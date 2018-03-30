<style>
	.logo {
		color: #3C763D;
		font-size: 40px;
	}

	input[type="text"] {
	    width: 350px;
	}
</style>

<?php 
	$partner1=""; $partner1_all=""; 
	$partner2=""; $partner2_all="";
	$partner_3="";
	$cont=0;
	$aux=""; $aux2="";
	foreach ($partners as $manager){
		$cont++;
		
		$aux = $manager["saludo"] . " " . $manager["nombre"] . " " . $manager["apellido"];

		$aux2 = $aux 
				. "<br/> Email: " . $manager["email"]
				. "<br/> Dependencia: " . $manager["dependencia"]
				. "<br/> Teléfono interno: " . $manager["telefonoTrabajo"]
				. "<br/> Extensión: " . $manager["extensionTrabajo"];

		if ( $cont == 1 ){		$partner1=$aux; $partner1_all=$aux2;
		} else if ($cont == 2){ $partner2=$aux; $partner2_all=$aux2;
		} else {
			$partner_3 .= "<br/>----<br/>" . $aux2;
		}
	}
?>


<div id="wholePage">

	<h4 style="text-align:center; color:<?= RGB_TECH; ?>; margin-top:0px; font-size: 35px; ">
		<span class="glyphicon glyphicon-info-sign logo slideanim"></span>
		<i> Su Perfil: </i>&nbsp;&nbsp;&nbsp;
	</h4>


	<div class="container col-sm-12 well well-lg">
		<form id="basicData" style="font-size: 18px; ">
			<div class="row">
				<div class="col-sm-6" align="center">
					<label for="c1" class=""><span class="glyphicon glyphicon-wrench logo"></span> Sobre Usted </label>
				</div>
				<div class="col-sm-6" align="center">
					<label for="c2" class=""><span class="glyphicon glyphicon-briefcase logo"></span> Sobre su Empresa</label>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2" align="right">
					<label for="c1" class="">Email:</label>
				</div>
				<div class="col-sm-4" align="left">
					<input type="text" class="" id="c1" size="40" style="border: 0px solid;" disabled="disabled" value="<?= $profile["usuario_email"] ; ?>" />
				</div>
				<div class="col-sm-2" align="right">
					<label for="c2" class="">Nombre:</label>
				</div>
				<div class="col-sm-4" align="left">
					<input type="text" class="" id="c2" style="border: 0px solid;" disabled="disabled" value="<?= $profile["nombre"]; ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2" align="right">
					<label for="c3"class="">Usuario:</label>
				</div>
				<div class="col-sm-4" align="left">
					<input type="text" class="" id="c3" style="border: 0px solid;" disabled="disabled" value="<?= $profile["usuario"] ; ?>" />
				</div>
				<div class="col-sm-2" align="right">
					<label for="c4" class="">Raz&oacute;n Social:</label>
				</div>
				<div class="col-sm-4" align="left">
					<?php
						$aux = $profile["razonSocial"];
						if ( $aux == NULL || $aux == "" ){
							$aux = "[No Registra]";
						}
					?>
					<input type="text" class="" id="c4" style="border: 0px solid; <?php if($aux=="[No Registra]") echo 'font-style:italic;' ?>" disabled="disabled" value="<?= $aux; ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2" align="right">
					<label for="c5"class="">Nombre:</label>
				</div>
				<div class="col-sm-4" align="left">
					<input type="text" class="" id="c5" style="border: 0px solid;" disabled="disabled" value="<?= $profile["saludo"] . ' ' . $profile["usuario_nombre"]; ?>" />
				</div>
				<div class="col-sm-2" align="right">
					<label for="c6" class="">NIT:</label>
				</div>
				<div class="col-sm-4" align="left">
					<?php
						$aux = $profile["NIT"];
						if ( $aux == NULL || $aux == "" ){
							$aux = "[No Registra]";
						}
					?>
					<input type="text" class="" id="c6" style="border: 0px solid; <?php if($aux=="[No Registra]") echo 'font-style:italic;' ?>" disabled="disabled" value="<?= $aux; ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2" align="right">
					<label for="c5"class="">Apellido:</label>
				</div>
				<div class="col-sm-4" align="left">
					<input type="text" class="" id="c5" style="border: 0px solid;" disabled="disabled" value="<?= $profile["apellido"]; ?>" />
				</div>
				<div class="col-sm-2" align="right">
					<label for="c6" class="">P&aacute;gina Web:</label>
				</div>
				<div class="col-sm-4" align="left">
					<?php
						$aux = $profile["paginaWeb"];
						if ( $aux == NULL || $aux == "" ){
							$aux = "[No Registra]";
						}
					?>
					<input type="text" class="" id="c6" style="border: 0px solid; <?php if($aux=="[No Registra]") echo 'font-style:italic;' ?>" disabled="disabled" value="<?= $aux; ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2" align="right">
					<label for="c5"class="">Tipo de Cuenta:</label>
				</div>
				<div class="col-sm-4" align="left">
					<?php
						$tipo = "";
						if ( $profile["role"] == "admin"){ 			$tipo = "Administrador"; }
						else if ( $profile["role"] == "manager"){   $tipo = "Partner"; }
						else if ( $profile["role"] == "client"){ 	$tipo = "Usuario"; }
						else if ( $profile["role"] == "developer"){ $tipo = "Programador"; }
						else if ( $profile["role"] == "tech"){ 		$tipo = "Técnico"; }
					?>
					<input type="text" class="" id="c5" style="border: 0px solid;" disabled="disabled" value="<?= $tipo; ?>" />
				</div>
				<div class="col-sm-2" align="right">
					<label for="c6" class="">Direcci&oacute;n:</label>
				</div>
				<div class="col-sm-4" align="left">
					<?php
						$aux = $profile["direccion"];
						if ( $aux == NULL || $aux == "" ){
							$aux = "[No Registra]";
						}
					?>
					<input type="text" class="" id="c6" style="border: 0px solid; <?php if($aux=="[No Registra]") echo 'font-style:italic;' ?>" disabled="disabled" value="<?= $aux; ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2" align="right">
					<label for="c5"class="">G&eacute;nero:</label>
				</div>
				<div class="col-sm-4" align="left">
					<input type="text" class="" id="c5" style="border: 0px solid;" disabled="disabled" value="<?= $profile["gender"]; ?>" />
				</div>
				<div class="col-sm-2" align="right">
					<label for="c6" class="">Dpto./Ciudad:</label>
				</div>
				<div class="col-sm-4" align="left">
					<?php
						$aux = $profile["departamento_Estado"];
						if ( $aux == NULL || $aux == "" ){
							$aux = "[N/A]";
						}
						$tipo = $profile["ciudad"];
						if ( $tipo == NULL || $tipo == "" ){
							$tipo = "[N/A]";
						}
					?>
					<input type="text" class="" id="c6" style="border: 0px solid;" disabled="disabled" value="<?= $aux . ' / ' . $tipo; ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2" align="right">
					<label for="c5"class="">Celular:</label>
				</div>
				<div class="col-sm-4" align="left">
					<?php
						$aux = $profile["celular"];
						if ( $aux == NULL || $aux == "" ){
							$aux = "[No Registra]";
						}
					?>
					<input type="text" class="" id="c5" style="border: 0px solid;" disabled="disabled" value="<?= $aux; ?>" />
				</div>
				<div class="col-sm-2" align="right">
					<label for="c6" class="">PBX:</label>
				</div>
				<div class="col-sm-4" align="left">
					<?php
						$aux = $profile["PBX"];
						if ( $aux == NULL || $aux == "" ){
							$aux = "[No Registra]";
						}
					?>
					<input type="text" class="" id="c6" style="border: 0px solid; <?php if($aux=="[No Registra]") echo 'font-style:italic;' ?>" disabled="disabled" value="<?= $aux; ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2" align="right">
					<label for="c5"class="">Tel&eacute;fono Casa:</label>
				</div>
				<div class="col-sm-4" align="left">
					<?php
						$aux = $profile["telefonoCasa"];
						if ( $aux == NULL || $aux == "" ){
							$aux = "[No Registra]";
						}
					?>
					<input type="text" class="" id="c5" style="border: 0px solid; <?php if($aux=="[No Registra]") echo 'font-style:italic;' ?>" disabled="disabled" value="<?= $aux; ?>" />
				</div>
				<div class="col-sm-2" align="right">
					<label for="c6" class="">Email empresarial:</label>
				</div>
				<div class="col-sm-4" align="left">
					<?php
						$aux = $profile["email"];
						if ( $aux == NULL || $aux == "" ){
							$aux = "[No Registra]";
						}
					?>
					<input type="text" class="" id="c6" style="border: 0px solid; <?php if($aux=="[No Registra]") echo 'font-style:italic;' ?>" disabled="disabled" value="<?= $aux; ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2" align="right">
					<label for="c5"class="">Tel&eacute;fono Trabajo:</label>
				</div>
				<div class="col-sm-4" align="left">
					<?php
						$aux = $profile["telefonoTrabajo"];
						if ( $aux == NULL || $aux == "" ){
							$aux = "[No Registra]";
						}
					?>
					<input type="text" class="" id="c5" style="border: 0px solid; <?php if($aux=="[No Registra]") echo 'font-style:italic;' ?>" disabled="disabled" value="<?= $aux; ?>" />
				</div>
				<div class="col-sm-2" align="right" style="cursor:help;"
				 data-toggle="tooltip" data-placement="bottom" title="Pulse sobre el Nombre para MÁS info...">
					<label for="c6" class=""><u>Partners</u></label>
				</div>
					<?php
						$aux = $partner1;
						if ( $aux == NULL || $aux == "" ){
					?>
						<div class="col-sm-4" align="left">
							<input type="text" class="" id="c6" style="border: 0px solid; font-style:italic; " disabled="disabled" value="[No Registra]" />

						<?php } else { ?>

						<div class="col-sm-4" align="left" onclick="javascript:showModal(1);" >
							<input type="text" class="" id="c6" style="border: 0px solid;" disabled="disabled" value="<?= $aux; ?>" />

						<?php } ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2" align="right">
					<label for="c5"class="">Su Extensi&oacute;n:</label>
				</div>
				<div class="col-sm-4" align="left">
					<?php
						$aux = $profile["extensionTrabajo"];
						if ( $aux == NULL || $aux == "" ){
							$aux = "[N/A]";
						}
					?>
					<input type="text" class="" id="c6" style="border: 0px solid; <?php if($aux=="[N/A]") echo 'font-style:italic;' ?>" disabled="disabled" value="<?= $aux; ?>" />
				</div>
				<div class="col-sm-2" align="right" style="cursor:help;"
				 data-toggle="tooltip" data-placement="bottom" title="Pulse sobre el Nombre para MÁS info...">
					<label for="c6" class=""><u>Encargados</u>:</label>
				</div>
				<?php
						$aux = $partner2;
						if ( $aux == NULL || $aux == "" ){
					?>
						<div class="col-sm-4" align="left">
							<input type="text" class="" id="c6" style="border: 0px solid; font-style:italic;" disabled="disabled" value="[No Registra]" />

						<?php } else { ?>

						<div class="col-sm-4" align="left" onclick="javascript:showModal(2);" >
							<input type="text" class="" id="c6" style="border: 0px solid;" disabled="disabled" value="<?= $aux; ?>" />

						<?php } ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2" align="right">
					<label for="c5"class="">Usuario creado el:</label>
				</div>
				<div class="col-sm-4" align="left">
					<input type="text" class="" id="c5" style="border: 0px solid;" disabled="disabled" value="<?= $profile["fecha_ingreso"]; ?>" />
				</div>
				<div class="col-sm-2" align="right">
					<label for="c6" class="">Registrada desde:</label>
				</div>
				<div class="col-sm-4" align="left">
					<input type="text" class="" id="c6" style="border: 0px solid;" disabled="disabled" value="<?= $profile["fechaCreacion"]; ?>" />
				</div>
			</div>
		</form>
	</div>


