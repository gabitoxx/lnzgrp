<?php
namespace app\controllers;
defined("APPPATH") OR die("Access denied");

/* ESTO LO HACE en el constructor las nuevas versiones de CodeIgniter (>3.0)
   session_start(); //we need to start session in order to access it through CI
*/
use \core\View,
	\app\models\user,
	\app\models\admin\user as UserAdmin,
	\app\models\EmailManagement,
	\app\models\admin\Company as Company,
	\app\models\admin\Transaccion,
	\app\models\Utils;

class UserAuthentication {

	/**
	 * @var
	 * Variable que indica si el sitio está o no en Construcción (fuera de servicio)
	 * EN PRODUCCIÓN deberá estar en false
	 */
	const EN_CONSTRUCCION = false;


	public function __construct() {
		
		/* parent::__construct(); */
		
	}

	public function index() {	
	}

	/*
	 * Show registration page for Admins
	 */
	public function register() {
		
		View::set("pageTitle", "Registro de nuevo Usuario | ADMINISTRADOR ");

		/* obteniendo empresas */
		$companies = Company::getAll();
		View::set("empresas", $companies);
		
		View::render("create_user");

	}



	/**
	 * Check for user login process
	 */
	public function login() {

		if ( self::EN_CONSTRUCCION == true ){
			View::render("construccion");
			return;
		}

		$username = $_POST['username'];
		$password = $_POST['password'];

		/* To protect MySQL injection for Security purpose */
		$username = stripslashes($username);
		$password = stripslashes($password);

		/**
		 * Llamando al metodo que se creo como Interface
		 * y desarrollado en Admin/User
		 */
		$userType="activo";
		$user = UserAdmin::getUser($username, $password, $userType);

		/*
		 * Obteniendo el sistema operativo o browser/navegador del Cliente
		 */
		$user_agent = $_SERVER['HTTP_USER_AGENT'];

		if( isset($user->usuario) ) { /* && is_object($user->usuario)) */
			
			/**
			 * To access an array member you use $array['KEY'];
			 * To access an object member you use $obj->KEY;
			 * To access an object member inside an array of objects:
			 *  $array[0] // Get the first object in the array
			 *  $array[0]->KEY // then access its key
			 *
			 * echo "se hallo.1:" . $user[0]->usuario;		NO PINTA NADA
			 * echo "se hallo.2:" . $user['usuario'];		NO PINTA NADA
			 * echo "se hallo.3:" . $user->usuario;			SÍ PINTA, PORQUE accede al miembro del objeto stdClass Object
			 * print_r($user); 
			 *
			 */
			
			/* To Start a PHP Session */
			session_start();
			
			$_SESSION['sessionId'] = session_id();

			/* Initializing Session with value of PHP Variable */
			$_SESSION['login_username'] = $user->usuario;
			$_SESSION['role_user']      = $user->role;
			$_SESSION['logged_user']    = $user;

			$_SESSION['logged_user_saludo'] = $user->saludo . " " . $user->nombre . " " . $user->apellido;
			
			$_SESSION['logged_user_empresaId'] = $user->empresaId;

			/**
			 * Estableciendo el huso horario correspondiente
			 * A FUTURO: verificar el $user->celular, el codigo, por si es diferente a +57, establecer otro uso horario
			 */
			date_default_timezone_set("America/Bogota");

			putenv("TZ=America/Bogota");

			/*
			 * Guardar el registro de ACCION en Transaccion
			 */
			Transaccion::insertTransaccionLogin("Ok", $user -> id,
					$_SESSION['role_user'], $_SESSION['logged_user_empresaId'], $user_agent);


			/**
			 * Pasando Variables a la Vista
			 */
			View::set("nombreUsuario", $user -> nombre . " " . $user -> apellido);
			View::set("username", $user -> usuario);
			View::set("user", $user);

			$male = true;
			if ( $user -> gender == "Hombre" ){
				$male = true;
				View::set("pageTitle", $user->usuario . ", Bienvenido al Portal Lanuza Group");

			} else {
				$male = false;
				View::set("pageTitle", $user->usuario . ", Bienvenida al Portal Lanuza Group");
			}

			View::set("genderMale", $male);

			/**
			 * Llamando a la Vista respectiva, segun el usuario
			 */
			if ( $user -> role == "client" ){
				
				/* Color del Portal para Clientes */
				$_SESSION['portal_color_rgb']= RGB_CLIENTE;

				View::render("welcome_client");

			} else if ( $user -> role == "tech" ){

				/* Color del Portal para Técnicos */
				$_SESSION['portal_color_rgb']= RGB_TECH;

				View::render("welcome_tech");

			} else if ( $user -> role == "manager" ){

				/* Color del Portal para Gerentes */
				$_SESSION['portal_color_rgb']= RGB_MANAGER;

				View::render("welcome_manager");

			} else if ( $user -> role == "developer" ){

				/* Color del Portal para Programadores */
				$_SESSION['portal_color_rgb']= "#A94442";

				View::render("");

			} else if ( $user -> role == "admin" ){

				/* Color del Portal para Administrador */
				$_SESSION['portal_color_rgb']= RGB_ADMIN;

				$opcionMenu = "home";
				View::set("opcionMenu", $opcionMenu);

				View::render("portal_admin_home");
			}

		} else {
			/*
			 * Transaccion
			 */
			Transaccion::insertTransaccionLogin("Not_Ok", $username, $password, "", $user_agent);

			/**
			 * Intentar logearse de nuevo o si se hizo un intento directo
			 */
			$error_message = "Usuario o Contraseña inválidas.<br/>Por favor, intente nuevamente.";
			View::set("error_message", $error_message);
			
			View::set("pageTitle", "Usuario o Contraseña inválidas, favor intente nuevamente | Lanuza Group SAS ");

			View::render("index3");
		}
	}
	
