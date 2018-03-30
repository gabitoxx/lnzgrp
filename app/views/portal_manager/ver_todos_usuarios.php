<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-indent-left logo slideanim"></span>
	<i>Listado de Usuarios de <?= $empresa->nombre; ?></i>&nbsp;&nbsp;&nbsp;
</h4>

<?php if ( isset($no_usuarios) ){ ?>

	<div class="container">
		<h3>
			<?= $empresa->nombre; ?>
		 No posee Usuarios registrados en el Sistema.
		</h3>
		<h4>
			No hay usuarios registrados para <?= $empresa->nombre; ?> ( <?= $empresa->razonSocial; ?> ).
			<br/>
			Por Favor, ponerse en contacto con Lanuza Group para saber c&oacute;mo agregar Usuarios a su Empresa.
		 </h4>
	</div>

<?php 
		/* Destruir la variable una vez usada */
		unset($no_usuarios);

	} else { 
		/* En caso de que haya incidencias, mostrar la tabla */
?>

<div class="container">
	<div id="no-more-tables">
	    <table class="col-md-12 table-hover table-striped cf" style="font-size:12px;">
			<thead class="cf">
				<tr>
					<th align="center">ID<br/> Nº</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Dependencia</th>
					<th>Tel&eacute;fono</th>
					<th>Extensi&oacute;n</th>
					<th>Rol en <br/> Sistema</th>
					<th>Estatus Actual</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($usuarios as $usuario) { ?>
				<tr>
					<td data-title="Nº ID" align="center" style="padding-top: 10px; padding-bottom: 10px;" >
						<?= $usuario["id"] ?>
					</td>
					<td data-title="Nombre"><?= $usuario["nombre"] ?></td>
					<td data-title="Apellido"><?php echo $usuario["apellido"] ?></td>
					<td data-title="Dependencia">
						<?php 
							if ( $usuario["dependencia"] != null && $usuario["dependencia"] != "") {
								echo $usuario["dependencia"];
							} else {
								echo '<h6 style="color:#FFF;">.</h6>';
							}
						?>
					</td>
					<td data-title="Tel&eacute;fono">
						<?php 
							if ( $usuario["telefonoTrabajo"] != null && $usuario["telefonoTrabajo"] != "") {
								echo $usuario["telefonoTrabajo"];
							} else {
								echo '<h6 style="color:#FFF;">.</h6>';
							}
						?>
					</td>
					<td data-title="Extensi&oacute;n">
						<?php 
							if ( $usuario["extensionTrabajo"] != null && $usuario["extensionTrabajo"] != "") {
								echo $usuario["extensionTrabajo"];
							} else {
								echo '<h6 style="color:#FFF;">.</h6>';
							}
						?>
					</td>

					<td data-title="Rol">
					  <?php 
					  	if ( $usuario["role"] == "admin"){ 			echo "Administrador"; }
						else if ( $usuario["role"] == "manager"){   echo "Partner"; }
						else if ( $usuario["role"] == "client"){ 	echo "Usuario"; }
						else if ( $usuario["role"] == "developer"){ echo "Programador"; }
						else if ( $usuario["role"] == "tech"){ 		echo "Ing. de Soporte"; }
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
					
					<td data-title="Acciones">
						<!--
						<button type="button" class="btn btn-success" 
						 onclick="javascript:darDeBaja(<?php echo $usuario["id"] ?>);"
						 data-toggle="tooltip" data-placement="bottom" title="Ver Información de Contacto"
						 >
						<span class="glyphicon glyphicon-info-sign"></span></button>
						-->
						<button type="button" class="btn btn-warning" 
						 onclick="javascript:darDeBaja(<?php echo $usuario["id"] ?>);"
						 data-toggle="tooltip" data-placement="bottom" title="Solicitar dar de Baja a este Usuario"
						 >
						<span class="glyphicon glyphicon-remove-circle"></span></button>
					</td>
				</tr>
				<?php } ?>

			</tbody>
		</table>
	</div>
</div>

<?php 
	} 
?>

<br/>
<fieldset class="scheduler-border">
	<legend class="scheduler-border">Leyenda</legend>
	<div class="row control-group">
		<div class="col-sm-2">Estatus actual:</div>
		<div class="col-sm-10"> es el estado actual del Usuario, donde:</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td class="success">Activo:</td>
					<td>Usuario actualmente activo en el Sistema. 
						Puede generar Incidencias y ver el Estado de su(s) Equipos 
						y Reportes (en caso de tener cuenta tipo Partner la cual posee privilegios administrativos).
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td class="warning">Inactivo:</td>
					<td>Usuario creado en el Sistema pero NO ha sido activado a&uacute;n.
						La Activaci&oacute;n de usuarios es responsabilidad del Administrador
						del Portal <b>Lanuza Group</b>.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td class="danger">Eliminado:</td>
					<td>Usuario NO activo en el Sistema. 
						No puede ingresar al Portal, generar Incidencias ni consultar el estado de los Equipos. 
						Se conserva con fines hist&oacute;ricos e informativos.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-2">Rol en Sistema:</div>
		<div class="col-sm-10"> es el tipo de Usuario, donde:</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td>Partner:</td>
					<td>Posee activas todas las funcionalidades del Portal.
						Puede: generar Incidencias propias o de los Empleados de su Empresa,
						ver el estado de los Equipos (todos los de su Empresa) y generar Reportes.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td>Usuario:</td>
					<td>Usuario b&aacute;sico del Sistema. 
						Puede generar Incidencias propias (para ser atendido por nuestros Ingenieros de Soporte)
						y ver solo el estado del Equipo registrado para su propio uso.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td>Ingeniero de Soporte:</td>
					<td align="left">Empleado de &aacute;mbito tecnol&oacute;gico de la Empresa Lanuza Group
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-2">Acciones:</div>
		<div class="col-sm-10"> en esta Pantalla ud. podr&aacute;:</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td>Dar de Baja:</td>
					<td>
						Esta opci&oacute;n enviar&aacute; un Email al Administrador del Sistema para Solicitar
						formalmente que un Usuario sea eliminado del Sistema
						(ya sea porque dicha persona no trabaja m&aacute;s en su Empresa u otra raz&oacute;n similar).
					</td>
				</tr>
			</table>
		</div>
	</div>
</fieldset>

<script>
	function darDeBaja(usuarioId){
		alert("EN CONSTRUCCION \n\nEsta opción enviará un Email al Administrador del Sistema para Solicitar formalmente que este Usuario sea eliminado del Sistema (ya sea porque dicha persona no trabaja más en su Empresa u otra razón similar).");
	}
</script>