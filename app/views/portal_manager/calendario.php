<?php
include( "CalendarIterator.php" );

date_default_timezone_set("America/Bogota");
setlocale(LC_ALL, 'es_CO');


// get the year and number of week from the query string and sanitize it
$year  = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);
$month = filter_input(INPUT_GET, 'month', FILTER_VALIDATE_INT);

// initialize the calendar object
$calendar = new calendar();

// get the current month object by year and number of month
$currentMonth = $calendar->month($year, $month);

// get the previous and next month for pagination
$prevMonth = $currentMonth->prev();
$nextMonth = $currentMonth->next();

// generate the URLs for pagination
$prevMonthURL = sprintf('?year=%s&month=%s', $prevMonth->year()->int(), $prevMonth->int());
$nextMonthURL = sprintf('?year=%s&month=%s', $nextMonth->year()->int(), $nextMonth->int());
/*
 * Mes actual
 */
$currentMonthURL = sprintf('?year=%s&month=%s', $year, $month);

// set the active tab for the header
$activeTab = 'month';

?>

<style type="text/css">
* {
	margin: 0;
	padding: 0;  
}

html {
	-webkit-font-smoothing: antialiased;
	overflow-y: scroll;
}

body {
	font-family: Helvetica, Arial, sans-serif;
	background: #eee;
	color: #222;
	margin: 50px;
}

li {
	list-style: none;
}

a {
	color: red;
	text-decoration: none;
}


h1 {
	text-align: center;
	margin-bottom: 50px;
}
h1 a {
	color: inherit;
	border-bottom: 1px solid red;
	padding-bottom: 1px;
}
h1 a:hover {
	color: red;
}
h1 a.arrow {
	color: red;
	border-bottom: none;
}


header {
	margin: -50px -50px 50px;
	background: #222;
	text-align: center;
	box-shadow: rgba(0,0,0, .1) 0px 2px 10px;
}
header nav li {
	display: inline-block;
	margin: 10px -3px 10px 0;
}
header nav li:first-child a {
	border-top-left-radius: 3px;
	border-bottom-left-radius: 3px;
}
header nav li:last-child a {
	border-top-right-radius: 3px;
	border-bottom-right-radius: 3px;
}
header nav li a {
	display: block;
	color: #fff;
	background: #444;
	font-weight: bold;
	font-size: 14px;
	padding: 5px 20px;
}
header nav li a.active {
	background: #666;
}


table {
	border-spacing: 0;
	background: #fff;
	width: 100%;
}


.year ul {
	margin-right: -2%;
	overflow: hidden;
}
.year li {
	float: left;
	width: 23%;
	margin-bottom: 2%;
	margin-right: 2%;
	box-shadow: rgba(0,0,0, .05) 0px 2px 5px;
}
.year li h2 {
	background: red;
	color: #fff;
	border: 1px solid red;
	padding: 10px;
	text-align: center;
	font-weight: normal;
	font-size: 18px;
	box-shadow: rgba(255,255,255, .06) 0px 1px 0px inset;
}
.year li h2 a {
	color: inherit;
}
.year li table {
	height: 200px;
	border-left: 1px solid #e6e6e6;
}
.year li th,
.year li td { 
	vertical-align: middle;
	text-align: center;
	border-bottom: 1px solid #e6e6e6;
	border-right: 1px solid #e6e6e6;
	width: 14.2%;
	box-shadow: rgba(255,255,255, .06) 0px 1px 0px inset;
}
.year li th {
	font-size: 12px;
	font-weight: normal;
	border-bottom: 1px solid red;
	color: red;
}
.year li td strong {
	color: red;
}
.year li td.inactive {
	background: #fff;
	color: rgba(0,0,0, .2);
}


.month table {
	box-shadow: rgba(0,0,0, .05) 0px 2px 5px;
	table-layout: fixed;
}
.month th,
.month td { 
	vertical-align: middle;
	text-align: center;
	border-bottom: 1px solid #000000; /* e6e6e6 */
	border-right: 1px solid #000000; /* e6e6e6 */
	box-shadow: rgba(255,255,255, .06) 0px 1px 0px inset;
}
.month th {
	font-size: 12px;
	font-weight: normal;
	border-bottom: 1px solid red;
	color: black;
	padding: 10px 0;
	background: #99bbff;
	font-size: 18px;
}
.month td {
	height: 120px;
}
.month td.inactive {
	background: #ccc;
	color: rgba(0,0,0, .2);
}
.month td strong {
	color: red;
}


.week table {
	box-shadow: rgba(0,0,0, .05) 0px 2px 5px;
	table-layout: fixed;
}
.week th,
.week td { 
	vertical-align: middle;
	text-align: center;
	border-bottom: 1px solid #e6e6e6;
	border-right: 1px solid #e6e6e6;
	box-shadow: rgba(255,255,255, .06) 0px 1px 0px inset;
}
.week th {
	font-size: 12px;
	font-weight: normal;
	border-bottom: 1px solid red;
	color: red;
	padding: 10px 0;
}
.week li {
	border-bottom: 1px solid #e6e6e6;
	padding: 10px 0;
}

