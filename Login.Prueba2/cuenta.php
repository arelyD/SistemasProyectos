<?php	
	session_start();
	require 'conexion.php';
	
	if(!isset($_SESSION["id_usuario"])){

		
	}
	$sql = "SELECT id, tipo FROM tipo_usuario";
	$result=$mysqli->query($sql);

	$bandera=false;

	if(!empty($_POST)){
		$usuario = mysqli_real_escape_string($mysqli,$_POST['usuario']);
		$password = mysqli_real_escape_string($mysqli,$_POST['password']);
	    $id_tipo= $_POST['tipo_usuario'];
	    $sha1_pass = sha1($password);
	   

	    $error='';

	    $sqlRegistro="SELECT id FROM usuarios Where usuario = '$usuario'";
	    $resultRegistro=$mysqli->query($sqlRegistro);
	    $rows=$resultRegistro->num_rows;

	    if($rows > 0){
	    	$error="El usuario ya ha sido registrado";
	    }
	    else{

	    	$sqlUsuario = "INSERT INTO usuarios (usuario, password,id_tipo)VALUES('$usuario','$sha1_pass','$id_tipo')";
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

           function validarUsuario()
			{
				valor = document.getElementById("usuario").value;
				if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
					alert('Falta Llenar titulo');
					return false;
				} else { return true;}
			}

			function validarPassword()
			{
				valor = document.getElementById("password").value;
				if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
					alert('Falta Llenar resumen');
					return false;
				} else { return true;}
			}

			function validarTipoUsuario()
			{
				indice = document.getElementById("tipo_usuario").selectedIndex;
				if( indice == null || indice==0 || indice==2 ) {
					alert('Seleccione tipo de usuario participante');
					return false;
				} else { return true;}
			}
			
			function validar()
			{
				if(validarUsuario() && validarPassword&& validarTipoUsuario())
				{
					document.registro.submit();
				}
			}
    </script>

	</head>
	
	<body>
		<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" > 
			<div><label>Titulo:</label><input id="usuario" name="usuario" type="textarea" ></div>
			<br />
			<div><label>Resumen:</label><input id="password" name="password" type="password"></div>
			<br />
           <div><label>Carrera</label>
				<select id="tipo_usuario" name="tipo_usuario">
					<option value="0">Seleccione el tipo</option>
					<?php while($row = $result->fetch_assoc()){ ?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['tipo']; ?></option>
					<?php }?>
				</select>
			</div>
			<br />
			<div><input name="registar" type="button" value="Registrar" onClick="validar();"></div> 
		</form>

			<?php if($bandera) { ?>
			<h1>Registro exitoso</h1>
			
			<?php }else{ ?>
			<br />
			<div style = "font-size:16px; color:#cc0000;"><?php echo isset($error) ? utf8_decode($error) : '' ; ?></div>
			
		<?php } ?>
	</body>
</html>