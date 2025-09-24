<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Cliente</title>
    <link rel="stylesheet" href="../css/style_dashboard.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .chat-container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .chat-header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            text-align: center;
            font-size: 1.2em;
        }

        .chat-messages {
            height: 400px;
            overflow-y: auto;
            padding: 15px;
            background-color: #f9f9f9;
        }

        .chat-messages .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
        }

        .chat-messages .message.sent {
            background-color: #007bff;
            color: #fff;
            text-align: right;
        }

        .chat-messages .message.received {
            background-color: #e9ecef;
            color: #333;
            text-align: left;
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
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .chat-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">Chat con Soporte</div>
        <div class="chat-messages" id="chatMessages">
            <!-- Mensajes cargados dinámicamente -->
        </div>
        <form class="chat-form" id="chatForm">
            <input type="text" id="mensaje" placeholder="Escribe tu mensaje...">
            <button type="submit">Enviar</button>
        </form>
    </div>

    <script>
        const chatForm = document.getElementById('chatForm');
        const chatMessages = document.getElementById('chatMessages');

        chatForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const mensaje = document.getElementById('mensaje').value;

            // Simulación de envío de mensaje
            const div = document.createElement('div');
            div.classList.add('message', 'sent');
            div.textContent = mensaje;
            chatMessages.appendChild(div);

            document.getElementById('mensaje').value = '';

            // Simulación de respuesta
            setTimeout(() => {
                const div = document.createElement('div');
                div.classList.add('message', 'received');
                div.textContent = 'Gracias por tu mensaje. Te responderemos pronto.';
                chatMessages.appendChild(div);
            }, 1000);
        });
    </script>
</body>
</html>
