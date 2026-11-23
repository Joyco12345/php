<section class="kartochka tsentr">
<h1>Оформление заказа</h1>
<p class="podzagolovok"><a href="/catalog">Вернуться в каталог</a></p>
<form class="forma" action="save_order" method="post">
    <div>
        <label>Заказчик:</label>
        <input type="text" name="customer" size="50" required />
    </div>
    <div>
        <label>Email заказчика:</label>
        <input type="email" name="email" size="50" required />
    </div>
    <div>
        <label>Телефон для связи:</label>
        <input type="phone" name="phone" size="50" required />
    </div>
    <div>
        <label>Адрес доставки:</label>
        <input type="text" name="address" size="50" required />
    </div>
    <div>
        <input class="knopka" type="submit" value="Заказать" />
    </div>
</form>
</section>
