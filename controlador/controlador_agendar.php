<?php
session_start();
require '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['usuario_id'];

    // 1. Verifica si el usuario ya tiene una cita activa
    $consulta = "SELECT COUNT(*) as total FROM citas WHERE id_usuario = '$id_usuario'";
    $resultado = mysqli_query($conexion, $consulta);
    $row = mysqli_fetch_assoc($resultado);

    if ($row['total'] > 0) {
        // Ya tiene una cita activa, no permite agendar otra
        $_SESSION['mensaje'] = "Solo puedes tener una cita activa. Cancela o actualiza tu cita actual antes de agendar una nueva.";
        header("Location: ../views/instrucciones.php");
        exit();
    }

    // ... Resto de tu código para agendar la cita ...
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $tipo_cliente = mysqli_real_escape_string($conexion, $_POST['tipo_cliente']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $vehiculo = mysqli_real_escape_string($conexion, $_POST['vehiculo']);
    $tipo_equipo = mysqli_real_escape_string($conexion, $_POST['tipo_equipo']);
    $serial_equipo = mysqli_real_escape_string($conexion, $_POST['serial_equipo']);
    $servicio = mysqli_real_escape_string($conexion, $_POST['servicio']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $fecha = mysqli_real_escape_string($conexion, $_POST['fecha']);
    $hora = mysqli_real_escape_string($conexion, $_POST['hora']);

    // Verificar si la hora ya está ocupada para esa fecha
    $verificar_sql = "SELECT COUNT(*) as total FROM citas WHERE fecha = '$fecha' AND hora = '$hora'";
    $verificar_resultado = mysqli_query($conexion, $verificar_sql);
    $verificar_row = mysqli_fetch_assoc($verificar_resultado);

    if ($verificar_row['total'] > 0) {
        $_SESSION['mensaje'] = "La hora seleccionada ya está ocupada. Por favor elige otra.";
        header("Location: ../views/agendar.php");
        exit();
    }

    // Manejo del archivo adjunto
    $archivo_nombre = null;
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
        $directorio = "../multimedia/archivos_citas/";
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }
        $archivo_nombre = uniqid() . "_" . basename($_FILES['archivo']['name']);
        $ruta_archivo = $directorio . $archivo_nombre;
        move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_archivo);
    }

    // Inserta en la base de datos (ahora incluye id_usuario)
    $sql = "INSERT INTO citas 
        (id_usuario, nombre, tipo_cliente, email, telefono, vehiculo, tipo_equipo, serial_equipo, servicio, descripcion, fecha, hora, archivo)
        VALUES 
        ('$id_usuario', '$nombre', '$tipo_cliente', '$email', '$telefono', '$vehiculo', '$tipo_equipo', '$serial_equipo', '$servicio', '$descripcion', '$fecha', '$hora', '$archivo_nombre')";

    if (mysqli_query($conexion, $sql)) {
        $id_cita = mysqli_insert_id($conexion);
        $res = mysqli_query($conexion, "SELECT * FROM citas WHERE id = $id_cita");
        $cita = mysqli_fetch_assoc($res);
        $_SESSION['cita'] = $cita;
        $_SESSION['mensaje_a'] = "¡Cita agendada con éxito!";
        header("Location: ../views/confirmacion.php");
        exit();
    } else {
        $_SESSION['mensaje'] = "Error al agendar la cita: " . mysqli_error($conexion);
        header("Location: ../views/agendar.php");
        exit();
    }
}
?>