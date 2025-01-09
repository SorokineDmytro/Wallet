<?php
namespace App\Controller;

use App\Model\Manager;
use App\Model\EntityManager;
use App\Service\OperationService;
use App\Service\CompteService;
use App\Service\CategorieService;
use App\Service\SousCategorieService;
use DateTime;

class ApercuController extends Manager
{
    public function __construct()
    {
        $compteManager = new EntityManager('compte', 'Compte');
        $operationManager = new EntityManager('operation', 'Operation');
        $categorieManager = new EntityManager('categorie', 'Categorie');
        $sousCategorieManager = new EntityManager('souscategorie', 'SousCategorie');
        $compteService = new CompteService();
        $operationService = new OperationService();
        $categorieService = new CategorieService();
        $sousCategorieService = new SousCategorieService();

        $clientId = 1; // Temporary; replace with dynamic user session ID when available
        $page = "apercu";
        switch ($page) {
            case "apercu":
                $file = "view/apercu/apercu.html.php";
                $title = "aperçu";

                // ACCOUNTS
                $accounts = $compteManager->findAll(['client_id' => $clientId], 'object', 'order by id asc');
                $formattedAccounts = [];
                foreach ($accounts as $account) {
                    $expenses = $operationService->getTotalExpenseByAccount($account->getId());
                    $incomes = $operationService->getTotalIncomeByAccount($account->getId());
                    $transfertsOut = $operationService->getTotalTransfertOutByAccount($account->getId());
                    $transfertsIn = $operationService->getTotalTransfertInByAccount($account->getId());

                    $formattedAccounts[] = [
                        'id' => $account->getId(),
                        'type' => $account->getTypecompte_id(),
                        'name' => $account->getNumcompte(),
                        'amount' => $account->getMontant_initial(),
                        'totalAmount' => ($account->getMontant_initial() + $incomes - $expenses - $transfertsOut + $transfertsIn),
                        'color' => $account->getColor(),
                    ];
                }
                $accountsJSON = json_encode($formattedAccounts);

                // OPERATIONS
                $selectedAccount = $_GET['acc_Id'] ?? $formattedAccounts[0]['id'];
                $selectedAccountJSON = json_encode($selectedAccount);
                $selectedAccountName = $compteService->getAccountNameByAccountId($selectedAccount);
                $operationsIn = $operationManager->findAll(['compte_id'=>$selectedAccount], "array", "order by id");
                $operationsOut = $operationManager->findAll(['compte_destinataire_id'=>$selectedAccount], "array", "order by id");
                $operationsTotal = array_merge($operationsIn, $operationsOut);
                $operationsJSON = json_encode($operationsTotal);

                // CATEGORIES
                $categoriesJSON = json_encode($categorieManager->findAll([], "array", "order by id"));

                // SOUS-CATEGORIES
                $sousCategoriesJSON = json_encode($sousCategorieManager->findAll([], "array", "order by id"));

                // WIDGETS TOTALS (to be implemented into statistics)
                // $totalGains = $operationService->getTotalOperationsByUser($clientId, 2);
                // $totalDepenses = $operationService->getTotalOperationsByUser($clientId, 1);
                // $totalSavings = $operationService->getTotalSavingsByUser($clientId);
                // $totalInvestments = $operationService->getTotalInvestmentsByUser($clientId);

                // WIDGETS
                $currentDate = new DateTime(); // Get current date
                $actualMonth = date('m');
                $lastMonth = $currentDate->modify('-1 month')->format('m');

                $totalActualMonthGainsJSON = json_encode($operationService->getTotalMonthlyOperationsByUser($clientId, 2, $actualMonth));
                $totalLastMonthGainsJSON = json_encode($operationService->getTotalMonthlyOperationsByUser($clientId, 2, $lastMonth));

                $totalActualMonthDepensesJSON = json_encode($operationService->getTotalMonthlyOperationsByUser($clientId, 1, $actualMonth));
                $totalLastMonthDepensesJSON = json_encode($operationService->getTotalMonthlyOperationsByUser($clientId, 1, $lastMonth));

                $totalActualMonthSavingsJSON = json_encode($operationService->getTotalMonthlySavingsByUser($clientId, $actualMonth));
                $totalLastMonthSavingsJSON = json_encode($operationService->getTotalMonthlySavingsByUser($clientId, $lastMonth));

                $totalActualMonthInvestmentsJSON = json_encode($operationService->getTotalMonthlyInvestmentsByUser($clientId, $actualMonth));
                $totalLastMonthInvestmentsJSON = json_encode($operationService->getTotalMonthlyInvestmentsByUser($clientId, $lastMonth));

                // VARIABLES
                $variables = [
                    "title" => $title,
                    "accounts" => $formattedAccounts,
                    "accountsJSON" => $accountsJSON,
                    "operationsJSON" => $operationsJSON,
                    "selectedAccount" => $selectedAccount,
                    "selectedAccountJSON" => $selectedAccountJSON,
                    "selectedAccountName" => $selectedAccountName,
                    "categoriesJSON" => $categoriesJSON,
                    "sousCategories" => $sousCategoriesJSON,
                    "totalActualMonthGainsJSON" => $totalActualMonthGainsJSON,
                    "totalLastMonthGainsJSON" => $totalLastMonthGainsJSON,
                    "totalActualMonthDepensesJSON" => $totalActualMonthDepensesJSON,
                    "totalLastMonthDepensesJSON" => $totalLastMonthDepensesJSON,
                    "totalActualMonthSavingsJSON" => $totalActualMonthSavingsJSON,
                    "totalLastMonthSavingsJSON" => $totalLastMonthSavingsJSON,
                    "totalActualMonthInvestmentsJSON" => $totalActualMonthInvestmentsJSON,
                    "totalLastMonthInvestmentsJSON" => $totalLastMonthInvestmentsJSON,
                ];
                // $this->printr($operationsJSON);die;

                $this->generatePage($file, $variables);
                break;
        }
    }
}