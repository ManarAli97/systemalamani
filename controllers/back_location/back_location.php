<?php

class back_location extends Controller
{


    function __construct()
    {
        parent::__construct();
        $this->table = 'back_location';
    }


    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
           `id` int(11)  NOT NULL AUTO_INCREMENT ,
        
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `location` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `quantity` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `userid` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table));

    }


    function index()
    {


        $this->adminHeaderController('back_location');

        require($this->render($this->folder, 'html', 'index', 'php'));
        $this->adminFooterController();

    }


    public function processing()
    {


        $table = 'back_location';
        $primaryKey = 'id';


        $columns = array(
            array('db' => 'code', 'dt' => 0),
            array('db' => 'location', 'dt' => 1),
            array('db' => 'model', 'dt' => 2),

            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    if ($this->permit('edit_code', $this->folder)) {
                        return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'   data-toggle='modal' data-target='#exampleModal_edit' data-id='{$id}' data-code='{$row[0]}'    >
                    <i class='fa fa-edit' aria-hidden='true'></i></i>
                         </button>
                    </div>
                   
                    ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),


            array(
                'db' => 'id',
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_location', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[1]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),

            array('db' => 'id', 'dt' => 5),

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
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns )
        );


    }


    function add()
    {

		$this->AddToTraceByFunction($this->userid,'back_location','add');
        $this->checkPermit('add', $this->folder);
        $this->adminHeaderController($this->langControl('add'));

        if (isset($_POST["submit"])) {


            try {
                $form = new  Form();

                $form->post('model')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');

                $form->post('files_normal')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $model=$data['model'];
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
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                            FALSE,
                            TRUE,
                            TRUE);


                        if (count($rowData[0]) >= 3) {


                                $code = trim($rowData[0][0]);
                                $location = trim($rowData[0][1]);
                                $q = (int)trim($rowData[0][2]);


                                $stmtS = $this->db->prepare("SELECT   sequence FROM `location_model`  WHERE  `location`=?  AND `model` =? ");
                                $stmtS->execute(array($location, $model));
                                if ($stmtS->rowCount() > 0) {
                                    $result = $stmtS->fetch(PDO::FETCH_ASSOC);
                                    $sequence=$result['sequence'];
                                }else
                                {
                                    $sequence='';
                                }


                                if ($model == 'savers')
                                {
                                    $m='product_savers';
                                }else
                                {
                                    $m=$model;
                                }


                                $stmtx1 = $this->db->prepare("SELECT SUM(number) as num  FROM `cart_shop_active`  WHERE `code`=?  AND `location`=?  AND `table` =?  AND cancel= 0  AND prepared=2 AND  date_d_r > 1637588022 GROUP BY code,`table`,id_item  ");
                                $stmtx1->execute(array($code,$location, $m));
                                if ($stmtx1->rowCount() > 0) {
                                    $result = $stmtx1->fetch(PDO::FETCH_ASSOC);
                                    $num=(int)$result['num'];

                                      $q = $q-$num;


                                    $stmtw = $this->db->prepare("SELECT SUM(quantity) as num  FROM `report_withdrawn`  WHERE `code`=?  AND `location`=?  AND `category` =?   AND  date > 1637588022 GROUP BY code,`category`,location  ");
                                    $stmtw->execute(array($code,$location, $model));
                                    if ($stmtw->rowCount() > 0) {
                                        $resultw = $stmtw->fetch(PDO::FETCH_ASSOC);
                                        $numw = (int)$resultw['num'];
                                        $q=$q-$numw;
                                    }



                                    $stmtcl = $this->db->prepare("SELECT quantity  FROM `location`  WHERE `code`=?  AND `location`=?  AND `model` =?     ");
                                    $stmtcl->execute(array($code,$location, $model));
                                    if ($stmtcl->rowCount()  > 0) {
                                        $resultll = $stmtcl->fetch(PDO::FETCH_ASSOC);
                                        $q=$q+$resultll['quantity'];


                                        $stmt = $this->db->prepare("INSERT INTO  `location` (`location`,`code`,`model`,`quantity`,`sequence`,`userid`,`date`) VALUES (?,?,?,?,?,?,?)");
                                        $stmt->execute(array($location, $code, $model, $q, $sequence, $this->userid, time()));
                                    }else
                                    {
                                        $stmt = $this->db->prepare("INSERT INTO  `location` (`location`,`code`,`model`,`quantity`,`sequence`,`userid`,`date`) VALUES (?,?,?,?,?,?,?)");
                                        $stmt->execute(array($location, $code, $model, $q, $sequence, $this->userid, time()));
                                    }
                                } else {


                                    $stmtw = $this->db->prepare("SELECT SUM(quantity) as num  FROM `report_withdrawn`  WHERE `code`=?  AND `location`=?  AND `category` =?   AND  date > 1637588022 GROUP BY code,`category`,location  ");
                                    $stmtw->execute(array($code,$location, $model));
                                    if ($stmtw->rowCount() > 0) {
                                        $resultw = $stmtw->fetch(PDO::FETCH_ASSOC);
                                        $numw = (int)$resultw['num'];
                                        $q=$q-$numw;
                                    }

                                    $stmtcl = $this->db->prepare("SELECT location  FROM `location`  WHERE `code`=?  AND `location`=?  AND `model` =?     ");
                                    $stmtcl->execute(array($code,$location, $model));
                                    if ($stmtcl->rowCount()  > 0) {

                                        $resultll = $stmtcl->fetch(PDO::FETCH_ASSOC);
                                        $q=$q+$resultll['quantity'];

                                        $stmt = $this->db->prepare("INSERT INTO  `location` (`location`,`code`,`model`,`quantity`,`sequence`,`userid`,`date`) VALUES (?,?,?,?,?,?,?)");
                                        $stmt->execute(array($location, $code, $model, $q, $sequence, $this->userid, time()));
                                    }else
                                    {

                                        $stmt = $this->db->prepare("INSERT INTO  `location` (`location`,`code`,`model`,`quantity`,`sequence`,`userid`,`date`) VALUES (?,?,?,?,?,?,?)");
                                        $stmt->execute(array($location, $code, $model, $q, $sequence, $this->userid, time()));
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
                    $this->lightRedirect(url . '/' . $this->folder );

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
            $location = $_POST['location'];
            $code = $_POST['code'];
			$this->AddToTraceByFunction($this->userid,'back_location','lct/'.$model.'/'.$location.'/'.$code);

            $stmtx1 = $this->db->prepare("SELECT *FROM `back_location`  WHERE `location`=?  AND `model` =?  ");
            $stmtx1->execute(array($location, $model));
            if ($stmtx1->rowCount() > 0) {

                $stmt = $this->db->prepare("UPDATE   `back_location` SET code=?,`date`=?,userid=? WHERE location=? AND model=? ");
                $stmt->execute(array( $code, time(), $this->userid, $location, $model));

                $stmt3 = $this->db->prepare("UPDATE   location SET  `code` = ?  WHERE  location=? AND model= ?  ");
                $stmt3->execute(array($code,$location, $model));

                echo '1';
            } else {

                $stmt = $this->db->prepare("INSERT INTO  `back_location` (`location`,`code`,`model`,`userid`,`date`) VALUES (?,?,?,?,?)");
                $stmt->execute(array($location, $code, $model, $this->userid, time()));
                echo '2';

            }


        }
    }


    function delete_location($id)
    {
        if ($this->handleLogin()) {

            $c = $this->db->prepare("DELETE FROM  `back_location`  WHERE  `id`=?");
            $c->execute(array($id));
            if ($c->rowCount() >0)
            {
                echo 1;
            }
        }

    }


    function delete_all($model)
    {
        if ($this->handleLogin()) {
        	$this->AddToTraceByFunction($this->userid,'back_location','delete_all/'.$model);
            $this->checkPermit('delete_all_location', $this->folder);

            $c = $this->db->prepare("DELETE FROM  `back_location`  WHERE  `model`=? ");
            $c->execute(array($model));
            if ($c->rowCount()>0)
            {
                echo  'true';
            }

        }
    }
    function active_location($model,$vis)
    {
        if ($this->handleLogin()) {
         $this->AddToTraceByFunction($this->userid,'back_location','active_location/'.$model.'/'.$vis);
            if (!is_numeric($vis) ) {
                $vis = 0;
            }

            $stmt = $this->db->prepare("UPDATE {$model} SET location = ?");
            $stmt->execute(array($vis));
            if ($stmt->rowCount() > 0)
            {
                echo  1;
            }

        }
    }

    function check_location($model)
    {

        $stmt = $this->db->prepare("SELECT *FROM {$model} WHERE location = 0");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return '';
        } else {
            return 'checked';
        }

    }


    function get_location_edit($id)
    {
        if ($this->handleLogin()) {
            $stmt = $this->db->prepare("SELECT * from `back_location` WHERE `id`=? LIMIT 1");
            $stmt->execute(array($id));
            if ($stmt->rowCount()>0) {
                $data =$stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($data);
            } else {
                exit();
            }
        }


    }


    public function edit($id = null)
    {

        if ($this->handleLogin()) {
        	
            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }
            $code= $_POST['code'];
			$this->AddToTraceByFunction($this->userid,'back_location','edit/'.$id.'/'.$code);
            $stmt=$this->db->prepare('SELECT *FROM back_location WHERE id=?');
            $stmt->execute(array($id));

            if ($stmt->rowCount() > 0)
            {
            $result=$stmt->fetch(PDO::FETCH_ASSOC);


             $stmt2 = $this->db->prepare("UPDATE   back_location  SET  `code` =  ? ,userid =?,`date`=? WHERE   id = ?  ");
             $stmt2->execute(array($code,$this->userid,time(),$id));
             if ($stmt2->rowCount() > 0)
             {
                 $stmt3 = $this->db->prepare("UPDATE   location SET  `code` = ?,userid=?,`date` = ? WHERE code=? AND model= ?  ");
                 $stmt3->execute(array($code,$this->userid,time(), $result['code'], $result['model']));
                 echo 'true';
             }


            }

        }

    }


}