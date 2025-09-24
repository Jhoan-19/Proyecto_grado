<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login-Representaciones Hidraulicas J.E.</title>
    <link rel="stylesheet" href="css/styles_login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="registro">

    <div class="wrapper">
        <form method="post">
            <h1>Registrarse</h1>

            <div class="input-box">
                <input type="text" name='name'placeholder="Nombre" required>
                <i class='bx bxs-user' ></i>
            </div>
            <div class="input-box">
                <input type="text" name="email" placeholder="Correo" required>
                <i class='bx bx-envelope'></i>
            </div>
            <div class="input-box">
                <input type="text" name="phone"  placeholder="telefono" required>
                <i class='bx bx-mobile-alt' ></i>
            </div>
            <div class="input-box" style="position: relative;">
                <input type="password" name="password" class="input-password" placeholder="Contraseña" required>
                <i class='bx bx-show toggle-password' style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
            </div>
            <div class="input-box">
                <input type="text" name="direction" placeholder="Direccion" required>
                <i class='bx bx-location-plus'></i>
            </div>


            <button type="submit" class="boton_ol" name="register">Registrarse</button>

            <div class="registrarse">
                <p>Ya tienes cuenta?</p>
                <a href="login_perfil.php">Iniciar sesión</a>
            </div>   
            
        </form>
        <?php
        include("../controlador/controlador_registrar.php");
        ?>
    </div>
    <script src="js/script.js"></script>
</body>
</html>