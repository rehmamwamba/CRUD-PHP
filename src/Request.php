<?php
namespace App;

class Request {
    public static function get($name, $default = null) {
        return $_GET[$name] ?? $default;
    }

    public static function post($name, $default = null) {
        return $_POST[$name] ?? $default;
    }
}
