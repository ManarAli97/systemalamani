<?php

class g extends Controller
{

    function __construct()
    {
        parent::__construct();
        $this->table = 'games';


    }

    function index()
    {

        $cookie_name = "g_active";
        $cookie_value = 1;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

        if (isset($_COOKIE['g_active']))
        {
            if ($this->handleLogin()) {

                header("Location:" . url . "/games/disk?g=1");
            }
        }else
        {
            header("Location:" . url . "/login/user?g=1"); // games category disk

        }


    }

}