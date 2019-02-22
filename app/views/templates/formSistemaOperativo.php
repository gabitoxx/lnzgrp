<br/>
			<hr/>
			<br/>

			<h4 style="text-align:center; color:#000;">
				<span class="glyphicon glyphicon-th-large"></span> 
				<i>Sistema Operativo</i>&nbsp;&nbsp;&nbsp; my
			</h4>
			<br/>

			<div id="windows-div" class="form-group">
				<div class="col-sm-3" align="right">
					<label>Windows con Licencia<b style="color:#E30513;font-size:18px;">*</b></label>
				</div>
				<div class="col-sm-6">
					<div class="input-group">
						<label class="radio-inline">
						  <input type="radio" name="windows" id="windows1" value="Si">
							S&iacute;
						</label>
						&nbsp;&nbsp;&nbsp;
						<label class="radio-inline">
						  <input type="radio" name="windows" id="windows2" value="No">
							No
						</label>
						&nbsp;&nbsp;&nbsp;
						<label class="radio-inline">
						  <input type="radio" name="windows" id="windows3" value="Desconocido">
							Desconocido / No es Windows
						</label>
					</div>
				</div>
				<div class="col-sm-3">
					<div id="windows-error" class="help-block">
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
				<div class="col-sm-3">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-sound-6-1"></i></span>
						<select class="form-control" id="sistemaOperativo" name="sistemaOperativo" onchange="javascript:toogleSistemasOperativo(this.value);">
							<option value="none">  --  Seleccione uno --  </option>
							<?php
								foreach ($sistemasOperativos as $so){

									$option = '<option value="' . $so["name"] . '">' . $so["name"] . '</option>';
									echo $option;
								}
							?>
						</select>
						<span id="sistemaOperativo-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-6">
					<div id="sistemaOperativo-error" class="help-block">
						Si existe alguna que no est&eacute; en este listado, 
						por favor notificarlo al Equipo de Desarrollo
						del Portal Lanuzasoft para agregarlo a este listado.
					</div>
				</div>
			</div>

			<div id="nombreSO-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label data-toggle="tooltip" data-placement="bottom" title="Cómo obtenerlo"
					 onclick="javascript:$('#nombreSO_Modal').modal('show'); ;"
					 onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'">
						<u>Nombre del S.O. (en caso de "Otro")</u>
						<br/>
						(click aqu&iacute; para saber c&oacute;mo obtenerlo)
					</label>
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-registration-mark"></i></span>
						<input type="text" class="form-control" id="nombreSO" name="nombreSO" disabled="disabled" 
						 placeholder="En caso de seleccionar arriba la opción OTRO. Escriba el nombre según aparece en la Configuración del Equipo">
						<span id="nombreSO-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-1">
					<div id="nombreSO-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>


			<div id="versionSO-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label data-toggle="tooltip" data-placement="bottom" title="Solo en caso de Seleccionar 'Windows' como Sistema Operativo">
						<u>Versi&oacute;n</u>
					</label>
				</div>
				<div class="col-sm-4">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-registration-mark"></i></span>
						<select class="form-control" id="versionSO" name="versionSO"
						 onchange="javascript:return false;">
							<option value="none">  --  Seleccione una versión --  </option>

							
							<optgroup label="Sistemas Windows">
<?php
								$option = "";
								foreach ($versionesSOWindows as $version){

									$option = '<option value="' . $version["name"] . '">' . $version["name"] . '</option>';
									echo $option;
								}
?>
								<option value="Windows 3.1" disabled="disabled">Windows 3.1</option>

							<optgroup label="Linux">
<?php
								$option = "";
								foreach ($versionesSOotros as $version){

									if ( $version["soBase"] == "Linux" ){
										$option = '<option value="' . $version["name"] . '">' . $version["name"] . '</option>';
										echo $option;
									}
								}
?>
							<optgroup label="Mac">
<?php
								$option = "";
								foreach ($versionesSOotros as $version){

									if ( $version["soBase"] == "Mac" ){
										$option = '<option value="' . $version["name"] . '">' . $version["name"] . '</option>';
										echo $option;
									}
								}
?>
						</select>
						<span id="versionSO-span" class=""></span>
					</div>
				</div>
				
				<div class="col-sm-5">
					<div id="versionSO-error" class="help-block">
						Aseg&uacute;rese de seleccionar uno correspondiente al S.O. arriba seleccionado.
					</div>
				</div>
			</div>

			<div id="nombreSistemaOperativo-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>
						Nombre del Sistema Operativo
					</label>
				</div>
				<div class="col-sm-5">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-th-large"></i></span>
						<select class="form-control" id="nombreSistemaOperativo" name="nombreSistemaOperativo" onchange="javascript:toogleSistemasOperativo(this.value);">
							<option value="none">  --  Seleccione uno --  </option>
<?php
								foreach ($nombresSO as $soNombre){

									$option = '<option value="' . $soNombre["name"] . '">' . $soNombre["name"] . '</option>';
									echo $option;
								}
?>
						</select>
						<span id="nombreSistemaOperativo-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-3">
					<div id="nombreSistemaOperativo-error" class="help-block">
					</div>
				</div>
			</div>

			<div id="tipoLicenciaSO-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>
						Tipo de Licencia
					</label>
				</div>
				<div class="col-sm-5">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-sound-7-1"></i></span>
						<select class="form-control" id="tipoLicenciaSO" name="tipoLicenciaSO">
							<option value="none">  --  Seleccione una --  </option>
<?php
								foreach ($tipoLicencias as $licencia){

									$option = '<option value="' . $licencia["name"] . '">' . $licencia["name"] . '</option>';
									echo $option;
								}
?>
						</select>
						<span id="tipoLicenciaSO-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-3">
					<div id="tipoLicenciaSO-error" class="help-block">
						<a href="https://www.microsoft.com/es/sam/licensingoptions.aspx" target="_blank">&iquest;Qu&eacute; es esto&quest;</a>
					</div>
				</div>
			</div>

			<div id="serialSO-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>N&uacute;mero de Serie <br/>(Serial del Sistema Operativo)</label>
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-sound-5-1"></i></span>
						<input type="text" class="form-control" id="serialSO" name="serialSO"
						 placeholder="Serial del Software que identifica el Sistema Operativo, normalmente en etiquetas o CD's de instalación">
						<span id="serialSO-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-1">
					<div id="serialSO-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-12">
					<div style="color:#E30513;text-align:right;"><b>* = Campo Obligatorio</b></div>
				</div>
			</div>