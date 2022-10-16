<?php


class Header extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->setting=new Setting();
    }


    public function adminHeader($title,$id=null)
    {

        $this->title =$title;



        $min=0;
        if ($this->permit('min_max', 'accessories')) {

            $stmt = $this->db->prepare("SELECT color_accessories.id FROM color_accessories   inner JOIN accessories ON color_accessories.id_item = accessories.id  JOIN excel_accessories ON color_accessories.code = excel_accessories.code  WHERE  excel_accessories.quantity < color_accessories.minimum LIMIT 1");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $min = 1;
            }

        }
       require( $this->render($this->folder,'html','adminHeader','php'));

    }



    public function menu($id=null)
    {
        $gallery = new Gallery();

        if ($this->permit('gallery', 'gallery')) {
            $galleryCategory = $gallery->select_category_gallery(0);
            $category_gallery = array();
            while ($row = $galleryCategory->fetch(PDO::FETCH_ASSOC)) {
                $category_gallery[] = $row;
            }
        }

        $category_mobile=array();
        if ($this->permit('mobile', 'mobile')) {
            $mobile = new mobile();
            $stmt_category_mobile = $mobile->select_category_mobile(0);
            while ($row = $stmt_category_mobile->fetch(PDO::FETCH_ASSOC)) {

                $category_mobile[] = $row;
            }
        }


        $category_games = array();
        if ($this->permit('games', 'games')) {
            $games =new games();
            $stmt_category_games = $games->select_category_games(0);
            while ($row = $stmt_category_games->fetch(PDO::FETCH_ASSOC)) {

                $category_games[] = $row;
            }
        }


        $category_camera=array();
        if ($this->permit('camera', 'camera')) {
            $camera = new camera();
            $stmt_category_camera = $camera->select_category_camera(0);
            while ($row = $stmt_category_camera->fetch(PDO::FETCH_ASSOC)) {

                $category_camera[] = $row;
            }
        }


        $category_printing_supplies = array();
        if ($this->permit('printing_supplies', 'printing_supplies')) {
            $printing_supplies = new printing_supplies();
            $stmt_category_printing_supplies = $printing_supplies->select_category_printing_supplies(0);
            while ($row = $stmt_category_printing_supplies->fetch(PDO::FETCH_ASSOC)) {

                $category_printing_supplies[] = $row;
            }
        }

        $category_computer = array();
        if ($this->permit('computer', 'computer')) {
            $computer = new computer();
            $stmt_category_computer = $computer->select_category_computer(0);
            while ($row = $stmt_category_computer->fetch(PDO::FETCH_ASSOC)) {

                $category_computer[] = $row;
            }

        }

        $category_network = array();

        if ($this->permit('network', 'network')) {

            $network = new network();
            $stmt_category_network = $network->select_category_network(0);

            while ($row = $stmt_category_network->fetch(PDO::FETCH_ASSOC)) {

                $category_network[] = $row;
            }
        }

        $category_accessories = array();

        if ($this->permit('accessories', 'accessories')) {

            $accessories = new Accessories();
            $stmt_category_accessories = $accessories->select_category_accessories(0);

            while ($row = $stmt_category_accessories->fetch(PDO::FETCH_ASSOC)) {
                $category_accessories[] = $row;
            }
        }

        $categorygroups = array();
        if ($this->permit('list_groups', 'groups')) {
            $groups = new groups();
            $category = $groups->select_category_groups(0);
            while ($row = $category->fetch(PDO::FETCH_ASSOC)) {
                $categorygroups[] = $row;
            }

        }

//        $cards =new cards();
//        $category=$cards->select_category_cards(0);
//        $categorycards=array();
//            while ($row=$category->fetch(PDO::FETCH_ASSOC))
//            {
//                $categorycards[]=$row;
//            }
//
//

        $categorypages = array();

        if ($this->permit('list_pages', 'pages')) {
            $pages = new pages();
            $category = $pages->select_category_pages(0);
            while ($row = $category->fetch(PDO::FETCH_ASSOC)) {
                $categorypages[] = $row;
            }

        }

        $category_parts = array();

        if ($this->permit('parts', 'parts')) {

            $parts = new parts();
            $stmt_category_parts = $parts->select_category_parts(0);
            while ($row = $stmt_category_parts->fetch(PDO::FETCH_ASSOC)) {
                $category_parts[] = $row;
            }

        }

        $group_user = array();
        if ($this->permit('user', 'user')) {
            $user = new User();
            $group_stmt = $user->select_all_group_user();
            while ($row_gp = $group_stmt->fetch(PDO::FETCH_ASSOC)) {
                $group_user[] = $row_gp;
            }
        }

        $wc=array();
        if ($this->permit('compare_warehouses', 'compare_warehouses')) {

            $stmtcw = $this->db->prepare("SELECT *FROM `warehouses_category` ORDER BY id DESC LIMIT 1");
            $stmtcw->execute();
            while ($r = $stmtcw->fetch(PDO::FETCH_ASSOC)) {
                $wc[] = $r;
            }
        }


        $accountCatg = '';
        if ($this->permit('account', 'account')) {
            $account = new Account();
            $accountCatg .=  $account->account_catg();
        }

       require( $this->render($this->folder,'html','menu','php'));

    }



        public function currency($v)
        {

            if ($v=='iq')
            {
                $v=0;
            }else
            {
                $v=1;
            }
           // setcookie("currency", $v ,time() + (86400 * 30), "/");
          echo 'true';
        }


        function active_mode_bast_it($active)
        {
            if ($active == 1)
            {
                $_SESSION['bast_it']=1;
               echo 1;
            }else
            {
               unset($_SESSION['bast_it']);
                echo 0;
            }


        }

    public function public_header($title)
    {

        $url=url;
        if (isset($_COOKIE['g_active']))
        {
            $url=url.'/games/disk?g=1';

            if (!isset($_SESSION['usernamelogin']))
            {

                if (isset($_COOKIE['g_active']))
                {
                    $stmt_login = $this->db->prepare("SELECT *FROM `user` WHERE id=?   LIMIT 1");
                    $stmt_login->execute(array($_COOKIE['id_user_disk']));
                    if ($stmt_login->rowCount() > 0)
                    {
                        $data_login = $stmt_login->fetch(PDO::FETCH_ASSOC);

                        Session::set('role', $data_login['role']);
                        Session::set('loggedIn', $data_login['password']);
                        Session::set('userid', $data_login['id']);
                        Session::set('idGroup', $data_login['idGroup']);
                        Session::set('usernamelogin', $data_login['username']);
                        Session::set('print', $data_login['print']);
                        Session::set('number_copy', $data_login['number_copy']);
                        Session::set('CSRFToken', $this->generateToken(25));
                        Session::set('direct', 1);

                        $stmtx = $this->db->prepare("SELECT   `id_member_r`  FROM  `cart_shop_active` WHERE  `user_direct`  = ?  AND number_bill = 0 GROUP BY `user_direct` ");
                        $stmtx->execute(array($data_login['id']));
                        if ($stmtx->rowCount() > 0) {
                            $r = $stmtx->fetch(PDO::FETCH_ASSOC);
                            if (!is_numeric($r['id_member_r'])) {
                                Session::set('uuid', $r['id_member_r']);
                            } else {
                                Session::set('uuid', $this->uuid(4));
                            }
                        }
                        else
                        {
                            Session::set('uuid', $this->uuid(4));
                        }

                    }else
                    {
                        header("Location:" . url . "/enter");
                    }



                }else
                {
                    header("Location:" . url . "/enter");
                }




            }

        }else{

            if (!isset($_SESSION['username_member_r']) && $this->loginUser() != true) {

                header("Location:" . url . "/enter");

            }

        }


//        if ($this->loginUser()  != true ) {
//            if (!isset($_SESSION['username_member_r'])) {
//
//                $phone = '10101010101';
//                $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE `phone`=? ");
//                $stmt->execute(array($phone));
//                if ($stmt->rowCount() > 0) {
//                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
//                    $_SESSION['username_member_r'] = $result['phone'];
//                    $_SESSION['id_member_r'] = $result['id'];
//                    $_SESSION['name_r'] = $result['name'];
//                    $_SESSION['typeLogin'] = $result['login'];
//
//                }
//
//                if (!isset($_SESSION['username_member_r']) && $this->loginUser() != true) {
//
//                    header("Location:" . url . "/enter");
//
//                }
//            }
////        if (!isset($_SESSION['username_member_r']) && $this->loginUser() != true) {
////
////            header("Location:" . url . "/enter");
////
////        }
//        }




        $this->title =$title;
        if ($this->setting->get('id_logo') != 0) {
            $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $this->setting->get('id_logo'), ':module' => 'logo_site'));
            $get_file = $get_file[0];
            $Img = $this->save_file .$get_file['rand_name'];

        }else
        {
            $Img=$this->static_file_control.'/image/site/logo.png';
        }






        $pages =new pages();
        $category=$pages->select_category_pages_public(0);
        $categorypages=array();
        while ($row=$category->fetch(PDO::FETCH_ASSOC))
        {
            $categorypages[]=$row;
        }




        $city=array(
            'بغداد',
            'كربلاء المقدسة',
            'بابل',
            'النجف الأشرف',
            'ميسان',
            'الأنبار',
            'أربيل',
            'البصرة',
            'دهوك',
            'القادسية',
            'ديالى',
            'ذي قار',
            'السليمانية',
            'صلاح الدين',
            'كركوك',
            'المثنى',
            'نينوى',
            'واسط',
        );


        if(!empty($_COOKIE['setLogin'])) {
            if (!isset($_SESSION['username_member_r'])  || $_SESSION['username_member_r'] ==null ) {
                $register= new Register();
                $register ->loginActive();
            }
        }


        $newMsg=0;
        if (isset($_SESSION['username_member_r']))
        {
            $stmt_read=$this->db->prepare("SELECT count(*)   FROM `chat` WHERE `username_r`= ? AND `admin` = ? AND `readUser`=1");
            $stmt_read->execute(array($_SESSION['username_member_r'],'admin'));

            $newMsg=$stmt_read->fetchColumn();

        }
		$mobile = new mobile();
		$category_site_acc_mobile = array();
		$category_mobile = array();
		if ($this->thisCatg('mobile')) {


			$stmt_cat = $mobile->select_category_mobile_public(0);


			while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
				if ($mobile->ck_sub_cat_public($row['id'])) {
					$row['sub'] = 'menu_arow_active dropdown-toggle';
				} else {
					$row['sub'] = '';
				}
				$row['idx'] = $row['id'] . '-mobile';
				$category_mobile[] = $row;
			}


			$stmt_site_table_acc_mobile = $mobile->select_category_mobile_public(0);

			while ($row_s_t_acc_mobile = $stmt_site_table_acc_mobile->fetch(PDO::FETCH_ASSOC)) {
				if ($mobile->ck_sub_cat_public($row_s_t_acc_mobile['id'])) {
					$row_s_t_acc_mobile['sub'] = 'menu_arow_active dropdown-toggle';
				} else {
					$row_s_t_acc_mobile['sub'] = '';
				}
				$category_site_acc_mobile[] = $row_s_t_acc_mobile;
			}


		}

		$category_accessories=array();
		$category_site_acc_accessories=array();
		if ($this->thisCatg('accessories')) {
			$accessories = new accessories();

			$stmt_cat = $accessories->select_category_accessories_public(0);


			while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
				if ($accessories->ck_sub_cat_public($row['id'])) {
					$row['sub'] = 'menu_arow_active dropdown-toggle';
				} else {
					$row['sub'] = '';
				}
				$row['idx'] = $row['id'] . '-accessories';
				$category_accessories[] = $row;
			}

			$stmt_site_table_acc_accessories = $accessories->select_category_accessories_public(0);


			while ($row_s_t_acc_accessories = $stmt_site_table_acc_accessories->fetch(PDO::FETCH_ASSOC)) {
				if ($accessories->ck_sub_cat_public($row_s_t_acc_accessories['id'])) {
					$row_s_t_acc_accessories['sub'] = 'menu_arow_active dropdown-toggle';
				} else {
					$row_s_t_acc_accessories['sub'] = '';
				}
				$category_site_acc_accessories[] = $row_s_t_acc_accessories;
			}
		}





		$category_site_acc_camera = array();
		$category_camera=array();
		if ($this->thisCatg('camera')) {
			$camera = new camera();
			$stmt_cat = $camera->select_category_camera_public(0);


			while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
				if ($camera->ck_sub_cat_public($row['id'])) {
					$row['sub'] = 'menu_arow_active dropdown-toggle';
				} else {
					$row['sub'] = '';
				}
				$row['idx'] = $row['id'] . '-camera';
				$category_camera[] = $row;
			}


			$stmt_site_table_acc_camera = $camera->select_category_camera_public(0);


			while ($row_s_t_acc_camera = $stmt_site_table_acc_camera->fetch(PDO::FETCH_ASSOC)) {
				if ($camera->ck_sub_cat_public($row_s_t_acc_camera['id'])) {
					$row_s_t_acc_camera['sub'] = 'menu_arow_active dropdown-toggle';
				} else {
					$row_s_t_acc_camera['sub'] = '';
				}
				$category_site_acc_camera[] = $row_s_t_acc_camera;
			}
		}




		$category_site_acc_printing_supplies = array();
		$category_printing_supplies=array();
		if ($this->thisCatg('printing_supplies')) {
			$printing_supplies = new printing_supplies();
			$stmt_cat = $printing_supplies->select_category_printing_supplies_public(0);


			while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
				if ($printing_supplies->ck_sub_cat_public($row['id'])) {
					$row['sub'] = 'menu_arow_active dropdown-toggle';
				} else {
					$row['sub'] = '';
				}
				$row['idx'] = $row['id'] . '-printing_supplies';
				$category_printing_supplies[] = $row;
			}


			$stmt_site_table_acc_printing_supplies = $printing_supplies->select_category_printing_supplies_public(0);


			while ($row_s_t_acc_printing_supplies = $stmt_site_table_acc_printing_supplies->fetch(PDO::FETCH_ASSOC)) {
				if ($printing_supplies->ck_sub_cat_public($row_s_t_acc_printing_supplies['id'])) {
					$row_s_t_acc_printing_supplies['sub'] = 'menu_arow_active dropdown-toggle';
				} else {
					$row_s_t_acc_printing_supplies['sub'] = '';
				}
				$category_site_acc_printing_supplies[] = $row_s_t_acc_printing_supplies;
			}
		}





		$category_site_acc_computer = array();
		$category_computer=array();
		if ($this->thisCatg('computer')) {
			$computer = new computer();
			$stmt_cat = $computer->select_category_computer_public(0);


			while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
				if ($computer->ck_sub_cat_public($row['id'])) {
					$row['sub'] = 'menu_arow_active dropdown-toggle';
				} else {
					$row['sub'] = '';
				}
				$row['idx'] = $row['id'] . '-computer';
				$category_computer[] = $row;
			}


			$stmt_site_table_acc_computer = $computer->select_category_computer_public(0);


			while ($row_s_t_acc_computer = $stmt_site_table_acc_computer->fetch(PDO::FETCH_ASSOC)) {
				if ($computer->ck_sub_cat_public($row_s_t_acc_computer['id'])) {
					$row_s_t_acc_computer['sub'] = 'menu_arow_active dropdown-toggle';
				} else {
					$row_s_t_acc_computer['sub'] = '';
				}
				$category_site_acc_computer[] = $row_s_t_acc_computer;
			}
		}






		$category_site_acc_games=array();
		$category_games=array();
		if ($this->thisCatg('games')) {
			$games = new games();
			$stmt_cat = $games->select_category_games_public(0);


			while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
				if ($games->ck_sub_cat_public($row['id'])) {
					$row['sub'] = 'menu_arow_active dropdown-toggle';
				} else {
					$row['sub'] = '';
				}
				$row['idx'] = $row['id'] . '-games';
				$category_games[] = $row;
			}


			$stmt_site_table_acc_games = $games->select_category_games_public(0);


			while ($row_s_t_acc_games = $stmt_site_table_acc_games->fetch(PDO::FETCH_ASSOC)) {
				if ($games->ck_sub_cat_public($row_s_t_acc_games['id'])) {
					$row_s_t_acc_games['sub'] = 'menu_arow_active dropdown-toggle';
				} else {
					$row_s_t_acc_games['sub'] = '';
				}
				$category_site_acc_games[] = $row_s_t_acc_games;
			}
		}


		$category_site_acc_network=array();
		$category_network=array();
		if ($this->thisCatg('network')) {
			$network = new network();
			$stmt_cat = $network->select_category_network_public(0);


			while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
				if ($network->ck_sub_cat_public($row['id'])) {
					$row['sub'] = 'menu_arow_active dropdown-toggle';
				} else {
					$row['sub'] = '';
				}
				$row['idx'] = $row['id'] . '-network';
				$category_network[] = $row;
			}


			$stmt_site_table_acc_network = $network->select_category_network_public(0);


			while ($row_s_t_acc_network = $stmt_site_table_acc_network->fetch(PDO::FETCH_ASSOC)) {
				if ($network->ck_sub_cat_public($row_s_t_acc_network['id'])) {
					$row_s_t_acc_network['sub'] = 'menu_arow_active dropdown-toggle';
				} else {
					$row_s_t_acc_network['sub'] = '';
				}
				$category_site_acc_network[] = $row_s_t_acc_network;
			}
		}




		$sum=0;
		$price1=0;
		$p1=0;
		$p2=0;
		$xp1=0;
		$xp2=0;
		$price1x=0;
		$price2x=0;
        $car=array();
        $count=0;
        if (isset($_SESSION['username_member_r'])  ||  $this->isDirect())
        {
            if ($this->isDirect())
            {
                $id=$this->isUuid();
            }else{
                $id= $_SESSION['id_member_r'];
            }


            $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,   `number` ,`buy`,`date`,`id_offer`,`offers` FROM `cart_shop_active` WHERE `id_member_r` =?  AND `buy` = 0 GROUP BY  `id_offer`,`offers`,`date` ORDER BY `id`  DESC  ");
            $stmt->execute(array($id));

            $buy_x=1;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {


				$row['number']=strip_tags(trim((int)$row['number']));
                $row['img']=$this->save_file.$row['image'];
                $count=$count+$row['number'];
                if ($row['buy']==0)
                {
                    $buy_x=0;
                }


				$row['q_0']=$this->q_0($row['table'],$row['code'],$row['name_color']);
                $car[]=$row;
            }

        }



        $city=array(
            'بغداد',
            'كربلاء المقدسة',
            'بابل',
            'النجف الأشرف',
            'ميسان',
            'الأنبار',
            'أربيل',
            'البصرة',
            'دهوك',
            'القادسية',
            'ديالى',
            'ذي قار',
            'السليمانية',
            'صلاح الدين',
            'كركوك',
            'المثنى',
            'نينوى',
            'واسط',
        );

        if (isset($_SESSION['username_member_r']))
        {
            $id_u = $_SESSION['id_member_r'];
            $reg=new Register();

            $stmt_fb=$reg->checkLoginData($id_u);

        }

        $delivery=false;
        if (isset($_SESSION['username_member_r']))
        {

            $stmt_smile=$this->db->prepare("SELECT *FROM `register_user` WHERE `id`=? AND `delivery_service`=1");
            $stmt_smile->execute(array($_SESSION['id_member_r']));
            if ($stmt_smile->rowCount()> 0 )
            {
                $reslt=$stmt_smile->fetch(PDO::FETCH_ASSOC);
                $delivery=true;
            }
        }

        $quest=false;
        $stmt_q=$this->db->prepare("SELECT *FROM `questions` WHERE `active`=1 " );
        $stmt_q->execute();
        if ($stmt_q->rowCount()>0)
        {
            $quest=true;
        }

        $overBoxMoney=0;

