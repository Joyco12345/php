<?php
$zakaz = new Order(
    Cleaner::str($_POST['customer'] ?? ''),
    Cleaner::str($_POST['email'] ?? ''),
    Cleaner::str($_POST['phone'] ?? ''),
    Cleaner::str($_POST['address'] ?? '')
);
Eshop::saveOrder($zakaz);
?>
<section class="kartochka tsentr">
<h1>Заказ принят</h1>
<p class="soob soob-ushpeh">Спасибо, <?php echo htmlspecialchars($zakaz->customer, ENT_QUOTES, 'UTF-8'); ?>! Ваш заказ оформлен.</p>
<p>Номер заказа: <span class="kod"><?php echo htmlspecialchars($zakaz->order_id, ENT_QUOTES, 'UTF-8'); ?></span></p>
<div class="deistviya">
<a class="knopka" href="/catalog">Вернуться в каталог</a>
</div>
</section>
