<?php
namespace app\models;
defined("APPPATH") OR die("Access denied");

use \core\View,
	\app\models\Empresas,
	\app\models\Incidencias,
	\app\models\Soportes,
	\app\models\admin\Transaccion;
 
class EmailManagement {

	/* ANTES: http://lanuzagroup.com/login  */
	private static $iniPage ="http://lanuzasoft.com/";

	public static function recordarPassword($user){

		try {

			$to = $user->email;

			$headers = "Content-Type: text/html; charset=iso-8859-1\n"; 
			$headers .= "From:". CONTACTEMAIL1 ."\r\n";            

			$tema =  $user->saludo . " " . $user->nombre . " " . $user->apellido
				. ": su contraseña del Portal Lanuza Group";

			$mensaje="
					<b>PORTAL LANUZA GROUP </b>
					<br/><br/>"
					."<b>". $user->saludo . " " . $user->nombre . " " . $user->apellido . "</b>"
					. "<br/><br/>
					Para seguir disfrutando de nuestros servicios, le enviamos su contrase&ntilde;a nuevamente:
					<br/><br/>
					"
					. "<br/>Usuario:   " . $user->usuario
					. "<br/>Contrase&ntilde;a:" . $user->password
					. "<br/><br/><br/>"
					. " Para ingresar directamente al LOGIN del Portal ingrese en el siguiente link:
						<br/><br/>
						<a href=\"" . self::$iniPage . "\" target=\"_blank\">" . self::$iniPage . "</a>
						<br/><br/>
					    Muchas gracias por usar nuestros servicios.
					    <br/><br/>
					    --<br/>
					    Atte.<br/>
					    <i>El Equipo T&eacute;cnico de <b>Lanuza Group</b></i>"
			;
			
			/* @mail($to,$tema,$mensaje,$headers); */
			mail("$to","$tema","$mensaje","$headers");

			return true;

		} catch( Exception $e) {
			$internalErrorCodigo  = "Exception in models.EmailManagement.recordarPassword():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $user->saludo . " " . $user->nombre . " " . $user->apellido;
			
			/**/
			Transaccion::insertTransaccionPDOException("Usuario_Olvido_password",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");

			return false;
		}
	}

	/**
	 * Cuando se crea un NUEVO usuario
	 */
	public static function nuevoUsuarioCreado($user){
		try {
			$to = "" . CONTACTEMAIL1 . "," . CONTACT_EMAIL_3 . "," . $user->email;

			$headers = "Content-Type: text/html; charset=iso-8859-1\n"; 
			$headers .= "From:". CONTACTEMAIL1 ."\r\n";            

			$tema = "NUEVO USUARIO CREADO: " . $user->saludo . " " . $user->nombre . " " . $user->apellido
				. ", en Portal Lanuza Group";

			$mensaje="
					<b>PORTAL LANUZA GROUP </b>
					<br/><br/>"
					."Se ha creado un NUEVO Usuario en el Sistema: <b>". $user->saludo . " " . $user->nombre . " " . $user->apellido . "</b>"
					. "<br/><br/>
					Más info:
					<br/><br/>
					"
					. "<br/>Usuario:   " . $user->usuario
					. "<br/>Email corporativo:" . $user->email
					. "<br/>Estatus actual:" . $user->activo
					. "<br/><br/><br/>"
					. " Si su Estatus NO es 'Activo', debe esperar a que el Equipo Técnico de LanuzaGroup autorice la creación de este nuevo Usuario.
						<br/><br/>
						Para ingresar directamente al LOGIN del Portal ingrese en el siguiente link:
						<br/><br/>
						<a href=\"" . self::$iniPage . "\" target=\"_blank\">" . self::$iniPage . "</a>
						<br/><br/>
					    Muchas gracias por usar nuestros servicios.
					    <br/><br/>
					    --<br/>
					    Atte.<br/>
					    <i>El Equipo T&eacute;cnico de <b>Lanuza Group</b></i>"
			;
			
			mail("$to","$tema","$mensaje","$headers");

			return true;

		} catch( Exception $e) {
			$internalErrorCodigo  = "Exception in models.EmailManagement.recordarPassword():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $user->saludo . " " . $user->nombre . " " . $user->apellido;
			
			/**/
			Transaccion::insertTransaccionPDOException("Usuario_Olvido_password",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");

			return false;
		}
	}

	/**
	 * De: el que ejecuta la Acción
	 * Para: la Persona directa que debe Enterarse
	 * Empresa: para mandar una Copia al Usuario de la Empresa
	 *
	 * Los correos deben seguir este patrón:
	 *     ACCIÓN (de)					MANDAR A (para)
	 *  User->Crear Incidencia		Lanuza Soporte
	 *  Tech->Asigna Incidencia		Lanuza Soporte, User que la creo, Managers de la Empresa
	 *  Tech->Poner en Espera		Lanuza Soporte, User que la creo
	 *  User->reply al Tech 		Lanuza Soporte, Tech
	 *	Tech->Resolver 				Lanuza Soporte, User que la creo, Managers de la Empresa
	 *
	 *  Tech->Inventario			Lanuza Soporte, Tech, Managers de la Empresa
	 */
	public static function enviarEmailAccion($deUsuarioId, $paraUsuarioId, $empresaId, $incidenciaId, $equipoId){

	}

	/**
	 * De: el que ejecuta la Acción
	 * Para: la Persona directa que debe Enterarse
	 * Empresa: para mandar una Copia al Usuario de la Empresa
	 *
	 * Los correos deben seguir este patrón:
	 *     ACCIÓN (de)					MANDAR A (para)
	 *  User->Crear Incidencia		Lanuza Soporte
	 */
	public static function sendNuevaIncidencia($incidenciaId, $user, $roleUser,
					$equipoIdIncidencia, $tipoFalla, $observaciones){

		$userId		= $user->id;
		$empresaId  = $user->empresaId;


		$to="";

		if ( $roleUser == "client" ){
			/* NOTIFICAR A: cliente, Partner y Lanuza */

			$mail = $user->email . "," ;

			$emails = Empresas::getEmailsDeManagersDeEmpresa( $empresaId );

			foreach ($emails as $email) {
				
				$mail .= $email["email"] . "," ;
			}

			/* substring el ultimo caracter */
			$mail = rtrim($mail,",");

		} else if ( $roleUser == "manager" ){
			/* NOTIFICAR A: Partner y Lanuza */

			$mail = $user->email;
		}

		/*
		 * Para enviar un correo HTML, debe establecerse la cabecera Content-type
		 */
		$cabeceras  = "MIME-Version: 1.0" . "\r\n";
		$cabeceras .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";

		/* Cabeceras adicionales */
		$cabeceras .= "To: " . $mail . "," . CONTACTEMAIL1 . "\r\n";
		$cabeceras .= "From: " . CONTACTEMAIL1 . "\r\n";
		$cabeceras .= "Cc: " . CONTACTEMAIL1 . "\r\n";
		$cabeceras .= "Bcc: " . CONTACT_EMAIL_3 . "\r\n";
		$cabeceras .= "X-Mailer: PHP\r\n";
		$cabeceras .= "X-Priority: 1"; // fijo prioridad

		/*
	 	 * Subject
		 */
		$tema = "LanuzaGroup :: " . $user->saludo . " " . $user->nombre . " " . $user->apellido
				. ": nueva Incidencia # $incidenciaId creada en el Portal Lanuza Group";

		if ( $equipoIdIncidencia != NULL || $equipoIdIncidencia != "" ){
			$equipoIdIncidencia = "Falla en equipo (ID de sistema: $equipoIdIncidencia)";
		} else {
			$equipoIdIncidencia = "No Registra";
		}

		/*
	 	 * Body
		 */
		$mensaje = "
					<b>PORTAL LANUZA GROUP </b>
					<br/><br/>"
					."<b>". $user->saludo . " " . $user->nombre . " " . $user->apellido . "</b>"
					. "<br/><br/>
					Cordial saludo.
					Usted ha generado una nueva Incidencia en nuestro Portal de LanuzaGroup.
					Se ha creado satisfactoriamente con estas caracter&iacute;sticas:
					<br/><br/>
					"
					. "<br/>Incidencia n&uacute;mero:   " . $incidenciaId
					. "<br/>Creada por: " . $user->nombre . " " . $user->apellido
					. "<br/>Equipo: " . $equipoIdIncidencia
					. "<br/>Tipo de Falla: " . $tipoFalla
					. "<br/>Observaciones del usuario: " . $observaciones
					. "<br/><br/><br/>"
					. " Nuestros Ingenieros de Soporte ya fueron notificados de la Incidencia creada y, tan pronto como est&eacute;n disponibles, alguno de ellos atender&aacute; su requerimiento y procederemos a notificarle."
					. "<br/><br/><br/>"
					. " Para ingresar directamente al LOGIN del Portal ingrese en el siguiente link:
						<br/><br/>
						<a href=\"" . self::$iniPage . "\" target=\"_blank\">" . self::$iniPage . "</a>
						<br/><br/>
					    Muchas gracias por usar nuestros servicios.
					    <br/><br/>
					    --<br/>
					    Atte.<br/>
					    <i>El Equipo T&eacute;cnico de <b>Lanuza Group</b></i>"
			;
/* echo "$mail"."<br/>"."$tema"."<br/>"."$mensaje"."<br/>"."$cabeceras"; */
		mail("$mail","$tema","$mensaje","$cabeceras");

		return true;
	}

	/**
	 * De: el que ejecuta la Acción
	 * Para: la Persona directa que debe Enterarse
	 * Empresa: para mandar una Copia al Usuario de la Empresa
	 *
	 * Los correos deben seguir este patrón:
	 *     ACCIÓN (de)					MANDAR A (para)
	 *  Tech->Poner en Espera		Lanuza Soporte, User que la creo
	 */
	public static function sendIncidenciaEnEspera( $incidenciaId, $tech, $razon ){

		/*
		 * Buscando el usuario que generó esta incidencia
		 */
		$user = Incidencias::getUsuarioCreadorDeIncidencia($incidenciaId);

		$to = $user->email;

		/*
		 * Para enviar un correo HTML, debe establecerse la cabecera Content-type
		 */
		$cabeceras  = "MIME-Version: 1.0" . "\r\n";
		$cabeceras .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";

		/* Cabeceras adicionales */
		$cabeceras .= "To: " . $user->email . "\r\n";
		$cabeceras .= "From: " . CONTACTEMAIL1 . "\r\n";
		$cabeceras .= "Cc: " . CONTACTEMAIL1 . "\r\n";
		$cabeceras .= "Bcc: " . CONTACT_EMAIL_3 . "\r\n";
		$cabeceras .= "X-Mailer: PHP\r\n";
		$cabeceras .= "X-Priority: 1"; // fijo prioridad

		/*
	 	 * Subject
		 */
		$tema = "LanuzaGroup :: " . $user->saludo . " " . $user->nombre . " " . $user->apellido
				. ", nuestro Ingeniero de Soporte necesita su ayuda con la Incidencia # $incidenciaId";

		/*
	 	 * Body
		 */
		$mensaje = "
					<b>PORTAL LANUZA GROUP </b>
					<br/><br/>"
					. "<br/><br/>
					Cordial saludo.
					Con respecto a la Incidencia generada por usted, nuestro Ingeniero de Soporte asignado ("
					. $tech->saludo . " " . $tech->nombre . " " . $tech->apellido
					. ") 
					requiere cierta informaci&oacute;n que le detiene de poder continuar con la Soluci&oacute;n de la incidencia:
					<br/><br/>
					"
					. "<br/>Incidencia n&uacute;mero:   " . $incidenciaId
					. "<br/><b>Raz&oacute;n por la que NO puede avanzar en la Soluci&oacute;n de esta Incidencia</b>: <i>" . $razon
					. "</i> <br/><br/><br/>"
					. " Usted tiene la posibilidad de entregar esta informaci&oacute;n al Ingeniero de Soporte a trav&eacute;s del Portal, en la Incidencia busque la opci&oacute;n <b>Responder al Ing. de Soporte</b>."
					. "<br/> Luego podr&aacute; continuar con la resoluci&oacute;n del inconveniente. <br/><br/>"
					. " Para ingresar directamente al LOGIN del Portal ingrese en el siguiente link:
						<br/><br/>
						<a href=\"" . self::$iniPage . "\" target=\"_blank\">" . self::$iniPage . "</a>
						<br/><br/>
					    Muchas gracias por usar nuestros servicios.
					    <br/><br/>
					    --<br/>
					    Atte.<br/>
					    <i>El Equipo T&eacute;cnico de <b>Lanuza Group</b></i>"
			;
/* echo "$to"."<br/>"."$tema"."<br/>"."$mensaje"."<br/>"."$cabeceras"; */
		mail("$to","$tema","$mensaje","$cabeceras");

		return true;
	}


	/**
	 * Los correos deben seguir este patrón:
	 *     ACCIÓN (de)					MANDAR A (para)
	 *  User->reply al Tech 	  	Lanuza Soporte, Tech
	 */
	public static function sendIncidenciaReply( $incidenciaId, $user, $comentario ){
		/*
		 * Buscando el usuario que generó esta incidencia
		 */
		$tech = Incidencias::getTecnicoDeIncidencia($incidenciaId);

		$to = $tech->email;

		/*
		 * Para enviar un correo HTML, debe establecerse la cabecera Content-type
		 */
		$cabeceras  = "MIME-Version: 1.0" . "\r\n";
		$cabeceras .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";

		/* Cabeceras adicionales */
		$cabeceras .= "To: " . $to . "\r\n";
		$cabeceras .= "From: " . CONTACTEMAIL1 . "\r\n";
		$cabeceras .= "Cc: " . CONTACTEMAIL1 . "\r\n";
		$cabeceras .= "Bcc: " . CONTACT_EMAIL_3 . "\r\n";
		$cabeceras .= "X-Mailer: PHP\r\n";
		$cabeceras .= "X-Priority: 1"; // fijo prioridad

		/*
	 	 * Subject
		 */
		$tema = "LanuzaGroup :: " . $tech->saludo . " " . $tech->nombre . " " . $tech->apellido
				. ", sobre la Incidencia # $incidenciaId";

		/*
	 	 * Body
		 */
		$mensaje = "
					<b>PORTAL LANUZA GROUP </b>
					<br/><br/>"
					. "<br/><br/>
					La informaci&oacute;n que usted solicit&oacute; a "
					. $user->saludo . " " . $user->nombre . " " . $user->apellido
					. " ha sido respondido:
					<br/><br/>
					"
					. "<br/>Incidencia n&uacute;mero:   " . $incidenciaId
					. "<br/><b>Respuesta</b>: <i>" . $comentario
					. "</i> <br/><br/><br/>"
					. " Ingrese al Portal para continuar con la resoluci&oacute;n de la Incidencia. Para ingresar directamente al LOGIN del Portal ingrese en el siguiente link:
						<br/><br/>
						<a href=\"" . self::$iniPage . "\" target=\"_blank\">" . self::$iniPage . "</a>
						<br/><br/>
					    Muchas gracias por usar nuestros servicios.
					    <br/><br/>
					    --<br/>
					    Atte.<br/>
					    <i>El Equipo T&eacute;cnico de <b>Lanuza Group</b></i>"
			;
/* echo "$to"."<br/>"."$tema"."<br/>"."$mensaje"."<br/>"."$cabeceras"; */
		mail("$to","$tema","$mensaje","$cabeceras");

		return true;
	}

	/**
	 * Los correos deben seguir este patrón:
	 *     ACCIÓN (de)					MANDAR A (para)
	 *	Tech->Resolver 				Lanuza Soporte, User que la creo, Managers de la Empresa
	 */
	public static function sendIncidenciaCerrada($incidenciaId, $tech, 
			$variableEndogena, $variableExogenaTecnica, $variableExogenaHumana){

		/*
		 * Buscando el usuario que generó esta incidencia
		 */
		$user = Incidencias::getUsuarioCreadorDeIncidencia($incidenciaId);

		if ( $user->role == "client" ){
			/* NOTIFICAR A: cliente, Partner y Lanuza */

			$mail = $user->email . "," ;

			$emails = Empresas::getEmailsDeManagersDeEmpresa( $user->empresaId );

			foreach ($emails as $email) {
				
				$mail .= $email["email"] . "," ;
			}

			/* substring el ultimo caracter */
			$mail = rtrim($mail,",");

		} else if ( $user->role == "manager" ){
			/* NOTIFICAR A: Partner y Lanuza */

			$mail = $user->email;
		}

		/*
		 * Para enviar un correo HTML, debe establecerse la cabecera Content-type
		 */
		$cabeceras  = "MIME-Version: 1.0" . "\r\n";
		$cabeceras .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";

		/* Cabeceras adicionales */
		$cabeceras .= "To: " . $mail . "\r\n";
		$cabeceras .= "From: " . CONTACTEMAIL1 . "\r\n";
		$cabeceras .= "Cc: " . CONTACTEMAIL1 . "\r\n";
		$cabeceras .= "Bcc: " . CONTACT_EMAIL_3 . "\r\n";
		$cabeceras .= "X-Mailer: PHP\r\n";
		$cabeceras .= "X-Priority: 1"; // fijo prioridad

		/*
	 	 * Subject
		 */
		$tema = "LanuzaGroup :: " . $user->saludo . " " . $user->nombre . " " . $user->apellido
				. ", la Incidencia # $incidenciaId ha sido RESUELTA.";

		/*
	 	 * Body
		 */
		$mensaje = "
					<b>PORTAL LANUZA GROUP </b>
					<br/><br/>"
					. "<br/><br/>
					Cordial saludo.
					Con respecto a la Incidencia # $incidenciaId ha sido <b>resuelta</b> por nuestro Ingeniero de Soporte asignado ("
					. $tech->saludo . " " . $tech->nombre . " " . $tech->apellido
					. "). A continuaci&oacute;n, un breve resumen de su reporte:
					<br/><br/>
					"
					. "<br/>Incidencia n&uacute;mero:   " . $incidenciaId
					. "<br/><b>Resumen</b>: <i>" . $variableEndogena . $variableExogenaTecnica . $variableExogenaHumana
					. "</i> <br/><br/><br/>"
					. " Usted tiene la posibilidad ahora de <b>Ver el Reporte completo</b> y tambi&eacute;n de <u>Certificar</u> dicha Soluci&oacute;n 
					(esto es, validar la soluci&oacute;n dada por el Ing. de Soporte). 
					Si certifica la Incidencia, nos dar&aacute; su opini&oacute;n que para nosotros es muy valiosa 
					para mejorar nuestra Calidad de Servicio. <br/><br/>"
					. " Para ingresar directamente al LOGIN del Portal ingrese en el siguiente link:
						<br/><br/>
						<a href=\"" . self::$iniPage . "\" target=\"_blank\">" . self::$iniPage . "</a>
						<br/><br/>
					    Muchas gracias por usar nuestros servicios.
					    <br/><br/>
					    --<br/>
					    Atte.<br/>
					    <i>El Equipo T&eacute;cnico de <b>Lanuza Group</b></i>"
			;

/* echo "$mail"."<br/>"."$tema"."<br/>"."$mensaje"."<br/>"."$cabeceras"; */
		mail("$mail","$tema","$mensaje","$cabeceras");

		return true;
	}

	/**
	 * Nuevo Soporte Programado creado por un MANAGER
	 */
	public static function nuevoSoporte($empresaId, $user, $fechaCita, $hora, $amPM, $trabajoArealizar, $otraDireccion){
		try {
			/* Empresa creadora */
			$company = Empresas::getEmpresa($empresaId);

			$to = CONTACTEMAIL1 . "," . CONTACT_EMAIL_3;

			/*
			 * Para enviar un correo HTML, debe establecerse la cabecera Content-type
			 */
			$cabeceras  = "MIME-Version: 1.0" . "\r\n";
			$cabeceras .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";

			/* Cabeceras adicionales */
			$cabeceras .= "To: " . $to . "\r\n";
			$cabeceras .= "From: " . CONTACTEMAIL1 . "\r\n";
			$cabeceras .= "X-Mailer: PHP\r\n";
			$cabeceras .= "X-Priority: 1"; // fijo prioridad

			$tema =  "(CITA) Propuesta de Soporte Programado, creado por "
					. $user->saludo . " " . $user->nombre . " " . $user->apellido;

			$mensaje="
					<b>PORTAL LANUZA GROUP </b>
					<br/><br/>"
					."<b>Propuesta de cita para Soporte Programado creado por ". $user->saludo . " " . $user->nombre . " " . $user->apellido . "</b>"
					. "<br/><br/>
					Info:
					<br/><br/>
					"
					. "<br/>Empresa:   " . $company->nombre . " (" . $company->razonSocial . ") "
					. "<br/>D&iacute;a:" . $fechaCita
					. "<br/>Hora:" . $hora . " " . $amPM
					. "<br/>Extra info:" . $trabajoArealizar . " " . $otraDireccion
					. "<br/><br/><br/>"
					. " Para ingresar directamente al LOGIN del Portal ingrese en el siguiente link:
						<br/><br/>
						<a href=\"" . self::$iniPage . "\" target=\"_blank\">" . self::$iniPage . "</a>
						<br/><br/>
					    Muchas gracias por usar nuestros servicios.
					    <br/><br/>
					    --<br/>
					    Atte.<br/>
					    <i>El Equipo T&eacute;cnico de <b>Lanuza Group</b></i>"
			;
			
/* echo "$to"."<br/>"."$tema"."<br/>"."$mensaje"."<br/>"."$cabeceras"; */
			mail("$to","$tema","$mensaje","$cabeceras");

			return true;

		} catch( Exception $e) {
			$internalErrorCodigo  = "Exception in models.EmailManagement.nuevoSoporte():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $user->saludo . " " . $user->nombre . " " . $user->apellido;
			
			/**/
			Transaccion::insertTransaccionPDOException("Soporte_crear",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
		}
	}

	/**
	 * Nuevo Soporte Programado creado por un TECH
	 */
	public static function nuevoSoporteDelTech($empresaId, $tech, $fechaCita, $hora, $amPM, $trabajoArealizar, $inventarioInfo){
		try {
			/* Empresa creadora */
			$company = Empresas::getEmpresa($empresaId);

			/* posiblemente Varios Emails */
			$emails = Empresas::getEmailsDeManagersDeEmpresa( $empresaId );

			$mail="";
			foreach ($emails as $email) {
				
				$mail .= $email["email"] . "," ;
			}

			/* substring el ultimo caracter */
			$mail = rtrim($mail,",");

			/*
			 * Para enviar un correo HTML, debe establecerse la cabecera Content-type
			 */
			$cabeceras  = "MIME-Version: 1.0" . "\r\n";
			$cabeceras .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";

			/* Cabeceras adicionales */
			$cabeceras .= "To: " . $mail . "\r\n";
			$cabeceras .= "From: " . CONTACTEMAIL1 . "\r\n";
			$cabeceras .= "Cc: " . CONTACTEMAIL1 . "\r\n";
			$cabeceras .= "Bcc: " . CONTACT_EMAIL_3 . "\r\n";
			$cabeceras .= "X-Mailer: PHP\r\n";
			$cabeceras .= "X-Priority: 1"; // fijo prioridad

			$tema =  "LanuzaGroup :: Propuesta de Soporte Programado, cita creada para "
					. $company->nombre . " ( " . $company->razonSocial . " )";

			$mensaje="
					<b>PORTAL LANUZA GROUP </b>
					<br/><br/>"
					."<b>Propuesta de cita para Soporte Programado creado por ". $tech->saludo . " " . $tech->nombre . " " . $tech->apellido . "</b>"
					. "<br/><br/>
					En nuestro portal, Usted puede <i>Editar la hora</i>, <b>Aceptar</b> o <u>Eliminar</u> esta cita agendada. Aqu&iacute; la info:
					<br/><br/>
					"
					. "<br/>Empresa:   " . $company->nombre . " (" . $company->razonSocial . ") "
					. "<br/>D&iacute;a:" . $fechaCita
					. "<br/>Hora:" . $hora . " " . $amPM
					. "<br/>Extra info:" . $trabajoArealizar . " " . $inventarioInfo
					. "<br/><br/><br/>"
					. " Para ingresar directamente al LOGIN del Portal ingrese en el siguiente link:
						<br/><br/>
						<a href=\"" . self::$iniPage . "\" target=\"_blank\">" . self::$iniPage . "</a>
						<br/><br/>
					    Muchas gracias por usar nuestros servicios.
					    <br/><br/>
					    --<br/>
					    Atte.<br/>
					    <i>El Equipo T&eacute;cnico de <b>Lanuza Group</b></i>"
			;
			
/* echo "$mail"."<br/>"."$tema"."<br/>"."$mensaje"."<br/>"."$cabeceras"; */
			mail("$mail","$tema","$mensaje","$cabeceras");

			return true;

		} catch( Exception $e) {
			$internalErrorCodigo  = "Exception in models.EmailManagement.nuevoSoporteDelTech():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "tech:".$tech->id . " | empresa:" . $empresaId;
			
			/**/
			Transaccion::insertTransaccionPDOException("Soporte_crear",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
		}
	}

	/**
	 * Soporte Programado updated by TECH
	 */
	public static function notificarSoporteTech($soporteId, $accion){
		$tipo_transaccion="";
		$mensaje="";

		if ( $accion == "cambiar_hora" ){

			$tipo_transaccion="Soporte_reprogramar";
			$mensaje = "Uno de los Soportes Programados ha sido actualizado en su fecha/hora. ";

		} else if ( $accion == "aceptar_cita" ){

			$tipo_transaccion="Soporte_aceptar_reprogramacion";
			$mensaje = "Se ha aceptado la cita agendada de Soporte Programado. ";

		} else if ( $accion == "Eliminada" ){

			$tipo_transaccion="Soporte_eliminar";
			$mensaje = "Una de las citas de Soporte Programado ha sido eliminada de la agenda de trabajo. ";
		}

		try {
			/* info de soporte */
			$soporte = Soportes::getById($soporteId);

			/* correos */
			$emails = Empresas::getEmailsDeManagersDeSoporte( $soporteId );

			$mail="";
			foreach ($emails as $email) {
				
				$mail .= $email["email"] . "," ;
			}

			/* substring el ultimo caracter */
			$mail = rtrim($mail,",");

			$cabeceras  = "MIME-Version: 1.0" . "\r\n";
			$cabeceras .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";

			/* Cabeceras adicionales */
			$cabeceras .= "To: " . $mail . "\r\n";
			$cabeceras .= "From: " . CONTACTEMAIL1 . "\r\n";
			$cabeceras .= "Cc: " . CONTACTEMAIL1 . "\r\n";
			$cabeceras .= "Bcc: " . CONTACT_EMAIL_3 . "\r\n";
			$cabeceras .= "X-Mailer: PHP\r\n";
			$cabeceras .= "X-Priority: 1"; // fijo prioridad

			$tema =  "LanuzaGroup :: Actualizacion de Soporte Programado (cita en la Agenda)";

			$mensaje="
					<b>PORTAL LANUZA GROUP </b>
					<br/><br/>"
					."Fue actualizado un Soporte Programado: $mensaje Para mayor informaci&oacute;n ingrese en el Portal LanuzaGroup."
					. "<br/><br/>
					En nuestro portal, Usted puede <i>Editar la hora</i>, <b>Aceptar</b> o <u>Eliminar</u> esta cita agendada. Aqu&iacute; la info:
					<br/><br/>
					"
					. "<br/>D&iacute;a:" . substr($soporte->fecha_cita, 0, 10)
					. "<br/>Hora:" . $soporte->hora_estimada . " " . $soporte->am_pm
					. "<br/>Extra info:" . $soporte->trabajoArealizar . " " . $soporte->inventario_info
					. "<br/><br/><br/>"
					. " Para ingresar directamente al LOGIN del Portal ingrese en el siguiente link:
						<br/><br/>
						<a href=\"" . self::$iniPage . "\" target=\"_blank\">" . self::$iniPage . "</a>
						<br/><br/>
					    Muchas gracias por usar nuestros servicios.
					    <br/><br/>
					    --<br/>
					    Atte.<br/>
					    <i>El Equipo T&eacute;cnico de <b>Lanuza Group</b></i>"
			;
			
/* echo "$mail"."<br/>"."$tema"."<br/>"."$mensaje"."<br/>"."$cabeceras"; */
			mail("$mail","$tema","$mensaje","$cabeceras");


		} catch( Exception $e) {
			$internalErrorCodigo  = "Exception in models.EmailManagement.nuevoSoporteDelTech():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "soporteId:" . $soporteId . " | accion:" . $accion;
			
			/**/
			Transaccion::insertTransaccionPDOException($tipo_transaccion, $internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
		}
	}


	/**
	 * Soporte Programado actualizado por un MANAGER
	 */
	public static function notificarSoporte($soporteId, $accion){
		$tipo_transaccion="";
		$mensaje="";

		if ( $accion == "cambiar_hora" ){

			$tipo_transaccion="Soporte_reprogramar";
			$mensaje = "Uno de los Soportes Programados ha sido actualizado en su fecha/hora. ";

		} else if ( $accion == "aceptar_cita" ){

			$tipo_transaccion="Soporte_aceptar_reprogramacion";
			$mensaje = "Se ha aceptado la cita agendada de Soporte Programado. ";

		} else if ( $accion == "Eliminada" ){

			$tipo_transaccion="Soporte_eliminar";
			$mensaje = "Una de las citas de Soporte Programado ha sido eliminada de la agenda de trabajo. ";
		}

		try {
			/* info de soporte */
			$soporte = Soportes::getById($soporteId);

			/* correos */
			$emails = Empresas::getEmailsDeTecnicoDeSoporte( $soporteId );

			if ( $emails == NULL || $emails == ""){
				$mail = CONTACTEMAIL1;
				
			} else {
				$mail="";
				foreach ($emails as $email) {
					
					$mail .= $email["email"] . "," ;
				}

				/* substring el ultimo caracter */
				$mail = rtrim($mail,",");
			}

			$cabeceras  = "MIME-Version: 1.0" . "\r\n";
			$cabeceras .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";

			/* Cabeceras adicionales */
			$cabeceras .= "To: " . $mail . "\r\n";
			$cabeceras .= "From: " . CONTACTEMAIL1 . "\r\n";
			$cabeceras .= "Cc: " . CONTACTEMAIL1 . "\r\n";
			$cabeceras .= "Bcc: " . CONTACT_EMAIL_3 . "\r\n";
			$cabeceras .= "X-Mailer: PHP\r\n";
			$cabeceras .= "X-Priority: 1"; // fijo prioridad

			$tema =  "LanuzaGroup :: Actualizacion de Soporte Programado (cita en la Agenda)";

			$mensaje="
					<b>PORTAL LANUZA GROUP </b>
					<br/><br/>"
					."Fue actualizado un Soporte Programado: $mensaje Para mayor informaci&oacute;n ingrese en el Portal LanuzaGroup."
					. "<br/><br/>
					En nuestro portal, Usted puede <i>Editar la hora</i>, <b>Aceptar</b> o <u>Eliminar</u> esta cita agendada. Aqu&iacute; la info:
					<br/><br/>
					"
					. "<br/>D&iacute;a:" . substr($soporte->fecha_cita, 0, 10)
					. "<br/>Hora:" . $soporte->hora_estimada . " " . $soporte->am_pm
					. "<br/>Extra info:" . $soporte->trabajoArealizar . " " . $soporte->inventario_info
					. "<br/><br/><br/>"
					. " Para ingresar directamente al LOGIN del Portal ingrese en el siguiente link:
						<br/><br/>
						<a href=\"" . self::$iniPage . "\" target=\"_blank\">" . self::$iniPage . "</a>
						<br/><br/>
					    Muchas gracias por usar nuestros servicios.
					    <br/><br/>
					    --<br/>
					    Atte.<br/>
					    <i>El Equipo T&eacute;cnico de <b>Lanuza Group</b></i>"
			;
			
			/* echo "$mail"."<br/>"."$tema"."<br/>"."$mensaje"."<br/>"."$cabeceras"; */
			mail("$mail","$tema","$mensaje","$cabeceras");


		} catch( Exception $e) {
			$internalErrorCodigo  = "Exception in models.EmailManagement.nuevoSoporteDelTech():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "soporteId:" . $soporteId . " | accion:" . $accion;
			
			/**/
			Transaccion::insertTransaccionPDOException($tipo_transaccion, $internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
		}
	}


	/**
	 * Recordatorio de Soporte Programado para MAÑANA
	 */
	public static function notificarCitaManana($mails,$message){
		try {
			$mensaje="
					<b>PORTAL LANUZA GROUP </b>
					<br/><br/>"
					. $message

					. " Nos veremos el día de mañana. Estaremos para servirle con gusto.
					<br/><br/>
					Para ingresar directamente al LOGIN del Portal ingrese en el siguiente link:
						<br/><br/>
						<a href=\"" . self::$iniPage . "\" target=\"_blank\">" . self::$iniPage . "</a>
						<br/><br/>
					    Muchas gracias por usar nuestros servicios.
					    <br/><br/>
					    --<br/>
					    Atte.<br/>
					    <i>El Equipo T&eacute;cnico de <b>Lanuza Group</b></i>"
			;

			/*
			 * Para enviar un correo HTML, debe establecerse la cabecera Content-type
			 */
			$cabeceras  = "MIME-Version: 1.0" . "\r\n";
			$cabeceras .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";

			/* Cabeceras adicionales */
			$cabeceras .= "To: " . $mails . "\r\n";
			$cabeceras .= "From: " . CONTACTEMAIL1 . "\r\n";
			$cabeceras .= "Cc: " . CONTACTEMAIL1 . "\r\n";
			$cabeceras .= "Bcc: " . CONTACT_EMAIL_3 . "\r\n";
			$cabeceras .= "X-Mailer: PHP\r\n";
			$cabeceras .= "X-Priority: 1"; // fijo prioridad

			$tema =  "LanuzaGroup :: Recordatorio de visita el día de Mañana";

			/* echo "$mails"."<br/>"."$tema"."<br/>"."$mensaje"."<br/>"."$cabeceras";  */
			mail("$mails","$tema","$mensaje","$cabeceras");


		} catch( Exception $e) {
			$internalErrorCodigo  = "Exception in models.EmailManagement.notificarCitaManana():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $user->saludo . " " . $user->nombre . " " . $user->apellido;
			
			/**/
			Transaccion::insertTransaccionPDOException("Soporte_aviso_email",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");

			return false;
		}
	}

	/**
	 * Enviar correo al Admin con CC al usuario
	 */
	public static function solicitudDarDeBajaAUsuario($empresaId, $userObject, $usuarioAEliminarId, $nombre, $apellido){
		try {
			/* Empresa creadora */
			$company = Empresas::getEmpresa($empresaId);

			$to = CONTACTEMAIL2;

			/*
			 * Para enviar un correo HTML, debe establecerse la cabecera Content-type
			 */
			$cabeceras  = "MIME-Version: 1.0" . "\r\n";
			$cabeceras .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";

			/* Cabeceras adicionales */
			$cabeceras .= "To: " . CONTACTEMAIL2 . "\r\n";
			$cabeceras .= "From: " . CONTACTEMAIL1 . "\r\n";
			$cabeceras .= "Cc: " . $userObject->email . "\r\n";
			$cabeceras .= "X-Mailer: PHP\r\n";
			$cabeceras .= "X-Priority: 1"; // fijo prioridad

			$tema =  "(INACTIVAR USUARIO) Dar de Baja | Solicitud hecha por "
					. $userObject->saludo . " " . $userObject->nombre . " " . $userObject->apellido;

			$mensaje="
					<b>PORTAL LANUZA GROUP </b>
					<br/><br/>"
					."<b>Solicitud 'Dar de Baja' creada por ". $userObject->saludo . " " . $userObject->nombre . " " . $userObject->apellido . "</b>"
					. "<br/><br/>
					Info:
					<br/><br/>
					"
					. "<br/>Empresa:   " . $company->nombre . " (" . $company->razonSocial . ") "
					. "<br/>Fecha:" . date("d/m/Y")
					. "<br/><b>Dar de baja a Usuario con ID:" . $usuarioAEliminarId . "</b>"
					. "<br/>Nombre:" . $nombre . " " . $apellido
					. "<br/><br/><br/>"
					. " Para ingresar directamente al LOGIN del Portal ingrese en el siguiente link:
						<br/><br/>
						<a href=\"" . self::$iniPage . "\" target=\"_blank\">" . self::$iniPage . "</a>
						<br/><br/>
					    Muchas gracias por usar nuestros servicios.
					    <br/><br/>
					    --<br/>
					    Atte.<br/>
					    <i>El Equipo T&eacute;cnico de <b>Lanuza Group</b></i>
						<br/><br/>
						PD al Admin.: recuerde la opci&oacute;n de INACTIVAR USUARIO en el Portal, secci&oacute;n Administraci&oacute;n -> Usuarios.
					    "
			;
			
 			/* echo "$to"."<br/>"."$tema"."<br/>"."$mensaje"."<br/>"."$cabeceras"; */
			mail("$to","$tema","$mensaje","$cabeceras");

			return true;

		} catch( Exception $e) {
			$internalErrorCodigo  = "Exception in models.EmailManagement.solicitudDarDeBajaAUsuario():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = $userObject->saludo . " " . $userObject->nombre . " " . $userObject->apellido;
			
			/**/
			Transaccion::insertTransaccionPDOException("Usuario_Desactivar",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");

			return false;
		}
	}

}