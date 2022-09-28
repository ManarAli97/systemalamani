<?php
require_once "offer_categories/offer_categories.php";
class Offers extends Controller
{
    public $ids=array();
    use offer_categories;

    function __construct()
    {
        parent::__construct();
        $this->table='offers';
        $this->offers_item='offers_item';
        $this->offer_categories = 'offer_categories';
        $this->cart_shop_active='cart_shop_active';
        $this->menu=new Menu();
        $this-> setting=new  setting();



        $stmtOfferD = $this->db->prepare("UPDATE  offers SET active=2 , note='انتهت مدة العرض ' WHERE active=1 AND `delete`=0 AND  todate  < ?    ");
        $stmtOfferD->execute(array(time()));

        $this->check_all_itemoffers();
        $this->onItemOffOffer();
        /*
                $excel='excel';
                $stmtUpdateOffer=$this->db->prepare(" UPDATE  offers_item   INNER JOIN offers  ON offers.id=offers_item.id_offer INNER JOIN {$excel} ON {$excel}.code=offers_item.code SET  offers.active = 2 , offers.note = 'نفذة كمية بعض مواد الغرض' WHERE   offers.`active`=1 AND {$excel}.quantity <= 0 AND offers_item.model=?");
                $stmtUpdateOffer->execute(array('mobile'));


        */

    }

