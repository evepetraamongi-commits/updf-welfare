<?php
// public/get-data.php
require_once __DIR__ . '/../config/database.php';

// Optimization Engine: Aggregate table sums cleanly directly inside PostgreSQL
$query = $pdo->query("SELECT aid_type, SUM(amount) as total_amount FROM disbursements GROUP BY aid_type");
$results = $query->fetchAll();

// Output the query strictly as structured system data text
header('Content-Type: application/json');
echo json_encode($results);
exit;