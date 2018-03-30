<style>
	#imgX {
		width: 350px;
		height: 350px;
	}
	td {
		padding: 10px;
	}
	tr:hover {
		background-color: #CCC;
	}
</style>


<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-indent-left logo slideanim"></span>
	<i>Historial de Equipos.</i>&nbsp;&nbsp;&nbsp;
</h4>

<?php
	if ( isset( $no_equipos) ){
?>
		<h4 style="text-align:center;">
			<i>No hay registrado ning&uacute;n Historial de Equipos hasta ahora.</i>
		</h4>
<?php
	} else {
?>
	<h4>
		<b><u><?= $cantidad_equipos; ?></b></u> Equipo(s) registrado(s).
	</h4>

	<br/>


<?php
		
		foreach ( $equipos_info as $equipo) {
?>
			<div class="row well well-lg">
				<div class="col-sm-12" align="center">
					<table>
						<tr>
							<td align="right">
								<b>Nombre (alias del Equipo):</b>
							</td>
							<td align="left">
								<?= $equipo[0]; ?>
							</td>
						</tr>
						<tr>
							<td align="right">
								<b>Dependencia:</b>
							</td>
							<td align="left"><?= $equipo[1]; ?></td>
						</tr>
						<tr>
							<td align="right"><b>MARCA:</b></td>
							<td align="left"><?= $equipo[2]; ?></td>
						</tr>
						<tr>
							<td align="right"><b>MODELO:</b></td>
							<td align="left"><?= $equipo[3]; ?></td>
						</tr>
						<tr>
							<td align="right"><b>Sistema Operativo:</b></td>
							<td align="left"><?= $equipo[4]; ?></td>
						</tr>
						<tr>
							<td align="right"><b>Tipo de Equipo:</b></td>
							<td align="left">
<?php 
								$tipoEquipo = $equipo[5];
								echo $tipoEquipo;
?>
							</td>
						</tr>
					</table>

					<br/>
<?php
					$linkedImagen = $equipo[6];

					if ( $linkedImagen != NULL && $linkedImagen != "" ) {
						/*
						 * Imagen Real del Equipo (Foto)
						 */
						echo '<img id="imgX" alt="' . $tipoEquipo . '" src="' . $linkedImagen . '" />';

					} else {
						echo "* ";

						/*
						 * Imagenes referenciales
						 */
						if ( $tipoEquipo == "Escritorio" )							echo '<img id="imgX" alt="Escritorio" src="' . APPIMAGEPATH . 'escritorio.jpg" />';
						else if ( $tipoEquipo == "Todo-en-uno" )					echo '<img id="imgX" alt="Todo-en-uno" src="' . APPIMAGEPATH . 'Todo-en-uno.jpg" />';
						else if ( $tipoEquipo == "Laptop o Portátil" )				echo '<img id="imgX" alt="Laptop" src="' . APPIMAGEPATH . 'laptop.png" />';
						else if ( $tipoEquipo == "Servidor" )						echo '<img id="imgX" alt="Servidor" src="' . APPIMAGEPATH . 'servidor.png" />';
						else if ( $tipoEquipo == "Router" )							echo '<img id="imgX" alt="Router" src="' . APPIMAGEPATH . 'router.jpg" />';
						else if ( $tipoEquipo == "Impresora" )						echo '<img id="imgX" alt="Impresora" src="' . APPIMAGEPATH . 'impresora.jpg" />';
						else if ( $tipoEquipo == "Impresora Multifuncional" )		echo '<img id="imgX" alt="Impresora Multifuncional" src="' . APPIMAGEPATH . 'multifuncional.jpg" />';
						else if ( $tipoEquipo == "Cámara Vigilancia" )				echo '<img id="imgX" alt="Cámara Vigilancia" src="' . APPIMAGEPATH . 'camara.jpg" />';
						else if ( $tipoEquipo == "Escáner" )						echo '<img id="imgX" alt="Escáner" src="' . APPIMAGEPATH . 'escaner.jpg" />';
						else if ( $tipoEquipo == "Módem" )							echo '<img id="imgX" alt="Módem" src="' . APPIMAGEPATH . 'modem.jpg" />';
						else if ( $tipoEquipo == "Repetidor" )						echo '<img id="imgX" alt="Repetidor" src="' . APPIMAGEPATH . 'repetidor.jpg" />';
						else if ( $tipoEquipo == "Switch" )							echo '<img id="imgX" alt="Switch" src="' . APPIMAGEPATH . 'switch.jpg" />';
						else if ( $tipoEquipo == "Monitor" )						echo '<img id="imgX" alt="Monitor" src="' . APPIMAGEPATH . 'monitor.jpg" />';
						else if ( $tipoEquipo == "Teclado" )						echo '<img id="imgX" alt="Teclado" src="' . APPIMAGEPATH . 'teclado.jpg" />';
						else if ( $tipoEquipo == "Mouse" )							echo '<img id="imgX" alt="Mouse" src="' . APPIMAGEPATH . 'mouse.jpg" />';
						else if ( $tipoEquipo == "TV" )								echo '<img id="imgX" alt="TV" src="' . APPIMAGEPATH . 'TV.jpg" />';
						else if ( $tipoEquipo == "Equipo Empresarial especial" )	echo '<img id="imgX" alt="Equipo Empresarial especial" src="' . APPIMAGEPATH . 'maquina_especial.jpeg" />';
						else if ( $tipoEquipo == "POS" )							echo '<img id="imgX" alt="POS" src="' . APPIMAGEPATH . 'POS.png" />';
						else if ( $tipoEquipo == "Celular" )						echo '<img id="imgX" alt="Smartphones" src="' . APPIMAGEPATH . 'celular.png" />';
						else if ( $tipoEquipo == "Otro" )							echo '<img id="imgX" alt="Otro tipo de equipo" src="' . APPIMAGEPATH . 'otro_equipo.png" />';
						else 														echo '<img id="imgX" alt="Otro tipo de equipo" src="' . APPIMAGEPATH . 'computadora-empresarial-handheld.jpg" />';

						echo "<br/> *Imagen referencial";
					}
?>
					<br/><br/><br/>
					<p style="font-size:16px;"><i><u>Historial de Equipo</u></i></p>

<?php
					if ( $equipo[7] == NULL || $equipo[7] == ""){

						echo "Hasta ahora este Equipo NO registra actividades";

					} else {
?>
						<div class="equipoDiv">
							<div id="no-more-tables">
							    <table class="col-md-12 table-hover table-striped cf" style="font-size:12px;">
									<thead class="cf">
										<tr>
											<th width="20px" class="active" align="center">Nº</th>
											<th width="160px">Fecha creaci&oacute;n<br/>(A&ntilde;o-Mes-D&iacute;a Hora)</th>
											<th>Trabajo Realizado</th>
											<th width="120px" align="center">Ing. de Soporte</th>
											<th width="100px" align="center">Incidencia o Reporte Nº</th>
											<th align="center">Informaci&oacute;n extra</th>
											<th>Error: tipo<br/>(Si es que hay)</th>
											<th>Error:<br/>codigo</th>
											<th>Error:<br/>mensaje</th>
										</tr>
									</thead>
									<tbody>
<?php
									/* Recorrido de Transacciones */
									$cont = 1;
									foreach ( $equipo[7] as $tx) {
?>
										<tr>
											<td data-title="Nº" align="center"><?= $cont++; ?></td>
											<td data-title="Fecha/Hora"><?= $tx["fecha_hora"]; ?></td>
											<td data-title="Trabajo">
												<?php 
													if ( $tx["tipo_transaccion"] == "Incidencia_Crear" ){							echo "Incidencia creada";
													} else if ( $tx["tipo_transaccion"] == "Incidencia_En_Progreso" ){				echo "Incidencia Atendida";
													} else if ( $tx["tipo_transaccion"] == "Incidencia_En_Espera" ){				echo "Incidencia puesta 'En Espera' por Ing.";
													} else if ( $tx["tipo_transaccion"] == "Incidencia_Usuario_Reply" ){			echo "Usuario atiende duda del Ing.";
													} else if ( $tx["tipo_transaccion"] == "Incidencia_Cerrada" ){					echo "Ing. de Soporte resuelve Incidencia";
													} else if ( $tx["tipo_transaccion"] == "Incidencia_Usuario_Certificar" ){		echo "Usuario Certifica solución de Incidencia";
													} else if ( $tx["tipo_transaccion"] == "Incidencia_Usuario_Opinar" ){			echo "Usuario emite Opinión sobre nuestros Servicios";
													} else if ( $tx["tipo_transaccion"] == "Tecnico_Nuevo_Inventario" ){			echo "Ing. de Soporte levanta info de Equipo";
													} else if ( $tx["tipo_transaccion"] == "Tecnico_Nuevo_Inventario_CSV" ){		echo "Ing. utiliza el Script(R) por primera vez";
													} else if ( $tx["tipo_transaccion"] == "Tecnico_Actualizar_Inventario" ){		echo "Ing. actualiza info de Equipo";
													} else if ( $tx["tipo_transaccion"] == "Tecnico_Actualizar_Inventario_CSV" ){	echo "Ing. utiliza el Script(R) para Actualizar info de Equipo";
													} else if ( $tx["tipo_transaccion"] == "Tecnico_Inventario_No_Script" ){		echo "Ing. levanta info manualmente";
													} else if ( $tx["tipo_transaccion"] == "Tecnico_Reporte_Visita_Crear" ){		echo "Ing. crea Reporte de Mantenimiento Preventivo o Correctivo";
													} else if ( $tx["tipo_transaccion"] == "Tecnico_Reporte_Visita_Cerrar" ){		echo "Ing. finaliza Trabajo de Mantenimiento Preventivo o Correctivo";
													} else {
														echo $tx["tipo_transaccion"];
													}

												?>
											</td>
											<td data-title="Ing. Soporte" align="center">
												<?php 
													if ( $tx["techNombre"] == NULL || $tx["techNombre"] == "" ){
														echo "No asignado";
													} else {
														echo $tx["techNombre"] . " " . $tx["techApellido"];
													}
												?>
											</td>
											<td data-title="Incidencia/Reporte Nº" align="center">
												<?php
													if ($tx["incidenciaId"] == NULL || $tx["incidenciaId"] == ""){
														echo "No aplica";
													} else {
														echo $tx["incidenciaId"];
													}
												?>
											</td>
											<td data-title="Info" align="center">
												<?php 
													if ( startsWith( $tx["info"] , "solucionId:" ) ){
														
														$resolucionId = str_replace("solucionId:", "", $tx["info"] );

														$texto = "Solución ID (en el Sistema): ";

														echo $texto;
														echo " ";
														echo ' <a href="#"  onclick="javascript:verDetalleSolucion('; //target="_blank"
															echo "'" . $resolucionId . "'";
														echo ');">' . $resolucionId . '</a>';
														
													} else {
														echo " " . $tx["info"];
													}
												?>
											</td>

											<td><?= $tx["error_tipo"]; ?></td>
											<td><?= $tx["error_codigo"]; ?></td>
											<td><?= $tx["error_mensaje"]; ?></td>
										</tr>
<?php
									}/*for.2*/
?>
									</tbody>
								</table>
							</div>
						</div>
<?php
					}/*else $equipo[7] */
?>		
				</div>
			</div>
			<hr/>

<?php
		
		}/*for.1*/
	
	}/* else */
?>

<br/>


<!-- ========================= Formulario para VER SOLUCION DE una incidencia  ================================== -->
<form id="resolucionIncidenciaForm" method="post" enctype="multipart/form-data" 
	action="<?= PROJECTURLMENU; ?>portal/ver_resolucion_incidencia">
	
		<input type="hidden" id="resolucionIncidenciaId" name="resolucionIncidenciaId" value="" />
</form>

<!-- ========================================== scripts ===================================================== -->
<script>
/**
	 * Formulario como el del Tecnico pero sin poder editar
	 */
	function verDetalleSolucion(resolucionId){
		alert("Buscará Formulario con resolucionId:" + resolucionId + " --> EN CONSTRUCCION");
		/*
		document.getElementById("resolucionIncidenciaId").value = resolucionId;

		document.getElementById("resolucionIncidenciaForm").submit(); */
	}
</script>

<?php
	/*
	 * Funciones PHP de Utils.php
	 */
	function startsWith($haystack, $needle){
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}
?>