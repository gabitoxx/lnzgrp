<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-blackboard logo slideanim"></span>
	<i>Inventario: completar info con el Script (archivos <b>.csv</b> generados) </i>&nbsp;&nbsp;&nbsp;
</h4>

<div class="container">

	
	<div class="row" style="background-color:#F9B233;">
		<div class="col-sm-10" align="left">
			<?= "<b>Empresa:</b> " . $companyInfo; ?>
		</div>
		<div class="col-sm-2">
			<a href="<?= PROJECTURLMENU; ?>admin/actualizar_inventario">No actualizar este Equipo</a>
		</div>
	</div>
	

	<div class="row" style="background-color:#F9B233;">
		<div class="col-sm-8" align="left">
			<b>Usuario:</b>
			<?= $usuario; ?>
		</div>
		<div class="col-sm-3" align="right">
			<span class="glyphicon glyphicon-thumbs-up"></span> 
			<b>ID en Sistema:</b>
		</div>
		<div class="col-sm-1" align="left">
			 <?= $equipoId; ?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12" align="left">
			<br/>
			<h6>Para realizar la 
				<b><span class="glyphicon glyphicon-blackboard"></span> Actualizaci&oacute;n de Inventario</b> 
				debe primero correr el <b>Script</b> propiedad de <i>Lanuza Group</i> para este fin. 
				<u>Si NO sabe c&oacute;mo hacerlo, por favor consulte los Tutoriales en la secci&oacute;n del 
				<b>Men&uacute; "Ayuda"</b></u>.
				<br/><br/>
				Como es una actualizaci&oacute;n, usted puede elegir actualizar la info con <b>UNO, VARIOS 
				o con TODOS los Scripts</b>, simplemente seleccione la casilla indicando
				qu&eacute; Scripts actualizar&aacute;, seleccione los archivos 
				y pulsa el bot&oacute;n <b>Actualizar Equipo</b>.
			</h6>
		</div>
	</div>

	<br/>
	<form data-toggle="validator" role="form" id="files_inventario" method="post"
	 enctype="multipart/form-data" action="<?= PROJECTURLMENU ?>admin/inventario_actualizar_archivos">

		<input type="hidden" id="equipoId" 	   name="equipoId" 	   value="<?= $equipoId; ?>" />
		<input type="hidden" id="equipoInfoId" name="equipoInfoId" value="<?= $equipoInfoId; ?>" />
		<input type="hidden" id="filesChosen"  name="filesChosen"  value="" />

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
				A continuaci&oacute;n seleccione las casillas de los archivos con extensi&oacute;n
				<b>".csv"</b> que desea actualizar, adjunte los archivos seg&uacute;n lo solicita:
			</div>
		</div>

		<br/>
		<div class="row">
			<div class="col-sm-12" align="center">
				<button type="button" class="btn btn-danger" onclick="javascript:toogleAll();">
					<i class="glyphicon glyphicon-ok-circle"></i> Marcar / Desmarcar todas las casillas</button>
			</div>
		</div>

		<br/>
		<div class="row">

			<div class="col-sm-2" align="left" style="font-size: 16px;">
				1: 
				<input type="checkbox" name="csv" id="csv" value="CPU" onclick="javascript:pressed=true;"> 
				<b>CPU.csv</b>
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

			<div class="col-sm-2" align="left" style="font-size: 16px;">
				2:
				<input type="checkbox" name="csv" id="csv" value="RAM" onclick="javascript:pressed=true;"> 
				<b>RAM.csv</b>
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

			<div class="col-sm-2" align="left" style="font-size: 16px;">
				3:
				<input type="checkbox" name="csv" id="csv" value="Hard_drives" onclick="javascript:pressed=true;"> 
				<b>Hard drives.csv</b>
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

			<div class="col-sm-2" align="left" style="font-size: 16px;">
				4:
				<input type="checkbox" name="csv" id="csv" value="SMART" onclick="javascript:pressed=true;"> 
				<b>SMART.csv</b>
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
			
			<div class="col-sm-2" align="left" style="font-size: 16px;">
				5: 
				<input type="checkbox" name="csv" id="csv" value="LocalUsers" onclick="javascript:pressed=true;"> 
				<b>LocalUsers.csv</b>
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

			<div class="col-sm-2" align="left" style="font-size: 16px;">
				6: 
				<input type="checkbox" name="csv" id="csv" value="Software" onclick="javascript:pressed=true;"> 
				<b>Software.csv</b>
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
			
			<div class="col-sm-2" align="left" style="font-size: 16px;">
				7: 
				<input type="checkbox" name="csv" id="csv" value="Motherboard" onclick="javascript:pressed=true;"> 
				<b>Motherboard.csv</b>
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

			<div class="col-sm-2" align="left" style="font-size: 16px;">
				8: 
				<input type="checkbox" name="csv" id="csv" value="Sound" onclick="javascript:pressed=true;"> 
				<b>Sound.csv</b>
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
			
			<div class="col-sm-2" align="left" style="font-size: 16px;">
				9: 
				<input type="checkbox" name="csv" id="csv" value="Networking" onclick="javascript:pressed=true;"> 
				<b>Networking.csv</b>
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

			<div class="col-sm-2" align="left" style="font-size: 16px;">
				10: 
				<input type="checkbox" name="csv" id="csv" value="Video" onclick="javascript:pressed=true;"> 
				<b>Video.csv</b>
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
			<div class="col-sm-2" align="left" style="font-size: 16px;">
				11: 
				<input type="checkbox" name="csv" id="csv" value="OS" onclick="javascript:pressed=true;"> 
				<b>OS.csv</b>
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
				   <span class="glyphicon glyphicon-floppy-open"></span> Subir y Procesar Archivos</button>
			</div>
		</div>
	</form>
