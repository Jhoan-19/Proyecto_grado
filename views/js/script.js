function consulta_buscador(busqueda){


    var dato= 'busca';
    var parametros = {"busqueda": busqueda, "dato": dato};
    $.ajax({
        data: parametros,
        url: '', 
        type: 'POST',
        beforeSend: function() {
            // Acción antes de enviar la petición
        },
        success: function(data) {
            // Acción si la petición es exitosa
        },
        error: function(data, error) {
            // Acción si ocurre un error
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    var btn = document.getElementById('btn-continuar');
    var modal = document.getElementById('modal-mensaje');
    if (btn && modal) {
        btn.onclick = function() {
            modal.style.display = 'none';
            window.location.href = "index.php";
        };
    }
});

// js/script.js
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggle-password').forEach(function(icon) {
        icon.addEventListener('click', function() {
            // Busca el input con clase .input-password dentro del mismo contenedor
            const input = this.parentElement.querySelector('.input-password');
            if (input) {
                if (input.type === "password") {
                    input.type = "text";
                    this.classList.remove('bx-show');
                    this.classList.add('bx-hide');
                } else {
                    input.type = "password";
                    this.classList.remove('bx-hide');
                    this.classList.add('bx-show');
                }
            }
        });
    });
});