<div id="allthreads-infos" class="container flex-centered-row">
    <div id="new-topic">
        <?php if (App\Session::isConnected()): ?>
            <label>Envie de discuter ? Créé un nouveau topic !</label>
            <a href="<?= RELATIVE_DIR . "home" . DS . "newThread" ?>">Go</a>
        <?php endif; ?>
    </div>
    <div>

    </div>
</div>
<?php if ($args_content != null) foreach ($args_content as $key => $value){ ?>
    <div class="container inline-thread">
        <div class="flex-centered border-right-80 is-locked">
            <?= $value[0]->getLocked() ? "<img src=\"" . IMG_DIR . "Thread" . DS . "threadLock.png\" />" : "" ?>
        </div>
        <div class="thread-img-container flex-centered border-right-80">
            <img src="<?= $value[0]->getClient()->getAvatar() ?>" />
            <p><?= $value[0]->getClient() ?></p>
        </div>
        <div class="thread-title-container">
            <h3 class="title-border"><a href="<?= RELATIVE_DIR . "home" . DS . "showThread" . DS . $value[0]->getId() ?>"><?= "<span class=\"smaller-span\">" . $value[0]->getTheme() . " - </span>" . $value[0]->getTitle() ?></a></h3>
            <p><?= App\Utils::newline_to_newp($value[1]->getBody()) ?></p>
        </div>
        <div class="thread-view-container border-left-80">
        <p><time datetime="<?= setLocale(LC_TIME, 'fr_FR'); $value[0]->getCreation()->format('Y-m-d') ?>"><?= $value[0]->getCreation()->format('d M Y') ?></time></p>
            <p><?= $value[2] ?> poste<?= $value[2] > 1 ? "s" : "" ?></p>
            <p>(0 vue)</p>
        </div>
    </div>
<?php } else { ?>
    <div class="container">
        <p>Il n'y a aucun topic ! Allons créer un topic ensemble !</p>
    </div>
<?php } ?>