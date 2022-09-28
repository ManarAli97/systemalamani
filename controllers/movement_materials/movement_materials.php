<?php

class movement_materials extends Controller
{

    public $ids = array();


    function __construct()
    {
        parent::__construct();
        $this->table = 'cart_shop_active';

    }



    function index()
    {
        $this->checkPermit('movement_materials','movement_materials');
        $this->adminHeaderController($this->langControl('movement_materials'));
        $this->add_cart_shop_all();



        $date_acc_and_req=0;

		$date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;
		$code=null;
		$data=array();

		$id=null;
		$model=null;
		$category=null;
		$path_category=null;
		$name_category=null;
		$ids_cat=null;
        $type=array();
        $price_type=array();

		if (isset($_GET['type']))
        {
            $type= $_GET['type'];
        }

		if (isset($_GET['price_type']))
        {
            $price_type= $_GET['price_type'];
        }

		$price_type_in=implode(',',$price_type);


		if (isset($_GET['code']))
        {
            $code= $_GET['code'];
        }

        if (isset($_GET['date']))
        {
            $date = $_GET['date'];
        }

		if (isset($_GET['todate']))
        {
            $todate = $_GET['todate'];
        }

		if (isset($_GET['model']))
        {
            $model = $_GET['model'];
        }


		if (isset($_GET['category']))
        {
            $category = $_GET['category'];
        }




		if (isset($_GET['model']) && isset($_GET['category'])) {

			$categoryIds = $_GET['category'];


			$id = explode('_', $categoryIds);
			$id = $id[1];

			$category=$_GET['model'];
			$model = $_GET['model'];



			$name_category = 'category_' . $model;
			$breadcumbsx = $this->BreadcumbsPublic($name_category, $id);
			$path_category ='<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) .' </li> ';
			foreach ($breadcumbsx as $key => $cat) {
				$path_category .= '<li class="breadcrumb-item active" aria-current="page" >' . $key .' </li> ';
			}


			$this->ids[]=$id;
			if (!empty($this->getLoopIdX($id,$name_category)))
			{
				$this->ids[]=  $this->getLoopIdX($id,$name_category);
			}
			$ids_cat=implode(',', $this->ids);


		} else if (isset($_GET['model']))
		{
			$id = null;
			$model = $_GET['model'];
			$path_category ='<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) .' </li> ';

		}
        if ($model=='mobile') {
            $color = 'color';
        }else  {
            $color = 'color_'.$model;
        }

        if ($model == 'savers')
        {
            $table='product_savers';
        }else
        {
            $table=$model;
        }

		if ($code || $date || $todate || $model || $category || 1==1 ) {

            /*****************account and  3 price *********************/

            if ( in_array(1,$price_type) || in_array(2,$price_type) || in_array(2,$price_type) ) {


                $date_acc_and_req=1;

                if ($model == 'savers')
                {
                    $table='product_savers';
                    $model='product_savers';
                }
                if ($code && $date && $todate && $model && $category) {


                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE {$model}.id_cat IN({$ids_cat}) AND cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1  AND cart_shop_all.price_type IN ({$price_type_in})  AND (cart_shop_all.date_accountant  BETWEEN ? AND ? or cart_shop_all.date_prepared  BETWEEN ? AND ?)  GROUP BY cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc   ");
                    $stmt->execute(array($code, $from_date_stm, $to_date_stm, $from_date_stm, $to_date_stm));


                } else if ($code && $date && $todate && $model) {

                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE cart_shop_all.`table` ='{$table}' AND cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1   AND cart_shop_all.price_type IN ({$price_type_in}) AND cart_shop_all.date_accountant   BETWEEN ? AND ? GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc     ");
                    $stmt->execute(array($code, $from_date_stm, $to_date_stm));


                } else if ($date && $todate && $model && $category) {


                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE {$model}.id_cat IN({$ids_cat})   AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1   AND cart_shop_all.price_type IN ({$price_type_in})   AND (cart_shop_all.date_accountant  BETWEEN ? AND ? or cart_shop_all.date_prepared  BETWEEN ? AND ?) GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc   ");
                    $stmt->execute(array($from_date_stm, $to_date_stm, $from_date_stm, $to_date_stm));


                } else if ($date && $todate && $model) {


                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE cart_shop_all.`table` ='{$table}'    AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1  AND cart_shop_all.price_type IN ({$price_type_in})   AND (cart_shop_all.date_accountant  BETWEEN ? AND ? or cart_shop_all.date_prepared  BETWEEN ? AND ?) GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute(array($from_date_stm, $to_date_stm, $from_date_stm, $to_date_stm));


                } else if ($code && $model && $category) {

                    $code = $_GET['code'];

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE {$model}.id_cat IN({$ids_cat}) AND cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1   AND cart_shop_all.price_type IN ({$price_type_in})   GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc ");
                    $stmt->execute(array($code));


                } else if ($code && $model) {

                    $code = $_GET['code'];

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE cart_shop_all.`table` ='{$table}'  AND cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1   AND cart_shop_all.price_type IN ({$price_type_in})    GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc ");
                    $stmt->execute(array($code));


                } else if ($model && $category) {
                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE {$model}.id_cat IN({$ids_cat})    AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1   AND cart_shop_all.price_type IN ({$price_type_in})     GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc   ");
                    $stmt->execute();
                } else if ($model) {

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE  cart_shop_all.`table` ='{$table}'   AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1   AND cart_shop_all.price_type IN ({$price_type_in})   GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute();
                } else if ($code && $date && $todate) {

                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE   cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1   AND cart_shop_all.price_type IN ({$price_type_in}) AND cart_shop_all.date_accountant   BETWEEN ? AND ? GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code ,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute(array($code, $from_date_stm, $to_date_stm));
                } else if ($date && $todate) {

                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);

                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE   cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1   AND cart_shop_all.price_type IN ({$price_type_in})  AND (cart_shop_all.date_accountant  BETWEEN ? AND ? or cart_shop_all.date_prepared  BETWEEN ? AND ?) GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc ");
                    $stmt->execute(array($from_date_stm, $to_date_stm, $from_date_stm, $to_date_stm));

                } else if ($code) {
                    $code = $_GET['code'];
                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1   AND cart_shop_all.price_type IN ({$price_type_in})  GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute(array($code));
                }else
                {
                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1    AND cart_shop_all.price_type IN ({$price_type_in})   GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute();
                }


                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                   $dat_table= $this->bast_it_item($row['table'],$row['id_item']);

                    $row['title']= $dat_table['title'] ;
                    if ($dat_table['bast_it'] == 1 )
                    {
                        $row['bast_it']= 'ننصح به' ;
                    }else
                    {
                        $row['bast_it']= '' ;
                    }
					 if($row['table'] == 'product_savers'){
                        $name_device= $this->type_device_savers($row['id_item']);
                        $row['name_device'] = $name_device;
                    }else{
                        $row['name_device'] = '';
                    }

                    $row['price'] = $this->sum_amount_mm($row['price_dollars'], $row['dollar_exchange'], $row['number'])  ;
                    $row['account'] = $this->UserInfo($row['id_accountant_user']);
                    $row['date'] = $row['date_accountant'];
                    $row['type_bill'] = 'تمت المحاسبة (قيد تجهيز)';
                    $row['store_location']=$this->store_location($row['location'],$row['table'],$row['code']);
                    $row['user_sale']=$this->UserInfo($row['user_direct']);
                    $row['crystal_bill']=$this->get_crystal_bill($row['number_bill']);
                    $row['point']=$this->point($row['code'],$row['table']);
                    $data [] = $row;
                }



            }

