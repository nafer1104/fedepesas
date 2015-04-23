<?php 
	$nombreUsuario = 'root';
	$contrasena = '';
	$host = 'localhost';
	$baseDatos = 'dbfedepesas';

	$conexion = new mysqli($host,$nombreUsuario,$contrasena,$baseDatos);

	/* comprueba la conexión */
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
	
	/*$conexion = mysql_connect($host,$nombreUsuario,$contrasena)
    or die('No se pudo conectar: ' . mysql_error());
echo 'Connected successfully';
mysql_select_db($baseDatos) or die('No se pudo seleccionar la base de datos');*/

?>