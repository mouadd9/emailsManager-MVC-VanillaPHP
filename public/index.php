<?php
/* 
Entry point of our application : 
This is the first file that executes when someone visits our website 
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define the root path of our application
// dirname(__DIR__) gives us the parent directory of 'public'
define('ROOT_PATH', dirname(__DIR__)); // C:\Users\pepe\Desktop\Web PHP\Email-Management

// Load interfaces first
require_once ROOT_PATH . '/src/Repository/IEmailRepository.php';
require_once ROOT_PATH . '/src/Services/IEmailService.php';

// Load implementations
require_once ROOT_PATH . '/src/Repository/implementations/FileEmailRepositoryImpl.php';
require_once ROOT_PATH . '/src/Services/implementations/EmailServiceImpl.php';
require_once ROOT_PATH . '/src/Controllers/EmailController.php';

// Set up dependency injection
$repository = new FileEmailRepositoryImpl(ROOT_PATH . '/data/emails.txt');
$emailService = new EmailServiceImpl($repository);
$controller = new EmailController($emailService);

// Start session for flash messages
session_start();

// Check if this is an AJAX request or file upload
if (!empty($_POST['action'])) {
    $controller->handleRequest(); // Handle AJAX request
} elseif (isset($_GET['action']) && $_GET['action'] === 'uploadFile') {
    $controller->uploadFile(); // Handle file upload
} else {
    $controller->index(); // Show the main page
}


/*
Browser → Web Server (Apache/Nginx) → PHP → Your Code

first : JavaScript sends POST request to index.php (AJAX call)

Before executing index.php PHP automatically:
 - Receives the request
 - Sees it's a POST request (checks the method)
 - Takes the body data: action=addEmail&email=test@example.com
 - Parses it into $_POST array
   $_POST = [
    'action' => 'addEmail',
    'email' => 'test@example.com'
   ];
 - THEN starts executing index.php

*/