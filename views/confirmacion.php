<?php
session_start();
require '../config/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit();
}

$idUsuario = $_SESSION['usuario_id'];
$resultado = mysqli_query($conexion, "SELECT * FROM datos WHERE id = $idUsuario");
$usuario = mysqli_fetch_assoc($resultado);

$cita = $_SESSION['cita'] ?? null; // Carga los datos de la cita desde la sesión

if (!$cita) {
    // Si no hay datos de la cita, redirigir al formulario de agendar
    header('Location: agendar.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="css/style_dashboard.css">
    <link rel="stylesheet" href="css/style_agendar.css">
    <title>Confirmación de Cita | TurboCars</title>
</head>

<body>
    <div class="container">
        <!-- Sidebar Section -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="img/logo.png">
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
                <a href="usuarios.php">
                    <span class="material-icons-sharp">person_outline</span>
                    <h3>Usuario</h3>
                </a>
                <a href="chat.php">
                    <span class="material-icons-sharp">chat</span>
                    <h3>Chat</h3>
                </a>
                <a href="agendar.php" class="active">
                    <span class="material-icons-sharp">event_available</span>
                    <h3>Agendar Cita</h3>
                </a>
                <a href="proximas.php">
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
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <section id="confirmacion-cita" class="seccion-perfil-usuario">
                <div class="perfil-usuario-header">
                    <div class="perfil-usuario-portada">
                        <div class="perfil-usuario-avatar">
                            <?php if (!empty($usuario['foto'])) { ?>
                                <img src="http://localhost/proyecto_grado/<?= htmlspecialchars($usuario['foto']); ?>" alt="Foto de Perfil" class="rounded-circle" style="width: 150px; height: 150px;">
                            <?php } else { ?>
                                <img src="http://localhost/multimedia/relleno/default.png" alt="Foto de Perfil" class="rounded-circle" style="width: 150px; height: 150px;">
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="perfil-usuario-body">
                    <div class="perfil-usuario-bio">
                        <h3 class="titulo"><?= htmlspecialchars($usuario['nombre']); ?></h3>
                        <h1 class="texto">¡Cita asignada con éxito!</h1>
                        <?php
                        if (isset($_SESSION['mensaje_a'])) {
                            echo "<div class='alert'>" . htmlspecialchars($_SESSION['mensaje_a']) . "</div>";
                            unset($_SESSION['mensaje_a']);
                        }
                        ?>
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
                <button class="btn" onclick="window.print()">Imprimir</button>
                <a href="../views/instrucciones.php"><button class="btn">Volver</button></a>
                <a href="actualizar.php"><button class="btn">Actualizar</button></a>
                <form action="../controlador/controlador_cancelar.php" method="POST" class="form-cancelar-cita" style="display:inline;">
                    <input type="hidden" name="id_cita" value="<?= $cita['id'] ?>">
                    <button type="submit" class="btn btn-cancelar">Cancelar</button>
                </form>
            </div>
            
        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <div class="right-section">
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">menu</span>
                </button>
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
                        <?php if (!empty($usuario['foto'])) { ?>
                            <img src="http://localhost/proyecto_grado/<?= htmlspecialchars($usuario['foto']); ?>">
                        <?php } else { ?>
                            <img src="http://localhost/multimedia/relleno/default.png">
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="user-profile">
                <div class="logo">
                    <img src="img/logo.png">
                    <h2>Representaciones Hidráulicas J.E. S.A.S</h2>
                </div>
            </div>
        </div>

    </div>

    <script src="js/dashboard.js"></script>
</body>

</html>
