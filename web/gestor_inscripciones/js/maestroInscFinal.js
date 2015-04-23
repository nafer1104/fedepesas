var codEvento = "";
var codCategoria = "";

$(function() {
	inicializar();
});

function inicializar(){

    cargarEventos($("#selectEvento"));
    cargarCategorias($("#selectCategoria"));
    cargarGrillaPreliminar();
    cargarGrillaFinal();
}
function buscarInscritos(){


	var objEvento = $("#selectEvento");
	var objCategoria = $("#selectCategoria");

	codEvento = objEvento.val();
	codCategoria = objCategoria.val();
	var listo = true;
	if($.trim(codEvento) == "select" || $.trim(codEvento) == "" ){
		listo = false;
		objEvento.popover('show');
        objEvento.focus(function () {
            objEvento.popover('destroy');
        });
	}

	if($.trim(codCategoria) == "select" || $.trim(codCategoria) == "" ){
		listo = false;
		objCategoria.popover('show');
        objCategoria.focus(function () {
            objCategoria.popover('destroy');
        });
	}
	if(listo){
		reloadGrillaPre();
		reloadGrillaFinal();
	}
	
}

function cargarGrillaPreliminar(){
	$("#grillaPreliminar").jqGrid({
        url:'web/gestor_inscripciones/controlador/controladorInscFinal.php?operacion=listarPrelimnar&codEvento='+codEvento+"&codCategoria="+codCategoria,
        datatype: "json",
        colNames:['No','Atleta','Peso','Liga','codEvento','codAtleta','codLiga','codCategoria','Final'],
        colModel:[
            {name:'id',index:'codigo',hidden:true,key:true, width:1},
            {name:'atleta',index:'atleta', width:150},
            {name:'peso',index:'peso', width:60},
            {name:'liga',index:'liga', width:70},

            {name:'codEvento',index:'codEvento',hidden:true, width:1},
            {name:'codAtleta',index:'codAtleta',hidden:true, width:1},
            {name:'codLiga',index:'codLiga',hidden:true, width:1},
            {name:'codCategoria',index:'codCategoria',hidden:true, width:1},            
         	{name:'operaciones',search:false, sortable:false,width: 50,formatter: getTagCellPreliminar},             
        ],
        rowNum:10,
        rowList:[10,20,30],
        pager: '#pagerPreliminar',
        sortname: 'atleta',
        viewrecords: true,
        sortorder: "desc",
        //caption:"incripción",
        height: "330",
        beforeRequest:function(data){
        	if(codEvento == "" || codCategoria == ""){
        		return false;
        	}else{
        		var newUrl = 'web/gestor_inscripciones/controlador/controladorInscFinal.php?operacion=listarPrelimnar&codEvento='+codEvento+"&codCategoria="+codCategoria;
        		$("#grillaPreliminar").setGridParam({url:newUrl});
        	}
        
        }
    });
    
    $("#grillaPreliminar")
        .jqGrid('navGrid','#pagerPreliminar',{edit:false,add:false,del:false,search:false});
    $("#grillaPreliminar").jqGrid('filterToolbar', { searchOnEnter: true, enableClear: false });
}
function reloadGrillaPre(){
    $("#grillaPreliminar").trigger("reloadGrid");
}
function cargarGrillaFinal(){
	$("#grillaFinal").jqGrid({
        url:'web/gestor_inscripciones/controlador/controladorInscFinal.php?operacion=listarFinal&codEvento='+codEvento+"&codCategoria="+codCategoria,
        datatype: "json",
        colNames:['No','Preliminar','Atleta','Peso','Liga','codEvento','codAtleta','codLiga','codCategoria'],
        colModel:[
            {name:'id',index:'codigo',hidden:true,key:true, width:1},
        	{name:'operaciones',search:false, sortable:false,width: 50,formatter: getTagCellFinal},            
            {name:'atleta',index:'atleta', width:150},
            {name:'peso',index:'peso', width:60},
            {name:'liga',index:'liga', width:70},

            {name:'codEvento',index:'codEvento',hidden:true, width:1},
            {name:'codAtleta',index:'codAtleta',hidden:true, width:1},
            {name:'codLiga',index:'codLiga',hidden:true, width:1},
            {name:'codCategoria',index:'codCategoria',hidden:true, width:1},            
         	             
        ],
        rowNum:10,
        rowList:[10,20,30],
        pager: '#pagerFinal',
        sortname: 'atleta',
        viewrecords: true,
        sortorder: "desc",
        //caption:"incripción",
        height: "330",
        beforeRequest:function(data){
        	if(codEvento == "" || codCategoria == ""){
        		return false;
        	}else{
        		var newUrl = 'web/gestor_inscripciones/controlador/controladorInscFinal.php?operacion=listarFinal&codEvento='+codEvento+"&codCategoria="+codCategoria;
        		$("#grillaFinal").setGridParam({url:newUrl});
        	}
        }
    });
    
    $("#grillaFinal")
        .jqGrid('navGrid','#pagerFinal',{edit:false,add:false,del:false,search:false});
    $("#grillaFinal").jqGrid('filterToolbar', { searchOnEnter: true, enableClear: false });
}
function reloadGrillaFinal(){
    $("#grillaFinal").trigger("reloadGrid");
}
//esta función la ejecuta la grilla por cada registro que tenga, esto para crear
//la lista de operaciones que se puede hacer con el registro.
function getTagCellPreliminar(a,objRow,data) {
    return '<button onclick="pasarFinal('+objRow.rowId+')" class="btn btn-default" type="button"><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></button>';/*"<select id=selectOpe_"+objRow.rowId+"  onchange='operaciones("+objRow.rowId+")'>"+
               "<option value='select'>Seleccionar..</option>"+
               "<option value='E'>Editar</option>"+
               "<option value='EL'>Eliminar</option>"+
           "</select>"*/;
}

