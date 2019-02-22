<?php
namespace app\models;
defined("APPPATH") OR die("Access denied");

use \core\View,
	\core\Database,
	\app\models\admin\user as UserAdmin,
	\app\models\Utils,
	\app\models\admin\Transaccion,
	\app\models\Equipos;

class Incidencias {
	
	/**
	 * Filtros genericos
	 */
	private static $FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO = " AND ( eq.estatus <> 'Suspendido' OR eq.estatus IS NULL ) ";


	/**
	 * Crea una NUEVA INCIDENCIA
	 * @param $jsonString para el campo Incidencias.datosConexionRemota
	 * @return incidenciaId
	 */ 
	public static function insert($userId, $equipoIdIncidencia, $tipoFalla, 
			$observaciones, $empresaId, $jsonString) {
		try {
			$connection = Database::instance();

			$usuarioId="";

			/*
			 * Si reportan la Incidencia por Equipo, no se quede sin registrar SU USUARIO en la BD
			 */
			if ( $userId == "" ){
				$resultado = UserAdmin::getUserIdByEquipoId($equipoIdIncidencia);
				$usuarioId = $resultado["usuarioId"];

			} else {
				$usuarioId = $userId;
			}

			/* Buscando el ID a insertar */
			$incidenciaId = Equipos::getMaxID("Incidencias");
			$incidenciaId++;

			$sql = " INSERT INTO Incidencias ( "
				. " usuarioId, equipoId, fallaId, observaciones, status, empresaId, incidenciaId, datosConexionRemota )" 
				. " VALUES ( ?, ?, ?, ?, ?, ?, ?, ? ) ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $usuarioId, \PDO::PARAM_INT);
			
			if ( $equipoIdIncidencia == NULL ){
				$nulo = NULL;
				$query -> bindParam(2, $nulo, \PDO::PARAM_INT);
			} else {
				$query -> bindParam(2, $equipoIdIncidencia, \PDO::PARAM_INT);
			}

			$query -> bindParam(3, $tipoFalla, \PDO::PARAM_INT);
			$query -> bindParam(4, $observaciones, \PDO::PARAM_STR);
			
			$status = "Abierta";
			$query -> bindParam(5, $status, \PDO::PARAM_STR);

			$query -> bindParam(6, $empresaId,    \PDO::PARAM_INT);
			$query -> bindParam(7, $incidenciaId, \PDO::PARAM_INT);
			$query -> bindParam(8, $jsonString,   \PDO::PARAM_STR);
			
			$count = $query -> execute();
			
			/* Cantidad de filas afectadas, se supone que es 1 */
			if ( $count == 1 ){
				return $incidenciaId;
			} else {
				return 0;
			}

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.insert():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:".$userId. " | empresa:".$empresaId."-". $equipoIdIncidencia."-". $tipoFalla."-".$observaciones."-";
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Crear",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Obtiene 1 incidencia
	 */
	public static function getIncidencia($incidenciaId){
		try {
			$connection = Database::instance();

			$sql = " SELECT * FROM Incidencias WHERE incidenciaId = ? ";

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $incidenciaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetch();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getIncidencia():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "incidenciaId:".$incidenciaId;
			
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
	 * Obtiene 1 incidencia
	 * @return Object[]
	 */
	public static function getIncidenciaObjeto($incidenciaId){
		try {
			$connection = Database::instance();

			$sql = " SELECT i.*, 
					fg.nombre AS TipoFalla, 
					e.nombre AS NombreEmpresa, e.razonSocial, 
					u.nombre AS reportadoPorNombre, u.apellido AS reportadoPorApellido, u.email, u.celular, u.telefonoTrabajo, u.extensionTrabajo, u.id AS usuarioCreadorId, 
					tech.nombre AS TecnicoNombre, tech.apellido AS TecnicoApellido,
					eq.codigoBarras, eq.nombreEquipo
					FROM Incidencias i 
					INNER JOIN FallasGenerales fg ON i.fallaId = fg.fallaId
					INNER JOIN Empresas e ON i.empresaId = e.empresaId
					INNER JOIN Usuarios u ON i.usuarioId = u.id
					LEFT JOIN Usuarios tech ON i.tecnicoId = tech.id
					LEFT JOIN Equipos eq ON i.equipoId = eq.id
					WHERE i.incidenciaId = ? ";

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $incidenciaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetch( \PDO::FETCH_OBJ );

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getIncidenciaObjeto():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "incidenciaId:".$incidenciaId;
			
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
	 * Obteniendo Incidencias de UN usuario
	 */
	public static function getIncidenciasDeUsuario($userId)
	{
		try {

			$connection = Database::instance();

			$sql = "SELECT i.incidenciaId,i.equipoId,i.fecha, "
					. "f.nombre AS falla, "
					. "eq.codigoBarras AS codigoBarras, "
					. "i.observaciones, i.status, i.tecnicoId, "
					. "u.nombre AS Tecnico_nombre, u.apellido  AS Tecnico_apellido,  "
					. "i.fecha_enEspera, i.fecha_reply, i.fecha_enProgreso, i.resolucionId, "
					. "i.enEsperaPor, "
					. "i.respuestaEsperada "
					. "FROM Incidencias i  "
					. "INNER JOIN FallasGenerales f ON i.fallaId = f.fallaId  "
					. "LEFT JOIN Usuarios u ON i.tecnicoId = u.id "
					. "LEFT JOIN Equipos eq ON i.equipoId = eq.id "
					. "WHERE i.usuarioId = ? AND i.status <> 'Certificada' ";

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $userId, \PDO::PARAM_INT);

			$query -> execute();

			/* return $query -> fetch(); */
			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getIncidenciasDeUsuario():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:".$userId;
			
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
	 * Obteniendo Incidencias FINALIZADAS de UN usuario
	 * @param $pageCount número de la página a mostrar al usuario para PAGINACION, de 1 en adelante
	 */
	public static function getIncidenciasCerradasDeUsuario($userId, $pageCount, $limitCount){
		try {

			$connection = Database::instance();

			$sql = " SELECT i.incidenciaId,i.equipoId,i.fecha, "
					. " fg.nombre AS tipoFalla, "
					. " eq.codigoBarras AS codigoBarras, "
					. " i.observaciones, i.status, i.tecnicoId, "
					. " u.nombre AS Tecnico_nombre, u.apellido  AS Tecnico_apellido,  "
					. " i.fecha_enEspera, i.fecha_reply, i.fecha_enProgreso, i.resolucionId, "
					. " i.enEsperaPor, "
					. " s.variableEndogena, s.variableExogenaTecnica, s.variableExogenaHumana, s.incidenciaDuracionDias "
					. " FROM Incidencias i  "
					. " INNER JOIN FallasGenerales fg ON i.fallaId = fg.fallaId  "
					. " LEFT JOIN Usuarios u ON i.tecnicoId = u.id "
					. " LEFT JOIN Equipos eq ON i.equipoId = eq.id "
					. " LEFT JOIN Soluciones s ON i.incidenciaId = s.incidenciaId "
					. " WHERE i.usuarioId = ? AND i.status IN ('Cerrada', 'Certificada') "
					. " LIMIT ? OFFSET ? ";

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $userId, \PDO::PARAM_INT);

			/* Paginacion: LIMITE de resultados a traer */
			$query -> bindParam(2, $limitCount, \PDO::PARAM_INT);

			/*
			 * Paginacion: OFFSET es el grupo que ha de traer el query
			 */
			$offset = (($pageCount - 1) * $limitCount );
			$query -> bindParam(3, $offset, \PDO::PARAM_INT);

			$query -> execute();

			/* return $query -> fetch(); */
			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getIncidenciasCerradasDeUsuario():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:" . $userId . "$pageCount, $limitCount";
			
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
	 * Obteniendo Incidencias FINALIZADAS de UN Tecnico
	 * @param $pageCount número de la página a mostrar al Tecnico para PAGINACION, de 1 en adelante
	 */
	public static function getIncidenciasCerradasDeTecnico($techId, $pageCount, $limitCount){
		try {

			$connection = Database::instance();

			$sql = " 
					SELECT i.incidenciaId, i.equipoId, i.fecha, 
					 fg.nombre AS tipoFalla, 
					 eq.codigoBarras AS codigoBarras, 
					 i.observaciones, i.status, i.tecnicoId, 
					 u.nombre AS Tecnico_nombre, u.apellido  AS Tecnico_apellido,  
					 i.fecha_enEspera, i.fecha_reply, i.fecha_enProgreso, i.resolucionId, 
					 i.enEsperaPor, 
					 s.variableEndogena, s.variableExogenaTecnica, s.variableExogenaHumana, s.incidenciaDuracionDias, 
					 emp.nombre AS nombreEmpresa 
					FROM Incidencias i  
					 INNER JOIN FallasGenerales fg ON i.fallaId = fg.fallaId 
					 LEFT JOIN Usuarios u ON i.tecnicoId = u.id 
					 LEFT JOIN Equipos eq ON i.equipoId = eq.id 
					 LEFT JOIN Soluciones s ON i.incidenciaId = s.incidenciaId 
					 LEFT JOIN Empresas emp ON i.empresaId = emp.empresaId 
					WHERE i.tecnicoId = ? AND i.status IN ('Cerrada', 'Certificada') "
					. self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO 
					. " ORDER BY i.incidenciaId DESC 
					 LIMIT ? OFFSET ? ";
					
					
			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $techId, \PDO::PARAM_INT);

			/* Paginacion: LIMITE de resultados a traer */
			$query -> bindParam(2, $limitCount, \PDO::PARAM_INT);

			/*
			 * Paginacion: OFFSET es el grupo que ha de traer el query
			 */
			$offset = (($pageCount - 1) * $limitCount );
			$query -> bindParam(3, $offset, \PDO::PARAM_INT);

			$query -> execute();

			/* return $query -> fetch(); */
			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getIncidenciasCerradasDeTecnico():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:" . $techId . "$pageCount, $limitCount";
			
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
	 * Obteniendo Incidencias de TODA una Empresa, dada un Usuario MANAGER
	 */
	public static function getIncidenciasDeEmpresa($empresaId)	{
		try {

			$connection = Database::instance();

			$sql = "SELECT i.incidenciaId,i.equipoId,i.fecha, "
					. "f.nombre AS falla, "
					. "eq.codigoBarras AS codigoBarras, "
					. "i.observaciones, i.status, i.tecnicoId, "
					. "u.nombre AS Tecnico_nombre, u.apellido  AS Tecnico_apellido,  "
					. "i.fecha_enEspera, i.fecha_reply, i.fecha_enProgreso, i.resolucionId, "
					. "rp.nombre AS reportadaPorNombre, "
					. "rp.apellido AS reportadaPorApellido, "
					. "i.enEsperaPor, "
					. "i.respuestaEsperada "
					. "FROM Incidencias i  "
					. "INNER JOIN FallasGenerales f ON i.fallaId = f.fallaId  "
					. "LEFT JOIN Usuarios u ON i.tecnicoId = u.id "
					. "LEFT JOIN Equipos eq ON i.equipoId = eq.id "
					. "LEFT JOIN Usuarios rp ON i.usuarioId = rp.id "
					. "WHERE i.empresaId = ? AND i.status NOT IN ('Certificada') ";/* ANTES incluia tambien 'Cerrada' pero asi un Partner no podría certificarlas */

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			/* return $query -> fetch(); */
			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getIncidenciasDeEmpresa():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "empresa:".$empresaId;
			
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
	 * Obteniendo Incidencias de TODA una Empresa, dada un Usuario MANAGER
	 */
	public static function getIncidenciasCerradasDeEmpresa($empresaId, $pageCount, $limitCount)	{
		try {

			$connection = Database::instance();

			$sql = " SELECT i.incidenciaId,i.equipoId,i.fecha, "
					. " f.nombre AS tipoFalla, "
					. " eq.codigoBarras AS codigoBarras, "
					. " i.observaciones, i.status, i.tecnicoId, "
					. " u.nombre AS Tecnico_nombre, u.apellido  AS Tecnico_apellido,  "
					. " i.fecha_enEspera, i.fecha_reply, i.fecha_enProgreso, i.resolucionId, "
					. " rp.nombre AS reportadaPorNombre, "
					. " rp.apellido AS reportadaPorApellido, "
					. " i.enEsperaPor, "
					. " s.variableEndogena, s.variableExogenaTecnica, s.variableExogenaHumana, s.incidenciaDuracionDias "
					. " FROM Incidencias i "
					. " INNER JOIN FallasGenerales f ON i.fallaId = f.fallaId  "
					. " LEFT JOIN Usuarios u ON i.tecnicoId = u.id "
					. " LEFT JOIN Equipos eq ON i.equipoId = eq.id "
					. " LEFT JOIN Usuarios rp ON i.usuarioId = rp.id "
					. " LEFT JOIN Soluciones s ON i.incidenciaId = s.incidenciaId "
					. " WHERE i.empresaId = ? AND (i.status = 'Cerrada' OR i.status = 'Certificada') "
					. " ORDER BY i.incidenciaId DESC "
					. " LIMIT ? OFFSET ? ";

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			/* Paginacion: LIMITE de resultados a traer */
			$query -> bindParam(2, $limitCount, \PDO::PARAM_INT);

			/*
			 * Paginacion: OFFSET es el grupo que ha de traer el query
			 */
			$offset = (($pageCount - 1) * $limitCount );
			$query -> bindParam(3, $offset, \PDO::PARAM_INT);

			$query -> execute();

			/* return $query -> fetch(); */
			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getIncidenciasCerradasDeEmpresa():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "empresa:".$empresaId;
			
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
	 * Obteniendo Incidencias de UN Técnico
	 */
	public static function getIncidenciasDeTecnico($tecnicoId){
		try {

			$connection = Database::instance();

			$sql = " 
					SELECT i.incidenciaId,i.equipoId,i.fecha, 
					 f.nombre AS falla, 
					 eq.codigoBarras AS codigoBarras, 
					 i.observaciones, i.status, i.tecnicoId, 
					 u.nombre AS Tecnico_nombre, u.apellido  AS Tecnico_apellido,  
					 i.fecha_enEspera, i.fecha_reply, i.fecha_enProgreso, i.resolucionId, 
					 rp.nombre AS reportadaPorNombre, 
					 rp.apellido AS reportadaPorApellido, 
					 i.enEsperaPor AS enEsperaPor, 
					 i.empresaId, 
					 i.respuestaEsperada 
					FROM Incidencias i  
					 INNER JOIN FallasGenerales f ON i.fallaId = f.fallaId  
					 LEFT JOIN Usuarios u ON i.tecnicoId = u.id 
					 LEFT JOIN Equipos eq ON i.equipoId = eq.id 
					 LEFT JOIN Usuarios rp ON i.usuarioId = rp.id 
					WHERE i.tecnicoId = ? AND i.status <> 'Cerrada' AND i.status <> 'Certificada' "
					. self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO;

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $tecnicoId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getIncidenciasDeTecnico():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:".$tecnicoId;
			
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
	 * Obteniendo Incidencias ABIERTAS
	 */
	public static function getIncidenciasAbiertas(){
		try {

			$connection = Database::instance();

			$sql = " 
					 SELECT i.incidenciaId,i.equipoId,i.fecha, 
					  f.nombre AS falla, 
					  eq.codigoBarras AS codigoBarras, 
					  i.observaciones, i.status, i.tecnicoId, 
					  u.nombre AS Tecnico_nombre, u.apellido  AS Tecnico_apellido,  
					  i.fecha_enEspera, i.fecha_reply, i.fecha_enProgreso, i.resolucionId, 
					  rp.nombre AS reportadaPorNombre, 
					  rp.apellido AS reportadaPorApellido, 
					  i.respuestaEsperada, i.enEsperaPor, 
					  emp.nombre AS nombreEmpresa 
					 FROM Incidencias i  
					  INNER JOIN FallasGenerales f ON i.fallaId = f.fallaId  
					  LEFT JOIN Usuarios u ON i.tecnicoId = u.id 
					  LEFT JOIN Equipos eq ON i.equipoId = eq.id 
					  LEFT JOIN Usuarios rp ON i.usuarioId = rp.id 
					  LEFT JOIN Empresas emp ON i.empresaId = emp.empresaId 
					 WHERE i.status NOT IN ('Cerrada', 'Certificada') "
					. self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO
					. " ORDER BY i.incidenciaId ASC ";

			$query = $connection -> prepare($sql);
			
			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getIncidenciasAbiertas():";
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
	 * Obteniendo Incidencias CERRADAS
	 * @param $pageCount número de la página a mostrar al usuario para PAGINACION, de 1 en adelante
	 */
	public static function getIncidenciasCerradas($pageCount, $limitCount){
		try {

			$connection = Database::instance();

			$sql = " 
					 SELECT i.incidenciaId, i.equipoId, i.fecha, 
					  fg.nombre AS tipoFalla, 
					  eq.codigoBarras AS codigoBarras, 
					  i.observaciones, i.status, i.tecnicoId, 
					  u.nombre AS Tecnico_nombre, u.apellido  AS Tecnico_apellido,  
					  i.fecha_enEspera, i.fecha_reply, i.fecha_enProgreso, i.resolucionId, 
					  i.enEsperaPor, 
					  s.variableEndogena, s.variableExogenaTecnica, s.variableExogenaHumana, s.incidenciaDuracionDias, 
					  emp.nombre AS nombreEmpresa 
					 FROM Incidencias i  
					  INNER JOIN FallasGenerales fg ON i.fallaId = fg.fallaId 
					  LEFT JOIN Usuarios u ON i.tecnicoId = u.id 
					  LEFT JOIN Equipos eq ON i.equipoId = eq.id 
					  LEFT JOIN Soluciones s ON i.incidenciaId = s.incidenciaId 
					  LEFT JOIN Empresas emp ON i.empresaId = emp.empresaId 
					 WHERE i.status IN ('Cerrada', 'Certificada') "
					. self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO 
					. " ORDER BY i.incidenciaId DESC 
					LIMIT ? OFFSET ? ";
					

			$query = $connection -> prepare($sql);

			/* Paginacion: LIMITE de resultados a traer */
			$query -> bindParam(1, $limitCount, \PDO::PARAM_INT);

			/*
			 * Paginacion: OFFSET es el grupo que ha de traer el query
			 */
			$offset = (($pageCount - 1) * $limitCount );

			$query -> bindParam(2, $offset, \PDO::PARAM_INT);
			
			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getIncidenciasCerradas():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$pageCount, $limitCount";
			
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
	 * Obteniendo Incidencias CERRADAS para el -ADMIN-
	 * @param $pageCount número de la página a mostrar al usuario para PAGINACION, de 1 en adelante
	 */
	public static function getIncidenciasCerradasAdmin($pageCount, $limitCount){
		try {

			$connection = Database::instance();

			$sql = " 
					 SELECT i.incidenciaId, i.equipoId, i.fecha, 
					  fg.nombre AS falla, 
					  eq.codigoBarras AS codigoBarras, 
					  i.observaciones, i.status, i.tecnicoId, 
					  u.nombre AS Tecnico_nombre, u.apellido  AS Tecnico_apellido,  
					  i.fecha_enEspera, i.fecha_reply, i.fecha_enProgreso, i.resolucionId, 
					  i.respuestaEsperada, i.enEsperaPor, 
					  s.variableEndogena, s.variableExogenaTecnica, s.variableExogenaHumana, s.incidenciaDuracionDias, 
					  emp.nombre AS nombreEmpresa, 
					  rp.nombre AS reportadaPorNombre, 
					  rp.apellido AS reportadaPorApellido 
					 FROM Incidencias i  
					  INNER JOIN FallasGenerales fg ON i.fallaId = fg.fallaId 
					  LEFT JOIN Usuarios u ON i.tecnicoId = u.id 
					  LEFT JOIN Equipos eq ON i.equipoId = eq.id 
					  LEFT JOIN Usuarios rp ON i.usuarioId = rp.id 
					  LEFT JOIN Soluciones s ON i.incidenciaId = s.incidenciaId 
					  LEFT JOIN Empresas emp ON i.empresaId = emp.empresaId 
					 WHERE i.status IN ('Cerrada', 'Certificada') "
					 . self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO 
					 . " ORDER BY i.incidenciaId DESC 
					 LIMIT ? OFFSET ? ";

			$query = $connection -> prepare($sql);

			/* Paginacion: LIMITE de resultados a traer */
			$query -> bindParam(1, $limitCount, \PDO::PARAM_INT);

			/*
			 * Paginacion: OFFSET es el grupo que ha de traer el query
			 */
			$offset = (($pageCount - 1) * $limitCount );

			$query -> bindParam(2, $offset, \PDO::PARAM_INT);
			
			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getIncidenciasCerradas():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$pageCount, $limitCount";
			
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
	 * Obteniendo Incidencias ABIERTAS DE OTROS TÉCNICOS excepto éste
	 */
	public static function getIncidenciasAbiertasSinEsteTecnico($tecnicoId){
		try {

			$connection = Database::instance();

			$sql = "
					SELECT i.incidenciaId,i.equipoId,i.fecha, 
					 f.nombre AS falla, 
					 eq.codigoBarras AS codigoBarras, 
					 i.observaciones, i.status, i.tecnicoId, 
					 u.nombre AS Tecnico_nombre, u.apellido  AS Tecnico_apellido,  
					 i.fecha_enEspera, i.fecha_reply, i.fecha_enProgreso, i.resolucionId, 
					 rp.nombre AS reportadaPorNombre, 
					 rp.apellido AS reportadaPorApellido, 
					 i.enEsperaPor AS enEsperaPor, 
					 i.respuestaEsperada 
					FROM Incidencias i  
					 INNER JOIN FallasGenerales f ON i.fallaId = f.fallaId  
					 LEFT JOIN Usuarios u ON i.tecnicoId = u.id 
					 LEFT JOIN Equipos eq ON i.equipoId = eq.id 
					 LEFT JOIN Usuarios rp ON i.usuarioId = rp.id 
					WHERE i.status <> 'Cerrada' AND i.status <> 'Certificada' 
					  AND ( i.tecnicoId IS NULL OR i.tecnicoId <> ? ) "
					. self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO ;

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $tecnicoId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getIncidenciasAbiertasSinEsteTecnico():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:".$tecnicoId;
			
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
	 * Asigna a ESTE TECNICO esta INCIDENCIA
	 */
	public static function asignarIncidencia($tecnicoId, $incidenciaId){
		try {

			$connection = Database::instance();

			$sql = " UPDATE Incidencias i SET i.tecnicoId = ? , status = 'En Progreso' , i.fecha_enProgreso = ? WHERE i.incidenciaId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $tecnicoId, \PDO::PARAM_INT);

			/* FECHA en MySQL.TIMESTAMP desde PHP.string */
			Utils::setLocalTimeZone();
			$fecha = date("Y-m-d H:i:s");
			$query -> bindParam(2, $fecha, \PDO::PARAM_STR);

			$query -> bindParam(3, $incidenciaId, \PDO::PARAM_INT);

			$count = $query -> execute();

			if ( $count == 1 ){
				
				return true;
			}

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.asignarIncidencia():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:".$tecnicoId. " - incidencia:".$incidenciaId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_En_Progreso",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Obteniendo Incidencias de UN Técnico
	 */
	public static function getIncidenciaInfoBasica($incidenciaId){
		try {

			$connection = Database::instance();

			$sql = " SELECT i.incidenciaId, "
					. "  emp.nombre AS nombre_empresa, "
					. "  eq.codigoBarras AS barcode, "
					. "  u.nombre AS usuario_nombre, "
					. "  u.apellido AS usuario_apellido, "
					. "  u.dependencia, "
					. "  i.empresaId, i.fallaId "
					. " FROM Incidencias i  "
					. "  INNER JOIN Empresas emp ON i.empresaId = emp.empresaId "
					. "  LEFT JOIN Usuarios u ON i.usuarioId = u.id "
					. "  LEFT JOIN Equipos eq ON i.equipoId = eq.id "
					. " WHERE i.incidenciaId = ? ";

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $incidenciaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getIncidenciaInfoBasica():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "incidencia:".$incidenciaId;
			
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
	 * Asigna a ESTE TECNICO esta INCIDENCIA
	 */
	public static function abandonarIncidencia($incidenciaId){

		try {

			$connection = Database::instance();

			$sql = " UPDATE Incidencias i SET i.tecnicoId = NULL , status = 'Abierta' WHERE i.incidenciaId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $incidenciaId, \PDO::PARAM_INT);

			$count = $query -> execute();

			if ( $count == 1 ){
				
				return true;
			}

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.abandonarIncidencia():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "incidencia:".$incidenciaId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Abandonar",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}
	

	/**
	 * marcar esta INCIDENCIA "En Espera"
	 */
	public static function marcarEnEspera($incidenciaId,$razon){

		try {

			$connection = Database::instance();

			$sql = " UPDATE Incidencias i SET i.enEsperaPor = ? , i.status = 'En Espera', i.respuestaEsperada = NULL , i.fecha_enEspera = ? WHERE i.incidenciaId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $razon, \PDO::PARAM_STR);
			
			Utils::setLocalTimeZone();
			$fecha = date("Y-m-d H:i:s");
			$query -> bindParam(2, $fecha, \PDO::PARAM_STR);

			$query -> bindParam(3, $incidenciaId, \PDO::PARAM_INT);

			$count = $query -> execute();

			if ( $count == 1 ){
				
				return true;
			}

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.marcarEnEspera():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "incidencia:".$incidenciaId." -razon:".$razon;
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_En_Espera",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * marcar esta INCIDENCIA "CERRADA"
	 * @param $reporteOincidencia ->  "true" si es Reporte | "false" si es Incidencia
	 */
	public static function cerrarIncidencia($incidenciaId, $solucionId, $reporteOincidencia){

		try {

			$connection = Database::instance();

			/*
			 * Los Reportes de Visita NO DEBEN cerrarse, poner directamente en estatus Certificada
			 */
			if ( $reporteOincidencia == "true" ){
				$status = 'Certificada';
			} else {
				$status = 'Cerrada';	
			}
			

			$sql = " UPDATE Incidencias i SET i.enEsperaPor = NULL , i.status = ?, i.resolucionId = ? WHERE i.incidenciaId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $status, 		\PDO::PARAM_STR);
			$query -> bindParam(2, $solucionId, 	\PDO::PARAM_INT);
			$query -> bindParam(3, $incidenciaId, 	\PDO::PARAM_INT);

			$count = $query -> execute();

			if ( $count == 1 ){
				
				return true;
			}

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.cerrarIncidencia():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "incidencia:".$incidenciaId." -solucionId:".$solucionId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Cerrada",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * devuelve EQUIPO_ID (el campo Auto incremental de la tabla Equipos)
	 */
	public static function getEquipoIDdeIncidencia($incidenciaId){
		try {

			$connection = Database::instance();

			$sql = " SELECT equipoId FROM Incidencias WHERE incidenciaId = ? ";

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $incidenciaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetch();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getEquipoIDdeIncidencia():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "incidencia:".$incidenciaId;
			
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
	 * Guardar el FORMULARIO completo de resolución de Incidencia por parte del Tecnico
	 * @return el ID de la Solución
	 */
	public static function resolverIncidencia( $incidenciaId, $tecnicoId, 
			$laborDelEquipo,
			$variableEndogena, $variableExogenaTecnica, $variableExogenaHumana,
			$mantenimientoHardware, $mantenimientoSoftware, $acompanamientoJunior,
			$tipoTrabajoHardware, $tipoTrabajoSoftware ) {

		try {
			$connection = Database::instance();

			$idEquipo = Incidencias::getEquipoIDdeIncidencia($incidenciaId);
			$id = NULL;
			if ( $idEquipo["equipoId"] != NULL || $idEquipo["equipoId"] != "" ){
				/*
				 * Hay INCIDENCIAS 	que NO estan asociadas a UN EQUIPO, otras que sí
				 */
				$id = $idEquipo["equipoId"];
			}

			/*
			 * Este query permite restar la fecha ACTUAL menos la FECHA de cuando se creó la Incidencia
			 * resultado en DIAS
			 */
			$queryRestaDeDias = " DATEDIFF( SYSDATE() , (SELECT i.fecha FROM Incidencias i WHERE i.incidenciaId = ? ) ) ";

			$solucionId = Equipos::getMaxID("Soluciones");
			$solucionId++;

			/*
			 * Arreglando los combo boxes
			 */
			if ( $tipoTrabajoHardware == "HWpreventivo" ){				$tipoHW = "Preventivo";
			} else if ( $tipoTrabajoHardware == "HWcorrectivo" ){		$tipoHW = "Correctivo";
			} else if ( $tipoTrabajoHardware == "HWotro" ){				$tipoHW = "Otro";
			} else {													$tipoHW = NULL;
			}

			if ( $tipoTrabajoSoftware == "SWpreventivo" ){				$tipoSW = "Preventivo";
			} else if ( $tipoTrabajoSoftware == "SWcorrectivo" ){		$tipoSW = "Correctivo";
			} else if ( $tipoTrabajoSoftware == "SWotro" ){				$tipoSW = "Otro";
			} else {													$tipoSW = NULL;
			}

			/*
			 * Agregar la Incidencia
			 */
			$sql = " INSERT INTO Soluciones ( solucionId, "
				. " equipoId, incidenciaId, tecnicoId, laborDelEquipo, "
				. " variableEndogena, variableExogenaTecnica, variableExogenaHumana, "
				. " mantenimientoHardware, mantenimientoSoftware, acompanamientoJunior, "
				. " tipoTrabajoHardware, tipoTrabajoSoftware, incidenciaDuracionDias ) "
				. " VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, "
				. $queryRestaDeDias
				. " ) ";
			
			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $solucionId, \PDO::PARAM_INT);
			$query -> bindParam(2, $id, \PDO::PARAM_INT);

			$query -> bindParam(3, $incidenciaId, \PDO::PARAM_INT);

			$query -> bindParam(4, $tecnicoId, \PDO::PARAM_INT);

			$query -> bindParam(5, $laborDelEquipo, 		\PDO::PARAM_STR);
			$query -> bindParam(6, $variableEndogena,       \PDO::PARAM_STR);
			$query -> bindParam(7, $variableExogenaTecnica, \PDO::PARAM_STR);
			$query -> bindParam(8, $variableExogenaHumana,  \PDO::PARAM_STR);
			$query -> bindParam(9, $mantenimientoHardware,  \PDO::PARAM_STR);
			$query -> bindParam(10,$mantenimientoSoftware,  \PDO::PARAM_STR);
			$query -> bindParam(11,$acompanamientoJunior,   \PDO::PARAM_STR);

			$query -> bindParam(12, $tipoHW, \PDO::PARAM_STR);
			$query -> bindParam(13, $tipoSW, \PDO::PARAM_STR);

			/* query de los días, clausula WHERE */
			$query -> bindParam(14, $incidenciaId, \PDO::PARAM_INT);

			$count = $query -> execute();

			/* Cantidad de filas afectadas, se supone que es 1 */
			if ( $count == 1 ){

				return $solucionId;
			}
			
		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.resolverIncidencia():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $incidenciaId."--". $tecnicoId."--". $laborDelEquipo."--".
					$variableEndogena."--". $variableExogenaTecnica."--". $variableExogenaHumana."--".
					$mantenimientoHardware."--". $mantenimientoSoftware."--". $acompanamientoJunior;
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Cerrada",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * devuelve SOLUCION_ID (el campo Auto incremental de la tabla)
	 */
	public static function getSolucionID($incidenciaId, $tecnicoId, $idEquipo){
		try {

			$connection = Database::instance();

			$sql = " SELECT solucionId FROM Soluciones WHERE equipoId = ? AND incidenciaId = ? AND tecnicoId = ? ";

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $idEquipo, \PDO::PARAM_INT);
			$query -> bindParam(2, $incidenciaId, \PDO::PARAM_INT);
			$query -> bindParam(3, $tecnicoId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetch();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getSolucionID():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "incidencia:".$incidenciaId."-id:". $tecnicoId."-". $idEquipo;
			
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
	 * En el Formulario de Resolución de Incidencia -> si el técnico añade un componente de HARDWARE a la solución
	 * @param $cantHardware Cantidad de componentes
	 * todos los valores vienen en literales de STRING separados por coma ','
	 * @param $deleteAllFirst --> if TRUE ent. borrar TODO antes de insertar
	 */
	public static function agregarComponenteHardware($solucionId, $cantHardware,
			$hardwareARemplazar, $hardwareDescripciones, $hardwareViejo, $hardwareNuevo, $hardwareFueRemplazadoSN,
			$deleteAllFirst) {

		try {
			if ( $cantHardware > 0 ){
				
				$connection = Database::instance();

				if ( $deleteAllFirst == true ){
					/*
					 * borrar todo antes de insertar lo nuevo --- viene del portal Admin
					 */
					$sql1 = " DELETE FROM CambioHardware WHERE solucionId = ? ";
					$query1 = $connection -> prepare($sql1);
					$query1 -> bindParam(1, $solucionId, \PDO::PARAM_INT);
					$query1 -> execute();
				}


				$sql = " INSERT INTO CambioHardware(solucionId, hardwareARemplazar, descripcion, hardwareViejo, hardwareNuevo, fueRemplazado) "
							. "VALUES (?,?,?,?,?,?) ";

				/*
				 * metodo explode() es similar al split() / separando por comas
				 */
				$myArray           = explode(',', $hardwareARemplazar);
				$arrayDescripciones= explode(',', $hardwareDescripciones);
				$arrayViejos       = explode(',', $hardwareViejo);
				$arrayNuevos       = explode(',', $hardwareNuevo);
				$arraySiNo         = explode(',', $hardwareFueRemplazadoSN);
				$count = 0;

				for ( $i = 0; $i < $cantHardware; $i++ ){
					
					$query = $connection -> prepare($sql);

					/*
					 * insertar en la Base de datos
					 */
					$query -> bindParam(1, $solucionId, \PDO::PARAM_INT);
					$query -> bindParam(2, $myArray[$i], \PDO::PARAM_STR);
					$query -> bindParam(3, $arrayDescripciones[$i], \PDO::PARAM_STR);
					$query -> bindParam(4, $arrayViejos[$i], \PDO::PARAM_STR);
					$query -> bindParam(5, $arrayNuevos[$i], \PDO::PARAM_STR);
					$query -> bindParam(6, $arraySiNo[$i], \PDO::PARAM_STR);

					$count += $query -> execute();
				}
			}
			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.agregarComponenteHardware():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $solucionId."--". $cantHardware."--".
					$hardwareARemplazar."--". $hardwareDescripciones."--". $hardwareViejo."--". $hardwareNuevo."--". $hardwareFueRemplazadoSN;
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Cerrada",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * En el Formulario de Resolución de Incidencia -> si el técnico añade un componente de Software a la solución
	 * @param $cantSoftware Cantidad de 'softwares' cambiados o instalados
	 * todos los valores vienen en literales de STRING separados por coma ','
	 * @param $deleteAllFirst --> if TRUE ent. borrar TODO antes de insertar
	 */
	public static function agregarComponenteSoftware($solucionId, $cantSoftware, $softwaresARemplazar, 
			$softwareVersiones, $softwareTipos, $softwareSeriales, $softwaresCambiados,
			$deleteAllFirst) {

		try {
			if ( $cantSoftware > 0 ){
				
				$connection = Database::instance();

				if ( $deleteAllFirst == true ){
					/*
					 * borrar todo antes de insertar lo nuevo --- viene del portal Admin
					 */
					$sql1 = " DELETE FROM CambioSoftware WHERE solucionId = ? ";
					$query1 = $connection -> prepare($sql1);
					$query1 -> bindParam(1, $solucionId, \PDO::PARAM_INT);
					$query1 -> execute();
				}

				$sql = " INSERT INTO CambioSoftware(solucionId, softwareARemplazar, version, tipo, serial, trabajo) "
							. "VALUES (?,?,?,?,?,?) ";

				/*
				 * metodo explode() es similar al split() / separando por comas
				 */
				$softwaresARemplazar= explode(',', $softwaresARemplazar);
				$softwareVersiones	= explode(',', $softwareVersiones);
				$softwareTipos      = explode(',', $softwareTipos);
				$softwareSeriales   = explode(',', $softwareSeriales);
				$softwaresCambiados = explode(',', $softwaresCambiados);
				$count = 0;

				for ( $i = 0; $i < $cantSoftware; $i++ ){
					
					$query = $connection -> prepare($sql);

					/*
					 * insertar en la Base de datos
					 */
					$query -> bindParam(1, $solucionId, \PDO::PARAM_INT);
					$query -> bindParam(2, $softwaresARemplazar[$i], \PDO::PARAM_STR);
					$query -> bindParam(3, $softwareVersiones[$i], \PDO::PARAM_STR);
					$query -> bindParam(4, $softwareTipos[$i], \PDO::PARAM_STR);
					$query -> bindParam(5, $softwareSeriales[$i], \PDO::PARAM_STR);
					$query -> bindParam(6, $softwaresCambiados[$i], \PDO::PARAM_STR);

					$count += $query -> execute();
				}
			}
			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.agregarComponenteSoftware():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $solucionId."--". $cantSoftware."--". $softwaresARemplazar."--". 
					$softwareVersiones."--". $softwareTipos."--". $softwareSeriales."--". $softwaresCambiados;
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Cerrada",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Obtener toda la info de una Resolución
	 */
	public static function getSolucion($solucionId){
		try {

			$connection = Database::instance();

			$sql = " SELECT * FROM Soluciones WHERE solucionId = ? ";

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $solucionId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetch();

		} catch(\PDOException $e) {
			print "Error in models.Incidencias.php.getSolucion(id): " . $e->getMessage();
			$internalErrorCodigo  = "PDOException in models.Incidencias.getSolucion():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "solucionId:". $solucionId;
			
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
	 * Obtener info de la tabla CambioHardware, si existen
	 */
	public static function getCambiosHardware($solucionId){
		try {

			$connection = Database::instance();

			$sql = " SELECT * FROM CambioHardware WHERE solucionId = ? ";

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $solucionId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getCambiosHardware():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "solucionId:". $solucionId;
			
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
	 * Obtener info de la tabla CambioSoftware, si existen
	 */
	public static function getCambiosSoftware($solucionId){
		try {

			$connection = Database::instance();

			$sql = " SELECT * FROM CambioSoftware WHERE solucionId = ? ";

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $solucionId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getCambiosSoftware():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "solucionId:". $solucionId;
			
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
	 * Marcar status ´Certificada` y permitir dar la opinion al Usuario
	 */
	public static function certificarIncidencia($incidenciaID, $solucionID){
		try {

			$connection = Database::instance();

			$sql = " UPDATE Incidencias i SET i.status = 'Certificada' WHERE i.incidenciaId = ? AND i.resolucionId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $incidenciaID, \PDO::PARAM_INT);
			$query -> bindParam(2, $solucionID, \PDO::PARAM_INT);

			$count = $query -> execute();

			if ( $count == 1 ){
				
				return true;
			}

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.certificarIncidencia():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "incidencia:".$incidenciaID."--solucionId:". $solucionId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Usuario_Certificar",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Marcar status ´Certificada` y permitir dar la opinion al Usuario
	 */
	public static function salvarOpinion($incidenciaId, $solucionId, $se_resolvio, $positiva_negativa,
			$barra_1, $barra_2, $barra_3, $barra_4, $comentarios){

		try {
			$connection = Database::instance();

			/*
			 * Acomodar la data:
			 * There is not really a BOOLEAN type in MySQL. BOOLEAN is just a synonym for TINYINT(1),
			 * and TRUE and FALSE are synonyms for 1 (true) and 0 (false).
			 */
			$b1 = false;
			if ( $se_resolvio == "true" ){
				$b1 = true;
			} else {
				$b1 = false;
			}

			/* pregunta eliminada
			$b2 = false;
			if ( $positiva_negativa == "true" ){
				$b2 = true;
			} else {
				$b2 = false;
			}
			*/
			$b2 = NULL;

			/* Data de las barras */
			$b3 = "";
			switch ($barra_1) {
				case 1:
					$b3 = "Totalmente en Desacuerdo";
					break;
				case 2:
					$b3 = "En Desacuerdo";
					break;
				case 3:
					$b3 = "Ni de Acuerdo ni en Desacuerdo";
					break;
				case 4:
					$b3 = "De Acuerdo";
					break;
				case 5:
					$b3 = "Totalmente de Acuerdo";
					break;
				default:
					$b3 = "Ni de Acuerdo ni en Desacuerdo";
			}

			$b4 = "";
			switch ($barra_2) {
				case 1:
					$b4 = "Totalmente en Desacuerdo";
					break;
				case 2:
					$b4 = "En Desacuerdo";
					break;
				case 3:
					$b4 = "Ni de Acuerdo ni en Desacuerdo";
					break;
				case 4:
					$b4 = "De Acuerdo";
					break;
				case 5:
					$b4 = "Totalmente de Acuerdo";
					break;
				default:
					$b4 = "Ni de Acuerdo ni en Desacuerdo";
			}

			$b5 = "";
			switch ($barra_3) {
				case 1:
					$b5 = "Totalmente en Desacuerdo";
					break;
				case 2:
					$b5 = "En Desacuerdo";
					break;
				case 3:
					$b5 = "Ni de Acuerdo ni en Desacuerdo";
					break;
				case 4:
					$b5 = "De Acuerdo";
					break;
				case 5:
					$b5 = "Totalmente de Acuerdo";
					break;
				default:
					$b5 = "Ni de Acuerdo ni en Desacuerdo";
			}

			$b6 = "";
			switch ($barra_4) {
				case 1:
					$b6 = "Totalmente en Desacuerdo";
					break;
				case 2:
					$b6 = "En Desacuerdo";
					break;
				case 3:
					$b6 = "Ni de Acuerdo ni en Desacuerdo";
					break;
				case 4:
					$b6 = "De Acuerdo";
					break;
				case 5:
					$b6 = "Totalmente de Acuerdo";
					break;
				default:
					$b6 = "Ni de Acuerdo ni en Desacuerdo";
			}

			/*
			 * Agregar la Incidencia
			 */
			$sql = " INSERT INTO OpinionIncidencias( incidenciaId, solucionId, seResolvio, opinionPositiva, tiempo_servicio, personal_resolvio, servicio_adicional, calificacion_general, comentarios) "
				. " VALUES(?, ?, ?, ?, ?, ?, ?, ?, ? ) ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $incidenciaId, \PDO::PARAM_INT);
			$query -> bindParam(2, $solucionId, \PDO::PARAM_INT);

			$query -> bindParam(3, $b1, \PDO::PARAM_BOOL);
			$query -> bindParam(4, $b2, \PDO::PARAM_BOOL);

			$query -> bindParam(5, $b3, \PDO::PARAM_STR);
			$query -> bindParam(6, $b4, \PDO::PARAM_STR);
			$query -> bindParam(7, $b5, \PDO::PARAM_STR);
			$query -> bindParam(8, $b6, \PDO::PARAM_STR);

			$query -> bindParam(9, $comentarios, \PDO::PARAM_STR);

			$count = $query -> execute();

			/* Cantidad de filas afectadas, se supone que es 1 */
			if ( $count == 1 ){
				return true;
			}
		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.salvarOpinion():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $incidenciaId."---". $solucionId."---". $se_resolvio."---". $positiva_negativa."---".
					$barra_1."---". $barra_2."---". $comentarios;
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Usuario_Opinar",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Para salvar Respuestas Pre-Definidas
	 */
	public static function salvarRespuesta($empresaId, $respuestaPredefinida, $campoFormulario){
		try {

			if ( $campoFormulario == "laborDelEquipo" ){
				/*
				 * 1ro. Toca ver si ya no ha sido salvada con anterioridad
				 */
				$connection = Database::instance();

				$sql = " SELECT respPredefId FROM RespuestasPredefinidas WHERE tipoRespuesta = 'laborEquipo' AND empresaId = ? AND respuesta = ? ";

				$query = $connection -> prepare($sql);
				
				$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);
				$query -> bindParam(2, $respuestaPredefinida, \PDO::PARAM_STR);

				$query -> execute();

				$result = $query -> fetch();

				/*
				 * 2do. Si NO ha sido salvada, entonces GUARDAR. Si ya está, no hacer nada
				 */
				if ( $result == null || $result == "" ){

					$sql2 = " INSERT INTO RespuestasPredefinidas(tipoRespuesta, empresaId, respuesta)  "
							. "VALUES (?,?,?) ";

					$query2 = $connection -> prepare($sql2);

					$aux = "laborEquipo";
					$query2 -> bindParam(1, $aux, \PDO::PARAM_STR);
					$query2 -> bindParam(2, $empresaId, \PDO::PARAM_INT);
					$query2 -> bindParam(3, $respuestaPredefinida, \PDO::PARAM_STR);

					$query2 -> execute();
				}

				return true;
			}

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.salvarRespuesta():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $empresaId."--". $respuestaPredefinida."--". $campoFormulario;
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Cerrada",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Para obtener Respuestas Pre-Definidas de una Empresa
	 */
	public static function getRespuestasDeEmpresa( $empresaId, $tipoRespuesta ){
		try {
			if ( $tipoRespuesta == "laborEquipo" ){
				$connection = Database::instance();

				$sql = " SELECT respuesta FROM RespuestasPredefinidas WHERE tipoRespuesta = 'laborEquipo' AND empresaId = ? LIMIT 100 ";

				$query = $connection -> prepare($sql);
					
				$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

				$query -> execute();

				return $query -> fetchAll();

			} else {
				return "";
			}

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getRespuestasDeEmpresa():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $empresaId."---". $tipoRespuesta;
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Cerrada",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Para hacer reply/responder al Tecnico que puso la Incidencia "En Espera"
	 * Volverá a estar "En Progreso"
	 */
	public static function replyTech($incidenciaId, $comentario){
		try {
			$connection = Database::instance();

			$sql = " UPDATE Incidencias i SET i.respuestaEsperada = ? , status = 'En Progreso' , i.fecha_reply = ? WHERE i.incidenciaId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $comentario, \PDO::PARAM_STR);

			Utils::setLocalTimeZone();
			$fecha = date("Y-m-d H:i:s");
			$query -> bindParam(2, $fecha, \PDO::PARAM_STR);

			$query -> bindParam(3, $incidenciaId, \PDO::PARAM_INT);

			$query -> execute();

			return true;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.replyTech():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "incidencia:".$incidenciaId."---comentario:". $comentario;
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Usuario_Reply",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Devuelve un USUARIO, el que creó esta Inciencia
	 */
	public static function getUsuarioCreadorDeIncidencia($incidenciaId){
		try {
			$connection = Database::instance();

			$sql = " SELECT * FROM Usuarios WHERE id IN ( SELECT i.usuarioId FROM Incidencias i WHERE i.incidenciaId = ? ) ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $incidenciaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetch( \PDO::FETCH_OBJ );

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getUsuarioCreadorDeIncidencia():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "incidencia:".$incidenciaId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Usuario_Reply",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Devuelve un TECNICO, el que esta atendiendo
	 */
	public static function getTecnicoDeIncidencia($incidenciaId){
		try {
			$connection = Database::instance();

			$sql = " SELECT * FROM Usuarios u WHERE u.id IN ( SELECT i.tecnicoId FROM Incidencias i WHERE i.incidenciaId = ? ) AND u.role = 'tech' ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $incidenciaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetch( \PDO::FETCH_OBJ );

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getTecnicoDeIncidencia():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "incidencia:".$incidenciaId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Usuario_Reply",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Busqueda de Incidencias para Tecnicos
	 */
	public static function searchIncidencias($tipoBusqueda, $literalStringABuscar, $tipoFalla){
		try {
			$connection = Database::instance();

			$a = trim($literalStringABuscar);
			$bool = false;

			$order = " ORDER BY i.incidenciaId DESC ";

			$sql = " SELECT i.incidenciaId,i.equipoId,i.fecha, "
					. " f.nombre AS falla, "
					. " eq.codigoBarras AS codigoBarras, "
					. " i.observaciones, i.status, i.tecnicoId, i.usuarioId, "
					. " u.nombre AS Usuario_nombre, u.apellido AS Usuario_apellido, "
					. " i.fecha_enEspera, i.fecha_reply, i.fecha_enProgreso, i.resolucionId, "
					. " i.enEsperaPor, "
					. " i.respuestaEsperada, "
					. " emp.nombre AS Empresa_nombre, emp.razonSocial "
					. " FROM Incidencias i  "
					. " INNER JOIN FallasGenerales f ON i.fallaId = f.fallaId  "
					. " LEFT JOIN Usuarios u ON i.usuarioId = u.id "
					. " LEFT JOIN Equipos eq ON i.equipoId = eq.id "
					. " LEFT JOIN Empresas emp ON i.empresaId = emp.empresaId "
					. " WHERE "
					;

			if ( $tipoBusqueda == "" && $literalStringABuscar == "" && $tipoFalla == "all_Incidencias" ){
				/**
				 * Busqueda de todas Incidencias
				 */
				$sql .= " i.fallaId < 100 ";

				$order = " ORDER BY Empresa_nombre ASC, i.incidenciaId DESC ";

				$sql .= $order;

				$query = $connection -> prepare($sql);
				

			} else if ( $tipoBusqueda == "" && $literalStringABuscar == "" && $tipoFalla == "all_Reportes" ){
				/**
				 * Busqueda de todas Reportes
				 */
				$sql .= " i.fallaId >= 100 ";

				$order = " ORDER BY Empresa_nombre ASC, i.incidenciaId DESC ";

				$sql .= $order;

				$query = $connection -> prepare($sql);
				

			} else if ( $tipoBusqueda == "1" && is_numeric($a) ){
				/***************************************************************************************
				 * Busqueda por ID
				 */
				$sql .= " i.incidenciaId = ? "
						. $order;

				$query = $connection -> prepare($sql);

				$query -> bindParam(1, $a, \PDO::PARAM_INT);


			} else if ( $tipoBusqueda == "2"){
				/***************************************************************************************/
				if ( $tipoFalla != NULL && $tipoFalla > 0 ){
					$sql .= " i.fallaId = ? AND ";
					$bool = true;
				}

				$sql .= " ( i.usuarioId IN "
						. "  ( SELECT u.id FROM Usuarios u WHERE u.nombre LIKE '%".$a."%' OR u.apellido LIKE '%".$a."%' OR u.email LIKE '%".$a."%' OR u.usuario LIKE '%".$a."%') "
						. "  OR i.empresaId IN "
						. "  ( SELECT emp.empresaId FROM Empresas emp WHERE emp.nombre LIKE '%".$a."%' OR emp.razonSocial LIKE '%".$a."%' OR emp.NIT LIKE '%".$a."%' ) "
						. " ) "
						. $order;

				$query = $connection -> prepare($sql);

				if ( $bool ){
					$query -> bindParam(1, $tipoFalla, \PDO::PARAM_INT);
				}


			} else if ( $tipoBusqueda == "3"){
				/***************************************************************************************/
				if ( $tipoFalla != NULL && $tipoFalla > 0 ){
					$sql .= " i.fallaId = ? AND ";
					$bool = true;
				}

				$sql .= " ( i.resolucionId IN "
						. "  ( SELECT sol.solucionId FROM Soluciones sol WHERE sol.laborDelEquipo LIKE '%".$a."%' "
						. "   OR sol.variableEndogena LIKE '%".$a."%' OR sol.variableExogenaTecnica LIKE '%".$a."%' OR sol.variableExogenaHumana LIKE '%".$a."%' "
						. "   OR sol.mantenimientoHardware LIKE '%".$a."%' OR sol.mantenimientoSoftware LIKE '%".$a."%' OR sol.acompanamientoJunior LIKE '%".$a."%' "
						. " ) ) "
						. $order;

				$query = $connection -> prepare($sql);

				if ( $bool ){
					$query -> bindParam(1, $tipoFalla, \PDO::PARAM_INT);
				}


			} else if ( $tipoBusqueda == "4"){
				/***************************************************************************************/
				if ( Utils::startsWith($a, "A") || Utils::startsWith($a, "B") ){
					/*
					 * A y B: tomar la LETRA (opcion) y la fecha
					 */
					$auxArray = explode(" ", $a);

					$letra  = $auxArray[0];
					$fecha1 = $auxArray[1];

					$fecha2 = $fecha1;

				} else if ( Utils::startsWith($a, "C") || Utils::startsWith($a, "D") ){
					/*
					 * C y D: tomar la LETRA (opcion) y las 2 fechas
					 */
					$auxArray = explode(" ", $a);
					
					$letra  = $auxArray[0];
					$fecha1 = $auxArray[1];
					$fecha2 = $auxArray[2];
				}

				/**/
				if ( $letra == "A" || $letra == "C" ){

					$sql .= " i.fecha >= '" .$fecha1. " 00:00.00' AND i.fecha < '" .$fecha2. " 23:59.59' ";

					$sql .= $order;

				} else if ( $letra == "B" || $letra == "D" ){

					$sql .= " (i.fecha >= '" .$fecha1. " 00:00.00' AND i.fecha < '" .$fecha2. " 23:59.59') "
							. " OR "
							. " (i.fecha_enProgreso >= '" .$fecha1. " 00:00.00' AND i.fecha_enProgreso < '" .$fecha2. " 23:59.59') "
							. " OR "
							. " (i.fecha_enEspera >= '" .$fecha1. " 00:00.00' AND i.fecha_enEspera < '" .$fecha2. " 23:59.59') "
							. " OR "
							. " (i.fecha_reply >= '" .$fecha1. " 00:00.00' AND i.fecha_reply < '" .$fecha2. " 23:59.59') "
							. " OR "
							. " i.resolucionId IN "
							. " ( SELECT sol.solucionId FROM Soluciones sol WHERE sol.fecha >= '" .$fecha1. " 00:00.00' AND sol.fecha < '" .$fecha2. " 23:59.59') "
							;

					$sql .= $order;

				} 

				$query = $connection -> prepare($sql);
			}

			/*
			 * Realizar la busqueda segun una de las 4 opciones de arriba
			 */
			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Equipos.searchIncidencias():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$tipoBusqueda, $literalStringABuscar, $tipoFalla";
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			/* Devolver el mensaje al Tecnico */
			return $internalErrorCodigo . ": " . $internalErrorMessage . " .:. " . $internalErrorExtra;
		}
	}


	/**
	 * Añadiendo incidencias IDs a la tabla UsuarioEstatus.incidenciasSinOpinar
	 * Se añadirá de esta forma: 
	   **INCIDENCIA_ID**
	 * con 2 asteriscos, permitirà la bùsqueda ùnica para cuando se desea eliminar
	 */
	public static function agregarAFaltaPorOpinar($incidenciaId){
		try {
			/*
			 * FINAL VARIABLE
			 */
			$SEPARATOR = "**";

			$sql = '';

			$connection = Database::instance();
			/*
			 * Buscando Campo a ver què tiene
			 */
			$sql1 = " SELECT * FROM UsuarioEstatus WHERE userId IN  
						( SELECT i.usuarioId FROM Incidencias i WHERE i.incidenciaId = ? )";

			$query1 = $connection -> prepare($sql1);
			
			$query1 -> bindParam(1, $incidenciaId, \PDO::PARAM_INT);

			$query1 -> execute();

			$result = $query1 -> fetch( \PDO::FETCH_OBJ );

			if ( $result == NULL || $result == "" ){
				/*
				 * Si NO existe registro, toca insertarlo: INSERT INTO
				 * esto no deberìa ser lo usual, sino que la insercion 
				 * viene en admin/user.nuevoUsuarioEstatus($userId)
				 */
				return true;

			} else {
				/*
				 * Si ya existe registro, toca actualizarlo: UPDATE
				 */
				$faltanPorOpinar = $result->incidenciasSinOpinar;

				if ( $faltanPorOpinar != NULL && $faltanPorOpinar != "" ){
					/*
					 * Codigo para cuando el CAMPO NO està en NULL, 
					 * ya que coloca el separador por delante {CONCAT_WS()} y por detràs (cableando el separador)
					 */
					$sql = ' UPDATE UsuarioEstatus ue 
							SET ue.incidenciasSinOpinar = CONCAT_WS("'.$SEPARATOR.'" 
								, ue.incidenciasSinOpinar, "'. $incidenciaId . $SEPARATOR . '" ) 
							WHERE ue.userId IN 
							 ( SELECT i.usuarioId FROM Incidencias i WHERE i.incidenciaId = ? ) ';

				} else {
					/*
					 * Codigo para cuando el CAMPO SÌ està en NULL
					 * se debe cablear el separador por DELANTE y por DETRÁS
					 */
					$sql = ' UPDATE UsuarioEstatus ue 
							SET ue.incidenciasSinOpinar = CONCAT_WS("'.$SEPARATOR.'" 
								, ue.incidenciasSinOpinar, "'. $SEPARATOR . $incidenciaId . $SEPARATOR . '" ) 
							WHERE ue.userId IN 
							 ( SELECT i.usuarioId FROM Incidencias i WHERE i.incidenciaId = ? ) ';
				}
				$query = $connection -> prepare($sql);

				$query -> bindParam(1, $incidenciaId, \PDO::PARAM_INT);

				$count = $query -> execute();

				return $count;
			}

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.agregarAFaltaPorOpinar():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "incidencia:".$incidenciaId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Cerrada",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * ELIMINAR incidencia ID de la lista de la tabla UsuarioEstatus.incidenciasSinOpinar
	 * SOLO para CLIENT
	 */
	public static function incidenciaOpinada( $userId, $incidenciaId ){
		try {
			$connection = Database::instance();

			$sql = " SELECT * FROM UsuarioEstatus WHERE userId = ? ";

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $userId, \PDO::PARAM_INT);

			$query -> execute();

			$result = $query -> fetch( \PDO::FETCH_OBJ );

			$bool = false; $quitandoId = NULL;

			if ( $result != NULL && $result != "" ){
				/*
				 * 2.- Si entra acà es porque el campo existe en la tabla
				 */
				$SEPARATOR = "**";
				
				/* los ID's separados por '**'; si es que hay */
				$IDs = $result->incidenciasSinOpinar;

				if ( $IDs == NULL || $IDs == "" ){
					/* 2.1.- Campo viene en NULL */
					$bool = false;

				} else if ( strpos( $IDs, $SEPARATOR . $incidenciaId . $SEPARATOR ) !== false ){
					/*
					 * 2.2.- Incidencia sì está en el campo; se busca asì **incidenciaID**
					 */
					$find = $SEPARATOR . $incidenciaId . $SEPARATOR;
					/*
					 * se reemplaza  **incidenciaID** con VACÌO
					 */
					$quitandoId = str_replace( $find, '', $IDs );
					$bool = true;

				} else {
					/* 2.3- NO está dicha incidencia */
					$bool = false;
				}

			} else {
				/* 1.- NO està el usuario en la tabla. Saliendo del Método */
				return true;
			}

			if ( $bool == true){
				/* limpiando a null el campo vacío */
				if ( $quitandoId == "" || $quitandoId == "," || $quitandoId == $SEPARATOR ){
					$quitandoId = NULL;
				}


				/* Eliminando Incidencia ID del listado */
				$sql2 = ' UPDATE UsuarioEstatus ue SET ue.incidenciasSinOpinar = ? WHERE ue.userId = ? ';

				$query2 = $connection -> prepare($sql2);

				$query2 -> bindParam(1, $quitandoId, \PDO::PARAM_STR);
				$query2 -> bindParam(2, $userId, 	 \PDO::PARAM_INT);

				$count = $query2 -> execute();

				return true;
			}

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.incidenciaOpinada():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:".$userId. " - incidencia:".$incidenciaId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Usuario_Opinar",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * ELIMINAR incidencia ID de la lista de la tabla UsuarioEstatus.incidenciasSinOpinar
	 * SOLO para PARTNER's
	 */ 
	public static function incidenciaOpinadaPartner($empresaId, $incidenciaId){
		/*
		 * Al ser Partner, se debe buscar esta INCIDENCIA_ID entre todos los EMPLEADOS
		 * de esta Empresa
		 */
		$connection = Database::instance();

		$SEPARATOR = "**";

		$sql = " SELECT * FROM UsuarioEstatus ue 
				WHERE ue.incidenciasSinOpinar LIKE '%" 
				. $SEPARATOR . $incidenciaId . $SEPARATOR . "%' 
				AND ue.userId IN 
				( SELECT u.id FROM Usuarios u WHERE u.empresaId = ? ) ";

		$query = $connection -> prepare($sql);
		
		$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

		$query -> execute();

		$result = $query -> fetch( \PDO::FETCH_OBJ );

		if ( $result != NULL && $result != "" ){
			/*
			 * Si entra acà es porque encrontrò algùn Empleado de esta EMPRESA_ID
			 * con dicha Incidencia; por eso se llama al metodo de eliminaciòn de INCIDENCIA_ID
			 * con este usuario encontrado
			 */
			$userId = $result->userId;
			return Incidencias::incidenciaOpinada( $userId, $incidenciaId );

		} else {
			/* Incidencia NO encontrada, hacer nada */
			return true;
		}

	}

	/**
	 * ELIMINAR incidencia ID de la lista de la tabla UsuarioEstatus.incidenciasSinOpinar
	 * SOLO para PARTNER's
	 * @param $empresaId
	 * @param $jsonString ej: [{"id":"1000"},{"id":"2000"}]
	 */ 
	public static function incidenciaOpinadaPartner2($empresaId, $jsonString){
		/*
		 * Al ser Partner, se debe buscar esta INCIDENCIA_ID entre todos los EMPLEADOS
		 * de esta Empresa
		 */
		$connection = Database::instance();

		$sql = ' SELECT * FROM UsuarioEstatus ue 
					WHERE ue.incidenciasSinOpinar LIKE "'
					. '%\"id\":\"' . $incidenciaId . '\"%"' ;

		$query = $connection -> prepare($sql);
		
		$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

		$query -> execute();

		$result = $query -> fetch( \PDO::FETCH_OBJ );

		if ( $result != NULL && $result != "" ){
			/*
			 * Si entra acà es porque encrontrò algùn Empleado de esta EMPRESA_ID
			 * con dicha Incidencia; por eso se llama al metodo de eliminaciòn de INCIDENCIA_ID
			 * con este usuario encontrado
			 */
			$userId = $result->userId;
			return Incidencias::incidenciaOpinada( $userId, $incidenciaId );

		} else {
			/* Incidencia NO encontrada, hacer nada */
			return true;
		}

	}


	/**
	 * Crea una nueva INCIDENCIA como "Reporte de Visita"
	 */ 
	public static function insertReporteVisita($tech, $empresaId, $userId, $equipoId, $cantidad, $tipoReporte ) {

		if ( $tipoReporte == true || $tipoReporte == "true"){
			/**
			 * Tipo de reporte: Reporte General (1 por CADA equipo) -$fallaId = 101;
			 */
			return Incidencias::insertReporteGeneralVisita($tech, $empresaId);
		}
		try {
			$connection = Database::instance();

			$techId = $tech->id;

			$quantity =  intval($cantidad);

			if ( $userId == "0" || $userId == 0 ){
				$userId = NULL;
			}

			if ( $equipoId == "0" || $equipoId == 0 ){
				$equipoId = NULL;
			}

			/*
			 * VALORES MAYORES A 100: reservados para Tecnicos y Reportes
			 * Tipo de reporte: Reporte individual (1 por Equipo o Usuario)
			 */
			$fallaId = 100;
			

			$observaciones = "REPORTE_VISITA | Creado_por_Tecnico_id:" . $techId . " | Empresa_id:".$empresaId;
			$status = "En Progreso";

			$sql = " INSERT INTO Incidencias ( "
					. " tecnicoId, fallaId, observaciones, empresaId, status, equipoId, usuarioId, incidenciaId ) " 
					. " VALUES ( ?, ?, ?, ?, ?, ?, ?, ? ) ";

			$count = 0;

			/* Buscando el ID a insertar */
			$incidenciaId = Equipos::getMaxID("Incidencias");
			

			for ( $i = 0; $i < $quantity; $i++ ){

				$incidenciaId++;

				$query = $connection -> prepare($sql);

				$query -> bindParam(1, $techId, 		\PDO::PARAM_INT);
				$query -> bindParam(2, $fallaId, 		\PDO::PARAM_INT);
				$query -> bindParam(3, $observaciones,  \PDO::PARAM_STR);
				$query -> bindParam(4, $empresaId, 		\PDO::PARAM_INT);
				$query -> bindParam(5, $status, 		\PDO::PARAM_STR);
				$query -> bindParam(6, $equipoId, 		\PDO::PARAM_INT);
				$query -> bindParam(7, $userId, 		\PDO::PARAM_INT);
				$query -> bindParam(8, $incidenciaId, 	\PDO::PARAM_INT);
				
				$count = $count + $query -> execute();

				/*
				 * Se debe crear una entrada por equipo para mostrarla en el HISTORIAL DE UN EQUIPO
				 */
				Transaccion::insertTransaccionEquipo2("Tecnico_Reporte_Visita_Crear", "Ok", $techId, 
						$_SESSION['role_user'], $_SESSION['logged_user_empresaId'], "fallaId = 100 | " . $observaciones , $equipoId, $incidenciaId);
			}
			
			$out["quantity"] = $count;
			$out["error"] = "";
			return $out;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.insertReporteVisita():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:".$userId. " | empresa:".$empresaId." | techId:".$techId." | $equipoId, $cantidad | fallaId = 100";
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Crear",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			$out["quantity"] = 0;
			$out["error"] = $internalErrorCodigo . " " . $internalErrorMessage . " " . $internalErrorExtra;
			return $out;
		}
	}

	/**
	 * Se procederá a crear UN REPORTE por CADA EQUIPO que tiene UNA Empresa
	 */
	public static function insertReporteGeneralVisita($tech, $empresaId){
		try {
			$connection = Database::instance();

			$techId = $tech->id;

			/*
			 * Datos generales de todos
			 * VALORES MAYORES A 100: reservados para Tecnicos y Reportes
			 */
			$fallaId = 101;
			
			$observaciones = "REPORTE_VISITA | Creado_por_Tecnico_id:" . $techId . " | Empresa_id:".$empresaId;
			$status = "En Progreso";

			$sql = " INSERT INTO Incidencias ( "
					. " tecnicoId, fallaId, observaciones, empresaId, status, equipoId, usuarioId, incidenciaId ) " 
					. " VALUES ( ?, ?, ?, ?, ?, ?, ?, ? ) ";

			$count = 0;

			/* Buscando el ID a insertar */
			$incidenciaId = Equipos::getMaxID("Incidencias");


			$equipos = Equipos::getEquiposDeEmpresa2($empresaId);

			foreach ( $equipos as $equipo ){

				$incidenciaId++;

				$query = $connection -> prepare($sql);

				/**/
				$text = "Equipo: " . $equipo["codigoBarras"];
				if ( $equipo["nombre"] != NULL && $equipo["nombre"] != "" ){
					$text .= " Usuario: " . $equipo["nombre"] . " " . $equipo["apellido"];
				} else {
					$text .= " Usuario: No asignado";
				}
				$text .= " | " . $observaciones;

				/**/
				$equipoId = $equipo["id"];

				/**/
				if ( $equipo["usuarioId"] != NULL && $equipo["usuarioId"] != "" ){
					$userId = $equipo["usuarioId"];
				} else {
					$userId = NULL;
				}

				$query -> bindParam(1, $techId, 		\PDO::PARAM_INT);
				$query -> bindParam(2, $fallaId, 		\PDO::PARAM_INT);
				$query -> bindParam(3, $text,  			\PDO::PARAM_STR);
				$query -> bindParam(4, $empresaId, 		\PDO::PARAM_INT);
				$query -> bindParam(5, $status, 		\PDO::PARAM_STR);
				$query -> bindParam(6, $equipoId, 		\PDO::PARAM_INT);
				$query -> bindParam(7, $userId, 		\PDO::PARAM_INT);
				$query -> bindParam(8, $incidenciaId, 	\PDO::PARAM_INT);
				
				$count = $count + $query -> execute();

				/*
				 * Se debe crear una entrada por equipo para mostrarla en el HISTORIAL DE UN EQUIPO
				 */
				Transaccion::insertTransaccionEquipo2("Tecnico_Reporte_Visita_Crear", "Ok", $techId, 
						$_SESSION['role_user'], $_SESSION['logged_user_empresaId'], "fallaId = 101 | " . $observaciones , $equipoId, $incidenciaId);
			}

			$out["quantity"] = $count;
			$out["error"] = "";
			return $out;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.insertReporteGeneralVisita():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "Empresa:".$empresaId." | techId:".$techId . " | fallaId = 101";
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Crear",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			$out["quantity"] = 0;
			$out["error"] = $internalErrorCodigo . " " . $internalErrorMessage . " " . $internalErrorExtra;
			return $out;
		}
	}


	/**
	 * Asigna a ESTE TECNICO esta INCIDENCIA
	 */
	public static function updateSolucion($incidenciaId, $solucionId, $laborDelEquipo, 
			$variableEndogena, $variableExogenaTecnica, $variableExogenaHumana,
			$mantenimientoHardware, $mantenimientoSoftware, $acompanamientoJunior){

		try {

			$connection = Database::instance();

			$sql = " UPDATE Soluciones sol SET sol.laborDelEquipo = ?,
					sol.variableEndogena = ?, sol.variableExogenaTecnica = ?,
					sol.variableExogenaHumana = ?, sol.mantenimientoHardware = ?,
					sol.mantenimientoSoftware = ?, sol.acompanamientoJunior = ?
					WHERE sol.incidenciaId = ? AND sol.solucionId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $laborDelEquipo, \PDO::PARAM_STR);
			$query -> bindParam(2, $variableEndogena, \PDO::PARAM_STR);
			$query -> bindParam(3, $variableExogenaTecnica, \PDO::PARAM_STR);
			$query -> bindParam(4, $variableExogenaHumana, \PDO::PARAM_STR);
			$query -> bindParam(5, $mantenimientoHardware, \PDO::PARAM_STR);
			$query -> bindParam(6, $mantenimientoSoftware, \PDO::PARAM_STR);
			$query -> bindParam(7, $acompanamientoJunior, \PDO::PARAM_STR);

			$query -> bindParam(8, $incidenciaId, \PDO::PARAM_INT);
			$query -> bindParam(9, $solucionId, \PDO::PARAM_INT);

			return $query -> execute();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.updateSolucion():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$incidenciaId, $solucionId, $laborDelEquipo, $variableEndogena, $variableExogenaTecnica, $variableExogenaHumana, $mantenimientoHardware, $mantenimientoSoftware, $acompanamientoJunior";
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_Cerrada",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * muestra Incidencias/Reportes pasadas de un Usuario
	 */
	public static function getHistoricoIncidencias($userId){
		try {
			$connection = Database::instance();

			$sql = " SELECT i.incidenciaId,i.equipoId,i.fecha, 
					 f.nombre AS falla, 
					 eq.codigoBarras AS codigoBarras, 
					 i.observaciones, i.status, i.tecnicoId, 
					 u.nombre AS Tecnico_nombre, u.apellido  AS Tecnico_apellido,  
					 i.fecha_enEspera, i.fecha_reply, i.fecha_enProgreso, i.resolucionId, 
					 i.enEsperaPor, 
					 i.respuestaEsperada 
					FROM Incidencias i  
					 INNER JOIN FallasGenerales f ON i.fallaId = f.fallaId  
					 LEFT JOIN Usuarios u ON i.tecnicoId = u.id 
					 LEFT JOIN Equipos eq ON i.equipoId = eq.id 
					WHERE i.usuarioId = ? OR ( i.fallaId >= 100 AND eq.usuarioId = ? ) ";

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $userId, \PDO::PARAM_INT);
			$query -> bindParam(2, $userId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getHistoricoIncidencias(userId):";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "userId:". $userId;
			
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
	 * @param $incidenciaId 
	 * @return Objeto de la BD con el userId y las IncidenciasSinOpinar
	 */
	public static function getIncidenciasSinOpinar($incidenciaId){

		try {
			$connection = Database::instance();

			$sql = "SELECT ue.userId, ue.incidenciasSinOpinar 
				FROM UsuarioEstatus ue 
				WHERE ue.userId = (
					SELECT i.usuarioId FROM Incidencias i WHERE i.incidenciaId = ?
				)";

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $incidenciaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetch( \PDO::FETCH_OBJ );
			
		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getIncidenciasSinOpinar(incidenciaId):";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "incidenciaId:". $incidenciaId;
			
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
	 * @param $incidenciaId 
	 * @param $json String para insertar/update 
	 * @return 
	 */
	public static function agregarAFaltaPorOpinarJSON( $userId, $jsonString ){

		try {
			$connection = Database::instance();

			$sql = " UPDATE UsuarioEstatus SET incidenciasSinOpinar = ? WHERE userId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $jsonString,  \PDO::PARAM_STR);
			$query -> bindParam(2, $userId,      \PDO::PARAM_INT);

			$count = $query -> execute();

			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.agregarAFaltaPorOpinarJSON(userId, jsonString):";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "userId:". $userId . " - jsonString: $jsonString ";
			
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
	 * @param $incidenciaId 
	 * @param $json String para insertar/update 
	 * @return 
	 */
	public static function buscarIncidenciasSinOpinar( $incidenciaId ){
		try {
			$connection = Database::instance();
			/*
			 * Buscando Campo a ver què tiene
			 */
			$sql = ' SELECT * FROM UsuarioEstatus ue 
					WHERE ue.incidenciasSinOpinar LIKE "'
					. '%\"id\":\"' . $incidenciaId . '\"%"' ;

			$query = $connection -> prepare($sql);

			$query -> execute();

			$result = $query -> fetch( \PDO::FETCH_OBJ );

			return $result;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.buscarIncidenciasSinOpinar(incidenciaId):";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "incidenciaId:". $incidenciaId;
			
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
	 *  JSON actualizando objeto
	 */
	public static function incidenciaOpinada2($userEstatusId, $json){
		try {

			$connection = Database::instance();

			$sql = " UPDATE UsuarioEstatus ue SET ue.incidenciasSinOpinar = ? WHERE ue.userId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $json, \PDO::PARAM_STR);
			$query -> bindParam(2, $userEstatusId, \PDO::PARAM_INT);

			$count = $query -> execute();

			if ( $count == 1 ){
				
				return true;
			}

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.incidenciaOpinada2(userEstatusId, json):";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:".$userEstatusId. " - JSON:".$json;
			
			/**/
			Transaccion::insertTransaccionPDOException("Incidencia_En_Progreso",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 *  Se sabe si es o no un REPORTE_VISITA
	 * @return TRUE si lo es, FALSE si es una Incidencia
	 */
	public static function esReporteDeVisita( $incidenciaId ){
		try {
			$connection = Database::instance();
			/*
			 * Buscando Campo a ver què tiene
			 */
			$sql = "SELECT * 
					FROM Incidencias i 
					WHERE i.incidenciaId = ? 
					AND i.observaciones LIKE '%REPORTE_VISITA |%'" ;

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $incidenciaId, \PDO::PARAM_INT);

			$query -> execute();

			$result = $query -> fetch( \PDO::FETCH_OBJ );

			if ( $result == NULL || $result == "" ){
				return false;
			} else {
				return true;
			}
			
		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.esReporteDeVisita(incidenciaId):";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "incidenciaId:". $incidenciaId;
			
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
	 * Obtener info de la tabla CambioSoftware, si existen
	 */
	public static function getIncidenciaById($incidenciaId){
		try {

			$connection = Database::instance();

			$sql = "SELECT * FROM Incidencias WHERE incidenciaId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $incidenciaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetch();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Incidencias.getIncidenciaById():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "incidenciaId:". $incidenciaId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Consultar_Incidencias",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

}