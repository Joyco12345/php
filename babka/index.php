<?php
session_start();

const POCA = 'ПОКА!';
const GROMCHE = 'АСЬ?! ГОВОРИ ГРОМЧЕ, ВНУЧЕК!';
const PROSHCHANIE = 'ДО СВИДАНИЯ, МИЛЫЙ!';
const TRI = 3;

if (isset($_GET['versiya'])) {
    $_SESSION['versiya'] = (int) $_GET['versiya'] === 2 ? 2 : 1;
    $_SESSION['dialog'] = [];
    $_SESSION['schetchik'] = 0;
    $_SESSION['zaversheno'] = false;
}
if (!isset($_SESSION['versiya'])) {
    $_SESSION['versiya'] = 1;
    $_SESSION['dialog'] = [];
    $_SESSION['schetchik'] = 0;
    $_SESSION['zaversheno'] = false;
}
if (isset($_GET['sbrose'])) {
    $_SESSION['dialog'] = [];
    $_SESSION['schetchik'] = 0;
    $_SESSION['zaversheno'] = false;
}
if (!isset($_SESSION['dialog'])) {
    $_SESSION['dialog'] = [];
}
if (!isset($_SESSION['schetchik'])) {
    $_SESSION['schetchik'] = 0;
}
if (!isset($_SESSION['zaversheno'])) {
    $_SESSION['zaversheno'] = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$_SESSION['zaversheno']) {
    $fraza = trim(strip_tags((string) ($_POST['fraza'] ?? '')));
    $verh = mb_strtoupper($fraza, 'UTF-8');
    $otvet = '';

    if ($verh === POCA) {
        if ($_SESSION['versiya'] === 2) {
            $_SESSION['schetchik'] = $_SESSION['schetchik'] + 1;
            if ($_SESSION['schetchik'] >= TRI) {
                $otvet = PROSHCHANIE;
                $_SESSION['zaversheno'] = true;
            }
        } else {
            $otvet = PROSHCHANIE;
            $_SESSION['zaversheno'] = true;
        }
        if ($otvet === '') {
            $god = mt_rand(1930, 1950);
            $otvet = "НЕТ, НИ РАЗУ С {$god} ГОДА!";
        }
    } else {
        if ($_SESSION['versiya'] === 2) {
            $_SESSION['schetchik'] = 0;
        }
        if (mb_substr($fraza, -1, 1, 'UTF-8') === '!') {
            $god = mt_rand(1930, 1950);
            $otvet = "НЕТ, НИ РАЗУ С {$god} ГОДА!";
        } else {
            $otvet = GROMCHE;
        }
    }

    if ($fraza !== '') {
        $_SESSION['dialog'][] = ['fraza' => $fraza, 'otvet' => $otvet];
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Глухая бабушка</title>
<style>
:root { --temny: #1d2d44; --goluboy: #2f6fb0; --seryi: #6b7a8d; --granitsa: #dfe6ef; --svetly: #f4f6fa; }
* { box-sizing: border-box; }
body { margin: 0; min-height: 100vh; font-family: 'Segoe UI', Arial, sans-serif; color: var(--temny); background: linear-gradient(135deg, #f8fafc, #e3ecf5); }
.shapka { padding: 16px 32px; color: #fff; background: linear-gradient(110deg, #162132, #24476f); }
.nazvanie-shapki { color: #fff; font-size: 20px; font-weight: 700; text-decoration: none; }
.obshem { max-width: 820px; margin: 0 auto; padding: 30px 20px 60px; }
.kartochka { padding: 26px; border: 1px solid var(--granitsa); border-radius: 16px; background: #fff; box-shadow: 0 10px 30px rgba(29,45,68,.10); }
h1 { margin-top: 0; font-size: 28px; }
.podzagolovok { color: var(--seryi); margin-top: -8px; }
.versii { display: flex; gap: 8px; margin: 20px 0; }
.versii a { padding: 8px 14px; border-radius: 999px; background: var(--svetly); color: var(--goluboy); text-decoration: none; font-size: 14px; }
.versii a.aktivnaya { background: var(--goluboy); color: #fff; }
.dialog { display: grid; gap: 12px; margin: 22px 0; }
.replika { padding: 12px 16px; border-radius: 12px; background: var(--svetly); }
.replika b { color: var(--seryi); font-size: 13px; display: block; margin-bottom: 4px; }
.otvet { background: #e8f1fb; }
form { display: flex; gap: 10px; flex-wrap: wrap; }
input { flex: 1 1 260px; padding: 11px 13px; border: 1px solid var(--granitsa); border-radius: 10px; font: inherit; }
.knopka { padding: 11px 20px; border: 0; border-radius: 10px; background: var(--goluboy); color: #fff; font: inherit; font-weight: 600; cursor: pointer; }
.schetchik { color: var(--seryi); font-size: 13px; }
</style>
</head>
<body>
<header class="shapka"><a class="nazvanie-shapki" href="/">Глухая бабушка</a></header>
<main class="obshem">
<section class="kartochka">
<h1>Глухая бабушка</h1>
<p class="podzagolovok">Версия <?php echo $_SESSION['versiya']; ?><?php if ($_SESSION['versiya'] === 2): ?> выход после трёх ПОКА! подряд<?php endif; ?></p>
<div class="versii">
<a href="?versiya=1" class="<?php echo $_SESSION['versiya'] === 1 ? 'aktivnaya' : ''; ?>">Версия 1</a>
<a href="?versiya=2" class="<?php echo $_SESSION['versiya'] === 2 ? 'aktivnaya' : ''; ?>">Версия 2</a>
<a href="?sbrose=1">Начать заново</a>
</div>
<div class="dialog">
<?php foreach ($_SESSION['dialog'] as $replika): ?>
<div class="replika"><b>Вы</b><?php echo htmlspecialchars($replika['fraza'], ENT_QUOTES, 'UTF-8'); ?></div>
<div class="replika otvet"><b>Бабушка</b><?php echo htmlspecialchars($replika['otvet'], ENT_QUOTES, 'UTF-8'); ?></div>
<?php endforeach; ?>
</div>
<?php if ($_SESSION['versiya'] === 2): ?>
<p class="schetchik">Подряд крикнуто ПОКА!: <?php echo $_SESSION['schetchik']; ?> из 3</p>
<?php endif; ?>
<?php if ($_SESSION['zaversheno']): ?>
<p class="schetchik">Разговор завершён. Нажмите "Начать заново", чтобы продолжить.</p>
<?php else: ?>
<form method="post" action="/">
<input type="text" name="fraza" autocomplete="off" autofocus>
<button class="knopka" type="submit">Сказать</button>
</form>
<?php endif; ?>
</section>
</main>
</body>
</html>
