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

        // function to retrieve the operations by account


        // WIDGETS logic --->
        // function to retrieve the total monthly amount of operations by user (modulable by type of operation and serve for all kind of operations)
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

        // function to retrieve the total monthly amount of savings by user
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
        
        // function to retrieve the total monthly amount of investments by user
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