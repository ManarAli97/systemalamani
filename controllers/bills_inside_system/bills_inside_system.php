<?php
require  "search/search.php";

class bills_inside_system extends Controller
{

use search;

	function __construct()
	{
		$this->table='cart_shop_active';
		$this->crystal_bill='crystal_bill';
		$this->group_bill='group_bill';
		parent::__construct();
		$this->setting = new Setting();
	}



	public function createTB()
	{


		$this->db->query("CREATE TABLE IF NOT EXISTS `{$this->crystal_bill}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
          `number_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `crystal_bill` int(10) NOT NULL,
          `userid` int (10) NOT NULL,
          `checked` int(20) NOT NULL DEFAULT 0,
          `user_checked` int(20) NOT NULL,
          `date` bigint(20) NOT NULL,
          `date_checked` bigint(20) NOT NULL,
          `edit` int(20) NOT NULL DEFAULT 0,
          `user_edit` int(20) NOT NULL,
          `note` varchar(250) NOT NULL,
          `delete` int(20) NOT NULL DEFAULT 0,

           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


		$this->db->query("CREATE TABLE IF NOT EXISTS `{$this->group_bill}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `number_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `crystal_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `number` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `userid` int (10) NOT NULL,
           `user_input_bill` int (10) NOT NULL,
           `checked` int(20) NOT NULL DEFAULT 0,
           `user_checked` int(20) NOT NULL,
           `date` bigint(20) NOT NULL,
           
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


		return  $this->db->cht(array($this->crystal_bill,$this->group_bill));

	}






	public function index()
	{
		$this->checkPermit('bills_inside_system', 'bills_inside_system');
		$this->AdminHeaderController($this->langControl('bills_inside_system'));





		$date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;

		if (isset($_GET['date'])&&isset($_GET['todate'])) {
			$date = $_GET['date'];
			$todate = $_GET['todate'];

			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);

		}


		require($this->render($this->folder, 'html', 'list', 'php'));
		$this->AdminFooterController();
	}




	public function processing($from_date_stm=null,$to_date_stm=null)
	{
		// $table_r='(select * from `cart_shop` UNION SELECT * from cart_shop_active  ) as cart_shop_active ';
		$table = 'cart_shop';
		$primaryKey = 'cart_shop.id';

		$columns = array(
			array('db' =>'register_user.name', 'dt' => 0,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),
			array('db' =>'register_user.phone', 'dt' => 1,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),


			array('db' => 'cart_shop.date_accountant', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return date('Y-m-d h:i a',$d);
				}
			),
			array('db' =>'cart_shop.number_bill', 'dt' => 3,
				'formatter' => function ($d, $row) {

					if ($row[15] == 1)
					{
						return $this->sunAmountBillByNumberBill($row[12],$d,'cart_shop') .' = '.'<span style="background: red">تم الغاء الفاتورة </span>';

					}else{
						return $this->sunAmountBillByNumberBill($row[12],$d,'cart_shop');

					}

				}
			),

			array('db' => 'user.username', 'dt' => 4),


			array('db' => 'cart_shop.number_bill', 'dt' => 5,
				'formatter' => function ($d, $row) {
					return "<a href='".url.'/'.$this->folder."/details/{$row[12]}/{$d}'>{$d}</a>";
				}
			),

	     array('db' => 'crystal_bill.crystal_bill', 'dt' => 6),

			array('db' => 'cart_shop.id', 'dt' => 7,
				'formatter' => function ($d, $row) {

				if ($row[16] && $row[19]==0)
				{
					return "
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-auto' style='padding-left: 2px'>		
				  	   <input id='numberBill_{$row[17]}' value='{$row[16]}'  onkeyup=''  type='text' class='form-control withBill' name='crystal_bill' required>
                    </div>
				  <div class='col-auto'  style='padding-right: 2px'>
				   <button type='submit' id='btn_in_bill_{$row[17]}' onclick=saveBill('".$row[17]."')  name='submit' class='btn  btn-success'>حفظ</button>
                  </div>
                  </div>
				 " ;
				}else{
					return "
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-auto' style='padding-left: 2px'>		
				  	       <input id='numberBill_{$row[17]}'  value='{$row[16]}' type='text' class='form-control withBill' name='crystal_bill' required>
                   </div>
				  <div class='col-auto' style='padding-right: 2px'>
				   <button type='submit' id='btn_in_bill_{$row[17]}' onclick=saveBill('".$row[17]."')  name='submit' class='btn btn-warning'>حفظ</button>
                  </div>
                  </div>
                    " ;
				}

				}
			),

			array('db' =>'crystal_bill.userid', 'dt' => 8,
				'formatter' => function ($d, $row) {
				if ($d)
				{
					return $this->UserInfo($d);

				}else{
					return '';
				 }
				}
			),

			array('db' =>'crystal_bill.checked', 'dt' => 9,
				'formatter' => function ($d, $row) {
				if ($d==1 && $row[19]==0)
				{
					return  '<i style="color: green" class="fa fa-check-circle"></i>';

				}else if ($row[18]){
					return  "<div id='div_checked_{$row[18]}'> <button class='btn btn-primary' onclick='checked_bill({$row[18]})' id='btn_checked_{$row[18]}'> تم </button> </div>";
				 }else
				{
					return '';
				}
				}
			),

			array('db' =>'crystal_bill.user_checked', 'dt' => 10,
				'formatter' => function ($d, $row) {
					if ($d)
					{
						return $this->UserInfo($d);

					}else{
						return '';
					}
				}
			),
			array('db' =>'cart_shop.id', 'dt' => 11),
			array('db' =>'cart_shop.id_member_r', 'dt' =>12),
			array('db' =>'cart_shop.id_accountant_user', 'dt' =>13),
			array('db' =>'cart_shop.user_direct', 'dt' =>14),
			array('db' =>'cart_shop.cancel', 'dt' =>15),
			array('db' =>'crystal_bill.crystal_bill', 'dt' =>16),
			array('db' =>'cart_shop.number_bill', 'dt' =>17),
			array('db' =>'crystal_bill.id', 'dt' =>18),
			array('db' =>'crystal_bill.edit', 'dt' =>19),


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);


