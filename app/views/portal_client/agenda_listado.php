<!-- ============================================================================================== -->
<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-calendar logo slideanim"></span>
	<i>Agenda de Soportes IT</i>
</h4>


<!-- ============================================================================================== -->
<h4 style="text-align:center;">
	<span class="glyphicon glyphicon-time logo slideanim"></span>
	<i>Citas de Soporte a&uacute;n pendientes</i>
</h4>

<?php 	
	if ( isset($no_citasPendientes) ){
?>

	<div class="container">
		<h3>No se han programado Citas de Soporte IT en su Empresa a futuro
		</h3>
		<h4>Usted puede revisar la Agenda completa, mes a mes, en el men&uacute; 
			<b>Soportes -&gt; Calendario</b>.
		 </h4>
	</div>

<?php 
		/* Destruir la variable una vez usada */
		unset($no_citasPendientes);

	} else { 
		/* En caso de que haya incidencias, mostrar la tabla */
?>
		
		<table id="usuariosReportado" class="table-hover table-striped cf" style="font-size: 14px;">
			<thead class="cf">
				<tr>
					<th class="active" width="100px">Fecha</th>
					<th class="active" width="230px">Horario de Visita</th>
					<th class="active" width="400px">Trabajo a Realizar</th>
					<th class="active" width="250px">Ing. de Soporte asignado</th>
				</tr>
			</thead>
			<tbody>

<?php 		foreach ( $citasPendientes as $cita ) {		?>

				<tr>
					<td>
						<?= substr( $cita["fecha_cita"], 0, 10 ); ?>
					</td>
					<td>
						<?php 
							$aux = $cita["hora_estimada"] . " " . $cita["am_pm"];

							if ( $cita["hasta_hora"] != NULL && $cita["hasta_hora"] != "" ){
								$aux1 = "Desde las " . $aux . " Hasta las " . $cita["hasta_hora"] . " " . $cita["hasta_am_pm"];

							} else {
								$aux1 = "A las " . $aux;
							}
							echo $aux1;
						?>
					</td>
					<td>
						<?php
							if ( $cita["inventario_info"] != NULL && $cita["inventario_info"] ){
								echo $cita["trabajoArealizar"] . "<br/>" . $cita["inventario_info"];
							} else {
								echo $cita["trabajoArealizar"];
							}
						?>
					</td>
					<td>
						<?php 
							if ( $cita["tecnicoId"] != NULL && $cita["tecnicoId"] != ""){
								echo $cita["nombre"] . " " . $cita["apellido"] . "<br/>(Contacto: " . $cita["email"] . ")";
							} else {
								echo "No asignado aún";
							}
						?>
					</td>
				</tr>

<?php		}	?>

			</tbody>
		</table>
<?php 
	}/* citasPendientes */ 
?>


<!-- ============================================================================================== -->
<br/><br/><br/>

<h4 style="text-align:center;">
	<span class="glyphicon glyphicon-hourglass logo slideanim"></span>
	<i>Citas ya pasadas de Soporte registradas del a&ntilde;o en curso</i>
</h4>


<?php 	
	if ( isset($no_citasPasadas) ){
?>

	<div class="container">
		<h3>No existen Citas de Soporte IT registradas de su Empresa
		</h3>
		<h4>No hemos registrado Visitas a su Empresa <b>en lo que va de a&ntilde;o</b>.
			<br/>
			Usted puede revisar la Agenda completa, mes a mes, en el men&uacute; 
			<b>Soportes -&gt; Calendario</b>.
		 </h4>
	</div>

<?php 
		/* Destruir la variable una vez usada */
		unset($no_citasPasadas);

	} else { 
		/* En caso de que haya incidencias, mostrar la tabla */
?>
		
		<table id="usuariosReportado" class="table-hover table-striped cf" style="font-size: 14px;">
			<thead class="cf">
				<tr>
					<th class="active" width="100px">Fecha</th>
					<th class="active" width="230px">Horario de Visita</th>
					<th class="active" width="400px">Trabajo a Realizar</th>
					<th class="active" width="250px">Ing. de Soporte asignado</th>
				</tr>
			</thead>
			<tbody>

<?php 		foreach ( $citasPasadas as $cita ) {		?>

				<tr>
					<td>
						<?= substr( $cita["fecha_cita"], 0, 10 ); ?>
					</td>
					<td>
						<?php 
							$aux = $cita["hora_estimada"] . " " . $cita["am_pm"];

							if ( $cita["hasta_hora"] != NULL && $cita["hasta_hora"] != "" ){
								$aux1 = "Desde las " . $aux . " Hasta las " . $cita["hasta_hora"] . " " . $cita["hasta_am_pm"];

							} else {
								$aux1 = "A las " . $aux;
							}
							echo $aux1;
						?>
					</td>
					<td>
						<?php
							if ( $cita["inventario_info"] != NULL && $cita["inventario_info"] ){
								echo $cita["trabajoArealizar"] . "<br/>" . $cita["inventario_info"];
							} else {
								echo $cita["trabajoArealizar"];
							}
						?>
					</td>
					<td>
						<?php 
							if ( $cita["tecnicoId"] != NULL && $cita["tecnicoId"] != ""){
								echo $cita["nombre"] . " " . $cita["apellido"] . "<br/>(Contacto: " . $cita["email"] . ")";
							} else {
								echo "No asignado aún";
							}
						?>
					</td>
				</tr>

<?php		}	?>

			</tbody>
		</table>
<?php 
	}/* citasPasadas */ 
?>