    public function createTB()
    {


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `content` longtext COLLATE utf8_unicode_ci NOT NULL,
           `description` longtext COLLATE utf8_unicode_ci NOT NULL,
           `total_price` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `rate` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `img` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `id_offer_categories` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `ids_cat` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `imgid` int(10) NOT NULL,
            `range_price` int(10) NOT NULL DEFAULT '1',
           `fromdate_normal` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `todate_normal` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `fromdate`  bigint(20) NOT NULL,
           `todate`  bigint(20) NOT NULL,
           `active` int(10) NOT NULL DEFAULT '0',
           `delete` int(10) NOT NULL DEFAULT '0',
           `quantity` int(10) NOT NULL DEFAULT '1',
           `lang` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `note` text COLLATE utf8_unicode_ci NOT NULL,
           `note2` text COLLATE utf8_unicode_ci NOT NULL,
           `userId` int(11) NOT NULL ,
           `range_price_user` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->offers_item}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `id_offer` int(10) NOT NULL,
           `id_item` int(10) NOT NULL,
           `ids_cat` int(10) NOT NULL,
           `img` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `code_color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `size` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `imgid` int(10) NOT NULL,
           `active` int(10) NOT NULL DEFAULT '0',
           `cover_type_offer` int(10) NOT NULL DEFAULT '0',
           `lang` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `latiniin_or_code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");




        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->offer_categories}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `active` int(10) NOT NULL DEFAULT '0',
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return  $this->db->cht(array($this->table,$this->offer_categories,$this->offers_item));

    }


    function filter($id_cat)
    {

        $date=time();

        if ($id_cat=='all')
        {
            $stmtOffer=$this->db->prepare("SELECT *FROM  offers WHERE   `active`=1 AND `delete`=0 AND  {$date} BETWEEN `fromdate` AND `todate` ");
            $stmtOffer->execute(array($id_cat));

        }else
        {

            $stmtOffer=$this->db->prepare("SELECT *FROM  offers WHERE   FIND_IN_SET(?,model) AND `active`=1 AND `delete`=0 AND {$date} BETWEEN `fromdate` AND `todate` ");
            $stmtOffer->execute(array($id_cat));
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

    public function index(){


        $data_cat=array();
        foreach ($this->category_website as $key => $cat)
        {
            $stmt=$this->db->prepare("SELECT id FROM `offers` WHERE  FIND_IN_SET('$key',model)  AND `active`=1  AND `delete`=0 LIMIT 1 ");
            $stmt->execute();
            if ($stmt->rowCount() > 0)
            {
                $data_cat[$key] =  $cat;
            }

        }



        $date=time();
        $stmtOffer=$this->db->prepare("SELECT *FROM  offers WHERE      `active`=1 AND `delete`=0 AND {$date} BETWEEN `fromdate` AND `todate`  ORDER  BY `date` DESC ");
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
            $offers[]=$row;
        }



        require ($this->render($this->folder,'html','index','php'));


    }



    function getInfoCode()
    {
        if ($this->handleLogin()) {
            $code = strip_tags(trim($_GET['code']));
            $model = strip_tags(trim($_GET['model']));

            if ($model == 'accessories') {

                $color = 'color_accessories';
                $stmt = $this->db->prepare("SELECT  {$model}.id, {$model}.title, {$model}.id_cat, {$color}.img  , {$color}.color, {$color}.code_color  FROM  {$color} INNER JOIN {$model} ON  {$model}.id={$color}.id_item WHERE  {$color}.code=? GROUP BY {$model}.id LIMIT 1");
                $stmt->execute(array($code));

            } else if ($model == 'savers') {
                $stmt = $this->db->prepare("SELECT product_savers.id, product_savers.title, product_savers.id_device as  id_cat , product_savers.img  , product_savers.color  , product_savers.code_color    FROM  product_savers   WHERE  product_savers.code=? GROUP BY product_savers.id LIMIT 1");
                $stmt->execute(array($code));
            } else {

                if ($model == 'mobile') {

                    $code_table = 'code';
                    $color = 'color';
                } else {

                    $code_table = 'code_' . $model;
                    $color = 'color_' . $model;
                }

                $stmt = $this->db->prepare("SELECT  {$model}.id, {$model}.title, {$model}.id_cat, {$color}.img   , {$color}.color  , {$color}.code_color , {$code_table}.size FROM  {$code_table}  INNER JOIN {$color} ON  {$color}.id={$code_table}.id_color   INNER JOIN {$model} ON  {$model}.id={$color}.id_item WHERE  {$code_table}.code=? GROUP BY {$model}.id LIMIT 1");
                $stmt->execute(array($code));
            }

            $data = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                if ($model == 'accessories' || $model =='savers')
                {
                    $row['size']='';
                }

                $data=$row;
            }

            if ($data)
            {
                echo json_encode($data);
            }

        }
    }

    public function ch_special($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE `id` = ? AND `special_active` = 1 ");
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




    public function list_offers()
    {
        $this->checkPermit('list_offers',$this->folder);
        $this->adminHeaderController($this->langControl('offers'));


        if (isset($_GET['model']) && isset($_GET['category'])) {

            $categoryIds = $_GET['category'];


            $id = explode('_', $categoryIds);
            $id = $id[1];


            $model = $_GET['model'];

            $name_category = 'category_' . $model;
            $breadcumbsx = $this->BreadcumbsPublic($name_category, $id);
            $category ='<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) .' </li> ';
            foreach ($breadcumbsx as $key => $cat) {
                $category .= '<li class="breadcrumb-item active" aria-current="page" >' . $key .' </li> ';
            }


        } else if (isset($_GET['model']))
        {
            $id = null;
            $model = $_GET['model'];
            $category ='<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) .' </li> ';

        }else
        {
            $id=null;
            $model=null;
            $category=null;

        }





        require ($this->render($this->folder,'html','list_offers','php'));
        $this->adminFooterController();

    }





    public function processing($model=null,$id=null)
    {

        $table = $this->table;
        $primaryKey = 'id';
        $category='category_'.$model;
        $columns = array(

            array( 'db' => 'title', 'dt' => 0 ),

            array( 'db' => 'total_price', 'dt' =>  1 ,
                'formatter' => function( $d, $row ) {
                    if ($d) {
                        return   $d . " <span style='color: red'>( نسبة التخفيض  " . $this->priceDollarOffer($row[18],6) . "  ) </span> "   ;

                    }
                }
            ),
            array( 'db' => 'rate', 'dt' =>  2 ,
                'formatter' => function( $d, $row ) {
                    return   $d ;
                }
            ),
            array( 'db' => 'id', 'dt' =>  3 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,1);
                }
            ),
            array( 'db' => 'id', 'dt' =>  4 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,2);
                }
            ),

            array( 'db' => 'id', 'dt' =>  5 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,3);
                }
            ),

            array( 'db' => 'id', 'dt' =>  6 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,4);
                }
            ),

            array( 'db' => 'id', 'dt' =>  7 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,5);
                }
            ),

            array( 'db' => 'id', 'dt' =>  8 ,
                'formatter' => function( $d, $row ) {
                    return  "<table  > <tr> <td style='background: #ffffFF;border: 1px solid;padding: 2px'>".date('Y-m-d h:i:s A',$row[16]) ."</td>  <td  style='background: #ffffFF;border: 1px solid;padding: 2px' >".date('Y-m-d h:i:s A',$row[17]) ." </td> </tr> </table>" ;
                }
            ),

            array( 'db' => 'date', 'dt' =>  9 ,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);

                }
            ),

            array( 'db' => 'note', 'dt' =>  10 ,
                'formatter' => function( $d, $row ) {
                    return   $d ;
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 11,
                'formatter' => function($id, $row ) {
                    if ($this->permit('visible','offers')) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch($id)} class='toggle-demo' onchange='visible_news(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-offer{$id}'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 12,
                'formatter' => function($id, $row ) {
                    if ($this->permit('edit','offers')) {
                        return "
                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/" . $this->folder . "/edit/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),


            array(
                'db'        => 'id',
                'dt'        => 13,
                'formatter' => function($id, $row ) {
                    if ($this->permit('range_price','offers')) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_range_price($id)} class='toggle-demo' onchange='visible_range_price(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-offer_range_price{$id}'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 14,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete','offers')) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),


            array('db' =>   'note2', 'dt' => 15,
                'formatter' => function ($d, $row) {
                    if ($this->permit('write_note', $this->folder)) {

                        if ($this->ch($row[18]) != 'checked') {
                            return "
             
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-12' style='padding: 0'>		
				  	       <textarea rows='5'  onkeyup=saveNote('" . $row[18] . "')  id='add_note_{$row[18]}'   type='text' class='form-control withBill'  required>{$d}</textarea>
                   </div>
				 
                  </div>
                    ";
                        }else
                        {
                            return "
             
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-12' style='padding: 0'>		
				  	       <textarea rows='5' readonly onkeyup=saveNote('" . $row[18] . "')  id='add_note_{$row[18]}'   type='text' class='form-control withBill'  required>{$d}</textarea>
                   </div>
				 
                  </div>
                    ";
                        }

                    } else {
                        return 'لا توجد صلاحية';
                    }

                }
            ),

            array( 'db' => 'fromdate', 'dt' =>  16 ),
            array( 'db' => 'todate', 'dt' =>  17   ),
            array(  'db' => 'id', 'dt'=>18)

        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        if ($model !=null && $id != null) {
            $this->ids[] = $id;
            if (!empty($this->getLoopIdX($id, $category))) {
                $this->ids[] = $this->getLoopIdX($id, $category);
            }

            $fieldDetails=null;
            foreach ($this->ids as $w)
            {
                $fieldDetails .= " ids_cat LIKE '%{$w}%' OR ";
            }
            $fieldDetails = rtrim($fieldDetails, 'OR ');
            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 0 AND ( `active` = 0 OR `active` = 1 OR `active` = 2 ) AND model LIKE '%{$model}%' AND ({$fieldDetails}) ")
            );
        }
        else if ($model)
        {
            if ($model=='double_offer')
            {
                echo json_encode(
                // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 0 AND ( `active` = 0 OR `active` = 1 OR `active` = 2 ) AND model LIKE '%,%' ")
                );

            }else
            {
                echo json_encode(
                // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 0 AND ( `active` = 0 OR `active` = 1 OR `active` = 2 ) AND model LIKE '%{$model}%' ")
                );

            }


        }else
        {
            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 0 AND ( `active` = 0 OR `active` = 1 OR `active` = 2 ) ")
            );
        }
    }



    function getLoopIdX($id,$category)
    {

        $stmt=$this->db->prepare("SELECT *from  {$category} WHERE  `relid` = {$id} AND `active` = 1 ");
        $stmt->execute(array($id));
        while (  $s=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $this->ids[]=$s['id'];
            $this->getLoopIdX($s['id'],$category);

        }

    }

    function getLoopId($id,$category)
    {

        if (!empty($id))
        {
            $this->ids[]=$id;
        }

        $stmt=$this->db->prepare("SELECT *from  {$category} WHERE  `relid` = {$id} AND `active` = 1 ");
        $stmt->execute(array($id));
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $this->ids[]=$row['id'];


            $this->getLoopIdX($row['id'],$category);
        }

        return $this->ids;
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

                    $html="<select  name='category'  id='sub_cags_p'  class='custom-select col-md-3 mb-3 list_menu_categ' onchange='sub_catgs2(this)' >";
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
            $c=0;
            if ($model != 'savers')
            {
                $category = 'category_' . $model;
                $stmt = $this->db->prepare("SELECT *FROM {$category} WHERE  `relid` = ? ");
                $stmt->execute(array($id));


                if ($stmt->rowCount() > 0) {

                    $html = "<select name='category'  id='{$data}' class='custom-select col-md-3 mb-3 list_menu_categ' onchange='sub_catgs(this)' >";
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

                    $html = "<select name='category'  id='{$data}'  class='custom-select col-md-3 mb-3 list_menu_categ' onchange='sub_catgs2(this)' > ";
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




    function save_note()
    {
        if ($this->handleLogin())
        {

            $id=trim(str_replace(' ','',$_GET['id']));
            $note=strip_tags($_GET['note']);


            $stmt_up =$this->db->prepare("UPDATE  `offers` SET  note2=?   WHERE  id =? AND `active` <> 1  ");
            $stmt_up->execute(array($note,$id));
            if ($stmt_up->rowCount() > 0)
            {
                echo '1';
                $this->Add_to_sync_schedule($id,"offers","add_offers");

            }else
            {
                echo '0';
            }


        }


    }




    public function offers_active()
    {
        $this->checkPermit('offers_active',$this->folder);
        $this->adminHeaderController($this->langControl('offers_active'));


        $id_c_of=null;

        if (isset($_GET['id_c_of']))
        {
            $id_c_of=$_GET['id_c_of'];
        }

        $stmt=$this->db->prepare("SELECT * FROM `offer_categories`  ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data_cat[]=  $row;
        }



        if (isset($_GET['model']) && isset($_GET['category'])) {

            $categoryIds = $_GET['category'];


            $id = explode('_', $categoryIds);
            $id = $id[1];


            $model = $_GET['model'];

            $name_category = 'category_' . $model;
            $breadcumbsx = $this->BreadcumbsPublic($name_category, $id);
            $category ='<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) .' </li> ';
            foreach ($breadcumbsx as $key => $cat) {
                $category .= '<li class="breadcrumb-item active" aria-current="page" >' . $key .' </li> ';
            }


        } else if (isset($_GET['model']))
        {
            $id = null;
            $model = $_GET['model'];
            $category ='<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) .' </li> ';

        }else
        {
            $id=null;
            $model=null;
            $category=null;

        }






        require ($this->render($this->folder,'html','offers_active','php'));
        $this->adminFooterController();

    }





    public function processing_offers_active($model=null,$id=null,$id_c_of=null)
    {

        $table = $this->table;
        $primaryKey = 'id';
        $category='category_'.$model;
        $columns = array(

            array('db' =>'img', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return "<img  src='".$this->save_file.$d."' style='width: 150px;border: 1px solid gainsboro;'>";
                }
            ),


            array( 'db' => 'title', 'dt' => 1 ),

            array( 'db' => 'total_price', 'dt' =>  2 ,
                'formatter' => function( $d, $row ) {
                    if ($d) {
                        return   $d . " <span style='color: red'>( نسبة التخفيض  " . $this->priceDollarOffer($row[18],6) . "  ) </span> "   ;

                    }
                }
            ),
            array( 'db' => 'rate', 'dt' =>  3 ,
                'formatter' => function( $d, $row ) {
                    return   $d ;
                }
            ),
            array( 'db' => 'id', 'dt' =>  4 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,1);
                }
            ),
            array( 'db' => 'id', 'dt' =>  5 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,2);
                }
            ),

            array( 'db' => 'id', 'dt' =>  6 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,3);
                }
            ),

            array( 'db' => 'id', 'dt' =>  7 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,4);
                }
            ),

            array( 'db' => 'id', 'dt' =>  8 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,5);
                }
            ),

            array( 'db' => 'id', 'dt' =>  9 ,
                'formatter' => function( $d, $row ) {
                    return  "<table  > <tr> <td style='background: #ffffFF;border: 1px solid;padding: 2px'>".date('Y-m-d h:i:s A',$row[18]) ."</td>  <td  style='background: #ffffFF;border: 1px solid;padding: 2px' >".date('Y-m-d h:i:s A',$row[19]) ." </td> </tr> </table>" ;
                }
            ),

            array( 'db' => 'date', 'dt' =>  10 ,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);

                }
            ),

            array( 'db' => 'note', 'dt' =>  11 ,
                'formatter' => function( $d, $row ) {
                    return   $d ;
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 12,
                'formatter' => function($id, $row ) {
                    if ($this->permit('visible','offers')) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch($id)} class='toggle-demo' onchange='visible_news(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-offer{$id}'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 13,
                'formatter' => function($id, $row ) {
                    if ($this->permit('edit','offers')) {
                        return "
                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/" . $this->folder . "/edit/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),


            array(
                'db'        => 'id',
                'dt'        => 14,
                'formatter' => function($id, $row ) {
                    if ($this->permit('range_price','offers')) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_range_price($id)} class='toggle-demo' onchange='visible_range_price(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-offer_range_price{$id}'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 15,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete','offers')) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),


            array('db' =>   'note2', 'dt' => 16,
                'formatter' => function ($d, $row) {
                    if ($this->permit('write_note', $this->folder)) {

                        if ($this->ch($row[20]) != 'checked') {
                            return "
             
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-12' style='padding: 0'>		
				  	       <textarea rows='5'  onkeyup=saveNote('" . $row[20] . "')  id='add_note_{$row[20]}'   type='text' class='form-control withBill'  required>{$d}</textarea>
                   </div>
				 
                  </div>
                    ";
                        }else
                        {
                            return "
             
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-12' style='padding: 0'>		
				  	       <textarea rows='5' readonly onkeyup=saveNote('" . $row[20] . "')  id='add_note_{$row[20]}'   type='text' class='form-control withBill'  required>{$d}</textarea>
                   </div>
				 
                  </div>
                    ";
                        }

                    } else {
                        return 'لا توجد صلاحية';
                    }

                }
            ),

            array( 'db' => 'userId', 'dt' =>  17,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }),
            array( 'db' => 'fromdate', 'dt' =>  18 ),
            array( 'db' => 'todate', 'dt' =>  19   ),
            array(  'db' => 'id', 'dt'=>20)

        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );



        $date=time();

        if ($id_c_of){
            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns ,"FIND_IN_SET({$id_c_of},id_offer_categories) AND   `delete` = 0 AND   `active` = 1   AND {$date} BETWEEN `fromdate` AND `todate`  " )
            );

        }else   if ($model != null && $id != null) {
            $this->ids[] = $id;
            if (!empty($this->getLoopIdX($id, $category))) {
                $this->ids[] = $this->getLoopIdX($id, $category);
            }

            $fieldDetails = null;
            foreach ($this->ids as $w) {
                $fieldDetails .= " ids_cat LIKE '%{$w}%' OR ";
            }
            $fieldDetails = rtrim($fieldDetails, 'OR ');
            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 0 AND   `active` = 1    AND {$date} BETWEEN `fromdate` AND `todate` AND model LIKE '%{$model}%' AND ({$fieldDetails}) ")
            );
        } else if ($model) {
            if ($model == 'double_offer') {
                echo json_encode(
                // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 0 AND   `active` = 1    AND {$date} BETWEEN `fromdate` AND `todate` AND model LIKE '%,%' ")
                );

            } else {
                echo json_encode(
                // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "   `delete` = 0 AND   `active` = 1    AND {$date} BETWEEN `fromdate` AND `todate`  AND model LIKE '%{$model}%' ")
                );

            }


        } else {
            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 0 AND   `active` = 1   AND {$date} BETWEEN `fromdate` AND `todate`  ")
            );
        }


    }








    public function  offers_deleted()
    {
        $this->checkPermit('offers_deleted',$this->folder);
        $this->adminHeaderController($this->langControl('offers_deleted'));




        $id_c_of=null;

        if (isset($_GET['id_c_of']))
        {
            $id_c_of=$_GET['id_c_of'];
        }

        $stmt=$this->db->prepare("SELECT * FROM `offer_categories`  ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data_cat[]=  $row;
        }



        if (isset($_GET['model']) && isset($_GET['category'])) {

            $categoryIds = $_GET['category'];


            $id = explode('_', $categoryIds);
            $id = $id[1];


            $model = $_GET['model'];

            $name_category = 'category_' . $model;
            $breadcumbsx = $this->BreadcumbsPublic($name_category, $id);
            $category ='<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) .' </li> ';
            foreach ($breadcumbsx as $key => $cat) {
                $category .= '<li class="breadcrumb-item active" aria-current="page" >' . $key .' </li> ';
            }


        } else if (isset($_GET['model']))
        {
            $id = null;
            $model = $_GET['model'];
            $category ='<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) .' </li> ';

        }else
        {
            $id=null;
            $model=null;
            $category=null;

        }



        require ($this->render($this->folder,'html','delete','php'));
        $this->adminFooterController();

    }





    public function processing_offers_deleted($model=null,$id=null,$id_c_of=null)
    {

        $table = $this->table;
        $primaryKey = 'id';
        $category='category_'.$model;
        $columns = array(

            array( 'db' => 'title', 'dt' => 0 ),

            array( 'db' => 'total_price', 'dt' =>  1 ,
                'formatter' => function( $d, $row ) {
                    if ($d) {
                        return   $d . " <span style='color: red'>( نسبة التخفيض  " . $this->priceDollarOffer($row[15],6) . "  ) </span> "   ;

                    }
                }
            ),
            array( 'db' => 'rate', 'dt' =>  2 ,
                'formatter' => function( $d, $row ) {
                    return   $d ;
                }
            ),
            array( 'db' => 'id', 'dt' =>  3 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,1);
                }
            ),
            array( 'db' => 'id', 'dt' =>  4 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,2);
                }
            ),

            array( 'db' => 'id', 'dt' =>  5 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,3);
                }
            ),

            array( 'db' => 'id', 'dt' =>  6 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,4);
                }
            ),

            array( 'db' => 'id', 'dt' =>  7 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,5);
                }
            ),

            array( 'db' => 'id', 'dt' =>  8 ,
                'formatter' => function( $d, $row ) {
                    return  "<table  > <tr> <td style='background: #ffffFF;border: 1px solid;padding: 2px'>".date('Y-m-d h:i:s A',$row[13]) ."</td>  <td  style='background: #ffffFF;border: 1px solid;padding: 2px' >".date('Y-m-d h:i:s A',$row[14]) ." </td> </tr> </table>" ;
                }
            ),

            array( 'db' => 'date', 'dt' =>  9 ,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);

                }
            ),

            array( 'db' => 'note', 'dt' =>  10 ,
                'formatter' => function( $d, $row ) {
                    return   $d ;
                }
            ),
            array( 'db' => 'userId', 'dt' =>  11 ,
                'formatter' => function( $d, $row ) {
                    return   $this->UserInfo($d) ;
                }
            ),
            array( 'db' => 'note2', 'dt' =>  12 ),
            array( 'db' => 'fromdate', 'dt' =>  13 ),
            array( 'db' => 'todate', 'dt' =>  14   ),
            array(  'db' => 'id', 'dt'=>15)

        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );








        $date=time();

        if ($id_c_of){
            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns ,"FIND_IN_SET({$id_c_of},id_offer_categories) AND    `delete` = 1   " )
            );

        }else   if ($model != null && $id != null) {
            $this->ids[] = $id;
            if (!empty($this->getLoopIdX($id, $category))) {
                $this->ids[] = $this->getLoopIdX($id, $category);
            }

            $fieldDetails = null;
            foreach ($this->ids as $w) {
                $fieldDetails .= " ids_cat LIKE '%{$w}%' OR ";
            }
            $fieldDetails = rtrim($fieldDetails, 'OR ');
            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "   `delete` = 1    AND model LIKE '%{$model}%' AND ({$fieldDetails}) ")
            );
        } else if ($model) {
            if ($model == 'double_offer') {
                echo json_encode(
                // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "    `delete` = 1    AND model LIKE '%,%' ")
                );

            } else {
                echo json_encode(
                // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "    `delete` = 1     AND model LIKE '%{$model}%' ")
                );

            }


        } else {

            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns ,"  `delete` = 1    " )
            );
        }










    }








    public function pending_offers()
    {
        $this->checkPermit('pending_offers',$this->folder);
        $this->adminHeaderController($this->langControl('pending_offers'));




        $id_c_of=null;

        if (isset($_GET['id_c_of']))
        {
            $id_c_of=$_GET['id_c_of'];
        }

        $stmt=$this->db->prepare("SELECT * FROM `offer_categories`  ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data_cat[]=  $row;
        }



        if (isset($_GET['model']) && isset($_GET['category'])) {

            $categoryIds = $_GET['category'];


            $id = explode('_', $categoryIds);
            $id = $id[1];


            $model = $_GET['model'];

            $name_category = 'category_' . $model;
            $breadcumbsx = $this->BreadcumbsPublic($name_category, $id);
            $category ='<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) .' </li> ';
            foreach ($breadcumbsx as $key => $cat) {
                $category .= '<li class="breadcrumb-item active" aria-current="page" >' . $key .' </li> ';
            }


        } else if (isset($_GET['model']))
        {
            $id = null;
            $model = $_GET['model'];
            $category ='<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) .' </li> ';

        }else
        {
            $id=null;
            $model=null;
            $category=null;

        }





        require ($this->render($this->folder,'html','pending_offers','php'));
        $this->adminFooterController();

    }



    public function processing_pending_offers($model=null,$id=null,$id_c_of=null)
    {

        $table = $this->table;
        $primaryKey = 'id';

        $category='category_'.$model;

        $columns = array(

            array('db' =>'img', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return "<img  src='".$this->save_file.$d."' style='width: 150px;border: 1px solid gainsboro;'>";
                }
            ),


            array( 'db' => 'title', 'dt' => 1 ),

            array( 'db' => 'total_price', 'dt' =>  2 ,
                'formatter' => function( $d, $row ) {
                    if ($d) {
                        return   $d . " <span style='color: red'>( نسبة التخفيض  " . $this->priceDollarOffer($row[18],6) . "  ) </span> "   ;

                    }
                }
            ),
            array( 'db' => 'rate', 'dt' =>  3 ,
                'formatter' => function( $d, $row ) {
                    return   $d ;
                }
            ),
            array( 'db' => 'id', 'dt' =>  4 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,1);
                }
            ),
            array( 'db' => 'id', 'dt' =>  5 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,2);
                }
            ),

            array( 'db' => 'id', 'dt' =>  6 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,3);
                }
            ),

            array( 'db' => 'id', 'dt' =>  7 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,4);
                }
            ),

            array( 'db' => 'id', 'dt' =>  8 ,
                'formatter' => function( $d, $row ) {
                    return $this->priceDollarOffer($d,5);
                }
            ),

            array( 'db' => 'id', 'dt' =>  9 ,
                'formatter' => function( $d, $row ) {
                    return  "<table  > <tr> <td style='background: #ffffFF;border: 1px solid;padding: 2px'>".date('Y-m-d h:i:s A',$row[18]) ."</td>  <td  style='background: #ffffFF;border: 1px solid;padding: 2px' >".date('Y-m-d h:i:s A',$row[19]) ." </td> </tr> </table>" ;
                }
            ),

            array( 'db' => 'date', 'dt' =>  10 ,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);

                }
            ),

            array( 'db' => 'note', 'dt' =>  11 ,
                'formatter' => function( $d, $row ) {
                    return   $d ;
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 12,
                'formatter' => function($id, $row ) {
                    if ($this->permit('visible','offers')) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch($id)} class='toggle-demo' onchange='visible_news(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-offer{$id}'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 13,
                'formatter' => function($id, $row ) {
                    if ($this->permit('edit','offers')) {
                        return "
                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/" . $this->folder . "/edit/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),


            array(
                'db'        => 'id',
                'dt'        => 14,
                'formatter' => function($id, $row ) {
                    if ($this->permit('range_price','offers')) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_range_price($id)} class='toggle-demo' onchange='visible_range_price(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-offer_range_price{$id}'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 15,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete','offers')) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),


            array('db' =>   'note2', 'dt' => 16,
                'formatter' => function ($d, $row) {
                    if ($this->permit('write_note', $this->folder)) {

                        if ($this->ch($row[20]) != 'checked') {
                            return "
             
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-12' style='padding: 0'>		
				  	       <textarea rows='5'  onkeyup=saveNote('" . $row[20] . "')  id='add_note_{$row[20]}'   type='text' class='form-control withBill'  required>{$d}</textarea>
                   </div>
				 
                  </div>
                    ";
                        }else
                        {
                            return "
             
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-12' style='padding: 0'>		
				  	       <textarea rows='5' readonly onkeyup=saveNote('" . $row[20] . "')  id='add_note_{$row[20]}'   type='text' class='form-control withBill'  required>{$d}</textarea>
                   </div>
				 
                  </div>
                    ";
                        }

                    } else {
                        return 'لا توجد صلاحية';
                    }

                }
            ),

            array( 'db' => 'userId', 'dt' =>  17,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }),
            array( 'db' => 'fromdate', 'dt' =>  18 ),
            array( 'db' => 'todate', 'dt' =>  19   ),
            array(  'db' => 'id', 'dt'=>20)

        );


// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );






        $date=time();

        if ($id_c_of){
            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns ," FIND_IN_SET({$id_c_of},id_offer_categories) AND    `active` =  2   " )
            );

        }else   if ($model != null && $id != null) {
            $this->ids[] = $id;
            if (!empty($this->getLoopIdX($id, $category))) {
                $this->ids[] = $this->getLoopIdX($id, $category);
            }

            $fieldDetails = null;
            foreach ($this->ids as $w) {
                $fieldDetails .= " ids_cat LIKE '%{$w}%' OR ";
            }
            $fieldDetails = rtrim($fieldDetails, 'OR ');
            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "   `active` =  2 AND model LIKE '%{$model}%' AND ({$fieldDetails}) ")
            );
        } else if ($model) {
            if ($model == 'double_offer') {
                echo json_encode(
                // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "   `active` =  2 AND model LIKE '%,%' ")
                );

            } else {
                echo json_encode(
                // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "   `active` =  2  AND model LIKE '%{$model}%' ")
                );

            }


        } else {
            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "   `active` =  2  ")
            );
        }









    }








    public function offers_report()
    {
        $this->checkPermit('offers_report',$this->folder);
        $this->adminHeaderController($this->langControl('offers_report'));



        $id_c_of=null;

        if (isset($_GET['id_c_of']))
        {
            $id_c_of=$_GET['id_c_of'];
        }

        $stmt=$this->db->prepare("SELECT * FROM `offer_categories`  ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data_cat[]=  $row;
        }



        if (isset($_GET['model']) && isset($_GET['category'])) {

            $categoryIds = $_GET['category'];


            $id = explode('_', $categoryIds);
            $id = $id[1];


            $model = $_GET['model'];

            $name_category = 'category_' . $model;
            $breadcumbsx = $this->BreadcumbsPublic($name_category, $id);
            $category ='<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) .' </li> ';
            foreach ($breadcumbsx as $key => $cat) {
                $category .= '<li class="breadcrumb-item active" aria-current="page" >' . $key .' </li> ';
            }


        } else if (isset($_GET['model']))
        {
            $id = null;
            $model = $_GET['model'];
            $category ='<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) .' </li> ';

        }else
        {
            $id=null;
            $model=null;
            $category=null;

        }


        require ($this->render($this->folder,'html','offers_report','php'));
        $this->adminFooterController();

    }

    public function processing_offers_report($model=null,$id=null,$id_c_of=null)
    {

        $table = $this->table;
        $primaryKey = 'id';
        $category='category_'.$model;
        $columns = array(

            array( 'db' => 'img', 'dt' => 0 ,
                'formatter' => function( $d, $row ) {
                    return "<img style='width: 100px' src='".$this->save_file.$d."'>";
                }
            ),
            array( 'db' => 'title', 'dt' => 1 ),


            array( 'db' => 'id_offer_categories', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                    return $this->category_offers_list($d);
                }
            ),
            array( 'db' => 'id', 'dt' =>  3 ,
                'formatter' => function( $d, $row ) {
                    return $this->offers_offers_code($d);
                }
            ),
            array( 'db' => 'id', 'dt' =>  4 ,
                'formatter' => function( $d, $row ) {
                    return $this->offers_offers_item($d);
                }
            ),
            array( 'db' => 'model', 'dt' => 5 ,
                'formatter' => function( $d, $row ) {
                    $c=explode(',',$d);

                    foreach ($c as $o)
                    {
                        $data_cat[]= "<p style='    background: #cddc3980;  border-radius: 8px;margin-bottom: 0px;'>{$this->langSite($o)}</p>" ;
                    }

                    if ($data_cat)
                    {
                        return implode(' , ', $data_cat);

                    }


                }
            ),

            array( 'db' => 'active', 'dt' =>  6 ,
                'formatter' => function( $d, $row ) {

                    if ($d==1)
                    {
                        return '<span id="notif_order" class="badge badge-success">مفعل</span>';
                    }else if ($d==2 || $d == 0)
                    {
                        return '<span id="notif_order" class="badge badge-warning">معلق</span>';

                    }else if ($d==3  )
                    {
                        return '<span id="notif_order" class="badge badge-danger">محذوف</span>';

                    }

                }
            ),

            array( 'db' => 'id', 'dt' => 7 ,
                'formatter' => function( $d, $row ) {
                    return $this->sales_offer($d);
                }
            ),



            array( 'db' => 'id', 'dt' =>  8 ,
                'formatter' => function( $d, $row ) {
                    return  "<table  > <tr> <td style='background: #ffffFF;border: 1px solid;padding: 2px'>".date('Y-m-d h:i:s A',$row[11]) ."</td>  <td  style='background: #ffffFF;border: 1px solid;padding: 2px' >".date('Y-m-d h:i:s A',$row[12]) ." </td> </tr> </table>" ;
                }
            ),

            array( 'db' => 'note', 'dt' =>  9 ,
                'formatter' => function( $d, $row ) {
                    return $d;
                }
            ),
            array( 'db' => 'note2', 'dt' =>  10 ,
                'formatter' => function( $d, $row ) {
                    return $d;
                }
            ),
            array( 'db' => 'fromdate', 'dt' =>  11 ),
            array( 'db' => 'todate', 'dt' =>  12   ),
            array(  'db' => 'id', 'dt'=>13)

        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );






        $date=time();

        if ($id_c_of){
            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns ,"FIND_IN_SET({$id_c_of},id_offer_categories)"  )
            );

        }else   if ($model != null && $id != null) {
            $this->ids[] = $id;
            if (!empty($this->getLoopIdX($id, $category))) {
                $this->ids[] = $this->getLoopIdX($id, $category);
            }

            $fieldDetails = null;
            foreach ($this->ids as $w) {
                $fieldDetails .= " ids_cat LIKE '%{$w}%' OR ";
            }
            $fieldDetails = rtrim($fieldDetails, 'OR ');
            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "    model LIKE '%{$model}%' AND ({$fieldDetails}) ")
            );
        } else if ($model) {
            if ($model == 'double_offer') {
                echo json_encode(
                // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "   model LIKE '%,%' ")
                );

            } else {
                echo json_encode(
                // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "     model LIKE '%{$model}%' ")
                );

            }


        } else {
            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns   )
            );

        }









    }



    function category_offers_list($id)
    {

        $stmt=$this->db->prepare("SELECT title FROM `offer_categories` WHERE  FIND_IN_SET(id,?) ");
        $stmt->execute(array($id));
        $data_cat=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data_cat[]= "<p style='  color: #fff;  background: #0000008c;  border-radius: 8px;margin-bottom: 0px;'>{$row['title']}</p>" ;

        }

        if ($data_cat)
        {
            return implode(' , ', $data_cat);

        }


    }


    function sales_offer($id)
    {

        $stmt = $this->db->prepare("SELECT COUNT(*) as num FROM (SELECT COUNT(id) FROM `cart_shop_active` WHERE  number_bill <> 0 AND `accountant` = 1 AND `prepared`= 2  AND `cancel`=0 AND id_offer=? GROUP BY `id_offer`,offers) t");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return  $result['num'];

    }



    function  offers_offers_item($id)
    {

        $stmt=$this->db->prepare("SELECT title FROM `offers_item` WHERE  id_offer =? ");
        $stmt->execute(array($id));
        $data_cat=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data_cat[]= "<p style='    background: #cddc3980;  border-radius: 8px;margin-bottom: 0px;'>{$row['title']}</p>" ;
        }

        if ($data_cat)
        {
            return implode(' , ', $data_cat);

        }


    }


    function  offers_offers_code($id)
    {

        $stmt=$this->db->prepare("SELECT code FROM `offers_item` WHERE  id_offer =? ");
        $stmt->execute(array($id));
        $data_cat=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data_cat[]= "<p style='    background: rgba(133,55,220,0.5);  border-radius: 8px;margin-bottom: 0px;'>{$row['code']}</p>";
        }

        if ($data_cat)
        {
            return implode(' , ', $data_cat);

        }


    }



    public function visible_offers($v_,$id_)
    {
        if ($this->handleLogin()) {

            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }

            $q='true';

            if ($v == 1) {



                if (!$this->check_one_itemoffers($id))
                {
                    $q = '01';
                }


                $stmtOffer = $this->db->prepare("SELECT   * FROM  offers WHERE     id  = ?  AND total_price <> ''   AND rate  <> '' ");
                $stmtOffer->execute(array($id));
                if ($stmtOffer->rowCount() > 0) {

                    $q = '02';
                }

                $date=time();

                $stmtOfferD = $this->db->prepare("SELECT   * FROM  offers WHERE todate  < ?    AND id  = ?  ");
                $stmtOfferD->execute(array($date,$id));
                if ($stmtOfferD->rowCount() > 0) {

                    $q = '03';
                }

                if ($q == 'true') {
                    $data = $this->db->update($this->table, array( 'active' => $v,'note' => '','userId'=>$this->userid), "`id`={$id}");

                    $this->Add_to_sync_schedule($id,"offers","add_offers");


//                    $stmtItemOff = $this->db->prepare("SELECT * FROM  offers_item WHERE id_offer=?  AND active = 1 ");
//                    $stmtItemOff->execute(array($id));
//                    if ($stmtItemOff->rowCount() > 0) {
//                        while ($rowItemOff = $stmtItemOff->fetch(PDO::FETCH_ASSOC)) {
//                            if ($rowItemOff['model'] == 'savers') {
//                                $rowItemOff['model']='savers';
//                            }
//                            $this->db->update($rowItemOff['model'],array('active'=>0), "`id`={$rowItemOff['id_item']}");
//                        }
//                    }


                    echo $q;
                } else if ($q=='01'){
                    echo $q;
                } else if ($q=='02')
                {
                    echo $q;
                } else if ($q=='03')
                {
                    echo $q;
                }
            }else
            {
                $data = $this->db->update($this->table, array( 'active' => $v,'userId'=>$this->userid), "`id`={$id}");
                $this->Add_to_sync_schedule($id,"offers","add_offers");


            }
        }
    }


    public function visible_range_price($v_,$id_)
    {
        if ($this->handleLogin()) {

            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }

            $this->db->update($this->table, array( 'range_price' => $v ,'range_price_user'=>$this->userid), "`id`={$id}");
            echo 'true';
            $this->Add_to_sync_schedule($id,"offers","add_offers");


        }
    }


    function delete_offers($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->update($this->table,array('delete'=>1,'active'=>3,'userId'=>$this->userid,'date'=>time()), "`id`={$id}");
            echo 'true';
            $this->Add_to_sync_schedule($id,"offers","add_offers");

        }
    }


    public function ch($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE `id` = ? AND `active` = 1 ");
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


    public function ch_range_price($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE `id` = ? AND `range_price` = 1 ");
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




    function add()
    {
        $this->checkPermit('add',$this->folder);
        $this->adminHeaderController($this->langControl('add'));

        $data_cat=array();

        $stmt=$this->db->prepare("SELECT * FROM `offer_categories` ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data_cat[]=  $row;
        }



        require ($this->render($this->folder,'html','add','php'));
        $this->adminFooterController();

    }


    function add_form()
    {
        $this->checkPermit('add',$this->folder);

        $error=null;
        $data['title']='';
        $data['content']='';
        $data['total_price']='';
        $data['rate']='';
        $data['description']='';
        $data['files']='';
        $data['list_file']='';
        $data['fromdate_normal']='';
        $data['todate_normal']='';
        $data['countdown']=1;

        try{
            $form =new Form();
            $form  ->post('title')
                ->val('is_empty','مطلوب')
                ->val('strip_tags',TAG);

            $form  ->post('content')
                ->val('strip_tags',TAG);

            $form  ->post('countdown')
                ->val('strip_tags',TAG);

            $form  ->post('description')
                ->val('strip_tags',TAG);

            $form  ->post('id_offer_categories')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('total_price')
                ->val('strip_tags',TAG);

            $form  ->post('rate')
                ->val('strip_tags',TAG);

            $form  ->post('fromdate_normal')
                ->val('strip_tags',TAG);

            $form  ->post('todate_normal')
                ->val('strip_tags',TAG);

            $form  ->post('main_img')
                ->val('strip_tags');

            $form  ->post('list_file')
                ->val('strip_tags');



            $form  ->post('model')
                ->val('is_array')
                ->val('strip_tags');


            $form  ->post('code')
                ->val('is_array')
                ->val('strip_tags');


            $form  ->post('names')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('id_item')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('ids_cat')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('imgitem')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('active')
                ->val('is_array')
                ->val('strip_tags');


            $form  ->post('color')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('code_color')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('size')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('latiniin_or_code')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('cover_type_offer')
                ->val('is_array')
                ->val('strip_tags');


            $form ->submit();
            $data =$form -> fetch();
            $file=new Files();

            $data['lang']=$this->langControl;
            $data['userId']=$this->userid;
            $data['date']=time();

            $data['id_offer_categories']=implode(',',json_decode($data['id_offer_categories'],true));
            $code=json_decode($data['code'],true);
            $names=json_decode($data['names'],true);
            $id_item=json_decode($data['id_item'],true);
            $ids_cat=json_decode($data['ids_cat'],true);
            $model=json_decode($data['model'],true);
            $active=json_decode($data['active'],true);
            $imgitem=json_decode($data['imgitem'],true);
            $color=json_decode($data['color'],true);
            $code_color=json_decode($data['code_color'],true);
            $size=json_decode($data['size'],true);
            $latiniin_or_code=json_decode($data['latiniin_or_code'],true);
            $cover_type_offer=json_decode($data['cover_type_offer'],true);


            $main_image=json_decode($data['main_img'],true);
            $image = array();
            if (count($code)  == 1)
            {
                if(empty($main_image) &&  $_FILES['image']['error'][0]  != 4 ) {
                    $image = $this->save_file($_FILES['image']);
                    $main_image[0]['rand_name']=$image[0];

                }else
                {
                    if (empty($main_image))
                    {
                        $main_image[0]['rand_name']=$imgitem[0];
                    }

                }
                $image=array('');
            }
            else
            {
                if (empty($main_image))
                {
                    $error = 1; // يجب رفع صورة رئيسية للعرض
                }

            }



            if ( $data['total_price'] &&  $data['rate'])
            {
                $data['active']=2;
                $data['note']=  'سعر كلي  و نسبة تخفيض مدخلة معاَ ' ;
            }else
            {
                $data['active']=0;
                $data['note']=  '' ;
            }


            $data['ids_cat']=implode(',',$ids_cat);
            $data['model']=implode(',',$model);
            $data['fromdate']=strtotime($data['fromdate_normal']);
            $data['todate']=strtotime($data['todate_normal']);

            if (empty($error))
            {

                $this->db->insert($this->table,array_diff_key($data,['imgitem'=>"delete",'color'=>"delete",'code_color'=>"delete",'size'=>"delete",'list_file'=>"delete",'main_img'=>"delete",'code'=>"delete",'names'=>"delete",'id_item'=>"delete",'latiniin_or_code'=>"delete",'cover_type_offer'=>"delete"]));
                $listid=$this->db->lastInsertId();
                $this->Add_to_sync_schedule($listid,"offers","add_offers");


                if ($listid){

                    if(!empty($main_image)) {
                        $id_file= $file->insert_file($this->folder, $listid, $main_image);
                        $this->db->update($this->table, array('img' => $main_image[0]['rand_name'],'imgid' => $id_file), "id={$listid}");
                        $this->Add_to_sync_schedule($listid,"offers","add_offers");

                    }

                    if(!empty($data['list_file'])) {
                        $file->insert_file($this->folder, $listid, json_decode($data['list_file'], True));
                    }

                    foreach ($code as $key => $cdo)
                    {


                        $cdo=trim($cdo);
                        $stmtMax1=$this->db->prepare("SELECT  COUNT(offers_item.code) as n_code  FROM offers_item INNER JOIN offers ON offers.id= offers_item.id_offer  WHERE offers_item.code=? AND  offers_item.model =? AND  offers.active =1  ");
                        $stmtMax1->execute(array($cdo,$model[$key]));
                        if($stmtMax1->rowCount() > 0)
                        {
                            $n=$stmtMax1->fetch(PDO::FETCH_ASSOC);

                            if ($n['n_code'] > 1)
                            {
                                $stmtMax2=$this->db->prepare("SELECT  offers_item.id FROM offers_item INNER JOIN offers ON offers.id= offers_item.id_offer  WHERE offers_item.code=? AND  offers_item.model =? AND  offers.active =1   ORDER BY offers.id DESC LIMIT 1 ");
                                $stmtMax2->execute(array($cdo,$model[$key]));
                                if ($stmtMax2->rowCount()> 0)
                                {
                                    $active[$key]=1;
                                }else
                                {
                                    $active[$key]=0;
                                }
                            }

                        }



                        if ($model[$key] == 'savers') {
                            $table='product_savers';
                        }else{
                            $table= $model[$key];
                        }
                        $this->db->update($table,array('active'=>$active[$key]), "`id`=$id_item[$key]");

                        if ($model[$key] == 'savers')
                        {
                            $stmt = $this->db->prepare("INSERT INTO `{$this->offers_item}` (`model`,`title`,`code`,`img`,`color`,`code_color`,`size`,`active`,`userId`,`date`,`id_item`,`id_offer`,`ids_cat`,`latiniin_or_code`,`cover_type_offer`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                            $stmt->execute(array($model[$key],$names[$key],$cdo,$imgitem[$key],$color[$key],$code_color[$key],$size[$key],$active[$key],$this->userid,time(),$id_item[$key],$listid,$ids_cat[$key],trim($latiniin_or_code[$key]),$cover_type_offer[$key]));

                            $idLast= $this->db->lastInsertId();
                            $this->Add_to_sync_schedule($idLast,"offers_item","add_offers_item");

                        }else
                        {
                            $stmt = $this->db->prepare("INSERT INTO `{$this->offers_item}` (`model`,`title`,`code`,`img`,`color`,`code_color`,`size`,`active`,`userId`,`date`,`id_item`,`id_offer`,`ids_cat`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                            $stmt->execute(array($model[$key],$names[$key],$cdo,$imgitem[$key],$color[$key],$code_color[$key],$size[$key],$active[$key],$this->userid,time(),$id_item[$key],$listid,$ids_cat[$key]));

                            $idLast= $this->db->lastInsertId();
                            $this->Add_to_sync_schedule($idLast,"offers_item","add_offers_item");
                        }

                    }
                }


            }else
            {
                echo $error;
            }

        }

        catch (Exception $e)
        {
            $data =$form -> fetch();
            $this->error_form=$e -> getMessage();
        }

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






    function edit($id)
    {

        if (!is_numeric($id)) { $error = new Errors(); $error->index();}
        $this->checkPermit('edit',$this->folder);
        $data=$this->db->select("SELECT * from {$this->table} WHERE `id`=:id LIMIT 1 ",array(':id'=>$id));
        $data=$data[0];
        $id_old_img=$data['imgid'];
        $oldImg=$data['img'];
        $activeOffer=$data['active'];
        $this->adminHeaderController($data['title'],$id);


        $data_cat=array();

        $stmt=$this->db->prepare("SELECT * FROM `offer_categories` ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data_cat[]=  $row;
        }



        $image=array();
        $stmt_image = $this->db->prepare("SELECT * from `files` WHERE `relid`=? AND `rand_name`=? AND `module`=?   LIMIT 1  ");
        $stmt_image->execute(array($id,$data['img'],$this->folder));
        while ($row =$stmt_image->fetch(PDO::FETCH_ASSOC))
        {
            $row['url']=$this->save_file.$row['rand_name'];
            $image[]=$row;
        }

        if (empty($image))
        {
            $image[0]['url']=$this->save_file.$data['img'];
            $image[0]['id']=0;

        }



        $list=array();
        $stmt_list = $this->db->prepare("SELECT * from `files` WHERE  `rand_name` <>  ? AND  `relid`=? AND     `module`=?  AND `lang`='{$this->langControl}'  ");
        $stmt_list->execute(array($data['img'],$id,$this->folder));
        while ($row =$stmt_list->fetch(PDO::FETCH_ASSOC))
        {
            if (file_exists($this->root_file.$row['rand_name'])) {
                $row['url'] = $this->save_file . $row['rand_name'];
                $list[] = $row;
            }
        }



        $stmtItem=$this->db->prepare("SELECT * FROM `offers_item` WHERE id_offer=? ");
        $stmtItem->execute(array($id));
        $item=array();
        $lastIdIten=0;
        while ($rowItem = $stmtItem->fetch(PDO::FETCH_ASSOC))
        {
            $lastIdIten=$rowItem['id'];
            $item[]=  $rowItem;
        }
        $lastIdIten=$lastIdIten+1;

        try
        {
            $form =new Form();

            $form  ->post('title')
                ->val('is_empty','مطلوب')
                ->val('strip_tags',TAG);
            $form  ->post('countdown')
                ->val('strip_tags',TAG);

            $form  ->post('content')
                ->val('strip_tags',TAG);

            $form  ->post('description')
                ->val('strip_tags',TAG);

            $form  ->post('id_offer_categories')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('total_price')
                ->val('strip_tags',TAG);

            $form  ->post('rate')
                ->val('strip_tags',TAG);

            $form  ->post('fromdate_normal')
                ->val('strip_tags',TAG);

            $form  ->post('todate_normal')
                ->val('strip_tags',TAG);

            $form  ->post('main_img')
                ->val('strip_tags');

            $form  ->post('list_file')
                ->val('strip_tags');

            $form  ->post('model')
                ->val('is_array')
                ->val('strip_tags');


            $form  ->post('code')
                ->val('is_array')
                ->val('strip_tags');


            $form  ->post('names')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('id_item')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('ids_cat')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('imgitem')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('active')
                ->val('is_array')
                ->val('strip_tags');


            $form  ->post('color')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('code_color')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('size')
                ->val('is_array')
                ->val('strip_tags');


            $form  ->post('latiniin_or_code')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('cover_type_offer')
                ->val('is_array')
                ->val('strip_tags');

            $form ->submit();
            $data =$form -> fetch();

            $file=new Files();

            $data['userId']=$this->userid;


            $data['id_offer_categories']=implode(',',json_decode($data['id_offer_categories'],true));
            $code=json_decode($data['code'],true);
            $names=json_decode($data['names'],true);
            $id_item=json_decode($data['id_item'],true);
            $ids_cat=json_decode($data['ids_cat'],true);
            $model=json_decode($data['model'],true);
            $active=json_decode($data['active'],true);
            $imgitem=json_decode($data['imgitem'],true);
            $color=json_decode($data['color'],true);
            $code_color=json_decode($data['code_color'],true);
            $size=json_decode($data['size'],true);
            $latiniin_or_code=json_decode($data['latiniin_or_code'],true);
            $cover_type_offer=json_decode($data['cover_type_offer'],true);

            $main_image = json_decode($data['main_img'], true);
            if (empty($oldImg) &&  $_FILES['image']['error'][0] != 4) {
                $image = array();
                if (count($code) == 1) {
                    if (empty($main_image) && $_FILES['image']['error'][0] != 4) {
                        $image = $this->save_file($_FILES['image']);
                        $main_image[0]['rand_name'] = $image[0];

                    } else {
                        if (empty($main_image)) {
                            $main_image[0]['rand_name'] = $imgitem[0];
                        }

                    }
                } else {
                    if (empty($main_image)) {
                        $error = 1; // يجب رفع صورة رئيسية للعرض
                    }
                }
            }

            $active_new=array();
            foreach ($active as $act)
            {
                $active_new[]=$act;
            }

            $data['ids_cat']=implode(',',$ids_cat);
            $data['model']=implode(',',$model);
            $data['fromdate']=strtotime($data['fromdate_normal']);
            $data['todate']=strtotime($data['todate_normal']);


            if ( $data['total_price'] &&  $data['rate'])
            {
                $data['active']=2;
                $data['note']=  'سعر كلي  و نسبة تخفيض مدخلة معاَ ' ;
            }else
            {
                $data['active']=$activeOffer;
                $data['note']=  '' ;
            }

            if(!empty($data['main_img'])) {
                $file->delete_file_and_row($id_old_img);
                $id_file= $file->insert_file($this->folder, $id , $main_image);
                $data['img']=$main_image[0]['rand_name'];
                $data['imgid']=$id_file;
            }

            if(!empty($data['list_file'])) {
                $file->insert_file($this->folder, $id, json_decode($data['list_file'], True));
            }


            $this->db->update($this->table, array_diff_key($data,['imgitem'=>"delete",'color'=>"delete",'code_color'=>"delete",'size'=>"delete",'list_file'=>"delete",'main_img'=>"delete",'code'=>"delete",'names'=>"delete",'id_item'=>"delete",'latiniin_or_code'=>"delete",'cover_type_offer'=>"delete"]), "id={$id}");

            $this->check_one_itemoffers($id);

            $this->Add_to_sync_schedule($id,"offers","add_offers");

            foreach ($code as $key => $cdo)
            {

                $cdo=trim($cdo);
                $stmtMax1=$this->db->prepare("SELECT  COUNT(offers_item.code) as n_code  FROM offers_item INNER JOIN offers ON offers.id= offers_item.id_offer  WHERE offers_item.code=? AND  offers_item.model =? AND  offers.active =1 AND  offers.id <> ? ");
                $stmtMax1->execute(array($cdo,$model[$key],$id));
                if($stmtMax1->rowCount() > 0)
                {
                    $n=$stmtMax1->fetch(PDO::FETCH_ASSOC);

                    if ($n['n_code'] > 1)
                    {
                        $stmtMax2=$this->db->prepare("SELECT  offers_item.id FROM offers_item INNER JOIN offers ON offers.id= offers_item.id_offer  WHERE offers_item.code=? AND  offers_item.model =? AND  offers.active =1   AND  offers.id <> ? ORDER BY offers.id DESC LIMIT 1 ");
                        $stmtMax2->execute(array($cdo,$model[$key],$id));
                        if ($stmtMax2->rowCount()> 0)
                        {
                            $active[$key]=1;
                        }else
                        {
                            $active[$key]=0;
                        }
                    }

                }

                if ($model[$key] == 'savers') {
                    $table='product_savers';
                }else{
                    $table= $model[$key];
                }
                $this->db->update($table,array('active'=>$active[$key]), "`id`=$id_item[$key]");



                if ($model[$key] == 'savers')
                {
                    $stmt = $this->db->prepare("INSERT INTO `{$this->offers_item}` (`id`,`model`,`title`,`code`,`img`,`color`,`code_color`,`size`,`active`,`userId`,`date`,`id_item`,`id_offer`,`ids_cat`,`latiniin_or_code`,`cover_type_offer`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)   ON DUPLICATE KEY UPDATE                                                                                                                                                                      
                                                                               `id`=VALUES(id) ,`model`=VALUES(model) ,`title`=VALUES(title)  ,`code`=VALUES(code) ,`img`=VALUES(img)  ,`active`=VALUES(active)  
                                                                               , `color`=VALUES(color) ,`code_color`=VALUES(code_color)  ,`size`=VALUES(size)
                                                                               ,`userId`=VALUES(userId)  ,`date`=VALUES(date)  ,`id_item`=VALUES(id_item) ,`id_offer`=VALUES(id_offer) ,`ids_cat`=VALUES(ids_cat) ,`latiniin_or_code`=VALUES(latiniin_or_code) ,`cover_type_offer`=VALUES(cover_type_offer)  ");
                    $stmt->execute(array($key,$model[$key],$names[$key],$cdo,$imgitem[$key],$color[$key],$code_color[$key],$size[$key],$active[$key],$this->userid,time(),$id_item[$key],$id,$ids_cat[$key],trim($latiniin_or_code[$key]),$cover_type_offer[$key]));

                    $listiditem=$this->db->lastInsertId();
                    $this->Add_to_sync_schedule($listiditem,"offers_item","add_offers_item");

                }else
                {
                    $stmt = $this->db->prepare("INSERT INTO `{$this->offers_item}` (`id`,`model`,`title`,`code`,`img`,`color`,`code_color`,`size`,`active`,`userId`,`date`,`id_item`,`id_offer`,`ids_cat`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?)   ON DUPLICATE KEY UPDATE                                                                                                                                                                      
                                                                               `id`=VALUES(id) ,`model`=VALUES(model) ,`title`=VALUES(title)  ,`code`=VALUES(code) ,`img`=VALUES(img)  ,`active`=VALUES(active)  
                                                                               , `color`=VALUES(color) ,`code_color`=VALUES(code_color)  ,`size`=VALUES(size)
                                                                               ,`userId`=VALUES(userId)  ,`date`=VALUES(date)  ,`id_item`=VALUES(id_item) ,`id_offer`=VALUES(id_offer) ,`ids_cat`=VALUES(ids_cat)  ");
                    $stmt->execute(array($key,$model[$key],$names[$key],$cdo,$imgitem[$key],$color[$key],$code_color[$key],$size[$key],$active[$key],$this->userid,time(),$id_item[$key],$id,$ids_cat[$key]));

                    $listiditem=$this->db->lastInsertId();
                    $this->Add_to_sync_schedule($listiditem,"offers_item","add_offers_item");
                }




            }


            $this->lightRedirect(url . '/' . $this->folder . '/list_offers', 0);


        }
        catch (Exception $e)
        {
            $this->error_form= $e -> getMessage();
        }

        require ($this->render($this->folder,'html','edit','php'));
        $this->adminFooterController();
    }


    public function visible($v_,$id_)
    {
        if ($this->handleLogin() )
        {

            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }
            $data = $this->db->update($this->table, array('active' => $v), "`id`={$id}");
            echo 'true';
            $this->Add_to_sync_schedule($id,"offers","add_offers");
        }
    }





    function delete_image($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->update($this->table,array('img'=>0),"`id`={$id}");
            echo 'true';
            $this->Add_to_sync_schedule($id,"offers","add_offers");
        }
    }

    public function getAlloffers()
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE   `active`=1 ORDER BY `id` DESC LIMIT 5");
        $stmt->execute();
        return $stmt->fetchAll();
    }




    public  function details($id)
    {

        if (!is_numeric($id)) {$error=new Errors(); $error->index();}


        $data_cat=array();
        foreach ($this->category_website as $key => $cat)
        {
            $stmt=$this->db->prepare("SELECT id FROM `offers` WHERE  FIND_IN_SET('$key',model)  AND `active`=1  LIMIT 1 ");
            $stmt->execute();
            if ($stmt->rowCount() > 0)
            {
                $data_cat[$key] =  $cat;
            }

        }



        $stmt=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE  `id` = ? AND `active`=1");
        $stmt->execute(array($id));
        $result=$stmt->fetch (PDO::FETCH_ASSOC) ;

        if (empty($result))
        {
            $this->lightRedirect(url);
        }

        $item=array();
        $stmtItem=$this->db->prepare("SELECT *FROM `offers_item` WHERE  `id_offer` = ?    GROUP BY id_item,model ");
        $stmtItem->execute(array($id));
        while($row=$stmtItem->fetch (PDO::FETCH_ASSOC))
        {

            if ($row['model'] == 'mobile') {
                $excel = 'excel';
            }else{
                $excel = 'excel_' . $row['model'] ;
            }


            $row['details'.$row['id']]=array();

            $type_device[$row['id']]=array();

            if ($row['model'] ==  'savers')
            {
                if ($row['cover_type_offer'] ==1)
                {



                    $list_latiniin_or_code=explode(',',$row['latiniin_or_code']);
                    $latiniin_or_code='';
                    foreach ($list_latiniin_or_code as $lc)
                    {
                        $latiniin_or_code.="'$lc',";
                    }

                    $latiniin_or_code = rtrim($latiniin_or_code, ',');


                    $stmtItemDetails=$this->db->prepare("SELECT product_savers.*,type_device.title FROM `product_savers`  INNER  JOIN type_device ON type_device.id = product_savers.id_device  INNER  JOIN {$excel} ON  {$excel}.code=product_savers.code WHERE ( product_savers.`latiniin`  IN({$latiniin_or_code}) OR    product_savers.`code`  IN({$latiniin_or_code}) )  AND {$excel}.quantity > 0 ");
                    $stmtItemDetails->execute();
                    while($details=$stmtItemDetails->fetch (PDO::FETCH_ASSOC))
                    {

                        $type_device[$row['id']][$details['id_device']]= $details['title'];
                        $details['image']=$this->save_file.$details['img'];

                        $row['details'.$row['id']][$details['id_device']][]=$details;
                    }

                }

                /*
                               else  if ($row['cover_type_offer'] ==2)
                               {
                                   $list_latiniin_or_code=explode(',',$row['latiniin_or_code']);

                                   $latiniin_or_code='';
                                   foreach ($list_latiniin_or_code as $lc)
                                   {
                                       $latiniin_or_code.="'$lc',";
                                   }

                                   $latiniin_or_code = rtrim($latiniin_or_code, ',');



                                   $stmtItemDetails=$this->db->prepare("SELECT product_savers.*,type_device.title FROM `product_savers` INNER  JOIN type_device ON type_device.id = product_savers.id_device INNER  JOIN {$excel} ON  {$excel}.code=product_savers.code WHERE  product_savers.`code` IN({$latiniin_or_code})     AND {$excel}.quantity > 0 ");
                                   $stmtItemDetails->execute();
                                   while($details=$stmtItemDetails->fetch (PDO::FETCH_ASSOC))
                                   {

                                       $type_device[$details['id_device']]= $details['title'];
                                       $details['image']=$this->save_file.$details['img'];

                                       $row['details'.$row['id']][$details['id_device']][]=$details;
                                   }
                               }*/

                else  if ($row['cover_type_offer'] ==2)
                {
                    $list_latiniin_or_code=explode(',',$row['latiniin_or_code']);

                    $char=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
                    $list_number='';
                    foreach($list_latiniin_or_code as $test) {
                        foreach ($char as $ch)
                        {
                            if (strpos($test, $ch) !== false) {

                                $sprat=explode($ch,$test);
                                $sprat[0]=trim(str_replace('fa','',$sprat[0]));
                                $sprat[0]=trim(str_replace('ml','',$sprat[0]));
                                $list_number.="  product_savers.`latiniin` LIKE '%".$sprat[0].$ch."%' OR";
                                break;
                            }
                        }
                    }



                    $latiniin_or_code = rtrim($list_number, 'OR');
                    $stmtItemDetails=$this->db->prepare("SELECT product_savers.*,type_device.title FROM `product_savers` INNER  JOIN type_device ON type_device.id = product_savers.id_device INNER  JOIN {$excel} ON  {$excel}.code=product_savers.code WHERE  {$latiniin_or_code}    AND {$excel}.quantity > 0 ");
                    $stmtItemDetails->execute();
                    while($details=$stmtItemDetails->fetch (PDO::FETCH_ASSOC))
                    {
                        $type_device[$row['id']][$details['id_device']]= $details['title'];
                        $details['image']=$this->save_file.$details['img'];
                        $row['details'.$row['id']][$details['id_device']][]=$details;
                    }
                }

                else if ($row['cover_type_offer'] ==3)
                {

                    $list_latiniin_or_code=explode(',',$row['latiniin_or_code']);

                    $list_number='';
                    foreach($list_latiniin_or_code as $test) {
                        $list_number.="  product_savers.`latiniin` LIKE '%".$test."%' OR";

                    }

                    $latiniin_or_code = rtrim($list_number, 'OR');


                    $stmtItemDetails=$this->db->prepare("SELECT product_savers.*,type_device.title FROM `product_savers`  INNER  JOIN type_device ON type_device.id = product_savers.id_device  INNER  JOIN {$excel} ON  {$excel}.code=product_savers.code WHERE  {$latiniin_or_code}     AND {$excel}.quantity > 0 ");
                    $stmtItemDetails->execute();
                    while($details=$stmtItemDetails->fetch (PDO::FETCH_ASSOC))
                    {

                        $type_device[$row['id']][$details['id_device']]= $details['title'];
                        $details['image']=$this->save_file.$details['img'];

                        $row['details'.$row['id']][$details['id_device']][]=$details;
                    }

                }


            }else
            {
                $stmtItemDetails=$this->db->prepare("SELECT offers_item.id,offers_item.color,offers_item.code_color,offers_item.size  FROM `offers_item` INNER  JOIN {$excel} ON  {$excel}.code=offers_item.code WHERE  offers_item.`id_offer` = ? AND offers_item.id_item=? AND offers_item.`model`=?  AND {$excel}.quantity > 0 ");
                $stmtItemDetails->execute(array($id,$row['id_item'],$row['model']));
                while($details=$stmtItemDetails->fetch (PDO::FETCH_ASSOC))
                {
                    $row['details'.$row['id']][]=$details;
                }


            }


            $item[]=$row;
        }



        if ($result['range_price'] == 0)
        {
            $result['priceC']=$this->priceDollarOffer($id,4);
            $result['price']=$result['priceC'] . '  د.ع ';

        }else
        {
            if ($this->loginUser())
            {
                $result['priceC']=$this->priceDollarOffer($id,4);
                $result['price']=$result['priceC'] . '  د.ع ';

            }else
            {
                $result['priceC']=$this->priceDollarOffer($id,5);
                $result['price']=$result['priceC'] . '  د.ع ';

            }

        }



        $image=array();
        if (empty($image))
        {
            $image[0]=$this->save_file.$result['img'];
        }


        $stmt_list = $this->db->prepare("SELECT `rand_name`  from `files` WHERE  `rand_name` <>  ? AND  `relid`=? AND     `module`=?     ");
        $stmt_list->execute(array($result['img'],$id,$this->folder));
        while ($row =$stmt_list->fetch(PDO::FETCH_ASSOC))
        {
            if (file_exists($this->root_file.$row['rand_name']))
            {
                $image[]=$this->save_file.$row['rand_name'];
            }
        }



        $date=time();
        $stmtOffer=$this->db->prepare("SELECT *FROM  offers WHERE  id <> ? AND     `active`=1 AND {$date} BETWEEN `fromdate` AND `todate` order by RAND() LIMIT 6 ");
        $stmtOffer->execute(array($id));
        $random=array();
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
            $random[]=$row;
        }





        require ($this->render($this->folder,'html','details','php'));
    }




    function remove_file($id,$id_file,$type='img')
    {
        if ($this->handleLogin() ) {
            $file = new Files();
            if ($type == 'img') {
                $this->db->update($this->table, array('img' => '','imgid' => 0), "`id`={$id} AND `imgid` = {$id_file}  ");

                $this->Add_to_sync_schedule($id,"offers","add_offers");
                $file->delete_file_and_row($id_file);
                echo 'true';
            } else if ($type == 'video') {
                $this->db->update($this->table, array('id_video' => 0), "`id`={$id} AND `imgid` = {$id_file} ");

                $this->Add_to_sync_schedule($id,"offers","add_offers");
                $file->delete_file_and_row($id_file);
                echo 'true';
            } else {
                $file->delete_file_and_row($id_file);
                echo 'true';
            }
        }

    }




    function cart_order($idOffer)
    {

        if (is_numeric($idOffer)) {
            $item_off=$_POST['details_offer'];
            $ids_item_off_savers=array(0);
            foreach ($item_off as $key => $itm)
            {
                if (is_numeric($itm)){
                    $ids_item_off[$key]=$itm;
                    if (is_numeric($key))
                    {  $ids_item_off_savers[$key]=$key;

                    }

                }

            }


            $ids_item_off=implode(',',$ids_item_off);
            $ids_item_off_savers=implode(',',$ids_item_off_savers);

            if ($this->check_one_itemoffers($idOffer)) {


                $stmtOfferCh = $this->db->prepare("SELECT *FROM offers_item WHERE id_offer=? AND (  id IN({$ids_item_off}) OR  id IN({$ids_item_off_savers}) ) ");
                $stmtOfferCh->execute(array($idOffer));

                while ($rowItemCh = $stmtOfferCh->fetch(PDO::FETCH_ASSOC)) {


                    if ($rowItemCh['model'] == 'mobile') {
                        $excel = 'excel';
                    } else {
                        $excel = 'excel_' . $rowItemCh['model'];
                    }

                    if ($rowItemCh['model'] !='savers')
                    {
                        $stmtItemDetails = $this->db->prepare("SELECT {$excel}.quantity FROM  {$excel}  WHERE  code =  ?   AND {$excel}.quantity  <= 0 ");
                        $stmtItemDetails->execute(array($rowItemCh['code']));
                        if ($stmtItemDetails->rowCount() > 0) {
                            die('نفذ اللون الذي تم اختيارة من مادة  ' . $rowItemCh['title'] . " يرجى اختيار لون اخر ");
                        }

                    }else
                    {



                        $stmtCove=$this->db->prepare("SELECT  code FROM `product_savers` WHERE  `id`=? ");
                        $stmtCove->execute(array($item_off[$rowItemCh['id']]));
                        if ($stmtCove->rowCount() > 0)
                        {
                            $resultCover=$stmtCove->fetch(PDO::FETCH_ASSOC);

                            $stmtItemDetails = $this->db->prepare("SELECT {$excel}.quantity FROM  {$excel}  WHERE  code =  ?   AND {$excel}.quantity  <= 0 ");
                            $stmtItemDetails->execute(array($resultCover['code']));
                            if ($stmtItemDetails->rowCount() > 0) {
                                die('يرجى اخيار حافظة اخرى الحافظة التي اخترتها غير متوفرة الان');
                            }
                        }else
                        {
                            die('يرجى اخيار حافظة اخرى الحافظة التي اخترتها غير متوفرة الان');
                        }


                    }





                }


                $date = time();

                $stmtOffer = $this->db->prepare("SELECT *FROM offers_item WHERE id_offer=? AND  (  id IN({$ids_item_off}) OR  id IN({$ids_item_off_savers}) ) ");
                $stmtOffer->execute(array($idOffer));
                while ($rowItem = $stmtOffer->fetch(PDO::FETCH_ASSOC)) {

                    if ($rowItem['model'] == 'mobile') {
                        $excel = 'excel';
                    } else {
                        $excel = 'excel_' . $rowItem['model'];
                    }

                    if ($rowItem['model'] !='savers')
                    {
                        $stmtexcel = $this->db->prepare("SELECT price_dollars FROM {$excel} WHERE `code`=?    LIMIT 1");
                        $stmtexcel->execute(array(trim($rowItem['code'])));
                        if ($stmtexcel->rowCount() > 0) {
                            $price_dollars = trim($stmtexcel->fetch(PDO::FETCH_ASSOC)['price_dollars']);

                            if (!$this->isDirect()) {
                                $data['id_member_r'] = $_SESSION['id_member_r'];
                            } else {
                                $data['id_member_r'] = $this->isUuid();
                                $data['user_direct'] = $this->userid;
                            }

                            $data['number'] = 1;
                            $data['date'] = $date;

                            $data['table'] = $rowItem['model'];
                            $data['image'] = $rowItem['img'];
                            $data['code'] = $rowItem['code'];
                            $data['id_item'] = $rowItem['id_item'];

                            $data['color'] = $rowItem['code_color'];
                            $data['name_color'] = $rowItem['color'];
                            $data['size'] = $rowItem['size'];

                            $data['id_offer'] = $idOffer;
                            $data['offers'] = 'offers';
                            $data['date_offer'] =$date;

                            $data['price_dollars'] =$price_dollars * $this->priceDollarOffer($idOffer, 6) ;

                            $dollar = new Dollar_price();
                            $data['dollar_exchange'] = $dollar->dollar_get();
                            $stmt_chx = $this->db->prepare("SELECT   * FROM `cart_shop_active` WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ? AND `id_offer`=?  AND `offers` =? ");
                            $stmt_chx->execute(array($rowItem['id_item'], $rowItem['code'], $rowItem['model'], $data['id_member_r'], $idOffer, 'offers'));

                            $this->db->insert($this->cart_shop_active, $data);


                        }
                    }else
                    {



                        $stmtCove=$this->db->prepare("SELECT  * FROM `product_savers` WHERE  `id`=? ");
                        $stmtCove->execute(array($item_off[$rowItem['id']]));
                        $resultCover=$stmtCove->fetch(PDO::FETCH_ASSOC);

                        $stmtexcel = $this->db->prepare("SELECT price_dollars FROM {$excel} WHERE `code`=?    LIMIT 1");
                        $stmtexcel->execute(array(trim($resultCover['code'])));
                        if ($stmtexcel->rowCount() > 0) {
                            $price_dollars = trim($stmtexcel->fetch(PDO::FETCH_ASSOC)['price_dollars']);

                            if (!$this->isDirect()) {
                                $data['id_member_r'] = $_SESSION['id_member_r'];
                            } else {
                                $data['id_member_r'] = $this->isUuid();
                                $data['user_direct'] = $this->userid;
                            }

                            $data['number'] = 1;
                            $data['date'] = $date;

                            $data['table'] = 'product_savers';
                            $data['image'] = $resultCover['img'];
                            $data['code'] = $resultCover['code'];
                            $data['id_item'] = $resultCover['id'];

                            $data['color'] = $resultCover['code_color'];
                            $data['name_color'] = $resultCover['color'];
                            $data['size'] = '';

                            $data['id_offer'] = $idOffer;
                            $data['offers'] = 'offers';
                            $data['date_offer'] =$date;

                            $data['price_dollars'] =$price_dollars * $this->priceDollarOffer($idOffer, 6) ;

                            $dollar = new Dollar_price();
                            $data['dollar_exchange'] = $dollar->dollar_get();
                            $stmt_chx = $this->db->prepare("SELECT   * FROM `cart_shop_active` WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ? AND `id_offer`=?  AND `offers` =? ");
                            $stmt_chx->execute(array($resultCover['id'], $resultCover['code'],'product_savers', $data['id_member_r'], $idOffer, 'offers'));

                            $this->db->insert($this->cart_shop_active, $data);


                        }
                    }

                }
                echo 'add';




            } else {
                echo 'finish';
            }

        }else
        {
            echo 'idx';
        }


    }





    function x()
    {
        $this->priceDollarOffer(27,1);
    }


    function count_c()
    {
        if ($this->isDirect())
        {
            $id=$this->isUuid();
        }else{
            $id= $_SESSION['id_member_r'];
        }

        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`, `number`,`buy`,`date` FROM `{$this->cart_shop_active}` WHERE `id_member_r` =?  AND `buy` = 0 GROUP BY `offers`,`id_offer`,`date`  ORDER BY `id`  DESC  ");
        $stmt->execute(array($id));
        $car=array();
        $count=0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $count=$count+$row['number'];
        }

        echo $count;

    }



    public function getAllContentFromCar_new($id_member_r)
    {
        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`, `number`,`buy`,`date` FROM `{$this->cart_shop_active}` WHERE `id_member_r` =?  AND `buy` = 0 GROUP BY `offers`,`id_offer`  ORDER BY `id`  DESC  ");
        $stmt->execute(array($id_member_r));
        return $stmt;
    }


    function delete_row_database()
    {

        if ($this->handleLogin())
        {

            $id=$_GET['id'];
            $code=$_GET['code'];
            $model=$_GET['model'];

            $stmt=$this->db->prepare("DELETE FROM offers_item WHERE  id =? AND  code =? AND model =?  ");
            $stmt->execute(array($id,$code,$model));
            if ($stmt->rowCount() > 0)
            {
                echo 'true';

                $this->Add_to_sync_schedule($id,"offers_item","delete_offers_item");

            }

        }

    }


}