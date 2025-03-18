<?php

    namespace App\Controller;
    
    use App\Model\Manager;
    use App\Model\EntityManager;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use DateTime;

    require_once "vendor/autoload.php"; // PHPMailer & other dependencies
    require_once "config/parametre.php"; // SMTP credentials

    class ForgotPasswordLogicController extends Manager {
        public function __construct() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
    
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST["email"] ?? '';
    
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo json_encode(["success" => false, "message" => "Adresse e-mail invalide."]);
                    exit;
                }
    
                $clientManager = new EntityManager("client", "Client");
                $client = $clientManager->findOne(["email" => $email], "object");
    
                if ($client) {
                    // Generate a unique token
                    $token = bin2hex(random_bytes(32));
                    date_default_timezone_set("Europe/Paris"); // Ensure correct timezone
                    $expires = (new DateTime())->modify('+1 hour')->format('Y-m-d H:i:s'); // Token expires in 1 hour
    
                    // Update database with token
                    $clientManager->update([
                        "id" => $client->getId(),
                        "password_reset_token" => $token,
                        "token_expiration" => $expires,
                    ]);
    
                    // Send reset email
                    $resetLink = "http://localhost:8888//wallet/index.php?url=resetPassword&token=" . $token; // Adjust URL
                    $this->sendPasswordResetEmail($email, $resetLink);
                } else {
                    echo json_encode(["success" => false, "message" => "Aucun compte trouvé avec cet e-mail."]);
                }
            }
        }
    
        private function sendPasswordResetEmail($toEmail, $resetLink) {
            $mail = new PHPMailer(true);
    
            try {
                // SMTP Configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'sorokine.dimitri@gmail.com'; // Your Gmail address
                $mail->Password = POSTKEY; // Use an App Password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
    
                // Email Content
                $mail->setFrom('sorokine.dimitri@gmail.com', 'Wallet');
                $mail->addAddress($toEmail);
                $mail->Subject = 'Reinitialisation de votre mot de passe';
                $mail->Body = "Bonjour,\n\nCliquez sur ce lien pour réinitialiser votre mot de passe : $resetLink\n\nCe lien expirera dans 1 heure.";
    
                // Send Email
                if ($mail->send()) {
                    echo json_encode(["success" => true, "message" => "Un e-mail de réinitialisation a été envoyé. Vous pouvez fermer cette page."]);
                } else {
                    echo json_encode(["success" => false, "message" => "Erreur lors de l'envoi de l'e-mail."]);
                }
            } catch (Exception $e) {
                echo json_encode(["success" => false, "message" => "Erreur d'envoi: {$mail->ErrorInfo}"]);
            }
        }
    }