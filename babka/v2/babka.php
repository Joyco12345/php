<?php
const POCA = 'ПОКА!';
const GROMCHE = 'АСЬ?! ГОВОРИ ГРОМЧЕ, ВНУЧЕК!';
const PROSHCHANIE = 'ДО СВИДАНИЯ, МИЛЫЙ!';
const TRI = 3;

$schetchik = 0;

while (true) {
    $stroka = fgets(STDIN);
    if ($stroka === false) {
        break;
    }

    $vvod = trim($stroka);
    $verh = mb_strtoupper($vvod, 'UTF-8');

    if ($verh === POCA) {
        $schetchik = $schetchik + 1;
        if ($schetchik === TRI) {
            echo PROSHCHANIE . PHP_EOL;
            break;
        }
    } else {
        $schetchik = 0;
    }

    if (mb_substr($vvod, -1, 1, 'UTF-8') === '!') {
        $god = mt_rand(1930, 1950);
        echo "НЕТ, НИ РАЗУ С {$god} ГОДА!" . PHP_EOL;
    } else {
        echo GROMCHE . PHP_EOL;
    }
}
