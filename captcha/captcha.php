<?php
session_start();
require 'nastroiki.php';

if (!isset($_SESSION['kod'])) {
    novyi_kod();
}

$put = __DIR__ . '/noise.jpg';
$kartinka = imagecreatefromjpeg($put);
$tcvet = imagecolorallocate($kartinka, 18, 10, 120);
$svet = imagecolorallocate($kartinka, 245, 240, 200);

for ($i = 0; $i < DLINA; $i++) {
    $x = 14 + $i * SHAG;
    $y = mt_rand(29, 33);
    $razmer = mt_rand(RAZMER_MIN, RAZMER_MAX);
    $simvol = $_SESSION['kod'][$i];
    imagettftext($kartinka, $razmer, 0, $x + 1, $y + 1, $svet, SHRIFT, $simvol);
    imagettftext($kartinka, $razmer, 0, $x, $y, $tcvet, SHRIFT, $simvol);
}

header('Content-Type: image/jpeg');
header('Cache-Control: no-store, no-cache, must-revalidate');
imagejpeg($kartinka);
imagedestroy($kartinka);
