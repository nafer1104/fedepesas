<?php
session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:...</title>
<link href="../estilos.css" rel="stylesheet">
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
    <br>
            <table class="fuente" cellpadding="2" cellspacing="2">
            <tr>
                <td align="center"><img src="../menu_proy.png" width="50" /></td>
                <td valign="bottom"><h1>Gestor de Proyectos</h1></td>
            </tr>
            </table>
    <div id="capa_form" align="center"><br>
    <table bgcolor="#FFF" class="fuente" cellpadding="1" cellspacing="0">
            <tr>
                <th width="50"><div id="titulo">No.</div></th>
                <th width="200"><div id="titulo">Nombre</div></th>
                <th width="90"><div id="titulo">Periodo</div></th>
                <th width="100"><div id="titulo">Operaciones</div></th>
            </tr>
            <tr>
                <td width="50" align="center">1</td>
                <td width="200">Manos Limpias</td>
                <td width="90" align="center">2014-02</td>
                <td width="100" align="center"><select class="campo">
                <option>Seleccione...</option>
                <option>Editar</option>
                <option>Eliminar</option>
                <option>Actividades</option>
                </select></td>
            </tr>
            <tr>
                <td colspan="4"><hr></td>
            </tr>
            <tr>
                <td width="50" align="center">2</td>
                <td width="200">El cuidado y correcto cepillado de los dientes</td>
                <td width="90" align="center">2014-02</td>
                <td width="100" align="center"><select class="campo">
                <option>Seleccione...</option>
                <option>Editar</option>
                <option>Eliminar</option>
                <option>Actividades</option>
                </select></td>
            </tr>
            <tr>
                <td colspan="4"><hr></td>
            </tr>
            <tr>
                <td width="50" align="center">3</td>
                <td width="200">Sensibilizacion en el ciudado y uso de las herramientas TICS</td>
                <td width="90" align="center">2014-02</td>
                <td width="100" align="center"><select class="campo">
                <option>Seleccione...</option>
                <option>Editar</option>
                <option>Eliminar</option>
                <option>Actividades</option>
                </select></td>
            </tr>
            
            </table><br>
    </div>
    </div>
    <div id="pie" align="center">
    Soportes y Servicios Tecnologicos<br>
    Autor: Joaquin Segundo Silva Romero<br>
    Ingeniero de Sistemas
    </div>
</div>
</body>
</html>