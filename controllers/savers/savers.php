<?php
require "type_cover/type_cover.php";
require "feature_cover/feature_cover.php";
class savers extends Controller
{

use type_cover,feature_cover;

    function __construct()
    {
        parent::__construct();
        $this->category = 'category_savers'; //  الماركة
        $this->table = 'name_device'; //   السلسلة
        $this->type_device = 'type_device';//  اسم الجهاز
        $this->color_savers = 'color_savers';//excel الون في كرستال
        $this->excel = 'excel_savers';//
        $this->like_savers = 'like_savers';//
        $this->cart_shop_active = 'cart_shop_active';//



        $this->product_savers = 'product_savers';//
        $this->product_savers_connect = 'product_savers_connect';//
        $this->cover_material = 'cover_material';//
        $this->type_cover = 'type_cover';//
        $this->feature_cover = 'feature_cover';//




        $this->setting=new Setting();
        $this->menu = new Menu();
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->category}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `relid` int (10) NOT NULL,
          `active` int(10) NOT NULL DEFAULT '0',
          `order_cat` int(10) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `id_cat` int(11) NOT NULL,
          `view` bigint(20) NOT NULL DEFAULT '0',
          `active` int(11) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->type_device}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `id_device` int (10) NOT NULL,
          `active` int(10) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->color_savers}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
          `color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `color_code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `type_device` int (10) NOT NULL,
           PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->excel}` (
            `id` int(10) NOT NULL AUTO_INCREMENT ,
            `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `price_dollars`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `price`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `quantity`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `color`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->like_savers}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `id_device` int(11) NOT NULL  DEFAULT '0',
          `id_member_r` int(11) NOT NULL,
          `like` int(11) NOT NULL  DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->product_savers}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `content` longtext COLLATE utf8_unicode_ci NOT NULL,
          `tags` longtext COLLATE utf8_unicode_ci NOT NULL,
          `view` bigint(20) NOT NULL DEFAULT '0',
          `active` int(11) NOT NULL DEFAULT '0',
          `bast_it` int(11) NOT NULL DEFAULT '0',
          `userId` int(11) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->product_savers_connect}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `ids` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `id_cat` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `active` int(11) NOT NULL DEFAULT '0',
          `userId` int(11) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");




        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->cover_material}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `cover_material` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `number` varchar(250) COLLATE utf8_unicode_ci NOT NULL,

          `active` int(11) NOT NULL DEFAULT '0',
          `userId` int(11) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->type_cover}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `type_cover` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `number` varchar(250) COLLATE utf8_unicode_ci NOT NULL,

          `active` int(11) NOT NULL DEFAULT '0',
          `userId` int(11) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->feature_cover}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `feature_cover` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `number` varchar(250) COLLATE utf8_unicode_ci NOT NULL,

          `active` int(11) NOT NULL DEFAULT '0',
          `userId` int(11) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        return $this->db->cht(array($this->table, $this->category, $this->feature_cover,$this->type_cover,$this->cover_material, $this->type_device, $this->color_savers, $this->excel, $this->like_savers, $this->product_savers,$this->product_savers));

    }


    public function index()
    {
        $index = new Index();
        $index->index();
    }


    public function list_savers($id = null)
    {

        $this->checkPermit('view_content', 'savers');
        $this->adminHeaderController($this->langControl('view_content'));

        require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();

    }


    public function list_view()
    {


        $stmt = $this->db->prepare("SELECT * from `{$this->category}` WHERE `active` = 1 AND {$this->is_delete}");
        $stmt->execute(array());
        $category=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row;
        }



        $date=time();


            $stmtOffer=$this->db->prepare("SELECT *FROM  offers WHERE  FIND_IN_SET('$this->folder',model)   AND `active`=1 AND {$date} BETWEEN `fromdate` AND `todate` ");
            $stmtOffer->execute();



        $offers=array();
        while ($row = $stmtOffer->fetch(PDO::FETCH_ASSOC))
        {

            $row['dollar']= $this->priceDollarOffer($row['id'],3);

            if ($row['range_price'] == 0)
            {
                $row['priceC']=$this->priceDollarOffer($row['id'],4);
                $row['range']=$row['priceC'] . '  د.ع ';

            }else
            {
                if ($this->loginUser())
                {
                    $row['priceC']=$this->priceDollarOffer($row['id'],4);
                    $row['range']=$row['priceC'] . '  د.ع ';

                }else
                {
                    $row['priceC']=$this->priceDollarOffer($row['id'],5);
                    $row['range']=$row['priceC'] . '  د.ع ';

                }

            }
            $row['image']=$this->show_file_site.$row['img'];
            $row['code']=$this->show_file_site.$row['code'];

            $offers[]=$row;
        }





        require($this->render($this->folder, 'html', 'view_list', 'php'));
    }



    public function getImage($id,$limit)
    {
        $stmt = $this->db->prepare("SELECT `id`,`img` FROM `{$this->product_savers}` WHERE   `id`= ?   LIMIT $limit ");
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }




    function numberItems($id)
    {
        $stmt = $this->db->prepare("SELECT `id`  FROM product_savers WHERE   `id_product`= ? AND {$this->is_delete} ");
        $stmt->execute(array($id));
        return $stmt;
    }



    public function smt_ch_q($code,$color)
    {

        $stmt = $this->db->prepare("SELECT *FROM `{$this->excel}` WHERE   `code`= ?   AND  `color`= ?   AND  `quantity` > 0");
        $stmt->execute(array($code,trim($color)));
        return $stmt;
    }

    public function getPrice($id,$code,$limit) //for details
    {

        $stmt = $this->db->prepare("SELECT `color`,`code_color` FROM `{$this->product_savers}` WHERE   `id`= ?  AND {$this->is_delete} ");
        $stmt->execute(array($id));

        $arr_code=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $arr_code[]=$row;
        }


        $stop=false;

        foreach ($arr_code as $color)
        {
            $stmt2 = $this->db->prepare("SELECT `price`,`price_dollars` FROM `{$this->excel}` WHERE   `code`= ?  AND    `color`= ?  AND    `quantity` <> '' AND  `quantity` <> 0   AND  `quantity`  >  0        LIMIT 1 ");
            $stmt2->execute(array($code,$color['color']));
            if ($stmt2->rowCount() > 0)
            {

                $stop=true;
                $result_= $stmt2->fetch(PDO::FETCH_ASSOC);

                return array('price'=>$result_['price'],'color'=>$color['color'],'code_color'=>$color['code_color']);
                break;
            } else {
                continue;
            }

        }

        if ($stop ==false)
        {
            $stmt = $this->db->prepare("SELECT  `price`,`price_dollars`,`code_color`,`color` FROM `{$this->product_savers}` WHERE   `id`= ? AND {$this->is_delete} ");
            $stmt->execute(array($id));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);

            $stmt2 = $this->db->prepare("SELECT `price`  FROM `{$this->excel}` WHERE `code`= ?  AND    `color`= ?       LIMIT 1 ");
            $stmt2->execute(array($code,$result['color']));
            $result_= $stmt2->fetch(PDO::FETCH_ASSOC);
            return array('price'=>$result_['price'],'color'=>$result['color'],'code_color'=>$result['code_color']);
        }



    }


    public function getPrice2($id,$code,$limit) //for lest
    {

        $stmt = $this->db->prepare("SELECT `color`,`code_color` FROM `{$this->product_savers}` WHERE   `id_product`= ?  AND {$this->is_delete}    ");
        $stmt->execute(array($id));

        $arr_code=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $arr_code[]=$row;
        }



        $stop=false;

        foreach ($arr_code as $color)
        {
            $stmt2 = $this->db->prepare("SELECT `price`,`price_dollars`,`wholesale_price` FROM `{$this->excel}` WHERE   `code`= ?  AND    `color`= ?  AND    `quantity` <> '' AND  `quantity` <> 0   AND  `quantity`  >  0        LIMIT 1 ");
            $stmt2->execute(array($code,$color['color']));
            if ($stmt2->rowCount() > 0)
            {

                $stop=true;
                $result_= $stmt2->fetch(PDO::FETCH_ASSOC);


                if ($this->loginUser() )
                {

                    $price = $this->price_dollarsAdmin($result_['price_dollars']);
                    return array('price'=>$price,'price_dollars' => $result_['price_dollars'],'color'=>$color['color'],'code_color'=>$color['code_color']);
                }else
                {
                    $price = $this->price_dollars($result_['price_dollars']);
                    return array('price'=>$price,'price_dollars' => $result_['price_dollars'],'color'=>$color['color'],'code_color'=>$color['code_color']);
                }

                break;
            } else {
                continue;
            }

        }

        if ($stop ==false)
        {
            $stmt = $this->db->prepare("SELECT  `price`,`price_dollars`,`code_color`,`color` FROM `{$this->product_savers}` WHERE   `id`= ?    AND {$this->is_delete} ");
            $stmt->execute(array($id));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);

            $stmt2 = $this->db->prepare("SELECT `price`  FROM `{$this->excel}` WHERE `code`= ?  AND    `color`= ?       LIMIT 1 ");
            $stmt2->execute(array($code,$result['color']));
            $result_= $stmt2->fetch(PDO::FETCH_ASSOC);


            if ($this->loginUser() )
            {

                $price = $this->price_dollarsAdmin($result_['price_dollars']);
                return array('price'=>$price,'color'=>$result['color'],'code_color'=>$result['code_color']);
            }else
            {
                $price = $this->price_dollars($result_['price_dollars']);
                return array('price'=>$price,'color'=>$result['color'],'code_color'=>$result['code_color']);
            }


        }



    }




    public function getPriceNew($code) //for lest
    {

            $stmt2 = $this->db->prepare("SELECT  *FROM `excel_savers` WHERE   `code`= ?   AND    `quantity` <> '' AND  `quantity` <> 0   AND  `quantity`  >  0    LIMIT 1 ");
            $stmt2->execute(array($code));
            if ($stmt2->rowCount() > 0) {
				$result_ = $stmt2->fetch(PDO::FETCH_ASSOC);

				if ($this->loginUser() )
				{

					$price = $this->price_dollarsAdmin($result_['price_dollars']);
					return array('price'=>$price,'quantity'=>$result_['quantity']);
				}else
				{
					$price = $this->price_dollars($result_['price_dollars']);
					return array('price'=>$price,'quantity'=>$result_['quantity']);
				}
			}else
			{
				return false;
			}

    }



    public function details($id,$id_device)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        if (!is_numeric($id_device)) {$error=new Errors(); $error->index();}


        $id_device_customer = $id_device;
		$stmt=$this->db->prepare("SELECT *FROM {$this->product_savers} WHERE  `id` = ?  AND {$this->is_delete} ");
		$stmt->execute(array($id));
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
        $result['id_type_device']= $result['id_device'];
		$latiniin=array();
		if ($result['latiniin'])
        {
            $stmt = $this->db->prepare("SELECT * from product_savers  WHERE `latiniin` = ?   AND {$this->is_delete}");
            $stmt->execute(array($result['latiniin']));
        }else
        {
            $stmt = $this->db->prepare("SELECT * from product_savers  WHERE   `id` = ?  AND {$this->is_delete} ");
            $stmt->execute(array($id));
        }

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$row['image'] = $this->save_file . $row['img'];

			$smt_price = $this->getPriceNew($row['code']);
			if ($smt_price) {


				$stmtlc=$this->db->prepare("SELECT *FROM location WHERE `code`=? AND model=? ");
				$stmtlc->execute(array($row['code'],'savers'));
				$row['location']=array();
				while ($rowlc = $stmtlc->fetch(PDO::FETCH_ASSOC))
				{
					$row['location'][]= $rowlc;
				}


			$latiniin[]=$row;
			}
		}








		$stmt = $this->db->prepare("SELECT * from `{$this->category}` WHERE `active` = 1  AND {$this->is_delete} ");
		$stmt->execute(array());
		$category=array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$category[]=$row;
		}


        $g_c_content=array();
        $id_c=0;
        $count=0;


        $stmt = $this->db->prepare("SELECT * from `{$this->category}` WHERE `active` = 1  AND {$this->is_delete} ");
        $stmt->execute(array());
        $category=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row;
        }



        require ($this->render($this->folder,'html','details','php'));


    }


    public function getImageAndColor($id,$limit)
    {
        $stmt = $this->db->prepare("SELECT *FROM `{$this->product_savers}` WHERE   `id_product`= ?  AND {$this->is_delete}  LIMIT $limit ");
        $stmt->execute(array($id));
        return $stmt;
    }



    function price()
    {

        $code=strip_tags(trim($_GET['code']));

        $stmt= $this->db->prepare("SELECT product_savers.id , `{$this->excel}`.price_dollars, `{$this->excel}`.wholesale_price, `{$this->excel}`.wholesale_price2, `{$this->excel}`.cost_price from `{$this->excel}` INNER  JOIN product_savers  ON product_savers.code={$this->excel}.code  WHERE  {$this->excel}.`code`=? AND  product_savers.`code`=?  LIMIT 1 ");
        $stmt->execute(array($code,$code));
        if ($stmt->rowCount()>0)
        {

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

          require($this->render($this->folder, 'html', 'price', 'php'));

        }else
        {
            echo  'السعر غير معروف';
        }


    }





    function getNmaDevice_public($id)
    {



        $stmt = $this->db->prepare("SELECT * from `{$this->table}` WHERE `id_cat`= ?  AND {$this->is_delete} ");
        $stmt->execute(array($id));
        $nameDevice = array();
        $c=0;
        $html='';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if ($c==0)
            {
                $html.="<option value='{$row['id']}'  selected >{$row['title']}</option>"  ;
            }else
            {
                $html.="<option value='{$row['id']}'   >{$row['title']}</option>"  ;
            }

            $c++;
        }
        echo $html ;

    }



    function colorDevice_public($id,$type='all')
    {

		$table=array();

        $stmt_ch = $this->db->prepare("SELECT `ids` FROM `product_savers_connect` WHERE  FIND_IN_SET(?,`ids`)  AND  active=1 LIMIT 1");
        $stmt_ch->execute(array($id));
        if ($stmt_ch->rowCount()>0)
        {
            $result = $stmt_ch->fetch(PDO::FETCH_ASSOC);
            $ids=$result['ids'];
            if ($type=='all')
            {
                $stmt = $this->db->prepare("SELECT type_device.id as id_type_device, type_device.title as title_device, product_savers.*,{$this->excel}.price_dollars as excel_price_dollars , {$this->excel}.wholesale_price , {$this->excel}.wholesale_price2 , {$this->excel}.cost_price from `product_savers` INNER JOIN type_device ON type_device.id =product_savers.id_device   INNER  JOIN {$this->excel} ON {$this->excel}.code =product_savers.code WHERE product_savers.`id_device`  IN ({$ids})  AND product_savers.`active`=1 AND  product_savers.`img` <> '' AND product_savers.`title` <> ''  AND   {$this->excel}.`quantity`  >  0   AND product_savers.`is_delete`=0");
                $stmt->execute();
            }else
            {

                $type="'%{$type}%'";
                $stmt = $this->db->prepare("SELECT type_device.id as id_type_device, type_device.title as title_device, product_savers.*,{$this->excel}.price_dollars as excel_price_dollars , {$this->excel}.wholesale_price , {$this->excel}.wholesale_price2 , {$this->excel}.cost_price  from `product_savers` INNER JOIN type_device ON type_device.id =product_savers.id_device  JOIN {$this->excel} ON {$this->excel}.code =product_savers.code WHERE product_savers.`id_device`  IN ({$ids})  AND product_savers.`active`=1 AND  product_savers.`img` <> '' AND product_savers.`title` <> '' AND ( product_savers.latiniin LIKE '%fm%' OR product_savers.latiniin LIKE  ? ) AND   {$this->excel}.`quantity`  >  0  AND product_savers.`is_delete`=0");
                $stmt->execute(array($type));
            }


        }else{


            if ($type=='all')
            {
                $stmt = $this->db->prepare("SELECT  type_device.id as id_type_device ,type_device.title as title_device, product_savers.*,{$this->excel}.price_dollars as excel_price_dollars , {$this->excel}.wholesale_price , {$this->excel}.wholesale_price2 , {$this->excel}.cost_price  from `product_savers` INNER JOIN type_device ON type_device.id =product_savers.id_device   JOIN {$this->excel} ON {$this->excel}.code =product_savers.code WHERE product_savers.`id_device` = ?    AND product_savers.`active`=1 AND  product_savers.`img` <> '' AND product_savers.`title` <> '' AND   {$this->excel}.`quantity`  >  0 AND product_savers.`is_delete`=0");
                $stmt->execute(array($id));
            }else
            {

                $type="'%{$type}%'";
                $stmt = $this->db->prepare("SELECT type_device.id as id_type_device, type_device.title as title_device, product_savers.*,{$this->excel}.price_dollars as excel_price_dollars , {$this->excel}.wholesale_price , {$this->excel}.wholesale_price2 , {$this->excel}.cost_price  from `product_savers` INNER JOIN type_device ON type_device.id =product_savers.id_device   JOIN {$this->excel} ON {$this->excel}.code =product_savers.code WHERE product_savers.`id_device` = ?    AND product_savers.`active`=1 AND  product_savers.`img` <> '' AND product_savers.`title` <> ''  AND ( product_savers.latiniin LIKE '%fm%' OR product_savers.latiniin LIKE  ? ) AND   {$this->excel}.`quantity`  >  0  AND product_savers.`is_delete`=0");
                $stmt->execute(array($id,$type));
            }



        }

		if ($stmt->rowCount() > 0 ){
			while ($idProd=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$idProd['image'] = $this->save_file . $idProd['img'];
				$idProd['id_device'] = $idProd['id_type_device'];

            	 $stmt_cat = $this->db->prepare("SELECT `title` FROM `type_device` WHERE id=?  AND  active=1 LIMIT 1");
                $stmt_cat->execute(array($id));
                if($stmt_cat->rowCount()>0)
                {
                    $row_cat = $stmt_cat->fetch(PDO::FETCH_ASSOC);
                    $idProd['title_device'] = $row_cat['title'];
                }

                $idProd['id_device_coustomer'] = $id;

                if ($this->loginUser()) {
                    $idProd['priceC'] = $this->price_dollarsAdmin($idProd['excel_price_dollars']);
                    $idProd['price'] =$idProd['priceC'] . ' د.ع ';

                    $idProd['wholesale_price'] = $this->price_dollarsAdmin($idProd['wholesale_price']). ' د.ع ';
                    $idProd['wholesale_price2'] = $this->price_dollarsAdmin($idProd['wholesale_price2']). ' د.ع ';
                    $idProd['cost_price'] = $this->price_dollarsAdmin($idProd['cost_price']). ' د.ع ';


                } else {

                        $idProd['priceC'] = $this->price_dollars($idProd['excel_price_dollars']);
                        $idProd['price'] =  $idProd['priceC']  . ' د.ع ';

                        $idProd['wholesale_price'] = $this->price_dollars($idProd['wholesale_price']). ' د.ع ';
                        $idProd['wholesale_price2'] = $this->price_dollars($idProd['wholesale_price2']). ' د.ع ';
                        $idProd['cost_price'] = $this->price_dollars($idProd['cost_price']). ' د.ع ';


                }


					$table[]= $idProd;



			}

		}


        $date=time();

        if ($id) {
            $stmtOffer=$this->db->prepare("SELECT *FROM  offers WHERE  FIND_IN_SET(?,`ids_cat`) AND  FIND_IN_SET('$this->folder',model)   AND `active`=1 AND {$date} BETWEEN `fromdate` AND `todate` ");
            $stmtOffer->execute(array($id));
        } else

        {
            $stmtOffer=$this->db->prepare("SELECT *FROM  offers WHERE  FIND_IN_SET('$this->folder',model)   AND `active`=1 AND {$date} BETWEEN `fromdate` AND `todate` ");
            $stmtOffer->execute();
        }

        $offers=array();
        while ($row = $stmtOffer->fetch(PDO::FETCH_ASSOC))
        {

            $row['dollar']= $this->priceDollarOffer($row['id'],3);

            if ($row['range_price'] == 0)
            {
                $row['priceC']=$this->priceDollarOffer($row['id'],4);
                $row['range']=$row['priceC'] . '  د.ع ';

            }else
            {
                if ($this->loginUser())
                {
                    $row['priceC']=$this->priceDollarOffer($row['id'],4);
                    $row['range']=$row['priceC'] . '  د.ع ';

                }else
                {
                    $row['priceC']=$this->priceDollarOffer($row['id'],5);
                    $row['range']=$row['priceC'] . '  د.ع ';

                }

            }
            $row['image']=$this->show_file_site.$row['img'];
            $offers[]=$row;
        }





        require ($this->render($this->folder,'html','filter','php'));


    }


    function typeDevice_public($id)
    {


        $stmt = $this->db->prepare("SELECT * from `{$this->type_device}` WHERE `id_device`= ?  AND {$this->is_delete} ORDER BY title ASC");
        $stmt->execute(array($id));

        $c=0;
        $html='';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if ($c==0)
            {
                $html.="<option value='{$row['id']}'  selected >{$row['title']}</option>"  ;
            }else
            {
                $html.="<option value='{$row['id']}'   >{$row['title']}</option>"  ;
            }

            $c++;
        }
        echo $html ;

    }


    function getNmaDevice_public_export_excel($id)
    {



        $stmt = $this->db->prepare("SELECT * from `{$this->table}` WHERE `id_cat`= ?   AND {$this->is_delete} ");
        $stmt->execute(array($id));
        $nameDevice = array();
        $c=0;
        $html="<option value=''    ></option>" ;
//        $html="<option value='all'    >الكل</option>" ;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $html.="<option value='{$row['id']}'   >{$row['title']}</option>"  ;

            $c++;
        }
        echo $html ;

    }



    function typeDevice_public_export_excel($id)
    {


        $stmt = $this->db->prepare("SELECT * from `{$this->type_device}` WHERE `id_device`= ?  AND {$this->is_delete}  ORDER BY title ASC");
        $stmt->execute(array($id));

        $c=0;
        $html="<option value=''    ></option>" ;
//        $html="<option value='all'    >الكل</option>" ;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


                $html.="<option value='{$row['id']}'   >{$row['title']}</option>"  ;


            $c++;
        }
        echo $html ;

    }




    public function type_device($id,$limit)
    {
        $stmt = $this->db->prepare("SELECT `id`  FROM `{$this->type_device}` WHERE   `id_device`= ?  AND {$this->is_delete}   LIMIT $limit ");
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function color_device($id,$limit)
    {
        $stmt = $this->db->prepare("SELECT `color`  FROM `{$this->color_savers}` WHERE   `type_device`= ?   LIMIT $limit ");
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function excel_det($color,$code,$limit)
    {
        $stmt = $this->db->prepare("SELECT `price`,`price_dollars`,`quantity`  FROM `{$this->excel}` WHERE   `color`= ?  AND `code` = ?  LIMIT $limit ");
        $stmt->execute(array($color,$code));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function like_d($id)
    {
        if (isset($_SESSION['username_member_r'])) {
            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            $stmt = $this->db->prepare("INSERT INTO  `{$this->like_savers}` (`id_device`,`id_member_r`,`like`,`date`) value (?,?,?,?)  ");
            $stmt->execute(array($id,$_SESSION['id_member_r'],1,time()));
            echo 'done';
        }else
        {
            echo '404';
        }
    }

    public function unlike_d($id)
    {
        if (isset($_SESSION['username_member_r'])) {

            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            $stmt = $this->db->prepare("DELETE FROM  `{$this->like_savers}` WHERE `id_device`=? AND `id_member_r`=? ");
            $stmt->execute(array($id,$_SESSION['id_member_r']));
            echo 'done';
        }else
        {
            echo '404';
        }
    }
    public function ckeckLick($id)
    { if (isset($_SESSION['username_member_r'])) {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->like_savers}` WHERE `id_member_r` =?  AND `id_device` =  ? ");
        $stmt->execute(array($_SESSION['id_member_r'],$id));
        if ($stmt->rowCount()>0)
        {
            return true;
        }else
        {
            return false;
        }
    }
    }




    public function list_category()
    {

        $this->checkPermit('list_category', 'savers');
        $this->adminHeaderController($this->langControl('list_category'));

        require($this->render($this->folder, 'cat', 'list', 'php'));
        $this->adminFooterController();

    }




    public function add_category()
    {


        $this->checkPermit('add_category', 'savers');
        $this->adminHeaderController($this->langControl('add_category'));

        $data['title'] = '';
        $data['order_cat'] = '';

        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();

                $form->post('title')
                    ->val('is_empty', 'حقل اسم الماركة فارغ')
                    ->val('strip_tags');


                $form  ->post('order_cat')
                    ->val('strip_tags');

                $form  ->post('code_cat')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $data['userid'] = $this->userid;
                $data['date'] = time();

                $stmt = $this->db->prepare("INSERT INTO `{$this->category}` (`title`,`order_cat`,`date`) VALUE (?,?,?)");
                $stmt->execute(array($data['title'], $data['order_cat'], $data['date']));
				// h27
				// هنا ناخذ آيدي الفئة المضافة حتى نضيفها بعدين لجدول المزامنة
				$id_cat_h = $this->db->lastInsertId();
            	//  هنا صارت اضافة الايدي حتى ما ناثر ولا نتاثر باضافة الصورة
				$this->Add_to_sync_schedule($id_cat_h,'savers','add_category_savers');
                $this->lightRedirect(url . "/savers/list_category", 0);

            } catch (Exception $e) {
                $data = $form->fetch();
                $data['date'] = strtotime($data['date']);
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }

        require($this->render($this->folder, 'cat', 'add', 'php'));
        $this->adminFooterController();

    }



    public function edit_category($id)
    {
        $this->checkPermit('edit_category', 'savers');
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }
        $files = new Files();
        $this->adminHeaderController($this->langControl('edit_category'));

        $data = $this->db->select("SELECT * from `{$this->category}` WHERE `id`=:id LIMIT 1 ", array(':id' => $id));
        $data = $data[0];


        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();

                $form->post('title')
                    ->val('is_empty', 'حقل اسم الماركة فارغ')
                    ->val('strip_tags');


                $form  ->post('order_cat')
                    ->val('strip_tags');

                $form  ->post('code_cat')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();

                if ($this->permit('save_edit_catg',$this->folder)) {
                    $stmt = $this->db->prepare("UPDATE `{$this->category}` SET  `title`=? ,  `order_cat`=?   WHERE `id`=?");
                    $stmt->execute(array($data['title'], $data['order_cat'], $id));

					// h27
					$this->Add_to_sync_schedule($id,'savers','add_category_savers');
                    $this->lightRedirect(url . "/savers/list_category", 0);
                }

            } catch (Exception $e) {
                $data = $form->fetch();
                $data['date'] = strtotime($data['date']);
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }


        require($this->render($this->folder, 'cat', 'edit', 'php'));
        $this->adminFooterController();

    }






    public function add()
    {


        $this->checkPermit('add', 'savers');
        $this->adminHeaderController($this->langControl('add'));


        $category = $this->db->select("SELECT * from `{$this->category}`  WHERE {$this->is_delete} ");


        $data['id_cat'] = '';
        $data['date'] = time();
        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();

                $form->post('id_cat')
                    ->val('is_empty', 'اختر الماركة')
                    ->val('strip_tags');

                $form->post('name_device')
                    ->val('is_array')
                    ->val('strip_tags');



                $form->submit();
                $data = $form->fetch();
                $data['date'] = time();


                $name_device = json_decode($data['name_device'], true);



                foreach ($name_device as $key => $save_data) {
                    $stmt_c = $this->db->prepare("INSERT INTO `{$this->table}` (`title`,`id_cat`,`date`) VALUE (?,?,?)");
                    $stmt_c->execute(array($save_data,$data['id_cat'], time()));
               		//             h27
                	//             	هنا ناخذ آيدي الفئة المضافة حتى نضيفها بعدين لجدول المزامنة
                	$id_cat_h = $this->db->lastInsertId();
                	//  هنا صارت اضافة الايدي حتى ما ناثر ولا نتاثر باضافة الصورة
					$this->Add_to_sync_schedule($id_cat_h,$this->table,'add_name_device');
                }

                $this->lightRedirect(url . "/savers/list_savers", 0);

            } catch (Exception $e) {
                $data = $form->fetch();
                $data['date'] = strtotime($data['date']);
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }

        require($this->render($this->folder, 'html', 'add', 'php'));
        $this->adminFooterController();

    }



    public function edit($id)
    {
        $this->checkPermit('edit', 'savers');
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }

        $files = new Files();
        $this->adminHeaderController($this->langControl('edit'));

        $data = $this->db->select("SELECT * from `{$this->table}` WHERE `id`=:id LIMIT 1 ", array(':id' => $id));
        $data = $data[0];

        $category = $this->db->select("SELECT * from `{$this->category}`  WHERE {$this->is_delete}");


        $catg = $this->db->select("SELECT * from `{$this->category}` WHERE `id`=:id LIMIT 1 ", array(':id' => $data['id_cat']));
        $catg = $catg[0];




        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();

                $form->post('id_cat')
                    ->val('is_empty', 'اختر الماركة ')
                    ->val('strip_tags');

                $form->post('title')
                    ->val('is_empty', '   اسم السلسة ')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();

                if ($this->permit('save_edit',$this->folder)) {
                    $this->db->update($this->table, $data, "id={$id}");

					//                 h27
					$this->Add_to_sync_schedule($id,$this->table,'add_name_device');
                    $this->lightRedirect(url . "/savers/list_savers", 0);
                }

            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }


        require($this->render($this->folder, 'html', 'edit', 'php'));
        $this->adminFooterController();

    }




    public function list_type_device()
    {

        $this->checkPermit('type_device', 'savers');
        $this->adminHeaderController($this->langControl('type_device'));

        require($this->render($this->folder, 'type', 'list', 'php'));
        $this->adminFooterController();

    }

    public function add_type_device()
    {


        $this->checkPermit('add_type_device', 'savers');
        $this->adminHeaderController($this->langControl('add_type_device'));

        $category = $this->db->select("SELECT * from `{$this->table}`  WHERE {$this->is_delete} ");



        $stmt_device_name = $this->db->prepare("SELECT *FROM `menu_link_device_acc_cover` ");
        $stmt_device_name->execute();
        $device_name= array();
        while ($row = $stmt_device_name->fetch(PDO::FETCH_ASSOC)) {
            $device_name[] = $row;
        }





        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();

                $form->post('id_device')
                    ->val('is_empty', 'اختر السلسلة')
                    ->val('strip_tags');

                $form->post('type_device')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('id_device_mobile')
                    ->val('is_array')
                    ->val('strip_tags');



                $form->submit();
                $data = $form->fetch();
                $data['date'] = time();



                $type_device = json_decode($data['type_device'], true);
                $id_device_mobile= json_decode($data['id_device_mobile'], true);



                foreach ($type_device as $key => $save_data) {
                    $stmt_c = $this->db->prepare("INSERT INTO `{$this->type_device}` (`title`,`id_device_mobile`,`id_device`,`date`,userid) VALUE (?,?,?,?,?)");
                    $stmt_c->execute(array($save_data,$id_device_mobile[$key],$data['id_device'], time(),$this->userid));
					//             h27
					//             	هنا ناخذ آيدي الفئة المضافة حتى نضيفها بعدين لجدول المزامنة
					$id_cat_h = $this->db->lastInsertId();

					$this->auto_select_device($id_cat_h);

                	//  هنا صارت اضافة الايدي حتى ما ناثر ولا نتاثر باضافة الصورة
                	$this->Add_to_sync_schedule($id_cat_h,'type_device','add_type_device');
                }

                $this->lightRedirect(url . "/savers/list_type_device", 0);

            } catch (Exception $e) {
                $data = $form->fetch();
                $data['date'] = strtotime($data['date']);
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }

        require($this->render($this->folder, 'type', 'add', 'php'));
        $this->adminFooterController();

    }



    public function edit_type_device($id)
    {
        $this->checkPermit('edit_type_device', 'savers');
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }

        $files = new Files();
        $this->adminHeaderController($this->langControl('edit'));

        $data = $this->db->select("SELECT * from `{$this->type_device}` WHERE `id`=:id LIMIT 1 ", array(':id' => $id));
        $data = $data[0];

        $category = $this->db->select("SELECT * from `{$this->table}` WHERE  {$this->is_delete} ");


        $catg = $this->db->select("SELECT * from `{$this->table}` WHERE `id`=:id LIMIT 1 ", array(':id' => $data['id_device']));
        $catg = $catg[0];



        $stmt_device_name = $this->db->prepare("SELECT *FROM `menu_link_device_acc_cover` ");
        $stmt_device_name->execute();
        $device_name= array();
        while ($row = $stmt_device_name->fetch(PDO::FETCH_ASSOC)) {
            $device_name[] = $row;
        }


        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();

                $form->post('id_device')
                    ->val('is_empty', 'اختر الماركة ')
                    ->val('strip_tags');

                $form->post('title')
                    ->val('is_empty', '   اسم السلسة ')
                    ->val('strip_tags');


                $form->post('id_device_mobile')
                    ->val('is_empty', ' تحديد الجهاز مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $data['userid']=$this->userid;
                if ($this->permit('save_edit',$this->folder)) {
                    $this->db->update($this->type_device, $data, "id={$id}");
                    $this->auto_select_device($id);
					//                 h27
					$this->Add_to_sync_schedule($id,'type_device','add_type_device');
                    $this->lightRedirect(url . "/savers/list_type_device", 0);
                }

            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }


        require($this->render($this->folder, 'type', 'edit', 'php'));
        $this->adminFooterController();

    }




    function save_file($image)
    {

        $save_file = $this->root_file;
        @mkdir($save_file);
        $path = $save_file;

        $file = array();
        foreach ($image["name"] as $i => $data) {
            if ($image['error'][$i] == 0) {
                $fileName_agency_file = $image['name'][$i];
                $file_agency_file = $image['tmp_name'][$i];
                $temp_agency_file = explode(".", $fileName_agency_file);
                $extension_agency_file = strtolower(end($temp_agency_file));
                $fileName_agency_file = time() . md5(mt_rand(1, time())) . '_.' . $extension_agency_file;
                move_uploaded_file($file_agency_file, $path . '/' . $fileName_agency_file);
                $setting=new Setting();
                $file_class=new Files();
                $file_class->smart_resize_image($this->root_file.$fileName_agency_file,$this->root_file.$fileName_agency_file,null,$setting->get('width',1800) ,$setting->get('height',1600),$setting->get('proportional',1),'file',false,false, $setting->get('quality',75) , $setting->get('grayscale',0) );

                $file[$i] = $fileName_agency_file;
            }
        }
        return $file;
    }



    function check_file($image, $arg, $ex = array())
    {

        foreach ($image["name"] as $i => $data) {
            if ($image['error'][$i] == 0) {
                $fileName_agency_file = $image['name'][$i];
                $file_agency_file = $image['tmp_name'][$i];
                $temp_agency_file = explode(".", $fileName_agency_file);
                $extension_agency_file = strtolower(end($temp_agency_file));
                if ($image['size'][$i] < 5194304) {
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
    }


    public function processing()
    {


        $table = $this->category;
        $primaryKey = 'id';

        $columns = array(


            array('db' => 'title', 'dt' => 0),

            array(
                'db' => 'id',
                'dt' =>1,
                'formatter' => function ($id, $row) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/savers/list_saver_connect/$id>  <span>ربط الاجهزة</span> </a>
                    </div> ";
                }
            ),

            array('db' => 'date', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d ', $d);
                }

            ),
            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible',$this->folder)) {
                    return "
                <div style='text-align: center'>
                  <input {$this->ch($id)} class='toggle-demo' onchange='visible_savers(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),

            array(
                'db' => 'id',
                'dt' =>4,
                'formatter' => function ($id, $row) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/savers/edit_category/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db' => 'id',
                'dt' =>5,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete',$this->folder)) {
                    return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => 'id', 'dt' => 6)


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
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
        );

    }

    public function processing_hardware_chains()
    {


        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(


            array('db' => 'title', 'dt' => 0),
            array('db' => 'date', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d ', $d);
                }

            ),
            array(
                'db' => 'id',
                'dt' => 2,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible',$this->folder)) {
                    return "
                <div style='text-align: center'>
                  <input {$this->ch_name_device($id)} class='toggle-demo' onchange='visible_savers(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),

            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/savers/edit/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db' => 'id',
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete',$this->folder)) {
                    return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => 'id', 'dt' => 5)


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
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,'is_delete = 0')
        );

    }



    public function processing_type_device()
    {


        $table = $this->type_device;
        $primaryKey = $table.'.id';

        $columns = array(


            array('db' => $table.'.title', 'dt' => 0),
            array('db' =>  'menu_link_device_acc_cover.name_device', 'dt' => 1),
            array('db' => $table.'.date', 'dt' => 2,
                'formatter' => function ($d, $row) {
                 return date('Y-m-d h:i:s a', $d);
                }

            ),
            array(
                'db' => $table.'.id',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible',$this->folder)) {
                    return "
                     {$this->off_on_device($id)}
                <div style='text-align: center'>
                  <input {$this->ch_type_device($id)} class='toggle-demo' onchange='visible_savers(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),

            array(
                'db' => $table.'.id',
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/savers/edit_type_device/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db' => $table.'.id',
                'dt' => 5,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete',$this->folder)) {
                    return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array(
                'db' => $table.'.userid',
                'dt' => 6,
                'formatter' => function ($id, $row) {

                    return $this->UserInfo($id);
                }
            ),
            array('db' =>$table.'.id', 'dt' => 7),
            array('db' =>$table.'.active', 'dt' => 8)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


                    $join = "LEFT JOIN menu_link_device_acc_cover ON menu_link_device_acc_cover.id=type_device.id_device_mobile";
                    $whereAll = array(" $table.is_delete=0 ");
                echo json_encode(

                SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null));

    }




    public function visible_savers($v_, $id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }
        $data = $this->db->update($this->category, array('active' => $v), "`id`={$id}");
    }

    public function visible_savers_name_device($v_, $id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }

        $data = $this->db->update($this->table, array('active' => $v), "`id`={$id}");
    }

    public function visible_savers_type_device($v_, $id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }

        $data = $this->db->update($this->type_device, array('active' => $v), "`id`={$id}");
    }


    public function ch($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->category} WHERE `id` = ? AND `active` = 1  AND {$this->is_delete}");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }


    public function ch_name_device($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `active` = 1  AND {$this->is_delete}");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }


    public function ch_type_device($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->type_device} WHERE `id` = ? AND `active` = 1  AND {$this->is_delete}");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }

    public function off_on_device($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->type_device} WHERE `id` = ? AND `active` = 1   AND {$this->is_delete}");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'ON';
        } else {
            return 'OFF';
        }
    }


    function remove_row_database($id)
    {
        if ($this->handleLogin() ) {

            $trace=new trace_site();
            $oldData=$trace->trace_category($id,$this->table);
            $trace->add($id,'category_'.$this->folder,'delete',$trace->inforow($id,$this->table,'title'),'',$oldData,'');

            // $c= $this->db->prepare("DELETE FROM `$this->table`  WHERE  `id`=?");
            // $c->execute(array($id));

//            $c= $this->db->prepare("DELETE FROM `$this->type_device`  WHERE  `id_device`=?");
//            $c->execute(array($id));
            echo true;
        }
    }

    function remove_sub_row_database($id)
    {
        if ($this->handleLogin() ) {

            $trace=new trace_site();
            $oldData=$trace->trace_category($id,$this->type_device);
            $trace->add($id,'category_'.$this->folder,'delete',$trace->inforow($id,$this->type_device,'title'),'',$oldData,'');

            // $c= $this->db->prepare("DELETE FROM `$this->type_device`  WHERE  `id`=?");
            // $c->execute(array($id));
            echo true;
        }
    }

    function delete_savers($id)
    {
        if ($this->handleLogin() ) {

            $trace=new trace_site();
            $oldData=$trace->trace_category($id,$this->category);
            $trace->add($id,'category_'.$this->folder,'delete',$trace->inforow($id,$this->category,'title'),'',$oldData,'');


            // $response = $this->db->delete($this->category, "`id`={$id}");
  			 $this->update_is_delete($this->category, 'id = '.$id.'');
        	 $stmt_name_device =$this->db->prepare("SELECT id FROM name_device where id_cat = $id AND is_delete = 0");
                $stmt_name_device->execute();
                if($stmt_name_device->rowCount()>0)
                {
                    while($row_name = $stmt_name_device->fetch())
                    {
                    	$this->update_is_delete($this->table, 'id = '.$row_name['id'].'');
                    	$this->update_is_delete('type_device', 'id_device = '.$row_name['id'].'');
                     	 $stmt_type_device =$this->db->prepare("SELECT id FROM type_device where id_device = ".$row_name['id']."");
                		 $stmt_type_device->execute();
                		if($stmt_type_device->rowCount()>0)
                		{
                    		while($row_type = $stmt_type_device->fetch())
                    		{
                        		$stmt_savers =$this->db->prepare("SELECT `id`,`code` FROM product_savers where id_device = ".$row_type['id']."");
                                $stmt_savers->execute();
                                while($row_savers = $stmt_savers->fetch())
                                {
                                    $this->update_code('product_savers',$row_savers['code'],$row_savers['id']);
                                }
                                $this->update_is_delete('product_savers', 'id_device = '.$row_type['id'].' AND is_delete = 0');

        	        		}
                		}

                    // $this->update_is_delete('product_savers', 'id = '.$row_savers['id'].'');
                        // $result_update_name_device = $this->delete_savers_name_device($row_name['id']);

        	        }
                }

        		  $this->Add_to_sync_schedule($id,$this->category,'delete_category_savers');

//            $c_id = $this->db->prepare("SELECT `id` FROM `$this->table`  WHERE  `id_cat`=? limit 1");
//            $c_id->execute(array($id));
//            $c_id_c = $c_id->fetch(PDO::FETCH_ASSOC)['id'];
//
//            $c = $this->db->prepare("DELETE FROM `$this->table`  WHERE  `id_cat`=?");
//            $c->execute(array($id));
//
//            $cd = $this->db->prepare("DELETE FROM `$this->type_device`  WHERE  `id_device`=?");
//            $cd->execute(array($c_id_c));
        }
    }



    function delete_savers_name_device($id)
    {
        if ($this->handleLogin() ) {
            // $response = $this->db->delete($this->table, "`id`={$id}");



            $trace=new trace_site();
            $oldData=$trace->trace_category($id,$this->table);
            $trace->add($id,'category_'.$this->folder,'delete',$trace->inforow($id,$this->table,'title'),'',$oldData,'');

            // $c = $this->db->prepare("DELETE FROM `$this->table`  WHERE  `id`=?");
            // $c->execute(array($id));


        	$this->update_is_delete($this->table, 'id = '.$id.'');
          	$stmt_type_device =$this->db->prepare("SELECT id FROM type_device where id_device = $id ");
            $stmt_type_device->execute();
                if($stmt_type_device->rowCount()>0)
                {
                    while($row_type = $stmt_type_device->fetch())
                    {
                        $this->update_is_delete('type_device', 'id = '.$row_type['id'].'');
                    	$stmt_savers=$this->db->prepare("SELECT id FROM `product_savers` where id_device = ".$row_type['id']." ");
                		$stmt_savers->execute();
                		if($stmt_savers->rowCount()>0)
                		{
                    		while($row_savers = $stmt_savers->fetch())
                    		{
                                $this->update_code('product_savers',$row_savers['code'],$row_savers['id']);
                    			$this->update_is_delete('product_savers', 'id = '.$row_savers['id'].'');

        	        		}
                		}


        	        }
                }
            $this->Add_to_sync_schedule($id,'name_device','delete_name_device');

//            $cd = $this->db->prepare("DELETE FROM `$this->type_device`  WHERE  `id_device`=?");
//            $cd->execute(array($response['id']));
        }
    }



    function delete_savers_connect($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->product_savers_connect, "`id`={$id}");
        }
    }


    function delete_savers_type_device($id)
    {
        if ($this->handleLogin() ) {

            $trace=new trace_site();
            $oldData=$trace->trace_category($id,$this->type_device);
            $trace->add($id,'category_'.$this->folder,'delete',$trace->inforow($id,$this->type_device,'title'),'',$oldData,'');

            // $cd = $this->db->prepare("DELETE FROM `$this->type_device`  WHERE  `id`=?");
            // $cd->execute(array($id));


        	 $this->update_is_delete('type_device', 'id = '.$id.'');
        	 $stmt_savers=$this->db->prepare("SELECT id FROM `product_savers` where id_device = $id AND is_delete = 0 ");
             $stmt_savers->execute();
                if($stmt_savers->rowCount()>0)
                {
                    while($row_savers = $stmt_savers->fetch())
                    {
                        $this->update_code('product_savers',$row_savers['code'],$row_savers['id']);
                    	$this->update_is_delete('product_savers', 'id = '.$row_savers['id'].' AND is_delete = 0');

        	        }
                }

        		$this->Add_to_sync_schedule($id,'type_device','delete_type_device');

        }
    }




    function connect($id=null)
    {
        $this->checkPermit('connect_between_cover_and_excel', 'savers');
        $this->adminHeaderController($this->langControl('connect_between_cover_and_excel'));

        $stmt = $this->db->prepare("SELECT * from `{$this->category}`  WHERE {$this->is_delete}");
        $stmt->execute(array());
        $category=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row;
        }


        require($this->render($this->folder, 'html', 'connect', 'php'));
        $this->adminFooterController();

    }


    function excel($id=null)
    {
        $this->checkPermit('connect_between_cover_and_excel', 'savers');
        $this->adminHeaderController($this->langControl('connect_between_cover_and_excel'));

        $stmt = $this->db->prepare("SELECT * from `{$this->category}`   ");
        $stmt->execute(array());
        $category=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row;
        }


        require($this->render($this->folder, 'html', 'excel', 'php'));
        $this->adminFooterController();

    }


      function  excel_ajax()
        {

             $lastId=0;
            if(isset($_POST["submit"])) {


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



						$x=array();
                        for ($row = 1; $row <= $highestRow; $row++) {
							//  Read a row of data into an array
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
								NULL,
								TRUE,
								TRUE);


							 if (count($rowData[0]) >= 7) {
								if (count($rowData[0]) == 7) {
									$rowData[0][7] = '';
								}


								 $stmtUp1 = $this->db->prepare("UPDATE `color_savers` SET `color`=?,symbol=? where color = ?");
								 $stmtUp1->execute(array($rowData[0][4], $rowData[0][5], $rowData[0][1]));

								 $stmtUp2 = $this->db->prepare("UPDATE `product_savers` SET `color`=?,symbol=?,`code`=?,`title`=?,latiniin=?,`content`=?  where color = ? AND code =?");
								 $stmtUp2->execute(array($rowData[0][4], $rowData[0][5], $rowData[0][2], $rowData[0][3], $rowData[0][6], $rowData[0][7], $rowData[0][1], $rowData[0][0]));


/*
								 $stmt = $this->db->prepare("SELECT *FROM `color_savers` where color = ?");
								$stmt->execute(array($rowData[0][1]));
								if ($stmt->rowCount() > 0) {

									$stmtUp1 = $this->db->prepare("UPDATE `color_savers` SET `color`=?,symbol=? where color = ?");
									$stmtUp1->execute(array($rowData[0][4], $rowData[0][5], $rowData[0][1]));

								} else {

									$stmtIn1 = $this->db->prepare("INSERT  INTO `color_savers` (`color`,`symbol`) VALUES (?,?) ");
									$stmtIn1->execute(array($rowData[0][4], $rowData[0][5]));
								}


								$stmt2 = $this->db->prepare("SELECT *FROM `product_savers` where color = ? AND code =? ");
								$stmt2->execute(array($rowData[0][1], $rowData[0][0]));
								if ($stmt2->rowCount() > 0) {

									$stmtUp2 = $this->db->prepare("UPDATE `product_savers` SET `color`=?,symbol=?,`code`=?,`title`=?,latiniin=?,`content`=?  where color = ? AND code =?");
									$stmtUp2->execute(array($rowData[0][4], $rowData[0][5], $rowData[0][2], $rowData[0][3], $rowData[0][6], $rowData[0][7], $rowData[0][1], $rowData[0][0]));

								} else {

									$stmtIn2 = $this->db->prepare("INSERT  INTO `product_savers` (`color`,symbol,`code`,`title`,latiniin,`content` ) VALUES (?,?,?,?,?,?) ");
									$stmtIn2->execute(array($rowData[0][4], $rowData[0][5], $rowData[0][2], $rowData[0][3], $rowData[0][6], $rowData[0][7]));
								}

*/
							 }else
						       {
							  echo 'a';
					    	}
						}
                        @unlink($inputFileName);
                        echo '1';

                    }else
                    {

                       echo 'b';
                    }


                } catch (Exception $e) {
                    $data =$form -> fetch();
                    $this->error_form=$e -> getMessage();

                }


            }



        }



    function getNmaDevice($id)
    {
        if ($this->handleLogin() ) {

            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }

            $stmt = $this->db->prepare("SELECT * from `{$this->table}` WHERE `id_cat`= ?  AND {$this->is_delete} ");
            $stmt->execute(array($id));
            $nameDevice = array();
            $c=0;
            $html='';
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                if ($c==0)
                {
                    $html.="<option value='{$row['id']}'  selected >{$row['title']}</option>"  ;
                }else
                {
                    $html.="<option value='{$row['id']}'   >{$row['title']}</option>"  ;
                }

                $c++;
            }
            echo $html ;

        }
    }


    function typeDevice($id)
    {
        if ($this->handleLogin() ) {

            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }

            $stmt = $this->db->prepare("SELECT * from `{$this->type_device}` WHERE `id_device`= ?  AND {$this->is_delete} ");
            $stmt->execute(array($id));

            $c=0;
            $html='';
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                if ($c==0)
                {
                    $html.="<option value='{$row['id']}'  selected >{$row['title']}</option>"  ;
                }else
                {
                    $html.="<option value='{$row['id']}'   >{$row['title']}</option>"  ;
                }

                $c++;
            }
            echo $html ;

        }
    }

    function getColor($id)
    {
        if ($this->handleLogin() ) {

            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }

            $stmt = $this->db->prepare("SELECT * from `{$this->color_savers}` WHERE `type_device`= ?  ");
            $stmt->execute(array($id));

            $html="";
            $c=0;
            if ($stmt->rowCount() > 0)
            {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    if ($c==0)
                    {
                        $html.="
                            <div class='row'>
                            <div class='col-3'>
                              <input type='color' name='color_code[{$row['id']}]' value='{$row['color_code']}' class='form-control colorBox' >
                            </div>
                            <div class='col'>
                              <input type='text' name='color[{$row['id']}]' value='{$row['color']}' class='form-control colorBox'  placeholder='لون المادة في كرستال'>
                            </div>
                            </div>

                         "  ;

                    }else
                    {
                        $html.="
                        <div class='row'>
                        <div class='col-2'>
                          <input type='color' name='color_code[{$row['id']}]' value='{$row['color_code']}' class='form-control colorBox' >

                        </div>
                        <div class='col'>
                            <div class='input-group colorBox delete_db_color{$row['id']}'>

                          <input  type='text' name='color[{$row['id']}]' value='{$row['color']}'  class='form-control'  placeholder='لون المادة في كرستال' required>

                           <div class='input-group-prepend'>
                            <div class='input-group-text delete_row'>  <button onclick='delete_db_color({$row['id']})' class='btn btn-danger' type='button'> <i class='fa fa-trash'></i> </button>  </div>
                        </div>
                        </div>

                        </div>
                        </div>

                    "  ;
                    }
                    $c++;
                }

            }else{
                $html.="
                            <div class='row'>
                            <div class='col-3'>
                             <input  type='color' name='color_code[new]'   class='form-control colorBox'  required>
                            </div>
                            <div class='col'>
                              <input  type='text' name='color[new]'   class='form-control colorBox'  placeholder='لون المادة في كرستال' required>
                            </div>
                            </div>

                         "  ;


            }


            echo $html ;

        }
    }



    function show_color_add_edit_product($id)
    {
        if ($this->handleLogin()) {

            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }

            $stmt = $this->db->prepare("SELECT * from `{$this->color_savers}` WHERE `type_device`= ?  ");
            $stmt->execute(array($id));

            $html = "";
            $c = 0;
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $html.='<div class="col-auto"><div class="colorProduct" style="background-color:'.$row['color_code'].' "></div> </div>';
                }

                echo $html;
            }  else{
                echo '<span style="color: red">المنتج لا يحتوى على الالوان في كرستال</span>';
            }
        }


    }



    function color()
    {
        $this->checkPermit('add_color', 'savers');
        if (isset($_POST['submit']))
        {

            $typeDevice=strip_tags(trim($_POST['typeDevice']));
            $color=$_POST['color'];
            $color_code=$_POST['color_code'];
            foreach ($color as $key => $c) {
                $stmt_d = $this->db->prepare("INSERT INTO `{$this->color_savers}` (`id`,`color`,`color_code`,`type_device`) VALUE (?,?,?,?)   ON DUPLICATE KEY UPDATE `id`=VALUES(id),`color`=VALUES(color),`color_code`=VALUES(color_code),`type_device`=VALUES(type_device) ");
                $stmt_d->execute(array($key,$c,$color_code[$key], $typeDevice));
            }
            echo 'true';

        }else
        {
            echo 'false';
        }

    }


    function delete_db_color($id)
    {
        if ($this->handleLogin() ) {

            $c= $this->db->prepare("DELETE FROM `$this->color_savers`  WHERE  `id`=?");
            $c->execute(array($id));
            echo true;
        }
    }






    function car_item($id,$count,$id_type_device=0,$id_device_customer=0)
    {


        $error=array();

            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            if (!is_numeric($count)) {$error=new Errors(); $error->index();}





            $stmt_product= $this->db->prepare("SELECT  *FROM `$this->product_savers`  WHERE  `id`=?  AND {$this->is_delete}");
            $stmt_product->execute(array($id));
            $result_product=$stmt_product->fetch(PDO::FETCH_ASSOC);



         $data['id_item']=$id;
         if($id_type_device == 0){
            $id_type_device = $result_product['id_device'];
        }
        if($id_device_customer == 0){
            $id_device_customer = $result_product['id_device'];
        }
        if(!$this->isDirect())
        {
            $data['id_member_r'] = $_SESSION['id_member_r'];
        }else{
            $data['id_member_r'] = $this->isUuid();
            $data['user_direct'] = $this->userid;
        }
            $data['number']=$count;
            $data['date']=time();



            if (empty($error))
            {
                $number=preg_replace('~\D~', '', $data['number']);
                $stmt_ch= $this->db->prepare("SELECT * from `{$this->excel}` WHERE  `code`=?   AND `quantity` >= {$number}  AND `quantity` <> 0  AND `quantity` <> '' ");
                $stmt_ch->execute(array($result_product['code']));


                if ($stmt_ch->rowCount() > 0) {


                    $result = $stmt_ch->fetch(PDO::FETCH_ASSOC);

                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?    AND `table`=? AND  `id_member_r` = ? AND  `buy` = 0 AND `status` = 0     ");
                    $stmt_order->execute(array($result['code'], $this->product_savers,$data['id_member_r']));
                    $only_order=$stmt_order->fetch(PDO::FETCH_ASSOC);

                    $q= $result['quantity']  - $only_order['num'];

                    if ($q >= $number) {



                        $data['code'] = $result_product['code'];
                        $data['image'] = $result_product['img'];
                        $data['name_color'] = $result_product['color'];

                        if ($result_product['cuts']== 1)
                        {
                            $data['price'] = $result_product['price_cuts'];
                        }else
                        {
                            if ($this->loginUser()) {

                                $data['price'] = $this->price_dollarsAdmin($result['price_dollars']);

                            } else {
                                $data['price'] = $this->price_dollars($result['price_dollars']);
                            }

                        }

						$dollar=new Dollar_price();
						$data['dollar_exchange']=$dollar->dollar_get();
                        $data['price_dollars'] = $result['price_dollars'];
                        $data['table'] = $this->product_savers;


						$stmt_chx = $this->db->prepare("SELECT   *FROM `cart_shop_active` WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?   AND  price_type=0 ");
						$stmt_chx->execute(array($data['id_item'],$data['code'], $this->product_savers, $data['id_member_r']));
						if ($stmt_chx->rowCount() > 0)
						{
							$stmtUpdate_cart=$this->db->prepare("UPDATE `cart_shop_active` SET `number`=number+? WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?   AND  price_type=0");
							$stmtUpdate_cart->execute(array($data['number'],$data['id_item'],$data['code'], $this->product_savers, $data['id_member_r']));
						}else{
							$this->db->insert($this->cart_shop_active, $data);
                        	$id_cart = $this->db->lastInsertId();
                            $stmtUpdate_cart=$this->db->prepare("INSERT INTO `type_device_customer` (`model`,`id_type_device`, `id_device_customer`,`id_shop_cart`) VALUES (?,?,?,?)");
							$stmtUpdate_cart->execute(array('product_savers',$id_type_device,$id_device_customer,$id_cart));
						}


                     }else
                    {
                        echo json_encode(array(3=> "الكمية غير متوفرة الان تتوفر قريبا ." ),1);
                    }

                }else
                {

                    echo json_encode(array(3=> "الكمية غير متوفرة الان تتوفر قريبا  ." ),1);
                }
            }
            else
            {
                echo json_encode(array(1=>$error),1);
            }



    }




    function cart_order($id,$id_type_device=0,$id_device_customer=0,$count=1)
    {


        $error=array();

            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            if (!is_numeric($count)) {$error=new Errors(); $error->index();}



            $stmt_product= $this->db->prepare("SELECT  *FROM `$this->product_savers`  WHERE  `id`=?  AND {$this->is_delete}");
            $stmt_product->execute(array($id));
            $result_product=$stmt_product->fetch(PDO::FETCH_ASSOC);



         $data['id_item']=$id;
         if($id_type_device == 0){
            $id_type_device = $result_product['id_device'];
        }
        if($id_device_customer == 0){
            $id_device_customer = $result_product['id_device'];
        }
        if(!$this->isDirect())
        {
            $data['id_member_r'] = $_SESSION['id_member_r'];
        }else{
            $data['id_member_r'] = $this->isUuid();
            $data['user_direct'] = $this->userid;
        }


        if (isset($_GET['number']))
        {
            if (is_numeric($_GET['number']))
            {
                $data['number'] =strip_tags($_GET['number']);
            }else
            {
                $data['number'] = $count;
            }
        }else
        {
            $data['number'] =$count;
        }


        if (isset($_GET['price_type']))
        {
            if (is_numeric($_GET['price_type']))
            {
                $data['price_type'] =$_GET['price_type'];
            }else
            {
                $data['price_type']=0;
            }

        }else
        {
            $data['price_type']=0;
        }



        $data['date']=time();



            if (empty($error))
            {
                $number=preg_replace('~\D~', '', $data['number']);
                $stmt_ch= $this->db->prepare("SELECT * from `{$this->excel}` WHERE  `code`=?   AND `quantity` >= {$number}  AND `quantity` <> 0  AND `quantity` <> '' ");
                $stmt_ch->execute(array($result_product['code']));


                if ($stmt_ch->rowCount() > 0) {


                    $result = $stmt_ch->fetch(PDO::FETCH_ASSOC);

                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?    AND `table`=? AND  `id_member_r` = ? AND  `buy` = 0 AND `status` = 0     ");
                    $stmt_order->execute(array($result['code'], $this->product_savers,$data['id_member_r']));
                    $only_order=$stmt_order->fetch(PDO::FETCH_ASSOC);

                    $q= $result['quantity']  - $only_order['num'];

                    if ($q >= $number) {



                        $data['code'] = $result_product['code'];
                        $data['image'] = $result_product['img'];
                        $data['name_color'] = $result_product['color'];


                        if ($this->loginUser()) {

                            $data['price'] = $this->price_dollarsAdmin($result['price_dollars']);

                        } else {
                            $data['price'] = $this->price_dollars($result['price_dollars']);
                        }


                        $dollar=new Dollar_price();
						$data['dollar_exchange']=$dollar->dollar_get();


                        if ($this->ch_wcprice())
                        {

                            if ($data['price_type'] == 1) {
                                $data['price_dollars'] = $result['wholesale_price'];

                            } else if ($data['price_type'] == 2) {
                                $data['price_dollars'] = $result['wholesale_price2'];

                            } else if ($data['price_type'] == 3) {
                                $data['price_dollars'] = $result['cost_price'];
                            } else {
                                $data['price_dollars'] = $result['price_dollars'];
                            }
                        }else
                        {
                            $data['price_dollars'] = $result['price_dollars'];
                        }


                        $data['table'] = $this->product_savers;

						$stmt_chx = $this->db->prepare("SELECT   *FROM `cart_shop_active` WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?  AND  price_type=?   ");
						$stmt_chx->execute(array($data['id_item'],$data['code'], $this->product_savers, $data['id_member_r'], $data['price_type']));
						if ($stmt_chx->rowCount() > 0)
						{
							$stmtUpdate_cart=$this->db->prepare("UPDATE `cart_shop_active` SET `number`=number+? WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?   AND  price_type=? ");
							$stmtUpdate_cart->execute(array($data['number'],$data['id_item'],$data['code'], $this->product_savers, $data['id_member_r'], $data['price_type']));
						}else{
							$this->db->insert($this->cart_shop_active, $data);
                            $id_cart = $this->db->lastInsertId();
                            $stmtUpdate_cart=$this->db->prepare("INSERT INTO `type_device_customer` (`model`,`id_type_device`,`id_device_customer`,`id_shop_cart`) VALUES (?,?,?,?)");
							$stmtUpdate_cart->execute(array('product_savers',$id_type_device,$id_device_customer,$id_cart));
						}


                     }else
                    {
                        echo 'finish';
                    }

                }else
                {

                    echo 'finish';
                }
            }
            else
            {
                echo 'error';
            }



    }





    public function getAllContentFromCar_new($id_member_r)
    {
        $stmt = $this->db->prepare("SELECT `id`, `size`, `id_item`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date` FROM `{$this->cart_shop_active}` WHERE `id_member_r` =?  AND `buy` = 0 GROUP BY `id_item`,`table`,`price`,`name_color` ORDER BY `id`  DESC  ");
        $stmt->execute(array($id_member_r));
        return $stmt;
    }

    function count_c()
    {
        if ($this->isDirect())
        {
            $id=$this->isUuid();
        }else{
            $id= $_SESSION['id_member_r'];
        }

        $stmt=$this->getAllContentFromCar_new($id);
            $car=array();
            $count=0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $count=$count+$row['number'];
            }

            echo $count;

    }



    function device()
    {
        if (isset($_POST['submit'])) {

            $nameDid = strip_tags(trim($_POST['nameDevice_public']));
            $color = strip_tags(trim($_POST['colorDevice_public']));

            $result=array();
            $stmt = $this->db->prepare("SELECT * from `{$this->table}` WHERE `id` = ?  AND {$this->is_delete}  LIMIT 1");
            $stmt->execute(array($nameDid));

            while ($row =  $stmt->fetch(PDO::FETCH_ASSOC)) {


                $stmt_img_id = $this->getImage($row['id'], 1);


                $row['color'] = $color;

                $excel = $this->excel_det($row['color'], $row['code'], 1);


                if ($excel['quantity'] > 0) {
                    if (isset($_COOKIE['currency'])) {
                        if ($_COOKIE['currency'] == 0) {
                            $row['priceC'] = $excel['price'];
                            $row['price'] = $excel['price'] . ' د.ع ';
                        } else {
                            $row['priceC'] = $excel['price_dollars'];
                            $row['price'] = $excel['price_dollars'] . '$ ';
                        }

                    } else {
                        $row['priceC'] = $excel['price'];
                        $row['price'] = $excel['price'] . ' د.ع ';
                    }

                    $row['code_color'] = $row['color'];

                    $row['image'] = $this->save_file . $stmt_img_id['img'];
                    $row['nameImage'] = $stmt_img_id['img'];
                    $row['like'] = $this->ckeckLick($row['id']);
                    $result[]=$row;

                    require($this->render($this->folder, 'html', 'filter', 'php'));

                }else
                {
                    echo 'notFound';
                }

            }


        }else
        {
            echo 'notSelect';
        }

    }





    public function list_product_savers()
    {

        $this->checkPermit('product_savers', 'savers');
        $this->adminHeaderController($this->langControl('product_savers'));

        require($this->render($this->folder, 'product', 'list', 'php'));
        $this->adminFooterController();

    }











    public function processing_product_savers()
    {


        $table = $this->product_savers;
        $primaryKey = 'id';

        $columns = array(


            array('db' => 'title', 'dt' => 0),
            array('db' => 'code', 'dt' => 1),
            array('db' => 'date', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d ', $d);
                }

            ),
            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible',$this->folder)) {
                    return "
                <div style='text-align: center'>
                  <input {$this->ch_product_savers($id)} class='toggle-demo' onchange='visible_savers(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),

            array(
                'db' => 'id',
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/savers/edit_product_savers/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db' => 'id',
                'dt' => 5,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete',$this->folder)) {
                    return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => 'id', 'dt' => 6)


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
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
        );

    }





    function delete_image($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->update($this->product_savers,array('img'=>0),"`id`={$id}");
            echo 'true';
        }
    }



    function remove_row_database_color_image($id)
    {
        if ($this->handleLogin() ) {
            $c= $this->db->prepare("DELETE FROM `$this->product_savers`  WHERE  `id`=?");
            $c->execute(array($id));

            echo true;
        }
    }

    /*
        function c()
        {


    //  Include PHPExcel_IOFactory
            include 'PHPExcel/Classes/PHPExcel.php';

            $inputFileName = $this->root_file . '/files/' .'1c3902a8dbed0355df220915b798b385_.xlsx';

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

            for ($row = 1; $row <= $highestRow; $row++) {
                //  Read a row of data into an array
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                    NULL,
                    TRUE,
                    FALSE);

    //            if (count($rowData[0]) == 2) {
    //
                    $stmt = $this->db->prepare("INSERT INTO product_savers (`color`,`code`,`date`) VALUES(?,?,?)");
    //                  $stmt->execute(array(trim(str_replace('"','',$rowData[0][1])),trim(str_replace('"','',$rowData[0][0])),time() ));
    //echo $row.'<br>';
    //            }

            }


        }


        function c2()
        {
            $stmt = $this->db->prepare("SELECT `code` FROM `product_savers` GROUP BY `code`");
            $stmt->execute();
            $c=1;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $stmt2 = $this->db->prepare("INSERT INTO   product_savers (`code`,`date`) VALUES(?,?)");
                $stmt2->execute(array($row['code'],time()+1));
               if ($stmt2->rowCount() > 0)
               {
                   echo $c++ .'<br>';
               }

            }


        }



        function c3()
        {
            $stmt = $this->db->prepare("SELECT `id`,`code` FROM `product_savers`  ");
            $stmt->execute();
            $c=1;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $stmt2 = $this->db->prepare("UPDATE   product_savers SET  `id_product`=? WHERE  `code`=?");
                $stmt2->execute(array($row['id'],$row['code']));
                if ($stmt2->rowCount() > 0)
                {
                    echo $c++ .'<br>';
                }

            }

        }



    */





	function checkColor($color)
	{
		$stmt=$this->db->prepare("SELECT *FROM `color_savers` WHERE `color`=?");
		$stmt->execute(array($color));
		if ($stmt->rowCount() > 0)
		{
			return true;
		}else
		{
			return false;
		}
	}

	function checkColor_idProd($color,$id)
	{
		$stmt=$this->db->prepare("SELECT *FROM `product_savers` WHERE `color`=? AND `id_product`=?  AND {$this->is_delete}");
		$stmt->execute(array($color,$id));
		if ($stmt->rowCount() > 0)
		{
			return true;
		}else
		{
			return false;
		}
	}


	function open_savers($id=null,$type='all')
	{
		$this->checkPermit('open_savers', $this->folder);

		$this->adminHeaderController($this->langControl('open_savers'));


		$stmt = $this->db->prepare("SELECT * from `{$this->category}`  WHERE {$this->is_delete}  ");
		$stmt->execute(array());
		$category=array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$category[]=$row;
		}





		require($this->render($this->folder, 'html', 'open_savers', 'php'));
		$this->adminFooterController();




	}





	function add_product_savers($id=null,$all=null)
	{
        $this->checkPermit('add_product_savers',$this->folder);


		$stmt = $this->db->prepare("SELECT * from `{$this->category}` WHERE `active` = 1  AND {$this->is_delete}");
		$stmt->execute(array());
		$category=array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$category[]=$row;
		}


		$stmtcover_material = $this->db->prepare("SELECT * from `cover_material`   ");
		$stmtcover_material->execute(array());
        $cover_material=array();
		while ($row = $stmtcover_material->fetch(PDO::FETCH_ASSOC))
		{
			$cover_material[]=$row;
		}

        $stmttype_cover = $this->db->prepare("SELECT * from `type_cover`   ");
        $stmttype_cover->execute(array());
        $type_cover=array();
        while ($row = $stmttype_cover->fetch(PDO::FETCH_ASSOC))
        {
            $type_cover[]=$row;
        }


		$stmtfeature_cover = $this->db->prepare("SELECT * from `feature_cover`   ");
		$stmtfeature_cover->execute(array());
        $feature_cover=array();
		while ($row = $stmtfeature_cover->fetch(PDO::FETCH_ASSOC))
		{
			$feature_cover[]=$row;
		}


		$this->adminHeaderController($this->langControl('add'));

         $data['is_service']=0;


		if (isset($_POST['submit']))
		{

			try{
				$form =new Form();

				$form  ->post('devise')
					->val('is_empty','مطلوب')
					->val('strip_tags');


				$form  ->post('content')
					->val('strip_tags',TAG);

				$form  ->post('tags')
					->val('strip_tags',TAG);

				$form  ->post('title')
					->val('is_array')
					->val('strip_tags');


				$form  ->post('code')
					->val('is_array')
					->val('strip_tags');
				$form  ->post('point')
					->val('is_array')
					->val('strip_tags');

				$form  ->post('latiniin')
					->val('is_array')
					->val('strip_tags');
				  $form  ->post('note')
					->val('is_array')
					->val('strip_tags');

				$form  ->post('serial_flag')
					->val('is_array')
					->val('strip_tags');




			     $form->post('is_service')
                    ->val('strip_tags');
				$form  ->post('enter_serial')
					->val('is_array')
					->val('strip_tags');

				$form  ->post('change_price')
					->val('is_array')
					->val('strip_tags');

				$form->post('serial')
					->val('is_array')
					->val('strip_tags');

				$form->post('tags')
					->val('is_array')
					->val('strip_tags');

				$form->post('locationTag')
					->val('is_array')
					->val('strip_tags');


				$form->post('cover_material')
					->val('is_array')
					->val('strip_tags');


				$form->post('type_cover')
					->val('is_array')
					->val('strip_tags');



				$form->post('feature_cover')
					->val('is_array')
					->val('strip_tags');




				$form ->submit();
				$data =$form -> fetch();

				$file=new Files();

				$data['userId']=$this->userid;

				$title=json_decode($data['title'],true);
				$code=json_decode($data['code'],true);
				$point=json_decode($data['point'],true);
				$latiniin=json_decode($data['latiniin'],true);
             	$note=json_decode($data['note'],true);
				$serial_flag=json_decode($data['serial_flag'],true);
				$locationTag=json_decode($data['locationTag'],true);
				$enter_serial=json_decode($data['enter_serial'],true);
				$change_price=json_decode($data['change_price'],true);
				$serial=json_decode($data['serial'],true);
				$tags=json_decode($data['tags'],true);
				$cover_material=json_decode($data['cover_material'],true);
				$type_cover=json_decode($data['type_cover'],true);
				$feature_cover=json_decode($data['feature_cover'],true);


				$image=array();
				if (empty($this->check_file($_FILES['image'], 'صور مطلوبة', array('jpg', 'jpeg', 'png')))) {
					$image = $this->save_file($_FILES['image']);
				} else {
					$this->error_form['image'] = $this->check_file($_FILES['image'], 'صور مطلوبة', array('jpg', 'jpeg', 'png'));
				}

				foreach ($code as $key => $save_data)
				{

                    $cover_material_value='';
				    if (isset($cover_material[$key]))
                    {
                        $cover_material_value=$cover_material[$key];
                    }

                     $type_cover_value='';
				    if (isset($type_cover[$key]))
                    {
                        $type_cover_value=$type_cover[$key];
                    }

                    $featureCover='';
				    if (isset($feature_cover[$key]))
                    {
                        $featureCover=implode(',',$feature_cover[$key]);
                    }



                    $stmt_c=$this->db->prepare("INSERT INTO `product_savers` (`code`,`point`,`latiniin`,`img`,`title`,`content`,`id_device`,`userId`,`serial_flag`,`locationTag`,`enter_serial`,`change_price`,`serial`,`tags`,`date`,`cover_material`,`type_cover`,`feature_cover`,`note`,`is_service`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
					$stmt_c->execute(array($save_data,$point[$key],$latiniin[$key],$image[$key],$title[$key],$data['content'],$data['devise'],$data['userId'],$serial_flag[$key], $locationTag[$key], $enter_serial[$key], $change_price[$key],$serial[$key],$tags[$key], time(),$cover_material_value, $type_cover_value,$featureCover,$note,$data['is_service']));
					$lastId=$this->db->lastInsertId();

					$trace=new trace_site();
					$newData=$trace->neaw($lastId,$this->folder);
					$trace->add($lastId,$this->folder,'add','',$data['title'],'',$newData);
                	$this->Add_to_sync_schedule($lastId,$this->folder,'add_savers');

				}

                if ($all){
                    $this->lightRedirect(url . "/savers/all_cover", 0);

                }else
                {
                    $this->lightRedirect(url . "/savers/open_savers/{$data['devise']}", 0);

                }

			}

			catch (Exception $e)
			{
				$data =$form -> fetch();
				$this->error_form=$e -> getMessage();
			}

		}



		require ($this->render($this->folder,'product','add','php'));
		$this->adminFooterController();

	}





	function edit_product_savers($id,$all=null)
	{


		if (!is_numeric($id)) { $error = new Errors(); $error->index();}
		$this->checkPermit('save_edit',$this->folder);


		$stmt = $this->db->prepare("SELECT * from `{$this->product_savers}` WHERE `id`= ?  AND {$this->is_delete}  LIMIT 1 ");
		$stmt->execute(array($id));
		$result=$stmt->fetch(PDO::FETCH_ASSOC);


        $stmt = $this->db->prepare("SELECT * from `{$this->category}` WHERE `active` = 1  AND {$this->is_delete} ");
        $stmt->execute(array());
        $category=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row;
        }

		$this->adminHeaderController($result['title']);




        $stmtcover_material = $this->db->prepare("SELECT * from `cover_material`   ");
        $stmtcover_material->execute(array());
        $cover_material=array();
        while ($row = $stmtcover_material->fetch(PDO::FETCH_ASSOC))
        {
            $cover_material[]=$row;
        }

        $stmttype_cover = $this->db->prepare("SELECT * from `type_cover`   ");
        $stmttype_cover->execute(array());
        $type_cover=array();
        while ($row = $stmttype_cover->fetch(PDO::FETCH_ASSOC))
        {
            $type_cover[]=$row;
        }


        $stmtfeature_cover = $this->db->prepare("SELECT * from `feature_cover`   ");
        $stmtfeature_cover->execute(array());
        $feature_cover=array();
        while ($row = $stmtfeature_cover->fetch(PDO::FETCH_ASSOC))
        {
            $feature_cover[]=$row;
        }






        if (isset($_POST['submit']))
		{


			$trace=new trace_site();
			$oldData=$trace->old($id,$this->folder);


			try
			{
				$form =new Form();

                $form  ->post('id_device')
                    ->val('strip_tags',TAG);

				$form  ->post('content')
					->val('strip_tags',TAG);

				$form  ->post('title')
					->val('is_array')
					->val('strip_tags');


				$form  ->post('code')
					->val('is_empty','مطلوب')
					->val('strip_tags');



				$form  ->post('point')

					->val('strip_tags');



				$form  ->post('latiniin')
					->val('is_empty','مطلوب')
					->val('strip_tags');

				  $form  ->post('note')
					->val('strip_tags');
				$form  ->post('serial_flag')
					->val('strip_tags');

				$form  ->post('change_price')
					->val('strip_tags');


				$form  ->post('locationTag')
					->val('strip_tags');

				 $form->post('is_service')
                    ->val('strip_tags');
				$form  ->post('enter_serial')
					->val('strip_tags');

				$form->post('serial')
					->val('strip_tags');

				$form->post('tags')
					->val('strip_tags');

                $form->post('cover_material')
                    ->val('strip_tags');

                $form->post('type_cover')
                    ->val('strip_tags');


                $form->post('feature_cover')
                    ->val('is_array')
                    ->val('strip_tags');






                $form ->submit();
				$data =$form -> fetch();

				$image=array();
				if ($_FILES['image']['error'][0]==0)
				{
					if (empty($this->check_file($_FILES['image'], 'صور مطلوبة', array('jpg', 'jpeg', 'png')))) {
						$image = $this->save_file($_FILES['image']);
						$data['img']=$image[0];
					}
				}else{
					$data['img']=$result['img'];
				}
                $feature_cover=implode(',',json_decode($data['feature_cover'],true));

				$stmt=$this->db->prepare("UPDATE `product_savers` SET `title`=?,`content`=?,`code`=?,`note`=?,`point`=?,`img`=?,`latiniin`=?,`serial_flag`=?,`locationTag`=?,`enter_serial`=?,`serial`=?,`tags`=?,`change_price`=?,`userId`=? ,id_device=?,cover_material=?,type_cover=?,feature_cover=?,`is_service`=? WHERE `id`=?");
				$stmt->execute(array($data['title'],$data['content'],$data['code'],$data['note'],$data['point'],$data['img'],$data['latiniin'],$data['serial_flag'],$data['locationTag'],$data['enter_serial'],$data['serial'],$data['tags'],$data['change_price'],$this->userid,$data['id_device'],$data['cover_material'],$data['type_cover'],$feature_cover,$data['is_service'],$id));


				$trace=new trace_site();
				$newData=$trace->neaw($id,$this->folder);
				$trace->add($id,$this->folder,'edit',$result['title'],$data['title'],$oldData,$newData);
				$this->Add_to_sync_schedule($id,$this->folder,'add_savers');

				if ($all){
                    $this->lightRedirect(url . "/savers/all_cover", 0);

                }else
                {
                    $this->lightRedirect(url . "/savers/open_savers/{$data['id_device']}", 0);

                }

			}
			catch (Exception $e)
			{
				$this->error_form= $e -> getMessage();
			}
		}
		require ($this->render($this->folder,'product','edit','php'));
		$this->adminFooterController();
	}



	public function processing_open_savers($id=null,$type='all')
	{


		$table = $this->product_savers;
		$primaryKey = 'product_savers.id';

		$columns = array(


			array('db' => 'product_savers.title', 'dt' => 0),
			array('db' => 'product_savers.code', 'dt' => 1),
			array('db' => 'excel_savers.quantity', 'dt' => 2),
			array('db' => 'product_savers.latiniin', 'dt' => 3),
			array('db' => 'product_savers.group_name', 'dt' => 4),
			array('db' => 'type_device.title', 'dt' => 5),
			array('db' => 'product_savers.date', 'dt' => 6,
				'formatter' => function ($d, $row) {
					return date('Y-m-d h:s:i a', $d);
				}

			),
			array('db' => 'product_savers.img', 'dt' => 7,
				'formatter' => function ($d, $row) {
					if ($d)
					{
						return "<img width=150 src='".$this->save_file.$d."' >";
					}else{
						return 'لاتوجد صورة';
					}

				}

			),
			array(
				'db' => 'product_savers.id',
				'dt' =>8 ,
				'formatter' => function ($id, $row) {
					if ($this->permit('visible',$this->folder)) {
						return "
                <div style='text-align: center'>
                  <input {$this->ch_product_savers($id)} class='toggle-demo' onchange='visible_savers(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
					else
					{
						return $this->langControl('forbidden');
					}
				}
			),

			array(
				'db' => 'product_savers.id',
				'dt' => 9,
				'formatter' => function ($id, $row) {
					return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/savers/edit_product_savers/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
				}
			),

            array( 'db' => 'product_savers.id', 'dt' => 10,
                'formatter' => function ($id, $row) {
                    if ($this->permit('copy_row', $this->folder)) {
                        return '
                   <button class="btn btn-warning btn-sm " onclick="copy_row('.$id.')"  type="button"  >  <i class="fa fa-clone"></i> <span>تكرار</span>  </button>

                ';
                    } else {
                        return $this->langControl('forbidden');
                    }

                }
            ),


            array(
				'db' => 'product_savers.id',
				'dt' => 11,
				'formatter' => function ($id, $row) {
					if ($this->permit('delete',$this->folder)) {
						return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
					else
					{
						return $this->langControl('forbidden');
					}
				}
			),
			array('db' => 'product_savers.id', 'dt' => 12)


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);


        $join = "INNER JOIN type_device ON type_device.id =product_savers.id_device  LEFT JOIN excel_savers ON product_savers.code = excel_savers.code ";

        if ($type=='all')
        {

            $whereAll=array("product_savers.id_device='{$id}' "," product_savers.id_device <> 0 and product_savers.is_delete = 0");
//            echo json_encode(
//            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
//                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"id_device='{$id}' AND id_device <> 0")
//
//            );
        }else
        {
             $type="'%{$type}%'";
            $whereAll=array("product_savers.id_device='{$id}' "," product_savers.id_device <> 0"," latiniin LIKE  {$type} ");

//            echo json_encode(
//            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
//                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "id_device='{$id}' AND id_device <> 0 AND ( latiniin LIKE '%fm%' OR latiniin LIKE  {$type} ) ")
//            );

        }

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));

    }


    function copy_row($id)
    {

        $stmt=$this->db->prepare("INSERT  INTO  product_savers ( color, code_color, img, id_product, date,  title, content, latiniin, symbol, bast_it, view, cuts, price_cuts, id_device, serial_flag, location, enter_serial, locationTag, serial, change_price, cover_material, type_cover, feature_cover, note, price_dollars, tags, rare_cover, group_name, point, is_delete,userId,active)   SELECT   color, code_color, img, id_product, date,  title, content, latiniin, symbol, bast_it, view, cuts, price_cuts, id_device, serial_flag, location, enter_serial, locationTag, serial, change_price, cover_material, type_cover, feature_cover, note, price_dollars, tags, rare_cover, group_name, point, is_delete,$this->userid,0 FROM  product_savers  WHERE id=?");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            echo  $this->db->lastInsertId();
        }
    }


	public function ch_product_savers($id)
	{


		$stmt = $this->db->prepare("SELECT * FROM {$this->product_savers} WHERE `id` = ? AND `active` = 1  AND {$this->is_delete} ");
		$stmt->execute(array($id));
		if ($stmt->rowCount() > 0) {
			return 'checked';
		} else {
			return '';
		}
	}


	function delete_savers_product_savers($id)
	{
		if ($this->handleLogin() ) {



			$stmt=$this->db->prepare("SELECT  *FROM `product_savers` WHERE `id`  = ?   " );
			$stmt->execute(array($id));
			$result=$stmt->fetch(PDO::FETCH_ASSOC);

        	$code = strval($result['code']);
        	$this->Add_to_sync_schedule($id,'product_savers','delete_savers', $code);

			$trace=new trace_site();
			$oldData=$trace->old($id,$this->folder);

			$trace->add($id,$this->folder,'delete',$result['title'],$result['title'],$oldData,'');

			$this->update_is_delete('product_savers', 'id = '.$id.'');

			$this->update_code('product_savers', $code,$id);
			// $cd = $this->db->prepare("DELETE FROM `$this->product_savers`  WHERE  `id`=?");
			// $cd->execute(array($id));




		}
	}



	public function visible_savers_product_savers($v_, $id_)
	{
		if ($this->handleLogin()) {
			if (is_numeric($v_) && is_numeric($id_)) {
				$v = $v_;
				$id = $id_;
			} else {
				$v = 0;
				$id = 0;
			}

			$stmt=$this->db->prepare("SELECT  *FROM `product_savers` WHERE `id`  = ?   AND {$this->is_delete}" );
			$stmt->execute(array($id));
			$result=$stmt->fetch(PDO::FETCH_ASSOC);

			$trace=new trace_site();
			$oldData=$trace->old($id,$this->folder);

			$data = $this->db->update($this->product_savers, array('active' => $v), "`id`={$id}");

			$newData=$trace->neaw($id,$this->folder);
			$trace->add($id,$this->folder,'active',$result['title'],$result['title'],$oldData,$newData);


		}

	}



	function quantity()
	{

		$this->checkPermit('export_excel', $this->folder);
		$this->adminHeaderController($this->langControl($this->folder).' '.date('Y-m-d',time()));


        $category = $this->db->select("SELECT * from `{$this->category}`  WHERE {$this->is_delete}");

        $cat='all';
        $name_device='';
        $device='';
        $from_price=null;
        $to_price=null;

        if (isset($_GET['cat']))
        {
            $cat=$_GET['cat'];
        }

        if (isset($_GET['name_device']))
        {
            $name_device=$_GET['name_device'];
        }

        if (isset($_GET['device']))
        {
            $device=$_GET['device'];
        }

        if (isset($_GET['from_price']))
        {
            $from_price=$_GET['from_price'];
        }

        if (isset($_GET['to_price']))
        {
            $to_price=$_GET['to_price'];
        }






        require($this->render($this->folder, 'quantity', 'index', 'php'));
		$this->adminFooterController();
	}

