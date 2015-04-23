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
        $SQL = "DELETE FROM categoria WHERE codigo='".$codigo."'";
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
        $resultado = $conexion->query( "SELECT COUNT(*) AS count FROM categoria" ) or die("Couldn t execute query.".mysql_error());
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
            $peso = isset($_GET['peso']) ? $_GET['peso'] : "%";
            $rama = isset($_GET['rama']) ? $_GET['rama'] : "%";
            $SQL = "SELECT c.codigo,c.nombre,c.peso,r.nombre rama FROM categoria c,rama r ".
                "WHERE c.codRama = r.codigo AND ".
                "c.nombre LIKE '%".$nombre."%' AND ".
                "c.peso LIKE '%".$peso."%' AND ".
                "r.nombre LIKE '%".$rama."%' ".
                " ORDER BY $sidx $sord LIMIT $start , $limit";
        }else{
            $SQL = "SELECT c.codigo,c.nombre,c.peso,r.nombre rama FROM categoria c,rama r WHERE c.codRama = r.codigo ORDER BY $sidx $sord LIMIT $start , $limit";
        }

        $result = $conexion->query( $SQL ) or die("Couldn t execute query.".mysql_error());

        $responce["page"] = $page;
        $responce["total"] = $total_pages;
        $responce["records"] = $count;
        $i=0;
        while($row = $result->fetch_assoc()){
            $responce["rows"][$i]['id']=$row["codigo"];
            $responce["rows"][$i]['cell']=array($row["codigo"],$row["nombre"],$row["peso"],$row["rama"]);
            $i++;
        }        
        echo json_encode($responce);
    }

}

if($tipoPeticion == "POST"){
    $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : null;
    $nombre = $_POST['nombre']; 
    $peso = $_POST['peso']; 
    $rama = isset($_POST['rama']) ? $_POST['rama'] : null;
    if ($codigo) {
        $insertcategoria = "UPDATE categoria SET nombre='".$nombre."',peso='".$peso."',codRama='".$rama."' WHERE codigo=".$codigo;
        $insert_row = $conexion->query($insertcategoria);
        if($insert_row)
        {
           echo json_encode(array("editado"=>"OK"));
        }else{        
            echo json_encode(array("editado"=>"KO"));
        }
    }else{
        $insertcategoria = "INSERT INTO categoria(nombre,peso,codRama) VALUES('".$nombre."','".$peso."',".$rama.")";
        $insert_row = $conexion->query($insertcategoria);
        if($insert_row)
        {
           echo json_encode(array("guardado"=>"OK"));
        }else{        
            echo json_encode(array("guardado"=>"KO"));
        }
    }

}
?>