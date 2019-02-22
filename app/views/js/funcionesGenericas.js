/**
 * @param arrayJsonObjs 		Array de Objetos Javascript
 * @param stringToSearch 		String a buscar en el campo id
 * @return int					-1 si no està dicho objeto, sino el INDICE en donde se encontrò (>= 0)
 */
function buscarIdEnJson(arrayJsonObjs, stringToSearch){
	
	var result = -1;

	for(var i=0; i < arrayJsonObjs.length ; i++){

		if ( arrayJsonObjs[i].id == stringToSearch ){
			console.log(stringToSearch + " "+i);
			result = i;
			break;
		}
	}

	return result;
}

/**
 * @param arrayJsonObjs 		Array de Objetos Javascript
 * @param index 				indice del obj a eliminar
 * @return Array sin el objeto eliminado
 */
function quitarObjJson(arrayJsonObjs, index){

	var nuevoArray = [];
	for(var i=0; i < arrayJsonObjs.length ; i++){
		if ( i == index ){
			continue;
		} else {
			nuevoArray.push(arrayJsonObjs[i]);
		}
	}
	return nuevoArray;
}

function addJsonObj(arrayJsonObjs, newJsonObj){
	var array = arrayJsonObjs;
	array.push(newJsonObj);

	//JSON.stringify(s) devuelve un String
	return JSON.stringify(array);
}


/**
 * Para generar el JSON para el campo Incidencias.datosConexionRemota
 * @see crear_incidencia.php / Partner
 */
function generarJsonDatosConexion( remoteLink, userID, password ){
	
	var s = '[{"remoteLink":"A"},{"userID":"B"},{"password":"C"}]';
	
	if ( remoteLink == null || remoteLink.trim() == "" ){
		remoteLink = "No indica";
	}
	if ( userID == null || userID.trim() == "" ){
		userID = "No indica";
	}
	if ( password == null || password.trim() == "" ){
		password = "No indica";
	}

	s = s.replace("A", remoteLink);
	s = s.replace("B", userID);
	s = s.replace("C", password);

	return s;
}


/**
 * Para los paneles que se contraen/expanden
 */
function collapseDiv( collapseID ){
	$('#' + collapseID ).collapse('toggle');
}

function collapseAll(){
	$('.collapse').collapse('hide');
}

function expandAll(){
	$('.collapse').collapse('show');
}


/*
 * boton ir Arriba
 */
function goArriba(){
	location.href = "#container";
}


/**
 * Formulario como el del Tecnico pero sin poder editar
 */
function verDetalleSolucion(resolucionId){

	document.getElementById("resolucionIncidenciaId").value = resolucionId;

	document.getElementById("resolucionIncidenciaForm").submit();
}