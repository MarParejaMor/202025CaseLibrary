document.addEventListener("DOMContentLoaded", () => {
    fetch("http://localhost/LOGIN/php/profile.php")
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }

            // Validar campos mínimos
            if (typeof data.name !== 'string' || typeof data.lastname !== 'string') {
                throw new Error("Estructura de datos inválida: nombre o apellido faltantes");
            }

            document.getElementById("profileName").textContent = `${data.name} ${data.lastname}`;
            document.getElementById("profileTitle").textContent = data.title || "";
            document.getElementById("profileEmail").textContent = data.email || "No disponible";
            document.getElementById("profilePhone").textContent = data.phone_number || "No registrado";
            document.getElementById("profileBio").textContent = data.bio || "";

            const container = document.getElementById("qualificationsList");
            container.innerHTML = "";

            // Verifica que qualifications sea un array
            if (Array.isArray(data.qualifications)) {
                data.qualifications.forEach(q => {
                    const col = document.createElement("div");
                    col.className = "col-md-6 mb-3";
                    col.innerHTML = `
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">${q.qualification_type || "Sin título"}</h5>
                                <p class="card-text">
                                    <strong>Institución:</strong> ${q.institution || "N/A"}<br>
                                    <strong>Rol:</strong> ${q.role || "N/A"}<br>
                                    <strong>Periodo:</strong> ${q.startYear || "?"} - ${q.endYear || "?"}
                                </p>
                                ${q.place ? `<p><small>Lugar: ${q.place}</small></p>` : ''}
                            </div>
                        </div>
                    `;
                    container.appendChild(col);
                });
            } else {
                // Si no hay certificaciones, opcionalmente muestra mensaje o lo deja vacío
                container.innerHTML = "<p>No hay certificaciones registradas.</p>";
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert(`Error al cargar el perfil: ${error.message}`);
        });
});
