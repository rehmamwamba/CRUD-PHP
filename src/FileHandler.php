<?php
namespace App;

class FileHandler {
    private $filename;

    public function __construct($filename) {
        $this->filename = $filename;
    }

    public function readContacts() {
        if (file_exists($this->filename)) {
            $data = file_get_contents($this->filename);
            return json_decode($data, true);
        } else {
            return [];
        }
    }

    public function writeContacts($contacts) {
        $data = json_encode($contacts, JSON_PRETTY_PRINT);
        file_put_contents($this->filename, $data);
    }
}
