<?php
class Order {
    public $id;
    public $order_id;
    public $customer;
    public $email;
    public $phone;
    public $address;
    public $created;
    public $items;

    public function __construct($zakazchik = '', $pochta = '', $telefon = '', $adres = '', $id = 0, $sozdan = '', $tovary = [], $order_id = '') {
        $this->customer = (string) $zakazchik;
        $this->email = (string) $pochta;
        $this->phone = (string) $telefon;
        $this->address = (string) $adres;
        $this->id = (int) $id;
        $this->created = (string) $sozdan;
        $this->items = (array) $tovary;
        $this->order_id = (string) $order_id;
    }
}