//  manar
	public function processing_quantity()
	{
		$this->checkPermit('view_quantity', $this->folder);
		$table = 'product_savers';
		$primaryKey = $table . '.id';
		$tableJoin = $table . '.';

		$columns = array(

			array('db' => 'type_device.title', 'dt' =>0),
			array('db' => 'product_savers.title', 'dt' =>1),
            array('db' => 'product_savers.group_name', 'dt' => 2),
			array('db' => $tableJoin . 'code', 'dt' => 3),
            array('db' => 'product_savers.date', 'dt' => 4,
            'formatter' => function ($d, $row) {
                return date('Y-m-d h:i:s', $d);
                }
            ),
			array('db' => 'excel_savers.quantity', 'dt' => 5),
			array('db' => 'excel_savers.price_dollars', 'dt' => 6),

            array('db' =>'product_savers.locationTag', 'dt' => 7,
                'formatter' => function( $d, $row ) {
                    if ($d == 1) {
                        $span = "<span class='location_active_{$row[12]}' style='color: green;font-weight: bold;display: block'>ON</span>";
                    } else {
                        $span = "<span class='location_active_{$row[12]}' style='color: red;font-weight: bold;display: block'>OFF</span>";

                    }
                    if ($this->permit('visible_location', $this->folder)) {
                        $span .= "
                            <div style='text-align: center'>
                              <input {$this->ch_location($row[12])} class='toggle-demo' onchange='visible_savers_location(this,$row[12])' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                             </div>
                         ";
                    }

                    return $span;
                }
            ),


            array('db' =>'product_savers.img', 'dt' =>8,
				'formatter' => function( $d, $row ) {
					return "<img  src='".$this->save_file.$d."' style='width: 50px;border: 1px solid gainsboro;'>";
				}
			),

            array('db' => 'product_savers.userId', 'dt' => 9,
                'formatter' => function ($user, $row) {
                    return $this->UserInfo($user);
                }
            ),
            array('db' => 'product_savers.date', 'dt' => 10,
                'formatter' => function( $d, $row ) {
                                     return  date('Y-m-d h:i:s A',$d) ;
                }),

            array('db' => 'product_savers.code', 'dt' => 11,
                'formatter' => function( $d, $row ) {
                    $m="'{$this->folder}'";;

                    return '
                   <button class="btn btn-primary btn_location" onclick="list_location('.$d.','.$m.')"  type="button" data-toggle="collapse" data-target="#get_location-'.$d.'" aria-expanded="false" aria-controls="get_location'.$d.'">المواقع</button>
                   <div class="collapse multi-collapse" id="get_location-'.$d.'">
                      <div style="padding: 5px;margin:0" class="card card-body" id="data_location_'.$d.'">
                   </div>
                </div>
                ';
                }),
            array('db' => 'product_savers.id', 'dt' => 12),

		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);

               if ( $_GET['cat']  =='all' && empty($_GET['name_device'])  && empty($_GET['device'])   && empty($_GET['from_price']) && empty($_GET['to_price']) )
        {
            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device    LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''","product_savers.is_delete =0");

        }else    if ( $_GET['cat']  =='all' && empty($_GET['name_device'])  && empty($_GET['device'])   && !empty($_GET['from_price']) && !empty($_GET['to_price']) )
        {
            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device    LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''","excel_savers.price_dollars BETWEEN {$_GET['from_price']} AND {$_GET['to_price']}","product_savers.is_delete =0");

        }else  if ( is_numeric($_GET['cat'])   && empty($_GET['name_device'])  && empty($_GET['device'])   && empty($_GET['from_price']) && empty($_GET['to_price']) )
        {
            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device   INNER JOIN category_savers ON category_savers.id=name_device.id_cat   LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''","category_savers.id={$_GET['cat']}","product_savers.is_delete =0");

        }else   if ( is_numeric($_GET['cat'])   && empty($_GET['name_device'])  && empty($_GET['device'])   && !empty($_GET['from_price']) && !empty($_GET['to_price']) )
        {

            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device   INNER JOIN category_savers ON category_savers.id=name_device.id_cat   LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''","category_savers.id={$_GET['cat']}","excel_savers.price_dollars BETWEEN {$_GET['from_price']} AND {$_GET['to_price']}","product_savers.is_delete =0");


        } else   if ( is_numeric($_GET['cat'])   && !empty($_GET['name_device'])  && empty($_GET['device'])   && empty($_GET['from_price']) && empty($_GET['to_price']) )
        {

            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device   INNER JOIN category_savers ON category_savers.id=name_device.id_cat   LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''","category_savers.id={$_GET['cat']}","name_device.id={$_GET['name_device']}","product_savers.is_delete =0");
          }

         else   if ( is_numeric($_GET['cat'])   && !empty($_GET['name_device'])  && empty($_GET['device'])   && !empty($_GET['from_price']) && !empty($_GET['to_price']) )
        {

            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device   INNER JOIN category_savers ON category_savers.id=name_device.id_cat   LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''","category_savers.id={$_GET['cat']}","name_device.id={$_GET['name_device']}","excel_savers.price_dollars BETWEEN {$_GET['from_price']} AND {$_GET['to_price']}","product_savers.is_delete =0");
          }

         else   if ( is_numeric($_GET['cat'])   && !empty($_GET['name_device'])  && !empty($_GET['device'])   && empty($_GET['from_price']) && empty($_GET['to_price']) )
        {

            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device   INNER JOIN category_savers ON category_savers.id=name_device.id_cat   LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''","category_savers.id={$_GET['cat']}","name_device.id={$_GET['name_device']}","product_savers.id_device={$_GET['device']}","product_savers.is_delete =0");
          }

         else   if ( is_numeric($_GET['cat'])   && !empty($_GET['name_device'])  && !empty($_GET['device'])   && !empty($_GET['from_price']) && !empty($_GET['to_price']) )
        {

            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device   INNER JOIN category_savers ON category_savers.id=name_device.id_cat   LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''","category_savers.id={$_GET['cat']}","name_device.id={$_GET['name_device']}","product_savers.id_device={$_GET['device']}","excel_savers.price_dollars BETWEEN {$_GET['from_price']} AND {$_GET['to_price']}","product_savers.is_delete =0");
          }

        echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null));

	}





    function list_location ($code,$model)
    {


        $stmt  = $this->db->prepare("SELECT    location,quantity  FROM location  WHERE code=? AND  model=?  ");
        $stmt ->execute(array($code,$model));

        $html = "<table class='table_location'>";
        if ($stmt->rowCount() > 0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $html .= "<tr> <td>{$this->tamayaz_locations($row['location'])}<td><span class='badge badge-pill badge-success'>{$row['quantity']} </span></td> </tr>    ";
            }
        }else
        {
            $html .= "</tr><td> لا يوجد مواقع</td></tr>";
        }
        $html .="</table>";
        echo $html;
    }




    public function ch_location($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM `product_savers` WHERE `id` = ? AND `locationTag` = 1  AND {$this->is_delete}");
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



    public function visible_savers_location($v_,$id_)
    {

        if ($this->handleLogin()) {
            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }

            $stmt=$this->db->prepare("SELECT  *FROM `{$this->product_savers}` WHERE `id`  = ?    AND {$this->is_delete}" );
            $stmt->execute(array($id));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);

            $trace=new trace_site();
            $oldData=$trace->old($id,$this->folder);

            $data = $this->db->update($this->product_savers, array('locationTag' => $v), "`id`={$id}");

            $newData=$trace->neaw($id,$this->folder);
            $trace->add($id,$this->product_savers,'active',$result['title'],$result['title'],$oldData,$newData);
            echo $v;
        }
    }





    function  unknown()
	{
		$this->checkPermit('unknown',$this->folder);
		$this->adminHeaderController($this->langControl('add'));

		$stmt = $this->db->prepare("SELECT * from `{$this->category}`  WHERE {$this->is_delete} ");
		$stmt->execute(array());
		$category=array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$category[]=$row;
		}


		if(isset($_POST["submit"])) {


			try {
				$form = new  Form();

				$form->post('cat')
					->val('is_empty', 'مطلوب')
					->val('strip_tags');

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

					for ($row = 1; $row <= $highestRow; $row++) {
						//  Read a row of data into an array
						$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
							FALSE,
							TRUE,
							TRUE);


						if (count($rowData[0])  >= 4  ) {



                            $point='';
                            if (isset($rowData[0][4]))
                            {
                                $point =$rowData[0][4];
                            }



                            $stmt = $this->db->prepare("SELECT * FROM  product_savers  WHERE `code`=?   AND {$this->is_delete}");
							$stmt->execute(array(trim($rowData[0][1])));
							if ($stmt->rowCount() <= 0) {

                                $stmt_in_m = $this->db->prepare("INSERT INTO product_savers  (`id_device`,`title`,`code`,`latiniin`,`group_name`,`img`,`active`,`date`,`userid`,`point`) VALUES(?,?,?,?,?,?,?,?,?,?)");
                                $stmt_in_m->execute(array($data['cat'], $rowData[0][0], $rowData[0][1], $rowData[0][2], $rowData[0][3], 'alixcol' . $this->uuid(55) . '.png', 1, time() + 1,$this->userid,$point));

                                $idm=$this->db->lastInsertId('product_savers');

                                $trace=new trace_site();
                                $newData=$trace->neaw($idm,$this->folder);
                                $trace->add($idm,$this->folder,'رفع سريع','',$rowData[0][0],'',$newData);



                            }
						} else {
							$this->error_form = json_encode(array('files_normal' => 'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
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
					$this->lightRedirect(url.'/'.$this->folder."/open_savers/".$data['cat']);

				}


			} catch (Exception $e) {
				$data =$form -> fetch();
				$this->error_form=$e -> getMessage();

			}


		}

		require ($this->render($this->folder,'html','unknown','php'));
		$this->adminFooterController();
	}




	function  unknown2()
	{
		$this->checkPermit('unknown',$this->folder);
		$this->adminHeaderController($this->langControl('add'));

		$stmt = $this->db->prepare("SELECT * from `{$this->category}`   WHERE {$this->is_delete} ");
		$stmt->execute(array());
		$category=array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$category[]=$row;
		}


		if(isset($_POST["submit"])) {


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

					for ($row = 1; $row <= $highestRow; $row++) {
						//  Read a row of data into an array
						$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
							FALSE,
							TRUE,
							TRUE);


						if (count($rowData[0])  >= 7  ) {




							$stmttd = $this->db->prepare('SELECT type_device.id FROM type_device INNER JOIN name_device ON name_device.id=type_device.id_device INNER JOIN category_savers ON category_savers.id =name_device.id_cat WHERE type_device.title = ? AND name_device.title=? AND category_savers.title =? LIMIT 1');
							$stmttd->execute(array($rowData[0][4],$rowData[0][5],$rowData[0][6]));
							if ($stmttd->rowCount() > 0) {

							    $result=$stmttd->fetch(PDO::FETCH_ASSOC);

                                $stmt = $this->db->prepare("SELECT * FROM  product_savers  WHERE `code`=? AND `id_device`=?  AND {$this->is_delete}");
                                $stmt->execute(array($rowData[0][0], $result['id']));
                                if ($stmt->rowCount() > 0) {
                                    continue;
                                }

                                $stmt_in_m = $this->db->prepare("INSERT INTO product_savers  (`id_device`,`code`,`title`,`color`,`latiniin`,`img`,`active`,`date`) VALUES(?,?,?,?,?,?,?,?)");
                                $stmt_in_m->execute(array( $result['id'], $rowData[0][0], $rowData[0][1], $rowData[0][2], $rowData[0][3], 'alixcol' . $this->uuid(55) . '.png', 1, time() + 1));

                            }

						} else {
							$this->error_form = json_encode(array('files_normal' => 'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
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
					$this->lightRedirect(url.'/'.$this->folder."/open_savers");

				}


			} catch (Exception $e) {
				$data =$form -> fetch();
				$this->error_form=$e -> getMessage();

			}


		}

		require ($this->render($this->folder,'html','unknown2','php'));
		$this->adminFooterController();
	}




    public function list_saver_connect($id)
    {

        $this->checkPermit('list_saver_connect', 'savers');
        $this->adminHeaderController($this->langControl('list_saver_connect'));

        $stmt = $this->db->prepare("SELECT `title` FROM `category_savers` WHERE  `id`=?  AND {$this->is_delete} ");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        require($this->render($this->folder, 'connect', 'index', 'php'));
        $this->adminFooterController();

    }



    public function processing_connect($id)
    {


        $table = $this->product_savers_connect;
        $primaryKey = 'product_savers_connect.id';

        $columns = array(


            array('db' => 'product_savers_connect.title', 'dt' => 0),

            array(
                'db' => 'product_savers_connect.id',
                'dt' => 1,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible',$this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_connect($id)} class='toggle-demo' onchange='visible_savers_connect(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),


            array('db' => 'product_savers_connect.date', 'dt' =>2,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d ', $d);
                }

            ),
            array(
                'db' => 'product_savers_connect.id',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    if ($this->permit('edit_product_savers_connect',$this->folder)) {
                        return "
                        <div style='text-align: center'>
                            <a href=".url."/savers/edit_savers_connect/$id>
                                <i class='fa fa-edit' aria-hidden='true'></i>
                            </a>
                        </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),

            array(
                'db' => 'product_savers_connect.id',
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_product_savers_connect',$this->folder)) {
                        return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => 'user.username', 'dt' => 5),
            array('db' => 'product_savers_connect.id', 'dt' => 6)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


            $join = " inner JOIN user ON user.id = product_savers_connect.userid  ";
            $whereAll = array("product_savers_connect.id_cat={$id}");

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null ));




    }

    function edit_savers_connect($id=null)
    {
        $this->checkPermit('edit_savers_connect', $this->folder);
        $this->adminHeaderController($this->langControl('list_saver_connect'));

        $stmt = $this->db->prepare("SELECT `title`,ids FROM `product_savers_connect` WHERE id = ?  ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $dev = $stmt->fetch(PDO::FETCH_ASSOC);
            $title = explode(' // ',$dev['title']);
            $ids = explode(',',$dev['ids']);
        }


        if (isset($_POST['submit']))
        {
            try
            {
                $form =new  Form();



                $form  ->post('ids')
                    ->val('is_array')
                    ->val('strip_tags');


                $form ->submit();
                $data =$form -> fetch();
                $data['date']=time();

                $data['userid']=$this->userid;


                $ids= json_decode($data['ids'], true);

                if (!empty($ids)) {

                    $title = array();
                    foreach ($ids as $d) {

                        $stmt = $this->db->prepare("SELECT `title` FROM `type_device` WHERE  `id`=? AND {$this->is_delete} ");
                        $stmt->execute(array($d));
                        $dev = $stmt->fetch(PDO::FETCH_ASSOC);
                        $title[] = $dev['title'];

                    }


                    $data['id_cat'] =  $id;
                    $data['title'] = implode(' // ', $title);
                    $data['ids'] = implode(',', $ids);

                    $where = "id = ".$id ;
                    $id_add=$this->db->update($this->product_savers_connect,$data,$where);

                    }
               $this->lightRedirect(url.'/'.$this->folder."/list_saver_connect/{$id}",0);


            }
            catch (Exception $e)
            {
                $data =$form -> fetch();

                $this->error_form= $e -> getMessage();
            }
        }
        require($this->render($this->folder, 'connect', 'edit', 'php'));
        $this->adminFooterController();
    }

    public function ch_connect($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->product_savers_connect} WHERE `id` = ? AND `active` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }

    public function visible_savers_connect($v_, $id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }
        $data = $this->db->update($this->product_savers_connect, array('active' => $v), "`id`={$id}");
    }

    public function add_connect_device($id)
    {


        $this->checkPermit('add_connect_device', 'savers');
        $this->adminHeaderController($this->langControl('add_connect_device'));

        $stmt = $this->db->prepare("SELECT `title` FROM `category_savers` WHERE  `id`=?  AND {$this->is_delete} ");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);



        if (isset($_POST['submit']))
        {
            try
            {
                $form =new  Form();



                $form  ->post('ids')
                    ->val('is_array')
                    ->val('strip_tags');


                $form ->submit();
                $data =$form -> fetch();
                $data['date']=time();

                $data['userid']=$this->userid;


                $ids= json_decode($data['ids'], true);

                if (!empty($ids)) {

                    $title = array();
                    foreach ($ids as $d) {

                        $stmt = $this->db->prepare("SELECT `title` FROM `type_device` WHERE  `id`=?  AND {$this->is_delete}");
                        $stmt->execute(array($d));
                        $dev = $stmt->fetch(PDO::FETCH_ASSOC);
                        $title[] = $dev['title'];

                    }


                    $data['id_cat'] =  $id;
                    $data['title'] = implode(' // ', $title);
                    $data['ids'] = implode(',', $ids);


                      $id_add=$this->db->insert($this->product_savers_connect,$data);

                    }
               $this->lightRedirect(url.'/'.$this->folder."/list_saver_connect/{$id}",0);


            }
            catch (Exception $e)
            {
                $data =$form -> fetch();

                $this->error_form= $e -> getMessage();
            }

        }

        require($this->render($this->folder, 'connect', 'add', 'php'));
        $this->adminFooterController();

    }


    function search($id)
    {
        if ($this->handleLogin()) {
            $data = $_GET['q'];
            $data = '%' . $data . '%';
            $stmt = $this->db->prepare("SELECT * FROM `type_device`  WHERE   {$this->is_delete} AND type_device.title LIKE ?   ");
            $stmt->execute(array($data));

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div  id='c_{$row['id']}' class='dropdownCustomer'> <button type='button' class='btn' onclick=add_c({$row["id"]}) >   <i class='fa fa-plus-circle'></i> </button>  " . $row['title'] . "  </div>";
                }
            } else
            {
                echo "لا يوجد";
            }
        }
    }

    function savers_info($id)
    {
        if ($this->handleLogin()) {
            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }

            $stmt = $this->db->prepare("SELECT `title` FROM `type_device` WHERE  `id`=?  AND {$this->is_delete} ");
            $stmt->execute(array($id));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo $result['title'];
        }
    }

    function  type_cover()
    {
        $this->checkPermit('type_cover',$this->folder);
        $this->adminHeaderController($this->langControl('type_cover'));

        if(isset($_POST["submit"])) {


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

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                            NULL,
                            TRUE,
                            TRUE);


                        if (count($rowData[0])  >= 2)
                        {


                                $stmtcode = $this->db->prepare("UPDATE  product_savers SET  `latiniin`=  ?   WHERE  code=?");
                                $stmtcode->execute(array($rowData[0][1],$rowData[0][0]));


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
                    $this->lightRedirect(url.'/'.$this->folder."/open_savers");

                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'html','type_cover','php'));
        $this->adminFooterController();
    }


    function all_cover()
    {
        $this->checkPermit('all_cover', $this->folder);

        $this->adminHeaderController($this->langControl('all_cover'));





        require($this->render($this->folder, 'html', 'all_cover', 'php'));
        $this->adminFooterController();




    }


    public function processing_all_cover()
    {


        $table = $this->product_savers;
        $primaryKey =  $table.'.id';

        $columns = array(

            array('db' => 'category_savers.title', 'dt' => 0),
            array('db' => $table.'.title', 'dt' => 1),
            array('db' =>  $table.'.code', 'dt' => 2),
            array('db' => 'excel_savers.quantity', 'dt' => 3),
            array('db' =>  $table.'.latiniin', 'dt' => 4),
            array('db' =>  $table.'.date', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:s:i a', $d);
                }

            ),
            array('db' =>  $table.'.img', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    if ($d)
                    {
                        return "<img width=140 src='".$this->save_file.$d."' >";
                    }else{
                        return 'لاتوجد صورة';
                    }

                }

            ),
            array(
                'db' =>  $table.'.id',
                'dt' =>7 ,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible',$this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_product_savers($id)} class='toggle-demo' onchange='visible_savers(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),

            array(
                'db' =>  $table.'.id',
                'dt' => 8,
                'formatter' => function ($id, $row) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/savers/edit_product_savers/{$id}/all> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db' =>  $table.'.id',
                'dt' => 9,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[1]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' =>  $table.'.id', 'dt' => 10)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device    INNER JOIN category_savers ON category_savers.id=name_device.id_cat   LEFT JOIN excel_savers ON excel_savers.code = product_savers.code ";
        $whereAll = array("product_savers.code <> ''  and product_savers.is_delete=0");


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));


    }
