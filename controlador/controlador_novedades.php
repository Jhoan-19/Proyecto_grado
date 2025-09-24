<?php
require '../config/conexion.php';

$action = $_GET['action'] ?? '';

if ($action === 'list') {
    $result = mysqli_query($conexion, "SELECT * FROM novedades ORDER BY id DESC");
    $novedades = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $novedades[] = $row;
    }
    echo json_encode($novedades);
} elseif ($action === 'add') {
    $trabajo_id = mysqli_real_escape_string($conexion, $_POST['work-id']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $sql = "INSERT INTO novedades (trabajo_id, descripcion) VALUES ('$trabajo_id', '$descripcion')";
    mysqli_query($conexion, $sql);
}
