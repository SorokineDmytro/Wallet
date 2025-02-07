    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Wallet est une application de gestion financière qui vous aide à catégoriser les opérations, à suivre les soldes de chaque compte et à générer des statistiques détaillées pour un budget plus intelligent.">

        <title>Wallet <?= isset($title) ? "- ".ucfirst($title) : "" ?></title>
        <link rel="icon" href="./public/img/wallet.png" type="image/png">

        <link rel="stylesheet" href="./public/css/wellcome.css">
        
        <link rel="stylesheet" href="./public/fontawesome-free-6.5.0-web/css/min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="wrapper">
            <aside>
                
            </aside>
            <main>
                <?=$content?>
            </main>
        </div>
        <script src="./public/js/wellcome.js"></script>
        <script src="./public/fontawesome-free-6.5.0-web/js/all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    </body>
    </html>