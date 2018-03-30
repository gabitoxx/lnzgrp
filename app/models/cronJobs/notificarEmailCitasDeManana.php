<?php
namespace app\models\cronJobs;

use \core\Database;

class Daemon5 {
http://php.net/manual/it/language.oop5.properties.php
	/**
	 * Se buscarà Citas del dia de mañana para ENVIAR CORREOS a las Empresas
	 *  como Recordatorio de que nuestros Técnicos van a ir a visitarlos
	 *
	 * tipo de Cron Job: RECORDATORIO_CITA
	 *
	 * Comando
	 * php /home/lanuzag/public_html/app/models/cronJobs/notificarEmailCitasDeManana.php
	 */
	public static function notificarEmailCitasDeManana(){

		/*
		 * Credenciales
		 */
		$servername="localhost";
		$username = "lanuzag_dbUser";
		$password = "mysqlC0ntr453ñ4*";

		try {
			echo "Corriendo función notificarEmailCitasDeManana() \n\n ";

			$incidenciasIDs = "";
//https://stackoverflow.com/questions/277247/increase-days-to-php-current-date    para sumar 1 dia pal SQL
			$anyo = date('Y');
			$mes  = date('m');
			$dia  = date('d');

			$date = $anyo ."-". $mes ."-". $dia;

			/*
			 * Obtiene los ID's de las Empresas
			 */
			$sql = " SELECT DISTINCT s.empresaId AS EmpresaId
					FROM lanuzag_LanuzaGroupDB.SoportesProgramados s 
					WHERE s.fecha_cita BETWEEN '" . $date . " 00:00:00' AND '" . $date . " 23:59:59'
					ORDER BY s.empresaId ";

			/* Create connection */
			$conn = mysqli_connect($servername, $username, $password);

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
					$cita = Daemon5::enviarCorreoAEmpresa($date, $row["EmpresaId"] );
					$i++;
				}

				echo "En total hay " . $i . " Incidencias desatendidas.";

				/*
				 * Busqueda exitosa. Se debe insertar esta corrida en la tabla
				 */
				Daemon5::insertarTransaccion( $incidenciasIDs, $i );
			}

			/* Liberando recursos */
			$conn->close();
			
		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.cronJobs.Daemon5.notificarEmailCitasDeManana():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "";
			
			echo $internalErrorCodigo . " -- " . $internalErrorMessage;
			die;
		}
	}

	/*
	 * FALTA XXX CREAR....
	 */
	public static function enviarCorreoAEmpresa( $date, $empresaId ){

		$sql = " SELECT s.* FROM lanuzag_LanuzaGroupDB.SoportesProgramados s 
				WHERE s.fecha_cita BETWEEN '" . $date . " 00:00:00' AND '" . $date . " 23:59:59' 
				AND s.empresaId = " . $empresaId ;

		$servername="localhost";
		$username = "lanuzag_dbUser";
		$password = "mysqlC0ntr453ñ4*";

		$conn = mysqli_connect($servername, $username, $password);

		if ( $conn ) {
			
			$result = mysqli_query($conn, $sql);
			
			$i = 0;
			/* 
			 * Cada objeto es una cita, la idea es juntar TODAS las citas y enviar un UNICO email
			 */
			$citaObj[0][""] = "";aqui se debe poner cada cita
			while ( $row = mysqli_fetch_assoc($result) ) {
					 
				$citaObj[0][] = $row["EmpresaId"]
				$i++;
			}

			con el Objeto de Citas se procede a enviar Email a dicha Empresa

			$conn->close();

		} else {
			echo " \n\n Connection failed - ERROR Tratando de registrar Transaccion en tabla CronJobTransaccion: "
					. mysqli_connect_error();
		}
	}


	/*
	 * Registro de esta Transaccion con su resultado
	 */
	public static function insertarTransaccion( $incidenciasIDs, $countRows ){

		$sql = " INSERT INTO lanuzag_LanuzaGroupDB.CronJobTransaccion(tipoCronJob, resultado, incidenciasIDs_csv ) 
					VALUES ( 'INCIDENCIAS_SIN_TECH', ". $countRows .", '". $incidenciasIDs ."' )";

		$servername="localhost";
		$username = "lanuzag_dbUser";
		$password = "mysqlC0ntr453ñ4*";

		$conn = mysqli_connect($servername, $username, $password);

		if ( $conn ) {
			if ($conn->query($sql) === TRUE) {
				echo " \n\n Transacción INCIDENCIAS_SIN_TECH insertada en tabla CronJobTransaccion";
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


Daemon5::notificarEmailCitasDeManana();

?>