<?php
namespace app\models\cronJobs;

use \core\Database;

class Daemon {

	/**
	 * Obtener Equipo(s) dado el USUARIO y su EMPRESA
	 */
	public static function test(){

		try {
			echo "5.entrò en test() -- ";

			$sql = " INSERT INTO lanuzaso_LanuzaGroupDB.CronJobTransaccion(tipoCronJob, resultado, comentarios, error_type, error_description) 
					VALUES ( 'BUSCA_INCIDENCIAS_NUEVAS', 0, 'comment', 'DAEMON', 'no hya errores' ) ";

$servername = "localhost";
$username = "lanuzaso_dbUser";
$password = "mysqlC0ntr453ñ4*";

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
	echo "Connected successfully";

	if ($conn->query($sql) === TRUE) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
}
			

		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.cronJobs.Daemon.test():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "";
			
			echo $internalErrorCodigo . " -- " . $internalErrorMessage;
			die;
		}
	}
}


Daemon::test();

/*
 * Si funciona!!!     El comando en CronJobs es el siguiente
   php /home/lanuzag/public_html/app/models/cronJobs/daemonPrueba.php
 */


?>