<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel control</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="ea3eiz echolink Conferencia 3spain">
    <meta name="description" content="Conferencia echolink libre para todos los radioaficionados con indicativo">
    <meta name="author" content="EA3EIZ">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="imagenes/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/estilos.css">

<!-- refresca la página cada 10 segundo (implantado por mi) -->
<!-- ====================================================== -->
<!-- <meta http-equiv="refresh" content="5" /> -->
<style>
body {
    background-color: #111;
    color: #fff;
    font-family: 'Arial';
    margin: 0;
    padding: 100 px;
    font-size:18px;
}

.btn{
  height:10px;
  text-align:center;
  border-radius:2px;
  padding-top:-10px;
}
</style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color:rgb(98, 46, 46);height:70px;">
  <div class="container d-flex align-items-center">
    
    <!-- Logo a la izquierda -->
    <a class="navbar-brand" href="https:/associacioader.com" target="_blank">
      <img src="img/Logo_Ader_New.png" alt="Logo ADER" width="50">
    </a>

    <!-- Botón hamburguesa -->
    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menú colapsable -->
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav">             
        <!-- Submenú "enlaces" -->
        <li class="nav-item dropdown mx-3">
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            Enlaces de interés
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="http://rem-esp.es/rem/asociacion/index.php" target="_blank">ASOCIACION REM</a></li>
            <li><a class="dropdown-item" href="http://www.ea3eiz.com" target="_blank">EA3EIZ.COM</a></li>
            <li><a class="dropdown-item" href="http://www.xreflector.es" target="_blank">REFLECTOR.ES</a></li>
          </ul>
        </li>

<!-- Submenú "Todo sobre DMR" -->
<li class="nav-item dropdown mx-3">
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            DMR
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="https://radioid.net/register" target="_blank">REGISTRO IDS</a></li>
            <li><a class="dropdown-item" href="https://monitor.brandmeister.es" target="_blank">MONITOR BM</a></li>
            <li><a class="dropdown-item" href="http://dmr.xreflector.es" target="_blank">IPSC2-EA-Hotspot</a></li>
            <li><a class="dropdown-item" href="http://eamaster04.xreflector.es/ipsc" target="_blank">IPSC2-EA4Master</a></li>
          </ul>
        </li>

<!-- Submenú "Todo sobre FUSION" -->
<li class="nav-item dropdown mx-3">
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            FUSION
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="http://aderdigital.ddns.net/ysf/" target="_blank">ES-ADER</a></li>
            <li><a class="dropdown-item" href="http://ysfdistrito4.xreflector.es" target="_blank">EA-Distrito4</a></li>
            <li><a class="dropdown-item" href="https://europelink.pa7lim.nl" target="_blank">EUROPELINK</a></li>
          </ul>
        </li>


 <!-- Submenú "Todo sobre DSTAR" -->
<li class="nav-item dropdown mx-3">
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            DSTAR
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="http://rem-esp.es/rem/asociacion/index.php" target="_blank">ASOCIACION REM</a></li>
            <li><a class="dropdown-item" href="http://www.ea3eiz.com" target="_blank">EA3EIZ.COM</a></li>
            <li><a class="dropdown-item" href="http://www.xreflector.es" target="_blank">REFLECTOR.ES</a></li>
          </ul>
        </li>       



<li class="nav-item">
          <a style="color:#fff;" class="nav-link" href="../../subir_archivos.php">📁 SUBIR ARCHIVOS</a>
        </li>

      </ul>
    </div>
  </div>
</nav>

<div class="container" style="margin-top: 30px;">

<!-- <h2><?php echo $fecha_hoy; ?></h2>

<h2><?php echo $hora_madrid; ?></h2> -->



<div class="row text-center align-items-center" style="height: 100px; margin-bottom: 120px;"> <!-- altura opcional -->
    <!-- Primer div: alineado a la derecha y centrado verticalmente -->
    <div class="col-md-4 offset-1 d-flex justify-content-end align-items-center">
        <span class="color_font_Bebas_azul">PANEL DE CONTROL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
    </div>

    <!-- Imagen: centrada horizontal y verticalmente -->
    <div class="col-md-2 d-flex justify-content-start align-items-center">
        <a href="https:/associacioader.com" target="_blank"><img src="img/Logo_Ader_New.png" width="100"></a>
    </div>

    <!-- Tercer div: alineado a la izquierda y centrado verticalmente -->
    <div class="col-md-4 d-flex justify-content-start align-items-center">
        <span class="color_font_Bebas_naranja">EXPERIMENTAL-PANEL&nbsp;&nbsp;</span>
    </div>
</div><!-- row  -->

<!-- <hr class="linea-blanca"> -->


<div class="row" style="margin-bottom: -100px;">
</div><!-- row  -->

<div class="row" style="margin-bottom: 60px;">
    <div class="col-md-3 text-center"><br>
        <a href="../upload/crear_zip.php" target="_blank">
            <img src="img/backup.png" width="200">
        </a>
        <a href="../upload/crear_zip.php"
           class="btn btn-warning d-flex justify-content-center align-items-center mx-auto"
           style="height: 30px; font-size: 10px; width: fit-content; padding: 0 10px; line-height: 1;">
            HACER COPIA DE SEGURIDAD
        </a>
    </div>

    <div class="col-md-3 text-center"><br>
        <a href="../upload/form.php" target="_blank">
            <img src="img/restore.png" width="200">
        </a>
        <a href="../upload/form.php"
           class="btn btn-success d-flex justify-content-center align-items-center mx-auto"
           style="height: 30px; font-size: 10px; width: fit-content; padding: 0 10px; line-height: 1;">
            RESTAURAR COPIA DE SEGURIDAD
        </a>
    </div>

<div class="col-md-3 text-center"><br>
    <a href="../index_dvswitch.php">
        <img src="../img/logo_dvswitch.png" width="240">
    </a><br>
    <a href="../index_dvswitch.php"
       class="btn btn-success d-flex justify-content-center align-items-center mx-auto"
       style="height: 30px; font-size: 12px; width: fit-content; padding: 0 10px; line-height: 1;">
        DASHBOARD DVSWITCH
    </a>
</div>


<div class="col-md-3 text-center"><br>
    <a href="http://<?php echo $ip_hblink; ?>" target="_blank">
        <img src="img/logo_hblink.png" width="163">
    </a><br>
    <a href="http://<?php echo $ip_hblink; ?>" target="_blank"
       class="btn btn-primary d-flex justify-content-center align-items-center mx-auto"
       style="height: 30px; font-size: 12px; width: fit-content; padding: 0 10px; line-height: 1;">
        DASHBOARD HBLINK3
    </a>
</div>

</div><!-- row -->


<div class="row text-center align-items-center" style="height: 100px; margin-bottom: 120px;">
    <!-- Primer div: alineado a la derecha y centrado verticalmente -->
    <div class="col-md-2 offset-5 text-center">
        <br>
        <img src="img/NEXTION.png" width="170"><br>
        <a href="menu.php" class="btn btn-primary d-flex justify-content-center align-items-center mx-auto"
           style="height: 25px; font-size: 13px; width: fit-content; padding: 0 10px; line-height: 1;">
            MONITORES NEXTION
        </a>
    </div>
</div>


</div><!-- container -->



<br>
<!-- Incluir Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
