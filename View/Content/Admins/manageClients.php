<div class="container">
    <h2>Si vous êtes ici, c'est que vous êtes un admin !</h2>
    <p>Voici la liste des utilisateurs :</p>
    <div class="flex-33">
        <?php foreach ($args_content as $c): ?>
            <div>
                <img src="<?= $c->getAvatar() ?>" />
                <dl class="title-border">
                    <dt>Pseudo</dt>
                    <dd><?= $c->getNickname() ?></dd>
                    <dt>Email</dt>
                    <dd><?= $c->getEmail() ?></dd>
                    <dt>Date de création du compte</dt>
                    <dd><?= $c->getSignedup()->format("d/m/Y à H:i:s") ?></dd>
                    <dt>Avatar</dt>
                    <dd><?= $c->getAvatarEnd() ?></dd>
                    <dt>Grade</dt>
                    <dd><?= $c->getGrade() ?></dd>
                </dl>
            </div>
        <?php endforeach; ?>
    </div>
</div>