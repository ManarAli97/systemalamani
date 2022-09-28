<?php


class money_clipper extends Controller
{

    public $ids = array();


    function __construct()
    {
        parent::__construct();
        $this->table = 'money_clipper';
        $this->money_clipper_add = 'money_clipper_add';
        $this->money_clipper_withdraw = 'money_clipper_withdraw';
        $this->money_clipper_main_user = 'money_clipper_main_user';
        $this->money_clipper_secondary_user = 'money_clipper_secondary_user';
        $this->setting = new Setting();
        if ($this->handleLogin())
        {
            $this->id_money_clipper=$this->set_money_clipper();

        }

    }



	public function createTB()
	{


		$this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
          `money`  bigint(20) NOT NULL DEFAULT 0,
          `userid`  int(10) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



		$this->db->query("CREATE TABLE IF NOT EXISTS `{$this->money_clipper_add}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
          `id_money_clipper` int(10) NOT NULL ,
          `money`  bigint(20) NOT NULL DEFAULT 0,
          `userid`  int(10) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

		$this->db->query("CREATE TABLE IF NOT EXISTS `{$this->money_clipper_withdraw}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
          `id_money_clipper` int(10) NOT NULL ,
          `money`  bigint(20) NOT NULL DEFAULT 0,
          `userid`  int(10) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


		$this->db->query("CREATE TABLE IF NOT EXISTS `{$this->money_clipper_main_user}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
          `id_money_clipper` int(10) NOT NULL,
          `money`  bigint(20) NOT NULL DEFAULT 0,   
          `flag` int(10) NOT NULL DEFAULT 0, /* صفر اضافة :1 سحب*/
          `id_user` int(10) NOT NULL, /*  علية السحب والاضافة */
          `userid`  int(10) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


		$this->db->query("CREATE TABLE IF NOT EXISTS `{$this->money_clipper_secondary_user}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
          `id_money_clipper` int(10) NOT NULL,
          `money` bigint(20) NOT NULL DEFAULT 0,   
          `flag` int(10) NOT NULL DEFAULT 0, /* صفر اضافة :1 سحب*/
          `id_user` int(10) NOT NULL, /*  علية السحب والاضافة */
          `userid`  int(10) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


		return  $this->db->cht(array($this->table));

	}


	function details_money_clipper()
    {
		$this->checkPermit('money_clipper', $this->folder);
		$this->adminHeaderController($this->langControl('add_momey_to_money_clipper'));

		$add=null;


		if (isset($_POST['money']))
		{
			$money=(int)trim(str_replace($this->comma,'',$_POST['money']));
            $note=$_POST['note'];
			$fromdate=strtotime(date('Y-m-d',time()));
			$todate=strtotime('+1 day', $fromdate);
			$stmt=$this->db->prepare("SELECT *FROM money_clipper WHERE id=? AND active=1 AND `date` BETWEEN  ? AND  ? ");
			$stmt->execute(array($this->id_money_clipper,$fromdate,$todate));
			if ($stmt->rowCount()  > 0)
			{
				$stmtu=$this->db->prepare("UPDATE money_clipper SET money=money+? ,userid=? ,date_active=? WHERE  `id`=? AND `date` BETWEEN  ? AND  ? ");
				$stmtu->execute(array($money,$this->userid,strtotime(date('Y-m-d h:i A',time())),$this->id_money_clipper,$fromdate,$todate));
				if ($stmtu->rowCount() > 0)
				{$add=1;}else{ $add=2;}
			}else{
				$stmte=$this->db->prepare("INSERT INTO money_clipper (money, userid,date,active,date_active,flag) VALUES (?,?,?,?,?,?)  ");
				$stmte->execute(array($money,$this->userid,strtotime(date('Y-m-d h:i A',time())),1,time(),0));
				if ($stmte->rowCount() > 0)
				{$add=1;}else{ $add=2;}
			}

			$stmte_add=$this->db->prepare("INSERT INTO money_clipper_add (money,note,id_money_clipper, userid,date) VALUES (?,?,?,?,?)  ");
			$stmte_add->execute(array($money,$note,$this->id_money_clipper,$this->userid,time()));
		}



		require($this->render($this->folder, 'html', 'list', 'php'));
		$this->adminFooterController();
	}







	function record_add_money_clipper()
	{
		$this->checkPermit('record_add_money_clipper', $this->folder);
		$this->adminHeaderController($this->langControl('record_add_money_clipper'));



		require($this->render($this->folder, 'html', 'add', 'php'));
		$this->adminFooterController();
	}



	public function processing_record_add_money_clipper()
	{

		$table = $this->money_clipper_add;
		$primaryKey = $table . '.id';

		$columns = array(
			array( 'db' => $table.'.money', 'dt' => 0,
				'formatter' => function( $d, $row ) {
					return   number_format($d)  .'  د.ع ';
				}
			),
			array( 'db' => $table.'.date', 'dt' =>  1 ,
				'formatter' => function( $d, $row ) {
					return date( 'Y-m-d h:i A', $d);
				}
			),
			array( 'db' => $table.'.userid', 'dt' =>  2 ,
				'formatter' => function( $d, $row ) {
					return $this->UserInfo($d);
				}
			),
            array('db' => $table.'.note', 'dt'=>3),

			array('db' => $table.'.id', 'dt'=>4)

		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);

		$join = "";

		$whereAll = array("");


		//$group="GROUP BY  {$table}.number_bill";

		echo json_encode(
			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns,'',null,'','',''));

	}








	function withdraw()
	{
		$this->checkPermit('withdraw', $this->folder);
		$this->adminHeaderController($this->langControl('withdraw'));



		require($this->render($this->folder, 'html', 'withdraw', 'php'));
		$this->adminFooterController();
	}



	public function processing_withdraw()
	{

		$table = $this->money_clipper_withdraw;
		$primaryKey = $table . '.id';

		$columns = array(
			array( 'db' => $table.'.money', 'dt' => 0,
				'formatter' => function( $d, $row ) {
					return   number_format($d)  .'  د.ع ';
				}
			),
			array( 'db' => $table.'.date', 'dt' =>  1 ,
				'formatter' => function( $d, $row ) {
					return date( 'Y-m-d h:i A', $d);
				}
			),
			array( 'db' => $table.'.userid', 'dt' =>  2 ,
				'formatter' => function( $d, $row ) {
					return $this->UserInfo($d);
				}
			),

			array('db' => $table.'.note', 'dt'=>3),
			array('db' => $table.'.id', 'dt'=>4)

		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);

		$join = "";

		$whereAll = array("");


		//$group="GROUP BY  {$table}.number_bill";

		echo json_encode(
			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns,'',null,'','',''));

	}




	function withdraw_ajax()
	{
		$this->checkPermit('withdraw', $this->folder);
		if (isset($_POST['money']))
		{
			  	$money=(int)trim(str_replace($this->comma,'',$_POST['money']));
				$fromdate=strtotime(date('Y-m-d',time()));
				$todate=strtotime('+1 day', $fromdate);
               $note= $_POST['note'];
				if (is_numeric($money)) {
					if ($money <= $this->allMoney_clipper($this->id_money_clipper)) {
						$stmte = $this->db->prepare("INSERT INTO money_clipper_withdraw (money,note,id_money_clipper, userid,date) VALUES (?,?,?,?,?)  ");
						$stmte->execute(array($money,$note, $this->id_money_clipper,$this->userid, time()));
						if ($stmte->rowCount() > 0) {
							echo 1;
						} else {
							echo 0;
						}
					} else {
						echo 'notMoney';
					}
				}

		}


	}







	public function processing()
	{

		$table = $this->table;
		$primaryKey = $table . '.id';

		$columns = array(
			array( 'db' => $table.'.money', 'dt' => 0,
				'formatter' => function( $d, $row ) {
					return   number_format($d)  .'  د.ع ';
				}
			 ),
			array( 'db' => $table.'.id', 'dt' => 1,
				'formatter' => function( $d, $row ) {
					return   number_format($this->sumMonyDayMainAcount($d,0)) .' د.ع ';
				}
			 ),
			array( 'db' => $table.'.id', 'dt' => 2,
				'formatter' => function( $d, $row ) {
					return   number_format($this->sumMonyDayMainAcount($d,1))  .' د.ع ';
				}
			 ),
			array( 'db' => $table.'.id', 'dt' => 3,
				'formatter' => function( $d, $row ) {
					return   number_format($this->sumMonyDaySecondaryAcount($d,0))  .' د.ع ';
				}
			 ),

			array( 'db' => $table.'.id', 'dt' => 4,
				'formatter' => function( $d, $row ) {
					return   number_format($this->sumMonyDaySecondaryAcount($d,1))  .' د.ع ';
				}
			 ),
//			array( 'db' => $table.'.id', 'dt' => 5,
//				'formatter' => function( $d, $row ) {
//					return   number_format((int)$row[0] - $this->remainder_clipper($d,0))  .' د.ع ';
//				}
//			 ),
//
			array( 'db' => $table.'.id', 'dt' => 5,
				'formatter' => function( $d, $row ) {
					return   number_format((int)$this->sumMonyDayMainAcount($d,0) + (int)$this->sumMonyDaySecondaryAcount($d,0))  .' د.ع ';
				}
			 ),	array( 'db' => $table.'.id', 'dt' => 6,
				'formatter' => function( $d, $row ) {
					return   number_format((int)$this->sumMonyDayMainAcount($d,1) + (int)$this->sumMonyDaySecondaryAcount($d,1))  .' د.ع ';
				}
			 ),

			array( 'db' => $table.'.id', 'dt' => 7,
				'formatter' => function( $d, $row ) {
					return   number_format((int)$this->sumMonyDayMainAcount($d,1) + (int)$this->sumMonyDaySecondaryAcount($d,1) + ((int)$row[0] - $this->remainder_clipper($d,0)) )  .' د.ع ';
				}
			 ),

			array( 'db' => $table.'.id', 'dt' => 8,
				'formatter' => function( $d, $row ) {
					return   number_format( (int)$this->widthdraw_money_clipper($d)  )  .' د.ع ';
				}
			 ),

			array( 'db' => $table.'.id', 'dt' => 9,
				'formatter' => function( $d, $row ) {
					return   number_format(((int)$this->sumMonyDayMainAcount($d,1) + (int)$this->sumMonyDaySecondaryAcount($d,1) + ((int)$row[0] - $this->remainder_clipper($d,0)))-(int)$this->widthdraw_money_clipper($d)  )  .' د.ع ';
				}
			 ),


			array( 'db' => $table.'.date', 'dt' =>  10 ,
				'formatter' => function( $d, $row ) {
					return date( 'Y-m-d h:i A', $d);
				}
			),


			array(  'db' => $table.'.id', 'dt'=>11)


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);

		$join = "";

	    $whereAll = array("");


		//$group="GROUP BY  {$table}.number_bill";

		echo json_encode(
			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns,'',null,'','',''));

	}



	function widthdraw_money_clipper($id)
	{

		$stmtd1 = $this->db->prepare("SELECT SUM(money) as money FROM money_clipper_withdraw WHERE `id_money_clipper`=?");
		$stmtd1->execute(array($id));
		$money_clipperd = $stmtd1->fetch(PDO::FETCH_ASSOC);
		return $money_clipperd['money'];
	}


	function sumMonyDayMainAcount($id,$flag)
	{

		$stmt = $this->db->prepare("SELECT SUM(money) as money FROM money_clipper_main_user WHERE `id_money_clipper`=? AND `flag`= ? ");
		$stmt->execute(array($id,$flag));
		if ($stmt->rowCount() > 0)
		{
			$money_clipper = $stmt->fetch(PDO::FETCH_ASSOC);
			return (int)$money_clipper['money'];
		}else
		{
			return 0;
		}
	}



	function sumMonyDaySecondaryAcount($id,$flag)
	{

		$stmt = $this->db->prepare("SELECT SUM(money) as money FROM money_clipper_secondary_user WHERE `id_money_clipper`=? AND `flag`= ? ");
		$stmt->execute(array($id,$flag));
		if ($stmt->rowCount() > 0)
		{
			$money_clipper = $stmt->fetch(PDO::FETCH_ASSOC);
			return (int)$money_clipper['money'];
		}else
		{
			return 0;
		}
	}



	function remainder_clipper($id,$flag)
	{

		$moneyMain=0;

		$stmt = $this->db->prepare("SELECT SUM(money) as money FROM money_clipper_main_user WHERE `id_money_clipper`=? AND `flag`= ? ");
		$stmt->execute(array($id,$flag));
		if ($stmt->rowCount() > 0)
		{
			$money_clipper = $stmt->fetch(PDO::FETCH_ASSOC);
			$moneyMain= (int)$money_clipper['money'];
		}

		$moneySecondary=0;
		$stmt = $this->db->prepare("SELECT SUM(money) as money FROM money_clipper_secondary_user WHERE `id_money_clipper`=? AND `flag`= ? ");
		$stmt->execute(array($id,$flag));
		if ($stmt->rowCount() > 0)
		{
			$money_clipper = $stmt->fetch(PDO::FETCH_ASSOC);
			$moneySecondary = (int)$money_clipper['money'];
		}

		return $moneyMain+$moneySecondary;


	}


	function main_user($id=null,$flag=0)
	{
		$this->checkPermit('main_user', $this->folder);
		$this->adminHeaderController($this->langControl('main_user'));



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
				$user[]=  $row ;
			}

		} else