<!-- ========================= MODAL para ver la info del Técnico ============================ -->
<div class="modal fade" id="myModal" role="dialog">
	<!-- tamaño del modal: modal-sm PEQUEÑO | modal-lg GRANDE -->
	<div class="modal-dialog modal-sm">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title" align="center">
			<span class="glyphicon glyphicon-briefcase"></span> 
			Informaci&oacute;n del Partner
		  </h4>
		</div>

		<div class="modal-body">
		  <p><div id="feedback"></div></p>
		</div>

		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		</div>
	  </div>
	</div>
</div>
<?php
	echo "<script>";
	echo "   var otros_partners = '" . $partner_3 . "';" ;
	echo "   var partner_1_all = '" . $partner1_all . "';" ;
	echo "   var partner_2_all = '" . $partner2_all . "';" ;
	echo "</script>";
?>
<script>
	function showModal(partner){

		var aux="";
		if ( partner == 1 ){
			aux = partner_1_all;
		} else {
			aux = partner_2_all;
		}

		if ( otros_partners != null && otros_partners != "" ){
			document.getElementById("feedback").innerHTML = aux + "<hr/><br/>Otros Partners: <br/>" + otros_partners;
		} else {
			document.getElementById("feedback").innerHTML = aux;
		}

		$('#myModal').modal('show');
		
	}


</script>