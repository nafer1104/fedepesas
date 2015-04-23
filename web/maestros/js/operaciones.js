var divMessageGuardado = '<div class="alert alert-success" role="alert">Registro guardado.</div>';
var divMessageEditado = '<div class="alert alert-success" role="alert">Registro editado.</div>';
var divMessageEliminado = '<div class="alert alert-success" role="alert">Registro eliminado.</div>';

var rutas = [
		{
			nombre:"liga",
			ruta:"web/maestros/controlador/controladorLiga.php?operacion=g",
			rutaEl:"web/maestros/controlador/controladorLiga.php?operacion=el&codigo="
		},
		{
			nombre:"categoria",
			ruta:"web/maestros/controlador/controladorCategoria.php?operacion=g",
			rutaEl:"web/maestros/controlador/controladorCategoria.php?operacion=el&codigo="
		},
		{
			nombre:"tipoJuez",
			ruta:"web/maestros/controlador/controladorTipoJuez.php?operacion=g",
			rutaEl:"web/maestros/controlador/controladorTipoJuez.php?operacion=el&codigo="
		},
		{
			nombre:"juez",
			ruta:"web/maestros/controlador/controladorJuez.php?operacion=g",
			rutaEl:"web/maestros/controlador/controladorJuez.php?operacion=el&codigo="
		},
		{
			nombre:"entrenador",
			ruta:"web/maestros/controlador/controladorEntrenador.php?operacion=g",
			rutaEl:"web/maestros/controlador/controladorEntrenador.php?operacion=el&codigo="
		},
		{
			nombre:"atleta",
			ruta:"web/maestros/controlador/controladorAtleta.php?operacion=g",
			rutaEl:"web/maestros/controlador/controladorAtleta.php?operacion=el&codigo="
		},
        {
            nombre:"evento",
            ruta:"web/maestros/controlador/controladorEvento.php?operacion=g",
            rutaEl:"web/maestros/controlador/controladorEvento.php?operacion=el&codigo="
        },
        {
            nombre:"inscPrelimi",
            ruta:"web/maestros/controlador/controladorIncPreliminar.php?operacion=g",
            rutaEl:"web/maestros/controlador/controladorIncPreliminar.php?operacion=el&codigo="
        }

	];
//funccion que devuelve la ruta segun el nombre
function conseguirRuta(nombre,operacion){
	var r = "";
	$.each(rutas,function( index, value ) {
		if(value.nombre == nombre){
			if(operacion == "g"){
				r = value.ruta;
			}
			if(operacion == "el"){
				r = value.rutaEl;
			}
		}
	});

	return r;
}

