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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/pDashboard.css">
  </head>
  <body class="d-flex flex-column min-vh-100">

    <!-- Navbar principal -->
    <header class="bg-dark-card text-white py-3 shadow-sm">
      <div class="container d-flex justify-content-between align-items-center">
        <div class="fw-bold fs-5">🖼️ Abg. Luz Romero</div>
        <nav>
          <a href="#" class="text-white me-3 text-decoration-none">Inicio</a>
          <a href="../html/Perfil_privado.php" class="text-white me-3 text-decoration-none">Perfil</a>
          <a href="#" class="text-white text-decoration-none">Ajustes</a>
        </nav>
      </div>
    </header>

    <!-- Contenido principal -->
    <main class="container my-5 flex-grow-1">
      <h1 class="mb-4">Procesos</h1>
      <div class="row">
        <div class="col-auto">
          <button class="btn btn-success mb-3">
            <i class="bi bi-plus"></i>
            Agregar Proceso
          </button>
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
