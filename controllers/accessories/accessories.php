<?php

class Accessories extends Controller
{

    public $ids=array();
    public $switch_location=0;


    function __construct()
    {
        parent::__construct();
        $this->table='accessories';
        $this->category='category_accessories';
        $this->color='color_accessories';
        $this->code='code_accessories';
        $this->excel='excel_accessories';
        $this->cart_shop_active='cart_shop_active';
        $this->like_accessories='like_accessories';
        $this->category_accessories_connect='category_accessories_connect';

        $this->menu=new Menu();
        $this->setting=new Setting();
        $this->check_name_category = 0;
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `content` longtext COLLATE utf8_unicode_ci NOT NULL,
           `description` longtext COLLATE utf8_unicode_ci NOT NULL,
          `price` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `id_cat` int(11) NOT NULL,
          `id_main_cat` int(11) NOT NULL,
          `img` bigint(20) NOT NULL DEFAULT '0',
          `view` bigint(20) NOT NULL DEFAULT '0',
          `active` int(11) NOT NULL DEFAULT '0',
          `main_cat` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->category}` (
         `id` int(10) NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `img` int(10) NOT NULL,
           `relid` int (10) NOT NULL,
          `active` int(10) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->color}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
          `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `code_color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `id_item` int(10) NOT NULL,
          `img` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
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


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->like_accessories}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `id_device` int(11) NOT NULL  DEFAULT '0',
          `id_member_r` int(11) NOT NULL,
          `like` int(11) NOT NULL  DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->category_accessories_connect}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `ids` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `active` int(11) NOT NULL DEFAULT '0',
          `userId` int(11) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        return  $this->db->cht(array($this->table, $this->category, $this->color, $this->excel,$this->like_accessories));

    }



    public function index(){ $index =new Index(); $index->index();}



    public function admin_category($id=0)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('View_category','accessories');
        $this->adminHeaderController($this->langControl('View_category'),$id);
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);
        $data=$this->db->select("SELECT * from  {$this->category} WHERE  `relid` = {$id} AND  {$this->is_delete}  ");
        foreach ($data as $key => $dt)
        {

            $data[$key]['checked']= ($dt['active']==1) ? 'checked' : null ;
            if ($dt['img'] !=0) {
                $data[$key]['img'] = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $dt['img'], ':module' => $this->folder.'_cat'));
               if ($data[$key]['img'])
               {
                   $data[$key]['image'] = $this->save_file.$data[$key]['img'][0]['rand_name'];
                   $data[$key]['type_file'] = $data[$key]['img'][0]['file_type'];
                   unset($data[$key]['img']);
               }else
               {
                   $data[$key]['image']="http://placehold.jp/20/cccccc/0000/252x252.png?text={$dt['title']}";

               }

            } else
            {
                $data[$key]['image']="http://placehold.jp/20/cccccc/0000/252x252.png?text={$dt['title']}";
            }
        }
        require ($this->render($this->folder,'cat','admin_category','php'));
        $this->adminFooterController();

    }


    public function list_accessories($id=null)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('view_content','accessories');
        $this->adminHeaderController($this->langControl('view_content'),$id);
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);
        $data_cat=$this->db->select("SELECT * from  {$this->category} WHERE  {$this->is_delete} ");
        foreach ($data_cat as $key => $d_cat)
        {


            if ($d_cat['id']  == $id)
            {
                $d_cat['selected']='selected';

            }else
            {
                $d_cat['selected']=null;
            }
            $data_cat[$key]=$d_cat;
        }


        require ($this->render($this->folder,'html','list','php'));
        $this->adminFooterController();

    }



    function getLoopIdX($id)
    {

        $stmt=$this->db->prepare("SELECT *from  {$this->category} WHERE  `relid` = {$id} AND `active` = 1 AND  {$this->is_delete}  ");
        $stmt->execute(array($id));
        while (  $s=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $this->ids[]=$s['id'];
            $this->getLoopIdX($s['id']);

        }

    }

    function getLoopId($id)
    {

        if (!empty($id))
        {
            $this->ids[]=$id;
        }

        $stmt=$this->db->prepare("SELECT *from  {$this->category} WHERE  `relid` = {$id} AND `active` = 1 AND  {$this->is_delete} ");
        $stmt->execute(array($id));
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {

                $this->ids[]=$row['id'];


            $this->getLoopIdX($row['id']);
        }

           return $this->ids;
      }


    public  function list_all($id=null,$page=1)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $breadcumbs = $this->BreadcumbsPublic($this->category,$id);
        $this->ids[]=$id;
        $stmt=$this->db->prepare("SELECT *from  {$this->category} WHERE  `relid` = {$id} AND `active` = 1 AND  {$this->is_delete}  ORDER BY `id` DESC    ");
        $stmt->execute(array($id));
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $this->ids[]=$row['id'];
            if (!empty($this->getLoopIdX($row['id'])))
            {
                $this->ids[]=  $this->getLoopIdX($row['id']);

            }
        }

        $ids_cat=implode(',', $this->ids);


        $result=$this->db->select("SELECT * from  {$this->category} WHERE  `id` = {$id} AND `active` = 1 AND   {$this->is_delete} ");
        $result=$result[0];
        $stmt=$this->db->prepare("SELECT *FROM `$this->table` WHERE `id_cat` IN ($ids_cat) AND `active` = 1 AND  {$this->is_delete} ");
        $stmt->execute(array($ids_cat));
        $table=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            if ($row['img'] == 0)
            {
                continue;
            }

            $stmt_price=$this->db->prepare("SELECT MIN(price) as min,MAX(price) as max  FROM {$this->size} WHERE `id_item` = ?  ");
            $stmt_price->execute(array($row['id']));
            $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);
            if ($result_price['min']==$result_price['max'])
            {
                $row['price']=  $result_price['min'];
            }else
            {
                $row['price']=$result_price['min'].'  - '.$result_price['max'];
            }

            $table[]=  $row;
        }


        $page_data=array_chunk($table,8);
        $count=count($page_data);
        $data_view=array();
        if (!empty($page_data)) {
            foreach ($page_data[$page - 1] as $row) {
                if ($row['img'] != 0) {
                    $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row['img'], ':module' => $this->folder));
                    $get_file = $get_file[0];
                    $row['img'] = $this->save_file . $get_file['rand_name'];
                } else {
                    $row['img'] = $this->static_file_control . '/image/admin/default.png';
                }
                $data_view[] = $row;
            }
        }


        require ($this->render($this->folder,'html','list_all','php'));
    }


    public  function all_product($page=1)
    {


        $stmt=$this->db->prepare("SELECT *FROM `$this->table` WHERE   `active` = 1 AND  {$this->is_delete}  ORDER BY `id` DESC ");
        $stmt->execute();
        $table=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            if ($row['img'] == 0)
            {
                continue;
            }

            $stmt_price=$this->db->prepare("SELECT MIN(price) as min,MAX(price) as max  FROM {$this->size} WHERE `id_item` = ?  ");
            $stmt_price->execute(array($row['id']));
            $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);
            if ($result_price['min']==$result_price['max'])
            {
                $row['price']=  $result_price['min'];
            }else
            {
                $row['price']=$result_price['min'].'  - '.$result_price['max'];
            }

            $table[]=  $row;
        }


        $page_data=array_chunk($table,8);
        $count=count($page_data);
        $data_view=array();
        if (!empty($page_data)) {
            foreach ($page_data[$page - 1] as $row) {
                if ($row['img'] != 0) {
                    $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row['img'], ':module' => $this->folder));
                    $get_file = $get_file[0];
                    $row['img'] = $this->save_file . $get_file['rand_name'];
                } else {
                    $row['img'] = $this->static_file_control . '/image/admin/default.png';
                }
                $data_view[] = $row;
            }
        }


        require ($this->render($this->folder,'html','all_product','php'));
    }






    public  function list_view($id=null,$page=1)
    {


        $range=false;
        $stmt_range=$this->db->prepare("SELECT *FROM `{$this->excel}` WHERE `range1` <> 0 AND range1 > 0  AND `range2` <> 0 AND range2 > 0 ");
        $stmt_range->execute();
        if ($stmt_range->rowCount() > 0)
        {
            $range=true;
        }


        $stmtCat=$this->db->prepare("SELECT *FROM {$this->category}  WHERE `active` = 1 AND  {$this->is_delete} ");
        $stmtCat->execute();
        $catRange=array();
        while ($row = $stmtCat->fetch(PDO::FETCH_ASSOC))
        {
            $catRange[]=$row;
        }

        if (is_numeric($id)) {

            $breadcumbs = $this->BreadcumbsPublic($this->category, $id);
            $result = $this->db->select("SELECT * from  {$this->category} WHERE  `id` = {$id} AND `active` = 1 AND  {$this->is_delete} ");
            $result = $result[0];

        }

        $specifications=array();

        $stmt_specif=$this->db->prepare("SELECT *FROM `specifications`  WHERE `model`=?");
        $stmt_specif->execute(array($this->folder));

        while ($row = $stmt_specif->fetch(PDO::FETCH_ASSOC))
        {

            $row['items']=array();

            $stmt_item=$this->db->prepare("SELECT *FROM `specifications_item` WHERE `id_specif`=?");
            $stmt_item->execute(array($row['id']));

            while ($row_itm = $stmt_item->fetch(PDO::FETCH_ASSOC))
            {
                $row['items'][]=$row_itm;
            }
            $specifications[]=$row;
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






        require ($this->render($this->folder,'html','view_list','php'));
    }

    function numberItems($id)
    {
        $stmt = $this->db->prepare("SELECT `id`  FROM `{$this->color}` WHERE   `id_item`= ?   AND  {$this->is_delete} ");
        $stmt->execute(array($id));
        return $stmt;
    }




    public function details($id,$id_catg_customer=0)
    {
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }

        $id_catgory ='';
        $stmt = $this->db->prepare("SELECT *FROM {$this->table} WHERE  `id` = ? AND  {$this->is_delete} ");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $breadcumbs = $this->BreadcumbsPublic($this->category, $result['id_cat']);
        $id_catgory = $result['id_cat'];
        $g_c_content = array();
        $id_c = 0;
        $count = 0;
        $g_c = $this->db->prepare("SELECT color_accessories.*,excel_accessories.quantity FROM `color_accessories` INNER JOIN  excel_accessories ON excel_accessories.code = color_accessories.code  WHERE   color_accessories.`id_item`= ? AND color_accessories.`is_delete`= 0 AND excel_accessories.quantity > 0 ");
        $g_c->execute(array($result['id']));
        while ($row = $g_c->fetch(PDO::FETCH_ASSOC)) {

                if ($count == 0) {
                    $id_c = $row['id'];
                }

                $row['image'] = $row['img'];

                $g_c_content[] = $row;
                $count++;

        }



        $content = array();

        $stmt_content = $this->getAllContent();
        while ($row = $stmt_content->fetch(PDO::FETCH_ASSOC))
        {


            $idItemC=array();

            $stmtIdItC=$this->numberItems($row['id']);
            while ($rowiIdIt = $stmtIdItC->fetch(PDO::FETCH_ASSOC))
            {
                $idItemC[]=$rowiIdIt;
            }

            if (!empty($idItemC))
            {

                foreach ($idItemC as $idItc) {

                    $stmt_img_id = $this->getImage($idItc['id'], 1);

                    $row['image'] = $this->save_file . $stmt_img_id['img'];
                    $stmt_price = $this->getPrice($stmt_img_id['code'], 1,$row['price_dollars']);

                    $smt_ch_q = $this->smt_ch_q($stmt_img_id['code'],$stmt_img_id['color']);
                    if ($smt_ch_q->rowCount() > 0) {
                        if (isset($_COOKIE['currency'])) {
                            if ($_COOKIE['currency'] == 0) {
                                $row['price'] = $stmt_price['price'] . ' د.ع ';
                            } else {
                                $row['price'] = $stmt_price['price_dollars'] . '$ ';
                            }

                        } else {
                            $row['price'] = $stmt_price['price'] . ' د.ع ';
                        }


                        $row['code'] = $stmt_img_id['code'];
                        $row['code_color'] = $stmt_img_id['code_color'];
                        $row['color'] = $stmt_img_id['color'];
                        $row['nameImage'] = $stmt_img_id['img'];

                        $row['like'] = $this->ckeckLick($row['id']);

                        $content[] = $row;
                        break;
                    } else {
                        continue;
                    }
                }
            }
        }

        $stmtc=$this->db->prepare("SELECT *FROM {$this->color} WHERE `id_item`=? AND  {$this->is_delete}");
        $stmtc->execute(array($id));
        $color=array();
        while ($row=$stmtc->fetch(PDO::FETCH_ASSOC))
        {

            $stmtlc=$this->db->prepare("SELECT *FROM location WHERE `code`=?  AND model=? ");
            $stmtlc->execute(array($row['code'],$this->folder));
            $row['location']=array();
            while ($rowlc = $stmtlc->fetch(PDO::FETCH_ASSOC))
            {
                $row['location'][]= $rowlc;
            }


            $color[]=$row;
        }



        $stmt = $this->db->prepare("UPDATE `{$this->table}` SET view = view+1 WHERE id = ?");
        $stmt->execute(array($id));

        require ($this->render($this->folder,'html','details','php'));


    }

    public function getAllContent()
    {

        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE   `active` = 1 AND  {$this->is_delete}  ORDER BY `id` DESC LIMIT 5");
        $stmt->execute();
        return $stmt;
    }



    public function getImage($id,$limit)
    {
        $stmt = $this->db->prepare("SELECT id,img,code,`code_color`,`color` FROM `{$this->color}` WHERE   `id`= ? AND  {$this->is_delete}  LIMIT $limit ");
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getImageAndColor($id)
    {
        $stmt = $this->db->prepare("SELECT *FROM `{$this->color}` WHERE   `id_item`= ?   AND  {$this->is_delete}");
        $stmt->execute(array($id));
        return $stmt;
    }



    function price($id)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}

        $stmt= $this->db->prepare("SELECT * from `{$this->size}` WHERE  `id`=?  ");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
       echo  $result['price'];

    }



    function dtl($id,$price_dollars)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}

        $stmt = $this->db->prepare("SELECT {$this->excel}.*  from `{$this->color}` INNER JOIN `{$this->excel}` ON `{$this->excel}`.code=`{$this->color}`.code  WHERE  `{$this->color}`.`id`=? AND  `{$this->color}`.`is_delete`=0  AND`{$this->excel}`.`quantity` > 0  ");
        $stmt->execute(array($id));
        if ($stmt->rowCount()>0)
        {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            require($this->render($this->folder, 'html', 'price', 'php'));

        }else
        {
            echo 'السعر غير معروف';
        }


    }

    public function add_accessories($id=null,$r=null)
    {

        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('add','accessories');
        $this->adminHeaderController($this->langControl('add'),$id);
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);
        $data_cat=$this->db->select("SELECT * from  {$this->category} WHERE {$this->is_delete} ");
        foreach ($data_cat as $key => $d_cat)
        {


            if ($d_cat['id']  == $id)
            {
                $d_cat['checked']='checked';

            }else
            {
                $d_cat['checked']=null;
            }
            $data_cat[$key]=$d_cat;
        }


        $stmt_specif=$this->db->prepare("SELECT *FROM `specifications`  WHERE `model`=?");
        $stmt_specif->execute(array($this->folder));
        $specifications=array();
        while ($row = $stmt_specif->fetch(PDO::FETCH_ASSOC))
        {

            $row['items']=array();

            $stmt_item=$this->db->prepare("SELECT *FROM `specifications_item` WHERE `id_specif`=?");
            $stmt_item->execute(array($row['id']));

            while ($row_itm = $stmt_item->fetch(PDO::FETCH_ASSOC))
            {
                $row['items'][]=$row_itm;
            }
            $specifications[]=$row;
        }



        $data['title']='';
        $data['bast_it']='';
        $data['serial_flag']='';
        $data['price_dollars']='';

		$data['enter_serial'] = '';
        $data['cuts']='';
        $data['price_cuts']='';
        $data['content']='';
        $data['description']='';
        $data['tags']='';
        $data['change_price']=1;
        $data['date']= time();
        $data['is_service'] =0;
        if (isset($_POST['submit']))
        {
            try
            {
                $form =new  Form();

                $form  ->post('title')
                    ->val('is_empty','حقل العنوان فاغ')
                    ->val('strip_tags');

                $form  ->post('content')
                    ->val('is_empty',$this->langControl('the_detail_field_is_empty'))
                    ->val('strip_tags',TAG);
                    $form  ->post('description')
                    ->val('strip_tags',TAG);

                $form  ->post('id_cat')
                    ->val('is_empty','يرجى تحديد قسم')
                    ->val('strip_tags');
                $form  ->post('cuts')
                    ->val('strip_tags');

                $form  ->post('price_cuts')
                    ->val('strip_tags');
                $form  ->post('change_price')
                    ->val('strip_tags');

                $form  ->post('bast_it')
                    ->val('strip_tags');
                $form  ->post('serial_flag')
                    ->val('strip_tags');
                $form  ->post('price_dollars')
                    ->val('strip_tags');

            	$form->post('is_service')
                    ->val('strip_tags');

				$form->post('enter_serial')
					->val('strip_tags');
                $form  ->post('name_color')
                    ->val('is_array')
                    ->val('strip_tags');

                $form  ->post('color')
                    ->val('is_array')
                    ->val('strip_tags');

                $form  ->post('serial')
                    ->val('is_array')
                    ->val('strip_tags');



                $form  ->post('code')
                    ->val('is_array')
                    ->val('strip_tags');
                $form  ->post('point')
                    ->val('is_array')
                    ->val('strip_tags');
                $form  ->post('minimum')
                    ->val('is_array')
                    ->val('strip_tags');
                $form  ->post('maximum')
                    ->val('is_array')
                    ->val('strip_tags');

                $form  ->post('size')
                    ->val('is_array')
                    ->val('strip_tags');

                $form  ->post('date')
                    ->val('is_empty','تحديد الوقت ')
                    ->val('strip_tags');
                $form  ->post('tags')
                    ->val('strip_tags');

                $form  ->post('specifications')
                    ->val('is_array')
                    ->val('strip_tags');

                $form ->submit();
                $data =$form -> fetch();
                if ($r)
                {
                    $data['active']=1;
                }


                if ($data['cuts'] == 1)
                {
                    if (empty($data['price_cuts']))
                    {
                        $this->error_form['price_cuts'] = 'سعر العرض الخاص مطلوب';
                    }

                }
                $form ->submit();
                $data =$form -> fetch();
                $data['date']=strtotime($data['date']);


                $name_color=json_decode($data['name_color'],true);
                $color=json_decode($data['color'],true);
                $code=json_decode($data['code'],true);
                $point=json_decode($data['point'],true);
                $minimum=json_decode($data['minimum'],true);
                $maximum=json_decode($data['maximum'],true);
                $serial=json_decode($data['serial'],true);

                if (!empty($data['specifications']))
                {
                    $specifications = json_decode($data['specifications'], true);
                    $specifications = implode(',', $specifications);
                }else
                {
                    $specifications='';
                }
                if (empty($this->error_form)) {
                    $stmt = $this->db->prepare("INSERT INTO `{$this->table}` (`title`,`id_cat`,`content`,`description`,`date`,`bast_it`,`serial_flag`,`price_dollars`,`tags`,`cuts`,`price_cuts`,`specifications`,`enter_serial`,`change_price`,`userId`,`is_service`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $stmt->execute(array($data['title'], $data['id_cat'], $data['content'],$data['description'], $data['date'], $data['bast_it'],$data['serial_flag'],$data['price_dollars'], $data['tags'], $data['cuts'], $data['price_cuts'], $specifications, $data['enter_serial'], $data['change_price'],$this->userid,$data['is_service']));
                    $lastId = $this->db->lastInsertId();

                    $image = array();
                    if (empty($this->check_file($_FILES['image'], 'صور مطلوبة', array('jpg', 'jpeg', 'png')))) {
                        $image = $this->save_file($_FILES['image']);
                    } else {
                        $this->error_form['image'] = $this->check_file($_FILES['image'], 'صور مطلوبة', array('jpg', 'jpeg', 'png'));
                    }

                    foreach ($name_color as $key => $save_data) {
                        $stmt_c = $this->db->prepare("INSERT INTO `{$this->color}` (`code`,`point`,`minimum`,`maximum`,`color`,`code_color`,`serial`,`id_item`,`img`,`date`) VALUE (?,?,?,?,?,?,?,?,?,?)");
                        $stmt_c->execute(array($code[$key], trim($point[$key]),$minimum[$key],  $maximum[$key], $save_data, $color[$key],$serial[$key], $lastId, $image[$key], time()));
                    }

					$trace=new trace_site();
					$newData=$trace->neaw($lastId,$this->folder);
					$trace->add($lastId,$this->folder,'add','',$data['title'],'',$newData);
					$this->Add_to_sync_schedule($lastId,"accessories","add_accessories");

                    if ($r)
                    {
                        $this->lightRedirect(url . "/purchase_customer/purchase", 0);
                    }else
                    {
					$this->lightRedirect(url . "/accessories/list_accessories/{$id}", 0);
                   }
                }

            }catch (Exception $e)
            {
                $data =$form -> fetch();
                $data['date']=strtotime($data['date']);
                $this->error_form= json_decode($e -> getMessage(),true);

            }

        }

        require ($this->render($this->folder,'html','add','php'));
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




    public function edit_accessories($id)
    {
        $this->checkPermit('edit', 'accessories');
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }
        $files = new Files();
        $this->adminHeaderController($this->langControl('edit'));

        $data = $this->db->select("SELECT * from `{$this->table}` WHERE `id`=:id LIMIT 1 ", array(':id' => $id));
        $data = $data[0];
		$oldTitle=$data['title'];
        $breadcumbs = $this->Breadcumbs($this->category, $data['id_cat']);


        $specifications_id=explode(',',$data['specifications']);

        $stmt_specif=$this->db->prepare("SELECT *FROM `specifications`  WHERE `model`=?");
        $stmt_specif->execute(array($this->folder));
        $specifications=array();
        while ($row = $stmt_specif->fetch(PDO::FETCH_ASSOC))
        {
            $row['items']=array();

            $stmt_item=$this->db->prepare("SELECT *FROM `specifications_item` WHERE `id_specif`=?");
            $stmt_item->execute(array($row['id']));

            while ($row_itm = $stmt_item->fetch(PDO::FETCH_ASSOC))
            {
                $row['items'][]=$row_itm;
            }
            $specifications[]=$row;
        }


        $stmt_color = $this->db->prepare("SELECT *FROM `{$this->color}` WHERE `id_item` = ? AND is_delete=0");
        $stmt_color->execute(array($id));
        $color = array();
        $image = array();
        while ($row = $stmt_color->fetch(PDO::FETCH_ASSOC))
        {
            $image[$row['id']]= $row['img'];
            $color[]=$row;
        }

        $stmt_last_id = $this->db->prepare("SELECT `id` FROM `{$this->color}` WHERE `id_item` = ? ORDER BY `id` DESC  LIMIT 1");
        $stmt_last_id->execute(array($id));
        $last_id=$stmt_last_id->fetch(PDO::FETCH_ASSOC)['id'];


        $data_cat=$this->db->select("SELECT * from  {$this->category}  ");
        foreach ($data_cat as $key => $d_cat)
        {
            if ($d_cat['id']  == $data['id_cat'])
            {
                $d_cat['checked']='checked';
            }else
            {
                $d_cat['checked']=null;
            }
            $data_cat[$key]=$d_cat;
        }


        if (isset($_POST['submit']))
        {
			$trace=new trace_site();
			$oldData=$trace->old($id,$this->folder);


			try
            {
                $form =new  Form();

                $form  ->post('title')
                    ->val('is_empty','حقل العنوان فاغ')
                    ->val('strip_tags');


                $form  ->post('content')
                    ->val('is_empty',$this->langControl('the_detail_field_is_empty'))
                    ->val('strip_tags',TAG);

                $form  ->post('description')
                    ->val('strip_tags',TAG);


                $form  ->post('id_cat')
                    ->val('is_empty','يرجى تحديد قسم')
                    ->val('strip_tags');


                $form  ->post('bast_it')
                    ->val('strip_tags');
                $form  ->post('serial_flag')
                    ->val('strip_tags');
                $form  ->post('price_dollars')
                    ->val('strip_tags');

            	 $form->post('is_service')
                    ->val('strip_tags');

				$form->post('enter_serial')
					->val('strip_tags');

                $form  ->post('cuts')
                    ->val('strip_tags');

                $form  ->post('price_cuts')
                    ->val('strip_tags');

                $form  ->post('change_price')
                    ->val('strip_tags');


                $form  ->post('name_color')
                    ->val('is_array')
                    ->val('strip_tags');

                $form  ->post('color')
                    ->val('is_array')
                    ->val('strip_tags');

                $form  ->post('code')
                    ->val('is_array')
                    ->val('strip_tags');
                $form  ->post('point')
                    ->val('is_array')
                    ->val('strip_tags');
                $form  ->post('minimum')
                    ->val('is_array')
                    ->val('strip_tags');
                $form  ->post('maximum')
                    ->val('is_array')
                    ->val('strip_tags');

                $form  ->post('size')
                    ->val('is_array')
                    ->val('strip_tags');
                $form  ->post('serial')
                    ->val('is_array')
                    ->val('strip_tags');



                $form  ->post('date')
                    ->val('is_empty','تحديد الوقت ')
                    ->val('strip_tags');

                $form  ->post('tags')
                    ->val('strip_tags');

                $form  ->post('specifications')
                    ->val('is_array')
                    ->val('strip_tags');

                $form ->submit();
                $data =$form -> fetch();

                if ($data['cuts'] == 1)
                {
                    if (empty($data['price_cuts']))
                    {
                        $this->error_form['price_cuts'] = 'سعر العرض الخاص مطلوب';
                    }

                }
                $form ->submit();
                $data =$form -> fetch();
                $data['date']=strtotime($data['date']);


                $name_color=json_decode($data['name_color'],true);
                $color_inst=json_decode($data['color'],true);
                $code=json_decode($data['code'],true);
                $point=json_decode($data['point'],true);
                $minimum=json_decode($data['minimum'],true);
                $maximum=json_decode($data['maximum'],true);
                $size=json_decode($data['size'],true);
                $serial=json_decode($data['serial'],true);

                if (!empty($data['specifications']))
                {
                    $specifications = json_decode($data['specifications'], true);
                    $specifications = implode(',', $specifications);
                }else
                {
                    $specifications='';
                }
                ;


                $image_new=array();

                $image_new = $this->save_file($_FILES['image']);


                foreach ($image_new as $key=> $img)
                {
                    $image[$key] = $image_new[$key];
                }

                if (empty($this->error_form)) {

                    $stmt = $this->db->prepare("UPDATE   `{$this->table}` SET  `title`=? ,  `content`=? ,  `description`=? , `id_cat`=? ,`date`=? ,`bast_it`=? ,`serial_flag`=? ,`price_dollars`=?,`tags`=? ,`cuts`=? ,`price_cuts`=? ,`specifications`=?   ,`enter_serial`=?  ,`change_price`=?  ,`userId`=? ,`is_service`=? WHERE `id`=?");
                    $stmt->execute(array($data['title'], $data['content'],$data['description'], $data['id_cat'], $data['date'], $data['bast_it'], $data['serial_flag'], $data['price_dollars'], $data['tags'], $data['cuts'], $data['price_cuts'], $specifications,$data['enter_serial'],$data['change_price'], $this->userid,$data['is_service'],$id));


                    foreach ($name_color as $key => $save_data) {

                        $stmt_c = $this->db->prepare("INSERT INTO `{$this->color}` (`id`,`code`,`point`,`minimum`,`maximum`,`color`,`code_color`,`serial`,`img`,`id_item`,`date`) VALUE (?,?,?,?,?,?,?,?,?,?,?)  ON DUPLICATE KEY UPDATE `id`=VALUES(id),`code`=VALUES(code),`point`=VALUES(point),`minimum`=VALUES(minimum),`maximum`=VALUES(maximum),`color`=VALUES(color),`code_color`=VALUES(code_color),`serial`=VALUES(serial),`img`=VALUES(img),`id_item`=VALUES(id_item)");
                        $stmt_c->execute(array($key, $code[$key],$point[$key],  $minimum[$key],$maximum[$key], $save_data, $color_inst[$key],  $serial[$key], $image[$key], $id, time()));
                    }


					$trace=new trace_site();
					$newData=$trace->neaw($id,$this->folder);
					$trace->add($id,$this->folder,'edit',$oldTitle,$data['title'],$oldData,$newData);
					$this->Add_to_sync_schedule($id,"accessories","add_accessories");


					$this->lightRedirect(url . "/accessories/list_accessories/{$data['id_cat']}", 0);
                }

            }catch (Exception $e)
            {
                $data =$form -> fetch();
                $data['date']=strtotime($data['date']);
                $this->error_form= json_decode($e -> getMessage(),true);

            }

        }


        require ($this->render($this->folder,'html','edit','php'));
        $this->adminFooterController();

    }








	public function processing($id)
	{


		$table = $this->table;
		$primaryKey = 'id';

		$columns = array(



			array( 'db' => 'title', 'dt' => 0 ),
			array( 'db' => 'id', 'dt' =>  1 ,
				'formatter' => function( $d, $row ) {
					return $this->details_acc($d);
				}

			),
			array( 'db' => 'date', 'dt' =>  2 ,
				'formatter' => function( $d, $row ) {
					return date( 'Y-m-d ', $d);
				}

			),
			array(
				'db'        => 'id',
				'dt'        => 3,
				'formatter' => function($id, $row ) {
					if ($this->permit('visible',$this->folder)) {
						return "
                <div style='text-align: center'>
                  <input {$this->ch($id)} class='toggle-demo' onchange='visible_accessories(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
					else
					{
						return $this->langControl('forbidden');
					}
				}
			),
			array( 'db' => 'view', 'dt' => 4 ),
			array(
				'db'        => 'id',
				'dt'        => 5,
				'formatter' => function($id, $row ) {
					return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=".url."/accessories/edit_accessories/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
				}
			),
            array( 'db' => 'id', 'dt' => 6,
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
				'db'        => 'id',
				'dt'        =>7,
				'formatter' => function($id, $row ) {
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
            array(  'db' => 'id_cat', 'dt'=>8),
			array(  'db' => 'id', 'dt'=>9),



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
			SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns ,"id_cat={$id} AND {$this->is_delete} ")
		);

	}



    function copy_row($id)
    {

        $stmt=$this->db->prepare("INSERT  INTO  accessories ( content, title, id_cat, id_main_cat, img, view, main_cat, date, bast_it, tags, specifications, cuts, price_cuts, description,  serial_flag, price_dollars, location, enter_serial,  change_price,is_delete,  active,userId)  SELECT  content, title, id_cat, id_main_cat, img, view, main_cat, date, bast_it, tags, specifications, cuts, price_cuts, description, serial_flag, price_dollars, location, enter_serial, change_price, is_delete,0,$this->userid FROM  accessories  WHERE id=?");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            echo  $this->db->lastInsertId();
        }
    }






	function details_acc($id)
	{

		$stmt=$this->db->prepare("SELECT color_accessories.*,excel_accessories.quantity FROM `color_accessories` left   JOIN excel_accessories ON color_accessories.code=excel_accessories.code WHERE color_accessories.id_item=? AND  color_accessories.is_delete=0");
		$stmt->execute(array($id));
		$html="
		<table class='table table-bordered' style='background: #fff;margin: 0;padding: 0'><tbody>";
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$html .= "
		 <tr>
        <td style='padding: 0;    vertical-align: unset;background: #ffffff'>   {$row['color']}   </td>
        <td style='padding: 0;    vertical-align: unset;background: #ffffff''> {$row['code']} </td>
        <td style='padding: 0;    vertical-align: unset;background: #ffffff''> {$row['quantity']} </td>
        <td style='padding: 0;    vertical-align: unset;background: #ffffff''>  <img width='100' src='{$this->save_file}/{$row['img']}'>  </td>

           </tr>
			";

		}

		$html.="</tbody> </table>";


		return $html;
	}




	public function visible_accessories($v_,$id_)
    {
        if ($this->handleLogin()) {
            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }

			$stmt=$this->db->prepare("SELECT  *FROM `{$this->table}` WHERE `id`  = ?   AND  {$this->is_delete}  " );
			$stmt->execute(array($id));
			$result=$stmt->fetch(PDO::FETCH_ASSOC);

			$trace=new trace_site();
			$oldData=$trace->old($id,$this->folder);

			$data = $this->db->update($this->table, array('active' => $v), "`id`={$id}");
        	$this->Add_to_sync_schedule($id,$this->folder,'add_accessories');

			$newData=$trace->neaw($id,$this->folder);
			$trace->add($id,$this->folder,'active',$result['title'],$result['title'],$oldData,$newData);

        }
    }


	public function visible_accessories_location($v_,$id_)
    {
        if ($this->handleLogin()) {
            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }

			$stmt=$this->db->prepare("SELECT  *FROM `{$this->table}` WHERE `id`  = ?   " );
			$stmt->execute(array($id));
			$result=$stmt->fetch(PDO::FETCH_ASSOC);

			$trace=new trace_site();
			$oldData=$trace->old($id,$this->folder);

			$data = $this->db->update($this->table, array('location' => $v), "`id`={$id}");

			$newData=$trace->neaw($id,$this->folder);
			$trace->add($id,$this->folder,'active',$result['title'],$result['title'],$oldData,$newData);
         echo $v;
        }
    }


    function delete_accessories($id)
    {
        if ($this->handleLogin()) {


			$stmt=$this->db->prepare("SELECT  *FROM `{$this->table}` WHERE `id`  = ? AND {$this->is_delete}  " );
			$stmt->execute(array($id));
			$result=$stmt->fetch(PDO::FETCH_ASSOC);

        	$stmt_codes_sync=$this->db->prepare("SELECT id , code FROM `color_accessories` where id_item =?");
            $stmt_codes_sync->execute(array($id));

            $check_codes="( ";
            while($row_codes = $stmt_codes_sync->fetch(PDO::FETCH_ASSOC))
            {
                $check_codes.='"'.$row_codes['code'].'",';
            	$this->update_code('color_accessories',$row_codes['code'],$row_codes['id']);
            }

        	 $check_codes=substr($check_codes,0,-1).')';
        	 $this->Add_to_sync_schedule($id,'accessories','delete_item_accessories', $check_codes);


			$trace=new trace_site();
			$oldData=$trace->old($id,$this->folder);
			$trace->add($id,$this->folder,'delete',$result['title'],$result['title'],$oldData,'');


			// $response = $this->db->delete($this->table, "`id`={$id}");
        	$this->update_is_delete($this->table, 'id = '.$id.'');

            $c_id = $this->db->prepare("SELECT `id` FROM `$this->color`  WHERE  `id_item`=? limit 1");
            $c_id->execute(array($id));
            $c_id_c = $c_id->fetch(PDO::FETCH_ASSOC)['id'];

            // $c = $this->db->prepare("DELETE FROM `$this->color`  WHERE  `id_item`=?");
            // $c->execute(array($id));

        	$this->update_is_delete($this->color, 'id_item = '.$id.'');

            // $cd = $this->db->prepare("DELETE FROM `$this->code`  WHERE  `id_color`=?");
            // $cd->execute(array($c_id_c));
        }

    }



    function delete_from_db_sub_item($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->size, "`id`={$id}");
            echo 'true';
        }
    }

    function remove_color_from_db($id)
    {
        if ($this->handleLogin() ) {
        	$this->update_is_delete($this->color, 'id = '.$id.'');
            // $response = $this->db->delete($this->color, "`id`={$id}");
            // echo 'true';
        }
    }

    public function ch($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `active` = 1 AND {$this->is_delete} ");
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


    public function ch_location($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `location` = 1 AND  {$this->is_delete} ");
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




    public function select_category_accessories($id)
    {
        $stmt=$this->db->prepare("SELECT * from  {$this->category} WHERE `relid`=? AND {$this->is_delete} ");
        $stmt->execute(array($id));
        return $stmt;
    }

    public function ck_sub_cat($id)
    {
        $stmt=$this->db->prepare("SELECT * from  {$this->category} WHERE `relid`=? AND  {$this->is_delete} ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            return true;
        }else
        {
            return false;
        }
    }

    public function listSubCategory($relid,$id=null)
    {

        $stmt = $this->db->prepare("SELECT * FROM `{$this->category}` WHERE relid = ? AND  {$this->is_delete} ");
        $stmt->execute(array($relid));
        while ($row = $stmt->fetch()) {
            require ($this->render($this->folder,'cat','sub_cat','php'));
        }
    }



    public function sub_cat_active($r_id,$id=null)
    {

        if ($id==null)
        {
            return 'close_this_accessories';
        }
        $stmt=$this->db->prepare("SELECT * from  `$this->category`  WHERE `id`=? AND {$this->is_delete}  ");
         $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            if ($r_id==$id || $result['relid'] == $r_id)
            {

                return 'accessories';
            }
            else
            {
                return 'close_this_accessories';
            }

        }
        else
        {

            return 'close_this_accessories';
        }


    }


//-----------------category------------------

     function add_category($id=0)
    {
        $this->checkPermit('add_category','accessories');
        if (!is_numeric($id)){  $error=new Errors();  $error ->index();}

        $breadcumbs = $this ->Breadcumbs( $this->category,$id);


        $this->adminHeaderController($this->lang('accessories'),$id);
        $data['title']='';
        $data['files']='';
        $data['order_cat']='';
        $data['code_cat']='';
        $data['id_device']='';



        $stmt_device_name = $this->db->prepare("SELECT *FROM `menu_link_device_acc_cover` ");
        $stmt_device_name->execute();
        $device_name= array();
        while ($row = $stmt_device_name->fetch(PDO::FETCH_ASSOC)) {
            $device_name[] = $row;
        }





        if (isset($_POST['submit']))
        {
            try{
                $form =new Form();
                $form  ->post('title')
                    ->val('is_empty','العنوان فارغ')
                    ->val('strip_tags');


                if (array_key_exists('اللواصق',$breadcumbs))
                {

                $form  ->post('id_device')
                  //  ->val('is_empty',' نوع الجهاز مطلوب ')
                    ->val('strip_tags');
                }


                $form  ->post('order_cat')
                    ->val('strip_tags');

                $form  ->post('code_cat')
                    ->val('strip_tags');
                $form  ->post('files')
                    ->val('strip_tags');

                $form ->submit();
                $data =$form -> fetch();
                $data['relid']=$id;
                $data['date']=time();
                $file=new Files();

                $this->db->insert($this->category,array_diff_key($data,['files'=>"delete"]));
				$id_cat_h = $this->db->lastInsertId();
                if(!empty($data['files'])) {
                    $img = $file->insert_file($this->folder.'_cat', $this->db->lastInsertId(), json_decode($data['files'], True));
                    $this->db->update($this->category, array('img' => $img), "id={$this->db->lastInsertId()}");
                }
            	$this->Add_to_sync_schedule($id_cat_h,'accessories','add_category');


                $this->lightRedirect(url.'/'.$this->folder."/admin_category/{$id}",0,1);
            }
            catch (Exception $e)
            {

                $data =$form -> fetch();
                $this->error_form= json_decode($e -> getMessage(),true);
            }

        }



        require ($this->render($this->folder,'cat','add','php'));
        $this->adminFooterController();

    }





    function edit_category($id)
    {

        $this->checkPermit('edit_category','accessories');
        $data=$this->db->select("SELECT * from {$this->category} WHERE `id`=:id LIMIT 1 ",array(':id'=>$id));
        $data=$data[0];
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);
        $this->adminHeaderController($this->lang($data['title']),$id);
        $idImg=0;
        if ( $data['img'] !=0) {
            $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $data['img'], ':module' => $this->folder.'_cat'));
            $get_file = $get_file[0];
            $idImg = $get_file['id'];
        }


        $stmt_device_name = $this->db->prepare("SELECT *FROM `menu_link_device_acc_cover` ");
        $stmt_device_name->execute();
        $device_name= array();
        while ($row = $stmt_device_name->fetch(PDO::FETCH_ASSOC)) {
            $device_name[] = $row;
        }




        if (isset($_POST['submit']))
        {

            try
            {
                $form =new Form();
                $form ->post('title')
                    ->val('is_empty','عنوان القسم فارغ')
                    ->val('strip_tags');
                $form  ->post('order_cat')
                    ->val('strip_tags');


                if (array_key_exists('اللواصق',$breadcumbs))
                {
                    $form  ->post('id_device')
                        //    ->val('is_empty',' نوع الجهاز مطلوب ')
                        ->val('strip_tags');
                }



                $form  ->post('code_cat')
                    ->val('strip_tags');
                $form ->post('files')
                    ->val('strip_tags');

                $form ->submit();
                $data =$form -> fetch();
                if (!empty($data['files']))
                {
                    if ($idImg != 0)
                    {
                        @unlink($this->root_file.$get_file['rand_name']);
                        $this->db->delete('files',"id={$get_file['id']}");
                    }
                    $file=new Files();
                    $data['img']= $file->insert_file( $this->folder.'_cat',$id,json_decode($data['files'],True));
                }
                else
                {
                    $data['img']=$idImg;
                }
                if ($this->permit('save_edit_catg',$this->folder)) {
                    $this->db->update($this->category, array_diff_key($data, ['files' => "delete"]), "id={$id}");
					$this->Add_to_sync_schedule($id,'accessories','add_category');
                    $this->lightRedirect(url . '/' . $this->folder . "/admin_category", 0,1);
                }
            }
            catch (Exception $e)
            {
                $this->error_form= json_decode($e -> getMessage(),true);
            }
        }
        require ($this->render($this->folder,'cat','edit','php'));
        $this->adminFooterController();
    }



    public function visible($v_,$id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v=$v_;$id=$id_;
        } else {
            $v = 0;$id = 0;
        }
        $data = $this->db->update($this->category,array('active'=>$v), "`id`={$id}");
    }





    function delete($id)
    {

        if ($this->handleLogin()) {

            $trace = new trace_site();
            $oldData = $trace->trace_category($id, $this->category);
            $trace->add($id, $this->category, 'delete', $trace->inforow($id, $this->category, 'title'), '', $oldData, '');

            // $response = $this->db->delete($this->category,"`id`={$id}");
            // echo $response;


            $this->update_is_delete($this->category, 'id = ' . $id . '');
            $stmt_item = $this->db->prepare("SELECT id FROM `$this->table` where id_cat = $id ");
            $stmt_item->execute();
            if ($stmt_item->rowCount() > 0) {
                while ($row_item = $stmt_item->fetch()) {
                    $this->update_is_delete($this->table, 'id = ' . $row_item['id'] . '');
					 $stmt_codes=$this->db->prepare("SELECT id,code FROM `$this->color` where id_item =?");
                    $stmt_codes->execute(array($row_item['id']));
                    while($row_codes = $stmt_codes->fetch(PDO::FETCH_ASSOC))
                    {
                        $this->update_code($this->color,$row_codes['code'],$row_codes['id']);
                    }
                	$this->update_is_delete($this->color, 'id_item = ' . $row_item['id'] . '');
                }
            }

            $stmt_child_cate = $this->db->prepare("SELECT id FROM `$this->category` where relid = $id AND is_delete = 0 ");
            $stmt_child_cate->execute();
            while ($row_cate = $stmt_child_cate->fetch(PDO::FETCH_ASSOC)) {
                $this->delete($row_cate['id']);
            }


            $this->Add_to_sync_schedule($id, 'accessories', 'delete_category');
        }
    }


    function delete_image_cat($id)
    {
        if ($this->handleLogin())
        {
            $response = $this->db->update($this->category,array('img'=>0),"`id`={$id}");
            echo $response ;
        }

    }







    public function get_all_category( )
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->category}` WHERE  `active` =? AND `relid`=0 AND {$this->is_delete} ORDER BY `id` ASC ");
        $stmt->execute(array(1));
        return $stmt;
    }

    public function getAllaccessoriesFromContent($id_cat = array(), $limit)
    {
        $Id_cat = implode(',', $id_cat);
        $stmt = $this->db->query("SELECT {$this->table}.* FROM `{$this->table}`  INNER JOIN color_accessories ON color_accessories.id_item = {$this->table}.id INNER JOIN excel_accessories ON excel_accessories.code = color_accessories.code WHERE  {$this->table}.`id_cat` IN ({$Id_cat})   AND {$this->table}.`active` = 1 AND {$this->bast_it} AND {$this->excel}.quantity > 0 AND {$this->table}.is_delete=0 GROUP BY {$this->table}.id   ORDER BY {$this->table}.`date` DESC LIMIT $limit");
        return $stmt;
    }







    public function getPrice($code,$limit,$price_dollars)
    {

        $stmt2 = $this->db->prepare("SELECT *  FROM `{$this->excel}` WHERE   `code`= ?   LIMIT {$limit} ");
        $stmt2->execute(array($code));
        $result_ = $stmt2->fetch(PDO::FETCH_ASSOC);
        if ($this->loginUser() )
        {
            $price= $this->price_dollarsAdmin($result_['price_dollars']);
            return array('price'=>$price,'price_dollars'=>$result_['price_dollars'],'code'=>$result_['code'],'quantity'=>$result_['quantity']);
        }else
        {
            if ($price_dollars==1)
            {
                $price= $this->price_dollars($result_['price_dollars']);
            }else
            {
                $price=$result_['price'];
            }
            return array('price'=>$price,'price_dollars'=>$result_['price_dollars'],'code'=>$result_['code'],'quantity'=>$result_['quantity']);
        }



    }


    public function smt_ch_q($code,$color=null)
    {

        $stmt = $this->db->prepare("SELECT *FROM `{$this->excel}` WHERE   `code`= ?  AND  `quantity` > 0");
        $stmt->execute(array($code));
       return $stmt;
    }



    public function select_category_accessories_public($id)
    {
        $stmt=$this->db->prepare("SELECT * from  `$this->category` WHERE `relid`=?  AND `active`=1 AND {$this->is_delete}  ORDER BY `order_cat` ASC");
        $stmt->execute(array($id));
        return $stmt;
    }


    public function select_category_news($id)
    {
        $stmt=$this->db->prepare("SELECT * from  `$this->category` WHERE `relid`=?  AND `active`=1 AND {$this->is_delete}");
        $stmt->execute(array($id));
        return $stmt;
    }

    public function ck_sub_cat_public($id)
    {
        $stmt=$this->db->prepare("SELECT * from   `$this->category`  WHERE `relid`=?  AND `active`=1  AND  {$this->is_delete} ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            return true;
        }else
        {
            return false;
        }
    }



    public function listSubCategoryMenu($relid)
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->category}` WHERE relid = ?   AND `active`=1  AND  {$this->is_delete} ");
        $stmt->execute(array($relid));
        while ($row = $stmt->fetch()) {


            if ($this->ck_sub_cat_public($row['id'])) {?>

                <li class="dropdown-submenu rotate_this_active">
                    <a class="dropdown-item dropdown-toggle" href="<?php  echo url .'/'. $this->folder?>/list_view/<?php echo $row['id']?>"><?php echo $row['title']?></a>
                    <ul class="dropdown-menu">
                        <?php $this ->listSubCategoryMenu($row['id']); ?>
                    </ul>
                </li>
            <?php    } else{  ?>
                <li class="dropdown-submenu">
                    <a class="dropdown-item" href="<?php  echo url .'/'. $this->folder?>/list_view/<?php echo $row['id']?>"><?php echo $row['title']?></a>
                </li>
            <?php  }
        }  ?>


        <?php

    }



    public function listSubCategoryMenu2($relid)
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->category}` WHERE relid = ?   AND `active`=1  AND  {$this->is_delete} ");
        $stmt->execute(array($relid));
        while ($row = $stmt->fetch()) {


            if ($this->ck_sub_cat_public($row['id'])) {?>


                <div class="sub_cat">
                        <div class="custom-control custom-checkbox">
                            <input  value="<?php echo $row['id'] ?>"  type="checkbox" id="cat_<?php echo $row['id'] ?>" name="id_cat[]"  class="custom-control-input">
                            <label class="custom-control-label" for="cat_<?php echo $row['id'] ?>"><?php echo $row['title'] ?></label>
                        </div>

                        <?php $this ->listSubCategoryMenu2($row['id']); ?>
                </div>

            <?php    } else{  ?>
                <div class="sub_cat">
                <div class="custom-control custom-checkbox">
                    <input  value="<?php echo $row['id'] ?>"  type="checkbox" id="cat_<?php echo $row['id'] ?>" name="id_cat[]"  class="custom-control-input">
                    <label class="custom-control-label" for="cat_<?php echo $row['id'] ?>"><?php echo $row['title'] ?></label>
                </div>
                </div>

            <?php  }
        }  ?>


        <?php

    }



    public function listSubCategoryMenu_acc($relid)
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->category}` WHERE relid = ?   AND `active`=1  AND  {$this->is_delete} ");
        $stmt->execute(array($relid));
        while ($row = $stmt->fetch()) {


            if ($row['img'] !=0) {
                $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row['img'], ':module' => 'accessories_cat'));
                $get_file = $get_file[0];
                $row['image'] ='<img class="ion_catg" src="'.$this->save_file.$get_file['rand_name'].'">';

            } else
            {
                $row['image']= '<i class="fa fa-diamond"></i>';
            }
            if ($this->ck_sub_cat_public($row['id'])) {?>


                <div id="accordion_sub_<?php echo $row['id'] ?>">
                    <div class="card row_accordion">
                        <div class="card-header" id="headingOne1<?php echo $row['id'] ?>">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-<?php if ($this->ck_sub_cat_public($row['id'])) echo 9;  else echo 12 ;?>">
                                    <a  class="list_link" href="<?php  echo url ?>/accessories/list_view/<?php echo $row['id'] ?>" >
                                        <div class="row align-items-center">
                                            <div class="col-auto" style="padding-left: 3px" >  <?php  echo $row['image']?>  </div>
                                            <div class="col-9" style="padding-right: 3px;padding-left: 1px" > <?php echo $row['title'] ?> </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-3" style="padding-right: 1px">
                                    <button class="btn btn_open_accordion collapsed"   data-toggle="collapse" href="#collapseOne1<?php echo $row['id'] ?>" aria-expanded="false" aria-controls="collapseOne1<?php echo $row['id'] ?>">
                                        <i class="fa fa-caret-left"></i>
                                    </button>
                                </div>
                            </div>

                            <div id="collapseOne1<?php echo $row['id'] ?>" class="collapse" data-parent="#accordion_sub_<?php echo $row['id'] ?>" aria-labelledby="headingOne1<?php echo $row['id'] ?>">
                                <div class="card-body">

                                    <div class="card row_accordion">

                                        <?php $this ->listSubCategoryMenu_acc($row['id']); ?>

                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php    } else{  ?>




                <div id="accordion_sub_<?php echo $row['id'] ?>">
                    <div class="card row_accordion">
                        <div class="card-header" id="headingOne1<?php echo $row['id'] ?>">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-<?php if ($this->ck_sub_cat_public($row['id'])) echo 9;  else echo 12 ;?>">
                                    <a  class="list_link" href="<?php  echo url ?>/accessories/list_view/<?php echo $row['id'] ?>" >
                                        <div class="row align-items-center">
                                            <div class="col-auto" style="padding-left: 3px" >  <?php  echo $row['image']?>   </div>
                                            <div class="col-<?php if ($this->ck_sub_cat_public($row['id'])) echo 9;else echo 10 ?>" style="padding-right: 3px;padding-left: 1px" >  <?php echo $row['title'] ?> </div>
                                        </div>
                                    </a>
                                </div>
                                <?php if ($this->ck_sub_cat_public($row['id'])) { ?>
                                    <div class="col-3" style="padding-right: 1px">
                                        <button class="btn btn_open_accordion collapsed"   data-toggle="collapse" href="#collapseOne1<?php echo $row['id'] ?>" aria-expanded="false" aria-controls="collapseOne1<?php echo $row['id'] ?>">
                                            <i class="fa fa-caret-left"></i>
                                        </button>
                                    </div>
                                <?php  } ?>
                            </div>

                        </div>
                    </div>
                </div>

            <?php  }
        }  ?>


        <?php

    }





         function getAllItemByIdCat($id,$limit=5)
         {

         }





    function remove_row_database($id)
    {
        if ($this->handleLogin() ) {

            $this->update_is_delete($this->color, 'id = '.$id.'');

            // $c= $this->db->prepare("DELETE FROM `$this->color`  WHERE  `id`=?");
            // $c->execute(array($id));

            // $c= $this->db->prepare("DELETE FROM `$this->code`  WHERE  `id_color`=?");
            // $c->execute(array($id));
            // echo true;
        }
    }


    function remove_sub_row_database($id)
    {
        if ($this->handleLogin() ) {

            $c= $this->db->prepare("DELETE FROM `$this->code`  WHERE  `id`=?");
            $c->execute(array($id));
            echo true;
        }
    }



    public function getAllContentFromCar_new($id_member_r)
    {
        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date` FROM `{$this->cart_shop_active}` WHERE `id_member_r` =?  AND `buy` = 0 GROUP BY `id_item`,`size`,`table`,`price`,`name_color` ORDER BY `id`  DESC  ");
        $stmt->execute(array($id_member_r));
        return $stmt;
    }

    /*
    *هذه الدالة تتحقق اذا كانت الفئة لواصق
    *create by NAI
    * 2022/07/04
    */
     public function check_id_catge($id){
        $stmt_catg_acc = $this->db->prepare("SELECT * FROM `category_accessories` WHERE id = ? LIMIT 1");
        $stmt_catg_acc->execute(array($id));


        if ($stmt_catg_acc->rowCount() > 0){
            $row_catg_acc = $stmt_catg_acc->fetch(PDO::FETCH_ASSOC);
            if($row_catg_acc['title'] == 'اللواصق'){
                $this->check_name_category = 1;
            }elseif(($row_catg_acc['title'] != 'اللواصق')&& ($row_catg_acc['relid'] == 0)){
                $this->check_name_category = 0;
            }else{
                $this->check_id_catge($row_catg_acc['relid']);
            }
        }
        return  $this->check_name_category;
    }

    function car_item($id,$id_catgory=0,$id_catg_customer=0,$count)
    {


        $error=array();

            if (!is_numeric($id)) {$error=new Errors(); $error->index();}



            if (!empty($_POST['color']))
            {
                $color = $_POST['color'];
            }else
            {
                $error['color']='يجب تحديد الون';
            }




            $data['id_item']=$id;
        if(!$this->isDirect())
        {
            $data['id_member_r'] = $_SESSION['id_member_r'];
        }else{
            $data['id_member_r'] = $this->isUuid();
            $data['user_direct'] = $this->userid;
        }
            $data['number']=intval($count);
            $data['date']=time();
		    $count=intval($count);

            if (empty($error))
            {

                $stmt_color= $this->db->prepare("SELECT * from `{$this->color}` WHERE  `img`=?  ");
                $stmt_color->execute(array($color));
                $result_color=$stmt_color->fetch(PDO::FETCH_ASSOC);


                $stmt_ch= $this->db->prepare("SELECT * from `{$this->excel}` WHERE  `code`=? AND `quantity` >= {$count} AND `quantity` <> 0  AND `quantity` <> '' ");
                $stmt_ch->execute(array($result_color['code']));

                if ($stmt_ch->rowCount() > 0) {

                    $stmt = $this->db->prepare("SELECT * from `{$this->excel}` WHERE  `code`=? ");
                    $stmt->execute(array($result_color['code']));
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?");
                    $stmt_order->execute(array($result['code'],$this->table,$data['id_member_r']));
                    $only_order=$stmt_order->fetch(PDO::FETCH_ASSOC);
                     $q= $result['quantity']  - $only_order['num'];

                    if ($q >= $data['number']) {

                        $data['code'] = $result_color['code'];
                        $data['image'] = $color;
                        $data['color'] = $result_color['code_color'];
                        $data['name_color'] =$result_color['color'];


                        $stmt_item = $this->db->prepare("SELECT * from `{$this->table}` WHERE  `id`=?  ");
                        $stmt_item->execute(array($id));
                        $result_item = $stmt_item->fetch(PDO::FETCH_ASSOC);

                        if ($result_item['cuts']== 1)
                        {
                            $data['price'] = $result_item['price_cuts'];
                        }else
                        {
                            if ($this->loginUser() )
                            {

                                    $data['price'] = $this->price_dollarsAdmin($result['price_dollars']);


                            }else
                            {
                                if ($resultcontrollers_item['price_dollars'] == 1 )
                                {
                                    $data['price'] = $this->price_dollars($result['price_dollars']);
                                }else
                                {
                                    $data['price'] = $result['wholesale_price'];
                                }

                            }
                        }

                        if($id_catgory == 0)
                        {
                            $id_catgory = $result_item['id_cat'];


                        }
                        if($id_catg_customer == 0){
                            $id_catg_customer = $result_item['id_cat'];
                        }
                        $data['price_dollars'] = $result['price_dollars'];

                        $data['table'] = $this->table;
						$dollar=new Dollar_price();
						$data['dollar_exchange']=$dollar->dollar_get();

						$stmt_chx = $this->db->prepare("SELECT   *FROM `cart_shop_active` WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?  AND `name_color`=? AND  price_type=0 ");
						$stmt_chx->execute(array($data['id_item'],$data['code'], $this->table, $data['id_member_r'], $data['name_color']));
						if ($stmt_chx->rowCount() > 0)
						{
							$stmtUpdate_cart=$this->db->prepare("UPDATE `cart_shop_active` SET `number`=number+? WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?   AND `name_color`=? AND  price_type=0 ");
							$stmtUpdate_cart->execute(array($data['number'],$data['id_item'],$data['code'], $this->table, $data['id_member_r'], $data['name_color']));
						}else{
							$this->db->insert($this->cart_shop_active, $data);
                            $id_cart = $this->db->lastInsertId();
                            $result_check = $this->check_id_catge($id_catgory);
                            if($result_check == 1){
                                $stmtUpdate_cart=$this->db->prepare("INSERT INTO `type_device_customer` (`model`,`id_type_device`, `id_device_customer`,`id_shop_cart`) VALUES (?,?,?,?)");
                                $stmtUpdate_cart->execute(array($this->table,$id_catgory,$id_catg_customer,$id_cart));
                            }
						}




                     }else
                    {
                        echo json_encode(array(3=> "الكمية غير متوفرة الان تتوفر قريبا ."  ),1);
                    }

                }else
                {

                    echo json_encode(array(3=> "الكمية غير متوفرة الان تتوفر قريبا x ." ),1);
                }
            }
            else
            {
                echo json_encode(array(1=>$error),1);
            }



    }




    public function like_d($id)
    {
        if (isset($_SESSION['username_member_r'])) {
            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            $stmt = $this->db->prepare("INSERT INTO  `{$this->like_accessories}` (`id_device`,`id_member_r`,`like`,`date`) value (?,?,?,?)  ");
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
            $stmt = $this->db->prepare("DELETE FROM  `{$this->like_accessories}` WHERE `id_device`=? AND `id_member_r`=? ");
            $stmt->execute(array($id,$_SESSION['id_member_r']));
            echo 'done';
        }else
        {
            echo '404';
        }
    }
    public function ckeckLick($id)
    { if (isset($_SESSION['username_member_r'])) {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->like_accessories}` WHERE `id_member_r` =?  AND `id_device` =  ? ");
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


    function cart_order($id_catgory =0,$id_catg_customer=0)
    {



        $data = json_decode($_GET['jsonData'], true);

        if(!$this->isDirect())
        {
            $data['id_member_r'] = $_SESSION['id_member_r'];
        }else{
            $data['id_member_r'] = $this->isUuid();
            $data['user_direct'] = $this->userid;
        }

        if (isset($data['number']))
        {
            if (is_numeric($data['number']))
            {
                $data['number'] =strip_tags($data['number']);
            }else
            {
                $data['number'] = 1;
            }
        }else
        {
            $data['number'] = 1;
        }

           $data['date'] = time();
            $stmt_ch= $this->db->prepare("SELECT * from `{$this->excel}` WHERE    `code`= ?     AND  `quantity` > 0  AND `quantity` <> 0  AND `quantity` <> '' ");
            $stmt_ch->execute(array($data['code'] ));
            if ($stmt_ch->rowCount() > 0) {

                $price_2D = $stmt_ch->fetch(PDO::FETCH_ASSOC);

                $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND  `buy` = 0   AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?");
                $stmt_order->execute(array($data['code'], $this->table, $data['id_member_r']));
                $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                $q = $price_2D['quantity'] - $only_order['num'];

                if ($q >= $data['number']) {

                    $data['table'] = $this->table;

                    $stmt_item = $this->db->prepare("SELECT * from `{$this->table}` WHERE  `id`=?  ");
                    $stmt_item->execute(array($data['id_item']));
                    $result_item = $stmt_item->fetch(PDO::FETCH_ASSOC);


                        if ($this->loginUser() )
                        {
                                $data['price'] = $this->price_dollarsAdmin($price_2D['price_dollars']);

                        }else
                        {
                            if ($result_item['price_dollars'] == 1 )
                            {
                                $data['price'] = $this->price_dollars($price_2D['price_dollars']);
                            }else
                            {
                                $data['price'] = $price_2D['wholesale_price'];
                            }

                        }

                        if($id_catgory == 0)
                        {
                            $id_catgory = $result_item['id_cat'];


                        }
                        if($id_catg_customer == 0){
                            $id_catg_customer = $result_item['id_cat'];
                        }
                    $stmt_id_color = $this->db->prepare("SELECT  *  from `{$this->color}`  WHERE  `code`=?  ");
                    $stmt_id_color->execute(array($data['code']));
                    $result_id_color = $stmt_id_color->fetch(PDO::FETCH_ASSOC);

                    $data['size'] = '';
                    $data['image'] = $result_id_color['img'];

                    $data['color'] = $result_id_color['code_color'];
                    $data['name_color'] = $result_id_color['color'];

                    $dollar=new Dollar_price();
                    $data['dollar_exchange']=$dollar->dollar_get();


                    if ($this->ch_wcprice())
                    {

                        if ($data['price_type'] == 1) {
                            $data['price_dollars'] = $price_2D['wholesale_price'];

                        } else if ($data['price_type'] == 2) {
                            $data['price_dollars'] = $price_2D['wholesale_price2'];

                        } else if ($data['price_type'] == 3) {
                            $data['price_dollars'] = $price_2D['cost_price'];
                        } else {
                            $data['price_dollars'] = $price_2D['price_dollars'];
                        }
                    }else
                    {
                        $data['price_dollars'] = $price_2D['price_dollars'];
                    }

					$stmt_chx = $this->db->prepare("SELECT   * FROM `cart_shop_active` WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ? AND `name_color`=?  AND  price_type=? ");
					$stmt_chx->execute(array($data['id_item'],$data['code'], $this->table, $data['id_member_r'], $data['name_color'], $data['price_type']));
					if ($stmt_chx->rowCount() > 0)
					{
						$stmtUpdate_cart=$this->db->prepare("UPDATE `cart_shop_active` SET `number`=number+1 WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ? AND `name_color`=?  AND  price_type=?  ");
						$stmtUpdate_cart->execute(array($data['id_item'],$data['code'], $this->table, $data['id_member_r'],$data['name_color'],$data['price_type']));
					}else{
						$this->db->insert($this->cart_shop_active, $data);
                        $id_cart = $this->db->lastInsertId();
                        $result_check = $this->check_id_catge($id_catgory);
                        if($result_check == 1){
                            $stmtUpdate_cart=$this->db->prepare("INSERT INTO `type_device_customer` (`model`,`id_type_device`, `id_device_customer`,`id_shop_cart`) VALUES (?,?,?,?)");
                            $stmtUpdate_cart->execute(array($this->table,$id_catgory,$id_catg_customer,$id_cart));
                        }
					}



                    if ($this->isDirect())
                    {
                        $id=$this->isUuid();
                    }else{
                        $id= $_SESSION['id_member_r'];
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



    function count_c()
    {
        if ($this->isDirect())
        {
            $id=$this->isUuid();
        }else{
            $id= $_SESSION['id_member_r'];
        }

        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`, `number`,`buy`,`date` FROM `{$this->cart_shop_active}` WHERE `id_member_r` =?  AND `buy` = 0 GROUP BY `offers`,`id_offer`,`date` ORDER BY `id`  DESC  ");
        $stmt->execute(array($id));
            $car=array();
            $count=0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $count=$count+$row['number'];
            }

            echo $count;

    }

    function range()
    {



		$mix=0;
		$max=0;

		$max_range =str_replace($this->comma,'', $_POST['max_range']);
		$min_range = str_replace($this->comma,'', $_POST['min_range']);
		$catRg = $_POST['catRg'];

		if (is_numeric($max_range) && is_numeric($min_range)) {

			if($min_range==0)
			{
				$mix =  '1';
			}
			else{
				$mix =  $min_range.'000';
			}

			$max =  $max_range.'000';
		}



		$stmt=$this->db->prepare("SELECT  `code` FROM `{$this->excel}` WHERE   (`range1`>= {$mix}  AND range1 <= {$max})  OR  (`range2`>= {$mix}  AND range2 <= {$max}) ");
		$stmt->execute();
		$code=array();
		$id_item=array();
		while ($row =  $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$stmtItem=$this->db->prepare("SELECT  `id_item` FROM `{$this->color}` WHERE  `code`   =?  ");
			$stmtItem->execute(array($row['code']));
			if ($stmtItem->rowCount()>0){
				$list_id_item=$stmtItem->fetch(PDO::FETCH_ASSOC);
				$id_item[]=$list_id_item['id_item'];
			}

			$code[]= $row['code'];
		}



        $Id_item = implode(',', $id_item);
        if ( abs(is_numeric($catRg)) &&  abs(is_numeric($catRg))  ) {
            $Id_cat = implode(',', $this->getLoopId($catRg));
            $stmt = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE `id`  IN ({$Id_item})   AND `active` = 1  AND `id_cat`  IN ({$Id_cat})  AND {$this->bast_it}  AND  {$this->is_delete}  ORDER BY `id` DESC  ");
        }else
        {
            $stmt = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE `id`  IN ({$Id_item})   AND `active` = 1 AND {$this->bast_it}  AND  {$this->is_delete}  ORDER BY `id` DESC  ");
        }
        $stmt->execute();


        $data_view=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {


            $idItemC=array();

            $stmtIdItC=$this->numberItems($row['id']);
            while ($rowiIdIt = $stmtIdItC->fetch(PDO::FETCH_ASSOC))
            {
                $idItemC[]=$rowiIdIt;
            }

            if (!empty($idItemC))
            {

                foreach ($idItemC as $idItc) {

                    $stmt_img_id = $this->getImage($idItc['id'], 1);

                    $row['image'] = $this->save_file . $stmt_img_id['img'];
                    $stmt_price = $this->getPrice($stmt_img_id['code'], 1,$row['price_dollars']);

                    if (in_array($stmt_img_id['code'],$code)) {
                        $smt_ch_q = $this->smt_ch_q($stmt_img_id['code'],$stmt_img_id['color']);
                        if ($smt_ch_q->rowCount() > 0) {
                            if (isset($_COOKIE['currency'])) {
                                if ($_COOKIE['currency'] == 0) {
                                    $row['priceC'] = $stmt_price['price'];
                                    $row['price'] = $stmt_price['price'] . ' د.ع ';
                                } else {
                                    $row['priceC'] = $stmt_price['price_dollars'];
                                    $row['price'] = $stmt_price['price_dollars'] . '$ ';
                                }

                            } else {
                                $row['priceC'] = $stmt_price['price'];
                                $row['price'] = $stmt_price['price'] . ' د.ع ';
                            }


                            $row['code'] = $stmt_img_id['code'];
                            $row['color'] = $stmt_img_id['color'];
                            $row['code_color'] = $stmt_img_id['code_color'];
                            $row['nameImage'] = $stmt_img_id['img'];

                            $row['like'] = $this->ckeckLick($row['id']);

                            $data_view[] = $row;

                        } else {
                            continue;
                        }
                    }

                }
            }
        }


        require ($this->render($this->folder,'html','range','php'));



    }



    public function filter()
    {

        if (isset($_REQUEST['specifications'])) {
            $myArray = $_REQUEST['specifications'];
            $id_cat = $_POST['catgFilter'];



            $arrayIds=array();
            foreach ($myArray as $xidz)
            {
                $arrayIds[]= $xidz[0];
            }



            $fieldDetails=null;
            foreach ($arrayIds as $w)
            {
                if (abs($w))
                {
                    $fieldDetails .= " specifications LIKE '%{$w}%' AND ";
                }

            }

            $fieldDetails = rtrim($fieldDetails, 'AND ');
            if ($id_cat=='all')
            {

                $stmt = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE  ({$fieldDetails})   AND  `active` = 1 AND {$this->bast_it} ORDER BY `id` DESC  ");
                $stmt->execute();
            }else
            {
                $Id_cat = implode(',', $this->getLoopId($id_cat));
                $stmt = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE `id_cat`  IN ({$Id_cat})  AND   ({$fieldDetails})  AND  `active` = 1 AND {$this->bast_it}    AND  {$this->is_delete}    ORDER BY `id` DESC  ");
                $stmt->execute(array($id_cat));
            }


            $data_view=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {


                $idItemC=array();

                $stmtIdItC=$this->numberItems($row['id']);
                while ($rowiIdIt = $stmtIdItC->fetch(PDO::FETCH_ASSOC))
                {
                    $idItemC[]=$rowiIdIt;
                }

                if (!empty($idItemC))
                {

                    foreach ($idItemC as $idItc) {

                        $stmt_img_id = $this->getImage($idItc['id'], 1);

                        $row['image'] = $this->save_file . $stmt_img_id['img'];
                        $stmt_price = $this->getPrice($stmt_img_id['code'], 1,$row['price_dollars']);

                        $smt_ch_q = $this->smt_ch_q($stmt_img_id['code'],$stmt_img_id['color']);
                        if ($smt_ch_q->rowCount() > 0) {
                            if (isset($_COOKIE['currency'])) {
                                if ($_COOKIE['currency'] == 0) {
                                    $row['priceC'] = $stmt_price['price'] ;
                                    $row['price'] = $stmt_price['price'] . ' د.ع ';
                                } else {
                                    $row['priceC'] = $stmt_price['price_dollars'] ;
                                    $row['price'] = $stmt_price['price_dollars'] . '$ ';
                                }

                            } else {
                                $row['priceC'] =  $stmt_price['price'];
                                $row['price'] =  $stmt_price['price'] . ' د.ع ';
                            }


                            $row['code'] = $stmt_img_id['code'];
                            $row['color'] = $stmt_img_id['color'];
                            $row['code_color'] = $stmt_img_id['code_color'];
                            $row['nameImage'] = $stmt_img_id['img'];

                            $row['like'] = $this->ckeckLick($row['id']);

                            $data_view[] = $row;
                            break;
                        } else {
                            continue;
                        }
                    }
                }
            }

            if (!empty($id_cat))
            {
                require ($this->render($this->folder,'html','range','php'));

            }

        }

    }



    public function list2_accessories()
    {

        $this->checkPermit('view_content','accessories');
        $this->adminHeaderController($this->langControl('view_content'));
        $data_cat=$this->db->select("SELECT * from  {$this->category} WHERE {$this->is_delete}");
        foreach ($data_cat as $key => $d_cat)
        {

            $data_cat[$key]=$d_cat;
        }


        require ($this->render($this->folder,'html','list2','php'));
        $this->adminFooterController();

    }



    public function processing2()
    {

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(



            array( 'db' => 'id_cat', 'dt' => 0 ,
                'formatter' => function( $d, $row ) {
                    return $this->category_name($d);
                }

            ),
            array( 'db' => 'title', 'dt' => 1),
            array( 'db' => 'id', 'dt' =>  2 ,
                'formatter' => function( $d, $row ) {
                    return $this->details_acc($d);
                }

            ),

            array( 'db' => 'date', 'dt' => 3 ,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i:s', $d);
                }

            ),
            array(
                'db'        => 'id',
                'dt'        => 4,
                'formatter' => function($id, $row ) {
                    if ($this->permit('visible',$this->folder)) {
                    $v='OFF';
                      if ($this->ch($id) =='checked')
                      {
                          $v='ON';
                        }
                        return "
                         {$v}
                        <div style='text-align: center'>
                          <input {$this->ch($id)} class='toggle-demo' onchange='visible_accessories(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                         </div>
                     ";
                    }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array( 'db' => 'view', 'dt' => 5 ),
            array(
                'db'        => 'id',
                'dt'        => 6,
                'formatter' => function($id, $row ) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=".url."/accessories/edit_accessories/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db'        => 'id',
                'dt'        =>7,
                'formatter' => function($id, $row ) {
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
            array(  'db' => 'id', 'dt'=>8)

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
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns," {$this->is_delete} " )
        );

    }

    function category_name($id)
    {

        $stmt=$this->db->prepare("SELECT *from  {$this->category} WHERE  `id` = {$id} AND  {$this->is_delete}  ");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return $result['title'];
    }



    function quantity()
    {

		$this->checkPermit('export_excel', $this->folder);
		$this->adminHeaderController($this->langControl($this->folder).' '.date('Y-m-d',time()));


        $stmt = $this->db->prepare("SELECT * from  {$this->category}");
        $stmt->execute();
        $data_cat=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $data_cat[] = $row;
        }

        $id='all';
        $from_price=null;
        $to_price=null;

        if (isset($_GET['id']))
        {
            $id=$_GET['id'];
        }

        if (isset($_GET['from_price']))
        {
            $from_price=$_GET['from_price'];
        }

        if (isset($_GET['to_price']))
        {
            $to_price=$_GET['to_price'];
        }



        if (isset($_GET['switch_location']))
        {
             $this->switch_location=$_GET['switch_location'];
        }




        require($this->render($this->folder, 'quantity', 'index', 'php'));
        $this->adminFooterController();
    }

  public function processing_quantity($id)
    {


        $this->switch_location=$_GET['switch_location'];
        $this->checkPermit('export_excel', $this->folder);
        $table = 'color_accessories';
        $primaryKey = $table . '.id';
        $tableJoin = $table . '.';

        $columns = array(


            array('db' => 'category_accessories.title', 'dt' => 0),
            array('db' => 'accessories.title', 'dt' => 1),
            array('db' => 'menu_link_device_acc_cover.name_device', 'dt' => 2),


            array('db' =>'color_accessories.color', 'dt' => 3),

            array('db' => $tableJoin . 'code', 'dt' =>4),
            array('db' => 'accessories.date', 'dt' => 5,
            'formatter' => function ($d, $row) {
                return date('Y-m-d h:i:s', $d);
                }
            ),

            array('db' => 'excel_accessories.quantity', 'dt' => 6),
            array('db' => 'excel_accessories.price_dollars', 'dt' => 7),

            array('db' =>'accessories.location', 'dt' => 8,
                'formatter' => function( $d, $row ) {
                    if ($d == 1) {
                        $span = "<span class='location_active_{$row[10]}' style='color: green;font-weight: bold;display: block'>ON</span>";
                    } else {
                        $span = "<span class='location_active_{$row[10]}' style='color: red;font-weight: bold;display: block'>OFF</span>";

                    }
                    if ($this->switch_location==0)
                    {
                        if ($this->permit('visible_location', $this->folder)) {
                            $span .= "
                            <div style='text-align: center'>
                              <input {$this->ch_location($row[10])} class='toggle-demo' onchange='visible_accessories_location(this,$row[10])' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                             </div>
                         ";
                        }

                    }

                    return $span;
                 }
              ),


            array('db' =>'color_accessories.img', 'dt' => 9,
                'formatter' => function( $d, $row ) {
                    return "<img  src='".$this->save_file.$d."' style='width: 150px;border: 1px solid gainsboro;'>";
                }
              ),
            array(
                'db'        => 'accessories.id',
                'dt'        => 10,
                'formatter' => function($id, $row ) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=".url."/accessories/edit_accessories/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),

            array(
                'db' =>   $this->table.'.specifications',
                'dt' => 11,
                'formatter' => function ($id, $row) {
                    if (trim($id))
                    {
                        return "<span style='color: green;font-size: 30px;font-weight: bold;'>√</span>";
                    }else
                    {
                        return "<span  style='color: red;font-size: 24px;font-weight: bold'>Χ</span>";

                    }
                }
            ),
            array(
                'db' =>   $this->table.'.description',
                'dt' => 12,
                'formatter' => function ($id, $row) {
                    if (trim($id))
                    {
                        return "<span style='color: green;font-size: 30px;font-weight: bold;'>√</span>";
                    }else
                    {
                        return "<span  style='color: red;font-size: 24px;font-weight: bold'>Χ</span>";

                    }
                }
            ),
            array(
                'db' =>   $this->table.'.tags',
                'dt' => 13,
                'formatter' => function ($id, $row) {
                    if (trim($id))
                    {
                        return "<span style='color: green;font-size: 30px;font-weight: bold;'>√</span>";
                    }else
                    {
                        return "<span  style='color: red;font-size: 24px;font-weight: bold'>Χ</span>";

                    }
                }
            ),
            array(
                'db' =>   $this->table.'.bast_it',
                'dt' => 14,
                'formatter' => function ($id, $row) {
                    if (trim($id))
                    {
                        return "<span style='color: green;font-size: 30px;font-weight: bold;'>√</span>";
                    }else
                    {
                        return "<span  style='color: red;font-size: 24px;font-weight: bold'>Χ</span>";

                    }
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



        if ($id == 'all' && empty($_GET['from_price']) && empty($_GET['to_price']) )
        {
            $join = " inner JOIN accessories ON color_accessories.id_item = accessories.id INNER JOIN category_accessories ON category_accessories.id = accessories.id_cat        LEFT JOIN  menu_link_device_acc_cover ON menu_link_device_acc_cover.id = category_accessories.id_device        LEFT JOIN excel_accessories ON color_accessories.code = excel_accessories.code ";
            $whereAll = array("accessories.is_delete=0","color_accessories.is_delete=0");
        }else if ($id=='all' && !empty($_GET['from_price']) && !empty($_GET['to_price']) )
        {
            $join = " inner JOIN accessories ON color_accessories.id_item = accessories.id INNER JOIN category_accessories ON category_accessories.id = accessories.id_cat     LEFT JOIN  menu_link_device_acc_cover ON menu_link_device_acc_cover.id = category_accessories.id_device   LEFT JOIN excel_accessories ON color_accessories.code = excel_accessories.code ";
            $whereAll = array("accessories.is_delete=0","color_accessories.is_delete=0","{$this->excel}.price_dollars BETWEEN {$_GET['from_price']} AND {$_GET['to_price']}");
        }else if (is_numeric($id)  && empty($_GET['from_price']) && empty($_GET['to_price']) )
        {

            $ids=implode(',', $this->getLoopId($id));

            $join = " inner JOIN accessories ON color_accessories.id_item = accessories.id INNER JOIN category_accessories ON category_accessories.id = accessories.id_cat     LEFT JOIN  menu_link_device_acc_cover ON menu_link_device_acc_cover.id = category_accessories.id_device   LEFT JOIN excel_accessories ON color_accessories.code = excel_accessories.code ";
            $whereAll = array("accessories.is_delete=0","color_accessories.is_delete=0","{$this->table}.id_cat IN({$ids})");
        }else   if (is_numeric($id)  && !empty($_GET['from_price']) && !empty($_GET['to_price']) )
        {
            $ids=implode(',', $this->getLoopId($id));

            $join = " inner JOIN accessories ON color_accessories.id_item = accessories.id INNER JOIN category_accessories ON category_accessories.id = accessories.id_cat     LEFT JOIN  menu_link_device_acc_cover ON menu_link_device_acc_cover.id = category_accessories.id_device   LEFT JOIN excel_accessories ON color_accessories.code = excel_accessories.code ";
            $whereAll = array("accessories.is_delete=0","color_accessories.is_delete=0","{$this->table}.id_cat IN({$ids})","{$this->excel}.price_dollars BETWEEN {$_GET['from_price']} AND {$_GET['to_price']}");
        }


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));

    }





    function min_max()
    {

		$this->checkPermit('min_max', $this->folder);
		$this->adminHeaderController($this->langControl($this->folder).' '.date('Y-m-d',time()));


        $stmt = $this->db->prepare("SELECT * from  {$this->category}");
        $stmt->execute();
        $data_cat=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $data_cat[] = $row;
        }

        $id='all';
        $from_price=null;
        $to_price=null;

        if (isset($_GET['id']))
        {
            $id=$_GET['id'];
        }

        if (isset($_GET['from_price']))
        {
            $from_price=$_GET['from_price'];
        }

        if (isset($_GET['to_price']))
        {
            $to_price=$_GET['to_price'];
        }




        require($this->render($this->folder, 'quantity', 'min_max', 'php'));
        $this->adminFooterController();
    }


   public function processing_min_max($id)
    {
        $this->checkPermit('min_max', $this->folder);
        $table = 'color_accessories';
        $primaryKey = $table . '.id';
        $tableJoin = $table . '.';

        $columns = array(


            array('db' => 'accessories.title', 'dt' => 0),
            array('db' =>'color_accessories.minimum', 'dt' => 1),
            array('db' =>'color_accessories.maximum', 'dt' => 2),


            array('db' => $tableJoin . 'code', 'dt' =>3),
            array('db' => 'excel_accessories.quantity', 'dt' =>4),
            array('db' =>'color_accessories.code', 'dt' =>5,
                'formatter' => function( $d, $row ) {
                    return $d;
                }
            ),
            array('db' => 'excel_accessories.price_dollars', 'dt' => 6),



            array('db' =>'color_accessories.img', 'dt' => 7,
                'formatter' => function( $d, $row ) {
                    return "<img  src='".$this->save_file.$d."' style='width: 150px;border: 1px solid gainsboro;'>";
                }
            ),

            array(
                'db'        => 'accessories.id',
                'dt'        => 8,
                'formatter' => function($id, $row ) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=".url."/accessories/edit_accessories/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
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



        if ($id=='all' && empty($_GET['from_price']) && empty($_GET['to_price']) )
        {
            $join = " inner JOIN accessories ON color_accessories.id_item = accessories.id  JOIN excel_accessories ON color_accessories.code = excel_accessories.code ";
            $whereAll = array("accessories.is_delete=0","color_accessories.is_delete=0","( color_accessories.minimum <> '' OR  color_accessories.maximum <> '')"," excel_accessories.quantity < color_accessories.minimum ");
        }else if ($id=='all' && !empty($_GET['from_price']) && !empty($_GET['to_price']) )
        {
            $join = " inner JOIN accessories ON color_accessories.id_item = accessories.id  LEFT JOIN excel_accessories ON color_accessories.code = excel_accessories.code ";
            $whereAll = array("accessories.is_delete=0","color_accessories.is_delete=0","{$this->excel}.price_dollars BETWEEN {$_GET['from_price']} AND {$_GET['to_price']}","( color_accessories.minimum <> '' OR  color_accessories.maximum <> '' )"," excel_accessories.quantity < color_accessories.minimum ");
        }else if (is_numeric($id)  && empty($_GET['from_price']) && empty($_GET['to_price']) )
        {

            $ids=implode(',', $this->getLoopId($id));

            $join = " inner JOIN accessories ON color_accessories.id_item = accessories.id   LEFT JOIN excel_accessories ON color_accessories.code = excel_accessories.code ";
            $whereAll = array("accessories.is_delete=0","color_accessories.is_delete=0","{$this->table}.id_cat IN({$ids})","( color_accessories.minimum <> '' OR  color_accessories.maximum <> '' )"," excel_accessories.quantity < color_accessories.minimum ");
        }else   if (is_numeric($id)  && !empty($_GET['from_price']) && !empty($_GET['to_price']) )
        {
            $ids=implode(',', $this->getLoopId($id));

            $join = " inner JOIN accessories ON color_accessories.id_item = accessories.id   LEFT JOIN excel_accessories ON color_accessories.code = excel_accessories.code ";
            $whereAll = array("accessories.is_delete=0","color_accessories.is_delete=0","{$this->table}.id_cat IN({$ids})","{$this->excel}.price_dollars BETWEEN {$_GET['from_price']} AND {$_GET['to_price']}","( color_accessories.minimum <> '' OR  color_accessories.maximum <> '' )"," excel_accessories.quantity < color_accessories.minimum ");
        }


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));

    }



	function rprice()
	{

		if (isset($_POST['submit']))
		{
			$idcolor=$_POST['idcolor'];
			$qr=$_POST['qr'];

			$stmtqr=$this->db->prepare("SELECT *FROM user WHERE hash=?");
			$stmtqr->execute(array($qr));
			if ($stmtqr->rowCount() > 0)
			{


				$stmt=$this->db->prepare("SELECT  excel_accessories.price_dollars  FROM color_accessories inner JOIN excel_accessories ON excel_accessories.code = color_accessories.code   WHERE color_accessories.color=excel_accessories.color AND color_accessories.code=excel_accessories.code AND  color_accessories.id= ? LIMIT 1");
				$stmt->execute(array($idcolor));
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

	function  unknown()
	{
		$this->checkPermit('unknown',$this->folder);
		$this->adminHeaderController($this->langControl('add'));
		$data_cat = $this->db->select("SELECT * from  {$this->category}");
		foreach ($data_cat as $key => $d_cat) {

			$data_cat[$key] = $d_cat;
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

                            $stmtc = $this->db->prepare("SELECT * FROM color_accessories  WHERE  `code`=?");
                            $stmtc->execute(array(trim($rowData[0][2])));
                            if ($stmtc->rowCount() < 1) {

                                $stmt = $this->db->prepare("SELECT * FROM {$this->table}  WHERE `title`=?  ");
                                $stmt->execute(array($rowData[0][0] ));
                                if ($stmt->rowCount() > 0) {
                                    $result=$stmt->fetch(PDO::FETCH_ASSOC);

                                    $stmt_in_c = $this->db->prepare("INSERT INTO  color_accessories  (`color`,`code`,`id_item`,`img`,`date`,`point`) VALUES(?,?,?,?,?,?)");
                                    $stmt_in_c->execute(array($rowData[0][1], $rowData[0][2], $result['id'],  'alixcol'.$this->uuid(55).'.png', time()+1,$point));


									$update = $this->db->prepare("UPDATE `{$this->table}`  SET  `is_delete`=0   WHERE id = ?  ");
                                    $update->execute(array($result['id']));

                                    $trace=new trace_site();
                                    $newData=$trace->neaw($result['id'],$this->folder);
                                    $trace->add($result['id'],$this->folder,'رفع سريع','',$rowData[0][0],'',$newData);


                                }else
                                {
                                    $stmt_in_m = $this->db->prepare("INSERT INTO accessories  (`id_cat`,`title`,`description`,`active`,`price_dollars`,`date`,`userid`) VALUES(?,?,?,?,?,?,?)");
                                    $stmt_in_m->execute(array($data['cat'],$rowData[0][0], $rowData[0][3], 1, 1, time()+1,$this->userid));
                                    if ($stmt_in_m->rowCount()>0)
                                    {
                                        $idm=$this->db->lastInsertId();



                                        $stmt_in_c = $this->db->prepare("INSERT INTO  color_accessories  (`color`,`code`,`id_item`,`img`,`date`,`point`) VALUES(?,?,?,?,?,?)");
                                        $stmt_in_c->execute(array($rowData[0][1], $rowData[0][2], $idm,  'alixcol'.$this->uuid(55).'.png', time()+1,$point));

                                        $trace=new trace_site();
                                        $newData=$trace->neaw($idm,$this->folder);
                                        $trace->add($idm,$this->folder,'رفع سريع','',$rowData[0][0],'',$newData);

                                    }

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
					$this->lightRedirect(url.'/'.$this->folder."/list_".$this->folder."/".$data['cat']);

				}


			} catch (Exception $e) {
				$data =$form -> fetch();
				$this->error_form=$e -> getMessage();

			}


		}

		require ($this->render($this->folder,'html','unknown','php'));
		$this->adminFooterController();
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


                            $stmtc = $this->db->prepare("SELECT * FROM color_accessories  WHERE  `code`=?");
                            $stmtc->execute(array(trim($rowData[0][0])));
                            if ($stmtc->rowCount() > 0) {

                                $stmt_point = $this->db->prepare("UPDATE color_accessories  SET  point=?   WHERE code = ?  ");
                                $stmt_point->execute(array($rowData[0][1], $rowData[0][0]));
                                if ($stmt_point->rowCount() > 0 )
                                {


                                    $stmt = $this->db->prepare("SELECT  {$this->table}.* FROM {$this->table} INNER  JOIN  {$this->color} ON  {$this->color}.id_item  = {$this->table}.id WHERE  {$this->color}.code=? AND {$this->table}.id_delete = 0  LIMIT 1");
                                    $stmt->execute(array($rowData[0][0] ));
                                    if ($stmt->rowCount() > 0) {
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $trace=new trace_site();
                                        $newData=$trace->neaw($result['id'],$this->folder);
                                        $trace->add($result['id'],$this->folder,'رفع نقاط المادة','',$result['title'],'',$newData);

                                    }



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
					$this->lightRedirect(url.'/'.$this->folder."/list2_accessories");

				}


			} catch (Exception $e) {
				$data =$form -> fetch();
				$this->error_form=$e -> getMessage();

			}


		}

		require ($this->render($this->folder,'html','point','php'));
		$this->adminFooterController();
	}




    public function list_accessories_connect()
    {

        $this->checkPermit('list_accessories_connect', $this->folder);
        $this->adminHeaderController($this->langControl('list_saver_connect'));


        require($this->render($this->folder, 'connect', 'index', 'php'));
        $this->adminFooterController();

    }




    public function processing_connect()
    {


        $table = $this->category_accessories_connect;
        $primaryKey = 'id';

        $columns = array(


            array('db' => 'title', 'dt' => 0),

            array(
                'db' => 'id',
                'dt' => 1,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible_accessories_connect',$this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_connect($id)} class='toggle-demo' onchange='visible_accessories_connect(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),


            array('db' => 'date', 'dt' =>2,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d ', $d);
                }

            ),

            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_accessories_connect_connect',$this->folder)) {
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
            array('db' => 'id', 'dt' => 4)


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

    public function ch_connect($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->category_accessories_connect} WHERE `id` = ? AND `active` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }

    public function visible_accessories_connect($v_, $id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }
        $data = $this->db->update($this->category_accessories_connect, array('active' => $v), "`id`={$id}");
    }

    public function add_accessories_connect()
    {


        $this->checkPermit('add_accessories_connect', $this->folder);
        $this->adminHeaderController($this->langControl('add_accessories_connect'));


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

                        $stmt = $this->db->prepare("SELECT `title` FROM `category_accessories` WHERE  `id`=? ");
                        $stmt->execute(array($d));
                        $dev = $stmt->fetch(PDO::FETCH_ASSOC);
                        $title[] = $dev['title'];

                    }


                    $data['title'] = implode(' // ', $title);
                    $data['ids'] = implode(',', $ids);


                    $id_add=$this->db->insert($this->category_accessories_connect,$data);

                }
                $this->lightRedirect(url.'/'.$this->folder."/list_accessories_connect",0);


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


    function search()
    {
        if ($this->handleLogin()) {
            $data = $_GET['q'];
            $data = '%' . $data . '%';
            $stmt = $this->db->prepare("SELECT * FROM `category_accessories`  WHERE   {$this->is_delete} AND title LIKE ?    ");
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

    function accessories_info($id)
    {
        if ($this->handleLogin()) {
            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }

            $stmt = $this->db->prepare("SELECT `title` FROM `category_accessories` WHERE  `id`=? ");
            $stmt->execute(array($id));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo $result['title'];
        }
    }


    function delete_accessories_connect($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->category_accessories_connect, "`id`={$id}");
        }
    }




    function index_data($id)
    {
        if (!is_numeric($id))
        {
            die('404');
        }

        $category_accessories=array();


        $c=1;
        $this->ids=array();


        $stmt_content = $this->getAllaccessoriesFromContent($this->getLoopId($id), 4);
        while ($row_cont = $stmt_content->fetch(PDO::FETCH_ASSOC)) {

            $stmtIdItC = $this->numberItems_new($row_cont['id']);
             $details = $stmtIdItC->fetch(PDO::FETCH_ASSOC) ;

            if (!empty($details)) {

                    $row_cont['image'] = $this->save_file . $details['img'];

                if ($this->loginUser()) {
                    $row_cont['priceC'] = $this->price_dollarsAdmin($details['price_dollars']);
                    $row_cont['price'] =$row_cont['priceC'] . ' د.ع ';

                    $row_cont['wholesale_price'] = $this->price_dollarsAdmin($details['wholesale_price']). ' د.ع ';
                    $row_cont['wholesale_price2'] = $this->price_dollarsAdmin($details['wholesale_price2']). ' د.ع ';
                    $row_cont['cost_price'] = $this->price_dollarsAdmin($details['cost_price']). ' د.ع ';


                } else {
                    if ($row_cont['price_dollars'] == 1) {
                        $row_cont['priceC'] = $this->price_dollars($details['price_dollars']);
                        $row_cont['price'] =  $row_cont['priceC']  . ' د.ع ';

                        $row_cont['wholesale_price'] = $this->price_dollars($details['wholesale_price']). ' د.ع ';
                        $row_cont['wholesale_price2'] = $this->price_dollars($details['wholesale_price2']). ' د.ع ';
                        $row_cont['cost_price'] = $this->price_dollars($details['cost_price']). ' د.ع ';

                    } else {
                        $row_cont['priceC'] = $details['price'];
                        $row_cont['price'] = $details['price'] . ' د.ع ';
                    }
                }

                        $row_cont['code'] = $details['code'];
                        $row_cont['code_color'] = $details['code_color'];
                        $row_cont['color'] = $details['color'];
                        $row_cont['nameImage'] = $details['img'];
                        $row_cont['like'] = $this->ckeckLick($row_cont['id']);
                        $category_accessories[] = $row_cont;


            }
        }
        $category_accessories= array_chunk($category_accessories, 4);


        require($this->render($this->folder, 'html', 'index_data', 'php'));


    }


    function numberItems_new($id)
    {
        $stmt = $this->db->prepare("SELECT `{$this->color}`.*,  {$this->excel}.price_dollars, {$this->excel}.price , {$this->excel}.wholesale_price , {$this->excel}.wholesale_price2 , {$this->excel}.cost_price  FROM `{$this->color}`  INNER JOIN {$this->excel} ON {$this->excel}.code = `{$this->color}`.code    WHERE   `{$this->color}`.`id_item`= ? AND {$this->excel}.quantity > 0  GROUP BY {$this->excel}.code LIMIT 1");
        $stmt->execute(array($id));
        return $stmt;
    }




    function load($id=null)
    {
		//This array to show lable("عروض كل يوم") to model accessories
        $offers_acc=array();

        $item_per_page = 6;
        $files=array();
        //sanitize post value
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

        if(!is_numeric($page_number)){
            header('HTTP/1.1 500 Invalid page number!');
            exit();
        }
        $position = (($page_number-1) * $item_per_page);

        if (is_numeric($id)) {

            $stmt_ch = $this->db->prepare("SELECT `ids` FROM `category_accessories_connect` WHERE   FIND_IN_SET(?,`ids`)  AND  active=1 LIMIT 1");
            $stmt_ch->execute(array($id));
            if ($stmt_ch->rowCount()>0)
            {
                $result2 = $stmt_ch->fetch(PDO::FETCH_ASSOC);
                $Id_cat=$result2['ids'];

                $stmt=$this->db->prepare("SELECT {$this->table}.id,{$this->table}.title,{$this->table}.id_cat as idcat,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description,{$this->table}.price_dollars  FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id   INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->color}.code  WHERE {$this->excel}.quantity > 0  AND {$this->table}.`id_cat`  IN({$Id_cat})   AND {$this->table}.`active` = 1   AND   {$this->bast_it} AND  {$this->table}.is_delete = 0  group by   {$this->table}.`id`   ORDER BY {$this->table}.`id` DESC  LIMIT $position,$item_per_page");
                $stmt->execute(array($id));


            }else{
                $Id_cat = implode(',', $this->getLoopId($id));
                $stmt=$this->db->prepare("SELECT {$this->table}.id,{$this->table}.title,{$this->table}.id_cat as idcat,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description ,{$this->table}.price_dollars FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id   INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->color}.code  WHERE {$this->excel}.quantity > 0  AND {$this->table}.`id_cat`  IN({$Id_cat})   AND {$this->table}.`active` = 1   AND   {$this->bast_it} AND  {$this->table}.is_delete = 0   group by   {$this->table}.`id`   ORDER BY {$this->table}.`id` DESC  LIMIT $position,$item_per_page");
                $stmt->execute(array($id));

            }


        }else{
            $stmt=$this->db->prepare("SELECT {$this->table}.id,{$this->table}.title,{$this->table}.id_cat as idcat,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description,{$this->table}.price_dollars    FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id   INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->color}.code WHERE {$this->excel}.quantity > 0 AND  {$this->table}.`active` = 1   AND   {$this->bast_it}  AND  {$this->table}.is_delete = 0  group by   {$this->table}.`id`   ORDER BY {$this->table}.`id` DESC  LIMIT $position,$item_per_page");
            $stmt->execute();
        }

        $table=array();
        while ($row_cont = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $id_catg =$row_cont['idcat'];
            $stmtIdItC = $this->numberItems_new($row_cont['id']);
            $details = $stmtIdItC->fetch(PDO::FETCH_ASSOC) ;

            if (!empty($details)) {

                $row_cont['image'] = $this->save_file . $details['img'];

                if ($this->loginUser() )
                {
                    $row_cont['priceC'] = $this->price_dollarsAdmin($details['price_dollars']);
                    $row_cont['price'] =$this->price_dollarsAdmin($details['price_dollars']). ' د.ع ';



                    $row_cont['wholesale_price'] = $this->price_dollarsAdmin($details['wholesale_price']). ' د.ع ';
                    $row_cont['wholesale_price2'] = $this->price_dollarsAdmin($details['wholesale_price2']). ' د.ع ';
                    $row_cont['cost_price'] = $this->price_dollarsAdmin($details['cost_price']). ' د.ع ';


                }else
                {
                        $row_cont['priceC'] = $this->price_dollars($details['price_dollars']);
                        $row_cont['price'] =$this->price_dollars($details['price_dollars']). ' د.ع ';

                        $row_cont['wholesale_price'] = $this->price_dollars($details['wholesale_price']). ' د.ع ';
                        $row_cont['wholesale_price2'] = $this->price_dollars($details['wholesale_price2']). ' د.ع ';
                        $row_cont['cost_price'] = $this->price_dollars($details['cost_price']). ' د.ع ';


                }
                $row_cont['id_catg_customer'] = $id;
                $row_cont['id_catg'] = $id_catg;
                $row_cont['code'] = $details['code'];
                $row_cont['code_color'] = $details['code_color'];
                $row_cont['color'] = $details['color'];
                $row_cont['nameImage'] = $details['img'];
                $row_cont['like'] = $this->ckeckLick($row_cont['id']);

            	 // اذا كانت الفئة الرئيسية هي اللواصق يعرض اسم الفئة والا يعرض اسم اللاصق
                $result_check = $this->check_id_catge($id);
                if($result_check == 1){
                    $stmt_cat = $this->db->prepare("SELECT `title` FROM `category_accessories` WHERE `id` = ? LIMIT 1");
                    $stmt_cat->execute(array($id));
                    if($stmt_cat->rowCount()>0)
                    {
                        while ($row_cat = $stmt_cat->fetch(PDO::FETCH_ASSOC))
                        {
                            $row_cont['title'] = $row_cat['title'];
                        }

                    }
                }else{
                    $row_cont['title'] = $row_cont['title'];
                }

                $table[] = $row_cont;

            }
        }




    	$date = time();
        $stmtOffers=$this->db->prepare("SELECT offers.id, offers_item.code  FROM `offers` INNER JOIN `offers_item` ON offers.id = offers_item.id_offer  WHERE offers_item.model = ? AND offers.active=1 AND {$date} BETWEEN `fromdate` AND `todate`AND offers.delete =0");
        $stmtOffers->execute(array('accessories'));
        while ($rowOffers = $stmtOffers->fetch(PDO::FETCH_ASSOC))
        {
            $rowOffers['code'] = $rowOffers['code'];

            $offers_acc[] = $rowOffers;
        }

        require ($this->render($this->folder,'html','data','php'));

    }



    function load_desc($id=null)
    {

        $item_per_page = 6;
        $files=array();
        //sanitize post value
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

        if(!is_numeric($page_number)){
            header('HTTP/1.1 500 Invalid page number!');
            exit();
        }
        $position = (($page_number-1) * $item_per_page);

        if (is_numeric($id)) {

            $stmt_ch = $this->db->prepare("SELECT `ids` FROM `category_accessories_connect` WHERE   FIND_IN_SET(?,`ids`)  AND  active=1 LIMIT 1");
            $stmt_ch->execute(array($id));
            if ($stmt_ch->rowCount()>0)
            {
                $result2 = $stmt_ch->fetch(PDO::FETCH_ASSOC);
                $Id_cat=$result2['ids'];

                $stmt=$this->db->prepare("SELECT {$this->table}.id,{$this->table}.title,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description,{$this->table}.price_dollars  FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id   INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->color}.code  WHERE {$this->excel}.quantity > 0  AND {$this->table}.`id_cat`  IN({$Id_cat})   AND {$this->table}.`active` = 1   AND   {$this->bast_it}  AND  {$this->table}.is_delete = 0  group by   {$this->table}.`id`   ORDER BY CAST({$this->excel}.`price_dollars` as DECIMAL(25,15))    DESC    LIMIT $position,$item_per_page");
                $stmt->execute(array($id));


            }else{
                $Id_cat = implode(',', $this->getLoopId($id));
                $stmt=$this->db->prepare("SELECT {$this->table}.id,{$this->table}.title,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description ,{$this->table}.price_dollars FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id   INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->color}.code  WHERE {$this->excel}.quantity > 0  AND {$this->table}.`id_cat`  IN({$Id_cat})   AND {$this->table}.`active` = 1   AND   {$this->bast_it}  AND  {$this->table}.is_delete = 0  group by   {$this->table}.`id`   ORDER BY  CAST({$this->excel}.`price_dollars` as DECIMAL(25,15))    DESC    LIMIT $position,$item_per_page");
                $stmt->execute(array($id));

            }


        }else{
            $stmt=$this->db->prepare("SELECT {$this->table}.id,{$this->table}.title,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description,{$this->table}.price_dollars    FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id   INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->color}.code WHERE {$this->excel}.quantity > 0 AND  {$this->table}.`active` = 1   AND   {$this->bast_it}  AND  {$this->table}.is_delete = 0  group by   {$this->table}.`id`   ORDER BY CAST({$this->excel}.`price_dollars` as DECIMAL(25,15))    DESC  LIMIT $position,$item_per_page");
            $stmt->execute();
        }

        $table=array();
        while ($row_cont = $stmt->fetch(PDO::FETCH_ASSOC))
        {

            $stmtIdItC = $this->numberItems_new($row_cont['id']);
            $details = $stmtIdItC->fetch(PDO::FETCH_ASSOC) ;

            if (!empty($details)) {

                $row_cont['image'] = $this->save_file . $details['img'];

                if ($this->loginUser() )
                {
                    $row_cont['priceC'] = $this->price_dollarsAdmin($details['price_dollars']);
                    $row_cont['price'] =$this->price_dollarsAdmin($details['price_dollars']). ' د.ع ';


                    $row_cont['wholesale_price'] = $this->price_dollarsAdmin($details['wholesale_price']). ' د.ع ';
                    $row_cont['wholesale_price2'] = $this->price_dollarsAdmin($details['wholesale_price2']). ' د.ع ';
                    $row_cont['cost_price'] = $this->price_dollarsAdmin($details['cost_price']). ' د.ع ';


                }else
                {

                        $row_cont['priceC'] = $this->price_dollars($details['price_dollars']);
                        $row_cont['price'] =$this->price_dollars($details['price_dollars']). ' د.ع ';



                    $row_cont['wholesale_price'] = $this->price_dollars($details['wholesale_price']). ' د.ع ';
                    $row_cont['wholesale_price2'] = $this->price_dollars($details['wholesale_price2']). ' د.ع ';
                    $row_cont['cost_price'] = $this->price_dollars($details['cost_price']). ' د.ع ';


                }

                $row_cont['code'] = $details['code'];
                $row_cont['code_color'] = $details['code_color'];
                $row_cont['color'] = $details['color'];
                $row_cont['nameImage'] = $details['img'];
                $row_cont['like'] = $this->ckeckLick($row_cont['id']);
                $table[] = $row_cont;

            }
        }

        require ($this->render($this->folder,'html','data','php'));

    }




    function load_asc($id=null)
    {

        $item_per_page = 6;
        $files=array();
        //sanitize post value
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

        if(!is_numeric($page_number)){
            header('HTTP/1.1 500 Invalid page number!');
            exit();
        }
        $position = (($page_number-1) * $item_per_page);

        if (is_numeric($id)) {

            $stmt_ch = $this->db->prepare("SELECT `ids` FROM `category_accessories_connect` WHERE   FIND_IN_SET(?,`ids`)  AND  active=1 LIMIT 1");
            $stmt_ch->execute(array($id));
            if ($stmt_ch->rowCount()>0)
            {
                $result2 = $stmt_ch->fetch(PDO::FETCH_ASSOC);
                $Id_cat=$result2['ids'];

                $stmt=$this->db->prepare("SELECT {$this->table}.id,{$this->table}.title,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description,{$this->table}.price_dollars  FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id   INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->color}.code  WHERE {$this->excel}.quantity > 0  AND {$this->table}.`id_cat`  IN({$Id_cat})   AND {$this->table}.`active` = 1   AND   {$this->bast_it}  AND  {$this->table}.is_delete = 0  group by   {$this->table}.`id`   ORDER BY CAST({$this->excel}.`price_dollars` as DECIMAL(25,15))    ASC    LIMIT $position,$item_per_page");
                $stmt->execute(array($id));


            }else{
                $Id_cat = implode(',', $this->getLoopId($id));
                $stmt=$this->db->prepare("SELECT {$this->table}.id,{$this->table}.title,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description ,{$this->table}.price_dollars FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id   INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->color}.code  WHERE {$this->excel}.quantity > 0  AND {$this->table}.`id_cat`  IN({$Id_cat})   AND {$this->table}.`active` = 1   AND   {$this->bast_it}  AND  {$this->table}.is_delete = 0  group by   {$this->table}.`id`   ORDER BY  CAST({$this->excel}.`price_dollars` as DECIMAL(25,15))    ASC    LIMIT $position,$item_per_page");
                $stmt->execute(array($id));

            }


        }else{
            $stmt=$this->db->prepare("SELECT {$this->table}.id,{$this->table}.title,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description,{$this->table}.price_dollars    FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id   INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->color}.code WHERE {$this->excel}.quantity > 0 AND  {$this->table}.`active` = 1   AND   {$this->bast_it}   AND  {$this->table}.is_delete = 0  group by   {$this->table}.`id`   ORDER BY CAST({$this->excel}.`price_dollars` as DECIMAL(25,15))    ASC  LIMIT $position,$item_per_page");
            $stmt->execute();
        }

        $table=array();
        while ($row_cont = $stmt->fetch(PDO::FETCH_ASSOC))
        {

            $stmtIdItC = $this->numberItems_new($row_cont['id']);
            $details = $stmtIdItC->fetch(PDO::FETCH_ASSOC) ;

            if (!empty($details)) {

                $row_cont['image'] = $this->save_file . $details['img'];

                if ($this->loginUser() )
                {
                    $row_cont['priceC'] = $this->price_dollarsAdmin($details['price_dollars']);
                    $row_cont['price'] =$this->price_dollarsAdmin($details['price_dollars']). ' د.ع ';

                    $row_cont['wholesale_price'] = $this->price_dollarsAdmin($details['wholesale_price']). ' د.ع ';
                    $row_cont['wholesale_price2'] = $this->price_dollarsAdmin($details['wholesale_price2']). ' د.ع ';
                    $row_cont['cost_price'] = $this->price_dollarsAdmin($details['cost_price']). ' د.ع ';

                }else
                {

                        $row_cont['priceC'] = $this->price_dollars($details['price_dollars']);
                        $row_cont['price'] =$this->price_dollars($details['price_dollars']). ' د.ع ';


                    $row_cont['wholesale_price'] = $this->price_dollars($details['wholesale_price']). ' د.ع ';
                    $row_cont['wholesale_price2'] = $this->price_dollars($details['wholesale_price2']). ' د.ع ';
                    $row_cont['cost_price'] = $this->price_dollars($details['cost_price']). ' د.ع ';

                }

                $row_cont['code'] = $details['code'];
                $row_cont['code_color'] = $details['code_color'];
                $row_cont['color'] = $details['color'];
                $row_cont['nameImage'] = $details['img'];
                $row_cont['like'] = $this->ckeckLick($row_cont['id']);
                $table[] = $row_cont;

            }
        }

        require ($this->render($this->folder,'html','data','php'));

    }


    function check_code()
    {

        if($this->handleLogin())
        {
            $code=trim($_GET['code']);
            $stmt=$this->db->prepare("SELECT *FROM {$this->color} WHERE code =? and is_delete =0 ");
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

    /*

        function move ($s=null)
        {
            if ($s) {
                $id_cat_move_from = 17;
                $id_cat_move_to = 677;
                $code = 'code';
                $color = 'color';
                $stmt = $this->db->prepare("SELECT *FROM mobile WHERE id_cat=?");
                $stmt->execute(array($id_cat_move_from));

                $c = 0;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $stmtIN = $this->db->prepare("INSERT INTO `accessories` (`title`,`id_cat`,`content`,`description`,`date`,`bast_it`,`serial_flag`,`price_dollars`,`tags`,`cuts`,`price_cuts`,`location`,`enter_serial`,`change_price`,`userId`,`active`,view) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $stmtIN->execute(array($row['title'], $id_cat_move_to, $row['content'], $row['description'], $row['date'], $row['bast_it'], $row['serial_flag'], $row['price_dollars'], $row['tags'], $row['cuts'], $row['price_cuts'], $row['location'], $row['enter_serial'], $row['change_price'], $row['userId'], $row['active'], $row['view']));
                    $lastId = $this->db->lastInsertId();
                    if ($stmtIN->rowCount() > 0) {

                        $stmt2 = $this->db->prepare("SELECT {$color}.*, {$code}.code, {$code}.serial FROM `{$color}` INNER JOIN {$code} ON {$code}.id_color={$color}.id WHERE {$color}.id_item=? ORDER BY  {$color}.color");
                        $stmt2->execute(array($row['id']));
                        while ($sub = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                            $stmt_c = $this->db->prepare("INSERT INTO `color_accessories` (`code`,`color`,`code_color`,`serial`,`id_item`,`img`,`date`) VALUE (?,?,?,?,?,?,?)");
                            $stmt_c->execute(array($sub['code'], $sub['color'], $sub['code_color'], $sub['serial'], $lastId, $sub['img'], $sub['date']));
                        }

                    echo $c + 1;
                }
                }

            }else{
                echo 'enter 1 for start move !';
            }
        }


        function move2 ($s=null)
        {
            if ($s) {
                $id_cat_move_from = 711;
                $id_cat_move_to = 92;
                $code = 'code';
                $color = 'color';
                $stmt = $this->db->prepare("SELECT *FROM accessories WHERE id_cat=?");
                $stmt->execute(array($id_cat_move_from));

                $c = 0;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


                    $stmtIN = $this->db->prepare("INSERT INTO `mobile` (`title`,`id_cat`,`content`, `description` ,`date`,`bast_it`,`serial_flag`,`price_dollars`,`tags`,`cuts`,`price_cuts`,`location`,`enter_serial`,`change_price`,`userId`,`active`,`view`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $stmtIN->execute(array($row['title'],$id_cat_move_to, $row['content'], $row['description'], $row['date'], $row['bast_it'], $row['serial_flag'], $row['price_dollars'], $row['tags'], $row['cuts'], $row['price_cuts'], $row['location'], $row['enter_serial'], $row['change_price'],$row['userId'],$row['active'],$row['view']));
                    $lastId = $this->db->lastInsertId();

                    if ($stmtIN->rowCount() > 0) {


                        $stmt2 = $this->db->prepare("SELECT * FROM `color_accessories`  WHERE id_item=?  ");
                        $stmt2->execute(array($row['id']));
                        while ($sub = $stmt2->fetch(PDO::FETCH_ASSOC)) {

                            $stmt_c = $this->db->prepare("INSERT INTO `{$color}` (`color`,`code_color`,`id_item`,`img`,`date`) VALUE (?,?,?,?,?)");
                            $stmt_c->execute(array($sub['color'], $sub['code_color'], $lastId, $sub['img'], $sub['date']));
                            $lastC = $this->db->lastInsertId();
                            if ($stmt_c->rowCount() > 0)
                            {
                                $stmt_cd = $this->db->prepare("INSERT INTO `{$code}` (`code`,`size`,`serial`,`id_color`,`date`) VALUE (?,?,?,?,?)");
                                $stmt_cd->execute(array($sub['code'], 'بلا',$sub['serial'],  $lastC, $sub['date']));
                            }

                        }

                        echo $c + 1;

                    }


                }

            }else{
                echo 'enter 1 for start move !';
            }
        }




        function del_acc ($s=null)
        {
            if ($s) {
                $id_cat = 711;
                $stmt = $this->db->prepare("SELECT *FROM accessories WHERE id_cat=?");
                $stmt->execute(array($id_cat));
                $c = 0;

                if ($stmt->rowCount() > 0) {

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $stmt_c = $this->db->prepare("DELETE FROM  `color_accessories`  WHERE id_item=?");
                        $stmt_c->execute(array($row['id']));
                        echo $c + 1;
                    }

                    $stmtd = $this->db->prepare("DELETE   FROM accessories WHERE id_cat=?");
                    $stmtd->execute(array($id_cat));
                    if ($stmtd->rowCount() > 0) {

                        $stmtca = $this->db->prepare("DELETE   FROM category_accessories WHERE id=?");
                        $stmtca->execute(array($id_cat));
                    }

                }
            }else{
                echo 'enter 1 for start move !';
            }
        }




     function del_acc_array ($s=null)
    {
        if ($s) {



            $list="168180
168169
185845
185829
202209
185549
185539
185538
185537
185536
198763
198762
202928
185410
185351
185350
185349
185348
185347
185346
185343
185344
185345
185342
185341
185340
185339
185338
185336
185337
185334
185333
181601
181600
185330
185327
185328
185326
185325
185324
185323
185252
190296
191401
189958
189957
2220494
185842
185248
185244
185245
75996
1006204
1012037
1012034
1800889
102
1009843
2323559
185843
185844
1006178
1006181
1011745
1006173
1006196
1006198
1006214
178199
1011924
10793
7114
7094
1011923
1011922
1640
10794
7048
7045
1006155
1006160
1006152
1006182
1006200
1006185
1012168
1012169
1012157
1012161
2221513
1006256
2220211
2220219
2221543
1009883
2221534
2221503
2221443
2220110
7362";

            $your_array = explode("\n", $list);


            foreach ($your_array as $ya ) {



                $stmt = $this->db->prepare("SELECT *FROM color_accessories WHERE code =  ? ");
                $stmt->execute(array(trim($ya)));
                $c = 0;

                if ($stmt->rowCount() > 0) {
                    echo $c + 1;    echo '<br>';
                   $row= $stmt->fetch(PDO::FETCH_ASSOC);
                        $stmt_c = $this->db->prepare("DELETE FROM  `color_accessories`  WHERE id=?");
                        $stmt_c->execute(array($row['id']));

                         $stmt_  = $this->db->prepare("DELETE FROM  `excel_accessories`  WHERE code=?");
                        $stmt_->execute(array($row['code']));



                    $stmtd = $this->db->prepare("DELETE   FROM accessories WHERE id=? AND id_cat = 743");
                    $stmtd->execute(array($row['id_item']));


                }

            }
        }else{
            echo 'enter 1 for start move !';
        }
    }
*/


    function del_catg ($s=null)
    {
        if ($s) {
            $id_cat= 55;

            $table = 'mobile';
            $catg= 'category_'.$table;
            $code = 'code';
            $color = 'color';
            $stmt = $this->db->prepare("SELECT *FROM {$table} WHERE id_cat=?");
            $stmt->execute(array($id_cat));
            $c = 0;
            if ($stmt->rowCount()>0) {

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $stmt2 = $this->db->prepare("SELECT * FROM `{$color}`  WHERE id_item=?  ");
                    $stmt2->execute(array($row['id']));
                    while ($sub = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                        $stmt_c = $this->db->prepare("DELETE FROM  `{$code}`  WHERE id_color=?");
                        $stmt_c->execute(array($sub['id']));
                    }
                    $stmt_colr = $this->db->prepare("DELETE FROM  `{$color}`  WHERE id_item=?");
                    $stmt_colr->execute(array($row['id']));
                    echo $c + 1;

                }

                $stmtd = $this->db->prepare("DELETE   FROM {$table} WHERE id_cat=?");
                $stmtd->execute(array($id_cat));
                if ($stmtd->rowCount() > 0) {

                    $stmtca = $this->db->prepare("DELETE   FROM {$catg} WHERE id=?");
                    $stmtca->execute(array($id_cat));
                }

            }
        }else{
            echo 'enter 1 for start move !';
        }
    }




/*
    function dxd($x)
    {

        if ($x==1)
        {


            $stmt=$this->db->prepare("SELECT *FROM ddddddd");
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {

                $stmt2=$this->db->prepare("SELECT *FROM color_accessories WHERE code=? LIMIT 1");
                $stmt2->execute(array($row['code']));
                $r=$stmt2->fetch(PDO::FETCH_ASSOC);

                $stmt3=$this->db->prepare("DELETE  FROM  accessories WHERE id=?");
                $stmt3->execute(array($r['id_item']));


                $stmt4=$this->db->prepare("DELETE  FROM  color_accessories WHERE code=?");
                $stmt4->execute(array($row['code']));

                $stmt5=$this->db->prepare("DELETE  FROM  excel_accessories WHERE code=?");
                $stmt5->execute(array($row['code']));

                echo $row['title'].'<br>';
            }



        }

    }*/






    public function active()
    {

        $this->checkPermit('active_location_and_enter_serial',$this->folder);
        $this->adminHeaderController($this->langControl('active'));
        $data_cat=$this->db->select("SELECT * from  {$this->category} WHERE {$this->is_delete}");
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
                $stmt=$this->db->prepare("UPDATE {$this->table} SET location=?,userId=?  ");
                $stmt->execute(array($ls,$this->userid));
            }else if ($type=='serial'){
                $stmt=$this->db->prepare("UPDATE {$this->table}  SET enter_serial=?,userId=?  ");
                $stmt->execute(array($ls,$this->userid));
            }

        }else
        {


            $Id_cat = implode(',', $this->getLoopId($cat));

            if ($type=='location')
            {
                $stmt=$this->db->prepare("UPDATE {$this->table} SET location=? ,userId=? WHERE id_cat IN({$Id_cat})");
                $stmt->execute(array($ls,$this->userid));
            }else if ($type=='serial'){
                $stmt=$this->db->prepare("UPDATE {$this->table} SET enter_serial=? ,userId=?  WHERE id_cat IN({$Id_cat})");
                $stmt->execute(array($ls,$this->userid));
            }

        }

        echo 1;

    }






    function getLoopIdX2($id)
    {

        $stmt=$this->db->prepare("SELECT *from  {$this->category} WHERE  `relid` = {$id}  AND {$this->is_delete} ");
        $stmt->execute(array($id));
        while (  $s=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $this->ids[]=$s['id'];
            $this->getLoopIdX2($s['id']);

        }

    }

    function getLoopId2($id)
    {

        if (!empty($id))
        {
            $this->ids[]=$id;
        }

        $stmt=$this->db->prepare("SELECT *from  {$this->category} WHERE  `relid` = {$id}   AND {$this->is_delete}  ");
        $stmt->execute(array($id));
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $this->ids[]=$row['id'];


            $this->getLoopIdX2($row['id']);
        }

        return $this->ids;
    }



    function get_id($id)
    {
      echo  $Id_cat = implode(',', $this->getLoopId2($id));
    }



    function fixed_location() {


    	$this->AddToTraceByFunction($this->userid,'accessories','fixed_location');
        $stmt=$this->db->prepare("SELECT  code  FROM  location WHERE model='accessories' AND fixed_location=0 ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

            $stmt2 = $this->db->prepare("INSERT INTO  location  (code,location,model,sequence,userid,`date`,quantity,fixed_location) values (?,?,?,?,?,?,?,?) ");
            $stmt2->execute(array(trim($row['code']),333333, 'accessories', '99', $this->userid, time(),0,1));
            echo $row['code'];
        }

    }


 function zero_location ($s=null)
    {

 	$this->AddToTraceByFunction($this->userid,'accessories','zero_location/'.$s);
        if ($s) {



            $list="2290-1
2295-1
2305-1
2310-1
2315-1
2320-1
2290-2
2295-2
2300-2
2305-2
2310-2
2315-2
2320-2
2310-5
2325-1
2330-1
2290-3
2295-3
2300-3
2305-3
2310-3
2315-3
2320-3
2325-2
2325-2
2330-2
2335-1
2335-2
2340-1
2345-1
2290-4
2295-4
2300-4
2305-4
2310-4
2315-4
2320-4
2325-3
2335-3
2340-2
2345-2
2350-1
2290-5
2295-5
2345-4
2360-1
2365-1
2305-6
2300-6
2295-6
2290-6
2290-7
2295-7
2305-7
2335-5
2335-4
2365-2
2360-3
2345-6
2345-6
2325-7
2320-7
2320-8
2315-
2310-9
2310-10
2315-12
2320-8
2290-8
2300-9
2305-9
2300-9
2295-9
2290-9
2305-10
2285-9
2280-9
2275-9
2270-9
2265-9
2260-9
2255-9
2250-9
2245-9
2240-9
2235-9
2230-9
2225-9
2220-9
2215-9
2210-9
2205-9
2200-9
2195-9
2190-9
2185-9
2180-9
2175-9
2170-9
2165-9
2160-9
2155-9
2150-9
2145-9
2140-9
2130-9
2130-8
2135-8
2140-8
2145-8
2150-8
2155-8
2160-8
2165-8
2170-8
2175-8
2180-8
2185-8
2190-8
2195-8
2200-8
2205-8
2210-8
2215-8
2220-8
2225-8
2230-8
2235-8
2240-8
2245-8
2250-8
2255-8
2260-8
2265-8
2270-8
2275-8
2280-8
2285-8
2285-7
2280-7
2275-7
2270-7
2265-7
2260-7
2255-7
2250-7
2245-7
2240-7
2235-7
2230-7
2225-7
2220-7
2215-7
2210-7
2205-7
2200-7
2195-7
2190-7
2185-7
2180-7
2175-7
2170-7
2165-7
2160-7
2155-7
2150-7
2145-7
2135-7
2130-7
2130-6
2135-6
2140-6
2145-6
2150-6
2155-6
2160-6
2165-6
2170-6
2175-6
2180-6
2185-6
2190-6
2195-6
2200-6
2205-6
2210-6
2215-6
2220-6
2225-6
2230-6
2235-6
2240-6
2245-6
2250-6
2255-6
2265-6
2270-6
2275-6
2280-6
2285-6
2285-5
2280-5
2275-5
2270-5
2265-5
2260-5
2255-5
2250-5
2245-5
2240-5
2235-5
2230-5
2225-5
2220-5
2215-5
2210-5
2205-5
2200-5
2195-5
2190-5
2185-5
2180-5
2175-5
2170-5
2165-5
2160-5
2155-5
2150-5
2145-5
2140-5
2135-5
2130-5
2130-4
2135-4
2140-4
2145-4
2150-4
2155-4
2160-4
2165-4
2170-4
2175-4
2180-4
2185-4
2190-4
2195-4
2200-4
2205-4
2210-4
2215-4
2220-4
2225-4
2230-4
2235-4
2240-4
2245-4
2250-4
2255-4
2260-4
2265-4
2270-4
2275-4
2280-4
2285-4
2285-3
2275-3
2270-3
2265-3
2260-3
2255-3
2250-3
2245-3
2240-3
2235-3
2230-3
2225-3
2220-3
2215-3
2210-3
2205-3
2200-3
2195-3
2190-3
2185-3
2180-3
2175-3
2170-3
2165-3
2160-3
2155-3
2150-3
2145-3
2140-3
2135-3
2130-3
2130-2
2135-2
2140-2
2145-2
2A50-2
2155-2
2160-2
2165-2
2170-2
2175-2
4180-2
2185-2
2190-2
2195-2
2200-2
2205-2
2210-2
2215-2
2220-2
2225-2
2230-2
2235-2
2240-2
2245-2
2250-2
2255-2
2260-2
2265-2
2270-2
2275-2
2280-2
2285-2
2285-1
2280-1
2275-1
2270-1
2265-1
2260-1
2255-1
2250-1
2245-1
2240-1
2235-1
2230-1
2225-1
2220-1
2215-1
2210-1
2205-1
2200-1
2195-1
2190-1
2185-1
2180-1
2175-1
2170-1
2165-1
2160-1
2155-1
2150-1
2145-1
2140-1
2135-1
2130-1";

            $your_array = explode("\n", $list);
            $c=0;

            foreach ($your_array as $ya ) {


               $ya=trim($ya);
                $stmt = $this->db->prepare("SELECT *FROM location WHERE location =  ?  AND  model = ?");
                $stmt->execute(array($ya,$this->folder));
                if ($stmt->rowCount() > 0) {
                    $r=$stmt->fetch(PDO::FETCH_ASSOC);
                    $code=$r['code'];
                    $x= $c + 1;
                    echo $x.'= '.$ya.'-'.$code.' <br>';


                    $stmt = $this->db->prepare("UPDATE `excel_accessories` SET quantity = 0 WHERE code = ?");
                    $stmt->execute(array($code));

                    $stmt2 = $this->db->prepare("UPDATE `location` SET quantity = 0 WHERE location = ?  AND  model = ?");
                    $stmt2->execute(array($ya,$this->folder));

                    $stmt3 = $this->db->prepare("UPDATE `location_confirm` SET quantity = 0 WHERE code = ?  AND  model = ?");
                    $stmt3->execute(array($code,$this->folder));

                }

            }
        }else{
            echo 'enter 1 for start move !';
        }
    }


