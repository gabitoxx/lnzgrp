<div id="container">

	<div class="row" style="background-color:#F9B233;font-size:16px;">
		<div class="col-sm-3" align="right">
			<b>ID del Equipo en el Portal:</b> 
			<?= $equipo["id"]; ?>
		</div>
		<div class="col-sm-5" align="right">
			<b>ID de la Empresa propietaria:</b> 
			<?= $equipo["empresaId"]; ?>
			<br/>
			<?= $empresaNombre; ?>
		</div>
		<div class="col-sm-4" align="right">
			<b>ID del Usuario asignado:</b> 
			<?= $equipo["usuarioId"]; ?>
			<br/>
			<?= $usuarioNombre; ?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-5" style="text-align:center;font-family:monospace;font-size: 20px;">
			<br/><br/><br/>
			C&oacute;digo de Barras generado para este Equipo:
		</div>
		<div class="col-sm-7" style="text-align:center;font-family:monospace;font-size: 60px;">
<?php
		$aux = $equipo["codigoBarras"];
		$companyId  = substr($aux, 0, 4);
		$tipoEquipo1= substr($aux, 4, 2);
		$id 		= substr($aux, 6, 4);
?>			
			<img id="imgX" alt="Codigo de barras generado" src="<?= APPIMAGEPATH; ?>barcode_example.png" />
			<br/>
			<span style="color:#0D181C;">
				<?= $companyId; ?>
			</span>
			<span style="color:#E30513;">
				<?= $tipoEquipo1; ?>
			</span>
			<span style="color:#94A6B0;">
				<?= $id; ?>
			</span>
		</div>
	</div>

	<script>
		/*
		 * Estas variables ayudan a determinar si se hizo algun cambio de data
		 * si NO se hicieron cambios, no se realizará ningún UPDATE en la BD
		 * si hubo por lo menos algún cambio, se realizará un UPDATE de todo
		 */
		var huboAlgunaActualizacion = false;
		var huboAlgunaActualizacionPerifericos = false;
	</script>

	<form data-toggle="validator" role="form" id="inventario_new_eq_form" method="post"
			 enctype="multipart/form-data" action="<?= PROJECTURLMENU ?>tecnicos/actualizacion_equipo">

		<input type="hidden" id="equipoId" 	name="equipoId"  value="<?= $equipo["id"]; ?>" />
		<input type="hidden" id="usuarioId" name="usuarioId" value="<?= $equipo["usuarioId"]; ?>" />
		<input type="hidden" id="empresaId" name="empresaId" value="<?= $equipo["empresaId"]; ?>" />
		<input type="hidden" id="cambios"   name="cambios"   value="false" />

		<input type="hidden" id="empresaNombre" name="empresaNombre" value="<?= $empresaNombre; ?>" />
		<input type="hidden" id="usuarioNombre" name="usuarioNombre" value="<?= $usuarioNombre; ?>" />
		
		<br/>
		<hr/>
		<br/>
		<h4 style="text-align:center; color:#000;">
			<span class="glyphicon glyphicon-blackboard"></span> 
			<i>Datos del Equipo Inventariado</i>&nbsp;&nbsp;&nbsp;
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
					 placeholder="Nombre del Equipo (OPCIONAL). Ej: Equipo de RRHH, Equipo de Ana, etc."
					 value="<?= $equipo["nombreEquipo"]; ?>" onblur="javascript:updated();" 
					 >
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
					 placeholder="Área de la Empresa o Dónde es usado. Ejemplo: Gerencia, Administración, RRHH, etc."
					 value="<?= $equipo["dependencia"]; ?>" onblur="javascript:updated();"
					 >
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
					 placeholder="Marca del Equipo. Ej: Toshiba, Dell, HP, Sony, etc."
					 value="<?= $equipo["marca"]; ?>" onblur="javascript:updated();" 
					 >
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
					 placeholder="El modelo del Equipo, generalmente acompaña la MARCA. Ejemplo: MOD1-PS6300"
					 value="<?= $equipo["modelo"]; ?>" onblur="javascript:updated();" 
					 >
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
				<label>N&uacute;mero de Serie (Serial)<b style="color:#E30513;font-size:18px;">*</b></label>
			</div>
			<div class="col-sm-8">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-sound-5-1"></i></span>
					<input type="text" class="form-control" id="serial" name="serial" required="required" 
					 placeholder="Número de Serie único del Equipo, normalmente está en una etiqueta frontal o trasera"
					 value="<?= $equipo["serial"]; ?>" onblur="javascript:updated();" 
					 >
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
							$a = $equipo["tipoEquipoId"];
							$b = "";

							foreach ($tipoEquipos as $tipoEquipo){

								if ( $a == $tipoEquipo["tipoEquipoId"] ){
									$b = ' selected="selected" ';
								} else {
									$b = "";
								}

								$option = '<option value="' . $tipoEquipo["tipoEquipoId"] . '" '.$b.'>' . $tipoEquipo["nombre"] . '</option>';
								
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
					 placeholder="(9 dígitos numéricos sin espacios)"
					 value="<?= $equipo["teamViewer_Id"]; ?>" onblur="javascript:updated();" 
					 >
					 <span id="teamViewerID-span" class=""></span>
				</div>
			</div>
			<div class="col-sm-2" align="right">
				<label data-toggle="tooltip" data-placement="bottom" title="6 caracteres ALFA-NUMÉRICOS">
					<u>TeamViewer Clave</u><b style="color:#E30513;font-size:18px;">*</b>:</label>
			</div>
			<div class="col-sm-2" align="right">
				<input type="text" class="form-control" id="teamViewerClave" name="teamViewerClave"
				 placeholder="Ejemplo: 123abc"
				 value="<?= $equipo["teamViewer_clave"]; ?>" onblur="javascript:updated();" 
				 >
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
					 placeholder="IP (fija) de Conexión Remota o Código de acceso remoto (de aplicaciones como join.me)"
					 value="<?= $equipo["conexionRemota"]; ?>" onblur="javascript:updated();" 
					 >
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
					 placeholder="La clave de la cuenta tipo ADMINISTRADOR del Sistema Operativo"
					 value="<?= $equipo["claveAdmin"]; ?>" onblur="javascript:updated();" 
					 >
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
					<input type="text" class="form-control" id="costo" name="costo" disabled="disabled" 
					 placeholder="En pesos colombianos (COP) | SIN separador de miles | ',' separador decimales | (Ej: 123000,45)"
					 value="<?= $equipo["valor"]; ?>" onblur="javascript:updated();" 
					 >
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
					<input type="text" class="form-control" id="reposicion" name="reposicion" disabled="disabled" 
					 placeholder="Valor de reponer del Equipo, en pesos (COP) SIN separador de miles (Ej: 123000,45) ',' es separador decimal"
					 value="<?= $equipo["valorReposicion"]; ?>" onblur="javascript:updated();" 
					 >
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
					 placeholder="Escriba sus Impresiones inicales. Ej: se ve en buen estado, es obsoleto, tiene carcasa rota, etc."
					 value="<?= $equipo["observacionInicial"]; ?>" onblur="javascript:updated();" 
					 >
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
					 placeholder="Enlace completo a donde se guarda la Foto del Equipo. Ej: https://i.imgur.com/AQMJpDW.gif"
					 value="<?= $equipo["linkImagen"]; ?>" onblur="javascript:updated();" 
					 >
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
					  <input type="radio" name="windows" id="windows" value="Si" onclick="javascript:updated();" 
					   <?php if($equipo["licWindows"]=="Si"){ echo ' checked="true" '; } ?>
					   >
						S&iacute;
					</label>
					&nbsp;&nbsp;&nbsp;
					<label class="radio-inline">
					  <input type="radio" name="windows" id="windows" value="No" onclick="javascript:updated();" 
						<?php if($equipo["licWindows"]=="No"){ echo ' checked="true" '; } ?>
					    >
						No
					</label>
					&nbsp;&nbsp;&nbsp;
					<label class="radio-inline">
					  <input type="radio" name="windows" id="windows" value="Desconocido" onclick="javascript:updated();" 
					   <?php if($equipo["licWindows"]=="Desconocido"){ echo ' checked="true" '; } ?>
					   >
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
					  <input type="radio" name="office" id="office" value="Si" onclick="javascript:updated();" 
					   <?php if($equipo["licOffice"]=="Si"){ echo ' checked="true" '; } ?>
					   >
						S&iacute;
					</label>
					&nbsp;&nbsp;&nbsp;
					<label class="radio-inline">
					  <input type="radio" name="office" id="office" value="No" onclick="javascript:updated();" 
					   <?php if($equipo["licOffice"]=="No"){ echo ' checked="true" '; } ?>
					   >
						No
					</label>
					&nbsp;&nbsp;&nbsp;
					<label class="radio-inline">
					  <input type="radio" name="office" id="office" value="Desconocido" onclick="javascript:updated();" 
						<?php if($equipo["licOffice"]=="Desconocido"){ echo ' checked="true" '; } ?>
					   >
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
					<select class="form-control" id="sistemaOperativo" name="sistemaOperativo" onblur="javascript:updated();">
<?php
						$a = $equipo["sistemaOperativo"];
?>
						<option value="none">  --  Seleccione uno --  </option>
						<option value="Windows"			<?php if($a=="Windows")				echo 'selected="selected"'; ?> >Windows</option>
						<option value="Linux/GNU"		<?php if($a=="Linux/GNU")			echo 'selected="selected"'; ?> >Linux/GNU</option>
						<option value="Mac"				<?php if($a=="Mac")					echo 'selected="selected"'; ?> >Mac</option>
						<option value="Solaris"			<?php if($a=="Solaris")				echo 'selected="selected"'; ?> >Solaris</option>
						<option value="Unix"			<?php if($a=="Unix")				echo 'selected="selected"'; ?> >Unix</option>
						<option value="Google Chrome OS"<?php if($a=="Google Chrome OS")	echo ' selected="selected"'; ?> >Google Chrome OS</option>
						<option value="AS/400"			<?php if($a=="AS/400")				echo 'selected="selected"'; ?> >AS/400</option>
						<option value="Otro"			<?php if($a=="Otro")				echo 'selected="selected"'; ?> >Otro</option>
					</select>
					<span id="sistemaOperativo-span" class=""></span>
				</div>
			</div>
			<div class="col-sm-2" align="right">
				<label data-toggle="tooltip" data-placement="bottom" title="El número de versión del Sistema Operativo, puede usar puntos, NO COMAS">
					<u>Versi&oacute;n N&uacute;mero</u><b style="color:#E30513;font-size:18px;">*</b>:</label>
			</div>
			<div class="col-sm-2" align="right">
				<input type="text" class="form-control" id="versionSO" name="versionSO" onblur="javascript:updated();" 
				 placeholder="Ejemplo: 8.1" value="<?= $equipo["versionSO"]; ?>">
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
					 placeholder="Escriba el nombre según aparece en la Info o Configuración del Equipo"
					 value="<?= $equipo["nombreSO"]; ?>" onblur="javascript:updated();" 
					 >
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
<?php
						$a = $equipo["hddEstado"];
?>
						<option value="none"> --  Seleccione uno --  </option>
						<option value="Bueno"   <?php if($a=="Bueno")		echo 'selected="selected"'; ?> >Bueno</option>
						<option value="Regular" <?php if($a=="Regular")		echo 'selected="selected"'; ?> >Regular</option>
						<option value="Malo"    <?php if($a=="Malo")		echo 'selected="selected"'; ?> >Malo</option>
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
			<i>Listado de Perif&eacute;ricos de este Equipo</i>&nbsp;&nbsp;&nbsp;
		</h4>
		<br/>

		<div class="row">
			<div class="col-sm-12" style="text-align:center;">
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
<?php 					if ( isset($no_perifericos) ){
							/* NO hay ninguno */
							echo "<script>";
							echo "  var cantidadPerifericos = 0;";
							echo "</script>";
						} else {
							$i=0;
							foreach ($perifericos as $periferico) {
								$i++;
								$aux = $periferico["id"] . "" . $periferico["marcaPeriferico"] . $periferico["serial"];
?>
								<tr>
									<td><?= $periferico["id"] ?></td>
									<td><?= $periferico["Nombre_Periferico"] ?></td>
									<td><?= $periferico["marcaPeriferico"] ?></td>
									<td><?= $periferico["serial"] ?></td>
									<td><?= $periferico["descripcion_obs"] ?></td>
									<td>
										<button type="button" class="btn btn-danger"
										 data-toggle="tooltip" data-placement="bottom" title="Eliminar esta entrada"
										 onclick="javascript:eliminarEntradaPeriferico('<?= $aux; ?>');">
										 	<span class="glyphicon glyphicon-trash"></span></button>
									</td>
								</tr>
<?php
 							}
 							echo "<script>";
							echo "  var cantidadPerifericos = $i;";
							echo "</script>";
						}
?>
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
		<input type="hidden" id="periferico_cambios"  		name="periferico_cambios" 		value="false" />
		
		<br/><br/>
		<hr/>

		<div class="row">
			<div class="col-sm-12" style="text-align:center;">
				<br/>
				Una vez completado el formulario, procurando que los datos que usted levant&oacute; de la 
				visita a la Empresa son los m&aacute;s exactos posibles, pulse el siguiente bot&oacute;n
				para <b>ACTUALIZAR</b> el Equipo en el Portal.
			</div>
			<br/>
		</div>
		<div class="row">
			<div class="col-sm-8" align="right">
				<br/>
				<button type="button" class="btn btn-success btn-lg" id="" onclick="javascript:actualizarEquipo();"
				 data-toggle="tooltip" data-placement="bottom" title="Actualizar este EQUIPO en el Sistema"
				 style="margin-top: 7px;">
					<span class="glyphicon glyphicon-hdd"></span> Actualizar data del Equipo </button>
			</div>
			<div class="col-sm-4" align="left">
				<br/><br/>
				<a href="<?= PROJECTURLMENU; ?>tecnicos/actualizar_inventario" class="btn btn-link" style="font-size: 18px;">
					Salir SIN guardar los cambios
					<span class="glyphicon glyphicon-circle-arrow-left"></span> 
				</a>
			</div>
		</div>
	</form>

	<br/>

	<script>

		function updated(){
			huboAlgunaActualizacion = true;
		}


		function actualizarEquipo(){

			if ( !huboAlgunaActualizacion && !huboAlgunaActualizacionPerifericos ){

				alert("Ud. No se ha realizado ningún cambio en este formulario que requiera ser actualizado en el Portal.");
				return false;

			} else {
				var bool = true;

				limpiarEstilos();

				if ( huboAlgunaActualizacion ){
					bool = verificandoCampos();
				}

				if ( bool == true || huboAlgunaActualizacionPerifericos == true ){

<?php
	if ( trim( $usuarioNombre) == "" ){
?>
					var confirmMessage = "Se procederá a actualizar el Equipo..."
							+ "\n\nDe la Empresa:  <?= $empresaNombre; ?>"
							+ "\n\n\n ¿Desea continuar con la actualización del Equipo?";
<?php 
	} else {
?>
					var confirmMessage = "Se procederá a actualizar el Equipo..."
							+ "\n\nDel Usuario:  <?= $usuarioNombre; ?>"
							+ "\n\nDe la Empresa:  <?= $empresaNombre; ?>"
							+ "\n\n\n ¿Desea continuar con la actualización del Equipo?";
<?php 
	}
?>
					var ask = confirm( confirmMessage );
					if ( ask == true) {

						document.getElementById("cambios").value = "true";

						/* serializando la tabla */
						if ( huboAlgunaActualizacionPerifericos ){
							document.getElementById("periferico_cambios").value = "true";
							csvTablaHTML();
						}

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
		}
		function verificandoCampos(){

			var bool = true;

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
			if ( $("#serial").val() == "" ){
				bool = false;
				
				document.getElementById("serial-div").className = "form-group has-error has-feedback";
				document.getElementById("serial-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("serial-error").innerHTML = "Busquelo bien";
			}

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

			return bool;
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
									if ( isset( $perifericosTodos ) ){
										foreach ($perifericosTodos as $periferico){

											$option = '<option value="' . $periferico["id"] . '">' . $periferico["nombre"] . '</option>';
											echo $option;
										}
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

				huboAlgunaActualizacionPerifericos = true;
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
				
				huboAlgunaActualizacionPerifericos = true;

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

	<fieldset class="scheduler-border">
		
		<legend class="scheduler-border">Importante</legend>
		
		<div class="row control-group">
			<div class="col-sm-12" style="text-align:left;">
				<u>Nota:</u> Aqu&iacute; <b>NO se actualiza los Scripts</b> (archivos .CSV) de este Equipo. Para eso, 
				<u><i>en la pantalla anterior</i></u> 
				debe seleccionar una de las siguientes opciones:
			</div>
		</div>
		<div class="row control-group">
			<div class="col-sm-offset-2 col-sm-10">
				<br/>
				<button type="button" class="btn btn-success">
					<span class="glyphicon glyphicon-floppy-disk"></span> 
				</button>
				Para subir los archivos .CSV de un Equipo <b>por primera vez</b>; ó

				<br/><br/>

				<button type="button" class="btn btn-primary">
					<span class="glyphicon glyphicon-floppy-open"></span> 
				</button> 
				Para <b>actualizar la info generada por los archivos .CSV</b> 
				(de la segunda vez en adelante, cada vez que se desee actualizar el Inventario de un Equipo, en visitas subsecuentes a las Empresas).
				
				<br/><br/>
			</div>
		</div>
		<div class="row control-group">
			<div class="col-sm-2">C&oacute;digo de Barras:</div>
			<div class="col-sm-10">
				el <b>c&oacute;digo de barras</b> que gener&oacute; el Sistema para ESTE Equipo es el siguiente:
			</div>
		</div>
		<div class="row control-group">
			<div class="col-sm-offset-2 col-sm-10" style="text-align:center;font-family:monospace;font-size: 60px;"> 	
				<img id="imgX" alt="Codigo de barras generado" src="<?= APPIMAGEPATH; ?>barcode_example.png" />
				<br/>
				<span style="color:#0D181C;">
					<?= $companyId; ?>
				</span>
				<span style="color:#E30513;">
					<?= $tipoEquipo1; ?>
				</span>
				<span style="color:#94A6B0;">
					<?= $id; ?>
				</span>
			</div>
		</div>
		<br/>
		<div class="row control-group">
			<div class="col-sm-2">Para su informaci&oacute;n:</div>
			<div class="col-sm-10">
				el <b>c&oacute;digo de barras</b> se compone de la siguiente manera:
				<br/><br/>
				Total de d&iacute;gitos num&eacute;ricos: <b>10</b>
				<br/>
				- <span style="color:#0D181C;">los primeros 4 d&iacute;gitos</span>: son el <b>ID de la Empresa en el Portal</b>.
				<br/>
				- <span style="color:#E30513;">el d&iacute;gito 5º y 6º</span>: son el <b>ID del Tipo de Equipo (Presentaci&oacute;n)</b>: Servidor, Todo-en-Uno, Escritorio, Port&aacute;til, etc.
				<br/>
				- <b><span style="color:#94A6B0;">los &uacute;ltimos 4 d&iacute;gitos</span></b>: son el <b>ID del Equipo dentro de la Empresa</b>
				(<i>NO el id del Equipo en el Portal</i>). Para cada Empresa se comienza con el n&uacute;mero 1;
				<i>pero el ID en el Portal es &uacute;nico en todo el Sistema</i>. 
				Por ejemplo: Un Equipo puede tener el ID "1" dentro la Empresa, pero en el Portal puede ser ID "10023".
				<br/>
				- el <b>ID de Sistema</b> (que puede ver en esta pantalla, arriba y a la derecha) es diferente,
				NO tiene que coincidir con este c&oacute;digo de barras. Este ID es para diferenciar el Equipo de 
				entre todos los Equipos registrados en el Portal LanuzaGroup.
				<br/><br/>
				<b>Ejemplo:</b> un c&oacute;digo <b>1234010004</b> generado por el Sistema significar&iacute;a que 
				ESTE Equipo pertenece a la Empresa con identificador ID: <b>1234</b>; 
				que ser&iacute;a un Servidor (ID de Presentaci&oacute;n <b>01</b>) y que este 
				ser&iacute;a el cuarto Equipo registrado para esta empresa (ID dentro de la Empresa <b>0004</b>).
			</div>
		</div>
	</fieldset>

</div><!-- cerrando "container"-->

<div class="modal fade" id="myModalInfo" role="dialog">
	
	<div class="modal-dialog modal-sm">
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title" align="center">
			<span class="glyphicon glyphicon-wrench"></span> 
			Informaci&oacute;n:
	      </h4>
	    </div>

	    <div class="modal-body">
	      <p><div id="feedback">
<?php
			if ( isset( $cambioRealizado ) ){
				if ( $cambioRealizado == true || $cambioRealizado == "true" || $cambioRealizado == 1 ){
					echo $cambioRealizado_message;
				} else {
					echo "No realizó cambios en la data del Equipo.";
				}
			}
			
			echo "<br/><br/>";

			if ( isset( $cambioRealizadoPerifericos ) ){
				if ( $cambioRealizadoPerifericos == true || $cambioRealizadoPerifericos == "true" || $cambioRealizadoPerifericos == 1 ){
					echo $cambioRealizadoPerifericos_message;
				} else {
					echo "No realizó cambios en los Periféricos del Equipo.";
				}
			}
?>
	      </div></p>
	    </div>

	    <div class="modal-footer">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	    </div>
	  </div>
	</div>
</div>

<?php
	if ( isset( $cambioRealizado ) ){
		echo "<script>";
		
		echo " $('#myModalInfo').modal({
			backdrop: 'static',
			keyboard: false,
			show: true
		}); ";
	
		echo "</script>";		
	}
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
		  10.- Este proceso se puede hacer cuando se crea un Equipo
		  por primera vez, en el men&uacute; <b>Equipos</b>, opci&oacute;n <b>Hacer Nuevo Inventario de Equipo</b>.
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