.rowImpar {
	background-color: #FFF;
}
.rowPar {
	background-color: #CCC;
}

</style>

<div class="row">
<div class="col-sm-offset-1 col-sm-11">
	<h4>
		<span class="glyphicon glyphicon-calendar" style="color:<?= RGB_MANAGER; ?>; font-size:18px; "></span> 
		Calendario de Soportes Programados para:
		<b><?= $company->nombre ?></b> 
		<?php if($company->razonSocial!=NULL && $company->razonSocial!="") echo "<i>(" . $company->razonSocial . ")</i>" ?>
	</h4>
	<h6>
		Para ver las Citas en formato de lista, puede dirigirse a la opci&oacute;n <b>Soportes -&gt; "Listado Soportes"</b>
		del Men&uacute;.
	</h6>
	<h6>
		En esta secci&oacute;n Usted podr&aacute; VER los Soportes que <i>Lanuza Group</i> ha programado para su Empresa.
		Ademas podr&aacute; realizar <b>Solicitudes de futuras Citas de Soporte</b> en nuestra 
		<span class="glyphicon glyphicon-calendar" style="color:<?= RGB_MANAGER; ?>; font-size:18px; "></span> Agenda.
		<br/>
		(Si desea que nuestros Ingenieros de Soporte visiten su Empresa por motivos de
		<b><u>fallas en sus Equipos</u></b>, debe crearla a trav&eacute;s del la opci&oacute;n <b>Incidencias -&gt; "Crear Incidencia"</b>)
	</h6>
	<h6>
		<mark>Pulse sobre el d&iacute;a para Conocer + info y Crear/Modificar sus Solicitudes.</mark>
	</h6>
</div>
</div>


<section class="month">

	<h1>
		<a class="arrow" href="<?php echo $prevMonthURL ?>"
		 data-toggle="tooltip" data-placement="bottom" title="Mes Anterior">&larr;</a> 
		
		<?php  
			$mes = $currentMonth->name();
			if ( $mes == "January" 		 || $mes == "enero" ){      $mes = "Enero"; }
			else if ( $mes == "February" || $mes == "febrero" ){    $mes = "Febrero"; }
			else if ( $mes == "March" 	 || $mes == "marzo" ){      $mes = "Marzo"; }
			else if ( $mes == "April" 	 || $mes == "abril" ){      $mes = "Abril"; }
			else if ( $mes == "May" 	 || $mes == "mayo" ){       $mes = "Mayo"; }
			else if ( $mes == "June" 	 || $mes == "junio" ){      $mes = "Junio"; }
			else if ( $mes == "July" 	 || $mes == "julio"){       $mes = "Julio"; }
			else if ( $mes == "August"	 || $mes == "agosto" ){     $mes = "Agosto"; }
			else if ( $mes == "September" || $mes== "septiembre" ){ $mes = "Septiembre"; }
			else if ( $mes == "October"  || $mes == "octubre" ){    $mes = "Octubre"; }
			else if ( $mes == "November" || $mes == "noviembre"){   $mes = "Noviembre"; }
			else if ( $mes == "December" || $mes == "diciembre"){   $mes = "Diciembre"; }
			else {  /* echo $mes; */ }
			echo $mes;
		?>

		<?php 
			$anyo = $currentMonth->year()->int(); 
			echo $anyo;
		?>

		<a class="arrow" href="<?php echo $nextMonthURL ?>"
		 data-toggle="tooltip" data-placement="bottom" title="Siguiente Mes">&rarr;</a>
	</h1>

	<table border="1">
		<tr>

			<?php foreach($currentMonth->weeks()->first()->days() as $weekDay): ?>
			<th>
				<?php 
					$dia = $weekDay->shortname();
					if ( 	  $dia == "Mon" || $dia == "lun" ){ 	echo "Lun"; }
					else if ( $dia == "Tue" || $dia == "mar" ){ 	echo "Mar"; }
					else if ( $dia == "Wed" || $dia == "mié" || substr($dia, 0, 2) == "mi" ){ 	echo "Mi&eacute;"; }
					else if ( $dia == "Thu" || $dia == "jue" ){ 	echo "Jue"; }
					else if ( $dia == "Fri" || $dia == "vie" ){ 	echo "Vie"; }
					else if ( $dia == "Sat" || $dia == "sáb" || substr($dia, 0, 1) == "s" ){ 	echo "S&aacute;b"; }
					else if ( $dia == "Sun" || $dia == "dom" ){ 	echo "Dom"; }
					else {	echo $dia;  }
				?>
			</th>
			<?php endforeach ?>
		</tr>


		<?php foreach($currentMonth->weeks(6) as $week): ?>

			<tr style="cursor:pointer;">  

				<?php foreach($week->days() as $day): ?>
					<!-- La clase INACTIVA es para los dias que NO son del MES actual -->
					<td
					<?php 
						$dia2 = $day->int();
						// $enElPasado1 = $day->int()->isInThePast();
						$enElPasado = "false";
						if ( $day->isInThePast() == "1" || $day->isInThePast() == 1 ){
							$enElPasado = "true";
						}
						if ( $day->isToday() ){
							echo ' style="background-color: yellow; "';
						}


						if ( $day->month() != $currentMonth) {
							echo ' class="inactive"' ;
						} else {
					?>
						onclick="javascript:showModal('<?= $anyo ; ?>' , '<?= $mes ; ?>' , '<?= $dia2 ; ?>' , '<?= $enElPasado; ?>');"

					<?php } ?>

					>

						<?php echo ($day->isToday()) ? '<strong>' . $day->int() . '</strong> (hoy)' : $day->int() ?>

						<?php 
							/* dia actual */
							$x = $day->int();
							foreach ($citas as $cita) { 

								/* SI en dia actual hay una cita */
								if ( $x == $cita["dia_cita"] && $cita["estatusCita"] != "Eliminada" ) {

									if ( $cita["aceptada"] == "no" ){
										/* color rojo */
										echo '<br/><span class="glyphicon glyphicon-wrench" style="color:#E30513; font-size:18px; "></span>';
									} else {
										/* otro color */
										echo '<br/><span class="glyphicon glyphicon-wrench" style="color:#3C763D; font-size:18px; "></span>';
									}
								}
							}
						?>
						

					</td>

				<?php endforeach ?>  

			</tr>

		<?php endforeach ?>


	</table>

