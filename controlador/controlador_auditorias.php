<?php
require '../config/conexion.php';

$action = $_GET['action'] ?? '';

if ($action === 'list') {
    $result = mysqli_query($conexion, "SELECT * FROM auditorias ORDER BY fecha DESC");
    $auditorias = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $auditorias[] = $row;
    }
    echo json_encode($auditorias);
} elseif ($action === 'add') {
    $trabajo_id = mysqli_real_escape_string($conexion, $_POST['work-id']);
    $detalle = mysqli_real_escape_string($conexion, $_POST['audit-detail']);
    $sql = "INSERT INTO auditorias (trabajo_id, detalle) VALUES ('$trabajo_id', '$detalle')";
    mysqli_query($conexion, $sql);
}
