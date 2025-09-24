<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../librerias/PHPMailer/PHPMailer.php';
require __DIR__ . '/../librerias/PHPMailer/SMTP.php';
require __DIR__ . '/../librerias/PHPMailer/Exception.php';

function configurarMailer() {
    $mail = new PHPMailer(true);

    // Configuración SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    
    // ✅ CAMBIAR ESTOS DATOS AL FINAL
    $mail->Username = 'jhoanricardov11@gmail.com';
    $mail->Password = 'jhcr eits zwlr oetm';

    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Datos del remitente
    $mail->setFrom('jhoanricardov11@gmail.com', 'proyecto');

    // Codificación y formato
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);

    return $mail;
}
?>
