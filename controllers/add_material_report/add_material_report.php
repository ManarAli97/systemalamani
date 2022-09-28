<?php

class add_material_report extends Controller
{


    function __construct()
    {
        parent::__construct();
        $this->table='add_material_report';
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `quantity` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `location` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `userid` int(11) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        return  $this->db->cht(array($this->table));

    }


    function location_list()
    {


        if ($this->handleLogin())
        {
            $code = trim($_GET['code']);
            $cat = trim($_GET['cat']);


            $stmt = $this->db->prepare("SELECT *FROM `location` WHERE `code`=? AND `model` =? ");
            $stmt->execute(array($code,$cat));

            if ($stmt->rowCount()>0) {


                $html = '<select class="custom-select mr-sm-2" name="location" id="location_s" required><option selected disabled value="" >اختر موقع</option>';
                if ($stmt->rowCount() > 0) {
                    $c = 0;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                            $html .= "<option value='{$row['id']}'>{$row['location']}= كمية ({$row['quantity']})</option>";


                        $c++;

                    }

                }

                echo $html .= '</select>';
            }

        }


    }



    function add()
    {

        $this->checkPermit('add_material_report',$this->folder);
        $this->adminHeaderController($this->langControl('add_material_report'));




        require ($this->render($this->folder,'html','add','php'));
        $this->adminFooterController();

    }



    function index()
    {

        $this->checkPermit('add_material_report',$this->folder);
        $this->adminHeaderController($this->langControl('add_material_report'));



        $date=null;
        $todate=null;

        $from_date_stm=null;
        $to_date_stm=null;

        if (isset($_GET['date'])&&isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);

        }


        require ($this->render($this->folder,'html','index','php'));
        $this->adminFooterController();

    }




    public function processing($from_date_stm=null,$to_date_stm=null)
    {


        $table = $this->table;
        $primaryKey = $table.'.id';

        $columns = array(

            array(  'db' =>$table.'.model', 'dt'=>0),
            array(  'db' => $table.'.code', 'dt'=>1),
           array(  'db' =>  $table.'.location', 'dt'=>2,
                'formatter'=> function($d,$row)
                {
                    return $this->tamayaz_locations($d);
                }
            ),

            array(  'db' => $table.'.quantity', 'dt'=>3),

            array(
                'db' => $table.'.userid',
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    return $this->UserInfo($id);
                }
            ),

            array(
                'db' => $table.'.date',
                'dt' => 5,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s A',$id);
                }
            ),


            array(  'db' => $table.'.note', 'dt'=>6),
            array(  'db' => $table.'.id', 'dt'=>7),



        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );




        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array();

        }else{
            $whereAll = array("{$table}.date BETWEEN {$from_date_stm} AND {$to_date_stm}");
        }

        $result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, null, null, $whereAll,'');

        echo json_encode($result);

    }



    function add_data()
    {
        if($this->handleLogin())
        {
			
        	
            $model=trim($_POST['cat']);
            $code=trim($_POST['code']);

            $quantity=trim($_POST['quantity']);
            $note=trim($_POST['note']);
        
			$this->AddToTraceByFunction($this->userid,'add_material_report','add_data/'.$model.'/'.$code.'/'.$quantity.'/'.$note);
        
            if ($model == 'mobile') {
                $excel = 'excel';
            } else  {
                $excel = 'excel_'.$model;
            }


            $stmtx1 = $this->db->prepare("SELECT *FROM `{$excel}` WHERE `code`=?  ");
            $stmtx1->execute(array($code));
            if($stmtx1->rowCount() > 0) {

                if (isset($_POST['location'])) {
                    $location=trim($_POST['location']);
                $result = $stmtx1->fetch(PDO::FETCH_ASSOC);
                $stmtLocation = $this->db->prepare("SELECT *FROM `location` WHERE code=? AND id= ?  AND model=? ");
                $stmtLocation->execute(array($code, $location, $model));
                if ($stmtLocation->rowCount() > 0) {

                    $location_result = $stmtLocation->fetch(PDO::FETCH_ASSOC);

                    $stmt_excel = $this->db->prepare("UPDATE  {$excel} SET  `quantity`=quantity + $quantity,`date`=? WHERE  code=?");
                    $stmt_excel->execute(array(time(), $code));
                	if ($stmt_excel->rowCount() > 0) {

                        $this->Add_to_sync_schedule($code, $model, 'quantity_adjustment', ' ', 'اضافة يدوي');


                        $stmt_location = $this->db->prepare("UPDATE  location SET  `quantity`=quantity+ $quantity ,`date`=?  WHERE location=? AND code=? AND model=?");
                        $stmt_location->execute(array(time(), $location_result['location'], $code, $model));
                        if($stmt_location->rowCount()  > 0)
                        {
                            $this->filter_location_tracking_quantity($code,$model,$location_result['location'],$quantity,'   اضافة مواد  - رقم3','+');

                        }else
                        {
                            $this->filter_location_error_quantity($code,$model,$location_result['location'],$quantity,'   اضافة مواد  - رقم الخطا 3','+');

                        }

                        $stmt = $this->db->prepare("INSERT INTO `add_material_report` (code, location, model,quantity,userid,date,note) VALUE (?,?,?,?,?,?,?) ");
                        $stmt->execute(array($code, $location_result['location'], $model, $quantity, $this->userid, time(), $note));
                        if ($stmt->rowCount() > 0) {

                            $stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,`number_bill`) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                            $stmt_user_add_excel->execute(array($code, $quantity, $result['price_dollars'], $this->userid, $_SESSION['usernamelogin'], time(), date('Y-m-d h:i A', time()), '', 'اضافة', $model, $note));


                            echo '1';
                        }
                    }
                } else {
                    echo 'not_found_location';
                }
            }else
                {

                    $stmt_excel = $this->db->prepare("UPDATE  {$excel} SET  `quantity`=quantity + $quantity,`date`=? WHERE  code=?");
                    $stmt_excel->execute(array(time(), $code));
                    if ($stmt_excel->rowCount() > 0) {

                        $stmtChCodeConform = $this->db->prepare("SELECT *FROM location_confirm WHERE code =? AND model=?");
                        $stmtChCodeConform->execute(array($code, $model));
                        if ($stmtChCodeConform->rowCount() > 0) {
                            $stmtExcel_conform = $this->db->prepare("UPDATE location_confirm SET  quantity=quantity+$quantity,`date`=?  WHERE code =? AND  model=?");
                            $stmtExcel_conform->execute(array(time(), $code, $model));
                            if($stmtExcel_conform->rowCount() <=0)
                            {
                                $this->filter_error_quantity( $code, $model,$quantity,' اضافة مواد   - رقم الخطا 14');
                            }
                        } else {

                            $stmtExcel_conform = $this->db->prepare("INSERT INTO  location_confirm (quantity,code,model,`date`,userid)  values (?,?,?,?,?)");
                            $stmtExcel_conform->execute(array(1, $code, $model, time(), $this->userid));
                            if($stmtExcel_conform->rowCount() <=0)
                            {
                                $this->filter_error_quantity( $code, $model,$quantity,' اضافة مواد   - رقم الخطا 15');
                            }
                        }
                        echo '1';
                    }else
                    {
                        echo 'not_found_code';//not found code
                    }
                    $this->Add_to_sync_schedule($code,$model,'quantity_adjustment',' ','اضافة يدوي  controllers\add_material_report\add_material_report.php 251'.$this->UserInfo($this->userid));


                }

            }else{
                echo 'not_found_code';//not found code
            }

        }
    }













}