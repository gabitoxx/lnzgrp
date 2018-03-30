<?php
	/*
	 * Se necesita saber si ESTE FORMULARIO se salvarà por primera vez
	 * o si es una ACTUALIZACIÒN
	 * para reenviarlo
	 */
	$phpFunction = "";
	if ( !isset( $redirigirA) ){
		$phpFunction = "inventario_manual_crear";
	} else {
		$phpFunction = $redirigirA;
		/* inventario_manual_actualizar_data */
	}

?>

<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-blackboard logo slideanim"></span>
	<i>Inventario: recabar manualmente la info del Equipo donde NO se pudo ejecutar el Script (archivos <b>.csv</b>)</i>
	<span class="glyphicon glyphicon-edit"></span>
</h4>

<div class="row" style="background-color:#F9B233;">
	<div class="col-sm-12" align="left">
		<b>Info:</b>
		<br/>
		<?= $infoEmpresaUsuario; ?>
	</div>
</div>

<div class="row" style="background-color:#F9B233;">
	<div class="col-sm-12" align="right">
		<?="<b>C&oacute;digo de Barras generado:</b> " . $newEquipoCodBarras; ?>
	</div>
</div>

<div class="row" style="background-color:#F9B233;">
	<div class="col-sm-12" align="right">
		<?= "<b>ID del Equipo en el sistema:</b> " . $equipoId; ?>
	</div>
</div>


<form data-toggle="validator" role="form" id="form_inventario_manual" method="post"
 enctype="multipart/form-data" action="<?= PROJECTURLMENU . "tecnicos/" . $phpFunction; ?>">

	<input type="hidden" id="equipoId" 	   name="equipoId" 	   value="<?= $equipoId; ?>" />
	<input type="hidden" id="equipoBarras" name="equipoBarras" value="<?= $newEquipoCodBarras; ?>" />

	<input type="hidden" id="equipoInfoId" name="equipoInfoId" value="<?php
		if ( isset($equipoInfoId) ){ echo $equipoInfoId;} else { echo ''; }
	?>" />


	<input type="hidden" id="nombreWindows1"  name="nombreWindows1"  value="" />

	<br/><br/>
	<hr/>
	<br/>
	<div class="row" style="font-size:18px;">
		<div class="col-sm-12" align="center">
			<i><u>Sistema Operativo* (debe indicar uno)</u></i>
		</div>
	</div>
	<br/>

	<div id="nombreWindows-div" class="form-group">
		<label class="control-label col-sm-3" for="nombreWindows">Nombre Windows:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-gift"></i></span>
				<input type="text" class="form-control" id="nombreWindows" name="nombreWindows" placeholder="NO incluya la parte inicial 'Microfsot Windows', escriba VERSION y el NOMBRE. Ejemplo: 8.1 Pro"
				 onblur="javascript:validar('nombreWindows');return false;">
				<span id="nombreWindows-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="nombreWindows-error" class="help-block">
				&nbsp;
			</div>
		</div>
	</div>

	

	<div class="row">
		<div class="col-sm-3">
			<i><u>Nombre a almacenar en el Sistema:</u></i>
		</div>
		<div class="col-sm-9">
			<b>
				Microfsot Windows <span id="span_nombreWindows"></span>
			</b>
		</div>
	</div>
	<br/>
	<div class="row">
		<div class="col-sm-12">
			Asegurese que el nombre de arriba esté <i>bien escrito</i>.
			Puede cerciorarse en el <a target="_blank" href="https://en.wikipedia.org/wiki/List_of_Microsoft_Windows_versions">listado de Windows de Wikipedia</a>
			en la tabla, columna <b>"Editions" (Ediciones)</b>
			 (<i>Tecla Windows + Pausa</i>, en la ventana Control Panel->Sistema, aparece el nombre exacto).
		</div>
	</div>

	<br/><br/>

	<div id="linux-div" class="form-group">
		<label class="control-label col-sm-3" for="linux">S.O. (NO Windows):</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-gift"></i></span>
				<input type="text" class="form-control" id="linux" name="linux" placeholder="LLENAR solo en caso de NO ser Windows, otro Sistema Operativo"
				 onblur="javascript:validar('linux');return false;">
				<span id="linux-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="linux-error" class="help-block">
				&nbsp;
			</div>
		</div>
	</div>

	<br/><br/><br/><br/>
	<hr/>
	<br/>
	<div class="row" style="font-size:18px;">
		<div class="col-sm-12" align="center">
			<i><u>Office</u></i>
		</div>
	</div>
	<br/>

	<div id="versionOffice-div" class="form-group">
		<label class="control-label col-sm-3" for="versionOffice">Versi&oacute;n Office*:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-edit"></i></span>
				<input type="text" class="form-control" id="versionOffice" name="versionOffice" placeholder="Versión de Office SOLO NÚMEROS SIN COMA, SEPARADOR DECIMAL CON PUNTO" required="required"
				 onblur="javascript:validar('versionOffice');return false;">
				<span id="versionOffice-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="versionOffice-error" class="help-block">
				&nbsp;
			</div>
		</div>
	</div>

	<br/><br/><br/><br/>
	<hr/>
	<br/>
	<div class="row" style="font-size:18px;">
		<div class="col-sm-12" align="center">
			<i><u>Info del CPU</u></i>
		</div>
	</div>
	<br/>

	<div id="marcaProcesador-div" class="form-group">
		<label class="control-label col-sm-3" for="marcaProcesador">Marca del Procesador*:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-object-align-vertical"></i></span>
				<input type="text" class="form-control" id="marcaProcesador" name="marcaProcesador" placeholder="Marca del Procesador" required="required"
				 onblur="javascript:validar('marcaProcesador');return false;">
				<span id="marcaProcesador-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="marcaProcesador-error" class="help-block">
				&nbsp;
			</div>
		</div>
	</div>


	<div id="referenciaCPU-div" class="form-group">
		<label class="control-label col-sm-3" for="referenciaCPU">Referencia*:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-object-align-vertical"></i></span>
				<input type="text" class="form-control" id="referenciaCPU" name="referenciaCPU" placeholder="Referencia del Procesador" required="required"
				 onblur="javascript:validar('referenciaCPU');return false;">
				<span id="referenciaCPU-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="referenciaCPU-error" class="help-block">
				&nbsp;
			</div>
		</div>
	</div>


	<div id="velocidadCPU-div" class="form-group">
		<label class="control-label col-sm-3" for="velocidadCPU">Velocidad*:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-object-align-vertical"></i></span>
				<input type="text" class="form-control" id="velocidadCPU" name="velocidadCPU" placeholder="Velocidad en Mhz, Ghz" required="required"
				 onblur="javascript:validar('velocidadCPU');return false;">
				<span id="velocidadCPU-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="velocidadCPU-error" class="help-block">
				&nbsp;
			</div>
		</div>
	</div>


	<div id="socket-div" class="form-group">
		<label class="control-label col-sm-3" for="socket">Socket*:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-object-align-vertical"></i></span>
				<input type="text" class="form-control" id="socket" name="socket" placeholder="Socket"
				 onblur="javascript:validar('socket');return false;">
				<span id="socket-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="socket-error" class="help-block">
				&nbsp;
			</div>
		</div>
	</div>

	<div id="nucleos-div" class="form-group">
		<label class="control-label col-sm-3" for="nucleos">N&uacute;cleos*:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
				<select class="form-control" id="nucleos" name="nucleos" onblur="javascript:validar('nucleos');return false;">
					<option value="none">---- Elige uno ----</option>
