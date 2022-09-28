<?php

class Install extends Controller
{

    function __construct()
    {
        parent::__construct();
        header('Content-Type:text/html');
    }

    function index()
    {
        $table = array();
        $dir = new DirectoryIterator('controllers');
        foreach ($dir as $fileinfo) {
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                $class_name = ucwords($fileinfo->getFilename());
                if (class_exists($class_name)) {
                    $call_class = new $class_name();
                    if (method_exists($call_class, 'createTB')) {
                        $table = $call_class->createTB();
                        $this->resultTable($table, $fileinfo->getFilename());
                    }
                }
            }

        }

        $this->close_install();
    }

    public function close_install()
    {
        $this->msg('ثم تنصيب قاعة البيانات بنجاح');

//        if (Session::get('userid')) {
//            $this->msg(' سيتم تحويلك بعد 5 ثواني');
//            $this->lightRedirect(url, 5000);
//        } else {
//            $this->msg('سيتم تحويلك بعد 5 ثواني');;
//            $this->lightRedirect(url . '/login', 5000);
//        }

    }

    public function resultTable($table = array(), $modules = null)
    {

        require 'html/index.php';

    }


    public function msg($message)
    {

        echo "<div class='show' style='
    min-width: 250px; 
    margin-left: -125px;
    background-color: #fc273b; 
    color: #fff;
    text-align: center; 
    border-radius: 2px;
    padding: 16px;
    position: fixed;
    z-index: 1;
    left: 50%;
    bottom: 30px;
    '>$message</div>";
    }


}

