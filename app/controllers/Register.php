<?php
namespace app\controllers;
defined("APPPATH") OR die("Access denied");

use \core\View,
	\app\models\admin\Company as Company;

class Register{

	public function index() {
		/* comprombando que sí funciona:  echo "Hola index"; */

		/* obteniendo empresas */
		$companies = Company::getAll();

		/* seteando valores y redirecionando */
		View::set("pageTitle", "Registro de nuevo Usuario | Lanuza Group SAS ");

		View::set("empresas", $companies);

		View::render("register_new");
	}
}