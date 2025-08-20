<?php
$logPath = "/var/log/mmdvm/MMDVMBM-" . date("Y-m-d") . ".log";
$miIndicativo = "EA3EIZ";
$dmrIdsFile = "/home/pi/MMDVMHost/DMRIds.dat";

// Leemos DMRIds.dat
$indicativoNombre = [];
if (file_exists($dmrIdsFile)) {
    foreach (file($dmrIdsFile) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') continue;
        $parts = preg_split('/\s+/', $line, 3);
        if (count($parts) >= 3) {
            list($numero, $indicativo, $nombre) = $parts;
            $indicativoNombre[$indicativo] = ['id' => $numero, 'nombre' => $nombre];
        }
    }
}

if (!file_exists($logPath)) {
    echo "<div class='no-talk'>NO TALK — Log no encontrado.</div>";
    return;
}

$lines = array_reverse(file($logPath));
$talkInfo = null;

foreach ($lines as $line) {
    $line = trim($line);

    // Detectar inicio de transmisión desde RF o red
    if (preg_match('/received (RF|network) voice header from (\w+) to TG (\d+)/', $line, $m)) {
        $callsign = $m[2];
        $tg = $m[3];
        $info = $indicativoNombre[$callsign] ?? ['id' => 'Desconocido', 'nombre' => 'N/A'];
        $talkInfo = [
            'yo' => ($callsign === $miIndicativo),
            'callsign' => $callsign,
            'id' => $info['id'],
            'name' => $info['nombre'],
            'tg' => $tg,
            'duration' => 'TX', // aún no ha terminado
            'ber' => 'N/A'
        ];
        break;
    }

    // Detectar fin de transmisión (por si no hubo header)
    if (preg_match('/received RF end of voice transmission from (\w+) to TG (\d+), ([\d\.]+) seconds, BER: ([\d\.]+)%/', $line, $m)) {
        $callsign = $m[1];
        $tg = $m[2];
        $duration = $m[3];
        $ber = $m[4];
        $info = $indicativoNombre[$callsign] ?? ['id' => 'Desconocido', 'nombre' => 'N/A'];
        $talkInfo = [
            'yo' => ($callsign === $miIndicativo),
            'callsign' => $callsign,
            'id' => $info['id'],
            'name' => $info['nombre'],
            'tg' => $tg,
            'duration' => $duration,
            'ber' => $ber
        ];
        break;
    }

    if (preg_match('/Mode set to Idle/', $line)) {
        $talkInfo = null;
        break;
    }
}

$lineas = file('/home/pi/MMDVMHost/MMDVMBM.ini');
$indicativo = isset($lineas[1]) ? trim($lineas[1]) : '';
$Id = isset($lineas[2]) ? trim($lineas[2]) : '';
$rx = isset($lineas[12]) ? trim($lineas[12]) : '';
$tx = isset($lineas[13]) ? trim($lineas[13]) : '';
?>


<div class="container">

  <!-- Bloque de indicativo e ID -->
  <div class="row justify-content-center mb-3">
    <div class="col-12 col-md-3 text-center mb-2 mb-md-0">
      <span class="indicativo">
        <?php echo $indicativo ?>
      </span>
    </div>
    <div class="col-12 col-md-3 text-center">
      <span class="id">
        <?php echo $Id ?>
      </span>
    </div>
  </div>

  <!-- Bloque de RX y TX -->
  <div class="row justify-content-center mb-3">
    <div class="col-12 col-md-3 text-center mb-2 mb-md-0">
      <span class="rx">
        <?php echo $rx ?>
      </span>
    </div>
    <div class="col-12 col-md-3 text-center">
      <span class="tx">
        <?php echo $tx ?>
      </span>
    </div>
  </div>

</div>
<?php
if ($talkInfo) {
    echo "<div class='btn btn-callsign'>" . htmlspecialchars($talkInfo['callsign']) . "</div>";
    echo "<div class='btn btn-id'>ID: " . htmlspecialchars($talkInfo['id']) . "</div>";
    echo "<div class='btn btn-tg'>TG: " . htmlspecialchars($talkInfo['tg']) . "</div>";
    echo "<div class='btn btn-name'>Nombre: " . htmlspecialchars($talkInfo['name']) . "</div>";
    echo "<div class='btn btn-time'>Duración: " . htmlspecialchars($talkInfo['duration']) . " s</div>";
    echo "<div class='btn btn-ber'>BER: " . htmlspecialchars($talkInfo['ber']) . " %</div>";
} else {
    echo "<div class='no-talk'></div>"; // Nadie está hablando
    echo "<div class='hora'>" . date("H:i:s") . "</div>";
}
?>
