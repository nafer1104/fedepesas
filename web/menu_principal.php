<?php
session_start();
$_SESSION["iden_pers"]="73429694";
$_SESSION["nomb_pers"]="JOAQUIN SEGUNDO SILVA ROMERO";
$_SESSION["nomb_prog"]="PROGRAMA DE INGENIERIA DE SISTEMAS";
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Fedepesas</title>
    <link href="../estilos/index.css" rel="stylesheet">
    <link href="../librerias/bootstrap_3_2_2/css/bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src = "../librerias/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src = "../librerias/bootstrap_3_2_2/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        var jsonMaestro = [
            {
                "nombre":"Gestion de Ligas",
                "descripcion":"Permite registrar, editar las ligas dsfd dfd fd f df d df d fd f d f ",
                "logo":"../imagenes/maestros/ligas.png",
                "vista":"vistaLiga.php"
            },
            {
                "nombre":"Gestion de Categorias",
                "descripcion":"Permite registrar, editar las ligas dsfd dfd fd f df d df d fd f d f ",
                "logo":"../imagenes/maestros/ligas.png",
                "vista":"vistaCategoria.php"
            },
            {
                "nombre":"Gestion tipos de jueces",
                "descripcion":"Permite registrar, editar las ligas dsfd dfd fd f df d df d fd f d f ",
                "logo":"../imagenes/maestros/ligas.png",
                "vista":"vistaTipoJuez.php"
            },
            {
                "nombre":"Gestion jueces",
                "descripcion":"Permite registrar, editar las ligas dsfd dfd fd f df d df d fd f d f ",
                "logo":"../imagenes/maestros/ligas.png",
                "vista":"vistaJuez.php"
            },
            {
                "nombre":"Gestion de Entrenadores",
                "descripcion":"Permite registrar, editar las ligas dsfd dfd fd f df d df d fd f d f ",
                "logo":"../imagenes/maestros/ligas.png",
                "vista":"vistaEntrenador.php"
            },
            {
                "nombre":"Gestion de Atletas",
                "descripcion":"Permite registrar, editar las ligas dsfd dfd fd f df d df d fd f d f ",
                "logo":"../imagenes/maestros/ligas.png",
                "vista":"vistaAtleta.php"
            },
            {
                "nombre":"Gestion de Ligas",
                "descripcion":"Permite registrar, editar las ligas dsfd dfd fd f df d df d fd f d f ",
                "logo":"../imagenes/maestros/ligas.png"
            },
        ];
        $(document).ready(function() {
            loadMaestros();
        });
        function loadMaestros(argument) {
            var divMaestros = $("div#maestros");
            $.each(jsonMaestro, function( index, maestro ) {
                var divMaestro = $("<div class='maestros'></div>");
                var divLogo = $("<div style='width:85px;float:left;margin-top: 5px;margin-bottom: 5px;'><img class='rueda' width='80px' src='"+maestro.logo+"'></img></div>");
                var divNombreDesc = $("<div style='width:60%;float:left;  text-align: -webkit-left; margin-top: 5px;margin-bottom: 5px;'></div>");
                var divNombre = $("<div style='width:99%;float:left;margin-bottom: 4px;'><b>"+maestro.nombre+"</b></div>");
                var divDescr = $("<div style='width:99%;float:left'>"+maestro.descripcion+"</div>");

                divMaestro.append(divLogo);
                divMaestro.append(divNombreDesc);

                divNombreDesc.append(divNombre);
                divNombreDesc.append(divDescr);
                divMaestros.append(divMaestro);

                divMaestro.click(function () {
                    window.location.href = "maestros/vista/"+maestro.vista;
                });

            });
        }
    </script>
</head>

<body class="fuente">
   <div id="principal" align="center">
        <div id="cabecera">
            <div style="width:99%;float:left;height: 28px;"><font color="#FFF" style="font-size:14px"><strong>Sistema Para Registro y Control de Proyeccion Social</strong></font>c</div>
             <div style="width:49%;float:left; text-align: left;"><font color="#FFF" style="font-size:12px">Bienvenido, <?php echo $_SESSION["nomb_pers"]; ?></font></div>
              <div style="width:49%;float:left;text-align: right;"><font color="#FFF" style="font-size:12px"><?php echo $_SESSION["nomb_prog"]; ?></font></div>
        </div>
        <div id="cuerpo">
            <div style="font-size:150%;padding:20px"><strong>Menu Principal</strong></div>
            <div id="maestros" ></div>
        </div>
        <div id="pie">
            Soportes y Servicios Tecnologicos<br>
            Autor: Joaquin Segundo Silva Romero<br>
            Ingeniero de Sistemas
        </div>
    
    </div>
</body>
</html>