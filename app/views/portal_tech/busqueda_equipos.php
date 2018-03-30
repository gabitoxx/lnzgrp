<?php 
	echo "<script>";
	echo " var searchURL4= '" . PROJECTURLMENU . "tecnicos/actualizar_equipo';" ;
	echo "</script>";

	/*
	 * En esta seccion se buscará un Equipo
	 */
	if ( isset($procesoParte) 
			&& ($procesoParte == "Busqueda_Equipo" || $procesoParte == "Seleccion_Equipo") ){
		
		echo "<script>";
		echo " var searchURL = '" . PROJECTURLMENU . "tecnicos/inventario_buscar_usuario';" ;
		echo " var searchURL2= '" . PROJECTURLMENU . "tecnicos/inventario_buscar_company';" ;
		echo "</script>";
?>


	<div class="row">
		<div class="col-sm-9" align="center" style="padding: 12px 20px 12px 40px; font-size: 18px; color: #E30513;">
			<i>Utilice el buscador para seleccionar el Equipo a Actualizar:</i>
		</div>
		<div class="col-sm-3" align="right">
			<a href="<?= PROJECTURLMENU; ?>tecnicos/nuevo_inventario">&iquest;No existe el Equipo&quest;: Crear Equipo nuevo</a>
		</div>
	</div>

<!-- ================================================================================================================= -->

	<hr/>

	<form class="form-horizontal" data-toggle="validator" role="form" id="search_equipo_form" method="post"
	 enctype="multipart/form-data" action="<?= PROJECTURLMENU ?>tecnicos/inventario_buscar_equipo">
		
		<div class="row">
			<div class="col-sm-12" align="left" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				Puede buscar Equipos por <b>Nombre de Empresa</b>, <b>info de Usuarios</b> (nombre, apellido, email) o por <b>C&oacute;digo de Barras</b> (ID del Equipo)
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2" align="right" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				<b>Buscar Equipo:</b>
			</div>
			<div class="col-sm-10">
				<style>
					#search {
						width: 230px;
						-webkit-transition: width 0.4s ease-in-out;
						transition: width 0.4s ease-in-out;
						padding: 12px 20px 12px 40px;
						font-size: 14px;
						border-radius: 4px;
						border: 2px solid #ccc;
						box-sizing: border-box;

						background-image: url('<?= APPIMAGEPATH; ?>searchicon.png');
						background-position: 10px 12px;
						background-repeat: no-repeat;
					}

					/* When the input field gets focus, change its width to 100% */
					#search:focus {
						width: 100%;
					}
				</style>
				<input type="text" name="search" id="search" placeholder="Buscar Equipos de Usuarios o de Empresa, indique palabra(s) clave... y presione ENTER (3 CARACTERES al menos)"
				 <?php if ( isset($searched) ) echo 'value="' . $searched . '"'; ?>
				 >
			</div>
		</div>
	</form>

	<script>
		$(document).ready(function () {

			$("#search").on('keyup', function (e) {
				if (e.keyCode == 13) {
					/* al presionar ENTER */

					if ( $("#search").val().length >= 3 ){

						document.getElementById("search_equipo_form").submit();

					} else {
						alert('Indique al menos 3 letras');
						return false;
					}
				}
			});
		});
	</script>

