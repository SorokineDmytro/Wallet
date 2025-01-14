<?php
    namespace App\Controller;
    use App\Model\Manager;
    use App\Model\EntityManager;
    use DateTime;

    class StatistiqueController extends Manager {
        public function __construct() 
        {
            $compteManager = new EntityManager('compte', 'Compte');
            $operationManager = new EntityManager('operation', 'Operation');
            $categorieManager = new EntityManager('categorie', 'Categorie');
            $clientId = 1; // Temporary; replace with dynamic user session ID when available
            $file = "view/statistique/statistique.html.php";
            $title = "statistique";

            // OPERATIONS
            // Get all operations by client
            $operationsTotalByClient = $operationManager->findAll(['client_id'=>$clientId], "array", "order by id");
            $operationsTotalByClientJSON = json_encode($operationsTotalByClient);

            // CATEGORIES
            $categoriesJSON = json_encode($categorieManager->findAll([], "array", "order by id"));

            $variables = [
                "title" => $title,
                "categoriesJSON" => $categoriesJSON,
                "operationsTotalByClientJSON" => $operationsTotalByClientJSON,
            ];
            $this -> generatePage($file, $variables);
        }

    }