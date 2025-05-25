<?php
session_start();
require_once __DIR__ . '/../php/db_connection.php';  // Ajusta según tu estructura

// Verifica sesión
if (!isset($_SESSION["account_id"])) {
    die("Sesión no iniciada.");
}

$user_id = intval($_SESSION["account_id"]);

// Consulta de datos con prepared statement
$sql ="SELECT * FROM account as ac join user_profile as up on ac.account_id=up.account_id where ac.account_id=?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();
    $_SESSION["images"]=$userData['profile_picture'];
} else {
    die("Error en la consulta: " . $conn->error);
}

//Extrae las cualificaciones de estudios, trabajo y activismo
$studiesQuery="SELECT qualification_id, role, institution, startYear FROM qualification WHERE profile_id = ? AND qualification_type = 'studies'";
$getStudies = $conn->prepare($studiesQuery);
$getStudies->bind_param("i", $user_id);
$getStudies->execute();
$studies=$getStudies->get_result();
$studiesList="";
//Crea las respectivas tarjetas
while ($study = $studies->fetch_assoc()) {
    $studyId=htmlspecialchars($study['qualification_id']);
    $role = htmlspecialchars($study['role']);
    $institution = htmlspecialchars($study['institution']);
    $year = htmlspecialchars($study['startYear']);

    $displayText = "($year) $role - $institution";
    $studiesList.= "
    <div class='study align-items-center mb-2'>
        <div class='col-md-10'>
            <p>$displayText</p>
        </div>
        <div class='col-md-1 pr-1'>
            <button class='btn btn-sm btn-info edit-btn'
                data-id='$id'
                data-role='$role'
                data-institution='$institution'
                data-year='$year'>
                <i class='bi bi-pencil-square'></i>
            </button>
        </div>
        <div class='col-md-1 pl-1'>
            <button class='btn btn-sm btn-danger delete-btn' data-id='$id'>
                <i class='bi bi-x-circle'></i>
            </button>
        </div>
    </div>
    ";
}


// Imagen de perfil
$profilePicture = (!empty($_SESSION["images"])) 
    ? $_SESSION["images"] 
    : "../images/blank-profile-picture.png";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/pDashboard.css">
    <title>Mi Perfil</title>
