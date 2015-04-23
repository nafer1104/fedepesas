<?php
session_start();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Fedepesas</title>
    <script src="web/gestor_inscripciones/js/maestroInscFinal.js" type="text/javascript"></script>    
</head>

<body class="fuente">
   <div id="principal" align="center">
        <div id="cuerpo">
            <div style="font-size:150%;padding:20px"><h3>Inscripción Final </h3></div>

            <table border="0">
                <tr>
                    <td colspan="2" style="padding-bottom: 20px;">   
                    <table>
                        <tr>
                            <td><label style="width: 70px">Evento:<span style="color:red">*</span></label></td>
                            <td> <select id="selectEvento" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio."></select></td>
                            <td style="width: 30px"></td>
                            <td><label style="width: 85px">Categoria:<span style="color:red">*</span></label></td>
                            <td><select id="selectCategoria" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio."></select></td>
                            <td style="width: 30px"></td>
                            <td><button onclick="buscarInscritos();" type="button" class="btn btn-primary">Aceptar</button></td>
                        </tr>
                    </table>                                        
                    <td>
                </tr>
                <tr>
                    <td>
                        <div style='float:left;width:48%' name="gridInscPreliminar">
                            <table id = "grillaPreliminar"></table>
                            <div id="pagerPreliminar"></div>
                        </div>
                    </td>
                    <td>
                        <div name="gridInscFinal" style='float:left;width:48%'>
                            <table id = "grillaFinal"></table>
                            <div id="pagerFinal"></div>
                        </div>  
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>