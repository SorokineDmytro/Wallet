<?php
    namespace App\Controller;
    use App\Model\Manager;
    class EpargneController extends Manager {
        public function __construct() {
            $page = "epargne";
            extract($_GET);
            switch($page) {
                case "epargne" :
                    $file = "view/epargne/epargne.html.php";
                    $title = "Épargne";
                    $variables = [
                        "title" => $title,
                    ];
                    $this -> generatePage($file, $variables);
                    break;
            }
        }
    }


