<?php
require_once "db_connection.php";

if (isset($_GET['id'])) {
  $event_id = intval($_GET['id']);

  $stmt = $conn->prepare("DELETE FROM event WHERE event_id = ?");
  $stmt->bind_param("i", $event_id);

  if ($stmt->execute()) {
    // Redirige con mensaje
    header("Location: ver_eventos.php?deleted=1");
    exit();
  } else {
    echo "❌ Error al eliminar el evento: " . $stmt->error;
  }

  $stmt->close();
} else {
  echo "❌ ID de evento no especificado.";
}

$conn->close();
?>
