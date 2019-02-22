<?php
namespace app\controllers;
defined("APPPATH") OR die("Access denied");

use \core\View,
	\app\controllers\Tecnicos,
	\app\models\admin\user as UserAdmin,
	\app\models\admin\Company,
	\app\models\Clients,
	\app\models\Incidencias,
	\app\models\InventarioScripts,
	\app\models\Empresas,
	\app\models\Equipos,
	\app\models\Reportes,
	\app\models\Soportes,
	\app\models\Utils;


class Admin {

	public function index()
	{
		//comprombando que sí funciona:  echo "Hola index";

		/**
		 * Pasando Variables a la Vista
		 */
		View::set("pageTitle", "Lanuza Group SAS | Su empresa de Soporte TI | Official Website");

		/**
		 * Llamando a la Vista
		 */
		View::render("pruebabootstrap");
	}

	public function allUsers() {

		$users = UserAdmin::getAll();

		/**
		 * Pasando Variables a la Vista
		 */
		View::set("users", $users);

		View::set("pageTitle", "Usuarios existentes en el sistema");

		View::render("users");

	}

	public static function home() {

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user);
	
		View::set("pageTitle", "Admin - Home");

		View::set("opcionMenu", "home");

		View::render("portal_admin_home");
	}

	/**
	 * para buscar
	 * @param GET una opcion: {"personas", "empresas", "equipos", "incidencias"}
	 * @param GET a donde redireccionar: {"reporte_dashboard", "reporte_equipos", "reporte_incidencias"}
	 */
	public static function buscar($opcion, $redireccionarA){

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user);

		View::set("pageTitle", "Admin | Portal Lanuza Group SAS");

		View::set("redireccionarA", $redireccionarA);
		
		/* VISTA */
		$opcionMenu = "dashboard";

		if ( $opcion == "empresas" ){
			
			$procesoParte = "Busqueda_Empresa";
			View::set("procesoParte", $procesoParte);

			$opcionMenu = "buscar_empresa";

		}

		View::set("opcionMenu", $opcionMenu);

		View::render("portal_admin_home");
	}

	/**
	 * Viene del Formulario: buscar Empresa
	 */ 
	public static function seleccionar_empresa(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Admin");
		
		/* VISTA */
		$opcionMenu = "buscar_empresa";
		

		/* FASE: parte del proceso */
		View::set("procesoParte", "Busqueda_Empresa");

		if ( isset( $_POST['searchCompany'] ) ){

			$search = stripslashes( $_POST['searchCompany'] );
			View::set("searchedCompany", $search);

			$redireccionarA = $_POST["redireccionarA"];
			View::set("redireccionarA", $redireccionarA);

			$opcionMenu = "buscar_empresa";
			
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
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_admin_home" );
	}

	
	/**
	 * seleccionada un Empresa
	 */ 
	public static function reporte_dashboard($anyo){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		if ( isset( $_POST['seleccionarEmpresaID'] ) ){

			/*
			 * Redireccionar la misma data de la busqueda, por si se hace nueva consulta a través
			 * del combo select Year
			 */
			View::set("seleccionarEmpresaID", $_POST['seleccionarEmpresaID'] );
			View::set("seleccionarEmpresaNombre", $_POST['seleccionarEmpresaNombre'] );
			View::set("seleccionarEmpresaRazonsocial", $_POST['seleccionarEmpresaRazonsocial'] );
			View::set("seleccionarEmpresaNIT", $_POST['seleccionarEmpresaNIT'] );
			View::set("seleccionarEmpresaDireccion", $_POST['seleccionarEmpresaDireccion'] );
			View::set("seleccionarEmpresaCantEquipos", $_POST['seleccionarEmpresaCantEquipos'] );

			View::set("reporteYear", $anyo);

			$empresaId = $_POST['seleccionarEmpresaID'];

			$company = Empresas::getEmpresa($empresaId);
			View::set("empresa", $company);

			View::set("pageTitle", "Dashboard de " . $company->nombre );

			/*
			 * I PARTE: Uso del Portal
			 */
			$estadisticasPortal = Reportes::usoPortalDashboard($empresaId);
			View::set("estadisticasPortal", $estadisticasPortal);

			/*
			 * II PARTE: Equipos
			 */
			$reporteEquipos = Reportes::reporteEquiposDashboard($empresaId);
			View::set("reporteEquipos", $reporteEquipos);


			$presentaciones = Reportes::presentacionesEquiposDashboard($empresaId);
			View::set("tipos_equipos", $presentaciones[0]);
			View::set("cantidad_equipos", $presentaciones[1]);


			$usuariosEquipos = Reportes::usuariosEquiposDashboard($empresaId);
			View::set("usuariosEquipos", $usuariosEquipos);


			$reemplazosHardware = Reportes::reemplazosHardwareDashboard($empresaId, $anyo);
			View::set("reemplazosHardware", $reemplazosHardware);

			$reemplazosSoftware = Reportes::reemplazosSoftwareDashboard($empresaId, $anyo);
			View::set("reemplazosSoftware", $reemplazosSoftware);


			$licencias = Reportes::licenciamientoEquiposDashboard($empresaId);
			View::set("licencias", $licencias);

			/*
			 * III PARTE: Incidencias
			 */
			$estadisticasIncidencias = Reportes::estadisticasIncidenciasDashboard($empresaId, $anyo);
			View::set("estadisticasIncidencias", $estadisticasIncidencias);


			$tiposIncidencias = Reportes::clasificacionIncidenciasDashboard($empresaId, $anyo);
			View::set("clasificacionIncidenciasDashboard", $tiposIncidencias);


			$tiposProblemas = Reportes::clasificacionCausasIncidenciasDashboard($empresaId, $anyo);
			View::set("causalesIncidenciasDashboard", $tiposProblemas);


			$duracionPromedio = Reportes::duracionPromedioIncidenciasDashboard($empresaId, $anyo);
			View::set("duracionPromedio", $duracionPromedio);


			$usuariosDeIncidencias = Reportes::usuariosDeIncidenciasDashboard($empresaId, $anyo);
			View::set("usuariosDeIncidenciasDeEsteAnyo", $usuariosDeIncidencias);


			$tecnicos = Reportes::tecnicosEnEmpresaDashboard($empresaId, $anyo);
			View::set("tecnicosQueHanVisitadoLaEmpresa", $tecnicos);

			/*
			 * IV PARTE: Citas programadas en Agenda
			 */
			$citasFuturas = Reportes::agendaFuturaEnEmpresaDashboard($empresaId);
			View::set("citasFuturas", $citasFuturas);

			$citasPasadas = Reportes::agendaPasadasEnEmpresaDashboard($empresaId, $anyo);
			View::set("citasPasadas", $citasPasadas);

			$reportesVisita = Reportes::reportesDeVisita($empresaId, $anyo);
			View::set("reportesVisita", $reportesVisita);

			/*
			 * V PARTE: INVENTARIO DE EQUIPOS
			 */
			$inventario = Reportes::getEquiposDeEmpresaDashboard($empresaId);
			View::set("inventario", $inventario);


			/* VISTA */
			$opcionMenu = "dashboard";
			
		} else {
			View::set("pageTitle", "Dashboard de Empresa - NOT FOUND");
		}

		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_admin_home" );
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

			
			View::set("acciones", "acciones");

			/* VISTA */
			$opcionMenu = "ver_solucion";
			View::set("opcionMenu", $opcionMenu);

			View::render( "portal_admin_home" );
		}
	}


	/**
	 * 
	 */
	public static function update_incidencia(){

		session_start();

		$tech = $_SESSION['logged_user'];

		View::set("user", $tech);

		if ( isset( $_POST['incidenciaId_Form'] ) ){

			$incidenciaId = $_POST['incidenciaId_Form'];
			$solucionId   = $_POST['solucionId_Form'];
			$empresaId    = $_POST['empresaId_mainForm'];

			
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


			/**/
			Incidencias::updateSolucion($incidenciaId, $solucionId, 
					$laborDelEquipo,
					$variableEndogena,
					$variableExogenaTecnica,
					$variableExogenaHumana,
					$mantenimientoHardware,
					$mantenimientoSoftware,
					$acompanamientoJunior
					);

			/* Salvar en Respuesta Predefinida * /
			Incidencias::salvarRespuesta($empresaId, $laborDelEquipo, "laborDelEquipo");
			*/

			/* se supone que se añade 1 registro */
			$addedHW = 0;
			$addedSW = 0;

			if ( $solucionId > 1){

				/* si hay componentes de Hardware, añadir a este registro */
				if ( $cantHardware > 0 ){

					$addedHW = Incidencias::agregarComponenteHardware($solucionId, $cantHardware,
							$hardwareARemplazar, $hardwareDescripciones, 
							$hardwareViejo, $hardwareNuevo, $hardwareFueRemplazadoSN,
							true);

				}

				/* si hay componentes de Hardware, añadir a este registro */
				if ( $cantSoftware > 0 ){

					$addedSW = Incidencias::agregarComponenteSoftware($solucionId, $cantSoftware,
							$softwaresARemplazar, $softwareVersiones, 
							$softwareTipos, $softwareSeriales, $softwaresCambiados,
							true);

				}

				
				$incidencia_cerrada = "La Incidencia #" . $incidenciaId . " ha sido ACTUALIZADA exitosamente.";

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
				/*
				View::set("solucion_cambios", 			$incidencia_cerrada);
				View::set("solucion_cambios_titulo", 	"Cambios guardados");
				*/
			}

			Admin::ver_resolucion_incidencia();
		}
	}


	/**
	 * 
	 */ 
	public static function reporte_incidencias($anyo){

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user);

		if ( isset( $_POST['seleccionarEmpresaID'] ) ){

			$empresaId = $_POST['seleccionarEmpresaID'];

			$company = Empresas::getEmpresa($empresaId);
			View::set("empresa", $company);

			View::set("pageTitle", "Reporte: Incidencias" );


			$estadisticasIncidencias = Reportes::estadisticasIncidenciasDashboard($empresaId, $anyo);
			View::set("estadisticasIncidencias", $estadisticasIncidencias);


			$tiposIncidencias = Reportes::clasificacionIncidenciasDashboard($empresaId, $anyo);
			View::set("clasificacionIncidenciasDashboard", $tiposIncidencias);


			$tiposProblemas = Reportes::clasificacionCausasIncidenciasDashboard($empresaId, $anyo);
			View::set("causalesIncidenciasDashboard", $tiposProblemas);


			$duracionPromedio = Reportes::duracionPromedioIncidenciasDashboard($empresaId, $anyo);
			View::set("duracionPromedio", $duracionPromedio);


			$usuariosDeIncidencias = Reportes::usuariosDeIncidenciasDashboard($empresaId, $anyo);
			View::set("usuariosDeIncidenciasDeEsteAnyo", $usuariosDeIncidencias);


			$tecnicos = Reportes::tecnicosEnEmpresaDashboard($empresaId, $anyo);
			View::set("tecnicosQueHanVisitadoLaEmpresa", $tecnicos);

			/* VISTA */
			$opcionMenu = "reportes_incidencias";
		}

		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_admin_home" );
	}

	/**/
	public static function reporte_equipos($anyo){

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user);

		if ( isset( $_POST['seleccionarEmpresaID'] ) ){

			$empresaId = $_POST['seleccionarEmpresaID'];

			$company = Empresas::getEmpresa($empresaId);
			View::set("empresa", $company);

			View::set("pageTitle", "Reporte: Equipos de su Empresa" );

			/* Todos los Equipos */
			$equipos = Reportes::equiposReporte($empresaId);
			View::set("equipos", $equipos);

			/*
			 * Resumen de otros datos de Equipos (Dashboard)
			 */
			$reporteEquipos = Reportes::reporteEquiposDashboard($empresaId);
			View::set("reporteEquipos", $reporteEquipos);


			$presentaciones = Reportes::presentacionesEquiposDashboard($empresaId);
			View::set("tipos_equipos", $presentaciones[0]);
			View::set("cantidad_equipos", $presentaciones[1]);


			$usuariosEquipos = Reportes::usuariosEquiposDashboard($empresaId);
			View::set("usuariosEquipos", $usuariosEquipos);


			$reemplazosHardware = Reportes::reemplazosHardwareDashboard($empresaId, $anyo);
			View::set("reemplazosHardware", $reemplazosHardware);

			$reemplazosSoftware = Reportes::reemplazosSoftwareDashboard($empresaId, $anyo);
			View::set("reemplazosSoftware", $reemplazosSoftware);


			$licencias = Reportes::licenciamientoEquiposDashboard($empresaId);
			View::set("licencias", $licencias);

			/* $ */
			$valores = Reportes::valoresEquiposReporte($empresaId);
			View::set("valores", $valores);

			/*
			 * Tabla: Memoria y Tarjetas
			 */
			$tarjetas = Reportes::memoriaYtarjetasEquiposReporte($empresaId);
			View::set("memoriaYtarjetas", $tarjetas);

			$RAM = Reportes::RAMdeEquiposReporte($empresaId);
			View::set("tarjetasRAM", $RAM);

			$soundVideo = Reportes::soundYvideoTarjetasReporte($empresaId);
			View::set("soundVideo", $soundVideo);

			/*
			 * Tabla: Discos y Uso de sus Equipos
			 */
			$hdd = Reportes::discosDurosYLogicosReporte($empresaId);
			View::set("discosDurosYLogicos", $hdd);

			$smart = Reportes::SMARTDiscosReporte($empresaId);
			View::set("smart", $smart);

			/* VISTA */
			$opcionMenu = "reportes_equipos";
		}

		View::set("opcionMenu", $opcionMenu);
		
		View::render( "portal_admin_home" );
	}

	/**
	 * para buscar
	 * @param GET una opcion: {"personas", "empresas", "equipos", "incidencias"}
	 */
	public static function search($opcion){

		session_start();

		$tech   = $_SESSION['logged_user'];
		
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

		View::render( "portal_admin_home" );
	}

	/**
	 * Viene del metodo search($opcion)
	 */
	public static function busqueda_general(){

		session_start();

		$tech   = $_SESSION['logged_user'];
		
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

		View::render( "portal_admin_home" );
	}

	/**
	 * see all Objects
	 */
	public static function listarTodos($opcion){

		session_start();

		$tech = $_SESSION['logged_user'];
		
		View::set("user", $tech );

		View::set("pageTitle", "Resultados de Búsqueda en el Sistema...");

		/* VISTA */
		$opcionMenu = "busqueda_general";
		View::set("opcionMenu", $opcionMenu);

		/**/
		$tipoEquipos = Equipos::getAllTipoEquipos();
		View::set("tipoEquipos", $tipoEquipos);

		/* combobox */
		$fallas = Clients::getFallasGenerales();
		View::set("fallas", $fallas);

		if ( $opcion == "personas" ){
			View::set("opcion", "personas");

			$usuarios = Clients::searchAllUsers();
			View::set("people", $usuarios);

			View::set("searchedPersons", "");
		
		} else if ( $opcion == "empresas" ){
			View::set("opcion", "empresas");

			$companies = Empresas::searchCompanies("");
			View::set("companies", $companies);

			View::set("searchedCompanies", "");

		} else if ( $opcion == "equipos" ){
			View::set("opcion", "equipos");

			$equipment = Equipos::searchEquipos2("", NULL);
			View::set("equipment", $equipment);

			View::set("searchedEquipos", "");

		} else if ( $opcion == "incidencias" ){
			View::set("opcion", "incidencias");

			$incidencias = Incidencias::searchIncidencias("", "", "all_Incidencias");
			View::set("incidencias", $incidencias);

			View::set("searchedIncidencias", 	"");
			View::set("searchedTipoIncidencia", "");
			View::set("searchedTipo1al4", 		"");

		} else if ( $opcion == "reportes" ){
			View::set("opcion", "incidencias");

			$incidencias = Incidencias::searchIncidencias("", "", "all_Reportes");
			View::set("incidencias", $incidencias);

			View::set("searchedIncidencias", 	"");
			View::set("searchedTipoIncidencia", "");
			View::set("searchedTipo1al4", 		"");
		}

		View::render( "portal_admin_home" );
	}


	/**
	 * Para mostrar el formulario de edicion
	 * @param GET una opcion: {"persona", "empresa", "equipo", "incidencias"}
	 */
	public static function editar($opcion, $id){
		
		session_start();

		$tech = $_SESSION['logged_user'];
		
		View::set("user", $tech );

		if ( $opcion == "persona" ){

			$usuario = UserAdmin::getUserObjectById($id);
			View::set("usuario", $usuario);

			/* VISTA */
			$opcionMenu = "actualizar_perfil";

			View::set("pageTitle", "Editar Persona " . $usuario->nombre );

			View::set("idUsuarioAEditar", $id);
		
		} else if ( $opcion == "empresa" ){

			$company = Company::getEmpresaById($id);
			View::set("empresa", $company);

			/* VISTA */
			$opcionMenu = "actualizar_empresa";

			View::set("pageTitle", "Editar Empresa: " . $company->nombre );

			View::set("idEmpresaAEditar", $id);
		}

		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_admin_home" );
	}


	public static function actualizar_info_form(){

		session_start();

		$user = $_SESSION['logged_user'];
		View::set("user", $user);

		$updated_info="";
		$passwordCambiado = false;

		/* Actualizar USUARIO */
		if ( isset( $_POST['idUsuarioAEditar'] ) ){

			$userId = $_POST['idUsuarioAEditar'];
			View::set("idUsuarioAEditar", $userId);

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
				$updated_info=" - Información Actualizada satisfactoriamente.";
			}
		}

		$usuario = UserAdmin::getUserObjectById($userId);
		View::set("usuario", $usuario);

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
				$userPwd = UserAdmin::getUser($usuario->usuario, $pwdActual, "activo");

				if( isset($userPwd->usuario) ) {

					$count = UserAdmin::updatePassword($userPwd->usuario, $pwdActual, $pwdrepited);
					
					if ( $count == 1 ){
						$updated_info .= "<br/><br/> - Contraseña NUEVA establecida.";
						$passwordCambiado = true;
					}

				} else {
					$updated_info .= "<br/><br/> - Contraseña NO Actualizada. Contraseña actual incorrecta.";
				}
			}
		}

		View::set("pageTitle", "Perfil Actualizado");
		
		View::set("updated_info", $updated_info);

		/* VISTA */
		$opcionMenu = "actualizar_perfil";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_admin_home" );
	}


	/**
	 * Para mostrar el formulario de edicion
	 * @param GET una opcion: {"persona", "empresa", "equipo", "incidencias"}
	 */
	public static function borrar($opcion, $tipoEdicion, $id){
		
		session_start();

		$tech = $_SESSION['logged_user'];
		
		View::set("user", $tech );

		if ( $opcion == "persona" ){

			$status="";
			if ( $tipoEdicion == "borrar" ){
				$status = "eliminado";

			} else if ( $tipoEdicion == "inactivar" ){
				$status = "inactivo";

			} else if ( $tipoEdicion == "activar" ){
				$status = "activo";
			}

			$count = UserAdmin::cambiarStatus($id, $status);
			if ( $count == 1 ){
				$updated_info = "Usuario " . $status;
			} else {
				$updated_info = "ERROR al tratar de cambiar el rol de este Usuario en el Sistema";
			}

			$usuario = UserAdmin::getUserObjectById($id);
			View::set("usuario", $usuario);

			/* VISTA */
			$opcionMenu = "actualizar_perfil";

			View::set("pageTitle", "Editar: Persona " . $usuario->nombre );

			View::set("idUsuarioAEditar", $id);
		}

		View::set("updated_info", $updated_info);

		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_admin_home" );
	}

	/**
	 * actualizacion de solo la Empresa
	 */
	public static function update_company(){

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user);

		if ( isset( $_POST['idEmpresaAEditar'] ) ){

			$empresaId = $_POST["idEmpresaAEditar"];
			View::set("idEmpresaAEditar", $empresaId);

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

			$count = Company::update($empresaId, $company, $company_razon, $company_nit, 
					$company_pais, $company_estado, $company_city, $company_direcc,
					$company_web, $company_pbx, $company_email);

			$tipoTransaccion = "Usuario_Actualizar";
			if ( $count == 1 ){
				$updated_info = "Datos de la Empresa actualizados.";

			} else {
				$updated_info = "Datos de la Empresa NO actualizados, por un problema en la Base de datos.";
			}
			
			View::set("updated_info", $updated_info);

			$empresa = Company::getEmpresaById( $empresaId );
			View::set("empresa", $empresa);

			/* VISTA */
			$opcionMenu = "actualizar_empresa";
			View::set("opcionMenu", $opcionMenu);

			View::set("pageTitle", "Empresa: Actualización");

			View::render( "portal_admin_home" );
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
			$tipoEquipo = $_POST['tipoEquipo'];
			View::set("tipoEquipo", $tipoEquipo);

			/**/
			$equipoInfoId = $_POST['equipoInfoId'];

			/**/
			$equipo = Equipos::getByEquipoInfoId( $equipoInfoId );
			View::set("codigoBarras", $equipo->codigoBarras );
			
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

		View::render( "portal_admin_home" );
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
			View::set("tipo_portal", "admin/home");

			View::set("viene_de_admin", "viene_de_admin");
			
			/* Pagina optimizada para IMPRIMIR: INCIDENCIAS */
			View::render( "imprimir_solucion_incidencia" );
		}
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

		View::render( "portal_admin_home" );
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

		View::render( "portal_admin_home" );
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

			View::render( "portal_admin_home" );
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

			$tipoReporte = $_POST['reporte_general_check'];
			
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

		Admin::home();
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

			View::render( "portal_admin_home" );

		} catch (Exception $e) {
			$internalErrorCodigo  = "Exception in controllers.Admin.calendario()";
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
	 * listado de Incidencias: abiertas o cerradas
	 */
	public static function incidencias($tipo) {

		session_start();

		$admin = $_SESSION['logged_user'];

		View::set("user", $admin);
		View::set("adminId", $admin->id);

		if ( $tipo == "pendientes" ){

			View::set("pageTitle", "Incidencias/Reportes PENDIENTES aún");

			View::set("tableTittle", "<i>Listado de <b>todos</b> las Incidencias/Reportes pendientes</i>");

			$incidencias = Incidencias::getIncidenciasAbiertas();
			View::set("incidencias", $incidencias);

			$opcionMenu = "ver_incidencias";

			View::set("subTitle", "Nota: los que están en estatus {'Abierta', 'En Progreso' o 'En Espera'} NO tendrá habilitado los botones AZUL ni VERDE, ya que no se han llenado sus Reportes como resueltos.");
		
		} else if ( $tipo == "legacy" ){

			View::set("pageTitle", "Histórico de Incidencias/Reportes");

			View::set("tableTittle", "Hist&oacute;rico: <i>Listado de <b>todos</b> las Incidencias/Reportes</i> Cerrados y Certificados");

			/*
			 * SQL LIMIT limitando resultados para PAGINATION
			 * $page debe INICIAR en 1
			 */
			$page = 1;
			$limit = 300;

			$cerradas = Incidencias::getIncidenciasCerradasAdmin( $page, $limit );
			View::set("incidencias", $cerradas);

			$opcionMenu = "ver_incidencias";

			View::set("subTitle", "Nota: los que están en estatus {'Cerrada' o 'Certificada'} SÍ tendrá habilitado los botones AZUL ni VERDE, ya que se han llenado sus Reportes como solucionados.");
		}

		
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_admin_home" );
	}


	/**
	 * mostrar filtro
	 */
	public static function transacciones(){

		session_start();

		$admin = $_SESSION['logged_user'];

		View::set("user", $admin);

		View::set("pageTitle", "Transacciones en el Portal LanuzaGroup");
		
		View::set("searched", "");
		View::set("searchedCompany", "");
		View::set("searchedTrx", "");
		View::set("searchDesde", "");
		View::set("searchHasta", "");

		View::set("checkboxKeywords", 	"false");
		View::set("checkboxCompany", 	"false");
		View::set("checkboxOperation",  "false");
		View::set("checkboxDesde", 		"false");
		View::set("checkboxHasta", 		"false");

		View::set("status",	"both");

		/* obteniendo empresas */
		$companies = Company::getAll();
		View::set("empresas", $companies);

		/* obteniendo tipos de operaciones */
		$operaciones = Clients::getTipoTransacciones();
		View::set("operaciones", $operaciones);

		$opcionMenu = "transacciones";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_admin_home" );
	}


	/**
	 * viene del filtro
	 */
	public static function busqueda_transacciones(){

		session_start();

		$admin = $_SESSION['logged_user'];

		View::set("user", $admin);

		View::set("pageTitle", "Transacciones en el Portal LanuzaGroup");

		/* obteniendo empresas */
		$companies = Company::getAll();
		View::set("empresas", $companies);

		/* obteniendo tipos de operaciones */
		$operaciones = Clients::getTipoTransacciones();
		View::set("operaciones", $operaciones);


		if ( isset( $_POST['searched'] ) ){

			$status = $_POST['status'];
			View::set("status",	$status);

			/*
			 * cada opcion con su checkbox
			 */
			if ( isset( $_POST['search_keywords'] ) && $_POST['search_keywords'] == "keywords" ){
				$texto = $_POST['searched'];
				View::set("checkboxKeywords", "true");
			} else {
				$texto = "";
				View::set("checkboxKeywords", "false");
			}
			View::set("searched", $texto);
			
			/**/
			if ( isset( $_POST['search_company'] ) && $_POST['search_company'] == "company" ){
				$company = $_POST['companiesCombo'];
				View::set("checkboxCompany", "true");
			} else {
				$company = "";
				View::set("checkboxCompany", "false");
			}
			View::set("searchedCompany", $company);

			/**/
			if ( isset( $_POST['search_operation'] ) && $_POST['search_operation'] == "operation" ){
				$trx = $_POST['trx'];
				View::set("checkboxOperation", "true");
			} else {
				$trx = "";
				View::set("checkboxOperation", "false");
			}
			View::set("searchedTrx", $trx);
			
			/**/
			if ( isset( $_POST['search_from'] ) && $_POST['search_from'] == "from" ){
				$desde = $_POST['fechaDesde'];
				View::set("checkboxDesde", "true");
			} else {
				$desde = "";
				View::set("checkboxDesde", "false");
			}
			View::set("searchDesde", $desde);
			
			/**/
			if ( isset( $_POST['search_to'] ) && $_POST['search_to'] == "to" ){
				$hasta = $_POST['fechaHasta'];
				View::set("checkboxHasta", "true");
			} else {
				$hasta = "";
				View::set("checkboxHasta", "false");
			}
			View::set("searchHasta", $hasta);

			/*
			 * Busqueda segun los filtros dados
			 */
			$transacciones = Clients::searchTransaccion($status, $trx, $company, $desde, $hasta, $texto);

			if ( $transacciones[0] != NULL && $transacciones[0] != "" ){
				View::set("transacciones", $transacciones[0]);
			} else {
				View::set("no_transacciones", "no_transacciones");
			}
			View::set("query", $transacciones[1]);
			
		}

		$opcionMenu = "transacciones";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_admin_home" );
	}


	/**
	 * Llamada AJAX para llenar data en ventana Modal
	 * Buscando info de UN usuario
	 */ 
	public static function ajax_ver_usuario(){

		if ( isset( $_POST['usuario_en_sistema_id'] ) ){

			$tech = UserAdmin::getById( $_POST['usuario_en_sistema_id'] );

			if ( $tech != null && $tech != "" ){

				$company = Empresas::getEmpresa( $tech["empresaId"] );

				$aux="";
				if ( $tech["role"]=="client" )			$aux="Usuario (Básico)";
				else if ( $tech["role"]=="manager" )	$aux="Partner (Avanzado - privilegios gerenciales)";
				else if ( $tech["role"]=="tech" )		$aux="Ing. de Soporte";
				else if ( $tech["role"]=="developer" )	$aux="Desarrollador";


				echo "<br/><b>Nombre:</b> &nbsp;&nbsp;"                 . $tech["nombre"];
				echo "<br/><b>Apellido:</b> &nbsp;"                     . $tech["apellido"];
				echo "<br/><b>Tipo de Usuario:</b> &nbsp;"              . $aux;
				echo "<br/><b>Usuario:</b> &nbsp;"                      . $tech["usuario"];
				echo "<br/><b>Email:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $tech["email"];
				echo "<br/><b>Empresa:</b> &nbsp;&nbsp;"                . $company->nombre;
				echo "<br/><b>Celular:</b> &nbsp;&nbsp;&nbsp;"          . $tech["celular"];
				echo "<br/><b>Teléf. Trabajo:</b> &nbsp;"               . $tech["telefonoTrabajo"];
				echo "<br/><b>Extensión:</b> &nbsp;"                    . $tech["extensionTrabajo"];
				
			} else {
				echo "<b>NO pudimos recuperar información del Usuario</b>" 
					. " <i>en estos momentos.</i> Por favor intente m&aacute;s tarde.";
			}
		}
	}
	
	/**
	 * Llamada AJAX para llenar data en ventana Modal
	 * Buscando info de UNA incidencia
	 */ 
	public static function ajax_ver_incidencia(){

		if ( isset( $_POST['incidencia_id'] ) ){

			$incidencia = Incidencias::getIncidenciaObjeto( $_POST['incidencia_id'] );

			if ( $incidencia != null && $incidencia != "" ){


				echo "<br/><b>Empresa:</b> &nbsp;&nbsp;"                   . $incidencia->NombreEmpresa     . " "  . $incidencia->razonSocial;
				echo "<br/><br/>";
				echo "<br/><b>Reportada por:</b> &nbsp;"                   . $incidencia->reportadoPorNombre. " "  . $incidencia->reportadoPorApellido;
				echo "<br/><b>Extra info:</b> &nbsp;"                      . $incidencia->email             . " / ". $incidencia->celular     . " / ". $incidencia->telefonoTrabajo. " Ext. ". $incidencia->extensionTrabajo;
				echo "<br/><br/>";
				echo "<br/><b>Tipo de Falla:</b> &nbsp;"                   . $incidencia->TipoFalla;
				echo "<br/><b>Detalles:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $incidencia->observaciones;
				echo "<br/><br/>";
				echo "<br/><b>Estatus:</b> &nbsp;&nbsp;"                   . $incidencia->status;
				echo "<br/><b>Ing. de Soporte:</b> &nbsp;&nbsp;&nbsp;"     . $incidencia->TecnicoNombre     . " "  . $incidencia->TecnicoApellido;
				echo "<br/><br/>";
				echo "<br/><b>Equipo afectado:</b> &nbsp;"                 . $incidencia->codigoBarras      . " (" . $incidencia->nombreEquipo. ")";
				
			} else {
				echo "<b>NO pudimos recuperar información de la Incidencia</b>" 
					. " <i>en estos momentos.</i> Por favor intente m&aacute;s tarde.";
			}
		}
	}


	/**
	 * Buscando los Equipos, Usuarios y seteando la info de la Empresa
	 */ 
	public static function asignacion(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );
		
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

			$estatuses = Clients::getEstatusEquipos();
			View::set("status_de_equipos", $estatuses);

			/* VISTA */
			$opcionMenu = "equipos_de_empresa";

		} else {
			echo "ERROR de redireccionamiento";
		}

		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_admin_home" );
	}

	/**
	 *  Eliminar UN USUARIO de un EQUIPO
	 */ 
	public static function desasociar_equipo_usuario(){

		if ( isset( $_POST['equipoId'] ) ){

			session_start();

			$user   = $_SESSION['logged_user'];
			$userId = $user->id;

			$companyID = $_POST['seleccionarEmpresaID'];
			$equipoId  = $_POST['equipoId'];
			$usuarioId = $_POST['usuarioId'];

			$tipoTransaccion = "Asignar_Equipo_Usuario";

			$count = Equipos::eliminarUsuarioDeEquipo($companyID, $equipoId, $usuarioId);

			if ( $count == 1 ){
				/*
				$info = "DESASOCIAR: Equipo:$equipoId - removido de Usuario:$usuarioId - Empresa:$companyID ";
				Transaccion::insertTransaccion($tipoTransaccion, "Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );
				*/
			} else {
				/*
				$info = "DESASOCIAR: empresa:$companyID - equipo:$equipoId - usuario:$usuarioId - tech:$userId - count_NOT_1: $count";
				Transaccion::insertTransaccion($tipoTransaccion, "Not_Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );
				*/
			}
		}

		Admin::asignacion();
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
				/*
				$info = "ASOCIAR: Equipo:$equipoId - asignado a Usuario:$usuarioId - Empresa:$companyID ";
				Transaccion::insertTransaccion($tipoTransaccion, "Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );
				*/
			} else {
				/*
				$info = "ASOCIAR: empresa:$companyID - equipo:$equipoId - usuario:$usuarioId - tech:$userId - count_NOT_1: $count";
				Transaccion::insertTransaccion($tipoTransaccion, "Not_Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );
				*/
			}
		}

		Admin::asignacion();
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

		View::render( "portal_admin_home" );
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
		View::render( "portal_admin_home" );
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
		View::render( "portal_admin_home" );
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
		View::render( "portal_admin_home" );
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
		View::render( "portal_admin_home" );
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
				/* 
				$info = "EQUIPO_CREADO para userId:".$searchedId;
				Transaccion::insertTransaccion($tipoTransaccion, "Ok", $techId, $_SESSION['role_user'], $empresaId , $info );

				/*
				 * Buscando Equipo recien creado
				 */
				$newEquipo = Equipos::getById($idAutoincremental);
				View::set("newEquipo", $newEquipo);

			} else {
				/*
				$info = "toEmpresa:".$empresaId.", toUser:".$searchedId.", techId:".$techId.", count_NOT_1: $count - EQUIPO_NO_CREADO - inventario_nuevo_equipo()";
				Transaccion::insertTransaccion($tipoTransaccion, "Not_Ok", $techId, $_SESSION['role_user'], $empresaId , $info );

				/* NO creado */
				View::set("newEquipo", "no_creado");
			}
		}

		/* VISTA */
		$opcionMenu = "inventario_subir_scripts";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_admin_home" );

	}
