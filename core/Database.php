<?php
namespace core;
defined("APPPATH") OR die("Access denied");
 
use \core\App;
 
/**
 * @class Database
 *
 * Cómo puedes ver simplemente es una conexión con una base de datos, pero tenemos un detalle en el constructor:
 * y es el uso de un archivo de configuración .ini que consumimos a través de un método de la clase Core/App.php
 * dicho archivo se llama config.ini y están en el directorio App/config,
 * créalo y añade el siguiente código:
 *[database]
 *host     = localhost
 *user     = root
 *password = admin
 *database = mvc
 *
 *
 * Las funciones mysql_* están obsoletas! Leer este articulo para ver sus equivalentes modernos:
 * http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
 */
class Database
{
 
	/**
	* @desc nombre del usuario de la base de datos
	* @var $_dbUser
	* @access private
	*/
	private $_dbUser;
 
	/**
	* @desc password de la base de datos
	* @var $_dbPassword
	* @access private
	*/
	private $_dbPassword;
 
	/**
	* @desc nombre del host
	* @var $_dbHost
	* @access private
	*/
	private $_dbHost;
 
	/**
	* @desc nombre de la base de datos
	* @var $_dbName
	* @access protected
	*/
	protected $_dbName;
 
	/**
	* @desc conexión a la base de datos
	* @var $_connection
	* @access private
	*/
	private $_connection;
 
    /**
    * @desc instancia de la base de datos
    * @var $_instance
    * @access private
    */
    private static $_instance;
 
	/**
	 * [__construct]
	 */
	private function __construct()
    {
		try {
			/**
			* CONFIGURATION-MVC
			* load from config/config.ini
			* llamando al App.php
			*/
			$config = App::getConfig();
			
			// Datos de Conexion
			$this->_dbHost = $config["host"];
			$this->_dbUser = $config["user"];
			$this->_dbPassword = $config["password"];
			$this->_dbName = $config["database"];
			
 			// Conexion a la BD
			$this->_connection = new \PDO(
				'mysql:host='.$this->_dbHost.'; dbname='.$this->_dbName,
				$this->_dbUser,
				$this->_dbPassword);

			$this ->_connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

			$this ->_connection->exec("SET CHARACTER SET utf8");
       
       } catch (\PDOException $e) {
			include APPPATH . "/views/errors/404.php";
            exit;
		}
    }


	/**
	 * [prepare]
	 * @param  [type] $sql [description]
	 * @return [type]      [description]
	 */
	public function prepare($sql) {
		return $this -> _connection -> prepare($sql);
	}
 	

	/**
	 * [instance singleton]
	 * @return [object] [class database]
	 */
	public static function instance() {

		if ( !isset( self::$_instance)) {
		        
			$class = __CLASS__;
		        
			self::$_instance = new $class;
		}
		
		return self::$_instance;
    }
 	

	/**
	 * [__clone Evita que el objeto se pueda clonar]
	 * @return [type] [message]
	 */
	public function __clone() {

		trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
	}
	
}