//Variable para lamacenar la informacin que se envia al servidor al
//momento de guardar o actualizar.
var dataForm = {};

//esta función la ejecuta la grilla por cada registro que tenga, esto para crear
//la lista de operaciones que se puede hacer con el registro.
function getTagCellContents(a,objRow,data) {
    return "<select id=selectOpe_"+objRow.rowId+"  onchange='operaciones("+objRow.rowId+")'>"+
               "<option value='select'>Seleccionar..</option>"+
               "<option value='E'>Editar</option>"+
               "<option value='EL'>Eliminar</option>"+
           "</select>";
}

//Esta función se ejecuta cada que se selecciona un el select de cualquier fila
//según la opción escogida se hace una operacion actualizar,eliminar...
function operaciones(rowId){
    var select = $("#selectOpe_"+rowId);
    var operation = select.val(); 
    var rowData = $('#grilla').jqGrid ('getRowData', rowId);
    if(operation == "E"){                 
        ediarIncrPrelim(rowData);
    }
    if(operation == "EL"){
        var nom = "";
        if(rowData){
            if(rowData.nombre){
                nom = rowData.nombre;
            }
        }

        // confirm dialog
        alertify.confirm("Eliminar atleta "+nom+" del evento?", function (e) {
            if (e) {
                eliminarMaestro("inscPrelimi",rowId,function(data){
                    if(data.eliminado == "OK"){
                        reloadGrilla();
                    }
                });
            } else {
                //alert("cancelar");
            }
        });
    }
    if(operation == "N"){
        nuvoInscPreli();
    }
    select.find("option[value='select']").attr("selected","selected");
}

//mostar el formulario para agregar un nueva registro
function nuvoInscPreli(){        
    $(".modal-title").html("Nueva incripción");    
    $('#formIncPreliminar').modal('show');
}

//editar 
function ediarIncrPrelim(rowData){ 
    var codigo = "";
    var codEvento = "";
    var codAtleta = "";
    var peso = "";
    var codLiga = "";
    var codCategoria = "";

    dataForm = {};
    if(rowData){
        if(rowData.id){
            $(".modal-title").html("Editar incripción");

            console.log("rowData");
            console.log(rowData);

            codigo = rowData.id;  
            dataForm.codigo = codigo;
            

            if(rowData.codEvento){
                codEvento = rowData.codEvento;
            }
            if(rowData.peso){
                peso = rowData.peso;
            }
            if(rowData.codAtleta){
                codAtleta = rowData.codAtleta;
            }

            if(rowData.codLiga){
                codLiga = rowData.codLiga;
            }

            if(rowData.codCategoria){
                codCategoria = rowData.codCategoria;
            } 
            
            var objEvento = $("#selectEvento");
            var objAtleta = $("#selectAtleta");
            var objCategoria = $("#selectCategoria");
            var objPeso = $("#textPeso");
            var objLiga = $("#selectLiga");

            objPeso.val(peso);
            objEvento.find("option[value="+codEvento+"]").attr("selected","selected");
            objAtleta.find("option[value="+codAtleta+"]").attr("selected","selected");
            objCategoria.find("option[value="+codCategoria+"]").attr("selected","selected");
            objLiga.find("option[value="+codLiga+"]").attr("selected","selected");

            $('#formIncPreliminar').modal('show');
        }
    }
}

function guardar(){    
    if(validarForm()){
        guardarMaestro("inscPrelimi",dataForm,function(data){
            if(data.guardado){
                if(data.guardado == "OK"){                            
                    $('#formIncPreliminar').modal('hide');
                    reloadGrilla();
                }
            }
            if(data.editado){
                if(data.editado == "OK"){
                    $('#formIncPreliminar').modal('hide');
                    reloadGrilla();
                }
            }
        }
        );
        dataForm = {};
    }
    
}

