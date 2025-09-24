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

// Consulta TODAS las citas con datos del usuario
$citas = mysqli_query($conexion, "SELECT c.*, d.nombre AS nombre_usuario, d.email AS email_usuario 
    FROM citas c
    LEFT JOIN datos d ON c.id_usuario = d.id
    ORDER BY c.fecha, c.hora");
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
                    <img src="img/logo.png">
                    <h2>Admin</h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">close</span>
                </div>
            </div>

            <div class="sidebar">
                <a href="dashboard_admin.php" >
                    <span class="material-icons-sharp">home</span>
                    <h3>Inicio</h3>
                </a>
                <a href="usuarios.php">
                    <span class="material-icons-sharp">person_outline</span>
                    <h3>Usuarios</h3>
                </a>
                <a href="chat_admin.php">
                    <span class="material-icons-sharp">chat</span>
                    <h3>Chats</h3>
                </a>
                <a href="citas_agendadas.php" class="active">
                    <span class="material-icons-sharp">event_available</span>
                    <h3>Citas Agendadas</h3>
                </a>
                <a href="notificaciones_admin.php">
                    <span class="material-icons-sharp">notifications</span>
                    <h3>Notificaciones</h3>
                </a>
                <a href="../index.php">
                    <span class="material-icons-sharp">arrow_back</span>
                    <h3>Volver</h3>
                </a>

                <a href="logout.php">
                    <span class="material-icons-sharp">
                        logout
                    </span>
                    <h3>Cerrar Sesión</h3>
                </a>
            </div>
        </aside>

    <!-- Main Content -->
    <main>
        <h1>Citas Agendadas</h1>
        <?php if (mysqli_num_rows($citas) > 0): ?>
            <ul class="detalles-cita">
                <?php while ($cita = mysqli_fetch_assoc($citas)): ?>
                    <li>
                        <div class="info-cita">
                            <span><strong>Usuario:</strong> <?= htmlspecialchars($cita['nombre_usuario']) ?> (<?= htmlspecialchars($cita['email_usuario']) ?>)</span>
                            <span><strong>Fecha:</strong> <?= htmlspecialchars($cita['fecha']) ?></span>
                            <span><strong>Hora:</strong> <?= htmlspecialchars($cita['hora']) ?></span>
                            <span><strong>Servicio:</strong> <?= htmlspecialchars($cita['servicio']) ?></span>
                            <span><strong>Descripción:</strong> <?= htmlspecialchars($cita['descripcion']) ?></span>
                        </div>
                        <div class="contenedor-botones">
                            <!-- Botón para ver información de la cita -->
                            <form action="informacion_citas.php" method="GET" style="display:inline;">
                                <input type="hidden" name="id_cita" value="<?= $cita['id'] ?>">
                                <button type="submit" class="btn btn-actualizar">Ver Información</button>
                            </form>
                            <!-- Botón para eliminar la cita -->
                            <form action="../controlador/controlador_cancelar_citas.php" method="POST" class="form-cancelar-cita" style="display:inline;">
                                <input type="hidden" name="id_cita" value="<?= $cita['id'] ?>">
                                <button type="submit" class="btn btn-cancelar">Eliminar</button>
                            </form>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <div class="alert">No tienes citas agendadas.</div>
        <?php endif; ?>

        <?php if (isset($_SESSION['mensaje_cita']) && !empty($_SESSION['mensaje_cita'])): ?>
            <div id="modal-mensaje" class="modal-mensaje">
                <div class="modal-contenido">
                    <span class="modal-texto"><?= htmlspecialchars($_SESSION['mensaje_cita']) ?></span>
                    <button id="btn-continuar" class="btn-modal">Continuar</button>
                </div>
            </div>
            <?php unset($_SESSION['mensaje_cita']); ?>
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
                    <small class="text-muted">Admin</small>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    var btn = document.getElementById('btn-continuar');
    var modal = document.getElementById('modal-mensaje');
    if(btn && modal){
        btn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }
});
</script>
</body>
</html>
