<?php
    namespace App\Controller;
    
    use App\Model\Manager;
    use App\Model\EntityManager;
    
    class LoginController extends Manager {
        public function __construct() {
            header('Content-Type: application/json');
        
            $clientManager = new EntityManager('client', 'Client');
            
            // Ensure the request method is POST
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
            
            // Validate email
            $email = filter_var($input['email'], FILTER_VALIDATE_EMAIL);
            if (!$email) {
                echo json_encode(['success' => false, 'message' => 'Format d\'email est invalide.']);
                return;
            }
            
            // Use the password as is (no sanitization)
            $password = $input['password'];
            if (empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Le mot de passe ne peut pas être vide.']);
                return;
            }
        
            // Find the client by email from the database
            $client = $clientManager->findOne(['email' => $email], 'object');
        
            // Check if the client exists and the password is correct
            if ($client && $client->getId() !== null) {
                if (password_verify($password, $client->getMot_de_passe())) {
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['client_id'] = $client->getId();
                    echo json_encode([
                        'success' => true,
                        'message' => 'Connexion réussie !',
                        'clientId' => $client->getId(),
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Mot de passe est invalide.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Aucun utilisateur trouvé avec cet email.']);
            }
        }
    }