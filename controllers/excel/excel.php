<?php

class Excel extends Controller
{

    protected $model = null;

    function __construct()
    {
        parent::__construct();
        $this->table = 'excel';
        $this->excel_accessories = 'excel_accessories';
        $this->excel_games = 'excel_games';
        $this->excel_camera = 'excel_camera';
        $this->excel_computer = 'excel_computer';
        $this->excel_printing_supplies = 'excel_printing_supplies';
        $this->excel_network = 'excel_network';
        $this->excel_savers = 'excel_savers';
        $this->cart_shop_active = 'cart_shop_active';
        $this->location = 'location';
        $this->uesr_add_excel = 'uesr_add_excel';

        $this->date_archives = strtotime(date('Y-m-d h:i A', time()));
        $this->normal_date = date('Y-m-d h:i A', time());
        $this->excel_filter = 'excel_filter';
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `id` int(10) NOT NULL AUTO_INCREMENT ,
            `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `price_dollars`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `price`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `quantity`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->location}` (
            `id` int(10) NOT NULL AUTO_INCREMENT ,
            `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `location`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `quantity`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `model`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->uesr_add_excel}` (
            `id` int(10) NOT NULL AUTO_INCREMENT ,
            `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `price`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `userid`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `username`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `model`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->excel_filter}` (
            `id` int(10) NOT NULL AUTO_INCREMENT ,
            `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `price_dollars` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `quantity` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `userid`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        return $this->db->cht(array($this->table, $this->location, $this->uesr_add_excel, $this->excel_filter));
    }


    public function index()
    {
        $index = new Index();
        $index->index();
    }

    public function list_excel($model)
    {
        $this->checkPermit('list_excel', 'excel');
        $this->adminHeaderController($this->langControl('excel'));

        $code_upload = null;
        $stmt = $this->db->prepare("SELECT *FROM `excel_filter` WHERE model=? LIMIT 1");
        $stmt->execute(array($model));
        if ($stmt->rowCount()  > 0) {

            $code_upload = true;
        }



        require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();
    }



    public function processing($model)
    {
        $this->checkPermit('list_excel', 'excel');

        $this->model = $model;

        if ($model == 'mobile') {
            $excel = 'excel';
        } else {
            $excel = 'excel_' . $model;
        }


        $table = $excel;
        $primaryKey = 'id';

        $columns = array(

            array('db' => 'code', 'dt' => 0),
            array('db' => 'quantity', 'dt' => 1),
            array('db' => 'price_dollars', 'dt' => 2),
            array('db' => 'wholesale_price', 'dt' => 3),
            array('db' => 'wholesale_price2', 'dt' => 4),
            array('db' => 'cost_price', 'dt' => 5),
            array(
                'db' => 'range1', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    return number_format($d);
                }
            ),
            array(
                'db' => 'range2', 'dt' => 7,
                'formatter' => function ($d, $row) {
                    return number_format($d);
                }

            ),
            array('db' => 'number_bill', 'dt' => 8),
            array(
                'db' => 'date', 'dt' =>  9,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 10,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => 'code',
                'dt'        => 11,
                'formatter' => function ($id, $row) {

                    if ($this->checkLocation($this->model, $id)) {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('$this->model',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }
                }
            ),
            array('db' => 'id', 'dt' => 12)


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

            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
        );


        // SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )

    }


    public function mobile_location_set()
    {
        $this->checkPermit('list_excel', 'excel');
        $this->adminHeaderController($this->langControl('excel'));

        require($this->render($this->folder, 'html', 'location_set', 'php'));
        $this->adminFooterController();
    }

    public function processing_mobile_location_set()
    {
        $this->checkPermit('list_excel', 'excel');
        $table = $this->table;
        $tableJoin = $this->table . '.';
        $primaryKey = $table . '.id';

        $columns = array(

            array('db' => $tableJoin . 'code', 'dt' => 0),
            array('db' => $tableJoin . 'quantity', 'dt' => 1),
            array('db' => $tableJoin . 'price_dollars', 'dt' => 2),
            array('db' => $tableJoin . 'price', 'dt' => 3),
            array('db' => $tableJoin . 'range1', 'dt' => 4),
            array('db' => $tableJoin . 'range2', 'dt' => 5),
            array('db' => $tableJoin . 'number_bill', 'dt' => 6),
            array(
                'db' => $tableJoin . 'date', 'dt' =>  7,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin . 'id',
                'dt'        => 8,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin . 'code',
                'dt'        => 9,
                'formatter' => function ($id, $row) {

                    if ($this->checkLocation('mobile', $id)) {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('mobile',$id,$row[1]) class='btn btn-success'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }
                }
            ),
            array('db' => $tableJoin . 'id', 'dt' => 10)


        );

        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = "INNER JOIN `location` ON {$table}.code = location.code ";
        $whereAll = array("location.model='mobile'");
        $group = "GROUP BY {$table}.code";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll, null, $group)
        );
    }



    public function mobile_location_set_not()
    {
        $this->checkPermit('list_excel', 'excel');
        $this->adminHeaderController($this->langControl('excel'));


        require($this->render($this->folder, 'html', 'location_set_not', 'php'));
        $this->adminFooterController();
    }

    public function processing_mobile_location_set_not()
    {
        $this->checkPermit('list_excel', 'excel');
        $table = $this->table;
        $tableJoin = $table . '.';
        $primaryKey = $table . '.id';

        $columns = array(

            array('db' => $tableJoin . 'code', 'dt' => 0),
            array('db' => $tableJoin . 'quantity', 'dt' => 1),
            array('db' => $tableJoin . 'price_dollars', 'dt' => 2),
            array('db' => $tableJoin . 'price', 'dt' => 3),
            array('db' => $tableJoin . 'range1', 'dt' => 4),
            array('db' => $tableJoin . 'range2', 'dt' => 5),
            array('db' => $tableJoin . 'number_bill', 'dt' => 6),
            array(
                'db' => $tableJoin . 'date', 'dt' =>  7,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin . 'id',
                'dt'        => 8,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin . 'code',
                'dt'        => 9,
                'formatter' => function ($id, $row) {

                    if ($this->checkLocation('mobile', $id)) {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('mobile',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }
                }
            ),
            array('db' => $tableJoin . 'id', 'dt' => 10)


        );

        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = "LEFT JOIN location ON {$table}.code = location.code  LEFT JOIN code ON excel.code=code.code ";
        $whereAll = array('location.code Is NULL', "code.location <> ''");

        echo json_encode(

            Ssp::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll)
        );
    }



    function  add($model)
    {
        $this->checkPermit('add_' . $model, 'excel');
        $this->adminHeaderController($this->langControl('add'));

        $this->AddToTraceByFunction($this->userid, 'excel', 'add/' . $model);
        if ($model == 'mobile') {
            $excel = 'excel';
            $code = 'code';
        } else
            if ($model == 'accessories') {
            $excel = 'excel_' . $model;
            $code = 'color_accessories';
        } else
                if ($model == 'savers') {
            $excel = 'excel_' . $model;
            $code = 'product_savers';
        } else {
            $excel = 'excel_' . $model;
            $code = 'code_' . $model;
        }



        $code_upload = null;
        $stmt = $this->db->prepare("SELECT *FROM `excel_filter` WHERE model=? LIMIT 1");
        $stmt->execute(array($model));
        if ($stmt->rowCount()  > 0) {
            $code_upload = true;
        }



        if (isset($_POST["submit"])) {


            try {
                $form = new  Form();

                $form->post('files_normal')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $name_file = json_decode($data['files_normal'], true);

                $inputFileName = $this->root_file . '/files/' . $name_file[0]['rand_name'];
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


                    $stmtdel = $this->db->prepare("DELETE  FROM `{$excel}` WHERE 1");
                    $stmtdel->execute();

                    $stmt_loc = $this->db->prepare("DELETE  FROM `location_confirm` WHERE model =?");
                    $stmt_loc->execute(array($model));

                    $stmt_f = $this->db->prepare("DELETE  FROM `excel_filter` WHERE model =?");
                    $stmt_f->execute(array($model));

                    $stmt_loc2 = $this->db->prepare("DELETE  FROM `location` WHERE model =?");
                    $stmt_loc2->execute(array($model));

                    $date = time();

                    $stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
                    $stmt_date->execute(array($model, $date));

                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray(
                            'A' . $row . ':' . $highestColumn . $row,
                            FALSE,
                            TRUE,
                            TRUE
                        );


                        if (count($rowData[0]) >= 4) {






                            if ($this->permit('wholesale_price', $this->folder)) {

                                if (!isset($rowData[0][4])) {
                                    $rowData[0][4] = 'NULL';
                                } else {
                                    if (empty($rowData[0][4])) {
                                        $rowData[0][4] = 'NULL';
                                    }
                                }

                                if (!isset($rowData[0][5])) {
                                    $rowData[0][5] = 'NULL';
                                } else {
                                    if (empty($rowData[0][5])) {
                                        $rowData[0][5] = 'NULL';
                                    }
                                }
                                if (!isset($rowData[0][6])) {
                                    $rowData[0][6] = 'NULL';
                                } else {
                                    if (empty($rowData[0][6])) {
                                        $rowData[0][6] = 'NULL';
                                    }
                                }
                            } else {
                                $rowData[0][4] = 'NULL';
                                $rowData[0][5] = 'NULL';
                                $rowData[0][6] = 'NULL';
                            }




                            if (!empty($rowData[0][0])) {

                                $q = (int)trim(strip_tags($rowData[0][1]));
                                $code_excel = trim(strip_tags($rowData[0][0]));


                                $stmt_code = $this->db->prepare("SELECT *FROM `{$code}` WHERE code=? AND is_delete=0");
                                $stmt_code->execute(array($code_excel));
                                if ($stmt_code->rowCount() > 0) {

                                    $stmt = $this->db->prepare("INSERT INTO {$excel} (`code`,`quantity`,`price_dollars`, `range1`,`range2`,`number_bill`,`date`,`userid`,`date_archives`,`wholesale_price`,`wholesale_price2`,`cost_price`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                                    $stmt->execute(array($code_excel, $q, $rowData[0][2],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][3], $date, $this->userid, $this->date_archives, $rowData[0][4], $rowData[0][5], $rowData[0][6]));

                                    if ($stmt->rowCount() > 0) {

                                        $this->Add_to_sync_schedule($code_excel, $model, 'quantity_adjustment', ' ', 'controllers\excel\excel.php 561 ' . $this->UserInfo($this->userid));
                                        $stmtInsert = $this->db->prepare("INSERT INTO  location_confirm  (code, price_dollars, quantity, model, date)  values  (?,?,?,?,?) ");
                                        $stmtInsert->execute(array($code_excel, $rowData[0][2], $q, $model, time()));


                                        $stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,`number_bill`,`wholesale_price`,`wholesale_price2`,`cost_price`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                                        $stmt_user_add_excel->execute(array($code_excel, $q, $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date, '', 'new', $model, $rowData[0][3], $rowData[0][4], $rowData[0][5], $rowData[0][6]));


                                        if ($q > 0) {

                                            $stmtUpdateOffer = $this->db->prepare(" UPDATE  offers_item   INNER JOIN offers    ON offers.id=offers_item.id_offer INNER JOIN  {$excel} ON {$excel}.code=offers_item.code SET  offers.active = 1 ,  offers.note = ''  WHERE offers_item.code =? AND offers_item.model=? ");
                                            $stmtUpdateOffer->execute(array($code_excel, $model));
                                        } else {
                                            $stmtUpdateOffer = $this->db->prepare(" UPDATE  offers_item   INNER JOIN offers  ON offers.id=offers_item.id_offer INNER JOIN {$excel} ON {$excel}.code=offers_item.code SET  offers.active = 2 ,  offers.note = 'نفذت كمية بعض مواد العرض'  WHERE offers_item.code =? AND offers_item.model=? ");
                                            $stmtUpdateOffer->execute(array($code_excel, $model));
                                        }

                                        $this->insertCodeSerial_conform($code, $model, 'حذف واستبدال');
                                    }

                                    //                                        $lc=new location_confirm();
                                    //                                        $lc->update($code_excel,$q,$model, $rowData[0][2]);

                                } else {

                                    $stmt_filter = $this->db->prepare("INSERT INTO excel_filter (`code`,`quantity`,`price_dollars`,`model`,`userid`,`date` ) VALUES( ?,?,?,?,?,?)");
                                    $stmt_filter->execute(array($code_excel, $q, $rowData[0][2], $model, $this->userid, time()));
                                }
                            }
                        } else {
                            $this->error_form = json_encode(array('files_normal' => 'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
                            break;
                        }
                    }

                    @unlink($inputFileName);
                } else {

                    $this->error_form = json_encode(array('files_normal' => 'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form)) {
                    $this->lightRedirect(url . "/location_confirm/view/{$model}");
                }
            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }
        }

        require($this->render($this->folder, 'html', 'add', 'php'));
        $this->adminFooterController();
    }



    function  cumulative_upload($model)
    {

        $this->checkPermit($model . '_cumulative_upload', 'excel');
        $this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid, 'excel', 'cumulative_upload/' . $model);
        if ($model == 'mobile') {
            $excel = 'excel';
            $code = 'code';
        } else   if ($model == 'accessories') {
            $excel = 'excel_' . $model;
            $code = 'color_accessories';
        } else   if ($model == 'savers') {
            $excel = 'excel_' . $model;
            $code = 'product_savers';
        } else {
            $excel = 'excel_' . $model;
            $code = 'code_' . $model;
        }


        $code_upload = null;
        $stmt = $this->db->prepare("SELECT *FROM `excel_filter` WHERE model=? LIMIT 1");
        $stmt->execute(array($model));
        if ($stmt->rowCount()  > 0) {
            $code_upload = true;
        }


        if (isset($_POST["submit"])) {


            try {
                $form = new  Form();

                $form->post('files_cumulative_upload')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $name_file = json_decode($data['files_cumulative_upload'], true);

                $inputFileName = $this->root_file . '/files/' . $name_file[0]['rand_name'];
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

                    $date = time();
                    $stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
                    $stmt_date->execute(array($model, $date));


                    $stmt_update_cnf = $this->db->prepare("UPDATE   `location_confirm` SET `quantity`=0 WHERE   `model`=? AND `quantity` < 0 ");
                    $stmt_update_cnf->execute(array($model));


                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray(
                            'A' . $row . ':' . $highestColumn . $row,
                            FALSE,
                            TRUE,
                            TRUE
                        );



                        if (count($rowData[0]) >= 4) {


                            if ($this->permit('wholesale_price', $this->folder)) {

                                if (!isset($rowData[0][4])) {
                                    $rowData[0][4] = 'NULL';
                                } else {
                                    if (empty($rowData[0][4])) {
                                        $rowData[0][4] = 'NULL';
                                    }
                                }

                                if (!isset($rowData[0][5])) {
                                    $rowData[0][5] = 'NULL';
                                } else {
                                    if (empty($rowData[0][5])) {
                                        $rowData[0][5] = 'NULL';
                                    }
                                }
                                if (!isset($rowData[0][6])) {
                                    $rowData[0][6] = 'NULL';
                                } else {
                                    if (empty($rowData[0][6])) {
                                        $rowData[0][6] = 'NULL';
                                    }
                                }
                            } else {
                                $rowData[0][4] = 'NULL';
                                $rowData[0][5] = 'NULL';
                                $rowData[0][6] = 'NULL';
                            }




                            $q = (int)trim(strip_tags($rowData[0][1]));
                            $code_excel = trim(strip_tags($rowData[0][0]));

                            $stmt_code = $this->db->prepare("SELECT *FROM `{$code}` WHERE code=? AND is_delete=0");

                            $stmt_code->execute(array($code_excel));
                            if ($stmt_code->rowCount() > 0) {
                                if ($q >= 0) {
                                    $stmt_Loction_conform = $this->db->prepare("DELETE  FROM `location_confirm` WHERE code = ?  AND  model =? AND location <> '' ");
                                    $stmt_Loction_conform->execute(array($code, $model));

                                    $stmt = $this->db->prepare("SELECT * FROM {$excel} WHERE `code`=? ");
                                    $stmt->execute(array($code_excel));
                                    if ($stmt->rowCount() > 0) {


                                        $stmtExcel = $this->db->prepare("UPDATE  {$excel} SET `quantity`=quantity + {$q} ,`price_dollars`=? , `range1`=?,`range2`=?,`number_bill`=?, `date` = ? ,`userid`=? ,`date_archives`=?,wholesale_price=COALESCE({$rowData[0][4]},wholesale_price) ,wholesale_price2=COALESCE({$rowData[0][5]},wholesale_price2) ,cost_price=COALESCE({$rowData[0][6]},cost_price)  WHERE `code`= ?  ");
                                        $stmtExcel->execute(array($rowData[0][2],   $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][3], $date, $this->userid, $this->date_archives, $code_excel));
                                        if ($stmtExcel->rowCount() > 0) {



                                            $stmtcm = $this->db->prepare("SELECT *FROM location_confirm WHERE code=? AND model=? ");
                                            $stmtcm->execute(array(trim($code_excel), $model));
                                            if ($stmtcm->rowCount() > 0) {
                                                $stmtUpdate = $this->db->prepare("UPDATE location_confirm SET quantity=  quantity + {$q} ,date=? ,price_dollars=? ,location=''  WHERE  code=? AND model=?  ");
                                                $stmtUpdate->execute(array(time(), $rowData[0][2], trim($code_excel), $model));
                                                if ($stmtUpdate->rowCount() <= 0) {
                                                    $this->filter_error_quantity($code_excel, $model, $rowData[0][2], 'رفع تراكمي اكسيل كميات واسعار - رقم الخطا 1');
                                                }
                                            } else {
                                                $stmtInsert = $this->db->prepare("INSERT INTO  location_confirm  (code, price_dollars, quantity, model, date,userid)  values  (?,?,?,?,?,?) ");
                                                $stmtInsert->execute(array(trim($code_excel), $rowData[0][2], $q, $model, time(), $this->userid));
                                                if ($stmtInsert->rowCount() <= 0) {
                                                    $this->filter_error_quantity($code_excel, $model, $rowData[0][2], 'رفع تراكمي اكسيل كميات واسعار - رقم الخطا 2');
                                                }
                                            }

                                            if ($q > 0) {

                                                $stmtUpdateOffer = $this->db->prepare(" UPDATE  offers_item   INNER JOIN offers    ON offers.id=offers_item.id_offer INNER JOIN  {$excel} ON {$excel}.code=offers_item.code SET  offers.active = 1 ,  offers.note = ''  WHERE offers_item.code =? AND offers_item.model=? ");
                                                $stmtUpdateOffer->execute(array($code_excel, $model));
                                            } else {
                                                $stmtUpdateOffer = $this->db->prepare(" UPDATE  offers_item   INNER JOIN offers  ON offers.id=offers_item.id_offer INNER JOIN {$excel} ON {$excel}.code=offers_item.code SET  offers.active = 2 ,  offers.note = 'نفذت كمية بعض مواد العرض'  WHERE offers_item.code =? AND offers_item.model=? ");
                                                $stmtUpdateOffer->execute(array($code_excel, $model));
                                            }


                                            $stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,number_bill,`wholesale_price`,`wholesale_price2`,`cost_price`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                                            $stmt_user_add_excel->execute(array($code_excel, $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date, 'بلا', 'old', $model, $rowData[0][3], $rowData[0][4], $rowData[0][5], $rowData[0][6]));
                                            $this->Add_to_sync_schedule($code_excel, $model, 'quantity_adjustment', ' ', ' controllers\excel\excel.php 809 رفع تراكمي ' . $this->UserInfo($this->userid));

                                            $this->insertCodeSerial_conform($code_excel, $model, 'رفع تراكمي اكسيل كميات واسعار');
                                        }
                                    } else {

                                        $stmtExcel = $this->db->prepare("INSERT INTO {$excel}  (`code`,`quantity`,`price_dollars`, `range1`,`range2`,`number_bill`,`date`,`userid`,`date_archives`,`wholesale_price`,`wholesale_price2`,`cost_price`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                                        $stmtExcel->execute(array($code_excel, $q, $rowData[0][2], $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][3], $date, $this->userid, $this->date_archives, $rowData[0][4], $rowData[0][5], $rowData[0][6]));
                                        if ($stmtExcel->rowCount() > 0) {

                                            $stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,number_bill,`wholesale_price`,`wholesale_price2`,`cost_price`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                                            $stmt_user_add_excel->execute(array($code_excel, $q, $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date, 'بلا', 'old', $model, $rowData[0][3], $rowData[0][4], $rowData[0][5], $rowData[0][6]));





                                            $stmtcm = $this->db->prepare("SELECT *FROM location_confirm WHERE code=? AND model=? ");
                                            $stmtcm->execute(array(trim($code_excel), $model));
                                            if ($stmtcm->rowCount() > 0) {
                                                $stmtUpdate = $this->db->prepare("UPDATE location_confirm SET quantity=  quantity + {$q} ,date=? ,price_dollars=? ,location='',userid=?  WHERE  code=? AND model=?  ");
                                                $stmtUpdate->execute(array(time(), $rowData[0][2], $this->userid, trim($code_excel), $model));
                                                if ($stmtUpdate->rowCount() <= 0) {
                                                    $this->filter_error_quantity($code_excel, $model, $rowData[0][2], 'رفع تراكمي اكسيل كميات واسعار - رقم الخطا 3');
                                                }
                                            } else {
                                                $stmtInsert = $this->db->prepare("INSERT INTO  location_confirm  (code, price_dollars, quantity, model, `date`,userid)  values  (?,?,?,?,?,?) ");
                                                $stmtInsert->execute(array($code_excel, $rowData[0][2], $q, $model, time(), $this->userid));
                                                if ($stmtInsert->rowCount() <= 0) {
                                                    $this->filter_error_quantity($code_excel, $model, $rowData[0][2], 'رفع تراكمي اكسيل كميات واسعار - رقم الخطا 4');
                                                }
                                            }






                                            if ($q > 0) {

                                                $stmtUpdateOffer = $this->db->prepare(" UPDATE  offers_item   INNER JOIN offers    ON offers.id=offers_item.id_offer INNER JOIN  {$excel} ON {$excel}.code=offers_item.code SET  offers.active = 1 ,  offers.note = ''  WHERE offers_item.code =? AND offers_item.model=? ");
                                                $stmtUpdateOffer->execute(array($code_excel, $model));
                                            } else {
                                                $stmtUpdateOffer = $this->db->prepare(" UPDATE  offers_item   INNER JOIN offers  ON offers.id=offers_item.id_offer INNER JOIN {$excel} ON {$excel}.code=offers_item.code SET  offers.active = 2 ,  offers.note = 'نفذت كمية بعض مواد العرض'  WHERE offers_item.code =? AND offers_item.model=? ");
                                                $stmtUpdateOffer->execute(array($code_excel, $model));
                                            }



                                            $this->Add_to_sync_schedule($code_excel, $model, 'quantity_adjustment', ' ', ' controllers\excel\excel.php 854 ' . $this->UserInfo($this->userid));
                                            $this->insertCodeSerial_conform($code_excel, $model, 'رفع تراكمي اكسيل كميات واسعار');
                                        }
                                    }
                                }
                                else{
                                    $stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,number_bill,`wholesale_price`,`wholesale_price2`,`cost_price`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                                    $stmt_user_add_excel->execute(array($code_excel, $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date, 'بلا', 'old', $model, $rowData[0][3], $rowData[0][4], $rowData[0][5], $rowData[0][6]));
                                }
                            } else {

                                $stmt_filter = $this->db->prepare("INSERT INTO excel_filter (`code`,`quantity`,`price_dollars`,`model`,`userid`,`date` ) VALUES( ?,?,?,?,?,?)");
                                $stmt_filter->execute(array($code_excel, $rowData[0][1], $rowData[0][2], $model, $this->userid, time()));
                            }
                        } else {
                            $this->error_form2 = json_encode(array('files_cumulative_upload' => 'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
                            break;
                        }
                    }

                    @unlink($inputFileName);
                } else {

                    $this->error_form2 = json_encode(array('files_cumulative_upload' => 'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form2)) {
                    $this->lightRedirect(url . "/location_confirm/view/{$model}");
                }
            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form2 = $e->getMessage();
            }
        }

        require($this->render($this->folder, 'html', 'add', 'php'));
        $this->adminFooterController();
    }


    function delete_excel($id, $model)
    {
        if ($this->handleLogin()) {


            $this->AddToTraceByFunction($this->userid, 'excel', 'delete_excel/' . $id . '/' . $model);
            if ($model == 'mobile') {
                $excel = 'excel';
                $code = 'code';
            } else   if ($model == 'accessories') {
                $excel = 'excel_' . $model;
                $code = 'color_accessories';
            } else   if ($model == 'savers') {
                $excel = 'excel_' . $model;
                $code = 'product_savers';
            } else {
                $excel = 'excel_' . $model;
                $code = 'code_' . $model;
            }


            $response = $this->db->delete($excel, "`id`={$id}");
            echo 'true';
        }
    }




    public function accessories_location_set()
    {
        $this->checkPermit('list_excel', 'excel');
        $this->adminHeaderController($this->langControl('excel'));

        require($this->render($this->folder, 'accessories', 'location_set', 'php'));
        $this->adminFooterController();
    }

    public function processing_accessories_location_set()
    {
        $this->checkPermit('list_excel', 'excel');
        $table = 'excel_accessories';
        $primaryKey = $table . '.id';
        $tableJoin = $table . '.';

        $columns = array(

            array('db' => $tableJoin . 'code', 'dt' => 0),
            array('db' => $tableJoin . 'quantity', 'dt' => 1),
            array('db' => $tableJoin . 'price_dollars', 'dt' => 2),
            array('db' => $tableJoin . 'price', 'dt' => 3),
            array('db' => $tableJoin . 'range1', 'dt' => 4),
            array('db' => $tableJoin . 'range2', 'dt' => 5),
            array('db' => $tableJoin . 'color', 'dt' => 6),
            array('db' => $tableJoin . 'number_bill', 'dt' => 7),
            array(
                'db' => $tableJoin . 'date', 'dt' => 8,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin . 'id',
                'dt'        => 9,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin . 'code',
                'dt'        => 10,
                'formatter' => function ($id, $row) {

                    if ($this->checkLocation('accessories', $id, $row[6])) {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('accessories',$id,$row[1],'$row[6]') class='btn btn-success'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }
                }
            ),
            array('db' => $tableJoin . 'id', 'dt' => 11)


        );

        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "INNER JOIN `location` ON {$table}.code = location.code ";
        $whereAll = array("location.model='accessories'");
        $group = "GROUP BY {$table}.code";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll, null, $group)
        );
    }



    public function accessories_location_set_not()
    {
        $this->checkPermit('list_excel', 'excel');
        $this->adminHeaderController($this->langControl('excel'));

        require($this->render($this->folder, 'accessories', 'location_set_not', 'php'));
        $this->adminFooterController();
    }

    public function processing_accessories_location_set_not()
    {
        $this->checkPermit('list_excel', 'excel');
        $table = 'excel_accessories';
        $tableJoin = '';
        $primaryKey = 'id';


        $columns = array(

            array('db' => $tableJoin . 'code', 'dt' => 0),
            array('db' => $tableJoin . 'quantity', 'dt' => 1),
            array('db' => $tableJoin . 'price_dollars', 'dt' => 2),
            array('db' => $tableJoin . 'price', 'dt' => 3),
            array('db' => $tableJoin . 'range1', 'dt' => 4),
            array('db' => $tableJoin . 'range2', 'dt' => 5),
            array('db' => $tableJoin . 'color', 'dt' => 6),
            array('db' => $tableJoin . 'number_bill', 'dt' => 7),
            array(
                'db' => $tableJoin . 'date', 'dt' => 8,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin . 'id',
                'dt'        => 9,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin . 'code',
                'dt'        => 10,
                'formatter' => function ($id, $row) {

                    if ($this->checkLocation('accessories', $id, $row[6])) {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('accessories',$id,$row[1],'$row[6]') class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }
                }
            ),
            array('db' => $tableJoin . 'id', 'dt' => 11)


        );


        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        //        $join = "LEFT JOIN location ON   location.code = {$table}.code LEFT JOIN color_accessories ON color_accessories.code = excel_accessories.code  ";
        //        $whereAll = array('location.code Is NULL' , "color_accessories.location <> ''","location.model='accessories'");

        echo json_encode(

            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "{$table}.code NOT IN (SELECT location.code FROM location  WHERE     location.model='accessories')")
        );
    }






    public function savers_location_set()
    {
        $this->checkPermit('savers_location_set', 'excel');
        $this->adminHeaderController($this->langControl('excel'));

        require($this->render($this->folder, 'service', 'location_set', 'php'));
        $this->adminFooterController();
    }



    public function processing_service_location_set()
    {
        $this->checkPermit('savers_location_set', 'excel');

        $table = 'excel_savers';
        $primaryKey = $table . '.id';
        $tableJoin = $table . '.';

        $columns = array(

            array('db' => $tableJoin . 'code', 'dt' => 0),
            array('db' => $tableJoin . 'quantity', 'dt' => 1),
            array('db' => $tableJoin . 'price_dollars', 'dt' => 2),
            array('db' => $tableJoin . 'price', 'dt' => 3),
            array('db' => $tableJoin . 'number_bill', 'dt' => 4),
            array(
                'db' => $tableJoin . 'date', 'dt' =>  5,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin . 'id',
                'dt'        => 6,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin . 'code',
                'dt'        => 7,
                'formatter' => function ($id, $row) {

                    if ($this->checkLocation('product_savers', $id)) {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('product_savers',$id,$row[2]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }
                }
            ),
            array('db' => $tableJoin . 'id', 'dt' => 8)


        );

        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        $join = "INNER JOIN `location` ON {$table}.code = location.code ";
        $whereAll = array("location.model='product_savers'");
        $group = "GROUP BY {$table}.code";

        echo json_encode(
            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll, null, $group)
        );
    }





    public function savers_location_set_not()
    {
        $this->checkPermit('savers_location_set_not', 'excel');
        $this->adminHeaderController($this->langControl('excel'));

        require($this->render($this->folder, 'service', 'location_set_not', 'php'));
        $this->adminFooterController();
    }



    public function processing_service_location_set_not()
    {
        $this->checkPermit('savers_location_set_not', 'excel');

        $table = 'excel_savers';
        $primaryKey = 'id';
        $tableJoin = '';

        $columns = array(

            array('db' => $tableJoin . 'code', 'dt' => 0),
            array('db' => $tableJoin . 'quantity', 'dt' => 1),
            array('db' => $tableJoin . 'price_dollars', 'dt' => 2),
            array('db' => $tableJoin . 'price', 'dt' => 3),
            array('db' => $tableJoin . 'number_bill', 'dt' => 4),
            array(
                'db' => $tableJoin . 'date', 'dt' =>  5,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin . 'id',
                'dt'        => 6,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin . 'code',
                'dt'        => 7,
                'formatter' => function ($id, $row) {

                    if ($this->checkLocation('product_savers', $id)) {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('product_savers',$id,$row[2]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }
                }
            ),
            array('db' => $tableJoin . 'id', 'dt' => 8)


        );

        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        //
        //		$join = "LEFT JOIN location ON   location.code = {$table}.code LEFT JOIN product_savers ON product_savers.code = excel_savers.code  ";
        //		$whereAll = array('location.code IS NULL' );
        //		$group = "GROUP BY excel_savers.code";

        echo json_encode(

            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "{$table}.code NOT IN (SELECT location.code FROM location  WHERE     location.model='savers')")
        );
    }




    public function games_location_set()
    {
        $this->checkPermit('list_excel', 'excel');
        $this->adminHeaderController($this->langControl('excel'));

        require($this->render($this->folder, 'games', 'location_set', 'php'));
        $this->adminFooterController();
    }

    public function processing_games_location_set()
    {
        $this->checkPermit('list_excel', 'excel');
        $table = 'excel_games';
        $primaryKey = $table . '.id';
        $tableJoin = $table . '.';
        $columns = array(

            array('db' => $tableJoin . 'code', 'dt' => 0),
            array('db' => $tableJoin . 'quantity', 'dt' => 1),
            array('db' => $tableJoin . 'price_dollars', 'dt' => 2),
            array('db' => $tableJoin . 'price', 'dt' => 3),
            array('db' => $tableJoin . 'range1', 'dt' => 4),
            array('db' => $tableJoin . 'range2', 'dt' => 5),
            array('db' => $tableJoin . 'number_bill', 'dt' => 6),
            array(
                'db' => $tableJoin . 'date', 'dt' =>  7,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin . 'id',
                'dt'        => 8,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin . 'code',
                'dt'        => 9,
                'formatter' => function ($id, $row) {

                    if ($this->checkLocation('games', $id)) {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('games',$id,$row[1]) class='btn btn-success'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }
                }
            ),
            array('db' => $tableJoin . 'id', 'dt' => 10)


        );

        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );



        $join = "INNER JOIN `location` ON {$table}.code = location.code ";
        $whereAll = array("location.model='games'");
        $group = "GROUP BY {$table}.code";

        echo json_encode(
            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll, null, $group)
        );
    }



    public function games_location_set_not()
    {
        $this->checkPermit('list_excel', 'excel');
        $this->adminHeaderController($this->langControl('excel'));

        require($this->render($this->folder, 'games', 'location_set_not', 'php'));
        $this->adminFooterController();
    }

    public function processing_games_location_set_not()
    {
        $this->checkPermit('list_excel', 'excel');
        $table = 'excel_games';
        $tableJoin = '';
        $primaryKey = 'id';

        $columns = array(

            array('db' => $tableJoin . 'code', 'dt' => 0),
            array('db' => $tableJoin . 'quantity', 'dt' => 1),
            array('db' => $tableJoin . 'price_dollars', 'dt' => 2),
            array('db' => $tableJoin . 'price', 'dt' => 3),
            array('db' => $tableJoin . 'range1', 'dt' => 4),
            array('db' => $tableJoin . 'range2', 'dt' => 5),
            array('db' => $tableJoin . 'number_bill', 'dt' => 6),
            array(
                'db' => $tableJoin . 'date', 'dt' =>  7,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin . 'id',
                'dt'        => 8,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin . 'code',
                'dt'        => 9,
                'formatter' => function ($id, $row) {

                    if ($this->checkLocation('games', $id)) {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('games',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }
                }
            ),
            array('db' => $tableJoin . 'id', 'dt' => 10)


        );

        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        //        $join = "LEFT JOIN location ON {$table}.code = location.code  LEFT JOIN code_games ON excel_games.code=code_games.code ";
        //        $whereAll = array('location.code Is NULL' , "code_games.location <> ''");

        echo json_encode(

            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "{$table}.code  IN (SELECT location.code FROM location  WHERE     location.model='games')")
        );


        // SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )

    }





    public function camera_location_set()
    {
        $this->checkPermit('list_excel', 'excel');
        $this->adminHeaderController($this->langControl('excel'));

        require($this->render($this->folder, 'camera', 'location_set', 'php'));
        $this->adminFooterController();
    }

    public function processing_camera_location_set()
    {
        $this->checkPermit('list_excel', 'excel');
        $table = 'excel_camera';
        $primaryKey = $table . '.id';
        $tableJoin = $table . '.';
        $columns = array(

            array('db' => $tableJoin . 'code', 'dt' => 0),
            array('db' => $tableJoin . 'quantity', 'dt' => 1),
            array('db' => $tableJoin . 'price_dollars', 'dt' => 2),
            array('db' => $tableJoin . 'price', 'dt' => 3),
            array('db' => $tableJoin . 'range1', 'dt' => 4),
            array('db' => $tableJoin . 'range2', 'dt' => 5),
            array('db' => $tableJoin . 'number_bill', 'dt' => 6),
            array(
                'db' => $tableJoin . 'date', 'dt' =>  7,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin . 'id',
                'dt'        => 8,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin . 'code',
                'dt'        => 9,
                'formatter' => function ($id, $row) {

                    if ($this->checkLocation('camera', $id)) {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('camera',$id,$row[1]) class='btn btn-success'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }
                }
            ),
            array('db' => $tableJoin . 'id', 'dt' => 10)


        );

        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );





        $join = "INNER JOIN `location` ON {$table}.code = location.code ";
        $whereAll = array("location.model='camera'");
        $group = "GROUP BY {$table}.code";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll, null, $group)
        );
    }



    public function camera_location_set_not()
    {
        $this->checkPermit('list_excel', 'excel');
        $this->adminHeaderController($this->langControl('excel'));

        require($this->render($this->folder, 'camera', 'location_set_not', 'php'));
        $this->adminFooterController();
    }

    public function processing_camera_location_set_not()
    {
        $this->checkPermit('list_excel', 'excel');
        $table = 'excel_camera';
        $tableJoin = '';
        $primaryKey = 'id';

        $columns = array(

            array('db' => $tableJoin . 'code', 'dt' => 0),
            array('db' => $tableJoin . 'quantity', 'dt' => 1),
            array('db' => $tableJoin . 'price_dollars', 'dt' => 2),
            array('db' => $tableJoin . 'price', 'dt' => 3),
            array('db' => $tableJoin . 'range1', 'dt' => 4),
            array('db' => $tableJoin . 'range2', 'dt' => 5),
            array('db' => $tableJoin . 'number_bill', 'dt' => 6),
            array(
                'db' => $tableJoin . 'date', 'dt' =>  7,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin . 'id',
                'dt'        => 8,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin . 'code',
                'dt'        => 9,
                'formatter' => function ($id, $row) {

                    if ($this->checkLocation('camera', $id)) {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('camera',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }
                }
            ),
            array('db' => $tableJoin . 'id', 'dt' => 10)


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

            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "{$table}.code  NOT IN  (SELECT location.code FROM location  WHERE     location.model='camera')")
        );


        // SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )

    }






    public function network_location_set()
    {
        $this->checkPermit('list_excel', 'excel');
        $this->adminHeaderController($this->langControl('excel'));

        require($this->render($this->folder, 'network', 'location_set', 'php'));
        $this->adminFooterController();
    }

    public function processing_network_location_set()
    {
        $this->checkPermit('list_excel', 'excel');
        $table = 'excel_network';
        $tableJoin = $table . '.';
        $primaryKey = $table . '.id';

        $columns = array(

            array('db' => $tableJoin . 'code', 'dt' => 0),
            array('db' => $tableJoin . 'quantity', 'dt' => 1),
            array('db' => $tableJoin . 'price_dollars', 'dt' => 2),
            array('db' => $tableJoin . 'price', 'dt' => 3),
            array('db' => $tableJoin . 'range1', 'dt' => 4),
            array('db' => $tableJoin . 'range2', 'dt' => 5),
            array('db' => $tableJoin . 'number_bill', 'dt' => 6),
            array(
                'db' => $tableJoin . 'date', 'dt' =>  7,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin . 'id',
                'dt'        => 8,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin . 'code',
                'dt'        => 9,
                'formatter' => function ($id, $row) {

                    if ($this->checkLocation('network', $id)) {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('network',$id,$row[1]) class='btn btn-success'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }
                }
            ),
            array('db' => $tableJoin . 'id', 'dt' => 10)


        );

        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "INNER JOIN `location` ON {$table}.code = location.code ";
        $whereAll = array("location.model='network'");
        $group = "GROUP BY {$table}.code";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll, null, $group)
        );
    }



    public function network_location_set_not()
    {
        $this->checkPermit('list_excel', 'excel');
        $this->adminHeaderController($this->langControl('excel'));

        require($this->render($this->folder, 'network', 'location_set_not', 'php'));
        $this->adminFooterController();
    }

    public function processing_network_location_set_not()
    {
        $this->checkPermit('list_excel', 'excel');
        $table = 'excel_network';
        $tableJoin = '';
        $primaryKey = 'id';

        $columns = array(

            array('db' => $tableJoin . 'code', 'dt' => 0),
            array('db' => $tableJoin . 'quantity', 'dt' => 1),
            array('db' => $tableJoin . 'price_dollars', 'dt' => 2),
            array('db' => $tableJoin . 'price', 'dt' => 3),
            array('db' => $tableJoin . 'range1', 'dt' => 4),
            array('db' => $tableJoin . 'range2', 'dt' => 5),
            array('db' => $tableJoin . 'number_bill', 'dt' => 6),
            array(
                'db' => $tableJoin . 'date', 'dt' =>  7,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin . 'id',
                'dt'        => 8,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin . 'code',
                'dt'        => 9,
                'formatter' => function ($id, $row) {

                    if ($this->checkLocation('network', $id)) {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('network',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }
                }
            ),
            array('db' => $tableJoin . 'id', 'dt' => 10)


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

            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "{$table}.code  NOT IN  (SELECT location.code FROM location  WHERE     location.model='network')")
        );


        // SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )

    }




    public function computer_location_set()
    {
        $this->checkPermit('list_excel', 'excel');
        $this->adminHeaderController($this->langControl('excel'));

        require($this->render($this->folder, 'computer', 'location_set', 'php'));
        $this->adminFooterController();
    }

    public function processing_computer_location_set()
    {
        $this->checkPermit('list_excel', 'excel');
        $table = 'excel_computer';
        $primaryKey = $table . '.id';
        $tableJoin = $table . '.';
        $columns = array(

            array('db' => $tableJoin . 'code', 'dt' => 0),
            array('db' => $tableJoin . 'quantity', 'dt' => 1),
            array('db' => $tableJoin . 'price_dollars', 'dt' => 2),
            array('db' => $tableJoin . 'price', 'dt' => 3),
            array('db' => $tableJoin . 'range1', 'dt' => 4),
            array('db' => $tableJoin . 'range2', 'dt' => 5),
            array('db' => $tableJoin . 'number_bill', 'dt' => 6),
            array(
                'db' => $tableJoin . 'date', 'dt' =>  7,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin . 'id',
                'dt'        => 8,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin . 'code',
                'dt'        => 9,
                'formatter' => function ($id, $row) {

                    if ($this->checkLocation('computer', $id)) {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('computer',$id,$row[1]) class='btn btn-success'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }
                }
            ),
            array('db' => $tableJoin . 'id', 'dt' => 10)


        );

        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );





        $join = "INNER JOIN `location` ON {$table}.code = location.code ";
        $whereAll = array("location.model='computer'");
        $group = "GROUP BY {$table}.code";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll, null, $group)
        );
    }


    public function computer_location_set_not()
    {
        $this->checkPermit('list_excel', 'excel');
        $this->adminHeaderController($this->langControl('excel'));

        require($this->render($this->folder, 'computer', 'location_set_not', 'php'));
        $this->adminFooterController();
    }

    public function processing_computer_location_set_not()
    {
        $this->checkPermit('list_excel', 'excel');
        $table = 'excel_computer';
        $tableJoin = '';
        $primaryKey = 'id';

        $columns = array(

            array('db' => $tableJoin . 'code', 'dt' => 0),
            array('db' => $tableJoin . 'quantity', 'dt' => 1),
            array('db' => $tableJoin . 'price_dollars', 'dt' => 2),
            array('db' => $tableJoin . 'price', 'dt' => 3),
            array('db' => $tableJoin . 'range1', 'dt' => 4),
            array('db' => $tableJoin . 'range2', 'dt' => 5),
            array('db' => $tableJoin . 'number_bill', 'dt' => 6),
            array(
                'db' => $tableJoin . 'date', 'dt' =>  7,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin . 'id',
                'dt'        => 8,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin . 'code',
                'dt'        => 9,
                'formatter' => function ($id, $row) {

                    if ($this->checkLocation('computer', $id)) {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('computer',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }
                }
            ),
            array('db' => $tableJoin . 'id', 'dt' => 10)


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

            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "{$table}.code  NOT IN  (SELECT location.code FROM location  WHERE     location.model='computer')")
        );


        // SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )

    }




    public function printing_supplies_location_set()
    {
        $this->checkPermit('list_excel', 'excel');
        $this->adminHeaderController($this->langControl('excel'));

        require($this->render($this->folder, 'printing_supplies', 'location_set', 'php'));
        $this->adminFooterController();
    }

    public function processing_printing_supplies_location_set()
    {
        $this->checkPermit('list_excel', 'excel');
        $table = 'excel_printing_supplies';
        $primaryKey = $table . '.id';
        $tableJoin = $table . '.';
        $columns = array(

            array('db' => $tableJoin . 'code', 'dt' => 0),
            array('db' => $tableJoin . 'quantity', 'dt' => 1),
            array('db' => $tableJoin . 'price_dollars', 'dt' => 2),
            array('db' => $tableJoin . 'price', 'dt' => 3),
            array('db' => $tableJoin . 'range1', 'dt' => 4),
            array('db' => $tableJoin . 'range2', 'dt' => 5),
            array('db' => $tableJoin . 'number_bill', 'dt' => 6),
            array(
                'db' => $tableJoin . 'date', 'dt' =>  7,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin . 'id',
                'dt'        => 8,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
<div style='text-align: center'>
	<button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
		<i class='fa fa-trash-o' aria-hidden='true'></i></i>
	</button>
</div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin . 'code',
                'dt'        => 9,
                'formatter' => function ($id, $row) {

                    if ($this->checkLocation('printing_supplies', $id)) {
                        return "*
<div style='text-align: center;font-size: 23px;'>
	<a onclick=getLocation('printing_supplies',$id,$row[1]) class='btn btn-success'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
</div> ";
                    }
                }
            ),
            array('db' => $tableJoin . 'id', 'dt' => 10)


        );

        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );





        $join = "INNER JOIN `location` ON {$table}.code = location.code ";
        $whereAll = array("location.model='printing_supplies'");
        $group = "GROUP BY {$table}.code";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll, null, $group)
        );
    }


    public function printing_supplies_location_set_not()
    {
        $this->checkPermit('list_excel', 'excel');
        $this->adminHeaderController($this->langControl('excel'));

        require($this->render($this->folder, 'printing_supplies', 'location_set_not', 'php'));
        $this->adminFooterController();
    }

    public function processing_printing_supplies_location_set_not()
    {
        $this->checkPermit('list_excel', 'excel');
        $table = 'excel_printing_supplies';
        $tableJoin = '';
        $primaryKey = 'id';

        $columns = array(

            array('db' => $tableJoin . 'code', 'dt' => 0),
            array('db' => $tableJoin . 'quantity', 'dt' => 1),
            array('db' => $tableJoin . 'price_dollars', 'dt' => 2),
            array('db' => $tableJoin . 'price', 'dt' => 3),
            array('db' => $tableJoin . 'range1', 'dt' => 4),
            array('db' => $tableJoin . 'range2', 'dt' => 5),
            array('db' => $tableJoin . 'number_bill', 'dt' => 6),
            array(
                'db' => $tableJoin . 'date', 'dt' =>  7,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin . 'id',
                'dt'        => 8,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
<div style='text-align: center'>
	<button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
		<i class='fa fa-trash-o' aria-hidden='true'></i></i>
	</button>
</div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin . 'code',
                'dt'        => 9,
                'formatter' => function ($id, $row) {

                    if ($this->checkLocation('printing_supplies', $id)) {
                        return "*
<div style='text-align: center;font-size: 23px;'>
	<a onclick=getLocation('printing_supplies',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
</div> ";
                    }
                }
            ),
            array('db' => $tableJoin . 'id', 'dt' => 10)


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

            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "{$table}.code  NOT IN  (SELECT location.code FROM location  WHERE     location.model='printing_supplies')")
        );


        // SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )

    }








    function checkLocation($model, $code, $color = null)
    {




        $table = null;
        /*       if ($model == 'mobile') {
                   $table = 'code';
               } else if ($model == 'accessories') {
                   $table = 'color_accessories';
               } else if ($model == 'product_savers') {
                   $table = 'product_savers';
               } else {
                   $table = 'code_' . $model;
               }*/

        $stmt = $this->db->prepare("SELECT *FROM  location WHERE `code`=? AND model = ? AND   `location` <> '' ");
        $stmt->execute(array($code, $model));
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    function set_location($model, $code, $quantity)
    {



        if ($this->handleLogin()) {



            $table = null;
            if ($model == 'mobile') {
                $table = 'code';
            } else if ($model == 'accessories') {
                $table = 'color_accessories';
            } else if ($model == 'product_savers') {
                $table = 'product_savers';
            } else {
                $table = 'code_' . $model;
            }
            $quantity_confirm = 0;
            $stmtlcm = $this->db->prepare("SELECT SUM(quantity) as  quantity FROM `location_confirm` WHERE `code`=? AND model = ? ");
            $stmtlcm->execute(array($code, $model));
            if ($stmtlcm->rowCount() > 0) {
                $resultlcm = $stmtlcm->fetch(PDO::FETCH_ASSOC);
                if ($resultlcm['quantity'] > 0) {
                    $quantity_confirm = $resultlcm['quantity'];
                }
            }

            $quantity_location = 0;
            $stmtlocation = $this->db->prepare("SELECT SUM(quantity) as  quantity FROM `location` WHERE `code`=? AND model = ? ");
            $stmtlocation->execute(array($code, $model));
            if ($stmtlocation->rowCount() > 0) {
                $resultlocation = $stmtlocation->fetch(PDO::FETCH_ASSOC);
                if ($resultlocation['quantity'] > 0) {
                    $quantity_location = $resultlocation['quantity'];
                }
            }


            $stmt = $this->db->prepare("SELECT *FROM `location` WHERE `code`=? AND model = ? ");
            $stmt->execute(array($code, $model));

            $location = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $location[] = $row;
            }


            require($this->render($this->folder, 'location', 'index', 'php'));
        }
    }

    function inst_location($model, $code)
    {

        if ($this->handleLogin()) {


            $location = $_POST['indexLocation']; /*  كمية */
            $oldLocationQuantity = $_POST['locationOldquantity']; /*  كمية */
            $this->AddToTraceByFunction($this->userid, 'excel', 'inst_location/' . $model . '/' . $code . '/' . $location . '/' . $oldLocationQuantity);
            $newLocationQuantity = 0;
            foreach ($location as $index => $qlocation) {
                $newLocationQuantity = (int)$newLocationQuantity + (int)$qlocation;
            }

            if ($model == 'mobile') {
                $excel = 'excel';
            } else {
                $excel = 'excel_' . $model;
            }
            $stmtExcel = $this->db->prepare("SELECT quantity FROM {$excel} WHERE code=? ");
            $stmtExcel->execute(array($code));
            if ($stmtExcel->rowCount() > 0) {
                $resultExcel = $stmtExcel->fetch(PDO::FETCH_ASSOC);
                if ($resultExcel['quantity'] >= $newLocationQuantity) {


                    if ($oldLocationQuantity == $newLocationQuantity) {
                        foreach ($location as $index => $qylocation) {


                            $stmtlocationInfo = $this->db->prepare('SELECT *FROM location WHERE code=? AND model=?  AND id=? ');
                            $stmtlocationInfo->execute(array($code, $model, $index));
                            $resultlocationInfo = $stmtlocationInfo->fetch(PDO::FETCH_ASSOC);

                            $stmtUplocation = $this->db->prepare('UPDATE location SET  quantity=? ,`date`=?,userid=?  WHERE id=? AND code =? AND  model=?');
                            $stmtUplocation->execute(array($qylocation, time(), $this->userid, $index, $code, $model));
                            if ($stmtUplocation->rowCount() > 0) {
                                $this->filter_location_tracking_quantity($code, $model, $resultlocationInfo['location'], $qylocation, '   توزيع الكمية على المواقع في Excel النظام   - رقم48', '+-');
                            } else {
                                $this->filter_location_error_quantity($code, $model, $resultlocationInfo['location'], $qylocation, '  توزيع الكمية على المواقع في Excel النظام  - رقم الخطا 48', '+-');
                            }
                        }
                    } else if ($newLocationQuantity > $oldLocationQuantity) {

                        $qConform = $newLocationQuantity - $oldLocationQuantity;


                        foreach ($location as $index => $qylocation) {


                            $stmtlocationInfo = $this->db->prepare('SELECT *FROM location WHERE code=? AND model=?  AND id=? ');
                            $stmtlocationInfo->execute(array($code, $model, $index));
                            $resultlocationInfo = $stmtlocationInfo->fetch(PDO::FETCH_ASSOC);

                            $stmtUplocation = $this->db->prepare('UPDATE location SET  quantity=? ,`date`=?,userid=?  WHERE id=? AND code =? AND  model=?');
                            $stmtUplocation->execute(array($qylocation, time(), $this->userid, $index, $code, $model));
                            if ($stmtUplocation->rowCount() > 0) {
                                $this->filter_location_tracking_quantity($code, $model, $resultlocationInfo['location'], $qylocation, '   توزيع الكمية على المواقع في Excel النظام   - رقم48', '+-');
                            } else {
                                $this->filter_location_error_quantity($code, $model, $resultlocationInfo['location'], $qylocation, '  توزيع الكمية على المواقع في Excel النظام  - رقم الخطا 48', '+-');
                            }
                        }


                        $stmtChCodeConform = $this->db->prepare("SELECT *FROM location_confirm WHERE code =? AND model=?");
                        $stmtChCodeConform->execute(array($code, $model));
                        if ($stmtChCodeConform->rowCount() > 0) {
                            $stmtExcel_conform = $this->db->prepare("UPDATE location_confirm SET  quantity=quantity-{$qConform} ,`date`=?,userid=?  WHERE code =? AND  model=?");
                            $stmtExcel_conform->execute(array(time(), $this->userid, $code, $model));
                            if ($stmtExcel_conform->rowCount() <= 0) {
                                $this->filter_error_quantity($code, $model, $qConform, '  توزيع الكمية على المواقع في Excel النظام    - رقم الخطا 49');
                            }
                        } else {
                            $stmtExcel_conform = $this->db->prepare("INSERT INTO  location_confirm (quantity,code,model,date,userid)  values (?,?,?,?,?)");
                            $stmtExcel_conform->execute(array($qConform, $code, $model, time(), $this->userid));
                            if ($stmtExcel_conform->rowCount() <= 0) {
                                $this->filter_error_quantity($code, $model, $qConform, '  توزيع الكمية على المواقع في Excel النظام    - رقم الخطا 50');
                            }
                        }


                        $stmtExcel_conform = $this->db->prepare("UPDATE location_confirm SET  quantity=0 ,`date`=?,userid=?  WHERE code =? AND  model=? AND quantity < 0 ");
                        $stmtExcel_conform->execute(array(time(), $this->userid, $code, $model));
                    } else if ($newLocationQuantity < $oldLocationQuantity) {




                        $qConform = $oldLocationQuantity - $newLocationQuantity;


                        foreach ($location as $index => $qylocation) {


                            $stmtlocationInfo = $this->db->prepare('SELECT *FROM location WHERE code=? AND model=?  AND id=? ');
                            $stmtlocationInfo->execute(array($code, $model, $index));
                            $resultlocationInfo = $stmtlocationInfo->fetch(PDO::FETCH_ASSOC);

                            $stmtUplocation = $this->db->prepare('UPDATE location SET  quantity=? ,`date`=?,userid=?  WHERE id=? AND code =? AND  model=?');
                            $stmtUplocation->execute(array($qylocation, time(), $this->userid, $index, $code, $model));
                            if ($stmtUplocation->rowCount() > 0) {
                                $this->filter_location_tracking_quantity($code, $model, $resultlocationInfo['location'], $qylocation, '   توزيع الكمية على المواقع في Excel النظام   - رقم48', '+-');
                            } else {
                                $this->filter_location_error_quantity($code, $model, $resultlocationInfo['location'], $qylocation, '  توزيع الكمية على المواقع في Excel النظام  - رقم الخطا 48', '+-');
                            }
                        }


                        $stmtChCodeConform = $this->db->prepare("SELECT *FROM location_confirm WHERE code =? AND model=?");
                        $stmtChCodeConform->execute(array($code, $model));
                        if ($stmtChCodeConform->rowCount() > 0) {
                            $stmtExcel_conform = $this->db->prepare("UPDATE location_confirm SET  quantity=quantity+{$qConform} ,`date`=?,userid=?  WHERE code =? AND  model=?");
                            $stmtExcel_conform->execute(array(time(), $this->userid, $code, $model));
                            if ($stmtExcel_conform->rowCount() <= 0) {
                                $this->filter_error_quantity($code, $model, $qConform, '  توزيع الكمية على المواقع في Excel النظام    - رقم الخطا 49');
                            }
                        } else {
                            $stmtExcel_conform = $this->db->prepare("INSERT INTO  location_confirm (quantity,code,model,date,userid)  values (?,?,?,?,?)");
                            $stmtExcel_conform->execute(array($qConform, $code, $model, time(), $this->userid));
                            if ($stmtExcel_conform->rowCount() <= 0) {
                                $this->filter_error_quantity($code, $model, $qConform, '  توزيع الكمية على المواقع في Excel النظام    - رقم الخطا 50');
                            }
                        }


                        $stmtExcel_conform = $this->db->prepare("UPDATE location_confirm SET  quantity=0 ,`date`=?,userid=?  WHERE code =? AND  model=? AND quantity < 0 ");
                        $stmtExcel_conform->execute(array(time(), $this->userid, $code, $model));
                    }
                } else {
                    echo '-q';
                }
            }
        }
    }





    function lct($model)
    {
        if ($this->handleLogin()) {

            $code = $_POST['code'];
            $location = $_POST['location'];
            $q = 0;
            if (is_numeric($_POST['q'])) {
                $q = $_POST['q'];
            }
            $this->AddToTraceByFunction($this->userid, 'excel', 'lct/' . $model . '/' . $code . '/' . $location . '/' . $q);


            if ($model == 'mobile') {
                $excel = 'excel';
            } else {
                $excel = 'excel_' . $model;
            }

            $stmtx1 = $this->db->prepare("SELECT *FROM `{$excel}` WHERE `code`=?  ");
            $stmtx1->execute(array($code));
            if ($stmtx1->rowCount() > 0) {

                $stmtx2 = $this->db->prepare("SELECT *FROM `{$excel}` WHERE `quantity` >= {$q} AND `code`=? ");
                $stmtx2->execute(array($code));
                if ($stmtx2->rowCount() > 0) {


                    $stmtLocation = $this->db->prepare("SELECT *FROM `location` WHERE code=? AND location= ?  AND model=? ");
                    $stmtLocation->execute(array($code, $location, $model));
                    if ($stmtLocation->rowCount() > 0) {
                        $stmt = $this->db->prepare("UPDATE   `location` SET  quantity=? ,`date`=? WHERE code=? AND location=? AND model=?");
                        $stmt->execute(array($q, time(), $code, $location, $model));
                        if ($stmt->rowCount() > 0) {
                            echo '1';
                        }
                    } else {
                        $stmt = $this->db->prepare("INSERT INTO `location` (code, location,quantity, model) VALUE (?,?,?,?) ");
                        $stmt->execute(array($code, $location, $q, $model));
                        if ($stmt->rowCount() > 0) {
                            echo '1';
                        }
                    }
                } else {
                    echo 'q'; //not found quantity
                }
            } else {
                echo 'c'; //not found code
            }
        }
    }




    function lctacc($model)
    {
        if ($this->handleLogin()) {


            $code = $_POST['code'];
            $color = $_POST['color'];
            $location = $_POST['location'];
            $q = 0;
            if (is_numeric($_POST['q'])) {
                $q = $_POST['q'];
            }
            $this->AddToTraceByFunction($this->userid, 'excel', 'lctacc/' . $model . '/' . $code . '/' . $color . '/' . $location . '/' . $q);

            $stmtx1 = $this->db->prepare("SELECT *FROM `excel_accessories` WHERE `code`=? AND color=?");
            $stmtx1->execute(array($code, $color));
            if ($stmtx1->rowCount() > 0) {

                $stmtx2 = $this->db->prepare("SELECT *FROM `excel_accessories` WHERE `quantity` >= {$q} AND `code`=? AND color=?");
                $stmtx2->execute(array($code, $color));
                if ($stmtx2->rowCount() > 0) {


                    $stmtLocation = $this->db->prepare("SELECT *FROM `location` WHERE code=? AND location= ?  AND model=? AND color=?");
                    $stmtLocation->execute(array($code, $location, $model, $color));
                    if ($stmtLocation->rowCount() > 0) {
                        $stmt = $this->db->prepare("UPDATE   `location` SET  quantity=? ,`date`=? WHERE code=? AND location=? AND model=?  AND color=?");
                        $stmt->execute(array($q, time(), $code, $location, $model, $color));
                        if ($stmt->rowCount() > 0) {
                            echo '1';
                        }
                    } else {
                        $stmt = $this->db->prepare("INSERT INTO `location` (code, location,quantity, model,color) VALUE (?,?,?,?,?) ");
                        $stmt->execute(array($code, $location, $q, $model, $color));
                        if ($stmt->rowCount() > 0) {
                            echo '1';
                        }
                    }
                } else {
                    echo 'q'; //not found quantity
                }
            } else {
                echo 'c'; //not found code
            }
        }
    }






    function type_add($t)
    {
        if ($t == 'new') {
            return 'حذف واستبدال';
        } else  if ($t == 'old') {
            return 'تراكمي';
        } else {
            return $t;
        }
    }

    public function archives($model)
    {
        $this->checkPermit('archives_' . $model, 'excel');
        $this->adminHeaderController($this->langControl('archives_' . $model));


        $date = null;
        $todate = null;

        $from_date_stm = null;
        $to_date_stm = null;
        $number_bill = null;

        $sumCode = 0;
        $sumqu = 0;
        $amount = 0;
        $amountD = 0;

        if (isset($_GET['date'])) {
            $date = $_GET['date'];
        }

        if (isset($_GET['todate'])) {
            $todate = $_GET['todate'];
        }

        if (isset($_GET['number_bill'])) {
            $number_bill = $_GET['number_bill'];
        }


        if ($date && $todate &&  $number_bill) {


            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);


            $stmtcode = $this->db->prepare("SELECT count(id) as count FROM uesr_add_excel WHERE number_bill=? AND   model=? AND  date BETWEEN  ? AND  ? AND code REGEXP '^[0-9]+$'");
            $stmtcode->execute(array($model, $number_bill, $from_date_stm, $to_date_stm));
            $sumCode = $stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

            $stmtqq = $this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE number_bill=? AND   model=? AND  date BETWEEN  ? AND  ?   AND quantity REGEXP '^[0-9]+$' ");
            $stmtqq->execute(array($model, $number_bill, $from_date_stm, $to_date_stm));
            $sumqu = $stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


            $stmtmony = $this->db->prepare("SELECT *FROM uesr_add_excel WHERE number_bill=? AND model=? AND  date BETWEEN  ? AND  ? ");
            $stmtmony->execute(array($model, $number_bill, $from_date_stm, $to_date_stm));
            $amount = 0;
            while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)) {
                if (is_numeric(trim($row['price']))) {
                    $s = (int)$row['quantity'] * (float)trim($row['price']);
                    $amount = (int)$amount + (int)$s;
                }
            }
        } else if ($date  && $todate) {


            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);


            $stmtcode = $this->db->prepare("SELECT count(id) as count FROM uesr_add_excel WHERE    model=?  AND  date BETWEEN  ? AND  ? AND code REGEXP '^[0-9]+$'");
            $stmtcode->execute(array($model, $from_date_stm, $to_date_stm));
            $sumCode = $stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

            $stmtqq = $this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE        model=?  AND  date BETWEEN  ? AND  ?   AND quantity REGEXP '^[0-9]+$' ");
            $stmtqq->execute(array($model, $from_date_stm, $to_date_stm));
            $sumqu = $stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


            $stmtmony = $this->db->prepare("SELECT *FROM uesr_add_excel WHERE   model=?  AND  date BETWEEN  ? AND  ? ");
            $stmtmony->execute(array($model, $from_date_stm, $to_date_stm));
            $amount = 0;
            while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)) {
                if (is_numeric(trim($row['price']))) {
                    $s = (int)$row['quantity'] * (float)trim($row['price']);
                    $amount = (int)$amount + (int)$s;
                }
            }
        } else {



            $stmtcode = $this->db->prepare("SELECT count(code) as count FROM uesr_add_excel WHERE model=?   AND code REGEXP '^[0-9]+$' ");
            $stmtcode->execute(array($model));
            $sumCode = $stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

            $stmtqq = $this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE      model=?    AND quantity REGEXP '^[0-9]+$' ");
            $stmtqq->execute(array($model));
            $sumqu = $stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


            $stmtmony = $this->db->prepare("SELECT *FROM uesr_add_excel WHERE  model=?   ");
            $stmtmony->execute(array($model));
            $amount = 0;
            while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)) {
                if (is_numeric(trim($row['price']))) {
                    $s = (int)$row['quantity'] * (float)trim($row['price']);
                    $amount = (int)$amount + (int)$s;
                }
            }
        }
        $amountD = $this->price_dollarsAdmin($amount);


        require($this->render($this->folder, 'html', 'archives_mobile', 'php'));
        $this->adminFooterController();
    }

    public function processing_archives($model, $from_date_stm = null, $to_date_stm = null, $number_bill = null)
    {




        $this->checkPermit('archives_' . $model, 'excel');
        $table = 'uesr_add_excel';
        $primaryKey = 'id';

        $columns = array(

            array('db' => 'code', 'dt' => 0),
            array('db' => 'number_bill', 'dt' => 1),
            array('db' => 'quantity', 'dt' => 2),
            array('db' => 'price', 'dt' => 3),
            array('db' => 'wholesale_price', 'dt' => 4),
            array('db' => 'wholesale_price2', 'dt' => 5),
            array('db' => 'cost_price', 'dt' => 6),
            array(
                'db' => 'type', 'dt' =>  7,
                'formatter' => function ($d, $row) {
                    return $this->type_add($d);
                }
            ),

            array(
                'db' => 'date', 'dt' => 8,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i:s A', $d);
                }
            ),


            array(
                'db'        => 'userid',
                'dt'        => 9,
                'formatter' => function ($id, $row) {

                    return $this->UserInfo($id);
                }
            ),
            array('db' => 'id', 'dt' => 10)


        );

        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        if (!empty($from_date_stm) && !empty($to_date_stm) && !empty($number_bill)) {
            echo json_encode(

                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "number_bill={$number_bill} AND `date` BETWEEN {$from_date_stm} AND {$to_date_stm} AND model='{$model}' ")
            );
        } else if (!empty($from_date_stm) && !empty($to_date_stm)) {
            echo json_encode(

                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, " `date` BETWEEN {$from_date_stm} AND {$to_date_stm} AND model='{$model}' ")
            );
        } else {
            echo json_encode(

                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "model='{$model}'")
            );
        }
    }

    public function all_archives()
    {
        $this->checkPermit('all_archives', 'excel');
        $this->adminHeaderController($this->langControl('all_archives'));


        $date = null;
        $todate = null;

        $from_date_stm = null;
        $to_date_stm = null;
        $number_bill = null;

        $sumCode = 0;
        $sumqu = 0;
        $amount = 0;
        $amountD = 0;

        if (isset($_GET['date'])) {
            $date = $_GET['date'];
        }

        if (isset($_GET['todate'])) {
            $todate = $_GET['todate'];
        }

        if (isset($_GET['number_bill'])) {
            $number_bill = $_GET['number_bill'];
        }


        if ($date && $todate &&  $number_bill) {


            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);


            $stmtcode = $this->db->prepare("SELECT count(id) as count FROM uesr_add_excel WHERE number_bill=? AND   date BETWEEN  ? AND  ? AND code REGEXP '^[0-9]+$'");
            $stmtcode->execute(array($number_bill, $from_date_stm, $to_date_stm));
            $sumCode = $stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

            $stmtqq = $this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE number_bill=? AND    date BETWEEN  ? AND  ?   AND quantity REGEXP '^[0-9]+$' ");
            $stmtqq->execute(array($number_bill, $from_date_stm, $to_date_stm));
            $sumqu = $stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


            $stmtmony = $this->db->prepare("SELECT *FROM uesr_add_excel WHERE number_bill=? AND   date BETWEEN  ? AND  ? ");
            $stmtmony->execute(array($number_bill, $from_date_stm, $to_date_stm));
            $amount = 0;
            while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)) {
                if (is_numeric(trim($row['price']))) {
                    $s = (int)$row['quantity'] * (float)trim($row['price']);
                    $amount = (int)$amount + (int)$s;
                }
            }
        } else if ($date  && $todate) {


            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);


            $stmtcode = $this->db->prepare("SELECT count(id) as count FROM uesr_add_excel WHERE    date BETWEEN  ? AND  ? AND code REGEXP '^[0-9]+$'");
            $stmtcode->execute(array($from_date_stm, $to_date_stm));
            $sumCode = $stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

            $stmtqq = $this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE       date BETWEEN  ? AND  ?   AND quantity REGEXP '^[0-9]+$' ");
            $stmtqq->execute(array($from_date_stm, $to_date_stm));
            $sumqu = $stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


            $stmtmony = $this->db->prepare("SELECT *FROM uesr_add_excel WHERE   date BETWEEN  ? AND  ? ");
            $stmtmony->execute(array($from_date_stm, $to_date_stm));
            $amount = 0;
            while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)) {
                if (is_numeric(trim($row['price']))) {
                    $s = (int)$row['quantity'] * (float)trim($row['price']);
                    $amount = (int)$amount + (int)$s;
                }
            }
        } else {



            $stmtcode = $this->db->prepare("SELECT count(code) as count FROM uesr_add_excel WHERE  code REGEXP '^[0-9]+$' ");
            $stmtcode->execute();
            $sumCode = $stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

            $stmtqq = $this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE  quantity REGEXP '^[0-9]+$' ");
            $stmtqq->execute();
            $sumqu = $stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


            $stmtmony = $this->db->prepare("SELECT *FROM uesr_add_excel   ");
            $stmtmony->execute();
            $amount = 0;
            while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)) {
                if (is_numeric(trim($row['price']))) {
                    $s = (int)$row['quantity'] * (float)trim($row['price']);
                    $amount = (int)$amount + (int)$s;
                }
            }
        }
        $amountD = $this->price_dollarsAdmin($amount);


        require($this->render($this->folder, 'html', 'all_archives', 'php'));
        $this->adminFooterController();
    }

    public function processing_all_archives($from_date_stm = null, $to_date_stm = null, $number_bill = null)
    {




        $this->checkPermit('all_archives', 'excel');
        $table = 'uesr_add_excel';
        $primaryKey = 'id';

        $columns = array(

            array('db' => 'model', 'dt' => 0),
            array('db' => 'code', 'dt' => 1),
            array('db' => 'number_bill', 'dt' => 2),
            array('db' => 'quantity', 'dt' => 3),
            array('db' => 'price', 'dt' => 4),
            array(
                'db' => 'type', 'dt' =>  5,
                'formatter' => function ($d, $row) {
                    return $this->type_add($d);
                }
            ),

            array(
                'db' => 'date', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),


            array(
                'db'        => 'userid',
                'dt'        => 7,
                'formatter' => function ($id, $row) {

                    return $this->UserInfo($id);
                }
            ),
            array('db' => 'id', 'dt' => 8)


        );

        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        if (!empty($from_date_stm) && !empty($to_date_stm) && !empty($number_bill)) {
            echo json_encode(

                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "number_bill={$number_bill} AND `date` BETWEEN {$from_date_stm} AND {$to_date_stm}   ")
            );
        } else if (!empty($from_date_stm) && !empty($to_date_stm)) {
            echo json_encode(

                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, " `date` BETWEEN {$from_date_stm} AND {$to_date_stm}   ")
            );
        } else {
            echo json_encode(

                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
            );
        }
    }



    function code_not_upload($model)
    {

        $this->checkPermit('code_not_upload', 'excel');
        $this->adminHeaderController($this->langControl($model));


        $date = null;
        $todate = null;

        $from_date_stm = null;
        $to_date_stm = null;


        if (isset($_GET['date'])) {
            $date = $_GET['date'];
        }

        if (isset($_GET['todate'])) {
            $todate = $_GET['todate'];
        }


        require($this->render($this->folder, 'html', 'code_not_upload', 'php'));
        $this->adminFooterController();
    }


    public function processing_code_not_upload($model, $from_date_stm = null, $to_date_stm = null)
    {


        $this->checkPermit('code_not_upload', 'excel');
        $table = 'excel_filter';
        $primaryKey = 'id';

        $columns = array(

            array('db' => 'model', 'dt' => 0),
            array('db' => 'code', 'dt' => 1),
            array('db' => 'quantity', 'dt' => 2),
            array('db' => 'price_dollars', 'dt' => 3),

            array(
                'db' => 'date', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => 'userid',
                'dt'        => 5,
                'formatter' => function ($id, $row) {

                    return $this->UserInfo($id);
                }
            ),
            array('db' => 'id', 'dt' => 6)


        );

        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        if (!empty($from_date_stm) && !empty($to_date_stm)) {
            echo json_encode(

                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "model ='{$model}' AND `date` BETWEEN {$from_date_stm} AND {$to_date_stm}   ")
            );
        } else {
            echo json_encode(

                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "model ='{$model}'")
            );
        }
    }



    function delete_not_upload_code($model)
    {
        if ($this->handleLogin()) {


            $stmt = $this->db->prepare("DELETE  FROM `excel_filter` WHERE model =?");
            $stmt->execute(array($model));
            if ($stmt->rowCount() > 0) {
                echo  'true';
            }
        }
    }
}
