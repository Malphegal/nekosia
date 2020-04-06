<div class="container">
    <h2>Si vous êtes ici, c'est que vous êtes un admin !</h2>
    <p>Voici la liste des utilisateurs :</p>
    <?php foreach ($args_content as $c): ?>
        <div>
            <a href="<?= RELATIVE_DIR . "client" . DS . "profil" . DS . strtolower($c) ?>" target="_blank"><img src="<?= $c->getAvatar() ?>" /><?= $c->getNickname() ?></a>
        </div>
    <?php endforeach; ?>
</div>