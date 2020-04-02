<div id="profil-full">
    <div id="profil-info" class="container">
        <img src="<?= $args_content[0] ?>" />
        <p><?= $args_content[1] ?></p>
        <p><?= $args_content[2] ?></p>
        <p>Nous a rejoint le : <time datetime="<?= $args_content[3]->format('Y-m-d') ?>"><?= $args_content[3]->format('d m Y') ?></time></p>
    </div>
    <div id="profil-about" class="container">
        <p>À propos de vous : [Bientôt disponible]</p>
    </div>
</div>
