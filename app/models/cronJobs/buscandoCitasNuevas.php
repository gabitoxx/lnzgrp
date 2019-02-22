<?php
namespace app\models\cronJobs;

use \core\Database;

class Daemon4 {

	/**
	 * Se buscarà Citas de Soportes Programados nuevas creadas despuès de la fecha de la última corrida
	 *
	 * tipo de Cron Job: BUSCA_CITAS_NUEVAS
	 *
	 * Comando
	 * php /home/lanuzag/public_html/app/models/cronJobs/buscandoCitasNuevas.php
	 */
	public static function buscandoCitasNuevas(){

		/*
		 * Credenciales
		 */
		$servername="localhost";
		$username = "lanuzaso_dbUser";
		$password = "mysqlC0ntr453ñ4*";

		try {
			echo "Corriendo función buscandoCitasNuevas() \n\n ";

			$soporteProgIDs_csv = "";
			$incidenciasIDs = "";

			/*
			 * Se busca las nuevas CITAS
			 */
			$sql = " SELECT s.*, 
						e.nombre AS NombreEmpresa, e.razonSocial, 
						u.nombre AS NombreTech, u.apellido AS ApellidoTech, 
						i.incidenciaId 
					FROM lanuzaso_LanuzaGroupDB.SoportesProgramados s 
						INNER JOIN lanuzaso_LanuzaGroupDB.Empresas e ON s.empresaId = e.empresaId
						LEFT JOIN lanuzaso_LanuzaGroupDB.Usuarios u ON s.tecnicoId = u.id 
						LEFT JOIN lanuzaso_LanuzaGroupDB.Incidencias i ON s.incidenciaId = i.incidenciaId 
					WHERE s.fecha_creacion > ( 
						SELECT c2.fecha_hora FROM lanuzaso_LanuzaGroupDB.CronJobTransaccion c2 WHERE c2.id = ( 
							SELECT MAX(c.id) AS ultimoId FROM lanuzaso_LanuzaGroupDB.CronJobTransaccion c WHERE c.tipoCronJob = 'BUSCA_CITAS_NUEVAS'
						)
					) ";

			/* Create connection */
			$conn = mysqli_connect($servername, $username, $password);

			/* Check connection */
			if ( !$conn ) {
				die("  -- Connection failed! -- Error de Conexión: " . mysqli_connect_error());
			}

			echo "  --  Connected successfully  --  \n\n";

			$result = mysqli_query($conn, $sql);

			if ( $result === FALSE ) {
				die("  -- Query failed! -- Error: " . mysql_error());

			} else {

				echo "La(s) siguiente(s) Incidencia(s) __NO tienen un Ingeniero de Soporte asignado__ desde la última vez que se corrió este Cron Job hasta ahora: \n\n";

				/* output data of each row */
				$i = 0;
				while ( $row = mysqli_fetch_assoc($result) ) {
						
					echo "Soporte Id: " . $row["soporteProgId"] . " \n "
							. " Creada el: " 					. $row["fecha_creacion"] . " \n "
							. " CITA agendada para el: " 		. $row["fecha_cita"] . " \n "
							. " Ingeniero de Soporte asignado: " . $row["NombreTech"] . " " .  $row["ApellidoTech"] . " \n "
							. " Empresa: " 			. $row["NombreEmpresa"] . " - " . $row["razonSocial"] . " \n "
							. " Incidencia Id: " 	. $row["incidenciaId"] . " \n "
							. " Horario: " 			. $row["hora_estimada"] . " " . $row["hora_estimada"] . " - " . $row["hasta_hora"]. " " . $row["hasta_am_pm"] . " \n "
							. " Trabajo a realizar: " 	. $row["trabajoArealizar"] . " \n "
							. " -------------------------------------------- \n\n ";
					
					$soporteProgIDs_csv .= $row["soporteProgId"] . ",";
					$incidenciasIDs .= $row["incidenciaId"] . ",";
					$i++;
				}

				echo "En total hay " . $i . " Citas nuevas de Soportes Programados.";

				/*
				 * Busqueda exitosa. Se debe insertar esta corrida en la tabla
				 */
				Daemon4::insertarTransaccion( $soporteProgIDs_csv, $incidenciasIDs, $i );
			}

			/* Liberando recursos */
			$conn->close();
			
		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.cronJobs.Daemon4.buscandoCitasNuevas():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "";
			
			echo $internalErrorCodigo . " -- " . $internalErrorMessage;
			die;
		}
	}

	/*
	 * Registro de esta Transaccion con su resultado
	 */
	public static function insertarTransaccion( $soporteProgIDs_csv, $incidenciasIDs, $countRows ){

		$sql = " INSERT INTO lanuzaso_LanuzaGroupDB.CronJobTransaccion(tipoCronJob, resultado, soporteProgIDs_csv, incidenciasIDs_csv ) 
					VALUES ( 'BUSCA_CITAS_NUEVAS', ". $countRows .", '". $soporteProgIDs_csv ."', '". $incidenciasIDs ."' )";

		$servername="localhost";
		$username = "lanuzaso_dbUser";
		$password = "mysqlC0ntr453ñ4*";

		$conn = mysqli_connect($servername, $username, $password);

		if ( $conn ) {
			if ($conn->query($sql) === TRUE) {
				echo " \n\n Transacción BUSCA_CITAS_NUEVAS insertada en tabla CronJobTransaccion";
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


Daemon4::buscandoCitasNuevas();

?>