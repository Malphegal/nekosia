<?php
    namespace Controller;

    use App\Session;
    use Model\Managers\PostManager;
    use Model\Managers\SignManager;
    use Model\Managers\ThemeManager;
    use Model\Managers\ThreadManager;

    /**
     * Default controller.
     *
     * @method index() Invoke the index page. It shows every threads.
     * @method showThread() Show posts of one thread.
     * @method editPost() Allow to edit a Post.
     * @method newThread() Allow to create a new Thread.
     * @method lockThread() Allow to lock/unlock a thread.
     * @method about() Show the forum details.
     * @method subscribe() Allow a Client to subscribe to a Thread.
     * @method invoke404() Invoke the 404.php page, and die().
     */
    class HomeController{
        
        // ---- METHODS ----

        /**
         * Invoke the index page.
         */
        public function index()
        {
            $tMan = new ThreadManager();
            $threads = $tMan->findAll();

            $res = null;

            // Only do operations if there is at least 1 Thread
            if ($threads != null)
            {
                // Sort by date
                usort($threads, array("Model\\Entities\\Thread", "compare"));
    
                $pMan = new PostManager();
                $sMan = new SignManager();
                $res = [];
                foreach($threads as $t)
                {
                    $posts = $pMan->findAllByThreadId($t->getId());
                    usort($posts, array("Model\\Entities\\Post", "compare"));

                    // Manage the newPosts logo, only if connected
                    $newThread = false;
                    $sub = false;
                    if (Session::isConnected())
                    {
                        $sign = $sMan->findOneByIds($t->getId(), $_SESSION[Session::ID_SES]);
                        if ($sign)
                        {
                            $newThread = $pMan->isOneAfterDate($posts, $sign->getLatestVisit());
                            $sub = true;
                        }
                    }
                    $res[] = [$t, $posts[0], count($posts), $newThread, $sub];
                }
            }

            return [
                "view" => DEFAULT_TEMPLATE,
                "data" => array("title" => "Accueil",
                    "content" => "Threads" . DS . "allThreads.php",
                    "args" => $res,
                    "css" => CSS_LINK . "Threads" . DS . "allThreads.css\" />")
            ];
        }
        
        /**
         * Show posts of one thread.
         *
         * @param int $id The thread id.
         */
        public function showThread($id)
        {
            if (!is_numeric($id))
                self::invoke404();

            $tMan = new ThreadManager();
            $thread = $tMan->findOneById($id);

            // If the requested thread does not exist, show the 404 page
            if (!$thread)
                self::invoke404();
            
            $pMan = new PostManager();
            
            // If the form has been completed, add the new post to the database
            if (isset($_POST["newpost-body"])){
                if (!Session::isConnected() || $thread->getLocked())
                    self::invoke404();
                $pMan->add(["body" => str_replace("'", "''", $_POST["newpost-body"]),
                    "creation" => date("Y-m-d H:i:s"),
                    "lattest_edit" => date("Y-m-d H:i:s"),
                    "thread_id" => $id,
                    "client_id" => $_SESSION[Session::ID_SES]]);
                header("location: " . RELATIVE_DIR . "home" . DS . "showThread" . DS . $id);
                die();
            }
            
            // Get all posts affected to the requested thread
            $posts = $pMan->findAllByThreadId($id);

            // Sort by date
            usort($posts, array("Model\\Entities\\Post", "compare"));

            $sub = false;

            // Manager the Sign table, only if connected
            if (Session::isConnected())
            {
                $sMan = new SignManager();
                $sign = $sMan->findOneByIds($thread->getId(), $_SESSION[Session::ID_SES]);
                if ($sign)
                {
                    $sMan->update([$thread->getId(), $_SESSION[Session::ID_SES]], date("Y-m-d H:i:s"));
                    $sub = true;
                }
            }

            // Increase view counter
            $tMan->update($id, ["view" => $thread->getView() + 1]);

            return [
                "view" => DEFAULT_TEMPLATE,
                "data" => array("title" => $thread->getTitle(),
                    "content" => "Threads" . DS . "oneThread.php",
                    "args" => [$thread, $posts, $sub],
                    "css" => CSS_LINK . "Threads" . DS . "oneThread.css\" />")
            ];
        }
        
        /**
         * Allow to edit a Post.
         *
         * @param int $id The Post id.
         */
        public function editPost($id)
        {
            if (!Session::isConnected())
                self::invoke404();

            $pMan = new PostManager();
            $post = $pMan->findOneById($id);

            $isAdmin = false;

            // Is the current logged in Client is admin
            if (Session::isCurrentAdmin())
                $isAdmin = true;
            // If the requested post does not exist or the post isn't affected to the current logged in Client
            if ($post != null)
            {
                if (($post->getClient()->getId() != $_SESSION[Session::ID_SES]) && !$isAdmin)
                    self::invoke404();
            }
            else
                self::invoke404();
                
            $thread = $post->getThread();
                
            // Check if an edit has been made
            if (isset($_POST["editpost-body"]))
            {
                $body = $_POST["editpost-body"];
                
                // If the Post's Client is not the current connected, or the body is empty, invoke 404.php
                if (empty($body))
                    self::invoke404();

                // Update in the database
                if ($pMan->update($post->getId(), ["body" => str_replace("'", "''", $body), "lattest_edit" => date("Y-m-d H:i:s")]))
                {
                    header("Location: " . RELATIVE_DIR . "home" . DS . "showThread" . DS . $thread->getId());
                    die();
                }
                else
                    self::invoke404();
            }
                        
            return [
                "view" => DEFAULT_TEMPLATE,
                "data" => array("title" => $thread->getTitle() . " - " . "Modifier un poste",
                    "content" => "Threads" . DS . "editPost.php",
                    "args" => [$thread, $post],
                    "css" => CSS_LINK . "Threads" . DS . "oneThread.css\" />")
            ];
        }
        
        /**
         * Allow to create a new Thread.
         */
        public function newThread()
        {
            if (!Session::isConnected())
                self::invoke404();

            if (isset($_POST["newthread-theme"]) && !empty($_POST["newthread-theme"])
                && isset($_POST["newthread-title"]) && !empty($_POST["newthread-title"])
                && isset($_POST["newthread-post"]) && !empty($_POST["newthread-post"]))
            {
                $themeMan = new ThemeManager();
                $exist = $themeMan->findOneById($_POST["newthread-theme"]);
                if (!$exist)
                    self::invoke404();

                // Add Thread
                $tMan = new ThreadManager();
                $threadId = $tMan->add(["title" => str_replace("'", "''", $_POST["newthread-title"]),
                    "creation" => date("Y-m-d H:i:s"),
                    "locked" => 0,
                    "lattest_edit" => date("Y-m-d H:i:s"),
                    "view" => 0,
                    "theme_id" => $_POST["newthread-theme"],
                    "client_id" => $_SESSION[Session::ID_SES]]);
                
                // Add Post to the Thread
                $pMan = new PostManager();
                $pMan->add(["body" => str_replace("'", "''", $_POST["newthread-post"]),
                    "creation" => date("Y-m-d H:i:s"),
                    "lattest_edit" => date("Y-m-d H:i:s"),
                    "thread_id" => $threadId,
                    "client_id" => $_SESSION[Session::ID_SES]]);
                
                header("Location: " . RELATIVE_DIR . "home" . DS . "showThread" . DS . $threadId);
                die();
            }

            // Find all themes
            $themeMan = new ThemeManager();
            $themes = $themeMan->findAll();

            $args = [];
            foreach ($themes as $t)
                $args[$t->getId()] = $t->getName();

            // Sort by name
            usort($themes, array("Model\\Entities\\Theme", "compare"));

            return [
                "view" => DEFAULT_TEMPLATE,
                "data" => array("title" => "Une envie de discuter !",
                    "content" => "Threads" . DS . "newThread.php",
                    "args" => $args,
                    "css" => "")
            ];
        }
        
        /**
         * Allow to lock/unlock a thread.
         *
         * @param int $id The thread id.
         */
        public function lockThread($id)
        {
            $tMan = new ThreadManager();
            $thread = $tMan->findOneById($id);

            if (!Session::isConnected() || $thread->getClient()->getId() != $_SESSION[Session::ID_SES] && !Session::isCurrentAdmin())
                self::invoke404();

            $newValue = $thread->getLocked() ? 0 : 1;
            $tMan->update($thread->getId(), ["locked" => $newValue]);
            header("Location: " . RELATIVE_DIR . "home" . DS . "showThread" . DS . $id);
        }
                
        /**
         * Show the forum details.
         */
        public function about()
        {
            return [
                "view" => DEFAULT_TEMPLATE,
                "data" => array("title" => "À propos",
                    "content" => "About" . DS . "about.php",
                    "args" => null,
                    "css" => "")
            ];
        }
        
        /**
         * Allow a Client to subscribe to a Thread.
         *
         * @param int $threadId The Thread id.
         */
        public function subscribe($threadId)
        {
            if (!Session::isConnected())
                self::invoke404();

            $clientId = $_SESSION[Session::ID_SES];

            $sMan = new SignManager();
            $exist = $sMan->findOneByIds($threadId, $clientId);

            // Add if it does not exist, otherwise create it
            if ($exist)
                $sMan->delete($threadId, $clientId);
            else
                $sMan->add(["thread_id" => $threadId,
                    "client_id" => $clientId,
                    "latest_visit" => date("Y-m-d H:i:s")]);

            header("Location: " . RELATIVE_DIR . "home" . DS . "showThread" . DS . $threadId);
            die();
        }

        /**
         * Invoke the 404.php page, and die().
         */
        public static function invoke404()
        {
            require(VIEW_DIR . "404.php");
            die();
        }
    }