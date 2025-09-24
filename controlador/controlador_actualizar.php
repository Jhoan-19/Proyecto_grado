<?php
session_start();
require '../modelos/modelo_citas.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nombre = trim($_POST['nombre'] ?? '');
    $tipo_cliente = trim($_POST['tipo_cliente'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $vehiculo = trim($_POST['vehiculo'] ?? '');
    $tipo_equipo = trim($_POST['tipo_equipo'] ?? '');
    $serial_equipo = trim($_POST['serial_equipo'] ?? '');
    $servicio = trim($_POST['servicio'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $fecha = trim($_POST['fecha'] ?? '');
    $hora = trim($_POST['hora'] ?? '');

    // Validar campos obligatorios
    if (!$id || !$nombre || !$tipo_cliente || !$email || !$telefono || !$vehiculo || !$servicio || !$fecha || !$hora) {
        $_SESSION['mensaje_a'] = 'Por favor complete todos los campos obligatorios.';
        header('Location: ../views/actualizar.php?id=' . urlencode($id));
        exit();
    }

    // Manejo del archivo adjunto
    $archivo_nombre = null;
    $archivoNuevo = false;
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === 0) {
        $directorio = "../multimedia/archivos_citas/";
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }
        $archivo_nombre = uniqid() . "_" . basename($_FILES['archivo']['name']);
        $ruta_archivo = $directorio . $archivo_nombre;
        move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_archivo);
        $archivoNuevo = true;
    }

    // Verificar si la hora está ocupada
    require '../config/conexion.php';
    $verificar_sql = "SELECT COUNT(*) as total FROM citas WHERE fecha = ? AND hora = ? AND id != ?";
    $stmt = $conexion->prepare($verificar_sql);
    $stmt->bind_param("ssi", $fecha, $hora, $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    if ($row['total'] > 0) {
        $_SESSION['mensaje_a'] = "La hora seleccionada ya está ocupada por otra cita. Elige otra.";
        header('Location: ../views/actualizar.php?id=' . urlencode($id));
        exit();
    }

    // Preparar los datos para actualizar
    $datos = [
        'nombre' => $nombre,
        'tipo_cliente' => $tipo_cliente,
        'email' => $email,
        'telefono' => $telefono,
        'vehiculo' => $vehiculo,
        'tipo_equipo' => $tipo_equipo,
        'serial_equipo' => $serial_equipo,
        'servicio' => $servicio,
        'descripcion' => $descripcion,
        'fecha' => $fecha,
        'hora' => $hora,
        'archivo' => $archivo_nombre
    ];

    $citaModel = new Cita();
    $resultado = $citaModel->actualizarCita($id, $datos, $archivoNuevo);

    if ($resultado === true) {
        $res = mysqli_query($conexion, "SELECT * FROM citas WHERE id = $id");
        $cita = mysqli_fetch_assoc($res);
        $_SESSION['mensaje_a'] = 'Cita actualizada con éxito.';
        $_SESSION['cita'] = $cita;
        header('Location: ../views/confirmacion.php');
        exit();
    } else {
        $_SESSION['mensaje_a'] = $resultado;
        header('Location: ../views/actualizar.php?id=' . urlencode($id));
        exit();
    }
}
?>
