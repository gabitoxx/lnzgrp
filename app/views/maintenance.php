<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>LanuzaSoft :: Gestión de Equipos</title>

	<link rel="shortcut icon" href="<?= APPIMAGEPATH; ?>favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?= APPIMAGEPATH; ?>favicon.ico" type="image/x-icon">
	
	<link rel="apple-touch-icon" href="<?= APPIMAGEPATH; ?>apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?= APPIMAGEPATH; ?>apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?= APPIMAGEPATH; ?>apple-touch-icon-114x114.png">

	<meta name="google-site-verification" content="7MTL52H6Hqrg5Ps8VtI8Lc5XraA_mI9P570lCUClxe0" />


	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	<link rel="stylesheet" href="css/error.css" type="text/css" media="screen">
	
  <style>
    ._404 {
      font-size: 50px !important;
      height: 90px !important;
      font-family: monospace !important;
      color: black !important;
      letter-spacing: 2px !important;
    }
    ._2 {
      color: black !important;
    }
    ._1 {
      font-size: 2rem !important;
      letter-spacing: 0px !important;
      color: black !important;
    }
    ._5 {
      color: black !important;
    }
    ._d {
      color: #e10716;
    }
    ._h {
      color: black;
    }
    ._m {
      color: #aab5ba;
    }
    ._s {
      color: black;
    }
  </style>
</head>
<body id="myPage">

	<div id="clouds">
            <div class="cloud x1"></div>
            <div class="cloud x1_5"></div>
            <div class="cloud x2"></div>
            <div class="cloud x3"></div>
            <div class="cloud x4"></div>
            <div class="cloud x5"></div>
        </div>
        <div class='c'>
            
            <div class='_2'>Tiempo en que estaremos de vuelta:</div>
        
            <div class='_404' id="timer">
              <span id="diax" class="_d"></span>
               : 
              <span id="horax" class="_h"></span>
               : 
              <span id="minx" class="_m"></span>
               : 
              <span id="secx" class="_s"></span>
            </div>

            <div class='_2'>
              <span style="color:red;">Días</span>
               : 
               <span style="color:black;"> Horas</span>
               : 
              <span style="color:#aab5ba;"> Minutos</span>
               : 
               <span style="color:black;">Segundos</span>
            </div>
            <hr/>
            <div class='_1'>En estos momentos estamos trabajando, actualizando el sistema para ofrecerle un mejor servicio</div>
            <br/>
            <div class="_5">
              <table style="width: 100%;">
                <tr>
                  <td>
                  <!-- img src="< ? = APPIMAGEPATH; ? >construccion.jpg" class="img-rounded" alt="Compu" style="height: 100px; width: 130px;" -->
                  </td>
                  <td>
                    Por tareas de actualización y mantenimiento, el portal <b>permanerecerá inactivo</b>
                    los días <b>sábado 4 y domingo 5 de septiembre</b> de 2021. Rogamos disculpe las molestias.
                    <br/>
                    Si necesita hablar con nuestro equipo de Lanuza Group de forma urgente, puede contactarnos, durante el periodo de cierre, 
                    directamente al correo <b>soporte@lanuzagroup.com</b>.
                  </td>
                </tr>
              </table>
            </div>
            <hr>
            <a class='btn' href='https://www.lanuzasoft.com/'>Regresar</a>
        </div>

	
	<!--div class="row">
		<div class="col-sm-12">
			<img src="<?= APPIMAGEPATH; ?>logo.png" alt="Lanuza Group" class="img-responsive" width="700" height="381">
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<a href="https://lanuzasoft.com/">Volver a la Página de Incio</a>
		</div>
	</div-->
  <script>
		var hora = 48, sHora = "";
		var min = 1, sMin = "";
    var sec = 59, sSec = "";
		var dia = 2, sDia = "";
		
		var finishDate = new Date("Sep 6, 2021 6:0:0").getTime(); // fin
		var now;
		var resta = 0;
		
    window.onload = function () {
		
			now = new Date().getTime();//ahorita mismo
			
			// en millisecs
			resta = finishDate - now;console.log("resta:", resta);
			
			// la resta en millisecs, transformarla a cada intervalo
			dia   = parseInt( resta / (1000 * 60 * 60 * 24) ); 
			var h = parseInt( resta / (1000 * 60 * 60));
			var m = parseInt( resta / (1000 * 60)); 
			var s = parseInt( resta /  1000 ); 
			
			// a cada intervalo, restar del anterior. Ej: si quedan 60 horas es porque realmente son 2 días + 12h
			// en cada intervalo, transformar a su equivalente
			hora= parseInt( h - ( dia*24 ));
			min = parseInt( m - ( dia*24*60 + hora*60 ) );
			sec = parseInt( s - ( dia*24*60*60 + hora*60*60 + min*60) );
			
			// info
			console.log("faltan "+dia+" dias");
			console.log("faltan "+hora+" horas");
			console.log("faltan "+min+" minnutes");
			console.log("faltan "+sec+" seconndos");
            
      setInterval(function () {
		
				sDia = ""+dia;
				sHora= ( hora< 10 ) ? "0" + hora: hora;
				sMin = ( min < 10 ) ? "0" + min : min;
				sSec = ( sec < 10 ) ? "0" + sec : sec;
        
        document.getElementById("diax").innerHTML = sDia;
        document.getElementById("horax").innerHTML= sHora;
        document.getElementById("minx").innerHTML = sMin;
        document.getElementById("secx").innerHTML = sSec;
        //document.getElementById("timer").innerHTML = sDia + " : " + sHora + " : " + sMin + " : " + sec;

        sec--; // el intervalo está en segundos
        if ( sec <= 0 ){
          min--;
          sec = 59;
          if ( min <= 0 ){
					  hora--;
            min = 59;
					  if ( hora <= 0 ){
              dia--;
              hora = 23;
					  }
          }
        }
      }, 1000); // el intervalo está en segundos
    };
</script>
</body>