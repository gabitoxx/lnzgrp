<?php
	echo "<script>";
	echo '	var saludoUsuario = "' . $_SESSION['logged_user_saludo'] . '";';
    
	if ( isset($objJsonIncidenciasSinOpinar) && $objJsonIncidenciasSinOpinar != NULL ){
		echo '	var jsonIncidenciasSinOpinar = ' . $objJsonIncidenciasSinOpinar->incidenciasSinOpinar . ';';
		echo '	var idUsuarioIncidenciaSinOpinar = ' . $objJsonIncidenciasSinOpinar->userId . ';';
	} else {
		echo '	var jsonIncidenciasSinOpinar = "[]";';
		echo '	var idUsuarioIncidenciaSinOpinar = -1; ';
	}

	echo "</script>";
?>
<form class="form-horizontal" data-toggle="validator" role="form" id="solucion_opinion_form"
 method="post" enctype="multipart/form-data">

<input type="hidden" id="incidenciaId_Form" name="incidenciaId_Form" 
<?php
	if ( isset($certificar_opinar_incidenciaID) ){ echo "value='".$certificar_opinar_incidenciaID."' "; }
?> />

<input type="hidden" id="solucionId_Form"   name="solucionId_Form"
<?php
	if ( isset($certificar_opinar_solucionID) ){ echo "value='".$certificar_opinar_solucionID."' "; }
?> />

<input type="hidden" id="se_pudo_resolver_Form"  name="se_pudo_resolver_Form"  value="" />
<input type="hidden" id="positiva_negativa_Form" name="positiva_negativa_Form" value='true' />

<input type="hidden" id="barra_1_Form" name="barra_1_Form" value='0' />
<input type="hidden" id="barra_2_Form" name="barra_2_Form" value='0' />
<input type="hidden" id="barra_3_Form" name="barra_3_Form" value='0' />
<input type="hidden" id="barra_4_Form" name="barra_4_Form" value='0' />

<input type="hidden" id="json_userId"      name="json_userId"      value='' />
<input type="hidden" id="json_incidencias" name="json_incidencias" value='' />

