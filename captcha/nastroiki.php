<?php
const ALFAVIT = 'abcdefghjkmnpqrstuvwxyz23456789';
const DLINA = 5;
const SHAG = 40;
const RAZMER_MIN = 20;
const RAZMER_MAX = 28;
const SHRIFT = 'C:/Windows/Fonts/arial.ttf';
const PREDEL_POPYTOK = 3;

function novyi_kod() {
    if (isset($_SESSION['kod'])) {
        $_SESSION['pred_kod'] = $_SESSION['kod'];
    }
    $kod = '';
    for ($i = 0; $i < DLINA; $i++) {
        $kod .= ALFAVIT[mt_rand(0, strlen(ALFAVIT) - 1)];
    }
    $_SESSION['kod'] = $kod;
}
