<?php
namespace app\models;
defined("APPPATH") OR die("Access denied");

use \core\Database,
	\core\View,
	\app\models\admin\Transaccion,
	app\models\Utils;

class Equipos {

	/**
	 * Obtener Equipo(s) dado el USUARIO y su EMPRESA
	 */
	public static function getById($equipoId){

		try {
			$connection = Database::instance();

			$sql = "SELECT * FROM Equipos WHERE id = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetch();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.getById():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $equipoId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Obtener Equipo dado el EquipoInfoId (deberia ser uno solo ya que es Auto_incremental)
	 */
	public static function getByEquipoInfoId($equipoInfoId){

		try {
			$connection = Database::instance();

			$sql = "SELECT * FROM Equipos WHERE equipoInfoId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetch( \PDO::FETCH_OBJ );

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.getByequipoInfoId():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $equipoId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Obtener Equipo(s) dado el USUARIO y su EMPRESA
	 */
	public static function getEquipos($usuarioId, $empresaId){

		try {
			$connection = Database::instance();

			$sql = " SELECT eq.*, teq.nombre AS TipoEquipo "
					. " FROM Equipos eq " 
					. " LEFT JOIN TipoEquipos teq ON eq.tipoEquipoId = teq.tipoEquipoId "
					. " WHERE usuarioId = ? AND empresaId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $usuarioId, \PDO::PARAM_INT);
			$query -> bindParam(2, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();
			/* return $query -> fetch( \PDO::FETCH_OBJ ); */

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.getEquipos():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $usuarioId." * ".$empresaId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Obtener Equipo(s) dado el USUARIO y su EMPRESA
	 */
	public static function getEquipos2($usuarioId, $empresaId){

		try {
			$connection = Database::instance();

			$sql = " SELECT eq.*, te.nombre AS tipoEquipo FROM Equipos eq "
					. " LEFT JOIN TipoEquipos te ON eq.tipoEquipoId = te.tipoEquipoId "
					. " WHERE eq.usuarioId = ? AND eq.empresaId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $usuarioId, \PDO::PARAM_INT);
			$query -> bindParam(2, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();
			/* return $query -> fetch( \PDO::FETCH_OBJ ); */

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.getEquipos2():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $usuarioId." * ".$empresaId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Obtener Equipo(s) de una EMPRESA
	 */
	public static function getEquiposDeEmpresa($empresaId){
		try {
			$connection = Database::instance();

			$sql = "SELECT * FROM Equipos WHERE empresaId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();
			/* return $query -> fetch( \PDO::FETCH_OBJ ); */

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.getEquiposDeEmpresa():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "empresa:".$empresaId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Obtener Equipo(s) de una EMPRESA LEFT JOIN con su Usuario
	 */
	public static function getEquiposDeEmpresa2($empresaId){
		try {
			$connection = Database::instance();

			$sql = " SELECT eq.*, u.nombre, u.apellido   
					FROM Equipos eq 
					LEFT JOIN Usuarios u ON eq.usuarioId = u.id 
					WHERE eq.empresaId = ? 
					ORDER BY eq.codigoBarras  ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();
			/* return $query -> fetch( \PDO::FETCH_OBJ ); */

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.getEquiposDeEmpresa2():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "empresa:".$empresaId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}
	

	/**
	 * Obtener Equipo(s) de una EMPRESA <EXCLUYENDO a este Usuario>
	 * Ej: Cuando se busca los Equipos de una Empresa SIN los equipos del Manager
	 */
	public static function getEquiposDeEmpresaSinEsteUsuario($empresaId, $usuarioId){
		try {
			$connection = Database::instance();
			
			$sql = " SELECT eq.*, teq.nombre AS TipoEquipo "
					. " FROM Equipos eq " 
					. " LEFT JOIN TipoEquipos teq ON eq.tipoEquipoId = teq.tipoEquipoId "
					. " WHERE eq.empresaId = ? AND ( eq.usuarioId <> ? OR eq.usuarioId IS NULL ) ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);
			$query -> bindParam(2, $usuarioId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();
			/* return $query -> fetch( \PDO::FETCH_OBJ ); */

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.getEquiposDeEmpresaSinEsteUsuario():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $empresaId . " | " . $usuarioId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Obtener Equipo(s) de una EMPRESA con Tipo Equipo (INNER JOIN)
	 */
	public static function getEquiposDeEmpresaConTipoEquipo($empresaId){
		try {
			$connection = Database::instance();
			
			$sql = " SELECT eq.*, teq.nombre AS TipoEquipo "
					. " FROM Equipos eq " 
					. " LEFT JOIN TipoEquipos teq ON eq.tipoEquipoId = teq.tipoEquipoId "
					. " WHERE eq.empresaId = ?  ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.getEquiposDeEmpresaConTipoEquipo():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $empresaId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	public static function getAllTipoEquipos() {

		try {
			$connection = Database::instance();

			$sql = "SELECT * FROM TipoEquipos ";

			$query = $connection -> prepare($sql);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.getAllTipoEquipos():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Obtiene un tipo de Equipo
	 */
	public static function getTipoEquipo($id){
		try {
			$connection = Database::instance();

			$sql = "SELECT * FROM TipoEquipos WHERE tipoEquipoId = ? LIMIT 1 ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $id, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetch( \PDO::FETCH_OBJ );

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.getTipoEquipo():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $id;
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Obtener ID al estilo Código de BARRAS
	 * Ejemplo 0010200003, donde
	 *  0001 - empresaId        - 4 digitos
	 *  02   - tipoEquipoId     - 2 digitos
	 *  0003 - equipoId         - 4 digitos
	 */
	public static function getIdCodigoBarras($equipo){
		/*
		$empresaId      = $equipo->empresaId;
		$tipoEquipoId   = $equipo->tipoEquipoId;
		$equipoId       = $equipo->equipoId;
		*/
		$empresaId      = $equipo[3];
		$tipoEquipoId   = $equipo[5];
		$equipoId       = $equipo[1];

		$empresaId      = str_pad($empresaId,    4, "0", STR_PAD_LEFT);
		$tipoEquipoId   = str_pad($tipoEquipoId, 2, "0", STR_PAD_LEFT);
		$equipoId       = str_pad($equipoId,     4, "0", STR_PAD_LEFT);

		return "" . $empresaId . $tipoEquipoId . $equipoId;
	}

	/**
	 * CREAR Código de BARRAS
	 * Ejemplo 0010200003, donde
	 *  0001 - empresaId        - 4 digitos
	 *  02   - tipoEquipoId     - 2 digitos
	 *  0003 - equipoId         - 4 digitos
	 */
	public static function crearCodigoBarras($empresaId, $tipoEquipoId, $equipoId){

		$empresaId      = str_pad($empresaId,    4, "0", STR_PAD_LEFT);
		$tipoEquipoId   = str_pad($tipoEquipoId, 2, "0", STR_PAD_LEFT);
		$equipoId       = str_pad($equipoId,     4, "0", STR_PAD_LEFT);

		return "" . $empresaId . $tipoEquipoId . $equipoId;
	}

	/**
	 * Obtener Equipo(s) dado el USUARIO y su EMPRESA y su tipo de Equipo
	 */
	public static function getEquiposYTipo($usuarioId, $empresaId){

		try {
			$connection = Database::instance();

			$sql = "SELECT * FROM Equipos eq LEFT JOIN TipoEquipos teq ON eq.tipoEquipoId = teq.tipoEquipoId WHERE usuarioId = ? AND empresaId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $usuarioId, \PDO::PARAM_INT);
			$query -> bindParam(2, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();
			/* return $query -> fetch( \PDO::FETCH_OBJ ); */

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.getEquiposYTipo():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $usuarioId." * ".$empresaId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Obtener Equipo(s) dado el USUARIO y su EMPRESA y su tipo de Equipo
	 */
	public static function numeroDeEquiposDeEmpresa($empresaId){
		try {
			$connection = Database::instance();

			$sql = " SELECT COUNT(id) FROM Equipos WHERE empresaId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetch();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.numeroDeEquiposDeEmpresa():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "empresa:".$empresaId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * CREAR Equipo para un USUARIO y su EMPRESA
	 * @param $ownerUserId es el usuario DUEÑO del Equipo   | puede venir en 0 o null
	 * @param $idAutoIncremental  es el ID auto incremental de la tabla; si viene este valor ent. se añadirá
	 * @param $data         un objeto que contendrá la data que viene del formulario
	 * @param $perifericos  un objeto con valores serializados por coma tipo CSV que se debe procesar
	 */
	public static function insert($empresaId, $ownerUserId, $idAutoIncremental, $data, $perifericos){
		try{
			$connection = Database::instance();

			if ( $ownerUserId <= 0 || $ownerUserId == NULL ){
				$ownerUserId = NULL;
			}

			/*
			 * Se necesita saber el numero de EQUIPOS de esta EMPRESA para asignar un nuevo NUMERO a éste Equipo
			 * es el NUMERO DE EQUIPOS que posee actualmente la Empresa $empresaId, SUMANDOLE 1 
			 * (auto incremental segun la cantidad de Equipos de dicha Empresa)
			 */
			$totalEquiposEmpresa = Equipos::numeroDeEquiposDeEmpresa( $empresaId );
			$idEnEmpresa = $totalEquiposEmpresa[0];
			$idEnEmpresa++;

			/*
			 * Se generará el CODIGO de BARRAS para este nuevo Equipo
			 */
			$tipoEquipoId = $data[5];
			$barcode = Equipos::crearCodigoBarras($empresaId, $tipoEquipoId, $idEnEmpresa);

			/*
			 * La primera info basica será el nombre del Equipo
			 */
			$infoBasica = $data[0];

			/*
			 * Limpiando version del Sistema Operativo
			 */
			$SOversion = trim($data[18]);
			$SOversion = str_replace(",", ".", $SOversion);
			
			/*
			 * SQL
			 */
			$sql = " INSERT INTO Equipos( id, equipoId, empresaId, usuarioId, tipoEquipoId, 
					teamViewer_Id, teamViewer_clave, observacionInicial, codigoBarras, infoBasica, 
					nombreEquipo, hddEstado, dependencia, marca, modelo, 
					serial, conexionRemota, claveAdmin, valor, valorReposicion, 
					linkImagen, licWindows, licOffice, 
					sistemaOperativo, versionSO, nombreSO ) 
					VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ) ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $idAutoIncremental,   \PDO::PARAM_INT);
			$query -> bindParam(2, $idEnEmpresa,         \PDO::PARAM_INT);

			$query -> bindParam(3, $empresaId,   \PDO::PARAM_INT);
			$query -> bindParam(4, $ownerUserId, \PDO::PARAM_INT);

			$query -> bindParam(5, $tipoEquipoId,\PDO::PARAM_INT);

			/**/
			$query -> bindParam(6,  $data[6],    \PDO::PARAM_INT);/* teamViewerId */
			$query -> bindParam(7,  $data[7],    \PDO::PARAM_STR);
			$query -> bindParam(8,  $data[12],   \PDO::PARAM_STR);
			$query -> bindParam(9,  $barcode,    \PDO::PARAM_STR);
			$query -> bindParam(10, $infoBasica, \PDO::PARAM_STR);

			/**/
			$query -> bindParam(11,  $infoBasica,   \PDO::PARAM_STR);/* nombreEquipo */
			$query -> bindParam(12,  $data[16],     \PDO::PARAM_STR);
			$query -> bindParam(13,  $data[1],      \PDO::PARAM_STR);
			$query -> bindParam(14,  $data[2],      \PDO::PARAM_STR);
			$query -> bindParam(15,  $data[3],      \PDO::PARAM_STR);

			/**/
			$query -> bindParam(16,  $data[4],  \PDO::PARAM_STR);/* serial */
			$query -> bindParam(17,  $data[8],  \PDO::PARAM_STR);
			$query -> bindParam(18,  $data[9],  \PDO::PARAM_STR);
			$query -> bindParam(19,  $data[10], \PDO::PARAM_STR);
			$query -> bindParam(20,  $data[11], \PDO::PARAM_STR);

			/**/
			$query -> bindParam(21,  $data[13], \PDO::PARAM_STR);/* linkDeFoto */
			$query -> bindParam(22,  $data[14], \PDO::PARAM_STR);
			$query -> bindParam(23,  $data[15], \PDO::PARAM_STR);
			
			/**/
			$query -> bindParam(24,  $data[17],  \PDO::PARAM_STR);/* sistemaOperativo */
			$query -> bindParam(25,  $SOversion, \PDO::PARAM_STR);
			$query -> bindParam(26,  $data[19],  \PDO::PARAM_STR);
			
			$count = $query -> execute();
			
			/*
			 * Actualizando campo Empresa.equiposRegistrados
			 */
			Equipos::agregar1EquipoAEmpresa($empresaId);


			/*
			 * Agregando Periféricos que el Técnico añadio (si es que hay)
			 */
			Equipos::agregarPerifericos($idAutoIncremental, $perifericos);
			

			/* Cantidad de filas afectadas, se supone que es 1 */
			return $count;


		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.insert():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "dueñoId:".$ownerUserId. " | empresa:".$empresaId." | (equipo)id:$idAutoIncremental";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * En el Formulario de NUEVO INVENTARIO viene SERIALIZADA una tabla HTML
	 * @param $perifericos[0]  Cantidad de componentes
	 * @param $perifericos[+0] Data a insertar; todos los valores vienen en literales de STRING separados por coma ','
	 */
	public static function agregarPerifericos($equipoId, $perifericos) {
		try {
			$cantidad = $perifericos[0];

			$count = 0;

			if ( $cantidad > 0 ){
				
				$connection = Database::instance();

				$sql = " INSERT INTO EquipoPerifericos( equipoId, tipoPerifericoId, marcaPeriferico, serial, descripcion_obs) "
							. " VALUES ( ?, ?, ?, ?, ? ) ";

				/* Vienen los ID's de la tabla TipoPerifericos */
				$arrayIDs = explode(',', $perifericos[1]);

				/*
				 * metodo explode() es similar al split() / separando por comas
				 */
				$arrayMarcas        = explode(',', $perifericos[2]);
				$arraySeriales      = explode(',', $perifericos[3]);
				$arrayDescripciones = explode(',', $perifericos[4]);
				
				
				for ( $i = 0; $i < $cantidad; $i++ ){
					
					$query = $connection -> prepare($sql);

					/*
					 * insertar en la Base de datos
					 */
					$query -> bindParam(1, $equipoId,               \PDO::PARAM_INT);
					$query -> bindParam(2, $arrayIDs[$i],           \PDO::PARAM_INT);
					$query -> bindParam(3, $arrayMarcas[$i],        \PDO::PARAM_STR);
					$query -> bindParam(4, $arraySeriales[$i],      \PDO::PARAM_STR);
					$query -> bindParam(5, $arrayDescripciones[$i], \PDO::PARAM_STR);
					
					$count += $query -> execute();
				}
			}
			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.agregarPerifericos():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $equipoId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * CREAR Equipo para un USUARIO y su EMPRESA
	 */
	public static function getEquipoByData($empresaId, $ownerOfEquipmentId, $tipoEquipoId, 
			$teamViewerID, $teamViewerClave, $observaciones){
		try {
			$connection = Database::instance();

			$sql = " SELECT * FROM Equipos WHERE empresaId = ? "
					. " AND usuarioId = ? AND tipoEquipoId = ? "
					. " AND teamViewer_Id = ? AND teamViewer_clave = ? "
					. " AND observacionInicial = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId,          \PDO::PARAM_INT);
			$query -> bindParam(2, $ownerOfEquipmentId, \PDO::PARAM_INT);
			$query -> bindParam(3, $tipoEquipoId,       \PDO::PARAM_INT);
			$query -> bindParam(4, $teamViewerID,       \PDO::PARAM_INT);
			$query -> bindParam(5, $teamViewerClave,    \PDO::PARAM_STR);
			$query -> bindParam(6, $observaciones,      \PDO::PARAM_STR);

			$query -> execute();

			return $query -> fetch();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.getEquipoByData():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId, $searchedId, $tipoEquipo, $teamViewerID, $teamViewerClave, $observaciones";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Obtiene el valor del campo "Auto incremental" más grande; 
	 *  con el fin de insertar LUEGO una fila en dicha tabla --> (se le debe sumar 1 ANTES de dicha insercion)
	 * @param $nombreTabla debe ser el nombre de la tabla de INVENTARIOS (las que comienzan con "I")
	 */
	public static function getMaxID( $nombreTabla ){
		try {
			$connection = Database::instance();
			$sql = "";

			if ( $nombreTabla == "ICPU" ){
				$sql = " SELECT MAX(cpuId) AS max FROM ICPU ";

			} else if ( $nombreTabla == "IMotherBoard" ){
				$sql = " SELECT MAX(motherboardId) AS max FROM IMotherBoard ";

			} else if ( $nombreTabla == "EquipoInfo" ){
				$sql = " SELECT MAX(equipoInfoId) AS max FROM EquipoInfo ";

			} else if ( $nombreTabla == "Equipos" ){
				$sql = " SELECT MAX(id) AS max FROM Equipos ";

			} else if ( $nombreTabla == "Soluciones" ){
				$sql = " SELECT MAX(solucionId) AS max FROM Soluciones ";

			} else if ( $nombreTabla == "Incidencias" ){
				$sql = " SELECT MAX(incidenciaId) AS max FROM Incidencias ";

			} else if ( $nombreTabla == "TipsUsoPortal" ){
				$sql = " SELECT MAX(id) AS max FROM TipsUsoPortal ";

			} else {
				return -1;
			}

			$query = $connection -> prepare($sql);

			$query -> execute();

			$response = $query -> fetch();

			$id = $response["max"];

			return $id;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.getMaxID():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $nombreTabla;
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Añade 1 equipo a la Empresa
	 */
	public static function agregar1EquipoAEmpresa($empresaId){
		try{
			$connection = Database::instance();

			$sql = " UPDATE Empresas SET equiposRegistrados = (equiposRegistrados + 1) WHERE empresaId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId,  \PDO::PARAM_INT);
			
			$count = $query -> execute();
			
			/* Cantidad de filas afectadas, se supone que es 1 */
			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.agregar1EquipoAEmpresa():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "empresaId:$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}


	/**************************************************************************************************************
	 * @param $A_Iid Es el Numero unico AUTO_INCREMENTAL a insertar en la tabla
	 */
	public static function insertarCPU($A_Iid, $AddressWidth, $CurrentClockSpeed, $L2CacheSize, $L3CacheSize, $Name, $NumberOfCores, $legacyNumber){
		try{
			$connection = Database::instance();

			$sql = ""; $bool = false;

			if ( $legacyNumber < 0 ){
				$sql = " INSERT INTO ICPU(cpuId, AddressWidth, CurrentClockSpeed, Name, NumberOfCores, L2CacheSize, L3CacheSize) "
						. " VALUES( ?, ?, ?, ?, ?, ?, ? ) ";

			} else {
				$sql = " INSERT INTO ICPU(cpuId, AddressWidth, CurrentClockSpeed, Name, NumberOfCores, L2CacheSize, L3CacheSize, legacyNumber) "
						. " VALUES( ?, ?, ?, ?, ?, ?, ?, ? ) ";
				$bool = true;
			}

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $A_Iid,              \PDO::PARAM_INT);
			$query -> bindParam(2, $AddressWidth,       \PDO::PARAM_INT);
			$query -> bindParam(3, $CurrentClockSpeed,  \PDO::PARAM_INT);
			$query -> bindParam(4, $Name,               \PDO::PARAM_STR);
			$query -> bindParam(5, $NumberOfCores,      \PDO::PARAM_INT);
			$query -> bindParam(6, $L2CacheSize,        \PDO::PARAM_INT);
			$query -> bindParam(7, $L3CacheSize,        \PDO::PARAM_INT);

			if ( $bool ){
				$query -> bindParam(8, $legacyNumber, \PDO::PARAM_INT);
			}
			
			$count = $query -> execute();
			
			/* Cantidad de filas afectadas, se supone que es 1 */
			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.insertarCPU():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$A_Iid, $AddressWidth, $CurrentClockSpeed, $L2CacheSize, $L3CacheSize, $Name, $NumberOfCores";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}


	/**
	 * @param $A_Iid Es el Numero unico AUTO_INCREMENTAL a insertar en la tabla
	 */
	public static function insertEquipoInfo($equipoInfoId, $cpuId){
		try{
			$connection = Database::instance();

			$sql = " INSERT INTO EquipoInfo(equipoInfoId, cpuId) "
				. " VALUES( ?, ? ) ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId,       \PDO::PARAM_INT);
			$query -> bindParam(2, $cpuId,              \PDO::PARAM_INT);
			// ...
			
			$count = $query -> execute();
			
			/* Cantidad de filas afectadas, se supone que es 1 */
			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.insertEquipoInfo():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "equipoInfoId:$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}


	/**
	 * Actualizar enlazando el ID del Inventario (tabla EquipoInfo) con el Equipo del Usuario (tabla Equipos)
	 */
	public static function updateEquipoConInventario($newEquipoId, $equipoInfoId){
		try{
			$connection = Database::instance();

			$sql = " UPDATE Equipos SET equipoInfoId = ? WHERE id = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId,   \PDO::PARAM_INT);
			$query -> bindParam(2, $newEquipoId,    \PDO::PARAM_INT);
			
			$count = $query -> execute();
			
			/* Cantidad de filas afectadas, se supone que es 1 */
			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.updateEquipoConInventario():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "newEquipoId:$newEquipoId -- equipoInfoId:$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}


	/**
	 * Inventario -- tabla IMotherboard
	 */
	public static function insertarMotherboard($motherboardId, $Name, $Product, $SerialNumber, $Version, $legacyNumber){
		try{
			$connection = Database::instance();

			$sql = ""; $bool = false;

			if ( $legacyNumber < 0 ){
				$sql = " INSERT INTO IMotherBoard( motherboardId, Name, Product, Version, SerialNumber) "
						. " VALUES( ?, ?, ?, ?, ? ) ";
			} else {
				$sql = " INSERT INTO IMotherBoard( motherboardId, Name, Product, Version, SerialNumber, legacyNumber) "
						. " VALUES( ?, ?, ?, ?, ?, ? ) ";
				$bool = true;
			}

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $motherboardId,  \PDO::PARAM_INT);
			$query -> bindParam(2, $Name,           \PDO::PARAM_STR);
			$query -> bindParam(3, $Product,        \PDO::PARAM_STR);
			$query -> bindParam(4, $Version,        \PDO::PARAM_INT);
			$query -> bindParam(5, $SerialNumber,   \PDO::PARAM_STR);

			if ( $bool ){
				$query -> bindParam(6, $legacyNumber, \PDO::PARAM_INT);
			}
			
			$count = $query -> execute();
			
			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.insertarMotherboard():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$motherboardId, $Name, $Product, $SerialNumber, $Version";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}


	/**
	 * Inventario -- tabla IMotherboard
	 */
	public static function updateEquipoInfo($equipoInfoId, $motherboardId ){
		try{
			$connection = Database::instance();

			$sql = " UPDATE EquipoInfo SET motherboardId = ? WHERE equipoInfoId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $motherboardId,  \PDO::PARAM_INT);
			$query -> bindParam(2, $equipoInfoId,   \PDO::PARAM_INT);
			
			$count = $query -> execute();
			
			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.updateEquipoInfo():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId, $motherboardId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}


	/**
	 * Inventario -- tabla ILocalUsers
	 * insertar una fila por cada cuenta que traiga el arreglo
	 */
	public static function insertarLocalUsers($equipoInfoId, 
			$cantidadCuentas, $arrayCuentas, $cantidadTipos, $arrayTipos, $legacyNumber){
		try {
			if ( $cantidadCuentas == $cantidadTipos ){
				
				$connection = Database::instance();

				$sql = ""; $bool = false;

				if ( $legacyNumber < 0 ){
					$sql = " INSERT INTO ILocalUsers( equipoInfoId, Cuenta, Tipo ) "
							. " VALUES ( ?, ?, ?) ";
				} else {
					$sql = " INSERT INTO ILocalUsers( equipoInfoId, Cuenta, Tipo, legacyNumber ) "
							. " VALUES ( ?, ?, ?, ?) ";

					$bool = true;
				}

				$count = 0;

				for ( $i = 0; $i < $cantidadCuentas; $i++ ){
					
					$query = $connection -> prepare($sql);

					/*
					 * insertar en la Base de datos
					 */
					$query -> bindParam(1, $equipoInfoId,       \PDO::PARAM_INT);
					$query -> bindParam(2, $arrayCuentas[$i],   \PDO::PARAM_STR);
					$query -> bindParam(3, $arrayTipos[$i],     \PDO::PARAM_STR);

					if ( $bool ){
						$query -> bindParam(4, $legacyNumber, \PDO::PARAM_INT);
					}

					$count += $query -> execute();
				}

				return "Se procesaron " . $count . " Cuentas para este Equipo."
						. "<br><b>...¡Procesado correctamente!</b>";

			} else {
				return "No se procesaron Cuentas para este Equipo. ( ERROR #005 in insertarLocalUsers() - archivo .CSV mal creado)";
			}
		} catch(\PDOException $e) {
			return "ERROR: No se procesaron Cuentas para este Equipo. Causa: " . $e -> getMessage();
		}
	}


	/**
	 * Inventario -- tabla ILocalUsers
	 * insertar una fila por cada cuenta que traiga el arreglo
	 * en las versiones nuevas el parametro <ConfiguredClockSpeed> NO viene en los archivos .csv
	 */
	public static function insertarRAM($equipoInfoId, $arrayBankLabel, $arrayCapacity, 
			$arrayConfiguredClockSpeed, $arrayMemoryType, $arraySpeed, $legacyNumber){
		try {
			if ( count($arrayBankLabel) == count($arrayCapacity) && count($arrayBankLabel) == count($arrayMemoryType) 
					&&  count($arrayBankLabel) == count($arraySpeed) ){
				/*
				 * solo entra si todos los Arreglos son del mismo tamaño
				 */
				$connection = Database::instance();

				$sql = ""; $bool = false;

				if ( $legacyNumber < 0 ){
					$sql = " INSERT INTO IRAM( equipoInfoId, BankLabel, Capacity, ConfiguredClockSpeed, MemoryType, Speed ) "
							. " VALUES ( ?, ?, ?, ?, ?, ?) ";
				} else {
					$sql = " INSERT INTO IRAM( equipoInfoId, BankLabel, Capacity, ConfiguredClockSpeed, MemoryType, Speed, legacyNumber ) "
							. " VALUES ( ?, ?, ?, ?, ?, ?, ?) ";

					$bool = true;
				}

				$count = 0;

				for ( $i = 0; $i < count($arrayBankLabel); $i++ ){
					
					$query = $connection -> prepare($sql);

					/*
					 * insertar en la Base de datos
					 */
					$query -> bindParam(1, $equipoInfoId,                   \PDO::PARAM_INT);
					$query -> bindParam(2, $arrayBankLabel[$i],             \PDO::PARAM_STR);
					$query -> bindParam(3, $arrayCapacity[$i],              \PDO::PARAM_INT);
					
					if ( $arrayConfiguredClockSpeed == NULL ){
						$aux = NULL;
						$query -> bindParam(4, $aux, \PDO::PARAM_INT);
					} else {
						$query -> bindParam(4, $arrayConfiguredClockSpeed[$i], \PDO::PARAM_INT);
					}
					
					$query -> bindParam(5, $arrayMemoryType[$i],            \PDO::PARAM_STR);
					$query -> bindParam(6, $arraySpeed[$i],                 \PDO::PARAM_INT);

					if ( $bool ){
						$query -> bindParam(7, $legacyNumber, \PDO::PARAM_INT);
					}

					$count += $query -> execute();
				}

				return "Se procesaron " . $count . " slots RAM's para este Equipo."
						. "<br><b>...¡Procesado correctamente!</b>";

			} else {
				return "No se procesaron slots RAM's para este Equipo. ( ERROR #005 in insertarRAM() - archivo .CSV mal creado)";
			}
		} catch(\PDOException $e) {
			return "ERROR: No se procesaron slots RAM's para este Equipo. Causa: " . $e -> getMessage();
		}
	}

	
	/**
	 * Inventario -- tabla ILocalUsers
	 * insertar una fila por cada cuenta que traiga el arreglo
	 */
	public static function insertarSound($equipoInfoId, $arrayCaption, $arrayManufacturer, $legacyNumber){
		try {
			if ( count( $arrayCaption) == count( $arrayManufacturer) ){
				
				$connection = Database::instance();

				$sql = ""; $bool = false;

				if ( $legacyNumber < 0 ){
					$sql = " INSERT INTO ISound( equipoInfoId, Caption, Manufacturer ) "
							. " VALUES ( ?, ?, ?) ";
				} else {
					$sql = " INSERT INTO ISound( equipoInfoId, Caption, Manufacturer, legacyNumber ) "
							. " VALUES ( ?, ?, ?, ? ) ";

					$bool = true;
				}

				$count = 0;

				for ( $i = 0; $i < count( $arrayManufacturer); $i++ ){
					
					$query = $connection -> prepare($sql);

					/*
					 * insertar en la Base de datos
					 */
					$query -> bindParam(1, $equipoInfoId,           \PDO::PARAM_INT);
					$query -> bindParam(2, $arrayCaption[$i],       \PDO::PARAM_STR);
					$query -> bindParam(3, $arrayManufacturer[$i],  \PDO::PARAM_STR);

					if ( $bool ){
						$query -> bindParam(4, $legacyNumber, \PDO::PARAM_INT);
					}

					$count += $query -> execute();
				}

				return "Se procesaron " . $count . " dispositivos de Sonido para este Equipo."
						. "<br><b>...¡Procesado correctamente!</b>";

			} else {
				return "No se procesaron dispositivos de Sonido para este Equipo. ( ERROR #005 in insertarSound() - archivo .CSV mal creado)";
			}
		} catch(\PDOException $e) {
			return "ERROR: No se procesaron dispositivos de Sonido para este Equipo. Causa: " . $e -> getMessage();
		}
	}

	
	/**
	 * Inventario -- tabla ILocalUsers
	 * insertar una fila por cada cuenta que traiga el arreglo
	 */
	public static function insertarVideo($equipoInfoId, $arrayAdapterCompatibility, 
			$arrayAdapterRAM, $arrayName, $arrayVideoProcessor, $legacyNumber){
		try {
			if ( count($arrayAdapterCompatibility) == count($arrayAdapterRAM) && count($arrayAdapterCompatibility) == count($arrayVideoProcessor) 
					&&  count($arrayName) == count($arrayAdapterRAM) ){
				/*
				 * solo entra si todos los Arreglos son del mismo tamaño
				 */
				$connection = Database::instance();

				$sql = ""; $bool = false;

				if ( $legacyNumber < 0 ){
					$sql = " INSERT INTO IVideo( equipoInfoId, AdapterCompatibility, AdapterRAM, Name, VideoProcessor) "
							. " VALUES ( ?, ?, ?, ?, ? ) ";
				} else {
					$sql = " INSERT INTO IVideo( equipoInfoId, AdapterCompatibility, AdapterRAM, Name, VideoProcessor, legacyNumber ) "
							. " VALUES ( ?, ?, ?, ?, ?, ? ) ";

					$bool = true;
				}

				$count = 0;

				for ( $i = 0; $i < count($arrayAdapterCompatibility); $i++ ){
					
					$query = $connection -> prepare($sql);

					/*
					 * insertar en la Base de datos
					 */
					$query -> bindParam(1, $equipoInfoId,                   \PDO::PARAM_INT);
					$query -> bindParam(2, $arrayAdapterCompatibility[$i],  \PDO::PARAM_STR);
					$query -> bindParam(3, $arrayAdapterRAM[$i],            \PDO::PARAM_INT);
					$query -> bindParam(4, $arrayName[$i],                  \PDO::PARAM_STR);
					$query -> bindParam(5, $arrayVideoProcessor[$i],        \PDO::PARAM_STR);

					if ( $bool ){
						$query -> bindParam(6, $legacyNumber, \PDO::PARAM_INT);
					}

					$count += $query -> execute();
				}

				return "Se procesaron " . $count . " dispositivos de Video para este Equipo."
						. "<br><b>...¡Procesado correctamente!</b>";

			} else {
				return "No se procesaron dispositivos de Video para este Equipo. ( ERROR #005 in insertarVideo() - archivo .CSV mal creado)";
			}
		} catch(\PDOException $e) {
			return "ERROR: No se procesaron dispositivos de Video para este Equipo. Causa: " . $e -> getMessage();
		}
	}


	/**
	 * Inventario -- tabla ILocalUsers  / 1 sola fila por Equipo
	 */
	public static function insertarOS($equipoInfoId, $Caption, $CSName, $Workgroup, $legacyNumber){
		try{
			$connection = Database::instance();

			$sql = ""; $bool = false;

			if ( $legacyNumber < 0 ){
				$sql = " INSERT INTO IOS ( equipoInfoId, Caption, CSName, Workgroup ) "
						. " VALUES( ?, ?, ?, ? ) ";
			} else {
				$sql = " INSERT INTO IOS ( equipoInfoId, Caption, CSName, Workgroup, legacyNumber ) "
						. " VALUES( ?, ?, ?, ?, ? ) ";

				$bool = true;
			}

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId,   \PDO::PARAM_INT);
			$query -> bindParam(2, $Caption,        \PDO::PARAM_STR);
			$query -> bindParam(3, $CSName,         \PDO::PARAM_STR);
			$query -> bindParam(4, $Workgroup,      \PDO::PARAM_STR);

			if ( $bool ){
				$query -> bindParam(5, $legacyNumber, \PDO::PARAM_INT);
			}
			
			$count = $query -> execute();
			
			if ( $count == 1 ){
				return "<br><b>...¡Procesado correctamente!</b>";
			} else {
				return "<br><b>No fue Procesado</b> el archivo OS.csv. ( ERROR #005 in insertarOS() -- archivo .CSV mal creado)";
			}
		} catch(\PDOException $e) {
			return "ERROR: leyendo archivo OS.csv -- Causa: " . $e -> getMessage();
		}
	}


	/**
	 * Inventario -- tabla ILocalUsers  / 1 sola fila por Equipo
	 * insertar una fila por cada cuenta que traiga el arreglo
	 */
	public static function insertarHardDrives($equipoInfoId,
			$contadorParticiones, 
			$arrayCapacity, $arrayDriveLetter, $arrayDriveType, $arrayFileSystem, $arrayFreeSpace,
			$contadorDiscos,
			$arrayInterfaceType, $arrayModel, $arraySerialNumber, $arraySize,
			$legacyNumber){

		try {
			$result = "";

			$connection = Database::instance();

			/******************************************************************************************************
			 *  .: PARTICIONES :.
			 */
			if ( $contadorParticiones == count($arrayCapacity) && count($arrayDriveLetter) == count($arrayDriveType) 
					&& $contadorParticiones == count($arrayFileSystem) && $contadorParticiones == count($arrayFreeSpace) ){
				
				$sql1 = ""; $bool = false;

				/*
				 * solo entra si todos los Arreglos son del mismo tamaño
				 */
				if ( $legacyNumber < 0 ){
					$sql1 = " INSERT INTO IHardDrives( equipoInfoId, Capacity, DriveLetter, DriveType, FileSystem, FreeSpace ) "
							. " VALUES ( ?, ?, ?, ?, ?, ? ) ";
				} else {
					$sql1 = " INSERT INTO IHardDrives( equipoInfoId, Capacity, DriveLetter, DriveType, FileSystem, FreeSpace, legacyNumber ) "
							. " VALUES ( ?, ?, ?, ?, ?, ?, ? ) ";

					$bool = true;
				}

				$count1 = 0;

				for ( $i = 0; $i < $contadorParticiones; $i++ ){
					
					$query1 = $connection -> prepare($sql1);

					/*
					 * insertar en la Base de datos
					 */
					$query1 -> bindParam(1, $equipoInfoId,          \PDO::PARAM_INT);
					$query1 -> bindParam(2, $arrayCapacity[$i],     \PDO::PARAM_STR);
					$query1 -> bindParam(3, $arrayDriveLetter[$i],  \PDO::PARAM_STR);
					$query1 -> bindParam(4, $arrayDriveType[$i],    \PDO::PARAM_STR);
					$query1 -> bindParam(5, $arrayFileSystem[$i],   \PDO::PARAM_STR);
					$query1 -> bindParam(6, $arrayFreeSpace[$i],    \PDO::PARAM_INT);

					if ( $bool ){
						$query1 -> bindParam(7, $legacyNumber, \PDO::PARAM_INT);
					}

					$count1 += $query1 -> execute();
				}

				$result .= "Se estan procesando " . $count1 . " Particiones en este Equipo."
						. "<br><b>...¡Procesado correctamente!</b>";

			} else {
				$bError = true;
				$result = " No se procesaron Particiones para este Equipo. ( ERROR #005 in insertarHardDrives() - archivo .CSV mal creado)";
			}

			/******************************************************************************************************
			 * .: DISCOS DUROS :.
			 */
			if ( $contadorDiscos == count($arrayInterfaceType) && count($arrayModel) == count($arraySerialNumber) 
					&& $contadorDiscos == count($arraySize) && $contadorDiscos == count($arraySerialNumber) ){
				
				$sql2 = ""; $bool = false;

				/*
				 * solo entra si todos los Arreglos son del mismo tamaño
				 */
				if ( $legacyNumber < 0 ){
					$sql2 = " INSERT INTO IHardDrives( equipoInfoId, InterfaceType, Model, SerialNumber, Size ) "
							. " VALUES ( ?, ?, ?, ?, ? ) ";
				} else {
					$sql2 = " INSERT INTO IHardDrives( equipoInfoId, InterfaceType, Model, SerialNumber, Size, legacyNumber ) "
							. " VALUES ( ?, ?, ?, ?, ?, ? ) ";

					$bool = true;
				}

				$count2 = 0;

				for ( $i = 0; $i < $contadorDiscos; $i++ ){

					$query2 = $connection -> prepare($sql2);

					/*
					 * insertar en la Base de datos
					 */
					$query2 -> bindParam(1, $equipoInfoId,          \PDO::PARAM_INT);
					$query2 -> bindParam(2, $arrayInterfaceType[$i],\PDO::PARAM_STR);
					$query2 -> bindParam(3, $arrayModel[$i],        \PDO::PARAM_STR);
					$query2 -> bindParam(4, $arraySerialNumber[$i], \PDO::PARAM_STR);
					$query2 -> bindParam(5, $arraySize[$i],         \PDO::PARAM_STR);

					if ( $bool ){
						$query2 -> bindParam(6, $legacyNumber, \PDO::PARAM_INT);
					}

					$count2 += $query2 -> execute();
				}

				$result .= "<br>Se estan procesando " . $count2 . " Discos Duros en este Equipo."
						. "<br><b>...¡Procesado correctamente!</b>";
				
			} else {
				$result .= "<br>No se procesaron DISCOS DUROS para este Equipo. ( ERROR #005 in insertarHardDrives() - archivo .CSV mal creado)";
			}

			/******************************************************************************************************
			 * resultados
			 */
			return $result;

		} catch(\PDOException $e) {
			return "ERROR: leyendo archivo HardDrives.csv -- Causa: " . $e -> getMessage();
		}
	}


	/**
	 * Inventario -- tabla ILocalUsers  / 1 sola fila por Equipo
	 * insertar una fila por cada cuenta que traiga el arreglo
	 * @param $contadorRedes    Contador de posiciones del arreglo de la primera dimension (tamaño variable)
	 * @param $arrayRedes       Arreglo de 2 dimensiones; la segunda dimension  (tamaño fijo)
	 */
	public static function insertarNetworking($equipoInfoId, $contadorRedes, $arrayRedes, $legacyNumber){
		try {
			$connection = Database::instance();

			$sql = ""; $bool = false;

			if ( $legacyNumber < 0 ){
				$sql = " INSERT INTO INetworking( equipoInfoId, Adapter, AdapterType, MAC, IP_1, IP_2, DCHPEnabled ) "
						. " VALUES ( ?, ?, ?, ?, ?, ?, ? ) ";
			} else {
				$sql = " INSERT INTO INetworking( equipoInfoId, Adapter, AdapterType, MAC, IP_1, IP_2, DCHPEnabled, legacyNumber ) "
						. " VALUES ( ?, ?, ?, ?, ?, ?, ?, ? ) ";

				$bool = true;
			}
			$count=0;

			for ( $i = 0; $i <= $contadorRedes; $i++ ){

				$query = $connection -> prepare($sql);

				/*
				 * insertar en la Base de datos
				 */
				$query -> bindParam(1, $equipoInfoId,                   \PDO::PARAM_INT);
				$query -> bindParam(2, $arrayRedes[$i]["Adapter"],      \PDO::PARAM_STR);
				$query -> bindParam(3, $arrayRedes[$i]["AdapterType"],  \PDO::PARAM_STR);
				$query -> bindParam(4, $arrayRedes[$i]["MAC"],          \PDO::PARAM_STR);
				$query -> bindParam(5, $arrayRedes[$i]["IP_1"],         \PDO::PARAM_STR);
				$query -> bindParam(6, $arrayRedes[$i]["IP_2"],         \PDO::PARAM_STR);

				$aux = $arrayRedes[$i]["DCHPEnabled"];

				if ( $aux == "TRUE" || $aux == "true" ){            $aux = "TRUE";
				} else if ( $aux == "FALSE" || $aux == "false" ){   $aux = "FALSE";
				} else {                                            $aux = "Unknown";
				}
				$query -> bindParam(7, $aux, \PDO::PARAM_STR);

				if ( $bool ){
					$query -> bindParam(8, $legacyNumber, \PDO::PARAM_INT);
				}

				$count += $query -> execute();
			}

			$result = "<br>Se estan procesando " . $count . " conexiones de RED."
					. "<br><b>...¡Procesado correctamente!</b>";

			return $result;

		} catch(\PDOException $e) {
			return "ERROR: leyendo archivo Networking.csv -- Causa: " . $e -> getMessage();
		}
	}
	

	/**
	 * Inventario -- tabla ILocalUsers  / 1 sola fila por Equipo
	 * insertar una fila por cada cuenta que traiga el arreglo
	 * @param $contadorPosiciones   Contador de posiciones del arreglo de la primera dimension (tamaño variable)
	 * @param $arraySMART           Arreglo de 2 dimensiones; la segunda dimension  (tamaño fijo)
	 */
	public static function insertarSMART($equipoInfoId, $contadorPosiciones, $arraySMART, $legacyNumber){
		try {
			$connection = Database::instance();

			$sql = ""; $bool = false;

			if ( $legacyNumber < 0 ){
				$sql = " INSERT INTO ISMART ( equipoInfoId, Serial, Model, Power_on_hours_1, Power_on_hours_2, HDD_temperature, Reallocated_sector_count ) "
						. " VALUES ( ?, ?, ?, ?, ?, ?, ? ) ";
			} else {
				$sql = " INSERT INTO ISMART ( equipoInfoId, Serial, Model, Power_on_hours_1, Power_on_hours_2, HDD_temperature, Reallocated_sector_count, legacyNumber ) "
						. " VALUES ( ?, ?, ?, ?, ?, ?, ?, ? ) ";

				$bool = true;
			}

			$count=0;

			for ( $i = 0; $i <= $contadorPosiciones; $i++ ){

				$query = $connection -> prepare($sql);

				/*
				 * insertar en la Base de datos
				 */
				$query -> bindParam(1, $equipoInfoId,                               \PDO::PARAM_INT);
				$query -> bindParam(2, $arraySMART[$i]["Serial"],                   \PDO::PARAM_STR);
				$query -> bindParam(3, $arraySMART[$i]["Model"],                    \PDO::PARAM_STR);
				$query -> bindParam(4, $arraySMART[$i]["Power_on_hours_1"],         \PDO::PARAM_INT);
				$query -> bindParam(5, $arraySMART[$i]["Power_on_hours_2"],         \PDO::PARAM_INT);
				$query -> bindParam(6, $arraySMART[$i]["HDD_temperature"],          \PDO::PARAM_INT);
				$query -> bindParam(7, $arraySMART[$i]["Reallocated_sector_count"], \PDO::PARAM_INT);

				if ( $bool ){
					$query -> bindParam(8, $legacyNumber, \PDO::PARAM_INT);
				}

				$count += $query -> execute();
			}

			$result = "<br>Se estan procesando " . $count . " entradas SMART."
					. "<br><b>...¡Procesado correctamente!</b>";

			return $result;

		} catch(\PDOException $e) {
			return "ERROR: leyendo archivo SMART.csv -- Causa: " . $e -> getMessage();
		}
	}

	/**
	 * Inventario -- tabla ILocalUsers  / 1 sola fila por Equipo
	 * insertar una fila por cada cuenta que traiga el arreglo
	 * @param $contadorProgramas    Contador de posiciones del arreglo de la primera dimension (tamaño variable - index +1)
	 * @param $arraySoftware        Arreglo de 2 dimensiones; la segunda dimension  (tamaño fijo)
	 */
	public static function insertarSoftware($equipoInfoId, $contadorProgramas, $arraySoftware, $legacyNumber){
		try {
			$connection = Database::instance();

			$count=0;
			$string = "";

			/* lo que hará division de linea */
			$enter = "$%";

			for ( $i = 0; $i < $contadorProgramas; $i++ ){

				$a       = $arraySoftware[$i]["Caption"];
				$b       = $arraySoftware[$i]["InstallDate"];
				$version = $arraySoftware[$i]["Version"];

				$fecha = Utils::arreglarFecha($b);

				$string .= " " . $a . " | Version: " . $version . " | Instalado: " . $fecha . $enter;
				
				$count++;
			}
			
			$sql = ""; $bool = false;

			if ( $legacyNumber < 0 ){
				$sql = " INSERT INTO ISoftware( equipoInfoId, cantidad, programas) VALUES ( ?, ?, ? ) ";

			} else {
				$sql = " INSERT INTO ISoftware( equipoInfoId, cantidad, programas, legacyNumber) VALUES ( ?, ?, ?, ? ) ";

				$bool = true;
			}

			$query = $connection -> prepare($sql);

			/*
			 * insertar en la Base de datos: datatype LONGTEXT (TEXT largo)
			 * y el Texto sera tratado como stream como PARAM_LOB
			 */
			$query -> bindParam(1, $equipoInfoId,   \PDO::PARAM_INT);
			$query -> bindParam(2, $count,          \PDO::PARAM_INT);
			$query -> bindParam(3, $string,         \PDO::PARAM_LOB);

			if ( $bool ){
				$query -> bindParam(4, $legacyNumber, \PDO::PARAM_INT);
			}

			$count = $query -> execute();

			$result = "<br>Se estan procesando " . $count . " entradas de Programas instalados."
					. "<br><b>...¡Procesado correctamente!</b>";

			return $result;

		} catch(\PDOException $e) {
			return "ERROR: leyendo archivo Software.csv -- Causa: " . $e -> getMessage();
		}
	}


	/**
	 * Todos los Equipos de una EMPRESA con sus USUARIOS (si es que lo tiene)
	 */
	public static function getEquiposUsuariosDeEmpresa($companyId){
		try {
			$connection = Database::instance();

			$sql = " SELECT eq.id AS equipoId, eq.codigoBarras, eq.observacionInicial, eq.infoBasica, "
					. "  eq.equipoInfoId, eq.tipoEquipoId, eq.fechaCreacion, eq.linkImagen, "
					. "  u.id AS usuarioId, u.saludo, u.nombre, u.apellido, u.dependencia, "
					. "  teq.nombre AS TipoEquipo "
					. " FROM Equipos eq "
					. " LEFT JOIN TipoEquipos teq ON eq.tipoEquipoId = teq.tipoEquipoId "
					. " LEFT JOIN Usuarios u ON eq.usuarioId = u.id "
					. " WHERE eq.empresaId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $companyId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.getEquiposUsuariosDeEmpresa():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $companyId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * eliminar ASOCIACION de un EQUIPO a un USUARIO
	 */
	public static function eliminarUsuarioDeEquipo($empresaId, $equipoId, $usuarioId){
		try {
			$connection = Database::instance();

			$sql = " UPDATE Equipos SET usuarioId = NULL WHERE empresaId = ? AND usuarioId = ? AND id = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId,  \PDO::PARAM_INT);
			$query -> bindParam(2, $usuarioId,  \PDO::PARAM_INT);
			$query -> bindParam(3, $equipoId,   \PDO::PARAM_INT);
			
			$count = $query -> execute();
			
			/* Cantidad de filas afectadas, se supone que es 1 */
			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.eliminarUsuarioDeEquipo():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId, $equipoId, $usuarioId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Asignar_Equipo_Usuario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}

	/**
	 * crear ASOCIACION de un EQUIPO a un USUARIO
	 */
	public static function asociarUsuarioAEquipo($empresaId, $equipoId, $usuarioId){
		try {
			$connection = Database::instance();

			$sql = " UPDATE Equipos SET usuarioId = ? WHERE empresaId = ? AND id = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $usuarioId,  \PDO::PARAM_INT);
			$query -> bindParam(2, $empresaId,  \PDO::PARAM_INT);
			$query -> bindParam(3, $equipoId,   \PDO::PARAM_INT);
			
			$count = $query -> execute();
			
			/* Cantidad de filas afectadas, se supone que es 1 */
			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.asociarUsuarioAEquipo():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId, $equipoId, $usuarioId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Asignar_Equipo_Usuario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}


	/**
	 * Solamente actualiza el campo infoBasica
	 * @param $tipo: "concat" es concatenar con la info anterior; "new" es reemplazar
	 */
	public static function actualizarInfoBasica($equipoId, $texto, $tipo){
		try {
			$connection = Database::instance();

			$sql = '';
			if ( $tipo == "concat" ){
				/*
				 * Se comentó para que no se sobrescribiera la info incial que se hace en el 
				 * levantamiento de informacion de inventario
				 *
					$sql = ' UPDATE Equipos eq SET eq.infoBasica = concat_ws(" ", eq.infoBasica, ? ) WHERE eq.id = ? ';
				 */
				return 1;
			
			} else if ( $tipo == "new" ){
				$sql = ' UPDATE Equipos eq SET eq.infoBasica = ? WHERE eq.id = ? ';
			}

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $texto,      \PDO::PARAM_STR);
			$query -> bindParam(2, $equipoId,   \PDO::PARAM_INT);
			
			$count = $query -> execute();
			
			/* Cantidad de filas afectadas, se supone que es 1 */
			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.actualizarInfoBasica():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoId, $texto, $tipo";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}



	/***********************************************************************************************************
	 * Busqueda de la info en tabla: IOS
	 */
	public static function inventarioOS( $equipoInfoId ){
		try {
			$connection = Database::instance();

			$sql = " SELECT os.* FROM IOS os WHERE os.equipoInfoId = ? AND isLegacy = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$f = false;
			$query -> bindParam(2, $f, \PDO::PARAM_BOOL);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.inventarioOS():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}

	/**
	 * Busqueda de la info en tabla: ICPU
	 */
	public static function inventarioCPU( $equipoInfoId ){
		try {
			$connection = Database::instance();

			$sql = " SELECT cpu.* FROM ICPU cpu WHERE isLegacy = ? AND cpu.cpuId IN " 
					. " (SELECT ei.cpuId FROM EquipoInfo ei WHERE ei.equipoInfoId = ? ) ";

			$query = $connection -> prepare($sql);

			$f = false;
			$query -> bindParam(1, $f, \PDO::PARAM_BOOL);

			$query -> bindParam(2, $equipoInfoId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.inventarioCPU():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}

	/**
	 * Busqueda de la info en tabla: IMotherboard
	 */
	public static function inventarioMotherboard( $equipoInfoId ){
		try {
			$connection = Database::instance();

			$sql = " SELECT mb.* FROM IMotherBoard mb WHERE isLegacy = ? AND mb.motherboardId IN "
					. " (SELECT ei.motherboardId FROM EquipoInfo ei WHERE ei.equipoInfoId = ? ) ";

			$query = $connection -> prepare($sql);

			$f = false;
			$query -> bindParam(1, $f, \PDO::PARAM_BOOL);

			$query -> bindParam(2, $equipoInfoId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.inventarioMotherboard():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}


	/**
	 * Busqueda de la info en tabla: IRAM
	 */
	public static function inventarioRAM( $equipoInfoId ){
		try {
			$connection = Database::instance();

			$sql = " SELECT ram.* FROM IRAM ram WHERE ram.equipoInfoId = ? AND isLegacy = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$f = false;
			$query -> bindParam(2, $f, \PDO::PARAM_BOOL);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.inventarioRAM():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}

	/**
	 * Busqueda de la info en tabla: ILocalUsers
	 */
	public static function inventarioLocalUsers( $equipoInfoId ){
		try {
			$connection = Database::instance();

			$sql = " SELECT lu.* FROM ILocalUsers lu WHERE lu.equipoInfoId = ? AND isLegacy = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$f = false;
			$query -> bindParam(2, $f, \PDO::PARAM_BOOL);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.inventarioLocalUsers():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}

	/**
	 * Busqueda de la info en tabla: IHardDrives
	 */
	public static function inventarioHardDrives( $equipoInfoId ){
		try {
			$connection = Database::instance();

			$sql = " SELECT hd.* FROM IHardDrives hd WHERE hd.equipoInfoId = ? AND isLegacy = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$f = false;
			$query -> bindParam(2, $f, \PDO::PARAM_BOOL);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.inventarioHardDrives():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}
	
	/**
	 * Busqueda de la info en tabla: ISound
	 */
	public static function inventarioSound( $equipoInfoId ){
		try {
			$connection = Database::instance();

			$sql = " SELECT so.* FROM ISound so WHERE so.equipoInfoId = ? AND isLegacy = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$f = false;
			$query -> bindParam(2, $f, \PDO::PARAM_BOOL);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.inventarioSound():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}
	
	/**
	 * Busqueda de la info en tabla: IVideo
	 */
	public static function inventarioVideo( $equipoInfoId ){
		try {
			$connection = Database::instance();

			$sql = " SELECT vi.* FROM IVideo vi WHERE vi.equipoInfoId = ? AND isLegacy = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$f = false;
			$query -> bindParam(2, $f, \PDO::PARAM_BOOL);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.inventarioVideo():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}
	
	/**
	 * Busqueda de la info en tabla: INetworking
	 */
	public static function inventarioNetworking( $equipoInfoId ){
		try {
			$connection = Database::instance();

			$sql = " SELECT net.* FROM INetworking net WHERE net.equipoInfoId = ? AND isLegacy = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$f = false;
			$query -> bindParam(2, $f, \PDO::PARAM_BOOL);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.inventarioNetworking():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}
	
	/**
	 * Busqueda de la info en tabla: ISMART
	 */
	public static function inventarioSmart( $equipoInfoId ){
		try {
			$connection = Database::instance();

			$sql = " SELECT sm.* FROM ISMART sm WHERE sm.equipoInfoId = ? AND isLegacy = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$f = false;
			$query -> bindParam(2, $f, \PDO::PARAM_BOOL);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.inventarioSmart():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}


	/**
	 * Busqueda de Equipos que coincidan con este texto en Usuario, Empresa o Codigo de Barras
	 */
	public static function searchEquipos($stringAbuscar){
		try {
			$connection = Database::instance();

			$a = $stringAbuscar;

			$sql = " SELECT eq.*, teq.nombre AS TipoEquipo, "
					. " us.nombre as NombreUsuarioAsignado, us.apellido as ApellidoUsuarioAsignado, us.dependencia as dependencia, "
					. " em.nombre as NombreEmpresa, em.razonSocial "
					. " FROM Equipos eq "
					. " LEFT JOIN TipoEquipos teq ON eq.tipoEquipoId = teq.tipoEquipoId "
					. " LEFT JOIN Usuarios us ON eq.usuarioId = us.id "
					. " LEFT JOIN Empresas em ON eq.empresaId = em.empresaId ";

			/**
			 * Evalua 1º si es un integer
			 * 2º evalua si su tamaño es 10 -- @see this.getIdCodigoBarras()
			 */
			if ( is_numeric($a) && strlen($a) == 10 ){
				$sql .= " WHERE eq.codigoBarras = '" . $a . "' ";

			} else if ( is_numeric($a) ){
				$sql .= " WHERE eq.id = " . $a . " ";

			} else {
				$sql .= " WHERE eq.usuarioId IN "
						. " ( SELECT u.id FROM Usuarios u WHERE u.nombre LIKE '%".$a."%' OR u.apellido LIKE '%".$a."%' ) "
						. " OR eq.empresaId IN "
						. " ( SELECT co.empresaId FROM Empresas co WHERE co.nombre LIKE '%".$a."%' OR co.razonSocial LIKE '%".$a."%' ) "
						. " OR eq.codigoBarras LIKE '%".$a."%' ";
			}

			$query = $connection -> prepare($sql);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.searchEquipos():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$textoDeBusqueda";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}


	/**
	 * Busqueda de la info faltante para redirigir desde CREAR INVENTARIO DESDE CERO
	 */
	public static function usuarioYempresaDadoEquipo( $equipoId ){
		try {
			$connection = Database::instance();

			$sql = " SELECT co.nombre AS Empresa, co.razonSocial, u.nombre, u.apellido "
					. " FROM Equipos eq "
					. " LEFT JOIN Empresas co ON eq.empresaId = co.empresaId "
					. " LEFT JOIN Usuarios u ON eq.usuarioId = u.id "
					. " WHERE eq.id = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetch( \PDO::FETCH_OBJ );

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.usuarioYempresaDadoEquipo():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}


	/**
	 * Update Id y contraseña del TeamViewer de UN Equipo
	 */
	public static function actualizarTeamviewerDeEquipo( $equipoId, $teamViewerID, $teamViewerClave ){
		try {
			$connection = Database::instance();

			$sql = " UPDATE Equipos SET teamViewer_Id = ?, teamViewer_clave = ? WHERE id = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $teamViewerID,       \PDO::PARAM_INT);
			$query -> bindParam(2, $teamViewerClave,    \PDO::PARAM_STR);
			$query -> bindParam(3, $equipoId,           \PDO::PARAM_INT);
			
			$count = $query -> execute();
			
			/* Cantidad de filas afectadas, se supone que es 1 */
			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.actualizarTeamviewerDeEquipo():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoId, $teamViewerID, $teamViewerClave";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}


	/**
	 ************************************************************************************************************
	 ************************************************************************************************************
	 * .CSV: CPU
	 * Actualizando el valor que YA está, volviendolo legacy, es decir, ya NO será el valor actual
	 * @param $equipoInfoId 
	 * @return Object :: Legacy
	 */
	public static function cpuGetLegacyNumberAndSetTrue($equipoInfoId){
		try {
			/* Proceso 1 obtener el legacyNumber */
			$connection = Database::instance();

			$sql = " SELECT cpu.legacyNumber, cpu.cpuId FROM ICPU cpu WHERE cpu.cpuId IN "
					. " ( SELECT ei.cpuId FROM EquipoInfo ei WHERE ei.equipoInfoId = ? ) ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$query -> execute();

			$result = $query -> fetch( \PDO::FETCH_OBJ );

			/* Proceso 2: transformar en legacy el valor actual */
			$sql2 = " UPDATE ICPU cpu SET cpu.isLegacy = TRUE WHERE cpu.cpuId IN "
					. " ( SELECT ei.cpuId FROM EquipoInfo ei WHERE ei.equipoInfoId = ? ) ";

			$query2 = $connection -> prepare($sql2);

			$query2 -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);
			
			$count = $query2 -> execute();

			return $result;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.cpuGetLegacyNumberAndSetTrue():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}


	/**
	 * .CSV: Motherboard
	 * Actualizando el valor que YA está, volviendolo legacy, es decir, ya NO será el valor actual
	 * @param $equipoInfoId 
	 * @return Object :: Legacy
	 */
	public static function motherboardGetLegacyNumberAndSetTrue($equipoInfoId){
		try {
			/* Proceso 1 obtener el legacyNumber */
			$connection = Database::instance();

			$sql = " SELECT mb.legacyNumber, mb.motherboardId FROM IMotherBoard mb WHERE mb.motherboardId IN "
					. " ( SELECT ei.motherboardId FROM EquipoInfo ei WHERE ei.equipoInfoId = ? ) ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$query -> execute();

			$result = $query -> fetch( \PDO::FETCH_OBJ );

			/* Proceso 2: transformar en legacy el valor actual */
			$sql2 = " UPDATE IMotherBoard mb SET mb.isLegacy = TRUE WHERE mb.motherboardId IN "
					. " ( SELECT ei.motherboardId FROM EquipoInfo ei WHERE ei.equipoInfoId = ? ) ";

			$query2 = $connection -> prepare($sql2);

			$query2 -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);
			
			$count = $query2 -> execute();

			return $result;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.motherboardGetLegacyNumberAndSetTrue():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}


	/**
	 * .CSV: RAM
	 * Actualizando el valor que YA está, volviendolo legacy, es decir, ya NO será el valor actual
	 * @param $equipoInfoId 
	 * @return Array :: Legacy
	 */
	public static function ramGetLegacyNumberAndSetTrue($equipoInfoId){
		try {
			/* Proceso 1 obtener el legacyNumber */
			$connection = Database::instance();

			$sql = " SELECT ram.legacyNumber, ram.id FROM IRAM ram WHERE ram.equipoInfoId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$query -> execute();

			$result = $query -> fetchAll();

			/* Proceso 2: transformar en legacy el valor actual */
			$sql2 = " UPDATE IRAM ram SET ram.isLegacy = TRUE WHERE ram.equipoInfoId = ? ";

			$query2 = $connection -> prepare($sql2);

			$query2 -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);
			
			$count = $query2 -> execute();

			return $result;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.ramGetLegacyNumberAndSetTrue():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}

	/**
	 *.CSV: Hard drives
	 * Actualizando el valor que YA está, volviendolo legacy, es decir, ya NO será el valor actual
	 * @param $equipoInfoId 
	 * @return Array :: Legacy
	 */
	public static function hardDrivesGetLegacyNumberAndSetTrue($equipoInfoId){
		try {
			/* Proceso 1 obtener el legacyNumber */
			$connection = Database::instance();

			$sql = " SELECT hd.legacyNumber, hd.id FROM IHardDrives hd WHERE hd.equipoInfoId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$query -> execute();

			$result = $query -> fetchAll();

			/* Proceso 2: transformar en legacy el valor actual */
			$sql2 = " UPDATE IHardDrives hd SET hd.isLegacy = TRUE WHERE hd.equipoInfoId = ? ";

			$query2 = $connection -> prepare($sql2);

			$query2 -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);
			
			$count = $query2 -> execute();

			return $result;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.hardDrivesGetLegacyNumberAndSetTrue():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}

	/**
	 *.CSV: SMART
	 * Actualizando el valor que YA está, volviendolo legacy, es decir, ya NO será el valor actual
	 * @param $equipoInfoId 
	 * @return Array :: Legacy
	 */
	public static function smartGetLegacyNumberAndSetTrue($equipoInfoId){
		try {
			/* Proceso 1 obtener el legacyNumber */
			$connection = Database::instance();

			$sql = " SELECT sm.legacyNumber, sm.id FROM ISMART sm WHERE sm.equipoInfoId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$query -> execute();

			$result = $query -> fetchAll();

			/* Proceso 2: transformar en legacy el valor actual */
			$sql2 = " UPDATE ISMART sm SET sm.isLegacy = TRUE WHERE sm.equipoInfoId = ? ";

			$query2 = $connection -> prepare($sql2);

			$query2 -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);
			
			$count = $query2 -> execute();

			return $result;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.smartGetLegacyNumberAndSetTrue():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}

	/**
	 *.CSV: LocalUsers
	 * Actualizando el valor que YA está, volviendolo legacy, es decir, ya NO será el valor actual
	 * @param $equipoInfoId 
	 * @return Array :: Legacy
	 */
	public static function localUsersGetLegacyNumberAndSetTrue($equipoInfoId){
		try {
			/* Proceso 1 obtener el legacyNumber */
			$connection = Database::instance();

			$sql = " SELECT lu.legacyNumber, lu.id FROM ILocalUsers lu WHERE lu.equipoInfoId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$query -> execute();

			$result = $query -> fetchAll();

			/* Proceso 2: transformar en legacy el valor actual */
			$sql2 = " UPDATE ILocalUsers lu SET lu.isLegacy = TRUE WHERE lu.equipoInfoId = ? ";

			$query2 = $connection -> prepare($sql2);

			$query2 -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);
			
			$count = $query2 -> execute();

			return $result;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.localUsersGetLegacyNumberAndSetTrue():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}

	/**
	 *.CSV: Sound
	 * Actualizando el valor que YA está, volviendolo legacy, es decir, ya NO será el valor actual
	 * @param $equipoInfoId 
	 * @return Array :: Legacy
	 */
	public static function soundGetLegacyNumberAndSetTrue($equipoInfoId){
		try {
			/* Proceso 1 obtener el legacyNumber */
			$connection = Database::instance();

			$sql = " SELECT so.legacyNumber, so.id FROM ISound so WHERE so.equipoInfoId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$query -> execute();

			$result = $query -> fetchAll();

			/* Proceso 2: transformar en legacy el valor actual */
			$sql2 = " UPDATE ISound so SET so.isLegacy = TRUE WHERE so.equipoInfoId = ? ";

			$query2 = $connection -> prepare($sql2);

			$query2 -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);
			
			$count = $query2 -> execute();

			return $result;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.soundGetLegacyNumberAndSetTrue():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}

	/**
	 *.CSV: Networking
	 * Actualizando el valor que YA está, volviendolo legacy, es decir, ya NO será el valor actual
	 * @param $equipoInfoId 
	 * @return Array :: Legacy
	 */
	public static function networkingGetLegacyNumberAndSetTrue($equipoInfoId){
		try {
			/* Proceso 1 obtener el legacyNumber */
			$connection = Database::instance();

			$sql = " SELECT net.legacyNumber, net.id FROM INetworking net WHERE net.equipoInfoId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$query -> execute();

			$result = $query -> fetchAll();

			/* Proceso 2: transformar en legacy el valor actual */
			$sql2 = " UPDATE INetworking net SET net.isLegacy = TRUE WHERE net.equipoInfoId = ? ";

			$query2 = $connection -> prepare($sql2);

			$query2 -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);
			
			$count = $query2 -> execute();

			return $result;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.networkingGetLegacyNumberAndSetTrue():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}

	/**
	 *.CSV: Video
	 * Actualizando el valor que YA está, volviendolo legacy, es decir, ya NO será el valor actual
	 * @param $equipoInfoId 
	 * @return Array :: Legacy
	 */
	public static function videoGetLegacyNumberAndSetTrue($equipoInfoId){
		try {
			/* Proceso 1 obtener el legacyNumber */
			$connection = Database::instance();

			$sql = " SELECT vi.legacyNumber, vi.id FROM IVideo vi WHERE vi.equipoInfoId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$query -> execute();

			$result = $query -> fetchAll();

			/* Proceso 2: transformar en legacy el valor actual */
			$sql2 = " UPDATE IVideo vi SET vi.isLegacy = TRUE WHERE vi.equipoInfoId = ? ";

			$query2 = $connection -> prepare($sql2);

			$query2 -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);
			
			$count = $query2 -> execute();

			return $result;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.videoGetLegacyNumberAndSetTrue():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}

	/**
	 *.CSV: OS
	 * Actualizando el valor que YA está, volviendolo legacy, es decir, ya NO será el valor actual
	 * @param $equipoInfoId 
	 * @return Object :: Legacy
	 */
	public static function osGetLegacyNumberAndSetTrue($equipoInfoId){
		try {
			/* Proceso 1 obtener el legacyNumber */
			$connection = Database::instance();

			$sql = " SELECT os.legacyNumber, os.osId FROM IOS os WHERE os.equipoInfoId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$query -> execute();

			$result = $query -> fetch( \PDO::FETCH_OBJ );

			/* Proceso 2: transformar en legacy el valor actual */
			$sql2 = " UPDATE IOS os SET os.isLegacy = TRUE WHERE os.equipoInfoId = ? ";

			$query2 = $connection -> prepare($sql2);

			$query2 -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);
			
			$count = $query2 -> execute();

			return $result;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.osGetLegacyNumberAndSetTrue():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}

	/**
	 *.CSV: Software
	 * Actualizando el valor que YA está, volviendolo legacy, es decir, ya NO será el valor actual
	 * @param $equipoInfoId 
	 * @return Object :: Legacy
	 */
	public static function softwareGetLegacyNumberAndSetTrue($equipoInfoId){
		try {
			/* Proceso 1 obtener el legacyNumber */
			$connection = Database::instance();

			$sql = " SELECT sof.legacyNumber, sof.id FROM ISoftware sof WHERE sof.equipoInfoId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

			$query -> execute();

			$result = $query -> fetch( \PDO::FETCH_OBJ );

			/* Proceso 2: transformar en legacy el valor actual */
			$sql2 = " UPDATE ISoftware sof SET sof.isLegacy = TRUE WHERE sof.equipoInfoId = ? ";

			$query2 = $connection -> prepare($sql2);

			$query2 -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);
			
			$count = $query2 -> execute();

			return $result;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.softwareGetLegacyNumberAndSetTrue():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}


	/**
	 *************************************************************************************************************
	 *************************************************************************************************************
	 * Actualizar solo la tabla 'EquipoInfo'
	 */
	public static function updateEquipoInfo2campos($equipoInfoId, $newMAX_ID, $campoAactualizar){
		try {
			$connection = Database::instance();

			$sql="";
			if ( $campoAactualizar == "CPU"){
				$sql = " UPDATE EquipoInfo SET cpuId = ? WHERE equipoInfoId = ? ";

			} else if ( $campoAactualizar == "Motherboard"){
				$sql = " UPDATE EquipoInfo SET motherboardId = ? WHERE equipoInfoId = ? ";
			}

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $newMAX_ID,      \PDO::PARAM_INT);
			$query -> bindParam(2, $equipoInfoId,   \PDO::PARAM_INT);
			
			$count = $query -> execute();
			
			/* Cantidad de filas afectadas, se supone que es 1 */
			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.updateEquipoInfo2campos():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$equipoInfoId, $newMAX_ID, $campoAactualizar";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}


	/**
	 **************************************************************************************************************
	 * INSERTAR nueva entrada en la tabla 'EquipoInfoHistorial'
	 * @param INT: $cpuId, $motherboardId
	 * @param STRING: los demas ID's, al estilo csv: "1,23,456"
	 */
	public static function insertInventarioHistorial($equipoId, $equipoInfoId, $legacyNumber,
			$cpuId, $motherboardId,
			$ramIds, $hardDriveIds, $smartIds, $localUsersIds, $soundIds, 
			$networkingIds, $videoIds, $osIds, $softwareIds ){

		try {
			$connection = Database::instance();

			$sql = " INSERT INTO EquipoInfoHistorial ( equipoId, equipoInfoId, legacyNumber, cpuId, motherBoardId, "
					. " ramIds, hardDrivesIds, smartIds, localUsersIds, soundIds, networkingIds, videoIds, osIds, softwareIds ) "
					. " VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ) ";

			$query = $connection -> prepare($sql);

			/**/
			$query -> bindParam(1, $equipoId,       \PDO::PARAM_INT);
			$query -> bindParam(2, $equipoInfoId,   \PDO::PARAM_INT);
			$query -> bindParam(3, $legacyNumber,   \PDO::PARAM_INT);

			/* INT */
			$query -> bindParam(4, $cpuId,          \PDO::PARAM_INT);
			$query -> bindParam(5, $motherboardId,  \PDO::PARAM_INT);

			/* STRING */
			$query -> bindParam(6, $ramIds,         \PDO::PARAM_STR);
			$query -> bindParam(7, $hardDriveIds,   \PDO::PARAM_STR);
			$query -> bindParam(8, $smartIds,       \PDO::PARAM_STR);
			$query -> bindParam(9, $localUsersIds,  \PDO::PARAM_STR);
			$query -> bindParam(10,$soundIds,       \PDO::PARAM_STR);
			$query -> bindParam(11,$networkingIds,  \PDO::PARAM_STR);
			$query -> bindParam(12,$videoIds,       \PDO::PARAM_STR);
			$query -> bindParam(13,$osIds,          \PDO::PARAM_STR);
			$query -> bindParam(14,$softwareIds,    \PDO::PARAM_STR);

			$count = $query -> execute();
			
			/* Cantidad de filas afectadas, se supone que es 1 */
			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.insertInventarioHistorial():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "equipo:$equipoId, equipoInfoId:$equipoInfoId, LegacyNumber:$legacyNumber, "
					. "| IDs: cpu:$cpuId, mb:$motherboardId - "
					. "RAM's: $ramIds .:. HardDrives: $hardDriveIds .:. SMART: $smartIds .:. LocalUsersIds: $localUsersIds .:. "
					. "Sounds: $soundIds .:. Net's:$networkingIds .:. Video:$videoIds .:. OS:$osIds .:. Software:$softwareIds";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}

	/**
	 * Busqueda de Equipos que coincidan con este texto en Usuario, Empresa o Codigo de Barras
	 */
	public static function searchEquipos2($stringAbuscar, $tipoEquipo){
		try {
			$connection = Database::instance();

			$a = $stringAbuscar;

			$sql = " SELECT eq.*, teq.nombre AS TipoEquipo, 
					us.nombre as NombreUsuarioAsignado, us.apellido as ApellidoUsuarioAsignado, us.dependencia as dependencia, 
					em.nombre as NombreEmpresa, em.razonSocial 
					FROM Equipos eq 
					LEFT JOIN TipoEquipos teq ON eq.tipoEquipoId = teq.tipoEquipoId 
					LEFT JOIN Usuarios us ON eq.usuarioId = us.id 
					LEFT JOIN Empresas em ON eq.empresaId = em.empresaId ";
			
			if ( $stringAbuscar == NULL || $a == "" ){
				/* NO añadir clausula WHERE */

			} else if ( is_numeric($a) && strlen($a) == 10 ){
				/**
				 * Evalua 1º si es un integer
				 * 2º evalua si su tamaño es 10 -- @see this.getIdCodigoBarras()
				 */
				$sql .= " WHERE eq.codigoBarras = '" . $a . "' ";

			} else {
				$sql .= " WHERE eq.usuarioId IN "
						. " ( SELECT u.id FROM Usuarios u WHERE u.nombre LIKE '%".$a."%' OR u.apellido LIKE '%".$a."%' OR u.email LIKE '%".$a."%' OR u.usuario LIKE '%".$a."%' ) "
						. " OR eq.empresaId IN "
						. " ( SELECT co.empresaId FROM Empresas co WHERE co.nombre LIKE '%".$a."%' OR co.razonSocial LIKE '%".$a."%' OR co.NIT LIKE '%".$a."%' ) "
						. " OR teq.tipoEquipoId = $tipoEquipo "
						. " OR eq.infoBasica LIKE '%".$a."%' "
						. " OR eq.equipoInfoId IN "
						. " ( SELECT os.equipoInfoId FROM IOS os WHERE os.Caption LIKE '%".$a."%' ) "
						;
			}

			$sql .= " ORDER BY NombreEmpresa ASC, eq.id ASC ";

			$query = $connection -> prepare($sql);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.searchEquipos2():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$stringAbuscar, $tipoEquipo";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}

	/**
	 * Obtener los Perifericos de un Equipo ID
	 */
	public static function getPerifericos($equipoId){
		try {
			$connection = Database::instance();

			$sql = " SELECT ep.*, tp.nombre AS Nombre_Periferico FROM EquipoPerifericos ep "
					. " INNER JOIN TipoPerifericos tp ON ep.tipoPerifericoId = tp.id WHERE ep.equipoId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();
			/* return $query -> fetch( \PDO::FETCH_OBJ ); */

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.getPerifericos():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $equipoId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * UPDATE en la tabla Equipos
	 */
	public static function actualizarEquipo($equipoId, $data){
		try {

			$connection = Database::instance();

			/*
			 * Limpiando version del Sistema Operativo
			 */
			$SOversion = trim($data[18]);
			$SOversion = str_replace(",", ".", $SOversion);
			
			$sql = " UPDATE Equipos SET 
					tipoEquipoId = ?, teamViewer_Id = ?, teamViewer_clave = ?, observacionInicial = ?, infoBasica = ?, 
					nombreEquipo = ?, hddEstado = ?, dependencia = ?, marca = ?, modelo = ?, 
					serial = ?, conexionRemota = ?, claveAdmin = ?, valor = ?, valorReposicion = ?, 
					linkImagen = ?, licWindows = ?, licOffice = ?,
					sistemaOperativo = ?, versionSO = ?, nombreSO = ?
					WHERE id = ? ";

			$query = $connection -> prepare($sql);

			$infoBasica = $data[0];

			/**/
			$query -> bindParam(1, $data[5],	\PDO::PARAM_INT);
			$query -> bindParam(2, $data[6],    \PDO::PARAM_INT);/* teamViewerId */
			$query -> bindParam(3, $data[7],    \PDO::PARAM_STR);
			$query -> bindParam(4, $data[12],   \PDO::PARAM_STR);
			$query -> bindParam(5, $infoBasica, \PDO::PARAM_STR);

			/**/
			$query -> bindParam( 6,  $infoBasica,   \PDO::PARAM_STR);/* nombreEquipo */
			$query -> bindParam( 7,  $data[16],     \PDO::PARAM_STR);
			$query -> bindParam( 8,  $data[1],      \PDO::PARAM_STR);
			$query -> bindParam( 9,  $data[2],      \PDO::PARAM_STR);
			$query -> bindParam(10,  $data[3],      \PDO::PARAM_STR);

			/**/
			$query -> bindParam(11,  $data[4],  \PDO::PARAM_STR);/* serial */
			$query -> bindParam(12,  $data[8],  \PDO::PARAM_STR);
			$query -> bindParam(13,  $data[9],  \PDO::PARAM_STR);
			$query -> bindParam(14,  $data[10], \PDO::PARAM_STR);
			$query -> bindParam(15,  $data[11], \PDO::PARAM_STR);

			/**/
			$query -> bindParam(16,  $data[13], \PDO::PARAM_STR);/* linkDeFoto */
			$query -> bindParam(17,  $data[14], \PDO::PARAM_STR);
			$query -> bindParam(18,  $data[15], \PDO::PARAM_STR);
		
			/**/
			$query -> bindParam(19,  $data[17],  \PDO::PARAM_STR);/* sistemaOperativo */
			$query -> bindParam(20,  $SOversion, \PDO::PARAM_STR);
			$query -> bindParam(21,  $data[19],  \PDO::PARAM_STR);


			/* WHERE */
			$query -> bindParam(22, $equipoId, \PDO::PARAM_INT);

			$count = $query -> execute();

			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.actualizarEquipo():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "equipoId:".$equipoId. " | Object data[]";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * UPDATE en la tabla EquipoPerifericos
	 */
	public static function actualizarPerifericos($equipoId, $perifericos){
		try {
			/*
			 * Para realizar esta acción debemos
			 * PRIMERO: saber si hay Perifericos que actualizar
			 */
			$cantidad = $perifericos[0];
			$count = 0;
			$result =0;

			if ( $cantidad > 0 ){
				/*
				 * SEGUNDO: si es así, ELIMINAR TODOS los que hay
				 */
				$connection = Database::instance();
			
				$sql = " DELETE FROM EquipoPerifericos WHERE equipoId = ? ";

				$query = $connection -> prepare($sql);

				$query -> bindParam(1, $equipoId, \PDO::PARAM_INT);

				$count = $query -> execute();

				if ( $count >= 0 ){
					/*
					 * TERCERO: y agregar todos los que vienen en esta lista
					 */
					$result = Equipos::agregarPerifericos($equipoId, $perifericos);
				}
			}
			return $result;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.actualizarPerifericos():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "equipoId:".$equipoId. " | Object perifericos[]";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	
	/**
	 * Buscar el Historial de CADA Equipo del Arreglo
	 * @param Array [tabla Equipos]
	 * @return  [0] INT el total de Equipos que hay
	 *			[1]Array => [<numero de Equipos>][<Historial de Cada uno>]; ejemplo [0][...], [1][...]
	 * 
	 */
	public static function getHistorialEquipos($equipos){
		try {
			if ( $equipos == NULL || $equipos == "" ){
				return NULL;
			}

			/* contando */
			$cont = 0;
			foreach ( $equipos as $equipo) {

				$result[$cont][0] = $equipo["infoBasica"];
				$result[$cont][1] = $equipo["dependencia"];
				$result[$cont][2] = $equipo["marca"];
				$result[$cont][3] = $equipo["modelo"];
				$result[$cont][4] = $equipo["sistemaOperativo"];
				$result[$cont][5] = $equipo["TipoEquipo"];
				$result[$cont][6] = $equipo["linkImagen"];

				/* Buscando el historial */
				$result[$cont][7] = Transaccion::getHistorial( $equipo["id"] );

				$cont++;
			}

			$data[0] = $cont;
			$data[1] = $result;

			return $data;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.getHistorialEquipos():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = " -- ";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/************************************************************************************************************
	 *  ABAJO: Metodos para Insercion de data Manual cuando falla los Scripts
	 */

	/************************************************************************************************************
	 * Insertar info manualmente cuando falla los SCRIPTS: ICPU
	 * @return cpuId, para insertar en EquipoInfo
	 */
	public static function manualCPU( $marcaProcesador, $referenciaCPU,
			$velocidadCPU, $nucleos, $arquitectura, $cache, $legacyNumber ){
		try {
			/*
			 * 1.- Buscar MAX ID de tabla Inventarios
			 */
			$cpuId = Equipos::getMaxID("ICPU");
			$cpuId++;

			/* 2.- insertar data */
			$connection = Database::instance();

			if ( $legacyNumber > 0 ){
				$sql = " INSERT INTO ICPU( cpuId, AddressWidth, Name, 
						 CurrentClockSpeed, NumberOfCores, L2CacheSize, legacyNumber ) 
						VALUES ( ?, ?, ?, ?, ?, ?, ? ) ";
			} else {
				$sql = " INSERT INTO ICPU( cpuId, AddressWidth, Name, 
						 CurrentClockSpeed, NumberOfCores, L2CacheSize ) 
						VALUES ( ?, ?, ?, ?, ?, ? ) ";
			}

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $cpuId, \PDO::PARAM_INT);
			$query -> bindParam(2, $arquitectura, \PDO::PARAM_INT);

			$aux = $marcaProcesador . " " . $referenciaCPU;
			$query -> bindParam(3, $aux, \PDO::PARAM_STR);

			$query -> bindParam(4, $velocidadCPU,   \PDO::PARAM_INT);
			$query -> bindParam(5, $nucleos, 		\PDO::PARAM_INT);
			$query -> bindParam(6, $cache, 			\PDO::PARAM_INT);
			
			if ( $legacyNumber > 0 ){
				$query -> bindParam(7, $legacyNumber, \PDO::PARAM_INT);	
			}

			$count = $query -> execute();
			
			if ( $count == 1 ){
				return $cpuId;
			} else {
				return -1;
			}

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.manualCPU():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = " $marcaProcesador, $referenciaCPU, $velocidadCPU, $nucleos, $arquitectura, $cache ";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Insertar info manualmente cuando falla los SCRIPTS: IMotherBoard
	 * @return cpuId, para insertar en EquipoInfo
	 */
	public static function manualMotherboard( $referenciaMB, $marcaMB, $legacyNumber ){
		try {
			/*
			 * 1.- Buscar MAX ID de tabla Inventarios
			 */
			$motherBoardId = Equipos::getMaxID("IMotherBoard");
			$motherBoardId++;

			/* 2.- insertar data */
			$connection = Database::instance();

			if ( $legacyNumber > 0 ){
				$sql = " INSERT INTO IMotherBoard( motherboardId, Product, Name, legacyNumber ) 
					  VALUES ( ?, ?, ?, ? ) ";
			} else {
				$sql = " INSERT INTO IMotherBoard( motherboardId, Product, Name ) 
					  VALUES ( ?, ?, ? ) ";
			}

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $motherBoardId,  \PDO::PARAM_INT);
			$query -> bindParam(2, $referenciaMB,   \PDO::PARAM_STR);
			$query -> bindParam(3, $marcaMB, 		\PDO::PARAM_STR);

			if ( $legacyNumber > 0 ){
				$query -> bindParam(4, $legacyNumber, \PDO::PARAM_INT);
			}

			$count = $query -> execute();
			
			if ( $count == 1 ){
				return $motherBoardId;
			} else {
				return -1;
			}

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.manualMotherboard():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = " $referenciaMB, $marcaMB ";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Insertar en EquipoInfo los 2 ID's pasados por paràmetros + EquipoInfoId generado en este metodo
	 * @return equipoInfoId, para insertar en tablas Inventario
	 */
	public static function insertEquipoInfo2( $cpuId, $motherboardId ){
		try {
			/*
			 * 1.- Buscar MAX ID de tabla Inventarios
			 */
			$equipoInfoId = Equipos::getMaxID("EquipoInfo");
			$equipoInfoId++;

			/* 2.- insertar data */
			$connection = Database::instance();

			$sql = " INSERT INTO EquipoInfo( equipoInfoId, cpuId, motherboardId ) VALUES ( ?, ?, ? ) ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoInfoId,   \PDO::PARAM_INT);
			$query -> bindParam(2, $cpuId, 			\PDO::PARAM_INT);
			$query -> bindParam(3, $motherboardId,  \PDO::PARAM_INT);

			$count = $query -> execute();
			
			if ( $count == 1 ){
				return $equipoInfoId;
			} else {
				return -1;
			}

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.insertEquipoInfo2():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = " -- ";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Insertar en IRAM 
	 * @return cantidad de RAM's insertadas
	 */
	public static function manualRAM( $equipoInfoId, $cantidadRAMs, $ram_tipo, $ram_tamanyoGb, $ram_velocidad, $legacyNumber ){
		try {
			$connection = Database::instance();

			if ( $legacyNumber > 0 ){
				$sql = " INSERT INTO IRAM( equipoInfoId, Capacity, MemoryType, Speed, BankLabel, legacyNumber ) 
						VALUES ( ?, ?, ?, ?, ?, ? ) ";
			} else {
				$sql = " INSERT INTO IRAM( equipoInfoId, Capacity, MemoryType, Speed, BankLabel ) 
						VALUES ( ?, ?, ?, ?, ? ) ";
			}
			
			$count = 0;
			$auxGb = 0;

			/*
			 * separando los valores CSV
			 */
			$arrayTipo      = explode(",", $ram_tipo);
			$arrayTamanyo   = explode(",", $ram_tamanyoGb);
			$arrayVelocidad = explode(",", $ram_velocidad);
			
			for ( $i = 0; $i < $cantidadRAMs; $i++ ){

				$query = $connection -> prepare($sql);

				$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);
				
				/* viene en GigaBytes, transformar a bytes */
				$auxGb = ((( $arrayTamanyo[$i] + 0 ) * 1024) * 1024) * 1024;
				$query -> bindParam(2, $auxGb, \PDO::PARAM_INT);
				$auxGb = 0;

				$query -> bindParam(3, $arrayTipo[$i],  	\PDO::PARAM_STR);
				$query -> bindParam(4, $arrayVelocidad[$i], \PDO::PARAM_INT);

				$bank = "BANK_" . $i;
				$query -> bindParam(5, $bank,  \PDO::PARAM_STR);

				if ( $legacyNumber > 0 ){
					$query -> bindParam(6, $legacyNumber, \PDO::PARAM_INT);
				}

				$count += $query -> execute();
			}

			return $count;
			
		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.manualRAM():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = " $equipoInfoId -- $cantidadRAMs, $ram_tipo, $ram_tamanyoGb, $ram_velocidad";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}	
	}

	
	/**
	 * Insertar en IHardDrives
	 * @return cantidad de HDD's insertadas
	 */
	public static function manualHDD( $equipoInfoId, $cantidadHDDs, $hdd_marca, $hdd_tamanyoGb, $hdd_interfaz, $legacyNumber ){
		try {
			$connection = Database::instance();

			if ( $legacyNumber > 0 ){
				$sql = " INSERT INTO IHardDrives( equipoInfoId, Model, Size, InterfaceType, DriveLetter, legacyNumber )
						VALUES ( ?, ?, ?, ?, ?, ? )  ";
			} else {
				$sql = " INSERT INTO IHardDrives( equipoInfoId, Model, Size, InterfaceType, DriveLetter )
						VALUES ( ?, ?, ?, ?, ? )  ";
			}

			/* insertando data obligatoria */
			$auxNull = NULL;
			$count = 0;
			$auxGb = 0; $auxS = "";
			/*
			 * separando los valores CSV
			 */
			$arrayMarca     = explode(",", $hdd_marca);
			$arrayTamanyo   = explode(",", $hdd_tamanyoGb);
			$arrayInterface = explode(",", $hdd_interfaz);

			for ( $i = 0; $i < $cantidadHDDs; $i++ ){

				$query = $connection -> prepare($sql);

				$query -> bindParam(1, $equipoInfoId,   	\PDO::PARAM_INT);
				$query -> bindParam(2, $arrayMarca[$i], 	\PDO::PARAM_STR);
				
				/* viene en GigaBytes, transformar a bytes */
				$auxGb = ((( $arrayTamanyo[$i] + 0 ) * 1024) * 1024) * 1024;
				$auxS  = "" . $auxGb;
				$query -> bindParam(3, $auxS, \PDO::PARAM_STR);

				$query -> bindParam(4, $arrayInterface[$i], \PDO::PARAM_STR);
				$query -> bindParam(5, $auxNull,  			\PDO::PARAM_STR);

				if ( $legacyNumber > 0 ){
					$query -> bindParam(6, $legacyNumber, \PDO::PARAM_INT);
				}

				$count += $query -> execute();
			}

			return $count;
			
		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.manualHDD():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = " $equipoInfoId -- $cantidadHDDs, $hdd_marca, $hdd_tamanyoGb, $hdd_interfaz";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Insertar en IOS
	 * @return cantidad insertada
	 */
	public static function manualIOS( $equipoInfoId, $nombreWindows, $so, $legacyNumber ){
		try {
			$connection = Database::instance();

			if ( $legacyNumber > 0 ){
				$sql = " INSERT INTO IOS( equipoInfoId, Caption, CSName, Workgroup, legacyNumber ) VALUES ( ?, ?, ?, ?, ? ) ";
			} else {
				$sql = " INSERT INTO IOS( equipoInfoId, Caption, CSName, Workgroup ) VALUES ( ?, ?, ?, ? ) ";
			}

			$query = $connection -> prepare($sql);
			
			/*
			 * Limpiar data si es Windows o linux
			 */
			$aux = "";
			if ( $nombreWindows == NULL || $nombreWindows == "" ){
				$aux = $so;
			} else {
				$aux = $nombreWindows;
			}

			$query -> bindParam(1, $equipoInfoId,   \PDO::PARAM_INT);
			$query -> bindParam(2, $aux, 			\PDO::PARAM_STR);

			$na = "N/R";
			$query -> bindParam(3, $na,	\PDO::PARAM_STR);
			$query -> bindParam(4, $na,	\PDO::PARAM_STR);

			if ( $legacyNumber > 0 ){
				$query -> bindParam(5, $legacyNumber, \PDO::PARAM_INT);
			}

			$count = $query -> execute();
			
			return $count;
			
		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.manualIOS():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = " $equipoInfoId -- $nombreWindows ** $so";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Insertar en ISMART
	 * @return cantidad insertada
	 */
	public static function manualSMART( $equipoInfoId, $cantidadHDDs, $hdd_marca, $hdd_horasuso, $legacyNumber){
		try {
			$connection = Database::instance();

			if ( $legacyNumber > 0 ){
				$sql = " INSERT INTO ISMART( equipoInfoId, Power_on_hours_1, Serial, Model, legacyNumber ) VALUES ( ?, ?, ?, ?, ? ) ";
			} else {
				$sql = " INSERT INTO ISMART( equipoInfoId, Power_on_hours_1, Serial, Model ) VALUES ( ?, ?, ?, ? ) ";
			}

			$na = "N/R"; $count = 0;
			/*
			 * separando los valores CSV
			 */
			$arrayMarca = explode(",", $hdd_marca);
			$arrayHoras = explode(",", $hdd_horasuso);

			for ( $i = 0; $i < $cantidadHDDs; $i++ ){

				$query = $connection -> prepare($sql);

				$query -> bindParam(1, $equipoInfoId, \PDO::PARAM_INT);

				$query -> bindParam(2, $arrayHoras[$i], \PDO::PARAM_INT);
				
				$query -> bindParam(3, $na,	\PDO::PARAM_STR);

				$query -> bindParam(4, $arrayMarca[$i],	\PDO::PARAM_STR);

				if ( $legacyNumber > 0 ){
					$query -> bindParam(5, $legacyNumber, \PDO::PARAM_INT);
				}

				$count += $query -> execute();
			}
			
			return $count;
			
		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.manualSMART():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = " $equipoInfoId -- $hdd_horasuso";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Actualizar con el mismo EquipoInfoId los nuevos ID's CPU y MB
	 */
	public static function actualizarEquipoInfo( $equipoInfoId, $cpuId, $motherboardId ){
		try {
			$connection = Database::instance();

			$sql = " UPDATE EquipoInfo SET cpuId = ?, motherboardId = ? WHERE equipoInfoId = ? ";
			
			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $cpuId, 			\PDO::PARAM_INT);
			$query -> bindParam(2, $motherboardId,  \PDO::PARAM_INT);
			$query -> bindParam(3, $equipoInfoId, 	\PDO::PARAM_INT);

			$count = $query -> execute();
			
			return $count;
			
		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.actualizarEquipoInfo():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = " $equipoInfoId -- $cpuId -- $motherboardId ";
			
			/**/
			Transaccion::insertTransaccionPDOException("Tecnico_Actualizar_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",  $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

}