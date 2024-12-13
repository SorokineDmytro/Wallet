<?php
namespace App\Controller;

use App\Model\Manager;
use App\Model\EntityManager;
use App\Service\OperationService;
use App\Service\CompteService;
use App\Service\CategorieService;
use App\Service\SousCategorieService;

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

                    $formattedAccounts[] = [
                        'id' => $account->getId(),
                        'type' => $account->getTypecompte_id(),
                        'name' => $account->getNumcompte(),
                        'amount' => $account->getMontant_initial(),
                        'totalAmount' => ($account->getMontant_initial() + $incomes - $expenses),
                        'color' => $account->getColor(),
                    ];
                }
                $accountsJSON = json_encode($formattedAccounts);

                // OPERATIONS
                $selectedAccount = $_GET['acc_Id'] ?? $formattedAccounts[0]['id'];
                $operations = $operationService->getOperationsByAccount($selectedAccount);
                $operationsJSON = json_encode($operationManager->findAll([], "array", "order by id"));
                $operationsByDate = [];
                foreach ($operations as $operation) {
                    $date = date('d-m-Y', strtotime($operation->getTimestamp()));
                    $operationsByDate[$date][] = [
                        'op_id' => $operation->getId(),
                        'op_type' => $operation->getType_id(),
                        'op_color' => $categorieService->getCategorieColorById(htmlspecialchars($operation->getCategorie_id())),
                        'op_icon' => $sousCategorieService->getSousCategorieIconById(htmlspecialchars($operation->getSouscategorie_id())),
                        'op_souscategorie' => $sousCategorieService->getSousCategorieNameById(htmlspecialchars($operation->getSouscategorie_id())),
                        'op_time' => date('H:i', strtotime($operation->getTimestamp())),
                        'op_amount' => $operation->getMontant(),
                        'op_accountId' => $operation->getCompte_id(),
                        'op_account' => $compteService->getAccountNameByAccountId(htmlspecialchars($operation->getCompte_id())),
                    ];
                }

                // CATEGORIES
                $categoriesJSON = json_encode($categorieManager->findAll([], "array", "order by id"));

                // SOUS-CATEGORIES
                $sousCategoriesJSON = json_encode($sousCategorieManager->findAll([], "array", "order by id"));

                // VARIABLES
                $variables = [
                    "title" => $title,
                    "accounts" => $formattedAccounts,
                    "accountsJSON" => $accountsJSON,
                    "operationsJSON" => $operationsJSON,
                    "operationsByDate" => $operationsByDate,
                    "selectedAccount" => $selectedAccount,
                    "categoriesJSON" => $categoriesJSON,
                    "sousCategories" => $sousCategoriesJSON,
                ];
                // $this->printr($operationsJSON);die;

                $this->generatePage($file, $variables);
                break;
        }
    }
}