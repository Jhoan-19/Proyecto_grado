<?php 

include(__DIR__ . '/../config/conexion.php');

if (isset($_POST["iniciar"]) || isset($_POST["iniciar_servicio"]) || isset($_POST["iniciar_perfil"])) {
    if (!empty($_POST["correo"]) && !empty($_POST["contrasena"])) {
        $correo = $_POST["correo"];
        $contrasena = hash('sha512', $_POST["contrasena"]);

        $sql = "SELECT * FROM datos WHERE email='$correo' AND contraseña='$contrasena'";
        $resultado = mysqli_query($conexion, $sql);

        if ($datos = mysqli_fetch_assoc($resultado)) {
            if ($datos['verificado'] == 0) {
                $_SESSION['msg'] = 'no_verificado';
                if (!empty($correo)) {
                    $_SESSION['correo'] = $correo;
                }
                header("Location: login_perfil.php");
                exit();
            }
            $_SESSION['usuario_nombre'] = $datos['nombre'];
            $_SESSION['usuario_rol'] = $datos['id_cargo']; // 1=admin, 2=cliente
            $_SESSION['usuario_id'] = $datos['id'];
            $_SESSION['id_cargo'] = $datos['id_cargo']; // <--- ESTA LÍNEA ES CLAVE

            if ($datos['id_cargo'] == 1) {
                header("Location: ../views/dashboard_admin.php");
                exit();
            } elseif ($datos['id_cargo'] == 2) {
                header("Location: ../views/dashboard_cliente.php");
                exit();
            } else {
                header("Location: ../index.php");
                exit();
            }
        } else {
            $_SESSION['msg'] = 'acceso_denegado';
            header("Location: login_perfil.php");
            exit();
        }
    } else {
        $_SESSION['msg'] = 'campos_vacios';
        header("Location: login_perfil.php");
        exit();
    }
}
