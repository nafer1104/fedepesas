<?php
//include db configuration file
include_once("../../../conexion/conexion.php");

//obtenemos el tipo de peticion que se esta haciendo (GET,POST,PUT,DELETE)
$tipoPeticion = $_SERVER['REQUEST_METHOD'];

  
if($tipoPeticion == "GET"){
    $responce = array();
    $operacion = $_GET['operacion']; // get the requested page
    if($operacion == "el"){
        $codigo = $_GET['codigo']; // get the requested page
        $SQL = "DELETE FROM liga WHERE codigo='".$codigo."'";
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
        $resultado = $conexion->query( "SELECT COUNT(*) AS count FROM liga" ) or die("Couldn t execute query.".mysql_error());
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
            $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : "%";
            $abreviatura = isset($_GET['abreviatura']) ? $_GET['abreviatura'] : "%";
            $descripcion = isset($_GET['descripcion']) ? $_GET['descripcion'] : "%";
            $SQL = "SELECT l.codigo,l.nombre,l.abreviatura,l.descripcion FROM liga l ".
                "WHERE ".
                "l.nombre LIKE '%".$nombre."%' AND ".
                "l.abreviatura LIKE '%".$abreviatura."%' AND ".
                "l.descripcion LIKE '%".$descripcion."%' ".
                " ORDER BY $sidx $sord LIMIT $start , $limit";
        }else{
            $SQL = "SELECT l.codigo,l.nombre,l.abreviatura,l.descripcion FROM liga l ORDER BY $sidx $sord LIMIT $start , $limit";
        }

        $result = $conexion->query( $SQL ) or die("Couldn t execute query.".mysql_error());

        $responce["page"] = $page;
        $responce["total"] = $total_pages;
        $responce["records"] = $count;
        $i=0;
        while($row = $result->fetch_assoc()){
            $responce["rows"][$i]['id']=$row["codigo"];
            $responce["rows"][$i]['cell']=array($row["codigo"],$row["nombre"],$row["abreviatura"],$row["descripcion"]);
            $i++;
        }        
        echo json_encode($responce);
    }

}

if($tipoPeticion == "POST"){
    $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : null;
    $nombre = $_POST['nombre']; 
    $abreviatura = $_POST['abreviatura']; 
    $descripcion = $_POST['descripcion'];
    if ($codigo) {
        $insertLiga = "UPDATE liga SET nombre='".$nombre."',abreviatura='".$abreviatura."',descripcion='".$descripcion."' WHERE codigo=".$codigo;
        $insert_row = $conexion->query($insertLiga);
        if($insert_row)
        {
           echo json_encode(array("editado"=>"OK"));
        }else{        
            echo json_encode(array("editado"=>"KO"));
        }
    }else{
        $insertLiga = "INSERT INTO liga(nombre,abreviatura,descripcion) VALUES('".$nombre."','".$abreviatura."','".$descripcion."')";
        $insert_row = $conexion->query($insertLiga);
        if($insert_row)
        {
           echo json_encode(array("guardado"=>"OK"));
        }else{        
            echo json_encode(array("guardado"=>"KO"));
        }
    }

}
?>