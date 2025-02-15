<!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?= BASE_URL ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= WEBSITE_NAME ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/ses.css">
</head>

<body>
    <div class="page-wrap">
        <aside id="mobile-nav" class="print-hide">
            <div class="header">
                <div class="header-content flex align-center justify-between flex-1">
                    <div class="flex align-center p8 ">
                        <img src="imgs/ses-logo.svg" alt="" class="pr4">
                        <h2 class="text-white"><?= WEBSITE_NAME ?></h2>
                    </div>
                    <div id="close-menu" class="pr8">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                            <path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15.75 15l-6-6m0 6l6-6m7 3c0-5.523-4.477-10-10-10s-10 4.477-10 10s4.477 10 10 10s10-4.477 10-10" color="white" />
                        </svg>
                    </div>

                </div>
            </div>
            <div class="side-nav-container">
                <ul class="side-nav">

                    <?php switch ($member_obj->user_level_id) {
                        case 4:
                            echo Template::partial('partials/navs/lead_tech', $data);
                            break;
                        case 5:
                            echo Template::partial('partials/navs/office', $data);
                            break;
                        case 6:
                            echo Template::partial('partials/navs/admin', $data);
                            break;
                        default:
                            echo Template::partial('partials/navs/techs', $data);
                    }
                    ?>
                    <li class="mt16"><a href="members/logout">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 3.095A10 10 0 0 0 12.6 3C7.298 3 3 7.03 3 12s4.298 9 9.6 9q.714 0 1.4-.095M21 12H11m10 0c0-.7-1.994-2.008-2.5-2.5M21 12c0 .7-1.994 2.008-2.5 2.5" color="currentColor" />
                            </svg>Sign Out</a>
                    </li>
                    <li class="mt4"><a href="sup_numbers">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                    <path d="M17 10.805c0-.346 0-.519.052-.673c.151-.448.55-.621.95-.803c.448-.205.672-.307.895-.325c.252-.02.505.034.721.155c.286.16.486.466.69.714c.943 1.146 1.415 1.719 1.587 2.35c.14.51.14 1.044 0 1.553c-.251.922-1.046 1.694-1.635 2.41c-.301.365-.452.548-.642.655a1.27 1.27 0 0 1-.721.155c-.223-.018-.447-.12-.896-.325c-.4-.182-.798-.355-.949-.803c-.052-.154-.052-.327-.052-.673zm-10 0c0-.436-.012-.827-.364-1.133c-.128-.111-.298-.188-.637-.343c-.449-.204-.673-.307-.896-.325c-.667-.054-1.026.402-1.41.87c-.944 1.145-1.416 1.718-1.589 2.35a2.94 2.94 0 0 0 0 1.553c.252.921 1.048 1.694 1.636 2.409c.371.45.726.861 1.363.81c.223-.018.447-.12.896-.325c.34-.154.509-.232.637-.343c.352-.306.364-.697.364-1.132z" />
                                    <path d="M5 9c0-3.314 3.134-6 7-6s7 2.686 7 6m0 8v.8c0 1.767-1.79 3.2-4 3.2h-2" />
                                </g>
                            </svg>Support Numbers</a>
                    </li>

                </ul>

            </div>
        </aside>
        <main>
            <div class="header-mobile print-hide">
                <div class="flex align-center justify-between flex-1">
                    <div class="flex align-center p8 ">
                        <img src="imgs/ses-logo.svg" alt="" class="pr4">
                        <h2 class="text-white">SesPortal</h2>
                    </div>
                    <div class="p8" id="open-menu">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                            <path fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5h16M4 12h16M4 19h16" color="#fff" />
                        </svg>
                    </div>
                </div>
            </div>
            <?= Template::display($data); ?>
        </main>
    </div>
    <script src="js/trongate-mx.js"></script>
    <script>
        const openMenu = document.getElementById('open-menu');
        const menu = document.getElementById('mobile-nav');
        const closeMenu = document.getElementById('close-menu');

        openMenu.addEventListener("click", () => {
            menu.style.transform = 'translateX(1000px)';
        })
        closeMenu.addEventListener("click", () => {
            menu.style.transform = 'translateX(-1000px)';
        })
    </script>
</body>

</html>