	/**
	 * 
	 */
	public function showLogin() {
		/**
		 * Llamando a la Vista
		 */
		View::render("index3");
		
	}


	/** 
	 * Validate and store registration data in database
	 */
	public function new_user_registration() {
		
		$userType = "inactivo";

		/* llamando al modelo */
		$insertado = UserAuthentication::createUser($userType);
		
		if ( $insertado == 1 ){
			$index_message_title = "Usuario creado satisfactoriamente";

			$index_message = "<table><tr><td align='center'><span class='glyphicon glyphicon-send logo-small'></span></td><td align='center'>"
					. "Usted ha creado un Usuario para nuestro <br/><b>Portal de <b>Lanuza Group</b><br/>"
					. "Nuestros Administradores deber&aacute;n aprobar la creaci&oacute;n de dicho usuario."
					. "<br/>Le estaremos haciendo llegar su cuenta de correo electr&oacute;nico la aprobaci&oacute;n de dicho Usuario "
					. "para que pueda comenzar a disfrutar de nuestros servicios."
					. "</td><td align='center'><span class='glyphicon glyphicon-ok logo-small'></span></td></tr></table>";

			View::set("pageTitle", "Usuario creado satisfactoriamente");

			/* SETEANDO las variables para que se vean en la vista MODAL del index  */
			View::set("index_message_title", $index_message_title);
			View::set("index_message", $index_message);

			View::render("index3");

		} else {
			echo "pagina de error, porq dio $ insertado:".$insertado;
		}
	}

	/** 
	 * Para ADMINISTRADORES
	 */
	public function create_new_user() {
		
		$userType = "activo";

		/* llamando al modelo */
		$cantidad = UserAuthentication::createUser($userType);

		echo "Nivel Administrativo: se insert&oacute; {". $cantidad ."} usuario con status ACTIVO.
				<br/><br/><br/>
				Para ingresar al Portal, debe loguarse con su Usuario o Email y Contrase&ntilde;a reci&eacute;n creada en la direcci&oacute;n:
				<br/><br/><br/>";
		echo '<a href="https://lanuzagroup.com">lanuzagroup.com</a>';
		
	}

