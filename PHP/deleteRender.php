<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (empty($_SESSION['is_admin'])) {
    header('Location: ../login.php');
    exit;
}

require 'config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: ../miTrabajo.php');
    exit;
}

try {
    // Obtener nombre de la imagen para borrarla
    $stmt = $pdo->prepare('SELECT imagen FROM renders WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $r = $stmt->fetch();

    if ($r && !empty($r['imagen'])) {
        $path = UPLOAD_DIR . $r['imagen'];
        if (file_exists($path) && !unlink($path)) {
            throw new Exception('No se pudo borrar la imagen antigua.');
        }
    }

    // Borrar registro de la base de datos
    $del = $pdo->prepare('DELETE FROM renders WHERE id = :id');
    $del->execute([':id' => $id]);

    header('Location: ../miTrabajo.php');
    exit;
} catch (Exception $e) {
    die('Error al borrar render: ' . $e->getMessage());
}
?>
