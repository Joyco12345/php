<?php
class User {
    public $id;
    public $login;
    public $password;
    public $email;
    public $created;

    public function __construct($login = '', $password = '', $email = '', $id = 0, $sozdan = '') {
        $this->login = (string) $login;
        $this->password = (string) $password;
        $this->email = (string) $email;
        $this->id = (int) $id;
        $this->created = (string) $sozdan;
    }
}
