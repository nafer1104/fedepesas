<?php
session_start();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Fedepesas</title>
    <script src="web/maestros/js/maestroLiga.js" type="text/javascript"></script>    
</head>

<body class="fuente">
   <div id="principal" align="center">
        <div id="cuerpo">
            <div style="padding:20px"><h3>Gestor Ligas</h3></div>
            <table id = "grilla"></table>
            <div id="pager2"></div>
        </div>
         
    </div>

    <div id="formLiga" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Nueva liga</h4>
                </div>
                <div class="modal-body">
                    <div style="padding-bottom: 10px;">
                        <label>Nombre:<span style="color:red">*</span></label><input id="textNombre"  type="text" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio.">
                    </div>
                    <div style="padding-bottom: 10px;">
                        <label >Abreviatura:<span style="color:red">*</span></label><input id="textAbreviatura"  type="text" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio.">
                    </div>
                    <div>
                        <label >Descripción:</label><textarea id="textDescripcion"  style="width:250px;" class="form-control"></textarea>
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