<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fedepesas</title>
<link href="estilos/estilo.css" rel="stylesheet" />
<link href="estilos/index.css" rel="stylesheet">
   
    <link href="librerias/css/jquery-ui/jquery-ui.css" rel="stylesheet">
    <link href="librerias/gridJS/css/ui.jqgrid.css" rel="stylesheet">
    <link href="librerias/bootstrap_3_2_2/css/bootstrap.css" rel="stylesheet">
    <link href="librerias/alert/alertify.js-0.3.11/themes/alertify.core.css" rel="stylesheet">
    <link href="librerias/alert/alertify.js-0.3.11/themes/alertify.bootstrap.css" rel="stylesheet">

    <script type="text/javascript" src = "librerias/jquery-2.1.3.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <script type="text/javascript" src = "librerias/bootstrap_3_2_2/js/bootstrap.min.js"></script>

    <script src="librerias/gridJS/js/i18n/grid.locale-en.js" type="text/javascript"></script>
    <script src="librerias/gridJS/js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <script src="librerias/alert/alertify.js-0.3.11/lib/alertify.min.js" type="text/javascript"></script>
    <script src="web/maestros/js/operaciones.js" type="text/javascript"></script>

<script type="text/javascript">
  function cargarPagina (nombre) {
    switch(nombre){
      case "evento":
        $("#contenido").load('web/maestros/vista/vistaEvento.php');  
      break;
      case "atleta":
        $("#contenido").load('web/maestros/vista/vistaAtleta.php');  
      break;
      case "liga":
        $("#contenido").load('web/maestros/vista/vistaLiga.php');  
      break;
      case "entrenador":
        $("#contenido").load('web/maestros/vista/vistaEntrenador.php');  
      break;
      case "categoria":
        $("#contenido").load('web/maestros/vista/vistaCategoria.php');  
      break;
      case "tipoJuez":
        $("#contenido").load('web/maestros/vista/vistaTipoJuez.php');  
      break;
      case "juez":
        $("#contenido").load('web/maestros/vista/vistaJuez.php');  
      break;
      case "inscPreli":
        $("#contenido").load('web/maestros/vista/vistaInscripcionPreliminar.php');  
      break;
      case "gestorInscripcion":
        $("#contenido").load('web/gestor_inscripciones/vistas/vistaInscFinal.php');  
      break;
    }
  }
</script>
</head>

<body>

<div class="containerInicial">
  <div class="header">
  <h2>M&oacute;dulo Administrador Para Gestionar Las Competencias De Levantamiento De Pesas</h2>
  </div>
  <div class="sidebar1">
    <ul class="nav">
	  <li><a href="./">
      <table><tr><td><img src="iconos/coor-010.png" /></td><td>Inicio</td></tr></table>
      </a></li>
      <li onclick="cargarPagina('evento')"><a href="#">
      <table><tr><td><img src="iconos/coor-001.png" /></td><td>Gestor de Eventos</td></tr></table>
      </a></li>
      <li><a href="#">
      <table><tr><td><img src="iconos/coor-004.png" /></td><td>Programación de Eventos</td></tr></table>
      </a></li>
      <li onclick="cargarPagina('gestorInscripcion')"><a href="#">
      <table><tr><td><img src="iconos/coor-002.png" /></td><td>Gestor de Inscripciones</td></tr></table>
      </a></li>
      <li onclick="cargarPagina('inscPreli')"><a href="#">
      <table><tr><td><img src="iconos/coor-002.png" /></td><td>Inscripciones Preliminar</td></tr></table>
      </a></li>
      <li onclick="cargarPagina('liga')"><a href="#">
      <table><tr><td><img src="iconos/coor-005.png" /></td><td>Gestor de Ligas</td></tr></table>
      </a></li>
      <li onclick="cargarPagina('entrenador')"><a href="#">
      <table><tr><td><img src="iconos/coor-003.png" /></td><td>Gestor de Entrenadores</td></tr></table>
      </a></li>
      <li onclick="cargarPagina('atleta')"><a href="#">
      <table><tr><td><img src="iconos/coor-009.png" /></td><td>Gestor de Atletas</td></tr></table>
      </a></li>
      <li><a href="#">
      <table><tr><td><img src="iconos/coor-006.png" /></td><td>Gestor de Reportes</td></tr></table>
      </a></li>
      <li onclick="cargarPagina('categoria')"><a href="#">
      <table><tr><td><img src="iconos/coor-000.png" /></td><td>Gestor de Categorias</td></tr></table>
      </a></li>
      <li onclick="cargarPagina('juez')"><a href="#">
      <table><tr><td><img src="iconos/coor-000.png" /></td><td>Gestor de Juez</td></tr></table>
      </a></li>
      <li onclick="cargarPagina('tipoJuez')"><a href="#">
      <table><tr><td><img src="iconos/coor-000.png" /></td><td>Gestor de Tipo de Juez</td></tr></table>
      </a></li>
    </ul>
 </div>
  <div class="content">
  <table width="550" align="CENTER"><tr>
  <td>
  <div style="border-radius: 15px; border:#CCC dotted 0px; background-color:#FFF; width:200px; height:92px;">
  <img src="iconos/logo_fedepesas.png" height="92" />
  </div>
  </td>
  <td>
  <div style="border-radius: 15px; border:#CCC dotted 0px; background-color:#FFF; width:340px; height:92px;">
  <img src="iconos/Horizontal.png" height="92" />
  </div>
  </td>
  </tr></table>
    <div id="contenido">
      <h1>Introducci&oacute;n</h1>
      <p align="justify">La Federación Colombiana de Levantamiento de Pesas (FCLP), ha estructurado su proceso de sistematización de todo lo concerniente a la planificación, difusión, ejecución y  control de las competencias de levantamiento de pesas en sus diferentes categorías de edades, cumpliendo con las normas que plantea la Federación Internacional de levantamiento de Pesas (IWF),  a través de sus reglas y reglamento técnico de competencia.</p>
      <p align="justify">Este desarrollo tecnológico mediante la construido de los software y hardware y la pagina web implementado por la federación colombiana de levantamiento de pesas permitirá,  transmitir en vivo todos sus eventos, con el fin de difundir y acercar a los seguidores de esta disciplina sin importar el sitio donde se esté desarrollando el evento.</p>
      <p align="justify">Con todas estas herramientas, se espera ser más eficiente en el manejo de la información, asimismo poder mostrar con objetividad e inmediatez a las ligas e instituciones deportivas del país, ubicándonos en la vanguardia en el uso de las tecnologías además de los logros deportivos.
    </div>
</p>
	</div>
  <div class="footer">
    <p>Autores:</p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
</html>
