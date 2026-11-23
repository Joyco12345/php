<?php
$vse_zakazy = [];
foreach (Eshop::getOrders() as $zakaz) {
    $stroki_zakaza = [];
    $itogo_zakaza = 0;
    foreach (Eshop::getOrderedItems($zakaz->order_id) as $element) {
        $kniga = $element['kniga'];
        $kolichestvo = $element['kolichestvo'];
        $stroki_zakaza[] = [$kniga, $kolichestvo];
        $itogo_zakaza += $kniga->price * $kolichestvo;
    }
    $vse_zakazy[] = ['zakaz' => $zakaz, 'stroki' => $stroki_zakaza, 'itogo' => $itogo_zakaza];
}
?>
<section class="kartochka">
<h1>Поступившие заказы</h1>
<p class="podzagolovok"><a href="/admin">Назад в админку</a></p>
<?php if (count($vse_zakazy) === 0): ?>
<p class="pustoj">Заказов пока нет.</p>
<?php endif; ?>
<?php foreach ($vse_zakazy as $zapros): ?>
<?php $zakaz = $zapros['zakaz']; ?>
<article class="zakaz">
<h2>Заказ номер: <span class="kod"><?php echo htmlspecialchars($zakaz->order_id, ENT_QUOTES, 'UTF-8'); ?></span></h2>
<div class="pola">
<p><b>Заказчик:</b> <?php echo htmlspecialchars($zakaz->customer, ENT_QUOTES, 'UTF-8'); ?></p>
<p><b>Email:</b> <?php echo htmlspecialchars($zakaz->email, ENT_QUOTES, 'UTF-8'); ?></p>
<p><b>Телефон:</b> <?php echo htmlspecialchars($zakaz->phone, ENT_QUOTES, 'UTF-8'); ?></p>
<p><b>Адрес доставки:</b> <?php echo htmlspecialchars($zakaz->address, ENT_QUOTES, 'UTF-8'); ?></p>
<p><b>Дата размещения:</b> <?php echo htmlspecialchars($zakaz->created, ENT_QUOTES, 'UTF-8'); ?></p>
</div>
<h3>Купленные товары</h3>
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
</tr>
</thead>
<tbody>
<?php foreach ($zapros['stroki'] as $nom => $stroka): ?>
<?php $kniga = $stroka[0]; ?>
<tr>
<td><?php echo $nom + 1; ?></td>
<td class="nazvanie"><?php echo htmlspecialchars($kniga->title, ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($kniga->author, ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo $kniga->pubyear; ?></td>
<td class="tsena"><?php echo $kniga->price; ?></td>
<td><?php echo $stroka[1]; ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<div class="itogo">Всего товаров в заказе на сумму: <?php echo $zapros['itogo']; ?> руб.</div>
</article>
<?php endforeach; ?>
</section>
