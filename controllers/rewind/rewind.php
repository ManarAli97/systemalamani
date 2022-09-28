<?php

require_once  "search_rewind/search_rewind.php";
class rewind extends Controller
{

use  search_rewind;
	function __construct()
	{
		parent::__construct();
        $this->group_bill='rewind_group_bill';


		$this->setting = new Setting();
	}


    public function createTB()
    {

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



        return $this->db->cht(array($this->group_bill));

    }


    function required($flag)
    {
        if ($flag==0)
        {
            $this->setting->set('required_serial_rewind',0) ;
        }else
        {
            $this->setting->set('required_serial_rewind',1) ;
        }

    }


    function index()
	{



		require($this->render($this->folder, 'account', 'index', 'php'));

	}

	function details($number_bill)
	{

		$this->checkPermit('details', $this->folder);
		$this->adminHeaderController($this->langControl('details'));


		$sum =$this->sumbill($number_bill);


		$stmt_customer=$this->db->prepare("SELECT register_user.*,review.number_bill_new,review.crystal_bill,review.date,review.id_accountant,review.id_prepared FROM review INNER JOIN register_user ON register_user.id = review.id_customre    WHERE   review.number_bill_new=? AND review.cancel=0");
		$stmt_customer->execute(array($number_bill));
		$result=$stmt_customer->fetch(PDO::FETCH_ASSOC);



		$stmt=$this->db->prepare("SELECT review_item.*,cart_shop_active.price_dollars,cart_shop_active.image FROM review_item     INNER JOIN cart_shop_active ON cart_shop_active.id=review_item.id_cart WHERE   number_bill_new=?  AND review_item.cancel=0 ");
		$stmt->execute(array($number_bill));
		$bill=array();

		while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
		{

			$row['price_sale']=$this->price_dollarsAdmin($row['price_dollars']);
			$row['image']=$this->save_file.$row['image'];
			$bill[]=$row;
		}




		require($this->render($this->folder, 'enter', 'details', 'php'));
		$this->adminFooterController();

	}


	public function bills_enter()
	{
		$this->checkPermit('bills_enter', $this->folder);
		$this->adminHeaderController($this->langControl('bills_enter'));





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


		require($this->render($this->folder, 'enter', 'bills_enter', 'php'));
		$this->adminFooterController();
	}


	public function processing_bills_enter($from_date_stm=null,$to_date_stm=null)
	{

		$table = 'review';
		$primaryKey = 'review.id';

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
			array('db' =>'review.number_bill_new', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return "<a href='".url.'/'.$this->folder."/details/{$d}'>{$d}</a>";
				}
			),

			array('db' =>'review.number_bill_new', 'dt' => 3,
				'formatter' => function ($d, $row) {
					return number_format($this->sumBill($d));
				}
			),

			array('db' =>'review.crystal_bill', 'dt' => 4,
				'formatter' => function ($d, $row) {
					return  $d;
				}
			),

			array('db' =>'review.crystal_bill', 'dt' => 5,
				'formatter' => function ($d, $row) {

					if ($this->permit('edit_bill', $this->folder)) {

						if (!empty($row[12]) && $row[13] == 0 && $row[14] == 1) {
							return "
					 <div class='row justify-content-center align-items-center'>
					  <div class='col-auto' style='padding-left: 2px'>		
							   <input id='numberBill_{$row[3]}'  value='{$d}' type='text' class='form-control withBill' name='crystal_bill' required>
					   </div>
					  <div class='col-auto' style='padding-right: 2px'>
					   <button type='submit' id='btn_in_bill_{$row[3]}' onclick=saveBill('" . $row[3] . "')  name='submit' class='btn btn-success'>حفظ</button>
					  </div>
					  </div>
					";
						} else {
							return "
					 <div class='row justify-content-center align-items-center'>
					  <div class='col-auto' style='padding-left: 2px'>		
							   <input id='numberBill_{$row[3]}'  value='{$d}' type='text' class='form-control withBill' name='crystal_bill' required>
					   </div>
					  <div class='col-auto' style='padding-right: 2px'>
					   <button type='submit' id='btn_in_bill_{$row[3]}' onclick=saveBill('" . $row[3] . "')  name='submit' class='btn btn-warning'>حفظ</button>
					  </div>
					  </div>
					";
						}

					}else
					{
						return 'لا تمتلك صلاحية';
					}


				}
			),


