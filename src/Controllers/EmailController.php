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
}
