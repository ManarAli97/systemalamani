<?php

class Accountant extends Controller
{

	function __construct()
	{
		parent::__construct();
		$this->cart_shop_active = 'cart_shop_active';
		$this->bill = 'bill';
		$this->setting=New Setting();
	}

	public function createTB()
	{

		$this->db->query("CREATE TABLE IF NOT EXISTS `{$this->bill}` (
           `id` int(11)  NOT NULL AUTO_INCREMENT ,
           `userid_accountant` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `userid_prepared` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `id_member_r` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `number_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `sum_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `minus_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `minus` int(11) not null default 0,
          
            /*    1-تم التنقي */
            /*    2-تم استرجاع الباقي */
            `note` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            
           PRIMARY KEY (`id`)
         ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


		return  $this->db->cht(array($this->bill));

	}



	public function index()
	{




		/*
		 * TODO set on number bill
		 */
		$this->checkPermit('view_request','accountant');
		$this->adminHeaderController($this->langControl('view_request'));



        $stmt = $this->db->prepare("SELECT id_member_r,number_bill,date_req,direct,user_direct FROM `cart_shop_active` WHERE   (`accountant` = 0 OR top= 1 ) AND `buy` <> 0 AND  `buy` < 2    AND `number_bill` <> 0  AND top =1 AND `cancel`=0 GROUP BY `number_bill` ,id_member_r   ");
		$stmt->execute();
		$count_active=array();
		while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$stmt_user = $this->db->prepare("SELECT id,`top`,phone,`name` FROM `register_user` WHERE id = ? ");
			$stmt_user->execute(array($row['id_member_r']));

			while ($row_user =$stmt_user->fetch(PDO::FETCH_ASSOC))
			{
				if ($row['top']==1)
				{
					$row_user['top']=1;
				}else{
					$row_user['top']=0;
				}
				$row_user['number_bill']=$row['number_bill'];
				// $row_user['sumbill']=$this->sunBill($row_user['id'],$row['number_bill']);
				$row_user['date_order']=date('Y-m-d h:i A',$row['date_req']);

				$row_user['direct']=$row['direct'];
				$row_user['user_direct']= $row['user_direct'];
				$count_active[]=$row_user;
			}

		}


		$stmt = $this->db->prepare("SELECT `cart_shop_active`.`top`,`cart_shop_active`.`date_req`,`cart_shop_active`.`number_bill`,`cart_shop_active`.`user_direct`,`cart_shop_active`.`direct`,register_user.name,register_user.phone ,register_user.id  FROM `cart_shop_active` INNER JOIN register_user ON register_user.id = cart_shop_active.id_member_r WHERE   `cart_shop_active`.`accountant` = 0 AND `cart_shop_active`.`buy` <> 0 AND `cart_shop_active`.`buy` < 2    AND `cart_shop_active`.`number_bill` <> 0 AND `cart_shop_active`.top=0 AND `cart_shop_active`.`cancel`=0 GROUP BY `cart_shop_active`.`number_bill`,`cart_shop_active`.id_member_r  ORDER BY   `cart_shop_active`.`number_bill` ASC ");
		$stmt->execute();
		while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
		{

				if ($row['top']==1)
				{
                    $row['top']=1;
				}else{
                    $row['top']=0;
				}

                // $row['sumbill']=$this->sunBill($row['id_member_r'],$row['number_bill']);
                $row['date_order']=date('Y-m-d h:i A',$row['date_req']);

				$count_active[]=$row;

		}



		require($this->render($this->folder, 'html', 'active', 'php'));

		$this->adminFooterController();

	}


	public function auto_print()
	{


		/*
		 * TODO set on number bill
		 */
		$this->checkPermit('auto_print','accountant');
		$this->adminHeaderController($this->langControl('auto_print'));



		require($this->render($this->folder, 'html', 'auto_print', 'php'));

		$this->adminFooterController();

	}


	function load_order()
    {


        $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   (`accountant` = 0 OR top= 1 ) AND `buy` <> 0 AND  `buy` < 2    AND `number_bill` <> 0  AND top =1 AND `cancel`=0 GROUP BY `number_bill`    ");
        $stmt->execute();
        $count_active=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $stmt_user = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ? ");
            $stmt_user->execute(array($row['id_member_r']));

            while ($row_user =$stmt_user->fetch(PDO::FETCH_ASSOC))
            {
                if ($row['top']==1)
                {
                    $row_user['top']=1;
                }else{
                    $row_user['top']=0;
                }
                $row_user['number_bill']=$row['number_bill'];
                // $row_user['sumbill']=$this->sunBill($row_user['id'],$row['number_bill']);
                $row_user['date_order']=date('Y-m-d h:i A',$row['date_req']);

                $row_user['direct']=$row['direct'];
                $row_user['user_direct']= $row['user_direct'];
                $count_active[]=$row_user;
            }

        }


        $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   `accountant` = 0 AND `buy` <> 0 AND  `buy` < 2    AND `number_bill` <> 0 AND top=0 AND `cancel`=0 GROUP BY `number_bill`  ORDER BY   `number_bill` ASC ");
        $stmt->execute();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $stmt_user = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ? ");
            $stmt_user->execute(array($row['id_member_r']));

            while ($row_user =$stmt_user->fetch(PDO::FETCH_ASSOC))
            {
                if ($row['top']==1)
                {
                    $row_user['top']=1;
                }else{
                    $row_user['top']=0;
                }
                $row_user['number_bill']=$row['number_bill'];
                // $row_user['sumbill']=$this->sunBill($row_user['id'],$row['number_bill']);
                $row_user['date_order']=date('Y-m-d h:i A',$row['date_req']);
                $row_user['direct']=$row['direct'];
                $row_user['user_direct']=$row['user_direct'];
                $count_active[]=$row_user;
            }

        }

        if (!empty($count_active))
        {
            require($this->render($this->folder, 'html', 'load_order', 'php'));

        }



    }




	function sunAllBillCustomerAccount($id,$n_bill)
	{


		$stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx`,`number_bill`,`top`,`dollar_exchange`,`prepared` FROM `cart_shop_active` WHERE `id_member_r` =? AND `number_bill`=?    AND `accountant`=1 AND `cancel`=0 GROUP BY `id_item`,`table`,`code`,`color`,`number_bill`,price_type ORDER BY `id` DESC  ");
		$stmt->execute(array($id,$n_bill));
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







	public function under_accounting()
	{

		/*
		 * TODO set on number bill
		 */
		$this->checkPermit('view_request','accountant');
		$this->adminHeaderController($this->langControl('view_request'));
		$stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   `accountant` = 0   AND `buy` <> 0 AND  `buy` < 2    AND `number_bill` <> 0   AND `cancel`=0 GROUP BY `number_bill`  ORDER BY `top`,`id_member_r`,`date_req` DESC ");
		$stmt->execute();
		$count_active=array();
		while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$stmt_user = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ? ");
			$stmt_user->execute(array($row['id_member_r']));

			$stmt_admin = $this->db->prepare("SELECT `username` FROM `user` WHERE id = ? ");
			$stmt_admin->execute(array($row['user_direct']));

			$request='الزبون هو من قام بالطلب';
			if ($stmt_admin->rowCount() > 0)
			{
				$request=$stmt_admin->fetch(PDO::FETCH_ASSOC)['username'];
			}
			while ($row_user =$stmt_user->fetch(PDO::FETCH_ASSOC))
			{
				if ($row['top']==1)
				{
					$row_user['top']=1;
				}else{
					$row_user['top']=0;
				}
				$row_user['number_bill']=$row['number_bill'];
				$row_user['date_req']=$row['date_req'];
				$row_user['name_request']=$request;
				$row_user['sum']=$this->setBill2($row['id_member_r'],$row['number_bill']) . ' د.ع';
				$count_active[]=$row_user;
			}

		}

		require($this->render($this->folder, 'html', 'under_accounting', 'php'));

		$this->adminFooterController();

	}




	function setBill2($id,$n_b)
	{

		$stmt=$this->sumNomberBill($id,$n_b);
		$request=array();

		$sum=0;
		$number_bill=0;
		$date_req=array();
		$price1=0;
		$xp1=0;
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








	public function minus()
	{

		$this->checkPermit('rest_amount_to_customer','accountant');
		$this->adminHeaderController($this->langControl('rest_amount_to_customer'));
		$stmt = $this->db->prepare("SELECT *FROM `bill` WHERE   `minus` = 1   GROUP BY `number_bill`    ");
		$stmt->execute();
		$count_active=array();
		while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$stmt_user = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ? ");
			$stmt_user->execute(array($row['id_member_r']));

			while ($row_user =$stmt_user->fetch(PDO::FETCH_ASSOC))
			{
				$row_user['number_bill']=$row['number_bill'];
				$count_active[]=$row_user;
			}

		}

		require($this->render($this->folder, 'html', 'minus', 'php'));

		$this->adminFooterController();

	}



	public function accounting_made()
	{

		$this->checkPermit('accounting_made','accountant');
		$this->adminHeaderController($this->langControl('accounting_made'));
	 
    

		require($this->render($this->folder, 'html', 'active2', 'php'));

		$this->adminFooterController();

	}



	public function notification_buy($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM  `cart_shop_active`  WHERE `id_member_r` = ? AND `buy` = 1 AND  `status` = 0  ");
		$stmt->execute(array($id));
		$number_of_rows = $stmt->fetchColumn();

		if ($number_of_rows > 0)
		{
			return '<i style="color: red" class="fa fa-bell"></i>';
		}else
		{
			return '<i style="color: lightgrey" class="fa fa-bell"></i>';
		}
	}


	public function all_notification_buy()
	{
        $stmt = $this->db->prepare("SELECT COUNT(*) as num FROM (SELECT COUNT(id) FROM `cart_shop_active` WHERE buy=1 AND number_bill <> 0 AND `accountant` = 0 AND `status` = 0 AND `cancel`=0  AND number_bill <> 0 GROUP BY number_bill,`id_member_r`) t");
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return  $result['num'];

	}

	public function minus_notification_buy()
	{
        $stmt = $this->db->prepare("SELECT COUNT(*) as num FROM (SELECT count(id) FROM `bill` WHERE `minus` =  1  GROUP BY `number_bill`) t");
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return  $result['num'];

	}

	public function notification_order()
	{
		$stmt = $this->db->prepare("SELECT COUNT(*) as num FROM (SELECT COUNT(id) FROM `cart_shop_active` WHERE buy=1  AND number_bill <> 0  AND  `accountant` = 0 AND `status` = 0 AND `cancel`=0  AND number_bill <> 0 GROUP BY number_bill,`id_member_r`) t");
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		echo  $result['num'];

	}
	public function auto_print_bill()
	{


        if ($this->admin($this->userid)) {
		$stmt = $this->db->prepare("SELECT COUNT(*) as num FROM (SELECT COUNT(id) FROM `cart_shop_active` WHERE direct <> 3 AND   buy=1 AND `accountant` = 0 AND `status` = 0  AND `auto_print`=0 AND `cancel`=0  AND number_bill <> 0 GROUP BY `id_member_r`,number_bill,`table`) t");
        }else {

            $categ = array();
            $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
            $stmt_cat->execute(array($this->userid));

            while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
                $categ[] = "'" . $row['catg'] . "'";
            }
            $c = implode(',', $categ);
            $stmt = $this->db->prepare("SELECT COUNT(*) as num FROM (SELECT COUNT(id) FROM `cart_shop_active` WHERE   direct <> 3 AND  `table` IN({$c}) AND buy=1 AND `accountant` = 0 AND `status` = 0  AND `auto_print`=0 AND cancel=0  AND number_bill <> 0 GROUP BY `id_member_r`,number_bill,`table`) t");

        }



		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		echo  $result['num'];

	}


	public function get_auto_print()
	{


        if ($this->admin($this->userid)) {
            $stmt = $this->db->prepare("SELECT id_member_r,number_bill FROM `cart_shop_active` WHERE   direct <> 3 AND   `auto_print`=0 GROUP BY id_member_r,number_bill LIMIT 1");
        }else{

            $categ=array();
            $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
            $stmt_cat->execute(array($this->userid));

            while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
            {
                $categ[]="'".$row['catg']."'";
            }
            $c=implode(',',$categ);
            $stmt = $this->db->prepare("SELECT id_member_r,number_bill FROM `cart_shop_active` WHERE    direct <> 3 AND   `table` IN({$c}) AND  `auto_print`=0 AND cancel=0 GROUP BY id_member_r,number_bill,`table` LIMIT 1");

        }


		$stmt->execute();
		if ($stmt->rowCount() > 0)
        {
            $result=$stmt->fetch(PDO::FETCH_ASSOC);

            echo  json_encode(array('id'=>$result['id_member_r'],'number_bill'=>$result['number_bill']));

        }

	}



    public function all_notification_auto_print()
    {



        if ($this->admin($this->userid)) {
            $stmt = $this->db->prepare("SELECT COUNT(*) as num FROM (SELECT COUNT(id) FROM `cart_shop_active` WHERE  direct <> 3 AND   buy=1 AND `accountant` = 0 AND `status` = 0 AND `auto_print`=0  GROUP BY `id_member_r`,number_bill,`table`) t");
        }else{

            $categ=array();
            $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
            $stmt_cat->execute(array($this->userid));

            while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
            {
                $categ[]="'".$row['catg']."'";
            }
            $c=implode(',',$categ);
            $stmt = $this->db->prepare("SELECT COUNT(*) as num FROM (SELECT COUNT(id) FROM `cart_shop_active` WHERE  direct <> 3 AND   `table` IN({$c}) AND buy=1 AND `accountant` = 0 AND `status` = 0 AND `auto_print`=0  GROUP BY `id_member_r`,number_bill,`table`) t");

        }



        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return  $result['num'];

    }


    public function done_auto_print()
    {
        if ($this->handleLogin())
        {
            $id=$_GET['id'];
            $number_bill=$_GET['number_bill'];
            $stmt = $this->db->prepare("UPDATE   `cart_shop_active`  SET auto_print=1 WHERE id_member_r= ? AND number_bill =? ");
            $stmt->execute(array($id,$number_bill));
            if ($stmt->rowCount()>0)
            {
                echo  'printed';
            }
        }


    }



	public function notification_minus()
	{
		$stmt = $this->db->prepare("SELECT COUNT(*) as num FROM (SELECT count(id) FROM `bill` WHERE `minus` =  1  GROUP BY `number_bill`) t");
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        echo  $result['num'];

	}



