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
        ediarAtleta(rowData);
    }
    if(operation == "EL"){
        var nom = "";
        if(rowData){
            if(rowData.nombre){
                nom = rowData.nombre;
            }
        }

        // confirm dialog
        alertify.confirm("Eliminar el atleta "+nom+"?", function (e) {
            if (e) {
                eliminarMaestro("atleta",rowId,function(data){
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
        nuvoAtleta();
    }
    select.find("option[value='select']").attr("selected","selected");
}

//mostar el formulario para agregar un nuevo registro
function nuvoAtleta(){        
    $(".modal-title").html("Nuevo atleta");    
    $('#formAtleta').modal('show');
}

//editar 
function ediarAtleta(rowData){ 
    var codigo = "";
    var identificacion = "";
    var nombre1 = "";
    var nombre2 = "";
    var apellido1 = "";
    var apellido2 = "";
    var fechaNacim = "";
    var peso = "";
    var genero = "";
    var liga = "";
    var categoria = "";
    var entrenador = "";
    dataForm = {};
    if(rowData){
        if(rowData.id){
            $(".modal-title").html("Editar atleta");
            console.log("rowData");
            console.log(rowData);
            codigo = rowData.id;  
            dataForm.codigo = codigo;
            if(rowData.identificacion){
                identificacion = rowData.identificacion;
            }
            if(rowData.nombre1){
                nombre1 = rowData.nombre1;
            }
            if(rowData.nombre2){
                nombre2 = rowData.nombre2;
            }
            if(rowData.apellido1){
                apellido1 = rowData.apellido1;
            }
            if(rowData.apellido2){
                apellido2 = rowData.apellido2;
            }
            if(rowData.fechaNacim){
                fechaNacim = rowData.fechaNacim;
            }
            if(rowData.peso){
                peso = rowData.peso;
            }
            if(rowData.genero){
                genero = rowData.genero;
            }
            if(rowData.categoria){
                categoria = rowData.categoria;
            }
            if(rowData.entrenador){
                entrenador = rowData.entrenador;
            }
            if(rowData.liga){
                liga = rowData.liga;
            } 
            

            var objIdentificacion = $("#textIdentificacion");
            var objNombre1 = $("#textNombre1");
            var objNombre2 = $("#textNombre2");
            var objApellido1 = $("#textApellido1");
            var objApellido2 = $("#textApellido2");
            var objFechaNacimi = $("#textFechaNacimiento");
            var objGenero = $("#selectGenero");
            var objPeso = $("#textPeso");
            var objCategoria = $("#selectCategoria");
            var objEntrenador = $("#selectEntrenador");
            var objLiga = $("#selectLiga");

            objIdentificacion.val(identificacion); 
            objNombre1.val(nombre1); 
            objNombre2.val(nombre2); 
            objApellido1.val(apellido1); 
            objApellido2.val(apellido2); 
            objFechaNacimi.val(fechaNacim); 
            objPeso.val(peso); 

            if(genero != ""){
                objGenero.find("option").each(function() {
                   if($(this).val() == genero){
                        objGenero.find("option[value='"+$(this).val()+"']").attr("selected","selected"); 
                   }
                });  
            }
            if(liga != ""){
                objLiga.find("option").each(function() {
                   if($(this).text() == liga){
                        objLiga.find("option[value="+$(this).val()+"]").attr("selected","selected"); 
                   }
                });  
            }
            if(categoria != ""){
                objCategoria.find("option").each(function() {
                   if($(this).text() == categoria){
                        objCategoria.find("option[value="+$(this).val()+"]").attr("selected","selected"); 
                   }
                });  
            }
            if(entrenador != ""){
                objEntrenador.find("option").each(function() {
                   if($(this).text() == entrenador){
                        objEntrenador.find("option[value="+$(this).val()+"]").attr("selected","selected"); 
                   }
                });  
            }



            //objGenero.find("option[value='select']").attr("selected","selected");
            //objLiga.find("option[value='select']").attr("selected","selected");
            $('#formAtleta').modal('show');
        }
    }
}

function guardar(){    
    if(validarForm()){
        guardarMaestro("atleta",dataForm,function(data){
            if(data.guardado){
                if(data.guardado == "OK"){                            
                    $('#formAtleta').modal('hide');
                    reloadGrilla();
                }
            }
            if(data.editado){
                if(data.editado == "OK"){
                    $('#formAtleta').modal('hide');
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
    
    var objIdentificacion = $("#textIdentificacion");
    var objNombre1 = $("#textNombre1");
    var objNombre2 = $("#textNombre2");
    var objApellido1 = $("#textApellido1");
    var objApellido2 = $("#textApellido2");
    var objFechaNacimi = $("#textFechaNacimiento");
    var objGenero = $("#selectGenero");
    var objPeso = $("#textPeso");

    var objCategoria = $("#selectCategoria");
    var objEntrenador = $("#selectEntrenador");
    var objLiga = $("#selectLiga");

    var textidenti = objIdentificacion.val(); 
    var textNombre1 = objNombre1.val(); 
    var textNombre2 = objNombre2.val(); 
    var textApellido1 = objApellido1.val(); 
    var textApellido2 = objApellido2.val(); 
    var textFechaNac = objFechaNacimi.val(); 
    var selectGenero = objGenero.val(); 
    var textPeso = objPeso.val();
    var selectCategoria = objCategoria.val(); 
    var selectEntrenador = objEntrenador.val(); 
    var selectLiga = objLiga.val(); 

    if($.trim(textidenti) == ""){
        esValido = false;
        objIdentificacion.popover('show');
        objIdentificacion.focus(function () {
            objIdentificacion.popover('destroy');
        });
    }else{
        dataForm.identificacion = textidenti;
    }

    if($.trim(textNombre1) == ""){
        esValido = false;
        objNombre1.popover('show');
        objNombre1.focus(function () {
            objNombre1.popover('destroy');
        });
    }else{
        dataForm.nombre1 = textNombre1;
    }

    if($.trim(textNombre2) == ""){
        /*esValido = false;
        objNombre2.popover('show');
        objNombre2.focus(function () {
            objNombre2.popover('destroy');
        });*/
    }else{
        dataForm.nombre2 = textNombre2;
    }

    if($.trim(textApellido1) == ""){
        esValido = false;
        objApellido1.popover('show');
        objApellido1.focus(function () {
            objApellido1.popover('destroy');
        });
    }else{
        dataForm.apellido1 = textApellido1;
    }

    if($.trim(textApellido2) == ""){
        /*esValido = false;
        objApellido2.popover('show');
        objApellido2.focus(function () {
            objApellido2.popover('destroy');
        });*/
    }else{
        dataForm.apellido2 = textApellido2;
    }

    if($.trim(textFechaNac) == ""){
       /* esValido = false;
        objFechaNacimi.popover('show');
        objFechaNacimi.focus(function () {
            objFechaNacimi.popover('destroy');
        });*/
    }else{
        dataForm.fechaNacim = textFechaNac;
    }

    if($.trim(selectGenero) == "select"){
        esValido = false;
        objGenero.popover('show');
        objGenero.focus(function () {
            objGenero.popover('destroy');
        });
    }else{
        dataForm.genero = selectGenero;
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

    if($.trim(selectEntrenador) == "select"){
        esValido = false;
        objEntrenador.popover('show');
        objEntrenador.focus(function () {
            objEntrenador.popover('destroy');
        });
    }else{
        dataForm.entrenador = selectEntrenador;
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
 
    var objIdentificacion = $("#textIdentificacion");
    var objNombre1 = $("#textNombre1");
    var objNombre2 = $("#textNombre2");
    var objApellido1 = $("#textApellido1");
    var objApellido2 = $("#textApellido2");
    var objFechaNacimi = $("#textFechaNacimiento");
    var objGenero = $("#selectGenero");
    var objPeso = $("#textPeso");

    var objCategoria = $("#selectCategoria");
    var objEntrenador = $("#selectEntrenador");
    var objLiga = $("#selectLiga");

    objIdentificacion.val(""); 
    objNombre1.val(""); 
    objNombre2.val(""); 
    objApellido1.val(""); 
    objApellido2.val(""); 
    objFechaNacimi.val(""); 
    objPeso.val(""); 
    objGenero.find("option[value='select']").attr("selected","selected");
    objCategoria.find("option[value='select']").attr("selected","selected");
    objEntrenador.find("option[value='select']").attr("selected","selected");
    objLiga.find("option[value='select']").attr("selected","selected");
}

function reloadGrilla(){
    $("#grilla").trigger("reloadGrid");
}
       
$(function() {
    
    $("#grilla").jqGrid({
        url:'web/maestros/controlador/controladorAtleta.php?operacion=listar',
        datatype: "json",
        colNames:['No','identificación','Nombre','Fecha nacimiento','Peso','Género','Categoria','Liga','Entrenador','nombre1','nombre2','apellido1','apellido2','Operaciones'],
        colModel:[
            {name:'id',index:'codigo',hidden:true,key:true, width:1},
            {name:'identificacion',index:'identificacion', width:100},
            {name:'nombre',index:'nombre', width:150},
            {name:'fechaNacim',index:'fechaNacim', width:90},
            {name:'peso',index:'peso', width:60},
            {name:'genero',index:'genero', width:70},
            {name:'categoria',index:'categoria', width:80},
            {name:'liga',index:'liga', width:60},
            {name:'entrenador',index:'entrenador', width:100},
            {name:'nombre1',index:'nombre1',hidden:true, width:1},
            {name:'nombre2',index:'nombre2',hidden:true, width:1},
            {name:'apellido1',index:'apellido1',hidden:true, width:1},
            {name:'apellido2',index:'apellido2',hidden:true, width:1},
            {name: 'operaciones',search:false, sortable:false,width: 130,formatter: getTagCellContents},             
        ],
        rowNum:10,
        rowList:[10,20,30],
        pager: '#pager2',
        sortname: 'nombre',
        viewrecords: true,
        sortorder: "desc",
        //caption:"",
        height: "330",
        autowidth:true
    });
    
    $("#grilla")
        .jqGrid('navGrid','#pager2',{edit:false,add:false,del:false,search:false})
        .navButtonAdd('#pager2',{
        caption:"Nuevo", 
        buttonicon:"ui-icon ui-icon-plus",                 
        onClickButton: function(){ 
            nuvoAtleta();
        }, 
        position:"last"
    });

    $("#grilla").jqGrid('filterToolbar', { searchOnEnter: true, enableClear: false });
    $("[data-toggle='tooltip']").tooltip();
    $('[data-toggle="popover"]').popover();
    
    cargarLigas($("#selectLiga"));
    cargarCategorias($("#selectCategoria"));
    cargarEntrenadores($("#selectEntrenador"));


    $('#formAtleta').on('hide.bs.modal', function (e) {
        var objIdentificacion = $("#textIdentificacion");
        var objNombre1 = $("#textNombre1");
        var objNombre2 = $("#textNombre2");
        var objApellido1 = $("#textApellido1");
        var objApellido2 = $("#textApellido2");
        var objFechaNacimi = $("#textFechaNacimiento");
        var objGenero = $("#selectGenero");
        var objPeso = $("#textPeso");

        var objCategoria = $("#selectCategoria");
        var objEntrenador = $("#selectEntrenador");
        var objLiga = $("#selectLiga");

        objIdentificacion.popover('destroy');
        objNombre1.popover('destroy');
        objNombre2.popover('destroy');
        objApellido1.popover('destroy');
        objApellido2.popover('destroy');
        objFechaNacimi.popover('destroy');
        objPeso.popover('destroy');
        objGenero.popover('destroy');
        objCategoria.popover('destroy');
        objEntrenador.popover('destroy');
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