            /*****************account only*********************/
             if (in_array('account', $type))
              {
                  $date_acc_and_req=1;
                  if ($model == 'savers')
                  {
                      $table='product_savers';
                      $model='product_savers';
                  }
                if ($code && $date && $todate && $model && $category) {


                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE {$model}.id_cat IN({$ids_cat}) AND cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1 AND (cart_shop_all.date_accountant  BETWEEN ? AND ? or cart_shop_all.date_prepared  BETWEEN ? AND ?) GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc   ");
                    $stmt->execute(array($code, $from_date_stm, $to_date_stm, $from_date_stm, $to_date_stm));


                } else if ($code && $date && $todate && $model) {

                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE cart_shop_all.`table` ='{$table}' AND cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1 AND (cart_shop_all.date_accountant  BETWEEN ? AND ? or cart_shop_all.date_prepared  BETWEEN ? AND ?) GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc     ");
                    $stmt->execute(array($code, $from_date_stm, $to_date_stm, $from_date_stm, $to_date_stm));


                } else if ($date && $todate && $model && $category) {


                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE {$model}.id_cat IN({$ids_cat})   AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1 AND (cart_shop_all.date_accountant  BETWEEN ? AND ? or cart_shop_all.date_prepared  BETWEEN ? AND ?) GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc   ");
                    $stmt->execute(array($from_date_stm, $to_date_stm, $from_date_stm, $to_date_stm));


                } else if ($date && $todate && $model) {


                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE cart_shop_all.`table` ='{$table}'    AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1 AND (cart_shop_all.date_accountant  BETWEEN ? AND ? or cart_shop_all.date_prepared  BETWEEN ? AND ?) GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute(array($from_date_stm, $to_date_stm, $from_date_stm, $to_date_stm));


                } else if ($code && $model && $category) {

                    $code = $_GET['code'];

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE {$model}.id_cat IN({$ids_cat}) AND cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1   GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc ");
                    $stmt->execute(array($code));


                } else if ($code && $model) {

                    $code = $_GET['code'];

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE cart_shop_all.`table` ='{$table}'  AND cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1    GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc ");
                    $stmt->execute(array($code));


                } else if ($model && $category) {
                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE {$model}.id_cat IN({$ids_cat})    AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1     GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc   ");
                    $stmt->execute();
                } else if ($model) {

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE  cart_shop_all.`table` ='{$table}'   AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1  GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute();
                } else if ($code && $date && $todate) {

                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE   cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1 AND (cart_shop_all.date_accountant  BETWEEN ? AND ? or cart_shop_all.date_prepared  BETWEEN ? AND ?) GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code ,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute(array($code, $from_date_stm, $to_date_stm, $from_date_stm, $to_date_stm));
                } else if ($date && $todate) {

                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);

                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE   cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1 AND (cart_shop_all.date_accountant  BETWEEN ? AND ? or cart_shop_all.date_prepared  BETWEEN ? AND ?) GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc ");
                    $stmt->execute(array($from_date_stm, $to_date_stm, $from_date_stm, $to_date_stm));

                } else if ($code) {
                    $code = $_GET['code'];
                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1  GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute(array($code));
                }else
                {
                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=1 AND cart_shop_all.accountant=1    GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute();
                }


                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $dat_table= $this->bast_it_item($row['table'],$row['id_item']);

                     $row['title']= $dat_table['title'] ;
                    if ($dat_table['bast_it'] == 1 )
                    {
                        $row['bast_it']= 'ننصح به' ;
                    }else
                    {
                        $row['bast_it']= '' ;
                    }
					if($row['table'] == 'product_savers'){
                        $name_device= $this->type_device_savers($row['id_item']);
                        $row['name_device'] =$name_device;
                    }else{
                        $row['name_device'] = '';
                    }
                    $row['price'] = $this->sum_amount_mm($row['price_dollars'], $row['dollar_exchange'], $row['number'])  ;

                    $row['account'] = $this->UserInfo($row['id_accountant_user']);
                    $row['date'] = $row['date_accountant'];
                    $row['type_bill'] = 'تمت المحاسبة (قيد تجهيز)';
                     $row['store_location']=$this->store_location($row['location'],$row['table'],$row['code']);
                    $row['user_sale']=$this->UserInfo($row['user_direct']);
                    $row['crystal_bill']=$this->get_crystal_bill($row['number_bill']);
                    $row['point']=$this->point($row['code'],$row['table']);

