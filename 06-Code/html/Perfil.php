<?php
session_start();
include("../php/db_connection.php");

if (!isset($_SESSION["account_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION["account_id"]);

// 1) Perfil básico + nombre completo
$sqlProfile = "
  SELECT up.*, a.name, a.lastname
    FROM user_profile AS up
    JOIN account AS a USING(account_id)
   WHERE up.account_id = $user_id
  LIMIT 1
";
$resProfile = mysqli_query($conn, $sqlProfile);
if (!$resProfile || mysqli_num_rows($resProfile) === 0) {
    die("Perfil no encontrado.");
}
$perfil = mysqli_fetch_assoc($resProfile);

// Foto de perfil
if (!empty($perfil['profile_picture'])) {
    // Asumimos que subes las imágenes a /uploads/
    $foto = "../uploads/" . htmlspecialchars($perfil['profile_picture']);
} else {
    $foto = "../images/blank-profile-picture.png";
}

// 2) Calificaciones / trayectorias
$sqlQual = "
  SELECT * 
    FROM qualification 
   WHERE profile_id = {$perfil['profile_id']}
   ORDER BY startYear DESC
";
$resQual = mysqli_query($conn, $sqlQual);

// Agrupamos ítems por tipo
$sections = [
  'estudio'     => 'Estudios y Formación',
  'profesional' => 'Trayectoria Profesional',
  'activista'   => 'Trayectoria como Activista',
];
$data = [];
while ($row = mysqli_fetch_assoc($resQual)) {
    $type = strtolower($row['qualification_type']);
    $data[$type][] = $row;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mi Perfil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-..."
    crossorigin="anonymous"
  >
  <style>
    body {
      background-color: #000;
      color: #fff;
    }
    .section-heading {
      border-bottom: 1px solid #444;
      padding-bottom: .3rem;
      margin-top: 2rem;
      margin-bottom: 1rem;
    }
    .qualification-item {
      background: #111;
      padding: .8rem;
      border-radius: .3rem;
      margin-bottom: .8rem;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <!-- Header: foto, nombre y título -->
    <div class="row align-items-center mb-5">
      <div class="col-md-3 text-center">
        <img src="<?= $foto ?>" 
             class="img-fluid rounded-circle border border-light" 
             alt="Foto de perfil">
      </div>
      <div class="col-md-9">
        <h1><?= htmlspecialchars($perfil['name'] . ' ' . $perfil['lastname']) ?></h1>
        <?php if (!empty($perfil['title'])): ?>
          <h4 class="text-muted"><?= htmlspecialchars($perfil['title']) ?></h4>
        <?php endif ?>
      </div>
    </div>

    <!-- Biografía -->
    <?php if (!empty($perfil['bio'])): ?>
      <div class="mb-5">
        <h3 class="section-heading">Acerca de mí</h3>
        <p><?= nl2br(htmlspecialchars($perfil['bio'])) ?></p>
      </div>
    <?php endif ?>

    <!-- Secciones dinámicas -->
    <?php foreach ($sections as $key => $label): ?>
      <?php if (!empty($data[$key])): ?>
        <div>
          <h3 class="section-heading"><?= $label ?></h3>
          <?php foreach ($data[$key] as $item): ?>
            <div class="qualification-item">
              <strong>
                <?= 
                  ($item['startYear'] ?? '') 
                  . 
                  (isset($item['endYear']) && $item['endYear'] 
                    ? "–{$item['endYear']}" 
                    : ''
                  ) 
                ?>
              </strong>
              <p class="mb-1"><?= htmlspecialchars($item['role']) ?></p>
              <small class="text-muted">
                <?= htmlspecialchars($item['institution']) ?>
                <?= !empty($item['place']) ? " · " . htmlspecialchars($item['place']) : '' ?>
              </small>
            </div>
          <?php endforeach ?>
        </div>
      <?php endif ?>
    <?php endforeach ?>

    <!-- Botones de editar/guardar -->
    <div class="mt-5 text-center">
      <a href="Perfil_privado.php" class="btn btn-light me-2">
        <i class="bi bi-pencil-square"></i> Editar Perfil
      </a>
      <a href="Pagina_principal.php" class="btn btn-secondary">
        Volver al Inicio
      </a>
    </div>
  </div>

  <!-- Bootstrap JS (optativo) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
