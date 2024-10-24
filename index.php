<?php
    session_start();
    require_once("./service/router.php");
    spl_autoload_register("router");
    
    // Script to use the dynamic path to different controllers
    $url="apercu";
    extract($_GET);
    $controller=ucfirst($url)."Controller";  
    $controller_file="controller/$controller.php";
    if(file_exists($controller_file)){
        $page=new $controller;
    }else{
        echo "<h1>Désolé! Le fichier $controller_file n'existe pas </h1>";
    }
