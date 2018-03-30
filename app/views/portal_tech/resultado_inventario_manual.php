<div class="container" style="font-family: monospace;">

	<div class="row" style="background-color:#F9B233;">

		<div class="col-sm-3" align="right">
			<span class="glyphicon glyphicon-thumbs-up"></span> 
			<b>Equipo Nuevo creado ID:</b>
		</div>
		<div class="col-sm-3" align="left">
			<?php if ( isset($equipoId) ) echo $equipoId; ?>
		</div>
		<div class="col-sm-3" align="right">
			C&oacute;digo de Barras:
		</div>
		<div class="col-sm-3" align="left">
			<?php if ( isset($equipoBarras) ) echo $equipoBarras; ?>
		</div>
	</div>

	<br/>
	
<?php
	if ( isset($Exception) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			No pudo procesarse la info del <b>formulario 'manual'</b>. Causa del error:
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12" align="left">
			<?= $Exception; ?>
		</div>
	</div>

<?php
	} else {
?>

	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			<?php if ( isset($resumen) ) echo $resumen; ?>
		</div>
	</div>

<?php
	}
?>