<?php

class code extends Controller
{


    function __construct()
    {
        parent::__construct();
        $this->setting=new Setting();
        $this->location_out_pull=array('999','403','402','401');

    }

    function required($flag)
    {
        if ($flag==0)
        {
            $this->setting->set('required_serial_code',0) ;
        }else
        {
            $this->setting->set('required_serial_code',1) ;
        }

    }


      function index()
    {

        $this->checkPermit('check_code', 'code');
        $this->adminHeaderController($this->langControl('check_code'));



        require($this->render($this->folder, 'html', 'index', 'php'));

        $this->adminFooterController();


    }


    function info_serial()
    {


        $serial=$_GET['serial'];

        $stmtpage = $this->db->prepare("SELECT  * FROM serial   WHERE serial=? LIMIT 1");
        $stmtpage->execute(array($serial));
        if ($stmtpage->rowCount() > 0) {
            $result= $stmtpage->fetch(PDO::FETCH_ASSOC);
          echo  json_encode(array('code'=>$result['code'],'model'=>$result['model']));
        }

    }



    function check_serial_required_withdraw()
    {

        $code=trim($_GET['code']);
        if ($this->check_serial_required($code,'serial_withdraw')==true)
        {
           echo 'true';
        }

    }






    function get()
    {
            if ($this->handleLogin()) {
                $this->checkPermit('check_code', 'code');

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
                    $device[0]['price_dollars']=$result['price_dollars'];
                    $device[0]['price']=$this->price_dollarsAdmin($result['price_dollars']);
                    $device[0]['r_price']=$this->price_dollars($result['price_dollars']);




                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1  AND `status` =0    AND `table`='mobile' ");
                    $stmt_order->execute(array($result['code']));
                    $only_order=$stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order']=$only_order['num'];


                    $stmt_cd = $this->db->prepare("SELECT  `id_color`  FROM `code` WHERE `code` =?  ");
                    $stmt_cd->execute(array($result['code']));
                    $id_color=$stmt_cd->fetch(PDO::FETCH_ASSOC);


                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`color`  FROM `color` WHERE `id` =?  ");
                    $stmt_img->execute(array($id_color['id_color']));
                    $img_div=$stmt_img->fetch(PDO::FETCH_ASSOC);


                    $device[0]['img']=$this->save_file.$img_div['img'];
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
                    $stmtCode_camera = $this->db->prepare("SELECT *FROM `excel_camera` WHERE `code`=?");
                    $stmtCode_camera->execute(array($code));
                    if ($stmtCode_camera->rowCount() > 0) {
                        $result = $stmtCode_camera->fetch(PDO::FETCH_ASSOC);


                        $device[0]['quantity']=$result['quantity'];
                        $device[0]['price_dollars']=$result['price_dollars'];
                        $device[0]['price']=$this->price_dollarsAdmin($result['price_dollars']);
                        $device[0]['r_price']=$this->price_dollars($result['price_dollars']);



                        $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='camera' ");
                        $stmt_order->execute(array($result['code']));
                        $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                        $device[0]['order'] = $only_order['num'];



                        $stmt_cd = $this->db->prepare("SELECT  `id_color`  FROM `code_camera` WHERE `code` =?  ");
                        $stmt_cd->execute(array($result['code']));
                        $id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);

                        $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color ,`color` FROM `color_camera` WHERE `id` =?  ");
                        $stmt_img->execute(array($id_color['id_color']));
                        $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                        $device[0]['img'] = $this->save_file . $img_div['img'];
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
                    $stmtCode_printing_supplies = $this->db->prepare("SELECT *FROM `excel_printing_supplies` WHERE `code`=?");
                    $stmtCode_printing_supplies->execute(array($code));
                    if ($stmtCode_printing_supplies->rowCount() > 0) {
                        $result = $stmtCode_printing_supplies->fetch(PDO::FETCH_ASSOC);


                        $device[0]['quantity']=$result['quantity'];
                        $device[0]['price_dollars']=$result['price_dollars'];
                        $device[0]['price']=$this->price_dollarsAdmin($result['price_dollars']);
                        $device[0]['r_price']=$this->price_dollars($result['price_dollars']);



                        $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='printing_supplies' ");
                        $stmt_order->execute(array($result['code']));
                        $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                        $device[0]['order'] = $only_order['num'];



                        $stmt_cd = $this->db->prepare("SELECT  `id_color`  FROM `code_printing_supplies` WHERE `code` =?  ");
                        $stmt_cd->execute(array($result['code']));
                        $id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);

                        $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color ,`color` FROM `color_printing_supplies` WHERE `id` =?  ");
                        $stmt_img->execute(array($id_color['id_color']));
                        $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                        $device[0]['img'] = $this->save_file . $img_div['img'];
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
                    $stmtCode_computer = $this->db->prepare("SELECT *FROM `excel_computer` WHERE `code`=?");
                    $stmtCode_computer->execute(array($code));
                    if ($stmtCode_computer->rowCount() > 0) {
                        $result = $stmtCode_computer->fetch(PDO::FETCH_ASSOC);


                        $device[0]['quantity']=$result['quantity'];
                        $device[0]['price_dollars']=$result['price_dollars'];
                        $device[0]['price']=$this->price_dollarsAdmin($result['price_dollars']);
                        $device[0]['r_price']=$this->price_dollars($result['price_dollars']);



                        $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='computer' ");
                        $stmt_order->execute(array($result['code']));
                        $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                        $device[0]['order'] = $only_order['num'];



                        $stmt_cd = $this->db->prepare("SELECT  `id_color`  FROM `code_computer` WHERE `code` =?  ");
                        $stmt_cd->execute(array($result['code']));
                        $id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);

                        $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color ,`color` FROM `color_computer` WHERE `id` =?  ");
                        $stmt_img->execute(array($id_color['id_color']));
                        $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                        $device[0]['img'] = $this->save_file . $img_div['img'];
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


                            $device[0]['quantity']=$result['quantity'];
                            $device[0]['price_dollars']=$result['price_dollars'];
                            $device[0]['price']=$this->price_dollarsAdmin($result['price_dollars']);
                            $device[0]['r_price']=$this->price_dollars($result['price_dollars']);



                            $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1  AND `status` =0  AND `table`='games' ");
                            $stmt_order->execute(array($result['code']));
                            $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                            $device[0]['order'] = $only_order['num'];



                            $stmt_cd = $this->db->prepare("SELECT  `id_color`  FROM `code_games` WHERE `code` =?  ");
                            $stmt_cd->execute(array($result['code']));
                            $id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);

                            $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`color`  FROM `color_games` WHERE `id` =?  ");
                            $stmt_img->execute(array($id_color['id_color']));
                            $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                            $device[0]['img'] = $this->save_file . $img_div['img'];
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


                                $device[0]['quantity']=$result['quantity'];
                                $device[0]['price_dollars']=$result['price_dollars'];
                                $device[0]['price']=$this->price_dollarsAdmin($result['price_dollars']);
                                $device[0]['r_price']=$this->price_dollars($result['price_dollars']);


                                $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0   AND `table`='network' ");
                                $stmt_order->execute(array($result['code']));
                                $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                                $device[0]['order'] = $only_order['num'];



                                $stmt_cd = $this->db->prepare("SELECT  `id_color`  FROM `code_network` WHERE `code` =?  ");
                                $stmt_cd->execute(array($result['code']));
                                $id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);