<?php
					for( $i = 1; $i <= 20; $i++ ){
						echo '<option value="' . $i . '">' . $i . '</option>';
					}
?>
				</select>
				<span id="nucleos-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="nucleos-error" class="help-block">
				&nbsp;
			</div>
		</div>
	</div>

	  <div id="arquitectura-div" class="form-group">
		<label class="control-label col-sm-3" for="arquitectura">Arquitectura*:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
				<select class="form-control" id="arquitectura" name="arquitectura" onblur="javascript:validar('Arquitectura');return false;">
					<option value="none">---- Elige uno ----</option>
					<option value="32">32 bits</option>
					<option value="64">64 bits</option>
				</select>
				<span id="arquitectura-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="arquitectura-error" class="help-block">
				&nbsp;
			</div>
		</div>
	</div>


	<div id="cache-div" class="form-group">
		<label class="control-label col-sm-3" for="cache">Cach&eacute;:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-object-align-vertical"></i></span>
				<input type="text" class="form-control" id="cache" name="cache" placeholder="Caché" required="required"
				 onblur="javascript:validar('cache');return false;">
				<span id="cache-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="cache-error" class="help-block">
				&nbsp;
			</div>
		</div>
	</div>

	<br/><br/><br/><br/>
	<hr/>
	<br/>
	<div class="row" style="font-size:18px;">
		<div class="col-sm-12" align="center">
			<i><u>Tarjeta Madre</u></i>
		</div>
	</div>
	<br/>

	<div id="referenciaMB-div" class="form-group">
		<label class="control-label col-sm-3" for="referenciaMB">Referencia*:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
				<input type="text" class="form-control" id="referenciaMB" name="referenciaMB" placeholder="Referencia" required="required"
				 onblur="javascript:validar('referenciaMB');return false;">
				<span id="referenciaMB-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="referenciaMB-error" class="help-block">
				&nbsp;
			</div>
		</div>
	</div>


	<div id="marcaMB-div" class="form-group">
		<label class="control-label col-sm-3" for="marcaMB">Marca:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
				<input type="text" class="form-control" id="marcaMB" name="marcaMB" placeholder="Marca de la Motherboard"
				 onblur="javascript:validar('marcaMB');return false;">
				<span id="marcaMB-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="marcaMB-error" class="help-block">
				&nbsp;
			</div>
		</div>
	</div>

	<br/><br/><br/><br/>
	<hr/>
	<br/>
	<div class="row" style="font-size:18px;">
		<div class="col-sm-12" align="center">
			<i><u>Memoria RAM</u></i>
		</div>
	</div>
	<br/>

	<div class="row">
		<div class="col-sm-12">
			<table id="tableRAM" name="tableRAM" class="table table-hover table-striped" style="font-size: 12px;width:100%;">
				<thead>
					<tr>
						<th>Tipo de Memoria</th>
						<th>Tama&ntilde;o</th>
						<th>Velocidad</th>
						<th>Eliminar ingreso</th>
					</tr>
				</thead>
				<tbody>
					<!-- vacio -->
				</tbody>
			</table>
		</div>
	</div>
	<!-- SALVAR los valores SERIALIZADOS por coma ',' de la tabla para el form.SUBMIT -->
	<input type="hidden" id="cantidadRAMs"  name="cantidadRAMs" 	value="" />
	<input type="hidden" id="ram_tipo" 		name="ram_tipo" 		value="" />
	<input type="hidden" id="ram_tamanyo" 	name="ram_tamanyo" 		value="" />
	<input type="hidden" id="ram_velocidad" name="ram_velocidad" 	value="" />

	<div class="row">
		<br/>
		<div class="col-sm-12"  style="text-align:center;">
			<button id="addSW" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalRAM">
				<span class="glyphicon glyphicon-plus"></span> 
				 Agregar Memoria RAM a la lista
			</button>
		</div>
		<br/>
	</div>

	<br/><br/><br/><br/>
	<hr/>
	<br/>
	<div class="row" style="font-size:18px;">
		<div class="col-sm-12" align="center">
			<i><u>Discos Duros (f&iacute;sicos)</u></i>
		</div>
	</div>
	<br/>

	<div class="row">
		<div class="col-sm-12">
			<table id="tableHDD" name="tableHDD" class="table table-hover table-striped" style="font-size: 12px;width:100%;">
				<thead>
					<tr>
						<th>Marca</th>
						<th>Tama&ntilde;o en Gb</th>
						<th>Velocidad</th>
						<th>Horas de Uso</th>
						<th>Interfaz</th>		
						<th>Eliminar ingreso</th>
					</tr>
				</thead>
				<tbody>
					<!-- vacio -->
				</tbody>
			</table>
		</div>
	</div>
	<!-- SALVAR los valores SERIALIZADOS por coma ',' de la tabla para el form.SUBMIT -->
	<input type="hidden" id="cantidadHDDs"  name="cantidadHDDs" value="" />
	<input type="hidden" id="hdd_marca" 	name="hdd_marca" value="" />
	<input type="hidden" id="hdd_tamanyo" 	name="hdd_tamanyo" value="" />
	<input type="hidden" id="hdd_velocidad" name="hdd_velocidad" value="" />
	<input type="hidden" id="hdd_horasuso"  name="hdd_horasuso" value="" />
	<input type="hidden" id="hdd_interfaz"  name="hdd_interfaz" value="" />

	<div class="row">
		<br/>
		<div class="col-sm-12"  style="text-align:center;">
			<button id="addSW" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalHDD">
				<span class="glyphicon glyphicon-plus"></span> 
				 Agregar Disco Duro a la lista
			</button>
		</div>
		<br/>
	</div>

