<?php
// Database connection using PDO
// Update the credentials below with your Hostinger MySQL details
$DB_HOST = 'localhost';      // e.g. localhost
$DB_NAME = 'u775031495_portafolio';    // database name
$DB_USER = 'u775031495_jcadenas';  // database user
$DB_PASS = 'Gm38L/[r@';       // database password

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4", $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    // For production you may want to log the error instead of displaying it
    exit('Database connection failed: ' . $e->getMessage());
}
?>
