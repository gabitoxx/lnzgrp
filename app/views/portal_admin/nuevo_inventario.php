<?php

	$formulario = "";

	/*
	 * En esta seccion se buscará un Usuario
	 */
	if ( isset($procesoParte) 
			&& ($procesoParte == "Busqueda_Usuario" || $procesoParte == "Seleccion_Usuario" || $procesoParte == "Seleccion_Empresa") ){
		
		echo "<script>";
		echo " var searchURL = '" . PROJECTURLMENU . "admin/inventario_buscar_usuario';" ;
		echo " var searchURL2= '" . PROJECTURLMENU . "admin/inventario_buscar_company';" ;
		echo "</script>";
?>

	<div class="row">
		<div class="col-sm-9" align="center" style="padding: 12px 20px 12px 40px; font-size: 18px;">
			<i>Utilice solo UNO de los siguientes buscadores:</i>
		</div>
		<div class="col-sm-3" align="right">
			<a href="<?= PROJECTURLMENU; ?>userAuthentication/register">&iquest;No existe el Usuario&quest;: Crear Usuario nuevo</a>
		</div>
	</div>

<!-- ================================================================================================================= -->

	<hr/>

	<form class="form-horizontal" data-toggle="validator" role="form" id="search_user_form" method="post"
	 enctype="multipart/form-data" action="<?= PROJECTURLMENU ?>admin/inventario_buscar_usuario">
		
		<h4 style="text-align:center; color:#E30513;">
			<span class="glyphicon glyphicon-user"></span> 
			&rarr; 
			<span class="glyphicon glyphicon-blackboard"></span> 
			<i>Usuario del Equipo a ser Inventariado</i>&nbsp;&nbsp;&nbsp;</h4>
		
		<div class="row">
			<div class="col-sm-12" align="left" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				En caso de Inventariar un <b>Equipo que una Persona utiliza</b> (como laptops, equipos de escritorio, PC's)
			</div>		
		</div>
		<div class="row">
			<div class="col-sm-2" align="right" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				<b>Buscar Usuario:</b>
			</div>
			<div class="col-sm-10">
				<style>
					input[type=text] {
						width: 230px;
						-webkit-transition: width 0.4s ease-in-out;
						transition: width 0.4s ease-in-out;
						padding: 12px 20px 12px 40px;
						font-size: 14px;
						border-radius: 4px;
						border: 2px solid #ccc;
						box-sizing: border-box;

						background-image: url('<?= APPIMAGEPATH; ?>searchicon.png');
						background-position: 10px 12px;
						background-repeat: no-repeat;
					}

					/* When the input field gets focus, change its width to 100% */
					input[type=text]:focus {
						width: 100%;
					}
				</style>
				<input type="text" name="search" id="search" placeholder="Buscar por Nombre, Apellido, Email, Username o por los Usuarios del nombre de una Empresa... y presione ENTER (3 CARACTERES al menos)"
				 <?php if ( isset($searched) ) echo 'value="' . $searched . '"' ?>
				 >
			</div>
		</div>
	</form>

<!-- ================================================================================================================= -->
	<hr/>

	<form class="form-horizontal" data-toggle="validator" role="form" id="search_company_form" method="post"
	 enctype="multipart/form-data" action="<?= PROJECTURLMENU ?>admin/inventario_buscar_company">
		
		<h4 style="text-align:center; color:#E30513;">
			<span class="glyphicon glyphicon-briefcase"></span> 
			&rarr; 
			<span class="glyphicon glyphicon-blackboard"></span> 
			<i>Empresa del Equipo a ser Inventariado</i>&nbsp;&nbsp;&nbsp;</h4>
		
		<div class="row">
			<div class="col-sm-12" align="left" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				En caso de Inventariar un Equipo que <b>NO sea de uso exclusivo de una Persona</b> (como Servidores, Modems, Routers, etc.)
			</div>		
		</div>
		<div class="row">
			<div class="col-sm-2" align="right" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				<b>Buscar Empresa:</b>
			</div>
			<div class="col-sm-10">
				<input type="text" name="searchCompany" id="searchCompany" placeholder="Buscar Empresa por Nombre, Razón Social, NIT, Email o dirección... y presione ENTER (3 CARACTERES al menos)"
				 <?php if ( isset($searchedCompany) ) echo 'value="' . $searchedCompany . '"' ?>
				 >
			</div>
		</div>
	</form>

<script>

	$(document).ready(function () {

		$("#search").on('keyup', function (e) {
			if (e.keyCode == 13) {
				/* al presionar ENTER */

				if ( $("#search").val().length >= 3 ){

					document.getElementById("search_user_form").action = searchURL;
					/*document.getElementById("search_user_form").submit();*/

				} else {
					alert('Indique al menos 3 letras');
					return false;
				}
			}
		});

		$("#searchCompany").on('keyup', function (e) {
			if (e.keyCode == 13) {
				/* al presionar ENTER */
				if ( $("#searchCompany").val().length >= 3 ){

					document.getElementById("search_company_form").action = searchURL2;

				} else {
					alert('Indique al menos 3 letras');
					return false;
				}
			}
		});

	});

</script>

<?php 

	}/* "Busqueda_Usuario" */
	
	/*
	 * En esta seccion se buscará un Usuario
	 */
	if ( isset($procesoParte) && $procesoParte == "Seleccion_Usuario" && isset($usuarios) ){
?>
	
<!-- ================================================================================================================= -->
	<hr/>
	<div class="container">
		<div class="row">
			<div class="col-sm-12" align="right" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				<i>Usuarios encontrados:</i> Seleccione uno para continuar con el <b>Inventario</b>...
			</div>
		</div>
		<div id="no-more-tables">
			<table class="col-md-12 table-hover table-striped cf" style="font-size:12px;">
				<thead class="cf">
					<tr>
						<th align="center">ID Nº</th>
						<th>Nombre</th>
						<th>Apellido</th>
						<th>Usuario</th>
						<th>Email</th>
						<th>Celular</th>
						<th>Rol en <br/> Sistema</th>
						<th>Estatus Actual</th>
						<th>Empresa</th>
						<th>Dependencia</th>
						<th align="center">Seleccionar</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($usuarios as $usuario) { ?>
					<tr>
						<td data-title="ID Nº" align="center" style="padding-top: 10px; padding-bottom: 10px;" >
							<?= $usuario["id"] ?>
						</td>
						
						<td data-title="Nombre" class="success"  ><?= $usuario["nombre"] ?></td>
						<td data-title="Apellido" class="success"><?php echo $usuario["apellido"] ?></td>

						<td data-title="Usuario"><?php echo $usuario["usuario"] ?></td>
						<td data-title="Email"><?= $usuario["email"] ?></td>

						<td data-title="Celular"><?= $usuario["celular"] ?></td>
						
						<td data-title="Rol">
						  <?php 
							if ( $usuario["role"] == "admin"){ 			echo "Administrador"; }
							else if ( $usuario["role"] == "manager"){   echo "Gerente"; }
							else if ( $usuario["role"] == "client"){ 	echo "Empleado"; }
							else if ( $usuario["role"] == "developer"){ echo "Programador"; }
							else if ( $usuario["role"] == "tech"){ 		echo "Técnico"; }
						  ?>
						</td>

						<td data-title="Estatus" 
						 <?php 
							if($usuario["activo"]=="activo"){echo 'class="success"';}
							else if($usuario["activo"]=="inactivo"){echo 'class="warning"';}
							else if($usuario["activo"]=="eliminado"){echo 'class="danger"';}
							else {echo 'class="active"';}
						 ?>
						>
							<?= ucfirst($usuario["activo"]); ?>
						</td>

						<td data-title="Empresa" class="info">
							<?php
								echo $usuario["empresaName"];
								if ( $usuario["razonSocial"] != null && $usuario["razonSocial"] != "") {
									echo "(" . $usuario["razonSocial"] . ")";
								}
							?>
						</td>

						<td data-title="Dependencia">
							<?php 
								if ( $usuario["dependencia"] != null && $usuario["dependencia"] != "") {
									echo $usuario["dependencia"];
								} else {
									echo '<h6 style="color:#FFF;">.</h6>';
								}
							?>
						</td>
						
						<td align="center" data-title="Selección">
							<input type="radio" name="usuarioId" id="usuarioId" value="<?= $usuario["id"] ?>"
							 onclick="javascript:setear(this.value,'<?= $usuario["nombre"] ?>','<?= $usuario["apellido"] ?>','<?= $usuario["empresaName"] ?>','<?= $usuario["razonSocial"] ?>','<?= $usuario["EmpresaID"] ?>');">
						</td>
					</tr>
					<?php } ?>

				</tbody>
			</table>
		</div>
		
		<div class="row">
			<div class="col-sm-12" align="center" style="">
				<br/>
				<button id="appointment_accept" type="button" class="btn btn-success btn-lg" onclick="javascript:seleccionarUsuario();"
				 data-toggle="tooltip" data-placement="bottom" title="PRIMERO Seleccionar un USUARIO y luego pulsar ESTE BOTÓN">
				   <span class="glyphicon glyphicon-user"></span> Seleccionar Usuario</button>
			</div>
		</div>
	</div>

	<form class="form-horizontal" data-toggle="validator" role="form" id="search_userID_form" method="post"
	 enctype="multipart/form-data" action="<?= PROJECTURLMENU ?>admin/inventario_seleccionar_usuario">

		<input type="hidden" id="seleccionarUsuarioID" 		 name="seleccionarUsuarioID" 		value="" />
		<input type="hidden" id="seleccionarUsuarioNombre"   name="seleccionarUsuarioNombre" 	value="" />
		<input type="hidden" id="seleccionarUsuarioApellido" name="seleccionarUsuarioApellido"  value="" />
		<input type="hidden" id="seleccionarUsuarioEmpresa"  name="seleccionarUsuarioEmpresa" 	value="" />
		<input type="hidden" id="seleccionarUsuarioRazon"    name="seleccionarUsuarioRazon" 	value="" />
		<input type="hidden" id="seleccionarUsuarioEmpresaID" name="seleccionarUsuarioEmpresaID" value="" />
	</form>

<script>
	function seleccionarUsuario(){

		if ( $('#seleccionarUsuarioID').val() == "" ){
			alert(" Debe SELECCIONAR un Usuario para continuar con el INVENTARIO del Equipo");

		} else {
			document.getElementById("search_userID_form").submit();
		}
	}
	function setear(value,nombre,apellido,nombreEmpresa,razonSocial, EmpresaID){
		$('#seleccionarUsuarioID').val(value);

		$('#seleccionarUsuarioNombre').val(nombre);
		$('#seleccionarUsuarioApellido').val(apellido);
		$('#seleccionarUsuarioEmpresa').val(nombreEmpresa);
		$('#seleccionarUsuarioRazon').val(razonSocial);
		$('#seleccionarUsuarioEmpresaID').val(EmpresaID);
	}
</script>

<?php 

	}/* "Seleccion_Usuario" */

	/*
	 * En esta seccion se buscará un Usuario
	 */
	if ( isset($procesoParte) && $procesoParte == "Usuario_Seleccionado" ){
?>

<!-- ================================================================================================================= -->
	<div class="container">
		<div class="row" style="background-color:#F9B233;">
			<div class="col-sm-2" align="right">
				<b>Usuario Seleccionado:</b>
			</div>
			<div class="col-sm-3" align="left">
				<?php
					if ( isset($searchedName) ){ echo $searchedName; }
					if ( isset($searchedId) ){ echo " (ID: " . $searchedId . ")"; }
				?>
			</div>
			<div class="col-sm-1" align="right">
				<b>Empresa:</b>
			</div>
			<div class="col-sm-4" align="left">
				<?php if ( isset($searchedCompany) ){ echo $searchedCompany; } ?>
			</div>
			<div class="col-sm-2" align="left">
				<a href="<?= PROJECTURLMENU; ?>admin/nuevo_inventario">No usar este Usuario</a>
			</div>
		</div>

<?php
		if ( isset($no_equipos) && $no_equipos == "no_equipos" ){
?>
		<div class="row" style="background-color:#F9B233;">
			<div class="col-sm-12" align="center">
				Este Usuario a&uacute;n NO tiene asignado ning&uacute;n Equipo.
			</div>
		</div>
<?php
		} else if ( isset($equipos) ){
?>
		<div class="row" style="background-color:#F9B233;">
			<div class="col-sm-12" align="center">
				<br/>
				Este Usuario tiene asignado los siguientes Equipos: (click para más detalles)
			</div>
		</div>
		<div id="no-more-tables" class="row">
			<table class="col-md-12 table-hover table-striped cf" style="font-size:12px;" frame="hsides"><!-- <table frame="box"> -->
				<thead class="cf">
					<tr>
						<th class="active">ID: C&oacute;digo Barras</th>
						<th>Tipo de Equipo</th>
						<th class="numeric">TeamViewer ID<br/>( Clave )</th>
						<th width="160px">Fecha creaci&oacute;n<br/>(A&ntilde;o-Mes-D&iacute;a Hora)</th>
						<th>Info y Observaci&oacute;n Inicial</th>
						<th width="90px" align="center">&iquest;Inventariado&quest;</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($equipos as $equipo) { ?>
						<tr class="active" onclick="javascript:alert(<?= $equipo["id"]; ?>);">
							<td>
								<?php 
									if ( $equipo["codigoBarras"] != null && $equipo["codigoBarras"] != ""){
										echo $equipo["codigoBarras"];
									} else {
										echo '<h6 style="color:#FFF;">.</h6>';
									}
								?>
							</td>
							<td><?= $equipo["tipoEquipo"]; ?></td>
							<td class="numeric">
								<?php 
									if ( $equipo["teamViewer_Id"] != null && $equipo["teamViewer_Id"] != ""){
										echo $equipo["teamViewer_Id"] . "<br/>(" . $equipo["teamViewer_clave"] . ")";
									} else {
										echo '<h6 style="color:#FFF;">.</h6>';
									}
								?>
							</td>
							<td>
								<?php 
									if ( $equipo["fechaCreacion"] != null && $equipo["fechaCreacion"] != ""){
										echo $equipo["fechaCreacion"];
									} else {
										echo '<h6 style="color:#FFF;">.</h6>';
									}
								?>
							</td>
							<td>
								<?php
									if ( $equipo["infoBasica"] != NULL || $equipo["infoBasica"] != "" ){
										echo $equipo["infoBasica"];
									}
									if ( $equipo["observacionInicial"] != NULL || $equipo["observacionInicial"] != "" ){
										echo " " . $equipo["observacionInicial"];
									}
									echo '<h6 style="color:#FFF;">.</h6>';
								?>
							</td>
							<td align="center">
								<?php 
									if ( $equipo["equipoInfoId"] != null && $equipo["equipoInfoId"] != ""){
										echo "Si";
									} else {
										echo "No";
									}
								?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>

<?php
		} /* equipos */
?>
<!-- ================================================================================================================= -->
		<div class="row">
			<div class="col-sm-12" align="center">
				<br/>
				<h4 style="text-align:center; color:#E30513;">
					<span class="glyphicon glyphicon-blackboard"></span> 
					<b>Nuevo Inventario</b>: Nuevo Equipo para <span class="glyphicon glyphicon-user"></span> <i><?php if ( isset($searchedName) ){ echo $searchedName; } ?></i>&nbsp;&nbsp;&nbsp;</h4>
			</div>
		</div>

<?php 	
		$formulario = "new_for_person";

		echo "<script>";
						
		echo " var searched_Name = '" . $searchedName . "';" ;
		echo " var searched_Company = '" . $searchedCompany . "';" ;

		echo ' var confirmMessage = "Se procederá a crear un NUEVO EQUIPO en el Sistema..."'
				. '+ "\n\nPara el Usuario:  " + searched_Name '
				. '+ "\n\nEn la Empresa:  " + searched_Company '
				. '+ "\n\n\n ¿Desea continuar con el INVENTARIO? \n\n(Se necesitará los archivos \".CSV\" que genera el Script )";';

		echo "</script>";
?>

<!-- ================================================================================================================= -->

<?php 
	}/* "Usuario_Seleccionado" */

	/*
	 * En caso de buscar Empresas
	 */
	if ( isset($procesoParte) && $procesoParte == "Seleccion_Empresa"  && isset($companies) ){
?>

<!-- ================================================================================================================= -->
	<hr/>
	<div class="container">
		<div class="row">
			<div class="col-sm-12" align="right" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				<i>Empresas encontradas:</i> Seleccione una para continuar con el <b>Inventario</b>...
			</div>
		</div>
		<div id="no-more-tables">
			<table class="col-md-12 table-hover table-striped cf" style="font-size:12px;">
				<thead class="cf">
					<tr>
						<th align="center">ID Nº</th>
						<th>Nombre</th>
						<th>Raz&oacute;n Social</th>
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
						<td data-title="Razon Social" class="success"><?php echo $company["razonSocial"] . '<div style="color:#FFF;">.</div>'; ?></td>

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
			<div class="col-sm-12" align="center" style="">
				<br/>
				<button id="accept" type="button" class="btn btn-success btn-lg" onclick="javascript:seleccionarEmpresa();"
				 data-toggle="tooltip" data-placement="bottom" title="PRIMERO Seleccionar una EMPRESA y luego pulsar ESTE BOTÓN">
				   <span class="glyphicon glyphicon-briefcase"></span> Seleccionar Empresa</button>
			</div>
		</div>
	</div>
	
	<form class="form-horizontal" data-toggle="validator" role="form" id="search_userID_form" method="post"
	 enctype="multipart/form-data" action="<?= PROJECTURLMENU ?>admin/inventario_seleccionar_empresa">

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
			alert(" Debe SELECCIONAR una Empresa para continuar con el INVENTARIO del Equipo");

		} else {
			document.getElementById("search_userID_form").submit();
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

	/*
	 * En caso de buscar Empresas
	 */
	if ( isset($procesoParte) && $procesoParte == "Empresa_Seleccionada" ){
?>
<!-- ================================================================================================================= -->
	<div class="container">
		<div class="row" style="background-color:#F9B233;">
			<div class="col-sm-2" align="left">
				<b>Empresa Seleccionada:</b>
			</div>
			<div class="col-sm-8" align="left">
				<?php
					if ( isset($companyInfo) ){ echo $companyInfo; }
					if ( isset($searchedCompanyId) ){ echo " (ID: " . $searchedCompanyId . ")"; }
				?>
			</div>
			<div class="col-sm-2" align="left">
				<a href="<?= PROJECTURLMENU; ?>admin/nuevo_inventario">No usar esta Empresa</a>
			</div>
		</div>
		<div class="row" style="background-color:#F9B233;">
			<div class="col-sm-1" align="right">
				<b>Direcci&oacute;n:</b>
			</div>
			<div class="col-sm-7" align="left">
				<?php if ( isset($empresaDireccion) ){ echo $empresaDireccion; } ?>
			</div>
			<div class="col-sm-4" align="right">
				Nº de Equipos registrados de la Empresa: <?php if ( isset($empresaCantidadEquipos) ){ echo $empresaCantidadEquipos; } ?>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12" align="center">
				<br/>
				<h4 style="text-align:center; color:#E30513;">
					<span class="glyphicon glyphicon-blackboard"></span> 
					<b>Nuevo Inventario</b>: Nuevo Equipo para <span class="glyphicon glyphicon-briefcase"></span> <i><?php if ( isset($companyInfo) ){ echo $companyInfo; } ?></i>&nbsp;&nbsp;&nbsp;</h4>
			</div>
		</div>

<?php 	
		$formulario = "new_for_company";

		echo "<script>";
		echo '  var confirmMessage = "Se procederá a crear un NUEVO EQUIPO en el Sistema..."
					+ "\n\nPara la Empresa:  ' . $companyInfo . '"
					+ "\n\n\n ¿Desea continuar con el INVENTARIO? \n\n(Se necesitará los archivos \".CSV\" que genera el Script )";';
		echo "</script>";

	}/* "Empresa_Seleccionada" */
?>

<!-- ================================================================================================ -->
<?php
	if ( $formulario == "new_for_person" || $formulario == "new_for_company" ){
		/*
		 * imprimiendo UNA sola vez el formulario de EQUIPO NUEVO tanto para Usuario como para Empresa
		 */
?>
		
		<form data-toggle="validator" role="form" id="inventario_new_eq_form" method="post"
		 enctype="multipart/form-data" action="<?= PROJECTURLMENU ?>admin/inventario_nuevo_equipo">

			<input type="hidden" id="searchedEmpresaId" name="searchedEmpresaId" value="<?php if(isset($searchedEmpresaId)) echo $searchedEmpresaId; ?>" />
			<input type="hidden" id="companyInfo" 		name="companyInfo" 		 value="<?php if(isset($companyInfo)) 		echo $companyInfo; ?>" />
			<input type="hidden" id="searchedUserId" 	name="searchedUserId" 	 value="<?php if(isset($searchedId)) 		echo $searchedId; ?>" />
			<input type="hidden" id="searchedUserName"  name="searchedUserName"  value="<?php if(isset($searchedName)) 		echo $searchedName; ?>" />
			
			<br/>
			<hr/>
			<br/>
			<h4 style="text-align:center; color:#000;">
				<span class="glyphicon glyphicon-blackboard"></span> 
				<i>Datos del Equipo a ser Inventariado</i>&nbsp;&nbsp;&nbsp;
			</h4>
			<br/>

			<div id="equipoName-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>Nombre del Equipo</label>
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-header"></i></span>
						<input type="text" class="form-control" id="equipoName" name="equipoName"
						 placeholder="Nombre del Equipo (OPCIONAL). Ej: Equipo de RRHH, Equipo de Ana, etc.">
						<span id="equipoName-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-1">
					<div id="equipoName-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<div id="dependencia-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>Dependencia<b style="color:#E30513;font-size:18px;">*</b></label>
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-tower"></i></span>
						<input type="text" class="form-control" id="dependencia" name="dependencia" required="required" 
						 placeholder="Área de la Empresa o Dónde es usado. Ejemplo: Gerencia, Administración, RRHH, etc.">
						<span id="dependencia-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-1">
					<div id="dependencia-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<div id="marca-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>Marca del Equipo<b style="color:#E30513;font-size:18px;">*</b></label>
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-text-background"></i></span>
						<input type="text" class="form-control" id="marca" name="marca" required="required" 
						 placeholder="Marca del Equipo. Ej: Toshiba, Dell, HP, Sony, etc.">
						<span id="marca-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-1">
					<div id="marca-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<div id="modelo-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>Modelo del Equipo</label>
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-text-color"></i></span>
						<input type="text" class="form-control" id="modelo" name="modelo"
						 placeholder="El modelo del Equipo, generalmente acompaña la MARCA. Ejemplo: MOD1-PS6300">
						<span id="modelo-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-1">
					<div id="modelo-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<div id="serial-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>N&uacute;mero de Serie (Serial)</label>
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-sound-5-1"></i></span>
						<input type="text" class="form-control" id="serial" name="serial" required="required" 
						 placeholder="Número de Serie único del Equipo, normalmente está en una etiqueta frontal o trasera">
						<span id="serial-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-1">
					<div id="serial-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<div id="tipo_equipo-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label data-toggle="tooltip" data-placement="bottom" title="PRESENTACIÓN: Elija un tipo">
						<u>Tipo de Equipo</u><b style="color:#E30513;font-size:18px;">*</b></label>
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-blackboard"></i></span>
						<select class="form-control" id="tipo_equipo" name="tipo_equipo">
							<option value="none">  --  Seleccione un tipo de Presentación --  </option>
							<?php
								$option = "";
								$razon  = "";
								foreach ($tipoEquipos as $tipoEquipo){

									$option = '<option value="' . $tipoEquipo["tipoEquipoId"] . '">' . $tipoEquipo["nombre"] . '</option>';
									echo $option;
								}
							?>
						</select>
						<span id="tipo_equipo-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-1">
					<div id="tipo_equipo-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<div class="row form-group">
				<div class="col-sm-12">
					<div style="color:#E30513;text-align:right;"><b>* = Campo Obligatorio</b></div>
				</div>
			</div>
			
			<br/>
			<hr/>
			<br/>
			<h4 style="text-align:center; color:#000;">
				<span class="glyphicon glyphicon-cloud"></span> 
				<i>Conexi&oacute;n, Valor y m&aacute;s detalles</i>&nbsp;&nbsp;&nbsp;
			</h4>
			<br/>

			<div id="teamViewerID-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label data-toggle="tooltip" data-placement="bottom" title="9 digitos NUMÉRICOS">
						<u>TeamViewer ID</u><b style="color:#E30513;font-size:18px;">*</b></label>
				</div>
				<div class="col-sm-4">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-resize-horizontal"></i></span>
						<input type="text" class="form-control" id="teamViewerID" name="teamViewerID"
						 placeholder="(9 dígitos numéricos sin espacios)">
						 <span id="teamViewerID-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2" align="right">
					<label data-toggle="tooltip" data-placement="bottom" title="6 caracteres ALFA-NUMÉRICOS">
						<u>TeamViewer Clave</u><b style="color:#E30513;font-size:18px;">*</b>:</label>
				</div>
				<div class="col-sm-2" align="right">
					<input type="text" class="form-control" id="teamViewerClave" name="teamViewerClave" placeholder="Ejemplo: 123abc">
					<span id="teamViewerClave-span" class=""></span>
				</div>
				<div class="col-sm-1">
					<div id="teamViewerID-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<div id="remota-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label data-toggle="tooltip" data-placement="bottom" title="IP (fija) de Conexión Remota o Código de acceso remoto (de aplicaciones como join.me)">
						<u>Conexi&oacute;n Remota</u></label>
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-cloud-download"></i></span>
						<input type="text" class="form-control" id="remota" name="remota" 
						 placeholder="IP (fija) de Conexión Remota o Código de acceso remoto (de aplicaciones como join.me)">
						<span id="remota-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-1">
					<div id="remota-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<div id="clave-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>Clave del Administrador</label>
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
						<input type="text" class="form-control" id="clave" name="clave" 
						 placeholder="La clave de la cuenta tipo ADMINISTRADOR del Sistema Operativo">
						<span id="clave-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-1">
					<div id="clave-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<div id="costo-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>Valor del Equipo</label>
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
						<input type="text" class="form-control" id="costo" name="costo" 
						 placeholder="En pesos colombianos (COP) | SIN separador de miles | ',' separador decimales | (Ej: 123000,45)">
						<span id="costo-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-1">
					<div id="costo-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<div id="reposicion-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>Valor de Reposici&oacute;n</label>
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-euro"></i></span>
						<input type="text" class="form-control" id="reposicion" name="reposicion" 
						 placeholder="Valor de reponer del Equipo, en pesos (COP) SIN separador de miles (Ej: 123000,45) ',' es separador decimal">
						<span id="reposicion-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-1">
					<div id="reposicion-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<div id="observaciones-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>Observaciones Iniciales<b style="color:#E30513;font-size:18px;">*</b></label>
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-eye-open"></i></span>
						<input type="text" class="form-control" id="observaciones" name="observaciones" required="required" 
						 placeholder="Escriba sus Impresiones inicales. Ej: se ve en buen estado, es obsoleto, tiene carcasa rota, etc.">
						<span id="observaciones-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-1">
					<div id="observaciones-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<div id="link-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label data-toggle="tooltip" data-placement="bottom" title="Enlace URL Completo, solo acepta formatos .JPG, .JPEG, .GIF o .PNG"
					 onclick="javascript:$('#imgurModal').modal('show'); ;"
					 onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'">
						<u>Imagen de Equipo</u>
						<br/>
						(click aqu&iacute; para saber c&oacute;mo a&ntilde;adir im&aacute;genes)
					</label>
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-camera"></i></span>
						<input type="text" class="form-control" id="link" name="link" 
						 placeholder="Enlace completo a donde se guarda la Foto del Equipo. Ej: https://i.imgur.com/AQMJpDW.gif">
						<span id="link-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-1">
					<div id="link-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<div id="windows-div" class="form-group">
				<div class="col-sm-3" align="right">
					<label>Windows con Licencia<b style="color:#E30513;font-size:18px;">*</b></label>
				</div>
				<div class="col-sm-3">
					<div class="input-group">
						<label class="radio-inline">
						  <input type="radio" name="windows" id="windows" value="Si">
							S&iacute;
						</label>
						&nbsp;&nbsp;&nbsp;
						<label class="radio-inline">
						  <input type="radio" name="windows" id="windows" value="No">
							No
						</label>
						&nbsp;&nbsp;&nbsp;
						<label class="radio-inline">
						  <input type="radio" name="windows" id="windows" value="Desconocido">
							Desconocido
						</label>
					</div>
				</div>
				<div class="col-sm-6">
					<div id="windows-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<div id="office-div" class="form-group">
				<div class="col-sm-3" align="right">
					<label>Office con Licencia<b style="color:#E30513;font-size:18px;">*</b></label>
				</div>
				<div class="col-sm-3">
					<div class="input-group">
						<label class="radio-inline">
						  <input type="radio" name="office" id="office" value="Si">
							S&iacute;
						</label>
						&nbsp;&nbsp;&nbsp;
						<label class="radio-inline">
						  <input type="radio" name="office" id="office" value="No">
							No
						</label>
						&nbsp;&nbsp;&nbsp;
						<label class="radio-inline">
						  <input type="radio" name="office" id="office" value="Desconocido">
							Desconocido
						</label>
					</div>
				</div>
				<div class="col-sm-6">
					<div id="office-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>



			<div id="sistemaOperativo-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>
						Sistema Operativo<b style="color:#E30513;font-size:18px;">*</b>
					</label>
				</div>
				<div class="col-sm-4">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-sound-6-1"></i></span>
						<select class="form-control" id="sistemaOperativo" name="sistemaOperativo">
							<option value="none">  --  Seleccione uno --  </option>
							<option value="Windows">Windows</option>
							<option value="Linux/GNU">Linux/GNU</option>
							<option value="Mac">Mac</option>
							<option value="Solaris">Solaris</option>
							<option value="Unix">Unix</option>
							<option value="Google Chrome OS">Google Chrome OS</option>
							<option value="AS/400">AS/400</option>
							<option value="Otro">Otro</option>
						</select>
						<span id="sistemaOperativo-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2" align="right">
					<label data-toggle="tooltip" data-placement="bottom" title="El número de versión del Sistema Operativo, puede usar puntos, NO COMAS">
						<u>Versi&oacute;n N&uacute;mero</u><b style="color:#E30513;font-size:18px;">*</b>:</label>
				</div>
				<div class="col-sm-2" align="right">
					<input type="text" class="form-control" id="versionSO" name="versionSO" placeholder="Ejemplo: 8.1">
					<span id="versionSO-span" class=""></span>
				</div>
				<div class="col-sm-1">
					<div id="sistemaOperativo-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>


			<div id="nombreSO-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label data-toggle="tooltip" data-placement="bottom" title="Cómo obtenerlo"
					 onclick="javascript:$('#nombreSO_Modal').modal('show'); ;"
					 onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'">
						<u>Nombre del Sistema Operativo</u>
						<br/>
						(click aqu&iacute; para saber c&oacute;mo obtenerlo)
					</label>
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-registration-mark"></i></span>
						<input type="text" class="form-control" id="nombreSO" name="nombreSO" required="required" 
						 placeholder="Escriba el nombre según aparece en la Info o Configuración del Equipo">
						<span id="nombreSO-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-1">
					<div id="nombreSO-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>


			<div id="hdd-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label data-toggle="tooltip" data-placement="bottom" title="Puede usar el programa Crystal Disk o en su defecto, observación directa">
						Estado del Disco Duro<b style="color:#E30513;font-size:18px;">*</b></label>
				</div>
				<div class="col-sm-4">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-hdd"></i></span>
						<select class="form-control" id="hdd" name="hdd">
							<option value="none">  --  Seleccione uno --  </option>
							<option value="Bueno">Bueno</option>
							<option value="Regular">Regular</option>
							<option value="Malo">Malo</option>
						</select>
						<span id="hdd-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-5">
					<div id="hdd-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-12">
					<div style="color:#E30513;text-align:right;"><b>* = Campo Obligatorio</b></div>
				</div>
			</div>

<!-- =============================================================================================== -->
			<br/>
			<hr/>
			<br/>
			<h4 style="text-align:center; color:#000;">
				<span class="glyphicon glyphicon-headphones"></span> 
				<i>Listado de Perif&eacute;ricos para este Equipo</i>&nbsp;&nbsp;&nbsp;
			</h4>
			<br/>

			<div class="row">
				<div class="col-sm-12"  style="text-align:center;">
					<button id="addHW" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
						<span class="glyphicon glyphicon-plus"></span> 
						 Agregar otro Perif&eacute;rico a la lista
					</button>
				</div>
				<br/>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<table id="tableHardware" name="tableHardware" class="table table-hover table-striped" style="font-size: 12px;width:100%;">
						<thead>
							<tr>
								<th>Perif&eacute;rico id</th>
								<th>Nombre</th>
								<th>Marca</th>
								<th>C&oacute;digo de serie</th>
								<th>Observaciones / Descripci&oacute;n</th>
								<th>Eliminar Perif&eacute;rico</th>
							</tr>
						</thead>
						<tbody>
							<!--
							<tr>
								<td>q</td>
								<td>z</td>
								<td>123</td>
								<td>456</td>
							</tr>
							-->
						</tbody>
					</table>
				</div>
			</div>
			<!-- SALVAR los valores SERIALIZADOS por coma ',' de la tabla para el form.SUBMIT -->
			<input type="hidden" id="cantidad_perifericos" 		name="cantidad_perifericos" 	value="" />
			<input type="hidden" id="periferico_componente" 	name="periferico_componente"    value="" />
			<input type="hidden" id="periferico_marca" 			name="periferico_marca"   		value="" />
			<input type="hidden" id="periferico_codigo" 		name="periferico_codigo"  		value="" />
			<input type="hidden" id="periferico_observaciones"  name="periferico_observaciones" value="" />

			
			<br/><br/>
			<hr/>

			<div class="row">
				<div class="col-sm-12"  style="text-align:center;">
					<br/>
					Una vez completado el formulario, procurando que los datos que usted levant&oacute; de la 
					visita a la Empresa son los m&aacute;s exactos posibles, pulse el siguiente bot&oacute;n
					para crear un nuevo Equipo en el Portal 
					(en la siguiente pantalla usted podr&aacute; subir los archivos <b>.csv</b>
					<i>los generados por haber corrido el Script</i> en <b>ESTE Equipo</b>).
					<br/>
				</div>
				<br/>
			</div>
			<div class="row">
				<div class="col-sm-8" align="right">
					<br/>
					<button type="button" class="btn btn-success btn-lg" id="" onclick="javascript:crearEquipo();"
					 data-toggle="tooltip" data-placement="bottom" title="Crear un EQUIPO nuevo en el Sistema y continuar con el INVENTARIO (Scripts archivos .CSV)"
					 style="margin-top: 7px;">
						<span class="glyphicon glyphicon-hdd"></span> Crear Equipo y continuar con los archivos del Script <span class="glyphicon glyphicon-floppy-disk"></span> </button>
				</div>
				<div class="col-sm-4" align="left">
					<br/><br/>
					<a href="<?= PROJECTURLMENU; ?>admin/nuevo_inventario" class="btn btn-link">
						No crear un Equipo nuevo. Volver atr&aacute;s 
						<span class="glyphicon glyphicon-circle-arrow-left"></span> 
					</a>
				</div>
			</div>
		</form>
		<br/><br/><br/><br/>
	</div><!-- cerrando "container"-->
	<script>
		function crearEquipo(){

			var bool = true;

			limpiarEstilos();

			if ( $("#dependencia").val() == "" ){
				bool = false;
				
				document.getElementById("dependencia-div").className = "form-group has-error has-feedback";
				document.getElementById("dependencia-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("dependencia-error").innerHTML = "Quién/Dónde se usa";
			}
			if ( $("#marca").val() == "" ){
				bool = false;
				
				document.getElementById("marca-div").className = "form-group has-error has-feedback";
				document.getElementById("marca-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("marca-error").innerHTML = "Indique alguna";
			}
			/*
			if ( $("#serial").val() == "" ){
				bool = false;
				
				document.getElementById("serial-div").className = "form-group has-error has-feedback";
				document.getElementById("serial-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("serial-error").innerHTML = "Busquelo bien";
			}
			*/
			/* Tipo de Equipo combobox */
			if ( $("#tipo_equipo").val() == "none" ){
				
				bool = false;
				
				document.getElementById("tipo_equipo-div").className = "form-group has-error has-feedback";
				document.getElementById("tipo_equipo-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("tipo_equipo-error").innerHTML = "Seleccione uno";
			}

			var teamViewer_Id = $("#teamViewerID").val();
			
			/*
			 * Reemplazando los espacios en blanco
			 */
			teamViewer_Id = teamViewer_Id.replace(" ", "");
			teamViewer_Id = teamViewer_Id.replace(" ", "");

			if ( !isNumber (teamViewer_Id) || teamViewer_Id < 100000000 ){
				bool = false;
				
				document.getElementById("teamViewerID-div").className = "form-group has-error has-feedback";
				document.getElementById("teamViewerID-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("teamViewerID-error").innerHTML = "ID no parece válido";

			} else {
				$("#teamViewerID").val( teamViewer_Id );
			}

			var teamViewer_clave = $("#teamViewerClave").val();
			if ( teamViewer_clave == "" || teamViewer_clave.length < 4 ){
				bool = false;
				
				document.getElementById("teamViewerID-div").className = "form-group has-error has-feedback";
				document.getElementById("teamViewerClave-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("teamViewerID-error").innerHTML = "Clave NO puede ser vacía ni menor a 4 caracteres";
			}

			if ( $("#observaciones").val() == "" ){
				bool = false;
				
				document.getElementById("observaciones-div").className = "form-group has-error has-feedback";
				document.getElementById("observaciones-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("observaciones-error").innerHTML = "Indique algo";
			}

			/* validando ENLACE y FORMATOS */
			var linked = $("#link").val();
			if ( linked != "" && !linked.startsWith("http:") && !linked.startsWith("https:") ){
				bool = false;

				document.getElementById("link-div").className = "form-group has-error has-feedback";
				document.getElementById("link-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("link-error").innerHTML = "Enlace parece incorrecto";
			}
			if ( linked != "" && !linked.endsWith(".gif") && !linked.endsWith(".png") && !linked.endsWith(".jpg") && !linked.endsWith(".jpeg") ){
				bool = false;

				document.getElementById("link-div").className = "form-group has-error has-feedback";
				document.getElementById("link-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("link-error").innerHTML = "Solo formatos: JPG, JPEG, GIF o PNG";
			}

			/* validando radio buttons */
			var windows = $('input[type=radio][name=windows]:checked').val();
			var office  = $('input[type=radio][name=office]:checked').val();

			if ( windows == "Si" || windows == "No" || windows == "Desconocido" ){
				/* valores validos */
			} else {
				bool = false;
				document.getElementById("windows-div").className = "form-group has-error has-feedback";
				document.getElementById("windows-error").innerHTML = "Seleccione uno. 'No' si es Linux, MAC u otro Sistema Operativo.";
			}

			if ( office == "Si" || office == "No" || office == "Desconocido" ){
				/* valores validos */
			} else {
				bool = false;
				document.getElementById("office-div").className = "form-group has-error has-feedback";
				document.getElementById("office-error").innerHTML = "Seleccione uno. Valide si son herramientas ofimáticas Propietarias para Linux o MAC.";
			}

			/* Tipo de Equipo combobox */
			if ( $("#hdd").val() == "none" ){
				
				bool = false;
				
				document.getElementById("hdd-div").className = "form-group has-error has-feedback";
				document.getElementById("hdd-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("hdd-error").innerHTML = "Seleccione uno. Procure usar el Cristal-Info o si no observación directa";
			}

			//-reposicion
			var costo = $("#costo").val();
			costo = costo.replace("," , ".");

			if ( costo != "" && !isNumber (costo) ){
				
				bool = false;
				
				document.getElementById("costo-div").className = "form-group has-error has-feedback";
				document.getElementById("costo-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("costo-error").innerHTML = "Valor debe ser NUMÉRICO. Ej: 123000,45 (sin separador de miles y la COMA como separador decimal)";
			}

			var reposicion = $("#reposicion").val();
			reposicion = reposicion.replace("," , ".");

			if ( reposicion != "" && !isNumber (reposicion) ){
				
				bool = false;
				
				document.getElementById("reposicion-div").className = "form-group has-error has-feedback";
				document.getElementById("reposicion-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("reposicion-error").innerHTML = "Valor debe ser NUMÉRICO. Ej: 123000,45 (sin separador de miles y la COMA como separador decimal)";
			}

			/* Sistema Operativo */
			if ( $("#sistemaOperativo").val() == "none" ){
				
				bool = false;
				
				document.getElementById("sistemaOperativo-div").className = "form-group has-error has-feedback";
				document.getElementById("sistemaOperativo-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("sistemaOperativo-error").innerHTML = "Seleccione uno";
			
			}

			
			var versionSO = $("#versionSO").val();
			versionSO = versionSO.replace("," , ".");

			if ( !isNumber(versionSO) ){
				bool = false;
				
				document.getElementById("sistemaOperativo-div").className = "form-group has-error has-feedback";
				document.getElementById("versionSO-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("sistemaOperativo-error").innerHTML = "Valor debe ser NUMÉRICO. Ej: 123000,45 (sin separador de miles y la COMA como separador decimal)";

			} else {
				$("#versionSO").val( versionSO );
			}

			if ( bool == true ){
				var ask = confirm( confirmMessage );
				if ( ask == true) {
					/* serializando la tabla */
					csvTablaHTML();

					/* quitando el disabled */
					document.getElementById("costo").removeAttribute("disabled");
					document.getElementById("reposicion").removeAttribute("disabled");

					/* submit POST enviando formulario */
					document.getElementById("inventario_new_eq_form").submit();
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		/**
		 * Funcion que determina si el valor pasado como parametro es o no un NUMERO
		 * Maneja espacios en blanco y null
		 */
		function isNumber (o) {
			return ! isNaN (o-0) && o !== null && o !== "" && o !== false;
		}

		function limpiarEstilos(){
			document.getElementById("tipo_equipo-span").className = "";
			document.getElementById("tipo_equipo-div").className = "form-group";
			document.getElementById("tipo_equipo-error").innerHTML = "";

			document.getElementById("observaciones-span").className = "";
			document.getElementById("observaciones-div").className = "form-group";
			document.getElementById("observaciones-error").innerHTML = "";

			document.getElementById("teamViewerID-span").className = "";
			document.getElementById("teamViewerClave-span").className = "";
			document.getElementById("teamViewerID-div").className = "form-group";
			document.getElementById("teamViewerID-error").innerHTML = "";

			document.getElementById("serial-span").className = "";
			document.getElementById("serial-div").className = "form-group";
			document.getElementById("serial-error").innerHTML = "";

			document.getElementById("marca-span").className = "";
			document.getElementById("marca-div").className = "form-group";
			document.getElementById("marca-error").innerHTML = "";

			document.getElementById("dependencia-span").className = "";
			document.getElementById("dependencia-div").className = "form-group";
			document.getElementById("dependencia-error").innerHTML = "";

			document.getElementById("costo-span").className = "";
			document.getElementById("costo-div").className = "form-group";
			document.getElementById("costo-error").innerHTML = "";
			
			document.getElementById("reposicion-span").className = "";
			document.getElementById("reposicion-div").className = "form-group";
			document.getElementById("reposicion-error").innerHTML = "";

			document.getElementById("sistemaOperativo-div").className = "form-group";
			document.getElementById("sistemaOperativo-span").className = "";
			document.getElementById("versionSO-span").className = "";
			document.getElementById("sistemaOperativo-error").innerHTML = "";
		}

		function csvTablaHTML(){

			/* serializar la tabla dinámica */
			if ( cantidadPerifericos > 0 ){

				var comp   = "";
				var marca  = "";
				var codigo = "";
				var obser  = "";
				
				var table = document.getElementById("tableHardware");var aux="";

				/* iterate through rows */
				for (var i = 0, row; row = table.rows[i]; i++) {
	   
					/* saltando el titulo */
					if (i === 0) { continue; }

					/* rows would be accessed using the "row" variable assigned in the for loop */

					/* iterate through columns */
					for (var j = 0, col; col = row.cells[j]; j++) {
		 
						/* columns would be accessed using the "col" variable assigned in the for loop */
						aux = col.innerHTML;

						if(j===0){
							comp += aux + "," ;

						} else if(j===1){
							/* saltarse el nombre del periferico */

						} else if(j===2){
							marca += aux + "," ;

						} else if(j===3){
							codigo += aux + "," ;

						} else if(j===4){
							obser += aux + "," ;
						}
				   }
				}

				document.getElementById("periferico_componente").value 	 = comp;
				document.getElementById("periferico_marca").value 		 = marca;
				document.getElementById("periferico_codigo").value 		 = codigo;
				document.getElementById("periferico_observaciones").value= obser;
				
			}
		}
	</script>

	<!-- ========================= Modal HARDWARE =============================================== -->
	<div id="myModal" class="modal fade" role="dialog">

	  <div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Agregar nuevo Perif&eacute;rico</h4>
		  </div>
		  <div class="modal-body">
			
			<form id="formHardware">

				<div id="Periferico_Nombre-div" class="form-group">
					<label class="control-label col-sm-2" for="Periferico_Nombre">Nombre<span style="color:#E30513;">*</span></label>
					<div class="col-sm-8">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-headphones"></i></span>

							<select class="form-control" id="Periferico_Nombre" name="Periferico_Nombre">
								<option value="none">  --  Seleccione un tipo --  </option>
								<?php
									$option = "";
									foreach ($perifericos as $periferico){

										$option = '<option value="' . $periferico["id"] . '">' . $periferico["nombre"] . '</option>';
										echo $option;
									}
								?>
							</select>
							<span id="Periferico_Nombre-span" class=""></span>
						</div>
					</div>
					<div class="col-sm-2">
						<div id="Periferico_Nombre-error" class="help-block">
							&nbsp;
						</div>
					</div>
				</div>
				<br/><br/>
				<div id="Periferico_Marca-div" class="form-group">
					<label class="control-label col-sm-2" for="Periferico_Marca">Marca<span style="color:#E30513;">*</span></label>
					<div class="col-sm-8">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-text-background"></i></span>
							<input type="text" class="form-control" id="Periferico_Marca" name="Periferico_Marca" required="required"
							 placeholder="Marca. Ejemplo: DELL, Sony, Lenovo, Toshiba, HP, Samsung, etc.">
							<span id="Periferico_Marca-span" class=""></span>
						</div>
					</div>
					<div class="col-sm-2">
						<div id="Periferico_Marca-error" class="help-block">
							&nbsp;
						</div>
					</div>
				</div>
				<br/><br/>
				<div id="Periferico_Serial-div" class="form-group">
					<label class="control-label col-sm-2" for="Periferico_Serial">Nº de Serie<span style="color:#E30513;">*</span></label>
					<div class="col-sm-8">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-sound-5-1"></i></span>
							<input type="text" class="form-control" id="Periferico_Serial" name="Periferico_Serial" required="required"
							 placeholder="Nº de Serie, usualmente antecedido por 'Nº Serie', 'S/N', 'Serial No.', etc. ">
							<span id="Periferico_Serial-span" class=""></span>
						</div>
					</div>
					<div class="col-sm-2">
						<div id="Periferico_Serial-error" class="help-block">
							&nbsp;
						</div>
					</div>
				</div>
				<br/><br/>
				<div id="Periferico_Descripcion-div" class="form-group">
					<label class="control-label col-sm-2" for="Periferico_Descripcion">Observaciones / Descripci&oacute;n</label>
					<div class="col-sm-8">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-eye-open"></i></span>
							<input type="text" class="form-control" id="Periferico_Descripcion" name="Periferico_Descripcion"
							 placeholder="Indique alguna descripcion física o para qué se usa (observaciones)">
							<span id="Periferico_Descripcion-span" class=""></span>
						</div>
					</div>
					<div class="col-sm-2">
						<div id="Periferico_Descripcion-error" class="help-block">
							&nbsp;
						</div>
					</div>
				</div>
				<br/><br/>
				<div class="form-group">
					<div class="col-sm-12">
						<div style="color:#E30513;text-align:right;"><b>* = Campo Obligatorio</b></div>
						<br/><br/>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-12">
					<u>Nota 1</u>:
					es importante que si el Equipo, en el campo "Presentaci&oacute;n" (Tipo de Equipo)
					es marcado como <b>"Todo en Uno" o como "Port&aacute;til",
					NO se debe agregar un perif&eacute;rico del tipo "Monitor"</b> 
					puesto que los port&aacute;tiles y los Todo-en-uno vienen con el monitor integrado. 
					Si se marca la opci&oacute;n <b>"Servidor"</b> tambi&eacute;n se debe obviar el Monitor,
					pero en caso de que tenga se debe agregar como <i>"Otro" y a&ntilde;adir
					que es un monitor en el campo Descripci&oacute;n</i>.
					</div>
				</div>
			</form>

		  </div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-info"
				onclick="javascript:addComponentModal();return false;">
				  Agregar a lista de Perif&eacute;ricos
			  </button>
			   &nbsp;&nbsp;&nbsp;&nbsp;
			  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar sin agregar</button>
			</div>
		  </div>

	  </div>
	</div>

	<script>
		var cantidadPerifericos = 0;
		
		/**
		 * Añadiendo Componentes de HARDWARE
		 */	
		function addComponentModal(){

			limpiarEstilosModal();
			
			var x1 = $("#Periferico_Nombre").val();
			var x2 = document.getElementById("Periferico_Marca").value;
			var x3 = document.getElementById("Periferico_Serial").value;
			var x4 = document.getElementById("Periferico_Descripcion").value;

			var bool = true;
			
			if ( x1 == "none" ){
				bool = false;
				document.getElementById("Periferico_Nombre-div").className = "form-group has-error has-feedback";
				document.getElementById("Periferico_Nombre-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("Periferico_Nombre-error").innerHTML = "Seleccione uno";
			}

			if ( x2 == "" ){
				bool = false;
				document.getElementById("Periferico_Marca-div").className = "form-group has-error has-feedback";
				document.getElementById("Periferico_Marca-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("Periferico_Marca-error").innerHTML = "No debe ser vacío";
			}

			if ( x3 == "" ){
				bool = false;
				document.getElementById("Periferico_Serial-div").className = "form-group has-error has-feedback";
				document.getElementById("Periferico_Serial-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("Periferico_Serial-error").innerHTML = "No debe ser vacío";
			}

			/*
			 * Comparar Monitor "1"
			 * contra tipo de Equipo {Todo-en-uno, Laptop o Portátil, Servidor}
			 */
			if ( x1 == "1"
					&& ($("#tipo_equipo").val() == "1" || $("#tipo_equipo").val() == "3" || $("#tipo_equipo").val() == "4") ){

				bool = false;
				document.getElementById("Periferico_Nombre-div").className = "form-group has-error has-feedback";
				document.getElementById("Periferico_Nombre-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("Periferico_Nombre-error").innerHTML = "Opción NO válida (ver Nota abajo)";
			}
			
			/* Si hay *campos vacíos, NO esconder Modal */
			if ( bool == false ){
				$('#myModal').modal({
					backdrop: 'static',
					keyboard: false,
					show: true
				});

			} else {
				/*
				 * sumando 1 al CONT de la lista 
				 * y guardandolo en variable HIDDEN
				 */
				cantidadPerifericos++;
				document.getElementById("cantidad_perifericos").value = cantidadPerifericos;

				/*
				 * Añadiendo a la TABLA
				 */
				var table = document.getElementById("tableHardware");
				var row = table.insertRow(cantidadPerifericos);

				var cell0 = row.insertCell(0);
				var cellA = row.insertCell(1);
				var cell1 = row.insertCell(2);
				var cell2 = row.insertCell(3);
				var cell3 = row.insertCell(4);
				var cell4 = row.insertCell(5);

				/* Obtiene el ID y el nombre del Periferico que vienen del combobox */
				cell0.innerHTML = "" + x1;
				cellA.innerHTML = "" +  $( "#Periferico_Nombre option:selected" ).text();

				/*
				 * Se elimina la coma ',' y se reemplaza por ';' por si el usuario escribe comas
				 * NO se permiten las comas porque luego se serializará la tabla y se enviará así "1,2,3,4" por el $_POST
				 */
				x2 = x2.replace(/,/gi, ";");/* reemplazo g-global | gi-case_insensitive https://www.w3schools.com/jsref/jsref_replace.asp  */
				x3 = x3.replace(/,/gi, ";");
				x4 = x4.replace(/,/gi, ";");

				cell1.innerHTML = "" + x2;
				cell2.innerHTML = "" + x3;
				cell3.innerHTML = "" + x4;
				cell4.innerHTML = '<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Eliminar esta entrada" onclick="javascript:eliminarEntradaPeriferico(\'' + x1+x2+x3 + '\');"><span class="glyphicon glyphicon-trash"></span></button>'
				;
				
				/*
				 * limpiando formulario para añadir un siguiente
				 */
				$('#Periferico_Nombre option[value="none"]').attr("selected", "selected");

				document.getElementById("Periferico_Marca").value  = ""; 
				document.getElementById("Periferico_Serial").value = "";
				document.getElementById("Periferico_Descripcion").value = "";

				$('#myModal').modal('hide');

				limpiarEstilosModal();
			}
		}
		
		function limpiarEstilosModal(){

			document.getElementById("Periferico_Nombre-span").className = "";
			document.getElementById("Periferico_Nombre-div").className = "form-group";
			document.getElementById("Periferico_Nombre-error").innerHTML = "";

			document.getElementById("Periferico_Serial-span").className = "";
			document.getElementById("Periferico_Serial-div").className = "form-group";
			document.getElementById("Periferico_Serial-error").innerHTML = "";

			document.getElementById("Periferico_Marca-span").className = "";
			document.getElementById("Periferico_Marca-div").className = "form-group";
			document.getElementById("Periferico_Marca-error").innerHTML = "";
		}

		/**
		 * Eliminar una fila de una tabla HTML
		 */
		function eliminarEntradaPeriferico( textoAencontrar ){
		
			var ask = confirm("¿Seguro de eliminar esta entrada de Periférico?");

			if ( ask == true) {
				var aux = "";
				var i = 0;
				/*
				 * Recorrido de tabla HTML usando Javascript para obtener valores
				 */
				for ( i=1; i < document.getElementById('tableHardware').rows.length -1; i++){

					aux ="" + document.getElementById('tableHardware').rows[i].cells[0].innerHTML
							+ document.getElementById('tableHardware').rows[i].cells[2].innerHTML
							+ document.getElementById('tableHardware').rows[i].cells[3].innerHTML;

					if ( textoAencontrar == aux ){
						break;
					}
				}

				document.getElementById( "tableHardware" ).deleteRow( i );
				
				/* Actualizar la cantidad */
				cantidadPerifericos--;
				document.getElementById("cantidad_perifericos").value = cantidadPerifericos;
			}
		}
	</script>

<?php
	}/* "new_for_person" || "new_for_company" */
?>


<!-- ========================= Modal subir imagenes a IMGUR =============================================== -->
<div class="modal fade" id="imgurModal" role="dialog">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title" align="center">
			<span class="glyphicon glyphicon-camera"></span> 
			Subir im&aacute;gens a IMGUR.com y a&ntilde;adirlas ac&aacute; 
			<span class="glyphicon glyphicon-picture"></span> 
		  </h4>
		</div>
		<div class="modal-body" style="font-size:16px;">
		  <p style="font-size:18px;">
		  	Para llenar este campo se debe realizar los siguientes pasos:
		  </p>
		  <br/>
		  1.- Ingresar a <a href="https://imgur.com/" target="_blank">https://imgur.com/</a> &nbsp;&nbsp;
		  (la URL directa a nuestra cuenta es https://lanuzagroup.imgur.com)
		  <br/>
		  2.- Ingresar en la Cuenta de LanuzaGroup, las credenciales son:
		  <br/><br/>
		  &nbsp;&nbsp;&nbsp;&nbsp;Usuario: <b>LanuzaGroup</b>
		  <br/>
		  &nbsp;&nbsp;&nbsp;&nbsp;Password: <b>l4nuz41m6ur</b> &nbsp;&nbsp; (Favor <b>NO cambiar la clave</b>)
		  <br/><br/>
		  3.- Pulsar el bot&oacute;n "<b>Add Images</b>" (a&ntilde;adir im&aacute;genes)
		  <br/>
		  4.- Tener a la mano una FOTO del Equipo (<b>solo acepta formatos .JPG, .JPEG, .GIF o .PNG</b>)
		  <br/>
		  5.- Navegar en la Computadora o Celular hasta la carpeta donde est&aacute; la FOTO, 
		  o tambi&eacute;n es posible ARRASTRAR-Y-SOLTAR 
		  <br/>
		  6.- Espere a que termine de cargar (la barra superior verde indica el progreso de upload)
		  <br/>
		  7.- Al ver que se a&ntilde;adi&oacute; la nueva FOTO, darle un click. 
		  Aparecer&aacute; una ventana modal donde 
		  le permitir&aacute; ver varios enlaces de la misma IMAGEN
		  <br/><br/>
		  8.- De esos enlaces, <b>COPIE</b> el que dice "<b>Direct Link</b>" 
		  { f&iacute;jese que ése tiene la direcci&oacute;n completa,
		  <b>desde el protocolo (http/https) hasta el formato de la imagen (.JPG, .JPEG, .GIF o .PNG)</b> }
		  <br/><br/>
		  9.- Una vez copiado ese enlace {<b>Control-C o a trav&eacute;s del bot&oacute;n "Copy Link"</b>} 
		  debe <b>PEGARLO {Control-V}</b> en este campo <i>Imagen de Equipo</i>
		  <br/><br/><br/>
		  10.- Si NO tiene a la mano la foto de este Equipo, este proceso tambi&eacute;n puede hacerlo en
		  el men&uacute; <b>Equipos</b>, opci&oacute;n <b>Actualizar Inventario de un Equipo</b>.
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		</div>
	  </div>
	</div>
</div>



<!-- ========================= Modal subir imagenes a IMGUR =============================================== -->
<div class="modal fade" id="nombreSO_Modal" role="dialog">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title" align="center">
			<span class="glyphicon glyphicon-sound-6-1"></span>
			C&oacute;mo obtener el nombre del Sistema Operativo 
			<span class="glyphicon glyphicon-registration-mark"></span> 
		  </h4>
		</div>
		<div class="modal-body" style="font-size:16px;">
		  <p style="font-size:18px;">
		  	En sistemas <b><u>Windows</u></b>:
		  </p>
		  <br/>
		  1.- Pulse las teclas WINDOWS + Pausa | o En su defecto en el bot&oacute;n Inicio - Panel de Control - Sistema
		  <br/>
		  2.- Coloque aquí el nombre que ve en dicha ventana, como ejemplo abajo, se extrae la info:
		  <br/><br/>
		  <b>Home Premium</b>
		  <br/><br/>
		  (<b>NO se coloca</b> Windows 7 ya que esa informaci&oacute;n va en el campo 
		  	<b>"Sistema Operativo" y "Versi&oacute;n"</b>)
		  <br/><br/>
		  <img id="imgX" alt="Codigo de barras generado" src="<?= APPIMAGEPATH; ?>windows_version.png" />
		  
		  <br/><br/><br/>

		  En <b><u>Linux</u></b>:
		  <br/>
		  1.- Se debe añadir el nombre de la <b>Distribuci&oacute;n</b>
		  <br/>
		  2.- Lo puede descubrir con alguno de estos comandos o archivos:
		  <br/>
			a] Archivo <b>/etc/*-release</b>
		  <br/>
			b] Comando <b>lsb_release</b>
		  <br/>
			c] Archivo <b>/proc/version</b>
		  <br/>
		  M&aacute;s info consulte: 
		  	<a href="https://www.cyberciti.biz/faq/find-linux-distribution-name-version-number/" target="_blank">
		  		https://www.cyberciti.biz/faq/find-linux-distribution-name-version-number/</a>
		  
		  <br/><br/><br/>

		  En <b><u>MAC</u></b>:
		  <br/>
		  1.- En <b>bot&oacute;n MAC</b> - seleccionar la opci&oacute;n <b>"About this Mac"</b> (Acerca de esta Mac)
		  <br/>
		  2.- Coloque el nombre completo en ESTE campo. El n&uacute;mero de Versi&oacute;n arriba
		   (NO coloque el n&uacute;mero de compilaci&oacute;n o Build).
		  <br/>
		  M&aacute;s info consulte: 
		  	<a href="https://support.apple.com/en-us/HT201260" target="_blank">
		  		https://support.apple.com/en-us/HT201260</a>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		</div>
	  </div>
	</div>
</div>