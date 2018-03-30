<div class="container" style="font-family: monospace;">
	
	<div class="row" style="background-color:#F9B233;">

		<div class="col-sm-3" align="right">
			<span class="glyphicon glyphicon-thumbs-up"></span> 
			<b>Equipo ID:</b>
		</div>
		<div class="col-sm-8" align="left">
			<?= $equipoId; ?> (ID en el Sistema)
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<?= $resultado; ?>
		</div>
	</div>

<?php
	if ( isset($no_cpu) || isset($no_motherboard) || isset($no_ram) || isset($no_hard_drives) || isset($no_SMART)
			|| isset($no_LocalUsers) || isset($no_Sound) || isset($no_Networking) || isset($no_Video) || isset($no_OS) 
			|| isset($no_Software) )
	{
?>
		<div class="row" style="background-color:#F9B233;">
			<div class="col-sm-12"align="center">
				Ocurrieron inconvenientes durante la Lectura de los Archivos .CSV
				<br/>
				Los detalles se mostrar&aacute;n a continuaci&oacute;n. 
				Se aconseja mostr&iacute;rselos al
				<b>Administrador del Portal LanuzaGroup</b> 
				para resolver estos inconvenientes.
			</div>
		</div>

		<div class="row" style="font-family: monospace;">
			<div class="col-sm-12">
<?php 
				if(isset($no_cpu)){			echo "ERROR en CPU.csv: ".$no_cpu."<hr/><br/>";}
				if(isset($no_motherboard)){	echo "ERROR en Motherboard.csv: ".$no_motherboard."<hr/><br/>";}
				if(isset($no_ram)){			echo "ERROR en RAM.csv: ".$no_ram."<hr/><br/>";}
				if(isset($no_hard_drives)){ echo "ERROR en Hard drives.csv: ".$no_hard_drives."<hr/><br/>";}
				if(isset($no_SMART)){		echo "ERROR en SMART.csv: ".$no_SMART."<hr/><br/>";}
				if(isset($no_LocalUsers)){	echo "ERROR en LocalUsers.csv: ".$no_LocalUsers."<hr/><br/>";}
				if(isset($no_Sound)){		echo "ERROR en Sound.csv: ".$no_Sound."<hr/><br/>";}
				if(isset($no_Networking)){	echo "ERROR en Networking.csv: ".$no_Networking."<hr/><br/>";}
				if(isset($no_Video)){		echo "ERROR en Video.csv: ".$no_Video."<hr/><br/>";}
				if(isset($no_OS)){			echo "ERROR en OS.csv: ".$no_OS."<hr/><br/>";}
				if(isset($no_Software)){	echo "ERROR en Software.csv: ".$no_Software."<hr/><br/>";}
?>
			</div>
		</div>

<?php 	}  ?>	

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
			<a href="<?= PROJECTURLMENU; ?>admin/home" class="btn btn-link">
				<span class="glyphicon glyphicon-home"></span> 
				Ir a p&aacute;gina principal del Portal
			</a>
		</div>
		<div class="col-sm-6" align="center">
			<a href="<?= PROJECTURLMENU; ?>admin/actualizar_inventario">
				<span class="glyphicon glyphicon-floppy-open"></span> 
				Crear una Nueva Actualizaci&oacute;n de otro Equipo
			</a>
		</div>
	</div>
</div>