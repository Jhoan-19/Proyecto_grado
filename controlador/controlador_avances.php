<?php
require '../config/conexion.php';

$action = $_GET['action'] ?? '';

if ($action === 'list') {
    $result = mysqli_query($conexion, "SELECT * FROM avances ORDER BY id DESC");
    $avances = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $avances[] = $row;
    }
    echo json_encode($avances);
} elseif ($action === 'add') {
    $trabajo_id = mysqli_real_escape_string($conexion, $_POST['work-id']);
    $tarea = mysqli_real_escape_string($conexion, $_POST['task']);
    $avance = intval($_POST['progress']);
    $comentarios = mysqli_real_escape_string($conexion, $_POST['comments']);
    $sql = "INSERT INTO avances (trabajo_id, tarea, avance, comentarios) VALUES ('$trabajo_id', '$tarea', $avance, '$comentarios')";
    mysqli_query($conexion, $sql);
}