//        if (isset($_SESSION['direct']))
//        {
//
//
//        if ($_SESSION['direct'] == 3)
//        {
//            $stmt=$this->db->prepare("SELECT *FROM `log_accountant` WHERE id_user=? ");
//            $stmt->execute(array($this->userid));
//            $result_d=$stmt->fetch(PDO::FETCH_ASSOC);
//
//
//
//            $stmt_user=$this->db->prepare("SELECT *FROM `user` WHERE id=? ");
//            $stmt_user->execute(array($this->userid));
//            $result_u=$stmt_user->fetch(PDO::FETCH_ASSOC);
//
//            if (!empty( $result_u['money_box']))
//            {
//                if ($result_d['money'] > $result_u['money_box'])
//                {
//                    $overBoxMoney=1;
//                }
//            }
//
//        }
//
//    }

        require( $this->render($this->folder,'html','header','php'));

    }


    function row_cart()
    {

        $id_member_r=$_GET['id_member_r'];
        $code=$_GET['code'];
        $id_item=$_GET['id_item'];
        $table=$_GET['table'];
        $name_color=$_GET['name_color'];

        $stmt=$this->db->prepare("SELECT *FROM cart_shop_active WHERE  id_member_r=? AND code =? AND id_item =? AND `table`=? AND `name_color`=? AND  prepared=0 LIMIT 1" );
        $stmt->execute(array($id_member_r,$code,$id_item,$table,$name_color));
        if ($stmt->rowCount() > 0)
        {

            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($result);

        }


    }

    function note_cart_note()
    {

        $id_member_r=$_POST['id_member_r'];
        $code=$_POST['code'];
        $id_item=$_POST['id_item'];
        $table=$_POST['table'];
        $name_color=$_POST['name_color'];
        $note=$_POST['note'];

        $stmt=$this->db->prepare("UPDATE cart_shop_active SET note=?  WHERE  id_member_r=? AND code =? AND id_item =? AND `table`=? AND `name_color`=? AND  prepared=0 LIMIT 1" );
        $stmt->execute(array($note,$id_member_r,$code,$id_item,$table,$name_color));
        if ($stmt->rowCount() > 0)
        {
           echo 'true';
        }


    }

    function cart()
	{
		$sum=0;
		$price1=0;
		$p1=0;
		$p2=0;
		$xp1=0;
		$xp2=0;
		$price1x=0;
		$price2x=0;
		$car=array();
		$count=0;
		$mobile=new mobile();
		if (isset($_SESSION['username_member_r'])  ||  $this->isDirect())
		{
			if ($this->isDirect())
			{
				$id=$this->isUuid();
			}else{
				$id= $_SESSION['id_member_r'];
			}

//            $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`id_offer`,`offers` FROM `cart_shop_active` WHERE `id_member_r` =?  AND `buy` = 0 GROUP BY  `id_offer`,`offers`,`id_item`,`size`,`table`,`price`,`name_color` ORDER BY `id`  DESC  ");
            $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,   `number` ,`buy`,`date`,`id_offer`,`offers`,`price_type` FROM `cart_shop_active` WHERE `id_member_r` =?  AND `buy` = 0 GROUP BY  `id_offer`,`offers`,`date` ORDER BY `id`  DESC  ");
            $stmt->execute(array($id));

			$buy_x=1;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{


                if ($row['table'] == 'mobile') {
                    $excel = 'excel';
                } else if ($row['table'] == 'accessories') {
                    $excel = 'excel_' . $row['table'];
                } else if ($row['table'] == 'product_savers') {
                    $excel = 'excel_savers';

                } else {
                    $excel = 'excel_' . $row['table'];
                }


                if ($row['offers']  =='offers')
                {
                    if ($this->loginUser() )
                    {
                        $row['price'] = $this->priceDollarOffer($row['id_offer'],4) . ' د.ع ';
                        $row['price_dollars'] = $this->priceDollarOffer($row['id_offer'],3)  ;
                    }else
                    {
                        $row['price'] = $this->priceDollarOffer($row['id_offer'],5) . ' د.ع ';
                        $row['price_dollars'] = $this->priceDollarOffer($row['id_offer'],3)  ;
                    }

                    $row['title']=$this->details_offer($row['id_offer'],'title');

                    $row['img']=$this->save_file.$this->details_offer($row['id_offer'],'img');

                }else   {


                    $stmt_get_item = $this->db->prepare("SELECT *FROM `{$row['table']}` WHERE id = ?  ");
                    $stmt_get_item->execute(array($row['id_item']));
                    $item = $stmt_get_item->fetch();
                    $row['title']=$item['title'];

                    $row['img']=$this->save_file.$row['image'];


                    if ($row['price_type']<=0){
                        $stmt_price = $this->db->prepare("SELECT  *FROM   `{$excel}`  WHERE  `code`=?  ");
                        $stmt_price->execute(array($row['code']));
                        $result_price = $stmt_price->fetch(PDO::FETCH_ASSOC);
                    }else
                    {
                        $result_price['price_dollars']=$row['price_dollars'];
                    }


                    $table_price=$row['table'];
                    $stmt_item = $this->db->prepare("SELECT * from `{$table_price}` WHERE  `id`=?  ");
                    $stmt_item->execute(array($row['id_item']));
                    $result_item = $stmt_item->fetch(PDO::FETCH_ASSOC);


                        if ($this->loginUser() )
                        {

                            $row['price'] = $this->price_dollarsAdmin($result_price['price_dollars']) . ' د.ع ';

                        }else
                        {
                            if ($this->loginUser() )
                            {

                                $row['price'] = $this->price_dollarsAdmin($result_price['price_dollars']) . ' د.ع ';

                            }else
                            {

                               $row['price'] = $this->price_dollars($result_price['price_dollars']) . ' د.ع ';

                            }

                        }



                }





                if ($this->isDirect())
				{
					if (!empty($this->cuts($row['id_item'],$row['table']))) {
						$price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
						$f1 = (double)trim(str_replace(',', '', $price[0]));
						$xp1 = $xp1 + ($f1 * $row['number']);
						$price1= number_format(round($xp1)).' د.ع ';
					}else {
						$price =$this->price_dollarsAdmin($row['price_dollars']);
						$f1 = (int)trim(str_replace(',', '', $price));
						$xp1 = $xp1 + ($f1 * $row['number']);
						$price1= number_format(round($xp1)).' د.ع ';
					}
				}else{
					if (!empty($this->cuts($row['id_item'],$row['table']))) {
						$price = explode('-',$this->cuts($row['id_item'], $row['table']))  ;
						$f1 = (double)trim(str_replace(',', '', $price[0]));
						$xp1 = $xp1 + ($f1 * $row['number']);
						$price1x= $price1x +  round($xp1) ;
						$price2x= $price2x +  round($xp1) ;
					}else{
						$price=explode('-',$this->price_dollars($row['price_dollars']));
						if (count($price) == 2)
						{
							$f1=(int)trim(str_replace(',','',$price[0] ));
							$f2=(int)trim(str_replace(',','',$price[1] ));
							$price1x=$price1x+ ($f1 * $row['number'] );
							$price2x=$price2x+($f2 * $row['number'] );
						}else{
							$f1=(int)trim(str_replace(',','',$price[0] ));
							$price1x=$price1x+ ($f1 * $row['number'] );
							$price2x=$price2x+ ($f1 * $row['number'] );

						}
					}
					$price1=number_format($price1x) .' - '.number_format($price2x).' د.ع ';

				}



				$row['number']=strip_tags(trim((int)$row['number']));

				$count=$count+$row['number'];
				if ($row['buy']==0)
				{
					$buy_x=0;
				}


				$row['q_0']=$this->q_0($row['table'],$row['code'],$row['name_color']);
				$car[]=$row;
			}
		}

		require( $this->render($this->folder,'html','cart','php'));


	}



    public function  xhrInsert()
    {
         $text= $_POST['text'];
         $data=array($text);
        $this->db->insert('models',array('models'=>$text));
        $data=array('models'=>$text,'id'=>$this->db->lastInsertId());
          echo json_encode($data);
    }

    function xhrGetListings()
    {
        $data=$this->db->select("SELECT * from  `models`");
        echo json_encode($data);
    }



}


?>