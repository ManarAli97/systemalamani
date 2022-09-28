<?php

class location_model extends Controller
{


    function __construct()
    {
        parent::__construct();
        $this->table = 'location_model';
    }


    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
           `id` int(11)  NOT NULL AUTO_INCREMENT ,
           `location` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `sequence` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `quantity` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `userid` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table));

    }


    function list_location($model)
    {

        $this->checkPermit($model, $this->folder);
        $this->adminHeaderController($this->langControl($model));

        require($this->render($this->folder, 'html', 'index', 'php'));
        $this->adminFooterController();

    }


    public function processing($model)
    {


        $table = 'location_model';
        $primaryKey = 'id';


        $columns = array(
            array('db' => 'sequence', 'dt' => 0),
            array(
                'db' => 'location',
                'dt' => 1,
                'formatter' => function ($id, $row) {

                     return $this->tamayaz_locations($id);

                }
            ),


            array('db' => 'model', 'dt' => 2),

            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    if ($this->permit('edit_sequence', $this->folder)) {
                        return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'   data-toggle='modal' data-target='#exampleModal_edit' data-id='{$id}' data-sequence='{$row[0]}'    >
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
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "model='{$model}'")
        );


    }


    function add($model)
    {


        $this->checkPermit('add', $this->folder);
        $this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'location_model','add/'.$model);
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
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                            NULL,
                            TRUE,
                            TRUE);


                        if (count($rowData[0]) >= 2) {


                                $stmtx1 = $this->db->prepare("SELECT *FROM `location_model`  WHERE `location`=?  AND `model` =?  ");
                                $stmtx1->execute(array(trim($rowData[0][0]), $model));
                                if ($stmtx1->rowCount() > 0) {

                                    $stmt = $this->db->prepare("UPDATE   `location_model` SET   sequence=?,`date`=?,userid=? WHERE location=? AND model=? ");
                                    $stmt->execute(array($rowData[0][1], time(), $this->userid, trim($rowData[0][0]), $model,));

                                    $stmt3 = $this->db->prepare("UPDATE   location SET  `sequence` = ?  WHERE   location=? AND model= ?  ");
                                    $stmt3->execute(array($rowData[0][1], $rowData[0][0], $model));


                                } else {

                                    $stmt = $this->db->prepare("INSERT INTO  `location_model` (`location`,`sequence`,`model`,`userid`,`date`) VALUES (?,?,?,?,?)");
                                    $stmt->execute(array(trim($rowData[0][0]), $rowData[0][1],$model, $this->userid, time()));


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
                    $this->lightRedirect(url . '/' . $this->folder . "/list_location/{$model}");

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
            $this->AddToTraceByFunction($this->userid,'location_model','lct/'.$model);

            $location = strip_tags(trim($_POST['location']));
            $sequence = strip_tags(trim($_POST['sequence']));


            $stmtx1 = $this->db->prepare("SELECT *FROM `location_model`  WHERE `location`=?  AND `model` =?  ");
            $stmtx1->execute(array($location, $model));
            if ($stmtx1->rowCount() > 0) {

                $stmt = $this->db->prepare("UPDATE   `location_model` SET sequence=?,`date`=?,userid=? WHERE location=? AND model=? ");
                $stmt->execute(array( $sequence, time(), $this->userid, $location, $model));

                $stmt3 = $this->db->prepare("UPDATE   location SET  `sequence` = ?  WHERE  location=? AND model= ?  ");
                $stmt3->execute(array($sequence,$location, $model));

                echo '1';
            } else {

                $stmt = $this->db->prepare("INSERT INTO  `location_model` (`location`,`sequence`,`model`,`userid`,`date`) VALUES (?,?,?,?,?)");
                $stmt->execute(array($location, $sequence, $model, $this->userid, time()));
                echo '2';

            }


        }
    }


    function delete_location($id)
    {
        if ($this->handleLogin()) {
            $this->AddToTraceByFunction($this->userid,'location_model','delete_location/'.$id);

            $c = $this->db->prepare("DELETE FROM  `location_model`  WHERE  `id`=?");
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
            $this->AddToTraceByFunction($this->userid,'location_model','delete_all/'.$model);

            $this->checkPermit('delete_all_location', $this->folder);

            $c = $this->db->prepare("DELETE FROM  `location_model`  WHERE  `model`=? ");
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
            $this->AddToTraceByFunction($this->userid,'location_model','active_location/'.$model.'/'.$vis);
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
            $stmt = $this->db->prepare("SELECT * from `location_model` WHERE `id`=? LIMIT 1");
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
            $this->AddToTraceByFunction($this->userid,'location_model','edit/'.$id);
            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }
            $sequence= strip_tags(trim($_POST['sequence']));

            $stmt=$this->db->prepare('SELECT *FROM location_model WHERE id=?');
            $stmt->execute(array($id));

            if ($stmt->rowCount() > 0)
            {
            $result=$stmt->fetch(PDO::FETCH_ASSOC);


             $stmt2 = $this->db->prepare("UPDATE   location_model  SET  `sequence` =  ? ,userid =?,`date`=? WHERE   id = ?  ");
             $stmt2->execute(array($sequence,$this->userid,time(),$id));
             if ($stmt2->rowCount() > 0)
             {
                 $stmt3 = $this->db->prepare("UPDATE   location SET  `sequence` = ?,userid=?,`date` = ? WHERE sequence=? AND model= ?  ");
                 $stmt3->execute(array($sequence,$this->userid,time(), $result['sequence'], $result['model']));
                 echo 'true';
             }


            }

        }

    }


}