<?php    

	echo "&nbsp; Si usted presenta inconvenientes con alguno de los Equipos de su Empresa, levante una nueva Incidencia."

		. " Su requerimiento será atendido por uno de nuestros técnicos a la brevedad posible.";



	if ( isset($Incidencias_que_faltan_por_opinar) ){



		if ( $Incidencias_que_faltan_por_opinar == NULL || $Incidencias_que_faltan_por_opinar == ""

				|| $Incidencias_que_faltan_por_opinar == "[]" ){

			//puede venir un JSON vacìo

			$puede_crear_incidencia = true;



			echo "<script>var jsonObjs = '[]'; </script>";



		} else {

			$puede_crear_incidencia = false;

			/* legacy code usando SEPARATOR

			$a = str_replace("****", ", ", $Incidencias_que_faltan_por_opinar);

			$b = str_replace("**", " ", $a);

			*/



			$razon_no_crear_incidencia = "Ud. NO podrá crear una nueva Incidencia hasta no Certificar la(s) Incidencia(s) número: ";



			echo "<script>var jsonObjs = " . $Incidencias_que_faltan_por_opinar . "; </script>";

		}

	}

?>



<form class="form-horizontal" data-toggle="validator" role="form" id="new_incidencia"

	 method="post" enctype="multipart/form-data" action="<?= PROJECTURLMENU; ?>portal/create_incidencia_gerente"

	 onsubmit="javascript:return submitForm();">

		<h4 style="text-align:center; color:#E30513;">

			<span class="glyphicon glyphicon-flash logo slideanim"></span>

			<i>Generar Nueva Incidencia</i>&nbsp;&nbsp;&nbsp;

		</h4>

		

	  <input type="hidden" id="jsonDatosConexion" name="jsonDatosConexion" value='[]' />

	  

	  <div class="col-sm-12">

			<br/>

			<h4 align="center"><i>

				Seleccione una de las 2 siguientes opciones:

				<span style="color:#E30513">el Usuario afectado</span> o 

				<span style="color:#E30513">el Equipo que presenta fallas</span>.

			</i></h4>

			<br/>

	  </div>



	  <div id="givenname-div" class="form-group">

		<label class="control-label col-sm-3" for="givenname">Usuario que necesita Soporte TI:</label>

		<div class="col-sm-7">

			<div class="input-group">

				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

				<select class="form-control" id="givenname" name="givenname" onblur="javascript:deshabilitarCombobox('equipos');return false;" onchange="javascript:deshabilitarCombobox('equipos');return false;">

					

					<option value="0">  --  Seleccione al Usuario afectado --  </option>

					

					<?php

						if ( isset($no_usuarios) ){



							echo "<option disabled>No hay Usuarios registrados</option>";



							unset($no_usuarios);



						} else {

							foreach ($usuarios as $usuario){

								echo '<option value="' . $usuario[0] . '">' . $usuario[3] . " " . $usuario[4] . '</option>';

							}

						}

					?>



				</select>

				<span id="givenname-span" class=""></span>

			</div>

		</div>

		<div class="col-sm-2">

			<div id="givenname-error" class="help-block">

				&nbsp;

			</div>

		</div>

	  </div>



		

	<div id="equipos-div" class="form-group">

		<label class="control-label col-sm-3" for="equipos">Indique el Equipo que presenta fallas:</label>

		<div class="col-sm-7">

			<div class="input-group">

				<span class="input-group-addon"><i class="glyphicon glyphicon-blackboard"></i></span>

				<select class="form-control" id="equipos" name="equipos" onblur="javascript:deshabilitarCombobox('givenname');return false;" onchange="javascript:deshabilitarCombobox('givenname');return false;">

					

					<option value="0">  --  Seleccione uno de sus Equipos --  </option>



					<optgroup label="Sus Equipos">

					

					<?php

						if ( isset($no_equipos) ){



							echo "<option disabled>Ud. No posee equipos registrados</option>";



							unset($no_equipos);



						} else {

							foreach ($equipos as $maquina){

								echo '<option value="' . $maquina[0] . '">' . $maquina[1] . '</option>';

							}

						}

					?>



					</optgroup>



					<optgroup label="Equipos de Su Empresa">



					<?php

						if ( isset($no_inventarioEquipos) ){



							echo "<option disabled>Su Empresa No posee equipos registrados</option>";



							unset($no_inventarioEquipos);



						} else {

							foreach ($inventarioEquipos as $maquina2){

								echo '<option value="' . $maquina2[0] . '">' . $maquina2[1] . '</option>';

							}

						}

					?>



					</optgroup>



				</select>

				<span id="equipos-span" class=""></span>

			</div>

		</div>

		<div class="col-sm-2">

			<div id="equipos-error" class="help-block">

				&nbsp;

			</div>

		</div>

	</div>



	<hr/>



	<div class="col-sm-12">

		<h4 align="center"><i>

			<span style="color:#E30513">Complete los siguientes campos:</span>

		</i></h4>

	  </div>



	<div id="fecha-div" class="form-group">

		<label class="control-label col-sm-3" for="fecha">Fecha:</label>

		<div class="col-sm-7">

			<div class="input-group">

				<p class="form-control-static">

				<span id="fecha" class="glyphicon glyphicon-calendar">

					<?= date("d/m/Y"); ?> (hoy)

				</span>

				</p>

			</div>

		</div>

		<div class="col-sm-2">

			<div id="fecha-error" class="help-block">

				&nbsp;

			</div>

		</div>

	  </div>



	<div id="tipo_falla-div" class="form-group">

		<label class="control-label col-sm-3" for="tipo_falla">Especifique un tipo de falla:<b style="color:#E30513;font-size:18px;">*</b></label>

		<div class="col-sm-7">

			<div class="input-group">

				<span class="input-group-addon"><i class="glyphicon glyphicon-fire"></i></span>

				<select class="form-control" id="tipo_falla" name="tipo_falla">

					<!-- optgroup label="Picnic" -->

					<option value="0">  --  Seleccione una opci&oacute;n --  </option>

					<?php

						foreach ($fallas as $falla){

							echo '<option value="' . $falla["fallaId"] . '">' . $falla["nombre"] . '</option>';

						}

					?>

				</select>

				<span id="tipo_falla-span" class=""></span>

			</div>

		</div>

		<div class="col-sm-2">

			<div id="tipo_falla-error" class="help-block">

				&nbsp;

			</div>

		</div>

	  </div>



	  <div id="observaciones-div" class="form-group">

		<label class="control-label col-sm-3" for="observaciones">

			Observaciones:<b style="color:#E30513;font-size:18px;">*</b>

			<br/>(Describa brevemente el problema que presenta)

		</label>

		<div class="col-sm-7">

			<div class="input-group">

				<span class="input-group-addon"><i class="glyphicon glyphicon-eye-open"></i></span>

				<textarea class="form-control" id="observaciones" name="observaciones"

				 rows="5"

				 onclick="javascript:if(this.value=='Describa brevemente el problema que presenta...'){this.value='';}"

				 >Describa brevemente el problema que presenta...</textarea>

				<span id="observaciones-span" class=""></span>

			</div>

		</div>

		<div class="col-sm-2">

			<div id="observaciones-error" class="help-block">

				&nbsp;

			</div>

		</div>

	  </div>



	  <hr/>



	  <div class="col-sm-12">

		<h4 align="center"><i>

			<span style="color:#E30513">Datos de Conexi&oacute;n Remota</span>

		</i></h4>

	  </div>



	  <div id="remote-div" class="form-group">

		<label class="control-label col-sm-3" for="remote">Conexi&oacute;n Remota:<b style="color:#E30513;font-size:18px;">*</b></label>

		<div class="col-sm-7">

			<div class="input-group">

				<span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span>

				<input type="text" class="form-control" id="remote" name="remote" placeholder="TeamViewer, Windows Remoto, etc." required="required"

				 onblur="javascript:validar('remote');return false;">

				<span id="remote-span" class=""></span>

			</div>

		</div>

		<div class="col-sm-2">

			<div id="remote-error" class="help-block">

				&nbsp;

			</div>

		</div>

	  </div>



	  <div id="userID-div" class="form-group">

		<label class="control-label col-sm-3" for="userID">Identificaci&oacute;n:<b style="color:#E30513;font-size:18px;">*</b></label>

		<div class="col-sm-7">

			<div class="input-group">

				<span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>

				<input type="text" class="form-control" id="userID" name="userID" placeholder="ID del Usuario de la conexión remota" required="required"

				 onblur="javascript:validar('userID');return false;">

				<span id="userID-span" class=""></span>

			</div>

		</div>

		<div class="col-sm-2">

			<div id="userID-error" class="help-block">

				&nbsp;

			</div>

		</div>

	  </div>



	  <div id="password-div" class="form-group">

		<label class="control-label col-sm-3" for="password">Contrase&ntilde;a:<b style="color:#E30513;font-size:18px;">*</b></label>

		<div class="col-sm-7">

			<div class="input-group">

				<span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>

				<input type="text" class="form-control" id="password" name="password" placeholder="Password" required="required"

				 onblur="javascript:validar('password');return false;">

				<span id="password-span" class=""></span>

			</div>

		</div>

		<div class="col-sm-2">

			<div id="password-error" class="help-block">

				&nbsp;

			</div>

		</div>

	  </div>

	  <div class="form-group">

			<div class="col-sm-9">

				<div style="color:#E30513;text-align:right;"><b>* = Campo Obligatorio</b></div>

			</div>

	  </div>



	  <br/><br/>



	  <div class="form-group"> 

		<div class="col-sm-offset-3 col-sm-4">

		  <button type="submit" class="btn btn-success btn-lg"

		   data-toggle="tooltip" data-placement="left" title="Reportar Problema con este equipo">

			<span class="glyphicon glyphicon-flash"></span> Reportar Incidencia

		  </button>

		</div>

		<div class="col-sm-5">

		  <input class="btn btn-warning btn-lg" type="reset" value=" Empezar desde cero " onclick="javascript:limpiarEstilos();"

		   data-toggle="tooltip" data-placement="right" title="Limpiar Formulario y comenzar otra vez">

		</div>

	  </div>





		<div id="extra-info-1" class="row form-group" style="background-color:yellow;">

			<div class="col-sm-offset-1 col-sm-11">

				<span class="glyphicon glyphicon-hand-right"></span> &nbsp; 



				<b>No se puede Crear una nueva Incidencia:</b> <?= $razon_no_crear_incidencia; ?> 

				<strong><span id="ids-incidencias-pendientes"></span></strong>

				<br/>

				<span class="glyphicon glyphicon-hand-right"></span> &nbsp; 

				Posee en total <strong><span id="numero-incidencias-total"></span> por Certificar</strong>.

			</div>

		</div>