			array('db' =>'review.id_accountant', 'dt' =>6,
				'formatter' => function ($d, $row) {
					return $this->UserInfo($d);
				}
			),
			array('db' =>'review.id_prepared', 'dt' =>7,
				'formatter' => function ($d, $row) {
					return $this->UserInfo($d);
				}
			),

			array('db' =>'review.date', 'dt' =>8,

				'formatter' => function ($d, $row) {
					return  date('Y-m-d h:i A',$d);
				}

			),

			array('db' =>'review.user_enter', 'dt' =>9,
				'formatter' => function ($d, $row) {
				return $this->UserInfo($d);
				}

				),
			array('db' =>'review.date_enter', 'dt' =>10,

				'formatter' => function ($d, $row) {
					return  date('Y-m-d h:i A',$d);
				}

				),

            array('db' =>'review.note_review', 'dt' =>11),


			array('db' =>'review.crystal_bill', 'dt' =>12),
			array('db' =>'review.edit', 'dt' =>13),
			array('db' =>'review.checked', 'dt' =>14),



		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);



		$join = "inner JOIN register_user ON register_user.id = review.id_customre     ";
		if (empty($from_date_stm) && empty($to_date_stm))
		{
			$whereAll = array("review.active = 1","review.cancel = 0","review.crystal_bill <> ''");

		}else{
			$whereAll = array("review.active = 1","review.cancel = 0","review.date_enter BETWEEN {$from_date_stm} AND {$to_date_stm}");

		}


		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));

	}




	public function bills_note_enter()
	{
		$this->checkPermit('bills_note_enter', $this->folder);
		$this->adminHeaderController($this->langControl('bills_note_enter'));





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

        $stmt = $this->db->prepare("SELECT  review.number_bill_new FROM `review`     WHERE   review.number_bill_new not in(SELECT number_bill FROM {$this->group_bill})  AND review.crystal_bill = '' AND review.active = 1 AND review.cancel=0") ;
        $stmt->execute();
        $bill=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $bill[]=$row['number_bill_new'];

        }

		require($this->render($this->folder, 'enter', 'bills_note_enter', 'php'));
		$this->adminFooterController();
	}


	public function processing_bills_note_enter($from_date_stm=null,$to_date_stm=null)
	{

		$table = 'review';
		$primaryKey = 'review.id';

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
			array('db' =>'review.number_bill_new', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return "<a href='".url.'/'.$this->folder."/details/{$d}'>{$d}</a>";
				}
			),

			array('db' =>'review.number_bill_new', 'dt' => 3,
				'formatter' => function ($d, $row) {
					return number_format($this->sumBill($d));
				}
			),

			array('db' =>'review.crystal_bill', 'dt' => 4,
				'formatter' => function ($d, $row) {
					return  $d;
				}
			),

			array('db' =>'review.crystal_bill', 'dt' => 5,
				'formatter' => function ($d, $row) {
					if ($this->permit('enter_bill', $this->folder)) {
						return "
					 <div class='row justify-content-center align-items-center'>
					  <div class='col-auto' style='padding-left: 2px'>		
							   <input id='numberBill_{$row[3]}'  value='{$d}' type='text' class='form-control withBill' name='crystal_bill' required>
					   </div>
					  <div class='col-auto' style='padding-right: 2px'>
					   <button type='submit' id='btn_in_bill_{$row[3]}' onclick=saveBill('" . $row[3] . "')  name='submit' class='btn btn-warning'>حفظ</button>
					  </div>
					  </div>
					";
					}else{
						return 'لا تمتلك صلاحية';
					}

				}
			),


			array('db' =>'review.id_accountant', 'dt' =>6,
				'formatter' => function ($d, $row) {
					return $this->UserInfo($d);
				}
			),
			array('db' =>'review.date', 'dt' =>7,

				'formatter' => function ($d, $row) {
					return  date('Y-m-d h:i A',$d);
				}

			),


			array('db' =>'review.id_prepared', 'dt' =>8,
				'formatter' => function ($d, $row) {
					return $this->UserInfo($d);
				}
			),

			array('db' =>'review.note_review', 'dt' =>9	),


            array('db' =>'review.number_bill_new', 'dt' => 10 ),



		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);



		$join = "inner JOIN register_user ON register_user.id = review.id_customre     ";
		if (empty($from_date_stm) && empty($to_date_stm))
		{
			$whereAll = array("review.active = 1","review.cancel = 0","review.crystal_bill = ''");

		}else{

			$whereAll = array("review.active = 1","review.cancel = 0","review.crystal_bill = ''","review.date_enter BETWEEN {$from_date_stm} AND {$to_date_stm}");



		}


		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));

	}





	public function bills_note_checked()
	{
		$this->checkPermit('bills_note_checked', $this->folder);
		$this->adminHeaderController($this->langControl('bills_note_checked'));





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


		require($this->render($this->folder, 'enter', 'note_checked', 'php'));
		$this->adminFooterController();
	}


	public function processing_bills_note_checked($from_date_stm=null,$to_date_stm=null)
	{

		$table = 'review';
		$primaryKey = 'review.id';

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
			array('db' =>'review.number_bill_new', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return "<a href='".url.'/'.$this->folder."/details/{$d}'>{$d}</a>";
				}
			),

			array('db' =>'review.number_bill_new', 'dt' => 3,
				'formatter' => function ($d, $row) {
					return number_format($this->sumBill($d));
				}
			),

			array('db' =>'review.crystal_bill', 'dt' => 4,
				'formatter' => function ($d, $row) {
					return  $d;
				}
			),

			array('db' =>'review.crystal_bill', 'dt' => 5,
				'formatter' => function ($d, $row) {
					return  "
					 <div class='row justify-content-center align-items-center'>
					  <div class='col-auto' style='padding-right: 2px'>
					   <button type='submit' id='btn_in_bill_{$row[3]}' onclick=checked_bill('".$row[3]."')  name='submit' class='btn btn-primary'>موافق</button>
					  </div>
					  </div>
					";

				}
			),


			array('db' =>'review.id_accountant', 'dt' =>6,
				'formatter' => function ($d, $row) {
					return $this->UserInfo($d);
				}
			),

			array('db' =>'review.date', 'dt' =>7,

				'formatter' => function ($d, $row) {
					return  date('Y-m-d h:i A',$d);
				}

			),

			array('db' =>'review.user_enter', 'dt' =>8,
				'formatter' => function ($d, $row) {
					return $this->UserInfo($d);
				}

			),
			array('db' =>'review.date_enter', 'dt' =>9,

				'formatter' => function ($d, $row) {
					return  date('Y-m-d h:i A',$d);
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



		$join = "inner JOIN register_user ON register_user.id = review.id_customre   ";
		if (empty($from_date_stm) && empty($to_date_stm))
		{
			$whereAll = array("review.active = 1","review.cancel = 0","review.crystal_bill <> ''","review.checked = 0");

		}else{
			$whereAll = array("review.active = 1","review.cancel = 0","review.crystal_bill <> ''","review.checked = 0","review.date_checked BETWEEN {$from_date_stm} AND {$to_date_stm}");

		}


		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));

	}





	public function bills_checked()
	{
		$this->checkPermit('bills_enter', $this->folder);
		$this->adminHeaderController($this->langControl('bills_enter'));





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


		require($this->render($this->folder, 'enter', 'bills_checked', 'php'));
		$this->adminFooterController();
	}


	public function processing_bills_checked($from_date_stm=null,$to_date_stm=null)
	{

		$table = 'review';
		$primaryKey = 'review.id';

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
			array('db' =>'review.number_bill_new', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return "<a href='".url.'/'.$this->folder."/details/{$d}'>{$d}</a>";
				}
			),

			array('db' =>'review.number_bill_new', 'dt' => 3,
				'formatter' => function ($d, $row) {
					return number_format($this->sumBill($d));
				}
			),

			array('db' =>'review.crystal_bill', 'dt' => 4,
				'formatter' => function ($d, $row) {
					return  $d;
				}
			),

			array('db' =>'review.crystal_bill', 'dt' => 5,
				'formatter' => function ($d, $row) {

						return '<i style="color: green" class="fa fa-check-circle"></i>';
					}

			),


			array('db' =>'review.id_accountant', 'dt' =>6,
				'formatter' => function ($d, $row) {
					return $this->UserInfo($d);
				}
			),

			array('db' =>'review.date', 'dt' =>7,

				'formatter' => function ($d, $row) {
					return  date('Y-m-d h:i A',$d);
				}

			),

			array('db' =>'review.user_checked', 'dt' =>8,
				'formatter' => function ($d, $row) {
					return $this->UserInfo($d);
				}

			),
			array('db' =>'review.date_checked', 'dt' =>9,

				'formatter' => function ($d, $row) {
					return  date('Y-m-d h:i A',$d);
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



		$join = "inner JOIN register_user ON register_user.id = review.id_customre   ";
		if (empty($from_date_stm) && empty($to_date_stm))
		{
			$whereAll = array("review.active = 1","review.cancel = 0","review.crystal_bill <> ''","review.checked = 1");

		}else{
			$whereAll = array("review.active = 1","review.cancel = 0","review.crystal_bill <> ''","review.checked = 1","review.date_enter BETWEEN {$from_date_stm} AND {$to_date_stm}");

		}


		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));

	}





	public function bills_edit()
	{
		$this->checkPermit('bills_edit', $this->folder);
		$this->adminHeaderController($this->langControl('bills_edit'));


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

		require($this->render($this->folder, 'enter', 'bills_edit', 'php'));
		$this->adminFooterController();
	}


	public function processing_bills_edit($from_date_stm=null,$to_date_stm=null)
	{

		$table = 'review';
		$primaryKey = 'review.id';

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
			array('db' =>'review.number_bill_new', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return "<a href='".url.'/'.$this->folder."/details/{$d}'>{$d}</a>";
				}
			),

			array('db' =>'review.number_bill_new', 'dt' => 3,
				'formatter' => function ($d, $row) {
					return number_format($this->sumBill($d));
				}
			),

			array('db' =>'review.crystal_bill', 'dt' => 4,
				'formatter' => function ($d, $row) {
					return  $d;
				}
			),



			array('db' =>'review.id_accountant', 'dt' =>5,
				'formatter' => function ($d, $row) {
					return $this->UserInfo($d);
				}
			),

			array('db' =>'review.date', 'dt' =>6,

				'formatter' => function ($d, $row) {
					return  date('Y-m-d h:i A',$d);
				}

			),

			array('db' =>'review.user_edit', 'dt' =>7,
				'formatter' => function ($d, $row) {
					return $this->UserInfo($d);
				}

			),
			array('db' =>'review.date_edit', 'dt' =>8,

				'formatter' => function ($d, $row) {
					return  date('Y-m-d h:i A',$d);
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



		$join = "inner JOIN register_user ON register_user.id = review.id_customre   ";
		if (empty($from_date_stm) && empty($to_date_stm))
		{
			$whereAll = array("review.active = 1","review.cancel = 0","review.edit =1 ");

		}else{
			$whereAll = array("review.active = 1","review.cancel = 0","review.edit =1 ","review.date_edit BETWEEN {$from_date_stm} AND {$to_date_stm}");
		}


		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));

	}






	function sumBill($bill){

		$stmt=$this->db->prepare("SELECT price_new FROM review_item WHERE number_bill_new=?");
		$stmt->execute(array($bill));
		$sum=0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

			$sum=(int)$sum+(int)$row['price_new'];
		}
		return $sum;

	}

	function crystal_bill()
	{
		if ($this->handleLogin())
		{

			$number_bill=trim(str_replace(' ','',$_GET['number_bill']));
			$crystal_bill=trim(str_replace(' ','',$_GET['crystal_bill']));


			$stmt=$this->db->prepare("SELECT *FROM `review` WHERE  `number_bill_new` =? AND crystal_bill = ''");
			$stmt->execute(array($number_bill));
			if ($stmt->rowCount() > 0)
			{
				$stmt_up=$this->db->prepare("UPDATE  `review` SET  crystal_bill=? , user_enter=?, date_enter=?  WHERE  `number_bill_new` =?  ");
				$stmt_up->execute(array($crystal_bill,$this->userid,time(),$number_bill));
				if ($stmt_up->rowCount() > 0)
				{
					echo '1';

				}

			}else{
				$stmt_up=$this->db->prepare("UPDATE  `review` SET  crystal_bill=? , user_edit=?, date_edit=?,`edit`=1,`checked`=0  WHERE  `number_bill_new` =?  ");
				$stmt_up->execute(array($crystal_bill,$this->userid,time(),$number_bill));
				if ($stmt_up->rowCount() > 0)
				{
					echo '1';

				}

			}


		}
	}




	function checked_bill()
	{

		if ($this->handleLogin())
		{
			$number_bill=$_GET['number_bill'];
			$stmt_up=$this->db->prepare("UPDATE  `review` SET  checked=1 , user_checked=?, date_checked=?,edit=0   WHERE  `number_bill_new` =?  ");
			$stmt_up->execute(array($this->userid,time(),$number_bill));
			if ($stmt_up->rowCount() > 0)
			{
				echo '1';
			}
		}

	}


    function all_rewind_note_enter_bill()
    {

        $stmt = $this->db->prepare("SELECT  count(*)  FROM `review`  WHERE  review.active = 1  AND review.crystal_bill = ''  ");
        $stmt->execute();
        return $stmt->fetchColumn() ;

    }


    function add_group()
    {

        $this->checkPermit('add_group', $this->folder);
        $stmt = $this->db->prepare("SELECT  review.number_bill_new FROM `review`     WHERE   review.number_bill_new not in(SELECT number_bill FROM {$this->group_bill})  AND review.crystal_bill = '' AND review.active = 1  AND review.cancel = 0  ") ;
        $stmt->execute();
        $bill=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $bill[]=$row['number_bill_new'];

        }



        if (!empty($bill)) {

            $number = 1;
            $stmt_sq = $this->db->prepare("SELECT `number` FROM {$this->group_bill} ORDER BY `number` DESC  LIMIT 1");
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
            }

            $values=rtrim($values, ',');
            $stmt_add=$this->db->prepare("INSERT INTO {$this->group_bill} (`name`, `number_bill`, `number`, `userid`, `date`) values {$values}");
            $stmt_add->execute();
            if ($stmt_add->rowCount() > 0)
            {
                echo $number;
            }
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


        $table = 'review_item';
        $primaryKey ='review_item.id';

        $columns = array(

            array('db' => $table.'.code', 'dt' => 0   ),
            array('db' => $table.'.code', 'dt' =>1 ,
                'formatter' => function ($d, $row) {
                    return $this->quantity_review_item($d,$row[4],$row[9],$row[8]);
                }),

            array('db' => $table.'.code', 'dt' =>2 ,
                'formatter' => function ($d, $row) {
                    return $this->storehouse($row[10],$d,$row[9]);
                }),

            array('db' => $table.'.price_new', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return number_format($d);
                }
            ),

            array('db' => $table.'.number_bill_new', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/details/{$d}'>{$d}</a>";
                }
            ),


            array('db' => $table.'.number_bill_new', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return "<div class='text-right'>{$this->customerInfo($row[8])} ,{$this->UserInfo($row[6])} ,{$this->UserInfo($row[7])} ,{$d}   </div> ";
                }

            ),
            array('db' =>$table.'.id_prepared', 'dt' =>6 ),
            array('db' =>$table.'.id_accountant', 'dt' =>7 ),
            array('db' =>$table.'.id_customre', 'dt' =>8 ),
            array('db' =>$table.'.table', 'dt' =>9 ),
            array('db' =>$table.'.location', 'dt' =>10 ),



        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = " inner JOIN {$this->group_bill} ON {$this->group_bill}.number_bill = review_item.number_bill_new  ";
        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array("{$this->group_bill}.number  = {$number}");

        }else{
            $whereAll = array("{$this->group_bill}.number  = {$number}","review_item.date BETWEEN {$from_date_stm} AND {$to_date_stm}");
        }

        $group="GROUP BY  review_item.code,review_item.table,review_item.number_bill_new,review_item.id_customre";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));
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
            $stmt = $this->db->prepare("SELECT  sequence FROM location  WHERE  location=? AND code=? AND  `model`=? LIMIT  1");
            $stmt->execute(array($l,$code,$table));
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $sequence[] = $row['sequence'];
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



    function quantity_review_item($code,$number_bill,$table,$id_customre)
    {

        $stmt=$this->db->prepare("SELECT count(code)  as c FROM review_item WHERE code=? AND number_bill_new=? AND `table`=? AND id_customre=? ");

        $stmt->execute(array($code,$number_bill,$table,$id_customre));

        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return $result['c'];

    }



    function group_not_enter()
    {

        $this->checkPermit('group_not_enter', 'bills_inside_system');
        $this->AdminHeaderController($this->langControl('group_not_enter'));


        $stmt = $this->db->prepare("SELECT  review.number_bill_new FROM `review`     WHERE   review.number_bill_new not in(SELECT number_bill FROM {$this->group_bill})  AND review.crystal_bill = '' AND review.active = 1   AND review.cancel =0  ") ;
        $stmt->execute();
        $bill=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $bill[]=$row['number_bill_new'];

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

            array('db' =>$table.'.number', 'dt' => 6),//7




        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = " left JOIN review ON review.crystal_bill = {$this->group_bill}.crystal_bill ";
        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array("{$this->group_bill}.crystal_bill  = '' ");

        }else{
            $whereAll = array("{$this->group_bill}.crystal_bill  = '' ","{$this->group_bill}.date BETWEEN {$from_date_stm} AND {$to_date_stm}" );

        }
        $group="GROUP BY  {$this->group_bill}.number";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

    }






    function crystal_bill_group()
    {
        if ($this->handleLogin()) {


            $number = trim(str_replace(' ', '', $_GET['number_group']));
            $crystal_bill = trim(str_replace(' ', '', $_GET['crystal_bill']));


            $stmt = $this->db->prepare("SELECT   number_bill FROM {$this->group_bill}    WHERE  number=? ");
            $stmt->execute(array($number));
            $bill = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $bill[] = $row['number_bill'];
            }


            $stmt_ch = $this->db->prepare("SELECT   number_bill FROM {$this->group_bill}    WHERE  number=? ");
            $stmt_ch->execute(array($number));
            if ($stmt_ch->rowCount() > 0) {


                $stmt_up = $this->db->prepare("UPDATE  `{$this->group_bill}` SET  crystal_bill=? , user_input_bill=?  WHERE  number =?   ");
                $stmt_up->execute(array($crystal_bill, $this->userid, $number));
                if ($stmt_up->rowCount() > 0) {

                    $bill_group=implode(',',$bill);
                    $stmt_p = $this->db->prepare("UPDATE  `review` SET  crystal_bill=? , user_enter=?,`date_enter`=?  WHERE  number_bill_new IN($bill_group)  ");
                    $stmt_p->execute(array($crystal_bill, $this->userid,time()));
                    if ($stmt_p->rowCount() > 0) {
                        echo '1';
                    }

                }
            }
        }

    }



    function group_enter()
    {

        $this->checkPermit('group_not_enter', 'bills_inside_system');
        $this->AdminHeaderController($this->langControl('group_not_enter'));


        $stmt = $this->db->prepare("SELECT  purchase_customer_bill.number_bill FROM `purchase_customer_bill`    WHERE purchase_customer_bill.number_bill not in(SELECT number_bill FROM {$this->group_bill})  AND   purchase_customer_bill.crystal_bill = '' AND purchase_customer_bill.active = 1  ") ;
        $stmt->execute();
        $bill=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $bill[]=$row['number_bill'];

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


        require($this->render($this->folder, 'group', 'group_enter', 'php'));
        $this->AdminFooterController();

    }



    public function processing_group_enter($from_date_stm=null,$to_date_stm=null)
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


            array('db' => $table.'.user_input_bill', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return  $this->UserInfo($d);
                }
            ),



            array('db' => $table.'.date', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i a',$d);
                }
            ),

            array('db' => $table.'.crystal_bill', 'dt' => 5  ),

            array('db' => $table.'.number', 'dt' => 6,
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

            array('db' => $table.'.number', 'dt' => 7,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/export_group_enter/{$d}'><span>تصدير مواد الفواتير</span></a>";
                }
            ),

            array('db' =>$table.'.number', 'dt' => 8),//7




        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = " left JOIN purchase_customer_bill ON purchase_customer_bill.crystal_bill = {$this->group_bill}.crystal_bill ";
        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array("{$this->group_bill}.crystal_bill  <>  '' ");

        }else{
            $whereAll = array("purchase_customer_bill.number_bill is null","{$this->group_bill}.crystal_bill  = '' ","{$this->group_bill}.date BETWEEN {$from_date_stm} AND {$to_date_stm}" );

        }
        $group="GROUP BY  {$this->group_bill}.number";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

    }




    public function export_group_enter($number)
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


        require($this->render($this->folder, 'group', 'bills_materials_enter', 'php'));
        $this->adminFooterController();
    }



    public function processing_bill_materials_crystal_enter($number,$from_date_stm=null,$to_date_stm=null)
    {


        $table = 'review_item';
        $primaryKey ='review_item.id';

        $columns = array(

            array('db' => $table.'.code', 'dt' => 0   ),
            array('db' => $table.'.code', 'dt' =>1 ,
                'formatter' => function ($d, $row) {
                    return $this->quantity_review_item($d,$row[4],$row[10],$row[9]);
                }),

            array('db' => $table.'.code', 'dt' =>2 ,
                'formatter' => function ($d, $row) {
                    return $this->storehouse($row[11],$d,$row[10]);
                }),

            array('db' => $table.'.price_new', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return number_format($d);
                }
            ),

            array('db' => $table.'.number_bill_new', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/details/{$d}'>{$d}</a>";
                }
            ),

            array('db' => $this->group_bill.'.crystal_bill', 'dt' => 5   ),

            array('db' => $table.'.number_bill_new', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    return "<div class='text-right'>{$this->customerInfo($row[9])} ,{$this->UserInfo($row[7])} ,{$this->UserInfo($row[8])} ,{$d} </div>";
                }

            ),
            array('db' =>$table.'.id_prepared', 'dt' =>7 ),
            array('db' =>$table.'.id_accountant', 'dt' =>8 ),
            array('db' =>$table.'.id_customre', 'dt' =>9 ),
            array('db' =>$table.'.table', 'dt' =>10 ),
            array('db' =>$table.'.location', 'dt' =>11 ),



        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = " inner JOIN {$this->group_bill} ON {$this->group_bill}.number_bill = review_item.number_bill_new  ";
        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array("{$this->group_bill}.number  = {$number}");

        }else{
            $whereAll = array("{$this->group_bill}.number  = {$number}","review_item.date BETWEEN {$from_date_stm} AND {$to_date_stm}");
        }

        $group="GROUP BY  review_item.code,review_item.table,review_item.number_bill_new,review_item.id_customre";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));
    }



    public function bills_note_enter_cancel()
    {
        $this->checkPermit('bills_note_enter_cancel', $this->folder);
        $this->adminHeaderController($this->langControl('bills_note_enter_cancel'));





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


        require($this->render($this->folder, 'enter', 'bills_note_enter_cancel', 'php'));
        $this->adminFooterController();
    }


    public function processing_bills_note_enter_cancel($from_date_stm=null,$to_date_stm=null)
    {

        $table = 'review';
        $primaryKey = 'review.id';

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
            array('db' =>'review.number_bill_new', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/details2/{$d}'>{$d}</a>";
                }
            ),

            array('db' =>'review.number_bill_new', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return number_format($this->sumBill($d));
                }
            ),

            array('db' =>'review.crystal_bill', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return  $d;
                }
            ),

            array('db' =>'review.crystal_bill', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    if ($this->permit('enter_bill', $this->folder)) {
                        return "
					 <div class='row justify-content-center align-items-center'>
					  <div class='col-auto' style='padding-left: 2px'>		
							   <input id='numberBill_{$row[3]}'  value='{$d}' type='text' class='form-control withBill' name='crystal_bill' required>
					   </div>
					  <div class='col-auto' style='padding-right: 2px'>
					   <button type='submit' id='btn_in_bill_{$row[3]}' onclick=saveBill('" . $row[3] . "')  name='submit' class='btn btn-warning'>حفظ</button>
					  </div>
					  </div>
					";
                    }else{
                        return 'لا تمتلك صلاحية';
                    }

                }
            ),


            array('db' =>'review.id_account_cancel', 'dt' =>6,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }
            ),
            array('db' =>'review.date_account_cancel', 'dt' =>7,

                'formatter' => function ($d, $row) {
                    return  date('Y-m-d h:i A',$d);
                }

            ),


            array('db' =>'review.id_prepared_cancel', 'dt' =>8,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }
            ),


            array('db' =>'review.number_bill_new', 'dt' => 9   ),



        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );



        $join = "inner JOIN register_user ON register_user.id = review.id_customre     ";
        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array("review.active = 0","review.cancel = 2","review.crystal_bill = ''");

        }else{

            $whereAll = array("review.active = 0","review.cancel =2","review.crystal_bill = ''","review.date_account_cancel BETWEEN {$from_date_stm} AND {$to_date_stm}");



        }


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));

    }

    public function bills_enter_cancel()
    {
        $this->checkPermit('bills_enter_cancel', $this->folder);
        $this->adminHeaderController($this->langControl('bills_enter_cancel'));





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


        require($this->render($this->folder, 'enter', 'bills_enter_cancel', 'php'));
        $this->adminFooterController();
    }


    public function processing_bills_enter_cancel($from_date_stm=null,$to_date_stm=null)
    {

        $table = 'review';
        $primaryKey = 'review.id';

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
            array('db' =>'review.number_bill_new', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/details2/{$d}'>{$d}</a>";
                }
            ),

            array('db' =>'review.number_bill_new', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return number_format($this->sumBill($d));
                }
            ),

            array('db' =>'review.crystal_bill', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return  $d;
                }
            ),

            array('db' =>'review.crystal_bill', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    if ($this->permit('enter_bill', $this->folder)) {
                        return "
					 <div class='row justify-content-center align-items-center'>
					  <div class='col-auto' style='padding-left: 2px'>		
							   <input id='numberBill_{$row[3]}'  value='{$d}' type='text' class='form-control withBill' name='crystal_bill' required>
					   </div>
					  <div class='col-auto' style='padding-right: 2px'>
					   <button type='submit' id='btn_in_bill_{$row[3]}' onclick=saveBill('" . $row[3] . "')  name='submit' class='btn btn-warning'>حفظ</button>
					  </div>
					  </div>
					";
                    }else{
                        return 'لا تمتلك صلاحية';
                    }

                }
            ),


            array('db' =>'review.id_account_cancel', 'dt' =>6,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }
            ),
            array('db' =>'review.date_account_cancel', 'dt' =>7,

                'formatter' => function ($d, $row) {
                    return  date('Y-m-d h:i A',$d);
                }

            ),


            array('db' =>'review.id_prepared_cancel', 'dt' =>8,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }
            ),


            array('db' =>'review.number_bill_new', 'dt' => 9   ),



        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );



        $join = "inner JOIN register_user ON register_user.id = review.id_customre     ";
        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array("review.active = 0","review.cancel = 2","review.crystal_bill <>  ''");

        }else{

            $whereAll = array("review.active = 0","review.cancel =2","review.crystal_bill <> ''","review.date_account_cancel BETWEEN {$from_date_stm} AND {$to_date_stm}");



        }


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));

    }


    function details2($number_bill)
    {

        $this->checkPermit('details_cancel', $this->folder);
        $this->adminHeaderController($this->langControl('details'));


        $sum =$this->sumbill($number_bill);


        $stmt_customer=$this->db->prepare("SELECT register_user.*,review.date_account_cancel,review.number_bill_new,review.crystal_bill,review.date,review.id_accountant,review.id_prepared ,review.id_account_cancel,review.id_prepared_cancel FROM review INNER JOIN register_user ON register_user.id = review.id_customre    WHERE   review.number_bill_new=? AND review.cancel=2");
        $stmt_customer->execute(array($number_bill));
        $result=$stmt_customer->fetch(PDO::FETCH_ASSOC);



        $stmt=$this->db->prepare("SELECT review_item.*,cart_shop_active.price_dollars,cart_shop_active.image FROM review_item     INNER JOIN cart_shop_active ON cart_shop_active.id=review_item.id_cart WHERE   number_bill_new=?  AND review_item.cancel=2");
        $stmt->execute(array($number_bill));
        $bill=array();

        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $row['price_sale']=$this->price_dollarsAdmin($row['price_dollars']);
            $row['image']=$this->save_file.$row['image'];
            $bill[]=$row;
        }




        require($this->render($this->folder, 'enter', 'details2', 'php'));
        $this->adminFooterController();

    }






}

?>