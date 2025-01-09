<?php
    namespace App\Service;
    use App\Model\EntityManager;
    use App\Service\CompteService;
    use DateTime;

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

        // WIDGETS logic --->
        // function to retrieve the total amount of operations by user (modulable by type of operation and serve for all kind of operations)

        // total
        public function getTotalOperationsByUser($userId, $typeOperationId) {
            $total = 0;
            $operations = $this->operationManager->findAll(['client_id' => $userId, 'type_id' => $typeOperationId], 'object');
            foreach ($operations as $operation) {
                $total += $operation->getMontant();
            }
            return $total;
        }

        // by month
        public function getTotalMonthlyOperationsByUser($userId, $typeOperationId, $month) {
            $total = 0;
            $operations = $this->operationManager->findAll(['client_id' => $userId, 'type_id' => $typeOperationId], 'object');
            foreach ($operations as $operation) {
                // Convert the timestamp to a DateTime object
                $operationDate = new DateTime($operation->getTimestamp());

                // Check if the operation's month matches the given month
                if ($operationDate->format('m') == $month) {
                    $total += $operation->getMontant();
                }
            }
            return $total;
        }

        // function to retrieve the total amount of savings by user

        // total
        public function getTotalSavingsByUser($userId) {
            $total = 0;
            $compteService = new CompteService();
            $comptes = $compteService->getSavingsAccountsByUser($userId);
            foreach ($comptes as $compte) {
                $savings = $this->operationManager->findAll(['client_id' => $userId, 'compte_destinataire_id' => $compte->getId()], 'object');
                $expenses = $this->operationManager->findAll(['client_id' => $userId, 'compte_id' => $compte->getId()], 'object');
                foreach ($savings as $saving) {
                    $total += $saving->getMontant();
                }
                foreach ($expenses as $expense) {
                    $total -= $expense->getMontant();
                }
            }
            return $total;
        }

        // by month
        public function getTotalMonthlySavingsByUser($userId, $month) {
            $total = 0;
            $compteService = new CompteService();
            $comptes = $compteService->getSavingsAccountsByUser($userId);
            foreach ($comptes as $compte) {
                $savings = $this->operationManager->findAll(['client_id' => $userId, 'compte_destinataire_id' => $compte->getId()], 'object');
                $expenses = $this->operationManager->findAll(['client_id' => $userId, 'compte_id' => $compte->getId()], 'object');
                foreach ($savings as $saving) {
                    // Convert the timestamp to a DateTime object
                    $operationDate = new DateTime($saving->getTimestamp());
                    // Check if the operation's month matches the given month
                    if ($operationDate->format('m') == $month) {
                        $total += $saving->getMontant();
                    }
                }
                foreach ($expenses as $expense) {
                    // Convert the timestamp to a DateTime object
                    $operationDate = new DateTime($expense->getTimestamp());
                    // Check if the operation's month matches the given month
                    if ($operationDate->format('m') == $month) {
                        $total -= $expense->getMontant();
                    }
                }
            }
            return $total;
        }
        
        // function to retrieve the total amount of investments by user

        // total
        public function getTotalInvestmentsByUser($userId) {
            $total = 0;
            $investments = $this->operationManager->findAll(['client_id' => $userId, 'categorie_id' => 9], 'object');
            foreach ($investments as $investment) {
                $total += $investment->getMontant();
            }
            return $total;
        }

        // by month
        public function getTotalMonthlyInvestmentsByUser($userId, $month) {
            $total = 0;
            $investments = $this->operationManager->findAll(['client_id' => $userId, 'categorie_id' => 9], 'object');
            foreach ($investments as $investment) {
                // Convert the timestamp to a DateTime object
                $operationDate = new DateTime($investment->getTimestamp());
                // Check if the operation's month matches the given month
                if ($operationDate->format('m') == $month) {
                    $total += $investment->getMontant();
                }
            }
            return $total;
        }
    }