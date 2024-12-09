<?php
    namespace App\Controller;

    use App\Model\Manager;
    use App\Model\EntityManager;
    use App\Service\OperationService;
    use App\Service\CompteService;
    use App\Service\CategorieService;
    use App\Service\SousCategorieService;

    class ApercuController extends Manager {
        public function __construct() {
            $compteManager = new EntityManager('compte', 'Compte');
            $operationManager = new EntityManager('operation', 'Operation');
            $categorieManager = new EntityManager('categorie', 'Categorie');
            $sousCategorieManager = new EntityManager('souscategorie', 'SousCategorie');
            $compteService = new CompteService();
            $operationService = new OperationService();
            $categorieService = new CategorieService();
            $sousCategorieService = new SousCategorieService();
            $page = "apercu";
            $clientId = 1; // don't forget to change it when the users could log in and have an id which can be retreated from $_SESSION
            extract($_GET);
            
            switch($page) {
                case "apercu" :
                    $file = "view/apercu/apercu.html.php";
                    $title = "aperçu";

                    // ACCOUNTS
                    // get the basic info of each account using CompteManager to dispalay it into the view
                    $accounts = $compteManager->findAll(['client_id' => $clientId], 'object', 'order by id asc');
                    $formattedAccounts = [];
                    foreach ($accounts as $account) {
                        // get the info about total debit and credit operations of each account using OperationManager
                        $expenses = $operationService->getTotalExpenseByAccount($account->getId());
                        $incomes = $operationService->getTotalIncomeByAccount($account->getId());
                        // account with all preformated info to send into a view in a form of a variable
                        $formattedAccounts[] = [
                            'id' => $account->getId(),
                            'type' => $account->getTypecompte_id(),
                            'name' => $account->getNumcompte(),
                            'amount' => $account->getMontant_initial(),
                            'totalAmount' => ($account->getMontant_initial() + $incomes - $expenses),
                            'color' => $account->getColor(),
                        ]; 
                    } 

                    // MODAL ACCOUNT
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acc_Id'])) {
                        $showAcountModal = true;
                        $modalAction = $_POST['action'] ?? null; // 'create', 'modify', 'delete'
                        $accountId = $_POST['acc_Id'] ?? null; // Get the account ID if available
                        foreach ($formattedAccounts as $account) {
                            if ($account['id'] == $accountId) {
                                $accountToModify = $account;
                                break;
                            }
                            else {
                                $accountToModify = null;
                            }
                        }
                    } else {
                        $showAcountModal = false;
                    }

                    // OPERATIONS 
                    // Retrieve all operations by client in array format for operation CRUD  
                    $allOperations = $operationManager->findAll(['client_id' => $clientId], 'array', "order by id");
                    // Retrieve operations only for the specified account
                    $selectedAccount = isset($_GET['acc_Id']) ? $_GET['acc_Id'] : $formattedAccounts[0]['id'];
                    $operations = $operationService->getOperationsByAccount($selectedAccount);
                    // Group operations by date
                    $operationsByDate = [];
                    foreach ($operations as $operation) {
                        $date = date('d-m-Y', strtotime($operation->getTimestamp())); // Format date to DD-MM-YYYY
                        $operationsByDate[$date][] = [
                            'op_type' => $operation->getType_id(),
                            'op_color' => $categorieService->getCategorieColorById(htmlspecialchars($operation->getCategorie_id())),
                            'op_icon' => $sousCategorieService->getSousCategorieIconById(htmlspecialchars($operation->getSouscategorie_id())),
                            'op_souscategorie' => $sousCategorieService->getSousCategorieNameById(htmlspecialchars($operation->getSouscategorie_id())),
                            'op_time' => date('H:i', strtotime($operation->getTimestamp())),
                            'op_amount' => $operation->getMontant(),
                            'op_account' => $compteService->getAccountNameByAccountId(htmlspecialchars($operation->getCompte_id())),
                        ];
                        // if($compte_destinataire) {
                        //     $operationsByDate[]['op_dest_account'] = $compteService->getAccountNameByAccountId(htmlspecialchars($compte_destinataire)); // normally = null, except transferts
                        // } else $operationsByDate[]['op_dest_account'] = '';
                    }
                    // $this->printr($operationsByDate[$date]);die;

                    // MODAL OPERATION
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['opp_Id'])) {
                        $showOperationModal = true;
                        $modalAction = $_POST['action'] ?? null; // 'create', 'modify', 'delete'
                        $operationID = $_POST['opp_Id'] ?? null; // Get the account ID if available
                        $acountToCreateOperation = $_POST['acc_For_Op'] ?? null; // Get the account to create opperation for
                        foreach ($allOperations as $operation) {
                            if ($operation['id'] == $operationID) {
                                $operationToModify = $operation;
                                break;
                            }
                            else {
                                $operationToModify = null;
                            }
                        }
                    } else {
                        $showOperationModal = false;
                    }

                    // CATEGORIES
                    $categories = $categorieManager->findAll([], "array", "order by id");
                    $categoriesJSON = json_encode($categories);

                    // SOUS-CATEGORIES
                    $sousCategories = $sousCategorieManager->findAll([], "array", "order by id");
                    $sousCategories = json_encode($sousCategories);

                    
                    //VARIABLES
                    $variables = [
                        "title" => $title,
                        "accounts" => $formattedAccounts,
                        "operationsByDate" => $operationsByDate,
                        "selectedAccount" => $selectedAccount,
                        "categories" => $categories,
                        "categoriesJSON" => $categoriesJSON,
                        "sousCategories" => $sousCategories,

                        "showAccountModal" => $showAcountModal,                        
                        "showOperationModal" => $showOperationModal, 
                    ];
                    if($showAcountModal == true){
                        $variables["modalAction"] = $modalAction;
                        $variables["accountId"] = $accountId;
                        $variables["accountToModify"] = $accountToModify;
                    };
                    if($showOperationModal == true){
                        $variables["modalAction"] = $modalAction;
                        $variables["accountId"] = $accountId;
                        $variables["operationToModify"] = $operationToModify;
                        $variables["acountToCreateOperation"] = $acountToCreateOperation;
                    };

                    $this -> generatePage($file, $variables);
                    break;
            }
        }
    }
