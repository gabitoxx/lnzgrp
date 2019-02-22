<?php
namespace app\models\cronJobs;

use \core\Database,
	\app\models\EmailManagement,
	\app\models\Empresas;

class notificarEmailCitasDeManana { 
	/* class Daemon5 { para correrlo desde la app, debe tener el archivo el mismo nombre de la clase */
/* class notificarEmailCitasDeManana { Para ejecutar Script por CronJob, se puede poner nombre de archivo cualq. */

	/*
	 * Credenciales
	 */
	private static $servername="localhost"; /* "lanuzasoft.com:3306";  */
	private static $username   = "lanuzaso_dbUser";
	private static $password   = "mysqlC0ntr453ñ4*";

	/**
	 * Se buscarà Citas del dia de mañana para ENVIAR CORREOS a las Empresas
	 *  como Recordatorio de que nuestros Técnicos van a ir a visitarlos
	 *
	 * tipo de Cron Job: RECORDATORIO_CITA
	 *
	 * Comando
	 * php /home/lanuzag/public_html/app/models/cronJobs/notificarEmailCitasDeManana.php
	 */
	public static function notificarEmailCitas(){

		try {
			echo "Corriendo función notificarEmailCitas() \n\n ";

			$soporteProgIDs_csv = "";
			
			/* para sumar 1 dia para la consulta SQL */
			$date = date('Y-m-d', strtotime("+1 days"));

			/*
			 * Obtiene los ID's de las Empresas
			 */
			$sql = " SELECT DISTINCT s.empresaId AS EmpresaId, e.nombre, e.razonSocial 
					FROM lanuzaso_LanuzaGroupDB.SoportesProgramados s 
					 INNER JOIN lanuzaso_LanuzaGroupDB.Empresas e ON s.empresaId = e.empresaId 
					WHERE s.fecha_cita BETWEEN '" . $date . " 00:00:00' AND '" . $date . " 23:59:59'
					ORDER BY s.empresaId ";
			
			/* Create connection */
			$conn = mysqli_connect(self::$servername, self::$username, self::$password);
			
			/* Check connection */
			if ( !$conn ) {
				die("  -- Connection failed! -- Error de Conexión: " . mysqli_connect_error());
			}

			echo "  --  Connected successfully  --  \n\n";

			$result = mysqli_query($conn, $sql);
			
			if ( $result === FALSE ) {
				die("  -- Query failed! -- Error: " . mysql_error() . " | query = " . $sql);
			} 

			if ( mysqli_num_rows($result) > 0 ) {
			
				/* output data of each row */
				$i = 0;
				while ( $row = mysqli_fetch_assoc($result) ) {
					
					/* Cada ciclo while hay solo un ID de Empresa */
					$soporteProgIDs_csv .= notificarEmailCitasDeManana::condensarCitasYEnviarCorreoAEmpresa($date, $row["EmpresaId"], $row["nombre"], $row["razonSocial"] );
					$i++;
				}

				echo "En total hay " . $i . " Citas el día de mañana.";

				/*
				 * Busqueda exitosa. Se debe insertar esta corrida en la tabla
				 */
				notificarEmailCitasDeManana::insertarTransaccion( $soporteProgIDs_csv, $i );
			}

			/* Liberando recursos */
			$conn->close();
			
		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.cronJobs.notificarEmailCitas.notificarEmailCitasDeManana():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "";
			
			echo $internalErrorCodigo . " -- " . $internalErrorMessage;
			die;
		}
	}

	/*
	 * 
	 */
	public static function condensarCitasYEnviarCorreoAEmpresa( $date, $empresaId, $companyName, $razonSocial ){

		$returnIds = "";

		$sql = " SELECT s.* FROM lanuzaso_LanuzaGroupDB.SoportesProgramados s 
				WHERE s.fecha_cita BETWEEN '" . $date . " 00:00:00' AND '" . $date . " 23:59:59' 
				AND s.empresaId = " . $empresaId ;

		$conn = mysqli_connect(self::$servername, self::$username, self::$password);

		if ( $conn ) {
			
			$result = mysqli_query($conn, $sql);
			
			$i = 0;
			/* 
			 * Cada objeto es una cita, la idea es juntar TODAS las citas y enviar un UNICO email
			 */
			$citaObj[0][""] = "";
			while ( $row = mysqli_fetch_assoc($result) ) {
					 
				$citaObj[$i]["trabajoArealizar"] = $row["trabajoArealizar"];
				$citaObj[$i]["hora_estimada"]    = $row["hora_estimada"];
				$citaObj[$i]["am_pm"]            = $row["am_pm"];
				$citaObj[$i]["inventario_info"]  = $row["inventario_info"];
				$citaObj[$i]["estatusCita"]      = $row["estatusCita"];
				$citaObj[$i]["hasta_hora"]       = $row["hasta_hora"];
				$citaObj[$i]["hasta_am_pm"]      = $row["hasta_am_pm"];

				$returnIds .= $row["soporteProgId"] . ",";

				$i++;
			}

			$conn->close();

			/* con el Objeto de Citas se procede a enviar Email a dicha Empresa */
			notificarEmailCitasDeManana::sendEmailToCompany($empresaId, $companyName, $razonSocial, $i, $citaObj);
			
			return $returnIds;

		} else {
			echo " \n\n Connection failed - ERROR Tratando de registrar Transaccion en tabla CronJobTransaccion: "
					. mysqli_connect_error($citaObj);
		}
	}

