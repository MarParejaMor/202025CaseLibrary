
<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>LegalSystem</title>
    <link rel="stylesheet" href="../css/pDashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
    <script src="../javascript/menuControl.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	
</head>

<body>
    <header id="estatico" class="fixed-top mb-lg-5">
            <div id="menu" class="container-fluid py-2 bg-dark text-light">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col-sm-3">
                        <h1 class="navbar-brand">
                        <i class="bi bi-person"></i>
                        Abg. Luz Romero
                        </h1>
                    </div>

                    <div class="col-auto align-items-center text-light">
                        <nav class="navbar navbar-dark navbar-expand-lg my-0">
                            <button class="border-light navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">
                                <span class=" text-light"></span>
                            </button>
                            <div class="collapse navbar-collapse justify-content-center" id="mainMenu">
                                <ul class="navbar-nav">
                                    <li class="nav-item px-3 newhov">
                                        <a class="nav-link link-light" href="dashboard.php"><i class="bi bi-house-door"></i> Inicio</a>
                                    </li>
                                    <li class="nav-item px-3 newhov">
                                        <a class="nav-link link-light" href="../php/ver_eventos.php"><i class="bi bi-calendar"></i> Eventos</a>
                                    </li>
                                    <li class="nav-item px-3 newhov">
                                        <a class="nav-link link-light" href="Perfil_privado.php"> <i class="bi bi-person-square"></i> Perfil</a>
                                    </li>
                                    <li class="nav-item px-3 newhov">
                                        <a class="nav-link link-light" href="#"> <i class="bi bi-wrench"></i> Cuenta</a>
                                    </li>
                                    <li class="nav-item px-3 newhov">
                                        <a class="nav-link link-light" href="#"> <i class="bi bi-door-open-fill"></i> Salir</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>


        <nav class="navbar navbar-dark navbar-expand-lg my-0 d-none" style="height: 3rem" id="processMenu">
            <div class="container my-0" style="height: 2rem">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="menuNav">
                    <ul class="navbar-nav">
                        <li class="nav-item px-3 newhov">
                            <a class="nav-link" href="inicio.php"><i class="bi bi-house-door"></i> Inicio</a>
                        </li>
                        <li class="nav-item px-3 newhov">
                            <a class="nav-link" href="dashboard.php"> <i class="bi bi-graph-up"></i> Dashboard</a>
                        </li>

                        <li class="nav-item px-3 newhov" id="ingperf">
                            <a class="nav-link" href="ingresos.php"><i class="bi bi-currency-dollar"></i> Ingresos</a>
                        </li>
                        
                        <li class="nav-item px-3 newhov" id="gastperf">
                            <a class="nav-link" href="Gastos.php"><i class="bi bi-bag"></i> Gastos</a>
                        </li>
                        <li class="nav-item dropdown px-3"  id="desplegableus">
                            <a class="nav-link dropdown-toggle" id="dropdownuser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-people"></i> Gestión de Usuarios
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownuser">
                                <li class="hov newhov"  id="userperf"><a class="dropdown-item" href="Usuarios.php"><i class="bi bi-people"></i> Usuarios</a></li>
                                <li class="hov newhov" id="perfperf"><a class="dropdown-item" href="perfiles.php" ><i class="bi bi-person-badge"></i> Perfiles</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown px-3" id="desplegablesis">
                            <a class="nav-link dropdown-toggle" id="dropdownsis" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-people"></i> Gestión del Sistema
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownsis">
                                <li  id="cncpperf" class="hov newhov">
                                    <a class="nav-link" href="agregarConcepto.php"><i class="bi bi-bank"></i> Concepto<br> (Ingresos-Gastos)
                                </a>
                                </li>
                                <li id="qrperf" class="hov newhov">
                                    <a class="nav-link" href="qr.php"><i class="bi bi-upc-scan"></i> Código QR
                                </a>
                                </li>
                                <li  id="auditoria" class="hov newhov">
                                    <a class="nav-link" href="auditoria.php">
                                        <i class="bi bi-journal-medical"></i> Auditoría
                                    </a>
                                </li>
                        </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div id="contenidomenu" class="mt-lg-5 pt-lg-5">

    </div>

    <footer class="bg-dark py-2 text-center">
        <p class="mb-0">&copy; <?= date('Y'); ?> SSDR Group</p>
    </footer>

</body>

</html>