<?php
session_start();
require '../config/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.html');
    exit();
}

$idAdmin = 1; // ID del administrador

// Obtener lista de clientes con mensajes
$queryClientes = "SELECT DISTINCT datos.id, datos.nombre FROM datos 
                  JOIN mensajes_chat ON datos.id = mensajes_chat.id_emisor 
                  WHERE mensajes_chat.id_receptor = $idAdmin";
$resultClientes = mysqli_query($conexion, $queryClientes);
$clientes = mysqli_fetch_all($resultClientes, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="css/style_dashboard.css">
    <link rel="stylesheet" href="css/chat.css">
    <link rel="stylesheet" href="../css/chat_style.css">
    <title>Chat Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .chat-container {
            max-width: 1000px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .chat-header {
            background-color: #343a40;
            color: #fff;
            padding: 15px;
            text-align: center;
            font-size: 1.2em;
        }

        .chat-messages {
            height: 500px;
            overflow-y: auto;
            padding: 15px;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .chat-messages .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
        }

        .chat-messages .message.sent {
            background-color: #343a40;
            color: #fff;
            text-align: right;
            align-self: flex-end;
        }

        .chat-messages .message.received {
            background-color: #e9ecef;
            color: #333;
            text-align: left;
            align-self: flex-start;
        }

        .chat-form {
            display: flex;
            padding: 15px;
            background-color: #f1f1f1;
        }

        .chat-form input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        .chat-form button {
            background-color: #343a40;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .chat-form button:hover {
            background-color: #23272b;
        }

        /* Estilos para el diseño de chat estilo iPhone en modo noche */
        .chat-container {
            background-color: #121212;
        }

        .chat-header {
            background-color: #1e1e1e;
        }

        .chat-messages {
            background-color: #121212;
        }

        .chat-messages .message.sent {
            background-color: #007aff;
            color: #fff;
        }

        .chat-messages .message.received {
            background-color: #2c2c2e;
            color: #fff;
        }

        .chat-form {
            background-color: #1e1e1e;
        }

        .chat-form input[type="text"] {
            background-color: #2c2c2e;
            color: #fff;
        }

        .chat-form button {
            background-color: #007aff;
        }

        .chat-form button:hover {
            background-color: #0051ba;
        }

        .timestamp {
            font-size: 0.8em;
            color: #888;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <main>
            <div class="chat-header">
                <h2>Chat</h2>
                <button class="back-button" onclick="window.location.href='dashboard_admin.php'">Volver al Panel
                </button>
            </div>
            <div class="chat-list">
                <h3>Clientes</h3>
                <ul>
                    <?php foreach ($clientes as $cliente): ?>
                    <li>
                        <button class="cliente-btn" data-id="<?= $cliente['id']; ?>">
                            <?= htmlspecialchars($cliente['nombre']); ?>
                        </button>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="chat-messages" id="chat-messages">
                <!-- Los mensajes del chat se cargarán aquí -->
            </div>
            <form id="chat-form" class="chat-form">
                <input type="hidden" id="id_emisor" value="1"> <!-- ID del administrador -->
                <input type="hidden" id="id_receptor">
                <input type="text" id="mensaje" placeholder="Escribe un mensaje..." required>
                <button type="submit" class="btn">Enviar</button>
            </form>
        </main>
    </div>

    <script>
        const chatForm = document.getElementById('chat-form');
        const chatMessages = document.getElementById('chat-messages');
        const clienteBtns = document.querySelectorAll('.cliente-btn');

        clienteBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const idCliente = btn.dataset.id;
                document.getElementById('id_receptor').value = idCliente;
                cargarMensajes(idCliente);
            });
        });

        function cargarMensajes(idCliente) {
            const idEmisor = document.getElementById('id_emisor').value;

            fetch(`../controlador/controlador_chat.php?id_emisor=${idEmisor}&id_receptor=${idCliente}`)
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
                        cargarMensajes(idReceptor);
                    }
                });
        });

        setInterval(() => {
            const idReceptor = document.getElementById('id_receptor').value;
            if (idReceptor) {
                cargarMensajes(idReceptor);
            }
        }, 3000); // Cargar mensajes cada 3 segundos
    </script>
</body>

</html>
