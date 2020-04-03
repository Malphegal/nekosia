<div class="container back-topics">
    <a href="<?= RELATIVE_DIR ?>">Retour à la listes des topics</a>
</div>

<div class="container thread-title">
    <h3 class="title-border"><?= "<span class=\"smaller-span\">" . $args_content[0]->getTheme() . " - </span>" . $args_content[0]->getTitle() ?></h3>
    <p>Créé le <time datetime="<?= $args_content[0]->getCreation()->format('Y-m-d') ?>"><?= $args_content[0]->getCreation()->format('d M Y') ?></time></p>
</div>

<?php foreach ($args_content[1] as $p): ?>
    <div class="container post-content">
        <div>
            <p><?= App\Utils::newline_to_newp($p->getBody()) ?></p>
        </div>
        <hr />
        <div class="post-footer">
            <div class="post-signature">

            </div>
            <div class="flex-centered">
                <?php if(App\Session::isConnected() && $p->getClient()->getNickname() == $_SESSION[App\Session::NICKNAME_SES]) echo "<a href=\"" . RELATIVE_DIR . "home/editPost/" . $p->getId() . "\" class=\"all-tags\">Editer</a>"; ?>
                <div class="post-client">
                    <img src="<?= $p->getClient()->getAvatar() ?>" />
                    <div>
                        <p><time datetime="<?= $p->getCreation()->format('Y-m-d') ?>"><?= $p->getCreation()->format('d M Y à H:i:s') ?></time></p>
                        <p><?= $p->getClient() ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php if (App\Session::isConnected()): ?>
    <div class="container">
        <form method="post">
            <label>Écrire un message : </label>
            <textarea name="newpost-body" id="newpost-body" cols="80" rows="5"></textarea>
            <input type="submit" value="Poster" />
        </form>
    </div>
<?php endif; ?>

<div class="container back-topics">
    <a href="<?= RELATIVE_DIR ?>">Retour à la listes des topics</a>
</div>