<?php

/**
 * Con esa sencilla función, todos los archivos que estén dentro del proyecto y cualquier 
 * directorio serán autocargados para poder utilizarlos donde necesitemos, 
 * y lo más importante, utilizando namespaces.
 */

/**
 * La aplicación será lanzada desde el archivo /public/index.php
 *  aquí será donde vamos a hacer la autocarga de clases y finalmente lanzar la aplicación,
 *  de momento, vamos a definir la autocarga con el siguiente código:
 */

// NO puede ser 'public' porque NO es una CLASE
function url(){
	//Para saber si es del tipo http o HTTPS
	return sprintf(
		"%s://%s%s",
		isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
		$_SERVER['SERVER_NAME'],
		$_SERVER['REQUEST_URI']
	);

	//Para PROBAR: echo "<br/>http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
}

/**
 * char AT en un string
 */
function char_at($str, $pos) {
	if ( $pos < strlen($str) ){

		return $str{$pos};
	} else {
		return ' ';
	}
}

/**
 * Obtiene el URL simple, sin controladores ni metodos
 * DESARROLLO: "http://localhost/mvc2/home/aboutUs" devuelve "http://localhost/"
 * PRODUCCION: "http://lanuzagroup.com/home" devuelve "http://lanuzagroup.com/"
 */
function getSimpleUrl($url){
	
	$aux=0;$x = 0;

	$int = strrpos ( $url , "/" );

	$url = substr ( $url , 0 , $int );
	
	for ($x = 0; $x <= $int; $x++) {
		
		$char = char_at($url, $x);
		if ( $char == '/' ){
			$aux++;
		}
		if ( $aux == 3 ){
			break;
		}
	}

	$temp = substr ( $url , 0 , ($x + 1) );
	
	if ( char_at($temp, strlen($temp) - 1) != '/' ){
		$temp = $temp . "/";
	}

	return $temp;
}

/**-------------------------------------------------------------------------------------------------------
 *  VARIABLES GLOBALES
 */
// En lugar de llamar a url(), se define una variable global
define("PROJECTURL", getSimpleUrl( url() ) );

//-------------------------------------------------------------------------------------------------------
// DEBE APUNTAR A LA CARPETA 'APP'
define("APPURL", 'mvc2/app/');						//CONFIGURATION-MVC Este corre en localhost
//define("APPURL", 'app/');							//CONFIGURATION-MVC Este corre en lanuzagroup.com

//@deprecated: directorio del proyecto
define("PROJECTPATH", dirname(__DIR__));

//-------------------------------------------------------------------------------------------------------
//directorio app
//define("APPPATH", PROJECTPATH . 'mvc2/app/');				//CONFIGURATION-MVC Este corre en localhost (sistema de archivos)
define("APPPATH", PROJECTURL . APPURL);						//CONFIGURATION-MVC Este corre en localhost (URL)
//define("APPPATH", 'app');									//CONFIGURATION-MVC Este corre en lanuzagroup.com

/**-------------------------------------------------------------------------------------------------------
 * Directorios para las Vistas
 */
define("APPIMAGEPATH" , PROJECTURL . APPURL . 'views/images/' );			//CONFIGURATION-MVC Este corre en localhost
//define("APPIMAGEPATH" , PROJECTURL . '/../app/views/images/' );		//CONFIGURATION-MVC Este corre en lanuzagroup.com

define("APPCSSPATH" , PROJECTURL . APPURL . 'views/css/' );				//CONFIGURATION-MVC Este corre en localhost
//define("APPCSSPATH" , PROJECTURL . '/../app/views/css/' );				//CONFIGURATION-MVC Este corre en lanuzagroup.com

define("APPJSPATH" , PROJECTURL . APPURL . 'views/js/' );					//CONFIGURATION-MVC Este corre en localhost
//define("APPJSPATH" , PROJECTURL . '/../app/views/js/' );				//CONFIGURATION-MVC Este corre en lanuzagroup.com

define("BOOTSTRAPPATH" , PROJECTURL . APPURL . 'views/assets/' );			//CONFIGURATION-MVC Este corre en localhost
//define("BOOTSTRAPPATH" , PROJECTURL . '/../app/views/assets/' );		//CONFIGURATION-MVC Este corre en lanuzagroup.com

/**-------------------------------------------------------------------------------------------------------
 * Email de Contacto
 */
define("CONTACTEMAIL1", "soporte@lanuzagroup.com");
define("CONTACTEMAIL2", "direccion@lanuzagroup.com");
define("CONTACT_EMAIL_3", "lanuzagroup@gmail.com");


/**------------------------------------------------------------------------------------------------------
 * USADO PARA EL MENU
 */
define("PROJECTURLMENU", PROJECTURL . "mvc2/");			//CONFIGURATION-MVC Este corre en localhost (URL)
//define("PROJECTURLMENU", PROJECTURL);					//CONFIGURATION-MVC Este corre en lanuzagroup.com


/**------------------------------------------------------------------------------------------------------
 * Colores del PORTAL segun el tipo de usuario
 */
define("RGB_CLIENTE",	"#39A8D9");
define("RGB_TECH",		"#AFCA0A");
define("RGB_MANAGER",   "#F9B233");
define("RGB_ADMIN", 	"#951B81");


//autoload con namespaces
function autoload_classes($class_name)
{
	// Buscando Home.php
	//$filename = PROJECTPATH . '/' . str_replace('\\', '/', $class_name) .'.php';		//CONFIGURATION-MVC Asi vino el ejemplo
	$filename = str_replace('\\', '/', $class_name) . '.php';							//CONFIGURATION-MVC Este corre en localhost y en lanuzagroup.com
	
	if( is_file($filename) ) {
		include_once $filename; 
	
	} else {
		// echo "probando" . $filename;
	}
}

//registramos el autoload autoload_classes
spl_autoload_register('autoload_classes');

//echo "1." . $filename;

//instanciamos la app
$app = new \core\App;
//$app = new App();

//lanzamos la app
$app -> render();