<div class="modal fade" id="myModalOpinar" role="dialog">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  
		  <!-- button type="button" class="close" data-dismiss="modal">&times;</button -->

		  <h4 class="modal-title" align="center" style="font-size:16px;">
		  	<span class="glyphicon glyphicon-hand-right"></span> &nbsp; 
			<span class="glyphicon glyphicon-certificate"></span> &nbsp; 
			&iexcl;Muchas gracias <i><u><?= $_SESSION['logged_user_saludo']; ?></u></i> 
			por Certificar la Soluci&oacute;n ofrecida por el Ing. de Soporte&excl;
			&nbsp; 
			<span class="glyphicon glyphicon-star"></span>  &nbsp; 
			<span class="glyphicon glyphicon-hand-left"></span>
		  </h4>
		</div>

		<div class="modal-body">
			<?php
				if ( isset( $certificar_opinar_ERROR ) ){
					echo $certificar_opinar_ERROR;
				} else {
			?>

				<div class="row">
					<div class="col-sm-12">
						Para nosotros en Lanuza Group, <b>su opini&oacute;n es muy importante</b>.
						Le solicitamos nos d&eacute; su opini&oacute;n sobre la Calidad de nuestro Servicio:
						<br/>
						<br/>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-offset-1 col-sm-7">
						&iquest;El Ingeniero de Soporte <span style="color:green;">resolvi&oacute;</span> el Inconveniente que usted report&oacute;&quest;
						<br/>
					</div>
					<div class="col-sm-4">
						<style>
							.switch {
							  position: relative;
							  display: inline-block;
							  width: 60px;
							  height: 34px;
							}

							.switch input {display:none;}

							.slider {
							  position: absolute;
							  cursor: pointer;
							  top: 0;
							  left: 0;
							  right: 0;
							  bottom: 0;
							  background-color: #ccc;
							  -webkit-transition: .4s;
							  transition: .4s;
							}

							.slider:before {
							  position: absolute;
							  content: "";
							  height: 26px;
							  width: 26px;
							  left: 4px;
							  bottom: 4px;
							  background-color: white;
							  -webkit-transition: .4s;
							  transition: .4s;
							}

							input:checked + .slider {
							  background-color: #2196F3;
							}

							input:focus + .slider {
							  box-shadow: 0 0 1px #2196F3;
							}

							input:checked + .slider:before {
							  -webkit-transform: translateX(26px);
							  -ms-transform: translateX(26px);
							  transform: translateX(26px);
							}

							/* Rounded sliders */
							.slider.round {
							  border-radius: 34px;
							}

							.slider.round:before {
							  border-radius: 50%;
							}
						</style>
						<!-- Rounded switch -->
						<label class="switch">
						  <input type="checkbox" id="opinion_resolvioProblema" name="opinion_resolvioProblema" onclick="javascript:toogleCheckbox();" />
						  <div class="slider round"></div>
						</label>
					</div>
				</div>
				<!--
				<div class="row">
					<div class="col-sm-offset-2 col-sm-6" style="vertical-align:middle;">
						<br/>
						&iquest;Usted califica como <span style="color:blue;">positiva</span> o 
						<span style="color:#E30513;">negativa</span> la atención del T&eacute;cnico&quest;
					</div>
					<div class="col-sm-4">
						<style>
							.fa {
								font-size: 50px;
								cursor: pointer;
								user-select: none;
							}
							.fa:hover {
								color: darkblue;
							}
						</style>
						<!-- Use an element to toggle between a like/dislike icon --
						<i onclick="likeDislike(this)" class="fa fa-thumbs-up"></i>
					</div>
				</div>
				-->
				<div class="row">
					<div class="col-sm-10">
						<hr/>
						Elija la opci&oacute;n que m&aacute;s se ajuste a lo que Usted piensa:
					</div>
					<div class="col-sm-2" style="background-color: #ffffb3;" align="center">
						<div id="iconFace" class="fa" style="font-size:48px;">&#xf11a;</div>
						<br/>
						<i>Resumen general</i>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12" align="center">
						<hr/>
						<span style="font-size:16px;">&iquest;Considera que el <i>tiempo de servicio</i> brindado por el personal es el necesario para cubrir el soporte&quest;</span>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12" align="center">
						<div class="btn-group btn-group-justified">
						  <a href="#" onclick="javascript:setBarra1(1);return false;" class="btn btn-danger" style="font-size:10px;">Totalmente en Desacuerdo</a>
						  <a href="#" onclick="javascript:setBarra1(2);return false;" class="btn btn-warning" style="font-size:10px;">En Desacuerdo</a>
						  <a href="#" onclick="javascript:setBarra1(3);return false;" class="btn btn-info" style="font-size:10px;">Ni de Acuerdo ni en Desacuerdo</a>
						  <a href="#" onclick="javascript:setBarra1(4);return false;" class="btn btn-success" style="font-size:10px;">De Acuerdo</a>
						  <a href="#" onclick="javascript:setBarra1(5);return false;" class="btn btn-primary" style="font-size:10px;">Totalmente de Acuerdo</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12" align="center">
						<style>
							#myProgress {
								width: 100%;
								background-color: black;
							}
							#myBar1, #myBar2, #myBar3, #myBar4 {
								width: 1%;
								height: 20px;
							}
						</style>
						<div id="myProgress">
							<div id="myBar1" class="progress-bar progress-bar-striped" role="progressbar" 
							 aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
								<span id="span-myBar1"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12" align="center">
						<hr/>
						<span style="font-size:16px;">&iquest;<i>El personal resolvi&oacute; dudas o brind&oacute; el soporte adecuado a su requerimiento</i>&quest;</span>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12" align="center">
						<div class="btn-group btn-group-justified">
						  <a href="#" onclick="javascript:setBarra2(1);return false;" class="btn btn-danger" style="font-size:10px;">Totalmente en Desacuerdo</a>
						  <a href="#" onclick="javascript:setBarra2(2);return false;" class="btn btn-warning" style="font-size:10px;">En Desacuerdo</a>
						  <a href="#" onclick="javascript:setBarra2(3);return false;" class="btn btn-info" style="font-size:10px;">Ni de Acuerdo ni en Desacuerdo</a>
						  <a href="#" onclick="javascript:setBarra2(4);return false;" class="btn btn-success" style="font-size:10px;">De Acuerdo</a>
						  <a href="#" onclick="javascript:setBarra2(5);return false;" class="btn btn-primary" style="font-size:10px;">Totalmente de Acuerdo</a>
						</div>
					</div>
				</div>
				<div class="row" align="center">
					<div class="col-sm-12">
						<div id="myProgress">
							<div id="myBar2" class="progress-bar progress-bar-striped" role="progressbar" 
							aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
								<span id="span-myBar2"></span>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12" align="center">
						<hr/>
						<span style="font-size:16px;">&iquest;LanuzaGroup le ha brindado alg&uacute;n servicio o producto adicional&quest;</span>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12" align="center">
						<div class="btn-group btn-group-justified">
						  <a href="#" onclick="javascript:setBarra3(1);return false;" class="btn btn-danger" style="font-size:10px;">Totalmente en Desacuerdo</a>
						  <a href="#" onclick="javascript:setBarra3(2);return false;" class="btn btn-warning" style="font-size:10px;">En Desacuerdo</a>
						  <a href="#" onclick="javascript:setBarra3(3);return false;" class="btn btn-info" style="font-size:10px;">Ni de Acuerdo ni en Desacuerdo</a>
						  <a href="#" onclick="javascript:setBarra3(4);return false;" class="btn btn-success" style="font-size:10px;">De Acuerdo</a>
						  <a href="#" onclick="javascript:setBarra3(5);return false;" class="btn btn-primary" style="font-size:10px;">Totalmente de Acuerdo</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12" align="center">
						<div id="myProgress">
							<div id="myBar3" class="progress-bar progress-bar-striped" role="progressbar" 
							 aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
								<span id="span-myBar3"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12" align="center">
						<hr/>
						<span style="font-size:16px;">&iquest;<b>C&oacute;mo califica en general</b> el servicio brindado por Lanuza Group&quest;</span>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12" align="center">
						<div class="btn-group btn-group-justified">
						  <a href="#" onclick="javascript:setBarra4(1);return false;" class="btn btn-danger" style="font-size:10px;">Totalmente en Desacuerdo</a>
						  <a href="#" onclick="javascript:setBarra4(2);return false;" class="btn btn-warning" style="font-size:10px;">En Desacuerdo</a>
						  <a href="#" onclick="javascript:setBarra4(3);return false;" class="btn btn-info" style="font-size:10px;">Ni de Acuerdo ni en Desacuerdo</a>
						  <a href="#" onclick="javascript:setBarra4(4);return false;" class="btn btn-success" style="font-size:10px;">De Acuerdo</a>
						  <a href="#" onclick="javascript:setBarra4(5);return false;" class="btn btn-primary" style="font-size:10px;">Totalmente de Acuerdo</a>
						</div>
					</div>
				</div>
				<div class="row" align="center">
					<div class="col-sm-12">
						<div id="myProgress">
							<div id="myBar4" class="progress-bar progress-bar-striped" role="progressbar" 
							aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
								<span id="span-myBar4"></span>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<br/>
					<div class="col-sm-3" align="right">
						Puede escribir sus Sugerencias, Comentarios o Reclamos...
					</div>
					<div class="col-sm-8">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
							<textarea class="form-control" id="opinion_comentarios" name="opinion_comentarios" rows="3"
							placeholder="Sus observaciones pueden ayudar a que mejoremos nuestros Servicios"
							></textarea>
						</div>
					</div>
					<div class="col-sm-1">&nbsp;</div>
				</div>
				<div class="row">
					&nbsp;
				</div>
				<div class="row">
					<div class="col-sm-12" align="center">
						<button type="submit" class="btn btn-success btn-lg" onclick="javascript:enviarOpinion();return false;"
						   data-toggle="tooltip" data-placement="bottom" title="¡Muchas Gracias por enviarnos su Opinión!">
							<span class="glyphicon glyphicon-thumbs-up"></span> 
							 &nbsp;&nbsp;
							 Enviar mi opini&oacute;n
							 &nbsp;&nbsp;
							<span class="glyphicon glyphicon-thumbs-down"></span> 
						</button>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-offset-1 col-sm-11">
						<span class="glyphicon glyphicon-sunglasses" style="font-size:13px;">
						Sus opiniones son consideradas como <b>an&oacute;nimas</b>.
						Esto nos ayudar&aacute; a mejorar nuestra Calidad de Servicio.</span>
					</div>
				</div>

			<?php
				}
			?>
		</div>

		<div class="modal-footer">
		  <!-- button type="button" class="btn btn-default" data-dismiss="modal">Voy a opinar m&aacute;s tarde</button -->
		</div>
	  </div>
	</div>
