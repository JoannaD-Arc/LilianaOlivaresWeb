<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHP_Mailer/src/PHPMailer.php';
require '../PHP_Mailer/src/SMTP.php';
require '../PHP_Mailer/src/Exception.php';

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$tipoConsulta = $_POST['tipoConsulta'];
$presupuesto = $_POST['presupuesto'] ?? 'No especificado';
$tiempo = $_POST['tiempo'] ?? 'No especificado';
$descripcion = $_POST['descripcion'];

$mail = new PHPMailer(true);

$mail->CharSet = 'UTF-8';
$mail->Encoding = 'base64';

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'lilianaolivares@lilianaolivares.site';
    $mail->Password = 'PanchitoInteriorista96$'; // ← Asegúrate de proteger esta información
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('lilianaolivares@lilianaolivares.site', 'Sitio Web');
    $mail->addAddress('lilianaolivares@lilianaolivares.site');
    $mail->addReplyTo($email, $nombre);

    $mail->isHTML(true);
    $mail->Subject = "Nueva consulta de tipo: $tipoConsulta";

    $mail->Body = "
        <h2>Nueva Consulta desde el sitio web</h2>
        <p><strong>Nombre:</strong> $nombre</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Tipo de consulta:</strong> $tipoConsulta</p>
        <p><strong>Presupuesto aproximado:</strong> $presupuesto</p>
        <p><strong>Tiempo requerido:</strong> $tiempo</p>
        <p><strong>Descripción del proyecto:</strong><br>$descripcion</p>
    ";

    // Adjuntar archivo si existe
    $maxSize = 10 * 1024 * 1024; // 10 MB

    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['archivo']['tmp_name'];
        $fileName = $_FILES['archivo']['name'];
        $fileSize = $_FILES['archivo']['size'];

        if ($fileSize <= $maxSize) {
            $mail->addAttachment($tmpName, $fileName);
        } else {
            error_log("Archivo '$fileName' excede el tamaño máximo permitido y fue omitido.");
        }
    }

    $mail->send();
    echo "Mensaje enviado correctamente.";
} catch (Exception $e) {
    echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
}
?>
