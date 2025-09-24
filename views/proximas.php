<?php
session_start();
require '../config/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.html');
    exit();
}

$idUsuario = $_SESSION['usuario_id'];
$resultado = mysqli_query($conexion, "SELECT * FROM datos WHERE id = $idUsuario");
$usuario = mysqli_fetch_assoc($resultado);

// Consulta las citas del usuario
$citas = mysqli_query($conexion, "SELECT * FROM citas WHERE id_usuario = $idUsuario ORDER BY fecha, hora");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Cliente | RHJE</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="css/style_dashboard.css">
    <link rel="stylesheet" href="css/style_proximas.css">
</head>

<body>
<div class="container">

    <!-- Sidebar Section -->
    <aside>
        <div class="toggle">
            <div class="logo">
                <img src="img/logo.png" alt="Logo">
                <h2>Clientes</h2>
            </div>
            <div class="close" id="close-btn">
                <span class="material-icons-sharp">close</span>
            </div>
        </div>

        <div class="sidebar">
            <a href="dashboard_cliente.php">
                <span class="material-icons-sharp">home</span>
                <h3>Inicio</h3>
            </a>
            <a href="usuario.php">
                <span class="material-icons-sharp">person_outline</span>
                <h3>Usuario</h3>
            </a>
            <a href="chat.php">
                <span class="material-icons-sharp">chat</span>
                <h3>Chat</h3>
            </a>
            <a href="instrucciones.php">
                <span class="material-icons-sharp">event_available</span>
                <h3>Agendar Cita</h3>
            </a>
            <a href="proximas.php" class="active">
                <span class="material-icons-sharp">event_note</span>
                <h3>Próximas Citas</h3>
            </a>
            <a href="notificaciones.php">
                <span class="material-icons-sharp">notifications</span>
                <h3>Notificaciones</h3>
            </a>
            <a href="historial.php">
                <span class="material-icons-sharp">history</span>
                <h3>Historial de Citas</h3>
            </a>
            <a href="../index.php">
                    <span class="material-icons-sharp">arrow_back</span>
                    <h3>Volver</h3>
            </a>

            <a href="logout.php">
                <span class="material-icons-sharp">logout</span>
                <h3>Cerrar Sesión</h3>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main>
        <h1>Próximas Citas</h1>
        <?php if (mysqli_num_rows($citas) > 0): ?>
            <ul class="detalles-cita">
                <?php while ($cita = mysqli_fetch_assoc($citas)): ?>
                    <li>
                        <div class="info-cita">
                            <span><strong>Fecha:</strong> <?= htmlspecialchars($cita['fecha']) ?></span>
                            <span><strong>Hora:</strong> <?= htmlspecialchars($cita['hora']) ?></span>
                            <span><strong>Servicio:</strong> <?= htmlspecialchars($cita['servicio']) ?></span>
                            <span><strong>Descripcion:</strong> <?= htmlspecialchars($cita['descripcion']) ?></span>
                        </div>
                        <div class="contenedor-botones">
                            <form action="actualizar.php" method="GET" style="display:inline;">
                                <input type="hidden" name="id_cita" value="<?= $cita['id'] ?>">
                                <button type="submit" class="btn btn-actualizar">Actualizar</button>
                            </form>
                            <form action="../controlador/controlador_cancelar.php" method="POST" class="form-cancelar-cita" style="display:inline;">
                                <input type="hidden" name="id_cita" value="<?= $cita['id'] ?>">
                                <button type="submit" class="btn btn-cancelar">Cancelar</button>
                            </form>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <div class="alert">No tienes próximas citas agendadas.</div>
        <?php endif; ?>
    </main>
    <!-- End of Main Content -->

    <!-- Right Section -->
    <div class="right-section">
        <div class="nav">
            <button id="menu-btn"><span class="material-icons-sharp">menu</span></button>
            <div class="dark-mode">
                <span class="material-icons-sharp active">light_mode</span>
                <span class="material-icons-sharp">dark_mode</span>
            </div>

            <div class="profile">
                <div class="info">
                    <p>Hey, <b><?= htmlspecialchars($usuario['nombre']); ?></b></p>
                    <small class="text-muted">cliente</small>
                </div>
                <div class="profile-photo">
                    <?php if (!empty($usuario['foto'])): ?>
                        <img src="http://localhost/proyecto_grado/<?= htmlspecialchars($usuario['foto']); ?>" alt="Perfil">
                    <?php else: ?>
                        <img src="http://localhost/multimedia/relleno/default.png" alt="Perfil">
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="user-profile">
            <div class="logo">
                <img src="img/logo.png" alt="Logo Empresa">
                <h2>Representaciones Hidráulicas J.E. S.A.S</h2>
            </div>
        </div>
    </div>

</div>

<script src="js/dashboard.js"></script>
</body>
</html>
