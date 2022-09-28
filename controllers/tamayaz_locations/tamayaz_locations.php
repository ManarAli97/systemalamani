<?php


class tamayaz_locations extends Controller
{

    public $ids = array();


    function __construct()
    {
        parent::__construct();
        $this->table = 'tamayaz_locations';
        $this->setting = new Setting();
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `location` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `active` int(10) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,  
          `userid` int(10) NOT NULL DEFAULT '0',
          
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table));

    }




    public function list_tamayaz_locations()
    {
        $this->checkPermit('list_tamayaz_locations', 'tamayaz_locations');
        $this->adminHeaderController($this->langControl('tamayaz_locations'));



        require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();
    }

    public function add_tamayaz_locations()
    {
        $this->checkPermit('add', 'tamayaz_locations');
        $this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'tamayaz_locations','add_tamayaz_locations');

        if (isset($_POST['submit'])) {
            try {
                $form = new Form();

                $form->post('location')
                    ->val('is_array', 'مطلوب');

                $form->submit();
                $data = $form->fetch();


                $title = json_decode($data['location'], true);


                foreach ($title as $key => $save_data) {
                    $stmt_s = $this->db->prepare("INSERT INTO `{$this->table}` (`location`,`date`,`userid`) VALUES (?,?,?)");
                    $stmt_s->execute(array(trim($save_data),time(),$this->userid));
                }


                $this->lightRedirect(url . '/' . $this->folder . '/list_tamayaz_locations', 0);
            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }

        }

        require($this->render($this->folder, 'html', 'add', 'php'));
        $this->adminFooterController();
    }


    public function processing_tamayaz_locations()
    {

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(
            array('db' => 'location', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),


            array('db' => 'userid', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }
            ),



            array(
                'db' => 'id',
                'dt' => 2,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', 'tamayaz_locations')) {
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
            array('db' => 'id', 'dt' => 3)


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
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
        );

    }


    public function ch_tamayaz_locations($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `active` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }


    public function visible_tamayaz_locations($v_, $id_)
    {
        if ($this->handleLogin()) {
            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }
            $data = $this->db->update($this->table, array('active' => $v), "`id`={$id}");
        }
    }


    function delete_tamayaz_locations($id)
    {
        if ($this->handleLogin()) {
            $this->AddToTraceByFunction($this->userid,'tamayaz_locations','delete_tamayaz_locations/'.$id);
            $c = $this->db->prepare("DELETE FROM  `$this->table`  WHERE  `id`=?");
            $c->execute(array($id));
        }
    }

    function get_tamayaz_locations($id)
    {
        if ($this->handleLogin()) {
            $data = $this->db->select("SELECT * from `{$this->table}` WHERE `id`=:id ", array(':id' => $id));
            if (!empty($data)) {
                $data = $data[0];
                echo json_encode($data);
            } else {
                exit();
            }
        }


    }


    public function edit_tamayaz_locations($id = null)
    {

        if ($this->handleLogin()) {
            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }
            $title = $_POST['location'];
            $stmt = $this->db->update($this->table, array('location' => $title), "id={$id}");

        }

    }





    function  excel()
    {
        $this->checkPermit('excel',$this->folder);
        $this->adminHeaderController($this->langControl('excel'));
        $this->AddToTraceByFunction($this->userid,'tamayaz_locations','excel');
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


                        if (count($rowData[0])  == 1)
                        {

                            $stmt=$this->db->prepare("INSERT INTO `tamayaz_locations` (`location`,`date`,`userid`,`color`) VALUES (?,?,?,?)");
                            $stmt->execute(array(trim($rowData[0][0]),time(),$this->userid,'red'));


                        }
                   		else if (count($rowData[0])  == 2)
                        {
                        	$stmt=$this->db->prepare("INSERT INTO `tamayaz_locations` (`location`,`date`,`userid`,`color`) VALUES (?,?,?,?)");
                            $stmt->execute(array(trim($rowData[0][0]),time(),$this->userid,trim($rowData[0][1])));
                        }
                    	else{
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
                    $this->lightRedirect(url.'/'.$this->folder."/list_tamayaz_locations");

                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'html','excel','php'));
        $this->adminFooterController();
    }








}









