<?php
require '../config/conexion.php';

if (!isset($_GET['fecha'])) {
    echo json_encode([]);
    exit;
}

$fecha = $_GET['fecha'];
$timestamp = strtotime($fecha);
$dow = date('w', $timestamp); // 0 = domingo, 6 = sábado

if ($dow == 0) {
    // Domingo, no se atiende
    echo json_encode([]);
    exit;
}

// Generar rangos por día
$horas = [];

if ($dow >= 1 && $dow <= 5) {
    // Lunes a Viernes: 7:30 a 17:30
    $inicio = strtotime('07:30');
    $fin = strtotime('17:30');
} else {
    // Sábado: 7:00 a 13:00
    $inicio = strtotime('07:00');
    $fin = strtotime('13:00');
}

// Intervalos de 1 hora
for ($hora = $inicio; $hora < $fin; $hora += 3600) {
    $hora_formato = date('H:i', $hora);
    $horas[] = ['hora' => $hora_formato, 'ocupado' => false];
}

// Consultar horas ocupadas
$sql = "SELECT hora FROM citas WHERE fecha = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $fecha);
$stmt->execute();
$result = $stmt->get_result();
$ocupadas = [];

while ($row = $result->fetch_assoc()) {
    $ocupadas[] = $row['hora'];
}

foreach ($horas as &$h) {
    if (in_array($h['hora'], $ocupadas)) {
        $h['ocupado'] = true;
    }
}

echo json_encode($horas);
?>
