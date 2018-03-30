<?php
namespace app\controllers;
defined("APPPATH") OR die("Access denied");


/**
 * Si te fijas, siempre hacemos uso de namespaces, es muy importante su uso para evitar que nuestras clases colisionen
 * entre ellas, de esta forma, podemos tener clases con el mismo nombre en diferentes namespaces.
 *
 * Comprobamos si está definida la constante APPPATH, si no es así, 
 * es que están tratando de acceder directamente al script, y eso no se puede permitir ya que 
 * se rompería la aplicación al completo.
 * 
 * Finalmente, creamos la clase Home y el método saludo con un parámetro $nombre, si accedes a 
 * http://localhost/mvc/public/home/saludo/gabriel
 * pone Hola tunombre, si es así, todo está trabajando correctamente.
 */


/**
 * AÑADIENDO VISTAS AL CONTROLADOR: 
 * Cómo puedes ver, hacemos uso de \Core\View con la sentencia use, 
 * finalmente utilizamos los métodos set y render de la clase View para renderizar la vista home,
 * que por defecto está en el directorio views
 *
 * AÑADIENDO MODELOS AL CONTROLADOR:
 * A través de la sentencia use añadir el modelo User
  * una vez hecho, ya podemos utilizarlo de la forma en la que lo hacemos en el método users, así de sencillo.
 */
use \core\View,
	\app\models\user,
	\app\models\admin\user as UserAdmin;


class Home
{
	public function saludo($nombre)
	{
		/*
		 * comprombando que sí funciona: echo "Hola " . $nombre;
		 *  http://localhost/mvc/public/home/saludo/unNombreDeAlguien
		 */

		/**
		 * Pasando Variables a la Vista
		 */
		View::set("name", $nombre);
		View::set("title", "Custom MVC");

		/**
		 * Llamando a la Vista
		 */
		View::render("home");
	}

	/*********************************************************************************************
	 * REDIRECCIONES DEL MENÚ
	 */
	public function index()
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

	function aboutUs(){
		/*Lanuza Group SAS - Official Website*/
		View::set("pageTitle", "Sobre Lanuza Group | Su empresa de Soporte TI");

		View::render("nosotros");
	}
	function services(){

		View::set("pageTitle", "Servicios de Lanuza Group | Su empresa de Soporte TI");

		View::render("servicios");
	}
	function clients(){

		View::set("pageTitle", "Nuestros Clientes, Amigos y Aliados | Lanuza Group SAS | Official Website");

		View::render("clientes");
	}
	function contact(){

		View::set("pageTitle", "Contacta a Lanuza Group: tu empresa de Soporte TI");

		View::render("contacto");
	}
	function infrastructure(){

		View::set("pageTitle", "Infraestrucutra: Completo asesoramiento, instalación y mantenimiento | Lanuza Group SAS ");

		View::render("infraestructura");
	}
	function ITSupport(){

		View::set("pageTitle", "Soporte en Tecnologías de la Información: equipos, datos, programas y más | Lanuza Group SAS ");

		View::render("soporteti");
	}
	function store(){

		View::set("pageTitle", "Tienda IT: Todo lo que necesites + instalación + mantenimiento | Lanuza Group SAS ");

		View::render("store");
	}
	function downloads(){

		View::set("pageTitle", "Lanuza Group SAS | Su empresa de Soporte TI | Herramientas útiles ");

		View::render("descargas");
	}
	function underConstruction(){

		View::set("pageTitle", "Lanuza Group SAS .: En construcción :.");

		View::render("construccion");
	}

	function bootstrap(){

		View::set("pageTitle", "probando bootstrap -- Lanuza Group SAS .: En construcción :.");

		View::render("contactor");
	}

	/**
	 *
	 */
	function contactMail(){

		if(!empty($_POST['nombre']) AND !empty($_POST['correo'])
				AND !empty($_POST['celular']) AND !empty($_POST['mensaje']) ){

			$to = CONTACTEMAIL1;

			$headers = "Content-Type: text/html; charset=iso-8859-1\n"; 
			$headers .= "From:".$_POST['correo']."\r\n";            

			$tema="Contacto desde el Sitio Web";

			$mensaje="
			<table border='0' cellspacing='2' cellpadding='2'>
			<tr>
				<td width='20%' align='center' rowspan='4'><span class='glyphicon glyphicon-envelope logo-small'></span></td>
				<td width='20%' align='center' bgcolor='#FFFFCC'><strong>Nombre:</strong></td>
				<td width='50%' align='left'>&nbsp;&nbsp; $_POST[nombre]</td>
				<td align='center' rowspan='4'><span class='glyphicon glyphicon-ok logo-small'></span></td>
			</tr>
			<tr>
				<td align='center' bgcolor='#FFFFCC'><strong>E-mail:</strong></td>
				<td align='left'>&nbsp;&nbsp; $_POST[correo]</td>
			</tr>
			<tr>
				<td align='center' bgcolor='#FFFFCC'><strong>Asunto</strong></td>
				<td align='left'>&nbsp;&nbsp; $_POST[celular]</td>
			</tr>
			<tr>
				<td align='center' bgcolor='#FFFFCC'><strong>Comentario:</strong></td>
				<td align='left'>&nbsp;&nbsp; $_POST[mensaje]</td>
			</tr>
			</table>
			<br />Muchas gracias por habernos contactado. A la brevedad posible nos pondremos en contacto con usted.<br />
			";

			/* @mail($to,$tema,$mensaje,$headers); */
			mail("$to","$tema","$mensaje","$headers");
			
			unset($contact_mail_error);

			/* echo $mensaje; */
			$index_message_title = "Correo enviado satisfactoriamente";
			View::set("pageTitle", $index_message_title);

			/* SETEANDO las variables para que se vean en la vista MODAL del index */
			View::set("index_message_title", $index_message_title);
			View::set("index_message", $mensaje);

			View::render("index");

		} else {
			View::set("contact_mail_error", "No se puede enviar el formulario de Contacto, verifique todos los campos");

			View::render("index");
		}
	}

}