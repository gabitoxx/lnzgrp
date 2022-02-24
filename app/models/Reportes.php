<?php
namespace app\models;
defined("APPPATH") OR die("Access denied");

use \core\Database,
	\core\View,
	\app\models\admin\Transaccion;
 
/**
 * Clase que alberga funcionalidades genéricas
 */
class Reportes {

	/**
	 * Filtros:
	 */
	private static $FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO = " AND eq.estatus <> 'Suspendido' ";



	/**
	 * Todo lo concerniente a Reportes sobre Equipos de UNA EMPRESA
	 * NO toma en cuenta rangos de fechas
	 * @return an Array Object[] {"Cantidad_Equipos", "Equipos_Asignados", "Equipos_No_Asignados"}
 	 */
	public static function reporteEquiposDashboard($empresaId){
		try {
			$connection = Database::instance();

			/**/
			$sql1 = " SELECT COUNT(eq.id) AS Cantidad_Equipos 
					FROM Equipos eq 
					WHERE eq.empresaId = ? "
					 . self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO;

			$query1 = $connection -> prepare($sql1);

			$query1 -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query1 -> execute();

			$r1 = $query1 -> fetch(\PDO::FETCH_OBJ );

			$out["Cantidad_Equipos"] = $r1->Cantidad_Equipos;

			/**/
			$sql2 = " SELECT COUNT(eq.id) AS Equipos_Asignados 
					FROM Equipos eq 
					WHERE eq.empresaId = ? AND eq.usuarioId IS NOT NULL "
					 . self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO;

			$query2 = $connection -> prepare($sql2);

			$query2 -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query2 -> execute();

			$r2 = $query2 -> fetch(\PDO::FETCH_OBJ );

			$out["Equipos_Asignados"] = $r2->Equipos_Asignados;

			/**/
			$r3 = ($r1->Cantidad_Equipos - $r2->Equipos_Asignados + 0);

			$out["Equipos_No_Asignados"] = $r3;

			/***/
			return $out;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.reporteEquiposDashboard():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Tipos de Equipos de UNA EMPRESA
	 * NO toma en cuenta rangos de fechas
	 * @return Object[0-Array_Presentaciones, 1-Array_Cantidades_de_cada_Presentacion ]
 	 */
	public static function presentacionesEquiposDashboard($empresaId){
		$array = "";
		try {
			$connection = Database::instance();

			$sql = " SELECT te.nombre AS Presentacion
					FROM Equipos eq
					INNER JOIN TipoEquipos te ON te.tipoEquipoId = eq.tipoEquipoId 
					WHERE eq.empresaId = ? "
					 . self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO
					. " ORDER BY Presentacion ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			$array = $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.presentacionesEquiposDashboard():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}

		/* Recorrido de presentaciones */
		$auxActual = ""; $auxAnterior = "";
		$index = 0; $cont = 0; $y = 0;
		$tipoEquipo[0] = ""; $cantidadEquipo[0] = 0;

		foreach ($array as $tipo) {

			$auxActual = $tipo["Presentacion"];

			$y++;
			if ( $y == 1 ){
				/* se salta la 1ra vez. */
				$auxAnterior = $auxActual;
				$cont++;
				continue;
			}
			
			if ( $auxActual == $auxAnterior ){
				/* si es el mismo que el anterior, se suma 1 y ya */
				$cont++;
				continue;

			} else {
				/* se añade a los totales */
				$cantidadEquipo[$index] = $cont;
				$tipoEquipo[$index]		= $auxAnterior;

				/* reinician valores */
				$auxAnterior = $auxActual;
				$index++;
				$cont = 1;
			}
		}
		/* Añadiendo el ultimo elemento */
		$cantidadEquipo[$index] = $cont;
		$tipoEquipo[$index]		= $auxActual;
		
		/* Armando el Objeto retorno */
		$out[0] = $tipoEquipo;
		$out[1] = $cantidadEquipo;

		return $out;
	}

	/**
	 * Usuarios de Equipos de UNA EMPRESA
	 * NO toma en cuenta rangos de fechas
	 * @return listado de Usuarios
 	 */
	public static function usuariosEquiposDashboard($empresaId){
		try {
			$connection = Database::instance();

			$sql = " SELECT u.nombre, u.apellido, u.dependencia, u.telefonoTrabajo, u.extensionTrabajo, u.role 
					FROM Usuarios u WHERE u.id IN (
					  SELECT DISTINCT(eq.usuarioId) FROM Equipos eq WHERE eq.empresaId = ? AND eq.usuarioId IS NOT NULL "
					  . self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO
					. " ) 
					ORDER BY u.nombre ASC ";

			$query = $connection -> prepare($sql);
			
			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.usuariosEquiposDashboard():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Uso del Portal, de UNA EMPRESA
	 * SOLO se da las del MES en curso
	 * @return Object[] {"Numero_veces_ingreso_Portal", "Numero_incidencias_creadas", "Cantidad_Usuarios"}
 	 */
	public static function usoPortalDashboard($empresaId){
		try {
			$connection = Database::instance();

			/*
			 * Buscando mes actual y el siguiente
			 */
			$year  = date('Y', time());
			$month = date('m', time());

			$fechaDesde = $year . "-" . $month;

			if ( $month == 11 ){
				/* es diciembre, entonces ENERO del año actual + 1 */
				$fechaHasta = ($year + 1) . "-01";
			} else {
				/* siguiente mes */
				$fechaHasta = $year . "-" . ($month + 1);
			}

			/**/
			$sql1 = " SELECT COUNT(t.transaccionId) AS Numero_veces_ingreso_Portal FROM Transaccion t
				WHERE t.empresaId = ? AND t.tipo_transaccion = 'Usuario_LogIn' AND 
				( t.fecha_hora > '" .$fechaDesde. "-01 00:00.00' AND t.fecha_hora < '" .$fechaHasta. "-01 00:00.00' ) ";

			$query1 = $connection -> prepare($sql1);

			$query1 -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query1 -> execute();

			$r1 = $query1 -> fetch(\PDO::FETCH_OBJ );

			$out["Numero_veces_ingreso_Portal"] = $r1->Numero_veces_ingreso_Portal;

			/**/
			$sql2 = " SELECT COUNT(t.transaccionId) AS Numero_incidencias_creadas FROM Transaccion t 
					WHERE t.empresaId = ? AND t.tipo_transaccion = 'Incidencia_Crear' AND 
					( t.fecha_hora > '" .$fechaDesde. "-01 00:00.00' AND t.fecha_hora < '" .$fechaHasta. "-01 00:00.00' ) ";

			$query2 = $connection -> prepare($sql2);

			$query2 -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query2 -> execute();

			$r2 = $query2 -> fetch(\PDO::FETCH_OBJ );

			$out["Numero_incidencias_creadas"] = $r2->Numero_incidencias_creadas;

			/**/
			$sql3 = " SELECT COUNT(u.id) AS Cantidad_Usuarios FROM Usuarios u WHERE u.empresaId = ? ";

			$query3 = $connection -> prepare($sql3);

			$query3 -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query3 -> execute();

			$r3 = $query3 -> fetch(\PDO::FETCH_OBJ );

			$out["Cantidad_Usuarios"] = $r3->Cantidad_Usuarios;

			/***/
			return $out;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.usoPortalDashboard():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Uso del Portal, de UNA EMPRESA
	 * SOLO el AÑO actual
	 * @return Object[] {"Numero_Incidencias", "Numero_tecnicos_que_han_visitado_empresa"}
 	 */
	public static function estadisticasIncidenciasDashboard($empresaId, $searchYear){
		try {
			$connection = Database::instance();

			/* AÑO actual */
			$yearDesde = date('Y', time());
			$yearHasta = ( $yearDesde + 1 );

			if ( $searchYear != NULL && $searchYear != "" && $searchYear > 2016 ){
				$yearDesde = $searchYear;
				$yearHasta = ( $yearDesde + 1 );
			}

			/**/
			$sql1 = " SELECT COUNT(i.incidenciaId) AS Numero_Incidencias FROM Incidencias i WHERE i.empresaId = ? 
					AND i.fallaId < 100 
					AND ( fecha > '" .$yearDesde. "-01-01 00:00.00' AND fecha < '" .$yearHasta. "-01-01 00:00.00' ) ";

			$query1 = $connection -> prepare($sql1);

			$query1 -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query1 -> execute();

			$r1 = $query1 -> fetch(\PDO::FETCH_OBJ );

			$out["Numero_Incidencias"] = $r1->Numero_Incidencias;

			/**/
			$sql2 = " SELECT COUNT( DISTINCT(i.tecnicoId) ) AS Numero_tecnicos_que_han_visitado_empresa 
					FROM Incidencias i WHERE i.empresaId = ? AND i.tecnicoId IS NOT NULL  ";

			$query2 = $connection -> prepare($sql2);

			$query2 -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query2 -> execute();

			$r2 = $query2 -> fetch(\PDO::FETCH_OBJ );

			$out["Numero_tecnicos_que_han_visitado_empresa"] = $r2->Numero_tecnicos_que_han_visitado_empresa;
			
			/***/
			return $out;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.estadisticasIncidenciasDashboard():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Quienes son los que han levantado Incidencias, de UNA EMPRESA
	 * No toma en cuenta el tiempo, solo el AÑO ACTUAL
	 * @return listado
 	 */
	public static function usuariosDeIncidenciasDashboard($empresaId, $searchYear){
		try {
			$connection = Database::instance();

			/* AÑO actual */
			$yearDesde = date('Y', time());
			$yearHasta = ( $yearDesde + 1 );

			if ( $searchYear != NULL && $searchYear != "" && $searchYear > 2016 ){
				$yearDesde = $searchYear;
				$yearHasta = ( $yearDesde + 1 );
			}

			/**/
			$sql = " SELECT u.id, u.nombre, u.apellido, u.dependencia, u.telefonoTrabajo, u.extensionTrabajo, u.role 
					 FROM Usuarios u
					 WHERE u.id IN ( 
						SELECT DISTINCT(i.usuarioId) FROM Incidencias i WHERE i.empresaId = ?
						AND ( i.fecha > '" .$yearDesde. "-01-01 00:00.00' AND i.fecha < '" .$yearHasta. "-01-01 00:00.00' ) 
					) ORDER BY u.nombre ASC ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.usuariosDeIncidenciasDashboard():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Tecnicos que han visitado UNA EMPRESA
	 * No toma en cuenta el tiempo, solo el AÑO ACTUAL
	 * @return listado
 	 */
	public static function tecnicosEnEmpresaDashboard($empresaId, $searchYear){
		try {
			$connection = Database::instance();

			/* AÑO actual */
			$yearDesde = date('Y', time());
			$yearHasta = ( $yearDesde + 1 );

			if ( $searchYear != NULL && $searchYear != "" && $searchYear > 2016 ){
				$yearDesde = $searchYear;
				$yearHasta = ( $yearDesde + 1 );
			}

			/**/
			$sql = " SELECT u.nombre, u.apellido, u.email FROM Usuarios u WHERE u.role = 'tech' AND u.id IN 
					( SELECT DISTINCT(i.tecnicoId) FROM Incidencias i WHERE i.empresaId = ? AND i.tecnicoId IS NOT NULL
						AND ( i.fecha > '" .$yearDesde. "-01-01 00:00.00' AND i.fecha < '" .$yearHasta. "-01-01 00:00.00' ) 
					) ORDER BY u.nombre ASC ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.tecnicosEnEmpresaDashboard():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Calsificacion de Incidencias de UNA EMPRESA - por Estatus
	 * No toma en cuenta el tiempo, solo el AÑO ACTUAL
	 * @return Object[] {"Numero_Incidencias_Status_Abierta", "Numero_Incidencias_Status_En_Progreso",
	 * 		"Numero_Incidencias_Status_En_Espera", "Numero_Incidencias_Status_Cerrada", 
	 *		"Numero_Incidencias_Status_Certificada",     "Numero_Incidencias_Total"    }
 	 */
	public static function clasificacionIncidenciasDashboard($empresaId, $searchYear){
		try {
			$connection = Database::instance();

			/* AÑO actual */
			$yearDesde = date('Y', time());
			$yearHasta = ( $yearDesde + 1 );

			if ( $searchYear != NULL && $searchYear != "" && $searchYear > 2016 ){
				$yearDesde = $searchYear;
				$yearHasta = ( $yearDesde + 1 );
			}

			/**/
			$sql1 = " SELECT COUNT(i.incidenciaId) AS Numero_Incidencias_Status_Abierta FROM Incidencias i 
					WHERE i.empresaId = ? AND i.status = 'Abierta' AND i.fallaId < 100 
					AND ( i.fecha > '" .$yearDesde. "-01-01 00:00.00' AND i.fecha < '" .$yearHasta. "-01-01 00:00.00' ) ";

			$query1 = $connection -> prepare($sql1);

			$query1 -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query1 -> execute();

			$r1 = $query1 -> fetch(\PDO::FETCH_OBJ );

			$out["Numero_Incidencias_Status_Abierta"] = $r1->Numero_Incidencias_Status_Abierta;

			/**/
			$sql2 = " SELECT COUNT(i.incidenciaId) AS Numero_Incidencias_Status_En_Progreso FROM Incidencias i 
					WHERE i.empresaId = ? AND i.status = 'En Progreso' AND i.fallaId < 100 
					AND ( i.fecha > '" .$yearDesde. "-01-01 00:00.00' AND i.fecha < '" .$yearHasta. "-01-01 00:00.00' ) ";

			$query2 = $connection -> prepare($sql2);

			$query2 -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query2 -> execute();

			$r2 = $query2 -> fetch(\PDO::FETCH_OBJ );

			$out["Numero_Incidencias_Status_En_Progreso"] = $r2->Numero_Incidencias_Status_En_Progreso;

			/**/
			$sql3 = " SELECT COUNT(i.incidenciaId) AS Numero_Incidencias_Status_En_Espera FROM Incidencias i 
					WHERE i.empresaId = ? AND i.status = 'En Espera' AND i.fallaId < 100 
					AND ( i.fecha > '" .$yearDesde. "-01-01 00:00.00' AND i.fecha < '" .$yearHasta. "-01-01 00:00.00' ) ";

			$query3 = $connection -> prepare($sql3);

			$query3 -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query3 -> execute();

			$r3 = $query3 -> fetch(\PDO::FETCH_OBJ );

			$out["Numero_Incidencias_Status_En_Espera"] = $r3->Numero_Incidencias_Status_En_Espera;

			/**/
			$sql4 = " SELECT COUNT(i.incidenciaId) AS Numero_Incidencias_Status_Cerrada FROM Incidencias i 
					WHERE i.empresaId = ? AND i.status = 'Cerrada' AND i.fallaId < 100 
					AND ( i.fecha > '" .$yearDesde. "-01-01 00:00.00' AND i.fecha < '" .$yearHasta. "-01-01 00:00.00' ) ";

			$query4 = $connection -> prepare($sql4);

			$query4 -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query4 -> execute();

			$r4 = $query4 -> fetch(\PDO::FETCH_OBJ );

			$out["Numero_Incidencias_Status_Cerrada"] = $r4->Numero_Incidencias_Status_Cerrada;

			/**/
			$sql5 = " SELECT COUNT(i.incidenciaId) AS Numero_Incidencias_Status_Certificada FROM Incidencias i 
					WHERE i.empresaId = ? AND i.status = 'Certificada' AND i.fallaId < 100 
					AND ( i.fecha > '" .$yearDesde. "-01-01 00:00.00' AND i.fecha < '" .$yearHasta. "-01-01 00:00.00' ) ";

			$query5 = $connection -> prepare($sql5);

			$query5 -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query5 -> execute();

			$r5 = $query5 -> fetch(\PDO::FETCH_OBJ );

			$out["Numero_Incidencias_Status_Certificada"] = $r5->Numero_Incidencias_Status_Certificada;

			/* Cuenta Total */
			$r6 = (0 + $r1->Numero_Incidencias_Status_Abierta + $r2->Numero_Incidencias_Status_En_Progreso 
					+ $r3->Numero_Incidencias_Status_En_Espera + $r4->Numero_Incidencias_Status_Cerrada
					+ $r5->Numero_Incidencias_Status_Certificada);

			$out["Numero_Incidencias_Total"] = $r6;

			/***/
			return $out;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.clasificacionIncidenciasDashboard():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Clasificacion de Incidencias de UNA EMPRESA - por el tipo de Variables que han occasionado los problemas
	 * No toma en cuenta el tiempo, solo el AÑO ACTUAL
	 * @return Object[] con 6 listados
 	 */
	public static function clasificacionCausasIncidenciasDashboard($empresaId, $searchYear){
		$array = NULL;
		try {
			$connection = Database::instance();

			/* AÑO actual */
			$yearDesde = date('Y', time());
			$yearHasta = ( $yearDesde + 1 );

			if ( $searchYear != NULL && $searchYear != "" && $searchYear > 2016 ){
				$yearDesde = $searchYear;
				$yearHasta = ( $yearDesde + 1 );
			}

			/**/
			$sql = " SELECT sol.variableEndogena, sol.variableExogenaTecnica, sol.variableExogenaHumana, sol.incidenciaId, sol.solucionId 
					FROM Soluciones sol WHERE sol.incidenciaId IN 
					( SELECT i.incidenciaId FROM Incidencias i WHERE i.empresaId = ? 
						AND ( i.fecha > '" .$yearDesde. "-01-01 00:00.00' AND i.fecha < '" .$yearHasta. "-01-01 00:00.00' ) 
					) ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			$array = $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.clasificacionCausasIncidenciasDashboard():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}

		$endogena[0] = ""; $endogenaId[0] = 0;
		$exogena[0]  = ""; $exogenaId[0]  = 0;
		$humana[0]   = ""; $humanaId[0]   = 0;

		$i = 0;
		foreach ( $array as $variable ) {

			if ( $variable["variableEndogena"] != NULL && $variable["variableEndogena"] != "" ){

				$endogena[$i]   = $variable["variableEndogena"];
				$endogenaId[$i] = $variable["solucionId"];
			}

			if ( $variable["variableExogenaTecnica"] != NULL && $variable["variableExogenaTecnica"] != "" ){

				$exogena[$i]   = $variable["variableExogenaTecnica"];
				$exogenaId[$i] = $variable["solucionId"];
			}

			if ( $variable["variableExogenaHumana"] != NULL && $variable["variableExogenaHumana"] != "" ){

				$humana[$i]   = $variable["variableExogenaHumana"];
				$humanaId[$i] = $variable["solucionId"];
			}

			$i++;
		}

		$out["endogena"]  = $endogena;
		$out["endogenaId"]= $endogenaId;
		$out["exogena"]   = $exogena;
		$out["exogenaId"] = $exogenaId;
		$out["humana"] 	  = $humana; 
		$out["humanaId"]  = $humanaId;

		return $out;
	}
	

	/**
	 * Duracion Promedio en resolver Incidencias de UNA EMPRESA
	 * No toma en cuenta el tiempo, solo el AÑO ACTUAL
	 * @return listado
 	 */
	public static function duracionPromedioIncidenciasDashboard($empresaId, $searchYear){
		try {
			$connection = Database::instance();

			/* AÑO actual */
			$yearDesde = date('Y', time());
			$yearHasta = ( $yearDesde + 1 );

			if ( $searchYear != NULL && $searchYear != "" && $searchYear > 2016 ){
				$yearDesde = $searchYear;
				$yearHasta = ( $yearDesde + 1 );
			}

			/**/
			$sql = " SELECT sol.incidenciaDuracionDias FROM Soluciones sol 
					WHERE sol.incidenciaDuracionDias IS NOT NULL AND sol.incidenciaId IN 
					( SELECT i.incidenciaId FROM Incidencias i WHERE i.empresaId = ? AND i.fallaId < 100 
						AND ( i.fecha > '" .$yearDesde. "-01-01 00:00.00' AND i.fecha < '" .$yearHasta. "-01-01 00:00.00' ) 
					) ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.duracionPromedioIncidenciasDashboard():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Numero de Reemplazos de HARDWARE de UNA EMPRESA
	 * No toma en cuenta el tiempo, solo el AÑO ACTUAL
	 * @return listado
 	 */
	public static function reemplazosHardwareDashboard($empresaId, $searchYear){
		try {
			$connection = Database::instance();

			/* AÑO actual */
			$yearDesde = date('Y', time());
			$yearHasta = ( $yearDesde + 1 );

			if ( $searchYear != NULL && $searchYear != "" && $searchYear > 2016 ){
				$yearDesde = $searchYear;
				$yearHasta = ( $yearDesde + 1 );
			}

			/**/
			$sql = " SELECT * FROM CambioHardware hard WHERE hard.solucionId IN 
					( SELECT sol.solucionId FROM Soluciones sol WHERE sol.incidenciaId IN 
						( SELECT i.incidenciaId FROM Incidencias i WHERE i.empresaId = ? 
							AND ( i.fecha > '" .$yearDesde. "-01-01 00:00.00' AND i.fecha < '" .$yearHasta. "-01-01 00:00.00' ) 
						) 
					)";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.reemplazosHardwareDashboard():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Numero de Reemplazos de SOFTWARE de UNA EMPRESA
	 * No toma en cuenta el tiempo, solo el AÑO ACTUAL
	 * @return listado
 	 */
	public static function reemplazosSoftwareDashboard($empresaId, $searchYear){
		try {
			$connection = Database::instance();

			/* AÑO actual */
			$yearDesde = date('Y', time());
			$yearHasta = ( $yearDesde + 1 );

			if ( $searchYear != NULL && $searchYear != "" && $searchYear > 2016 ){
				$yearDesde = $searchYear;
				$yearHasta = ( $yearDesde + 1 );
			}

			/**/
			$sql = " SELECT * FROM CambioSoftware soft WHERE soft.solucionId IN 
					( SELECT sol.solucionId FROM Soluciones sol WHERE sol.incidenciaId IN 
						( SELECT i.incidenciaId FROM Incidencias i WHERE i.empresaId = ? 
							AND ( i.fecha > '" .$yearDesde. "-01-01 00:00.00' AND i.fecha < '" .$yearHasta. "-01-01 00:00.00' ) 
						) 
					)";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.reemplazosSoftwareDashboard():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Listado de Citas en el Calendario, agenda para esta Empresa
	 * Citas a FUTURO del dia actual
	 * @return listado
 	 */
	public static function agendaFuturaEnEmpresaDashboard($empresaId){
		try {
			$connection = Database::instance();

			/**/
			$sql = " SELECT sp.*, tech.id, tech.nombre, tech.apellido, tech.email 
					FROM SoportesProgramados sp 
					LEFT JOIN Usuarios tech ON sp.tecnicoId = tech.id 
					WHERE sp.empresaId = ? AND sp.fecha_cita >= CURDATE() ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.agendaFuturaEnEmpresaDashboard():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Listado de Citas en el Calendario, agenda para esta Empresa
	 * Citas previas del dia actual, solo de ESTE AÑO
	 * @return listado
 	 */
	public static function agendaPasadasEnEmpresaDashboard($empresaId, $searchYear){
		try {
			$connection = Database::instance();

			/* AÑO actual */
			$yearDesde = date('Y', time());

			if ( $searchYear != NULL && $searchYear != "" && $searchYear > 2016 ){
				$yearDesde = $searchYear;
			}

			/**/
			$sql = " SELECT sp.*, tech.id, tech.nombre, tech.apellido, tech.email
					FROM SoportesProgramados sp 
					LEFT JOIN Usuarios tech ON sp.tecnicoId = tech.id
					WHERE sp.empresaId = ? AND sp.fecha_cita < CURDATE() 
						AND ( sp.fecha_cita > '" .$yearDesde. "-01-01 00:00.00' ) ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.agendaPasadasEnEmpresaDashboard():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Licenciamiento de Office y Windows
	 * @return Object[]
 	 */
	public static function licenciamientoEquiposDashboard($empresaId){
		
		try {
			$connection = Database::instance();

			$sql = " SELECT eq.licWindows, eq.licOffice, eq.equipoSOInfoId, eq.equipoOfimaticaInfoId 
					FROM Equipos eq 
					WHERE eq.empresaId = ? "
					 . self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO;

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);
			
			$query -> execute();

			$array = $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.getCitasPreviasAnyoActual():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}

		/*************************************************************************************
		 * Transformando valores para el grafico de torta
		 */
		$win_contSi = 0; $win_contNo = 0; $win_contUnknown = 0; $win_fks[0] = 0; $win_sinData = 0;
		$off_contSi = 0; $off_contNo = 0; $off_contUnknown = 0; $off_fks[0] = 0; $lic_sinData = 0;

		$i = -1;
		foreach ( $array as $variable ) {
			$i++;

			/* Windows */
			$aux = $variable["licWindows"];
			if ( $aux == "Si" ){					$win_contSi++;
			} else if ( $aux == "No" ){				$win_contNo++;
			} else if ( $aux == "Desconocido" ){
				if ( $variable["equipoSOInfoId"] != null && $variable["equipoSOInfoId"] != "" ){
					$win_fks[ $win_contUnknown ] = $variable["equipoSOInfoId"];
					$win_contUnknown++;
				} else {
					 $win_sinData++;
				}
			}

			/* Ofimática */
			$aux1 = $variable["licOffice"];
			if ( $aux1 == "Si" ){					$off_contSi++;
			} else if ( $aux1 == "No" ){			$off_contNo++;
			} else if ( $aux1 == "Desconocido" ){
				if ( $variable["equipoOfimaticaInfoId"] != null && $variable["equipoOfimaticaInfoId"] != "" ){
					$off_fks[ $off_contUnknown ] = $variable["equipoOfimaticaInfoId"];
					$off_contUnknown++;
				} else {
					$lic_sinData++;
				}
			}
		}

		/********************************************************************
		 * Version 2 de almacenamiento de esta info: 
		 * buscar en las FK equipoSOInfoId y equipoOfimaticaInfoId
		 */
		$NOwin_siLic = 0; $NOwin_noLic = 0;

		if ( $win_contUnknown > 0 ){

			$responseWin = Reportes::buscarLicenciasSistemasOperativos( $win_fks, $win_contUnknown );

			$win_contSi = $win_contSi + $responseWin["windows_si"];
			$win_contNo = $win_contNo + $responseWin["windows_no"];

			$NOwin_siLic = $responseWin["otros_si"];
			$NOwin_noLic = $responseWin["otros_no"];
		}

		$NOoff_siLic = 0; $NOoff_noLic = 0;

		if ( $off_contUnknown > 0 ){

			$responseOff = Reportes::buscarLicenciasOfimaticas( $off_fks, $off_contUnknown );

			$off_contSi = $off_contSi + $responseOff["office_si"];
			$off_contNo = $off_contNo + $responseOff["office_no"];
			
			$NOoff_siLic = $responseOff["otro_office_si"];
			$NOoff_noLic = $responseOff["otro_office_no"];
		}


		/****************************************************************
		 * Valores a devolver
		 */
		$out["win_contSi"] 		= $win_contSi;
		$out["win_contNo"] 		= $win_contNo;
		$out["win_contUnknown"] = $win_sinData;
		$out["win_otrosSO_Si"]  = $NOwin_siLic;
		$out["win_otrosSO_No"]  = $NOwin_noLic;

		$out["off_contSi"] 		= $off_contSi;
		$out["off_contNo"] 		= $off_contNo;
		$out["off_contUnknown"] = $lic_sinData;
		$out["off_otros_Si"] 	= $NOoff_siLic;
		$out["off_otros_No"] 	= $NOoff_noLic;

		/**/
		return $out;
	}


	/**
	 * Todos los Equipos de una Empresa
	 * @return listado
 	 */
	public static function equiposReporte($empresaId){
		try {
			$connection = Database::instance();

			$sql = " SELECT eq.*, te.nombre AS TipoEquipo 
					FROM Equipos eq 
					LEFT JOIN TipoEquipos te ON eq.tipoEquipoId = te.tipoEquipoId 
					WHERE eq.empresaId = ? "
					. self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO;

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);
			
			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.equiposReporte():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Todos los VALORES $ Equipos de una Empresa
	 * @return listado
 	 */
	public static function valoresEquiposReporte($empresaId){
		try {
			$connection = Database::instance();

			$sql = " SELECT eq.codigoBarras, eq.valor, eq.valorReposicion, eq.nombreEquipo, eq.gama  
					FROM Equipos eq WHERE eq.empresaId = ? "
					. self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO;

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);
			
			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.valoresEquiposReporte():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * tabla: Memoria y Tarjetas
	 * @return listado
 	 */
	public static function memoriaYtarjetasEquiposReporte($empresaId){
		try {
			$connection = Database::instance();

			$sql = " SELECT eq.codigoBarras, eq.nombreEquipo, 
					 cpu.AddressWidth, cpu.Name AS CPU_Name, cpu.NumberOfCores,
					 mb.Name AS Motherboard, mb.Product
					FROM Equipos eq LEFT JOIN EquipoInfo ei ON eq.equipoInfoId = ei.equipoInfoId 
					 LEFT JOIN ICPU cpu ON ei.cpuId = cpu.cpuId 
					 LEFT JOIN IMotherBoard mb ON ei.motherboardId = mb.motherboardId 
					WHERE eq.empresaId = ?
					 AND cpu.isLegacy = ? AND mb.isLegacy = ? "
					 . self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO;

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$f = false;
			$query -> bindParam(2, $f, \PDO::PARAM_BOOL);
			$query -> bindParam(3, $f, \PDO::PARAM_BOOL);
			
			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.memoriaYtarjetasEquiposReporte():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * tabla: Memoria y Tarjetas //Discos y Uso del Equipo
	 * @return listado
 	 */
	public static function RAMdeEquiposReporte($empresaId){
		try {
			$connection = Database::instance();

			$sql = " SELECT eq.codigoBarras, ram.BankLabel, ram.Capacity, ram.Speed 
					FROM IRAM ram 
					 INNER JOIN Equipos eq ON eq.equipoInfoId = ram.equipoInfoId 
					WHERE eq.empresaId = ? AND ram.isLegacy = ? "
					 . self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO;

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$f = false;
			$query -> bindParam(2, $f, \PDO::PARAM_BOOL);
			
			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.RAMdeEquiposReporte():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * tabla: Memoria y Tarjetas
	 * @return listado
 	 */
	public static function soundYvideoTarjetasReporte($empresaId){
		try {
			$connection = Database::instance();

			$sql1 = " SELECT eq.codigoBarras, COUNT(so.Caption) AS cantidad 
					FROM ISound so 
					 INNER JOIN Equipos eq ON eq.equipoInfoId = so.equipoInfoId 
					WHERE eq.empresaId = ? 
					 AND so.isLegacy = ? "
					 . self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO 
					. " GROUP BY eq.codigoBarras ";

			$query1 = $connection -> prepare($sql1);

			$query1 -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$f = false;
			$query1 -> bindParam(2, $f, \PDO::PARAM_BOOL);
			
			$query1 -> execute();

			$out["sonido"] = $query1 -> fetchAll();

			/**/
			$sql2 = " SELECT eq.codigoBarras, COUNT(vi.Name) AS cantidad 
					FROM IVideo vi 
					 INNER JOIN Equipos eq ON eq.equipoInfoId = vi.equipoInfoId 
					WHERE eq.empresaId = ? 
					 AND vi.isLegacy = ? "
					 . self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO
					. " GROUP BY eq.codigoBarras ";

			$query2 = $connection -> prepare($sql2);

			$query2 -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query2 -> bindParam(2, $f, \PDO::PARAM_BOOL);
			
			$query2 -> execute();

			$out["video"] = $query2 -> fetchAll();

			/***/
			return $out;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.soundYvideoTarjetasReporte():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * tabla: Discos y Uso del Equipo
	 * @return Object[]
 	 */
	public static function discosDurosYLogicosReporte($empresaId){
		try {
			$connection = Database::instance();

			$sql = " SELECT eq.codigoBarras, eq.nombreEquipo, hd.* 
					FROM IHardDrives hd 
					 INNER JOIN Equipos eq ON eq.equipoInfoId = hd.equipoInfoId 
					WHERE eq.empresaId = ? AND hd.isLegacy = ? "
					 . self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO;

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$f = false;
			$query -> bindParam(2, $f, \PDO::PARAM_BOOL);
			
			$query -> execute();

			$array = $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.discosDurosYLogicosReporte():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
		
		/*
		 * Haciendo la Division de Discos Duros y Particiones Logicas
		 */
		$out["particiones_logicas"] = NULL;
		$out["discos_duros"] = NULL;

		$particion["codigoBarras"] = ""; $arrayParticiones[0] = NULL;
		$disco["codigoBarras"] = ""; 	 $arrayDiscos[0] = NULL;


		$i = -1; $j = -1;
		foreach ( $array as $pl ) {
				
			if ( $pl["DriveLetter"] != NULL ){
				/* nueva particion */
				$i++;

				$particion["codigoBarras"] = $pl["codigoBarras"];
				$particion["nombreEquipo"] = $pl["nombreEquipo"];

				$particion["DriveLetter"] = $pl["DriveLetter"];
				$particion["DriveType"]   = $pl["DriveType"];
				$particion["Capacity"]    = $pl["Capacity"];
				$particion["FreeSpace"]   = $pl["FreeSpace"];

				$arrayParticiones[$i] = $particion;

			} else {
				/* nuevo disco duro */
				$j++;

				$disco["codigoBarras"] = $pl["codigoBarras"];
				$disco["nombreEquipo"] = $pl["nombreEquipo"];

				$disco["Model"] 		= $pl["Model"];
				$disco["InterfaceType"] = $pl["InterfaceType"];
				$disco["Size"]    		= $pl["Size"];

				$arrayDiscos[$j] = $disco;
			}
		}

		$out["total_particiones"] = $i;
		$out["total_discos"]      = $j;

		$out["arrayParticiones"] = $arrayParticiones;
		$out["arrayDiscos"] 	 = $arrayDiscos;

		/***/
		return $out;
	}
	

	/**
	 * tabla: Discos y Uso del Equipo
	 * @return Object[]
 	 */
	public static function SMARTDiscosReporte($empresaId){
		try {
			$connection = Database::instance();

			$sql = " SELECT eq.codigoBarras, sm.Model, 
					 sm.Power_on_hours_1 + sm.Power_on_hours_2 AS Horas_encendido, 
					 sm.Reallocated_sector_count, sm.HDD_temperature, 
					 sm.fechaUltimaActualizacion 
					FROM ISMART sm 
					 INNER JOIN Equipos eq ON eq.equipoInfoId = sm.equipoInfoId 
					WHERE eq.empresaId = ? AND sm.isLegacy = ? "
					 . self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO;

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$f = false;
			$query -> bindParam(2, $f, \PDO::PARAM_BOOL);
			
			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.SMARTDiscosReporte():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Reportes de Visita: en Dashbard y en menu /gerentes/reportes_de_visita
	 * @return list
 	 */
	public static function reportesDeVisita($empresaId, $searchYear){
		try {
			$connection = Database::instance();

			/* AÑO actual */
			$yearDesde = date('Y', time());
			$yearHasta = ( $yearDesde + 1 );

			if ( $searchYear != NULL && $searchYear != "" && $searchYear > 2016 ){
				$yearDesde = $searchYear;
				$yearHasta = ( $yearDesde + 1 );
			}

			$sql = " SELECT i.*, fg.nombre AS TipoFalla, sol.*, 
					 u.nombre AS UsuarioNombre, u.apellido AS UsuarioApellido 
					FROM Incidencias i 
					 INNER JOIN FallasGenerales fg ON i.fallaId = fg.fallaId 
					 LEFT JOIN Soluciones sol ON i.resolucionId = sol.solucionId 
					 LEFT JOIN Usuarios u ON i.usuarioId = u.id 
					 LEFT JOIN Equipos eq ON i.equipoId = eq.id 
					WHERE i.empresaId = ? AND i.fallaId >= 100 
					 AND sol.fecha BETWEEN '" .$yearDesde. "-01-01 00:00.00' AND '" .$yearHasta. "-01-01 00:00.00' 
					 AND eq.estatus <> 'Suspendido' 
					ORDER BY i.incidenciaId DESC ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);
			
			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.reportesDeVisita():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Obtener Equipo(s) de una EMPRESA LEFT JOIN con su Usuario
	 */
	public static function getEquiposDeEmpresaDashboard($empresaId){
		try {
			$connection = Database::instance();

			$sql = " SELECT eq.*, u.nombre, u.apellido, te.nombre AS TipoEquipo 
					FROM Equipos eq 
					INNER JOIN TipoEquipos te ON eq.tipoEquipoId = te.tipoEquipoId 
					LEFT JOIN Usuarios u ON eq.usuarioId = u.id 
					WHERE eq.empresaId = ? "
					 . self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO
					. " ORDER BY eq.codigoBarras ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();
			/* return $query -> fetch( \PDO::FETCH_OBJ ); */

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.getEquiposDeEmpresaDashboard():";
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
	 * Obtener Info sobre Licencias en la tabla EquipoSOInfo
	 */
	public static function buscarLicenciasSistemasOperativos( $equipoSOInfoIDs, $total ){

		try {
			$W_si = 0; $W_no = 0; $O_si = 0; $O_no = 0;

			if ( $total > 0 && $equipoSOInfoIDs != null ){
				$connection = Database::instance();

				$sql = " SELECT e.SO, e.licencia FROM EquipoSOInfo e  
						WHERE e.id = ? ";

				for ( $i = 0; $i < $total; $i++ ){

					$query = $connection -> prepare($sql);

					$query -> bindParam(1, $equipoSOInfoIDs[ $i ], \PDO::PARAM_INT);

					$query -> execute();

					$r = $query -> fetch( \PDO::FETCH_OBJ );

					if ( $r->SO == "Windows" ) {
						if ( $r->licencia == "none" ){	$W_no++;
						} else {						$W_si++;
						}
					} else {
						if ( $r->licencia == "none" ){	$O_no++;
						} else {						$O_si++;
						}
					}
				}
			}

			$out["windows_si"] = $W_si;
			$out["windows_no"] = $W_no;
			$out["otros_si"]   = $O_si;
			$out["otros_no"]   = $O_no;

			return $out;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.buscarLicenciasSistemasOperativos():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $equipoSOInfoIDs;
			
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
	 * Obtener Info sobre Licencias en la tabla EquipoOfimaticaInfo
	 */
	public static function buscarLicenciasOfimaticas( $equipoOfimaticaInfoIDs, $total ){
		
		try {
			$W_si = 0; $W_no = 0; $O_si = 0; $O_no = 0;

			if ( $total > 0 && $equipoOfimaticaInfoIDs != null ){
				$connection = Database::instance();

				$sql = " SELECT e.Ofimatica, e.licencia FROM EquipoOfimaticaInfo e  
						WHERE e.id = ? ";

				for ( $i = 0; $i < $total; $i++ ){

					$query = $connection -> prepare($sql);

					$query -> bindParam(1, $equipoOfimaticaInfoIDs[ $i ], \PDO::PARAM_INT);

					$query -> execute();

					$r = $query -> fetch( \PDO::FETCH_OBJ );

					if ( $r->Ofimatica == "Microsoft Office" ) {
						if ( $r->licencia == "none" ){	$W_no++;
						} else {						$W_si++;
						}
					} else {
						if ( $r->licencia == "none" ){	$O_no++;
						} else {						$O_si++;
						}
					}
				}
			}

			$out["office_si"] 		= $W_si;
			$out["office_no"] 		= $W_no;
			$out["otro_office_si"]  = $O_si;
			$out["otro_office_no"]  = $O_no;

			return $out;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.buscarLicenciasOfimaticas():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $equipoOfimaticaInfoIDs;
			
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
	 * Menú Licencias de Equipos para una Empresa - Sistemas Operativos
	 */
	public static function licenciasSistemaOperativoPorEmpresa($empresaId){
		try {
			$connection = Database::instance();

			$sql =" SELECT esoi.*, eq.* 
					FROM EquipoSOInfo esoi 
					 INNER JOIN Equipos eq ON eq.equipoOfimaticaInfoId = esoi.id
					WHERE eq.empresaId = ? "
					 . self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO
					 . " ORDER BY esoi.licencia ASC ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();
			/* return $query -> fetch( \PDO::FETCH_OBJ ); */

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.licenciasSistemaOperativoPorEmpresa():";
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
	 * Menú Licencias de Equipos para una Empresa - Herramientas Ofimática
	 */
	public static function licenciasOfimaticasPorEmpresa($empresaId){
		try {
			$connection = Database::instance();

			$sql =" SELECT eoi.*, eq.* 
					FROM EquipoOfimaticaInfo eoi 
					 INNER JOIN Equipos eq ON eq.equipoOfimaticaInfoId = eoi.id
					WHERE eq.empresaId = ? "
					 . self::$FILTRO_EQUIPOS_WHERE_NOSUSPENDIDO
					 . " ORDER BY eoi.licencia ASC ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();
			/* return $query -> fetch( \PDO::FETCH_OBJ ); */

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.licenciasOfimaticasPorEmpresa():";
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
}