    function rewindNotif()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as num FROM (SELECT COUNT(id) FROM `review` WHERE   `active` = 0 AND cancel=0  GROUP BY `id_customre`) t");
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        echo  $result['num'];


    }


    function rewindNotif_buy()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as num FROM (SELECT COUNT(id) FROM `review` WHERE   `active` = 0 AND cancel =0  GROUP BY `id_customre`) t");
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return  $result['num'];


    }


    public  function view_order($id)
	{

		if (!is_numeric($id)) {$error=new Errors(); $error->index();}
//		$this->checkPermit('view_order','accountant');

		$number_bill=$_GET['number_bill'];

		$id_user = $id;
		$stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ?    LIMIT 1");
		$stmt->execute(array($id_user));
		$result = $stmt->fetch();


		$stmt=$this->getAllContentFromCar($id,$number_bill);
		$request=array();

		$sum=0;
		$date_req=array();
		$price1=0;
		$xp1=0;
		$xpd=0;
		$number_type=0;
		$sum_material=0;
		$price_dollars=0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{


			if (!empty($this->cuts($row['id_item'],$row['table']))) {

				$price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
                $row['price']=$price;
                $f1 = (int)trim(str_replace($this->comma, '', $price[0]));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1= number_format(round($xp1));


			} else {

                if ($this->check_item_round($row['table'],$row['id_item'])) {
                    $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
                    $row['price']= $price;
                }else
                {
                    $price = $this->not_round_price($row['price_dollars'], $row['dollar_exchange']);
                    $row['price']= $price;
                }

				$f1 = (int)trim(str_replace($this->comma, '', $price));
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
			$number_bill=$row['number_bill'];
			$table=$row['table'];
			$stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
			$stmt_get_item->execute(array($row['id_item']));
			$item = $stmt_get_item->fetch(PDO::FETCH_ASSOC);

			$row['title']=$item['title'];
			$row['img']=$this->save_file.$row['image'];

			$date_req[$row['date_req']]=$row['date_req'];
            if ($row['direct']  > 0 || $row['user_direct'] !=0  )
            {
                $prepared=$this->UserInfo($row['user_direct']);
            }else
            {
                $prepared=$this->UserInfo($row['id_prepared']);
            }
            $row['color_name']=$row['name_color'];



			$request[]=$row;
		}
		$date_req=json_encode($date_req);

		/*             بسبب تجميعة العروض       */


		$requestPrint=array();


		$price1_Offer=0;
		$price1_normal=0;
		$xp1Offer=0;
		$xpdOffer=0;
		$number_typeOffer=0;
		$sum_materialOffer=0;
		$price_dollarsOffer=0;




        $stmtOffer = $this->db->prepare("SELECT  cart_shop_active.*  FROM `cart_shop_active` WHERE `id_member_r` =? AND `number_bill`=? AND   `buy` = 1 AND `status` =0 AND `accountant`=0  AND id_offer <> 0 AND offers = 'offers' GROUP BY  `date_offer`  ORDER BY `id` DESC  ");
        $stmtOffer->execute(array($id,$number_bill));

        while ($row = $stmtOffer->fetch(PDO::FETCH_ASSOC))
        {


            if ($row['offers']  =='offers')
            {

                    $row['price'] = $this->priceDollarOffer($row['id_offer'],4) . ' د.ع ';
                   $price1_Offer = $price1_Offer + (int)str_replace($this->comma,'',$this->priceDollarOffer($row['id_offer'],4));
                    $row['price_dollars'] = $this->priceDollarOffer($row['id_offer'],3)  ;

                $row['title']=$this->details_offer($row['id_offer'],'title');

                $row['img']=$this->save_file.$this->details_offer($row['id_offer'],'img');

            }
            $row['size']='';
            $row['name_color']='';





            $pd=explode('-',$row['price_dollars'])  ;
            $f1d= (double)trim(str_replace(',','.', $pd[0]));
            $xpdOffer = $xpdOffer + ($f1d * $row['number']);
            $price_dollarsOffer= $xpdOffer;
            $number_typeOffer=$number_typeOffer+1;
            $sum_materialOffer=$sum_materialOffer+$row['number'];

            $date=$row['date'];
            $number_bill=$row['number_bill'];


            if ($row['direct']  > 0 || $row['user_direct'] !=0  )
            {
                $prepared=$this->UserInfo($row['user_direct']);
            }else
            {
                $prepared=$this->UserInfo($row['id_prepared']);
            }
            $row['color_name']=$row['name_color'];




            $requestPrint[]=$row;
        }



        $stmtOffer = $this->db->prepare("SELECT  cart_shop_active.*,SUM(number) as number FROM `cart_shop_active` WHERE `id_member_r` =? AND `number_bill`=? AND   `buy` = 1 AND `status` =0 AND `accountant`=0   AND id_offer = 0  AND offers = ''  GROUP BY  `id_item`,`table`,`code`,`color`,`number_bill`,price_type  ORDER BY `id` DESC  ");
        $stmtOffer->execute(array($id,$number_bill));

		while ($row = $stmtOffer->fetch(PDO::FETCH_ASSOC))
		{



                $table=$row['table'];
                $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
                $stmt_get_item->execute(array($row['id_item']));
                $item = $stmt_get_item->fetch();

                $row['title']=$item['title'];
                $row['img']=$this->save_file.$row['image'];



                if (!empty($this->cuts($row['id_item'],$row['table']))) {

				$price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
                    $row['price']= $price;
				$f1 = (int)trim(str_replace($this->comma, '', $price[0]));
                $xp1Offer = $xp1Offer + ($f1 * $row['number']);
                    $price1_normal= (round($xp1Offer));


			} else {

                if ($this->check_item_round($row['table'],$row['id_item'])) {
                    $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
                    $row['price']= $price;
                }else
                {
                    $price = $this->not_round_price($row['price_dollars'], $row['dollar_exchange']);
                    $row['price']= $price;
                }

				$f1 = (int)trim(str_replace($this->comma, '', $price));
                $xp1Offer = $xp1Offer + ($f1 * $row['number']);
                    $price1_normal= ($xp1Offer);

			}

			$pd=explode('-',$row['price_dollars'])  ;
			$f1d= (double)trim(str_replace(',','.', $pd[0]));
            $xpdOffer = $xpdOffer + ($f1d * $row['number']);
            $price_dollarsOffer= $xpdOffer;
            $number_typeOffer=$number_typeOffer+1;
            $sum_materialOffer=$sum_materialOffer+$row['number'];

			$date=$row['date'];
			$number_bill=$row['number_bill'];


			if ($row['direct']  > 0 || $row['user_direct'] !=0  )
            {
                $prepared=$this->UserInfo($row['user_direct']);
            }else
            {
                $prepared=$this->UserInfo($row['id_prepared']);
            }
				$row['color_name']=$row['name_color'];



            $requestPrint[]=$row;
		}

        $price1Offer=0;
        $price1Offer=(int)str_replace($this->comma,'',$price1_Offer)+(int)str_replace($this->comma,'',$price1_normal);


		require($this->render($this->folder, 'html', 'order', 'php'));

	}



	public  function view_order_under_accounting_order($id,$number_bill)
	{

		if (!is_numeric($id)) {$error=new Errors(); $error->index();}
		$this->checkPermit('view_request','accountant');
		$this->adminHeaderController($this->langControl('view_request'));


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
		$xp1=0;
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

		require($this->render($this->folder, 'html', 'under_accounting_order', 'php'));

		$this->adminFooterController();
	}




	public  function order_miuns($id,$number_bill)
	{

		if (!is_numeric($id)) {$error=new Errors(); $error->index();}

		$xstmt=$this->db->prepare("SELECT *FROM `bill` WHERE  `id_member_r` = ? AND number_bill=? AND `minus` = 1");
		$xstmt->execute(array($id,$number_bill));
		$result=$xstmt->fetch(PDO::FETCH_ASSOC);


		$item=array();

		$stmt=$this->db->prepare("SELECT *FROM `retrieve_item` WHERE `id_customer`=? AND number_bill=? AND `type`='minus' AND `recovery`=0 AND type_account <> 3 GROUP BY id_item");
		$stmt->execute(array($id,$number_bill));
		while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$table=$row['table'];
			$stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
			$stmt_get_item->execute(array($row['id_item']));
			$data = $stmt_get_item->fetch(PDO::FETCH_ASSOC);

			$row['title']=$data['title'];
			$row['img']=$this->save_file.$row['image'];


			if (!empty($this->cuts($row['id_item'],$row['table'])))
			{
				$row['price']=  $this->cuts($row['id_item'],$row['table']).' د.ع ';
			}else
			{
				$row['price']= $this->price_dollarsAdmin($row['price'],$row['dollar_exchange']).' د.ع ';
			}



			$item[]=$row;
		}


		$stmt2=$this->db->prepare("SELECT *FROM `retrieve_item` WHERE `id_customer`=? AND number_bill=? AND `type`='cancel' AND `recovery`=0  GROUP BY id_item");
		$stmt2->execute(array($id,$number_bill));

		if ($stmt2->rowCount() > 0 )
		{


			$stmt3=$this->db->prepare("SELECT   *  FROM `cart_shop_active` WHERE `id_member_r`=? AND number_bill=? ");
			$stmt3->execute(array($id,$number_bill));
			while ($row3=$stmt3->fetch(PDO::FETCH_ASSOC))
			{

				$table=$row3['table'];
				$stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
				$stmt_get_item->execute(array($row3['id_item']));
				$data = $stmt_get_item->fetch(PDO::FETCH_ASSOC);

				$row3['title']=$data['title'];
				$row3['img']=$this->save_file.$row3['image'];
				$row3['color']=$row3['name_color'];


				if (!empty($this->cuts($row3['id_item'],$row3['table'])))
				{
					$row3['price']=  $this->cuts($row3['id_item'],$row3['table']).' د.ع ';
				}else
				{
					$row3['price']= $this->price_dollarsAdmin($row3['price_dollars'],$row3['dollar_exchange']).' د.ع ';
				}


				$item[]=$row3;
			}

		}


		require($this->render($this->folder, 'html', 'order_miuns', 'php'));

	}




	public function getAllContentFromCar($id_member_r,$number_bill)
	{
		$stmt = $this->db->prepare("SELECT  cart_shop_active.*,SUM(`number`)as number FROM `cart_shop_active` WHERE `id_member_r` =? AND `number_bill`=? AND   `buy` = 1 AND `status` =0 AND `accountant`=0 GROUP BY `id_item`,`table`,`code`,`number_bill`,price_type,id_offer ORDER BY `id` DESC  ");
		$stmt->execute(array($id_member_r,$number_bill));
		return $stmt;
	}

	public function getAllContentFromCar_number_bill($id_member_r,$number_bill)
	{
		$stmt = $this->db->prepare("SELECT   cart_shop_active.*,SUM(`number`)as number FROM `cart_shop_active` WHERE `id_member_r` =? AND number_bill =? AND   `buy` = 1 AND `status` =0 AND `accountant`=0 GROUP BY `id_item`,`table`,`code`,`number_bill`,price_type,id_offer ORDER BY `id` DESC  ");
		$stmt->execute(array($id_member_r,$number_bill));
 
		return $stmt;
	}


	function return_order_minus($table,$code,$id_user)
	{
		if (!is_string($table)) {$error=new Errors(); $error->index();}
		if (!is_numeric($id_user)) {$error=new Errors(); $error->index();}

		if ($this->handleLogin()) {

			$this->checkPermit('return_order_minus', 'accountant');
			$color = $_GET['color'];
			$number_bill= $_GET['number_bill'];



			$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=?  ");
			$stmtt->execute(array($number_bill));
			$oldData=array();
			while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
			{
				$oldData[]=$rowt;
			}

			$stmt_count_n = $this->db->prepare("SELECT  *FROM `{$this->cart_shop_active}` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?    AND `number_bill`=? AND `buy` = 1 AND `accountant`=0 AND `number` = 1");
			$stmt_count_n->execute(array($table, $code, $id_user,$number_bill));

			if ($stmt_count_n->rowCount() > 0 )
			{


				/*  trace Accountant Minus  */
				$stmt_retrieve_item=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?  AND `number_bill` = ? AND `buy` = 1   LIMIT  1 ");
				$stmt_retrieve_item->execute(array($table, $code, $id_user,$number_bill));
				$resultRI=$stmt_retrieve_item->fetch(PDO::FETCH_ASSOC);
				$accountant=new Accountant();
                $id_row_tem=$resultRI['id_item'];
				$accountant->retrieve_item(array(
					'id_item'=>$resultRI['id_item'],
					'id_cart'=>$resultRI['id'],
					'number_bill'=>$number_bill,
					'code'=>$code,
					'color'=>$color,
					'image'=>$resultRI['image'],
					'price'=>$resultRI['price_dollars'],
					'table'=>$table,
					'id_user'=>$this->userid,
					'dollar_exchange'=>$resultRI['dollar_exchange'],
					'type'=>'minus',
					'date'=>time(),
					'number'=>1,
					'recovery'=>1,
                    'delete'=>1,
					'delete_user'=>$this->userid,
					'delete_date'=>time(),
					'id_customer'=>$id_user,
                    'id_accountant_user'=>$resultRI['id_accountant_user'],
                    'accountant'=>$resultRI['accountant'],
                    'prepared'=>$resultRI['prepared']
				));



				$stmt_delete_last_one = $this->db->prepare("SELECT SUM(`number`)as number  FROM `{$this->cart_shop_active}` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `name_color` = ? AND `number_bill`=?  AND `buy` = 1 AND `accountant`=0");
				$stmt_delete_last_one->execute(array($table, $code, $id_user,$color,$number_bill));
				$number= $stmt_delete_last_one->fetch(PDO::FETCH_ASSOC)['number'];

				if ($number == 1) {

					$stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ? AND `number_bill`=? AND `buy` = 1 AND `accountant`=0  LIMIT 1 ");
					$stmt->execute(array($table, $code, $id_user,$color,$number_bill));
					echo  0;

				}else if ($number > 1)
				{
					$stmt_sel = $this->db->prepare("UPDATE  `cart_shop_active` SET  `number`=`number` - 1  WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ? AND `number_bill`=? AND `buy` = 1  AND number > 1 AND `accountant`=0 LIMIT  1  ");
					$stmt_sel->execute(array($table, $code, $id_user,$color,$number_bill));
					if ($stmt_sel->rowCount() < 1)
					{
						$stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ? AND `number_bill`=? AND `buy` = 1 AND `accountant`=0  LIMIT 1 ");
						$stmt->execute(array($table, $code, $id_user,$color,$number_bill));
					}
				}else{
					$stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?   AND `number_bill`=? AND `buy` = 1 AND `accountant`=0 LIMIT 1 ");
					$stmt->execute(array($table, $code, $id_user,$number_bill));
				}

			} else
			{

				/*  trace Accountant Minus  */
				$stmt_retrieve_item=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `number_bill` = ? AND `buy` = 1   LIMIT  1 ");
				$stmt_retrieve_item->execute(array($table, $code, $id_user,$number_bill));
				$resultRI=$stmt_retrieve_item->fetch(PDO::FETCH_ASSOC);
				$accountant=new Accountant();
				$accountant->retrieve_item(array(
					'id_item'=>$resultRI['id_item'],
					'id_cart'=>$resultRI['id'],
					'number_bill'=>$number_bill,
					'code'=>$code,
					'color'=>$color,
					'image'=>$resultRI['image'],
					'price'=>$resultRI['price_dollars'],
					'table'=>$table,
					'id_user'=>$this->userid,
					'dollar_exchange'=>$resultRI['dollar_exchange'],
					'type'=>'minus',
					'date'=>time(),
					'number'=>1,
                    'recovery'=>1,
                    'delete'=>1,
                    'delete_user'=>$this->userid,
                    'delete_date'=>time(),
					'id_customer'=>$id_user,
                    'id_accountant_user'=>$resultRI['id_accountant_user'],
                    'accountant'=>$resultRI['accountant'],
                    'prepared'=>$resultRI['prepared']
				));
 

				$stmt_sel = $this->db->prepare("UPDATE  `cart_shop_active` SET  `number`=`number` - 1  WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ? AND `number_bill`=? AND `buy` = 1  AND number > 1 AND `accountant`=0 LIMIT  1  ");
				$stmt_sel->execute(array($table, $code, $id_user,$color,$number_bill));

			}


			$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=? ");
			$stmtt->execute(array($number_bill));
			$newData=array();
			while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
			{
				$newData[]=$rowt;
			}

			$trace = new trace(); $trace->addtrace('cart_shop_active','محاسبة',json_encode($oldData),json_encode($newData),  'تنقيص من الطلب',$number_bill);

			$this->edit_bill($number_bill,$this->userid);



            $this->set_quantity_order_minus($table,$id_row_tem,$code,1);

			$stmt2 = $this->db->prepare("SELECT  SUM(`number`)as number  FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ?  AND `number_bill`=? AND `buy`= 1 AND `accountant`=0 GROUP BY `id_item`,`size`,`table`,`code`,`name_color`  ORDER BY `id`  DESC  ");
			$stmt2->execute(array($table, $code, $id_user,$color,$number_bill));
			$res = $stmt2->fetch(PDO::FETCH_ASSOC);

			if ($stmt2->rowCount() > 0) {
				echo $res['number'];
			}


        }

	}




	function return_order_minus_after_accept($table,$code,$id_user)
	{
		if (!is_string($table)) {$error=new Errors(); $error->index();}
		if (!is_numeric($id_user)) {$error=new Errors(); $error->index();}

		if ($this->handleLogin()) {

			$this->checkPermit('return_order_minus', 'accountant');
			$color = $_GET['color'];
			$number_bill= $_GET['number_bill'];

			$flag=0;


			$countBill=0;
			$stmtCountNumberBillForClear = $this->db->prepare("SELECT COUNT(number_bill) as bill , SUM(number) as num FROM `cart_shop_active` WHERE  `number_bill`=?   ");
			$stmtCountNumberBillForClear->execute(array($number_bill));
			if ($stmtCountNumberBillForClear->rowCount() > 0)
			{
				$rCountBill=$stmtCountNumberBillForClear->fetch(PDO::FETCH_ASSOC);
				$sumNumber=$rCountBill['num'];
				$countB= $rCountBill['bill'];
				if ($sumNumber == 1 && $countB == 1)
				{
					$countBill=$countB;
				}

			}



			$stmt_count_n = $this->db->prepare("SELECT  *FROM `{$this->cart_shop_active}` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `name_color` = ?   AND `buy` = 1 AND `accountant`=1 AND `prepared`=1 AND `number_bill`=?  AND `number` = 1");
			$stmt_count_n->execute(array($table, $code, $id_user,$color,$number_bill));

			if ($stmt_count_n->rowCount() > 0 )
			{



                $stmt_totalc = $this->db->prepare("SELECT  *FROM `{$this->cart_shop_active}` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `number_bill`=?  LIMIT 1");
                $stmt_totalc->execute(array($table, $code, $id_user,$number_bill));
                if($stmt_totalc->rowCount() > 0)
                {
                    $result_total=$stmt_totalc->fetch(PDO::FETCH_ASSOC);

                    $price1 = 0;
                    $xp1 = 0;

                    if (!empty($this->cuts($result_total['id_item'], $result_total['table']))) {

                        $price = explode('-', $this->cuts($result_total['id_item'], $result_total['table']));
                        $f1 = (double)trim(str_replace(',', '', $price[0]));
                        $xp1 = $xp1 + ($f1 * 1);
                        $price1 = $xp1;

                    } else {

                        $price = $this->price_dollarsAdmin($result_total['price_dollars'], $result_total['dollar_exchange']);
                        $f1 = (int)trim(str_replace(',', '', $price));
                        $xp1 = $xp1 + ($f1 * 1);
                        $price1 = $xp1;

                    }
                    $sum = (int)str_replace($this->comma,'',trim($price1));

                    $stmt_total = $this->db->prepare("SELECT *FROM `total_accountants` WHERE  `id_account` = ?  ");
                    $stmt_total->execute(array($this->userid));
                    if ($stmt_total->rowCount() > 0) {
                        $stmt_t = $this->db->prepare("UPDATE  `total_accountants` SET `minus_customer`=minus_customer + {$sum}  ,`userId`=?, `date`=? WHERE  `id_account` = ?   ");
                        $stmt_t->execute(array($this->userid,time(),$this->userid));

                    } else {
                        $stmt_t = $this->db->prepare("INSERT INTO `total_accountants` (`username`,`id_account`,`minus_customer`,`userId`,`date`) values (?,?,?,?,?)");
                        $stmt_t->execute(array(Session::get('usernamelogin'),$this->userid,$sum,$this->userid, time()));
                    }


                }




                /*  trace Accountant Minus  */
                $stmt_retrieve_item=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `number_bill` = ? AND `buy` = 1   LIMIT  1 ");
                $stmt_retrieve_item->execute(array($table, $code, $id_user,$number_bill));
                $resultRI=$stmt_retrieve_item->fetch(PDO::FETCH_ASSOC);
                $accountant=new Accountant();
                $accountant->retrieve_item(array(
                    'id_item'=>$resultRI['id_item'],
                    'id_cart'=>$resultRI['id'],
                    'number_bill'=>$number_bill,
                    'code'=>$code,
                    'color'=>$color,
                    'image'=>$resultRI['image'],
                    'price'=>$resultRI['price_dollars'],
                    'table'=>$table,
                    'id_user'=>$this->userid,
                    'dollar_exchange'=>$resultRI['dollar_exchange'],
                    'type'=>'minus',
                    'date'=>time(),
                    'number'=>1,
                    'recovery'=>1,
                    'delete'=>1,
                    'delete_user'=>$this->userid,
                    'delete_date'=>time(),
                    'id_customer'=>$id_user,
                    'id_accountant_user'=>$resultRI['id_accountant_user'],
                    'accountant'=>$resultRI['accountant'],
                    'prepared'=>$resultRI['prepared']
                ));


                $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=? ");
				$stmtt->execute(array($number_bill));
				$oldData=array();
				while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
				{
					$oldData[]=$rowt;
				}

				$stmt_delete_last_one = $this->db->prepare("SELECT SUM(`number`)as number  FROM `{$this->cart_shop_active}` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `name_color` = ?   AND `buy` = 1 AND `accountant`=1 AND `prepared`=1 AND `number_bill`=?");
				$stmt_delete_last_one->execute(array($table, $code, $id_user,$color,$number_bill));
				$number= $stmt_delete_last_one->fetch(PDO::FETCH_ASSOC)['number'];

				if ($number == 1) {

					$stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ?  AND `buy` = 1 AND `accountant`=1 AND `prepared`=1 AND `number_bill`=? LIMIT 1 ");
					$stmt->execute(array($table, $code, $id_user,$color,$number_bill));
					$flag=1;

				}else if ($number > 1)
				{
					$stmt_sel = $this->db->prepare("UPDATE  `cart_shop_active` SET  `number`=`number` - 1  WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ?  AND `buy` = 1  AND number > 1 AND `accountant`=1 AND `prepared`=1 AND `number_bill`=? LIMIT  1  ");
					$stmt_sel->execute(array($table, $code, $id_user,$color,$number_bill));
					if ($stmt_sel->rowCount() < 1)
					{
						$stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ?  AND `buy` = 1 AND `accountant`=1 AND `prepared`=1 AND `number_bill`=? LIMIT 1 ");
						$stmt->execute(array($table, $code, $id_user,$color,$number_bill));
						$flag=1;
					}else{
						$flag=1;
					}
				}else{
					$stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ?  AND `buy` =2 AND `accountant`=1 AND `prepared`=1 AND `number_bill`=? LIMIT 1 ");
					$stmt->execute(array($table, $code, $id_user,$color,$number_bill));
					$flag=1;
				}

			} else
			{



                $stmt_totalc = $this->db->prepare("SELECT  *FROM `{$this->cart_shop_active}` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `number_bill`=?  LIMIT 1");
                $stmt_totalc->execute(array($table, $code, $id_user,$number_bill));
                if($stmt_totalc->rowCount() > 0)
                {
                    $result_total=$stmt_totalc->fetch(PDO::FETCH_ASSOC);

                    $price1 = 0;
                    $xp1 = 0;

                    if (!empty($this->cuts($result_total['id_item'], $result_total['table']))) {

                        $price = explode('-', $this->cuts($result_total['id_item'], $result_total['table']));
                        $f1 = (double)trim(str_replace(',', '', $price[0]));
                        $xp1 = $xp1 + ($f1 * 1);
                        $price1 = $xp1;

                    } else {

                        $price = $this->price_dollarsAdmin($result_total['price_dollars'], $result_total['dollar_exchange']);
                        $f1 = (int)trim(str_replace(',', '', $price));
                        $xp1 = $xp1 + ($f1 * 1);
                        $price1 = $xp1;

                    }
                    $sum = (int)str_replace($this->comma,'',trim($price1));

                    $stmt_total = $this->db->prepare("SELECT *FROM `total_accountants` WHERE  `id_account` = ?  ");
                    $stmt_total->execute(array($this->userid));
                    if ($stmt_total->rowCount() > 0) {
                        $stmt_t = $this->db->prepare("UPDATE  `total_accountants` SET `minus_customer`=minus_customer + {$sum}  ,`userId`=?, `date`=? WHERE  `id_account` = ?   ");
                        $stmt_t->execute(array($this->userid,time(),$this->userid));

                    } else {
                        $stmt_t = $this->db->prepare("INSERT INTO `total_accountants` (`username`,`id_account`,`minus_customer`,`userId`,`date`) values (?,?,?,?,?)");
                        $stmt_t->execute(array(Session::get('usernamelogin'),$this->userid,$sum,$this->userid, time()));
                    }


                }





                /*  trace Accountant Minus  */
                $stmt_retrieve_item=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `number_bill` = ? AND `buy` = 1   LIMIT  1 ");
                $stmt_retrieve_item->execute(array($table, $code, $id_user,$number_bill));
                $resultRI=$stmt_retrieve_item->fetch(PDO::FETCH_ASSOC);
                $accountant=new Accountant();
                $accountant->retrieve_item(array(
                    'id_item'=>$resultRI['id_item'],
                    'id_cart'=>$resultRI['id'],
                    'number_bill'=>$number_bill,
                    'code'=>$code,
                    'color'=>$color,
                    'image'=>$resultRI['image'],
                    'price'=>$resultRI['price_dollars'],
                    'table'=>$table,
                    'id_user'=>$this->userid,
                    'dollar_exchange'=>$resultRI['dollar_exchange'],
                    'type'=>'minus',
                    'date'=>time(),
                    'number'=>1,
                    'recovery'=>1,
                    'delete'=>1,
                    'delete_user'=>$this->userid,
                    'delete_date'=>time(),
                    'id_customer'=>$id_user,
                    'id_accountant_user'=>$resultRI['id_accountant_user'],
                    'accountant'=>$resultRI['accountant'],
                    'prepared'=>$resultRI['prepared']
                ));



                $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=? ");
				$stmtt->execute(array($number_bill));
				$oldData=array();
				while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
				{
					$oldData[]=$rowt;
				}

				$stmt_sel = $this->db->prepare("UPDATE  `cart_shop_active` SET  `number`=`number` - 1  WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ?  AND `buy` = 1   AND number > 1 AND `accountant`=1 AND `prepared`=1 AND `number_bill`=? LIMIT  1  ");
				$stmt_sel->execute(array($table, $code, $id_user,$color,$number_bill));
				$flag=1;

			}

			if ($flag==1) {


                $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=? ");
				$stmtt->execute(array($number_bill));
				$newData=array();
				while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
				{
					$newData[]=$rowt;
				}

				$trace = new trace(); $trace->addtrace('cart_shop_active','محاسبة',json_encode($oldData),json_encode($newData),'تنقيص الطلب بعد المحاسبة',$number_bill);

				$this->edit_bill($number_bill,$this->userid);


                $stmttIdItem=$this->db->prepare("SELECT id_item FROM `cart_shop_active` WHERE `number_bill` = ? AND id_member_r=?");
                $stmttIdItem->execute(array($number_bill,$id_user));
                $resultIdItem= $stmttIdItem->fetch(PDO::FETCH_ASSOC);
                $this->set_quantity_order_minus($table,$resultIdItem['id_item'],$code,1);



                $stmtm = $this->db->prepare("UPDATE  `bill` SET  sum_bill=?,userid_accountant=? WHERE  `id_member_r` = ? AND number_bill=?   ");
				$stmtm->execute(array((int)str_replace($this->comma,'',$this->setBill($id_user,$number_bill)),$this->userid,$id_user,$number_bill));

				echo number_format($this->setBill($id_user,$number_bill));


				if ($stmtm->rowCount() > 0)
				{
					if ($countBill==1)
					{
						$this->clearBill($number_bill,$countBill);
					}

				}

			}

		}

	}



	function setBill($id,$n_b)
	{



		$stmt=$this->getAllContentFromCar_byNomberBill($id,$n_b);
		$request=array();

		$sum=0;
		$number_bill=0;
		$date_req=array();
		$price1=0;
		$xp1=0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{

			if (!empty($this->cuts($row['id_item'],$row['table']))) {

				$price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
				$f1 = (double)trim(str_replace(',', '', $price[0]));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1= $xp1;

			}else {
				$price =$this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']);
				$f1 = (int)trim(str_replace(',', '', $price));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1= $xp1;

			}



		}

		return $price1;
	}



	public function sumNomberBill($id_member_r,$n_b)
	{
		$stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx`,`number_bill`,`top`,`dollar_exchange` FROM `cart_shop_active` WHERE `id_member_r` =?  AND  `number_bill` =? AND `accountant`=0 GROUP BY `id_item`,`table`,`code`,`color` ORDER BY `id` DESC  ");
		$stmt->execute(array($id_member_r,$n_b));
		return $stmt;
	}


	public function getAllContentFromCar_byNomberBill($id_member_r,$n_b)
	{
		$stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx`,`number_bill`,`top`,`dollar_exchange` FROM `cart_shop_active` WHERE `id_member_r` =?  AND  `number_bill` =? AND `accountant`=1 GROUP BY `id_item`,`table`,`code`,`color` ORDER BY `id` DESC  ");
		$stmt->execute(array($id_member_r,$n_b));
		return $stmt;
	}



	public function getAllContentFromCar_number_bill_after_accept($id_member_r,$number_bill,$code)
	{
		$stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx`,`number_bill`,`top`,`dollar_exchange` FROM `cart_shop_active` WHERE `id_member_r` =? AND number_bill =? AND  `code`=?  LIMIT 1  ");
		$stmt->execute(array($id_member_r,$number_bill,$code));
		return $stmt;
	}




	function return_order_plus($table,$code,$id_user)
	{
		if (!is_string($table)) {$error=new Errors(); $error->index();}
		if (!is_numeric($id_user)) {$error=new Errors(); $error->index();}

		if ($this->handleLogin()) {
			$this->checkPermit('return_order_plus', 'accountant');
			$color = $_GET['color'];
			$number_bill = $_GET['number_bill'];


			$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill` = ? AND id_member_r=?");
			$stmtt->execute(array($number_bill,$id_user));
			$oldData=array();
			while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
			{
				$oldData[]=$rowt;
			}

			$stmt_sel = $this->db->prepare("UPDATE  `cart_shop_active` SET  `number`=`number` + 1  WHERE `table` =?  AND `code` =? AND `id_member_r` = ? AND  `name_color` = ?  AND  `number_bill` = ? AND `buy` = 1  AND `accountant`=0 LIMIT  1  ");
			$stmt_sel->execute(array($table, $code, $id_user,$color,$number_bill));

			$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill` = ?  ");
			$stmtt->execute(array($number_bill));
			$newData=array();
			while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
			{
				$newData[]=$rowt;
			}

			$trace = new trace(); $trace->addtrace('cart_shop_active','المحاسب زيادة الطلب -رقم الفاتورة '.$number_bill,json_encode($oldData),json_encode($newData),  '  زيادة الطلب ',$number_bill);
			$this->edit_bill($number_bill,$this->userid);

			if ($stmt_sel->rowCount() > 0 ) {



               $stmttIdItem=$this->db->prepare("SELECT id_item FROM `cart_shop_active` WHERE `number_bill` = ? AND id_member_r=?");
               $stmttIdItem->execute(array($number_bill,$id_user));
               $resultIdItem= $stmttIdItem->fetch(PDO::FETCH_ASSOC);

                $this->set_quantity_order($table,$resultIdItem['id_item'],$code,1);




				$stmt2 = $this->db->prepare("SELECT SUM(`number`)as number  FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ? AND `name_color`=?  AND `number_bill`=? AND `buy`= 1 AND `accountant`=0 GROUP BY `id_item`,`size`,`table`,`code`,`number_bill` ORDER BY `id`  DESC  ");
				$stmt2->execute(array($table, $code, $id_user,$color,$number_bill));
				$res = $stmt2->fetch(PDO::FETCH_ASSOC);

				if ($stmt2->rowCount() > 0) {
					echo $res['number'];
				}
			}

		}
	}


	function processing_request($id)
	{
		if ($this->handleLogin()) {
			if (!is_numeric($id)) {
				$error = new Errors();
				$error->index();
			}
			$this->checkPermit('processing_request', 'accountant');
			$date_req = $_GET['date_req'];
			$number_bill = $_GET['number_bill'];



			$stmtChAcco = $this->db->prepare("SELECT *FROM  `cart_shop_active`  WHERE `number_bill` =? AND `id_member_r`=? AND `buy` = 1  AND cancel=0  AND accountant=0 ");
			$stmtChAcco->execute(array($number_bill, $id));
			if ($stmtChAcco->rowCount() > 0) {



				$sum = (int)trim(str_replace($this->comma, '', $this->sunBill($id,$number_bill)));


				$stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill` = ? ");
				$stmtt->execute(array( $number_bill));
				$oldData = array();
				while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
					$oldData[] = $rowt;
				}

				$date_req = implode(',', $date_req);
				$stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `status` = 1 ,  `accountant` = 1 , `prepared` = 1 , `date_accountant`= ? , `user_id`=?,`id_accountant_user`=?,`top`=0 ,auto_print=1 WHERE `number_bill` =? AND `buy` = ?  AND `id_member_r`=?  AND `date_req` IN ($date_req)  ");
				$stmt2->execute(array(time(), $this->userid, $this->userid, $number_bill, 1, $id));

				if ($stmt2->rowCount() > 0) {

					$stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill` = ? ");
					$stmtt->execute(array( $number_bill));
					$newData = array();
					while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
						$newData[] = $rowt;
					}

					$trace = new trace();
					$trace->addtrace('cart_shop_active', 'محاسبة', json_encode($oldData), json_encode($newData), ' محاسبة طلب',$number_bill);


					$xstmt = $this->db->prepare("SELECT *FROM `bill` WHERE  `id_member_r` = ? AND number_bill=? AND `userid_accountant`=? ");
					$xstmt->execute(array($id, $number_bill,$this->userid));
					if ($xstmt->rowCount() > 0) {
						$stmt = $this->db->prepare("UPDATE  `bill` SET `sum_bill`=sum_bill+?  WHERE  `id_member_r` = ? AND number_bill=?  AND `userid_accountant`=? ");
						$stmt->execute(array($sum, $id, $number_bill,$this->userid));

					} else {
						$stmt = $this->db->prepare("INSERT INTO `bill` (`userid_accountant`,`id_member_r`,`number_bill`,`sum_bill`,`date`) values (?,?,?,?,?)");
						$stmt->execute(array($this->userid, $id, $number_bill, $sum, time()));
					}


					$stmt_total = $this->db->prepare("SELECT *FROM `total_accountants` WHERE  `id_account` = ?  ");
					$stmt_total->execute(array($this->userid));
					if ($stmt_total->rowCount() > 0) {
						$stmt_t = $this->db->prepare("UPDATE  `total_accountants` SET `bill_sale`=bill_sale + {$sum},number_bill=number_bill+1 ,`userId`=?, `date`=? WHERE  `id_account` = ?   ");
                        $stmt_t->execute(array($this->userid,time(),$this->userid));

					} else {
                        $stmt_t = $this->db->prepare("INSERT INTO `total_accountants` (`username`,`id_account`,`number_bill`,`bill_sale`,`userId`,`date`) values (?,?,?,?,?,?)");
                        $stmt_t->execute(array(Session::get('usernamelogin'),$this->userid, 1,$sum,$this->userid, time()));
					}

                    $stmtPrint = $this->db->prepare("SELECT * FROM `cart_shop_active` WHERE  direct=2  AND  `accountant` = 1 AND `number_bill` = ? AND  id_member_r=? GROUP BY `id_member_r`,number_bill  ");
                    $stmtPrint->execute(array($number_bill,$id));
                    if ($stmtPrint->rowCount() > 0)
                    {
                        echo  2;  /*  بدون طباعة بعد المحاسبة لان يطبع تلقائي */
                    }else{
                        echo 1; /*  ما يطبع تلقايئ يطبع بعد المحاسبة */
                    }

					 //هاي الداله اسوي تجهيز مباشر اذا الماده خدميه
                    // $this->tajhez_service_material($id,$number_bill);


				} else {
					echo 0;
				}
			}else{
				echo 'accounted';
			}

		}else{
			echo 'login';
		}
	}



// 	public function tajhez_service_material($id,$number_bill)
//     {

//         $stmtCh_acco = $this->db->prepare("SELECT `id_item`,`code`,`table` FROM `cart_shop` WHERE id_member_r=? AND  `number_bill`=?  AND `accountant`=1  ");
//         $stmtCh_acco->execute(array($id,$number_bill));
//         if($stmtCh_acco->rowCount()>0){

//             while ($rowt = $stmtCh_acco->fetch(PDO::FETCH_ASSOC)) {

//                 $stmt = $this->db->prepare("SELECT `is_service` FROM `{$rowt['table']}` WHERE id=? AND `is_service` = 1");
// 		        $stmt->execute(array($rowt['id_item'] ));
//                 if($stmt->rowCount()>0){
//                     $stmt2 = $this->db->prepare("UPDATE `cart_shop` SET  `user_direct`=?, `done_direct` = 1,`buy` = 2 , `prepared` = 2 , `date_prepared`= ?   WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=? AND `number_bill` = ? AND `accountant`=1 ");
//                     $stmt2->execute(array($this->userid,time(), $rowt['code'] , $id , $rowt['table'] , $rowt['id_item'] , $number_bill));

//                     $trace = new trace();
//                     $trace->addtrace('cart_shop', 'تجهيز الطلب من قبل المحاسب لانه ماده خدميه ' . $number_bill,null, null, '  تجهيز الطلب من قبل المحاسب لانه ماده خدميه ',$number_bill);
//                 }
//             }
//         }

//     }



    function sunBill($id,$n_bill)
    {


        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }

        $number_bill =$n_bill;

        $price1_Offer=0;
        $price1_normal=0;
        $xp1Offer=0;
        $stmtOffer = $this->db->prepare("SELECT  offers,price,id_offer FROM `cart_shop_active` WHERE `id_member_r` =? AND `number_bill`=?  AND `accountant`=0  AND id_offer <> 0 AND offers = 'offers' GROUP BY  `date_offer`    ");
        $stmtOffer->execute(array($id, $number_bill));
        if ($stmtOffer -> rowCount() > 0) {
            while ($row = $stmtOffer->fetch(PDO::FETCH_ASSOC)) {
                if ($row['offers'] == 'offers') {
                    $row['price'] = $this->priceDollarOffer($row['id_offer'], 4) . ' د.ع ';
                    $price1_Offer = $price1_Offer + (int)str_replace($this->comma, '', $this->priceDollarOffer($row['id_offer'], 4));
                }
            }
        }

        $stmtNotOffer = $this->db->prepare("SELECT  price_dollars,dollar_exchange,price,`number`,SUM(number) as number FROM `cart_shop_active` WHERE `id_member_r` =? AND `number_bill`=? AND    `accountant`=0   AND id_offer = 0  AND offers = ''  GROUP BY  `id_item`,`table`,`code`,`color`,`number_bill`,price_type     ");
        $stmtNotOffer->execute(array($id,$number_bill));
        if ($stmtNotOffer -> rowCount() > 0) {
            while ($row = $stmtNotOffer->fetch(PDO::FETCH_ASSOC)) {

                $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
                $row['price'] = $price;

                // تحقق من سعر الدولار مفعل للبطاقة او  تم تعليقها لان النظام بطئ

//            if ($this->check_item_round($row['table'],$row['id_item'])) {
//            }else
//            {
//                $price = $this->not_round_price($row['price_dollars'], $row['dollar_exchange']);
//                $row['price']= $price;
//            }

                $f1 = (int)trim(str_replace($this->comma, '', $price));
                $xp1Offer = $xp1Offer + ($f1 * $row['number']);
                $price1_normal = ($xp1Offer);

            }
        }

        $price1Offer=0;
        $price1Offer=(int)str_replace($this->comma,'',$price1_Offer)+(int)str_replace($this->comma,'',$price1_normal);
        return number_format($price1Offer);
    }





    function check_number_bill()
    {

        $number_bill = trim(strip_tags($_GET['number_bill']));
        $stmt_ch = $this->db->prepare("SELECT COUNT(a) as num_bill FROM (select COUNT(id_member_r) as a FROM cart_shop_active WHERE number_bill =? AND accountant=0      GROUP BY id_member_r,number_bill) as t;");
        $stmt_ch->execute(array($number_bill));
        $rult = $stmt_ch->fetch(PDO::FETCH_ASSOC);
        if ($rult['num_bill'] > 1) {

            $html='';
            $stmt_custom = $this->db->prepare("SELECT  cart_shop_active.id_member_r,register_user.name FROM `cart_shop_active` INNER JOIN register_user ON register_user.id =cart_shop_active.id_member_r WHERE  cart_shop_active.number_bill = ? AND  cart_shop_active.accountant=0    GROUP BY cart_shop_active.id_member_r ");
            $stmt_custom->execute(array($number_bill));
            if ($stmt_custom->rowCount() > 0) {

                while ($row = $stmt_custom->fetch(PDO::FETCH_ASSOC))
                {

                    $html.="<div class='custom-control custom-radio custom-control-inline'>
                      <input type='radio' value='{$row['id_member_r']}'    id='customRadioInline-{$row['id_member_r']}' name='id_custom' class='custom-control-input name_select' required>
                      <label class='custom-control-label' for='customRadioInline-{$row['id_member_r']}'>{$row['name']}</label>
                    </div>";
                }
            }

            echo $html;
        }
    }

	function pay_bill()
	{
		if ($this->handleLogin()) {

            $this->checkPermit('processing_request', 'accountant');

            $number_bill = trim(strip_tags($_GET['number_bill']));


            $id=null;
            if (isset($_GET['id_custom']))
            {
                $id=$_GET['id_custom'];
            }


            if ($id)
            {
                $stmtChAcco = $this->db->prepare("SELECT *FROM  `cart_shop_active`  WHERE `number_bill` =? AND `id_member_r`=? AND accountant=0 AND   `buy` = 1  AND cancel=0    ");
                $stmtChAcco->execute(array($number_bill,$id));

            }else
            {
                $stmtChAcco = $this->db->prepare("SELECT *FROM  `cart_shop_active`  WHERE `number_bill` =?  AND  accountant=0 AND   `buy` = 1  AND cancel=0    ");
                $stmtChAcco->execute(array($number_bill));

            }



                if ($stmtChAcco->rowCount() > 0) {


                    $result = $stmtChAcco->fetch(PDO::FETCH_ASSOC);
                    $id = $result['id_member_r'];
                    $stmt = $this->getAllContentFromCar_number_bill($id, $number_bill);

                    $price1 = 0;
                    $xp1 = 0;
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


                    $sum = (int)str_replace($this->comma, '', trim($price1));



                        $stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill` = ? AND id_member_r=?  AND `$id`");
                        $stmtt->execute(array($number_bill,$id));



                    $oldData = array();
                    while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
                        $oldData[] = $rowt;
                    }


                        $stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `status` = 1 ,  `accountant` = 1 , `prepared` = 1 , `date_accountant`= ? , `user_id`=?,`id_accountant_user`=?,`top`=0,auto_print=1  WHERE `number_bill` =? AND `buy` = ?  AND `id_member_r`=?    ");
                        $stmt2->execute(array(time(), $this->userid, $this->userid, $number_bill, 1, $id));


                    if ($stmt2->rowCount() > 0) {

                        $stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill` = ? AND id_member_r =?");
                        $stmtt->execute(array($number_bill,$id));
                        $newData = array();
                        while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
                            $newData[] = $rowt;
                        }

                        $trace = new trace();
                        $trace->addtrace('cart_shop_active', 'محاسبة', json_encode($oldData), json_encode($newData), ' محاسبة طلب', $number_bill);


                        $xstmt = $this->db->prepare("SELECT *FROM `bill` WHERE  `id_member_r` = ? AND number_bill=? AND `userid_accountant`=? ");
                        $xstmt->execute(array($id, $number_bill, $this->userid));
                        if ($xstmt->rowCount() > 0) {
                            $stmt = $this->db->prepare("UPDATE  `bill` SET `sum_bill`=sum_bill+?  WHERE  `id_member_r` = ? AND number_bill=?  AND `userid_accountant`=? ");
                            $stmt->execute(array($sum, $id, $number_bill, $this->userid));

                        } else {
                            $stmt = $this->db->prepare("INSERT INTO `bill` (`userid_accountant`,`id_member_r`,`number_bill`,`sum_bill`,`date`) values (?,?,?,?,?)");
                            $stmt->execute(array($this->userid, $id, $number_bill, $sum, time()));
                        }


                        $stmt_total = $this->db->prepare("SELECT *FROM `total_accountants` WHERE  `id_account` = ?  ");
                        $stmt_total->execute(array($this->userid));
                        if ($stmt_total->rowCount() > 0) {
                            $stmt_t = $this->db->prepare("UPDATE  `total_accountants` SET `bill_sale`=bill_sale + {$sum},number_bill=number_bill+1 ,`userId`=?, `date`=? WHERE  `id_account` = ?   ");
                            $stmt_t->execute(array($this->userid, time(), $this->userid));

                        } else {
                            $stmt_t = $this->db->prepare("INSERT INTO `total_accountants` (`username`,`id_account`,`number_bill`,`bill_sale`,`userId`,`date`) values (?,?,?,?,?,?)");
                            $stmt_t->execute(array(Session::get('usernamelogin'), $this->userid, 1, $sum, $this->userid, time()));
                        }


                        echo '1';

                    } else {
                        echo 'not_found_bill';
                    }
                } else {
                    echo 'not_found_bill';
                }
            }


        else{
                echo 'login';
            }

	}


	function action_minus($id,$number_bill)
	{
		$note=$_GET['note'];


		$stmtt=$this->db->prepare("SELECT *FROM `bill` WHERE `id_member_r` = ? AND number_bill=? ");
		$stmtt->execute(array($id,$number_bill));
		$oldData=array();
		while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
		{
			$oldData[]=$rowt;
		}
		$stmt_action=$this->db->prepare("SELECT *FROM `bill` WHERE `id_member_r` = ? AND number_bill=?  ");
		$stmt_action->execute(array($id,$number_bill));
		$result=$stmt_action->fetch(PDO::FETCH_ASSOC);
		  $allMoney_from_star=(int)trim(str_replace($this->comma,'',$this->billAcount_money_clipper($this->userid)));

		$money=(int)str_replace($this->comma, '', $result['minus_bill']);
		if ($money <= $allMoney_from_star && $allMoney_from_star !=0 ) {

			if ((int)str_replace($this->comma, '', $result['sum_bill']) < $money)
			{
				$sum=0;
            }else
			{
				$sum = (int)str_replace($this->comma, '', $result['sum_bill']) -  $money;
			}


            $stmt_total = $this->db->prepare("SELECT *FROM `total_accountants` WHERE  `id_account` = ?  ");
            $stmt_total->execute(array($this->userid));
            if ($stmt_total->rowCount() > 0) {
                $stmt_t = $this->db->prepare("UPDATE  `total_accountants` SET `minus_customer`=minus_customer + {$money}  ,`userId`=?, `date`=? WHERE  `id_account` = ?   ");
                $stmt_t->execute(array($this->userid,time(),$this->userid));

            } else {
                $stmt_t = $this->db->prepare("INSERT INTO `total_accountants` (`username`,`id_account`,`minus_customer`,`userId`,`date`) values (?,?,?,?,?)");
                $stmt_t->execute(array(Session::get('usernamelogin'),$this->userid,$money,$this->userid, time()));
            }



            $stmt = $this->db->prepare("UPDATE  `bill` SET `minus`=2 ,`note`=? ,sum_bill=?,minus_bill=0 WHERE  `id_member_r` = ? AND number_bill=? AND `minus` = 1  ");
			$stmt->execute(array($note, $sum, $id, $number_bill));
			if ($stmt->rowCount() > 0) {



				if ($result['userid_accountant'] != $this->userid)
				{
					$stmt_minus = $this->db->prepare("INSERT INTO `bill_minus` (`id_account`,`money`,`number_bill`,`date`) values (?,?,?,?)");
					$stmt_minus->execute(array($this->userid, $money, $number_bill, time()));
				}


				$stmtx = $this->db->prepare("UPDATE  `bill` SET `minus`=2  ,minus_bill=0 WHERE  `id_member_r` = ? AND number_bill=?  ");
				$stmtx->execute(array( $id, $number_bill));


				$stmtt = $this->db->prepare("SELECT *FROM `bill` WHERE `id_member_r` = ? AND number_bill=?  ");
				$stmtt->execute(array($id, $number_bill));
				$newData = array();
				while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
					$newData[] = $rowt;
				}

				$trace = new trace();
				$trace->addtrace('bill', ' المحاسب-استرجاع باقي المبلغ الى الزبون - رقم الفاتورة' . $number_bill, json_encode($oldData), json_encode($newData), 'المحاسب - استرجاع باقي المبلغ للزبون بسبب استرجاع مادة من الطلب او تبدلها بخرى اقل سعر');


				$stmtx = $this->db->prepare("UPDATE  `retrieve_item` SET `recovery`=1 ,`delete`=1,delete_user=? ,delete_date=?  WHERE  `id_customer` = ? AND number_bill=? AND `recovery` = 0 ");
				$stmtx->execute(array($this->userid,time(),$id, $number_bill));

				$stmt_ch0=$this->db->prepare("SELECT SUM(sum_bill) as sumbll FROM `bill` WHERE `id_member_r` = ? AND number_bill=? ");
				$stmt_ch0->execute(array($id,$number_bill));
				$r=$stmt_ch0->fetch(PDO::FETCH_ASSOC);
				$allSum=(int)str_replace($this->comma,'',$r);
				if ($allSum <= 0) {
					$this->clearBill($number_bill, 1);
				}

				echo 'true';
			}
		}else
		{
			echo '-1';
		}
	}




	public  function order2($id)
	{
		if (!is_numeric($id)) {$error=new Errors(); $error->index();}
		$this->checkPermit('details_client','accountant');

		$id_user = $id;
		$stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ?    LIMIT 1");
		$stmt->execute(array($id_user));
		$result = $stmt->fetch();

		$stmt=$this->db->prepare("SELECT *FROM `register_answer` WHERE `id_user`=?");
		$stmt->execute(array($id));
		$answer=$stmt->fetch(PDO::FETCH_ASSOC);




		$stmt_date_req_done=$this->getAllContentFromCar_details_client_done_groupByDate_req($id);
		$date_req_done=array();
		while ($row_d =$stmt_date_req_done->fetch(PDO::FETCH_ASSOC))
		{
			$row_d['sum']=0;
			$row_d[$row_d['number_bill']]=array();
			$stmtx=$this->getAllContentFromCar_details_client_done($id,$row_d['number_bill']);
			$sum=0;
			$number_bill=0;
			$date_req=array();
			$price1=0;
			$date=0;
			$xp1=0;
			while ($row = $stmtx->fetch(PDO::FETCH_ASSOC))
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


				$row_d['sum']=$price1;

				$table=$row['table'];
				$stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
				$stmt_get_item->execute(array($row['id_item']));
				$item = $stmt_get_item->fetch();

				$row['title']=$item['title'];
				$row['img']=$this->save_file.$row['image'];



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



                $stmtCheck=$this->db->prepare("SELECT id FROM review_item WHERE id_cart = ? ");
				$stmtCheck->execute(array($row['id']));
				if($stmtCheck->rowCount()> 0)
				{
					$row['review_item']=false;
				}else
				{
					$row['review_item']=true;
				}

				$row_d[$row_d['number_bill']][]=$row;
			}


			$date_req_done[]=$row_d;

		}


		require($this->render($this->folder, 'html', 'order2', 'php'));

	}



	function loadmore()
	{



		$limit = (intval($_GET['limit']) != 0) ? $_GET['limit'] : 10;
		$offset = (intval($_GET['offset']) != 0) ? $_GET['offset'] : 0;

		$toDate= time();
		$backDay=strtotime(date("Y-m-d", strtotime("-1 day")) .' 12:00:00 am');
		$toTime= strtotime(date('Y-m-d').' '.$this->setting->get('hour').':05:60 am');

		if (   time() >= strtotime(date('Y-m-d').' 12:00:00 am')  &&  time()  < $toTime && $this->setting->get('hour') !=0 )
		{
			$stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE    `accountant` = 1     AND date_accountant between ? AND  ? GROUP BY `id_member_r`   LIMIT $limit OFFSET $offset");
			$stmt->execute(array($backDay,$toDate));
		}else
		{    	 
			$stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE    `accountant` = 1     AND date_accountant between ? AND  ? GROUP BY `id_member_r`   LIMIT $limit OFFSET $offset");
			$stmt->execute(array($toTime,$toDate));
		}


		$count_active='';
		while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$stmt_user = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ? ");
			$stmt_user->execute(array($row['id_member_r']));

			while ($row_user =$stmt_user->fetch(PDO::FETCH_ASSOC))
			{
				if ($this->permit('number_phone_show',$this->folder)) {
					$phone=$row_user['phone'];
				}else
				{
					$phone=substr($row_user['phone'], 0, 3) . "*****" . substr($row_user['phone'], 8);
				}

				if ($row['direct']==3)
				{
					$count_active.="
                <a class='infoCustomer ifactive direct_bill' id='row{$row_user['id']}' href='#' onclick='getOrder({$row_user['id']})'>
                       
                           <div class='row align-items-center justify-content-between'> 
							 <div class='col'>
							        <div>{$row_user['name']}  ({$row['number_bill']})  </div>
                                   <div   style='direction: ltr;' >{$phone}</div>
								</div>
								<div class='col-auto'>
									<div class='user_account'>   {$this->UserInfo($row['id_accountant_user'])} </div>
								  </div>
							 </div>
                     
                         <div class='direct_user_name'>المحاسب الثانوي:{$this->UserInfo($row['user_direct'])}</div>
                    </a>
                                  
                ";
				}else{
					$count_active.="
                <a class='infoCustomer ifactive' id='row{$row_user['id']}' href='#' onclick='getOrder({$row_user['id']})'>
                     <div class='row align-items-center justify-content-between'> 
                     <div class='col'>
                         <div>{$row_user['name']}  ({$row['number_bill']})  </div>
                        <div   style='direction: ltr;' >{$phone}</div>
                        </div>
                        <div class='col-auto'>
                            <div class='user_account'>    {$this->UserInfo($row['id_accountant_user'])} </div>
                          </div>
                     </div>
                    
                        
                        
                    </a>
                                    
                ";
				}

			}

		}

		echo  $count_active;




	}





	public function getAllContentFromCar_details_client_done_groupByDate_req($id_member_r)
	{
		$stmt = $this->db->prepare("SELECT  `date_req`,`date_d_r`,`id_member_r`,`delivery_user`,`number_bill` ,`dollar_exchange`,`date_accountant`,`id_accountant_user` FROM `cart_shop_active` WHERE `id_member_r` =?  AND  `accountant`=1  GROUP BY `number_bill`   ORDER BY `date_accountant` DESC ");

		$stmt->execute(array($id_member_r));
		return $stmt;
	}


	public function getAllContentFromCar_details_client_done($id_member_r,$number_bill)
	{
		$stmt = $this->db->prepare("SELECT  cart_shop_active.*,SUM(`number`)as number FROM `cart_shop_active` WHERE `id_member_r` =?  AND   `accountant` = 1     AND `number_bill`= ? GROUP BY `id_item`,`table`,`code`,`number_bill`,price_type,id_offer  ORDER BY `id` DESC  ");
		$stmt->execute(array($id_member_r,$number_bill));
		return $stmt;
	}


	public function getAllContentFromCar_details_client_reject_groupByDate_req($id_member_r)
	{
		$stmt = $this->db->prepare("SELECT  `date_req` ,`why_rejected`,`date_d_r`  FROM `{$this->cart_shop_active}` WHERE `id_member_r` =?  AND   `buy` = 3 AND `status` =2  GROUP BY `date_d_r`  ORDER BY `date_req` DESC ");
		$stmt->execute(array($id_member_r));
		return $stmt;
	}

	public function getAllContentFromCar_details_client_reject($id_member_r,$date_d_r)
	{
		$stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx` FROM `{$this->cart_shop_active}` WHERE `id_member_r` =?  AND   `buy` = 3 AND `status` =2 AND `date_d_r`= ?  GROUP BY `id_item`,`table`,`code`,`date_d_r` ORDER BY `id` DESC  ");
		$stmt->execute(array($id_member_r,$date_d_r));
		return $stmt;
	}



	function get() // add product for customer by admin
	{
		if ($this->handleLogin()) {
			$this->checkPermit('add_to_order', $this->folder);

			$code = strip_tags(trim($_POST['code']));
			$cat = strip_tags(trim($_POST['cat']));

			$device=array();


			if ($cat =='mobile')
			{


				$stmtCode_mobile=$this->db->prepare("SELECT *FROM `excel` WHERE `code`=?");
				$stmtCode_mobile->execute(array($code));
				if ($stmtCode_mobile->rowCount() > 0 )
				{
					$result=$stmtCode_mobile->fetch(PDO::FETCH_ASSOC);


					$device[0]['quantity']=$result['quantity'];
					$device[0]['price']=$result['price'];



					$stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1  AND `status` =0    AND `table`='mobile' ");
					$stmt_order->execute(array($result['code']));
					$only_order=$stmt_order->fetch(PDO::FETCH_ASSOC);
					$device[0]['order']=$only_order['num'];


					$stmt_cd = $this->db->prepare("SELECT *  FROM `code` WHERE `code` =?  ");
					$stmt_cd->execute(array($result['code']));
					$id_color=$stmt_cd->fetch(PDO::FETCH_ASSOC);
					$device[0]['size'] = $id_color['size'];

					$stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`color`  FROM `color` WHERE `id` =?  ");
					$stmt_img->execute(array($id_color['id_color']));
					$img_div=$stmt_img->fetch(PDO::FETCH_ASSOC);
					$device[0]['img']=$this->save_file.$img_div['img'];
					$device[0]['image']=$img_div['img'];
					$device[0]['color']=$img_div['code_color'];
					$device[0]['name_color'] = $img_div['color'];


					$stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `mobile` WHERE `id` =?    ");
					$stmt_name_device->execute(array($img_div['id_item']));
					$name_device=$stmt_name_device->fetch(PDO::FETCH_ASSOC);
					$device[0]['name'] = $name_device['title'];
					$device[0]['id'] = $name_device['id'];

					$stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_mobile` WHERE `id` =?    ");
					$stmt_name_cat->execute(array($name_device['id_cat']));
					$name_cate=$stmt_name_cat->fetch(PDO::FETCH_ASSOC);
					$device[0]['category']=$this->langControl('mobile'). '  /  ' .$name_cate['title'];


				}
			}


			if ($cat =='camera') {
				$stmtCode_camera = $this->db->prepare("SELECT * FROM `excel_camera` WHERE `code`=?");
				$stmtCode_camera->execute(array($code));
				if ($stmtCode_camera->rowCount() > 0) {
					$result = $stmtCode_camera->fetch(PDO::FETCH_ASSOC);

					$device[0]['quantity'] = $result['quantity'];
					$device[0]['price'] = $result['price'];



					$stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='camera' ");
					$stmt_order->execute(array($result['code']));
					$only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
					$device[0]['order'] = $only_order['num'];



					$stmt_cd = $this->db->prepare("SELECT  * FROM `code_camera` WHERE `code` =?  ");
					$stmt_cd->execute(array($result['code']));
					$id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);
					$device[0]['size'] = $id_color['size'];

					$stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color ,`color` FROM `color_camera` WHERE `id` =?  ");
					$stmt_img->execute(array($id_color['id_color']));
					$img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
					$device[0]['img'] = $this->save_file . $img_div['img'];
					$device[0]['image']=$img_div['img'];
					$device[0]['color'] = $img_div['code_color'];
					$device[0]['name_color'] = $img_div['color'];

					$stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `camera` WHERE `id` =?    ");
					$stmt_name_device->execute(array($img_div['id_item']));
					$name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
					$device[0]['name'] = $name_device['title'];
					$device[0]['id'] = $name_device['id'];

					$stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_camera` WHERE `id` =?    ");
					$stmt_name_cat->execute(array($name_device['id_cat']));
					$name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
					$device[0]['category'] = $this->langControl('camera') . '  /  ' . $name_cate['title'];


				}

			}


			if ($cat =='printing_supplies') {
				$stmtCode_printing_supplies = $this->db->prepare("SELECT * FROM `excel_printing_supplies` WHERE `code`=?");
				$stmtCode_printing_supplies->execute(array($code));
				if ($stmtCode_printing_supplies->rowCount() > 0) {
					$result = $stmtCode_printing_supplies->fetch(PDO::FETCH_ASSOC);

					$device[0]['quantity'] = $result['quantity'];
					$device[0]['price'] = $result['price'];



					$stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='printing_supplies' ");
					$stmt_order->execute(array($result['code']));
					$only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
					$device[0]['order'] = $only_order['num'];



					$stmt_cd = $this->db->prepare("SELECT  * FROM `code_printing_supplies` WHERE `code` =?  ");
					$stmt_cd->execute(array($result['code']));
					$id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);
					$device[0]['size'] = $id_color['size'];

					$stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color ,`color` FROM `color_printing_supplies` WHERE `id` =?  ");
					$stmt_img->execute(array($id_color['id_color']));
					$img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
					$device[0]['img'] = $this->save_file . $img_div['img'];
					$device[0]['image']=$img_div['img'];
					$device[0]['color'] = $img_div['code_color'];
					$device[0]['name_color'] = $img_div['color'];

					$stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `printing_supplies` WHERE `id` =?    ");
					$stmt_name_device->execute(array($img_div['id_item']));
					$name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
					$device[0]['name'] = $name_device['title'];
					$device[0]['id'] = $name_device['id'];

					$stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_printing_supplies` WHERE `id` =?    ");
					$stmt_name_cat->execute(array($name_device['id_cat']));
					$name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
					$device[0]['category'] = $this->langControl('printing_supplies') . '  /  ' . $name_cate['title'];


				}

			}

			if ($cat =='computer') {
				$stmtCode_computer = $this->db->prepare("SELECT * FROM `excel_computer` WHERE `code`=?");
				$stmtCode_computer->execute(array($code));
				if ($stmtCode_computer->rowCount() > 0) {
					$result = $stmtCode_computer->fetch(PDO::FETCH_ASSOC);

					$device[0]['quantity'] = $result['quantity'];
					$device[0]['price'] = $result['price'];



					$stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='computer' ");
					$stmt_order->execute(array($result['code']));
					$only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
					$device[0]['order'] = $only_order['num'];



					$stmt_cd = $this->db->prepare("SELECT  * FROM `code_computer` WHERE `code` =?  ");
					$stmt_cd->execute(array($result['code']));
					$id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);
					$device[0]['size'] = $id_color['size'];

					$stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color ,`color` FROM `color_computer` WHERE `id` =?  ");
					$stmt_img->execute(array($id_color['id_color']));
					$img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
					$device[0]['img'] = $this->save_file . $img_div['img'];
					$device[0]['image']=$img_div['img'];
					$device[0]['color'] = $img_div['code_color'];
					$device[0]['name_color'] = $img_div['color'];

					$stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `computer` WHERE `id` =?    ");
					$stmt_name_device->execute(array($img_div['id_item']));
					$name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
					$device[0]['name'] = $name_device['title'];
					$device[0]['id'] = $name_device['id'];

					$stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_computer` WHERE `id` =?    ");
					$stmt_name_cat->execute(array($name_device['id_cat']));
					$name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
					$device[0]['category'] = $this->langControl('computer') . '  /  ' . $name_cate['title'];


				}

			}
			if ($cat =='games') {
				$stmtCode_games = $this->db->prepare("SELECT *FROM `excel_games` WHERE `code`=?");
				$stmtCode_games->execute(array($code));
				if ($stmtCode_games->rowCount() > 0) {
					$result = $stmtCode_games->fetch(PDO::FETCH_ASSOC);

					$device[0]['quantity'] = $result['quantity'];
					$device[0]['price'] = $result['price'];



					$stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1  AND `status` =0  AND `table`='games' ");
					$stmt_order->execute(array($result['code']));
					$only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
					$device[0]['order'] = $only_order['num'];



					$stmt_cd = $this->db->prepare("SELECT *  FROM `code_games` WHERE `code` =?  ");
					$stmt_cd->execute(array($result['code']));
					$id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);
					$device[0]['size'] = $id_color['size'];

					$stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`color`  FROM `color_games` WHERE `id` =?  ");
					$stmt_img->execute(array($id_color['id_color']));
					$img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
					$device[0]['img'] = $this->save_file . $img_div['img'];
					$device[0]['image']=$img_div['img'];
					$device[0]['color'] = $img_div['code_color'];
					$device[0]['name_color'] = $img_div['color'];

					$stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `games` WHERE `id` =?    ");
					$stmt_name_device->execute(array($img_div['id_item']));
					$name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
					$device[0]['name'] = $name_device['title'];
					$device[0]['id'] = $name_device['id'];

					$stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_games` WHERE `id` =?    ");
					$stmt_name_cat->execute(array($name_device['id_cat']));
					$name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
					$device[0]['category'] = $this->langControl('games') . '  /  ' . $name_cate['title'];


				}


			}

			if ($cat =='network') {
				$stmtCode_network = $this->db->prepare("SELECT *FROM `excel_network` WHERE `code`=?");
				$stmtCode_network->execute(array($code));
				if ($stmtCode_network->rowCount() > 0) {
					$result = $stmtCode_network->fetch(PDO::FETCH_ASSOC);

					$device[0]['quantity'] = $result['quantity'];
					$device[0]['price'] = $result['price'];


					$stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0   AND `table`='network' ");
					$stmt_order->execute(array($result['code']));
					$only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
					$device[0]['order'] = $only_order['num'];



					$stmt_cd = $this->db->prepare("SELECT  * FROM `code_network` WHERE `code` =?  ");
					$stmt_cd->execute(array($result['code']));
					$id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);
					$device[0]['size'] = $id_color['size'];

					$stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`color`  FROM `color_network` WHERE `id` =?  ");
					$stmt_img->execute(array($id_color['id_color']));
					$img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
					$device[0]['img'] = $this->save_file . $img_div['img'];
					$device[0]['image']=$img_div['img'];
					$device[0]['color'] = $img_div['code_color'];
					$device[0]['name_color'] = $img_div['color'];

					$stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `network` WHERE `id` =?    ");
					$stmt_name_device->execute(array($img_div['id_item']));
					$name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
					$device[0]['name'] = $name_device['title'];
					$device[0]['id'] = $name_device['id'];


					$stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_network` WHERE `id` =?    ");
					$stmt_name_cat->execute(array($name_device['id_cat']));
					$name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
					$device[0]['category'] = $this->langControl('network') . '  /  ' . $name_cate['title'];


				}

			}
			if ($cat =='accessories') {

				$stmtCode_accessories = $this->db->prepare("SELECT *FROM `excel_accessories` WHERE `code`=?");
				$stmtCode_accessories->execute(array($code));
				if ($stmtCode_accessories->rowCount() > 0) {
					$result = $stmtCode_accessories->fetch(PDO::FETCH_ASSOC);

					$device[0]['quantity'] = $result['quantity'];
					$device[0]['price'] = $result['price'];



					$stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='accessories' ");
					$stmt_order->execute(array($result['code']));
					$only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
					$device[0]['order'] = $only_order['num'];




					$stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`color`  FROM `color_accessories` WHERE `code` =?  ");
					$stmt_img->execute(array($result['code']));
					$img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
					$device[0]['img'] = $this->save_file . $img_div['img'];
					$device[0]['image']=$img_div['img'];
					$device[0]['color'] = $img_div['code_color'];
					$device[0]['name_color'] = $img_div['color'];
					$device[0]['size'] = '';

					$stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `accessories` WHERE `id` =?    ");
					$stmt_name_device->execute(array($img_div['id_item']));
					$name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
					$device[0]['name'] = $name_device['title'];
					$device[0]['id'] = $name_device['id'];

					$stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_accessories` WHERE `id` =?    ");
					$stmt_name_cat->execute(array($name_device['id_cat']));
					$name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
					$device[0]['category'] = $this->langControl('accessories') . '  /  ' . $name_cate['title'];


				}


			}

			if ($cat =='savers')
			{
				$color = strip_tags(trim($_POST['color']));


				$stmtCode_network = $this->db->prepare("SELECT *FROM `excel_savers` WHERE `code`=? AND `color`=? ");
				$stmtCode_network->execute(array($code,$color));
				if ($stmtCode_network->rowCount() > 0) {
					$result = $stmtCode_network->fetch(PDO::FETCH_ASSOC);

					$device[0]['quantity'] = $result['quantity'];
					$device[0]['price'] = $result['price'];


					$stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `name_color` =?  AND `buy` = 1 AND `status` =0   AND `table`='product_savers' ");
					$stmt_order->execute(array($result['code'],$color));
					$only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
					$device[0]['order'] = $only_order['num'];
					$device[0]['size'] = '';



					$stmt_color = $this->db->prepare("SELECT  * FROM `product_color`  WHERE `color` =?   LIMIT 1");
					$stmt_color->execute(array($color));
					$colorx = $stmt_color->fetch(PDO::FETCH_ASSOC);
					$device[0]['color'] = $colorx['code_color'];
					$device[0]['name_color'] = $colorx['color'];
					$device[0]['img'] = $this->save_file . $colorx['img'];
					$device[0]['image']=$colorx['img'];


					$stmt_name = $this->db->prepare("SELECT  `id`,`title`  FROM `product_savers` WHERE `id` =?  AND `code` =?");
					$stmt_name->execute(array($colorx['id_product'],$result['code']));
					$name_device = $stmt_name->fetch(PDO::FETCH_ASSOC);
					$device[0]['name'] = $name_device['title'];
					$device[0]['id'] = $name_device['id'];

					$device[0]['category'] = $this->langControl('savers') ;

				}

			}


			require($this->render($this->folder, 'code', 'data', 'php'));


		}
	}




	function processing_request_rejected($id,$number_bill)
	{
		if (!is_numeric($id)) {$error=new Errors(); $error->index();}
		if ($this->handleLogin()) {


			$why_rej = $_GET['why_rej'];


			$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill` =? AND `id_member_r` =? ");
			$stmtt->execute(array($number_bill,$id));
			$oldData=array();
			while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
			{
				$oldData[]=$rowt;
			}

			


			$stmt = $this->db->prepare("UPDATE `cart_shop_active` SET `cancel` = 1  ,`status` = 2  , `buy` = 3, `why_rejected` = ?  , `date_d_r`= ? , `user_id`=?,`id_accountant_user`=?  WHERE  `buy` = ? AND `id_member_r`=? AND `number_bill`=? AND accountant = 0");
			$stmt->execute(array($why_rej, time(), $this->userid,$this->userid, 1, $id,$number_bill));
			if ($stmt->rowCount() > 0) {
            	
            	$stmt_c = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`dollar_exchange` FROM `cart_shop_active` WHERE `id_member_r` =?  AND  `number_bill` =?    GROUP BY `id_item`,`table`,`code` ,`id_member_r`   ");
            	$stmt_c->execute(array($id,$number_bill));
            	while ($row = $stmt_c->fetch(PDO::FETCH_ASSOC)) {
                	$table=$row['table'] ;
                	if ($table == 'mobile') {
                    	$excel = 'excel';
                	}  else   if ($table == 'product_savers') {
                    	$table='savers';
                    	$excel = 'excel_savers';
                	} else {
                    	$excel = 'excel_' . $table;
                	}
                	$number = $row['number'];
                	$stmt = $this->db->prepare("UPDATE  `{$excel}` SET `quantity`=`quantity` +  {$number} WHERE  `code`=?  ");
                	$stmt->execute(array($row['code']));

            	}
				echo 1;
			} else {
				echo 0;
			}

			$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=?  ");
			$stmtt->execute(array( $number_bill));
			$newData=array();
			while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
			{
				$newData[]=$rowt;
			}

			$trace = new trace(); $trace->addtrace('cart_shop_active','محاسبة',json_encode($oldData),json_encode($newData),$this->userid . 'الغاء طلب ',$number_bill);

            $this->AddToTraceByFunction($this->userid,'accountant','processing_request_rejected/'.$id.'/'.$number_bill.'/'.$why_rej);

		}else{
			echo 'login';
		}
	}


	function sumAllMoney($id,$fromdate=null,$todate=null)
	{

		if (empty($fromdate) && empty($todate))
		{
			$fromdate = strtotime(date('Y-m-d', time()));
			$todate = strtotime('+1 day', $fromdate);
		}
		$sun=0;
		$stmt = $this->db->prepare("SELECT  SUM(`sum_bill`) as money    FROM `bill`  WHERE  userid_accountant=? AND  `date` BETWEEN ? AND  ? ");
		$stmt->execute(array($id,$fromdate,$todate));
		if ($stmt->rowCount() > 0) {
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$sun = $result['money'];
		}

		//$money_clipper=new money_clipper();
		//$sunAll=($money_clipper->addOrWithdrawMoney($id,0,$fromdate,$todate) + (int)$sun) - $money_clipper->addOrWithdrawMoney($id,1,$fromdate,$todate) ;
		return number_format($sun);

	}


