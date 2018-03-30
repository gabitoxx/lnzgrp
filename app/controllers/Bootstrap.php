<?php
namespace app\controllers;
defined("APPPATH") OR die("Access denied");

use \core\View,
	\app\models\EmailManagement,
	\app\models\admin\user as UserAdmin;

class Bootstrap
{
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
	public function embajadoresPrueba()
	{
		View::set("pageTitle", "Lanuza Group SAS | Su empresa de Soporte TI | Official Website");

		View::render("embajadores");
	}
	public function calendario()
	{
		View::set("pageTitle", "Calendario");

		View::render("calendario");
	}


	public function emailPrueba()
	{
		session_start();
		/*
		// CLIENT ó MANAGER
		$incidenciaId = 26;
		$roleUser="client";

		$user = $_SESSION['logged_user'];

		$equipoIdIncidencia = 1;
		$tipoFalla = "Mi equipo NO enciende";
		$observaciones = " observaciones de alguien ";

		EmailManagement::sendNuevaIncidencia($incidenciaId, $user, $roleUser,
					$equipoIdIncidencia, $tipoFalla, $observaciones);
		* /
		// TECNICO
		$incidenciaId = 26;
		$tech = $_SESSION['logged_user'];
		EmailManagement::sendIncidenciaEnEspera($incidenciaId, $tech, "razon es q no encuentro..." );
		* /
		//CLIENT ó MANAGER
		$incidenciaId = 24;
		$user = $_SESSION['logged_user'];
		EmailManagement::sendIncidenciaReply( $incidenciaId, $user, "la llave esta debajo del escritorio" );
		* /
		// TECNICO
		$incidenciaId = 20;
		$tech = $_SESSION['logged_user'];
		EmailManagement::sendIncidenciaCerrada($incidenciaId, $tech, 
			"variableEndogena", "variableExogenaTecnica", "alguna variableExogenaHumana");
		* /
		// MANAGER
		$empresaId = 2;
		$user = $_SESSION['logged_user'];
		EmailManagement::nuevoSoporte($empresaId, $user, "31/12/2099", 8, "AM", "trabajoArealizar", " otraDireccion");
		* /
		// TECNICO
		$empresaId = 2;
		$tech = $_SESSION['logged_user'];
		EmailManagement::nuevoSoporteDelTech($empresaId, $tech, "31/12/2099", 8, "AM", "trabajoArealizar", " voy a inventariar");
		* / 
		$soporteId=3;
		$accion="Eliminada";
		EmailManagement::notificarSoporteTech($soporteId, $accion);
		*/
		// MANAGER
		$soporteId=3;
		$accion="aceptar_cita";
		EmailManagement::notificarSoporte($soporteId, $accion);
	}
}