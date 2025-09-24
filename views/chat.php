<?php
session_start();
require '../config/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.html');
    exit();
}

$idUsuario = $_SESSION['usuario_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="css/style_dashboard.css">
    <title>Chat</title>
</head>

<body>
    <div class="container">
        <main>
            <div class="chat-header">
                <h2>Chat</h2>
                <button class="back-button" onclick="window.location.href='dashboard_cliente.php'">Volver al Panel
                </button>
            </div>
            <div class="chat-messages" id="chat-messages">
                <!-- Los mensajes del chat se cargarán aquí -->
            </div>
            <form id="chat-form" class="chat-form">
                <input type="hidden" id="id_emisor" value="<?= htmlspecialchars($idUsuario); ?>">
                <input type="hidden" id="id_receptor" value="1"> <!-- ID del administrador -->
                <input type="text" id="mensaje" placeholder="Escribe un mensaje..." required>
                <button type="submit" class="btn">Enviar</button>
            </form>
        </main>
    </div>

    <script>
        const chatForm = document.getElementById('chat-form');
        const chatMessages = document.getElementById('chat-messages');

        function cargarMensajes() {
            const idEmisor = document.getElementById('id_emisor').value;
            const idReceptor = document.getElementById('id_receptor').value;

            fetch(`../controlador/controlador_chat.php?id_emisor=${idEmisor}&id_receptor=${idReceptor}`)
                .then(response => response.json())
                .then(data => {
                    chatMessages.innerHTML = '';
                    data.forEach(mensaje => {
                        const div = document.createElement('div');
                        div.className = mensaje.id_emisor == idEmisor ? 'message sent' : 'message received';
                        div.textContent = mensaje.mensaje;
                        chatMessages.appendChild(div);
                    });
                });
        }

        chatForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const idEmisor = document.getElementById('id_emisor').value;
            const idReceptor = document.getElementById('id_receptor').value;
            const mensaje = document.getElementById('mensaje').value;

            fetch('../controlador/controlador_chat.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_emisor=${idEmisor}&id_receptor=${idReceptor}&mensaje=${mensaje}`,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('mensaje').value = '';
                        cargarMensajes();
                    }
                });
        });

        setInterval(cargarMensajes, 3000); // Cargar mensajes cada 3 segundos
    </script>
</body>

</html>