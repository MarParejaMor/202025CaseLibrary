<?php
require_once "db_connection.php";

$name = $_POST['name'];
$description = $_POST['description'];
$dateStart = $_POST['dateStart'];
$dateEnd = isset($_POST['dateEnd']) && $_POST['dateEnd'] !== "" ? $_POST['dateEnd'] : $dateStart;

$sql = "INSERT INTO event (name, description, dateStart, dateEnd) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $description, $dateStart, $dateEnd);

$success = false;
if ($stmt->execute()) {
  $success = true;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Evento Agregado</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #121212;
      color: #ffffff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: sans-serif;
      text-align: center;
    }

    .message {
      background-color: #1e1e1e;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
    }
  </style>
</head>
<body>
  <div class="message">
    <?php if ($success): ?>
      <h2>✅ Evento agregado exitosamente</h2>
      <p>Serás redirigido en un momento...</p>
      <script>
        setTimeout(() => {
          window.location.href = "../html/ver_eventos.php?added=1";
        }, 1000);
      </script>
    <?php else: ?>
      <h2>❌ Error al agregar el evento</h2>
      <p><a href="agregar_evento.html" class="btn btn-warning mt-3">Volver al formulario</a></p>
    <?php endif; ?>
  </div>
</body>
</html>
