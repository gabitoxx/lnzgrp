<?php
namespace app\models\cronJobs;

use \core\Database;

class Daemon2 {

	/**
	 * Se buscarà incidencias nuevas creadas despuès de la fecha de la última corrida
	 * tipo de Cron Job: BUSCA_INCIDENCIAS_NUEVAS
	 *
	 * Comando
	 * php /home/lanuzag/public_html/app/models/cronJobs/buscandoNuevasIncidencias.php
	 */
	public static function buscandoNuevasIncidencias(){

		/*
		 * Credenciales
		 */
		$servername="localhost";
		$username = "lanuzaso_dbUser";
		$password = "mysqlC0ntr453ñ4*";

		try {
			echo "Corriendo función buscandoNuevasIncidencias() \n\n ";

			$incidenciasIDs = "";

			$sql = " SELECT i.incidenciaId, i.observaciones, i.status, i.fecha, 
						u.nombre, u.apellido, 
						e.nombre AS NombreEmpresa, e.razonSocial, 
						f.nombre AS TipoFalla 
					FROM lanuzaso_LanuzaGroupDB.Incidencias i 
						INNER JOIN lanuzaso_LanuzaGroupDB.Usuarios u ON i.usuarioId = u.id
						INNER JOIN lanuzaso_LanuzaGroupDB.Empresas e ON i.empresaId = e.empresaId
						INNER JOIN lanuzaso_LanuzaGroupDB.FallasGenerales f ON i.fallaId = f.fallaId
					WHERE i.fecha > (
						SELECT c2.fecha_hora FROM lanuzaso_LanuzaGroupDB.CronJobTransaccion c2 WHERE c2.id = (
							SELECT MAX(c.id) AS ultimoId FROM lanuzaso_LanuzaGroupDB.CronJobTransaccion c WHERE c.tipoCronJob = 'BUSCA_INCIDENCIAS_NUEVAS'
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

				echo "La(s) siguiente(s) Incidencia(s) se crearon desde la última vez que se corrió este Cron Job hasta ahora: \n\n";

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

				echo "En total hay " . $i . " Incidencias nuevas.";

				/*
				 * Busqueda exitosa. Se debe insertar esta corrida en la tabla
				 */
				Daemon2::insertarTransaccion( $incidenciasIDs, $i );
			}

			/* Liberando recursos */
			$conn->close();
			
		} catch(\PDOException $e) {
			$internalErrorCodigo  = "PDOException in models.cronJobs.Daemon2.buscandoNuevasIncidencias():";
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
					VALUES ( 'BUSCA_INCIDENCIAS_NUEVAS', ". $countRows .", '". $incidenciasIDs ."' )";

		$servername="localhost";
		$username = "lanuzaso_dbUser";
		$password = "mysqlC0ntr453ñ4*";

		$conn = mysqli_connect($servername, $username, $password);

		if ( $conn ) {
			if ($conn->query($sql) === TRUE) {
				echo " \n\n Transacción BUSCA_INCIDENCIAS_NUEVAS insertada en tabla CronJobTransaccion";
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


Daemon2::buscandoNuevasIncidencias();

?>