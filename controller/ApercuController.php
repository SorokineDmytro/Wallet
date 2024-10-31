<?php
    class ApercuController extends Manager {
        public function __construct() {
            $cm = new CompteManager();
            $om = new OperationManager();
            $scm = new SousCategorieManager();
            $page = "apercu";
            extract($_GET);
            switch($page) {
                case "apercu" :
                    $file = "view/apercu/apercu.html.php";
                    $title = "aperçu";
                    $clientId = 1; // don't forget to change it when the users could log in and have an id which can be retreated from $_SESSION
                    
                    // Retrieve operations only for the specified account
                    $operations = $om->getOperationsByAccount(1);

                    // Group operations by date
                    $operationsByDate = [];
                    foreach ($operations as $operation) {
                        $date = date('d-m-Y', strtotime($operation->getTimestamp())); // Format date to YYYY-MM-DD
                        $operationsByDate[$date][] = [
                            'op_type' => $operation->getType_id(),
                            'op_souscategorie' => $scm->getSousCategorieNameById(htmlspecialchars($operation->getSouscategorie_id())),
                            'op_time' => date('H:i', strtotime($operation->getTimestamp())),
                            'op_amount' => number_format($operation->getMontant(), 2, '.', ' ') . ' €' ,
                            'op_account' => $cm->getAccountNameByAccountId(htmlspecialchars($operation->getCompte_id())),
                        ];
                    }
                    // $this->printr($operationsByDate);die;


                    // get the basic info of each account using CompteManager to dispalay it into the view
                    $accounts = $cm->findAll(['client_id' => $clientId], 'object');
                    $formattedAccounts = [];
                    foreach ($accounts as $account) {
                        // get the info about total debit and credit operations of each account using OperationManager
                        $expenses = $om->getTotalExpenseByAccount($account->getId());
                        $incomes = $om->getTotalIncomeByAccount($account->getId());
                        // account with all preformated info to send into a view in a form of a variable
                        $formattedAccounts[] = [
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