function guardarMaestro (nombre,dataForm,fn) {
	var urlD = conseguirRuta(nombre,"g");

	$.ajax({
	  	method: "POST",
	  	url: urlD,
	  	data: dataForm,
	  	success: function(data) {
		  	var objJson = JSON.parse(data);
		  	if(objJson){
		  		if(objJson.guardado){
		  		   if(objJson.guardado == "OK"){
			    		fn.call(null,objJson);
			    		//alert("Registro guardado.");
			    		alertify.success(divMessageGuardado);
	                }
	                if(objJson.guardado == "KO"){
			    		//alert("Registro guardado.");
			    		if(objJson.mensage){
			    			alertify.alert(objJson.mensage);
			    		}
	                }
	            }
	            if(objJson.editado){
	                if(objJson.editado == "OK"){
			    		fn.call(null,objJson);
			    		//alert("Registro editado.");
			    		alertify.success(divMessageEditado);
	                }
	                if(objJson.editado == "KO"){
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




function eliminarMaestro (nombre,codigo,fn) {
	var urlD = conseguirRuta(nombre,"el")+codigo;

	$.ajax({
		url:urlD,   
		type: 'GET',   
		success: function(data) {
		     var objJson = JSON.parse(data);
		  	if(objJson){
	  		   if(objJson.eliminado == "OK"){
	  		   		fn.call(null,objJson);
		    		//alert("Registro eliminado.");
		    		alertify.success(divMessageEliminado);
                }
		  	}else{
		  		alert("Error al guardar");
		  	}
		}
	});

}

//Cargar las ramas en un select
function cargarRamas(objSelec){
    $.ajax({
        url:"web/maestros/controlador/controladorComun.php?operacion=ramas",   
        type: 'GET',   
        success: function(data) {
             var objJson = JSON.parse(data);
            if(objJson){
               if(objJson.data){
                if(objSelec){
                	objSelec.empty();
                	objSelec.append("<option value=select>Seleccionar</option>");
                    $.each(objJson.data,function( index, value ) {
                      objSelec.append("<option value="+value.codigo+">"+value.nombre+"</option>");
                    });
                    objSelec.find("option[value='select']").attr("selected","selected");
                }
               }
            }else{
                alert("Error al guardar");
            }
        }
    });
}

//Cargar las ramas en un select
function cargarTipoJuez(objSelec){
    $.ajax({
        url:"web/maestros/controlador/controladorComun.php?operacion=tipoJuez",   
        type: 'GET',   
        success: function(data) {
             var objJson = JSON.parse(data);
            if(objJson){
               if(objJson.data){
                if(objSelec){
                	objSelec.empty();
                	objSelec.append("<option value=select>Seleccionar</option>");
                    $.each(objJson.data,function( index, value ) {
                      objSelec.append("<option value="+value.codigo+">"+value.nombre+"</option>");
                    });
                    objSelec.find("option[value='select']").attr("selected","selected");
                }
               }
            }else{
                alert("Error al guardar");
            }
        }
    });
}

//Cargar las ligas en un select
function cargarLigas(objSelec){
    $.ajax({
        url:"web/maestros/controlador/controladorComun.php?operacion=ligas",   
        type: 'GET',   
        success: function(data) {
             var objJson = JSON.parse(data);
            if(objJson){
               if(objJson.data){
                if(objSelec){
                	objSelec.empty();
                	objSelec.append("<option value=select>Seleccionar</option>");
                    $.each(objJson.data,function( index, value ) {
                      objSelec.append("<option value="+value.codigo+">"+value.nombre+"</option>");
                    });
                    objSelec.find("option[value='select']").attr("selected","selected");
                }
               }
            }else{
                alert("Error al cargar ligas");
            }
        }
    });
}

//Cargar las categoriaS en un select
function cargarCategorias(objSelec){
    $.ajax({
        url:"web/maestros/controlador/controladorComun.php?operacion=categorias",   
        type: 'GET',   
        success: function(data) {
             var objJson = JSON.parse(data);
            if(objJson){
               if(objJson.data){
                if(objSelec){
                	objSelec.empty();
                	objSelec.append("<option value=select>Seleccionar</option>");
                    $.each(objJson.data,function( index, value ) {
                      objSelec.append("<option value="+value.codigo+">"+value.nombre+"</option>");
                    });
                    objSelec.find("option[value='select']").attr("selected","selected");
                }
               }
            }else{
                alert("Error al cargar ligas");
            }
        }
    });
}

//Cargar los entrenadores en un select
function cargarEntrenadores(objSelec){
    $.ajax({
        url:"web/maestros/controlador/controladorComun.php?operacion=entrenadores",   
        type: 'GET',   
        success: function(data) {
             var objJson = JSON.parse(data);
            if(objJson){
               if(objJson.data){
                if(objSelec){
                	objSelec.empty();
                	objSelec.append("<option value=select>Seleccionar</option>");
                    $.each(objJson.data,function( index, value ) {
                      objSelec.append("<option value="+value.codigo+">"+value.nombre+"</option>");
                    });
                    objSelec.find("option[value='select']").attr("selected","selected");
                }
               }
            }else{
                alert("Error al cargar entrenadores");
            }
        }
    });
}

//Cargar los eventos de un select
function cargarEventos(objSelec){
    $.ajax({
        url:"web/maestros/controlador/controladorComun.php?operacion=eventos",   
        type: 'GET',   
        success: function(data) {
             var objJson = JSON.parse(data);
            if(objJson){
               if(objJson.data){
                if(objSelec){
                    objSelec.empty();
                    objSelec.append("<option value=select>Seleccionar</option>");
                    $.each(objJson.data,function( index, value ) {
                      objSelec.append("<option value="+value.codigo+">"+value.nombre+"</option>");
                    });
                    objSelec.find("option[value='select']").attr("selected","selected");
                }
               }
            }else{
                alert("Error al cargar eventos");
            }
        }
    });
}

//Cargar los eventos de un select
function cargarAtletas(objSelec){
    $.ajax({
        url:"web/maestros/controlador/controladorComun.php?operacion=atletas",   
        type: 'GET',   
        success: function(data) {
             var objJson = JSON.parse(data);
            if(objJson){
               if(objJson.data){
                if(objSelec){
                    objSelec.empty();
                    objSelec.append("<option value=select>Seleccionar</option>");
                    $.each(objJson.data,function( index, value ) {
                      objSelec.append("<option value="+value.codigo+">"+value.nombre+"</option>");
                    });
                    objSelec.find("option[value='select']").attr("selected","selected");
                }
               }
            }else{
                alert("Error al cargar eventos");
            }
        }
    });
}

