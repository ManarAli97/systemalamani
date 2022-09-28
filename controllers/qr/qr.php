<?php

class qr extends Controller
{



    function __construct()
    {
        parent::__construct();


    }


    public function index(){



        require ($this->render($this->folder,'html','details2','php'));


    }










}