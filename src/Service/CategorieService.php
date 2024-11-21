<?php
    namespace App\Service;
    use App\Model\EntityManager;

    class CategorieService {
        private $categorieManager;

        public function __construct() {
            $this->categorieManager = new EntityManager('categorie', 'Categorie');
        }

        // function to retrive a sousCategrie name by it's ID
        public function getCategorieColorById($categorieId) {
            $categorieColor = $this->categorieManager->findOne(['id' => $categorieId], 'object');
            return $categorieColor->getColor();
        }
    }