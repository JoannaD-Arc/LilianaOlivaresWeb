<?php
session_start();
// Ajusta la ruta según tu estructura de carpetas
require __DIR__ . '/../PHP/config.php';

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Por favor completa todos los campos.';
    } else {
        // 1) Verificar si el usuario ya existe
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = 'El nombre de usuario ya está en uso.';
        } else {
            // 2) Hashear la contraseña
            $hash = password_hash($password, PASSWORD_DEFAULT);
            // 3) Insertar nuevo usuario
            $stmt = $pdo->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
            if ($stmt->execute([$username, $hash])) {
                $success = '¡Usuario registrado correctamente!';
            } else {
                $error = 'Error al registrar el usuario. Intenta de nuevo.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@400;700&family=Raleway:wght@400;700&display=swap" rel="stylesheet">
    <style>
      /* ==== Reset & Layout ==== */
      * { box-sizing: border-box; margin: 0; padding: 0; }
      body {
        background: #FEFAE0;
        font-family: 'Montserrat', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
      }
      .container {
        background: #fff;
        padding: 2rem;
        width: 360px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        text-align: center;
      }
      h2 {
        font-family: 'Playfair Display', serif;
        color: #626F47;
        margin-bottom: 1.5rem;
      }
      /* ==== Form Styles ==== */
      label { 
        display: block;
        text-align: left;
        margin-bottom: 0.4rem;
        font-weight: 700;
        color: #76614f;
      }
      input {
        width: 100%;
        padding: 0.7rem;
        margin-bottom: 1rem;
        border: 1px solid #F0BB78;
        border-radius: 6px;
        font-size: 0.95rem;
      }
      button {
        width: 100%;
        padding: 0.8rem;
        background: #F0BB78;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.3s;
      }
      button:hover {
        background: #76614f;
      }
      .msg {
        margin-bottom: 1rem;
        font-size: 0.95rem;
      }
      .error { color: #d9534f; }
      .success { color: #28a745; }
      a.back {
        display: inline-block;
        margin-top: 1rem;
        font-family: 'Raleway', sans-serif;
        color: #626F47;
        text-decoration: none;
        font-size: 0.9rem;
      }
      a.back:hover { text-decoration: underline; }
    </style>
</head>
<body>
  <div class="container">
    <h2>Registro</h2>

    <?php if ($error): ?>
      <div class="msg error"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
      <div class="msg success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post" action="registro.php">
      <label for="username">Usuario</label>
      <input type="text" id="username" name="username" required autofocus>

      <label for="password">Contraseña</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Registrar</button>
    </form>

    <a class="back" href="login.html">&larr; Volver al Login</a>
  </div>
</body>
</html>
