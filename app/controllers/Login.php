<?php
namespace app\controllers;
defined("APPPATH") OR die("Access denied");

use \core\View;

class Login{

	public function index()
	{
		/* comprombando que sí funciona:  echo "Hola index"; */

		/**
		 * Pasando Variables a la Vista
		 */
		View::set("pageTitle", "Ingreso de Clientes y Técnicos | Lanuza Group SAS | Su empresa de Soporte TI | Official Website");

		/**
		 * Llamando a la Vista
		 */
		View::render("login_form");
	}
}