
<script src="<?= APPJSPATH; ?>jspdf.js?version=2"></script>
<script src="<?= APPJSPATH; ?>pdfFromHTML.js?version=2"></script>

<style>
	#imgX {
		width: 400px;
		height: 400px;
	}
	hr { 
		display: block;
		margin-top: 0.5em;
		margin-bottom: 0.5em;
		margin-left: auto;
		margin-right: auto;
		border-style: inset;
		border-width: 1px;
	}

	.slide {
		animation-name: slide;
		-webkit-animation-name: slide;
		animation-duration: 1s;
		-webkit-animation-duration: 1s;
		visibility: visible;
	}
	@keyframes slide {
		0% {
			opacity: 0;
			transform: translateY(70%);
		} 
		100% {
			opacity: 1;
			transform: translateY(0%);
		}
	}
	@-webkit-keyframes slide {
		0% {
			opacity: 0;
			-webkit-transform: translateY(70%);
		} 
		100% {
			opacity: 1;
			-webkit-transform: translateY(0%);
		}
	}
	a.back-to-top {
		display: block;
		width: 60px;
		height: 60px;
		text-indent: -9999px;
		position: fixed;
		z-index: 999;
		right: 20px;
		bottom: 20px;
		background: #3C763D url("<?= APPIMAGEPATH; ?>up-arrow.png") no-repeat center 43%;
		-webkit-border-radius: 30px;
		-moz-border-radius: 30px;
		border-radius: 30px;
	}
	a:hover.back-to-top {
		background-color: #E30513;
	}
</style>

<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-blackboard logo slideanim"></span>
	<i>Informaci&oacute;n detallada del Equipo</i>&nbsp;&nbsp;&nbsp;
</h4>

