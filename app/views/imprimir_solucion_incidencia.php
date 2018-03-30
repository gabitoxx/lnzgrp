<?php    
	if ( !isset($solucion) ){
		die("ERROR al tratar de cargar la Info de la Incidencia. Por favor, Intente màs tarde.");
	}

?>

<html>

<head>
	<title>Reporte de Soluci&oacute;n de la Incidencia Nº: <?= $solucion["incidenciaId"]; ?></title>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<script src="<?= APPJSPATH; ?>jspdf.js?version=2"></script>
	<script src="<?= APPJSPATH; ?>pdfFromHTML.js?version=2"></script>

	<link href="<?= BOOTSTRAPPATH; ?>css/bootstrap.min.css" rel="stylesheet">

	<style>
		hr { 
			display: block;
			margin-top: 0.5em;
			margin-bottom: 0.5em;
			margin-left: auto;
			margin-right: auto;
			border-style: inset;
			border-width: 1px;
		}
		div {
			font-size: 12px;
		}

		@page {
			/* size: 21cm 29.7cm; */
			size: A4;
			margin: 10mm 15mm 10mm 15mm; /* change the margins as you want them to be. */
		}
	</style>

</head>

<body onload="javascript:printThisPage();">

<h4 style="text-align:center; color:#000;">
	Si <b>NO</b> se descarga autom&aacute;ticamente el archivo en .PDF, 
	<a href="#" onclick="javascript:printThisPage();">presione aqu&iacute; para descargar la versi&oacute;n en PDF</a>
</h4>
<br/>
<h6 style="text-align:center; color:#000;">
	Si desea usar el Sistema de Impresi&oacute;n de su Navegador (
		<script>
			document.write(navigator.appName + " " + navigator.appCodeName + " - en sistema: " + navigator.platform);
		</script>
	), 
	<a href="#" onclick="javascript:imprimirBrowser();" class="btn btn-info btn-sm">
		<span class="glyphicon glyphicon-print"></span> presione aqu&iacute;
	</a>
