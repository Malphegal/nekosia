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
        <p>À propos de vous : [Bientôt disponible]</p>
    </div>
</div>
