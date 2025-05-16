<?php
session_start();
// Para depurar, muéstrame errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (empty($_SESSION['is_admin'])) {
    header('Location: ../login.php');
    exit;
}

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 1) Validar campos
        $proyecto = trim($_POST['proyecto'] ?? '');
        $software = trim($_POST['software'] ?? '');
        if ($proyecto === '' || $software === '') {
            throw new Exception('Proyecto y software son obligatorios.');
        }
        // 2) Subir imagen
        if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Error al subir la imagen.');
        }
        $tmp = $_FILES['imagen']['tmp_name'];
        $nombreArchivo = time() . '_' . basename($_FILES['imagen']['name']);
        move_uploaded_file($tmp, __DIR__ . '/../uploads/' . $nombreArchivo);

        // 3) Insertar en la BBDD
        $stmt = $pdo->prepare(
            'INSERT INTO renders (nombre_proyecto, software_utilizado, imagen)
             VALUES (:proyecto, :software, :imagen)'
        );
        $stmt->execute([
            ':proyecto' => $proyecto,
            ':software' => $software,
            ':imagen'   => $nombreArchivo,
        ]);

        // 4) Redirigir al listado
        header('Location: ../miTrabajo.php');
        exit;
    } catch (Exception $e) {
        die('Error al agregar render: ' . $e->getMessage());
    }
}

// Si llegamos aquí, es GET: muestro el formulario
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Render</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/addRender.css">
</head>
<body>
  <div class="container">
    <h2>Agregar Nuevo Render</h2>
    <form action="addRender.php" method="post" enctype="multipart/form-data">
      <label for="nombre_proyecto">Nombre del Proyecto:</label>
      <input type="text" id="nombre_proyecto" name="nombre_proyecto" required>

      <label for="software_utilizado">Software Utilizado:</label>
      <input type="text" id="software_utilizado" name="software_utilizado" required>

      <label for="imagen">Imagen:</label>
      <input type="file" id="imagen" name="imagen" accept="image/*" required>

      <button type="submit">Agregar Render</button>
      <a href="../miTrabajo.php" class="cancel-btn">Cancelar</a>
    </form>
  </div>
</body>
</html>
