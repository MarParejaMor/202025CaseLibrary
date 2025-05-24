document.addEventListener("DOMContentLoaded", function () {
  loadPage("dashboard.php");
  document.body.addEventListener("click", function (event) {
      const link = event.target.closest("a");
      if (link && link.getAttribute("href") && !link.getAttribute("target")) {
          event.preventDefault();
          loadPage(link.getAttribute("href"));
      }
  });
});

function loadPage(url) {
  fetch(url)
      .then((response) => {
          if (!response.ok) {
              throw new Error("Error en la respuesta del servidor");
          }
          return response.text();
      })
      .then((php) => {
          const bodyContents = document.getElementById("contenidomenu");
          bodyContents.innerHTML = php;

          deletePreviousScripts(); 
          executeScripts(bodyContents);

      })
      .catch((error) => {
          console.error("Error al cargar el contenido:", error);
          document.getElementById("contenido").innerHTML =
              "<p>Error al cargar el contenido.</p>";
      });
}

function deletePreviousScripts() {
  document.querySelectorAll("script[data-dynamic]").forEach(script => script.remove());
}

function executeScripts(element) {
  const scripts = element.querySelectorAll("script");

  scripts.forEach((oldScript) => {
    const newScript = document.createElement("script");
    newScript.setAttribute("data-dynamic", "true");
    

      if (oldScript.src) {
          const relativeSrc = getRelativePath(oldScript.src);
          newScript.src = relativeSrc;
          if (!document.querySelector(`script[src="${relativeSrc}"]`)) {
              document.body.appendChild(newScript);
          }
      } else {
          newScript.textContent = oldScript.textContent;
          document.body.appendChild(newScript);
      }

      oldScript.remove();
  });
}


function getRelativePath(url) {
  const urlObj = new URL(url, window.location.origin);
  return urlObj.pathname;
}

