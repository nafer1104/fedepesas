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
        $SQL = "DELETE FROM eventos WHERE codigo='".$codigo."'";
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
        $resultado = $conexion->query( "SELECT COUNT(*) AS count FROM eventos" ) or die("Couldn t execute query.".mysql_error());
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
            $fechaEvento = isset($_GET['fechaEvento']) ? $_GET['fechaEvento'] : "%";
            $lugar = isset($_GET['lugar']) ? $_GET['lugar'] : "%";
            $SQL = "SELECT e.codigo,e.nombre,e.fecha,e.lugar FROM eventos e ".
                "WHERE ".
                "e.nombre LIKE '%".$nombre."%' AND ".
                "e.fecha LIKE '%".$fechaEvento."%' AND ".
                "e.lugar LIKE '%".$lugar."%' ".
                " ORDER BY $sidx $sord LIMIT $start , $limit";
        }else{
            $SQL = "SELECT e.codigo,e.nombre,e.fecha,e.lugar FROM eventos e ORDER BY $sidx $sord LIMIT $start , $limit";
        }

        $result = $conexion->query( $SQL ) or die("Couldn t execute query.".mysql_error());

        $responce["page"] = $page;
        $responce["total"] = $total_pages;
        $responce["records"] = $count;
        $i=0;
        while($row = $result->fetch_assoc()){
            $responce["rows"][$i]['id']=$row["codigo"];
            $responce["rows"][$i]['cell']=array($row["codigo"],$row["nombre"],$row["fecha"],$row["lugar"]);
            $i++;
        }        
        echo json_encode($responce);
    }

}

if($tipoPeticion == "POST"){
    $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : null;
    $nombre = $_POST['nombre']; 
    $fechaEvento = $_POST['fechaEvento']; 
    $lugar = $_POST['lugar'];
    if ($codigo) {
        $insertEvento = "UPDATE eventos SET nombre='".$nombre."',fecha='".$fechaEvento."',lugar='".$lugar."' WHERE codigo=".$codigo;
        $insert_row = $conexion->query($insertEvento);
        if($insert_row)
        {
           echo json_encode(array("editado"=>"OK"));
        }else{        
            echo json_encode(array("editado"=>"KO"));
        }
    }else{
        $insertEvento = "INSERT INTO eventos(nombre,fecha,lugar) VALUES('".$nombre."','".$fechaEvento."','".$lugar."')";
        $insert_row = $conexion->query($insertEvento);
        if($insert_row)
        {
           echo json_encode(array("guardado"=>"OK"));
        }else{        
            echo json_encode(array("guardado"=>"KO","mensage"=>$insertEvento));
        }
    }

}
?>