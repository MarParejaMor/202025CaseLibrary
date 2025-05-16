<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<link rel="stylesheet" type="text/css" href="../css/estilo1.css">
</head>

<body>
	<script src="../js/prog1.js"></script>
    <h2>Subir una imagen</h2>
    
    <!-- Formulario para cargar la imagen -->
    <form id="imageForm" method="post" action="imgserv.php">
        <p>
          <input type="file" id="imageInput" accept="image/*"/>
        </p>
        <p>
          <input type="submit" name="submit" id="submit" value="Enviar">
        </p>
    </form>
	<div style="margin: auto;width: 60%;">
	<img src="" alt="imagen_subida" id="myimg" style="border: solid 1px black">
	<button onClick="recuperar()">Imagen</button>
	</div>

    <!-- Área para visualizar la imagen subida -->
</body>
</html>
