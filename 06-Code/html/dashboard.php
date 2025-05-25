<?php
session_start();
include("../php/getProcesses.php");
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Publicaciones · Luz Romero</title>
    <link rel="stylesheet" href="../css/pDashboard.css">
  </head>
  <body class="d-flex flex-column min-vh-100">
    <!-- Contenido principal -->
    <main class="container my-5 flex-grow-1">
      <h1 class="mb-4">Procesos</h1>
      <div class="row">
        <div class="col-auto">
          <a class="btn btn-success mb-3" href='agregarCaso.html'>
            <i class="bi bi-plus"></i>
            Agregar Proceso
          </a>
        </div>
      </div>
      <div class="row g-4" id="processCardContainer">

        <!-- Event Cards -->
        <?php
          echo($html);
          ?>
      </div>
    </main>

    

   <script src="../javascript/selectProcess.js"></script>
  </body>
</html>
