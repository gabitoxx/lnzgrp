<?php
namespace core;
defined("APPPATH") OR die("Access denied");
 
class View
{
	/**
	 * @var
	 */
	protected static $data;

	/**
	 * @var
	 */
	//const VIEWS_PATH = "../app/views/";		//CONFIGURATION-MVC Asi vino el ejemplo
	const VIEWS_PATH = "app/views/";			//CONFIGURATION-MVC Funciona en localhost y en lanuzagroup.com
	
	/**
	 * @var
	 */
	const EXTENSION_TEMPLATES = "php";

	/**
	 * [render views with data]
	 * @param  [String]  [template name]
	 * @return [html]    [render html]
	 */
	public static function render($template) {

		if( !file_exists(self::VIEWS_PATH . $template . "." . self::EXTENSION_TEMPLATES))
		{
		    throw new \Exception("Exception in View.php -- Error: El archivo " . self::VIEWS_PATH . $template . "." . self::EXTENSION_TEMPLATES . " no existe", 1);
		}

		ob_start();

		try {
			error_reporting(E_ALL & ~E_WARNING );
			extract(self::$data);

		} catch (Exception $e){}

		include(self::VIEWS_PATH . $template . "." . self::EXTENSION_TEMPLATES);

		$str = ob_get_contents();

		ob_end_clean();

		echo $str;
    }
 
	/**
	 * [set Set Data form views]
	 * @param [string] $name  [key]
	 * @param [mixed] $value [value]
	 */
	public static function set($name, $value)
	{
		self::$data[$name] = $value;
	}
}