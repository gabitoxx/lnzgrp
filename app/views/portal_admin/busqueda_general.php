<?php 
	function startsWith($haystack, $needle)
	{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}

	function endsWith($haystack, $needle)
	{
		$length = strlen($needle);

		return $length === 0 || 
		(substr($haystack, -$length) === $needle);
	}
?>


<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-indent-left logo slideanim"></span>
	<i>Buscar registros en el Sistema: Portal LanuzaGroup</i>&nbsp;&nbsp;&nbsp;
</h4>

<?php
	$footer = "*Esta informaci&oacute;n es concerniente a la Empresa LanuzaGroup y NO debe ser usada 
			con otros fines m&aacute;s all&aacute; del alcance de los Soportes T&eacute;cnicos 
			contratados con la Empresa y NO para divulgaci&oacute;n p&uacute;blica.";
?>
<div class="container">

	<form class="form-horizontal" data-toggle="validator" role="form" id="busqueda_general_form" method="post"
	 enctype="multipart/form-data" action="<?= PROJECTURLMENU ?>admin/busqueda_general">

		<div class="row">
			<div class="col-sm-12" align="center" style="padding: 12px 20px 12px 40px; font-size: 18px; color: #E30513;">
				<b>Buscar</b>: <i>Seleccione un "Objeto" a buscar, indique las opciones o palabras claves y presione ENTER</i>.
			</div>
		</div>

		<hr/>

		<div class="row">
			<div class="col-sm-3" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				Especifique, Qu&eacute; desea buscar:
			</div>
			<div class="col-sm-2" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				<label>
					<input type="radio" id="search_type" name="search_type" value="personas" onclick="javascript:mostrar('personas');"
					 <?php if($opcion == "personas") echo ' checked="checked" ' ?>
					 > 
					Personas
				</label>
			</div>
			<div class="col-sm-2" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				<label>
					<input type="radio" id="search_type" name="search_type" value="empresas" onclick="javascript:mostrar('empresas');"
					 <?php if($opcion == "empresas") echo ' checked="checked" ' ?>
					 > 
					Empresas
				</label>
			</div>
			<div class="col-sm-2" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				<label>
					<input type="radio" id="search_type" name="search_type" value="equipos" onclick="javascript:mostrar('equipos');"
					 <?php if($opcion == "equipos") echo ' checked="checked" ' ?>
					 > 
					Equipos
				</label>
			</div>
			<div class="col-sm-3" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				<label>
					<input type="radio" id="search_type" name="search_type" value="incidencias" onclick="javascript:mostrar('incidencias');" 
					 <?php if($opcion == "incidencias") echo ' checked="checked" ' ?>
					 >
					Incidencias/Reportes
				</label>
			</div>
		</div>

		<!-- ================================================================================================== -->
		<div id="personas" class="row well well-lg">
			<hr/>
			<div class="row">
				<div class="col-sm-12" align="right" style="padding: 12px 20px 12px 40px; font-size: 16px;">
					<b>Personas:</b> para buscar <b>"Usuarios" o "Partners"</b>, puede indicar <u>una palabra clave</u>, 
					puede ser: su Nombre, Apellido, Email, Username o Dependencia; o por la Empresa donde labora (Nombre, Raz&oacute;n social o NIT). 
					Incluso si lo conoce, puede indicar su <b>ID del Sistema</b> (valor netamente num&eacute;rico) del usuario a buscar.
				</div>
			</div>
			<div class="row">
				<div class="col-sm-10">
					<input type="text" name="searchPersons" id="searchPersons" class="search" placeholder="Buscar Usuarios o Partners registrados en el Portal, indique palabra(s) clave... y presione ENTER (3 CARACTERES al menos)"
					 <?php if ( isset($searchedPersons) ) echo 'value="' . $searchedPersons . '"'; ?>
					 >
				</div>
				<div class="col-sm-2">
					<span style="background-color:yellow;">y presione ENTER</span>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12" align="center">
					<br/><br/>
					<button type="button" class="btn btn-primary"
					 data-toggle="tooltip" data-placement="bottom" title="Listar todos los Usuarios del Sistema, se ordenará por Empresa luego por Nombre"
					 onclick="javascript:searchAll('personas');"
					 >
						<span class="glyphicon glyphicon-sort-by-alphabet"></span> Ver todos los Usuarios
					</button>
				</div>
			</div>
		</div>


		<!-- ================================================================================================== -->
		<div id="empresas" class="row well well-lg">
			<hr/>
			<div class="row">
				<div class="col-sm-12" align="right" style="padding: 12px 20px 12px 40px; font-size: 16px;">
					<b>Empresas:</b> para buscar <b>"Empresas"</b> registradas en el Sistema, puede indicar <u>una palabra clave</u>, 
					puede ser: Nombre de la Compa&ntilde;&iacute;a, su Raz&oacute;n social, NIT o Tel&eacute;fono. 
					Incluso si lo conoce, puede indicar su <b>ID del Sistema</b> (valor netamente num&eacute;rico) de la Empresa a buscar.
				</div>
			</div>
			<div class="row">
				<div class="col-sm-10">
					<input type="text" name="searchCompanies" id="searchCompanies" class="search" placeholder="Buscar Empresas registradas en el Portal, indique palabra(s) clave... y presione ENTER (3 CARACTERES al menos)"
					 <?php if ( isset($searchedCompanies) ) echo 'value="' . $searchedCompanies . '"'; ?>
					 >
				</div>
				<div class="col-sm-2">
					<span style="background-color:yellow;">y presione ENTER</span>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12" align="center">
					<br/><br/>
					<button type="button" class="btn btn-primary"
					 data-toggle="tooltip" data-placement="bottom" title="Listar todas las Compañías del Sistema, se ordenarán por Nombre de Empresa"
					 onclick="javascript:searchAll('empresas');"
					 >
						<span class="glyphicon glyphicon-sort-by-alphabet"></span> Ver todas las Empresas
					</button>
				</div>
			</div>
		</div>


		<!-- ================================================================================================== -->
		<div id="equipos" class="row well well-lg">
			<hr/>
			<div class="row">
				<div class="col-sm-12" align="left" style="padding: 12px 20px 12px 40px; font-size: 16px;">
					<b>Equipos:</b> para buscar <b>"Equipos"</b> registrados en el Sistema, puede indicar
					las siguientes opciones:
					<br/><br/>
					<span style="background-color:#F9B233;">
						1.- La manera m&aacute;s directa de encontrar un Equipo en particular 
						es introduciendo el <b>C&oacute;digo de Barras</b> del Equipo, ya que es el 
						identificador &uacute;nico que otorga LanuzaGroup a cada equipo.
					</span>
					<br/><br/>
					2.- Puede <i>Filtrar</i> por tipo de Equipo (si desea, puede seleccionar uno de la lista). 
					Aunque usando solo esta opci&oacute;n puede encontrar much&iacute;simos Equipos...
					<br/><br/>
					3.- Puede tambi&eacute;n <i>Filtrar</i> por <u>una palabra clave</u>, la cual puede ser: 
					nombre del Sistema Operativo (Windows 8, Windows 10, Linux, etc.) 
					o si lo prefiere filtrar por:
					<br/>
					&nbsp;&nbsp;&nbsp;
					- <b>Usuario del Equipo</b> (Nombre, Apellido, Email o Username); o
					<br/>
					&nbsp;&nbsp;&nbsp;
					- <b>Empresa due&ntilde;a del Equipo</b> (Nombre, Raz&oacute;n social o NIT).
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-sm-4" align="right">
					<span id="filtrarTipo">Filtrar</span> por Tipo de Equipo (opcional):
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-blackboard"></i></span>
						<select class="form-control" id="tipo_equipo" name="tipo_equipo">
							<option value="none">  --  Seleccione uno --  </option>
							<?php
								$option = "";
								foreach ($tipoEquipos as $tipoEquipo){

									$option = '<option value="' . $tipoEquipo["tipoEquipoId"] . '">' . $tipoEquipo["nombre"] . '</option>';
									echo $option;
								}
							?>
						</select>
					</div>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-sm-10">
					<input type="text" name="searchEquipos" id="searchEquipos" class="search" placeholder="Buscar Equipos, indique palabra(s) clave según las instrucciones de arriba... y presione ENTER (3 CARACTERES al menos)"
					 <?php if ( isset($searchedEquipos) ) echo 'value="' . $searchedEquipos . '"'; ?>
					 >
				</div>
				<div class="col-sm-2">
					<span style="background-color:yellow;">y presione ENTER</span>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-sm-12" align="center">
					<br/><br/>
					<button type="button" class="btn btn-primary"
					 data-toggle="tooltip" data-placement="bottom" title="Listar todos los Equipos del Sistema, se ordenarán por Nombre de Empresa"
					 onclick="javascript:searchAll('equipos');"
					 >
						<span class="glyphicon glyphicon-sort-by-alphabet"></span> Ver todos los Equipos
					</button>
				</div>
			</div>
		</div>


		<!-- ================================================================================================== -->
		<div id="incidencias" class="row well well-lg">
			<hr/>
			<div class="row">
				<div class="col-sm-12" align="left" style="padding: 12px 20px 12px 40px; font-size: 16px;">
					<b>Incidencias/Reportes de Visita:</b> para buscar <b>"Incidencias"</b> o <b>"Reportes"</b> 
					registradas en el Sistema, puede indicar
					SOLO UNA de las siguientes opciones:
					<br/><br/>
					<span style="background-color:#F9B233;">
						1.- La manera m&aacute;s directa de encontrar una Incidencia en particular 
						es introduciendo el <b>#ID de la Incidencia/Reporte</b>, ya que es el 
						identificador &uacute;nico que otorga el Portal LanuzaGroup a dicho inconveniente registrado.
					</span>
					<br/><br/>
					2.- Puede <i>Filtrar</i> por <u>una palabra clave</u>, la cual puede ser: 
					nombre del <b>Usuario o Partner</b> afectado (Nombre, Apellido, Email o Username) 
					o <b>Empresa</b> afectada (Nombre, Raz&oacute;n social o NIT).
					<br/><br/>
					3.- Puede realizar la b&uacute;squeda por <b>alguna(s) de las palabra(s) clave(s) de la(s) soluciones</b> brindadas por los 
					Ingenieros de Soporte. Se proceder&aacute; a buscar en los registros de: 
					<i>
						variables End&oacute;genas, variable Ex&oacute;genas T&eacute;cnicas,
						variables Ex&oacute;genas Humanas,
						mantenimientos de Hardware, mantenimientos de Software y/o acompa&oacute;amientos Junior.
					</i>
					<br/><br/>
					<span style="background-color:#F9B233;">
						4.- Para hacer b&uacute;squeda por <b>FECHAS</b> debe seguir las siguientes indicaciones exactas:
					</span>
					
					<br/>
					4.1.- Debe escribir las fechas en formato <b>AAAA-MM-DD</b> (a&ntilde;o-mes-d&iacute;a). Ejemplo: "2017-12-31", para el 31 de diciembre del año 2017
					<br/>
					4.2.- Debe escribir <b>la primera letra con el tipo de B&uacute;squeda deseado; luego dejar un espacio en blanco</b>. 
					para la(s) fecha(s). Los tipos de b&uacute;squeda posibles son:
					<br/>					

					<table border="1" style="font-size: 14px;">
						<tr>
							<thead>
								<th align="center" style="text-align: center;">&nbsp;Letra&nbsp;</th>
								<th>Descripci&oacute;n</th>
								<th align="center" style="text-align: center;">Ejemplo</th>
							</thead>
						</tr>
						<tr>
							<td align="center" style="text-align: center;">A</td>
							<td>
								Para la b&uacute;squeda por <i>un d&iacute;a en particular, la fecha de Creaci&oacute;n exacta</i> de Incidencias.
							</td>
							<td align="center" style="text-align: center;">
								<b>A 2017-06-22</b>
								<br/>(esto buscar&iacute;a las Incidencias creadas el 22 de junio del a&ntilde;o 2017).
							</td>
						</tr>
						<tr>
							<td align="center" style="text-align: center;">B</td>
							<td>
								Para la b&uacute;squeda por <i>un d&iacute;a en particular, la fecha exacta de &uacute;ltima Actualizaci&oacute;n</i> de Incidencias.
							</td>
							<td align="center" style="text-align: center;">
								<b>B 2017-10-03</b>
								<br/>(esto buscar&iacute;a las Incidencias actualizadas el 3 de octubre del a&ntilde;o 2017).
							</td>
						</tr>
						<tr>
							<td align="center" style="text-align: center;">C</td>
							<td>
								Para la b&uacute;squeda por <i>rango de fechas de Creaci&oacute;n</i> de Incidencias.
							</td>
							<td align="center" style="text-align: center;">
								<b>C 2017-09-01 2017-09-30</b>
								<br/>(esto buscar&iacute;a las Incidencias creadas en septiembre del 2017, las fechas deben estar separadas por un espacio en blanco).
							</td>
						</tr>
						<tr>
							<td align="center" style="text-align: center;">D</td>
							<td>
								Para la b&uacute;squeda por <i>rango de fechas de &uacute;ltima Actualizaci&oacute;n</i> de Incidencias.
							</td>
							<td align="center" style="text-align: center;">
								<b>D 2017-12-01 2017-12-31</b>
								<br/>(esto buscar&iacute;a las Incidencias actualizadas en diciembre del 2017, las fechas deben estar separadas por un espacio en blanco).
							</td>
						</tr>
					</table>

					<br/>
					<span id="filtrarTipo">Puede</span> tambi&eacute;n <i>Filtrar</i> por tipo de Incidencia (si desea, puede seleccionar uno de la lista). 
					Se recomienda ayudarse con palabras claves, ya que usando solo esta opci&oacute;n puede encontrar much&iacute;simas incidencias...
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<b>Seleccione primero cu&aacute;l Tipo de B&uacute;squeda realizar&aacute;:</b>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label>
						<input type="radio" id="search_incidencia_type" name="search_incidencia_type"
						 value="1" onclick="javascript:cambiarPlaceholder(1);"
