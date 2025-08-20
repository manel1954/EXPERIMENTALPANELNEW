<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar BM.ini</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/custom.css">
    <style>


    </style>
</head>
<body>
<div class="container mt-5 centrar-formulario">

<div class="row">
    <div class="col-6 offset-3 text-center">
    <a href="http://associacioader.com" target="_blank"><img src="../img/Logo_Ader_New.png" alt="Logo ADER" width="50"></a>
    </div>
</div>  

<div class="row">
  <div class="col-6 offset-3 text-center">
    <span class="text-center color_font_Bebas_azul">Editor&nbsp;&nbsp;&nbsp;&nbsp;</span>
    <span class="text-center color_font_Bebas_naranja">  Brandmeister</span>
  </div>
</div>

<!-- <hr class="linea-blanca"> -->

    <?php
    $filePath = "/home/pi/MMDVMHost/MMDVMBM.ini";
    $lineas = file($filePath);
    $mensaje = '';

    if (!empty($_POST["num_linea"]) && isset($_POST["contenido_linea"])) {
        $num = intval($_POST["num_linea"]) - 1;
        if (isset($lineas[$num])) {
            $lineas[$num] = $_POST["contenido_linea"] . PHP_EOL;
            file_put_contents($filePath, implode("", $lineas));
            $mensaje .= '<div class="alert alert-warning mt-2">Línea ' . ($num + 1) . ' actualizada.</div>';
        } else {
            $mensaje .= '<div class="alert alert-danger mt-2">La línea indicada no existe.</div>';
        }
    }
    ?>

    <hr>

<!-- Botón centrado para mostrar/ocultar el formulario -->
<div class="row mb-3">

<div class="col-3 text-left">
    <a href="index.php" class="btn btn-primary">Volver al Monitor Nextión</a>
</div>

<!-- <div class="col-6 text-center">
    <button id="toggle-form-btn" class="btn btn-success">
      Mostrar/Ocultar formulario de edición fichero MMDVMPLUS.ini
    </button>
  </div> -->

</div>


<!-- Formulario oculto inicialmente --> 
<form style="background:#141414;" method="post" class="mb-4" id="form-editar-linea-flotante">
    <div class="row">
        <div class="col-2">
            <input style="background:#141414; color:#ff0;" type="number" min="1" name="num_linea" id="num_linea" class="form-control" placeholder="N° línea" required>
        </div>
        <div class="col-8">
            <input style="background:#141414; color:#ff0;" type="text" name="contenido_linea" id="contenido_linea" class="form-control" placeholder="Nuevo contenido..." required>
        </div>
        <div class="col-2">
            <button class="btn btn-success w-100" type="submit">Editar línea</button>
        </div>
    </div>
</form>
<table class="table table-dark table-hover table-bordered">

<!-- <table class="table table-dark table-hover"> -->

    <!-- <table class="table table-bordered table-striped"> -->
        <thead class="table-light">
            <tr >
                <th style="background:#999; color:#3434ed;">Líneas</th>
                <th style="background:#999;color:#3434ed; ">Parametros</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($lineas as $num => $contenido) {
            $clase = ($num >= 1 && $num <= 4) ? "linea-editable" : "";
            $icono = ($num >= 1 && $num <= 4) ? '<span class="icono-editar"></span>' : '';
            $numeroLinea = $num + 1;
            $contenidoLimpio = htmlspecialchars(trim($contenido));

            // Detectar si la línea está entre corchetes
            if (preg_match('/^\[.*\]$/', trim($contenido))) {
                $contenidoFormateado = "<span style='color:#198754; font-weight:bold;'>" . htmlspecialchars($contenido) . "</span>";
            } else {
                $contenidoFormateado = htmlspecialchars($contenido);
            }

            echo "<tr class=\"$clase\">
                    <td class=\"linea-clickable\" data-linea=\"$numeroLinea\" data-contenido=\"" . htmlspecialchars($contenidoLimpio) . "\"><span style='color:#ffffff;font-weight:bold;cursor:pointer;'>Editar linea: </span> $numeroLinea</td>
                    <td class='editable' data-linea='$numeroLinea'>$contenidoFormateado</td>

                  </tr>";
        }
        ?>
        
        </tbody>
    </table>
</div>

<!-- ***** Botón Ir al inicio ***** -->
<button id="btn-inicio" title="Ir al inicio" style="display:none;">
  <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
    <polyline points="18 15 12 9 6 15"></polyline>
  </svg>
</button>

<!-- ***** Botón Ir al final ***** -->
<button id="btn-final" title="Ir al final" style="display:none;">
  <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
    <polyline points="6 9 12 15 18 9"></polyline>
  </svg>
</button>

<!-- ***** Mostrar/ocultar el formulario al pulsar el botón ***** -->
<script>
    document.getElementById('toggle-form-btn').addEventListener('click', function() {
        const form = document.getElementById('form-editar-linea-flotante');
        if (form.style.display === 'none' || form.style.display === '') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    });

    // ***** Rellenar el formulario al hacer clic en una línea *****
    document.querySelectorAll('.linea-clickable').forEach(td => {
        td.addEventListener('click', () => {
            const numLinea = td.dataset.linea;
            const contenido = td.dataset.contenido;
            document.getElementById('num_linea').value = numLinea;
            document.getElementById('contenido_linea').value = contenido;
            document.getElementById('contenido_linea').focus();
            // Opcional: mostrar el formulario al hacer clic en una línea
            document.getElementById('form-editar-linea-flotante').style.display = 'block';
        });
    });
</script>

<!-- ***** Botones para ir al Principio/Final del contenido de los parametros **** -->
<script>
window.addEventListener('scroll', function() {
  const btnInicio = document.getElementById('btn-inicio');
  const btnFinal = document.getElementById('btn-final');
  // Mostrar ambos botones solo cuando se hace scroll
  if (window.scrollY > 100) {
    btnInicio.style.display = 'flex';
  } else {
    btnInicio.style.display = 'none';
  }
  // Mostrar el botón "Ir al final" solo si no estamos al final
  if ((window.innerHeight + window.scrollY) < document.body.offsetHeight - 100) {
    btnFinal.style.display = 'flex';
  } else {
    btnFinal.style.display = 'none';
  }
});
// Scroll suave al inicio
document.getElementById('btn-inicio').addEventListener('click', function() {
  window.scrollTo({ top: 0, behavior: 'smooth' });
});
// Scroll suave al final
document.getElementById('btn-final').addEventListener('click', function() {
  window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
});
</script>



<script>
document.querySelectorAll('.editable').forEach(td => {
    td.addEventListener('dblclick', () => {
        const linea = td.dataset.linea;
        const valorOriginal = td.textContent.trim();
        const input = document.createElement('input');
        input.type = 'text';
        input.value = valorOriginal;
        input.style.width = '100%';
        input.style.background = '#141414';
        input.style.color = '#ff0';
        input.style.border = 'none';

        td.innerHTML = '';
        td.appendChild(input);
        input.focus();

        const guardarCambio = () => {
            const nuevoValor = input.value;
            fetch('editar_lineas_bm.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `num_linea=${linea}&contenido_linea=${encodeURIComponent(nuevoValor)}`
            })
            .then(res => res.text())
            .then(res => {
                if (res.trim() === 'OK') {
                    td.innerHTML = nuevoValor;
                } else {
                    td.innerHTML = valorOriginal;
                    alert("Error al guardar los cambios.");
                }
            });
        };

        input.addEventListener('blur', guardarCambio);
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                guardarCambio();
            } else if (e.key === 'Escape') {
                td.innerHTML = valorOriginal;
            }
        });
    });
});
</script>








</body>
</html>
