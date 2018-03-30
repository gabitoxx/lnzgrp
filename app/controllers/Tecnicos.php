<?php
namespace app\controllers;
defined("APPPATH") OR die("Access denied");

use \core\View,
	\app\models\admin\Company as Company,
	\app\models\admin\user as UserAdmin,
	\app\models\Incidencias,
	\app\models\admin\Transaccion,
	\app\models\Soportes,
	\app\models\Utils,
	\app\models\Equipos,
	\app\models\InventarioScripts,
	\app\models\Empresas,
	\app\models\EmailManagement,
	\app\models\Clients;

class Tecnicos { 
	
	public static function index() {
		Tecnicos::home();
	}

	public static function home() {

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user);
	
		Tecnicos::startTech( $user );
	}

	/**
	 * Para mostrar los USUARIOS de una EMPRESA
	 */
	public static function ver_incidencias(){

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user);

		Tecnicos::startTech( $user );

	}

	/**
	 * Iniciando Vista Tecnicos
	 * - Mostrar las incidencias que tiene asignado este técnico
	 * - Mostrar el resto de incidencias ABIERTAS
	 */
	public static function startTech( $user ){

		$titulo = $user->saludo . " " . $user->nombre . " " . $user->apellido;
		
		View::set("pageTitle", $titulo . " | Portal Técnicos | Lanuza Group SAS");

		/* Incidencias de este tecnico */
		$incidencias = Incidencias::getIncidenciasDeTecnico($user->id);

		if ( $incidencias != null ){
			View::set("misIncidencias", $incidencias);
		} else {
			View::set("no_mis_incidencias", "no hay incidencias de este tecnico");
		}
			
		/* Incidencias ABIERTAS de otros técnicos */
		$incidenciasAbiertas = Incidencias::getIncidenciasAbiertasSinEsteTecnico($user->id);
		
		if ( $incidenciasAbiertas != null ){
			View::set("incidenciasPendientes", $incidenciasAbiertas);
		} else {
			View::set("no_incidencias_pendientes", "no hay incidencias pendientes");
		}

		/**
		 * Opcion del menu a desplegar: VER INCIDENCIAS Pendientes
		 */
		$opcionMenu = "ver_incidencias";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_tech_home" );
	}


	/**
	 * Llamada AJAX para llenar data en ventana Modal
	 * Buscando info de UN técnico
	 */ 
	public static function ajax_ver_tecnico(){

		if ( isset( $_POST['tecnicoId'] ) ){

			$tech = UserAdmin::getTecnicoById( $_POST['tecnicoId'] );

			if ( $tech != null && $tech != "" ){

				echo "<br/><b>Nombre:</b> &nbsp;&nbsp;"				 	. $tech[3];
				echo "<br/><b>Apellido:</b> &nbsp;" 					. $tech[4];
				echo "<br/><b>Email:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $tech[5];
				
			} else {
				echo "<b>NO pudimos recuperar información del Ing. de Soporte</b>" 
					. " <i>en estos momentos.</i> Por favor intente m&aacute;s tarde.";
			}
		}
	}


	/**
	 * Llamada AJAX para guardar la opinon de un usuario
	 * Modulo PQRS .:. Cualquier usuario
	 */ 
	public static function ajax_salvar_pqrs(){

		if ( isset( $_POST['comentarioTipo'] ) ){

			session_start();

			$user   = $_SESSION['logged_user'];
			$userId = $user->id;

			$rol  		= $_SESSION['role_user'];
			$empresaId  = $_SESSION['logged_user_empresaId'];

			$count = Clients::insertPQRS($userId, $empresaId, $rol, $_POST['comentarioTipo'], $_POST['opinionComentarios']);

			if ( $count == 1 ){ 
				echo "Sus Comentarios han sido enviados... Much&iacute;simas Gracias :)";
			} else {
				echo $count;
			}
		}
	}


	/**
	 * Para solucionar esta Incidencia por un TECNICO en particular
	 */
	public static function solucionar_incidencia(){

		session_start();

		$tech = $_SESSION['logged_user'];

		View::set("user", $tech);

		if ( isset( $_POST['tecnicoId'] ) ){

			$tecnicoId    = $_POST['tecnicoId'];
			$incidenciaId = $_POST['incidenciaId_form'];
			$empresaId    = $_POST['empresaId'];

			/*
			 * Cargar info de la INCIDENCIA
			 */
			$incidencia = Incidencias::getIncidenciaInfoBasica( $incidenciaId );
			View::set("incidenciaInfo", $incidencia);

			/*
			 * Cargar Respuestas predefinidas: Labor
			 */
			$respuestas = Incidencias::getRespuestasDeEmpresa( $empresaId, "laborEquipo" );
			View::set("respuestas", $respuestas);

			/**
			 * Opcion del menu a desplegar: resolver INCIDENCIA
			 */
			$opcionMenu = "resolver_incidencia";
			View::set("opcionMenu", $opcionMenu);

			View::set("pageTitle", "Solucionar Incidencia");

			View::render( "portal_tech_home" );
		}

	}


	/**
	 * Asignar esta INCIDENCIA al Tecnico LOGUEADO
	 */
	public static function asignarmeIncidencia(){

		session_start();

		$tech = $_SESSION['logged_user'];

		View::set("user", $tech);

		if ( isset( $_POST['incidenciaId_aMi'] ) ){

			$incidenciaId = $_POST['incidenciaId_aMi'];

			/* Asignacion */
			Incidencias::asignarIncidencia($tech->id, $incidenciaId);

			/**/
			Transaccion::insertTransaccionIncidenciaHistorial("Incidencia_En_Progreso", "Ok", $tech, $incidenciaId, 0, "");

			/**/
			/* XXX EmailManagement enviar actualizacion */

			/* Reiniciar página */
			Tecnicos::startTech($tech);

		} else {
			/**/
			Transaccion::insertTransaccionErrorFormulario("Incidencia_En_Progreso","Tecnicos.asignarmeIncidencia()", 
					$tech->id, $_SESSION['role_user'], $tech->empresaId, "No POST() del Formulario");
		}
	}


	/**
	 * El Tecnico logueado ABANDONARA esta incidencia
	 */
	public static function abandonar_incidencia(){

		session_start();

		$tech = $_SESSION['logged_user'];

		View::set("user", $tech);

		if ( isset( $_POST['abandonarIncidenciaId'] ) ){

			$incidenciaId = $_POST['abandonarIncidenciaId'];

			/* Asignacion */
			Incidencias::abandonarIncidencia( $incidenciaId );

			/**/
			Transaccion::insertTransaccionIncidenciaHistorial("Incidencia_Abandonar", "Ok", $tech, $incidenciaId, 0, "");

			/* Reiniciar página */
			Tecnicos::startTech($tech);
		
		} else {
			/**/
			Transaccion::insertTransaccionErrorFormulario("Incidencia_Abandonar","Tecnicos.abandonar_incidencia()", 
					$tech->id, $_SESSION['role_user'], $tech->empresaId, "No POST() del Formulario");
		}
	}
	

	/**
	 * El Tecnico logueado puso en espera
	 */
	public static function incidencia_en_espera(){

		session_start();

		$tech = $_SESSION['logged_user'];

		View::set("user", $tech);

		if ( isset( $_POST['enesperaIncidenciaId'] ) ){

			$incidenciaId = $_POST['enesperaIncidenciaId'];
			$razon = stripslashes( $_POST['razonEnEspera'] );

			/* Asignacion */
			Incidencias::marcarEnEspera( $incidenciaId, $razon );

			/**/
			Transaccion::insertTransaccionIncidenciaHistorial("Incidencia_En_Espera", "Ok", $tech, $incidenciaId, 0, $razon);

			/* 
			 * En este caso se Notifica al Usuario creador de la Incidencia (y a LanuzaGroup)
			 */
			EmailManagement::sendIncidenciaEnEspera( $incidenciaId, $tech, $razon );

			/* Reiniciar página */
			Tecnicos::startTech($tech);
		
		} else {
			/**/
			Transaccion::insertTransaccionErrorFormulario("Incidencia_En_Espera","Tecnicos.incidencia_en_espera()", 
					$tech->id, $_SESSION['role_user'], $tech->empresaId, "No POST() del Formulario");
		}
	}


	/**
	 * El Tecnico logueado HA RESUELTO esta incidencia
	 */
	public static function cerrar_incidencia(){

		session_start();

		$tech = $_SESSION['logged_user'];

		View::set("user", $tech);

		if ( isset( $_POST['incidenciaId_mainForm'] ) ){

			$incidenciaId = $_POST['incidenciaId_mainForm'];
			$empresaId = $_POST['empresaId_mainForm'];

			/*
			 * formulario de resolucion
			 */
			$laborDelEquipo         = stripslashes( $_POST['laborDelEquipo'] );
			$variableEndogena       = stripslashes( $_POST['variableEndogena'] );
			$variableExogenaTecnica = stripslashes( $_POST['variableExogenaTecnica'] );
			$variableExogenaHumana  = stripslashes( $_POST['variableExogenaHumana'] );
			$mantenimientoHardware  = stripslashes( $_POST['mantenimientoHardware'] );
			$mantenimientoSoftware  = stripslashes( $_POST['mantenimientoSoftware'] );
			$acompanamientoJunior   = stripslashes( $_POST['acompanamientoJunior'] );
			
			/*
			 * Los radio buttons, chequear si fueron o no apretados
			 */
			if ( isset($_POST['HWmantenimiento']) ){
				$tipoTrabajoHW = $_POST['HWmantenimiento'];
			} else {
				$tipoTrabajoHW = NULL;
			}
			
			if ( isset($_POST['SWmantenimiento']) ){
				$tipoTrabajoSW = $_POST['SWmantenimiento'];
			} else {
				$tipoTrabajoSW = NULL;
			}
			

			$reporteOincidencia = $_POST['reporteOincidencia'];

			/*
			 * datos de la tabla dinámica: Hardware
			 */
			$cantHardware = $_POST['cantidadComponenetesHardware'];

			$hardwareARemplazar      = $_POST['hardwareARemplazar'];
			$hardwareDescripciones   = $_POST['hardwareDescripciones'];
			$hardwareViejo           = $_POST['hardwareViejo'];
			$hardwareNuevo           = $_POST['hardwareNuevo'];
			$hardwareFueRemplazadoSN = $_POST['hardwareFueRemplazadoSN'];

			/*
			 * tabla de Software dinamica
			 */
			$cantSoftware = $_POST['cantidadComponenetesSoftware'];

			$softwaresARemplazar= $_POST['SoftwaresARemplazar'];
			$softwareVersiones  = $_POST['SoftwareVersiones'];
			$softwareTipos 		= $_POST['SoftwareTipos'];
			$softwareSeriales   = $_POST['SoftwareSeriales'];
			$softwaresCambiados = $_POST['SoftwaresCambiados'];


			/* Asignacion */
			$solucionID = Incidencias::resolverIncidencia( $incidenciaId, $tech->id, 
					$laborDelEquipo,
					$variableEndogena,
					$variableExogenaTecnica,
					$variableExogenaHumana,
					$mantenimientoHardware,
					$mantenimientoSoftware,
					$acompanamientoJunior,
					$tipoTrabajoHW, $tipoTrabajoSW
					);

			/* Salvar en Respuesta Predefinida */
			Incidencias::salvarRespuesta($empresaId, $laborDelEquipo, "laborDelEquipo");

			/* se supone que se añade 1 registro */
			$addedHW = 0;
			$addedSW = 0;

			if ( $solucionID > 1){

				/* si hay componentes de Hardware, añadir a este registro */
				if ( $cantHardware > 0 ){

					$addedHW = Incidencias::agregarComponenteHardware($solucionID, $cantHardware,
							$hardwareARemplazar, $hardwareDescripciones, 
							$hardwareViejo, $hardwareNuevo, $hardwareFueRemplazadoSN,
							false);

				}

				/* si hay componentes de Hardware, añadir a este registro */
				if ( $cantSoftware > 0 ){

					$addedSW = Incidencias::agregarComponenteSoftware($solucionID, $cantSoftware,
							$softwaresARemplazar, $softwareVersiones, 
							$softwareTipos, $softwareSeriales, $softwaresCambiados,
							false);

				}

				/*
				 * Actualizar INCIDENCIA: a estatus Cerrada
				 */
				$fin = Incidencias::cerrarIncidencia( $incidenciaId, $solucionID, $reporteOincidencia );

				if ( $fin == "true" ){
					/*
					 * En este espacio ya la incidencia ha sido guardada
					 * y ha sido marcada con status "Cerrada"
					 *
					 * Ahora se debe mostrar una ventana modal indicando el fin (cantidad de componentes añadidos)
					 */
					$incidencia_cerrada = "La Incidencia #" . $incidenciaId . " ha sido CERRADA exitosamente.";

					if ( $cantHardware > 0 || $cantSoftware > 0 ){

						$incidencia_cerrada .= "<br/> ( Adicionalmente se añadieron ";

						if ( $cantHardware > 0 ){
							$incidencia_cerrada .= $cantHardware . " relevos o cambios de Hardware. ";
						}
						if ( $cantSoftware > 0 ){
							$incidencia_cerrada .= $cantSoftware . " cambios de cantSoftware. ";
						}
						$incidencia_cerrada .= ")";
					}

					View::set("incidencia_cerrada_correctamente", 			$incidencia_cerrada);
					View::set("incidencia_cerrada_correctamente_titulo", 	"La Incidencia ha sido Cerrada ");
					View::set("incidencia_cerrada_correctamente_footer", 	'Para revisar las Incidencias CERRADAS debe buscar la opci&oacute;n "Consultar Hist&oacute;rico de Incidencias" del men&uacute;.');


					/**/
					Transaccion::insertTransaccionIncidenciaHistorial("Incidencia_Cerrada", "Ok", $tech, $incidenciaId, 0, $incidencia_cerrada);

					/*
					 * Notificar a los clientes: Usuarios + Partner
					 */
					EmailManagement::sendIncidenciaCerrada($incidenciaId, $tech, $variableEndogena, $variableExogenaTecnica, $variableExogenaHumana);
					
					/*
					 * En este punto se añade esta INCIDENCIA como que falta por CERTIFICAR
					 * por parte del Usuario afectado
					 */
					Incidencias::agregarAFaltaPorOpinar( $incidenciaId );
				}

			}

			/* Reiniciar página */
			Tecnicos::startTech($tech);

		} else {
			/**/
			Transaccion::insertTransaccionErrorFormulario("Incidencia_Cerrada","Tecnicos.cerrar_incidencia()", 
					$tech->id, $_SESSION['role_user'], $tech->empresaId, "No POST() del Formulario");
		}
	}

	/**
	 * Calendario de Soportes programados (citas)
	 */
	public static function calendario() {

		session_start();

		$tech = $_SESSION['logged_user'];

		View::set("user", $tech);
		View::set("techId", $tech->id);

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
			$citas = Soportes::getSoportesProgramados($year, $month, $yearHasta, $mesHasta );

			View::set("citas", $citas);

			View::set("pageTitle", "Calendario de Soportes Programados");

			View::render( "portal_tech_home" );

		} catch (Exception $e) {
			$internalErrorCodigo  = "Exception in controllers.Tecnicos.calendario()";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "tratando de llamar Soportes::getSoportesProgramados($year, $month, $yearHasta, $mesHasta )";
			
			/**/
			Transaccion::insertTransaccionException("Soporte_crear",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra, $_SESSION['role_user'], $tech->id);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}
	}

	/**
	 * puede venir del portal TECH o ADMIN
	 * Busca las Empresas y las arma para llenar un <select> combo box
	 */
	public static function ajax_json_empresas(){

		if ( isset( $_POST['tecnicoId'] ) ){

			try {
				$json = "";

				$companies = Company::getAll();

				$i=0;
				foreach ($companies as $empresa){

					//$json .= "{ \"" . $empresa["empresaId"]. "\" , \"" . $empresa["nombre"].  "\" , \"" . $empresa["razonSocial"]. "\" },";

					$json .= "<option value=\"" . $empresa["empresaId"]. "\">" . $empresa["nombre"].  " (" . $empresa["razonSocial"]. ")</option>";

					$i++;
				}

				if ( $i > 0 ){
					//$json .= "], \"success\": 1 }";
					echo $json;
				} else {
					//$json = "{ \"receiverDetails\": [] }, \"success\": 1 }";
					echo "<option value=\"none\">ERROR #001 : No se encuentran Empresas, comuniquese con Soporte TI Lanuza Group</option>";
				}

				
				
			} catch (Exception $e) {
				echo "<option value=\"none\">ERROR #002 : No se encuentran Empresas, comuniquese con Soporte TI Lanuza Group</option>";
			}
		}
	}
	/**/
	public static function ajax_json_tecnicos(){
		$json = "";

		$techs = Clients::getAllTecnicos();

		$i=0;
		foreach ($techs as $tech){

			$json .= "<option value=\"" . $tech["id"]. "\">" . $tech["nombre"].  " " . $tech["apellido"]. "</option>";

			$i++;
		}

		if ( $i > 0 ){
			echo $json;
		} else {
			echo "<option value=\"none\">ERROR #001 : No se encuentran Técnicos, comuniquese con Soporte TI Lanuza Group</option>";
		}
	}


	/**
	 * puede venir del portal TECH o ADMIN
	 * Funcion de Creacion de Soporte programado: desde el TECNICO
	 */
	public static function crear_soporte(){

		session_start();

		$tech = $_SESSION['logged_user'];

		View::set("user", $tech);

		if ( isset( $_POST['companiesCombo'] ) ) {

			$empresaId  = $_POST['companiesCombo'];
			$amPM 		= $_POST['am_pm'];
			$hora 		= $_POST['hora'];
			$AmPmHasta  = $_POST['am_pm_hasta'];
			$horaHasta	= $_POST['hora_hasta'];
			$techId     = $_POST['tecnicoAcargo'];

			$trabajoArealizar = stripslashes( $_POST['trabajoArealizar'] );
			$inventarioInfo   = stripslashes( $_POST['trabajo_inventario'] );

			$year= $_POST['soporte_year'];
			$mes = $_POST['soporte_mes'];
			$dia = $_POST['soporte_dia'];

			/* Crear fecha con parametros dados */
			$fechaCita = NULL;
			try {
				$fechaCita = Utils::crearFecha($year, $mes, $dia, $hora, $amPM);

			} catch (Exception $e) {
				$internalErrorCodigo  = "Exception in controllers.Tecnicos.crear_soporte()";
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

			if ( $techId == "none" || $techId == "" ){
				$techId = NULL;
			}
			
			/* Insertar Cita */
			$count = Soportes::insert($techId, $empresaId, $fechaCita, $dia, $hora, $amPM, 
					$trabajoArealizar, $inventarioInfo, "admin", "no", $horaHasta, $AmPmHasta );

			if ( $count == 1 ){
				/**/
				EmailManagement::nuevoSoporteDelTech($empresaId, $tech, $fechaCita, $hora, $amPM, $trabajoArealizar, $inventarioInfo);

				/**/
				$info = "tech-$dia, $hora, $amPM, $trabajoArealizar, $inventarioInfo";
				Transaccion::insertTransaccionSoporteHistorial("Soporte_crear", "Ok", "tech", $techId, $empresaId, $info);

			} else {
				$info = "tech-$dia, $hora, $amPM, $trabajoArealizar, $inventarioInfo, count_NOT_1: $count";
				Transaccion::insertTransaccionSoporteHistorial("Soporte_crear", "Not_Ok", "tech", $techId, $empresaId, $info);
			}
		}
	}


	/**
	 * puede venir del portal TECH o ADMIN
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

				$citas = Soportes::getSoportesDelDia($y, $mes, $d );

				$a1="";$a2="";$a3="";$a4="";$a5="";$a6="";$a7="";$a8="";$a9="";$a10="";$a11="";

				foreach ($citas as $cita) {

					$a1 = $cita["nombreEmpresa"];
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

					if ( $a1 == NULL || $a1 == "" )	$a1 = "nulo";
					if ( $a2 == NULL || $a2 == "" )	$a2 = "nulo";
					if ( $a3 == NULL || $a3 == "" )	$a3 = "nulo";
					if ( $a4 == NULL || $a4 == "" )	$a4 = "nulo";
					if ( $a5 == NULL || $a5 == "" )	$a5 = " ";
					if ( $a6 == NULL || $a6 == "" )	$a6 = "N/A";
					if ( $a7 == NULL || $a7 == "" )	$a7 = "N/A";
					if ( $a8 == NULL || $a8 == "" )	$a8 = "No";
					if ( $a9 == NULL || $a9 == "" )	$a9 = "[No";
					if ( $a10== NULL || $a10== "" )	$a10= "asignado]";
					
					echo $a1
						. "|" . $a2 . " ". $a3
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
			echo "Error|PHP|Controlles|Tecnicos.php|ajax_soportes_table()|".$e -> getMessage()."|Notificar a|Soporte de|Lanuza Group|ERROR #003";
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

		/* VISTA */
		$opcionMenu = "info_perfil";
		View::set("opcionMenu", $opcionMenu);

		$titulo = $_SESSION['logged_user_saludo'];
		View::set("pageTitle", $titulo . "| Perfil");

		View::render( "portal_tech_home" );
	}

	/**
	 * puede venir del portal TECH o ADMIN
	 * actualizaciones VARIAS
	 */
	public static function actualizar_soporte_cita(){

		session_start();

		$tech = $_SESSION['logged_user'];

		View::set("user", $tech);

		if ( isset( $_POST['accion'] ) ) {

			$accion = $_POST['accion'];

			$isAdmin = false;
			if ( isset( $_POST['isAdmin']) ){
				$isAdmin = true;
			}

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
					EmailManagement::notificarSoporte($soporteId, $accion);

					$info = "$hora, $am_pm";
					Transaccion::insertTransaccionSoporteHistorial("Soporte_reprogramar", "Ok", "tech", $tech->id, $soporteId, $info);

				} else {
					$info = "$hora, $am_pm, count_NOT_1: $count";
					Transaccion::insertTransaccionSoporteHistorial("Soporte_reprogramar", "Not_Ok", "tech", $tech->id, $soporteId, $info);
				}

			} else if ( $accion == "aceptar_cita" ){
				/*
				 * aceptar cita de soporte
				 */
				$soporteId  = $_POST['cita_id'];
				$techId = $tech->id;

				$role = "tech";
				if ( $isAdmin == true ){
					$role = "admin";
				}

				$count = Soportes::aceptarCita($soporteId, $techId, $role);

				if ( $count == 1 ){
					/**/
					EmailManagement::notificarSoporte($soporteId, $accion);

					$info = "";
					Transaccion::insertTransaccionSoporteHistorial("Soporte_reprogramar", "Ok", "tech", $tech->id, $soporteId, $info);

				} else {
					$info = "$soporteId, $techId, count_NOT_1: $count";
					Transaccion::insertTransaccionSoporteHistorial("Soporte_reprogramar", "Not_Ok", "tech", $tech->id, $soporteId, $info);
				}
			} else if ( $accion == "Eliminada" ){
				/*
				 * ELIMINAR cita de soporte
				 */
				$soporteId  = $_POST['cita_id'];
				$techId = $tech->id;

				$role = "tech";
				if ( $isAdmin == true ){
					$role = "admin";
				}

				$count = Soportes::eliminarCita($soporteId, $techId, $role);

				if ( $count == 1 ){
					/**/
					EmailManagement::notificarSoporte($soporteId, $accion );

					$info = "";
					Transaccion::insertTransaccionSoporteHistorial("Soporte_eliminar", "Ok", "tech", $tech->id, $soporteId, $info);

				} else {
					$info = "$soporteId, $techId, count_NOT_1: $count";
					Transaccion::insertTransaccionSoporteHistorial("Soporte_eliminar", "Not_Ok", "tech", $tech->id, $soporteId, $info);
				}
			}
		}
	}


	/**
	 * mostrar Formulario
	 */
	public static function update_profile(){

		session_start();

		$tech = $_SESSION['logged_user'];

		View::set("user", $tech);

		View::set("pageTitle", $_SESSION['logged_user_saludo'] . " | Actualizar Perfil ");
		
		/* VISTA */
		$opcionMenu = "actualizar_perfil";
		View::set("opcionMenu", $opcionMenu);
		
		View::render( "portal_tech_home" );
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
			$greetings     = stripslashes($_POST['greetings']);
			$givenname     = stripslashes($_POST['givenname']);
			$lastname      = stripslashes($_POST['lastname']);
			$gender        = stripslashes($_POST['gender']);

			$email         = stripslashes($_POST['email']);
			$dependencia   = stripslashes( $_POST['dependencia'] );

			$cellphone_code= stripslashes( $_POST['cellphone_code'] );
			$phone_cell    = stripslashes( $_POST['phone_cell'] );
			$phone_home    = stripslashes( $_POST['phone_home'] );
			$phone_work    = stripslashes( $_POST['phone_work'] );
			$phone_work_ext= stripslashes( $_POST['phone_work_ext'] );

			/*
			 * Primera Letra Mayúscula 
			 * las demas en minúsculas
			 */
			$givenname = ucfirst( strtolower( $givenname ));
			$lastname  = ucfirst( strtolower( $lastname ));

			/* Actualizar solo el USUARIO */
			$count = UserAdmin::update($userId, $greetings, $givenname, $lastname, $gender,
				$email, $dependencia, 
				$cellphone_code, $phone_cell, $phone_home, $phone_work, $phone_work_ext);

			$tipoTransaccion = "Usuario_Actualizar";
			if ( $count == 0 ){
				$updated_info=" - Información NO Actualizada: Email debe ser único y el correo " . $email . " ya se encuentra registrado para otro Usuario";

			} else if ( $count == 1 ){
				$info = "";
				Transaccion::insertTransaccion($tipoTransaccion, "Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );

				$updated_info=" - Información Actualizada satisfactoriamente.";

			} else {
				$info = "empresa:".$_SESSION['logged_user_empresaId'].", user:$userId, count_NOT_1: $count";
				Transaccion::insertTransaccion($tipoTransaccion, "Not_Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );
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
			} else {
				$password = $pwdrepited;
			}
			
			$user = UserAdmin::getUser($username, $password, $userType);

			/* limpiando */
			unset( $_SESSION['logged_user'] );

			/* poniendolo de nuevo */
			$_SESSION['logged_user'] = $user;

			View::set("user", $user);

			View::set("pageTitle", $_SESSION['logged_user_saludo'] . " | Actualizar Perfil ");
			
			/* VISTA */
			$opcionMenu = "actualizar_perfil";
			View::set("opcionMenu", $opcionMenu);

			View::render( "portal_tech_home" );

		} catch (Exception $e) {
			$internalErrorCodigo  = "Exception in controllers.Tecnicos.actualizar_info_form()";
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
	 * mostrar Formulario para tecnicos
	 */
	public static function nuevo_inventario(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Realizar Nuevo Inventario ");
		
		/* VISTA */
		$opcionMenu = "nuevo_inventario";
		View::set("opcionMenu", $opcionMenu);

		/* FASE: parte del proceso */
		View::set("procesoParte", "Busqueda_Usuario");

		View::render( "portal_tech_home" );
	}

	/**
	 * mostrar Formulario y RESULTADOS de la Busqueda
	 */
	public static function inventario_buscar_usuario(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Seleccione Usuario... ");

		/* VISTA */
		$opcionMenu = "nuevo_inventario";
		View::set("opcionMenu", $opcionMenu);

		/* FASE INICIAL: parte del proceso */
		View::set("procesoParte", "Busqueda_Usuario");	

		if ( isset( $_POST['search'] ) ){

			$search = stripslashes( $_POST['search'] );
			View::set("searched", $search);
			
			if ( strlen($search) >= 3 ){

				/* FASE: parte del proceso */
				View::set("procesoParte", "Seleccion_Usuario");				

				/*
				 * Buscando usuarios de TODAS las Empresas que coincidan con este texto
				 */
				$usuarios = UserAdmin::searchUsers( $search );

				View::set("usuarios", $usuarios);
			}
		}
		View::render( "portal_tech_home" );
	}
	

	/**
	 * mostrar Formulario y RESULTADOS de la Busqueda
	 */
	public static function inventario_buscar_company(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Seleccione Empresa... ");

		/* VISTA */
		$opcionMenu = "nuevo_inventario";
		View::set("opcionMenu", $opcionMenu);

		/* FASE INICIAL: parte del proceso */
		View::set("procesoParte", "Busqueda_Usuario");	

		if ( isset( $_POST['searchCompany'] ) ){

			$search = stripslashes( $_POST['searchCompany'] );
			View::set("searchedCompany", $search);
			
			if ( strlen($search) >= 3 ){

				/* FASE: parte del proceso */
				View::set("procesoParte", "Seleccion_Empresa");				

				/*
				 * Buscando TODAS las Empresas que coincidan con este texto
				 */
				$companies = Empresas::searchCompanies( $search );

				View::set("companies", $companies);
			}
		}
		View::render( "portal_tech_home" );
	}

	/**
	 * una vez Buscado el USUARIO, proseguir con el FORMULARIO de Inventario
	 */
	public static function inventario_seleccionar_usuario(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Inventario Nuevo");

		/* VISTA */
		$opcionMenu = "nuevo_inventario";
		View::set("opcionMenu", $opcionMenu);

		/* FASE INICIAL: parte del proceso */
		View::set("procesoParte", "Busqueda_Usuario");

		if ( isset( $_POST['seleccionarUsuarioID'] ) ){
			/*
			 * NO buscar info del USUARIO, setearla de la pantalla ANTERIOR
			 */
			$searchedId = $_POST['seleccionarUsuarioID'];
			View::set("searchedId", $searchedId );

			View::set("searchedName", $_POST['seleccionarUsuarioNombre'] . " " . $_POST['seleccionarUsuarioApellido']);
			
			$company = $_POST['seleccionarUsuarioEmpresa'];

			if ( $_POST['seleccionarUsuarioRazon'] != "" ){
				$company .= "(" . $_POST['seleccionarUsuarioRazon'] . ")";
			}
			View::set("searchedCompany", $company );

			/*
			 * BUSCAR Equipos de Este Usuario, si es que tiene
			 */
			$empresaId = $_POST['seleccionarUsuarioEmpresaID'];
			View::set("searchedEmpresaId", $empresaId);

			$equipos = Equipos::getEquipos2($searchedId, $empresaId);
			
			if ( $equipos != null ){
				View::set("equipos", $equipos);
			} else {
				View::set("no_equipos", "no_equipos");
			}
			
			/*
			 * Info para crear un nuevo Equipo
			 */
			$tipoEquipos = Equipos::getAllTipoEquipos();
			View::set("tipoEquipos", $tipoEquipos);

			$perifericos = Clients::getPerifericos();
			View::set("perifericos", $perifericos);

			/* FASE: parte del proceso */
			View::set("procesoParte", "Usuario_Seleccionado");
		}
		View::render( "portal_tech_home" );
	}

	
	/**
	 * una vez Buscada la EMPRESA, proseguir con el FORMULARIO de Inventario
	 */
	public static function inventario_seleccionar_empresa(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Inventario Nuevo");

		/* VISTA */
		$opcionMenu = "nuevo_inventario";
		View::set("opcionMenu", $opcionMenu);

		/* FASE INICIAL: parte del proceso */
		View::set("procesoParte", "Busqueda_Usuario");

		if ( isset( $_POST['seleccionarEmpresaID'] ) ){
			/*
			 * NO buscar info de la Empresa, setearla de la pantalla ANTERIOR
			 */
			$searchedId = $_POST['seleccionarEmpresaID'];
			View::set("searchedEmpresaId", $searchedId );

			$company = $_POST['seleccionarEmpresaNombre'];

			if ( $_POST['seleccionarEmpresaRazonsocial'] != NULL && $_POST['seleccionarEmpresaRazonsocial'] != ""  ){
				$company .= " ( " . $_POST['seleccionarEmpresaRazonsocial'] . " )";
			}

			if ( $_POST['seleccionarEmpresaNIT'] != NULL && $_POST['seleccionarEmpresaNIT'] != ""  ){
				$company .= ". NIT: " . $_POST['seleccionarEmpresaNIT'];
			}

			View::set("companyInfo", $company);
			View::set("empresaDireccion", $_POST['seleccionarEmpresaDireccion']);
			View::set("empresaCantidadEquipos", $_POST['seleccionarEmpresaCantEquipos']);

			/*
			 * Info para crear un nuevo Equipo
			 */
			$tipoEquipos = Equipos::getAllTipoEquipos();
			View::set("tipoEquipos", $tipoEquipos);

			$perifericos = Clients::getPerifericos();
			View::set("perifericos", $perifericos);

			/* FASE: parte del proceso */
			View::set("procesoParte", "Empresa_Seleccionada");
		}
		View::render( "portal_tech_home" );
	}

	/**
	 * CREAR EQUIPO nuevo al USUARIO ó EMPRESA buscada
	 * y mostrará FORMULARIO para subida de ARCHIVOS
	 */
	public static function inventario_nuevo_equipo(){

		session_start();

		$tech   = $_SESSION['logged_user'];
		$techId = $tech->id;

		View::set("user", $tech );

		View::set("pageTitle", "Equipo Nuevo creado");

		if ( isset( $_POST['searchedEmpresaId'] ) ){

			/*
			 * Busqueda por USUARIO
			 */
			$searchedId = $_POST['searchedUserId'];
			if ( $searchedId == NULL || $searchedId == "" ){
				$searchedId = 0;
			}
			
			$searchedUserName = $_POST['searchedUserName'];
			View::set("searchedUserName", $searchedUserName);

			/*
			 * Busqueda por EMPRESA
			 */
			$empresaId  = $_POST['searchedEmpresaId'];

			$companyInfo = $_POST['companyInfo'];
			View::set("companyInfo", $companyInfo);

			/*
			 * Buscar MAX ID de tabla Inventarios
			 */
			$idAutoincremental = Equipos::getMaxID("Equipos");
			$idAutoincremental++;

			/*
			 * Buscando en el formulario la data del Equipo a CREAR; y sus PERIFERICOS (si es que hay)
			 */
			$data = Tecnicos::obtenerDataDelFormularioEquipo();

			$perifericos = Tecnicos::obtenerPerifericosDelFormularioEquipo();

			/*
			 * crear equipo, si $searchedId==0 ent NO se asociará a Usuario
			 */
			$count = Equipos::insert($empresaId, $searchedId, $idAutoincremental, $data, $perifericos);

			$tipoTransaccion = "Tecnico_Nuevo_Inventario";
			if ( $count == 1 ){
				$info = "EQUIPO_CREADO para userId:".$searchedId;
				Transaccion::insertTransaccionEquipo($tipoTransaccion, "Ok", $techId, $_SESSION['role_user'], $empresaId , $info , $idAutoincremental);

				/*
				 * Buscando Equipo recien creado
				 */
				$newEquipo = Equipos::getById($idAutoincremental);
				View::set("newEquipo", $newEquipo);

			} else {
				$info = "toEmpresa:".$empresaId.", toUser:".$searchedId.", techId:".$techId.", count_NOT_1: $count - EQUIPO_NO_CREADO - inventario_nuevo_equipo()";
				Transaccion::insertTransaccionEquipo($tipoTransaccion, "Not_Ok", $techId, $_SESSION['role_user'], $empresaId , $info , $idAutoincremental);

				/* NO creado */
				View::set("newEquipo", "no_creado");
			}
		}

		/* VISTA */
		$opcionMenu = "inventario_subir_scripts";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_tech_home" );

	}

/**
 * USADO PARA PRUEBAS - test user
 * @TEST -> inventario_nuevo_equipo()
 */
public static function script(){
	session_start();
	$tech   = $_SESSION['logged_user'];
	$techId = $tech->id;
	View::set("user", $tech );
	View::set("pageTitle", "Equipo Nuevo creado");

	View::set("searchedUserName", "Helmuld Prueba");

	$newEquipo=Equipos::getById(24);
	View::set("newEquipo", $newEquipo);
/*$E="Revisores de Texto do Microsoft Office 2013 – Português do Brasil";echo "$E .:. " . Utils::transliterateString($E);
*/
	$opcionMenu = "inventario_subir_scripts";
	View::set("opcionMenu", $opcionMenu);

	View::render( "portal_tech_home" );
}


	/**
	 * una vez Buscado el USUARIO y seleccionado los archivos; proceder a leerlos
	 */
	public static function inventario_leer_archivos(){

		session_start();

		$tech   = $_SESSION['logged_user'];
		$techId = $tech->id;
		View::set("user", $tech );

		View::set("pageTitle", "Procesando archivos de Inventario");

		$tipoTransaccion = "Tecnico_Nuevo_Inventario_CSV";

		if ( isset( $_POST['newEquipoId'] ) ){

			/**
			 * 1.- Leer Archivos
			 */

			$newEquipoId = $_POST['newEquipoId'];
			
			View::set("newEquipoId", $newEquipoId);
			View::set("newEquipoCodigoBarras", $_POST['newEquipoBarras']);

			/*****************************************************************************************
			 *  a)  CPU.csv
			 */
			$CPU = file_get_contents($_FILES["CPU"]["tmp_name"]);

			$cpu1 = "<br><b>Archivo 1: " . $_FILES["CPU"]["name"] . "</b>";

			$cpu1 .= "<br>Tamaño: " . ($_FILES["CPU"]["size"] ) . " bytes";/* $_FILES["CPU"]["size"]  / 1024 da en KBytes */

			$cpu1 .= "<br>Almacenamiento temporal: " . $_FILES["CPU"]["tmp_name"];

			//echo "<br/>contenido:$CPU";
			$cpu1 .= "<br><i>Procesando...</i> ";
			
			try {
				$data = InventarioScripts::csvCPU( $CPU, $newEquipoId );
 
				/* id de tabla */
				$cpuId = $data['cpuId'];

				if ( $cpuId ==  -1 || $data['count'] != 1 ){
					$cpu1 .= "<br><b>...Archivo NO procesado</b>. ".$data['count'];
				} else {
					$cpu1 .= "<br><b>...¡Procesado correctamente!</b>";	
				}
				
				$cpu1 .= $data['resumen'];

				View::set("cpu", $cpu1);

				/* Testing forzando excepción: throw new \Exception("mensaje error.");  */

			} catch (\Exception $e) {
				View::set("no_cpu", $e -> getMessage() );
			}

			/*
			 * 2.- Buscar MAX ID de tabla Inventarios
			 */
			$equipoInfoId = Equipos::getMaxID("EquipoInfo");
			$equipoInfoId++;

			/*
			 * 3.- Insertar INVENTARIO con los ID's A_I de las tablas INVENTARIO
			 */
			$count = Equipos::insertEquipoInfo($equipoInfoId, $cpuId );//.... todos los id's A_I del inventario
			if ( $count == 1 ){
				/*
				 * 4.- Asociar INVENTARIO al EQUIPO del Usuario
				 */
				$count = Equipos::updateEquipoConInventario($newEquipoId, $equipoInfoId);

				if ( $count == 1 ){
					/*****************************************************************************************
					 *     b)    Motherboard.csv
					 */
					try {
						$a = $_FILES["Motherboard"]["tmp_name"];
						$b = $_FILES["Motherboard"]["name"];
						$c = $_FILES["Motherboard"]["size"];
						$d = file_get_contents( $a );

						$data2 = InventarioScripts::csvMotherboard( $equipoInfoId, $a, $b, $c, $d, -1 );

						$mb = $data2['info'] . $data2['resumen'];

						$motherboardId = $data2['mbId'];

						View::set("motherboard", $mb);

					} catch (\Exception $e) {
						View::set("no_motherboard", $e -> getMessage() );
					}

					/*
					 * ID's a actualizar en tabla EquipoInfo
					 */
					$update = Equipos::updateEquipoInfo($equipoInfoId, $motherboardId );

					/*****************************************************************************************
					 *     c)    RAM.csv
					 */
					try {
						$k = $_FILES["RAM"]["tmp_name"];
						$l = $_FILES["RAM"]["name"];
						$m = $_FILES["RAM"]["size"];
						$n = file_get_contents( $k );

						$data3 = InventarioScripts::csvRAM( $equipoInfoId, $k, $l, $m, $n, -1 );

						View::set("RAM", $data3);

					} catch (\Exception $ex) {
						View::set("no_RAM", $ex -> getMessage() );
					}

					/*****************************************************************************************
					 *     d)    LocalUsers.csv
					 */
					try {
						$e = $_FILES["LocalUsers"]["tmp_name"];
						$f = $_FILES["LocalUsers"]["name"];
						$g = $_FILES["LocalUsers"]["size"];
						$h = file_get_contents( $e );

						$data4 = InventarioScripts::csvLocalUsers( $equipoInfoId, $e, $f, $g, $h, -1 );

						View::set("localUsers", $data4);

					} catch (\Exception $ex) {
						View::set("no_localUsers", $ex -> getMessage() );
					}

					/*****************************************************************************************
					 *     e)    Sound.csv
					 */
					try {
						$o = $_FILES["Sound"]["tmp_name"];
						$p = $_FILES["Sound"]["name"];
						$q = $_FILES["Sound"]["size"];
						$r = file_get_contents( $o );

						$data5 = InventarioScripts::csvSound( $equipoInfoId, $o, $p, $q, $r, -1 );

						View::set("sound", $data5);

					} catch (\Exception $ex) {
						View::set("no_sound", $ex -> getMessage() );
					}

					/*****************************************************************************************
					 *     f)    Video.csv
					 */
					try {
						$s = $_FILES["Video"]["tmp_name"];
						$t = $_FILES["Video"]["name"];
						$u = $_FILES["Video"]["size"];
						$v = file_get_contents( $s );

						$data6 = InventarioScripts::csvVideo( $equipoInfoId, $s, $t, $u, $v, -1 );

						View::set("video", $data6);

					} catch (\Exception $ex) {
						View::set("no_video", $ex -> getMessage() );
					}

					/*****************************************************************************************
					 *     g)    OS.csv
					 */
					try {
						$w = $_FILES["OS"]["tmp_name"];
						$x = $_FILES["OS"]["name"];
						$y = $_FILES["OS"]["size"];
						$z = file_get_contents( $w );

						$data7 = InventarioScripts::csvOS( $equipoInfoId, $w, $x, $y, $z, $newEquipoId, -1, "concat" );

						View::set("OS", $data7);

					} catch (\Exception $ex) {
						View::set("no_OS", $ex -> getMessage() );
					}

					/*****************************************************************************************
					 *     h)    Hard drives.csv
					 */
					try {
						$aa = $_FILES["Hard_drives"]["tmp_name"];
						$bb = $_FILES["Hard_drives"]["name"];
						$cc = $_FILES["Hard_drives"]["size"];
						$dd = file_get_contents( $aa );

						$data8 = InventarioScripts::csvHardDrives( $equipoInfoId, $aa, $bb, $cc, $dd, -1 );

						View::set("hard_drive", $data8);

					} catch (\Exception $ex) {
						View::set("no_hard_drives", $ex -> getMessage() );
					}

					/*****************************************************************************************
					 *     i)    SMART.csv
					 */
					try {
						$ee = $_FILES["SMART"]["tmp_name"];
						$ff = $_FILES["SMART"]["name"];
						$gg = $_FILES["SMART"]["size"];
						$hh = file_get_contents( $ee );

						$data9 = InventarioScripts::csvSMART( $equipoInfoId, $ee, $ff, $gg, $hh, -1 );

						View::set("SMART", $data9);

					} catch (\Exception $ex) {
						View::set("no_SMART", $ex -> getMessage() );
					}

					/*****************************************************************************************
					 *     j)    Networking.csv
					 */
					try {
						$ii = $_FILES["Networking"]["tmp_name"];
						$jj = $_FILES["Networking"]["name"];
						$kk = $_FILES["Networking"]["size"];
						$ll = file_get_contents( $ii );

						$data10 = InventarioScripts::csvNetworking( $equipoInfoId, $ii, $jj, $kk, $ll, -1 );

						View::set("networking", $data10);

					} catch (\Exception $ex) {
						View::set("no_networking", $ex -> getMessage() );
					}

					/*****************************************************************************************
					 *     k)    Software.csv
					 */
					try {
						$mm = $_FILES["Software"]["tmp_name"];
						$nn = $_FILES["Software"]["name"];
						$oo = $_FILES["Software"]["size"];
						$pp = file_get_contents( $mm );

						$data11 = InventarioScripts::csvSoftware( $equipoInfoId, $mm, $nn, $oo, $pp, -1 );

						View::set("software", $data11);

					} catch (\Exception $ex) {
						View::set("no_software", $ex -> getMessage() );
					}

					/*
					 * llegados a este punto, informar que todo salió bien
					 */
					$info = "equipoInfoId:$equipoInfoId";
					Transaccion::insertTransaccionEquipo($tipoTransaccion, "Ok", $techId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'], $info , $newEquipoId);

				} else {
					/*
					 * informar Tecnico que NO se realizó actualización. Paso 4.-
					 */
					$info = "updateEquipoConInventario()_ERROR:  count_NOT_1: $count";
					Transaccion::insertTransaccionEquipo($tipoTransaccion, "Not_Ok", $techId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'], $info , $newEquipoId);

				}
			} else {
				/*
				 * informar Tecnico que NO se realizó actualización. Paso 3.-
				 */
				$info = "insertEquipoInfo()_:  count_NOT_1: $count";
				Transaccion::insertTransaccionEquipo($tipoTransaccion, "Not_Ok", $techId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'], $info , $newEquipoId);
			}
		}
		
		/* VISTA */
		$opcionMenu = "resultado_inventario";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_tech_home" );
	}


	/**
	 * Una vez Buscado el USUARIO y seleccionado los archivos; proceder a leerlos
	 */
	public static function historico_incidencias(){

		session_start();

		$tech   = $_SESSION['logged_user'];
		$techId = $tech->id;
		View::set("user", $tech );

		View::set("pageTitle", "Incidencias ya Cerradas (finalizadas/resueltas)");

		/*
		 * SQL LIMIT limitando resultados para PAGINATION
		 * $page debe INICIAR en 1
		 */
		$page = 1;
		$limit = 100;

		/* Incidencias de este tecnico */
		$incidenciasTecnico = Incidencias::getIncidenciasCerradasDeTecnico( $techId, $page, $limit );

		if ( $incidenciasTecnico != NULL && $incidenciasTecnico != "" ){
			View::set("incidenciasTecnico", $incidenciasTecnico );
		} else {
			View::set("no_incidenciasTecnico", "no_incidenciasTecnico" );
		}

		/* Incidencias TODAS */
		$incidenciasTodas = Incidencias::getIncidenciasCerradas( $page, $limit );
		View::set("incidenciasTodas", $incidenciasTodas );

		/* VISTA */
		$opcionMenu = "historico_incidencias";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_tech_home" );

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

			/* VISTA */
			$opcionMenu = "ver_solucion";
			View::set("opcionMenu", $opcionMenu);

			View::render( "portal_tech_home" );
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
			View::set("tipo_portal", "tecnicos/home");

			View::set("viene_de_tech", "viene_de_tech");

			

			/* Pagina optimizada para IMPRIMIR: INCIDENCIAS */
			View::render( "imprimir_solucion_incidencia" );

		}
	}


	/**
	 * Mostrar Formulario para buscar Empresa
	 */ 
	public static function asignacion(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Asignación de Equipos de Empresa");
		
		/* VISTA */
		$opcionMenu = "asignacion_buscar_empresa";
		View::set("opcionMenu", $opcionMenu);

		/* FASE: parte del proceso */
		View::set("procesoParte", "Busqueda_Empresa");

		View::render( "portal_tech_home" );
	}


	/**
	 * Viene del Formulario: buscar Empresa
	 */ 
	public static function asignacion_seleccionar_empresa(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Asignación de Equipos de Empresa");
		
		/* VISTA */
		$opcionMenu = "asignacion_buscar_empresa";
		View::set("opcionMenu", $opcionMenu);

		/* FASE: parte del proceso */
		View::set("procesoParte", "Busqueda_Empresa");

		if ( isset( $_POST['searchCompany'] ) ){

			$search = stripslashes( $_POST['searchCompany'] );
			View::set("searchedCompany", $search);
			
			if ( strlen($search) >= 3 ){

				/* FASE: parte del proceso */
				View::set("procesoParte", "Seleccion_Empresa");				

				/*
				 * Buscando TODAS las Empresas que coincidan con este texto
				 */
				$companies = Empresas::searchCompanies( $search );

				View::set("companies", $companies);
			}
		}
		View::render( "portal_tech_home" );
	}


	/**
	 * Viene del Formulario: buscar Empresa; ya se seleccionó UNA y ahora mostrará los Equipos y Usuarios de ella
	 */ 
	public static function asignacion_equipos_de_empresa(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		Tecnicos::mostrarEquiposYUsuariosDeEmpresa();
	}


	/**
	 *  Eliminar UN USUARIO de un EQUIPO
	 */ 
	public static function desasociar_equipo_usuario(){

		if ( isset( $_POST['equipoId'] ) ){

			session_start();

			View::set("user", $_SESSION['logged_user'] );

			$user   = $_SESSION['logged_user'];
			$userId = $user->id;

			$companyID = $_POST['seleccionarEmpresaID'];
			$equipoId  = $_POST['equipoId'];
			$usuarioId = $_POST['usuarioId'];

			$tipoTransaccion = "Asignar_Equipo_Usuario";

			$count = Equipos::eliminarUsuarioDeEquipo($companyID, $equipoId, $usuarioId);

			if ( $count == 1 ){
				/**/
				$info = "DESASOCIAR: Equipo:$equipoId - removido de Usuario:$usuarioId - Empresa:$companyID ";
				Transaccion::insertTransaccion($tipoTransaccion, "Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );

			} else {
				/**/
				$info = "DESASOCIAR: empresa:$companyID - equipo:$equipoId - usuario:$usuarioId - tech:$userId - count_NOT_1: $count";
				Transaccion::insertTransaccion($tipoTransaccion, "Not_Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );
			}
		}

		Tecnicos::mostrarEquiposYUsuariosDeEmpresa();
	}

	/**
	 * asociando UN EQUIPO a UN USUARIO
	 */ 
	public static function asociar_equipo_usuario(){

		if ( isset( $_POST['usuarioId'] ) ){

			session_start();

			View::set("user", $_SESSION['logged_user'] );

			$user   = $_SESSION['logged_user'];
			$userId = $user->id;

			$companyID = $_POST['seleccionarEmpresaID'];
			$equipoId  = $_POST['equipoId'];
			$usuarioId = $_POST['usuarioId'];

			$tipoTransaccion = "Asignar_Equipo_Usuario";

			$count = Equipos::asociarUsuarioAEquipo($companyID, $equipoId, $usuarioId);

			if ( $count == 1 ){
				/**/
				$info = "ASOCIAR: Equipo:$equipoId - asignado a Usuario:$usuarioId - Empresa:$companyID ";
				Transaccion::insertTransaccion($tipoTransaccion, "Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );

			} else {
				/**/
				$info = "ASOCIAR: empresa:$companyID - equipo:$equipoId - usuario:$usuarioId - tech:$userId - count_NOT_1: $count";
				Transaccion::insertTransaccion($tipoTransaccion, "Not_Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );
			}
		}

		Tecnicos::mostrarEquiposYUsuariosDeEmpresa();
	}

	/**
	 * buscando los Equipos, Usuarios y seteando la info de la Empresa
	 */ 
	public static function mostrarEquiposYUsuariosDeEmpresa(){
		
		if ( isset( $_POST['seleccionarEmpresaID'] ) ){
			/*
			 * NO buscar info de la Empresa, setearla de la pantalla ANTERIOR
			 */
			$searchedId = $_POST['seleccionarEmpresaID'];
			View::set("searchedCompanyId", $searchedId );

			$company = $_POST['seleccionarEmpresaNombre'];

			if ( $_POST['seleccionarEmpresaRazonsocial'] != NULL && $_POST['seleccionarEmpresaRazonsocial'] != "" ){
				$company .= " ( " . $_POST['seleccionarEmpresaRazonsocial'] . " )";
			}

			if ( $_POST['seleccionarEmpresaNIT'] != NULL && $_POST['seleccionarEmpresaNIT'] != ""  ){
				$company .= ". NIT: " . $_POST['seleccionarEmpresaNIT'];
			}

			View::set("companyInfo", $company);
			View::set("empresaDireccion", $_POST['seleccionarEmpresaDireccion']);
			View::set("empresaCantidadEquipos", $_POST['seleccionarEmpresaCantEquipos']);

			View::set("pageTitle", $_POST['seleccionarEmpresaNombre'] . ": Asignación de Equipos de Empresa");

			/*
			 * Mostrar Equipos de esta Empresa
			 */
			$equipos = Equipos::getEquiposUsuariosDeEmpresa($searchedId);
			View::set("equipos", $equipos);

			$usuarios = UserAdmin::getUsuariosDeEmpresa($searchedId, true);
			if ( $usuarios != NULL && $usuarios != "" ){
				View::set("usuarios", $usuarios);
			} else {
				View::set("no_usuarios", "no_usuarios");
			}

			/* VISTA */
			$opcionMenu = "equipos_de_empresa";

		} else {
			/* VISTA */
			$opcionMenu = "asignacion_buscar_empresa";
		}

		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_tech_home" );
	}

	/**
	 * Mostrar el formulario de busqueda de Equipos
	 */ 
	public static function actualizar_inventario(){
		
		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Actualizar Inventario");

		/* fase del proceso */
		View::set("procesoParte", "Busqueda_Equipo");

		/* VISTA */
		$opcionMenu = "busqueda_equipos";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_tech_home" );
	}


	/**
	 * Busqueda de Equipos - presentacion en tabla
	 */ 
	public static function inventario_buscar_equipo(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Búsqueda de Equipos para Actualizar");
		
		/* VISTA */
		$opcionMenu = "busqueda_equipos";
		View::set("opcionMenu", $opcionMenu);

		/* FASE: parte del proceso */
		View::set("procesoParte", "Busqueda_Equipo");

		if ( isset( $_POST['search'] ) ){

			$search = stripslashes( $_POST['search'] );
			View::set("searched", $search);
			
			if ( strlen($search) >= 3 || is_numeric($search) ){

				/* FASE: parte del proceso */
				View::set("procesoParte", "Seleccion_Equipo");

				/*
				 * Buscando TODAS las Empresas que coincidan con este texto
				 */
				$equipos = Equipos::searchEquipos( $search );

				if ( $equipos == NULL || $equipos == "" ){
					View::set("no_equipos", "no_equipos");
				} else {
					View::set("equipos", $equipos);
				}
			}
		}
		View::render( "portal_tech_home" );
	}


	/**
	 * Ya el EQUIPO existe, pero se cargará los Scripts desde cero
	 */ 
	public static function inventario_desde_cero(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Equipo para Actualizar");

		if ( isset( $_POST['equipoId'] ) ){

			$id = $_POST['equipoId'];

			$newEquipo = Equipos::getById( $id );
			View::set("newEquipo", $newEquipo);

			$info = Equipos::usuarioYempresaDadoEquipo( $id );

			$companyInfo = $info->Empresa;
			if ( $info->razonSocial != NULL && $info->razonSocial != "" ){
				$companyInfo .= " (" . $info->razonSocial . ")";
			}

			View::set("companyInfo", $companyInfo);

			if ( $info->nombre == NULL || $info->nombre == "" ){
				$searchedUserName = "No Asignado";
			} else {
				$searchedUserName = $info->nombre . " " . $info->apellido;
			}

			View::set("searchedUserName", $searchedUserName);

			/* VISTA */
			$opcionMenu = "inventario_subir_scripts";
			View::set("opcionMenu", $opcionMenu);

			View::render( "portal_tech_home" );
		}
	}


	/**
	 * Ya el EQUIPO existe, y fue inventariado, ahora ACTUALIZAR
	 */ 
	public static function inventario_actualizar(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Actualizar Equipo con los Scripts");

		if ( isset( $_POST['equipoInfoId'] ) ){

			$equipoId 	 = $_POST['equipoId'];
			$equipoInfoId= $_POST['equipoInfoId'];
			$usuario 	 = $_POST['Nombre'];
			$apellido 	 = $_POST['Apellido'];
			$company 	 = $_POST['Empresa'];
			$razonSocial = $_POST['RazonSocial'];

			if ( $apellido != NULL && $apellido != "" ){
				View::set("usuario", $usuario . " " . $apellido);
			} else {
				View::set("usuario", "N/A");
			}	
			
			if ( $razonSocial != NULL && $razonSocial != "" ){
				View::set("companyInfo", $company . " (" . $razonSocial . ")");
			} else {
				View::set("companyInfo", $company);
			}

			View::set("equipoId", 	  $equipoId);
			View::set("equipoInfoId", $equipoInfoId);

			/* VISTA */
			$opcionMenu = "inventario_actualizar_scripts";
			View::set("opcionMenu", $opcionMenu);

			View::render( "portal_tech_home" );
		}
	}


	/**
	 * ACTUALIZAR solo ID/Clave
	 */ 
	public static function actualizar_teamviewer(){

		session_start();

		$tech   = $_SESSION['logged_user'];
		$techId = $tech->id;
		View::set("user", $tech );

		View::set("pageTitle", "Actualizar Equipo con los Scripts");

		if ( isset( $_POST['tv_equipoId'] ) ){
			
			$equipoId 		 = $_POST['tv_equipoId'];
			$teamViewerID    = $_POST['tv_id'];
			$teamViewerClave = $_POST['tv_clave'];

			$count = Equipos::actualizarTeamviewerDeEquipo( $equipoId, $teamViewerID, $teamViewerClave );
			if ( $count == 1 ){
				$info = "actualizar_teamviewer() | equipoId: $equipoId";
				Transaccion::insertTransaccion("Tecnico_Actualizar_Inventario", "Ok", $techId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );
			} else {
				$info = "actualizar_teamviewer() | data: $equipoId, $teamViewerID, $teamViewerClave | count_NOT_1: $count";
				Transaccion::insertTransaccion("Tecnico_Actualizar_Inventario", "Not_Ok", $techId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );
			}

			/*
			 * Buscando TODAS las Empresas que coincidan con este texto
			 */
			$search = $_POST['tv_search'];
			View::set("searched", $search);

			$equipos = Equipos::searchEquipos( $search );

			if ( $equipos == NULL || $equipos == "" ){
				View::set("no_equipos", "no_equipos");
			} else {
				View::set("equipos", $equipos);
			}

			/* FASE: parte del proceso */
			View::set("procesoParte", "Seleccion_Equipo");

			/* VISTA */
			$opcionMenu = "busqueda_equipos";
			View::set("opcionMenu", $opcionMenu);

			View::render( "portal_tech_home" );
		}
	}


	/**
	 * ACTUALIZAR 1, varios o TODOS los Archivos Scripts,
	 * y crear el Historial (legacy) para comparaciones
	 *
	 * Viene del formulario inventario_actualizar_scripts.php
	 */ 
	public static function inventario_actualizar_archivos(){

		session_start();

		$tech   = $_SESSION['logged_user'];
		$techId = $tech->id;
		View::set("user", $tech );

		$tipoTransaccion = "Tecnico_Actualizar_Inventario_CSV";

		View::set("pageTitle", "Actualizando info de Equipo...");

		if ( isset( $_POST['equipoId'] ) ){

			$equipoId = $_POST['equipoId'];
			View::set("equipoId", $equipoId);

			$equipoInfoId = $_POST['equipoInfoId'];

			/**
			 * 1.- Saber qué Archivos vienen, los que vengan
			 */
			$filesChosen = $_POST['filesChosen'];
			
			$bCPU = false;
			$bMB  = false;
			$bRAM = false;
			$bLU  = false;
			$bSo  = false;
			$bVi  = false;
			$bOS  = false;
			$bHD  = false;
			$bSm  = false;
			$bNet = false;
			$bSof = false;

			$array = explode(",", $filesChosen);

			for ( $i=0; $i < count($array); $i++ ){

				$aux = $array[$i];

				if ( $aux == "CPU" )				$bCPU = true;
				else if ( $aux == "RAM" )			$bRAM = true;
				else if ( $aux == "Hard_drives" )	$bHD = true;
				else if ( $aux == "SMART" )			$bSm = true;
				else if ( $aux == "LocalUsers" )	$bLU = true;
				else if ( $aux == "Software" )		$bSof = true;
				else if ( $aux == "Motherboard" )	$bMB = true;
				else if ( $aux == "Sound" )			$bSo = true;
				else if ( $aux == "Networking" )	$bNet = true;
				else if ( $aux == "Video" )			$bVi = true;
				else if ( $aux == "OS" )			$bOS = true;
			}
			
			/**
			 * 2.- Actualizar dicha info, una por una
			 */
			$print = "";

			/* todos los ID's inician en NULL  */
			$old_cpuId = NULL; $old_mbId = NULL;
			$old_ramIds = NULL; $old_hdIds = NULL; $old_smartIds = NULL; $old_localUsersIds = NULL; 
			$old_soundIds = NULL; $old_networkingIds = NULL; $old_videoIds = NULL; $old_OsIds = NULL; $old_SoftwareIds = NULL;

			/* Para insertar en el Historial, se insertará el MAYOR número de Inventariado */
			$mayorLegacyNumber = 0;

			if ( $bCPU ){
				/*****************************************************************************************
				 *  a)  CPU.csv
				 */
				$a = $_FILES["CPU"]["tmp_name"];
				$b = $_FILES["CPU"]["name"];
				$c = $_FILES["CPU"]["size"];
				$d = file_get_contents( $a );

				try {
					$data = InventarioScripts::csvActualizarCPU( $equipoId, $equipoInfoId, $a, $b, $c, $d );
	 
					/* id de tabla */
					$cpuId = $data['cpuId'];

					$print .= "<br/><br/>" . $data['resumen'];

					if ( $cpuId ==  -1 || $data['count'] != 1 ){
						$print .= "<br><b>...Archivo NO procesado</b>. " . $data['count'];
					} else {
						$print .= "<br><b>...¡Procesado correctamente!</b>";
					}

					/*
					 * Info de Inventario
					 */
					$mayorLegacyNumber = Utils::tomarElMayor( $mayorLegacyNumber, $data['legacyNumber'] );

					$old_cpuId = $data['oldCpuId'];

				} catch (\Exception $e) {
					View::set("no_cpu", $e -> getMessage() );
				}
			}

			if ( $bMB ){
				/*****************************************************************************************
				 *  b)  Motherboard.csv
				 */
				$e = $_FILES["Motherboard"]["tmp_name"];
				$f = $_FILES["Motherboard"]["name"];
				$g = $_FILES["Motherboard"]["size"];
				$h = file_get_contents( $e );

				try {
					$data = InventarioScripts::csvActualizarMotherboard( $equipoId, $equipoInfoId, $e, $f, $g, $h );
	 
					/* id de tabla */
					$mbId = $data['mbId'];

					$print .= "<br/><br/>" . $data['resumen'];

					if ( $mbId ==  -1 || $data['count'] != 1 ){
						$print .= "<br><b>...Archivo NO procesado</b>. " . $data['count'];
					} else {
						$print .= "<br><b>...¡Procesado correctamente!</b>";
					}

					/*
					 * Info de Inventario
					 */
					$mayorLegacyNumber = Utils::tomarElMayor( $mayorLegacyNumber, $data['legacyNumber'] );

					$old_mbId = $data['oldMbId'];

				} catch (\Exception $e) {
					View::set("no_motherboard", $e -> getMessage() );
				}
			}

			if ( $bRAM ){
				/*****************************************************************************************
				 *  c)  RAM.csv
				 */
				$i = $_FILES["RAM"]["tmp_name"];
				$j = $_FILES["RAM"]["name"];
				$k = $_FILES["RAM"]["size"];
				$l = file_get_contents( $i );

				try {
					$data = InventarioScripts::csvActualizarRAM( $equipoId, $equipoInfoId, $i, $j, $k, $l );
					
					$print .= "<br/><br/>" . $data['resumen'];

					/*
					 * Info de Inventario
					 */
					$mayorLegacyNumber = Utils::tomarElMayor( $mayorLegacyNumber, $data['legacyNumber'] );

					$old_ramIds = $data['oldRamIds'];

				} catch (\Exception $e) {
					View::set("no_ram", $e -> getMessage() );
				}
			}

			if ( $bHD ){
				/*****************************************************************************************
				 *  d)  Hard drives.csv
				 */
				$m = $_FILES["Hard_drives"]["tmp_name"];
				$n = $_FILES["Hard_drives"]["name"];
				$o = $_FILES["Hard_drives"]["size"];
				$p = file_get_contents( $m );

				try {
					$data = InventarioScripts::csvActualizarHardDrives( $equipoId, $equipoInfoId, $m, $n, $o, $p );
					
					$print .= "<br/><br/>" . $data['resumen'];

					/*
					 * Info de Inventario
					 */
					$mayorLegacyNumber = Utils::tomarElMayor( $mayorLegacyNumber, $data['legacyNumber'] );

					$old_hdIds = $data['oldHDIds'];

				} catch (\Exception $e) {
					View::set("no_hard_drives", $e -> getMessage() );
				}
			}

			if ( $bSm ){
				/*****************************************************************************************
				 *  e)  SMART.csv
				 */
				$q = $_FILES["SMART"]["tmp_name"];
				$r = $_FILES["SMART"]["name"];
				$s = $_FILES["SMART"]["size"];
				$t = file_get_contents( $q );

				try {
					$data = InventarioScripts::csvActualizarSMART( $equipoId, $equipoInfoId, $q, $r, $s, $t );
					
					$print .= "<br/><br/>" . $data['resumen'];

					/*
					 * Info de Inventario
					 */
					$mayorLegacyNumber = Utils::tomarElMayor( $mayorLegacyNumber, $data['legacyNumber'] );

					$old_smartIds = $data['oldSmartIds'];

				} catch (\Exception $e) {
					View::set("no_SMART", $e -> getMessage() );
				}
			}

			if ( $bLU ){
				/*****************************************************************************************
				 *  f)  LocalUsers.csv
				 */
				$q = $_FILES["LocalUsers"]["tmp_name"];
				$r = $_FILES["LocalUsers"]["name"];
				$s = $_FILES["LocalUsers"]["size"];
				$t = file_get_contents( $q );

				try {
					$data = InventarioScripts::csvActualizarLocalUsers( $equipoId, $equipoInfoId, $q, $r, $s, $t );
					
					$print .= "<br/><br/>" . $data['resumen'];

					/*
					 * Info de Inventario
					 */
					$mayorLegacyNumber = Utils::tomarElMayor( $mayorLegacyNumber, $data['legacyNumber'] );

					$old_localUsersIds = $data['oldLocalUsersIds'];

				} catch (\Exception $e) {
					View::set("no_LocalUsers", $e -> getMessage() );
				}
			}
			
			if ( $bSo ){
				/*****************************************************************************************
				 *  g)  Sound.csv
				 */
				$u = $_FILES["Sound"]["tmp_name"];
				$v = $_FILES["Sound"]["name"];
				$w = $_FILES["Sound"]["size"];
				$x = file_get_contents( $u );

				try {
					$data = InventarioScripts::csvActualizarSound( $equipoId, $equipoInfoId, $u, $v, $w, $x );
					
					$print .= "<br/><br/>" . $data['resumen'];

					/*
					 * Info de Inventario
					 */
					$mayorLegacyNumber = Utils::tomarElMayor( $mayorLegacyNumber, $data['legacyNumber'] );

					$old_soundIds = $data['oldSoundIds'];

				} catch (\Exception $e) {
					View::set("no_Sound", $e -> getMessage() );
				}
			}

			if ( $bNet ){
				/*****************************************************************************************
				 *  h)  Networking.csv
				 */
				$y = $_FILES["Networking"]["tmp_name"];
				$z = $_FILES["Networking"]["name"];
				$aa= $_FILES["Networking"]["size"];
				$bb= file_get_contents( $y );

				try {
					$data = InventarioScripts::csvActualizarNetworking( $equipoId, $equipoInfoId, $y, $z, $aa, $bb );
					
					$print .= "<br/><br/>" . $data['resumen'];

					/*
					 * Info de Inventario
					 */
					$mayorLegacyNumber = Utils::tomarElMayor( $mayorLegacyNumber, $data['legacyNumber'] );

					$old_networkingIds = $data['oldNetworkingIds'];

				} catch (\Exception $e) {
					View::set("no_Networking", $e -> getMessage() );
				}
			}

			if ( $bVi ){
				/*****************************************************************************************
				 *  i)  Video.csv
				 */
				$y = $_FILES["Video"]["tmp_name"];
				$z = $_FILES["Video"]["name"];
				$aa= $_FILES["Video"]["size"];
				$bb= file_get_contents( $y );

				try {
					$data = InventarioScripts::csvActualizarVideo( $equipoId, $equipoInfoId, $y, $z, $aa, $bb );
					
					$print .= "<br/><br/>" . $data['resumen'];

					/*
					 * Info de Inventario
					 */
					$mayorLegacyNumber = Utils::tomarElMayor( $mayorLegacyNumber, $data['legacyNumber'] );

					$old_videoIds = $data['oldVideoIds'];

				} catch (\Exception $e) {
					View::set("no_Video", $e -> getMessage() );
				}
			}

			if ( $bOS ){
				/*****************************************************************************************
				 *  j)  OS.csv
				 */
				$cc= $_FILES["OS"]["tmp_name"];
				$dd= $_FILES["OS"]["name"];
				$ee= $_FILES["OS"]["size"];
				$ff= file_get_contents( $cc );

				try {
					if ( $bCPU ){
						/* si se actualizó CPU, estos valores se añadirán a lo que se acabó de actualizar */
						$tipo = "concat";
					} else {
						/* si solo se actualizó OS.csv entonces se tendrá solo ésta info como la +reciente */
						$tipo = "new";
					}

					$data = InventarioScripts::csvActualizarOS( $equipoId, $equipoInfoId, $cc, $dd, $ee, $ff, $tipo );
					
					$print .= "<br/><br/>" . $data['resumen'];

					/*
					 * Info de Inventario
					 */
					$mayorLegacyNumber = Utils::tomarElMayor( $mayorLegacyNumber, $data['legacyNumber'] );

					$old_OsIds = $data['oldOSId'];

				} catch (\Exception $e) {
					View::set("no_OS", $e -> getMessage() );
				}
			}

			if ( $bSof ){
				/*****************************************************************************************
				 *  k)  Software.csv
				 */
				$gg= $_FILES["Software"]["tmp_name"];
				$hh= $_FILES["Software"]["name"];
				$ii= $_FILES["Software"]["size"];
				$jj= file_get_contents( $gg );

				try {
					$data = InventarioScripts::csvActualizarSoftware( $equipoId, $equipoInfoId, $gg, $hh, $ii, $jj);
					
					$print .= "<br/><br/>" . $data['resumen'];

					/*
					 * Info de Inventario
					 */
					$mayorLegacyNumber = Utils::tomarElMayor( $mayorLegacyNumber, $data['legacyNumber'] );

					$old_SoftwareIds = $data['oldSoftwareId'];

				} catch (\Exception $e) {
					View::set("no_Software", $e -> getMessage() );
				}
			}


			/*
			 * 3.- INSERT into EquipoInfoHistorial los ID's que apuntan a la INFO VIEJA
			 */
			$count = Equipos::insertInventarioHistorial($equipoId, $equipoInfoId, $mayorLegacyNumber,
					$old_cpuId, $old_mbId, 
					$old_ramIds, $old_hdIds, $old_smartIds, $old_localUsersIds, $old_soundIds,
					$old_networkingIds, $old_videoIds, $old_OsIds, $old_SoftwareIds );

			if ( $count != 1 ){
				$print .= "<br/><br/><b>Error en la Insercion en el Historial de Inventariado</b>: Causa: " . $count;

				Transaccion::insertTransaccionEquipo($tipoTransaccion, "Not_Ok", $techId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'], $print , $equipoId);
			}

			/**/
			$info = "CPU:$bCPU | RAM:$bRAM | HD:$bHD | Sm:$bSm | LU:$bLU | Sof:$bSof | MB:$bMB | So:$bSo | Net:$bNet | Vi:$bVi | OS:$bOS";
			Transaccion::insertTransaccionEquipo($tipoTransaccion, "Ok", $techId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'], $info , $equipoId);

			
			/* VISTA */
			$opcionMenu = "resultado_inventario_actualizacion";
			View::set("opcionMenu", $opcionMenu);

			View::set("resultado", $print);

			View::render( "portal_tech_home" );
		}
	}

	/**
	 * para buscar
	 * @param GET una opcion: {"personas", "empresas", "equipos", "incidencias"}
	 */
	public static function buscar($opcion){

		session_start();

		$tech   = $_SESSION['logged_user'];
		$techId = $tech->id;
		View::set("user", $tech );

		View::set("pageTitle", "Buscar en el Sistema...");

		/**/
		$tipoEquipos = Equipos::getAllTipoEquipos();
		View::set("tipoEquipos", $tipoEquipos);

		/* combobox */
		$fallas = Clients::getFallasGenerales();
		View::set("fallas", $fallas);

		/* VISTA */
		$opcionMenu = "busqueda_general";
		View::set("opcionMenu", $opcionMenu);

		View::set("opcion", $opcion);

		View::render( "portal_tech_home" );
	}


	/**
	 * Viene del metodo buscar($opcion)
	 */
	public static function busqueda_general(){

		session_start();

		$tech   = $_SESSION['logged_user'];
		$techId = $tech->id;
		View::set("user", $tech );

		View::set("pageTitle", "Resultados de Búsqueda en el Sistema...");

		if ( isset( $_POST["search_type"] ) ){

			$opcion = $_POST["search_type"];
			View::set("opcion", $opcion);

			if ( $opcion == "personas" ){

				/*************************************************************************************/
				$search = $_POST["searchPersons"];

				if ( strlen($search) >= 3 ){
					$usuarios = UserAdmin::searchUsers2( $search );
					View::set("people", $usuarios);
				}

				View::set("searchedPersons", $search);

			} else if ( $opcion == "empresas" ){

				/*************************************************************************************/
				$search = $_POST["searchCompanies"];

				if ( strlen($search) >= 3 ){
					$companies = Empresas::searchCompanies( $search );
					View::set("companies", $companies);
				}

				View::set("searchedCompanies", $search);

			} else if ( $opcion == "equipos" ){

				/*************************************************************************************/
				$search = "" . $_POST["searchEquipos"];

				if ( strlen($search) >= 3 ){
					
					$tipoEquipo = $_POST["tipo_equipo"];
					if ( $tipoEquipo == "none" ){
						$tipoEquipo = "0";
					}

					$equipment = Equipos::searchEquipos2($search, $tipoEquipo);
					View::set("equipment", $equipment);
				}
				
				View::set("searchedEquipos", $search);

			} else if ( $opcion == "incidencias" ){

				/*************************************************************************************/
				$search 		= $_POST["searchIncidencias"];
				$tipoBusqueda 	= "" . $_POST["search_incidencia_type"];
				$tipoFalla 		= ""; 
				
				if ( $tipoBusqueda == "2" || $tipoBusqueda == "3" ){
					$tipoFalla 	= $_POST["tipo_falla"];
					if ( $tipoFalla == "none" ){
						$tipoFalla = "0";
					}
				}

				if ( ($tipoBusqueda == "1" && is_numeric($search))
						|| ( ($tipoBusqueda == "2" || $tipoBusqueda == "3") && strlen($search) >= 3)
						|| ($tipoBusqueda == "4" && strlen($search) >= 12 && Tecnicos::verificarFechasBusquedaIncidencias($search)) ){

					$incidencias = Incidencias::searchIncidencias($tipoBusqueda, $search, $tipoFalla);
					View::set("incidencias", $incidencias);
				}

				View::set("searchedIncidencias", 	$search);
				View::set("searchedTipoIncidencia", $tipoFalla);
				View::set("searchedTipo1al4", 		"" . $tipoBusqueda);
			}
		}

		/* VISTA */
		$opcionMenu = "busqueda_general";
		View::set("opcionMenu", $opcionMenu);

		/**/
		$tipoEquipos = Equipos::getAllTipoEquipos();
		View::set("tipoEquipos", $tipoEquipos);

		/* combobox */
		$fallas = Clients::getFallasGenerales();
		View::set("fallas", $fallas);

		View::render( "portal_tech_home" );
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

			$tipoEquipo = $_POST['tipoEquipo'];
			View::set("tipoEquipo", $tipoEquipo);


			$equipoInfoId = $_POST['equipoInfoId'];
			
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

		View::render( "portal_tech_home" );
	}

	/**
	 * Debe usarse para la "Busqueda de Inciencias" - menú BUSCAR
	 * @param $literalConFechas debe venir así: 
	 * A 2017-02-31
	 * B 2017-02-31
	 * C 2017-02-01 2017-02-31
	 * D 2017-02-01 2017-02-31
	 */
	static function verificarFechasBusquedaIncidencias($literalConFechas){

		$a = trim($literalConFechas);

		if ( Utils::startsWith($a, "A") || Utils::startsWith($a, "B") 
				|| Utils::startsWith($a, "C") || Utils::startsWith($a, "D") ){

			if ( Utils::startsWith($a, "A") || Utils::startsWith($a, "B") ){

				if ( strlen($a) == 12 ){
					list($letra, $fecha1) = split('[ ]', $a);

					if ( strlen($letra) == 1 && strlen($fecha1) == 10 ){
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}

			} else if ( Utils::startsWith($a, "C") || Utils::startsWith($a, "D") ){
				
				if ( strlen($a) == 23 ){
					list($letra, $fecha1, $fecha2) = split('[ ]', $a);

					if ( strlen($letra) == 1 && strlen($fecha1) == 10 && strlen($fecha2) == 10 ){
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}


	/**
	 * Esta opción se deberá usar para GENERAR un Reporte cuando un Tecnico visita una Empresa
	 * FUTURE-FUNCTION PENDIENTE :: Esta opción deberá enñazarse cuando se generen CITAS de SOPORTE
	 * en cuyo caso cada CITA deberá generar automáticamente "una nueva incidencia" (un Reporte de Visita)
	 * -- se muestra el formulario --
	 */
	public static function generarReporte(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Crear un Nuevo Reporte de Visita");

		/* VISTA */
		$opcionMenu = "crearReporteVisita";
		View::set("opcionMenu", $opcionMenu);

		/* FASE: parte del proceso */
		View::set("procesoParte", "Inicio");


		if ( isset( $_POST["searchCompanies"] ) ){

			$search = $_POST["searchCompanies"];

			if ( strlen($search) >= 3 ){
				$companies = Empresas::searchCompanies( $search );
				View::set("companies", $companies);
			}

			View::set("searchedCompanies", $search);

			View::set("procesoParte", "Seleccion_Empresa");
		}

		View::render( "portal_tech_home" );
	}

	/**
	 * Una vez se selecciona la Empresa, muestra formulario para CREAR Reportes de Visita
	 */
	public static function empresa_reporte_visita(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		if ( isset( $_POST['seleccionarEmpresaID'] ) ){

			/*
			 * NO buscar info de la Empresa, setearla de la pantalla ANTERIOR
			 */
			$empresaId = $_POST['seleccionarEmpresaID'];
			View::set("searchedCompanyId", $empresaId );

			$company = $_POST['seleccionarEmpresaNombre'];
			View::set("pageTitle", "Nuevo Reporte de Visita para " . $company);


			if ( $_POST['seleccionarEmpresaRazonsocial'] != NULL && $_POST['seleccionarEmpresaRazonsocial'] != "" ){
				$company .= " ( " . $_POST['seleccionarEmpresaRazonsocial'] . " )";
			}

			if ( $_POST['seleccionarEmpresaNIT'] != NULL && $_POST['seleccionarEmpresaNIT'] != ""  ){
				$company .= ". NIT: " . $_POST['seleccionarEmpresaNIT'];
			}

			View::set("companyInfo", $company);
			View::set("empresaDireccion", $_POST['seleccionarEmpresaDireccion']);
			View::set("empresaCantidadEquipos", $_POST['seleccionarEmpresaCantEquipos']);

			/* combobox: Usuarios todos */
			$usuarios = UserAdmin::getUsuariosDeEmpresa( $empresaId, true);

			if ( $usuarios == NULL || $usuarios == "" ){
				View::set("no_usuarios", "no_usuarios");
			} else {
				View::set("usuarios", $usuarios);
			}

			/* Equipo(s) de este Usuario (SI ES QUE TIENE) */		
			$equipos = Equipos::getEquiposDeEmpresa( $empresaId );

			if ( $equipos == NULL || $equipos == "" ){
				View::set("no_equipos", "no_equipos");
			} else {
				View::set("equipos", $equipos);
			}

			/* VISTA */
			$opcionMenu = "nuevoReporteVisita";
			View::set("opcionMenu", $opcionMenu);

			View::render( "portal_tech_home" );
		}
	}

	/**
	 * Viene del formulario nuevoReporteVisita
	 * Dejará las Incidencias en el LISTADO DEL TÉCNICO
	 */
	public static function crear_reporte_visita(){

		session_start();

		$tech = $_SESSION['logged_user'];

		View::set("user", $tech );
		
		if ( isset( $_POST['quantity'] ) ){

			$cantidad = $_POST['quantity'];
			$userId   = $_POST['givenname'];
			$equipoId = $_POST['equipo'];
			$empresaId= $_POST['empresaID'];

			$tipoReporteForm = $_POST['reporte_general_check'];
			if ( $tipoReporteForm == "true" ){
				$tipoReporte = true;
			} else {
				$tipoReporte = false;
			}
			
			$result = Incidencias::insertReporteVisita($tech, $empresaId, $userId, $equipoId, $cantidad, $tipoReporte );

			/*
			 * Resultados para mostrar en pantalla MODAL del HOME
			 */
			if ( $result["quantity"] > 0 ) {
				View::set("incidencia_cerrada_correctamente", 			"Reportes de Visitas creados");
				View::set("incidencia_cerrada_correctamente_titulo", 	"Se crearon " . $result["quantity"] . " Reporte(s) de Visita correctamente");
				View::set("incidencia_cerrada_correctamente_footer", 	'Para revisar los Reportes de Visitas verifique en Su Listado de Incidencias Pendientes (NO son Incidencias, pero el Formato de Trabajo a llenar es el mismo).');

			} else {
				View::set("incidencia_cerrada_correctamente", 			"Reportes de Visitas NO creados");
				View::set("incidencia_cerrada_correctamente_titulo", 	"Se encontró un ERROR al tratar de crear los Reportes:");
				View::set("incidencia_cerrada_correctamente_footer", 	$result["error"]);
			}
		}

		Tecnicos::startTech( $tech );
	}

	/**
	 * mostrar el formulario para actualizar el Equipo
	 */
	public static function actualizar_equipo(){

		session_start();

		$tech = $_SESSION['logged_user'];

		View::set("user", $tech );

		if ( isset( $_POST['equipoId'] ) ){

			View::set("pageTitle", "Editar el Equipo #" . $_POST['equipoId'] );

			$equipo = Equipos::getById( $_POST['equipoId'] );
			View::set("equipo", $equipo);

			$perifericos = Equipos::getPerifericos( $_POST['equipoId'] );

			if ( $perifericos == NULL || $perifericos == "" ){
				View::set("no_perifericos", "no_perifericos");
			} else {
				View::set("perifericos", $perifericos);
			}

			$tipoEquipos = Equipos::getAllTipoEquipos();
			View::set("tipoEquipos", $tipoEquipos);

			$perifericosTodos = Clients::getPerifericos();
			View::set("perifericosTodos", $perifericosTodos);

			$empresa = $_POST['Empresa'];
			View::set("empresaNombre", $empresa);

			$usuario = trim( $_POST['Nombre'] );
			View::set("usuarioNombre", $usuario);
		}

		/* VISTA */
		$opcionMenu = "actualizar_equipo";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_tech_home" );
	}

	/**
	 * Viene del formulario actualizar_equipo()
	 * se puede actualizar LA DATA DEL EQUIPO, los PERIFERICOS del mismo; o AMBOS
	 */
	public static function actualizacion_equipo(){

		session_start();

		$tech = $_SESSION['logged_user'];
		$techId = $tech->id;

		View::set("user", $tech );

		if ( isset( $_POST['equipoId'] ) ){

			$equipoId = $_POST['equipoId'];
			View::set("pageTitle", "Editando el Equipo # $equipoId" );

			$usuarioId = $_POST['usuarioId'];

			$empresaId = $_POST['empresaId'];

			$tipoTransaccion = "Tecnico_Actualizar_Inventario";

			$cambioRealizado = false; $message1 = "";
			$cambioRealizadoPerifericos = false; $message2 = "";

			/*
			 * Confirmando si hubo cambios en el Equipo
			 */
			if ( $_POST['cambios'] == "true" ){
				
				$data = Tecnicos::obtenerDataDelFormularioEquipo();

				$count = Equipos::actualizarEquipo($equipoId, $data);

				if ( $count == 1 ){
					$info = "EQUIPO_ACTUALIZADO por techId:".$techId;
					Transaccion::insertTransaccionEquipo($tipoTransaccion, "Ok", $techId, $_SESSION['role_user'], $empresaId , $info , $equipoId);
					
					$cambioRealizado = true;
					$message1 = "Se realizaron los cambios del Equipo exitosamente.";

				} else {
					$info = "toEmpresa:".$empresaId.", toUser:".$usuarioId.", techId:".$techId.", count_NOT_1: $count - EQUIPO_NO_ACTUALIZADO - actualizacion_equipo()";
					Transaccion::insertTransaccionEquipo($tipoTransaccion, "Not_Ok", $techId, $_SESSION['role_user'], $empresaId , $info , $equipoId);

					/* NO actualizado */
					$cambioRealizado = true;
					$message1 = "NO se guardaron los cambios, hubo inconvenientes en la Base de Datos. Por favor, intente más tarde.";
				}
			}

			/*
			 * Confirmando si hubo cambios en los Periféricos del Equipo
			 */
			$count2 = 0;
			if ( $_POST['periferico_cambios'] == "true" ){

				$perifericos = Tecnicos::obtenerPerifericosDelFormularioEquipo();

				$cambioRealizadoPerifericos = false;

				$count2 = Equipos::actualizarPerifericos($equipoId, $perifericos);

				if ( $count2 > 0 ){
					$message2 = "Se realizaron ".$count2." cambios en los Periféricos de este Equipo exitosamente.";
				} else {
					$message2 = "NO se guardaron los cambios de Periféricos, hubo inconvenientes en la Base de Datos. Por favor, intente más tarde.";
				}
			}

			/*
			 * Volviendo a la misma pantalla pero notificando el cambio
			 */
			$equipo = Equipos::getById( $equipoId );
			View::set("equipo", $equipo);

			$perifericos = Equipos::getPerifericos( $equipoId );

			if ( $perifericos == NULL || $perifericos == "" ){
				View::set("no_perifericos", "no_perifericos");
			} else {
				View::set("perifericos", $perifericos);
			}

			$tipoEquipos = Equipos::getAllTipoEquipos();
			View::set("tipoEquipos", $tipoEquipos);

			$perifericosTodos = Clients::getPerifericos();
			View::set("perifericosTodos", $perifericosTodos);

			$empresa = $_POST['empresaNombre'];
			View::set("empresaNombre", $empresa);

			$usuario = trim( $_POST['usuarioNombre'] );
			View::set("usuarioNombre", $usuario);

			View::set("cambioRealizado", $cambioRealizado);
			View::set("cambioRealizado_message", $message1);

			View::set("cambioRealizadoPerifericos", $cambioRealizadoPerifericos);
			View::set("cambioRealizadoPerifericos_message", $message2);

			/* VISTA */
			$opcionMenu = "actualizar_equipo";
			View::set("opcionMenu", $opcionMenu);

			View::render( "portal_tech_home" );
		}
	}


	/**
	 * Obteniendo data del Formulario CREAR ó ACTUALIZAR Equipo
	 */
	public static function obtenerDataDelFormularioEquipo(){

		$tipoEquipo = $_POST['tipo_equipo'];
			
		/* To protect MySQL injection for Security purpose */
		$nombre          = stripslashes($_POST['equipoName']);
		$dependencia     = stripslashes($_POST['dependencia']);
		$marca           = stripslashes($_POST['marca']);
		$modelo          = stripslashes($_POST['modelo']);
		$serial          = stripslashes($_POST['serial']);
		
		$teamViewerID    = stripslashes($_POST['teamViewerID']);
		$teamViewerClave = stripslashes($_POST['teamViewerClave']);
		$conexion        = stripslashes($_POST['remota']);
		$clave           = stripslashes($_POST['clave']);
		$observaciones   = stripslashes($_POST['observaciones']);
		$linkDeFoto      = stripslashes($_POST['link']);
		$valor           = stripslashes($_POST['costo']);
		$reposicion      = stripslashes($_POST['reposicion']);

		$windows         = $_POST['windows'];
		$office          = $_POST['office'];
		$hdd             = $_POST['hdd'];

		$SOtipo 		 = $_POST['sistemaOperativo'];
		$SOversion 		 = stripslashes($_POST['versionSO']);
		$SOnombre 		 = stripslashes($_POST['nombreSO']);

		/*
		 * por motivos de conveniencia, se creará un objeto que albergue la data entera
		 */
		$data[ 0] = $nombre;
		$data[ 1] = $dependencia;
		$data[ 2] = $marca;
		$data[ 3] = $modelo;
		$data[ 4] = $serial;
		$data[ 5] = $tipoEquipo;
		$data[ 6] = $teamViewerID;
		$data[ 7] = $teamViewerClave;
		$data[ 8] = $conexion;
		$data[ 9] = $clave;
		$data[10] = $valor;
		$data[11] = $reposicion;
		$data[12] = $observaciones;
		$data[13] = $linkDeFoto;
		$data[14] = $windows;
		$data[15] = $office;
		$data[16] = $hdd;
		$data[17] = $SOtipo;
		$data[18] = $SOversion;
		$data[19] = $SOnombre;

		return $data;
	}


	/**
	 * Obteniendo data del Formulario CREAR ó ACTUALIZAR Equipo: solo los PERIFERICOS
	 */
	public static function obtenerPerifericosDelFormularioEquipo(){

		/* obteniendo los datos de la tabla dinámica */
		$cantidad 		= $_POST['cantidad_perifericos'];
		$nombres 		= $_POST['periferico_componente'];
		$marcas 		= $_POST['periferico_marca'];
		$seriales 		= $_POST['periferico_codigo'];
		$descripciones  = $_POST['periferico_observaciones'];

		$perifericos[0] = $cantidad;
		$perifericos[1] = $nombres;/* Vienen los ID's de la tabla TipoPerifericos */
		$perifericos[2] = $marcas;
		$perifericos[3] = $seriales;
		$perifericos[4] = $descripciones;

		return $perifericos;
	}

	/**
	 * Mostrar el Calendario en forma de listado
	 */ 
	public static function listado_soportes(){
		
		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Soportes IT - Listado");

		$futuros = Soportes::getCitasPendientes(0);
		
		if ( $futuros != null && $futuros != "" ){
			View::set("citasPendientes", $futuros );
		} else {
			View::set("no_citasPendientes", "no_citasPendientes" );
		}

		$pasadas = Soportes::getCitasPreviasAnyoActual(0);
		
		if ( $pasadas != null && $pasadas != "" ){
			View::set("citasPasadas", $pasadas );
		} else {
			View::set("no_citasPasadas", "no_citasPasadas" );
		}
		
		/* VISTA */
		$opcionMenu = "agenda_listado";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_tech_home" );
	}

	/**
	 * Meramente informativa: que significan los CODIGOS
	 */ 
	public static function info_codigos(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Códigos de Equipos");

		$codigos = Clients::getInfoCodigos();
		View::set("codigos", $codigos);

		/* VISTA */
		$opcionMenu = "info_codigos";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_tech_home" );
	}


	/**
	 * mostrar Formulario para tecnicos
	 */
	public static function historialEquipo_buscarEmpresa(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Buscar Empresa...");
		
		/* VISTA */
		$opcionMenu = "historialEquipo_buscarEmpresa";
		View::set("opcionMenu", $opcionMenu);

		/* FASE: parte del proceso */
		View::set("procesoParte", "Busqueda_Empresa");

		View::render( "portal_tech_home" );
	}


	/**
	 * mostrar Formulario para tecnicos
	 */
	public static function historialEquipo_seleccionarEmpresa(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Seleccione Empresa... ");

		/* VISTA */
		$opcionMenu = "historialEquipo_buscarEmpresa";
		View::set("opcionMenu", $opcionMenu);

		/* FASE INICIAL: parte del proceso */
		View::set("procesoParte", "Busqueda_Empresa");

		if ( isset( $_POST['searchCompany'] ) ){

			$search = stripslashes( $_POST['searchCompany'] );
			View::set("searchedCompany", $search);
			
			if ( strlen($search) >= 3 ){

				/* FASE: parte del proceso */
				View::set("procesoParte", "Seleccion_Empresa");				

				/*
				 * Buscando TODAS las Empresas que coincidan con este texto
				 */
				$companies = Empresas::searchCompanies( $search );

				View::set("companies", $companies);
			}
		}
		View::render( "portal_tech_home" );
	}


	/**
	 * Buscar el Historial de las cosas hechas a Equipos
	 */
	public static function historialEquipos(){

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user );

		View::set("pageTitle", "Trabajos realizados sobre los Equipos de esta Empresa");

		if ( isset( $_POST['seleccionarEmpresaID'] ) ){

			$empresaId = $_POST['seleccionarEmpresaID'];
			
			/* Equipo(s) de la EMPRESA */
			$inventarioEquipos = Equipos::getEquiposDeEmpresaConTipoEquipo( $empresaId );

			if ( $inventarioEquipos == NULL || $inventarioEquipos == "" ){
				View::set("no_equipos", "no_equipos");

			} else {

				$resultado2 = Equipos::getHistorialEquipos($inventarioEquipos);

				View::set("cantidad_equipos", $resultado2[0]);
				View::set("equipos_info", 	  $resultado2[1]);
			}
		}

		/* VISTA */
		$opcionMenu = "historial_equipos";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_tech_home" );
	}

	/**
	 * Mostrar Formulario de lev. manual de info inventario
	 */
	public static function inventario_manual(){

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user );

		View::set("pageTitle", "Lev. manual de info");

		if ( isset( $_POST['newEquipoId'] ) ){

			$equipoId = $_POST['newEquipoId'];
			View::set("equipoId", $equipoId);

			View::set("newEquipoCodBarras", $_POST["newEquipoCodBarras"] );
			View::set("infoEmpresaUsuario", $_POST["infoEmpresaUsuario"] );
		}

		/* VISTA */
		$opcionMenu = "inventario_manual";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_tech_home" );
	}


	/**
	 * Mostrar Formulario de lev. manual de info inventario
	 */
	public static function inventario_manual_crear(){

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user );

		View::set("pageTitle", "Actualizando el Equipo");

		/*
		 * Al crearlo desde cero, no pide equipoInfoId
		 */
		if ( isset( $_POST['equipoId'] ) ){
			
			$equipoId = $_POST['equipoId'];
			View::set("equipoId", $equipoId );

			$equipoBarras = $_POST['equipoBarras'];
			View::set("equipoBarras", $equipoBarras );

			/*
			 * 1.- Leer formulario
			 */
			$nombreWindows   = stripslashes( $_POST['nombreWindows1'] );
			$so              = stripslashes( $_POST['linux'] );
			$versionOffice   = stripslashes( $_POST['versionOffice'] );
			$marcaProcesador = stripslashes( $_POST['marcaProcesador'] );
			$referenciaCPU   = stripslashes( $_POST['referenciaCPU'] );
			$velocidadCPU    = stripslashes( $_POST['velocidadCPU'] );
			$socket          = stripslashes( $_POST['socket'] );
			$nucleos         = $_POST['nucleos'];
			$arquitectura    = $_POST['arquitectura'];
			$cache           = stripslashes( $_POST['cache'] );
			$referenciaMB    = stripslashes( $_POST['referenciaMB'] );
			$marcaMB         = stripslashes( $_POST['marcaMB'] );

			/* RAM's */
			$cantidadRAMs   = $_POST['cantidadRAMs'];
			$ram_tipo       = $_POST['ram_tipo'];
			$ram_tamanyoGb  = $_POST['ram_tamanyo'];
			$ram_velocidad  = $_POST['ram_velocidad'];

			/* HDD's */
			$cantidadHDDs  = $_POST['cantidadHDDs'];
			$hdd_marca     = $_POST['hdd_marca'];
			$hdd_tamanyoGb = $_POST['hdd_tamanyo'];
			$hdd_velocidad = $_POST['hdd_velocidad'];
			$hdd_horasuso  = $_POST['hdd_horasuso'];
			$hdd_interfaz  = $_POST['hdd_interfaz'];

			try {
				/*
				 * 3.- Insertar INVENTARIO Manual del CPU
				 */
				$cpuId = Equipos::manualCPU( $marcaProcesador, $referenciaCPU,
						$velocidadCPU, $nucleos, $arquitectura, $cache, 0 );


				/* 
				 * 4.- Meter en IMotherboard
				 */
				$motherboardId = Equipos::manualMotherboard( $referenciaMB, $marcaMB, 0 );

				/*
				 * 5.- Insertar INVENTARIO con los ID's A_I de las tablas INVENTARIO
				 */
				$equipoInfoId = Equipos::insertEquipoInfo2( $cpuId, $motherboardId );


				/* 
				 * 6.- Meter el resto de la data
				 */

				/* RAM */
				$ram = Equipos::manualRAM( $equipoInfoId, $cantidadRAMs, $ram_tipo, $ram_tamanyoGb, $ram_velocidad, 0 );

				/* IOS */
				$os = Equipos::manualIOS( $equipoInfoId, $nombreWindows, $so, 0 );
				
				/* IHardDrives */
				$hdd = Equipos::manualHDD( $equipoInfoId, $cantidadHDDs, $hdd_marca, $hdd_tamanyoGb, $hdd_interfaz, 0 );

				/* Meter en ISMART */
				$smart = Equipos::manualSMART( $equipoInfoId, $cantidadHDDs, $hdd_marca, $hdd_horasuso, 0 );


				/* XXX FUTURE PENDING estos datos no los trae los .CSV * /
				$hdd_velocidad *;
				$versionOffice * ;<--- este puede que si en el software
				$socket; ---motherboard (opcional)
				*/

				
				$resumen = "Resumen de la Inserción:";

				if ( $cpuId > 0 ){	$resumen .= "<br/>CPU: insertado correctamente";
				} else {			$resumen .= "<br/>CPU: NO insertado";
				}
				/**/
				if ( $motherboardId > 0 ){	$resumen .= "<br/>Motherboard: insertado correctamente";
				} else {					$resumen .= "<br/>Motherboard: NO insertado";
				}
				/**/
				/**/
				if ( $ram > 0 ){	$resumen .= "<br/>RAM: insertado correctamente. Total: $ram unidades.";
				} else {			$resumen .= "<br/>RAM: NO insertado";
				}
				/**/
				if ( $hdd > 0 ){	$resumen .= "<br/>Discos Duros: insertado(s) correctamente. Total: $hdd unidades.";
				} else {			$resumen .= "<br/>Discos Duros: NO insertados";
				}
				/**/
				if ( $smart > 0 ){	$resumen .= "<br/>SMART: insertado correctamente: $hdd_horasuso Horas de Uso.";
				} else {			$resumen .= "<br/>SMART: NO insertado";
				}

				/*
				 * Actualizar Equipo
				 */
				$count = Equipos::updateEquipoConInventario($equipoId, $equipoInfoId);

				if ( $count == 1 ){
					$resumen .= "<br/>Info asociada correctamente a Equipo nuevo.";
				} else {
					$resumen .= "<br/><br/><b>Asociación incorrecta de Inventario nuevo con Equipo</b>. "
							. "Comuníquese con Área de Soporte."
							. "Detalles: ERROR #006  ErrorPHP|Tecnicos.php|inventario_manual_crear()| NO se asoció Inventario manual Nuevo con Equipo|$equipoId NO asociado a $equipoInfoId "
							;
				}

				View::set("resumen", $resumen);


			} catch (\Exception $e) {
				View::set("Exception", "Ocurrió un Error al intentar ingresar la data del Formulario. Detalle: " . $e -> getMessage() );
			}
		}

		/* VISTA */
		$opcionMenu = "resultado_inventario_manual";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_tech_home" );
	}



	/**
	 * Mostrar Formulario de lev. manual de info inventario
	 */
	public static function inventario_manual_actualizar(){

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user );

		View::set("pageTitle", "Lev. manual de info");

		if ( isset( $_POST['equipoId'] ) ){

			$equipoId = $_POST['equipoId'];
			View::set("equipoId", $equipoId);
			
			$equipoInfoId = $_POST['equipoInfoId'];
			View::set("equipoInfoId", $equipoInfoId);

			View::set("infoEmpresaUsuario", $_POST["infoEmpresaUsuario"] );

			/* recuperar codeBar */
			$codBarras = Equipos::getById($equipoId);
			View::set("newEquipoCodBarras", $codBarras["codigoBarras"] );

			/* debe redirigir a ACTUALIZAR */
			View::set("redirigirA", "inventario_manual_actualizar_data" );		
		}

		/* VISTA */
		$opcionMenu = "inventario_manual";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_tech_home" );
	}


	/**
	 * Viene del Formulario de lev. manual de info inventario PARA ACTUALIZAR
	 */
	public static function inventario_manual_actualizar_data(){

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user );

		View::set("pageTitle", "Actualizando el Equipo");

		/*
		 * Al actualizarlo, si pide equipoInfoId y deberìa traerlo el form
		 */
		if ( isset( $_POST['equipoId'] ) && isset($_POST['equipoInfoId']) ){
			
			$equipoId = $_POST['equipoId'];
			View::set("equipoId", $equipoId );

			$equipoInfoId = $_POST['equipoInfoId'];

			/*
			 * 1.- Leer formulario
			 */
			$nombreWindows   = stripslashes( $_POST['nombreWindows1'] );
			$so              = stripslashes( $_POST['linux'] );
			$versionOffice   = stripslashes( $_POST['versionOffice'] );
			$marcaProcesador = stripslashes( $_POST['marcaProcesador'] );
			$referenciaCPU   = stripslashes( $_POST['referenciaCPU'] );
			$velocidadCPU    = stripslashes( $_POST['velocidadCPU'] );
			$socket          = stripslashes( $_POST['socket'] );
			$nucleos         = $_POST['nucleos'];
			$arquitectura    = $_POST['arquitectura'];
			$cache           = stripslashes( $_POST['cache'] );
			$referenciaMB    = stripslashes( $_POST['referenciaMB'] );
			$marcaMB         = stripslashes( $_POST['marcaMB'] );

			/* RAM's */
			$cantidadRAMs   = $_POST['cantidadRAMs'];
			$ram_tipo       = $_POST['ram_tipo'];
			$ram_tamanyoGb  = $_POST['ram_tamanyo'];
			$ram_velocidad  = $_POST['ram_velocidad'];

			/* HDD's */
			$cantidadHDDs  = $_POST['cantidadHDDs'];
			$hdd_marca     = $_POST['hdd_marca'];
			$hdd_tamanyoGb = $_POST['hdd_tamanyo'];
			$hdd_velocidad = $_POST['hdd_velocidad'];
			$hdd_horasuso  = $_POST['hdd_horasuso'];
			$hdd_interfaz  = $_POST['hdd_interfaz'];
			

			/* todos los ID's inician en NULL  */
			$old_cpuId = NULL; $old_mbId = NULL;
			$old_ramIds = NULL; $old_hdIds = NULL; $old_smartIds = NULL; $old_localUsersIds = NULL; 
			$old_soundIds = NULL; $old_networkingIds = NULL; $old_videoIds = NULL; $old_OsIds = NULL; $old_SoftwareIds = NULL;

			/* Para insertar en el Historial, se insertará el MAYOR número de Inventariado */
			$mayorLegacyNumber = 0;


			$out = NULL;
			try {
				/*
				 * 2.- Sumar 1 a los LEGACY's actuales de: ICPU, IMotherBoard, IRAM, IHardDrives, ISMART
				 * Obtener los ID's actuales ANTES de la nueva insercion (para el Historial)
				 */
				$out = Tecnicos::actualizarLegacysDeTablasParaFormularioManual($equipoInfoId);

			} catch (\Exception $e) {
				View::set("Exception", "ERROR #007  ErrorPHP|Tecnicos.php|inventario_manual_actualizar_data() / actualizarLegacysDeTablasParaFormularioManual() |Ocurrió un Error al intentar SUMAR 1 a los Legacy.|No se asociò $equipoId con $equipoInfoId |Detalle: " . $e -> getMessage() );
				/* VISTA */
				View::set("opcionMenu", "resultado_inventario_manual");
				View::render( "portal_tech_home" );
			}

			try {
				$mayorLegacyNumber = 0;

				/*
				 * 3.- Insertar INVENTARIO Manual del CPU
				 */
				$LN_CPU = $out[0];
				$cpuId = Equipos::manualCPU( $marcaProcesador, $referenciaCPU,
						$velocidadCPU, $nucleos, $arquitectura, $cache, ($LN_CPU+1) );

				$old_cpuId = $out[1];

				$mayorLegacyNumber = Utils::tomarElMayor( $mayorLegacyNumber, $LN_CPU );

				/* 
				 * 4.- Meter en IMotherboard
				 */
				$LN_MB = $out[2];
				$motherboardId = Equipos::manualMotherboard( $referenciaMB, $marcaMB, ($LN_MB+1) );

				$old_mbId = $out[3];

				$mayorLegacyNumber = Utils::tomarElMayor( $mayorLegacyNumber, $LN_MB );

				/*
				 * 5.- Actualizar INVENTARIO con los ID's A_I de las tablas INVENTARIO
				 */
				$count = Equipos::actualizarEquipoInfo( $equipoInfoId, $cpuId, $motherboardId );

				/* 
				 * 6.- Meter el resto de la data
				 */

				/* RAM */
				$LN_RAM = $out[4];
				$ram = Equipos::manualRAM( $equipoInfoId, $cantidadRAMs, $ram_tipo, $ram_tamanyoGb, $ram_velocidad, ($LN_RAM+1) );

				$old_ramIds = $out[5];

				$mayorLegacyNumber = Utils::tomarElMayor( $mayorLegacyNumber, $LN_RAM );

				/* IHardDrives */
				$LN_HDD = $out[6];
				$hdd = Equipos::manualHDD( $equipoInfoId, $cantidadHDDs, $hdd_marca, $hdd_tamanyoGb, $hdd_interfaz, ($LN_HDD+1) );

				$old_hdIds = $out[7];

				$mayorLegacyNumber = Utils::tomarElMayor( $mayorLegacyNumber, $LN_HDD );

				/* ISMART */
				$LN_SMART = $out[8];
				$smart = Equipos::manualSMART( $equipoInfoId, $cantidadHDDs, $hdd_marca, $hdd_horasuso, ($LN_SMART+1) );

				$old_smartIds = $out[9];

				$mayorLegacyNumber = Utils::tomarElMayor( $mayorLegacyNumber, $LN_SMART );

				/* IOS */
				$LN_IOS = $out[10];
				$os = Equipos::manualIOS( $equipoInfoId, $nombreWindows, $so, ($LN_IOS+1) );

				$old_OsIds = $out[11];

				$mayorLegacyNumber = Utils::tomarElMayor( $mayorLegacyNumber, $LN_IOS );


				/* XXX FUTURE PENDING estos datos no los trae los .CSV * /
				$hdd_velocidad;
				$versionOffice;<--- este puede que si en el software
				$socket;         
				*/

				$resumen = "Resumen de la Inserción:";

				if ( $cpuId > 0 ){	$resumen .= "<br/>CPU: insertado correctamente";
				} else {			$resumen .= "<br/>CPU: NO insertado";
				}
				/**/
				if ( $motherboardId > 0 ){	$resumen .= "<br/>Motherboard: insertado correctamente";
				} else {					$resumen .= "<br/>Motherboard: NO insertado";
				}
				/**/
				/**/
				if ( $ram > 0 ){	$resumen .= "<br/>RAM: insertado correctamente. Total: $ram unidades.";
				} else {			$resumen .= "<br/>RAM: NO insertado";
				}
				/**/
				if ( $hdd > 0 ){	$resumen .= "<br/>Discos Duros: insertado(s) correctamente. Total: $hdd unidades.";
				} else {			$resumen .= "<br/>Discos Duros: NO insertados";
				}
				/**/
				if ( $smart > 0 ){	$resumen .= "<br/>SMART: insertado correctamente: $hdd_horasuso Horas de Uso.";
				} else {			$resumen .= "<br/>SMART: NO insertado";
				}
				
				View::set("resumen", $resumen);


				/*
				 * 7.- INSERT into EquipoInfoHistorial los ID's que apuntan a la INFO VIEJA
				 */
				$count = Equipos::insertInventarioHistorial($equipoId, $equipoInfoId, $mayorLegacyNumber,
						$old_cpuId, $old_mbId, 
						$old_ramIds, $old_hdIds, $old_smartIds, $old_localUsersIds, $old_soundIds,
						$old_networkingIds, $old_videoIds, $old_OsIds, $old_SoftwareIds );

			} catch (\Exception $e) {
				View::set("Exception", "Ocurrió un Error al intentar ingresar la data del Formulario. Detalle: " . $e -> getMessage() );
			}
		}

		/* VISTA */
		$opcionMenu = "resultado_inventario_manual";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_tech_home" );
	}

	/**
	 * Viene de metodo inventario_manual_actualizar_data()
	 * @return Object [los legacy's numbers de estas tablas / los actuales A_I Id's]
	 * tablas en orden: ICPU, IMotherBoard, IRAM, IHardDrives, ISMART, IOS
	 */
	static function actualizarLegacysDeTablasParaFormularioManual($equipoInfoId){

		$LN_CPU=0; 	$actualCpuId="";
		$LN_MB=0; 	$actualMbId="";
		$LN_RAM=0; 	$actualRamId="";
		$LN_HDD=0; 	$actualHddId="";
		$LN_SMART=0;$actualSmartId="";
		$LN_IOS=0; 	$actualOsId="";

		/*
		 * 1.- Actualizar Legacy a TRUE y obtener el numero actual
 		 */
		$object1 = Equipos::cpuGetLegacyNumberAndSetTrue($equipoInfoId);
		/*
		 * 2.- INSERTAR un nuevo valor en ICPU con LegacyNumber++
		 * - obteniendo primero el MAX_ID
		 */
		$LN_CPU = $object1->legacyNumber;
		$actualCpuId = $object1->cpuId;

		/*
		 * Repetir Proceso para las demàs tablas
		 */

		/* MotherBoard */
		$object2 = Equipos::motherboardGetLegacyNumberAndSetTrue($equipoInfoId);
		
		$LN_MB = $object2->legacyNumber;
		$actualMbId = $object2->motherboardId;

		$LN = 0; $stringIds = "";

		/************************** RAM *************************************/
		$object3 = Equipos::ramGetLegacyNumberAndSetTrue($equipoInfoId);
		
		if ( $object3 != null ){

			$LN = 0; $stringIds = "";

			foreach ( $object3 as $row ){
				/* legacy */
				$LN = Utils::tomarElMayor( $LN, $row[0] );

				/* ID's en forma CSV */
				$stringIds .= $row[1] . ",";
			}

			/* substring el ultimo caracter, eliminar la ultima coma */
			$stringIds = rtrim($stringIds,",");

			$LN_RAM = $LN;
			$actualRamId = $stringIds;
		}

		/************************** HDD *************************************/
		$object4 = Equipos::hardDrivesGetLegacyNumberAndSetTrue($equipoInfoId);
		
		if ( $object4 != null ){

			$LN = 0; $stringIds = "";

			foreach ( $object4 as $row ){
				/* legacy */
				$LN = Utils::tomarElMayor( $LN, $row[0] );

				/* ID's en forma CSV */
				$stringIds .= $row[1] . ",";
			}

			/* substring el ultimo caracter, eliminar la ultima coma */
			$stringIds = rtrim($stringIds,",");

			$LN_HDD = $LN;
			$actualHddId = $stringIds;
		}
		

		/************************** SMART *************************************/
		$object5 = Equipos::smartGetLegacyNumberAndSetTrue($equipoInfoId);
		
		if ( $object5 != null ){

			$LN = 0; $stringIds = "";

			foreach ( $object5 as $row ){
				/* legacy */
				$LN = Utils::tomarElMayor( $LN, $row[0] );

				/* ID's en forma CSV */
				$stringIds .= $row[1] . ",";
			}

			/* substring el ultimo caracter, eliminar la ultima coma */
			$stringIds = rtrim($stringIds,",");

			$LN_SMART = $LN;
			$actualSmartId = $stringIds;
		}
		

		/************************** OS *************************************/
		$object6 = Equipos::osGetLegacyNumberAndSetTrue($equipoInfoId);
		
		if ( $object6 != null ){

			$LN = 0; $stringIds = "";

			foreach ( $object6 as $row ){
				/* legacy */
				$LN = Utils::tomarElMayor( $LN, $row[0] );

				/* ID's en forma CSV */
				$stringIds .= $row[1] . ",";
			}

			/* substring el ultimo caracter, eliminar la ultima coma */
			$stringIds = rtrim($stringIds,",");
			
			$LN_IOS = $LN;
			$actualOsId = $stringIds;
		}
		

		/*******************************************************************/
		$out[0] = $LN_CPU;
		$out[1] = $actualCpuId;

		$out[2] = $LN_MB;
		$out[3] = $actualMbId;

		$out[4] = $LN_RAM;
		$out[5] = $actualRamId;

		$out[6] = $LN_HDD;
		$out[7] = $actualHddId;

		$out[8] = $LN_SMART;
		$out[9] = $actualSmartId;

		$out[10]= $LN_IOS;
		$out[11]= $actualOsId;

		return $out;
	}
}