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
    <link rel="stylesheet" href="css/style_agendar.css">
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
        <?php
        // Validar y obtener el id de la cita
        $idCita = isset($_GET['id_cita']) ? intval($_GET['id_cita']) : 0;
        if ($idCita <= 0) {
            echo "<div class='alert'>Cita no válida.</div>";
        } else {
            // Si es admin, puede ver cualquier cita
            if (isset($_SESSION['id_cargo']) && $_SESSION['id_cargo'] == 1) {
                $sql = "SELECT * FROM citas WHERE id = $idCita";
            } else {
                // Si es cliente, solo puede ver sus propias citas
                $sql = "SELECT * FROM citas WHERE id = $idCita AND id_usuario = $idUsuario";
            }
            $res = mysqli_query($conexion, $sql);
            $cita = mysqli_fetch_assoc($res);

            if (!$cita) {
                echo "<div class='alert'>No se encontró la cita o no tienes permisos para verla.</div>";
            } else {
        ?>
    
        <section id="confirmacion-cita" class="seccion-perfil-usuario">
                <div class="perfil-usuario-body">
                    <div class="perfil-usuario-bio">
                        <h1 class="texto">¡Información de la Cita!</h1>
                    </div>
                    <div class="perfil-usuario-footer">
                        <ul class="detalles-cita">
                            <li><strong>Nombre:</strong> <?= htmlspecialchars($cita['nombre']); ?></li>
                            <li><strong>Tipo de Cliente:</strong> <?= htmlspecialchars($cita['tipo_cliente']); ?></li>
                            <li><strong>Correo:</strong> <?= htmlspecialchars($cita['email']); ?></li>
                            <li><strong>Teléfono:</strong> <?= htmlspecialchars($cita['telefono']); ?></li>
                            <li><strong>Equipo/Vehículo:</strong> <?= htmlspecialchars($cita['vehiculo']); ?></li>
                            <li><strong>Tipo de Equipo:</strong> <?= htmlspecialchars($cita['tipo_equipo']); ?></li>
                            <li><strong>Serial/Número de Serie:</strong> <?= htmlspecialchars($cita['serial_equipo']); ?></li>
                            <li><strong>Servicio:</strong> <?= htmlspecialchars($cita['servicio']); ?></li>
                            <li><strong>Descripción:</strong> <?= htmlspecialchars($cita['descripcion']); ?></li>
                            <li><strong>Fecha:</strong> <?= htmlspecialchars($cita['fecha']); ?></li>
                            <li><strong>Hora:</strong> <?= htmlspecialchars($cita['hora']); ?></li>
                            <?php if (!empty($cita['archivo'])): ?>
                                <li><strong>Archivo adjunto:</strong>
                                    <a href="../multimedia/archivos_citas/<?= htmlspecialchars($cita['archivo']); ?>" target="_blank">Ver archivo</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
        </section>

    <div class="contenedor-botones">
        <a href="citas_agendadas.php" class="btn">Volver</a>
    </div>
    <?php
        }
    }
    ?>
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
</body>
</html>
