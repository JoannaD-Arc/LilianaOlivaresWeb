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
    // Obtener datos existentes
    $stmt = $pdo->prepare('SELECT * FROM renders WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $r = $stmt->fetch();
    if (!$r) {
        throw new Exception('Render no encontrado.');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $proyecto = $_POST['nombre_proyecto'] ?? '';
        $software = $_POST['software_utilizado'] ?? '';
        if (empty($proyecto) || empty($software)) {
            throw new Exception('Proyecto y software son obligatorios.');
        }

        // Procesar nueva imagen si se subió una
        if (!empty($_FILES['imagen']['name']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nuevoNombre = time() . '_' . basename($_FILES['imagen']['name']);
            $destino = UPLOAD_DIR . $nuevoNombre;
            if (!is_dir(UPLOAD_DIR) && !mkdir(UPLOAD_DIR, 0755, true)) {
                throw new Exception('No se pudo crear la carpeta de uploads.');
            }
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
                throw new Exception('Error al subir nueva imagen.');
            }
            // Borrar imagen antigua
            $antigua = UPLOAD_DIR . $r['imagen'];
            if (!empty($r['imagen']) && file_exists($antigua)) {
                unlink($antigua);
            }
            $imagenParaGuardar = $nuevoNombre;
        } else {
            $imagenParaGuardar = $r['imagen'];
        }

        // Actualizar en la base de datos
        $upd = $pdo->prepare('UPDATE renders SET nombre_proyecto = :proyecto, software_utilizado = :software, imagen = :imagen WHERE id = :id');
        $upd->execute([
            ':proyecto' => $proyecto,
            ':software' => $software,
            ':imagen'   => $imagenParaGuardar,
            ':id'       => $id,
        ]);

        header('Location: ../miTrabajo.php');
        exit;
    }
} catch (Exception $e) {
    die('Error al actualizar render: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Render</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/addRender.css">
</head>
<body>
  <div class="container">
    <h2>Editar Render #<?= htmlspecialchars($r['id']) ?></h2>
    <form action="editRender.php?id=<?= htmlspecialchars($r['id']) ?>" method="post" enctype="multipart/form-data">
      <label for="nombre_proyecto">Nombre del Proyecto:</label>
      <input
        type="text"
        id="nombre_proyecto"
        name="nombre_proyecto"
        value="<?= htmlspecialchars($r['nombre_proyecto']) ?>"
        required
      >

      <label for="software_utilizado">Software Utilizado:</label>
      <input
        type="text"
        id="software_utilizado"
        name="software_utilizado"
        value="<?= htmlspecialchars($r['software_utilizado']) ?>"
        required
      >

      <label>Imagen Actual:</label>
      <div style="text-align:center; margin-bottom:1rem;">
        <img
          src="uploads/<?= htmlspecialchars($r['imagen']) ?>"
          alt="Render #<?= htmlspecialchars($r['id']) ?>"
          style="max-width:100%; border-radius:0.25rem;"
        >
      </div>

      <label for="imagen">Cambiar Imagen (opcional):</label>
      <input type="file" id="imagen" name="imagen" accept="image/*">

      <button type="submit">Actualizar</button>
      <a href="miTrabajo.php" class="cancel-btn">Cancelar</a>
    </form>
  </div>
</body>
</html>
