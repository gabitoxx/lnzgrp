<?php
namespace app\models;
defined("APPPATH") OR die("Access denied");

use \core\View,
	\core\Database,
	\app\models\admin\Transaccion,
  \app\models\Utils;

class Soportes {

	/**
	 * Obtener Soporte por ID
	 */
	public static function getById($soporteId){
		try {
			$connection = Database::instance();

			$sql = " SELECT * FROM SoportesProgramados sp WHERE sp.soporteProgId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $soporteId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetch( \PDO::FETCH_OBJ );

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Soportes.getById():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:$soporteId";
			
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
	 * insertar una CITA de soporte Programado
	 * @param $inventarioInfo en caso de tech 	| si es creada por MANAGER tendrá campo <otraDireccion>
	 * @param $userId ID del Técnico a cargo si viene de ADMIN; o ID del Partner creador
	 */
	public static function insert($userId, $empresaId, $fechaCita, $dia, $hora, $amPM, 
			$trabajoArealizar, $inventarioInfo, $createdBy, $aceptadaSoN, $horaHasta, $AmPmHasta ){

    $trabajoArealizar = Utils::sanitize( $trabajoArealizar, 250 );
    $inventarioInfo   = Utils::sanitize( $inventarioInfo, 250 );

		try {
			$connection = Database::instance();

			/**/
			if ( $aceptadaSoN == "no" || $aceptadaSoN == "No" || $aceptadaSoN == "NO" ){
				$aceptadaSoN = "no";
			} else {
				$aceptadaSoN = "si";
			}

			/**/
			if ( $amPM == "am" || $amPM == "AM" || $amPM == "Am"){
				$amPM == "AM";
			} else {
				$amPM == "PM";
			}
			/**/
			$status = "En Espera";


			if ( $createdBy == "tech" || $createdBy == "admin" ){
				/**/
				if ( $AmPmHasta == "am" || $AmPmHasta == "AM" || $AmPmHasta == "Am"){
					$AmPmHasta == "AM";
				} else {
					$AmPmHasta == "PM";
				}

				/*
				 * Si la cita la crea EL TECNICO, tendrá llenos los campos <tecnicoId> y creadoPor="tech"
				 */
				$sql = " INSERT INTO SoportesProgramados ( tecnicoId, "
						. " empresaId, trabajoArealizar, hora_estimada, am_pm, inventario_info, creadoPor, aceptada, fecha_cita, dia_cita, estatusCita, hasta_hora, hasta_am_pm ) " 
						. " VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";

				$query = $connection -> prepare($sql);

				$query -> bindParam(1, $userId, 			\PDO::PARAM_INT);
				$query -> bindParam(2, $empresaId, 			\PDO::PARAM_INT);
				$query -> bindParam(3, $trabajoArealizar, 	\PDO::PARAM_STR);
				$query -> bindParam(4, $hora, 				\PDO::PARAM_INT);
				$query -> bindParam(5, $amPM, 				\PDO::PARAM_STR);
				$query -> bindParam(6, $inventarioInfo, 	\PDO::PARAM_STR);
				$query -> bindParam(7, $createdBy,			\PDO::PARAM_STR);
				$query -> bindParam(8, $aceptadaSoN,		\PDO::PARAM_STR);
				$query -> bindParam(9, $fechaCita,			\PDO::PARAM_STR);
				$query -> bindParam(10, $dia, 				\PDO::PARAM_INT);
				$query -> bindParam(11, $status,			\PDO::PARAM_STR);

				$query -> bindParam(12, $horaHasta,			\PDO::PARAM_INT);
				$query -> bindParam(13, $AmPmHasta,			\PDO::PARAM_STR);

			} else if ( $createdBy == "manager" ){
				/*
				 * Si la cita la crea EL MANAGER, NO tendrá campo <tecnicoId> al inicio y creadoPor="manager"
				 */
				$sql = " INSERT INTO SoportesProgramados ("
						. " empresaId, trabajoArealizar, hora_estimada, am_pm, otraDireccion, creadoPor, aceptada, fecha_cita, dia_cita, estatusCita ) " 
						. " VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";

				$query = $connection -> prepare($sql);

				$query -> bindParam(1, $empresaId, 			\PDO::PARAM_INT);
				$query -> bindParam(2, $trabajoArealizar, 	\PDO::PARAM_STR);
				$query -> bindParam(3, $hora, 				\PDO::PARAM_INT);
				$query -> bindParam(4, $amPM, 				\PDO::PARAM_STR);
				$query -> bindParam(5, $inventarioInfo, 	\PDO::PARAM_STR);/*otraDireccion*/
				$query -> bindParam(6, $createdBy,			\PDO::PARAM_STR);
				$query -> bindParam(7, $aceptadaSoN,		\PDO::PARAM_STR);
				$query -> bindParam(8, $fechaCita,			\PDO::PARAM_STR);
				$query -> bindParam(9, $dia, 				\PDO::PARAM_INT);
				$query -> bindParam(10, $status,			\PDO::PARAM_STR);
			}

			$count = $query -> execute();

			return $count;
			
		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Soportes.insert():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $userId." ". $empresaId." ". $fechaCita." ". $dia." ". $hora." ". $amPM." ". 
					$trabajoArealizar." ". $inventarioInfo." ". $createdBy." ". $aceptadaSoN;
			
			/**/
			Transaccion::insertTransaccionPDOException("Soporte_crear",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Obtener Soportes para página TECNICOS
	 * @param $yearDesde	NUMBER 	
 	 * @param $mesDesde		NUMBER 	desde el mes en curso
	 * @param $yearHasta	NUMBER 	
	 * @param $mesHasta 	NUMBER 	hasta el mes siguiente
	 */
	public static function getSoportesProgramados($yearDesde, $mesDesde, $yearHasta, $mesHasta ){

		try {
			$connection = Database::instance();

			$sql = " SELECT * FROM SoportesProgramados WHERE "
					. " ( fecha_cita BETWEEN '" .$yearDesde. "-".$mesDesde."-01 00:00:00' AND '".$yearHasta."-".$mesHasta."-01 00:00:00')";

			$query = $connection -> prepare($sql);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Soportes.getSoportesProgramados():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $sql;
			
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
	 * Obtener Soportes para UNA EMPRESA
	 * @param $yearDesde	NUMBER 	
 	 * @param $mesDesde		NUMBER 	desde el mes en curso
	 * @param $yearHasta	NUMBER 	
	 * @param $mesHasta 	NUMBER 	hasta el mes siguiente
	 */
	public static function getSoportesProgramadosDeEmpresa($yearDesde, $mesDesde, $yearHasta, $mesHasta, $empresaId){

		try {
			$connection = Database::instance();

			$sql = " SELECT * FROM SoportesProgramados WHERE empresaId = ? AND "
					. " ( fecha_cita BETWEEN '" .$yearDesde. "-".$mesDesde."-01 00:00:00' AND '".$yearHasta."-".$mesHasta."-01 00:00:00')";

			$query = $connection -> prepare($sql);
			$query -> bindParam(1, $empresaId, 	\PDO::PARAM_INT);
			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Soportes.getSoportesProgramadosDeEmpresa():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $empresaId . "--" . $sql;
			
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
	 * Obtener Soportes para página TECNICOS
	 * @param $year	NUMBER 	
 	 * @param $mes	NUMBER
	 * @param $dia	NUMBER 	
	 */
	public static function getSoportesDelDia($year, $month, $dia ){
		try {
			$connection = Database::instance();

			$sql = " SELECT sp.*, "
					. " e.nombre AS nombreEmpresa, "
					. " u.nombre AS nombreTech, "
					. " u.apellido AS apellidoTech "
					. " FROM SoportesProgramados sp  "
					. " LEFT JOIN Empresas e ON sp.empresaId = e.empresaId "
					. " LEFT JOIN Usuarios u ON sp.tecnicoId = u.id "
					. " WHERE ( fecha_cita BETWEEN '".$year."-".$month."-".$dia." 00:00:00' AND '".$year."-".$month."-".$dia." 23:59:59' ) ";

			$query = $connection -> prepare($sql);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Soportes.getSoportesDelDia():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$year, $month, $dia";
			
			/**/
			Transaccion::insertTransaccionPDOException("Soporte_crear",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}
	/**
	 * Obtener Soportes para página TECNICOS
	 * @param $year	NUMBER 	
 	 * @param $mes	NUMBER
	 * @param $dia	NUMBER 	
	 */
	public static function getSoportesDelDiaDeEmpresa($year, $month, $dia, $empresaId){
		try {
			$connection = Database::instance();

			$sql = " SELECT sp.*, "
					. " e.nombre AS nombreEmpresa, "
					. " u.nombre AS nombreTech, "
					. " u.apellido AS apellidoTech "
					. " FROM SoportesProgramados sp  "
					. " LEFT JOIN Empresas e ON sp.empresaId = e.empresaId "
					. " LEFT JOIN Usuarios u ON sp.tecnicoId = u.id "
					. " WHERE sp.empresaId = ? AND estatusCita <> 'Eliminada' "
					. " AND ( fecha_cita BETWEEN '".$year."-".$month."-".$dia." 00:00:00' AND '".$year."-".$month."-".$dia." 23:59:59' ) ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId,	\PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Soportes.getSoportesDelDiaDeEmpresa():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$year, $month, $dia, $empresaId";
			
			/**/
			Transaccion::insertTransaccionPDOException("Soporte_crear",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * MANAGER o TECNICO puede cambiar la Hora
	 */
	public static function cambiarHora($soporteId, $hora, $am_pm){
		try {
			$connection = Database::instance();

			$AM = "";
			if ( $am_pm == "pm" || $am_pm == "Pm" || $am_pm == "PM" ){
				$AM = "PM";
			} else {
				$AM = "AM";
			}

			$sql = " UPDATE SoportesProgramados SET hora_estimada = ?, am_pm = ? WHERE soporteProgId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $hora,		\PDO::PARAM_INT);
			$query -> bindParam(2, $AM,			\PDO::PARAM_STR);
			$query -> bindParam(3, $soporteId,	\PDO::PARAM_INT);

			$count = $query -> execute();

			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Soportes.cambiarHora():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$soporteId, $hora, $am_pm";
			
			/**/
			Transaccion::insertTransaccionPDOException("Soporte_reprogramar",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * MANAGER o TECNICO pueden ACEPTAR una cita
	 */
	public static function aceptarCita($soporteId, $userId, $tipoUsuario){
		try {
			$connection = Database::instance();

			$sql = "";
			if ( $tipoUsuario == "tech"){

				$sql = " UPDATE SoportesProgramados SET aceptada = 'si', aceptadaPor = 'tech', estatusCita = 'Atendida', tecnicoId = ? WHERE soporteProgId = ? ";
				
				$query = $connection -> prepare($sql);

				$query -> bindParam(1, $userId,		\PDO::PARAM_INT);
				$query -> bindParam(2, $soporteId,	\PDO::PARAM_INT);

			} else if ( $tipoUsuario == "manager"){

				$sql = " UPDATE SoportesProgramados SET aceptada = 'si', aceptadaPor = 'manager', estatusCita = 'Atendida' WHERE soporteProgId = ? ";
				$query = $connection -> prepare($sql);

				$query -> bindParam(1, $soporteId,	\PDO::PARAM_INT);
			}

			$count = $query -> execute();

			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Soportes.aceptarCita():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$soporteId, $userId, $tipoUsuario";
			
			/**/
			Transaccion::insertTransaccionPDOException("Soporte_aceptar_reprogramacion",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * MANAGER o TECNICO pueden eliminar citas
	 */
	public static function eliminarCita($soporteId, $userId, $tipoUsuario){
		try {
			$connection = Database::instance();

			$info = "";
			if ( $tipoUsuario == "tech"){
				$info = "ELIMINADA_POR_TECNICO_id:$userId|$soporteId";

			} else if ( $tipoUsuario == "manager") {
				$info = "ELIMINADA_POR_MANAGER_id:$userId|soporte:$soporteId";
			}

			$sql = " UPDATE SoportesProgramados SET estatusCita = 'Eliminada', otraDireccion = ? WHERE soporteProgId = ? ";
				
			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $info,		\PDO::PARAM_INT);
			$query -> bindParam(2, $soporteId,	\PDO::PARAM_INT);		

			$count = $query -> execute();

			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Soportes.eliminarCita():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$soporteId, $userId, $tipoUsuario";
			
			/**/
			Transaccion::insertTransaccionPDOException("Soporte_eliminar",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * MANAGER o TECNICO: obtener citas a futuro del día actual
	 * @param $empresaId si es == 0 buscará TODAS las Empresas
	 * @return listado
	 */
	public static function getCitasPendientes($empresaId){
		try {
			$connection = Database::instance();

			if ( $empresaId <= 0 ){

				$sql = " SELECT sp.*, tech.id, tech.nombre, tech.apellido, tech.email 
						FROM SoportesProgramados sp 
						LEFT JOIN Usuarios tech ON sp.tecnicoId = tech.id 
						WHERE sp.fecha_cita >= CURDATE() 
						ORDER BY sp.fecha_cita ASC ";

				$query = $connection -> prepare($sql);

			} else {
				$sql = " SELECT sp.*, tech.id, tech.nombre, tech.apellido, tech.email 
						FROM SoportesProgramados sp 
						LEFT JOIN Usuarios tech ON sp.tecnicoId = tech.id 
						WHERE sp.empresaId = ? AND sp.fecha_cita >= CURDATE() 
						ORDER BY sp.fecha_cita ASC ";
			
				$query = $connection -> prepare($sql);

				$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);
			}

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Soportes.getCitasPendientes():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
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
	 * MANAGER o TECNICO: Listado de Citas PASADAS en el Calendario solo de ESTE AÑO
	 * @param $empresaId si es == 0 buscará TODAS las Empresas
	 * @return listado
 	 */
	public static function getCitasPreviasAnyoActual($empresaId){
		try {
			$connection = Database::instance();

			/* AÑO actual */
			$yearDesde = date('Y', time());

			if ( $empresaId <= 0 ){

				$sql = " SELECT sp.*, tech.id, tech.nombre, tech.apellido, tech.email
						FROM SoportesProgramados sp 
						LEFT JOIN Usuarios tech ON sp.tecnicoId = tech.id
						WHERE sp.fecha_cita < CURDATE() 
							AND ( sp.fecha_cita > '" .$yearDesde. "-01-01 00:00.00' ) 
						ORDER BY sp.fecha_cita DESC ";

				$query = $connection -> prepare($sql);
				
			} else {

				$sql = " SELECT sp.*, tech.id, tech.nombre, tech.apellido, tech.email
						FROM SoportesProgramados sp 
						LEFT JOIN Usuarios tech ON sp.tecnicoId = tech.id
						WHERE sp.empresaId = ? AND sp.fecha_cita < CURDATE() 
							AND ( sp.fecha_cita > '" .$yearDesde. "-01-01 00:00.00' ) 
						ORDER BY sp.fecha_cita DESC ";

				$query = $connection -> prepare($sql);

				$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);
			}

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Reportes.getCitasPreviasAnyoActual():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "$empresaId";
			
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