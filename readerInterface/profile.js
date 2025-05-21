document.addEventListener("DOMContentLoaded", () => {
    fetch("profile.php")
        .then(response => {
            if (!response.ok) {
                throw new Error("Error de red o del servidor");
            }
            return response.json();
        })
        .then(data => {
            document.getElementById("profileName").textContent = data.name + " " + data.lastname;
            document.getElementById("profileTitle").textContent = data.title || "Sin título";
            document.getElementById("profileEmail").textContent = data.email;
            document.getElementById("profilePhone").textContent = data.phone_number;
            document.getElementById("profileBio").textContent = data.bio || "Sin biografía.";

            // Imagen de perfil
            if (data.profile_picture) {
                document.querySelector(".card-img-top").src = data.profile_picture;
            }

            // Certificaciones
            const container = document.getElementById("qualificationsList");
            container.innerHTML = ""; // Limpiar si ya existían
            if (Array.isArray(data.qualifications)) {
                data.qualifications.forEach(q => {
                    const col = document.createElement("div");
                    col.className = "col-md-6 mb-3";

                    const item = `
                        <div class="border p-3 rounded bg-light shadow-sm">
                            <h5>${q.role}</h5>
                            <p class="mb-1"><strong>${q.institution}</strong> (${q.startYear} - ${q.endYear})</p>
                            <p class="mb-0 text-muted">${q.qualification_type} - ${q.place}</p>
                        </div>
                    `;

                    col.innerHTML = item;
                    container.appendChild(col);
                });
            } else {
                container.innerHTML = "<p class='text-muted'>No hay certificaciones registradas.</p>";
            }
        })
        .catch(error => {
            console.error("Error al cargar el perfil:", error);
            alert("No se pudo cargar la información del perfil.");
        });
});
