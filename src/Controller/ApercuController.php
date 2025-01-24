<?php
    namespace App\Controller;

    use App\Model\Manager;
    use App\Model\EntityManager;
    use App\Service\OperationService;
    use DateTime;
    use phpDocumentor\Reflection\Location;

    class ApercuController extends Manager
    {
        public function __construct()
        {
            // Start the session if it's not already started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            // Prevent browser caching
            header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
            header("Pragma: no-cache"); // HTTP 1.0
            header("Expires: 0"); // Proxies

            // Check if the user is logged in
            if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['client_id'])) {
                // Let user go to apercu page if logged in
                $clientManager = new EntityManager('client', 'Client');
                $compteManager = new EntityManager('compte', 'Compte');
                $operationManager = new EntityManager('operation', 'Operation');
                $categorieManager = new EntityManager('categorie', 'Categorie');
                $sousCategorieManager = new EntityManager('souscategorie', 'SousCategorie');
                $operationService = new OperationService();
                $clientId = $_SESSION['client_id'];
                $file = "view/apercu/apercu.html.php";
                $title = "aperçu";
                
                // CLIENT
                $client = $clientManager->findOne(['id' => $clientId], 'object');
                $clientInfo = [
                    'lastName' => $client->getNomclient(),
                    'firstName' => $client->getPrenomclient(),
                    'email' => $client->getEmail(),
                ];

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
                    ];
                }
                $accountsJSON = json_encode($formattedAccounts);

                // OPERATIONS
                // Get the selected account ID passed from the URL
                $selectedAccount = $_GET['acc_Id'] ?? $formattedAccounts[0]['id'];
                $selectedAccountJSON = json_encode($selectedAccount);
                // Get all operations by client
                $operationsTotalByClient = $operationManager->findAll(['client_id'=>$clientId], "array", "order by id");
                $operationsTotalByClientJSON = json_encode($operationsTotalByClient);

                // CATEGORIES
                $categoriesJSON = json_encode($categorieManager->findAll([], "array", "order by id"));

                // SOUS-CATEGORIES
                $sousCategoriesJSON = json_encode($sousCategorieManager->findAll([], "array", "order by id"));

                // WIDGETS
                $currentDate = new DateTime(); // Get current date
                $actualMonth = date('m');
                $lastMonth = $currentDate->modify('-1 month')->format('m');
                $totalActualMonthGains = $operationService->getTotalMonthlyOperationsByUser($clientId, 2, $actualMonth);
                $totalLastMonthGains = $operationService->getTotalMonthlyOperationsByUser($clientId, 2, $lastMonth);
                $totalActualMonthDepenses = $operationService->getTotalMonthlyOperationsByUser($clientId, 1, $actualMonth);
                $totalLastMonthDepenses = $operationService->getTotalMonthlyOperationsByUser($clientId, 1, $lastMonth);
                $totalActualMonthSavings = $operationService->getTotalMonthlySavingsByUser($clientId, $actualMonth);
                $totalLastMonthSavings = $operationService->getTotalMonthlySavingsByUser($clientId, $lastMonth);
                $totalActualMonthInvestments = $operationService->getTotalMonthlyInvestmentsByUser($clientId, $actualMonth);
                $totalLastMonthInvestments = $operationService->getTotalMonthlyInvestmentsByUser($clientId, $lastMonth);

                // VARIABLES
                $variables = [
                    "title" => $title,
                    "clientInfo" => $clientInfo,
                    "accountsJSON" => $accountsJSON,
                    "selectedAccountJSON" => $selectedAccountJSON,
                    "categoriesJSON" => $categoriesJSON,
                    "sousCategories" => $sousCategoriesJSON,
                    "totalActualMonthGains" => $totalActualMonthGains,
                    "totalLastMonthGains" => $totalLastMonthGains,
                    "totalActualMonthDepenses" => $totalActualMonthDepenses,
                    "totalLastMonthDepenses" => $totalLastMonthDepenses,
                    "totalActualMonthSavings" => $totalActualMonthSavings,
                    "totalLastMonthSavings" => $totalLastMonthSavings,
                    "totalActualMonthInvestments" => $totalActualMonthInvestments,
                    "totalLastMonthInvestments" => $totalLastMonthInvestments,
                    "operationsTotalByClientJSON" => $operationsTotalByClientJSON,
                ];
                $this->generatePage($file, $variables);
            } else {
            // User is not logged in; redirect to the "wellcome" page
            header('Location: index.php?url=wellcome');
            exit;
            }
        }
    }