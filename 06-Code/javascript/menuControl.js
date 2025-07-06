//Este event listener se activa al cargar el contenido de la página
document.addEventListener("DOMContentLoaded", function () {
  //Por defecto, carga el contenido de dashboard.php
  loadPage("dashboard.php");
  //Para cada enlace se agrega un event listener
  document.body.addEventListener("click", function (event) {
      const link = event.target.closest("a");
      if (link && link.getAttribute("href") && !link.getAttribute("target")) {
          //En caso de que el enlace tenga un atributo href y no tenga un atributo target
          event.preventDefault();
          //Carga la pagina internamete
          loadPage(link.getAttribute("href"));
      }
  });
});

//Función para cargar la pa´gina
function loadPage(url) {
  //Recibe y busca el enlace
  fetch(url)
      .then((response) => {
          if (!response.ok) {
              throw new Error("Error en la respuesta del servidor");
          }
          return response.text();//Devuelve el contenido del body
      })
      .then((php) => {
          const bodyContents = document.getElementById("contenidomenu");
          bodyContents.innerHTML = php;
          //carga la respuesta en el div que representa al body
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
  //Quita los scripts dinámicos(Con enlaces externos al proyecto)
  document.querySelectorAll("script[data-dynamic]").forEach(script => script.remove());
}

function executeScripts(element) {
  const scripts = element.querySelectorAll("script");
  //Selecciona todos los scripts antiguos de la página recibida
  scripts.forEach((oldScript) => {
    const newScript = document.createElement("script");
    newScript.setAttribute("data-dynamic", "true");
    //Crea nuevos scripts dinámicos

      if (oldScript.src) {
          const relativeSrc = getRelativePath(oldScript.src);//Extrae el url realitvo de los antiguos
          newScript.src = relativeSrc;//Y lo carga en los nuevos
          if (!document.querySelector(`script[src="${relativeSrc}"]`)) {
              document.body.appendChild(newScript);
          }
      } else {
          newScript.textContent = oldScript.textContent;
          document.body.appendChild(newScript);
      }
      //Quita los scripts viejos
      oldScript.remove();
  });
}


function getRelativePath(url) {
  const urlObj = new URL(url, window.location.origin);
  return urlObj.pathname;
}