		{
			die('لا يوجد مجموعة محاسبين');
		}

		if ($id)
		{
			$account=new Accountant();
			$sum=number_format((int)trim(str_replace($this->comma,'',$account->billAcount_money_clipper($id))));
		}


		require($this->render($this->folder, 'html', 'main_user', 'php'));
		$this->adminFooterController();
	}





	public function processing_add_money_to_main_user($id,$flag=0)
	{

		$table = $this->money_clipper_main_user;
		$primaryKey = $table . '.id';

		$columns = array(
			array( 'db' => $table.'.money', 'dt' => 0,
				'formatter' => function( $d, $row ) {
					return   number_format($d)  .'  د.ع ';
				}

			),
			array( 'db' => $table.'.date', 'dt' =>  1 ,
				'formatter' => function( $d, $row ) {
					return date( 'Y-m-d h:i A', $d);
				}
			),

			array( 'db' => $table.'.userid', 'dt' =>  2 ,
				'formatter' => function( $d, $row ) {
					return $this->UserInfo($d);
				}
			),

			array(  'db' => $table.'.id', 'dt'=>3)


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);

		$join = "";

		$whereAll = array("id_user = {$id}","flag = {$flag}");


		//$group="GROUP BY  {$table}.number_bill";

		echo json_encode(
			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns,'',null,$whereAll,'',''));

	}



	function secondary_user($id=null,$flag=0)
	{
		$this->checkPermit('secondary_user', $this->folder);
		$this->adminHeaderController($this->langControl('secondary_user'));
        $user = array();
		$stmt_groups =$this->db->prepare("SELECT *FROM `usergroup` WHERE   (`name` LIKE '%مباشر%' OR `name` LIKE '%مباشرين%' OR `name` LIKE '%ثانويين%')   ");
		$stmt_groups->execute();
		if ($stmt_groups->rowCount() > 0)
		{
		   while ($result_g=$stmt_groups->fetch(PDO::FETCH_ASSOC)) {
               $stmt = $this->db->prepare("SELECT *FROM  `user` WHERE  `idGroup`  = ? AND `direct`=3");
               $stmt->execute(array($result_g['id']));

               while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                   $user[] = $row;
               }

           }


		} else

		{
			die('لا يوجد مجموعة محاسبين مباشرين');
		}

		if ($id)
		{
			$direct=new direct();
			$sum=number_format((int)trim(str_replace($this->comma,'',$direct->sumAllMoney($id))));

		}


		require($this->render($this->folder, 'html', 'secondary_user', 'php'));
		$this->adminFooterController();
	}



	public function processing_add_money_to_secondary_user($id,$flag=0)
	{

		$table = $this->money_clipper_secondary_user;
		$primaryKey = $table . '.id';

		$columns = array(
			array( 'db' => $table.'.money', 'dt' => 0,
				'formatter' => function( $d, $row ) {
					return   number_format($d) .'  د.ع ';
				}

			),
			array( 'db' => $table.'.date', 'dt' =>  1 ,
				'formatter' => function( $d, $row ) {
					return date( 'Y-m-d h:i A', $d);
				}
			),

			array( 'db' => $table.'.userid', 'dt' =>  2 ,
				'formatter' => function( $d, $row ) {
					return $this->UserInfo($d);
				}
			),

			array(  'db' => $table.'.id', 'dt'=>3)


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);

		$join = "";

		$whereAll = array("id_user = {$id}","flag = {$flag}");


		//$group="GROUP BY  {$table}.number_bill";

		echo json_encode(
			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns,'',null,$whereAll,'',''));

	}
