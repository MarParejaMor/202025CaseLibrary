document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const casesContainer = document.getElementById('casesContainer');
    let allCases = [];

    // Cargar casos desde el servidor
    const loadCases = async () => {
        try {
            const response = await fetch('../php/cases.php'); // usa ruta relativa si llamas desde /html
            const data = await response.json();

            if (!data.success || !Array.isArray(data.data)) {
                throw new Error(data.message || 'Respuesta inválida del servidor');
            }

            allCases = data.data;
            renderCases(allCases);
        } catch (error) {
            console.error('Error:', error);
            showError('Error al cargar los casos');
        }
    };

    // Filtrar los casos por búsqueda y estado
    const filterCases = () => {
        const searchTerm = searchInput.value.toLowerCase();
        const status = statusFilter.value;

        const filtered = allCases.filter(caso => {
            const matchesSearch =
                (caso.title?.toLowerCase().includes(searchTerm) ?? false) ||
                (caso.process_number?.toLowerCase().includes(searchTerm) ?? false) ||
                (caso.process_type?.toLowerCase().includes(searchTerm) ?? false) ||
                caso.process_id?.toString().includes(searchTerm);

            const matchesStatus = status === 'all' || caso.process_status === status;

            return matchesSearch && matchesStatus;
        });

        renderCases(filtered);
    };

    // Mostrar los casos en tarjetas
    const renderCases = (cases) => {
        if (!cases.length) {
            casesContainer.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-info">No se encontraron casos.</div>
                </div>
            `;
            return;
        }

        casesContainer.innerHTML = cases.map(caso => `
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header ${getStatusClass(caso.process_status)} text-white">
                        <h5 class="card-title mb-0">${caso.title || 'Sin título'}</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            <span class="badge ${getStatusClass(caso.process_status)}">
                                ${formatStatus(caso.process_status)}
                            </span>
                        </p>
                        <p><strong>Número:</strong> ${caso.process_number || 'N/A'}</p>
                        <p><strong>Tipo:</strong> ${caso.process_type || 'N/A'}</p>
                        <p><strong>Ubicación:</strong> ${caso.canton || '¿?'} - ${caso.province || '¿?'}</p>
                        <p class="text-muted">${truncateText(caso.process_description, 100)}</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <small class="text-muted">Última actualización: ${formatDate(caso.last_update)}</small>
                    </div>
                </div>
            </div>
        `).join('');
    };

    // Estilos según estado del proceso
    const getStatusClass = (status) => {
        const statusClasses = {
            'not started': 'bg-secondary',
            'in progress': 'bg-info',
            'suspended': 'bg-warning',
            'finished': 'bg-success'
        };
        return statusClasses[status] || 'bg-dark';
    };

    // Nombres traducidos de estado
    const formatStatus = (status) => {
        const statusNames = {
            'not started': 'No Iniciado',
            'in progress': 'En Progreso',
            'suspended': 'Suspendido',
            'finished': 'Finalizado'
        };
        return statusNames[status] || status;
    };

    // Truncar texto largo
    const truncateText = (text, maxLength) => {
        return text?.length > maxLength ? text.substring(0, maxLength) + '...' : text || '';
    };

    // Formato de fecha
    const formatDate = (dateString) => {
        if (!dateString) return 'N/A';
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('es-ES', options);
    };

    // Mostrar error
    const showError = (message) => {
        casesContainer.innerHTML = `
            <div class="col-12">
                <div class="alert alert-danger">${message}</div>
            </div>
        `;
    };

    // Eventos
    searchInput?.addEventListener('input', filterCases);
    statusFilter?.addEventListener('change', filterCases);

    // Inicialización
    loadCases();
});
