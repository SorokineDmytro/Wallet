<?php
namespace App\Controller;

use App\Model\Manager;

class LoginController extends Manager {
    public function __construct() {
        header('Content-Type: application/json');
        
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            return;
        }
        
        // Parse JSON input
        $input = json_decode(file_get_contents('php://input'), true);
        
        // Handle logout request
        if (isset($input['logout']) && $input['logout'] === true) {
            // Start session if not already started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Destroy the session
            session_destroy();
            echo json_encode(['success' => true, 'message' => 'Déconnexion réussie !']);
            return;
        }
        
        // Handle login request
        if (!isset($input['email']) || !isset($input['password'])) {
            echo json_encode(['success' => false, 'message' => 'Email ou mot de passe manquant.']);
            return;
        }
        
        $email = $input['email'];
        $password = $input['password'];

        // Query the database
        $query = "SELECT * FROM client WHERE email = :email";
        $stmt = $this->getConnexion()->prepare($query);
        $stmt->execute(['email' => $email]);
        $client = $stmt->fetch();

        if ($client) {
            if (password_verify($password, $client['mot_de_passe'])) {
                // Start session if not already started
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['client_id'] = $client['id'];
                echo json_encode([
                    'success' => true,
                    'message' => 'Connexion réussie !',
                    'clientId' => $client['id'],
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Mot de passe invalide.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Aucun utilisateur trouvé avec cet email.']);
        }
    }
}
