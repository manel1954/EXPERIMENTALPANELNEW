<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filePath = "/home/pi/MMDVMHost/MMDVMBM.ini";
    $lineas = file($filePath);
    $num = intval($_POST["num_linea"]) - 1;
    $contenido = $_POST["contenido_linea"];

    if (isset($lineas[$num])) {
        $lineas[$num] = $contenido . PHP_EOL;
        file_put_contents($filePath, implode("", $lineas));
        echo "OK";
    } else {
        echo "ERROR";
    }
}
?>
