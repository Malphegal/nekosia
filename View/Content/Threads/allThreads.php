<div id="allthreads-infos" class="container flex-centered-row">
    <div id="new-topic">
        <?php if (App\Session::isConnected()): ?>
            <label>Envie de discuter ? Créé un nouveau topic !</label>
            <a href="<?= RELATIVE_DIR ?>home/newThread">Go</a>
        <?php endif; ?>
    </div>
    <div>

    </div>
</div>
<?php if ($args_content != null) foreach ($args_content as $key => $value){ ?>
    <div class="container inline-thread">
        <div class="thread-img-container">
            <img src="<?= $value[0]->getClient()->getAvatar() ?>" />
            <p><?= $value[0]->getClient() ?></p>
        </div>
        <div class="thread-title-container">
            <h3><a href="<?= RELATIVE_DIR ?>home/showThread/<?= $value[0]->getId() ?>"><?= $value[0]->getTitle() ?></a></h3>
            <p><?= App\Utils::newline_to_newp($value[1]->getBody()) ?></p>
        </div>
        <div class="thread-view-container">
        <p><time datetime="<?= $value[0]->getCreation()->format('Y-m-d') ?>"><?= $value[0]->getCreation()->format('d M Y') ?></time></p>
            <p><?= $value[2] ?> poste<?= $value[2] > 1 ? "s" : "" ?></p>
            <p>(0 vue)</p>
        </div>
    </div>
<?php } else { ?>
    <div class="container">
        <p>Il n'y a aucun topic ! Allons créer un topic ensemble !</p>
    </div>
<?php } ?>