<?php 
	} /* Busqueda_Equipo */

	if ( isset($procesoParte) && $procesoParte == "Seleccion_Equipo") {

		if ( isset($no_equipos) ) {
?>
			
			<div class="row">
				<div class="col-sm-12" align="left" style="padding: 12px 20px 12px 40px; font-size: 16px;">
					No se encontraron <b>Equipos</b> con el criterio de b&uacute;squeda 
<?php
	 					if(isset($searched)) echo '"<i>' . $searched .'</i>"';
						else 				 echo 'indicado arriba.';
?>	
					<br/>
					Intente con otra palabra clave nuevamente.
				</div>
			</div>

<?php 
		} /* no_equipos */

		if ( isset($equipos) ) {
?>

<div class="container">
	<div id="no-more-tables">
		<table id="tableId" class="col-md-12 table-hover table-striped cf" style="font-size: 12px;">
			<thead class="cf">
				<tr>
					<th align="center" style="text-align: center;">ID<br/>Equipo</th>
					<th align="center" style="text-align: center;width: 90px;">Acciones</th>
					<th>C&oacute;digo Barras</th>
					<th style="width: 200px;">Info b&aacute;sica</th>
					<th>Fecha creaci&oacute;n<br/>(A&ntilde;o-Mes-D&iacute;a Hora)</th>
					<th>ID TeamViewer</th>
					<th style="width: 250px;">Empresa</th>
					<th style="text-align: center;">Asignado a</th>
					<th align="center" style="text-align: center;">&iquest;Inventariado&quest;<br/>(S&iacute;/No)</th>
				</tr>
			</thead>
			<tbody>
<?php 			
				foreach ($equipos as $equipo) {

					$companyName = $equipo["NombreEmpresa"];
					if ( $equipo["razonSocial"] != NULL && $equipo["razonSocial"] != "" ) {
						$companyName .=  " (" . $equipo["razonSocial"] . ")";
					}

					$userAsiggned = "";
					if ( $equipo["NombreUsuarioAsignado"] != NULL || $equipo["NombreUsuarioAsignado"] != "" ){
						$userAsiggned = $equipo["NombreUsuarioAsignado"] . " " . $equipo["ApellidoUsuarioAsignado"];
					} else {
						$userAsiggned = " ";
					}
?>
				<tr style="border-spacing:5em;" 
<?php 
						if ( $equipo["equipoInfoId"] == NULL){ echo 'class="danger"'; }
						else { echo 'class="success"'; }
?>
				>

					<td data-title="ID Equipo" align="center" style="text-align: center;"><?php echo $equipo["id"]; ?></td>

					<td data-title="Acciones" style="width: 90px;">
<?php 					if ( $equipo["equipoInfoId"] == NULL){  ?>
							<button type="button" class="btn btn-success"
							 onclick="javascript:crearInventario('<?= $equipo["id"] ?>');"
							 data-toggle="tooltip" data-placement="bottom" title="Crear Inventario desde cero"
							>
								<span class="glyphicon glyphicon-floppy-disk"></span>
							</button>
							&nbsp;

<?php 					} else {  ?>
							<button type="button" class="btn btn-primary"
							 onclick="javascript:actualizarInventario('<?= $equipo["NombreUsuarioAsignado"] ?>','<?= $equipo["ApellidoUsuarioAsignado"] ?>','<?= $equipo["NombreEmpresa"] ?>','<?= $equipo["razonSocial"] ?>','<?= $equipo["equipoInfoId"] ?>','<?= $equipo["id"] ?>');"
							 data-toggle="tooltip" data-placement="bottom" title="Actualizar Inventario de este Equipo"
							>
								<span class="glyphicon glyphicon-floppy-open"></span>
							</button>
							&nbsp;
<?php 					}  ?>
						
						<button type="button"class="btn btn-warning"
						 onclick="javascript:popupTeamViewer('<?= $equipo["id"] ?>', '<?= $companyName; ?>', '<?= $userAsiggned; ?>');"
						 data-toggle="tooltip" data-placement="bottom" title="Actualizar la data de este Equipo"
						>
							<span class="glyphicon glyphicon-edit"></span>
						</button>
						<br/>

					</td>
					<td data-title="C&oacute;digo Barras" style="text-align: center;">
						<?php echo $equipo["codigoBarras"]; ?>
					</td>
					<td data-title="Info b&aacute;sica" style="width: 200px;">
<?php 					echo $equipo["TipoEquipo"];
						if ( $equipo["infoBasica"] != NULL && $equipo["infoBasica"] != "" ){
							echo "<br/>" . $equipo["infoBasica"];
						}
?>
					</td>
					<td data-title="Fecha creaci&oacute;n"><?php echo $equipo["fechaCreacion"]; ?></td>

					<td data-title="ID TeamViewer" style="text-align: center;">
						<?php echo $equipo["teamViewer_Id"]; ?>
					</td>

					<td data-title="Empresa">
						<?= $companyName; ?>
					</td>
					<td data-title="Asignado a" style="text-align: center;">
<?php 					if ( $equipo["NombreUsuarioAsignado"] != NULL && $equipo["NombreUsuarioAsignado"] != "" ) {
							echo $equipo["NombreUsuarioAsignado"] . "<br/>" . $equipo["ApellidoUsuarioAsignado"];
							
							if ( $equipo["dependencia"] != NULL && $equipo["dependencia"] != "" ) {
								echo "<br/>(" . $equipo["dependencia"] . ")";
							}
						} else {
							echo "<i>N/A</i>";
						}
?>
					</td>
					<td data-title="&iquest;Inventariado&quest;" align="center" style="text-align: center;">
<?php 					if ( $equipo["equipoInfoId"] != NULL && $equipo["equipoInfoId"] != "" ) {
							echo "S&iacute;";
						} else {
							echo "No";
						}
?>
					</td>
				</tr>
<?php 			} ?>

			</tbody>
		</table>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<br/><br/>
		</div>
	</div>

	<fieldset class="scheduler-border">
	
		<legend class="scheduler-border">Leyenda</legend>
		
		<div class="row control-group">
			<div class="col-sm-2">C&oacute;digo de Barras:</div>
			<div class="col-sm-10">
			 es el <b>identificador &uacute;nico</b>
			 el cual se gener&oacute; a partir de la <b>creaci&uacute;n del Equipo</b>,
			 debe tener un m&aacute;ximo de 10 digitos num&eacute;ricos.
			</div>
		</div>

		<br/>

		<div class="row control-group">
			<div class="col-sm-2">N/A:</div>
			<div class="col-sm-10">
			 <b>No Asignado</b>, si el Equipo NO est&aacute; asociado a un Usuario en espec&iacute;fico.
			</div>
		</div>

		<br/>

		<div class="row control-group">
			<div class="col-sm-2">&iquest;Inventariado&quest;:</div>
			<div class="col-sm-10">
				si ya se ha ingresado la informaci&oacute;n espec&iacute;fica del Equipo, 
				a partir del uso de los Scripts de levantamiento de informaci&oacute;n durante la
				labor de Inventariado.
				<br/>
				<b>S&iacute;</b> significa que ya se ha usado los Scripts (por lo menos una vez) 
				en este Equipo.
				<br/>
				<b>No</b> significa que no se ha usado los Scripts en este Equipo,
				por lo que no se conoce ning&uacute;n detalle del mismo.
			</div>
		</div>

		<br/>

		<div class="row control-group">
			<div class="col-sm-2">Acciones:</div>
			<div class="col-sm-10">&nbsp;</div>
		</div>

		<div class="row control-group">
			<div class="col-sm-offset-2 col-sm-10">
				<table class="table table-hover table-striped">
					<tr>
						<td class="success" style="width: 96px;">
							<span class="glyphicon glyphicon-floppy-disk"></span> 
							Crear Inventario:
						</td>
						<td>Esta acci&oacute;n ser&aacute; necesaria cuando el Equipo apenas 
							se ha registrado en el Sistema <b>y a&uacute;n NO se ha han usado
							los Scripts</b> para capturar informaci&oacute;n de dicho Equipo.
							Para mayor informaci&oacute;n sobre los Scripts, consulte 
							en el <u>Men&uacute;</u>, en las secciones 
							<b>Tutorial de Inventario</b> y <b>Uso del Script</b>.
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row control-group">
			<div class="col-sm-offset-2 col-sm-10">
				<table class="table table-hover table-striped">
					<tr>
						<td class="info" style="width: 96px;">
							<span class="glyphicon glyphicon-floppy-open"></span> 
							Actualizar Inventario:
						</td>
						<td>Esta acci&oacute;n permite actualizar la informaci&oacute;n e Inventario de 
							un Equipo en particular. Usted puede actualizar <b>UNO, VARIOS o TODOS</b> 
							los Scripts. Al Actualizar la informaci&oacute;n, quedar&aacute; registrada 
							como la m&aacute;s reciente ("<i>estado actual</i>"), lo que permitir&aacute; poder 
							hacer comparaciones con estados previos del Equipo ("<i>estado previo</i>").
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row control-group">
			<div class="col-sm-offset-2 col-sm-10">
				<table class="table table-hover table-striped">
					<tr>
						<td class="warning" style="width: 96px;">
							<span class="glyphicon glyphicon-edit"></span> 
							Actualizar Equipo:
						</td>
						<td>Esta acci&oacute;n permitir&aacute; actualizar la data 
							del Equipo. Este le desplegar&aacute; el mismo formulario de 
							Creaci&oacute;n de Nuevo Equipo y podr&aacute; modificar ninguno, uno o m&aacute;s campos.
						</td>
					</tr>
				</table>
			</div>
		</div>
	
	</fieldset>

</div>

<?php
	echo "<script>";
	echo " var searchURL = '" . PROJECTURLMENU . "tecnicos/inventario_desde_cero';" ;
	echo " var searchURL2= '" . PROJECTURLMENU . "tecnicos/inventario_actualizar';" ;
	echo " var searchURL3= '" . PROJECTURLMENU . "tecnicos/actualizar_teamviewer';" ;
	echo "</script>";
?>
<form class="form-horizontal" data-toggle="validator" role="form" id="subir_scripts_form" method="post"
 enctype="multipart/form-data" action="">

	<input type="hidden" id="equipoId" 		name="equipoId" 	value="" />
	<input type="hidden" id="Nombre"   		name="Nombre" 		value="" />
	<input type="hidden" id="Apellido" 		name="Apellido"  	value="" />
	<input type="hidden" id="Empresa"  		name="Empresa" 		value="" />
	<input type="hidden" id="RazonSocial"	name="RazonSocial"	value="" />
	<input type="hidden" id="equipoInfoId"  name="equipoInfoId" value="" />
</form>

<script>
	function crearInventario(equipoId){

		$("#equipoId").val( equipoId );

		document.getElementById("subir_scripts_form").action = searchURL;
		document.getElementById("subir_scripts_form").submit();
	}

	function actualizarInventario(nombre,apellido,empresa,razonSocial,equipoInfoId,equipoId){

		$("#equipoId").val( equipoId );
		$("#equipoInfoId").val( equipoInfoId );
		$("#Nombre").val( nombre );
		$("#Apellido").val( apellido );
		$("#Empresa").val( empresa );
		$("#RazonSocial").val( razonSocial );

		document.getElementById("subir_scripts_form").action = searchURL2;
		document.getElementById("subir_scripts_form").submit();
	}

	function popupTeamViewer(equipoId, empresa, usuario){

		document.getElementById("modalTitulo").innerHTML = equipoId;

		/* muestra modal 
		$('#myModal').modal('show');

		$("#tv_equipoId").val( equipoId );
		*/

		$("#equipoId").val( equipoId );
		$("#Empresa").val( empresa );
		$("#Nombre").val( usuario );

		document.getElementById("subir_scripts_form").action = searchURL4;
		document.getElementById("subir_scripts_form").submit();
	}

	function actualizarTeamViewer(){

		$("#myModal").modal('hide');

		/* Get the snackbar DIV */
		var x = document.getElementById("snackbar");

		/*x.innerHTML = snackbarMessage;*/

		/* Add the "show" class to DIV */
		x.className = "show";

		/* llenando el form HIDDEN */
		$("#tv_id").val( 		$("#teamViewerID").val() 	);
		$("#tv_clave").val( 	$("#teamViewerClave").val() );
		$("#tv_search").val( 	$("#search").val() 			);


		/* enviando formulario despues de 3 segundos */
		setTimeout(function(){
			//$("#updateTeamViewer").action = searchURL3;
			//$("#updateTeamViewer").submit();

			document.getElementById("updateTeamViewer").action = searchURL3;
			document.getElementById("updateTeamViewer").submit();
		 }, (3 * 1000) );
	}

</script>

<form id="updateTeamViewer" method="post" enctype="multipart/form-data" action="" role="form" >
	<input type="hidden" id="tv_equipoId"   name="tv_equipoId"  value="" />
	<input type="hidden" id="tv_id" 		name="tv_id" 		value="" />
	<input type="hidden" id="tv_clave"  	name="tv_clave" 	value="" />
	<input type="hidden" id="tv_search"  	name="tv_search" 	
<?php 
		if ( isset($searched) ) echo 'value="' . $searched . '"';
		else echo 'value=""';
?> />
</form>

<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title" align="center" style="color: #E30513;">
			<span class="glyphicon glyphicon-resize-horizontal"></span> 
			Actualizar pareja ID/Clave de TeamViewer para el equipo
			#<span id="modalTitulo"></span> 
		  </h4>
		</div>

		<div class="modal-body">

			<div class="row">
				<div class="col-sm-12">
					A continuaci&oacute;n establezca los nuevos valores para ID y Contrase&ntilde;a
					(estos sobreescribir&aacute;n los antiguos valores):
					<br/>
					<br/>
				</div>
			</div>

			<div id="teamViewerID-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label data-toggle="tooltip" data-placement="bottom" title="9 digitos NUMÉRICOS sin espacios">
						<u>TeamViewer ID</u>:(&quest;)</label>
				</div>
				<div class="col-sm-3">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-resize-horizontal"></i></span>
						<input type="text" class="form-control" id="teamViewerID" name="teamViewerID"
						 placeholder="(9 dígitos)">
						 <span id="teamViewerID-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-3" align="right">
					<label data-toggle="tooltip" data-placement="bottom" title="6 caracteres ALFA-NUMÉRICOS">
						<u>TeamViewer Clave</u>:(&quest;)</label>
				</div>
				<div class="col-sm-2" align="right">
					<input type="text" class="form-control" id="teamViewerClave" name="teamViewerClave" placeholder="Ej: 123abc">
					<span id="teamViewerClave-span" class=""></span>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12" align="center">
					<br/>
					<button type="button" class="btn btn-success btn-lg" onclick="javascript:actualizarTeamViewer();">
						<span class="glyphicon glyphicon-ok"></span> 
						Actualizar Credenciales
					  </button>
					<br/>
				</div>
			</div>

		</div>

		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Salir SIN Actualizar</button>
		</div>
	  </div>
	</div>
</div>

<?php 
		} /* equipos */
	} /* Seleccion_Equipo */