// function x()
// {



//     $idcarCover=array();
//     $stmtIdCatCover=$this->db->prepare("SELECT *  FROM  menu_link_device_acc_cover  ");
//     $stmtIdCatCover->execute(array());
//   $c=0;
//     while ($row=$stmtIdCatCover->fetch(PDO::FETCH_ASSOC))
//     {
//         $dd="'{$row['name_device']}'";
//         $stmtacc=$this->db->prepare("SELECT  id,title, MATCH(title) AGAINST ( {$dd} IN NATURAL LANGUAGE MODE) AS score  FROM category_accessories WHERE MATCH(title) AGAINST ({$dd} IN NATURAL LANGUAGE MODE) AND id_device = 0 LIMIT 1");
//         $stmtacc->execute(array());
//         while ($acc=$stmtacc->fetch(PDO::FETCH_ASSOC))
//         {

//             $stmt = $this->db->prepare("UPDATE `category_accessories` SET id_device = ?  WHERE id = ?");
//             $stmt->execute(array($row['id'],$acc['id']));
//             if($stmt->rowCount() > 0)
//             {
//                      echo  $c++;
//                      echo '<br>';
//             }

// //            $idcarCover[$c]['category accessories']=$acc['title'];
// //            $idcarCover[$c]['name device covers']=$dd;
// //            $idcarCover[$c]['similarity ratio']=round($acc['score'],1) ;


//         }
//     }



// }



    public function processing_all_category()
    {


        $table = $this->category;
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


        $stmt = $this->db->prepare("SELECT * FROM {$this->category} WHERE `id` = ? AND `serial_prepared` = 1 ");
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
        $data = $this->db->update($this->category, array('serial_prepared' => $v,'userid_serial' => $this->userid), "`id`={$id}");


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





}
