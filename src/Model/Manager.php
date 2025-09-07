<?php 
namespace App\Model;
require_once("config/parametre.php");
class Manager {
    
    // Function that handles a secure connection to DB using params from config/parametre.php
    function getConnexion($host = HOST, $dbname = DBNAME, $user = USER, $password = PASSWORD) {
        $dsn = "pgsql:host=$host;dbname=$dbname;options='--client_encoding=UTF8'";
        try{
            $connexion = new \PDO($dsn, $user, $password);
            return $connexion;
        } catch(\Exception $e) {
            echo "<h1 style='color:red; text-align:center;'>Impossible de se connecter à la base de données!</h1>";
            die;
        } 
    }

    // Function which generates the page using a file with variables in conditions to a given base 
    function generatePage($file , $variables =[], $base="view/base.html.php") {
        if (file_exists($file)) {

            ob_start(); // Opens a temp memory (to transform a file into texte)
            extract($variables); // Creates variables used into the $file (indexes will be transformed into variables)
            require_once($file); // Uploads a file referenced by the variable $file
            $content = ob_get_clean(); // Closes a temp memory (to transform it's content into texte and asigns it to the variable $content)

            ob_start(); // Opens a temp memory (to insert into it also the base.html.php)
            require_once($base); // Uploads a file referenced by the variable $base (it's content will be filled in with $content)
            $page = ob_get_clean(); // Closes a temp memory (to transform it's content into texte and asigns it to the variable $page)

            echo $page; // Prints the file base.html.php filled in with $content

        } else {
            echo "<h1 style='color:red; text-align:center;'>Le fichier $file n'existe pas!</h1>"; // Handling an error message in case we can't found a file
            die;
        }
    }
  
    // Function to find one entry in one table by given ID 
    public function findTable($table,$id){
        $connexion=$this->getConnexion();
        $sql="select * from $table where id=?";
        $stmt=$connexion->prepare($sql);
        $stmt->execute([$id]);
        $resultat=$stmt->fetch(\PDO::FETCH_ASSOC);
        return $resultat;
    }
    
    // Function to find ALL entries (using fetchAll) in one table by conditions 
    public function findAllTable($table, $conditions=[],$order=""){
        $columns=[];
        $values=[];
        foreach($conditions as $key=>$value){
            $columns[]="$key=?";
            $values[]=$value;
        }
        //----transforms a column to text
        if($columns){  // $columns !=[]
            $columns=implode(" and ",$columns);
        }else{
            $columns="true";
        }
        $connexion=$this->getConnexion();
        $sql="select * from $table where $columns $order";
        $stmt=$connexion->prepare($sql);
        $stmt->execute($values);
        $resultats=$stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $resultats;
    }   

    // Function to find a unique entry (using fetch) in one table by conditions
    public function findOneTable($table, $conditions=[],$order=""){
        $columns=[];
        $values=[];
        foreach($conditions as $key=>$value){
            $columns[]="$key=?";
            $values[]=$value;
        }
        //----transformation $columns en texte
        if($columns){  // $columns !=[]
            $columns=implode(" and ",$columns);
        }else{
            $columns="true";
        }
        $connexion=$this->getConnexion();
        $sql="select * from $table where $columns $order";
        $stmt=$connexion->prepare($sql);
        $stmt->execute($values);
        $resultat=$stmt->fetch(\PDO::FETCH_ASSOC);
        return $resultat;
    }     

    // Function to find ALL entries (using fetchAll) in one table by conditions (used for search from a search bar)
    public function searchTableByCondition($table,$columns,$mot,$conditions=[],$orderBy="",$limit=0,$offset=0){
        $condition="";
        $values=[];
        foreach($columns as $value){
            if($condition==""){
                $condition.="$value ilike ?";
            }else{
                $condition.=" or $value ilike ?";
            }
            $values[]="%$mot%";
        }
        $condition=" ($condition) ";
        foreach($conditions as $key=>$value){
            $condition.=" AND $key=?";
            $values[]=$value;
        }
        $condition.=" $orderBy ";
        if($limit){
            $condition.=" limit $limit "; 
        }
        if($offset){
            $condition.=" offset $offset ";
        }
        $connexion=$this->getConnexion();
        $sql="select * from $table where $condition";
        $stmt=$connexion->prepare($sql);
        $stmt->execute($values);
        $rows=$stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $rows;

    } 

    // Function to insert data into a given table
    public function insertTable($table,$data){
        $columns=[]; // initiation of an array
        $values=[];
        $replacements=[]  ; // array containing '?'
        foreach($data as $key=>$value){
            if($key!='id'){
                $columns[]=$key; // asigning to the variables $columns the content of the $key
                $values[]=$value;
                $replacements[]="?";
            }
        }
        $columns=implode(",",$columns);
        $replacements=implode(",",$replacements);
        $connexion=$this->getConnexion();
        $sql="insert into $table ($columns) values ($replacements) ";
        $requete=$connexion->prepare($sql);
        $requete->execute($values);
    }
    // Function to update data into a given table
    public function updateTable($table,$data){
        $sets=[];
        $values=[];
        $connexion=$this->getConnexion();
        foreach($data as $key=>$value){
            if($key!='id'){
                $sets[]="$key=?";
                $values[]=$value;
            }
        }
        $values[]=$data['id'];
        $sets=implode(",",$sets);
        $sql="update $table set $sets where id=?";
        $requete=$connexion->prepare($sql);
        $requete->execute($values);
    }

    // Function to delete data from a given table
    public function deleteTable($table, $id)
    {
        $connexion = $this->getConnexion();
        $sql = "delete from $table where id = ?";
        $value = [$id];
        $requete = $connexion->prepare($sql);
        $requete->execute($value);
    } 

    // Function to print in easier way to read data
    function printr($array) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }

}