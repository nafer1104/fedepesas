<?php
//include db configuration file
include_once("../../../conexion/conexion.php");

//obtenemos el tipo de peticion que se esta haciendo (GET,POST,PUT,DELETE)
$tipoPeticion = $_SERVER['REQUEST_METHOD'];
$responce = array();
  
if($tipoPeticion == "GET"){
    
    $operacion = $_GET['operacion']; // get the requested page
    if($operacion == "el"){
        $codigo = $_GET['codigo']; // get the requested page
        $SQL = "DELETE FROM entrenador WHERE codigo='".$codigo."'";
        $result = $conexion->query( $SQL )  or die("Couldn t execute query.".mysql_error());
        if ($result === TRUE) {
            $responce["eliminado"] = "OK";
        }else{
            $responce["eliminado"] = "KO";
        }
        echo json_encode($responce);
    }

    if($operacion == "listar"){
        $page = $_GET['page']; // get the requested page
        $limit = $_GET['rows']; // get how many rows we want to have into the grid
        $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
        $sord = $_GET['sord']; // get the direction
        if(!$sidx) $sidx =1;

          /* Consultas de selección que devuelven un conjunto de resultados */
        $resultado = $conexion->query( "SELECT COUNT(*) AS count FROM entrenador" ) or die("Couldn t execute query.".mysql_error());
        $row = $resultado->fetch_assoc();
        $count = $row['count'];

        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages) $page=$total_pages;
        if ($limit<0) $limit = 0;
        $start = $limit*$page - $limit; // do not put $limit*($page - 1)
        if ($start<0) $start = 0;

        $isSearch = $_GET['_search'];
        
        if($isSearch == "true"){
            $liga = isset($_GET['liga']) ? $_GET['liga'] : "%";
            $identificacion = isset($_GET['identificacion']) ? $_GET['identificacion'] : "%";
            $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : "%";
            $fechaNacim = isset($_GET['fechaNacim']) ? $_GET['fechaNacim'] : "%";
            $genero = isset($_GET['genero']) ? $_GET['genero'] : "%";
            $SQL = "SELECT e.codigo,CONCAT(l.abreviatura,' - ', l.nombre) AS liga ,p.identificacion,CONCAT(p.nombre1,' ',p.nombre2,' ',p.apellido1,' ',p.apellido2) AS nombre, p.fechaNacimiento,p.genero,p.nombre1,p.nombre2,p.apellido1,p.apellido2 ".
                "FROM entrenador e,persona p,liga l ".
                "WHERE e.codPersona = p.codigo AND l.codigo = e.codLiga AND ".
                "CONCAT(l.abreviatura,' - ', l.nombre) LIKE '%".$liga."%' AND ".
                "p.identificacion LIKE '%".$identificacion."%' AND ".
                "CONCAT(p.nombre1,' ',p.nombre2,' ',p.apellido1,' ',p.apellido2) LIKE '%".$nombre."%' AND ".
                "p.fechaNacimiento LIKE '%".$fechaNacim."%' AND ".
                "p.genero LIKE '%".$genero."%' ".                
                " ORDER BY $sidx $sord LIMIT $start , $limit";
        }else{
            $SQL = "SELECT e.codigo,CONCAT(l.abreviatura,' - ', l.nombre) AS liga ,p.identificacion,CONCAT(p.nombre1,' ',p.nombre2,' ',p.apellido1,' ',p.apellido2) AS nombre, p.fechaNacimiento,p.genero,p.nombre1,p.nombre2,p.apellido1,p.apellido2 FROM entrenador e,persona p,liga l WHERE e.codPersona = p.codigo AND l.codigo = e.codLiga ORDER BY $sidx $sord LIMIT $start , $limit";
        }

        $result = $conexion->query( $SQL ) or die("Couldn t execute query.".mysql_error());

        $responce["page"] = $page;
        $responce["total"] = $total_pages;
        $responce["records"] = $count;
        $i=0;
        while($row = $result->fetch_assoc()){
            $responce["rows"][$i]['id']=$row["codigo"];
            $responce["rows"][$i]['cell']=array($row["codigo"],$row["liga"],$row["identificacion"],$row["nombre"],$row["fechaNacimiento"],$row["genero"],$row["nombre1"],$row["nombre2"],$row["apellido1"],$row["apellido2"]);
            $i++;
        }        
        echo json_encode($responce);
    }

}

