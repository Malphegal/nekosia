<?php $isConnected = App\Session::isConnected(); ?>
<header>
    <div id="headerimg">
        </div>
    <div id="subheader">
        <div class="flex-centered">
            <?php if (App\Session::isCurrentAdmin()): ?>
                <a href="<?= RELATIVE_DIR . "admin" . DS . "manageClients"?>" class="admin-tags">Gérer les clients</a>
            <?php endif; ?>
        </div>
        <div class="flex-centered">
            <h1><a href="<?= RELATIVE_DIR ?>">Nekosia</a></h1>
        </div>
        <div id="header-client-profil">
            <?php if ($isConnected): ?>
                <p><?= $_SESSION[App\Session::NICKNAME_SES] ?></p>
            <?php endif; ?>
            <label for="checkbox-header">
                <img id="useravatar" src="<?= $isConnected ? $_SESSION[App\Session::AVATAR_SES] : AVATAR_DIR . "default_avatar.png" ?>" class="avatar" />
                <i class="fas fa-chevron-down" id="ii"></i>
            </label>
            <input id="checkbox-header" type="checkbox" />
            <ul class="container">
                <li><a href="<?= RELATIVE_DIR . "client" . DS . "profil" ?>"><?= $isConnected ? "Profil" : "Se connecter" ?></a></li>
                <?= $isConnected ? "<li><a href=\"" . RELATIVE_DIR . "client" . DS . "logout\">Se déconnecter</a></li>" : "" ?>
            </ul>
        </div>
    </div>
</header>