function x()
{


    for ($i=1;$i<=6810;$i++){

        $stmt=$this->db->prepare("INSERT INTO cover_code (code) values ('')");
        $stmt->execute();
        if ($stmt->rowCount() > 0)
        {
            echo $i.'<br>';
        }


    }

}

    function check_code()
    {

        if($this->handleLogin())
        {
            $code=trim($_GET['code']);
            $stmt=$this->db->prepare("SELECT *FROM {$this->product_savers} WHERE code =? AND {$this->is_delete}  ");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0)
            {
                echo '1';
            }else
            {
                echo '0';
            }

        }
    }




    public function list_cover_material()
    {

        $this->checkPermit('cover_material', 'savers');
        $this->adminHeaderController($this->langControl('cover_material'));

        require($this->render($this->folder, 'cover_material', 'html/list', 'php'));
        $this->adminFooterController();

    }

    public function add_cover_material()
    {


        $this->checkPermit('add_cover_material', 'savers');
        $this->adminHeaderController($this->langControl('add_cover_material'));

        $category = $this->db->select("SELECT * from `{$this->table}` WHERE {$this->is_delete}  ");


        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();



                $form->post('cover_material')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('number')
                    ->val('is_array')
                    ->val('strip_tags');



                $form->submit();
                $data = $form->fetch();
                $data['date'] = time();
                $data['userid'] = $this->userid;


                $cover_material = json_decode($data['cover_material'], true);
                $number = json_decode($data['number'], true);



                foreach ($cover_material as $key => $save_data) {
                    $stmt_c = $this->db->prepare("INSERT INTO `{$this->cover_material}` (`cover_material`,`number`,`userid`,`date`) VALUE (?,?,?,?)");
                    $stmt_c->execute(array($save_data,$number[$key],$this->userid, time()));

                }

                $this->lightRedirect(url . "/savers/list_cover_material", 0);

            } catch (Exception $e) {
                $data = $form->fetch();
                $data['date'] = strtotime($data['date']);
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }

        require($this->render($this->folder, 'cover_material', 'html/add', 'php'));
        $this->adminFooterController();

    }



    public function edit_cover_material($id)
    {
        $this->checkPermit('edit_cover_material', 'savers');
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }

        $files = new Files();
        $this->adminHeaderController($this->langControl('edit'));

        $data = $this->db->select("SELECT * from `{$this->cover_material}` WHERE `id`=:id LIMIT 1 ", array(':id' => $id));
        $data = $data[0];


        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();


                $form->post('cover_material')
                    ->val('is_empty', ' اسم المادة مطلوب  ')
                    ->val('strip_tags');

                $form->post('number')
                    ->val('is_empty', ' رقم المادة مطلوب  ')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();


                    $this->db->update($this->cover_material, $data, "id={$id}");


                    $this->lightRedirect(url . "/savers/list_cover_material", 0);


            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }


        require($this->render($this->folder, 'cover_material', 'html/edit', 'php'));
        $this->adminFooterController();

    }

    public function processing_cover_material()
    {


        $table = $this->cover_material;
        $primaryKey = 'id';

        $columns = array(


            array('db' => 'cover_material', 'dt' => 0),
            array('db' => 'number', 'dt' =>1),
            array('db' => 'date', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d ', $d);
                }

            ),
            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($id, $row) {

                        return "
                <div style='text-align: center'>
                  <input {$this->ch_cover_material($id)} class='toggle-demo' onchange='visible_savers(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }


            ),

            array(
                'db' => 'id',
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/savers/edit_cover_material/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db' => 'id',
                'dt' => 5,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_cover_material',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => 'id', 'dt' => 6)


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
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
        );

    }


    public function ch_cover_material($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->cover_material} WHERE `id` = ? AND `active` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }
    public function visible_savers_cover_material($v_, $id_)
    {

        if ($this->handleLogin())
        {

        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }

        $data = $this->db->update($this->cover_material, array('active' => $v), "`id`={$id}");
    }

 }

    function delete_savers_cover_material($id)
    {
        if ($this->handleLogin() ) {

            $cd = $this->db->prepare("DELETE FROM `$this->cover_material`  WHERE  `id`=?");
            $cd->execute(array($id));
        }
    }


    function rprice()
    {

        if (isset($_POST['submit']))
        {
            $iditem=$_POST['idcolor'];
            $qr=$_POST['qr'];

            $stmtqr=$this->db->prepare("SELECT *FROM user WHERE hash=?");
            $stmtqr->execute(array($qr));
            if ($stmtqr->rowCount() > 0)
            {


                $stmt=$this->db->prepare("SELECT  {$this->excel}.price_dollars  FROM product_savers inner JOIN {$this->excel} ON {$this->excel}.code = product_savers.code   WHERE  product_savers.id= ? LIMIT 1");
                $stmt->execute(array($iditem));
                if ($stmt->rowCount() > 0 )
                {
                    $result=$stmt->fetch(PDO::FETCH_ASSOC);
                    echo  $this->price_dollarsAdmin($result['price_dollars']) .' د.ع ';

                } else
                {
                    echo 'unk';
                }
            }else{

                echo 'rqr';
            }

        }else
        {
            echo 'rqr';
        }



    }



    public function active()
    {

        $this->checkPermit('active_location_and_enter_serial',$this->folder);
        $this->adminHeaderController($this->langControl('active'));
        $data_cat=$this->db->select("SELECT * from  {$this->type_device} WHERE {$this->is_delete} ");
        foreach ($data_cat as $key => $d_cat)
        {

            $data_cat[$key]=$d_cat;
        }


        require ($this->render($this->folder,'html','active','php'));
        $this->adminFooterController();

    }


    public function active_pro()
    {

        $this->checkPermit('active_location_and_enter_serial',$this->folder);


        $cat=$_GET['cat'];
        $type=$_GET['type'];
        $ls=$_GET['ls'];

        if ($cat=='all')
        {
            if ($type=='location')
            {
                $stmt=$this->db->prepare("UPDATE product_savers SET locationTag=?,userId=?  ");
                $stmt->execute(array($ls,$this->userid));
            }else if ($type=='serial'){
                $stmt=$this->db->prepare("UPDATE product_savers  SET enter_serial=?,userId=?  ");
                $stmt->execute(array($ls,$this->userid));
            }

        }else
        {



            if ($type=='location')
            {
                $stmt=$this->db->prepare("UPDATE product_savers SET locationTag=? ,userId=? WHERE id_device = ?");
                $stmt->execute(array($ls,$this->userid));
            }else if ($type=='serial'){
                $stmt=$this->db->prepare("UPDATE product_savers SET enter_serial=? ,userId=?  WHERE  id_device = ?  ");
                $stmt->execute(array($ls,$this->userid));
            }

        }

        echo 1;

    }



    function quantity2()
    {

        $this->checkPermit('export_excel2', $this->folder);
        $this->adminHeaderController($this->langControl($this->folder).' '.date('Y-m-d',time()));



        require($this->render($this->folder, 'quantity', 'index2', 'php'));
        $this->adminFooterController();
    }

    public function processing_quantity2()
    {
        $this->checkPermit('view_quantity2', $this->folder);
        $table = 'product_savers';
        $primaryKey = $table . '.id';
        $tableJoin = $table . '.';

        $columns = array(

            array('db' => 'type_device.title', 'dt' => 0),
            array('db' => 'product_savers.title', 'dt' =>1),
            array('db' => $tableJoin . 'code', 'dt' => 2),
            array('db' => 'excel_savers.quantity', 'dt' => 3),
            array('db' => 'product_savers.latiniin', 'dt' => 4),
            array('db' =>'product_savers.img', 'dt' =>5,
                'formatter' => function( $d, $row ) {
                $img=null;


                if ($d)
                {
                    if (strpos(' '.$d, 'alixcol') == false ) {
                          $img='*';
                    }
                }

                    return "<div>{$img}</div><img  src='".$this->save_file.$d."' style='width: 50px;border: 1px solid gainsboro;'>";
                }
            ),
            array('db' => 'product_savers.date', 'dt' => 6,
                'formatter' => function( $d, $row ) {
                      return  date('Y-m-d h:i:s A',$d) ;;
                }),

            array('db' => 'product_savers.id', 'dt' => 7),

        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device    LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''");


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null));

    }



    /*
        function del_cover ($s=null)
        {
            if ($s) {



                $list="
    154648";

                $your_array = explode("\n", $list);

                $c=0;
                foreach ($your_array as $ya ) {

                        $stmtd = $this->db->prepare("DELETE   FROM product_savers WHERE title=? AND id_device=802");
                        $stmtd->execute(array($ya));
                        if ($stmtd->rowCount() > 0 )
                        {
                            echo $c ++;    echo '<br>';
                        }

                }
            }else{
                echo 'enter 1 for start move !';
            }
        }
    */

