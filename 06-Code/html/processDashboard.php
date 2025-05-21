<?php
session_start();
include("../php/getProcessData.php");
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Publicaciones · Luz Romero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/pDashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body class="d-flex flex-column min-vh-100">

    <!-- Navbar principal -->
    <header class="bg-dark-card text-white py-3 shadow-sm">
      <div class="container d-flex justify-content-between align-items-center">
        <div class="fw-bold fs-5">🖼️ Abg. Luz Romero</div>
        <nav>
          <a href="#" class="text-white me-3 text-decoration-none">
            <i class="bi bi-house"></i>Inicio</a>
          <a href="../html/Perfil_privado.php" class="text-white me-3 text-decoration-none">
            <i class="bi bi-person-circle"></i>
            Perfil</a>
          <a href="#" class="text-white text-decoration-none">
            <i class="bi bi-journal-bookmark"></i>
            Ajustes</a>
        </nav>
      </div>
    </header>

    <!-- Segundo navbar -->
    <nav class="navbar navbar-expand-lg text-light bg-second-nav shadow-sm position-sticky">
      <div class="container align-content-center justify-content-evenly">
        <h4 class="mx-2">Caso <?php 
        echo(htmlspecialchars($currentProcess['process_number'])); 
        ?></h4>
        <ul class="navbar-nav mb-2 mb-lg-0 justify-content-evenly">
          <li class="nav-item">
            <i class="bi bi-info"></i>
            <a class="nav-link link-light active" aria-current="page" href="processDashboard.html">Información general</a>
          </li>
          <li class="nav-item ">
             <i class="bi bi-calendar4-week"></i>
            <a class="nav-link link-light active" aria-current="page" href="processDashboard.html">Desarrollo</a>
          </li>
          <li class="nav-item">
            <i class="bi bi-file-earmark-fill"></i>
            <a class="nav-link link-light active" aria-current="page" href="#">Evidencias</a>
          </li>
          <li class="nav-item">
            <i class="bi bi-search"></i>
            <a class="nav-link link-light active" aria-current="page" href="#">Observaciones</a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Contenido principal -->
    <main class="container my-5 flex-grow-1">
      <h1 class="mb-4">Informacion General del Proceso</h1>
      <div class="row">
        <div class="col-auto">
          <button class="btn btn-info mb-3" id="editButton" onclick="enableEdition()">
            <i class="bi bi-pencil"></i>
            Editar
          </button>
        </div>
      </div>
      <div class="row g-4">
        <form id="processEditionForm" name="processEditionForm">
            <div class="container mt-4 mx-auto col-sm-10" id="processInfoContainer">
                <div class="mb-3">
                            <label for="title" class="form-label">Título:</label>
                            <input type="text" disabled class=" form-control text-black" id="processTitle" name="processTitle" placeholder="Título para los lectores" onchange="titleControl()" 
                            value=" <?php echo($currentProcess['title']); ?>" 
                            required>
                    </div>
                <div class="row mb-3">
                    <div class="col-sm-auto">
                    <label for="processType" class="form-label">Tipo de proceso:</label>
                    <select class="form-select" disabled id="processType" name="processType" required>
                        <option value=""></option>
                        <?php
                            $types=["penal","civil","constitucional","administrativo", "laboral"];
                            foreach($types as $type)
                            {
                                $selected=($currentProcess['process_type'] == $type)?"selected":"";
                                echo("<option value=".$type." ".$selected.">".ucfirst($type)."</option>");
                            }
                        ?>
                    </select>
                </div>
                </div>
                <div class="mb-3">
                    <label for="conflict" class=" form-label col-form-label">Controversia/Conflicto:</label>
                    <input type="text" disabled class="form-control" id="conflict" name="conflict" 
                    value=" <?php echo($currentProcess['offense']); ?>" 
                    required onchange="conflictControl()">
                </div>
                <div class="mb-3">
                            <label for="title" class="form-label">Resumen:</label>
                            <textarea disabled class=" form-control" id="processResume" name="processResume" required><?=htmlspecialchars($currentProcess['process_description']); ?></textarea>
                </div>
                <div class="row mb-3 justify-content-evenly">
                    <p class="h5 mb-1">Datos del cliente</p>
                    <div class="col-sm-6 mt-1">
                        <label class="form-label">Genero:</label><br>
                        <select id="gender" disabled name="gender" class="form-select">
                            <option value=""></option>
                            <?php
                            $genders=["mujer","hombre"];
                            foreach($genders as $gender)
                            {
                                $selected=($currentProcess['client_gender'] == $gender)?"selected":"";
                                echo("<option value=".$gender." ".$selected.">".ucfirst($gender)."</option>");
                            }
                        ?>
                        </select>
                    </div>
                    <div class="col-sm-6 mt-1">
                        <label class="form-label">Edad:</label><br>
                        <input type="number" disabled name="age" id="age" min="7" step="1" class="form-control" 
                        value="<?php echo(htmlspecialchars((int)$currentProcess['client_age']??'')); ?>" 
                        required>
                    </div>
                </div>
                <div class="row mb-3 justify-content-evenly">
                    <div class="col-sm-6">
                        <label for="title" class="form-label">Provincia:</label>
                        <select class="form-select" disabled id="province" name="province" required value="Azuay">
                            <option value=""></option>
                            <?php
                                $provinces = ["Azuay", "Bolivar", "Caniar", "Carchi", "Chimborazo", "Cotopaxi", "El_Oro", "Esmeraldas", "Galapagos", "Guayas", "Imbabura", "Loja", "Los_Rios", "Manabi", "Morona_Santiago", "Napo", "Orellana", "Pastaza", "Pichincha", "Santa_Elena", "Santo_Domingo", "Sucumbios", "Tungurahua", "Zamora_Chinchipe"];
                                foreach($provinces as $province)
                                {
                                    $selected=($currentProcess['province'] == $province)?"selected":"";
                                    echo("<option value=".$province." ".$selected.">".ucfirst($province)."</option>");
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="title" class="form-label">Cantón:</label>
                        <input type="text" disabled class="form-control" id="canton" name="canton" required 
                        value=" <?php echo($currentProcess['canton']); ?>" 
                        onchange="cantonControl()">
                    </div>
                </div>
                <div class="my-3  justify-content-center visually-hidden" id="buttonContainer">
                <button class="btn btn-md btn-success my-1 mx-1">Guardar Cambios</button>
                <button class="btn btn-md btn-danger my-1 mx-1">Cancelar</button>
                </div>
                </div>
            </div>
        </form>
      </div>
    </main>
    <script src="../javascript/editProcess.js"></script>
  </body>
</html>
