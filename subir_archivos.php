<?php
$mensaje = '';
$mostrarVistaPrevia = false;
$rutaImagen = '';

// Manejar eliminación de archivos 
if (isset($_GET['eliminar'])) {
    $archivo = urldecode($_GET['eliminar']);
    if (file_exists($archivo)) {
        unlink($archivo); // Elimina el archivo
        $mensaje = "La imagen ha sido eliminada correctamente.";
    } else {
        $mensaje = "No se encontró la imagen para eliminar.";
    }
}

// Manejar renombrado de archivos
if (isset($_POST['renombrar_actual']) && isset($_POST['nuevo_nombre'])) {
    $actual = $_POST['renombrar_actual'];
    $nuevoNombre = basename($_POST['nuevo_nombre']);
    $directorio = dirname($actual);
    $extension = pathinfo($actual, PATHINFO_EXTENSION);
    $nuevoArchivo = $directorio . '/' . $nuevoNombre . '.' . $extension;

    if (!empty($nuevoNombre)) {
        if (file_exists($nuevoArchivo)) {
            $mensaje = "Ya existe un archivo con ese nombre.";
        } elseif (!file_exists($actual)) {
            $mensaje = "No se encontró la imagen original.";
        } else {
            rename($actual, $nuevoArchivo);
            $mensaje = "El archivo ha sido renombrado correctamente.";
        }
    } else {
        $mensaje = "Por favor introduce un nombre válido.";
    }
}

// Procesar carga de imagen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagen'])) {
    $directorio = "upload/files/";
    $archivo = $directorio . basename($_FILES["imagen"]["name"]);
    $tipoArchivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));

    // Verificar si es una imagen JPG
    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if ($check === false) {
        $mensaje = "El archivo no es una imagen válida.";
    } elseif (file_exists($archivo)) {
        $mensaje = "Lo siento, el archivo ya existe.";
    } elseif ($_FILES["imagen"]["size"] > 2000000) {
        $mensaje = "Lo siento, el archivo es demasiado grande. Máximo 2MB.";
    } elseif ($tipoArchivo != "jpg" && $tipoArchivo != "jpeg") {
        $mensaje = "Lo siento, solo se permiten archivos JPG/JPEG.";
    } else {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $archivo)) {
            $mensaje = "El archivo " . htmlspecialchars(basename($_FILES["imagen"]["name"])) . " ha sido subido correctamente.";
            $rutaImagen = $archivo;
            $mostrarVistaPrevia = true;
        } else {
            $mensaje = "Hubo un error al subir tu archivo. Inténtalo más tarde.";
        }
    }
}

// Obtener lista de imágenes JPG en la carpeta upload
$imagenes = [];
if (is_dir("upload/files")) {
    $archivos = scandir("upload/files");
    foreach ($archivos as $archivo) {
        $ext = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg'])) {
            $imagenes[] = "upload/files/" . $archivo;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir y Listar Imágenes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Subir y Listar Imágenes JPG</h2>

    <?php if (!empty($mensaje)): ?>
        <div class="alert <?= strpos($mensaje, 'correctamente') !== false ? 'alert-success' : 'alert-danger'; ?>">
            <?= $mensaje; ?>
        </div>
    <?php endif; ?>

    <!-- Formulario de subida -->
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="imagen" class="form-label">Selecciona una imagen JPG</label>
            <input class="form-control" type="file" id="imagen" name="imagen" accept=".jpg,.jpeg" required>
        </div>

        <div class="mb-3">
            <img id="vistaPrevia" src="#" alt="Vista previa de la imagen" class="img-thumbnail mt-3" style="display: none; max-height: 300px;">
        </div>

        <?php if ($mostrarVistaPrevia): ?>
            <div class="mb-3">
                <p>Imagen subida:</p>
                <img src="<?= $rutaImagen ?>" class="img-thumbnail" style="max-height: 300px;">
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-success">Aceptar y Subir</button>
        <a href="/paneles_virtuales_nextion/panel_control.php" class="btn btn-danger">Cancelar</a>
    </form>

    <!-- Listado de imágenes guardadas como lista -->
    <?php if (!empty($imagenes)): ?>
        <hr class="my-4">
        <h3>Imágenes Guardadas</h3>
        <ul class="list-group mb-4">
            <?php foreach ($imagenes as $img): 
                $nombre = basename($img);
            ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><?= htmlspecialchars($nombre) ?></span>
                    <div class="btn-group" role="group">
                        <a href="<?= $img ?>" download class="btn btn-sm btn-info text-white">Descargar</a>
                        <a href="<?= $_SERVER['PHP_SELF'] ?>?eliminar=<?= urlencode($img) ?>" 
                           onclick="return confirm('¿Estás seguro de que deseas eliminar esta imagen?');" 
                           class="btn btn-sm btn-danger">
                            Eliminar
                        </a>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalRenombrar" data-imagen="<?= $img ?>">
                            Renombrar
                        </button>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <hr class="my-4">
        <p class="text-muted">No hay imágenes subidas aún.</p>
    <?php endif; ?>
</div>

<!-- Modal para renombrar -->
<div class="modal fade" id="modalRenombrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Renombrar Imagen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="renombrar_actual" id="renombrar_actual">
                    <div class="mb-3">
                        <label for="nuevo_nombre" class="form-label">Nuevo nombre (sin extensión)</label>
                        <input type="text" class="form-control" name="nuevo_nombre" id="nuevo_nombre" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('imagen').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('vistaPrevia');

        if (file && /\.(jpe?g)$/i.test(file.name)) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        } else {
            alert("Por favor selecciona solo archivos JPG.");
            this.value = '';
            preview.style.display = 'none';
        }
    });

    // Rellenar datos en modal de renombrar
    document.addEventListener('DOMContentLoaded', function () {
        var modalRenombrar = document.getElementById('modalRenombrar');
        if (modalRenombrar) {
            modalRenombrar.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var imagen = button.getAttribute('data-imagen');
                var nombreBase = imagen.substring(imagen.lastIndexOf("/") + 1, imagen.lastIndexOf("."));
                var modal = modalRenombrar.querySelector('form');
                modal.querySelector('#renombrar_actual').value = imagen;
                modal.querySelector('#nuevo_nombre').value = nombreBase;
            });
        }
    });
</script>

</body>
</html>