<?php
session_start();
require_once __DIR__ . '/../php/db_connection.php';  // Ajusta según tu estructura

// Verifica sesión
if (!isset($_SESSION["account_id"])) {
    die("Sesión no iniciada.");
}

$user_id = intval($_SESSION["account_id"]);

// Consulta de datos con prepared statement
$sql = "SELECT `name`, `lastname`, `username`, `email`, `phone_number`, `address`, `personal_bio`
        FROM account 
        WHERE account_id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();
    $stmt->close();
} else {
    die("Error en la consulta: " . $conn->error);
}

// Imagen de perfil
$profilePicture = (!empty($_SESSION["images"])) 
    ? "../" . $_SESSION["images"] 
    : "../images/blank-profile-picture.png";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <title>Mi Perfil</title>

    <!-- Estilos fondo negro -->
    <style>
        body {
            background-color: #000;
            color: #fff;
        }
        .bg-white { background-color: #1a1a1a !important; }
        .form-control, .form-control:disabled {
            background-color: #333 !important;
            color: #fff !important;
            border: 1px solid #555;
        }
        .form-label { color: #ccc; }
        .modal-content { background-color: #1e1e1e; color: #fff; }
        .btn-close { filter: invert(1); }
    </style>
</head>
<body>
    <div class="container my-4">
        <div class="card bg-white text-white shadow">
            <div class="card-header text-center">
    <h1>Mi Perfil</h1>
    <div class="mt-3">
    <a href="Pagina_Principal.php" class="btn btn-primary me-2">
            <i class="bi bi-house"></i> Página Principal
        </a>
        <a href="Perfil.php" class="btn btn-secondary">
            <i class="bi bi-person-circle"></i> Mi Perfil
        </a>
    </div>
</div>

            <div class="card-body">
                <form method="post" action="../php/updateProfile.php" enctype="multipart/form-data">
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <img src="<?= htmlspecialchars($profilePicture) ?>"
                                 class="img-thumbnail mb-2" alt="Perfil" style="max-width: 200px;">
                            <input type="file" name="profileImg" accept="image/*" class="form-control">
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" id="name" name="name" required
                                       class="form-control"
                                       value="<?= htmlspecialchars($userData['name']) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="lastname" class="form-label">Apellido</label>
                                <input type="text" id="lastname" name="lastname" required
                                       class="form-control"
                                       value="<?= htmlspecialchars($userData['lastname']) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="personalBio" class="form-label">Biografía</label>
                                <textarea id="personalBio" name="personalBio"
                                          class="form-control"><?= htmlspecialchars($userData['personal_bio']) ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Teléfono</label>
                            <input type="tel" id="phone" name="phone" required
                                   class="form-control"
                                   value="<?= htmlspecialchars($userData['phone_number']) ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="mail" class="form-label">Correo</label>
                            <input type="email" id="mail" name="mail" required
                                   class="form-control"
                                   value="<?= htmlspecialchars($userData['email']) ?>">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Dirección</label>
                            <input type="text" id="address" name="address" required
                                   class="form-control"
                                   value="<?= htmlspecialchars($userData['address']) ?>">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success me-2">Guardar Cambios</button>
                        <button type="reset" class="btn btn-danger">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS + dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success text-center" role="alert">
        Perfil actualizado correctamente.
    </div>
<?php endif; ?>
</html>
