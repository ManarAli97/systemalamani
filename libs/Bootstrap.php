<?php

/**
 * Class Bootstrap
 */


class Bootstrap
{

    private $_url = null;
    private $_controller = null;
    private $_controllerPath = 'controllers/';//Always include trailing slash
    private $_modelPath = 'models/'; //Always include trailing slash
    private $_errorFile = 'errors/errors.php';
    private $_defaultFile = 'index/index.php';


    /**
     * Use init
     */

    /**
     * @return bool
     *starts th bootstrap
     */
    public function init()
    {


        //sets the protected $_url
        $this->_getURL();

        //load the default controller if no Url is set
        //eg:Visit http://localhost it loads Default controller
        if (empty($this->_url[0])) {
            $this->_loadDefaultController();
            return false;
        }

        $this->_loadExistingController();

        $this->_callControllerMethod();
    }

    /**
     * (Optional) set a custom  path to  controllers
     * @param string $path
     */


    public function setControllerPath($path)
    {
        $this->_controllerPath = trim($path, '/') . '/';

    }

    /**
     * (Optional) set a custom  path to  models
     * @param string $path
     */


    public function setModelPath($path)
    {
        $this->_modelPath = trim($path, '/') . '/';
    }

    /**
     * (Optional) set a custom  path to  the error file
     * @param string $path use file name  of your controller ,eg:error.php
     */

    public function setErrorFile($path)
    {
        $this->_errorFile = trim($path, '/');
    }


    /**
     * (Optional) set a custom  path to  the error file
     * @param string $path use file name  of your controller ,eg:index.php
     */

    public function setDefaultFile($path)
    {
        $this->_defaultFile = trim($path, '/');
    }


    /**
     * fetch the $_GET from 'url'
     */
    private function _getURL()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);//remove or replease /%0/.../ in url
        $this->_url = explode('/', $url);
    }


    /**
     * this loads if there is no GET parameter passed ***home page site
     */
    private function _loadDefaultController()
    {
        require $this->_controllerPath . $this->_defaultFile;
        $this->_controller = new index();
        $this->_controller->index();
    }


    /**
     * @return bool | string
     *
     * load an existing controller if there IS a GET parameter passed
     */
    private function _loadExistingController()
    {
        $file = $this->_controllerPath . $this->_url[0] . '/' . $this->_url[0] . '.php';

        if (file_exists($file)) {
            require $file;
            $this->_controller = new $this->_url[0];
            //control model_
            //$this->_controller->loadModel($this->_url[0],$this->_modelPath); //to call models
        } else {
            $this->_error();
            return false;
        }

    }


    /**
     * If a method is passed in the GET parameter
     */
    private function _callControllerMethod()
    {
        //http://localhost/controller/method/(param)/(param)/(param)
        //url[0] = controller
        //url[1] = method
        //url[2] = param
        //url[3] = param
        //url[4] = param

        $length = count($this->_url);
        //make sure the method we are calling exists
        if ($length > 1) {
            //  $this->_controller=$this->_controller.$this->_url[1];
            if (!method_exists($this->_controller, $this->_url[1])) {
                $this->_error();
            }
        }


        //determine what to load
        switch ($length) {
            case 10:
                //controller -> method (param1,param2,param3,param4)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3], $this->_url[4], $this->_url[5], $this->_url[6], $this->_url[9]);
                break;
            case 9:
                //controller -> method (param1,param2,param3,param4)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3], $this->_url[4], $this->_url[5], $this->_url[6], $this->_url[8]);
                break;
            case 8:
                //controller -> method (param1,param2,param3,param4)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3], $this->_url[4], $this->_url[5], $this->_url[6], $this->_url[7]);
                break;
            case 7:
                //controller -> method (param1,param2,param3,param4)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3], $this->_url[4], $this->_url[5], $this->_url[6]);
                break;
            case 6:
                //controller -> method (param1,param2,param3,param4)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3], $this->_url[4], $this->_url[5]);
                break;
            case 5:
                //controller -> method (param1,param2,param3)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3], $this->_url[4]);
                break;
            case 4:
                //controller -> method (param1,param2)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3]);
                break;
            case 3:
                //controller -> method (param1)
                $this->_controller->{$this->_url[1]}($this->_url[2]);
                break;
            case 2:
                //controller -> method ()
                $this->_controller->{$this->_url[1]}();
                break;

            default:

                    $this->_controller->index();

                break;
        }
    }

    /**
     * display an error page if nothing exists
     * @return boolean
     */

    private function _error()
    {
        require $this->_controllerPath . $this->_errorFile;
        $this->_controller = new Errors();
        $this->_controller->index();
        exit;
    }

}