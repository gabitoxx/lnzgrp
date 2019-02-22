<?php
namespace app\models\admin;
defined("APPPATH") OR die("Access denied");

use \core\Database;

class Transaccion {


	/**
	 *   status:	"Ok" , "Not_Ok"
	 */

	public static function getTransaccionById($transaccionId) {

	}

	public static function updateTransaccion($transaccionId) {

	}


	/*
	 * Generico
	 */
	public static function insertTransaccion($tipoTransaccion, $status, $userId, $RoleUser, $empresaId, $extraInfo){
		try {
			if ( $status != "Ok" ){
				$status = "Not_Ok";
			}

			$connection = Database::instance();

			/*
			 * Segun el Usuario
			 */
			$campo = "usuarioId";
			if ( $RoleUser == "developer" ){		$campo = "developerId";
			} else if ( $RoleUser == "client" ){	$campo = "usuarioId";
			} else if ( $RoleUser == "tech" ){		$campo = "tecnicoId";
			} else if ( $RoleUser == "manager" ){	$campo = "managerId";
			} else if ( $RoleUser == "admin" ){		$campo = "adminId";
			}

			// Actualizar ese campo
			$sql = " INSERT INTO Transaccion(tipo_transaccion, status, "
				. $campo
				. ", empresaId, info ) VALUES ( ?, ?, ?, ?, ? ) ";
			
			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
			$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
			$query -> bindParam(3, $userId, 			\PDO::PARAM_INT);
			$query -> bindParam(4, $empresaId, 			\PDO::PARAM_INT);
			$query -> bindParam(5, $extraInfo, 			\PDO::PARAM_STR);

			$count = $query -> execute();

		} catch(\PDOException $e) {
			/* print "Error in models.admin.Transaccion.insertTransaccionLogout() / ".$status." .:. " . $e->getMessage(); */
			$internalErrorCodigo  = "PDOException in models.Admin.Transaccion.insertTransaccionLogout():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:". $userId . " <-> empresa:".$empresaId ;

			/**/
			Transaccion::insertTransaccionPDOException($tipoTransaccion,$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}
	

	/**
	 * @param $userId   OK: userId		|	Not_Ok: username
	 * @param $RoleUser Ok: role 		|	Not_Ok: password
	 * @param $user_agent 	$_SERVER['HTTP_USER_AGENT'] sistema operativo o browser/navegador del Cliente
	 */
	public static function insertTransaccionLogin($status, $userId, $RoleUser, $empresaId, $user_agent){

		$tipoTransaccion = "Usuario_LogIn";
		$excOcurred=false;
		$internalErrorCodigo="";
		$internalErrorMessage="";

		$user_agent = "user_agent:" . $user_agent;

		if ( $status == "Ok" ){
			try {
				$connection = Database::instance();

				/*
				 * Segun el Usuario
				 */
				$campo = "usuarioId";
				if ( $RoleUser == "developer" ){		$campo = "developerId";
				} else if ( $RoleUser == "client" ){	$campo = "usuarioId";
				} else if ( $RoleUser == "tech" ){		$campo = "tecnicoId";
				} else if ( $RoleUser == "manager" ){	$campo = "managerId";
				} else if ( $RoleUser == "admin" ){		$campo = "adminId";
				}

				// Actualizar ese campo
				$sql = " INSERT INTO Transaccion(tipo_transaccion, status, "
					. $campo
					. ", empresaId, info ) VALUES ( ?, ?, ?, ?, ? ) ";

				
				$query = $connection -> prepare($sql);

				$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
				$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
				$query -> bindParam(3, $userId, 			\PDO::PARAM_INT);
				$query -> bindParam(4, $empresaId, 			\PDO::PARAM_INT);
				$query -> bindParam(5, $user_agent, 		\PDO::PARAM_STR);

				$count = $query -> execute();

			} catch(\PDOException $e) {
				$excOcurred = true;
				$internalErrorCodigo  = "PDOException in models.admin.Transaccion.insertTransaccionLogin() / Ok";
				$internalErrorMessage = $e->getMessage();
			}

		} else {
			try {
				$status = "Not_Ok";

				$extraComment = "Login_Fallido.:. user:".$userId." password:".$RoleUser . "|user_agent:" . $user_agent ;

				$connection = Database::instance();

				$sql = " INSERT INTO Transaccion (tipo_transaccion, status, info) VALUES ( ?, ?, ? ) ";
				
				$query = $connection -> prepare($sql);

				$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
				$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
				$query -> bindParam(3, $extraComment,		\PDO::PARAM_STR);

				$count = $query -> execute();

			} catch(\PDOException $e) {
				$excOcurred = true;
				$internalErrorCodigo  = "PDOException in models.admin.Transaccion.insertTransaccionLogin() / Not_Ok";
				$internalErrorMessage = $e->getMessage();
			}
		}
		if ( $excOcurred == true ){
			$internalErrorExtra   = "id:". $userId . " <-> empresa:".$empresaId ;

			/**/
			Transaccion::insertTransaccionPDOException($tipoTransaccion,$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}

	}

	/*
	 * cierre de sesion
	 */
	public static function insertTransaccionLogout($status, $userId, $RoleUser, $empresaId){
		try {
			$tipoTransaccion="Usuario_LogOut";

			$connection = Database::instance();

			/*
			 * Segun el Usuario
			 */
			$campo = "usuarioId";
			if ( $RoleUser == "developer" ){		$campo = "developerId";
			} else if ( $RoleUser == "client" ){	$campo = "usuarioId";
			} else if ( $RoleUser == "tech" ){		$campo = "tecnicoId";
			} else if ( $RoleUser == "manager" ){	$campo = "managerId";
			} else if ( $RoleUser == "admin" ){		$campo = "adminId";
			}

			// Actualizar ese campo
			$sql = " INSERT INTO Transaccion(tipo_transaccion, status, "
				. $campo
				. ", empresaId ) VALUES ( ?, ?, ?, ? ) ";
			
			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
			$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
			$query -> bindParam(3, $userId, 			\PDO::PARAM_INT);
			$query -> bindParam(4, $empresaId, 			\PDO::PARAM_INT);

			$count = $query -> execute();

		} catch(\PDOException $e) {
			/* print "Error in models.admin.Transaccion.insertTransaccionLogout() / ".$status." .:. " . $e->getMessage(); */
			$internalErrorCodigo  = "PDOException in models.Admin.Transaccion.insertTransaccionLogout():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:". $userId . " <-> empresa:".$empresaId ;

			/**/
			Transaccion::insertTransaccionPDOException($tipoTransaccion,$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/*
	 * Creacion de un Usuario
	 * @$activo: si SI fue creado por un Administrador 	|	"inactivo" creacion del formulario normal
	 * @$user: Objeto USUARIO 							|  Not_Ok: $cantidad de registros
	 * @$activo: tipo de Activacion 					|  Not_Ok: extra info

	 */
	public static function insertTransaccionCreateUser($status, $user, $activo){
		$excOcurred=false;
		$internalErrorCodigo="";
		$internalErrorMessage="";
		$internalErrorExtra="";

		/**/
		$tipoTransaccion="";
		if ( $activo == "activo" ){
			$tipoTransaccion="Crear_Usuario_Activo";
		} else {
			$tipoTransaccion="Crear_Usuario";
		}

		if ( $status == "Ok" ){
			try{
				$connection = Database::instance();

				$RoleUser = $user -> role;
				$userId   = $user->id;
				$empresaId= $user->empresaId;

				/*
				 * Segun el Usuario
				 */
				$campo = "usuarioId";
				if ( $RoleUser == "developer" ){		$campo = "developerId";
				} else if ( $RoleUser == "client" ){	$campo = "usuarioId";
				} else if ( $RoleUser == "tech" ){		$campo = "tecnicoId";
				} else if ( $RoleUser == "manager" ){	$campo = "managerId";
				} else if ( $RoleUser == "admin" ){		$campo = "adminId";
				}

				// Actualizar ese campo
				$sql = " INSERT INTO Transaccion(tipo_transaccion, status, "
					. $campo
					. ", empresaId ) VALUES ( ?, ?, ?, ? ) ";
				
				$query = $connection -> prepare($sql);

				$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
				$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
				$query -> bindParam(3, $userId, 			\PDO::PARAM_INT);
				$query -> bindParam(4, $empresaId, 			\PDO::PARAM_INT);

				$count = $query -> execute();

			} catch(\PDOException $e) {
				$excOcurred = true;
				$internalErrorCodigo  = "PDOException in models.admin.Transaccion.insertTransaccionCreateUser() / Ok";
				$internalErrorMessage = $e->getMessage();
				$internalErrorExtra   = "id:". $userId . " <-> empresa:".$empresaId ;
			}
		} else {
			try{
				$status = "Not_Ok";

				$connection = Database::instance();

				$sql = " INSERT INTO Transaccion(tipo_transaccion, status, info ) VALUES ( ?, ?, ? ) ";
				
				$query = $connection -> prepare($sql);

				$info = "Cantidad:".$user."-->".$activo;

				$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
				$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
				$query -> bindParam(3, $info, 				\PDO::PARAM_STR);

				$count = $query -> execute();

			} catch(\PDOException $e) {
				$excOcurred = true;
				$internalErrorCodigo  = "PDOException in models.admin.Transaccion.insertTransaccionCreateUser() / Not_Ok";
				$internalErrorMessage = $e->getMessage();
				$internalErrorExtra   = "info:". $info;
			}
		}
		if ( $excOcurred == true ){
			/**/
			Transaccion::insertTransaccionPDOException($tipoTransaccion,$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * @$userId 	id 		|	"Not_Ok": email a recordar
	 */
	public static function insertTransaccionForgetPassword($status, $userId, $RoleUser, $userEmail, $empresaId, $index_message_title){
		$tipoTransaccion="Usuario_Olvido_password";

		$excOcurred=false;
		$internalErrorCodigo="";
		$internalErrorMessage="";

		if ( $status == "Ok" ){
			try {
				$connection = Database::instance();

				/*
				 * Segun el Usuario: CORREO SÍ ENVIADO
				 */
				$campo = "usuarioId";
				if ( $RoleUser == "developer" ){		$campo = "developerId";
				} else if ( $RoleUser == "client" ){	$campo = "usuarioId";
				} else if ( $RoleUser == "tech" ){		$campo = "tecnicoId";
				} else if ( $RoleUser == "manager" ){	$campo = "managerId";
				} else if ( $RoleUser == "admin" ){		$campo = "adminId";
				}

				// Actualizar ese campo
				$sql = " INSERT INTO Transaccion(tipo_transaccion, status, "
					. $campo
					. ", empresaId, info ) VALUES ( ?, ?, ?, ?, ? ) ";
				
				$query = $connection -> prepare($sql);

				$info = $userEmail."-->".$index_message_title;

				$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
				$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
				$query -> bindParam(3, $userId, 			\PDO::PARAM_INT);
				$query -> bindParam(4, $empresaId, 			\PDO::PARAM_INT);
				$query -> bindParam(5, $info,				\PDO::PARAM_STR);

				$count = $query -> execute();

			} catch(\PDOException $e) {
				$excOcurred = true;
				$internalErrorCodigo  = "PDOException in models.admin.Transaccion.insertTransaccionForgetPassword() / Ok";
				$internalErrorMessage = $e->getMessage();
				$internalErrorExtra = "id:".$userId. " / empresa:".$empresaId . " / info:".$info;
			}
		} else {
			try {
				$status = "Not_Ok";

				$connection = Database::instance();

				$sql = "";
				if ( $userId != "" ){
					/*
					 * Segun el Usuario: CORREO NO ENVIADO
					 */
					$campo = "usuarioId";
					if ( $RoleUser == "developer" ){		$campo = "developerId";
					} else if ( $RoleUser == "client" ){	$campo = "usuarioId";
					} else if ( $RoleUser == "tech" ){		$campo = "tecnicoId";
					} else if ( $RoleUser == "manager" ){	$campo = "managerId";
					} else if ( $RoleUser == "admin" ){		$campo = "adminId";
					}

					// Actualizar ese campo
					$sql = " INSERT INTO Transaccion(tipo_transaccion, status, "
						. $campo
						. ", empresaId, info ) VALUES ( ?, ?, ?, ?, ? ) ";
					
					$query = $connection -> prepare($sql);

					$info = $userEmail."-->".$index_message_title;

					$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
					$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
					$query -> bindParam(3, $userId, 			\PDO::PARAM_INT);
					$query -> bindParam(4, $empresaId, 			\PDO::PARAM_INT);
					$query -> bindParam(5, $info,				\PDO::PARAM_STR);
				
				} else {
					//USUARIO NO ENCONTRADO
					$sql = " INSERT INTO Transaccion(tipo_transaccion, status, info ) VALUES ( ?, ?, ? ) ";
				
					$query = $connection -> prepare($sql);

					$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
					$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
					$query -> bindParam(3, $userEmail,			\PDO::PARAM_STR);
				}

				$count = $query -> execute();

			} catch(\PDOException $e) {
				$excOcurred = true;
				$internalErrorCodigo  = "PDOException in models.admin.Transaccion.insertTransaccionForgetPassword() / Not_Ok";
				$internalErrorMessage = $e->getMessage();
				$internalErrorExtra = "id:".$userId. " / empresa:".$empresaId . " / info:".$info;
			}
		}
		if ( $excOcurred == true ){
			/**/
			Transaccion::insertTransaccionPDOException($tipoTransaccion,$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Al momento de crear una Incidencia
	 */
	public static function insertTransaccionIncidencia($status, $userId, $RoleUser, $empresaId, $info){
		try {
			$tipoTransaccion = "Incidencia_Crear";

			if ( $status != "Ok" ){
				$status = "Not_Ok";
			}

			$connection = Database::instance();

			/*
			 * Segun el Usuario: CORREO SÍ ENVIADO
			 */
			$campo = "usuarioId";
			if ( $RoleUser == "developer" ){		$campo = "developerId";
			} else if ( $RoleUser == "client" ){	$campo = "usuarioId";
			} else if ( $RoleUser == "tech" ){		$campo = "tecnicoId";
			} else if ( $RoleUser == "manager" ){	$campo = "managerId";
			} else if ( $RoleUser == "admin" ){		$campo = "adminId";
			}

			// Actualizar ese campo
			$sql = " INSERT INTO Transaccion(tipo_transaccion, status, "
				. $campo
				. ", empresaId, info ) VALUES ( ?, ?, ?, ?, ? ) ";
			
			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
			$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
			$query -> bindParam(3, $userId, 			\PDO::PARAM_INT);
			$query -> bindParam(4, $empresaId, 			\PDO::PARAM_INT);
			$query -> bindParam(5, $info,				\PDO::PARAM_STR);

			$count = $query -> execute();

		} catch(\PDOException $e) {
			/* print "Error in models.admin.Transaccion.insertTransaccionIncidencia() / ".$status." .:. " . $e->getMessage(); */
			$internalErrorCodigo  = "PDOException in models.Admin.Transaccion.insertTransaccionIncidencia():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:". $userId . " <-> empresa:".$empresaId ;

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
	 * Al momento de crear una Incidencia + incidenciaID
	 */
	public static function insertTransaccionIncidencia2( $status, $userId, $RoleUser, $empresaId, $info, $incidenciaId ){
		try {
			$tipoTransaccion = "Incidencia_Crear";

			if ( $status != "Ok" ){
				$status = "Not_Ok";
			}

			$connection = Database::instance();

			/*
			 * Segun el Usuario: CORREO SÍ ENVIADO
			 */
			$campo = "usuarioId";
			if ( $RoleUser == "developer" ){		$campo = "developerId";
			} else if ( $RoleUser == "client" ){	$campo = "usuarioId";
			} else if ( $RoleUser == "tech" ){		$campo = "tecnicoId";
			} else if ( $RoleUser == "manager" ){	$campo = "managerId";
			} else if ( $RoleUser == "admin" ){		$campo = "adminId";
			}

			// Actualizar ese campo
			$sql = " INSERT INTO Transaccion(tipo_transaccion, status, "
				. $campo
				. ", empresaId, info, incidenciaId ) VALUES ( ?, ?, ?, ?, ?, ? ) ";
			
			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
			$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
			$query -> bindParam(3, $userId, 			\PDO::PARAM_INT);
			$query -> bindParam(4, $empresaId, 			\PDO::PARAM_INT);
			$query -> bindParam(5, $info,				\PDO::PARAM_STR);
			$query -> bindParam(6, $incidenciaId, 		\PDO::PARAM_INT);

			$count = $query -> execute();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Admin.Transaccion.insertTransaccionIncidencia2():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:". $userId . " <-> empresa:".$empresaId . " | incidenciaId:$incidenciaId " ;

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
	 * Generico: cuando accede a un Metodo y el formulario NO se serializa correctamente en metodo $_POST()
	 */
	public static function insertTransaccionErrorFormulario($tipoTransaccion,$claseYmetodo,$userId,
			$RoleUser, $empresaId, $info){
		try {
			$status = "Not_Ok";

			$connection = Database::instance();

			$error_tipo = "FORM_NO_POST";

			/*
			 * Segun el Usuario: CORREO SÍ ENVIADO
			 */
			$campo = "usuarioId";
			if ( $RoleUser == "developer" ){		$campo = "developerId";
			} else if ( $RoleUser == "client" ){	$campo = "usuarioId";
			} else if ( $RoleUser == "tech" ){		$campo = "tecnicoId";
			} else if ( $RoleUser == "manager" ){	$campo = "managerId";
			} else if ( $RoleUser == "admin" ){		$campo = "adminId";
			}

			// Actualizar ese campo
			$sql = " INSERT INTO Transaccion(tipo_transaccion, status, "
				. $campo
				. ", empresaId, error_tipo, error_codigo, error_mensaje ) VALUES ( ?, ?, ?, ?, ?, ?, ? ) ";
			
			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
			$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
			$query -> bindParam(3, $userId, 			\PDO::PARAM_INT);
			$query -> bindParam(4, $empresaId, 			\PDO::PARAM_INT);
			$query -> bindParam(5, $error_tipo,			\PDO::PARAM_STR);
			$query -> bindParam(6, $claseYmetodo,		\PDO::PARAM_STR);
			$query -> bindParam(7, $info,				\PDO::PARAM_STR);

			$count = $query -> execute();

		} catch(\PDOException $e) {
			/* print "Error in models.admin.Transaccion.insertTransaccionErrorFormulario() / Not_Ok .:. " . $e->getMessage(); */
			$internalErrorCodigo  = "PDOException in models.Admin.Transaccion.insertTransaccionErrorFormulario():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:". $userId . " <-> empresa:".$empresaId . ":: ".$info ;

			/**/
			Transaccion::insertTransaccionPDOException("Formulario_POST",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Generico: cuando hay error de \PDOException
	 */
	public static function insertTransaccionPDOException($tipoTransaccion,
			$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra){
		try {
			$status = "Not_Ok";

			$connection = Database::instance();

			$error_tipo = "DATABASE";

			$sql = " INSERT INTO Transaccion(tipo_transaccion, status, "
					. " info, error_tipo, error_codigo, error_mensaje ) VALUES ( ?, ?, ?, ?, ?, ? ) ";
			
			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
			$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
			$query -> bindParam(3, $internalErrorExtra, \PDO::PARAM_STR);
			$query -> bindParam(4, $error_tipo,			\PDO::PARAM_STR);
			$query -> bindParam(5, $internalErrorCodigo,\PDO::PARAM_STR);
			$query -> bindParam(6, $internalErrorMessage,\PDO::PARAM_STR);

			$count = $query -> execute();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Admin.Transaccion.insertTransaccionPDOException():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $tipoTransaccion.";".$internalErrorCodigo.";". $internalErrorMessage.";". $internalErrorExtra;
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Generico: cuando hay error de \Exception
	 */
	public static function insertTransaccionException($tipoTransaccion,
			$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra, $RoleUser, $userId){
		try {
			$status = "Not_Ok";

			/*
			 * Segun el Usuario: CORREO SÍ ENVIADO
			 */
			$campo = "usuarioId";
			if ( $RoleUser == "developer" ){		$campo = "developerId";
			} else if ( $RoleUser == "client" ){	$campo = "usuarioId";
			} else if ( $RoleUser == "tech" ){		$campo = "tecnicoId";
			} else if ( $RoleUser == "manager" ){	$campo = "managerId";
			} else if ( $RoleUser == "admin" ){		$campo = "adminId";
			}

			$connection = Database::instance();

			$error_tipo = "FATAL";

			$sql = " INSERT INTO Transaccion(tipo_transaccion, status, " . $campo
					. " , info, error_tipo, error_codigo, error_mensaje ) VALUES ( ?, ?, ?, ?, ?, ?, ? ) ";
			
			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
			$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
			$query -> bindParam(3, $userId, 			\PDO::PARAM_INT);
			$query -> bindParam(4, $internalErrorExtra, \PDO::PARAM_STR);
			$query -> bindParam(5, $error_tipo,			\PDO::PARAM_STR);
			$query -> bindParam(6, $internalErrorCodigo,\PDO::PARAM_STR);
			$query -> bindParam(7, $internalErrorMessage,\PDO::PARAM_STR);

			$count = $query -> execute();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Admin.Transaccion.insertTransaccionPDOException():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $tipoTransaccion.";".$internalErrorCodigo.";". $internalErrorMessage.";". $internalErrorExtra;
			
			/**/
			Transaccion::insertTransaccionPDOException($tipoTransaccion,$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Para guardar el Historial de una Incidencia
	 */
	public static function insertTransaccionIncidenciaHistorial($tipoTransaccion, $status, $user, $incidenciaId, $empresaId, $info){

		if ( $status != "Ok" ){
			$status = "Not_Ok";
		}
		try {
			$RoleUser = $user->role;
			$userId   = $user->id;

			if ( $empresaId == 0 ){
				$empresaId = $user->empresaId;
			}

			/*
			 * Segun el Usuario
			 */
			$campo = "usuarioId";
			if ( $RoleUser == "developer" ){		$campo = "developerId";
			} else if ( $RoleUser == "client" ){	$campo = "usuarioId";
			} else if ( $RoleUser == "tech" ){		$campo = "tecnicoId";
			} else if ( $RoleUser == "manager" ){	$campo = "managerId";
			} else if ( $RoleUser == "admin" ){		$campo = "adminId";
			}

			// Actualizar ese campo
			$sql = " INSERT INTO Transaccion(tipo_transaccion, status, "
				. $campo
				. ", empresaId, info, incidenciaId ) VALUES ( ?, ?, ?, ?, ?, ? ) ";
			
			$connection = Database::instance();

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
			$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
			$query -> bindParam(3, $userId, 			\PDO::PARAM_INT);
			$query -> bindParam(4, $empresaId, 			\PDO::PARAM_INT);
			$query -> bindParam(5, $info, 				\PDO::PARAM_STR);
			$query -> bindParam(6, $incidenciaId, 		\PDO::PARAM_INT);

			$count = $query -> execute();

		} catch(\PDOException $e) {
			/* print "Error in models.admin.Transaccion.insertTransaccionIncidenciaHistorial() / ".$status." .:. " . $e->getMessage(); */
			$internalErrorCodigo  = "PDOException in models.Admin.Transaccion.insertTransaccionIncidenciaHistorial():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:". $userId . " | empresa:".$empresaId . " | incidencia:".$incidenciaId . "| info:". $info ;

			/**/
			Transaccion::insertTransaccionPDOException($tipoTransaccion,$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * Para guardar el Historial de una Incidencia
	 * @param $soporteId 	| en caso de CREAR, viene $empresaId
	 */
	public static function insertTransaccionSoporteHistorial($tipoTransaccion, $status, $tipoUser, $userId, $soporteId, $info){

		if ( $status != "Ok" ){
			$status = "Not_Ok";
		}
		try {
			/*
			 * Segun el Usuario
			 */
			$campo = "usuarioId";
			if ( $tipoUser == "developer" ){		$campo = "developerId";
			} else if ( $tipoUser == "client" ){	$campo = "usuarioId";
			} else if ( $tipoUser == "tech" ){		$campo = "tecnicoId";
			} else if ( $tipoUser == "manager" ){	$campo = "managerId";
			} else if ( $tipoUser == "admin" ){		$campo = "adminId";
			}


			$campo2 = "soporteProgId";
			if ( $tipoTransaccion == "Soporte_crear"){					$campo2 = "empresaId";
			} else if ( $tipoTransaccion == "Soporte_reprogramar"){		$campo2 = "soporteProgId";
			}


			// Actualizar ese campo
			$sql = " INSERT INTO Transaccion(tipo_transaccion, status, "
				. $campo . ", " . $campo2
				. ",info ) VALUES ( ?, ?, ?, ?, ? ) ";
			
			$connection = Database::instance();

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
			$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
			$query -> bindParam(3, $userId, 			\PDO::PARAM_INT);
			$query -> bindParam(4, $soporteId, 			\PDO::PARAM_INT);
			$query -> bindParam(5, $info, 				\PDO::PARAM_STR);

			$count = $query -> execute();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Admin.Transaccion.insertTransaccionSoporteHistorial():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "id:". $userId . " | empresa_o_soporte:".$soporteId . "| info:". $info ;

			/**/
			Transaccion::insertTransaccionPDOException($tipoTransaccion,$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/*
	 * Equipos: HISTORIAL
	 */
	public static function insertTransaccionEquipo($tipoTransaccion, $status, $userId, $RoleUser, 
			$empresaId, $extraInfo, $equipoId){

		try {
			if ( $status != "Ok" ){
				$status = "Not_Ok";
			}

			$connection = Database::instance();

			/*
			 * Segun el Usuario
			 */
			$campo = "usuarioId";
			if ( $RoleUser == "developer" ){		$campo = "developerId";
			} else if ( $RoleUser == "client" ){	$campo = "usuarioId";
			} else if ( $RoleUser == "tech" ){		$campo = "tecnicoId";
			} else if ( $RoleUser == "manager" ){	$campo = "managerId";
			} else if ( $RoleUser == "admin" ){		$campo = "adminId";
			}

			// Actualizar ese campo
			$sql = " INSERT INTO Transaccion(tipo_transaccion, status, "
				. $campo
				. ", empresaId, info, equipoId ) VALUES ( ?, ?, ?, ?, ?, ? ) ";
			
			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
			$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
			$query -> bindParam(3, $userId, 			\PDO::PARAM_INT);
			$query -> bindParam(4, $empresaId, 			\PDO::PARAM_INT);
			$query -> bindParam(5, $extraInfo, 			\PDO::PARAM_STR);
			$query -> bindParam(6, $equipoId, 			\PDO::PARAM_INT);

			$count = $query -> execute();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Admin.Transaccion.insertTransaccionEquipo():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "techId:". $userId . " <-> empresa:".$empresaId . " | equipoId:$equipoId | extraInfo:$extraInfo";

			/**/
			Transaccion::insertTransaccionPDOException($tipoTransaccion,$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/*
	 * Equipos: HISTORIAL + insertando incidenciaId
	 */
	public static function insertTransaccionEquipo2($tipoTransaccion, $status, $userId, $RoleUser, 
			$empresaId, $extraInfo, $equipoId , $incidenciaId){

		try {
			if ( $status != "Ok" ){
				$status = "Not_Ok";
			}

			$connection = Database::instance();

			/*
			 * Segun el Usuario
			 */
			$campo = "usuarioId";
			if ( $RoleUser == "developer" ){		$campo = "developerId";
			} else if ( $RoleUser == "client" ){	$campo = "usuarioId";
			} else if ( $RoleUser == "tech" ){		$campo = "tecnicoId";
			} else if ( $RoleUser == "manager" ){	$campo = "managerId";
			} else if ( $RoleUser == "admin" ){		$campo = "adminId";
			}

			// Actualizar ese campo
			$sql = " INSERT INTO Transaccion(tipo_transaccion, status, "
				. $campo
				. ", empresaId, info, equipoId, incidenciaId ) VALUES ( ?, ?, ?, ?, ?, ?, ? ) ";
			
			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $tipoTransaccion, 	\PDO::PARAM_STR);
			$query -> bindParam(2, $status, 			\PDO::PARAM_STR);
			$query -> bindParam(3, $userId, 			\PDO::PARAM_INT);
			$query -> bindParam(4, $empresaId, 			\PDO::PARAM_INT);
			$query -> bindParam(5, $extraInfo, 			\PDO::PARAM_STR);
			$query -> bindParam(6, $equipoId, 			\PDO::PARAM_INT);
			$query -> bindParam(7, $incidenciaId,		\PDO::PARAM_INT);

			$count = $query -> execute();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Admin.Transaccion.insertTransaccionEquipo2():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "techId:". $userId . " <-> empresa:".$empresaId . " | incidenciaId:$incidenciaId | equipoId:$equipoId | extraInfo:$extraInfo | ";

			/**/
			Transaccion::insertTransaccionPDOException($tipoTransaccion,$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}


	/**
	 * Obtener El Historial de un Equipo
	 */
	public static function getHistorial($equipoId){

		try {
			$connection = Database::instance();

			$sql =" SELECT t.*, u.nombre AS techNombre, u.apellido AS techApellido
					FROM Transaccion t 
					 LEFT JOIN Usuarios u ON t.tecnicoId = u.id
					WHERE t.equipoId = ? 
					 OR t.incidenciaId IN
					 ( SELECT i.incidenciaId FROM Incidencias i WHERE i.equipoId = ? )
					ORDER BY transaccionId DESC 
					";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $equipoId, \PDO::PARAM_INT);
			$query -> bindParam(2, $equipoId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetchAll();

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Transaccion.getHistorial():";
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
	 * Obtener QUIEN fue el CREADOR de una INCIDENCIA
	 */
	public static function getUsuarioCreadorIncidencia( $incidenciaId ){
		try {
			$connection = Database::instance();

			$sql =" SELECT * 
					FROM Transaccion t 
					WHERE t.tipo_transaccion = 'Incidencia_Crear' AND t.status = 'Ok' 
					  AND t.incidenciaId = ?
					";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $incidenciaId, \PDO::PARAM_INT);

			$query -> execute();

			return $query -> fetch( \PDO::FETCH_OBJ );

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Transaccion.getUsuarioCreadorIncidencia():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $incidenciaId;
			
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