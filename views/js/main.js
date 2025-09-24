// Lógica genérica para manejar formularios de auditorías, avances y novedades

document.addEventListener('DOMContentLoaded', function() {
    // Detecta el formulario presente en la página
    const form = document.querySelector('form');
    const reportContainer = document.getElementById('reportContainer') || document.getElementById('auditorias-list') || document.getElementById('avances-list') || document.getElementById('novedades-list');

    if (!form || !reportContainer) return;

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        // Detecta campos comunes
        const id = form.querySelector('[name="work-id"]')?.value;
        const details = form.querySelector('[name="workDetails"], [name="audit-detail"], [name="task"], [name="update"], [name="comments"]')?.value;
        const progress = form.querySelector('[name="progress"]')?.value;
        const photos = form.querySelector('[type="file"]')?.files;

        // Validación básica
        if (!id || (!details && !progress)) {
            alert('Por favor, complete todos los campos obligatorios.');
            return;
        }

        // Genera el reporte visual según el formulario
        const report = document.createElement('div');
        report.classList.add('report');

        const reportId = document.createElement('h3');
        reportId.textContent = `ID del Trabajo: ${id}`;
        report.appendChild(reportId);

        if (details) {
            const reportDetails = document.createElement('p');
            reportDetails.textContent = `Detalle: ${details}`;
            report.appendChild(reportDetails);
        }

        if (progress) {
            const reportProgress = document.createElement('p');
            reportProgress.textContent = `Avance: ${progress}%`;
            report.appendChild(reportProgress);
        }

        if (photos && photos.length > 0) {
            const photoList = document.createElement('div');
            photoList.classList.add('photo-list');
            for (let i = 0; i < photos.length; i++) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(photos[i]);
                img.alt = `Foto ${i + 1}`;
                img.classList.add('uploaded-photo');
                photoList.appendChild(img);
            }
            report.appendChild(photoList);
        }

        reportContainer.appendChild(report);
        form.reset();
    });
});