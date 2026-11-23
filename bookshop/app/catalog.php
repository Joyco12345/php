<?php
$knigi = [];
foreach (Eshop::getItemsFromCatalog() as $kniga) {
    $knigi[] = $kniga;
}
?>
<section class="kartochka">
<h1>Каталог товаров</h1>
<p class="podzagolovok">Выберите книгу и добавьте её в корзину</p>
<p>Товаров в <a href="/basket">корзине</a>: <b><?php echo count(Basket::$korzina) - 1; ?></b></p>
<div class="tablica">
<table>
<thead>
<tr>
<th>Название</th>
<th>Автор</th>
<th>Год издания</th>
<th>Цена, руб.</th>
<th>В корзину</th>
</tr>
</thead>
<tbody>
<?php foreach ($knigi as $kniga): ?>
<tr>
<td class="nazvanie"><?php echo htmlspecialchars($kniga->title, ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($kniga->author, ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo $kniga->pubyear; ?></td>
<td class="tsena"><?php echo $kniga->price; ?></td>
<td><a class="knopka knopka-legkaya" href="/add_item_to_basket?id=<?php echo $kniga->id; ?>">В корзину</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</section>
