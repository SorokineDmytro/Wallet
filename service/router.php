<?php
    function router($class) {
        $fichierModel = "model/$class.php";
        $fichierController = "controller/$class.php";
        $fichierService = "service/$class.php";
        $fichiers = [$fichierController, $fichierModel, $fichierService];
        foreach ($fichiers as $fichier) {
            if(file_exists($fichier)) {
                require_once($fichier);
            }
        }
    }
