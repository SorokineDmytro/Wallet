<?php
    namespace App\Controller;
    use App\Model\Manager;
    use App\Model\EntityManager;

    class WellcomeController extends Manager {
        public function __construct() {
            $file = "view/wellcome/wellcome.html.php";
            $title = "Bienvenue";

            $variables = [
                "title" => $title,
            ];
            $this -> generatePage($file, $variables, $base="view/login.html.php");
        }
        
    }


