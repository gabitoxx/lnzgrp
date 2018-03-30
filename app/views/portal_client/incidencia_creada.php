<?php if ( isset($incidencia_generada_correctamente) ){ ?>

	<div class="container">
		<h3><span class="glyphicon glyphicon-ok-sign logo"></span> Usted ha generado una nueva <b>Incidencia</b> satisfactoriamente.
		</h3>
		<br/> 
		<h4>A la brevedad posible, uno de nuestros T&eacute;cnicos de Lanuza Group<br/> 
			  se pondr&aacute; en contacto con usted para darle Soporte en su inconveniente.<br/> 
			  <br/> 
			  Las Incidencias creadas por usted las podr&aacute; ver en el men&uacute; izquierdo: <b>Ver Incidencias</b>,
			   o en el superior: <b>Consulta de Incidencias</b>
		 </h4>
	</div>

<?php 
		/* Destruir la variable una vez usada */
		unset($incidencia_generada_correctamente);

	} else { 
		/* En caso de que haya incidencias, mostrar la tabla */
?>
	<div class="container">
		<h3><span class="glyphicon glyphicon-remove-sign logo"></span> Error durante la creaci&oacute;n de la nueva <b>Incidencia</b>.
		</h3>
		<h4>Por favor intente m&aacute;s tarde. Si persiste el error comun&iacute;quese con nuestros T&eacute;cnicos de Lanuza Group<br/>
		 </h4>
	</div>

<?php } ?>