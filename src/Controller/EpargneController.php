<?php
    namespace App\Controller;
    
    use App\Model\Manager;
    use App\Model\EntityManager;
    use function PHPUnit\Framework\isTrue;

    class EpargneController extends Manager {
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
                $compteManager = new EntityManager('compte', 'Compte');
                $operationManager = new EntityManager('operation', 'Operation');
                $epargneManager = new EntityManager('epargne', 'Epargne');
                $clientId = $_SESSION['client_id'];
                $file = "view/epargne/epargne.html.php";
                $title = "épargne";

                // EPARGNE
                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['epargneData'])) {
                    $epargneData = json_decode($_POST['epargneData'], true);
                    // Retrieve form data
                    $montant_initial = floatval($epargneData['montant_initial'] ?? 0);
                    $contributions = floatval($epargneData['contributions'] ?? 100);
                    $periode_contributions = $epargneData['periode_contributions'] ?? 'month';
                    $taux_interet = floatval($epargneData['taux_interet'] ?? 0);
                    $periode_interet = $epargneData['periode_interet'] ?? 'year';
                    $nombre_annees = intval($epargneData['nombre_annees'] ?? 3);
                    // Check if data exists for this client
                    $existingData = $epargneManager->findOne(['client_id' => $clientId], 'array');

                    if ($existingData) {
                        // Update existing entry
                        $updateData = [
                            "id" => $existingData['id'],
                            "client_id" => $clientId,
                            "montant_initial" => $montant_initial,
                            "contributions" => $contributions,
                            "periode_contributions" => $periode_contributions,
                            "taux_interet" => $taux_interet,
                            "periode_interet" => $periode_interet,
                            "nombre_annees" => $nombre_annees,
                        ];
                        $epargneManager->update($updateData);
                    } else {
                        // Insert new entry
                        $newData = [
                            "client_id" => $clientId,
                            "montant_initial" => $montant_initial,
                            "contributions" => $contributions,
                            "periode_contributions" => $periode_contributions,
                            "taux_interet" => $taux_interet,
                            "periode_interet" => $periode_interet,
                            "nombre_annees" => $nombre_annees,
                        ];
                        $epargneManager->insert($newData);
                    }
                } else if($epargneManager->findOne(['client_id' => $clientId], 'array')) {
                    $epargneData = $epargneManager->findOne(['client_id' => $clientId], 'array');
                } else {
                    // No data sent
                    $epargneData = [
                        "montant_initial" => 0,
                        "contributions" => 0,
                        "periode_contributions" => "month",
                        "taux_interet" => 0,
                        "periode_interet" => "year",
                        "nombre_annees" => 1,
                    ];
                }
                $epargneDataJSON = json_encode($epargneData);

                // CLIENT
                $client = $clientManager->findOne(['id' => $clientId], 'object');
                $clientInfo = [
                    'lastName' => $client->getNomclient(),
                    'firstName' => $client->getPrenomclient(),
                    'email' => $client->getEmail(),
                    'photo' => $client->getPhoto(),
                ];

                // ACCOUNTS
                $savingAccounts = $compteManager->findAll(['client_id' => $clientId, 'typecompte_id' => 2], 'object', 'order by id asc');
                $formattedAccounts = [];
                foreach ($savingAccounts as $account) {
                    $formattedAccounts[] = [
                        'id' => $account->getId(),
                        'type' => $account->getTypecompte_id(),
                        'name' => $account->getNumcompte(),
                        'amount' => $account->getMontant_initial(),
                        'color' => $account->getColor(),
                        'creationTimestamp' => $account->getDate_creation(),
                    ];
                }
                $savingAccountsJSON = json_encode($formattedAccounts);

                // OPERATIONS 
                // Get all operations by client
                $operationsTotalByClient = $operationManager->findAll(['client_id'=>$clientId], "array", "order by id");
                $operationsTotalByClientJSON = json_encode($operationsTotalByClient);

                $variables = [
                    "title" => $title,
                    "clientInfo" => $clientInfo,
                    "savingAccountsJSON" => $savingAccountsJSON,
                    "operationsTotalByClientJSON" => $operationsTotalByClientJSON,
                    "epargneDataJSON" => $epargneDataJSON,
                ];
                $this -> generatePage($file, $variables);
            } else {
                // User is not logged in; redirect to the "wellcome" page
                header('Location: index.php?url=wellcome');
                exit;
            }
        }
    }


