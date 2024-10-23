<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account = $_POST['account'];
    $date = $_POST['date'];
    $amount = $_POST['amount'];
    $type = $_POST['type'];
    $category = $_POST['category'];

    if (empty($account) || empty($date) || empty($amount) || empty($type) || empty($category)) {
        $_SESSION['error'] = 'Заполните поля наименования и стоимости!';
        header('Location: index.html.php'); // Redirect to the form
        exit;
    }

    getConnexion();
    saveProduct($account, $date, $amount, $type, $category);
    $_SESSION['success'] = 'Запись успешно добавлена!';
    header('Location: index.html.php');
            exit;
    }

function getConnexion($host = '127.0.0.1', $dbname = 'wallet', $user = 'postgres', $password = '160717') {
    $dsn = "pgsql:host=$host;dbname=$dbname;options='--client_encoding=UTF8'";
    try {
        $connection = new PDO($dsn, $user, $password);
        return $connection;
    } catch (Exception $e) {
        echo "An error occurred.\n";
        die;
    }
}


function getFromDB($tableName) {
    // Define a whitelist of allowed table names
    $allowedTables = ['type', 'categorie', 'souscategorie']; // can add more tables here in future requests from db

    // Check if the requested table name is in the whitelist
    if (!in_array($tableName, $allowedTables)) {
        throw new Exception("Invalid table name");
    }

    $connection = getConnexion();
    $sql = "SELECT * FROM $tableName;";
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertClient ($lastName, $firstName, $email, $password) { // Function to insert a client into DB Client with the password hashed by BCRYPT 
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $connection = getConnexion();
    $sql = "INSERT INTO client (nomClient, prenomClient, email, mot_de_passe) VALUES (?, ?, ?, ?);";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$lastName, $firstName, $email, $hashedPassword]);
}

function saveProduct($account, $date, $amount, $type, $category) {
    $connection = getConnexion();
    $sql = "INSERT INTO operation (account, date_time, amount, type, category) VALUES (?, ?, ?, ?, ?);";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$account, $date, $amount, $type, $category]);
}

function getOperations() {
    $connection = getConnexion();
    $sql = 'SELECT * FROM operation';
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTotalAmount($operations) {
    $totalAmount = 0;
    foreach ($operations as $operation) {
        $operation['type'] == 'income' ? $totalAmount += $operation['amount'] : $totalAmount -= $operation['amount']; 
        }
    return $totalAmount;
}

function getUniqueDates($connection) {
    $sql = "SELECT DISTINCT DATE(date_time) as operation_date FROM operation ORDER BY operation_date";
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function getOperationsByDate($connection, $date) {
    $sql = "SELECT * FROM operation WHERE DATE(date_time) = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$date]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function printr($array) {
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}