<?php
class Eshop {
    private static $bd;

    public static function init(array $nastroiki) {
        $dsn = 'mysql:host=' . $nastroiki['HOST'] . ';port=' . $nastroiki['PORT'] . ';dbname=' . $nastroiki['NAME'] . ';charset=utf8mb4';
        self::$bd = new PDO($dsn, $nastroiki['USER'], $nastroiki['PASS'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }

    public static function addItemToCatalog(Book $kniga) {
        $zapros = self::$bd->prepare('CALL spAddItemToCatalog(?, ?, ?, ?)');
        return $zapros->execute([$kniga->title, $kniga->author, $kniga->price, $kniga->pubyear]);
    }

    public static function getItemsFromCatalog() {
        $zapros = self::$bd->query('CALL spGetCatalog()');
        $strok = $zapros->fetchAll();
        $zapros->closeCursor();
        foreach ($strok as $stroka) {
            yield new Book($stroka['title'], $stroka['author'], $stroka['price'], $stroka['pubyear'], $stroka['id']);
        }
    }

    public static function addItemToBasket($id_tovara, $kolichestvo = 1) {
        Basket::add($id_tovara, $kolichestvo);
    }

    public static function removeItemFromBasket($id_tovara) {
        Basket::remove($id_tovara);
    }

    public static function getItemsFromBasket() {
        $id_tovary = [];
        foreach (Basket::$korzina as $klyuch => $znachenie) {
            if ($klyuch !== 'order-id') {
                $id_tovary[] = (int) $klyuch;
            }
        }
        if (count($id_tovary) === 0) {
            return;
        }
        $spisok = implode(',', $id_tovary);
        $zapros = self::$bd->prepare('CALL spGetItemsForBasket(?)');
        $zapros->execute([$spisok]);
        $strok = $zapros->fetchAll();
        $zapros->closeCursor();
        foreach ($strok as $stroka) {
            $kniga = new Book($stroka['title'], $stroka['author'], $stroka['price'], $stroka['pubyear'], $stroka['id']);
            yield ['kniga' => $kniga, 'kolichestvo' => (int) Basket::$korzina[$stroka['id']]];
        }
    }

    public static function saveOrder(Order $zakaz) {
        if ($zakaz->order_id === '') {
            $zakaz->order_id = Basket::$korzina['order-id'] ?? uniqid('', true);
        }
        $zapros = self::$bd->prepare('CALL spSaveOrder(?, ?, ?, ?, ?)');
        $uspeh = $zapros->execute([$zakaz->order_id, $zakaz->customer, $zakaz->email, $zakaz->phone, $zakaz->address]);

        $id_tovary = [];
        $kolichestva = [];
        foreach (Basket::$korzina as $klyuch => $znachenie) {
            if ($klyuch !== 'order-id') {
                $id_tovary[] = (int) $klyuch;
                $kolichestva[] = (int) $znachenie;
            }
        }
        if (count($id_tovary) > 0) {
            $zapros_tovarov = self::$bd->prepare('CALL spSaveOrderedItems(?, ?, ?)');
            $zapros_tovarov->execute([$zakaz->order_id, implode(',', $id_tovary), implode(',', $kolichestva)]);
            $zapros_tovarov->closeCursor();
        }
        Basket::clear();
        return $uspeh;
    }

    public static function getOrders() {
        $zapros = self::$bd->query('CALL spGetOrders()');
        $strok = $zapros->fetchAll();
        $zapros->closeCursor();
        foreach ($strok as $stroka) {
            yield new Order(
                $stroka['customer'],
                $stroka['email'],
                $stroka['phone'],
                $stroka['address'],
                $stroka['id'],
                $stroka['created'],
                [],
                $stroka['order_id']
            );
        }
    }

    public static function getOrderedItems($order_id) {
        $zapros = self::$bd->prepare('CALL spGetOrderedItems(?)');
        $zapros->execute([$order_id]);
        $strok = $zapros->fetchAll();
        $zapros->closeCursor();
        foreach ($strok as $stroka) {
            $kniga = new Book($stroka['title'], $stroka['author'], $stroka['price'], $stroka['pubyear'], $stroka['id']);
            yield ['kniga' => $kniga, 'kolichestvo' => (int) $stroka['quantity']];
        }
    }

    public static function userAdd(User $polzovatel) {
        $zapros = self::$bd->prepare('CALL spSaveAdmin(?, ?, ?)');
        return $zapros->execute([$polzovatel->login, $polzovatel->password, $polzovatel->email]);
    }

    public static function userCheck(User $polzovatel): bool {
        $nayden = self::userGet($polzovatel);
        return $nayden->id > 0 && password_verify($polzovatel->password, $nayden->password);
    }

    public static function userGet(User $polzovatel): User {
        $zapros = self::$bd->prepare('CALL spGetAdmin(?)');
        $zapros->execute([$polzovatel->login]);
        $stroka = $zapros->fetch();
        $zapros->closeCursor();
        if (!$stroka) {
            return new User();
        }
        return new User($stroka['login'], $stroka['password'], $stroka['email'], $stroka['id'], $stroka['created']);
    }

    public static function createHash(string $password): string {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function isAdmin(): bool {
        return isset($_SESSION['admin']);
    }

    public static function logIn() {
        $_SESSION['admin'] = true;
    }

    public static function logOut() {
        unset($_SESSION['admin']);
        session_destroy();
        header('Location: /enter');
        exit;
    }
}
