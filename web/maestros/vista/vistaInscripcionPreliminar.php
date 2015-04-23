<?php
session_start();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Fedepesas</title>
    <script src="web/maestros/js/maestroIncPreliminar.js" type="text/javascript"></script>    
</head>

<body class="fuente">
   <div id="principal" align="center">
        <div id="cuerpo">
            <div style="font-size:150%;padding:20px"><h3>Inscripción Preliminar </h3></div>
            <table id = "grilla"></table>
            <div id="pager2"></div>
        </div>
    </div>

    <div id="formIncPreliminar" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Inscripción Preliminar</h4>
                </div>
                <div class="modal-body">
                    <div style="padding-bottom: 10px;">
                        <label style="width: 150px">Evento:<span style="color:red">*</span></label><select id="selectEvento" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio."></select>
                    </div>
                    <div style="padding-bottom: 10px;">
                        <label style="width: 150px">Atleta:<span style="color:red">*</span></label><select id="selectAtleta" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio."></select>
                    </div>
                    <div style="padding-bottom: 10px;">
                        <label style="width: 150px">Peso:</label><input id="textPeso"  type="number" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio. Campo numérico.">
                    </div>
                    <div style="padding-bottom: 10px;">
                        <label style="width: 150px">Liga:<span style="color:red">*</span></label><select id="selectLiga" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio."></select>
                    </div>
                    <div style="padding-bottom: 10px;">
                        <label style="width: 150px">Categoria:<span style="color:red">*</span></label><select id="selectCategoria" class="form-control" data-container="body" data-trigger="focus" data-placement="right" data-content="Campo obligatorio."></select>
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