		$join = "inner JOIN register_user ON register_user.id = cart_shop.id_member_r left JOIN crystal_bill ON crystal_bill.number_bill = cart_shop.number_bill left JOIN user ON user.id = cart_shop.id_accountant_user  ";
		if (empty($from_date_stm) && empty($to_date_stm))
		{
			$whereAll = array("(cart_shop.accountant = 1 OR crystal_bill.delete =0)");

		}else{
			$whereAll = array("(cart_shop.accountant = 1 OR crystal_bill.delete =0)","cart_shop.date_req BETWEEN {$from_date_stm} AND {$to_date_stm}");

		}
		$group="GROUP BY  cart_shop.number_bill,cart_shop.id_member_r";

		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

	}



    public function item_deleted_from_bills()
    {
        $this->checkPermit('item_deleted_from_bills', $this->folder);
        $this->AdminHeaderController($this->langControl('bills_inside_system'));


        $date=null;
        $todate=null;

        $from_date_stm=null;
        $to_date_stm=null;

        if (isset($_GET['date'])&&isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);

        }


        require($this->render($this->folder, 'html', 'item_deleted_from_bills', 'php'));
        $this->AdminFooterController();
    }



    public function processing_item_deleted_from_bills($from_date_stm=null,$to_date_stm=null)
	{

		$table = 'retrieve_item';
		$primaryKey = 'id';

		$columns = array(
			array('db' =>'image', 'dt' => 0,
				'formatter' => function ($d, $row) {
					return "<img style='width: 50px' src='{$this->save_file}{$d}'>";
				}
			),
			array('db' =>'table', 'dt' => 1,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),

			array('db' =>'code', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),

            array('db' => 'number_bill', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/details_delete/{$row[9]}/{$d}'>{$d}</a>";
                }
            ),

			array('db' =>'price', 'dt' => 4,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),

			array('db' =>'id_user', 'dt' => 5,
				'formatter' => function ($d, $row) {
					return $this->UserInfo($d);
				}
			 ),


			array('db' =>'delete_user', 'dt' => 6,
				'formatter' => function ($d, $row) {
					return $this->UserInfo($d);
				}
			),

			array('db' =>  'recovery', 'dt' => 7,
				'formatter' => function ($d, $row) {
				if ($d==1)
                {
                 return '<span class="badge badge-success"> مسترجع</span>';
                }else
                {
                    return '<span class="badge badge-warning"> غير مسترجع</span>';
                }

				}
			),
			array('db' =>  'date', 'dt' => 8,
				'formatter' => function ($d, $row) {
					return date('Y-m-d h:i a',$d);
				}
			),

            array('db' =>'id_customer', 'dt' =>9
            ,
                'formatter' => function ($d, $row) {
                    return $this->customerInfo($d) ;
                }
            ),
			array('db' =>'id', 'dt' =>10),



		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);



        if ($from_date_stm && $to_date_stm)
        {
            echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"date BETWEEN {$from_date_stm} AND {$to_date_stm}" ));
        }else
        {
            echo json_encode(
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns ));

        }

    }


	function checked_bill($id)
	{

		if ($this->handleLogin())
		{
			$stmt_up=$this->db->prepare("UPDATE  `crystal_bill` SET  checked=1 , user_checked=?, date_checked=?   WHERE  `id` =? AND `delete`=0");
			$stmt_up->execute(array($this->userid,time(),$id));
			if ($stmt_up->rowCount() > 0)
			{
				echo '1';
			}
		}

	}


	function crystal_delete($id,$number_bill)
	{

		if ($this->handleLogin())
		{
			$stmt_up=$this->db->prepare("UPDATE  `crystal_bill` SET  checked=1 , user_checked=?, date_checked=?,crystal_delete=1   WHERE  `id` =? AND crystal_bill=?  ");
			$stmt_up->execute(array($this->userid,time(),$id,$number_bill));
			if ($stmt_up->rowCount() > 0)
			{
				echo '1';
			}
		}

	}




	public function bills_crystal_enter()
	{
		$this->checkPermit('bills_crystal_enter', 'bills_inside_system');
		$this->AdminHeaderController($this->langControl('bills_crystal_enter'));





		$date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;

		if (isset($_GET['date'])&&isset($_GET['todate'])) {
			$date = $_GET['date'];
			$todate = $_GET['todate'];

			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);

		}


		require($this->render($this->folder, 'html', 'bills_crystal_enter', 'php'));
		$this->AdminFooterController();
	}


	public function processing_bills_crystal_enter($from_date_stm=null,$to_date_stm=null)
	{

		$table = 'cart_shop';
		$primaryKey = 'cart_shop.id';

		$columns = array(
			array('db' =>'register_user.name', 'dt' => 0,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),
			array('db' =>'register_user.phone', 'dt' => 1,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),


			array('db' => 'cart_shop.date_accountant', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return date('Y-m-d h:i a',$d);
				}
			),
			array('db' => 'cart_shop.number_bill', 'dt' => 3,
				'formatter' => function ($d, $row) {



                    if ($row[14]==1)
                    {
                        if ($row[12] == 1)
                        {
                            return   $this->sunAmountBillByNumberBill($row[10],$d,'cart_shop') .' = <span style="background: red">تم الغاء الفاتورة </span>'  ;

                        }else{
                            return "<span   data-toggle='tooltip' data-placement='top' title='تم تغير  سعر الفاتورة '   style='color: red'> {$this->sunAmountBillByNumberBill($row[10],$d,'cart_shop')} </span>";

                        }
                    }else
                    {
                        if ($row[12] == 1)
                        {
                            return $this->sunAmountBillByNumberBill($row[10],$d,'cart_shop') .' = <span style="background: red">تم الغاء الفاتورة </span>';

                        }else{
                            return $this->sunAmountBillByNumberBill($row[10],$d,'cart_shop');

                        }
                    }



                }
			),

            array('db' => 'cart_shop.id_accountant_user', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return  $this->UserInfo($d);
                }
            ),

            array('db' => 'cart_shop.number_bill', 'dt' => 5,
				'formatter' => function ($d, $row) {
					return "<a href='".url.'/'.$this->folder."/details/{$row[10]}/{$d}/cart_shop'>{$d}</a>";
				}
			),

			array('db' => 'cart_shop.crystal_bill', 'dt' => 6),

			array('db' => 'cart_shop.id', 'dt' => 7,
				'formatter' => function ($d, $row) {

					if ($this->permit('edit_bill', 'bills_inside_system')) {


						if ($row[6]) {
							return "
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-auto' style='padding-left: 2px'>		
				  	   <input id='numberBill_{$row[13]}{$row[10]}' value='{$row[6]}'  onkeyup=''  type='text' class='form-control withBill' name='crystal_bill' required>
                    </div>
				  <div class='col-auto'  style='padding-right: 2px'>
				   <button type='submit' id='btn_in_bill_{$row[13]}{$row[10]}' onclick=saveBill('" . $row[13] . "','" . $row[10] . "')  name='submit' class='btn  btn-success'>حفظ</button>
                  </div>
                  </div>
				 ";
						} else {
							return "
             	              <div class='row justify-content-center align-items-center'>
				  <div class='col-auto' style='padding-left: 2px'>		
				  	       <input id='numberBill_{$row[13]}{$row[10]}'  value='{$row[6]}' type='text' class='form-control withBill' name='crystal_bill' required>
                   </div>
				  <div class='col-auto' style='padding-right: 2px'>
				   <button type='submit' id='btn_in_bill_{$row[13]}{$row[10]}' onclick=saveBill('" . $row[13] . "','" . $row[10] . "')  name='submit' class='btn btn-warning'>حفظ</button>
                  </div>
                  </div>
                                 ";
						}
					}else
					{
						return 'لا توجد صلاحية';
					}



				}
			),

			array('db' => 'cart_shop.number_bill', 'dt' => 8,
				'formatter' => function ($d, $row) {
                    $stmt=$this->db->prepare("SELECT user.username FROM `crystal_bill` INNER JOIN user ON user.id=crystal_bill.userid WHERE     crystal_bill. `number_bill` =?  LIMIT 1");
                    $stmt->execute(array($d));
                    if ($stmt->rowCount() > 0)
                    {
                        return $stmt->fetch(PDO::FETCH_ASSOC)['username'];
                    }else{
                        return '';
                    }
				}
			),



			array('db' =>'cart_shop.id', 'dt' => 9),//11
			array('db' =>'cart_shop.id_member_r', 'dt' =>10),//12
			array('db' =>'cart_shop.user_direct', 'dt' =>11),//14
			array('db' =>'cart_shop.cancel', 'dt' =>12),//15
 			array('db' =>'cart_shop.number_bill', 'dt' =>13),//17
             array('db' =>'cart_shop.edit_price', 'dt' =>14),//17


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);



		$join = "inner JOIN register_user ON register_user.id = cart_shop.id_member_r    ";

			$whereAll = array("cart_shop.accountant = 1","cart_shop.date_req BETWEEN {$from_date_stm} AND {$to_date_stm}","cart_shop.crystal_bill <> '' ");

		$group="GROUP BY  cart_shop.number_bill,cart_shop.id_member_r";

		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,1));

	}

	public function bills_crystal_not_enter()
	{
		$this->checkPermit('bills_crystal_not_enter', 'bills_inside_system');
		$this->AdminHeaderController($this->langControl('bills_crystal_not_enter'));



        $stmt = $this->db->prepare("SELECT number_bill FROM `cart_shop_active` WHERE  accountant = 1 AND prepared=2 AND crystal_bill  = '' AND  cancel = 0  AND  group_bill = ''  GROUP BY number_bill,id_member_r") ;
        $stmt->execute();
        $bill=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {
            if ($this->ch_prepared($row['number_bill'])  )
            {
                $bill[]=$row['number_bill'];
            }
        }


        $date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;

		if (isset($_GET['date'])&&isset($_GET['todate'])) {
			$date = $_GET['date'];
			$todate = $_GET['todate'];

			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);

		}


		require($this->render($this->folder, 'html', 'bills_crystal_not_enter', 'php'));
		$this->AdminFooterController();
	}



	public function processing_bills_crystal_not_enter($from_date_stm=null,$to_date_stm=null)
	{

		$table = $this->table;
		$primaryKey = $this->table.'.id';

		$columns = array(
			array('db' =>'register_user.name', 'dt' => 0,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),
			array('db' =>'register_user.phone', 'dt' => 1,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),


			array('db' => $this->table.'.date_accountant', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return date('Y-m-d h:i a',$d);
				}
			),
			array('db' => $this->table.'.number_bill', 'dt' => 3,
				'formatter' => function ($d, $row) {
			    if ($row[15]==1)
                {
                    if ($row[13] == 1)
                    {
                        return   $this->sunAmountBillByNumberBill($row[10],$d) .' = <span style="background: red">تم الغاء الفاتورة </span>';

                    }else{
                        return "<span   data-toggle='tooltip' data-placement='top' title='تم تغير  سعر الفاتورة '   style='color: red'> {$this->sunAmountBillByNumberBill($row[10],$d)} </span>";

                    }
                }else
                {
                    if ($row[13] == 1)
                    {
                        return $this->sunAmountBillByNumberBill($row[10],$d) .' = '.'<span style="background: red">تم الغاء الفاتورة </span>';

                    }else{
                        return $this->sunAmountBillByNumberBill($row[10],$d);

                    }
                }


				}
			),

			array('db' => $this->table.'.id_accountant_user', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return  $this->UserInfo($d);
                }
                ),
            array('db' => $this->table.'.user_direct', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return  $this->UserInfoBill($d);
                }
            ),

			array('db' => $this->table.'.number_bill', 'dt' => 6,
				'formatter' => function ($d, $row) {
					return "<button  class='btn btn-secondary' onclick='get_details($row[10],$d)'  >{$d}</button>";
				}
			),


			array('db' => $this->table.'.id', 'dt' => 7,
				'formatter' => function ($d, $row) {
					if ($this->permit('enter_bills', 'bills_inside_system')) {

					return "
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-auto' style='padding-left: 2px'>		
				  	       <input id='numberBill_{$row[14]}{$row[10]}'  value='' type='text' class='form-control withBill' name='crystal_bill' required>
                   </div>
				  <div class='col-auto' style='padding-right: 2px'>
				   <button type='submit' id='btn_in_bill_{$row[14]}{$row[10]}}' onclick=saveBill('".$row[14]."','".$row[10]."')  name='submit' class='btn btn-warning'>حفظ</button>
                  </div>
                  </div>
                    " ;
					}else
					{
						return 'لا توجد صلاحية';
					}

				}
			),


			array('db' =>$this->table.'.note_prepared', 'dt' => 8),//8
			array('db' =>$this->table.'.id', 'dt' => 9),//8
			array('db' =>$this->table.'.id_member_r', 'dt' =>10),//9
			array('db' =>$this->table.'.id_accountant_user', 'dt' =>11),//10
			array('db' =>$this->table.'.user_direct', 'dt' =>12),//11
			array('db' =>$this->table.'.cancel', 'dt' =>13),//12
			array('db' =>$this->table.'.number_bill', 'dt' =>14),//14
            array('db' =>$this->table.'.edit_price', 'dt' =>15),//17



        );

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);


		$join = "inner JOIN register_user ON register_user.id = cart_shop_active.id_member_r ";
		if (empty($from_date_stm) && empty($to_date_stm))
		{
			$whereAll = array("cart_shop_active.accountant = 1 ","cart_shop_active.crystal_bill  = '' "," cart_shop_active.cancel = 0 "," cart_shop_active.group_bill = '' ");

		}else{
			$whereAll = array("cart_shop_active.accountant = 1 ","cart_shop_active.crystal_bill  = '' "," cart_shop_active.cancel = 0 "," cart_shop_active.group_bill = '' ","cart_shop_active.date_req BETWEEN {$from_date_stm} AND {$to_date_stm}");

		}
		$group="GROUP BY  cart_shop_active.number_bill, cart_shop_active.id_member_r";

		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

	}




	public function bills_crystal_edit_bill()
	{
		$this->checkPermit('bills_crystal_edit_bill', 'bills_inside_system');
		$this->AdminHeaderController($this->langControl('bills_crystal_edit_bill'));

		$date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;

		if (isset($_GET['date'])&&isset($_GET['todate'])) {
			$date = $_GET['date'];
			$todate = $_GET['todate'];

			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);

		}


		require($this->render($this->folder, 'html', 'bills_crystal_edit_bill', 'php'));
		$this->AdminFooterController();
	}


	public function processing_bills_crystal_edit_bill($from_date_stm=null,$to_date_stm=null)
	{

		$table = $this->table;
		$primaryKey = $this->table.'.id';

		$columns = array(
			array('db' =>'register_user.name', 'dt' => 0,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),
			array('db' =>'register_user.phone', 'dt' => 1,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),


			array('db' => $this->table.'.date_accountant', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return date('Y-m-d h:i a',$d);
				}
			),
			array('db' => $this->table.'.number_bill', 'dt' => 3,
				'formatter' => function ($d, $row) {

					if ($row[15] == 1)
					{
						return $this->sunAmountBillByNumberBill($row[12],$d) .' = '.'<span style="background: red">تم الغاء الفاتورة </span>';

					}else{
						return $this->sunAmountBillByNumberBill($row[12],$d);

					}

				}
			),

			array('db' => 'user.username', 'dt' => 4),


			array('db' => $this->table.'.number_bill', 'dt' => 5,
				'formatter' => function ($d, $row) {
					return "<a href='".url.'/'.$this->folder."/details/{$row[12]}/{$d}'>{$d}</a>";
				}
			),

			array('db' => 'crystal_bill.crystal_bill', 'dt' => 6),

			array('db' => $this->table.'.id', 'dt' => 7,
				'formatter' => function ($d, $row) {

						return "
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-auto' style='padding-left: 2px'>		
				  	       <input id='numberBill_{$row[17]}'  value='' type='text' class='form-control withBill' name='crystal_bill' required>
                   </div>
				  <div class='col-auto' style='padding-right: 2px'>
				   <button type='submit' id='btn_in_bill_{$row[17]}' onclick=saveBill('".$row[17]."')  data-crystal_bill='{$row[6]}' name='submit' class='btn btn-warning'>حفظ</button>
                  </div>
                  </div>
                    " ;

				}
			),

			array('db' =>'crystal_bill.note', 'dt' => 8),

			array('db' =>'crystal_bill.checked', 'dt' => 9,
				'formatter' => function ($d, $row) {
					if ($d==1)
					{
						return  '<i style="color: green" class="fa fa-check-circle"></i>';

					}else if ($row[18]){
						return  "<div id='div_checked_{$row[18]}'> <button class='btn btn-primary' onclick='checked_bill({$row[18]})' id='btn_checked_{$row[18]}'> تم </button> </div>";
					}else
					{
						return '';
					}
				}
			),

			array('db' =>'crystal_bill.user_checked', 'dt' => 10,
				'formatter' => function ($d, $row) {
					if ($d)
					{
						return $this->UserInfo($d);

					}else{
						return '';
					}
				}
			),
			array('db' =>$this->table.'.id', 'dt' => 11),
			array('db' =>$this->table.'.id_member_r', 'dt' =>12),
			array('db' =>$this->table.'.id_accountant_user', 'dt' =>13),
			array('db' =>$this->table.'.user_direct', 'dt' =>14),
			array('db' =>$this->table.'.cancel', 'dt' =>15),
			array('db' =>'crystal_bill.crystal_bill', 'dt' =>16),
			array('db' =>$this->table.'.number_bill', 'dt' =>17),
			array('db' =>'crystal_bill.id', 'dt' =>18),
			array('db' =>'crystal_bill.edit', 'dt' =>19),


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);


		$join = "inner JOIN register_user ON register_user.id = cart_shop_active.id_member_r left JOIN crystal_bill ON crystal_bill.number_bill = cart_shop_active.number_bill left JOIN user ON user.id = cart_shop_active.id_accountant_user ";

		 $whereAll = array("crystal_bill.delete =0","cart_shop_active.date_req BETWEEN {$from_date_stm} AND {$to_date_stm}","crystal_bill.edit = 1 ");

		$group="GROUP BY  cart_shop_active.number_bill,cart_shop_active.id_member_r";

		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

	}



	public function bills_checked()
	{
		$this->checkPermit('bills_checked', 'bills_inside_system');
		$this->AdminHeaderController($this->langControl('bills_checked'));


		$date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;

		if (isset($_GET['date'])&&isset($_GET['todate'])) {
			$date = $_GET['date'];
			$todate = $_GET['todate'];

			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);

		}


		require($this->render($this->folder, 'html', 'bills_checked', 'php'));
		$this->AdminFooterController();
	}


	public function processing_bills_checked($from_date_stm=null,$to_date_stm=null)
	{


		$table = $this->table;
		$primaryKey = $this->table.'.id';

		$columns = array(
			array('db' =>'register_user.name', 'dt' => 0,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),
			array('db' =>'register_user.phone', 'dt' => 1,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),


			array('db' => $this->table.'.date_accountant', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return date('Y-m-d h:i a',$d);
				}
			),
			array('db' => $this->table.'.number_bill', 'dt' => 3,
				'formatter' => function ($d, $row) {



                    if ($row[18]==1)
                    {
                        if ($row[14] == 1)
                        {
                            return   $this->sunAmountBillByNumberBill($row[11],$d) .' = <span style="background: red">تم الغاء الفاتورة </span>';

                        }else{
                            return "<span   data-toggle='tooltip' data-placement='top' title='تم تغير  سعر الفاتورة '   style='color: red'> {$this->sunAmountBillByNumberBill($row[11],$d)} </span>";

                        }
                    }else
                    {
                        if ($row[14] == 1)
                        {
                            return $this->sunAmountBillByNumberBill($row[11],$d) .' = '.'<span style="background: red">تم الغاء الفاتورة </span>';

                        }else{
                            return $this->sunAmountBillByNumberBill($row[11],$d);

                        }
                    }





                }
			),

			array('db' => 'user.username', 'dt' => 4),


			array('db' => $this->table.'.number_bill', 'dt' => 5,
				'formatter' => function ($d, $row) {
					return "<a href='".url.'/'.$this->folder."/details/{$row[11]}/{$d}'>{$d}</a>";
				}
			),

			array('db' => 'crystal_bill.crystal_bill', 'dt' => 6),



			array('db' =>'crystal_bill.userid', 'dt' => 7,
				'formatter' => function ($d, $row) {
					if ($d)
					{
						return $this->UserInfo($d);

					}else{
						return '';
					}
				}
			),

			array('db' =>'crystal_bill.checked', 'dt' => 8,
				'formatter' => function ($d, $row) {
					if ($d==1)
					{
						return  '<i style="color: green" class="fa fa-check-circle"></i>';

					}else if ($row[17]){
						return  "<div id='div_checked_{$row[17]}'> <button class='btn btn-primary' onclick='checked_bill({$row[17]})' id='btn_checked_{$row[17]}'> تم </button> </div>";
					}else
					{
						return '';
					}
				}
			),

			array('db' =>'crystal_bill.user_checked', 'dt' => 9,
				'formatter' => function ($d, $row) {
					if ($d)
					{
						return $this->UserInfo($d);

					}else{
						return '';
					}
				}
			),
			array('db' =>$this->table.'.id', 'dt' => 10),
			array('db' =>$this->table.'.id_member_r', 'dt' =>11),
			array('db' =>$this->table.'.id_accountant_user', 'dt' =>12),
			array('db' =>$this->table.'.user_direct', 'dt' =>13),
			array('db' =>$this->table.'.cancel', 'dt' =>14),
			array('db' =>'crystal_bill.crystal_bill', 'dt' =>15),
			array('db' =>$this->table.'.number_bill', 'dt' =>16),
			array('db' =>'crystal_bill.id', 'dt' =>17),
            array('db' =>$this->table.'.edit_price', 'dt' =>18),


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);



		$join = "inner JOIN register_user ON register_user.id = cart_shop_active.id_member_r inner JOIN crystal_bill ON crystal_bill.number_bill = cart_shop_active.number_bill left JOIN user ON user.id = cart_shop_active.id_accountant_user  ";

			$whereAll = array("crystal_bill.delete =0","crystal_bill.checked = 1","cart_shop_active.date_req BETWEEN {$from_date_stm} AND {$to_date_stm}");

		$group="GROUP BY  cart_shop_active.number_bill,cart_shop_active.id_member_r";

		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

	}



	public function bills_note_checked()
	{
		$this->checkPermit('bills_note_checked', 'bills_inside_system');
		$this->AdminHeaderController($this->langControl('bills_note_checked'));


		$date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;

		if (isset($_GET['date'])&&isset($_GET['todate'])) {
			$date = $_GET['date'];
			$todate = $_GET['todate'];

			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);

		}


		require($this->render($this->folder, 'html', 'bills_note_checked', 'php'));
		$this->AdminHeaderController();
	}


	public function processing_bills_note_checked($from_date_stm=null,$to_date_stm=null)
	{


		$table = $this->table;
		$primaryKey = $this->table.'.id';

		$columns = array(

			array( 'db' => $this->table.'.number_bill', 'dt' => 0 ,
				'formatter' => function( $d, $row ) {
					return "<input type='checkbox'    class='childcheckbox'  name='number_bill[]' value='{$d}'>";
				}
			),


			array('db' =>'register_user.name', 'dt' =>1,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),
			array('db' =>'register_user.phone', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),


			array('db' => $this->table.'.date_accountant', 'dt' => 3,
				'formatter' => function ($d, $row) {
					return date('Y-m-d h:i a',$d);
				}
			),
			array('db' => $this->table.'.number_bill', 'dt' => 4,
				'formatter' => function ($d, $row) {


                    if ($row[17]==1)
                    {
                        if ($row[13] == 1)
                        {
                            return  $this->sunAmountBillByNumberBill($row[10],$d) .' = <span style="background: red">تم الغاء الفاتورة </span>';

                        }else{
                            return "<span   data-toggle='tooltip' data-placement='top' title='تم تغير  سعر الفاتورة '   style='color: red'> {$this->sunAmountBillByNumberBill($row[10],$d)} </span>";

                        }
                    }else
                    {
                        if ($row[13] == 1)
                        {
                            return $this->sunAmountBillByNumberBill($row[10],$d) .' = '.'<span style="background: red">تم الغاء الفاتورة </span>';

                        }else{
                            return $this->sunAmountBillByNumberBill($row[10],$d);

                        }
                    }





                }
			),

			array('db' => 'user.username', 'dt' => 5),


			array('db' => $this->table.'.number_bill', 'dt' => 6,
				'formatter' => function ($d, $row) {
					return "<a href='".url.'/'.$this->folder."/details/{$row[10]}/{$d}'>{$d}</a>";
				}
			),

			array('db' => 'crystal_bill.crystal_bill', 'dt' => 7),




			array('db' =>'crystal_bill.checked', 'dt' => 8,
				'formatter' => function ($d, $row) {
					if ($d==1)
					{
						return  '<i style="color: green" class="fa fa-check-circle"></i>';

					}else if ($row[16]){
						return  "<div id='div_checked_{$row[16]}'> <button type='button'  class='btn btn-primary' onclick='checked_bill({$row[16]})' id='btn_checked_{$row[16]}'> تم </button> </div>";
					}else
					{
						return '';
					}
				}
			),

			array('db' =>$this->table.'.id', 'dt' => 9),
			array('db' =>$this->table.'.id_member_r', 'dt' =>10),
			array('db' =>$this->table.'.id_accountant_user', 'dt' =>11),
			array('db' =>$this->table.'.user_direct', 'dt' =>12),
			array('db' =>$this->table.'.cancel', 'dt' =>13),
			array('db' =>'crystal_bill.crystal_bill', 'dt' =>14),
			array('db' =>$this->table.'.number_bill', 'dt' =>15),
			array('db' =>'crystal_bill.id', 'dt' =>16),
            array('db' =>$this->table.'.edit_price', 'dt' =>17),


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);



		$join = "inner JOIN register_user ON register_user.id = cart_shop_active.id_member_r inner JOIN crystal_bill ON crystal_bill.number_bill = cart_shop_active.number_bill left JOIN user ON user.id = cart_shop_active.id_accountant_user  ";

			$whereAll = array("crystal_bill.delete =0","cart_shop_active.date_req BETWEEN {$from_date_stm} AND {$to_date_stm}","crystal_bill.checked = 0","crystal_bill.edit = 0");

		$group="GROUP BY  cart_shop_active.number_bill,cart_shop_active.id_member_r";

		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

	}


	function checked_all()
	{
		if ($this->handleLogin()) {

			if (isset($_REQUEST['number_bill'])) {
				$myArray = $_REQUEST['number_bill'];
				$ids = implode(',', $myArray);
				$stmt_up = $this->db->prepare("UPDATE  `crystal_bill` SET  checked=1 , user_checked=?, date_checked=?   WHERE   `number_bill` IN ({$ids})   AND `delete`=0");
				$stmt_up->execute(array($this->userid, time()));
				if ($stmt_up->rowCount() > 0) {
					echo '1';
				}
			}
		}
	}





	public function bills_deleted()
	{
		$this->checkPermit('bills_deleted', 'bills_inside_system');
		$this->AdminHeaderController($this->langControl('bills_deleted'));



		$date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;

		if (isset($_GET['date'])&&isset($_GET['todate'])) {
			$date = $_GET['date'];
			$todate = $_GET['todate'];

			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);

		}


		require($this->render($this->folder, 'html', 'bills_deleted', 'php'));
		$this->AdminFooterController();
	}


	public function processing_deleted($from_date_stm=null,$to_date_stm=null)
	{


		$table = 'retrieve_item';
		$primaryKey = $table.'.id';

		$columns = array(
			array('db' =>'register_user.name', 'dt' => 0,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),
			array('db' =>'register_user.phone', 'dt' => 1,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),


			array('db' => $table.'.date', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return date('Y-m-d h:i a',$d);
				}
			),
			array('db' => $table.'.number_bill', 'dt' => 3,
				'formatter' => function ($d, $row) {

				return 0;
				}
			),


			array('db' => $table.'.number_bill', 'dt' => 4,
				'formatter' => function ($d, $row) {
					return "<a href='".url.'/'.$this->folder."/details_delete/{$row[10]}/{$d}'>{$d}</a>";
				}
			),

			array('db' => 'crystal_bill.crystal_bill', 'dt' => 5),


			array('db' =>'crystal_bill.crystal_delete', 'dt' => 6,
				'formatter' => function ($d, $row) {
					if ($d==1)
					{
						return  '<i style="color: red" class="fa fa-check-circle"></i>';

					}else  {
						return  "<div id='div_checked_{$row[9]}'> <button class='btn btn-primary' onclick='crystal_delete({$row[9]},{$row[5]})' id='btn_checked_{$row[9]}'> تم </button> </div>";
					}
				}
			),

            array('db' =>$table.'.id_user', 'dt' => 7,
                'formatter' => function ($d, $row) {
                    if ($d)
                    {
                        return $this->UserInfo($d);

                    }else{
                        return '';
                    }
                }
            ),
			array('db' =>$table.'.delete_user', 'dt' => 8,
				'formatter' => function ($d, $row) {
					if ($d)
					{
						return $this->UserInfo($d);

					}else{
						return '';
					}
				}
			),
			array('db' =>'crystal_bill.id', 'dt' => 9),
			array('db' =>$table.'.id_customer', 'dt' => 10),

		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);


        $join = "inner JOIN register_user ON register_user.id = {$table}.id_customer inner JOIN crystal_bill ON crystal_bill.number_bill = {$table}.number_bill left JOIN user ON user.id = {$table}.id_user  ";

		if ($from_date_stm && $to_date_stm)
        {
            $whereAll = array("crystal_bill.delete =1","crystal_bill.date BETWEEN {$from_date_stm} AND {$to_date_stm}");

        }else
        {
            $whereAll = array("crystal_bill.delete =1" );

        }


		$group="GROUP BY  {$table}.number_bill, {$table}.id_customer";

		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

	}


	public function bills_crystal_note_enter_deleted()
	{
		$this->checkPermit('bills_crystal_note_enter_deleted', 'bills_inside_system');
		$this->AdminHeaderController($this->langControl('bills_crystal_note_enter_deleted'));


		$date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;

		if (isset($_GET['date'])&&isset($_GET['todate'])) {
			$date = $_GET['date'];
			$todate = $_GET['todate'];

			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);

		}


		require($this->render($this->folder, 'html', 'bills_note_enter_deleted', 'php'));
		$this->AdminFooterController();
	}


	public function processing_note_enter_deleted($from_date_stm=null,$to_date_stm=null)
	{


		$table = 'retrieve_item';
		$primaryKey = $table.'.id';

		$columns = array(
			array('db' =>'register_user.name', 'dt' => 0,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),
			array('db' =>'register_user.phone', 'dt' => 1,
				'formatter' => function ($d, $row) {
					return strip_tags($d);
				}
			),



			array('db' => $table.'.number_bill', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return "<a href='".url.'/'.$this->folder."/details_delete/{$row[6]}/{$d}'>{$d}</a>";
				}
			),


			array('db' => 'user.username', 'dt' => 3,
				'formatter' => function ($d, $row) {
					if ($d)
					{
						return $d;

					}else{
						return '';
					}
				}
			),

			array('db' =>$table.'.delete_user', 'dt' => 4,
				'formatter' => function ($d, $row) {
					if ($d)
					{
						return $this->UserInfo($d);

					}else{
						return '';
					}
				}
			),
			array('db' =>$table.'.date', 'dt' =>5,
				'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i a',$d);
				}
			),

			array('db' =>$table.'.id_customer', 'dt' => 6),

		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);



		$join = "inner JOIN register_user ON register_user.id = {$table}.id_customer  left JOIN user ON user.id = {$table}.id_user  ";

		 $whereAll = array("{$table}.delete =1","{$table}.delete_date BETWEEN {$from_date_stm} AND {$to_date_stm}");

		$group="GROUP BY  {$table}.number_bill, {$table}.id_customer";

		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

	}



	function crystal_bill()
	{
		if ($this->handleLogin())
		{
			$cart_shop = 'cart_shop_active';
			if(isset($_GET['cart_shop']))
			{
				$cart_shop = $_GET['cart_shop'];
			}
			$number_bill=trim(str_replace(' ','',$_GET['number_bill']));
			$id=trim(str_replace(' ','',$_GET['id']));
			$crystal_bill=trim(str_replace(' ','',$_GET['crystal_bill']));
			 $stmt=$this->db->prepare("SELECT *FROM `crystal_bill` WHERE  number_bill =? AND id_customer=? AND `delete`=0");
			 $stmt->execute(array($number_bill,$id));
			 if ($stmt->rowCount() > 0)
			 {
			     if ($this->permit('admin_edit_crystal_bill',$this->folder)) {

                     $stmt_up = $this->db->prepare("UPDATE  `crystal_bill` SET  crystal_bill=? , userid=?, date=?,`edit`=0  WHERE  number_bill =? AND  id_customer=? AND `delete`=0");
                     $stmt_up->execute(array($crystal_bill, $this->userid, time(), $number_bill,$id));
                     if ($stmt_up->rowCount() > 0) {
                         $stmt_cart_shop = $this->db->prepare("UPDATE  `$cart_shop` SET  crystal_bill=?  WHERE  number_bill =? AND id_member_r=? ");
                         $stmt_cart_shop->execute(array($crystal_bill, $number_bill,$id));

                         echo '1';
                     }
                 }else
                 {
                    echo '2';
                 }
			 }else{
                 $stmt_in = $this->db->prepare("INSERT INTO  `crystal_bill` (number_bill, crystal_bill, userid, date,id_customer) values (?,?,?,?,?)  ");
                 $stmt_in->execute(array($number_bill, $crystal_bill, $this->userid, time(),$id));
                 if ($stmt_in->rowCount() > 0) {
                     $stmt_cart_shop = $this->db->prepare("UPDATE  `$cart_shop` SET  crystal_bill=?  WHERE  number_bill =? AND id_member_r=? ");
                     $stmt_cart_shop->execute(array($crystal_bill, $number_bill,$id));

                     echo '1';
                 }

			 }

		}


	}




	function name_admin($id)
	{
		$stmt =$this->db->prepare("SELECT *FROM `user` WHERE  id=? ");
		$stmt->execute(array($id));
		if ($stmt->rowCount() > 0)
		{
			$result=$stmt->fetch(PDO::FETCH_ASSOC);
			return $result['username'];
		}else
		{
			return ' غير معروف';

		}
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


	public function disaccount($id,$id_user)
	{
		if ($this->handleLogin()) {

			$discount=trim($_POST['discount']);
			$discount=(int)$discount;
			$stmt1=$this->db->prepare("SELECT *FROM  bills_inside_system  WHERE `id` = ? AND `id_user`=? AND  `money` > 0");
			$stmt1->execute(array($id,$id_user));
			if ($stmt1->rowCount() > 0)
			{
				$stmt=$this->db->prepare("UPDATE bills_inside_system SET `money`=money-?   WHERE `id` = ? AND `id_user`=?");
				$stmt->execute(array($discount,$id,$id_user));
			}else{
				echo 0;
			}

		}

	}


	public function sumNomberBill($id,$n_b,$cart_shop)
	{
		$stmt = $this->db->prepare("SELECT *FROM $cart_shop WHERE `id_member_r`=? AND `number_bill` =? ");
		$stmt->execute(array($id,$n_b));
		return $stmt;
	}


	function sunAmountBillByNumberBill($id,$n_b,$cart_shop='cart_shop_active')
	{

		$stmt=$this->sumNomberBill($id,$n_b,$cart_shop);
		$request=array();

		$sum=0;
		$number_bill=0;
		$date_req=array();
		$price1=0;
		$p1=0;
		$p2=0;
		$xp1=0;
		$xp2=0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{

            $cuts=$this->cuts($row['id_item'],$row['table']);
			if (!empty($cuts)) {

				$price = explode('-',$cuts)  ;
				$f1 = (double)trim(str_replace(',', '', $price[0]));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1= number_format(round($xp1));

			}else {

                if ($this->check_item_round($row['table'],$row['id_item'])) {
                    $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
                }else
                {
                    $price = $this->not_round_price($row['price_dollars'], $row['dollar_exchange']);
                }

				$f1 = (int)trim(str_replace(',', '', $price));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1= number_format($xp1);

			}


		}

		return $price1;
	}


	public  function details($id,$number_bill,$cart_shop='cart_shop_active')
	{

		if (!is_numeric($id)) {$error=new Errors(); $error->index();}
		$this->checkPermit('view_request',$this->folder);
		$this->AdminHeaderController($this->langControl('view_request'));

		$bills_crystal=null;
		$stmtc=$this->db->prepare("SELECT * FROM `crystal_bill` WHERE `number_bill`=?");
		$stmtc->execute(array($number_bill));
		if($stmtc->rowCount() > 0){
		  	$bills_crystal=$stmtc->fetch(PDO::FETCH_ASSOC)['crystal_bill'];
		}


		$stmt=$this->db->prepare("SELECT *FROM `register_answer` WHERE `id_user`=?");
		$stmt->execute(array($id));
		$answer=$stmt->fetch(PDO::FETCH_ASSOC);


		$id_user = $id;
		$stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ?    LIMIT 1");
		$stmt->execute(array($id_user));
		$result = $stmt->fetch();



		$stmt=$this->getAllContentFromCar($id,$number_bill,$cart_shop);
		$request=array();

        $sum=0;
        $date_req=array();
        $price1=0;
        $date=0;
        $xp1=0;
        $xpd=0;
        $number_type=0;
        $sum_material=0;
        $price_dollars=0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{


			if (!empty($this->cuts($row['id_item'],$row['table']))) {

				$price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
				$f1 = (double)trim(str_replace(',', '', $price[0]));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1= number_format(round($xp1));

			}else {
                if ($this->check_item_round($row['table'],$row['id_item'])) {
                    $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
                }else
                {
                    $price = $this->not_round_price($row['price_dollars'], $row['dollar_exchange']);
                }
				$f1 = (int)trim(str_replace(',', '', $price));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1= number_format($xp1);

			}


            $pd=explode('-',$row['price_dollars'])  ;
            $f1d= (double)trim(str_replace(',','.', $pd[0]));
            $xpd = $xpd + ($f1d * $row['number']);
            $price_dollars= $xpd;
            $number_type=$number_type+1;
            $sum_material=$sum_material+$row['number'];

            $date=$row['date'];
            $seles=$this->UserInfo($row['id_prepared']);


            $number_bill=$row['number_bill'];
			$table=$row['table'];
			$stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
			$stmt_get_item->execute(array($row['id_item']));
			$item = $stmt_get_item->fetch();

			$row['title']=$item['title'];
			$row['img']=$this->save_file.$row['image'];

			$date_req[$row['date_req']]=$row['date_req'];



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
                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->not_round_price($row['price_dollars'],$row['dollar_exchange']).' د.ع ';

                    }
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
                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->not_round_price($row['price_dollars'],$row['dollar_exchange']).' د.ع ';

                    }
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
                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->not_round_price($row['price_dollars'],$row['dollar_exchange']).' د.ع ';

                    }
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
                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->not_round_price($row['price_dollars'],$row['dollar_exchange']).' د.ع ';

                    }
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
                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->not_round_price($row['price_dollars'],$row['dollar_exchange']).' د.ع ';

                    }
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
                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->not_round_price($row['price_dollars'],$row['dollar_exchange']).' د.ع ';

                    }
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
                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->not_round_price($row['price_dollars'],$row['dollar_exchange']).' د.ع ';

                    }
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
                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->not_round_price($row['price_dollars'],$row['dollar_exchange']).' د.ع ';

                    }
                }

			}


			$request[]=$row;
		}
		$date_req=json_encode($date_req);

		$groups=array();
		$stmt_groups =$this->db->prepare("SELECT *FROM `usergroup` WHERE `name` LIKE '%توصيل%' ");
		$stmt_groups->execute();
		while ($row = $stmt_groups->fetch(PDO::FETCH_ASSOC))
		{

			$groups[]= $row;


		}

		require($this->render($this->folder, 'html', 'details', 'php'));

		$this->AdminFooterController();
	}


	public  function details_bill($id,$number_bill)
	{

		if (!is_numeric($id)) {$error=new Errors(); $error->index();}
		$this->checkPermit('view_request',$this->folder);

		$bills_crystal=null;
		$stmtc=$this->db->prepare("SELECT * FROM `crystal_bill` WHERE `number_bill`=?");
		$stmtc->execute(array($number_bill));
		if($stmtc->rowCount() > 0){
		  	$bills_crystal=$stmtc->fetch(PDO::FETCH_ASSOC)['crystal_bill'];
		}


		$stmt=$this->db->prepare("SELECT *FROM `register_answer` WHERE `id_user`=?");
		$stmt->execute(array($id));
		$answer=$stmt->fetch(PDO::FETCH_ASSOC);


		$id_user = $id;
		$stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ?    LIMIT 1");
		$stmt->execute(array($id_user));
		$result = $stmt->fetch();



		$stmt=$this->getAllContentFromCar($id,$number_bill);
		$request=array();

        $sum=0;
        $date_req=array();
        $price1=0;
        $date=0;
        $xp1=0;
        $xpd=0;
        $number_type=0;
        $sum_material=0;
        $price_dollars=0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{


			if (!empty($this->cuts($row['id_item'],$row['table']))) {

				$price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
				$f1 = (double)trim(str_replace(',', '', $price[0]));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1= number_format(round($xp1));

			}else {
                if ($this->check_item_round($row['table'],$row['id_item'])) {
                    $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
                }else
                {
                    $price = $this->not_round_price($row['price_dollars'], $row['dollar_exchange']);
                }
				$f1 = (int)trim(str_replace(',', '', $price));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1= number_format($xp1);

			}


            $pd=explode('-',$row['price_dollars'])  ;
            $f1d= (double)trim(str_replace(',','.', $pd[0]));
            $xpd = $xpd + ($f1d * $row['number']);
            $price_dollars= $xpd;
            $number_type=$number_type+1;
            $sum_material=$sum_material+$row['number'];

            $date=$row['date'];
            $seles=$this->UserInfo($row['id_prepared']);


            $number_bill=$row['number_bill'];
			$table=$row['table'];
			$stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
			$stmt_get_item->execute(array($row['id_item']));
			$item = $stmt_get_item->fetch();

			$row['title']=$item['title'];
			$row['img']=$this->save_file.$row['image'];

			$date_req[$row['date_req']]=$row['date_req'];



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
                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->not_round_price($row['price_dollars'],$row['dollar_exchange']).' د.ع ';

                    }
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
                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->not_round_price($row['price_dollars'],$row['dollar_exchange']).' د.ع ';

                    }
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
                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->not_round_price($row['price_dollars'],$row['dollar_exchange']).' د.ع ';

                    }
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
                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->not_round_price($row['price_dollars'],$row['dollar_exchange']).' د.ع ';

                    }
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
                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->not_round_price($row['price_dollars'],$row['dollar_exchange']).' د.ع ';

                    }
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
                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->not_round_price($row['price_dollars'],$row['dollar_exchange']).' د.ع ';

                    }
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
                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->not_round_price($row['price_dollars'],$row['dollar_exchange']).' د.ع ';

                    }
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
                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }else
                    {
                        $row['price']= $this->not_round_price($row['price_dollars'],$row['dollar_exchange']).' د.ع ';

                    }
                }

			}


			$request[]=$row;
		}
		$date_req=json_encode($date_req);

		$groups=array();
		$stmt_groups =$this->db->prepare("SELECT *FROM `usergroup` WHERE `name` LIKE '%توصيل%' ");
		$stmt_groups->execute();
		while ($row = $stmt_groups->fetch(PDO::FETCH_ASSOC))
		{

			$groups[]= $row;


		}

		require($this->render($this->folder, 'html', 'details_bill', 'php'));


	}



	public  function details_delete($id,$number_bill)
	{

		if (!is_numeric($number_bill)) {$error=new Errors(); $error->index();}
		$this->checkPermit('view_request',$this->folder);
		$this->AdminHeaderController($this->langControl('view_request'));




		$stmt=$this->db->prepare("SELECT *FROM `register_answer` WHERE `id_user`=?");
		$stmt->execute(array($id));
		$answer=$stmt->fetch(PDO::FETCH_ASSOC);


		$id_user = $id;
		$stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ?    LIMIT 1");
		$stmt->execute(array($id_user));
		$result = $stmt->fetch();



		$stmt = $this->db->prepare("SELECT `id`, `id_item`,`price`,`color`,`code`,`table`,SUM(`number`)as number,`date`,`number_bill`,`dollar_exchange`,image FROM `retrieve_item` WHERE `id_customer` =? AND `number_bill`=?  GROUP BY `id_item`,`table`,`code`,`color`,`number_bill` ORDER BY `id` DESC  ");
		$stmt->execute(array($id,$number_bill));
		$request=array();

		$sum=0;
		$date_req=array();
		$price1=0;
		$p1=0;
		$p2=0;
		$xp1=0;
		$xp2=0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{


			if (!empty($this->cuts($row['id_item'],$row['table']))) {

				$price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
				$f1 = (double)trim(str_replace(',', '', $price[0]));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1= number_format(round($xp1));

			}else {
				$price =$this->price_dollarsAdmin($row['price'],$row['dollar_exchange']);
				$f1 = (int)trim(str_replace(',', '', $price));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1= number_format($xp1);

			}


			$number_bill=$row['number_bill'];
			$table=$row['table'];
			$stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
			$stmt_get_item->execute(array($row['id_item']));
			$item = $stmt_get_item->fetch();

			$row['title']=$item['title'];
			$row['img']=$this->save_file.$row['image'];

			$date_req[$row['date']]=$row['date'];
            $row['price']= $this->price_dollarsAdmin($row['price'],$row['dollar_exchange']).' د.ع ';


			$request[]=$row;
		}

		require($this->render($this->folder, 'html', 'details_delete', 'php'));

		$this->AdminFooterController();
	}



	public function getAllContentFromCar($id_member_r,$number_bill,$cart_shop='cart_shop_active')
	{
		$stmt = $this->db->prepare("SELECT   $cart_shop.*,SUM(`number`)as number  FROM `$cart_shop` WHERE `id_member_r` =? AND `number_bill`=?   GROUP BY `id_item`,`table`,`code`,`color`,`number_bill` ORDER BY `id` DESC  ");
		$stmt->execute(array($id_member_r,$number_bill));
		return $stmt;
	}

