<?php
$host     = 'localhost';              // o el host que te indique tu proveedor
$port     = '3306';                   // opcional, si tu host lo requiere
$dbname   = 'u175004361_LilianaDesign';  // tu base de datos
$username = 'u175004361_LilianaOlv';  // tu usuario MySQL
$password = 'eJiLv[EqGy7@';// ¡TU contraseña real aquí!
$charset  = 'utf8mb4';

$dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Nota los cuatro argumentos: dsn, usuario, contraseña, opciones
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}

if (!defined('UPLOAD_DIR')) {
    define('UPLOAD_DIR', __DIR__ . '/../uploads/');
}
if (!defined('UPLOAD_URL')) {
    define('UPLOAD_URL', '/uploads/');
}
?>