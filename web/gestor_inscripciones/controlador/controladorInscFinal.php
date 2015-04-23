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
        $SQL = "DELETE FROM inscripcionPreliminar WHERE codigo='".$codigo."'";
        $result = $conexion->query( $SQL )  or die("Couldn t execute query.".mysql_error());
        if ($result === TRUE) {
            $responce["eliminado"] = "OK";
        }else{
            $responce["eliminado"] = "KO";
        }
        echo json_encode($responce);
    }

    if($operacion == "listarPrelimnar"){
        $page = $_GET['page']; // get the requested page
        $limit = $_GET['rows']; // get how many rows we want to have into the grid
        $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
        $sord = $_GET['sord']; // get the direction
        if(!$sidx) $sidx =1;

          /* Consultas de selección que devuelven un conjunto de resultados */
        $resultado = $conexion->query( "SELECT COUNT(*) AS count FROM inscripcionPreliminar " ) or die("Couldn t execute query.".mysql_error());
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
            $atleta = isset($_GET['atleta']) ? $_GET['atleta'] : "%";
            $peso = isset($_GET['peso']) ? $_GET['peso'] : "%";
            
            $codEvento = isset($_GET['codEvento']) ? $_GET['codEvento'] : "%";
            $codCategoria = isset($_GET['codCategoria']) ? $_GET['codCategoria'] : "%";
            
            $liga = isset($_GET['liga']) ? $_GET['liga'] : "%";

            $SQL = "SELECT ip.codigo, e.nombre AS evento,CONCAT(p.nombre1,' ',p.nombre2,' ',p.apellido1,' ',p.apellido2) AS atleta, ip.peso, l.nombre AS liga, c.nombre AS categoria, ".
                "e.codigo AS codEvento,l.codigo AS codLiga,c.codigo AS codCategoria,a.codigo AS codAtleta ".
                "FROM inscripcionPreliminar ip, atleta a,liga l, eventos e, categoria c, persona p ".
                "WHERE ".
                "ip.final = false AND ".
                "ip.codLiga = l.codigo AND ".
                "ip.codAtleta = a.codigo AND ".
                "ip.codEvento = e.codigo AND ".
                "ip.codCategoria = c.codigo AND ".
                "a.codPersona = p.codigo AND ".
                "CONCAT(p.nombre1,' ',p.nombre2,' ',p.apellido1,' ',p.apellido2) LIKE '%".$atleta."%' AND ".
                "ip.peso LIKE '%".$peso."%' AND ".
                "e.codigo LIKE '%".$codEvento."%' AND ".
                "c.codigo LIKE '%".$codCategoria."%' AND ".
                "l.nombre LIKE '%".$liga."%' ".
                " GROUP BY ip.codigo ORDER BY $sidx $sord LIMIT $start , $limit";
               // echo $SQL;
        }else{
            $codEvento = isset($_GET['codEvento']) ? $_GET['codEvento'] : "%";
            $codCategoria = isset($_GET['codCategoria']) ? $_GET['codCategoria'] : "%";
            
            $SQL =  "SELECT ip.codigo, e.nombre AS evento,CONCAT(p.nombre1,' ',p.nombre2,' ',p.apellido1,' ',p.apellido2) AS atleta, ip.peso, l.nombre AS liga, c.nombre AS categoria, ".
                    "e.codigo AS codEvento,l.codigo AS codLiga,c.codigo AS codCategoria,a.codigo AS codAtleta ".
                    "FROM inscripcionPreliminar ip, atleta a,liga l, eventos e, categoria c, persona p ".
                    "WHERE ip.codAtleta = a.codigo AND ".
                    "ip.final = false AND ".
                    "ip.codLiga = l.codigo AND ".
                    "ip.codAtleta = a.codigo AND ".
                    "ip.codEvento = e.codigo AND ".
                    "ip.codCategoria = c.codigo AND ".
                    "e.codigo LIKE '%".$codEvento."%' AND ".
                    "c.codigo LIKE '%".$codCategoria."%' AND ".
                    "a.codPersona = p.codigo ".
                    " GROUP BY ip.codigo ORDER BY $sidx $sord LIMIT $start , $limit";
        }

        $result = $conexion->query( $SQL ) or die("Couldn t execute query.".mysql_error());

        $responce["page"] = $page;
        $responce["total"] = $total_pages;
        $responce["records"] = $count;
        $i=0;
        while($row = $result->fetch_assoc()){
            $responce["rows"][$i]['id']=$row["codigo"];
            $responce["rows"][$i]['cell']=array($row["codigo"],$row["atleta"],$row["peso"],$row["liga"],$row["evento"],$row["categoria"],$row["codEvento"],$row["codAtleta"],$row["codLiga"],$row["codCategoria"]);
            $i++;
        }        
        echo json_encode($responce);
    }
    if($operacion == "listarFinal"){
        $page = $_GET['page']; // get the requested page
        $limit = $_GET['rows']; // get how many rows we want to have into the grid
        $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
        $sord = $_GET['sord']; // get the direction
        if(!$sidx) $sidx =1;

          /* Consultas de selección que devuelven un conjunto de resultados */
        $resultado = $conexion->query( "SELECT COUNT(*) AS count FROM inscripcionfinal " ) or die("Couldn t execute query.".mysql_error());
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
            $atleta = isset($_GET['atleta']) ? $_GET['atleta'] : "%";
            $peso = isset($_GET['peso']) ? $_GET['peso'] : "%";
            
            $codEvento = isset($_GET['codEvento']) ? $_GET['codEvento'] : "%";
            $codCategoria = isset($_GET['codCategoria']) ? $_GET['codCategoria'] : "%";
            $liga = isset($_GET['liga']) ? $_GET['liga'] : "%";

            $SQL = "SELECT ip.codigo, e.nombre AS evento,CONCAT(p.nombre1,' ',p.nombre2,' ',p.apellido1,' ',p.apellido2) AS atleta, ip.peso, l.nombre AS liga, c.nombre AS categoria, ".
                "e.codigo AS codEvento,l.codigo AS codLiga,c.codigo AS codCategoria,a.codigo AS codAtleta ".
                "FROM inscripcionfinal ip, atleta a,liga l, eventos e, categoria c, persona p ".
                "WHERE ".
                "ip.codLiga = l.codigo AND ".
                "ip.codAtleta = a.codigo AND ".
                "ip.codEvento = e.codigo AND ".
                "ip.codCategoria = c.codigo AND ".
                "a.codPersona = p.codigo AND ".
                "CONCAT(p.nombre1,' ',p.nombre2,' ',p.apellido1,' ',p.apellido2) LIKE '%".$atleta."%' AND ".
                "ip.peso LIKE '%".$peso."%' AND ".
                "e.codigo LIKE '%".$codEvento."%' AND ".
                "c.codigo LIKE '%".$codCategoria."%' AND ".
                "l.nombre LIKE '%".$liga."%' ".
                " GROUP BY ip.codigo ORDER BY $sidx $sord LIMIT $start , $limit";
        }else{
            $codEvento = isset($_GET['codEvento']) ? $_GET['codEvento'] : "%";
            $codCategoria = isset($_GET['codCategoria']) ? $_GET['codCategoria'] : "%";
            $SQL =  "SELECT ip.codigo, e.nombre AS evento,CONCAT(p.nombre1,' ',p.nombre2,' ',p.apellido1,' ',p.apellido2) AS atleta, ip.peso, l.nombre AS liga, c.nombre AS categoria, ".
                    "e.codigo AS codEvento,l.codigo AS codLiga,c.codigo AS codCategoria,a.codigo AS codAtleta ".
                    "FROM inscripcionfinal ip, atleta a,liga l, eventos e, categoria c, persona p ".
                    "WHERE ip.codAtleta = a.codigo AND ".
                    "ip.codLiga = l.codigo AND ".
                    "ip.codAtleta = a.codigo AND ".
                    "ip.codEvento = e.codigo AND ".
                    "ip.codCategoria = c.codigo AND ".
                    "e.codigo LIKE '%".$codEvento."%' AND ".
                    "c.codigo LIKE '%".$codCategoria."%' AND ".
                    "a.codPersona = p.codigo ".
                    " GROUP BY ip.codigo ORDER BY $sidx $sord LIMIT $start , $limit";
        }

        $result = $conexion->query( $SQL ) or die("Couldn t execute query.".mysql_error());

        $responce["page"] = $page;
        $responce["total"] = $total_pages;
        $responce["records"] = $count;
        $i=0;
        while($row = $result->fetch_assoc()){
            $responce["rows"][$i]['id']=$row["codigo"];
            $responce["rows"][$i]['cell']=array($row["codigo"],'',$row["atleta"],$row["peso"],$row["liga"],$row["evento"],$row["categoria"],$row["codEvento"],$row["codAtleta"],$row["codLiga"],$row["codCategoria"]);
            $i++;
        }        
        echo json_encode($responce);
    }

}

