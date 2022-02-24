<?php

namespace app\controllers;

defined("APPPATH") OR die("Access denied");



use \core\View,

	\app\models\Clients,

	\app\models\Equipos,

	\app\models\Incidencias,

	\app\models\admin\user as UserAdmin,

	\app\controllers\Tecnicos,

	\app\models\admin\Company,

	\app\models\admin\Transaccion,

	\app\models\Soportes,

	\app\models\Utils,

	\app\models\EmailManagement,

	\app\models\InventarioScripts;



class Portal {



	/*********************************************************************************************

	 * REDIRECCIONES DEL MENÚ Portal para CLIENTES

	 */

	public static function index()

	{

		/* comprombando que sí funciona:  echo "Hola index"; */



		/**

		 * Pasando Variables a la Vista

		 */

		View::set("pageTitle", "Lanuza Group SAS | Su empresa de Soporte TI | Official Website");



		/**

		 * Llamando a la Vista

		 */

		View::render("index");

	}





	public static function home() {

		session_start();



		/*comprombando que sí funciona:  

		$username = $_SESSION['login_username'];

		echo $username;

		$user = $_SESSION['logged_user'];

		echo $user->saludo . " " . $user->nombre . " " . $user->apellido;

		*/



		/* Pasando Variables a la Vista */

		try {

			$user = $_SESSION['logged_user'];



		} catch ( \Exception $e ) {

			View::render( "404" );

			exit;

		}

		

		View::set("user", $user);



		/* Seteando el Email en Sesion para uso de envíos de correo */

		$_SESSION['logged_user_email'] = $user->email;



		/*

		 * Iniciando sesion segun el tipo de Usuario

		 */

		if ( $_SESSION['role_user'] == "client" ){

			/*

			 * Clientes

			 */

			Portal::startClient( $user );





		} else if ( $_SESSION['role_user'] == "tech" ){

			/*

			 * Tecnicos

			 */

			Tecnicos::startTech( $user );





		} else if ( $_SESSION['role_user'] == "manager" ){

			/*

			 * Gerentes

			 */

			Portal::startManager( $user );





		} else if ( $_SESSION['role_user'] == "admin" ){

			/*

			 * Admnistrador

			 */

			$opcionMenu = "home";

			View::set("opcionMenu", $opcionMenu);



			View::set("pageTitle", "Admin - LanuzaSoft");

				

			View::render( "portal_admin_home" );



		} else {

			View::render( "404" );

		}

	}





	/**

	 * Iniciando Vista Cliente

	 * - si tiene incidencias por ver, iniciará "ver_incidencias.php"

	 * - si no, su opcion de menu será "crear_incidencias.php"

	 */

	private static function startClient( $user ){



		$incidencias = Incidencias::getIncidenciasDeUsuario($user->id);



		if ( $incidencias != null ){

			/**

			 * Opcion del menu a desplegar: VER INCIDENCIAS Pendientes

			 */

			$opcionMenu = "ver_incidencias";

			View::set("opcionMenu", $opcionMenu);



			/* Incidencias */

			View::set("incidencias", $incidencias);





		} else {

			/* Crear incidencia :: formulario */

			Portal::form_new_incidencias($user);

		}



		$titulo = $user->saludo . " " . $user->nombre . " " . $user->apellido;



		View::set("pageTitle", $titulo . " | Portal Clientes | Lanuza Group SAS");



		/**

		 * Siempre la Vista del PORTAL

		 */

		// View::render("portal/client_home");

		//echo addslashes("portal\client_home");

		View::render( "portal_client_home" );

	}





	/**

	 * Viene del formulario CREAR INCIDENCIA

	 */ 

