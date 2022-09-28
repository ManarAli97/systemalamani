<?php
class  Form
{
     /** @var array  $_currentItem  the immediately post item  */
     private $_currentItem =null ;

     /** @var array  $_postData stores the post data */
    private $_postData=array();

     /** @var object  $_val the validator object  */
    private $_val=array();


     /** @var array  $_error  holds the current forms errors   */
    private $_error=array();




    /**
     * the  constructor.
     */
    public function minlength($data,$arg)
    {
        if(mb_strlen($data) < $arg)
        {
            return "your string can only be $arg long ";
        }
    }
    public function maxlength($data,$arg)
    {
        if(mb_strlen($data) > $arg)
        {
            return "your string can only be $arg long ";
        }
    }
    public function digit($data)
    {
        if(ctype_digit($data)==false)
        {
            return "your string must be a digit ";
        }
    }
    public function is_empty($data,$arg)
    {
        if(empty($data))
        {
            return "$arg";
        }
    }


   public function is_numeric($data,$arg)
    {

      if (!is_numeric($data))
        {
            return "$arg";
        }
    }

   public function strip_tags($field,$data,$arg)
    {
        if ($arg==null)
        {
            if ($this->isJson($data))
            {
                $value = strip_tags($data,$arg);
             }else{
                $char=['"',"'"];
                $value= strip_tags(str_replace($char,'',$data));
            }
        }else{
            $value = strip_tags($data,$arg);
        }
        $this->_postData[$field]=$value;

    }

    function isJson($string) {
        return ((is_string($string) &&
            (is_object(json_decode($string)) ||
                is_array(json_decode($string))))) ? true : false;
    }


    public function is_array($field,$data,$arg)
    {

         if (is_array($data))
         {
             $this->_postData[$field]=json_encode($data);
         }else
         {
             return "$arg";
         }


    }



    /**
     * post -  this is to run $_POST
      * @para string $field - the HTML fieldname to post
     */
    public function post($field)
    {
        error_reporting(0);
        $this->_postData[$field]=$_POST[$field];
        $this->_currentItem =$field;
       return $this;
    }

    /**
     *
     * fetch - return the posted data
     * @param mixed   $filedName
     * @return  mixed string or array
     */
    public function fetch($filedName=false)
    {
        if ($filedName)
        {

            if (isset($this->_postData[$filedName]))
            return $this->_postData[$filedName];
            else
               return false;
        }
        else
        {
            return $this->_postData;
        }
    }

    /**
     *val - this is to validate
     *
     * @para string $typeOfValidator A method from the Form/Val class

     * @para string $arg A property to validate aginst
     */
    public function val($typeOfValidator,$arg=null)
    {

        if ($typeOfValidator == 'strip_tags')
        {
            $error = $this ->{$typeOfValidator}($this->_currentItem,$this->_postData[$this->_currentItem],$arg);
       }
      elseif   ($typeOfValidator == 'is_array')
       {
           $error = $this ->{$typeOfValidator}($this->_currentItem,$this->_postData[$this->_currentItem],$arg);
       }
        else
          {
            if ($arg == null)
                $error = $this ->{$typeOfValidator}($this->_postData[$this->_currentItem]);
            else
                $error = $this ->{$typeOfValidator}($this->_postData[$this->_currentItem],$arg);
        }

        if($error)
            $this->_error[$this->_currentItem] =$error;

        return $this;


//        $val -> minlength('dog',$arg);

    }


    /**
     * submit - Handle the form ,and  throws an exeption upon error
     * @return bool
     * @throws Exception
     */
    public function submit()
    {
        if (empty($this->_error))
        {
            return true;
        }
        else
            {

         foreach ($this->_error as $key => $value)
         {
             $str[$key]= $value;
         }
            throw new Exception(json_encode($str));
        }

    }

}




?>