//main_user

	function add_money_to_main_user($id)
	{
		$this->checkPermit('add_money_to_main_user', $this->folder);

		if ($this->handleLogin())
		{
			$flag=0;

			if (isset($_POST['add_money'])) {
				$money = (int)trim(str_replace($this->comma, '', $_POST['add_money']));



				$sum=$this->allMoney_clipper($this->id_money_clipper);
				if ($money <= $sum) {

						$stmte = $this->db->prepare("INSERT INTO money_clipper_main_user (id_money_clipper, money, flag, id_user, userid, date) VALUES (?,?,?,?,?,?)  ");
						$stmte->execute(array($this->id_money_clipper, $money, $flag, $id, $this->userid, time()));
						if ($stmte->rowCount() > 0) {




                            $stmt_total = $this->db->prepare("SELECT *FROM `total_accountants` WHERE  `id_account` = ?  ");
                            $stmt_total->execute(array($id));
                            if ($stmt_total->rowCount() > 0) {
                                $stmt_t = $this->db->prepare("UPDATE  `total_accountants` SET `amount_from_clipping`=amount_from_clipping + {$money},`userId`=?, `date`=? WHERE  `id_account` = ?   ");
                                $stmt_t->execute(array($this->userid,time(),$id));

                            } else {
                                $stmt_t = $this->db->prepare("INSERT INTO `total_accountants` (`username`,`id_account`,`amount_from_clipping`,`userId`,`date`) values (?,?,?,?,?)");
                                $stmt_t->execute(array($this->UserInfo($id),$id, $money,$this->userid, time()));
                            }



                            echo '1';
						}

				}else
				{
					echo 'noMoney';
				}
			}
		}



	}



	function withdraw_amount_money_to_main_user($id)
	{
		$this->checkPermit('withdraw_amount_money_to_main_user', $this->folder);

		if ($this->handleLogin())
		{


			if ($this->handleLogin())
			{
				$flag=1;

				if (isset($_POST['withdraw_amount'])) {
					$money = (int)trim(str_replace($this->comma, '', $_POST['withdraw_amount']));
					$fromdate = strtotime(date('Y-m-d', time()));
					$todate = strtotime('+1 day', $fromdate);


					$account=new Accountant();
				  	$allMoney_from_star=(int)trim(str_replace($this->comma,'',$account->billAcount_money_clipper($id)));

					if ($money <= $allMoney_from_star) {
							$stmte = $this->db->prepare("INSERT INTO money_clipper_main_user (id_money_clipper, money, flag, id_user, userid, date) VALUES (?,?,?,?,?,?)  ");
							$stmte->execute(array($this->id_money_clipper,$money, $flag, $id, $this->userid, time()));
							if ($stmte->rowCount() > 0) {

                                $stmt_total = $this->db->prepare("SELECT *FROM `total_accountants` WHERE  `id_account` = ?  ");
                                $stmt_total->execute(array($id));
                                if ($stmt_total->rowCount() > 0) {
                                    $stmt_t = $this->db->prepare("UPDATE  `total_accountants` SET `amount_to_clipping`=amount_to_clipping + {$money},`userId`=?, `date`=? WHERE  `id_account` = ?   ");
                                    $stmt_t->execute(array($this->userid,time(),$id));

                                } else {
                                    $stmt_t = $this->db->prepare("INSERT INTO `total_accountants` (`username`,`id_account`,`amount_to_clipping`,`userId`,`date`) values (?,?,?,?,?)");
                                    $stmt_t->execute(array($this->UserInfo($id),$id, $money,$this->userid, time()));
                                }
								echo '1';
							}
					}else
					{
						echo 'noMoney';
					}
				}

			}



		}

	}