</form>

<div class="row">
	<div class="col-sm-12" align="center">
		<br/><br/><br/>
		<hr/>
		Una vez que haya completado el levantamiento de informaci&oacute;n de este Equipo 
		y est&eacute; conforme proporcionando la Data correcta, pulse 'Guardar'...
		<br/><br/>
		<button type="submit" id="createAccount" 
		 class="btn btn-success btn-lg" onclick="javascript:return submitForm();" 
		 data-toggle="tooltip" data-placement="bottom" title="">
			<span class="glyphicon glyphicon-blackboard"></span> Guardar Data de este Equipo
		</button>
	</div>
</div>

<!-- ===================================================================================================== -->
<fieldset class="scheduler-border">
	
	<legend class="scheduler-border">Importante</legend>
	
	<div class="row control-group">
		<div class="col-sm-2">C&oacute;digo de Barras:</div>
		<div class="col-sm-10">
			el <b>c&oacute;digo de barras</b> que gener&oacute; el Sistema para ESTE Equipo es el siguiente:
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10" style="text-align:center;font-family:monospace;font-size: 60px;"> 
<?php
	$aux = $newEquipoCodBarras;
	$companyId  = substr($aux, 0, 4);
	$tipoEquipo = substr($aux, 4, 2);
	$id 		= substr($aux, 6, 4);
