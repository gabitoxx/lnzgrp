<div class="container">

	<div class="row">
		<div class="col-sm-12" align="center">
			<img src="<?= APPIMAGEPATH; ?>waiting.gif" class="img-rounded" alt="Cargando..." width="150" height="150">
		</div>
	</div>

	<div class="row">
		<div class="col-sm-3" align="center">
			<img src="<?= APPIMAGEPATH; ?>creating_report.png" class="img-rounded" alt="Creando..." width="250" height="250">
		</div>
		<div class="col-sm-6" align="center">
			<b>
				Espere un momento: Estamos <i>Cargando</i> informaci&oacute;n &uacute;til y Reportes para Usted...
			</b>
			<br/><br/>
			Buscamos que la data acumulada en nuestros Sistemas le produzca informaci&oacute;n &uacute;til 
			para la toma de decisiones en su Empresa...
			<br/><br/>
			Estamos compilando la data, gener&aacute;ndole informaci&oacute;n en forma de gr&aacute;ficas y res&uacute;menes
			de todas las actividades, tanto la de usted como la de los Usuarios del Portal en su Empresa;
			esto le permitir&aacute; conocer un res&uacute;men de Incidencias, estado de los Equipos, Soporte TI y m&aacute;s.
			<br/><br/>
			<b>
				No dude en consultar por nuestras Asesor&iacute;as para que sus Equipos y su Infraestructura
				de Tecnolog&iacute;a se encuentre a la vanguardia. Estamos para servirle...
			</b>
		</div>
		<div class="col-sm-3" align="center">
			<img src="<?= APPIMAGEPATH; ?>creating_report2.png" class="img-rounded" alt="Reportes..." width="250" height="250">
		</div>
	</div>
	<br/>
	<hr/>
	<br/>
	<div class="row">
		<div class="col-sm-2" align="center">
			<img src="<?= APPIMAGEPATH; ?>creating_report1.png" class="img-rounded" alt="Tip" width="130" height="130">
		</div>
		<div class="col-sm-8">
			<br/><br/>
<?php
			if ( isset($tip) ){
				echo $tip["tip"];
			}

			if ( isset( $funcionAcargar) ){
				echo "<script> var URL = '" . PROJECTURLMENU . "gerentes/" . $funcionAcargar . "'; </script>" ;
			}

?>			
		</div>
	</div>

</div>
<script type="text/javascript">
	/* After 1 second, go to THE PAGE */
	setTimeout(function(){ 
		location.href = URL; 
	}, (1 * 1000) );
</script>