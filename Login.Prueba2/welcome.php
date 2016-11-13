<?php
session_start();
	require 'conexion.php';
	
	if(!isset($_SESSION["id_usuario"])){
		header("Location: index.php");
	}

$idUsuario = $_SESSION['id_usuario'];
	
	$sql = "SELECT u.id, p.usuario FROM usuarios AS u INNER JOIN usuarios AS p ON u.id=p.id WHERE u.id = '$idUsuario'";
	$result=$mysqli->query($sql);
	
	$row = $result->fetch_assoc();


?>

<html>
	<head>
		<title>Registro</title>
	</head>
	
	<body>
	
	<h1><?php echo 'Bienvenid@ '.utf8_decode($row['usuario']); ?></h1>
	
	<?php if($_SESSION['tipo_usuario']==1) { ?>
	
	<a href="registro.php">Registarse</a>
	<br />
	<?php } ?>
	
	<a href="logout.php">Cerrar Sesi&oacute;n</a>


	<?php if($_SESSION['tipo_usuario']==2) { ?>
	
	<a href="jurado.php">Ver Proyecto</a>
	<br />
	<?php } ?>
	

	
	
	</body>
		
</html>