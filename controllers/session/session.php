<?php
class Session extends Controller
{

    public static function init()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
    public static function set($key,$value)
    {
        $_SESSION[$key]=$value;
    }
    public static function get($key)
    {
        if (isset($_SESSION[$key]))
        {
            return $_SESSION[$key];
        }
        else
        {
            return false;
        }
    }
    public static function destroy()
    {
        Session::set('loggedIn',NULL);
        session_destroy();
    }

}