<div class="container">
    <h3><?= $args_content[0]->getTitle() ?></h3>
</div>
<div class="container post-content">
    <form method="post">
        <textarea name="editpost-body"><?= $args_content[1]->getBody(); ?></textarea>
        <?= App\Session::isCurrentAdmin() && !App\Session::isCurrentClient($args_content[1]->getClient()) ? "<p class=\"admin-tags\">Attention, ce n'est pas votre post !</p>" : "" ?>
        <input type="submit" value="Modifier" />
    </form>
    <hr />
    <div class="post-footer">
        <div class="post-signature">

        </div>
        <div class="flex-centered">
            <div class="post-client">
                <img src="<?= $args_content[1]->getClient()->getAvatar() ?>" class="avatar" />
                <div>
                    <p><time datetime="<?= $args_content[1]->getCreation()->format('Y-m-d') ?>"><?= $args_content[1]->getCreation()->format('d M Y à H:i:s') ?></time></p>
                    <p><?= $args_content[1]->getClient() ?></p>
                </div>
            </div>
        </div>
    </div>
</div>