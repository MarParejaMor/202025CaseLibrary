document.addEventListener('DOMContentLoaded', async () => {
    // Actualizar estadísticas
    try {
        const [casesResponse, appointmentsResponse] = await Promise.all([
            fetch('http://localhost/LOGIN/php/cases.php'),
            fetch('http://localhost/LOGIN/php/appointment.php')
        ]);

        const casesData = await casesResponse.json();
        const appointmentsData = await appointmentsResponse.json();

        // Actualizar contadores
        document.getElementById('activeCases').textContent = 
            casesData.data.filter(c => c.process_status === 'in progress').length;
        
        document.getElementById('scheduledAppointments').textContent = 
            appointmentsData.data.length;

        // Actualizar actividad reciente
        const recentActivity = document.getElementById('recentActivity');
        recentActivity.innerHTML = casesData.data
            .slice(0, 3)
            .map(caso => `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>${caso.title}</span>
                    <span class="badge ${getStatusClass(caso.process_status)}">
                        ${formatStatus(caso.process_status)}
                    </span>
                </li>
            `).join('');

    } catch (error) {
        console.error('Error loading dashboard data:', error);
    }

    // Funciones compartidas
    function getStatusClass(status) {
        const statusClasses = {
            'not started': 'bg-secondary',
            'in progress': 'bg-info',
            'suspended': 'bg-warning',
            'finished': 'bg-success'
        };
        return statusClasses[status] || 'bg-secondary';
    }

    function formatStatus(status) {
        const statusNames = {
            'not started': 'No Iniciado',
            'in progress': 'En Progreso',
            'suspended': 'Suspendido',
            'finished': 'Finalizado'
        };
        return statusNames[status] || status;
    }
});
