<?php
    namespace App\Controller;

    use App\Model\Manager;
    use App\Model\EntityManager;

    require_once "vendor/autoload.php";

    class ResetPasswordLogicController extends Manager {
        public function __construct() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $token = $_POST["token"] ?? '';
                $newPassword = $_POST["password"] ?? '';

                if (empty($token) || empty($newPassword)) {
                    echo json_encode(["success" => false, "message" => "Tous les champs sont obligatoires."]);
                    exit;
                }

                $clientManager = new EntityManager("client", "Client");
                $client = $clientManager->findOne(["password_reset_token" => $token], "object");

                if ($client) {
                    // Check token expiration
                    if (strtotime($client->getToken_expiration()) < time()) {
                        echo json_encode(["success" => false, "message" => "Le lien de réinitialisation a expiré."]);
                        exit;
                    }

                    // Hash the new password
                    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

                    // Update password in DB
                    $clientManager->update([
                        "id" => $client->getId(),
                        "mot_de_passe" => $hashedPassword,
                        "password_reset_token" => null, // Remove the token after use
                        "token_expiration" => null,
                    ]);

                    echo json_encode([
                        "success" => true, 
                        "message" => "Votre mot de passe a été mis à jour avec succès.\n Vous serez redirigé vers la page de connexion.",
                        "redirect" => "index.php?url=wellcome",
                    ]);
                } else {
                    echo json_encode(["success" => false, "message" => "Token invalide."]);
                }
            }
        }
    }
