<?php
session_start();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Fedepesas</title>
    <script src="web/maestros/js/maestroCategoria.js" type="text/javascript"></script>    
</head>

<body class="fuente">
   <div id="principal" align="center">
        <div id="cuerpo">
            <div style="font-size:150%;padding:20px"><h3>Gestor Categorias</h3></div>
            <table id = "grilla"></table>
            <div id="pager2"></div>
        </div>    
    </div>

    <div id="formCategoria" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Nueva categoria</h4>
                </div>
                <div class="modal-body">
                    <div style="padding-bottom: 10px;">
                        <label>Nombre:<span style="color:red">*</span></label><input id="textNombre" style="width:250px;" type="text" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio.">
                    </div>
                    <div style="padding-bottom: 10px;">
                        <label >Peso:<span style="color:red">*</span></label><input id="textPeso" style="width:250px;" type="number" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio, valor numérico.">
                    </div>
                    <div>
                        <label >Rama:<span style="color:red">*</span></label><select id="selectRamas" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio."></select>
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