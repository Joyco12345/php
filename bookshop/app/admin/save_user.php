<?php
$polzovatel = new User(
    Cleaner::str($_POST['login'] ?? ''),
    Eshop::createHash(Cleaner::str($_POST['password'] ?? '')),
    Cleaner::str($_POST['email'] ?? '')
);
if (Eshop::userAdd($polzovatel)) {
    header('Location: /admin/create_user');
    exit;
}
?>
<section class="kartochka tsentr">
<h1>Не удалось добавить пользователя</h1>
<p class="soob soob-oshibka">Возможно, такой логин уже занят.</p>
<a class="knopka" href="/admin/create_user">Назад к форме</a>
</section>