                                $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`color`  FROM `color_network` WHERE `id` =?  ");
                                $stmt_img->execute(array($id_color['id_color']));
                                $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                                $device[0]['img'] = $this->save_file . $img_div['img'];
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

                               // $color = strip_tags(trim($_POST['color']));

                                $stmtCode_accessories = $this->db->prepare("SELECT *FROM `excel_accessories` WHERE `code`=? ");
                                $stmtCode_accessories->execute(array($code));
                                if ($stmtCode_accessories->rowCount() > 0) {
                                    $result = $stmtCode_accessories->fetch(PDO::FETCH_ASSOC);


                                    $device[0]['quantity']=$result['quantity'];
                                    $device[0]['price_dollars']=$result['price_dollars'];
                                    $device[0]['price']=$this->price_dollarsAdmin($result['price_dollars']);
                                    $device[0]['r_price']=$this->price_dollars($result['price_dollars']);



                                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?    AND `buy` = 1 AND `status` =0  AND `table`='accessories' ");
                                    $stmt_order->execute(array($result['code']));
                                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                                    $device[0]['order'] = $only_order['num'];




                                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`color`  FROM `color_accessories` WHERE `code` =?  ");
                                    $stmt_img->execute(array($result['code']));
                                    $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                                    $device[0]['img'] = $this->save_file . $img_div['img'];
                                    $device[0]['color'] = $img_div['code_color'];
                                    $device[0]['name_color'] = $img_div['color'];

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

                                $stmtCode_network = $this->db->prepare("SELECT *FROM `excel_savers` WHERE `code`=?   ");
                                $stmtCode_network->execute(array($code));
                                if ($stmtCode_network->rowCount() > 0) {
                                    $result = $stmtCode_network->fetch(PDO::FETCH_ASSOC);


                                    $device[0]['quantity']=$result['quantity'];
                                    $device[0]['price_dollars']=$result['price_dollars'];
                                    $device[0]['price']=$this->price_dollarsAdmin($result['price_dollars']);
                                    $device[0]['r_price']=$this->price_dollars($result['price_dollars']);

                                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?   AND `buy` = 1 AND `status` =0   AND `table`='product_savers' ");
                                    $stmt_order->execute(array($result['code']));
                                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                                    $device[0]['order'] = $only_order['num'];
                                    $device[0]['name_color'] ='';


                                    $stmt_name = $this->db->prepare("SELECT  *  FROM `product_savers` WHERE  `code` =?");
                                    $stmt_name->execute(array( $result['code']));
                                    $name_device = $stmt_name->fetch(PDO::FETCH_ASSOC);
                                    $device[0]['name'] = $name_device['title'];
                                    $device[0]['id'] = $name_device['id'];
									$device[0]['img'] = $this->save_file . $name_device['img'];
                                    $device[0]['category'] = $this->langControl('savers') ;

                                }

                             }


