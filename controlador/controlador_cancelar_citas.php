<?php
session_start();
require '../config/conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_cita'])) {
    $_SESSION['mensaje_cita'] = "Solicitud inválida.";
    header('Location: ../views/citas_agendadas.php');
    exit();
}

$idCita = intval($_POST['id_cita']);

// El admin puede cancelar cualquier cita
$sql = "DELETE FROM citas WHERE id = $idCita";
if (mysqli_query($conexion, $sql)) {
    $_SESSION['mensaje_cita'] = "Cita cancelada correctamente.";
} else {
    $_SESSION['mensaje_cita'] = "No se pudo cancelar la cita.";
}
header('Location: ../views/citas_agendadas.php');
exit();
?>