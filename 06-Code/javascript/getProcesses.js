document.addEventListener("DOMContentLoaded", function () {
    fetch('../php/getProcesses.php')  // Reemplaza con la ruta correcta, ej: "api/get_processes.php"
  .then(response => response.json())
  .then(data => {
    const container = document.getElementById('processContainer');
    container.innerHTML = ''; // Limpiar contenido previo

    data.forEach(process => {
      const card = `
        <div class="col-12 col-sm-6 col-lg-4">
          <div class="card bg-dark-card text-white h-100 shadow">
            <div class="card-header"></div>
            <div class="card-body">
              <h6 class="card-subtitle mb-2 text-warning">${process.title}</h6>
              <p class="card-text">${process.description}</p>
            </div>
            <div class="card-footer d-flex justify-content-between">
              <button class="btn btn-outline-light btn-sm">Me gusta</button>
              <button class="btn btn-warning btn-sm">Comentar</button>
            </div>
          </div>
        </div>
      `;
      container.insertAdjacentHTML('beforeend', card);
    });
  })
  .catch(error => {
    console.error('Error al cargar procesos:', error);
  });
}
);
