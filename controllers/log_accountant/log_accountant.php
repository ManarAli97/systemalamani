<?php


class log_accountant extends Controller
{

    public $ids = array();


    function __construct()
    {
        parent::__construct();
        $this->table = 'log_accountant';
        $this->log_accountant_bill = 'log_accountant_bill';
        $this->discount = 'discount';
        $this->setting = new Setting();
        $this->f=null;
        $this->t=null;
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `username` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `id_user` int(10) NOT NULL,
          `money` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->log_accountant_bill}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `username` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `id_user` int(10) NOT NULL ,
          `money` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `number_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->discount}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `from_username` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `from_id_user` int(10) NOT NULL ,
          `to_username` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `to_id_user` int(10) NOT NULL ,
          `money` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT 0,
          `time` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT 0,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table,$this->log_accountant_bill,$this->discount));

    }




    public function index($id=null)
    {
        $this->checkPermit('log_accountant', 'log_accountant');
        $this->adminHeaderController($this->langControl('log_accountant'));


//        if ($this->admin($this->userid))
//		{

		$stmt_groups =$this->db->prepare("SELECT *FROM `usergroup` WHERE  (`name` LIKE '%محاسب%' OR `name` LIKE '%محاسبين الرئيسيين%')  ");
		$stmt_groups->execute();
		$rg=$stmt_groups->fetch(PDO::FETCH_ASSOC);

		$stmtu =$this->db->prepare("SELECT *FROM  `user` WHERE  `idGroup`  = ? ");
		$stmtu->execute(array($rg['id']));
		$user=array();
		while ($row=$stmtu->fetch(PDO::FETCH_ASSOC))
		{
			$user[]=$row;
		}
//
//	   }



        $date=null;
		$tDate=null;
		$recordFDate=null;
		$recordTDate=null;

        if (isset($_GET['date']) && isset($_GET['toDate']))
        {
            $date=$_GET['date'];
			$tDate=$_GET['toDate'];


			$recordFDate=strtotime($date);
			$recordTDate= strtotime($tDate);

         }
        //else
//		{
//			$date =  date('Y-m-d', time());
//			$tDate = date('Y-m-d',strtotime('+1 day',time()));
//		}

//        if (empty($id))
//		{
//			$id=$this->userid;
//		}

		$allMoney=0;
		$allMoney_from_star=0;
        if ($date!=null &&  $tDate!=null) {



          $fromDate=strtotime($date);
          $toDate= strtotime($tDate);


            $my = 0;
            $stmt1 = $this->db->prepare("SELECT  SUM(`money`) as money FROM `discount`  WHERE `to_id_user` =? AND `date` BETWEEN ? AND  ? ");
            $stmt1->execute(array($id,$fromDate,$toDate));
            if ($stmt1->rowCount() > 0) {
                $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                $my = $result1['money'];
            }




            $accountant = new Accountant();
            $acc = str_replace($this->comma, '', $accountant->sumAllMoney($id,$fromDate,$toDate));


			$rewind = 0;
			$stmt2 = $this->db->prepare("SELECT  SUM(`money`) as money    FROM `review` WHERE  id_accountant=? AND  `date` BETWEEN ? AND  ? ");
			$stmt2->execute(array($id,$fromDate,$toDate));
			if ($stmt2->rowCount() > 0) {
				$result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
				$rewind = $result2['money'];
			}




				$allMoney=((int)$my+(int)$acc);

			$account=new Accountant();
			$allMoney_from_star=number_format((int)trim(str_replace($this->comma,'',$account->billAcount_money_clipper($id))));


		}



        require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();
    }


    public function processing($fromdate=null,$todate=null)
    {

        $table = $this->table;
        $primaryKey = 'id';

         $this->f=$fromdate;
        $this->t=$todate;
        $columns = array(
            array('db' => 'id_user', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }
            ),

            array('db' => 'money', 'dt' => 1,
                'formatter' => function ($d, $row) {
                 return number_format($d+$this->sumDiscount($row[0])) .' د.ع ';
                }
            ),
            array('db' => 'id_user', 'dt' =>2,
                'formatter' => function ($d, $row) {

                 return  number_format($this->sumDiscount($d)).'   د.ع '  ;
                }
            ),
            array('db' => 'id_user', 'dt' =>3,
                'formatter' => function ($d, $row) {

                 return  number_format($this->sumAddFromMoney_clipper($d,0)).'   د.ع '  ;
                }
            ),
            array('db' => 'id_user', 'dt' =>4,
                'formatter' => function ($d, $row) {

                 return  number_format($this->sumAddFromMoney_clipper($d,1)).'   د.ع '  ;
                }
            ),
            array('db' => 'id_user', 'dt' =>5,
                'formatter' => function ($d, $row) {
                    $purc=new purchase_customer();
                 return  number_format($purc->sumbillall($d) ).'   د.ع '  ;
                }
            ),
            array('db' => 'id_user', 'dt' =>6,
                'formatter' => function ($d, $row) {
                 return  number_format($this->sum_rewind2($d) ).'   د.ع '  ;
                }
            ),
			array('db' => 'money', 'dt' => 7,
				'formatter' => function ($d, $row) {



                    $purc=new purchase_customer();
                     $pc=$purc->sumbillall($row[0]) ;
                     $in=(int)$d+(int)$this->sumDiscount($row[0])+$this->sumAddFromMoney_clipper($d,0);
                     $out=(int)$this->sumDiscount($row[0])+(int)$this->sumAddFromMoney_clipper($row[0],1)+(int)$pc+$this->sum_rewind2($row[0]);

					 return  number_format($in - $out ) .' د.ع ';


				}
			),

            array(
                'db' => 'id_user',
                'dt' => 8,
                'formatter' => function ($id, $row) {
                    return "
 
                   <div style='text-align: center;font-size: 23px;'>
                    <a class='btn btn-warning' href=" . url .'/'.$this->folder."/bill/$id>  {$this->number_billAll($id)} </a>
                    </div> ";
                }
            ),


            array(
                'db' => 'id',
                'dt' => 9,
                'formatter' => function ($id, $row) {
                    if ($this->permit('disaccount', 'log_accountant')) {


						return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'   data-toggle='modal' data-target='#exampleModal_edit' data-id='{$id}' data-id_user='{$row[11]}' data-money='{$row[13]}'   >
                    <i class='fa fa-edit' aria-hidden='true'></i> 
                         </button>
                    </div>
                  
                    ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
			array(
				'db' => 'id_user',
				'dt' => 10,
				'formatter' => function ($id, $row) {
					return "
 
                   <div style='text-align: center;'>
                    <a href=" . url .'/'.$this->folder."/log_discount/$id>  سجل السحب </a>
                    </div> ";
				}
			),
            array('db' => 'id_user', 'dt' =>11),
            array('db' => 'id', 'dt' => 12),
			array('db' => 'money', 'dt' => 13)



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
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
        );

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






    public function search($id=null)
    {
        $this->checkPermit('search', 'log_accountant');
        $this->adminHeaderController($this->langControl('log_accountant'));


//        if ($this->admin($this->userid))
//		{

		$stmt_groups =$this->db->prepare("SELECT *FROM `usergroup` WHERE  (`name` LIKE '%محاسب%' OR `name` LIKE '%محاسبين الرئيسيين%')  ");
		$stmt_groups->execute();
		$rg=$stmt_groups->fetch(PDO::FETCH_ASSOC);

		$stmtu =$this->db->prepare("SELECT *FROM  `user` WHERE  `idGroup`  = ? ");
		$stmtu->execute(array($rg['id']));
		$user=array();
		while ($row=$stmtu->fetch(PDO::FETCH_ASSOC))
		{
			$user[]=$row;
		}

//	   }
//
//        if (empty($id))
//        {
//            $id=$this->userid;
//        }



        $date=null;
		$tDate=null;
		$recordFDate=null;
		$recordTDate=null;

        if (isset($_GET['date']) && isset($_GET['toDate']))
        {
            $date=$_GET['date'];
			$tDate=$_GET['toDate'];


			$recordFDate=strtotime($date);
			$recordTDate= strtotime($tDate);

                         $user=array();

                        $purc=new purchase_customer();
                        $result_g=$stmt_groups->fetch(PDO::FETCH_ASSOC) ;
                        $stmt = $this->db->prepare("SELECT *FROM  `log_accountant`  ");
                        $stmt->execute(array($result_g['id']));
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                            $row['all_discount']= $this->sumDiscount($row['id_user']);
                            $row['all_money_bill']= $row['money']+$row['all_discount'];
                            $row['from_customers_bill_date']= $this->sunMoneyBill($row['id_user'],$recordFDate,$recordTDate);
                            $row['discount_date']= $this->sumDiscount_byDate($row['id_user'],$recordFDate,$recordTDate);

                            $row['sumAddFromMoney_clipper_all']= $this->sumAddFromMoney_clipper($row['id_user'],0);
                            $row['sumAddFromMoney_clipper_date']= $this->sumAddFromMoney_clipper($row['id_user'],0,$recordFDate,$recordTDate);

                            $row['sumDiscountFromMoney_clipper_all']= $this->sumAddFromMoney_clipper($row['id_user'],1);
                            $row['sumDiscountFromMoney_clipper_date']= $this->sumAddFromMoney_clipper($row['id_user'],1,$recordFDate,$recordTDate);

                            $row['purchase_customer_all']= $purc->sumbillall($row['id_user']);
                            $row['purchase_customer_date']= $purc->sumbillDate($row['id_user'],$recordFDate,$recordTDate);


                            $row['sumAll']= ($row['all_money_bill'] + $row['sumAddFromMoney_clipper_all']) - ($row['all_discount']+$row['purchase_customer_all']+$row['sumDiscountFromMoney_clipper_all'])  ;
                            $row['sumDate']= ($row['from_customers_bill_date'] + $row['sumAddFromMoney_clipper_date']) - ($row['discount_date']+$row['purchase_customer_date']+$row['sumDiscountFromMoney_clipper_date'])  ;

                            $row['sumbill']=  $this->number_billAll($row['id_user'])   ;
                            $row['sumbill_date']=  $this->number_billAll($row['id_user'],$recordFDate,$recordTDate)   ;


                        $user[] = $row;
                    }

        }



        require($this->render($this->folder, 'html', 'search', 'php'));
        $this->adminFooterController();
    }

/*
    public function processing_search($fromdate=null,$todate=null)
    {

        $table = $this->table;
        $primaryKey = 'id';

         $this->f=$fromdate;
        $this->t=$todate;
        $columns = array(
            array('db' => 'id_user', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }
            ),

            array('db' => 'money', 'dt' => 1,
                'formatter' => function ($d, $row) {
                 return number_format($d+$this->sumDiscount($row[0])) .' د.ع ';
                }
            ),
            array('db' => 'id_user', 'dt' =>2,
                'formatter' => function ($d, $row) {

                 return  number_format($this->sumDiscount($d)).'   د.ع '  ;
                }
            ),
            array('db' => 'id_user', 'dt' =>3,
                'formatter' => function ($d, $row) {

                 return  number_format($this->sumAddFromMoney_clipper($d,0,$this->f,$this->t)).'   د.ع '  ;
                }
            ),
            array('db' => 'id_user', 'dt' =>4,
                'formatter' => function ($d, $row) {

                 return  number_format($this->sumAddFromMoney_clipper($d,1,$this->f,$this->t)).'   د.ع '  ;
                }
            ),
            array('db' => 'id_user', 'dt' =>5,
                'formatter' => function ($d, $row) {
                    $purc=new purchase_customer();
                 return  number_format($purc->sumbillall($d) ).'   د.ع '  ;
                }
            ),
			array('db' => 'money', 'dt' => 6,
				'formatter' => function ($d, $row) {
					$fromdate = strtotime(date('Y-m-d', time()));
					$todate = strtotime('+1 day', $fromdate);
					$money_clipper=new money_clipper();

                    $purc=new purchase_customer();
                     $pc=$purc->sumbillall($row[0]) ;

					if (!empty($this->f) && !empty($this->t))
					{
						return strip_tags(number_format(((int)$d+(int)$money_clipper->addOrWithdrawMoneySecondary($row[0],0,$this->f,$this->t)) - (int)$money_clipper->addOrWithdrawMoneySecondary($row[0],1,$this->f,$this->t) - (int)$pc )) .' د.ع ';

					}else{
						return strip_tags(number_format(((int)$d+(int)$money_clipper->addOrWithdrawMoneySecondaryAllDay($row[0],0))- (int)$money_clipper->addOrWithdrawMoneySecondaryAllDay($row[0],1)- (int)$pc  )) .' د.ع ';

					}
				}
			),

            array(
                'db' => 'id_user',
                'dt' => 7,
                'formatter' => function ($id, $row) {
                    return "
 
                   <div style='text-align: center;font-size: 23px;'>
                    <a class='btn btn-warning' href=" . url .'/'.$this->folder."/bill/$id>  {$this->number_billAll($id,$this->f,$this->t)} </a>
                    </div> ";
                }
            ),


            array(
                'db' => 'id',
                'dt' => 8,
                'formatter' => function ($id, $row) {
                    if ($this->permit('disaccount', 'log_accountant')) {


						return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'   data-toggle='modal' data-target='#exampleModal_edit' data-id='{$id}' data-id_user='{$row[10]}' data-money='{$row[12]}'   >
                    <i class='fa fa-edit' aria-hidden='true'></i></i>
                         </button>
                    </div>
                  
                    ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
			array(
				'db' => 'id_user',
				'dt' => 9,
				'formatter' => function ($id, $row) {
					return "
 
                   <div style='text-align: center;'>
                    <a href=" . url .'/'.$this->folder."/log_discount/$id>  سجل السحب </a>
                    </div> ";
				}
			),
            array('db' => 'id_user', 'dt' =>10),
            array('db' => 'id', 'dt' => 11),
			array('db' => 'money', 'dt' => 12)



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
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
        );

    }
*/

	function number_billAll($id,$fromDate=null,$toDate=null)
	{


		if ($fromDate==null)
		{
			$stmt =$this->db->prepare("SELECT COUNT(`number_bill`) as number_bill FROM  `log_accountant_bill` WHERE  `id_user`  = ?  ");
			$stmt->execute(array($id));
		}else
		{

			$stmt =$this->db->prepare("SELECT COUNT(`number_bill`) as number_bill FROM  `log_accountant_bill` WHERE  `id_user`  = ?  AND `date`  between ? AND ?");
			$stmt->execute(array($id,$fromDate,$toDate));

		}

		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		return $result['number_bill'];
	}

	function sunMoneyBill($id,$fromDate=null,$toDate=null)
	{

	    $stmt =$this->db->prepare("SELECT SUM(`money`) as money FROM  `log_accountant_bill` WHERE  `id_user`  = ?  AND `date`  between ? AND ?");
		$stmt->execute(array($id,$fromDate,$toDate));
		if ($stmt->rowCount() > 0)
        {
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $result['money'];
        }else
        {
            return 0;
        }

	}


    function sumDiscount($id)
	{
		if ($this->handleLogin())
		{
			$stmt1 = $this->db->prepare("SELECT    sum(`money`) as money  FROM `discount` WHERE  from_id_user=?  ");
			$stmt1->execute(array($id));

				$result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
			   return $result1['money'];
		}

	}

    function sumDiscount_byDate($id,$from_date,$to_date)
	{
		if ($this->handleLogin())
		{
			$stmt1 = $this->db->prepare("SELECT    sum(`money`) as money  FROM `discount` WHERE  from_id_user=?  AND `date` between ? AND ?");
			$stmt1->execute(array($id,$from_date,$to_date));

				$result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
			   return $result1['money'];
		}

	}

    function sumAddFromMoney_clipper($id,$flag,$fromDate=null,$toDate=null)
	{
		if ($this->handleLogin())
		{


			if ($fromDate==null) {
				$stmt1 = $this->db->prepare("SELECT    sum(`money`) as money  FROM `money_clipper_secondary_user` WHERE  id_user=? AND `flag`=?");
				$stmt1->execute(array($id, $flag));
			}
			else{
				$stmt1 = $this->db->prepare("SELECT    sum(`money`) as money  FROM `money_clipper_secondary_user` WHERE  id_user=? AND `flag`=? AND date between ? AND  ? ");
				$stmt1->execute(array($id, $flag,$fromDate,$toDate));
			}


				$result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
			   return $result1['money'];
		}

	}






	function log_discount($id)
	{

		$this->checkPermit('log_discount', 'main_log_accountant');
		$this->adminHeaderController($this->langControl('log_discount'));






		require($this->render($this->folder, 'html', 'discount', 'php'));
		$this->adminFooterController();
	}



	public function processing_discount($id)
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
			SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"`from_id_user`={$id}")
		);

	}











	function bill($id)
    {

        $this->checkPermit('bill', 'log_accountant');
        $this->adminHeaderController($this->langControl('log_accountant'));

        $stmt =$this->db->prepare("SELECT *FROM  `user` WHERE  `id`  = ? ");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);

        $date=null;
        if (isset($_GET['date']))
        {
            $date=$_GET['date'];
        }
        $xy=0;
        $stmt1 = $this->db->prepare("SELECT    `money`    FROM `log_accountant` WHERE  id_user=?  ");
        $stmt1->execute(array($id));
        if ($stmt1->rowCount() > 0) {
            $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            $xy = $result1['money'];
        }

        $result['money']= $this->account_billAll($id,$date);

		$money_clipper=new money_clipper();

		$fromdate = strtotime(date('Y-m-d', time()));
		$todate = strtotime('+1 day', $fromdate);

		$sun=((int)$xy+(int)$money_clipper->addOrWithdrawMoneySecondaryAllDay($id,0)) - (int)$money_clipper->addOrWithdrawMoneySecondaryAllDay($id,1);



		$result['remainder']=number_format($sun);



        require($this->render($this->folder, 'html', 'bill', 'php'));
        $this->adminFooterController();
    }

    function account_billAll($id,$date)
    {

        if ($date==null)
        {

            $stmt =$this->db->prepare("SELECT   `number_bill`  FROM  `cart_shop_active` WHERE  `user_direct`  = ? AND `id_accountant_user`=? AND  `accountant` = 1  AND cancel=0  GROUP BY `number_bill` ");
            $stmt->execute(array($id,$id));

        }else
        {
            $fromDate=strtotime($date);
            $toDate= strtotime(date('Y-m-d', strtotime($date. ' + 1 days')));


            $stmt =$this->db->prepare("SELECT   `number_bill`  FROM  `cart_shop_active` WHERE  `user_direct`  = ? AND `id_accountant_user`=?  AND  `accountant` = 1  AND cancel=0 AND `date_accountant`  between ? AND ? GROUP BY `number_bill` ");
            $stmt->execute(array($id,$id,$fromDate,$toDate));


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




    public function getAllContentFromCar_byNomberBill($id_user,$n_b)
    {
        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx`,`number_bill`,`top`,`dollar_exchange` FROM `cart_shop_active` WHERE `user_direct` =? AND `id_accountant_user` =? AND `number_bill`=?  AND   `accountant`=1 AND cancel=0 GROUP BY `id_item`,`table`,`code`,`color` ORDER BY `id` DESC  ");
        $stmt->execute(array($id_user,$id_user,$n_b));
        return $stmt;
    }




    public function processing_bill($id)
    {

        $table = 'cart_shop_active';
        $primaryKey = 'id';

        $columns = array(
            array('db' => 'number_bill', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),

            array('db' => 'user_direct', 'dt' =>1,
                'formatter' => function ($d, $row) {

            	if ($this->sunBill($d,$row[0]) ==0)
				{
					return $this->sunBill($d,$row[0]) .' = '.'<span style="background: red">تم الغاء الفاتورة </span>';

				}else{
					return $this->sunBill($d,$row[0]);

				}
                }
            ),
            array('db' => 'id_accountant_user', 'dt' =>2,
                'formatter' => function ($d, $row) {
                    return  $this->UserInfo($d);
                }
            ),
            array('db' => 'date_prepared', 'dt' =>3,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i:s A',$d);
                }
            ),

            array('db' => 'id', 'dt' => 4)

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
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"`user_direct`={$id} AND `number_bill` <> 0 AND `accountant`=1 GROUP BY `number_bill` ")
        );

    }


    function sunBill($id,$n_bill)
    {



        $stmt=$this->getAllContentFromCar($id,$n_bill);
        $request=array();

        $sum=0;
        $number_bill=0;
        $date_req=array();
        $price1=0;
        $date=0;
        $p1=0;
        $p2=0;
        $xp1=0;
        $xp2=0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

			if (!empty($this->cuts($row['id_item'], $row['table']))) {

				$price = explode('-', $this->cuts($row['id_item'], $row['table']));
				$f1 = (double)trim(str_replace(',', '', $price[0]));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1 = $xp1;

			} else {
				$price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
				$f1 = (int)trim(str_replace(',', '', $price));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1 = $xp1;

			}
		}


			return number_format($price1);

  }



    public function getAllContentFromCar($id,$number_bill)
    {
        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx`,`number_bill` ,`id_member_r`,`prepared`,`dollar_exchange` FROM `cart_shop_active` WHERE `user_direct` =?  AND `accountant`=1 AND `number_bill`=? AND `number_bill` <> 0   AND cancel=0 GROUP BY `id_item`,`table`,`code`,`color`,`user_direct`,`number_bill` ORDER BY `id` DESC  ");
        $stmt->execute(array($id,$number_bill));
        return $stmt;
    }



    function getUser($id,$id_user)
    {
        if ($this->handleLogin()) {

			$direct=new direct();
			$data['username']=$this->UserInfo($id_user);
			$data['money']=number_format((int)trim(str_replace($this->comma,'',$direct->sumAllMoney($id_user))));

			echo json_encode($data);
        }


    }



    public function disaccount($id,$id_user)
    {
        if ($this->handleLogin()) {

            $discount=(int)str_replace($this->comma,'',trim($_POST['discount']));

            $stmt1=$this->db->prepare("SELECT *FROM  log_accountant  WHERE `id` = ? AND `id_user`=?   ");
            $stmt1->execute(array($id,$id_user));

			$data =$stmt1->fetch(PDO::FETCH_ASSOC);
			$money_clipper=new money_clipper();

			$direct=new direct();
			$sun=(int)trim(str_replace($this->comma,'',$direct->sumAllMoney($id_user)));


			if ($stmt1->rowCount() > 0)
            {
            	if ($discount <= $sun) {

					$stmtt = $this->db->prepare("SELECT *FROM `log_accountant` WHERE  `id` = ? AND `id_user`=?   ");
					$stmtt->execute(array($id, $id_user));
					$oldData = array();
					while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
						$oldData[] = $rowt;
					}


					$stmt = $this->db->prepare("UPDATE log_accountant SET `money`=money-?   WHERE `id` = ? AND `id_user`=?");
					$stmt->execute(array($discount, $id, $id_user));


					$stmtU = $this->db->prepare("SELECT *FROM  user  WHERE `id` = ? ");
					$stmtU->execute(array($id_user));
					$result = $stmtU->fetch(PDO::FETCH_ASSOC);

					$stmtD = $this->db->prepare("INSERT INTO `discount` (`from_username`,`from_id_user`,`to_username`,`to_id_user`,`money`,`date`,`time`)VALUES (?,?,?,?,?,?,?)");
					$stmtD->execute(array($result['username'], $result['id'], session::get('usernamelogin'), $this->userid, $discount, time(), time()));


					$stmtt = $this->db->prepare("SELECT *FROM `log_accountant` WHERE  `id` = ? AND `id_user`=?   ");
					$stmtt->execute(array($id, $id_user));
					$newData = array();
					while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
						$newData[] = $rowt;
					}

					$note = "سحب مبلغ قدرة" . number_format($discount) . " من المحاسب المباشر " . $result['username'];
					$trace = new trace();
					$trace->addtrace('log_accountant', $note, json_encode($oldData), json_encode($newData), 'سحب مبالغ من المحاسب المباشر ' . $result['username']);




                    $stmt_total = $this->db->prepare("SELECT *FROM `total_accountants` WHERE  `id_account` = ?  ");
                    $stmt_total->execute(array($this->userid));
                    if ($stmt_total->rowCount() > 0) {
                        $stmt_t = $this->db->prepare("UPDATE  `total_accountants` SET `secondary_accountants`=secondary_accountants + {$discount},`userId`=?, `date`=? WHERE  `id_account` = ?   ");
                        $stmt_t->execute(array($this->userid,time(),$this->userid));

                    } else {
                        $stmt_t = $this->db->prepare("INSERT INTO `total_accountants` (`username`,`id_account`,`secondary_accountants`,`userId`,`date`) values (?,?,?,?,?)");
                        $stmt_t->execute(array(Session::get('usernamelogin'),$this->userid, $discount,$this->userid, time()));
                    }






                }else{
					echo 0;
				}

            }else{
                echo 0;
            }

        }

    }




    function check_amount()
    {


        $d3=new direct();



        $stmt=$this->db->prepare("SELECT money_box  FROM user WHERE id=?");
        $stmt->execute(array($this->userid));
        if ($stmt->rowCount() > 0 ) {
            $result= $stmt->fetch(PDO::FETCH_ASSOC);;
            if (!empty($result['money_box'])) {
                if (((int)trim(str_ireplace($this->comma, '', $d3->sumAllMoney($this->userid)))) > (int)$result['money_box']  ) {
                    echo 'false';
                } else {
                    echo 'true';
                }
            } else {
                echo 'true';
            }
        }else
        {
            echo 'false';
        }

    }
/*
    function check_amountDirect3($id)
    {


            $stmt =$this->db->prepare("SELECT   `number_bill`  FROM  `cart_shop_active` WHERE  `user_direct`  = ?  AND  `accountant` =0 GROUP BY `number_bill` ");
            $stmt->execute(array($id));



        $SumPrice=0;
        while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC))
        {

            $stmt2=$this->getAllContentFromCar_byNomberBill2($id,$row1['number_bill']);

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


        return  $SumPrice;

    }
*/

    public function getAllContentFromCar_byNomberBill2($id_user,$n_b)
    {
        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx`,`number_bill`,`top`,`dollar_exchange` FROM `cart_shop_active` WHERE `user_direct` =? AND `number_bill`=?  AND   `accountant`=0 AND cancel=0 GROUP BY `id_item`,`table`,`code`,`color` ORDER BY `id` DESC  ");
        $stmt->execute(array($id_user,$n_b));
        return $stmt;
    }





}









