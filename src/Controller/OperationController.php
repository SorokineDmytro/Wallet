<?php
    namespace App\Controller;

    use App\Model\Manager;
    use App\Model\EntityManager;

    class OperationController extends Manager {
        public function __construct() {
            $operationManager = new EntityManager('operation', 'Operation');
            $clientId = 1; // don't forget to change it when the users could log in and have an id which can be retreated from $_SESSION
            $url = isset($_GET['url']) ? $_GET['url'] : '';
            extract($_GET);
            $page = isset($_GET['page']) ? $_GET['page'] : '';
            
            if ($url === 'operation') {
                switch ($page) {
                    case "createOperation" :
                        
                        // Filtering and sanitizing input values came from $_POST
                        $compte_id = filter_var($_POST['compte_id'], FILTER_VALIDATE_INT); // Validate as int
                        $compte_destinataire_id = !empty($_POST['compte_destinataire_id']) ? filter_var($_POST['compte_destinataire_id'], FILTER_VALIDATE_INT) : null;
                        $timestamp = htmlspecialchars(trim($_POST['timestamp']), ENT_QUOTES, 'UTF-8'); // Sanitize string input
                        $montant = filter_var($_POST['montant'], FILTER_VALIDATE_FLOAT); // Validate as float
                        $type_id = filter_var($_POST['type_id'], FILTER_VALIDATE_INT);
                        $categorie_id = filter_var($_POST['categorie_id'], FILTER_VALIDATE_INT);
                        $souscategorie_id = filter_var($_POST['souscategorie_id'], FILTER_VALIDATE_INT);

                        // Check for any validation failures
                        if ($type_id === false || $montant === false || $compte_id === false || 
                            $categorie_id === false || $souscategorie_id === false) {
                            // Handle invalid inputs
                            die('Invalid form input.');
                        }
                    
                        // Create an array of sanitized data
                        $data = [
                            'type_id' => $type_id,
                            'timestamp' => $timestamp,
                            'montant' => $montant,
                            'compte_id' => $compte_id,
                            'compte_destinataire_id' => $compte_destinataire_id, // Can be null
                            'categorie_id' => $categorie_id,
                            'souscategorie_id' => $souscategorie_id,
                            'client_id' => $clientId,
                        ];
                        $operationManager->insert($data);
                        // Redirect or return
                        header("Location: index.php?page=apercu");
                        exit;
                    case "modifyOperation" :
                        
                        $operationManager->update($data);
                        // Redirect or return
                        header("Location: index.php?page=apercu");
                        break;
                    case "deleteOperation" :
                        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
                        $operationManager->delete($id);
                        // Redirect or return
                        header("Location: index.php?page=apercu");
                        break;
                }
            }
        }
    }