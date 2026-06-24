<?php
// Purpose: Shared PDO connection helper for all PHP pages.
require_once __DIR__ . '/config.php';

function getDbConnection()
{
    global $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS;

    try {
        $dsn = 'mysql:host=' . $DB_HOST . ';dbname=' . $DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        error_log('DB connection failed: ' . $e->getMessage());
        throw new Exception('Unable to connect to the database. Please check your settings.');
    }
}
?>