<?php  
	if ( isset($errorMessage) ){
?>
<div class="row">
	<div class="col-sm-12" align="center">
		Hubo un inconveniente al recuperar informaci&oacute;n del Equipo:
		<br/>
		<h4 style="color:#E30513;">Causa del Error:</h4> 
		<?= $errorMessage; ?>
		<br/><br/>
		Por favor, intente m&aacute;s tarde. Si el error persite, puede comunicarse con Soporte TI
		de LanuzaGroup al correo: <?= CONTACTEMAIL1; ?>.
	</div>
</div>
<?php 
	}
	if ( isset($no_errorMessage) ){
?>
<div id="HTMLtoPDF" class="page-body">

<div class="row">
	<div class="col-sm-12" align="center" style="font-size: 16px;">
		<?php
			if ( isset($linkedImagen) && $linkedImagen != NULL && $linkedImagen != "" ) {
				/*
				 * Imagen Real del Equipo (Foto)
				 */
				echo '<img id="imgX" alt="' . $tipoEquipo . '" src="' . $linkedImagen . '" />';

			} else {
				/*
				 * Imagenes referenciales
				 */
				echo "* ";

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
			}
		?>
		<br/>
		<?= "<b>" . $tipoEquipo . "</b>"; ?>
		<br/>
		<?= "C&oacute;digo Barras: " . $codigoBarras; ?>
		<br/>
		<?= "Sistema Operativo: <b>" . $os[0]["Caption"] . "</b>"; ?>
		<br/>
<?php
		if ( trim( $os[0]["Workgroup"] ) == "WORKGROUP" ){
			echo "Grupo de Trabajo: " . $os[0]["CSName"] . "<br/>";

		} else if ( trim( $os[0]["Workgroup"] ) == "HOMEGROUP" ){
			echo "Grupo de Casa: " . $os[0]["CSName"] . "<br/>";
		}
?>
		<br/>
		<span style="font-size: 12px;">* Imagen referencial, NO es la Foto real del Equipo.</span>
	</div>
</div>

<br/>
<hr/>
<div class="row well well-lg">
	<div class="col-sm-2" align="right">
		<img alt="CPU" src="<?= APPIMAGEPATH . 'cpu.jpg'; ?>" style="width: 200px; height: 100px;" />
	</div>
	<div class="col-sm-4" style="margin-left: 5px;">
		<b style="font-size: 20px;"> CPU</b>
		<br/>
		<?= $cpu[0]["Name"]; ?>
		<br/>
		M&aacute;quina de <b><?= $cpu[0]["AddressWidth"]; ?></b> bits
		<br/>
		N&uacute;mero de N&uacute;cleos: <b><?= $cpu[0]["NumberOfCores"]; ?></b>
		<br/>
		Velocidad del procesador: <?= $cpu[0]["CurrentClockSpeed"]; ?>
		<br/>
		Tama&ntilde;os de las Cach&eacute;s:
		<br/>
		L1 = <?= $cpu[0]["L2CacheSize"]; ?>; L2 = <?= $cpu[0]["L3CacheSize"]; ?>
		<?= "<br/>---<br/><i>[ Info actualizada al " . $cpu[0]["fechaUltimaActualizacion"] . " ]</i> <br/>---<br/>"; ?>

	</div>


	<div class="col-sm-2" align="right" style="margin-left: -5px;">
		<img alt="CPU" src="<?= APPIMAGEPATH . 'motherboard.png'; ?>" style="width: 200px; height: 100px;" />
	</div>
	<div class="col-sm-4">
		<b style="font-size: 20px;"> Tarjeta Madre</b>
		<br/>
		<?= $motherboard[0]["Name"]; ?>
		<br/>
		<b><?= $motherboard[0]["Product"]; ?></b>
		<br/>
		<?php if ( $motherboard[0]["Version"] != 0 ) { ?>
			Versi&oacute;n: <?= $motherboard[0]["Version"]; ?>
			<br/>
		<?php } ?>
		N&uacute;mero de Serial: 
<?php 
			if( strpos( $motherboard[0]["SerialNumber"], 'E+' ) !== false ){
				/* Notacion Cientifica */
				$a = sprintf('%f', $motherboard[0]["SerialNumber"]);
				echo str_replace('.', '', $a);
			} else {
				/* impresion normal */
				echo $motherboard[0]["SerialNumber"];
			}

			echo "<br/>---<br/><i>[ Info actualizada al " . $motherboard[0]["fechaUltimaActualizacion"] . " ]</i> <br/>";
			echo "---<br/>";
?>
	</div>
</div>

<br/>
<hr/>
<div class="row well well-lg">
	<div class="col-sm-2">
		<img alt="CPU" src="<?= APPIMAGEPATH . 'ram.jpg'; ?>" style="width: 200px; height: 100px;" />
	</div>
	<div class="col-sm-4" style="margin-left: 5px;">
		<b style="font-size: 20px;"> Memoria RAM</b>
		<br/>
		Cantidad de Bancos de Memoria disponibles:
<?php
			$cont=0;
			foreach ($ram as $iRAM) {
				$cont++;
			}
			echo "<b>" . $cont . "</b>";
?>
			<br/>
			<i>Info de cada banco de Memoria:</i>
			<br/>---<br/>

<?php
			$cont=0;
			$fecha = "";
			foreach ($ram as $iRAM) {
				echo "<b>Banco de Memoria Nº " . ($cont + 1) . "</b><br/>";

				echo $iRAM["BankLabel"] . "  - Capacidad: <b>" 
						. ( number_format( ($iRAM["Capacity"] / 1000000000), 2, '.', '') ) . " Gigabytes</b> <br/>";

				echo "Tipo de Memoria: " . $iRAM["MemoryType"] . "  - Velocidad: " . $iRAM["ConfiguredClockSpeed"] . "<br/>";

				$fecha = "---<br/><i>[ Info actualizada al " . $iRAM["fechaUltimaActualizacion"] . " ]</i> <br/>---<br/>";

				echo "---<br/>";
				$cont++;
			}

			echo $fecha;
?>
		<br/>
	</div>

	<div class="col-sm-2" align="right" style="margin-left: -5px;">
		<img alt="CPU" src="<?= APPIMAGEPATH . 'users.png'; ?>" style="width: 150px; height: 150px;" />
	</div>
	<div class="col-sm-4">
		<b style="font-size: 20px;"> Usuarios Locales</b>
		<br/>
		Cantidad de Usuarios:
<?php
			$cont=0;
			foreach ($users as $user) {
				$cont++;
			}
			echo "<b>" . $cont . "</b>";
?>
			<br/>
			<i>Info de cada Usuario:</i>
			<br/>---<br/>

<?php
			$cont=0;
			foreach ($users as $user) {
				echo "<b>Usuario Nº " . ($cont + 1) . "</b><br/>";

				echo '<b>"' . trim( $user["Cuenta"] ) . '"</b>';

				$a = trim( $user["Tipo"] );
				if ( $a == "Administrators" )	 $a = "Administrador";
				else if ( $a == "Domain Users" ) $a = "Est&aacute;ndar";
				else 							 $a = $user["Tipo"];

				echo " - Tipo de usuario: <i>" . $a . "</i><br/>";

				$fecha = "---<br/><i>[ Info actualizada al " . $user["fechaUltimaActualizacion"] . " ]</i> <br/>---<br/>";

				echo "---<br/>";
				$cont++;
			}

			echo $fecha;
			
?>
		<br/>
	</div>
</div>

<br/>
<hr/>
<div class="row well well-lg">
	<div class="col-sm-2">
		<img alt="CPU" src="<?= APPIMAGEPATH . 'partitions.png'; ?>" style="width: 200px; height: 200px;" />
	</div>
	<div class="col-sm-4" style="margin-left: 5px;">
		<b style="font-size: 20px;"> Particiones l&oacute;gicas</b>
		<br/>
		Cantidad de Particiones:
<?php
			$cont=0;
			foreach ($hardDrives as $partition) {
				$a = trim( $partition["DriveLetter"] );
				if ( $a != NULL && $a != "" ){
					$cont++;
				}
			}
			echo "<b>" . $cont . "</b>";
?>
			<br/>
			<i>Info de cada Partición:</i>
			<br/>---<br/>

<?php
			$cont=0;
			foreach ($hardDrives as $partition) {
				$a = trim( $partition["DriveLetter"] );
				$isLocalDisk = false;

				if ( $a != NULL && $a != "" ){

					$b = trim( $partition["DriveType"] );
					if ( $b == "Local Disk" ){
						$b = "Partici&oacute;n";
						$isLocalDisk = true;

					} else if ( $b == "Removable Disk" ){
						$b = "Disco Externo";
						$isLocalDisk = false;

					} else if ( $b == "Compact Disk" ){
						$b = "Unidad de CD";
						$isLocalDisk = false;
					}

					echo $b . " <b>" . $a . "</b><br/>";

					if ( $isLocalDisk ){
						echo "Sistema de Archivos: " . $partition["FileSystem"] . "<br/>";
	
						echo "Capacidad: <b>" . ( number_format( ($partition["Capacity"] / 1000000000), 2, '.', '') ) . "</b> Gb";
	
						echo " - Espacio libre: <b>" . ( number_format( ($partition["FreeSpace"] / 1000000000), 2, '.', '') ) . "</b> Gb<br/>";
					}

					$fecha = "---<br/><i>[ Info actualizada al " . $partition["fechaUltimaActualizacion"] . " ]</i> <br/>---<br/>";

					echo "---<br/>";
					$cont++;
				}
			}

			echo $fecha;
?>
		<br/>
	</div>

	<div class="col-sm-2" align="right" style="margin-left: -5px;">
		<img alt="CPU" src="<?= APPIMAGEPATH . 'HardDrive.png'; ?>" style="width: 200px; height: 150px;" />
	</div>
	<div class="col-sm-4">
		<b style="font-size: 20px;"> Discos Duros</b>
		<br/>
		Cantidad de Discos Duros F&iacute;sicos:
<?php
			$cont=0;
			foreach ($hardDrives as $hdd) {
				$a = $hdd["DriveLetter"];
				if ( $a == NULL || trim( $a ) == "" ){
					$cont++;
				}
			}
			echo "<b>" . $cont . "</b>";
?>
			<br/>
			<i>Info de cada Disco F&iacute;sico:</i>
			<br/>---<br/>

<?php
			$cont=0;
			foreach ($hardDrives as $hdd) {
				
				$a = $hdd["DriveLetter"];
				if ( $a == NULL || trim( $a ) == "" ){

					echo "Interfaz tipo: <b>" . $hdd["InterfaceType"] . "</b><br/>";

					echo "Modelo: <b>" . $hdd["Model"] . "</b><br/>";

					echo "Serial Nº: <b>";

					$c = $hdd["SerialNumber"];
					if( strpos( $c, 'E+' ) !== false ){
						/* Notacion Cientifica */
						$d = sprintf('%f', $c);
						echo str_replace('.', '', $d);

					} else {
						/* impresion normal */
						echo $c;
					}
					echo "</b><br/>";

					$b = trim( $hdd["Size"] ); 
					if ( $b != NULL && $b != "" ){
						echo "Tama&ntilde;o: <b>" 
								. ( number_format( ($b / 1000000000), 2, '.', '') ) . "</b> Gb<br/>";
					}

					$fecha = "---<br/><i>[ Info actualizada al " . $hdd["fechaUltimaActualizacion"] . " ]</i> <br/>---<br/>";

					echo "---<br/>";
					$cont++;
				}
			}

			echo $fecha;
?>
		<br/>
	</div>
</div>


<br/>
<hr/>
<div class="row well well-lg">
	<div class="col-sm-2">
		<img alt="CPU" src="<?= APPIMAGEPATH . 'video_card.jpg'; ?>" style="width: 200px; height: 200px;" />
	</div>
	<div class="col-sm-4" style="margin-left: 5px;">
		<b style="font-size: 20px;"> Tarjeta(s) de Video</b>
		<br/>
		Cantidad de Tarjetas:
<?php
			$cont=0;
			foreach ($video as $vid) {
				$cont++;
			}
			echo "<b>" . $cont . "</b>";
?>
			<br/>
			<i>Info de cada Tarjeta:</i>
			<br/>---<br/>

<?php
			$cont=0;
			foreach ($video as $vid) {
				
				echo "<b>" . $vid["Name"] . "</b><br/>";

				echo "Video Procesador: <b>" . $vid["VideoProcessor"] . "</b><br/>";

				echo "Compatibilidad <b>" . $vid["AdapterCompatibility"] . "</b><br/>";

				echo "Adaptador en RAM <b>" . $vid["AdapterRAM"] . "</b><br/>";

				$fecha = "---<br/><i>[ Info actualizada al " . $vid["fechaUltimaActualizacion"] . " ]</i> <br/>---<br/>";

				echo "---<br/>";
				$cont++;
			}

			echo $fecha;
?>
		<br/>
	</div>

	<div class="col-sm-2" align="right" style="margin-left: -5px;">
		<img alt="CPU" src="<?= APPIMAGEPATH . 'sound_card.png'; ?>" style="width: 200px; height: 150px;" />
	</div>
	<div class="col-sm-4">
		<b style="font-size: 20px;"> Sistema(s) de Sonido</b>
		<br/>
		Cantidad de sistemas:
<?php
			$cont=0;
			foreach ($sound as $sonido) {
				$cont++;
			}
			echo "<b>" . $cont . "</b>";
?>
			<br/>
			<i>Info de cada Disco F&iacute;sico:</i>
			<br/>---<br/>

<?php
			$cont=0;
			foreach ($sound as $sonido) {

				echo "<b>" . $sonido["Caption"] . "</b><br/>";

				echo "Manufacturado por: <b>" . $sonido["Manufacturer"] . "</b><br/>";

				$fecha = "---<br/><i>[ Info actualizada al " . $sonido["fechaUltimaActualizacion"] . " ]</i> <br/>---<br/>";

				echo "---<br/>";
				$cont++;
			}
			
			echo $fecha;
?>
		<br/>
	</div>
</div>

<br/>
<hr/>
<div class="row well well-lg">
	<div class="col-sm-2">
		<img alt="CPU" src="<?= APPIMAGEPATH . 'ethernet.png'; ?>" style="width: 200px; height: 200px;" />
	</div>
	<div class="col-sm-4" style="margin-left: 5px;">
		<b style="font-size: 20px;"> Adaptadores de Red</b>
		<br/>
		Cantidad:
<?php
			$cont=0;
			foreach ($networking as $red) {
				$cont++;
			}
			echo "<b>" . $cont . "</b>";
?>
			<br/>
			<i>Detalle:</i>
			<br/>---<br/>

<?php
			$cont=0;
			foreach ($networking as $red) {
				
				echo "<b>" . $red["Adapter"] . "</b><br/>";

				echo "Tipo de Adaptador: <b>" . $red["AdapterType"] . "</b><br/>";

				$a = $red["DCHPEnabled"];
				if ( $a == "TRUE" || $a == "true" )			$b = "S&iacute;";
				else if ( $a == "FALSE" || $a == "false" )	$b = "No";
				else if ( $a == "Unknown" )					$b = "Desconocido";
				else 										$b = $a;

				echo "DCHP habiilitado: <b>" . $b . "</b><br/>";

				$c = trim( $red["MAC"] );
				if ( $c != NULL && $c != "" && $c != "0" ){
					echo "Direcci&oacute;n MAC: <b>" . $c . "</b> <br/>";
				
				} else {
					echo "Direcci&oacute;n MAC: <b>Desconocido</b> <br/>";
				}

				$d = trim( $red["IP_1"] );
				if ( $d != NULL && $d != "" && $d != "0" ){
					echo "Direcci&oacute;n IP (1): <b>" . $d . "</b> <br/>";
				
				} else {
					echo "Direcci&oacute;n IP (1): <b>Desconocido</b> <br/>";
				}

				$e = trim( $red["IP_2"] );
				if ( $e != NULL && $e != "" && $e != "0" ){
					echo "Direcci&oacute;n IP (2): <b>" . $e . "</b> <br/>";
				}

				$fecha = "---<br/><i>[ Info actualizada al " . $red["fechaUltimaActualizacion"] . " ]</i> <br/>---<br/>";

				echo "---<br/>";
				$cont++;
			}

			echo $fecha;
?>
		<br/>
	</div>

	<div class="col-sm-2" align="right" style="margin-left: -5px;">
		<img alt="CPU" src="<?= APPIMAGEPATH . 'harddrive1.png'; ?>" style="width: 200px; height: 200px;" />
	</div>
	<div class="col-sm-4">
		<b style="font-size: 20px;"> Monitoreo SMART</b>
		<br/>
		Cantidad de Discos:
<?php
			$cont=0;
			foreach ($smart as $hdd) {
				$cont++;
			}
			echo "<b>" . $cont . "</b>";
?>
			<br/>
			<i>Indicadores por cada Disco:</i>
			<br/>---<br/>

<?php
			$cont=0;
			foreach ($smart as $hdd) {

				echo "Modelo: <b>" . $hdd["Model"] . "</b><br/>";

				echo "Serial Nº: <b>";
				
				$a = $hdd["Serial"];

				if( strpos( $a, 'E+' ) !== false ){
					/* Notacion Cientifica */
					$b = sprintf('%f', $a);
					echo str_replace('.', '', $b);

				} else {
					/* impresion normal */
					echo $a;
				}
				echo  "</b><br/>";

				echo "Cantidad de Sectores Relocalizados: <b>" . $hdd["Reallocated_sector_count"] . "</b><br/>";

				echo "Temperatura en ºC: <b>";

				$f = $hdd["HDD_temperature"];
				if ( $f <= 0 ){
					echo "Desconocida";
				} else {
					/* Conversion de ºF a ºC - formula de Fahrenheit a Centígrados */
					$c = ( (5/9) * ($f - 32) );
					echo ( number_format( ($c), 2, ',', '') );
				}
				echo "</b><br/>";

				if ( $hdd["Power_on_hours_1"] != 0 ){
					echo "Cantidad de Horas encendido #1: <b>" . $hdd["Power_on_hours_1"] . "</b><br/>";
				}

				if ( $hdd["Power_on_hours_2"] != 0 ){
					echo "Cantidad de Horas encendido #2: <b>" . $hdd["Power_on_hours_2"] . "</b><br/>";
				}

				$fecha = "---<br/><i>[ Info actualizada al " . $hdd["fechaUltimaActualizacion"] . " ]</i> <br/>---<br/>";

				echo "---<br/>";
				$cont++;
			}
			
			echo $fecha;
?>
		<br/>
	</div>
</div>

</div>

<br/>
<hr/>

<?php 
	} /* no_errorMessage */

	echo "<script>";
	echo "   var gohome = '" . PROJECTURLMENU . "portal/mis_equipos';" ;
	echo "</script>";
