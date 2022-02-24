<?php
namespace app\models\admin;
defined("APPPATH") OR die("Access denied");

use \core\Database,
    \app\models\Utils;

class Company {

	public static function getAll() {

		try {
			$connection = Database::instance();

			$sql = "SELECT * FROM Empresas ORDER BY nombre ASC";

			$query = $connection -> prepare($sql);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			/* print "Error in models.Admin.Company.php.getAll(): " . $e->getMessage(); */
			$internalErrorCodigo  = "PDOException in models.Admin.Company.getAll():";
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
   * Insercion de nueva empresa en tabla Empresas
   */
	public static function insert($nombreEmpresa, $razonSocial, $NIT,
			$pais, $estado, $ciudad, $company_direccion){

		try {
			$connection = Database::instance();

			$sql = "INSERT INTO Empresas("
				. "nombre,razonSocial,NIT,pais,departamento_Estado,ciudad, direccion )" 
				. "VALUES(?, ?, ?, ?, ?, ?, ? )";

			$query = $connection -> prepare($sql);

      /**
       * Sanitization
       */
      $nombreEmpresa       = Utils::sanitize( $nombreEmpresa, 255 );
      $razonSocial         = Utils::sanitize( $razonSocial, 512 );
      $NIT                 = Utils::sanitize( $NIT, 50 );
      $pais                = Utils::sanitize( $pais, 50 );
      $estado              = Utils::sanitize( $estado, 100 );
      $ciudad              = Utils::sanitize( $ciudad, 100 );
      $company_direccion   = Utils::sanitize( $company_direccion, 500 );

			$query -> bindParam(1, $nombreEmpresa, \PDO::PARAM_STR);
			$query -> bindParam(2, $razonSocial, \PDO::PARAM_STR);
			$query -> bindParam(3, $NIT, \PDO::PARAM_STR);
			$query -> bindParam(4, $pais, \PDO::PARAM_STR);
			$query -> bindParam(5, $estado, \PDO::PARAM_STR);
			$query -> bindParam(6, $ciudad, \PDO::PARAM_STR);
			$query -> bindParam(7, $company_direccion, \PDO::PARAM_STR);

			$count = $query -> execute();

			if ( $count == 1 ){
				/* debe devolver solo la compañia recien ingesada  */
				$company = Company::getEmpresaByNames($nombreEmpresa, $razonSocial, $NIT );

				/* devuelvo TODO el objeto */
				return $company;
			}

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Admin.Company.insert():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $nombreEmpresa."-". $razonSocial."-". $NIT."-".$pais."-". $estado."-". $ciudad;
			
			/**/
			Transaccion::insertTransaccionPDOException("Crear_Usuario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}
	
	
	public static function getEmpresaByNames($nombreEmpresa, $razonSocial, $NIT ){
		try{

			$connection = Database::instance();

			$sql = "SELECT * FROM Empresas WHERE nombre = ? AND razonSocial = ? AND NIT = ? LIMIT 1 ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $nombreEmpresa, \PDO::PARAM_STR);
			$query -> bindParam(2, $razonSocial, \PDO::PARAM_STR);
			$query -> bindParam(3, $NIT, \PDO::PARAM_STR);

			$query -> execute();

			/* NO funciona: return $query -> fetchAll(); 
			 * NO deja usar las sintaxis:
			 * $idEmpresa = $compania->empresaId;
			 * $idEmpresa = $compania->{'empresaId'};
			*/
			return $query -> fetch( \PDO::FETCH_OBJ );

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Admin.Company.getEmpresaByNames():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $nombreEmpresa."-". $razonSocial."-". $NIT;
			
			/**/
			Transaccion::insertTransaccionPDOException("Crear_Usuario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	public static function getEmpresaById($empresaId){
		try{

			$connection = Database::instance();

			$sql = "SELECT * FROM Empresas WHERE empresaId = ? LIMIT 1 ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);

			$query -> execute();
			
			return $query -> fetch( \PDO::FETCH_OBJ );

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Admin.Company.getEmpresaById():";
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
	 * ACTUALIZAR empresa
	 */
	public static function update($empresaId, $companyName, $razonSocial, $NIT, 
			$pais, $estado, $ciudad, $direccion, $company_web, $company_pbx, $email ) {

		try {
			$connection = Database::instance();

			$sql = " UPDATE Empresas SET nombre=?, razonSocial=?, NIT=?, PBX=?, email=?, direccion=?, "
					. " ciudad=?, departamento_Estado=?, pais=?, paginaWeb=? WHERE empresaId = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $companyName, \PDO::PARAM_STR);
			$query -> bindParam(2, $razonSocial, \PDO::PARAM_STR);
			$query -> bindParam(3, $NIT, 		 \PDO::PARAM_STR);
			$query -> bindParam(4, $company_pbx, \PDO::PARAM_STR);
			$query -> bindParam(5, $email, 		 \PDO::PARAM_STR);
			$query -> bindParam(6, $direccion, 	 \PDO::PARAM_STR);
			$query -> bindParam(7, $ciudad, 	 \PDO::PARAM_STR);
			$query -> bindParam(8, $estado, 	 \PDO::PARAM_STR);
			$query -> bindParam(9, $pais, 		 \PDO::PARAM_STR);
			$query -> bindParam(10,$company_web, \PDO::PARAM_STR);

			$query -> bindParam(11, $empresaId, \PDO::PARAM_INT);
			
			$count = $query -> execute();

			return $count;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Admin.Company.update():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "ACTUALIZAR_EMPRESA_ERROR: $empresaId, $companyName, $razonSocial, $NIT, $pais, $estado, $ciudad, $direccion, $company_web, $company_pbx, $email";
			
			/**/
			Transaccion::insertTransaccionPDOException("Usuario_Actualizar",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}
}