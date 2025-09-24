<?php
session_start();
require '../modelos/modelo_datos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['usuario_id'])) {
    $idUsuario = $_SESSION['usuario_id'];

    $datosModel = new Datos();
    $resultado = $datosModel->eliminarCliente($idUsuario);

    if ($resultado) {
        $_SESSION['mensaje_index'] = "Perfil eliminado correctamente.";
        session_write_close(); // Mantiene la sesión hasta que el mensaje se muestre
        header('Location: ../index.php');
        exit();
    } else {
        $_SESSION['mensaje_perfil'] = "No se pudo eliminar el perfil.";
        header('Location: ../views/perfil.php');
        exit();
    }
} else {
    $_SESSION['mensaje_perfil'] = "No se pudo procesar la solicitud.";
    header('Location: ../views/perfil.php');
    exit();
}
?>
