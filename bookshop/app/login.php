<?php
$polzovatel = new User(
    Cleaner::str($_POST['login'] ?? ''),
    Cleaner::str($_POST['password'] ?? '')
);
if (Eshop::userCheck($polzovatel)) {
    Eshop::logIn();
    header('Location: /admin');
    exit;
}
?>
<section class="kartochka tsentr">
<h1>Неверный логин или пароль</h1>
<p class="soob soob-oshibka">Проверьте введённые данные и попробуйте снова.</p>
<div class="deistviya">
<a class="knopka" href="/enter">Попробовать снова</a>
</div>
</section>
