<style>
	th {
		text-align: center;
	}
</style>

<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-comment logo slideanim"></span>
	PQRS: Peticiones - Quejas - Reclamos - Sugerencias (de todos los Usuarios)
</h4>

<br/><br/>

<div class="row">
	<div class="col-sm-2">
		Filtrando por:
	</div>
	<div class="col-sm-1">
		<label>
			<input type="radio" id="comentario_tipo" name="comentario_tipo" value="todos" onclick="javascript:changeSpan('T');"
			 <?php if( $opcion == "todos" || $opcion == "Todos" ) echo 'checked="checked"'; ?>
			 > 
			Todos
		</label>
	</div>
	<div class="col-sm-1">
		<label>
			<input type="radio" id="comentario_tipo" name="comentario_tipo" value="Petición" onclick="javascript:changeSpan('P');"
			 <?php if( $opcion == "Petición" || $opcion == "Peticion" ) echo 'checked="checked"'; ?>
			 >

			Petici&oacute;n
		</label>
	</div>
	<div class="col-sm-1">
		<label>
			<input type="radio" id="comentario_tipo" name="comentario_tipo" value="Queja" onclick="javascript:changeSpan('Q');"
			 <?php if( $opcion == "Queja" ) echo 'checked="checked"'; ?>
			 >
			Queja
		</label>
	</div>
	<div class="col-sm-2">
		<label>
			<input type="radio" id="comentario_tipo" name="comentario_tipo" value="Reclamo" onclick="javascript:changeSpan('R');"
			 <?php if( $opcion == "Reclamo" ) echo 'checked="checked"'; ?>
			 >
			Reclamo
		</label>
	</div>
	<div class="col-sm-2">
		<label>
			<input type="radio" id="comentario_tipo" name="comentario_tipo" value="Sugerencia" onclick="javascript:changeSpan('S');"
			 <?php if( $opcion == "Sugerencia" ) echo 'checked="checked"'; ?>
			 >
			Sugerencia
		</label>
	</div>
	<div class="col-sm-3">
		<button type="button" class="btn btn-primary"
		 data-toggle="tooltip" data-placement="bottom" title="BUSCAR seg&uacute;n la opci&oacute;n seleccionada"
		 onclick="javascript:rebuscarPQRS();">
			<span class="glyphicon glyphicon-search"></span> Buscar
		</button>
	</div>
</div>

<div class="row">
	<div class="col-sm-12" align="center" style="background-color: #ffffcc;">
		<br/>
		El texto que se le pone al Usuario y que antecede su comentario es este:
		<br/><br/>
		<b><span id="spanTipoComentario"><i>Seleccione los tipos de Comentarios que desea ver</i></span></b>
		<br/><br/><br/>
	</div>
</div>


<div class="container">
	<div id="no-more-tables">
	    <table class="col-md-12 table-hover table-striped cf" style="font-size:12px;" border="1">
			<thead class="cf">
				<tr>
					<th width="90px" class="active" align="center">Empresa</th>
					<th width="160px" align="center">Usuario</th>
					<th width="150px" align="center">Rol en Sistema</th>
					<th width="80px">PQRS</th>
					<th align="center">Comentario</th>
					<th width="100px">Fecha <br/>(A&ntilde;o-Mes-D&iacute;a Hora)</th>
				</tr>
			</thead>
			<tbody>
<?php 

					foreach ($comentarios as $comentario) {
?>
				<tr 
<?php 
					if ( $comentario["tipo"] == "Petición"){ 		echo 'class="info"';
					} else if ( $comentario["tipo"] == "Queja"){ 	echo 'class="danger"';
					} else if ( $comentario["tipo"] == "Reclamo"){ 	echo 'class="warning"';
					} else {										echo 'class="success"';
					}
?> 				>

					<td data-title="Empresa" align="center" style="padding-top: 10px; padding-bottom: 10px;">
						<?= $comentario["NombreEmpresa"] . "<br/>" . $comentario["razonSocial"]; ?>
					</td>
					
					<td data-title="Usuario" align="center" style="padding-top: 10px; padding-bottom: 10px;">
						<?= $comentario["nombre"] . "<br/>" . $comentario["apellido"]; ?>
					</td>

					<td data-title="Rol" align="center">
<?php 
						if ( $comentario["userRole"] == "client"){ 			echo 'Usuario';
						} else if ( $comentario["userRole"] == "manager"){ 	echo 'Partner';
						} else if ( $comentario["userRole"] == "tech"){ 	echo 'Ing. de Soporte';
						} else if ( $comentario["userRole"] == "developer"){echo 'Desarrollador';
						} else {											echo 'Admin';
						}
?>
					</td>
					
					<td data-title="Tipo PQRS"><?= $comentario["tipo"]; ?></td>

					<td data-title="Comentario"><?= $comentario["texto"]; ?></td>

					<td data-title="Fecha" align="center"><?= $comentario["fecha"]; ?></td>

				</tr>

<?php 				} ?>

			</tbody>
		</table>
	</div>
</div>

<script>
	function changeSpan(type){
		if ( type == 'P' ){
			document.getElementById("spanTipoComentario").innerHTML = "Alguna nueva Solicitud o Mejoras al Servicio ofrecido o al Portal web LanuzaSoft";
		
		} else if ( type == 'Q' ){
			document.getElementById("spanTipoComentario").innerHTML = "Alg&uacute;n comentario sobre un mal Servicio prestado por nuestros Ingenieros de Soporte";
		
		} else if ( type == 'R' ){
			document.getElementById("spanTipoComentario").innerHTML = "Alg&uacute;n proceso que usted realiz&oacute; en nuestro Portal LanuzaSoft y su resultado NO fue satisfactorio";
		
		} else if ( type == 'S' ){
			document.getElementById("spanTipoComentario").innerHTML = "Alguna idea innovadora sobre nuestros Servicios o sobre el Portal LanuzaSoft para que podamos brindarle una mejor Calidad de Servicio";
		
		} else {
			document.getElementById("spanTipoComentario").innerHTML = "Ver Todos";
		}
	}

	function rebuscarPQRS(){

		var opt = $('input[type=radio][name=comentario_tipo]:checked').val();

		if ( opt == "Petición"){
			opt = "Peticion";
		}

		location.href = "<?= PROJECTURLMENU; ?>admin/pqrs/" + opt;
	}
</script>