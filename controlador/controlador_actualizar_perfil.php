<?php
session_start();
require '../modelos/modelo_datos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_SESSION['usuario_id'] ?? null;
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');

    if ($id && $nombre && $email && $telefono && $direccion) {
        $datosModel = new Datos();
        $resultado = $datosModel->actualizarCliente($id, htmlspecialchars($nombre), htmlspecialchars($email), htmlspecialchars($telefono), htmlspecialchars($direccion));

        if ($resultado) {
            $_SESSION['mensaje_perfil_a'] = "Perfil actualizado correctamente.";
            header('Location: ../views/usuario.php');
        } else {
            $_SESSION['mensaje_perfil_a'] = "No se pudo actualizar el perfil.";
            header('Location: ../views/actualizar_perfil.php');
        }
    } else {
        $_SESSION['mensaje_perfil_a'] = "Todos los campos son obligatorios.";
        header('Location: ../views/actualizar_perfil.php');
    }
    exit();
} 
?>
