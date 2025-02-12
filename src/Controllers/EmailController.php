<?php
/**
 * EmailController handles all email-related operations
 * This is the main controller of our application
 */
class EmailController {
    /**
     * The index method is called when users visit our main page
     * It prepares data and shows the main template
     */
    public function index() {
        // Prepare data that we want to show in our template
        // For now, this is just test data
        $data = [
            'pageTitle' => 'Email Management System',
            'emails' => ['test@example.com', 'another@example.com']
        ];
        
        // Pass our data to the template
        // This will show the layout.php template with our data
        $this->render('layout', $data);
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
