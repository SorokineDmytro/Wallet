<?php
    function router($class) {
        // App\Model\Article - avant
        $file = str_replace("App", "src", $class);
        // src\Model\article -apres (il faut remplacr encore "\" par "/")
        $file = str_replace("\\", "/", $file);
        // src/Model/Article
        $file = "$file.php";
        // src/Model/Article.php
        if(file_exists($file)){
            require_once($file);
        }
    }
