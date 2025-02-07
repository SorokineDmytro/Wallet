<?php
    namespace App\Controller;

    use App\Model\Manager;
    use App\Model\EntityManager;

    class ClientController extends Manager {
        public function __construct() {
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
                
                switch ($_GET['page']) {
                    case 'information':
                        // Check if all required fields exist and are not empty
                        $errors = [];

                        if (!isset($_POST['lastName']) || empty(trim($_POST['lastName']))) {
                            $errors['lastName'] = "Le nom est requis.";
                        }

                        if (!isset($_POST['firstName']) || empty(trim($_POST['firstName']))) {
                            $errors['firstName'] = "Le prénom est requis.";
                        }

                        if (!isset($_POST['email']) || empty(trim($_POST['email']))) {
                            $errors['email'] = "L'adresse e-mail est requise.";
                        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                            $errors['email'] = "L'adresse e-mail n'est pas valide.";
                        }

                        // If errors exist, return a JSON response
                        if (!empty($errors)) {
                            echo json_encode(['success' => false, 'errors' => $errors]);
                            exit;
                        }

                        // If no errors, sanitize inputs and proceed
                        $lastName = htmlspecialchars(trim($_POST['lastName']));
                        $firstName = htmlspecialchars(trim($_POST['firstName']));
                        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

                        // Save user data to database
                        $clientManager->update([
                            'id' => $clientId,
                            'nomclient' => $lastName,
                            'prenomclient' => $firstName,
                            'email' => $email,
                        ]);

                        // Reddirection to the reglage page
                        header('Location: index.php?url=reglages');
                        break;
                    case 'password':
                        if (isset($_POST['new-password']) && isset($_POST['confirmation-password'])) {
                            $newPassword = $_POST['new-password'];
                            $confirmationPassword = $_POST['confirmation-password'];
                            if ($newPassword === $confirmationPassword) {
                                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                                // Save user data to database
                                $clientManager->update([
                                    'id' => $clientId,
                                    'mot_de_passe' => $hashedPassword,
                                ]);
                            }
                        }
                        
                        // Reddirection to the reglage page
                        header('Location: index.php?url=reglages');
                        break;
                    case 'photo':
                        // Get file details
                        $fileTmpPath = $_FILES['inputPhoto']['tmp_name'];  // Temporary path
                        $fileName = $_FILES['inputPhoto']['name'];  // Original file name
                        // $fileType = $_FILES['inputPhoto']['type'];  // File MIME type
                        // $fileSize = $_FILES['inputPhoto']['size'];  // File size

                        // Define the target directory
                        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/wallet/public/img/avatars/";  // Change this to your img directory path

                        // Ensure directory exists
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                    
                        // Generate a unique file name (optional: use user ID or timestamp)
                        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION); // Extract extension
                        $newFileName = $clientId . '.' . $fileExtension; // Rename file

                        // Set the destination path
                        $destination = $uploadDir . $newFileName;
                    
                        // Move the uploaded file to the img directory
                        if (move_uploaded_file($fileTmpPath, $destination)) {
                            echo "File uploaded successfully: " . $newFileName;
                        }
                        
                        // Save user photo to database
                        $clientManager->update([
                            'id' => $clientId,
                            'photo' => './public/img/avatars/'.$newFileName,
                        ]);

                        // Reddirection to the reglage page
                        header('Location: index.php?url=reglages');
                        break;
                    case 'delete':
                        session_destroy();

                        // Delete client from database
                        $clientManager->delete([
                            'id' => $clientId,
                        ]);
                        // Reddirection to the wellcome page
                        header('Location: index.php?url=wellcome');
                        break;
                }
            } else {
                // User is not logged in; redirect to the "wellcome" page
                header('Location: index.php?url=wellcome');
                exit;
            }
        }
    }