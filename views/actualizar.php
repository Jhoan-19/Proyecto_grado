<?php
session_start();
require '../config/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit();
}

// Obtener datos actuales del usuario
$idUsuario = $_SESSION['usuario_id'];
$resultado = mysqli_query($conexion, "SELECT * FROM datos WHERE id = $idUsuario");
$usuario = mysqli_fetch_assoc($resultado);

// Obtener cita desde sesión o por GET
$cita = $_SESSION['cita'] ?? null;

if (!$cita && isset($_GET['id_cita'])) {
    $idCita = intval($_GET['id_cita']);
    $res = mysqli_query($conexion, "SELECT * FROM citas WHERE id = $idCita AND id_usuario = $idUsuario");
    $cita = mysqli_fetch_assoc($res);
    if ($cita) {
        $_SESSION['cita'] = $cita; // Opcional: guarda en sesión para el proceso de actualización
    }
}

if (!$cita) {
    header('Location: agendar.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Cita</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="css/style_dashboard.css">
    <link rel="stylesheet" href="css/style_agendar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                <a href="instrucciones.php">
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
            <section id="actualizar-cita" class="seccion-perfil-usuario">
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
                        <h1 class="texto">Actualizar Cita</h1>
                        <?php
                        if (isset($_SESSION['mensaje_a'])) {
                            echo "<div class='alert'>" . htmlspecialchars($_SESSION['mensaje_a']) . "</div>";
                            unset($_SESSION['mensaje_a']);
                        }
                        ?>
                    </div>
                    <div class="perfil-usuario-footer">
                        <form action="../controlador/controlador_actualizar.php" method="POST" class="formulario-actualizar" enctype="multipart/form-data">
                            <ul class="lista-datos">
                                <li>
                                    <label for="nombre"><i class='bx bxs-id-card'></i><strong>Nombre Completo:</strong></label>
                                    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($cita['nombre']); ?>" required>
                                </li>
                                <li>
                                    <label for="tipo_cliente"><i class='bx bx-user'></i><strong>Tipo de Cliente:</strong></label>
                                    <select id="tipo_cliente" name="tipo_cliente" required>
                                        <option value="Persona Natural" <?= $cita['tipo_cliente'] === 'Persona Natural' ? 'selected' : ''; ?>>Persona Natural</option>
                                        <option value="Empresa" <?= $cita['tipo_cliente'] === 'Empresa' ? 'selected' : ''; ?>>Empresa</option>
                                    </select>
                                </li>
                                <li>
                                    <label for="email"><i class='bx bxs-envelope'></i><strong>Correo:</strong></label>
                                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($cita['email']); ?>" required>
                                </li>
                                <li>
                                    <label for="telefono"><i class='bx bx-mobile-alt'></i><strong>Teléfono:</strong></label>
                                    <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($cita['telefono']); ?>" required>
                                </li>
                                <li>
                                    <label for="vehiculo"><i class='bx bxs-car'></i><strong>Equipo/Vehículo (Marca/Modelo):</strong></label>
                                    <input type="text" id="vehiculo" name="vehiculo" value="<?= htmlspecialchars($cita['vehiculo']); ?>" required>
                                </li>
                                <li>
                                    <label for="tipo_equipo"><i class='bx bx-cog'></i><strong>Tipo de Equipo:</strong></label>
                                    <input type="text" id="tipo_equipo" name="tipo_equipo" value="<?= htmlspecialchars($cita['tipo_equipo']); ?>">
                                </li>
                                <li>
                                    <label for="serial_equipo"><i class='bx bx-barcode'></i><strong>Serial/Número de Serie:</strong></label>
                                    <input type="text" id="serial_equipo" name="serial_equipo" value="<?= htmlspecialchars($cita['serial_equipo']); ?>">
                                </li>
                                <li>
                                    <label for="servicio"><i class='bx bx-wrench'></i><strong>Servicio Solicitado:</strong></label>
                                    <select id="servicio" name="servicio" required>
                                        <option value="">Elige Servicio</option>
                                        <option value="Mantenimiento Preventivo" <?= $cita['servicio'] === 'Mantenimiento Preventivo' ? 'selected' : ''; ?>>Mantenimiento Preventivo</option>
                                        <option value="Mantenimiento Correctivo" <?= $cita['servicio'] === 'Mantenimiento Correctivo' ? 'selected' : ''; ?>>Mantenimiento Correctivo</option>
                                        <option value="Diagnóstico de Fallas" <?= $cita['servicio'] === 'Diagnóstico de Fallas' ? 'selected' : ''; ?>>Diagnóstico de Fallas</option>
                                        <option value="Reparación de Motores" <?= $cita['servicio'] === 'Reparación de Motores' ? 'selected' : ''; ?>>Reparación de Motores</option>
                                        <option value="Cambio de Aceite" <?= $cita['servicio'] === 'Cambio de Aceite' ? 'selected' : ''; ?>>Cambio de Aceite</option>
                                        <option value="Frenos y Suspensión" <?= $cita['servicio'] === 'Frenos y Suspensión' ? 'selected' : ''; ?>>Frenos y Suspensión</option>
                                        <option value="Otro" <?= $cita['servicio'] === 'Otro' ? 'selected' : ''; ?>>Otro</option>
                                    </select>
                                </li>
                                <li>
                                    <label for="descripcion"><i class='bx bx-message-square-detail'></i><strong>Descripción del Problema o Solicitud:</strong></label>
                                    <textarea id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($cita['descripcion']); ?></textarea>
                                </li>
                                <li>
                                    <label for="fecha"><i class='bx bx-calendar'></i><strong>Fecha de la Cita:</strong></label>
                                    <input type="date" id="fecha" name="fecha" value="<?= htmlspecialchars($cita['fecha']); ?>" min="<?= date('Y-m-d'); ?>" required>
                                </li>
                                <li>
                                    <label for="hora"><i class='bx bx-time'></i><strong>Hora de la Cita:</strong></label>
                                    <select id="hora" name="hora" required>
                                        <option value="">Seleccione una fecha primero</option>
                                    </select>
                                    <small id="mensaje-hora" style="color: red; display: none;">La hora seleccionada ya está ocupada. Elija otra.</small>
                                </li>
                                <li>
                                    <label for="archivo"><i class='bx bx-paperclip'></i><strong>Archivo adjunto (opcional):</strong></label>
                                    <?php if (!empty($cita['archivo'])): ?>
                                        <div style="margin-bottom: 0.5em;">
                                            <a href="../multimedia/archivos_citas/<?= htmlspecialchars($cita['archivo']); ?>" target="_blank">Ver archivo actual</a>
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" id="archivo" name="archivo" accept="image/*,application/pdf">
                                </li>
                                <li>
                                    <button type="submit" class="btn">Actualizar Cita</button>
                                </li>
                            </ul>
                            <input type="hidden" name="id" value="<?= htmlspecialchars($cita['id']); ?>">
                        </form>
                    </div>
                </div>
            </section>
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

    <script src="js/script_agendar.js"></script>
    <script src="js/dashboard.js"></script>

</body>
</html>
