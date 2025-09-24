<?php
// filepath: c:\xampp\htdocs\proyecto_grado\controlador\controlador_cambiar_cargo.php
session_start();
require '../config/conexion.php';

// Solo permitir si el usuario logueado es admin
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['id_cargo']) || $_SESSION['id_cargo'] != 1) {
    header('Location: ../views/usuarios.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = intval($_POST['id_usuario'] ?? 0);
    $nuevo_cargo = intval($_POST['nuevo_cargo'] ?? 2);

    // Evitar que el admin se cambie a sí mismo a cliente (opcional)
    if ($id_usuario == $_SESSION['usuario_id']) {
        $_SESSION['mensaje_perfil_a'] = "No puedes cambiar tu propio cargo.";
        header('Location: ../views/usuarios.php');
        exit();
    }

    // Actualizar el cargo en la base de datos
    $sql = "UPDATE datos SET id_cargo = $nuevo_cargo WHERE id = $id_usuario";
    if (mysqli_query($conexion, $sql)) {
        $_SESSION['mensaje_perfil_a'] = "Cargo actualizado correctamente.";
    } else {
        $_SESSION['mensaje_perfil_a'] = "Error al actualizar el cargo.";
    }
    header('Location: ../views/usuarios.php');
    exit();
} else {
    header('Location: ../views/usuarios.php');
    exit();
}