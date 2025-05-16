<?php
session_start();
require 'PHP/config.php';

$stmt = $pdo->query("SELECT * FROM renders ORDER BY id DESC");
$renders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-GRR9HMZQRP"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-GRR9HMZQRP');
</script>
    <meta charset="UTF-8">
    <title>Mi Trabajo</title>
    <link rel="stylesheet" href="CSS/contacto.css">
    <link rel="stylesheet" href="CSS/miTrabajo.css">
    <link rel="stylesheet" href="CSS/modal.css">
</head>
<body>
    <!-- HEADER MOBILE -->
<div class="mobile-header">
  <div class="menu-icon" onclick="toggleMenu()">
    <span></span>
    <span></span>
    <span></span>
  </div>
  <div class="logo-horizontal">LILIANA OLIVARES</div>
</div>

<!-- HEADER MOBILE -->
 
<!-- SIDEBAR -->

    <div class="sidebar">
      <div class="menu-icon" onclick="toggleMenu()" role="button" aria-label="Abrir menú lateral">
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="logo-vertical">LILIANA OLIVARES</div>
    </div>
    
    <nav class="menu-slide" id="menuSlide">
      <div class="menu-header">
        <div class="logo">LILIANA OLIVARES</div>
        <div class="close-btn" onclick="toggleMenu()">×</div>
      </div>
      
      <div class="menu-items">
        <a href="index.html">INICIO</a>
        <a href="sobreMi.html">ACERCA DE MI</a>
        <a href="miTrabajo.php">MI TRABAJO</a>
        <a href="misServicios.html">MIS SERVICIOS</a>
        <a href="testimonios.html">TESTIMONIOS</a>
        <a href="contacto.html">CONTACTO</a>
      </div>
      
      <div class="menu-footer">
        <div class="contact-info">
          <p>+52 656 600 8080</p>
          <p>lilianaolivares@lilianaolivares.site</p>
        </div>
      </div>
    </nav>

<!-- SIDEBAR -->

    <div class="container">
  <h1>Catálogo de Renders</h1>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Proyecto</th>
        <th>Software</th>
        <th>Imagen</th>
        <?php if (!empty($_SESSION['is_admin'])): ?>
          <th>Acciones</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($renders as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['id']) ?></td>
          <td><?= htmlspecialchars($r['nombre_proyecto']) ?></td>
          <td class="software-cell">
            <?= htmlspecialchars($r['software_utilizado']) ?>
            </td>

    <td>
      <img 
        src="uploads/<?= htmlspecialchars($r['imagen']) ?>" 
        alt="<?= htmlspecialchars($r['nombre_proyecto']) ?>" 
        class="render-thumb" 
      />
    </td>

          <?php if (!empty($_SESSION['is_admin'])): ?>
            <td>
              <a href="PHP/editRender.php?id=<?= $r['id'] ?>">Editar</a> |
              <a
                href="PHP/deleteRender.php?id=<?= $r['id'] ?>"
                onclick="return confirm('¿Eliminar este render?')"
              >
                Eliminar
              </a>
            </td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <?php if (!empty($_SESSION['is_admin'])): ?>
    <a href="PHP/addRender.php" class="add-render">Agregar nuevo render</a>
  <?php endif; ?>
</div>

<div id="img-modal" class="img-modal" style="display: none;">
  <img id="modal-img" src="" alt="Imagen ampliada">
</div>



    <script src="JS/contacto.js"></script>

    <script src="JS/modal.js"></script>
</body>
</html>
