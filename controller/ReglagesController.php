<?php
    class ReglagesController extends Manager {
        public function __construct() {
           $page = "reglages";
           extract($_GET); 
           switch($page) {
            case "reglages" :
                $file = "view/reglages/reglages.html.php";
                $title = "reglages";
                $variables = [
                    "title" => $title,
                ];
                $this -> generatePage($file, $variables);
                break;
           }
        }
    }