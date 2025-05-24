<?php
require_once "db_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $event_id = intval($_POST['event_id']);
  $name = $_POST['name'];
  $description = $_POST['description'];
  $dateStart = $_POST['dateStart'];
  $dateEnd = $_POST['dateEnd'];

  $stmt = $conn->prepare("UPDATE event SET name = ?, description = ?, dateStart = ?, dateEnd = ? WHERE event_id = ?");
  $stmt->bind_param("ssssi", $name, $description, $dateStart, $dateEnd, $event_id);

  if ($stmt->execute()) {
    header("Location: ver_eventos.php?updated=1");
    exit();
  } else {
    echo "❌ Error al actualizar el evento: " . $stmt->error;
  }

  $stmt->close();
}

$conn->close();
?>
