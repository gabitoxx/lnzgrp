<style>
	#imgX {
	 	width: 250px;
	 	height: 200px;
	}
</style> 
<div class="container">
	
	<div class="row">
		<div class="col-sm-12" align="center" style="padding: 12px 20px 12px 40px; font-size: 18px;">
			Aqu&iacute; usted podr&aacute; <b>asignar</b> y <b>desasignar</b> <i>Equipos</i> a los <u>Usuarios</u> de esta Empresa.
			<br/>
		</div>
	</div>

<?php 
	
	if ( $equipos != NULL && $equipos != "" ){

		$cont = -1;
		$inicioRow = false;
		$finRow    = false;

		foreach ($equipos as $equipo) {

			$cont++;

			if ( $cont % 2 == 0 ) {

				echo '<div class="row">';
				$inicioRow = true;
				$finRow    = false;
			}
?>
		<div class="col-sm-1">&nbsp;</div>
		<div class="col-sm-5 well well-lg" align="center" style="border-color:#000;">
			 
			<?php
				if ( $equipo["linkImagen"] != NULL && $equipo["linkImagen"] != "" ) {
					/*
					 * Imagen Real del Equipo (Foto)
					 */
					echo '<img id="imgX" alt="' . $equipo["TipoEquipo"] . '" src="' . $equipo["linkImagen"] . '" />';

				} else {
					echo '* ';

					if ( $equipo["TipoEquipo"] == "Escritorio" )						echo '<img id="imgX" alt="Escritorio" src="' . APPIMAGEPATH . 'escritorio.jpg" />';
					else if ( $equipo["TipoEquipo"] == "Todo-en-uno" )					echo '<img id="imgX" alt="Todo-en-uno" src="' . APPIMAGEPATH . 'Todo-en-uno.jpg" />';
					else if ( $equipo["TipoEquipo"] == "Laptop o Portátil" )			echo '<img id="imgX" alt="Laptop" src="' . APPIMAGEPATH . 'laptop.png" />';
					else if ( $equipo["TipoEquipo"] == "Servidor" )						echo '<img id="imgX" alt="Servidor" src="' . APPIMAGEPATH . 'servidor.png" />';
					else if ( $equipo["TipoEquipo"] == "Router" )						echo '<img id="imgX" alt="Router" src="' . APPIMAGEPATH . 'router.jpg" />';
					else if ( $equipo["TipoEquipo"] == "Impresora" )					echo '<img id="imgX" alt="Impresora" src="' . APPIMAGEPATH . 'impresora.jpg" />';
					else if ( $equipo["TipoEquipo"] == "Impresora Multifuncional" )		echo '<img id="imgX" alt="Impresora Multifuncional" src="' . APPIMAGEPATH . 'multifuncional.jpg" />';
					else if ( $equipo["TipoEquipo"] == "Cámara Vigilancia" )			echo '<img id="imgX" alt="Cámara Vigilancia" src="' . APPIMAGEPATH . 'camara.jpg" />';
					else if ( $equipo["TipoEquipo"] == "Escáner" )						echo '<img id="imgX" alt="Escáner" src="' . APPIMAGEPATH . 'escaner.jpg" />';
					else if ( $equipo["TipoEquipo"] == "Módem" )						echo '<img id="imgX" alt="Módem" src="' . APPIMAGEPATH . 'modem.jpg" />';
					else if ( $equipo["TipoEquipo"] == "Repetidor" )					echo '<img id="imgX" alt="Repetidor" src="' . APPIMAGEPATH . 'repetidor.jpg" />';
					else if ( $equipo["TipoEquipo"] == "Switch" )						echo '<img id="imgX" alt="Switch" src="' . APPIMAGEPATH . 'switch.jpg" />';
					else if ( $equipo["TipoEquipo"] == "Monitor" )						echo '<img id="imgX" alt="Monitor" src="' . APPIMAGEPATH . 'monitor.jpg" />';
					else if ( $equipo["TipoEquipo"] == "Teclado" )						echo '<img id="imgX" alt="Teclado" src="' . APPIMAGEPATH . 'teclado.jpg" />';
					else if ( $equipo["TipoEquipo"] == "Mouse" )						echo '<img id="imgX" alt="Mouse" src="' . APPIMAGEPATH . 'mouse.jpg" />';
					else if ( $equipo["TipoEquipo"] == "TV" )							echo '<img id="imgX" alt="TV" src="' . APPIMAGEPATH . 'TV.jpg" />';
					else if ( $equipo["TipoEquipo"] == "Equipo Empresarial especial" )	echo '<img id="imgX" alt="Equipo Empresarial especial" src="' . APPIMAGEPATH . 'maquina_especial.jpeg" />';
					else if ( $equipo["TipoEquipo"] == "POS" )							echo '<img id="imgX" alt="POS" src="' . APPIMAGEPATH . 'POS.png" />';
					else if ( $equipo["TipoEquipo"] == "Celular" )						echo '<img id="imgX" alt="Smartphones" src="' . APPIMAGEPATH . 'celular.png" />';
					else if ( $equipo["TipoEquipo"] == "Otro" )							echo '<img id="imgX" alt="Otro tipo de equipo" src="' . APPIMAGEPATH . 'otro_equipo.png" />';
					else 																echo '<img id="imgX" alt="Otro tipo de equipo" src="' . APPIMAGEPATH . 'computadora-empresarial-handheld.jpg" />';
				}
			?>
			<br/>
			<?= "<b>" . $equipo["TipoEquipo"] . "</b>"; ?>
			<br/>
			<?= "C&oacute;digo Barras: " . $equipo["codigoBarras"]; ?>
			<br/>
			<?= $equipo["infoBasica"]; ?>
			<?php 
				if ( $equipo["observacionInicial"] != NULL && $equipo["observacionInicial"] != ""){
					echo " (" . $equipo["observacionInicial"] . ") <br/>";
				}

				if ( $equipo["dependencia"] != NULL && $equipo["dependencia"] != ""){
			 		echo "Dependencia: " . "<i>" . $equipo["dependencia"] . "</i> <br/>";
				}

				if ( $equipo["nombre"] != NULL && $equipo["nombre"] != ""){
					$auxName = $equipo["saludo"] . " " . $equipo["nombre"] . " " . $equipo["apellido"];
					echo "Asignado a: <b>" . $auxName . "</b>";
					echo "<br/><br/>";
					?>

					<button type="button" class="btn btn-danger" 
					 <?php 
					 	echo 'onclick="javascript:desasociar(';
					 	echo $equipo["equipoId"] . "," . $equipo["usuarioId"] . ", '" . $equipo["codigoBarras"] . "' , '" . $auxName . "'";
					 	echo ');"';
					 ?>
					 data-toggle="tooltip" data-placement="bottom" title="Eliminar la Asociaci&oacute;n de este Equipo a este Usuario">
					 	<span class="glyphicon glyphicon-log-out"></span> Des-asignar Equipo</button>
					
					<?php
				} else {
					echo "Equipo <b>NO</b> asignado.";
					echo "<br/><br/>";
					?>
					<button type="button" class="btn btn-primary" 
					 <?php 
					 	echo 'onclick="javascript:asociarA(';
					 	echo $equipo["equipoId"] . ", '" . $equipo["codigoBarras"] . "'";
					 	echo ');"';
					 ?>
					 data-toggle="tooltip" data-placement="bottom" title="Asociar este Equipo a un Usuario de esta Empresa">
					 	<span class="glyphicon glyphicon-log-in"></span> Asignar Equipo a Usuario...</button>

					<?php
				}
			?>
		</div>

<?php
			if ( $cont % 2 != 0 ) {

				echo '</div>';/* row */
				$finRow = true;
			}

		}/* foreach */

		if ( $inicioRow == true && $finRow == false ){
			echo '</div>';/* row */
		}

	} else {
		echo "No hay Equipos de esta empresa. Para agregar Equipos, vaya a Menú <b>Equipos -&gt; Nuevo Inventario</b>.";
	}
