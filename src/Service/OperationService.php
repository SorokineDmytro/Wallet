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

        // function to retrieve the total amount of transferts sent by each account 
        public function getTotalTransfertOutByAccount($accountId) {
            $totalTransfertOut = 0;
            $transfertsOut = $this->operationManager->findAll(['compte_id' => $accountId, 'type_id' => 3], 'object');
            foreach ($transfertsOut as $transfert) {
                $totalTransfertOut += $transfert->getMontant();
            }
            return $totalTransfertOut;
        }

        // function to retrieve the total amount of transferts received by each account 
        public function getTotalTransfertInByAccount($accountId) {
            $totalTransfertIn = 0;
            $transfertsIn = $this->operationManager->findAll(['compte_destinataire_id' => $accountId, 'type_id' => 3], 'object');
            foreach ($transfertsIn as $transfert) {
                $totalTransfertIn += $transfert->getMontant();
            }
            return $totalTransfertIn;
        }

        // function to retrieve the operations by account
        public function getOperationsByAccount($accountId) {
            $operations1 = $this->operationManager->findAll(['compte_id' => $accountId], 'object', 'order by timestamp desc');
            $operations2 = $this->operationManager->findAll(['compte_destinataire_id' => $accountId], 'object', 'order by timestamp desc');
            // Merge and sort operations by timestamp
            $operations = array_merge($operations1, $operations2);
            usort($operations, function ($a, $b) {
                return $b->getTimestamp() <=> $a->getTimestamp();
            });
            return $operations;
        }
        
    }