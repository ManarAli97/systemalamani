<?php

class purchases_man extends Controller
{

    public $ids = array();


    function __construct()
    {
        parent::__construct();
        $this->table = 'purchases';
        $this->points_delegate = 'points_delegate';
        $this->user_purchases_region = 'user_purchases_region';
        $this->user_purchases_catg = 'user_purchases_catg';
        $this->setting = new Setting();
    }


    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `category` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `id_category` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `item` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `image` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `price` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `price_dollars` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `old_quantity` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `quantity` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `sale_quantity` varchar(250) COLLATE utf8_unicode_ci NULL DEFAULT '0',
          `note` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `note_d` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `sales_man` bigint(20) NOT NULL DEFAULT '0',
          `purchases_man` bigint(20) NOT NULL DEFAULT '0',
          `delegate_man` bigint(20) NOT NULL DEFAULT '0',
          `id_user` int(11)  NOT NULL, /*sales_man*/
          `id_user_p` int(11)  NOT NULL,  /*purchases_man*/
          `id_user_d` int(11)  NOT NULL,  /*delegate_man*/
          `edit` int(11)  NOT NULL,
          `id_cat` int(11)  NOT NULL ,
          `id_item` int(11)  NOT NULL ,
          `date` bigint(20) NOT NULL,
          `full_date` bigint(20) NOT NULL,
          `purchases` bigint(20) NOT NULL DEFAULT '0',
          `purchases_finish` bigint(20) NOT NULL DEFAULT '0',
          `date_purchases` bigint(20) NOT NULL,
          `time_purchases` bigint(20) NOT NULL,
          `region` int(20) NOT NULL,
         `checked_purchases` bigint(20) NOT NULL DEFAULT '0',
         `suggestion` bigint(20) NOT NULL DEFAULT '0',
         `list_image` longtext COLLATE utf8_unicode_ci NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");




        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->points_delegate}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `id_user` int(250)  NOT NULL,
          `id_delegate` int(250)  NOT NULL,
          `points` bigint(20) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->user_purchases_region}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `id_user` int(250)  NOT NULL,
          `id_region` int(250)  NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->user_purchases_catg}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `id_user` int(250)  NOT NULL,
          `catg` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table,$this->points_delegate,$this->user_purchases_region,$this->user_purchases_catg));

    }





    public function index()
    {
        $this->checkPermit('purchases_man','purchases_man');
        $this->adminHeaderController($this->langControl('purchases_man'));



        $groups=array();
        $stmt_groups =$this->db->prepare("SELECT *FROM `usergroup` WHERE `name` LIKE '%مندوب%' OR `name` LIKE '%مندوبين%' ");
        $stmt_groups->execute();
        while ($row = $stmt_groups->fetch(PDO::FETCH_ASSOC))
        {
            $groups[]= $row;
        }



        if (isset($_POST['model']) && isset($_POST['category'])) {

            $categoryIds = $_POST['category'];


            $id = explode('_', end($categoryIds));
            $id = $id[1];
            $model = $_POST['model'];

            $name_category = 'category_' . $model;
            $breadcumbsx = $this->BreadcumbsPublic($name_category, $id);
            $category = $this->langControl($model);
            foreach ($breadcumbsx as $key => $cat) {
                $category .= ' / ' . $key;
            }

            $id_category= $this->BreadcumbsPublic_id_category($name_category,$id);;
             $ids=implode(',',$id_category);
        } else if (isset($_POST['model']))
        {
            $id = null;
            $model = $_POST['model'];
            $category = $this->langControl($model);

        }else
        {
            $id=null;
            $model=null;
            $category=null;

        }


        if ($model == null)
        {
            $categ=array();
            $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
            $stmt_cat->execute(array($this->userid));
            while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
            {
                $categ[]=$row['catg'];
            }
        }else
        {
            $categ=array();
            $categ[]=$model;
            $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? AND `catg` <> ?");
            $stmt_cat->execute(array($this->userid,$model));
            while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
            {
                $categ[]=$row['catg'];
            }
        }



        require ($this->render($this->folder,'html','index','php'));
        $this->adminFooterController();

    }



    public function processing($model,$id=null)
    {


        $this->checkPermit('report_search_by_category', 'purchases_man');
        if ($model !=null && ($id != null || $id != 0))

        {

            $name_category='category_'.$model;
            $breadcumbsx = $this->BreadcumbsPublic($name_category,$id);
            $category= $this->langControl($model) ;
            foreach ($breadcumbsx as  $key => $cat)
            {
                $category.= ' / ' . $key;
            }

            $id_category= $this->BreadcumbsPublic_id_category($name_category,$id);;
            $ids=implode(',',$id_category);

        }


        $table = $this->table;
        $primaryKey = 'id';


        $columns = array(


            array( 'db' => 'id', 'dt' => 0 ,
                'formatter' => function( $d, $row ) {
                    return "<input type='checkbox' checked  class='childcheckbox{$row[17]}'  name='item[]' value='{$d}'>";
                }
            ),
            array( 'db' => 'category', 'dt' => 1 ),
            array( 'db' => 'item', 'dt' => 2 ),
            array( 'db' => 'region', 'dt' => 3,

                'formatter' => function( $d, $row ) {
                    return  $this->region_all($d);
                }

            ),
            array( 'db' => 'code', 'dt' => 4 ),
            array( 'db' => 'color', 'dt' => 5 ),
            array( 'db' => 'price', 'dt' =>6 ),

            array( 'db' => 'quantity', 'dt' => 7 ),
            array( 'db' => 'sale_quantity', 'dt' =>8 ),

            array( 'db' => 'quantity', 'dt' => 9,
                'formatter' => function( $d, $row ) {
                    return (int)$d - (int)$row[8];
                }

            ),



            array( 'db' => 'note', 'dt' =>10 ),

            array( 'db' => 'full_date', 'dt' =>  11,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);
                }

            ),
            array( 'db' => 'image', 'dt' => 12,
                'formatter' => function( $d, $row ) {
                    if (!empty($d))
                    {
                        return "<img style='width: 30px' src='{$this->save_file}{$d}'>";

                    }else
                    {
                        return "<img style='width: 30px' src=".$this->static_file_control."/image/admin/default.png >";

                    }
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 13,
                'formatter' => function($id, $row ) {
                    return "
                   <div style='text-align: center;font-size: 23px;'>
                    <a href=".url.'/'.$this->folder."/edit/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),


            array(
                'db'        => 'id',
                'dt'        =>14,
                'formatter' => function($id, $row ) {
                    return "
                <div style='text-align: center'>
                    <button type='button'  class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[2]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                }
            ),
            array( 'db' => 'id_user', 'dt' => 15,
                'formatter' => function( $d, $row ) {
                    return  $this->delivery_user_name($d);
                }
            ),

            array(  'db' => 'id', 'dt'=>16),
            array(  'db' => 'model', 'dt'=>17),



        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        if ($id==null || $id==0 )
        {

            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`model` = '{$model}' AND  `purchases_man`=1 AND   (`delegate_man`=1 OR `purchases`=0) ")
            );

        }

        else
        {

            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`model` = '{$model}' AND  (`category` LIKE '%{$category}%') AND  `purchases_man`=1 AND   (`delegate_man`=1 OR `purchases`=0) ")
            );

        }

    }



    function delegate_man($id)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        if ($this->handleLogin())
        {

            $stmt_groups =$this->db->prepare("SELECT *FROM `user` WHERE `idGroup` = ? ");
            $stmt_groups->execute(array($id));
            $html='';$c=0;
            while ($row = $stmt_groups->fetch(PDO::FETCH_ASSOC))
            {
                if ($c==0)
                {
                    $html.='<option value="'.$row['id'].'"  selected  >'.$row['username'].'</option>';

                }else
                {
                    $html.='<option value="'.$row['id'].'" >'.$row['username'].'</option>';

                }
                $c++;
            }

            echo $html;
        }


    }







    public function add($id=null,$model=null)
    {


        $this->checkPermit('add_shortfalls','purchases_man');
        $this->adminHeaderController($this->langControl('add_shortfalls'),$id);

        $category='category_'.$model;




        $region=array();
        $stmt=$this->db->prepare("SELECT *FROM `region` WHERE `active`=1 ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $region[]=$row;
        }


        $class=new $model;

        $stmt=$this->db->prepare("SELECT *FROM {$model} WHERE  `id` = ? ");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);


        $breadcumbsx = $this->BreadcumbsPublic($category,$result['id_cat']);

        $cat_link= $this->langControl($model) ;
        foreach ($breadcumbsx as  $key => $cat)
        {
            $cat_link.= ' / ' . $key;
        }

        $id_category= $this->BreadcumbsPublic_id_category($category,$result['id_cat']);;

        $stmtCat=$this->db->prepare("SELECT *FROM {$category} WHERE  `id` = ? ");
        $stmtCat->execute(array($result['id_cat']));
        $resultCat=$stmtCat->fetch(PDO::FETCH_ASSOC);


        $g_c=$class->getImageAndColor($result['id'],100);
        $g_c_content=array();

        while ($row = $g_c->fetch(PDO::FETCH_ASSOC)) {

            if ($model=='accessories')
            {
                $stmt_price = $class->getPrice($row['code'], 1);
            }else{
                $stmt_price = $class->getPrice($row['id'], 1);
            }

            $row['code'] = $stmt_price['code'] ;
            $row['price'] = $stmt_price['price'];
            $row['price_dollars'] = $stmt_price['price_dollars'];
            $row['quantity'] = $stmt_price['quantity'];
            $row['image'] = $row['img'];
            $g_c_content[$row['id']] = $row;
        }

        if (isset($_POST['submit']))
        {
            try
            {
                $form =new  Form();


                $form  ->post('selected')
                    ->val('is_array')
                    ->val('strip_tags');

                $form  ->post('region')
                    ->val('is_empty','منطقة التسوق مطلوب')
                    ->val('strip_tags');

                $form  ->post('price')
                    ->val('strip_tags');

                $form  ->post('quantity')
                    ->val('strip_tags');

                $form  ->post('note')
                    ->val('strip_tags');


                $form ->submit();
                $data =$form -> fetch();
                $date=strtotime(date('Y-m-d',time()));
                $full_date=time();

                $selected = json_decode($data['selected'], true);


                $fullData=array();

                foreach ($selected as $sld)
                {

                    $fullData[$sld]['model']=$model;
                    $fullData[$sld]['category']=$cat_link;
                    $fullData[$sld]['id_category']=implode(',',$id_category);
                    $fullData[$sld]['item']=$result['title'];
                    $fullData[$sld]['image']=$g_c_content[$sld]['image'];
                    $fullData[$sld]['color']=$g_c_content[$sld]['color'];
                    $fullData[$sld]['code']=$g_c_content[$sld]['code'];
                    $fullData[$sld]['price_dollars']=$g_c_content[$sld]['price_dollars'];
                    $fullData[$sld]['old_quantity']=$g_c_content[$sld]['quantity'];
                    $fullData[$sld]['quantity']=$data['quantity'];
                    $fullData[$sld]['price']=$data['price'];
                    $fullData[$sld]['note']=$data['note'];
                    $fullData[$sld]['id_user']=$this->userid;
                    $fullData[$sld]['id_cat']= $resultCat['id'];
                    $fullData[$sld]['id_item']=$result['id'];
                    $fullData[$sld]['date']=$date;
                    $fullData[$sld]['full_date']=$full_date;

                    $fullData[$sld]['region']=$data['region'];

                    $fullData[$sld]['purchases_man']=1;
                    $fullData[$sld]['sales_man']=1;
                }


                foreach ($selected as $sld)
                {


                    $this->db->insert($this->table,$fullData[$sld]);

                }

                $sendProd=true;


            }catch (Exception $e)
            {
                $data =$form -> fetch();
                $this->error_form= json_decode($e -> getMessage(),true);
            }
            $this->lightRedirect(url.'/'.$this->folder,0);
        }




        require ($this->render($this->folder,'html','add','php'));
        $this->adminFooterController();



    }


    function by_code()
    {

        $this->checkPermit('add_purchases_by_code', 'purchases_man');
        $this->adminHeaderController($this->langControl('check_code'));


        $categ=array();
        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
        $stmt_cat->execute(array($this->userid));

        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
        {
            $cat[$row['catg']]=$this->langControl($row['catg']);
        }




        require($this->render($this->folder, 'html', 'code', 'php'));

        $this->adminFooterController();


    }


    function get()
    {
        if ($this->handleLogin()) {
            $this->checkPermit('add_purchases_by_code', 'purchases_man');

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



                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1  AND `status` =0    AND `table`='mobile' ");
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

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];



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

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];



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

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];



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

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];



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

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];


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

                $color = strip_tags(trim($_POST['color']));

                $stmtCode_accessories = $this->db->prepare("SELECT *FROM `excel_accessories` WHERE `code`=? AND `color`= ?");
                $stmtCode_accessories->execute(array($code,$color));
                if ($stmtCode_accessories->rowCount() > 0) {
                    $result = $stmtCode_accessories->fetch(PDO::FETCH_ASSOC);

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];



                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `name_color` =?  AND `buy` = 1 AND `status` =0  AND `table`='accessories' ");
                    $stmt_order->execute(array($result['code'],$color));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order'] = $only_order['num'];




                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`color`  FROM `color_accessories` WHERE `code` =? AND `color`= ? ");
                    $stmt_img->execute(array($result['code'],$color));
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




                    $stmt_color = $this->db->prepare("SELECT  * FROM `product_color`  WHERE `color` =?   LIMIT 1");
                    $stmt_color->execute(array($color));
                    $colorx = $stmt_color->fetch(PDO::FETCH_ASSOC);
                    $device[0]['color'] = $colorx['code_color'];
                    $device[0]['name_color'] = $colorx['color'];
                    $device[0]['img'] = $this->save_file . $colorx['img'];



                    $stmt_name = $this->db->prepare("SELECT  `id`,`title`  FROM `product_savers` WHERE `id` =?  AND `code` =?");
                    $stmt_name->execute(array($colorx['id_product'],$result['code']));
                    $name_device = $stmt_name->fetch(PDO::FETCH_ASSOC);
                    $device[0]['name'] = $name_device['title'];
                    $device[0]['id'] = $name_device['id'];

                    $device[0]['category'] = $this->langControl('savers') ;

                }

            }


            require($this->render($this->folder, 'html', 'data', 'php'));


        }
    }







    function delete_item($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->table, "`id`={$id}");
        }
    }

    function convert_to_employ_delegate_man()
    {
        if ($this->handleLogin()) {

            if (isset($_REQUEST['item'])) {
                $myArray = $_REQUEST['item'];



                foreach ($myArray as $ids)
                {
                    $stmt_rig=$this->db->prepare("SELECT `region` FROM `{$this->table}` WHERE `id` = ?");
                    $stmt_rig->execute(array($ids));
                    $result_idr=$stmt_rig->fetch(PDO::FETCH_ASSOC);

                    $stmt_user=$this->db->prepare("SELECT `id_user` FROM `user_purchases_region` WHERE `id_region` = ? LIMIT 1");
                    $stmt_user->execute(array($result_idr['region']));
                    if ($stmt_user->rowCount()>0)

                      {
                      $result_user=$stmt_user->fetch(PDO::FETCH_ASSOC);
                    $stmt = $this->db->prepare("UPDATE {$this->table}  SET  `purchases_man`=2,`delegate_man`=1,`id_user_p`=?,`id_user_d`=? WHERE `id`  = ? AND `model` <> ''  AND `quantity` <> ''  AND `quantity` <> 0  AND (`item` <> '' OR `image` <> '') ");
                    $stmt->execute(array($this->userid,$result_user['id_user'],$ids));
                  }
                }

                if ($stmt->rowCount() > 0) {
                    echo json_encode(array('done' => $myArray, JSON_FORCE_OBJECT));
                }else
                {
                    echo json_encode(array('stop_convert' =>  array('empty' =>'قيمة فارغ'), JSON_FORCE_OBJECT));
                }
            }
            else {
                echo json_encode(array('empty' => array('empty' => 'قيمة فارغ'), JSON_FORCE_OBJECT));

            }

        }
    }

    function checked_purchases_all()
    {
        if ($this->handleLogin()) {

            if (isset($_REQUEST['item'])) {
                $myArray = $_REQUEST['item'];

                $ids = implode(',', $myArray);
                $stmt = $this->db->prepare("UPDATE {$this->table}  SET  `checked_purchases`=1 WHERE `id` IN ({$ids}) AND `checked_purchases`= 0 AND  `id_user_p`=? ");
                $stmt->execute(array($this->userid));
                if ($stmt->rowCount() > 0) {
                    echo json_encode(array('done' => $myArray, JSON_FORCE_OBJECT));
                }else
                {
                    echo json_encode(array('error_ch' =>  array('empty' =>'قيمة فارغ'), JSON_FORCE_OBJECT));
                }
            }
            else {
                echo json_encode(array('empty' => array('empty' => 'قيمة فارغ'), JSON_FORCE_OBJECT));

            }

        }
    }



    function note_checked_purchases_all()
    {
        if ($this->handleLogin()) {

            if (isset($_REQUEST['item'])) {
                $myArray = $_REQUEST['item'];

                $ids = implode(',', $myArray);
                $stmt = $this->db->prepare("UPDATE {$this->table}  SET  `checked_purchases`=0 WHERE `id` IN ({$ids}) AND `checked_purchases`= 1 AND  `id_user_p`=? ");
                $stmt->execute(array($this->userid));
                if ($stmt->rowCount() > 0) {
                    echo json_encode(array('done' => $myArray, JSON_FORCE_OBJECT));
                }else
                {
                    echo json_encode(array('error_ch' =>  array('empty' =>'قيمة فارغ'), JSON_FORCE_OBJECT));
                }
            }
            else {
                echo json_encode(array('empty' => array('empty' => 'قيمة فارغ'), JSON_FORCE_OBJECT));

            }

        }
    }






    function add_manual()
    {

        $this->checkPermit('add_shortfalls','purchases_man');
        $this->adminHeaderController($this->langControl('add_shortfalls'));


        $region=array();
        $stmt=$this->db->prepare("SELECT *FROM `region` WHERE `active`=1 ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $region[]=$row;
        }

        $categ=array();
        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
        $stmt_cat->execute(array($this->userid));

        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
        {
            $categ[]=$row['catg'];
        }




        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();

                $form->post('model')
                    ->val('is_empty','القسم الرئيسي مطلوب')
                    ->val('strip_tags');

                $form->post('region')
                    ->val('strip_tags');

                $form->post('category')
                    ->val('is_array')
                    ->val('strip_tags');


                $form->post('item')
                    ->val('strip_tags');

                $form->post('color')
                    ->val('strip_tags');


                $form->post('code')
                    ->val('strip_tags');


                $form->post('price')
                    ->val('strip_tags');


                $form->post('quantity')
                    ->val('strip_tags');


                $form->post('note')
                    ->val('strip_tags');



                $form->submit();
                $data = $form->fetch();
                $data['date']=strtotime(date('Y-m-d',time()));
                $data['full_date']=time();
                $data['purchases_man']=1;
                $data['sales_man']=1;
                $data['image']=1;



                if (empty($data['item']) && $_FILES['image']['error']==4 )
                {
                    $this->error_form=array('image'=>'يجب اضافة اسم المنتج او صورة لة');
                }


                if (empty($this->error_form)) {



                    $last_id_cat=explode('_',end($categoryIds));
                    $name_category='category_'.$data['model'];
                    $breadcumbsx = $this->BreadcumbsPublic($name_category,$last_id_cat[1]);
                    $category= $this->langControl($data['model']) ;
                    foreach ($breadcumbsx as  $key => $cat)
                    {
                        $category.= ' / ' . $key;
                    }

                    $id_category= $this->BreadcumbsPublic_id_category($name_category,$last_id_cat[1]);;
                     $id_category=implode(',',$id_category);


                     if ($_FILES['image']['error']==0)
                     {
                         $data['image'] = $this->save_file($_FILES['image']);
                     }

                       $data['category']=$category;
                       $data['id_category']=$id_category;
                       $data['id_user_p']=$this->userid;

                    $stmt=$this->db->insert($this->table,$data);

                  $this->lightRedirect(url.'/'.$this->folder,0);
                }

            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form= json_decode($e -> getMessage(),true);
            }

        }



        require ($this->render($this->folder,'html','add_manual','php'));
        $this->adminFooterController();


    }


    function getMainCatDB($model)
    {
        if ($this->handleLogin())
        {

            if ($model != 'savers')
            {
                $category='category_'.$model;
                $stmt=$this->db->prepare("SELECT *FROM {$category} WHERE  `relid` = 0 ");
                $stmt->execute();

                if ($stmt->rowCount() > 0)
                {

                    $html="<select  name='category[]'  id='sub_cags_p'  class='custom-select col-md-3 mb-3 list_menu_categ' onchange='sub_catgs2(this)' >";
                    $html.="<option value='' disabled  selected > اختر قسم  </option>"  ;

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


                            $html.="<option value='{$model}_{$row['id']}'   >{$row['title']}</option>"  ;

                    }

                    $html.='</select>';

                    echo $html ;
                }


            }
        }

    }




    function sub_catgs($data)
    {
        if ($this->handleLogin())
        {

            $d=explode('_',$data);
            
            $model=$d[0];
            $id=$d[1];
            if ($model != 'savers')
            {
                $category = 'category_' . $model;
                $stmt = $this->db->prepare("SELECT *FROM {$category} WHERE  `relid` = ? ");
                $stmt->execute(array($id));


                if ($stmt->rowCount() > 0) {

                    $html = "<select name='category[]'  id='{$data}' class='custom-select col-md-3 mb-3 list_menu_categ' onchange='sub_catgs(this)' >";
                    $html.="<option value='' disabled  selected > اختر قسم  </option>"  ;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                            $html .= "<option value='{$model}_{$row['id']}'   >{$row['title']}</option>";

                        $c++;
                    }

                    $html .= '</select> ';

                    echo $html;

                }
            }
        }

    }


    function sub_catgs2($data)
    {
        if ($this->handleLogin())
        {

            $d=explode('_',$data);

            $model=$d[0];
            $id=$d[1];
            if ($model != 'savers')
            {
                $category = 'category_' . $model;
                $stmt = $this->db->prepare("SELECT *FROM {$category} WHERE  `relid` = ? ");
                $stmt->execute(array($id));


                if ($stmt->rowCount() > 0) {

                    $html = "<select name='category[]'  id='{$data}'  class='custom-select col-md-3 mb-3 list_menu_categ' onchange='sub_catgs2(this)' > ";
                    $html.="<option value='' disabled  selected > اختر قسم  </option>"  ;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                            $html .= "<option value='{$model}_{$row['id']}'   >{$row['title']}</option>";

                    }

                    $html .= '</select>';

                    echo $html;

                }
            }
        }

    }




    function edit($id)
    {

        $this->checkPermit('edit_shortfalls','purchases_man');
        $this->adminHeaderController($this->langControl('edit'));


        $region=array();
        $stmt=$this->db->prepare("SELECT *FROM `region` WHERE `active`=1 ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $region[]=$row;
        }


        $categ=array();
        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
        $stmt_cat->execute(array($this->userid));

        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
        {
            $categ[]=$row['catg'];
        }



        $stmt=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE `id`= ? ");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        $result['category']=str_replace(' / ','/',$result['category']);

        if (!empty($result['image']))
        {
            $result['img']=$this->save_file.$result['image'];

        }else
        {
            $result['img']=$this->static_file_control."/image/admin/default.png";
        }



         if (isset($_POST['submit'])) {

            try {

                $form = new  Form();
                $form->post('model')
                    ->val('strip_tags');


                    $form->post('path_catg_hide')
                    ->val('is_empty','يرجى اختيار الاقسام او الفئات')
                    ->val('strip_tags');

                $form->post('region')
                    ->val('is_empty','منطقة التسوق مطلوبة')
                    ->val('strip_tags');


                $form->post('category')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('item')
                    ->val('strip_tags');


                $form->post('color')
                    ->val('strip_tags');


                $form->post('code')
                    ->val('strip_tags');


                $form->post('price')
                    ->val('strip_tags');


                $form->post('quantity')
                    ->val('strip_tags');


                $form->post('note')
                    ->val('strip_tags');



                $form->submit();
                $data = $form->fetch();
                $data['edit']=$this->userid;
                $data['id_user_p']=$this->userid;
                $data['suggestion']=1;
                $data['purchases_man']=1;
                $data['sales_man']=1;

               if ($_FILES['image']['error']==0)
               {
                   if (empty($this->check_file($_FILES['image'], 'صور مطلوبة', array('jpg', 'jpeg', 'png')))) {
                       $image = $this->save_file($_FILES['image']);
                       $data['image']=$image;
                   }

               }
                if ($this->permit('save_edit',$this->folder)) {
                    if (empty($this->error_form)) {


                        if (!empty($data['path_catg_hide'])) {

                            if (empty($data['model'])) {
                                $data['model'] = $result['model'];
                            }

                            $categoryIds = json_decode($data['category'], true);

                            if (empty($categoryIds)) {
                                $data['category'] = $result['category'];
                                $data['id_category'] = $result['id_category'];
                            } else {

                                $last_id_cat = explode('_', end($categoryIds));
                                $name_category = 'category_' . $data['model'];
                                $breadcumbsx = $this->BreadcumbsPublic($name_category, $last_id_cat[1]);
                                $category = $this->langControl($data['model']);

                                foreach ($breadcumbsx as $key => $cat) {
                                    $category .= ' / ' . $key;
                                }

                                $data['category'] = $category;

                                $id_category = $this->BreadcumbsPublic_id_category($name_category, $last_id_cat[1]);;
                                $data['id_category'] = implode(',', $id_category);
                            }


                            $this->db->update($this->table, array_diff_key($data, ['path_catg_hide' => "delete"]), "`id`={$id}");
                            $this->lightRedirect(url . '/' . $this->folder, 0);
                        } else {

                            $this->error_form = array('path_catg' => 'يرجى اختيار الاقسام او الفئات');
                        }
                    }
                }
            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form= json_decode($e -> getMessage(),true);
            }

        }


        require ($this->render($this->folder,'html','edit','php'));
        $this->adminFooterController();


    }



    function save_file($image)
    {


        $save_file = $this->root_file;
        @mkdir($save_file);
        $path = $save_file;

        $file = array();

            if ($image['error'] == 0) {
                $fileName_agency_file = $image['name'];
                $file_agency_file = $image['tmp_name'];
                $temp_agency_file = explode(".", $fileName_agency_file);
                $extension_agency_file = strtolower(end($temp_agency_file));
                $fileName_agency_file = time() . md5(mt_rand(1, time())) . '_.' . $extension_agency_file;
                move_uploaded_file($file_agency_file, $path . '/' . $fileName_agency_file);
                $setting=new Setting();
                $file=new Files();
                $file->smart_resize_image($this->root_file . $fileName_agency_file, $this->root_file .$fileName_agency_file, null, $setting->get('width', 1800), $setting->get('height', 1600), $setting->get('proportional', 1), 'file', false, false, $setting->get('quality', 75), $setting->get('grayscale', 0));

                $file= $fileName_agency_file;
            }

        return $file;
    }



    function check_file($image, $arg, $ex = array())
    {


            if ($image['error'] == 0) {
                $fileName_agency_file = $image['name'];
                $file_agency_file = $image['tmp_name'];
                $temp_agency_file = explode(".", $fileName_agency_file);
                $extension_agency_file = strtolower(end($temp_agency_file));
                if ($image['size'] < 5194304) {
                    if (in_array($extension_agency_file, $ex)) {
                        if (is_uploaded_file($file_agency_file)) {
                        } else {
                            return $error['document'] = " فشل تحميل ملف {$arg} ";
                        }
                    } else {
                        return $error['document'] = "صيغة الملف غير مسموح بيها";

                    }
                } else {
                    return $error['document'] = "   حجم الملف اكبر من 5 ميكابت ";
                }
            } else {
                return $error['document'] = "مطلوب ";
            }

    }













    public function report()
    {
        $this->checkPermit('report','purchases_man');
        $this->adminHeaderController($this->langControl('report'));

        if (isset($_GET['date'])) {
            $date = strtotime($_GET['date']);
        }else
        {
            $date=null;
        }

        require ($this->render($this->folder,'html','report','php'));
        $this->adminFooterController();

    }


    public function processing_report($date=null)
    {


        $categ=array();
        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
        $stmt_cat->execute(array($this->userid));
        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
        {
            $categ[]="'".$row['catg']."'";
        }
        $model=implode(',',$categ);





        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'category', 'dt' => 0 ),
            array( 'db' => 'item', 'dt' => 1),
            array( 'db' => 'code', 'dt' => 2 ),
            array( 'db' => 'color', 'dt' => 3 ),
            array( 'db' => 'price', 'dt' => 4 ),
            array( 'db' => 'quantity', 'dt' => 5 ),
            array( 'db' => 'sale_quantity', 'dt' => 6 ),

            array( 'db' => 'quantity', 'dt' => 7,
                'formatter' => function( $d, $row ) {
                    return (int)$d - (int)$row[6];
                }

            ),


            array( 'db' => 'note', 'dt' => 8 ),

            array( 'db' => 'full_date', 'dt' =>  9,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);
                }

            ),
            array( 'db' => 'image', 'dt' => 10,
                'formatter' => function( $d, $row ) {
                    if (!empty($d))
                    {
                        return "<img style='width: 30px' src='{$this->save_file}{$d}'>";

                    }else
                    {
                        return "<img style='width: 30px' src=".$this->static_file_control."/image/admin/default.png >";

                    }
                }
            ),

         array( 'db' => 'id_user', 'dt' => 11,
                'formatter' => function( $d, $row ) {
                    return  $this->delivery_user_name($d);
                }
            ),



            array(  'db' => 'id', 'dt'=>12)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        if ($date == null)
        {

            echo json_encode(
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`model` IN ({$model}) AND `purchases_man`=2  ")
            );

        }else
        {
            echo json_encode(
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`model` IN ({$model}) AND `purchases_man`=2  AND `date` = {$date} ")
            );
        }

    }


    function delivery_user_name($id)
    {

        if ($this->handleLogin())
        {
            $stmtCods = $this->db->prepare("SELECT `username`FROM `user` WHERE id = ?    LIMIT 1");
            $stmtCods->execute(array($id));
            $result=$stmtCods->fetch(PDO::FETCH_ASSOC);
            return $result['username'];
        }

    }






    function  excel()
    {
        $this->checkPermit('excel','purchases_man');
        $this->adminHeaderController($this->langControl('add'));


        $categ=array();
        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
        $stmt_cat->execute(array($this->userid));

        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
        {
            $categ[]=$row['catg'];
        }


        $region=array();
        $stmt=$this->db->prepare("SELECT *FROM `region` WHERE `active`=1 ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $region[]=$row;
        }



        if(isset($_POST["submit"])) {

            try {
                $form = new  Form();

                $form->post('model')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->post('region')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->post('excel')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();

                  $name_file=json_decode($data['excel'],true);

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
                    $date=strtotime(date('Y-m-d',time()));
                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                            '',
                            TRUE,
                            TRUE);

                        if (count($rowData[0]) >= 7 )
                        {

                            $tableCat='category_'.$data['model'];
                            $stmt_cat = $this->db->prepare("SELECT `id` FROM `{$tableCat}`  WHERE `code_cat`= ? LIMIT 1 ");
                            $stmt_cat->execute(array(trim($rowData[0][0])));
                             if ($stmt_cat->rowCount() >0 )
                             {
                                 $id_cat=$stmt_cat->fetch(PDO::FETCH_ASSOC)['id'];
                                 $breadcumbsx = $this->BreadcumbsPublic($tableCat,$id_cat);
                                 $category= $this->langControl($data['model']) ;
                                 foreach ($breadcumbsx as  $key => $cat)
                                 {
                                     $category.= ' / ' . $key;
                                 }

                                 $id_category= $this->BreadcumbsPublic_id_category($tableCat,$id_cat);
                                 $id_category=implode(',',$id_category);
                             }else
                             {
                                 $category= $this->langControl($data['model']) ;
                                 $id_category='';
                             }

                             $image=null;
                            $result_user=0;

                            if ($data['model']=='accessories') {

                                $stmt_img = $this->db->prepare("SELECT `img` FROM `color_accessories` WHERE `code` = ? AND `color` LIMIT 1");
                                $stmt_img->execute(array(trim($rowData[0][2], $rowData[0][3])));
                                if ($stmt_img->rowCount() > 0) {
                                    $image = $stmt_img->fetch(PDO::FETCH_ASSOC)['img'];
                                }


                            }else if ($data['model']=='savers')
                            {


                                $stmt_id_c=$this->db->prepare("SELECT `id` FROM `product_savers` WHERE `code` = ? LIMIT 1");
                                $stmt_id_c->execute(array(trim($rowData[0][2])));
                                if ($stmt_id_c->rowCount() > 0)
                                {

                                    $idc=$stmt_id_c->fetch(PDO::FETCH_ASSOC)['id'];

                                    $stmt_img=$this->db->prepare("SELECT `img` FROM  `product_color`  WHERE  `id` = ? AND `color`  LIMIT 1");
                                    $stmt_img->execute(array($idc,$rowData[0][3]));
                                    if ($stmt_img->rowCount() > 0)
                                    {
                                        $image=$stmt_img->fetch(PDO::FETCH_ASSOC)['img'];
                                    }
                                }

                            }else{


                                if ($data['model']=='mobile')
                                {

                                   $code_table='code';
                                   $color_table='color';
                                }else
                                {
                                    $code_table='code_'.$data['model'];
                                    $color_table='color_'.$data['model'];
                                }


                                $stmt_id_c=$this->db->prepare("SELECT `id_color` FROM {$code_table} WHERE `code` = ? LIMIT 1");
                                $stmt_id_c->execute(array(trim($rowData[0][2])));
                                if ($stmt_id_c->rowCount() > 0)
                                {

                                    $idc=$stmt_id_c->fetch(PDO::FETCH_ASSOC)['id_color'];

                                    $stmt_img=$this->db->prepare("SELECT `img` FROM {$color_table} WHERE `id` = ? LIMIT 1");
                                    $stmt_img->execute(array($idc));
                                    if ($stmt_img->rowCount() > 0)
                                    {
                                        $image=$stmt_img->fetch(PDO::FETCH_ASSOC)['img'];
                                    }
                                }

                            }

                            if (!empty($image))
                            {
                                $delegate_man=1;
                                $purchases_man=2;


                                $stmt_user=$this->db->prepare("SELECT `id_user` FROM `user_purchases_region` WHERE `id_region` = ? LIMIT 1");
                                $stmt_user->execute(array($data['region']));
                                if ($stmt_user->rowCount()>0) {
                                    $result_user = $stmt_user->fetch(PDO::FETCH_ASSOC)['id_user'];
                                }

                            }else
                            {
                                $purchases_man=1;
                                $delegate_man=0;
                            }

                            $stmt = $this->db->prepare("INSERT INTO {$this->table} (`model`,`code_catg`,`item`,`code`,`color`,`price`,`quantity`,`note`,`id_user`,`date`,`full_date`,`purchases_man`,`sales_man`,`delegate_man`,`category`,`id_category`,`image`,`region`,`id_user_d`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                            $stmt->execute(array($data['model'], trim($rowData[0][0]), $rowData[0][1], $rowData[0][2], $rowData[0][3], $rowData[0][4], $rowData[0][5], $rowData[0][6],$this->userid, $date,time(),$purchases_man,1,$delegate_man,$category,$id_category,$image,$data['region'],$result_user));
                           }else{
                            $this->error_form=json_encode(array('excel'=>'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
                            break;
                        }
                    }
                     @unlink($inputFileName);
                }else
                {

                    $this->error_form=json_encode(array('excel'=>'يرجى اعادة رفع الملف'));
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

        require ($this->render($this->folder,'html','add_excel','php'));
        $this->adminFooterController();
    }





    public function report_purchases()
    {
        $this->checkPermit('report_purchases_all','purchases_man');
        $this->adminHeaderController($this->langControl('report_purchases_all'));

        if (isset($_GET['date'])) {
            $date = strtotime($_GET['date']);
        }else
        {
            $date=null;
        }



        $categ=array();
        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
        $stmt_cat->execute(array($this->userid));
        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
        {
            $categ[]=$row['catg'];
        }



        require ($this->render($this->folder,'html','report_purchases','php'));
        $this->adminFooterController();

    }


    public function processing_report_purchases($model,$date=null)
    {

//
//        $categ=array();
//        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
//        $stmt_cat->execute(array($this->userid));
//        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
//        {
//            $categ[]="'".$row['catg']."'";
//        }
//        $model=implode(',',$categ);



        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(


            array( 'db' => 'id', 'dt' => 0 ,
                'formatter' => function( $d, $row ) {
                    return "<input type='checkbox'   class='childcheckbox$row[16]'  name='item[]' value='{$d}'>";
                }
            ),
            array(
                'db'        => 'id',
                'dt'        => 1,
                'formatter' => function($id, $row ) {
                    return "
                <div style='text-align: center'>
                  <input id='checked_{$id}' {$this->ch_checked_purchases($id)} class='toggle-demo' onchange='checked_purchases(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                }
            ),


            array( 'db' => 'category', 'dt' => 2 ),
            array( 'db' => 'item', 'dt' => 3 ),
            array( 'db' => 'region', 'dt' => 4,

                'formatter' => function( $d, $row ) {
                    return  $this->region_all($d);
                }

            ),
            array( 'db' => 'code', 'dt' => 5),
            array( 'db' => 'color', 'dt' => 6 ),
            array( 'db' => 'price', 'dt' => 7 ),
            array( 'db' => 'quantity', 'dt' => 8,
                'formatter' => function( $d, $row ) {
                    return (int)$d;
                }
            ),

            array( 'db' => 'sale_quantity', 'dt' => 9,
                'formatter' => function( $d, $row ) {
                    return (int)$d;
                }

            ),
            array( 'db' => 'quantity', 'dt' => 10,
                'formatter' => function( $d, $row ) {
                    return (int)$d - (int)$row[9];
                }
            ),


            array( 'db' => 'note', 'dt' => 11 ),

            array( 'db' => 'full_date', 'dt' =>  12,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);
                }

            ),
            array( 'db' => 'image', 'dt' => 13,
                'formatter' => function( $d, $row ) {
                    if (!empty($d))
                    {
                        return "<img style='width: 30px' src='{$this->save_file}{$d}'>";

                    }else
                    {
                        return "<img style='width: 30px' src=".$this->static_file_control."/image/admin/default.png >";

                    }
                }
            ),

            array( 'db' => 'id_user', 'dt' => 14,
                'formatter' => function( $d, $row ) {
                    return  $this->delivery_user_name($d);
                }
            ),

            array(  'db' => 'id', 'dt'=>15),
            array(  'db' => 'model', 'dt'=>16),



        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        if ($date == null)
        {

            echo json_encode(
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`model`  = '{$model}' AND `purchases_finish`=1")
            );

        }else
        {
            echo json_encode(

                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`model` = '{$model}' AND `purchases_finish`=1 AND  `date_purchases` = {$date} ")
            );

        }



    }




    public function report_search_by_category()
    {
        $this->checkPermit('report_search_by_category', 'purchases_man');
        $this->adminHeaderController($this->langControl('report_search_by_category'));

        $categ = array();
        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
        $stmt_cat->execute(array($this->userid));

        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
            $categ[] = $row['catg'];
        }

        if (isset($_POST['model']) && isset($_POST['category'])) {

            $categoryIds = $_POST['category'];


            $id = explode('_', end($categoryIds));
            $id = $id[1];
            $model = $_POST['model'];

            $name_category = 'category_' . $model;
            $breadcumbsx = $this->BreadcumbsPublic($name_category, $id);
            $category = $this->langControl($model);
            foreach ($breadcumbsx as $key => $cat) {
                $category .= ' / ' . $key;
            }


        } else if (isset($_POST['model']))
        {
            $id = null;
            $model = $_POST['model'];
             $category = $this->langControl($model);

        }else
        {
            $id=null;
            $model=null;
            $category=null;

        }

        require ($this->render($this->folder,'html','report_purchases_search_by_category','php'));
        $this->adminFooterController();

    }


    public function processing_report_report_search_by_category($model=null,$id=null)
    {

        $this->checkPermit('report_search_by_category', 'purchases_man');
        if ($model==null && $id==null)
        {
            $category='xxxxxxxxxx';
            $ids='xxxxxxxxx';
          }else if ($model !=null && $id != null)

           {

            $name_category='category_'.$model;
            $breadcumbsx = $this->BreadcumbsPublic($name_category,$id);
            $category= $this->langControl($model) ;
            foreach ($breadcumbsx as  $key => $cat)
            {
                $category.= ' / ' . $key;
            }

            $id_category= $this->BreadcumbsPublic_id_category($name_category,$id);;
            $ids=implode(',',$id_category);

        }

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(


            array( 'db' => 'id', 'dt' => 0 ,
                'formatter' => function( $d, $row ) {
                    return "<input type='checkbox' checked  class='childcheckbox'  name='item[]' value='{$d}'>";
                }
            ),
            array(
                'db'        => 'id',
                'dt'        => 1,
                'formatter' => function($id, $row ) {
                    return "
                <div style='text-align: center'>
                  <input id='checked_{$id}' {$this->ch_checked_purchases($id)} class='toggle-demo' onchange='checked_purchases(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                }
            ),


            array( 'db' => 'category', 'dt' => 2 ),
            array( 'db' => 'item', 'dt' => 3 ),
            array( 'db' => 'region', 'dt' => 4,

                'formatter' => function( $d, $row ) {
                    return  $this->region_all($d);
                }

            ),
            array( 'db' => 'code', 'dt' => 5),
            array( 'db' => 'color', 'dt' => 6 ),
            array( 'db' => 'price', 'dt' => 7 ),
            array( 'db' => 'quantity', 'dt' => 8,
                'formatter' => function( $d, $row ) {
                    return (int)$d;
                }
            ),

            array( 'db' => 'sale_quantity', 'dt' => 9,
                'formatter' => function( $d, $row ) {
                    return (int)$d;
                }

            ),
            array( 'db' => 'quantity', 'dt' => 10,
                'formatter' => function( $d, $row ) {
                    return (int)$d - (int)$row[9];
                }
            ),


            array( 'db' => 'note', 'dt' => 11 ),

            array( 'db' => 'full_date', 'dt' =>  12,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);
                }

            ),
            array( 'db' => 'image', 'dt' => 13,
                'formatter' => function( $d, $row ) {
                    if (!empty($d))
                    {
                        return "<img style='width: 30px' src='{$this->save_file}{$d}'>";

                    }else
                    {
                        return "<img style='width: 30px' src=".$this->static_file_control."/image/admin/default.png >";

                    }
                }
            ),

            array( 'db' => 'id_user', 'dt' => 14,
                'formatter' => function( $d, $row ) {
                    return  $this->delivery_user_name($d);
                }
            ),

            array(  'db' => 'id', 'dt'=>15),



        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        if ($model !=null && $id != null)
        {
            echo json_encode(
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`model` = '{$model}' AND  (`category` LIKE '%{$category}%') AND   `purchases_finish`=1   ")
            );
        }else{
            echo json_encode(
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`model` = '{$model}' AND   `purchases_finish`=1   ")
            );
        }



    }


    public function ch_checked_purchases($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `checked_purchases` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            return 'checked';
        }
        else
        {
            return '';
        }
    }

    public function checked_purchases($v_,$id_)
    {
        if ($this->handleLogin()) {
            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }
            $data = $this->db->update($this->table, array('checked_purchases' => $v), "`id`={$id}");
        }
    }


    function list_delegate_man()
    {



        $this->checkPermit('list_delegate_man','purchases_man');
        $this->adminHeaderController($this->langControl('list_delegate_man'));




        $stmt_groups =$this->db->prepare("SELECT *FROM `usergroup` WHERE `name` LIKE '%مندوب%' OR `name` LIKE '%مندوبين%'  ");
        $stmt_groups->execute();
        $groups_id=array();
        while ($rowId = $stmt_groups->fetch(PDO::FETCH_ASSOC))
        {
            $groups_id[]= $rowId['id'];
        }

        $delegate=array();
        $idG=implode( ',',$groups_id);
        $stmt =$this->db->prepare("SELECT *FROM  `user` WHERE  `idGroup` IN ({$idG}) ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

            $stmt1 = $this->db->prepare("SELECT  SUM(`points`) as sum FROM `{$this->points_delegate}`  WHERE  `id_delegate` = ? ");
            $stmt1->execute(array($row['id']));
            $row['sum']  = $stmt1->fetch(PDO::FETCH_ASSOC)['sum'];


            $stmt3 = $this->db->prepare("SELECT  `points` FROM `{$this->points_delegate}`  WHERE   `id_delegate`=? ORDER BY `id` DESC LIMIT 1");
            $stmt3->execute(array($row['id']));
            $row['points'] = $stmt3->fetch(PDO::FETCH_ASSOC)['points'] ;


            $delegate[]= $row;
        }




        require ($this->render($this->folder,'html','delegate','php'));
        $this->adminFooterController();


    }


    function add_point($id)
    {

        $this->checkPermit('add_point','purchases_man');
        $this->adminHeaderController($this->langControl('add_point'));

        $stmt =$this->db->prepare("SELECT *FROM  `user` WHERE  `id`  = ? ");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);

        $data['points']='';
        $data['date']=time();

        if (isset($_POST['submit']))
        {
            try{
                $form =new Form();
                $form  ->post('points')
                    ->val('is_empty','عدد النقاط مطلوب')
                    ->val('strip_tags');

                $form  ->post('date')
                    ->val('is_empty','التاريخ مطلوب')
                    ->val('strip_tags',TAG);

                $form ->submit();
                $data =$form -> fetch();

                $data['id_delegate']=$id;
                $data['id_user']=$this->userid;
                $data['date']=strtotime( $data['date']);

                $this->db->insert($this->points_delegate,$data);

                $this->lightRedirect(url.'/'.$this->folder.'/list_delegate_man',0);
            }

            catch (Exception $e)
            {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();
            }

        }





        require ($this->render($this->folder,'html','add_point','php'));
        $this->adminFooterController();


    }


    function view_purchases($id)
    {

        $this->checkPermit('view_purchases','purchases_man');
        $this->adminHeaderController($this->langControl('view_purchases'));


        if (isset($_GET['date'])) {
            $date = strtotime($_GET['date']);
        }else
        {
            $date=null;
        }

        $stmt =$this->db->prepare("SELECT *FROM  `user` WHERE  `id`  = ? ");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);



        require ($this->render($this->folder,'html','view_purchases','php'));
        $this->adminFooterController();


    }


    public function processing_view_purchases($id,$date=null)
    {



        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'category', 'dt' => 0 ),
            array( 'db' => 'item', 'dt' => 1 ),
            array( 'db' => 'code', 'dt' => 2 ),
            array( 'db' => 'color', 'dt' => 3 ),
            array( 'db' => 'price', 'dt' => 4 ),
            array( 'db' => 'quantity', 'dt' => 5,
                'formatter' => function( $d, $row ) {
                    return (int)$d;
                }
            ),

            array( 'db' => 'sale_quantity', 'dt' => 6,
                'formatter' => function( $d, $row ) {
                    return (int)$d;
                }

            ),
            array( 'db' => 'quantity', 'dt' => 7,
                'formatter' => function( $d, $row ) {
                    return (int)$d - (int)$row[6];
                }
            ),


            array( 'db' => 'note', 'dt' => 8 ),

            array( 'db' => 'full_date', 'dt' =>  9,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);
                }

            ),
            array( 'db' => 'image', 'dt' => 10,
                'formatter' => function( $d, $row ) {
                    if (!empty($d))
                    {
                        return "<img style='width: 30px' src='{$this->save_file}{$d}'>";

                    }else
                    {
                        return "<img style='width: 30px' src=".$this->static_file_control."/image/admin/default.png >";

                    }
                }
            ),

            array( 'db' => 'id_user', 'dt' => 11,
                'formatter' => function( $d, $row ) {
                    return  $this->delivery_user_name($d);
                }
            ),

            array(  'db' => 'id', 'dt'=>12),



        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        if ($date == null)
        {

            echo json_encode(
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns," `purchases_finish`=1 AND `id_user_d`={$id}")
            );

        }else
        {
            echo json_encode(

                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns," `purchases_finish`=1 AND  `date_purchases` = {$date} AND `id_user_d`={$id}")
            );

        }



    }








    public function list_suggestion()
    {
        $this->checkPermit('list_suggestion','purchases_man');
        $this->adminHeaderController($this->langControl('list_suggestion'));




        require ($this->render($this->folder,'html','sunggestion','php'));
        $this->adminFooterController();

    }



    public function processing_suggestion()
    {




        $table = $this->table;
        $primaryKey = 'id';


        $columns = array(


            array( 'db' => 'item', 'dt' => 0 ),


            array( 'db' => 'id_user_d', 'dt' => 1,
                'formatter' => function( $d, $row ) {
                    return $this->delivery_user_name($d);
                }

            ),



            array( 'db' => 'full_date', 'dt' =>  2,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);
                }
            ),

            array( 'db' => 'image', 'dt' => 3,
                'formatter' => function( $d, $row ) {
                    if (!empty($d))
                    {
                        return "<img style='width: 30px' src='{$this->save_file}{$d}'>";

                    }else
                    {
                        return "<img style='width: 30px' src=".$this->static_file_control."/image/admin/default.png >";

                    }
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 4,
                'formatter' => function($id, $row ) {
                    return "
                   <div style='text-align: center;font-size: 23px;'>
                    <a href=".url.'/'.$this->folder."/details/$id> <span>عرض التفاصيل</span> </a>
                    </div> ";
                }
            ),
            array(
                'db'        => 'id',
                'dt'        =>5,
                'formatter' => function($id, $row ) {
                    return "
                <div style='text-align: center'>
                    <button type='button'  class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[2]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                }
            ),
            array(  'db' => 'id', 'dt'=>6),



        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        echo json_encode(
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`id_user_d` <> 0 AND  `suggestion`=0 ")
        );

    }




    function details($id)
    {
        $this->checkPermit('details_suggestion','purchases_man');
        $this->adminHeaderController($this->langControl('details_suggestion'));



        $stmt=$this->db->prepare("SELECT *FROM {$this->table} WhERE `id`=?");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);

        $image=array();
        $image=explode(',',$result['list_image']);




        require ($this->render($this->folder,'html','details','php'));
        $this->adminFooterController();

    }




    public function  notification_seg()
    {
        $stmt = $this->db->prepare("SELECT  count(*)  FROM `{$this->table}`  WHERE   `id_user_d` <> 0 AND  `suggestion`=0");
        $stmt->execute();
        return $stmt->fetchColumn() ;

    }










    public function done_checked()
    {
        $this->checkPermit('done_checked','purchases_man');
        $this->adminHeaderController($this->langControl('done_checked'));

        if (isset($_GET['date'])) {
            $date = strtotime($_GET['date']);
        }else
        {
            $date=null;
        }



        $categ=array();
        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
        $stmt_cat->execute(array($this->userid));
        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
        {
            $categ[]=$row['catg'];
        }



        require ($this->render($this->folder,'html','done_checked','php'));
        $this->adminFooterController();

    }


    public function processing_report_done_checked($model,$date=null)
    {


//        $categ=array();
//        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
//        $stmt_cat->execute(array($this->userid));
//        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
//        {
//            $categ[]="'".$row['catg']."'";
//        }
//        $model=implode(',',$categ);
//


        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(


            array( 'db' => 'id', 'dt' => 0 ,
                'formatter' => function( $d, $row ) {
                    return "<input type='checkbox'    class='childcheckbox{$row[16]}'  name='item[]' value='{$d}'>";
                }
            ),
            array(
                'db'        => 'id',
                'dt'        => 1,
                'formatter' => function($id, $row ) {
                    return "
                <div style='text-align: center'>
                  <input id='checked_{$id}' {$this->ch_checked_purchases($id)} class='toggle-demo' onchange='checked_purchases(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                }
            ),


            array( 'db' => 'category', 'dt' => 2 ),
            array( 'db' => 'item', 'dt' => 3 ),
            array( 'db' => 'region', 'dt' => 4,

                'formatter' => function( $d, $row ) {
                    return  $this->region_all($d);
                }

            ),
            array( 'db' => 'code', 'dt' => 5 ),
            array( 'db' => 'color', 'dt' => 6 ),
            array( 'db' => 'price', 'dt' => 7 ),
            array( 'db' => 'quantity', 'dt' => 8,
                'formatter' => function( $d, $row ) {
                    return (int)$d;
                }
            ),

            array( 'db' => 'sale_quantity', 'dt' => 9,
                'formatter' => function( $d, $row ) {
                    return (int)$d;
                }

            ),
            array( 'db' => 'quantity', 'dt' => 10,
                'formatter' => function( $d, $row ) {
                    return (int)$d - (int)$row[9];
                }
            ),


            array( 'db' => 'note', 'dt' => 11 ),

            array( 'db' => 'full_date', 'dt' =>  12,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);
                }

            ),
            array( 'db' => 'image', 'dt' => 13,
                'formatter' => function( $d, $row ) {
                    if (!empty($d))
                    {
                        return "<img style='width: 30px' src='{$this->save_file}{$d}'>";

                    }else
                    {
                        return "<img style='width: 30px' src=".$this->static_file_control."/image/admin/default.png >";

                    }
                }
            ),

            array( 'db' => 'id_user', 'dt' => 14,
                'formatter' => function( $d, $row ) {
                    return  $this->delivery_user_name($d);
                }
            ),

            array(  'db' => 'id', 'dt'=>15),
            array(  'db' => 'model', 'dt'=>16),



        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        if ($date == null)
        {

            echo json_encode(
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`model` = '{$model}' AND `purchases_finish`=1 AND `checked_purchases`=1")
            );

        }else
        {
            echo json_encode(

                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`model` = '{$model}' AND `purchases_finish`=1 AND  `date_purchases` = {$date} AND `checked_purchases`=1")
            );

        }



    }






    public function note_checked()
    {
        $this->checkPermit('note_checked','purchases_man');
        $this->adminHeaderController($this->langControl('note_checked'));

        if (isset($_GET['date'])) {
            $date = strtotime($_GET['date']);
        }else
        {
            $date=null;
        }



        $categ=array();
        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
        $stmt_cat->execute(array($this->userid));
        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
        {
            $categ[]=$row['catg'];
        }




        require ($this->render($this->folder,'html','note_checked','php'));
        $this->adminFooterController();

    }


    public function processing_report_note_checked($model,$date=null)
    {

//
//        $categ=array();
//        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
//        $stmt_cat->execute(array($this->userid));
//        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
//        {
//            $categ[]="'".$row['catg']."'";
//        }
//        $model=implode(',',$categ);
//
//

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(


            array( 'db' => 'id', 'dt' => 0 ,
                'formatter' => function( $d, $row ) {
                    return "<input type='checkbox'    class='childcheckbox{$row[16]}'  name='item[]' value='{$d}'>";
                }
            ),
            array(
                'db'        => 'id',
                'dt'        => 1,
                'formatter' => function($id, $row ) {
                    return "
                <div style='text-align: center'>
                  <input id='checked_{$id}' {$this->ch_checked_purchases($id)} class='toggle-demo' onchange='checked_purchases(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                }
            ),


            array( 'db' => 'category', 'dt' => 2 ),
            array( 'db' => 'item', 'dt' => 3 ),
            array( 'db' => 'region', 'dt' => 4,

                'formatter' => function( $d, $row ) {
                    return  $this->region_all($d);
                }

            ),
            array( 'db' => 'code', 'dt' =>5),
            array( 'db' => 'color', 'dt' => 6 ),
            array( 'db' => 'price', 'dt' => 7 ),
            array( 'db' => 'quantity', 'dt' => 8,
                'formatter' => function( $d, $row ) {
                    return (int)$d;
                }
            ),

            array( 'db' => 'sale_quantity', 'dt' => 9,
                'formatter' => function( $d, $row ) {
                    return (int)$d;
                }

            ),
            array( 'db' => 'quantity', 'dt' => 10,
                'formatter' => function( $d, $row ) {
                    return (int)$d - (int)$row[9];
                }
            ),


            array( 'db' => 'note', 'dt' => 11 ),

            array( 'db' => 'full_date', 'dt' =>  12,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);
                }
            ),
            array( 'db' => 'image', 'dt' => 13,
                'formatter' => function( $d, $row ) {
                    if (!empty($d))
                    {
                        return "<img style='width: 30px' src='{$this->save_file}{$d}'>";

                    }else
                    {
                        return "<img style='width: 30px' src=".$this->static_file_control."/image/admin/default.png >";

                    }
                }
            ),

            array( 'db' => 'id_user', 'dt' => 14,
                'formatter' => function( $d, $row ) {
                    return  $this->delivery_user_name($d);
                }
            ),

            array(  'db' => 'id', 'dt'=>15),
            array(  'db' => 'model', 'dt'=>16),



        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        if ($date == null)
        {

            echo json_encode(
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`model` = '{$model}' AND `purchases_finish`=1 AND `checked_purchases`=0")
            );

        }else
        {
            echo json_encode(

                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`model` = '{$model}' AND `purchases_finish`=1 AND  `date_purchases` = {$date} AND `checked_purchases`=0")
            );

        }



    }




    public function add_by_category($id=null,$model=null)
    {
        $sendProd=false;

        $this->checkPermit('add_shortfalls','purchases_man');
        $this->adminHeaderController($this->langControl('add_shortfalls'),$id);

        $category='category_'.$model;

        $region=array();
        $stmt=$this->db->prepare("SELECT *FROM `region` WHERE `active`=1 ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $region[]=$row;
        }




        $class=new $model;

        $stmt=$this->db->prepare("SELECT *FROM {$model} WHERE  `id` = ? ");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);


        $breadcumbsx = $this->BreadcumbsPublic($category,$result['id_cat']);

        $cat_link= $this->langControl($model) ;
        foreach ($breadcumbsx as  $key => $cat)
        {
            $cat_link.= ' / ' . $key;
        }

        $id_category= $this->BreadcumbsPublic_id_category($category,$result['id_cat']);;

        if (isset($_POST['submit']))
        {
            try
            {
                $form =new  Form();



                $form  ->post('region')
                    ->val('is_empty','منطقة التسوق مطلوب')
                    ->val('strip_tags');


                $form  ->post('item')
                    ->val('is_empty','اسم المنتج   مطلوب')
                    ->val('strip_tags');




                $form->post('color')

                    ->val('strip_tags');


                $form->post('code')

                    ->val('strip_tags');


                $form->post('price')

                    ->val('strip_tags');


                $form->post('quantity')

                    ->val('strip_tags');


                $form->post('note')

                    ->val('strip_tags');



                $form->submit();
                $data = $form->fetch();
                $data['date']=strtotime(date('Y-m-d',time()));
                $data['full_date']=time();
                $data['model']=$model;


                if (empty($this->error_form)) {


                    $data['category'] = $cat_link;
                    $data['id_category'] =   implode(',',$id_category);;



                    $data['image'] = '';
                    if (empty($this->check_file($_FILES['image'], 'صور مطلوبة', array('jpg', 'jpeg', 'png')))) {
                        $data['image'] = $this->save_file($_FILES['image']);
                    }

                    $data['purchases_man'] = 1;
                    $data['sales_man'] = 1;
                    $data['id_user_p'] = $this->userid;


                    $stmt = $this->db->insert($this->table, $data);

                    $sendProd = true;
                }


            }catch (Exception $e)
            {
                $data =$form -> fetch();

            }

        }


        require ($this->render($this->folder,'html','add_by_category','php'));
        $this->adminFooterController();

    }






}



















