<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Representaciones Hidráulicas J.E.</title>
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
    <header>
        <div class="container" style="display: flex; align-items: center; justify-content: space-between; padding: 0;">
            <img src="views/img/LogoRHJE.png" alt="Representaciones Hidráulicas J.E." class="logo-header" style="height: 48px;">
            <nav class="main-nav" style="flex: 1;">
                <ul class="menu" style="margin: 0;">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="views/quienes-somos.html">Quiénes somos</a></li>
                    <li><a href="views/nuestros-trabajos.html">Nuestros Trabajos</a></li>
                    <li class="dropdown">
                        <a href="#">Servicios <span class="arrow">&#9660;</span></a>
                        <ul class="submenu">
                            <li><a href="views/servicio-mantenimiento.html">Mantenimientos preventivos y correctivos de maquinaria pesada</a></li>
                            <li><a href="views/servicio-reparacion.html">Reparación de cilindros hidráulicos, bombas, válvulas y mandos</a></li>
                            <li><a href="views/servicio-fabricacion.html">Fabricación de piezas especiales</a></li>
                            <li><a href="views/servicio-soldadura.html">Soldadura</a></li>
                            <li><a href="views/servicio-torno.html">Torno</a></li>
                            <li><a href="views/servicio-fresadora.html">Fresadora</a></li>
                        </ul>
                    </li>
                    <li><a href="views/contacto.php">Contacto</a></li>
                </ul>
            </nav>
            <div class="auth-links" style="display: flex; align-items: center; gap: 1rem;">
<?php
if (isset($_SESSION['usuario_nombre'])) {
    echo '<span class="user-name" style="color:#fff;font-weight:bold;display:flex;align-items:center;gap:0.4rem;"><span class="user-icon">👤</span> ' . htmlspecialchars($_SESSION["usuario_nombre"]) . '</span>';
    echo '<a href="views/logout.php" class="btn-header">Cerrar sesión</a>';
    if ($_SESSION["usuario_rol"] == 1) {
        echo '<a href="views/dashboard_admin.php" class="btn-header">Panel Admin</a>';
    } else {
        echo '<a href="views/dashboard_cliente.php" class="btn-header">Mi Perfil</a>';
    }
} else {
    echo '<a href="views/login_perfil.php" class="btn-header">Iniciar Sesión</a>';
    echo '<a href="views/registrarse_perfil.php" class="btn-header">Registrarse</a>';
}
?>
            </div>
        </div>
    </header>
    <section class="banner">
        <video autoplay muted loop playsinline class="banner-video">
            <source src="views/img/banner1.mp4" type="video/mp4">
            Tu navegador no soporta video HTML5.
        </video>
        <div class="banner-content">
            <h1>Soluciones Hidráulicas J.E.</h1>
            <p>Mantenimiento confiable, resultados duraderos.</p>
        </div>
    </section>
    <div class="container">
        <section class="services">
            <div class="service">
                <h3>Venta de Equipos</h3>
                <p>Bombas, válvulas, tuberías y accesorios hidráulicos de alta calidad.</p>
            </div>
            <div class="service">
                <h3>Asesoría Técnica</h3>
                <p>Soporte profesional para el diseño, instalación y mantenimiento de sistemas hidráulicos.</p>
            </div>
            <div class="service">
                <h3>Proyectos Especiales</h3>
                <p>Soluciones a la medida para proyectos industriales, comerciales y residenciales.</p>
            </div>
        </section>
    </div>
    <!-- Empresas que han confiado en nosotros -->
    <div class="container empresas-clientes">
        <h2>Empresas que han confiado en nosotros</h2>
        <div class="carousel-empresas">
            <div class="carousel-track">
                <img src="views/img/LogoHidroSas.png" alt="HidroSas">
                <img src="views/img/LogoYemapan.png" alt="Yemapan">
                <img src="views/img/LogoDiaco.png" alt="Diaco">
                <img src="views/img/LogoAutoGruasLaSexta.png" alt="AutoGruasLaS">
                <img src="views/img/LogoHI.png" alt="HI">
                <img src="views/img/gift-llano-pozos.gif" alt="Llano Pozos">
            </div>
        </div>
    </div>
    <!-- Banner tipo footer -->
    <div class="footer-banner">
        <div class="footer-col">
            <h3>Páginas</h3>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="views/quienes-somos.html">Quiénes Somos</a></li>
                <li><a href="views/nuestros-trabajos.html">Nuestros Trabajos</a></li>
                <li><a href="#">Servicios</a></li>
                <li><a href="views/contacto.html">Contacto</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h3>Servicios</h3>
            <ul>
                <li> Mantenimientos preventivos y correctivos de maquinaria pesada</li>
                <li> Reparación de cilindros hidráulicos, bombas, válvulas y mandos</li>
                <li> Fabricación de piezas especiales</li>
                <li> Soldadura</li>
                <li> Torno</li>
                <li> Fresadora</li>
            </ul>
        </div>
        <div class="footer-col">
            <h3>Encuéntrenos</h3>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.6494976164768!2d-74.14143652628022!3d4.6564406420422735!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9b039d78a493%3A0x65fbf09acf154b29!2sRepresentaciones%20Hidráulicas%20JE%20SAS!5e0!3m2!1ses-419!2sus!4v1752098692017!5m2!1ses-419!2sus" width="100%" height="180" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    <footer>
        &copy; 2025 Representaciones Hidráulicas J.E. | Todos los derechos reservados.
    </footer>
    <!-- Botón flotante de WhatsApp -->
    <a href="https://wa.me/573157922254" class="whatsapp-chat" target="_blank" title="Chatea con nosotros por WhatsApp">
        <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/whatsapp.svg" alt="WhatsApp" />
    </a>
    <script>
        // Duplica los logos para efecto infinito
        const track = document.querySelector('.carousel-track');
        if (track) {
            track.innerHTML += track.innerHTML;
        }
    </script>
    <script>
        document.querySelectorAll('.menu .dropdown > a').forEach(function(el) {
            el.addEventListener('click', function(e) {
                // Solo en móvil
                if (window.innerWidth <= 900) {
                    e.preventDefault();
                    const parent = this.parentElement;
                    parent.classList.toggle('open');
                }
            });
        });
    </script>
</body>
</html>