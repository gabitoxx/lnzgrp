<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-flash logo slideanim"></span>
	<i>Generar Nuevo <b>Reporte de Visita</b> a Empresa</i>&nbsp;&nbsp;&nbsp;
</h4>
	
<div class="row">
	<div class="col-sm-12">
		Esta opci&oacute;n permitir&aacute; generar un Reporte de Visita 
		que tiene el mismo formato del <u>"Formulario de Soporte"</u> para Incidencias 
		pero <i>este es generado por el mismo Ingeniero de Soporte</i> 
		(el otro es generado por los Usuarios al reportar un problema) 
		con el fin de hacer constar la visita a la Empresa y el trabajo 
		que se realiz&oacute; en ella. 
		Normalmente, este Reporte de Visita debe ser 
		<span class="glyphicon glyphicon-pencil"></span> <u>firmado en f&iacute;sico</u> 
		por la Empresa para hacer <b>constar que se visit&oacute; la misma 
		y del trabajo que usted realiz&oacute; en ella</b>.
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<br/>
		<h4 align="center" style="font-family:inherit;"><i>
			Los Reportes deben estar asociados obligatoriamente 
			<span style="color:#E30513" class="glyphicon glyphicon-briefcase"> a una Empresa</span> 
			y a 1 o 2 de las siguientes opciones:
			<br/><br/>
			<span style="color:#E30513" class="glyphicon glyphicon-user"> a un Usuario afectado</span>
			&nbsp; &nbsp; o &nbsp; &nbsp; 
			<span style="color:#E30513" class="glyphicon glyphicon-blackboard"> a un Equipo que presenta fallas</span>.
		</i></h4>
		<hr/>
	</div>
</div>

<div id="empresas" class="row well well-lg">
	<div class="row">
		<div class="col-sm-12" align="right" style="padding: 12px 20px 12px 40px; font-size: 16px;">
			<b>Busque una Empresa:</b> para buscar <b>"Empresas"</b> registradas en el Sistema, puede indicar <u>una palabra clave</u>, 
			puede ser:
			<br/>
			Nombre de la Compa&ntilde;&iacute;a, su Raz&oacute;n social, NIT o Tel&eacute;fono. 
			Incluso si lo conoce, puede indicar su <b>ID del Sistema</b> (valor netamente num&eacute;rico) de la Empresa a buscar.
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<form class="form-horizontal" data-toggle="validator" role="form" id="busqueda_empresa_form" method="post"
	 		 enctype="multipart/form-data" action="<?= PROJECTURLMENU ?>admin/generarReporte">
				
				<input type="text" name="searchCompanies" id="searchCompanies" class="search" placeholder="Primero BUSQUE una Empresa para generarle un   NUEVO REPORTE DE VISITA   : indique palabra(s) clave... y presione ENTER (3 CARACTERES al menos)"
				 <?php if ( isset($searchedCompanies) ) echo 'value="' . $searchedCompanies . '"'; ?>
				 >

			</form>
		</div>
	</div>
</div>


<script>
		
	$(document).ready(function () {

		$(".search").on('keyup', function (e) {
			if (e.keyCode == 13) {
				/* al presionar ENTER */
				document.getElementById("busqueda_empresa_form").submit();
			}
		});
	});

</script>

