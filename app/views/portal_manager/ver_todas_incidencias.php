<?php
	$incidenciasSinOpinarJSON = "[]";
	if ( isset($jsonIncidenciasSinOpinar) ){
		$incidenciasSinOpinarJSON = $jsonIncidenciasSinOpinar;
	}
	echo "<script>";
	echo "   var jsonString = '" . $incidenciasSinOpinarJSON . "'" ;
	echo "</script>";
?>
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


<!-- ============================================================================================== -->
<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-indent-left logo slideanim"></span>
	<i>Listado de Incidencias reportadas por Usted</i>
</h4>

<?php 
	/*
	 * Variable que indicará si por lo menos hay una Incidencia con el status 'En Espera'
	 */
	$porlomenosunEnEspera = false;


	if ( isset($no_incidencias_de_Manager) ){
?>

	<div class="container">
		<h3>Usted No ha creado Incidencias/Soportes t&eacute;cnicos en el Sistema.
		</h3>
		<h4>Si Usted presenta alg&uacute;n inconveniente o falla en su equipo y necesita 
			 de una Asistencia o Soporte TI,
			  seleccione la opci&oacute;n <b>Generar nueva Incidencia</b> en el men&uacute;.
		 </h4>
	</div>

<?php 
		/* Destruir la variable una vez usada */
		unset($no_incidencias_de_Manager);

	} else { 
		/* En caso de que haya incidencias, mostrar la tabla */
?>

<div class="container">
	<div id="no-more-tables">
		<table id="tableIncidenciasGerente" class="col-md-12 table-hover table-striped cf" style="font-size: 12px;">
			<thead class="cf">
				<tr>
					<th width="90px" class="active" align="center">Nº Incidencia<br/>y Estatus</th>
					<th width="200px" style="min-width:200px;">Acciones</th>
					<th width="100px" align="center">Nº Equipo</th>
					<th width="145px">Fecha creaci&oacute;n<br/>(A&ntilde;o-Mes-D&iacute;a Hora)</th>
					<th width="160px">Falla:<br/>General</th>
					<th width="160px">Falla:<br/>Comentarios</th>
					<th width="100px" align="center">Atendida por <br/> (Ingeniero de Soporte)</th>
					<th width="100px">Fecha &uacute;ltima<br/> actualizaci&oacute;n</th>
				</tr>
			</thead>
			<tbody>

				<?php 
					/* Recorrido de Incidencias */
					foreach ($incidenciasDeManager as $incidencia) { 
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
					 	<?= $incidencia["incidenciaId"] . "<br/>" . $incidencia["status"]; ?>
					</td>

					<td data-title="Acciones">
						<button type="button"
						 <?php 
							if ($incidencia["resolucionId"]==null || $incidencia["resolucionId"]==""){
								echo 'class="btn btn-primary disabled" disabled="disabled" ';
							}else{
								echo 'class="btn btn-primary"';
							}
						 ?>
						 data-toggle="tooltip" data-placement="bottom" title="Ver Soluci&oacute;n de la Incidencia | Opci&oacute;n Imprimir Reporte"
						 onclick="javascript:verDetalleSolucion(<?php echo $incidencia["resolucionId"] ?>);"
						 >
							<span class="glyphicon glyphicon-folder-open"></span> 
						</button>
						&nbsp;
						<button type="button"
						 <?php 
							if ($incidencia["tecnicoId"]==null || $incidencia["tecnicoId"]==""){
								echo 'class="btn btn-info disabled" disabled="disabled" ';
							}else{
								echo 'class="btn btn-info"';
							}
						 ?>
						 data-toggle="tooltip" data-placement="bottom" title="Ver Informaci&oacute;n de Contacto del Ingeniero de Soporte"
						 onclick="javascript:verInfoTecnico(<?php echo $incidencia["tecnicoId"] ?>);"
						 >
							<span class="glyphicon glyphicon-wrench"></span>
						</button>
						&nbsp;
						<button type="button" class="btn btn-warning"
						 data-toggle="tooltip" data-placement="bottom" title="Ver Datos de la Conexi&oacute;n Remota"
						 onclick="javascript:verDatosConexion(<?php echo $incidencia["incidenciaId"] ?>);"
						 >
							<span class="glyphicon glyphicon-link"></span>
						</button>
						&nbsp;
						<?php 
							if($incidencia["status"]=="En Espera") {

								$porlomenosunEnEspera = true;
						?>

							<button type="button" class="btn btn-danger" onclick="javascript:responderAlTech(<?= $incidencia["incidenciaId"]; ?>);" 
							 data-toggle="tooltip" data-placement="bottom" title="Responder a la raz&oacute;n del Ingeniero de Soporte de su motivo 'En Espera' ">
								<span class="glyphicon glyphicon-comment"></span> 
							</button>

						<?php } else { ?>

							<button type="button"
							 <?php 
								if ($incidencia["resolucionId"]==null || $incidencia["resolucionId"]==""){
									echo 'class="btn btn-success disabled" disabled="disabled" ';
								}else{
									echo 'class="btn btn-success"';
								}
							 ?>
							 data-toggle="tooltip" data-placement="bottom" title="CERTIFICAR: Estoy Conforme con la Soluci&oacute;n brindada por el Ingeniero de Soporte"
							 onclick="javascript:certificarIncidencia(<?php echo $incidencia["incidenciaId"] . "," . $incidencia["resolucionId"] ?>);"
							 >
								<span class="glyphicon glyphicon-ok"></span> 
							</button>

						<?php } ?>
					</td>

					<td data-title="Nº Equipo" align="center">
						<?php 
							if ( $incidencia["codigoBarras"] != null && $incidencia["codigoBarras"] != ""){
								echo $incidencia["codigoBarras"];
							} else {
								echo '<h6 style="color:#FFF;">.</h6>';
							}
						?>
					</td>
					<td data-title="Fecha creaci&oacute;n"><?php echo $incidencia["fecha"]; ?></td>
					
					<td data-title="Falla General" <?php if($incidencia["falla"]=="Reporte de Visita" || $incidencia["falla"]=="Reporte General de Visita") echo 'class="info"'; ?> >
						<?php echo $incidencia["falla"]; ?>
					</td>
					
					<?php 
						/* imprimiendo una CELDA programatically */
						if ( $incidencia["respuestaEsperada"] != null ){
							echo  '<td class="info" data-title="Respuesta del Usuario">' . $incidencia["respuestaEsperada"] . '</td>';

						} else if ( $incidencia["enEsperaPor"] != null ){
							echo  '<td class="info" data-title="Ingeniero de Soporte espera por">' . $incidencia["enEsperaPor"] . '</td>';

						} else {
							echo '<td data-title="Comentarios">' . $incidencia["observaciones"] . '</td>';
						}
					?>

					<td data-title="Atendida por" align="center">
						<?php 
							if ( $incidencia["Tecnico_nombre"] != null && $incidencia["Tecnico_nombre"] != ""){
								echo $incidencia["Tecnico_nombre"] . "<br/>" . $incidencia["Tecnico_apellido"];
							} else {
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


<!-- ============================================================================================== -->
<?php if ( isset($no_incidencias) ){ ?>

	<div class="container">
		<h3>Usted No posee Incidencias/Soportes t&eacute;cnicos registrados en el Sistema.
		</h3>
		<h4>Si posee alg&uacute;n inconveniente o falla en su equipo y necesita 
			 de una Asistencia o Soporte TI,<br/> 
			  seleccione la opci&oacute;n <b>Generar nueva Incidencia</b> en el men&uacute;.
		 </h4>
	</div>

<?php 
		/* Destruir la variable una vez usada */
		unset($no_incidencias);

	} else { 
		/* En caso de que haya incidencias, mostrar la tabla */
?>
<br/>
<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-indent-left logo slideanim"></span>
	<i>Listado de Incidencias de 
		<?= $_SESSION['logged_user_empresa']->nombre ;?>
	</i>
</h4>

<div class="container">
	<div id="no-more-tables">
		<table id="tableId" class="col-md-12 table-hover table-striped cf" style="font-size: 12px;">
			<thead class="cf">
				<tr>
					<th width="90px" class="active" align="center">Nº Incidencia<br/>y Estatus</th>
					<th width="200px" style="min-width:200px;">Acciones</th>
					<th width="120px" align="center">Nº Equipo<br/>(Usuario)</th>
					<th width="160px">Fecha creaci&oacute;n<br/>(A&ntilde;o-Mes-D&iacute;a Hora)</th>
					<th width="160px">Falla:<br/>General</th>
					<th width="160px">Falla:<br/>Comentarios</th>
					<th width="100px" align="center">Atendida por <br/> (Ingeniero de Soporte)</th>
					<th width="100px">Fecha &uacute;ltima<br/> actualizaci&oacute;n</th>
				</tr>
			</thead>
			<tbody>
				
				<?php   foreach ($incidencias as $incidencia) {  ?>

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
					 	<?= $incidencia["incidenciaId"] . "<br/>" . $incidencia["status"]; ?>
					</td>

					<td data-title="Acciones">
						<button type="button"
						 <?php 
							if ($incidencia["resolucionId"]==null || $incidencia["resolucionId"]==""){
								echo 'class="btn btn-primary disabled" disabled="disabled" ';
							}else{
								echo 'class="btn btn-primary"';
							}
						 ?>
						 data-toggle="tooltip" data-placement="bottom" title="Ver Soluci&oacute;n de la Incidencia | Opci&oacute;n Imprimir Reporte"
						 onclick="javascript:verDetalleSolucion(<?php echo $incidencia["resolucionId"] ?>);"
						 >
							<span class="glyphicon glyphicon-folder-open"></span> 
						</button>
						&nbsp;
						<button type="button"
						 <?php 
							if ($incidencia["tecnicoId"]==null || $incidencia["tecnicoId"]==""){
								echo 'class="btn btn-info disabled" disabled="disabled" ';
							}else{
								echo 'class="btn btn-info"';
							}
						 ?>
						 data-toggle="tooltip" data-placement="bottom" title="Ver Informaci&oacute;n de Contacto del Ingeniero de Soporte"
						 onclick="javascript:verInfoTecnico(<?php echo $incidencia["tecnicoId"] ?>);"
						 >
							<span class="glyphicon glyphicon-wrench"></span>
						</button>
						&nbsp;
						<button type="button" class="btn btn-warning"
						 data-toggle="tooltip" data-placement="bottom" title="Ver Datos de la Conexi&oacute;n Remota"
						 onclick="javascript:verDatosConexion(<?php echo $incidencia["incidenciaId"] ?>);"
						 >
							<span class="glyphicon glyphicon-link"></span>
						</button>
						&nbsp;
						<button type="button"
							 <?php 
								if ( $incidencia["status"] != "Cerrada" ){
									echo 'class="btn btn-success disabled" disabled="disabled" ';
								}else{
									echo 'class="btn btn-success"';
								}
							 ?>
							 data-toggle="tooltip" data-placement="bottom" title="CERTIFICAR: Estoy Conforme con la Soluci&oacute;n brindada por el Ingeniero de Soporte"
							 onclick="javascript:certificarIncidencia(<?php echo $incidencia["incidenciaId"] . "," . $incidencia["resolucionId"] ?>);"
							 >
								<span class="glyphicon glyphicon-ok"></span> 
						</button>
					</td>

					<td data-title="Equipo/Usuario" align="center">
						<?php 
							echo $incidencia["codigoBarras"] . "<br/>(" 
									. $incidencia["reportadaPorNombre"] . " " . $incidencia["reportadaPorApellido"] . ")"; 
						?>
					</td>
					<td data-title="Fecha creaci&oacute;n"><?php echo $incidencia["fecha"]; ?></td>
					
					<td data-title="Falla General" <?php if($incidencia["falla"]=="Reporte de Visita") echo 'class="info"'; ?> >
						<?php echo $incidencia["falla"]; ?>
					</td>
					
					<?php 
						/* imprimiendo una CELDA programatically */
						if ( $incidencia["respuestaEsperada"] != null ){
							echo  '<td class="info" data-title="Respuesta de Usuario">' . $incidencia["respuestaEsperada"] . '</td>';

						} else if ( $incidencia["enEsperaPor"] != null ){
							echo  '<td class="info" data-title="Ingeniero de Soporte espera por">' . $incidencia["enEsperaPor"] . '</td>';
							
						} else {
							echo '<td data-title="Comentarios">' . $incidencia["observaciones"] . '</td>';
						}
					?>

					<td data-title="Atendida por" align="center">
						<?php 
							if ( $incidencia["Tecnico_nombre"] != null && $incidencia["Tecnico_nombre"] != ""){
								echo $incidencia["Tecnico_nombre"] . "<br/>" . $incidencia["Tecnico_apellido"];
							} else {
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
<fieldset class="scheduler-border">
	<legend class="scheduler-border">Leyenda</legend>
	<div class="row control-group">
		<div class="col-sm-2"><b>Nº de Incidencia y Estatus actual:</b></div>
		<div class="col-sm-10">
		 es el <b>identificador &uacute;nico</b> y el <b>estado actual</b>
		  en el que se encuentra la Incidenacia, donde:
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td width="109px" class="danger">Abierta:</td>
					<td>Se ha reportado un nuevo inconveniente. 
						A&uacute;n no ha sido atendido por ninguno de nuestros Ingenieros de Soporte.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td width="109px" class="warning">En Progreso:</td>
					<td>Ya uno de nuestros Ingenieros de Soporte <b>est&aacute; asignado</b> y 
						proceder&aacute; a trabajar para solucionar el inconveniente.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td width="109px" class="info">En Espera:</td>
					<td>Uno de nuestros Ingenieros de Soporte ya ha sido asignado 
						<span style="color:#E30513;"><b>PERO</b></span> necesita m&aacute;s informaci&oacute;n (o detalles sobre el problema presentado)
						 por parte del Usuario afectado antes de proceder a darle resoluci&oacute;n. 
						 Sin esta informaci&oacute;n el Ingeniero de Soporte no sabr&aacute; 
						 c&oacute;mo continuar atendiendo esta Incidencia. 
						 <u><i>El Usuario</i> que report&oacute; la Incidencia</u> tiene la opci&oacute;n de responderle
						 al Ingeniero de Soporte y darle la informaci&oacute;n que necesita a trav&eacute;s de la Acci&oacute;n 
						 <b><button class="btn btn-danger"><span class="glyphicon glyphicon-comment"></span> </button> Responder al Ingeniero de Soporte</b>.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td width="109px" class="success">Cerrada:</td>
					<td><b>Ya se encuentra Resuelto el inconveniente</b>. 
						El Ingeniero de Soporte asignado procedi&oacute; a cerrar la Incidencia. 
						Puede revisar m&aacute;s detalles sobre la resoluci&oacute;n del inconveniente pulsando el bot&oacute;n &nbsp; 
						<b><button class="btn btn-primary"><span class="glyphicon glyphicon-folder-open"></span> </button> Ver Soluci&oacute;n</b>
						y podr&aacute; ver el Reporte detallado del trabajo del Ingeniero de Soporte que atendi&oacute; esta Incidencia.
						<br/><br/>
						Si surge un problema nuevo, por favor puede proceder a <b>Crear Nueva Incidencia</b>.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td width="109px" class="success">Certificada:</td>
					<td><b>Ya se encuentra Resuelto el inconveniente y el 
						<i>Usuario</i> ha dado la Soluci&oacute;n ofrecida por el Ingeniero de Soporte como <i>V&aacute;lida</i></b>. 
						<br/><mark>
							<span style="color:#E30513;"><b>Nota: </b></span>
							Cuando las Incidencias hayan sido resueltas, le solicitamos por favor a los Usuarios afectados que
							<b>Certifiquen</b> las Incidencias, con el prop&oacute;sito de conocer
							si han quedado conforme con el trabajo de nuestros Ingenieros de Soportes.
						</mark>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-2"><b>Atendida por (Ingeniero de Soporte):</b></div>
		<div class="col-sm-10"> es el Ingeniero de Soporte que atendi&oacute; dicha Incidencia. 
			Si desea ponerse en contacto con &eacute;l(la) puede pulsar la Acci&oacute;n 
			<b><button class="btn btn-info"><span class="glyphicon glyphicon-info-sign"></span></button> Ver Info de Ingeniero de Soporte</b> 
			 y se le desplegar&eacute; su informaci&oacute;n para poder contactarlo.
		</div>
	</div>
	<br/>
	<div class="row control-group">
		<div class="col-sm-2"><b>Acciones:</b></div>
		<div class="col-sm-10">
		 las Acciones que usted puede ejecutar en esta Vista, las cuales son:
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td width="57px">
						<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-folder-open"></span></button>
					</td>
					<td>
						<b>Ver la Soluci&oacute;n de la Incidencia</b> (<span class="glyphicon glyphicon-print"></span> <i>Imprimir</i>): 
						<br/>El Ingeniero de Soporte asignado cerr&oacute; la Incidencia
						porque resolvi&oacute; el inconveniente y pulsando esta opci&oacute;n usted podr&aacute; conocer
						la soluci&oacute;n al mismo (Reporte generado por el Ingeniero de Soporte a cargo). Tambi&eacute;n puede 
						<b><span class="glyphicon glyphicon-print"></span> IMPRIMIR</b> dicho Reporte en <b>PDF</b>.
						<br/><br/>
						Si surge un problema nuevo, por favor puede proceder a <b>Crear Nueva Incidencia</b>.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td width="57px">
						<button type="button" class="btn btn-info"><span class="glyphicon glyphicon-wrench"></span></button>
					</td>
					<td>
						<b>Ver info del Ingeniero de Soporte</b>: 
						<br/>Se mostrar&aacute; la informaci&oacute;n de contacto del Ingeniero de Soporte.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td width="57px">
						<button type="button" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></button>
					</td>
					<td>
						<b>Certificar la Soluci&oacute;n de la Incidencia</b>: 
						<br/>Certificar es <b>DAR como V&Aacute;LIDA</b> la soluci&oacute;n que nuestro
						Ingeniero de Soporte ofreci&oacute; al Inconveniente reportado. 
						<br/><br/>
						&iexcl;Para nosotros su opini&oacute;n es muy importante&excl;
						<b>Por eso le invitamos a que se Certifiquen todas las Incidencias</b> una vez resueltas
						por nuestros Ingenieros de Soportes (as&iacute; podr&aacute; darnos sus opiniones [Usted y sus Empleados] 
						y ayudarnos a mejorar nuestra Calidad de Servicio).
					</td>
				</tr>
			</table>
		</div>
	</div>
	
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td>
						<button type="button" class="btn btn-danger">
							<span class="glyphicon glyphicon-comment"></span> 
						</button>
					</td>
					<td class="active">
						<b>Responder al Ingeniero de Soporte</b><br/>
						Cuando un Ingeniero de Soporte <b>NO</b> puede avanzar debido a que necesita m&aacute;s informaci&oacute;n, 
						pone la Incidencia <b>"En Espera"</b>.
						Si usted conoce la informaci&oacute;n que necesita el Ingeniero de Soporte puede pulsar
						esta opci&oacute;n para responderle y as&iacute; pueda avanzar y proceder a resolverlo.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<br/>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td>
						<button type="button" class="btn btn-warning">
							<span class="glyphicon glyphicon-link"></span> 
						</button>
					</td>
					<td class="active">
						<b>Datos de Conexi&oacute;n Remota</b><br/>
						Son los Datos digitados <b>al momento de Crear la Incidencia</b> y 
						que son necesarios para establecer la <b>Asistencia y Conexi&oacute;n Remota</b> con el Equipo afectado.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<br/>
	<div class="row control-group">
		<div class="col-sm-2">Reportes de Visita:</div>
		<div class="col-sm-10" style="background-color:#d9edf7;">
			En la columna de <b>"Falla General"</b> podr&aacute; ver los 
			<b>Reportes de Visita en color AZUL</b>,
			que NO son Incidencias pero de igual forma deber&aacute; proporcionar un Reporte detallado
			del trabajo realizado en su visita a la Empresa (en calidad de Ingeniero de Soporte).
		</div>
	</div>

</fieldset>


<!-- ==================================  ======================================= -->
<div class="modal fade" id="myModal" role="dialog">
	<!-- tamaño del modal: modal-sm PEQUEÑO | modal-lg GRANDE -->
	<div class="modal-dialog modal-sm">
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title" align="center">
			<span class="glyphicon glyphicon-wrench" id="titleSpan">
				Informaci&oacute;n del Ingeniero de Soporte
			</span> 
	      </h4>
	    </div>

	    <div class="modal-body">
	      <p><div id="feedback"></div></p>
	    </div>

	    <div class="modal-footer">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	    </div>
	  </div>
	</div>
</div>

<!-- ================================== Formulario para VER info del Tecnico ======================================= -->
<?php
	echo "<script> var modalAjaxURL = '" . PROJECTURLMENU . "tecnicos/ajax_ver_tecnico'; </script>" ;
?>
<form id="enviarTecnico" method="post" enctype="multipart/form-data">
	<input type="hidden" id="tecnicoId" name="tecnicoId" value="" />
</form>

<!-- ================================== Formulario para VER Data Conexion Remota =================================== -->
<?php
	echo "<script> var modalAjaxURL_3 = '" . PROJECTURLMENU . "tecnicos/ajax_ver_datos_conexion_remota'; </script>" ;
?>
<form id="askDataLink" method="post" enctype="multipart/form-data">
	<input type="hidden" id="DataLink_incidenciaId" name="DataLink_incidenciaId" value="" />
</form>


<!-- ========================= Formulario para VER SOLUCION DE una incidencia  ================================== -->
<form id="resolucionIncidenciaForm" method="post" enctype="multipart/form-data" 
	action="<?= PROJECTURLMENU; ?>portal/ver_resolucion_incidencia">
	
		<input type="hidden" id="resolucionIncidenciaId" name="resolucionIncidenciaId" value="" />
</form>


<!-- ================== MODAL para Opinar sobre la Solucion dad por el Técnico ===================================== -->
<?php 
//	if ( isset( $certificar_opinar_incidenciaID ) ){

		$fileLocation = 'modalOpinarSobreSolucionIncidencia.php';
		include( $fileLocation );

		echo "<script>";
		echo "   var modalAjaxURL_2 = '" . PROJECTURLMENU . "portal/registrar_opinion';" ;
		echo "</script>";
//	}
?>


<!-- ================== formulario para CERTIFICAR incidencia y OPINAR =========================================== -->
<form class="form-horizontal" data-toggle="validator" role="form" id="solucion_incidencia_form"
 method="post" enctype="multipart/form-data" action="<?= PROJECTURLMENU; ?>portal/certificar_incidencia">

  <input type="hidden" id="certificar_incidenciaId_Form" name="certificar_incidenciaId_Form" value="" />
  <input type="hidden" id="certificar_solucionId_Form"   name="certificar_solucionId_Form"   value="" />
</form>


<!-- ================== MODAL para Responder al Técnico cuando pone una Excusa o Motivo de Espera ================ -->
<?php   if ( $porlomenosunEnEspera == true) {  ?>

<div class="modal fade" id="myModalReply" role="dialog">
	<form class="form-horizontal" data-toggle="validator" role="form" id="reply_en_espera_form"
 	 method="post" enctype="multipart/form-data" action="<?= PROJECTURLMENU; ?>portal/reply_al_tecnico">

		<div class="modal-dialog modal-lg">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title" align="center">
				<span class="glyphicon glyphicon-comment"></span> 
				Dar Informaci&oacute;n al Ingeniero de Soporte
			  </h4>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-sm-offset-1 col-sm-9">
						<span style="font-size:14px;">Por este medio Usted podr&aacute; responder a la 
							informaci&oacute;n que el Ingeniero de Soporte requiere para continuar.
							Llene la siguiente casilla con dicha info y se la haremos llegar al Ingeniero de Soporte.
						</span>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-offset-1 col-sm-9">
						<hr/>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
							<textarea class="form-control" id="user_reply" name="user_reply" rows="3"
							 placeholder="Responda al Ing. de Soporte la Info que él(la) necesita"
							></textarea>

							<input type="hidden" id="incidenciaId_ReplyForm" name="incidenciaId_ReplyForm" value="" />

						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-offset-1 col-sm-9">
						<span style="font-size:10px;">
							<i>(Se le enviar&aacute; un email al Ingeniero de Soporte con esta informaci&oacute;n; sin embargo,
							si usted conoce c&oacute;mo
							contactarlo directamente, le puede notificar que ha respondido a su solicitud)</i>.
						</span>
					</div>
				</div>
			</div>

			<div class="modal-footer">
			  <button type="button" class="btn btn-success" data-dismiss="modal"
			   onclick="javascript:replyAlTech();">Responder al Ingeniero de Soporte</button>
			     &nbsp;&nbsp;&nbsp;
			  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar sin responder</button>
			</div>
		  </div>
		</div>
	</form>
</div>

<?php 	} ?>


<!-- ========================================== scripts ===================================================== -->
<script>

	function verInfoTecnico(tecnicoId){

		$('#myModal').modal({
			backdrop: 'static',
			keyboard: false,
			show: true
		});

		/* valor en el input type hidden */
		document.getElementById("tecnicoId").value = "" + tecnicoId;

		$.ajax({
			type: "POST",
			url: modalAjaxURL,
			data: $('#enviarTecnico').serialize(),
			success: function(message){
				/*alert("OK_");*/
				/*$("#feedback-modal").modal('hide');*/
				$("#feedback").html(message)
			},
			error: function(){
				alert("Error al buscar info del Técnico en nuestro Sistema\nPor favor, intente más tarde");
			}
		});
	}

	function verDatosConexion(incidenciaId){

		$('#myModal').modal({
			backdrop: 'static',
			keyboard: false,
			show: true
		});

		$('#titleSpan').text("Datos de Conexión Remota");

		/* valor en el input type hidden */
		document.getElementById("DataLink_incidenciaId").value = "" + incidenciaId;

		$.ajax({
			type: "POST",
			url: modalAjaxURL_3,
			data: $('#askDataLink').serialize(),
			success: function(message){
				/*alert("OK_");*/
				/*$("#feedback-modal").modal('hide');*/
				$("#feedback").html(message);
			},
			error: function(){
				alert("Error al buscar info de la Conexión Remota\nPor favor, intente más tarde");
			}
		});
	}


	$(document).ready(function () {

		$('[data-toggle="tooltip"]').tooltip();

		$('#myModal').modal('hide');/* hide|show */

	});

	/**
	 * Formulario como el del Tecnico pero sin poder editar
	 */
	function verDetalleSolucion(resolucionId){

		document.getElementById("resolucionIncidenciaId").value = resolucionId;

		document.getElementById("resolucionIncidenciaForm").submit();
	}

	/**
	 * Validar Solucion y Opinar
	 */
	function certificarIncidencia(incidenciaId, resolucionId){

		document.getElementById("certificar_incidenciaId_Form").value = incidenciaId;
		document.getElementById("certificar_solucionId_Form").value   = resolucionId;

		document.getElementById("solucion_incidencia_form").submit();
	}


	/**
	 * MODAL y Razon de Respuesta del Usuario
	 */
	function responderAlTech(incidenciaId){
		
		document.getElementById("incidenciaId_ReplyForm").value = incidenciaId;
		
		$('#myModalReply').modal({
			backdrop: 'static',
			keyboard: false,
			show: true
		});
	}

	function replyAlTech(){

		$('#myModalReply').modal('hide');

		document.getElementById("reply_en_espera_form").submit();

	}

</script>


<?php
	echo "<script>";
	if ( isset( $certificar_opinar_incidenciaID ) ){
		echo " $('#myModalOpinar').modal({
			backdrop: 'static',
			keyboard: false,
			show: true
		}); ";
	}
	echo "</script>";
?>