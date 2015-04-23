<?php
session_start();
$_SESSION["iden_pers"]="73429694";
$_SESSION["nomb_pers"]="JOAQUIN SEGUNDO SILVA ROMERO";
$_SESSION["nomb_prog"]="PROGRAMA DE INGENIERIA DE SISTEMAS";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:...</title>
<link href="estilos.css" rel="stylesheet">
</head>

<body class="fuente">
<div id="principal" align="center">
    <div id="cabecera">
    <table width="100%" height="100%" class="fuente" style="color:#FCFCFC">
    <tr>
    <th align="center" valign="middle" colspan="2"><font color="#FFF" style="font-size:14px">Sistema Para Registro y Control de Proyeccion Social</font></th>
    </tr>
    <tr>
    <td valign="bottom">
    Bienvenido, <?php echo $_SESSION["nomb_pers"]; ?>
    </td>
    <td valign="bottom" align="right">
    <?php echo $_SESSION["nomb_prog"]; ?>
    </td>
    </tr>
    </table>
    </div>
    <div id="cuerpo">
    <br><h1>Menu Principal</h1>
    <table align="center" cellpadding="4" cellspacing="4" class="fuente">
    <tr>
    	<td>
        	<div id="capa_menu">
            <a href="mod_proyectos/">
            <table class="fuente" width="100%" cellpadding="2" cellspacing="2">
            <tr>
                <td align="center"><img id="rueda" src="menu_proy.png" width="80" /></td>
                <td><b>Gestor de Proyectos</b><br><p align="justify" style="color:#808080">
                Permite registrar los proyectos del programa por periodos academicos</p></td>
            </tr>
            </table>
            </a>
            </div>
        </td>
        <td>
            <div id="capa_menu">
            <a href="">
            <table class="fuente" width="100%" cellpadding="2" cellspacing="2">
            <tr>
                <td align="center"><img id="rueda" src="menu_estu.png" width="80" /></td>
                <td><b>Gestor de Estudiantes</b><br><p align="justify" style="color:#808080;">
                Permite registrar, editar estudiantes vinculados a los proyectos</p></td>
            </tr>
            </table>
            </a>
            </div>
        </td>
        <td>
            <div id="capa_menu">
            <a href="">
            <table class="fuente" width="100%" cellpadding="2" cellspacing="2">
            <tr>
                <td align="center"><img id="rueda" src="menu_acti.png" width="80" /></td>
                <td><b>Gestor de Actividades</b><br><p align="justify" style="color:#808080">
                Permite registrar las actividades realizadas por periodos academicos.</p></td>
            </tr>
            </table>
            </a>
            </div>
        </td>
    </tr>
    <tr>
    	<td>
        	<div id="capa_menu">
            <a href="">
            <table class="fuente" width="100%" cellpadding="2" cellspacing="2">
            <tr>
                <td align="center"><img id="rueda" src="menu_revi.png" width="80" /></td>
                <td><b>Asi nos Proyectamos</b><br>
                <p align="justify" style="color:#808080">
                Permite consolidar  en un formato las actividades por periodo.</p></td>
            </tr>
            </table>
            </a>
            </div>
        </td>
        <td>
            <div id="capa_menu">
            <a href="">
            <table class="fuente" width="100%" cellpadding="2" cellspacing="2">
            <tr>
                <td align="center"><img id="rueda" src="menu_esta.png" width="80" /></td>
                <td><b>Reportes y Estadisticas</b><br>
                <p align="justify" style="color:#808080">
                Permite mostrar las estadisticas de las actividades realizadas.</p></td>
            </tr>
            </table>
            </a>
            </div>
        </td>
        <td>
            <div id="capa_menu">
            <a href="">
            <table class="fuente" width="100%" cellpadding="2" cellspacing="2">
            <tr>
                <td align="center"><img id="rueda" src="menu_off.png" width="80" /></td>
                <td><b>Cerrar Sesion</b><br>
                <p align="justify" style="color:#808080">
                Cierra la sesion  y salir de la interfaz actual.</p></td>
            </tr>
            </table>
            </a>
            </div>
        </td>
    </tr>
    </table>
    </div>
    <div id="pie" align="center">
    Soportes y Servicios Tecnologicos<br>
    Autor: Joaquin Segundo Silva Romero<br>
    Ingeniero de Sistemas
    </div>
</div>
</body>
</html>