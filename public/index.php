<?php
/**
 * Entry point of our application
 * This is the first file that executes when someone visits our website
 */

// Enable full error reporting during development
// This helps us see any mistakes immediately
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define the root path of our application
// dirname(__DIR__) gives us the parent directory of 'public'
define('ROOT_PATH', dirname(__DIR__));

// Load our controller file
// Without this, PHP wouldn't know about our EmailController class
require_once ROOT_PATH . '/src/Controllers/EmailController.php';

// Create an instance of our controller and call its index method
// This starts the whole process of showing our page
$controller = new EmailController();
$controller->index();
