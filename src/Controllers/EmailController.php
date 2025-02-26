<?php
/**
 * EmailController handles all email-related operations
 * This is the main controller of our application
 */
class EmailController
{
    private $emailService;

    // dependency injection
    public function __construct(IEmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    // The index method is called when users visit our main page
    // It prepares data and shows the main template
    public function index()
    {
        // Prepare data for template
        $data = [
            'pageTitle' => 'Gestion des Emails',
            'validEmails' => $this->emailService->getEmails(),
            'invalidEmails' => $this->emailService->getInvalidEmails(),
            'domainEmails' => $this->emailService->getEmailsByDomain(),
            'sortedEmails' => $this->emailService->getSortedEmails()
        ];

        // Show template with data
        $this->render('layout', $data);
    }

    // Handle AJAX requests from our JavaScript
    public function handleRequest()
    { // Returns JSON response
        // Tell browser we're sending JSON
        header('Content-Type: application/json');

        $action = $_POST['action'] ?? '';

        try {
            // Handle different actions
            switch ($action) {
                case 'addEmail':
                    $emailAddress = $_POST['email'] ?? '';
                    // Delegate to email service
                    $result = $this->emailService->addEmail($emailAddress);
                    $response = array_merge($result, $this->getTablesView());
                    break;

                case 'validateEmails':
                case 'verifierAdresses':
                    $result = $this->emailService->validateEmails();
                    $response = array_merge($result, $this->getTablesView());
                    break;

                case 'afficherFrequences':
                    $result = $this->emailService->getEmailFrequencies();
                    ob_start();
                    extract(['frequencies' => $result['data']]);
                    require ROOT_PATH . "/src/Views/partial/frequency_table.php";
                    $result['html'] = ob_get_clean();
                    $response = $result;
                    break;

                case 'supprimerDoublons':
                    $result = $this->emailService->removeDuplicates();
                    $response = array_merge($result, $this->getTablesView());
                    break;

                case 'trierEmails':
                    $result = $this->emailService->sortEmails();
                    $response = array_merge($result, $this->getTablesView());
                    break;

                case 'separerDomaines':
                    $result = $this->emailService->separateByDomain();
                    $response = array_merge($result, $this->getTablesView());
                    break;

                case 'verifierDomaines':
                    $result = $this->emailService->getNonExistentDomains();
                    ob_start();
                    extract(['nonexistentDomains' => $result['data']]);
                    require ROOT_PATH . "/src/Views/partial/nonexistent_domains.php";
                    $result['html'] = ob_get_clean();
                    $response = $result;
                    break;

                case 'exportEmails':
                    $type = $_POST['type'] ?? '';
                    $emails = [];
                    
                    switch($type) {
                        case 'valid':
                            $emails = $this->emailService->getEmails();
                            $filename = 'valid_emails.txt';
                            break;
                        case 'invalid':
                            $emails = $this->emailService->getInvalidEmails();
                            $filename = 'invalid_emails.txt';
                            break;
                        case 'sorted':
                            $emails = $this->emailService->getSortedEmails();
                            $filename = 'sorted_emails.txt';
                            break;
                        case 'domain':
                            $domainEmails = $this->emailService->getEmailsByDomain();
                            $emails = [];
                            foreach ($domainEmails as $domain => $list) {
                                $emails[] = "[$domain]";
                                $emails = array_merge($emails, $list);
                                $emails[] = ""; // Empty line between domains
                            }
                            $filename = 'domain_emails.txt';
                            break;
                        case 'frequency':
                            $frequencies = $this->emailService->getEmailFrequencies()['data'];
                            $emails = [];
                            foreach ($frequencies as $email => $count) {
                                $emails[] = "$email: $count occurrence(s)";
                            }
                            $filename = 'email_frequencies.txt';
                            break;
                        case 'nonexistent':
                            $domains = $this->emailService->getNonExistentDomains()['data'];
                            foreach ($domains as $domain => $emails_list) {
                                $emails[] = "[$domain]";
                                $emails = array_merge($emails, $emails_list);
                                $emails[] = ""; // Empty line between domains
                            }
                            $filename = 'nonexistent_domains.txt';
                            break;
                        default:
                            $response = [
                                'success' => false,
                                'message' => 'Invalid export type'
                            ];
                            echo json_encode($response);
                            return;
                    }

                    // Set headers for file download
                    header('Content-Type: text/plain');
                    header('Content-Disposition: attachment; filename="' . $filename . '"');
                    header('Content-Length: ' . strlen(implode("\n", $emails)));
                    header('Cache-Control: private');
                    header('Pragma: public');

                    echo implode("\n", $emails);
                    exit;

                default:
                    $response = [
                        'success' => false,
                        'message' => 'Invalid action'
                    ];
            }
        } catch (Exception $e) {
            // Log the error
            error_log($e->getMessage());
            $response = [
                'success' => false,
                'message' => 'An unexpected error occurred'
            ];
        }

        echo json_encode($response);
    }

    /**
     * The render method processes our template with data
     * This is where PHP actually generates the HTML
     * 
     * @param string $template The template file to use (without .php)
     * @param array $data Data to pass to the template
     */
    private function render($template, $data)
    {
        // Convert array keys to variables
        // After this, $data['pageTitle'] becomes $pageTitle
        extract($data);

        // Include and process the template file
        // THIS IS WHERE THE HTML IS GENERATED!
        // PHP reads the template file and outputs it directly
        require_once ROOT_PATH . "/src/Views/{$template}.php";
    }

    /**
     * Get updated content for AJAX requests
     */
    private function getTablesView(): array
    {
        $data = [
            'validEmails' => $this->emailService->getEmails(),
            'invalidEmails' => $this->emailService->getInvalidEmails(),
            'domainEmails' => $this->emailService->getEmailsByDomain(),
            'sortedEmails' => $this->emailService->getSortedEmails()
        ];
        return [
            'html' => $this->renderPartial($data)
        ];
    }

    /**
     * Render partial content for AJAX updates
     */
    private function renderPartial(array $data): string
    {
        ob_start();
        extract($data);
        require ROOT_PATH . "/src/Views/partial/tables.php";
        return ob_get_clean();
    }

    public function uploadFile()
    {
        if (!isset($_FILES['emailFile']) || $_FILES['emailFile']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = "Erreur lors du téléchargement du fichier";
            header('Location: index.php');
            return;
        }

        $tmpName = $_FILES['emailFile']['tmp_name'];
        $content = file_get_contents($tmpName);
        
        if ($content === false) {
            $_SESSION['error'] = "Impossible de lire le contenu du fichier";
            header('Location: index.php');
            return;
        }

        // Copier le fichier vers data/emails.txt
        if (!copy($tmpName, ROOT_PATH . '/data/emails.txt')) {
            $_SESSION['error'] = "Impossible de sauvegarder le fichier";
            header('Location: index.php');
            return;
        }

        $_SESSION['success'] = "Le fichier a été téléchargé avec succès";
        header('Location: index.php');
    }
}
