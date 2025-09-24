<?php
require("../config/conexion.php");
require("../config/config_email.php");
use PHPMailer\PHPMailer\Exception;

$msg = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = trim($_POST['email']);
    $consulta = mysqli_query($conexion, "SELECT * FROM datos WHERE email='$correo'");

    if (mysqli_num_rows($consulta) > 0) {
        $usuario = mysqli_fetch_assoc($consulta);
        $token = bin2hex(random_bytes(32));
        $id = $usuario['id'];

        // Guardar el token en la base de datos
        mysqli_query($conexion, "UPDATE datos SET token_activacion='$token' WHERE id=$id");

        try {
            $mail = configurarMailer();
            $mail->addAddress($correo, $usuario['nombre']);
            $mail->Subject = "Recuperar contraseña ";
            $link = "http://localhost/proyecto_grado/views/reset_password.php?token=$token";
            $mail->Body = "
                <h2>Solicitud de recuperación de contraseña</h2>
                <p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p>
                <a href='$link'>$link</a>
                <p>Si no solicitaste esto, ignora este mensaje.</p>
            ";
            $mail->send();
            $msg = "<div class='alert-login success-login'>✅ Enlace enviado a <strong>$correo</strong>.</div>";
        } catch (Exception $e) {
            $msg = "<div class='alert-login error-login'>❌ Error al enviar el correo: {$mail->ErrorInfo}</div>";
        }
    } else {
        $msg = "<div class='alert-login error-login'>❌ Este correo no está registrado.</div>";
    }
}
?>

<!-- Tu formulario HTML de siempre -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="css/styles_login.css">
</head>
<body class="login">
    <div class="wrapper">
        <form method="POST">
            <h1>Recuperar Contraseña</h1>
            <?= $msg ?>
            <div class="input-box">
                <input type="email" name="email" placeholder="Correo registrado" required>
                <i class='bx bx-envelope'></i>
            </div>
            <button type="submit" class="boton_ol">Enviar enlace</button>
            <div class="volver">
                <a href="login_perfil.php"><button type="button" class="boton_vo">Volver</button></a>
            </div>
        </form>
    </div>
</body>
</html>
