<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="icon" type="image/png" href="Public/Img/Header/default_avatar.png" />

        <title><?= TAB_TITLE . $data["title"] ?></title>

        <link rel="stylesheet" type="text/css" href="<?= CSS_DIR ?>style.css" />
        <?= $data["css"] ?> <!-- <- Additional content css, optional -->
        <link rel="stylesheet" type="text/css" href="<?= CSS_DIR_FRAG ?>header.css" />

        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
            integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ="
            crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous">
        </script>
    </head>
    <body>
        <main>
            <div id="wrapper">
                <?php echo $page_header; ?>
                <div id="content">
                    <?php echo $page_content; ?>
                </div>
                <div id="right">
                    <?php ?>
                </div>
            </div>
        </main>
        <?php ?>
        <!-- <script src="js/nav.js"></script> -->
    </body>
</html>