<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet</title>
    <link rel="stylesheet" href="./public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="./public/fontawesome-free-6.5.0-web/css/all.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <aside>
            <div class="aside-container">
                <h1>Wallet</h1>
                <nav>
                    <ul class="nav-list">
                        <h3>MENU</h3>
                        <a href="index.php"><li class="nav-list_item"><i class="fas fa-chart-bar"></i>Aperçu</li></a>
                        <a href="statistique"><li class="nav-list_item"><i class="fas fa-chart-pie"></i>Statistique</li></a>
                        <a href="epargne"><li class="nav-list_item"><i class="fas fa-wallet"></i>Épargne</li></a>
                    </ul>
                    <ul class="service-list">
                        <h3>GÉNÉRAL</h3>
                        <a href="reglages"><li class="nav-list_item"><i class="fas fa-gear"></i>Reglages</li></a>
                        <a href=""><li class="nav-list_item"><i class="fas fa-moon"></i>Apparence</li></a>
                    </ul>
                </nav>
            </div>
        </aside>
        <header>
            <div class="header-left">
                <h2><?=ucfirst($title)?></h2>
            </div>
            <div class="header-right">
                <a class="menu-btn"><i class="fas fa-bell"></i></a>
                <div class="separator"></div>
                <a class="menu-btn"><i class="fas fa-door-open"></i></a>
                <div class="separator"></div>
                <div class="person">
                    <div class="photo"></div>
                    <span class="name">Dmytro Sorokine</span>
                    <span class="mail">sorokine.dimitri@gmail.com</span>
                </div>
            </div>
        </header>
        <main>
            <?=$content?>
        </main>
    </div>
        
<script src="./public/js/script.js"></script>
<script src="./public/fontawesome-free-6.5.0-web/js/all.js"></script>
</body>
</html>