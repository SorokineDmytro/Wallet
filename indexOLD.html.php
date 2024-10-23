<?php require_once "process.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet</title>
    <link rel="stylesheet" href="./public/css/style.css">
    <link rel="stylesheet" href="./public/fontawesome-free-6.5.0-web/css/all.css">

</head>
<body>
<?php if (isset($_SESSION['error'])): ?>
    <div id="errorMessage" class="w-[600px] mx-auto p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
    <script>
        // Hide the message after 3 seconds (3000 milliseconds)
        setTimeout(function() {
            let errorMessage = document.getElementById('errorMessage');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 3000); // 3000 ms = 3 seconds
    </script>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div id="successMessage" class="w-[600px] mx-auto p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
    <script>
        // Hide the message after 3 seconds (3000 milliseconds)
        setTimeout(function() {
            let successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 3000); // 3000 ms = 3 seconds
    </script>
<?php endif; ?>

<div class="wrapper">
    <div class="container">
        <form method="post" action="process.php" id="form">
            <label for="account">Compte</label>
            <select name="compte" id="account">
                <option value="Principal">Principal</option>
            </select>

            <label for="date">Date et l'heure</label>
            <input type="datetime-local" name="date" id="date">

            <label for="amount">Montant</label>
            <input type="number" step="0.01" name="montant" id="amount"> 
            
            <label for="type">Type d'opération</label>
            <select name="type" id="type">
                <?php foreach(getFromDB('type') as $type) : ?>
                    <option value="<?=$type['id']?>"><?=$type['description']?></option>
                <?php endforeach?>
            </select>

            <label for="category">Catégorie</label>
            <select name="categorie" id="category">
                <?php foreach(getFromDB('categorie') as $categorie) : ?>
                    <option value="<?=$categorie['id']?>"><?=$categorie['description']?></option>
                <?php endforeach?>
            </select>
            
            <label for="souscategorie">Sous-Catégorie</label>
            <select name="souscategorie" id="souscategorie">
                <?php foreach(getFromDB('souscategorie') as $souscategorie) : ?>
                    <option value="<?=$souscategorie['id']?>"><?=$souscategorie['description']?></option>
                <?php endforeach?>
            </select>

            <button type="submit" id="save-btn">Enregistrer</button>
            <button type="reset" id="reset-btn">Effacer</button>
        </form>
    </div>

    <?php
        $operations = getOperations();

        $totalAmount = getTotalAmount($operations);
    ?>

    <div class="container-output">
        <h2 class="totalAmount"><?= number_format($totalAmount, 2, ".", " ") ?> €</h2>

        <?php
        function displayOperationsByDate($connection) {
            $uniqueDates = getUniqueDates($connection);

            foreach ($uniqueDates as $date) {
                $operations = getOperationsByDate($connection, $date);
        ?>
                <h4 class="date"><?= date('d-m-Y', strtotime($date)) ?></h4>
                <ul>
                    <?php if (count($operations) > 0): ?>
                        <?php foreach ($operations as $operation): ?>
                            <li>
                                <div class="text-center"><?= $operation['account'] ?></div>
                                <div class="text-center"><?= $operation['category'] ?></div>
                                <div class="text-right <?=($operation['type'] == "income") ? "green" : "red" ?>">
                                    <?=($operation['type'] == "income") ? "+ ".number_format($operation['amount'], 2, '.', ' ') : " - ".number_format($operation['amount'], 2, '.', ' ') ?> €
                                </div>
                                <div class="text-center">
                                    <?php 
                                    $dateTime = date_create($operation['date_time']);
                                    echo date_format($dateTime, "H:i");
                                    ?>
                                </div>
                                <div>
                                    <button class="action-btn"><i class="fas fa-pen"></i></button>
                                    <button class="action-btn"><i class="fas fa-trash"></i></button>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
        <?php
            }
        }
        displayOperationsByDate(getConnexion());
        ?>
    </div>
</div>

</body>
</html>