if($tipoPeticion == "POST"){
    $operacion = isset($_POST['operacion']) ? $_POST['operacion'] : null;
    $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : null;

    if($operacion){
        if($operacion == 'pasarFinal'){
            if ($codigo) {
                $pasarFinal =  "INSERT INTO inscripcionfinal (codAtleta,peso,codLiga,codEvento,codCategoria,codInscFin) ".
                                "SELECT ip.codAtleta,ip.peso,ip.codLiga,ip.codEvento,ip.codCategoria,ip.codigo ".
                                "FROM inscripcionpreliminar ip ".
                                "WHERE ip.codigo = ".$codigo;
                
                $insert_row = $conexion->query($pasarFinal);
                if($insert_row)
                {   
                    $updateIncPreliminar = "UPDATE inscripcionPreliminar SET final=true WHERE codigo =".$codigo;
                    $update_row = $conexion->query($updateIncPreliminar);

                   echo json_encode(array("guardado"=>"OK"));
                }else{        
                    echo json_encode(array("guardado"=>"KO","mensage"=>"No se pudo guardar el registro."));
                }
            }
        }

        if($operacion == 'pasarPreliminar'){
            if ($codigo) {
                 $resultado = $conexion->query( "SELECT codInscFin FROM inscripcionfinal WHERE codigo=".$codigo ) or die("Couldn t execute query.".mysql_error());
                $row = $resultado->fetch_assoc();
                $codInscFin = $row['codInscFin'];

                $pasarFinal =  "DELETE ".
                                "FROM inscripcionfinal ".
                                "WHERE codigo = ".$codigo;
                
                $insert_row = $conexion->query($pasarFinal);
                if($insert_row)
                {   


                    $updateIncPreliminar = "UPDATE inscripcionPreliminar SET final=false WHERE codigo =".$codInscFin;
                    $update_row = $conexion->query($updateIncPreliminar);

                   echo json_encode(array("guardado"=>"OK"));
                }else{        
                    echo json_encode(array("guardado"=>"KO","mensage"=>"No se pudo guardar el registro."));
                }
            }
        }
    }else{
        echo json_encode(array("guardado"=>"KO","mensage"=>"1No se pudo guardar el registro."));
    }

}
?>