    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Wallet est une application de gestion financière qui vous aide à catégoriser les opérations, à suivre les soldes de chaque compte et à générer des statistiques détaillées pour un budget plus intelligent.">

        <title>Wallet <?= isset($title) ? "- ".ucfirst($title) : "" ?></title>
        <link rel="icon" href="./public/img/wallet.png" type="image/png">

        <link rel="stylesheet" href="./public/css/style.css">
        
        <link rel="stylesheet" href="./public/fontawesome-free-6.5.0-web/css/min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <!-- Dynamically loaded CSS -->
        <?php
            // Define CSS files based on the current page content
            $pageStyles = [
                'aperçu' => './public/css/apercu.css',
                'statistique' => './public/css/statistique.css',
                'épargne' => './public/css/epargne.css',
                'reglages' => './public/css/reglages.css',
            ];
            // Get the current page title or content type
            $currentStyle = $pageStyles[$title] ?? null;
            // Load the specific stylesheet if defined
            if ($currentStyle) {
                echo "<link rel='stylesheet' href='{$currentStyle}'>";
            }
        ?>
    </head>
    <body>
        <div class="wrapper">
            <aside>
                <div class="aside-container">
                    <h1>Wallet</h1>
                    <nav>
                        <ul class="nav-list">
                            <h3>MENU</h3>
                            <a href="index.php"><li class="nav-list_item"><i class="fa-solid fa-chart-bar"></i>Aperçu</li></a>
                            <a href="statistique"><li class="nav-list_item"><i class="fa-solid fa-chart-pie"></i>Statistique</li></a>
                            <a href="epargne"><li class="nav-list_item"><i class="fa-solid fa-wallet"></i>Épargne</li></a>
                        </ul>
                        <ul class="service-list">
                            <h3>GÉNÉRAL</h3>
                            <a href="reglages"><li class="nav-list_item"><i class="fa-solid fa-gear"></i>Reglages</li></a>
                            <a href=""><li class="nav-list_item"><i class="fa-solid fa-moon"></i>Apparence</li></a>
                        </ul>
                    </nav>
                </div>
            </aside>
            <header>
                <div class="header-left">
                    <h2><?=ucfirst($title)?></h2>
                </div>
                <div class="header-right">
                    <a class="menu-btn news"><i class="fas fa-bell"></i></a>
                    <div class="separator"></div>
                    <a class="menu-btn logout"><i class="fas fa-door-open"></i></a>
                    <div class="separator"></div>
                    <div class="person">
                        <div class="photo"></div>
                        <span class="name"><?= $clientInfo['firstName'].' '.$clientInfo['lastName'] ?></span>
                        <span class="mail"><?= $clientInfo['email'] ?></span>
                    </div>
                </div>
            </header>
            <main>
                <?=$content?>
            </main>
        </div>
            
        <script src="./public/fontawesome-free-6.5.0-web/js/all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
        <script src="./public/js/base.js"></script>
        <!-- Dynamically loaded JS -->
        <?php
            // Define CSS files based on the current page content
            $pageScripts = [
                'aperçu' => './public/js/apercu.js',
                'statistique' => './public/js/statistique.js',
                'épargne' => './public/js/epargne.js',
                'reglages' => './public/js/reglages.js',
            ];
            // Get the current page title or content type
            $currentScript = $pageScripts[$title] ?? null;
            // Load the specific stylesheet if defined
            if ($currentScript) {
                echo "<script src='{$currentScript}'></script>";
            }
        ?>
    </body>
    </html>