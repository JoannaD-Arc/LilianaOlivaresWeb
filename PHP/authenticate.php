<?php
session_start();
require 'config.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Buscamos el usuario por nombre
$stmt = $pdo->prepare(
    "SELECT id, password, role 
     FROM usuarios 
     WHERE username = :username 
     LIMIT 1"
);
$stmt->execute(['username' => $username]);
$user = $stmt->fetch();

if (!$user) {
    die('Usuario no encontrado.');
}

// Verificamos que sea admin según el campo role
if ($user['role'] !== 'admin') {
    die('No tienes permisos de administración.');
}

// Verificamos la contraseña (asegúrate de haberla almacenado con password_hash)
if (!password_verify($password, $user['password'])) {
    die('Contraseña incorrecta.');
}

// Si todo OK, creamos la sesión
$_SESSION['user_id']  = $user['id'];
$_SESSION['username'] = $username;
$_SESSION['role']     = $user['role'];
$_SESSION['is_admin'] = true;

header('Location: ../miTrabajo.php');
exit;