</div>
</form>

<script>
	var bResuelto = false;
	var bGusto = true;

	/**
	 * Funcion del boton tipo facebook like/dislike
	 */
	function likeDislike(x) {

		x.classList.toggle("fa-thumbs-down");

		if ( bGusto == false ) {
			document.getElementById("positiva_negativa_Form").value = "true";
			bGusto = true;

		} else {
			document.getElementById("positiva_negativa_Form").value = "false";
			bGusto = false;
		}

		actualizarResumenGeneral();
	}


	function toogleCheckbox(){

		if ( bResuelto == false ) {
			document.getElementById("se_pudo_resolver_Form").value = "true";
			bResuelto = true;
		} else {
			document.getElementById("se_pudo_resolver_Form").value = "false";
			bResuelto = false;
		}

		actualizarResumenGeneral();
	}


	/**
	 * Funciones para setear los valores de los grupos de botones
	 */
	function setBarra1(value){
		document.getElementById("barra_1_Form").value = value;

		switch(value) {
			case 1:
				moveBar("myBar1", 20, "progress-bar progress-bar-danger progress-bar-striped");
				break;
			case 2:
				moveBar("myBar1", 40, "progress-bar progress-bar-warning progress-bar-striped");
				break;
			case 3:
				moveBar("myBar1", 60, "progress-bar progress-bar-info progress-bar-striped");
				break;
			case 4:
				moveBar("myBar1", 80, "progress-bar progress-bar-success progress-bar-striped");
				break;
			case 5:
				moveBar("myBar1", 100,"progress-bar progress-bar-primary progress-bar-striped");
				break;
		}
	}
	function setBarra2(value){
		document.getElementById("barra_2_Form").value = value;

		switch(value) {
			case 1:
				moveBar("myBar2", 20, "progress-bar progress-bar-danger progress-bar-striped");
				break;
			case 2:
				moveBar("myBar2", 40, "progress-bar progress-bar-warning progress-bar-striped");
				break;
			case 3:
				moveBar("myBar2", 60, "progress-bar progress-bar-info progress-bar-striped");
				break;
			case 4:
				moveBar("myBar2", 80, "progress-bar progress-bar-success progress-bar-striped");
				break;
			case 5:
				moveBar("myBar2", 100,"progress-bar progress-bar-primary progress-bar-striped");
				break;
		}
	}
	function setBarra3(value){
		document.getElementById("barra_3_Form").value = value;

		switch(value) {
			case 1:
				moveBar("myBar3", 20, "progress-bar progress-bar-danger progress-bar-striped");
				break;
			case 2:
				moveBar("myBar3", 40, "progress-bar progress-bar-warning progress-bar-striped");
				break;
			case 3:
				moveBar("myBar3", 60, "progress-bar progress-bar-info progress-bar-striped");
				break;
			case 4:
				moveBar("myBar3", 80, "progress-bar progress-bar-success progress-bar-striped");
				break;
			case 5:
				moveBar("myBar3", 100,"progress-bar progress-bar-primary progress-bar-striped");
				break;
		}
	}
	function setBarra4(value){
		document.getElementById("barra_4_Form").value = value;

		switch(value) {
			case 1:
				moveBar("myBar4", 20, "progress-bar progress-bar-danger progress-bar-striped");
				break;
			case 2:
				moveBar("myBar4", 40, "progress-bar progress-bar-warning progress-bar-striped");
				break;
			case 3:
				moveBar("myBar4", 60, "progress-bar progress-bar-info progress-bar-striped");
				break;
			case 4:
				moveBar("myBar4", 80, "progress-bar progress-bar-success progress-bar-striped");
				break;
			case 5:
				moveBar("myBar4", 100,"progress-bar progress-bar-primary progress-bar-striped");
				break;
		}
	}

	function moveBar(barID, finalValue, classNames) {

		var elem = document.getElementById(barID);

		elem.className = classNames;

		document.getElementById('span-' + barID).innerHTML = "" + finalValue + "%";

		var width = 1;

		var id = setInterval(framex, 10);

		function framex() {
			if (width >= finalValue) {
				clearInterval(id);

			} else {
				width++; 
				elem.style.width = finalValue + '%';
			}
		}

		actualizarResumenGeneral();
	}

	function actualizarResumenGeneral(){

		var icon = document.getElementById("iconFace");
		
		var number = parseInt( $("#barra_1_Form").val() )
				+ parseInt( $("#barra_2_Form").val() )
				+ parseInt( $("#barra_3_Form").val() )
				+ parseInt( $("#barra_4_Form").val() );
		
		if ( bResuelto == true && ( number >= 12 ) ){
			icon.innerHTML = "&#xf118;";/*cara feliz*/
		
		} else if ( bResuelto == true  && ( number > 6 ) ){
			icon.innerHTML = "&#xf11a;";/*cara media*/
		
		} else if ( bResuelto == true) {
			icon.innerHTML = "&#xf11a;";/*cara media*/

		} else if ( bResuelto == false && ( number >= 16 ) ){
			icon.innerHTML = "&#xf11a;";/*cara media*/

		} else {
			icon.innerHTML = "&#xf119;";/*cara triste*/
		}
	}

	function enviarOpinion(){

		var b0 = $("#se_pudo_resolver_Form").val();

		var b1 = $("#barra_1_Form").val();
		var b2 = $("#barra_2_Form").val();
		var b3 = $("#barra_3_Form").val();
		var b4 = $("#barra_4_Form").val();

		if ( b0 != "" && b1 != "0" && b2 != "0" && b3 != "0" && b4 != "0" ){
			/*
			 * todos los campos llenos
			 */
			$('#myModalOpinar').modal('hide');

			/* Get the snackbar DIV */
			var x = document.getElementById("snackbar")

			/* Add the "show" class to DIV */
			x.className = "show";

			/*
			 * Eliminando esta incidencia, el obj JSON, del arreglo
			 */
			var json = eliminarIncidenciaDeJson( $("#incidenciaId_Form").val(), jsonIncidenciasSinOpinar);
			var jsonString = "";
			if ( json.length == 0 ){
				jsonString = "[]";
			} else {
				jsonString = JSON.stringify(json);
			}
			//y añadiendolos al form
			document.getElementById("json_userId").value = idUsuarioIncidenciaSinOpinar;
			document.getElementById("json_incidencias").value = jsonString;

			$.ajax({
				type: "POST",
				url: modalAjaxURL_2,
				data: $('#solucion_opinion_form').serialize(),
				success: function(message){
					/* alert(message); */

					/* After 5 seconds, remove the show class from DIV */
					setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
				},
				error: function(){
					alert("Error de Base de Datos\nPor favor, intente más tarde");
				}
			});

		} else {
			/*
			 * NO estan todos los campos llenos, Anderson pidió que NO fuesen vacíos (reunión 18/07/2017)
			 */
			alert(saludoUsuario + ":\n\nPara nosotros su opinión es muy valiosa e indispensable.\n\n ( Por favor, complete todos los campos solicitados)\n\nSolo así la Encuesta quedará completa y podremos mejorar la Calidad de Servicio que le ofrecemos...\n\nNota: ¿se cercioró de responder el primer botón?");
		}
	}

	function eliminarIncidenciaDeJson(incidenciaId, jsonObjs){
		var result="";

		var estaId = buscarIdEnJson(jsonObjs, ""+incidenciaId);

		if ( estaId > -1 ){
			console.log("si esta");
			/* nuevoJson */
			result = quitarObjJson(jsonObjs, estaId);
			console.log( "nuevoJson" , JSON.stringify(result));
		}
		return result;
	}

