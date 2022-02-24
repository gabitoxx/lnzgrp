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
			<span class="glyphicon glyphicon-calendar" style="color:<?= RGB_CLIENTE; ?>; font-size:18px; "></span> 
			Visualizar Calendario de Soportes Programados
		</h4>
		<h6>
			Aqu&iacute; podr&aacute; visualizar las Visitas Programados de nuestros Ingenieros de Soportes
			a su Empresa. Estas visitas son por motivos de Soportes Programados; 
			las Incidencias (problemas con su Equipo) habr&aacute;n de tratarse 
			a trav&eacute;s de las opciones del men&uacute; <b>Incidencias</b>.
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

	<table>
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

			<tr>  

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
	echo " var modalAjaxURL = '" . PROJECTURLMENU . "tecnicos/programar_soporte';" ;
	echo " var modalAjaxURL2 = '" . PROJECTURLMENU . "portal/ajax_soportes_table';" ;
	echo " var currentMonthURL = '" . $currentMonthURL . "';" ;
	echo "</script>";
?>
<form class="form-horizontal" data-toggle="validator" role="form" id="buscar_soportes_form"
 	method="post" enctype="multipart/form-data">

 	<input type="hidden" id="ajax_year" name="ajax_year" value="" />
	<input type="hidden" id="ajax_mes"  name="ajax_mes"  value="" />
	<input type="hidden" id="ajax_dia"  name="ajax_dia"  value="" />
</form>

<!-- ==========================================   Scripts ================================================== -->
<script>
	
	function showModal(year, mesNombre, diaNumero, bDiaYaPasado){
		/*alert( year + " * " + mesNombre + " - " + diaNumero + " ---> " + bDiaYaPasado + "__" + modalAjaxURL2);*/

		/* muestra modal */
		$('#myModal').modal({
			backdrop: 'static',
			keyboard: false,
			show: true
		});


		/**
		 * Buscando info del Dia
		 */
		document.getElementById("ajax_year").value = year;
		document.getElementById("ajax_mes").value  = mesNombre;
		document.getElementById("ajax_dia").value  = diaNumero;

		$.ajax({
			type: "POST",
			url: modalAjaxURL2,
			data: $('#buscar_soportes_form').serialize(),
			success: function(message){
				crearFilasCitas(message, bDiaYaPasado);
			},
			error: function(){
				alert("Error al buscar info de Empresas en nuestro Sistema\nPor favor, intente más tarde");
			}
		});
		
		document.getElementById("modalTitulo").innerHTML = "Información del Día: " + diaNumero + " / " + mesNombre + " / " + year;

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
				/*
				cell = row.insertCell(7);
				cell.innerHTML = "<input type=\"radio\" name=\"soporteProgId\" id=\"soporteProgId\" value=\""+ array[i] +"\" onclick=\"javascript:habilitarBotonesCitas("+bDiaYaPasado+");\">";
				*/
				filas++;
				filasCreadas++;
			}

			iHasta7++;
		}
	}

	/**
	 * Borrar filas al salir
	 */
	function eraseTable(){
		try {
			var limit    = filasCreadas + 99;
			filasCreadas = 0;

			var table = document.getElementById("myTable");

			for ( var i = 1; i <= limit; i++){
				table.deleteRow(i);
			}
		} catch(err) {
			/* JavaScript will actually create an Error object with two properties: name and message. */
			/* document.getElementById("demo").innerHTML = err.message;   alert(err.message);  */
		}
	}

	function habilitarBotonesCitas(bDiaYaPasado){}

</script>


<!-- ========================= MODAL para ver la info del Técnico ============================ -->
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" align="center" style="color: red;">
			<span class="glyphicon glyphicon-calendar"></span> 
			<span id="modalTitulo"></span> 
		  </h4>
		</div>

		<div class="modal-body">

<!-- ====================  Opcion de Cambiar Hora de las Citas ya registradas ====================================================== -->
			<div id="citas_pasadas">
				<div class="row">
					<div class="col-sm-12" align="center">
						<b>Detalle de Citas del d&iacute;a actual</b>
						<br/>
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
									<!-- th>Selecci&oacute;n</th -->
							</thead>
							<tbody style="background-color:#fff;"></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal"
		   style="background-color:#b3b3b3; font-family:monospace; font-size:16px;"
		   onclick="javascript:eraseTable();"> <span class="glyphicon glyphicon-remove-circle"></span> Cerrar</button>
		</div>
	  </div>
	</div>
</div>

<!-- ==================================== INFORMACION DE LA PAGINA ============================================ -->
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
						<b>MAS</b> no ha sido aprobada por la otra parte: 
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
</fieldset>