<?php $isConnected = App\Session::isConnected(); ?>

<div class="container back-topics">
    <a href="<?= RELATIVE_DIR ?>">Retour à la listes des topics</a>
</div>

<div class="container thread-title">
    <div>
        <?= $args_content[0]->getLocked() ? "<img src=\"" . IMG_DIR . "Thread" . DS . "threadLock.png\" class=\"img-64\" />" : "" ?>
        <h3 class="title-border inline-blocked"><?= "<span class=\"smaller-span\">" . $args_content[0]->getTheme() . " - </span>" . $args_content[0]->getTitle() ?></h3>
    </div>
    <div>
        <p>Créé le <time datetime="<?= $args_content[0]->getCreation()->format('Y-m-d') ?>"><?= $args_content[0]->getCreation()->format('d M Y') ?></time></p>
        <?= App\Session::isCurrentClient($args_content[0]->getClient()) ?
            "<a href=\"" . RELATIVE_DIR . "home" . DS . "lockThread" . DS . $args_content[0]->getId() . "\" class=\"all-tags\">" . ($args_content[0]->getLocked() ? "Dév" : "V") . "errouiller</a>"
            : (App\Session::isCurrentAdmin() ?
                "<a href=\"" . RELATIVE_DIR . "home" . DS . "lockThread" . DS . $args_content[0]->getId() . "\" class=\"admin-tags\">" . ($args_content[0]->getLocked() ? "Dév" : "V") . "errouiller</a>"
                : "") ?>
        <?= $isConnected ? "<a href=\"" . RELATIVE_DIR . "home" . DS . "subscribe" . DS . $args_content[0]->getId() . "\" class=\"all-tags\">" . ($args_content[2] ? "Se désinscrire" : "S'inscrire") . "</a>" : "" ?>
    </div>
</div>

<?php foreach ($args_content[1] as $p): ?>
    <div class="container post-content">
        <div>
            <p><?= App\Utils::newline_to_newp($p->getBody()) ?></p>
        </div>
        <hr />
        <div class="post-footer">
            <div class="post-signature">
                <p><?= App\Utils::newline_to_newp($p->getClient()->getSignature()) ?></p>
            </div>
            <div class="flex-centered">
                <?php
                    if (App\Session::isConnected() && App\Session::isCurrentClient($p->getClient()))
                        echo "<a href=\"" . RELATIVE_DIR . "home" . DS . "editPost" . DS . $p->getId() . "\" class=\"all-tags\">Editer</a>";
                    else if (App\Session::isCurrentAdmin())
                        echo "<a href=\"" . RELATIVE_DIR . "home" . DS . "editPost" . DS . $p->getId() . "\" class=\"admin-tags\">Editer</a>";
                ?>
                <div class="post-client">
                <a href="<?= RELATIVE_DIR . "client" . DS . "profil" . DS . strtolower($p->getClient()) ?>"><img src="<?= $p->getClient()->getAvatar() ?>" class="avatar" /></a>
                    <div>
                        <p><time datetime="<?= $p->getCreation()->format('Y-m-d') ?>"><?= $p->getCreation()->format('d M Y à H:i:s') ?></time></p>
                        <a href="<?= RELATIVE_DIR . "client" . DS . "profil" . DS . strtolower($p->getClient()) ?>" <?= $p->getClient()->getIsBanned() ? "class=\"banned\"" : "" ?>><?= $p->getClient() ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php if (!$args_content[0]->getLocked() && $isConnected): ?>
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