</head>
<body class="bg-dark">
    <div class="container my-4">
        <div class="card bg-dark-card text-white shadow">
            <div class="card-header text-center">
    <h1>Mi Perfil</h1>
    <div class="mt-3">
        <a href="Perfil.php" class="btn btn-secondary">
            <i class="bi bi-pencil-fill"></i> Editar Perfil
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
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" id="name" name="name" required
                                        class="form-control"
                                        value="<?= htmlspecialchars($userData['name']) ?>">
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="lastname" class="form-label">Apellido</label>
                                    <input type="text" id="lastname" name="lastname" required
                                        class="form-control"
                                        value="<?= htmlspecialchars($userData['lastname']) ?>">
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <label for="title" class="form-label">Título</label>
                                    <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($userData['title']) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                                <label for="personalBio" class="form-label">Biografía</label>
                                <textarea id="personalBio" name="personalBio" class="form-control"><?=htmlspecialchars($userData['bio'])?></textarea>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <h1>Información de Contacto</h1>
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
                                   value="<?=htmlspecialchars($userData['email']) ?>">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Dirección</label>
                            <input type="text" id="address" name="address" required
                                   class="form-control"
                                   value="<?=htmlspecialchars($userData['address']) ?>">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success me-2">Guardar Cambios</button>
                        <button type="reset" class="btn btn-danger">Cancelar</button>
                    </div>
                </form>
                <div class="row align-items-top overflow-auto form-group mx-auto" id="studiesInfo">
                    <h4>Certificados y Licencias</h4>
                    <div class="row overflow-scroll" id="studiesList">
                        <?= $studiesList?>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#newStudyModal">
                            Agregar Certificado
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="row align-items-top overflow-auto form-group mx-auto" id="studiesInfo">
                    <h4>Certificados y Licencias</h4>
                    <div class="row overflow-scroll" id="studiesList">
                        <div class="row align-items-center">
                            <div class="col-md-10 overflow-x-visible">
                                 <p>(2024)MAESTRIA EN DERECHO, CON MENCION EN DERECHO CONSTITUCIONAL EN LA UNIVERSIDAD INDOAMERICA</p>
                            </div>
                            <div class="col-md-1 pr-1">
                                <button class="btn btn-sm btn-info">
                                <i class="bi-pencil-square"></i>
                                </button>
                            </div>
                            <div class="col-md-1 pl-1">
                                <button class="btn btn-sm btn-danger">
                                <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                        </div>
                         <div class="row align-items-center">
                            <div class="col-md-10 overflow-x-visible">
                                 <p>(2024)MAESTRIA EN DERECHO, CON MENCION EN DERECHO CONSTITUCIONAL EN LA UNIVERSIDAD INDOAMERICA</p>
                            </div>
                            <div class="col-md-1 pr-1">
                                <button class="btn btn-sm btn-info">
                                <i class="bi-pencil-square"></i>
                                </button>
                            </div>
                            <div class="col-md-1 pl-1">
                                <button class="btn btn-sm btn-danger">
                                <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Agregar Certificado
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="row align-items-top overflow-auto form-group mx-auto" id="studiesInfo">
                    <h4>Certificados y Licencias</h4>
                    <div class="row overflow-scroll" id="studiesList">
                        <div class="row align-items-center">
                            <div class="col-md-10 overflow-x-visible">
                                 <p>(2024)MAESTRIA EN DERECHO, CON MENCION EN DERECHO CONSTITUCIONAL EN LA UNIVERSIDAD INDOAMERICA</p>
                            </div>
                            <div class="col-md-1 pr-1">
                                <button class="btn btn-sm btn-info">
                                <i class="bi-pencil-square"></i>
                                </button>
                            </div>
                            <div class="col-md-1 pl-1">
                                <button class="btn btn-sm btn-danger">
                                <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                        </div>
                         <div class="row align-items-center">
                            <div class="col-md-10 overflow-x-visible">
                                 <p>(2024)MAESTRIA EN DERECHO, CON MENCION EN DERECHO CONSTITUCIONAL EN LA UNIVERSIDAD INDOAMERICA</p>
                            </div>
                            <div class="col-md-1 pr-1">
                                <button class="btn btn-sm btn-info">
                                <i class="bi-pencil-square"></i>
                                </button>
                            </div>
                            <div class="col-md-1 pl-1">
                                <button class="btn btn-sm btn-danger">
                                <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Agregar Certificado
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="modal fade" id="newStudyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content bg-dark">
            <div class="modal-header ">
                <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Agregar Ítem</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="newStudyForm" name="newStudyForm">
                <div class="modal-body px-5">
                    <div class="row mb-1">
                        <label class="form-label">Titulo:</label>
                        <input type="text" class="form-control" id="titleIn" name="titleIn">
                    </div>
                    <div class="row mb-1">
                        <label class="form-label">Institución:</label>
                        <input type="text" class="form-control" id="instituteIn" name="instituteIn">
                    </div>
                    <div class="row mb-1">
                        <label class="form-label">Año:</label>
                        <div class="col-auto">
                            <input type="number" class="form-control" id="yearIn" name="yearIn" step="1" placeholder="ej: 2024">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <input type="reset" class="btn btn-danger mx-1" data-bs-dismiss="modal" value="Cancelar">
                    <input type="submit" class="btn btn-primary mx-1" value="Agregar">
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="studyChangeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Editar Ítem</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changeStudyForm" name="changeStudyForm" method="post">
                <div class="modal-body px-5">
                    <div class="row mb-1">
                        <label class="form-label">Titulo:</label>
                        <textarea class="form-control" id="titleCh" name="titleCh">

                        </textarea>
                    </div>
                    <div class="row mb-1">
                        <label class="form-label">Institución:</label>
                        <input type="text" class="form-control" id="studyInsitutionCh" name="studyInsitutionCh">
                    </div>
                    <div class="row mb-1">
                        <label class="form-label">Año:</label>
                        <div class="col-auto">
                            <input type="number" class="form-control" id="studyYearCh" name="studyYearCh" step="1" placeholder="ej: 2024">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <input type="reset" class="btn btn-danger mx-1" data-bs-dismiss="modal" value="Cancelar">
                    <input type="reset" class="btn btn-primary mx-1" value="Guardar Cambios">
                </div>
            </form>
            </div>
        </div>
    </div>
<script src="../javascript/qualificationsControl.js"> </script>
<script src="../javascript/profileControl.js"></script>
</body>
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success text-center" role="alert">
        Perfil actualizado correctamente.
    </div>
<?php endif; ?>
</html>
