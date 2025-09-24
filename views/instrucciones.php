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
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instrucciones | RHJE</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="css/style_dashboard.css">
    <link rel="stylesheet" href="css/style_agendar.css">
</head>

<body>
<div class="container">

    <!-- Sidebar -->
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
                <span class="material-icons-sharp">chat</span
                ><h3>Chat</h3
            ></a>
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
                <span class="material-icons-sharp">logout</span>
                <h3>Cerrar Sesión</h3>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main>
        <section class="seccion-perfil-usuario">
            <div class="perfil-usuario-header">
                <div class="perfil-usuario-portada">
                    <div class="perfil-usuario-avatar">
                        <?php if (!empty($usuario['foto'])): ?>
                            <img src="http://localhost/proyecto_grado/<?= htmlspecialchars($usuario['foto']); ?>" alt="Foto de Perfil" class="rounded-circle" style="width: 150px; height: 150px;">
                        <?php else: ?>
                            <img src="http://localhost/multimedia/relleno/default.png" alt="Foto de Perfil" class="rounded-circle" style="width: 150px; height: 150px;">
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="perfil-usuario-body">
                <div class="perfil-usuario-bio">
                    <h3 class="titulo"><?= htmlspecialchars($usuario['nombre']); ?></h3>
                    <h1 class="texto">Instrucciones para Agendar Cita</h1>
                    <?php
                        if (isset($_SESSION['mensaje_perfil_a'])) {
                            echo "<div class='alert'>" . htmlspecialchars($_SESSION['mensaje_perfil_a']) . "</div>";
                            unset($_SESSION['mensaje_perfil_a']);
                        }
                        if (isset($_SESSION['mensaje'])) {
                            echo "<div class='alert'>" . htmlspecialchars($_SESSION['mensaje']) . "</div>";
                            unset($_SESSION['mensaje']);
                        }
                        ?>
                <?php
                    // Mostrar mensaje si existe
                    if (isset($_SESSION['mensaje'])) {
                        echo "<div class='alert'>" . htmlspecialchars($_SESSION['mensaje']) . "</div>";
                        unset($_SESSION['mensaje']); // Limpia el mensaje de la sesión
                    }

                    // Mostrar mensaje de error (si existe)
                    if (isset($mensaje)) {
                        echo "<p class='error'>$mensaje</p>";
                    }
                ?>

                    <div class="instrucciones">
                        <p><strong>Por favor lea atentamente antes de agendar su cita:</strong></p>
                        <ul>
                            <li><strong>Solo puedes tener una cita activa al mismo tiempo.</strong> Si ya tienes una cita agendada, deberás cancelarla o actualizarla antes de programar una nueva.</li>
                            <li>Este formulario debe diligenciarse <strong>únicamente</strong> si necesita una <strong>visita presencial</strong> en nuestra sede: <br><strong>Carrera Falsa 123, Bogotá.</strong></li>
                            <li>Si desea consultas virtuales o telefónicas, utilice el <strong>chat</strong> o los medios de contacto disponibles en la plataforma.</li>
                            <li><strong>Adjuntar archivo (opcional):</strong> puede subir documentos o imágenes relacionadas con su solicitud. <br>Formatos permitidos: <strong>Imágenes (.jpg, .png) o archivos PDF.</strong></li>
                            <li>Complete correctamente todos los campos requeridos del formulario para una mejor atención.</li>
                        </ul>
                    </div>

                    <div style="margin-top: 2rem;">
                        <a href="agendar.php" class="btn btn-subir-foto" style="padding: 12px 24px; font-size: 1rem;">Agendar Cita</a>
                    </div>

                </div>
            </div>
        </section>
    </main>

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
                    <small class="text-muted">Cliente</small>
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
