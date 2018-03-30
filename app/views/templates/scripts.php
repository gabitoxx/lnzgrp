<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	
	<!-- script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script -->
	<!-- script src="<?= APPJSPATH; ?>jquery-3.1.1.min.js" type="text/javascript"></script -->
	
	<!-- script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
	
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="<?= APPJSPATH; ?>cufon-yui.js" type="text/javascript"></script>
	<script src="<?= APPJSPATH; ?>cufon-replace.js" type="text/javascript"></script>
	<script src="<?= APPJSPATH; ?>NewsGoth_400.font.js" type="text/javascript"></script>
	<script src="<?= APPJSPATH; ?>NewsGoth_700.font.js" type="text/javascript"></script>
	<script src="<?= APPJSPATH; ?>NewsGoth_Lt_BT_italic_400.font.js" type="text/javascript"></script>
	<script src="<?= APPJSPATH; ?>Vegur_400.font.js" type="text/javascript"></script> 
	<script src="<?= APPJSPATH; ?>FF-cash.js" type="text/javascript"></script>
	<script src="<?= APPJSPATH; ?>jquery.featureCarousel.js" type="text/javascript"></script>     
	
	<script type="text/javascript">
		$(document).ready(function() {

			$("#carousel").featureCarousel({
				autoPlay:3000,					//segundos
				trackerIndividual:false,
				trackerSummation:false,
				topPadding:50,
				smallFeatureWidth:.9,
				smallFeatureHeight:.9,
				sidePadding:0,
				smallFeatureOffset:0
			});

			/**-------------------------------------------------------------------------
			 * VALIDACIONES DE Formularios, de CAMPOS, mensajes en Español
			 */

			var msg="";

			var elements = document.getElementsByTagName("INPUT");

			for (var i = 0; i < elements.length; i++) {

				elements[i].oninvalid =function(e) {

					if (!e.target.validity.valid) {

						switch(e.target.id){

							case 'user_password' : 
								e.target.setCustomValidity("Contraseña NO puede estar en blanco.");
								break;
							case 'user_login' : 
								e.target.setCustomValidity("Especifique Usuario o Email.");
								break;
							case 'nombre' : 
								e.target.setCustomValidity("Por Favor díganos su Nombre y Apellido.");
								break;
							case 'correo' : 
								e.target.setCustomValidity("Es vital su Email o Correo electrónico para contactarnos con usted.");
								break;
							case 'celular' : 
								e.target.setCustomValidity("Es vital su número Celular o Teléfono para contactarnos con usted.");
								break;
							case 'mensaje' : 
								e.target.setCustomValidity("Escriba sus dudas, si quiere saber sobre nuestros Servicios, Precios o sus Comentarios.");
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

			var elements = document.getElementsByTagName("textarea");
			for (var j = 0; j < elements.length; j++) {
				elements[j].oninvalid =function(e) {
					if ( !e.target.validity.valid) {
						switch(e.target.id){
							case 'mensaje' : 
								e.target.setCustomValidity("Escriba sus dudas, si quiere saber sobre nuestros Servicios, Precios o sus Comentarios.");
								break;
							default : 
								e.target.setCustomValidity("");
								break;
						}
					}
				}
				elements[j].oninput = function(e) {
					e.target.setCustomValidity(msg);
				};
			}
		});
	</script>
	
	<script type="text/javascript"> Cufon.now(); </script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>