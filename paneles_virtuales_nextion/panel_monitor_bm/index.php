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
    <?php include 'contenidoBM.php'; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>


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

setInterval(actualizarContenido, 1000); // cada 3 segundos
</script>












<!-- Sección de Últimos 10 Escuchados - MMDVM BM (RF) -->
<div class="container mt-5">
  <div class="col-6 offset-3">
    <h3 class="text-center color_font_Bebas_azul">ÚLTIMOS 10 ESCUCHADOS - BM (RF)</h3>
    <div class="table-responsive">
      <table class="table table-dark table-striped table-hover align-middle text-center">
        <thead>
          <tr>
            <th>#</th>
            <th>Fecha y Hora</th>
            <th>Call</th>
            <th>ID</th>
            <th>TG</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $fechaHoy = date('Y-m-d');
          $archivoLog = "/var/log/mmdvm/MMDVMBM-{$fechaHoy}.log"; // Cambia si tu log se llama distinto

          $entradas = [];

          if (file_exists($archivoLog)) {
              $lineas = file($archivoLog, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

              // Recorremos desde el final hacia arriba (más recientes primero)
              for ($i = count($lineas) - 1; $i >= 0; $i--) {
                  $linea = $lineas[$i];

                  // ✅ Buscamos INICIO de transmisión por RF (lo más temprano y fiable)
                  if (preg_match(
                      '/M:\s+(\d{4}-\d{2}-\d{2})\s+(\d{2}:\d{2}:\d{2}\.\d{3}).*received RF voice header from\s+([A-Z0-9]+)\s+to TG (\d+)/',
                      $linea,
                      $matches
                  )) {
                      $fecha = $matches[1];
                      $hora = substr($matches[2], 0, -4); // sin milis
                      $callsign = $matches[3];
                      $tg = $matches[4];
                      $timestamp = "$fecha $hora";
                      $id = "—"; // por defecto

                      // 🔎 Buscar ID en las líneas previas (FindWithName)
                      // Buscamos hasta 10 líneas antes
                      for ($j = $i - 1; $j >= max(0, $i - 10); $j--) {
                          $lineaAnterior = $lineas[$j];

                          // Caso: FindWithName =CALL ID (ej: =EA3EIZ 213456789)
                          if (preg_match('/FindWithName\s+=' . preg_quote($callsign) . '\s+(\d+)/', $lineaAnterior, $idMatch)) {
                              $id = $idMatch[1];
                              break;
                          }

                          // Caso: FindWithName =CALL Nombre (ej: =EA3EIZ Manel) → no hay ID
                          // No hacemos nada, ID sigue siendo "—"
                      }

                      // Evitar duplicados consecutivos del mismo callsign
                      if (empty($entradas) || $entradas[count($entradas) - 1]['callsign'] != $callsign) {
                          $entradas[] = [
                              'fecha' => $timestamp,
                              'callsign' => $callsign,
                              'id' => $id,
                              'tg' => $tg
                          ];
                      }

                      // Salimos cuando tengamos 10
                      if (count($entradas) >= 10) break;
                  }
              }
          } else {
              echo "<tr><td colspan='5'>Log no encontrado: $archivoLog</td></tr>";
          }

          // Mostrar resultados
          if (empty($entradas)) {
              echo "<tr><td colspan='5'>No hay actividad RF reciente</td></tr>";
          } else {
              foreach ($entradas as $index => $entrada) {
                  echo "<tr>
                          <td>" . ($index + 1) . "</td>
                          <td>{$entrada['fecha']}</td>
                          <td><strong>{$entrada['callsign']}</strong></td>
                          <td>{$entrada['id']}</td>
                          <td>TG {$entrada['tg']}</td>
                        </tr>";
              }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>











</body>
</html>
