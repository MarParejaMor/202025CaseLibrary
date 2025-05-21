document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const casesContainer = document.getElementById('casesContainer');
    let allCases = [];

    // Cargar casos iniciales
    const loadCases = async () => {
        try {
            const response = await fetch('http://localhost/LOGIN/cases.php');
            const data = await response.json();
            allCases = data.data;
            renderCases(allCases);
        } catch (error) {
            console.error('Error:', error);
            showError('Error al cargar los casos');
        }
    };

    // Función de filtrado
    const filterCases = () => {
        const searchTerm = searchInput.value.toLowerCase();
        const status = statusFilter.value;

        const filtered = allCases.filter(caso => {
            const matchesSearch = 
                caso.title.toLowerCase().includes(searchTerm) ||
                caso.process_number.includes(searchTerm) ||
                caso.process_type.toLowerCase().includes(searchTerm) ||
                caso.process_id.toString().includes(searchTerm);

            const matchesStatus = status === 'all' || caso.process_status === status;

            return matchesSearch && matchesStatus;
        });

        renderCases(filtered);
    };

    // Renderizar casos
    const renderCases = (cases) => {
        casesContainer.innerHTML = cases.map(caso => `
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">${caso.title}</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <span class="badge ${getStatusClass(caso.process_status)}">
                                ${formatStatus(caso.process_status)}
                            </span>
                        </p>
                        <p><strong>Número:</strong> ${caso.process_number}</p>
                        <p><strong>Tipo:</strong> ${caso.process_type}</p>
                        <p><strong>Ubicación:</strong> ${caso.canton}, ${caso.province}</p>
                        <p class="text-muted">${truncateText(caso.process_description, 100)}</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <small class="text-muted">Última actualización: ${formatDate(caso.last_update)}</small>
                    </div>
                </div>
            </div>
        `).join('');
    };

    // Funciones auxiliares
    const getStatusClass = (status) => {
        const statusClasses = {
            'not started': 'bg-secondary',
            'in progress': 'bg-info',
            'suspended': 'bg-warning',
            'finished': 'bg-success'
        };
        return statusClasses[status] || 'bg-secondary';
    };

    const formatStatus = (status) => {
        const statusNames = {
            'not started': 'No Iniciado',
            'in progress': 'En Progreso',
            'suspended': 'Suspendido',
            'finished': 'Finalizado'
        };
        return statusNames[status] || status;
    };

    const truncateText = (text, maxLength) => {
        return text?.length > maxLength ? text.substr(0, maxLength) + '...' : text;
    };

    const formatDate = (dateString) => {
        if (!dateString) return 'N/A';
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('es-ES', options);
    };

    const showError = (message) => {
        casesContainer.innerHTML = `
            <div class="col-12">
                <div class="alert alert-danger">${message}</div>
            </div>
        `;
    };

    // Event listeners
    searchInput.addEventListener('input', filterCases);
    statusFilter.addEventListener('change', filterCases);

    // Cargar casos iniciales
    loadCases();
});