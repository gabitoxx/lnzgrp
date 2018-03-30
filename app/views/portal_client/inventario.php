<style>
	#imgX {
	 	width: 250px;
	 	height: 200px;
	}
</style>
<div class="container">
	
	<h4 style="text-align:center; color:#E30513;">
		<span class="glyphicon glyphicon-blackboard logo slideanim"></span>
		<i>Inventario de Equipos</i>&nbsp;&nbsp;&nbsp;
	</h4>
	<div class="row">
		<div class="col-sm-12" align="center" style="padding: 12px 20px 12px 40px; font-size: 14px;">
			Aqu&iacute; usted podr&aacute; <b>ver en detalle</b> la informaci&aacute;n
			que poseemos en nuestro sistema sobre su(s) Equipo(s). 
			Esta informaci&oacute;n fue recolectada por nuestros Ingenieros de Soporte 
			al momento de realizar una <i>visita de Inventario</i> en su Empresa.
			<br/>
		</div>
	</div>

<?php 	if ( isset($no_misEquipos) ){	?>
	
	<div class="row">
		<div class="col-sm-12" align="center" style="padding: 12px 20px 12px 40px; font-size: 18px;">
			Usted <b>NO</b> posee equipos registrados a su uso. 
			<br/>
			Para la Asignaci&oacute;n de Equipos, puede dirigirse a un Ingeniero de Soporte de LanuzaGroup 
			o a tambi&eacute;n al "Partner" (encargado) de LanuzaGroup en su Empresa.
		</div>
	</div>
	

<?php 	
		} /* no_misEquipos */

		if ( isset($misEquipos) ){
?>
	<div class="row">
		<div class="col-sm-12" align="center" style="padding: 12px 20px 12px 40px; font-size: 18px;">
			<b><i>Mis Equipos</i></b>
			<br/>
		</div>
	</div>

<?php
			foreach ($misEquipos as $equipo) {
				
?>
		<div class="row">
			<div class="col-sm-2">&nbsp;</div>
			<div class="col-sm-8 well well-lg" align="center" style="border-color:#000;">
				 
				<?php
					if ( $equipo["linkImagen"] != NULL && $equipo["linkImagen"] != "" ) {
						/*
						 * Imagen Real del Equipo (Foto)
						 */
						echo '<img id="imgX" alt="' . $equipo["TipoEquipo"] . '" src="' . $equipo["linkImagen"] . '" />';

					} else {
						echo "* ";
						/*
						 * Imagenes referenciales
						 */
						if ( $equipo["TipoEquipo"] == "Escritorio" )						echo '* <img id="imgX" alt="Escritorio" src="' . APPIMAGEPATH . 'escritorio.jpg" />';
						else if ( $equipo["TipoEquipo"] == "Todo-en-uno" )					echo '* <img id="imgX" alt="Todo-en-uno" src="' . APPIMAGEPATH . 'Todo-en-uno.jpg" />';
						else if ( $equipo["TipoEquipo"] == "Laptop o Portátil" )			echo '* <img id="imgX" alt="Laptop" src="' . APPIMAGEPATH . 'laptop.png" />';
						else if ( $equipo["TipoEquipo"] == "Servidor" )						echo '* <img id="imgX" alt="Servidor" src="' . APPIMAGEPATH . 'servidor.png" />';
						else if ( $equipo["TipoEquipo"] == "Router" )						echo '* <img id="imgX" alt="Router" src="' . APPIMAGEPATH . 'router.jpg" />';
						else if ( $equipo["TipoEquipo"] == "Impresora" )					echo '* <img id="imgX" alt="Impresora" src="' . APPIMAGEPATH . 'impresora.jpg" />';
						else if ( $equipo["TipoEquipo"] == "Impresora Multifuncional" )		echo '* <img id="imgX" alt="Impresora Multifuncional" src="' . APPIMAGEPATH . 'multifuncional.jpg" />';
						else if ( $equipo["TipoEquipo"] == "Cámara Vigilancia" )			echo '* <img id="imgX" alt="Cámara Vigilancia" src="' . APPIMAGEPATH . 'camara.jpg" />';
						else if ( $equipo["TipoEquipo"] == "Escáner" )						echo '* <img id="imgX" alt="Escáner" src="' . APPIMAGEPATH . 'escaner.jpg" />';
						else if ( $equipo["TipoEquipo"] == "Módem" )						echo '* <img id="imgX" alt="Módem" src="' . APPIMAGEPATH . 'modem.jpg" />';
						else if ( $equipo["TipoEquipo"] == "Repetidor" )					echo '* <img id="imgX" alt="Repetidor" src="' . APPIMAGEPATH . 'repetidor.jpg" />';
						else if ( $equipo["TipoEquipo"] == "Switch" )						echo '* <img id="imgX" alt="Switch" src="' . APPIMAGEPATH . 'switch.jpg" />';
						else if ( $equipo["TipoEquipo"] == "Monitor" )						echo '* <img id="imgX" alt="Monitor" src="' . APPIMAGEPATH . 'monitor.jpg" />';
						else if ( $equipo["TipoEquipo"] == "Teclado" )						echo '* <img id="imgX" alt="Teclado" src="' . APPIMAGEPATH . 'teclado.jpg" />';
						else if ( $equipo["TipoEquipo"] == "Mouse" )						echo '* <img id="imgX" alt="Mouse" src="' . APPIMAGEPATH . 'mouse.jpg" />';
						else if ( $equipo["TipoEquipo"] == "TV" )							echo '* <img id="imgX" alt="TV" src="' . APPIMAGEPATH . 'TV.jpg" />';
						else if ( $equipo["TipoEquipo"] == "Equipo Empresarial especial" )	echo '* <img id="imgX" alt="Equipo Empresarial especial" src="' . APPIMAGEPATH . 'maquina_especial.jpeg" />';
						else if ( $equipo["TipoEquipo"] == "POS" )							echo '* <img id="imgX" alt="POS" src="' . APPIMAGEPATH . 'POS.png" />';
						else if ( $equipo["TipoEquipo"] == "Celular" )						echo '* <img id="imgX" alt="Smartphones" src="' . APPIMAGEPATH . 'celular.png" />';
						else if ( $equipo["TipoEquipo"] == "Otro" )							echo '* <img id="imgX" alt="Otro tipo de equipo" src="' . APPIMAGEPATH . 'otro_equipo.png" />';
						else 																echo '* <img id="imgX" alt="Equipo registrado" src="' . APPIMAGEPATH . 'computadora-empresarial-handheld.jpg" />';
					}
				?>
				<br/>
				<?= "<b>" . $equipo["TipoEquipo"] . "</b>"; ?>
				<br/>
				<?= "C&oacute;digo Barras: " . $equipo["codigoBarras"]; ?>
				<br/>
				<?php 
					if ( $equipo["infoBasica"] != NULL && $equipo["infoBasica"] != ""){
						echo $equipo["infoBasica"];
					}
				?>
				<?php 
					if ( $equipo["observacionInicial"] != NULL && $equipo["observacionInicial"] != ""){
						echo " (" . $equipo["observacionInicial"] . ") <br/>";
					}
				?>
				<button type="button" class="btn btn-primary" 
				 <?php 
				 	echo 'onclick="javascript:verInventario(';
				 	if ( $equipo["equipoInfoId"] != NULL ){
				 		echo $equipo["equipoInfoId"] . ", '" . $equipo["TipoEquipo"] . "' , '" . $equipo["codigoBarras"] . "' , '" . $equipo["linkImagen"] . "'";
				 	} else {
				 		echo "0,0,0,0";
				 	}
				 	echo ');"';
				 ?>
				 data-toggle="tooltip" data-placement="bottom" title="Ver m&aacute;s informaci&oacute;n: detalles de este Equipo">
				 	<span class="glyphicon glyphicon-modal-window"></span> +Detalles</button>
						
			</div>
			<div class="col-sm-2">&nbsp;</div>
		</div>

<?php 	
			}
		} /* misEquipos */