function all_delete_bill()
{

	$stmt = $this->db->prepare("SELECT  count(*)  FROM `crystal_bill`  WHERE   `delete`=1 AND date_checked=0");
	$stmt->execute();
	return $stmt->fetchColumn() ;

}

function all_note_enter_bill()
{

	$stmt = $this->db->prepare("SELECT COUNT(t.row) as num FROM (SELECT  count(id) as row  FROM `cart_shop_active`    WHERE  accountant = 1 AND crystal_bill  = '' AND  cancel = 0  AND  group_bill = ''    GROUP BY  number_bill,id_member_r) as t") ;
	$stmt->execute();
	if ($stmt->rowCount() >0)
    {
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return $result['num'] ;

    }else
    {
        return 0;
    }


}
function noty_menu()
{

	$stmt = $this->db->prepare("SELECT COUNT(t.row) as num FROM (SELECT  count(id) as row  FROM `cart_shop_active`    WHERE  accountant = 1 AND crystal_bill  = '' AND  cancel = 0  AND  group_bill = ''    GROUP BY  number_bill,id_member_r) as t") ;
	$stmt->execute();
	if ($stmt->rowCount() >0)
    {
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        echo $result['num'] ;

    }else
    {
        echo 0;
    }


}


function chbill()
{
	$h1 = date('Y-m-d h:00:00 a',time());

	$timestamp = strtotime($h1) + 60*60;

	$h2= date('Y-m-d h:i:s a', $timestamp);

	  $t1=strtotime($h1);
	  $t2=strtotime($h2);

        $number_bill=array();

	$stmt = $this->db->prepare("SELECT   number_bill FROM `crystal_bill`  WHERE crystal_bill <> '' AND `delete`=0 AND date between ? AND ?");
	$stmt->execute(array($t1,$t2));
	if ($stmt->rowCount() > 0)
	{
		while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$number_bill[]=$row['number_bill'];
		}
		echo json_encode($number_bill);
	}


}

    function add_group()
    {

        $this->checkPermit('add_group', $this->folder);
        $stmt = $this->db->prepare("SELECT   number_bill FROM `cart_shop_active`  WHERE  accountant = 1 AND prepared=2 AND crystal_bill  = '' AND  cancel = 0  AND  group_bill = ''   GROUP BY number_bill,id_member_r order by id limit 100") ;
        $stmt->execute();
        $bill=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {
            if ($this->ch_prepared($row['number_bill'])  )
            {
                $bill[]=$row['number_bill'];
            }
        }

        if (!empty($bill)) {

            $number = 1;
            $stmt_sq = $this->db->prepare("SELECT `number` FROM group_bill ORDER BY `number` DESC  LIMIT 1");
            $stmt_sq->execute();
            if ($stmt_sq->rowCount() > 0) {
                $num = $stmt_sq->fetch(PDO::FETCH_ASSOC);
                $number = $num['number'] + 1;
            }

            $time=time();
            $values="";

            $list_bill=implode(',',$bill);
            foreach ($bill as $data)
            {
                $values.="(
                    '{$list_bill}',
                    '{$data}',
                    '{$number}',
                    {$this->userid},
                    {$time}
                   )," ;

                $stmt_cart_shop = $this->db->prepare("UPDATE  `cart_shop_active` SET  group_bill=?   WHERE  number_bill =?   ");
                $stmt_cart_shop->execute(array($number, $data));

            }

              $values=rtrim($values, ',');
                $stmt_add=$this->db->prepare("INSERT INTO group_bill (`name`, `number_bill`, `number`, `userid`, `date`) values {$values}");
                $stmt_add->execute();
                if ($stmt_add->rowCount() > 0)
                {
                  echo $number;
                }
        }


    }







    function group_not_enter()
    {

        $this->checkPermit('group_not_enter', 'bills_inside_system');
        $this->AdminHeaderController($this->langControl('group_not_enter'));

//
//        $stmt = $this->db->prepare("SELECT  cart_shop_active.number_bill FROM `cart_shop_active`  left JOIN crystal_bill ON crystal_bill.number_bill = cart_shop_active.number_bill    WHERE   cart_shop_active.number_bill not in(SELECT number_bill FROM group_bill) AND  cart_shop_active.accountant = 1 AND  cart_shop_active.prepared = 2 AND cart_shop_active.cancel=0 AND  crystal_bill.number_bill is null GROUP BY cart_shop_active.number_bill") ;
//        $stmt->execute();
//        $bill=array();
//        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
//        {
//            if ($this->ch_prepared($row['number_bill'])  )
//            {
//                $bill[]=$row['number_bill'];
//            }
//        }


        $date=null;
        $todate=null;

        $from_date_stm=null;
        $to_date_stm=null;

        if (isset($_GET['date'])&&isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);

        }


        require($this->render($this->folder, 'group', 'group_not_enter', 'php'));
        $this->AdminFooterController();

    }



    public function processing_group_not_enter($from_date_stm=null,$to_date_stm=null)
    {

        $table = $this->group_bill;
        $primaryKey = $this->group_bill.'.id';

        $columns = array(


            array('db' => $table.'.number', 'dt' => 0  ),

            array('db' => $table.'.name', 'dt' => 1  ),
            array('db' => $table.'.userid', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return  $this->UserInfo($d);
                }
            ),



            array('db' => $table.'.date', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i a',$d);
                }
            ),


            array('db' => $table.'.number', 'dt' => 4,
                'formatter' => function ($d, $row) {

                    return "
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-auto' style='padding-left: 2px'>		
				  	       <input id='numberBill_{$d}'  type='text' class='form-control withBill' name='crystal_bill' autocomplete='off' required>
                   </div>
				  <div class='col-auto' style='padding-right: 2px'>
				   <button type='submit' id='btn_in_bill_{$d}' onclick=saveBill('".$d."')  name='submit' class='btn btn-warning'>حفظ</button>
                  </div>
                  </div>
                    " ;
                }
            ),

            array('db' => $table.'.number', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/export_group/{$d}'><span>تصدير مواد الفواتير</span></a>";
                }
            ),

            array('db' => $table.'.number', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/export_serial/{$d}'><span>  تصدير السريلات الفواتير    </span></a>";
                }
            ),

            array('db' =>$table.'.number', 'dt' => 7),//7




        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = " left JOIN crystal_bill ON crystal_bill.number_bill = group_bill.crystal_bill ";
        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array("crystal_bill.number_bill is null","group_bill.crystal_bill  = '' ");

        }else{
            $whereAll = array("crystal_bill.number_bill is null","group_bill.crystal_bill  = '' ","group_bill.date BETWEEN {$from_date_stm} AND {$to_date_stm}" );

        }
        $group="GROUP BY  group_bill.number";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

    }



    function group_enter()
    {

        $this->checkPermit('group_enter', 'bills_inside_system');
        $this->AdminHeaderController($this->langControl('group_enter'));


        $date=null;
        $todate=null;

        $from_date_stm=null;
        $to_date_stm=null;

        if (isset($_GET['date'])&&isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);

        }


        require($this->render($this->folder, 'group', 'group_enter', 'php'));
        $this->AdminFooterController();

    }



    public function processing_group_enter($from_date_stm=null,$to_date_stm=null)
    {

        $table = $this->group_bill;
        $primaryKey ='id';

        $columns = array(


            array('db' => 'number', 'dt' => 0  ),

            array('db' => 'name', 'dt' => 1  ),

            array('db' => 'userid', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return  $this->UserInfo($d);
                }
                    ),

          array('db' => 'user_input_bill', 'dt' => 3,
                        'formatter' => function ($d, $row) {
                            return  $this->UserInfo($d);
                        }
                    ),



            array('db' => 'date', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i a',$d);
                }
            ),

            array('db' =>'crystal_bill', 'dt' => 5),

            array('db' => 'number', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    if ($this->permit('edit_crystal_bill_group',$this->folder)) {
                        return "
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-auto' style='padding-left: 2px'>		
				  	       <input id='numberBill_{$d}' value='{$row[5]}'  type='text' class='form-control withBill' name='crystal_bill' required>
                   </div>
				  <div class='col-auto' style='padding-right: 2px'>
				   <button type='submit' id='btn_in_bill_{$d}' onclick=saveBill('" . $d . "')  name='submit' class='btn btn-success'>تعديل</button>
                  </div>
                  </div>
                    ";
                    }
                    else
                    {
                        return 'لا تمتلك صلاحية';
                    }
                }
            ),

            array('db' => 'number', 'dt' => 7,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/export_group_enter/{$d}'><span>تصدير مواد الفواتير</span></a>";
                }
            ),

            array('db' => 'number', 'dt' => 8,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/export_serial/{$d}'><span>  تصدير السريلات الفواتير    </span></a>";
                }
            ),


            array('db' =>'number', 'dt' => 9),
            array('db' =>'crystal_bill', 'dt' => 10),




        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


     /*   $join = " left JOIN crystal_bill ON crystal_bill.number_bill = group_bill.crystal_bill ";
        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array(" group_bill.crystal_bill <> '' ");

        }else{
            $whereAll = array("group_bill.crystal_bill <> '' ","group_bill.date BETWEEN {$from_date_stm} AND {$to_date_stm}" );

        }
        $group="GROUP BY  group_bill.number";
*/

        if (empty($from_date_stm) && empty($to_date_stm))
        {
        echo json_encode(

            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null,"crystal_bill <> '' GROUP BY  number"));
        }else{
            echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null,"crystal_bill <> '' AND date BETWEEN {$from_date_stm} AND {$to_date_stm} GROUP BY  number"));

        }
    }



    public function export_group($number)
    {
        $this->checkPermit('export_group', $this->folder);
        $this->adminHeaderController($this->langControl('export_group'));




        if (!is_numeric($number))
        {
            $error=new Errors();
            $error->index();
        }


        $stmt = $this->db->prepare("SELECT   * FROM {$this->group_bill}    WHERE  number=?   LIMIT 1") ;
        $stmt->execute(array($number));
        if ($stmt->rowCount() < 1)
        {
            $error=new Errors();
            $error->index();
        }


        $result=$stmt->fetch(PDO::FETCH_ASSOC);

        $date=null;
        $todate=null;

        $from_date_stm=null;
        $to_date_stm=null;

        if (isset($_GET['date'])&&isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);

        }


        require($this->render($this->folder, 'group', 'bills_materials_not_enter', 'php'));
        $this->adminFooterController();
    }


    public function processing_bill_materials_crystal_not_enter($number,$from_date_stm=null,$to_date_stm=null)
    {



        $stmt = $this->db->prepare("SELECT   number_bill FROM group_bill    WHERE  number=?") ;
        $stmt->execute(array($number));
        $bill=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $bill[]=$row['number_bill'];

        }

        $ids= implode(',',$bill) ;



        $table = $this->table;
        $primaryKey = $this->table.'.id';

        $columns = array(

            array('db' => $this->table.'.code', 'dt' => 0   ),
            array('db' => $this->table.'.number_bill', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return $this->sum_quantity($d,$row[7],$row[11],$row[12],$row[0]);
                }
            ),

            array('db' => $this->table.'.price_dollars', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return $this->price_dollarsAdmin($d);
                }
            ),
            array('db' => $this->table.'.location', 'dt' => 3,
                'formatter' => function ($d, $row) {

                    return  $this->storehouse($d,$row[0],$row[12]) ;
                }
            ),


            array('db' => $this->table.'.number_bill', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/details/{$row[7]}/{$d}'>{$d}</a>";
                }
            ),

            array('db' => $this->table.'.date_accountant', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return  date('Y-m-d h:i:s a',$d);
                }
            ),


            array('db' => $this->table.'.number_bill', 'dt' => 6,
                'formatter' => function ($d, $row) {
                   $date= date('Y-m-d h:i:s a',$row[5]);
                   return "{$this->customerInfo($row[7])} ,{$this->UserInfo($row[8],'c')},{$this->UserInfo($row[9])},{$this->UserInfo($row[10])}   {$this->UserInfo($row[8])},{$d},{$this->details_offer($row[13],'title')},{$this->info_price_type($row[14])},{$date}";
                }

            ),

            array('db' =>$this->table.'.id_member_r', 'dt' =>7 ),
            array('db' =>$this->table.'.user_direct', 'dt' =>8 ),
            array('db' =>$this->table.'.id_accountant_user', 'dt' =>9 ),
            array('db' =>$this->table.'.id_prepared', 'dt' =>10 ),
            array('db' =>$this->table.'.id_item', 'dt' =>11 ),
            array('db' =>$this->table.'.table', 'dt' =>12 ),
            array('db' =>$this->table.'.id_offer', 'dt' =>13 ),
            array('db' =>$this->table.'.price_type', 'dt' =>14 ),






        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "inner JOIN register_user ON register_user.id = cart_shop_active.id_member_r left JOIN crystal_bill ON crystal_bill.number_bill = cart_shop_active.number_bill left JOIN user ON user.id = cart_shop_active.id_accountant_user ";
        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array("cart_shop_active.number_bill IN({$ids})");

        }else{
            $whereAll = array("cart_shop_active.date_req BETWEEN {$from_date_stm} AND {$to_date_stm}","cart_shop_active.number_bill IN({$ids})");
        }

        $group="GROUP BY  cart_shop_active.id_item, cart_shop_active.code, cart_shop_active.table,cart_shop_active.id_member_r,cart_shop_active.number_bill";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

    }




    public function export_group_enter($number)
    {
        $this->checkPermit('export_group_enter', $this->folder);
        $this->adminHeaderController($this->langControl('export_group_enter'));




        $stmt = $this->db->prepare("SELECT   * FROM group_bill    WHERE  number=? AND  crystal_bill  <> '' LIMIT 1") ;
        $stmt->execute(array($number));
        if ($stmt->rowCount() < 1)
        {
          $error=new Errors();
          $error->index();
        }
        $result=$stmt->fetch(PDO::FETCH_ASSOC);




        $date=null;
        $todate=null;

        $from_date_stm=null;
        $to_date_stm=null;

        if (isset($_GET['date'])&&isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);

        }


        require($this->render($this->folder, 'group', 'bills_materials_enter', 'php'));
        $this->adminFooterController();
    }


    public function processing_bill_materials_crystal_enter($number,$from_date_stm=null,$to_date_stm=null)
    {



        $stmt = $this->db->prepare("SELECT   number_bill FROM group_bill    WHERE  number=?") ;
        $stmt->execute(array($number));
        $bill=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $bill[]=$row['number_bill'];

        }

        $ids= implode(',',$bill) ;



        $table = $this->table;
        $primaryKey = $this->table.'.id';

        $columns = array(


            array('db' => $this->table.'.code', 'dt' => 0   ),
            array('db' => $this->table.'.number_bill', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return $this->sum_quantity($d,$row[7],$row[11],$row[12],$row[0]);
                }
            ),

            array('db' => $this->table.'.price_dollars', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return $this->price_dollarsAdmin($d);
                }
            ),
            array('db' => $this->table.'.location', 'dt' => 3,
                'formatter' => function ($d, $row) {

                    return  $this->storehouse($d,$row[0],$row[12]) ;
                }
            ),


            array('db' => $this->table.'.number_bill', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/details/{$row[7]}/{$d}'>{$d}</a>";
                }
            ),

            array('db' => $this->table.'.date_accountant', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return  date('Y-m-d h:i:s a',$d);
                }
            ),


            array('db' => $this->table.'.number_bill', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    $date= date('Y-m-d h:i:s a',$row[5]);
                    return "{$this->customerInfo($row[7])} ,{$this->UserInfo($row[8],'c')},{$this->UserInfo($row[9])},{$this->UserInfo($row[10])}   {$this->UserInfo($row[8])},{$d},{$this->details_offer($row[13],'title')},{$this->info_price_type($row[14])},{$date}";
                }

            ),

            array('db' =>$this->table.'.id_member_r', 'dt' =>7 ),
            array('db' =>$this->table.'.user_direct', 'dt' =>8 ),
            array('db' =>$this->table.'.id_accountant_user', 'dt' =>9 ),
            array('db' =>$this->table.'.id_prepared', 'dt' =>10 ),
            array('db' =>$this->table.'.id_item', 'dt' =>11 ),
            array('db' =>$this->table.'.table', 'dt' =>12 ),
            array('db' =>$this->table.'.id_offer', 'dt' =>13 ),
            array('db' =>$this->table.'.price_type', 'dt' =>14 ),



        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "inner JOIN register_user ON register_user.id = cart_shop_active.id_member_r left JOIN crystal_bill ON crystal_bill.number_bill = cart_shop_active.number_bill left JOIN user ON user.id = cart_shop_active.id_accountant_user ";
        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array("cart_shop_active.number_bill IN({$ids})");

        }else{
            $whereAll = array("cart_shop_active.date_req BETWEEN {$from_date_stm} AND {$to_date_stm}","cart_shop_active.number_bill IN({$ids})");

        }

        $group="GROUP BY  cart_shop_active.id_item,  cart_shop_active.code, cart_shop_active.table,cart_shop_active.id_member_r,cart_shop_active.number_bill";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

    }

    function info_price_type($num)
    {

        if ($num)
        {
            if (in_array($num,array(1,2,3)))
            {
                return  $this->price_type[$num];
            }
        }else
        {
            return 'سعر مفرد';
        }

    }


        function storehouse($location,$code,$table)
        {



            if ($table =='product_savers')
            {
                $table='savers';
            }


            $loc=explode(',',$location);

            $sequence = array();
            foreach ($loc as $l)
            {
                if ($l)
                {
                    $stmt = $this->db->prepare("SELECT  sequence FROM location  WHERE  location=? AND code=? AND  `model`=? LIMIT  1");
                    $stmt->execute(array(trim($l),$code,$table));
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $sequence[] = $row['sequence'];
                    }
                }

            }

            $store=array();
            foreach ($sequence as $sq)
            {
                $stmt2 = $this->db->prepare("SELECT  * FROM  group_location   WHERE {$sq} between `from` AND  `to` LIMIT 1 ");
                $stmt2->execute();
                $name_store=$stmt2->fetch(PDO::FETCH_ASSOC);

                if (!in_array($name_store['title'],$store))
                {
                    $store[]=$name_store['title'];

                }

            }
            return implode(',',$store);

        }



        function sum_quantity($number_bill,$id_member,$id_item,$table,$code)
        {

            $stmt = $this->db->prepare("SELECT SUM(number) as number FROM `cart_shop_active`   where  number_bill =? AND  id_member_r =? AND id_item=? AND `table`=? AND `code` = ? ") ;
            $stmt->execute(array($number_bill,$id_member,$id_item,$table,$code));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $result['number'];

        }



        function crystal_bill_group()
        {
            if ($this->handleLogin()) {


                $number = trim(str_replace(' ', '', $_GET['number_group']));
                $crystal_bill = trim(str_replace(' ', '', $_GET['crystal_bill']));


                $stmt = $this->db->prepare("SELECT   number_bill FROM group_bill    WHERE  number=? ");
                $stmt->execute(array($number));
                $bill = array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $bill[] = $row['number_bill'];
                }


                $stmt_ch = $this->db->prepare("SELECT   number_bill FROM group_bill    WHERE  number=? AND crystal_bill = ''");
                $stmt_ch->execute(array($number));
                 if ($stmt_ch->rowCount() > 0) {

                     $stmt_up = $this->db->prepare("UPDATE  `group_bill` SET  crystal_bill=? , user_input_bill=?  WHERE  number =?   ");
                     $stmt_up->execute(array($crystal_bill, $this->userid, $number));
                     if ($stmt_up->rowCount() > 0) {

                         $time = time();
                         $values = "";

                         foreach ($bill as $data) {
                             $values .= "(
                     '{$data}',
                     '{$crystal_bill}',
                    {$this->userid},
                    {$time}
                   ),";
                         }

                         $values = rtrim($values, ',');

                         $stmt_in = $this->db->prepare("INSERT INTO  `crystal_bill` (number_bill, crystal_bill, userid, date) values  {$values}  ");
                         $stmt_in->execute();
                         if ($stmt_in->rowCount() > 0) {

                             foreach ($bill as $data) {
                                 $stmt_cart_shop = $this->db->prepare("UPDATE  `cart_shop_active` SET  crystal_bill=?   WHERE  number_bill =?   ");
                                 $stmt_cart_shop->execute(array($crystal_bill, $data));
                             }

                             echo $number;
                         }

                     }
                 }else
                 {

                     $stmt_up = $this->db->prepare("UPDATE  `group_bill` SET  crystal_bill=? , user_input_bill=?  WHERE  number =?   ");
                     $stmt_up->execute(array($crystal_bill, $this->userid, $number));
                     if ($stmt_up->rowCount() > 0) {

                         echo '1';
                         foreach ($bill as $data) {
                             $stmt_up2 = $this->db->prepare("UPDATE  `crystal_bill` SET  crystal_bill=? , userid=?, date=?,`edit`=0  WHERE  number_bill =?  AND `delete`=0");
                             $stmt_up2->execute(array($crystal_bill, $this->userid, time(), $data));

                                 $stmt_cart_shop = $this->db->prepare("UPDATE  `cart_shop_active` SET  crystal_bill=? WHERE  number_bill =?   ");
                                 $stmt_cart_shop->execute(array($crystal_bill, $data));


                         }
                     }

                 }
            }

        }





    function  ch_prepared($bill)
    {
        $stmt = $this->db->prepare("SELECT  cart_shop_active.number_bill FROM `cart_shop_active`   where  number_bill =? AND  prepared =1 ") ;
        $stmt->execute(array($bill));
        if ($stmt->rowCount() > 0)
        {
            return false;
        }else
        {
            return true;
        }
    }





    public function export_serial($number)
    {
        $this->checkPermit('export_serial', $this->folder);
        $this->adminHeaderController($this->langControl('export_serial'));



        $stmtde = $this->db->prepare("SELECT   * FROM group_bill    WHERE  number=?  LIMIT 1") ;
        $stmtde->execute(array($number));
        if ($stmtde->rowCount() < 1)
        {
            $error=new Errors();
            $error->index();
        }

        $result=$stmtde->fetch(PDO::FETCH_ASSOC);


        $stmt = $this->db->prepare("SELECT   number_bill FROM group_bill    WHERE  number=?") ;
        $stmt->execute(array($number));
        $bill=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $bill[]=$row['number_bill'];

        }



         $ids= implode(',',$bill) ;

        $stmtc = $this->db->prepare("SELECT     id,code,enter_serial FROM  cart_shop_active    WHERE   cart_shop_active.number_bill IN({$ids})  AND  `enter_serial`  <> '' ") ;
        $stmtc->execute();
        $serial=array();
        while ($row =$stmtc->fetch(PDO::FETCH_ASSOC))
        {
            $s=explode(',',$row['enter_serial']);
            foreach ($s as $key => $n)
            {
                $serial[$row['id']][$n]=$row['code'];

            }

        }



        require($this->render($this->folder, 'group', 'export_serial', 'php'));
        $this->adminFooterController();
    }