</section>

<!-- ==========================   Formularios HIDDEN para serializar y enviar opciones  ============================== -->
<?php
	echo "<script>";
	echo " var modalAjaxURL3 = '" . PROJECTURLMENU . "portal/crear_soporte';" ;
	echo " var modalAjaxURL4 = '" . PROJECTURLMENU . "portal/ajax_soportes_table';" ;
	echo " var modalAjaxURL5 = '" . PROJECTURLMENU . "portal/actualizar_soporte_cita';" ;
	echo " var currentMonthURL = '" . $currentMonthURL . "';" ;
	echo "</script>";
?>

<form class="form-horizontal" data-toggle="validator" role="form" id="buscar_soportes_form"
 	method="post" enctype="multipart/form-data">

 	<input type="hidden" id="ajax_year" name="ajax_year" value="" />
	<input type="hidden" id="ajax_mes"  name="ajax_mes"  value="" />
	<input type="hidden" id="ajax_dia"  name="ajax_dia"  value="" />
</form>

<form class="form-horizontal" data-toggle="validator" role="form" id="actualizar_cita_form"
 	method="post" enctype="multipart/form-data" >
	<input type="hidden" id="cita_id" 	name="cita_id" 		value="" />
	<input type="hidden" id="cita_hora" name="cita_hora"  	value="" />
	<input type="hidden" id="cita_pm"   name="cita_pm"  	value="" />
	<input type="hidden" id="accion"    name="accion"		value="" />
</form>