//-----------------


//secondary_user
	function add_money_to_secondary_user($id)
	{
		$this->checkPermit('add_money_to_secondary', $this->folder);

		if ($this->handleLogin())
		{
			$flag=0;

			if (isset($_POST['add_money'])) {
				$money = (int)trim(str_replace($this->comma, '', $_POST['add_money']));
				$fromdate = strtotime(date('Y-m-d', time()));
				$todate = strtotime('+1 day', $fromdate);

				$sum=$this->allMoney_clipper($this->id_money_clipper);

				if ($money <= $sum) {

						$stmte = $this->db->prepare("INSERT INTO money_clipper_secondary_user (id_money_clipper, money, flag, id_user, userid, date) VALUES (?,?,?,?,?,?)  ");
						$stmte->execute(array( $this->id_money_clipper,$money, $flag, $id, $this->userid, time()));
						if ($stmte->rowCount() > 0) {
							echo '1';
						}

				}else
				{
					echo 'noMoney';
				}
			}
		}



	}


	function withdraw_amount_money_to_secondary_user($id)
	{
		$this->checkPermit('withdraw_amount_money_to_secondary_user', $this->folder);

		if ($this->handleLogin())
		{


			if ($this->handleLogin())
			{
				$flag=1;

				if (isset($_POST['withdraw_amount'])) {
					$money = (int)trim(str_replace($this->comma, '', $_POST['withdraw_amount']));
					$fromdate = strtotime(date('Y-m-d', time()));
					$todate = strtotime('+1 day', $fromdate);


					$direct=new direct();
				    $sum=(int)trim(str_replace($this->comma,'',$direct->sumAllMoney($id)));

					if ($money <= $sum) {

							$stmte = $this->db->prepare("INSERT INTO money_clipper_secondary_user (id_money_clipper, money, flag, id_user, userid, date) VALUES (?,?,?,?,?,?)  ");
							$stmte->execute(array( $this->id_money_clipper,$money, $flag, $id, $this->userid, time()));
							if ($stmte->rowCount() > 0) {
								echo '1';
							}

					}else
					{
						echo 'noMoney';
					}
				}

			}



		}

	}