	/*
	 *
	 */
	public static function sendEmailToCompany($empresaId, $companyName, $razonSocial, $numCitas, $citasObj){

		$message  = "Sres. $companyName $razonSocial \n\n";
		$message .= "Este correo sirva como recordatorio de que el día de mañana tenemos agendado ";
		if ( $numCitas == 1 ){
			$message .= "una cita";
		} else {
			$message .= $numCitas ." citas";
		}
		$message .= " de Soporte Programado en su Empresa. La(s) labor(es) a realizar son las siguientes:  \n\n";

		for ( $i = 0; $i < $numCitas; $i++ ){
			$j = $i + 1;
			$message .= "$j :: " . $citasObj[$i]["estatusCita"] . "\n" ;
			$message .= "Hora: " . $citasObj[$i]["hora_estimada"] . " " . $citasObj[$i]["am_pm"] . "\n" ;
			if ( $citasObj[$i]["hasta_hora"] != NULL && $citasObj[$i]["hasta_hora"] != "" ){
				$message .= "Hasta: " . $citasObj[$i]["hasta_hora"] . " " . $citasObj[$i]["hasta_am_pm"] . "\n" ;
			}
			$message .= "Tabajo a realizar: " . $citasObj[$i]["trabajoArealizar"] . " " . $citasObj[$i]["inventario_info"] . "\n" ;
			$message .= "\n\n";
		}

		$mails = notificarEmailCitasDeManana::getEmailsDeManagersDeEmpresa($empresaId);
		$mail  = "";

		if ( $mails != NULL && $mails != "" ){
			while ( $row = mysqli_fetch_assoc($mails) ){
				
				$mail .= $row["email"] . "," ;
			}
		}

		/* substring el ultimo caracter */
		$mail = rtrim($mail,",");

		EmailManagement::notificarCitaManana($mail,$message);
	}



	/**
	 * Buscar correo(s) de(los) Partner(s) o Gerente(s) de esta EMPRESA
	 */
	public static function getEmailsDeManagersDeEmpresa( $empresaId ){
		try {
			$connection = Database::instance();

			$sql = " SELECT email FROM Usuarios WHERE role = 'manager' AND empresaId = ? ";

			$conn = mysqli_connect(self::$servername, self::$username, self::$password);

			if ( $conn ) {
				$result = mysqli_query($conn, $sql);
				
				return $result;
			}

			return "";

		} catch(\PDOException $e) {
			return NULL;
		}
	}


	/*
	 * Registro de esta Transaccion con su resultado
	 */
	public static function insertarTransaccion( $soporteProgIds, $countRows ){

		$sql = " INSERT INTO lanuzaso_LanuzaGroupDB.CronJobTransaccion(tipoCronJob, resultado, soporteProgIDs_csv ) 
					VALUES ( 'RECORDATORIO_CITA', ". $countRows .", '". $soporteProgIds ."' )";

		$conn = mysqli_connect(self::$servername, self::$username, self::$password);

		if ( $conn ) {
			if ($conn->query($sql) === TRUE) {
				echo " \n\n Transacción RECORDATORIO_CITA insertada en tabla CronJobTransaccion";
			} else {
				echo " \n\n Error: " . $sql . "  | Causa: " . $conn->error;
			}

			$conn->close();

		} else {
			echo " \n\n Connection failed - ERROR Tratando de registrar Transaccion en tabla CronJobTransaccion: "
					. mysqli_connect_error();
		}
	}

}


notificarEmailCitasDeManana::notificarEmailCitas();

?>