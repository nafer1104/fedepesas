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
        ediarTipoJuez(rowData);
    }
    if(operation == "EL"){
        var nom = "";
        if(rowData){
            if(rowData.nombre){
                nom = rowData.nombre;
            }
        }

        // confirm dialog
        alertify.confirm("Eliminar el tipo de juez "+nom+"?", function (e) {
            if (e) {
                eliminarMaestro("tipoJuez",rowId,function(data){
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
        nuvoTipoJuez();
    }
    select.find("option[value='select']").attr("selected","selected");
}

//mostar el formulario para agregar un nuevo registro
function nuvoTipoJuez(){        
    $(".modal-title").html("Nuevo tipo juez");    
    $('#formTipoJuez').modal('show');
}

//editar 
function ediarTipoJuez(rowData){ 
    var codigo = "";
    var nombre = "";
    var abrevi = "";
    dataForm = {};
    if(rowData){ 

        if(rowData.id){

            $(".modal-title").html("Editar tipo juez");

            codigo = rowData.id;  
            dataForm.codigo = codigo;
            if(rowData.nombre){
                nombre = rowData.nombre;
            } 
            if(rowData.abreviatura){
                abrevi = rowData.abreviatura;                        
            }            

            var objNombre = $("#textNombre");
            var objAbrevi = $("#textAbreviatura");

            objNombre.val(nombre); 
            objAbrevi.val(abrevi); 
            $('#formTipoJuez').modal('show');
        }
    }
}

function guardar(){
    
    if(validarForm()){
        guardarMaestro("tipoJuez",dataForm,function(data){
            if(data.guardado){
                if(data.guardado == "OK"){                            
                    $('#formTipoJuez').modal('hide');
                    reloadGrilla();
                }
            }
            if(data.editado){
                if(data.editado == "OK"){
                    $('#formTipoJuez').modal('hide');
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

    var textNombre = objNombre.val(); 
    var textAbrevi = objAbrevi.val(); 

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

    return esValido;
}

function limpiarForm(){
    var objNombre = $("#textNombre");
    var objAbrevi = $("#textAbreviatura");

    objNombre.val(""); 
    objAbrevi.val(""); 
}

function reloadGrilla(){
    $("#grilla").trigger("reloadGrid");
}
       
$(function() {
    $('#formTipoJuez').on('hidden.bs.modal', function (e) {
        limpiarForm();              
    });
    $("#grilla").jqGrid({
        url:'web/maestros/controlador/controladorTipoJuez.php?operacion=listar',
        datatype: "json",
        colNames:['No','Nombre','abreviatura',"Operaciones"],
        colModel:[
            {name:'id',index:'codigo',hidden:true,key:true, width:1},
            {name:'nombre',index:'nombre', width:360},
            {name:'abreviatura',index:'abreviatura', width:200}, 
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
        //caption:"TIPO JUEZ",
        height: "330",
    });
    
    $("#grilla")
        .jqGrid('navGrid','#pager2',{edit:false,add:false,del:false,search:false})
        .navButtonAdd('#pager2',{
        caption:"Nuevo", 
        buttonicon:"ui-icon ui-icon-plus",                 
        onClickButton: function(){ 
            nuvoTipoJuez();
        }, 
        position:"last"
    });

    $("#grilla").jqGrid('filterToolbar', { searchOnEnter: true, enableClear: false });
        $("[data-toggle='tooltip']").tooltip();
        $('[data-toggle="popover"]').popover();

        $('#formTipoJuez').on('hide.bs.modal', function (e) {

            var objNombre = $("#textNombre");
            var objAbrevi = $("#textAbreviatura");
            objNombre.popover('destroy');
            objAbrevi.popover('destroy');
        });
});