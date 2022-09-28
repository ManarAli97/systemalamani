<?php

class compare_warehouses extends Controller
{



    function __construct()
    {
        parent::__construct();
        $this->table = 'material';
        $this->warehouses = 'warehouses';
        $this->warehouses_category = 'warehouses_category';
        $this->setting=new Setting();

    }

    public function createTB()
    {


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `id` int(10) NOT NULL AUTO_INCREMENT ,
            `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `name`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `color`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `category` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->warehouses}` (
            `id` int(10) NOT NULL AUTO_INCREMENT ,
            `id_mat` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `quantity`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `category` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `number`  int(11)   NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->warehouses_category}` (
            `id` int(10) NOT NULL AUTO_INCREMENT ,
            `category` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `type`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        return $this->db->cht(array($this->table,$this->warehouses,$this->warehouses_category));

    }


    public function index($cat,$type)
    {

        $this->checkPermit('list',$this->folder);
        $this->adminHeaderController($this->langControl('compare_warehouses'));


        $number = array();
        $stmt = $this->db->prepare("SELECT *FROM warehouses GROUP BY `number`");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $number[]=$row['number'];
        }


        foreach ($number as $x)
        {
            $this->num=$x;

        }



        $last_upload=null;
        $stmtcw=$this->db->prepare("SELECT *FROM `warehouses_category` ORDER BY id DESC LIMIT 1");
        $stmtcw->execute();
        if ($stmtcw->rowCount()>0)
        {
            $rslt=$stmtcw->fetch(PDO::FETCH_ASSOC);
            $last_upload=date('d-m-Y h:i:s A',$rslt['date']);
        }




        require ($this->render($this->folder,'html','list','php'));
        $this->adminFooterController();

    }



    public function processing($cat,$type)
    {
        $this->checkPermit('list', $this->folder);
        $table = $this->table;
        $primaryKey = $this->table.'.id';
        if ($cat=='mobile')
        {
            $excel = 'excel';
            $code = 'code';
            $color= 'color';
        }else{
            $excel = 'excel_'.$cat;
            $code = 'code_'.$cat;
            $color= 'color_'.$cat;
        }

        $number = array();
        $stmt = $this->db->prepare("SELECT *FROM warehouses GROUP BY `number`");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $number[]=$row['number'];
        }

        $columnsx = array(
            array(  'db' => $this->table.'.id', 'dt'=>0),

            array('db' => $color.'.img', 'dt' =>1,
                'formatter' => function ($d, $row) {
                    if ($d)
                    {
                        return "<img width=150 src='".$this->save_file.$d."' >";
                    }else{
                        return 'لاتوجد صورة';
                    }

                }

            ),
            array( 'db' => $this->table.'.code', 'dt' => 2 ),
            array( 'db' => $this->table.'.name', 'dt' => 3),
            array( 'db' => $this->table.'.color', 'dt' => 4 ),
            array(  'db' => $excel.'.quantity', 'dt'=>5),
            array( 'db' => $this->table.'.code', 'dt' => 6,

                'formatter' => function( $d, $row) {
                    return $this->booked_up($d,$row[4]);
                }

            ),
            array( 'db' => $this->table.'.code', 'dt' => 7,

                'formatter' => function( $d, $row) {
                    return $this->sale($d,$row[4]);
                }

            ),


            array('db' => $this->table.'.note', 'dt' => 8,
                'formatter' => function ($d, $row) {
                    if ($this->permit('add_note', $this->folder)) {

                        return "
                <div id='note_{$row[0]}'>{$d}</div>
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-12' style='padding: 0'>		
				  	       <textarea rows='5'  onkeyup=saveNote('".$row[0]."')  id='add_note_{$row[0]}'   type='text' class='form-control withBill'  required></textarea>
                   </div>
				 
                  </div>
                    " ;
                    }else
                    {
                        return 'لا توجد صلاحية';
                    }

                }
            ),

            array('db' => $cat.'.bast_it', 'dt' => 9,
                'formatter' => function ($d, $row) {
                if ($d==1)
                {
                    return "ننصح به";

                }else{
                    return "";

                }

                }


            ),

            /*    مستودعات  */
            array(  'db' => $this->table.'.id', 'dt'=>10,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,1);
                }),


            array(  'db' => $this->table.'.id', 'dt'=>11,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,2);
                }),


            array(  'db' => $this->table.'.id', 'dt'=>12,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,3);
                }),


            array(  'db' => $this->table.'.id', 'dt'=>13,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,4);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>14,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,5);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>15,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,6);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>16,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,7);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>17,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,8);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>18,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,9);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>19,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,10);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>20,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,11);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>21,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,12);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>22,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,13);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>23,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,14);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>24,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,15);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>25,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,16);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>26,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,17);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>27,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,18);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>28,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,19);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>29,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,20);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>30,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,21);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>31,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,22);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>32,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,23);
                }),




            array(  'db' => $this->table.'.id', 'dt'=>33,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,24);
                }),



            array(  'db' => $this->table.'.id', 'dt'=>34,
                'formatter' => function( $d, $row) {
                    return $this->datx($d,25);
                })

        );


// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );



        if ($cat=='accessories')
        {
            $join = "LEFT JOIN {$color} ON {$color}.code={$this->table}.code LEFT JOIN {$cat} ON {$cat}.id = {$color}.id_cat LEFT JOIN {$excel} ON {$excel}.code =  material.code";

        }else
        {
            $join = "LEFT JOIN {$code} ON {$code}.code={$this->table}.code LEFT JOIN {$color} ON {$color}.id={$code}.id_color  LEFT JOIN {$cat} ON {$cat}.id = {$color}.id_item  LEFT JOIN {$excel} ON material.code = {$excel}.code";

        }

        if ($type=1)
        {
            $whereAll = array("material.category = '{$cat}'");

        }else{
            $xcode=$excel.'.code';
            $color=$excel.'.color';
            $whereAll = array("material.category = '{$cat}'","material.code = $xcode","material.color = $color");
        }



        $result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columnsx, $join, null, $whereAll );

        $start=$_REQUEST['start']+1;
        $idx=1;
        foreach($result['data'] as &$res){
            $res[0]=(string)$start;
            $start++;
            $idx++;
        }
        echo json_encode($result);

    }

    function bast_it_item($table,$id)

    {
        $stmt=$this->db->prepare("SELECT *from   {$table}  WHERE  `id` = ?  AND `bast_it` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount()>0)
        {
            return 'ننصح به';
        }else
        {
            return '';
        }
    }

    function save_note()
    {
        if ($this->handleLogin())
        {

            $code=trim(str_replace(' ','',$_GET['code']));
            $note=strip_tags($_GET['note']);


            $stmt_up =$this->db->prepare("UPDATE  `product_savers` SET  note=?   WHERE  code =? ");
            $stmt_up->execute(array($note,$code));
            if ($stmt_up->rowCount() > 0)
            {
                echo '1';
            }


        }


    }






    function datx($id,$n)
    {

        $stmt = $this->db->prepare("SELECT quantity FROM warehouses  WHERE `id_mat`=? AND `number`=?");
        $stmt->execute(array($id,$n));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return $result['quantity'];

    }



    function sale($code,$color)
    {

        $stmt= $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop_active` WHERE `code` = ? AND `name_color`=? AND `accountant` = 1  AND `buy` = 2 AND cancel=0   ");
        $stmt->execute(array($code, $color));
        $only_delivered = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($only_delivered['num'])
        {
            return $only_delivered['num'];
        }else{

            return 0;
        }
    }
    function sale_cover($code,$model)
    {

        $stmt= $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop_active` WHERE `code` = ? AND `table`=? AND `accountant` = 1  AND `buy` = 2 AND cancel=0   ");
        $stmt->execute(array($code, $model));
        $only_delivered = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($only_delivered['num'])
        {
            return $only_delivered['num'];
        }else{

            return 0;
        }
    }


    function booked_up($code,$color)
    {

        $stmt= $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop_active` WHERE `code` = ? AND `name_color`=? AND  `buy` = 1   AND cancel=0 ");
        $stmt->execute(array($code, $color));
        $booked = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($booked['num'])
        {
            return $booked['num'];
        }else{

            return 0;
        }
    }

