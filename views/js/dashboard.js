const sideMenu = document.querySelector('aside');
const menuBtn = document.getElementById('menu-btn');
const closeBtn = document.getElementById('close-btn');
const darkMode = document.querySelector('.dark-mode');
let lightIcon, darkIcon;

// Aplica el modo oscuro según localStorage, aunque no haya darkMode en la página
function applyDarkModeSetting() {
    const isDark = localStorage.getItem('darkMode') === 'enabled';
    document.body.classList.toggle('dark-mode-variables', isDark);

    // Si existen los iconos, sincronízalos
    if (darkMode) {
        lightIcon = darkMode.querySelector('span:nth-child(1)');
        darkIcon = darkMode.querySelector('span:nth-child(2)');
        if (isDark) {
            lightIcon.classList.remove('active');
            darkIcon.classList.add('active');
        } else {
            lightIcon.classList.add('active');
            darkIcon.classList.remove('active');
        }
    }
}


window.addEventListener('DOMContentLoaded', applyDarkModeSetting);

if (menuBtn && sideMenu) {
    menuBtn.addEventListener('click', () => {
        sideMenu.style.display = 'block';
    });
}

if (closeBtn && sideMenu) {
    closeBtn.addEventListener('click', () => {
        sideMenu.style.display = 'none';
    });
}

if (darkMode) {
    lightIcon = darkMode.querySelector('span:nth-child(1)');
    darkIcon = darkMode.querySelector('span:nth-child(2)');
    darkMode.addEventListener('click', () => {
        const isDark = document.body.classList.toggle('dark-mode-variables');
        lightIcon.classList.toggle('active', !isDark);
        darkIcon.classList.toggle('active', isDark);
        localStorage.setItem('darkMode', isDark ? 'enabled' : 'disabled');
    });
}

/*
 * Confirmaciones para acciones críticas (cancelar cita, eliminar perfil)
 * Se agrega aquí porque todas las páginas cargan dashboard.js,
 * así garantizas que el aviso funcione en cualquier vista donde estén los formularios.
 */
window.addEventListener('DOMContentLoaded', () => {
    // Confirmar antes de cancelar una cita
    document.querySelectorAll('.form-cancelar-cita').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('¿Estás seguro de que deseas cancelar tu cita? Esta acción no se puede deshacer.')) {
                e.preventDefault();
            }
        });
    });

    // Confirmar antes de eliminar el perfil de usuario
    document.querySelectorAll('.form-borrar-perfil').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('¿Estás seguro de eliminar tu perfil? Se eliminarán también todas tus citas y tu información personal. Esta acción es irreversible.')) {
                e.preventDefault();
            }
        });
    });
});

// Confirmación para convertir a admin
document.querySelectorAll('.form-cambiar-cargo').forEach(form => {
    form.addEventListener('submit', function(e) {
        const nuevoCargo = form.querySelector('input[name="nuevo_cargo"]').value;
        if (nuevoCargo == "1") {
            if (!confirm('¿Estás seguro que quieres convertir este perfil a administrador? El usuario podrá modificar y eliminar información importante.')) {
                e.preventDefault();
            }
        }
    });
});

