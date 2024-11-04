<?php
    namespace App\Service;
    use App\Model\EntityManager;

    class OperationService {
        private $operationManager;

        public function __construct() {
            $this->operationManager = new EntityManager('operation', 'Operation');
        }
        
        // function to retrieve the total amount of incomes by each account 
        public function getTotalIncomeByAccount($accountId) {
            $totalIncome = 0;
            $incomes = $this->operationManager->findAll(['compte_id' => $accountId, 'type_id' => 2], 'object');
            foreach ($incomes as $income) {
                $totalIncome += $income->getMontant();
            }
            return $totalIncome;
        }

        // function to retrieve the total amount of expenses by each account 
        public function getTotalExpenseByAccount($accountId) {
            $totalExpense = 0;
            $expenses = $this->operationManager->findAll(['compte_id' => $accountId, 'type_id' => 1], 'object');
            foreach ($expenses as $expense) {
                $totalExpense += $expense->getMontant();
            }
            return $totalExpense;
        }

        // function to retrieve the operations by account
        public function getOperationsByAccount($accountId) {
            $operations = $this->operationManager->findAll(['compte_id' => $accountId], 'object', 'order by timestamp desc');
            return $operations;
        }
    }