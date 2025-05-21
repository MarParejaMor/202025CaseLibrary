document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('appointmentForm');
    const datetimeInput = document.querySelector('input[type="datetime-local"]');

    // Establecer fecha mínima (hoy)
    datetimeInput.min = new Date().toISOString().slice(0, 16);

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = {
            type: form.type.value,
            date: form.date.value,
            description: form.description.value,
            contact_info: form.contact_info?.value || ''
        };

        try {
            const response = await fetch('appointments.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (result.success) {
                showSuccess('Cita programada exitosamente');
                form.reset();
            } else {
                showError(result.message || 'Error al programar la cita');
            }
        } catch (error) {
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