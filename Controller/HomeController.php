<?php
    namespace Controller;

    use App\Session;
    use Model\Managers\PostManager;
    use Model\Managers\ThreadManager;

    /**
     * Default controller.
     *
     * @method index() Invoke the index page. It shows every threads.
     * @method showThread() Show posts of one thread.
     * @method invoke404() Invoke the 404.php page, and die().
     */
    class HomeController{
        
        // ---- METHODS ----

        // -- AJAX
                
        // -- FULL VIEW

        /**
         * Invoke the index page.
         */
        public function index()
        {
            $tMan = new ThreadManager();
            $threads = $tMan->findAll();

            // Sort by date
            usort($threads, array("Model\\Entities\\Thread", "compare"));

            $pMan = new PostManager();
            
            $res = [];
            foreach($threads as $t){
                $posts = $pMan->findAllByThreadId($t->getId());
                usort($posts, array("Model\\Entities\\Post", "compare"));
                $res[] = [$t, $posts[0], count($posts)];
            }

            return [
                "view" => DEFAULT_TEMPLATE,
                "data" => array("title" => TAB_TITLE . "Accueil",
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
            if (!is_numeric($id)){
                self::invoke404();
            }

            $tMan = new ThreadManager();
            $thread = $tMan->findOneById($id);

            // If the requested thread does not exist, show the 404 page
            if ($thread === false)
                self::invoke404();
            
            $pMan = new PostManager();
            
            // If the form has been completed, add the new post to the database
            if (isset($_POST["newpost-body"])){
                if (!Session::isConnected())
                    self::invoke404();
                $pMan->add(["body" => str_replace("'", "''", $_POST["newpost-body"]),
                    "creation" => date("Y-m-d H:i:s"),
                    "lattest_edit" => date("Y-m-d H:i:s"),
                    "thread_id" => $id,
                    "client_id" => $_SESSION[Session::ID_SES]]);
                header("location: index.php?action=showThread&id=$id");
                die();
            }
            
            // Get all posts affected to the requested thread
            $posts = $pMan->findAllByThreadId($id);

            // Sort by date
            usort($posts, array("Model\\Entities\\Post", "compare"));

            return [
                "view" => DEFAULT_TEMPLATE,
                "data" => array("title" => TAB_TITLE . $thread->getTitle(),
                    "content" => "Threads" . DS . "oneThread.php",
                    "args" => [$thread, $posts],
                    "css" => CSS_LINK . "Threads" . DS . "oneThread.css\" />")
            ];
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