<?php
	
	if ( isset($procesoParte) && ($procesoParte == "Seleccion_Empresa" ) ){
?>

	<form class="form-horizontal" data-toggle="validator" role="form" id="new_reporte_visita"
	 method="post" enctype="multipart/form-data" action="<?= PROJECTURLMENU; ?>portal/create_incidencia_gerente"
	 onsubmit="javascript:return submitForm();">


	</form>

	<div id="companiesFound">
		<div class="row">
			<div class="col-sm-12" align="center" style="padding: 12px 20px 12px 40px; font-size: 18px; color:#951B81; ">
				<span class="glyphicon glyphicon-briefcase"></span> 
				<i>Empresas encontradas:</i>
			</div>
		</div>
		<div id="no-more-tables">
			<table class="col-md-12 table-hover table-striped cf" style="font-size:12px;">
				<thead class="cf">
					<tr>
						<th align="center">ID Nº</th>
						<th>Nombre</th>
						<th style="width: 100px;">Raz&oacute;n Social</th>
						<th>NIT</th>
						<th>Email</th>
						<th>PBX</th>
						<th>Direcci&oacute;n</th>
						<th>Ciudad</th>
						<th>Dpto./Edo.</th>
						<th>Pa&iacute;s</th>
						<th>P&aacute;g. Web</th>
						<th align="center">Seleccionar</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($companies as $company) { ?>
					<tr>
						<td data-title="ID Nº" align="center" style="padding-top: 10px; padding-bottom: 10px;" >
							<?= $company["empresaId"] ?>
						</td>
						
						<td data-title="Nombre" class="success"  ><?= $company["nombre"] . '<div style="color:#FFF;">.</div>'; ?></td>
						<td data-title="Razon Social" class="success" style="width: 100px;"><?php echo $company["razonSocial"] . '<div style="color:#FFF;">.</div>'; ?></td>

						<td data-title="NIT"><?php echo $company["NIT"] . '<div style="color:#FFF;">.</div>'; ?></td>
						<td data-title="Email"><?= $company["email"] . '<div style="color:#FFF;">.</div>'; ?></td>

						<td data-title="PBX"><?= $company["PBX"] . '<div style="color:#FFF;">.</div>'; ?></td>
						<td data-title="Direcci&oacute;n"><?= $company["direccion"] . '<div style="color:#FFF;">.</div>'; ?></td>

						<td data-title="ciudad" class="success"  ><?= $company["ciudad"] . '<div style="color:#FFF;">.</div>'; ?></td>
						<td data-title="Dpto./Edo." class="success"  ><?= $company["departamento_Estado"] . '<div style="color:#FFF;">.</div>'; ?></td>
						<td data-title="Pa&iacute;s" class="success"  ><?= $company["pais"] . '<div style="color:#FFF;">.</div>'; ?></td>

						<td data-title="P&aacute;gina Web">
							<?php 
								if ( $company["paginaWeb"] != null && $company["paginaWeb"] != "") {
									echo $company["paginaWeb"];
								} else {
									echo '<h6 style="color:#FFF;">.</h6>';
								}
							?>
						</td>

						<td align="center" data-title="Selección">
							<input type="radio" name="empresaId" id="empresaId" value="<?= $company["empresaId"] ?>"
							 onclick="javascript:setear2(this.value,'<?= $company["nombre"] ?>','<?= $company["razonSocial"] ?>','<?= $company["NIT"] ?>','<?= $company["direccion"] ?>','<?= $company["equiposRegistrados"] ?>');">
						</td>

					</tr>
					<?php } ?>

				</tbody>
			</table>
		</div>
		
		<div class="row">
			<div class="col-sm-12" align="center">
				<br/>
				<button id="accept" type="button" class="btn btn-success btn-lg" onclick="javascript:seleccionarEmpresa();"
				 data-toggle="tooltip" data-placement="bottom" title="PRIMERO Seleccionar una EMPRESA y luego pulsar ESTE BOTÓN">
				   <span class="glyphicon glyphicon-briefcase"></span> Seleccionar Empresa para Crearle Reportes de Visita...</button>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12" align="center" style="">
				<br/><br/>
				<h6>
					* Al pulsar este bot&oacute;n <b>NO se crean Reportes de Visita</b> a&uacute;n. Deber&aacute; proporcionar m&aacute;s detalles.
				</h6>
			</div>
		</div>

	</div>

	<form class="form-horizontal" data-toggle="validator" role="form" id="search_companyID_form" method="post"
	 enctype="multipart/form-data" action="<?= PROJECTURLMENU ?>admin/empresa_reporte_visita">

		<input type="hidden" id="seleccionarEmpresaID" 		 	name="seleccionarEmpresaID" 			value="" />
		<input type="hidden" id="seleccionarEmpresaNombre"   	name="seleccionarEmpresaNombre" 		value="" />
		<input type="hidden" id="seleccionarEmpresaRazonsocial" name="seleccionarEmpresaRazonsocial"  	value="" />
		<input type="hidden" id="seleccionarEmpresaNIT"  		name="seleccionarEmpresaNIT" 			value="" />
		<input type="hidden" id="seleccionarEmpresaDireccion"   name="seleccionarEmpresaDireccion" 		value="" />
		<input type="hidden" id="seleccionarEmpresaCantEquipos" name="seleccionarEmpresaCantEquipos" 	value="" />
	</form>

<script>
	function seleccionarEmpresa(){

		if ( $('#seleccionarEmpresaID').val() == "" ){
			alert(" Debe SELECCIONAR una Empresa para continuar con la ASIGNACIÓN de Equipo(s) a Usuario(s)");

		} else {
			document.getElementById("search_companyID_form").submit();
		}
	}
	function setear2(value,nombre,razonSocial,NIT,direccion,cantidadEquipos){
		$('#seleccionarEmpresaID').val(value);

		$('#seleccionarEmpresaNombre').val(nombre);
		$('#seleccionarEmpresaRazonsocial').val(razonSocial);
		$('#seleccionarEmpresaNIT').val(NIT);
		$('#seleccionarEmpresaDireccion').val(direccion);
		$('#seleccionarEmpresaCantEquipos').val(cantidadEquipos);
	}
</script>

<?php
	}/* "Seleccion_Empresa" */
?>