<!-- ==========================================   Scripts ================================================== -->
<script>
	
	function showModal(year, mesNombre, diaNumero, bDiaYaPasado){
		/* alert( year + " * " + mesNombre + " - " + diaNumero + " ---> " + bDiaYaPasado ); */

		/* muestra modal */
		$('#myModal').modal({
			backdrop: 'static',
			keyboard: false,
			show: true
		});


		/**
		 * Esto permitirá que NO se generen CITAs para fechas en el PASADO
		 */
		if ( bDiaYaPasado == "true" ){
			/* Deshabilitando Boton PASADO */
			document.getElementById("createNuevaCita").setAttribute("disabled", "disabled");

		} else {
			/* NO crear CITAS para el mismo dia */
			if( today(year, mesNombre, diaNumero) ){
				document.getElementById("createNuevaCita").setAttribute("disabled", "disabled");
			} else {
				document.getElementById("createNuevaCita").removeAttribute("disabled");	
			}

			/*
			 * actualizando los valores al dia seleccionado para el FORMULARIO
			 */
			document.getElementById("soporte_year").value = year;
			document.getElementById("soporte_mes").value  = mesNombre;
			document.getElementById("soporte_dia").value  = diaNumero;
		}

		/**
		 * Buscando info del Dia
		 */
		document.getElementById("ajax_year").value = year;
		document.getElementById("ajax_mes").value  = mesNombre;
		document.getElementById("ajax_dia").value  = diaNumero;

		$.ajax({
			type: "POST",
			url: modalAjaxURL4,
			data: $('#buscar_soportes_form').serialize(),
			success: function(message){
				crearFilasCitas(message, bDiaYaPasado);
			},
			error: function(){
				alert("Error al buscar info de Empresas en nuestro Sistema\nPor favor, intente más tarde");
			}
		});
		
		document.getElementById("modalTitulo").innerHTML = "Información del Día: " + diaNumero + " / " + mesNombre + " / " + year;
		
		/* DESHABILITANDO TODOS Botones de modificaciones de Citas */
		document.getElementById("appointment_delete").setAttribute("disabled", "disabled");
		document.getElementById("appointment_accept").setAttribute("disabled", "disabled");
		document.getElementById("change_hour").setAttribute("disabled", "disabled");

	}

	function crearSoporte(){

		var bool = true;

		if ( $("#hora").val() == "none" ){
			bool = false;
			document.getElementById("hora-div").className = "form-group has-error has-feedback";
		} else {
			document.getElementById("hora-div").className = "form-group";
		}
		
		if ( $("#trabajoArealizar").val() == "" ){
			bool = false;
			document.getElementById("trabajoArealizar-div").className = "form-group has-error has-feedback";
		} else {
			document.getElementById("trabajoArealizar-div").className = "form-group";
		}
		
		/* Envia formulario */
		if ( bool ){

			var ask = confirm("Esta Solicitud será añadida a la Agenda de Ingenieros de Soporte disponibles de Lanuza Group."
					+ "\n\n\n Esta entrada en nuestra Agenda será analizada y en caso de ser aceptada "
					+ "se le notificará a través del Portal y a su Correo electrónico. Se aceptará según la "
					+ "DISPONIBILIDAD de nuestros Ingenieros de Soporte. \n\n\n ¿Desea continuar?");
			if ( ask == true) {
			
				enviarPeticionAJAX(modalAjaxURL3, "#crear_soporte_form", "Solicitud de Soporte TI agendado. Se anotará en nuestra Agenda...", 5, 3);

				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}

	/**
	 * Enviar DATA via AJAX
	 */
	function enviarPeticionAJAX(AJAX_URL, formId, snackbarMessage, snackbarSegundos, refreshSegundos){

		$('#myModal').modal('hide');

		/* Get the snackbar DIV */
		var x = document.getElementById("snackbar");

		x.innerHTML = snackbarMessage;

		/* Add the "show" class to DIV */
		x.className = "show";

		/* After 5 seconds, remove the show class from DIV */
		setTimeout(function(){ x.className = x.className.replace("show", ""); }, (snackbarSegundos * 1000) );

		$.ajax({
			type: "POST",
			url: AJAX_URL,
			data: $(formId).serialize(),
			success: function(message){
				/* alert("OK__"+message); */
			},
			error: function(){
				alert("Error de Base de Datos\nPor favor, intente más tarde");
			}
		});

		/* After 3 seconds, REFRESH THE PAGE */
		setTimeout(function(){ location.href = currentMonthURL; }, (refreshSegundos * 1000) );
	}

	/**
	 * Crear FILAS en la tabla de CITAs una vez pulsado el DIA
	 */
	var filasCreadas = 0;
	function crearFilasCitas(pipeSeparated, bDiaYaPasado){

		eraseTable();

		/*
		 * Separandolos y dejandolos en un Arreglo
		 */
		var array = pipeSeparated.split('|');

		/* Find a <table> element with id="myTable": */
		var table = document.getElementById("myTable");

		var iHasta7 = 0;
		var filas = 1;/* empieza en 1 para saltar el Encabezado <thead> */
		var row;
		var cell;
		if ( array.length > 1 ){
			for ( var i = 0; i < array.length; i++ ){


				if ( iHasta7 == 0 ){
					/* Create an empty <tr> element and add it to the 1st position of the table: */
					row = table.insertRow(filas);

					if ( filas % 2 == 0 ) {
						row.className = "rowPar";
					} else {
						row.className = "rowImpar";
					}
				}

				if ( iHasta7 < 7 ){
					/* Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element: */
					cell = row.insertCell(iHasta7);

					/* Add some text to the new cells: */
					cell.innerHTML = array[i];
				}

				/* Otro TR y volver al inicio de Tabla */
				if ( iHasta7 == 7 ){
					iHasta7 = -1; /*para que entre en el if 0 otra vez */

					cell = row.insertCell(7);
					cell.innerHTML = "<input type=\"radio\" name=\"soporteProgId\" id=\"soporteProgId\" value=\""+ array[i] +"\" onclick=\"javascript:habilitarBotonesCitas("+bDiaYaPasado+");\">";
					
					filas++;
					filasCreadas++;
				}

				iHasta7++;
			}
		}
		if ( filas <= 1 ){
			document.getElementById("change_hour").setAttribute("disabled", "disabled");
		}
	}


	/**
	 * Borrar filas al salir
	 */
	function eraseTable(){

		var limit    = filasCreadas + 99;
		filasCreadas = 0;

		try {
			var table = document.getElementById("myTable");

			for ( var i = 1; i <= limit; i++){
				table.deleteRow(i);
			}
		} catch(err) {
			/* JavaScript will actually create an Error object with two properties: name and message. */
			/* document.getElementById("demo").innerHTML = err.message;   alert(err.message);  */
		}

		if ( hideout ) {
			toogleTextArea("otra_sucursal");
		}
	}

	function habilitarBotonesCitas(bDiaYaPasado){
		if ( bDiaYaPasado == false ) {
			/*
			 * Solo habilita los botones SI EL DIA NO HA PASADO aun
			 */
			document.getElementById("appointment_accept").removeAttribute("disabled");
			document.getElementById("appointment_delete").removeAttribute("disabled");
			document.getElementById("change_hour").removeAttribute("disabled");
		}
	}

	/**
	 * Cambiar la HORA
	 */
	function changeHour(){

		if ( $("#cambiar_hora_combo").val() == "none" ){

			alert("Seleccione PRIMERO una HORA para establecer el Cambio.");
			return false;

		} else {

			var id = $('input[type=radio][name=soporteProgId]:checked').val();

			document.getElementById("cita_id").value = id;
			document.getElementById("cita_hora").value = $("#cambiar_hora_combo").val();
			document.getElementById("cita_pm").value = $("#cambiar_pm_combo").val();

			document.getElementById("accion").value = "cambiar_hora";
			
			/*document.getElementById("actualizar_cita_form").submit();*/

			enviarPeticionAJAX(modalAjaxURL5, '#actualizar_cita_form', "Cita de Soporte actualizada en nuestra Agenda. Reagendando...", 5, 3);

			return true;
		}
	}

	function aceptarCita(){

		var ask = confirm("¿Seguro de ACEPTAR esta cita agendada de Soporte Programado?"
			+ "\n\nCon esta Acción, Usted está notificando a nuestros Ing. de Soporte que dicha cita (DÍA-HORA) "
			+ "es aceptada para que en Su Empresa lo visitemos a esa hora");

		if ( ask == true) {

			var id = $('input[type=radio][name=soporteProgId]:checked').val();

			document.getElementById("cita_id").value = id;

			document.getElementById("accion").value = "aceptar_cita";

			enviarPeticionAJAX(modalAjaxURL5, '#actualizar_cita_form', "Cita (DÍA y HORA) de Soporte Programado ACEPTADA. Agendando en nuestro Calendario...", 5, 3);

			return true;
		}
	}

	function eliminarCita(){

		var ask = confirm("¿Seguro de ELIMINAR esta cita Agendada para este día?");
		if ( ask == true) {

			var id = $('input[type=radio][name=soporteProgId]:checked').val();

			document.getElementById("cita_id").value = id;

			document.getElementById("accion").value = "Eliminada";

			enviarPeticionAJAX(modalAjaxURL5, '#actualizar_cita_form', "Cita de Soporte Programado ELIMINADA. Eliminando de nuestra Agenda...", 5, 5);

			return true;
		}
	}

	var hideout = false;
	function toogleTextArea(idTextArea){
		if ( hideout ){
			var element = document.getElementById(idTextArea);
			element.setAttribute("disabled", "disabled");
			element.style.backgroundColor = "#d9d9d9";
			element.value = "";
			hideout = false;
		} else {
			document.getElementById(idTextArea).removeAttribute("disabled");
			document.getElementById(idTextArea).style.backgroundColor = "#FFF";
			hideout = true;
		}
	}

	/**
	 * Para validar si es el dia de HOY
	 */
	function today(year, mesNombre, diaNumero){
		var m2 = getMesNumero(mesNombre);

		var d = new Date();
		var n = d.getDate();		/* Returns the day of the month (from 1-31) */
		var m = d.getMonth();		/* Returns the month (from 0-11) */
		var y = d.getFullYear();

		if ( y == year && m == m2 && n == diaNumero ){
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Obtiendo MES para JavaScript ( Date().getMonth() Returns the month, according to universal time (from 0-11) )
	 */
	function getMesNumero(mesNombre){
		var mesNumero = 0;
		if ( mesNombre == "Enero" 		 	|| mesNombre == "enero" ){     mesNumero = 0; }
		else if ( mesNombre == "Febrero" 	|| mesNombre == "febrero" ){   mesNumero = 1; }
		else if ( mesNombre == "Marzo" 		|| mesNombre == "marzo" ){     mesNumero = 2; }
		else if ( mesNombre == "Abril" 		|| mesNombre == "abril" ){     mesNumero = 3; }
		else if ( mesNombre == "Mayo" 	 	|| mesNombre == "mayo" ){      mesNumero = 4; }
		else if ( mesNombre == "Junio" 	 	|| mesNombre == "junio" ){     mesNumero = 5; }
		else if ( mesNombre == "Julio" 	 	|| mesNombre == "julio"){      mesNumero = 6; }
		else if ( mesNombre == "Agosto"	 	|| mesNombre == "agosto" ){    mesNumero = 7; }
		else if ( mesNombre == "Septiembre" || mesNombre== "septiembre" ){ mesNumero = 8; }
		else if ( mesNombre == "Octubre"  	|| mesNombre == "octubre" ){   mesNumero = 9; }
		else if ( mesNombre == "Noviembre"  || mesNombre == "noviembre"){  mesNumero = 10; }
		else if ( mesNombre == "Diciembre"  || mesNombre == "diciembre"){  mesNumero = 11; }
		else {  /* echo mesNombre; */ }
		return mesNumero;
	}

</script>


<!-- ========================= MODAL para ver la info del Técnico ============================ -->
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <!-- button type="button" class="close" data-dismiss="modal">&times;</button -->
		  <h4 class="modal-title" align="center" style="color: red;">
			<span class="glyphicon glyphicon-calendar"></span> 
			<span id="modalTitulo"></span> 
		  </h4>
		</div>

		<div class="modal-body">

<!-- ====================  Opcion de CREAR una nueva cita para Soportes Programados  ========================================= -->

			<form class="form-horizontal" data-toggle="validator" role="form" id="crear_soporte_form"
 			 method="post" enctype="multipart/form-data">


	 			<input type="hidden" id="soporte_year" name="soporte_year" value="" />
				<input type="hidden" id="soporte_mes"  name="soporte_mes"  value="" />
				<input type="hidden" id="soporte_dia"  name="soporte_dia"  value="" />


				<div class="row">
					<div class="col-sm-12" align="center">
						<br/>
						Realizar <b>Solicitud de Cita</b>:
						con esta opci&oacute;n usted <i>propone una Fecha para AGENDAR</i> los Soportes Programados.
						<br/>
						<h6>(la misma estar&aacute; sujeta a la disponibilidad de nuestros Ingenieros de Soportes y se le notificar&aacute; a usted 
						a trav&eacute;s de este Portal y su correo electr&oacute;nico)</h6>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" align="right">
						<label>Soporte Programado para</label>
					</div>
					<div class="col-sm-8">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
							<input type="text" class="form-control" disabled="disabled" style="background-color:#d9d9d9" 
							<?php 
								if ($company->razonSocial != NULL && $company->razonSocial != ""){
									echo "value=\"" . $company->nombre . " (" . $company->razonSocial . ")\"";
								} else {
									echo "value=\"" . $company->nombre . "\"";
								}
							?>
							>
						</div>
					</div>
					<div class="col-sm-1">&nbsp;</div>
				</div>
				<div class="row" id="hora-div">
					<div class="col-sm-3" align="right">
						<label>Hora estimada</label>
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							<select class="form-control" id="hora" name="hora" onblur="javascript:return false;">
								<option value="none">-</option>
								<option value="1" >1</option>
								<option value="2" >2</option>
								<option value="3" >3</option>
								<option value="4" >4</option>
								<option value="5" >5</option>
								<option value="6" >6</option>
								<option value="7" >7</option>
								<option value="8" >8</option>
								<option value="9" >9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
							</select>
						</div>
					</div>
					<div class="col-sm-2">
							<select class="form-control" id="am_pm" name="am_pm" onblur="javascript:;return false;">
								<option value="AM" >A.M.</option>
								<option value="PM" >P.M.</option>
							</select>
					</div>
					<div class="col-sm-1">&nbsp;</div>
				</div>
				<div class="row" id="trabajoArealizar-div">
					<div class="col-sm-3" align="right">
						<label>Trabajo a realizar</label>
					</div>
					<div class="col-sm-8">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-wrench"></i></span>
							<textarea class="form-control" id="trabajoArealizar" name="trabajoArealizar" rows="2"
							 placeholder="Descripción breve del Servicio que desea que realicemos en su Empresa o si este Servicio ya fue pautado con anterioridad"
							 ></textarea>
						</div>
					</div>
					<div class="col-sm-1">&nbsp;</div>
				</div>
				<div class="row">
					<div class="col-sm-3" align="right">
						<label>Direcci&oacute;n registrada</label>
					</div>
					<div class="col-sm-8">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
							<?php
								$a1="";$a2="";$a3="";
								if ( $company->ciudad!=NULL && $company->ciudad!="" ){
									$a1 = $company->ciudad . " - ";
								}
								if ( $company->departamento_Estado!=NULL && $company->departamento_Estado!="" ){
									$a2 = $company->departamento_Estado . " , ";
								}
								if ( $company->pais!=NULL && $company->pais!="" ){
									$a3 = $company->pais;
								}
								$adrress1 = "(" . $a1 . $a2 . $a3 . ")";

								$adrress2 = "";
								if ( $company->direccion!=NULL && $company->direccion!="" ){
									$adrress2 = $company->direccion . "\n ".$adrress1;
								} else {
									$adrress2 = $adrress1;
								}

							?>
							<textarea class="form-control" rows="2" disabled="disabled" style="background-color:#d9d9d9" 
							><?= $adrress2; ?></textarea>
						</div>
					</div>
					<div class="col-sm-1">&nbsp;</div>
				</div>
				<div class="row">
					<div class="col-sm-3" align="right">
						<label>
							<input type="checkbox" id="direccion_check" name="direccion_check" value="direccion_check" onclick="javascript:toogleTextArea('otra_sucursal');"
							 data-toggle="tooltip" data-placement="bottom" title="Indicar SOLO en caso de que desee que el Ing. de Soporte se diriga A OTRA DIRECCI&Oacute;N de Su Empresa (DIFERENTE a la indicada arriba)">
							Otra Sucursal
						</label>
					</div>
					<div class="col-sm-8">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
							<textarea class="form-control" id="otra_sucursal" name="otra_sucursal" rows="2" disabled="disabled" 
							 placeholder="Indicar SOLO en caso de que desee que el Ing. de Soporte se diriga A OTRA DIRECCI&Oacute;N de Su Empresa (DIFERENTE a la indicada arriba)"
							></textarea>
						</div>
					</div>
					<div class="col-sm-1">&nbsp;</div>
				</div>
				<div class="row">
					<div class="col-sm-12" align="center">
						<button type="button" class="btn btn-success btn-md" id="createNuevaCita" onclick="javascript:crearSoporte();"
						 data-toggle="tooltip" data-placement="bottom" title="Crear SOLICITUD de Soporte Programado con estas especificaciones (se le notificar&aacute; a Lanuza Group vía Email)"
						 style="margin-top: 7px;">
						   <span class="glyphicon glyphicon-time"></span> Crear SOLICITUD de cita para Soporte Programado </button>
					</div>
				</div>
			</form>

<!-- ====================  Opcion de Cambiar Hora de las Citas ya registradas ====================================================== -->
			<div id="citas_pasadas">
				<div class="row">
					<div class="col-sm-12" align="center">
						<br/>
						<b>Eliminar entradas previas</b>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12" align="center">
						<table id="myTable" border="1">
							<thead style="background-color:#AAA; font-size: 12px;">
								<tr>
									<th>Hora</th>
									<th>Trabajo</th>
									<th>Inventario</th>
									<th>Extra info</th>
									<th>Otra direcc.</th>
									<th>&iquest;Aprobada&quest;</th>
									<th>Ingeniero de Soporte</th>
									<th>Selecci&oacute;n</th>
							</thead>
							<tbody style="background-color:#fff;"></tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2" align="right">
						Cambio de Hora:
					</div>
					<div class="col-sm-2" align="center">
						<select class="form-control" id="cambiar_hora_combo" name="cambiar_hora_combo">
							<option value="none">-</option>
							<option value="1" >1</option>
							<option value="2" >2</option>
							<option value="3" >3</option>
							<option value="4" >4</option>
							<option value="5" >5</option>
							<option value="6" >6</option>
							<option value="7" >7</option>
							<option value="8" >8</option>
							<option value="9" >9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
						</select>
					</div>
					<div class="col-sm-2" align="center">
						<select class="form-control" id="cambiar_pm_combo" name="cambiar_pm_combo">
							<option value="AM" >A.M.</option>
							<option value="PM" >P.M.</option>
						</select>
					</div>
					<div class="col-sm-2" align="center">
						<button id="change_hour" type="button" class="btn btn-info btn-sm" onclick="javascript:changeHour();"
						 data-toggle="tooltip" data-placement="bottom" title="Establezca NUEVA Hora para el Soporte que desea Cambiar, luego haga click en CAMBIAR HORA">
						   <span class="glyphicon glyphicon-hourglass"></span> Cambiar Hora</button>
					</div>

					<div class="col-sm-2" align="center">
						<button id="appointment_delete" type="button" class="btn btn-danger btn-sm" onclick="javascript:eliminarCita();"
						 data-toggle="tooltip" data-placement="bottom" title="Elimine la Cita SELECCIONADA (Solo si USTED creó dicha cita)">
						   <span class="glyphicon glyphicon-remove"></span> Eliminar Cita</button>
					</div>

					<div class="col-sm-2" align="center">
						<button id="appointment_accept" type="button" class="btn btn-success btn-sm" onclick="javascript:aceptarCita();"
						 data-toggle="tooltip" data-placement="bottom" title="Establecer que usted Atenderá esta Cita">
						   <span class="glyphicon glyphicon-import"></span> Aceptar</button>
					</div>
				</div>
				<div class="row">&nbsp;
				</div>
				<div class="row">
					<div class="col-sm-12" align="center" style>
						<span class="glyphicon glyphicon-sunglasses" style="font-size:13px;">
							* Esta opci&oacute;n le permitir&aacute; <b>cambiar la Hora</b> estimada de la 
							Visita a la Empresa. Si desea cambiar el <b>D&iacute;a</b>, deber&aacute;
							<b>Eliminar la Cita</b> y <u>Crearla en el d&iacute;a correspondiente</u>.</span>
					</div>
				</div>
			</div>
		</div>

		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color:#b3b3b3; font-family:monospace; font-size:16px;"
		   onclick="javascript:eraseTable();"><span class="glyphicon glyphicon-remove-circle"></span> Cerrar SIN guardar cambios</button>
		</div>
	  </div>
	</div>
</div>

<!-- ========================= Formulario para usar AJAX .:. Buscar Datos Tecnico ============================ -->
<?php
	echo "<script>";
	echo "   var modalAjaxURL = '" . PROJECTURLMENU . "tecnicos/programar_soporte';" ;
	echo "</script>";
?>
<form id="enviarTecnico" method="post" enctype="multipart/form-data">
	<input type="hidden" id="tecnicoId" name="tecnicoId" value="" />
</form>

<br/>
<fieldset class="scheduler-border">
	<legend class="scheduler-border">Leyenda</legend>

	<div class="row control-group">
		<div class="col-sm-1"><b>&Iacute;conos</b></div>
		<div class="col-sm-11">
		 	El significado de los s&iacute;mbolos a tomar en cuenta, donde:
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td width="160px" class="danger">
						<span class="glyphicon glyphicon-wrench" style="color:#E30513;  font-size:24px;"></span>
						Soporte Creado
					</td>
					<td>
						Se ha agendado una cita de Soporte en &eacute;ste d&iacute;a
						<b>PERO</b> NO ha sido aprobada por la otra parte: 
						(<i>si la crea un Ingeniero de Soporte, puede/debe ser aprobado por el Partner o Gerente</i>;
						<u>en cambio si fue creada por la Empresa debe ser aprobada por un Ingeniero de Soporte</u> 
						que es el que aceptar&aacute; dar dicho Soporte).
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td width="160px" class="success">
						<span class="glyphicon glyphicon-wrench" style="color:#3C763D; font-size:24px;"></span>
						Soporte Aprobado
					</td>
					<td>La fecha propuesta ha sido Aprobada por la otra parte (Si la crea un Partner o de parte de una Empresa
						deber&aacute; aceptarla un Ingeniero de Soporte que es el que decidir&aacute; ir a dicha Empresa).
					</td>
				</tr>
			</table>
		</div>
	</div>


	<div class="row control-group">
		<div class="col-sm-1"><b>Acciones</b></div>
		<div class="col-sm-11">
		 En esta secci&oacute;n, usted podr&aacute; ver las "citas" programadas de Soporte TI  
		 las cuales se deben atender presencialmente en la Empresa, donde:
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td width="220px" class="success">
						<button type="button" class="btn btn-success">
						<span class="glyphicon glyphicon-time"></span></button> 
						<b>Crear Solicitud de cita</b>
					</td>
					<td>
						Para Crear una Solicitud de cita se establece:
						direcci&oacute;n, la Fecha (el d&iacute;a y la hora estimada)
						y descripci&oacute;n del tipo de trabajo a realizar.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td width="220px" class="danger">
						<button type="button" class="btn btn-danger">
						<span class="glyphicon glyphicon-remove-circle"></span></button> 
						<b>Eliminar Solicitud</b>
					</td>
					<td>
						Eliminar una Solicitud previamente creada.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td width="220px" class="info">
						<button type="button" class="btn btn-info">
						<span class="glyphicon glyphicon-hourglass"></span></button> 
						<b>Actualizar Hora</b>
					</td>
					<td>
						Reprogramar cita en la Agenda, estableciendo nueva <b>Hora</b> para una cita previamente establecida 
						(en caso de querer cambiar el d&iacute;a y/o el mes, se debe "Eliminar" y "Crear" una nueva Solicitud).
					</td>
				</tr>
			</table>
		</div>
	</div>
	
</fieldset>
<!-- ================== snackbar para avisar que el mensaje fue enviado ===================================== -->
<style>
	/* The snackbar - position it at the bottom and in the middle of the screen */
	#snackbar {
		visibility: hidden; 	/* Hidden by default. Visible on click */
		min-width: 250px; 		/* Set a default minimum width */
		margin-left: -125px; 	/* Divide value of min-width by 2 */
		background-color: #333; /* Black background color */
		color: #fff; 			/* White text color */
		text-align: center; 	/* Centered text */
		border-radius: 2px; 	/* Rounded borders */
		padding: 16px; 			/* Padding */
		position: fixed; 		/* Sit on top of the screen */
		z-index: 1; 			/* Add a z-index if needed */
		left: 50%; 				/* Center the snackbar */
		bottom: 30px; 			/* 30px from the bottom */
	}

	/* Show the snackbar when clicking on a button (class added with JavaScript) */
	#snackbar.show {
		visibility: visible; /* Show the snackbar */

		/* Add animation: Take 0.5 seconds to fade in and out the snackbar. 
		 * However, delay the fade out process for 4.5 seconds
		 */
		-webkit-animation: fadein 0.5s, fadeout 0.5s 4.5s;
		animation: fadein 0.5s, fadeout 0.5s 4.5s;
	}

	/* Animations to fade the snackbar in and out */
	@-webkit-keyframes fadein {
		from {bottom: 0; opacity: 0;} 
		to {bottom: 30px; opacity: 1;}
	}

	@keyframes fadein {
		from {bottom: 0; opacity: 0;}
		to {bottom: 30px; opacity: 1;}
	}

	@-webkit-keyframes fadeout {
		from {bottom: 30px; opacity: 1;} 
		to {bottom: 0; opacity: 0;}
	}

	@keyframes fadeout {
		from {bottom: 30px; opacity: 1;}
		to {bottom: 0; opacity: 0;}
	}
</style>

<!-- The actual snackbar -->
<div id="snackbar">
	Su Opini&oacute;n ha sido enviada... Muchas Gracias :)
</div>
