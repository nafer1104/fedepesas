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
        $SQL = "DELETE FROM tipojuez WHERE codigo='".$codigo."'";
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
        $resultado = $conexion->query( "SELECT COUNT(*) AS count FROM tipojuez" ) or die("Couldn t execute query.".mysql_error());
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
            $SQL = "SELECT tj.codigo,tj.nombre,tj.abreviatura FROM tipojuez tj ".
                "WHERE ".
                "tj.nombre LIKE '%".$nombre."%' AND ".
                "tj.abreviatura LIKE '%".$abreviatura."%' ".
                "ORDER BY $sidx $sord LIMIT $start , $limit";
        }else{
            $SQL = "SELECT tj.codigo,tj.nombre,tj.abreviatura FROM tipojuez tj ORDER BY $sidx $sord LIMIT $start , $limit";
        }

        $result = $conexion->query( $SQL ) or die("Couldn t execute query.".mysql_error());

        $responce["page"] = $page;
        $responce["total"] = $total_pages;
        $responce["records"] = $count;
        $i=0;
        while($row = $result->fetch_assoc()){
            $responce["rows"][$i]['id']=$row["codigo"];
            $responce["rows"][$i]['cell']=array($row["codigo"],$row["nombre"],$row["abreviatura"]);
            $i++;
        }        
        echo json_encode($responce);
    }

}

if($tipoPeticion == "POST"){
    $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : null;
    $nombre = $_POST['nombre']; 
    $abreviatura = $_POST['abreviatura']; 
    if ($codigo) {
        $insertLiga = "UPDATE tipojuez SET nombre='".$nombre."',abreviatura='".$abreviatura."' WHERE codigo=".$codigo;
        $insert_row = $conexion->query($insertLiga);
        if($insert_row)
        {
           echo json_encode(array("editado"=>"OK"));
        }else{        
            echo json_encode(array("editado"=>"KO"));
        }
    }else{
        $insertLiga = "INSERT INTO tipojuez(nombre,abreviatura) VALUES('".$nombre."','".$abreviatura."')";
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