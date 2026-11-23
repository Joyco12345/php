<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Книжный магазин</title>
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header class="shapka">
<a class="nazvanie-shapki" href="/catalog">Книжный магазин</a>
<nav class="navigatsiya">
<a href="/catalog">Каталог</a>
<a href="/basket">Корзина</a>
<?php if (Eshop::isAdmin()): ?>
<a href="/admin">Админка</a>
<a href="/admin/logout">Выйти</a>
<?php endif; ?>
<a href="/tasks">Все задания</a>
</nav>
</header>
<main class="obshem">
