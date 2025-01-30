<?php
    namespace App\Controller;
    use App\Model\Manager;
    use App\Model\EntityManager;

    class WellcomeController extends Manager {
        public function __construct() {
            $clientManager = new EntityManager('client', 'Client');
            $file = "view/wellcome/wellcome.html.php";
            $title = "Bienvenue";
            
            // CLIENTS
            $clientsJSON = json_encode($clientManager->findAll([], 'array', 'order by id asc'));

            // VARIABLES
            $variables = [
                "title" => $title,
                "clientsJSON" => $clientsJSON,
            ];
            $this -> generatePage($file, $variables, $base="view/login.html.php");
        }
        
    }