	/**
	 * Creando el usuario
	 */
	public function createUser($userType){

		/**
		 * Valores del Formulario
		 */
		$greetings     = $_POST['greetings'];
		$givenname     = $_POST['givenname'];
		$lastname      = $_POST['lastname'];
		$gender        = $_POST['gender'];

		$email         = $_POST['email'];
		$username      = $_POST['username'];
		$pwd           = $_POST['pwd'];
		$pwdrepited    = $_POST['pwdrepited'];

		$dependencia   = $_POST['dependencia'];
		$cargo         = $_POST['cargo'];

		$cellphone_code= $_POST['cellphone_code'];
		$phone_cell    = $_POST['phone_cell'];
		$phone_home    = $_POST['phone_home'];
		$phone_work    = $_POST['phone_work'];
		$phone_work_ext= $_POST['phone_work_ext'];

		/*	Campos de Compañia nueva:
		 * companyCombo -- existente
		 * company_check value="company_new"
		 * si no, entonces validar:
		 * company, company_razon, company_nit, company_pais, company_estados, company_city
		 */
		$companyCombo = $_POST['companyCombo'];

		$company        = $_POST['company'];
		$company_razon  = $_POST['company_razon'];
		$company_nit    = $_POST['company_nit'];
		$company_pais   = $_POST['company_pais'];
		$company_estado = $_POST['company_estados'];
		$company_city   = $_POST['company_city'];
		$company_direcc = $_POST['company_direccion'];


		/* To protect MySQL injection for Security purpose */
		$greetings     = stripslashes($greetings);
		$givenname     = trim( stripslashes($givenname) );
		$lastname      = trim( stripslashes($lastname) );
		$gender        = stripslashes($gender);

		$email         = stripslashes($email);
		$username      = stripslashes($username);
		$pwd           = stripslashes($pwd);
		$pwdrepited    = stripslashes($pwdrepited);

		$dependencia   = stripslashes($dependencia);
		$cargo         = stripslashes($cargo);

		$cellphone_code= stripslashes($cellphone_code);
		$phone_cell    = stripslashes($phone_cell);
		$phone_home    = stripslashes($phone_home);
		$phone_work    = stripslashes($phone_work);
		$phone_work_ext= stripslashes($phone_work_ext);

		$userType      = stripslashes($userType);

		$companyCombo  = stripslashes($companyCombo);
		$company       = stripslashes($company);
		$company_razon = stripslashes($company_razon);
		$company_nit   = stripslashes($company_nit);
		$company_pais  = stripslashes($company_pais);
		$company_estado= stripslashes($company_estado);
		$company_city  = stripslashes($company_city);
		$company_direcc= stripslashes($company_direcc);

		/*
		 * - ucfirst() convierte la Primera Letra en Mayúscula (no realiza acciones sobre la otras letras)
		 *
 		 * - ucwords() convierte la Primera Letra de CADA PALABRA en Mayúscula (no realiza acciones sobre la otras letras)
 		 *
 		 * - strtolower() convierte todas las letras en minúsculas
		 */
		$givenname = ucwords( strtolower( $givenname ));
		$lastname  = ucwords( strtolower( $lastname ));

		$dependencia = ucfirst($dependencia);

		/* Cumpleaños */
		$dia = $_POST['birth_day'];
		if ( $dia == "none" ){
			$dia = 1;
		}

		$mes = $_POST['birth_mes'];
		if ( $mes == "none" ){
			$mes = 1;
		}

		$year = $_POST['birth_year'];
		if ( $year == "none" ){
			$year = 1912;
		}

		$fechaCumple = Utils::crearFecha($year, $mes, $dia, 12, "AM");

		/*
		 * Registrando o no Empresa nueva
		 * devolviendo su ID
		 */
		$idEmpresa = 0;
		
		$nuevaEmpresa = isset($_POST['company_check']) && $_POST['company_check'] 
				? true : false;

		if ( $nuevaEmpresa ) {
			/* Crear nueva empresa y devolver el ID  */
			$compania = Company::insert($company, $company_razon, $company_nit,
				$company_pais, $company_estado, $company_city, $company_direcc);

			$idEmpresa = $compania->empresaId;

		} else {
			/* insertar directamente este ID */
			$idEmpresa = $_POST['companyCombo'];
			$idEmpresa = stripslashes($idEmpresa);
		}

		/**
		 * Creando el usuario en la BD
		 */
		$cantidad = UserAdmin::insert(
				$greetings,
				$givenname,
				$lastname,
				$gender,
				$email,
				$username,
				$pwd,
				$idEmpresa,
				$dependencia,
				$cargo,
				$cellphone_code,
				$phone_cell,
				$phone_home,
				$phone_work,
				$phone_work_ext,
				$userType,
				$fechaCumple
		);
		
		/* echo "createUser(), Se supone q inserto {". $cantidad ."}"; return $cantidad; */
		/* Cantidad de filas afectadas, se supone que es 1 */
		if ( $cantidad == 1 ){
			$userTipo="";
			$user = UserAdmin::getUser($username, $pwd, $userTipo);

			/*
			 * Creando Preferencias del Usuario por defecto y sus campos "flag" o "bandera"
			 */
			UserAdmin::setPreferenciasDefault($user);

			UserAdmin::nuevoUsuarioEstatus($user->id);

			/**/
			Transaccion::insertTransaccionCreateUser("Ok", $user, $userType);

			/*
			 * Notificar a Anderson y a Direccion LanuzaGroup
			 */
			EmailManagement::nuevoUsuarioCreado($user);		

			return $cantidad;

		} else {
			/**/
			$info = "Formulario:".$greetings." ".$givenname." ".$lastname." ".
				$gender." ".$email." ".$username." ".$pwd." ".
				$idEmpresa." ".$dependencia." ".$cargo." ".
				$cellphone_code." ".$phone_cell." ".$phone_home." ".$phone_work." ".$phone_work_ext
				." --Activo:".$userType;
			Transaccion::insertTransaccionCreateUser("Not_Ok", $cantidad, $info);

			return 0;
		}
	}