/*  حذف الكفرات النادرة علي الشامي 2022-2-19  */
    function xcover()
    {

        $stmt=$this->db->prepare("SELECT  product_savers.code,excel_savers.quantity FROM `product_savers`   INNER JOIN ali_cover ON ali_cover.code = product_savers.code   LEFT JOIN excel_savers ON excel_savers.code=product_savers.code WHERE  excel_savers.quantity <= 0 OR excel_savers.quantity IS NULL");
        $stmt->execute();
        $c=0;
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $stmtd=$this->db->prepare("DELETE  FROM `product_savers` WHERE code=? ");
            $stmtd->execute(array(trim($row['code'])));
            if ($stmtd->rowCount() > 0)
            {
                echo $c++;
                echo '<br>';
            }else
            {
                echo $row['code'];
                echo '<br>';
            }

        }

    }


    function fixed_location() {

        $stmt=$this->db->prepare("SELECT  code  FROM  location WHERE model='savers' AND fixed_location=0 ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

            $stmt2 = $this->db->prepare("INSERT INTO  location  (code,location,model,sequence,userid,`date`,quantity,fixed_location) values (?,?,?,?,?,?,?,?) ");
            $stmt2->execute(array(trim($row['code']),555555, 'savers', '99', $this->userid, time(),0,1));

            echo $row['code'];
        }

    }


    function  point()
    {
        $this->checkPermit('point',$this->folder);
        $this->adminHeaderController($this->langControl('point'));


        if(isset($_POST["submit"])) {


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

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                            FALSE,
                            TRUE,
                            TRUE);


                        if (count($rowData[0])  >= 2  ) {


                            $stmtc = $this->db->prepare("SELECT * FROM product_savers  WHERE  `code`=? AND {$this->is_delete} ");
                            $stmtc->execute(array(trim($rowData[0][0])));
                            if ($stmtc->rowCount() > 0) {
                                $result = $stmtc->fetch(PDO::FETCH_ASSOC);

                                $stmt_point = $this->db->prepare("UPDATE product_savers  SET  point=?   WHERE code = ?  ");
                                $stmt_point->execute(array($rowData[0][1], $rowData[0][0]));
                                if ($stmt_point->rowCount() > 0 )
                                {


                                        $trace=new trace_site();
                                        $newData=$trace->neaw($result['id'],$this->folder);
                                        $trace->add($result['id'],$this->folder,'رفع نقاط المادة','',$result['title'],'',$newData);


                                }

                            }



                        } else {
                            $this->error_form = json_encode(array('files_normal' => 'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
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
                    $this->lightRedirect(url.'/'.$this->folder."/open_savers");

                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'html','point','php'));
        $this->adminFooterController();
    }



    function del_acc_array ($s=null)
    {
        if ($s) {



            $list="156308
190245
192751
166569
169581
154370
192842
198204
169552
179738
157741
801489
14029
178044
191833
164703
139372
164935
15031
192005
164707
160160
165092
15076
191086
192995
167213
169628
154601
192994
190464
169732
189463
158007
11672
10525
178495
189639
159249
14289
10744
181016
192107
165084
163777
165848
114016
192274
193679
167815
169759
155122
193002
192904
169942
193874
161029
185447
170084
189757
161450
15115
14042
189759
192368
165087
164147
168022
137204
192311
193866
169530
177969
155556
196314
169537
178960
157322
198199
161005
198768
177145
190215
162381
137390
14134
190026
192394
165128
164861
169161
139587
192403
192560
165731
169532
143458
192840
198203
169542
179339
157645
800914
179347
177738
191701
164221
139371
14536
190216
192004
164706
157169
165089
15036
190351
192951
167070
169626
154537
192949
206413
169731
189326
157977
11663596
192224
178260
14044
10720
179394
192083
164934
162088
165668
18323
192109
193673
167743
169677
155014
192998
801081
169877
189467
159217
156360
185446
170083
189705
161382
15094
10860
189755
192364
165086
163836
167473
137086
192306
193855
168128
173204
155479
193027
194243
169535
178067
157259
196317
156299
193398
173723
190176
162248
114010
14126
189763
192389
165127
164424
169113
139375
192402
169529
142890
192484
198195
169541
179322
157624
208355
138153
177472
190335
163847
137501
14288
190170
192450
165726
165069
15034
190350
192754
166570
169586
154502
192853
198210
169730
189262
157747
11663595
202431
178247
191925
164705
157095
10635
178700
192008
164708
161826
165542
15097
191831
193439
167474
169645
154615
192996
2323087
169738
189466
158053
12216
170016
189642
160253
14537
10818
185807
192308
165085
163823
167365
137008
192279
193808
167826
169764
155456
193007
156258
190471
178045
155580
194190
156314
185455
173716
189791
161734
15518
14124
189762
192388
165126
164227
168151
139059
192363
193871
169534
169475
142685
192446
196316
169539
179321
157440
198215
156264
189236
177436
190229
162681
137394
14252
190169
192405
165129";

            $your_array = explode("\n", $list);


            foreach ($your_array as $ya ) {

/*
                    $stmt_c = $this->db->prepare("DELETE FROM  `product_savers`  WHERE code=? AND id_device=919  ");
                    $stmt_c->execute(array(trim($ya)));

                    $stmt_  = $this->db->prepare("DELETE FROM  `excel_savers`  WHERE code=?");
                    $stmt_->execute(array(trim($ya)));

                    $stmt_  = $this->db->prepare("DELETE FROM  `location`  WHERE code=? AND  model='savers'");
                    $stmt_->execute(array(trim($ya)));

                    $stmt_  = $this->db->prepare("DELETE FROM  `location_confirm`  WHERE code=? AND  model='savers'");
                    $stmt_->execute(array(trim($ya)));
*/


            }
        }else{
            echo 'enter 1 for start move !';
        }
    }



    function auto_select_device($id=null)
    {

        if ($this->handleLogin()) {

            if ($id) {
                $stmt = $this->db->prepare("SELECT *FROM `type_device`  WHERE  id =? AND id_device_mobile=0");
                $stmt->execute(array($id));

            } else {
                $stmt = $this->db->prepare("SELECT *FROM `type_device`  WHERE  id_device_mobile=0");
                $stmt->execute();
            }

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $stmt_device_name = $this->db->prepare("SELECT *FROM `menu_link_device_acc_cover` WHERE name_device=?  LIMIT 1");
                $stmt_device_name->execute(array(trim($row['title'])));
                if ($stmt_device_name->rowCount() > 0) {
                    $result = $stmt_device_name->fetch(PDO::FETCH_ASSOC);
                    $stmtUpdate = $this->db->prepare("UPDATE type_device SET id_device_mobile=? WHERE id=?  ");
                    $stmtUpdate->execute(array($result['id'], $row['id']));
//                    if ($stmtUpdate->rowCount() > 0) {
//                        echo $result['name_device'] . '=' . $row['title'] . '<br>';
//                    }

                }

            }

        }
    }




    /*          توزيع الحافظات من الحافظات النادة الى اقسامهن  */
    function convert()
    {


        if ($this->handleLogin()) {

            $stmt = $this->db->prepare("SELECT *FROM `cover_add`  ");
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $stmt_category_savers = $this->db->prepare("SELECT  type_device.id  FROM `category_savers`

               INNER  JOIN name_device ON  name_device.id_cat=category_savers.id
               INNER  JOIN type_device ON  type_device.id_device=name_device.id

                  WHERE category_savers.title=?  AND name_device.title=? AND type_device.title=? LIMIT 1");
                $stmt_category_savers->execute(array(trim($row['mark']), trim($row['sqe']), trim($row['device'])));
                if ($stmt_category_savers->rowCount() > 0) {
                    $category_savers = $stmt_category_savers->fetch(PDO::FETCH_ASSOC);

                    $stmtUpdate = $this->db->prepare("UPDATE product_savers SET title=? , id_device=? WHERE code=?  ");
                    $stmtUpdate->execute(array($row['title'], $category_savers['id'], $row['code']));
                    if ($stmtUpdate->rowCount() > 0) {
                        echo $row['code'] . '=' . $row['title'] . '<br>';
                    }

                }
            }
        }

    }




    public function processing_all_category()
    {


        $table = $this->type_device;
        $primaryKey ='id';

        $columns = array(


            array('db' => 'title', 'dt' => 0),
            array(
                'db' => 'serial_prepared',
                'dt' => 1,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible_serial_prepared',$this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_visible_serial_prepared($row[8])} class='toggle-demo' onchange='visible_serial(this,$row[8])' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),




            array(
                'db' => 'serial_duplication',
                'dt' => 2,
                'formatter' => function ($id, $row) {
                    if ($this->permit('serial_duplication',$this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_serial_duplication($row[8])} class='toggle-demo' onchange='duplication_serial(this,$row[8])' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),


            array(
                'db' => 'serial_transfer',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    if ($this->permit('serial_transfer',$this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_serial_transfer($row[8])} class='toggle-demo' onchange='transfer_serial(this,$row[8])' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),


            array(
                'db' => 'serial_rewind',
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    if ($this->permit('serial_rewind',$this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_serial_rewind($row[8])} class='toggle-demo' onchange='rewind_serial(this,$row[8])' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),


            array(
                'db' => 'serial_purchase',
                'dt' => 5,
                'formatter' => function ($id, $row) {
                    if ($this->permit('serial_purchase',$this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_serial_purchase($row[8])} class='toggle-demo' onchange='purchase_serial(this,$row[8])' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),



            array(
                'db' => 'serial_withdraw',
                'dt' =>6,
                'formatter' => function ($id, $row) {
                    if ($this->permit('serial_withdraw',$this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_serial_withdraw($row[8])} class='toggle-demo' onchange='withdraw_serial(this,$row[8])' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),




            array(
                'db' => 'userid_serial',
                'dt' => 7,
                'formatter' => function ($id, $row) {

                    return $this->UserInfo($id);
                }
            ),
            array('db' =>'id', 'dt' => 8),


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

            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns));

    }




    function ch_visible_serial_prepared($id){


        $stmt = $this->db->prepare("SELECT * FROM {$this->type_device} WHERE `id` = ? AND `serial_prepared` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }


    }



    function  visible_serial ($v_,$id_){


        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }
        $data = $this->db->update($this->type_device, array('serial_prepared' => $v,'userid_serial' => $this->userid), "`id`={$id}");


    }



    function ch_serial_duplication($id){


        $stmt = $this->db->prepare("SELECT * FROM {$this->category} WHERE `id` = ? AND `serial_duplication` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }


    }

    function  duplication_serial ($v_,$id_){


        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }
        $data = $this->db->update($this->category, array('serial_duplication' => $v), "`id`={$id}");


    }



    function ch_serial_transfer($id){


        $stmt = $this->db->prepare("SELECT * FROM {$this->category} WHERE `id` = ? AND `serial_transfer` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }


    }

    function  transfer_serial ($v_,$id_){


        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }
        $data = $this->db->update($this->category, array('serial_transfer' => $v), "`id`={$id}");


    }


    function ch_serial_rewind($id){


        $stmt = $this->db->prepare("SELECT * FROM {$this->category} WHERE `id` = ? AND `serial_rewind` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }


    }

    function  rewind_serial ($v_,$id_){


        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }
        $data = $this->db->update($this->category, array('serial_rewind' => $v), "`id`={$id}");


    }



    function ch_serial_purchase($id){


        $stmt = $this->db->prepare("SELECT * FROM {$this->category} WHERE `id` = ? AND `serial_purchase` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }


    }

    function  purchase_serial ($v_,$id_){


        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }
        $data = $this->db->update($this->category, array('serial_purchase' => $v), "`id`={$id}");


    }


    function ch_serial_withdraw($id){


        $stmt = $this->db->prepare("SELECT * FROM {$this->category} WHERE `id` = ? AND `serial_withdraw` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }


    }

    function  withdraw_serial ($v_,$id_){


        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }
        $data = $this->db->update($this->category, array('serial_withdraw' => $v), "`id`={$id}");


    }



	 // 2022/09/06
    function full_report()
    {
        $this->checkPermit('full_report', 'savers');
        $this->adminHeaderController($this->langControl('full_report'));
        $this->saleQuantity = 0;
        $this->totalQuantity = 0;
        $this->nextQuantity = 0;
        $this->insideQuantity = 0;
        $stmt = $this->db->prepare("SELECT * from `{$this->category}`  WHERE {$this->is_delete}  ");
		$stmt->execute(array());
		$category=array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$category[]=$row;
		}

    	 $stmtcover_material = $this->db->prepare("SELECT * from `cover_material`   ");
        $stmtcover_material->execute(array());
        $cover_material=array();
        while ($row = $stmtcover_material->fetch(PDO::FETCH_ASSOC))
        {
            $cover_material[]=$row;
        }

        $stmttype_cover = $this->db->prepare("SELECT * from `type_cover`   ");
        $stmttype_cover->execute(array());
        $type_cover=array();
        while ($row = $stmttype_cover->fetch(PDO::FETCH_ASSOC))
        {
            $type_cover[]=$row;
        }


        $stmtfeature_cover = $this->db->prepare("SELECT * from `feature_cover`   ");
        $stmtfeature_cover->execute(array());
        $feature_cover=array();
        while ($row = $stmtfeature_cover->fetch(PDO::FETCH_ASSOC))
        {
            $feature_cover[]=$row;
        }

        require($this->render($this->folder, 'html', 'full_report', 'php'));
        $this->adminFooterController();

    }


    function processing_full_report($model ='0',$date_start = '0',$date_end = '0',$cover_material = '0',$type_cover = '0',$feature_cover= '0'){
        $this->data = new compare_warehouses();

        $this->date_start = strtotime($date_start);
        $this->date_end =  strtotime($date_end);
        $this->model = $model;

        // الكمية المباعة حسب التصنيف الكلي
        $this->quantSaleAllType = array();
        $this->quantSaleAllType = $this->quantitySaleByAllType($this->model,$this->date_start,$this->date_end);


        // الكمية الكلية حسب التصنيف الكلي
        $this->quantTotalAllType = array();
        $this->quantTotalAllType = $this->quantTotalByAllType($this->model);


        // الكمية القادمة حسب التصنيف الكلي
        $this->quantNextAllType = array();
        $this->quantNextAllType = $this->quantNextByAllType($this->model);


        // الكمية الداخلة حسب التصنيف الكلي
        $this->quantInsideAllType = array();
        $this->quantInsideAllType = $this->quantInsideByAllType($this->model,$this->date_start,$this->date_end);


        $table = "product_savers";
        $primaryKey = 'product_savers.id';
        $tableJoin = 'type_device';
        $columns = array(
            array( 'db' => 'product_savers.code', 'dt' => 0),
            array( 'db' => 'product_savers.img', 'dt' => 1,
                'formatter' => function ($img, $row) {
                    if ($img)
                    {
                        return "<img width=140 height= 140 src='".$this->save_file.$img."' >";
                    }else{
                        return 'لاتوجد صورة';
                    }
                }
            ),
            array('db' => 'product_savers.title', 'dt' =>2),
            array('db' => 'product_savers.latiniin', 'dt' =>3),
            array('db' => 'product_savers.date', 'dt' =>4,
                  'formatter' => function ($date,$row) {
                     return  date('Y-m-d h:i:s A',$date);
                  }
            ),
            array( 'db' => 'product_savers.code', 'dt' =>5,
                'formatter' => function ($code,$row) {
                    return $this->sale($code,$this->date_start,$this->date_end);
                }
            ),
            array( 'db' => 'product_savers.code', 'dt' =>6,
                'formatter' => function ($code, $row) {
                    return $this->insideQuantity($code,$this->date_start,$this->date_end);
                }
            ),
            array( 'db' => 'product_savers.code', 'dt' =>7,
                'formatter' => function ($code,$row) {
                    return $this->currentQuantity($code);
                }
            ),

            array('db' => 'product_savers.id', 'dt' =>8,
                'formatter' => function ($id, $row) {
                return $this->typeSavers($row[9],$row[10],$row[11]);
                }
            ),
            array('db' => 'product_savers.cover_material', 'dt' =>9,
            'formatter' => function ($id, $row) {
                 if($id != ''){
                    return "<button type='button' onclick='edit_cover_material($row[0])' class='btn btn-sm'  id='edit-cover-material-{$row[0]}' style = 'background-color : #008CBA;color: #FFF;'> <i class='fa fa-pencil' ></i></button>"."<div  class='edit-cover-material-{$row[0]}'  style='display:none'>".$this->data->cover_material($id,$row[0])."</div>";
                }
                else{
                    return $this->data->cover_material($id, $row[0]);
                }
            }
            ),
            array('db' => 'product_savers.type_cover', 'dt' => 10,
                'formatter' => function ($id, $row) {
                    if($id != ''){
                        return "<button type='button' onclick='edit_type_cover($row[0])' class='btn btn-sm '   id='edit-type-cover-{$row[0]}' style = 'background-color : #008CBA;color: #FFF;'> <i class='fa fa-pencil' ></i></button>"."<div  class='edit-type-cover-{$row[0]}'  style='display:none'>".$this->data->type_cover($id,$row[0])."</div>";
                    }else{
                    return $this->data->type_cover($id, $row[0]);
                    }
                }
            ),
            array('db' => 'product_savers.feature_cover', 'dt' => 11,
                'formatter' => function ($id, $row) {
                if($id != ''){
                        return "<button type='button' onclick='edit_feature_cover($row[0])' class='btn btn-sm'  id='edit-feature-cover-{$row[0]}' style = 'background-color : #008CBA;color: #FFF;'> <i class='fa fa-pencil' ></i></button>"."<div class='edit-feature-cover-{$row[0]}'  style='display:none'>".$this->data->feature_cover($id,$row[0])."</div>";
                    }else{
                        return  $this->data->feature_cover($id, $row[0]);
                    }
                }
            ),
            array('db' => 'product_savers.note', 'dt' =>12,
                'formatter' => function ($note, $row) {
                    return "<input type='text' onchange='update_rate(this.value,$row[38])' class='note' name='note'  value='{$note}' style='width:80px;height:30px; font-size:14px'/>";
                }
            ),
            array( 'db' => 'product_savers.code', 'dt' => 13,
                'formatter' => function ($code, $row) {
                    return $this->quantInViewOrStore($code,' `sequence` BETWEEN 4 AND 100');
                }
            ),
            array( 'db' => 'product_savers.code', 'dt' => 14,
                'formatter' => function ($code, $row) {
                    return  $this->quantInViewOrStore($code,' (`sequence` < 4 OR `sequence` > 100 ) ');
                }
            ),
           array( 'db' => 'product_savers.code', 'dt' => 15,
                'formatter' => function ($code, $row) {
                    return  $this->nextQuantity($code);
                }
            ),
            array( 'db' => 'product_savers.code', 'dt' =>16,
                'formatter' => function ($code, $row) {
                    return $this->stateOrder($code);
                }
            ),
            array( 'db' => 'product_savers.code', 'dt' =>17,
                'formatter' => function ($code, $row) {
                    return $this->dateArrival($code);
                }
            ),
            array( 'db' => 'product_savers.note', 'dt' => 18,
                'formatter' => function ($rate, $row) {
                    return $this->getRateMore70($this->model,$rate);
                }
            ),
            array( 'db' => 'product_savers.note', 'dt' => 19,
                'formatter' => function ($rate, $row) {
                    return $this->getRateBetween60And70($this->model,$rate);
                }
            ),
            array( 'db' => 'product_savers.note', 'dt' => 20,
                'formatter' => function ($rate, $row) {
                    return $this->getRateLess60($this->model,$rate);
                }
            ),

            array( 'db' => 'product_savers.id', 'dt' => 21,
                'formatter' => function ($id, $row) {
                    $key = $row[9].$row[10].$row[11];
                    if($this->quantSaleAllType[$key] != ''){
                        return  $this->quantSaleAllType[$key];
                    }else{
                        return  0;
                    }
                }
            ),
            array( 'db' => 'product_savers.id', 'dt' => 22,
                'formatter' => function ($id, $row) {
                    $key = $row[9].$row[10].$row[11];
                    if($this->quantInsideAllType[$key] != ''){
                        return  $this->quantInsideAllType[$key];
                    }else{
                        return  0;
                    }
                }
            ),
            array( 'db' => 'product_savers.id', 'dt' =>23,
                'formatter' => function ($id, $row) {
                    $key = $row[9].$row[10].$row[11];
                    if($this->quantTotalAllType[$key] != ''){
                        return  $this->quantTotalAllType[$key];
                    }else{
                        return  0;
                    }

                }
            ),
            array( 'db' => 'product_savers.id', 'dt' => 24,
                'formatter' => function ($id, $row) {
                    $key = $row[9].$row[10].$row[11];
                    if($this->quantNextAllType[$key] != ''){
                        return  $this->quantNextAllType[$key];
                    }else{
                        return  0;
                    }
                }
            ),
            array( 'db' => 'product_savers.code', 'dt' => 25,
                'formatter' => function ($code, $row) {
                    return $this->lastSaleFromViewOrStore($code,'`sequence` BETWEEN 4 AND 100');
                }
            ),

            array( 'db' => 'product_savers.code', 'dt' => 26,
                'formatter' => function ($code, $row) {
                    return $this->lastSaleFromViewOrStore($code,' (`sequence` < 4 OR `sequence` > 100 ) ');
                }
            ),
            array( 'db' => 'product_savers.code', 'dt' => 27,
                'formatter' => function ($code, $row) {
                    return $this->lastTransferViewOrStore($code,'`sequence` BETWEEN 4 AND 100 ');
                }
            ),
            array( 'db' => 'product_savers.code', 'dt' => 28,
                'formatter' => function ($code, $row) {
                    return $this->lastTransferViewOrStore($code,'(`sequence` < 4 OR `sequence` > 100 )');
                }
            ),
            array( 'db' => 'product_savers.code', 'dt' => 29,
                'formatter' => function ($code, $row) {
                    return $this->lastOffers($code);
                }
            ),
            array( 'db' => 'product_savers.code', 'dt' =>30,
                'formatter' => function ($code, $row) {
                    $data = $this->lastJard($code);
                    if($data != false){
                        return  date('Y-m-d h:i:s A',$data['date']);
                    }else{
                        return '-';
                    }
                }
            ),
            array( 'db' => 'product_savers.code', 'dt' => 31,
                'formatter' => function ($code, $row) {
                    $data = $this->lastJard($code);
                    if($data != false){
                        return $this->UserInfo($data['userId']);
                    }else{
                        return '-';
                    }
                }
            ),
            array( 'db' => 'product_savers.id', 'dt' =>32,
                'formatter' => function ($id, $row) {
                    return '-';
                }
            ),
            array( 'db' => 'product_savers.id', 'dt' =>33,
                'formatter' => function ($id, $row) {
                    return '-';
                }
            ),
            array( 'db' => 'product_savers.id', 'dt' =>34,
                'formatter' => function ($id, $row) {
                    return ' - ';
                }
            ),
            array( 'db' => 'product_savers.id', 'dt' =>35,
            'formatter' => function ($id, $row) {
                    return '-';
                }
            ),
            array( 'db' => 'product_savers.id', 'dt' =>36,
                'formatter' => function ($id, $row) {
                    return '- ';
                }
            ),
            array( 'db' => 'product_savers.id', 'dt' => 37,
                'formatter' => function ($id, $row) {
                    return '-';
                }
            ),
            array( 'db' => 'product_savers.id', 'dt' => 38)


        );
        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = " INNER JOIN type_device ON product_savers.id_device = type_device.id    ";
        $whereAll = " `product_savers`.`id_device` = $model AND `product_savers`.`is_delete` = 0  ";
       if($cover_material != '0'){
            $whereAll .= " AND  `product_savers`.`cover_material` = $cover_material ";
        }
        if($type_cover != '0'){
            $whereAll .= " AND  `product_savers`.`type_cover` = $type_cover ";
        }
        if($feature_cover != '0'){
            $whereAll .= " AND  `product_savers`.`feature_cover` = $feature_cover ";
        }




        // echo json_encode(SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, "id_device = $model ") );
        echo json_encode(SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));
    }




    // عرض مجموع الحافظات الرجالية او النسائية
    function numberCover($model,$type){
        $quantity = 0;
        if($type == 1){
            $type = 'رجالي';
        }
        if($type == 2){
            $type = 'نسائي';
        }
        $stmt_type_cover =$this->db->prepare("SELECT number FROM type_cover WHERE  type_cover=? OR type_cover=?");
        $stmt_type_cover->execute(array($type,'مشترك'));
        if($stmt_type_cover->rowCount() > 0){
            while ($row_type_cover = $stmt_type_cover->fetch(PDO::FETCH_ASSOC)){
                $type_cover = $row_type_cover['number'];
                $stmt_quantity= $this->db->prepare("SELECT  SUM(excel_savers.quantity) as num FROM excel_savers INNER JOIN product_savers ON excel_savers.code = product_savers.code WHERE   product_savers.id_device = ? AND `product_savers`.`is_delete` = 0  AND product_savers.type_cover =? ");
                $stmt_quantity->execute(array($model,$type_cover));
                if($stmt_quantity->rowCount() > 0){
                    $row_quantity = $stmt_quantity->fetch(PDO::FETCH_ASSOC);
                    $quantity += $row_quantity['num'];
                }
            }


        }

        echo  $quantity;
    }

	function numberTypeCover($model,$type){
        $quantity = 0;

        if($type == 1){
            $type = 'رجالي';
        }
        if($type == 2){
            $type = 'نسائي';
        }
        if($type == 3){
            $type = 'مشترك';
        }
        // echo $type;
        $stmt_type_cover =$this->db->prepare("SELECT `number` FROM `type_cover` WHERE  `type_cover`=? ");
        $stmt_type_cover->execute(array($type));
        if($stmt_type_cover->rowCount() > 0){

            $row = $stmt_type_cover->fetch(PDO::FETCH_ASSOC);
            $type_cover = $row['number'];
            $stmt_quantity= $this->db->prepare("SELECT  `product_savers`.`id` FROM `product_savers` INNER JOIN `excel_savers` ON `product_savers`.`code` = `excel_savers`.`code` WHERE   `product_savers`.`id_device` = ? AND  `product_savers`.`type_cover` =? AND `excel_savers`.`quantity` !=0  GROUP BY  `product_savers`.`latiniin`");
            $stmt_quantity->execute(array($model,$type_cover));
            if($stmt_quantity->rowCount() > 0){
                // $row_quantity = $stmt_quantity->fetch(PDO::FETCH_ASSOC);
                $quantity = $stmt_quantity->rowCount();
            }



        }

        echo  $quantity;
    }


	 function numberTypeCoverBySearch($model,$cover_material = '0',$type_cover='0',$feature_cover='0'){
        $quantity = 0;
        $where = " `product_savers`.`is_delete` = 0 " ;
        if($cover_material != 0){
            $where .=  " AND `product_savers`.`cover_material` = $cover_material";
        }
        if($type_cover != 0){
            $where .=  " AND `product_savers`.`type_cover` = $type_cover";
        }
        if($feature_cover != 0){
            $where .=  " AND `product_savers`.`feature_cover` = $feature_cover";
        }

        // echo $where;
        $stmt_quantity= $this->db->prepare("SELECT  `product_savers`.`id` FROM `product_savers` INNER JOIN `excel_savers` ON `product_savers`.`code` = `excel_savers`.`code` WHERE   `product_savers`.`id_device` = ? AND `excel_savers`.`quantity` !=0 AND {$where}  GROUP BY  `product_savers`.`latiniin`");
        $stmt_quantity->execute(array($model));
        if($stmt_quantity->rowCount() > 0){
            // $row_quantity = $stmt_quantity->fetch(PDO::FETCH_ASSOC);
            // $quantity += $row_quantity['num'];
            $quantity = $stmt_quantity->rowCount();
        }

        echo $quantity;
    }

    //  الكمية المباعة حسب الباركود
    function sale($code,$date_start,$date_end){
        $stmt= $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop_all` WHERE `code` = ? AND `table`= 'product_savers' AND `date` BETWEEN ? AND ?  AND  `accountant` = 1  AND `buy` = 2 AND cancel=0   ");
        $stmt->execute(array($code,$date_start,$date_end));
        $only_sale = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($only_sale['num'])
        {
            return $only_sale['num'];
        }else{

            return 0;
        }
    }

    //  الكمية  الداخلة حسب الباركود
    function insideQuantity($code,$date_start,$date_end){
        $quantity = 0;
        $quant_location_conf =$this->db->prepare("SELECT SUM(`quantity`) as num FROM `location_confirm` WHERE  `model` = ?  AND `date` BETWEEN ? AND ? AND `code` =? ");
        $quant_location_conf->execute(array('savers',$date_start,$date_end,$code));
        if ($quant_location_conf->rowCount() > 0)
        {
            $row = $quant_location_conf->fetch(PDO::FETCH_ASSOC);
            $quantity =   $row['num'];
        }


        $quant_purchase =$this->db->prepare("SELECT SUM(`quantity`) as num FROM `purchase_customer_item` WHERE `table` = ?  AND `date` BETWEEN ? AND ? AND  `code` =?");
        $quant_purchase->execute(array('savers',$date_start,$date_end,$code));

        if ($quant_purchase->rowCount() > 0)
        {
            $row= $quant_purchase->fetch(PDO::FETCH_ASSOC);
            $quantity +=   $row['num'];
        }

        return $quantity;

    }


    //  الكمية الكلية حسب الباركود
    function currentQuantity($code){
        $stmt_quantity =$this->db->prepare("SELECT `quantity` FROM `excel_savers` WHERE `code` =?  limit 1");
        $stmt_quantity->execute(array($code));
        $row = $stmt_quantity->fetch(PDO::FETCH_ASSOC);
        if ($row['quantity'])
        {
            return $row['quantity'];
        }else{

            return 0;
        }

    }

    // اذا مامرفوعات تراكمي(purchase_item)الكمية القادمة حسب الباركود تحسب من جدول
    function nextQuantity($code){
        $stmt_quantity =$this->db->prepare("SELECT  SUM(`quantity`) as num FROM `purchase_item` WHERE `add_to_excel`= 0 AND `code` =? ");
        $stmt_quantity->execute(array($code));
        $row = $stmt_quantity->fetch(PDO::FETCH_ASSOC);
        if ($row['num'])
        {
            return $row['num'];
        }else{

            return 0;
        }
    }

    // حالة الطلب من فاتورة عرض الشراء
    function stateOrder($code){
        $stateOrder = '';
        $stmt_state= $this->db->prepare("SELECT  `purchase_order`.`state_order`, `purchase_item`.`quantity` FROM `purchase_order` INNER JOIN `purchase_item` ON `purchase_order`.`id` = `purchase_item`.`idpurchase` WHERE  `purchase_item`.`code`= ? ");
        $stmt_state->execute(array($code));
        if($stmt_state->rowCount() > 0){
            while ($row = $stmt_state->fetch(PDO::FETCH_ASSOC)){
                $stateOrder .=  $row['quantity'].'  :  '. $this->langControl($row['state_order']) . '<br>';
            }


        }else{
            $stateOrder = '-';
        }
        return  $stateOrder;
    }

    // الوقت المتوقع للوصول
    function dateArrival($code){
        $date = '';
        $stmt_date= $this->db->prepare("SELECT  `purchase_order`.`date_ex_arrival`, `purchase_item`.`quantity` FROM `purchase_order` INNER JOIN `purchase_item` ON `purchase_order`.`id` = `purchase_item`.`idpurchase` WHERE  `purchase_item`.`code`= ? ");
        $stmt_date->execute(array($code));
        if($stmt_date->rowCount() > 0){
            while ($row = $stmt_date->fetch(PDO::FETCH_ASSOC)){
                if($row['date_ex_arrival'] != 0){
                    $date .=  $row['quantity'].'  : '. date('Y-m-d',$row['date_ex_arrival']) . '<br>';
                }else{
                    $date .= '-'.'<br>';
                }
            }
        }else{
            $date .= '-';
        }
        return  $date;
    }


   // تعديل النسبة
	function updateRate($idSavers,$rate){
        $update =$this->db->prepare("UPDATE `product_savers` SET `note` = ? WHERE `id` = ?");
        $update->execute(array($rate,$idSavers));
        if ($update->rowCount() > 0) {
            return true;
        }else{
            return false;
        }
    }

    // التصنيف
    function typeSavers($cover_material,$type_cover,$feature){
        $featureCover= explode(",",$feature);
        $feature_cover = '';
        $type = '';
        $stmt_cover_material =$this->db->prepare("SELECT `cover_material` FROM `cover_material` WHERE  `number`=? limit 1");
        $stmt_cover_material->execute(array($cover_material));
        if($stmt_cover_material->rowCount() > 0){
            $row_cover_material = $stmt_cover_material->fetch(PDO::FETCH_ASSOC);
            $cover_material = $row_cover_material['cover_material'];
        }else{
            $cover_material = '';
        }


        $stmt_type_cover =$this->db->prepare("SELECT `type_cover` FROM `type_cover` WHERE  `number`=?  limit 1");
        $stmt_type_cover->execute(array($type_cover));
        if($stmt_type_cover->rowCount() > 0){
            $row_type_cover = $stmt_type_cover->fetch(PDO::FETCH_ASSOC);
            $type_cover = $row_type_cover['type_cover'];
        }else{
            $type_cover = '';
        }

        for($i = 0 ; $i< count($featureCover); $i++){
            $stmt_feature_cover =$this->db->prepare("SELECT `feature_cover` FROM `feature_cover` WHERE  `number`=? limit 1");
            $stmt_feature_cover->execute(array($featureCover[$i]));
            if($stmt_feature_cover->rowCount() > 0){
                $row_feature_cover = $stmt_feature_cover->fetch(PDO::FETCH_ASSOC);
                $feature_cover .= $row_feature_cover['feature_cover']. '<br>';
            }else{
                $feature_cover = '';
            }
        }


        $type = $cover_material .' <br> '.$type_cover .' <br> '.$feature_cover;



        return $type;
    }

    // 70%
    function getRateMore70($model,$rate){
        $quantity = 0;
        $countCover = 0;
        $result = 0.0;
        $stmt_count= $this->db->prepare("SELECT  COUNT(*) as _count FROM `product_savers` WHERE  `product_savers`.`id_device` = ? AND `product_savers`.`is_delete` = 0 ");
        $stmt_count->execute(array($model));
        if($stmt_count->rowCount() > 0){
            $row = $stmt_count->fetch(PDO::FETCH_ASSOC);
            $countCover = $row['_count'];
        }
        if($rate >= 0.7){
            $stmt_quantity= $this->db->prepare("SELECT  SUM(`excel_savers`.`quantity`) as num FROM `excel_savers` INNER JOIN `product_savers` ON `excel_savers`.`code` = `product_savers`.`code` WHERE   `product_savers`.`id_device` = ?  AND  `product_savers`.`note` = ? AND `product_savers`.`is_delete` = 0 ");
            $stmt_quantity->execute(array($model,$rate));
            if($stmt_quantity->rowCount() > 0){
                $row_quantity = $stmt_quantity->fetch(PDO::FETCH_ASSOC);
                $quantity = $row_quantity['num'];
            }
            $result= round(($quantity/$countCover),1);
            return $result;

        }else{
            return '-';
        }


    }

    // 60%-70%
    function getRateBetween60And70($model,$rate){
        $quantity = 0;
        $countCover = 0;
        $result = 0.0;
        $stmt_count= $this->db->prepare("SELECT  COUNT(*) as _count FROM `product_savers` WHERE  `product_savers`.`id_device` = ? AND `product_savers`.`is_delete` = 0 ");
        $stmt_count->execute(array($model));
        if($stmt_count->rowCount() > 0){
            $row = $stmt_count->fetch(PDO::FETCH_ASSOC);
            $countCover = $row['_count'];
        }
        if($rate < 0.7 && $rate >= 0.6){
            $stmt_quantity= $this->db->prepare("SELECT  SUM(`excel_savers`.`quantity`) as num FROM `excel_savers` INNER JOIN `product_savers` ON `excel_savers`.`code` = `product_savers`.`code` WHERE   `product_savers`.`id_device` = ?  AND  `product_savers`.`note` = ? AND `product_savers`.`is_delete` = 0 ");
            $stmt_quantity->execute(array($model,$rate));
            if($stmt_quantity->rowCount() > 0){
                $row_quantity = $stmt_quantity->fetch(PDO::FETCH_ASSOC);
                $quantity = $row_quantity['num'];
            }
            $result= round(($quantity/$countCover),1);
            return $result;

        }else{
            return '-';
        }


    }

    // اقل من %60
    function getRateLess60($model,$rate){
        $quantity = 0;
        $countCover = 0;
        $result = 0.0;
        $stmt_count= $this->db->prepare("SELECT  COUNT(*) as _count FROM `product_savers` WHERE  `product_savers`.`id_device` = ? AND `product_savers`.`is_delete` = 0 ");
        $stmt_count->execute(array($model));
        if($stmt_count->rowCount() > 0){
            $row = $stmt_count->fetch(PDO::FETCH_ASSOC);
            $countCover = $row['_count'];
        }
        if($rate < 0.6){
            $stmt_quantity= $this->db->prepare("SELECT  SUM(`excel_savers`.`quantity`) as num FROM `excel_savers` INNER JOIN `product_savers` ON `excel_savers`.`code` = `product_savers`.`code` WHERE   `product_savers`.`id_device` = ?  AND  `product_savers`.`note` = ?");
            $stmt_quantity->execute(array($model,$rate));
            if($stmt_quantity->rowCount() > 0){
                $row_quantity = $stmt_quantity->fetch(PDO::FETCH_ASSOC);
                $quantity = $row_quantity['num'];
            }
            $result= round(($quantity/$countCover),1);
            return $result;

        }else{
            return '-';
        }


    }

    // الكمية المباعة حسب التصنيف
    function quantitySaleByAllType($model,$date_start,$date_end){
        $quantSaleAllType = array();
        $stmt_quantity= $this->db->prepare("SELECT  SUM(`cart_shop_all`.`number`) as num,`product_savers`.`cover_material`,`product_savers`.`type_cover`, `product_savers`.`feature_cover` FROM `cart_shop_all` INNER JOIN `product_savers` ON `cart_shop_all`.`code` = `product_savers`.`code` WHERE  `cart_shop_all`.`table`= 'product_savers' AND `cart_shop_all`.`accountant` = 1 AND `cart_shop_all`.`buy` = 2 AND `cart_shop_all`.`cancel` =0 AND `cart_shop_all`.`date` BETWEEN ? AND ? AND `product_savers`.`id_device` = ? AND `product_savers`.`is_delete` = 0   GROUP by `product_savers`.`cover_material` ,`product_savers`.`type_cover`, `product_savers`.`feature_cover` ");
        $stmt_quantity->execute(array($date_start,$date_end,$model));

        if ($stmt_quantity->rowCount() > 0)
        {
            while ($row_quantity = $stmt_quantity->fetch(PDO::FETCH_ASSOC)){
                $key = $row_quantity['cover_material'].$row_quantity['type_cover'].$row_quantity['feature_cover'];
                $quantSaleAllType[$key]= $row_quantity['num'];
            }
        }

        return $quantSaleAllType;
    }

    // الكمية الكليةالداخلة  حسب التصنيف
    function quantInsideByAllType($model,$date_start,$date_end){
        $quantity = array();
        $stmt_location= $this->db->prepare("SELECT  SUM(`location_confirm`.`quantity`) as num,`product_savers`.`cover_material`,`product_savers`.`type_cover`, `product_savers`.`feature_cover` FROM `location_confirm` INNER JOIN `product_savers` ON `location_confirm`.`code` = `product_savers`.`code` WHERE   `location_confirm`.`model` = 'savers' AND `location_confirm`.`date` BETWEEN ? AND ? AND `product_savers`.`id_device` = ? AND `product_savers`.`is_delete` = 0   GROUP by `product_savers`.`cover_material` ,`product_savers`.`type_cover`, `product_savers`.`feature_cover` ");
        $stmt_location->execute(array($date_start,$date_end,$model));

        if ($stmt_location->rowCount() > 0)
        {
            while ($row_location = $stmt_location->fetch(PDO::FETCH_ASSOC)){
                $key = $row_location['cover_material'].$row_location['type_cover'].$row_location['feature_cover'];
                $quantity[$key]= $row_location['num'];
            }
        }

        $stmt_quantity= $this->db->prepare("SELECT  SUM(`purchase_customer_item`.`quantity`) as num,`product_savers`.`cover_material`,`product_savers`.`type_cover`, `product_savers`.`feature_cover` FROM `purchase_customer_item` INNER JOIN `product_savers` ON `purchase_customer_item`.`code` = `product_savers`.`code` WHERE   `purchase_customer_item`.`table` = 'savers' AND `purchase_customer_item`.`date` BETWEEN ? AND ? AND `product_savers`.`id_device` = ? AND `product_savers`.`is_delete` = 0  GROUP by `product_savers`.`cover_material` ,`product_savers`.`type_cover`, `product_savers`.`feature_cover` ");
        $stmt_quantity->execute(array($date_start,$date_end,$model));

        if ($stmt_quantity->rowCount() > 0)
        {
            while ($row_quantity = $stmt_quantity->fetch(PDO::FETCH_ASSOC)){
                $key = $row_quantity['cover_material'].$row_quantity['type_cover'].$row_quantity['feature_cover'];
                isset($quantity[$key]) ? $quantity[$key] += $row_quantity['num']:  $quantity[$key] =  $row_quantity['num'];
            }
        }


        return $quantity;

    }

    //  الكمية الكلية حسب التصنيف
    function quantTotalByAllType($model){
        $quantity = array();

        $stmt_quantity= $this->db->prepare("SELECT  SUM(`excel_savers`.`quantity`) as num,`product_savers`.`cover_material`,`product_savers`.`type_cover`, `product_savers`.`feature_cover` FROM `excel_savers` INNER JOIN `product_savers` ON `excel_savers`.`code` = `product_savers`.`code` WHERE   `product_savers`.`id_device` = ? AND `product_savers`.`is_delete` = 0   GROUP by `product_savers`.`cover_material` ,`product_savers`.`type_cover`, `product_savers`.`feature_cover` ");
        $stmt_quantity->execute(array($model));

        if ($stmt_quantity->rowCount() > 0)
        {
            while ($row_quantity = $stmt_quantity->fetch(PDO::FETCH_ASSOC)){
                $key = $row_quantity['cover_material'].$row_quantity['type_cover'].$row_quantity['feature_cover'];
                $quantity[$key]= $row_quantity['num'];
            }
        }
        return $quantity;
    }

    // الكميةالقادمة من عرض الشراء حسب التصنيف
    function quantNextByAllType($model){
        $quantity = array();

        $stmt_quantity= $this->db->prepare("SELECT  SUM(`purchase_item`.`quantity`) as num,`product_savers`.`cover_material`,`product_savers`.`type_cover`, `product_savers`.`feature_cover` FROM `purchase_item` INNER JOIN `product_savers` ON `purchase_item`.`code` = `product_savers`.`code` WHERE   `product_savers`.`id_device` = ? AND `product_savers`.`is_delete` = 0    GROUP by `product_savers`.`cover_material` ,`product_savers`.`type_cover`, `product_savers`.`feature_cover` ");
        $stmt_quantity->execute(array($model));

        if ($stmt_quantity->rowCount() > 0)
        {
            while ($row_quantity = $stmt_quantity->fetch(PDO::FETCH_ASSOC)){
                $key = $row_quantity['cover_material'].$row_quantity['type_cover'].$row_quantity['feature_cover'];
                $quantity[$key]= $row_quantity['num'];
            }
        }

        return $quantity;
    }

    // الكمية في مواقع العرض
    function quantInViewOrStore($code,$where){
        $stmt_quantity =$this->db->prepare("SELECT  SUM(`quantity`) as num FROM `location` WHERE {$where} AND `code` =? ");
        $stmt_quantity->execute(array($code));
        $row = $stmt_quantity->fetch(PDO::FETCH_ASSOC);
        if ($row['num'])
        {
            return $row['num'];
        }else{

            return 0;
        }
    }

    // تاريخ اخر مبيع في مواقع العرض او الخزن
    function lastSaleFromViewOrStore($code,$where){
        $date = '';
        $stmt_date = $this->db->prepare("SELECT  `cart_shop_all`.`date` FROM `cart_shop_all` INNER JOIN `location` ON `cart_shop_all`.`code` = `location`.`code` WHERE  `cart_shop_all`.`table`= 'product_savers' AND `location`.`model` = 'savers' AND  `cart_shop_all`.`accountant` = 1 AND `cart_shop_all`.`buy` = 2 AND `cart_shop_all`.`cancel` =0    AND `cart_shop_all`.`code` =? AND {$where} ORDER BY `cart_shop_all`.`id` DESC limit 1");
        $stmt_date->execute(array($code));
        if($stmt_date->rowCount() > 0){
            $row = $stmt_date->fetch(PDO::FETCH_ASSOC);
            $date = date('Y-m-d h:i:s A',$row['date']);
        }else{
            $date = '-';
        }

       return $date;
    }


    //  تاريخ اخر مناقلة الى الحالية في مواقع العرض او الخزن
    function lastTransferViewOrStore($code,$where){
        $date = '';
        $stmt_date =$this->db->prepare("SELECT `date` FROM `location` WHERE  `model`=? AND `new_location` = 1 AND {$where} AND `code` =?  ORDER BY `id` DESC limit 1");
        $stmt_date->execute(array('savers',$code));
        if($stmt_date->rowCount() > 0){
            $row = $stmt_date->fetch(PDO::FETCH_ASSOC);
            $date = date('Y-m-d h:i:s A',$row['date']);
        }else{
            $date = '-';
        }

       return $date;
    }


    // تأريخ اخر عرض
    function lastOffers($code){
        $date = '';
        $stmt_date =$this->db->prepare("SELECT `date` FROM `offers_item` WHERE  `model`=? AND `code` =? ORDER BY `id` DESC limit 1");
        $stmt_date->execute(array('savers',$code));
        if($stmt_date->rowCount() > 0){
            $row = $stmt_date->fetch(PDO::FETCH_ASSOC);
            $date = date('Y-m-d h:i:s A',$row['date']);
        }else{
            $date = '-';
        }

       return $date;
    }


    // تأريخ اخر جرد
    function lastJard($code){
        $stmt_date =$this->db->prepare("SELECT `date`,`userId` FROM `jard` WHERE  `model`=? AND `code` =?  ORDER BY `id` DESC limit 1");
        $stmt_date->execute(array('savers',$code));
        if($stmt_date->rowCount() > 0){
            return $stmt_date->fetch(PDO::FETCH_ASSOC);
        }else{
            return  false;
        }
    }


    // العدد الكلي المباع
    function totalSaleByCat($model,$date_start,$date_end,$cover_material,$type_cover,$feature_cover){
        $date_start = strtotime($date_start);
        $date_end =  strtotime($date_end);
        $quantity = 0;
    	$where = " `product_savers`.`is_delete` = 0 " ;
        if($cover_material != 0){
            $where .=  " AND `product_savers`.`cover_material` = $cover_material";
        }
        if($type_cover != 0){
            $where .=  " AND `product_savers`.`type_cover` = $type_cover";
        }
        if($feature_cover != 0){
            $where .=  " AND `product_savers`.`feature_cover` = $feature_cover";
        }
        $stmt_quantity= $this->db->prepare("SELECT  SUM(`cart_shop_all`.`number`) as num FROM `cart_shop_all` INNER JOIN `product_savers` ON `cart_shop_all`.`code` = `product_savers`.`code` WHERE  `cart_shop_all`.`table`= 'product_savers' AND `cart_shop_all`.`accountant` = 1 AND `cart_shop_all`.`buy` = 2 AND `cart_shop_all`.`cancel` =0 AND `cart_shop_all`.`date` BETWEEN ? AND ? AND `product_savers`.`id_device` = ? AND {$where} ");
        $stmt_quantity->execute(array($date_start,$date_end,$model));
        if($stmt_quantity->rowCount() > 0){
            $row = $stmt_quantity->fetch(PDO::FETCH_ASSOC);
            $quantity = $row['num'];

        }else{
         $quantity = 0;
        }
        echo $quantity;
    }

    // العدد الكلي الداخل
    function totalInsideByCat($model,$date_start,$date_end,$cover_material,$type_cover,$feature_cover){
        $date_start = strtotime($date_start);
        $date_end =  strtotime($date_end);
        $quantity = 0;
    	$where = " `product_savers`.`is_delete` = 0 " ;
        if($cover_material != 0){
            $where .=  " AND `product_savers`.`cover_material` = $cover_material";
        }
        if($type_cover != 0){
            $where .=  " AND `product_savers`.`type_cover` = $type_cover";
        }
        if($feature_cover != 0){
            $where .=  " AND `product_savers`.`feature_cover` = $feature_cover";
        }

        $quant_location_conf= $this->db->prepare("SELECT  SUM(`location_confirm`.`quantity`) as num FROM `location_confirm` INNER JOIN `product_savers` ON `location_confirm`.`code` = `product_savers`.`code` WHERE  `location_confirm`.`model`= 'savers'  AND `location_confirm`.`date` BETWEEN ? AND ? AND `product_savers`.`id_device` = ? AND {$where} ");
        $quant_location_conf->execute(array($date_start,$date_end,$model));
        if($quant_location_conf->rowCount() > 0){
            $row = $quant_location_conf->fetch(PDO::FETCH_ASSOC);
            $quantity = $row['num'];

        }

        $quant_purchase= $this->db->prepare("SELECT  SUM(`purchase_customer_item`.`quantity`) as num FROM `purchase_customer_item` INNER JOIN `product_savers` ON `purchase_customer_item`.`code` = `product_savers`.`code` WHERE  `purchase_customer_item`.`table`= 'savers'  AND `purchase_customer_item`.`date` BETWEEN ? AND ? AND `product_savers`.`id_device` = ? AND {$where}");
        $quant_purchase->execute(array($date_start,$date_end,$model));
        if($quant_purchase->rowCount() > 0){
            $row = $quant_purchase->fetch(PDO::FETCH_ASSOC);

            $quantity += $row['num'];

        }

        echo $quantity;


    }

    // العدد الكلي الحالي
    function totalCurrentByCat($model,$cover_material,$type_cover,$feature_cover){
        $quantity = 0;
    	$where = " `product_savers`.`is_delete` = 0 " ;
        if($cover_material != 0){
            $where .=  " AND `product_savers`.`cover_material` = $cover_material";
        }
        if($type_cover != 0){
            $where .=  " AND `product_savers`.`type_cover` = $type_cover";
        }
        if($feature_cover != 0){
            $where .=  " AND `product_savers`.`feature_cover` = $feature_cover";
        }
        $stmt_quantity= $this->db->prepare("SELECT  SUM(`excel_savers`.`quantity`) as num FROM `excel_savers` INNER JOIN `product_savers` ON `excel_savers`.`code` = `product_savers`.`code` WHERE   `product_savers`.`id_device` = ? AND {$where} ");
        $stmt_quantity->execute(array($model));
        if($stmt_quantity->rowCount() > 0){
            $row = $stmt_quantity->fetch(PDO::FETCH_ASSOC);
            $quantity = $row['num'];

        }else{
         $quantity = 0;
        }
        echo $quantity;
    }

    // العدد الكلي القادم
    function totalNextByCat($model,$cover_material,$type_cover,$feature_cover){
        $quantity = 0;
        $where = " `product_savers`.`is_delete` = 0 " ;
        if($cover_material != 0){
            $where .=  " AND `product_savers`.`cover_material` = $cover_material";
        }
        if($type_cover != 0){
            $where .=  " AND `product_savers`.`type_cover` = $type_cover";
        }
        if($feature_cover != 0){
            $where .=  " AND `product_savers`.`feature_cover` = $feature_cover";
        }
        $stmt_quantity= $this->db->prepare("SELECT  SUM(`purchase_item`.`quantity`) as num FROM `purchase_item` INNER JOIN `product_savers` ON `purchase_item`.`code` = `product_savers`.`code` WHERE   `product_savers`.`id_device` = ? AND {$where} ");
        $stmt_quantity->execute(array($model));
        if($stmt_quantity->rowCount() > 0){
            $row = $stmt_quantity->fetch(PDO::FETCH_ASSOC);
            $quantity = $row['num'];

        }
        echo $quantity;
    }







}