document.addEventListener('DOMContentLoaded', function () {
    const fechaInput = document.getElementById('fecha');
    const horaSelect = document.getElementById('hora');
    const mensajeHora = document.getElementById('mensaje-hora');

    // Bloquear domingos
    fechaInput.addEventListener('change', function () {
        const fecha = this.value;
        if (!fecha) return;

        const fechaDate = new Date(fecha + 'T00:00:00'); // asegurar formato
        const diaSemana = fechaDate.getDay(); // 0 = domingo

        if (diaSemana === 0) {
            alert('No se puede agendar citas los domingos.');
            this.value = '';
            horaSelect.innerHTML = '<option value="">Seleccione una fecha válida</option>';
            return;
        }

        // OPCIONAL: Console log para depurar
        console.log("Buscando horas para la fecha:", fecha);

        // Mostrar "Cargando..." mientras espera respuesta
        horaSelect.innerHTML = '<option value="">Cargando...</option>';

        fetch(`../controlador/horas_disponibles.php?fecha=${encodeURIComponent(fecha)}`)
            .then(response => response.json())
            .then(data => {
                console.log("Respuesta del servidor:", data); // OPCIONAL: depuración
                horaSelect.innerHTML = '';
                if (data.length === 0) {
                    horaSelect.innerHTML = '<option value="">No hay horarios disponibles</option>';
                    return;
                }

                data.forEach(hora => {
                    const option = document.createElement('option');
                    option.value = hora.hora;
                    option.textContent = hora.hora;

                    if (hora.ocupado) {
                        option.disabled = true;
                        option.textContent += ' (ocupado)';
                        option.style.color = '#999';
                    }

                    // Preseleccionar si estamos actualizando
                    if (typeof horaActual !== "undefined" && typeof fechaActual !== "undefined") {
                        if (hora.hora === horaActual && fecha === fechaActual) {
                            option.selected = true;
                        }
                    }

                    horaSelect.appendChild(option);
                });
            })
            .catch(() => {
                horaSelect.innerHTML = '<option value="">Error al cargar horas</option>';
            });
    });

    // Validación antes de enviar
    const form = document.getElementById('form-cita');
    form.addEventListener('submit', function (e) {
        const seleccion = horaSelect.value;
        const disabledOption = horaSelect.querySelector(`option[value="${seleccion}"]:disabled`);
        if (disabledOption) {
            mensajeHora.style.display = 'block';
            e.preventDefault();
        } else {
            mensajeHora.style.display = 'none';
        }
    });
});
