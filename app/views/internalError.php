<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>ERROR Interno</title>

	<link rel="shortcut icon" href="<?= APPIMAGEPATH; ?>favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?= APPIMAGEPATH; ?>favicon.ico" type="image/x-icon">
	
	<link rel="apple-touch-icon" href="<?= APPIMAGEPATH; ?>apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?= APPIMAGEPATH; ?>apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?= APPIMAGEPATH; ?>apple-touch-icon-114x114.png">

	<meta name="google-site-verification" content="7MTL52H6Hqrg5Ps8VtI8Lc5XraA_mI9P570lCUClxe0" />


	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
</head>
<body id="myPage">

	<div class="row">
		<div class="col-sm-4" align="left">
			<img src="<?= APPIMAGEPATH; ?>logo.png" alt="Lanuza Group" class="img-responsive" width="300" height="94">
		</div>
		<div class="col-sm-8" align="left">
			<h1>Error Interno</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12" align="center">
			<?php
				$i = rand (1,20);$img="";
				if ( $i % 2 == 0 ){ $img="error2.jpg"; } else { $img="error.jpg"; }
			?>
			<img src="<?= APPIMAGEPATH . $img; ?>" alt="Lanuza Group" class="img-responsive" width="400" height="250">
		</div>
	</div>
	<div class="well well-lg">
		<div class="row">
			<div class="col-sm-6" align="right">
				<div style="color:#E30513;"><b>Fecha:<b/></div>
				<br/>
				<?php
					date_default_timezone_set("America/Bogota");
					putenv("TZ=America/Bogota");
				?>
				<?= date("d/m/Y") . " - " . date("h:i:s A"); ?>
			</div>
			<div class="col-sm-6" align="left">
				<div style="color:#E30513;"><b>C&oacute;digo de Error:<b/></div>
				<br/>
				<?php  if (isset($internalErrorCodigo)) echo $internalErrorCodigo; ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<div style="color:#E30513;"><b>Mensaje:<b/></div>
				<br/>
				<?php  if (isset($internalErrorMessage)) echo $internalErrorMessage; ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<div style="color:#E30513;"><b>Extra Info:<b/></div>
				<br/>
				<?php  if (isset($internalErrorExtra)) echo $internalErrorExtra; ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-offset-1 col-sm-10" align="center">
			<br/>
			<h5>
				* Se recomienda realizar un <i>pantallazo (o print-screen)</i> de &eacute;sta p&aacute;gina y enviarla
				por correo electr&oacute;nico a <b><?= CONTACTEMAIL2; ?></b> y con gusto atenderemos esta falla. 
				<i>Como alternativa</i>, puede enviar el texto del <b>C&oacute;digo y Mensaje de Error junto con 
				la Fecha y la informaci&oacute;n Extra</b> 
				(copiar-y-pegar) el texto de arriba y enviarlo al mismo correo electr&oacute;nico del 
				<b>Soporte de <i>Lanuza Group</i></b> para atender esta falla.
			</h5>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6" align="right">
			<br/>
			<button type="submit" class="btn btn-info btn-lg" onclick="javascript:window.print();" 
		     data-toggle="tooltip" data-placement="bottom" title="S&iacute;, deseo Crear mi cuenta con estos datos">
		     <span class="glyphicon glyphicon-print"></span> Imprimir </button>
		</div>
		<div class="col-sm-6" align="left">
			<br/>
			<a href="<?= PROJECTURLMENU; ?>home" class="btn btn-success btn-lg" role="button">
				<span class="glyphicon glyphicon-home"></span> Volver a la P&aacute;gina de Inicio
			</a>
		</div>
	</div>
</body>