<?php
include("../config/conexion.php");

$token = $_GET['token'] ?? null;
$msg = '';

// Validar token
if (!$token) {
    die("<h3>❌ Token no proporcionado.</h3>");
}

$consulta = mysqli_query($conexion, "SELECT * FROM datos WHERE token_activacion='$token'");
if (mysqli_num_rows($consulta) === 0) {
    die("<h3>❌ Token inválido o expirado.</h3>");
}

// Procesar nueva contraseña
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nueva = trim($_POST['nueva']);
    $confirmar = trim($_POST['confirmar']);

    if ($nueva === $confirmar && strlen($nueva) >= 6) {
        $nueva_hash = hash('sha512', $nueva);
        $usuario = mysqli_fetch_assoc($consulta);
        $id = $usuario['id'];

        // Actualizar contraseña y limpiar token
        $actualizar = "UPDATE datos SET contraseña='$nueva_hash', token_activacion=NULL WHERE id=$id";
        mysqli_query($conexion, $actualizar);

        // Redirigir al login con mensaje
        header("Location: login_perfil.php?msg=restablecida");
        exit();
    } else {
        $msg = "<div class='alert-login error-login'>❌ Las contraseñas no coinciden o son muy cortas.</div>";
    }
}
?>

<!-- Formulario para nueva contraseña -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="css/styles_login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="login">
    <div class="wrapper">
        <form method="POST">
            <h1>Establecer Nueva Contraseña</h1>
            <?= $msg ?>
            
            <div class="input-box" style="position: relative;">
                <input type="password" name="nueva" placeholder="Nueva contraseña" class="input-password" required>
                <i class='bx bx-show toggle-password' style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
            </div>
            <div class="input-box" style="position: relative;">
                <input type="password" name="confirmar" placeholder="Confirmar contraseña" class="input-password" required>
                <i class='bx bx-show toggle-password' style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
            </div>

            <button type="submit" class="boton_ol">Actualizar</button>
        </form>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
