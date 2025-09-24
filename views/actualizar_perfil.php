<?php
session_start();
require '../config/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.html');
    exit();
}

// Obtener datos actuales del usuario
$idUsuario = $_SESSION['usuario_id'];
$resultado = mysqli_query($conexion, "SELECT * FROM datos WHERE id = $idUsuario");
$usuario = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Perfil</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="css/style_dashboard.css">
    <link rel="stylesheet" href="css/styles_perfil.css">
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
                        <h1 class="texto">Actualizar Información del Perfil</h1>
                        <?php
                        if (isset($_SESSION['mensaje_perfil'])) {
                            echo "<div class='alert'>" . htmlspecialchars($_SESSION['mensaje_perfil']) . "</div>";
                            unset($_SESSION['mensaje_perfil']);
                        }
                        ?>
                    </div>
                    <div class="perfil-usuario-footer">
                        <form action="../controlador/controlador_actualizar_perfil.php" method="POST" class="formulario-actualizar">
                            <ul class="lista-datos">
                                <li><label for="nombre"><i class='bx bxs-id-card'></i><strong>Nombre Completo:</strong></label></li>
                                <li><input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']); ?>" required></li>

                                <li><label for="email"><i class='bx bxs-envelope'></i><strong>Correo:</strong></label></li>
                                <li><input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']); ?>" required></li>
                                
                                <li><label for="direccion"><i class='bx bx-map'></i><strong>Dirección:</strong></label></li>
                                <li><input type="text" id="direccion" name="direccion" value="<?= htmlspecialchars($usuario['direccion']); ?>" required></li>

                                <li><label for="telefono"><i class='bx bx-mobile-alt'></i><strong>Teléfono:</strong></label></li>
                                <li><input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($usuario['telefono']); ?>" required></li>

                                <li><button type="submit" class="btn">Actualizar</button></li>
                            </ul>
                        </form>
                    </div>
                </div>
            </section>

            <div class="contenedor-botones">
                <a href="usuario.php"><button class="btn">Cancelar</button></a>
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
                        <small class="text-muted">cliente/admin</small>
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
