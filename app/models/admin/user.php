<?php
namespace app\models\admin;
defined("APPPATH") OR die("Access denied");

use \core\Database;
use \app\interfaces\crud;
use \core\View,
	\app\models\admin\Transaccion,
  \app\models\Utils;


class user implements crud {



	public static function getAll() {



		try {

			$connection = Database::instance();



			$sql = "SELECT * FROM Usuarios ";



			$query = $connection -> prepare($sql);



			$query -> execute();



			return $query -> fetchAll();



		} catch(\PDOException $e) {

			/* print "Error in models.Admin.User.getAll: " . $e->getMessage(); */



			$internalErrorCodigo  = "PDOException in models.Admin.User.getAll():";

			$internalErrorMessage = $e -> getMessage();



			/**/

			Transaccion::insertTransaccionPDOException("Usuario_LogIn",$internalErrorCodigo, $internalErrorMessage, "");

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);



			View::render("internalError");

			die;

		}

	}





	/**

	 * Un Usuario dado su ID

	 */

	public static function getById($id){

		try {



			$connection = Database::instance();



			$sql = " SELECT * FROM Usuarios WHERE id = ? ";



			$query = $connection -> prepare($sql);



			$query -> bindParam(1, $id, \PDO::PARAM_INT);



			$query -> execute();



			return $query -> fetch();



		} catch(\PDOException $e) {

			/*print "Error in models.Admin.User.php.getById(): " . $e->getMessage();*/



			$internalErrorCodigo  = "PDOException in models.Admin.User.getById():";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = $id;



			/**/

			Transaccion::insertTransaccionPDOException("Usuario_LogIn",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);

			View::set("internalErrorExtra",	 $internalErrorExtra);



			View::render("internalError");

			die;

		}

	}

	/**

	 * Un Usuario dado su ID

	 * @return un Objeto

	 */

	public static function getUserObjectById($id){

		try {



			$connection = Database::instance();



			$sql = "SELECT * FROM Usuarios WHERE id = ? ";



			$query = $connection -> prepare($sql);



			$query -> bindParam(1, $id, \PDO::PARAM_INT);



			$query -> execute();



			return $query -> fetch( \PDO::FETCH_OBJ );



		} catch(\PDOException $e) {

			$internalErrorCodigo  = "PDOException in models.Admin.User.getUserObjectById():";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = $id;



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
	 * Un USUARIO dado su EMAIL o su USERNAME & password
	 */
	public static function getUser($username, $password, $userType){
		try {
			$sql = "";
			$connection = Database::instance();

      // Encriptando para recuperar
      $password = md5( strrev( $password ) );

			if ( $userType == "activo" ){
				$sql = " SELECT * FROM Usuarios WHERE ( usuario = ? OR email = ?) AND password = ? AND activo = 'activo' ";

			} else {
				$sql = " SELECT * FROM Usuarios WHERE ( usuario = ? OR email = ?) AND password = ? ";

			}
			
			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $username, \PDO::PARAM_STR);
			$query -> bindParam(2, $username, \PDO::PARAM_STR);
			$query -> bindParam(3, $password, \PDO::PARAM_STR);

			$query -> execute();

			return $query -> fetch( \PDO::FETCH_OBJ );/* COMMENT probando parametro \PDO::FETCH_OBJ */

		} catch(\PDOException $e) {
			/* print "Error in models.Admin.User.getUser(): " . $e -> getMessage(); */

			$internalErrorCodigo  = "PDOException in models.Admin.User.getUser():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "username:".$username;

			/**/

			Transaccion::insertTransaccionPDOException("Usuario_LogIn",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

  /**
	 * Un USUARIO dado su EMAIL o su USERNAME & password YA ENCRIPTADO
   * @password ya encriptado
	 */
	public static function getUser2($username, $password, $userType){
		try {
			$sql = "";
			$connection = Database::instance();

      // Encriptando para recuperar
      //$password = md5( strrev( $password ) );

			if ( $userType == "activo" ){
				$sql = " SELECT * FROM Usuarios WHERE ( usuario = ? OR email = ?) AND password = ? AND activo = 'activo' ";

			} else {
				$sql = " SELECT * FROM Usuarios WHERE ( usuario = ? OR email = ?) AND password = ? ";

			}
			
			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $username, \PDO::PARAM_STR);
			$query -> bindParam(2, $username, \PDO::PARAM_STR);
			$query -> bindParam(3, $password, \PDO::PARAM_STR);

			$query -> execute();

			return $query -> fetch( \PDO::FETCH_OBJ );/* COMMENT probando parametro \PDO::FETCH_OBJ */

		} catch(\PDOException $e) {
			/* print "Error in models.Admin.User.getUser(): " . $e -> getMessage(); */

			$internalErrorCodigo  = "PDOException in models.Admin.User.getUser():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "username:".$username;

			/**/

			Transaccion::insertTransaccionPDOException("Usuario_LogIn",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}





	/**

	 * INSERTAR un nuevo USUARIO 

	 */

	public static function insert($greetings, $givenname, $lastname, $gender,
			$email, $username, $password,
			$empresaId, $dependencia, $cargo,
			$cellphone_code, $phone_cell, $phone_home, $phone_work, $phone_work_ext,
			$activo, $birthdate ) {

		try {

			$connection = Database::instance();

			$sql = " INSERT INTO Usuarios (
          usuario, password, nombre, apellido, email,
          empresaId, role, dependencia, saludo, gender,
          activo, Celular, TelefonoTrabajo, ExtensionTrabajo, TelefonoCasa, 
          cumpleanos
          )
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";

			$query = $connection -> prepare($sql);

      /**
       * Encriptacion password
       */
      $password = md5( strrev( $password ) );

      $query -> bindParam(2, $password, \PDO::PARAM_STR);
      
      /*
       * sanitization
       */
      $username   = Utils::sanitize( $username, 32 );
      $givenname  = Utils::sanitize( $givenname, 32 ); 
      $lastname   = Utils::sanitize( $lastname, 32 );
      $email      = Utils::sanitize( $email, 100 );
      
      $cargo      = Utils::sanitize( $cargo, 20 );
      $dependencia= Utils::sanitize( $dependencia, 150 );
      $greetings  = Utils::sanitize( $greetings, 10 );
      
      $activo     = Utils::sanitize( $activo, 10 );
      $phone_cell = Utils::sanitize( $phone_cell, 20 );
      $phone_work = Utils::sanitize( $phone_work, 10 );
      $phone_home = Utils::sanitize( $phone_home, 10 );
      $birthdate  = Utils::sanitize( $birthdate, 20 );

      $cellphone_code = Utils::sanitize( $cellphone_code, 5 );
      $phone_work_ext = Utils::sanitize( $phone_work_ext, 8 );

      // binding parámetros al SQL
			$query -> bindParam(1, $username, \PDO::PARAM_STR);
			$query -> bindParam(3, $givenname, \PDO::PARAM_STR);
			$query -> bindParam(4, $lastname, \PDO::PARAM_STR);
			$query -> bindParam(5, $email, \PDO::PARAM_STR);
			$query -> bindParam(6, $empresaId, \PDO::PARAM_INT);

			/* Cargo = Role */
			$query -> bindParam(7, $cargo, \PDO::PARAM_STR);
			$query -> bindParam(8, $dependencia, \PDO::PARAM_STR);
			$query -> bindParam(9, $greetings, \PDO::PARAM_STR);

			/* Gender = sexo */		
			if ( $gender == "Masculino" ){
				$gender = "Hombre";
			} else {
				$gender = "Mujer";
			}
			$query -> bindParam(10, $gender, \PDO::PARAM_STR);

			/*
			 * Activo = NO por defecto
			 * Debe activarlo el ADMINISTRADOR DEL SISTEMA
			 */
			$query -> bindParam(11, $activo, \PDO::PARAM_STR);

			/*
			 * Celular se compone de codigo de pais (+57) + numero celular (314 1234567)
			 */

			$aux = $cellphone_code . $phone_cell;
			$query -> bindParam(12, $aux, \PDO::PARAM_STR);

			/* Otros numeros */
			$query -> bindParam(13, $phone_work, \PDO::PARAM_INT);
			$query -> bindParam(14, $phone_work_ext, \PDO::PARAM_INT);
			$query -> bindParam(15, $phone_home, \PDO::PARAM_INT);

			/* cumpleaños */
			$query -> bindParam(16, $birthdate, \PDO::PARAM_STR);

			$count = $query -> execute();

			/* Cantidad de filas afectadas, se supone que es 1 */
			return $count;

		} catch(\PDOException $e) {

			/* print "Error in models.Admin.User.php.insert(): " . $e -> getMessage(); */



			$internalErrorCodigo  = "PDOException in models.Admin.User.insert():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $greetings." ". $givenname." ". $lastname." ". $gender." ".
					$email." ". $username." ". $password." ".
					$empresaId." ". $dependencia." ". $cargo." ".
					$cellphone_code." ". $phone_cell." ". $phone_home." ". $phone_work." ". $phone_work_ext." ".$activo;



			/**/

			Transaccion::insertTransaccionPDOException("Usuario_LogIn",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
      
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");

			die;

		}

	}



	/**

	 * Actualizacion

	 */

	public static function update($userId, $greetings, $givenname, $lastname, $gender,

			$email, $dependencia, 

			$cellphone_code, $phone_cell, $phone_home, $phone_work, $phone_work_ext,

			$birthdate) {



		try {

			$otroUsuarioConEsteEmail = user::searchAnotherEmail($userId,$email);



			if ( $otroUsuarioConEsteEmail != NULL || $otroUsuarioConEsteEmail != "" || count($otroUsuarioConEsteEmail) > 1 ){
				/*
				 * NO actualizará al usuario
				 * count($otroUsuarioConEsteEmail) = 1 cuando el arreglo viene VACIO
				 */
				return 0;
			}

			$connection = Database::instance();

      /*
       * Sanitization
       */
      $givenname  = Utils::sanitize( $givenname, 32 );
      $lastname   = Utils::sanitize( $lastname, 32 );
      $email      = Utils::sanitize( $email, 100 );
      
      $dependencia= Utils::sanitize( $dependencia, 150 );
      $greetings  = Utils::sanitize( $greetings, 10 );
      
      $phone_cell = Utils::sanitize( $phone_cell, 20 );
      $phone_work = Utils::sanitize( $phone_work, 10 );
      $phone_home = Utils::sanitize( $phone_home, 10 );
      $birthdate  = Utils::sanitize( $birthdate, 20 );

      $cellphone_code = Utils::sanitize( $cellphone_code, 5 );
      $phone_work_ext = Utils::sanitize( $phone_work_ext, 8 );


			/* Gender = sexo */		
			if ( $gender == "Masculino" ){
				$gender = "Hombre";

			} else {
				$gender = "Mujer";

			}

			/*

			 * Celular se compone de codigo de pais (+57) + numero celular (314 1234567)

			 */

			$aux = $cellphone_code . $phone_cell;

			$sql = " UPDATE Usuarios SET nombre=?, apellido=?, "
					. " email=?,dependencia=?, saludo=?,gender=?, "
					. " celular=?, telefonoTrabajo=?, extensionTrabajo=?,telefonoCasa=?, "
					. " cumpleanos=? "
					. " WHERE id = ? ";

			$query = $connection -> prepare($sql);

			$query -> bindParam(1, $givenname, \PDO::PARAM_STR);
			$query -> bindParam(2, $lastname,  \PDO::PARAM_STR);

			$query -> bindParam(3, $email, 		 \PDO::PARAM_STR);
			$query -> bindParam(4, $dependencia, \PDO::PARAM_STR);

			$query -> bindParam(5, $greetings, \PDO::PARAM_STR);
			$query -> bindParam(6, $gender, 	\PDO::PARAM_STR);

			$query -> bindParam(7, $aux, \PDO::PARAM_STR);


			$query -> bindParam(8, $phone_work, 	\PDO::PARAM_STR);
			$query -> bindParam(9, $phone_work_ext, \PDO::PARAM_STR);
			$query -> bindParam(10, $phone_home, 	\PDO::PARAM_STR);

			$query -> bindParam(11, $birthdate, \PDO::PARAM_STR);
			$query -> bindParam(12, $userId, 	\PDO::PARAM_INT);

			$count = $query -> execute();

			/* Cantidad de filas afectadas, se supone que es 1 */
			return $count;

		} catch(\PDOException $e) {

			/* print "Error in models.Admin.User.php.insert(): " . $e -> getMessage(); */



			$internalErrorCodigo  = "PDOException in models.Admin.User.insert():";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = $greetings." ". $givenname." ". $lastname." ". $gender." ".

					$email." ". $username." ". $password." ".

					$empresaId." ". $dependencia." ". $cargo." ".

					$cellphone_code." ". $phone_cell." ". $phone_home." ". $phone_work." ". $phone_work_ext." ".$activo;



			/**/

			Transaccion::insertTransaccionPDOException("Usuario_LogIn",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);

			View::set("internalErrorExtra",	 $internalErrorExtra);



			View::render("internalError");

			die;

		}

	}



	/**

	 * Actualizar SOLO el Password

	 * @param $claveActual - La clave actual en el Sistema

	 * @param $claveNueva - La clave por la cual se va a modificar

	 */

	public static function updatePassword($userName, $claveActual, $claveNueva){

		try {

			$connection = Database::instance();

      /**
       * Encriptacion de contraseñas
       */
      $claveNueva  = md5( strrev( $claveNueva ) );
      $claveActual = md5( strrev( $claveActual ) );

			$sql = " UPDATE Usuarios SET password = ? WHERE usuario = ? AND password = ? ";



			$query = $connection -> prepare($sql);



			$query -> bindParam(1, $claveNueva, 	\PDO::PARAM_STR);

			$query -> bindParam(2, $userName,  		\PDO::PARAM_STR);

			$query -> bindParam(3, $claveActual, 	\PDO::PARAM_STR);



			$count = $query -> execute();



			/* Cantidad de filas afectadas, se supone que es 1 */

			return $count;

		

		} catch(\PDOException $e) {

			$internalErrorCodigo  = "PDOException in models.Admin.User.updatePassword()):";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = "$userName: $claveActual, $claveNueva";



			/**/

			Transaccion::insertTransaccionPDOException("Usuario_Actualizar",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);

			View::set("internalErrorExtra",	 $internalErrorExtra);



			View::render("internalError");

			die;

		}

	}



	public static function delete($id){

		try {

			$conn = Database::instance();



			$sql = "DELETE FROM Usuarios WHERE id = ?";



			$query = $conn -> prepare($sql);



			$query -> bindParam(1, $id, \PDO::PARAM_INT);



			$cont = $query -> execute();



			return $cont;

		} catch(\PDOException $e) {

			$internalErrorCodigo  = "PDOException in models.Admin.User.updatePassword()):";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = "$userName: $claveActual, $claveNueva";



			/**/

			Transaccion::insertTransaccionPDOException("Usuario_Actualizar",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);

			View::set("internalErrorExtra",	 $internalErrorExtra);



			View::render("internalError");

			die;

		}

	}



	public static function getUserByEmailOrUsername($forgetPassword){

		try {



			$connection = Database::instance();



			$sql = "SELECT * FROM Usuarios WHERE usuario = ? OR email = ? LIMIT 1 ";



			$query = $connection -> prepare($sql);



			$query -> bindParam(1, $forgetPassword, \PDO::PARAM_STR);

			$query -> bindParam(2, $forgetPassword, \PDO::PARAM_STR);



			$query -> execute();



			return $query -> fetch( \PDO::FETCH_OBJ );



		} catch(\PDOException $e) {

			/* print "Error in models.Admin.User.php.getUserByEmailOrUsername(): " . $e -> getMessage(); */



			$internalErrorCodigo  = "PDOException in models.Admin.User.getUserByEmailOrUsername():";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = $forgetPassword;



			/**/

			Transaccion::insertTransaccionPDOException("Usuario_LogIn",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);

			View::set("internalErrorExtra",	 $internalErrorExtra);



			View::render("internalError");

			die;

		}

	}





	/**

	 * Obtener TODOS los Usuarios de UNA EMPRESA

	 */

	public static function getUsuariosDeEmpresa($empresaId, $ordenadoPorNombre){

		try {



			$connection = Database::instance();



			if ( $ordenadoPorNombre == true ){

 

				$sql = "SELECT * FROM Usuarios WHERE empresaId = ? ORDER BY nombre ASC ";

			} else {



				$sql = "SELECT * FROM Usuarios WHERE empresaId = ? ";

			}



			$query = $connection -> prepare($sql);



			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);



			$query -> execute();



			return $query -> fetchAll();



		} catch(\PDOException $e) {

			/* print "Error in models.Admin.User.php.getUsuariosDeEmpresa(): " . $e->getMessage(); */

			$internalErrorCodigo  = "PDOException in models.Admin.User.getUsuariosDeEmpresa():";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = "empresa:".$empresaId;



			/**/

			Transaccion::insertTransaccionPDOException("Usuario_LogIn",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);

			View::set("internalErrorExtra",	 $internalErrorExtra);



			View::render("internalError");

			die;

		}

	}





	/**

	 * Un Tecnico dado su ID / en la clausula WHERE se asegura que sea Tecnico

	 */

	public static function getTecnicoById($tecnicoId){

		try {



			$connection = Database::instance();



			$sql = "SELECT * FROM Usuarios WHERE id = ? AND role = 'tech' ";



			$query = $connection -> prepare($sql);



			$query -> bindParam(1, $tecnicoId, \PDO::PARAM_INT);



			$query -> execute();



			return $query -> fetch();



		} catch(\PDOException $e) {

			/* print "Error in models.Admin.User.php.getTecnicoById(): " . $e->getMessage(); */

			$internalErrorCodigo  = "PDOException in models.Admin.User.getTecnicoById():";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = $tecnicoId;



			/**/

			Transaccion::insertTransaccionPDOException("Usuario_LogIn",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);

			View::set("internalErrorExtra",	 $internalErrorExtra);



			View::render("internalError");

			die;

		}

	}





	/**

	 * Dado un EquipoID (Auto incremental) de la tabla Equipos, retorna su UsuarioId

	 */

	public static function getUserIdByEquipoId($equipoId){

		try {



			$connection = Database::instance();



			$sql = " SELECT usuarioId FROM Equipos WHERE id = ? ";



			$query = $connection -> prepare($sql);



			$query -> bindParam(1, $equipoId, \PDO::PARAM_INT);



			$query -> execute();



			return $query -> fetch();



		} catch(\PDOException $e) {

			/* print "Error in models.Admin.User.php.getUserIdByEquipoId(): " . $e->getMessage(); */

			$internalErrorCodigo  = "PDOException in models.Admin.User.getUserIdByEquipoId():";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = $equipoId;



			/**/

			Transaccion::insertTransaccionPDOException("Usuario_LogIn",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);

			View::set("internalErrorExtra",	 $internalErrorExtra);



			View::render("internalError");

			die;

		}

	}



	/**

	 * Tabla Preferences por defecto, cuando se crea un Usuario

	 */

	public static function setPreferenciasDefault($user){

		try {

			$connection = Database::instance();



			$userId = $user->id;



			$sql = " INSERT INTO Preferencias ( userId ) VALUES ( ? ) ";



			$query = $connection -> prepare($sql);



			$query -> bindParam(1, $userId, \PDO::PARAM_INT);



			$count = $query -> execute();

			

			/* Cantidad de filas afectadas, se supone que es 1 */

			return $count;



		} catch(\PDOException $e) {

			/* print "Error in models.Admin.User.php.setPreferenciasDefault(): " . $e->getMessage(); */

			$internalErrorCodigo  = "PDOException in models.Admin.User.setPreferenciasDefault():";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = $user;



			/**/

			Transaccion::insertTransaccionPDOException("Usuario_LogIn",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);

			View::set("internalErrorExtra",	 $internalErrorExtra);



			View::render("internalError");

			die;

		}

	}



	

	/**

	 * Tabla UsuarioEstatus, cuando se crea un Usuario

	 */

	public static function nuevoUsuarioEstatus($userId){

		try {

			$connection = Database::instance();



			$sql = " INSERT INTO UsuarioEstatus ( userId ) VALUES ( ? ) ";



			$query = $connection -> prepare($sql);



			$query -> bindParam(1, $userId, \PDO::PARAM_INT);



			$count = $query -> execute();

			

			/* Cantidad de filas afectadas, se supone que es 1 */

			return $count;



		} catch(\PDOException $e) {

			$internalErrorCodigo  = "PDOException in models.Admin.User.nuevoUsuarioEstatus():";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = "user:".$userId;



			/**/

			Transaccion::insertTransaccionPDOException("Usuario_LogIn",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);

			View::set("internalErrorExtra",	 $internalErrorExtra);



			View::render("internalError");

			die;

		}

	}





	/**

	 * Obtener los status, flags o campos "bandera" de un Usuario

	 */

	public static function getUsuarioEstatus($userId){

		try {



			$connection = Database::instance();



			$sql = "SELECT * FROM UsuarioEstatus WHERE userId = ? ";



			$query = $connection -> prepare($sql);



			$query -> bindParam(1, $userId, \PDO::PARAM_INT);



			$query -> execute();



			return $query -> fetch( \PDO::FETCH_OBJ );



		} catch(\PDOException $e) {

			$internalErrorCodigo  = "PDOException in models.Admin.User.getUsuarioEstatus():";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = $userId;



			/**/

			Transaccion::insertTransaccionPDOException("Usuario_LogIn",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);

			View::set("internalErrorExtra",	 $internalErrorExtra);



			View::render("internalError");

			die;

		}

	}





	/**

	 * Buscara en la tabla USUARIOS si ya existe en el valor <valorAvalidar> para el campo <campoAvalidar>

	 * @param campoAvalidar: { emai, username }

	 */

	public static function yaExisteEsteCampo( $campoAvalidar, $valorAvalidar ){

		try {

			$connection = Database::instance();



			$sql = "";



			/* trim limpiando espacios */

			$valorAvalidar = trim($valorAvalidar," ");



			if ( $campoAvalidar == "email" ){

				$sql = " SELECT id FROM Usuarios WHERE email = ? ";



			} else if ( $campoAvalidar == "username" ){

				$sql = " SELECT id FROM Usuarios WHERE usuario = ? ";



			} else {

				return false;

			} 



			$query = $connection -> prepare($sql);



			$query -> bindParam(1, $valorAvalidar, \PDO::PARAM_STR);



			$query -> execute();



			$result = $query -> fetch();



			if ( $result == null || $result == "" ){

				return false;

			} else {

				return true;

			}

		} catch(\PDOException $e) {

			/* print "Error in models.Admin.User.php.yaExisteEsteCampo(): " . $e->getMessage(); */

			$internalErrorCodigo  = "PDOException in models.Admin.User.yaExisteEsteCampo():";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = $campoAvalidar. ":". $valorAvalidar ;



			/**/

			Transaccion::insertTransaccionPDOException("Usuario_LogIn",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);

			View::set("internalErrorExtra",	 $internalErrorExtra);



			View::render("internalError");

			die;

		}

	}



	/**

	 * Un Usuario Y su EMPRESA dado su ID

	 */

	public static function getProfile($id){

		try {



			$connection = Database::instance();



			$sql = " SELECT *, u.nombre AS usuario_nombre, u.email AS usuario_email FROM Usuarios u INNER JOIN Empresas e ON u.empresaId = e.empresaId WHERE u.id = ? ";



			$query = $connection -> prepare($sql);



			$query -> bindParam(1, $id, \PDO::PARAM_INT);



			$query -> execute();



			return $query -> fetch();



		} catch(\PDOException $e) {

			/*print "Error in models.Admin.User.php.getById(): " . $e->getMessage();*/



			$internalErrorCodigo  = "PDOException in models.Admin.User.getProfile():";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = $id;



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

	 * Un Usuario Y su EMPRESA dado su ID

	 */

	public static function getManagersDeEmpresa($empresaId){

		try {



			$connection = Database::instance();



			$sql = " SELECT * FROM Usuarios WHERE empresaId = ? AND role = 'manager' ";



			$query = $connection -> prepare($sql);



			$query -> bindParam(1, $empresaId, \PDO::PARAM_INT);



			$query -> execute();



			return $query -> fetchAll();



		} catch(\PDOException $e) {

			/*print "Error in models.Admin.User.php.getById(): " . $e->getMessage();*/



			$internalErrorCodigo  = "PDOException in models.Admin.User.getManagersDeEmpresa():";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = $empresaId;



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

	 * Busvando OTRO Usuario que tenga este CORREO

	 * SI el resultado es MAYOR que cero 0, entonces HAY 2 USUARIOS CON EL MISMO CORREO: ERROR!!!

	 */

	public static function searchAnotherEmail($userId, $email){

		try {



			$connection = Database::instance();



			$sql = " SELECT usuario FROM Usuarios WHERE id <> ? AND email = ? ";



			$query = $connection -> prepare($sql);



			$query -> bindParam(1, $userId, \PDO::PARAM_INT);

			$query -> bindParam(2, $email,  \PDO::PARAM_STR);



			$query -> execute();



			return $query -> fetch();



		} catch(\PDOException $e) {

			/*print "Error in models.Admin.User.php.getById(): " . $e->getMessage();*/



			$internalErrorCodigo  = "PDOException in models.Admin.User.getManagersDeEmpresa():";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = $empresaId;



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

	 * Buscando Usuarios...

	 * @param $givenOrLastNameOrEmailOrCompanyName por Nombre, Apellido, Email o por los Usuarios del nombre de una Empresa

	 */

	public static function searchUsers($givenOrLastNameOrEmailOrCompanyName){

		try {

			$connection = Database::instance();



			$a = $givenOrLastNameOrEmailOrCompanyName;



			$sql = " SELECT u.id, u.nombre, u.apellido, u.email, u.dependencia, u.role, u.celular, u.usuario, u.activo, "

					. " e.nombre AS empresaName, e.razonSocial, e.empresaId AS EmpresaID "

					. " FROM Usuarios u "

					. " LEFT JOIN Empresas e ON u.empresaId = e.empresaId "

					. " WHERE u.nombre LIKE '%".$a."%' OR u.apellido LIKE '%".$a."%' OR u.email LIKE '%".$a."%' "

					. " OR u.dependencia LIKE '%".$a."%' OR u.usuario LIKE '%".$a."%' OR e.nombre LIKE '%".$a."%' ";



			$query = $connection -> prepare($sql);



			$query -> bindParam(1, $givenOrLastNameOrEmailOrCompanyName, \PDO::PARAM_STR);

			$query -> bindParam(2, $givenOrLastNameOrEmailOrCompanyName, \PDO::PARAM_STR);

			$query -> bindParam(3, $givenOrLastNameOrEmailOrCompanyName, \PDO::PARAM_STR);

			$query -> bindParam(4, $givenOrLastNameOrEmailOrCompanyName, \PDO::PARAM_STR);

			$query -> bindParam(5, $givenOrLastNameOrEmailOrCompanyName, \PDO::PARAM_STR);

			$query -> bindParam(6, $givenOrLastNameOrEmailOrCompanyName, \PDO::PARAM_STR);

			

			$query -> execute();



			return $query -> fetchAll();



		} catch(\PDOException $e) {

			/*print "Error in models.Admin.User.php.getById(): " . $e->getMessage();*/



			$internalErrorCodigo  = "PDOException in models.Admin.User.searchUsers():";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = "data:".$givenOrLastNameOrEmailOrCompanyName;



			/**/

			Transaccion::insertTransaccionPDOException("Tecnico_Nuevo_Inventario",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);

			View::set("internalErrorExtra",	 $internalErrorExtra);



			View::render("internalError");

			die;

		}

	}



	/**

	 * Buscando Usuarios...

	 * @param $literalStringToSearch por Nombre, Apellido, Email o por los Usuarios de una Empresa (nombre razon social o NIT)

	 */

	public static function searchUsers2($literalStringToSearch){

		try {

			$connection = Database::instance();



			$a = $literalStringToSearch;



			$sql = " SELECT u.*, e.nombre AS empresaName, e.razonSocial, e.empresaId AS EmpresaID "

					. " FROM Usuarios u "

					. " LEFT JOIN Empresas e ON u.empresaId = e.empresaId "

					. " WHERE u.nombre LIKE '%".$a."%' OR u.apellido LIKE '%".$a."%' OR u.email LIKE '%".$a."%' "

					. " OR u.dependencia LIKE '%".$a."%' OR u.usuario LIKE '%".$a."%' OR e.nombre LIKE '%".$a."%' "

					. " OR e.razonSocial LIKE '%".$a."%' OR e.NIT LIKE '%".$a."%' ";



			$query = $connection -> prepare($sql);



			$query -> bindParam(1, $a, \PDO::PARAM_STR);

			$query -> bindParam(2, $a, \PDO::PARAM_STR);

			$query -> bindParam(3, $a, \PDO::PARAM_STR);

			$query -> bindParam(4, $a, \PDO::PARAM_STR);

			$query -> bindParam(5, $a, \PDO::PARAM_STR);

			$query -> bindParam(6, $a, \PDO::PARAM_STR);

			$query -> bindParam(7, $a, \PDO::PARAM_STR);

			$query -> bindParam(8, $a, \PDO::PARAM_STR);

			

			$query -> execute();



			return $query -> fetchAll();



		} catch(\PDOException $e) {



			$internalErrorCodigo  = "PDOException in models.Admin.User.searchUsers2():";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = "literal:".$literalStringToSearch;



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

	 * ACTIVAR o DESactivar a un Usuario

	 */

	public static function cambiarStatus($userId, $role){

		try {

			$connection = Database::instance();



			$sql = " UPDATE Usuarios SET activo = ? WHERE id = ? ";



			$query = $connection -> prepare($sql);



			$query -> bindParam(1, $role,   \PDO::PARAM_STR);

			$query -> bindParam(2, $userId, \PDO::PARAM_INT);



			return $query -> execute();



		} catch(\PDOException $e) {

			$internalErrorCodigo  = "PDOException in models.Admin.User.cambiarStatus():";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = "user:".$userId;



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
   * @param user Objeto Usuarios
   */
  public static function establecerPasswordTemporal( $user ){
    try {
			$connection = Database::instance();

			$sql = " UPDATE Usuarios SET password = ? WHERE id = ? ";

			$query = $connection -> prepare($sql);

      $x = "7e1b812defa66152c881a8df30de0dda"; //1234567
			$query -> bindParam(1, $x,  \PDO::PARAM_STR);
			$query -> bindParam(2, $user->id, \PDO::PARAM_INT);

			$query -> execute();

      return true;

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.Admin.User.establecerPasswordTemporal(usuario):";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "userID:".$user->id;

			/**/
			Transaccion::insertTransaccionPDOException("Password_gestion",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);

			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
  }
}