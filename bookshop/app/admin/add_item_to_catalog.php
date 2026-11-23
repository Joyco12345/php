<section class="kartochka tsentr">
<h1>Добавить товар в каталог</h1>
<p class="podzagolovok"><a href="/admin">Назад в админку</a></p>
<form class="forma" action="save_item_to_catalog" method="post">
    <div>
        <label>Название:</label>
        <input type="text" name="title" size="50" required>
    </div>
    <div>
        <label>Автор:</label>
        <input type="text" name="author" size="50" required>
    </div>
    <div>
        <label>Год издания:</label>
        <input type="text" name="pubyear" size="50" maxlength="4" required>
    </div>
    <div>
        <label>Цена (руб.):</label>
        <input type="text" name="price" size="50" maxlength="6" required>
    </div>
    <div>
        <input class="knopka" type="submit" value="Добавить">
    </div>
</form>
</section>
