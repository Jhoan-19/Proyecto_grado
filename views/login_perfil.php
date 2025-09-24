<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    // Redirige según el cargo: 1 = admin, 2 = cliente
    if (isset($_SESSION['id_cargo']) && $_SESSION['id_cargo'] == 1) {
        header('Location: dashboard_admin.php');
    } else {
        header('Location: dashboard_cliente.php');
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login-Representaciones Hidraulicas J.E.</title>
    <link rel="stylesheet" href="css/styles_login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="login">

    <div class="wrapper">
        <form action="" method="POST">
            <h1>Inicia sesión</h1>
            <?php
            $msg = $_SESSION['msg'] ?? $_GET['msg'] ?? null;
            $correo = $_SESSION['correo'] ?? $_GET['correo'] ?? null;
            if ($msg):
            ?>
                <div class="alerta-login <?php echo (
                    $msg == 'no_verificado' || $msg == 'acceso_denegado' || $msg == 'campos_vacios'
                ) ? 'error' : 'success'; ?>">
                    <?php
                        if ($msg == 'verificacion_enviada' && $correo) {
                            echo "✅ Te enviamos un correo a <strong>{$correo}</strong> para activar tu cuenta.";
                        } elseif ($msg == 'verificado') {
                            echo "✅ Tu cuenta ha sido verificada correctamente. Ya puedes iniciar sesión.";
                        } elseif ($msg == 'restablecida') {
                            echo "✅ Tu contraseña ha sido actualizada. Ya puedes iniciar sesión.";
                        } elseif ($msg == 'no_verificado') {
                            echo "❌ Debes verificar tu correo para iniciar sesión.";
                        } elseif ($msg == 'acceso_denegado') {
                            echo "❌ Acceso Denegado";
                        } elseif ($msg == 'campos_vacios') {
                            echo "❌ Por favor, completa todos los campos.";
                        }
                    ?>
                </div>
                <?php unset($_SESSION['msg'], $_SESSION['correo']); ?>
            <?php endif; ?>
            <?php include "../controlador/controlador_login.php"; ?>
            <div class="input-box">
                <input type="text" placeholder="Correo" name="correo" required>
                <i class='bx bx-envelope'></i>
            </div>
            <div class="input-box" style="position:relative;">
                <input type="password" placeholder="Contraseña" name="contrasena" class="input-password" required>
                <i class='bx bx-show toggle-password' style="cursor:pointer; position:absolute; right:10px; top:50%; transform:translateY(-50%);"></i>
            </div>


            <div class="olvidado">
                <a href="logout_forget.php">Olvidaste la Contraseña?</a>
            </div>

            <button type="submit" class="boton_ol" name="iniciar_perfil">Iniciar</button>

            <div class="registrarse">
                <p>No tienes una cuenta?</p><a href="registrarse_perfil.php">Registrarse</a>
            </div>       
        </form>
        <div class="volver">
            <a href="../index.php"><button type="submit" class="boton_vo">Volver</button></a> 
        </div>
    </div> 
    <script src="js/script.js"></script> 
</body>
</html>