                    $data [] = $row;
                }

            }



            /*****************sale and  3 price *********************/
            if (in_array(1,$price_type) || in_array(2,$price_type) || in_array(2,$price_type)  ) {
                $date_acc_and_req=1;
                if ($model == 'savers')
                {
                    $table='product_savers';
                    $model='product_savers';
                }
                if ($code && $date && $todate && $model && $category) {


                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE {$model}.id_cat IN({$ids_cat}) AND cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1  AND cart_shop_all.price_type IN ({$price_type_in})   AND cart_shop_all.date_prepared BETWEEN ? AND ? GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc   ");
                    $stmt->execute(array($code, $from_date_stm, $to_date_stm));


                } else if ($code && $date && $todate && $model) {

                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE cart_shop_all.`table` ='{$table}' AND cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1  AND cart_shop_all.price_type IN ({$price_type_in})  AND cart_shop_all.date_prepared BETWEEN ? AND ? GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc     ");
                    $stmt->execute(array($code, $from_date_stm, $to_date_stm));


                } else if ($date && $todate && $model && $category) {


                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE {$model}.id_cat IN({$ids_cat})   AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1  AND cart_shop_all.price_type IN ({$price_type_in})  AND (cart_shop_all.date_accountant  BETWEEN ? AND ? or cart_shop_all.date_prepared  BETWEEN ? AND ?) GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc   ");
                    $stmt->execute(array($from_date_stm, $to_date_stm, $from_date_stm, $to_date_stm));


                } else if ($date && $todate && $model) {


                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`     WHERE cart_shop_all.`table` ='{$table}'    AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1  AND cart_shop_all.price_type IN ({$price_type_in})   AND (cart_shop_all.date_accountant  BETWEEN ? AND ? or cart_shop_all.date_prepared  BETWEEN ? AND ?) GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute(array($from_date_stm, $to_date_stm, $from_date_stm, $to_date_stm));


                } else if ($code && $model && $category) {

                    $code = $_GET['code'];

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE {$model}.id_cat IN({$ids_cat}) AND cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1   AND cart_shop_all.price_type IN ({$price_type_in})  GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc ");
                    $stmt->execute(array($code));


                } else if ($code && $model) {

                    $code = $_GET['code'];

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE cart_shop_all.`table` ='{$table}'  AND cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1   AND cart_shop_all.price_type IN ({$price_type_in})   GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc ");
                    $stmt->execute(array($code));


                } else if ($model && $category) {
                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE {$model}.id_cat IN({$ids_cat})    AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1   AND cart_shop_all.price_type IN ({$price_type_in})    GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc   ");
                    $stmt->execute();
                } else if ($model) {

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE  cart_shop_all.`table` ='{$table}'   AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1  AND cart_shop_all.price_type IN ({$price_type_in})  GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute();
                } else if ($code && $date && $todate) {

                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE   cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1   AND cart_shop_all.price_type IN ({$price_type_in})   AND (cart_shop_all.date_accountant  BETWEEN ? AND ? or cart_shop_all.date_prepared  BETWEEN ? AND ?) GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code ,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute(array($code, $from_date_stm, $to_date_stm, $from_date_stm, $to_date_stm));
                } else if ($date && $todate) {

                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);

                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE   cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1   AND cart_shop_all.price_type IN ({$price_type_in})  AND cart_shop_all.date_prepared BETWEEN ? AND ? GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc ");
                    $stmt->execute(array($from_date_stm, $to_date_stm));

                } else if ($code) {
                    $code = $_GET['code'];
                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1  AND cart_shop_all.price_type IN ({$price_type_in})   GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute(array($code));
                }else
                {
                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1   AND cart_shop_all.price_type IN ({$price_type_in})   GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute();
                }


                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $dat_table= $this->bast_it_item($row['table'],$row['id_item']);

                    $row['title']= $dat_table['title'] ;
                    if ($dat_table['bast_it'] == 1 )
                    {
                        $row['bast_it']= 'ننصح به' ;
                    }else
                    {
                        $row['bast_it']= '' ;
                    }
 					if($row['table'] == 'product_savers'){
                        $name_device= $this->type_device_savers($row['id_item']);
                        $row['name_device'] = $name_device;
                    }else{
                        $row['name_device'] = '';
                    }
                    $row['price'] = $this->sum_amount_mm($row['price_dollars'], $row['dollar_exchange'], $row['number'])  ;

                    $row['account'] = $this->UserInfo($row['id_accountant_user']);
                    $row['date'] = $row['date_prepared'];
                    $row['type_bill'] = 'مبيع';
                     $row['store_location']=$this->store_location($row['location'],$row['table'],$row['code']);
                    $row['user_sale']=$this->UserInfo($row['user_direct']);
                    $row['crystal_bill']=$this->get_crystal_bill($row['number_bill']);
                    $row['point']=$this->point($row['code'],$row['table']);

                    $data [] = $row;
                }
            }

            /*****************sale*********************/

            if (in_array('sale', $type)){

                $date_acc_and_req=1;
                if ($model == 'savers')
                {
                    $table='product_savers';
                    $model='product_savers';
                }
                if ($code && $date && $todate && $model && $category) {


                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`     inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE {$model}.id_cat IN({$ids_cat}) AND cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1 AND cart_shop_all.date_prepared BETWEEN ? AND ? GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc   ");
                    $stmt->execute(array($code, $from_date_stm, $to_date_stm));


                } else if ($code && $date && $todate && $model) {

                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE cart_shop_all.`table` ='{$table}' AND cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1 AND cart_shop_all.date_prepared BETWEEN ? AND ? GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc     ");
                    $stmt->execute(array($code, $from_date_stm, $to_date_stm));


                } else if ($date && $todate && $model && $category) {


                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE {$model}.id_cat IN({$ids_cat})   AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1 AND (cart_shop_all.date_accountant  BETWEEN ? AND ? or  cart_shop_all.date_prepared  BETWEEN ? AND ?) GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc   ");
                    $stmt->execute(array($from_date_stm, $to_date_stm, $from_date_stm, $to_date_stm));


                } else if ($date && $todate && $model) {


                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE cart_shop_all.`table` ='{$table}'    AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1 AND (cart_shop_all.date_accountant  BETWEEN ? AND ? or cart_shop_all.date_prepared  BETWEEN ? AND ?) GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute(array($from_date_stm, $to_date_stm, $from_date_stm, $to_date_stm));


                } else if ($code && $model && $category) {

                    $code = $_GET['code'];

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE {$model}.id_cat IN({$ids_cat}) AND cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1   GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc ");
                    $stmt->execute(array($code));


                } else if ($code && $model) {

                    $code = $_GET['code'];

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE cart_shop_all.`table` ='{$table}'  AND cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1    GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc ");
                    $stmt->execute(array($code));


                } else if ($model && $category) {
                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE {$model}.id_cat IN({$ids_cat})    AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1     GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc   ");
                    $stmt->execute();
                } else if ($model) {

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    inner join {$model} on {$model}.id =cart_shop_all.id_item WHERE  cart_shop_all.`table` ='{$table}'   AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1  GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute();
                } else if ($code && $date && $todate) {

                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE   cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1 AND (cart_shop_all.date_accountant  BETWEEN ? AND ? or cart_shop_all.date_prepared  BETWEEN ? AND ?) GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code ,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute(array($code, $from_date_stm, $to_date_stm, $from_date_stm, $to_date_stm));
                } else if ($date && $todate) {

                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);

                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE   cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1 AND cart_shop_all.date_prepared BETWEEN ? AND ? GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc ");
                    $stmt->execute(array($from_date_stm, $to_date_stm));

                } else if ($code) {
                    $code = $_GET['code'];
                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE cart_shop_all.`code`=?  AND  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1  GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute(array($code));
                }else
                {
                    $stmt = $this->db->prepare("SELECT cart_shop_all.*, SUM(cart_shop_all.number) as number FROM `cart_shop_all`    WHERE  cart_shop_all.`cancel` =0 AND  cart_shop_all.`buy`=2 AND cart_shop_all.accountant=1    GROUP BY  cart_shop_all.id_member_r , cart_shop_all.id_item ,cart_shop_all.code,cart_shop_all.number_bill ORDER BY  cart_shop_all.number_bill  asc  ");
                    $stmt->execute();
                }


                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $dat_table= $this->bast_it_item($row['table'],$row['id_item']);

                    $row['title']= $dat_table['title'] ;
                    if ($dat_table['bast_it'] == 1 )
                    {
                        $row['bast_it']= 'ننصح به' ;
                    }else
                    {
                        $row['bast_it']= '' ;
                    }
                 	if($row['table'] == 'product_savers'){
                        $name_device= $this->type_device_savers($row['id_item']);
                        $row['name_device'] = $name_device;
                    }else{
                        $row['name_device'] = '';
                    }
                    $row['price'] = $this->sum_amount_mm($row['price_dollars'], $row['dollar_exchange'], $row['number'])  ;
                    $row['account'] = $this->UserInfo($row['id_accountant_user']);
                    $row['date'] = $row['date_prepared'];
                    $row['type_bill'] = 'مبيع';
                     $row['store_location']=$this->store_location($row['location'],$row['table'],$row['code']);
                    $row['user_sale']=$this->UserInfo($row['user_direct']);
                    $row['crystal_bill']=$this->get_crystal_bill($row['number_bill']);
                    $row['point']=$this->point($row['code'],$row['table']);

                    $data [] = $row;
                }

            }

            /*****************purchase*********************/
            if (in_array('purchase', $type)) {
                if ($code && $date && $todate && $model && $category) {


                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT purchase_customer_item.*,purchase_customer_bill.crystal_bill,purchase_customer_bill.userid,SUM(purchase_customer_item.quantity) as number,{$color}.img as image,{$color}.color FROM `purchase_customer_item` left join  purchase_customer_bill ON purchase_customer_bill.id = purchase_customer_item.id_bill  inner join {$model} on {$model}.id =purchase_customer_item.id_item inner join {$color} on {$color}.id = purchase_customer_item.id_color
                  WHERE 
                  purchase_customer_item.`table` ='{$model}'
                  AND purchase_customer_item.`code` =?
                  AND purchase_customer_item.date BETWEEN ? AND ?
                    AND purchase_customer_bill.cancel=0
                 GROUP BY purchase_customer_item.id_item ,purchase_customer_item.code,purchase_customer_item.number_bill ORDER BY  purchase_customer_item.number_bill  asc   ");

                    $stmt->execute(array($code, $from_date_stm, $to_date_stm));


                } else if ($code && $date && $todate && $model) {

                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);
                    $stmt = $this->db->prepare("SELECT purchase_customer_item.*,purchase_customer_bill.crystal_bill,purchase_customer_bill.userid,SUM(purchase_customer_item.quantity) as number,{$color}.img as image,{$color}.color FROM `purchase_customer_item` left join  purchase_customer_bill ON purchase_customer_bill.id = purchase_customer_item.id_bill  inner join {$model} on {$model}.id =purchase_customer_item.id_item inner join {$color} on {$color}.id = purchase_customer_item.id_color
                  WHERE 
                  purchase_customer_item.`table` ='{$model}'
                  AND purchase_customer_item.`code` =?
                  AND purchase_customer_item.date BETWEEN ? AND ?
                    AND purchase_customer_bill.cancel=0 AND {$model}.id_cat IN({$ids_cat})  
                 GROUP BY purchase_customer_item.id_item ,purchase_customer_item.code,purchase_customer_item.number_bill ORDER BY  purchase_customer_item.number_bill  asc   ");


                    $stmt->execute(array($code, $from_date_stm, $to_date_stm));


                } else if ($date && $todate && $model && $category) {


                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT purchase_customer_item.*,purchase_customer_bill.crystal_bill,purchase_customer_bill.userid,SUM(purchase_customer_item.quantity) as number,{$color}.img as image,{$color}.color FROM `purchase_customer_item` left join  purchase_customer_bill ON purchase_customer_bill.id = purchase_customer_item.id_bill  inner join {$model} on {$model}.id =purchase_customer_item.id_item inner join {$color} on {$color}.id = purchase_customer_item.id_color
                  WHERE 
                  purchase_customer_item.`table` ='{$model}'
                  AND purchase_customer_item.date BETWEEN ? AND ?
                    AND purchase_customer_bill.cancel=0  AND {$model}.id_cat IN({$ids_cat})  
                 GROUP BY purchase_customer_item.id_item ,purchase_customer_item.code,purchase_customer_item.number_bill ORDER BY  purchase_customer_item.number_bill  asc   ");


                    $stmt->execute(array($from_date_stm, $to_date_stm));


                } else if ($date && $todate && $model) {


                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                  $stmt = $this->db->prepare("SELECT purchase_customer_item.*,purchase_customer_bill.crystal_bill,purchase_customer_bill.userid,SUM(purchase_customer_item.quantity) as number,{$color}.img as image,{$color}.color FROM `purchase_customer_item` left join  purchase_customer_bill ON purchase_customer_bill.id = purchase_customer_item.id_bill  inner join {$model} on {$model}.id =purchase_customer_item.id_item inner join {$color} on {$color}.id = purchase_customer_item.id_color
                  WHERE 
                  purchase_customer_item.`table` ='{$model}'
                  AND purchase_customer_item.date BETWEEN ? AND ?
                    AND purchase_customer_bill.cancel=0 
                 GROUP BY purchase_customer_item.id_item ,purchase_customer_item.code,purchase_customer_item.number_bill ORDER BY  purchase_customer_item.number_bill  asc   ");

                    $stmt->execute(array($from_date_stm, $to_date_stm));


                } else if ($code && $model && $category) {

                    $code = $_GET['code'];

                    $stmt = $this->db->prepare("SELECT purchase_customer_item.*,purchase_customer_bill.crystal_bill,purchase_customer_bill.userid,SUM(purchase_customer_item.quantity) as number,{$color}.img as image,{$color}.color FROM `purchase_customer_item` left join  purchase_customer_bill ON purchase_customer_bill.id = purchase_customer_item.id_bill  inner join {$model} on {$model}.id =purchase_customer_item.id_item inner join {$color} on {$color}.id = purchase_customer_item.id_color
                  WHERE 
                  purchase_customer_item.`table` ='{$model}'
                  AND purchase_customer_item.`code` =?
                    AND purchase_customer_bill.cancel=0  AND {$model}.id_cat IN({$ids_cat})  
                 GROUP BY purchase_customer_item.id_item ,purchase_customer_item.code,purchase_customer_item.number_bill ORDER BY  purchase_customer_item.number_bill  asc   ");

                    $stmt->execute(array($code));


                } else if ($code && $model) {


                    $code = $_GET['code'];

                    $stmt = $this->db->prepare("SELECT purchase_customer_item.*,purchase_customer_bill.crystal_bill,purchase_customer_bill.userid,SUM(purchase_customer_item.quantity) as number,{$color}.img as image,{$color}.color FROM `purchase_customer_item` left join  purchase_customer_bill ON purchase_customer_bill.id = purchase_customer_item.id_bill  inner join {$model} on {$model}.id =purchase_customer_item.id_item inner join {$color} on {$color}.id = purchase_customer_item.id_color
                  WHERE 
                  purchase_customer_item.`table` ='{$model}'
                  AND purchase_customer_item.`code` =?
                    AND purchase_customer_bill.cancel=0
                   GROUP BY purchase_customer_item.id_item ,purchase_customer_item.code,purchase_customer_item.number_bill ORDER BY  purchase_customer_item.number_bill  asc   ");

                    $stmt->execute(array($code));


                } else if ($model && $category) {

                    $stmt = $this->db->prepare("SELECT purchase_customer_item.*,purchase_customer_bill.crystal_bill,purchase_customer_bill.userid,SUM(purchase_customer_item.quantity) as number,{$color}.img as image,{$color}.color FROM `purchase_customer_item` left join  purchase_customer_bill ON purchase_customer_bill.id = purchase_customer_item.id_bill  inner join {$model} on {$model}.id =purchase_customer_item.id_item inner join {$color} on {$color}.id = purchase_customer_item.id_color
                  WHERE 
                  purchase_customer_item.`table` ='{$model}'
                    AND purchase_customer_bill.cancel=0  AND {$model}.id_cat IN({$ids_cat})  
                 GROUP BY purchase_customer_item.id_item ,purchase_customer_item.code,purchase_customer_item.number_bill ORDER BY  purchase_customer_item.number_bill  asc   ");

                    $stmt->execute();
                } else if ($model) {

                    $stmt = $this->db->prepare("SELECT purchase_customer_item.*,purchase_customer_bill.crystal_bill,purchase_customer_bill.userid,SUM(purchase_customer_item.quantity) as number,{$color}.img as image,{$color}.color  FROM `purchase_customer_item` left join  purchase_customer_bill ON purchase_customer_bill.id = purchase_customer_item.id_bill  inner join {$model} on {$model}.id =purchase_customer_item.id_item inner join {$color} on {$color}.id = purchase_customer_item.id_color
                  WHERE 
                  purchase_customer_item.`table` ='{$model}'
                    AND purchase_customer_bill.cancel=0
                 GROUP BY purchase_customer_item.id_item ,purchase_customer_item.code,purchase_customer_item.number_bill ORDER BY  purchase_customer_item.number_bill  asc   ");
                    $stmt->execute();
                } else if ($code && $date && $todate) {


                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);


                    $code = $_GET['code'];

                    $stmt = $this->db->prepare("SELECT purchase_customer_item.*,purchase_customer_bill.crystal_bill,purchase_customer_bill.userid,SUM(purchase_customer_item.quantity) as number FROM `purchase_customer_item` left join  purchase_customer_bill ON purchase_customer_bill.id = purchase_customer_item.id_bill  
                  WHERE 
                  purchase_customer_item.`code` =?
                    AND purchase_customer_bill.cancel=0
                  AND purchase_customer_item.date BETWEEN ? AND ?
                 GROUP BY purchase_customer_item.id_item ,purchase_customer_item.code,purchase_customer_item.number_bill ORDER BY  purchase_customer_item.number_bill  asc   ");

                    $stmt->execute(array($code, $from_date_stm, $to_date_stm));
                } else if ($date && $todate) {

                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);

                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT purchase_customer_item.*,purchase_customer_bill.crystal_bill,purchase_customer_bill.userid,SUM(purchase_customer_item.quantity) as number  FROM `purchase_customer_item` left join  purchase_customer_bill ON purchase_customer_bill.id = purchase_customer_item.id_bill   
                  WHERE 
         
                    purchase_customer_item.date BETWEEN ? AND ?
                    AND purchase_customer_bill.cancel=0
                    GROUP BY purchase_customer_item.id_item ,purchase_customer_item.code,purchase_customer_item.number_bill ORDER BY  purchase_customer_item.number_bill  asc   ");
                    $stmt->execute(array($from_date_stm, $to_date_stm));

                } else if ($code) {
                    $code = $_GET['code'];
                    $stmt = $this->db->prepare("SELECT purchase_customer_item.*,purchase_customer_bill.crystal_bill,purchase_customer_bill.userid,SUM(purchase_customer_item.quantity) as number  FROM `purchase_customer_item` left join  purchase_customer_bill ON purchase_customer_bill.id = purchase_customer_item.id_bill   
                  WHERE 
                    purchase_customer_item.`code` =?
                    AND purchase_customer_bill.cancel=0
                    GROUP BY purchase_customer_item.id_item ,purchase_customer_item.code,purchase_customer_item.number_bill ORDER BY  purchase_customer_item.number_bill  asc   ");
                    $stmt->execute(array($code));
                }else
                {

                    $stmt = $this->db->prepare("SELECT purchase_customer_item.*,purchase_customer_bill.crystal_bill,purchase_customer_bill.userid,SUM(purchase_customer_item.quantity) as number  FROM `purchase_customer_item` left join  purchase_customer_bill ON purchase_customer_bill.id = purchase_customer_item.id_bill  
                  WHERE 
          
                   purchase_customer_bill.cancel=0
                    GROUP BY purchase_customer_item.id_item ,purchase_customer_item.code,purchase_customer_item.number_bill ORDER BY  purchase_customer_item.number_bill  asc   ");
                    $stmt->execute();

                }


                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    if (empty($model))
                    {
                        if ($row['table']=='mobile') {
                            $color = 'color';
                        }else  {
                            $color = 'color_'.$row['table'];
                        }

                        $stmtc=$this->db->prepare("SELECT color,img FROM {$color} WHERE id=?");
                        $stmtc->execute(array($row['id_color']));
                        $result=$stmtc->fetch(PDO::FETCH_ASSOC);
                        $row['image'] = $result['img'];
                        $row['name_color'] = $result['color'];
                    }else
                    {
                        $row['name_color'] = $row['color'];
                    }



                    $dat_table= $this->bast_it_item($row['table'],$row['id_item']);

                    $row['title']= $dat_table['title'] ;
                    if ($dat_table['bast_it'] == 1 )
                    {
                        $row['bast_it']= 'ننصح به' ;
                    }else
                    {
                        $row['bast_it']= '' ;
                    }
					 if($row['table'] == 'product_savers'){
                        $name_device= $this->type_device_savers($row['id_item']);
                        $row['name_device'] =  $name_device;
                    }else{
                        $row['name_device'] = '';
                    }
                    $row['price'] = number_format( (int)$row['price_purchase'] * (int)$row['quantity']) ;
                    $row['id_member_r'] = $row['id_customer'];
                    $row['enter_serial'] =$row['serial'];
                    $row['account'] = $this->UserInfo($row['userid']);
                    $row['type_bill'] = 'شراء';
                     $row['location']='';
                    $row['store_location']= '';
                    $row['offers']= '';
                    $row['user_sale']='';
                    $row['price_type']=0;
                    $row['group_bill']='';
                    $row['edit_price']='0';
                    $row['id_prepared']='';
                    $row['user_direct']='';
                    $row['note_prepared']='';
                    $row['note']='';
                    $row['point']=$this->point($row['code'],$row['table']);




                    $data [] = $row;
                }


            }

            /*****************review_item*********************/
            if (in_array('review', $type)) {
                if ($model == 'savers')
                {
                    $table='product_savers';
                    $model='product_savers';
                }
                if ($code && $date && $todate && $model && $category) {


                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT review_item.*,review.crystal_bill,count(review_item.code) as number FROM `review_item` left join  review ON review.number_bill_new = review_item.number_bill_new  inner join {$table} on {$table}.id =review_item.id_item
              WHERE review.cancel=0 AND
              review_item.`table` ='{$table}'
              AND review_item.`code` =?
              AND review_item.date BETWEEN ? AND ?  AND {$table}.id_cat IN({$ids_cat})  
            GROUP BY review_item.id_item ,review_item.code,review_item.number_bill_new ORDER BY  review_item.number_bill_new  asc   ");

                    $stmt->execute(array($code, $from_date_stm, $to_date_stm));


                } else if ($code && $date && $todate && $model) {

                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT review_item.*,review.crystal_bill,count(review_item.code) as number FROM `review_item` left join  review ON review.number_bill_new = review_item.number_bill_new  inner join {$table} on {$table}.id =review_item.id_item
              WHERE review.cancel=0 AND
              review_item.`table` ='{$table}'
              AND review_item.`code` =?
              AND review_item.date BETWEEN ? AND ?
            GROUP BY review_item.id_item ,review_item.code,review_item.number_bill_new ORDER BY  review_item.number_bill_new  asc   ");

                    $stmt->execute(array($code, $from_date_stm, $to_date_stm));


                } else if ($date && $todate && $model && $category) {


                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);


                    $stmt = $this->db->prepare("SELECT review_item.*,review.crystal_bill,count(review_item.code) as number FROM `review_item` left join  review ON review.number_bill_new = review_item.number_bill_new  inner join {$table} on {$table}.id =review_item.id_item
              WHERE review.cancel=0 AND
              review_item.`table` ='{$table}'
              AND review_item.date BETWEEN ? AND ?  AND {$table}.id_cat IN({$ids_cat})  
            GROUP BY review_item.id_item ,review_item.code,review_item.number_bill_new ORDER BY  review_item.number_bill_new  asc   ");


                    $stmt->execute(array($from_date_stm, $to_date_stm));


                } else if ($date && $todate && $model) {


                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT review_item.*,review.crystal_bill,count(review_item.code) as number FROM `review_item` left join  review ON review.number_bill_new = review_item.number_bill_new  inner join {$table} on {$table}.id =review_item.id_item
              WHERE review.cancel=0 AND
              review_item.`table` ='{$table}'
              AND review_item.date BETWEEN ? AND ?
            GROUP BY review_item.id_item ,review_item.code,review_item.number_bill_new ORDER BY  review_item.number_bill_new  asc   ");

                    $stmt->execute(array($from_date_stm, $to_date_stm));


                } else if ($code && $model && $category) {

                    $code = $_GET['code'];

                    $stmt = $this->db->prepare("SELECT review_item.*,review.crystal_bill,count(review_item.code) as number FROM `review_item` left join  review ON review.number_bill_new = review_item.number_bill_new  inner join {$table} on {$table}.id =review_item.id_item
                  WHERE review.cancel=0 AND
                  review_item.`table` ='{$table}'
                 AND review_item.`code` =?  AND {$table}.id_cat IN({$ids_cat})  
                GROUP BY review_item.id_item ,review_item.code,review_item.number_bill_new ORDER BY  review_item.number_bill_new  asc   ");

                    $stmt->execute(array($code));


                } else if ($code && $model) {

                    $code = $_GET['code'];


                    $code = $_GET['code'];

                    $stmt = $this->db->prepare("SELECT review_item.*,review.crystal_bill,count(review_item.code) as number FROM `review_item` left join  review ON review.number_bill_new = review_item.number_bill_new  inner join {$table} on {$table}.id =review_item.id_item
                  WHERE review.cancel=0 AND
                  review_item.`table` ='{$table}'
                 AND review_item.`code` =?
                GROUP BY review_item.id_item ,review_item.code,review_item.number_bill_new ORDER BY  review_item.number_bill_new  asc   ");

                    $stmt->execute(array($code));


                } else if ($model && $category) {
                    $stmt = $this->db->prepare("SELECT review_item.*,review.crystal_bill,count(review_item.code) as number FROM `review_item` left join  review ON review.number_bill_new = review_item.number_bill_new  inner join {$table} on {$table}.id =review_item.id_item WHERE review.cancel=0 AND review_item.`table` ='{$table}'   GROUP BY review_item.id_item ,review_item.code,review_item.number_bill_new ORDER BY  review_item.number_bill_new  asc   ");

                    $stmt->execute();
                } else if ($model) {

                    $stmt = $this->db->prepare("SELECT review_item.*,review.crystal_bill,count(review_item.code) as number FROM `review_item` left join  review ON review.number_bill_new = review_item.number_bill_new  inner join {$table} on {$table}.id =review_item.id_item WHERE review.cancel=0 AND review_item.`table` ='{$table}'   AND {$table}.id_cat IN({$ids_cat})   GROUP BY review_item.id_item ,review_item.code,review_item.number_bill_new ORDER BY  review_item.number_bill_new  asc   ");
                    $stmt->execute();
                } else if ($code && $date && $todate) {

                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT review_item.*,review.crystal_bill,count(review_item.code) as number FROM `review_item` left join  review ON review.number_bill_new = review_item.number_bill_new  
                  WHERE review.cancel=0 AND
                   review_item.`code` =?
                 AND review_item.date BETWEEN ? AND ?
                GROUP BY review_item.id_item ,review_item.code,review_item.number_bill_new ORDER BY  review_item.number_bill_new  asc   ");
                    $stmt->execute(array($code, $from_date_stm, $to_date_stm));
                } else if ($date && $todate) {

                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);

                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT review_item.*,review.crystal_bill,count(review_item.code) as number FROM `review_item` left join  review ON review.number_bill_new = review_item.number_bill_new   
                  WHERE review.cancel=0 AND
                     review_item.date BETWEEN ? AND ?
                    GROUP BY review_item.id_item ,review_item.code,review_item.number_bill_new ORDER BY  review_item.number_bill_new  asc   ");
                    $stmt->execute(array($from_date_stm, $to_date_stm));

                } else if ($code) {
                    $code = $_GET['code'];
                    $stmt = $this->db->prepare("SELECT review_item.*,review.crystal_bill,count(review_item.code) as number FROM `review_item` left join  review ON review.number_bill_new = review_item.number_bill_new   
                  WHERE review.cancel=0 AND
                   review_item.`code` =?
                GROUP BY review_item.id_item ,review_item.code,review_item.number_bill_new ORDER BY  review_item.number_bill_new  asc   ");
                    $stmt->execute(array($code));
                }else
                {

                    $stmt = $this->db->prepare("SELECT review_item.*,review.crystal_bill,count(review_item.code) as number FROM `review_item` left join  review ON review.number_bill_new = review_item.number_bill_new  WHERE review.cancel=0   
                    GROUP BY review_item.id_item ,review_item.code,review_item.number_bill_new ORDER BY  review_item.number_bill_new  asc   ");
                    $stmt->execute();

                }


                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


                    $dat_table= $this->bast_it_item($row['table'],$row['id_item']);

                    $row['title']= $dat_table['title'] ;
                    if ($dat_table['bast_it'] == 1 )
                    {
                        $row['bast_it']= 'ننصح به' ;
                    }else
                    {
                        $row['bast_it']= '' ;
                    }

					if($row['table'] == 'product_savers'){
                        $name_device= $this->type_device_savers($row['id_item']);
                        $row['name_device'] = $name_device;
                    }else{
                        $row['name_device'] = '';
                    }
                    $row['price'] = number_format((int)$row['price_new']*(int)$row['number']  )  ;
                    $row['name_color'] = $row['color'];
                    $row['id_member_r'] = $row['id_customre'];
                    $row['enter_serial'] = '';
                    $row['account'] = $this->UserInfo($row['id_accountant']);
                    $row['type_bill'] = 'مرتجع';
                    $row['number_bill'] = $row['number_bill_new'];
                     $row['location']='';
                    $row['store_location']='';
                    $row['offers']= '';
                    $row['user_sale']='';
                    $row['price_type']=0;
                    $row['group_bill']='';
                    $row['edit_price']='0';
                    $row['id_prepared']='';
                    $row['user_direct']='';
                    $row['note_prepared']='';
                    $row['note']='';
                    $row['point']=$this->point($row['code'],$row['table']);

                    $data [] = $row;
                }


            }


            /*****************withdrawn*********************/
            if (in_array('withdrawn', $type)) {
                if ($code && $date && $todate && $model && $category) {


                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);


                    $stmt = $this->db->prepare("SELECT report_withdrawn.*, report_withdrawn.`category` as `table`,  report_withdrawn.quantity as number,{$color}.img as image   FROM `report_withdrawn`  inner join {$model} on {$model}.id =report_withdrawn.id_product inner join {$color} on {$color}.id_item = {$model}.id
                  WHERE 
                  report_withdrawn.`category` ='{$model}'
                  AND report_withdrawn.`code` =?
                  AND report_withdrawn.date BETWEEN ? AND ?   AND {$model}.id_cat IN({$ids_cat})  
                  GROUP BY report_withdrawn.id_product ,report_withdrawn.code,report_withdrawn.note ORDER BY  report_withdrawn.note  asc   ");

                    $stmt->execute(array($code, $from_date_stm, $to_date_stm));


                } else if ($code && $date && $todate && $model) {

                    $code = $_GET['code'];
                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);
                    $stmt = $this->db->prepare("SELECT report_withdrawn.*, report_withdrawn.`category` as `table`,    report_withdrawn.quantity as number,{$color}.img as image   FROM `report_withdrawn`  inner join {$model} on {$model}.id =report_withdrawn.id_product inner join {$color} on {$color}.id_item = {$model}.id
                  WHERE 
                  report_withdrawn.`category` ='{$model}'
                  AND report_withdrawn.`code` =?
                  AND report_withdrawn.date BETWEEN ? AND ?
                  GROUP BY report_withdrawn.id_product ,report_withdrawn.code,report_withdrawn.note ORDER BY  report_withdrawn.note  asc   ");

                    $stmt->execute(array($code, $from_date_stm, $to_date_stm));


                } else if ($date && $todate && $model && $category) {


                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT report_withdrawn.*, report_withdrawn.`category` as `table`,    report_withdrawn.quantity as number,{$color}.img as image   FROM `report_withdrawn`  inner join {$model} on {$model}.id =report_withdrawn.id_product inner join {$color} on {$color}.id_item = {$model}.id
                  WHERE 
                  report_withdrawn.`category` ='{$model}'
                  AND report_withdrawn.date BETWEEN ? AND ? 
                  GROUP BY report_withdrawn.id_product ,report_withdrawn.code,report_withdrawn.note ORDER BY  report_withdrawn.note  asc   ");


                    $stmt->execute(array($from_date_stm, $to_date_stm));


                } else if ($date && $todate && $model) {


                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);


                    $stmt = $this->db->prepare("SELECT report_withdrawn.*, report_withdrawn.`category` as `table`,    report_withdrawn.quantity as number,{$color}.img as image   FROM `report_withdrawn`  inner join {$model} on {$model}.id =report_withdrawn.id_product inner join {$color} on {$color}.id_item = {$model}.id
                  WHERE 
                  report_withdrawn.`category` ='{$model}'
                  AND report_withdrawn.date BETWEEN ? AND ?
                  GROUP BY report_withdrawn.id_product ,report_withdrawn.code,report_withdrawn.note ORDER BY  report_withdrawn.note  asc   ");

                    $stmt->execute(array($from_date_stm, $to_date_stm));


                } else if ($code && $model && $category) {

                    $code = $_GET['code'];


                    $stmt = $this->db->prepare("SELECT report_withdrawn.*, report_withdrawn.`category` as `table`,    report_withdrawn.quantity as number,{$color}.img as image   FROM `report_withdrawn`  inner join {$model} on {$model}.id =report_withdrawn.id_product inner join {$color} on {$color}.id_item = {$model}.id
                  WHERE 
                  report_withdrawn.`category` ='{$model}'
                  AND report_withdrawn.`code` =?  AND {$model}.id_cat IN({$ids_cat})  
                  GROUP BY report_withdrawn.id_product ,report_withdrawn.code,report_withdrawn.note ORDER BY  report_withdrawn.note  asc   ");


                    $stmt->execute(array($code));


                } else if ($code && $model) {


                    $code = $_GET['code'];


                    $stmt = $this->db->prepare("SELECT report_withdrawn.*, report_withdrawn.`category` as `table`,   report_withdrawn.quantity as number,{$color}.img as image   FROM `report_withdrawn`  inner join {$model} on {$model}.id =report_withdrawn.id_product inner join {$color} on {$color}.id_item = {$model}.id
                  WHERE 
                  report_withdrawn.`category` ='{$model}'
                  AND report_withdrawn.`code` =?
                  GROUP BY report_withdrawn.id_product ,report_withdrawn.code,report_withdrawn.note ORDER BY  report_withdrawn.note  asc   ");

                    $stmt->execute(array($code));


                } else if ($model && $category) {


                    $stmt = $this->db->prepare("SELECT report_withdrawn.*, report_withdrawn.`category` as `table`,    report_withdrawn.quantity as number,{$color}.img as image   FROM `report_withdrawn`  inner join {$model} on {$model}.id =report_withdrawn.id_product inner join {$color} on {$color}.id_item = {$model}.id
                  WHERE 
                  report_withdrawn.`category` ='{$model}'  AND {$model}.id_cat IN({$ids_cat})  
                  GROUP BY report_withdrawn.id_product ,report_withdrawn.code,report_withdrawn.note ORDER BY  report_withdrawn.note  asc   ");

                    $stmt->execute();
                } else if ($model) {

                  $stmt = $this->db->prepare("SELECT report_withdrawn.*, report_withdrawn.`category` as `table`,    report_withdrawn.quantity as number,{$color}.img as image   FROM `report_withdrawn`  inner join {$model} on {$model}.id =report_withdrawn.id_product inner join {$color} on {$color}.id_item = {$model}.id
                  WHERE 
                  report_withdrawn.`category` ='{$model}'
                  GROUP BY report_withdrawn.id_product ,report_withdrawn.code,report_withdrawn.note ORDER BY  report_withdrawn.note  asc   ");

                  $stmt->execute();
                } else if ($code && $date && $todate) {


                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);
                    $to_date_stm = strtotime($todate);


                    $code = $_GET['code'];


                    $stmt = $this->db->prepare("SELECT report_withdrawn.*, report_withdrawn.`category` as `table`,    report_withdrawn.quantity as number  FROM `report_withdrawn`   
                  WHERE 
                   report_withdrawn.`code` =?
                  AND report_withdrawn.date BETWEEN ? AND ?
                  GROUP BY report_withdrawn.id_product ,report_withdrawn.code,report_withdrawn.note ORDER BY  report_withdrawn.note  asc   ");

                    $stmt->execute(array($code, $from_date_stm, $to_date_stm));
                } else if ($date && $todate) {

                    $date = $_GET['date'];
                    $todate = $_GET['todate'];

                    $from_date_stm = strtotime($date);

                    $to_date_stm = strtotime($todate);

                    $stmt = $this->db->prepare("SELECT report_withdrawn.*, report_withdrawn.`category` as `table`,    report_withdrawn.quantity as number   FROM `report_withdrawn` 
                  WHERE 
                
                    report_withdrawn.date BETWEEN ? AND ?
                  GROUP BY report_withdrawn.id_product ,report_withdrawn.code,report_withdrawn.note ORDER BY  report_withdrawn.note  asc   ");

                    $stmt->execute(array($from_date_stm, $to_date_stm));

                } else if ($code) {
                    $code = $_GET['code'];


                  $stmt = $this->db->prepare("SELECT report_withdrawn.*, report_withdrawn.`category` as `table`,    report_withdrawn.quantity as number    FROM `report_withdrawn` 
                  WHERE    
                  report_withdrawn.`code` =?
                  GROUP BY report_withdrawn.id_product ,report_withdrawn.code,report_withdrawn.note ORDER BY  report_withdrawn.note  asc   ");

                    $stmt->execute(array($code));
                }else
                {

                    $stmt = $this->db->prepare("SELECT report_withdrawn.*, report_withdrawn.`category` as `table`,    report_withdrawn.quantity as number    FROM `report_withdrawn` 
                  WHERE 1   
                  GROUP BY report_withdrawn.id_product ,report_withdrawn.code,report_withdrawn.note ORDER BY  report_withdrawn.note  asc   ");

                    $stmt->execute();
                }

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


                    if (empty($model))
                    {
                        if ($row['category']=='mobile') {
                            $color = 'color';
                            $codee = 'code';
                        }else  {
                            $color = 'color_'.$row['category'];
                            $codee = 'code_'.$row['category'];
                        }
                        if ($row['category']=='accessories') {
                            $stmtc = $this->db->prepare("SELECT {$color}.color,{$color}.img FROM {$color}  WHERE {$color}.code=?");
                        }else
                        {
                            $stmtc = $this->db->prepare("SELECT {$color}.color,{$color}.img FROM {$codee} INNER JOIN {$color} ON {$color}.id={$codee}.id_color WHERE {$codee}.code=?");

                        }
                        $stmtc->execute(array($row['code']));
                        $result=$stmtc->fetch(PDO::FETCH_ASSOC);
                        $row['image'] = $result['img'];
                        $row['name_color'] = $result['color'];
                    }



                    $dat_table= $this->bast_it_item($row['category'],$row['id_product']);

                    $row['title']= $dat_table['title'] ;
                    if ($dat_table['bast_it'] == 1 )
                    {
                        $row['bast_it']= 'ننصح به' ;
                    }else
                    {
                        $row['bast_it']= '' ;
                    }
					if($row['table'] == 'product_savers'){
                        $name_device= $this->type_device_savers($row['id_item']);
                        $row['name_device'] = $name_device;
                    }else{
                        $row['name_device'] = '';
                    }

                    $row['price'] = 0;
                    $row['crystal_bill'] =$row['note'];
                    $row['id_member_r'] = '';
                    $row['enter_serial'] ='';
                    $row['number_bill'] =$row['note'];
                    $row['account'] = $this->UserInfo($row['userid']);
                    $row['type_bill'] = 'سحب';
                    $row['bast_it']=$this->bast_it_item($row['category'],$row['id_product']);
                    $row['store_location']=$this->store_location($row['location'],$row['category'],$row['code']);
                    $row['offers']= '';
                    $row['price_type']=0;
                    $row['crystal_bill']='';
                    $row['group_bill']='';
                    $row['edit_price']='0';
                    $row['id_prepared']='';
                    $row['user_direct']='';
                    $row['note_prepared']='';
                    $row['note']='';
                    $row['point']=$this->point($row['code'],$row['category']);

                    $data [] = $row;
                }

            }

        }


        require ($this->render($this->folder,'html','index','php'));
        $this->adminFooterController();
    }


    function get_crystal_bill($number_bill)

    {
        $stmt=$this->db->prepare("SELECT  crystal_bill  from   crystal_bill  WHERE  `number_bill` = ?  LIMIT 1");
        $stmt->execute(array($number_bill));
       if ($stmt->rowCount()>0)
       {
           $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $result['crystal_bill'];
       }else
       {
           return '';
       }
    }


    function bast_it_item($table,$id)

    {

        $stmt=$this->db->prepare("SELECT  bast_it,title from   {$table}  WHERE  `id` = ?   ");
        $stmt->execute(array($id));
           if ($stmt->rowCount()>0)
           {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }else
           {
               return array('title'=>'','bast_it'=>0);
           }
    }

 	function type_device_savers($id)

    {

        $stmt=$this->db->prepare("SELECT `id_device` from  `product_savers` WHERE  `id` = ?");
        $stmt->execute(array($id));
        $row =  $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt_name=$this->db->prepare("SELECT `title` from  `type_device` WHERE  `id` = ?");
        $stmt_name->execute(array($row['id_device']));
           if ($stmt_name->rowCount()>0)
           {
                $name = $stmt_name->fetch(PDO::FETCH_ASSOC);
                return  $name['title'];
            }else
           {
               return ' ';
           }
    }

	function getLoopIdX($id,$category)
	{

		$stmt=$this->db->prepare("SELECT *from  {$category} WHERE  `relid` = {$id} AND `active` = 1 ");
		$stmt->execute(array($id));
		while (  $s=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->ids[]=$s['id'];
			$this->getLoopIdX($s['id'],$category);

		}

	}

	function getLoopId($id,$category)
	{

		if (!empty($id))
		{
			$this->ids[]=$id;
		}

		$stmt=$this->db->prepare("SELECT *from  {$category} WHERE  `relid` = {$id} AND `active` = 1 ");
		$stmt->execute(array($id));
		while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{

			$this->ids[]=$row['id'];


			$this->getLoopIdX($row['id'],$category);
		}

		return $this->ids;
	}


	function getMainCatDB($model)
	{
		if ($this->handleLogin())
		{

			if ($model != 'savers')
			{
				$category='category_'.$model;
				$stmt=$this->db->prepare("SELECT *FROM {$category} WHERE  `relid` = 0 ");
				$stmt->execute();

				if ($stmt->rowCount() > 0)
				{

					$html="<select  name='category'  id='sub_cags_p'  class='custom-select col-md-3 mb-3 list_menu_categ' onchange='sub_catgs2(this)' >";
					$html.="<option value='' disabled  selected > اختر قسم  </option>"  ;

					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


						$html.="<option value='{$model}_{$row['id']}'   >{$row['title']}</option>"  ;

					}

					$html.='</select>';

					echo $html ;
				}


			}
		}

	}




	function sub_catgs($data)
	{
		if ($this->handleLogin())
		{

			$d=explode('_',$data);

			$model=$d[0];
			$id=$d[1];
			$c=0;
			if ($model != 'savers')
			{
				$category = 'category_' . $model;
				$stmt = $this->db->prepare("SELECT *FROM {$category} WHERE  `relid` = ? ");
				$stmt->execute(array($id));


				if ($stmt->rowCount() > 0) {

					$html = "<select name='category'  id='{$data}' class='custom-select col-md-3 mb-3 list_menu_categ' onchange='sub_catgs(this)' >";
					$html.="<option value='' disabled  selected > اختر قسم  </option>"  ;
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

						$html .= "<option value='{$model}_{$row['id']}'   >{$row['title']}</option>";

						$c++;
					}

					$html .= '</select> ';

					echo $html;

				}
			}
		}

	}


	function sub_catgs2($data)
	{
		if ($this->handleLogin())
		{

			$d=explode('_',$data);

			$model=$d[0];
			$id=$d[1];
			if ($model != 'savers')
			{
				$category = 'category_' . $model;
				$stmt = $this->db->prepare("SELECT *FROM {$category} WHERE  `relid` = ? ");
				$stmt->execute(array($id));


				if ($stmt->rowCount() > 0) {

					$html = "<select name='category'  id='{$data}'  class='custom-select col-md-3 mb-3 list_menu_categ' onchange='sub_catgs2(this)' > ";
					$html.="<option value='' disabled  selected > اختر قسم  </option>"  ;
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

						$html .= "<option value='{$model}_{$row['id']}'   >{$row['title']}</option>";

					}

					$html .= '</select>';

					echo $html;

				}
			}
		}

	}


    function sum_amount_mm($price_dollars,$dollar_exchange,$number)
    {


        $price = $this->price_dollarsAdmin($price_dollars, $dollar_exchange);
        $f1 = (int)trim(str_replace(',', '', $price));
        $price = $f1 * $number;
        return number_format($price);
    }




    function point($code,$model)
    {


        if ($model == 'product_savers') {



            $stmtc = $this->db->prepare("SELECT point FROM product_savers  WHERE  `code`=?");
            $stmtc->execute(array(trim($code)));
            if ($stmtc->rowCount() > 0) {
                $result = $stmtc->fetch(PDO::FETCH_ASSOC);
                return $result['point'];
            }
         }else if ($model == 'accessories')
        {

            $stmt = $this->db->prepare("SELECT   point FROM  color_accessories  WHERE   code=? LIMIT 1");
            $stmt->execute(array($code ));
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result['point'];

            }
        }else{


            if ($model=='mobile')
            {
               $table_code='code';
            }else
            {
                $table_code='code_'.$model;
            }

            $stmt = $this->db->prepare("SELECT  point FROM {$table_code}  WHERE  `code`=? LIMIT 1");
            $stmt->execute(array(trim($code)));
            if ($stmt->rowCount() > 0) {

                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result['point'];
            }

        }

    }


//
//    function store_location($location,$model,$code)
//    {
//
//        if ($model =='product_savers')
//        {
//            $model='savers';
//        }
//
//
//
//        $stmt=$this->db->prepare('SELECT  *FROM location WHERE location=? AND model=? AND code = ? LIMIT 1');
//        $stmt->execute(array(trim($location),trim($model),$code));
//        if ($stmt->rowCount() > 0)
//        {
//            $result=$stmt->fetch(PDO::FETCH_ASSOC);
//            $stmt_sequence=$this->db->prepare("SELECT title FROM group_location WHERE  {$result['sequence']} between `from` AND  `to`     LIMIT 1");
//            $stmt_sequence->execute();
//            if ($stmt_sequence->rowCount() > 0)
//            {
//                $group=$stmt_sequence->fetch(PDO::FETCH_ASSOC);
//                return $group['title'];
//            }else{
//                return 'لم يتم تحديد مجموعة للمستودعات';
//
//            }
//        }else
//        {
//            return  "الموقع  " .$location. "  غير موجود من ضمن مواقع الباركود ";
//        }
//    }
//
//
//

}