<?php
$id_tovara = Cleaner::uint($_GET['id'] ?? 0);
Eshop::addItemToBasket($id_tovara);
header('Location: /catalog');
exit;
