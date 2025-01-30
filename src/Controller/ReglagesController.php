<?php
    namespace App\Controller;

    use App\Model\Manager;
    use App\Model\EntityManager;

    class ReglagesController extends Manager {
        public function __construct() 
        {
            // Start the session if it's not already started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            // Prevent browser caching
            header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
            header("Pragma: no-cache"); // HTTP 1.0
            header("Expires: 0"); // Proxies

            // Check if the user is logged in
            if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['client_id'])) {
                $clientManager = new EntityManager('client', 'Client');
                $clientId = $_SESSION['client_id'];
                $file = "view/reglages/reglages.html.php";
                $title = "reglages";

                // CLIENT
                $client = $clientManager->findOne(['id' => $clientId], 'object');
                $clientInfo = [
                    'lastName' => $client->getNomclient(),
                    'firstName' => $client->getPrenomclient(),
                    'email' => $client->getEmail(),
                    'photo' => $client->getPhoto(),
                ];

                $variables = [
                    "title" => $title,
                    "clientInfo" => $clientInfo,
                ];
                $this -> generatePage($file, $variables);
            } else {
                // User is not logged in; redirect to the "wellcome" page
                header('Location: index.php?url=wellcome');
                exit;
            }
        }
    }