// Obtener datos de localStorage y mostrarlos en la página
document.getElementById("conf-nombre").textContent = localStorage.getItem("nombre");
document.getElementById("conf-vehiculo").textContent = localStorage.getItem("vehiculo");
document.getElementById("conf-fecha").textContent = localStorage.getItem("fecha");
document.getElementById("conf-hora").textContent = localStorage.getItem("hora");
document.getElementById("conf-servicio").textContent = localStorage.getItem("servicio");

// Función para imprimir la cita
function imprimirCita() {
    window.print();
}

// Función para descargar la cita en un archivo de texto
function descargarCita() {
    const nombre = localStorage.getItem("nombre");
    const vehiculo = localStorage.getItem("vehiculo");
    const fecha = localStorage.getItem("fecha");
    const hora = localStorage.getItem("hora");
    const servicio = localStorage.getItem("servicio");

    const contenido = `Cita de Taller TurboCars\n\nNombre: ${nombre}\nVehículo: ${vehiculo}\nFecha: ${fecha}\nHora: ${hora}\nServicio: ${servicio}`;
    const blob = new Blob([contenido], { type: "text/plain" });
    const enlace = document.createElement("a");
    enlace.href = URL.createObjectURL(blob);
    enlace.download = "Cita_TurboCars.txt";
    enlace.click();
}

// Función para cancelar la cita (opcional: podría hacer algo más)
function cancelarCita() {
    if (confirm("¿Estás seguro de que quieres cancelar la cita?")) {
        window.location.href = "index.html";
    }
}
