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
        ediarEvento(rowData);
    }
    if(operation == "EL"){
        var nom = "";
        if(rowData){
            if(rowData.nombre){
                nom = rowData.nombre;
            }
        }

        // confirm dialog
        alertify.confirm("Eliminar evento "+nom+"?", function (e) {
            if (e) {
                eliminarMaestro("evento",rowId,function(data){
                    if(data.eliminado == "OK"){
                        $("#grilla").trigger("reloadGrid");
                        reloadGrilla();
                    }
                });
            } else {
                //alert("cancelar");
            }
        });
    }
    if(operation == "N"){
        nuvoEvento();
    }
    select.find("option[value='select']").attr("selected","selected");
}

//mostar el formulario para agregar un nuevo registro
function nuvoEvento(){        
    $(".modal-title").html("Nuevo evento");    
    $('#formEvento').modal('show');
}

//editar una liga
function ediarEvento(rowData){ 
    var codigo = "";
    var nombre = "";
    var fechaEvento = "";
    var lugar = "";
    console.log("rowData");
    console.log(rowData);
    dataForm = {};
    if(rowData){ 

        if(rowData.id){

            $(".modal-title").html("Editar evento");

            codigo = rowData.id;  
            dataForm.codigo = codigo;
            if(rowData.nombre){
                nombre = rowData.nombre;
            } 
            if(rowData.fechaEvento){
                fechaEvento = rowData.fechaEvento;                        
            }
            if(rowData.lugar){
                lugar = rowData.lugar;                        
            }

            var objNombre = $("#textNombre");
            var objFecha = $("#textFechaEvento");
            var objLugar = $("#textLugar");

            objNombre.val(nombre); 
            objFecha.val(fechaEvento); 
            objLugar.val(lugar); 
            $('#formEvento').modal('show');
        }
    }
}

function guardar(){
    
    if(validarForm()){
        guardarMaestro("evento",dataForm,function(data){
            if(data.guardado){
                if(data.guardado == "OK"){                            
                    $('#formEvento').modal('hide');
                    reloadGrilla();
                }
            }
            if(data.editado){
                if(data.editado == "OK"){
                    $('#formEvento').modal('hide');
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
    
    var objNombre = $("#textNombre");
    var objFecha = $("#textFechaEvento");
    var objLugar = $("#textLugar");

    var textNombre = objNombre.val(); 
    var textFecha = objFecha.val(); 
    var textLugar = objLugar.val(); 

    if($.trim(textNombre) == ""){
        esValido = false;
        objNombre.popover('show');
        objNombre.focus(function () {
            objNombre.popover('destroy');
        });
    }else{
        dataForm.nombre = textNombre;
    }

    if($.trim(textFecha) == ""){
        esValido = false;
        objFecha.popover('show');
        objFecha.focus(function () {
            objFecha.popover('destroy');
        });
    }else{
        dataForm.fechaEvento = textFecha;
    }

    if($.trim(textLugar) == ""){
        esValido = false;
        objLugar.popover('show');
        objLugar.focus(function () {
            objLugar.popover('destroy');
        });
    }else{
        dataForm.lugar = textLugar;
    }

    return esValido;
}

function limpiarForm(){

    var objNombre = $("#textNombre");
    var objFecha = $("#textFechaEvento");
    var objLugar = $("#textLugar");

    objNombre.val(""); 
    objFecha.val(""); 
    objLugar.val(""); 
}

function reloadGrilla(){
    $("#grilla").trigger("reloadGrid");
}
       
$(function() {
    $('#formEvento').on('hidden.bs.modal', function (e) {
        limpiarForm();              
    });
    $("#grilla").jqGrid({
        url:'web/maestros/controlador/controladorEvento.php?operacion=listar',
        datatype: "json",
        colNames:['No','Nombre','Fecha','Lugar',"Operaciones"],
        colModel:[
            {name:'id',index:'codigo',hidden:true,key:true, width:1},
            {name:'nombre',index:'nombre', width:150},
            {name:'fechaEvento',index:'fechaEvento', width:120}, 
            {name:'lugar', width:300,sortable:false},
            {name: 'operaciones',search:false, sortable:false,width: 120,formatter: getTagCellContents}
            /*{name:'total',index:'total', width:80,align:"right"},       
            {name:'note',index:'note', width:150, sortable:false}   */    
        ],
        rowNum:10,
        rowList:[10,20,30],
        pager: '#pager2',
        sortname: 'nombre',
        viewrecords: true,
        sortorder: "desc",
        //caption:"LIGAS",
        height: "330",
    });
    
    $("#grilla")
        .jqGrid('navGrid','#pager2',{edit:false,add:false,del:false,search:false})
        .navButtonAdd('#pager2',{
        caption:"Nuevo", 
        buttonicon:"ui-icon ui-icon-plus",                 
        onClickButton: function(){ 
            nuvoEvento();
        }, 
        position:"last"
    });

    $("#grilla").jqGrid('filterToolbar', { searchOnEnter: true, enableClear: false });
    $("[data-toggle='tooltip']").tooltip();
    $('[data-toggle="popover"]').popover();

    $('#formEvento').on('hide.bs.modal', function (e) {

        var objNombre = $("#textNombre");
        var objFecha = $("#textFechaEvento");
        var objLugar = $("#textLugar");
        objNombre.popover('destroy');
        objFecha.popover('destroy');
        objLugar.popover('destroy');
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
    $('#textFechaEvento').datepicker({"dateFormat":"yy-mm-dd",changeMonth: true,changeYear: true });
});