?>

	<div class="row">
		<br/><br/>
		<div class="col-sm-12" align="center">
			<h4>* Imagenes referenciales, NO son fotos reales de los Equipos de la Empresa.</h4>
		</div>
	</div>

</div>

<!-- =================================================================================================== -->
<form id="equipoInfoId_form" method="post" enctype="multipart/form-data"
 data-toggle="validator" role="form" action="<?= PROJECTURLMENU; ?>portal/ver_inventario_equipo">

	<input type="hidden" id="equipoInfoId"  name="equipoInfoId" value="" />
	<input type="hidden" id="tipoEquipo" 	name="tipoEquipo" 	value="" />
	<input type="hidden" id="codigoBarras"  name="codigoBarras" value="" />
	<input type="hidden" id="linkImagen"  	name="linkImagen"   value="" />

</form>
<script>
	function verInventario(equipoInfoId, tipoEquipo, codigoBarras, URL){

		if ( equipoInfoId == 0 ){
			alert("Este Equipo aún NO ha sido analizado e inventariado por nuestros Ingenieros de Soporte."
				+ "\n\n Para ver la información de su Equipo, puede dirigirse a uno de nuestros Ing. de Soporte "
				+ "o al Partner asociado a LanuzaGroup en su Empresa.");
		
		} else {

			$('#equipoInfoId').val( equipoInfoId );
			$('#tipoEquipo').val( tipoEquipo );
			$('#codigoBarras').val( codigoBarras );
			$('#linkImagen').val( URL );

			$('#equipoInfoId_form').submit();

		}
	}
</script>