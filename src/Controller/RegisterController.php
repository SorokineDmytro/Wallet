<?php
namespace App\Controller;

use App\Model\Manager;
use App\Model\EntityManager;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class RegisterController extends Manager {
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
        
        // Validate all fields
        $errors = $this->validateInput($input);
        
        if (!empty($errors)) {
            echo json_encode(['success' => false, 'errors' => $errors]);
            return;
        }

        // Check if email already exists in the database
        $existingClient = $clientManager->findOne(['LOWER(email)' => strtolower($input['email'])], "array");
        if ($existingClient) {
            echo json_encode(['success' => false, 'message' => 'E-mail déjà enregistré ! Veuillez vous connecter.']);
            return;
        }

        // Hash password before saving
        $hashedPassword = password_hash($input['password'], PASSWORD_BCRYPT);

        // Save user to database
        $clientManager->insert([
            'nomclient' => $input['lastName'],
            'prenomclient' => $input['firstName'],
            'email' => $input['email'],
            'mot_de_passe' => $hashedPassword,
            'photo' => './public/img/avatars/unknown_user.png',
        ]);
        
        $this->sendRegisterEmail($input['email']);
        echo json_encode(['success' => true, 'message' => 'Inscription réussie ! Vous serez redirigé.']);
    }

    private function validateInput($input) {
        $errors = [];

        // Validate last name
        if (empty($input['lastName']) || !preg_match('/^[a-zA-ZÀ-ÿ]{2,}$/', trim($input['lastName']))) {
            $errors['lastName'] = 'Le nom doit comporter au moins 2 lettres, sans chiffres ni caractères spéciaux.';
        }

        // Validate first name
        if (empty($input['firstName']) || !preg_match('/^[a-zA-ZÀ-ÿ]{2,}$/', trim($input['firstName']))) {
            $errors['firstName'] = 'Le prénom doit comporter au moins 2 lettres, sans chiffres ni caractères spéciaux.';
        }

        // Validate email
        if (empty($input['email']) || !filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Format d\'e-mail invalide.';
        }

        // Validate password
        $password = $input['password'];
        if (empty($password) || strlen($password) < 8 || 
            !preg_match('/[a-z]/', $password) ||
            !preg_match('/[A-Z]/', $password) ||
            !preg_match('/\d/', $password) ||
            !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $errors['password'] = 'Le mot de passe doit comporter au moins 8 caractères et inclure une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.';
        }

        // Validate password confirmation
        if ($password !== $input['passwordConfirmation']) {
            $errors['passwordConfirmation'] = 'Les mots de passe ne correspondent pas.';
        }

        return $errors;
    }

    private function sendRegisterEmail($toEmail) {
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
            $mail->Subject = 'Bienvenue sur Wallet';
            $mail->Body = "Bonjour,\n\nMerci de vous être inscrit sur Wallet. Vous pouvez maintenant vous connecter.";
            $mail->send();
            
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Erreur d'envoi: {$mail->ErrorInfo}"]);
        }
    }
}