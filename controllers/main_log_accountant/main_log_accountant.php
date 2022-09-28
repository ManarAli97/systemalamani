<?php


class main_log_accountant extends Controller
{

    public $ids = array();


    function __construct()
    {
        parent::__construct();
        $this->discount = 'discount';
        $this->table ='total_accountants';
        $this->setting = new Setting();


    }


    public function createTB()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `username` varchar(250) COLLATE utf8_unicode_ci NOT NULL  DEFAULT '0',   
           `id_account` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',   
           `bill_sale` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',   
           `number_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',   
           `secondary_accountants` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',   
           `minus_customer` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',   
           `review_to_customer` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',   
           `amount_from_clipping` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',   
           `amount_to_clipping` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',   
           `bill_purchase` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',   
           `active` int(10) NOT NULL DEFAULT '0',
           `lang` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           `normal_date` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return  $this->db->cht(array($this->table));

    }


    public function index2()
    {


        $stmt_groups =$this->db->prepare("SELECT *FROM `usergroup` WHERE    (`name` LIKE '%محاسب%' OR `name` LIKE '%محاسبين%' OR `name` LIKE '%المحاسبين%')  ");
        $stmt_groups->execute();
        if ($stmt_groups->rowCount() > 0)
        {
            $result_g=$stmt_groups->fetch(PDO::FETCH_ASSOC);


        $stmt =$this->db->prepare("SELECT *FROM  `user` WHERE  `idGroup`  = ? ");
        $stmt->execute(array($result_g['id']));
        $user=array();

        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $row['money']= $this->account_billAll2($row['id']);
            $row['number_bill']= $this->number_billAll2($row['id']);
            $row['sum_discount']= $this->sum_discount2($row['id']);
            $row['sum_rewind']= $this->sum_rewind2($row['id']);
            $row['addMoney_clipper']= $this->addOrWithdrawMoney2($row['id'],0);
            $row['withdrawMoney_clipper']= $this->addOrWithdrawMoney2($row['id'],1);
            $row['pur_cust']= $this->sumbillDate2($row['id']);

            $user[]=  $row ;

        }

/*
        foreach ($user as $data)
        {

           $stmt= $this->db->prepare("INSERT INTO {$this->table} (
                   username,
                   id_account,
                   bill_sale,
                   number_bill,
                   secondary_accountants,
                   minus_customer,
                   review_to_customer,
                   amount_from_clipping,
                   amount_to_clipping,
                   bill_purchase,
                   userId,
                   date
                   ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array(
                $data['username'],
                $data['id'],
                $data['money'],
                $data['number_bill'],
                $data['sum_discount'],
                0,
                $data['sum_rewind'],
                $data['addMoney_clipper'],
                $data['withdrawMoney_clipper'],
                $data['pur_cust'],
                $this->userid,
                time()

            ));
        }

        echo 'done';
        */
        } else

        {
            die('لا يوجد مجموعة محاسبين');
        }


    }


    public function index()
    {
        $this->checkPermit('main_log_accountant', 'main_log_accountant');
        $this->adminHeaderController($this->langControl('main_log_accountant'));



            $stmt = $this->db->prepare("SELECT * from `total_accountants`   ");
            $stmt->execute();
          $user =array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {

                $plus=(int)$row['bill_sale'] + (int)$row['secondary_accountants'] + (int)$row['amount_from_clipping'];
                $minus=(int)$row['minus_customer'] + (int)$row['review_to_customer'] + (int)$row['amount_to_clipping'] + (int)$row['bill_purchase'];

                $row['sum']=$plus - $minus;
                $user[]=$row;

            }







        require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();
    }


    public function search()
    {
        $this->checkPermit('main_log_accountant', 'main_log_accountant');
        $this->adminHeaderController($this->langControl('main_log_accountant'));



        $date=null;
        $todate=null;

        if (isset($_GET['date'])&&isset($_GET['todate']))
        {
            $date=$_GET['date'];
            $todate=$_GET['todate'];
        }else{
			$date =  date('Y-m-d', time());
			$todate = date('Y-m-d',strtotime('+1 day',time()));
		}

        $stmt_groups =$this->db->prepare("SELECT *FROM `usergroup` WHERE    (`name` LIKE '%محاسب%' OR `name` LIKE '%محاسبين%' OR `name` LIKE '%المحاسبين%')  ");
        $stmt_groups->execute();
        if ($stmt_groups->rowCount() > 0)
        {
            $result_g=$stmt_groups->fetch(PDO::FETCH_ASSOC);


        $stmt =$this->db->prepare("SELECT *FROM  `user` WHERE  `idGroup`  = ? ");
        $stmt->execute(array($result_g['id']));
        $user=array();
			$money_clipper=new money_clipper();
			$purc=new purchase_customer();
			$account=new Accountant();
            while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
            {
                $row['money']= $this->account_billAll($row['id'],$date,$todate);
                $row['number_bill']= $this->number_billAll($row['id'],$date,$todate);
                $row['sum_discount']= $this->sum_discount($row['id'],$date,$todate);
                $row['sum_rewind']= $this->sum_rewind($row['id'],$date,$todate);
                $row['addMoney_clipper']= $money_clipper->addOrWithdrawMoney($row['id'],0,strtotime($date),strtotime($todate));
                $row['withdrawMoney_clipper']= $money_clipper->addOrWithdrawMoney($row['id'],1,strtotime($date),strtotime($todate));
                $row['pur_cust']= $purc->sumbillDate($row['id'],strtotime($date),strtotime($todate));

                if (isset($_GET['date'])&&isset($_GET['todate']))
                {
                    $plus=(int)str_replace($this->comma,'',$row['money'])+ (int)str_replace($this->comma,'',$row['sum_discount'])+  (int)str_replace($this->comma,'',$row['addMoney_clipper']);
                    $muns=(int)str_replace($this->comma,'',$row['sum_rewind']) +(int)str_replace($this->comma,'',$row['withdrawMoney_clipper']) +(int)str_replace($this->comma,'',$row['withdrawMoney_clipper']) +(int)str_replace($this->comma,'',$row['pur_cust'])  ;
                    $row['sum']=number_format($plus - $muns);
                    //$row['sum']=number_format( (((((int)(str_replace($this->comma,'',$row['money'])) + (int)(str_replace($this->comma,'',$this->sum_discount($row['id'],$date,$todate)))) - (int)str_replace($this->comma,'',$this->sum_rewind($row['id'],$date,$todate))+$row['addMoney_clipper'])-$row['withdrawMoney_clipper']) -(int)$row['pur_cust'])-(int)$account->bill_minus($row['id'],$date,$todate));
                }else
                {
                    $row['sum']=    $account->billAcount_money_clipper($row['id']);

                }


                $user[]=  $row ;
            }

        } else

        {
            die('لا يوجد مجموعة محاسبين');
        }




        require($this->render($this->folder, 'html', 'search', 'php'));
        $this->adminFooterController();
    }



    function account_billAll($id,$date=null,$todate=null)
    {

        if ($date==null)
        {


            $stmt =$this->db->prepare("SELECT   `number_bill`  FROM  `cart_shop_active` WHERE  `user_id`  = ?  AND  `accountant` = 1   AND cancel=0 GROUP BY `number_bill` ");
            $stmt->execute(array($id));

        }else
        {
            $fromDate=strtotime($date);
            $toDate= strtotime($todate);


            $stmt =$this->db->prepare("SELECT   `number_bill`  FROM  `cart_shop_active` WHERE  `user_id`  = ?  AND  `accountant` = 1  AND cancel=0 AND `date_accountant`  between ? AND ? GROUP BY `number_bill` ");
            $stmt->execute(array($id,$fromDate,$toDate));


        }



        $SumPrice=0;
        while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC))
        {


            $stmt2=$this->getAllContentFromCar_byNomberBill($id,$row1['number_bill']);

            $price1=0;
            $p1=0;
            $p2=0;
            $xp1=0;
            $xp2=0;
            while ($row = $stmt2->fetch(PDO::FETCH_ASSOC))
            {

				if (!empty($this->cuts($row['id_item'],$row['table']))) {

					$price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
					$f1 = (double)trim(str_replace($this->comma, '', $price[0]));
					$xp1 = $xp1 + ($f1 * $row['number']);
					$price1= (int)$xp1;

				}else {
					$price =$this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']);
					$f1 = (int)trim(str_replace($this->comma, '', $price));
					$xp1 = $xp1 + ($f1 * $row['number']);
					$price1= (int)$xp1;

				}


			}

            $SumPrice=$SumPrice+$price1;
        }


        return number_format($SumPrice);


    }

	function account_All_bill_Without_date($id)
	{

			$stmt =$this->db->prepare("SELECT   `number_bill`  FROM  `cart_shop_active` WHERE  `user_id`  = ?  AND  `accountant` = 1   AND cancel=0 GROUP BY `number_bill` ");
			$stmt->execute(array($id));


		$SumPrice=0;
		while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC))
		{


			$stmt2=$this->getAllContentFromCar_byNomberBill($id,$row1['number_bill']);

			$price1=0;
			$p1=0;
			$p2=0;
			$xp1=0;
			$xp2=0;
			while ($row = $stmt2->fetch(PDO::FETCH_ASSOC))
			{

				if (!empty($this->cuts($row['id_item'],$row['table']))) {

					$price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
					$f1 = (double)trim(str_replace($this->comma, '', $price[0]));
					$xp1 = $xp1 + ($f1 * $row['number']);
					$price1= (int)$xp1;

				}else {
					$price =$this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']);
					$f1 = (int)trim(str_replace($this->comma, '', $price));
					$xp1 = $xp1 + ($f1 * $row['number']);
					$price1= (int)$xp1;

				}


			}

			$SumPrice=$SumPrice+$price1;
		}


		return (int)str_replace($this->comma,'',$SumPrice);


	}




	public function getAllContentFromCar_byNomberBill($id_user,$n_b)
    {
        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx`,`number_bill`,`top`,`dollar_exchange` FROM `cart_shop_active` WHERE `user_id` =? AND `number_bill`=?  AND   `accountant`=1 AND cancel=0 GROUP BY `id_item`,`table`,`code`,`color` ORDER BY `id` DESC  ");
        $stmt->execute(array($id_user,$n_b));
        return $stmt;
    }



    function number_billAll($id,$date,$todate)
    {


        if ($date==null)
        {
            $stmt =$this->db->prepare("SELECT COUNT(`number_bill`) as number_bill FROM  `bill` WHERE  `userid_accountant`  = ? AND `sum_bill` <> 0 ");
            $stmt->execute(array($id));
        }else
        {
            $fromDate=strtotime($date);
            $toDate= strtotime($todate);

            $stmt =$this->db->prepare("SELECT COUNT(`number_bill`) as number_bill FROM  `bill` WHERE  `userid_accountant`  = ? AND `sum_bill` <> 0  AND `date`  between ? AND ?");
            $stmt->execute(array($id,$fromDate,$toDate));

        }

        $result=$stmt->fetch(PDO::FETCH_ASSOC);
         return $result['number_bill'];
    }



    function sum_discount($id,$date,$todate)
    {


        if ($date==null)
        {
            $stmt =$this->db->prepare("SELECT SUM(`money`) as money FROM  `discount` WHERE  `to_id_user`  = ? ");
            $stmt->execute(array($id));
        }else
        {
            $fromDate=strtotime($date);
            $toDate= strtotime($todate);

            $stmt =$this->db->prepare("SELECT SUM(`money`) as money FROM  `discount` WHERE  `to_id_user`  = ? AND `date`  between ? AND ?");
            $stmt->execute(array($id,$fromDate,$toDate));

        }

        $result=$stmt->fetch(PDO::FETCH_ASSOC);
         return number_format($result['money']);
    }

    function sum_rewind($id,$date,$todate)
    {


        if ($date==null)
        {

			$stmt = $this->db->prepare("SELECT  SUM(`money`) as money    FROM `review` WHERE  id_accountant=? ");
			$stmt->execute(array($id));

		}else
        {
            $fromDate=strtotime($date);
            $toDate= strtotime($todate);

			$rewind = 0;
			$stmt = $this->db->prepare("SELECT  SUM(`money`) as money    FROM `review` WHERE  id_accountant=? AND  `date` BETWEEN ? AND  ? ");
			$stmt->execute(array($id,$fromDate,$toDate));
		}

        $result=$stmt->fetch(PDO::FETCH_ASSOC);
         return number_format($result['money']);
    }


    function getUser($id,$id_user)
    {
        if ($this->handleLogin()) {
            $stmt = $this->db->prepare("SELECT * from `{$this->table}` WHERE `id`=? AND `id_user` = ? ");
            $stmt->execute(array($id,$id_user));
            if ($stmt->rowCount() > 0) {
                $data =$stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($data);
            } else {
                exit();
            }
        }


    }


    function log_discount($id)
    {

        $this->checkPermit('log_discount', 'main_log_accountant');
        $this->adminHeaderController($this->langControl('log_discount'));



        require($this->render($this->folder, 'html', 'discount', 'php'));
        $this->adminFooterController();
    }



    public function processing($id)
    {

        $table = $this->discount;
        $primaryKey = 'id';

        $columns = array(
            array('db' => 'to_username', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),

            array('db' => 'from_username', 'dt' =>1,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),

            array('db' => 'money', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return strip_tags(number_format($d));
                }
            ),

            array('db' => 'date', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d',$d);
                }
            ),

            array('db' => 'time', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return  date('h:i:s A',$d);
                }
            ),

        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"`to_id_user`={$id}")
        );

    }



    function bill($id)
    {
        $this->checkPermit('view_bill', 'main_log_accountant');
        $this->adminHeaderController($this->langControl('view_bill'));

        $stmt =$this->db->prepare("SELECT *FROM `user` WHERE  id=? ");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);

        $stmt_date_req_done=$this->getAllBillThisAccountant($id);
        $date_req_done=array();
        while ($row_d =$stmt_date_req_done->fetch(PDO::FETCH_ASSOC))
        {
            $row_d['sum']=0;
            $row_d[$row_d['number_bill']]=array();
            $row_d['customer_name']=$this->customer_name($row_d['id_member_r']);
            $stmt=$this->getAllContentFromCar_details_client_done($id,$row_d['number_bill']);
            $sum=0;
            $number_bill=0;
            $date_req=array();
            $price1=0;
            $date=0;
            $p1=0;
            $p2=0;
            $xp1=0;
            $xp2=0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {

				if (!empty($this->cuts($row['id_item'],$row['table']))) {

					$price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
					$f1 = (double)trim(str_replace($this->comma, '', $price[0]));
					$xp1 = $xp1 + ($f1 * $row['number']);
					$price1= (int)$xp1;

				}else {
					$price =$this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']);
					$f1 = (int)trim(str_replace($this->comma, '', $price));
					$xp1 = $xp1 + ($f1 * $row['number']);
					$price1= (int)$xp1;

				}


                $row_d['sum']=number_format($price1);

                $table=$row['table'];
                $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
                $stmt_get_item->execute(array($row['id_item']));
                $item = $stmt_get_item->fetch();

                $row['title']=$item['title'];
                $row['img']=$this->save_file.$row['image'];

                if ($row['table'] == 'medical_supplies') {

                    $stmt_id_catg_c = $this->db->prepare("SELECT `id_cat` FROM `medical_supplies` WHERE `id` = ?  LIMIT 1");
                    $stmt_id_catg_c->execute(array($row['id_item']));
                    $id_catgC=$stmt_id_catg_c->fetch(PDO::FETCH_ASSOC)['id_cat'];

                    $stmt_id_catg_title = $this->db->prepare("SELECT `title` FROM `medical_supplies` WHERE `id` = ?  LIMIT 1");
                    $stmt_id_catg_title->execute(array($id_catgC));

                    $row['title']=$stmt_id_catg_title->fetch(PDO::FETCH_ASSOC)['title'] .'  -  '. $item['title']  ;

                    $row['price']= $row['price']. ' د.ع ';
                    $row['color_name']='';
                }



                if ($row['table'] == 'mobile') {
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `color` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];


                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);


                    if (!empty($this->cuts($row['id_item'],$row['table'])))
                {
                    $row['price']=  $this->cuts($row['id_item'],$row['table']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }


                }


                if ($row['table'] == 'camera') {
                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_camera`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

           if (!empty($this->cuts($row['id_item'],$row['table'])))
                {
                    $row['price']=  $this->cuts($row['id_item'],$row['table']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }



                }



                if ($row['table'] == 'printing_supplies') {
                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_printing_supplies`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

           if (!empty($this->cuts($row['id_item'],$row['table'])))
                {
                    $row['price']=  $this->cuts($row['id_item'],$row['table']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }



                }


                if ($row['table'] == 'computer') {
                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_computer`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

           if (!empty($this->cuts($row['id_item'],$row['table'])))
                {
                    $row['price']=  $this->cuts($row['id_item'],$row['table']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }



                }



                if ($row['table'] == 'games') {
                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_games`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

           if (!empty($this->cuts($row['id_item'],$row['table'])))
                {
                    $row['price']=  $this->cuts($row['id_item'],$row['table']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }


                }


                if ($row['table'] == 'network') {

                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_network`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

           if (!empty($this->cuts($row['id_item'],$row['table'])))
                {
                    $row['price']=  $this->cuts($row['id_item'],$row['table']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }




                }



                if ($row['table'] == 'accessories') {


                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_accessories`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

           if (!empty($this->cuts($row['id_item'],$row['table'])))
                {
                    $row['price']=  $this->cuts($row['id_item'],$row['table']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }

                }


                if ($row['table'] == 'product_savers') {

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_savers`  WHERE  `code`=? ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);
                    $row['color_name']=$row['name_color'];
                    if (!empty($this->cuts($row['id_item'],$row['table'])))
                {
                    $row['price']=  $this->cuts($row['id_item'],$row['table']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }

                }


                $row_d[$row_d['number_bill']][]=$row;
            }


            $date_req_done[]=$row_d;

        }


        require($this->render($this->folder, 'html', 'bill', 'php'));
        $this->adminFooterController();
    }



    public function getAllBillThisAccountant($id)
    {
        $stmt = $this->db->prepare("SELECT  `date_req`,`date_d_r`,`id_member_r`,`delivery_user`,`number_bill` ,`dollar_exchange` FROM `cart_shop_active` WHERE `id_accountant_user` =?  AND  `accountant`=1 AND cancel=0 GROUP BY `number_bill`   ORDER BY `id` DESC ");

        $stmt->execute(array($id));
        return $stmt;
    }


    public function getAllContentFromCar_details_client_done($id,$number_bill)
    {
        $stmt = $this->db->prepare("SELECT  cart_shop_active.*,SUM(`number`)as number  FROM `cart_shop_active` WHERE `id_accountant_user` =?  AND   `accountant` = 1   AND cancel=0   AND `number_bill`= ? AND cancel=0 GROUP BY `id_item`,`table`,`code`,`number_bill`  ORDER BY `id` DESC  ");
        $stmt->execute(array($id,$number_bill));
        return $stmt;
    }


    function customer_name($id)
    {
        $stmt =$this->db->prepare("SELECT *FROM `register_user` WHERE  id=? ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $result['name'];
        }else
        {
            return 'زبون غير معروف';

        }
    }




    function account_billAll2($id)
    {

            $stmt =$this->db->prepare("SELECT   `number_bill`  FROM  `cart_shop_active` WHERE  `user_id`  = ?  AND  `accountant` = 1   AND cancel=0 GROUP BY `number_bill` ");
            $stmt->execute(array($id));



        $SumPrice=0;
        while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC))
        {


            $stmt2=$this->getAllContentFromCar_byNomberBill($id,$row1['number_bill']);

            $price1=0;
            $p1=0;
            $p2=0;
            $xp1=0;
            $xp2=0;
            while ($row = $stmt2->fetch(PDO::FETCH_ASSOC))
            {

                if (!empty($this->cuts($row['id_item'],$row['table']))) {

                    $price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
                    $f1 = (double)trim(str_replace($this->comma, '', $price[0]));
                    $xp1 = $xp1 + ($f1 * $row['number']);
                    $price1= (int)$xp1;

                }else {
                    $price =$this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']);
                    $f1 = (int)trim(str_replace($this->comma, '', $price));
                    $xp1 = $xp1 + ($f1 * $row['number']);
                    $price1= (int)$xp1;

                }


            }

            $SumPrice=$SumPrice+$price1;
        }


        return  str_replace($this->comma,'',trim($SumPrice));


    }


    function number_billAll2($id)
    {

        $stmt =$this->db->prepare("SELECT COUNT(`number_bill`) as number_bill FROM  `bill` WHERE  `userid_accountant`  = ? AND `sum_bill` <> 0 ");
        $stmt->execute(array($id));

        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return  str_replace($this->comma,'',trim($result['number_bill']));
    }


    function sum_discount2($id)
    {


            $stmt =$this->db->prepare("SELECT SUM(`money`) as money FROM  `discount` WHERE  `to_id_user`  = ? ");
            $stmt->execute(array($id));


        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return str_replace($this->comma,'',trim($result['money']));
    }


    function sum_rewind2($id)
    {


        $stmt = $this->db->prepare("SELECT  SUM(`money`) as money    FROM `review` WHERE  id_accountant=? ");
        $stmt->execute(array($id));

        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        if ($result['money'] > 0)
        {
            return  str_replace($this->comma,'',trim($result['money']));

        }else
        {
            return  0;
        }
    }



    function addOrWithdrawMoney2($id,$flag)
    {

        $stmt = $this->db->prepare("SELECT SUM(money) as money FROM money_clipper_main_user WHERE  `id_user`=? AND `flag`= ?  ");
        $stmt->execute(array($id,$flag));
        if ($stmt->rowCount() > 0)
        {
            $money_clipper = $stmt->fetch(PDO::FETCH_ASSOC);
            return  str_replace($this->comma,'',trim($money_clipper['money']));
        }else
        {
            return 0;
        }


    }

    function sumbillDate2($id)
    {

        $stmt = $this->db->prepare("SELECT *FROM purchase_customer_bill WHERE userid=? AND active=1  ");
        $stmt->execute(array($id));
        $sum = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


            $stmtsum = $this->db->prepare("SELECT *FROM purchase_customer_item WHERE  id_bill=? AND id_customer=? AND number_bill=?");
            $stmtsum->execute(array($row['id'], $row['id_customer'], $row['number_bill']));

            while ($rowsum = $stmtsum->fetch(PDO::FETCH_ASSOC)) {
                $s = (int)$rowsum['quantity'] * (int)$rowsum['price_purchase'];
                $sum = (int)$sum + (int)$s;
            }
        }

        return  str_replace($this->comma,'',trim($sum));


    }



}









