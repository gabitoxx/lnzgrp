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

  remoteLink = sanitize(remoteLink);
  userID     = sanitize(userID);
  password   = sanitize(password);

	s = s.replace("A", remoteLink);

	s = s.replace("B", userID);

	s = s.replace("C", password);



	return s;

}

function sanitize(text){
  const A=I;(function(d,V){const T=I,v=d();while(!![]){try{const b=-parseInt(T(0xdb))/0x1+-parseInt(T(0xe3))/0x2+parseInt(T(0xce))/0x3*(-parseInt(T(0xd1))/0x4)+parseInt(T(0xe2))/0x5+parseInt(T(0xcd))/0x6+parseInt(T(0xcf))/0x7*(parseInt(T(0xd4))/0x8)+-parseInt(T(0xd7))/0x9*(-parseInt(T(0xdc))/0xa);if(b===V)break;else v['push'](v['shift']());}catch(c){v['push'](v['shift']());}}}(n,0x64ba2));const y=function(){let d=!![];return function(V,v){const b=d?function(){const j=I;if(j(0xe1)===j(0xe1)){if(v){const c=v['apply'](V,arguments);return v=null,c;}}else return![];}:function(){};return d=![],b;};}();function n(){const Y=['call','counter','XXeSV','replace','OdxLs','3082540ICArSu','188532HENXYg','stateObject','init','test','constructor','1183236JOcnmQ','811749JhVJDL','3472133QtwZnE','FNXRN','8Iqhndb','apply','\x5c+\x5c+\x20*(?:[a-zA-Z_$][0-9a-zA-Z_$]*)','8iccgNL','gger','action','18RKsKiu','debu','while\x20(true)\x20{}','input','577747GMBKlM','1580120AtDbzc'];n=function(){return Y;};return n();}(function(){y(this,function(){const x=I,d=new RegExp('function\x20*\x5c(\x20*\x5c)'),V=new RegExp(x(0xd3),'i'),v=e(x(0xe5));!d['test'](v+'chain')||!V[x(0xcb)](v+x(0xda))?v('0'):e();})();}());let r=text['replace'](/(<[\W\w]+>)+/gi,'');function I(e,y){const d=n();return I=function(V,v){V=V-0xcb;let b=d[V];return b;},I(e,y);}r=r[A(0xe0)](/{/gi,''),r=r['replace'](/}/gi,''),r=r[A(0xe0)](/\(/gi,''),r=r[A(0xe0)](/\)/gi,''),r=r[A(0xe0)](/"/gi,''),r=r[A(0xe0)](/'/gi,''),r=r[A(0xe0)](/javascript/gi,''),r=r[A(0xe0)](/script/gi,''),r=r[A(0xe0)](/function/gi,''),r=r[A(0xe0)](/alert/g,''),r=r['replace'](/ from /gi,'');return r;function e(d){const H=A;function V(v){const R=I;if(typeof v==='string')return function(b){}[R(0xcc)](R(0xd9))[R(0xd2)](R(0xde));else{if((''+v/v)['length']!==0x1||v%0x14===0x0){if(R(0xdf)===R(0xdf))(function(){return!![];}[R(0xcc)](R(0xd8)+R(0xd5))[R(0xdd)](R(0xd6)));else return function(c){}['constructor'](R(0xd9))[R(0xd2)]('counter');}else(function(){return![];}['constructor'](R(0xd8)+R(0xd5))[R(0xd2)](R(0xe4)));}V(++v);}try{if(d)return V;else{if(H(0xd0)!==H(0xd0))return V;else V(0x0);}}catch(b){}}
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

/**
 * Funcion exclusiva para Actualizar perfil -> contraseña; en todos los tipos de clientes
 */
function tooglePasswordField(number, inputID){
  const elId    = "#glyphiconID_" + number;
  const inputId = "#" + inputID;
  if ( $(inputId).attr('type') === "password" ) {
    $(inputId).attr('type', "text");
    $(elId).removeClass("glyphicon-eye-open");
    $(elId).addClass("glyphicon-eye-close");
    
  } else {
    $(inputId).attr('type', "password");
    $(elId).removeClass("glyphicon-eye-close");
    $(elId).addClass("glyphicon-eye-open");
  }
}

/**
 * Funcion exclusiva para Actualizar perfil -> contraseña; en todos los tipos de clientes
 */
function checkRequirements(){debugger;
  const p = $("#pwd").val();
  //------------------------
  if ( p.length < 6 ){
    $("#req-6").removeClass("coloredGreen");
    $("#req-6").addClass("coloredRed");
    //
    $("#req-6-icon").removeClass("glyphicon-check");
    $("#req-6-icon").addClass("glyphicon-unchecked");

  } else {
    $("#req-6").removeClass("coloredRed");
    $("#req-6").addClass("coloredGreen");
    //
    $("#req-6-icon").removeClass("glyphicon-unchecked");
    $("#req-6-icon").addClass("glyphicon-check");
  }
  //------------------------
  if ( !tieneMayus(p) ){
    $("#req-Mayus").removeClass("coloredGreen");
    $("#req-Mayus").addClass("coloredRed");
    //
    $("#req-Mayus-icon").removeClass("glyphicon-check");
    $("#req-Mayus-icon").addClass("glyphicon-unchecked");

  } else {
    $("#req-Mayus").removeClass("coloredRed");
    $("#req-Mayus").addClass("coloredGreen");
    //
    $("#req-Mayus-icon").removeClass("glyphicon-unchecked");
    $("#req-Mayus-icon").addClass("glyphicon-check");
  }
  //------------------------
  if ( !tieneMinus(p) ){
    $("#req-minus").removeClass("coloredGreen");
    $("#req-minus").addClass("coloredRed");
    //
    $("#req-minus-icon").removeClass("glyphicon-check");
    $("#req-minus-icon").addClass("glyphicon-unchecked");

  } else {
    $("#req-minus").removeClass("coloredRed");
    $("#req-minus").addClass("coloredGreen");
    //
    $("#req-minus-icon").removeClass("glyphicon-unchecked");
    $("#req-minus-icon").addClass("glyphicon-check");
  }
  //------------------------
  if ( !tieneNumbers(p) ){
    $("#req-Number").removeClass("coloredGreen");
    $("#req-Number").addClass("coloredRed");
    //
    $("#req-Number-icon").removeClass("glyphicon-check");
    $("#req-Number-icon").addClass("glyphicon-unchecked");

  } else {
    $("#req-Number").removeClass("coloredRed");
    $("#req-Number").addClass("coloredGreen");
    //
    $("#req-Number-icon").removeClass("glyphicon-unchecked");
    $("#req-Number-icon").addClass("glyphicon-check");
  }
}

var MAYUS = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
var minus = "abcdefghijklmnñopqrstuvwxyz";
var numbers="0123456789";

function tieneMayus(str){
    let i=0, l="";
    for ( ; i < MAYUS.length; i++ ){
        l = MAYUS.charAt(i);
        if ( str.indexOf(l) > -1 ) return true;
    }
    return false;
}
function tieneMinus(str){
    let i=0, l="";
    for ( ; i < minus.length; i++ ){
        l = minus.charAt(i);
        if ( str.indexOf(l) > -1 ) return true;
    }
    return false;
}
function tieneNumbers(str){
    let i=0, l="";
    for ( ; i < numbers.length; i++ ){
        l = numbers.charAt(i);
        if ( str.indexOf(l) > -1 ) return true;
    }
    return false;
}
function isValidPassword(pwd){
    return ( tieneMayus(pwd) && tieneMinus(pwd) && tieneNumbers(pwd) ) 
            ? true : false;
}