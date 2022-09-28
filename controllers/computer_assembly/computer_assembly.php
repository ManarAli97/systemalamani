<?php

class computer_assembly extends Controller
{
    public $ids=array();


    function __construct()
    {
        parent::__construct();
        $this->table='computer_assembly';
        $this->computer_assembly_item='computer_assembly_item';
        $this->computer_assembly_categories = 'computer_assembly_categories';
        $this->cart_shop_active='cart_shop_active';
        $this->menu=new Menu();
        $this-> setting=new  setting();




        $this->check_all_itemcomputer_assembly();



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
           `id_computer_assembly_categories` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
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



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->computer_assembly_item}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `id_computer_assembly` int(10) NOT NULL,
           `id_item` int(10) NOT NULL,
           `ids_cat` int(10) NOT NULL,
           `img` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `code_color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `size` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `imgid` int(10) NOT NULL,
           `active` int(10) NOT NULL DEFAULT '0',
           `cover_type_computer_assembly` int(10) NOT NULL DEFAULT '0',
           `lang` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `latiniin_or_code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");




        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->computer_assembly_categories}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `active` int(10) NOT NULL DEFAULT '0',
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return  $this->db->cht(array($this->table,$this->computer_assembly_categories,$this->computer_assembly_item));

    }


    function filter($id_cat)
    {

        $date=time();

        if ($id_cat=='all')
        {
            $stmtcomputer_assembly=$this->db->prepare("SELECT *FROM  computer_assembly WHERE   `active`=1 AND `delete`=0 AND  {$date} BETWEEN `fromdate` AND `todate` ");
            $stmtcomputer_assembly->execute(array($id_cat));

        }else
        {

            $stmtcomputer_assembly=$this->db->prepare("SELECT *FROM  computer_assembly WHERE   FIND_IN_SET(?,model) AND `active`=1 AND `delete`=0 AND {$date} BETWEEN `fromdate` AND `todate` ");
            $stmtcomputer_assembly->execute(array($id_cat));
        }


        $computer_assembly=array();
        while ($row = $stmtcomputer_assembly->fetch(PDO::FETCH_ASSOC))
        {

            $row['dollar']= $this->priceDollarcomputer_assembly($row['id'],3);

            if ($row['range_price'] == 0)
            {
                $row['priceC']=$this->priceDollarcomputer_assembly($row['id'],4);
                $row['range']=$row['priceC'] . '  د.ع ';

            }else
            {
                if ($this->loginUser())
                {
                    $row['priceC']=$this->priceDollarcomputer_assembly($row['id'],4);
                    $row['range']=$row['priceC'] . '  د.ع ';

                }else
                {
                    $row['priceC']=$this->priceDollarcomputer_assembly($row['id'],5);
                    $row['range']=$row['priceC'] . '  د.ع ';

                }

            }
            $row['image']=$this->show_file_site.$row['img'];
            $computer_assembly[]=$row;
        }



        require ($this->render($this->folder,'html','filter','php'));


    }

    public function index(){



        $stmtcomputer_assembly=$this->db->prepare("SELECT *FROM  computer_assembly WHERE      `active`=1 AND `delete`=0   ORDER  BY `date` DESC ");
        $stmtcomputer_assembly->execute();
        $computer_assembly=array();
        while ($row = $stmtcomputer_assembly->fetch(PDO::FETCH_ASSOC))
        {


            if ($this->loginUser())
            {
                $row['priceC']= number_format($this->getPriceComputerAssembly($row['id']));
                $row['range']=$row['priceC'] . '  د.ع ';

            }else
            {
                $row['priceC']=$this->price_dollars($this->getPriceComputerAssembly($row['id']));
                $row['range']=$row['priceC'] . '  د.ع ';

            }

            $row['image']=$this->show_file_site.$row['img'];
            $computer_assembly[]=$row;
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




    public function list_computer_assembly()
    {
        $this->checkPermit('list_computer_assembly',$this->folder);
        $this->adminHeaderController($this->langControl('computer_assembly'));


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





        require ($this->render($this->folder,'html','list_computer_assembly','php'));
        $this->adminFooterController();

    }





    public function processing($model=null,$id=null)
    {

        $table = $this->table;
        $primaryKey = 'id';
        $category='category_'.$model;
        $columns = array(

            array( 'db' => 'title', 'dt' => 0 ),


            array( 'db' => 'id', 'dt' =>  1 ,
                'formatter' => function( $d, $row ) {
                    return  $this->getPriceComputerAssembly($d,1);
                }
            ),

            array( 'db' => 'id', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                    return  $this->price_dollarsAdmin( $this->getPriceComputerAssembly($d,1));
                }
            ),




            array( 'db' => 'date', 'dt' =>  3 ,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);

                }
            ),

            array( 'db' => 'note', 'dt' =>  4 ,
                'formatter' => function( $d, $row ) {
                    return   $d ;
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 5,
                'formatter' => function($id, $row ) {
                    if ($this->permit('visible','computer_assembly')) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch($id)} class='toggle-demo' onchange='visible_news(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-computer_assembly{$id}'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
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
                'dt'        => 6,
                'formatter' => function($id, $row ) {
                    if ($this->permit('edit','computer_assembly')) {
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
                'dt'        => 7,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete','computer_assembly')) {
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


            array('db' =>   'note2', 'dt' => 8,
                'formatter' => function ($d, $row) {
                    if ($this->permit('write_note', $this->folder)) {

                        if ($this->ch($row[9]) != 'checked') {
                            return "
             
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-12' style='padding: 0'>		
				  	       <textarea rows='5'  onkeyup=saveNote('" . $row[9] . "')  id='add_note_{$row[9]}'   type='text' class='form-control withBill'  required>{$d}</textarea>
                   </div>
				 
                  </div>
                    ";
                        }else
                        {
                            return "
             
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-12' style='padding: 0'>		
				  	       <textarea rows='5' readonly onkeyup=saveNote('" . $row[9] . "')  id='add_note_{$row[9]}'   type='text' class='form-control withBill'  required>{$d}</textarea>
                   </div>
				 
                  </div>
                    ";
                        }

                    } else {
                        return 'لا توجد صلاحية';
                    }

                }
            ),

            array(  'db' => 'id', 'dt'=> 9 )/*18*/

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
            if ($model=='double_computer_assembly')
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




    public function list_computer_assembly_active()
    {
        $this->checkPermit('list_computer_assembly_active',$this->folder);
        $this->adminHeaderController($this->langControl('computer_assembly'));


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





        require ($this->render($this->folder,'html','list_computer_assembly_active','php'));
        $this->adminFooterController();

    }





    public function processing_active($model=null,$id=null)
    {

        $table = $this->table;
        $primaryKey = 'id';
        $category='category_'.$model;
        $columns = array(

            array( 'db' => 'title', 'dt' => 0 ),


            array( 'db' => 'id', 'dt' =>  1 ,
                'formatter' => function( $d, $row ) {
                    return  $this->getPriceComputerAssembly($d,1);
                }
            ),

            array( 'db' => 'id', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                    return  $this->price_dollarsAdmin( $this->getPriceComputerAssembly($d,1));
                }
            ),




            array( 'db' => 'date', 'dt' =>  3 ,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);

                }
            ),

            array( 'db' => 'note', 'dt' =>  4 ,
                'formatter' => function( $d, $row ) {
                    return   $d ;
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 5,
                'formatter' => function($id, $row ) {
                    if ($this->permit('visible','computer_assembly')) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch($id)} class='toggle-demo' onchange='visible_news(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-computer_assembly{$id}'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
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
                'dt'        => 6,
                'formatter' => function($id, $row ) {
                    if ($this->permit('edit','computer_assembly')) {
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
                'dt'        => 7,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete','computer_assembly')) {
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


            array('db' =>   'note2', 'dt' => 8,
                'formatter' => function ($d, $row) {
                    if ($this->permit('write_note', $this->folder)) {

                        if ($this->ch($row[9]) != 'checked') {
                            return "
             
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-12' style='padding: 0'>		
				  	       <textarea rows='5'  onkeyup=saveNote('" . $row[9] . "')  id='add_note_{$row[9]}'   type='text' class='form-control withBill'  required>{$d}</textarea>
                   </div>
				 
                  </div>
                    ";
                        }else
                        {
                            return "
             
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-12' style='padding: 0'>		
				  	       <textarea rows='5' readonly onkeyup=saveNote('" . $row[9] . "')  id='add_note_{$row[9]}'   type='text' class='form-control withBill'  required>{$d}</textarea>
                   </div>
				 
                  </div>
                    ";
                        }

                    } else {
                        return 'لا توجد صلاحية';
                    }

                }
            ),

            array(  'db' => 'id', 'dt'=> 9 )/*18*/

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
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 0 AND   `active` = 1 AND model LIKE '%{$model}%' AND ({$fieldDetails}) ")
            );
        }
        else if ($model)
        {
            if ($model=='double_computer_assembly')
            {
                echo json_encode(
                // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 0 AND `active` = 1  AND model LIKE '%,%' ")
                );

            }else
            {
                echo json_encode(
                // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 0 AND  `active` = 1  AND model LIKE '%{$model}%' ")
                );

            }


        }else
        {
            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 0 AND  `active` = 1   ")
            );
        }
    }



    public function list_computer_assembly_stopped()
    {
        $this->checkPermit('list_computer_assembly_stopped',$this->folder);
        $this->adminHeaderController($this->langControl('computer_assembly'));


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





        require ($this->render($this->folder,'html','list_computer_assembly_stopped','php'));
        $this->adminFooterController();

    }





    public function processing_stopped($model=null,$id=null)
    {

        $table = $this->table;
        $primaryKey = 'id';
        $category='category_'.$model;
        $columns = array(

            array( 'db' => 'title', 'dt' => 0 ),


            array( 'db' => 'id', 'dt' =>  1 ,
                'formatter' => function( $d, $row ) {
                    return  $this->getPriceComputerAssembly($d,1);
                }
            ),

            array( 'db' => 'id', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                    return  $this->price_dollarsAdmin( $this->getPriceComputerAssembly($d,1));
                }
            ),




            array( 'db' => 'date', 'dt' =>  3 ,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);

                }
            ),

            array( 'db' => 'note', 'dt' =>  4 ,
                'formatter' => function( $d, $row ) {
                    return   $d ;
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 5,
                'formatter' => function($id, $row ) {
                    if ($this->permit('visible','computer_assembly')) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch($id)} class='toggle-demo' onchange='visible_news(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-computer_assembly{$id}'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
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
                'dt'        => 6,
                'formatter' => function($id, $row ) {
                    if ($this->permit('edit','computer_assembly')) {
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
                'dt'        => 7,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete','computer_assembly')) {
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


            array('db' =>   'note2', 'dt' => 8,
                'formatter' => function ($d, $row) {
                    if ($this->permit('write_note', $this->folder)) {

                        if ($this->ch($row[9]) != 'checked') {
                            return "
             
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-12' style='padding: 0'>		
				  	       <textarea rows='5'  onkeyup=saveNote('" . $row[9] . "')  id='add_note_{$row[9]}'   type='text' class='form-control withBill'  required>{$d}</textarea>
                   </div>
				 
                  </div>
                    ";
                        }else
                        {
                            return "
             
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-12' style='padding: 0'>		
				  	       <textarea rows='5' readonly onkeyup=saveNote('" . $row[9] . "')  id='add_note_{$row[9]}'   type='text' class='form-control withBill'  required>{$d}</textarea>
                   </div>
				 
                  </div>
                    ";
                        }

                    } else {
                        return 'لا توجد صلاحية';
                    }

                }
            ),

            array(  'db' => 'id', 'dt'=> 9 )/*18*/

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
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 0 AND   `active` = 2 AND model LIKE '%{$model}%' AND ({$fieldDetails}) ")
            );
        }
        else if ($model)
        {
            if ($model=='double_computer_assembly')
            {
                echo json_encode(
                // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 0 AND `active` = 2  AND model LIKE '%,%' ")
                );

            }else
            {
                echo json_encode(
                // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 0 AND  `active` = 2  AND model LIKE '%{$model}%' ")
                );

            }


        }else
        {
            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 0 AND  `active` = 2   ")
            );
        }
    }



    public function list_computer_assembly_deleted()
    {
        $this->checkPermit('list_computer_assembly_deleted',$this->folder);
        $this->adminHeaderController($this->langControl('computer_assembly'));


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





        require ($this->render($this->folder,'html','list_computer_assembly_deleted','php'));
        $this->adminFooterController();

    }





    public function processing_deleted($model=null,$id=null)
    {

        $table = $this->table;
        $primaryKey = 'id';
        $category='category_'.$model;
        $columns = array(

            array( 'db' => 'title', 'dt' => 0 ),


            array( 'db' => 'id', 'dt' =>  1 ,
                'formatter' => function( $d, $row ) {
                    return  $this->getPriceComputerAssembly($d,1);
                }
            ),

            array( 'db' => 'id', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                    return  $this->price_dollarsAdmin( $this->getPriceComputerAssembly($d,1));
                }
            ),




            array( 'db' => 'date', 'dt' =>  3 ,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);

                }
            ),

            array( 'db' => 'note', 'dt' =>  4 ,
                'formatter' => function( $d, $row ) {
                    return   $d ;
                }
            ),




            array('db' =>   'note2', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    if ($this->permit('write_note', $this->folder)) {

                        if ($this->ch($row[7]) != 'checked') {
                            return "
             
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-12' style='padding: 0'>		
				  	       <textarea   rows='5'  onkeyup=saveNote('" . $row[7] . "')  id='add_note_{$row[7]}'   type='text' class='form-control withBill'  required>{$d}</textarea>
                   </div>
				 
                  </div>
                    ";
                        }else
                        {
                            return "
             
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-12' style='padding: 0'>		
				  	       <textarea   rows='5' readonly onkeyup=saveNote('" . $row[7] . "')  id='add_note_{$row[7]}'   type='text' class='form-control withBill'  required>{$d}</textarea>
                   </div>
				 
                  </div>
                    ";
                        }

                    } else {
                        return 'لا توجد صلاحية';
                    }

                }
            ),

            array( 'db' => 'userId', 'dt' =>  6 ,
                'formatter' => function( $d, $row ) {
                    return   $this->UserInfo($d) ;
                }
            ),




            array(  'db' => 'id', 'dt'=> 7 )/*18*/

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
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 1 AND   `active` = 3 AND model LIKE '%{$model}%' AND ({$fieldDetails}) ")
            );
        }
        else if ($model)
        {
            if ($model=='double_computer_assembly')
            {
                echo json_encode(
                // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 1 AND `active` = 3  AND model LIKE '%,%' ")
                );

            }else
            {
                echo json_encode(
                // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 1 AND  `active` = 3  AND model LIKE '%{$model}%' ")
                );

            }


        }else
        {
            echo json_encode(
            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "  `delete` = 1 AND  `active` = 3   ")
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


            $stmt_up =$this->db->prepare("UPDATE  `computer_assembly` SET  note2=?   WHERE  id =? AND `active` <> 1  ");
            $stmt_up->execute(array($note,$id));
            if ($stmt_up->rowCount() > 0)
            {
                echo '1';
                $this->Add_to_sync_schedule($id,"computer_assembly","add_computer_assembly");

            }else
            {
                echo '0';
            }


        }


    }





    function sales_computer_assembly($id)
    {

        $stmt = $this->db->prepare("SELECT COUNT(*) as num FROM (SELECT COUNT(id) FROM `cart_shop_active` WHERE  number_bill <> 0 AND `accountant` = 1 AND `prepared`= 2  AND `cancel`=0 AND id_computer_assembly=? GROUP BY `id_computer_assembly`,computer_assembly) t");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return  $result['num'];

    }







    public function visible_computer_assembly($v_,$id_)
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



                if (!$this->check_one_itemcomputer_assembly($id))
                {
                    $q = '01';
                }



                if ($q == 'true') {
                    $data = $this->db->update($this->table, array( 'active' => $v,'note' => '','userId'=>$this->userid), "`id`={$id}");

                    $this->Add_to_sync_schedule($id,"computer_assembly","add_computer_assembly");

                    echo $q;
                } else if ($q=='01'){
                    echo $q;
                } else
                {
                    echo $q;
                }
            }else
            {
                $data = $this->db->update($this->table, array( 'active' => $v,'userId'=>$this->userid), "`id`={$id}");
                $this->Add_to_sync_schedule($id,"computer_assembly","add_computer_assembly");


            }
        }
    }



    function delete_computer_assembly($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->update($this->table,array('delete'=>1,'active'=>3,'userId'=>$this->userid,'date'=>time()), "`id`={$id}");
            echo 'true';
            $this->Add_to_sync_schedule($id,"computer_assembly","add_computer_assembly");

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



        require ($this->render($this->folder,'html','add','php'));
        $this->adminFooterController();

    }


    function add_form()
    {
        $this->checkPermit('add',$this->folder);

        $error=null;
        $data['title']='';
        $data['content']='';
        $data['description']='';
        $data['files']='';
        $data['list_file']='';


        try{
            $form =new Form();
            $form  ->post('title')
                ->val('is_empty','مطلوب')
                ->val('strip_tags',TAG);

            $form  ->post('content')
                ->val('strip_tags',TAG);



            $form  ->post('description')
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


            $form  ->post('color')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('code_color')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('size')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('price')
                ->val('is_array')
                ->val('strip_tags');


//            sub
            $form  ->post('code_sub')
                ->val('is_array')
                ->val('strip_tags');


            $form  ->post('names_sub')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('id_item_sub')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('ids_cat_sub')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('imgitem_sub')
                ->val('is_array')
                ->val('strip_tags');


            $form  ->post('color_sub')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('code_color_sub')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('size_sub')
                ->val('is_array')
                ->val('strip_tags');


            $form  ->post('price_sub')
                ->val('is_array')
                ->val('strip_tags');




            $form ->submit();
            $data =$form -> fetch();
            $file=new Files();

            $data['lang']=$this->langControl;
            $data['userId']=$this->userid;
            $data['date']=time();

            $code=json_decode($data['code'],true);
            $names=json_decode($data['names'],true);
            $id_item=json_decode($data['id_item'],true);
            $ids_cat=json_decode($data['ids_cat'],true);
            $model=json_decode($data['model'],true);
            $color=json_decode($data['color'],true);
            $code_color=json_decode($data['code_color'],true);
            $size=json_decode($data['size'],true);
            $imgitem=json_decode($data['imgitem'],true);
            $price=json_decode($data['price'],true);


            $code_sub=json_decode($data['code_sub'],true);
            $names_sub=json_decode($data['names_sub'],true);
            $id_item_sub=json_decode($data['id_item_sub'],true);
            $ids_cat_sub=json_decode($data['ids_cat_sub'],true);
            $model_sub=json_decode($data['model_sub'],true);
            $color_sub=json_decode($data['color_sub'],true);
            $code_color_sub=json_decode($data['code_color_sub'],true);
            $size_sub=json_decode($data['size_sub'],true);
            $imgitem_sub=json_decode($data['imgitem_sub'],true);
            $price_sub=json_decode($data['price_sub'],true);





            $main_image=json_decode($data['main_img'],true);

            if (empty($main_image))
            {
                $error = 1; // يجب رفع صورة رئيسية للعرض
            }




                $data['active']=0;
                $data['note']=  '' ;


            $data['model']=implode(',',$model);


            if (empty($error))
            {

                $this->db->insert($this->table,array_diff_key($data,['imgitem'=>"delete",'color'=>"delete",'code_color'=>"delete",'size'=>"delete",'list_file'=>"delete",'main_img'=>"delete",'code'=>"delete",'names'=>"delete",'id_item'=>"delete",'latiniin_or_code'=>"delete",'cover_type_computer_assembly'=>"delete",
                    'code_sub'=>'delete',
                    'names_sub'=>'delete',
                    'id_item_sub'=>'delete',
                    'ids_cat_sub'=>'delete',
                    'model_sub'=>'delete',
                    'color_sub'=>'delete',
                    'code_color_sub'=>'delete',
                    'size_sub'=>'delete',
                    'imgitem_sub'=>'delete',
                    'price'=>'delete',
                    'price_sub'=>'delete',
                    ]));
                $listid=$this->db->lastInsertId();
                $this->Add_to_sync_schedule($listid,"computer_assembly","add_computer_assembly");


                if ($listid){

                    if(!empty($main_image)) {
                        $id_file= $file->insert_file($this->folder, $listid, $main_image);
                        $this->db->update($this->table, array('img' => $main_image[0]['rand_name'],'imgid' => $id_file), "id={$listid}");
                        $this->Add_to_sync_schedule($listid,"computer_assembly","add_computer_assembly");

                    }

                    if(!empty($data['list_file'])) {
                        $file->insert_file($this->folder, $listid, json_decode($data['list_file'], True));
                    }

                    foreach ($code as $key => $cdo)
                    {


                          $cdo=trim($cdo);


                            $stmt = $this->db->prepare("INSERT INTO `{$this->computer_assembly_item}` (`model`,`title`,`code`,`color`,`code_color`,`size`,`userId`,`date`,`id_item`,`img`,`id_computer_assembly`,`ids_cat`,`price`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                            $stmt->execute(array($model[$key],$names[$key],$cdo,$color[$key],$code_color[$key],$size[$key],$this->userid,time(),$id_item[$key],$imgitem[$key],$listid,$ids_cat[$key],$price[$key]));

                            $idLast= $this->db->lastInsertId();


                            if (is_array($code_sub[$key]))
                            {

                                foreach ($code_sub[$key] as $index => $sub_item) {

                                     $stmt_sub = $this->db->prepare("INSERT INTO `computer_assembly_item` (`sub_item`,  `model`,`title`,`code`,`color`,`code_color`,`size`,`userId`,`date`,`id_item`,`img`,`id_computer_assembly`,`ids_cat`,`price`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                                    if (empty($code_color_sub[$key][$index]))
                                    {
                                        $code_color_sub[$key][$index]=' ';
                                    }
                                    if (empty($size_sub[$key][$index]))
                                    {
                                        $size_sub[$key][$index]=' ';
                                    }
                                    $stmt_sub->execute(array($idLast,$model[$key],$names_sub[$key][$index],$sub_item,$color_sub[$key][$index],$code_color_sub[$key][$index],$size_sub[$key][$index],$this->userid,time(),$id_item_sub[$key][$index],$imgitem_sub[$key][$index],$listid,$ids_cat_sub[$key][$index],$price_sub[$key][$index]));
                                }

                            }



                            $this->Add_to_sync_schedule($idLast,"computer_assembly_item","add_computer_assembly_item");


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
        $activecomputer_assembly=$data['active'];
        $this->adminHeaderController($data['title'],$id);





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



        $stmtItem=$this->db->prepare("SELECT * FROM `computer_assembly_item` WHERE id_computer_assembly=? AND sub_item=0");
        $stmtItem->execute(array($id));
        $item=array();
        $lastIdIten=0;
        while ($rowItem = $stmtItem->fetch(PDO::FETCH_ASSOC))
        {

            $rowItem['sub']=array();
            $rowItem['listIdSub']=0;

            $stmtItemSub=$this->db->prepare("SELECT * FROM `computer_assembly_item` WHERE id_computer_assembly=? AND sub_item=?");
            $stmtItemSub->execute(array( $id, $rowItem['id']));
            while ($rowItemSub = $stmtItemSub->fetch(PDO::FETCH_ASSOC))
            {
                $rowItem['listIdSub']=$rowItemSub['id']+1;
                $rowItem['sub'][]=$rowItemSub;
            }

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


            $form  ->post('content')
                ->val('strip_tags',TAG);

            $form  ->post('description')
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

            $form  ->post('price')
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






//            sub
            $form  ->post('code_sub')
                ->val('is_array')
                ->val('strip_tags');


            $form  ->post('names_sub')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('id_item_sub')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('ids_cat_sub')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('imgitem_sub')
                ->val('is_array')
                ->val('strip_tags');


            $form  ->post('color_sub')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('code_color_sub')
                ->val('is_array')
                ->val('strip_tags');

            $form  ->post('size_sub')
                ->val('is_array')
                ->val('strip_tags');
       $form  ->post('price_sub')
                ->val('is_array')
                ->val('strip_tags');





            $form ->submit();
            $data =$form -> fetch();

            $file=new Files();

            $data['userId']=$this->userid;


            $code=json_decode($data['code'],true);
            $names=json_decode($data['names'],true);
            $id_item=json_decode($data['id_item'],true);
            $ids_cat=json_decode($data['ids_cat'],true);
            $model=json_decode($data['model'],true);
            $imgitem=json_decode($data['imgitem'],true);
            $color=json_decode($data['color'],true);
            $code_color=json_decode($data['code_color'],true);
            $size=json_decode($data['size'],true);
            $price=json_decode($data['price'],true);



            $code_sub=json_decode($data['code_sub'],true);
            $names_sub=json_decode($data['names_sub'],true);
            $id_item_sub=json_decode($data['id_item_sub'],true);
            $ids_cat_sub=json_decode($data['ids_cat_sub'],true);
            $model_sub=json_decode($data['model_sub'],true);
            $color_sub=json_decode($data['color_sub'],true);
            $code_color_sub=json_decode($data['code_color_sub'],true);
            $size_sub=json_decode($data['size_sub'],true);
            $imgitem_sub=json_decode($data['imgitem_sub'],true);
            $price_sub=json_decode($data['price_sub'],true);




            $main_image = json_decode($data['main_img'], true);
            if (empty($oldImg) ) {

                    if (empty($main_image)) {
                     echo   $error = 1; // يجب رفع صورة رئيسية للعرض
                    }

            }



            $data['ids_cat']=implode(',',$ids_cat);
            $data['model']=implode(',',$model);


            if(!empty($data['main_img'])) {
                $file->delete_file_and_row($id_old_img);
                $id_file= $file->insert_file($this->folder, $id , $main_image);
                $data['img']=$main_image[0]['rand_name'];
                $data['imgid']=$id_file;
            }

            if(!empty($data['list_file'])) {
                $file->insert_file($this->folder, $id, json_decode($data['list_file'], True));
            }


            $this->db->update($this->table, array_diff_key($data,['imgitem'=>"delete",'color'=>"delete",'code_color'=>"delete",'size'=>"delete",'list_file'=>"delete",'main_img'=>"delete",'code'=>"delete",'names'=>"delete",'id_item'=>"delete",'latiniin_or_code'=>"delete",'cover_type_computer_assembly'=>"delete",
                'code_sub'=>'delete',
                'names_sub'=>'delete',
                'id_item_sub'=>'delete',
                'ids_cat_sub'=>'delete',
                'model_sub'=>'delete',
                'color_sub'=>'delete',
                'code_color_sub'=>'delete',
                'size_sub'=>'delete',
                'imgitem_sub'=>'delete',
                'price'=>'delete',
                'price_sub'=>'delete',
                ]), "id={$id}");



            $this->Add_to_sync_schedule($id,"computer_assembly","add_computer_assembly");

            foreach ($code as $key => $cdo)
            {

                echo $key .'<br>';
                $table= $model[$key];

                    $stmt = $this->db->prepare("INSERT INTO `computer_assembly_item` (`id`,`model`,`title`,`code`,`img`,`color`,`code_color`,`size`,`userId`,`date`,`id_item`,`id_computer_assembly`,`ids_cat`,`price`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?)   ON DUPLICATE KEY UPDATE                                                                                                                                                                      
                                                                               `id`=VALUES(id) ,`model`=VALUES(model) ,`title`=VALUES(title)  ,`code`=VALUES(code) ,`img`=VALUES(img)   
                                                                               , `color`=VALUES(color) ,`code_color`=VALUES(code_color)  ,`size`=VALUES(size)
                                                                               ,`userId`=VALUES(userId)  ,`date`=VALUES(date)  ,`id_item`=VALUES(id_item) ,`id_computer_assembly`=VALUES(id_computer_assembly) ,`ids_cat`=VALUES(ids_cat) ,`price`=VALUES(price)  ");
                    $stmt->execute(array($key,$model[$key],$names[$key],$cdo,$imgitem[$key],$color[$key],$code_color[$key],$size[$key],$this->userid,time(),$id_item[$key],$id,$ids_cat[$key],$price[$key]));
                    $listiditem=$this->db->lastInsertId();



                if (is_array($code_sub[$key]))
                {

                    foreach ($code_sub[$key] as $index => $sub_item) {



                        $stmt_sub = $this->db->prepare("INSERT INTO `computer_assembly_item` (id,`sub_item`,  `model`,`title`,`code`,`color`,`code_color`,`size`,`userId`,`date`,`id_item`,`img`,`id_computer_assembly`,`ids_cat`,`price`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
                                                                                ON DUPLICATE KEY UPDATE                                                                                                                                                                      
                                                                               `id`=VALUES(id) ,`model`=VALUES(model) ,`title`=VALUES(title)  ,`code`=VALUES(code) ,`img`=VALUES(img)   
                                                                               , `color`=VALUES(color) ,`code_color`=VALUES(code_color)  ,`size`=VALUES(size)
                                                                               ,`userId`=VALUES(userId)  ,`date`=VALUES(date)  ,`id_item`=VALUES(id_item) ,`id_computer_assembly`=VALUES(id_computer_assembly) ,`ids_cat`=VALUES(ids_cat),`price`=VALUES(price)


                     ");
                        if (empty($code_color_sub[$key][$index]))
                        {
                            $code_color_sub[$key][$index]=' ';
                        }
                        if (empty($size_sub[$key][$index]))
                        {
                            $size_sub[$key][$index]=' ';
                        }
                        $stmt_sub->execute(array($index,$listiditem,$model[$key],$names_sub[$key][$index],$sub_item,$color_sub[$key][$index],$code_color_sub[$key][$index],$size_sub[$key][$index],$this->userid,time(),$id_item_sub[$key][$index],$imgitem_sub[$key][$index],$id,$ids_cat_sub[$key][$index],$price_sub[$key][$index]));
                    }

                }






                $this->Add_to_sync_schedule($listiditem,"computer_assembly_item","add_computer_assembly_item");


            }


           $this->lightRedirect(url . '/' . $this->folder . '/list_computer_assembly', 0);


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
            $this->Add_to_sync_schedule($id,"computer_assembly","add_computer_assembly");
        }
    }





    function delete_image($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->update($this->table,array('img'=>0),"`id`={$id}");
            echo 'true';
            $this->Add_to_sync_schedule($id,"computer_assembly","add_computer_assembly");
        }
    }

    public function getAllcomputer_assembly()
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE   `active`=1 ORDER BY `id` DESC LIMIT 5");
        $stmt->execute();
        return $stmt->fetchAll();
    }




    public  function details($id)
    {

        if (!is_numeric($id)) {$error=new Errors(); $error->index();}




        $stmt=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE  `id` = ? AND `active`=1");
        $stmt->execute(array($id));
        $result=$stmt->fetch (PDO::FETCH_ASSOC) ;

        if (empty($result))
        {
            $this->lightRedirect(url);
        }

        $price=0;
         $priceC=0;
        if ($this->loginUser())
        {
            $priceC = number_format($this->getPriceComputerAssembly($id)) ;
            $price=$priceC . '  د.ع ';
        }else
        {
            $priceC=$this->price_dollars($this->getPriceComputerAssembly($id));
            $price=$priceC . '  د.ع ';

        }




        $stmtItem=$this->db->prepare("SELECT * FROM `computer_assembly_item` WHERE id_computer_assembly=?  AND sub_item=0");
        $stmtItem->execute(array($id));
        $item=array();

        while ($rowItem = $stmtItem->fetch(PDO::FETCH_ASSOC))
        {
            $rowItem['sub']=array();
            $stmtItemSub=$this->db->prepare("SELECT * FROM `computer_assembly_item` WHERE id_computer_assembly=?  AND sub_item=?");
            $stmtItemSub->execute(array( $id, $rowItem['id']));


            if ($rowItem['model'] == 'mobile') {
                $excel = 'excel';
            } else {
                $excel = 'excel_' . $rowItem['model'];
            }

            while ($rowItemSub = $stmtItemSub->fetch(PDO::FETCH_ASSOC))
            {


                $stmtItemQty = $this->db->prepare("SELECT {$excel}.quantity FROM `{$excel}`   WHERE  code=?  AND {$excel}.quantity > 0 ");
                $stmtItemQty->execute(array($rowItemSub['code'] ));
                if ($stmtItemQty->rowCount() > 0) {

                    if ($this->loginUser()) {
                        $rowItemSub['price'] = $this->price_dollarsAdmin($rowItemSub['price']) . ' د.ع ';
                    } else {

                        $rowItemSub['price'] = $this->price_dollars($rowItemSub['price']) . ' د.ع ';
                    }

                    $rowItemSub['img'] = $this->save_file . $rowItemSub['img'];
                    $rowItem['sub'][] = $rowItemSub;
                }
            }


            if ($this->loginUser())
            {
                $rowItem['price'] = $this->price_dollarsAdmin($rowItem['price']) .' د.ع ' ;
            }else
            {

                $rowItem['price'] = $this->price_dollars($rowItem['price']) .' د.ع ' ;
            }



            $rowItem['disabled']='';
            $stmtItemQty = $this->db->prepare("SELECT {$excel}.quantity FROM `{$excel}`   WHERE  code=?  AND {$excel}.quantity <= 0 ");
            $stmtItemQty->execute(array($rowItem['code'] ));
            if ($stmtItemQty->rowCount() > 0)
            {
                $rowItem['disabled']='disabled';
            }


            $rowItem['img']=$this->save_file.$rowItem['img'];

            $item[]=  $rowItem;
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




        $stmtcomputer_assembly=$this->db->prepare("SELECT *FROM  computer_assembly WHERE  id <> ? AND     `active`=1   order by RAND() LIMIT 6 ");
        $stmtcomputer_assembly->execute(array($id));
        $random=array();
        while ($row = $stmtcomputer_assembly->fetch(PDO::FETCH_ASSOC))
        {


            if ($this->loginUser())
            {
                $row['priceC']= number_format($this->getPriceComputerAssembly($row['id']));
                $row['range']=$row['priceC'] . '  د.ع ';

            }else
            {
                $row['priceC']=$this->price_dollars($this->getPriceComputerAssembly($row['id']));
                $row['range']=$row['priceC'] . '  د.ع ';

            }


            $row['image']=$this->show_file_site.$row['img'];
            $random[]=$row;
        }





        require ($this->render($this->folder,'html','details','php'));
    }


    function xxx()
    {

        $stmtItemDetails=$this->db->prepare("SELECT computer_assembly_item.id,computer_assembly_item.color,computer_assembly_item.code_color,computer_assembly_item.size  FROM `computer_assembly_item` INNER  JOIN {$excel} ON  {$excel}.code=computer_assembly_item.code WHERE  computer_assembly_item.`id_computer_assembly` = ? AND computer_assembly_item.id_item=? AND computer_assembly_item.`model`=?  AND {$excel}.quantity > 0 ");
        $stmtItemDetails->execute(array($id,$row['id_item'],$row['model']));
        while($details=$stmtItemDetails->fetch (PDO::FETCH_ASSOC))
        {
            $row['details'.$row['id']][]=$details;
        }
    }



    function remove_file($id,$id_file,$type='img')
    {
        if ($this->handleLogin() ) {
            $file = new Files();
            if ($type == 'img') {
                $this->db->update($this->table, array('img' => '','imgid' => 0), "`id`={$id} AND `imgid` = {$id_file}  ");

                $this->Add_to_sync_schedule($id,"computer_assembly","add_computer_assembly");
                $file->delete_file_and_row($id_file);
                echo 'true';
            } else if ($type == 'video') {
                $this->db->update($this->table, array('id_video' => 0), "`id`={$id} AND `imgid` = {$id_file} ");

                $this->Add_to_sync_schedule($id,"computer_assembly","add_computer_assembly");
                $file->delete_file_and_row($id_file);
                echo 'true';
            } else {
                $file->delete_file_and_row($id_file);
                echo 'true';
            }
        }

    }




    function cart_order($idcomputer_assembly)
    {




        if (is_numeric($idcomputer_assembly)) {

            if (isset( $_POST['item']))
            {
                $item_off=$_POST['item'];
            }else

            {
                die('يرجى اختيار مواد المجموعة');
            }



            if (empty($item_off))
            {
                die('يرجى اختيار مواد المجموعة');
            }

             foreach ($item_off as $key => $itm)
            {
                if (is_numeric($itm)){
                    $ids_item_off[$key]=$itm;

                }else
                {
                    die('حدثت مشكلة');
                }

            }



            $ids_item_off=implode(',',$ids_item_off);

            if ($this->check_one_itemcomputer_assembly($idcomputer_assembly)) {


                $stmtcomputer_assemblyCh = $this->db->prepare("SELECT *FROM computer_assembly_item WHERE id_computer_assembly=? AND   id IN({$ids_item_off})   ");
                $stmtcomputer_assemblyCh->execute(array($idcomputer_assembly));

                while ($rowItemCh = $stmtcomputer_assemblyCh->fetch(PDO::FETCH_ASSOC)) {


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
                    }
                }


                $date = time();

                $stmtcomputer_assembly = $this->db->prepare("SELECT *FROM computer_assembly_item WHERE id_computer_assembly=? AND    id IN({$ids_item_off})   ");
                $stmtcomputer_assembly->execute(array($idcomputer_assembly));
                while ($rowItem = $stmtcomputer_assembly->fetch(PDO::FETCH_ASSOC)) {


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

                            $data['id_computer_assembly'] = $idcomputer_assembly;
                            $data['computer_assembly'] = 'computer_assembly';
                            $data['date_computer_assembly'] =$date;


                            $data['price_dollars'] =$rowItem['price'] ;

                            $dollar = new Dollar_price();
                            $data['dollar_exchange'] = $dollar->dollar_get();
                            $stmt_chx = $this->db->prepare("SELECT   * FROM `cart_shop_active` WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ? AND `id_computer_assembly`=?  AND `computer_assembly` =? ");
                            $stmt_chx->execute(array($rowItem['id_item'], $rowItem['code'], $rowItem['model'], $data['id_member_r'], $idcomputer_assembly, 'computer_assembly'));

                            $this->db->insert($this->cart_shop_active, $data);



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






    function count_c()
    {
        if ($this->isDirect())
        {
            $id=$this->isUuid();
        }else{
            $id= $_SESSION['id_member_r'];
        }

        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`, `number`,`buy`,`date` FROM `{$this->cart_shop_active}` WHERE `id_member_r` =?  AND `buy` = 0 GROUP BY `computer_assembly`,`id_computer_assembly`,`date`  ORDER BY `id`  DESC  ");
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
        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`, `number`,`buy`,`date` FROM `{$this->cart_shop_active}` WHERE `id_member_r` =?  AND `buy` = 0 GROUP BY `computer_assembly`,`id_computer_assembly`  ORDER BY `id`  DESC  ");
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

            $stmt=$this->db->prepare("DELETE FROM computer_assembly_item WHERE  id =? AND  code =? AND model =?  ");
            $stmt->execute(array($id,$code,$model));
            if ($stmt->rowCount() > 0)
            {
                echo 'true';

                $this->Add_to_sync_schedule($id,"computer_assembly_item","delete_computer_assembly_item");

            }

        }

    }


    function getPriceItemSelect($id)
    {

        $ids=$_GET['ids'];

        foreach ($ids as $key => $itm)
        {
            if (is_numeric($itm)){
                $ids[$key]=$itm;

            }else
            {
                die('error');
            }

        }


        $ids=implode(',',$ids);

        $price=0;

        $stmtItem=$this->db->prepare("SELECT *FROM `computer_assembly_item` WHERE  `id_computer_assembly` = ?  AND  id IN({$ids})   ");
        $stmtItem->execute(array($id));
        $price=0;
        while($row=$stmtItem->fetch (PDO::FETCH_ASSOC)) {


            if ($this->loginUser())
            {
                $price=$price+str_replace($this->comma,'',$this->price_dollarsAdmin($row['price']));
            }else
            {
                $price=$price+$row['price'];
            }

        }

        $data=array();
        if ($this->loginUser())
        {
            $data=array('price'=>number_format($price).' د.ع ','priceC'=>$price);
        }else
        {
            $data=array('price'=>$this->price_dollars($price) .' د.ع ','priceC'=>$this->price_dollars($price) );

        }

        if ($data)
        {
            echo json_encode($data);
        }



    }


    function check_All_itemcomputer_assembly()
    {


        $stmtItemChAll = $this->db->prepare("SELECT * FROM `computer_assembly`    WHERE active=1 OR  active= 0");
        $stmtItemChAll->execute();
        while ($rowChAll = $stmtItemChAll->fetch(PDO::FETCH_ASSOC)) {

            $stmtItemCh = $this->db->prepare("SELECT * FROM `computer_assembly_item`    WHERE id_computer_assembly=?  AND sub_item=0 GROUP BY id_item,model");
            $stmtItemCh->execute(array($rowChAll['id']));
            while ($rowCh = $stmtItemCh->fetch(PDO::FETCH_ASSOC)) {

                $stmtItem = $this->db->prepare("SELECT * FROM `computer_assembly_item`    WHERE id=? AND id_computer_assembly=?  AND sub_item=0");
                $stmtItem->execute(array($rowCh['id'], $rowChAll['id']));
                $qty = 0;
                while ($rowItem = $stmtItem->fetch(PDO::FETCH_ASSOC)) {
                    if ($rowItem['model'] == 'mobile') {
                        $excel = 'excel';
                    } else {
                        $excel = 'excel_' . $rowItem['model'];
                    }
                    $stmtexcel = $this->db->prepare("SELECT  {$excel}.quantity  FROM {$excel} WHERE `code`=?    AND {$excel}.quantity > 0  LIMIT 1");
                    $stmtexcel->execute(array(trim($rowItem['code'])));
                    if ($stmtexcel->rowCount() > 0) {
                        $resultQty = $stmtexcel->fetch(PDO::FETCH_ASSOC);
                        $qty = $qty + $resultQty['quantity'];
                    }


                    $stmtItemSub = $this->db->prepare("SELECT {$excel}.quantity  FROM `computer_assembly_item` INNER  JOIN {$excel} ON  {$excel}.code=computer_assembly_item.code  WHERE computer_assembly_item.id_computer_assembly=?  AND computer_assembly_item.sub_item=?   AND {$excel}.quantity > 0");
                    $stmtItemSub->execute(array($rowChAll['id'], $rowItem['id']));
                    while ($rowItemSub = $stmtItemSub->fetch(PDO::FETCH_ASSOC)) {
                        $qty = $qty + $rowItemSub['quantity'];
                    }

                }


                if ($qty == 0) {
                    $stmtUPd = $this->db->prepare("UPDATE    computer_assembly SET active=? , note =?    WHERE id = ?  ");
                    $stmtUPd->execute(array(2, 'نفذت بعض مواد التجميعة', $rowChAll['id']));
                }

            }

        }

    }


}