<?php
// Iniciar sesión para poder acceder a datos almacenados
session_start();

// Incluir el modelo de citas o la conexión a la base de datos
require '../modelos/modelo_citas.php'; // Cambia la ruta si es necesario

// Verificar si se recibió un ID de cita
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_cita'])) {
    $idCita = $_POST['id_cita'];

    // Crear una instancia del modelo Cita
    $citaModel = new Cita();

    // Intentar borrar la cita
    $resultado = $citaModel->borrarCita($idCita);

    if ($resultado === true) {
        // Cita cancelada con éxito, redirigir con mensaje de éxito
        $_SESSION['mensaje'] = 'Cita cancelada con éxito.';
        header('Location: ../views/instrucciones.php');
        exit();
    } else {
        // Error al cancelar la cita, guardar mensaje de error
        $_SESSION['mensaje'] = $resultado;
        header('Location: ../views/instrucciones.php');
        exit();
    }
} else {
    // Si no se recibió un ID de cita, redirigir al formulario
    $_SESSION['mensaje'] = 'No se pudo cancelar la cita. ID no válido.';
    header('Location: ../views/instrucciones.php');
    exit();
}