	/**
	 * Logout from logged user page 
	 */
	public function logout() {

		session_start();

		/**/
		$user = $_SESSION['logged_user'];
		Transaccion::insertTransaccionLogout("Ok", $user -> id,$_SESSION['role_user'], $_SESSION['logged_user_empresaId']);

		if( isset($_SESSION['sessionId']) ){
			/*
			 * Is Used To Destroy Specified Session
			 */
			unset( $_SESSION['sessionId'] );
			
			/*
			 * si tenemos muchas variables de sesión y queremos liberarlas todas
			 */
			$_SESSION = array();
		}

		/* Is Used To Destroy All Sessions */
		session_destroy();

		/**
		 * Pasando Variables a la Vista
		 */
		View::set("pageTitle", "Lanuza Group SAS | Su empresa de Soporte TI | Official Website");

		/**
		 * Llamando a la Vista
		 */
		View::render("index3");
	}

	
	/**
	 * Olvido de Password, email para recordar
	 */
	public function forget(){

		/* viene Email o nombre de usuario */
		$forgetPassword = $_POST['datamail'];

		$forgetPassword = stripslashes($forgetPassword);

		$user = UserAdmin::getUserByEmailOrUsername($forgetPassword);

		if( isset($user->usuario) ) {
			/*SI encontrado*/
			$sent = EmailManagement::recordarPassword($user);

			if ($sent == true){
				/* correo enviado satisfactoriamente */
				$index_message_title = "Correo enviado satisfactoriamente";

				$index_message = "<table><tr><td align='center'><span class='glyphicon glyphicon-envelope logo-small'></span></td><td align='center'>"
						. "Hemos enviado a <br/><b>"
						. $user->email
						. "</b><br/>"
						. "un correo con su Contrase&ntilde;a de vuelta. Usuario: <b>"
						. $user->usuario
						. "</b> <br/>"
						. $user->saludo . " " . $user->nombre . " " .  $user->apellido . ", "
						. "le invitamos a que revise en su <b>Bandeja de Entrada Principal</b> o en su carpeta <b>Todos</b>. "
						. "Inclusive hay servicios de correo que lo pudieran depositar en <b>SPAM</b>."
						. "</td><td align='center'><span class='glyphicon glyphicon-ok logo-small'></span></td></tr></table>";

				View::set("pageTitle", "Usuario creado satisfactoriamente");

				/**/
				Transaccion::insertTransaccionForgetPassword("Ok", $user->id, $user->role, $user->email, $user->empresaId, $index_message_title);

				/* SETEANDO las variables para que se vean en la vista MODAL del index  */
				View::set("index_message_title", $index_message_title);
				View::set("index_message", $index_message);

				View::render("index3");

			} else {
				/* correo NO enviado */
				$index_message_title = "Correo NO enviado";

				$index_message = "<table><tr><td align='center'><span class='glyphicon glyphicon-envelope logo-small' style='color:red;'></span></td><td align='center'>"
						. "En estos momentos el servicio de ENV&Iacute;O DE EMAILS se encuentra ca&iacute;do. No hemos podido enviar a <br/><b>"
						. $user->email
						. "</b><br/>"
						. "un correo con su Contrase&ntilde;a de vuelta. Usuario: <b>"
						. $user->usuario
						. "</b> <br/>"
						. $user->saludo . " " . $user->nombre . " " .  $user->apellido . ", "
						. "le invitamos a que lo intente m&aacute;s tarde. "
						. "De persistir el error varias veces, le invitamos a que se <b>comunique con nosotros</b> para hacernoslo saber."
						. "</td><td align='center'><span class='glyphicon glyphicon-remove-sign logo-small' style='color:red;'></span></td></tr></table>";

				View::set("pageTitle", "Usuario creado satisfactoriamente");

				/* SETEANDO las variables para que se vean en la vista MODAL del index  */
				View::set("index_message_title", $index_message_title);
				View::set("index_message", $index_message);

				/**/
				Transaccion::insertTransaccionForgetPassword("Not_Ok", $user->id, $user->role, $user->email, $user->empresaId, $index_message_title);

				View::render("index3");
			}

		} else {
			/* Usuario NO encontrado */
			View::set("pageTitle", "Email o Usuario inválido, favor intente nuevamente | Lanuza Group SAS ");
			
			$error_message          = "Email o Usuario inválido.<br/>Por favor, intente nuevamente.";
			$index_message_title = "Email o Usuario inválido";
			
			/* SETEANDO las variables para que se vean en la vista MODAL del index  */
			View::set("index_message_title", $index_message_title);
			View::set("index_message", $error_message);

			/**/
			Transaccion::insertTransaccionForgetPassword("Not_Ok", "", "", $forgetPassword, 0, "");

			View::render("index3");
		}
	}


	/**
	 * Validacion de Campos NO repetidos de Usuarios anteriores
	 * campoAvalidar: { emai, username }
	 */
	public function validar_campos_no_repetidos(){

		if ( isset( $_POST['campoAvalidar'] ) ){

			/* puede ser email OR username */
			$campoAvalidar = $_POST['campoAvalidar'];

			$valorAvalidar = $_POST['valorAvalidar'];

			$result = UserAdmin::yaExisteEsteCampo( $campoAvalidar, $valorAvalidar );

			if ( $result == false ){
				/* Valor NO existe, por lo tanto sí se puede usar */
				echo "Ok";
			} else {
				echo "Not_Ok";
			}
		}
	}

}