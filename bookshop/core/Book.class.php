<?php
class Book {
    public $id;
    public $title;
    public $author;
    public $price;
    public $pubyear;

    public function __construct($nazvanie = '', $avtor = '', $tsena = 0, $god = 0, $id = 0) {
        $this->title = (string) $nazvanie;
        $this->author = (string) $avtor;
        $this->price = (float) $tsena;
        $this->pubyear = (int) $god;
        $this->id = (int) $id;
    }
}
