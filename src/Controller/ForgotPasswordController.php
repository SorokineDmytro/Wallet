<?php
    namespace App\Controller;
    use App\Model\Manager;

    class forgotPasswordController extends Manager {
        public function __construct() {
            $file = "view/wellcome/forgotPassword.html.php";
            $title = "Mot de passe oublié";
            
            // VARIABLES
            $variables = [
                "title" => $title,
            ];
            $this -> generatePage($file, $variables, $base="view/login.html.php");
        }
        
    }