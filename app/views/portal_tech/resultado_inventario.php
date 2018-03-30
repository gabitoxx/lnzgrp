<div class="container" style="font-family: monospace;">

	<div class="row" style="background-color:#F9B233;">

		<div class="col-sm-3" align="right">
			<span class="glyphicon glyphicon-thumbs-up"></span> 
			<b>Equipo Nuevo creado ID:</b>
		</div>
		<div class="col-sm-3" align="left">
			<?= $newEquipoId; ?>
		</div>
		<div class="col-sm-3" align="right">
			C&oacute;digo de Barras:
		</div>
		<div class="col-sm-3" align="left">
			<?= $newEquipoCodigoBarras; ?>
		</div>
	</div>

	<br/>
	
<?php
	if ( isset($no_cpu) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			No pudo procesarse el Archivo <b>CPU.csv</b>. Causa del error:
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12" align="left">
			<?= $no_cpu; ?>
		</div>
	</div>

<?php
	}/* no_cpu */
	if ( isset($cpu) ){
?>

	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			<?= $cpu; ?>
		</div>
	</div>

<?php
	} /* cpu */
	if ( isset($no_motherboard) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			No pudo procesarse el Archivo <b>Motherboard.csv</b>. Causa del error:
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12" align="left">
			<?= $no_motherboard; ?>
		</div>
	</div>

<?php
	}/* no_motherboard */
	if ( isset($motherboard) ){
?>

	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			<?= $motherboard; ?>
		</div>
	</div>

<?php
	} /* motherboard */
	if ( isset($no_RAM) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			No pudo procesarse el Archivo <b>RAM.csv</b>. Causa del error:
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12" align="left">
			<?= $no_RAM; ?>
		</div>
	</div>

<?php
	}/* no_RAM */
	if ( isset($RAM) ){
?>

	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			<?= $RAM; ?>
		</div>
	</div>

<?php
	}/* RAM */
	if ( isset($no_localUsers) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			No pudo procesarse el Archivo <b>LocalUsers.csv</b>. Causa del error:
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12" align="left">
			<?= $no_localUsers; ?>
		</div>
	</div>

<?php
	}/* no_localUsers */
	if ( isset($localUsers) ){
?>

	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			<?= $localUsers; ?>
		</div>
	</div>

<?php
	}/* localUsers */
	if ( isset($no_sound) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			No pudo procesarse el Archivo <b>Sound.csv</b>. Causa del error:
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12" align="left">
			<?= $no_sound; ?>
		</div>
	</div>

<?php
	}/* no_sound */
	if ( isset($sound) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			<?= $sound; ?>
		</div>
	</div>

<?php
	}/* sound */
	if ( isset($no_video) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			No pudo procesarse el Archivo <b>Video.csv</b>. Causa del error:
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12" align="left">
			<?= $no_video; ?>
		</div>
	</div>

<?php
	}/* no_video */
	if ( isset($video) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			<?= $video; ?>
		</div>
	</div>

<?php
	}/* video */
	if ( isset($no_OS) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			No pudo procesarse el Archivo <b>OS.csv</b>. Causa del error:
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12" align="left">
			<?= $no_OS; ?>
		</div>
	</div>

<?php
	}/* no_OS */
	if ( isset($OS) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			<?= $OS; ?>
		</div>
	</div>

<?php
	}/* OS */
	if ( isset($no_hard_drives) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			No pudo procesarse el Archivo <b>Hard drives.csv</b>. Causa del error:
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12" align="left">
			<?= $no_hard_drives; ?>
		</div>
	</div>

<?php
	}/* no_hard_drives */
	if ( isset($hard_drive) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			<?= $hard_drive; ?>
		</div>
	</div>

<?php
	}/* hard_drive */
	if ( isset($no_SMART) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			No pudo procesarse el Archivo <b>SMART.csv</b>. Causa del error:
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12" align="left">
			<?= $no_SMART; ?>
		</div>
	</div>

<?php
	}/* no_SMART */
	if ( isset($SMART) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			<?= $SMART; ?>
		</div>
	</div>

<?php
	}/* SMART */
	if ( isset($no_networking) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			No pudo procesarse el Archivo <b>Networking.csv</b>. Causa del error:
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12" align="left">
			<?= $no_networking; ?>
		</div>
	</div>

<?php
	}/* no_networking */
	if ( isset($networking) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			<?= $networking; ?>
		</div>
	</div>

<?php
	}/* networking */
	if ( isset($no_software) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			No pudo procesarse el Archivo <b>Software.csv</b>. Causa del error:
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12" align="left">
			<?= $no_software; ?>
		</div>
	</div>

<?php
	}/* no_software */
	if ( isset($software) ){
?>
	<div class="row">
		<div class="col-sm-12" align="left">
			<hr/>
			<?= $software; ?>
		</div>
	</div>

<?php
	}/*software*/
?>

	<hr/>
	<br/>
	<div class="row" style="background-color:#F9B233;">
		<div class="col-sm-12" align="center">
			Tip: <h4>* Procure NO darle F5 ( Refresh / Refrescar ) a esta p&aacute;gina; 
			ya que volver&iacute;a a cargar los Scripts al mismo Equipo y la info quedar&iacute;a repetida.</h4>
		</div>
	</div>

	<hr/>
	<br/><br/>
	
	<div class="row">
		<div class="col-sm-6" align="center">
			<a href="<?= PROJECTURLMENU; ?>tecnicos/home" class="btn btn-link">
				<span class="glyphicon glyphicon-home"></span> 
				Ir a p&aacute;gina principal del Portal
			</a>
		</div>
		<div class="col-sm-6" align="center">
			<a href="<?= PROJECTURLMENU; ?>tecnicos/nuevo_inventario">
				<span class="glyphicon glyphicon-blackboard"></span> 
				Crear un Nuevo Inventario
			</a>
		</div>
	</div>
</div>