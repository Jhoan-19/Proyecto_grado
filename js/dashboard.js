// JavaScript for handling dynamic loading and form submissions
// This file is referenced in the dashboard_admin.php

// Load data dynamically
function loadData(url, targetElementId) {
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const targetElement = document.getElementById(targetElementId);
            targetElement.innerHTML = data.map(item => {
                return `<div>${Object.entries(item).map(([key, value]) => `<strong>${key}:</strong> ${value}`).join(' | ')}</div>`;
            }).join('');
        });
}

// Submit form data
function submitForm(formId, url, callback) {
    const form = document.getElementById(formId);
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch(url, {
            method: 'POST',
            body: formData
        }).then(() => callback());
    });
}

// Initialize
window.onload = function () {
    loadData('../controlador/controlador_avances.php?action=list', 'avances-list');
    loadData('../controlador/controlador_novedades.php?action=list', 'novedades-list');
    loadData('../controlador/controlador_auditorias.php?action=list', 'auditorias-list');

    submitForm('avances-form', '../controlador/controlador_avances.php?action=add', () => loadData('../controlador/controlador_avances.php?action=list', 'avances-list'));
    submitForm('novedades-form', '../controlador/controlador_novedades.php?action=add', () => loadData('../controlador/controlador_novedades.php?action=list', 'novedades-list'));
    submitForm('auditorias-form', '../controlador/controlador_auditorias.php?action=add', () => loadData('../controlador/controlador_auditorias.php?action=list', 'auditorias-list'));
};