</script>


<!-- ================== snackbar para avisar que el mensaje fue enviado ===================================== -->
<style>
	/* The snackbar - position it at the bottom and in the middle of the screen */
	#snackbar {
		visibility: hidden; 	/* Hidden by default. Visible on click */
		min-width: 250px; 		/* Set a default minimum width */
		margin-left: -125px; 	/* Divide value of min-width by 2 */
		background-color: #333; /* Black background color */
		color: #fff; 			/* White text color */
		text-align: center; 	/* Centered text */
		border-radius: 2px; 	/* Rounded borders */
		padding: 16px; 			/* Padding */
		position: fixed; 		/* Sit on top of the screen */
		z-index: 1; 			/* Add a z-index if needed */
		left: 50%; 				/* Center the snackbar */
		bottom: 30px; 			/* 30px from the bottom */
	}

	/* Show the snackbar when clicking on a button (class added with JavaScript) */
	#snackbar.show {
		visibility: visible; /* Show the snackbar */

		/* Add animation: Take 0.5 seconds to fade in and out the snackbar. 
		 * However, delay the fade out process for 4.5 seconds
		 */
		-webkit-animation: fadein 0.5s, fadeout 0.5s 4.5s;
		animation: fadein 0.5s, fadeout 0.5s 4.5s;
	}

	/* Animations to fade the snackbar in and out */
	@-webkit-keyframes fadein {
		from {bottom: 0; opacity: 0;} 
		to {bottom: 30px; opacity: 1;}
	}

	@keyframes fadein {
		from {bottom: 0; opacity: 0;}
		to {bottom: 30px; opacity: 1;}
	}

	@-webkit-keyframes fadeout {
		from {bottom: 30px; opacity: 1;} 
		to {bottom: 0; opacity: 0;}
	}

	@keyframes fadeout {
		from {bottom: 30px; opacity: 1;}
		to {bottom: 0; opacity: 0;}
	}
</style>

<!-- The actual snackbar -->
<div id="snackbar">
	Su Opini&oacute;n ha sido enviada... Muchas Gracias :)
</div>
