<?php
namespace App\Controller;

use App\Model\Manager;
use App\Model\EntityManager;
use App\Service\OperationService;
use DateTime;

class ApercuController extends Manager
{
public function __construct()
{
    $compteManager = new EntityManager('compte', 'Compte');
    $operationManager = new EntityManager('operation', 'Operation');
    $categorieManager = new EntityManager('categorie', 'Categorie');
    $sousCategorieManager = new EntityManager('souscategorie', 'SousCategorie');
    $operationService = new OperationService();
    $clientId = 1; // Temporary; replace with dynamic user session ID when available
        $file = "view/apercu/apercu.html.php";
        $title = "aperçu";
        
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
    }
}