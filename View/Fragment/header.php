<?php $isConnected = App\Session::isConnected(); ?>
<header>
    <div id="headerimg">
        </div>
    <div id="subheader">
        <div>

        </div>
        <div class="flex-centered">
            <h1><a href="<?= RELATIVE_DIR ?>">Nekosia</a></h1>
        </div>
        <div id="header-client-profil">
            <label for="checkbox-header">
                <img id="useravatar" src="<?= $isConnected ? $_SESSION[App\Session::AVATAR_SES] : AVATAR_DIR . "default_avatar.png" ?>"/>
                <i class="fas fa-chevron-down" id="ii"></i>
            </label>
            <input id="checkbox-header" type="checkbox" />
            <ul class="container">
                <li><a href="<?= RELATIVE_DIR ?>index.php?ctrl=client&action=profil"><?= $isConnected ? "Profil" : "Se connecter" ?></a></li>
                <?= $isConnected ? "<li><a href=\"" . RELATIVE_DIR . "index.php?ctrl=client&action=logout\">Se déconnecter</a></li>" : "" ?>
            </ul>
        </div>
    </div>
</header>

