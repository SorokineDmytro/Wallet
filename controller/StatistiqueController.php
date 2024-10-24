<?php
    class StatistiqueController extends Manager {
        public function __construct() {
            $page = "statistique";
            extract($_GET);
            switch($page) {
                case "statistique" :
                    $file = "view/statistique/statistique.html.php";
                    $title = "statistique";
                    $variables = [
                        "title" => $title,
                    ];
                    $this -> generatePage($file, $variables);
                    break;
            }
        }
    }