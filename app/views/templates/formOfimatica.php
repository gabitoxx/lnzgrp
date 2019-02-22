<br/>
			<hr/>
			<br/>
			<h4 style="text-align:center; color:#000;">
				<span class="glyphicon glyphicon-text-size"></span> 
				<i>Herramienta Ofim&aacute;tica</i>&nbsp;&nbsp;&nbsp;
			</h4>
			<br/>

			<div id="office-div" class="form-group">
				<div class="col-sm-3" align="right">
					<label>Office con Licencia<b style="color:#E30513;font-size:18px;">*</b></label>
				</div>
				<div class="col-sm-6">
					<div class="input-group">
						<label class="radio-inline">
						  <input type="radio" name="office" id="office1" value="Si" onclick="javascript:toogleLicOffice(1);">
							S&iacute;
						</label>
						&nbsp;&nbsp;&nbsp;
						<label class="radio-inline">
						  <input type="radio" name="office" id="office2" value="No" onclick="javascript:toogleLicOffice(0);">
							No
						</label>
						&nbsp;&nbsp;&nbsp;
						<label class="radio-inline">
						  <input type="radio" name="office" id="office3" value="Desconocido" onclick="javascript:toogleLicOffice(1);">
							Desconocido / No es Windows Office
						</label>
					</div>
				</div>
				<div class="col-sm-3">
					<div id="office-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>


			<div id="herramientaOfimatica-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>
						Herramienta Ofim&aacute;tica<b style="color:#E30513;font-size:18px;">*</b>
					</label>
				</div>
				<div class="col-sm-3">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-text-size"></i></span>
						<select class="form-control" id="herramientaOfimatica" name="herramientaOfimatica"
							 onchange="javascript:toogleOfimatica(this.value);">
								<option value="none">  --  Seleccione una --  </option>
<?php
									$option = "";
									foreach ($ofimatica as $tool){

										$option = '<option value="' . $tool["name"] . '">' . $tool["name"] . '</option>';
										echo $option;
									}
?>
							</select>
						 <span id="herramientaOfimatica-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-6">
					<div id="herramientaOfimatica-error" class="help-block">
						Si existe alguna que no est&eacute; en este listado, 
						por favor notificarlo al Equipo de Desarrollo
						del Portal Lanuzasoft para agregarlo a este listado.
					</div>
				</div>
			</div>

			<div id="nombreOfimatica-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>
						<u>Nombre de la Herramienta<br/>(en caso de "Otra")</u>
					</label>
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-registration-mark"></i></span>
						<input type="text" class="form-control" id="nombreOfimatica" name="nombreOfimatica" disabled="disabled" 
						 placeholder="En caso de seleccionar arriba la opción OTRA">
						<span id="nombreOfimatica-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-1">
					<div id="nombreOfimatica-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>


			<div id="nombreHerramientaOfimatica-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>
						Nombre de Herramienta Ofim&aacute;tica
					</label>
				</div>
				<div class="col-sm-5">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-registration-mark"></i></span>
						<select class="form-control" id="nombreHerramientaOfimatica" name="nombreHerramientaOfimatica">
								<option value="none">  --  Seleccione una --  </option>
<?php
									$option = "";
									foreach ($ofimaticaSoftwareNombres as $tool){

										$option = '<option value="' . $tool["name"] . '">' . $tool["name"] . '</option>';
										echo $option;
									}
?>
							</select>
						 <span id="nombreHerramientaOfimatica-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-4">
					<div id="nombreHerramientaOfimatica-error" class="help-block">
					</div>
				</div>
			</div>


			<div id="versionHerramientaOfimatica-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>
						Versi&oacute;n de Herramienta Ofim&aacute;tica
					</label>
				</div>
				<div class="col-sm-5">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-sound-7-1"></i></span>
						<select class="form-control" id="versionHerramientaOfimatica" name="versionHerramientaOfimatica">
								<option value="none">  --  Seleccione una versión --  </option>
<?php
									$option = "";
									foreach ($versionesOfimaticaSoftware as $tool){

										$option = '<option value="' . $tool["name"] . '">' . $tool["name"] . '</option>';
										echo $option;
									}
?>
							</select>
						 <span id="versionHerramientaOfimatica-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-4">
					<div id="versionHerramientaOfimatica-error" class="help-block">
					</div>
				</div>
			</div>


			<div id="tipoLicenciaOfimatica-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>
						Tipo de Licencia
					</label>
				</div>
				<div class="col-sm-5">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-sound-7-1"></i></span>
						<select class="form-control" id="tipoLicenciaOfimatica" name="tipoLicenciaOfimatica">
							<option value="none">  --  Seleccione una --  </option>
							<?php
								foreach ($tipoLicencias as $licencia){

									$option = '<option value="' . $licencia["name"] . '">' . $licencia["name"] . '</option>';
									echo $option;
								}
							?>
						</select>
						<span id="tipoLicenciaOfimatica-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-3">
					<div id="tipoLicenciaOfimatica-error" class="help-block">
						<a href="https://www.microsoft.com/es/sam/licensingoptions.aspx" target="_blank">&iquest;Qu&eacute; es esto&quest;</a>
					</div>
				</div>
			</div>


			<div id="serialOfimatica-div" class="row form-group">
				<div class="col-sm-3" align="right">
					<label>N&uacute;mero de Serie <br/>(Serial de la Herramienta Ofim&aacute;tica)</label>
				</div>
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-sound-6-1"></i></span>
						<input type="text" class="form-control" id="serialOfimatica" name="serialOfimatica"
						 placeholder="Serial del Software que identifica el Office u otra H.O., normalmente en etiquetas o CD's de instalación">
						<span id="serialOfimatica-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-1">
					<div id="serialOfimatica-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>


			<div class="form-group">
				<div class="col-sm-12">
					<div style="color:#E30513;text-align:right;"><b>* = Campo Obligatorio</b></div>
				</div>
			</div>