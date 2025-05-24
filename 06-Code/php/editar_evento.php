<?php
require_once "db_connection.php";

if (!isset($_GET['id'])) {
  die("ID de evento no especificado.");
}

$event_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM event WHERE event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
  die("Evento no encontrado.");
}

$evento = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Evento</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/editar_evento.css">
</head>
<body>
  <div class="container">
    <h2>Editar Evento</h2>
    <form method="POST" action="guardar_edicion.php">
      <input type="hidden" name="event_id" value="<?= $evento['event_id'] ?>">

      <div class="mb-3">
        <label for="name" class="form-label">Nombre del Evento</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($evento['name']) ?>" required>
      </div>

      <div class="mb-3">
        <label for="dateStart" class="form-label">Fecha de Inicio</label>
        <input type="date" class="form-control" id="dateStart" name="dateStart" value="<?= $evento['dateStart'] ?>" required>
      </div>

      <div class="mb-3">
        <label for="dateEnd" class="form-label">Fecha de Fin</label>
        <input type="date" class="form-control" id="dateEnd" name="dateEnd" value="<?= $evento['dateEnd'] ?>" required>
      </div>

      <div class="mb-3">
        <label for="description" class="form-label">Descripción</label>
        <textarea class="form-control" id="description" name="description" rows="4"><?= htmlspecialchars($evento['description']) ?></textarea>
      </div>

      <button type="submit" class="btn btn-success">Guardar Cambios</button>
      <a href="ver_eventos.php" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</body>
</html>
