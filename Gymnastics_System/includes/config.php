<?php
// Purpose: Application configuration and environment defaults.

$DB_HOST = getenv('DB_HOST') ?: 'localhost';
$DB_NAME = getenv('DB_NAME') ?: 'gymnastics_system';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: 'Terryfolds123#';

if (!defined('APP_NAME')) {
    define('APP_NAME', 'Gymnastics Training System');
}

if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/Gymnastics_System');
}
?>