?>

<div class="row">
	<div class="col-sm-4" align="center">
	  <button type="submit" class="btn btn-success btn-lg" onclick="javascript:volverAInventario();"
	   data-toggle="tooltip" data-placement="top" title="Volver a Inventario">
		<span class="glyphicon glyphicon-menu-left"></span> 
		Volver
	  </button>
	</div>

	<div class="col-sm-4" align="center">
	  <button type="submit" class="btn btn-primary btn-lg" onclick="javascript:printPDF();"
	   data-toggle="tooltip" data-placement="top" title="Descargar en formato PDF">
		<span class="glyphicon glyphicon-file"></span> 
		Guardar en PDF
	  </button>
	</div>

	<div class="col-sm-4" align="center">
	  <button type="submit" class="btn btn-danger btn-lg" onclick="javascript:imprimirBrowser();"
	   data-toggle="tooltip" data-placement="top" title="Imprimir a trav&eacute;s de su Navegador Web">
		<span class="glyphicon glyphicon-print"></span> 
		Imprimir
	  </button>
	</div>
</div>
<script>
	function volverAInventario(){
		location.href = gohome;
	}

	function printPDF(){

		HTMLtoPDF();

		alert("Se está descargando automáticamente un archivo PDF con este Reporte."
			+ "\n\n(Puede que el formato visual adaptado a PDF difiera de su navegador y/o tamaño de pantalla)"
			+ "\n\nPresione OK/Aceptar para continuar...");
	}

	function imprimirBrowser(){

		var printContents = document.getElementById("HTMLtoPDF").innerHTML;

		var originalContents = document.body.innerHTML;

		document.body.innerHTML = printContents;

		window.print();

		document.body.innerHTML = originalContents;
	}

	$(document).ready(function(){
		// create the back to top button -- Botón de Volver Arriba
		$('body').prepend('<a href="#HTMLtoPDF" class="back-to-top" data-toggle="tooltip" title="Volver Arriba" onclick="javascript:toTop();">Volver Arriba</a>');
	});

	function toTop(){
		
		$('html, body').delay(500).animate({
			scrollTop: $("#HTMLtoPDF").offset().top
		}, 1000);

		return false;
	}
</script>