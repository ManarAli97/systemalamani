<?php


class bill_main_accountant extends Controller
{


    function __construct()
    {
        parent::__construct();
		$this->table='cart_shop_active';
        $this->setting = new Setting();
    }




    public function index()
    {
        $this->checkPermit('bill_main_accountant', $this->folder);
        $this->adminHeaderController($this->langControl('bill_main_accountant'));


        $date=null;
        $todate=null;

        if (isset($_GET['date'])&&isset($_GET['todate']))
        {
            $date=$_GET['date'];
            $todate=$_GET['todate'];
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
          /*  if($this->admin($this->userid))
			{
				$stmt =$this->db->prepare("SELECT *FROM  `user` WHERE  `idGroup`  = ? ");
				$stmt->execute(array($result_g['id']));
			}else
			{
				$stmt =$this->db->prepare("SELECT *FROM  `user` WHERE  `idGroup`  = ?  AND id =?");
				$stmt->execute(array($result_g['id'],$this->userid));
			}*/

        $user=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $row['money']= $this->account_billAll($row['id'],$date,$todate);
            $row['number_bill']= $this->number_billAll($row['id'],$date,$todate);

            $user[]=  $row ;
        }

        } else

        {
            die('لا يوجد مجموعة محاسبين');
        }


        require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();
    }





	public function bill($id)
	{
		$this->checkPermit('view_bills', $this->folder);
		$this->adminHeaderController($this->langControl('view_bills'));

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


		$stmt=$this->db->prepare("SELECT *FROM user WHERE id=?");
		$stmt->execute(array($id));
		$result=$stmt->fetch(PDO::FETCH_ASSOC);

		require($this->render($this->folder, 'html', 'view_list', 'php'));
		$this->adminFooterController();
	}



	public function processing($id,$from_date_stm=null,$to_date_stm=null)
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

						return $this->sunAmountBillByNumberBill($row[7],$row[8],$d);


				}
			),

			array('db' => 'user.username', 'dt' => 4),


			array('db' => $this->table.'.number_bill', 'dt' => 5,
				'formatter' => function ($d, $row) {
					return "<a href='".url.'/'.$this->folder."/details/{$row[7]}/{$row[8]}/{$d}'>{$d}</a>";
				}
			),

			array('db' =>$this->table.'.id', 'dt' => 6),//11
			array('db' =>$this->table.'.id_member_r', 'dt' =>7),//12
			array('db' =>$this->table.'.id_accountant_user', 'dt' =>8),//13
			array('db' =>$this->table.'.user_direct', 'dt' =>9),//14
			array('db' =>$this->table.'.number_bill', 'dt' =>10),//16



		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);


		$join = "inner JOIN register_user ON register_user.id = cart_shop_active.id_member_r  left JOIN user ON user.id = cart_shop_active.id_accountant_user ";
		if (empty($from_date_stm) && empty($to_date_stm))
		{
			$whereAll = array("{$table}.id_accountant_user ={$id}","accountant=1","cancel=0");

		}else{
			$whereAll = array("{$table}.id_accountant_user ={$id}","accountant=1","cancel=0","cart_shop_active.date_accountant BETWEEN {$from_date_stm} AND {$to_date_stm}");

		}
		$group="GROUP BY  cart_shop_active.number_bill";

		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

	}


	function sunAmountBillByNumberBill($id,$id_account,$n_b)
	{

		$stmt=$this->sumNomberBill($id,$id_account,$n_b);
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

			if (!empty($this->cuts($row['id_item'],$row['table']))) {

				$price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
				$f1 = (double)trim(str_replace(',', '', $price[0]));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1= number_format(round($xp1));

			}else {
				$price =$this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']);
				$f1 = (int)trim(str_replace(',', '', $price));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1= number_format($xp1);

			}


		}

		return $price1;
	}



	public function sumNomberBill($id,$id_account,$n_b)
	{
		$stmt = $this->db->prepare("SELECT *FROM cart_shop_active WHERE `id_member_r`=? AND `id_accountant_user` =? AND `number_bill` =? ");
		$stmt->execute(array($id,$id_account,$n_b));
		return $stmt;
	}



	function account_billAll($id,$date,$todate)
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


	public  function details($id,$id_account,$number_bill)
	{

		if (!is_numeric($id)) {$error=new Errors(); $error->index();}
		$this->checkPermit('view_request',$this->folder);
		$this->adminHeaderController($this->langControl('view_request'));


		$stmtUser=$this->db->prepare("SELECT *FROM user WHERE id=?");
		$stmtUser->execute(array($id_account));
		$resultUser=$stmtUser->fetch(PDO::FETCH_ASSOC);


		$stmt=$this->db->prepare("SELECT *FROM `register_answer` WHERE `id_user`=?");
		$stmt->execute(array($id));
		$answer=$stmt->fetch(PDO::FETCH_ASSOC);


		$id_user = $id;
		$stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ?    LIMIT 1");
		$stmt->execute(array($id_user));
		$result = $stmt->fetch();



		$stmt=$this->getAllContentFromCar($id,$id_account,$number_bill);
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
				$price =$this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']);
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

			$date_req[$row['date_req']]=$row['date_req'];

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

		$this->adminFooterController();
	}




	public function getAllContentFromCar($id_member_r,$id_account,$number_bill)
	{
		$stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx`,`number_bill`,`top`,`dollar_exchange` FROM `cart_shop_active` WHERE `id_member_r` =? AND `id_accountant_user`=?      AND `number_bill`=?  AND  `accountant`=1 GROUP BY `id_item`,`table`,`code`,`color`,`number_bill` ORDER BY `id` DESC  ");
		$stmt->execute(array($id_member_r,$id_account,$number_bill));
		return $stmt;
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
			$stmt =$this->db->prepare("SELECT COUNT(number_bill)  as number_bill FROM ( SELECT COUNT(`number_bill`) as number_bill FROM  `cart_shop_active` WHERE  `id_accountant_user`  = ? AND `accountant` =1    GROUP BY number_bill  ) number_bill   ");
			$stmt->execute(array($id));
		}else
		{
			$fromDate=strtotime($date);
			$toDate= strtotime($todate);

			$stmt =$this->db->prepare("SELECT COUNT(number_bill)  as number_bill FROM ( SELECT COUNT(`number_bill`) as number_bill FROM  `cart_shop_active` WHERE  `id_accountant_user`  = ? AND `accountant` = 1  AND `date`  between ? AND ?  GROUP BY number_bill) number_bill ");
			$stmt->execute(array($id,$fromDate,$toDate));

		}

		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		return $result['number_bill'];
	}




}









