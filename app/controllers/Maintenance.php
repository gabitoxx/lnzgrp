<?php
namespace app\controllers;
defined("APPPATH") OR die("Access denied");

use \core\View;

class Maintenance{

  /**
   * Para periodos de mantenimiento
   */
	public function index() {
		View::render( "maintenance" );
	}
}