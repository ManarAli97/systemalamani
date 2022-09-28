<?php

class location_confirm extends Controller
{


    function __construct()
    {
        parent::__construct();
        $this->table = 'location_confirm';
    }


    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
           `id` int(11)  NOT NULL AUTO_INCREMENT ,
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `price_dollars` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `quantity` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        return $this->db->cht(array($this->table));
    }

    /*
        function update($code, $q, $model, $price, $type = 0, $color = '')
        {


            $q = (int)trim($q);
            if ($type == 1) {
                $stmt = $this->db->prepare("SELECT *FROM location_confirm WHERE code=? AND model=? ");
                $stmt->execute(array($code, $model));
                if ($stmt->rowCount() > 0) {
                    $stmtUpdate = $this->db->prepare("UPDATE location_confirm SET quantity=  quantity + {$q} ,date=? ,location=''  WHERE  code=? AND model=?  ");
                    $stmtUpdate->execute(array(time(), $code, $model));
                } else {
                    $stmtInsert = $this->db->prepare("INSERT INTO  location_confirm  (code, price_dollars, quantity, model, date)  values  (?,?,?,?,?) ");
                    $stmtInsert->execute(array($code, $price, $q, $model, time()));
                }
            } else {
                $stmt = $this->db->prepare("SELECT *FROM location_confirm WHERE code=? AND model=? ");
                $stmt->execute(array($code, $model));
                if ($stmt->rowCount() > 0) {
                    $stmtUpdate = $this->db->prepare("UPDATE location_confirm SET quantity = ?  ,date=?,location=''  WHERE  code=? AND model=?  ");
                    $stmtUpdate->execute(array($q, time(), $code, $model));
                } else {
                    $stmtInsert = $this->db->prepare("INSERT INTO  location_confirm  (code, price_dollars, quantity, model, date)  values  (?,?,?,?,?) ");
                    $stmtInsert->execute(array($code, $price, $q, $model, time()));
                }
            }


        }

    **/
    function view($model)
    {

        $this->checkPermit($model, $this->folder);
        $this->adminHeaderController($this->langControl($model));

        require($this->render($this->folder, 'html', 'index', 'php'));
        $this->adminFooterController();
    }


    function remove_all()
    {
        if ($this->handleLogin()) {


            $model = $_GET['model'];
            $this->AddToTraceByFunction($this->userid, 'location_confirm', 'remove_all/' . $model);
            $this->checkPermit('delete_all_' . $model, $this->folder);

            if ($model == 'mobile') {
                $excel = 'excel';
            } else {
                $excel = 'excel_' . $model;
            }

            $stmtconfirm = $this->db->prepare("SELECT code,quantity FROM location_confirm WHERE model=? ");
            $stmtconfirm->execute(array($model));
            if ($stmtconfirm->rowCount() > 0) {
                while ($row = $stmtconfirm->fetch(PDO::FETCH_ASSOC)) {

                    $q = (int)$row['quantity'];

                    $stmtCode = $this->db->prepare("UPDATE   {$excel} SET quantity=quantity-{$q} WHERE code = ?  ");
                    $stmtCode->execute(array($row['code']));

                    $stmtC = $this->db->prepare("DELETE FROM  location_confirm WHERE code =? AND model=?");
                    $stmtC->execute(array(trim($row['code']), $model));
                }

                echo 'true';
            }
        }
    }


    function delete_code($id)
    {
        if ($this->handleLogin()) {


            $this->checkPermit('delete', $this->folder);
            $this->AddToTraceByFunction($this->userid, 'location_confirm', 'delete_code/' . $id);


            $stmtconfirm = $this->db->prepare("SELECT code,model,quantity FROM location_confirm WHERE id=? ");
            $stmtconfirm->execute(array($id));
            if ($stmtconfirm->rowCount() > 0) {
                $row = $stmtconfirm->fetch(PDO::FETCH_ASSOC);



                $model = $row['model'];
                if ($model == 'mobile') {
                    $excel = 'excel';
                } else {
                    $excel = 'excel_' . $model;
                }

                $q = (int)$row['quantity'];

                $stmtCode = $this->db->prepare("UPDATE   {$excel} SET quantity=quantity-{$q} WHERE code = ?  ");
                $stmtCode->execute(array($row['code']));
                $this->Add_to_sync_schedule($row['code'], $model, 'quantity_adjustment', ' ', ' controllers\location_confirm\location_confirm.php 143 حذف مواد بانتضار تاكيد مواقعها' . $this->UserInfo($this->userid));
                $stmtC = $this->db->prepare("DELETE FROM  location_confirm WHERE code =? AND model=?");
                $stmtC->execute(array(trim($row['code']), $model));

                echo 'true';
            }
        }
    }


    public function processing($model)
    {


        $table = 'location_confirm';
        $primaryKey = $table . '.id';


        if ($model == 'mobile') {
            $code = 'code';
            $color = 'color';
        } else {
            $code = 'code_' . $model;
            $color = 'color_' . $model;
        }
        if ($model == 'savers') {
            $model = 'product_savers';
        }

        $columns = array(
            array('db' => $table . '.model', 'dt' => 0),
            array('db' => $model . '.title', 'dt' => 1),
            array('db' => $table . '.code', 'dt' => 2),
            array('db' => $table . '.price_dollars', 'dt' => 3),
            array('db' => $table . '.quantity', 'dt' => 4),
            array(
                'db' => $table . '.date', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i:s A', $d);
                }

            ),


            array(
                'db' => $table . '.id',
                'dt' => 6,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[2]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),


            array('db' => $table . '.id', 'dt' => 7),
        );

        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        if ($model == 'product_savers') {
            $join = "
            inner JOIN product_savers ON  product_savers.code={$table}.code 
             ";
            $model = 'savers';
        } else if ($model == 'accessories') {
            $join = "
         
            inner JOIN {$color} ON  {$color}.code={$table}.code 
            inner JOIN {$model} ON {$model}.id={$color}.id_item 
            ";
        } else {
            $join = "
        
            inner JOIN {$code} ON  {$code}.code={$table}.code 
            inner JOIN {$color} ON {$color}.id= {$code}.id_color 
            inner JOIN {$model} ON {$model}.id={$color}.id_item   
            ";
        }
        //inner  JOIN {$color} ON {$color}.id= {$code}.id_color
        //inner JOIN {$model} ON {$model}.id={$color}.id_item
        $whereAll = array("{$table}.model='{$model}' ", " {$table}.`quantity` > 0", " {$table}.`location` = ''");
        echo json_encode(
            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll, null)
        );
    }


    function view_acc_and_cover($model)
    {

        $this->checkPermit($model, $this->folder);
        $this->adminHeaderController($this->langControl($model));

        require($this->render($this->folder, 'html', 'accessories_and_cover', 'php'));
        $this->adminFooterController();
    }




    function add($model)
    {

        $class1 = '';
        $class2 = 'show active';

        $this->checkPermit('add', $this->folder);
        $this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid, 'location_confirm', 'add/' . $model);
        if ($model == 'mobile') {
            $excel = 'excel';
        } else {
            $excel = 'excel_' . $model;
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

                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray(
                            'A' . $row . ':' . $highestColumn . $row,
                            NULL,
                            TRUE,
                            TRUE
                        );


                        if (count($rowData[0]) >= 3) {

                            $q = (int)str_replace('&gt;', '', trim($rowData[0][2]));
                            $code_excel = trim(strip_tags($rowData[0][0]));


                            $stmtCheckCodeExcel = $this->db->prepare("SELECT * FROM    {$excel}   WHERE  code=?   AND quantity  >= $q ");
                            $stmtCheckCodeExcel->execute(array(trim($code_excel)));
                            if ($stmtCheckCodeExcel->rowCount() > 0) {

                                $stmtconfirm_found = $this->db->prepare("SELECT * FROM location_confirm INNER JOIN {$excel} ON {$excel}.code=location_confirm.code WHERE  location_confirm.code=?  AND {$excel}.code=?  AND location_confirm.model=?  ");
                                $stmtconfirm_found->execute(array(trim($code_excel), trim($code_excel), $model));
                                if ($stmtconfirm_found->rowCount() > 0) {


                                    $stmt_backup_location = $this->db->prepare("INSERT INTO  location_backup  (code,location,quantity,model,userid,`date_noraml`,`date`,`type`) values (?,?,?,?,?,?,?,?) ");
                                    $stmt_backup_location->execute(array(trim($code_excel), trim($rowData[0][1]), $rowData[0][2], $model, $this->userid, date('Y-m-d h-i a'), time(), 'حذف واستبدال'));

                                    $stmtc = $this->db->prepare("SELECT *FROM location WHERE code=? AND location=? AND model=? ");
                                    $stmtc->execute(array(trim($code_excel), trim($rowData[0][1]), $model));
                                    if ($stmtc->rowCount() > 0) {


                                        $over = 0;
                                        $stmtconfirm = $this->db->prepare("SELECT * FROM location_confirm WHERE  code=? AND model=? AND quantity < {$q}");
                                        $stmtconfirm->execute(array($code_excel, $model));
                                        if ($stmtconfirm->rowCount() > 0) {
                                            $result = $stmtconfirm->fetch(PDO::FETCH_ASSOC);
                                            if ($result['quantity'] > 0) {
                                                $over = $q - $result['quantity'];
                                                $q = $result['quantity'];

                                                $stmtup = $this->db->prepare("UPDATE   location SET  `quantity` = ? ,over_quantity=?,userid=?,`date`=? WHERE code=? AND location=? AND model=?");
                                                $stmtup->execute(array($q, $over, $this->userid, time(), trim($code_excel), trim($rowData[0][1]), $model));

                                                if ($stmtup->rowCount() > 0) {

                                                    $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity`- $q ,userid=?,`date`=? WHERE code=? AND model=? ");
                                                    $stmtcon->execute(array($this->userid, time(), trim($code_excel), $model));
                                                    if ($stmtcon->rowCount() <= 0) {
                                                        $this->filter_error_quantity(trim($code_excel), $model, $q, '  اضافة كميات للمواقع بستخدام الاكسيل   - رقم الخطا 15');
                                                    }

                                                    $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كميات للمواقع بستخدام الاكسيل - رقم16', '+');
                                                } else {
                                                    $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كميات للمواقع بستخدام الاكسيل - رقم الخطا 16', '+');
                                                }
                                            } else {

                                                $stmtup = $this->db->prepare("UPDATE   location SET  over_quantity=? ,userid=?,`date`=? WHERE code=? AND location=? AND model=?");
                                                $stmtup->execute(array($q, $this->userid, time(),  trim($code_excel), trim($rowData[0][1]), $model));
                                                if ($stmtup->rowCount() > 0) {

                                                    $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =0,userid=?,`date`=?  WHERE code=? AND model=? ");
                                                    $stmtcon->execute(array($this->userid, time(), trim($code_excel), $model));
                                                    if ($stmtcon->rowCount() <= 0) {
                                                        $this->filter_error_quantity(trim($code_excel), $model, $q, ' اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع   - رقم الخطا 30');
                                                    }

                                                    $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع   - رقم28', '+');
                                                } else {
                                                    $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع  - رقم الخطا 28', '+');
                                                }
                                            }
                                        } else {
                                            $stmt = $this->db->prepare("UPDATE   location SET  `quantity` = ? ,over_quantity=?,userid=?,`date`=? WHERE code=? AND location=? AND model=?");
                                            $stmt->execute(array($q, $over, $this->userid, time() + 1, trim($code_excel), trim($rowData[0][1]), $model));
                                            if ($stmt->rowCount() > 0) {

                                                $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity`- $q ,userid=?,`date`=?  WHERE code=? AND model=? ");
                                                $stmtcon->execute(array($this->userid, time(), trim($code_excel), $model));
                                                if ($stmtcon->rowCount() <= 0) {
                                                    $this->filter_error_quantity(trim($code_excel), $model, $q, ' اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع   - رقم الخطا 31');
                                                }

                                                $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كميات للمواقع بستخدام الاكسيل - رقم17', '+');
                                            } else {
                                                $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كميات للمواقع بستخدام الاكسيل - رقم الخطا 17', '+');
                                            }
                                        }
                                    } else {

                                        if ($model != 'accessories' && $model != 'savers') {


                                            $location = array();
                                            $stmt_locat = $this->db->prepare("SELECT location,sequence FROM `location_model`  WHERE  `model` =?  ");
                                            $stmt_locat->execute(array($model));
                                            while ($rowx = $stmt_locat->fetch(PDO::FETCH_ASSOC)) {
                                                $location[] = $rowx;
                                            }

                                            if (!empty($location)) {
                                                foreach ($location as $in_location) {
                                                    $stmtc = $this->db->prepare("SELECT *FROM location WHERE code=? AND location=? AND model=? ");
                                                    $stmtc->execute(array(trim($code_excel), $in_location['location'], $model));

                                                    if ($stmtc->rowCount() <= 0) {
                                                        $stmt = $this->db->prepare("INSERT INTO  location  (code,location,model,sequence,userid,`date`) values (?,?,?,?,?,?) ");
                                                        $stmt->execute(array(trim($code_excel), $in_location['location'], $model, $in_location['sequence'], $this->userid, time()));
                                                    }
                                                }

                                                $over = 0;
                                                $stmtconfirm = $this->db->prepare("SELECT *FROM location_confirm WHERE  code=? AND model=? AND quantity < {$q} ");
                                                $stmtconfirm->execute(array($code_excel, $model));
                                                if ($stmtconfirm->rowCount() > 0) {
                                                    $result = $stmtconfirm->fetch(PDO::FETCH_ASSOC);
                                                    if ($result['quantity'] > 0) {
                                                        $over = $q - $result['quantity'];
                                                        $q = $result['quantity'];

                                                        $stmtup = $this->db->prepare("UPDATE   location SET  `quantity` = ? ,over_quantity=?,userid=?,`date`=? WHERE code=? AND location=? AND model=?");
                                                        $stmtup->execute(array($q, $over, $this->userid, time(), trim($code_excel), trim($rowData[0][1]), $model));
                                                        if ($stmtup->rowCount() > 0) {

                                                            $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity`- $q,userid=?,`date`=?  WHERE code=? AND model=? ");
                                                            $stmtcon->execute(array($this->userid, time(), trim($code_excel), $model));
                                                            if ($stmtcon->rowCount() <= 0) {
                                                                $this->filter_error_quantity(trim($code_excel), $model, $q, '  اضافة كميات للمواقع بستخدام الاكسيل   - رقم الخطا 18');
                                                            }

                                                            $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كميات للمواقع بستخدام الاكسيل - رقم18', '+');
                                                        } else {
                                                            $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كميات للمواقع بستخدام الاكسيل - رقم الخطا 18', '+');
                                                        }
                                                    } else {


                                                        $stmtup = $this->db->prepare("UPDATE   location SET  over_quantity=? ,userid=?,`date`=? WHERE code=? AND location=? AND model=?");
                                                        $stmtup->execute(array($q, $this->userid, time(),  trim($code_excel), trim($rowData[0][1]), $model));
                                                        if ($stmtup->rowCount() > 0) {

                                                            $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =0,userid=?,`date`=?  WHERE code=? AND model=? ");
                                                            $stmtcon->execute(array($this->userid, time(), trim($code_excel), $model));
                                                            if ($stmtcon->rowCount() <= 0) {
                                                                $this->filter_error_quantity(trim($code_excel), $model, $q, ' اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع   - رقم الخطا 32');
                                                            }

                                                            $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع   - رقم29', '+');
                                                        } else {
                                                            $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع  - رقم الخطا 29', '+');
                                                        }
                                                    }
                                                } else {
                                                    $stmt = $this->db->prepare("UPDATE   location SET  `quantity` = ? ,over_quantity=?,userid=?,`date`=? WHERE code=? AND location=? AND model=?");
                                                    $stmt->execute(array($q, $over, $this->userid, time() + 1, trim($code_excel), trim($rowData[0][1]), $model));
                                                    if ($stmt->rowCount() > 0) {

                                                        $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity`- $q ,userid=?,`date`=? WHERE code=? AND model=? ");
                                                        $stmtcon->execute(array($this->userid, time(), trim($code_excel), $model));
                                                        if ($stmtcon->rowCount() <= 0) {
                                                            $this->filter_error_quantity(trim($code_excel), $model, $q, '  اضافة كميات للمواقع بستخدام الاكسيل   - رقم الخطا 19');
                                                        }
                                                        $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كميات للمواقع بستخدام الاكسيل - رقم19', '+');
                                                    } else {
                                                        $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كميات للمواقع بستخدام الاكسيل - رقم الخطا 19', '+');
                                                    }
                                                }
                                            }
                                        } else {

                                            $stmt_locat = $this->db->prepare("SELECT  * FROM `location_model`  WHERE location=? AND `model` =? LIMIT 1 ");
                                            $stmt_locat->execute(array($rowData[0][1], $model));
                                            if ($stmt_locat->rowCount() > 0) {

                                                $sequence = $stmt_locat->fetch(PDO::FETCH_ASSOC);

                                                $stmt = $this->db->prepare("INSERT INTO  location  (code,location,model,sequence,userid,`date`,new_location) values (?,?,?,?,?,?,?) ");
                                                $stmt->execute(array(trim($code_excel), $rowData[0][1], $model, $sequence['sequence'], $this->userid, time(), 1));

                                                $over = 0;
                                                if ($stmt->rowCount() > 0) {

                                                    $stmtconfirm = $this->db->prepare("SELECT * FROM location_confirm WHERE  code=?  AND model=? AND quantity < {$q} ");
                                                    $stmtconfirm->execute(array($code_excel, $model));
                                                    if ($stmtconfirm->rowCount() > 0) {
                                                        $result = $stmtconfirm->fetch(PDO::FETCH_ASSOC);
                                                        if ($result['quantity'] > 0) {
                                                            $over = $q - $result['quantity'];
                                                            $q = $result['quantity'];

                                                            $stmtup = $this->db->prepare("UPDATE   location SET  `quantity` = ? ,over_quantity=?,userid=?,`date`=? WHERE code=? AND location=? AND model=?");
                                                            $stmtup->execute(array($q, $over, $this->userid, time(), trim($code_excel), trim($rowData[0][1]), $model));
                                                            if ($stmtup->rowCount() > 0) {

                                                                $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity`- $q,userid=?,`date`=?  WHERE code=? AND model=? ");
                                                                $stmtcon->execute(array($this->userid, time(), trim($code_excel), $model));
                                                                if ($stmtcon->rowCount() <= 0) {
                                                                    $this->filter_error_quantity(trim($code_excel), $model, $q, '  اضافة كميات للمواقع بستخدام الاكسيل   - رقم الخطا 20');
                                                                }

                                                                $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كميات للمواقع بستخدام الاكسيل - رقم20', '+');
                                                            } else {
                                                                $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كميات للمواقع بستخدام الاكسيل - رقم الخطا 20', '+');
                                                            }
                                                        } else {



                                                            $stmtup = $this->db->prepare("UPDATE   location SET  over_quantity=? ,userid=?,`date`=? WHERE code=? AND location=? AND model=?");
                                                            $stmtup->execute(array($q, $this->userid, time(),  trim($code_excel), trim($rowData[0][1]), $model));
                                                            if ($stmtup->rowCount() > 0) {

                                                                $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =0,userid=?,`date`=?  WHERE code=? AND model=? ");
                                                                $stmtcon->execute(array($this->userid, time(), trim($code_excel), $model));
                                                                if ($stmtcon->rowCount() <= 0) {
                                                                    $this->filter_error_quantity(trim($code_excel), $model, $q, ' اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع   - رقم الخطا 33');
                                                                }

                                                                $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع   - رقم30', '+');
                                                            } else {
                                                                $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع  - رقم الخطا 30', '+');
                                                            }
                                                        }
                                                    } else {


                                                        $stmtu = $this->db->prepare("UPDATE   location SET  `quantity` =  ? ,over_quantity=?,userid=?,`date`=? WHERE code=? AND location=? AND model=? ");
                                                        $stmtu->execute(array($q, $over, $this->userid, time() + 1, trim($code_excel), trim($rowData[0][1]), $model));
                                                        if ($stmtu->rowCount() > 0) {
                                                            $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity`- $q ,userid=?,`date`=?  WHERE code=? AND model=? ");
                                                            $stmtcon->execute(array($this->userid, time(), trim($code_excel), $model));
                                                            if ($stmtcon->rowCount() <= 0) {
                                                                $this->filter_error_quantity(trim($code_excel), $model, $q, ' اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع   - رقم الخطا 34');
                                                            }

                                                            $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كميات للمواقع بستخدام الاكسيل - رقم21', '+');
                                                        } else {
                                                            $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كميات للمواقع بستخدام الاكسيل - رقم الخطا 21', '+');
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {


                                    $stmt_in_location_confirm = $this->db->prepare("INSERT INTO  location_confirm  (code,quantity,model,userid,`date`,`location`) values (?,?,?,?,?,?) ");
                                    $stmt_in_location_confirm->execute(array(trim($code_excel), $q, $model, $this->userid, time(), $rowData[0][1]));
                                    if ($stmt_in_location_confirm->rowCount() <= 0) {
                                        $this->filter_error_quantity(trim($code_excel), $model, $q, '  اضافة كميات للمواقع بستخدام الاكسيل   - رقم الخطا 22');
                                    }
                                }
                            }
                        } else {
                            $this->error_form =  'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى';
                            break;
                        }
                    }

                    @unlink($inputFileName);
                } else {

                    $this->error_form =  'يرجى اعادة رفع الملف';
                }

                if (empty($this->error_form)) {

                    $this->lightRedirect(url . '/' . $this->folder . "/view/{$model}");
                }
            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }
        }

        require($this->render($this->folder, 'html', 'add', 'php'));
        $this->adminFooterController();
    }





    function add_cumulative($model)
    {
        $class1 = '';
        $class2 = 'show active';
        $this->checkPermit('add_cumulative', $this->folder);
        $this->adminHeaderController($this->langControl('add_cumulative'));
        $this->AddToTraceByFunction($this->userid, 'location_confirm', 'add_cumulative/' . $model);
        if ($model == 'mobile') {
            $excel = 'excel';
        } else {
            $excel = 'excel_' . $model;
        }
        if (isset($_POST["submit"])) {


            try {
                $form = new  Form();

                $form->post('files_normal2')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $name_file = json_decode($data['files_normal2'], true);

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

                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray(
                            'A' . $row . ':' . $highestColumn . $row,
                            NULL,
                            TRUE,
                            TRUE
                        );


                        if (count($rowData[0]) >= 3) {

                            $code_excel = trim(strip_tags($rowData[0][0]));
                            $location = trim($rowData[0][1]);
                            $q = (int)str_replace('&gt;', '', trim($rowData[0][2]));
                            // هنا نشوف اذا المادة ما موجوده ك مواد بانتضار التاكيد فراح نضيفها 
                            if(!$this->isExist('location_confirm',"code='{$code_excel}' AND model='{$model}' "))
                            {
                                $stmt_insert_location_confirm = $this->db->prepare("INSERT into location_confirm (`code`,`quantity`,`model`,`userid`,`date`) values (?,?,?,?,?) ");
                                $stmt_insert_location_confirm->execute(array($code_excel, 0, $model, $this->userid, time()));
                            }
                            




                            $stmtconfirm_found = $this->db->prepare("SELECT * FROM location_confirm INNER JOIN {$excel} ON {$excel}.code=location_confirm.code WHERE  location_confirm.code=?  AND {$excel}.code=?  AND location_confirm.model=?  ");
                            $stmtconfirm_found->execute(array(trim($code_excel), trim($code_excel), $model));
                            if ($stmtconfirm_found->rowCount() > 0) {


                                $stmt_backup_location = $this->db->prepare("INSERT INTO  location_backup  (code,location,quantity,model,userid,`date_noraml`,`date`,`type`) values (?,?,?,?,?,?,?,?) ");
                                $stmt_backup_location->execute(array(trim($code_excel), trim($rowData[0][1]), $q, $model, $this->userid, date('Y-m-d h-i a'), time(), 'تراكمي'));


                                $stmtc = $this->db->prepare("SELECT *FROM location WHERE code=? AND location=? AND model=? ");
                                $stmtc->execute(array(trim($code_excel), trim($rowData[0][1]), $model));
                                if ($stmtc->rowCount() > 0) {


                                    $over = 0;
                                    $stmtconfirm = $this->db->prepare("SELECT * FROM location_confirm WHERE  code=? AND model=? AND quantity  < {$q}");
                                    $stmtconfirm->execute(array($code_excel, $model));
                                    if ($stmtconfirm->rowCount() > 0) {
                                        $result = $stmtconfirm->fetch(PDO::FETCH_ASSOC);
                                        if ($result['quantity'] > 0) {
                                            $over = $q - $result['quantity'];
                                            $q = $result['quantity'];

                                            $stmtup = $this->db->prepare("UPDATE   location SET  `quantity` =  quantity + {$q}  ,over_quantity=?,userid=?,`date`=?  WHERE code=? AND location=? AND model=?");
                                            $stmtup->execute(array($over, $this->userid, time(), trim($code_excel), trim($rowData[0][1]), $model));

                                            if ($stmtup->rowCount() > 0) {

                                                $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity`- $q ,userid=?,`date`=? WHERE code=? AND model=? ");
                                                $stmtcon->execute(array($this->userid, time(), trim($code_excel), $model));
                                                if ($stmtcon->rowCount() <= 0) {
                                                    $this->filter_error_quantity(trim($code_excel), $model, $q, '  اضافة كميات للمواقع بستخدام الاكسيل   - رقم الخطا 23');
                                                }

                                                $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كميات للمواقع بستخدام الاكسيل - رقم22', '+');
                                            } else {
                                                $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كميات للمواقع بستخدام الاكسيل - رقم الخطا 22', '+');
                                            }
                                        } else {


                                            $stmtup = $this->db->prepare("UPDATE   location SET  over_quantity=? ,userid=?,`date`=? WHERE code=? AND location=? AND model=?");
                                            $stmtup->execute(array($q, $this->userid, time(), trim($code_excel), trim($rowData[0][1]), $model));
                                            if ($stmtup->rowCount() > 0) {

                                                $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =0,userid=?,`date`=?  WHERE code=? AND model=? ");
                                                $stmtcon->execute(array($this->userid, time(), trim($code_excel), $model));
                                                if ($stmtcon->rowCount() <= 0) {
                                                    $this->filter_error_quantity(trim($code_excel), $model, $q, ' اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع   - رقم الخطا 35');
                                                }

                                                $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع   - رقم31', '+');
                                            } else {
                                                $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع  - رقم الخطا 31', '+');
                                            }
                                        }
                                    } else {


                                        $stmt = $this->db->prepare("UPDATE   location SET  `quantity` = quantity + {$q} ,over_quantity=?,userid=?,`date`=? WHERE code=? AND location=? AND model=?");
                                        $stmt->execute(array($over, $this->userid, time(), trim($code_excel), trim($rowData[0][1]), $model));
                                        if ($stmt->rowCount() > 0) {

                                            $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity`- $q ,userid=?,`date`=?  WHERE code=? AND model=? ");
                                            $stmtcon->execute(array($this->userid, time(), trim($code_excel), $model));
                                            if ($stmtcon->rowCount() <= 0) {
                                                $this->filter_error_quantity(trim($code_excel), $model, $q, '  اضافة كميات للمواقع بستخدام الاكسيل   - رقم الخطا 24');
                                            }

                                            $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كميات للمواقع بستخدام الاكسيل - رقم23', '+');
                                        } else {
                                            $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كميات للمواقع بستخدام الاكسيل - رقم الخطا 23', '+');
                                        }
                                    }
                                } else {
                                    if ($model != 'accessories' && $model != 'savers') {


                                        $location = array();
                                        $stmt_locat = $this->db->prepare("SELECT location,sequence FROM `location_model`  WHERE  `model` =?  ");
                                        $stmt_locat->execute(array($model));
                                        while ($rowx = $stmt_locat->fetch(PDO::FETCH_ASSOC)) {
                                            $location[] = $rowx;
                                        }

                                        if (!empty($location)) {
                                            foreach ($location as $in_location) {


                                                $stmtc = $this->db->prepare("SELECT * FROM location WHERE code=? AND location=? AND model=? ");
                                                $stmtc->execute(array(trim($code_excel), $in_location['location'], $model));
                                                if ($stmtc->rowCount() <= 0) {

                                                    $stmt = $this->db->prepare("INSERT INTO  location  (code,location,model,sequence,userid,`date`) values (?,?,?,?,?,?) ");
                                                    $stmt->execute(array(trim($code_excel), $in_location['location'], $model, $in_location['sequence'], $this->userid, time()));
                                                }
                                            }

                                            $over = 0;
                                            $stmtconfirm = $this->db->prepare("SELECT * FROM location_confirm WHERE  code=?  AND model=? AND quantity < {$q}");
                                            $stmtconfirm->execute(array($code_excel, $model));
                                            if ($stmtconfirm->rowCount() > 0) {
                                                $result = $stmtconfirm->fetch(PDO::FETCH_ASSOC);
                                                if ($result['quantity'] > 0) {
                                                    $over = $q - $result['quantity'];
                                                    $q = $result['quantity'];

                                                    $stmtup = $this->db->prepare("UPDATE   location SET  `quantity` = ? ,over_quantity=?,userid=?,`date`=? WHERE code=? AND location=? AND model=?");
                                                    $stmtup->execute(array($q, $over, $this->userid, time(), trim($code_excel), trim($rowData[0][1]), $model));
                                                    if ($stmtup->rowCount() > 0) {

                                                        $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity`- $q,userid=?,`date`=?  WHERE code=? AND model=? ");
                                                        $stmtcon->execute(array($this->userid, time(), trim($code_excel), $model));
                                                        if ($stmtcon->rowCount() <= 0) {
                                                            $this->filter_error_quantity(trim($code_excel), $model, $q, '  اضافة كميات للمواقع بستخدام الاكسيل   - رقم الخطا 25');
                                                        }

                                                        $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كميات للمواقع بستخدام الاكسيل - رقم24', '+');
                                                    } else {
                                                        $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كميات للمواقع بستخدام الاكسيل - رقم الخطا 24', '+');
                                                    }
                                                } else {
                                                    $stmtup = $this->db->prepare("UPDATE   location SET  over_quantity=? ,userid=?,`date`=? WHERE code=? AND location=? AND model=?");
                                                    $stmtup->execute(array($q, $this->userid, time(), trim($code_excel), trim($rowData[0][1]), $model));
                                                    if ($stmtup->rowCount() > 0) {

                                                        $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =0,userid=?,`date`=?  WHERE code=? AND model=? ");
                                                        $stmtcon->execute(array($this->userid, time(), trim($code_excel), $model));
                                                        if ($stmtcon->rowCount() <= 0) {
                                                            $this->filter_error_quantity(trim($code_excel), $model, $q, ' اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع   - رقم الخطا 36');
                                                        }

                                                        $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع   - رقم32', '+');
                                                    } else {
                                                        $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع  - رقم الخطا 32', '+');
                                                    }
                                                }
                                            } else {
                                                $stmt = $this->db->prepare("UPDATE   location SET  `quantity` = ? ,over_quantity=?,userid=?,`date`=? WHERE code=? AND location=? AND model=?");
                                                $stmt->execute(array($q, $over, $this->userid, time() + 1, trim($code_excel), trim($rowData[0][1]), $model));
                                                if ($stmt->rowCount() > 0) {

                                                    $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity`- $q ,userid=?,`date`=? WHERE code=? AND model=? ");
                                                    $stmtcon->execute(array($this->userid, time() + 1, trim($code_excel), $model));
                                                    if ($stmtcon->rowCount() <= 0) {
                                                        $this->filter_error_quantity(trim($code_excel), $model, $q, '  اضافة كميات للمواقع بستخدام الاكسيل   - رقم الخطا 26');
                                                    }
                                                    $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كميات للمواقع بستخدام الاكسيل - رقم25', '+');
                                                } else {
                                                    $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كميات للمواقع بستخدام الاكسيل - رقم الخطا 25', '+');
                                                }
                                            }
                                        }
                                    } else {
                                        $stmt_locat = $this->db->prepare("SELECT  * FROM `location_model`  WHERE location=? AND `model` =?  ");
                                        $stmt_locat->execute(array($rowData[0][1], $model));
                                        if ($stmt_locat->rowCount() > 0) {


                                            $sequence = $stmt_locat->fetch(PDO::FETCH_ASSOC);
                                            $stmt = $this->db->prepare("INSERT INTO  location  (code,location,model,sequence,userid,`date`,new_location) values (?,?,?,?,?,?,?) ");
                                            $stmt->execute(array(trim($code_excel), $rowData[0][1], $model, $sequence['sequence'], $this->userid, time(), 1));
                                            if ($stmt->rowCount() > 0) {

                                                $over = 0;
                                                $stmtconfirm = $this->db->prepare("SELECT *FROM location_confirm WHERE  code=?   AND model=? AND quantity < {$q}");
                                                $stmtconfirm->execute(array($code_excel, $model));
                                                if ($stmtconfirm->rowCount() > 0) {

                                                    $result = $stmtconfirm->fetch(PDO::FETCH_ASSOC);
                                                    if ($result['quantity'] > 0) {
                                                        $over = $q - $result['quantity'];
                                                        $q = $result['quantity'];

                                                        $stmtup = $this->db->prepare("UPDATE   location SET  `quantity` = ? ,over_quantity=?,userid=?,`date`=?  WHERE code=? AND location=? AND model=?");
                                                        $stmtup->execute(array($q, $over, $this->userid, time() + 1, trim($code_excel), trim($rowData[0][1]), $model));
                                                        if ($stmtup->rowCount() > 0) {

                                                            $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity`- $q,userid=?,`date`=?  WHERE code=? AND model=? ");
                                                            $stmtcon->execute(array($this->userid, time() + 1, trim($code_excel), $model));
                                                            if ($stmtcon->rowCount() <= 0) {
                                                                $this->filter_error_quantity(trim($code_excel), $model, $q, '  اضافة كميات للمواقع بستخدام الاكسيل   - رقم الخطا 27');
                                                            }

                                                            $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كميات للمواقع بستخدام الاكسيل - رقم26', '+');
                                                        } else {
                                                            $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كميات للمواقع بستخدام الاكسيل - رقم الخطا 26', '+');
                                                        }
                                                    } else {
                                                        $stmtup = $this->db->prepare("UPDATE   location SET  over_quantity=? ,userid=?,`date`=? WHERE code=? AND location=? AND model=?");
                                                        $stmtup->execute(array($q, $this->userid, time() + 1, trim($code_excel), trim($rowData[0][1]), $model));
                                                        if ($stmtup->rowCount() > 0) {

                                                            $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =0,userid=?,`date`=?  WHERE code=? AND model=? ");
                                                            $stmtcon->execute(array($this->userid, time() + 1, trim($code_excel), $model));
                                                            if ($stmtcon->rowCount() <= 0) {
                                                                $this->filter_error_quantity(trim($code_excel), $model, $q, ' اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع   - رقم الخطا 37');
                                                            }

                                                            $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع   - رقم33', '+');
                                                        } else {
                                                            $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع  - رقم الخطا 33', '+');
                                                        }
                                                    }
                                                } else {
                                                    $stmtcon = $this->db->prepare("UPDATE   location SET  `quantity` = ? ,over_quantity=?,userid=?,`date`=?  WHERE code=? AND location=? AND model=?");
                                                    $stmtcon->execute(array($q, $over, $this->userid, time() + 1, trim($code_excel), trim($rowData[0][1]), $model));
                                                    if ($stmtcon->rowCount() > 0) {
                                                        $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity`- $q ,userid=?,`date`=?  WHERE code=? AND model=? ");
                                                        $stmtcon->execute(array($this->userid, time() + 1, trim($code_excel), $model));
                                                        if ($stmtcon->rowCount() <= 0) {
                                                            $this->filter_error_quantity(trim($code_excel), $model, $q, '  اضافة كميات للمواقع بستخدام الاكسيل   - رقم الخطا 28');
                                                        }

                                                        $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كميات للمواقع بستخدام الاكسيل - رقم27', '+');
                                                    } else {
                                                        $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كميات للمواقع بستخدام الاكسيل - رقم الخطا 27', '+');
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            } 
                            else {

                                // $stmtup = $this->db->prepare("UPDATE   location SET  over_quantity=? ,userid=?,`date`=? WHERE code=? AND location=? AND model=?");
                                // $stmtup->execute(array($q, $this->userid, time(), trim($code_excel), trim($rowData[0][1]), $model));
                                // if ($stmtup->rowCount() > 0) {

                                //     $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =0,userid=?,`date`=?  WHERE code=? AND model=? ");
                                //     $stmtcon->execute(array($this->userid, time(), trim($code_excel), $model));
                                //     if ($stmtcon->rowCount() <= 0) {
                                //         $this->filter_error_quantity(trim($code_excel), $model, $q, ' اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع   - رقم الخطا 36');
                                //     }

                                //     $this->filter_location_tracking_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '  اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع   - رقم32', '+');
                                // } else {
                                //     $this->filter_location_error_quantity(trim($code_excel), $model, trim($rowData[0][1]), $q, '   اضافة كمية اكبر من كمية المواد بنتظار تأكيد الموقع  - رقم الخطا 32', '+');
                                // }
                                // $stmt_in_location_confirm = $this->db->prepare("INSERT INTO  location_confirm  (code,quantity,model,userid,`date`,`location`) values (?,?,?,?,?,?) ");
                                // $stmt_in_location_confirm->execute(array(trim($code_excel), $q, $model, $this->userid, time(), $rowData[0][1]));
                                // if ($stmt_in_location_confirm->rowCount() <= 0) {
                                //     $this->filter_error_quantity(trim($code_excel), $model, $q, '  اضافة كميات للمواقع بستخدام الاكسيل   - رقم الخطا 29');
                                // }
                            }
                        } else {
                            $this->error_form =  'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى';
                            break;
                        }
                    }

                    @unlink($inputFileName);
                } else {

                    $this->error_form =   'يرجى اعادة رفع الملف';
                }

                if (empty($this->error_form)) {
                    $this->lightRedirect(url . '/' . $this->folder . "/view/{$model}");
                }
            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }
        }

        require($this->render($this->folder, 'html', 'add', 'php'));
        $this->adminFooterController();
    }


    function lct($model)
    {
        if ($this->handleLogin()) {

            $code = trim($_POST['code']);
            $location = trim($_POST['location']);
            $q = (int)trim($_POST['q']);
            if (empty($q) || $q == 0) {
                $q = 1;
            }
            $this->AddToTraceByFunction($this->userid, 'location_confirm', 'lct/' . $model . '/' . $code . '/' . $location . '/' . $q);
            $over = 0;
            if ($model == 'mobile') {
                $excel = 'excel';
            } else {
                $excel = 'excel_' . $model;
            }
            $new_location = 0;
            if ($model == 'accessories' || $model == 'savers') {
                $new_location = 1;
            }

            $stmtx1 = $this->db->prepare("SELECT *FROM `location_model`  WHERE `location`=?  AND `model` =?  ");
            $stmtx1->execute(array($location, $model));
            if ($stmtx1->rowCount() > 0) {
                $result = $stmtx1->fetch(PDO::FETCH_ASSOC);


                $stmtconfirm_found = $this->db->prepare("SELECT * FROM location_confirm INNER JOIN {$excel} ON {$excel}.code=location_confirm.code WHERE  location_confirm.code=?  AND {$excel}.code=?  AND location_confirm.model=?  ");
                $stmtconfirm_found->execute(array($code, $code, $model));
                if ($stmtconfirm_found->rowCount() > 0) {

                    $stmt_backup_location = $this->db->prepare("INSERT INTO  location_backup  (code,location,quantity,model,userid,`date_noraml`,`date`,`type`) values (?,?,?,?,?,?,?,?) ");
                    $stmt_backup_location->execute(array($code, $location, $q, $model, $this->userid, date('Y-m-d h-i a'), time(), 'ضرب باركود'));



                    $stmtconfirm = $this->db->prepare("SELECT *FROM location_confirm WHERE code=? AND model=? AND quantity <  $q ");
                    $stmtconfirm->execute(array($code, $model));
                    if ($stmtconfirm->rowCount() > 0) {
                        $result_quantity = $stmtconfirm->fetch(PDO::FETCH_ASSOC);

                        $this->runInDBTransaction(function () use ($code, $location, $q, $model, $excel, $result_quantity, $new_location, $over, $result) {


                            if ($result_quantity['quantity'] > 0) {
                                //  over  = 1- 0 =1
                                $over = $q - $result_quantity['quantity'];
                                $q = $result_quantity['quantity'];

                                $stmtLocation = $this->db->prepare("SELECT *FROM `location` WHERE code=? AND location= ?  AND model=? ");
                                $stmtLocation->execute(array($code, $location, $model));
                                if ($stmtLocation->rowCount() > 0) {
                                    $stmt = $this->db->prepare("UPDATE   `location` SET  quantity=quantity +  {$q} ,`date`=?,over_quantity=?,userid=? WHERE code=? AND location=? AND model=?");
                                    $stmt->execute(array(time() + 1, $over, $this->userid, $code, $location, $model));
                                    if ($stmt->rowCount() > 0) {

                                        $this->filter_location_tracking_quantity($code, $model, $location, $q, '  توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها - رقم34', '+');


                                        $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` = 0  WHERE code=? AND model=? ");
                                        $stmtcon->execute(array($code, $model));
                                        if ($stmtcon->rowCount() <= 0) {
                                            $this->filter_error_quantity($code, $model, $q, ' توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها     - رقم الخطا 38');
                                        }
                                        echo 'q';


                                        $stmt_backup_location2 = $this->db->prepare("INSERT INTO  location_backup2  (code,location,quantity,model,userid,`date_noraml`,`date`,`type`) values (?,?,?,?,?,?,?,?) ");
                                        $stmt_backup_location2->execute(array($code, $location, $q, $model, $this->userid, date('Y-m-d h-i a'), time(), 'ضرب باركود'));
                                    } else {

                                        $this->filter_location_error_quantity($code, $model, $location, $q, '   توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها  - رقم الخطا 34', '+');
                                    }
                                } else {

                                    $stmt = $this->db->prepare("INSERT INTO  `location`  ( `code`,`location`,`model`,`quantity`,`sequence`,`date`,`userid`,over_quantity,new_location) values (?,?,?,?,?,?,?,?,?)");
                                    $stmt->execute(array($code, $location, $model, $q, $result['sequence'], time(), $this->userid, $over, $new_location));
                                    if ($stmt->rowCount() > 0) {

                                        $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity`- {$q}  WHERE code=? AND model=? ");
                                        $stmtcon->execute(array($code, $model));
                                        if ($stmtcon->rowCount() <= 0) {
                                            $this->filter_error_quantity($code, $model, $q, ' توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها     - رقم الخطا 39');
                                        }

                                        echo 'q';
                                        $stmt_backup_location2 = $this->db->prepare("INSERT INTO  location_backup2  (code,location,quantity,model,userid,`date_noraml`,`date`,`type`) values (?,?,?,?,?,?,?,?) ");
                                        $stmt_backup_location2->execute(array($code, $location, $q, $model, $this->userid, date('Y-m-d h-i a'), time(), 'ضرب باركود'));
                                        $this->filter_location_tracking_quantity($code, $model, $location, $q, '  توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها    - رقم35', '+');
                                    } else {

                                        $this->filter_location_error_quantity($code, $model, $location, $q, '   توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها  - رقم الخطا 35', '+');
                                    }
                                }
                            } else {



                                $stmtLocation = $this->db->prepare("SELECT *FROM `location` WHERE code=? AND location= ?  AND model=? ");
                                $stmtLocation->execute(array($code, $location, $model));
                                if ($stmtLocation->rowCount() > 0) {


                                    $stmtup = $this->db->prepare("UPDATE   location SET  over_quantity=over_quantity+ {$q},userid=?,`date`=?  WHERE code=? AND location=? AND model=?");
                                    $stmtup->execute(array($this->userid, time() + 1, $code, $location, $model));
                                    if ($stmtup->rowCount() > 0) {

                                        $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =0,userid=?,`date`=?  WHERE code=? AND model=? ");
                                        $stmtcon->execute(array($this->userid, time(), $code, $model));
                                        if ($stmtcon->rowCount() <= 0) {
                                            $this->filter_error_quantity($code, $model, $q, 'توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها    - رقم الخطا 40');
                                        }

                                        $this->filter_location_tracking_quantity($code, $model, $location, $q, '  توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها    - رقم36', '+');
                                    } else {
                                        $this->filter_location_error_quantity($code, $model, $location, $q, '   توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها  - رقم الخطا 36', '+');
                                    }



                                    echo 'q';
                                    $stmt_backup_location2 = $this->db->prepare("INSERT INTO  location_backup2  (code,location,quantity,model,userid,`date_noraml`,`date`,`type`) values (?,?,?,?,?,?,?,?) ");
                                    $stmt_backup_location2->execute(array($code, $location, $q, $model, $this->userid, date('Y-m-d h-i a'), time(), 'ضرب باركود'));
                                } else {

                                    $stmt = $this->db->prepare("INSERT INTO  `location`  ( `code`,`location`,`model`,`quantity`,`sequence`,`date`,`userid`,over_quantity,new_location) values (?,?,?,?,?,?,?,?,?)");
                                    $stmt->execute(array($code, $location, $model, 0, $result['sequence'], time(), $this->userid, $q, $new_location));
                                    if ($stmt->rowCount() > 0) {

                                        // $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity`- {$q}  WHERE code=? AND model=? ");
                                        // $stmtcon->execute(array($code, $model));
                                        // if ($stmtcon->rowCount() <= 0) {
                                        //     $this->filter_error_quantity($code, $model, $q, ' توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها     - رقم الخطا 39');
                                        // }

                                        echo 'q';
                                        $stmt_backup_location2 = $this->db->prepare("INSERT INTO  location_backup2  (code,location,quantity,model,userid,`date_noraml`,`date`,`type`) values (?,?,?,?,?,?,?,?) ");
                                        $stmt_backup_location2->execute(array($code, $location, $q, $model, $this->userid, date('Y-m-d h-i a'), time(), 'ضرب باركود'));
                                        $this->filter_location_tracking_quantity($code, $model, $location, $q, '  توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها    - رقم43', '+');
                                    } else {

                                        $this->filter_location_error_quantity($code, $model, $location, $q, '   توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها  - رقم الخطا 43', '+');
                                    }
                                }
                            }
                        });
                    } else {

                        $this->runInDBTransaction(function () use ($code, $location, $q, $model, $excel, $new_location, $result, $over) {

                            $stmtLocation = $this->db->prepare("SELECT *FROM `location` WHERE code=? AND location= ?  AND model=? ");
                            $stmtLocation->execute(array($code, $location, $model));
                            if ($stmtLocation->rowCount() > 0) {
                                $stmt = $this->db->prepare("UPDATE   `location` SET  quantity=quantity +  {$q} ,`date`=?,userid=? WHERE code=? AND location=? AND model=?");
                                $stmt->execute(array(time(), $this->userid, $code, $location, $model));
                                if ($stmt->rowCount() > 0) {

                                    $stmtcon = $this->db->prepare("UPDATE   location_confirm SET    `quantity` =`quantity`-  {$q},userid=?,`date`=?  WHERE code=? AND model=? ");
                                    $stmtcon->execute(array($this->userid, time(), $code, $model));
                                    if ($stmtcon->rowCount() <= 0) {
                                        $this->filter_error_quantity($code, $model, $q, 'توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها    - رقم الخطا 41');
                                    }

                                    echo '1';
                                    $stmt_backup_location2 = $this->db->prepare("INSERT INTO  location_backup2  (code,location,quantity,model,userid,`date_noraml`,`date`,`type`) values (?,?,?,?,?,?,?,?) ");
                                    $stmt_backup_location2->execute(array($code, $location, $q, $model, $this->userid, date('Y-m-d h-i a'), time(), 'ضرب باركود'));


                                    $this->filter_location_tracking_quantity($code, $model, $location, $q, '  توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها    - رقم37', '+');
                                } else {
                                    $this->filter_location_error_quantity($code, $model, $location, $q, '   توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها  - رقم الخطا 37', '+');
                                }
                            } else {


                                $stmt = $this->db->prepare("INSERT INTO  `location`  ( `code`,`location`,`model`,`quantity`,`sequence`,`date`,`userid`,new_location) values (?,?,?,?,?,?,?,?)");
                                $stmt->execute(array($code, $location, $model, $q, $result['sequence'], time(), $this->userid, $new_location));
                                if ($stmt->rowCount() > 0) {

                                    $stmtcon = $this->db->prepare("UPDATE   location_confirm SET    `quantity` =`quantity`- {$q},userid=?,`date`=?  WHERE code=? AND model=? ");
                                    $stmtcon->execute(array($this->userid, time(), $code, $model));
                                    if ($stmtcon->rowCount() <= 0) {
                                        $this->filter_error_quantity($code, $model, $q, 'توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها    - رقم الخطا 41');
                                    }

                                    echo '1';
                                    $stmt_backup_location2 = $this->db->prepare("INSERT INTO  location_backup2  (code,location,quantity,model,userid,`date_noraml`,`date`,`type`) values (?,?,?,?,?,?,?,?) ");
                                    $stmt_backup_location2->execute(array($code, $location, $q, $model, $this->userid, date('Y-m-d h-i a'), time(), 'ضرب باركود'));

                                    $this->filter_location_tracking_quantity($code, $model, $location, $q, '  توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها    - رقم38', '+');
                                } else {
                                    $this->filter_location_error_quantity($code, $model, $location, $q, '   توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها  - رقم الخطا 38', '+');
                                }
                            }
                        });
                    }
                } else {

                    $stmt_backup_location = $this->db->prepare("INSERT INTO  location_backup  (code,location,quantity,model,userid,`date_noraml`,`date`,`type`) values (?,?,?,?,?,?,?,?) ");
                    $stmt_backup_location->execute(array($code, $location, $q, $model, $this->userid, date('Y-m-d h-i a'), time(),  'ضرب باركود - دخول موقع غير موجود في اكسيل الكميات والاسعار'));


                    /*

                        $stmt_in_location_confirm_ch = $this->db->prepare("SELECT *FROM location_confirm WHERE code=? AND model=? AND location  =? ");
                        $stmt_in_location_confirm_ch->execute(array($code, $model,$location));
                        if ($stmt_in_location_confirm_ch->rowCount() > 0) {
                            $stmt_in_location_confirm = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity` + {$q},userid=?,`date`=?  WHERE code=? AND model=? AND location=?");
                            $stmt_in_location_confirm->execute(array($q, $this->userid, time(),trim($code),  $model, $location));
                            if ($stmt_in_location_confirm->rowCount() <= 0) {
                                $this->filter_error_quantity($code, $model, $q, 'توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها - الباركود غير موجود في الاكسيل   - رقم الخطا 42');
                            }

                        }else
                        {
                            $stmt_in_location_confirm = $this->db->prepare("INSERT INTO  location_confirm  (code,quantity,model,userid,`date`,`location`) values (?,?,?,?,?,?) ");
                            $stmt_in_location_confirm->execute(array(trim($code), $q, $model, $this->userid, time(), $location));
                            if ($stmt_in_location_confirm->rowCount() <= 0) {
                                $this->filter_error_quantity($code, $model, $q, 'توزيع الكمية على المواقع - مواد بنتظار تأكيد مواقعها - الباركود غير موجود في الاكسيل   - رقم الخطا 42');
                            }
                        }

*/
                    echo 'insert_code_to_location_conform';
                }
            } else {
                echo 'not_found'; //not found code
            }

            //            $fp = $_SERVER['DOCUMENT_ROOT'] . "/location_code.txt";
            //            $content =  $contents=$code." ".$location." ".$q.PHP_EOL;
            //            file_put_contents($fp,$content,FILE_APPEND);
            //


        }
    }



    function get_info_code($model)
    {
        $code_get = trim($_GET['code']);


        if ($model == 'mobile') {
            $code = 'code';
            $color = 'color';
            $excel = 'excel';
        } else {
            $code = 'code_' . $model;
            $color = 'color_' . $model;
            $excel = 'excel_' . $model;
        }


        if ($model == 'accessories') {





            $stmt = "   SELECT {$color}.code,{$color}.img,{$excel}.quantity,location.location,location.quantity as locq FROM `{$excel}` 
                left JOIN {$color} ON `{$color}`.code={$excel}.code 
                left JOIN location ON location.code={$excel}.code WHERE {$excel}.code=? AND `location`.model=?
                 ";
        } else if ($model == 'savers') {

            $stmt = "
          SELECT product_savers.code,product_savers.img,{$excel}.quantity,location.location,location.quantity as locq FROM `{$excel}` 
        left JOIN  product_savers ON product_savers.code={$excel}.code 
        left JOIN location ON location.code={$excel}.code WHERE {$excel}.code=? AND `location`.model=?
        ";
        } else {


            $stmt = "
         SELECT {$code}.code,{$color}.img,{$excel}.quantity,location.location,location.quantity as locq FROM `{$excel}`   
        left JOIN  {$code}  ON `{$code}`.code=`{$excel}`.code
        left JOIN {$color} ON {$color}.id={$code}.id_color 
        left JOIN location ON location.code={$excel}.code  
        WHERE {$excel}.code=? AND `location`.model=? ";
        }

        $stmt = $this->db->prepare($stmt);
        $stmt->execute(array($code_get, $model));



        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $row['image'] = $this->save_file . $row['img'];
            $stmtc = $this->db->prepare("SELECT *FROM `location_confirm`  WHERE `code` =  ?  AND `model` =?   LIMIT 1");
            $row['qNotConvert'] = '';
            $stmtc->execute(array($row['code'], $model));
            if ($stmtc->rowCount() > 0) {
                $rest = $stmtc->fetch(PDO::FETCH_ASSOC);
                $row['qNotConvert'] = $rest['quantity'];
            }

            $data[] = $row;
        }


        if (empty($data)) {


            if ($model == 'accessories') {


                $stmt2 = $this->db->prepare("
                  SELECT {$color}.code,{$color}.img,{$excel}.quantity FROM `{$excel}` 
                INNER JOIN {$color} ON `{$color}`.code={$excel}.code 
                WHERE {$excel}.code=?  
               ");
            } else if ($model == 'savers') {

                $stmt2 = $this->db->prepare("
                SELECT product_savers.code,product_savers.img,{$excel}.quantity  FROM `{$excel}` 
               INNER JOIN  product_savers ON product_savers.code={$excel}.code 
                WHERE {$excel}.code=? 
              ");
            } else {


                $stmt2 = $this->db->prepare("
                SELECT {$code}.code,{$color}.img,{$excel}.quantity  FROM `{$excel}` 
                INNER JOIN  {$code}  ON `{$code}`.code=`{$excel}`.code
                INNER JOIN {$color} ON {$color}.id={$code}.id_color 
                WHERE {$excel}.code=? 

            ");
            }


            $stmt2->execute(array($code_get));
            while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {


                $stmtc = $this->db->prepare("SELECT *FROM `location_confirm`  WHERE `code` =  ?  AND `model` =?   LIMIT 1");
                $row['qNotConvert'] = '';
                $stmtc->execute(array($row['code'], $model));
                if ($stmtc->rowCount() > 0) {
                    $rest = $stmtc->fetch(PDO::FETCH_ASSOC);
                    $row['qNotConvert'] = $rest['quantity'];
                }
                $row['location'] = '';
                $row['locq'] = 0;
                $row['image'] = $this->save_file . $row['img'];

                $data[] = $row;
            }
        }

        if ($data) {
            require($this->render($this->folder, 'html', 'details', 'php'));
        }
    }

    function search_location()
    {
        $model = $_GET['model'];
        $location = $_GET['location'];
        $location = '%' . $location . '%';
        $stmt = $this->db->prepare("SELECT *FROM `location_model`  WHERE `location` LIKE ?  AND `model` =? GROUP BY location LIMIT 25");
        $stmt->execute(array($location, $model));
        if ($stmt->rowCount() > 0) {

            $html = ''; {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $html .= "<a class='btn d-block text-right bg-light' href='#' onclick='print_location(this)'>{$row['location']}</a>";
                }
            }
            echo $html;
        }
    }

    function active_location($model, $vis)
    {
        if ($this->handleLogin()) {
            $this->AddToTraceByFunction($this->userid, 'location_confirm', 'active_location/' . $model . '/' . $vis);
            if (!is_numeric($vis)) {
                $vis = 0;
            }


            if ($model == 'savers') {

                $stmt = $this->db->prepare("UPDATE product_savers SET locationTag = ?");
                $stmt->execute(array($vis));
                if ($stmt->rowCount() > 0) {
                    echo  1;
                }
            } else {
                $stmt = $this->db->prepare("UPDATE {$model} SET location = ?");
                $stmt->execute(array($vis));
                if ($stmt->rowCount() > 0) {
                    echo  1;
                }
            }
        }
    }

    function check_location($model)
    {


        if ($model == 'savers') {
            $stmt = $this->db->prepare("SELECT id FROM  product_savers WHERE locationTag = 1");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return 'checked';
            } else {
                return '';
            }
        } else {

            $stmt = $this->db->prepare("SELECT id FROM {$model} WHERE location = 1");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return 'checked';
            } else {
                return '';
            }
        }
    }
    /*
        function convert()
        {

            $model='accessories';
            $stmt = $this->db->prepare("SELECT * FROM xxx  ");
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)  )
            {
                $stmtcm = $this->db->prepare("SELECT *FROM location_confirm WHERE code=? AND model=? ");
                $stmtcm->execute(array($row['code'], $model));
                if ($stmtcm->rowCount() > 0) {
                    $stmtUpdate = $this->db->prepare("UPDATE location_confirm SET quantity =  ?   ,date=? , location=''  WHERE  code = ? AND model = ?  ");
                    $stmtUpdate->execute(array($row['quantity'], time(), $row['code'], $model));
                } else {
                    $stmtInsert = $this->db->prepare("INSERT INTO  location_confirm  (code, price_dollars, quantity, model, date)  values  (?,?,?,?,?) ");
                    $stmtInsert->execute(array($row['code'],'', $row['quantity'], $model, time()));
                }
    echo $row['code'] .'---'.$row['quantity'] .'<br>';

            }

        }
    */



    function remove_by_excel2()
    {
        if ($this->handleLogin()) {

            $this->AddToTraceByFunction($this->userid, 'location_confirm', 'remove_by_excel2');
            $model = 'accessories';

            $excel = 'excel_' . $model;



            $stmtconfirm = $this->db->prepare("SELECT code,quantity FROM location_confirm WHERE model=? ");
            $stmtconfirm->execute(array($model));
            if ($stmtconfirm->rowCount() > 0) {
                while ($row = $stmtconfirm->fetch(PDO::FETCH_ASSOC)) {

                    $q = (int)$row['quantity'];

                    $stmtconEx = $this->db->prepare("SELECT * FROM excel_accessories WHERE code=? AND quantity > ? ");
                    $stmtconEx->execute(array($row['code'], $q));
                    if ($stmtconEx->rowCount() > 0) {
                        $stmtCode = $this->db->prepare("UPDATE   {$excel} SET quantity=quantity-{$q} WHERE code = ?  ");
                        $stmtCode->execute(array($row['code']));
                    } else {
                        $ex = $stmtconEx->fetch(PDO::FETCH_ASSOC);

                        $q = $q - $ex['quantity'];

                        $stmtCode = $this->db->prepare("UPDATE   {$excel} SET quantity=quantity-{$q} WHERE code = ?  ");
                        $stmtCode->execute(array($row['code']));
                    }


                    $stmtC = $this->db->prepare("DELETE FROM  location_confirm WHERE code =? AND model=?");
                    $stmtC->execute(array(trim($row['code']), $model));
                }

                echo 'true';
            }
        }
    }



    function alixcol($model)
    {
        //        حذف بستخدام الاكسيل

        if ($model == 'mobile') {
            $excel = 'excel';
        } else {
            $excel = 'excel_' . $model;
        }
        $this->checkPermit('remove_by_excel', $this->folder);
        $this->adminHeaderController($this->langControl('remove_by_excel'));
        if (isset($_POST["submit"])) {
            $this->AddToTraceByFunction($this->userid, 'location_confirm', 'alixcol/' . $model);

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

                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray(
                            'A' . $row . ':' . $highestColumn . $row,
                            NULL,
                            TRUE,
                            TRUE
                        );


                        if (count($rowData[0]) >= 2) {


                            $code = trim($rowData[0][0]);
                            $q = (int)trim($rowData[0][1]);
                            $stmtconEx = $this->db->prepare("SELECT * FROM {$excel} WHERE code=? AND quantity > ? ");
                            $stmtconEx->execute(array($code, $q));
                            if ($stmtconEx->rowCount() > 0) {
                                $stmtCode = $this->db->prepare("UPDATE   {$excel} SET quantity=quantity-{$q} WHERE code = ?  ");
                                $stmtCode->execute(array($code));
                            } else {
                                $ex = $stmtconEx->fetch(PDO::FETCH_ASSOC);

                                $q = $q - $ex['quantity'];

                                $stmtCode = $this->db->prepare("UPDATE   {$excel} SET quantity=quantity-{$q} WHERE code = ?  ");
                                $stmtCode->execute(array($code));
                            }


                            $stmtC = $this->db->prepare("DELETE FROM  location_confirm WHERE code =? AND model=?");
                            $stmtC->execute(array($code, $model));
                        } else {
                            $this->error_form =  'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى';
                            break;
                        }
                    }

                    @unlink($inputFileName);
                } else {

                    $this->error_form =  'يرجى اعادة رفع الملف';
                }


                if (empty($this->error_form)) {
                    echo 'doneeeeee  delete ........';
                }
            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }
        }

        require($this->render($this->folder, 'html', 'delete', 'php'));
        $this->adminFooterController();
    }



    function  convert_quantity_from_excel_conform()
    {


        $this->AddToTraceByFunction($this->userid, 'location_confirm', 'convert_quantity_from_excel_conform');
        $model = trim($_GET['model']);
        $code = trim($_GET['code']);
        if ($model == 'mobile') {
            $excel = 'excel';
        } else {
            $excel = 'excel_' . $model;
        }


        $stmt = $this->db->prepare("SELECT code,quantity  as exq FROM {$excel} WHERE code=?  LIMIT 1");
        $stmt->execute(array($code));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $row['lsmq'] = 0;
            $stmtLocation = $this->db->prepare("SELECT SUM(quantity) as lsmq  FROM location WHERE code=? AND model= ? ");
            $stmtLocation->execute(array($code, $model));
            if ($stmtLocation->rowCount() > 0) {

                $qlocation = $stmtLocation->fetch(PDO::FETCH_ASSOC);
                if ($qlocation['lsmq'] > 0) {
                    $row['lsmq'] = $qlocation['lsmq'];
                }
            }



            if ($row['exq'] > $row['lsmq']) {

                $stmtlc = $this->db->prepare("SELECT quantity FROM location_confirm WHERE code=? AND model= ? ");
                $stmtlc->execute(array($row['code'], $model));
                if ($stmtlc->rowCount() > 0) {
                    $clocation = $stmtlc->fetch(PDO::FETCH_ASSOC);
                    $q = (int)$row['lsmq'] + (int)$clocation['quantity'];
                    if ($row['exq'] > $q) {

                        $over = (int)$row['exq'] - $q;
                        $stmtlcu = $this->db->prepare("UPDATE location_confirm SET  quantity=quantity+{$over} ,`date`=?,userid=? WHERE code=? AND model= ? ");
                        $stmtlcu->execute(array(time(), $this->userid, $row['code'], $model));
                    }
                } else {
                    $over = (int)$row['exq'] - (int)$row['lsmq'];
                    $stmtExcel_conform = $this->db->prepare("INSERT INTO  location_confirm (quantity,code,model,date,userid)  values (?,?,?,?,?)");
                    $stmtExcel_conform->execute(array($over, $row['code'], $model, time(), $this->userid));
                }
            }
        }

        echo 'true';
    }
    function fix_problem()
    {
        // get sum of quantity in location_backup group by code and loction and model
        $stmt = $this->db->prepare("SELECT code FROM location_backup where  `date` > 1660597200 and `type` like '%حذف%'  GROUP BY code,location,model order ");
        $stmt->execute();
        // 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // get last id of location_backup 
            $stmt2 = $this->db->prepare("SELECT date FROM location_backup where code=? and location=? and model=? and `type` like '%حذف%'  ORDER BY id DESC LIMIT 1");
            $stmt2->execute(array($row['code'], $row['location'], $row['model']));
            $last_date = $stmt2->fetch(PDO::FETCH_ASSOC)['date'];
            // get rows in location_backup where code and location and model group by code and loction and model 
            $stmtlc = $this->db->prepare("SELECT * FROM location_backup WHERE code=? and location=? AND model= ? and  date between 1660597200 and $last_date ");
            $stmtlc->execute(array($row['code'], $row['location'], $row['model']));
            if ($stmtlc->rowCount() > 0) {
                $rowlc = $stmtlc->fetch(PDO::FETCH_ASSOC);
                $date_befor = $rowlc['date'];
                $sum_of_quantity = 0;
                while ($rowlc = $stmtlc->fetch(PDO::FETCH_ASSOC)) {
                    $date_after = $rowlc['date'];
                    $sum_of_quantity += $rowlc['quantity'];
                }
                $clocation = $stmtlc->fetch(PDO::FETCH_ASSOC);
                $q = (int)$row['q'] + (int)$clocation['quantity'];
                if ($row['count_'] > 1) {
                    $stmtlcu = $this->db->prepare("UPDATE location_confirm SET  quantity=quantity+{$row['q']} ,`date`=?,userid=? WHERE code=? AND model= ? ");
                    $stmtlcu->execute(array(time(), $this->userid, $row['code'], $row['model']));
                }
            } else {
                $stmtExcel_conform = $this->db->prepare("INSERT INTO  location_confirm (quantity,code,model,date,userid)  values (?,?,?,?,?)");
                $stmtExcel_conform->execute(array($row['q'], $row['code'], $row['model'], time(), $this->userid));
            }
        }
    }
    /**
     * get sum number from cart_shop_active for code between two dates
     */
    function get_sum_number_from_cart_shop($code, $location, $date_befor, $date_after)
    {

        $stmt = $this->db->prepare("SELECT SUM(number) as q FROM cart_shop_active WHERE code=? AND location =? and  date between ? AND ? ");
        $stmt->execute(array($code, $location, $date_befor, $date_after));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            return $row['q'];
        else
            return 0;
    }
    /**
     * get sum of qunatity from report_withdrawn by code and location and model between two dates
     * @param  [type] $code      [description]
     * @param  [type] $location  [description]
     * @param  [type] $model     [description]
     * @param  [type] $date_befor [description]
     * @param  [type] $date_after [description]
     * @return [type]            [description]
     */
    function get_sum_number_from_report_withdrawn($code, $location, $model, $date_befor, $date_after)
    {
        $stmt = $this->db->prepare("SELECT SUM(quantity) as q FROM report_withdrawn WHERE code=? AND location =? AND model=? and date between ? AND ? ");
        $stmt->execute(array($code, $location, $model, $date_befor, $date_after));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            return $row['q'];
        else
            return 0;
    }
    /**
     * get sum of qunatity from add_material_report by code and location and model between two dates
     * @param  [type] $code      [description]
     * @param  [type] $location  [description]
     * @param  [type] $model     [description]
     * @param  [type] $date_befor [description]
     * @param  [type] $date_after [description]
     * @return [type]            [description]
     */
    function get_sum_number_from_add_material_report($code, $location, $model, $date_befor, $date_after)
    {
        $stmt = $this->db->prepare("SELECT SUM(quantity) as q FROM add_material_report WHERE code=? AND location =? AND model=? and date between ? AND ? ");
        $stmt->execute(array($code, $location, $model, $date_befor, $date_after));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            return $row['q'];
        else
            return 0;
    }
}
