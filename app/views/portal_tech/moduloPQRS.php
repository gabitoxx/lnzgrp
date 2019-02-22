<style>
	.chatLive{
		box-shadow: none;
		position: fixed;
		right: 20px;
		bottom: 0;
		z-index: 1030;
		background-color: <?= RGB_TECH; ?>;
		color: #000;
		font-size: 12px;
		text-align: center;
	}

</style>

<!-- ==========================   Modulo PQRS  ========================================================  -->
<div id="div_chat" class="chatLive well well-sm" onclick="javascript:openPQRS();"
 onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'">
	
	<div class="hidden-xs">
	<!-- Esconder en Celulares -->
		<span class="glyphicon glyphicon-heart"></span>
		&nbsp;&nbsp;&nbsp;
		<b>M&oacute;dulo PQRS</b>
		&nbsp;&nbsp;&nbsp;
		<span class="glyphicon glyphicon-comment"></span>
		<br/>
		¿Comentarios, Quejas, Reclamos o Sugerencias?
		<br/>
		Estamos aqu&iacute; para escucharte...
	</div>
	
	<div class="visible-xs-block">
	<!-- Mostrar SOLO en Celulares -->
		<span class="glyphicon glyphicon-heart"></span>
		<b>PQRS</b>
		<span class="glyphicon glyphicon-comment"></span>
	</div>
</div>

<!-- ==========================   Modal  ========================================================  -->
<div class="modal fade" id="modalPQRS" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" align="center">
				<span class="glyphicon glyphicon-comment"></span>
				&nbsp;&nbsp;&nbsp;
				<i>Peticiones, Quejas, Reclamos o Sugerencias</i>
				&nbsp;&nbsp;&nbsp;
				<span class="glyphicon glyphicon-bullhorn"></span>
			</h4>
		</div>

		<div class="modal-body">

			<div class="row">
				<div class="col-sm-12">
					Para nosotros en Lanuza Group, <b>su opini&oacute;n es muy importante</b>.
					Le solicitamos nos d&eacute; su opini&oacute;n sobre la Calidad de nuestro Servicio,
					as&iacute; como cualquier comentario, queja o sugerencia que desee hacernos.
					<br/><br/>
					Recuerde que como Ingeniero de Soporte, puede ayudarnos a saber 
					qu&eacute; nos faltar&iacute;a para mejorar nuestros Servicios,
					o tambi&eacute;n qu&eacute; funcionalidades se pueden mejorar en el PORTAL web LanuzaSoft.
					<br/><br/>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-3">
					Deseo hacer una: 
				</div>
				<div class="col-sm-2" data-toggle="tooltip" data-placement="top"
				 title="Alguna nueva Solicitud o Mejoras al Servicio ofrecido o al Portal LanuzaSoft">
					<label>
						<input type="radio" id="comentario_tipo" name="comentario_tipo" value="Petición" onclick="javascript:changeSpan('P');"> 
						Petici&oacute;n
					</label>
				</div>
				<div class="col-sm-2" data-toggle="tooltip" data-placement="top"
				 title="Alg&uacute;n comentario sobre un mal Servicio prestado por nuestros Ingenieros de Soporte">
					<label>
						<input type="radio" id="comentario_tipo" name="comentario_tipo" value="Queja" onclick="javascript:changeSpan('Q');"> 
						Queja
					</label>
				</div>
				<div class="col-sm-2" data-toggle="tooltip" data-placement="top"
				 title="Alg&uacute;n proceso que usted realiz&oacute; en nuestro Portal LanuzaSoft y su resultado NO fue satisfactorio">
					<label>
						<input type="radio" id="comentario_tipo" name="comentario_tipo" value="Reclamo" onclick="javascript:changeSpan('R');"> 
						Reclamo
					</label>
				</div>
				<div class="col-sm-2" data-toggle="tooltip" data-placement="top"
				 title="Alguna idea innovadora sobre nuestros Servicios o sobre el Portal LanuzaSoft para que podamos brindarle una mejor Calidad de Servicio">
					<label>
						<input type="radio" id="comentario_tipo" name="comentario_tipo" value="Sugerencia" onclick="javascript:changeSpan('S');"> 
						Sugerencia
					</label>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12" align="center" style="background-color: #ffffcc;">
					<br/>
					<b><span id="spanTipoComentario"><i>Seleccione el tipo de Comentario que desea realizar</i></span></b>
					<br/>
				</div>
			</div>
			<div class="row">&nbsp;</div>
			<div class="row">
				<br/>
				<div class="col-sm-2" align="right">
					Puede escribir sus Comentarios aqu&iacute;...
				</div>
				<div class="col-sm-9">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
						<textarea class="form-control" id="opinion_comentarios" name="opinion_comentarios" rows="3"
						 placeholder="Sus observaciones pueden ayudar a que mejoremos nuestros Servicios y la Calidad de los mismos..."
						 ></textarea>
					</div>
				</div>
				<div class="col-sm-1">&nbsp;</div>
			</div>
			<div class="row">&nbsp;</div>

		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-success btn-lg" onclick="javascript:sendPQRS();return false;"
			 data-toggle="tooltip" data-placement="bottom" title="&iexcl;Muchas Gracias por enviarnos sus Comentarios&excl;">
				<span class="glyphicon glyphicon-comment"></span> 
				Enviar al Buz&oacute;n de Sugerencias
			</button>
			&nbsp;&nbsp;&nbsp;
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		</div>
	  </div>
	</div>
