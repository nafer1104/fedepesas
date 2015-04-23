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
        ediarLiga(rowData);
    }
    if(operation == "EL"){
        var nom = "";
        if(rowData){
            if(rowData.nombre){
                nom = rowData.nombre;
            }
        }

        // confirm dialog
        alertify.confirm("Eliminar liga "+nom+"?", function (e) {
            if (e) {
                eliminarMaestro("liga",rowId,function(data){
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
        nuvoLiga();
    }
    select.find("option[value='select']").attr("selected","selected");
}

//mostar el formulario para agregar un nuevo registro
function nuvoLiga(){        
    $(".modal-title").html("Nuevo liga");    
    $('#formLiga').modal('show');
}

//editar una liga
function ediarLiga(rowData){ 
    var codigo = "";
    var nombre = "";
    var abrevi = "";
    var descri = "";
    dataForm = {};
    if(rowData){ 

        if(rowData.id){

            $(".modal-title").html("Editar liga");

            codigo = rowData.id;  
            dataForm.codigo = codigo;
            if(rowData.nombre){
                nombre = rowData.nombre;
            } 
            if(rowData.abreviatura){
                abrevi = rowData.abreviatura;                        
            }
            if(rowData.descripcion){
                descri = rowData.descripcion;                        
            }

            var objNombre = $("#textNombre");
            var objAbrevi = $("#textAbreviatura");
            var objDescri = $("#textDescripcion");

            objNombre.val(nombre); 
            objAbrevi.val(abrevi); 
            objDescri.val(descri); 
            $('#formLiga').modal('show');
        }
    }
}

function guardar(){
    
    if(validarForm()){
        guardarMaestro("liga",dataForm,function(data){
            if(data.guardado){
                if(data.guardado == "OK"){                            
                    $('#formLiga').modal('hide');
                    reloadGrilla();
                }
            }
            if(data.editado){
                if(data.editado == "OK"){
                    $('#formLiga').modal('hide');
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
    var objAbrevi = $("#textAbreviatura");
    var objDescri = $("#textDescripcion");

    var textNombre = objNombre.val(); 
    var textAbrevi = objAbrevi.val(); 
    var textDescri = objDescri.val(); 

    if($.trim(textNombre) == ""){
        esValido = false;
        objNombre.popover('show');
        objNombre.focus(function () {
            objNombre.popover('destroy');
        });
    }else{
        dataForm.nombre = textNombre;
    }

    if($.trim(textAbrevi) == ""){
        esValido = false;
        objAbrevi.popover('show');
        objAbrevi.focus(function () {
            objAbrevi.popover('destroy');
        });

    }else{
        dataForm.abreviatura = textAbrevi;
    }

    if($.trim(textDescri) == ""){
        //esValido = false;
        dataForm.descripcion = "";
    }else{
        dataForm.descripcion = textDescri;
    }

    return esValido;
}

function limpiarForm(){
    var objNombre = $("#textNombre");
    var objAbrevi = $("#textAbreviatura");
    var objDescri = $("#textDescripcion");

    objNombre.val(""); 
    objAbrevi.val(""); 
    objDescri.val(""); 
}

function reloadGrilla(){
    $("#grilla").trigger("reloadGrid");
}
       
$(function() {
    $('#formLiga').on('hidden.bs.modal', function (e) {
        limpiarForm();              
    });
    $("#grilla").jqGrid({
        url:'web/maestros/controlador/controladorLiga.php?operacion=listar',
        datatype: "json",
        colNames:['No','Nombre','abreviatura','descripción',"Operaciones"],
        colModel:[
            {name:'id',index:'codigo',hidden:true,key:true, width:1},
            {name:'nombre',index:'nombre', width:150},
            {name:'abreviatura',index:'abreviatura', width:120}, 
            {name:'descripcion', width:300,sortable:false},
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
            nuvoLiga();
        }, 
        position:"last"
    });

    $("#grilla").jqGrid('filterToolbar', { searchOnEnter: true, enableClear: false });
        $("[data-toggle='tooltip']").tooltip();
        $('[data-toggle="popover"]').popover();

        $('#formLiga').on('hide.bs.modal', function (e) {

            var objNombre = $("#textNombre");
            var objAbrevi = $("#textAbreviatura");
            var objDescri = $("#textDescripcion");
            objNombre.popover('destroy');
            objAbrevi.popover('destroy');
            objDescri.popover('destroy');
        });
});