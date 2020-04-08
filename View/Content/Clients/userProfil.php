<?php $isCurrent = App\Session::isCurrentClient($args_content); ?>
<div id="profil-full">
    <div id="profil-info" class="container">
        <img src="<?= $args_content->getAvatar() ?>" />
        <p><?= $args_content ?></p>
        <p><?= $args_content->getEmail() ?></p>
        <p>Nous a rejoint le : <time datetime="<?= $args_content->getSignedup()->format('Y-m-d') ?>"><?= $args_content->getSignedup()->format('d m Y') ?></time></p>
        <?php if (App\Session::isCurrentAdmin()): ?>
            <a href="<?= RELATIVE_DIR . "admin" . DS . "ban" . DS . $args_content ?>" class="admin-tags"><?= $args_content->getIsBanned() ? "Grâcier" : "Bannir" ?></a>
        <?php endif; ?>
    </div>
    <div id="profil-about" class="container">
        <div>
            <h3>À propos de <?= $args_content ?></h3>
            <?php if ($isCurrent){ ?>
                <form method="post">
                    <textarea name="update-about"><?= $args_content->getAbout() ?></textarea>
                    <input type="submit" name="" value="Mettre à jour" />
                </form>
            <?php } else { ?>
                <?= strlen($args_content->getAbout()) == 0 ? "<p class=\"undefined\">Cette utilisateur préfère rester dans l'ombre.</p>" : "<p>" . $args_content->getAbout() . "</p>" ?>
            <?php } ?>
        </div>
        <hr />
        <div>
            <h3><?= $isCurrent ? "Votre signature" : "Signature de $args_content" ?></h3>
            <?php if ($isCurrent){ ?>
                <form method="post">
                    <textarea name="update-signature"><?= $args_content->getSignature() ?></textarea>
                    <input type="submit" name="" value="Mettre à jour" />
                </form>
            <?php } else { ?>
                <p><?= $args_content->getSignature() ?></p>
            <?php } ?>
        </div>
    </div>
</div>
