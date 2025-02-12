<?php
// This is our entry point - the first file that executes

// 1. Show errors during development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Define the root path of our application
define('ROOT_PATH', dirname(__DIR__));

// For now, let's just make sure our setup works
echo "Hello! The Email Management System is starting...";
