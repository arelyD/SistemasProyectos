<?php
session_start();
	require 'conexion.php';
	
	if(!isset($_SESSION["id_usuario"])){
		header("Location: index.php");
	}
	$sql = "SELECT id, tipocarrera FROM carreras";
	$result=$mysqli->query($sql);

	$bandera=false;

	if(!empty($_POST)){
		$titulo = mysqli_real_escape_string($mysqli,$_POST['titulo']);
		$resumen = mysqli_real_escape_string($mysqli, $_POST['resumen']);
		$autores = mysqli_real_escape_string($mysqli,$_POST['resumen']);
		$institucion = mysqli_real_escape_string($mysqli,$_POST['institucion']);
	    $tipocarrera= $_POST['tipo_carrera'];
	    $semestre = mysqli_real_escape_string($mysqli,$_POST['semestre']);
	    $email= mysqli_real_escape_string($mysqli,$_POST['mail']);

	    $error='';

	    $sqlRegistro="SELECT id FROM registros Where titulo = '$titulo'";
	    $resultRegistro=$mysqli->query($sqlRegistro);
	    $rows=$resultRegistro->num_rows;

	    if($rows > 0){
	    	$error="El proyecto ya ha sido registrado";
	    }
	    else{

	    	$sqlUsuario = "INSERT INTO registros (titulo, resumen, autores, institucion,tipocarrera,semestre,email) VALUES('$titulo', '$resumen', '$autores', '$institucion','$tipocarrera',' $semestre','$email')";
			$resultUsuario = $mysqli->query($sqlUsuario);
			
			if($resultUsuario>0)
			$bandera = true;
			else
			$error = "Error al Registrar";

	    }
	}

?>
<html>
	<head>
		<title>Login</title>
    <script>

           function validarTitulo()
			{
				valor = document.getElementById("titulo").value;
				if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
					alert('Falta Llenar titulo');
					return false;
				} else { return true;}
			}

			function validarResumen()
			{
				valor = document.getElementById("resumen").value;
				if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
					alert('Falta Llenar resumen');
					return false;
				} else { return true;}
			}

			function validarAutores()
			{
				valor = document.getElementById("autores").value;
				if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
					alert('Falta Llenar autores');
					return false;
				} else { return true;}
			}
	
			
			function validarInstitucion()
			{
				valor = document.getElementById("institucion").value;
				if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
					alert('Falta Llenar Institucion');
					return false;
				} else { return true;}
			}

			function validarTipoCarrera()
			{
				indice = document.getElementById("tipo_carrera").selectedIndex;
				if( indice == null || indice==0 ) {
					alert('Seleccione tipo carrera');
					return false;
				} else { return true;}
			}
			function validarSemestre()
			{
				valor = document.getElementById("semestre").value;
				if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
					alert('Falta Llenar Semestre');
					return false;
				} else { return true;}
			}
			function validarEmail()
			{
				valor = document.getElementById("mail").value;
				if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
					alert('Falta Llenar e-mail');
					return false;
				} else { return true;}
			}
			function validar()
			{
				if(validarTitulo() && validarResumen() && validarAutores() && validarInstitucion() && validarTipoCarrera() && validarSemestre() && validarEmail())
				{
					document.registroP.submit();
				}
			}
    </script>

	</head>
	
	<body>
		<form id="registroP" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" > 
			<div><label>Titulo:</label><input id="titulo" name="titulo" type="textarea" ></div>
			<br />
			<div><label>Resumen:</label><input id="resumen" name="resumen" type="textarea"></div>
			<br />
			<div><label>Autores:</label><input id="autores" name="autores" type="textarea" ></div>
			<br />
			<div><label>Institucion:</label><input id="institucion" name="institucion" type="textarea"></div>
			<br />
           <div><label>Carrera</label>
				<select id="tipo_carrera" name="tipo_carrera">
					<option value="0">Seleccione la carrera</option>
					<?php while($row = $result->fetch_assoc()){ ?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['tipocarrera']; ?></option>
					<?php }?>
				</select>
			</div>
			<br />
			<div><label>Semestre:</label><input id="semestre" name="semestre" type="text"></div>
			<br />
			<div><label>e-mail:</label><input id="mail" name="mail" type="text" ></div>
			<br />
			<div><input name="registar" type="button" value="Registrar" onClick="validar();"></div> 
		</form>

			<?php if($bandera) { ?>
			<h1>Registro exitoso</h1>
			<a href="welcome.php">Regresar</a>
			
			<?php }else{ ?>
			<br />
			<div style = "font-size:16px; color:#cc0000;"><?php echo isset($error) ? utf8_decode($error) : '' ; ?></div>
			
		<?php } ?>
	</body>
</html>