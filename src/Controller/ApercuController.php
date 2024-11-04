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
            extract($_GET);
            switch($page) {
                case "apercu" :
                    $file = "view/apercu/apercu.html.php";
                    $title = "aperçu";
                    $clientId = 1; // don't forget to change it when the users could log in and have an id which can be retreated from $_SESSION
                    
                    // Retrieve operations only for the specified account
                    $operations = $os->getOperationsByAccount(1);

                    // Group operations by date
                    $operationsByDate = [];
                    foreach ($operations as $operation) {
                        $date = date('d-m-Y', strtotime($operation->getTimestamp())); // Format date to YYYY-MM-DD
                        $operationsByDate[$date][] = [
                            'op_type' => $operation->getType_id(),
                            'op_souscategorie' => $scm->getSousCategorieNameById(htmlspecialchars($operation->getSouscategorie_id())),
                            'op_time' => date('H:i', strtotime($operation->getTimestamp())),
                            'op_amount' => number_format($operation->getMontant(), 2, '.', ' ') . ' €' ,
                            'op_account' => $cs->getAccountNameByAccountId(htmlspecialchars($operation->getCompte_id())),
                        ];
                    }
                    // $this->printr($operationsByDate);die;


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
                            'amount' => number_format(($account->getMontant_initial() + $incomes - $expenses), 2, '.', ' ') . ' €',
                        ]; 
                    } 

                    $variables = [
                        "title" => $title,
                        "accounts" => $formattedAccounts,
                        "operationsByDate" => $operationsByDate,
                    ];
                    $this -> generatePage($file, $variables);
                    break;
                case "createAcc" :

                    break;
            }
        }
    }
