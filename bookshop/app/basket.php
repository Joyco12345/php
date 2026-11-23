<?php
$stroki_korziny = [];
$itogo = 0;
foreach (Eshop::getItemsFromBasket() as $element) {
    $kniga = $element['kniga'];
    $kolichestvo = $element['kolichestvo'];
    $stroki_korziny[] = [$kniga, $kolichestvo];
    $itogo += $kniga->price * $kolichestvo;
}
?>
<section class="kartochka">
<h1>Ваша корзина</h1>
<p class="podzagolovok"><a href="/catalog">Вернуться в каталог</a></p>
<?php if (count($stroki_korziny) === 0): ?>
<p class="pustoj">Корзина пока пуста. Загляните в каталог и выберите книгу.</p>
<?php else: ?>
<div class="tablica">
<table>
<thead>
<tr>
<th>N п/п</th>
<th>Название</th>
<th>Автор</th>
<th>Год издания</th>
<th>Цена, руб.</th>
<th>Количество</th>
<th>Удалить</th>
</tr>
</thead>
<tbody>
<?php foreach ($stroki_korziny as $nom => $stroka): ?>
<?php $kniga = $stroka[0]; ?>
<tr>
<td><?php echo $nom + 1; ?></td>
<td class="nazvanie"><?php echo htmlspecialchars($kniga->title, ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($kniga->author, ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo $kniga->pubyear; ?></td>
<td class="tsena"><?php echo $kniga->price; ?></td>
<td><?php echo $stroka[1]; ?></td>
<td><a class="knopka knopka-opasnaya" href="/remove_item_from_basket?id=<?php echo $kniga->id; ?>">Удалить</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<div class="itogo">Всего товаров в корзине на сумму: <?php echo $itogo; ?> руб.</div>
<div class="deistviya">
<a class="knopka" href="/create_order">Оформить заказ!</a>
<a class="knopka knopka-legkaya" href="/catalog">Продолжить покупки</a>
</div>
<?php endif; ?>
</section>
