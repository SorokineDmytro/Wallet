<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="./public/fontawesome-free-6.5.0-web/css/all.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <aside>
            <h1>Wallet</h1>
            <nav>
                <ul class="nav-list">
                    <h3>MENU</h3>
                    <li class="nav-list_item"><a href=""><i class="fas fa-chart-bar"></i>Aperçu</a></li>
                    <li class="nav-list_item"><a href=""><i class="fas fa-chart-pie"></i>Statistique</a></li>
                    <li class="nav-list_item"><a href=""><i class="fas fa-wallet"></i>Épargne</a></li>
                </ul>
                <ul class="service-list">
                    <h3>GÉNÉRAL</h3>
                    <li class="nav-list_item"><a href=""><i class="fas fa-gear"></i>Reglages</a></li>
                    <li class="nav-list_item"><a href=""><i class="fas fa-moon"></i>Apparence</a></li>
                </ul>
            </nav>
            <a class="logout"><i class="fas fa-arrow-right-from-bracket"></i>Se déconnecter</a>
        </aside>
        <header>
            <div class="header-left">
                <h2>Aperçu</h2>
            </div>
            <div class="header-right">
                <div class="notification"><i class="fas fa-bell"></i></div>
                <div class="separator"></div>
                <div class="person">
                    <div class="photo"></div>
                    <span class="name">Dmytro Sorokine</span>
                    <span class="mail">sorokine.dimitri@gmail.com</span>
                </div>
            </div>
        </header>
        <main>
            <div class="main-conatainer">
                <div class="main-widgets">
                    <div class="block widget">
                        <h4 class="widget-title"><i class="fas fa-coins"></i>Gains</h4>
                        <div class="widget-middle">
                            <span class="widget-main-amount">2 500.00 €</span>
                            <div class="widget-circle red">
                                <span>-5.1%</span>
                            </div>
                        </div>
                        <span class="widget-secondary-amount"><span class="color-green">-100.00 €</span> par rapport au dernier mois</span>
                    </div>
                    <div class="block widget">
                        <h4 class="widget-title"><i class="fas fa-cart-shopping"></i>Dépences</h4>
                        <div class="widget-middle">
                            <span class="widget-main-amount">2 500.00 €</span>
                            <div class="widget-circle red">
                                <span>-5.1%</span>
                            </div>
                        </div>
                        <span class="widget-secondary-amount"><span class="color-green">-100.00 €</span> par rapport au dernier mois</span>
                    </div>
                    <div class="block widget">
                        <h4 class="widget-title"><i class="fas fa-piggy-bank"></i>Épargnes</h4>
                        <div class="widget-middle">
                            <span class="widget-main-amount">2 500.00 €</span>
                            <div class="widget-circle green">
                                <span>+5.1%</span>
                            </div>
                        </div>
                        <span class="widget-secondary-amount"><span class="color-red">-100.00 €</span> par rapport au dernier mois</span>
                    </div>
                    <div class="block widget">
                        <h4 class="widget-title"><i class="fas fa-money-bill-trend-up"></i>Investisements</h4>
                        <div class="widget-middle">
                            <span class="widget-main-amount">2 500.00 €</span>
                            <div class="widget-circle green">
                                <span>+5.1%</span>
                            </div>
                        </div>
                        <span class="widget-secondary-amount"><span class="color-red">-100.00 €</span> par rapport au dernier mois</span>
                    </div>
                </div>
                <div class="main-statistic">
                    <div class="block statistics"></div>
                    <div class="block accounts">
                        <div class="account">
                            <div class="account-img green"><i class="fas fa-credit-card"></i></div>
                            <button class="actions">...</button>
                            <h5 class="account-title">Général de Dmytro</h5>
                            <span class="account-amount">2000.00€</span>
                        </div>
                        <div class="account">
                            <div class="account-img red"><i class="fas fa-credit-card"></i></div>
                            <button class="actions">...</button>
                            <h5 class="account-title">Secondaire de Dmytro</h5>
                            <span class="account-amount">2000.00€</span>
                        </div>
                        <div class="account">
                            <div class="account-img blue"><i class="fas fa-piggy-bank"></i></div>
                            <button class="actions">...</button>
                            <h5 class="account-title">Épargne de Dmytro</h5>
                            <span class="account-amount">2000.00€</span>
                        </div>
                        <div class="account add-account">
                            <div class="blue"><i class="fas fa-plus"></i></div>
                            <span>Ajouter un compte</span>
                        </div>
                    </div>
                </div>
                <div class="main-operations">
                    <div class="block operations">
                        <div class="operations-title">
                            <h2>Liste d'operations</h2>
                        </div>
                        <ul class="operation-list">
                            <li class="operation-date">
                                <h3>23 OCTOBRE</h3>
                                <ul>
                                    <li class="operation-item">
                                    <input type="checkbox" name="choix" id="choix">
                                        <div class="operation-item_circle"><i class="fas fa-circle-question"></i></div>
                                        <span class="operation-item_categorie">Divers</span>
                                        <span class="operation-item_account">Général de Dmytro</span>
                                        <span class="operation-item_time">15:00</span>
                                        <span class="operation-item_amount">-150.00 €</span>
                                        <div class="buttons">
                                            <button class="btn-modify"><i class="fas fa-pencil"></i>Modifier</button>
                                            <button class="btn-delete"><i class="fas fa-trash"></i>Supprimer</button>
                                        </div>
                                    </li>
                                    <li class="operation-item">
                                        <input type="checkbox" name="choix" id="choix">
                                        <div class="operation-item_circle"><i class="fas fa-circle-question"></i></div>
                                        <span class="operation-item_categorie">Divers</span>
                                        <span class="operation-item_account">Général de Dmytro</span>
                                        <span class="operation-item_time">15:00</span>
                                        <span class="operation-item_amount">-150.00 €</span>
                                        <div class="buttons">
                                            <button class="btn-modify"><i class="fas fa-pencil"></i>Modifier</button>
                                            <button class="btn-delete"><i class="fas fa-trash"></i>Supprimer</button>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="operation-date">
                                <h3>24 OCTOBRE</h3>
                                <ul>
                                    <li class="operation-item">

                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
        
<script src="public/js/script.js"></script>
<script src="public/fontawesome-free-6.5.0-web/js/all.js"></script>
</body>
</html>