<?php

class search_serial extends Controller
{

    public $ids = array();


    function __construct()
    {
        parent::__construct();
        $this->table = 'cart_shop_active';

    }



    function index()
    {
        $this->checkPermit('search_serial','search_serial');
        $this->adminHeaderController($this->langControl('search_serial'));




        require ($this->render($this->folder,'html','index','php'));
        $this->adminFooterController();
    }

    function get()
    {

        if ($this->handleLogin())
        {
            $val=$_GET['value'];
        }

		$q = '[[:<:]]'.$val.'[[:>:]]';

        $stmt=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE `enter_serial`   REGEXP ?  ");
        $stmt->execute(array($q));
        $data=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {


			if (!empty($this->cuts($row['id_item'],$row['table'])))
			{
				$row['price']=  $this->cuts($row['id_item'],$row['table']).' د.ع ';
			}else
			{
				$row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
			}
            $data []=$row;
        }

        require ($this->render($this->folder,'html','data','php'));
    }



    function get_serial_movement()
    {

        if ($this->handleLogin())
        {
            $val=trim($_GET['value']);
        }

        $q = '[[:<:]]'.$val.'[[:>:]]';

        $stmt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `enter_serial`   REGEXP ?  ");
        $stmt->execute(array($q));
        $data=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

            if ($row['table'] == 'product_savers')
            {
                $row['table'] ='savers';
            }

            $result= $this->data_code_info($row['code'],$row['table']);
            $row['model']=$this->langControl($row['table']);
            $row['title']=$result['title'];
            $row['img']=$result['img'];
            $row['date']=$row['date_prepared'];
            $row['user']=$this->UserInfo($row['id_prepared']);

            $row['serial']= $row['enter_serial'];
            $row['move']='مبيع';
            $data []=$row;
        }


        $stmt=$this->db->prepare("SELECT *FROM `serial` WHERE `serial`   = ?  ");
        $stmt->execute(array($val));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

           $result= $this->data_code_info($row['code'],$row['model']);

            $row['model']=$this->langControl($row['model']);
            $row['number_bill']=$row['bill'];
            $row['title']=$result['title'];
            $row['img']=$result['img'];
            $row['user']=$this->UserInfo($row['userId']);

            $row['move']='ادخال سيريال';
            $data []=$row;
        }

        $stmt=$this->db->prepare("SELECT *FROM `jard`  WHERE `serial`   = ?  ");
        $stmt->execute(array($val));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

           $result= $this->data_code_info($row['code'],$row['model']);

            $row['model']=$this->langControl($row['model']);
            $row['number_bill']='';
            $row['title']=$result['title'];
            $row['img']=$result['img'];
            $row['user']=$this->UserInfo($row['userId']);

            $row['move']='تقرير الجرد (جرد السيريلات) ';
            $data []=$row;
        }


        $stmt=$this->db->prepare("SELECT *FROM `jard_and_correction`  WHERE `serial`   = ?  ");
        $stmt->execute(array($val));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

           $result= $this->data_code_info($row['code'],$row['model']);

            $row['model']=$this->langControl($row['model']);
            $row['number_bill']='';
            $row['title']=$result['title'];
            $row['img']=$result['img'];
            $row['user']=$this->UserInfo($row['userId']);

            $row['move']='جرد و تصحيح';
            $data []=$row;
        }


        $stmt=$this->db->prepare("SELECT *FROM `review_item` WHERE `serial`   = ?  ");
        $stmt->execute(array($val));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

           $result= $this->data_code_info($row['code'],$row['table']);

            $row['model']=$this->langControl($row['table']);
            $row['number_bill']=$row['number_bill_new'];
            $row['title']=$result['title'];
            $row['img']=$result['img'];
            $row['user']=$this->UserInfo($row['id_prepared']);

            $row['move']='مرتجع';
            $data []=$row;
        }



        $stmt=$this->db->prepare("SELECT  *FROM `purchase_customer_item` WHERE `serial`   = ?  ");
        $stmt->execute(array($val));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

           $result= $this->data_code_info($row['code'],$row['table']);

            $row['model']=$this->langControl($row['table']);
            $row['title']=$result['title'];
            $row['img']=$result['img'];


            $stmtUser=$this->db->prepare("SELECT  *FROM `purchase_customer_bill` WHERE `id`   = ? LIMIT 1");
            $stmtUser->execute(array($row['id_bill']));
             $resultUser= $stmtUser->fetch(PDO::FETCH_ASSOC);
            $row['user']=$this->UserInfo($resultUser['userid']);

            $row['move']='شراء';
            $data []=$row;
        }




        $stmt=$this->db->prepare("SELECT *FROM `report_withdrawn` WHERE `serial`   = ?  ");
        $stmt->execute(array($val));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

            $result= $this->data_code_info($row['code'],$row['category']);

            $row['model']=$this->langControl($row['category']);
            $row['number_bill']='';
            $row['title']=$result['title'];
            $row['img']=$result['img'];
            $row['user']=$this->UserInfo($row['userid']);

            $row['move']='سحب';
            $data []=$row;
        }






        require ($this->render($this->folder,'html','movement','php'));
    }


    function save_note($id)
    {
         if ($this->handleLogin())
         {

             $data['note_search_serial']=$_GET['note_search_serial'];
             $data['user_note_search_serial']=$this->userid;

             $this->db->update( "`{$this->table}`",array_diff_key($data,['files'=>"delete"]),"id={$id}");
             echo $this->userInfo($this->userid);

         }
    }




    function data_code_info($code,$model)
    {


        if ($model=='accessories')
        {
            $stmt=$this->db->prepare("SELECT  accessories.title,color_accessories.color ,color_accessories.img ,color_accessories.code FROM color_accessories INNER JOIN  accessories ON  accessories.id=color_accessories.id_item  WHERE color_accessories.code=? LIMIT  1");
            $stmt->execute(array($code));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            $result['size']='';

        }else if($model=='savers')
        {

            $stmt=$this->db->prepare("SELECT  product_savers.title,  product_savers.img,product_savers.color,product_savers.code FROM product_savers    WHERE product_savers.code=? LIMIT  1");
            $stmt->execute(array($code));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            $result['size']='';

        }else
        {

            if ($model == 'mobile')
            {

                $code_table='code';
                $color='color';
                $excel='excel';
            }else
            {
                $code_table='code_'.$model;
                $color='color_'.$model;
                $excel='excel_'.$model;
            }

            $stmt=$this->db->prepare("SELECT  {$model}.title,{$color}.color,{$color}.img,{$code_table}.size,{$code_table}.code FROM {$code_table} INNER JOIN  {$color} ON  {$color}.id={$code_table}.id_color INNER JOIN  {$model} ON {$model}.id={$color}.id_item    WHERE {$code_table}.code=? LIMIT  1");
            $stmt->execute(array($code));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
        }


        return $result;


    }



}