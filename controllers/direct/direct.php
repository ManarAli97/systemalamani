<?php

class direct extends Controller
{

	function __construct()
	{
		parent::__construct();
		$this->cart_shop_active = 'cart_shop_active';
		$this->setting=new Setting();
        $this->result = 0;
        $this->catgUser=array();

        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
        $stmt_cat->execute(array($this->userid));

        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
        {

            if ($row['catg'] =='savers')
            {
                $row['catg']='product_savers';
            }
            $this->catgUser[]="'".$row['catg']."'";

        }

    }


	public function index()
	{

		$this->checkPermit('view_request', $this->folder);
		$this->adminHeaderController($this->langControl('view_request'));

		if ($this->admin($this->userid)) {
			$stmt = $this->db->prepare("SELECT cart_shop_active.accountant,cart_shop_active.id_accountant_user,cart_shop_active.id_member_r, cart_shop_active.number_bill,cart_shop_active.top,cart_shop_active.date_req,cart_shop_active.direct,cart_shop_active.user_direct,register_user.id,register_user.name,register_user.phone  FROM `cart_shop_active` inner join register_user on register_user.id=cart_shop_active.id_member_r WHERE  cart_shop_active.`accountant` = 1 AND cart_shop_active.`prepared` = 1 AND  cart_shop_active.done_direct =0 AND  (cart_shop_active.`direct` =2  OR cart_shop_active.direct=0 )   GROUP BY cart_shop_active.`number_bill`,cart_shop_active.id_member_r   ORDER BY cart_shop_active.`number_bill` ASC ");
			$stmt->execute();
		} else {
			$stmt = $this->db->prepare("SELECT cart_shop_active.accountant,cart_shop_active.id_accountant_user,cart_shop_active.id_member_r, cart_shop_active.number_bill,cart_shop_active.top,cart_shop_active.date_req,cart_shop_active.direct,cart_shop_active.user_direct,register_user.id,register_user.name,register_user.phone  FROM `cart_shop_active` inner join register_user on register_user.id=cart_shop_active.id_member_r WHERE   (cart_shop_active.`user_direct` =? OR cart_shop_active.direct=0 ) AND cart_shop_active.`accountant` = 1 AND cart_shop_active.`prepared` = 1 AND  cart_shop_active.done_direct =0 AND (cart_shop_active.`direct` =2  OR cart_shop_active.direct=0 ) GROUP BY cart_shop_active.`number_bill`,cart_shop_active.id_member_r  ORDER BY cart_shop_active.`number_bill` ASC ");
			$stmt->execute(array($this->userid));
		}

		$count_active = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

				$count_active[] = $row;


		}

		require($this->render($this->folder, 'html', 'active', 'php'));

