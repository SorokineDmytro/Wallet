<?php
    namespace App\Service;
    use App\Model\EntityManager;

    class SousCategorieService {
        private $sousCategorieManager;

        public function __construct() {
            $this->sousCategorieManager = new EntityManager('sousCategorie', 'SousCategorie');
        }

        // function to retrive a sousCategrie name by it's ID
        public function getSousCategorieNameById($sousCategorieId) {
            $sousCategorieName = $this->sousCategorieManager->findOne(['id' => $sousCategorieId], 'object');
            return $sousCategorieName->getDescription();
        }

        public function getSousCategorieIconById($sousCategorieId) {
            $sousCategorieIcon = $this->sousCategorieManager->findOne(['id' => $sousCategorieId], 'object');
            return $sousCategorieIcon->getIcone();
        }
    }