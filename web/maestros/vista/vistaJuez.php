<?php
session_start();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Fedepesas</title>
    <script src="web/maestros/js/maestroJuez.js" type="text/javascript"></script>    
</head>

<body class="fuente">
   <div id="principal" align="center">
        <div id="cuerpo">
            <div style="font-size:150%;padding:20px"><h3>Gestor de jueces </h3></div>
            <table id = "grilla"></table>
            <div id="pager2"></div>
        </div> 
    </div>

    <div id="formJuez" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Nuevo juez</h4>
                </div>
                <div class="modal-body">
                    <div style="padding-bottom: 10px;">
                        <label style="width: 150px">Identificación:<span style="color:red">*</span></label><input id="textIdentificacion"  type="text" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio.">
                    </div>
                    <div style="padding-bottom: 10px;">
                        <label style="width: 150px" >Primer Nombre:<span style="color:red">*</span></label><input id="textNombre1"  type="text" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio.">
                    </div>
                    <div style="padding-bottom: 10px;">
                        <label style="width: 150px">Segundo Nombre:</label><input id="textNombre2"  type="text" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio.">
                    </div>
                    <div style="padding-bottom: 10px;">
                        <label style="width: 150px">Primer Apellido:<span style="color:red">*</span></label><input id="textApellido1"  type="text" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio.">
                    </div>
                    <div style="padding-bottom: 10px;">
                        <label style="width: 150px">Segundo Apellido:</label><input id="textApellido2"  type="text" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio.">
                    </div>                    
                    <div style="padding-bottom: 10px;">
                        <label style="width: 150px">Fecha nacimiento:</label><input id="textFechaNacimiento"  type="text" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio.">
                    </div>
                    <div style="padding-bottom: 10px;">
                        <label style="width: 150px">Género:<span style="color:red">*</span></label><select id="selectGenero" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio."><option value="select">Seleccionar..</option><option value="M">Masculino</option><option value="F">Femenino</option></select>
                    </div>
                    <div style="padding-bottom: 10px;">
                        <label style="width: 150px">Tipo juez:<span style="color:red">*</span></label><select id="selectTipoJuez" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio."></select>
                    </div>           

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button onclick="guardar();" type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</body>
</html>