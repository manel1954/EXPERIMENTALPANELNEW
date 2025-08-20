<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Monitor DMR+</title>
    <meta name="author" content="EA3EIZ">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="imagenes/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Monitor DMR+</h1>

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
              <a class="nav-link text-white" href="editor_dmrplus.php">EDITOR DMR+</a>
            </li> 
            <li class="nav-item mx-3">
              <a class="nav-link text-white" href="../panel_monitor_bm/index.php">MONITOR NEXTION BM</a>
            </li>  
            <li class="nav-item mx3">
              <a style="color:#000;font-weight: bold;" class="nav-link active">MONITOR NEXTION DMR+</a>
            </li>      
          </ul>
        </div>
      </div>
    </nav>

    <div class="row mt-5">
      <div class="col-6 offset-3 text-center">
        <span class="text-center color_font_Bebas_azul">NEXTION&nbsp;&nbsp;&nbsp;&nbsp;</span>
        <span class="text-center color_font_Bebas_naranja">  DMR+</span>
      </div>
    </div>

    <!-- Contenedor dinámico Monitor Nextion -->
    <div id="contenido">
        <?php include 'muestra_monitor_nextion_dmrplus.php'; ?>
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
        fetch('muestra_monitor_nextion_dmrplus.php')
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