// validar el formulario
function validarForm(){
    var esValido = true;
    
    var objEvento = $("#selectEvento");
    var objAtleta = $("#selectAtleta");
    var objCategoria = $("#selectCategoria");
    var objPeso = $("#textPeso");
    var objLiga = $("#selectLiga");

    var selectEvento = objEvento.val();
    var selectAtleta = objAtleta.val();
    var selectCategoria = objCategoria.val();
    var textPeso = objPeso.val();
    var selectLiga = objLiga.val();

    if($.trim(selectEvento) == "select"){
        esValido = false;
        objEvento.popover('show');
        objEvento.focus(function () {
            objEvento.popover('destroy');
        });
    }else{
        dataForm.evento = selectEvento;
    }

    if($.trim(selectAtleta) == "select"){
        esValido = false;
        objAtleta.popover('show');
        objAtleta.focus(function () {
            objAtleta.popover('destroy');
        });
    }else{
        dataForm.atleta = selectAtleta;
    }

    if($.trim(selectCategoria) == "select"){
        esValido = false;
        objCategoria.popover('show');
        objCategoria.focus(function () {
            objCategoria.popover('destroy');
        });
    }else{
        dataForm.categoria = selectCategoria;
    }

    if($.trim(textPeso) == ""){
        esValido = false;
        objPeso.popover('show');
        objPeso.focus(function () {
            objPeso.popover('destroy');
        });
    }else{
        dataForm.peso = textPeso;
    }

    if($.trim(selectLiga) == "select"){
        esValido = false;
        objLiga.popover('show');
        objLiga.focus(function () {
            objLiga.popover('destroy');
        });
    }else{
        dataForm.liga = selectLiga;
    }

    return esValido;
}

function limpiarForm(){
 
    var objEvento = $("#selectEvento");
    var objAtleta = $("#selectAtleta");
    var objCategoria = $("#selectCategoria");
    var objPeso = $("#textPeso");
    var objLiga = $("#selectLiga");

    objEvento.find("option[value='select']").attr("selected","selected");
    objAtleta.find("option[value='select']").attr("selected","selected");
    objCategoria.find("option[value='select']").attr("selected","selected");
    objPeso.val("");
    objLiga.find("option[value='select']").attr("selected","selected");
}

function reloadGrilla(){
    $("#grilla").trigger("reloadGrid");
}
       
$(function() {
    
    $("#grilla").jqGrid({
        url:'web/maestros/controlador/controladorIncPreliminar.php?operacion=listar',
        datatype: "json",
        colNames:['No','Evento','Atleta','Peso','Liga','Categoria','codEvento','codAtleta','codLiga','codCategoria','Operaciones'],
        colModel:[
            {name:'id',index:'codigo',hidden:true,key:true, width:1},
            {name:'evento',index:'evento', width:150},            
            {name:'atleta',index:'atleta', width:150},
            {name:'peso',index:'peso', width:100},
            {name:'liga',index:'liga', width:70},
            {name:'categoria',index:'categoria', width:100},

            {name:'codEvento',index:'codEvento',hidden:true, width:1},
            {name:'codAtleta',index:'codAtleta',hidden:true, width:1},
            {name:'codLiga',index:'codLiga',hidden:true, width:1},
            {name:'codCategoria',index:'codCategoria',hidden:true, width:1},            
            {name:'operaciones',search:false, sortable:false,width: 120,formatter: getTagCellContents},             
        ],
        rowNum:10,
        rowList:[10,20,30],
        pager: '#pager2',
        sortname: 'evento',
        viewrecords: true,
        sortorder: "desc",
        //caption:"incripción",
        height: "330",
    });
    
    $("#grilla")
        .jqGrid('navGrid','#pager2',{edit:false,add:false,del:false,search:false})
        .navButtonAdd('#pager2',{
        caption:"Nueva", 
        buttonicon:"ui-icon ui-icon-plus",                 
        onClickButton: function(){ 
            nuvoInscPreli();
        }, 
        position:"last"
    });

    $("#grilla").jqGrid('filterToolbar', { searchOnEnter: true, enableClear: false });
    $("[data-toggle='tooltip']").tooltip();
    $('[data-toggle="popover"]').popover();
    
    cargarEventos($("#selectEvento"));
    cargarAtletas($("#selectAtleta"));
    cargarLigas($("#selectLiga"));
    cargarCategorias($("#selectCategoria"));

    $('#formIncPreliminar').on('hide.bs.modal', function (e) {
        var objEvento = $("#selectEvento");
        var objAtleta = $("#selectAtleta");
        var objCategoria = $("#selectCategoria");
        var objPeso = $("#textPeso");
        var objLiga = $("#selectLiga");

        objEvento.popover('destroy');
        objAtleta.popover('destroy');
        objCategoria.popover('destroy');
        objPeso.popover('destroy');
        objLiga.popover('destroy');

        limpiarForm();
    });
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: ' nextText: Sig',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié;', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $('#textFechaNacimiento').datepicker({"dateFormat":"yy-mm-dd",changeMonth: true,changeYear: true });
});