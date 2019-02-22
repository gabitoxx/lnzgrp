<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-blackboard logo slideanim"></span>
	<i>Inventario: completar info con el Script (archivos <b>.csv</b> generados) </i>&nbsp;&nbsp;&nbsp;
</h4>

<?php
	if ( isset($newEquipo) && $newEquipo == "no_creado"){
?>
	
	<hr/>
	<div class="row">
		<div class="col-sm-12" style="padding: 12px 20px 12px 40px; font-size: 16px;">
			<b>No se pudo crear un nuevo Equipo para el Usuario </b><i><?= $searchedUserName; ?></i>
			<br/>
			Intente nuevamente o verifique el ERROR en el Sistema.
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2" align="left">
			<a href="<?= PROJECTURLMENU; ?>tecnicos/nuevo_inventario">Intentar Nuevo Inventario</a>
		</div>
	</div>

<?php
	} else if ( isset($newEquipo) && $newEquipo != NULL ){
?>
	
	<script>
		/* para almacenar texto HTML */
		var generalInfo = "";
	</script>

	<div class="container">

<?php 		
		if ( isset($companyInfo) ){
?>
			<div class="row" style="background-color:#F9B233;">
				<div class="col-sm-12" align="left">
					<?= "<b>Empresa Seleccionada:</b> " . $companyInfo; ?>
				</div>
			</div>

<?php 
			echo '<script> generalInfo = "<b>Empresa Seleccionada:</b> ' . $companyInfo . '<br/>"; </script>';
		}
?>

		<div class="row" style="background-color:#F9B233;">
			<div class="col-sm-2" align="right">
<?php
		if ( isset($searchedUserName) ){ echo "<b>Usuario Seleccionado:</b>"; } else { echo " "; }
?>
			</div>
			<div class="col-sm-2" align="left">
<?php
		if ( isset($searchedUserName) ){ 
			echo $searchedUserName;
			echo '<script> generalInfo += "<b>Usuario Seleccionado:</b> '.$searchedUserName . '<br/>"; </script>';			
		} else {
			echo " ";
		}
?>
			</div>
			<div class="col-sm-3" align="right">
				<span class="glyphicon glyphicon-thumbs-up"></span> 
				<b>Equipo Nuevo creado:</b>
			</div>
			<div class="col-sm-3" align="left">
				C&oacute;digo de Barras: <?= $newEquipo["codigoBarras"]; ?>
			</div>
			<div class="col-sm-2" align="left">
				ID en Sistema: <?= $newEquipo["id"]; ?>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12" align="left">
				<br/>
				<h6>Para realizar el <span class="glyphicon glyphicon-blackboard"></span> Inventario
					debe primero correr el <b>Script</b> propiedad de <i>Lanuza Group</i> para este fin. 
					<u>Si NO sabe c&oacute;mo hacerlo, por favor consulte los Tutoriales en la secci&oacute;n del 
					<b>Men&uacute; "Ayuda"</b></u>.
				</h6>
			</div>
		</div>

		<br/>
		<form data-toggle="validator" role="form" id="files_inventario" method="post"
		 enctype="multipart/form-data" action="<?= PROJECTURLMENU ?>tecnicos/inventario_leer_archivos">

			<input type="hidden" id="newEquipoId" 	  name="newEquipoId" 	 value="<?= $newEquipo["id"]; ?>" />
			<input type="hidden" id="newEquipoBarras" name="newEquipoBarras" value="<?= $newEquipo["codigoBarras"]; ?>" />

			<style>
				.file {
				  visibility: hidden;
				  position: absolute;
				}
			</style>
			<script>
				
				$(document).on('click', '.browse', function(){
					var file = $(this).parent().parent().parent().find('.file');
					file.trigger('click');
				});

				$(document).on('change', '.file', function(){
					$(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
				});

			</script>

			<div class="row">
				<div class="col-sm-12" align="left">
					A continuaci&oacute;n adjunte los archivos con extensi&oacute;n
					<b>".csv"</b> generados por el Script, 
					seg&uacute;n lo solicita cada tipo de Archivo:
				</div>
			</div>
			<br/>
			<div class="row">

				<div class="col-sm-2" align="right" style="font-size: 16px;">
					1: Adjunte <b>CPU.csv</b>
				</div>
				<div class="col-sm-4" align="left">
					<div class="form-group">
						<input type="file" name="CPU" id="CPU" class="file">
						<div class="input-group">
						  <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
						  <input type="text" id="text_CPU" name="text_CPU" class="form-control input-lg" disabled="disabled" placeholder="Buscar CPU.csv ...">
						  <span class="input-group-btn">
							<button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Buscar</button>
						  </span>
						</div>
					  </div>
				</div>

				<div class="col-sm-2" align="right" style="font-size: 16px;">
					2: Adjunte <b>RAM.csv</b>
				</div>
				<div class="col-sm-4" align="left">
					<div class="form-group">
						<input type="file" name="RAM" id="RAM" class="file">
						<div class="input-group">
						  <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
						  <input type="text" id="text_RAM" name="text_RAM" class="form-control input-lg" disabled="disabled" placeholder="Buscar RAM.csv ...">
						  <span class="input-group-btn">
							<button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Buscar</button>
						  </span>
						</div>
					  </div>
				</div>

			</div>

			<div class="row">

				<div class="col-sm-2" align="right" style="font-size: 16px;">
					3: <b>Hard drives.csv</b>
				</div>
				<div class="col-sm-4" align="left">
					<div class="form-group">
						<input type="file" name="Hard_drives" id="Hard_drives" class="file">
						<div class="input-group">
						  <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
						  <input type="text" id="text_Hard_drives" name="text_Hard_drives" class="form-control input-lg" disabled="disabled" placeholder="Buscar Hard drives.csv ...">
						  <span class="input-group-btn">
							<button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Buscar</button>
						  </span>
						</div>
					  </div>

				</div>

				<div class="col-sm-2" align="right" style="font-size: 16px;">
					4: <b>SMART.csv</b>
				</div>
				<div class="col-sm-4" align="left">
					<div class="form-group">
						<input type="file" name="SMART" id="SMART" class="file">
						<div class="input-group">
						  <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
						  <input type="text" id="text_SMART" name="text_SMART" class="form-control input-lg" disabled="disabled" placeholder="Buscar SMART.csv ...">
						  <span class="input-group-btn">
							<button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Buscar</button>
						  </span>
						</div>
					  </div>
				</div>
				
			</div>

			<div class="row">
				
				<div class="col-sm-2" align="right" style="font-size: 16px;">
					5: <b>LocalUsers.csv</b>
				</div>
				<div class="col-sm-4" align="left">
					<div class="form-group">
						<input type="file" name="LocalUsers" id="LocalUsers" class="file">
						<div class="input-group">
						  <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
						  <input type="text" id="text_LocalUsers" name="text_LocalUsers" class="form-control input-lg" disabled="disabled" placeholder="Buscar LocalUsers.csv ...">
						  <span class="input-group-btn">
							<button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Buscar</button>
						  </span>
						</div>
					  </div>
				</div>

				<div class="col-sm-2" align="right" style="font-size: 16px;">
					6: <b>Software.csv</b>
				</div>
				<div class="col-sm-4" align="left">
					<div class="form-group">
						<input type="file" name="Software" id="Software" class="file">
						<div class="input-group">
						  <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
						  <input type="text" id="text_Software" name="text_Software" class="form-control input-lg" disabled="disabled" placeholder="Buscar Software.csv ...">
						  <span class="input-group-btn">
							<button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Buscar</button>
						  </span>
						</div>
					  </div>
				</div>
				
			</div>

			<div class="row">
				
				<div class="col-sm-2" align="right" style="font-size: 16px;">
					7: <b>Motherboard.csv</b>
				</div>
				<div class="col-sm-4" align="left">
					<div class="form-group">
						<input type="file" name="Motherboard" id="Motherboard" class="file">
						<div class="input-group">
						  <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
						  <input type="text" id="text_Motherboard" name="text_Motherboard" class="form-control input-lg" disabled="disabled" placeholder="Buscar Motherboard.csv ...">
						  <span class="input-group-btn">
							<button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Buscar</button>
						  </span>
						</div>
					  </div>
				</div>

				<div class="col-sm-2" align="right" style="font-size: 16px;">
					8: <b>Sound.csv</b>
				</div>
				<div class="col-sm-4" align="left">
					<div class="form-group">
						<input type="file" name="Sound" id="Sound" class="file">
						<div class="input-group">
						  <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
						  <input type="text" id="text_Sound" name="text_Sound" class="form-control input-lg" disabled="disabled" placeholder="Buscar Sound.csv ...">
						  <span class="input-group-btn">
							<button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Buscar</button>
						  </span>
						</div>
					  </div>
				</div>
				
			</div>

			<div class="row">
				
				<div class="col-sm-2" align="right" style="font-size: 16px;">
					9: <b>Networking.csv</b>
				</div>
				<div class="col-sm-4" align="left">
					<div class="form-group">
						<input type="file" name="Networking" id="Networking" class="file">
						<div class="input-group">
						  <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
						  <input type="text" id="text_Networking" name="text_Networking" class="form-control input-lg" disabled="disabled" placeholder="Buscar Networking.csv ...">
						  <span class="input-group-btn">
							<button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Buscar</button>
						  </span>
						</div>
					  </div>
				</div>

				<div class="col-sm-2" align="right" style="font-size: 16px;">
					10: <b>Video.csv</b>
				</div>
				<div class="col-sm-4" align="left">
					<div class="form-group">
						<input type="file" name="Video" id="Video" class="file">
						<div class="input-group">
						  <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
						  <input type="text" id="text_Video" name="text_Video" class="form-control input-lg" disabled="disabled" placeholder="Buscar Video.csv ...">
						  <span class="input-group-btn">
							<button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Buscar</button>
						  </span>
						</div>
					  </div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-2" align="right" style="font-size: 16px;">
					11: <b>OS.csv</b>
				</div>
				<div class="col-sm-4" align="left">
					<div class="form-group">
						<input type="file" name="OS" id="OS" class="file">
						<div class="input-group">
						  <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
						  <input type="text" id="text_OS" name="text_OS" class="form-control input-lg" disabled="disabled" placeholder="Buscar OS.csv ...">
						  <span class="input-group-btn">
							<button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Buscar</button>
						  </span>
						</div>
					  </div>
				</div>
			</div>

			<div class="row">
				<br/>
				<div class="col-sm-12" align="center">
					<button type="button" class="btn btn-success btn-lg" onclick="javascript:uploadFiles();"
					 data-toggle="tooltip" data-placement="bottom" title="PRIMERO Adjunte TODOS los Archivos, luego pulsar ESTE BOTÓN">
					   &nbsp;&nbsp;&nbsp;
					   <span class="glyphicon glyphicon-floppy-open"></span> Subir y Procesar Archivos .CSV 
					   &nbsp;&nbsp;&nbsp; 
					</button>
				</div>
			</div>
			<div class="row">
				<br/>
				<hr/>
				<br/>
				<div class="col-sm-12" align="center">
					<b>SEGUNDA OPCI&Oacute;N:</b>
					<i>Ingreso manual de la informaci&oacute;n del Equipo</i>.
					Pulsando aqu&iacute;, se le llevar&aacute; a un Formulario
					donde debe indicar los datos m&aacute;s relevantes de ESTE Equipo...
					<br/><br/>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6" align="center">
					<button type="button" class="btn btn-danger btn-lg" onclick="javascript:manualForm();"
					 data-toggle="tooltip" data-placement="bottom" title="SOLO EN CASO de que NO pueda generar los SCRIPTS con el programa propiedad de LanuzaGroup&reg;">
					   <span class="glyphicon glyphicon-edit"></span> Levantamiento manual de informaci&oacute;n
					</button>
				</div>
				<div class="col-sm-6" align="center">
					<u><b>NOTA:</b></u>
					 use esta opci&oacute;n SOLO EN CASO de que NO pueda generar los SCRIPTS con el programa propiedad de LanuzaGroup&reg; destinado para ello
					 (o cualquier otro inconveniente que impida la correcta generaci&oacute;n de los <b>archivos .CSV</b>).
				</div>
			</div>
			<hr/>
		</form>
	</div>

<script>
	function uploadFiles(){

		var bool = true;
		var message = "";

		limpiarEstilos();

		/* Nombre de los Archivos */
		var cpu 		= document.getElementById("CPU");
		var motherboard = document.getElementById("Motherboard");
		var ram 		= document.getElementById("RAM");
		var localUsers  = document.getElementById("LocalUsers");
		var sound 		= document.getElementById("Sound");
		var video  		= document.getElementById("Video");
		var os 			= document.getElementById("OS");
		var hard_drives	= document.getElementById("Hard_drives");
		var smart		= document.getElementById("SMART");
		var networking	= document.getElementById("Networking");
		var software	= document.getElementById("Software");

		
		/*
		 * NiNGUN archivo puede ser Vacío
		 */
		if( cpu.files.length == 0 ){
			bool = errorIn("text_CPU");
			message += "\n CPU.csv no adjuntado";

		} else if ( !cpu.value.endsWith("CPU.csv") ) {
			bool = errorIn("text_CPU");
			message += "\n El Archivo 1: debe ser OBLIGATORIAMENTE CPU.csv";

		}
		/**/
		if( ram.files.length == 0 ){
			bool = errorIn("text_RAM");
			message += "\n RAM.csv no adjuntado";

		} else if ( !ram.value.endsWith("RAM.csv") ) {
			bool = errorIn("text_RAM");
			message += "\n El Archivo 2: debe ser OBLIGATORIAMENTE RAM.csv";
			
		}
		/**/
		if( hard_drives.files.length == 0 ){
			bool = errorIn("text_Hard_drives");
			message += "\n Hard drives.csv no adjuntado";

		} else if ( !hard_drives.value.endsWith("Hard drives.csv") ) {
			bool = errorIn("text_Hard_drives");
			message += "\n El Archivo 3: debe ser OBLIGATORIAMENTE Hard drives.csv";
			
		}
		
		/**/
		if( localUsers.files.length == 0 ){
			bool = errorIn("text_LocalUsers");
			message += "\n LocalUsers.csv no adjuntado";

		} else if ( !localUsers.value.endsWith("LocalUsers.csv") ) {
			bool = errorIn("text_LocalUsers");
			message += "\n El Archivo 5: debe ser OBLIGATORIAMENTE LocalUsers.csv";
			
		}
		
		/**/
		if( software.files.length == 0 ){
			bool = errorIn("text_Software");
			message += "\n Software.csv no adjuntado";

		} else if ( !software.value.endsWith("Software.csv") ) {
			bool = errorIn("text_Software");
			message += "\n El Archivo 6: debe ser OBLIGATORIAMENTE Software.csv";
			
		}

		/**/
		if( motherboard.files.length == 0 ){
			bool = errorIn("text_Motherboard");
			message += "\n Motherboard.csv no adjuntado";

		} else if ( !motherboard.value.endsWith("Motherboard.csv") ) {
			bool = errorIn("text_Motherboard");
			message += "\n El Archivo 7: debe ser OBLIGATORIAMENTE Motherboard.csv";
			
		}
		/**/
		if( sound.files.length == 0 ){
			bool = errorIn("text_Sound");
			message += "\n Sound.csv no adjuntado";

		} else if ( !sound.value.endsWith("Sound.csv") ) {
			bool = errorIn("text_Sound");
			message += "\n El Archivo 8: debe ser OBLIGATORIAMENTE Sound.csv";
			
		}
		/**/
		if( networking.files.length == 0 ){
			bool = errorIn("text_Networking");
			message += "\n Networking.csv no adjuntado";

		} else if ( !networking.value.endsWith("Networking.csv") ) {
			bool = errorIn("text_Networking");
			message += "\n El Archivo 9: debe ser OBLIGATORIAMENTE Networking.csv";
			
		}
		/**/
		if( video.files.length == 0 ){
			bool = errorIn("text_Video");
			message += "\n Video.csv no adjuntado";

		} else if ( !video.value.endsWith("Video.csv") ) {
			bool = errorIn("text_Video");
			message += "\n El Archivo 10: debe ser OBLIGATORIAMENTE Video.csv";
			
		}
		/**/
		if( os.files.length == 0 ){
			bool = errorIn("text_OS");
			message += "\n OS.csv no adjuntado";

		} else if ( !os.value.endsWith("OS.csv") ) {
			bool = errorIn("text_OS");
			message += "\n El Archivo 11: debe ser OBLIGATORIAMENTE OS.csv";
			
		}
		/**/
		if ( smart.files.length != 0 && !smart.value.endsWith("SMART.csv") ) {
			bool = errorIn("text_SMART");
			message += "\n El Archivo 4: debe ser OBLIGATORIAMENTE SMART.csv";
		}
		

		if ( bool == true ){
			var bool2 = false;
			/*
			 * El archivo SMART puede que NO se genere, entonces esta info NO es obligatoria
			 */
			if( smart.files.length == 0 ){
			
				var ask = confirm("\n Archivo SMART.csv NO adjuntado."
					+ "\n\n\n ¿Desea continuar?");
				if ( ask == true) {
					bool2 = true;
				} else {
					bool2 = false;
				}
			} else {
				bool2 = true;
			}

			if ( bool2 == true ){
				/* ventana de espera... */
				$('#myModal').modal('show');

				/* After 1 second, submit */
				setTimeout(function(){ 
					document.getElementById("files_inventario").submit();
				}, (1 * 1000) );
			}

		} else {
			alert( "NO se pudo realizar el envío de los Archivos. Errores: \n" + message );
		}
	}

	function limpiarEstilos(){
		var blanco = "#FFF";
		document.getElementById("text_CPU").style.backgroundColor = blanco;
		document.getElementById("text_RAM").style.backgroundColor = blanco;
		document.getElementById("text_Hard_drives").style.backgroundColor = blanco;
		document.getElementById("text_SMART").style.backgroundColor = blanco;
		document.getElementById("text_LocalUsers").style.backgroundColor = blanco;
		document.getElementById("text_Software").style.backgroundColor = blanco;
		document.getElementById("text_Sound").style.backgroundColor = blanco;
		document.getElementById("text_Motherboard").style.backgroundColor = blanco;
		document.getElementById("text_Networking").style.backgroundColor = blanco;
		document.getElementById("text_Video").style.backgroundColor = blanco;
		document.getElementById("text_OS").style.backgroundColor = blanco;
	}
	
	function errorIn(textFieldId){
		document.getElementById(textFieldId).style.backgroundColor = "#ffb3b3";
		return false;
	}

</script>

<!-- =======================   FORMULARIO MANUAL EN CASO DE NO USAR EL SCRIPT   ========================== -->
<form data-toggle="validator" role="form" id="manual_inventario" method="post"
 enctype="multipart/form-data" action="<?= PROJECTURLMENU ?>tecnicos/inventario_manual">

	<input type="hidden" id="newEquipoId" 		 name="newEquipoId" 		value="<?= $newEquipo["id"]; ?>" />
	<input type="hidden" id="newEquipoCodBarras" name="newEquipoCodBarras"  value="<?= $newEquipo["codigoBarras"]; ?>" />
	<input type="hidden" id="infoEmpresaUsuario" name="infoEmpresaUsuario"  value="" />
</form>

<script>
	function manualForm(){

		var ask = confirm("\n Usando esta opción deberá recopilar información manualmente por diversos medios,"
				+ " entre ellos el Panel de Control, Crystal Info, entre otros."
				+ "\n\n\n ¿Desea continuar?");
		if ( ask == true) {
			$("#infoEmpresaUsuario").val( generalInfo );
			document.getElementById("manual_inventario").submit();			
		}
		
	}
</script>
<!-- ===================================================================================================== -->


<?php
	} /* else ($newEquipo != NULL ) */
?>
<div class="row">
	<br/><br/>
	<div class="col-sm-12" align="center" style="background-color:#F9B233;">
		Tip: <h4>* Procure NO darle F5 ( Refresh / Refrescar ) a esta p&aacute;gina; 
		ya que crear&iacute;a otro Equipo para este mismo Usuario o Empresa.</h4>
	</div>
</div>
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog modal-sm">
	  <div class="modal-content">
		<div class="modal-header">
		  <!-- button type="button" class="close" data-dismiss="modal">&times;</button -->
		  <h4 class="modal-title" align="center">
			<span class="glyphicon glyphicon-level-up"></span> 
			Subiendo y Procesando Archivos...
		  </h4>
		</div>

		<div class="modal-body" align="center">
		  <p><div id="feedback"><img src="<?= APPIMAGEPATH; ?>waiting.gif" alt="waiting" class="img-responsive" width="100" height="100"></div></p>
		</div>

		<div class="modal-footer">
		  <!-- button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button -->
		</div>
	  </div>
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
	$aux = $newEquipo["codigoBarras"];
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