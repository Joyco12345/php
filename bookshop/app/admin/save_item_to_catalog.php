<?php
$kniga = new Book(
    Cleaner::str($_POST['title'] ?? ''),
    Cleaner::str($_POST['author'] ?? ''),
    Cleaner::uint($_POST['price'] ?? 0),
    Cleaner::uint($_POST['pubyear'] ?? 0)
);
if (Eshop::addItemToCatalog($kniga)) {
    header('Location: /admin/add_item_to_catalog');
    exit;
}
?>
<section class="kartochka tsentr">
<h1>Не удалось добавить товар</h1>
<p class="soob soob-oshibka">Проверьте данные формы и попробуйте снова.</p>
<a class="knopka" href="/admin/add_item_to_catalog">Назад к форме</a>
</section>
