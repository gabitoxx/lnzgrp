<?php
namespace app\models\cronJobs;

use \core\Database,
	\app\models\EmailManagement,
	\app\models\Empresas;

class Daemon5 {

	/*
	 * Credenciales
	 */
	private static $servername ="localhost"; /*  "lanuzasoft.com:3306";  */
	private static $username   = "lanuzaso_dbUser";
	private static $password   = "mysqlC0ntr453ñ4*";


	/**
	 * Se buscará los Cumpleañeros de hoy y se les enviará un Correo de Felicitación
	 *  con copia a Soporte
	 *
	 * tipo de Cron Job: CUMPLEANOS
	 *
	 * Comando
	 * php /home/lanuzasoft/public_html/app/models/cronJobs/cumpleanerosDeHoySendEmail.php
	 */
	public static function cumpleanerosDeHoy(){

		try {
			echo "Corriendo función cumpleanerosDeHoy() \n\n ";
			
			/* HOY: solo mes y dia */
			$dateQuery = "%-" . date('m-d') . " 12:00:00";

			/*
			 * Obtiene los ID's de las Empresas
			 */
			$sql = " SELECT * FROM lanuzaso_LanuzaGroupDB.Usuarios u WHERE u.cumpleanos LIKE '" . $dateQuery . "' ";

			
			/* Create connection */
			$conn = mysqli_connect(self::$servername, self::$username, self::$password);
			
			
			/* Check connection */
			if ( !$conn ) {
				$m = "  -- Connection failed! -- Error de Conexión: " . mysqli_connect_error();
				echo $m;
				die($m);
			}

			echo "  --  Connected successfully  --  \n\n";

			$result = mysqli_query($conn, $sql);

			if ( $result === FALSE ) {
				$m = "  -- Query failed! -- Error: " . mysql_error() . " | query = " . $sql;
				echo $m;
				die($m);

			} else {
				echo " -- Query no failed --";
			}


			if ( mysqli_num_rows($result) > 0 ) {

				echo " \n Hay algún cumpleañero hoy: \n";

				/* output data of each row */
				$i = 0;
				$userIDs[0] = 0;
				while ( $row = mysqli_fetch_assoc($result) ) {
					
					$userIDs[ $i ] = $row["id"];

					/* Cada ciclo while hay solo un cumpleanero */
					Daemon5::enviarEmailACumpleanero(
							$row["nombre"], $row["apellido"], $row["cumpleanos"],
							$row["email"], $row["fecha_ingreso"], $row["gender"], $row["saludo"]
					);
					
					echo "\n Hoy cumple años " . $row["nombre"] . " " . $row["apellido"] . " - usuario: ". $row["usuario"];
					
					$i++;

				}

				$conclusion = "\n\n En total hay " . $i . " cumpleanyero(s) el dia de hoy: " . date('d-m');
				echo $conclusion;

				/*
				 * Busqueda exitosa. Se debe insertar esta corrida en la tabla
				 */
				Daemon5::insertarTransaccion( $conclusion, $userIDs );
			
			} else {
				echo " \n\n No hay cumpleañeros el día de hoy: " . $dateQuery;
			}

			/* Liberando recursos */
			$conn->close();
			
		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.cronJobs.Daemon5.cumpleanerosDeHoy():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "";
			
			echo $internalErrorCodigo . " -- " . $internalErrorMessage;
			die;
		}
	}

	/*
	 * Registro de esta Transaccion con su resultado
	 */
	public static function insertarTransaccion( $texto, $arrayIDs ){

		$max = sizeof( $arrayIDs );//is just an alias for the true function count()
		$ids = "";
		for( $i = 0; $i < $max; $i++) {
			$ids .= $arrayIDs[ $i ] . ", ";
		}

		$texto .= ". IDs de Usuarios cumpleanyeros: " . $ids;

		$sql = " INSERT INTO lanuzaso_LanuzaGroupDB.CronJobTransaccion(tipoCronJob, resultado, comentarios ) 
					VALUES ( 'CUMPLEANOS', '". $max ."', '". $texto ."' )";

		$conn = mysqli_connect(self::$servername, self::$username, self::$password);

		if ( $conn ) {
			if ( $conn->query($sql) === TRUE ) {
				echo " \n\n Transacción CUMPLEANOS insertada en tabla CronJobTransaccion";
			} else {
				echo " \n\n Error: " . $sql . "  | Causa: " . $conn->error;
			}

			$conn->close();

		} else {
			echo " \n\n Connection failed - ERROR Tratando de registrar Transaccion en tabla CronJobTransaccion: "
					. mysqli_connect_error();
		}
	}

	/**
	 * Envía un CORREO al cumpleañero pasado por parámetro
	 */
	public static function enviarEmailACumpleanero($nombre, $apellido, $fechaCumple, $email, $fechaIngreso, $gender, $saludo){
		
		$CONTACTEMAIL1 = "soporte@lanuzagroup.com";
		$CONTACTEMAIL2 = "direccion@lanuzagroup.com";

		try {
			
			$to = "" . $email . "," . $CONTACTEMAIL1 . "," . $CONTACTEMAIL2;

			/*
			 * Para enviar un correo HTML, debe establecerse la cabecera Content-type
			 */
			$cabeceras  = "MIME-Version: 1.0" . "\r\n";
			$cabeceras .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";

			/* Cabeceras adicionales */
			$cabeceras .= "To: " . $email . "\r\n";
			$cabeceras .= "From: " . $CONTACTEMAIL1 . "\r\n";
			$cabeceras .= "Cc: " . $CONTACTEMAIL2 . "\r\n";
			$cabeceras .= "X-Mailer: PHP\r\n";
			$cabeceras .= "X-Priority: 1"; // fijo prioridad

			$tema =  "Felicidades en su día " . $saludo . " " . $nombre . " " . $apellido . " - Feliz Cumpleaños le desea LanuzaGroup";

			$mensaje=" <br/> 
					<b>PORTAL LANUZA GROUP </b>
					<br/><br/>"
					."<b>Felicidades ". $saludo . " " . $nombre . " " . $apellido . "</b>"
					. "<br/><br/>
					Le extendemos un afectuoso y muy cari&ntilde;oso abrazo de felicitaciones en su d&iacute;a:
					<br/><br/>
					"
					. "<br/>Ud. ha sido parte de nuestra familia desde " . $fechaIngreso 
					. "<br/>y por eso no pod&iacute;amos dejar de pasar esta nueva oportunidad "
					. "<br/><b>de felicitarle en su d&iacute;a</b>."
					. "<br/><br/><br/>"
					. " Muchas gracias por usar nuestros servicios.
					    <br/><br/>
					    --<br/>
					    Atte.<br/>
					    <i>El Equipo T&eacute;cnico de <b>Lanuza Group</b></i>"
			;

			mail("$to","$tema","$mensaje","$cabeceras");

			return true;

		} catch( Exception $e) {
			$internalErrorCodigo  = "Exception in models.EmailManagement.enviarEmailACumpleanero():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "No se envió correo de cumnpleaños a $saludo $nombre $apellido - email $email";
			
			/**/
			Transaccion::insertTransaccionPDOException("Soporte_aviso_email",$internalErrorCodigo, $internalErrorMessage, $internalErrorExtra);
			
			View::set("internalErrorCodigo", $internalErrorCodigo);
			View::set("internalErrorMessage",$internalErrorMessage);
			View::set("internalErrorExtra",	 $internalErrorExtra);

			View::render("internalError");

			return false;
		}
	}
}


Daemon5::cumpleanerosDeHoy();

?>