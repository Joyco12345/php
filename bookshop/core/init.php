<?php
const YADRO_DIR = 'core/';
const PRILOZH_DIR = 'app/';
const ADMIN_DIR = PRILOZH_DIR . 'admin/';
const OSHIBKA_LOG = ADMIN_DIR . 'error.log';
const OSHIBKA_SOOB = 'Срочно обратитесь к администратору! admin@email.info';

set_include_path(get_include_path() . PATH_SEPARATOR . YADRO_DIR . PATH_SEPARATOR . PRILOZH_DIR . PATH_SEPARATOR . ADMIN_DIR);
spl_autoload_extensions('.class.php');
spl_autoload_register();

function zapisat_oshibku($soob, $fayl, $stroka) {
    $data = date('d-m-Y H:i:s');
    error_log("$data - $soob in $fayl:$stroka\n", 3, OSHIBKA_LOG);
    echo OSHIBKA_SOOB;
}

function obrarabotchik_oshibok($nom, $soob, $fayl, $stroka) {
    zapisat_oshibku($soob, $fayl, $stroka);
}

function obrarabotchik_isklyucheniy($e) {
    zapisat_oshibku($e->getMessage(), $e->getFile(), $e->getLine());
}

set_error_handler('obrarabotchik_oshibok');
set_exception_handler('obrarabotchik_isklyucheniy');

const DB = [
    'HOST' => '127.0.0.1',
    'PORT' => '3307',
    'USER' => 'root',
    'PASS' => '',
    'NAME' => 'eshop',
];

session_start();

$put = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (!isset($_SESSION['admin']) && !in_array($put, ['/enter', '/login', '/tasks'], true)) {
    header('Location: /enter');
    exit;
}

Eshop::init(DB);
Basket::init();
