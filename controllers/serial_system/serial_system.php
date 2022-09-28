<?php
require_once "report_serial_entry/report_serial_entry.php";
require_once "report_serial_cases/report_serial_cases.php";
require_once "spare_code/spare_code.php";
require_once "serial_conform/serial_conform.php";
require_once "serial_material_inventory/serial_material_inventory.php";
require_once "jard/jard.php";
require_once "jard_and_correction/jard_and_correction.php";
require_once "case_serial/case_serial.php";
require_once "oldserial/oldserial.php";
class serial_system extends Controller
{

    protected $list_serial_system='';
    public $ids=array();
    use report_serial_entry,oldserial,report_serial_cases,spare_code,serial_conform,serial_material_inventory,jard,case_serial,jard_and_correction;
    function __construct()
    {
        parent::__construct();
        $this->table='serial_system';
        $this->serial_system_page='serial_system_page';
        $this->serial_page='serial_page';
        $this->serial='serial';
        $this->serial_delete='serial_delete';
        $this->spare_code='spare_code';
        $this->serial_conform='serial_conform';
        $this->jard='jard';
        $this->jardTime='jardTime';
        $this->jard_page='jard_page';
        $this->jard_and_correction='jard_and_correction';
        $this->jard_and_correction_page='jard_and_correction_page';
        $this->jard_delete ='jard_delete';
        $this->serial_moves ='serial_moves';
        $this->serial_case_1 ='serial_case_1';
        $this->serial_case_2 ='serial_case_2';
        $this->serial_correct_location_deleted ='serial_correct_location_deleted';
        $this->setting=new Setting();
        $this->infoCode=array('cat_title'=>'','title'=>'');

    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
          `serial_system` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `length` int(11) NOT NULL ,
          `page` int(11) NOT NULL ,
           `lang` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `type` int(11) NOT NULL ,
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");





        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->serial_system_page}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` int(11) NOT NULL ,
           `userid` int(11) NOT NULL ,
           `print`  int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->serial_page}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` int(11) NOT NULL ,
           `userId` int(11) NOT NULL ,
           `from_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `to_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");





        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->serial}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` int(11) NOT NULL ,
           `bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `serial` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `type_enter` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `quantity` bigint(20) NOT NULL,
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `userId` int(11) NOT NULL ,
           `time_taken` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->serial_delete}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` int(11) NOT NULL ,
           `bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `serial` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `type_enter` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `quantity` bigint(20) NOT NULL,
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->serial_moves}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` int(11) NOT NULL ,
           `bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `serial` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `type_enter` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `quantity` bigint(20) NOT NULL,
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `type` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `number_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->spare_code}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `size` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `spare_code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `userId` int(11) NOT NULL ,
           `id_item` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->serial_conform}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `type` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");






        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->jard_page}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` int(11) NOT NULL ,
           `userId` int(11) NOT NULL ,
           `from_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `to_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->jardTime}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` int(11) NOT NULL ,
           `userId` int(11) NOT NULL ,
           `from_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `to_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");




        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->jard}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` int(11) NOT NULL ,
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `serial` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `type_enter` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `quantity` bigint(20) NOT NULL,
           `excel_quantity` bigint(20) NOT NULL,
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `userId` int(11) NOT NULL ,
           `from_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `to_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `date` bigint(20) NOT NULL,  `location` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `location_quantity` int(11) NOT NULL ,
           `location_quantity_all` int(11) NOT NULL 
           
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");




        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->jard_and_correction_page}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` int(11) NOT NULL ,
           `userId` int(11) NOT NULL ,
           `from_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `to_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");




        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->jard_and_correction}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` int(11) NOT NULL ,
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `serial` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `type_enter` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `quantity` bigint(20) NOT NULL,
           `excel_quantity` bigint(20) NOT NULL,
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `userId` int(11) NOT NULL ,
           `from_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `to_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `date` bigint(20) NOT NULL,
            `location` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `location_quantity` int(11) NOT NULL ,
           `location_quantity_all` int(11) NOT NULL ,
    
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->jard_delete}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` int(11) NOT NULL ,
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `serial` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `type_enter` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `quantity` bigint(20) NOT NULL,
           `excel_quantity` bigint(20) NOT NULL,
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->serial_case_1}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `serial` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `number_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->serial_case_2}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `serial` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `location` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `type_enter` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
            `quantity` bigint(20) NOT NULL, 
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->serial_correct_location_deleted}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `oldlocation` longtext COLLATE utf8_unicode_ci  ,   
           `newlocation` longtext COLLATE utf8_unicode_ci  ,   
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        return  $this->db->cht(array($this->table,$this->jardTime,$this->serial_correct_location_deleted,$this->serial,$this->serial_delete,$this->spare_code,$this->serial_conform,$this->jard_page,$this->jard,$this->jard_delete,$this->serial_case_1,$this->serial_case_2,$this->jard_and_correction,$this->jard_and_correction_page));

    }


    public function index(){ $index =new Index(); $index->index();}




    function load_class()
    {

        spl_autoload_register(function ( $class_name) {

            echo $class_name;



//            if (file_exists(LIBS.$class_name.'.php'))
//            {
//                 echo LIBS.$class_name.'.php';
//            }elseif(file_exists('controllers/'.strtolower($class_name).'/'.strtolower($class_name).'.php'))
//            {
//                 echo 'controllers/'.strtolower($class_name).'/'.strtolower($class_name).'.php';
//
//            }

        });
    }






    function list_page_serial_system()
    {

        $this->checkPermit('page_serial_system',$this->folder);

        $this->adminHeaderController($this->langControl($this->folder));

        require ($this->render($this->folder,'html','page_serial_system','php'));
        $this->adminFooterController();

    }

    public function processing_page_serial_system()
    {


        $table = $this->serial_system_page;
        $primaryKey = $table.'.id';

        $columns = array(


            array( 'db' => $table.'.page', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/generation_serial/{$d}'>{$d}</a>";
                }
            ),
            array( 'db' => 'user.username', 'dt' => 1 ),

            array( 'db' =>  $table.'.date', 'dt' => 2 ,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),


            array( 'db' => $table.'.print', 'dt' => 3,
                'formatter' => function ($d, $row) {
                if ($d==0)
                {
                    return "<a  target='_blank' class='btn btn-warning'  href='".url.'/'.$this->folder."/print_serial/{$row[0]}'>  غير مطبوع  </a>";

                }else
                {
                    return "<a  target='_blank'  class='btn btn-success'  href='".url.'/'.$this->folder."/print_serial/{$row[0]}'> مطبوع</a>";

                }
                }
            ),

            array(  'db' =>   $table.'.id', 'dt'=> 4)


        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = " inner JOIN user ON user.id = {$table}.userid   ";
        $whereAll = array("");


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));

    }



    function creat_page_serial_system()
    {


        $stmtpage = $this->db->prepare("SELECT `page` FROM serial_system_page    ORDER BY page DESC LIMIT 1");
        $stmtpage->execute();
        if ($stmtpage->rowCount() > 0) {
            $page = $stmtpage->fetch(PDO::FETCH_ASSOC)['page'] + 1;
            $stmt = $this->db->prepare("INSERT INTO `serial_system_page` ( page, userid, date) VALUE (?,?,?) ");
            $stmt->execute(array($page,$this->userid,time()));
        } else {
            $stmt = $this->db->prepare("INSERT INTO `serial_system_page` ( page, userid, date) VALUE (?,?,?) ");
            $stmt->execute(array(1,$this->userid,time()));
            $page =  1;

        }

        echo $page;
    }




    function list_serial_system()
    {

        $this->checkPermit('generation_serial',$this->folder);

        $this->adminHeaderController($this->langControl($this->folder));

        require ($this->render($this->folder,'html','list','php'));
        $this->adminFooterController();

    }


    function generation_serial($id)
    {

        $this->checkPermit('generation_serial',$this->folder);

        $this->adminHeaderController($this->langControl($this->folder));

        require ($this->render($this->folder,'html','list','php'));
        $this->adminFooterController();

    }


    function generation($id)
    {

        $this->checkPermit('generation',  $this->folder);
        $this->adminHeaderController($this->langControl('generation'));

        require($this->render($this->folder, 'html', 'add', 'php'));
        $this->adminFooterController();

    }





    function form_generation_serial($id)
    {

        $data['length'] = '';
        $data['number'] = '';
        $data['code'] = '';

        if (isset($_POST['submit'])) {
            try {

                $form = new  Form();


                $form->post('code')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');
                $form->post('length')
                    ->val('digit', $this->langControl('required'))
                    ->val('strip_tags');

                $form->post('number')
                    ->val('digit', $this->langControl('required'))
                    ->val('strip_tags');

                $form->post('type')
                    ->val('digit', $this->langControl('required'))
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();

                $num=$data['number'];

                $data['userid'] = $this->userid;
                $data['date'] = time();
                $model=$this->model_code(trim($data['code']));
                 if ( $model ) {


                     if ($model=='mobile')
                     {
                         $excel='excel';
                     }else
                     {
                         $excel='excel_'.$model;
                     }

                     $stmtExcel=$this->db->prepare("SELECT quantity FROM  {$excel} WHERE  code=?");
                     $stmtExcel->execute(array($data['code']));
                     $excelResult= $stmtExcel->fetch(PDO::FETCH_ASSOC);

                      $serialEnter=$this->sum_serial_enter($data['code'],$model);

                     $qSerial=(int)$excelResult['quantity']-(int)$serialEnter;

                     if ($qSerial <=0)
                     {
                         die('not_found_quantity');
                     }

                     $overQuantity=false;
                     if ($num > $qSerial)
                     {
                         $num=  $qSerial;
                         $overQuantity=true;
                     }

                      for ($i = 1; $i <= $num; $i++) {

                         if ($data['type'] == 1) {
                             $srel = $this->generateNumber($data['length']);
                         } else if ($data['type'] == 2) {
                             $srel = $this->generateChar($data['length']);
                         } else {
                             $srel = $this->generateCharNumb($data['length']);
                         }

                         $stmtCh = $this->db->prepare("SELECT * FROM serial_system WHERE serial_system =? ");
                         $stmtCh->execute(array($srel));
                         if ($stmtCh->rowCount() <= 0) {
                             $stmt = $this->db->prepare("INSERT INTO `serial_system` (`code`,`serial_system`,`length`,`userid`,`date`,`type`,`page`) VALUE (?,?,?,?,?,?,?) ");
                             $stmt->execute(array(trim($data['code']), $srel, $data['length'], $this->userid, time(), $data['type'], $id));


                             $stmt = $this->db->prepare("SELECT * FROM serial WHERE code =? AND  serial=? AND  model=?  ");
                             $stmt->execute(array(trim($data['code']), $srel, $model ));
                             if ($stmt->rowCount() <= 0) {
                                 $stmt = $this->db->prepare("INSERT INTO `serial` (  code, serial, type_enter, quantity, userId, date, model) VALUE (?,?,?,?,?,?,?) ");
                                 $stmt->execute(array(trim($data['code']), $srel, 'صفحة توليد سيريلات', 1, $this->userid, time(), $model));
                                 $this->deleteCodeFromSerialConform(trim($data['code']), $data['model']);
                             }

                         }

                     }
                     if ($overQuantity){
                         echo 'over_quantity';
                     }else
                     {
                         echo 'true';
                     }

                 }else
                 {
                     echo 'code_note_found';
                 }

            } catch (Exception $e) {
                $data = $form->fetch();
              $this->error_form = $e->getMessage();
            }

        }
    }




    function generateNumber($h)
    {

        $alphabet = '0123456789';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $h; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }


    function generateChar($h)
    {

        $alphabet = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $h; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }


    function generateCharNumb($h)
    {

        $alphabet = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $h; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }





    public function processing($id)
    {


        $table = $this->table;
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $table.'.page', 'dt' => 0 ),
            array( 'db' => $table.'.code', 'dt' => 1 ),
            array( 'db' => $table.'.serial_system', 'dt' => 2 ),
            array( 'db' => $table.'.length', 'dt' => 3 ),
            array( 'db' => 'user.username', 'dt' => 4 ),

            array( 'db' =>  $table.'.date', 'dt' => 5,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),

            array(  'db' =>   $table.'.id', 'dt'=>6)


        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = " inner JOIN user ON user.id = {$table}.userid   ";
        $whereAll = array("page={$id}");


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));

    }


    function delete_all()
    {
        if ($this->handleLogin()) {
            $this->checkPermit('delete_all', $this->folder);
            $stmt = $this->db->prepare("TRUNCATE TABLE `{$this->table}` ");
            $stmt->execute();
            echo 1;
        }
    }

    function delete_code($code)
    {
        if ($this->handleLogin()) {
            $this->checkPermit('delete_serial_code', $this->folder);
            $stmt = $this->db->prepare("DELETE FROM serial_system WHERE code=? ");
            $stmt->execute(array(trim($code)));

            $stmt = $this->db->prepare("DELETE FROM serial WHERE code=? ");
            $stmt->execute(array(trim($code)));

            $stmt = $this->db->prepare("DELETE FROM jard WHERE code=? ");
            $stmt->execute(array(trim($code)));

            $stmt = $this->db->prepare("DELETE FROM jard_and_correction WHERE code=? ");
            $stmt->execute(array(trim($code)));

            echo 1;
        }
    }




    function print_serial($id)
    {

      $this->checkPermit('print_serial', $this->folder);


        // Include the main TCPDF library (search for installation path).
        require_once('tcpdf/examples/config/tcpdf_config_alt.php');
        require_once('tcpdf/tcpdf.php');

// create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, array(25,50), true, 'UTF-8', true);

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetTitle(' رقم الصفحة   ' . $id);



        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => true,
            'fitwidth' => false,
            'cellfitalign' => '',
            'border' => false,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );


        $pdf->SetAutoPageBreak(TRUE, 0);
        $pdf->SetFont('dejavusans', '', 8);

        $pdf->setCellPaddings( 5, 0,5, 0);
        $pdf->SetMargins(0, 1, 0);


        $stmt = $this->db->prepare("SELECT *FROM serial_system WHERE page=?");
        $stmt->execute(array($id));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

            $result= $this->data_code_print($row['code']);
            if (isset($result['title']))
            {
                $row['title']=$result['title'];
            }else
            {
                $row['title']=  'المادة غير معرفة في النظام';
            }

            $pdf->AddPage();
            $pdf->Cell(0, 0,  $row['title'], 0, 1,'C');
            $pdf->Cell(0, 0,  $row['code'], 0, 1,'C');
            $pdf->write1DBarcode( $row['serial_system'], 'c128', '', '', '', 15, 0.4, $style, 'N');



        }



        $pdf->Output('page number  ' . $id.'.pdf', 'I');



        $stmtUpdatePage = $this->db->prepare("UPDATE `serial_system_page`  SET   print =1  WHERE  page=?  ");
        $stmtUpdatePage->execute(array($id));


    }




    function record_quantity_correction(){

        $this->checkPermit('record_quantity_correction', $this->folder);
        $this->adminHeaderController($this->langControl($this->folder));


        require ($this->render($this->folder,'html','record_quantity_correction','php'));
        $this->adminFooterController();

    }



    public function processing_record_quantity_correction()
    {


        $table = 'serial_correct_location_deleted';
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $table.'.model', 'dt' => 0 ),
            array( 'db' => $table.'.code', 'dt' => 1 ),


            array( 'db' =>  $table.'.oldlocation', 'dt' => 2 ,
                'formatter' => function ($id, $row) {
                    return  $this->locationCoreect($id) ;
                }
            ),

            array( 'db' =>  $table.'.newlocation', 'dt' => 3 ,
                'formatter' => function ($id, $row) {
                    return  $this->locationCoreect($id) ;
                }
            ),

            array( 'db' =>  $table.'.date', 'dt' => 4 ,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),
            array( 'db' => 'user.username', 'dt' => 5 ),

            array(  'db' =>   $table.'.id', 'dt'=> 6)


        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = " inner JOIN user ON user.id = {$table}.userId   ";
        $whereAll = array("");


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));

    }


    function locationCoreect($data)
    {

        $data=json_decode($data,true);

        if ($data) {
            $html = "<table class='table table-bordered table-dark'><tr> <td>الموقع</td> <td>الكمية</td></tr>";
            foreach ($data as $out) {
                $html .= "<tr style='padding: 0' > <td style='padding: 0'>{$out['location']}</td> <td>{$out['quantity']}</td></trs>";
            }
            return $html .= "</table>";
        }else
        {
            return '';
        }

    }





    function data_code_print($code,$model=null)
    {


        if ($model==null)
        {
             $model=$this->model_code($code);
        }

        if ($model=='accessories')
        {
            $stmt=$this->db->prepare("SELECT  accessories.title,color_accessories.color ,color_accessories.img ,color_accessories.code FROM color_accessories INNER JOIN  accessories ON  accessories.id=color_accessories.id_item  WHERE color_accessories.code=? LIMIT  1");
            $stmt->execute(array($code));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            $result['size']='';

        }else if($model=='savers')
        {

            $stmt=$this->db->prepare("SELECT  product_savers.title,  product_savers.img,product_savers.color,product_savers.code FROM product_savers    WHERE product_savers.code=? LIMIT  1");
            $stmt->execute(array($code));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            $result['size']='';

        }else
        {

            if ($model == 'mobile')
            {

                $code_table='code';
                $color='color';
                $excel='excel';
            }else
            {
                $code_table='code_'.$model;
                $color='color_'.$model;
                $excel='excel_'.$model;
            }

            $stmt=$this->db->prepare("SELECT  {$model}.title,{$color}.color,{$color}.img,{$code_table}.size,{$code_table}.code FROM {$code_table} INNER JOIN  {$color} ON  {$color}.id={$code_table}.id_color INNER JOIN  {$model} ON {$model}.id={$color}.id_item    WHERE {$code_table}.code=? LIMIT  1");
            $stmt->execute(array($code));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
        }


        return $result;


    }

function normal_date()

{
    $stmt = $this->db->prepare("SELECT *FROM serial  ");
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {

       echo $normal_date=date('Y-m-d',$row['date']);
        $stmtUpdate = $this->db->prepare("UPDATE `serial`  SET   normal_date = ?  WHERE  code=? AND  serial=? ");
        $stmtUpdate->execute(array($normal_date,$row['code'],$row['serial']));
    }


}


}