//esta función la ejecuta la grilla por cada registro que tenga, esto para crear
//la lista de operaciones que se puede hacer con el registro.
function getTagCellFinal(a,objRow,data) {
    return '<button onclick="pasarPreliminar('+objRow.rowId+')" class="btn btn-default" type="button"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></button>';/*"<select id=selectOpe_"+objRow.rowId+"  onchange='operaciones("+objRow.rowId+")'>"+
               "<option value='select'>Seleccionar..</option>"+
               "<option value='E'>Editar</option>"+
               "<option value='EL'>Eliminar</option>"+
           "</select>"*/;
}

function pasarFinal(rowId){
	$(this).prop("enabled","enabled")
	var dataForm = {"operacion":"pasarFinal","codigo":rowId};
	$.ajax({
	  	method: "POST",
	  	url: 'web/gestor_inscripciones/controlador/controladorInscFinal.php',
	  	data: dataForm,
	  	success: function(data) {
		  	var objJson = JSON.parse(data);
		  	if(objJson){
		  		if(objJson.guardado){
		  		   if(objJson.guardado == "OK"){
			    		//alert("Registro guardado.");
			    		reloadGrillaPre();
			    		reloadGrillaFinal();

			    		//alertify.success(divMessageGuardado);
	                }
	                if(objJson.guardado == "KO"){
			    		//alert("Registro guardado.");
			    		if(objJson.mensage){
			    			alertify.alert(objJson.mensage);
			    		}
	                }
	            }                
		  	}else{
		  		alertify.alert("Error al guardar.");
		  	}
		}
	});
}

function pasarPreliminar(rowId){
	var dataForm = {"operacion":"pasarPreliminar","codigo":rowId};
	$.ajax({
	  	method: "POST",
	  	url: 'web/gestor_inscripciones/controlador/controladorInscFinal.php',
	  	data: dataForm,
	  	success: function(data) {
		  	var objJson = JSON.parse(data);
		  	if(objJson){
		  		if(objJson.guardado){
		  		   if(objJson.guardado == "OK"){
			    		//alert("Registro guardado.");
			    		reloadGrillaFinal();
			    		reloadGrillaPre();
			    		//alertify.success(divMessageGuardado);
	                }
	                if(objJson.guardado == "KO"){
			    		//alert("Registro guardado.");
			    		if(objJson.mensage){
			    			alertify.alert(objJson.mensage);
			    		}
	                }
	            }                
		  	}else{
		  		alertify.alert("Error al guardar.");
		  	}
		}
	});
}