# Интернет-магазин книг (Eshop)

Каталог книг, корзина в cookie, оформление заказов и админка.

## Состав

- `core/eshop.sql` структура базы, хранимые процедуры и начальные данные.
- `core/init.php` настройки подключения, автозагрузка классов, сессия и проверка входа.
- `core/Eshop.class.php` работа с базой, корзиной, заказами и пользователями.
- `core/Book.class.php`, `Order.class.php`, `User.class.php`, `Basket.class.php`, `Cleaner.class.php` классы проекта.
- `app/` страницы сайта и админки, `app/__router.php` маршрутизация.
- `css/style.css` оформление.

## Запуск

1. Импортируйте `core/eshop.sql` в MySQL:
   `mysql --default-character-set=utf8mb4 -u root -p < core/eshop.sql`
2. В `core/init.php` задайте свои параметры подключения в массиве `DB`.
3. Откройте сайт через встроенный сервер PHP:
   `php -S 127.0.0.1:8000 -t .`
4. Войдите в админку: логин `admin`, пароль `admin`.

Хранимые процедуры: `spAddItemToCatalog`, `spGetCatalog`, `spGetItemsForBasket`, `spSaveOrder`, `spSaveOrderedItems`, `spGetOrders`, `spGetOrderedItems`, `spSaveAdmin`, `spGetAdmin`.

Корзина хранится в cookie `eshop` в виде JSON с фиксированным ключом `order-id` и идентификаторами товаров.
