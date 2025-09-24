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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="css/style_dashboard.css">
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
                <a href="historial.php" class="active">
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
            <h1>Historial</h1>
            <!-- Analyses -->
            <div class="analyse">
                <div class="sales">
                    <div class="status">
                        <div class="info">
                            <h3>Total Sales</h3>
                            <h1>$65,024</h1>
                        </div>
                        <div class="progresss">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="percentage">
                                <p>+81%</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="visits">
                    <div class="status">
                        <div class="info">
                            <h3>Site Visit</h3>
                            <h1>24,981</h1>
                        </div>
                        <div class="progresss">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="percentage">
                                <p>-48%</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="searches">
                    <div class="status">
                        <div class="info">
                            <h3>Searches</h3>
                            <h1>14,147</h1>
                        </div>
                        <div class="progresss">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="percentage">
                                <p>+21%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Analyses -->

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
</body>

</html>