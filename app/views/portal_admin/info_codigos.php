
<fieldset class="scheduler-border">
	
	<legend class="scheduler-border">Importante</legend>
	
	<div class="row control-group">
		<div class="col-sm-2">C&oacute;digo de Barras:</div>
		<div class="col-sm-10">
			el <b>c&oacute;digo de barras</b> que gener&oacute; el Sistema para todos los Equipos siguen el siguiente Esquema:
		</div>
	</div>

	<br/><br/>

	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10" style="text-align:center;font-family:monospace;font-size: 60px;"> 
<?php
	$companyId  = "1234";
	$tipoEquipo = "01";
	$id 		= "5678";
?>			
			<img id="imgX" alt="Codigo de barras generado" src="<?= APPIMAGEPATH; ?>barcode_example.png" />
			<br/>
			<span style="color:#0D181C;">
				<?= $companyId; ?>
			</span>
			<span style="color:#E30513;">
				<?= $tipoEquipo; ?>
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
			<br/><br/><br/>
			- <span style="color:#0D181C;">los primeros 4 d&iacute;gitos</span>: son el <b>ID de la Empresa en el Portal</b>.
			<br/><br/><br/>
			- <span style="color:#E30513;">el d&iacute;gito 5º y 6º</span>: son el <b>ID del Tipo de Equipo (Presentaci&oacute;n)</b>: Servidor, Todo-en-Uno, Escritorio, Port&aacute;til, etc.
			<br/>
			(*VER ABAJO EL LISTADO)
			<br/><br/><br/>
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

<br/><br/><br/>

<div class="container">
	<div id="no-more-tables">
		<table id="tableIncidenciasGerente" class="col-md-12 table-hover table-striped cf" style="font-size: 16px;">
			<thead class="cf">
				<tr>
					<th width="90px" class="active" align="rigth">ID del Tipo de Equipo</th>
					<th width="200px" align="left">Presentaci&oacute;n</th>
					<th width="200px">Observaciones</th>
				</tr>
			</thead>
			<tbody>

				<?php 
					foreach ($codigos as $codigo) { 
				?>
				<tr>
					<td data-title="Tipo de Equipo" align="rigth" style="text-align: right;padding-right: 20px;padding-bottom: 10px;">
						<?= $codigo["tipoEquipoId"]; ?>
					</td>
					<td data-title="Presentaci&oacute;n" align="left" style="text-align: left;padding-right: 20px;padding-bottom: 10px;">
						<?= $codigo["nombre"]; ?>
					</td>
					<td data-title="Observaciones"><?php if ( $codigo["observaciones"] != NULL && $codigo["observaciones"] != "" ) echo $codigo["observaciones"]; ?></td>
				</tr>

				<?php  } ?>

			</tbody>
		</table>
	</div>
</div>