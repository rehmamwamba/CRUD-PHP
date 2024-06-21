<?php

namespace App;

class Session
{
    public static function start()
    {
        session_start();
    }

    public static function setFlash($type, $message)
    {
        $_SESSION['flash'][$type] = $message;
    }

    public static function getFlash($type)
    {
        $message = $_SESSION['flash'][$type] ?? null;
        unset($_SESSION['flash'][$type]);
        return $message;
    }
}
?>
