<?php
//include db configuration file
include_once("../../../conexion/conexion.php");

//obtenemos el tipo de peticion que se esta haciendo (GET,POST,PUT,DELETE)
$tipoPeticion = $_SERVER['REQUEST_METHOD'];
$responce = array();
  
if($tipoPeticion == "GET"){
	$operacion = $_GET['operacion']; // get the requested page

	if($operacion == "ramas"){
        $SQL = "SELECT c.codigo,c.nombre FROM rama c";
        $result = $conexion->query( $SQL ) or die("Couldn t execute query.".mysql_error());

        $responce["total"] = 0;
        $i=0;
        while($row = $result->fetch_assoc()){
            $responce["data"][$i]=array("codigo"=>$row["codigo"],"nombre"=>$row["nombre"]);
            $i++;
        }        
        $responce["total"] = $i;
        echo json_encode($responce);

	}

	if($operacion == "tipoJuez"){
        $SQL = "SELECT tj.codigo, CONCAT(tj.abreviatura , ' - ', tj.nombre) AS nombre FROM tipojuez tj";
        $result = $conexion->query( $SQL ) or die("Couldn t execute query.".mysql_error());

        $responce["total"] = 0;
        $i=0;
        while($row = $result->fetch_assoc()){
            $responce["data"][$i]=array("codigo"=>$row["codigo"],"nombre"=>$row["nombre"]);
            $i++;
        }        
        $responce["total"] = $i;
        echo json_encode($responce);

	}

    if($operacion == "ligas"){
        $SQL = "SELECT l.codigo, CONCAT(l.abreviatura , ' - ', l.nombre) AS nombre FROM liga l";
        $result = $conexion->query( $SQL ) or die("Couldn t execute query.".mysql_error());

        $responce["total"] = 0;
        $i=0;
        while($row = $result->fetch_assoc()){
            $responce["data"][$i]=array("codigo"=>$row["codigo"],"nombre"=>$row["nombre"]);
            $i++;
        }        
        $responce["total"] = $i;
        echo json_encode($responce);

    }

    if($operacion == "categorias"){
        $SQL = "SELECT c.codigo, CONCAT(c.peso , 'kg - ', c.nombre) AS nombre FROM categoria c";
        $result = $conexion->query( $SQL ) or die("Couldn t execute query.".mysql_error());

        $responce["total"] = 0;
        $i=0;
        while($row = $result->fetch_assoc()){
            $responce["data"][$i]=array("codigo"=>$row["codigo"],"nombre"=>$row["nombre"]);
            $i++;
        }        
        $responce["total"] = $i;
        echo json_encode($responce);

    }

    if($operacion == "entrenadores"){
        $SQL = "SELECT e.codigo,CONCAT(l.abreviatura,' - ', l.nombre) AS liga ,p.identificacion,CONCAT(p.nombre1,' ',p.nombre2,' ',p.apellido1,' ',p.apellido2) AS nombre, p.fechaNacimiento,p.genero,p.nombre1,p.nombre2,p.apellido1,p.apellido2 FROM entrenador e,persona p,liga l WHERE e.codPersona = p.codigo AND l.codigo = e.codLiga";
        $result = $conexion->query( $SQL ) or die("Couldn t execute query.".mysql_error());

        $responce["total"] = 0;
        $i=0;
        while($row = $result->fetch_assoc()){
            $responce["data"][$i]=array("codigo"=>$row["codigo"],"nombre"=>$row["nombre"]);
            $i++;
        }        
        $responce["total"] = $i;
        echo json_encode($responce);

    }

    if($operacion == "eventos"){
        $SQL = "SELECT e.codigo,e.nombre AS nombre FROM eventos e";
        $result = $conexion->query( $SQL ) or die("Couldn t execute query.".mysql_error());

        $responce["total"] = 0;
        $i=0;
        while($row = $result->fetch_assoc()){
            $responce["data"][$i]=array("codigo"=>$row["codigo"],"nombre"=>$row["nombre"]);
            $i++;
        }        
        $responce["total"] = $i;
        echo json_encode($responce);

    }

    if($operacion == "atletas"){
        $SQL = "SELECT a.codigo, CONCAT(p.nombre1,' ',p.nombre2,' ',p.apellido1,' ',p.apellido2) AS nombre ".
                "FROM atleta a,persona p ".
                "WHERE a.codPersona = p.codigo";
        $result = $conexion->query( $SQL ) or die("Couldn t execute query.".mysql_error());

        $responce["total"] = 0;
        $i=0;
        while($row = $result->fetch_assoc()){
            $responce["data"][$i]=array("codigo"=>$row["codigo"],"nombre"=>$row["nombre"]);
            $i++;
        }        
        $responce["total"] = $i;
        echo json_encode($responce);

    }
}

?>