//    dayle
	function billAcount($id)
	{

		$fromdate = strtotime(date('Y-m-d', time()));
		$todate = strtotime('+1 day', $fromdate);

		$stmt =$this->db->prepare("SELECT  SUM(sum_bill)  as sum FROM  `bill` WHERE  `userid_accountant`  = ? AND date between ? AND  ?");
		$stmt->execute(array($id,$fromdate,$todate));
		$SumPrice=$stmt->fetch(PDO::FETCH_ASSOC);

//		$money_clipper=new money_clipper();
//
//        $sun=( $money_clipper->addOrWithdrawMoney($id,0,$fromdate,$todate) + (int)$SumPrice['sum']) - $money_clipper->addOrWithdrawMoney($id,1,$fromdate,$todate) ;
//


		return number_format((int)$SumPrice['sum']);


	}



	function bill_minus($id,$from_date=null,$to_date=null)
	{

		if ($from_date && $to_date)
		{

			$stmt_bill_minus =$this->db->prepare("SELECT  SUM(money)  as money FROM  `bill_minus` WHERE  `id_account`  = ? AND `date` between ? AND  ? ");
			$stmt_bill_minus->execute(array($id,strtotime($from_date),strtotime($to_date)));
			if ($stmt_bill_minus->rowCount()>0)
			{
				$Sum_bill_minus=$stmt_bill_minus->fetch(PDO::FETCH_ASSOC);
				return $Sum_bill_minus['money'];
			}else{
				return 0;
			}

		}else{
			$stmt_bill_minus =$this->db->prepare("SELECT  SUM(money)  as money FROM  `bill_minus` WHERE  `id_account`  = ? ");
			$stmt_bill_minus->execute(array($id));
			if ($stmt_bill_minus->rowCount()>0)
			{
				return $Sum_bill_minus=$stmt_bill_minus->fetch(PDO::FETCH_ASSOC)['money'];
			}else{
				return 0;
			}
		}


	}


