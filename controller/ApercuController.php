<?php
    class ApercuController extends Manager {
        public function __construct() {
            $page = "apercu";
            extract($_GET);
            switch($page) {
                case "apercu" :
                    $file = "view/apercu/apercu.html.php";
                    $title = "aperçu";
                    $variables = [
                        "title" => $title,
                    ];
                    $this -> generatePage($file, $variables);
                    break;
            }
        }
    }
