<?php $count = 0; ?>
<?php foreach ($args_content as $key => $value): ?>
    <div class="container inline-thread">
        <div class="thread-img-container">
            <img src="<?= $value[0]->getClient()->getAvatar() ?>" />
            <p><?= $value[0]->getClient() ?></p>
        </div>
        <div class="thread-title-container">
            <h3><a href="<?= RELATIVE_DIR ?>index.php?action=showThread&id=<?= $value[0]->getId() ?>"><?= $value[0]->getTitle() ?></a></h3>
            <p><?= App\Utils::newline_to_newp($value[1]->getBody()) ?></p>
        </div>
        <div class="thread-view-container">
        <p><time datetime="<?= $value[0]->getCreation()->format('Y-m-d') ?>"><?= $value[0]->getCreation()->format('d M Y') ?></time></p>
            <p><?= $value[2] ?> poste<?= $value[2] > 1 ? "s" : "" ?></p>
            <p>(0 vue)</p>
        </div>
    </div>
<?php $count++; endforeach; ?>