<?php
    namespace App\Controller;

    use App\Model\Manager;
    use App\Model\EntityManager;
    use App\Service\OperationService;
    use App\Service\CompteService;
use App\Service\SousCategorieService;

    class ApercuController extends Manager {
        public function __construct() {
            $cm = new EntityManager('compte', 'Compte');
            $cs = new CompteService();
            $os = new OperationService();
            $scm = new SousCategorieService;
            $page = "apercu";
            $clientId = 1; // don't forget to change it when the users could log in and have an id which can be retreated from $_SESSION
            extract($_GET);
            switch($page) {
                case "apercu" :
                    $file = "view/apercu/apercu.html.php";
                    $title = "aperçu";
                    
                    // Retrieve operations only for the specified account
                    $selectedAccount = isset($_GET['acc_Id']) ? $_GET['acc_Id'] : 1;
                    $operations = $os->getOperationsByAccount($selectedAccount);

                    // Group operations by date
                    $operationsByDate = [];
                    foreach ($operations as $operation) {
                        $date = date('d-m-Y', strtotime($operation->getTimestamp())); // Format date to YYYY-MM-DD
                        $operationsByDate[$date][] = [
                            'op_type' => $operation->getType_id(),
                            'op_souscategorie' => $scm->getSousCategorieNameById(htmlspecialchars($operation->getSouscategorie_id())),
                            'op_time' => date('H:i', strtotime($operation->getTimestamp())),
                            'op_amount' => $operation->getMontant(),
                            'op_account' => $cs->getAccountNameByAccountId(htmlspecialchars($operation->getCompte_id())),
                        ];
                    }

                    // get the basic info of each account using CompteManager to dispalay it into the view
                    $accounts = $cm->findAll(['client_id' => $clientId], 'object');
                    $formattedAccounts = [];
                    foreach ($accounts as $account) {
                        // get the info about total debit and credit operations of each account using OperationManager
                        $expenses = $os->getTotalExpenseByAccount($account->getId());
                        $incomes = $os->getTotalIncomeByAccount($account->getId());
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
                    
                    //MODAL ACCOUNT
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $showModal = true;
                        $accountId = $_POST['acc_Id'] ?? null; // 'create', 'modify', 'delete'
                        $modalAction = $_POST['action'] ?? null; // Get the account ID if available
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
                        $showModal = false;
                    }
                    $variables = [
                        "title" => $title,
                        "accounts" => $formattedAccounts,
                        "operationsByDate" => $operationsByDate,
                        "selectedAccount" => $selectedAccount,
                        "showModal" => $showModal,                        
                    ];
                    if($showModal == true){
                        $variables["modalAction"] = $modalAction;
                        $variables["accountId"] = $accountId;
                        $variables["accountToModify"] = $accountToModify;
                    };
                    $this -> generatePage($file, $variables);
                    break;
                case "createAccount" :
                    // Filtering and sanitizing input values came from $_POST
                    $typecompte_id = filter_var($_POST['typecompte_id'], FILTER_VALIDATE_INT);
                    // Step 1: Trim whitespace
                    $numcompte = trim($_POST['numcompte']); 
                    // Step 2: Sanitize by allowing only letters, numbers, and some symbols (e.g., hyphens, spaces)
                    $numcompte = preg_replace("/[^a-zA-Z0-9\s\#\-\é\è\ê\ë\à\ä\â\ç\ù\û\ü\î\ï\É\È\Ê\Ë\À\Ä\Â\Ç\Ù\Û\Ü\Î\Ï]/u", "", $numcompte);
                    // Step 3: Optionally, use htmlspecialchars to escape HTML characters if outputting in HTML
                    $numcompte = htmlspecialchars($numcompte, ENT_QUOTES, 'UTF-8');
                    $color = htmlspecialchars(trim($_POST['color']), ENT_QUOTES, 'UTF-8');
                    $montant_initial = filter_var($_POST['montant_initial'], FILTER_VALIDATE_FLOAT);
                    $data = [
                        'client_id' => $clientId,
                        'numcompte' => $numcompte,
                        'typecompte_id' => $typecompte_id,
                        'montant_initial' => $montant_initial,
                        'color' => $color
                    ];
                    $cm->insert($data);
                    // Redirect or return
                    header("Location: index.php?page=apercu");
                    exit;
                case "modifyAccount" :
                    // Filtering and sanitizing input values came from $_POST
                    $typecompte_id = filter_var($_POST['typecompte_id'], FILTER_VALIDATE_INT);
                    // Step 1: Trim whitespace
                    $numcompte = trim($_POST['numcompte']); 
                    // Step 2: Sanitize by allowing only letters, numbers, and some symbols (e.g., hyphens, spaces)
                    $numcompte = preg_replace("/[^a-zA-Z0-9\s\#\-\é\è\ê\ë\à\ä\â\ç\ù\û\ü\î\ï\É\È\Ê\Ë\À\Ä\Â\Ç\Ù\Û\Ü\Î\Ï]/u", "", $numcompte);
                    // Step 3: Optionally, use htmlspecialchars to escape HTML characters if outputting in HTML
                    $numcompte = htmlspecialchars($numcompte, ENT_QUOTES, 'UTF-8');
                    $color = htmlspecialchars(trim($_POST['color']), ENT_QUOTES, 'UTF-8');
                    $montant_initial = filter_var($_POST['montant_initial'], FILTER_VALIDATE_FLOAT);
                    $data = [
                        'client_id' => $clientId,
                        'numcompte' => $numcompte,
                        'typecompte_id' => $typecompte_id,
                        'montant_initial' => $montant_initial,
                        'color' => $color
                    ];
                    // $this->printr($_POST);die;
                    // $cm->update($data);
                    // Redirect or return
                    header("Location: index.php?page=apercu");
                    break;
                case "deleteAccount" :
                    $cm->delete($accountId);
                    // Redirect or return
                    header("Location: index.php?page=apercu");
                    break;
            }
        }
    }
