<?php
$fechaHoy = date('Y-m-d');
$archivoLog = "/var/log/mmdvm/MMDVMBM-{$fechaHoy}.log";
$entradas = [];
?>
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
if (file_exists($archivoLog)) {
    $lineas = file($archivoLog, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Recorremos desde el final hacia arriba
    for ($i = count($lineas) - 1; $i >= 0; $i--) {
        $linea = $lineas[$i];

        if (preg_match(
            '/M:\s+(\d{4}-\d{2}-\d{2})\s+(\d{2}:\d{2}:\d{2}\.\d{3}).*received network voice header from\s+([A-Z0-9]+)\s+to TG (\d+)/',
            $linea,
            $matches
        )) {
            $fecha = $matches[1];
            $hora = substr($matches[2], 0, -4);
            $callsign = $matches[3];
            $tg = $matches[4];

            $timestamp = "$fecha $hora";
            $id = "—";

            // Evitar duplicados consecutivos
            if (empty($entradas) || $entradas[count($entradas) - 1]['callsign'] != $callsign) {
                $entradas[] = [
                    'fecha' => $timestamp,
                    'callsign' => $callsign,
                    'id' => $id,
                    'tg' => $tg
                ];
            }

            if (count($entradas) >= 10) break;
        }
    }
} else {
    echo "<tr><td colspan='5'>Log no encontrado: $archivoLog</td></tr>";
}

if (empty($entradas)) {
    echo "<tr><td colspan='5'>No hay actividad reciente</td></tr>";
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
