<?php
// config/database.php

// 1. Fetch connection instructions from Render's environment settings
$dbUrl = getenv('DATABASE_URL');

if (!$dbUrl) {
    // Local fallback if testing on your computer's XAMPP
    $host = "127.0.0.1";
    $user = "postgres";
    $password = "password";
    $dbname = "updf_welfare_db";
    $port = "5432";
} else {
    // Automatically split Render's secure URL string into individual components
    $dbopts = parse_url($dbUrl);
    $host = $dbopts['host'];
    $port = $dbopts['port'];
    $user = $dbopts['user'];
    $password = $dbopts['pass'];
    $dbname = ltrim($dbopts['path'], '/');
}

// 2. Open the connection gate
try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Database Connection Error: " . $e->getMessage());
}
?>