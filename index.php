<?php
    session_start();
    require_once("vendor/autoload.php");
    
    // Script to use the dynamic path to different controllers
    $url="apercu";
    extract($_GET);
    $controller=ucfirst($url)."Controller";  
    $controller_file="src/Controller/$controller.php";
    if(file_exists($controller_file)){
        $controller = "App\\Controller\\$controller";
        $page=new $controller;
    }else{
        echo "<h1>Désolé! Le fichier $controller_file n'existe pas </h1>";
    }
