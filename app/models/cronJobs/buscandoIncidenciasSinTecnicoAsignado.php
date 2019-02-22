<?php
namespace app\models\cronJobs;

use \core\Database;

class Daemon3 {

	/**
	 * Se buscarà incidencias nuevas creadas despuès de la fecha de la última corrida
	 *  y que NO tengan un Ingeniero de Soporte asignado, es decir, estàn desatendidas
	 *
	 * tipo de Cron Job: INCIDENCIAS_SIN_TECH
	 *
	 * Comando
	 * php /home/lanuzag/public_html/app/models/cronJobs/buscandoIncidenciasSinTecnicoAsignado.php
	 */
	public static function buscandoIncidenciasSinTecnicoAsignado(){

		/*
		 * Credenciales
		 */
		$servername="localhost";
		$username = "lanuzaso_dbUser";
		$password = "mysqlC0ntr453ñ4*";

		try {
			echo "Corriendo función buscandoIncidenciasSinTecnicoAsignado() \n\n ";

			$incidenciasIDs = "";

			/*
			 * Se excluyen los REPORTE_VISITA - TechId en blanco
			 */
			$sql = " SELECT i.incidenciaId, i.observaciones, i.status, i.fecha, 
						u.nombre, u.apellido, 
						e.nombre AS NombreEmpresa, e.razonSocial, 
						f.nombre AS TipoFalla 
					FROM lanuzaso_LanuzaGroupDB.Incidencias i 
						INNER JOIN lanuzaso_LanuzaGroupDB.Usuarios u ON i.usuarioId = u.id
						INNER JOIN lanuzaso_LanuzaGroupDB.Empresas e ON i.empresaId = e.empresaId
						INNER JOIN lanuzaso_LanuzaGroupDB.FallasGenerales f ON i.fallaId = f.fallaId
					WHERE ( i.tecnicoId IS NULL OR i.tecnicoId = '')
						AND i.fallaId NOT IN (100, 101) 
						AND i.fecha > (
							SELECT c2.fecha_hora FROM lanuzaso_LanuzaGroupDB.CronJobTransaccion c2 WHERE c2.id = (
								SELECT MAX(c.id) AS ultimoId FROM lanuzaso_LanuzaGroupDB.CronJobTransaccion c WHERE c.tipoCronJob = 'INCIDENCIAS_SIN_TECH'
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

			if ( mysqli_num_rows($result) > 0 ) {

			echo "La(s) siguiente(s) Incidencia(s) __NO tienen un Ingeniero de Soporte asignado__ desde la última vez que se corrió este Cron Job hasta ahora: \n\n";

				/* output data of each row */
				$i = 0;
				while ( $row = mysqli_fetch_assoc($result) ) {
						
					echo "Incidencia Id: " . $row["incidenciaId"] . " \n "
							. " Creada el: " 		. $row["fecha"] . " \n "
							. " Creada por: " 		. $row["nombre"] . " " .  $row["apellido"] . " \n "
							. " De la Empresa: " 	. $row["NombreEmpresa"] . " - " . $row["razonSocial"] . " \n "
							. " TipoFalla: " 		. $row["TipoFalla"] . " \n "
							. " Observaciones: " 	. $row["observaciones"] . " \n "
							. " Estatus actual: " 	. $row["status"] . " \n "
							. " -------------------------------------------- \n\n ";
					$incidenciasIDs .= $row["incidenciaId"] . ",";
					$i++;
				}

				echo "En total hay " . $i . " Incidencias desatendidas.";

				/*
				 * Busqueda exitosa. Se debe insertar esta corrida en la tabla
				 */
				Daemon3::insertarTransaccion( $incidenciasIDs, $i );
			}

			/* Liberando recursos */
			$conn->close();
			
		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.cronJobs.Daemon3.buscandoIncidenciasSinTecnicoAsignado():";
			$internalErrorMessage = $e -> getMessage();
			$internalErrorExtra   = "";
			
			echo $internalErrorCodigo . " -- " . $internalErrorMessage;
			die;
		}
	}

	/*
	 * Registro de esta Transaccion con su resultado
	 */
	public static function insertarTransaccion( $incidenciasIDs, $countRows ){

		$sql = " INSERT INTO lanuzaso_LanuzaGroupDB.CronJobTransaccion(tipoCronJob, resultado, incidenciasIDs_csv ) 
					VALUES ( 'INCIDENCIAS_SIN_TECH', ". $countRows .", '". $incidenciasIDs ."' )";

		$servername="localhost";
		$username = "lanuzaso_dbUser";
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


Daemon3::buscandoIncidenciasSinTecnicoAsignado();

?>