		$this->adminFooterController();

	}


	public function direct3_account()
	{

		$this->checkPermit('view_request', $this->folder);
		$this->adminHeaderController($this->langControl('view_request'));



            $c=implode(',',$this->catgUser);
            //   تغير بسبب اقراص  اللعاب تحديث 2022-4-28  الى 2022-5-1  في حال النسيان راجع الرسائل مع ست اسراء
//			$stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  buy <> 0 AND   ( `user_direct` =? OR   `direct` = 0   )  AND  `accountant` = 0    AND  done_direct =0 AND  ( `direct` =3  OR `direct` = 0   ) AND `back_to`=0 AND `cancel`=0    AND `table`  IN ({$c})    GROUP BY `number_bill`  ORDER BY `number_bill` ASC ");
			$stmt = $this->db->prepare("SELECT cart_shop_active.date_req,cart_shop_active.id_accountant_user,cart_shop_active.accountant,cart_shop_active.user_direct,cart_shop_active.number_bill,cart_shop_active.id_accountant_user,cart_shop_active.number_bill,register_user.name,register_user.phone,register_user.id FROM `cart_shop_active` INNER JOIN register_user ON register_user.id=cart_shop_active.id_member_r WHERE  cart_shop_active.buy <> 0 AND   cart_shop_active.`accountant` = 0   AND   cart_shop_active.`back_to`=0 AND cart_shop_active.`cancel`=0    AND cart_shop_active.`table`  IN ({$c})    GROUP BY cart_shop_active.`number_bill`,cart_shop_active.`id_member_r`   ORDER BY cart_shop_active.`number_bill` ASC ");
			$stmt->execute();
//			$stmt->execute(array($this->userid));


		$count_active = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

//                $row['sumbill']=$this->sunBill($row['id_member_r'],$row['number_bill']);
                $row['date_order']=date('Y-m-d h:i A',$row['date_req']);
                $row['id_accountant_user'] = $this->UserInfo($row['id_accountant_user']);
				$count_active[] = $row;

		}

		require($this->render($this->folder, 'html', 'darect3_account', 'php'));

        $this->adminFooterController2();

	}



	function  search_new()
	{
		if ($this->handleLogin())
		{


			$search = strip_tags(trim($_GET['value']));
			$q = '%' . $search . '%';
			$stmt = $this->db->prepare("SELECT cart_shop_active.accountant,cart_shop_active.id_member_r, cart_shop_active.number_bill,cart_shop_active.top,cart_shop_active.date_req,cart_shop_active.direct,cart_shop_active.user_direct,register_user.id,register_user.name,register_user.phone  FROM `cart_shop_active` inner join register_user on register_user.id=cart_shop_active.id_member_r WHERE ( register_user.name LIKE ? OR  register_user.phone LIKE ? OR cart_shop_active.number_bill=? ) AND  cart_shop_active.accountant =0   AND cart_shop_active.cancel=0 AND          (`prepared`=1 or prepared=0) GROUP BY cart_shop_active.id_member_r  LIMIT 15");
			$stmt->execute(array($q,$q,trim($search)));
			$data=array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{


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




	function  search_new_qr()
	{
		if ($this->handleLogin())
		{


            $q = strip_tags(trim($_GET['qr']));

			$stmt = $this->db->prepare("SELECT cart_shop_active.accountant,cart_shop_active.id_member_r, cart_shop_active.number_bill,cart_shop_active.top,cart_shop_active.date_req,cart_shop_active.direct,cart_shop_active.user_direct,register_user.id,register_user.name,register_user.phone  FROM `cart_shop_active` inner join register_user on register_user.id=cart_shop_active.id_member_r WHERE register_user.uid = ?  AND  cart_shop_active.accountant =0   AND cart_shop_active.cancel=0    AND     (`prepared`=1 or prepared=0) GROUP BY cart_shop_active.id_member_r  LIMIT 1");
			$stmt->execute(array($q));
			$data=array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{


				$row['sumbill']=$this->sunBill($row['id_member_r'],$row['number_bill']);
				$row['date_order']=date('Y-m-d h:i A',$row['date_req']);

				$row['user_direct']=$this->UserInfo($row['user_direct']);

				if ($row['accountant']==0)
				{
					$data[]=$row;

				}

			}
			if($data){
                require($this->render($this->folder, 'html', 'search_acc_qr', 'php'));
            }

		}
	}




	function  search_new_qr_direct3_tz()
	{
		if ($this->handleLogin())
		{


            $q = strip_tags(trim($_GET['qr']));

			$stmt = $this->db->prepare("SELECT cart_shop_active.accountant,cart_shop_active.id_accountant_user,cart_shop_active.id_member_r, cart_shop_active.number_bill,cart_shop_active.top,cart_shop_active.date_req,cart_shop_active.direct,cart_shop_active.user_direct,register_user.id,register_user.name,register_user.phone  FROM `cart_shop_active` inner join register_user on register_user.id=cart_shop_active.id_member_r WHERE register_user.uid = ?  AND  cart_shop_active.accountant =1   AND cart_shop_active.cancel=0    AND     (`prepared`=1 or prepared=0) GROUP BY cart_shop_active.id_member_r  LIMIT 1");
			$stmt->execute(array($q));
			$data=array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{


				$row['sumbill']=$this->sunBill($row['id_member_r'],$row['number_bill']);
				$row['date_order']=date('Y-m-d h:i A',$row['date_req']);

				$row['user_direct']=$this->UserInfo($row['user_direct']);

                $row['id_accountant_user']=$this->UserInfo($row['id_accountant_user']);



					$data[]=$row;


			}

			if($data){
                 require($this->render($this->folder, 'html', 'search_qr_direct3_tz', 'php'));
            }

		}
	}



	function  search_new_qr_direct2_tz()
	{
		if ($this->handleLogin())
		{


            $q = strip_tags(trim($_GET['qr']));

			$stmt = $this->db->prepare("SELECT cart_shop_active.accountant,cart_shop_active.id_accountant_user,cart_shop_active.id_member_r, cart_shop_active.number_bill,cart_shop_active.top,cart_shop_active.date_req,cart_shop_active.direct,cart_shop_active.user_direct,register_user.id,register_user.name,register_user.phone  FROM `cart_shop_active` inner join register_user on register_user.id=cart_shop_active.id_member_r WHERE register_user.uid = ?    AND `accountant` = 1 AND `prepared` = 1 AND  done_direct =0 AND (`direct` =2  OR direct=0 )    LIMIT 1");
			$stmt->execute(array($q));
			$data=array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{



					$data[]=$row;


			}

			if($data){
                 require($this->render($this->folder, 'html', 'search_qr_direct2_tz', 'php'));
            }

		}
	}








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
        $stmtOffer = $this->db->prepare("SELECT  cart_shop_active.* FROM `cart_shop_active` WHERE `id_member_r` =? AND `number_bill`=?  AND `accountant`=0  AND id_offer <> 0 AND offers = 'offers' GROUP BY  `date_offer`  ORDER BY `id` DESC  ");
        $stmtOffer->execute(array($id, $number_bill));
        if ($stmtOffer -> rowCount() > 0) {
            while ($row = $stmtOffer->fetch(PDO::FETCH_ASSOC)) {
                if ($row['offers'] == 'offers') {
                    $row['price'] = $this->priceDollarOffer($row['id_offer'], 4) . ' د.ع ';
                    $price1_Offer = $price1_Offer + (int)str_replace($this->comma, '', $this->priceDollarOffer($row['id_offer'], 4));
                }
            }
        }

        $stmtNotOffer = $this->db->prepare("SELECT  cart_shop_active.*,SUM(number) as number FROM `cart_shop_active` WHERE `id_member_r` =? AND `number_bill`=? AND    `accountant`=0   AND id_offer = 0  AND offers = ''  GROUP BY  `id_item`,`table`,`code`,`color`,`number_bill`,price_type  ORDER BY `id` DESC  ");
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




    /*
    * get title type device from table(type_device) and  table(category_accessories)
    *2022/07/09
    */
    function type_device($id_device,$table)
    {
        $stmt_name = $this->db->prepare("SELECT `title` FROM `{$table}` WHERE id = ?  LIMIT 1");
        $stmt_name->execute(array($id_device));
        if ($stmt_name->rowCount()>0)
        {
            $name = $stmt_name->fetch(PDO::FETCH_ASSOC);
            return  $name['title'];
        }else
        {
            return ' ';
        }
    }
    /*
   * get title type device customer from table(type_device) and  table(category_accessories)
   *2022/07/09
   */
    function type_device_customer($id_device,$number_bill,$table){
        $model = 'product_savers';
        if($table == 'category_accessories'){
            $model = 'accessories';
        }
        $stmt_device_customer = $this->db->prepare("SELECT `title` FROM `{$table}` WHERE id in (SELECT id_device_customer FROM `type_device_customer` where `model` = ? AND id_type_device =? AND id_shop_cart in (select id from `cart_shop_active` where number_bill =?))");
        $stmt_device_customer->execute(array($model,$id_device,$number_bill));
        if ($stmt_device_customer->rowCount()>0)
        {
            $name = $stmt_device_customer->fetch(PDO::FETCH_ASSOC);
            return  $name['title'];
        }else
        {
            return ' ';
        }
    }



	public function view_order3_account($id)
	{

		if (!is_numeric($id)) {
			$error = new Errors();
			$error->index();
		}
		$this->checkPermit('view_order', $this->folder);

		$number_bill = $_GET['number_bill'];


		$stmt = $this->db->prepare("SELECT *FROM `register_answer` WHERE `id_user`=?");
		$stmt->execute(array($id));
		$answer = $stmt->fetch(PDO::FETCH_ASSOC);


		$id_user = $id;
		$stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ?    LIMIT 1");
		$stmt->execute(array($id_user));
		$result = $stmt->fetch();


		$stmt = $this->db->prepare("SELECT  cart_shop_active.*,SUM(`number`)as number FROM `cart_shop_active` WHERE `id_member_r` =?  AND `accountant`=0 AND `number_bill`=?    GROUP BY   `id_item`,`table`,`code`,`number_bill`,price_type,id_offer     ");
		$stmt->execute(array($id, $number_bill));

		$request = array();

		$sum = 0;
		$date_req = array();
		$price1 = 0;
		$xp1 = 0;
		$xpd = 0;
		$number_type = 0;
		$sum_material = 0;
		$price_dollars = 0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {





                if ($row['offers'] == 'offers') {

//                    $price = $this->priceDollarOffer($row['id_offer'], 4);
                    $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);

                }else
                {
                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
                    }else
                    {
                        $price = $this->not_round_price($row['price_dollars'], $row['dollar_exchange']);
                    }
                }



                 $row['price']=$price.' د.ع ';


				$f1 = (int)trim(str_replace($this->comma, '', $price));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1 = number_format($xp1);


			$pd = explode('-', $row['price_dollars']);
			$f1d = (double)trim(str_replace(',', '.', $pd[0]));
			$xpd = $xpd + ($f1d * $row['number']);
			$price_dollars = $xpd;
			$number_type = $number_type + 1;
			$sum_material = $sum_material + $row['number'];

			$date = $row['date'];
			$number_bill = $row['number_bill'];
			$table = $row['table'];
			$stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
			$stmt_get_item->execute(array($row['id_item']));
			$item = $stmt_get_item->fetch();

			$row['title'] = $item['title'];
			$row['img'] = $this->save_file . $row['image'];

			$date_req[$row['date_req']] = $row['date_req'];


			  $row['color_name'] = $row['name_color'];

            if($row['table'] == 'product_savers'){
                $id_device =  $item['id_device'];
                $name_device= $this->type_device($id_device,'type_device');
                $row['name_device'] =  $name_device;

                $name_device_customer= $this->type_device_customer($id_device,$number_bill,'type_device');
                $row['name_device_customer'] =  $name_device_customer;


            }

//             if($row['table'] == 'accessories'){
//                 $result_check = $this->check_id_catge($item['id_cat']);
//                 if($result_check == 1){

//                     $id_catg_acc =  $item['id_cat'];
//                     $name_categ_acc= $this->type_device($id_catg_acc,'category_accessories');
//                     $row['name_categ_acc'] =  $name_categ_acc;

//                     $name_categ_acc_customer= $this->type_device_customer($id_catg_acc,$number_bill,'category_accessories');
//                     $row['name_categ_acc_customer'] =  $name_categ_acc_customer;
//                 }else{
//                     $row['name_categ_acc'] = '';
//                     $row['name_categ_acc_customer'] = '';
//                 }

//             }
        
        	
            if($row['table'] == 'accessories'){
                $result_check = $this->check_id_catge($item['id_cat']);
                if($result_check == 1){

         

                $row['category']= array();
                $result_check = $this->check_id_catge($item['id_cat']);
                if($result_check == 1){
                    $stmt_ch = $this->db->prepare("SELECT `ids` FROM `category_accessories_connect` WHERE  FIND_IN_SET(?,`ids`)  AND  active=1 LIMIT 1");
                    $stmt_ch->execute(array($item['id_cat']));
                    if($stmt_ch->rowCount() > 0){
                        $row_ch = $stmt_ch->fetch(PDO::FETCH_ASSOC);
                        $ids = $row_ch['ids'];
                        $stmt_title = $this->db->prepare("SELECT `title` FROM `category_accessories` WHERE  id IN ($ids)");
                        $stmt_title->execute(array($item['id_cat']));
                        while ($row_title = $stmt_title->fetch(PDO::FETCH_ASSOC)) {
                            $row['category'][] = $row_title;
                            $row['check_s'] = true;
                        }
                    }
                }

                }else{
                    $nameCatAcc= array();
                    $row['check_s'] = false;
               }

            }

			$request[] = $row;
		}
		$date_req = json_encode($date_req);



        $requestPrint=array();


        $price1_Offer=0;
        $price1_normal=0;
        $xp1Offer=0;
        $xpdOffer=0;
        $number_typeOffer=0;
        $sum_materialOffer=0;
        $price_dollarsOffer=0;


        $stmtOffer = $this->db->prepare("SELECT  cart_shop_active.* FROM `cart_shop_active` WHERE `id_member_r` =? AND `number_bill`=?  AND `accountant`=0  AND id_offer <> 0 AND offers = 'offers' GROUP BY  `date_offer`  ORDER BY `id` DESC  ");
        $stmtOffer->execute(array($id, $number_bill));


        while ($row = $stmtOffer->fetch(PDO::FETCH_ASSOC))
        {


            if ($row['offers']  =='offers')
            {

                    $row['price'] = $this->priceDollarOffer($row['id_offer'],4) . ' د.ع ';
                   $price1_Offer = $price1_Offer + (int)str_replace($this->comma,'',$this->priceDollarOffer($row['id_offer'],4));
                    $row['price_dollars'] = $this->priceDollarOffer($row['id_offer'],3)  ;


                $row['title']=$this->details_offer($row['id_offer'],'title');

                $row['img']=$this->save_file.$this->details_offer($row['id_offer'],'img');

            }else{

                $table=$row['table'];
                $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
                $stmt_get_item->execute(array($row['id_item']));
                $item = $stmt_get_item->fetch();

                $row['title']=$item['title'];
                $row['img']=$this->save_file.$row['image'];

            }


            $pd=explode('-',$row['price_dollars'])  ;
            $f1d= (double)trim(str_replace(',','.', $pd[0]));
            $xpdOffer = $xpdOffer + ($f1d * $row['number']);
            $price_dollarsOffer= $xpdOffer;
            $number_typeOffer=$number_typeOffer+1;
            $sum_materialOffer=$sum_materialOffer+$row['number'];

            $date=$row['date'];
            $number_bill=$row['number_bill'];
            if($row['table'] == 'product_savers'){
                $id_device =  $item['id_device'];
                $name_device= $this->type_device($id_device,'type_device');
                $row['name_device'] =  $name_device;

                $name_device_customer= $this->type_device_customer($id_device,$number_bill,'type_device');
                $row['name_device_customer'] =  $name_device_customer;

            }

//             if($row['table'] == 'accessories'){
//                 $result_check = $this->check_id_catge($item['id_cat']);
//                 if($result_check == 1){
//                     $id_catg_acc =  $item['id_cat'];
//                     $name_categ_acc= $this->type_device($id_catg_acc,'category_accessories');
//                     $row['name_categ_acc'] =  $name_categ_acc;

//                     $name_categ_acc_customer= $this->type_device_customer($id_catg_acc,$number_bill,'category_accessories');
//                     $row['name_categ_acc_customer'] =  $name_categ_acc_customer;
//                 }else{
//                     $row['name_categ_acc'] = '';
//                     $row['name_categ_acc_customer'] = '';

//                 }
//             }
        
        		 if($row['table'] == 'accessories'){
                $result_check = $this->check_id_catge($item['id_cat']);
                if($result_check == 1){

         

                $row['category']= array();
                $result_check = $this->check_id_catge($item['id_cat']);
                if($result_check == 1){
                    $stmt_ch = $this->db->prepare("SELECT `ids` FROM `category_accessories_connect` WHERE  FIND_IN_SET(?,`ids`)  AND  active=1 LIMIT 1");
                    $stmt_ch->execute(array($item['id_cat']));
                    if($stmt_ch->rowCount() > 0){
                        $row_ch = $stmt_ch->fetch(PDO::FETCH_ASSOC);
                        $ids = $row_ch['ids'];
                        $stmt_title = $this->db->prepare("SELECT `title` FROM `category_accessories` WHERE  id IN ($ids)");
                        $stmt_title->execute(array($item['id_cat']));
                        while ($row_title = $stmt_title->fetch(PDO::FETCH_ASSOC)) {
                            $row['category'][] = $row_title;
                            $row['check_s'] = true;
                        }
                    }
                }

                }else{
                    $nameCatAcc= array();
                    $row['check_s'] = false;
               }

            }

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

        $stmtOffer = $this->db->prepare("SELECT  cart_shop_active.*,SUM(number) as number FROM `cart_shop_active` WHERE `id_member_r` =? AND `number_bill`=? AND    `accountant`=0   AND id_offer = 0  AND offers = ''  GROUP BY  `id_item`,`table`,`code`,`color`,`number_bill`,price_type  ORDER BY `id` DESC  ");
        $stmtOffer->execute(array($id,$number_bill));

        while ($row = $stmtOffer->fetch(PDO::FETCH_ASSOC))
        {



            $table=$row['table'];
            $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
            $stmt_get_item->execute(array($row['id_item']));
            $item = $stmt_get_item->fetch();

            $row['title']=$item['title'];
            $row['img']=$this->save_file.$row['image'];

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


            $pd=explode('-',$row['price_dollars'])  ;
            $f1d= (double)trim(str_replace(',','.', $pd[0]));
            $xpdOffer = $xpdOffer + ($f1d * $row['number']);
            $price_dollarsOffer= $xpdOffer;
            $number_typeOffer=$number_typeOffer+1;
            $sum_materialOffer=$sum_materialOffer+$row['number'];

            $date=$row['date'];
            $number_bill=$row['number_bill'];


            if($row['table'] == 'product_savers'){
                $id_device =  $item['id_device'];
                $name_device= $this->type_device($id_device,'type_device');
                $row['name_device'] =  $name_device;
                $name_device_customer= $this->type_device_customer($id_device,$number_bill,'type_device');
                $row['name_device_customer'] =  $name_device_customer;

            }


        
        	 if($row['table'] == 'accessories'){
                $result_check = $this->check_id_catge($item['id_cat']);
                if($result_check == 1){

         

                $row['category']= array();
                $result_check = $this->check_id_catge($item['id_cat']);
                if($result_check == 1){
                    $stmt_ch = $this->db->prepare("SELECT `ids` FROM `category_accessories_connect` WHERE  FIND_IN_SET(?,`ids`)  AND  active=1 LIMIT 1");
                    $stmt_ch->execute(array($item['id_cat']));
                    if($stmt_ch->rowCount() > 0){
                        $row_ch = $stmt_ch->fetch(PDO::FETCH_ASSOC);
                        $ids = $row_ch['ids'];
                        $stmt_title = $this->db->prepare("SELECT `title` FROM `category_accessories` WHERE  id IN ($ids)");
                        $stmt_title->execute(array($item['id_cat']));
                        while ($row_title = $stmt_title->fetch(PDO::FETCH_ASSOC)) {
                            $row['category'][] = $row_title;
                            $row['check_s'] = true;
                        }
                    }
                }

                }else{
                    $nameCatAcc= array();
                    $row['check_s'] = false;
               }

            }



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




        require($this->render($this->folder, 'html', 'order3_account', 'php'));

	}


	function processing_request3_account($id)
	{
				if ($this->handleLogin()) {
			if (!is_numeric($id)) {
				$error = new Errors();
				$error->index();
			}


		        	$number_bill = $_GET['number_bill'];


                        $stmtChAcco = $this->db->prepare("SELECT count(id) as count_ FROM  `cart_shop_active`  WHERE `number_bill` =? AND `id_member_r`=? AND `buy` = 1  AND cancel=0 ");
                        $stmtChAcco->execute(array($number_bill, $id));
                        $rowChAcco = $stmtChAcco->fetch(PDO::FETCH_ASSOC);
                        if ($rowChAcco['count_'] > 0) {




				              $price1 = (int)trim(str_replace($this->comma, '', $this->sunBill($id,$number_bill)));

								$stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill` = ? ");
								$stmtt->execute(array($number_bill));
								$oldData = array();
								while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
									$oldData[] =$rowt;
								}


								 $stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `status` = 1 ,  `accountant` = 1 , `prepared` = 1 , `date_accountant`= ? , `user_id`=?,`id_accountant_user`=?,`top`=0,user_direct=?,auto_print=1  WHERE `number_bill` =? AND `buy` = ?  AND `id_member_r`=?  AND `accountant`=0");
								$stmt2->execute(array(time(), $this->userid, $this->userid,  $this->userid, $number_bill, 1, $id));

								if ($stmt2->rowCount() > 0) {

									$stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill` = ? ");
									$stmtt->execute(array($number_bill));
									$newData = array();
									while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
										$newData[] = $rowt;
									}

									$trace = new trace();
									$trace->addtrace('cart_shop_active', 'محاسبة', json_encode($oldData), json_encode($newData), ' محاسبة طلب', $number_bill);




									$stmt1 = $this->db->prepare("SELECT count(id) as count_ FROM  log_accountant  WHERE `id_user` = ? ");
									$stmt1->execute(array($this->userid));
                                    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
									if ($row1['count_'] > 0) {
										$stmt = $this->db->prepare("UPDATE log_accountant SET `money`=money+? ,`date`=? WHERE `id_user` = ?");
										$stmt->execute(array($price1, time(), $this->userid));
									} else {
										$stmt = $this->db->prepare("INSERT INTO log_accountant (`money`,`username`,`id_user`,`date`) values  (?,?,?,?) ");
										$stmt->execute(array($price1, $_SESSION['usernamelogin'], $this->userid, time()));
									}

									$stmt1x = $this->db->prepare("SELECT count(id) as count_ FROM  log_accountant_bill  WHERE `number_bill` = ? ");
									$stmt1x->execute(array($number_bill));
                                    $row1x = $stmt1x->fetch(PDO::FETCH_ASSOC);
									if ($row1x['count_'] > 0) {
										$stmtx = $this->db->prepare("UPDATE log_accountant_bill SET `money`=money+? ,`date`=?,`update_uer`=? WHERE `number_bill` = ?");
										$stmtx->execute(array($price1, time(), $this->userid, $number_bill));
									} else {
										$stmtx = $this->db->prepare("INSERT INTO log_accountant_bill (`money`,`number_bill`,`username`,`id_user`,`date`) values  (?,?,?,?,?) ");
										$stmtx->execute(array($price1, $number_bill, $_SESSION['usernamelogin'], $this->userid, time()));
									}



									$xstmt = $this->db->prepare("SELECT count(id) as count_ FROM `bill` WHERE  `id_member_r` = ? AND number_bill=? AND `userid_accountant`=? ");
									$xstmt->execute(array($id, $number_bill,$this->userid));
                                    $xrow = $xstmt->fetch(PDO::FETCH_ASSOC);
									if ($xrow['count_'] > 0) {
										$stmt = $this->db->prepare("UPDATE  `bill` SET `sum_bill`=sum_bill+?  WHERE  `id_member_r` = ? AND number_bill=?  AND `userid_accountant`=? ");
										$stmt->execute(array($price1, $id, $number_bill,$this->userid));

									} else {
										$stmt = $this->db->prepare("INSERT INTO `bill` (`userid_accountant`,`id_member_r`,`number_bill`,`sum_bill`,`date`) values (?,?,?,?,?)");
										$stmt->execute(array($this->userid, $id, $number_bill, $price1, time()));
									}

									//هاي الداله اسوي تجهيز مباشر اذا الماده خدميه
                                    // $this->tajhez_service_material($id,$number_bill);
							echo 1;
						} else {
							echo 0;
						}
			    } else {
				echo 'accounted';
			}

		} else {
			echo 'login';
		}
	}

//  public function tajhez_service_material($id,$number_bill)
//     {

//         $stmtCh_acco = $this->db->prepare("SELECT `id_item`,`code`,`table` FROM `cart_shop` WHERE id_member_r=? AND  `number_bill`=?  AND `accountant`=1  ");
//         $stmtCh_acco->execute(array($id,$number_bill));
//         if($stmtCh_acco->rowCount()>0){

//             while ($rowt = $stmtCh_acco->fetch(PDO::FETCH_ASSOC)) {

//                 $stmt = $this->db->prepare("SELECT is_service FROM `{$rowt['table']}` WHERE id=? AND is_service = 1");
// 		        $stmt->execute(array($rowt['id_item'] ));
//                 if($stmt->rowCount()>0){
//                     $stmt2 = $this->db->prepare("UPDATE `cart_shop` SET  `user_direct`=?,  `done_direct` = 1, `buy` = 2 ,  `prepared` = 2 ,  `date_prepared`= ?   WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=? AND `number_bill` = ? AND `accountant`=1 ");
//                     $stmt2->execute(array( $this->userid,time(), $rowt['code'] , $id , $rowt['table'] , $rowt['id_item'] , $number_bill));

//                     $trace = new trace();
//                     $trace->addtrace('cart_shop', 'تجهيز الطلب من قبل المحاسب المباشر  ' . $number_bill,null,null, '  تجهيز الطلب من قبل المحاسب المباشر',$number_bill);
//                 }
//             }
//         }

//     }

	public function getAllContentFromCar_number_bill3_account($id_member_r,$number_bill)
	{
		$stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx`,`number_bill`,`top`,`dollar_exchange` FROM `cart_shop_active` WHERE `id_member_r` =? AND number_bill =? AND   `buy` = 1 AND `status` =0 AND `accountant`=0 GROUP BY  `id_item`,`table`,`code`,`number_bill`,price_type,id_offer   ORDER BY `id` DESC  ");
		$stmt->execute(array($id_member_r,$number_bill));
		return $stmt;
	}






	public function direct3()
    {

        $this->checkPermit('view_request',$this->folder);
        $this->adminHeaderController($this->langControl('view_request'));



            $c=implode(',',$this->catgUser);



            $stmt = $this->db->prepare("SELECT cart_shop_active.*,register_user.name,register_user.phone,register_user.id FROM `cart_shop_active` INNER JOIN register_user ON register_user.id=cart_shop_active.id_member_r WHERE  cart_shop_active.`accountant` = 1  AND cart_shop_active.`prepared` = 1  AND cart_shop_active.cancel=0 AND cart_shop_active.buy <> 3 AND cart_shop_active.`table`  IN ({$c})   GROUP BY cart_shop_active.`number_bill`,cart_shop_active.`id_member_r`  ORDER BY cart_shop_active.`number_bill` ASC ");
            $stmt->execute();


        $count_active=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row['date_order']=date('Y-m-d h:i A',$row['date_req']);
            $row['id_accountant_user'] = $this->UserInfo($row['id_accountant_user']);
            $count_active[] = $row;

        }


        require($this->render($this->folder, 'html', 'direct3', 'php'));


        $this->adminFooterController2();

    }



    public function back_to()
    {

        $this->checkPermit('back_to',$this->folder);
        $this->adminHeaderController($this->langControl('back_to'));


        if ($this->admin($this->userid))
        {
            $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `accountant` = 1 AND `prepared` = 1 AND  done_direct =0 AND `direct` =3  AND `back_to`=2 GROUP BY `id_member_r`  ORDER BY `date_req` ASC ");
            $stmt->execute();
        }else
        {
            $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   `user_direct` =?  AND `accountant` = 1 AND `prepared` = 1 AND  done_direct =0 AND `direct` =3 AND `back_to`=2  GROUP BY `id_member_r`  ORDER BY `date_req` ASC ");
            $stmt->execute(array($this->userid));
        }

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

        require($this->render($this->folder, 'html', 'back_to', 'php'));

        $this->adminFooterController();

    }



    public function prepared_made()
    {

        $this->checkPermit('prepared_made',$this->folder);
        $this->adminHeaderController($this->langControl('prepared_made'));



        require($this->render($this->folder, 'html', 'active2', 'php'));

        $this->adminFooterController();

    }

    public function prepared_made3()
    {

        $this->checkPermit('prepared_made',$this->folder);
        $this->adminHeaderController($this->langControl('prepared_made'));


        require($this->render($this->folder, 'html', 'active3', 'php'));

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

        if ($this->admin($this->userid)) {

            $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   `accountant` =1 AND `prepared` = 1   AND  done_direct =0 AND  ( `direct` =2  OR `direct` =0   )  AND number_bill <> 0  GROUP BY `id_member_r`");
            $stmt->execute();
        }else
        {
            $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE    ( `user_direct`=? OR  `direct` = 0 )  AND `accountant` = 1 AND `prepared` =1 AND  done_direct =0 AND  ( `direct` =2 OR `direct` =0   )  AND number_bill <> 0 GROUP BY `id_member_r`");
            $stmt->execute(array($this->userid));
        }

        $count_active=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $count_active[]=$row;
        }
        return count($count_active);

    }

    public function all_notification_buy3()
    {



            $c=implode(',',$this->catgUser);



            $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE    `accountant` =1  AND   (  `prepared` = 1  OR  `prepared` = 0 )    AND number_bill <> 0  AND `cancel`=0  AND `table`  IN ({$c})   GROUP BY `number_bill`");
            $stmt->execute(array($this->userid));

//            $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  ( `user_direct`=? OR  `direct` = 0 )   AND `accountant` =1  AND   (  `prepared` = 1  OR  `prepared` = 0 )   AND ( `direct` =3  OR `direct` =0   ) AND number_bill <> 0  AND `cancel`=0  AND `table`  IN ({$c})   GROUP BY `number_bill`");
//            $stmt->execute(array($this->userid));


        $count_active=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $count_active[]=$row;
        }
        return count($count_active);

    }

    public function all_notification_buy3_new()
    {







            $c=implode(',',$this->catgUser);


//
//
//            $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  ( `user_direct`=? OR  `direct` = 0 )   AND `accountant` = 0 AND (  `prepared` = 1  OR  `prepared` = 0 ) AND  done_direct =0 AND ( `direct` =3  OR `direct` =0   ) AND number_bill <> 0  AND `cancel`=0  AND `table`  IN ({$c})   GROUP BY `number_bill`");
//            $stmt->execute(array($this->userid));
//


            $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   buy <> 0 AND   `accountant` = 0    AND `cancel`=0  AND number_bill <> 0  AND `cancel`=0  AND `table`  IN ({$c})   GROUP BY `number_bill`");
            $stmt->execute(array($this->userid));

        $count_active=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $count_active[]=$row;
        }

        return count($count_active);

    }



    public function all_notification_buy3_acount()
    {






            $c=implode(',',$this->catgUser);


//
//
//            $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  ( `user_direct`=? OR  `direct` = 0 )   AND `accountant` = 0 AND (  `prepared` = 1  OR  `prepared` = 0 ) AND  done_direct =0 AND ( `direct` =3  OR `direct` =0   ) AND number_bill <> 0  AND `cancel`=0  AND `table`  IN ({$c})   GROUP BY `number_bill`");
//            $stmt->execute(array($this->userid));
//


            $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE    `accountant` = 1  AND  prepared =1 AND `cancel`=0  AND number_bill <> 0   AND `table`  IN ({$c})   GROUP BY `number_bill`");
            $stmt->execute(array($this->userid));


        $count_active=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $count_active[]=$row;
        }

        echo count($count_active);

    }






    public function all_notification_buy3back()
    {


            $c=implode(',',$this->catgUser);

            $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE     `accountant` = 1 AND  (  `prepared` = 1  OR  `prepared` = 0 )   AND   `back_to`=0 AND `cancel`=0  AND number_bill <> 0  AND `cancel`=0  AND `table`  IN ({$c})   GROUP BY `number_bill`");
            $stmt->execute();


//            $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  ( `user_direct`=? OR  `direct` = 0 )   AND `accountant` = 1 AND  (  `prepared` = 1  OR  `prepared` = 0 )  AND  done_direct =0 AND  ( `direct` =3  OR `direct` =0   )  AND `cancel`=0   AND number_bill <> 0  GROUP BY `id_member_r`");
//            $stmt->execute(array($this->userid));


        $count_active=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $count_active[]=$row;
        }
        return count($count_active);

    }

    public function notification_order()
    {


// // old code
//             $c=implode(',',$this->catgUser);

//             $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE      `accountant` = 1 AND  (  `prepared` = 1  OR  `prepared` = 0 )   AND `table`  IN ({$c})   AND number_bill <> 0  GROUP BY `id_member_r`");
//             $stmt->execute(array($this->userid));




// //            $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE    (`user_direct` =?  OR `direct` =0   )  AND `accountant` = 1 AND  (  `prepared` = 1  OR  `prepared` = 0 )  AND  done_direct =0 AND  ( `direct` =2  OR `direct` =0   )    AND number_bill <> 0  GROUP BY `id_member_r`");
// //            $stmt->execute(array($this->userid));

//         $count_active=array();
//         while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
//         {
//             $count_active[]=$row;
//         }
//        echo  count($count_active);
 
//     H27
//     11/6/2022
    	$c=implode(',',$this->catgUser);
        $stmt = $this->db->prepare("SELECT count( DISTINCT id_member_r ) as count FROM `cart_shop_active` WHERE      `accountant` = 1 AND  (  `prepared` = 1  OR  `prepared` = 0 )   AND `table`  IN ({$c})   AND number_bill <> 0  ");
        $stmt->execute(array());
        $row =$stmt->fetch(PDO::FETCH_ASSOC);
        echo  $row['count'];
    

    }


    public function notification_order3()
    {



//  // old code
//             $c=implode(',',$this->catgUser);

//             $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE    buy <> 0 AND   `accountant` = 0    AND `cancel`=0  AND number_bill <> 0  AND `cancel`=0   AND `table`  IN ({$c})   AND number_bill <> 0  GROUP BY `number_bill`,`id_member_r`");
//             $stmt->execute(array($this->userid));




// //            $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE    (`user_direct` =?  OR `direct` =0   )  AND `accountant` = 1 AND  (  `prepared` = 1  OR  `prepared` = 0 )  AND  done_direct =0 AND  ( `direct` =2  OR `direct` =0   )    AND number_bill <> 0  GROUP BY `id_member_r`");
// //            $stmt->execute(array($this->userid));

//         $count_active=array();
//         while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
//         {
//             $count_active[]=$row;
//         }
//         echo  count($count_active);
// /////
    
//     H27
//     11/6/2022
    
    	$c=implode(',',$this->catgUser);

        $stmt = $this->db->prepare("SELECT count( DISTINCT number_bill ) as count FROM `cart_shop_active` WHERE buy <> 0 AND `accountant` = 0 AND `cancel`=0 AND `cancel`=0 AND `table` IN ({$c})  ");
        $stmt->execute(array());
        $row =$stmt->fetch(PDO::FETCH_ASSOC);
        echo  $row['count'];
    }



    public function notification_order3backto()
    {
//  // old code
//         $c=implode(',',$this->catgUser);


//         $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE       `accountant` = 1 AND  `prepared` = 1     AND `cancel`=0  AND number_bill <> 0  AND `table`  IN ({$c})   GROUP BY `number_bill`");
//         $stmt->execute();

//         $count_active=array();
//         while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
//         {
//             $count_active[]=$row;
//         }
//        echo  count($count_active);
//        
//        
//     H27
//     11/6/2022
     	$c=implode(',',$this->catgUser);
		$stmt = $this->db->prepare("SELECT count( DISTINCT number_bill ) as count FROM `cart_shop_active` WHERE `accountant` = 1 AND `prepared` = 1 AND `cancel`=0 AND number_bill <> 0  AND `table` IN ({$c}) ");
        $stmt->execute();
		$row =$stmt->fetch(PDO::FETCH_ASSOC);
        echo  $row['count'];
    }



    function setBill($id,$number_bill,$code)
    {


        $stmt=$this->getAllContentFromCar_number_bill($id,$number_bill,$code);

        $price1=0;
        $p1=0;
        $p2=0;
        $xp1=0;
        $xp2=0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {


				if (!empty($this->cuts($row['id_item'],$row['table']))) {
					$price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
					$price1 = (int)trim(str_replace(',', '', $price[0]));
				}else {
					$price =$this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']);
					$price1 = (int)trim(str_replace(',', '', $price));
				}



        }


        $stmt = $this->db->prepare("UPDATE  `bill` SET `userid_prepared`=? , `minus_bill`=`minus_bill` + ?, minus=1    WHERE `id_member_r`=? AND `number_bill`=? ");
        $stmt->execute(array($this->userid, $price1, $id, $number_bill));

        if ($stmt->rowCount() > 0)
        {

            echo $price1;
        }

    }
    public function getAllContentFromCar_number_bill($id_member_r,$number_bill,$code)
    {
        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx`,`number_bill`,`top`,`dollar_exchange` FROM `cart_shop_active` WHERE `id_member_r` =? AND number_bill =? AND  `code`=?  LIMIT 1  ");
        $stmt->execute(array($id_member_r,$number_bill,$code));
        return $stmt;
    }


    public  function view_order($id,$n_bill)
    {

        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('view_order',$this->folder);



        $categ=array();
        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
        $stmt_cat->execute(array($this->userid));

        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
        {

            if ($row['catg'] =='savers')
            {
                $row['catg']='product_savers';
            }

            $categ[]=$row['catg'];
        }



        $stmt=$this->db->prepare("SELECT *FROM `register_answer` WHERE `id_user`=?");
        $stmt->execute(array($id));
        $answer=$stmt->fetch(PDO::FETCH_ASSOC);


        $id_user = $id;
        $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ?    LIMIT 1");
        $stmt->execute(array($id_user));
        $result = $stmt->fetch();



		$stmtCar=$this->getAllContentFromCar($id,$n_bill);
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
		$xpd=0;
		$number_type=0;
		$sum_material=0;
		$price_dollars=0;
		$list_serial=array();
        $notebill=null;
        while ($row = $stmtCar->fetch(PDO::FETCH_ASSOC))
        {
            $notebill=$row['note_prepared'];
			if (!empty($row['enter_serial']))
			{
				$list_serial[$row['code']]=$row['enter_serial'];
			}




            if ($row['offers'] == 'offers') {

                $price = $this->priceDollarOffer($row['id_offer'], 4);

            }else
            {
                if ($this->check_item_round($row['table'],$row['id_item'])) {
                    $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
                }else
                {
                    $price = $this->not_round_price($row['price_dollars'], $row['dollar_exchange']);
                }
            }

                  $row['price']=  $price.' د.ع ';


                $f1 = (int)trim(str_replace(',', '', $price));
                $xp1 = $xp1 + ($f1 * $row['number']);
                $price1= number_format($xp1);


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

            $stmt_serial = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND `serial_flag` = 1   LIMIT 1");
            $stmt_serial->execute(array($row['id_item']));
            if ($stmt_serial->rowCount() > 0)
            {
                $row['serial_flag']=1;
            }else{
                $row['serial_flag']=0;
            }


            $date_req[$row['date_req']]=$row['date_req'];



            $row['color_name']=$row['name_color'];


            $row['location']=$this->get_location($row['table'],$row['code'],null);


            if ($this->chPrp($id_user,$row['code'],$n_bill,$row['table'],1))
			{
				$row['prepared']=1;
			}

            $row['listSerial']=$this->getSerialCode($row['code'],$row['number'],$row['table']);
            $request[]=$row;
        }
        $date_req=json_encode($date_req);

		$html_list=null;
		foreach( $list_serial as $key => $list)
		{
			$html_list.=$key.':'.$list.';';
		}
		$html_list= rtrim($html_list,';');







        $requestPrint=array();

        $price1_Offer=0;
        $price1_normal=0;
        $price1Offer=0;
        $xp1Offer=0;
        $xpdOffer=0;
        $number_typeOffer=0;
        $sum_materialOffer=0;
        $price_dollarsOffer=0;



        $stmtOffer = $this->db->prepare("SELECT  cart_shop_active.* FROM `cart_shop_active` WHERE  `id_member_r` =?  AND `accountant`=1 AND `number_bill`=?  AND id_offer <> 0 AND offers = 'offers' GROUP BY  `date_offer`  ORDER BY `id` DESC   ");
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



        $stmtOffer = $this->db->prepare("SELECT  cart_shop_active.*,SUM(number) as number FROM `cart_shop_active` WHERE  `id_member_r` =?  AND `accountant`=1 AND `number_bill`=?  AND id_offer = 0  AND offers = ''  GROUP BY  `id_item`,`table`,`code`,`color`,`number_bill`,price_type   ORDER BY `id` DESC  ");
        $stmtOffer->execute(array($id,$number_bill));

        while ($row = $stmtOffer->fetch(PDO::FETCH_ASSOC))
        {



            $table=$row['table'];
            $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
            $stmt_get_item->execute(array($row['id_item']));
            $item = $stmt_get_item->fetch();

            $row['title']=$item['title'];
            $row['img']=$this->save_file.$row['image'];





            if ($row['offers'] == 'offers') {

                $price = $this->priceDollarOffer($row['id_offer'], 4);

            }else
            {
                if ($this->check_item_round($row['table'],$row['id_item'])) {
                    $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
                }else
                {
                    $price = $this->not_round_price($row['price_dollars'], $row['dollar_exchange']);
                }
            }

            $row['price']=  $price.' د.ع ';



            $f1 = (int)trim(str_replace($this->comma, '', $price));
            $xp1Offer = $xp1Offer + ($f1 * $row['number']);
            $price1_normal=  ($xp1Offer);



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



    function chPrp($id_member_r,$code,$number_bill,$table,$p)
	{
//		$stmt = $this->db->prepare("SELECT  COALESCE(SUM(`number`),0) as number   FROM `cart_shop_active` WHERE `id_member_r` =? AND `code`=?   AND `number_bill`=? AND `table`=? AND `accountant`=1 AND `prepared`=? ");
//		$stmt->execute(array($id_member_r,$code,$number_bill,$table,$p));
//		 if ($stmt->rowCount() > 0)
//		 {
//		 	$result=$stmt->fetch(PDO::FETCH_ASSOC);
//		 	return 4;
//		 }else
//		 {
//		 	return 0;
//		 }
//

		 $stmt = $this->db->prepare("SELECT wr_prepared  FROM `cart_shop_active` WHERE `id_member_r` =? AND `code`=?   AND `number_bill`=? AND `table`=? AND `accountant`=1 AND `prepared`=? ");
		$stmt->execute(array($id_member_r,$code,$number_bill,$table,$p));
		 if ($stmt->rowCount() > 0)
		 {
		 	$result=$stmt->fetch(PDO::FETCH_ASSOC);
		 	return $result['wr_prepared'];
		 }else
		 {
		 	return 0;
		 }
	}


    /*
    *هذه الدالة تتحقق اذا كانت الفئة لواصق
    *create by NAI
    * 2022/07/04
    */
    public function check_id_catge($id){

        $stmt_name_catg_acc = $this->db->prepare("SELECT * FROM `category_accessories` WHERE id = ? LIMIT 1");
        $stmt_name_catg_acc->execute(array($id));


        if ($stmt_name_catg_acc->rowCount() > 0){
            $row_name_catg_acc = $stmt_name_catg_acc->fetch(PDO::FETCH_ASSOC);
            if($row_name_catg_acc['title'] == 'اللواصق'){
                $this->result = 1;
            }elseif(($row_name_catg_acc['title'] != 'اللواصق')&& ($row_name_catg_acc ['relid'] == 0)){
                $this->result = 0;
            }else{
                $this->check_id_catge($row_name_catg_acc['relid']);
            }
        }
        return  $this->result;
    }


    public  function view_order3($id,$n_bill)
    {

        if (!is_numeric($id)) {$error=new Errors(); $error->index();}


        $id_user = $id;
        $stmt2 = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ?    LIMIT 1");
        $stmt2->execute(array($id_user));
        $result = $stmt2->fetch(PDO::FETCH_ASSOC);


        $stmtCar=$this->getAllContentFromCar3($id,$n_bill);
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
		$xpd=0;
		$number_type=0;
		$sum_material=0;
		$price_dollars=0;
		$list_serial=array();
        $notebill=null;
        while ($row = $stmtCar->fetch(PDO::FETCH_ASSOC))
        {
            $notebill=$row['note_prepared'];
			if (!empty($row['enter_serial']))
			{
				$list_serial[$row['code']]=$row['enter_serial'];
			}





            if ($row['offers'] == 'offers') {

                $price = $this->priceDollarOffer($row['id_offer'], 4);

            }else
            {
                if ($this->check_item_round($row['table'],$row['id_item'])) {
                    $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
                }else
                {
                    $price = $this->not_round_price($row['price_dollars'], $row['dollar_exchange']);
                }
            }



            $row['price']=$price.' د.ع ';



			$f1 = (int)trim(str_replace(',', '', $price));
            $xp1 = $xp1 + ($f1 * $row['number']);
            $price1= number_format($xp1);



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


            $stmt_serial = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND `serial_flag` = ?   LIMIT 1");
            $stmt_serial->execute(array($row['id_item'],1));
            if ($stmt_serial->rowCount() > 0)
            {
                $row['serial_flag']=1;
            }else{
                $row['serial_flag']=0;
            }

            if($row['table'] == 'product_savers'){
                $id_device =  $item['id_device'];
                $name_device= $this->type_device($id_device,'type_device');
                $row['name_device'] =  $name_device;
                $name_device_customer= $this->type_device_customer($id_device,$number_bill,'type_device');
                $row['name_device_customer'] =  $name_device_customer;

            }

            if($row['table'] == 'accessories'){
                $result_check = $this->check_id_catge($item['id_cat']);
                if($result_check == 1){
                    $id_catg_acc =  $item['id_cat'];
                    $name_categ_acc= $this->type_device($id_catg_acc,'category_accessories');
                    $row['name_categ_acc'] =  $name_categ_acc;

                    $name_categ_acc_customer= $this->type_device_customer($id_catg_acc,$number_bill,'category_accessories');
                    $row['name_categ_acc_customer'] =  $name_categ_acc_customer;
                }else{
                    $row['name_categ_acc'] = '';
                    $row['name_categ_acc_customer'] = '';
                }
            }


            $date_req[$row['date_req']]=$row['date_req'];

            $row['color_name']=$row['name_color'];


            $row['location']=$this->get_location($row['table'],$row['code'],null);

            if ($this->chPrp($id_user,$row['code'],$n_bill,$row['table'],1))
			{
				$row['prepared']=1;
			}



            $row['listSerial']=$this->getSerialCode($row['code'],$row['number'],$row['table']);

            $request[]=$row;
        }
        $date_req=json_encode($date_req);


        $html_list=null;
        foreach( $list_serial as $key => $list)
		{
			$html_list.=$key.':'.$list.';';
		}
        $html_list= rtrim($html_list,';');

		//$price1=$this->outPrice($price1);




        $requestPrint=array();


        $price1_Offer=0;
        $price1_normal=0;
        $xp1Offer=0;
        $xpdOffer=0;
        $number_typeOffer=0;
        $sum_materialOffer=0;
        $price_dollarsOffer=0;



        $stmtOffer = $this->db->prepare("SELECT  cart_shop_active.*  FROM `cart_shop_active` WHERE  `id_member_r` =?    AND `number_bill`=? AND `accountant`=1   AND id_offer <> 0 AND offers = 'offers' GROUP BY  `date_offer`  ORDER BY `id` DESC  ");
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


            if($row['table'] == 'product_savers'){
                $id_device =  $item['id_device'];
                $name_device= $this->type_device($id_device,'type_device');
                $row['name_device'] =  $name_device;
                $name_device_customer= $this->type_device_customer($id_device,$number_bill,'type_device');
                $row['name_device_customer'] =  $name_device_customer;

            }

            if($row['table'] == 'accessories'){
                $result_check = $this->check_id_catge($item['id_cat']);
                if($result_check == 1){
                    $id_catg_acc =  $item['id_cat'];
                    $name_categ_acc= $this->type_device($id_catg_acc,'category_accessories');
                    $row['name_categ_acc'] =  $name_categ_acc;

                    $name_categ_acc_customer= $this->type_device_customer($id_catg_acc,$number_bill,'category_accessories');
                    $row['name_categ_acc_customer'] =  $name_categ_acc_customer;
                }else{
                    $row['name_categ_acc'] = '';
                    $row['name_categ_acc_customer'] = '';
                }
            }


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



        $stmtOffer = $this->db->prepare("SELECT  cart_shop_active.*,SUM(number) as number FROM `cart_shop_active` WHERE `id_member_r` =?    AND `number_bill`=? AND `accountant`=1  AND id_offer = 0  AND offers = ''  GROUP BY  `id_item`,`table`,`code`,`color`,`number_bill`,price_type   ORDER BY `id` DESC  ");
        $stmtOffer->execute(array($id,$number_bill));

        while ($row = $stmtOffer->fetch(PDO::FETCH_ASSOC))
        {



            $table=$row['table'];
            $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
            $stmt_get_item->execute(array($row['id_item']));
            $item = $stmt_get_item->fetch();

            $row['title']=$item['title'];
            $row['img']=$this->save_file.$row['image'];





            if ($row['offers'] == 'offers') {

                $price = $this->priceDollarOffer($row['id_offer'], 4);

            }else
            {
                if ($this->check_item_round($row['table'],$row['id_item'])) {
                    $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
                }else
                {
                    $price = $this->not_round_price($row['price_dollars'], $row['dollar_exchange']);
                }

            }


            $row['price']=$price.' د.ع ';

            $f1 = (int)trim(str_replace($this->comma, '', $price));
            $xp1Offer = $xp1Offer + ($f1 * $row['number']);
            $price1_normal=  ($xp1Offer);



            $pd=explode('-',$row['price_dollars'])  ;
            $f1d= (double)trim(str_replace(',','.', $pd[0]));
            $xpdOffer = $xpdOffer + ($f1d * $row['number']);
            $price_dollarsOffer= $xpdOffer;
            $number_typeOffer=$number_typeOffer+1;
            $sum_materialOffer=$sum_materialOffer+$row['number'];

            $date=$row['date'];
            $number_bill=$row['number_bill'];

            if($row['table'] == 'product_savers'){
                $id_device =  $item['id_device'];
                $name_device= $this->type_device($id_device,'type_device');
                $row['name_device'] =  $name_device;
                $name_device_customer= $this->type_device_customer($id_device,$number_bill,'type_device');
                $row['name_device_customer'] =  $name_device_customer;
            }
            if($row['table'] == 'accessories'){
                $result_check = $this->check_id_catge($item['id_cat']);
                if($result_check == 1){
                    $id_catg_acc =  $item['id_cat'];
                    $name_categ_acc= $this->type_device($id_catg_acc,'category_accessories');
                    $row['name_categ_acc'] =  $name_categ_acc;

                    $name_categ_acc_customer= $this->type_device_customer($id_catg_acc,$number_bill,'category_accessories');
                    $row['name_categ_acc_customer'] =  $name_categ_acc_customer;
                }else{
                    $row['name_categ_acc'] = '';
                    $row['name_categ_acc_customer'] = '';
                }
            }


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


        require($this->render($this->folder, 'html', 'order3backto', 'php'));

    }

    public  function view_orderBackto($id,$n_bill)
    {

        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('view_order',$this->folder);



        $categ=array();
        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
        $stmt_cat->execute(array($this->userid));

        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
        {

            if ($row['catg'] =='savers')
            {
                $row['catg']='product_savers';
            }

            $categ[]=$row['catg'];
        }



        $stmt=$this->db->prepare("SELECT *FROM `register_answer` WHERE `id_user`=?");
        $stmt->execute(array($id));
        $answer=$stmt->fetch(PDO::FETCH_ASSOC);


        $id_user = $id;
        $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ?    LIMIT 1");
        $stmt->execute(array($id_user));
        $result = $stmt->fetch();



        $stmt=$this->getAllContentFromCar3Backto($id,$n_bill);
        $request=array();

        $sum=0;
        $number_bill=0;
        $date_req=array();
        $price1=0;
        $date=0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

            $f1=(int)trim($row['price']);
            $price1=$price1+ ($f1 * $row['number'] );
            $date=date('Y-m-d',$row['date']);
            $number_bill=$row['number_bill'];
            $table=$row['table'];
            $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
            $stmt_get_item->execute(array($row['id_item']));
            $item = $stmt_get_item->fetch();

            $row['title']=$item['title'];
            $row['img']=$this->save_file.$row['image'];


            $stmt_serial = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND `serial_flag`  = ?  LIMIT 1");
            $stmt_serial->execute(array($row['id_item'],1));
            if ($stmt_serial->rowCount() > 0)
            {
                $row['serial_flag']=1;
            }else{
                $row['serial_flag']=0;
            }



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

            $row['location']=$this->get_location($row['table'],$row['code'],null);




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

        require($this->render($this->folder, 'html', 'order3backto', 'php'));

    }

    public function getAllContentFromCarNotAccount($id_member_r,$number_bill)
    {

        $stmt = $this->db->prepare("SELECT  cart_shop_active.*,SUM(`number`)as number  FROM `cart_shop_active` WHERE `id_member_r` =?  AND `accountant`=0 AND `number_bill`=? GROUP BY   `id_item`,`table`,`code`,`number_bill`,price_type,id_offer     ");
        $stmt->execute(array($id_member_r,$number_bill));
        return $stmt;
    }
    public function getAllContentFromCar($id_member_r,$number_bill)
    {

        $stmt = $this->db->prepare("SELECT  cart_shop_active.*,SUM(`number`)as number   FROM `cart_shop_active` WHERE `id_member_r` =?  AND `accountant`=1 AND `number_bill`=? GROUP BY   `id_item`,`table`,`code`,`number_bill`,price_type,id_offer   ");
        $stmt->execute(array($id_member_r,$number_bill));
        return $stmt;
    }

    public function getAllContentFromCar3($id_member_r,$number_bill)
    {

        $stmt = $this->db->prepare("SELECT  cart_shop_active.*,SUM(`number`)as number FROM `cart_shop_active` WHERE `id_member_r` =?    AND `number_bill`=? AND `accountant`=1 GROUP BY  `id_item`,`table`,`code`,`number_bill`,price_type,id_offer    ");
        $stmt->execute(array($id_member_r,$number_bill));
        return $stmt;
    }

  /*  public function getAllContentFromCar3Tajhez($id_member_r,$number_bill,$table,$code,$name_color)
    {

        $stmt = $this->db->prepare("SELECT  cart_shop_active.*,SUM(`number`)as number FROM `cart_shop_active` WHERE `id_member_r` =?    AND `number_bill`=? AND `table`=? AND `code`=?  GROUP BY  `id_item`,`table`,`code`,`number_bill`,price_type,id_offer   ORDER BY `id` DESC  ");
        $stmt->execute(array($id_member_r,$number_bill,$table,$code));
        return $stmt;
    }
*/

    public function getAllContentFromCar3Backto($id_member_r,$number_bill)
    {

        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx`,`number_bill` ,`id_member_r`,`prepared`,`dollar_exchange` FROM `cart_shop_active` WHERE `id_member_r` =?  AND `accountant`=1 AND `number_bill`=? GROUP BY  `id_item`,`table`,`code`,`number_bill`,price_type,id_offer   ORDER BY `id` DESC  ");
        $stmt->execute(array($id_member_r,$number_bill));
        return $stmt;
    }



    function processing_request($id)
    {
        if ($this->handleLogin()) {
            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }
            $this->checkPermit('processing_request', $this->folder);
            $date_req = $_GET['date_req'];
            $number_bill = $_GET['number_bill'];
            $date_req = implode(',', $date_req);
            $stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `status` = 1 ,  `prepared` = 1 , `date_prepared`= ? , `user_id`=? WHERE `number_bill` =? AND `buy` = ?  AND `id_member_r`=?  AND `date_req` IN ($date_req)  ");
            $stmt2->execute(array(time(), $_SESSION['userid'],$number_bill, 1, $id));

            if ($stmt2->rowCount() > 0) {
                echo 1;
            } else {
                echo 0;
            }
        }else{
            echo 'login';
        }
    }






    public  function order($id)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}

        $id_user = $id;
        $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ?    LIMIT 1");
        $stmt->execute(array($id_user));
        $result = $stmt->fetch();

        $stmt=$this->db->prepare("SELECT *FROM `register_answer` WHERE `id_user`=?");
        $stmt->execute(array($id));
        $answer=$stmt->fetch(PDO::FETCH_ASSOC);


        $stmt_date_req_done=$this->getAllContentFromCar_details_client_direct2($id);
        $date_req_done=array();
        while ($row_d =$stmt_date_req_done->fetch(PDO::FETCH_ASSOC))
        {
            $row_d['sum']=0;
            $row_d[$row_d['number_bill']]=array();
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




         require($this->render($this->folder, 'html', 'order02', 'php'));

    }




    public  function order2($id)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}

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
                        $f1 = (double)trim(str_replace(',', '', $price[0]));
                        $xp1 = $xp1 + ($f1 * $row['number']);
                        $price1= number_format(round($xp1));

                    }else {
						$price =$this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']);
						$f1 = (int)trim(str_replace(',', '', $price));
						$xp1 = $xp1 + ($f1 * $row['number']);
						$price1= number_format(round($xp1));

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




    function  cancel_order($id,$n_bill,$id_member_r=0)
    {

        $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   number_bill =?  ");
        $stmtt->execute(array($n_bill));
        $oldData=array();
        while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
        {
            $oldData[]=$rowt;
        }


        $stmt = $this->db->prepare("UPDATE  `cart_shop_active` SET `cancel`=1 ,`date_cancel`=? WHERE   `accountant` = 1 AND `user_direct` = ? AND  number_bill =?   ");
        $stmt->execute(array(time(),$id,$n_bill));
        if ($stmt->rowCount() >0)
        {

			if ($_SESSION['direct']==2) {
				$accountant = new Accountant();
				$accountant->retrieve_item(array(
					'id_item' => '',
					'id_cart' => '',
					'number_bill' => $n_bill,
					'code' => '',
					'color' => '',
					'image' => '',
					'price' => '',
					'table' => '',
					'id_user' => $this->userid,
					'dollar_exchange' => '',
					'type' => 'cancel',
					'date' => time(),
					'number' => 1,
					'id_customer' => $id_member_r,

				));

			}



			$stmt1 = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`dollar_exchange` FROM `cart_shop_active` WHERE    `accountant` = 1 AND `user_direct` = ? AND  number_bill =?   GROUP BY `id_item`,`size`,`table`,`code`,`user_direct`, number_bill ");
            $stmt1->execute(array($id,$n_bill));
            while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {

                $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE    number_bill =?  ");
                $stmtt->execute(array($n_bill));
                $newData=array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                {
                    $newData[]=$rowt;
                }

                $trace = new trace(); $trace->addtrace('cart_shop_active','الغاء الطلب من قبل المحاسب المباشر  او المجهز المباشر بعد المحاسبة والتجهيز - رقم الفاتورة '.$n_bill,json_encode($oldData),json_encode($newData),'الغاء الطلب من قبل المحاسب المباشر  او المجهز المباشر  بعد المحاسبة والتجهيز ',$n_bill);

                $table=$row['table'];
                if ($table=='mobile')
                {
                    $excel='excel';
                    $model=$table;
                }else if ($table == 'product_savers')
                {
                    $excel='excel_savers';
                    $model='savers';
                }else
                {
                    $excel='excel_'.$table;
                    $model=$table;
                }


                    $number = $row['number'];
                    $stmt = $this->db->prepare("UPDATE  `{$excel}` SET `quantity`=`quantity` + {$number} WHERE  `code`=?  ");
                    $stmt->execute(array($row['code']));
//                    $stmtc = $this->db->prepare("UPDATE  `location_confirm` SET `quantity`=`quantity` + {$number} WHERE  `code` = ?  AND `model`=?  ");
//                    $stmtc->execute(array($row['code'],$row['table']));



            }


            $stmt = $this->db->prepare("UPDATE `cart_shop_active` SET `status` = 2  , `buy` = 3 , `date_d_r`= ? , `user_id`=?  WHERE   `user_direct` = ? AND  number_bill =?");
            $stmt->execute(array(time(), $_SESSION['userid'], $id,$n_bill));

            if ($stmt->rowCount() > 0) {
                echo 1;
            } else {
                echo 0;
            }

            if ($_SESSION['direct']==3)
            {
                $stmt_sx=$this->db->prepare("UPDATE   `log_accountant` SET money=money - ?  WHERE   id_user=? ");
                $stmt_sx->execute(array($this->sumBill($id,$n_bill),$id));

                $stmt_s=$this->db->prepare("UPDATE   `log_accountant_bill`   SET money= 0   WHERE id_user=? AND number_bill=? ");
                $stmt_s->execute(array($id,$n_bill));
            }


            if ($_SESSION['direct']==2)
            {
                $stmt = $this->db->prepare("UPDATE  `bill` SET `userid_prepared`=? , `minus_bill`=`minus_bill` + ?,minus=1  WHERE `id_member_r`=? AND `number_bill`=? ");
                $stmt->execute(array($this->userid, $this->sumBill($id,$n_bill), $id_member_r, $n_bill));
            }

            $this->AddToTraceByFunction($this->userid,'direct','cancel_order/'.$id.'/'.$n_bill.'/'.$id_member_r);
        }


    }


    function check_money($id_member_r,$n_bill)
	{

	     $sum_bill=(int)str_replace($this->comma,'',$this->sumBillIdCustomer($id_member_r,$n_bill));
		 $amount_admin= (int)str_replace($this->comma,'',$this->sumAllMoney($this->userid));
		 if ($sum_bill > $amount_admin)
		 {
		 	echo 'false';
		 }else
		 {
		 	echo 'true';
		 }


	}




	function check_money_oue_item($table,$code,$id_user)
	{
		if (!is_string($table)) {
			$error = new Errors();
			$error->index();
		}
		if (!is_numeric($id_user)) {
			$error = new Errors();
			$error->index();
		}

			$color = $_GET['color'];
			$number_bill = $_GET['number_bill'];
			$id_row = $_GET['id'];

			$stmt_count_n = $this->db->prepare("SELECT  *FROM `cart_shop_active` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `name_color` = ? AND `number_bill`=?  AND  `prepared`=2 AND `accountant`=1 AND `id`=? LIMIT 1");
			$stmt_count_n->execute(array($table, $code, $id_user, $color, $number_bill,$id_row));

			$price=0;
			if ($stmt_count_n->rowCount() > 0) {

				$result=$stmt_count_n->fetch(PDO::FETCH_ASSOC);
				if (!empty($this->cuts($result['id_item'],$result['table'])))
				{
					$price=  (int)str_replace($this->comma,'',$this->cuts($result['id_item'],$result['table']));
				}else
				{
					$price=(int)str_replace($this->comma,'',$this->price_dollarsAdmin($result['price_dollars'],$result['dollar_exchange']));
				}
				$amount_admin= (int)str_replace($this->comma,'',$this->sumAllMoney($this->userid));


				if ($price > $amount_admin)
				{
					echo 'false';
				}else
				{
					echo 'true';
				}

			}else
			{

				echo 'true';
			}

	}





    function sumBill($id,$n_b)
    {

        $stmt=$this->getAllContentFromCar_byNomberBill($id,$n_b);
        $request=array();

        $sum=0;
        $number_bill=0;
        $date_req=array();
        $price1=0;
        $p1=0;
        $p2=0;
        $xp1=0;
        $xp2=0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

				if (!empty($this->cuts($row['id_item'],$row['table']))) {

					$price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
					$f1 = (double)trim(str_replace(',', '', $price[0]));
					$xp1 = $xp1 + ($f1 * $row['number']);
					$price1=$xp1;

				}else {
					$price =$this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']);
					$f1 = (int)trim(str_replace(',', '', $price));
					$xp1 = $xp1 + ($f1 * $row['number']);
					$price1= $xp1;

				}


		}

        return (int)$price1;
    }



    public function getAllContentFromCar_byNomberBill($id,$n_b)
    {
        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx`,`number_bill`,`top`,`dollar_exchange` FROM `cart_shop_active` WHERE `user_direct` =?  AND  `number_bill` =? AND `accountant`=1 GROUP BY  `id_item`,`table`,`code`,`number_bill`,price_type,id_offer   ORDER BY `id` DESC  ");
        $stmt->execute(array($id,$n_b));
        return $stmt;
    }




    function sumBillIdCustomer($id,$n_b)
    {

		$stmt=$this->getAllContentFromCar_byNomberBill($id,$n_b);
		$request=array();

		$sum=0;
		$number_bill=0;
		$date_req=array();
		$price1=0;
		$p1=0;
		$p2=0;
		$xp1=0;
		$xp2=0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

			if (!empty($this->cuts($row['id_item'],$row['table']))) {

				$price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
				$f1 = (double)trim(str_replace(',', '', $price[0]));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1=$xp1;

			}else {
				$price =$this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']);
				$f1 = (int)trim(str_replace(',', '', $price));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1= $xp1;

			}


		}

		return (int)$price1;

    }



    public function getAllContentFromCar_byNomberBillIdCustomer($id,$n_b)
    {
        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx`,`number_bill`,`top`,`dollar_exchange` FROM `cart_shop_active` WHERE `id_member_r` =?  AND  `number_bill` =? AND `accountant`=1 GROUP BY  `id_item`,`table`,`code`,`number_bill`,price_type,id_offer   ORDER BY `id` DESC  ");
        $stmt->execute(array($id,$n_b));
        return $stmt;
    }










    function loadmore()
    {

        $limit = (intval($_GET['limit']) != 0) ? $_GET['limit'] : 10;
        $offset = (intval($_GET['offset']) != 0) ? $_GET['offset'] : 0;
		$fromDate=strtotime(date('Y-m-d'),time());
		$toDate= time();



		$backDay=strtotime(date("Y-m-d", strtotime("-1 day")) .' 12:00:00 am');
		$toTime= strtotime(date('Y-m-d').' '.$this->setting->get('hour').':05:60 am');

		if (   time() >= strtotime(date('Y-m-d').' 12:00:00 am')  &&  time()  < $toTime && $this->setting->get('hour') !=0 )
		{
			if ($this->admin($this->userid))
			{
				$stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   `accountant` = 1 AND `prepared` = 2 AND  done_direct =1 AND  ( `direct` =2  OR direct=0 )  AND `cancel`=0 AND date_prepared between  ? AND  ? GROUP BY `id_member_r`  ORDER BY `number_bill` DESC LIMIT $limit OFFSET $offset");
				$stmt->execute(array($backDay,$toDate));

			}else{
				$stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   `accountant` = 1 AND `prepared` = 2 AND  done_direct =1 AND  ( `direct` =2  OR direct=0 )   AND  (`user_direct` =? OR direct=0 )  AND `cancel`=0  AND date_prepared between ? AND  ? GROUP BY `id_member_r`  ORDER BY `number_bill` DESC LIMIT $limit OFFSET $offset");
				$stmt->execute(array($this->userid,$backDay,$toDate));

			}
		}else
		{


			if ($this->admin($this->userid))
			{
				$stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   `accountant` = 1 AND `prepared` = 2 AND  done_direct =1 AND  ( `direct` =2  OR direct=0 )  AND `cancel`=0 AND date_prepared between  ? AND  ? GROUP BY `id_member_r`  ORDER BY `number_bill` DESC LIMIT $limit OFFSET $offset");
				$stmt->execute(array($toTime,$toDate));

			}else{
				$stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   `accountant` = 1 AND `prepared` = 2 AND  done_direct =1 AND ( `direct` =2  OR direct=0 )  AND (`user_direct` =? OR direct=0 )  AND `cancel`=0  AND date_prepared between ? AND  ? GROUP BY `id_member_r`  ORDER BY `number_bill` DESC LIMIT $limit OFFSET $offset");
				$stmt->execute(array($this->userid,$toTime,$toDate));

			}
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

				$count_active .= "
                <a class='infoCustomer ifactive' id='row{$row_user['id']}' href='#' onclick='getOrder({$row_user['id']})'>
                      <div>{$row_user['name']}  ({$row['number_bill']})  </div>
                        <div   style='direction: ltr;'>{$phone}</div>
                    </a>
                                    
                ";
            }

        }

            echo  $count_active;


    }




    function loadmore3()
    {

        $limit = (intval($_GET['limit']) != 0) ? $_GET['limit'] : 10;
        $offset = (intval($_GET['offset']) != 0) ? $_GET['offset'] : 0;

		$fromDate=strtotime(date('Y-m-d'),time());
		$toDate= time();



		$backDay=strtotime(date("Y-m-d", strtotime("-1 day")) .' 12:00:00 am');
		$toTime= strtotime(date('Y-m-d').' '.$this->setting->get('hour').':05:60 am');

		if (   time() >= strtotime(date('Y-m-d').' 12:00:00 am')  &&  time()  < $toTime && $this->setting->get('hour') !=0 )
		{
			if ($this->admin($this->userid))
			{
				$stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   `accountant` = 1 AND `prepared` = 2 AND  done_direct =1 AND (  `direct` =3 OR `direct` = 0   )   AND `cancel`=0 AND `date_prepared` between ? AND  ? GROUP BY `id_member_r`   ORDER BY `number_bill` ASC LIMIT $limit OFFSET $offset");
				$stmt->execute(array($backDay,$toDate));

			}else{
				$stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   `accountant` = 1 AND `prepared` = 2 AND  done_direct =1 AND   (  `direct` =3 OR `direct` = 0   )   AND `cancel`=0   AND ( `user_direct`=? OR  `direct` = 0 ) AND date_prepared between  ? AND  ? GROUP BY `id_member_r`  ORDER BY `number_bill` ASC LIMIT $limit OFFSET $offset");
				$stmt->execute(array($this->userid,$backDay,$toDate));

			}

		}else
		{


			if ($this->admin($this->userid))
			{
				$stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   `accountant` = 1 AND `prepared` = 2 AND  done_direct =1 AND (  `direct` =3 OR `direct` = 0   )  AND `cancel`=0 AND `date_prepared` between ? AND  ? GROUP BY `id_member_r`   ORDER BY `number_bill` ASC LIMIT $limit OFFSET $offset");
				$stmt->execute(array($toTime,$toDate));

			}else{
				$stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   `accountant` = 1 AND `prepared` = 2 AND  done_direct =1 AND (  `direct` =3 OR `direct` = 0   )  AND `cancel`=0   AND  ( `user_direct`=? OR  `direct` = 0 )  AND date_prepared between  ? AND  ? GROUP BY `id_member_r`  ORDER BY `number_bill` ASC LIMIT $limit OFFSET $offset");
				$stmt->execute(array($this->userid,$toTime,$toDate));

			}

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

                $count_active.="
                <a class='infoCustomer ifactive' id='row{$row_user['id']}' href='#' onclick='getOrder({$row_user['id']})'>
                       <div>{$row_user['name']}  ({$row['number_bill']})  </div>
                       <div   style='direction: ltr;'>{$phone}</div>
                    </a>
                                    
                ";
            }

        }

            echo  $count_active;


    }





    public function getAllContentFromCar_details_client_done_groupByDate_req($id_member_r)
    {
        $stmt = $this->db->prepare("SELECT  * FROM `cart_shop_active` WHERE `id_member_r` =?  AND  `prepared`=2   AND `cancel`=0  AND (  `direct` =3 OR `direct` = 0   )    GROUP BY   `number_bill`  ORDER BY `date` DESC   ");

        $stmt->execute(array($id_member_r));
        return $stmt;
    }



    public function getAllContentFromCar_details_client_direct2($id_member_r)
    {
        $stmt = $this->db->prepare("SELECT   * FROM `cart_shop_active` WHERE `id_member_r` =?  AND  `prepared`=2   AND `cancel`=0  AND `direct`=2 GROUP BY   `number_bill`  ORDER BY `id` DESC   ");

        $stmt->execute(array($id_member_r));
        return $stmt;
    }


    public function getAllContentFromCar_details_client_done($id_member_r,$number_bill)
    {
        $stmt = $this->db->prepare("SELECT  cart_shop_active.*,SUM(`number`)as number  FROM `cart_shop_active` WHERE `id_member_r` =?  AND   `prepared` = 2     AND `number_bill`= ? GROUP BY `id_item`,`table`,`code`,`number_bill`,price_type  ORDER BY `id` DESC  ");
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




    function tajhezxxx()
    {

        $id_cart=$_GET['id_cart'];
        $id=$_GET['id'];
        $id_user=$_GET['id_user'];
        $serial=$_GET['serial'];
        $table=$_GET['table'];

        $stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `done_direct` = 1, `buy` = 2 ,  `prepared` = 2 , `date_prepared`= ?  , `user_direct`=?, `serial`=? WHERE `id`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=?  ");
        $stmt2->execute(array(time(), $this->userid,$serial, $id_cart, $id_user,$table,$id));
        if ($stmt2->rowCount() > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }



    function tajhez($id_user,$code,$number_bill,$back=0)
    {


        if (  !$this->check_model_code_and_serial($code) ){
        $stmt=$this->db->prepare("SELECT id,id_member_r,id_item,`table`,SUM(number) as number,name_color FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=?  AND `prepared`=1 GROUP BY  code ,name_color HAVING COUNT(number)=COUNT(*)");
        $stmt->execute(array($id_user,$code,$number_bill));
        if ($stmt->rowCount() > 0) {

            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            $table=$result['table'];


			if ($table=='product_savers')
			{
				$stmt_serial = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?   AND (`locationTag` = 1 OR `enter_serial` = 1)  LIMIT 1");
			}else
			{
				$stmt_serial = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?   AND (`location` = 1 OR `enter_serial` = 1)  LIMIT 1");
			}

			$stmt_serial->execute(array($result['id_item']));
            if ($stmt_serial->rowCount() > 0)
            {

				if ($table=='product_savers')
				{
					$stmt_location = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND  `locationTag` = 1  LIMIT 1");
				}else
				{
					$stmt_location = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND `location` = 1   LIMIT 1");
				}
				$stmt_location->execute(array($result['id_item']));

				if($stmt_location->rowCount() > 0) {


					$stmt_ins13 = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND  `enter_serial` = 1      LIMIT 1");
					$stmt_ins13->execute(array($result['id_item']));
					if($stmt_ins13->rowCount() > 0)
					{
						echo 'Location2_enterSerial#'.$code.'#'.$result['number'].'#'.$result['table']; //write serial
					}
					else
					{

						if ($table=='product_savers')
						{
							$stmt_location = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND  `locationTag` = 1 LIMIT 1");
						}else
						{
							$stmt_location = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND `location` =1  LIMIT 1");
						}

						$stmt_location->execute(array($result['id_item']));

						if($stmt_location->rowCount() > 0)
						{
							echo 'location#'.$code.'#'.$result['table'];
						}
					}

				}else{

					$stmt_ins3 = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?    AND `enter_serial` = 1     LIMIT 1");
					$stmt_ins3->execute(array($result['id_item']));
					if($stmt_ins3->rowCount() > 0)
					{
						echo "enterSerialOnly#".$code.'#'.$result['number'].'#'.$result['table'];//write serial
					}

				}

			}

            else{

                    $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=?");
                    $stmtt->execute(array($number_bill));
                    $oldData=array();
                    while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                    {
                        $oldData[]=$rowt;
                    }



                    $stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `done_direct` = 1, `buy` = 2 ,  `prepared` = 2 , `date_prepared`= ? , `user_direct`=? WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=? AND `number_bill`=?  AND `accountant`=1  ");
                $stmt2->execute(array(time(), $_SESSION['userid'], $code, $id_user,$table,$result['id_item'],$number_bill));
                if ($stmt2->rowCount() > 0) {

                    $this->Add_to_sync_schedule($code,$table,'quantity_adjustment',' ','controllers\direct\direct.php تجهيز 3186 '.$this->UserInfo($this->userid));

                    $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill`=?");
                    $stmtt->execute(array($number_bill));
                    $newData=array();
                    while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                    {
                        $newData[]=$rowt;
                    }

                    $trace = new trace(); $trace->addtrace('cart_shop_active','تجهيز مواد الفاتورة من قبل المجهز المباشر',json_encode($oldData),json_encode($newData),'  تجهيز الفاتورة رقم ' . $number_bill,$number_bill);

                    echo $code;
                }

            }
        }else
        {



            //  التحقق من الباركود البديل
            $stmtpage = $this->db->prepare("SELECT  * FROM spare_code   WHERE spare_code=? LIMIT 1");
            $stmtpage->execute(array($code));
            if ($stmtpage->rowCount() > 0) {

                $result = $stmtpage->fetch(PDO::FETCH_ASSOC);
                $code = $result['code'];

                $stmt=$this->db->prepare("SELECT  * FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=?  AND `prepared`=1  ");
                $stmt->execute(array($id_user,$code,$number_bill));
                if ($stmt->rowCount() > 0) {
                    $this->tajhez($id_user, $code, $number_bill, 0);

                }else
                {
                    echo 'notFoundCode';
                }

            } else {
                echo 'notFoundCode';
            }



        }
        }else {



            $stmt=$this->db->prepare("SELECT  id,id_member_r,id_item,`table`,SUM(number) as number,name_color FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=? AND `prepared`=1 GROUP BY  code ,name_color HAVING COUNT(number)=COUNT(*)");
            $stmt->execute(array($id_user,$code,$number_bill));
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $table = $result['table'];

                if ($table == 'product_savers') {
                    $stmt_location = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND  `locationTag` = 1 LIMIT 1");
                } else {
                    $stmt_location = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND `location` =1  LIMIT 1");
                }
                $stmt_location->execute(array($result['id_item']));

                if ($stmt_location->rowCount() > 0) {

                    echo 'Location2_enterSerial#'.$code.'#'.$result['number'].'#'.$result['table']; //write serial

                }else
                {
                    echo "enterSerialOnly#".$code.'#'.$result['number'].'#'.$result['table'];//write serial
                }

            }else {

                echo 'notFoundCode';
            }




        }







    }



    function location()
    {

        $id_user=$_POST['id_user'];
        $code=$_POST['code'];
        $number_bill=$_POST['number_bill'];
        //		$location=$_POST['alixcol'];
        $location=array_filter(explode('+',ltrim(rtrim(trim($_POST['location']),'+'),'+')));


        $stmt=$this->db->prepare("SELECT   cart_shop_active.*, SUM(`number`)as number  FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=? AND `prepared` = 1 ");
        $stmt->execute(array($id_user,$code,$number_bill));
        if ($stmt->rowCount() > 0) {
            $result=$stmt->fetch(PDO::FETCH_ASSOC);

            $table=$result['table'];


            if ($table=='product_savers')
            {
                $tableLocation= 'savers';
            }else
            {
                $tableLocation= $table;
            }



            $numberOrder= (int)$result['number'] - (int)$result['wr_prepared'] ;
			$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill`=?");
			$stmtt->execute(array($number_bill));
			$oldData=array();
			while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
			{
				$oldData[]=$rowt;
			}
			$slot=null;

			foreach ($location as   $value) {
                $value=trim($value);
				$slot .= "'$value',";
			}
			$lot = rtrim($slot, ',');

				$stmt_location_sum = $this->db->prepare("SELECT  SUM(quantity)   as q  FROM `location` WHERE location IN({$lot}) AND code = ? AND `model` = ? LIMIT 1");
				$stmt_location_sum->execute(array($code,$tableLocation));


			$rloct=$stmt_location_sum->fetch(PDO::FETCH_ASSOC);
			$checkx=$rloct['q'];
			if($numberOrder <= $checkx)
			{

				$x=0;
                $passLocation=true;
				foreach ($location as $key => $lx)
				{

                    $lx=trim($lx);
                    if (!in_array($lx,$this->hide_location())) {
						$stmt_location_one = $this->db->prepare("SELECT   quantity  FROM `location` WHERE location = ? AND code = ? AND `model` = ?  LIMIT 1");
						$stmt_location_one->execute(array($lx,$code,$tableLocation));
						$rone=$stmt_location_one->fetch(PDO::FETCH_ASSOC);
						$quantity=$rone['quantity'];
						if ($numberOrder >= $quantity && $numberOrder > 0)
						{
							$x=$quantity;
						}
						else if ($numberOrder > 0)
						{
							$x = $numberOrder;
						}
						if ($numberOrder > 0)
						{

							$stmt_location = $this->db->prepare("UPDATE   `location` SET `quantity`=quantity-?,`userid`=?,`date`=?    WHERE location =? AND code = ? AND `model` = ?   LIMIT 1");
							$stmt_location->execute(array($x,$this->userid,time(),$lx,$code,$tableLocation));

                            if($stmt_location->rowCount()  > 0)
                            {
                                $this->filter_location_tracking_quantity($code,$tableLocation,$lx,$x,'  تجهيز الطلب بائع ومجهز - رقم5','-',$number_bill);

                            }else
                            {
                                $this->filter_location_error_quantity($code,$tableLocation,$lx,$x,'   تجهيز الطلب بائع ومجهز  - رقم الخطا 5','-',$number_bill);

                            }





                            $stmtCheck_trans = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND location = ? ");
                            $stmtCheck_trans->execute(array($code, $tableLocation,$lx));
                            if ($stmtCheck_trans->rowCount() > 0) {


                                $stmtfx1 = $this->db->prepare("UPDATE    location_transport SET  quantity=quantity-?  WHERE   code=?  AND model=? AND location = ?");
                                $stmtfx1->execute(array($x,$code, $tableLocation,$lx));
                                $stmtCheck_trans_q = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND location = ?  AND  quantity <= 0 ");
                                $stmtCheck_trans_q->execute(array($code, $tableLocation,$lx));
                                if ($stmtCheck_trans_q->rowCount() > 0) {

                                    $stmtCheck_trans_de = $this->db->prepare("DELETE  FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND location = ?  AND  quantity <= 0 ");
                                    $stmtCheck_trans_de->execute(array($code, $tableLocation,$lx));
                                }


                            }
						}
						$numberOrder=$numberOrder - $x;

                    $location[$key]=$lx;
                    }else
                    {

                        $passLocation=false;
                        echo 'hide_location#'.$result['table'];//  الكمية المطلوبة امبر من الموجودة في   الموقع
                    }
				}

                if ($passLocation) {
                    $location = array_unique(array_merge(explode(',', $result['location']), $location), SORT_REGULAR); // التجهيز الذكي

                    $stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `done_direct` = 1, `buy` = 2 ,  `prepared` = 2 , `date_prepared`= ? , `user_direct`=?,location=? WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=? AND `number_bill`=?  AND `accountant`=1  ");
                    $stmt2->execute(array(time(), $_SESSION['userid'], implode(',', $location), $code, $id_user, $table, $result['id_item'], $number_bill));
                    if ($stmt2->rowCount() > 0) {
                        $this->Add_to_sync_schedule($code,$table,'quantity_adjustment',' ','controllers\direct\direct.php تجهيز ذكي 3378 '.$this->UserInfo($this->userid));
                        $stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=?");
                        $stmtt->execute(array($number_bill));
                        $newData = array();
                        while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
                            $newData[] = $rowt;
                        }
                        $trace = new trace();
                        $trace->addtrace('cart_shop_active', 'مجهز مباشر - تجهيز الفاتورة ' . $number_bill, json_encode($oldData), json_encode($newData), ' تجهيز الفاتورة بعد المحاسبة من قبل محاسب الكاشير -بستخدام الموقع ولسيريل', $number_bill);

                        echo $code;
                    }
                }
			}else
			{
				echo 'not_enough#'.$result['table'];//  الكمية المطلوبة امبر من الموجودة في   الموقع
			}


        }else
        {
            echo 'notFoundCode#';
        }

        $this->AddToTraceByFunction($this->userid,'direct','location/'.$id_user.'/'.$code.'/'.$number_bill);

    }





/*
    function enter_serial()
    {

        $id_user=$_POST['id_user'];
        $code=$_POST['code'];
        $number_bill=$_POST['number_bill'];
        $serial=$_POST['serial'];


        $stmt=$this->db->prepare("SELECT  `id`, `id_item`,`size`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number ,`dollar_exchange`   FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=?");
        $stmt->execute(array($id_user,$code,$number_bill));
        if ($stmt->rowCount() > 0) {
            $result=$stmt->fetch(PDO::FETCH_ASSOC);

			$numberOrder= $result['number'] ;
            $table=$result['table'];

            $c_serial=$this->serialChecked($serial,$table,$code,$result['name_color']);

            if ($c_serial =="true")
            {

                if (isset($_POST['location'])) {



					$location=$_POST['alixcol'];



					$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=?");
					$stmtt->execute(array($number_bill));
					$oldData=array();
					while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
					{
						$oldData[]=$rowt;
					}
					$slot=null;

					foreach ($location as   $value) {
						$slot .= "'$value',";
					}
					$lot = rtrim($slot, ',');
					if ($table =='accessories')
					{
						$stmt_location_sum = $this->db->prepare("SELECT  SUM(quantity) as q  FROM `location` WHERE location IN({$lot}) AND code = ? AND `model` = ? AND color =? LIMIT 1");
						$stmt_location_sum->execute(array($code,$table,$result['name_color']));
					}else{
						$stmt_location_sum = $this->db->prepare("SELECT  SUM(quantity)   as q  FROM `location` WHERE location IN({$lot}) AND code = ? AND `model` = ? LIMIT 1");
						$stmt_location_sum->execute(array($code,$table));
					}

					$rloct=$stmt_location_sum->fetch(PDO::FETCH_ASSOC);
					$checkx=$rloct['q'];
					if($numberOrder <= $checkx)
					{

						$x=0;
						foreach ($location as $lx)
						{
							if ($table =='accessories')
							{
								$stmt_location_one = $this->db->prepare("SELECT   quantity  FROM `location` WHERE location = ? AND code = ? AND `model` = ? AND color =? LIMIT 1");
								$stmt_location_one->execute(array($lx,$code,$table,$result['name_color']));
								$rone=$stmt_location_one->fetch(PDO::FETCH_ASSOC);
								$quantity=$rone['quantity'];
								if ($numberOrder >= $quantity && $numberOrder > 0)
								{
									$x=$quantity;
								}
								else if ($numberOrder > 0)
								{
									$x = $numberOrder;
								}
								if ($numberOrder > 0)
								{
									$stmt_location = $this->db->prepare("UPDATE   `location` SET `quantity`=quantity-?    WHERE location =? AND code = ? AND `model` = ?   AND `color` = ?   LIMIT 1");
									$stmt_location->execute(array($x,$lx,$code,$table,$result['name_color']));
								}
								$numberOrder=$numberOrder - $x;
							}else
							{
								$stmt_location_one = $this->db->prepare("SELECT   quantity  FROM `location` WHERE location = ? AND code = ? AND `model` = ?  LIMIT 1");
								$stmt_location_one->execute(array($lx,$code,$table));
								$rone=$stmt_location_one->fetch(PDO::FETCH_ASSOC);
								$quantity=$rone['quantity'];
								if ($numberOrder >= $quantity && $numberOrder > 0)
								{
									$x=$quantity;
								}
								else if ($numberOrder > 0)
								{
									$x = $numberOrder;
								}
								if ($numberOrder > 0)
								{

									$stmt_location = $this->db->prepare("UPDATE   `location` SET `quantity`=quantity-?    WHERE location =? AND code = ? AND `model` = ?   LIMIT 1");
									$stmt_location->execute(array($x,$lx,$code,$table));
								}
								$numberOrder=$numberOrder - $x;
							}

						}



						$stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `done_direct` = 1, `buy` = 2 ,  `prepared` = 2 , `date_prepared`= ? , `user_direct`=?,serial=? WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=? AND `number_bill`=? AND `accountant`=1");
						$stmt2->execute(array(time(), $_SESSION['userid'],$serial, $code, $id_user,$table,$result['id_item'],$number_bill));
						if ($stmt2->rowCount() > 0) {


							$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=?");
							$stmtt->execute(array($number_bill));
							$newData=array();
							while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
							{
								$newData[]=$rowt;
							}

							$trace = new trace(); $trace->addtrace('cart_shop_active','مجهز مباشر - تجهيز الفاتورة '.$number_bill,json_encode($oldData),json_encode($newData),' تجهيز الفاتورة بعد المحاسبة من قبل محاسب الكاشير -بستخدام الموقع ولسيريل',$number_bill);
							echo $code;
						}


					}else
					{
						echo 'not_enough';//  الكمية المطلوبة امبر من الموجودة في   الموقع
					}


                }else{


                    $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=?");
                    $stmtt->execute(array($number_bill));
                    $oldData=array();
                    while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                    {
                        $oldData[]=$rowt;
                    }



                    $stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `done_direct` = 1, `buy` = 2 ,  `prepared` = 2 , `date_prepared`= ? , `user_direct`=?,serial=? WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=? AND `number_bill`=? AND `accountant`=1");
                    $stmt2->execute(array(time(), $_SESSION['userid'],$serial, $code, $id_user,$table,$result['id_item'],$number_bill));
                    if ($stmt2->rowCount() > 0) {




                        $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=?");
                        $stmtt->execute(array($number_bill));
                        $newData=array();
                        while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                        {
                            $newData[]=$rowt;
                        }
                        $trace = new trace(); $trace->addtrace('cart_shop_active','مجهز مباشر - تجهيز الفاتورة '.$number_bill,json_encode($oldData),json_encode($newData),' تجهيز الفاتورة بعد المحاسبة من قبل محاسب الكاشير - استخدم موقع المادة',$number_bill);

                        echo $code;
                    }

                }

            }else
            {
                echo 'notFoundSerial';
            }

        }else
        {
            echo 'notFoundCode';
        }
    }

*/




	function enterSerial2location()
	{

		$id_user=$_POST['id_user'];
		$code=$_POST['code'];
		$number_bill=$_POST['number_bill'];
        $enter_serial=$_POST['enter_serial'];
        if (is_array($enter_serial))
        {
            $enter_serial=implode(',',$enter_serial);
        }


        $stmt=$this->db->prepare("SELECT  cart_shop_active.*,SUM(`number`)as number    FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=? AND prepared = 1");
		$stmt->execute(array($id_user,$code,$number_bill));
		if ($stmt->rowCount() > 0) {
			$result=$stmt->fetch(PDO::FETCH_ASSOC);
			$table=$result['table'];

            if ($table=='product_savers')
            {
                $tableLocation= 'savers';
            }else
            {
                $tableLocation= $table;
            }

            $numberOrder= (int)$result['number'] - (int)$result['wr_prepared'] ;

			if (isset($_POST['serial']) && isset($_POST['location']))
			{

				$serial=$_POST['serial'];
				$c_serial=$this->serialChecked($serial,$table,$code,$result['name_color']);


				if ($c_serial =="true")
				{


					if (isset($_POST['location'])) {


                        //		$location=$_POST['alixcol'];
                        $location=array_filter(explode('+',ltrim(rtrim(trim($_POST['location']),'+'),'+')));


                        $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=?");
						$stmtt->execute(array($number_bill));
						$oldData=array();
						while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
						{
							$oldData[]=$rowt;
						}
						$slot=null;


						foreach ($location as   $value) {
							$slot .= trim("'$value',");
						}
					  	$lot = rtrim($slot, ',');

							$stmt_location_sum = $this->db->prepare("SELECT  SUM(quantity)   as q  FROM `location` WHERE location IN($lot) AND code = ? AND `model` = ? LIMIT 1");
							$stmt_location_sum->execute(array($code,$tableLocation));


						$rloct=$stmt_location_sum->fetch(PDO::FETCH_ASSOC);
						   $checkx=$rloct['q'];
						if($numberOrder <= $checkx)
						{

							$x=0;
                            $passLocation=true;
							foreach ($location as $key => $lx)
							{
                                $lx=trim($lx);
                                if (!in_array($lx,$this->hide_location())) {
                                    $stmt_location_one = $this->db->prepare("SELECT   quantity  FROM `location` WHERE location = ? AND code = ? AND `model` = ?  LIMIT 1");
                                    $stmt_location_one->execute(array($lx, $code, $tableLocation));
                                    $rone = $stmt_location_one->fetch(PDO::FETCH_ASSOC);
                                    $quantity = $rone['quantity'];
                                    if ($numberOrder >= $quantity && $numberOrder > 0) {
                                        $x = $quantity;
                                    } else if ($numberOrder > 0) {
                                        $x = $numberOrder;
                                    }

                                    if ($numberOrder > 0) {

                                        $stmt_location = $this->db->prepare("UPDATE   `location` SET `quantity`=quantity-? ,`userid`=?,`date`=?   WHERE location =? AND code = ? AND `model` = ?   LIMIT 1");
                                        $stmt_location->execute(array($x,$this->userid,time(), $lx, $code, $tableLocation));

                                        if($stmt_location->rowCount()  > 0)
                                        {
                                            $this->filter_location_tracking_quantity($code,$tableLocation,$lx,$x,'  تجهيز الطلب بائع ومجهز - رقم6','-',$number_bill);

                                        }else
                                        {
                                            $this->filter_location_error_quantity($code,$tableLocation,$lx,$x,'   تجهيز الطلب بائع ومجهز  - رقم الخطا 6','-',$number_bill);

                                        }

                                        $stmtCheck_trans = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND location = ? ");
                                        $stmtCheck_trans->execute(array($code, $tableLocation,$lx));
                                        if ($stmtCheck_trans->rowCount() > 0) {


                                            $stmtfx1 = $this->db->prepare("UPDATE    location_transport SET  quantity=quantity-?  WHERE   code=?  AND model=? AND location = ?");
                                            $stmtfx1->execute(array($x,$code, $tableLocation,$lx));
                                            $stmtCheck_trans_q = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND location = ?  AND  quantity <= 0 ");
                                            $stmtCheck_trans_q->execute(array($code, $tableLocation,$lx));
                                            if ($stmtCheck_trans_q->rowCount() > 0) {

                                                $stmtCheck_trans_de = $this->db->prepare("DELETE  FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND location = ?  AND  quantity <= 0 ");
                                                $stmtCheck_trans_de->execute(array($code, $tableLocation,$lx));
                                            }


                                        }
                                    }
                                    $numberOrder = $numberOrder - $x;

                                    $location[$key] = $lx;
                                }else
                                {

                                    $passLocation=false;
//                                    echo 'hide_location#'.$result['table'];//  الكمية المطلوبة امبر من الموجودة في   الموقع
                                    echo 'hide_location';//  الكمية المطلوبة امبر من الموجودة في   الموقع
                                }
							}
                            if ($passLocation) {
                                $location = array_unique(array_merge(explode(',', $result['location']), $location), SORT_REGULAR); // التجهيز الذكي

                                $stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `buy` = 2 ,  `prepared` = 2 , `date_prepared`= ? , `user_direct`=?,`serial`=?,`enter_serial`=?,location=? WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=?  AND `number_bill`=?  AND `accountant`=1 AND `prepared`=1 ");
                                $stmt2->execute(array(time(), $_SESSION['userid'], $serial, $enter_serial, implode(',', $location), $code, $id_user, $table, $result['id_item'], $number_bill));
                                if ($stmt2->rowCount() > 0) {
                                    $this->Add_to_sync_schedule($code, $table,'quantity_adjustment',' ','controllers\direct\direct.php 3712 '.$this->UserInfo($this->userid));
                                    echo $code;
                                }

                                $stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=?");
                                $stmtt->execute(array($number_bill));
                                $newData = array();
                                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
                                    $newData[] = $rowt;
                                }

                                $trace = new trace();
                                $trace->addtrace('cart_shop_active', 'تجهيز الفاتورة', json_encode($oldData), json_encode($newData), ' تجهيز عناصر الفاتورة من قبل المجهز  المباشر ', $number_bill);

                            }
						}else
						{
//                            echo 'not_enough#'.$result['table'];//  الكمية المطلوبة امبر من الموجودة في   الموقع
							echo 'not_enough';//  الكمية المطلوبة امبر من الموجودة في   الموقع
						}

					}

				}else
				{
//					echo 'notFoundSerial';
					echo 'notFoundSerial';
				}


			}else  if (isset($_POST['serial']))
			{


				$serial=$_POST['serial'];
				$c_serial=$this->serialChecked($serial,$table,$code,$result['name_color']);

				if ($c_serial =="true")
				{

					$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill`=?");
					$stmtt->execute(array($number_bill));
					$oldData=array();
					while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
					{
						$oldData[]=$rowt;
					}

					$stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `buy` = 2 ,  `prepared` = 2 , `date_prepared`= ? , `user_direct`=?,`serial`=?,`enter_serial`=? WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=? AND `number_bill`=?  AND `accountant`=1 AND `prepared`=1 ");
					$stmt2->execute(array(time(), $_SESSION['userid'],$serial,$enter_serial, $code , $id_user,$table,$result['id_item'],$number_bill));
					if ($stmt2->rowCount() > 0) {
                        $this->Add_to_sync_schedule($code,$table,'quantity_adjustment',' ','controllers\direct\direct.php 3763 '.$this->UserInfo($this->userid));
						$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill`=?");
						$stmtt->execute(array($number_bill));
						$newData=array();
						while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
						{
							$newData[]=$rowt;
						}

						$trace = new trace(); $trace->addtrace('cart_shop_active','تجهيز الفاتورة',json_encode($oldData),json_encode($newData),' تجهيز عناصر الفاتورة من قبل المجهز بستخدام السيريال ',$number_bill);

						echo $code;
					}

				}else
				{
					echo 'notFoundSerial';
				}




			}else if (isset($_POST['location']))
			{


				$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=?");
				$stmtt->execute(array($number_bill));
				$oldData=array();
				while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
				{
					$oldData[]=$rowt;
				}
				$slot=null;

                //		$location=$_POST['alixcol'];
                $location=array_filter(explode('+',ltrim(rtrim(trim($_POST['location']),'+'),'+')));

                foreach ($location as   $value) {
                    $value=trim($value);
                    $slot .= "'$value',";
				}
				$lot = rtrim($slot, ',');

					$stmt_location_sum = $this->db->prepare("SELECT  SUM(quantity)   as q  FROM `location` WHERE location IN({$lot}) AND code = ? AND `model` = ? LIMIT 1");
					$stmt_location_sum->execute(array($code,$tableLocation));

				$rloct=$stmt_location_sum->fetch(PDO::FETCH_ASSOC);
				$checkx=$rloct['q'];
				if($numberOrder <= $checkx)
				{

					$x=0;
                    $passLocation=true;
					foreach ($location as $key=> $lx)
					{
                        $lx=trim($lx);
                        if (!in_array($lx,$this->hide_location())) {
                            $stmt_location_one = $this->db->prepare("SELECT   quantity  FROM `location` WHERE location = ? AND code = ? AND `model` = ?  LIMIT 1");
                            $stmt_location_one->execute(array($lx, $code, $tableLocation));
                            $rone = $stmt_location_one->fetch(PDO::FETCH_ASSOC);
                            $quantity = $rone['quantity'];
                            if ($numberOrder >= $quantity && $numberOrder > 0) {
                                $x = $quantity;
                            } else if ($numberOrder > 0) {
                                $x = $numberOrder;
                            }
                            if ($numberOrder > 0) {

                                $stmt_location = $this->db->prepare("UPDATE   `location` SET `quantity`=quantity-? ,`userid`=?,`date`=?  WHERE location =? AND code = ? AND `model` = ?   LIMIT 1");
                                $stmt_location->execute(array($x,$this->userid,time(), $lx, $code, $tableLocation));
                                if($stmt_location->rowCount()  > 0)
                                {
                                    $this->filter_location_tracking_quantity($code,$tableLocation,$lx,$x,'  تجهيز الطلب بائع ومجهز - رقم7','-',$number_bill);

                                }else
                                {
                                    $this->filter_location_error_quantity($code,$tableLocation,$lx,$x,'   تجهيز الطلب بائع ومجهز  - رقم الخطا 7','-',$number_bill);

                                }

                                $stmtCheck_trans = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND location = ? ");
                                $stmtCheck_trans->execute(array($code, $tableLocation,$lx));
                                if ($stmtCheck_trans->rowCount() > 0) {


                                    $stmtfx1 = $this->db->prepare("UPDATE    location_transport SET  quantity=quantity-?  WHERE   code=?  AND model=? AND location = ?");
                                    $stmtfx1->execute(array($x,$code, $tableLocation,$lx));
                                    $stmtCheck_trans_q = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND location = ?  AND  quantity <= 0 ");
                                    $stmtCheck_trans_q->execute(array($code, $tableLocation,$lx));
                                    if ($stmtCheck_trans_q->rowCount() > 0) {

                                        $stmtCheck_trans_de = $this->db->prepare("DELETE  FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND location = ?  AND  quantity <= 0 ");
                                        $stmtCheck_trans_de->execute(array($code, $tableLocation,$lx));
                                    }


                                }
                            }
                            $numberOrder = $numberOrder - $x;

                            $location[$key] = $lx;
                        }else
                        {

                            $passLocation=false;
//                            echo 'hide_location#'.$result['table'];//  الكمية المطلوبة امبر من الموجودة في   الموقع
                            echo 'hide_location';//  الكمية المطلوبة امبر من الموجودة في   الموقع
                        }
					}

                    if ($passLocation) {
                        $location = array_unique(array_merge(explode(',', $result['location']), $location), SORT_REGULAR); // التجهيز الذكي

                        $stmt_enter_serial = $this->db->prepare("UPDATE `cart_shop_active` SET    `buy` = 2 ,  `prepared` = 2 , `date_prepared`= ? , `user_direct`=?,`enter_serial`=? ,location=? WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=? AND `number_bill`=?  AND `accountant`=1 AND `prepared`=1 ");
                        $stmt_enter_serial->execute(array(time(), $_SESSION['userid'], $enter_serial, implode(',', $location), $code, $id_user, $table, $result['id_item'], $number_bill));
                        if ($stmt_enter_serial->rowCount() > 0) {
                            $this->serial_moves($enter_serial,$code,$number_bill,$table,'sale');
                            $this->Add_to_sync_schedule($code, $table,'quantity_adjustment',' ','controllers\direct\direct.php 3872 '.$this->UserInfo($this->userid));
                            $stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=?");
                            $stmtt->execute(array($number_bill));
                            $newData = array();
                            while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
                                $newData[] = $rowt;
                            }

                            $trace = new trace();
                            $trace->addtrace('cart_shop_active', 'تجهيز الفاتورة', json_encode($oldData), json_encode($newData), ' تجهيز عناصر الفاتورة من قبل المجهز بستخدام السيريال ', $number_bill);

                            echo $code;
                        }
                    }
				}else
				{
//                    echo 'not_enough#'.$result['table'];//  الكمية المطلوبة امبر من الموجودة في   الموقع
					echo 'not_enough';//  الكمية المطلوبة امبر من الموجودة في   الموقع
				}



			}else if($enter_serial) {

				$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill`=?");
				$stmtt->execute(array($number_bill));
				$oldData=array();
				while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
				{
					$oldData[]=$rowt;
				}

				$stmt_enter_serial = $this->db->prepare("UPDATE `cart_shop_active` SET    `buy` = 2 ,  `prepared` = 2 , `date_prepared`= ? , `user_direct`=?,`enter_serial`=? WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=? AND `number_bill`=?  AND `accountant`=1 AND `prepared`=1 ");
				$stmt_enter_serial->execute(array(time(), $_SESSION['userid'],$enter_serial, $code , $id_user,$table,$result['id_item'],$number_bill));
				if ($stmt_enter_serial->rowCount() > 0) {
                    $this->serial_moves($enter_serial,$code,$number_bill,$table,'sale');
                    $this->Add_to_sync_schedule($code,$table,'quantity_adjustment',' ','controllers\direct\direct.php 3907 '.$this->UserInfo($this->userid));
					$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=?");
					$stmtt->execute(array($number_bill));
					$newData=array();
					while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
					{
						$newData[]=$rowt;
					}

					$trace = new trace(); $trace->addtrace('cart_shop_active','تجهيز الفاتورة',json_encode($oldData),json_encode($newData),' تجهيز عناصر الفاتورة من قبل المجهز  المباشر   ',$number_bill);

					echo $code;
				}

			}

		}else
		{
			echo 'notFoundCode';
		}

        $this->AddToTraceByFunction($this->userid,'direct','enterSerial2location');

	}











	function serialChecked($serial,$table,$code,$color)
    {
        if ($this->handleLogin())
        {
            $serial = '[[:<:]]'.$serial.'[[:>:]]';
            if ($table=='mobile')
            {
                $stmt_serial = $this->db->prepare("SELECT *FROM `code`  WHERE `code` = ? AND `serial`  REGEXP ?  LIMIT 1");
                $stmt_serial->execute(array($code,$serial));
                if ($stmt_serial->rowCount() > 0)
                {
                    return 'true';
                }else{
                    return 'false';
                }

            }else if ($table=='accessories') {

                $stmt_serial = $this->db->prepare("SELECT *FROM `color_accessories` WHERE id = ? AND color =? AND `serial`  REGEXP ?  LIMIT 1");
                $stmt_serial->execute(array($code,$color,$serial));
                if ($stmt_serial->rowCount() > 0)
                {
                    return 'true';
                }else{
                    return 'false';
                }

            }else
            {
                $tableCode='code_'.$table;

                $stmt_serial = $this->db->prepare("SELECT *FROM `{$tableCode}`  WHERE `code` = ? AND `serial`  REGEXP ?  LIMIT 1");
                $stmt_serial->execute(array($code,$serial));
                if ($stmt_serial->rowCount() > 0)
                {
                    return 'true';
                }else{
                    return 'false';
                }
            }


        }


    }




    function tajhez3xxx()
    {

        $id_cart=$_GET['id_cart'];
        $id=$_GET['id'];
        $id_user=$_GET['id_user'];
        $serial=$_GET['serial'];
        $table=$_GET['table'];
        $number_bill=$_GET['number_bill'];


        $stmt = $this->getAllContentFromCar3($id_user,$number_bill);
        $price1 = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $f1 = (int)trim($row['price']);
            $price1 = $price1 + ($f1 * $row['number']);
        }

        $stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `done_direct` = 1, `buy` = 2 ,  `prepared` = 2 ,accountant=1,date_accountant=? ,`date_prepared`= ?  , `user_direct`=?, `serial`=? WHERE `id`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=? AND `number_bill` = ?  ");
        $stmt2->execute(array(time(),time(), $this->userid,$serial, $id_cart, $id_user,$table,$id,$number_bill));


        if ($stmt2->rowCount() > 0) {

            $stmt1=$this->db->prepare("SELECT *FROM  log_accountant  WHERE `id_user` = ? ");
            $stmt1->execute(array($this->userid));
            if ($stmt1->rowCount() > 0)
            {
                $stmt=$this->db->prepare("UPDATE log_accountant SET `money`=money+? ,`date`=? WHERE `id_user` = ?");
                $stmt->execute(array($price1,time(),$this->userid));
            }else{
                $stmt=$this->db->prepare("INSERT INTO log_accountant (`money`,`username`,`id_user`,`date`) values  (?,?,?,?) ");
                $stmt->execute(array($price1,$_SESSION['usernamelogin'],$this->userid,time()));
            }

            $stmt=$this->db->prepare("INSERT INTO log_accountant_bill (`money`,`number_bill`,`username`,`id_user`,`date`) values  (?,?,?,?,?) ");
            $stmt->execute(array($price1,$number_bill,$_SESSION['usernamelogin'],$this->userid,time()));

             echo 1;
        } else {
            echo 0;
        }
    }






	function tajhez3($id_user,$code,$number_bill,$back=0)
	{

        if (!$this->check_model_code_and_serial($code)  ){

		$accountant=false;
		$stmtCh_acco = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE id_member_r=? AND  `code` = ?  AND  `number_bill`=?  AND `accountant`=1  ");
		$stmtCh_acco->execute(array($id_user,$code, $number_bill));
		if($stmtCh_acco->rowCount()>0)
		{
			$accountant=true;
		}

			$stmt = $this->db->prepare("SELECT   id,id_member_r,id_item,`table`,SUM(number) as number,name_color FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=? AND `prepared`=1 AND (`accountant`=0 OR `accountant`=1) GROUP BY  code ,name_color HAVING COUNT(number)=COUNT(*)");
			$stmt->execute(array($id_user, $code, $number_bill));
			if ($stmt->rowCount() > 0) {
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				$table = $result['table'];


				if ($table=='product_savers')
				{
					$stmt_serial = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND   (  `locationTag` = 1  OR `enter_serial` = 1) LIMIT 1");
				}else
				{
					$stmt_serial = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND   (`location` = 1    OR `enter_serial` = 1) LIMIT 1");
				}

				$stmt_serial->execute(array($result['id_item']));
				if ($stmt_serial->rowCount() > 0) {


					if ($table=='product_savers')
					{
						$stmt_location = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND  `locationTag` = 1   LIMIT 1");
					}else
					{
						$stmt_location = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND  `location` = 1   LIMIT 1");
					}
					$stmt_location->execute(array($result['id_item']));

					if($stmt_location->rowCount() > 0) {


						$stmt_ins13 = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND  `enter_serial` = 1      LIMIT 1");
						$stmt_ins13->execute(array($result['id_item']));
						if($stmt_ins13->rowCount() > 0)
						{
							echo 'Location2_enterSerial#'.$code.'#'.$result['number'].'#'.$result['table']; //write serial
						}
						else
						{
							if ($table=='product_savers')
							{
								$stmt_location = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND   `locationTag` = 1   LIMIT 1");
							}else
							{
								$stmt_location = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND `location` =1   LIMIT 1");
							}
							$stmt_location->execute(array($result['id_item']));

							if($stmt_location->rowCount() > 0)
							{
								echo 'location#'.$code.'#'.$result['table'];
							}
						}

					}else{

						$stmt_ins3 = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?    AND `enter_serial` = 1     LIMIT 1");
						$stmt_ins3->execute(array($result['id_item']));
						if($stmt_ins3->rowCount() > 0)
						{
							echo "enterSerialOnly#".$code.'#'.$result['number'].'#'.$result['table'];//write serial
						}

					}


				} else {

						$stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill`=?");
						$stmtt->execute(array($number_bill));
						$oldData = array();
						while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
							$oldData[] = $rowt;
						}



							$stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET  `user_direct`=?,  `done_direct` = 1, `buy` = 2 ,  `prepared` = 2 ,  `date_prepared`= ?   WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=? AND `number_bill` = ? AND `accountant`=1 ");
							$stmt2->execute(array( $this->userid,time(),   $code, $id_user, $table, $result['id_item'], $number_bill));

						if ($stmt2->rowCount() > 0) {


                            $this->Add_to_sync_schedule($code,$table,'quantity_adjustment',' ',' controllers\direct\direct.php 4136 '.$this->UserInfo($this->userid));
							$stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=?");
							$stmtt->execute(array($number_bill));
							$newData = array();
							while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
								$newData[] = $rowt;
							}
							$trace = new trace();
							$trace->addtrace('cart_shop_active', 'تجهيز الطلب من قبل المحاسب المباشر  - تجهيز الفاتورة ' . $number_bill, json_encode($oldData), json_encode($newData), '  تجهيز الطلب من قبل المحاسب المباشر',$number_bill);



							echo $code;
						}

				}
			} else {


                //  التحقق من الباركود البديل
                $stmtpage = $this->db->prepare("SELECT  * FROM spare_code   WHERE spare_code=? LIMIT 1");
                $stmtpage->execute(array($code));
                if ($stmtpage->rowCount() > 0) {

                    $result = $stmtpage->fetch(PDO::FETCH_ASSOC);
                    $code = $result['code'];

                    $stmt=$this->db->prepare("SELECT  * FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=?  AND `prepared`=1  ");
                    $stmt->execute(array($id_user,$code,$number_bill));
                    if ($stmt->rowCount() > 0) {
                        $this->tajhez3($id_user, $code, $number_bill, 0);

                    }else
                    {
                        echo 'notFoundCode';

                    }

                } else {

                    echo 'notFoundCode';
                }


            }
        }else {



            $stmt=$this->db->prepare("SELECT  id,id_member_r,id_item,`table`,SUM(number) as number,name_color FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=? AND `prepared`=1 GROUP BY  code ,name_color HAVING COUNT(number)=COUNT(*)");
            $stmt->execute(array($id_user,$code,$number_bill));
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $table = $result['table'];

                if ($table == 'product_savers') {
                    $stmt_location = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND  `locationTag` = 1 LIMIT 1");
                } else {
                    $stmt_location = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ? AND `location` =1  LIMIT 1");
                }
                $stmt_location->execute(array($result['id_item']));

                if ($stmt_location->rowCount() > 0) {

                    echo 'Location2_enterSerial#'.$code.'#'.$result['number'].'#'.$result['table']; //write serial

                }else
                {
                    echo "enterSerialOnly#".$code.'#'.$result['number'].'#'.$result['table'];//write serial
                }

            }else {

                echo 'notFoundCode';
            }



        }

	}




    function location3()
    {

        $id_user=$_POST['id_user'];
        $code=$_POST['code'];
        $number_bill=$_POST['number_bill'];
        //		$location=$_POST['alixcol'];
        $location=array_filter(explode('+',ltrim(rtrim(trim($_POST['location']),'+'),'+')));




        $accountant=false;
		$stmtCh_acco = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE id_member_r=? AND  `code`=?  AND `number_bill`=?  AND `accountant`=1 ");
		$stmtCh_acco->execute(array($id_user,$code, $number_bill));
		if($stmtCh_acco->rowCount()>0)
		{
			$accountant=true;
		}




		$stmtCx=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=? AND `prepared`=1 AND  (`accountant`=0 OR `accountant`=1)");
		$stmtCx->execute(array($id_user,$code,$number_bill));
		if ($stmtCx->rowCount() > 0) {
			$stmt = $this->db->prepare("SELECT  cart_shop_active.*,SUM(`number`)as number  FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=?");
			$stmt->execute(array($id_user, $code, $number_bill));
			if ($stmt->rowCount() > 0) {
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				$table = $result['table'];


                if ($table=='product_savers')
                {
                    $tableLocation= 'savers';
                }else
                {
                    $tableLocation= $table;
                }



                $numberOrder= (int)$result['number'] - (int)$result['wr_prepared'] ;
				$stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill`=?");
				$stmtt->execute(array($number_bill));
				$oldData = array();
				while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
					$oldData[] = $rowt;
				}
				$slot = null;

				foreach ($location as $value) {
                    $value=trim($value);
                    $slot .= "'$value',";
				}
				$lot = rtrim($slot, ',');

					$stmt_location_sum = $this->db->prepare("SELECT  SUM(quantity)   as q  FROM `location` WHERE location IN({$lot}) AND code = ? AND `model` = ? LIMIT 1");
					$stmt_location_sum->execute(array($code, $tableLocation));

				$rloct = $stmt_location_sum->fetch(PDO::FETCH_ASSOC);
				$checkx = $rloct['q'];
				if ($numberOrder <= $checkx) {

					$x = 0;
                    $passLocation=true;
					foreach ($location as $key => $lx) {
                        $lx=trim($lx);
                        if (!in_array($lx,$this->hide_location())) {
							$stmt_location_one = $this->db->prepare("SELECT   quantity  FROM `location` WHERE location = ? AND code = ? AND `model` = ?  LIMIT 1");
							$stmt_location_one->execute(array($lx, $code, $tableLocation));
							$rone = $stmt_location_one->fetch(PDO::FETCH_ASSOC);
							$quantity = $rone['quantity'];
							if ($numberOrder >= $quantity && $numberOrder > 0) {
								$x = $quantity;
							} else if ($numberOrder > 0) {
								$x = $numberOrder;
							}
							if ($numberOrder > 0) {

								$stmt_location = $this->db->prepare("UPDATE   `location` SET `quantity`=quantity-? ,`userid`=?,`date`=?   WHERE location =? AND code = ? AND `model` = ?   LIMIT 1");
								$stmt_location->execute(array($x,$this->userid,time(), $lx, $code, $tableLocation));

                                if($stmt_location->rowCount()  > 0)
                                {
                                    $this->filter_location_tracking_quantity($code,$tableLocation,$lx,$x,'  تجهيز الطلب بائع ومحاسب ومجهز - رقم8','-',$number_bill);

                                }else
                                {
                                    $this->filter_location_error_quantity($code,$tableLocation,$lx,$x,'   تجهيز الطلب بائع ومحاسب ومجهز  - رقم الخطا 8','-',$number_bill);

                                }

                                $stmtCheck_trans = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND location = ? ");
                                $stmtCheck_trans->execute(array($code, $tableLocation,$lx));
                                if ($stmtCheck_trans->rowCount() > 0) {

                                    $stmtfx1 = $this->db->prepare("UPDATE    location_transport SET  quantity=quantity-?  WHERE   code=?  AND model=? AND location = ?");
                                    $stmtfx1->execute(array($x,$code, $tableLocation,$lx));

                                    $stmtCheck_trans_q = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND location = ?  AND  quantity <= 0 ");
                                    $stmtCheck_trans_q->execute(array($code, $tableLocation,$lx));
                                    if ($stmtCheck_trans_q->rowCount() > 0) {

                                        $stmtCheck_trans_de = $this->db->prepare("DELETE  FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND location = ?  AND  quantity <= 0 ");
                                        $stmtCheck_trans_de->execute(array($code, $tableLocation,$lx));
                                    }

                                }
							}
							$numberOrder = $numberOrder - $x;
                           $location[$key]=$lx;
                        }else
                        {

                            $passLocation=false;
                            echo 'hide_location#'.$result['table'];//  الكمية المطلوبة امبر من الموجودة في   الموقع
                        }
					}

                    if ($passLocation) {
                        $location = array_unique(array_merge(explode(',', $result['location']), $location), SORT_REGULAR); // التجهيز الذكي

                        $stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `done_direct` = 1, `buy` = 2 ,  `prepared` = 2, `date_prepared`= ?  , `user_direct`=? ,location=? WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=? AND `number_bill` = ? AND `accountant`=1 ");
                        $stmt2->execute(array(time(), $this->userid, implode(',', $location), $code, $id_user, $table, $result['id_item'], $number_bill));

                        if ($stmt2->rowCount() > 0) {
                            $this->Add_to_sync_schedule($code, $table,'quantity_adjustment',' ',' controllers\direct\direct.php 4332 '.$this->UserInfo($this->userid));
                            $stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=?");
                            $stmtt->execute(array($number_bill));
                            $newData = array();
                            while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
                                $newData[] = $rowt;
                            }
                            $trace = new trace();
                            $trace->addtrace('cart_shop_active', 'تجهيز الطلب من قبل المحاسب المباشر  - تجهيز الفاتورة ' . $number_bill, json_encode($oldData), json_encode($newData), '  تجهيز الطلب من قبل المحاسب المباشر استخدام مواقع المواد', $number_bill);

                            echo $code;

                        }
                    }
				} else {
					echo 'not_enough#'.$result['table'];//  الكمية المطلوبة امبر من الموجودة في   الموقع
				}


			} else {
				echo 'notFoundCode#';
			}

		}
    }


