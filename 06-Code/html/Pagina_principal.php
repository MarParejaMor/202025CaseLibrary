<?php
    session_start();
    include("../php/db_connection.php");
    $userId=$_SESSION["account_id"];
    $profileQuery="SELECT * FROM process WHERE `account_id`='$userId'";
    $result = mysqli_query($conn,$profileQuery);
    $processes="";
    while($process = mysqli_fetch_assoc($result))
    {
        $processes.="<article class='card'>";
        $processes.="<div class='thumb'>";
        $processes.="<h1>Proceso".htmlspecialchars($process['type'])."</h1>";
        $processes.="</div>";
        $processes.="<div class='card-body'>";
        $processes.="<h3>".htmlspecialchars($process['title'])."</h3>";
        $processes.="<p>".htmlspecialchars($process['process_description'])."</p>";
        $processes.="</div>";
        $processes.="<div class='card-actions'>";
        $processes.="<button class='btn-like'>Me gusta</button>";
        $processes.="<button class='btn-comment'>Comentar</button>";
        $processes.="</div>";
        $processes.="</article>";
    }
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Publicaciones · Luz Romero</title>
    <link rel="stylesheet" href="../css/PaginaPrincipal.css" />
  </head>
  <body>
    <header class="site-header">
      <div class="logo">🖼️ Abg. Luz Romero</div>
      <nav class="main-nav">
        <a href="#">Inicio</a>
        <a href="../html/Perfil_privado.php">Perfil</a>
        <a href="#">Ajustes</a>
      </nav>
    </header>

    <main class="content">
      <div class="cards-grid">
        <h1>Publicaciones</h1>
        <div>
          <button class="button-add" onclick="window.location.href='agregarCaso.html'">Agregar</button>
        </div>
        <?php
          echo($processes);
        ?>
      </div>
    </main>

    <footer class="site-footer">
      <ul class="footer-links">
        <li><a href="#">Política de Privacidad</a></li>
        <li><a href="#">Términos de Servicio</a></li>
        <li><a href="#">Contáctanos</a></li>
      </ul>
      <div class="social-icons">
        <a href="#" aria-label="Facebook">🔵</a>
        <a href="#" aria-label="Twitter">🐦</a>
        <a href="#" aria-label="Instagram">📸</a>
      </div>
    </footer>
  </body>
</html>
