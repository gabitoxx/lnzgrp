<?php
namespace app\models;
defined("APPPATH") OR die("Access denied");

use \core\Database,
	\core\View,
	\app\models\admin\Transaccion;
  
class Empresas {

	/**
	 * Obtener datos de una EMPRESA
	 */
	public static function getEmpresa($empresaId){
		try {
			$connection = Database::instance();

			$sql = "SELECT * FROM Empresas e WHERE e.empresaId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();

			/*
			return $query -> fetchAll();
			return $query -> fetch();
			*/
			return $query -> fetch( \PDO::FETCH_OBJ );

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Empresas.getEmpresa():";
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
	 * Obtener datos de una EMPRESA
	 */
	public static function getEmpresas(){
		try {
			$connection = Database::instance();

			$sql = "SELECT * FROM Empresas ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();
			
			return $query -> fetchAll();
			/*
			return $query -> fetch();
			return $query -> fetch( \PDO::FETCH_OBJ );
			*/

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Empresas.getEmpresa():";
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
	 * Obtener datos de EMPRESAS con este filtro
	 */
	public static function searchCompanies( $stringAbuscar ){
		try {
			$connection = Database::instance();

			$a = $stringAbuscar;

			if ( $a == "" ){
				$sql = " SELECT * FROM Empresas ORDER BY nombre ASC ";

			} else {

				$sql = " SELECT * FROM Empresas WHERE "
						. " nombre LIKE '%".$a."%' OR razonSocial LIKE '%".$a."%' OR NIT LIKE '%".$a."%' "
						. " OR email LIKE '%".$a."%' OR direccion LIKE '%".$a."%' OR ciudad LIKE '%".$a."%' "
						. " OR departamento_Estado LIKE '%".$a."%' OR pais LIKE '%".$a."%' "
						. "  ORDER BY nombre ASC ";
			}

			$query = $connection -> prepare($sql);

			$query -> execute();
			
			return $query -> fetchAll();

		} catch(\PDOException $e) {
			return NULL;
		}
	}

	/**
	 * Buscar correo(s) de(los) Partner(s) o Gerente(s) de esta EMPRESA
	 */
	public static function getEmailsDeManagersDeEmpresa( $empresaId ){
		try {
			$connection = Database::instance();

			$sql = " SELECT email FROM Usuarios WHERE role = 'manager' AND empresaId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();
			
			return $query -> fetchAll();

		} catch(\PDOException $e) {
			return NULL;
		}
	}
	

	/**
	 * Buscar correo(s) de(los) Partner(s) o Gerente(s) de esta EMPRESA
	 */
	public static function getEmailsDeManagersDeSoporte( $soporteId ){
		try {
			$connection = Database::instance();

			$sql = " SELECT u.email FROM Usuarios u WHERE u.empresaId IN ( SELECT sp.empresaId FROM SoportesProgramados sp WHERE sp.soporteProgId = ? ) ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $soporteId, \PDO::PARAM_INT);

			$query -> execute();
			
			return $query -> fetchAll();

		} catch(\PDOException $e) {
			return NULL;
		}
	}

	
	/**
	 * Buscar correo deTecnico
	 */
	public static function getEmailsDeTecnicoDeSoporte( $soporteId ){
		try {
			$connection = Database::instance();

			$sql = " SELECT u.email FROM Usuarios u WHERE u.id IN ( SELECT sp.tecnicoId FROM SoportesProgramados sp WHERE sp.soporteProgId = ? ) ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $soporteId, \PDO::PARAM_INT);

			$query -> execute();
			
			return $query -> fetchAll();

		} catch(\PDOException $e) {
			return NULL;
		}
	}
}