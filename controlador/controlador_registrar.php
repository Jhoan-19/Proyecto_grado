<?php
include("../config/conexion.php");
require("../config/config_email.php");

use PHPMailer\PHPMailer\Exception;

if (isset($_POST['register'])) {
    if (
        strlen($_POST['name']) >= 1 &&
        strlen($_POST['email']) >= 1 &&
        strlen($_POST['phone']) >= 1 &&
        strlen($_POST['direction']) >= 1 &&
        strlen($_POST['password']) >= 1
    ) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $direction = trim($_POST['direction']);
        $password = hash('sha512', trim($_POST['password']));
        $fecha = date("Y-m-d");
        $id_cargo = 2;

        // Validar si ya existe el correo
        $verificar_correo = mysqli_query($conexion, "SELECT * FROM datos WHERE email='$email'");
        if (mysqli_num_rows($verificar_correo) > 0) {
            echo "<div class='alert-reg error-reg'>
                    <i class='bx bx-error-circle'></i> Este correo ya está registrado
                    </div>";
            exit();
        }

        // Generar token de verificación
        $token = bin2hex(random_bytes(32));

        // Insertar nuevo usuario
        $consulta = "INSERT INTO datos(nombre, email, telefono, direccion, contraseña, fecha, id_cargo, verificado, token_activacion)
                    VALUES('$name', '$email', '$phone', '$direction', '$password', '$fecha', $id_cargo, 0, '$token')";

        $resultado = mysqli_query($conexion, $consulta);

        if ($resultado) {
            // Enviar correo de verificación
            try {
                $mail = configurarMailer();
                $mail->addAddress($email, $name);
                $mail->Subject = "Verifica tu cuenta";
                $link = "http://localhost/proyecto_grado/views/verificar_correo.php?token=$token";
                $mail->Body = "
                    <h2>¡Bienvenido a Representaciones Hidraulicas J.E S.A.S!</h2>
                    <p>Gracias por registrarte. Para activar tu cuenta, haz clic en el siguiente enlace:</p>
                    <a href='$link'>Verificar mi cuenta</a>
                    <p>Si tú no hiciste este registro, ignora este mensaje.</p>
                ";
                $mail->send();

                // Redirige al login con mensaje
                header("Location: login_perfil.php?msg=verificacion_enviada&correo=" . urlencode($email));
                exit();
            } catch (Exception $e) {
                echo "<div class='alert-reg error-reg'>
                        <i class='bx bx-error-circle'></i> Error al enviar correo: {$mail->ErrorInfo}
                    </div>";
            }
        } else {
            echo "<div class='alert-reg error-reg'>
                    <i class='bx bx-error-circle'></i> Ocurrió un error al registrar
                </div>";
        }
    } else {
        echo "<div class='alert-reg error-reg'>
                <i class='bx bx-error-circle'></i> Llena todos los campos
                </div>";
    }
}
?>
