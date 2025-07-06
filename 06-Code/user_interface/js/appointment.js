document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('appointmentForm');
    if (!form) return;

    const datetimeInput = form.querySelector('input[type="datetime-local"]');
    if (datetimeInput) {
        datetimeInput.min = new Date().toISOString().slice(0, 16);
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Limpiar alertas previas
        const alerts = form.parentNode.querySelectorAll('.alert');
        alerts.forEach(alert => alert.remove());

        const formData = {
            type: form.type?.value || '',
            date: form.date?.value || '',
            description: form.description?.value || '',
            contact_info: form.contact_info?.value || ''
        };

        try {
            const response = await fetch('/LOGIN/php/appointments.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            });

            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }

            const result = await response.json();

            if (result.success) {
                showSuccess('Cita programada exitosamente');
                form.reset();
            } else {
                showError(result.message || 'Error al programar la cita');
            }
        } catch {
            showError('Error de conexión con el servidor');
        }
    });

    function showSuccess(message) {
        const alert = document.createElement('div');
        alert.className = 'alert alert-success mt-3';
        alert.textContent = message;
        form.parentNode.insertBefore(alert, form.nextSibling);
        setTimeout(() => alert.remove(), 3000);
    }

    function showError(message) {
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger mt-3';
        alert.textContent = message;
        form.parentNode.insertBefore(alert, form.nextSibling);
        setTimeout(() => alert.remove(), 3000);
    }
});