?>

	
	<div class="row">
		<br/><br/>
		<div class="col-sm-12" align="center">
			<h4>* Fotos referenciales, NO son fotos de los Equipos reales de la Empresa.</h4>
		</div>
	</div>

	<br/>

	<fieldset class="scheduler-border">
		
		<legend class="scheduler-border">Leyenda</legend>
		
		<div class="row control-group">
			<div class="col-sm-1">Acciones:</div>
			<div class="col-sm-11">Usted puede optar por realizar las siguientes acciones:</div>
		</div>
		<div class="row control-group">
			<div class="col-sm-offset-2 col-sm-10">
				<table class="table table-hover table-striped">
					<tr>
						<td style="width: 234px;">
							<button type="button" class="btn btn-danger">
							<span class="glyphicon glyphicon-log-out"></span> Des-asignar Equipo</button>
						</td>
						<td>
							Cuando ya el Equipo tiene un Usuario asignado y desea quitar esta asociaci&oacute;n 
							(ya sea porque el Usuario se fue de la Empresa, porque ha de usar otro Equipo, etc.) 
							a trav&eacute;s de esta opci&oacute;n usted eliminar&aacute; la asociaci&oacute;n en el sistema; 
							es decir, <b>este 
							<span class="glyphicon glyphicon-blackboard"></span> Equipo quedar&aacute; libre para que pueda ser asignado a 
							otro Usuario</b>.
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row control-group">
			<div class="col-sm-offset-2 col-sm-10">
				<table class="table table-hover table-striped">
					<tr>
						<td style="width: 234px;">
							<button type="button" class="btn btn-primary">
							<span class="glyphicon glyphicon-log-in"></span> Asignar Equipo a Usuario...</button>
						</td>
						<td>
							Cuando un Equipo NO tiene una asociación en el Sistema 
							(es decir, no se posee información de quién lo está usando) 
							a trav&eacute;s de esta opci&oacute;n usted podr&aacute; 
							establecer dicha asociaci&oacute;n; 
							<b>
								as&iacute; sabremos qu&eacute; 
								<span class="glyphicon glyphicon-user"></span> Usuario
								est&aacute; usando dicho 
								<span class="glyphicon glyphicon-blackboard"></span> Equipo
							</b>.
						</td>
					</tr>
				</table>
			</div>
		</div>

	</fieldset>
