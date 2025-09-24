<?php
session_start();
require '../config/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.html');
    exit();
}

$result = mysqli_query($conexion, "SELECT * FROM avances ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="../css/style_dashboard.css">
    <title>Avances</title>
</head>
<body>
    <div class="container">
        <aside>
            <?php include '../views/sidebar.php'; ?>
        </aside>
        <main>
            <h1>Avances</h1>
            <div class="analyse">
                <div id="avances-list">
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <div class="status">
                            <div class="info">
                                <strong>ID Trabajo:</strong> <?php echo htmlspecialchars($row['trabajo_id']); ?> |
                                <strong>Tarea:</strong> <?php echo htmlspecialchars($row['tarea']); ?> |
                                <strong>Avance:</strong> <?php echo $row['avance']; ?>% |
                                <strong>Comentarios:</strong> <?php echo htmlspecialchars($row['comentarios']); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </main>
    </div>
    <script src="../js/dashboard.js"></script>
</body>
</html>