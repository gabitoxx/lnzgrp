<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    
    <title><?php echo $pageTitle ?> | Lanuza Group</title>  
  
    <!-- CSS files here... -->
    <link href="<?php echo base_url(); ?>/application/views/css/styles.css?version=3" rel="stylesheet" type="text/css" >
    
    <!-- Menú superior -->
    <!-- link rel="stylesheet" href="<?php echo base_url(); ?>/application/views/css/style.css" type="text/css" media="screen" -->

    <!-- Google fonts here... -->

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                      <span class="sr-only">Men&uacute;</span>
                        <span class="icon-bar"><a href="<?php echo base_url(); ?>">Home</a></span>
                        <span class="icon-bar"><a href="<?php echo base_url(); ?>contactosControllerTut/agregar/">Agregar Usuario</a></span>
                        <span class="icon-bar"><a href="<?php echo base_url(); ?>home/aboutUs">Nosotros</a></span>
                        <span class="icon-bar"><a href="<?php echo base_url(); ?>home/services">Servicios</a></span>
                        <span class="icon-bar"><a href="<?php echo base_url(); ?>home/clients">Clientes</a></span>
                        <span class="icon-bar"><a href="<?php echo base_url(); ?>home/contact">Contacto</a></span>
                  </button>
                  <!a class="navbar-brand"  href="<?php echo base_url(); ?>">
                      <img class="img-border2" src="<?php echo base_url(); ?>/application/views/images/logo.png" alt="Lanuza Group | Home" />
                  </a>
              </div>
              <div class="navbar-collapse collapse" id="barra-collapse">
                  <ul class="nav navbar-nav">
                      <div class="menu-row">
            	        <div class="menu-bg">
                          <div class="main">
                            <nav class="indent-left">
                            <ul class="menu wrapper">
                                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li><a href="<?php echo base_url(); ?>contactosControllerTut/agregar/">Agregar Usuario</a></li>
                                <li><a href="<?php echo base_url(); ?>home/aboutUs">Nosotros</a></li>
                                <li><a href="<?php echo base_url(); ?>home/services">Servicios</a></li>
                                <li><a href="<?php echo base_url(); ?>home/clients">Clientes</a></li>
                                <li><a href="<?php echo base_url(); ?>home/contact">Contacto</a></li>
                            </ul>
                          </nav>
                        </div>
                      </div>
                    </div>
                  </ul>
              </div>
          