</div>
<!-- ========================================================================================================= -->
<?php
	echo "<script>";
	echo " var searchURL  = '" . PROJECTURLMENU . "gerentes/desasociar_equipo_usuario';" ;
	echo " var searchURL2 = '" . PROJECTURLMENU . "gerentes/asociar_equipo_usuario';" ;
	echo "</script>";
?>
<form class="form-horizontal" data-toggle="validator" role="form" id="asignacion_form"
	 method="post" enctype="multipart/form-data" action="">

	  <input type="hidden" id="equipoId" 	name="equipoId"   value="" />
	  <input type="hidden" id="usuarioId"   name="usuarioId"  value="" />

	  <input type="hidden" id="seleccionarEmpresaID"   			name="seleccionarEmpresaID"  			value="<?= $searchedCompanyId; ?>" />
	  <input type="hidden" id="seleccionarEmpresaNombre"    	name="seleccionarEmpresaNombre"  		value="<?= $companyInfo; ?>" />
	  <input type="hidden" id="seleccionarEmpresaRazonsocial"   name="seleccionarEmpresaRazonsocial"  	value="" />
	  <input type="hidden" id="seleccionarEmpresaNIT"    		name="seleccionarEmpresaNIT"  			value="" />
	  <input type="hidden" id="seleccionarEmpresaDireccion"    	name="seleccionarEmpresaDireccion"  	value="" />
	  <input type="hidden" id="seleccionarEmpresaCantEquipos"   name="seleccionarEmpresaCantEquipos"  	value="" />

</form>
<!-- ========================================================================================================= -->
<script>
	function desasociar(equipoId, usuarioId, codigoBarras, nombre){

		var ask = confirm("Se procederá a desasociar..."
				+ "\n\n El Equipo: " + codigoBarras
				+ "\n\n Del Usuario: " + nombre
				+ "\n\n\n¿Desea continuar?");
		
		if ( ask == true) {

			document.getElementById("equipoId").value =  equipoId;
			document.getElementById("usuarioId").value = usuarioId;

			document.getElementById("asignacion_form").action = searchURL;
			document.getElementById("asignacion_form").submit();
			return true;

		} else {
			return false;
		}
	}

	function asociarA(equipoId, codigoBarras){

		document.getElementById("barCodeModal").innerHTML = codigoBarras;

		document.getElementById("equipoId").value = equipoId;

		$('#myModal').modal('show');
	}

	function seleccionarUsuario(){

		if ( $("#givenname").val() == "0" ){
			alert("Debe SELECCIONAR UN USUARIO para Asignarlo al Equipo");
			return false;

		} else {
			document.getElementById("usuarioId").value = $("#givenname").val();

			document.getElementById("asignacion_form").action = searchURL2;
			document.getElementById("asignacion_form").submit();
			return true;
		}
	}

</script>
<!-- ========================================================================================================= -->
<div class="modal fade" id="myModal" role="dialog">
	
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title" align="center">
			<span class="glyphicon glyphicon-blackboard"></span> 
			&rarr;
			<span class="glyphicon glyphicon-user"></span> 
			Asignar Equipo a Usuario...
		  </h4>
		</div>

		<div class="modal-body">
		  
			<div class="row">
				<div class="col-sm-12">
					A continuaci&oacute;n seleccione uno de los siguientes 
					<b>Usuarios activos</b> 
					en el Sistema (de esta Empresa) 
					para asignarle el Equipo: <b><span id="barCodeModal"></span></b>
					<br/>
					<br/>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">

					<select class="form-control" id="givenname" name="givenname">
					
					<option value="0">  --  Seleccione al Usuario afectado --  </option>
					
					<?php
						if ( isset($no_usuarios) ){

							echo "<option disabled>No hay Usuarios registrados</option>";

							unset($no_usuarios);

						} else {
							foreach ($usuarios as $usuario){
								echo '<option value="' . $usuario[0] . '">' . $usuario[3] . " " . $usuario[4] . '</option>';
							}
						}
					?>

				</select>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12" align="center">
					<br/>
					<br/>
					<button id="accept" type="button" class="btn btn-primary btn-lg" onclick="javascript:seleccionarUsuario();"
					 data-toggle="tooltip" data-placement="bottom" title="PRIMERO Seleccionar un USUARIO y luego pulsar ESTE BOTÓN">
					   <span class="glyphicon glyphicon-user"></span> Seleccionar Usuario</button>
				</div>
			</div>

		</div>

		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar SIN asignar</button>
		</div>
	  </div>
	</div>
</div>