/**
 * USADO PARA PRUEBAS - test user
 * @TEST -> inventario_nuevo_equipo()
 */
public static function script(){
	session_start();
	$tech   = $_SESSION['logged_user'];
	$adminId = $tech->id;
	View::set("user", $tech );
	View::set("pageTitle", "Equipo Nuevo creado");

	View::set("searchedUserName", "MIRa 2 prueba");

	$newEquipo=Equipos::getById(70);
	View::set("newEquipo", $newEquipo);
/*$E="Revisores de Texto do Microsoft Office 2013 – Português do Brasil";echo "$E .:. " . Utils::transliterateString($E);
*/
	$opcionMenu = "inventario_subir_scripts";
	View::set("opcionMenu", $opcionMenu);

	View::render( "portal_admin_home" );
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

				} else {
					/*
					 * informar Tecnico que NO se realizó actualización. Paso 4.-
					 */
					$info = "updateEquipoConInventario()_ERROR:  count_NOT_1: $count";
					/* Transaccion::insertTransaccion("Tecnico_Nuevo_Inventario", "Not_Ok", $techId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'], $info ); */
				}
			} else {
				/*
				 * informar Tecnico que NO se realizaó actualización. Paso 3.-
				 */
				$info = "insertEquipoInfo()_:  count_NOT_1: $count";
				/* Transaccion::insertTransaccion("Tecnico_Nuevo_Inventario", "Not_Ok", $techId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'], $info ); */
			}
		}
		
		/* VISTA */
		$opcionMenu = "resultado_inventario";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_admin_home" );
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

		View::render( "portal_admin_home" );
	}

	/**
	 * Busqueda de Equipos - presentacion en tabla
	 */ 
	public static function inventario_buscar_equipo(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "ADMIN: Búsqueda de Equipos para Actualizar");
		
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
		View::render( "portal_admin_home" );
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

			/*
			 * Los perifericos que ya fueron creados
			 */
			$perifericos = Equipos::getPerifericos( $_POST['equipoId'] );

			if ( $perifericos == NULL || $perifericos == "" ){
				View::set("no_perifericos", "no_perifericos");
			} else {
				View::set("perifericos_creados", $perifericos);
			}

			$empresa = $_POST['Empresa'];
			View::set("empresaNombre", $empresa);

			$usuario = trim( $_POST['Nombre'] );
			View::set("usuarioNombre", $usuario);

			/*
			 * Buscar Info para llenar los formularios S.O. y Ofimática
			 */
			Tecnicos::buscarInfoRellenarFormsSOyOffice( $equipo["equipoSOInfoId"], $equipo["equipoOfimaticaInfoId"] );
		
		}

		/* VISTA */
		$opcionMenu = "actualizar_equipo";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_admin_home" );
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
					/*$info = "EQUIPO_ACTUALIZADO por techId:".$techId;
					Transaccion::insertTransaccion($tipoTransaccion, "Ok", $techId, $_SESSION['role_user'], $empresaId , $info );
					*/
					$cambioRealizado = true;
					$message1 = "Se realizaron los cambios del Equipo exitosamente.";

				} else {
					/*$info = "toEmpresa:".$empresaId.", toUser:".$usuarioId.", techId:".$techId.", count_NOT_1: $count - EQUIPO_NO_ACTUALIZADO - actualizacion_equipo()";
					Transaccion::insertTransaccion($tipoTransaccion, "Not_Ok", $techId, $_SESSION['role_user'], $empresaId , $info );
					
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

			View::render( "portal_admin_home" );
		}
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

			View::render( "portal_admin_home" );
		}
	}

	/**
	 * Ya el EQUIPO existe, y fue inventariado, ahora ACTUALIZAR
	 */ 
	public static function inventario_actualizar(){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "ADMIN: Actualizar Equipo con los Scripts");

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

			View::render( "portal_admin_home" );
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
			}

			
			/* VISTA */
			$opcionMenu = "resultado_inventario_actualizacion";
			View::set("opcionMenu", $opcionMenu);

			View::set("resultado", $print);

			View::render( "portal_admin_home" );
		}
	}

	/**
	 * Ya el EQUIPO existe, y fue inventariado, ahora ACTUALIZAR
	 */ 
	public static function pqrs($opcion){

		session_start();

		View::set("user", $_SESSION['logged_user'] );

		View::set("pageTitle", "Ver PQRS de los Usuarios");

		$comentarios = Clients::getPQRS($opcion);
		
		View::set("comentarios", $comentarios);

		/**/
		View::set("opcion", $opcion);

		/* VISTA */
		$opcionMenu = "pqrs";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_admin_home" );
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

		View::render( "portal_admin_home" );
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
	 * Buscar el Historial de las cosas hechas a Equipos
	 */
	public static function licencias(){
		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user);

		if ( isset( $_POST['seleccionarEmpresaID'] ) ){

			//
			$empresaId = $_POST['seleccionarEmpresaID'];

			$company = Empresas::getEmpresa($empresaId);
			View::set("empresa", $company);

			View::set("pageTitle", "Inventario por Licencias de " . $company->nombre );

			/*
			 * obtener Licencias para los SO's y Ofimática
			 */
			$SO = Reportes::licenciasSistemaOperativoPorEmpresa($empresaId);
			View::set("licencias_sistemas_operativos", $SO);

			$office = Reportes::licenciasOfimaticasPorEmpresa($empresaId);
			View::set("licencias_sistemas_ofimatica", $office);

			/* VISTA */
			$opcionMenu = "licencias_inventario_equipos";
		}

		View::set("opcionMenu", $opcionMenu);
		
		View::render( "portal_admin_home" );
	}

	/*

labores q debe tener el portal admisnitrativo:

- borrar la tabla Transaccion -> esto es pasar la data del año a una tabla backup

- borrar de la tabla Transaccion los ultimos 6 meses, la info de Log_IN, log_OUT, (las mas numerosas) a tabla backup

- borrar de la tabla SoportesProgramados las citas con status 'eliminada'   >> dar analisis

- dashboard  de ERRORES de la tabla Transaccion

	*/
}