?>			
			<img id="imgX" alt="Codigo de barras generado" src="<?= APPIMAGEPATH; ?>barcode_example.png" />
			<br/>
			<span style="color:#0D181C;">
				<?= $companyId; ?>
			</span>
			<span style="color:#E30513;">
				<?= $tipoEquipo; ?>
			</span>
			<span style="color:#94A6B0;">
				<?= $id; ?>
			</span>
		</div>
	</div>
	<br/>
	<div class="row control-group">
		<div class="col-sm-2">Para su informaci&oacute;n:</div>
		<div class="col-sm-10">
			el <b>c&oacute;digo de barras</b> se compone de la siguiente manera:
			<br/><br/>
			Total de d&iacute;gitos num&eacute;ricos: <b>10</b>
			<br/>
			- <span style="color:#0D181C;">los primeros 4 d&iacute;gitos</span>: son el <b>ID de la Empresa en el Portal</b>.
			<br/>
			- <span style="color:#E30513;">el d&iacute;gito 5º y 6º</span>: son el <b>ID del Tipo de Equipo (Presentaci&oacute;n)</b>: Servidor, Todo-en-Uno, Escritorio, Port&aacute;til, etc.
			<br/>
			- <b><span style="color:#94A6B0;">los &uacute;ltimos 4 d&iacute;gitos</span></b>: son el <b>ID del Equipo dentro de la Empresa</b>
			(<i>NO el id del Equipo en el Portal</i>). Para cada Empresa se comienza con el n&uacute;mero 1;
			<i>pero el ID en el Portal es &uacute;nico en todo el Sistema</i>. 
			Por ejemplo: Un Equipo puede tener el ID "1" dentro la Empresa, pero en el Portal puede ser ID "10023".
			<br/>
			- el <b>ID de Sistema</b> (que puede ver en esta pantalla, arriba y a la derecha) es diferente,
			NO tiene que coincidir con este c&oacute;digo de barras. Este ID es para diferenciar el Equipo de 
			entre todos los Equipos registrados en el Portal LanuzaGroup.
			<br/><br/>
			<b>Ejemplo:</b> un c&oacute;digo <b>1234010004</b> generado por el Sistema significar&iacute;a que 
			ESTE Equipo pertenece a la Empresa con identificador ID: <b>1234</b>; 
			que ser&iacute;a un Servidor (ID de Presentaci&oacute;n <b>01</b>) y que este 
			ser&iacute;a el cuarto Equipo registrado para esta empresa (ID dentro de la Empresa <b>0004</b>).
		</div>
	</div>
</fieldset>

