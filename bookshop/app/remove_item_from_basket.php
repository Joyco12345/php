<?php
$id_tovara = Cleaner::uint($_GET['id'] ?? 0);
Eshop::removeItemFromBasket($id_tovara);
header('Location: /basket');
exit;
