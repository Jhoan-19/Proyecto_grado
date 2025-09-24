document.addEventListener('DOMContentLoaded', function () {
    const fechaInput = document.getElementById('fecha');
    const horaSelect = document.getElementById('hora');
    const mensajeHora = document.getElementById('mensaje-hora');

    // Variables PHP exportadas al script (debes definirlas en PHP)
    const horaActual = window.horaActual || "";
    const fechaActual = window.fechaActual || "";

    fechaInput.addEventListener('change', function () {
        const fecha = this.value;
        if (!fecha) return;

        const fechaDate = new Date(fecha + 'T00:00:00');
        const diaSemana = fechaDate.getDay(); // 0 = domingo

        if (diaSemana === 0) {
            alert('No se puede agendar citas los domingos.');
            this.value = '';
            horaSelect.innerHTML = '<option value="">Seleccione una fecha válida</option>';
            return;
        }

        horaSelect.innerHTML = '<option value="">Cargando...</option>';

        fetch(`../controlador/horas_disponibles.php?fecha=${encodeURIComponent(fecha)}`)
            .then(response => {
                if (!response.ok) throw new Error("Error al obtener horarios");
                return response.json();
            })
            .then(data => {
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

                    if (hora.hora === horaActual && fecha === fechaActual) {
                        option.selected = true;
                    }

                    horaSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error("Error al cargar horas:", error);
                horaSelect.innerHTML = '<option value="">Error al cargar horas</option>';
            });
    });

    const form = document.querySelector('.formulario-actualizar');
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

    if (fechaInput.value) {
        fechaInput.dispatchEvent(new Event('change'));
    }
});