<script>
	function validar(elementId){
		/* alert( document.getElementById(elementId).value );  */
		/* alert( $("#" + elementId).val() ); */

		var bError = false;
		var sErrorMessage = "";

		var valor = $("#" + elementId).val();

		/**
		 * Manejando todos los campos del formulario
		 * Longitud > 2
		 * No numericos
		 */
		if ( elementId == "givenname" ){
			if ( valor.length < 2 ){
				bError = true;
				sErrorMessage = "Longitud m&iacute;nima de Nombre es 2";
			}
			else if ( isNumber( valor ) ){
				bError = true;
				sErrorMessage = "El Nombre no puede contener N&uacute;meros";
			}
		}

		if ( elementId == "nombreWindows" ){

			document.getElementById("span_nombreWindows").innerHTML = valor;

			/* hidden */
			$("#nombreWindows1").val( "Microfsot Windows " + valor );
		}
	}

	/**
	 * Añadiendo RAM's
	 */
	var cantidadRAMs = 0;
	function addRAM(){

		limpiarEstilos("RAM");
		
		var x1 = $("#tipomemoria").val();
		var x2 = $("#tamanyoCadaMemoria").val();
		var x3 = $("#velocidadCadaMemoria").val();

		var bool = true;
		
		if ( x1 == "" || x1 == "none" ){
			
			bool = false;
		
			document.getElementById("tipomemoria-div").className = "form-group has-error has-feedback";
			document.getElementById("tipomemoria-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("tipomemoria-error").innerHTML = "Debe elegir uno";
		}

		if ( !esNumero(x2) || (esNumero(x2) && x2.includes(".")) || (x2.trim() == "") ){
			
			bool = false;
		
			document.getElementById("tamanyoCadaMemoria-div").className = "form-group has-error has-feedback";
			document.getElementById("tamanyoCadaMemoria-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("tamanyoCadaMemoria-error").innerHTML = "No debe ser vacío, numérico sin coma";
		}

		if ( !esNumero(x3) || (esNumero(x3) && x3.includes(".")) || (x3.trim() == "") ){
			
			bool = false;
		
			document.getElementById("velocidadCadaMemoria-div").className = "form-group has-error has-feedback";
			document.getElementById("velocidadCadaMemoria-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("velocidadCadaMemoria-error").innerHTML = "Numérico sin coma NI punto";
		}

		
		/* Si hay *campos vacíos, NO esconder Modal */
		if ( bool == false ){
			$('#myModalSoftware').modal('show');

		} else {
			/*
			 * limpiando formulario para añadir un siguiente
			 */
			document.getElementById("tipomemoria").value = "";
			document.getElementById("tamanyoCadaMemoria").value= ""; 
			document.getElementById("velocidadCadaMemoria").value 	= "";
			
			/*
			 * sumando 1 al CONT de la lista 
			 * y guardandolo en variable HIDDEN
			 */
			cantidadRAMs++;
			document.getElementById("cantidadRAMs").value = cantidadRAMs;

			/*
			 * Añadiendo a la TABLA
			 */
			var table = document.getElementById("tableRAM");
			var row = table.insertRow(cantidadRAMs);

			var cell0 = row.insertCell(0);
			var cell1 = row.insertCell(1);
			var cell2 = row.insertCell(2);
			var cell3 = row.insertCell(3);

			cell0.innerHTML = "" + x1;
			cell1.innerHTML = "" + x2;
			cell2.innerHTML = "" + x3;
			cell3.innerHTML = '<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Eliminar esta entrada" onclick="javascript:eliminarEntradaRAM(\'' + x1+x2+x3 + '\');"><span class="glyphicon glyphicon-trash"></span></button>'
			;

			$('#myModalRAM').modal('hide');

			limpiarEstilos("RAM");
		}
	}

	function eliminarEntradaRAM( textoAencontrar ){
		
		var r = confirm("¿Seguro de eliminar esta entrada de RAM?");
		if ( r == true) {
			var aux = "";
			var i = 0;
			/*
			 * Recorrido de tabla HTML usando Javascript para obtener valores
			 */
			for ( i=1; i < document.getElementById('tableRAM').rows.length -1; i++){

				aux ="" + document.getElementById('tableRAM').rows[i].cells[0].innerHTML
						+ document.getElementById('tableRAM').rows[i].cells[1].innerHTML
						+ document.getElementById('tableRAM').rows[i].cells[2].innerHTML;

				if ( textoAencontrar == aux ){
					break;
				}
			}

			document.getElementById( "tableRAM" ).deleteRow( i );
			
			/* Actualizar la cantidad */
			cantidadRAMs--;
			document.getElementById("cantidadRAMs").value = cantidadRAMs;
		}
	}


	/**
	 * Añadiendo hdd's
	 */
	var cantidadHDDs = 0;
	function addHDD(){

		limpiarEstilos("HDD");

		var x1 = $("#marca").val();
		var x2 = $("#tamanyoGigas").val();
		var x3 = $("#velocidad").val();
		var x4 = $("#horauso").val();
		var x5 = $("#interfaz").val();

		var bool = true;
		
		if ( x1 == "" ){
			
			bool = false;
		
			document.getElementById("marca-div").className = "form-group has-error has-feedback";
			document.getElementById("marca-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("marca-error").innerHTML = "No debe ser vacío";
		}

		if ( (x2.trim() == "") || !esNumero(x2) ){
			bool = false;
		
			document.getElementById("tamanyoGigas-div").className = "form-group has-error has-feedback";
			document.getElementById("tamanyoGigas-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("tamanyoGigas-error").innerHTML = "No debe ser vacío. NUMÉRICO";
		}

		if ( !esNumero(x4) || (esNumero(x4) && x4.includes(".")) || (x4.trim() == "") ){
			bool = false;
		
			document.getElementById("velocidad-div").className = "form-group has-error has-feedback";
			document.getElementById("velocidad-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("velocidad-error").innerHTML = "No debe ser vacío. NUMÉRICO sin punto";
		}

		if ( !esNumero(x4) || (esNumero(x4) && x4.includes(".")) || (x4.trim() == "") ){
			
			bool = false;
		
			document.getElementById("horauso-div").className = "form-group has-error has-feedback";
			document.getElementById("horauso-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("horauso-error").innerHTML = "No debe ser vacío. NUMÉRICO sin punto";
		}


		/* Si hay *campos vacíos, NO esconder Modal */
		if ( bool == false ){
			$('#myModalHDD').modal('show');

		} else {
			/*
			 * limpiando formulario para añadir un siguiente
			 */
			document.getElementById("marca").value = "";
			document.getElementById("tamanyoGigas").value= ""; 
			document.getElementById("velocidad").value 	= "";
			document.getElementById("horauso").value= "";

			/*
			 * sumando 1 al CONT de la lista 
			 * y guardandolo en variable HIDDEN
			 */
			cantidadHDDs++;
			document.getElementById("cantidadHDDs").value = cantidadHDDs;

			/*
			 * Añadiendo a la TABLA
			 */
			var table = document.getElementById("tableHDD");
			var row = table.insertRow(cantidadHDDs);

			var cell0 = row.insertCell(0);
			var cell1 = row.insertCell(1);
			var cell2 = row.insertCell(2);
			var cell3 = row.insertCell(3);
			var cell4 = row.insertCell(4);
			var cell5 = row.insertCell(5);

			cell0.innerHTML = "" + x1;
			cell1.innerHTML = "" + x2;
			cell2.innerHTML = "" + x3;
			cell3.innerHTML = "" + x4;
			cell4.innerHTML = "" + x5;
			cell5.innerHTML = '<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Eliminar esta entrada" onclick="javascript:eliminarEntradaHDD(\'' + x1+x2+x3+x4+x5 + '\');"><span class="glyphicon glyphicon-trash"></span></button>'
			;

			$('#myModalHDD').modal('hide');

			limpiarEstilos("HDD");
		}
	}

	function eliminarEntradaHDD( textoAencontrar ){
		
		var r = confirm("¿Seguro de eliminar esta entrada de Disco Duro?");
		if ( r == true) {
			var aux = "";
			var i = 0;
			/*
			 * Recorrido de tabla HTML usando Javascript para obtener valores
			 */
			for ( i=1; i < document.getElementById('tableHDD').rows.length -1; i++){

				aux ="" + document.getElementById('tableHDD').rows[i].cells[0].innerHTML
						+ document.getElementById('tableHDD').rows[i].cells[1].innerHTML
						+ document.getElementById('tableHDD').rows[i].cells[2].innerHTML
						+ document.getElementById('tableHDD').rows[i].cells[3].innerHTML
						+ document.getElementById('tableHDD').rows[i].cells[4].innerHTML;

				if ( textoAencontrar == aux ){
					break;
				}
			}

			document.getElementById( "tableHDD" ).deleteRow( i );
			
			/* Actualizar la cantidad */
			cantidadHDDs--;
			document.getElementById("cantidadHDDs").value = cantidadHDDs;
		}
	}


	function limpiarEstilos(part){

		if ( part == "RAM" ){

			document.getElementById("tipomemoria-span").className = "";
			document.getElementById("tipomemoria-div").className = "form-group";
			document.getElementById("tipomemoria-error").innerHTML = "";

			document.getElementById("tamanyoCadaMemoria-span").className = "";
			document.getElementById("tamanyoCadaMemoria-div").className = "form-group";
			document.getElementById("tamanyoCadaMemoria-error").innerHTML = "";

		} else if ( part == "HDD" ){

			document.getElementById("marca-span").className = "";
			document.getElementById("marca-div").className = "form-group";
			document.getElementById("marca-error").innerHTML = "";

			document.getElementById("tamanyoGigas-span").className = "";
			document.getElementById("tamanyoGigas-div").className = "form-group";
			document.getElementById("tamanyoGigas-error").innerHTML = "";

			document.getElementById("velocidad-span").className = "";
			document.getElementById("velocidad-div").className = "form-group";
			document.getElementById("velocidad-error").innerHTML = "";

			document.getElementById("interfaz-span").className = "";
			document.getElementById("interfaz-div").className = "form-group";
			document.getElementById("interfaz-error").innerHTML = "";

			document.getElementById("horauso-span").className = "";
			document.getElementById("horauso-div").className = "form-group";
			document.getElementById("horauso-error").innerHTML = "";
		
		} else if ( part == "form" ){

			document.getElementById("versionOffice-span").className = "";
			document.getElementById("versionOffice-div").className = "form-group";
			document.getElementById("versionOffice-error").innerHTML = "";

			document.getElementById("marcaProcesador-span").className = "";
			document.getElementById("marcaProcesador-div").className = "form-group";
			document.getElementById("marcaProcesador-error").innerHTML = "";

			document.getElementById("referenciaCPU-span").className = "";
			document.getElementById("referenciaCPU-div").className = "form-group";
			document.getElementById("referenciaCPU-error").innerHTML = "";

			document.getElementById("velocidadCPU-span").className = "";
			document.getElementById("velocidadCPU-div").className = "form-group";
			document.getElementById("velocidadCPU-error").innerHTML = "";

			document.getElementById("socket-span").className = "";
			document.getElementById("socket-div").className = "form-group";
			document.getElementById("socket-error").innerHTML = "";

			document.getElementById("nucleos-span").className = "";
			document.getElementById("nucleos-div").className = "form-group";
			document.getElementById("nucleos-error").innerHTML = "";

			document.getElementById("arquitectura-span").className = "";
			document.getElementById("arquitectura-div").className = "form-group";
			document.getElementById("arquitectura-error").innerHTML = "";

			document.getElementById("referenciaMB-span").className = "";
			document.getElementById("referenciaMB-div").className = "form-group";
			document.getElementById("referenciaMB-error").innerHTML = "";
		}

	}
</script>

<!-- ========================= Modal RAM =============================================== -->
<div id="myModalRAM" class="modal fade" role="dialog">

  <div class="modal-dialog modal-lg">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Agregar Memoria RAM</h4>
	  </div>
	  <div class="modal-body">
		
		<form id="formsoftware">

			<div id="tipomemoria-div" class="form-group">
				<label class="control-label col-sm-3" for="tipomemoria">Tipo de Memoria*:</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-modal-window"></i></span>
						<select class="form-control" id="tipomemoria" name="tipomemoria" onblur="javascript:validar('tipomemoria');return false;">
							<option value="none">---- Elige uno ----</option>
							<option value="DDR">DDR</option>
							<option value="DDR2">DDR2</option>
							<option value="DDR3">DDR3</option>
							<option value="DD3">DD3</option>
							<option value="SDRAM">SDRAM</option>
							<option value="Unknow">Desconocido</option>
						</select>
						<span id="tipomemoria-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="tipomemoria-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>



			<div id="tamanyoCadaMemoria-div" class="form-group">
				<label class="control-label col-sm-3" for="tamanyoCadaMemoria">Tamaño en Gigas*:</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-modal-window"></i></span>
						<input type="text" class="form-control" id="tamanyoCadaMemoria" name="tamanyoCadaMemoria" placeholder="Tamaño en Gb, SOLO NUMEROS (el PUNTO es el separador DECIMAL). Ejemplo: 2.4" required="required"
						 onblur="javascript:validar('tamanyoCadaMemoria');return false;">
						<span id="tamanyoCadaMemoria-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="tamanyoCadaMemoria-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>


			<div id="velocidadCadaMemoria-div" class="form-group">
				<label class="control-label col-sm-3" for="velocidadCadaMemoria">Velocidad :</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-modal-window"></i></span>
						<input type="text" class="form-control" id="velocidadCadaMemoria" name="velocidadCadaMemoria" placeholder="Velocidad de esta Memoria. Ejemplo: 1333, 1600, 8299, etc."
						 onblur="javascript:validar('velocidadCadaMemoria');return false;">
						<span id="velocidadCadaMemoria-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="velocidadCadaMemoria-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<br/><br/>
			<div class="form-group">
				<div class="col-sm-4">
					<div style="color:#E30513;"><b>* = Campo Obligatorio</b></div>
				</div>
			</div>
			<br/><br/>
		</form>

	  </div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-info" 
			onclick="javascript:addRAM();return false;">
			  Agregar a la lista
		  </button>
		   &nbsp;&nbsp;&nbsp;&nbsp;
		  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar sin agregar</button>
		</div>
	  </div>

  </div>
</div>

<!-- ========================= Modal HDD =============================================== -->
<div id="myModalHDD" class="modal fade" role="dialog">

  <div class="modal-dialog modal-lg">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Agregar Disco Duro (f&iacute;sico)</h4>
	  </div>
	  <div class="modal-body">
		
		<form id="formsoftware">

			<div id="marca-div" class="form-group">
				<label class="control-label col-sm-3" for="marca">Marca*:</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-hdd"></i></span>
						<input type="text" class="form-control" id="marca" name="marca" placeholder="Marca del Disco duro" required="required"
						 onblur="javascript:validar('marca');return false;">
						<span id="marca-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="marca-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>


			<div id="tamanyoGigas-div" class="form-group">
				<label class="control-label col-sm-3" for="tamanyoGigas">Tamaño (en Gigas)*:</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-hdd"></i></span>
						<input type="text" class="form-control" id="tamanyoGigas" name="tamanyoGigas" placeholder="Tamaño en Gb, NUMÉRICO, PUNTO es el separador DECIMAL" required="required"
						 onblur="javascript:validar('tamanyoGigas');return false;">
						<span id="tamanyoGigas-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="tamanyoGigas-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>


			<div id="velocidad-div" class="form-group">
				<label class="control-label col-sm-3" for="velocidad">Velocidad*:</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-hdd"></i></span>
						<input type="text" class="form-control" id="velocidad" name="velocidad" placeholder="Velocidad, NUMÉRICO SIN COMA NI PUNTO" required="required"
						 onblur="javascript:validar('velocidad');return false;">
						<span id="velocidad-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="velocidad-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>


			<div id="horauso-div" class="form-group">
				<label class="control-label col-sm-3" for="horauso">Horas de Uso*:</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-hdd"></i></span>
						<input type="text" class="form-control" id="horauso" name="horauso" placeholder="Horas que el Equipo lleva encendido. NUMÉRICO SIN COMA NI PUNTO" required="required"
						 onblur="javascript:validar('horauso');return false;">
						<span id="horauso-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="horauso-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<div id="interfaz-div" class="form-group">
				<label class="control-label col-sm-3" for="interfaz">Interfaz:</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
						<select class="form-control" id="interfaz" name="interfaz" onblur="javascript:validar('interfaz');return false;">
							<option value="IDE">IDE</option>
							<option value="SATA">SATA</option>
							<option value="USB">USB</option>
						</select>
						<span id="interfaz-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="interfaz-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<br/><br/>
			<div class="form-group">
				<div class="col-sm-4">
					<div style="color:#E30513;"><b>* = Campo Obligatorio</b></div>
				</div>
			</div>
			<br/><br/>
		</form>

		<br/><br/><br/>
	  </div>
	  <div class="modal-footer">
	  		<br/><br/><br/>
		  	<button type="button" class="btn btn-info" onclick="javascript:addHDD();return false;">
				Agregar a la lista
			</button>
		   &nbsp;&nbsp;&nbsp;&nbsp;
		  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar sin agregar</button>
	  </div>
	</div>
  </div>
</div>

<script>
	function submitForm(){
	
		var bool = true;
		var scrollElement = "#basicData";
		var scrolled = false;

		limpiarEstilos("form");

		if ( $("#nombreWindows").val() == "" && $("#linux").val() == "" ){
			bool = false;

			document.getElementById("nombreWindows-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("nombreWindows-div").className = "form-group has-error has-feedback";
			document.getElementById("nombreWindows-error").innerHTML = "Debe indicar Windows, linux, Mac, etc.";

		}

		if ( $("#versionOffice").val() == "" ){
			bool = false;

			document.getElementById("versionOffice-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("versionOffice-div").className = "form-group has-error has-feedback";
			document.getElementById("versionOffice-error").innerHTML = "Debe indicar sistema Ofimático: Windows office, LibreOffice, etc.";

		}

		if ( $("#marcaProcesador").val() == "" ){
			bool = false;

			document.getElementById("marcaProcesador-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("marcaProcesador-div").className = "form-group has-error has-feedback";
			document.getElementById("marcaProcesador-error").innerHTML = "NO Debe ser vacío";

		}

		if ( $("#referenciaCPU").val() == "" ){
			bool = false;

			document.getElementById("referenciaCPU-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("referenciaCPU-div").className = "form-group has-error has-feedback";
			document.getElementById("referenciaCPU-error").innerHTML = "NO Debe ser vacío";

		}

		if ( $("#velocidadCPU").val() == "" || !esNumero( $("#velocidadCPU").val() ) ){
			bool = false;

			document.getElementById("velocidadCPU-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("velocidadCPU-div").className = "form-group has-error has-feedback";
			document.getElementById("velocidadCPU-error").innerHTML = "Debe ser SOLO numérico entero (SIN decimales)";

		}

		if ( $("#nucleos").val() == "none" ){
			bool = false;

			document.getElementById("nucleos-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("nucleos-div").className = "form-group has-error has-feedback";
			document.getElementById("nucleos-error").innerHTML = "Elija uno";

		}

		if ( $("#arquitectura").val() == "none" ){
			bool = false;

			document.getElementById("arquitectura-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("arquitectura-div").className = "form-group has-error has-feedback";
			document.getElementById("arquitectura-error").innerHTML = "Elija uno";

		}
		var aux = $("#cache").val();
		if ( !esNumero( aux ) || aux.includes(".") ){
			bool = false;

			document.getElementById("cache-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("cache-div").className = "form-group has-error has-feedback";
			document.getElementById("cache-error").innerHTML = "Numérico SIN decimales";

		}

		if ( $("#referenciaMB").val() == "" ){
			bool = false;

			document.getElementById("referenciaMB-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("referenciaMB-div").className = "form-group has-error has-feedback";
			document.getElementById("referenciaMB-error").innerHTML = "NO Debe ser vacío";

		}


		if ( cantidadRAMs == 0 ){
			bool = false;
			alert("Debe añadir por lo menos 1 Memoria RAM");

		} else {
			/* serializar la tabla dinámica */
			var tipo = "";
			var tamanyo = "";
			var velocidad = "";
			
			var table = document.getElementById("tableRAM");
			var aux="";

			/* iterate through rows */
			for (var i = 0, row; row = table.rows[i]; i++) {
   
				/* saltando el titulo */
				if (i === 0) { continue; }

				/* rows would be accessed using the "row" variable assigned in the for loop */

				/* iterate through columns */
				for (var j = 0, col; col = row.cells[j]; j++) {
	 
					/* columns would be accessed using the "col" variable assigned in the for loop */
					aux = col.innerHTML;

					if(j===0){
						tipo += aux + "," ;

					} else if(j===1){
						tamanyo += aux + "," ;

					} else if(j===2){
						velocidad += aux + "," ;
					}
			   }
			}

			document.getElementById("ram_tipo").value 	 	= tipo;
			document.getElementById("ram_tamanyo").value 	= tamanyo;
			document.getElementById("ram_velocidad").value 	= velocidad;

		}


		if ( cantidadHDDs == 0 ){
			bool = false;
			alert("Debe añadir por lo menos 1 Disco Duro");

		} else {
			/* serializar la tabla dinámica */
			var marca = "";
			var tamanyo = "";
			var velocidad = "";
			var horas = "";
			var interfaz = "";
			
			var table = document.getElementById("tableHDD");
			var aux="";

			/* iterate through rows */
			for (var i = 0, row; row = table.rows[i]; i++) {
   
				/* saltando el titulo */
				if (i === 0) { continue; }

				/* rows would be accessed using the "row" variable assigned in the for loop */

				/* iterate through columns */
				for (var j = 0, col; col = row.cells[j]; j++) {
	 
					/* columns would be accessed using the "col" variable assigned in the for loop */
					aux = col.innerHTML;

					if ( j===0 ){
						marca += aux + "," ;

					} else if(j===1){
						tamanyo += aux + "," ;

					} else if(j===2){
						velocidad += aux + "," ;

					} else if(j===3){
						horas += aux + "," ;

					} else if(j===4){
						interfaz += aux + "," ;
					}
				}
			}

			document.getElementById("hdd_marca").value 	 	= marca;
			document.getElementById("hdd_tamanyo").value 	= tamanyo;
			document.getElementById("hdd_velocidad").value 	= velocidad;
			document.getElementById("hdd_horasuso").value 	= horas;
			document.getElementById("hdd_interfaz").value 	= interfaz;
		}
		
		if ( bool == true ){

			var ask = confirm( "¿Está seguro de que la data es CORRECTA y desea añadir esta información al Equipo actual?" );
			if ( ask == true) {
				
				/* submit POST enviando formulario */
				document.getElementById("form_inventario_manual").submit();
				
				return true;
			} else {
				return false;
			}
		} else {
			alert("Revise los Errores");
			return false;
		}
	}


	/**
	 * Funcion que determina si el valor pasado como parametro es o no un NUMERO
	 * Maneja espacios en blanco y null
	 */
	function esNumero (o) {
		return ! isNaN (o-0) && o !== null && o !== "" && o !== false;
	}
</script>