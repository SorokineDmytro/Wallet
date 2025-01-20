<?php


    namespace App\Controller;

    use App\Model\Manager;
    use App\Model\EntityManager;
    use DateTime;

    class AccountController extends Manager {
        public function __construct() {
            $compteManager = new EntityManager('compte', 'Compte');
            $clientId = 1; // don't forget to change it when the users could log in and have an id which can be retreated from $_SESSION
            $url = isset($_GET['url']) ? $_GET['url'] : '';
            extract($_GET);
            $page = isset($_GET['page']) ? $_GET['page'] : '';
            $date = new DateTime();
            $timestamp = $date->format('Y-m-d H:i:s');

            if ($url === 'account') {
                switch ($page) {
                    case "createAccount" :
                        // Filtering and sanitizing input values came from $_POST
                        $typecompte_id = filter_var($_POST['typecompte_id'], FILTER_VALIDATE_INT);
                        // Step 1: Trim whitespace
                        $numcompte = trim($_POST['numcompte']); 
                        // Step 2: Sanitize by allowing only letters, numbers, and some symbols (e.g., hyphens, spaces)
                        $numcompte = preg_replace("/[^a-zA-Z0-9\s\#\-\é\è\ê\ë\à\ä\â\ç\ù\û\ü\î\ï\É\È\Ê\Ë\À\Ä\Â\Ç\Ù\Û\Ü\Î\Ï]/u", "", $numcompte);
                        // Step 3: Optionally, use htmlspecialchars to escape HTML characters if outputting in HTML
                        $numcompte = htmlspecialchars($numcompte, ENT_QUOTES, 'UTF-8');
                        $color = htmlspecialchars(trim($_POST['color']), ENT_QUOTES, 'UTF-8');
                        $montant_initial = filter_var($_POST['montant_initial'], FILTER_VALIDATE_FLOAT);
                        $$timestamp = $timestamp;
                        $data = [
                            'client_id' => $clientId,
                            'numcompte' => $numcompte,
                            'typecompte_id' => $typecompte_id,
                            'montant_initial' => $montant_initial,
                            'color' => $color,
                            'date_creation' => $timestamp,
                        ];
                        $compteManager->insert($data);
                        // Redirect or return
                        $compteCreated = $compteManager->findOne(['numcompte' => $numcompte])->getId();
                        header("Location: index.php?page=apercu&acc_Id=$compteCreated");
                        exit;
                    case "modifyAccount" :
                        // Filtering and sanitizing input values came from $_POST
                        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
                        $typecompte_id = filter_var($_POST['typecompte_id'], FILTER_VALIDATE_INT);
                            // Step 1: Trim whitespace
                        $numcompte = trim($_POST['numcompte']); 
                            // Step 2: Sanitize by allowing only letters, numbers, and some symbols (e.g., hyphens, spaces)
                        $numcompte = preg_replace("/[^a-zA-Z0-9\s\#\-\é\è\ê\ë\à\ä\â\ç\ù\û\ü\î\ï\É\È\Ê\Ë\À\Ä\Â\Ç\Ù\Û\Ü\Î\Ï]/u", "", $numcompte);
                            // Step 3: Optionally, use htmlspecialchars to escape HTML characters if outputting in HTML
                        $numcompte = htmlspecialchars($numcompte, ENT_QUOTES, 'UTF-8');
                        $color = htmlspecialchars(trim($_POST['color']), ENT_QUOTES, 'UTF-8');
                        $montant_initial = filter_var($_POST['montant_initial'], FILTER_VALIDATE_FLOAT);
                        $data = [
                            'id' => $id,
                            'client_id' => $clientId,
                            'numcompte' => $numcompte,
                            'typecompte_id' => $typecompte_id,
                            'montant_initial' => $montant_initial,
                            'color' => $color
                        ];
                        $compteManager->update($data);
                        // Redirect or return
                        header("Location: index.php?page=apercu&acc_Id=$id");
                        break;
                    case "deleteAccount" :
                        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
                        $compteManager->delete($id);
                        // Redirect or return
                        header("Location: index.php?page=apercu");
                        break;
                }
            }
        }
    }
