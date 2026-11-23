<section class="kartochka tsentr">
<h1>Добавить пользователя</h1>
<p class="podzagolovok"><a href="/admin">Назад в админку</a></p>
<form class="forma forma-uzkaya" action="save_user" method="post">
    <div>
        <label>Логин:</label>
        <input type="text" name="login" size="25" required>
    </div>
    <div>
        <label>Пароль:</label>
        <input type="password" name="password" size="25" required>
    </div>
    <div>
        <label>Email:</label>
        <input type="email" name="email" size="25" required>
    </div>
    <div>
        <input class="knopka" type="submit" value="Создать">
    </div>
</form>
</section>