</div>

<script>
	function showSelectedValues(){
		return $("input[name=csv]:checked").map(
			function () {return this.value;}).get().join(",");
	}

	var pressed = false;

	function uploadFiles(){

		if ( pressed == false ){
			alert("Si desea actualizar el Inventario debe subir al menos 1 archivo .csv");
			return false;
		}

		/*
		 * dejando todos los valores en un string - luego pasandolos a un arreglo
		 */
		var checkValues = "" + showSelectedValues();

		var array = checkValues.split(",");

		var bCPU = false;
		var bMB  = false;
		var bRAM = false;
		var bLU  = false;
		var bSo  = false;
		var bVi  = false;
		var bOS  = false;
		var bHD  = false;
		var bSm  = false;
		var bNet = false;
		var bSof = false;

		/* buscando qué variables selecciono el tecnico */
		var aux = "";
		for ( var i = 0; i < array.length; i++ ){

			aux = array[i];

			if ( aux == "CPU" )					bCPU = true;
			else if ( aux == "Motherboard" )	bMB  = true;
			else if ( aux == "RAM" )			bRAM = true;
			else if ( aux == "LocalUsers" )		bLU  = true;
			else if ( aux == "Sound" )			bSo  = true;
			else if ( aux == "Video" )			bVi  = true;
			else if ( aux == "OS" )				bOS  = true;
			else if ( aux == "Hard_drives" )	bHD  = true;
			else if ( aux == "SMART" )			bSm  = true;
			else if ( aux == "Networking" )		bNet = true;
			else if ( aux == "Software" )		bSof = true;
		}

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
		 * NiNGUN archivo puede ser Vacío si esta seleccionado
		 */
		if ( bCPU ) {
			if( cpu.files.length == 0 ){
				bool = errorIn("text_CPU");
				message += "\n CPU.csv no adjuntado";

			} else if ( !cpu.value.endsWith("CPU.csv") ) {
				bool = errorIn("text_CPU");
				message += "\n El Archivo 1: debe ser OBLIGATORIAMENTE CPU.csv";

			}
		}
		/**/
		if ( bRAM ) {
			if( ram.files.length == 0 ){
				bool = errorIn("text_RAM");
				message += "\n RAM.csv no adjuntado";

			} else if ( !ram.value.endsWith("RAM.csv") ) {
				bool = errorIn("text_RAM");
				message += "\n El Archivo 2: debe ser OBLIGATORIAMENTE RAM.csv";
				
			}
		}
		/**/
		if ( bHD ) {
			if( hard_drives.files.length == 0 ){
				bool = errorIn("text_Hard_drives");
				message += "\n Hard drives.csv no adjuntado";

			} else if ( !hard_drives.value.endsWith("Hard drives.csv") ) {
				bool = errorIn("text_Hard_drives");
				message += "\n El Archivo 3: debe ser OBLIGATORIAMENTE Hard drives.csv";
				
			}
		}
		/**/
		if ( bSm ) {
			if( smart.files.length == 0 ){
				bool = errorIn("text_SMART");
				message += "\n SMART.csv no adjuntado";

			} else if ( !smart.value.endsWith("SMART.csv") ) {
				bool = errorIn("text_SMART");
				message += "\n El Archivo 4: debe ser OBLIGATORIAMENTE SMART.csv";
				
			}
		}
		/**/
		if ( bLU ) {
			if( localUsers.files.length == 0 ){
				bool = errorIn("text_LocalUsers");
				message += "\n LocalUsers.csv no adjuntado";

			} else if ( !localUsers.value.endsWith("LocalUsers.csv") ) {
				bool = errorIn("text_LocalUsers");
				message += "\n El Archivo 5: debe ser OBLIGATORIAMENTE LocalUsers.csv";
				
			}
		}
		/**/
		if ( bSof ) {
			if( software.files.length == 0 ){
				bool = errorIn("text_Software");
				message += "\n Software.csv no adjuntado";

			} else if ( !software.value.endsWith("Software.csv") ) {
				bool = errorIn("text_Software");
				message += "\n El Archivo 6: debe ser OBLIGATORIAMENTE Software.csv";
				
			}
		}
		/**/
		if ( bMB ) {
			if( motherboard.files.length == 0 ){
				bool = errorIn("text_Motherboard");
				message += "\n Motherboard.csv no adjuntado";

			} else if ( !motherboard.value.endsWith("Motherboard.csv") ) {
				bool = errorIn("text_Motherboard");
				message += "\n El Archivo 7: debe ser OBLIGATORIAMENTE Motherboard.csv";
				
			}
		}
		/**/
		if ( bSo ) {
			if( sound.files.length == 0 ){
				bool = errorIn("text_Sound");
				message += "\n Sound.csv no adjuntado";

			} else if ( !sound.value.endsWith("Sound.csv") ) {
				bool = errorIn("text_Sound");
				message += "\n El Archivo 8: debe ser OBLIGATORIAMENTE Sound.csv";
				
			}
		}
		/**/
		if ( bNet ) {
			if( networking.files.length == 0 ){
				bool = errorIn("text_Networking");
				message += "\n Networking.csv no adjuntado";

			} else if ( !networking.value.endsWith("Networking.csv") ) {
				bool = errorIn("text_Networking");
				message += "\n El Archivo 9: debe ser OBLIGATORIAMENTE Networking.csv";
			}
		}
		/**/
		if ( bVi ) {
			if( video.files.length == 0 ){
				bool = errorIn("text_Video");
				message += "\n Video.csv no adjuntado";

			} else if ( !video.value.endsWith("Video.csv") ) {
				bool = errorIn("text_Video");
				message += "\n El Archivo 10: debe ser OBLIGATORIAMENTE Video.csv";
			}
		}
		/**/
		if ( bOS ) {
			if( os.files.length == 0 ){
				bool = errorIn("text_OS");
				message += "\n OS.csv no adjuntado";

			} else if ( !os.value.endsWith("OS.csv") ) {
				bool = errorIn("text_OS");
				message += "\n El Archivo 11: debe ser OBLIGATORIAMENTE OS.csv";
			}
		}

		if ( bool == true && pressed == true ){
			
			var m = "\n\nSe seleccionaron " + (array.length) + " archivos .CSV para actualizar: (" + checkValues + ")";

			if ( array.length < 11 ){
				m += "\n\nNO se seleccionaron los otros " + (11 - array.length) + " archivos"
						+ " por lo que NO se actualizará dicha información NO seleccionada.";
			}

			var ask = confirm("Actualizar la info dejará esta como la más reciente"
					+ " y la antigua solo podrá ser consultada a través de las funcionalidades"
					+ " del modulo de 'Reportes'."
					+ m
					+ "\n\n¿Desea continuar con la actualización?");

			if ( ask == true) {
				/* ventana de espera... */
				$('#myModal').modal('show');

				document.getElementById("filesChosen").value = checkValues;

				/* After 1 second, submit */
				setTimeout(function(){ 
					document.getElementById("files_inventario").submit();
				}, (1 * 1000) );
			
			} else {
				return false;
			}
		} else {
			alert( "NO se pudo realizar el envío de los Archivos. Errores: \n" + message );
			return false;
		}
	}

	function limpiarEstilos(){
		var blanco = "#FFF";
		document.getElementById("text_CPU").style.backgroundColor        = blanco;
		document.getElementById("text_RAM").style.backgroundColor        = blanco;
		document.getElementById("text_Hard_drives").style.backgroundColor= blanco;
		document.getElementById("text_SMART").style.backgroundColor      = blanco;
		document.getElementById("text_LocalUsers").style.backgroundColor = blanco;
		document.getElementById("text_Software").style.backgroundColor   = blanco;
		document.getElementById("text_Sound").style.backgroundColor      = blanco;
		document.getElementById("text_Motherboard").style.backgroundColor= blanco;
		document.getElementById("text_Networking").style.backgroundColor = blanco;
		document.getElementById("text_Video").style.backgroundColor      = blanco;
		document.getElementById("text_OS").style.backgroundColor         = blanco;
	}
	
	function errorIn(textFieldId){
		document.getElementById(textFieldId).style.backgroundColor = "#ffb3b3";
		return false;
	}

	var bPressed = false;
	function toogleAll(){
		if ( bPressed == false ){
			bPressed = true;
			$('input[name=csv]').prop('checked', true);

		} else {
			bPressed = false;
			$('input[name=csv]').prop('checked', false);
		}
	}
</script>
	

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