if($tipoPeticion == "POST"){

    $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : null;
    $identificacion = isset($_POST['identificacion']) ? $_POST['identificacion'] : null;
    $nombre1 = isset($_POST['nombre1']) ? $_POST['nombre1'] : "";
    $nombre2 = isset($_POST['nombre2']) ? $_POST['nombre2'] : "";
    $apellido1 = isset($_POST['apellido1']) ? $_POST['apellido1'] : "";
    $apellido2 = isset($_POST['apellido2']) ? $_POST['apellido2'] : "";
    $fechaNacim = isset($_POST['fechaNacim']) ? $_POST['fechaNacim'] : "";
    $genero = isset($_POST['genero']) ? $_POST['genero'] : null;
    $codLiga = isset($_POST['liga']) ? $_POST['liga'] : null;

    if ($codigo) {

        $resultado = $conexion->query( "SELECT codPersona FROM entrenador WHERE codigo='".$codigo."'" ) or die("Couldn t execute query.".mysql_error());
        $row = $resultado->fetch_assoc();
        $codPers = $row['codPersona'];

        $updatepersona = "UPDATE persona ".
        "SET identificacion='".$identificacion."', ".
        "nombre1='".$nombre1."',".
        "nombre2='".$nombre2."', ".
        "apellido1='".$apellido1."', ".
        "apellido2='".$apellido2."', ".
        "fechaNacimiento='".$fechaNacim."', ".
        "genero='".$genero."' ".
        "WHERE codigo=".$codPers;

        $update_row = $conexion->query($updatepersona);
        if($update_row)
        {

            $updatejuez = "UPDATE entrenador ".
            "SET codLiga=".$codLiga." ".        
            "WHERE codigo='".$codigo."'";
            $update_row = $conexion->query($updatejuez);
            if($update_row){
                echo json_encode(array("editado"=>"OK"));
            }else{
                echo json_encode(array("editado"=>"KO","mensage"=>"No se pudo actualizar la liga."));
            }
        }else{        
            echo json_encode(array("editado"=>"KO"));
        }
    }else{
        if($identificacion){

            /* Consultas de selección que devuelven un conjunto de resultados */
            $resultado = $conexion->query( "SELECT COUNT(*) AS count FROM persona WHERE identificacion='".$identificacion."'" ) or die("Couldn t execute query.".mysql_error());
            $row = $resultado->fetch_assoc();
            $count = $row['count'];
            if($count ==  0){
                $insertPersona = "INSERT INTO persona(identificacion,nombre1,nombre2,apellido1,apellido2,fechaNacimiento,genero) ".
                "VALUES('".$identificacion."','".$nombre1."','".$nombre2."','".$apellido1."','".$apellido2."','".$fechaNacim."','".$genero."' )";

                $insert_row = $conexion->query($insertPersona);
                if($insert_row)
                {   

                    $resultado = $conexion->query( "SELECT p.codigo FROM persona p WHERE identificacion='".$identificacion."'" ) or die("Couldn t execute query.".mysql_error());
                    $row = $resultado->fetch_assoc();
                    $codigoPersona = $row['codigo'];


                    $insertJueces = "INSERT INTO entrenador(codPersona,codLiga) ".
                    "VALUES(".$codigoPersona.",".$codLiga." )";

                    $insert_row = $conexion->query($insertJueces);
                    if($insert_row){ 
                        echo json_encode(array("guardado"=>"OK"));
                    }else{        
                        echo json_encode(array("guardado"=>"KO"));
                    }
                }else{        
                    echo json_encode(array("guardado"=>"KO"));
                }
            }else{
                echo json_encode(array("guardado"=>"KO","mensage"=>"Ya existe un entrenador con esa identificación."));   
            }
        }else{
            echo json_encode(array("guardado"=>"KO","mensage"=>"Identificación es requerida."));
        }
    }

}
?>