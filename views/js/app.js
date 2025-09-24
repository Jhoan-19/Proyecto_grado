console.log("JavaScript cargado correctamente.");

/*codigo de js de la pagina principal para mostrar mas carros */
function toggleExtra() {
    const extras = document.querySelectorAll('.extra');
    extras.forEach(section => {
        section.style.display = section.style.display === 'flex' ? 'none' : 'flex';
    });

    const btn = document.querySelector('.btn');
    btn.textContent = btn.textContent === 'Ver más carros' ? 'Ver menos carros' : 'Ver más carros';
}
/*codigo de js de la pagina catalogo para el carrusel de las imagenes */

document.addEventListener("DOMContentLoaded", () => {
    const slider = document.querySelector('.slider');
    const scrollAmount = 200; // Ajusta el valor según necesites
    
    const leftArrow = document.querySelector('.left-arrow');
    const rightArrow = document.querySelector('.right-arrow');

    // Verificar que se cargó el JavaScript
    console.log("JavaScript cargado correctamente.");

    leftArrow.addEventListener('click', () => {
        console.log("Botón izquierdo presionado"); // Verificar si este mensaje aparece en la consola

        // Si está al inicio, vuelve al final
        if (slider.scrollLeft <= 0) {
            slider.scrollLeft = slider.scrollWidth;
            console.log("Regresando al final del carrusel");
        } else {
            slider.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        }
        console.log("Posición actual al ir a la izquierda:", slider.scrollLeft);
    });

    rightArrow.addEventListener('click', () => {
        console.log("Botón derecho presionado"); // Verificar si este mensaje aparece en la consola

        // Si está al final, vuelve al inicio
        if (slider.scrollLeft + slider.offsetWidth >= slider.scrollWidth) {
            slider.scrollLeft = 0;
            console.log("Regresando al inicio del carrusel");
        } else {
            slider.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }
        console.log("Posición actual al ir a la derecha:", slider.scrollLeft);
    });
});


/*------------------------------------- */

document.addEventListener("DOMContentLoaded", function() {
    cargarCarros();
    cargarNoticias();
});

function cargarCarros() {
    const carros = [
        { marca: 'Toyota', modelo: 'Corolla', precio: 15000 },
        { marca: 'Honda', modelo: 'Civic', precio: 17000 },
        { marca: 'Ford', modelo: 'Mustang', precio: 25000 },
    ];

    let carrosHTML = '';
    carros.forEach(carro => {
        carrosHTML += `
            <div class="carro">
                <h3>${carro.marca} ${carro.modelo}</h3>
                <p>Precio: $${carro.precio}</p>
            </div>
        `;
    });
    
    document.getElementById('carros').innerHTML = carrosHTML;
}

function cargarNoticias() {
    const noticias = [
        { titulo: 'Nuevo lanzamiento', contenido: 'Presentamos el nuevo modelo 2024.' },
        { titulo: 'Promoción de Octubre', contenido: '¡Descuentos de hasta el 20% en nuestros servicios de taller!' },
    ];

    let noticiasHTML = '';
    noticias.forEach(noticia => {
        noticiasHTML += `
            <div class="noticia">
                <h4>${noticia.titulo}</h4>
                <p>${noticia.contenido}</p>
            </div>
        `;
    });

    document.getElementById('noticias-content').innerHTML = noticiasHTML;
}
document.addEventListener("DOMContentLoaded", function() {
    // Aquí puedes cargar carros y noticias dinámicamente si los tienes en una base de datos.
    console.log("Página cargada correctamente.");
});
// Agregar evento al formulario de agendamiento
document.getElementById("form-cita").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevenir que el formulario se envíe automáticamente

  // Obtener los valores de los campos
  const nombre = document.getElementById("nombre").value;
  const vehiculo = document.getElementById("vehiculo").value;
  const fecha = document.getElementById("fecha").value;
  const hora = document.getElementById("hora").value;
  const servicio = document.getElementById("servicio").value;

  // Validar si los campos están completos
  if (nombre === "" || vehiculo === "" || fecha === "" || hora === "" || servicio === "") {
      alert("Por favor, completa todos los campos antes de agendar la cita.");
      return; // Detener si hay algún campo vacío
  }

  // Guardar los datos en localStorage
  localStorage.setItem("nombre", nombre);
  localStorage.setItem("vehiculo", vehiculo);
  localStorage.setItem("fecha", fecha);
  localStorage.setItem("hora", hora);
  localStorage.setItem("servicio", servicio);

  // Redirigir a la página de confirmación
  window.location.href = "confirmacion.html";
});


// 
const imagenes = [
    "img/chevrolet_carros/alto/1.jpg",
    "img/chevrolet_carros/alto/2.jpg",
    "img/chevrolet_carros/alto/3.jpg",
    "img/chevrolet_carros/alto/4.jpg",
    "img/chevrolet_carros/alto/5.jpg",
    "img/chevrolet_carros/alto/6.jpg",
    "img/chevrolet_carros/alto/7.jpg",
    "img/chevrolet_carros/alto/8.jpg",
    "img/chevrolet_carros/alto/9.jpg",
    "img/chevrolet_carros/alto/10.jpg",
    "img/chevrolet_carros/alto/11.jpg",
    "img/chevrolet_carros/alto/12.jpg",
];

let indiceActual = 0;

function cambiarImagen(direccion) {
    indiceActual += direccion;

    // Ciclar las imágenes
    if (indiceActual < 0) {
        indiceActual = imagenes.length - 1;
    } else if (indiceActual >= imagenes.length) {
        indiceActual = 0;
    }

    document.getElementById("imagen-galeria").src = imagenes[indiceActual];
}
