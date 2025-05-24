<?php
require_once "db_connection.php";

$sql = "SELECT * FROM event ORDER BY dateStart ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Eventos Registrados</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/eventostyle.css">
</head>
<body>
  <div class="header">
    <h2>Eventos Registrados</h2>
    <a href="../html/agregar_evento.html" class="btn btn-back">➕ Agregar Evento</a>
  </div>

  <?php if ($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
      <div class="card p-3">
        <h5><?= htmlspecialchars($row["name"]) ?></h5>
        <p><strong>Inicio:</strong> <?= $row["dateStart"] ?></p>
        <p><strong>Fin:</strong> <?= $row["dateEnd"] ?></p>
        <p><?= nl2br(htmlspecialchars($row["description"])) ?></p>
        <div class="d-flex justify-content-end">
          <a href="editar_evento.php?id=<?= $row["event_id"] ?>" class="btn btn-warning btn-sm me-2">✏️ Editar</a>
          <a href="eliminar_evento.php?id=<?= $row["event_id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este evento?');">🗑️ Eliminar</a>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No hay eventos registrados.</p>
  <?php endif; ?>
<?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
  <div class="alert alert-success text-center" role="alert">
    ✅ Evento editado exitosamente.
  </div>
<?php endif; ?>

<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
  <div class="alert alert-danger text-center" role="alert">
    🗑️ Evento eliminado correctamente.
  </div>
<?php endif; ?>

  <?php $conn->close(); ?>
<?php if (isset($_GET['added']) && $_GET['added'] == 1): ?>
  <div class="alert alert-success text-center" role="alert">
    ✅ Evento agregado exitosamente.
  </div>
<?php endif; ?>

</body>
<script>
  // Espera 1 segundo y luego oculta las alertas
  setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
      alert.style.transition = 'opacity 0.5s ease';
      alert.style.opacity = '0';
      setTimeout(() => alert.remove(), 500); // Espera 0.5s más y lo elimina del DOM
    });
  }, 1000); // 1 segundo de espera
</script>

</html>
