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
        ediarCategoria(rowData);
    }
    if(operation == "EL"){
        var nom = "";
        if(rowData){
            if(rowData.nombre){
                nom = rowData.nombre;
            }
        }
        
        // confirm dialog
        alertify.confirm("Eliminar categoria "+nom+"?", function (e) {
            if (e) {
                eliminarMaestro("categoria",rowId,function(data){
                    if(data.eliminado == "OK"){
                        //$("#grilla").trigger("reloadGrid");
                        reloadGrilla();
                    }
                });
            } else {
                //alert("cancelar");
            }
        });


    }
    if(operation == "N"){
        nuvoCategoria();
    }
    select.find("option[value='select']").attr("selected","selected");
}

//mostar el formulario para agregar un nuevo registro
function nuvoCategoria(){    
    $(".modal-title").html("Nuevo categoria"); 
    $("#selectRamas").find("option[value='select']").attr("selected","selected");       
    $('#formCategoria').modal('show');
}

//editar una liga
function ediarCategoria(rowData){ 
    var codigo = "";
    var nombre = "";
    var peso = "";
    var rama = "";
    dataForm = {};
    console.log("rowData");
    console.log(rowData);
    if(rowData){     
        if(rowData.id){
            $(".modal-title").html("Editar categoria");
            codigo = rowData.id;  
            dataForm.codigo = codigo;
            if(rowData.nombre){
                nombre = rowData.nombre;
            } 
            if(rowData.peso){
                peso = rowData.peso;                        
            }
            if(rowData.rama){
                rama = rowData.rama;                        
            }

            var objNombre = $("#textNombre");
            var objPeso = $("#textPeso");
            var objRama = $("#selectRamas");

            objNombre.val(nombre); 
            objPeso.val(peso);
            if(rama != ""){
                console.log("objRama");
                console.log(objRama);
                objRama.find("option").each(function() {
                   if($(this).text() == rama){
                        objRama.find("option[value='"+$(this).val()+"']").attr("selected","selected"); 
                   }
                });  
            } 
            $('#formCategoria').modal('show');
        }
    }
}

function guardar(){
    
    if(validarForm()){
        guardarMaestro("categoria",dataForm,function(data){
            if(data.guardado){
                if(data.guardado == "OK"){                            
                    $('#formCategoria').modal('hide');
                    reloadGrilla();
                }
            }
            if(data.editado){
                if(data.editado == "OK"){
                    $('#formCategoria').modal('hide');
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
    var objPeso = $("#textPeso");
    var objRama = $("#selectRamas");

    var textNombre = objNombre.val(); 
    var textPeso = objPeso.val(); 
    var selectRama = objRama.val(); 

    if($.trim(textNombre) == ""){
        esValido = false;
        objNombre.popover('show');
        objNombre.focus(function () {
            objNombre.popover('destroy');
        });
    }else{
        dataForm.nombre = textNombre;
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

    if($.trim(selectRama) == "select"){
        esValido = false;
        dataForm.rama = "";
        objRama.popover('show');
        objRama.focus(function () {
            objRama.popover('destroy');
        });
    }else{
        dataForm.rama = selectRama;
    }

    return esValido;
}

function limpiarForm(){
    var objNombre = $("#textNombre");
    var objPeso = $("#textPeso");
    var objRama = $("#selectRamas");

    objNombre.val(""); 
    objPeso.val(""); 
    objRama.val(""); 
}

function reloadGrilla(){
    $("#grilla").trigger("reloadGrid");
}
       
$(function() {
    $('#formCategoria').on('hidden.bs.modal', function (e) {
        limpiarForm();              
    });
    $("#grilla").jqGrid({
        url:'web/maestros/controlador/controladorCategoria.php?operacion=listar',
        datatype: "json",
        colNames:['No','Nombre','Peso','Rama',"Operaciones"],
        colModel:[
            {name:'id',index:'codigo',hidden:true,key:true, width:1},
            {name:'nombre',index:'nombre', width:200},
            {name:'peso',index:'peso', width:170}, 
            {name:'rama', width:200,sortable:false},
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
       // caption:"CATEGORIAS",
        height: "330",
    });
    
    $("#grilla")
        .jqGrid('navGrid','#pager2',{edit:false,add:false,del:false,search:false})
        .navButtonAdd('#pager2',{
        caption:"Nuevo", 
        buttonicon:"ui-icon ui-icon-plus",                 
        onClickButton: function(){ 
            nuvoCategoria();
        }, 
        position:"last"
    });

    $("#grilla").jqGrid('filterToolbar', { searchOnEnter: true, enableClear: false });
    cargarRamas($("#selectRamas"));

     $("[data-toggle='tooltip']").tooltip();
        $('[data-toggle="popover"]').popover();

        $('#formCategoria').on('hide.bs.modal', function (e) {
            var objNombre = $("#textNombre");
            var objPeso = $("#textPeso");
            var objRama = $("#selectRamas");

            objNombre.popover('destroy');
            objPeso.popover('destroy');
            objRama.popover('destroy');
        });
});