//---------------------------


	function addOrWithdrawMoney($id,$flag,$fromdate, $todate)
	{

		$stmt = $this->db->prepare("SELECT SUM(money) as money FROM money_clipper_main_user WHERE  `id_user`=? AND `flag`= ?  AND `date` BETWEEN  ? AND  ? ");
		$stmt->execute(array($id,$flag, $fromdate, $todate));
		if ($stmt->rowCount() > 0)
		{
			$money_clipper = $stmt->fetch(PDO::FETCH_ASSOC);
			return (int)$money_clipper['money'];
		}else
		{
			return 0;
		}


	}




	function addOrWithdrawMoneyAllDay($id,$flag)
	{

		$stmt = $this->db->prepare("SELECT SUM(money) as money FROM money_clipper_main_user WHERE  `id_user`=? AND `flag`= ?  ");
		$stmt->execute(array($id,$flag));
		if ($stmt->rowCount() > 0)
		{
			$money_clipper = $stmt->fetch(PDO::FETCH_ASSOC);
			return (int)$money_clipper['money'];
		}else
		{
			return 0;
		}


	}





	function addOrWithdrawMoneySecondaryAllDay($id,$flag)
	{

		$stmt = $this->db->prepare("SELECT SUM(money) as money FROM money_clipper_secondary_user WHERE  `id_user`=? AND `flag`= ? ");
		$stmt->execute(array($id,$flag));
		if ($stmt->rowCount() > 0)
		{
			$money_clipper = $stmt->fetch(PDO::FETCH_ASSOC);
			return (int)$money_clipper['money'];
		}else
		{
			return 0;
		}


	}




	function addOrWithdrawMoneySecondary($id,$flag,$fromdate, $todate)
	{

		$stmt = $this->db->prepare("SELECT SUM(money) as money FROM money_clipper_secondary_user WHERE  `id_user`=? AND `flag`= ?  AND `date` BETWEEN  ? AND  ? ");
		$stmt->execute(array($id,$flag, $fromdate, $todate));
		if ($stmt->rowCount() > 0)
		{
			$money_clipper = $stmt->fetch(PDO::FETCH_ASSOC);
			return (int)$money_clipper['money'];
		}else
		{
			return 0;
		}


	}





}