//    function store_location($location,$model,$code)
//    {
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




/*
 * ادخال فواتير كرستال والمجموعات الفواتير النظام
function x()
{



    $list="80371
80333
80354
80356
80372
80315
80369
80373
80315
80373
80337
80325
80348
80335
80368
80338
80345
80353
80360
80360
80360
80365
80347
80344
80346
80338
80358
80336
80338
80349
80329
80327
80332
80334
80361
80339
80370
80374
80315
80342
80359
80364
80343
80357
80360
80367
80341
80375
80366
80351
80343
80355
80363
80352
80350
80340
80376";



    $your_array =  explode("\n", $list);


//    echo  $your_array = implode(",", $your_array);


 $name='80377,80378,80379,80380,80381,80382,80383,80384,80385,80386,80387,80388,80389,80390,80391,80392,80393,80394,80395,80397,80398,80399,80400,80401,80402,80403,80405,80406,80407,80408,80409,80410,80411,80412,80413,80414,80415,80417,80419,80421,80422,80423,80371 ,80333 ,80354 ,80356 ,80372 ,80315 ,80369 ,80373 ,80315 ,80373 ,80337 ,80325 ,80348 ,80335 ,80368 ,80338 ,80345 ,80353 ,80360 ,80360 ,80360 ,80365 ,80347 ,80344 ,80346 ,80338 ,80358 ,80336 ,80338 ,80349 ,80329 ,80327 ,80332 ,80334 ,80361 ,80339 ,80370 ,80374 ,80315 ,80342 ,80359 ,80364 ,80343 ,80357 ,80360 ,80367 ,80341 ,80375 ,80366 ,80351 ,80343 ,80355 ,80363 ,80352 ,80350 ,80340 ,80376';

foreach ($your_array as $b)
{
    $sg=$this->db->prepare("INSERT INTO group_bill ( name, number_bill, crystal_bill, number, userid, user_input_bill, checked, user_checked, date) values (?,?,?,?,?,?,?,?,?)");
    $sg->execute(array($name,$b,13196,2365,$this->userid,$this->userid,0,0,time()));

    $sg=$this->db->prepare("INSERT INTO crystal_bill (  number_bill, crystal_bill, userid,  checked, user_checked, date) values (?,?,?,?,?,?)");
    $sg->execute(array($b,13196,$this->userid,0,0,time()));
    echo $b;
}



}
*/




    public function bills_crystal_not_enter_cancel()
    {
        $this->checkPermit('bills_crystal_not_enter_cancel', 'bills_inside_system');
        $this->AdminHeaderController($this->langControl('bills_crystal_not_enter_cancel'));





        $date=null;
        $todate=null;

        $from_date_stm=null;
        $to_date_stm=null;

        if (isset($_GET['date'])&&isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);

        }


        require($this->render($this->folder, 'cancel', 'bills_crystal_not_enter_cancel', 'php'));
        $this->AdminFooterController();
    }



    public function processing_bills_crystal_not_enter_cancel($from_date_stm=null,$to_date_stm=null)
    {

        $table = $this->table;
        $primaryKey = $this->table.'.id';

        $columns = array(
            array('db' =>'register_user.name', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),
            array('db' =>'register_user.phone', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),


            array('db' => $this->table.'.date_req', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i a',$d);
                }
            ),
            array('db' => $this->table.'.number_bill', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    if ($row[15]==1)
                    {
                        if ($row[13] == 1)
                        {
                            return   $this->sunAmountBillByNumberBill($row[10],$d)  ;

                        }else{
                            return "<span   data-toggle='tooltip' data-placement='top' title='تم تغير  سعر الفاتورة '   style='color: red'> {$this->sunAmountBillByNumberBill($row[9],$d)} </span>";

                        }
                    }else
                    {
                        if ($row[13] == 1)
                        {
                            return $this->sunAmountBillByNumberBill($row[10],$d)  ;

                        }else{
                            return $this->sunAmountBillByNumberBill($row[10],$d);

                        }
                    }


                }
            ),

            array('db' => $this->table.'.id_accountant_user', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return  $this->UserInfo($d);
                }
            ),
            array('db' => $this->table.'.user_direct', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return  $this->UserInfoBill($d);
                }
            ),

            array('db' => $this->table.'.number_bill', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    return "<button  class='btn btn-secondary' onclick='get_details($row[10],$d)'  >{$d}</button>";
                }
            ),


            array('db' => $this->table.'.id', 'dt' => 7,
                'formatter' => function ($d, $row) {
                    if ($this->permit('enter_bills', 'bills_inside_system')) {

                        return "
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-auto' style='padding-left: 2px'>		
				  	       <input id='numberBill_{$row[14]}'  value='' type='text' class='form-control withBill' name='crystal_bill' required>
                   </div>
				  <div class='col-auto' style='padding-right: 2px'>
				   <button type='submit' id='btn_in_bill_{$row[14]}' onclick=saveBill('".$row[14]."')  name='submit' class='btn btn-warning'>حفظ</button>
                  </div>
                  </div>
                    " ;
                    }else
                    {
                        return 'لا توجد صلاحية';
                    }

                }
            ),

            array('db' =>$this->table.'.why_rejected', 'dt' => 8),//8
            array('db' =>$this->table.'.id', 'dt' => 9),//8
            array('db' =>$this->table.'.id_member_r', 'dt' =>10),//9
            array('db' =>$this->table.'.id_accountant_user', 'dt' =>11),//10
            array('db' =>$this->table.'.user_direct', 'dt' =>12),//11
            array('db' =>$this->table.'.cancel', 'dt' =>13),//12
            array('db' =>$this->table.'.number_bill', 'dt' =>14),//13
            array('db' =>$this->table.'.edit_price', 'dt' =>15),//14



        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "inner JOIN register_user ON register_user.id = cart_shop_active.id_member_r ";
        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array( "cart_shop_active.crystal_bill  = ' ' "," cart_shop_active.cancel = 1   ");

        }else{
            $whereAll = array( "cart_shop_active.crystal_bill  = ' ' "," cart_shop_active.cancel = 1 ", "cart_shop_active.date_req BETWEEN {$from_date_stm} AND {$to_date_stm}");

        }
        $group="GROUP BY  cart_shop_active.number_bill, cart_shop_active.id_member_r";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

    }



    public function bills_crystal_enter_cancel()
    {
        $this->checkPermit('bills_crystal_enter_cancel', 'bills_inside_system');
        $this->AdminHeaderController($this->langControl('bills_crystal_enter_cancel'));





        $date=null;
        $todate=null;

        $from_date_stm=null;
        $to_date_stm=null;

        if (isset($_GET['date'])&&isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);

        }


        require($this->render($this->folder, 'cancel', 'bills_crystal_enter_cancel', 'php'));
        $this->AdminFooterController();
    }



    public function processing_bills_crystal_enter_cancel($from_date_stm=null,$to_date_stm=null)
    {

        $table = $this->table;
        $primaryKey = $this->table.'.id';

        $columns = array(
            array('db' =>'register_user.name', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),
            array('db' =>'register_user.phone', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),


            array('db' => $this->table.'.date_req', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i a',$d);
                }
            ),
            array('db' => $this->table.'.number_bill', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    if ($row[15]==1)
                    {
                        if ($row[13] == 1)
                        {
                            return   $this->sunAmountBillByNumberBill($row[10],$d)  ;

                        }else{
                            return "<span   data-toggle='tooltip' data-placement='top' title='تم تغير  سعر الفاتورة '   style='color: red'> {$this->sunAmountBillByNumberBill($row[9],$d)} </span>";

                        }
                    }else
                    {
                        if ($row[13] == 1)
                        {
                            return $this->sunAmountBillByNumberBill($row[10],$d)  ;

                        }else{
                            return $this->sunAmountBillByNumberBill($row[10],$d);

                        }
                    }


                }
            ),

            array('db' => $this->table.'.id_accountant_user', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return  $this->UserInfo($d);
                }
            ),
            array('db' => $this->table.'.user_direct', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return  $this->UserInfoBill($d);
                }
            ),

            array('db' => $this->table.'.number_bill', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    return "<button  class='btn btn-secondary' onclick='get_details($row[10],$d)'  >{$d}</button>";
                }
            ),


            array('db' => $this->table.'.crystal_bill', 'dt' => 7,
                'formatter' => function ($d, $row) {
                    if ($this->permit('enter_bills', 'bills_inside_system')) {

                        return "
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-auto' style='padding-left: 2px'>		
				  	       <input id='numberBill_{$row[14]}'  value='{$d}' type='text' class='form-control withBill' name='crystal_bill' required>
                   </div>
				  <div class='col-auto' style='padding-right: 2px'>
				   <button type='submit' id='btn_in_bill_{$row[14]}' onclick=saveBill('".$row[14]."')  name='submit' class='btn btn-success'>حفظ</button>
                  </div>
                  </div>
                    " ;
                    }else
                    {
                        return 'لا توجد صلاحية';
                    }

                }
            ),

            array('db' =>$this->table.'.why_rejected', 'dt' => 8),//8
            array('db' =>$this->table.'.id', 'dt' => 9),//8
            array('db' =>$this->table.'.id_member_r', 'dt' =>10),//9
            array('db' =>$this->table.'.id_accountant_user', 'dt' =>11),//10
            array('db' =>$this->table.'.user_direct', 'dt' =>12),//11
            array('db' =>$this->table.'.cancel', 'dt' =>13),//12
            array('db' =>$this->table.'.number_bill', 'dt' =>14),//13
            array('db' =>$this->table.'.edit_price', 'dt' =>15),//14



        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "inner JOIN register_user ON register_user.id = cart_shop_active.id_member_r ";
        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array( "cart_shop_active.crystal_bill   <>  '' "," cart_shop_active.cancel = 1   ");

        }else{
            $whereAll = array( "cart_shop_active.crystal_bill   <>  '' "," cart_shop_active.cancel = 1 ", "cart_shop_active.date_req BETWEEN {$from_date_stm} AND {$to_date_stm}");

        }
        $group="GROUP BY  cart_shop_active.number_bill, cart_shop_active.id_member_r";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

    }








}










