<?php
// session_start();
/*
 * Daemon de prueba
 */
$sql_host = "lanuzagroup.com";

$sql_db = "lanuzaso_LanuzaGroupDB";

$sql_user = "lanuzaso_dbUser";

$sql_password = "mysqlC0ntr453ñ4*";

$sql_port = "3306";

$conn = new mysqli( $sql_host, $sql_user, $sql_password, $sql_db, $sql_port );

/* comprobar la conexión */
if ( $conn->connect_errno ) {
    $serverHost = $_SERVER['HTTP_HOST'];
    echo "2.Falló la conexión: " .  $mysqli->connect_error . " -- SERVER_HOST= " . $serverHost;
    exit();
}

$conn->set_charset("utf8");

//$sql = " SELECT * FROM CronJobTransaccion ";
$sql = " INSERT INTO CronJobTransaccion(tipoCronJob, resultado, comentarios, error_type, error_description) 
	VALUES ( 'BUSCA_INCIDENCIAS_NUEVAS', 0, 'comment', 'DAEMON', 'no hya errores' ) ";

/* Consultas de selección que devuelven un conjunto de resultados */
if ( $resultado = $conn->query( $sql ) ) {

    // printf("La selección devolvió %d filas.\n", $resultado->num_rows);

    /* liberar el conjunto de resultados */
    $resultado->close();
}

mysqli_close( $conn );