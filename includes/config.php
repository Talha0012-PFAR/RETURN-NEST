<?php
// includes/config.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host   = 'localhost';
$dbname = 'lost_found_db';
$user   = 'root';
$pass   = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    exit('Database connection failed: ' . $e->getMessage());
}

function getDBConnection() {
    global $pdo;
    return $pdo;
}

require_once __DIR__ . '/functions.php';
