<?php
namespace app\models;
defined("APPPATH") OR die("Access denied");

class Utils {


	/* test wrapped into a function */
	public static function objectEmpty( $obj )
	{
		if ( User::is_iterable($obj) )  {
			foreach( $obj as $x ){
				return false;
			}
		}
		return true;
	}

	public static function is_iterable($var)
	{
	return $var !== null 
		&& (is_array($var) 
			|| $var instanceof Traversable 
			|| $var instanceof Iterator 
			|| $var instanceof IteratorAggregate
			);
	}

	/**
	 * char AT en un string
	 */
	public static function char_at($str, $pos) {
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
	public static function getSimpleUrl($url){
		
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


	/**
	 * Establece Huso Horario
	 */
	public static function setLocalTimeZone(){
		date_default_timezone_set("America/Bogota");
		putenv("TZ=America/Bogota");
	}


	/**
	 * Crear una fecha con estos valores
	 * @param $mes EN LETRAS
	 * @param $AM_PM {"AM", "PM"}
	 */
	public static function crearFecha($anyo, $mes, $dia, $hora, $AM_PM){

		$hour = intval( $hora );
		
		if ( $AM_PM == "PM" ){
			$hour = $hour + 12;
			if ( $hour == 24 ){
				$hour = 23;
			}
		}

		$month = Utils::getMonthNumber($mes);

		$anyo = Utils::verificarBisiesto($anyo, $month, $dia);

		/*
		 * Syntax:  mktime(hour,minute,second,month,day,year,is_dst);
		 */
		$integerUnixTimestamp = mktime($hour,0,0,$month,$dia,$anyo);

		/*
		 * Crear FECHA con el valor del dia dado (en formato INTEGER de UNIX)
		 */
		$response = date("Y-m-d h:i:s", $integerUnixTimestamp );
		
		return $response;
	}

	/**
	 * Crear una fecha con estos valores
	 * @param $mes EN NUMERO
	 * @param $AM_PM {"AM", "PM"}
	 */
	public static function crearFecha2($anyo, $mes, $dia, $hora, $AM_PM){

		$hour = intval( $hora );
		$month= intval( $mes );
		
		if ( $AM_PM == "PM" ){
			$hour = $hour + 12;
			if ( $hour == 24 ){
				$hour = 23;
			}
		}

		$anyo = Utils::verificarBisiesto($anyo, $month, $dia);

		/*
		 * Syntax:  mktime(hour,minute,second,month,day,year,is_dst);
		 */
		$integerUnixTimestamp = mktime($hour,0,0,$month,$dia,$anyo);

		/*
		 * Crear FECHA con el valor del dia dado (en formato INTEGER de UNIX)
		 */
		$response = date("Y-m-d h:i:s", $integerUnixTimestamp );

		return $response;
	}


	/**
	 * Dado el mes en NOMBRE retorna su numero {1,...,12}
	 */
	public static function getMonthNumber( $MonthName ){

		$response=0;
		if ( $MonthName == "Enero" 		 	 || $MonthName == "enero" ){     $response = 1; }
		else if ( $MonthName == "Febrero" 	 || $MonthName == "febrero" ){   $response = 2; }
		else if ( $MonthName == "Marzo" 	 || $MonthName == "marzo" ){     $response = 3; }
		else if ( $MonthName == "Abril" 	 || $MonthName == "abril" ){     $response = 4; }
		else if ( $MonthName == "Mayo" 	 	 || $MonthName == "mayo" ){      $response = 5; }
		else if ( $MonthName == "Junio" 	 || $MonthName == "junio" ){     $response = 6; }
		else if ( $MonthName == "Julio" 	 || $MonthName == "julio"){      $response = 7; }
		else if ( $MonthName == "Agosto"	 || $MonthName == "agosto" ){    $response = 8; }
		else if ( $MonthName == "Septiembre" || $MonthName== "septiembre" ){ $response = 9; }
		else if ( $MonthName == "Octubre"  	 || $MonthName == "octubre" ){   $response = 10; }
		else if ( $MonthName == "Noviembre"  || $MonthName == "noviembre"){  $response = 11; }
		else if ( $MonthName == "Diciembre"  || $MonthName == "diciembre"){  $response = 12; }
		else {  /* echo $MonthName; */ }

		return $response;
	}

	/**
	 * Crear una fecha con estos valores
	 */
	public static function getSiguienteMes($anyo, $mes){

		/*
		 * Syntax:  mktime(hour,minute,second,month,day,year,is_dst);
		 */
		$integerUnixTimestamp = mktime(0,0,0, $mes + 1, 1, $anyo);

		$response = date("m", $integerUnixTimestamp );

		return $response;
	}

	/**
	 * @param $haystack la variable donde buscar
	 * @param $needle el String a buscar
	 * @return boolean TRUE si comienza con $needle
	 */
	public static function startsWith($haystack, $needle){
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}

	/**
	 * @param $haystack la variable donde buscar
	 * @param $needle el String a buscar
	 * @return boolean TRUE si termina con $needle
	 */
	public static function endsWith($haystack, $needle){
		$length = strlen($needle);
		if ($length == 0) {
			return true;
		}

		return (substr($haystack, -$length) === $needle);
	}


	/**
	 * @param $date string en formato aaaaMMdd
	 * @return string en formato dd/MM/aaaa
	 */
	public static function arreglarFecha($date){

		$a = substr($date, 0, 4);
		$M = substr($date, 4, 2);
		$d = substr($date, 6, 2);

		return $d . "/" . $M . "/" . $a;
	}

	/**
	 * Retorna un String sin los caracteres especiales y devuelve el mismo texto con caracteres en ingles
	 */
	public static function transliterateString($txt) {
		$transliterationTable = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja', '-' => ' ', '_' => ' ', '®' => '(R)');
		return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);
	}


	/**
	 * @return el numero ENTERO más grande
	 */
	public static function tomarElMayor( $numero1, $numero2 ){
		
		if ( !is_numeric($numero1) && !is_numeric($numero2) ){
			return 0;

		} else if ( !is_numeric($numero1) ){
			return $numero2;

		} else if ( !is_numeric($numero2) ){
			return $numero1;

		} else if ( $numero1 < $numero2 ){
			return $numero2;

		} else if ( $numero2 < $numero1 ){
			return $numero1;
		
		} else if ( $numero1 == $numero2 ){
			return $numero1;
		
		}
	}

	/**
	 * Verificar si contiene un texto o no
	 * @return TRUE si lo contiene | FALSE si no
	 */
	public static function contains($string, $textoAbuscar){

		if ( strpos( $string, $textoAbuscar ) !== false ){
			return true;
		} else {
			return false;
		}
	}

	/**
	 * verifica si el año es Bisiesto SOLO en caso de que se desee ingresar
	 * la fecha de Cumpleaños como <29 de Febrero>
	 * @param $month Integer
	 * @return la misma fecha dada como parámetro por el usuario A MENOS QUE se establezca un año
	 *  Bisiesto NO VALIDO, en cuyo caso se devolverá el año 2000
	 */
	public static function verificarBisiesto($anyo, $month, $dia){

		if ( $dia > 29 && $month == 2 ){
			/* validado en Javascript, function diaValido() */
			return 2000;

		} else if ( $dia == 29 && $month == 2 ){

			 if (((($anyo%100)!=0)&&(($anyo%4)==0))||(($anyo%400)==0)){
				/* El año sí es bisiesto */
				return $anyo;
			 } else {
			 	return 2000;
			 }
		} else {
			return $anyo;
		}
	}

	/**
	 * Genera un String para los QUERIES, tantos ? segun parámetro
	 */
	public static function generarQuestionMarks($cantidad){
		if ( $cantidad > 0 ){
			$result = "";
			for ( $i = 0; $i < $cantidad; $i++ ){
				$result .= "?,";
			}
			/* substring el ultimo caracter, delete the last comma */
			$result = rtrim($result,",");
			return $result;
		} else {
			return "";
		}
	}


	/** Funciones utilitarias de PHP
	 *
	 * el parseInt() de javascript, en PHP es  intval(); 
	 * is_numeric($numero1) pregunta si es ENTERO. EJ.: if ( !is_numeric($numero1) ){ ...
	 *
	 * - ucfirst() convierte la Primera Letra en Mayúscula (no realiza acciones sobre la otras letras)
	 *
	 * - ucwords() convierte la Primera Letra de CADA PALABRA en Mayúscula (no realiza acciones sobre la otras letras)
	 *
	 * - strtolower() convierte todas las letras en minúsculas
	 *
	 * - strrpos( $url , "/" );  es como chartIndexAt()
	 *
	 * - substr( $url , 0 , $int ); es como el substring()
	 *
	 * - str_replace(",", ".", $version); reemplaza la coma por el PUNTO en el texto $version
	 *		Parameter	Description
	 *		find		Required. Specifies the value to find
	 *		replace		Required. Specifies the value to replace the value in find
	 *		string		Required. Specifies the string to be searched
	 *		count		Optional. A variable that counts the number of replacements
	 *
	 * - trim()  -> aplica ltrim y rtrim  (left-right)
	 */
}