</div>

<!-- ========================= Formulario para usar AJAX .:. Enviar Comentarios ============================ -->
<?php
	echo "<script>";
	echo "   var modalAjaxURL_PQRS = '" . PROJECTURLMENU . "tecnicos/ajax_salvar_pqrs';" ;
	echo "   var saludoUsuario = '" . $_SESSION['logged_user_saludo'] . "';" ;
	
	echo "</script>";
?>
<form id="enviarComentario" method="post" enctype="multipart/form-data">
	<input type="hidden" id="comentarioTipo" 	 name="comentarioTipo" 		value="" />
	<input type="hidden" id="opinionComentarios" name="opinionComentarios"  value="" />
</form>

<script>
	/**
	 * MODAL modulo PQRS
	 */
	function openPQRS(){
		
		$('#modalPQRS').modal({
			backdrop: 'static',
			keyboard: false,
			show: true
		});
	}

	function changeSpan(type){
		if ( type == 'P' ){
			document.getElementById("spanTipoComentario").innerHTML = "Alguna nueva Solicitud o Mejoras al Servicio ofrecido o al Portal web LanuzaSoft";
		
		} else if ( type == 'Q' ){
			document.getElementById("spanTipoComentario").innerHTML = "Alg&uacute;n comentario sobre un mal Servicio prestado por nuestros Ingenieros de Soporte";
		
		} else if ( type == 'R' ){
			document.getElementById("spanTipoComentario").innerHTML = "Alg&uacute;n proceso que usted realiz&oacute; en nuestro Portal LanuzaSoft y su resultado NO fue satisfactorio";
		
		} else if ( type == 'S' ){
			document.getElementById("spanTipoComentario").innerHTML = "Alguna idea innovadora sobre nuestros Servicios o sobre el Portal LanuzaSoft para que podamos brindarle una mejor Calidad de Servicio";
		}
	}

	function sendPQRS(){

		
		var x1 = $('input[type=radio][name=comentario_tipo]:checked').val();
		var x2 = $("#opinion_comentarios").val();

		var bool = false;
		if ( x1 == "Petición" || x1 == "Queja" || x1 == "Reclamo" || x1 == "Sugerencia" ){
			bool = true;
		}

		if ( x2 != "" && bool ){

			/*
			 * seteando nuevos valores y blanqueando campos
			 */
			$("#comentarioTipo").val( x1 );
			$("#opinionComentarios").val( x2 );

			$("#opinion_comentarios").val( "" );
			
			/**/
			$('#modalPQRS').modal('hide');

			/* Get the snackbar DIV */
			var x = document.getElementById("snackbarPQRS");

			/* Add the "show" class to DIV */
			x.className = "show";

			$.ajax({
				type: "POST",
				url: modalAjaxURL_PQRS,
				data: $('#enviarComentario').serialize(),
				success: function(message){

					document.getElementById("spanResultadoEnvioComentarios").innerHTML = "" + message;

					/* After 5 seconds, remove the show class from DIV */
					setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
				},
				error: function(message){
					alert("Error tratando de Enviar sus Comentarios\nPor favor, intente más tarde.\n Error: " + message);
					x.className = x.className.replace("show", "");
				}
			});

		} else {
			/*
			 * NO estan todos los campos llenos, Anderson pidió que NO fuesen vacíos (reunión 18/07/2017)
			 */
			alert(saludoUsuario + ":\n\nPara nosotros su opinión es muy valiosa e indispensable.\n\n ( Por favor, complete todos los 2 campos solicitados. Solo así podremos mejorar la Calidad de Servicio que le ofrecemos...)");
		}
	}

</script>

<!-- ================== snackbar para avisar que el mensaje fue enviado ===================================== -->
<style>
	/* The snackbar - position it at the bottom and in the middle of the screen */
	#snackbarPQRS {
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
	#snackbarPQRS.show {
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
<div id="snackbarPQRS">
	<span id="spanResultadoEnvioComentarios">
		Enviando Su Opini&oacute;n...
	</span>
</div>