//all day main account
	function billAcount_money_clipper($id)
	{


	    return $this->sum_account_main($id);
/*
		$stmt =$this->db->prepare("SELECT  SUM(sum_bill)  as sum FROM  `bill` WHERE  `userid_accountant`  = ? ");
		$stmt->execute(array($id));
		$SumPrice=$stmt->fetch(PDO::FETCH_ASSOC);

		$stmt_discount =$this->db->prepare("SELECT  SUM(money)  as mony FROM  `discount` WHERE  `to_id_user`  = ? ");
		$stmt_discount->execute(array($id));
		$Sum_discount=$stmt_discount->fetch(PDO::FETCH_ASSOC);

		$main_log_account=new main_log_accountant();
		$sumFromBillAndDiscount=($main_log_account->account_All_bill_Without_date($id)+(int)$Sum_discount['mony'])-((int)$this->bill_minus($id));


		$money_clipper=new money_clipper();

		$sun=( $money_clipper->addOrWithdrawMoneyAllDay($id,0) + $sumFromBillAndDiscount) - $money_clipper->addOrWithdrawMoneyAllDay($id,1) ;

		$rewind = 0;
		$stmt2 = $this->db->prepare("SELECT  SUM(`money`) as money    FROM `review` WHERE  id_accountant=? ");
		$stmt2->execute(array($id));
		if ($stmt2->rowCount() > 0) {
			$result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
			$rewind = $result2['money'];
		}

		  $purc=new purchase_customer();

		return number_format(((int)$sun-(int)$rewind)-(int)$purc->sumbillall($id));

*/
	}



	function  search()
	{
		if ($this->handleLogin())
		{


			$search = strip_tags(trim($_GET['value']));
			$q = '%' . $search . '%';
			$stmt = $this->db->prepare("SELECT register_user.id,register_user.name,register_user.phone,cart_shop_active.id_accountant_user,cart_shop_active.number_bill  FROM `register_user` inner join cart_shop_active on cart_shop_active.id_member_r=register_user.id WHERE ( register_user.name LIKE ? OR  register_user.phone LIKE ? ) AND  cart_shop_active.accountant =1  AND cart_shop_active.cancel=0  GROUP BY cart_shop_active.id_member_r order by cart_shop_active.number_bill DESC  LIMIT 15");
			$stmt->execute(array($q,$q));
			$data=array();
			$count_active='';
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{


				if ($this->permit('number_phone_show',$this->folder)) {
					$phone=$row['phone'];
				}else
				{
					$phone=substr($row['phone'], 0, 3) . "*****" . substr($row['phone'], 8);
				}

				$count_active.="
                <a class='infoCustomer ifactive' id='row{$row['id']}' href='#' onclick='getOrder({$row['id']})'>
                        
                    <div class='row align-items-center justify-content-between'> 
                     <div class='col'>
                         <div>{$row['name']}  ({$row['number_bill']})  </div>
                        <div   style='direction: ltr;' >{$phone}</div>
                        </div>
                        <div class='col-auto'>
                            <div class='user_account'>    {$this->UserInfo($row['id_accountant_user'])} </div>
                          </div>
                     </div>
                         
                         
                    </a>
                                   
                ";
			}

			echo  $count_active;


		}
	}


	function  search_new()
	{
		if ($this->handleLogin())
		{


			$search = strip_tags(trim($_GET['value']));
			$q = '%' . $search . '%';
			$stmt = $this->db->prepare("SELECT cart_shop_active.accountant,cart_shop_active.id_member_r, cart_shop_active.number_bill,cart_shop_active.top,cart_shop_active.date_req,cart_shop_active.direct,cart_shop_active.user_direct,register_user.id,register_user.name,register_user.phone  FROM `cart_shop_active` inner join register_user on register_user.id=cart_shop_active.id_member_r WHERE ( register_user.name LIKE ? OR  register_user.phone LIKE ? OR cart_shop_active.number_bill=?) AND  cart_shop_active.accountant =0   AND cart_shop_active.cancel=0 AND (`prepared`=1 or prepared=0) GROUP BY cart_shop_active.id_member_r  LIMIT 15");
			$stmt->execute(array($q,$q,trim($search)));
			$data=array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{


				if ($row['top']==1)
				{
					$row['top']=1;
				}else{
					$row['top']=0;
				}

				$row['sumbill']=$this->sunBill($row['id_member_r'],$row['number_bill']);
				$row['date_order']=date('Y-m-d h:i A',$row['date_req']);

				$row['user_direct']=$this->UserInfo($row['user_direct']);

				if ($row['accountant']==0)
				{
					$data[]=$row;

				}

			}
			require($this->render($this->folder, 'html', 'search', 'php'));

		}
	}


	function retrieve_item($data=array())
	{
		if($this->handleLogin())
		{
			$this->db->insert('retrieve_item',$data);
		}

	}





	public function rewind()
	{


		$this->checkPermit('retrieval','accountant');
		$this->adminHeaderController($this->langControl('retrieval'));
		$stmt = $this->db->prepare("SELECT *FROM `review` WHERE   `active` = 0 AND cancel=0  AND `hidden`=0  GROUP BY `id_customre`,`number_bill_new`");
		$stmt->execute();
		$rewind_active=array();
		while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$rewind_active[]=$row;

		}


		require($this->render($this->folder, 'html', 'rewind', 'php'));

		$this->adminFooterController();

	}


	public function rewind_done()
	{

		$this->checkPermit('rewind_done','accountant');
		$this->adminHeaderController($this->langControl('rewind_done'));



		require($this->render($this->folder, 'html', 'rewind_done', 'php'));
		$this->adminFooterController();
	}

    function cancel_rewind($id,$number_bill)
    {
        if ($this->handleLogin())
        {


            $stmtt=$this->db->prepare("SELECT *FROM `review_item` WHERE  `id_customre` = ? AND number_bill_new =?  AND `active`=0  ");
            $stmtt->execute(array($id,$number_bill));
            $newData=array();
            while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
            {
                $rowt['active']=1;
                $rowt['id_accountant']=$this->userid;
                $newData[]=$rowt;
            }

            $trace = new trace(); $trace->addtrace('review_item','الغاء المرتجع من قبل المحاسب',json_encode(array()),json_encode($newData),'  الغاء   المرتج - رقم فاتورة المرتجع الجديد '.$number_bill,$number_bill);


            $stmt = $this->db->prepare("UPDATE    `review` SET cancel=1 ,id_account_cancel=? , date_account_cancel=?  WHERE  id_customre=? AND number_bill_new=? AND `active` = 0   ");
            $stmt->execute(array($this->userid,time(),$id,$number_bill));


            $stmt2 = $this->db->prepare("UPDATE  `review_item` SET cancel=1,id_account_cancel=? , date_account_cancel=?  WHERE  id_customre=? AND number_bill_new=? AND `active` = 0 AND cancel=0 ");
            $stmt2->execute(array($this->userid,time(),$id,$number_bill));

            if ($stmt->rowCount() > 0 && $stmt2->rowCount() > 0)
            {
                echo 'true';
            }

        }

    }



    function delete_item_rewind($id_item,$id_customer)
	{
		$stmt = $this->db->prepare("SELECT *FROM `review_item` WHERE id = ?  AND id_customre =? ");
		$stmt->execute(array($id_item,$id_customer));
		if ($stmt->rowCount() > 0)
		{
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$money=(int)str_replace($this->comma,'',$result['price_new']);
			$stmtu = $this->db->prepare("UPDATE  `review` SET money=money-{$money} WHERE id = ?  AND id_customre =?  AND number_bill_new =?   ");
			$stmtu->execute(array($result['id_review'],$id_customer,$result['number_bill_new']));

            $trace = new trace(); $trace->addtrace('review_item','الغاء المرتجع من قبل المحاسب',json_encode(array($result)),json_encode(array()),'  الغاء   المرتج - رقم فاتورة المرتجع الجديد '.$result['number_bill_new'],$result['number_bill_new']);

            $stmtdi = $this->db->prepare("UPDATE   `review_item` SET cancel=1,id_account_cancel=?,date_account_cancel=?  WHERE id = ?  AND id_customre =? ");
			$stmtdi->execute(array($this->userid,time(),$id_item,$id_customer));
			if ($stmtdi->rowCount() > 0)
			{
                $result2 = $stmtdi->fetch(PDO::FETCH_ASSOC);

                $trace = new trace(); $trace->addtrace('review_item','الغاء المرتجع من قبل المحاسب',json_encode(array()),json_encode(array($result2)),'  الغاء   المرتج - رقم فاتورة المرتجع الجديد '.$result['number_bill_new'],$result['number_bill_new']);

                $stmtc = $this->db->prepare("SELECT *FROM `review_item` WHERE number_bill_new = ?  AND id_customre =? AND cancel=0");
				$stmtc->execute(array($result['number_bill_new'],$id_customer));
				if ($stmtc->rowCount() > 0)
				{
					echo 'true';
				}else
				{

					$stmtdr = $this->db->prepare("UPDATE   `review` SET cancel=1,id_account_cancel=?,date_account_cancel=? WHERE id = ?  AND id_customre =?  AND number_bill_new =? ");
					$stmtdr->execute(array($this->userid,time(),$result['id_review'],$id_customer,$result['number_bill_new']));
					if ($stmtdr->rowCount() > 0) {

						echo 'true0';
					}

				}


			}

		}
	}


	function view_rewind($id,$number_bill)
	{

		if ($this->handleLogin()) {

			$stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ?    LIMIT 1");
			$stmt->execute(array($id));
			$result = $stmt->fetch();

			$stmtr = $this->db->prepare("SELECT review_item.*,COUNT(id) as number FROM `review_item` WHERE   `id_customre` = ?   AND `number_bill_new`= ? AND `active`= 0  AND cancel=0 GROUP BY id_item,code,`table`");
            $stmtr->execute(array($id,$number_bill));
			$rewind_active = array();
			$price=0;
            $number_type=0;
            $sum_material=0;
			while ($row = $stmtr->fetch(PDO::FETCH_ASSOC)) {
				$price=$price+($row['price_new']*$row['number']);
				$row['username']=$this->UserInfo($row['id_prepared']);

				$row['now_price']=0;
                $number_bill=$row['number_bill_new'];
                $number_type=$number_type+1;
                $sum_material=$sum_material+$row['number'];



                if ($row['table'] =='mobile')
                {
                    $excel='excel';
                }else if  ($row['table'] == 'product_savers')
                {
                    $excel='excel_savers';
                }
                else
                {
                    $excel='excel_'.$row['table'];
                }


                $excelStmt=$this->db->prepare("SELECT *FROM {$excel} WHERE `code`=?");
                $excelStmt->execute(array($row['code']));
                if ($excelStmt->rowCount() > 0)
                {
                    $DPrice=$excelStmt->fetch(PDO::FETCH_ASSOC);
                    $row['now_price'] = $this->price_dollarsAdmin($DPrice['price_dollars']) . ' د.ع ';
                }else{
                    $row['now_price'] ='سعر المادة غير موجود في   الاكسل';
                }


				$rewind_active[] = $row;
			}


			require($this->render($this->folder, 'html', 'view_rewind', 'php'));
		}
	}



	function success_rewind()
	{



		if ($this->handleLogin()) {
			$id = $_GET['id'];
			$number_bill= $_GET['number_bill'];

			$account=new Accountant();
			$allMoney_from_star=(int)trim(str_replace($this->comma,'',$account->billAcount_money_clipper($this->userid)));

			$stmtSumMoneyReview = $this->db->prepare("SELECT SUM(price_new) as money FROM `review_item` WHERE   `id_customre` = ? AND number_bill_new=? AND `active`= 0 AND cancel=0");
			$stmtSumMoneyReview->execute(array($id,$number_bill));
			$resultSum = $stmtSumMoneyReview->fetch(PDO::FETCH_ASSOC);
			$sum=$resultSum['money'];

			if ($sum > $allMoney_from_star) {
				echo '-1';
			} else {

				$stmtR = $this->db->prepare("SELECT  *FROM `review`  WHERE   `id_customre` = ? AND number_bill_new=? AND `active`=0  AND cancel=0 ");
				$stmtR->execute(array( $id,$number_bill));
				$result=$stmtR->fetch(PDO::FETCH_ASSOC);

				$stmtx = $this->db->prepare("UPDATE   `review` SET `active`=1 , `id_accountant`= ? WHERE   `id_customre` = ? AND number_bill_new=? AND `active`=0  AND cancel=0 ");
				$stmtx->execute(array($this->userid, $id,$number_bill));

				if ($stmtx->rowCount() > 0) {


                    $stmt_total = $this->db->prepare("SELECT *FROM `total_accountants` WHERE  `id_account` = ?  ");
                    $stmt_total->execute(array($this->userid));
                    if ($stmt_total->rowCount() > 0) {
                        $stmt_t = $this->db->prepare("UPDATE  `total_accountants` SET review_to_customer=review_to_customer + {$sum},`userId`=?, `date`=? WHERE  `id_account` = ?   ");
                        $stmt_t->execute(array($this->userid,time(),$this->userid));

                    } else {
                        $stmt_t = $this->db->prepare("INSERT INTO `total_accountants` (`username`,`id_account`,`review_to_customer`,`userId`,`date`) values (?,?,?,?,?)");
                        $stmt_t->execute(array(Session::get('usernamelogin'),$this->userid, $sum,$this->userid, time()));
                    }

                    $stmtRb = $this->db->prepare("SELECT *FROM `review_item` WHERE   `id_customre` = ? AND number_bill_new=? AND `active`= 0  AND cancel=0 ");
					$stmtRb->execute(array($id,$number_bill));

					while ($row = $stmtRb->fetch(PDO::FETCH_ASSOC)) {

						$this->edit_bill($row['number_bill_old'], $this->userid);




                        if ($row['table'] == 'mobile')
                        {
                            $excel='excel';
                        }else
                        {

                            $excel='excel_'.$row['table'];
                        }


                        if ($row['table'] == 'product_savers') {
                            $tble='savers';
                            $excel='excel_'.$tble;
                        }else
                        {
                            $tble=$row['table'];
                        }





                        if ($row['serial'])
                        {


                                $stmtSERial = $this->db->prepare("INSERT INTO `serial` ( code, serial, type_enter, quantity, userId, `date`, model,note) VALUE (?,?,?,?,?,?,?,?) ");
                                $stmtSERial->execute(array( $row['code'],$row['serial'],$row['number_bill_new'].' فاتورة مرتجع ', 1,$this->userid, time(), $row['table'],$row['number_bill_new'].' فاتورة مرتجع  '));

                        }



                        $stmt = $this->db->prepare("UPDATE  `{$excel}` SET `quantity`=`quantity` + 1 WHERE  `code`=?  ");
                        $stmt->execute(array($row['code']));


                        if ($stmt->rowCount() > 0) {


                            $row['location']=rtrim(ltrim($row['location'],','),',');
                            if (!empty($row['location']))
                            {


                                $loc=explode(',',$row['location']);
                                foreach ($loc as $l)
                                {
                                    $l=trim($l);

                                    if ($l) {

                                        $stmt_ch_location = $this->db->prepare("SELECT *FROM  location  WHERE code =? AND  model=? AND location=?");
                                        $stmt_ch_location->execute(array($row['code'], $tble, $l));
                                        if ($stmt_ch_location->rowCount() > 0) {
                                            $stmtExcel_conform = $this->db->prepare("UPDATE location SET  quantity=quantity+1 ,userid=?,`date`=?  WHERE code =? AND  model=? AND location=?");
                                            $stmtExcel_conform->execute(array($this->userid,time(), $row['code'], $tble, $l));

                                            if($stmtExcel_conform->rowCount()  > 0)
                                            {
                                                 $this->filter_location_tracking_quantity( $row['code'],$tble,$l,1,'  المحاسب الرئيسي محاسبة فاتورة مرتجع   - رقم1','+',$number_bill);

                                            }else
                                            {
                                                $this->filter_location_error_quantity( $row['code'],$tble,$l,1,'  المحاسب الرئيسي محاسبة فاتورة مرتجع   - رقم الخطا 1','+',$number_bill);

                                            }





                                        } else {
                                            $stmtExcel_conform = $this->db->prepare("INSERT INTO location (quantity,`date`,code,model,location,userid) VALUES (?,?,?,?,?,?)");
                                            $stmtExcel_conform->execute(array(1, time(), $row['code'], $tble, $l, $this->userid));
                                            if($stmtExcel_conform->rowCount()  > 0)
                                            {
                                                $this->filter_location_tracking_quantity( $row['code'],$tble,$l,1,'  المحاسب الرئيسي محاسبة فاتورة مرتجع   - رقم2','+',$number_bill);

                                            }else
                                            {
                                                $this->filter_location_error_quantity( $row['code'],$tble,$l,1,'  المحاسب الرئيسي محاسبة فاتورة مرتجع   - رقم الخطا 2','+',$number_bill);

                                            }

                                        }

                                    }
                                }


                            }else{

                                $stmtChCodeConform = $this->db->prepare("SELECT *FROM location_confirm WHERE code =? AND model=?");
                                $stmtChCodeConform->execute(array($row['code'], $tble));
                                if ($stmtChCodeConform->rowCount() > 0) {
                                    $stmtExcel_conform = $this->db->prepare("UPDATE location_confirm SET  quantity=quantity+1 ,`date`=?  WHERE code =? AND  model=?");
                                    $stmtExcel_conform->execute(array(time(), $row['code'], $tble));

                                    if($stmtExcel_conform->rowCount() <=0)
                                    {
                                        $this->filter_error_quantity( $row['code'],$tble,1,'  المحاسب الرئيسي محاسبة فاتورة مرتجع   - رقم الخطا 5',$number_bill);
                                    }

                                } else {
                                $stmtExcel_conform = $this->db->prepare("INSERT INTO  location_confirm (quantity,code,model,`date`,userid)  values (?,?,?,?,?)");
                                $stmtExcel_conform->execute(array(1, $row['code'], $tble, time(),$this->userid));
                                    if($stmtExcel_conform->rowCount() <=0)
                                    {
                                        $this->filter_error_quantity( $row['code'],$tble,1,'  المحاسب الرئيسي محاسبة فاتورة مرتجع   - رقم الخطا 6',$number_bill);
                                    }
                                }
                            }


                        }

                    }


					$stmtt = $this->db->prepare("SELECT *FROM `review_item` WHERE  `id_customre` = ? AND number_bill_new=? AND `active`=0  AND cancel=0 ");
					$stmtt->execute(array($id,$number_bill));
					$newData = array();
					while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
						$rowt['active'] = 1;
						$rowt['id_accountant'] = $this->userid;
						$newData[] = $rowt;
					}

					$trace = new trace();
					$trace->addtrace('review_item', 'الموافقة على المرتجع من قبل المحاسب', json_encode(array()), json_encode($newData), '  الموافقة على المرتج - رقم فاتورة المرتجع   ' . $result['number_bill_new'], $result['number_bill_new']);


					$stmt2 = $this->db->prepare("UPDATE   `review_item` SET `active`=1 , `id_accountant`= ? WHERE    `id_customre` = ? AND number_bill_new=? AND `active`=0  AND cancel=0  ");
					$stmt2->execute(array($this->userid, $id,$number_bill));


					 echo '1';

				}else {
					echo '0';
				}

			}


            $this->AddToTraceByFunction($this->userid,'accountant','success_rewind/'.$id.'/'.$number_bill);


        }

	}


	function loadmore_view_rewind()
	{

		$limit = (intval($_GET['limit']) != 0) ? $_GET['limit'] : 10;
		$offset = (intval($_GET['offset']) != 0) ? $_GET['offset'] : 0;

		$stmt = $this->db->prepare("SELECT *FROM `review` WHERE    `active` = 1 AND `id_accountant`= ?  GROUP BY `id_customre` LIMIT $limit OFFSET $offset");
		$stmt->execute(array($this->userid));
		$count_active='';
		while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
		{

			if ($this->permit('number_phone_show',$this->folder)) {
				$phone=$row['phone'];
			}else
			{
				$phone=substr($row['phone'], 0, 3) . "*****" . substr($row['phone'], 8);
			}

			$count_active.="
                <a class='infoCustomer ifactive' id='row{$row['id_customre']}' href='#' onclick='getRewind({$row['id_customre']})'>
                        <div>{$row['name']}</div>
                        <div   style='direction: ltr;' >{$phone}</div>
                    </a>
                                   
                ";
		}

		echo  $count_active;


	}



	function view_rewind2($id)
	{


		if ($this->handleLogin()) {



			$stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ?    LIMIT 1");
			$stmt->execute(array($id));
			$result = $stmt->fetch();


			$stmt = $this->db->prepare("SELECT *FROM `review_item` WHERE   `id_customre` = ? AND `active`= 1 ORDER BY id DESC ");
			$stmt->execute(array($id));
			$rewind_active = array();
			$price=0;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$price=$price+$row['price_new'];
				$row['username']=$this->UserInfo($row['id_prepared']);
				$row['username_acc']=$this->UserInfo($row['id_accountant']);


				$row['now_price']=0;
				if ($row['table'] == 'mobile') {

					$excelStmt=$this->db->prepare("SELECT *FROM excel WHERE `code`=?");
					$excelStmt->execute(array($row['code']));
					if ($excelStmt->rowCount() > 0)
					{
						$DPrice=$excelStmt->fetch(PDO::FETCH_ASSOC);
						$row['now_price'] = $this->price_dollarsAdmin($DPrice['price_dollars']) . ' د.ع ';
					}else{
						$row['now_price'] ='سعر المادة غير موجود في   الاكسل';
					}



				}


				if ($row['table'] == 'camera') {

					$excelStmt=$this->db->prepare("SELECT *FROM excel_camera WHERE `code`=?");
					$excelStmt->execute(array($row['code']));
					if ($excelStmt->rowCount() > 0)
					{
						$DPrice=$excelStmt->fetch(PDO::FETCH_ASSOC);
						$row['now_price'] = $this->price_dollarsAdmin($DPrice['price_dollars']) . ' د.ع ';
					}else{
						$row['now_price'] ='سعر المادة غير موجود في   الاكسل';
					}



				}



				if ($row['table'] == 'printing_supplies') {

					$excelStmt=$this->db->prepare("SELECT *FROM excel_printing_supplies WHERE `code`=?");
					$excelStmt->execute(array($row['code']));
					if ($excelStmt->rowCount() > 0)
					{
						$DPrice=$excelStmt->fetch(PDO::FETCH_ASSOC);
						$row['now_price'] = $this->price_dollarsAdmin($DPrice['price_dollars']) . ' د.ع ';
					}else{
						$row['now_price'] ='سعر المادة غير موجود في   الاكسل';
					}



				}


				if ($row['table'] == 'computer') {

					$excelStmt=$this->db->prepare("SELECT *FROM excel_computer WHERE `code`=?");
					$excelStmt->execute(array($row['code']));
					if ($excelStmt->rowCount() > 0)
					{
						$DPrice=$excelStmt->fetch(PDO::FETCH_ASSOC);
						$row['now_price'] = $this->price_dollarsAdmin($DPrice['price_dollars']) . ' د.ع ';
					}else{
						$row['now_price'] ='سعر المادة غير موجود في   الاكسل';
					}



				}


				if ($row['table'] == 'games') {

					$excelStmt=$this->db->prepare("SELECT *FROM excel_games WHERE `code`=?");
					$excelStmt->execute(array($row['code']));
					if ($excelStmt->rowCount() > 0)
					{
						$DPrice=$excelStmt->fetch(PDO::FETCH_ASSOC);
						$row['now_price'] = $this->price_dollarsAdmin($DPrice['price_dollars']) . ' د.ع ';
					}else{
						$row['now_price'] ='سعر المادة غير موجود في   الاكسل';
					}


				}


				if ($row['table'] == 'network') {

					$excelStmt=$this->db->prepare("SELECT *FROM excel_network WHERE `code`=?");
					$excelStmt->execute(array($row['code']));
					if ($excelStmt->rowCount() > 0)
					{
						$DPrice=$excelStmt->fetch(PDO::FETCH_ASSOC);
						$row['now_price'] = $this->price_dollarsAdmin($DPrice['price_dollars']) . ' د.ع ';
					}else{
						$row['now_price'] ='سعر المادة غير موجود في   الاكسل';
					}

				}


				if ($row['table'] == 'accessories') {


					$excelStmt=$this->db->prepare("SELECT *FROM excel_accessories WHERE `code`=? AND `color`=?");
					$excelStmt->execute(array($row['code'],$row['color']));
					if ($excelStmt->rowCount() > 0)
					{
						$DPrice=$excelStmt->fetch(PDO::FETCH_ASSOC);
						$row['now_price'] = $this->price_dollarsAdmin($DPrice['price_dollars']) . ' د.ع ';
					}else{
						$row['now_price'] ='سعر المادة غير موجود في   الاكسل';
					}

				}


				if ($row['table'] == 'product_savers') {

					$excelStmt = $this->db->prepare("SELECT *FROM excel_savers WHERE `code`=?");
					$excelStmt->execute(array($row['code']));
					if ($excelStmt->rowCount() > 0) {
						$DPrice = $excelStmt->fetch(PDO::FETCH_ASSOC);
						$row['now_price'] = $this->price_dollarsAdmin($DPrice['price_dollars']) . ' د.ع ';
					} else {
						$row['now_price'] = 'سعر المادة غير موجود في   الاكسل';
					}

				}




				$rewind_active[] = $row;
			}

			require($this->render($this->folder, 'html', 'view_rewind_done', 'php'));
		}
	}

	function  rewind_search()
	{
		if ($this->handleLogin())
		{

			$search = strip_tags(trim($_GET['value']));
			$q = '%' . $search . '%';
			$stmt = $this->db->prepare("SELECT *FROM `review` WHERE ( name LIKE ? OR  phone LIKE ? ) AND `active`=1 AND cancel=0  AND `hidden`=0 GROUP BY `id_customre`  LIMIT 15");
			$stmt->execute(array($q,$q));
			$data=array();
			$count_active=null;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{

				if ($this->permit('number_phone_show',$this->folder)) {
					$phone=$row['phone'];
				}else
				{
					$phone=substr($row['phone'], 0, 3) . "*****" . substr($row['phone'], 8);
				}

				$count_active.="
                <a class='infoCustomer ifactive' id='row{$row['id_customre']}' href='#' onclick='getRewind({$row['id_customre']})'>
                        <div>{$row['name']}</div>
                        <div   style='direction: ltr;' >{$phone}</div>
                    </a>
                                   
                ";
			}

			if ($count_active)
			{
				echo  $count_active;

			}else{
				echo 'لا توجد بيانات';
			}


		}
	}

	function  rewind_search_new()
	{
		if ($this->handleLogin())
		{

			$search = strip_tags(trim($_GET['value']));
			  $q = '%' . $search . '%';
			$stmt = $this->db->prepare("SELECT *FROM `review` WHERE ( name LIKE ? OR  phone LIKE ? )  AND `active`=0 AND cancel=0 GROUP BY `id_customre`  LIMIT 15");
			$stmt->execute(array($q,$q));
			$data=array();
			$count_active=null;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{

				if ($this->permit('number_phone_show',$this->folder)) {
					$phone=$row['phone'];
				}else
				{
					$phone=substr($row['phone'], 0, 3) . "*****" . substr($row['phone'], 8);
				}
				$count_active.="
                <a class='infoCustomer ifactive' id='row{$row['id_customre']}' href='#' onclick='getRewind({$row['id_customre']})'>
                        <div>{$row['name']}</div>
                        <div   style='direction: ltr;' >{$phone}</div>
                    </a>
                                   
                ";
			}

			if ($count_active)
			{
				echo  $count_active;

			}else{
				echo 'لا توجد بيانات';
			}


		}
	}

    function edit_price()
    {
        $price=(int)str_replace($this->comma,'',$_GET['price']);
        if (is_numeric($price)) {


            $id_member_r = $_GET['id_member_r'];
            $id_item = $_GET['id_item'];
            $number_bill = $_GET['number_bill'];
            $table = $_GET['table'];
            $code = $_GET['code'];
            $color_name = $_GET['color_name'];




                $stmtch = $this->db->prepare("SELECT *FROM cart_shop_active WHERE id_member_r=? AND id_item =? AND number_bill=? AND  `table`=? AND code=? AND name_color=? LIMIT 1");
                $stmtch->execute(array($id_member_r, $id_item, $number_bill, $table, $code, $color_name));
                if ($stmtch->rowCount() > 0) {
                    $result = $stmtch->fetch(PDO::FETCH_ASSOC);
                    $new_price = $price / $result['dollar_exchange'];

                    if ($this->check_item_round($table,$id_item)) {
                        if (is_float($new_price)) {
                            $p = explode('.', $new_price);
                            $new_price = $p[0] . '.' . substr($p[1], 0, 1);
                        }
                    }

                    $stmtup = $this->db->prepare("UPDATE  cart_shop_active  SET price_dollars=? ,old_price=?,edit_price=?,user_edit_price=? WHERE id_member_r=? AND id_item =? AND number_bill=? AND  `table`=? AND code=? AND name_color=? ");
                    $stmtup->execute(array($new_price, $result['price_dollars'], 1, $this->userid, $id_member_r, $id_item, $number_bill, $table, $code, $color_name));
                    if ($stmtup->rowCount() > 0) {


                        $stmtPriceBill = $this->db->prepare("UPDATE  cart_shop_active  SET edit_price=? WHERE id_member_r=?   AND number_bill=? AND  `table`=?   ");
                        $stmtPriceBill->execute(array(1, $id_member_r, $number_bill, $table));


                        echo 'edit';
                    }else
                    {
                        echo 'not_edit';
                    }
                } else {
                    echo 'not_found';
                }
        }else
        {
            echo 'xprice';
        }

    }



    public  function details($id,$number_bill)
    {

        if (!is_numeric($id)) {$error=new Errors(); $error->index();}

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



        $stmt=$this->getAllContentFromCar_details_client_done($id,$number_bill);
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
                $row['price']=$price;
                $f1 = (int)trim(str_replace($this->comma, '', $price[0]));
                $xp1 = $xp1 + ($f1 * $row['number']);
                $price1= number_format(round($xp1));


            } else {

                if ($this->check_item_round($row['table'],$row['id_item'])) {
                    $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
                    $row['price']= $price;
                }else
                {
                    $price = $this->not_round_price($row['price_dollars'], $row['dollar_exchange']);
                    $row['price']= $price;
                }

                $f1 = (int)trim(str_replace($this->comma, '', $price));
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
            $number_bill=$row['number_bill'];
            $table=$row['table'];
            $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
            $stmt_get_item->execute(array($row['id_item']));
            $item = $stmt_get_item->fetch();

            $row['title']=$item['title'];
            $row['img']=$this->save_file.$row['image'];

            $date_req[$row['date_req']]=$row['date_req'];
            if ($row['direct']  > 0 || $row['user_direct'] !=0  )
            {
                $prepared=$this->UserInfo($row['user_direct']);
            }else
            {
                $prepared=$this->UserInfo($row['id_prepared']);
            }
            $row['color_name']=$row['name_color'];



            $request[]=$row;
        }
        $date_req=json_encode($date_req);

        /*             بسبب تجميعة العروض       */


        $requestPrint=array();


        $price1_Offer=0;
        $price1_normal=0;
        $xp1Offer=0;
        $xpdOffer=0;
        $number_typeOffer=0;
        $sum_materialOffer=0;
        $price_dollarsOffer=0;




        $stmtOffer = $this->db->prepare("SELECT  cart_shop_active.*  FROM `cart_shop_active` WHERE `id_member_r` =? AND `number_bill`=?  AND `accountant`=1  AND id_offer <> 0 AND offers = 'offers' GROUP BY  `date_offer`  ORDER BY `id` DESC  ");
        $stmtOffer->execute(array($id,$number_bill));

        while ($row = $stmtOffer->fetch(PDO::FETCH_ASSOC))
        {


            if ($row['offers']  =='offers')
            {

                $row['price'] = $this->priceDollarOffer($row['id_offer'],4) . ' د.ع ';
                $price1_Offer = $price1_Offer + (int)str_replace($this->comma,'',$this->priceDollarOffer($row['id_offer'],4));
                $row['price_dollars'] = $this->priceDollarOffer($row['id_offer'],3)  ;

                $row['title']=$this->details_offer($row['id_offer'],'title');

                $row['img']=$this->save_file.$this->details_offer($row['id_offer'],'img');

            }
            $row['size']='';
            $row['name_color']='';





            $pd=explode('-',$row['price_dollars'])  ;
            $f1d= (double)trim(str_replace(',','.', $pd[0]));
            $xpdOffer = $xpdOffer + ($f1d * $row['number']);
            $price_dollarsOffer= $xpdOffer;
            $number_typeOffer=$number_typeOffer+1;
            $sum_materialOffer=$sum_materialOffer+$row['number'];

            $date=$row['date'];
            $number_bill=$row['number_bill'];


            if ($row['direct']  > 0 || $row['user_direct'] !=0  )
            {
                $prepared=$this->UserInfo($row['user_direct']);
            }else
            {
                $prepared=$this->UserInfo($row['id_prepared']);
            }
            $row['color_name']=$row['name_color'];




            $requestPrint[]=$row;
        }



        $stmtOffer = $this->db->prepare("SELECT  cart_shop_active.*,SUM(number) as number FROM `cart_shop_active` WHERE `id_member_r` =? AND `number_bill`=?  AND `accountant`=1   AND id_offer = 0  AND offers = ''  GROUP BY  `id_item`,`table`,`code`,`color`,`number_bill`,price_type  ORDER BY `id` DESC  ");
        $stmtOffer->execute(array($id,$number_bill));

        while ($row = $stmtOffer->fetch(PDO::FETCH_ASSOC))
        {



            $table=$row['table'];
            $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
            $stmt_get_item->execute(array($row['id_item']));
            $item = $stmt_get_item->fetch();

            $row['title']=$item['title'];
            $row['img']=$this->save_file.$row['image'];



            if (!empty($this->cuts($row['id_item'],$row['table']))) {

                $price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
                $row['price']= $price;
                $f1 = (int)trim(str_replace($this->comma, '', $price[0]));
                $xp1Offer = $xp1Offer + ($f1 * $row['number']);
                $price1_normal= (round($xp1Offer));


            } else {

                if ($this->check_item_round($row['table'],$row['id_item'])) {
                    $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
                    $row['price']= $price;
                }else
                {
                    $price = $this->not_round_price($row['price_dollars'], $row['dollar_exchange']);
                    $row['price']= $price;
                }

                $f1 = (int)trim(str_replace($this->comma, '', $price));
                $xp1Offer = $xp1Offer + ($f1 * $row['number']);
                $price1_normal= ($xp1Offer);

            }

            $pd=explode('-',$row['price_dollars'])  ;
            $f1d= (double)trim(str_replace(',','.', $pd[0]));
            $xpdOffer = $xpdOffer + ($f1d * $row['number']);
            $price_dollarsOffer= $xpdOffer;
            $number_typeOffer=$number_typeOffer+1;
            $sum_materialOffer=$sum_materialOffer+$row['number'];

            $date=$row['date'];
            $number_bill=$row['number_bill'];


            if ($row['direct']  > 0 || $row['user_direct'] !=0  )
            {
                $prepared=$this->UserInfo($row['user_direct']);
            }else
            {
                $prepared=$this->UserInfo($row['id_prepared']);
            }
            $row['color_name']=$row['name_color'];



            $requestPrint[]=$row;
        }

        $price1Offer=0;
        $price1Offer=(int)str_replace($this->comma,'',$price1_Offer)+(int)str_replace($this->comma,'',$price1_normal);



        require($this->render($this->folder, 'html', 'details', 'php'));


    }



    function sun_total_money()
    {
       echo number_format( $this->billAcount_money_clipper($this->userid));
    }


}
