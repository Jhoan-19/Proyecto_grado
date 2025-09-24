<?php
session_start();
session_unset(); // Limpia todas las variables de sesión
session_destroy(); // Destruye la sesión
header('Location: ../index.php'); // Redirige al inicio (ajusta si tu index está en otra ruta)
exit();
?>