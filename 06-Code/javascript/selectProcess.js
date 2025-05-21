//Event listener for editing a process
$(document).ready(function()
{
    $(document).on("click", ".edit-process", function() {
    const id = $(this).data("process-id");
    // Enviar el mensaje a la API
    $.ajax({
    url: '../php/chooseProcess.php',
    method: 'POST',
    data: { process_id: id },
    success: function(response) {
        console.log(response);
       Window.Location.href="processDashboard.php";
    },
    error: function(response) {
            console.log("Error en la conexion");
            }
        });
    });
})