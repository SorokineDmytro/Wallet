<?php
    namespace App\Controller;
    use App\Model\Manager;
    use App\Model\EntityManager;
    use DateTime;

    class StatistiqueController extends Manager {
        public function __construct() 
        {
            $compteManager = new EntityManager('compte', 'Compte');
            $operationManager = new EntityManager('operation', 'Operation');
            $categorieManager = new EntityManager('categorie', 'Categorie');
            $clientId = 1; // Temporary; replace with dynamic user session ID when available
            $file = "view/statistique/statistique.html.php";
            $title = "statistique";

            // ACCOUNTS
            $accounts = $compteManager->findAll(['client_id' => $clientId], 'object', 'order by id asc');
            $formattedAccounts = [];
            foreach ($accounts as $account) {
                $formattedAccounts[] = [
                    'id' => $account->getId(),
                    'type' => $account->getTypecompte_id(),
                    'name' => $account->getNumcompte(),
                    'amount' => $account->getMontant_initial(),
                    'color' => $account->getColor(),
                    'creationTimestamp' => $account->getDate_creation(),
                ];
            }
            $accountsJSON = json_encode($formattedAccounts);

            // OPERATIONS
            // Get all operations by client
            $operationsTotalByClient = $operationManager->findAll(['client_id'=>$clientId], "array", "order by id");
            $operationsTotalByClientJSON = json_encode($operationsTotalByClient);

            // CATEGORIES
            $categoriesJSON = json_encode($categorieManager->findAll([], "array", "order by id"));

            $variables = [
                "title" => $title,
                "accountsJSON" => $accountsJSON,
                "categoriesJSON" => $categoriesJSON,
                "operationsTotalByClientJSON" => $operationsTotalByClientJSON,
            ];
            $this -> generatePage($file, $variables);
        }

    }