	public static function create_incidencia(){



		try {

			session_start();



			$cantidadEquipos = $_POST['cantidad_equipos'];



			$equipoIdIncidencia = 0;



			if ( $cantidadEquipos == 0 ){

				$equipoIdIncidencia = NULL;



			} else if ( $cantidadEquipos == 1 ){

				$equipoIdIncidencia = $_POST['equipo_id'];

				

			} else {

				$equipoIdIncidencia = $_POST['equipos'];

			}



			$tipoFalla 		= $_POST['tipo_falla'];

			$observaciones  = $_POST['observaciones'];



			/* Limpiando campo textual */

			$observaciones  = stripslashes($observaciones);

			

			/* usuario logueado */

			$user = $_SESSION['logged_user'];

			$userId		= $user->id;

			$empresaId  = $user->empresaId;

			

			

			/* 

			 * Datos de Conexion Remota en Partner 

			 * campos: remote, userID y password

			 */

			$json = $_POST['jsonDatosConexion'];

			

			

			/* insertar Falla */

			$incidenciaID = Incidencias::insert($userId, $equipoIdIncidencia, $tipoFalla, $observaciones, $empresaId, $json);



			if ( $incidenciaID > 1 ){

				$incidencia_generada_correctamente = "Incidencia generada correctamente";



				View::set("incidencia_generada_correctamente",$incidencia_generada_correctamente);

				View::set("user", $user);



				/**/

				Transaccion::insertTransaccionIncidencia2("Ok", $userId,

						$_SESSION['role_user'], $empresaId, "", $incidenciaID);



			} else {

				/**/

				$info = $equipoIdIncidencia." ".$tipoFalla." ".$observaciones;



				Transaccion::insertTransaccionIncidencia("Not_Ok", $userId,

						$_SESSION['role_user'], $empresaId, $info);



			}



			/* 

			 * En este caso se crea una Incidencia: enviar correo a usuario, al Partner (GERENTE) y a LanuzaGroup

			 */

			EmailManagement::sendNuevaIncidencia($incidenciaID, $user, $_SESSION['role_user'],

					$equipoIdIncidencia, $tipoFalla, $observaciones);



			View::set("pageTitle", "Incidencia: Creada");





			if ( $_SESSION['role_user'] == "client" ) {



				$opcionMenu = "incidencia_creada";

				View::set("opcionMenu", $opcionMenu);



				View::render( "portal_client_home" );



			} else if ( $_SESSION['role_user'] == "manager" ) {



				$opcionMenu = "incidencia_creada";

				View::set("opcionMenu", $opcionMenu);



				View::render( "portal_manager_home" );



			}



		} catch (Exception $e) {

			$internalErrorCodigo  = "Exception in controllers.Portal.create_incidencia()";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = $equipoIdIncidencia."--".$tipoFalla."--".$observaciones."--".$observaciones."--".$userId."--".$empresaId;

			

			/**/

			Transaccion::insertTransaccionException("Incidencia_Crear",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra, $_SESSION['role_user'], $userId);

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);

			View::set("internalErrorExtra",	 $internalErrorExtra);



			View::render("internalError");

			die;

		}

	}





	/**

	 * Mostrar Formulario para Crear Incidencia

	 * para CLIENTE

	 */

	public static function form_new_incidencias($user){



		/* session_start(); */

		try {

			/**

			 * Opcion del menu a desplegar: CREAR INCIDENCIA

			 */

			$opcionMenu = "crear_incidencia";

			View::set("opcionMenu", $opcionMenu);

			

			/* combobox */

			$fallas = Clients::getFallasGenerales();

			View::set("fallas", $fallas);

			

			/* Equipo(s) de este Usuario (SI ES QUE TIENE) */

			$usuarioId = $user->id;

			$empresaId = $user->empresaId;



			$equipos = Equipos::getEquipos($usuarioId, $empresaId);

			

			if ( $equipos != null ){



				View::set("puede_crear_incidencia", true);

				

				$i=0;

				foreach ($equipos as $equipo){

					$i++;

				}



				View::set("cantidad_equipos", $i);

				

				if ( $i == 1 ){

					/*

					 * 1 equipo

					 */ 

					foreach ($equipos as $equipo){

						/* Id unico */

						View::set("equipo_id", $equipo[0]);



						/* ID del equipo */

						$ID = $equipo[10];

						View::set("equipo_id_barcode", $ID);



						/* Tipo de Equipo */

						$tipoEquipo = $equipo[13];



						/* infoBasica es el campo [11] */

						$basics = $tipoEquipo . ", " . $equipo[11];

						View::set("equipo_basics", $basics);



						break;

					}

				} else {

					/*

					 * varios equipos

					 */ 

					$array[][]= " "; 

					$j = 0;

					$tipo_equipo = "";



					foreach ( $equipos as $equipo ){

						/* Id unico */

						$array[$j][0] = $equipo[0];



						/* Tipo de Equipo ID */

						$aux = $equipo[5];



						$tipo_equipo = $equipo[13];



						$ID = $equipo[10];



						$array[$j][1] = $tipo_equipo . " ( Cod. Barras: " . $ID . " ) ";



						$j++;

					}



					View::set("equipos", $array);



				}

			} else {

				/*

				 * NINGUN equipo

				 */ 

				View::set("equipo_id_barcode", "Equipo No asignado");

				View::set("equipo_basics", "Comuníquese con Soporte TI de Lanuza Group o <b>Consulte los Tutoriales en el menú Ayuda</b> para saber cómo realizar la Asignación de Equipos a los Usuarios");

				View::set("puede_crear_incidencia", true);

				View::set("cantidad_equipos", 0);

			}



			/*

			 * Buscar si puede crear o no una Incidencia nueva

			 */

			$flags = UserAdmin::getUsuarioEstatus( $usuarioId );



			$faltanPorCerrar = $flags->incidenciasSinOpinar;

			if ( $faltanPorCerrar == NULL || $faltanPorCerrar == "" ){

				View::set("Incidencias_que_faltan_por_opinar", "");

			} else {

				View::set("Incidencias_que_faltan_por_opinar", $faltanPorCerrar);	

			}



		} catch (Exception $e) {

			$internalErrorCodigo  = "Exception in controllers.Portal.form_new_incidencias()";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = $user->id;

			

			/**/

			Transaccion::insertTransaccionException("Incidencia_Crear",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra, $_SESSION['role_user'], $usuarioId);

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);

			View::set("internalErrorExtra",	 $internalErrorExtra);



			View::render("internalError");

			die;

		}

	}





	/**

	 * Para Crear una nueva Incidencia

	 */

	public static function nueva_incidencia(){



		session_start();



		$user = $_SESSION['logged_user'];



		View::set("user", $user);



		Portal::form_new_incidencias($user);



		$titulo = $user->saludo . " " . $user->nombre . " " . $user->apellido;

		

		View::set("pageTitle", $titulo . " | Portal Clientes | Lanuza Group SAS");



		View::render( "portal_client_home" );



	}





	/**

	 * Para mostrar las Incidencias del usuario

	 */

	public static function ver_incidencias(){



		session_start();



		$user = $_SESSION['logged_user'];



		View::set("user", $user);



		$incidencias = Incidencias::getIncidenciasDeUsuario($user->id);



		if ( $incidencias != null ){



			/* Incidencias */

			View::set("incidencias", $incidencias);



		} else {

			View::set("no_incidencias", "no_incidencias");

		}



		$opcionMenu = "ver_incidencias";

		View::set("opcionMenu", $opcionMenu);

		

		$titulo = $_SESSION['logged_user_saludo'];

		View::set("pageTitle", $titulo . " | Portal Clientes | Lanuza Group SAS");



		View::render( "portal_client_home" );

	}





	/**

	 * Iniciando Vista GERENTES

	 * - si tiene incidencias por ver, iniciará "ver_todas_incidencias.php"

	 * - si no, su opcion de menu será "crear_incidencia_manager.php"

	 */

	private static function startManager( $user ){



		/* buscando empresa de este gerente */

		$empresa = Company::getEmpresaById( $user->empresaId );



		$_SESSION['logged_user_empresa'] = $empresa;

		

		/* buscando incidencias de esta empresa */

		$incidencias = Incidencias::getIncidenciasDeEmpresa($user->empresaId);



		if ( $incidencias != null ){

			/**

			 * Opcion del menu a desplegar: VER INCIDENCIAS Pendientes

			 */

			$opcionMenu = "ver_todas_incidencias";

			View::set("opcionMenu", $opcionMenu);



			/* Incidencias */

			View::set("incidencias", $incidencias);



			/* incidencias del propio Manager */

			$incidenciasDeManager = Incidencias::getIncidenciasDeUsuario($user->id);



			if ( $incidenciasDeManager != null ){



				/* incidencias Del Manager */

				View::set("incidenciasDeManager", $incidenciasDeManager);



			} else {

				View::set("no_incidencias_de_Manager", "no_incidenciasDeManager");

			}





		} else {

			/* Crear incidencia :: formulario */

			Portal::form_new_incidencia_gerente($user);

		}



		$titulo = $user->saludo . " " . $user->nombre . " " . $user->apellido;



		View::set("pageTitle", $titulo . " | Portal Gerentes | Lanuza Group SAS");



		/**

		 * Siempre la Vista del PORTAL

		 */

		// View::render("portal/client_home");

		//echo addslashes("portal\client_home");

		View::render( "portal_manager_home" );

	}



	/**

	 * Para mostrar las Incidencias de la EMPRESA (gerentes)

	 */

	public static function ver_todas_incidencias(){



		session_start();



		$user = $_SESSION['logged_user'];



		View::set("user", $user);



		/*  */

		$incidenciasDeManager = Incidencias::getIncidenciasDeUsuario($user->id);



		if ( $incidenciasDeManager != null ){



			/* incidencias Del Manager */

			View::set("incidenciasDeManager", $incidenciasDeManager);



		} else {

			View::set("no_incidencias_de_Manager", "no_incidenciasDeManager");

		}



		/*  */

		$incidenciasDeEmpresa = Incidencias::getIncidenciasDeEmpresa($user->empresaId);



		if ( $incidenciasDeEmpresa != null ){



			/* Incidencias de toda la Empresa */

			View::set("incidencias", $incidenciasDeEmpresa);



		} else {

			View::set("no_incidencias", "no_incidencias");

		}



		$opcionMenu = "ver_todas_incidencias";

		View::set("opcionMenu", $opcionMenu);

		

		$titulo = $_SESSION['logged_user_saludo'];

		View::set("pageTitle", $titulo . " | Portal Gerentes | Lanuza Group SAS");



		View::render( "portal_manager_home" );

	}





	/**

	 * Para Crear una nueva Incidencia

	 */

	public static function nueva_incidencia_gerente(){



		session_start();



		$user = $_SESSION['logged_user'];



		View::set("user", $user);



		/* VARIOS EQUIPOS + VARIOS USUARIOS */

		Portal::form_new_incidencia_gerente($user);		



		$titulo = $user->saludo . " " . $user->nombre . " " . $user->apellido;

		

		View::set("pageTitle", $titulo . " | Portal Gerentes | Lanuza Group SAS");



		View::render( "portal_manager_home" );



	}



	/**

	 * Mostrar Formulario para GERENTES: Crear Incidencia

	 */

	private static function form_new_incidencia_gerente($user){

		try {

			/**

			 * Opcion del menu a desplegar: CREAR INCIDENCIA

			 */

			$opcionMenu = "crear_incidencia";

			View::set("opcionMenu", $opcionMenu);

			

			/* combobox */

			$fallas = Clients::getFallasGenerales();

			View::set("fallas", $fallas);



			$usuarioId = $user->id;

			$empresaId = $user->empresaId;



			/* combobox: Usuarios todos */

			$usuarios = UserAdmin::getUsuariosDeEmpresa($empresaId, true);



			/*

			 * Siempre podrá crear Incidencias, porque ya hay un Usuario, el mismo Manager

			 * se puede generar SIN especificar Equipos

			 */

			View::set("puede_crear_incidencia", true);

			

			if ( $usuarios != null ){

				View::set("usuarios", $usuarios);

			} else {

				View::set("no_usuarios", "no_usuarios");

			}



			/* Equipo(s) de este Usuario (SI ES QUE TIENE) */

			$equipos = Equipos::getEquipos($usuarioId, $empresaId);



			/* Equipo(s) de la EMPRESA */

			$inventarioEquipos = Equipos::getEquiposDeEmpresaSinEsteUsuario($empresaId, $usuarioId);

			

			/*

			 * Equipos del Gerente

			 */

			if ( $equipos != null ){



				$array[][]= " "; 

				$j = 0;

				$tipo_equipo = "";



				foreach ( $equipos as $equipo ){

					/* Id unico */

					$array[$j][0] = $equipo[0];



					/* Tipo de Equipo */

					$tipo_equipo = $equipo[13];



					$ID = $equipo[10];



					$array[$j][1] = $tipo_equipo . " ( Cod. Barras: " . $ID . " ) ";



					$j++;

				}



				View::set("equipos", $array);



			} else {

				View::set("no_equipos", "no_equipos");

			}



			/*

			 * Equipos de la Empresa

			 */

			if ( $inventarioEquipos != null ){

				

				$array2[][]= " "; 

				$j = 0;

				$tipo_equipo = "";



				foreach ( $inventarioEquipos as $equipo ){

					/* Id unico */

					$array2[$j][0] = $equipo[0];



					/* Tipo de Equipo */

					$tipo_equipo = $equipo[13];



					$ID = $equipo[10];



					$array2[$j][1] = $tipo_equipo . " ( Cod. Barras: " . $ID . " ) ";

					

					$j++;

				}

				

				View::set("inventarioEquipos", $array2);



			} else {

				View::set("no_inventarioEquipos", "no_inventarioEquipos");

			}



			/*

			 * Buscar si puede crear o no una Incidencia nueva

			 */

			$flags = UserAdmin::getUsuarioEstatus( $usuarioId );



			if ( $flags == NULL ){

				View::set("Incidencias_que_faltan_por_opinar", "");



			} else {

				$faltanPorCerrar = $flags->incidenciasSinOpinar;

				

				if ( $faltanPorCerrar == NULL || $faltanPorCerrar == "" ){

					View::set("Incidencias_que_faltan_por_opinar", "");

				} else {

					View::set("Incidencias_que_faltan_por_opinar", $faltanPorCerrar);	

				}

			}

		} catch (Exception $e) {

			$internalErrorCodigo  = "Exception in controllers.Portal.form_new_incidencia_gerente()";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = $user->id;

			

			/**/

			Transaccion::insertTransaccionException("Incidencia_Crear",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra, $_SESSION['role_user'], $usuarioId);

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);

			View::set("internalErrorExtra",	 $internalErrorExtra);



			View::render("internalError");

			die;

		}

	}



	/**

	 * Viene del formulario CREAR INCIDENCIA Gerencial

	 */ 

	public static function create_incidencia_gerente(){



		session_start();



		View::set("pageTitle", $_SESSION['logged_user_saludo'] . " | Creando Incidencia ");



		/* Manager logueado */

		$user = $_SESSION['logged_user'];

		$empresaId = $user->empresaId;



		View::set("user", $user);



		if ( isset( $_POST['givenname'] ) ){

			try {

				$usuarioAfectadoId= $_POST['givenname'];

				$equipoId 	 	  = $_POST['equipos'];

				$tipoFalla 		  = $_POST['tipo_falla'];

				$observaciones    = $_POST['observaciones'];



				/* Limpiando campo textual */

				$observaciones  = stripslashes($observaciones);



				/* Limpiando seleccion: es USUARIO ó EQUIPO */

				if ( $usuarioAfectadoId == 0){

					$usuarioAfectadoId = "";



				} else if ( $equipoId == 0){

					$equipoId = "";

				}

				

				

				/* 

				 * Datos de Conexion Remota en Partner 

				 * campos: remote, userID y password

				 */

				$json = $_POST['jsonDatosConexion'];

				

				

				/* insertar Falla */

				$incidenciaId = Incidencias::insert($usuarioAfectadoId, $equipoId, $tipoFalla, $observaciones, $empresaId, $json);



				if ( $incidenciaId > 1 ){

					View::set("incidencia_generada_correctamente","inciencia generada correctamente");

					View::set("user", $user);



					/**/

					Transaccion::insertTransaccionIncidencia2("Ok", $user->id,

							$_SESSION['role_user'], $empresaId, "", $incidenciaId);



				} else {

					/**/

					$info = $equipoId." ".$tipoFalla." ".$observaciones;



					Transaccion::insertTransaccionIncidencia("Not_Ok", $user->id,

							$_SESSION['role_user'], $empresaId, $info);

				}



				/* VISTA */

				$opcionMenu = "incidencia_creada";

				View::set("opcionMenu", $opcionMenu);



				if ( $_SESSION['role_user'] == "client" ) {		View::render( "portal_client_home" );

				} else if($_SESSION['role_user'] == "manager"){	View::render( "portal_manager_home" );

				}



			} catch (Exception $e) {

				echo 'Excepción capturada: ',  $e->getMessage(), "\n";

			}



		} else {

			/**/

			Transaccion::insertTransaccionErrorFormulario("Incidencia_Crear","Portal.create_incidencia_gerente()", 

					$user->id, $_SESSION['role_user'], $empresaId, "No POST() del Formulario");

		}

	}





	/**

	 * Para mostrar formulario como el de SOLUCIONAR INCIDENCIA pero sin editar

	 */ 

	public static function ver_resolucion_incidencia(){



		session_start();



		$user = $_SESSION['logged_user'];



		View::set("user", $user);



		View::set("pageTitle", $_SESSION['logged_user_saludo'] . " | Portal Lanuza Group SAS");



		if ( isset( $_POST['resolucionIncidenciaId'] )){

			

			$solucionId = $_POST['resolucionIncidenciaId'];

			//$solucionId = 7;

			/* Resolución establecida */

			$solucion = Incidencias::getSolucion($solucionId);

			View::set("solucion", $solucion);



			/* Cambios de Hardware, si existen */

			$hardware = Incidencias::getCambiosHardware($solucionId);



			if ( $hardware == null ){

				View::set("no_hardware", "no_hardware");

			} else {

				View::set("hardware", $hardware);

			}



			/* Cambios de Software, si existen */

			$software = Incidencias::getCambiosSoftware($solucionId);



			if ( $software == null ){

				View::set("no_software", "no_software");

			} else {

				View::set("software", $software);

			}



			/*

			 * Cargar info de la INCIDENCIA

			 */

			$incidenciaId = $solucion["incidenciaId"];



			$incidencia = Incidencias::getIncidenciaInfoBasica( $incidenciaId );

			View::set("incidenciaInfo", $incidencia);



			/* Si esta establecido, ya no se puede Finalizar ni Cerrar */

			if ( isset( $_POST['no_acciones'] )){

				View::set("acciones", "no_acciones");

				View::set("volver_a_historico", "volver_a_historico");

			} else {

				View::set("acciones", "acciones");

			}



			/* VISTA */

			$opcionMenu = "ver_solucion";

			View::set("opcionMenu", $opcionMenu);



			if ( $_SESSION['role_user'] == "client" ) {		View::render( "portal_client_home" );

			} else if($_SESSION['role_user'] == "manager"){	View::render( "portal_manager_home" );

			}

		}

	}





	/**

	 * Para CERTIFICAR una INCIDENCIA

	 */ 

	public static function certificar_incidencia(){

		

		session_start();



		$user = $_SESSION['logged_user'];



		View::set("user", $user);



		if ( isset( $_POST['certificar_incidenciaId_Form'] )){



			$incidenciaID = $_POST['certificar_incidenciaId_Form'];

			$solucionID   = $_POST['certificar_solucionId_Form'];



			/* MARCAR CON STATUS 'Certificada' */

			$listo = Incidencias::certificarIncidencia($incidenciaID, $solucionID);



			if ( $listo == true ){

				/* Mostrar MODAL para dar Opinion */

				View::set("certificar_opinar_incidenciaID", $incidenciaID);

				View::set("certificar_opinar_solucionID",   $solucionID);



				/**/

				Transaccion::insertTransaccionIncidenciaHistorial("Incidencia_Usuario_Certificar", "Ok", $user, $incidenciaID, 0, "solucionId:".$solucionID);



				/* JSON */

				$objConJson = Incidencias::buscarIncidenciasSinOpinar( $incidenciaID );

				View::set("objJsonIncidenciasSinOpinar", $objConJson);



			} else {

				$comentario="Hubo un error al Certificar la Incidencia #" . $incidenciaID . ". Por Favor, intente más tarde.";

				View::set("certificar_opinar_incidenciaID", 0);

				View::set("certificar_opinar_ERROR", $comentario);



				/**/

				Transaccion::insertTransaccionIncidenciaHistorial("Incidencia_Usuario_Certificar", "Not_Ok", $user, $incidenciaID, 0, $comentario);

			}



			

			/* VISTA */

			if ( $_SESSION['role_user'] == "client" ) {		Portal::ver_incidencias();

			} else if($_SESSION['role_user'] == "manager"){	Portal::ver_todas_incidencias();

			}



		} else {

			/**/

			Transaccion::insertTransaccionErrorFormulario("Incidencia_Usuario_Certificar","Portal.certificar_incidencia()", 

					$user->id, $_SESSION['role_user'], 0, "No POST() del Formulario");

		}



	}





	/**

	 * Para salvar el formulario MODAL de la opinon de una SOLUCION de una INCIDENCIA

	 */ 

	public static function registrar_opinion(){



		session_start();



		$user = $_SESSION['logged_user'];



		View::set("user", $user);



		if ( isset( $_POST['incidenciaId_Form'] )){



			$incidenciaId     = $_POST['incidenciaId_Form'];

			$solucionId       = $_POST['solucionId_Form'];



			$se_resolvio      = $_POST['se_pudo_resolver_Form'];

			$positiva_negativa= 0;/*pregunta eliminada: $_POST['positiva_negativa_Form']; */



			$barra_1 = $_POST['barra_1_Form'];

			$barra_2 = $_POST['barra_2_Form'];

			$barra_3 = $_POST['barra_3_Form'];

			$barra_4 = $_POST['barra_4_Form'];



			$comentarios = stripslashes( $_POST['opinion_comentarios'] );



			$listo = Incidencias::salvarOpinion($incidenciaId, $solucionId, 

					$se_resolvio, $positiva_negativa, $barra_1, $barra_2, $barra_3, $barra_4, $comentarios);

			

			/* echo $se_resolvio . "**" . $positiva_negativa . "--" .$ ; */

			

			/**/

			if ( $listo == true ){

				Transaccion::insertTransaccionIncidenciaHistorial("Incidencia_Usuario_Opinar", "Ok", $user, $incidenciaId, 0, "solucionId:".$solucionId);



				$userEstatusId = $_POST['json_userId'];

				$json = $_POST['json_incidencias'];



				/*

				 * Una vez que se opine sobre la INCIDENCIA, se debe eliminar de las Pendientes por Opinar

				 */

				if ( $_SESSION['role_user'] == "client" ) {



					/* usando SEPARATOR

					 * Incidencias::incidenciaOpinada($user->id, $incidenciaId);

					 */



					/* Ahora con JSON, solo hay que actualizar el string JSON en la BD */

					Incidencias::incidenciaOpinada2($userEstatusId, $json);





				} else if($_SESSION['role_user'] == "manager"){

					/*

					 * Como es el Partner, se debe buscar la COMPAÑÌA_ID

					 * con ese valor se debe buscar entre TODOS los EMPLEADOS registrados de esa compañía

					 * alguno que tenga ESA incidenciaId por Certificar y CERRARLA

					 *

					 * (esto es porque el Partner puede crear Incidencia a cualquiera en su Empresa) 

					 */

					

					/* usando SEPARATOR

					 * Incidencias::incidenciaOpinadaPartner($_SESSION['logged_user_empresaId'], $incidenciaId);

					 */



					/* Ahora con JSON

					 * solo hay que actualizar el string JSON en la BD porque trae su UsuarioEstatus.Id de la vista

					 */

					Incidencias::incidenciaOpinada2($userEstatusId, $json);

				}



			} else {

				Transaccion::insertTransaccionIncidenciaHistorial("Incidencia_Usuario_Opinar", "Not_Ok", $user, $incidenciaId, 0, "solucionId:".$solucionId);

			}

		

		} else {

			/**/

			Transaccion::insertTransaccionErrorFormulario("Incidencia_Usuario_Opinar","Portal.registrar_opinion()", 

					$user->id, $_SESSION['role_user'], 0, "No POST() del Formulario");

		}

	}





	/**

	 * El Usuario puede Responder al Técnico cuando éste ha marcado la Incidencia "En Espera"

	 */ 

	public static function reply_al_tecnico(){



		session_start();



		$user = $_SESSION['logged_user'];



		$empresaId = $user->empresaId;



		View::set("user", $user);



		if ( isset( $_POST['user_reply'] )){



			$incidenciaId = $_POST['incidenciaId_ReplyForm'];

			$comentario   = stripslashes( $_POST['user_reply'] );



			/* Poner status "En Progreso" y salvar la info del Usuario */

			Incidencias::replyTech($incidenciaId, $comentario);

			

			/**/

			Transaccion::insertTransaccionIncidenciaHistorial("Incidencia_Usuario_Reply", "Ok", $user, $incidenciaId, $empresaId, $comentario);



			/* 

			 * En este caso se Notifica al TECNICO (y a LanuzaGroup)

			 */

			EmailManagement::sendIncidenciaReply( $incidenciaId, $user, $comentario );



			/*echo $se_resolvio; /*. "**" . $positiva_negativa . "--" .$ ; */



			if ( $_SESSION['role_user'] == "client" ) {		Portal::startClient( $user );

			} else if($_SESSION['role_user'] == "manager"){	Portal::startManager( $user );

			}



		} else {

			/**/

			Transaccion::insertTransaccionErrorFormulario("Incidencia_Usuario_Reply","Portal.reply_al_tecnico()", 

					$user->id, $_SESSION['role_user'], $empresaId, "No POST() del Formulario");

		}

	}





	/**

	 * Imprimir en PDF -> primero se optimizará la página

	 */ 

	public static function imprimir_solucion_incidencia(){



		session_start();



		$user = $_SESSION['logged_user'];



		View::set("user", $user);



		if ( isset( $_POST['incidenciaId_print'] )){



			$incidenciaId = $_POST['incidenciaId_print'];

			View::set("incidenciaId", $incidenciaId);



			$solucionId   = $_POST['solucionId_print'];



			/* Resolución establecida */

			$solucion = Incidencias::getSolucion($solucionId);

			View::set("solucion", $solucion);



			/* Cambios de Hardware, si existen */

			$hardware = Incidencias::getCambiosHardware($solucionId);



			if ( $hardware == null ){

				View::set("no_hardware", "no_hardware");

			} else {

				View::set("hardware", $hardware);

			}



			/* Cambios de Software, si existen */

			$software = Incidencias::getCambiosSoftware($solucionId);



			if ( $software == null ){

				View::set("no_software", "no_software");

			} else {

				View::set("software", $software);

			}



			/*

			 * Cargar info de la INCIDENCIA

			 */

			$incidenciaId = $solucion["incidenciaId"];

			

			$incidencia = Incidencias::getIncidenciaInfoBasica( $incidenciaId );

			View::set("incidenciaInfo", $incidencia);



			/* Portal para regresar a PAGINA PRINCIPAL */

			if ( $_SESSION['role_user'] == "client" ) {		

				View::set("tipo_portal", "portal/ver_incidencias");



			} else if($_SESSION['role_user'] == "manager"){	

				View::set("tipo_portal", "portal/ver_todas_incidencias");

			}



			/* Pagina optimizada para IMPRIMIR: INCIDENCIAS */

			View::render( "imprimir_solucion_incidencia" );



		}

	}





	/**

	 * Calendario para ambos: solo MANAGER puede CREAR, ACEPTAR, ELIMINAR, etc.

	 */

	public static function calendario() {



		session_start();



		$user = $_SESSION['logged_user'];



		View::set("user", $user);



		try {

			$opcionMenu = "calendario";

			View::set("opcionMenu", $opcionMenu);



			View::set("pageTitle", "Calendario");



			/*

			 * Buscar la fecha actual y los soportes del mes en curso

			 */

			$year  = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);

			$month = filter_input(INPUT_GET, 'month', FILTER_VALIDATE_INT);

			if ( $year != "" && $month != "" ){

				/* fechas que vienen por metodo _GET */



			} else {

				/* NO viene data por el $_GET; es decir es el mes actual */

				$year  = date("Y");

				$month = date("m");

			}



			if ( $month == 12 ){

				/* Enero del Año siguiente */

				$yearHasta = $year + 1;

				$mesHasta  = 1;



			} else {

				/* Calcular el siguiente mes */

				$yearHasta = $year;

				$mesHasta  = $month + 1;

			}



			/* Citas para este mes */

			$citas = Soportes::getSoportesProgramadosDeEmpresa($year, $month, $yearHasta, $mesHasta, $_SESSION['logged_user_empresaId'] );



			View::set("citas", $citas);



			View::set("pageTitle", "Calendario de Soportes Programados");



			if ( $_SESSION['role_user'] == "client" ) {		View::render( "portal_client_home" );



			} else if($_SESSION['role_user'] == "manager"){



				/* Empresa actual */

				$empresa = $_SESSION['logged_user_empresa'];

				View::set("company", $empresa);



				View::render( "portal_manager_home" );

			}



		} catch (Exception $e) {

			$internalErrorCodigo  = "Exception in controllers.Portal.calendario()";

			$internalErrorMessage = $e -> getMessage();

			$internalErrorExtra   = "tratando de llamar Soportes::getSoportesProgramadosDeEmpresa($year, $month, $yearHasta, $mesHasta )";

			

			/**/

			Transaccion::insertTransaccionException("Soporte_crear",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra, $_SESSION['role_user'], $user->id);

			

			View::set("internalErrorCodigo", $internalErrorCodigo);

			View::set("internalErrorMessage",$internalErrorMessage);

			View::set("internalErrorExtra",	 $internalErrorExtra);



			View::render("internalError");

			die;

		}

	}





	/**

	 * opcion PERFIL

	 */

	public static function profile() {



		session_start();



		$user = $_SESSION['logged_user'];



		View::set("user", $user);





		/* Usuario: toda su info */

		$profile = UserAdmin::getProfile( $user->id );

		View::set("profile", $profile);





		$partners = UserAdmin::getManagersDeEmpresa($user->empresaId);

		View::set("partners", $partners);





		$equipos = Equipos::getEquiposYTipo( $user->id, $user->empresaId);

		View::set("equipos", $equipos);





		/* VISTA */

		$opcionMenu = "info_perfil";

		View::set("opcionMenu", $opcionMenu);



		$titulo = $_SESSION['logged_user_saludo'];

		View::set("pageTitle", $titulo . "| Perfil");





		if ( $_SESSION['role_user'] == "client" ) {		View::render( "portal_client_home" );

		} else if($_SESSION['role_user'] == "manager"){	View::render( "portal_manager_home" );

		}



	}



	/**

	 * Funcion de Creacion de Soporte programado: desde el TECNICO

	 */

	public static function ajax_soportes_table(){



		session_start();



		$tech = $_SESSION['logged_user'];



		View::set("user", $tech);



		try {

			if ( isset( $_POST['ajax_year'] ) ) {



				$y = $_POST['ajax_year'];

				$m = $_POST['ajax_mes'];

				$d = $_POST['ajax_dia'];



				$mes = Utils::getMonthNumber($m);



				$citas = Soportes::getSoportesDelDiaDeEmpresa( $y, $mes, $d, $_SESSION['logged_user_empresaId'] );



				$a2="";$a3="";$a4="";$a5="";$a6="";$a7="";$a8="";$a9="";$a10="";$a11="";



				foreach ($citas as $cita) {



					$a2 = $cita["hora_estimada"];

					$a3 = $cita["am_pm"];

					$a4 = $cita["trabajoArealizar"];

					$a5 = $cita["inventario_info"];

					$a6 = $cita["Comentarios"];

					$a7 = $cita["otraDireccion"];

					$a8 = ucfirst( $cita["aceptada"] );

					$a9 = $cita["nombreTech"];

					$a10= $cita["apellidoTech"];

					$a11= $cita["soporteProgId"];



					if ( $a2 == NULL || $a2 == "" )	$a2 = "nulo";

					if ( $a3 == NULL || $a3 == "" )	$a3 = "nulo";

					if ( $a4 == NULL || $a4 == "" )	$a4 = "nulo";

					if ( $a5 == NULL || $a5 == "" )	$a5 = " ";

					if ( $a6 == NULL || $a6 == "" )	$a6 = "N/A";

					if ( $a7 == NULL || $a7 == "" )	$a7 = "N/A";

					if ( $a8 == NULL || $a8 == "" )	$a8 = "No";

					if ( $a9 == NULL || $a9 == "" )	$a9 = "[No";

					if ( $a10== NULL || $a10== "" )	$a10= "asignado]";

					

					echo $a2 . " ". $a3

						. "|" . $a4

						. "|" . $a5

						. "|" . $a6

						. "|" . $a7

						. "|" . $a8

						. "|" . $a9 . " " . $a10 

						. "|" . $a11

						. "|";



				}

			}



		} catch (Exception $e) {

			echo "ERROR #004|Portal.php|ajax_soportes_table()|".$e -> getMessage()."|Notificar a Soporte|de Lanuza Group|ERROR #004|ErrorPHP";

		}

	}



	

	/**

	 * Funcion de Creacion de Soporte programado: desde el MANAGER

	 */

	public static function crear_soporte(){



		session_start();



		$user = $_SESSION['logged_user'];



		View::set("user", $user);



		if ( isset( $_POST['soporte_dia'] ) ) {



			$amPM 		= $_POST['am_pm'];

			$hora 		= $_POST['hora'];



			$trabajoArealizar = stripslashes( $_POST['trabajoArealizar'] );



			$year= $_POST['soporte_year'];

			$mes = $_POST['soporte_mes'];

			$dia = $_POST['soporte_dia'];



			$nuevaDireccion = (isset($_POST['direccion_check']) && $_POST['direccion_check'] )

				? true : false;



			$otraDireccion = "";

			if ( $nuevaDireccion ) {

				$otraDireccion = stripslashes( $_POST['otra_sucursal'] );

			} else {

				$otraDireccion = "";

			}



			/* Crear fecha con parametros dados */

			$fechaCita = NULL;

			try {

				$fechaCita = Utils::crearFecha($year, $mes, $dia, $hora, $amPM);



			} catch (Exception $e) {

				$internalErrorCodigo  = "Exception in controllers.Portal.crear_soporte()";

				$internalErrorMessage = $e -> getMessage();

				$internalErrorExtra   = "Tratando de ejecutar Utils::crearFecha($year, $mes, $dia, $hora, $amPM);";

				

				/**/

				Transaccion::insertTransaccionException("Soporte_crear",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra, $_SESSION['role_user'], $tech->id);

				

				View::set("internalErrorCodigo", $internalErrorCodigo);

				View::set("internalErrorMessage",$internalErrorMessage);

				View::set("internalErrorExtra",	 $internalErrorExtra);



				View::render("internalError");

				die;

			}



			$userId = $user->id;

			$empresaId = $_SESSION['logged_user_empresaId'];



			/* Insertar Cita */

			$count = Soportes::insert($userId, $empresaId, $fechaCita, $dia, $hora, $amPM, 

					$trabajoArealizar, $otraDireccion, "manager", "no", "", "" );



			if ( $count == 1 ){

				/**/

				EmailManagement::nuevoSoporte($empresaId, $user, $fechaCita, $hora, $amPM, $trabajoArealizar, $otraDireccion);



				/**/

				$info = "manager-$dia, $hora, $amPM, $trabajoArealizar, $otraDireccion";

				Transaccion::insertTransaccionSoporteHistorial("Soporte_crear", "Ok", "manager", $userId, $empresaId, $info);



			} else {

				$info = "manager-$dia, $hora, $amPM, $trabajoArealizar, $otraDireccion, count_NOT_1: $count";

				Transaccion::insertTransaccionSoporteHistorial("Soporte_crear", "Not_Ok", "manager", $userId, $empresaId, $info);

			}

		}

	}





	/**

	 * actualizaciones VARIAS

	 */

	public static function actualizar_soporte_cita(){



		session_start();



		$user = $_SESSION['logged_user'];



		View::set("user", $user);



		if ( isset( $_POST['accion'] ) ) {



			$accion = $_POST['accion'];



			if ( $accion == "cambiar_hora" ){

				/*

				 * cambiar hora

				 */

				$soporteId  = $_POST['cita_id'];

				$hora 		= $_POST['cita_hora'];

				$am_pm 		= $_POST['cita_pm'];



				$count = Soportes::cambiarHora($soporteId, $hora, $am_pm );



				if ( $count == 1 ){

					/**/

					EmailManagement::notificarSoporteTech($soporteId, $accion);



					$info = "$hora, $am_pm";

					Transaccion::insertTransaccionSoporteHistorial("Soporte_reprogramar", "Ok", "manager", $user->id, $soporteId, $info);



				} else {

					$info = "$hora, $am_pm, count_NOT_1: $count";

					Transaccion::insertTransaccionSoporteHistorial("Soporte_reprogramar", "Not_Ok", "manager", $user->id, $soporteId, $info);

				}



			} else if ( $accion == "aceptar_cita" ){

				/*

				 * aceptar cita de soporte

				 */

				$soporteId  = $_POST['cita_id'];

				$userId = $user->id;



				$count = Soportes::aceptarCita($soporteId, $userId, "manager");



				if ( $count == 1 ){

					/**/

					EmailManagement::notificarSoporteTech($soporteId, $accion);



					$info = "";

					Transaccion::insertTransaccionSoporteHistorial("Soporte_reprogramar", "Ok", "manager", $user->id, $soporteId, $info);



				} else {

					$info = "$soporteId, $userId, count_NOT_1: $count";

					Transaccion::insertTransaccionSoporteHistorial("Soporte_reprogramar", "Not_Ok", "manager", $user->id, $soporteId, $info);

				}

			} else if ( $accion == "Eliminada" ){

				/*

				 * ELIMINAR cita de soporte

				 */

				$soporteId  = $_POST['cita_id'];

				$userId = $user->id;



				$count = Soportes::eliminarCita($soporteId, $userId, "manager");



				if ( $count == 1 ){

					/**/

					EmailManagement::notificarSoporteTech($soporteId, $accion);



					$info = "";

					Transaccion::insertTransaccionSoporteHistorial("Soporte_eliminar", "Ok", "manager", $user->id, $soporteId, $info);



				} else {

					$info = "$soporteId, $userId, count_NOT_1: $count";

					Transaccion::insertTransaccionSoporteHistorial("Soporte_eliminar", "Not_Ok", "manager", $user->id, $soporteId, $info);

				}

			}

		}

	}





	/**

	 * mostrar Formulario

	 */

	public static function update_profile(){



		session_start();



		$user = $_SESSION['logged_user'];



		View::set("user", $user);



		View::set("pageTitle", $_SESSION['logged_user_saludo'] . " | Actualizar Perfil ");

		

		/* VISTA */

		$opcionMenu = "actualizar_perfil";

		View::set("opcionMenu", $opcionMenu);



		if ( $_SESSION['role_user'] == "client" ) {		

			View::render( "portal_client_home" );



		} else if($_SESSION['role_user'] == "manager"){	



			/* Datos de Empresa */

			$empresa = Company::getEmpresaById( $user->empresaId );

			View::set("empresa", $empresa);



			View::render( "portal_manager_home" );

		}

	}



	/**

	 * actualizaciones VARIAS: Cuenta, email, password y datos personales

	 */

	public static function actualizar_info_form(){



		session_start();



		$user   = $_SESSION['logged_user'];

		$userId = $user->id;



		View::set("user", $user);



		$updated_info="";

		$passwordCambiado = false;



		/* Actualizar USUARIO */

		if ( isset( $_POST['dependencia'] ) ){



			/* To protect MySQL injection for Security purpose */

			$greetings     = stripslashes( $_POST['greetings'] );
			$givenname     = stripslashes( $_POST['givenname'] );
			$lastname      = stripslashes( $_POST['lastname'] );
			$gender        = stripslashes( $_POST['gender'] );
			$email         = stripslashes( $_POST['email'] );
			$dependencia   = stripslashes( $_POST['dependencia'] ) ;
			$cellphone_code= stripslashes( $_POST['cellphone_code'] );
			$phone_cell    = stripslashes( $_POST['phone_cell'] ) ;
			$phone_home    = stripslashes( $_POST['phone_home'] ) ;
			$phone_work    = stripslashes( $_POST['phone_work'] ) ;
			$phone_work_ext= stripslashes( $_POST['phone_work_ext'] ) ;

			/* Cumpleaños */
			$dia = stripslashes( $_POST['birth_day'] );
			if ( $dia == "none" ){
				$dia = 1;
			}

			$mes = stripslashes( $_POST['birth_mes'] );
			if ( $mes == "none" ){
				$mes = 1;
			}

			$year = stripslashes( $_POST['birth_year'] );
			if ( $year == "none" ){
				$year = 1912;
			}
      //echo "debugger.php.1:".$dia . "--".$mes."--".$year;
			
      $fechaCumple = Utils::crearFecha($year, $mes, $dia, 12, "AM");
      // echo "debugger.php.2".$fechaCumple;

			/*
			 * Primera Letra Mayúscula 
	 		 * las demas en minúsculas
			 */

			$givenname = ucfirst( strtolower( $givenname ));
			$lastname  = ucfirst( strtolower( $lastname ));

			/* Actualizar solo el USUARIO */
			$count = UserAdmin::update($userId, $greetings, $givenname, $lastname, $gender,
					$email, $dependencia, 
					$cellphone_code, $phone_cell, $phone_home, $phone_work, $phone_work_ext,
					$fechaCumple);

			$tipoTransaccion = "Usuario_Actualizar";

			if ( $count == 0 ){

				$updated_info=" - Información NO Actualizada: Email debe ser único y el correo " . $email . " ya se encuentra registrado para otro Usuario";



			} else if ( $count == 1 ){

				$info = "";

				Transaccion::insertTransaccion($tipoTransaccion, "Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'], $info );

				$updated_info=" - Información Actualizada satisfactoriamente.";

			} else {

				$info = "empresa:".$_SESSION['logged_user_empresaId'].", user:$userId, count_NOT_1: $count";

				Transaccion::insertTransaccion($tipoTransaccion, "Not_Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'], $info );

			}

		}



		/* Actualizar PASSWORD */
		if ( isset( $_POST['pwdActual'] ) ){

			$pwdActual     = stripslashes($_POST['pwdActual']);

			$pwd           = stripslashes($_POST['pwd']);

			$pwdrepited    = stripslashes($_POST['pwdrepited']);



			if ( $pwdActual == "" ){

				/* no actualizar */

				$updated_info .= "<br/><br/> - Contraseña NO cambiada.";

			} else if ( $pwd =! "" && $pwd != $pwdrepited ){

				$updated_info .= "<br/><br/> - Contraseña NO Actualizada: La clave Nueva y la Confirmación NO coinciden.";



			} else {

				$userPwd = UserAdmin::getUser($user->usuario, $pwdActual, "activo");



				if( isset($userPwd->usuario) ) {

          // La encriptación ocurre dentro de este método
					$count = UserAdmin::updatePassword($userPwd->usuario, $pwdActual, $pwdrepited);

					$tipoTransaccion = "Usuario_Actualizar";

					if ( $count == 1 ){

						$info = "CONTRASEÑA_ACTUALIZADA";

						Transaccion::insertTransaccion($tipoTransaccion, "Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info);



						$updated_info .= "<br/><br/> - Contraseña NUEVA establecida.";



						$passwordCambiado = true;



					} else {

						$info = "empresa:".$_SESSION['logged_user_empresaId'].", user:$userId, count_NOT_1: $count - CONTRASEÑA_NO_ACTUALIZADA";

						Transaccion::insertTransaccion($tipoTransaccion, "Not_Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info);

					}



				} else {

					$updated_info .= "<br/><br/> - Contraseña NO Actualizada. Contraseña actual incorrecta.";

				}

			}

		}



		View::set("updated_info", $updated_info);



		try {

			/*

			 * Tomando el USUARIO logueado; buscandolo por Credenciales 

			 *  y poniendo en SESION los valores del Usuario recien actualizado

			 */

			$username = $user->usuario;

			$userType = $user->activo;



			$password = "";

			if ( $passwordCambiado == false ){

				$password = $user->password;
        $user = UserAdmin::getUser2($username, $password, $userType);

			} else {
				$password = $pwdrepited;
        $user = UserAdmin::getUser($username, $password, $userType);
			}

			/* limpiando */
			unset( $_SESSION['logged_user'] );

			/* poniendolo de nuevo */
			$_SESSION['logged_user'] = $user;

			View::set("user", $user);

			View::set("pageTitle", $_SESSION['logged_user_saludo'] . " | Actualizar Perfil ");

			$empresa = Company::getEmpresaById( $user->empresaId );

			View::set("empresa", $empresa);

			/* VISTA */
			$opcionMenu = "actualizar_perfil";

			View::set("opcionMenu", $opcionMenu);

			if ( $_SESSION['role_user'] == "client" ) {		View::render( "portal_client_home" );
			} else if($_SESSION['role_user'] == "manager"){	View::render( "portal_manager_home" );
			}

		} catch (Exception $e) {
			$internalErrorCodigo  = "Exception in controllers.Portal.actualizar_info_form()";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "tratando de llamar UserAdmin::getUser($username, $password, $userType)";

			/**/
			Transaccion::insertTransaccionException("Usuario_Actualizar",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra, $_SESSION['role_user'], $user->id);
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}

	}





	/**

	 * actualizacion de solo la Empresa

	 */

	public static function update_company(){



		session_start();



		$user   = $_SESSION['logged_user'];

		$userId = $user->id;



		View::set("user", $user);



		if ( $_SESSION['role_user'] == "manager" && isset( $_POST['company_pbx'] ) ){



			$company        = stripslashes( $_POST['company'] );

			$company_razon  = stripslashes( $_POST['company_razon'] );

			$company_nit    = stripslashes( $_POST['company_nit'] );

			$company_pais   = stripslashes( $_POST['company_pais'] );

			$company_estado = stripslashes( $_POST['company_estados'] );

			$company_city   = stripslashes( $_POST['company_city'] );

			$company_direcc = stripslashes( $_POST['company_direccion'] );

			$company_web    = stripslashes( $_POST['company_web'] );

			$company_pbx    = stripslashes( $_POST['company_pbx'] );

			$company_email  = stripslashes( $_POST['company_email'] );



			$empresaId = $_SESSION['logged_user_empresaId'];



			$count = Company::update($empresaId, $company, $company_razon, $company_nit, 

					$company_pais, $company_estado, $company_city, $company_direcc,

					$company_web, $company_pbx, $company_email);



			$tipoTransaccion = "Usuario_Actualizar";

			if ( $count == 1 ){

				$info = "EMPRESA_ACTUALIZADA";

				Transaccion::insertTransaccion($tipoTransaccion, "Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info);



				$updated_info = "Datos de la Empresa actualizados.";



			} else {

				$info = "$empresaId, $company, $company_razon, $company_nit, $company_pais, $company_estado, $company_city, $company_direcc, $company_web, $company_pbx, $company_email, count_NOT_1: $count - EMPRESA_NO_ACTUALIZADA";

				Transaccion::insertTransaccion($tipoTransaccion, "Not_Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );

			}

			

			View::set("updated_info", $updated_info);



			$empresa = Company::getEmpresaById( $empresaId );

			View::set("empresa", $empresa);



			/* VISTA */

			$opcionMenu = "actualizar_perfil";

			View::set("opcionMenu", $opcionMenu);



			View::set("pageTitle", $_SESSION['logged_user_saludo'] . " | Perfil  Actualizado");



			View::render( "portal_manager_home" );

		}

	}



	

	/**

	 * Mostrar pantalla donde se vera los inventarios de Equipo(s), CLIENT ö MANAGER

	 */

	public static function mis_equipos(){



		session_start();



		View::set("pageTitle", $_SESSION['logged_user_saludo'] . " | Sus Equipos ");



		$user      = $_SESSION['logged_user'];

		$empresaId = $_SESSION['logged_user_empresaId'];

		$roleUser  = $_SESSION['role_user'];



		$usuarioId = $user->id;



		View::set("user", $user);



		$misEquipos = Equipos::getEquipos($usuarioId, $empresaId);



		if ( $misEquipos != NULL && $misEquipos != "" ){

			View::set("misEquipos", $misEquipos);

		} else {

			View::set("no_misEquipos", "no_misEquipos");

		}



		if ( $roleUser == "manager" ){



			/* Equipo(s) de la EMPRESA */

			$equiposDeEmpresa = Equipos::getEquiposDeEmpresaSinEsteUsuario($empresaId, $usuarioId);

			View::set("equipos", $equiposDeEmpresa);



		} else {

			View::set("no_equipos", "no_equipos");

		}



		/* VISTA */

		$opcionMenu = "inventario";

		View::set("opcionMenu", $opcionMenu);



		if ( $_SESSION['role_user'] == "client" ) {		View::render( "portal_client_home" );

		} else if($_SESSION['role_user'] == "manager"){	View::render( "portal_manager_home" );

		}

	}





	/**

	 * Mostrar info que se tiene de UN EQUIPO

	 */

	public static function ver_inventario_equipo(){



		session_start();



		View::set("pageTitle", "Inventario: detalle de Equipo");



		$user = $_SESSION['logged_user'];



		View::set("user", $user);



		if ( isset( $_POST['equipoInfoId'] ) ){



			/**/

			$equipoId = $_POST['equipoID'];

			$generalInfo = Equipos::getById($equipoId);

			View::set("generalInfo", $generalInfo);



			/**/

			$tipoEquipo   = $_POST['tipoEquipo'];

			View::set("tipoEquipo", $tipoEquipo);



			$codigoBarras = $_POST['codigoBarras'];

			View::set("codigoBarras", $codigoBarras);



			$equipoInfoId = $_POST['equipoInfoId'];

			

			$linkImagen = $_POST['linkImagen'];

			View::set("linkedImagen", $linkImagen);



			/**/

			$arreglos = InventarioScripts::equipoInfoInventario( $equipoInfoId );



			$error = $arreglos["errorMessage"];

			if ( $error != "" ){

				View::set("errorMessage", $error);

			} else {

				View::set("no_errorMessage", "no_errorMessage");

			}



			/**/

			$os = $arreglos["os"];

			View::set("os", $os);



			/**/

			$cpu = $arreglos["cpu"];

			View::set("cpu", $cpu);



			/**/

			$motherboard = $arreglos["motherboard"];

			View::set("motherboard", $motherboard);



			/**/

			$ram = $arreglos["ram"];

			View::set("ram", $ram);



			/**/

			$users = $arreglos["users"];

			View::set("users", $users);



			/**/

			$hardDrives = $arreglos["hardDrives"];

			View::set("hardDrives", $hardDrives);



			/**/

			$video = $arreglos["video"];

			View::set("video", $video);



			/**/

			$sound = $arreglos["sound"];

			View::set("sound", $sound);



			/**/

			$networking = $arreglos["networking"];

			View::set("networking", $networking);



			/**/

			$smart = $arreglos["smart"];

			View::set("smart", $smart);



		}



		/* VISTA */

		$opcionMenu = "inventario_equipo";

		View::set("opcionMenu", $opcionMenu);



		if ( $_SESSION['role_user'] == "client" ) {		View::render( "portal_client_home" );

		} else if($_SESSION['role_user'] == "manager"){	View::render( "portal_manager_home" );

		}

	}





	/**

	 * Obtiene la primera página de las Incidencias cerradas

	 */

	public static function historico_incidencias(){



		session_start();



		$user      = $_SESSION['logged_user'];

		$empresaId = $_SESSION['logged_user_empresaId'];

		

		View::set("user", $user );



		View::set("pageTitle", "Incidencias ya Cerradas (Finalizadas/Resueltas)");



		/*

		 * SQL LIMIT limitando resultados para PAGINATION

		 * $page debe INICIAR en 1

		 */

		$page = 1;

		$limit = 100;



		/* Incidencias de este tecnico */

		$incidenciasFinalizadas = Incidencias::getIncidenciasCerradasDeEmpresa( $empresaId, $page, $limit );



		if ( $incidenciasFinalizadas != NULL && $incidenciasFinalizadas != "" ){

			View::set("incidenciasFinalizadas", $incidenciasFinalizadas );

		} else {

			View::set("no_incidenciasFinalizadas", "no_incidenciasFinalizadas" );

		}



		/* VISTA */

		$opcionMenu = "historico_incidencias";

		View::set("opcionMenu", $opcionMenu);



		View::render( "portal_manager_home" );

	}



	/**

	 * Una vez Buscado el USUARIO y seleccionado los archivos; proceder a leerlos

	 */

	public static function listado_soportes(){



		session_start();



		$user      = $_SESSION['logged_user'];

		$empresaId = $_SESSION['logged_user_empresaId'];

		

		View::set("user", $user );



		View::set("pageTitle", "Soportes IT - Listado");



		$futuros = Soportes::getCitasPendientes($empresaId);

		

		if ( $futuros != null && $futuros != "" ){

			View::set("citasPendientes", $futuros );

		} else {

			View::set("no_citasPendientes", "no_citasPendientes" );

		}



		$pasadas = Soportes::getCitasPreviasAnyoActual($empresaId);

		

		if ( $pasadas != null && $pasadas != "" ){

			View::set("citasPasadas", $pasadas );

		} else {

			View::set("no_citasPasadas", "no_citasPasadas" );

		}

		

		/* VISTA */

		$opcionMenu = "agenda_listado";

		View::set("opcionMenu", $opcionMenu);



		if ( $_SESSION['role_user'] == "client" ) {		View::render( "portal_client_home" );

		} else if($_SESSION['role_user'] == "manager"){	View::render( "portal_manager_home" );

		}

	}





	/**

	 * SOLO al Client: mirar su histórico

	 */

	public static function ver_historico_cliente(){



		session_start();



		$user = $_SESSION['logged_user'];

		

		View::set("user", $user );



		View::set("pageTitle", "Soportes IT - Listado");



		$userId = $user->id;



		$historico_incidencias = Incidencias::getHistoricoIncidencias($userId);

		View::set("incidencias", $historico_incidencias);

		



		if ( $historico_incidencias == NULL || $historico_incidencias == "" ){

			View::set("no_incidencias", "no_incidencias");

		}





		/* VISTA */

		$opcionMenu = "listado_historico";

		View::set("opcionMenu", $opcionMenu);



		View::render( "portal_client_home" );

	}







	/**

	 * Buscar el Historial de las cosas hechas a Equipos

	 */

	public static function historialEquipoCliente(){



		session_start();



		$user = $_SESSION['logged_user'];



		View::set("user", $user );



		View::set("pageTitle", "Trabajos realizados sobre sus Equipos");



		$empresaId = $_SESSION['logged_user_empresaId'];

		$usuarioId = $user->id;



		$misEquipos = Equipos::getEquipos($usuarioId, $empresaId);



		if ( $misEquipos == NULL || $misEquipos == "" ){

			View::set("no_equipos", "no_equipos");



		} else {



			$resultado = Equipos::getHistorialEquipos($misEquipos);



			View::set("cantidad_equipos", $resultado[0]);

			View::set("equipos_info", 	  $resultado[1]);

		}



		

		/* VISTA */

		$opcionMenu = "historial_equipos";

		View::set("opcionMenu", $opcionMenu);



		View::render( "portal_client_home" );

		

	}



}