<?php 		if ( $puede_crear_incidencia == false && isset($razon_no_crear_incidencia) ){	?>



		<script>

			$("#extra-info-1").addClass( "display" );

		</script>



<?php		} else {	?>



		<script>

			$("#extra-info-1").addClass( "hidden" );

		</script>



<?php		} ?>



</form>



<script>

	var bPuedeCrearIncidencia = true;

	$(document).ready(function () {



		var msg="";



		var elements = document.getElementsByTagName("textarea");



		for (var i = 0; i < elements.length; i++) {



			elements[i].oninvalid = function(e) {



				if (!e.target.validity.valid) {



					switch(e.target.id){



						case 'observaciones' : 

							e.target.setCustomValidity("Por favor, indique ciertos detalles del inconveniente");

							break;

						default : 

							e.target.setCustomValidity("");

							break;

					}

				}

			};



			elements[i].oninput = function(e) {

				e.target.setCustomValidity(msg);

			};

		}



		$('[data-toggle="tooltip"]').tooltip();



		fillingPendingData();



	});



	function submitForm(){

	

		var bool = true;

		var scrollElement = "";

		var scrolled = false;



		limpiarEstilos();



		/* tipo falla */

		if ( $("#tipo_falla").val() == "0" ){

			

			bool = false;

			

			document.getElementById("tipo_falla-div").className = "form-group has-error has-feedback";

			document.getElementById("tipo_falla-span").className = "glyphicon glyphicon-remove form-control-feedback";

			document.getElementById("tipo_falla-error").innerHTML = "Seleccione uno";

		}

		

		if ( $("#observaciones").val() == "Describa brevemente el problema que presenta..." 

				|| $("#observaciones").val() == "" ){



			bool = false;

			

			document.getElementById("observaciones-div").className = "form-group has-error has-feedback";

			document.getElementById("observaciones-span").className = "glyphicon glyphicon-remove form-control-feedback";

			document.getElementById("observaciones-error").innerHTML = "Por favor, Indique ciertos detalles del inconveniente";

		}

		

		

		if ( $("#equipos").val() == "0" && $("#givenname").val() == "0" ){

			bool = false;

		

			document.getElementById("givenname-div").className = "form-group has-error has-feedback";

			document.getElementById("givenname-span").className = "glyphicon glyphicon-remove form-control-feedback";

			document.getElementById("givenname-error").innerHTML = "Seleccione Usuario o...";



			document.getElementById("equipos-div").className = "form-group has-error has-feedback";

			document.getElementById("equipos-span").className = "glyphicon glyphicon-remove form-control-feedback";

			document.getElementById("equipos-error").innerHTML = "... seleccione Equipo";

		}

		

		if ( $("#password").val().trim() == "" ){



			bool = false;

			

			document.getElementById("password-div").className = "form-group has-error has-feedback";

			document.getElementById("password-span").className = "glyphicon glyphicon-remove form-control-feedback";

			document.getElementById("password-error").innerHTML = "Por favor, Indique la contraseña";

		}

		if ( $("#userID").val().trim() == "" ){



			bool = false;

			

			document.getElementById("userID-div").className = "form-group has-error has-feedback";

			document.getElementById("userID-span").className = "glyphicon glyphicon-remove form-control-feedback";

			document.getElementById("userID-error").innerHTML = "Por favor, Indique el identificador de usuario Remoto";

		}

		if ( $("#remote").val().trim() == "" ){



			bool = false;

			

			document.getElementById("remote-div").className = "form-group has-error has-feedback";

			document.getElementById("remote-span").className = "glyphicon glyphicon-remove form-control-feedback";

			document.getElementById("remote-error").innerHTML = "Por favor, Indique la forma cómo podremos asistirle remotamente";

		}



		if ( bool == true && bPuedeCrearIncidencia == true ){

			/* JSON con los datos de la Conexion */

			var json = generarJsonDatosConexion( $("#remote").val(), $("#userID").val(), $("#password").val());

			$("#jsonDatosConexion").val( json );



			/* submit POST enviando formulario */

			document.getElementById("new_incidencia").submit();



			return true;



		} else {

			return false;

		}

	}



	/**

	 * Limpia todos los estilos de SUCCESS y ERROR del formulario

	 */

	function limpiarEstilos(){

		var array = ['tipo_falla','observaciones', 'equipos', 'givenname' ];



		var elementId = "";



		for (var i = 0; i < array.length ; i++) {



			elementId = array[i];



			document.getElementById(elementId + "-span").className = "";

			

			/* en el elemento form-group*/

			document.getElementById(elementId + "-div").className = "form-group";

			/* Mensaje de error */

			document.getElementById(elementId + "-error").innerHTML = "";

		}

	}



	function deshabilitarCombobox(selectId){



		document.getElementById( selectId ).value = 0;
    $("#"+selectId).val( 0 );



		if ( selectId == "equipos" ){

			if ( $("#givenname").val() != 0 ){

				document.getElementById("givenname-div").className = "form-group has-success has-feedback";

				document.getElementById("givenname-span").className = "glyphicon glyphicon-ok form-control-feedback";

				document.getElementById("givenname-error").innerHTML = "Usuario seleccionado";

			} else {

				document.getElementById("givenname-div").className = "form-group";

				document.getElementById("givenname-span").className = "";

				document.getElementById("givenname-error").innerHTML = "";

			}

			document.getElementById("equipos-div").className = "form-group";

			document.getElementById("equipos-span").className = "";

			document.getElementById("equipos-error").innerHTML = "";

		

		} else if ( selectId == "givenname" ){

			if ( $("#equipos").val() != 0 ){

				document.getElementById("equipos-div").className = "form-group has-success has-feedback";

				document.getElementById("equipos-span").className = "glyphicon glyphicon-ok form-control-feedback";

				document.getElementById("equipos-error").innerHTML = "Equipo seleccionado";

			} else {

				document.getElementById("equipos-div").className = "form-group";

				document.getElementById("equipos-span").className = "";

				document.getElementById("equipos-error").innerHTML = "";

			}

			document.getElementById("givenname-div").className = "form-group";

			document.getElementById("givenname-span").className = "";

			document.getElementById("givenname-error").innerHTML = "";

		}

	}



	function fillingPendingData(){



		if ( $("#extra-info-1").hasClass("display") ){



			var x = ( jsonObjs != undefined ) ? jsonObjs.length : 0;



			if ( x == 1 || x == "1" ){

				$("#numero-incidencias-total").text( x + " Incidencia pendiente" );

			} else {

				$("#numero-incidencias-total").text( x + " Incidencia(s) pendiente(s)");

			}



			var y = "";

			for(var i=0; i < jsonObjs.length ; i++){

				y += jsonObjs[i].id;

				if ( i != jsonObjs.length -1 ){

					y += ", ";

				}

			}

			$("#ids-incidencias-pendientes").text( y );

		}



		/* dependiendo si se muestra o no la seccion info extra: pendientes por Certificar/Opinar */

		if ( $("#extra-info-1").hasClass("hidden") ){



			$(".btn-success").removeAttr("disabled");

			bPuedeCrearIncidencia = true;

		

		} else if ( $("#extra-info-1").hasClass("display") ){

			

			$(".btn-success").attr("disabled","disabled");

			bPuedeCrearIncidencia = false;

		}

	}



	function validar(inputID){

		var s = $("#"+inputID).val();

		s = s.replace(/"/gi, "");

		$("#"+inputID).val( s );

	}



</script>