</h6>
<hr/>
<div id="HTMLtoPDF" class="page-body">

	<table border="1" style="width:1654px; background-color:#FFF;">
		<tr>
			<td>
				uno
				Reporte generado en Fecha: <?= date("d/m/Y"); ?> 
				Hora: <?= date("h:i:s A"); ?>
			</td>
			<td>
				 .dos.
				<span style="text-align:center;">
					<i><u>Reporte de Soluci&oacute;n de la Incidencia Nº: <?= $solucion["incidenciaId"]; ?>  </u></i>
				</span>
			</td>
			<td> .tre.
				<img src="<?= APPIMAGEPATH; ?>logo.png" alt="" height="100px" width="350px" />
			</td>
		</tr>
	</table>

	<div class="row">
		<div class="col-sm-offset-1 col-sm-2" style="line-height: 50px; height:100px;">
			<br/>
			<h6>Reporte generado en Fecha: <?= date("d/m/Y"); ?> 
			Hora: <?= date("h:i:s A"); ?></h6>
		</div>
		<div class="col-sm-5" style="vertical-align:middle; height:100px; display: table-cell;">
			<br/>
			<h4 style="text-align:center;">
				<i><u>Reporte de Soluci&oacute;n de la Incidencia Nº: <?= $solucion["incidenciaId"]; ?>  </u></i>
			</h4>
		</div>
		<div class="col-sm-4" align="right">
			<img src="<?= APPIMAGEPATH; ?>logo.png" alt="" height="100px" width="350px" />
		</div>
	</div>
	<br/>
	<div style="border-radius: 15px;border: 1px solid #CCC;padding: 3px;margin-left: 40px;margin-right: 40px;">
		<div class="row">
			<div class="col-sm-offset-1 col-sm-3">
				<b>Nombre de Usuario:</b> <?= $incidenciaInfo[0]["usuario_nombre"] . " " . $incidenciaInfo[0]["usuario_apellido"] ; ?>
			</div>
			<div class="col-sm-4">
				<b>Nombre de Empresa:</b> <?= $incidenciaInfo[0]["nombre_empresa"] ; ?>
			</div>
			<div class="col-sm-3">
				<b>Dependencia:</b> <?= $incidenciaInfo[0]["dependencia"] ; ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-offset-1 col-sm-3">
				<b>Equipo Nº:</b> <?= $incidenciaInfo[0]["barcode"] ; ?> (C&oacute;d. Barras)
			</div>
			<div class="col-sm-5">
				<b>Fecha de Soluci&oacute;n de la Incidencia:</b> <?= $solucion["fecha"]; ?>
			</div>
		</div>
	</div>

	<br/>

	<div class="row">
		<div class="col-sm-12" align="center">
			<b>LABOR QUE DESEMPE&Ntilde;A EL EQUIPO</b>
		</div>
	</div>

	<br/>

	<div class="row">
		<div class="col-sm-offset-1 col-sm-10 well well-lg" align="left">
			<?= $solucion["laborDelEquipo"]; ?>	
		</div>
	</div>

	<br/>

	<div class="row">
		<div class="col-sm-12" align="center">
			<b>OBSERVACIONES Y NOVEDADES</b>
		</div>
	</div>

	<br/>

	<div class="row">
		<div class="col-sm-offset-1 col-sm-10 well well-lg" align="left">
			<b>Variables End&oacute;genas:</b>
			<br/>
			<?= $solucion["variableEndogena"]; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-offset-1 col-sm-10 well well-lg" align="left">
			<b>Variables Ex&oacute;genas T&eacute;cnicas:</b>
			<br/>
			<?= $solucion["variableExogenaTecnica"]; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-offset-1 col-sm-10 well well-lg" align="left">
			<b>Variables Ex&oacute;genas Humanas:</b>
			<br/>
			<?= $solucion["variableExogenaHumana"]; ?>
		</div>
	</div>
	
	<br/>
	
	<div class="row">
		<div class="col-sm-12" align="center">
			<b>REPORTE MANTENIMIENTO DE HARDWARE (Procedimientos a Ejecutar)</b>
		</div>
	</div>

	<br/>

	<div class="row">
		<div class="col-sm-offset-1 col-sm-10 well well-lg" align="left">
			<b>Procedimientos a Ejecutar para la realizaci&oacute;n del Mantenimiento de Hardware:</b>
			<br/>
			<?= $solucion["mantenimientoHardware"]; ?>
		</div>
	</div>

	<br/>

	<div class="row">
		<div class="col-sm-12" align="center">
			<b>REPORTE DE RELEVO O CAMBIO DE HARDWARE DEL EQUIPO</b>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-offset-1 col-sm-10 well well-lg" align="left">
			<?php if ( isset($no_hardware) ){ ?>
				No se realizaron reemplazos de Componentes de Hardware.
			<?php } else { ?>
				<table id="tableHardware" name="tableHardware" class="table table-hover table-striped" style="font-size: 12px;width:100%;">
					<thead>
						<tr>
							<th>Componente</th>
							<th>Descripci&oacute;n</th>
							<th>Serial Viejo</th>
							<th>Serial Nuevo</th>
							<th>&iquest;Reemplazado&quest;</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($hardware as $cambio) { ?>
							<tr>
								<td><?= $cambio["hardwareARemplazar"]; ?></td>
								<td><?= $cambio["descripcion"]; ?></td>
								<td><?= $cambio["hardwareViejo"]; ?></td>
								<td><?= $cambio["hardwareNuevo"]; ?></td>
								<td align="center"><?= ucfirst( $cambio["fueRemplazado"] ); ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>
	</div>
	
	<br/>

	<div class="row">
		<div class="col-sm-12" align="center">
			<b>REPORTE MANTENIMIENTO DE SOFTWARE (Procedimientos a Ejecutar)</b>
		</div>
	</div>

	<br/>

	<div class="row">
		<div class="col-sm-offset-1 col-sm-10 well well-lg" align="left">
			<b>Procedimientos a Ejecutar para la realizaci&oacute;n del Mantenimiento de Software:</b>
			<br/>
			<?= $solucion["mantenimientoSoftware"]; ?>
		</div>
	</div>
	

	<div class="row">
		<div class="col-sm-12" align="center">
			<b>REPORTE DE CAMBIO DE SOFTWARE DEL EQUIPO</b>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-offset-1 col-sm-10 well well-lg" align="left">
			<?php if ( isset($no_software) ){ ?>
				No se realizaron Cambios o Instalaciones de Componentes de Software.
			<?php } else { ?>
				<table id="tableSoftware" name="tableSoftware" class="table table-hover table-striped" style="font-size: 12px;width:100%;">
					<thead>
						<tr>
							<th>Software</th>
							<th width="160px">Versi&oacute;n</th>
							<th align="center" width="160px">Tipo</th>
							<th>Serial</th>
							<th align="center" width="160px">Trabajo</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($software as $trabajo) { ?>
							<tr>
								<td><?= $trabajo["softwareARemplazar"]; ?></td>
								<td><?= $trabajo["version"]; ?></td>
								<td><?= ucfirst( $trabajo["tipo"] ); ?></td>
								<td><?= $trabajo["serial"]; ?></td>
								<td align="center"><?= ucfirst( $trabajo["trabajo"] ); ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>
	</div>

	<br/>
	
	<div class="row">
		<div class="col-sm-12" align="center">
			<b>REPORTE DE ACOMPA&Ntilde;AMIENTO JUNIOR</b>
		</div>
	</div>

	<br/>

	<div class="row">
		<div class="col-sm-offset-1 col-sm-10 well well-lg" align="left">
			<?= $solucion["acompanamientoJunior"]; ?>
		</div>
	</div>

	<br/>
	
</div>

<div class="row">
	<div class="col-sm-6" align="right">
	  <button type="submit" class="btn btn-success btn-lg" onclick="javascript:volverAVerSolucion();">
		<span class="glyphicon glyphicon-menu-left"></span> 
		Volver a Soluci&oacute;n de Incidencia
	  </button>
	</div>

	<div class="col-sm-6" align="left">
		<a href="<?= PROJECTURLMENU; ?><?= $tipo_portal; ?>" class="btn btn-link">
			<span class="glyphicon glyphicon-home"></span> 
			Ir a p&aacute;gina principal del Portal
		</a>
	</div>
</div>

<!-- ========================= Formulario para VER SOLUCION DE una incidencia  ================================== -->
<form id="resolucionIncidenciaForm2" method="post" enctype="multipart/form-data" 
	action="<?php 
		echo PROJECTURLMENU; 
		if ( isset( $viene_de_tech) ){ 				echo "tecnicos";
		} else if ( isset( $viene_de_admin) ){ 		echo "admin";
		} else {									echo "portal";
		}
	?>/ver_resolucion_incidencia">
	
		<input type="hidden" id="resolucionIncidenciaId" name="resolucionIncidenciaId" value="<?= $solucion["solucionId"]; ?>" />
</form>

<!-- ========================================== scripts ===================================================== -->
<script>

	$(document).ready(function () {

		//alert("2.Procesando PDF y Descargando...");

	});


	function volverAVerSolucion(){

		document.getElementById("resolucionIncidenciaForm2").submit();
	}

	function printThisPage(){

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
	

</script>
</body>
</html>