    function booked_up_cover($code,$model)
    {

        $stmt= $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop_active` WHERE `code` = ? AND `table`=? AND  `buy` = 1   AND cancel=0 ");
        $stmt->execute(array($code, $model));
        $booked = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($booked['num'])
        {
            return $booked['num'];
        }else{

            return 0;
        }
    }


    function  add()
    {
        $this->checkPermit('add',$this->folder);
        $this->adminHeaderController($this->langControl('add'));




        if(isset($_POST["submit"])) {


            try {
                $form = new  Form();

                $form->post('files_normal')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');

                $form->post('cat')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');

                $form->post('type')
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


                    $stmt = $this->db->prepare("DELETE FROM `material` WHERE category=? AND type=?");
                    $stmt->execute(array($data['cat'], $data['type']));

                    $stmtx = $this->db->prepare("DELETE FROM `warehouses` WHERE category=? AND type=?");
                    $stmtx->execute(array($data['cat'], $data['type']));

                    $stmtc = $this->db->prepare("DELETE FROM `warehouses_category` WHERE category=? AND type=?");
                    $stmtc->execute(array($data['cat'], $data['type']));


                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                            NULL,
                            TRUE,
                            TRUE);



                        $stmtc = $this->db->prepare("INSERT INTO `warehouses_category` (`category`,`type`,`date`) VALUES(?,?,?)");
                        $stmtc->execute(array($data['cat'], $data['type'], time()));


                        $stmt = $this->db->prepare("INSERT INTO `material` (`category`,`code`,`name`,`color`,`date`) VALUES(?,?,?,?,?)");
                        $stmt->execute(array($data['cat'],$rowData[0][0], $rowData[0][1], $rowData[0][2],  time()));
                        $lastId=$this->db->lastInsertId();

                        $m=1;
                        for ($i=3 ;$i <= count($rowData[0]) ; $i++)
                        {

                            $stmtI = $this->db->prepare("INSERT INTO `warehouses`(`category`,`id_mat`,`quantity`,`number`,date) VALUES(?,?,?,?,?)");
                            $stmtI->execute(array($data['cat'],$lastId,$rowData[0][$i], $m,time()));
                            $m++;
                        }


                    }

                    @unlink($inputFileName);
                }else
                {

                    $this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form))
                {
                    $this->lightRedirect(url.'/'.$this->folder."/index/{$data['cat']}/{$data['type']}");

                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'html','add','php'));
        $this->adminFooterController();
    }


    public function cover($brand=0,$series=0,$id_device=0,$cov=0,$typ=0,$feat=0)
    {

        $this->checkPermit('list',$this->folder);
        $this->adminHeaderController($this->langControl('compare_warehouses'));


        $stmt = $this->db->prepare("SELECT * from `category_savers`  ");
        $stmt->execute(array());
        $category=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row;
        }




        $number = array();
        $stmt = $this->db->prepare("SELECT *FROM warehouses GROUP BY `number`");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $number[]=$row['number'];
        }


        foreach ($number as $x)
        {
            $this->num=$x;

        }



        $last_upload=null;
        $stmtcw=$this->db->prepare("SELECT *FROM `warehouses_category` ORDER BY id DESC LIMIT 1");
        $stmtcw->execute();
        if ($stmtcw->rowCount()>0)
        {
            $rslt=$stmtcw->fetch(PDO::FETCH_ASSOC);
            $last_upload=date('d-m-Y h:i:s A',$rslt['date']);
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

        $cat='savers';
        $excel = 'excel_'.$cat;

        $join = "INNER JOIN product_savers ON product_savers.code={$this->table}.code  LEFT JOIN {$excel} ON  {$excel}.code = material.code ";
        $whereAll = "  material.category = '{$cat}'  and category ='savers'";
        $where_brand = "";
        if($brand != 0)
        {
            $where_brand = " AND material.brand = $brand ";
        }
        $where_series = "";
        if($series != 0)
        {
            $where_series = " AND material.series = $series ";
        }
        $where_id_device = "";
        if($id_device != 0)
        {
            $where_id_device = " AND material.id_device = $id_device ";
        }
        $where_cov = "";
        if($cov != 0)
        {
            $where_cov = " AND product_savers.cover_material = {$cov} ";
        }
        $where_typ = "";
        if($typ != 0)
        {
            $where_typ = " AND product_savers.type_cover = {$typ}  ";
        }
        $where_feat = "";
        if($feat != 0)
        {
            $where_feat = " AND product_savers.feature_cover REGEXP  {$feat} ";
        }

        // if ($brand == 0 && $series == 0 && $id_device == 0 && $cov==0 &&  $typ==0 && $feat == 0)
        // {
        //     $whereAll = array("material.category = '{$cat}' "," category ='savers' ");

        // }else

        // {
        //     if ($cov==0 &&  $typ==0 && $feat == 0)
        //     {
        //         if ($brand !=0 && $series == 0 && $id_device == 0)
        //         {
        //             $whereAll = array("material.category = '{$cat}'","material.brand = $brand "," category ='savers' ");

        //         }else if ($brand != 0 && $series !=0 && $id_device==0){
        //             $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","material.series = $series "," category ='savers' ");

        //         }else {
        //             $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","material.series = $series ","material.id_device = $id_device "," category ='savers' ");

        //         }


        //     }else
        //     {

        //         if ($brand !=0 && $series == 0 && $id_device == 0)
        //         {

        //             if ($cov!=0 &&  $typ==0 && $feat == 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand "," product_savers.cover_material = {$cov}"," category ='savers' ");

        //             }else if($cov !=0 &&  $typ !=0 && $feat == 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand "," product_savers.cover_material = {$cov}","product_savers.type_cover = {$typ} "," category ='savers' ");

        //             }else if ($cov !=0 &&  $typ !=0 && $feat  != 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","product_savers.cover_material = {$cov}  "," product_savers.type_cover = {$typ} "," product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }
        //             else if ($cov !=0 &&  $typ ==0 && $feat  != 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","product_savers.cover_material = {$cov}  ","   product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }
        //             else  if ($cov ==0 &&  $typ !=0 && $feat == 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand "," product_savers.type_cover = {$typ}  "," category ='savers' ");

        //             }
        //             else if ($cov ==0 &&  $typ !=0 && $feat  != 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand "," product_savers.type_cover = {$typ} "," product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }else
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand "," product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }




        //         }else if ($brand != 0 && $series !=0 && $id_device==0){


        //             if ($cov!=0 &&  $typ==0 && $feat == 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand "," material.series = $series "," product_savers.cover_material = {$cov}"," category ='savers' ");

        //             }else if($cov !=0 &&  $typ !=0 && $feat == 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","material.series = $series "," product_savers.cover_material = {$cov}","product_savers.type_cover = {$typ} "," category ='savers' ");

        //             }else if ($cov !=0 &&  $typ !=0 && $feat  != 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","material.series = $series ","product_savers.cover_material = {$cov}  "," product_savers.type_cover = {$typ} "," product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }
        //             else if ($cov !=0 &&  $typ ==0 && $feat  != 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","material.series = $series ","product_savers.cover_material = {$cov}  ","   product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }
        //             else  if ($cov ==0 &&  $typ !=0 && $feat == 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","material.series = $series "," product_savers.type_cover = {$typ}  "," category ='savers' ");

        //             }
        //             else if ($cov ==0 &&  $typ !=0 && $feat  != 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","material.series = $series "," product_savers.type_cover = {$typ} "," product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }else
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","material.series = $series "," product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }




        //         }else {


        //             if ($cov!=0 &&  $typ==0 && $feat == 0)
        //             {
        //                 $whereAll = array(" product_savers.cover_material = {$cov}"," category ='savers' ");

        //             }else if($cov !=0 &&  $typ !=0 && $feat == 0)
        //             {
        //                 $whereAll = array(" product_savers.cover_material = {$cov}","product_savers.type_cover = {$typ} "," category ='savers' ");

        //             }else if ($cov !=0 &&  $typ !=0 && $feat  != 0)
        //             {
        //                 $whereAll = array("product_savers.cover_material = {$cov}  "," product_savers.type_cover = {$typ} "," product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }
        //             else if ($cov !=0 &&  $typ ==0 && $feat  != 0)
        //             {
        //                 $whereAll = array("product_savers.cover_material = {$cov}  ","   product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }
        //             else  if ($cov ==0 &&  $typ !=0 && $feat == 0)
        //             {
        //                 $whereAll = array(" product_savers.type_cover = {$typ}  "," category ='savers' ");
        //             }
        //             else if ($cov ==0 &&  $typ !=0 && $feat  != 0)
        //             {
        //                 $whereAll = array(" product_savers.type_cover = {$typ} "," product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");
        //             }else
        //             {
        //                 $whereAll = array(" product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");
        //             }


        //         }



        //     }
        // }
        $whereAll =  $whereAll.$where_brand.$where_series.$where_id_device.$where_cov.$where_typ.$where_feat;


        $group="   GROUP BY SUBSTRING_INDEX(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                     replace(
                         replace(
                                 replace(
                                         replace(
                                                 replace(
                                                         replace(LOWER(replace(replace(material.latiniin,'ml ',''),'fm ','')), 'a', ' ')
                                                    
                                                     , 'b', ' '), 'c', ' '
                                             ), 'd', ' '
                                     ), 'e', ' ')
                     ,'f', ' ')
                     ,'g', ' ')
                     ,'h', ' ')
                     ,'i', ' ')
                     ,'j', ' ')
                     ,'k', ' ')
                     ,'l', ' ')
                     ,'m', ' ')
                     ,'n', ' ')
                     ,'o', ' ')
                     ,'p', ' ')
                     ,'q', ' ')
                     ,'r', ' ')
                     ,'s', ' ')
                     ,'t', ' ')
                     ,'u', ' ')
                     ,'v', ' ')
                     ,'w', ' ')
                     ,'x', ' ')
                     ,'y', ' ')
                     ,'z', ' ')
             , ' ', 1) 
        
        ";


            // if ( ! $whereAll ) {
            //     $whereAll='';
            // }
            // else if ( $whereAll && is_array($whereAll) ) {
            //     $whereAll= implode( ' AND ' , $whereAll );
            // }else
            // {
            //     $whereAll='';
            // }


        $total=0;
        $stmt=$this->db->prepare("SELECT COUNT(num) as total FROM (SELECT COUNT(material.id) as num FROM material {$join} WHERE {$whereAll}  {$group} ) t");
        $stmt->execute();
        if ($stmt->rowCount() >0 )
        {
            $con=$stmt->fetch(PDO::FETCH_ASSOC);
            $total=  $con['total'];
        }


        require ($this->render($this->folder,'html','list_cover','php'));
        $this->adminFooterController();

    }



    public function processing_cover($brand=0,$series=0,$id_device=0,$cov=0,$typ=0,$feat=0)
    {
        $this->checkPermit('list', $this->folder);
        $table = $this->table;
        $primaryKey = $this->table.'.id';
        $cat='savers';
        $excel = 'excel_'.$cat;


        $number = array();
        $stmt = $this->db->prepare("SELECT *FROM warehouses GROUP BY `number`");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $number[]=$row['number'];
        }

        if ($this->setting->get('type_cover',1) == 1) {

            $columnsx = array(
                array('db' => $this->table . '.id', 'dt' => 0),

                array('db' => $this->table . '.code', 'dt' => 1),
                array('db' => $this->table . '.name', 'dt' => 2),

                array('db' => 'product_savers.img', 'dt' => 3,
                    'formatter' => function ($d, $row) {
                        if ($d) {
                            return "<img width=150 src='" . $this->save_file . $d . "' >";
                        } else {
                            return 'لاتوجد صورة';
                        }

                    }

                ),

                array('db' =>   'product_savers.note', 'dt' => 4,
                    'formatter' => function ($d, $row) {
                        if ($this->permit('add_note', $this->folder)) {

                            return "
                <div class='note_{$row[1]}'>{$d}</div>
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-12' style='padding: 0'>		
				  	       <textarea rows='5'    oninput=saveNote(this,'".$row[1]."')  id='add_note_{$row[1]}'   type='text' class='form-control withBill'  required></textarea>
                   </div>
				 
                  </div>
                    ";
                        } else {
                            return 'لا توجد صلاحية';
                        }

                    }
                ),

                array('db' => $this->table . '.latiniin', 'dt' => 5),
                array('db' => 'product_savers.cover_material', 'dt' => 6,
                    'formatter' => function ($d, $row) {
                        return $this->cover_material($d, $row[1]);
                    }),

                array('db' => 'product_savers.type_cover', 'dt' => 7,
                    'formatter' => function ($d, $row) {
                        return $this->type_cover($d, $row[1]);
                    }
                ),

                array('db' => 'product_savers.feature_cover', 'dt' => 8,
                    'formatter' => function ($d, $row) {
                        return $this->feature_cover($d, $row[1]);
                    }

                ),
                array('db' => 'product_savers.feature_cover', 'dt' => 9,
                    'formatter' => function ($d, $row) {

                        return "<p>{$this->name_cover_material($row[6])}</p> <p>{$this->name_type_cover($row[7])}</p> <p>{$this->name_feature_cover($d)}</p>";
                    }

                ),


                array('db' => 'product_savers.date', 'dt' => 10,
                    'formatter' => function ($d, $row) {
                        return date('Y-m-d h:i:s a',$d);
                    }

                ),

                array('db' => $excel . '.quantity', 'dt' => 11),
                array('db' => $this->table . '.code', 'dt' => 12,

                    'formatter' => function ($d, $row) {
                        return $this->booked_up_cover($d, 'product_savers');
                    }

                ),
                array('db' => $this->table . '.code', 'dt' => 13,

                    'formatter' => function ($d, $row) {
                        return $this->sale_cover($d, 'product_savers');
                    }

                ),


                /*    مستودعات  */
                array('db' => $this->table . '.id', 'dt' => 14,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 1);
                    }),


                array('db' => $this->table . '.id', 'dt' => 15,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 2);
                    }),


                array('db' => $this->table . '.id', 'dt' => 16,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 3);
                    }),


                array('db' => $this->table . '.id', 'dt' => 17,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 4);
                    }),


                array('db' => $this->table . '.id', 'dt' => 18,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 5);
                    }),


                array('db' => $this->table . '.id', 'dt' => 19,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 6);
                    }),


                array('db' => $this->table . '.id', 'dt' => 20,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 7);
                    }),


                array('db' => $this->table . '.id', 'dt' => 21,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 8);
                    }),


                array('db' => $this->table . '.id', 'dt' => 22,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 9);
                    }),


                array('db' => $this->table . '.id', 'dt' => 23,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 10);
                    }),


                array('db' => $this->table . '.id', 'dt' => 24,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 11);
                    }),


                array('db' => $this->table . '.id', 'dt' => 25,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 12);
                    }),


                array('db' => $this->table . '.id', 'dt' => 26,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 13);
                    }),


                array('db' => $this->table . '.id', 'dt' => 27,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 14);
                    }),


                array('db' => $this->table . '.id', 'dt' => 28,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 15);
                    }),


                array('db' => $this->table . '.id', 'dt' => 29,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 16);
                    }),


                array('db' => $this->table . '.id', 'dt' => 30,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 17);
                    }),


                array('db' => $this->table . '.id', 'dt' => 31,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 18);
                    }),


                array('db' => $this->table . '.id', 'dt' => 32,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 19);
                    }),


                array('db' => $this->table . '.id', 'dt' => 33,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 20);
                    }),


                array('db' => $this->table . '.id', 'dt' => 34,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 21);
                    }),


                array('db' => $this->table . '.id', 'dt' => 35,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 22);
                    }),


                array('db' => $this->table . '.id', 'dt' => 36,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 23);
                    }),


                array('db' => $this->table . '.id', 'dt' => 37,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 24);
                    }),


                array('db' => $this->table . '.id', 'dt' => 38,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 25);
                    }),


            );
        }else{
            $columnsx = array(
                array('db' => $this->table . '.id', 'dt' => 0),

                array('db' => $this->table . '.code', 'dt' => 1),
                array('db' => $this->table . '.name', 'dt' => 2),

                array('db' => 'product_savers.img', 'dt' => 3,
                    'formatter' => function ($d, $row) {
                        if ($d) {
                            return "<img width=150 src='" . $this->save_file . $d . "' >";
                        } else {
                            return 'لاتوجد صورة';
                        }

                    }

                ),

                array('db' => 'product_savers.note', 'dt' => 4,
                    'formatter' => function ($d, $row) {
                        if ($this->permit('add_note', $this->folder)) {

                            return "
                <div id='note_{$row[1]}'>{$d}</div>
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-12' style='padding: 0'>		
				  	       <textarea rows='5'  onkeyup=saveNote('".$row[1]."')  id='add_note_{$row[1]}'   type='text' class='form-control withBill'  required></textarea>
                   </div>
				 
                  </div>
                    ";
                        } else {
                            return 'لا توجد صلاحية';
                        }

                    }
                ),

                array('db' => $this->table . '.latiniin', 'dt' => 5),

                array('db' => 'product_savers.feature_cover', 'dt' => 6,
                    'formatter' => function ($d, $row) {

                        return "<p>{$this->name_cover_material($row[36])}</p> <p>{$this->name_type_cover($row[37])}</p> <p>{$this->name_feature_cover($d)}</p>";
                    }

                ),

                array('db' => 'product_savers.date', 'dt' => 7,
                    'formatter' => function ($d, $row) {
                        return date('Y-m-d h:i:s a',$d);
                    }

                ),

                array('db' => $excel . '.quantity', 'dt' => 8),
                array('db' => $this->table . '.code', 'dt' => 9,

                    'formatter' => function ($d, $row) {
                        return $this->booked_up_cover($d, 'product_savers');
                    }

                ),
                array('db' => $this->table . '.code', 'dt' => 10,

                    'formatter' => function ($d, $row) {
                        return $this->sale_cover($d, 'product_savers');
                    }

                ),


                /*    مستودعات  */
                array('db' => $this->table . '.id', 'dt' => 11,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 1);
                    }),


                array('db' => $this->table . '.id', 'dt' => 12,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 2);
                    }),


                array('db' => $this->table . '.id', 'dt' => 13,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 3);
                    }),


                array('db' => $this->table . '.id', 'dt' => 14,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 4);
                    }),


                array('db' => $this->table . '.id', 'dt' => 15,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 5);
                    }),


                array('db' => $this->table . '.id', 'dt' => 16,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 6);
                    }),


                array('db' => $this->table . '.id', 'dt' => 17,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 7);
                    }),


                array('db' => $this->table . '.id', 'dt' => 18,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 8);
                    }),


                array('db' => $this->table . '.id', 'dt' => 19,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 9);
                    }),


                array('db' => $this->table . '.id', 'dt' => 20,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 10);
                    }),


                array('db' => $this->table . '.id', 'dt' => 21,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 11);
                    }),


                array('db' => $this->table . '.id', 'dt' => 22,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 12);
                    }),


                array('db' => $this->table . '.id', 'dt' => 23,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 13);
                    }),


                array('db' => $this->table . '.id', 'dt' => 24,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 14);
                    }),


                array('db' => $this->table . '.id', 'dt' => 25,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 15);
                    }),


                array('db' => $this->table . '.id', 'dt' => 26,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 16);
                    }),


                array('db' => $this->table . '.id', 'dt' => 27,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 17);
                    }),


                array('db' => $this->table . '.id', 'dt' => 28,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 18);
                    }),


                array('db' => $this->table . '.id', 'dt' => 29,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 19);
                    }),


                array('db' => $this->table . '.id', 'dt' => 30,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 20);
                    }),


                array('db' => $this->table . '.id', 'dt' => 31,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 21);
                    }),


                array('db' => $this->table . '.id', 'dt' => 32,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 22);
                    }),


                array('db' => $this->table . '.id', 'dt' => 33,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 23);
                    }),


                array('db' => $this->table . '.id', 'dt' => 34,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 24);
                    }),


                array('db' => $this->table . '.id', 'dt' => 35,
                    'formatter' => function ($d, $row) {
                        return $this->datx($d, 25);
                    }),
                array('db' => 'product_savers.cover_material', 'dt' => 36),

                array('db' => 'product_savers.type_cover', 'dt' => 37),



            );
        }

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $user_id= $this->userid;
        $join = "INNER JOIN product_savers ON product_savers.code={$this->table}.code  LEFT JOIN {$excel} ON  {$excel}.code = material.code ";

        $whereAll = "  material.category = '{$cat}'  and category ='savers'   ";
        $where_brand = " 1 ";
        if($brand != 0)
        {
            $where_brand = "  material.brand = $brand ";
        }
        $where_series = " 1 ";
        if($series != 0)
        {
            $where_series = "  material.series = $series ";
        }
        $where_id_device = " 1 ";
        if($id_device != 0)
        {
            $where_id_device = "  `material`.`id_device` = $id_device ";
        }
        $where_cov = " 1 ";
        if($cov != 0)
        {
            $where_cov = "  product_savers.cover_material = {$cov} ";
        }
        $where_typ = " 1 ";
        if($typ != 0)
        {
            $where_typ = "  product_savers.type_cover = {$typ}  ";
        }
        $where_feat = " 1 ";
        if($feat != 0)
        {
            $where_feat = "  product_savers.feature_cover REGEXP  {$feat} ";
        }
        if($cat == 'savers')
        {
            $where_userid = "  material.user_id = $user_id ";
        }

        // if ($brand == 0 && $series == 0 && $id_device == 0 && $cov==0 &&  $typ==0 && $feat == 0)
        // {

        //     $whereAll = array("material.category = '{$cat}' "," category ='savers' ");

        // }else
        // {
        //     if ($cov==0 &&  $typ==0 && $feat == 0)
        //     {

        //         if ($brand !=0 && $series == 0 && $id_device == 0)
        //         {
        //             $whereAll = array("material.category = '{$cat}'","material.brand = $brand "," category ='savers' ");

        //         }else if ($brand != 0 && $series !=0 && $id_device==0){
        //             $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","material.series = $series "," category ='savers' ");

        //         }else {
        //             $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","material.series = $series ","material.id_device = $id_device "," category ='savers' ");

        //         }


        //     }else
        //     {

        //         if ($brand !=0 && $series == 0 && $id_device == 0)
        //         {

        //             if ($cov!=0 &&  $typ==0 && $feat == 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand "," product_savers.cover_material = {$cov}"," category ='savers' ");

        //             }else if($cov !=0 &&  $typ !=0 && $feat == 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand "," product_savers.cover_material = {$cov}","product_savers.type_cover = {$typ} "," category ='savers' ");

        //             }else if ($cov !=0 &&  $typ !=0 && $feat  != 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","product_savers.cover_material = {$cov}  "," product_savers.type_cover = {$typ} "," product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }
        //             else if ($cov !=0 &&  $typ ==0 && $feat  != 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","product_savers.cover_material = {$cov}  ","   product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }
        //             else  if ($cov ==0 &&  $typ !=0 && $feat == 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand "," product_savers.type_cover = {$typ}  "," category ='savers' ");

        //             }
        //             else if ($cov ==0 &&  $typ !=0 && $feat  != 0)
        //             {
        //             $whereAll = array("material.category = '{$cat}'","material.brand = $brand "," product_savers.type_cover = {$typ} "," product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }else
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand "," product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }




        //         }else if ($brand != 0 && $series !=0 && $id_device==0){


        //             if ($cov!=0 &&  $typ==0 && $feat == 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand "," material.series = $series "," product_savers.cover_material = {$cov}"," category ='savers' ");

        //             }else if($cov !=0 &&  $typ !=0 && $feat == 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","material.series = $series "," product_savers.cover_material = {$cov}","product_savers.type_cover = {$typ} "," category ='savers' ");

        //             }else if ($cov !=0 &&  $typ !=0 && $feat  != 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","material.series = $series ","product_savers.cover_material = {$cov}  "," product_savers.type_cover = {$typ} "," product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }
        //             else if ($cov !=0 &&  $typ ==0 && $feat  != 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","material.series = $series ","product_savers.cover_material = {$cov}  ","   product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }
        //             else  if ($cov ==0 &&  $typ !=0 && $feat == 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","material.series = $series "," product_savers.type_cover = {$typ}  "," category ='savers' ");

        //             }
        //             else if ($cov ==0 &&  $typ !=0 && $feat  != 0)
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","material.series = $series "," product_savers.type_cover = {$typ} "," product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }else
        //             {
        //                 $whereAll = array("material.category = '{$cat}'","material.brand = $brand ","material.series = $series "," product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }




        //         }else {


        //             if ($cov!=0 &&  $typ==0 && $feat == 0)
        //             {
        //                 $whereAll = array(" product_savers.cover_material = {$cov}"," category ='savers' ");

        //             }else if($cov !=0 &&  $typ !=0 && $feat == 0)
        //             {

        //                 $whereAll = array(" product_savers.cover_material = {$cov}","product_savers.type_cover = {$typ} "," category ='savers' ");

        //             }else if ($cov !=0 &&  $typ !=0 && $feat  != 0)
        //             {
        //                 $whereAll = array("product_savers.cover_material = {$cov}  "," product_savers.type_cover = {$typ} "," product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }
        //             else if ($cov !=0 &&  $typ ==0 && $feat  != 0)
        //             {
        //                 $whereAll = array("product_savers.cover_material = {$cov}  ","   product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }
        //             else  if ($cov ==0 &&  $typ !=0 && $feat == 0)
        //             {
        //                 $whereAll = array(" product_savers.type_cover = {$typ}  "," category ='savers' ");

        //             }
        //             else if ($cov ==0 &&  $typ !=0 && $feat  != 0)
        //             {
        //                 $whereAll = array(" product_savers.type_cover = {$typ} "," product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }else
        //             {
        //                 $whereAll = array(" product_savers.feature_cover REGEXP  {$feat}  "," category ='savers' ");

        //             }


        //         }



        //     }
        // }
        $whereAll = array("  material.category = '{$cat}'  "," category ='savers' " ,$where_brand,$where_series,$where_id_device,$where_cov,$where_typ,$where_feat,$where_userid);
        // $whereAll =  $whereAll.$where_brand.$where_series.$$where_id_device.$$where_cov.$$where_typ.$$where_feat;

        $group="   GROUP BY SUBSTRING_INDEX(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                 replace(
                     replace(
                         replace(
                                 replace(
                                         replace(
                                                 replace(
                                                         replace(LOWER(material.latiniin), 'a', ' ')
                                                     , 'b', ' '), 'c', ' '
                                             ), 'd', ' '
                                     ), 'e', ' ')
                     ,'f', ' ')
                     ,'g', ' ')
                     ,'h', ' ')
                     ,'i', ' ')
                     ,'j', ' ')
                     ,'k', ' ')
                     ,'l', ' ')
                     ,'m', ' ')
                     ,'n', ' ')
                     ,'o', ' ')
                     ,'p', ' ')
                     ,'q', ' ')
                     ,'r', ' ')
                     ,'s', ' ')
                     ,'t', ' ')
                     ,'u', ' ')
                     ,'v', ' ')
                     ,'w', ' ')
                     ,'x', ' ')
                     ,'y', ' ')
                     ,'z', ' ')
             , ' ', 1)
        
        ";


        $result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columnsx, $join, null, $whereAll,null,null);

        $start=$_REQUEST['start']+1;
        $idx=1;
        foreach($result['data'] as &$res){
            $res[0]=(string)$start;
            $start++;
            $idx++;
        }
        echo json_encode($result);

    }

    function column_type_cover($vis)
    {
        if ($this->handleLogin()) {
            if (!is_numeric($vis)) {
                $vis = 0;
            }

            $this->setting->set('type_cover',$vis);
            echo 'true';
        }
    }


	// مستخدمه هذه الدوال من تعدلون عليهن بلغوني
    function cover_material($data,$code)
    {
        if ($this->handleLogin())
        {
            $stmt = $this->db->prepare("SELECT cover_material,number from `cover_material`  ");
            $stmt->execute(array($data));

            $html=null;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                if ($data == $row['number'])
                {
                 $html.='<div class="custom-control custom-radio">
                  <input checked value="'.$row["number"].'" type="radio" id="cover_material_'.$code.$row["number"].'"   onchange="cover_material(this,'."$code".')" name="cover_material_'.$code.'" class="custom-control-input">
                  <label class="custom-control-label" for="cover_material_'.$code.$row["number"].'">'.$row["cover_material"].'</label>
                </div>';

                }else{
                  $html.='<div class="custom-control custom-radio">
                  <input value="'.$row["number"].'" type="radio" id="cover_material_'.$code.$row["number"].'"   onchange="cover_material(this,'."$code".')" name="cover_material_'.$code.'" class="custom-control-input">
                  <label class="custom-control-label" for="cover_material_'.$code.$row["number"].'">'.$row["cover_material"].'</label>
                </div>';
                }

            }
            return $html;

        }

    }




    function update_cover_material($c,$code)
    {
        if ($this->handleLogin())
        {

            $stmt=$this->db->prepare("UPDATE product_savers SET cover_material=? WHERE code =? ");
            $stmt->execute(array($c,$code));
            if ($stmt->rowCount() > 0)
            {
                echo 'true';
            }
        }

    }


    function type_cover($data,$code)
    {
        if ($this->handleLogin())
        {
            $stmt = $this->db->prepare("SELECT type_cover,number from `type_cover`   ");
            $stmt->execute(array($data));
            $html=null;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                if ($data == $row['number'])
                {
                    $html.='<div class="custom-control custom-radio">
                  <input checked value="'.$row["number"].'" type="radio" id="type_cover_'.$code.$row["number"].'"   onchange="type_cover(this,'."$code".')" name="type_cover_'.$code.'" class="custom-control-input">
                  <label class="custom-control-label" for="type_cover_'.$code.$row["number"].'">'.$row["type_cover"].'</label>
                </div>';

                }else{
                    $html.='<div class="custom-control custom-radio">
                  <input value="'.$row["number"].'" type="radio" id="type_cover_'.$code.$row["number"].'"   onchange="type_cover(this,'."$code".')" name="type_cover_'.$code.'" class="custom-control-input">
                  <label class="custom-control-label" for="type_cover_'.$code.$row["number"].'">'.$row["type_cover"].'</label>
                </div>';
                }
            }
            return $html;
        }
    }


    function update_type_cover($c,$code)
    {
        if ($this->handleLogin())
        {

            $stmt=$this->db->prepare("UPDATE product_savers SET type_cover=? WHERE code =? ");
            $stmt->execute(array($c,$code));
            if ($stmt->rowCount() > 0)
            {
                echo 'true';
            }
        }

    }


    function feature_cover($data,$code)
    {
        if ($this->handleLogin())
        {
            $stmt = $this->db->prepare("SELECT feature_cover,number from `feature_cover`   ");
            $stmt->execute(array($data));
            $html=null;

            $data=explode(',',$data);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                if (in_array($row['number'],$data) )
                {
                $html.='<div class="custom-control custom-checkbox">
                   <input checked value="'.$row["number"].'" type="checkbox" id="feature_cover_'.$code.$row["number"].'"   onchange="feature_cover(this,'."$code".')"   class="feature_cover_'.$code.' custom-control-input">
                  <label class="custom-control-label" for="feature_cover_'.$code.$row["number"].'">'.$row["feature_cover"].'</label>
                </div>';

                }else{
                  $html.='<div class="custom-control custom-checkbox">
                   <input value="'.$row["number"].'" type="checkbox" id="feature_cover_'.$code.$row["number"].'"   onchange="feature_cover(this,'."$code".')"   class="feature_cover_'.$code.'  custom-control-input">
                   <label class="custom-control-label" for="feature_cover_'.$code.$row["number"].'">'.$row["feature_cover"].'</label>
                </div>';
                }
            }
            return $html;
        }

    }

    function update_feature_cover($code)
    {
        if ($this->handleLogin())
        {
             $feature_cover=$_GET['feature'];
            $stmt=$this->db->prepare("UPDATE product_savers SET feature_cover=? WHERE code =? ");
            $stmt->execute(array($feature_cover,$code));
            if ($stmt->rowCount() > 0)
            {
                echo 'true';
            }
        }

    }


    function name_cover_material($data)
    {
        if ($this->handleLogin())
        {
            $stmt = $this->db->prepare("SELECT cover_material from `cover_material` WHERE number = ? LIMIT 1");
            $stmt->execute(array($data));
            if ($stmt->rowCount()>0)
            {
                $cover_material= $stmt->fetch(PDO::FETCH_ASSOC);
                return  $cover_material['cover_material'] ;

            }

        }

    }
    function name_type_cover($data)
    {
        if ($this->handleLogin())
        {
            $stmt = $this->db->prepare("SELECT type_cover from `type_cover` WHERE number = ? LIMIT 1");
            $stmt->execute(array($data));
            if ($stmt->rowCount()>0)
            {
                $type_cover= $stmt->fetch(PDO::FETCH_ASSOC);
                return  $type_cover['type_cover'] ;

            }

        }

    }

    function name_feature_cover($data)
    {
        if ($this->handleLogin())
        {
            $stmt = $this->db->prepare("SELECT feature_cover from `feature_cover` WHERE number IN($data)");
            $stmt->execute(array());
            $feature_cover=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $feature_cover[]=$row['feature_cover'];
            }
            return implode(',',$feature_cover);

        }

    }




    function  add_cover($id=null,$type='all')
    {
        $this->checkPermit('add_cover',$this->folder);
        $this->adminHeaderController($this->langControl('add'));



        $stmt = $this->db->prepare("SELECT * from `category_savers`  ");
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

                $form->post('id_device')
                    ->val('strip_tags');

                $form->post('type_cover')
                    ->val('strip_tags');
                $form->post('series')
                    ->val('strip_tags');
                $form->post('brand')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $data['user_id'] = $this->userid;
                if (empty($data['id_device']))
                {
                    $data['id_device']=0;
                }

                if (empty($data['type_cover']))
                {
                    $data['type_cover']=0;
                }

                if (empty($data['brand']))
                {
                    $data['brand']=0;
                }

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

                        if ($row == 1) {

                            $stmtc = $this->db->prepare("INSERT INTO `warehouses_category` (`category`,`type`,`date`) VALUES(?,?,?)");
                            $stmtc->execute(array('savers', 1, time()));
                        }
                        $stmt = $this->db->prepare("INSERT INTO `material` (`category`,`code`,`name`,`latiniin`,`date`,id_device,type,brand,series,`user_id`) VALUES(?,?,?,?,?,?,?,?,?,?)");
                        $stmt->execute(array('savers',$rowData[0][0], $rowData[0][1], $rowData[0][2],  time(),$data['id_device'],$data['type_cover'],$data['brand'],$data['series'],$data['user_id']));
                        $lastId=$this->db->lastInsertId();

                        $m=1;
                        for ($i=3 ;$i <= count($rowData[0]) ; $i++)
                        {

                            $stmtI = $this->db->prepare("INSERT INTO `warehouses`(`category`,`id_mat`,`quantity`,`number`,date) VALUES(?,?,?,?,?)");
                            $stmtI->execute(array('savers',$lastId,$rowData[0][$i], $m,time()));
                            $m++;
                        }


                    }

                    @unlink($inputFileName);
                }else
                {

                    $this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form))
                {
                    $this->lightRedirect(url.'/'.$this->folder."/cover");

                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'html','add_cover','php'));
        $this->adminFooterController();
    }


    function delete_all($model)
    {
        $user_id = $this->userid;
        if ($this->handleLogin()) {
            $this->checkPermit('delete_all', $this->folder);


            $stmt = $this->db->prepare("DELETE FROM `material` WHERE category=? and `user_id`=?");
            $stmt->execute(array($model, $user_id));

            $stmtx = $this->db->prepare("DELETE FROM `warehouses` WHERE category=?  ");
            $stmtx->execute(array($model));

            $stmtc = $this->db->prepare("DELETE FROM `warehouses_category` WHERE category=?  ");
            $stmtc->execute(array($model));
            if ($stmtc->rowCount()>0)
            {
                echo 'true';
            }


        }
    }
    function getNmaDevice_public($id)
    {



        $stmt = $this->db->prepare("SELECT * from `name_device` WHERE `id_cat`= ?  ");
        $stmt->execute(array($id));
        $nameDevice = array();

        $html="<option value='0'  selected ></option>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $html.="<option value='{$row['id']}'   >{$row['title']}</option>"  ;

        }
        echo $html ;

    }

    function typeDevice_public($id)
    {


        $stmt = $this->db->prepare("SELECT * from `type_device` WHERE `id_device`= ?  ");
        $stmt->execute(array($id));


        $html="<option value='0'  selected ></option>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $html.="<option value='{$row['id']}'   >{$row['title']}</option>"  ;
        }
        echo $html ;

    }



}