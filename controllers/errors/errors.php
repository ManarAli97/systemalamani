<?php

class Errors extends Controller
{


    public  function  index()
    {

        require ($this->render($this->folder,'html','index','php'));
         die();
    }



    public  function  stop()
    {
        $msg="👻  You clicked on a dangerous link 👻";
        require ($this->render($this->folder,'html','stop','php'));
         die();
    }



}

