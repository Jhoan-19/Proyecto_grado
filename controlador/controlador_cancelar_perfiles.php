<?php
session_start();
require '../config/conexion.php';

// Solo permitir si el usuario logueado es admin
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['id_cargo']) || $_SESSION['id_cargo'] != 1) {
    $_SESSION['mensaje_perfil_a'] = "No tienes permisos para realizar esta acción.";
    header('Location: ../views/usuarios.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_usuario'])) {
    $idEliminar = intval($_POST['id_usuario']);

    // Evitar que el admin se elimine a sí mismo
    if ($idEliminar == $_SESSION['usuario_id']) {
        $_SESSION['mensaje_perfil_a'] = "No puedes eliminar tu propio perfil desde aquí.";
        header('Location: ../views/usuarios.php');
        exit();
    }

    // Eliminar usuario y sus citas (por ON DELETE CASCADE en la BD)
    $sql = "DELETE FROM datos WHERE id = $idEliminar";
    if (mysqli_query($conexion, $sql)) {
        $_SESSION['mensaje_perfil_a'] = "Perfil eliminado correctamente.";
    } else {
        $_SESSION['mensaje_perfil_a'] = "No se pudo eliminar el perfil.";
    }
    header('Location: ../views/usuarios.php');
    exit();
} else {
    $_SESSION['mensaje_perfil_a'] = "Solicitud inválida.";
    header('Location: ../views/usuarios.php');
    exit();
}
?>