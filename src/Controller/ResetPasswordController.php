<?php
    namespace App\Controller;
    use App\Model\Manager;

    class resetPasswordController extends Manager {
        public function __construct() {
            $file = "view/wellcome/resetPassword.html.php";
            $title = "Réinitialiser le mot de passe";
            
            // VARIABLES
            $variables = [
                "title" => $title,
            ];
            $this -> generatePage($file, $variables, $base="view/login.html.php");
        }
        
    }