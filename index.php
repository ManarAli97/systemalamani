<?php

date_default_timezone_set('Asia/baghdad');

    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
                if (strpos($name, 'xcolx_') !== false) {
                setcookie($name, '', time()-1000);
                setcookie($name, '', time()-1000, '/');
            }

        }
    }


    require 'config.php';
    // use an autoloader
    // Also spl__autoloader_register (take a look at  it if you like)
    spl_autoload_register(function ( $class_name) {

        if (file_exists(LIBS.$class_name.'.php'))
        {
            require LIBS.$class_name.'.php';
        }elseif(file_exists('controllers/'.strtolower($class_name).'/'.strtolower($class_name).'.php'))
        {
            require 'controllers/'.strtolower($class_name).'/'.strtolower($class_name).'.php';

        }

    });

    $bootstrap= new Bootstrap();
    $bootstrap->init();

 ?>