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
        $SQL = "DELETE FROM atleta WHERE codigo='".$codigo."'";
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
        $resultado = $conexion->query( "SELECT COUNT(*) AS count FROM atleta" ) or die("Couldn t execute query.".mysql_error());
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
            $peso = isset($_GET['peso']) ? $_GET['peso'] : "%";
            $genero = isset($_GET['genero']) ? $_GET['genero'] : "%";
            $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : "%";
            $entrenador = isset($_GET['entrenador']) ? $_GET['entrenador'] : "%";
            $SQL = "SELECT a.codigo,". 
                        "p.identificacion,".
                        "CONCAT(p.nombre1,' ',p.nombre2,' ',p.apellido1,' ',p.apellido2) AS nombre,".
                        "p.fechaNacimiento,".
                        "a.peso,".
                        "p.genero,".
                        "CONCAT(c.peso , 'kg - ', c.nombre) AS categoria ,".
                        "CONCAT(l.abreviatura,' - ', l.nombre) AS liga ,".
                        "(SELECT  CONCAT(pe.nombre1,' ',pe.nombre2,' ',pe.apellido1,' ',pe.apellido2) AS entrenador from entrenador ent,persona pe WHERE ent.codPersona = pe.codigo AND ent.codigo=a.codEntrenador) AS entrenador,".
                        "p.nombre1,p.nombre2,p.apellido1,p.apellido2 ".
                        "FROM atleta a,persona en,categoria c,persona p,liga l,entrenador e ".
                        "WHERE a.codCategoria = c.codigo AND a.codLiga = l.codigo AND a.codPersona = p.codigo AND ".
                        "p.identificacion LIKE '%".$identificacion."%' AND ".
                        "CONCAT(p.nombre1,' ',p.nombre2,' ',p.apellido1,' ',p.apellido2) LIKE '%".$nombre."%' AND ".
                        "p.fechaNacimiento LIKE '%".$fechaNacim."%' AND ".
                        "a.peso LIKE '%".$peso."%' AND ".                
                        "CONCAT(c.peso , 'kg - ', c.nombre) LIKE '%".$categoria."%' AND ".
                        "CONCAT(l.abreviatura,' - ', l.nombre) LIKE '%".$liga."%' AND ".
                        "p.genero LIKE '%".$genero."%' AND ".
                        "(SELECT  CONCAT(pe.nombre1,' ',pe.nombre2,' ',pe.apellido1,' ',pe.apellido2) AS entrenador from entrenador ent,persona pe WHERE ent.codPersona = pe.codigo AND ent.codigo=a.codEntrenador) LIKE '%".$entrenador."%' ".                
                        "GROUP BY a.codigo ORDER BY $sidx $sord LIMIT $start , $limit";

                        //echo $SQL;
        }else{
            $SQL = "SELECT a.codigo,".
                    "p.identificacion,".
                    "CONCAT(p.nombre1,' ',p.nombre2,' ',p.apellido1,' ',p.apellido2) AS nombre,".
                    "p.fechaNacimiento,".
                    "a.peso,".
                    "p.genero,".
                    "CONCAT(c.peso , 'kg - ', c.nombre) AS categoria ,".
                    "CONCAT(l.abreviatura,' - ', l.nombre) AS liga ,".
                    "(SELECT  CONCAT(pe.nombre1,' ',pe.nombre2,' ',pe.apellido1,' ',pe.apellido2) AS entrenador from entrenador ent,persona pe WHERE ent.codPersona = pe.codigo AND ent.codigo=a.codEntrenador) AS entrenador,".
                    "p.nombre1,p.nombre2,p.apellido1,p.apellido2 ".
                    "FROM atleta a,categoria c,persona p,liga l,entrenador e ".
                    "where ".
                    "a.codCategoria = c.codigo AND ".
                    "a.codLiga = l.codigo AND ".
                    "a.codPersona = p.codigo ".
                    "GROUP BY a.codigo ORDER BY $sidx $sord LIMIT $start , $limit";
        }

        $result = $conexion->query( $SQL ) or die("Couldn t execute query.".mysql_error());

        $responce["page"] = $page;
        $responce["total"] = $total_pages;
        $responce["records"] = $count;
        $i=0;
        while($row = $result->fetch_assoc()){
            $responce["rows"][$i]['id']=$row["codigo"];
            $responce["rows"][$i]['cell']=array($row["codigo"],$row["identificacion"],$row["nombre"],$row["fechaNacimiento"],$row["peso"],$row["genero"],$row["categoria"],$row["liga"],$row["entrenador"],$row["nombre1"],$row["nombre2"],$row["apellido1"],$row["apellido2"]);
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
    $peso = isset($_POST['peso']) ? $_POST['peso'] : "";
    $genero = isset($_POST['genero']) ? $_POST['genero'] : null;
    $codCategoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;
    $codEntrenador = isset($_POST['entrenador']) ? $_POST['entrenador'] : null;
    $codLiga = isset($_POST['liga']) ? $_POST['liga'] : null;

    if ($codigo) {

        $resultado = $conexion->query( "SELECT codPersona FROM atleta WHERE codigo='".$codigo."'" ) or die("Couldn t execute query.".mysql_error());
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

            $updateAtleta = "UPDATE atleta ".
            "SET codLiga=".$codLiga.", ".        
            "peso=".$peso.", ".        
            "codCategoria=".$codCategoria.", ".        
            "codEntrenador=".$codEntrenador." ".        
            "WHERE codigo='".$codigo."'";
            $update_row = $conexion->query($updateAtleta);
            if($update_row){
                echo json_encode(array("editado"=>"OK"));
            }else{
                echo json_encode(array("editado"=>"KO","mensage"=>"No se pudo actualizar el atleta."));
            }
        }else{        
            echo json_encode(array("editado"=>"KO","mensage"=>"No se pudo actualizar el atleta."));
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


                    $insertAtleta = "INSERT INTO atleta(codPersona,peso,codCategoria,codEntrenador,codLiga) ".
                    "VALUES(".$codigoPersona.",".$peso.",".$codCategoria.",".$codEntrenador.",".$codLiga.")";

                    $insert_row = $conexion->query($insertAtleta) ;//or die("Couldn t execute query.".mysql_error());
                    if($insert_row){ 
                        echo json_encode(array("guardado"=>"OK"));
                    }else{        
                        echo json_encode(array("guardado"=>"KO","mensage"=>"Error al guardar atleta.".$insertAtleta));
                    }
                }else{        
                    echo json_encode(array("guardado"=>"KO"));
                }
            }else{
                echo json_encode(array("guardado"=>"KO","mensage"=>"Ya existe un atleta con esa identificación."));   
            }
        }else{
            echo json_encode(array("guardado"=>"KO","mensage"=>"Identificación es requerida."));
        }
    }

}
?>