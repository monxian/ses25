<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="<?= BASE_URL ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/trongate.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/trongate-datetime.css">
    <link rel="stylesheet" href="<?= THEME_DIR ?>css/admin-theme.css">
    <?= $additional_includes_top ?>
    <title>Admin</title>
</head>

<body>
    <header>
        <nav class="hide-sm">
            <div class="tg-flex">
                <div class="tg-flex">
                    <img src="imgs/ses-logo.svg" alt="" class="pr4">
                    <div>
                        <a href="<?= BASE_URL ?>">
                            <h3>SesPortal Database</h3>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <div id="hamburger" class="hide-lg" onclick="openSlideNav()">&#9776;</div>
        <div>
            <?= anchor('trongate_administrators/manage', '<i class="fa fa-gears"></i>') ?>
            <?= anchor('trongate_administrators/account', '<i class="fa fa-user"></i>') ?>
            <?= anchor('trongate_administrators/logout', '<i class="fa fa-sign-out"></i>') ?>
        </div>
    </header>
    <div class="wrapper">
        <div id="sidebar">
            <h3>Menu</h3>
            <nav id="left-nav">
                <?= Template::partial('partials/admin/dynamic_nav') ?>
            </nav>
        </div>
        <div>
            <main>
                <?= Template::display($data) ?>
            </main>
        </div>
    </div>
    <div id="slide-nav">
        <div id="close-btn" onclick="closeSlideNav()">&times;</div>
        <ul auto-populate="true"></ul>
    </div>
    <script src="js/admin.js"></script>
    <script src="js/trongate-datetime.js"></script>
    <?= $additional_includes_btm ?>
</body>

</html>