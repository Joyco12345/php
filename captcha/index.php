<?php
session_start();
require 'nastroiki.php';

if (!isset($_SESSION['kod'])) {
    novyi_kod();
}
if (!isset($_SESSION['popytki'])) {
    $_SESSION['popytki'] = 0;
}

if (isset($_GET['zaznovo'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}
if (isset($_GET['obnovit'])) {
    novyi_kod();
}

$otvet = '';
$zakryto = $_SESSION['popytki'] >= PREDEL_POPYTOK;

if ($zakryto && $_SERVER['REQUEST_METHOD'] === 'POST' && $otvet === '') {
    $otvet = 'ПОПЫТКИ ЗАКОНЧИЛИСЬ. НАЖМИТЕ НАЧАТЬ ЗАНОВО';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$zakryto) {
    $vvod = preg_replace('/\s+/u', '', trim((string) ($_POST['kod'] ?? '')));
    $podhodyashche = strcasecmp($vvod, $_SESSION['kod']) === 0;
    if (!$podhodyashche && !empty($_SESSION['pred_kod'])) {
        $podhodyashche = strcasecmp($vvod, $_SESSION['pred_kod']) === 0;
    }
    if ($podhodyashche) {
        $otvet = 'ПРАВИЛЬНО';
        $_SESSION['uspeh'] = true;
        $_SESSION['popytki'] = 0;
        novyi_kod();
    } else {
        $_SESSION['uspeh'] = false;
        $_SESSION['popytki'] = $_SESSION['popytki'] + 1;
        novyi_kod();
        if ($_SESSION['popytki'] >= PREDEL_POPYTOK) {
            $otvet = 'НЕПРАВИЛЬНО. ПОПЫТКИ ЗАКОНЧИЛИСЬ';
            $zakryto = true;
        } else {
            $otvet = 'НЕПРАВИЛЬНО';
        }
    }
} elseif (!empty($_SESSION['uspeh'])) {
    $otvet = 'ПРАВИЛЬНО';
}
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Капча</title>
<style>
body { margin: 0; min-height: 100vh; font-family: 'Segoe UI', Arial, sans-serif; color: #1d2d44; background: linear-gradient(135deg, #f8fafc, #e3ecf5); }
.blok { max-width: 420px; margin: 60px auto; padding: 26px; border: 1px solid #dfe6ef; border-radius: 16px; background: #fff; box-shadow: 0 10px 30px rgba(29,45,68,.10); }
h1 { margin-top: 0; font-size: 26px; }
.kartinka { display: block; margin-bottom: 12px; }
.otvet { margin: 12px 0; font-weight: 700; }
.otvet-uspeh { color: #186646; }
.otvet-oshibka { color: #b4362c; }
.popytki { color: #6b7a8d; font-size: 13px; }
input { padding: 10px 12px; border: 1px solid #dfe6ef; border-radius: 10px; font: inherit; }
.knopka { padding: 10px 18px; border: 0; border-radius: 10px; background: #2f6fb0; color: #fff; font: inherit; font-weight: 600; cursor: pointer; }
</style>
</head>
<body>
<div class="blok">
<h1>Регистрация</h1>
<img class="kartinka" src="captcha.php" alt="Капча">
<?php
$klass_otveta = '';
if ($otvet === 'ПРАВИЛЬНО') {
    $klass_otveta = 'otvet-uspeh';
} elseif (strpos($otvet, 'НЕПРАВИЛЬНО') === 0) {
    $klass_otveta = 'otvet-oshibka';
}
?>
<?php if ($otvet !== ''): ?>
<p class="otvet <?php echo $klass_otveta; ?>"><?php echo $otvet; ?></p>
<?php endif; ?>
<p class="popytki">Попыток: <?php echo $_SESSION['popytki']; ?> из <?php echo PREDEL_POPYTOK; ?></p>
<?php if (!$zakryto): ?>
<form method="post" autocomplete="off">
<label>Введите строку <input type="text" name="kod"></label>
<button class="knopka" type="submit">ОК</button>
</form>
<p><a href="?obnovit">Обновить картинку</a></p>
<?php else: ?>
<p><a href="?zaznovo">Начать заново</a></p>
<?php endif; ?>
</div>
</body>
</html>