<?php 						if(isset($searchedTipo1al4) && $searchedTipo1al4 == "1") echo 'checked="checked"'; ?>
						 > 
							Tipo 1 (#ID)
					</label>
				</div>
				<div class="col-sm-3">
					<label>
						<input type="radio" id="search_incidencia_type" name="search_incidencia_type"
						 value="2" onclick="javascript:cambiarPlaceholder(2);"
<?php 						if(isset($searchedTipo1al4) && $searchedTipo1al4 == "2") echo 'checked="checked"'; ?>
						 > 
							Tipo 2 (Persona o Empresa)
					</label>
				</div>
				<div class="col-sm-3">
					<label>
						<input type="radio" id="search_incidencia_type" name="search_incidencia_type"
						 value="3" onclick="javascript:cambiarPlaceholder(3);"
<?php 						if(isset($searchedTipo1al4) && $searchedTipo1al4 == "3") echo 'checked="checked"'; ?>
						 > 
							Tipo 3 (palabras clave en Reportes)
					</label>
				</div>
				<div class="col-sm-4">
					<label>
						<input type="radio" id="search_incidencia_type" name="search_incidencia_type"
						 value="4" onclick="javascript:cambiarPlaceholder(4);"
<?php 						if(isset($searchedTipo1al4) && $searchedTipo1al4 == "4") echo 'checked="checked"'; ?>
						 > 
							Tipo 4 (por Fechas)
					</label>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-sm-3" align="right" style="text-align: right;">
					Filtrar por Tipo de Incidencia:
				</div>
				<div class="col-sm-9">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-fire"></i></span>
						<select class="form-control" id="tipo_falla" name="tipo_falla" disabled="disabled">
							<option value="none">  --  Seleccione un tipo de Incidencia --  </option>
							<?php
								$aux="";
								foreach ($fallas as $falla){
									$aux = '<option value="' . $falla["fallaId"] . '"';
									
									if(isset($searchedTipoIncidencia) && $falla["fallaId"] == $searchedTipoIncidencia ){
										$aux .= 'selected="selected"';
									}

									$aux .= '>' . $falla["nombre"] . '</option>';

									echo $aux;
								}
							?>
						</select>
					</div>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-sm-10">
					<input type="text" name="searchIncidencias" id="searchIncidencias" class="search" disabled="disabled"
					 placeholder="Buscar Incidencias según una de las opciones de arriba... y presione ENTER (3 CARACTERES al menos)"
					 <?php if ( isset($searchedIncidencias) ) echo 'value="' . $searchedIncidencias . '"'; ?>
					 >
				</div>
				<div class="col-sm-2">
					<span style="background-color:yellow;">y presione ENTER</span>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-sm-6" align="center">
					<br/><br/>
					<button type="button" class="btn btn-primary"
					 data-toggle="tooltip" data-placement="bottom" title="Listar todas las Incidencias, se ordenarán por Nombre de Empresa"
					 onclick="javascript:searchAll('incidencias');"
					 >
						<span class="glyphicon glyphicon-sort-by-alphabet"></span> Ver todas las Incidencias
					</button>
				</div>
				<div class="col-sm-6" align="center">
					<br/><br/>
					<button type="button" class="btn btn-success"
					 data-toggle="tooltip" data-placement="bottom" title="Listar todas los Reportes de Visitas, se ordenarán por Nombre de Empresa"
					 onclick="javascript:searchAll('reportes');"
					 >
						<span class="glyphicon glyphicon-sort-by-alphabet"></span> Ver todas los Reportes de Visita
					</button>
				</div>
			</div>
		</div>

	</form>


	<script>
		
		$(document).ready(function () {

			$(".search").on('keyup', function (e) {
				if (e.keyCode == 13) {
					/* al presionar ENTER */
					document.getElementById("busqueda_general_form").submit();
				}
			});
		});

		/*
		 * Mostrar Panel de busqueda adecuado
		 */
		function mostrar(opcion){

			if ( opcion == "personas" ){
				$("#personas").css({'visibility':'visible', 'position':'absolute', 'top': '290px'});

				/**/
				$("#empresas").css('visibility', 	'hidden');
				$("#equipos").css('visibility', 	'hidden');
				$("#incidencias").css('visibility', 'hidden');

				/**/
				$("#peopleFound").css('visibility', 	'visible');
				$("#companiesFound").css('visibility',  'hidden');
				$("#equipmentFound").css('visibility',  'hidden');
				$("#incidentFound").css('visibility',   'hidden');

			} else if ( opcion == "empresas" ){
				$("#empresas").css({'visibility':'visible', 'position':'absolute', 'top': '290px'});

				/**/
				$("#personas").css('visibility', 	'hidden');
				$("#equipos").css('visibility', 	'hidden');
				$("#incidencias").css('visibility', 'hidden');

				/**/
				$("#peopleFound").css('visibility', 	'hidden');
				$("#companiesFound").css('visibility',  'visible');
				$("#equipmentFound").css('visibility',  'hidden');
				$("#incidentFound").css('visibility',   'hidden');
				

			} else if ( opcion == "equipos" ){
				$("#equipos").css({'visibility':'visible', 'position':'absolute', 'top': '290px'});

				$("#personas").css('visibility', 	'hidden');
				$("#empresas").css('visibility', 	'hidden');
				$("#incidencias").css('visibility', 'hidden');

				/**/
				$("#peopleFound").css('visibility', 	'hidden');
				$("#companiesFound").css('visibility',  'hidden');
				$("#equipmentFound").css('visibility',  'visible');
				$("#incidentFound").css('visibility',   'hidden');
				

			} else if ( opcion == "incidencias" ){
				$("#incidencias").css({'visibility':'visible', 'position':'absolute', 'top': '290px'});

				$("#personas").css('visibility', 	'hidden');
				$("#equipos").css('visibility', 	'hidden');
				$("#empresas").css('visibility', 	'hidden');

				/**/
				$("#peopleFound").css('visibility', 	'hidden');
				$("#companiesFound").css('visibility',  'hidden');
				$("#equipmentFound").css('visibility',  'hidden');
				$("#incidentFound").css('visibility',   'visible');
				
			}
		}

		function cambiarPlaceholder(tipo){

			if ( tipo == 1 ) {
				$("#searchIncidencias").attr( 'placeholder', "Indique el identificador de la Incidencia (#Incidencia)... y presione ENTER (solo se aceptan NÚMEROS)");
				$("#tipo_falla").attr( "disabled", "disabled" );

			} else if ( tipo == 2 ) {
				$("#searchIncidencias").attr( 'placeholder', "Indique alguna Persona(Nombre o Apellido) o Empresa(Nombre, Razón social o NIT) afectada por la Incidencia a buscar... y presione ENTER (3 caracteres al menos)" );
				$("#tipo_falla").removeAttr( 'disabled' );

			} else if ( tipo == 3 ) {
				$("#searchIncidencias").attr( 'placeholder', "Indique palabra(s) clave(s) de alguna Solución brindada(Variable Endógena, Exógena, etc.)... y presione ENTER (3 caracteres al menos)" );
				$("#tipo_falla").removeAttr( 'disabled' );
			
			} else if ( tipo == 4 ) {
				$("#searchIncidencias").attr( 'placeholder', "Indique LETRA del tipo de búsqueda, un ESPACIO EN BLANCO y la(s) fechas(s), según instrucciones de arriba... y presione ENTER");
				$("#tipo_falla").attr( "disabled", "disabled" );

			}

			$("#searchIncidencias").removeAttr( 'disabled' );
		}

		/**
		 * @param objetoAlistar {"personas", "empresas", "equipos"}
		 */
		function searchAll(objetoAlistar){
			
			location.href = "<?= PROJECTURLMENU; ?>admin/listarTodos/" + objetoAlistar;
		}

	</script>


<?php
	echo "<script>";
	echo '		mostrar("' . $opcion . '");';
	echo "</script>";
?>


<?php
	/*********************************************************************************************************/
	/*********************************************************************************************************/
	if ( isset( $people) ){
?>
	<div id="peopleFound">
		<div class="row">
			<div class="col-sm-12" align="center" style="padding: 12px 20px 12px 40px; font-size: 18px; color:#951B81; ">
				<span class="glyphicon glyphicon-user"></span> 
				<i>Usuarios encontrados:</i>
			</div>
		</div>
		<div id="no-more-tables">
			<table class="col-md-12 table-hover table-striped cf" style="font-size:12px;" border="1">
				<thead class="cf">
					<tr>
						<th style="width: 60px;">Acciones</th>
						<th align="center">ID Nº</th>
						<th>Nombre</th>
						<th>Apellido</th>
						<th>G&eacute;nero</th>
						<th>Usuario</th>
						<th>Email</th>
						<th>Celular</th>
						<th>Rol en <br/> Sistema</th>
						<th style="width: 75px;">Estatus Actual</th>
						<th style="width: 110px;">Empresa</th>
						<th style="width: 110px;">Dependencia</th>
						<th style="width: 90px;">Tel&eacute;f. Trabajo</th>
						<th>Registrado desde</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($people as $usuario) { ?>
					<tr>
						<td data-title="Editar" align="center">
							<button type="button" class="btn btn-primary"
							 data-toggle="tooltip" data-placement="bottom" title="Editar o Eliminar Usuario"
							 onclick="javascript:editarPersona(<?= $usuario["id"] ?>);"
							 >
								<span class="glyphicon glyphicon-pencil"></span> 
							</button>
						</td>
						<td data-title="ID Nº" align="center" style="padding-top: 10px; padding-bottom: 10px;" >
							<?= $usuario["id"] ?>
						</td>
						
						<td data-title="Nombre" class="success"  ><?= $usuario["saludo"] . " " . $usuario["nombre"]; ?></td>
						<td data-title="Apellido" class="success"><?php echo $usuario["apellido"]; ?></td>

						<td data-title="G&eacute;nero"><?php echo $usuario["gender"]; ?></td>

						<td data-title="Usuario"><?php echo $usuario["usuario"] . "&nbsp;&nbsp; "; ?></td>
						<td data-title="Email"><?= $usuario["email"]; ?></td>

						<td data-title="Celular"><?= $usuario["celular"]; ?></td>
						
						<td data-title="Rol">
						  <?php 
							if ( $usuario["role"] == "admin"){ 			echo "Administrador"; }
							else if ( $usuario["role"] == "manager"){   echo "Gerente"; }
							else if ( $usuario["role"] == "client"){ 	echo "Empleado"; }
							else if ( $usuario["role"] == "developer"){ echo "Programador"; }
							else if ( $usuario["role"] == "tech"){ 		echo "Ing. Soporte"; }
						  ?>
						</td>

						<td data-title="Estatus" style="width: 75px;" 
						 <?php 
							if($usuario["activo"]=="activo"){echo 'class="success"';}
							else if($usuario["activo"]=="inactivo"){echo 'class="warning"';}
							else if($usuario["activo"]=="eliminado"){echo 'class="danger"';}
							else {echo 'class="active"';}
						 ?>
						>
							<?= ucfirst($usuario["activo"]); ?>
						</td>

						<td data-title="Empresa" class="info" style="width: 100px;">
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

						<td data-title="Telef. Trabajo" style="width: 90px;">
							<?= $usuario["telefonoTrabajo"] . " " . $usuario["extensionTrabajo"]; ?>
						</td>

						<td data-title="Registrado desde">
							<?= $usuario["fecha_ingreso"]; ?>
						</td>
					</tr>

					<?php } ?>

				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="col-sm-12" align="center">
				<br/><br/><br/>
				<h6>
					<?= $footer; ?>
				</h6>
			</div>
		</div>
	</div>
	<script>
		$("#peopleFound").css({'visibility':'visible', 'position':'absolute', 'top': '540px'});

		function editarPersona(usuarioId){
			location.href = "<?= PROJECTURLMENU; ?>admin/editar/persona/" + usuarioId;
		}
	</script>

<?php
	}/* $people */

	/*********************************************************************************************************/
	/*********************************************************************************************************/
	if ( isset( $companies) ){
?>

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
						<th style="width: 60px;">Acciones</th>
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
					</tr>
				</thead>
				<tbody>
					<?php foreach ($companies as $company) { ?>
					<tr>
						<td data-title="Editar" align="center">
							<button type="button" class="btn btn-primary"
							 data-toggle="tooltip" data-placement="bottom" title="Editar Empresa"
							 onclick="javascript:editarCompany(<?= $company["empresaId"]; ?>);"
							 >
								<span class="glyphicon glyphicon-pencil"></span> 
							</button>
						</td>
						<td data-title="ID Nº" align="center" style="padding-top: 10px; padding-bottom: 10px;" >
							<?= $company["empresaId"]; ?>
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

					</tr>
					<?php } ?>

				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="col-sm-12" align="center">
				<br/><br/><br/>
				<h6>
					<?= $footer; ?>
				</h6>
			</div>
		</div>
	</div>
	<script>
		$("#companiesFound").css({'visibility':'visible', 'position':'absolute', 'top': '540px'});

		function editarCompany(companyId){
			location.href = "<?= PROJECTURLMENU; ?>admin/editar/empresa/" + companyId;
		}
	</script>

<?php
	}/* $companies */

	/*********************************************************************************************************/
	/*********************************************************************************************************/
	if ( isset( $equipment) ){
?>

	<div id="equipmentFound">
		<div class="row">
			<div class="col-sm-12" align="center" style="padding: 12px 20px 12px 40px; font-size: 18px; color:#951B81; ">
				<span class="glyphicon glyphicon-blackboard"></span> 
				<i>Equipos encontrados:</i>
			</div>
		</div>
		<div id="no-more-tables">
			<table id="tableId" class="col-md-12 table-hover table-striped cf" style="font-size: 12px;">
				<thead class="cf">
					<tr>
						<th align="center" style="text-align: center;">ID<br/>Equipo</th>
						<th align="center" style="text-align: center;width: 90px;">Ver<br/>Detalles</th>
						<th style="width: 100px;">C&oacute;digo Barras</th>
						<th style="width: 200px;">Info b&aacute;sica</th>
						<th>Fecha creaci&oacute;n<br/>(A&ntilde;o-Mes-D&iacute;a Hora)</th>
						<th align="center" style="text-align: center;width: 100px;">TeamViewer<br/>ID</th>
						<th style="width: 200px;">Empresa</th>
						<th style="text-align: center; width: 100px;">Asignado a</th>
						<th align="center" style="text-align: center;">&iquest;Inventariado&quest;<br/>(S&iacute;/No)</th>
					</tr>
				</thead>
				<tbody>
	<?php 			foreach ($equipment as $equipo) { ?>
					<tr
	<?php 
							if ( $equipo["equipoInfoId"] == NULL){ echo 'class="danger"'; }
							else { echo 'class="success"'; }
	?>
					>

						<td data-title="ID Equipo" align="center" style="text-align: center;"><?php echo $equipo["id"]; ?></td>

						<td data-title="Acciones" style="width: 90px;text-align: center;">
	<?php 					if ( $equipo["equipoInfoId"] == NULL){ 
								echo "N/A";

							} else {  ?>
								<button type="button"class="btn btn-success"
								 onclick="javascript:verInventario('<?= $equipo["equipoInfoId"] ?>' , '<?= $equipo["TipoEquipo"] ?>');"
								 data-toggle="tooltip" data-placement="bottom" title="Ver +Detalles técnicos"
								>
									<span class="glyphicon glyphicon-tasks"></span>
								</button>
								&nbsp;
	<?php 					}  ?>
							
							<br/>

						</td>
						<td data-title="C&oacute;digo Barras" style="text-align: center; width: 100px;">
							<?php echo $equipo["codigoBarras"]; ?>
						</td>
						<td data-title="Info b&aacute;sica" style="width: 200px;">
	<?php 					echo $equipo["TipoEquipo"];
							if ( $equipo["infoBasica"] != NULL && $equipo["infoBasica"] != "" ){
								echo "<br/>" . $equipo["infoBasica"];
							}
	?>
						</td>
						<td data-title="Fecha creaci&oacute;n"><?php echo $equipo["fechaCreacion"]; ?></td>

						<td data-title="ID TeamViewer" style="text-align: center; width: 80px;">
							<?php echo $equipo["teamViewer_Id"]; ?>
						</td>

						<td data-title="Empresa" style="width: 200px;">
	<?php 					echo $equipo["NombreEmpresa"];
							if ( $equipo["razonSocial"] != NULL && $equipo["razonSocial"] != "" ) {
								echo " (" . $equipo["razonSocial"] . ")";
							}
	?>
						</td>
						<td data-title="Asignado a" style="text-align: center; width: 100px;">
	<?php 					if ( $equipo["NombreUsuarioAsignado"] != NULL && $equipo["NombreUsuarioAsignado"] != "" ) {
								echo $equipo["NombreUsuarioAsignado"] . "<br/>" . $equipo["ApellidoUsuarioAsignado"];
								
								if ( $equipo["dependencia"] != NULL && $equipo["dependencia"] != "" ) {
									echo "<br/>(" . $equipo["dependencia"] . ")";
								}
							} else {
								echo "<i>N/A</i>";
							}
	?>
						</td>
						<td data-title="&iquest;Inventariado&quest;" align="center" style="text-align: center;">
	<?php 					if ( $equipo["equipoInfoId"] != NULL && $equipo["equipoInfoId"] != "" ) {
								echo "S&iacute;";
							} else {
								echo "No";
							}
	?>
						</td>
					</tr>
	<?php 			} ?>

				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="col-sm-12" align="center">
				<br/><br/><br/>
				<h6>
					<?= $footer; ?>
				</h6>
			</div>
		</div>
		<script>
			$("#equipmentFound").css({'visibility':'visible', 'position':'absolute', 'top': '810px'});

			function verInventario(equipoInfoId, tipoEquipo){

				$("#equipoInfoId").val( equipoInfoId );
				$("#tipoEquipo").val(   tipoEquipo );

				$("#inventario_form").submit();
			}
		</script>
		<form class="form-horizontal" data-toggle="validator" role="form" id="inventario_form" method="post"
		 enctype="multipart/form-data" action="<?= PROJECTURLMENU ?>admin/ver_inventario_equipo">
			<input type="hidden" id="equipoInfoId" name="equipoInfoId" value="" />
			<input type="hidden" id="tipoEquipo"   name="tipoEquipo"   value="" />
		</form>
	</div>
<?php
	
		echo '<script> document.location.href = "#filtrarTipo"; </script>';

	}/* $equipment */

	/*********************************************************************************************************/
	/*********************************************************************************************************/
	if ( isset( $incidencias) ){
?>

	<div id="incidentFound">
		<div class="row">
			<div class="col-sm-12" align="center" style="padding: 12px 20px 12px 40px; font-size: 18px; color:#951B81; ">
				<span class="glyphicon glyphicon-list"></span> 
				<i>Incidencias/Reportes encontrados:</i>
			</div>
		</div>
		<div id="no-more-tables">
			<table class="col-md-12 table-hover table-striped cf" style="font-size:12px;">
				<thead class="cf">
					<tr>
						<th width="90px" class="active" align="center">Nº Incidencia<br/>y Estatus</th>
						<th width="150px" style="text-align: center;" align="center">Acciones</th>
						<th width="100px" class="numeric">Equipo Nº</th>
						<th width="160px">Fecha creaci&oacute;n<br/>(A&ntilde;o-Mes-D&iacute;a Hora)</th>
						<th>Falla:<br/>General</th>
						<th>Falla:<br/>Comentarios</th>
						<th style="text-align: center;" align="center">Empresa<br/>afectada</th>
						<th width="100px" style="text-align: center;" align="center">Usuario<br/>afectado</th>
						<th width="100px">Fecha &uacute;ltima<br/> actualizaci&oacute;n</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						/*
						 * Variable que indicará si por lo menos hay una Incidencia con el status 'En Espera'
						 */
						$porlomenosunEnEspera = false;

						/* Recorrido de Incidencias */
						foreach ($incidencias as $incidencia) {
					?>
					<tr>

						<td data-title="Incidencia/Estatus" align="center" style="padding-top: 10px; padding-bottom: 10px;" 
						 <?php 
							if($incidencia["status"]=="Abierta"){echo 'class="danger"';}
							else if($incidencia["status"]=="En Espera"){echo 'class="info"';}
							else if($incidencia["status"]=="En Progreso"){echo 'class="warning"';}
							else if($incidencia["status"]=="Cerrada" || $incidencia["status"]=="Certificada"){echo 'class="success"';}
							else {echo 'class="active"';}
						 ?>
						>
							<?= $incidencia["incidenciaId"] . "<br/>" . $incidencia["status"] ?>
						</td>

						<td data-title="Acciones" >
							<button type="button"
							 <?php 
								if ($incidencia["resolucionId"]==null || $incidencia["resolucionId"]==""){
									echo 'class="btn btn-primary disabled"';
								}else{
									echo 'class="btn btn-primary"';
								}
							 ?>
							 data-toggle="tooltip" data-placement="bottom" title="VER o EDITAR Soluci&oacute;n de la Incidencia"
							 onclick="javascript:verDetalleSolucion(<?php echo $incidencia["resolucionId"] ?>);">
								<span class="glyphicon glyphicon-folder-open"></span> 
							</button>
							&nbsp;
							<button type="button"
							 <?php 
								if ($incidencia["tecnicoId"]==null || $incidencia["tecnicoId"]==""){
									echo 'class="btn btn-info disabled"';
								}else{
									echo 'class="btn btn-info"';
								}
							 ?>
							 data-toggle="tooltip" data-placement="bottom" title="Ver Informaci&oacute;n de Contacto del Ingeniero de Soporte"
							 onclick="javascript:verInfoTecnico(<?php echo $incidencia["tecnicoId"] ?>);"
							 >
								<span class="glyphicon glyphicon-info-sign"></span> 
							</button>
							
						</td>

						<td align="center" data-title="Equipo Nº" align="center">
							<?php 
								if ( $incidencia["codigoBarras"] != null && $incidencia["codigoBarras"] != ""){
									echo $incidencia["codigoBarras"];
								} else {
									echo '<h6 style="color:#FFF;">.</h6>';
								}
							?>
						</td>
						<td data-title="Fecha Creación"><?php echo $incidencia["fecha"]; ?></td>
						<td data-title="Fallas y Comentarios">
<?php 
							
							echo $incidencia["falla"];
?>
						</td>

						<?php 
							/* imprimiendo una CELDA programatically */
							if ( $incidencia["respuestaEsperada"] != null ){
								echo  '<td class="info" data-title="Respuesta del Usuario">' . $incidencia["respuestaEsperada"] . '</td>';

							} else if ( $incidencia["enEsperaPor"] != null ){
								echo  '<td class="info" data-title="Tecnico espera por">' . $incidencia["enEsperaPor"] . '</td>';

							} else {
								echo '<td data-title="Observaciones">' . $incidencia["observaciones"] . '</td>';
							}
						?>

						<td data-title="Empresa afectada" class="info">
							<?php 
								echo $incidencia["Empresa_nombre"];
								if ( $incidencia["razonSocial"] != null && $incidencia["razonSocial"] != "") {
									echo " (" . $incidencia["razonSocial"] . ")";
								}
							?>
						</td>
						<td data-title="Usuario afectado" style="text-align: center;" align="center" class="info">
							<?php echo $incidencia["Usuario_nombre"] . "<br/>" . $incidencia["Usuario_apellido"]; ?>
						</td>

						<td data-title="Actualizada">
							<?php
								if ( $incidencia["fecha_reply"] != null && $incidencia["fecha_reply"] != "") {
									echo $incidencia["fecha_reply"];

								} else if ( $incidencia["fecha_enEspera"] != null && $incidencia["fecha_enEspera"] != "") {
									echo $incidencia["fecha_enEspera"];
								
								} else if ( $incidencia["fecha_enProgreso"] != null && $incidencia["fecha_enProgreso"] != "") {
									echo $incidencia["fecha_enProgreso"];
									
								} else {
									echo '<h6 style="color:#FFF;">.</h6>';
								}
							?>
						</td>
						
					</tr>

					<?php } ?>

				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="col-sm-12" align="center">
				<br/><br/><br/>
				<h6>
					<?= $footer; ?>
				</h6>
			</div>
		</div>
	</div>
	<!-- ================================== Formulario para VER info del Tecnico ======================================= -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog modal-sm">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title" align="center">
				<span class="glyphicon glyphicon-wrench"></span> 
				Informaci&oacute;n del Ingeniero de Soporte
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
		echo "<script> var modalAjaxURL = '" . PROJECTURLMENU . "tecnicos/ajax_ver_tecnico'; </script>" ;
	?>

	<!-- ========================= Formulario para VER SOLUCION DE una incidencia  ================================== -->
	<form id="resolucionIncidenciaForm" method="post" enctype="multipart/form-data" 
		action="<?= PROJECTURLMENU; ?>admin/ver_resolucion_incidencia">
		
			<input type="hidden" id="resolucionIncidenciaId" name="resolucionIncidenciaId" value="" />
	</form>

	<form id="enviarTecnico" method="post" enctype="multipart/form-data">
		<input type="hidden" id="tecnicoId" name="tecnicoId" value="" />
	</form>

	<script>
		$("#incidentFound").css({'visibility':'visible', 'position':'absolute', 'top': '1280px'});

		function verInfoTecnico(tecnicoId){

			$('#myModal').modal('show');

			/* valor en el input type hidden */
			document.getElementById("tecnicoId").value = "" + tecnicoId;

			$.ajax({
				type: "POST",
				url: modalAjaxURL,
				data: $('#enviarTecnico').serialize(),
				success: function(message){
					/*alert("OK_");*/
					/*$("#feedback-modal").modal('hide');*/
					$("#feedback").html(message)
				},
				error: function(){
					alert("Error al buscar info del Técnico en nuestro Sistema\nPor favor, intente más tarde");
				}
			});
		}

		/**
		 * 
		 */
		function verDetalleSolucion(resolucionId){

			document.getElementById("resolucionIncidenciaId").value = resolucionId;

			document.getElementById("resolucionIncidenciaForm").submit();
		}
		
	</script>
	<?php
		echo '<script> document.location.href = "#filtrarTipo"; </script>';
	?>

<?php
	}/* $incidencias */
?>

</div>
