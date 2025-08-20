<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Monitor BM</title>
    <meta name="author" content="EA3EIZ">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="imagenes/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/estilos.css">

<style>
</style>

</head>
<body>
    <h1>Monitor Brandmeister</h1>

  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color:rgb(98, 46, 46);height:70px;">
  <div class="container d-flex align-items-center">
    
    <!-- Logo a la izquierda -->
    <a class="navbar-brand" href="https:/associacioader.com" target="_blank">
      <img src="../img/Logo_Ader_New.png" alt="Logo ADER" width="50">
    </a>

    <!-- Botón hamburguesa -->
    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menú colapsable -->
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav"> 

        <li class="nav-item mx-3">
          <a class="nav-link text-white" href="../panel_control.php">PANEL DE CONTROL</a>
        </li>

        <li class="nav-item mx-3">  
          <a class="nav-link text-white" href="editor_bm.php">EDITOR BRANDMEISTER</a>
        </li> 

        <li class="nav-item mx3">
          <a style="color:#000;font-weight: bold;" class="nav-link active">MONITOR NEXTION BM</a>
        </li>

        <li class="nav-item mx-3">
          <a class="nav-link text-white" href="../panel_monitor_dmrplus/index.php">MONITOR NEXTION DMR+</a>
        </li>


      </ul>
    </div>
  </div>
</nav>



<div class="row">
  <div class="col-6 offset-3 text-center">
    <span class="text-center color_font_Bebas_azul">NEXTION&nbsp;&nbsp;&nbsp;&nbsp;</span>
    <span class="text-center color_font_Bebas_naranja">  BRANDMEISTER</span>
  </div>
</div>




<?php
$iniFile = "/home/pi/MMDVMHost/MMDVMBM.ini";

function leerLineaINI($ruta, $lineaDeseada, $etiqueta) {
    if (file_exists($ruta)) {
        $lineas = file($ruta, FILE_IGNORE_NEW_LINES);
        if (isset($lineas[$lineaDeseada - 1])) {
            $linea = $lineas[$lineaDeseada - 1];
            $pos = strpos($linea, '=');
            if ($pos !== false) {
                $valor = substr($linea, $pos + 1);
                echo "<div class='parametros'>$etiqueta: " . htmlspecialchars($valor) . "</div>";
            } else {
                echo "<div class='btn btn-name'>Línea $lineaDeseada: (no hay signo igual en la línea)</div>";
            }
        } else {
            echo "<div class='no-talk'>La línea $lineaDeseada no existe.</div>";
        }
    } else {
        echo "<div class='no-talk'>Archivo INI no encontrado.</div>";
    }
}


?>

<!-- Contenedor dinámico -->
<div id="contenido">
    <?php include 'muestra_monitor_nextion_bm.php'; ?>
</div>

    <!-- Sección de Últimos 10 Escuchados - Centrada -->
    <div class="container mt-5">
      <div class="col-6 offset-3">
        <h3 class="text-center color_font_Bebas_azul">ÚLTIMOS 10 ESCUCHADOS - DMR+</h3>
        <div id="ultimos-escuchados">
          <?php include 'ultimos_escuchados.php'; ?>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Actualización AJAX -->
    <script>
    function actualizarContenido() {
        fetch('muestra_monitor_nextion_bm.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('contenido').innerHTML = data;
            })
            .catch(error => console.error('Error al actualizar contenido:', error));
    }

    function actualizarUltimos() {
        fetch('ultimos_escuchados.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('ultimos-escuchados').innerHTML = data;
            })
            .catch(error => console.error('Error al actualizar últimos escuchados:', error));
    }

    // refrescar cada 3 segundos
    setInterval(actualizarContenido, 3000);
    setInterval(actualizarUltimos, 3000);
    </script>










</body>
</html>
