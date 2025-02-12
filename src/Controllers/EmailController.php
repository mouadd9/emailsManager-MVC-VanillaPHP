<?php
/**
 * EmailController handles all email-related operations
 * This is the main controller of our application
 */
class EmailController {
    private $emailService;

    // dependency injection
    public function __construct(IEmailService $emailService) {
        $this->emailService = $emailService;
    }

    // The index method is called when users visit our main page
    // It prepares data and shows the main template
    public function index() {
        // Get emails from service
        $data = [
            'pageTitle' => 'Email Management System',
            'emails' => $this->emailService->getEmails()
        ];
        
        // Pass our data to the template
        $this->render('layout', $data);
    }
    
    // Handle AJAX requests from our JavaScript
    public function handleRequest() { // Returns JSON response
        // Tell browser we're sending JSON
        header('Content-Type: application/json');
        
        $action = $_POST['action'] ?? '';
        
        // Handle different actions
        switch($action) {
            case 'addEmail':
                $email = $_POST['email'] ?? '';
                // Delegate to email service
                $result = $this->emailService->addEmail($email); 
                echo json_encode($result);
                break;
                
            default:
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid action'
                ]);

                /*
                {
                    "success" : false,
                    "message" : "Invalid action"
                } 
                
                */
        }
    }
    
    /**
     * The render method processes our template with data
     * This is where PHP actually generates the HTML
     * 
     * @param string $template The template file to use (without .php)
     * @param array $data Data to pass to the template
     */
    private function render($template, $data) {
        // Convert array keys to variables
        // After this, $data['pageTitle'] becomes $pageTitle
        extract($data);
        
        // Include and process the template file
        // THIS IS WHERE THE HTML IS GENERATED!
        // PHP reads the template file and outputs it directly
        require_once ROOT_PATH . "/src/Views/{$template}.php";
    }
}
