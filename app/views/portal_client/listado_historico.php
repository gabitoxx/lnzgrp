<style>
	#tableId tr td:nth-child(3){
		width:210px !important;
	}
	#tableId tr td:nth-child(4){
		width:210px !important;
	}
	#tableId tr td:nth-child(5){
		width:300px !important;
	}
	#tableId {
		table-layout: fixed !important;
		width: 100% !important;
	}

</style>

<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-indent-left logo slideanim"></span>
	<i>Listado Hist&oacute;rico</i><br/><br/>
	<u>Incidencias</u> 
	<span style="color:#000;">reportadas por Usted que ya han sido Cerradas +</span> 
	<u>Reportes</u> 
	<span style="color:#000;">sobre sus Equipos (Mantenimientos y Trabajos).</span>
</h4>
 

<br/><br/>

<?php if ( isset($no_incidencias) ){ ?>

	<div class="container">
		<h3>Usted No posee Incidencias/Soportes TI registrados en el Sistema.
		</h3>
		<h4>Si posee alg&uacute;n inconveniente o falla en su equipo y necesita 
			 de una Asistencia o Soporte T&eacute;cnico,<br/> 
			  seleccione la opci&oacute;n <b>Generar nueva Incidencia</b> en el men&uacute;.
		 </h4>
	</div>

<?php 
		/* Destruir la variable una vez usada */
		unset($no_incidencias);

	} else { 
		/* En caso de que haya incidencias, mostrar la tabla */
?>

<div class="container">
	<div id="no-more-tables">
	    <table class="col-md-12 table-hover table-striped cf" style="font-size:12px;">
			<thead class="cf">
				<tr>
					<th width="90px" class="active" align="center">Nº Incidencia<br/>y Estatus</th>
					<th width="100px" class="numeric">Equipo Nº</th>
					<th width="160px">Fecha creaci&oacute;n<br/>(A&ntilde;o-Mes-D&iacute;a Hora)</th>
					<th>Falla:<br/>General</th>
					<th>Falla:<br/>Comentarios</th>
					<th width="100px">Atendida por <br/>(Ing. de Soporte)</th>
					<th width="100px">Fecha &uacute;ltima<br/> actualizaci&oacute;n</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					/*
					 * Variable que indicará si por lo menos hay una Incidencia con el status 'En Espera'
					 */
					$porlomenosunEnEspera = false;

					/* Recorrido de Incidencias */
					foreach ($incidencias as $incidencia) {
				?>
				<tr>

					<td data-title="Incidencia/Estatus" align="center" style="padding-top: 10px; padding-bottom: 10px;" 
					 <?php 
						if($incidencia["status"]=="Abierta"){echo 'class="danger"';}
						else if($incidencia["status"]=="En Espera"){echo 'class="info"';}
						else if($incidencia["status"]=="En Progreso"){echo 'class="warning"';}
						else if($incidencia["status"]=="Cerrada" || $incidencia["status"]=="Certificada"){echo 'class="success"';}
						else {echo 'class="active"';}
					 ?>
					>
						<?= $incidencia["incidenciaId"] . "<br/>" . $incidencia["status"] ?>
					</td>

					<td align="center" data-title="Equipo Nº" align="center">
						<?php 
							if ( $incidencia["codigoBarras"] != null && $incidencia["codigoBarras"] != ""){
								echo $incidencia["codigoBarras"];
							} else {
								echo '<h6 style="color:#FFF;">.</h6>';
							}
						?>
					</td>
					<td data-title="Creada"><?php echo $incidencia["fecha"]; ?></td>
					
					<td data-title="Falla General" <?php if($incidencia["falla"]=="Reporte de Visita") echo 'class="info"'; ?> >
						<?php echo $incidencia["falla"]; ?>
					</td>

					<?php 
						/* imprimiendo una CELDA programatically */
						if ( $incidencia["respuestaEsperada"] != null ){
							echo  '<td class="info" data-title="Respuesta del Usuario">' . $incidencia["respuestaEsperada"] . '</td>';

						} else if ( $incidencia["enEsperaPor"] != null ){
							echo  '<td class="info" data-title="Ing. espera por">' . $incidencia["enEsperaPor"] . '</td>';

						} else {
							echo '<td data-title="Observaciones">' . $incidencia["observaciones"] . '</td>';
						}
					?>

					<td data-title="Atendida por" align="center">
						<?php 
							if ( $incidencia["Tecnico_nombre"] != null && $incidencia["Tecnico_nombre"] != ""){
								echo $incidencia["Tecnico_nombre"] . "<br/>" . $incidencia["Tecnico_apellido"];
							} else {
								/*
								 * Para usar la tabla <div id="no-more-tables">
								 * se necesita que NINGUNA CELDA contenga espacios VACÍOS o NULOS
								 * Si NO hay data que mostrar, se mostrará un "N/A" o un punto en COLOR BLANCO
								 */
								echo '<h6 style="color:#FFF;">.</h6>';
							}
						?>
					</td>

					<td data-title="Actualizada">
						<?php
							if ( $incidencia["fecha_reply"] != null && $incidencia["fecha_reply"] != "") {
								echo $incidencia["fecha_reply"];

							} else if ( $incidencia["fecha_enEspera"] != null && $incidencia["fecha_enEspera"] != "") {
								echo $incidencia["fecha_enEspera"];
							
							} else if ( $incidencia["fecha_enProgreso"] != null && $incidencia["fecha_enProgreso"] != "") {
								echo $incidencia["fecha_enProgreso"];
								
							} else {
								echo '<h6 style="color:#FFF;">.</h6>';
							}
						?>
					</td>
					
				</tr>

				<?php } ?>

			</tbody>
		</table>
	</div>
</div>

<?php 
	}
?>

<br/>