?>

<!-- ================== snackbar para avisar que el mensaje fue enviado ===================================== -->
<style>
	/* The snackbar - position it at the bottom and in the middle of the screen */
	#snackbar {
		visibility: hidden; 	/* Hidden by default. Visible on click */
		min-width: 250px; 		/* Set a default minimum width */
		margin-left: -125px; 	/* Divide value of min-width by 2 */
		background-color: #333; /* Black background color */
		color: #fff; 			/* White text color */
		text-align: center; 	/* Centered text */
		border-radius: 2px; 	/* Rounded borders */
		padding: 16px; 			/* Padding */
		position: fixed; 		/* Sit on top of the screen */
		z-index: 1; 			/* Add a z-index if needed */
		left: 50%; 				/* Center the snackbar */
		bottom: 30px; 			/* 30px from the bottom */
	}

	/* Show the snackbar when clicking on a button (class added with JavaScript) */
	#snackbar.show {
		visibility: visible; /* Show the snackbar */

		/* Add animation: Take 0.5 seconds to fade in and out the snackbar. 
		 * However, delay the fade out process for 4.5 seconds
		 */
		-webkit-animation: fadein 0.5s, fadeout 0.5s 4.5s;
		animation: fadein 0.5s, fadeout 0.5s 4.5s;
	}

	/* Animations to fade the snackbar in and out */
	@-webkit-keyframes fadein {
		from {bottom: 0; opacity: 0;} 
		to {bottom: 30px; opacity: 1;}
	}

	@keyframes fadein {
		from {bottom: 0; opacity: 0;}
		to {bottom: 30px; opacity: 1;}
	}

	@-webkit-keyframes fadeout {
		from {bottom: 30px; opacity: 1;} 
		to {bottom: 0; opacity: 0;}
	}

	@keyframes fadeout {
		from {bottom: 30px; opacity: 1;}
		to {bottom: 0; opacity: 0;}
	}
</style>

<!-- The actual snackbar -->
<div id="snackbar">
	Actualizando Credenciales de TeamViewer...
</div>