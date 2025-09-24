<?php
session_start();
require '../config/conexion.php';

// Procesar el formulario antes de cualquier salida
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../controlador/controlador_agendar.php';
    exit(); // Detén la ejecución después de procesar/redirigir
}

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.html');
    exit();
}

$idUsuario = $_SESSION['usuario_id'];
$resultado = mysqli_query($conexion, "SELECT * FROM datos WHERE id = $idUsuario");
$usuario = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="css/style_dashboard.css">
    <link rel="stylesheet" href="css/style_agendar.css">
    <title>Responsive Dashboard Design #1 | AsmrProg</title>
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
                <a href="usuario.php" >
                    <span class="material-icons-sharp">person_outline</span>
                    <h3>Usuario</h3>
                </a>
                <a href="chat.php">
                    <span class="material-icons-sharp">chat</span>
                    <h3>Chat</h3>
                </a>
                <a href="instrucciones.php" class="active">
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
                    <span class="material-icons-sharp">
                        logout
                    </span>
                    <h3>Cerrar Sesión</h3>
                </a>
            </div>
        </aside>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <section class="seccion-perfil-usuario">
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
                        <h1 class="texto">Agendar Cita</h1>
                </div>
    <div class="form-container">
        <form id="form-cita" action="agendar.php" method="POST" enctype="multipart/form-data">
            <label for="nombre">Nombre Completo:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="tipo_cliente">Tipo de Cliente:</label>
            <select id="tipo_cliente" name="tipo_cliente" required>
                <option value="Persona Natural">Persona Natural</option>
                <option value="Empresa">Empresa</option>
            </select>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>

            <label for="vehiculo">Equipo/Vehículo (Marca/Modelo):</label>
            <input type="text" id="vehiculo" name="vehiculo" required>

            <label for="tipo_equipo">Tipo de Equipo:</label>
            <input type="text" id="tipo_equipo" name="tipo_equipo" placeholder="Ej: Bomba hidráulica, Prensa, etc.">

            <label for="serial_equipo">Serial/Número de Serie:</label>
            <input type="text" id="serial_equipo" name="serial_equipo" placeholder="Opcional">

            <label for="servicio">Servicio Solicitado:</label>
            <select id="servicio" name="servicio" required>
                <option value="">Elige Servicio</option>
                <option value="Mantenimiento Preventivo">Mantenimiento Preventivo</option>
                <option value="Mantenimiento Correctivo">Mantenimiento Correctivo</option>
                <option value="Diagnóstico de Fallas">Diagnóstico de Fallas</option>
                <option value="Reparación de Motores">Reparación de Motores</option>
                <option value="Cambio de Aceite">Cambio de Aceite</option>
                <option value="Frenos y Suspensión">Frenos y Suspensión</option>
                <option value="Otro">Otro</option>
            </select>

            <label for="descripcion">Descripción del Problema o Solicitud:</label>
            <textarea id="descripcion" name="descripcion" rows="2" placeholder="Describe brevemente el problema o la solicitud"></textarea>

            <label for="fecha">Fecha Preferida:</label>
            <input type="date" id="fecha" name="fecha" min="<?= date('Y-m-d'); ?>" required>

            <label for="hora">Hora Preferida:</label>
            <select id="hora" name="hora" required>
                <option value="">Seleccione una fecha primero</option>
            </select>
            <small id="mensaje-hora" style="color: red; display: none;">La hora seleccionada ya está ocupada. Elija otra.</small>

            <label for="archivo">Adjuntar archivo (opcional):</label>
            <input type="file" id="archivo" name="archivo" accept="image/*,application/pdf">

            <button type="submit" class="btn btn-subir-foto">Agendar Cita</button>
        </form>
        <div style="margin-top: 1.5rem; text-align: center;">
            <a href="instrucciones.php" class="btn btn-subir-foto">Volver</a>
        </div>
    </div>
    
</main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <div class="right-section">
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">
                        menu
                    </span>
                </button>
                <div class="dark-mode">
                    <span class="material-icons-sharp active">
                        light_mode
                    </span>
                    <span class="material-icons-sharp">
                        dark_mode
                    </span>
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
            <!-- End of Nav -->

            <div class="user-profile">
                <div class="logo">
                    <img src="img/logo.png">
                    <h2> Representaciones Hidráulicas J.E. S.A.S</h2>
                </div>
            </div>

        </div>


    </div>

    <script src="js/dashboard.js"></script>
    <script src="js/script_agendar.js"></script>
</body>
</html>