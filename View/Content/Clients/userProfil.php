<div id="profil-full">
    <div id="profil-info" class="container">
        <img src="<?= $_SESSION[App\Session::AVATAR_SES] ?>" />
        <p><?= $_SESSION[App\Session::NICKNAME_SES] ?></p>
        <p><?= $_SESSION[App\Session::EMAIL_SES] ?></p>
        <p>Nous a rejoint le : <time datetime="<?= $_SESSION[App\Session::SIGNEDUP_SES]->format('Y-m-d') ?>"><?= $_SESSION[App\Session::SIGNEDUP_SES]->format('d m Y') ?></time></p>
    </div>
    <div id="profil-about" class="container">
        <p>À propos de vous :</p>
        <?php
            foreach ($_SESSION as $key => $value){
                echo "<p>$key : " . ($value instanceof DateTime ? $value->format('Y m d') : $value) . "</p>";
            }
        ?>
    </div>
</div>
