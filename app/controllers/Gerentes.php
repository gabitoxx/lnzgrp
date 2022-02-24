<?php
namespace app\controllers;
defined("APPPATH") OR die("Access denied");

use \core\View,
	\app\models\Empresas,
	\app\models\admin\user as UserAdmin,
	\app\models\admin\Transaccion,
	\app\models\Equipos,
	\app\models\Clients,
	\app\models\Reportes,
	\app\models\EmailManagement;

class Gerentes {

	/**
	 * Para mostrar los USUARIOS de una EMPRESA
	 */
	public static function buscar_usuarios(){

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user);

		$usuarios = UserAdmin::getUsuariosDeEmpresa($user->empresaId, true);

		if ( $usuarios != null ){

			/* Usuarios */
			View::set("usuarios", $usuarios);

		} else {
			View::set("no_usuarios", "no usuarios");
		}

		/* Empresa */
		$empresa = Empresas::getEmpresa($user->empresaId);
		View::set("empresa", $empresa);

		/* listado */
		$opcionMenu = "ver_todos_usuarios";
		View::set("opcionMenu", $opcionMenu);
		
		$titulo = $_SESSION['logged_user_saludo'];
		View::set("pageTitle", $titulo . " | Portal Gerentes | Usuarios de su Empresa");
		
