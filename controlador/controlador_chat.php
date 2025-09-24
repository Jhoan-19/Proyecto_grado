<?php
// Activar la visualización de errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Asegurar que las respuestas sean JSON
header('Content-Type: application/json');

require '../config/conexion.php';
require '../config/config_email.php';

function enviarNotificacionCorreo($correoReceptor, $nombreReceptor) {
    $mail = configurarMailer();

    try {
        $mail->addAddress($correoReceptor, $nombreReceptor);
        $mail->Subject = 'Nuevo mensaje recibido';
        $mail->Body = 'Has recibido un nuevo mensaje en la plataforma. Por favor, inicia sesión para revisarlo.';

        $mail->send();
    } catch (Exception $e) {
        error_log('Error al enviar correo: ' . $mail->ErrorInfo);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEmisor = $_POST['id_emisor'];
    $idReceptor = $_POST['id_receptor'];
    $mensaje = $_POST['mensaje'];

    $query = "INSERT INTO mensajes_chat (id_emisor, id_receptor, mensaje) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('iis', $idEmisor, $idReceptor, $mensaje);

    if ($stmt->execute()) {
        // Obtener correo y nombre del receptor desde la base de datos
        $queryReceptor = "SELECT correo, nombre FROM usuarios WHERE id = ?";
        $stmtReceptor = $conexion->prepare($queryReceptor);
        $stmtReceptor->bind_param('i', $idReceptor);
        $stmtReceptor->execute();
        $resultReceptor = $stmtReceptor->get_result();

        if ($resultReceptor->num_rows > 0) {
            $receptor = $resultReceptor->fetch_assoc();
            $correoReceptor = $receptor['correo'];
            $nombreReceptor = $receptor['nombre'];

            enviarNotificacionCorreo($correoReceptor, $nombreReceptor);
        } else {
            error_log('No se encontró el receptor con ID: ' . $idReceptor);
        }

        echo json_encode(['success' => true]);
    } else {
        error_log('Error al insertar mensaje: ' . $stmt->error);
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $idEmisor = $_GET['id_emisor'];
    $idReceptor = $_GET['id_receptor'];

    $query = "SELECT * FROM mensajes_chat WHERE (id_emisor = ? AND id_receptor = ?) OR (id_emisor = ? AND id_receptor = ?) ORDER BY fecha ASC";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('iiii', $idEmisor, $idReceptor, $idReceptor, $idEmisor);
    $stmt->execute();
    $result = $stmt->get_result();

    $mensajes = [];
    while ($row = $result->fetch_assoc()) {
        $mensajes[] = $row;
    }

    echo json_encode($mensajes);
    exit();
}

// Obtener lista de clientes con mensajes
if (isset($_GET['clientes'])) {
    $idAdmin = 1; // ID del administrador
    $queryClientes = "SELECT DISTINCT datos.id, datos.nombre FROM datos 
                      JOIN mensajes_chat ON datos.id = mensajes_chat.id_emisor 
                      WHERE mensajes_chat.id_receptor = $idAdmin";
    $resultClientes = mysqli_query($conexion, $queryClientes);

    $clientes = [];
    while ($row = $resultClientes->fetch_assoc()) {
        $clientes[] = $row;
    }

    echo json_encode($clientes);
    exit();
}
?>
