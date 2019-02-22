<?php
namespace app\models;
defined("APPPATH") OR die("Access denied");

use \core\Database,
	\core\View,
	\app\models\admin\Transaccion;

/**
 * Clase que alberga funcionalidades genéricas
 */
class Clients {

	/**
	 * Para obtener los tipos de Fallas Generales con los que los Usuarios pueden identificar sus incidencias
	 * VALORES MAYORES A 100: reservados para Tecnicos y Reportes
 	 */
	public static function getFallasGenerales(){

		try {
			$connection = Database::instance();

			$sql = " SELECT * FROM FallasGenerales WHERE fallaId < 100 ";

			$query = $connection -> prepare($sql);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Clients.getFallasGenerales():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}
	

	/**
	 * Para obtener los tipos de Fallas Generales con los que los Usuarios pueden identificar sus incidencias
	 * VALORES MAYORES A 100: reservados para Tecnicos y Reportes
 	 */
	public static function getPerifericos(){
		try {
			$connection = Database::instance();

			$sql = " SELECT * FROM TipoPerifericos ORDER BY nombre ASC ";

			$query = $connection -> prepare($sql);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Clients.getPerifericos():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Obtener un tip generando un numero ALEATORIO (random) a través de SQL
	 * tabla :: TipsUsoPortal ::
 	 */
	public static function getTip($maximoId, $roleUsuario){
		try {
			$connection = Database::instance();

			$i = 0; $encontrado = false;
			$result = "";
			do {
				$intID = rand(1, $maximoId);

				$sql = " SELECT * FROM TipsUsoPortal tip WHERE tip.id = ? AND tip.loPuedeVer = ? ";

				$query = $connection -> prepare($sql);

				$query -> bindParam(1, $intID, 		 \PDO::PARAM_INT);
				$query -> bindParam(2, $roleUsuario, \PDO::PARAM_STR);

				$query -> execute();

				$result = $query -> fetch();


				if ( $result == NULL || $result != "" ){
					$encontrado = false;
				} else {
					$encontrado = true;
				}
				$i++;

			} while ( $i <= $maximoId && $encontrado == false );

			return $result;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Clients.getTip():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$maximoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	public static function getAllTecnicos() {
		try {
			$connection = Database::instance();

			$sql = " SELECT * FROM Usuarios tech WHERE tech.role = 'tech' ORDER BY tech.nombre ASC ";

			$query = $connection -> prepare($sql);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Clients.getAllTecnicos():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Tipos de Operaciones de la tabla Transaccion
 	 */
	public static function getTipoTransacciones(){

		$connection = Database::instance();

		$sql = " SELECT * FROM TipoTransacciones ";

		$query = $connection -> prepare($sql);

		$query -> execute();

		return $query -> fetchAll();
	}


	/**
	 * tabla Transaccion
	 * @return Object[] { filas, query_ejecutado }
 	 */
	public static function searchTransaccion($status, $operacion, $empresaId, $desde, $hasta, $palabrasClave){

		$connection = Database::instance();

		$sql = " SELECT * FROM Transaccion WHERE ";

		/*
		 * APPEND de varias clausulas WHERE 
		 */
		$boolBoth = false;
		if ( $status != "both" ){
			$sql .= " status = ? ";
		} else {
			$boolBoth = true;
			$sql .= " status IN ('Not_Ok', 'Ok') ";
		}

		$boolOp = false;
		if ( $operacion != "" ){
			$sql .= " AND tipo_transaccion = ? ";
			$boolOp = true;
		}

		$boolCo = false;
		if ( $empresaId != "" ){
			$sql .= " AND empresaId = ? ";
			$boolCo = true;
		}

		if ( $desde != "" ){
			$sql .= " AND fecha_hora >= '" .$desde. " 00:00.00' ";
		}

		if ( $hasta != "" ){
			$sql .= " AND fecha_hora < '" .$hasta. " 00:00.00' ";
		}
		
		if ( $palabrasClave != "" ){
			$a = $palabrasClave;
			$sql .= " AND (info LIKE '%".$a."%' OR error_tipo LIKE '%".$a."%' OR error_codigo LIKE '%".$a."%' OR error_mensaje LIKE '%".$a."%' ) ";
		}
		
		$sql .= " ORDER BY transaccionId DESC ";

		/**/
		$query = $connection -> prepare($sql);

		/**/
		$i = 0;
		if ( $boolBoth == false ){
			$i++;
			$query -> bindParam($i, $status, \PDO::PARAM_STR);	
		}
		
		/**/
		if ( $boolOp == true ){
			$i++;
			$query -> bindParam($i, $operacion, \PDO::PARAM_STR);
		}

		if ( $boolCo == true ){
			$i++;
			$query -> bindParam($i, $empresaId, \PDO::PARAM_INT);
		}

		$query -> execute();

		$result = $query -> fetchAll();

		$out[0] = $result;
		$out[1] = $sql;

		return $out;
	}

	/**
	 * Listar todos los Usuarios del Sistema, se ordenará por Empresa luego por Nombre
	 */
	public static function searchAllUsers(){

		$connection = Database::instance();

		$sql = " SELECT u.*, emp.nombre AS empresaName, emp.razonSocial, emp.empresaId AS EmpresaID
				FROM Usuarios u 
				INNER JOIN Empresas emp ON u.empresaId = emp.empresaId
				ORDER BY emp.nombre ASC, u.nombre ASC ";

		$query = $connection -> prepare($sql);

		$query -> execute();

		return $query -> fetchAll();
	}


	/**
	 * Modulo PQRS
	 */
	public static function insertPQRS($userId, $empresaId, $userRol, $comentarioTipo, $opinionComentarios){
		try {
			$connection = Database::instance();

			$sql = " INSERT INTO PQRS( userId, empresaId, userRole, tipo, texto ) 
					VALUES ( ?, ?, ?, ?, ? ) ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $userId, 			\PDO::PARAM_INT);
			$query -> bindParam(2, $empresaId, 			\PDO::PARAM_INT);
			$query -> bindParam(3, $userRol, 			\PDO::PARAM_STR);
			$query -> bindParam(4, $comentarioTipo, 	\PDO::PARAM_STR);
			$query -> bindParam(5, $opinionComentarios, \PDO::PARAM_STR);

			$count = $query -> execute();

			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Clients.insertPQRS():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$userId, $empresaId, $userRol, $comentarioTipo, $opinionComentarios";
			
			/**/
			Transaccion::insertTransaccionPDOException("Opinion_PQRS",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			return $internalErrorMessage;
		}
	}

	/**
	 * Listar todos los Usuarios del Sistema, se ordenará por Empresa luego por Nombre
	 * @param $opcion {"todos", "Petición", "Queja", "Reclamo", "Sugerencia"}
	 */
	public static function getPQRS($opcion){

		$connection = Database::instance();

		$sql = " SELECT p.*, e.nombre AS NombreEmpresa, e.razonSocial, u.nombre, u.apellido  
				FROM PQRS p 
				INNER JOIN Empresas e ON p.empresaId = e.empresaId 
				INNER JOIN Usuarios u ON p.userId = u.id 
				WHERE ";

		if ( $opcion == "todos" ){

			$sql .= " 1 ORDER BY p.id DESC ";
			
			$query = $connection -> prepare($sql);

		} else {
			if ( $opcion == "Peticion" ){
				$opcion = "Petición";
			}

			$sql .= ' p.tipo = ? ORDER BY p.id DESC ';
			
			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $opcion, \PDO::PARAM_STR);
		}

		$query -> execute();

		return $query -> fetchAll();
	}


	/**
	 * Listado de Codigos
	 */
	public static function getInfoCodigos(){
		
		$connection = Database::instance();

		$sql = " SELECT * FROM TipoEquipos ORDER BY tipoEquipoId ASC ";

		$query = $connection -> prepare($sql);

		$query -> execute();

		return $query -> fetchAll();
	}


	/**
	 * Listado de SistemasOperativos
	 */
	public static function getSistemasOperativos(){

		$connection = Database::instance();

		$sql = " SELECT * FROM SistemasOperativosListado ORDER BY id ASC ";

		$query = $connection -> prepare($sql);

		$query -> execute();

		return $query -> fetchAll();
	}

	/**
	 * Listado de VersionesWindowsListado + VersionesOtrosSOListado
	 */
	public static function getVersionesSistemasOperativos(){

		$connection = Database::instance();

		$sql = " SELECT * FROM VersionesWindowsListado ORDER BY id ASC;
					SELECT * FROM VersionesOtrosSOListado ORDER BY id ASC; ";

		$query = $connection -> prepare($sql);

		$query->execute();

		$result["windows"] = $query -> fetchAll();

		$query->nextRowset();

		$result["otro"] = $query -> fetchAll();

		return $result;
	}

	/**
	 * Listado de VersionesWindowsListado
	 */
	public static function getVersionesWindowsListado(){

		$connection = Database::instance();

		$sql = " SELECT * FROM VersionesWindowsListado ORDER BY id ASC ";

		$query = $connection -> prepare($sql);

		$query -> execute();

		return $query -> fetchAll();
	}

	/**
	 * Listado de VersionesOtrosSOListado
	 */
	public static function getVersionesOtrosSOListado(){

		$connection = Database::instance();

		$sql = " SELECT * FROM VersionesOtrosSOListado ORDER BY id ASC ";

		$query = $connection -> prepare($sql);

		$query -> execute();

		return $query -> fetchAll();
	}

	/**
	 * Listado de SistemasOperativosNombresListado
	 */
	public static function getSistemasOperativosNombresListado(){

		$connection = Database::instance();

		$sql = " SELECT * FROM SistemasOperativosNombresListado ORDER BY name ASC ";

		$query = $connection -> prepare($sql);

		$query -> execute();

		return $query -> fetchAll();
	}

	/**
	 * Listado de LicenciasTipoListado
	 */
	public static function getLicenciasTipoListado(){

		$connection = Database::instance();

		$sql = " SELECT * FROM LicenciasTipoListado ORDER BY name ASC ";

		$query = $connection -> prepare($sql);

		$query -> execute();

		return $query -> fetchAll();
	}

	/**
	 * Listado de OfimaticaSoftwareListado
	 */
	public static function getOfimaticaSoftwareListado(){

		$connection = Database::instance();

		$sql = " SELECT * FROM OfimaticaSoftwareListado ORDER BY id ASC ";

		$query = $connection -> prepare($sql);

		$query -> execute();

		return $query -> fetchAll();
	}
	
	
	/**
	 * Listado de OfimaticaSoftwareNombresListado
	 */
	public static function getOfimaticaSoftwareNombresListado(){

		$connection = Database::instance();

		$sql = " SELECT * FROM OfimaticaSoftwareNombresListado ORDER BY name ASC ";

		$query = $connection -> prepare($sql);

		$query -> execute();

		return $query -> fetchAll();
	}

	/**
	 * Listado de VersionesOfimaticaSoftwareListado
	 */
	public static function getVersionesOfimaticaSoftwareListado(){

		$connection = Database::instance();

		$sql = " SELECT * FROM VersionesOfimaticaSoftwareListado ORDER BY id ASC ";

		$query = $connection -> prepare($sql);

		$query -> execute();

		return $query -> fetchAll();
	}

	/**
	 * Para obtener los Estatus que poseen los Equipos
 	 */
	public static function getEstatusEquipos(){

		$connection = Database::instance();

		$sql = " SELECT * FROM StatusEquipos ORDER BY status ASC ";

		$query = $connection -> prepare($sql);

		$query -> execute();

		return $query -> fetchAll();
	}

}