/*
    function enter_serial3()
    {

        $id_user=$_POST['id_user'];
        $code=$_POST['code'];
        $number_bill=$_POST['number_bill'];
        $serial=$_POST['serial'];

		$accountant=false;
		$stmtCh_acco = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE id_member_r=? AND  `number_bill`=?  AND `accountant`=1 GROUP BY number_bill");
		$stmtCh_acco->execute(array($id_user, $number_bill));
		if($stmtCh_acco->rowCount()>0)
		{
			$accountant=true;
		}

		$stmtCx=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=? AND `prepared`=1 AND  (`accountant`=0 OR `accountant`=1)");
		$stmtCx->execute(array($id_user,$code,$number_bill));
		if ($stmtCx->rowCount() > 0) {
			$stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=? AND `prepared` = 1 ");
			$stmt->execute(array($id_user, $code, $number_bill));
			if ($stmt->rowCount() > 0) {
				$result = $stmt->fetch(PDO::FETCH_ASSOC);

				$table = $result['table'];

				$c_serial = $this->serialChecked($serial, $table, $code, $result['name_color']);

				if ($c_serial == "true") {

					if (isset($_POST['location'])) {
						$location = $_POST['location'];
						if ($table == 'accessories') {
							$stmt_location = $this->db->prepare("SELECT *FROM `location` WHERE location =? AND code = ? AND `model` = ? AND color=? LIMIT 1");
							$stmt_location->execute(array($location, $code, $table, $result['name_color']));
						} else {
							$stmt_location = $this->db->prepare("SELECT *FROM `location` WHERE location =? AND code = ? AND `model` = ?   LIMIT 1");
							$stmt_location->execute(array($location, $code, $table));
						}
						if ($stmt_location->rowCount() > 0) {
							$result_location = $stmt_location->fetch(PDO::FETCH_ASSOC);
							$numberLocation = $result_location['quantity'];

							$numberOrder = $result['number'];


							if ($numberOrder > $numberLocation) {
								echo 'not_enough';//  الكمية المطلوبة امبر من الموجودة في هذا الموقع
							} else {


								$stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill`=?");
								$stmtt->execute(array($number_bill));
								$oldData = array();
								while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
									$oldData[] = $rowt;
								}

								if ($table == 'accessories') {
									$stmt_location = $this->db->prepare("UPDATE  `location` SET `quantity`=quantity-?  WHERE location =? AND code = ? AND `model` = ? AND color=? LIMIT 1");
									$stmt_location->execute(array($numberOrder, $location, $code, $table, $result['name_color']));
								} else {
									$stmt_location = $this->db->prepare("UPDATE   `location` SET `quantity`=quantity-?    WHERE location =? AND code = ? AND `model` = ?   LIMIT 1");
									$stmt_location->execute(array($numberOrder, $location, $code, $table));
								}


								$stmt = $this->getAllContentFromCar3Tajhez($id_user, $number_bill, $table, $code, $result['name_color']);
								$price1 = 0;
								$p1 = 0;
								$p2 = 0;
								$xp1 = 0;
								$xp2 = 0;
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
								$price1 = (int)trim(str_replace($this->comma, '', $price1));


								if($accountant)
								{
									$stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `done_direct` = 1, `buy` = 2 ,  `prepared` = 2 , `date_prepared`= ?  , `user_direct`=?,`serial`=? WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=? AND `number_bill` = ?  ");
									$stmt2->execute(array( time(), $this->userid, $serial, $code, $id_user, $table, $result['id_item'], $number_bill));
								}else{
									$stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `id_accountant_user`=?,`done_direct` = 1, `buy` = 2 ,  `prepared` = 2 ,accountant=1 ,date_accountant=? , `date_prepared`= ?  , `user_direct`=?,`serial`=? WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=? AND `number_bill` = ?  ");
									$stmt2->execute(array($this->userid,time(), time(), $this->userid, $serial, $code, $id_user, $table, $result['id_item'], $number_bill));
								}


								if ($stmt2->rowCount() > 0) {

									$stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill`=?");
									$stmtt->execute(array($number_bill));
									$newData = array();
									while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
										$newData[] = $rowt;
									}

									$trace = new trace();
									$trace->addtrace('cart_shop_active', 'تجهيز الطلب من قبل المحاسب المباشر  - تجهيز الفاتورة ' . $number_bill, json_encode($oldData), json_encode($newData), '  تجهيز الطلب من قبل المحاسب المباشر بستخدام الموقع',$number_bill);


									if ($accountant==false){
										$stmt1 = $this->db->prepare("SELECT *FROM  log_accountant  WHERE `id_user` = ? ");
										$stmt1->execute(array($this->userid));
										if ($stmt1->rowCount() > 0) {
											$stmt = $this->db->prepare("UPDATE log_accountant SET `money`=money+? ,`date`=? WHERE `id_user` = ?");
											$stmt->execute(array($price1, time(), $this->userid));
										} else {
											$stmt = $this->db->prepare("INSERT INTO log_accountant (`money`,`username`,`id_user`,`date`) values  (?,?,?,?) ");
											$stmt->execute(array($price1, $_SESSION['usernamelogin'], $this->userid, time()));
										}

										$stmt1x = $this->db->prepare("SELECT *FROM  log_accountant_bill  WHERE `number_bill` = ? ");
										$stmt1x->execute(array($number_bill));
										if ($stmt1x->rowCount() > 0) {
											$stmtx = $this->db->prepare("UPDATE log_accountant_bill SET `money`=money+? ,`date`=?,`update_uer`=? WHERE `number_bill` = ?");
											$stmtx->execute(array($price1, time(), $this->userid, $number_bill));
										} else {
											$stmtx = $this->db->prepare("INSERT INTO log_accountant_bill (`money`,`number_bill`,`username`,`id_user`,`date`) values  (?,?,?,?,?) ");
											$stmtx->execute(array($price1, $number_bill, $_SESSION['usernamelogin'], $this->userid, time()));
										}

									}

									echo $code;
								}

							}
						} else {

							echo 'notLocation';
						}
					} else {


						$stmt = $this->getAllContentFromCar3Tajhez($id_user, $number_bill, $table, $code, $result['name_color']);
						$price1 = 0;
						$p1 = 0;
						$p2 = 0;
						$xp1 = 0;
						$xp2 = 0;

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
						$price1 = (int)trim(str_replace($this->comma, '', $price1));

						$stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill`=?");
						$stmtt->execute(array($number_bill));
						$oldData = array();
						while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
							$oldData[] = $rowt;
						}


						if($accountant)
						{
							$stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET   `done_direct` = 1, `buy` = 2 ,  `prepared` = 2  , `date_prepared`= ?  , `user_direct`=?,`serial`=? WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=? AND `number_bill` = ?  ");
							$stmt2->execute(array(time(), $this->userid, $serial, $code, $id_user, $table, $result['id_item'], $number_bill));
						}else{
							$stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `id_accountant_user`=?,`done_direct` = 1, `buy` = 2 ,  `prepared` = 2 ,accountant=1,`date_accountant`=?, `date_prepared`= ?  , `user_direct`=?,`serial`=? WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=? AND `number_bill` = ?  ");
							$stmt2->execute(array($this->userid,time(),time(), $this->userid, $serial, $code, $id_user, $table, $result['id_item'], $number_bill));
						}

						if ($stmt2->rowCount() > 0) {


							$stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill`=?");
							$stmtt->execute(array($number_bill));
							$newData = array();
							while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
								$newData[] = $rowt;
							}

							$trace = new trace();
							$trace->addtrace('cart_shop_active', 'تجهيز الطلب من قبل المحاسب المباشر  - تجهيز الفاتورة ' . $number_bill, json_encode($oldData), json_encode($newData), '  تجهيز الطلب من قبل المحاسب المباشر بستخدام الموقع والسيريال',$number_bill);



							if($accountant==false){

								$stmt1 = $this->db->prepare("SELECT *FROM  log_accountant  WHERE `id_user` = ? ");
								$stmt1->execute(array($this->userid));
								if ($stmt1->rowCount() > 0) {
									$stmt = $this->db->prepare("UPDATE log_accountant SET `money`=money+? ,`date`=? WHERE `id_user` = ?");
									$stmt->execute(array($price1, time(), $this->userid));
								} else {
									$stmt = $this->db->prepare("INSERT INTO log_accountant (`money`,`username`,`id_user`,`date`) values  (?,?,?,?) ");
									$stmt->execute(array($price1, $_SESSION['usernamelogin'], $this->userid, time()));
								}

								$stmt1x = $this->db->prepare("SELECT *FROM  log_accountant_bill  WHERE `number_bill` = ? ");
								$stmt1x->execute(array($number_bill));
								if ($stmt1x->rowCount() > 0) {
									$stmtx = $this->db->prepare("UPDATE log_accountant_bill SET `money`=money+? ,`date`=?,`update_uer`=? WHERE `number_bill` = ?");
									$stmtx->execute(array($price1, time(), $this->userid, $number_bill));
								} else {
									$stmtx = $this->db->prepare("INSERT INTO log_accountant_bill (`money`,`number_bill`,`username`,`id_user`,`date`) values  (?,?,?,?,?) ");
									$stmtx->execute(array($price1, $number_bill, $_SESSION['usernamelogin'], $this->userid, time()));
								}

							}


							echo $code;
						}

					}


				} else {
					echo 'notFoundSerial';
				}

			} else {
				echo 'notFoundCode';
			}
		}
    }
*/

	function enterSerial2location3()
	{

		$id_user=$_POST['id_user'];
		$code=$_POST['code'];
		$number_bill=$_POST['number_bill'];
        $enter_serial=$_POST['enter_serial'];
        if (is_array($enter_serial))
        {
            $enter_serial=implode(',',$enter_serial);
        }



        $accountant=false;
		$stmtCh_acco = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE id_member_r=? AND  `code`=?  AND  `number_bill`=?  AND `accountant`=1  ");
		$stmtCh_acco->execute(array($id_user,$code, $number_bill));
		if($stmtCh_acco->rowCount()>0)
		{
			$accountant=true;
		}

		$stmtCx=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=? AND `prepared`=1 AND  (`accountant`=0 OR `accountant`=1)");
		$stmtCx->execute(array($id_user,$code,$number_bill));
		if ($stmtCx->rowCount() > 0) {
			$stmt = $this->db->prepare("SELECT cart_shop_active.*,SUM(`number`)as number   FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=? AND `prepared` = 1");
			$stmt->execute(array($id_user, $code, $number_bill));
			if ($stmt->rowCount() > 0) {
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				$table = $result['table'];


                if ($table=='product_savers')
                {
                    $tableLocation= 'savers';
                }else
                {
                    $tableLocation= $table;
                }



                $numberOrder= (int)$result['number'] - (int)$result['wr_prepared'] ;


				    if (isset($_POST['location'])) {


					$stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill`=?");
					$stmtt->execute(array($number_bill));
					$oldData = array();
					while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
						$oldData[] = $rowt;
					}
					$slot = null;

                    //		$location=$_POST['alixcol'];
                    $location=array_filter(explode('+',ltrim(rtrim(trim($_POST['location']),'+'),'+')));

                    foreach ($location as $value) {
                        $value=trim($value);
                        $slot .= "'$value',";
					}
					$lot = rtrim($slot, ',');

						$stmt_location_sum = $this->db->prepare("SELECT  SUM(quantity)   as q  FROM `location` WHERE location IN({$lot}) AND code = ? AND `model` = ? LIMIT 1");
						$stmt_location_sum->execute(array($code, $tableLocation));

					$rloct = $stmt_location_sum->fetch(PDO::FETCH_ASSOC);
					$checkx = $rloct['q'];
					if ($numberOrder <= $checkx) {

						$x = 0;
                        $passLocation=true;
						foreach ($location as $key => $lx) {
                            $lx=trim($lx);
                            if (!in_array($lx,$this->hide_location())) {
								$stmt_location_one = $this->db->prepare("SELECT   quantity  FROM `location` WHERE location = ? AND code = ? AND `model` = ?  LIMIT 1");
								$stmt_location_one->execute(array($lx, $code, $tableLocation));
								if($stmt_location_one->rowCount() > 0) {
                                    $rone = $stmt_location_one->fetch(PDO::FETCH_ASSOC);
                                    $quantity = $rone['quantity'];
                                    if ($numberOrder >= $quantity && $numberOrder > 0) {
                                        $x = $quantity;
                                    } else if ($numberOrder > 0) {
                                        $x = $numberOrder;
                                    }
                                    if ($numberOrder > 0) {

                                        $stmt_location = $this->db->prepare("UPDATE   `location` SET `quantity`=quantity-?,`userid`=?,`date`=?    WHERE location =? AND code = ? AND `model` = ?   LIMIT 1");
                                        $stmt_location->execute(array($x,$this->userid,time(), $lx, $code, $tableLocation));

                                        if ($stmt_location->rowCount() > 0) {
                                            $this->filter_location_tracking_quantity($code, $tableLocation, $lx, $x, '  تجهيز الطلب بائع ومحاسب ومجهز - رقم9', '-', $number_bill);

                                        } else {
                                            $this->filter_location_error_quantity($code, $tableLocation, $lx, $x, '   تجهيز الطلب بائع ومحاسب ومجهز  - رقم الخطا 9', '-', $number_bill);

                                        }

                                        $stmtCheck_trans = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND location = ? ");
                                        $stmtCheck_trans->execute(array($code, $tableLocation, $lx));
                                        if ($stmtCheck_trans->rowCount() > 0) {


                                            $stmtfx1 = $this->db->prepare("UPDATE    location_transport SET  quantity=quantity-?  WHERE   code=?  AND model=? AND location = ?");
                                            $stmtfx1->execute(array($x, $code, $tableLocation, $lx));
                                            $stmtCheck_trans_q = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND location = ?  AND  quantity <= 0 ");
                                            $stmtCheck_trans_q->execute(array($code, $tableLocation, $lx));
                                            if ($stmtCheck_trans_q->rowCount() > 0) {

                                                $stmtCheck_trans_de = $this->db->prepare("DELETE  FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND location = ?  AND  quantity <= 0 ");
                                                $stmtCheck_trans_de->execute(array($code, $tableLocation, $lx));
                                            }


                                        }
                                    }
                                    $numberOrder = $numberOrder - $x;

                                    $location[$key] = $lx;

                                }else
                                {
                                    echo 'not_enough';//  الكمية المطلوبة امبر من الموجودة في   الموقع
                                }

                            }else
                            {

                                $passLocation=false;
                                echo 'hide_location';//  الكمية المطلوبة امبر من الموجودة في   الموقع
                            }
						}

                        if ($passLocation) {
                            $location = array_unique(array_merge(explode(',', $result['location']), $location), SORT_REGULAR); // التجهيز الذكي

                            $stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `done_direct` = 1,`buy` = 2 ,  `prepared` = 2 , `date_prepared`= ? , `user_direct`=?,`enter_serial`=? ,location=?    WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=?  AND `number_bill`=? AND `accountant`=1 ");
                            $stmt2->execute(array(time(), $_SESSION['userid'], $enter_serial, implode(',', $location), $code, $id_user, $table, $result['id_item'], $number_bill));


                            if ($stmt2->rowCount() > 0) {
                                $this->serial_moves($enter_serial,$code,$number_bill,$table,'sale');
                                $this->Add_to_sync_schedule($code, $table,'quantity_adjustment',' ',' controllers\direct\direct.php 4901 '.$this->UserInfo($this->userid));

                                $stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill`=?");
                                $stmtt->execute(array($number_bill));
                                $newData = array();
                                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
                                    $newData[] = $rowt;
                                }
                                $trace = new trace();
                                $trace->addtrace('cart_shop_active', 'تجهيز الطلب من قبل المحاسب المباشر  - تجهيز الفاتورة ' . $number_bill, json_encode($oldData), json_encode($newData), '  تجهيز الطلب من قبل المحاسب المباشر استخدام مواقع المواد', $number_bill);


                                echo $code;
                            }
                        }

					} else {
//                        echo 'not_enough#'.$result['table'];//  الكمية المطلوبة امبر من الموجودة في   الموقع
						echo 'not_enough';//  الكمية المطلوبة امبر من الموجودة في   الموقع
					}


				} else if ($enter_serial) {

					$stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill`=?");
					$stmtt->execute(array($number_bill));
					$oldData = array();
					while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
						$oldData[] = $rowt;
					}





						$stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET     `done_direct` = 1,`buy` = 2 ,  `prepared` = 2 , `date_prepared`= ? , `user_direct`=?,`enter_serial`=? WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=?  AND `number_bill`=?  AND `accountant`=1");
						$stmt2->execute(array(time(), $_SESSION['userid'], $enter_serial, $code, $id_user, $table, $result['id_item'], $number_bill));

					if ($stmt2->rowCount() > 0) {
                        $this->serial_moves($enter_serial,$code,$number_bill,$table,'sale');
                        $this->Add_to_sync_schedule($code,$table,'quantity_adjustment',' ',' controllers\direct\direct.php 4941 '.$this->UserInfo($this->userid));
						$stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill`=?");
						$stmtt->execute(array($number_bill));
						$newData = array();
						while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
							$newData[] = $rowt;
						}
						$trace = new trace();
						$trace->addtrace('cart_shop_active', 'تجهيز الطلب من قبل المحاسب المباشر  - تجهيز الفاتورة ' . $number_bill, json_encode($oldData), json_encode($newData), '  تجهيز الطلب من قبل المحاسب المباشر استخدام مواقع المواد',$number_bill);


						echo $code;
					}

				}

			} else {
				echo 'notFoundCode';
			}
		}
        $this->AddToTraceByFunction($this->userid,'direct','enterSerial2location3/'.$code.'/'.$number_bill.'/'.$enter_serial);


    }










	function tajhez3Backto()
    {


        $id_user=$_GET['id_user'];
        $number_bill=$_GET['number_bill'];


        $stmt = $this->getAllContentFromCar3($id_user,$number_bill);
        $price1 = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $f1 = (int)trim($row['price']);
            $price1 = $price1 + ($f1 * $row['number']);
        }


        $stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET   `done_direct` = 1 ,`buy` = 2 ,  `prepared` = 2 , `date_prepared`= ? , `user_direct`=? WHERE `id_member_r` =? AND `number_bill` = ? AND `accountant` = 1   ");
        $stmt2->execute(array(time(), $this->userid, $id_user,$number_bill));
        if ($stmt2->rowCount() > 0) {

             echo 1;
        } else {
            echo 0;
        }
    }


    function tajhez31()
    {


        $id_user=$_GET['id_user'];
        $number_bill=$_GET['number_bill'];
        $type=$_GET['type'];


        $stmt = $this->getAllContentFromCar3($id_user,$number_bill);
        $price1 = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $f1 = (int)trim($row['price']);
            $price1 = $price1 + ($f1 * $row['number']);
        }

        $stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET   `back_to`=1, `user_direct`=? WHERE `id_member_r` =? AND `number_bill` = ?   ");
        $stmt2->execute(array( $this->userid, $id_user,$number_bill));
        if ($stmt2->rowCount() > 0) {
             echo 1;
        } else {
            echo 0;
        }
    }

    function tajhez32()
    {


        $id_user=$_GET['id_user'];
        $number_bill=$_GET['number_bill'];
        $type=$_GET['type'];


        $stmt = $this->getAllContentFromCar3($id_user,$number_bill);
        $price1 = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $f1 = (int)trim($row['price']);
            $price1 = $price1 + ($f1 * $row['number']);
        }

        $stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET   `back_to`=2, `user_direct`=? WHERE `id_member_r` =? AND `number_bill` = ?   ");
        $stmt2->execute(array( $this->userid, $id_user,$number_bill));
        if ($stmt2->rowCount() > 0) {
             echo 1;
        } else {
            echo 0;
        }
    }


    function color_list($code,$cat)
    {


        $code = strip_tags(trim($code));
        $cat = strip_tags(trim($cat));



        $table='excel_'.$cat;
        $stmtColor = $this->db->prepare("SELECT *FROM `{$table}` WHERE `code`=?  ");
        $stmtColor->execute(array($code));
        $html='<select class="custom-select mr-sm-2"  id="color_name_acc">';
        if ($stmtColor->rowCount() > 0) {
            $c=0;
            while ($row = $stmtColor->fetch(PDO::FETCH_ASSOC))
            {
                if ($c==0)
                {
                    $html.="<option value='{$row['color']}'  selected>{$row['color']}</option>";

                }else
                {
                    $html.="<option value='{$row['color']}'>{$row['color']}</option>";

                }

                $c++;

            }

        }

        echo $html.='</select>';



    }


    function return_order_minus($table,$code,$id_user,$prepared=1)
    {
        if (!is_string($table)) {$error=new Errors(); $error->index();}
        if (!is_numeric($id_user)) {$error=new Errors(); $error->index();}

        $buy=1;
        if ($prepared == 2)
        {
            $buy=2;
        }

        if ($this->handleLogin()) {


            $color = $_GET['color'];
            $number_bill = $_GET['number_bill'];

            $stmt_count_n = $this->db->prepare("SELECT  *FROM `{$this->cart_shop_active}` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?    AND `buy` = ? AND `number` = 1 AND `prepared`=?  AND `number_bill`=?");
            $stmt_count_n->execute(array($table, $code, $id_user,$buy,$prepared,$number_bill));
            $id_row_tem=0;
            if ($stmt_count_n->rowCount() > 0 )
            {


				/*  trace Accountant Minus  */
				$stmt_retrieve_item=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `number_bill` = ? AND `buy` = ? AND `prepared`=?   ");
				$stmt_retrieve_item->execute(array($table, $code, $id_user,$number_bill,$buy,$prepared,));
				$resultRI=$stmt_retrieve_item->fetch(PDO::FETCH_ASSOC);
				$accountant=new Accountant();
                $id_row_tem=$resultRI['id_item'];
				if ( $_SESSION['direct'] == 3)
                {
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
                }else
                {
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
                        'id_customer'=>$id_user,
                        'id_accountant_user'=>$resultRI['id_accountant_user'],
                        'accountant'=>$resultRI['accountant'],
                        'prepared'=>$resultRI['prepared']
                    ));
                }




				$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $oldData=array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                {
                    $oldData[]=$rowt;
                }


                $stmt_delete_last_one = $this->db->prepare("SELECT SUM(`number`)as number  FROM `{$this->cart_shop_active}` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?    AND `buy` = ? AND `prepared`=? AND `number_bill`=? ");
                $stmt_delete_last_one->execute(array($table, $code, $id_user,$buy,$prepared,$number_bill));
                $number= $stmt_delete_last_one->fetch(PDO::FETCH_ASSOC)['number'];

                if ($number == 1) {

                    $stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `buy` = ? AND `prepared`=? AND `number_bill`=?  LIMIT 1 ");
                    $stmt->execute(array($table, $code, $id_user,$buy,$prepared,$number_bill));


                }else if ($number > 1)
                {
                    $stmt_sel = $this->db->prepare("UPDATE  `cart_shop_active` SET  `number`=`number` - 1  WHERE `table` =?  AND `code` =? AND `id_member_r` = ?   AND `buy` = ?  AND number > 1 AND `prepared`=? AND `number_bill`=? LIMIT  1  ");
                    $stmt_sel->execute(array($table, $code, $id_user,$buy,$prepared,$number_bill));
                    if ($stmt_sel->rowCount() < 1)
                    {
                        $stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `buy` = ?  AND  `prepared`=? AND `number_bill`=? LIMIT 1 ");
                        $stmt->execute(array($table, $code, $id_user,$buy,$prepared,$number_bill));
                    }
                }else{
                    $stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?   AND `buy` = ? AND  `prepared`=? AND `number_bill`=? LIMIT 1 ");
                    $stmt->execute(array($table, $code, $id_user,$buy,$prepared,$number_bill));
                }

                $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $newData=array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                {
                    $newData[]=$rowt;
                }

                if ($prepared == 2)
                {
                    $trace = new trace(); $trace->addtrace('cart_shop_active',' استرجاع مادة من  الطلب من قبل المجهز المباشر بعد المحاسبة والتجهيز -رقم الفاتورة' .$number_bill,json_encode($oldData),json_encode($newData), 'استرجاع مادة من قبل المجهز المباشر',$number_bill);

                }else{
                    $trace = new trace(); $trace->addtrace('cart_shop_active',' استرجاع مادة من  الطلب من قبل المجهز المباشر-رقم الفاتورة' .$number_bill,json_encode($oldData),json_encode($newData), 'استرجاع مادة من قبل المجهز المباشر',$number_bill);

                }



            } else
            {

				/*  trace Accountant Minus  */
				$stmt_retrieve_item=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `number_bill` = ? AND `buy` = ? AND `prepared`=?   LIMIT  1  ");
				$stmt_retrieve_item->execute(array($table, $code, $id_user,$number_bill,$buy,$prepared));
				$resultRI=$stmt_retrieve_item->fetch(PDO::FETCH_ASSOC);
				$accountant=new Accountant();
                if ( $_SESSION['direct'] == 3)
                {
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
                }else
                {
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
                        'id_customer'=>$id_user,
                        'id_accountant_user'=>$resultRI['id_accountant_user'],
                        'accountant'=>$resultRI['accountant'],
                        'prepared'=>$resultRI['prepared']
                    ));
                }





				$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $oldData=array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                {
                    $oldData[]=$rowt;
                }


                $stmt_sel = $this->db->prepare("UPDATE  `cart_shop_active` SET  `number`=`number` - 1  WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `buy` = ?  AND number > 1 AND `prepared`=? AND `number_bill`=? LIMIT  1  ");
                $stmt_sel->execute(array($table, $code, $id_user,$buy,$prepared,$number_bill));

                $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $newData=array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                {
                    $newData[]=$rowt;
                }

                if ($prepared == 2)
                {
                    $trace = new trace(); $trace->addtrace('cart_shop_active',' استرجاع مادة من  الطلب من قبل المجهز المباشر بعد المحاسبة والتجهيز -رقم الفاتورة' .$number_bill,json_encode($oldData),json_encode($newData), 'استرجاع مادة من قبل المجهز المباشر',$number_bill);

                }else{
                    $trace = new trace(); $trace->addtrace('cart_shop_active',' استرجاع مادة من  الطلب من قبل المجهز المباشر-رقم الفاتورة' .$number_bill,json_encode($oldData),json_encode($newData), 'استرجاع مادة من قبل المجهز المباشر',$number_bill);

                }



            }
			$this->edit_bill($number_bill,$this->userid);

            $stmt2 = $this->db->prepare("SELECT  SUM(`number`)as number  FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?   AND `buy`= ?  AND    `prepared`=? AND `number_bill`=? GROUP BY `id_item`,`size`,`table`,`code`  ORDER BY `id`  DESC  ");
            $stmt2->execute(array($table, $code, $id_user,$buy,$prepared,$number_bill));
            $res = $stmt2->fetch(PDO::FETCH_ASSOC);


            if ($stmt2->rowCount() > 0) {

				$stmt_up=$this->db->prepare("UPDATE  `cart_shop_active` SET    edit_bill=1   WHERE  `number_bill` =? AND `code`=?");
				$stmt_up->execute(array($number_bill,$code));


                echo $res['number'];
            }else
            {
                echo 0;
            }


            $this->set_quantity_order_minus($table,$id_row_tem,$code,1);



        }
    }



    function return_order_plus($table,$code,$id_user,$id_row)
    {
        if (!is_string($table)) {$error=new Errors(); $error->index();}
        if (!is_numeric($id_user)) {$error=new Errors(); $error->index();}
        if (!is_numeric($id_row)) {$error=new Errors(); $error->index();}

        if ($this->handleLogin()) {

            $color = $_GET['color'];
            $number_bill = $_GET['number_bill'];


            $tmt_plus=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `table` =?  AND `code` =? AND `id_member_r` = ? AND  `name_color` = ? AND `id`=? AND `number_bill`=? AND `buy` = 1 " );
            $tmt_plus->execute(array($table, $code, $id_user,$color,$id_row,$number_bill));
            $result=$tmt_plus->fetch(PDO::FETCH_ASSOC);


            $data['id_member_r']=$result['id_member_r'];
            $data['id_item']=$result['id_item'];
            $data['size']=$result['size'];
            $data['price']=$result['price'];
            $data['price_dollars']=$result['price_dollars'];
            $data['image']=$result['image'];
            $data['color']=$result['color'];
            $data['code']=$result['code'];
            $data['table']=$result['table'];
            $data['number']=1;
            $data['buy']=1;
            $data['date']=$result['date'];
            $data['date_req']=$result['date_req'];
            $data['user_id']=$this->userid;
            $data['user_direct']=$this->userid;
            $data['date_d_r']=$result['date_d_r'];
            $data['number_bill']=$number_bill;
            $data['name_color']=$result['name_color'];
            $data['top']=1;
            $data['direct']=$result['direct'];
            $data['edit_bill']=1;
            $stmt=$this->db->prepare("SELECT *FROM `dollar_price`  WHERE `active` = 1  ORDER BY `id` DESC  LIMIT 1" );
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $resultD = $stmt->fetch(PDO::FETCH_ASSOC);
                $data['dollar_exchange']=$resultD['dollar'];
            }




            $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill` = ? ");
            $stmtt->execute(array($number_bill));
            $oldData=array();
            while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
            {
                $oldData[]=$rowt;
            }

            $r=$this->db->insert('cart_shop_active',$data);
			$stmt_up=$this->db->prepare("UPDATE  `cart_shop_active` SET    edit_bill=1   WHERE  `number_bill` =? AND `code`=?");
			$stmt_up->execute(array($number_bill,$code));
			$this->edit_bill($number_bill,$this->userid);

            $this->set_quantity_order($table,$result['id_item'],$code,1);


            if ($r) {



                $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $newData=array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                {
                    $newData[]=$rowt;
                }

                $trace = new trace(); $trace->addtrace('cart_shop_active','  اضافة مادة الى  الطلب من قبل المجهز المباشر-رقم الفاتورة' .$number_bill,json_encode($oldData),json_encode($newData), 'اضافة مادة الى قبل المجهز المباشر',$number_bill);



                $stmt2 = $this->db->prepare("SELECT SUM(`number`)as number  FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ? AND `name_color`=? AND `buy`= 1 GROUP BY `id_item`,`size`,`table`,`code` ORDER BY `id`  DESC  ");
                $stmt2->execute(array($table, $code, $id_user,$color));
                $res = $stmt2->fetch(PDO::FETCH_ASSOC);

                if ($stmt2->rowCount() > 0) {
                    echo $res['number'];
                }
            }

        }
    }

    function serial()
    {
        if ($this->handleLogin())
        {
            $id=$_GET['id'];
            $serial=$_GET['serial'];
            $table=$_GET['table'];
            $code=$_GET['code'];
            $color=$_GET['color'];
            $serial = '[[:<:]]'.$serial.'[[:>:]]';
            if ($table=='mobile')
            {
                $stmt_serial = $this->db->prepare("SELECT *FROM `code`  WHERE `code` = ? AND `serial`  REGEXP ?  LIMIT 1");
                $stmt_serial->execute(array($code,$serial));
                if ($stmt_serial->rowCount() > 0)
                {
                    echo 'true';
                }else{
                    echo 'false';
                }

            }else if ($table=='accessories') {

                $stmt_serial = $this->db->prepare("SELECT *FROM `color_accessories` WHERE id = ? AND color =? AND `serial`  REGEXP ?  LIMIT 1");
                $stmt_serial->execute(array($code,$color,$serial));
                if ($stmt_serial->rowCount() > 0)
                {
                    echo 'true';
                }else{
                    echo 'false';
                }

            }else
            {
                $tableCode='code_'.$table;

                $stmt_serial = $this->db->prepare("SELECT *FROM `{$tableCode}`  WHERE `code` = ? AND `serial`  REGEXP ?  LIMIT 1");
                $stmt_serial->execute(array($code,$serial));
                if ($stmt_serial->rowCount() > 0)
                {
                    echo 'true';
                }else{
                    echo 'false';
                }
            }


        }


    }





    function return_order_minus3($table,$code,$id_user)
    {
        if (!is_string($table)) {$error=new Errors(); $error->index();}
        if (!is_numeric($id_user)) {$error=new Errors(); $error->index();}

        if ($this->handleLogin()) {

            $color = $_GET['color'];
            $number_bill = $_GET['number_bill'];



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


            $stmt = $this->db->prepare("SELECT  * FROM `cart_shop_active` WHERE `id_member_r` =?    AND `number_bill`=? AND `table`=? AND `code`=? GROUP BY  `id_item`,`table`,`code`,`number_bill`,price_type,id_offer   LIMIT 1 ");
            $stmt->execute(array($id_user,$number_bill,$table,$code));
			$price1 = 0;
			$xp1 = 0;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
					$f1 = (int)trim(str_replace(',', '', $price));
					$xp1 = $xp1 + ($f1 * 1);
					$price1 = $xp1;
			}

			$price1 = (int)trim(str_replace($this->comma, '', $price1));

			if($price1 <=  (int)trim(str_replace($this->comma, '', $this->sumAllMoney($this->userid)))) {


			$stmt_count_n = $this->db->prepare("SELECT  *FROM `{$this->cart_shop_active}` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `name_color` = ? AND `number_bill`=?    AND `buy` = 1 AND `number` = 1 AND `prepared`=1  AND `accountant`=1");
            $stmt_count_n->execute(array($table, $code, $id_user,$color,$number_bill));
                $id_row_tem=0;
            if ($stmt_count_n->rowCount() > 0 )
            {




				/*  trace Accountant Minus  */
                $stmt_retrieve_item=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `name_color` = ? AND `number_bill` = ? AND `buy` = 1 AND `prepared`=1 LIMIT  1 ");
                $stmt_retrieve_item->execute(array($table, $code, $id_user,$color,$number_bill));
                $resultRI=$stmt_retrieve_item->fetch(PDO::FETCH_ASSOC);
                $id_cart = $resultRI['id'];
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
                    'id_customer'=>$id_user,
                    'recovery'=>1,
                    'delete'=>1,
                    'delete_user'=>$this->userid,
                    'delete_date'=>time(),
                    'type_account'=>3,
                    'id_accountant_user'=>$resultRI['id_accountant_user'],
                    'accountant'=>$resultRI['accountant'],
                    'prepared'=>$resultRI['prepared']
                ));




				$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $oldData=array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                {
                    $oldData[]=$rowt;
                }


               $stmt_delete_last_one = $this->db->prepare("SELECT SUM(`number`)as number  FROM `{$this->cart_shop_active}` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `name_color` = ? AND `number_bill`=?    AND `buy` = 1 AND `prepared`=1  AND `accountant`=1 ");
                $stmt_delete_last_one->execute(array($table, $code, $id_user,$color,$number_bill));
                $number= $stmt_delete_last_one->fetch(PDO::FETCH_ASSOC)['number'];

                if ($number == 1) {
                    $stmt_delete1 = $this->db->prepare( "DELETE FROM `type_device_customer` WHERE  `id_shop_cart` = ? ");
                    $stmt_delete1->execute(array($id_cart));

                    $stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ? AND `number_bill`=?  AND `buy` = 1 AND `prepared`=1   AND `accountant`=1 LIMIT 1 ");
                    $stmt->execute(array($table, $code, $id_user,$color,$number_bill));

                    $flag=1;
                }else if ($number > 1)
                {
                    $stmt_sel = $this->db->prepare("UPDATE  `cart_shop_active` SET  `number`=`number` - 1  WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ? AND `number_bill`=?   AND `buy` = 1  AND number > 1 AND `prepared`=1 AND `accountant`=1 LIMIT  1  ");
                    $stmt_sel->execute(array($table, $code, $id_user,$color,$number_bill));
                    if ($stmt_sel->rowCount() < 1)
                    {
                        $stmt_delete = $this->db->prepare( "DELETE FROM `type_device_customer` WHERE  `id_shop_cart` = ? ");
                        $stmt_delete->execute(array($id_cart));

                        $stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ? AND `number_bill`=?  AND `buy` = 1  AND  `prepared`=1  AND `accountant`=1 LIMIT 1 ");
                        $stmt->execute(array($table, $code, $id_user,$color,$number_bill));
                        $flag=1;
                    }
                }else{

                    $stmt_delete1 = $this->db->prepare( "DELETE FROM `type_device_customer` WHERE  `id_shop_cart` = ? ");
                    $stmt_delete1->execute(array($id_cart));

                    $stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ? AND `number_bill`=?  AND `buy` = 1 AND  `prepared`=1  AND `accountant`=1 LIMIT 1 ");
                    $stmt->execute(array($table, $code, $id_user,$color,$number_bill));
                    $flag=1;
                }



                $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $newData=array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                {
                    $newData[]=$rowt;
                }

                $trace = new trace(); $trace->addtrace('cart_shop_active',' استرجاع مادة من  الطلب من قبل المحاسب المباشر قبل  المحاسبة والتجهيز -رقم الفاتورة' .$number_bill,json_encode($oldData),json_encode($newData), 'استرجاع مادة من قبل المحاسب المباشر',$number_bill);



            } else
            {


				/*  trace Accountant Minus  */
				$stmt_retrieve_item=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `name_color` = ? AND `number_bill` = ? AND `buy` = 1 AND `prepared`=1 LIMIT  1 ");
				$stmt_retrieve_item->execute(array($table, $code, $id_user,$color,$number_bill));
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
					'id_customer'=>$id_user,
                    'recovery'=>1,
                    'delete'=>1,
                    'delete_user'=>$this->userid,
                    'delete_date'=>time(),
					'type_account'=>3,
                    'id_accountant_user'=>$resultRI['id_accountant_user'],
                    'accountant'=>$resultRI['accountant'],
                    'prepared'=>$resultRI['prepared']
				));

                $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $oldData=array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                {
                    $oldData[]=$rowt;
                }

                $stmt_sel = $this->db->prepare("UPDATE  `cart_shop_active` SET  `number`=`number` - 1  WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ?  AND `number_bill`=? AND `buy` = 1  AND number > 1 AND `prepared`=1 AND `accountant`=1 LIMIT  1  ");
                $stmt_sel->execute(array($table, $code, $id_user,$color,$number_bill));
				$flag=1;


                $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $newData=array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                {
                    $newData[]=$rowt;
                }

                $trace = new trace(); $trace->addtrace('cart_shop_active',' استرجاع مادة من  الطلب من قبل المحاسب المباشر قبل  المحاسبة والتجهيز -رقم الفاتورة' .$number_bill,json_encode($oldData),json_encode($newData), 'استرجاع مادة من قبل المحاسب المباشر',$number_bill);


            }


            if($flag==1) {




					$stmt_log_accountant = $this->db->prepare("UPDATE log_accountant SET `money`=money-? ,`date`=? WHERE `id_user` = ?");
                    $stmt_log_accountant->execute(array($price1, time(), $this->userid));

					$stmtx = $this->db->prepare("UPDATE log_accountant_bill SET `money`=money-? ,`date`=?,`update_uer`=? WHERE `number_bill` = ?");
					$stmtx->execute(array($price1, time(), $this->userid, $number_bill));


					$this->edit_bill($number_bill, $this->userid);


					$stmt2 = $this->db->prepare("SELECT  SUM(`number`)as number  FROM `cart_shop_active` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ? AND `buy`= 1  AND `prepared`=1 GROUP BY `id_item`,`size`,`table`,`code`,`name_color` ORDER BY `id`  DESC  ");
					$stmt2->execute(array($table, $code, $id_user, $color));
					$res = $stmt2->fetch(PDO::FETCH_ASSOC);

					if ($stmt2->rowCount() > 0) {

						$stmt_up=$this->db->prepare("UPDATE  `cart_shop_active` SET    edit_bill=1   WHERE  `number_bill` =? AND `code`=?");
						$stmt_up->execute(array($number_bill,$code));

						echo $res['number'];
					} else {
						echo 0;
					}

					if ($countBill == 1) {
						$this->clearBill($number_bill, $countBill);
					}



                $this->set_quantity_order_minus($table,$id_row_tem,$code,1);





            }else
			{
				echo 0;
			}
		}else
		{

			echo '-1';
		}
        }

    }



    function return_order_plus3($table,$code,$id_user,$id_row)
    {
        if (!is_string($table)) {$error=new Errors(); $error->index();}
        if (!is_numeric($id_user)) {$error=new Errors(); $error->index();}
        if (!is_numeric($id_row)) {$error=new Errors(); $error->index();}

        if ($this->handleLogin()) {

            $color = $_GET['color'];
			$number_bill = $_GET['number_bill'];


            $tmt_plus=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `table` =?  AND `code` =? AND `id_member_r` = ? AND  `name_color` = ? AND `id`=?  AND `number_bill`=? AND `buy` = 1 " );
            $tmt_plus->execute(array($table, $code, $id_user,$color,$id_row,$number_bill));
            $result=$tmt_plus->fetch(PDO::FETCH_ASSOC);


            $data['id_member_r']=$result['id_member_r'];
            $data['id_item']=$result['id_item'];
            $data['size']=$result['size'];
            $data['price']=$result['price'];
            $data['price_dollars']=$result['price_dollars'];
            $data['image']=$result['image'];
            $data['color']=$result['color'];
            $data['code']=$result['code'];
            $data['table']=$result['table'];
            $data['number']=1;
            $data['buy']=1;
            $data['date']=$result['date'];
            $data['date_req']=$result['date_req'];
            $data['user_id']=$this->userid;
            $data['user_direct']=$this->userid;
            $data['date_d_r']=$result['date_d_r'];
            $data['number_bill']=$number_bill;
            $data['name_color']=$result['name_color'];
            $data['prepared']=$result['prepared'];
            $data['direct']=$result['direct'];
			$data['edit_bill']=1;
            $stmt=$this->db->prepare("SELECT *FROM `dollar_price`  WHERE `active` = 1  ORDER BY `id` DESC  LIMIT 1" );
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $resultD = $stmt->fetch(PDO::FETCH_ASSOC);
                $data['dollar_exchange']=$resultD['dollar'];
            }



            $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill` = ? ");
            $stmtt->execute(array($number_bill));
            $oldData=array();
            while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
            {
                $oldData[]=$rowt;
            }

            $r=$this->db->insert('cart_shop_active',$data);
			$stmt_up=$this->db->prepare("UPDATE  `cart_shop_active` SET    edit_bill=1   WHERE  `number_bill` =? AND `code`=?");
			$stmt_up->execute(array($number_bill,$code));
			$this->edit_bill($number_bill,$this->userid);

            $this->set_quantity_order($table,$result['id_item'],$code,1);



            if ($r) {


                $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $newData=array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                {
                    $newData[]=$rowt;
                }

                $trace = new trace(); $trace->addtrace('cart_shop_active','  زيادة مادة الى  الطلب من قبل المحاسب المباشر-رقم الفاتورة' .$number_bill,json_encode($oldData),json_encode($newData), 'زيادة  مادة الى الطلب من قبل المحاسب  المباشر',$number_bill);




                $stmt2 = $this->db->prepare("SELECT SUM(`number`)as number  FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ? AND `name_color`=? AND `buy`= 1 GROUP BY `id_item`,`size`,`table`,`code` ORDER BY `id`  DESC  ");
                $stmt2->execute(array($table, $code, $id_user,$color));
                $res = $stmt2->fetch(PDO::FETCH_ASSOC);

                if ($stmt2->rowCount() > 0) {
                    echo $res['number'];
                }
            }

        }
    }



    function return_order_minus3After_pay($table,$code,$id_user)
    {
        if (!is_string($table)) {$error=new Errors(); $error->index();}
        if (!is_numeric($id_user)) {$error=new Errors(); $error->index();}

        if ($this->handleLogin()) {

            $color = $_GET['color'];
            $number_bill = $_GET['number_bill'];
            $id_row = $_GET['id'];

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



			$stmt_count_n = $this->db->prepare("SELECT  *FROM `{$this->cart_shop_active}` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `name_color` = ? AND `number_bill`=?    AND `buy` = 2 AND `number` = 1 AND `prepared`=2 AND `accountant`=1");
            $stmt_count_n->execute(array($table, $code, $id_user,$color,$number_bill));

            if ($stmt_count_n->rowCount() > 0 )
            {

				$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $oldData=array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                {
                    $oldData[]=$rowt;
                }


                $stmt_delete_last_one = $this->db->prepare("SELECT SUM(`number`)as number  FROM `{$this->cart_shop_active}` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `name_color` = ? AND `number_bill`=?    AND `buy` = 2 AND `prepared`=2  AND `accountant`=1  ");
                $stmt_delete_last_one->execute(array($table, $code, $id_user,$color,$number_bill));
                $number= $stmt_delete_last_one->fetch(PDO::FETCH_ASSOC)['number'];

                if ($number == 1) {
                    $this->setAmountEmployDirect3($id_row,$number_bill);
                    $stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ? AND `number_bill`=?  AND `buy` = 2 AND `prepared`=2  AND `accountant`=1  LIMIT 1 ");
                    $stmt->execute(array($table, $code, $id_user,$color,$number_bill));
					$flag=1;


                }else if ($number > 1)
                {
                    $stmt_sel = $this->db->prepare("UPDATE  `cart_shop_active` SET  `number`=`number` - 1  WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ? AND `number_bill`=?   AND `buy` = 2  AND number > 1 AND `prepared`=2  AND `accountant`=1 LIMIT  1  ");
                    $stmt_sel->execute(array($table, $code, $id_user,$color,$number_bill));
                    if ($stmt_sel->rowCount() < 1)
                    {
                        $this->setAmountEmployDirect3($id_row,$number_bill);
                        $stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ? AND `number_bill`=?  AND `buy` = 2  AND  `prepared`=2   AND `accountant`=1 LIMIT 1 ");
                        $stmt->execute(array($table, $code, $id_user,$color,$number_bill));
						$flag=1;
                    }else{
                        $this->setAmountEmployDirect3($id_row,$number_bill);
						$flag=1;
                    }
                }else{
                    $this->setAmountEmployDirect3($id_row,$number_bill);
                    $stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ? AND `number_bill`=?  AND `buy` = 2 AND  `prepared`=2  AND `accountant`=1 LIMIT 1 ");
                    $stmt->execute(array($table, $code, $id_user,$color,$number_bill));
					$flag=1;
                }


                $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $newData=array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                {
                    $newData[]=$rowt;
                }

                $trace = new trace(); $trace->addtrace('cart_shop_active',' استرجاع مادة من  الطلب من قبل المحاسب المباشر بعد  المحاسبة والتجهيز -رقم الفاتورة' .$number_bill,json_encode($oldData),json_encode($newData), 'استرجاع مادة من قبل المحاسب المباشر',$number_bill);


            } else
            {


                $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $oldData=array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                {
                    $oldData[]=$rowt;
                }

                $this->setAmountEmployDirect3($id_row,$number_bill);
                $stmt_sel = $this->db->prepare("UPDATE  `cart_shop_active` SET  `number`=`number` - 1  WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ?  AND `number_bill`=? AND `buy` = 2  AND number > 1 AND `prepared`=2  AND `accountant`=1 LIMIT  1  ");
                $stmt_sel->execute(array($table, $code, $id_user,$color,$number_bill));

				$flag=1;

                $stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $newData=array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
                {
                    $newData[]=$rowt;
                }

                $trace = new trace(); $trace->addtrace('cart_shop_active',' استرجاع مادة من  الطلب من قبل المحاسب المباشر بعد  المحاسبة والتجهيز -رقم الفاتورة' .$number_bill,json_encode($oldData),json_encode($newData), 'استرجاع مادة من قبل المحاسب المباشر',$number_bill);

            }
			$this->edit_bill($number_bill,$this->userid);

            if ($flag==1) {



				echo $this->setBillAfterAccept($id_user, $number_bill);


				if ($countBill == 1) {
					$this->clearBill($number_bill, $countBill);
				}


                $stmttIdItem=$this->db->prepare("SELECT id_item FROM `cart_shop_active` WHERE `number_bill` = ? AND id_member_r=?");
                $stmttIdItem->execute(array($number_bill,$id_user));
                $resultIdItem= $stmttIdItem->fetch(PDO::FETCH_ASSOC);
                $this->set_quantity_order_minus($table,$resultIdItem['id_item'],$code,1);



            }
		}

    }



    function setBillAfterAccept($id,$n_b)
    {



        $stmt=$this->getAllContentFromCar_byNomberBillAfterAccept($id,$n_b);
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



    public function getAllContentFromCar_byNomberBillAfterAccept($id_member_r,$n_b)
    {
        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx`,`number_bill`,`top`,`dollar_exchange` FROM `cart_shop_active` WHERE `id_member_r` =?  AND  `number_bill` =? AND `accountant`=1 GROUP BY  `id_item`,`table`,`code`,`number_bill`,price_type,id_offer   ORDER BY `id` DESC  ");
        $stmt->execute(array($id_member_r,$n_b));
        return $stmt;
    }




    function setAmountEmployDirect3($id,$n_b)
    {


        $stmtd = $this->db->prepare("SELECT * FROM `cart_shop_active` WHERE `id` =? AND `number_bill`=? AND user_direct =? ");
        $stmtd->execute(array($id,$n_b,$this->userid));

        $request=array();
        $sum=0;
        $number_bill=0;
        $date_req=array();
        $price1=0;
        $p1=0;
        $p2=0;
        $xp1=0;
        $xp2=0;
        while ($row = $stmtd->fetch(PDO::FETCH_ASSOC))
        {

			if (!empty($this->cuts($row['id_item'],$row['table']))) {

				$price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
				$f1 = (double)trim(str_replace($this->comma, '', $price[0]));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1= $xp1;

			}else {
				$price =$this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']);
				$f1 = (int)trim(str_replace($this->comma, '', $price));
				$xp1 = $xp1 + ($f1 * $row['number']);
				$price1= $xp1;

			}

        }


		$price1 = (int)trim(str_replace($this->comma, '', $price1));

		$stmt = $this->db->prepare("UPDATE log_accountant SET `money`=money-? ,`date`=? WHERE `id_user` = ?");
		$stmt->execute(array($price1, time(), $this->userid));

		$stmtx = $this->db->prepare("UPDATE log_accountant_bill SET `money`=?,`date`=?,`update_uer`=? WHERE `number_bill` = ? AND `id_user`=? ");
		$stmtx->execute(array($price1, time(), $this->userid, $n_b, $this->userid));


    }




	function add_item_to_order($id_member_r)
	{


		if ($this->handleLogin()) {


			if (!empty($_POST['id_device'])) {
				$ids = $_POST['id_device'];
				$code = $_POST['code'];
				$image = $_POST['image'];
				$count = $_POST['count'];
				$found = $_POST['found'];
				$cat = $_POST['cat'];
				$name_color = $_POST['name_color'];
				$code_color = $_POST['code_color'];
				$size = $_POST['size'];
				$number_bill = strip_tags($_POST['number_bill']);

                $stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill` = ? AND  id_member_r=? ");
                $stmtt->execute(array($number_bill,$id_member_r));
                $oldData = array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
                    $oldData[] = $rowt;
                }

                foreach ($ids as $key => $id) {

                    if ($cat[$key] == 'mobile') {
                        $data['table'] = $cat[$key];
                        $excel = 'excel';
                    }else if ($cat[$key] == 'savers')
                    {
                        $data['table'] = 'product_savers';
                        $excel = 'excel_savers';
                    }else
                    {
                        $data['table'] = $cat[$key];
                        $excel = 'excel_'. $data['table'] ;
                    }



                    $stmt = $this->db->prepare("SELECT * from `{$excel}` WHERE  `code`= ?  ");
                    $stmt->execute(array($code[$key]));
				    $result = $stmt->fetch(PDO::FETCH_ASSOC);


					if ($found[$key] >= $count[$key]) {

                        $stmtExcel = $this->db->prepare("SELECT * from `{$excel}` WHERE  `code`= ?  ");
                        $stmtExcel->execute(array($code[$key]));
                        $result = $stmtExcel->fetch(PDO::FETCH_ASSOC);



                        $data['buy'] = 1;
						$data['id_item'] = $id;
						$data['id_member_r'] = $id_member_r;
						$data['number'] = $count[$key];
						$data['date'] = time();
						$data['date_req'] = time();
						$data['date_d_r'] = time();
						$data['name_color'] = $name_color[$key];
						$data['code'] = $code[$key];
						$data['size'] = $size[$key];
						$data['image'] = $image[$key];
						$data['color'] = $code_color[$key];
						$data['price'] = $result['price'];
						$data['price_dollars'] = $result['price_dollars'];
						$data['user_id'] = $this->userid;
						$data['user_direct'] = $this->userid;
						if($_SESSION['direct']==3)
						{
							$data['top'] = 0;
							$data['prepared'] = 1;
						}else
						{
							$data['top'] = 1;
						}
						$data['number_bill'] = $number_bill;
						$data['edit_bill'] = 1;
						$data['direct'] =$_SESSION['direct'];

						$stmt = $this->db->prepare("SELECT *FROM `dollar_price`  WHERE `active` = 1  ORDER BY `id` DESC  LIMIT 1");
						$stmt->execute();
						if ($stmt->rowCount() > 0) {
							$resultD = $stmt->fetch(PDO::FETCH_ASSOC);
							$data['dollar_exchange'] = $resultD['dollar'];
						}


						$this->db->insert('cart_shop_active', $data);
                        $this->set_quantity_order($data['table'],$id,$code[$key],$count[$key]);



					}
				}

				$stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill` = ? ");
				$stmtt->execute(array($number_bill));
				$newData = array();
				while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
					$newData[] = $rowt;
				}

				$trace = new trace();
				$trace->addtrace('cart_shop_active', 'اضافة مادة الى الطلب - رقم الفاتورة ' . $number_bill, json_encode($oldData), json_encode($newData), 'اضافة مادة الى الطلب - رقم الفاتورة ' . $number_bill, $number_bill);
				$this->edit_bill($number_bill,$this->userid);

				echo 'add';

			} else {
				echo 'error';
			}

		}

	}


	function checkNewItemInBill($id,$id_item,$number_bill)
	{
		if ($_SESSION['direct']==2)
		{
			$acc=1;
		}else
		{
			$acc=0;
		}

		$stmt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE id_member_r=? AND id_item=? AND number_bill=? AND edit_bill=1 AND accountant=?");
		$stmt->execute(array($id,$id_item,$number_bill,$acc));
		if ($stmt->rowCount()>0)
		{
			return true;
		}else
		{
			return false;
		}
	}

	function search_serial()
	{
		$cat=$_POST['cat'];
		$serial=$_POST['serial'];


		if ($cat == 'mobile') {
			$table = 'code';

		}

		if ($cat == 'camera') {
			$table = 'code_camera';

		}

		if ($cat == 'printing_supplies') {
			$table = 'code_printing_supplies';

		}


		if ($cat == 'computer') {
			$table = 'code_computer';

		}


		if ($cat == 'games') {
			$table = 'code_games';

		}

		if ($cat == 'network') {
			$table = 'code_network';

		}

		if ($cat == 'accessories') {
			$table = 'color_accessories';
		}
		$serial = '[[:<:]]'.$serial.'[[:>:]]';


		$stmt = $this->db->prepare("SELECT * from `{$table}` WHERE  `serial` REGEXP ?  ");
		$stmt->execute(array($serial));
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		echo $result['code'];

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
					$device[0]['price']=$this->price_dollarsAdmin($result['price_dollars']);
					$device[0]['code']=$code;
					$device[0]['cat']=$cat;



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
					$device[0]['price']=$this->price_dollarsAdmin($result['price_dollars']);
					$device[0]['code']=$code;
					$device[0]['cat']=$cat;


					$stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='camera' ");
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
					$device[0]['price']=$this->price_dollarsAdmin($result['price_dollars']);
					$device[0]['code']=$code;
					$device[0]['cat']=$cat;


					$stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='printing_supplies' ");
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
					$device[0]['price']=$this->price_dollarsAdmin($result['price_dollars']);
					$device[0]['code']=$code;
					$device[0]['cat']=$cat;


					$stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='computer' ");
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
					$device[0]['price']=$this->price_dollarsAdmin($result['price_dollars']);
					$device[0]['code']=$code;
					$device[0]['cat']=$cat;
					$stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1  AND `status` =0  AND `table`='games' ");
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
					$device[0]['price']=$this->price_dollarsAdmin($result['price_dollars']);
					$device[0]['code']=$code;
					$device[0]['cat']=$cat;

					$stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0   AND `table`='network' ");
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

				$color=$_POST['color'];

				$stmtCode_accessories = $this->db->prepare("SELECT *FROM `excel_accessories` WHERE `code`=? AND `color`=?");
				$stmtCode_accessories->execute(array($code,$color));
				if ($stmtCode_accessories->rowCount() > 0) {
					$result = $stmtCode_accessories->fetch(PDO::FETCH_ASSOC);

					$device[0]['quantity'] = $result['quantity'];
					$device[0]['price'] = $this->price_dollarsAdmin( $result['price_dollars']);
					$device[0]['code']=$code;
					$device[0]['cat']=$cat;

					$stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='accessories' ");
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


				$stmtCode_network = $this->db->prepare("SELECT *FROM `excel_savers` WHERE `code`=?  ");
				$stmtCode_network->execute(array($code));
				if ($stmtCode_network->rowCount() > 0) {
					$result = $stmtCode_network->fetch(PDO::FETCH_ASSOC);

					$device[0]['quantity'] = $result['quantity'];
					$device[0]['price']=$this->price_dollarsAdmin($result['price_dollars']);
					$device[0]['code']=$code;
					$device[0]['cat']=$cat;

					$stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?   AND `buy` = 1 AND `status` =0   AND `table`='product_savers' ");
					$stmt_order->execute(array($result['code']));
					$only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
					$device[0]['order'] = $only_order['num'];
					$device[0]['size'] = '';



					$stmt_color = $this->db->prepare("SELECT  * FROM `product_savers`  WHERE `code` =?   LIMIT 1");
					$stmt_color->execute(array($code));
					$colorx = $stmt_color->fetch(PDO::FETCH_ASSOC);
					$device[0]['color'] = '';
					$device[0]['name_color'] ='';
					$device[0]['img'] = $this->save_file . $colorx['img'];
					$device[0]['image']=$colorx['img'];
					$device[0]['name'] = $colorx['title'];
					$device[0]['id'] = $colorx['id'];

					$device[0]['category'] = $this->langControl('savers') ;

				}

			}


			require($this->render($this->folder, 'code', 'data', 'php'));


		}
	}





	/*--  حساب مبلغ المحاسب الثانوي----*/

	function sumAllMoney($user_id)
    {

            $stmt=$this->db->prepare("SELECT *FROM `log_accountant` WHERE id_user=? ");
            $stmt->execute(array($user_id));
            $result_d=$stmt->fetch(PDO::FETCH_ASSOC);


			$money_clipper=new money_clipper();
			$sunAll=($money_clipper->addOrWithdrawMoneySecondaryAllDay($user_id,0) + (int)$result_d['money']) - $money_clipper->addOrWithdrawMoneySecondaryAllDay($user_id,1) ;

           $purc=new purchase_customer();
         $amount= $sunAll - $purc->sumbillall($user_id);

         $log_accountant=new log_accountant();

        return number_format($amount-$log_accountant->sum_rewind2($user_id) );

    }

    function sun_total_money()
    {
        echo $this->sumAllMoney($this->userid);
    }




    function  search()
    {
        if ($this->handleLogin())
        {


            $search = strip_tags(trim($_GET['value']));
            $q = '%' . $search . '%';
			$stmt = $this->db->prepare("SELECT register_user.id,register_user.name,register_user.phone  FROM `register_user` inner join cart_shop_active on cart_shop_active.id_member_r=register_user.id WHERE ( register_user.name LIKE ? OR  register_user.phone LIKE ? ) AND  cart_shop_active.accountant =1   AND cart_shop_active.cancel=0 GROUP BY cart_shop_active.id_member_r LIMIT 15");

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
                        <div>{$row['name']}</div>
                        <div   style='direction: ltr;'>{$phone}</div>
                    </a>
                                   
                ";
            }

            echo  $count_active;


        }
    }



	function  searchActive()
	{
		if ($this->handleLogin())
		{


			$c=implode(',',$this->catgUser);



			$search = strip_tags(trim($_GET['value']));
			$q = '%' . $search . '%';
			$stmt = $this->db->prepare("SELECT register_user.id,register_user.name,register_user.phone,cart_shop_active.user_direct ,cart_shop_active.number_bill  FROM `register_user` inner join cart_shop_active on cart_shop_active.id_member_r=register_user.id WHERE ( register_user.name LIKE ? OR  register_user.phone LIKE ?  OR cart_shop_active.number_bill=? ) AND  cart_shop_active.accountant =1 AND (cart_shop_active.prepared=1 OR  cart_shop_active.prepared=0 ) AND `table` IN({$c}) AND cart_shop_active.cancel=0 GROUP BY cart_shop_active.id_member_r LIMIT 15");

			$stmt->execute(array($q,$q,trim($search)));
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
                <a class='infoCustomer ifactive' id='row{$row['number_bill']}' href='#' onclick='getOrder({$row['id']},{$row['number_bill']})'>
                         
                    <div class='row align-items-center justify-content-between'> 
                     <div class='col'>
                         <div>{$row['name']}  ({$row['number_bill']})  </div>
                        <div   style='direction: ltr;' >{$phone}</div>
                        </div>
                        <div class='col-auto'>
                            <div class='user_account'>   {$this->UserInfoBill($row['user_direct'])} </div>
                          </div>
                     </div>
                        
                </a>
                                   
                ";
			}

			echo  $count_active;


		}
	}





	function  location_get()
    {
        if ($this->handleLogin())
        {
		  	$code=$_GET['code'];
		  	$table=$_GET['table'];

            $lisq=null;
            if ($table == 'accessories') {
                $color = 'color_accessories';
                $stmtacc = $this->db->prepare("SELECT  {$table}.id   FROM  {$color} INNER JOIN {$table} ON  {$table}.id={$color}.id_item WHERE  {$table}.title LIKE '%لاصق%' AND {$color}.code=? GROUP BY {$table}.id LIMIT 1");
                $stmtacc->execute(array($code));
                if ($stmtacc->rowCount() > 0)
                {
                    $lisq=true;
                }
            }


            if ($table=='product_savers')
            {
                $table ='savers';
            }


            $stmt=$this->db->prepare("SELECT *FROM location WHERE `code`= ? AND `model` = ? AND `quantity` > 0 ");
			$stmt->execute(array($code,$table));
			$html='<div style="text-align: center;border: 1px solid #e8e7e9;background: #f7f7f7;margin-top: 12px;">الموقع(الكمية)</div><table class="table    table-bordered" style="margin-bottom: 0"><tr style="padding: 0;margin: 0 ">';
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{



                    if ($lisq || $table == 'camera' || $table == 'network' || $table == 'printing_supplies') {
                        $html .= '<td style="padding: 0;margin: 0;vertical-align: inherit;"><input type="checkbox" class="locationList"   onchange=selectLOcation() value="' . "{$row['location']}" . '" id="' . "x{$row['id']}" . '"> <label style="margin:0;cursor: pointer;" for="' . "x{$row['id']}" . '">' . $this->tamayaz_locations($row['location']) . '(' . $row['quantity'] . ')' . '</label></td>';

                    } else {
                        $html .= '<td style="padding: 0;margin: 0;vertical-align: inherit;">  ' . $this->tamayaz_locations($row['location']) . '(' . $row['quantity'] . ')' . '</td>';

                    }



			}
			$html.='</tr></table>';
			echo $html;
        }
    }



	function  search_rewind()
	{
		if ($this->handleLogin())
		{


			$search = strip_tags(trim($_GET['value']));
			$q = '%' . $search . '%';
			$stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE ( name LIKE ? OR  phone LIKE ? ) LIMIT 15");
			$stmt->execute(array($q,$q));
			$data=array();
			$count_active='';
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{

				$count_active.="
                <a class='infoCustomer ifactive'  id='row{$row['id']}' href='#' data-id='{$row['id']}' data-phone='{$row['phone']}' data-name='{$row['name']}' onclick='getOrder_search_rewind(this)'>
                        <div>{$row['name']}</div>
                        <div>{$row['phone']}</div>
                </a>
                                   
                ";
			}

			echo  $count_active;


		}
	}


	function  review()
	{



		$this->checkPermit('rewind', $this->folder);
		$this->adminHeaderController($this->langControl('rewind'));

		require($this->render($this->folder, 'html', 'rewind', 'php'));

		$this->adminFooterController();

	}



	function  item_review()
	{




		if ($this->handleLogin())
		{


            $count=trim(strip_tags($_POST['count']));


			$number_bill=null;
			$serial=null;
            $fromDate=null;
            $toDate=null;

            if (isset($_POST['fromDate']))
            {
                $fromDate=strtotime(strip_tags($_POST['fromDate']));
            }

            if (isset($_POST['toDate']))
            {
                $toDate=strtotime(strip_tags($_POST['toDate']));
            }



			if (isset($_POST['number_bill']))
			{
				$number_bill=trim(strip_tags($_POST['number_bill']));
			}
			if (isset($_POST['id_costumer']))
			{
				$id=trim(strip_tags($_POST['id_costumer']));
			}

			if (isset($_POST['serial']))
			{
				$serial=trim(strip_tags($_POST['serial']));
				if (!empty($serial))
				{
					$serial = '[[:<:]]'.$serial.'[[:>:]]';

				}
			}

            // هاي اكبر تلزيكة راح تصير  بس مستعجل
            // المرتجع راح يجيك الجدول الي بي فواتير قبل ما تتصدر
            // واذا ماكو عود يدور بالفواتير المصدرة الى كرستال
            if ($fromDate && $toDate)
            {

                if ($number_bill &&  $serial && $id)
                {
                    $stmt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `id_member_r`=? AND number_bill=? AND  (code   REGEXP ?  OR  `enter_serial`   REGEXP ?  )  AND `accountant`=1 AND prepared=2 AND cancel=0  AND date_prepared  between  ? AND ? ORDER BY `date_req` DESC ");
                    $stmt->execute(array($id, $number_bill , $serial, $serial,$fromDate,$toDate));
                }
                else if ($id && $number_bill)
                {

                    $stmt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `id_member_r`=? AND `number_bill`=? AND `accountant`=1 AND prepared=2 AND cancel=0   AND date_prepared  between  ? AND ?  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($id,$number_bill,$fromDate,$toDate));
                }

                else if ($id && $serial)
                {
                    $stmt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `id_member_r`=? AND   (code   REGEXP ?  OR  `enter_serial`   REGEXP ?  )  AND `accountant`=1 AND prepared=2 AND cancel=0   AND date_prepared  between  ? AND ?   ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($id,$serial,$serial,$fromDate,$toDate));
                }

                else if ($number_bill && $serial)
                {
                    $stmt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill`=? AND   (code   REGEXP ?  OR  `enter_serial`   REGEXP ?  )  AND `accountant`=1 AND prepared=2 AND cancel=0   AND date_prepared  between  ? AND ?  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($number_bill,$serial,$serial,$fromDate,$toDate));
                }
                else if ($number_bill)
                {

                    $stmt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   number_bill=?  AND `accountant`=1 AND prepared=2 AND cancel=0    AND date_prepared  between  ? AND ?  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($number_bill,$fromDate,$toDate));
                }
                else if($serial)
                {
                    $stmt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   (code   REGEXP ?  OR  `enter_serial`   REGEXP ?  )  AND `accountant`=1 AND prepared=2 AND cancel=0   AND date_prepared  between  ? AND ?   ORDER BY `date_req` DESC  ");
                    $stmt->execute(array( $serial, $serial,$fromDate,$toDate));
                }
                else if ($id)
                {
                    $stmt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `id_member_r`=?   AND `accountant`=1 AND prepared=2 AND cancel=0   AND date_prepared  between  ? AND ?   ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($id,$fromDate,$toDate));
                }


            }
            else {


                if ($number_bill && $serial && $id) {
                    $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `id_member_r`=? AND number_bill=? AND  (code   REGEXP ?  OR  `enter_serial`   REGEXP ?  )  AND `accountant`=1 AND prepared=2 AND cancel=0 ORDER BY `date_req` DESC ");
                    $stmt->execute(array($id, $number_bill, $serial, $serial));
                } else if ($id && $number_bill) {

                    $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `id_member_r`=? AND `number_bill`=? AND `accountant`=1 AND prepared=2 AND cancel=0  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($id, $number_bill));
                } else if ($id && $serial) {
                    $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `id_member_r`=? AND   (code   REGEXP ?  OR  `enter_serial`   REGEXP ?  )  AND `accountant`=1 AND prepared=2 AND cancel=0  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($id, $serial, $serial));
                } else if ($number_bill && $serial) {
                    $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill`=? AND   (code   REGEXP ?  OR  `enter_serial`   REGEXP ?  )  AND `accountant`=1 AND prepared=2 AND cancel=0  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($number_bill, $serial, $serial));
                } else if ($number_bill) {

                    $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   number_bill=?  AND `accountant`=1 AND prepared=2 AND cancel=0  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($number_bill));
                } else if ($serial) {
                    $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   (code   REGEXP ?  OR  `enter_serial`   REGEXP ?  )  AND `accountant`=1 AND prepared=2 AND cancel=0  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($serial, $serial));
                } else if ($id) {
                    $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `id_member_r`=?   AND `accountant`=1 AND prepared=2 AND cancel=0  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($id));
                }

            }

            if ($stmt->rowCount() ==0 ) {
                if ($fromDate && $toDate)
            {

                if ($number_bill &&  $serial && $id)
                {
                    $stmt=$this->db->prepare("SELECT *FROM `cart_shop` WHERE `id_member_r`=? AND number_bill=? AND  (code   REGEXP ?  OR  `enter_serial`   REGEXP ?  )  AND `accountant`=1 AND prepared=2 AND cancel=0  AND date_prepared  between  ? AND ? ORDER BY `date_req` DESC ");
                    $stmt->execute(array($id, $number_bill , $serial, $serial,$fromDate,$toDate));
                }
                else if ($id && $number_bill)
                {

                    $stmt=$this->db->prepare("SELECT *FROM `cart_shop` WHERE `id_member_r`=? AND `number_bill`=? AND `accountant`=1 AND prepared=2 AND cancel=0   AND date_prepared  between  ? AND ?  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($id,$number_bill,$fromDate,$toDate));
                }

                else if ($id && $serial)
                {
                    $stmt=$this->db->prepare("SELECT *FROM `cart_shop` WHERE `id_member_r`=? AND   (code   REGEXP ?  OR  `enter_serial`   REGEXP ?  )  AND `accountant`=1 AND prepared=2 AND cancel=0   AND date_prepared  between  ? AND ?   ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($id,$serial,$serial,$fromDate,$toDate));
                }

                else if ($number_bill && $serial)
                {
                    $stmt=$this->db->prepare("SELECT *FROM `cart_shop` WHERE `number_bill`=? AND   (code   REGEXP ?  OR  `enter_serial`   REGEXP ?  )  AND `accountant`=1 AND prepared=2 AND cancel=0   AND date_prepared  between  ? AND ?  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($number_bill,$serial,$serial,$fromDate,$toDate));
                }
                else if ($number_bill)
                {

                    $stmt=$this->db->prepare("SELECT *FROM `cart_shop` WHERE   number_bill=?  AND `accountant`=1 AND prepared=2 AND cancel=0    AND date_prepared  between  ? AND ?  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($number_bill,$fromDate,$toDate));
                }
                else if($serial)
                {
                    $stmt=$this->db->prepare("SELECT *FROM `cart_shop` WHERE   (code   REGEXP ?  OR  `enter_serial`   REGEXP ?  )  AND `accountant`=1 AND prepared=2 AND cancel=0   AND date_prepared  between  ? AND ?   ORDER BY `date_req` DESC  ");
                    $stmt->execute(array( $serial, $serial,$fromDate,$toDate));
                }
                else if ($id)
                {
                    $stmt=$this->db->prepare("SELECT *FROM `cart_shop` WHERE `id_member_r`=?   AND `accountant`=1 AND prepared=2 AND cancel=0   AND date_prepared  between  ? AND ?   ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($id,$fromDate,$toDate));
                }


            }
            else {


                if ($number_bill && $serial && $id) {
                    $stmt = $this->db->prepare("SELECT *FROM `cart_shop` WHERE `id_member_r`=? AND number_bill=? AND  (code   REGEXP ?  OR  `enter_serial`   REGEXP ?  )  AND `accountant`=1 AND prepared=2 AND cancel=0 ORDER BY `date_req` DESC ");
                    $stmt->execute(array($id, $number_bill, $serial, $serial));
                } else if ($id && $number_bill) {

                    $stmt = $this->db->prepare("SELECT *FROM `cart_shop` WHERE `id_member_r`=? AND `number_bill`=? AND `accountant`=1 AND prepared=2 AND cancel=0  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($id, $number_bill));
                } else if ($id && $serial) {
                    $stmt = $this->db->prepare("SELECT *FROM `cart_shop` WHERE `id_member_r`=? AND   (code   REGEXP ?  OR  `enter_serial`   REGEXP ?  )  AND `accountant`=1 AND prepared=2 AND cancel=0  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($id, $serial, $serial));
                } else if ($number_bill && $serial) {
                    $stmt = $this->db->prepare("SELECT *FROM `cart_shop` WHERE `number_bill`=? AND   (code   REGEXP ?  OR  `enter_serial`   REGEXP ?  )  AND `accountant`=1 AND prepared=2 AND cancel=0  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($number_bill, $serial, $serial));
                } else if ($number_bill) {

                    $stmt = $this->db->prepare("SELECT *FROM `cart_shop` WHERE   number_bill=?  AND `accountant`=1 AND prepared=2 AND cancel=0  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($number_bill));
                } else if ($serial) {
                    $stmt = $this->db->prepare("SELECT *FROM `cart_shop` WHERE   (code   REGEXP ?  OR  `enter_serial`   REGEXP ?  )  AND `accountant`=1 AND prepared=2 AND cancel=0  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($serial, $serial));
                } else if ($id) {
                    $stmt = $this->db->prepare("SELECT *FROM `cart_shop` WHERE `id_member_r`=?   AND `accountant`=1 AND prepared=2 AND cancel=0  ORDER BY `date_req` DESC  ");
                    $stmt->execute(array($id));
                }

            }
            }




            $c=1;

			$result=array()	;
			if ($stmt->rowCount() >0 ) {

				while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{

                    $row['store'] = $this->store_location($row['location'],$row['table'],$row['code']);

					$table = $row['table'];
					$stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
					$stmt_get_item->execute(array($row['id_item']));
					$item = $stmt_get_item->fetch(PDO::FETCH_ASSOC);

					$row['title'] = $item['title'];
					$row['img'] = $this->save_file . $row['image'];





                    if ($table == 'mobile') {
                        $excel = 'excel';
                    }else if ($table == 'product_savers') {
                        $excel = 'excel_savers';
                    } else {
                        $excel = 'excel_' . $table;
                    }


                    if (!empty($this->cuts($row['id_item'], $row['table']))) {
                        $row['realprice'] = $this->cuts($row['id_item'], $row['table'])  ;
                    } else {
                        $row['realprice'] = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange'])  ;
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

                    if ($id)
					{
						$check_review=$this->db->prepare("SELECT *FROM review_item WHERE `id_customre`=?  AND `id_cart`=? AND  `code`=? AND  ( ( `active` = 1 AND cancel = 0 )  OR   (  `active` = 0 AND cancel = 0) ) ");
						$check_review->execute(array($id,$row['id'],$row['code']));
					}else{
						$check_review=$this->db->prepare("SELECT *FROM review_item WHERE   `id_cart`=? AND  `code`=?   AND   ( ( `active` = 1 AND cancel = 0 )  OR   (  `active` = 0 AND cancel = 0) )  ");
						$check_review->execute(array($row['id'],$row['code']));
					}
                 
                    $required ='';
                    if ($this->check_serial_required($row['code'],'serial_rewind')==true)
                    {
                        $required ='required';
                    }


					if($check_review->rowCount() > 0)
					{

						$resultReview=$check_review->fetch(PDO::FETCH_ASSOC);

						$typeRow='مسترجع';
						$class_review_back='review_back';
						if ($resultReview['active']== 0 && $resultReview['cancel'] == 0 )
                        {
                            $typeRow='قيد الاسترجاع';
                            $class_review_back='review_back_wait';
                        }

						$row['content']='
			 <tr id="x'.$c.'" class="'.$class_review_back.'">
			 
			 <td>'.$c.'</td>
			 <td> '.$row['id'].' </td>
			  <td>
			  '. $this->nameCustomer($row['id_member_r']) . '
			  </td>
			 <td><img width="40" src="'.$row['img'].'"></td>
			 <td>'.$row['title'].'</td>
			 <td>'.$row['code'].'</td>
			 <td>'.$row['enter_serial'].'</td>
			 	<td>'.$row['enter_serial'].'</td>
			 <td>'.$row['name_color'].'</td>
			 <td>  <span> سعر الاسترجاع: </span> <span>'.number_format($resultReview['price_new']).'</span>  د.ع </td>
			   
			    <td>'.$row['now_price'].'</td>
			   
			 <td> تاريخ الاسترجاع   '.date('Y-m-d h:i:s A',$resultReview['date']).'</td>
	          <td>'.$resultReview['note'].'</td>	
	 		 <td>  '.$typeRow.'   </td>
			 
             </tr>
			 
			 ';
					}else
					{
						$row['content']='
			 <tr id="x'.$c.'" class="haveData_review">
			 
			 <td>'.$c.'</td>
			 <td><input readonly name="idrow['.$row['id_member_r'].'][]" class="form-control" value="'.$row['id'].'"></td>
			 <td>
			  
			  '. $this->nameCustomer($row['id_member_r']) . '
			   <div class="input-group mb-2">
					 <input name="id_customer['.$row['id_member_r'].']"  type="hidden"  value="'.$row['id_member_r'].'">
					  
			  </div>
				 
               </td>
			 <td><img width="40" src="'.$row['img'].'"></td>
			 <td>'.$row['title'].'</td>
			 <td>'.$row['code'].'</td>
			  <td><input '.$required.'  name="serial['.$row['id_member_r'].'][]" class="form-control"  placeholder="سيريال"  ></td>	
			<td>'.$row['enter_serial'].'</td>
			 <td>'.$row['name_color'].'</td>
			 <td>
			   <div class="input-group mb-2">
					 <input name="price['.$row['id_member_r'].'][]"  onkeyup="add_comma(this)" class="form-control" value="'.$row['realprice'].'">
					 <div class="input-group-prepend">
					  <div class="input-group-text">د.ع</div>
					</div>
			  </div>
				 
			   </td>
			   
			    <td>'.$row['now_price'].'</td>
			   
			 <td>'.date('Y-m-d h:i:s A',$row['date_accountant']).'</td>
		     <td>'.$row['store'].'
		     
		       <input name="location['.$row['id_member_r'].'][]"  type="hidden"    value="'.trim($row['location']).'">
		     
		     </td>
	          <td><textarea   name="note['.$row['id_member_r'].'][]" class="form-control" ></textarea></td>	
	 		 <td><button type="button"  class="btn btn-danger" onclick="removerow('.$c.')"><i class="fa fa-times"></i> </button></td>
			 
             </tr>
			 
			 ';


					}


					for($i=1 ;$i <= $row['number'];$i++)
					{
						$result[]=$row;
					}
					$c++;
				}

				require($this->render($this->folder, 'html', 'rewind_data', 'php'));



			}else{
				echo '0';
			}


		}

	}

	function nameCustomer($id)
	{
		$stmt=$this->db->prepare("SELECT *FROM register_user WHERE `id`= ? LIMIT 1");
		$stmt->execute(array($id));
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		return $result['name'];
	}


	function  insert_item_review()
	{
		if ($this->handleLogin()) {


			$ids = $_POST['id_customer'];
			$idrow = $_POST['idrow'];
			$price = $_POST['price'];
			$note = $_POST['note'];
            $serial = $_POST['serial'];
            $location = $_POST['location'];
            $note_review = $_POST['note_review'];
			if (!empty($ids)) {
				foreach ($ids as $id) {

					$stmt = $this->db->prepare("SELECT *FROM register_user WHERE `id`= ? LIMIT 1");
					$stmt->execute(array($id));
					$result = $stmt->fetch(PDO::FETCH_ASSOC);

					$price_review = 0;
					foreach ($price[$id] as $idx) {
						$p = (int)trim(str_replace($this->comma, '', $idx));
						$price_review = $price_review + $p;
					}


					if ($serial)
                    {
                        foreach ($idrow[$id] as $keyCh => $idxCh) {
                            $stmtCheckSerial = $this->db->prepare("SELECT  enter_serial ,`table`,code FROM cart_shop_active WHERE `id`= ? UNION SELECT  enter_serial ,`table`,code FROM cart_shop WHERE `id`= ? LIMIT 1");
                            $stmtCheckSerial->execute(array($idxCh,$idxCh));
                            $resultCheckSerial= $stmtCheckSerial->fetch(PDO::FETCH_ASSOC);
                            $tableCheck=$resultCheckSerial['table'];

                            if ($resultCheckSerial['enter_serial']) {
                                if ($resultCheckSerial['table'] == 'product_savers') {
                                    $tableCheck = 'savers';
                                }

                                if ($this->check_active_serial_prepared($tableCheck, $resultCheckSerial['code'])) {
                                    $listSERIAL = explode(',', $resultCheckSerial['enter_serial']);
                                    $serialTest = trim($serial[$id][$keyCh]);
                                    if (!in_array($serialTest, $listSERIAL)) {

                                        die('serial_note_found');

                                    }

                                }

                            }

                        }

                    }



                    $number_bill_new = $this->getNumberBillReview(4);

					$stmt2 = $this->db->prepare("INSERT INTO review (`id_customre`,`name`,`phone`,`money`,`number_bill_new`,`id_prepared`,`date`,note_review)values (?,?,?,?,?,?,?,?)");
					$stmt2->execute(array($id, $result['name'], $result['phone'], $price_review, $number_bill_new, $this->userid, time(),$note_review));
					$lastID = $this->db->lastInsertId();
					$oldData = array();
					if ($stmt2->rowCount() > 0) {
						foreach ($idrow[$id] as $key => $idx) {
							$stmt3 = $this->db->prepare("SELECT *FROM cart_shop_active WHERE `id`= ? UNION  SELECT *FROM cart_shop WHERE `id`= ? LIMIT 1");
							$stmt3->execute(array($idx,$idx));
							$result3 = $stmt3->fetch(PDO::FETCH_ASSOC);


							$table = $result3['table'];
							$stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
							$stmt_get_item->execute(array($result3['id_item']));
							$item = $stmt_get_item->fetch(PDO::FETCH_ASSOC);

							$result3['title'] = $item['title'];

							$price_new = (int)trim(str_replace($this->comma, '', $price[$id][$key]));

							$stmt4 = $this->db->prepare("INSERT INTO review_item (`id_customre`,`id_cart`,`id_review`,`id_item`,`item_name`,`image`,`code`,`number_bill_old`,`number_bill_new`,`price_new`,`date`,`id_prepared`,color,date_buy,note,serial,location,`table`)values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
							$stmt4->execute(array($id, $idx, $lastID, $result3['id_item'], $result3['title'], $result3['image'], $result3['code'], $result3['number_bill'], $number_bill_new, $price_new, time(), $this->userid, $result3['name_color'], $result3['date'], $note[$id][$key],trim($serial[$id][$key]), $location[$id][$key], $result3['table']));


							$oldData[] = array('id_customre' => $id, 'id_cart' => $idx, 'id_review' => $lastID, 'id_item' => $result3['id_item'], 'item_name' => $result3['title'], 'image' => $result3['image'], 'code' => $result3['code'], 'number_bill_old' => $result3['number_bill'], 'number_bill_new' => $number_bill_new, 'price_new' => $price_new, 'date' => time(), 'id_prepared' => $this->userid, 'color' => $result3['name_color'], 'date_d_r' => $result3['date_d_r'], 'note' => $note[$id][$key], 'table' => $result3['table']);


						}

						$trace = new trace();
						$trace->addtrace('review_item', 'مرتجع', json_encode($oldData), json_encode(array()), '   انشاء مرتجع مواد من قبل المجهز المباشر  ' . $_SESSION['usernamelogin'], $result3['number_bill']);


					}
				}

			} else {
				echo '0';
			}
		}
	}








	function processing_request_rejected($id,$number_bill)
	{
		if (!is_numeric($id)) {$error=new Errors(); $error->index();}
		if ($this->handleLogin()) {


			$why_rej = $_GET['why_rej'];


			$stmtt=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill` =?   ");
			$stmtt->execute(array($number_bill));
			$oldData=array();
			while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
			{
				$oldData[]=$rowt;
			}

			


			$stmt = $this->db->prepare("UPDATE `cart_shop_active` SET `cancel` = 1  ,`status` = 2  , `buy` = 3, `why_rejected` = ?  , `date_d_r`= ? , `user_id`=?,`id_accountant_user`=?  WHERE  `buy` = ? AND `id_member_r`=? AND `number_bill`=?  ");
			$stmt->execute(array($why_rej, time(), $this->userid,$this->userid, 1, $id,$number_bill));
			if ($stmt->rowCount() > 0) {
            	$stmtx = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`dollar_exchange` FROM `cart_shop_active` WHERE `id_member_r` =?  AND  `number_bill` =?  GROUP BY `id_item`,`table`,`code` ");
				$stmtx->execute(array($id,$number_bill));
				while ($row = $stmtx->fetch(PDO::FETCH_ASSOC)) {

                	$number = (int)$row['number'];



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

			$trace = new trace(); $trace->addtrace('cart_shop_active','الغاء الطلبمن قبل المحاسب الثانوي',json_encode($oldData),json_encode($newData),$this->userid . 'الغاء طلب ',$number_bill);

            $this->AddToTraceByFunction($this->userid,'direct','processing_request_rejected/'.$id.'/'.$number_bill);

		}else{
			echo 'login';
		}
	}




	function alixcol3($id_user,$code,$number_bill,$back=0)
	{
        if ( !$this->check_model_code_and_serial($code) ){
		$accountant=false;
		$stmtCh_acco = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE id_member_r=? AND  `code` = ?  AND  `number_bill`=?  AND `accountant`=1  ");
		$stmtCh_acco->execute(array($id_user,$code, $number_bill));
		if($stmtCh_acco->rowCount()>0)
		{
			$accountant=true;
		}


		$stmt = $this->db->prepare("SELECT   id,id_member_r,id_item,`table`,SUM(number) as number,name_color FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=? AND `prepared`=1 AND (`accountant`=0 OR `accountant`=1) GROUP BY  code ,name_color HAVING COUNT(number)=COUNT(*)");
		$stmt->execute(array($id_user, $code, $number_bill));
		if ($stmt->rowCount() > 0) {

            $result=$stmt->fetch(PDO::FETCH_ASSOC);

            if (in_array($result['table'],$this->model_big_q))
            {
                if ($result['table'] =='product_savers')
                {
                    $model='savers';
                }else
                {
                    $model=$result['table'];
                }

                $stmtCode=$this->db->prepare("SELECT * FROM model_big_q WHERE model =? AND  code= ? ");
                $stmtCode->execute(array($model,$code));
                if ($stmtCode->rowCount() > 0)
                {
                    echo json_encode(array('code' => $code, 'serial' =>  '', 'pass' => 'false', 'serial_prepared' => 'false'));

                }else
                {
                    echo json_encode(array('code' => $code, 'serial' => '', 'pass' => 'true', 'serial_prepared' => 'false'));

                }

            }else
            {
                echo json_encode(array('code' => $code, 'serial' =>  '', 'pass' => 'true', 'serial_prepared' => 'false'));

            }

		} else {


            //  التحقق من الباركود البديل
            $stmtpage = $this->db->prepare("SELECT  * FROM spare_code   WHERE spare_code=? LIMIT 1");
            $stmtpage->execute(array($code));
            if ($stmtpage->rowCount() > 0) {

                $result = $stmtpage->fetch(PDO::FETCH_ASSOC);
                $code = $result['code'];

                $stmt=$this->db->prepare("SELECT  * FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=?  AND `prepared`=1  ");
                $stmt->execute(array($id_user,$code,$number_bill));
                if ($stmt->rowCount() > 0) {
                    $this->alixcol3($id_user, $code, $number_bill, 0);

                }else
                {
                    echo 'notFoundCode';
                }

            } else {

                echo 'notFoundCode';
            }

        }

        }else{



            $stmtpage = $this->db->prepare("SELECT  * FROM serial   WHERE serial=? LIMIT 1");
            $stmtpage->execute(array($code));
            if ($stmtpage->rowCount() > 0) {

                $result = $stmtpage->fetch(PDO::FETCH_ASSOC);
                $code = $result['code'];

                $stmt = $this->db->prepare("SELECT   id,id_member_r,id_item,`table`,SUM(number) as number,name_color FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=? AND `prepared`=1 AND (`accountant`=0 OR `accountant`=1) GROUP BY  code ,name_color HAVING COUNT(number)=COUNT(*)");
                $stmt->execute(array($id_user,$code,$number_bill));
                if ($stmt->rowCount() > 0) {
                    $stmtCode = $this->db->prepare("SELECT * FROM model_big_q WHERE model =? AND  code= ? ");
                    $stmtCode->execute(array($result['model'], $code));
                    if ($stmtCode->rowCount() > 0) {
                        echo json_encode(array('code' => $code, 'serial' => $result['serial'], 'pass' => 'false', 'serial_prepared' => 'true'));
                    } else {
                        echo json_encode(array('code' => $code, 'serial' => $result['serial'], 'pass' => 'true', 'serial_prepared' => 'true'));
                    }
                }else
                {
                    echo 'notFoundSerial';
                }

            }else
            {
                echo 'notFoundSerial';
            }
        }

	}




	function alixcol($id_user,$code,$number_bill,$back=0)
	{
        if ( !$this->check_model_code_and_serial($code)  )
        {
		$stmt=$this->db->prepare("SELECT id,id_member_r,id_item,`table`,SUM(number) as number,name_color FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=?  AND `prepared`=1 GROUP BY  code ,name_color HAVING COUNT(number)=COUNT(*)");
		$stmt->execute(array($id_user,$code,$number_bill));
		if ($stmt->rowCount() > 0) {
            $result=$stmt->fetch(PDO::FETCH_ASSOC);


            if (in_array($result['table'],$this->model_big_q))
            {
                if ($result['table'] =='product_savers')
                {
                    $model='savers';
                }else
                {
                    $model=$result['table'];
                }

                $stmtCode=$this->db->prepare("SELECT * FROM model_big_q WHERE model =? AND  code= ? ");
                $stmtCode->execute(array($model,$code));
                if ($stmtCode->rowCount() > 0)
                {
                    echo json_encode(array('code' => $code, 'serial' =>  '', 'pass' => 'false', 'serial_prepared' => 'false'));

                }else
                {
                    echo json_encode(array('code' => $code, 'serial' => '', 'pass' => 'true', 'serial_prepared' => 'false'));

                }

            }else
            {
                echo json_encode(array('code' => $code, 'serial' =>  '', 'pass' => 'true', 'serial_prepared' => 'false'));

            }
		}else
		{

		    //  التحقق من الباركود البديل
            $stmtpage = $this->db->prepare("SELECT  * FROM spare_code   WHERE spare_code=? LIMIT 1");
            $stmtpage->execute(array($code));
            if ($stmtpage->rowCount() > 0) {

                $result = $stmtpage->fetch(PDO::FETCH_ASSOC);
                $code = $result['code'];

                $stmt=$this->db->prepare("SELECT  * FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=?  AND `prepared`=1  ");
                $stmt->execute(array($id_user,$code,$number_bill));
                if ($stmt->rowCount() > 0) {
                    $this->alixcol($id_user, $code, $number_bill, 0);

                }else
                {
                    echo 'notFoundCode';
                }

            } else {

                echo 'notFoundCode';
            }


        }
        }else {

            $stmtpage = $this->db->prepare("SELECT  * FROM serial   WHERE serial=? LIMIT 1");
            $stmtpage->execute(array($code));
            if ($stmtpage->rowCount() > 0) {

                $result = $stmtpage->fetch(PDO::FETCH_ASSOC);
                $code = $result['code'];


                $stmt=$this->db->prepare("SELECT  id,id_member_r,id_item,`table`,SUM(number) as number,name_color FROM `cart_shop_active` WHERE id_member_r=? AND `code`=? AND `number_bill`=? AND `prepared`=1 GROUP BY  code ,name_color HAVING COUNT(number)=COUNT(*)");
                $stmt->execute(array($id_user,$code,$number_bill));
                if ($stmt->rowCount() > 0) {
                    $stmtCode = $this->db->prepare("SELECT * FROM model_big_q WHERE model =? AND  code= ? ");
                    $stmtCode->execute(array($result['model'], $code));
                    if ($stmtCode->rowCount() > 0) {
                        echo json_encode(array('code' => $code, 'serial' => $result['serial'], 'pass' => 'false', 'serial_prepared' => 'true'));
                    } else {
                        echo json_encode(array('code' => $code, 'serial' => $result['serial'], 'pass' => 'true', 'serial_prepared' => 'true'));
                    }
                }else
                {
                    echo 'notFoundSerial';
                }

            }else
            {
                echo 'notFoundSerial';
            }

        }



		/*	$thisModel=$this->check_other_code_in_cart_shop($this->userid);

			$stmtAllcode=$this->db->prepare("SELECT `table`,code,name_color,id_member_r FROM `cart_shop_active` WHERE  number_bill=? AND `prepared`=1  AND `table` IN ({$thisModel})  GROUP BY   `id_item`,`table`,`code`,`number_bill`,price_type,id_offer    ");
			$stmtAllcode->execute(array($number_bill));

			$xcode=false;
			while ($rowx=$stmtAllcode->fetch(PDO::FETCH_ASSOC))
			{

				if ($rowx['table']=='accessories') {

                    $code_other = '[[:<:]]' . $code . '[[:>:]]';
                    $stmt_ch_code = $this->db->prepare("SELECT *FROM `color_accessories`  WHERE code=? AND `color`=? AND serial REGEXP ? ");
                    $stmt_ch_code->execute(array($rowx['code'], $rowx['name_color'], $code_other));
                    if ($stmt_ch_code->rowCount() > 0) {
                        $this->alixcol($rowx['id_member_r'], $rowx['code'], $number_bill);
                        $xcode = true;
                    }
                    break;

                } else if ($rowx['table']=='product_savers')

                {

                    $code_other = '[[:<:]]'.$code.'[[:>:]]';
                    $stmt_ch_code=$this->db->prepare("SELECT *FROM `product_savers`  WHERE code=?   AND serial REGEXP ? ");
                    $stmt_ch_code->execute(array($rowx['code'],$code_other));
                    if ($stmt_ch_code->rowCount() > 0)
                    {
                        $this->alixcol($rowx['id_member_r'],$rowx['code'],$number_bill);
                        $xcode=true;
                    }
                    break;

                }else
				{

					if ($rowx['table']=='mobile')
					{
						$table_code='code';
						$table_color='color';

					}else
					{
						$table_code='code_'.$rowx['table'];
						$table_color='color_'.$rowx['table'];

					}

					$code_other = '[[:<:]]'.$code.'[[:>:]]';
					$stmt_ch_code=$this->db->prepare("SELECT *FROM `{$table_code}` INNER JOIN {$table_color} ON `{$table_code}`.id_color = {$table_color}.id  WHERE `{$table_code}`.code= ? AND `{$table_color}`.color = ?  AND `{$table_code}`.serial REGEXP ?  ");
					$stmt_ch_code->execute(array($rowx['code'],$rowx['name_color'],$code_other));
					if ($stmt_ch_code->rowCount() > 0)
					{
						$this->alixcol($rowx['id_member_r'],$rowx['code'],$number_bill);
						$xcode=true;
						break;
					}

				}

			}
			if ($xcode==false)
			{
				echo 'notFoundCode';
			}*/





	}



    function edit_price()
    {
        if ($this->handleLogin()) {
            $price = (int)str_replace($this->comma, '', $_GET['price']);
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
                    $new_price =  $price / $result['dollar_exchange'];

                    $stmt_round_price=$this->db->prepare("SELECT *FROM {$table} WHERE  id=? AND `change_price`=1  ");
                    $stmt_round_price->execute(array($id_item));
                    if ($stmt_round_price->rowCount() > 0) {
                        if (is_float($new_price)) {
                            $p = explode('.', $new_price);
                            $new_price = $p[0] . '.' . substr($p[1], 0, 1);
                        }
                    }

                    $stmtup = $this->db->prepare("UPDATE  cart_shop_active  SET price_dollars=? ,old_price=?,edit_price=?,user_edit_price=? WHERE id_member_r=? AND id_item =? AND number_bill=? AND  `table`=? AND code=? AND name_color=? ");
                    $stmtup->execute(array($new_price, $result['price_dollars'], 1, $this->userid, $id_member_r, $id_item, $number_bill, $table, $code, $color_name));
                    if ($stmtup->rowCount() > 0) {

                        $stmtPriceBill= $this->db->prepare("UPDATE  cart_shop_active  SET edit_price=? WHERE id_member_r=?   AND number_bill=? AND  `table`=?   ");
                        $stmtPriceBill->execute(array(1 ,$id_member_r, $number_bill, $table  ));

                        echo 'edit';
                    }else
                    {
                        echo 'not_edit';
                    }
                } else {
                    echo 'not_found';
                  }

            } else {
                echo 'xprice';
            }
        }
    }


    function  smartsearch()
    {

        $mod=array('accessories','savers');

        $val=strip_tags(trim($_GET['val']));
        $model=strip_tags(trim($_GET['cat']));
        $mod=array('accessories','savers');
        if ($model=='mobile') {
            $code = 'code';
            $color = 'color';
        }else  if (!in_array($model,$mod)){
            $code = 'code_'.$model;
            $color = 'color_'.$model;

        }
        $contentAll = array();
        $q = '%' . trim($val) . '%';
        $r = '[[:<:]]'.trim($val).'[[:>:]]';

        if (!in_array($model,$mod)) {



            $stmt = $this->db->prepare("SELECT `id`,`title`,`bast_it`,`price_dollars` FROM `{$model}` WHERE ( title LIKE ? OR  tags LIKE ? )     LIMIT 10");
            $stmt->execute(array($q, $q));

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $contentAll[] = $row;

                }
            }

            $stmtcode = $this->db->prepare("SELECT {$model}.* FROM {$code} inner JOIN {$color} ON {$code}.id_color = {$color}.id inner JOIN {$model} ON {$color}.id_item =  {$model}.id WHERE ({$code}.code=? OR {$code}.serial  REGEXP ?) ");
            $stmtcode->execute(array(str_replace(' ', '', $val),$r));
            if ($stmtcode->rowCount() > 0) {
                while ($row_code = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
                    $contentAll[] = $row_code;


                }
            }
        }else if ($model =='accessories')
        {

            $stmt = $this->db->prepare("SELECT *FROM `accessories` WHERE ( title LIKE ? OR  tags LIKE ? )  LIMIT 10");
            $stmt->execute(array($q, $q));

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $contentAll[] = $row;

                }
            }

            $stmtcode = $this->db->prepare("SELECT accessories.* FROM color_accessories inner JOIN accessories ON color_accessories.id_item = accessories.id WHERE  (color_accessories.code=?  OR color_accessories.serial  REGEXP ?)  ");
            $stmtcode->execute(array(str_replace(' ', '', $val),$r));
            if ($stmtcode->rowCount() > 0) {
                while ($row_code = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
                    $contentAll[] = $row_code;
                }
            }



        }else if ($model =='savers')
        {

            $stmt = $this->db->prepare("SELECT * from `product_savers` WHERE (title LIKE ?  OR code = ? OR serial REGEXP ? ) LIMIT 10");
            $stmt->execute(array($q, $q,$r));

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $contentAll[] = $row;

                }
            }

        }
        if (!empty($contentAll))
        {
            require($this->render($this->folder, 'html', 'search_add_to_order', 'php'));

        }



    }





    function getdata()
    {
        $id=$_GET['id'];
        $model=$_GET['model'];

        $mod=array('accessories','savers');
        if ($model=='mobile') {
            $code = 'code';
            $color = 'color';
            $excel = 'excel';
        }else  if (!in_array($model,$mod)){
            $code = 'code_'.$model;
            $color = 'color_'.$model;
            $excel = 'excel_'.$model;

        }

        if (!in_array($model,$mod)) {


            $stmt = $this->db->prepare("SELECT id,title,serial_flag,enter_serial  FROM `{$model}` WHERE  id=?     ");
            $stmt->execute(array($id));

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $result['color'] = array();
            $stmtc = $this->db->prepare("SELECT *FROM `{$color}` WHERE  id_item=?  ");
            $stmtc->execute(array($id));
            while ($row = $stmtc->fetch(PDO::FETCH_ASSOC)) {
                $row['image'] = $this->save_file . $row['img'];
                $row['table'] = $model;

                $row['code'] = array();

                $stmtcode = $this->db->prepare("SELECT {$code}.*,{$excel}.quantity,{$excel}.price_dollars FROM `{$code}` left   join {$excel} on {$excel}.code = {$code}.code WHERE  {$code}.id_color=?  ");
                $stmtcode->execute(array($row['id']));
                while ($rowcode = $stmtcode->fetch(PDO::FETCH_ASSOC)) {

                    if (empty($rowcode['price_dollars'])) {
                        $rowcode['price_dollars'] = 0;
                    }


                    if (empty($rowcode['quantity'])) {
                        $rowcode['quantity'] = 0;
                    }


                    $rowcode['price'] = $this->price_dollarsAdmin($rowcode['price_dollars']);
                    $row['code'][] = $rowcode;
                }

                $result['color'][] = $row;
            }
        }else if ($model=='accessories')
        {


            $stmt = $this->db->prepare("SELECT id,title,serial_flag,enter_serial  FROM `accessories` WHERE  id=?     ");
            $stmt->execute(array($id));

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $result['color'] = array();
            $stmtc = $this->db->prepare("SELECT color_accessories.*,excel_accessories.quantity,excel_accessories.price_dollars FROM `color_accessories` left   join excel_accessories on excel_accessories.code = color_accessories.code WHERE  color_accessories.id_item=?  ");
            $stmtc->execute(array($id));
            while ($row = $stmtc->fetch(PDO::FETCH_ASSOC)) {
                $row['image'] = $this->save_file . $row['img'];
                $row['table'] = $model;
                $codex=$row['code'];
                $row['code'] = array();

                $row['code'][0]['price_dollars'] =$row['price_dollars'];
                $row['code'][0]['code'] =$codex;
                $row['code'][0]['price'] = $this->price_dollarsAdmin($row['price_dollars']);
                if (empty($row['quantity'])) {
                    $row['code'][0]['quantity'] = 0;
                }else
                {
                    $row['code'][0]['quantity'] = $row['quantity'];
                }
                $row['code'][0]['size'] = '';
                $result['color'][] = $row;
            }
        }
        else if ($model=='savers')
        {


            $stmt = $this->db->prepare("SELECT id,title,serial_flag,enter_serial  FROM `product_savers` WHERE  id=?     ");
            $stmt->execute(array($id));

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $result['color'] = array();
            $stmtc = $this->db->prepare("SELECT product_savers.*,excel_savers.quantity,excel_savers.price_dollars FROM `product_savers` left   join excel_savers on excel_savers.code = product_savers.code WHERE  product_savers.id=?  ");
            $stmtc->execute(array($id));
            while ($row = $stmtc->fetch(PDO::FETCH_ASSOC)) {
                $row['image'] = $this->save_file . $row['img'];
                $row['table'] = $model;
                $codex=$row['code'];
                $row['code'] = array();

                $row['code'][0]['price_dollars'] =$row['price_dollars'];
                $row['code'][0]['code'] =$codex;
                $row['code'][0]['price'] = $this->price_dollarsAdmin($row['price_dollars']);
                if (empty($row['quantity'])) {
                    $row['code'][0]['quantity'] = 0;
                }else
                {
                    $row['code'][0]['quantity'] = $row['quantity'];
                }
                $row['code'][0]['size'] = '';
                $result['color'][] = $row;
            }
        }





        if (!empty($result))
        {
            require($this->render($this->folder, 'html', 'data', 'php'));

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
            if ($row['id_prepared']){
                $seles=$this->UserInfo($row['id_prepared']);
            }else
            {
                $seles=$this->UserInfo($row['user_direct']);

            }


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


    }




function load_order()
{




    $c=implode(',',$this->catgUser);



    $stmt = $this->db->prepare("SELECT cart_shop_active.*,register_user.name,register_user.phone,register_user.id FROM `cart_shop_active` INNER JOIN register_user ON register_user.id=cart_shop_active.id_member_r WHERE  cart_shop_active.`accountant` = 1  AND cart_shop_active.`prepared` = 1  AND cart_shop_active.cancel=0 AND cart_shop_active.buy <> 3 AND cart_shop_active.`table`  IN ({$c})   GROUP BY cart_shop_active.`number_bill`,cart_shop_active.`id_member_r`  ORDER BY cart_shop_active.`number_bill` ASC ");
    $stmt->execute();


    $count_active=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//        $row['sumbill']=$this->sunBill($row['id_member_r'],$row['number_bill']);
        $row['date_order']=date('Y-m-d h:i A',$row['date_req']);
        $row['id_accountant_user'] = $this->UserInfo($row['id_accountant_user']);
        $count_active[] = $row;

    }


    require($this->render($this->folder, 'html', 'load_order', 'php'));


}



