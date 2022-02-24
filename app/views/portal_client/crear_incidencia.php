<?php    

	echo "&nbsp; Si usted presenta inconvenientes con su Equipo, levante una nueva Incidencia."

		. " Su requerimiento será atendido por uno de nuestros técnicos a la brevedad posible.";



	echo "<script>var cantidadEquipos = " . $cantidad_equipos . ";</script>";



	if ( isset($Incidencias_que_faltan_por_opinar) ){



		if ( $Incidencias_que_faltan_por_opinar == NULL || $Incidencias_que_faltan_por_opinar == ""

				|| $Incidencias_que_faltan_por_opinar == "[]" ){

			//puede venir un JSON vacìo

			$puede_crear_incidencia = true;



		} else {

			$puede_crear_incidencia = false;

			/* legacy code usando SEPARATOR

			$a = str_replace("****", ", ", $Incidencias_que_faltan_por_opinar);

			$b = str_replace("**", " ", $a);

			*/



			$razon_no_crear_incidencia = "Ud. NO podrá crear una nueva Incidencia hasta no Certificar la(s) Incidencia(s) número: ";

		}



		echo "<script>var jsonObjs = " . $Incidencias_que_faltan_por_opinar . "; </script>";

	}

?>



<form class="form-horizontal" data-toggle="validator" role="form" id="new_incidencia"

	 method="post" enctype="multipart/form-data" action="<?= PROJECTURLMENU; ?>portal/create_incidencia"

	 onsubmit="javascript:return submitForm();">

		<h4 style="text-align:center; color:#E30513;">

			<span class="glyphicon glyphicon-flash logo slideanim"></span>

			<i>Generar Nueva Incidencia</i>&nbsp;&nbsp;&nbsp;

		</h4>

		

	  <input type="hidden" id="jsonDatosConexion" name="jsonDatosConexion" value='[]' />

	  

	  <div id="givenname-div" class="form-group">

		<label class="control-label col-sm-3" for="givenname">Fecha:</label>

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

			<div id="givenname-error" class="help-block">

				&nbsp;

			</div>

		</div>

	  </div>



	  <div id="givenname-div" class="form-group">

		<label class="control-label col-sm-3" for="givenname">Usuario:</label>

		<div class="col-sm-7">

			<div class="input-group">

				<p class="form-control-static">

				<span id="fecha" class="glyphicon glyphicon-user">

					<?= $user->saludo . " " . $user->nombre . " " . $user->apellido; ?>

				</span>

				</p>

			</div>

		</div>

		<div class="col-sm-2">

			<div id="givenname-error" class="help-block">

				&nbsp;

			</div>

		</div>

	  </div>



	<input type="hidden" name="cantidad_equipos" value="<?= $cantidad_equipos; ?>" />



	<?php if ( $cantidad_equipos <= 1 ) { ?>



	  <div id="equipo_id-div" class="form-group">

		<label class="control-label col-sm-3" for="equipo_id">Equipo:</label>

		<div class="col-sm-7">

			<div class="input-group">

				<p class="form-control-static">

				<span id="equipo" class="glyphicon glyphicon-blackboard">

					ID:  

					<span id="equipo_id">

						<?php if(isset($equipo_id_barcode)) echo $equipo_id_barcode; ?>

					</span>

					<input type="hidden" name="equipo_id" value="<?php if(isset($equipo_id)) echo $equipo_id; ?>" />

					<br/>

					&nbsp;

					Info básica: 

					<span id="equipo_basics">

						<?php if(isset($equipo_basics)) echo $equipo_basics; ?>

					</span>

				</span>

				</p>

			</div>

		</div>

		<div class="col-sm-2">

			<div id="equipo_id-error" class="help-block">

				&nbsp;

			</div>

		</div>

	  </div>



	<?php } else { ?>

		

		<div id="equipos-div" class="form-group">

		<label class="control-label col-sm-3" for="equipos">Indique su Equipo que presenta fallas:</label>

		<div class="col-sm-7">

			<div class="input-group">

				<span class="input-group-addon"><i class="glyphicon glyphicon-blackboard"></i></span>

				<select class="form-control" id="equipos" name="equipos">

					<!-- optgroup label="Picnic" -->

					<option value="0">  --  Seleccione uno de sus Equipos --  </option>

					<?php

						foreach ($equipos as $maquina){

							echo '<option value="' . $maquina[0] . '">' . $maquina[1] . '</option>';

						}

					?>

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





	<?php } ?>



	  <div id="tipo_falla-div" class="form-group">

		<label class="control-label col-sm-3" for="tipo_falla">Especifique un tipo de falla:</label>

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

		<label class="control-label col-sm-3" for="observaciones">Observaciones: <br/>(Describa brevemente el problema que presenta)</label>

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

			<!-- input class="btn btn-warning" type="reset" value=" Empezar desde cero " onclick="javascript:limpiarEstilos();"

			 data-toggle="tooltip" data-placement="right" title="Limpiar Formulario y comenzar otra vez" -->

			<button type="reset" class="btn btn-warning btn-lg"

			 data-toggle="tooltip" data-placement="right" title="Limpiar Formulario y comenzar otra vez">

			<span class="glyphicon glyphicon-repeat"></span> Empezar desde cero

		  </button>

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

		

		//pruebaJson();



		fillingPendingData();



	});



	function submitForm(){

	

		var bool = true;

		var scrollElement = "";

		var scrolled = false;



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

		

		/* alert(cantidadEquipos+"---");if(cantidadEquipos==2)alert("yeah"); */



		if ( cantidadEquipos > 1 ){

			if ( $("#equipos").val() == "0" ){

				bool = false;

			

				document.getElementById("equipos-div").className = "form-group has-error has-feedback";

				document.getElementById("equipos-span").className = "glyphicon glyphicon-remove form-control-feedback";

				document.getElementById("equipos-error").innerHTML = "Seleccione uno";

				}

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

		var array = ['tipo_falla','observaciones', 'equipos' ];



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



	function pruebaJson(){//debugger;

		var s = '[{"id":"1001"},{"id":"1002"},{"id":"1005"},{"id":"1000"}]';

		var e = '[]';

		var jsonObjs = JSON.parse(s);

		//var jsonObjs = JSON.stringify(s);

		console.log("hey:"+jsonObjs);		



		console.log("res:"+jsonObjs.length);

		var estaId = buscarIdEnJson(jsonObjs, "1001");

		if ( estaId > -1 ){

			console.log("si esta");

			var nuevoJson = quitarObjJson(jsonObjs, estaId);

			console.log( nuevoJson , JSON.stringify(nuevoJson), nuevoJson.length);

		}



		var toadd = JSON.parse(s);

		var newobj = { "id":"20" };

		var jsonToUpdate = addJsonObj(toadd, newobj);

		console.log("jsonToUpdate",jsonToUpdate);

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

</script>