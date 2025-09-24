<?php
// filepath: c:\xampp\htdocs\proyecto_grado (2)\proyecto_grado\views\mensajes_contacto.php
session_start();
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] != 1) {
    header('Location: ../index.php');
    exit();
}
include '../config/conexion.php';

$result = mysqli_query($conexion, "SELECT * FROM contacto ORDER BY fecha DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensajes de Contacto</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 2em; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #003366; color: #fff; }
        tr:nth-child(even) { background: #f5f5f5; }
    </style>
</head>
<body>
    <h1>Mensajes de Contacto</h1>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Mensaje</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['fecha']); ?></td>
                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                <td><a href="mailto:<?php echo htmlspecialchars($row['email']); ?>"><?php echo htmlspecialchars($row['email']); ?></a></td>
                <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($row['mensaje'])); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>