function load_order_acount()
{




        $c=implode(',',$this->catgUser);

        $stmt = $this->db->prepare("SELECT `cart_shop_active`.*,register_user.name,register_user.phone ,register_user.id  FROM `cart_shop_active` INNER JOIN register_user ON register_user.id = cart_shop_active.id_member_r WHERE   `cart_shop_active`.`accountant` = 0 AND `cart_shop_active`.`buy` <> 0 AND `table` IN ({$c})  AND `cart_shop_active`.`number_bill` <> 0  AND `cart_shop_active`.`cancel`=0 GROUP BY `cart_shop_active`.`number_bill`,`cart_shop_active`.id_member_r  ORDER BY   `cart_shop_active`.`number_bill` ASC ");
        $stmt->execute();


//        $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   `user_direct` =?  AND  `accountant` = 1  AND `prepared` = 1 AND  done_direct =0 AND `direct` =3 AND `back_to`=0  GROUP BY `number_bill`  ORDER BY `number_bill` ASC ");
//        $stmt->execute(array($this->userid));

    $count_active=array();

    while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
    {


        $row['sumbill']=$this->sunBill($row['id_member_r'],$row['number_bill']);
        $row['date_order']=date('Y-m-d h:i A',$row['date_req']);
        $row_user['id_accountant_user'] = $this->UserInfo($row['id_accountant_user']);

        $count_active[]=$row;

    }






    require($this->render($this->folder, 'html', 'load_order_acount', 'php'));


}


    public function rewind_cancel()
    {


        if ($this->handleLogin()) {

            $this->adminHeaderController($this->langControl('rewind_cancel'));
            $stmt = $this->db->prepare("SELECT review.*  FROM  `review_item` INNER JOIN review ON  review.number_bill_new =review_item.number_bill_new WHERE   review_item.`active`=0  AND review_item.cancel=1     GROUP BY review.`id_customre`,review.`number_bill_new`");
            $stmt->execute();
            $rewind_active = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $rewind_active[] = $row;

            }


            require($this->render($this->folder, 'html', 'rewind_cancel', 'php'));

            $this->adminFooterController();
        }
    }


    function view_rewind($id,$number_bill)
    {

        if ($this->handleLogin()) {

            $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ?    LIMIT 1");
            $stmt->execute(array($id));
            $result = $stmt->fetch();

            $stmtr = $this->db->prepare("SELECT review_item.*,COUNT(id) as number FROM `review_item` WHERE   `id_customre` = ?   AND `number_bill_new`= ? AND `active`= 0  AND cancel=1 GROUP BY id_item,code,`table`");
            $stmtr->execute(array($id,$number_bill));
            $rewind_active = array();
            $price=0;
            $number_type=0;
            $sum_material=0;
            while ($row = $stmtr->fetch(PDO::FETCH_ASSOC)) {
                $price=$price+$row['price_new'];
                $row['username']=$this->UserInfo($row['id_prepared']);

                $row['now_price']=0;
                $number_bill=$row['number_bill_new'];
                $number_type=$number_type+1;
                $sum_material=$sum_material+$row['number'];
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


            require($this->render($this->folder, 'html', 'view_rewind_cancel', 'php'));
        }
    }


    function  rewind_search_new()
    {
        if ($this->handleLogin())
        {

            $search = strip_tags(trim($_GET['value']));
            $q = '%' . $search . '%';
            $stmt = $this->db->prepare("SELECT *FROM `review_item` INNER JOIN review ON  review.number_bill_new =review_item.number_bill_new WHERE ( review.name LIKE ? OR  review.phone LIKE ? )  AND review.`active`=0  AND review_item.cancel=1 GROUP BY review.`id_customre`  LIMIT 15");
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

    function cancel_rewind($id,$number_bill)
    {
        if ($this->handleLogin())
        {

            $stmtt=$this->db->prepare("SELECT *FROM `review_item` WHERE  `id_customre` = ? AND number_bill_new =?  AND `cancel`=1  ");
            $stmtt->execute(array($id,$number_bill));
            $newData=array();
            while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC))
            {
                $rowt['active']=1;
                $rowt['id_accountant']=$this->userid;
                $newData[]=$rowt;
            }

            $trace = new trace(); $trace->addtrace('review_item','  الغاء المرتجع من قبل المجهز ',json_encode(array()),json_encode($newData),'  الغاء   المرتج - رقم فاتورة المرتجع الجديد '.$number_bill,$number_bill);

            $stmtdi = $this->db->prepare("UPDATE   `review_item` SET cancel=2,id_prepared_cancel=?,date_prepared_cancel=?  WHERE id_customre = ?  AND number_bill_new =? AND cancel=1 ");
            $stmtdi->execute(array($this->userid,time(),$id,$number_bill));
            if ($stmtdi->rowCount() > 0)
            {
                $result2 = $stmtdi->fetch(PDO::FETCH_ASSOC);

                $trace = new trace(); $trace->addtrace('review_item',' الغاء المرتجع من قبل المجهز ',json_encode(array()),json_encode(array($result2)),'  الغاء   المرتج - رقم فاتورة المرتجع الجديد '.$number_bill,$number_bill);

                $stmtc = $this->db->prepare("SELECT *FROM `review_item` WHERE number_bill_new = ?  AND id_customre =? AND cancel=0");
                $stmtc->execute(array($number_bill,$id));
                if ($stmtc->rowCount() > 0)
                {
                    echo 'true';
                }else
                {

                    $stmtdr = $this->db->prepare("UPDATE   `review` SET cancel=2,id_prepared_cancel=?,date_prepared_cancel=? WHERE  id_customre =?  AND number_bill_new =? AND cancel=1 ");
                    $stmtdr->execute(array($this->userid,time(),$id,$number_bill));
                    if ($stmtdr->rowCount() > 0) {

                        echo 'true';
                    }

                }


            }

        }

    }




    /*------------قيد المرتجع -----------*/


    function rewindNotif_buy()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as num FROM (SELECT COUNT(id) FROM `review` WHERE   `active` = 0 AND cancel =0  GROUP BY `id_customre`) t");
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return  $result['num'];


    }
    public function rewind()
    {


        $this->checkPermit('retrieval',$this->folder);
        $this->adminHeaderController($this->langControl('retrieval'));
        $stmt = $this->db->prepare("SELECT *FROM `review` WHERE   `active` = 0 AND cancel=0 GROUP BY `id_customre`,`number_bill_new`");
        $stmt->execute();
        $rewind_active=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $rewind_active[]=$row;

        }
        require($this->render($this->folder, 'rewind', 'rewind', 'php'));

        $this->adminFooterController();

    }


    function  rewind_search_new3()
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
                <a class='infoCustomer ifactive' id='row{$row['id_customre']}' href='#' onclick='getRewind({$row['id_customre']},{$row['number_bill_new']})'>
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


    function view_rewind3($id,$number_bill)
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


            require($this->render($this->folder, 'rewind', 'view_rewind', 'php'));
        }
    }


    function cancel_rewind3($id,$number_bill)
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

    function success_rewind()
    {



        if ($this->handleLogin()) {
            $id = $_GET['id'];
            $number_bill= $_GET['number_bill'];


            $allMoney_from_star= (int)str_replace($this->comma,'',$this->sumAllMoney($this->userid)) ;

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

                            $this->Add_to_sync_schedule($row['code'],$row['table'],'quantity_adjustment',' ','controllers\direct\direct.php 9003 '.$this->UserInfo($this->userid));


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
                                                $this->filter_location_tracking_quantity($row['code'],$tble,$l,1,'   محاسبة فاتورة مرتجع - رقم4','+',$number_bill);

                                            }else
                                            {
                                                $this->filter_location_error_quantity($row['code'],$tble,$l,1,'   محاسبة فاتورة مرتجع  - رقم الخطا 4','+',$number_bill);

                                            }


                                        } else {
                                            $stmtExcel_conform = $this->db->prepare("INSERT INTO location (quantity,`date`,code,model,location,userid) VALUES (?,?,?,?,?,?)");
                                            $stmtExcel_conform->execute(array(1, time(), $row['code'], $tble, $l, $this->userid));

                                            if($stmtExcel_conform->rowCount()  > 0)
                                            {
                                                $this->filter_location_tracking_quantity($row['code'],$tble,$l,1,'   محاسبة فاتورة مرتجع - رقم39','+',$number_bill);

                                            }else
                                            {
                                                $this->filter_location_error_quantity($row['code'],$tble,$l,1,'   محاسبة فاتورة مرتجع  - رقم الخطا 39','+',$number_bill);

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
                                        $this->filter_error_quantity( $row['code'],$tble,1,'  المحاسب الثانوي محاسبة فاتورة مرتجع   - رقم الخطا 7',$number_bill);
                                    }

                                }

                                else {

                                    $stmtExcel_conform = $this->db->prepare("INSERT INTO  location_confirm (quantity,code,model,`date`,userid)  values (?,?,?,?,?)");
                                    $stmtExcel_conform->execute(array(1, $row['code'], $tble, time(),$this->userid));
                                    if($stmtExcel_conform->rowCount() <=0)
                                    {
                                        $this->filter_error_quantity( $row['code'],$tble,1,'  المحاسب الثانوي محاسبة فاتورة مرتجع   - رقم الخطا 8',$number_bill);
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

            $this->AddToTraceByFunction($this->userid,'direct','success_rewind/'.$id.'/'.$number_bill);


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


    public function rewind_done()
    {

        $this->checkPermit('rewind_done',$this->folder);
        $this->adminHeaderController($this->langControl('rewind_done'));



        require($this->render($this->folder, 'rewind', 'rewind_done', 'php'));
        $this->adminFooterController();
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

            require($this->render($this->folder, 'rewind', 'view_rewind_done', 'php'));
        }
    }

    function  rewind_search()
    {
        if ($this->handleLogin())
        {

            $search = strip_tags(trim($_GET['value']));
            $q = '%' . $search . '%';
            $stmt = $this->db->prepare("SELECT *FROM `review` WHERE ( name LIKE ? OR  phone LIKE ? ) AND `active`=1 GROUP BY `id_customre`  LIMIT 15");
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



            $number_bill = trim(strip_tags($_GET['number_bill']));


            $id=null;
            if (isset($_GET['id_custom']))
            {
                $id=$_GET['id_custom'];
            }


            if ($id)
            {
                $stmtChAcco = $this->db->prepare("SELECT *FROM  `cart_shop_active`  WHERE `number_bill` =? AND `id_member_r`=? AND `buy` = 1  AND cancel=0 AND `accountant`=0 ");
                $stmtChAcco->execute(array($number_bill, $id));

            }else
            {
                $stmtChAcco = $this->db->prepare("SELECT *FROM  `cart_shop_active`  WHERE `number_bill` =?   AND `buy` = 1  AND cancel=0 AND `accountant`=0");
                $stmtChAcco->execute(array($number_bill));

            }


            if ($stmtChAcco->rowCount() > 0) {
                $result = $stmtChAcco->fetch(PDO::FETCH_ASSOC);
                $id = $result['id_member_r'];
                $stmt = $this->getAllContentFromCar_number_bill3_account($id, $number_bill);

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


                $price1 = (int)trim(str_replace($this->comma, '', $price1));

                $stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $oldData = array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
                    $oldData[] =$rowt;
                }


                $stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET    `status` = 1 ,  `accountant` = 1 , `prepared` = 1 , `date_accountant`= ? , `user_id`=?,`id_accountant_user`=?,`top`=0,user_direct=?,auto_print=1  WHERE `number_bill` =? AND `buy` = ?  AND `id_member_r`=?  AND `accountant`=0");
                $stmt2->execute(array(time(), $this->userid, $this->userid,  $this->userid, $number_bill, 1, $id));

                if ($stmt2->rowCount() > 0) {

                    $stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE  `number_bill` = ? ");
                    $stmtt->execute(array($number_bill));
                    $newData = array();
                    while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
                        $newData[] = $rowt;
                    }

                    $trace = new trace();
                    $trace->addtrace('cart_shop_active', 'محاسبة', json_encode($oldData), json_encode($newData), ' محاسبة طلب', $number_bill);




                    $stmt1 = $this->db->prepare("SELECT *FROM  log_accountant  WHERE `id_user` = ? ");
                    $stmt1->execute(array($this->userid));
                    if ($stmt1->rowCount() > 0) {
                        $stmt = $this->db->prepare("UPDATE log_accountant SET `money`=money+? ,`date`=? WHERE `id_user` = ?");
                        $stmt->execute(array($price1, time(), $this->userid));
                    } else {
                        $stmt = $this->db->prepare("INSERT INTO log_accountant (`money`,`username`,`id_user`,`date`) values  (?,?,?,?) ");
                        $stmt->execute(array($price1, $_SESSION['usernamelogin'], $this->userid, time()));
                    }

                    $stmt1x = $this->db->prepare("SELECT *FROM  log_accountant_bill  WHERE `number_bill` = ? ");
                    $stmt1x->execute(array($number_bill));
                    if ($stmt1x->rowCount() > 0) {
                        $stmtx = $this->db->prepare("UPDATE log_accountant_bill SET `money`=money+? ,`date`=?,`update_uer`=? WHERE `number_bill` = ?");
                        $stmtx->execute(array($price1, time(), $this->userid, $number_bill));
                    } else {
                        $stmtx = $this->db->prepare("INSERT INTO log_accountant_bill (`money`,`number_bill`,`username`,`id_user`,`date`) values  (?,?,?,?,?) ");
                        $stmtx->execute(array($price1, $number_bill, $_SESSION['usernamelogin'], $this->userid, time()));
                    }



                    $xstmt = $this->db->prepare("SELECT *FROM `bill` WHERE  `id_member_r` = ? AND number_bill=? AND `userid_accountant`=? ");
                    $xstmt->execute(array($id, $number_bill,$this->userid));
                    if ($xstmt->rowCount() > 0) {
                        $stmt = $this->db->prepare("UPDATE  `bill` SET `sum_bill`=sum_bill+?  WHERE  `id_member_r` = ? AND number_bill=?  AND `userid_accountant`=? ");
                        $stmt->execute(array($price1, $id, $number_bill,$this->userid));

                    } else {
                        $stmt = $this->db->prepare("INSERT INTO `bill` (`userid_accountant`,`id_member_r`,`number_bill`,`sum_bill`,`date`) values (?,?,?,?,?)");
                        $stmt->execute(array($this->userid, $id, $number_bill, $price1, time()));
                    }


                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                echo 'accounted';
            }

        }  else{
            echo 'login';
        }

    }

    function save_note_bill()
    {
        if ($this->handleLogin())
        {
            $note=$_GET['note'];
            $bill=$_GET['bill'];
            $id=$_GET['id'];

            $stmt=$this->db->prepare("UPDATE  cart_shop_active SET  note_prepared=? ,user_note_prepared=? WHERE number_bill=? AND id_member_r=?");
            $stmt->execute(array($note,$this->userid,$bill,$id));
        }


    }

}