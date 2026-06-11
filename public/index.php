<?php
// public/index.php
session_start();
require_once __DIR__ . '/../config/database.php';

// Grab the web address path the user is trying to look at
$request = $_SERVER['REQUEST_URI'];

// Clean up any trailing slashes or extra text at the end of the URL
$path = parse_url($request, PHP_URL_PATH);

// The Router Switcher: Tells the server exactly which file to open
switch ($path) {
    // FIX: If they visit the main website address (e.g., updf-welfare.onrender.com/)
    case '/':
    case '/index.php':
        // Show the registration forms page directly
        require_once __DIR__ . '/index.php'; 
        break;

    case '/dashboard':
    case '/dashboard.php':
        require_once __DIR__ . '/dashboard.php';
        break;

    case '/get-data.php':
    case '/api/analytics-data':
        require_once __DIR__ . '/get-data.php';
        break;

    default:
        // If they type a broken web link that doesn't exist
        http_response_code(404);
        echo "404 - Page Not Found. Please return to the home page.";
        break;
}