		/* VISTA */
		View::render( "portal_manager_home" );
	}


	/**
	 * Para asociar EQUIPOS a USUARIOS de una EMPRESA: mostrar pantalla
	 */
	public static function asignacion(){

		session_start();

		$user = $_SESSION['logged_user'];
		View::set("user", $user);

		Gerentes::mostrarEquiposYUsuariosDeEmpresa();
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

			$empresa   = $_SESSION['logged_user_empresa'];
			$companyID = $empresa->empresaId;

			$equipoId  = $_POST['equipoId'];
			$usuarioId = $_POST['usuarioId'];

			$tipoTransaccion = "Asignar_Equipo_Usuario";

			$count = Equipos::eliminarUsuarioDeEquipo($companyID, $equipoId, $usuarioId);

			if ( $count == 1 ){
				/**/
				$info = "DESASOCIAR: Equipo:$equipoId - removido de Usuario:$usuarioId - Empresa:$companyID - Gerentes.php";
				Transaccion::insertTransaccion($tipoTransaccion, "Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );

			} else {
				/**/
				$info = "DESASOCIAR: empresa:$companyID - equipo:$equipoId - usuario:$usuarioId - count_NOT_1: $count  - Gerentes.php";
				Transaccion::insertTransaccion($tipoTransaccion, "Not_Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );
			}
		}

		Gerentes::mostrarEquiposYUsuariosDeEmpresa();
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

			$empresa   = $_SESSION['logged_user_empresa'];
			$companyID = $empresa->empresaId;

			$equipoId  = $_POST['equipoId'];
			$usuarioId = $_POST['usuarioId'];

			$tipoTransaccion = "Asignar_Equipo_Usuario";

			$count = Equipos::asociarUsuarioAEquipo($companyID, $equipoId, $usuarioId);

			if ( $count == 1 ){
				/**/
				$info = "ASOCIAR: Equipo:$equipoId - asignado a Usuario:$usuarioId - Empresa:$companyID   - Gerentes.php";
				Transaccion::insertTransaccion($tipoTransaccion, "Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );

			} else {
				/**/
				$info = "ASOCIAR: empresa:$companyID - equipo:$equipoId - usuario:$usuarioId - count_NOT_1: $count  - Gerentes.php";
				Transaccion::insertTransaccion($tipoTransaccion, "Not_Ok", $userId, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );
			}
		}

		Gerentes::mostrarEquiposYUsuariosDeEmpresa();
	}

	/**
	 * buscando los Equipos, Usuarios y seteando la info de la Empresa
	 */ 
	public static function mostrarEquiposYUsuariosDeEmpresa(){
		
		$empresa   = $_SESSION['logged_user_empresa'];
		$empresaId = $empresa->empresaId;

		$usuarios = UserAdmin::getUsuariosDeEmpresa($empresaId, true);
		if ( $usuarios != NULL && $usuarios != "" ){
			View::set("usuarios", $usuarios);
		} else {
			View::set("no_usuarios", "no_usuarios");
		}

		$equipos = Equipos::getEquiposUsuariosDeEmpresa($empresaId);
		View::set("equipos", $equipos);

		/**/
		View::set("searchedCompanyId", $empresaId);
		View::set("companyInfo", $empresa->nombre);

		View::set("pageTitle", "Asignar Equipos a Usuarios de su Empresa");

		/* VISTA */
		$opcionMenu = "equipos_de_empresa";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_manager_home" );
	}


	/**
	 * mostrar la página de "Cargando Reportes...."
	 */ 
	public static function cargar_dashboard(){
		
		session_start();

		View::set("user", $_SESSION['logged_user'] );

		$opcionMenu = "cargando_dashboard";
		View::set("opcionMenu", $opcionMenu);

		View::set("pageTitle", "Cargando Dashboard...");

		/*
		 * Buscando un tip en la BD
		 */
		$max_id = Equipos::getMaxID("TipsUsoPortal");

		$tip = Clients::getTip( $max_id, $_SESSION['role_user'] );
		View::set("tip", $tip);

		/*
		 * A qué funcion se va a llamar:
		 */
		View::set("funcionAcargar", "dashboard");

		View::render( "portal_manager_home" );
	}

	/**
	 * mostrar Dashboard principal
	 */ 
	public static function dashboard($anyo){

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user);

		try {
			View::set("reporteYear", $anyo);

			$empresaId = $_SESSION['logged_user_empresaId'];

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


			/**/
			$info = "Dashboard generado - Gerentes.php";
			Transaccion::insertTransaccion("Generar_Reporte", "Ok", $user->id, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );

		} catch (Exception $e) {
			$internalErrorCodigo  = "Exception in controllers.Gerentes.dashboard()";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "empresaId:$empresaId | userId:" . $user->id;
			
			/**/
			Transaccion::insertTransaccionException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra, $_SESSION['role_user'], $tech->id);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}

		/* VISTA */
		$opcionMenu = "dashboard";
		View::set("opcionMenu", $opcionMenu);
		
		View::render( "portal_manager_home" );
		
	}

	/**
	 * mostrar la página de "Cargando Reportes...."
	 */ 
	public static function cargar_reporte_equipos(){
		
		session_start();

		View::set("user", $_SESSION['logged_user'] );

		$opcionMenu = "cargando_dashboard";
		View::set("opcionMenu", $opcionMenu);

		View::set("pageTitle", "Cargando Reporte de Equipos...");

		/*
		 * Buscando un tip en la BD
		 */
		$max_id = Equipos::getMaxID("TipsUsoPortal");

		$tip = Clients::getTip( $max_id, $_SESSION['role_user'] );
		View::set("tip", $tip);

		/*
		 * A qué funcion se va a llamar:
		 */
		View::set("funcionAcargar", "reportes_equipos");

		View::render( "portal_manager_home" );
	}


	/**
	 * Menú Equipos -> Reportes
	 */ 
	public static function reportes_equipos($anyo){

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user);

		try {
			$empresaId = $_SESSION['logged_user_empresaId'];

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


			/**/
			$info = "Reporte:Equipos, generado - Gerentes.php";
			Transaccion::insertTransaccion("Generar_Reporte", "Ok", $user->id, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );
		
		} catch (Exception $e) {
			$internalErrorCodigo  = "Exception in controllers.Gerentes.reportes_equipos()";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "empresaId:$empresaId | userId:" . $user->id;
			
			/**/
			Transaccion::insertTransaccionException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra, $_SESSION['role_user'], $tech->id);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}

		/* VISTA */
		$opcionMenu = "reportes_equipos";
		View::set("opcionMenu", $opcionMenu);
		
		View::render( "portal_manager_home" );
	}


	/**
	 * mostrar la página de "Cargando Incidencias...."
	 */ 
	public static function cargar_reporte_incidencias(){
		
		session_start();

		View::set("user", $_SESSION['logged_user'] );

		$opcionMenu = "cargando_dashboard";
		View::set("opcionMenu", $opcionMenu);

		View::set("pageTitle", "Cargando Reporte de Incidencias...");

		/*
		 * Buscando un tip en la BD
		 */
		$max_id = Equipos::getMaxID("TipsUsoPortal");

		$tip = Clients::getTip( $max_id, $_SESSION['role_user'] );
		View::set("tip", $tip);

		/*
		 * A qué funcion se va a llamar:
		 */
		View::set("funcionAcargar", "reportes_incidencias");

		View::render( "portal_manager_home" );
	}


	/**
	 * Menu Incidencias -> Reportes
	 */ 
	public static function reportes_incidencias($anyo){

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user);

		try {
			$empresaId = $_SESSION['logged_user_empresaId'];

			$company = Empresas::getEmpresa($empresaId);
			View::set("empresa", $company);

			View::set("pageTitle", "Reporte: Incidencias en su Empresa" );


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


			/**/
			$info = "Reporte:Incidencias, generado - Gerentes.php";
			Transaccion::insertTransaccion("Generar_Reporte", "Ok", $user->id, $_SESSION['role_user'], $_SESSION['logged_user_empresaId'] , $info );

		} catch (Exception $e) {
			$internalErrorCodigo  = "Exception in controllers.Gerentes.reportes_incidencias()";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "empresaId:$empresaId | userId:" . $user->id;
			
			/**/
			Transaccion::insertTransaccionException("Generar_Reporte",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra, $_SESSION['role_user'], $tech->id);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");
			die;
		}

		/* VISTA */
		$opcionMenu = "reportes_incidencias";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_manager_home" );
	}

	/**
	 * mostrar solo Reportes de Visita
	 */ 
	public static function reportes_de_visita(){

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user);

		$empresaId = $_SESSION['logged_user_empresaId'];

		$reportesVisita = Reportes::reportesDeVisita($empresaId, "");

		if ( $reportesVisita == NULL || $reportesVisita =="" ){
			View::set("no_reportes_de_visita", "no_reportes_de_visita");
		} else {
			View::set("reportesVisita", $reportesVisita);
		}

		View::set("pageTitle", "Reporte de Trabajos realizados en su Empresa" );

		/* VISTA */
		$opcionMenu = "reportes_de_visita";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_manager_home" );
	}


	/**
	 * mostrar la página de "Cargando Reportes...."
	 */ 
	public static function cargar_historial_equipos(){
		
		session_start();

		View::set("user", $_SESSION['logged_user'] );

		$opcionMenu = "cargando_dashboard";
		View::set("opcionMenu", $opcionMenu);

		View::set("pageTitle", "Cargando Historial de Equipos...");

		/*
		 * Buscando un tip en la BD
		 */
		$max_id = Equipos::getMaxID("TipsUsoPortal");

		$tip = Clients::getTip( $max_id, $_SESSION['role_user'] );
		View::set("tip", $tip);

		/*
		 * A qué funcion se va a llamar:
		 */
		View::set("funcionAcargar", "historialEquipos");

		View::render( "portal_manager_home" );
	}


	/**
	 * Buscar el Historial de las cosas hechas a Equipos
	 */
	public static function historialEquipos(){

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user );

		View::set("pageTitle", "Trabajos realizados sobre los Equipos de su Empresa");

		$empresaId = $_SESSION['logged_user_empresaId'];
		$usuarioId = $user->id;


		/* Equipo(s) de este Usuario (SI ES QUE TIENE) */
		$misEquipos = Equipos::getEquipos($usuarioId, $empresaId);

		if ( $misEquipos == NULL || $misEquipos == "" ){
			View::set("no_mis_equipos", "no_mis_equipos");

		} else {

			$resultado = Equipos::getHistorialEquipos($misEquipos);

			View::set("cantidad_mis_equipos", $resultado[0]);
			View::set("mis_equipos_info", 	  $resultado[1]);
		}

		
		/* Equipo(s) de la EMPRESA */
		$inventarioEquipos = Equipos::getEquiposDeEmpresaSinEsteUsuario($empresaId, $usuarioId);

		if ( $inventarioEquipos == NULL || $inventarioEquipos == "" ){
			View::set("no_equipos", "no_equipos");

		} else {

			$resultado2 = Equipos::getHistorialEquipos($inventarioEquipos);

			View::set("cantidad_equipos", $resultado2[0]);
			View::set("equipos_info", 	  $resultado2[1]);
		}

		/* VISTA */
		$opcionMenu = "historial_equipos";
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_manager_home" );
	}

	/**
	 * Enviar correo al Admin. de LanuzaSoft para dar de BAJA a este usuario
	 */
	public static function dar_de_baja(){

		session_start();

		$user = $_SESSION['logged_user'];

		View::set("user", $user);

		if ( isset( $_POST['bajarUsuarioId'] ) ){

			$empresaId = $_SESSION['logged_user_empresaId'];
			
			/* usuario a eliminar */
			$usuarioId  = $_POST['bajarUsuarioId'];
			$nombre 	= $_POST['bajarUsuarioNombre'];
			$apellido 	= $_POST['bajarUsuarioApellido'];

			EmailManagement::solicitudDarDeBajaAUsuario($empresaId, $user, $usuarioId, $nombre, $apellido);
		}
		/* llamada AJAX, no hay retorno */
		echo "OK";
	}

	/**
	 * mostrar la página de "Cargando Reportes...."
	 */ 
	public static function cargar_licencias_equipos(){
		
		session_start();

		View::set("user", $_SESSION['logged_user'] );

		$opcionMenu = "cargando_dashboard";
		View::set("opcionMenu", $opcionMenu);

		View::set("pageTitle", "Cargando Historial de Equipos...");

		/*
		 * Buscando un tip en la BD
		 */
		$max_id = Equipos::getMaxID("TipsUsoPortal");

		$tip = Clients::getTip( $max_id, $_SESSION['role_user'] );
		View::set("tip", $tip);

		/*
		 * A qué funcion se va a llamar:
		 */
		View::set("funcionAcargar", "InventarioLicenciasEquipos");

		View::render( "portal_manager_home" );
	}


	/**
	 * mostrar la página de "Cargando Reportes...."
	 */ 
	public static function InventarioLicenciasEquipos(){

		session_start();

		$user = $_SESSION['logged_user'];
		View::set("user", $user );

		//
		$empresaId = $_SESSION['logged_user_empresaId'];
		$usuarioId = $user->id;
		
		//
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
		View::set("opcionMenu", $opcionMenu);

		View::render( "portal_manager_home" );
	}
}