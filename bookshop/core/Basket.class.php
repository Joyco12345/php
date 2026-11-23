<?php
class Basket {
    public static $korzina = [];

    public static function init() {
        if (isset($_COOKIE['eshop'])) {
            self::read();
        } else {
            self::create();
        }
    }

    public static function create() {
        self::$korzina = ['order-id' => uniqid('', true)];
        self::save();
    }

    public static function read() {
        $razobrannoe = json_decode((string) $_COOKIE['eshop'], true);
        if (!is_array($razobrannoe) || !isset($razobrannoe['order-id'])) {
            self::create();
            return;
        }
        self::$korzina = $razobrannoe;
    }

    public static function save() {
        setcookie('eshop', json_encode(self::$korzina), time() + 86400 * 30, '/');
    }

    public static function add($id_tovara, $kolichestvo = 1) {
        $id_tovara = (int) $id_tovara;
        if ($id_tovara <= 0) {
            return;
        }
        if (!isset(self::$korzina[$id_tovara])) {
            self::$korzina[$id_tovara] = 0;
        }
        self::$korzina[$id_tovara] += max(1, (int) $kolichestvo);
        self::save();
    }

    public static function remove($id_tovara) {
        unset(self::$korzina[(int) $id_tovara]);
        self::save();
    }

    public static function clear() {
        self::$korzina = ['order-id' => uniqid('', true)];
        self::save();
    }
}
