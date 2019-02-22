<?php 
	/*
	 * En esta seccion se buscará un Usuario
	 */
	if ( isset($procesoParte) 
			&& ($procesoParte == "Busqueda_Empresa" || $procesoParte == "Seleccion_Empresa") ){
		
		echo "<script>";
		echo " var searchURL = '" . PROJECTURLMENU . "admin/buscar';" ;
		echo "</script>";
?>
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

	<div class="row">
		<div class="col-sm-12" align="center" style="padding: 12px 20px 12px 40px; font-size: 18px;">
			Buscar una <u>Empresa</u>:
		</div>		
	</div>

<!-- ================================================================================================================= -->
	<hr/>

	<form class="form-horizontal" data-toggle="validator" role="form" id="search_company_form" method="post"
	 enctype="multipart/form-data" action="<?= PROJECTURLMENU ?>admin/seleccionar_empresa">

	 	<input type="hidden" id="redireccionarA" name="redireccionarA" value="<?php if(isset($redireccionarA)) echo $redireccionarA; ?>" />
		
		<h4 style="text-align:center; color:#E30513;">
			<span class="glyphicon glyphicon-briefcase"></span> 
			&rarr; 
			Nota: <i>Buscar Empresa por Nombre, Raz&oacute;n Social, NIT, Email o direcci&oacute;n... y presione ENTER (3 CARACTERES al menos)</i>
		</h4>
		
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

		$("#searchCompany").on('keyup', function (e) {
			if (e.keyCode == 13) {
				/* al presionar ENTER */
				if ( $("#searchCompany").val().length >= 3 ){

					document.getElementById("search_company_form").action = searchURL;

				} else {
					alert('Indique al menos 3 letras');
					return false;
				}
			}
		});

	});

</script>

<?php 
	}/* "Busqueda_Empresa" */

	/* Año actual */
	$year = date('Y', time());

	/*
	 * En caso de buscar Empresas
	 */
	if ( isset($procesoParte) && $procesoParte == "Seleccion_Empresa"  && isset($companies) ){

		$opcionesExtrasUrl = "";
		if ( $redireccionarA == "reporte_dashboard" || $redireccionarA == "reporte_equipos" ){
			$opcionesExtrasUrl = "/" . $year;
		}

		echo "<script>";
		echo " var URL = '" . PROJECTURLMENU . "admin/" . $redireccionarA . $opcionesExtrasUrl . "';" ;
		echo "</script>";
?>

<!-- ================================================================================================================= -->
	<hr/>
	<div class="container">
		<div class="row">
			<div class="col-sm-12" align="right" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				<i>Empresas encontradas:</i> Seleccione una para continuar...
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
					<?php foreach ( $companies as $company ) { ?>
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

						<td data-title="ciudad" class="success" ><?= $company["ciudad"] . '<div style="color:#FFF;">.</div>'; ?></td>
						<td data-title="Dpto./Edo." class="success" ><?= $company["departamento_Estado"] . '<div style="color:#FFF;">.</div>'; ?></td>
						<td data-title="Pa&iacute;s" class="success" ><?= $company["pais"] . '<div style="color:#FFF;">.</div>'; ?></td>

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

		<br/><br/>

		<div class="row">
			<div class="col-sm-12" align="center" style="">
				<button id="accept" type="button" class="btn btn-success btn-lg" onclick="javascript:seleccionarEmpresa();"
				 data-toggle="tooltip" data-placement="bottom" title="PRIMERO Seleccionar una EMPRESA y luego pulsar ESTE BOTÓN">
				   <span class="glyphicon glyphicon-briefcase"></span> Seleccionar Empresa</button>
			</div>
		</div>

		<br/><br/>

		<div class="row">
			<div class="col-sm-12" align="center" style="">
				Al presionar el bot&oacute;n redireccionar&aacute; a: 
				<b>
<?php
					if ( $redireccionarA == "reporte_dashboard" ){
						echo "Reporte 'Dashboard' de la Empresa seleccionada";

					} else if ( $redireccionarA == "reporte_incidencias" ){
						echo "Reporte 'Incidencias' de la Empresa seleccionada";

					} else if ( $redireccionarA == "reporte_equipos" ){
						echo "Reporte 'Equipos' de la Empresa seleccionada";

					} else if ( $redireccionarA == "historialEquipos" ){
						echo "Reporte trabajos realizados a 'Equipos' de la Empresa seleccionada";
					
					} else if ( $redireccionarA == "licencias" ){
						echo "Reporte Inventario de Licencias de los Equipos de la Empresa seleccionada";
					}
?>
				</b>.
			</div>
		</div>

		<br/><br/>

	</div>
	
	<form class="form-horizontal" data-toggle="validator" role="form" id="search_companyID_form" method="post"
	 enctype="multipart/form-data" action="">

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
			alert(" Debe SELECCIONAR una Empresa para continuar...");

		} else {
			document.getElementById("search_companyID_form").action = URL;
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
	} /* "Seleccion_Empresa" */
?>	