                require($this->render($this->folder, 'html', 'data', 'php'));


            }
        }



        function color_list($code,$cat)
        {
            $this->checkPermit('check_code', 'code');


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



        function location_list()
        {


        	if ($this->handleLogin())
			{
				$code = trim($_GET['code']);
				$cat = trim($_GET['cat']);


				if ($this->check_active_location($cat,$code)) {


                    $stmt = $this->db->prepare("SELECT *FROM `location` WHERE `code`=? AND `model` =? AND quantity  > 0");
                    $stmt->execute(array($code, $cat));

                    if ($stmt->rowCount() > 0) {
                        $html = ' <small style="color: #9c27b0">تم تفعيل المواقع للمادة        </small> <select class="custom-select mr-sm-2" name="location" id="location_s"  required >  <option value="" selected >اختر موقع</option>   ';

                        $c = 0;
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $dis = null;
                            $style = null;
                            $tool = null;
                            if ($this->UserInfo($this->userid, null, 'location_out_pull') == 0) {
                                if (in_array($row['location'], $this->location_out_pull)) {
                                    $dis = 'disabled';
                                    $style = "style='background:#9e9e9e'";
                                    $tool = '  title="تم تعطيل هذا الموقع لايمكن السحب منه!" ';
                                }
                            }
							// بسبب الاستعجال بموضوع اضافة المواد الموجوده في مستودع حي البلدية راح نسوي فد تلزيكة هنا
                            if ($row['sequence'] >700 and $row['sequence'] <=800) {
                                $dis = 'disabled';
                                $style = "style='background:#d6d6d6'";
                                $tool = '  title="لا يمكن السحب من مستودع البلدية" ';
                            }

                            if ($this->tamayaz_locations_bool($row['location'])) {

                                
                                $html .= "<option  {$dis} {$style}  {$tool} style='color: {$this->tamayaz_locations_color($row['location'])} !important;font-weight:bold '  value='{$row['id']}'>{$row['location']}= كمية ({$row['quantity']})</option>";
                            } else {
                                $html .= "<option {$dis}  {$style}  {$tool} value='{$row['id']}'>{$row['location']}= كمية ({$row['quantity']})</option>";

                            }


                        }
                        echo $html .= '</select>';
                    }else
                    {

                        $html = ' <small style="color: red">تم تفعيل المواقع للمادة        </small> <select class="custom-select mr-sm-2" name="location" id="location_s"  required >  <option value="" selected >اختر موقع</option>   ';
                        $html .= "<option  disabled value=''>لا توجد مواقع تحتوي على كميات </option>";
                        echo $html .= '</select>';

                    }


                }

			}


        }












    /*  function price($dollar)
      {

          $price1=0;
          $p1=0;
          $p2=0;
          $xp1=0;
          $xp2=0;

          $stmtp=$this->db->prepare("SELECT   dollar FROM `dollar_price` WHERE `active`=1 ORDER BY `id` DESC  LIMIT 1" );
          $stmtp->execute();
          if ($stmtp->rowCount() > 0) {
              $resultPD = $stmtp->fetch(PDO::FETCH_ASSOC);

              $price=explode('-',$dollar);
              if (count($price) == 2)
              {
                  $f1=(double)trim(str_replace(',','.',$price[0] ));
                  $f2=(double)trim(str_replace(',','.',$price[1] ));
                  $p1=($f1 * $resultPD['dollar'] );
                  $p2=($f2 * $resultPD['dollar'] );

                  $xp1=$xp1+($p1*$dollar);
                  $xp2=$xp2+($p2*$row['number']);
                  $price1= round($xp1) ;
              }else
              {
                  $f1=(double)trim(str_replace(',','.',$price[0] ));
                  $p1=($f1 * $resultPD['dollar'] );
                  $xp1=$xp1+($p1*$row['number']);
                  $price1=  round($xp1) ;
              }
          }else{

              $price=explode('-',$row['price']);
              if (count($price) == 2) {
                  $f1 = (double)trim(str_replace(',', '.', $price[0]));
                  $f2 = (double)trim(str_replace(',', '.', $price[1]));
                  $p1=$p1+($f1 * $row['number'] );
                  $p2=$p2+($f2 * $row['number'] );
                  $price1= round($p1) ;
              }else
              {
                  $f1 = (double)trim(str_replace(',', '.', $price[0]));
                  $p1=$p1+ ($f1 * $row['number'] );
                  $price1= round($p1) ;
              }
          }

      }


$sum = $price1;
*/



    function  excel()
    {
        $this->checkPermit('excel',$this->folder);
        $this->adminHeaderController($this->langControl('excel'));

        if(isset($_POST["submit"])) {

            $this->AddToTraceByFunction($this->userid,'code','excel');

            try {
                $form = new  Form();



                $form->post('files_normal')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $name_file=json_decode($data['files_normal'],true);

                $inputFileName=$this->root_file.'/files/'.$name_file[0]['rand_name'];
                if (file_exists($inputFileName)) {

                    //  Read your Excel workbook
                    try {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFileName);
                    } catch (Exception $e) {
                        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                    }

                    //  Get worksheet dimensions
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();


                    //  Loop through each row of the worksheet in turn



                    $id_item=0;
                    $color_item='';
                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                            NULL,
                            TRUE,
                            TRUE);


                        if (count($rowData[0])  >= 4)
                        {


                            $model=$this->model_code($rowData[0][0]);



                            if ($model == 'mobile') {
                                $excel = 'excel';
                                $color = 'color';
                                $code = 'code';
                            } else  {
                                $excel = 'excel_'.$model;
                                $color = 'color_'.$model;
                                $code = 'code_'.$model;
                            }



                            $stmtch=$this->db->prepare("SELECT *FROM {$excel} WHERE code=? ");
                            $stmtch->execute(array( $rowData[0][0]));
                            if ($stmtch->rowCount() > 0)
                            {


                                $result=$stmtch->fetch(PDO::FETCH_ASSOC);

                                if ($rowData[0][1] > $result['quantity'])
                                {
                                    $quantity=0;
                                }else{
                                    $quantity=   $rowData[0][1];
                                }


                                if ($model == 'accessories') {
                                    $stmtg=$this->db->prepare("SELECT color_accessories.id_item ,color_accessories.color FROM `color_accessories`  WHERE color_accessories.code =? LIMIT 1");
                                    $stmtg->execute(array( $rowData[0][0]));

                                }
                                else if ($model == 'savers')
                                {
                                    $stmtg=$this->db->prepare("SELECT product_savers.id as id_item ,product_savers.color FROM `product_savers`   WHERE product_savers.code =? LIMIT 1");
                                    $stmtg->execute(array( $rowData[0][0]));

                                }else
                                {
                                    $stmtg=$this->db->prepare("SELECT {$color}.id_item ,{$color}.color FROM `{$code}` INNER JOIN {$color} ON {$color}.id = {$code}.id_color WHERE {$code}.code =? LIMIT 1");
                                    $stmtg->execute(array( $rowData[0][0]));

                                }


                                if ($stmtg->rowCount()> 0) {

                                    $re = $stmtg->fetch(PDO::FETCH_ASSOC);
                                    $id_item = $re['id_item'];
                                    $color_item = $re['color'];
                                    $stmtlcq = $this->db->prepare("SELECT  *FROM location  WHERE code=? AND  location=? AND  model=? ");
                                    $stmtlcq->execute(array($rowData[0][0], $rowData[0][2], $model));
                                    if ($stmtlcq->rowCount() > 0) {

                                        $result2 = $stmtlcq->fetch(PDO::FETCH_ASSOC);
                                        $ex = '';
                                        if ($rowData[0][1] > $result2['quantity']) {

                                            $qdrw = (int)$result2['quantity'];
                                            $ex = $rowData[0][1];

                                        } else {

                                            $qdrw = $rowData[0][1];
                                        }

                                        $stmtl = $this->db->prepare("UPDATE location SET quantity=quantity - ? ,`date`=?,userid=? WHERE code=? AND  location=? AND  model=? ");
                                        $stmtl->execute(array($qdrw, time(), $this->userid, $rowData[0][0], $rowData[0][2], $model));
                                        if ($stmtl->rowCount() > 0) {

                                            $this->filter_location_tracking_quantity($rowData[0][0], $model, $rowData[0][2], $qdrw, '   سحب بستخدام الاكسيل - رقم54', '-', $rowData[0][3]);


                                            $stmt = $this->db->prepare("INSERT INTO `report_withdrawn` (`id_product`,`code`,`quantity`,`note`,`userid`,`date`,`category`,`name_color`,`location`,`q_excel`) VALUES (?,?,?,?,?,?,?,?,?,?)");
                                            $stmt->execute(array($id_item, $rowData[0][0], $qdrw, $rowData[0][3], $this->userid, time(), $model, $color_item, $rowData[0][2], $ex));
                                                if ($stmt->rowCount() > 0) {
                                                    $stmt2 = $this->db->prepare("UPDATE  `{$excel}` SET `quantity`=`quantity` - ? , `date`=? , userid =?  WHERE  `code`= ?  ");
                                                    $stmt2->execute(array($qdrw, time(), $this->userid, $rowData[0][0]));

                                                    $this->Add_to_sync_schedule($rowData[0][0], $model, 'quantity_adjustment', ' ', '713 سحب  باكسل');
                                                }
                                        }else
                                        {
                                            $this->filter_location_error_quantity($rowData[0][0], $model, $rowData[0][2], $qdrw, '   تجهيز الطلب بائع ومحاسب ومجهز  - رقم الخطا 54', '-', $rowData[0][3]);

                                        }

                                    } else {

                                        $stmtTopQ = $this->db->prepare("SELECT  *FROM location  WHERE code=? AND   model=? ");
                                        $stmtTopQ->execute(array($rowData[0][0], $model));
                                        if ($stmtTopQ->rowCount() > 0) {

                                            $getLocation = $this->get_location($rowData[0][0], $model, $rowData[0][1]);

                                            if (!empty($getLocation)) {
                                                foreach ($getLocation as $ql) {

                                                    $stmtl = $this->db->prepare("UPDATE location SET quantity=quantity - ?  WHERE code=? AND  location=? AND  model=? ");
                                                    $stmtl->execute(array($ql['qget'], $ql['code'], $ql['location'], $ql['model']));
                                                    if ($stmtl->rowCount() > 0) {

                                                        $this->filter_location_tracking_quantity($rowData[0][0], $model, $rowData[0][2], $ql['qget'], '   سحب بستخدام الاكسيل - رقم55', '-', $rowData[0][3]);


                                                        $stmt = $this->db->prepare("INSERT INTO `report_withdrawn` (`id_product`,`code`,`quantity`,`note`,`userid`,`date`,`category`,`name_color`,`location`,`q_excel`) VALUES (?,?,?,?,?,?,?,?,?,?)");
                                                        $stmt->execute(array($id_item,$ql['code'], $ql['qget'], $rowData[0][3], $this->userid, time(), $ql['model'], $color_item, $ql['location'], $rowData[0][1]));
                                                      if ($stmt->rowCount() > 0) {
                                                          $this->Add_to_sync_schedule($rowData[0][0], $model, 'quantity_adjustment', ' ', '763 سحب  باكسل');

                                                          $stmt2 = $this->db->prepare("UPDATE  `{$excel}` SET `quantity`=`quantity` - ? WHERE  `code`= ?  ");
                                                          $stmt2->execute(array($ql['qget'], $ql['code']));
                                                      }
                                                    }else
                                                    {
                                                        $this->filter_location_error_quantity($rowData[0][0], $model, $rowData[0][2], $ql['qget'],'   تجهيز الطلب بائع ومحاسب ومجهز  - رقم الخطا 55', '-', $rowData[0][3]);

                                                    }


                                                }

                                            }

                                        } else {


                                            $stmtTopQ = $this->db->prepare("SELECT  *FROM `{$excel}`  WHERE code=?   LIMIT 1");
                                            $stmtTopQ->execute(array($rowData[0][0]));
                                            if ($stmtTopQ->rowCount() > 0) {

                                                $result2 = $stmtTopQ->fetch(PDO::FETCH_ASSOC);

                                                if ($rowData[0][1] > $result2['quantity']) {

                                                    $qdrw = (int)$result2['quantity'];
                                                    $ex = $rowData[0][1];
                                                } else {

                                                    $qdrw = $rowData[0][1];
                                                    $ex = $rowData[0][1];
                                                }


                                                $stmt = $this->db->prepare("INSERT INTO `report_withdrawn` (`id_product`,`code`,`quantity`,`note`,`userid`,`date`,`category`,`name_color`,`location`,`q_excel`) VALUES (?,?,?,?,?,?,?,?,?,?)");
                                                $stmt->execute(array($id_item, $rowData[0][0], $qdrw, $rowData[0][3], $this->userid, time(), $model, $color_item, 'no location in excel or code not have location', $ex));
                                                if ($stmt->rowCount() > 0) {
                                                    $stmt2 = $this->db->prepare("UPDATE  `{$excel}` SET `quantity`=`quantity` - ? WHERE  `code`= ?  ");
                                                    $stmt2->execute(array($qdrw, $rowData[0][0]));

                                                    $stmtChCodeConform = $this->db->prepare("SELECT *FROM location_confirm WHERE code =? AND model=? ");
                                                    $stmtChCodeConform->execute(array($rowData[0][0], $model));
                                                    if ($stmtChCodeConform->rowCount() > 0) {

                                                        $stmtExcel_conform = $this->db->prepare("UPDATE location_confirm SET  quantity=quantity - {$qdrw} ,`date`=?,userid=?  WHERE code =? AND  model=?");
                                                        $stmtExcel_conform->execute(array(time(),$this->userid, $rowData[0][0], $model));
                                                        if ($stmtExcel_conform->rowCount() > 0)
                                                        {
                                                            $stmtExcel_conform = $this->db->prepare("UPDATE location_confirm SET  quantity=0 ,`date`=?,userid=?  WHERE code =? AND  model=? AND  quantity < 0 ");
                                                            $stmtExcel_conform->execute(array(time(),$this->userid, $rowData[0][0], $model));
                                                        }else
                                                        {
                                                            $this->filter_error_quantity($rowData[0][0], $model, $qdrw, '  سحب بستخدام اكسيل    - رقم الخطا 51');

                                                        }

                                                    }

                                                    $this->Add_to_sync_schedule($rowData[0][0], $model, 'quantity_adjustment', ' ', '811 سحب  باكسل');

                                                }
                                            }


                                        }


                                    }


                                }

                            }



                        }else{
                            $this->error_form=json_encode(array('files_normal'=>'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
                            break;
                        }

                    }

                    @unlink($inputFileName);
                }else
                {

                    $this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form))
                {
                  $this->lightRedirect(url.'/'.$this->folder);

                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'html','excel','php'));
        $this->adminFooterController();
    }



    function getQlocation($code,$model,$q)
    {


        $stmtTopQ=$this->db->prepare("SELECT  location,quantity,code,model FROM location  WHERE code=? AND   model=?  ORDER BY quantity DESC  ");
        $stmtTopQ->execute(array($code,$model));
        $locatinGwt=array();
        while ($row = $stmtTopQ->fetch(PDO::FETCH_ASSOC))
        {

          if ($row['quantity'] > 0) {
              if ($q > 0) {
                  if ($q > $row['quantity']) {
                      $q = $q - $row['quantity'];
                      $row['qget'] = $row['quantity'];

                  } else if ($row['quantity'] >= $q) {

                      $row['qget'] = $q;
                      $q = 0;
                  } else {
                      break;
                  }
              } else {
                  break;
              }
              $locatinGwt[]=$row;
          }

        }

        print_r($locatinGwt);
    }





}


