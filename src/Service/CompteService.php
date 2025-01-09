<?php
    namespace App\Service;
    use App\Model\EntityManager;

    class CompteService {
        private $compteManager;

        public function __construct() {
            $this->compteManager = new EntityManager('compte', 'Compte');
        }

        // function to retrive an account name by it's ID
        public function getAccountNameByAccountId($accountId) {
            $accountName = $this->compteManager->findOne(['id' => $accountId], 'object');
            return $accountName->getNumcompte();
        }

        // function to retrive an account name by it's ID
        public function getDestAccountNameByAccountId($accountId) {
            $destAccountName = $this->compteManager->findOne(['id' => $accountId], 'object');
            return $destAccountName->getNumcompte();
        }

        // function to retrieve the saving accounts by user
        public function getSavingsAccountsByUser($userId) {
            $savingAccounts = $this->compteManager->findAll(['client_id' => $userId, 'typecompte_id' => 2], 'object');
            return $savingAccounts;
        }

    }