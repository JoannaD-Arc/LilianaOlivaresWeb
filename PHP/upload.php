<?php
// ———————– DEBUG ———————–
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ————————————————
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

// Ajusta la ruta si config.php está en la misma carpeta:
require_once __DIR__ . '/config.php';

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;
require __DIR__ . '/../PHP/config.php';
if (empty($_FILES['imagen']['tmp_name'])) {
  http_response_code(400);
  echo json_encode(['error'=>'imagen_missing']);
  exit;
}
$name = time().'_'.basename($_FILES['imagen']['name']);
if (!move_uploaded_file($_FILES['imagen']['tmp_name'], UPLOAD_DIR.$name)) {
  http_response_code(500);
  echo json_encode(['error'=>'upload_failed']);
  exit;
}
echo json_encode(['status'=>'ok','ruta_imagen'=>UPLOAD_URL.$name]);
