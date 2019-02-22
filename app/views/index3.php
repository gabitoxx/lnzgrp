<!DOCTYPE html>

<html lang="en">

<head>

	<title>

<?php

		if ( !isset($pageTitle) ){

			echo "Lanuza Soft - Portal de Incidencias de Lanuza Group";

		} else {

			echo $pageTitle;

		}

?>

	</title>

	<meta charset="UTF-8" />

	<meta name="viewport" content="width=device-width, initial-scale=1" />

<!--===============================================================================================-->	

	<link rel="icon" type="image/png" href="https://lanuzasoft.com/images/icons/favicon.ico"/>
	<link rel="apple-touch-icon" href="https://lanuzasoft.com/images/icons/apple-touch-icon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="https://lanuzasoft.com/images/icons/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="https://lanuzasoft.com/images/icons/apple-touch-icon-114x114.png" />
<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="https://lanuzasoft.com/vendor/bootstrap/css/bootstrap.min.css" />

<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="https://lanuzasoft.com/fonts/font-awesome-4.7.0/css/font-awesome.min.css" />

<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="https://lanuzasoft.com/vendor/animate/animate.css" />

<!--===============================================================================================-->	

	<link rel="stylesheet" type="text/css" href="https://lanuzasoft.com/vendor/css-hamburgers/hamburgers.min.css" />

<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="https://lanuzasoft.com/vendor/select2/select2.min.css" />

<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="https://lanuzasoft.com/css/util.css" />

	<link rel="stylesheet" type="text/css" href="https://lanuzasoft.com/css/main.css" />

	<link rel="manifest" href="https://lanuzasoft.com/css/manifest.json" />
	<meta name="theme-color" content="#56BF56" />
<!--===============================================================================================-->

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />


</head>

<body>

	

	<div class="limiter">

		<div class="container-login100">

			<div class="wrap-login100">

				<div class="login100-pic js-tilt" data-tilt>

<?php

					$imagenCompu = "img-01.png";

					if ( isset($error_message) ){

						$imagenCompu = "img-triste.png";

					} else {

						$min = intval( date("i") );

						if ( $min % 2 == 0 ){

						        $imagenCompu = "img-feliz.png";

						} else {

							$imagenCompu = "img-01.png";

						}

					}  

?>				

					<img src="https://lanuzasoft.com/images/<?= $imagenCompu; ?>" alt="IMG">

				</div>

               

                

				<form id="login" class="login100-form validate-form" method="post" enctype="multipart/form-data" action="<?= PROJECTURLMENU; ?>userAuthentication/login">

<?php

				if ( !isset($error_message) ){

?>

					<span class="login100-form-title">

						Bienvenido a <br/> Lanuza Soft

						<br/>

				               <a class="txt3" href="https://www.lanuzagroup.com/">

							&iquest;Te gustar&iacute;a conocer m&aacute;s&quest;

							<i class="fa fa-idea m-l-5" aria-hidden="true"></i>

						</a>

					</span>

<?php

				} else {

?>

					<span class="login100-form-title">

						Tus credenciales<br />no son v&aacute;lidas

						<br />

					</span>

					<span class="txt1">

						Por favor int&eacute;ntalo otra vez
						<br/><br/>
					</span>
					<br/>

<?php

				}

?>

                    

					<!-- class="wrap-input100 validate-input"  data-validate = "Debe ser un E-mail valido: ejemplo@ej.com" -->

					<div class="wrap-input100">
						<input class="input100" type="text" placeholder="Correo o Usuario" name="username" id="username"/>

						<span class="focus-input100"></span>

						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>



					<div class="wrap-input100 validate-input" data-validate="No puede ser en blanco">
						<div class="row">
							<div class="col-sm-10">
								<input class="input100" type="password" placeholder="Contraseña" name="password" id="password" />
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="fa fa-lock" aria-hidden="true"></i>
								</span>
							</div>
							<style>
								#to_see_asterisks {
									text-align:left;
									padding-left: 0px;
									vertical-align: middle;
									font-size: 30px; 
									color: #53E3A6;
									margin-top:5px;
								}
							</style>
							<div class="col-sm-2" id="to_see_asterisks">
								<span class="glyphicon glyphicon-eye-open" title="Ver Contraseña" onclick="javascript:tooglePasswordField();" id="glyphiconID"></span>
							</div>
						</div>
					</div>

					

					<div class="container-login100-form-btn">

						<button class="login100-form-btn">

							Inicio

						</button>

					</div>



					<div class="text-center p-t-12">

						<span class="txt1">

							&iquest;Olvid&oacute; el

						</span>

						<a class="txt2" href="https://lanuzasoft.com/restaurar.html">

							Usuario o la Contrase&ntilde;a&quest;

						</a>

					</div>

					<div class="text-center p-t-12">

						<span class="txt1">

							&iquest;No tiene cuenta&quest;

						</span>

						<br/>

						<a class="txt2" href="<?= PROJECTURLMENU; ?>register">

							Reg&iacute;strese como nuevo Cliente<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>

						</a>

					</div>

                        

					</div>

				</form>

			</div>

		</div>

	</div>

	

	



	

<!--===============================================================================================-->	

	<script src="https://lanuzasoft.com/vendor/jquery/jquery-3.2.1.min.js"></script>

<!--===============================================================================================-->

	<script src="https://lanuzasoft.com/vendor/bootstrap/js/popper.js"></script>

	<script src="https://lanuzasoft.com/vendor/bootstrap/js/bootstrap.min.js"></script>

<!--===============================================================================================-->

	<script src="https://lanuzasoft.com/vendor/select2/select2.min.js"></script>

<!--===============================================================================================-->

	<script src="https://lanuzasoft.com/vendor/tilt/tilt.jquery.min.js"></script>

	<script >

		$('.js-tilt').tilt({

			scale: 1.1

		});
		
		function tooglePasswordField(){
			if ( $('#password').attr('type') === "password" ) {
 				$('#password').attr('type', "text");
				$('#glyphiconID').removeClass("glyphicon-eye-open");
				$('#glyphiconID').addClass("glyphicon-eye-close");
 				
			} else {
				$('#password').attr('type', "password");
				$('#glyphiconID').removeClass("glyphicon-eye-close");
				$('#glyphiconID').addClass("glyphicon-eye-open");
			}
		}

	</script>

<!--===============================================================================================-->

	<script src="https://lanuzasoft.com/js/main.js"></script>





<!--==================     Modal    ===============================================================-->

<style>

	.logo-small {

		color: #337AB7;

		font-size: 50px;

	}

</style>

<div class="modal fade" id="myModal" role="dialog">

	<div class="modal-dialog modal-lg">

		<div class="modal-content" style="top: 50px;">

			<div class="modal-header">
			
				<span class="glyphicon glyphicon-info-sign" style="font-size:  34px;"></span></p>

				<h4 class="modal-title">

<?php					

					if ( isset($index_message_title)) {

						echo "<i>" . $index_message_title ."</i>";

					}

?>

				</h4>
				
				<button type="button" class="close" data-dismiss="modal">&times;</button>

			</div>

			<div class="modal-body">

				<p>

<?php

					if ( isset($index_message) ){

						echo "<i>" . $index_message ."</i>";

					}

?>

				</p>

			</div>

			<div class="modal-footer">

				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

			</div>

		</div>

	</div>

</div>

<?php

	if ( isset($index_message)) {

		echo "<script> $('#myModal').modal('show'); </script> ";

	}

?>



</body>

</html>