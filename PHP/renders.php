<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD']==='OPTIONS') exit;
require_once __DIR__ . '/config.php';
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);
switch($method){
  case 'GET':
    if (!empty($_GET['id'])) {
      $stmt = $pdo->prepare("SELECT * FROM renders WHERE id=?");
      $stmt->execute([$_GET['id']]);
      $data = $stmt->fetch();
    } else {
      $data = $pdo->query("SELECT * FROM renders ORDER BY id DESC")->fetchAll();
    }
    echo json_encode($data);
    break;
  case 'POST':
    $stmt = $pdo->prepare("INSERT INTO renders (nombre_proyecto,software_utilizado,imagen) VALUES (?,?,?)");
    $stmt->execute([
      $input['nombre_proyecto'],
      $input['software_utilizado'],
      basename($input['ruta_imagen'])
    ]);
    echo json_encode(['status'=>'created','id'=>$pdo->lastInsertId()]);
    break;
  case 'PUT':
    $stmt = $pdo->prepare("UPDATE renders SET nombre_proyecto=?,software_utilizado=?,imagen=? WHERE id=?");
    $stmt->execute([
      $input['nombre_proyecto'],
      $input['software_utilizado'],
      basename($input['ruta_imagen']),
      $input['id']
    ]);
    echo json_encode(['status'=>'updated']);
    break;
  case 'DELETE':
    if (empty($_GET['id'])) { http_response_code(400); echo json_encode(['error'=>'id_missing']); exit; }
    // Opcional: borrar el archivo previo
    $id = $_GET['id'];
    $row = $pdo->prepare("SELECT imagen FROM renders WHERE id=?");
    $row->execute([$id]);
    if ($img = $row->fetchColumn()) {
      @unlink(UPLOAD_DIR.$img);
    }
    $pdo->prepare("DELETE FROM renders WHERE id=?")->execute([$id]);
    echo json_encode(['status'=>'deleted']);
    break;
  default:
    http_response_code(405);
    echo json_encode(['error'=>'method_not_allowed']);
}
