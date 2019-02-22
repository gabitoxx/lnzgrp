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
	<span class="glyphicon glyphicon-inbox logo slideanim"></span>
	<i><?= $_SESSION['logged_user_saludo']; ?>: sus Incidencias/Reportes pendientes</i>
</h4>

<?php if ( isset($no_mis_incidencias) ){ ?>

	<div class="container">
		<h3>
			Usted No posee Incidencias/Soportes t&eacute;cnicos asignados 
			pendientes por resolver.
		</h3>
	</div>

<?php 
		/* Destruir la variable una vez usada */
		unset($no_mis_incidencias);

	} else { 
		/* En caso de que haya incidencias, mostrar la tabla */
?>

<div class="container">
	<div id="no-more-tables">
		<table id="tableId" class="col-md-12 table-hover table-striped cf" style="font-size: 12px;">
			<thead class="cf">
				<tr>
					<th align="center" class="active">Nº Incidencia y Estatus</th>
					<th>Acciones</th>
					<th>Equipo Nº<br/>(Reportado por)</th>
					<th>Fecha creaci&oacute;n<br/>(A&ntilde;o-Mes-D&iacute;a Hora)</th>
					<th>Falla:<br/>General</th>
					<th>Falla:<br/>Comentarios</th>
					<th>Atendida por <br/> (Ing. de Soporte)</th>
					<th>Fecha &uacute;ltima<br/> actualizaci&oacute;n</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($misIncidencias as $incidencia) { ?>
				<tr>
					<td align="center" data-title="Incidencia/Estatus" style="padding-top: 10px; padding-bottom: 10px;" 
					 <?php 
						if($incidencia["status"]=="Abierta"){echo 'class="danger"';}
						else if($incidencia["status"]=="En Espera"){echo 'class="info"';}
						else if($incidencia["status"]=="En Progreso"){echo 'class="warning"';}
						else if($incidencia["status"]=="Cerrada"){echo 'class="success"';}
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
						 onclick="javascript:verDetalleSolucion(<?php echo $incidencia["resolucionId"] ?>);"
						 data-toggle="tooltip" data-placement="bottom" title="Ver Soluci&oacute;n | Opci&oacute;n Imprimir"
						>
						<span class="glyphicon glyphicon-folder-open"></span></button>
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
							if ($incidencia["resolucionId"]==null || $incidencia["resolucionId"]==""){
								echo 'class="btn btn-success"';
							}else{
								echo 'class="btn btn-success disabled" disabled="disabled" ';
							}
						 ?>
						 onclick="javascript:editarSolucion(<?php echo $incidencia["incidenciaId"] . "," . $incidencia["tecnicoId"] . "," . $incidencia["empresaId"]; ?>);"
						 data-toggle="tooltip" data-placement="bottom" title="Resolver o Editar Soluci&oacute;n"
						>
						<span class="glyphicon glyphicon-wrench"></span></button>

					</td>

					<td data-title="Nº Equipo" align="center">
						<?php 
							echo $incidencia["codigoBarras"] . "<br/>(" 
									. $incidencia["reportadaPorNombre"] . " " . $incidencia["reportadaPorApellido"] . ")"; 
						?>
					</td>

					<td data-title="Fecha creaci&oacute;n"><?php echo $incidencia["fecha"]; ?></td>

					<td data-title="Falla General" <?php if($incidencia["falla"]=="Reporte de Visita" || $incidencia["falla"]=="Reporte General de Visita") echo 'class="info"'; ?> >
						<?php echo $incidencia["falla"]; ?>
					</td>
					
					<?php 
						/* imprimiendo una CELDA programatically */
						if ( $incidencia["respuestaEsperada"] != null ){
							echo  '<td class="info" data-title="Respuesta de Usuario">' . $incidencia["respuestaEsperada"] . '</td>';

						} else if ( $incidencia["enEsperaPor"] != null ){
							echo  '<td class="info" data-title="T&eacute;cnico espera por">' . $incidencia["enEsperaPor"] . '</td>';

						} else {
							echo '<td data-title="Comentarios">' . $incidencia["observaciones"] . '</td>';
						}
					?>
					
					<td data-title="Atendida por">
						<?php 
							if ( $incidencia["Tecnico_nombre"] != null && $incidencia["Tecnico_nombre"] != ""){
								echo $incidencia["Tecnico_nombre"] . " " . $incidencia["Tecnico_apellido"];
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

<hr/>

<br/>

<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-list-alt logo slideanim"></span>
	<i>Listado de todas las Incidencias/Reportes pendientes por Resolver</i>
</h4>

<?php if ( isset($no_incidencias_pendientes) ){ ?>

	<div class="container">
		<h3>
			No hay Incidencias/Soportes IT  
			pendientes por resolver.
		</h3>
	</div>

<?php 
		/* Destruir la variable una vez usada */
		unset($no_incidencias_pendientes);

	} else { 
		/* En caso de que haya incidencias, mostrar la tabla */
?>


<div class="container">
	<div id="no-more-tables">
		<table id="tableId" class="col-md-12 table-hover table-striped cf" style="font-size: 12px;">
			<thead class="cf">
				<tr>
					<th align="center" class="active">Nº Incidencia y Estatus</th>
					<th>Acciones</th>
					<th>Nº Equipo<br/>(Reportado por)</th>
					<th>Fecha creaci&oacute;n<br/>(A&ntilde;o-Mes-D&iacute;a Hora)</th>
					<th>Falla:<br/>General</th>
					<th>Falla:<br/>Comentarios</th>
					<th>Atendida por <br/> (Ing. de Soporte)</th>
					<th>Fecha &uacute;ltima<br/> actualizaci&oacute;n</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($incidenciasPendientes as $incidencia) { ?>
				<tr>
					<td align="center" data-title="Estatus" style="padding-top: 10px; padding-bottom: 10px;" 
					 <?php 
						if($incidencia["status"]=="Abierta"){echo 'class="danger"';}
						else if($incidencia["status"]=="En Espera"){echo 'class="info"';}
						else if($incidencia["status"]=="En Progreso"){echo 'class="warning"';}
						else if($incidencia["status"]=="Cerrada"){echo 'class="success"';}
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
						  data-toggle="tooltip" data-placement="bottom" title="Ver Soluci&oacute;n | Opci&oacute;n Imprimir"
						  onclick="javascript:verDetalleSolucion(<?php echo $incidencia["resolucionId"] ?>);">
						 <span class="glyphicon glyphicon-folder-open"></span>
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
							if ( ($incidencia["resolucionId"]==null || $incidencia["resolucionId"]=="")
									&& ($incidencia["Tecnico_nombre"] == null || $incidencia["Tecnico_nombre"] == "" ) )
							{
								/*
								 * Esta incidencia la puede tomar este Técnico
								 * solo si NO ha sido tomada por otro Técnico
								 */
						?>
							<button type="button"
							 class="btn btn-danger"
							 onclick="javascript:asignarmeIncidencia(<?php echo $incidencia["incidenciaId"]; ?>);"
							 data-toggle="tooltip" data-placement="bottom" title="Asignarme esta Incidencia a m&iacute;"
							>
								<span class="glyphicon glyphicon-download-alt"></span>
							</button>

						<?php
							} else {
								/*
								 * Si ya ha sido tomada por otro Técnico
								 * se puede ver la info de contacto de dicho tecnico
								 */
						?>
							<button type="button"
							 class="btn btn-info"
							 onclick="javascript:verInfoTecnico(<?php echo $incidencia["tecnicoId"] ?>);"
							 data-toggle="tooltip" data-placement="bottom" title="Ver info T&eacute;cnico"
							>
								<span class="glyphicon glyphicon-info-sign"></span>
							</button>

						<?php } ?>
					</td>

					<td data-title="Nº Equipo" align="center">
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
							echo  '<td class="info" data-title="T&eacute;cnico espera por">' . $incidencia["enEsperaPor"] . '</td>';
							
						} else {
							echo '<td data-title="Comentarios">' . $incidencia["observaciones"] . '</td>';
						}
					?>
					</td>
					
					<td data-title="Atendida por">
						<?php 
							if ( $incidencia["Tecnico_nombre"] != null && $incidencia["Tecnico_nombre"] != ""){
								echo $incidencia["Tecnico_nombre"] . " " . $incidencia["Tecnico_apellido"];
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
	} /* else */
?>

<br/>

<fieldset class="scheduler-border">
	
	<legend class="scheduler-border">Leyenda</legend>
	
	<div class="row control-group">
		<div class="col-sm-2">Nº de Incidencia y Estatus actual:</div>
		<div class="col-sm-10">
		 es el <b>identificador &uacute;nico</b>
		 y el <b>estado actual</b> en el que se encuentra la Incidenacia, donde:
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td class="danger">Abierta:</td>
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
					<td class="warning">En Progreso:</td>
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
					<td class="info">En Espera:</td>
					<td>Uno de nuestros Ingenieros de Soporte ya ha sido asignado 
						PERO necesita m&aacute;s informaci&oacute;n (o detalles sobre el problema presentado)
						 por parte del Usuario afectado
						para saber c&oacute;mo poder ayudarle mejor.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td class="success">Cerrada:</td>
					<td><b>Ya se encuentra Resuelto el inconveniente</b>. 
						El Ingeniero de Soporte asignado procedi&oacute; a cerrar la Incidencia. 
						Puede revisar m&aacute;s detalles sobre la resoluci&oacute;n del inconveniente pulsando el bot&oacute;n 
						<span class="glyphicon glyphicon-folder-open"></span> Ver Soluci&oacute;n</button>.
						<br/><br/>
						Si surge un problema nuevo, por favor puede proceder a <b>Crear Nueva Incidencia</b>.
						<br/><br/>
						<b> IMPORTANTE:</b> Una vez que el Cliente haya certificado la Soluci&oacute;n
						<i>deberá marcar la Incidencia como <u>FINALIZADA</u></i> 
						(ingresando en el Portal Clientes con su usuario) 
						para poder dar como <b>CONCLUIDA la Incidencia</b>; de lo contrario NO se tomar&aacute; el 
						caso como "CERRADO" (finalizado).
					</td>
				</tr>
			</table>
		</div>
	</div>
	<br/>
	<div class="row control-group">
		<div class="col-sm-2">Acciones:</div>
		<div class="col-sm-10"> usted como Ingeniero de Soporte puede optar por realizar las siguientes acciones:</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td>
						<button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Ver Solución">
						<span class="glyphicon glyphicon-folder-open"></span></button>
					</td>
					<td>Ver Soluci&oacute;n<br/>(<span class="glyphicon glyphicon-print"></span> <i>Imprimir</i>)</td>
					<td>Si ya se prest&oacute; un Soporte TI a esta Incidencia 
						y ya fue resuelta (por usted o por otro Ingeniero de Soporte),
						pulsando este bot&oacute;n podr&aacute; ver la Soluci&oacute;n
						dada a la Incidencia.
						<br/><br/>
						Tambi&eacute;n puede 
						<b><span class="glyphicon glyphicon-print"></span> IMPRIMIR</b> dicho Reporte en <b>PDF</b>.
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
						<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Asignarme esta Incidencia a m&iacute;">
						<span class="glyphicon glyphicon-download-alt"></span></button>
					</td>
					<td>Asignarme esta Incidencia a m&iacute;</td>
					<td>Esta acci&oacute;n permitir&aacute; establecer que 
						<b>usted ser&aacute; el Responsable de prestar el debido 
						Soporte TI a esta Incidencia</b> 
						y quedar&aacute; registrado en el Sistema que ahora usted 
						estar&aacute; a cargo de la misma.
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
						<button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Resolver o Editar Soluci&oacute;n">
						<span class="glyphicon glyphicon-wrench"></span></button>
					</td>
					<td>Resolver o Editar Soluci&oacute;n</td>
					<td>Esta acci&oacute;n le permitir&aacute; a usted
						<b>Resolver esta Incidencia</b> 
						y quedar&aacute; registrado en el Sistema que usted fue el 
						encargado de proporcionar la Soluci&oacute;n al Cliente.
						Luego de esto se le notificar&aacute; al Cliente <b>v&iacute;a e-mail</b> para que 
						pueda certificar que la Soluci&oacute;n ha sido la correcta 
						(aunque usted tambi&eacute;n puede indicarle que su caso ha sido resuelto para que haga la prueba de que es as&iacute;).
						<br/><br/>
						<b> IMPORTANTE:</b> Una vez que el Cliente haya certificado la Soluci&oacute;n
						<i>deber&aacute; marcar la Incidencia como <u>FINALIZADA</u></i> 
						(ingresando en el Portal Clientes con su usuario) 
						para poder dar como <b>CONCLUIDA la Incidencia</b>.
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
						<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ver Info de T&eacute;cnico">
						<span class="glyphicon glyphicon-info-sign"></span></button>
					</td>
					<td>Ver Info del Ing. de Soporte</td>
					<td>Ya dicha Incidencia ha sido asignada a otro
						Ingeniero de Soporte. Con esta opci&oacute;n usted 
						podr&aacute; ver su informaci&oacute;n de Contacto.
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
						<button type="button" class="btn btn-warning">
							<span class="glyphicon glyphicon-link"></span> 
						</button>
					</td>
					<td><b>Datos de Conexi&oacute;n Remota</b></td>
					<td>Son los Datos digitados <b>al momento de Crear la Incidencia</b> y 
						que son necesarios para establecer la <b>Asistencia y Conexi&oacute;n Remota</b> con el Equipo afectado.
					</td>
				</tr>
			</table>
		</div>
	</div>

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

<!-- ========================= Formulario para la peticion AJAX ============================ -->
<?php
	echo "<script>";
	echo " var modalAjaxURL = '" . PROJECTURLMENU . "tecnicos/ajax_ver_tecnico';" ;
	echo " var editarSolucionAction = '" . PROJECTURLMENU . "tecnicos/solucionar_incidencia';" ;
	echo "</script>";
?>
<form id="enviarTecnico" method="post" enctype="multipart/form-data">
	<input type="hidden" id="tecnicoId" name="tecnicoId" value="" />
	<input type="hidden" id="incidenciaId_form" name="incidenciaId_form" value="" />
	<input type="hidden" id="empresaId" name="empresaId" value="" />
</form>

<!-- ========================= Formulario para asignar incidencia ============================ -->
<form id="asignarmeIncidenciaAmi" method="post" enctype="multipart/form-data" 
	action="<?= PROJECTURLMENU; ?>tecnicos/asignarmeIncidencia">

		<input type="hidden" id="incidenciaId_aMi" name="incidenciaId_aMi" value="" />
</form>


<!-- ========================= Formulario para VER SOLUCION DE una incidencia  ================================== -->
<form id="resolucionIncidenciaForm" method="post" enctype="multipart/form-data" 
	action="<?= PROJECTURLMENU; ?>tecnicos/ver_resolucion_incidencia">
	
		<input type="hidden" id="resolucionIncidenciaId" name="resolucionIncidenciaId" value="" />
</form>

<!-- ================================== Formulario para VER Data Conexion Remota =================================== -->
<?php
	echo "<script> var modalAjaxURL_3 = '" . PROJECTURLMENU . "tecnicos/ajax_ver_datos_conexion_remota'; </script>" ;
?>
<form id="askDataLink" method="post" enctype="multipart/form-data">
	<input type="hidden" id="DataLink_incidenciaId" name="DataLink_incidenciaId" value="" />
</form>


<!-- ========================= MODAL mostrando Incidencia CERRADA satisfactoriamente  ============== -->
<div class="modal fade" id="incidenciaModal" role="dialog">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title" align="center">
			<span class="glyphicon glyphicon-wrench"></span> 
<?php 			if ( isset($incidencia_cerrada_correctamente_titulo) ){
					echo $incidencia_cerrada_correctamente_titulo;
			 	}
?>
		  </h4>
		</div>
		<div class="modal-body">
		  <p>
			<div id="feedback">
<?php 			if ( isset($incidencia_cerrada_correctamente) ){
					echo $incidencia_cerrada_correctamente;
				}
?>
			</div>
		  </p>
		  <p><div id="feedback">
<?php 			if ( isset($incidencia_cerrada_correctamente_footer) ){
					echo $incidencia_cerrada_correctamente_footer;
				}
?>
		  </div></p>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		</div>
	  </div>
	</div>
</div>


<script>

	function verInfoTecnico(tecnicoId){

		$('#myModal').modal('show');

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
	 * Para crear la solucion de este problema
	 */
	function editarSolucion(incidenciaId, tecnicoId, empresaId){

		var r = confirm(" >> Resolver la Incidencia/Reporte número: "
			+ incidenciaId + " << "
			+ "\n Esta opción le permitirá llenar el Formulario de Resolución de esta Incidencia."
			+ "\n\n ¿Desea continuar?"
			+ "\n (Presione Yes/OK si usted dará el Soporte TI a esta incidencia)");

		if (r == true) {
			/* txt = "You pressed OK!"; */
			document.getElementById("incidenciaId_form").value  = "" + incidenciaId;
			document.getElementById("tecnicoId").value 			= "" + tecnicoId;
			document.getElementById("empresaId").value 			= "" + empresaId;

			document.getElementById("enviarTecnico").action = editarSolucionAction;
			document.getElementById("enviarTecnico").submit();

			return true;

		} else {
			/* txt = "You pressed Cancel!";*/
			return false;
		}
	}

	function asignarmeIncidencia(incidenciaId){

		var ask = confirm(" >> Asignarte la Incidencia número: "
			+ incidenciaId + " << "
			+ "\n\n Pulsando esta opción, usted será el Ingeniero de Soporte a cargo de Resolver esta Incidencia."
			+ "\n [ Podrá solucionar la Incidencia ahora mismo o en otro momento. ]"
			+ "\n\n ¿Desea continuar?"
			+ "\n (Presione Yes/OK para asignarse esta incidencia)");

		if ( ask == true) {
			/* añadiendo valor y mandadno formulario */
			document.getElementById("incidenciaId_aMi").value = incidenciaId;

			document.getElementById("asignarmeIncidenciaAmi").submit();
		}
	}

	/**
	 * Formulario como el del Tecnico pero sin poder editar
	 */
	function verDetalleSolucion(resolucionId){

		document.getElementById("resolucionIncidenciaId").value = resolucionId;

		document.getElementById("resolucionIncidenciaForm").submit();
	}

</script>

<?php 
	if ( isset($incidencia_cerrada_correctamente) ){
		/*
		 * Mostrar el modal de incidencia cerrada
		 */
		echo "<script> $('#incidenciaModal').modal('show'); </script>";

		unset($incidencia_cerrada_correctamente);
	}
?>