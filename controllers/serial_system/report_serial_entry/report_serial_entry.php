<?php

trait report_serial_entry
{

    protected  $data_code=array();

    function __construct()
    {
        parent::__construct();
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject
    }




    function repet($flag)
    {
        if ($flag==0)
        {
            $this->setting->set('repet',1) ;
        }else
        {
            $this->setting->set('repet',2) ;
        }

    }


    function list_report_serial_entry()
    {

        $this->checkPermit('generation_serial',$this->folder);

        $this->adminHeaderController($this->langControl($this->folder));

        require ($this->render($this->folder,'report_serial_entry/html','list','php'));
        $this->adminFooterController();

    }


    function creat_page_serial()
    {


        $stmtpage = $this->db->prepare("SELECT `page` FROM serial_page    ORDER BY page DESC LIMIT 1");
        $stmtpage->execute();
        if ($stmtpage->rowCount() > 0) {
            $page = $stmtpage->fetch(PDO::FETCH_ASSOC)['page'] + 1;
            $stmt = $this->db->prepare("INSERT INTO `serial_page` ( page, userId, date) VALUE (?,?,?) ");
            $stmt->execute(array($page,$this->userid,time()));
        } else {
            $stmt = $this->db->prepare("INSERT INTO `serial_page` ( page, userId, date) VALUE (?,?,?) ");
            $stmt->execute(array(1,$this->userid,time()));
            $page =  1;

        }

        echo $page;
    }


    function add_report_serial_entry($id)
    {

        $this->checkPermit('add_report_serial_entry',  $this->folder);
        $this->adminHeaderController($this->langControl('add_report_serial_entry'));





        require($this->render($this->folder, 'report_serial_entry/html', 'add', 'php'));
        $this->adminFooterController();

    }




    function from_add($id)
    {


        $this->checkPermit('add_jard',  $this->folder);

        if (isset($_POST['submit'])) {

            try {

                $form = new  Form();


                $form->post('bill')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');

                $form->post('location')
                    ->val('strip_tags');

                $form->post('code')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');


                $form->post('serial')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');

                $form->post('type_enter')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');


                $form->post('spare_code')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();



                  $code=$data['code'];

                 $model = $this->model_code(trim($code));

                if ($model) {
                    $data['code'] = $code;
                    $data['model']=$model;

                    if ($model=='mobile')
                    {
                        $excel='excel';
                    }else
                    {
                        $excel='excel_'.$model;
                    }

                }
                else
                {
                    $stmt_spare_code=$this->db->prepare("SELECT *FROM spare_code WHERE  spare_code=? LIMIT 1");
                    $stmt_spare_code->execute(array($code));
                    if ($stmt_spare_code->rowCount() > 0)
                    {
                        $result=$stmt_spare_code->fetch(PDO::FETCH_ASSOC);
                        $data['model']  = $this->model_code(trim($result['code']));
                        $data['code'] = $result['code'];

                        $model= $data['model'];
                        $code= $data['code'];
                        if ($model=='mobile')
                        {
                            $excel='excel';
                        }else
                        {
                            $excel='excel_'.$model;
                        }
                    }
                }

                if ($data['model'] && $data['code']) {


                    if ($data['location'])
                    {
                        $stmtCheckLocationModel=$this->db->prepare("SELECT *FROM location_model WHERE model=? AND location=? ");
                        $stmtCheckLocationModel->execute(array($data['model'],$data['location']));
                        if ($stmtCheckLocationModel->rowCount() <= 0)
                        {
                            die('locationNotFound');
                        }

                    }




                    $stmtExcel=$this->db->prepare("SELECT quantity FROM  {$excel} WHERE  code=?");
                    $stmtExcel->execute(array($data['code']));
                     $excelResult= $stmtExcel->fetch(PDO::FETCH_ASSOC);

                     $serialEnter=$this->sum_serial_enter($data['code'],$data['model']);


                    if ((int)$serialEnter <  (int)$excelResult['quantity'] )
                    {

                        if ($data['spare_code']) {

                            $stmtSpareCode = $this->db->prepare("SELECT  * FROM  spare_code   WHERE spare_code=? AND model =? AND code=? LIMIT 1 ");
                            $stmtSpareCode->execute(array($data['spare_code'], $data['model'],$data['code']));
                            if ($stmtSpareCode->rowCount() <= 0) {
                                $this->addSpareCode($data['spare_code'], $data['model'],$data['code'],false);
                            }

                        }

                    $stmtUpdatePage = $this->db->prepare("UPDATE `serial_page`  SET   from_date =?  WHERE  page=?  AND    userId=? AND  from_date = 0");
                    $stmtUpdatePage->execute(array(time(), $id, $this->userid));

                    $stmtUpdatePage2 = $this->db->prepare("UPDATE `serial_page`  SET   to_date =?  WHERE  page=?  AND    userId=?  ");
                    $stmtUpdatePage2->execute(array(time(), $id, $this->userid));



                    $duplication=true;


                        $stmtCh = $this->db->prepare("SELECT * FROM serial WHERE serial=? AND  model=?  ");
                        $stmtCh->execute(array(trim($data['serial']),$model));
                        if ($stmtCh->rowCount() > 0) {

                           if ($this->check_serial_required($code,'serial_duplication',$model)==false)
                           {
                               $duplication=false;
                           }

                        }

                    if ($duplication==true){
                    if ($this->setting->get('repet') == 2) {

                        $stmt = $this->db->prepare("INSERT INTO `serial` ( page,bill, code, serial, type_enter, quantity, userId, date, model, location) VALUE (?,?,?,?,?,?,?,?,?,?) ");
                        $stmt->execute(array($id, trim($data['bill']), trim($data['code']), $data['serial'], $data['type_enter'], 1, $this->userid, time(), $data['model'], $data['location']));
                        $this->deleteCodeFromSerialConform(trim($data['code']), $data['model']);
                        echo 'true';
                    } else {

                        $stmt = $this->db->prepare("SELECT * FROM serial WHERE code =? AND  serial=? AND  model=?  ");
                        $stmt->execute(array(trim($data['code']), $data['serial'], $data['model']));
                        if ($stmt->rowCount() <= 0) {

                            $stmt = $this->db->prepare("INSERT INTO `serial` ( page,bill, code, serial, type_enter, quantity, userId, date, model,location) VALUE (?,?,?,?,?,?,?,?,?,?) ");
                            $stmt->execute(array($id, trim($data['bill']), trim($data['code']), $data['serial'], $data['type_enter'], 1, $this->userid, time(), $data['model'], $data['location']));
                            $this->deleteCodeFromSerialConform(trim($data['code']), $data['model']);

                        }
                        echo 'true';
                    }
                 }else
                    {
                        echo 'no_duplication';
                    }




                }else
                {

                    $stmt = $this->db->prepare("INSERT INTO `serial_case_2` ( page,bill, code, serial, type_enter, quantity, userId, date, model,location) VALUE (?,?,?,?,?,?,?,?,?,?) ");
                    $stmt->execute(array($id, trim($data['bill']), trim($data['code']), $data['serial'], $data['type_enter'], 1, $this->userid, time(), $data['model'], $data['location']));
                    echo 'over';
                }


                }else{
                    echo 'not_code_found';
                }

            } catch (Exception $e) {

                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }

        }

    }




    function from_addOLd()
    {


        $this->checkPermit('add_report_serial_entry',  $this->folder);


        if (isset($_POST['submit'])) {

            try {

                $form = new  Form();
                $form->post('bill')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');

                $form->post('code')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');

                $form->post('serial')
                    ->val('is_array', $this->langControl('required'))
                    ->val('strip_tags');

                $form->post('type_enter')
                    ->val('is_array', $this->langControl('required'))
                    ->val('strip_tags');

                $form->post('new_page')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');

                $form->post('time_taken')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();


                $serial = json_decode($data['serial'], true);
                $type_enter = json_decode($data['type_enter'], true);

                $data['userid'] = $this->userid;
                $data['date'] = time();
                $data['model'] = $this->model_code(trim($data['code']));

                if ($data['model']) {

                    $time_taken = $this->time_reg($data['time_taken']);


                    if ($data['new_page'] == 1) {

                        $stmtpage = $this->db->prepare("SELECT `page` FROM serial    ORDER BY page DESC LIMIT 1");
                        $stmtpage->execute();
                        if ($stmtpage->rowCount() > 0) {
                            $page = $stmtpage->fetch(PDO::FETCH_ASSOC)['page'] + 1;
                            $_SESSION['page_serial'] = $page;
                        } else {
                            $stmt2 = $this->db->prepare("SELECT `page` FROM serial   ORDER BY page DESC LIMIT 1");
                            $stmt2->execute();
                            $page = $stmt2->fetch(PDO::FETCH_ASSOC)['page'] + 1;
                            $_SESSION['page_serial'] = $page;
                        }

                    } else {
                        $page = $_SESSION['page_serial'];
                    }

                    foreach ($serial as $key => $sel) {

                        if ($sel) {

                            if ($type_enter[$key]) {
                                $type_etr = $type_enter[$key];
                            } else {
                                $type_etr = 'ادخال يدوي';
                            }


                            $sel = trim($sel);


                            if ($this->setting->get('repet') == 2) {
                                $stmt = $this->db->prepare("INSERT INTO `serial` ( page,bill, code, serial, type_enter, quantity, userId, date, model,time_taken) VALUE (?,?,?,?,?,?,?,?,?,?) ");
                                $stmt->execute(array($page, trim($data['bill']), trim($data['code']), $sel, $type_etr, 1, $this->userid, time(), $data['model'], $time_taken));
                                $this->deleteCodeFromSerialConform(trim($data['code']), $data['model']);

                            } else {

                                $stmt = $this->db->prepare("SELECT * FROM serial WHERE code =? AND  serial=? AND  model=? AND bill =? ");
                                $stmt->execute(array(trim($data['code']), $sel, $data['model'], trim($data['bill'])));
                                if ($stmt->rowCount() <= 0) {
                                    $stmt = $this->db->prepare("INSERT INTO `serial` ( page,bill, code, serial, type_enter, quantity, userId, date, model,time_taken) VALUE (?,?,?,?,?,?,?,?,?,?) ");
                                    $stmt->execute(array($page, trim($data['bill']), trim($data['code']), $sel, $type_etr, 1, $this->userid, time(), $data['model'], $time_taken));
                                    $this->deleteCodeFromSerialConform(trim($data['code']), $data['model']);

                                }


                            }

                        }
                    }
                    echo 'true';
                }else
                {
                    echo 'not_code_found';
                }

            } catch (Exception $e) {

                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }

        }

    }


    function time_reg($time)
    {

        if ($time <= 59)
        {
            return    $time . '  ثانية ';
        }else {


            $H = floor($time / 3600);

            if ($H >= 1 )
            {
                return   $H . '  ساعة ' ;
            }else
            {
                $i = ($time / 60) % 60;
                return    $i . '  دقيقة ' ;
            }
        }

    }







    function insert_data($s=1)
    {


            $date_now_js = $_GET['date_now'];
            $time = date('s', time());
            $t = $time - $date_now_js;

            if ($t <= $s) {
                echo 'جهاز قارئ الباركود';

            } else {

                echo 'ادخال يدوي';
            }

        }




    public function processing_report_serial_entry()
    {




        $table = $this->serial_page;
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $table.'.page', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/details_page/{$d}'>{$d}</a>";
                }
            ),

            array( 'db' => 'user.username', 'dt' => 1 ),


            array( 'db' =>  $table.'.from_date', 'dt' => 2 ,
                'formatter' => function ($id, $row) {
                    $from_date= strtotime(date('H:i:s', $id));
                    $to_date= strtotime(date('H:i:s', $row[5]));
                    $diff = $from_date - $to_date;
                    return  $this->time_reg(abs($diff));

                }
            ),

            array( 'db' =>  $table.'.date', 'dt' => 3 ,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),
            array( 'db' =>  $table.'.date', 'dt' => 4 ,
                'formatter' => function ($id, $row) {

                    $date_add=strtotime('+1 day', $id);

                    if ($date_add >= time())
                    {
                        return "<a href='".url.'/'.$this->folder."/edit_report_serial_entry/{$row[0]}'><i class='fa fa-edit'></i></a>";
                    }
                }
            ),
            array(  'db' =>   $table.'.to_date', 'dt'=> 5),
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
        if ($this->admin($this->userid)) {
            $whereAll = array("");
        }else
        {
            $whereAll = array(" {$table}.userId = {$this->userid}");
        }

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));

    }






    function details_page($id)
    {

        $this->checkPermit('details_page',$this->folder);
        $this->adminHeaderController($this->langControl($this->folder));



        require ($this->render($this->folder,'report_serial_entry/html','details_page','php'));
        $this->adminFooterController();

    }


    public function processing_details_page($id)
    {


        $table = $this->serial;
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $table.'.bill', 'dt' => 0),
            array( 'db' => $table.'.code', 'dt' => 1),
            array( 'db' => $table.'.serial', 'dt' => 2 ),
            array( 'db' => $table.'.location', 'dt' => 3 ),
            array( 'db' => $table.'.type_enter', 'dt' => 4),
            array( 'db' => 'user.username', 'dt' => 5 ),

            array( 'db' =>  $table.'.date', 'dt' => 6 ,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),

            array( 'db' =>  $table.'.date', 'dt' => 7 ,
                'formatter' => function ($id, $row) {
                   return "<button class='btn btn-danger' onclick='delete_serial({$row[8]})'><i class='fa fa-trash'></i> </button>";
                }
            ),

            array(  'db' =>   $table.'.id', 'dt'=> 8)


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




    function  list_material()
    {

        $this->checkPermit('details_page',$this->folder);
        $this->adminHeaderController($this->langControl($this->folder));



        require ($this->render($this->folder,'report_serial_entry/html','material','php'));
        $this->adminFooterController();

    }




function get_serial($code,$model)
{


        $stmt  = $this->db->prepare("SELECT   *  FROM serial  WHERE code=? AND  model=?  ");
        $stmt ->execute(array($code,$model));


       /*  اتم ايقافة حتى كل السيريلات تظهر للموضف المدخلها والي ما مدخلها وما يشتبة    */
//    if ($this->admin($this->userid)) {
//        $stmt  = $this->db->prepare("SELECT   *  FROM serial  WHERE code=? AND  model=?  ");
//        $stmt ->execute(array($code,$model));
//    }else
//    {
//        $stmt  = $this->db->prepare("SELECT    *  FROM serial  WHERE code=? AND  model=? AND  userId =?  ");
//        $stmt ->execute(array($code,$model,$this->userid));
//    }

    $html = '';
  if ($stmt->rowCount() > 0) {

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       if ($this->permit('delete_serial',$this->folder))
       {
           $html .= "<div class='list_serial'  style='cursor: pointer'  data-toggle='tooltip' data-placement='top' title='{$row['note']}' id='serial_{$row['id']}'>  {$row['serial']}  <span onclick='delete_serial({$row['id']})'><i class='fa fa-times-circle'></i> </span> </div>";
       }
      }
  }else
  {
      $html .= "<div class='list_serial'>لا يوجد سيريال</div>";
  }
   echo $html;
}


function get_serialWithOutDelete($code,$model)
{

    if ($this->admin($this->userid)) {
        $stmt  = $this->db->prepare("SELECT   *  FROM serial  WHERE code=? AND  model=?  ");
        $stmt ->execute(array($code,$model));
    }else
    {
        $stmt  = $this->db->prepare("SELECT    *  FROM serial  WHERE code=? AND  model=? AND  userId =?  ");
        $stmt ->execute(array($code,$model,$this->userid));
    }

    $html = '';
  if ($stmt->rowCount() > 0) {

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       if ($this->permit('delete_serial',$this->folder))
       {
           $html .= "<div class='list_serial'  style='cursor: pointer'  data-toggle='tooltip' data-placement='top' title='{$row['note']}' id='serial_{$row['id']}'>  {$row['serial']}   </div>";
       }
      }
  }else
  {
      $html .= "<div class='list_serial'>لا يوجد سيريال</div>";
  }
   echo $html;
}





    function info_code($code=null)
    {

        if (isset($_GET['code']))
        {
            $code=$_GET['code'];
        }


        $model = $this->model_code(trim($code));
        if ($model) {

            $data= $this->data_code($code,$model);
            $data['model'] =$model;
            $data['location'] =$this->list_location_no_html($code,$model);
            $data['num_serial'] =$this->sum_serial_enter($code,$model);
            require($this->render($this->folder, 'report_serial_entry/html', 'data', 'php'));

        }else
        {
            $stmt_spare_code=$this->db->prepare("SELECT *FROM spare_code WHERE  spare_code=? LIMIT 1");
            $stmt_spare_code->execute(array($code));
            if ($stmt_spare_code->rowCount() > 0)
            {
                $result=$stmt_spare_code->fetch(PDO::FETCH_ASSOC);
                $model = $this->model_code(trim($result['code']));
                $data= $this->data_code($result['code'],$model);
                $data['model'] =$model;
                $data['location'] =$this->list_location_no_html($result['code'],$model);
                $data['num_serial'] =$this->sum_serial_enter($result['code'],$model);



                require($this->render($this->folder, 'report_serial_entry/html', 'data', 'php'));
            }
        }

    }




function data_code($code,$model=null)
{


    if ($model==null)
    {
         $model=$this->model_code($code);
    }

    if ($model=='accessories')
    {
        $stmt=$this->db->prepare("SELECT  accessories.title,accessories.id_cat,excel_accessories.quantity,color_accessories.color ,color_accessories.img ,color_accessories.code FROM color_accessories INNER JOIN  accessories ON  accessories.id=color_accessories.id_item left JOIN  excel_accessories ON excel_accessories.code=color_accessories.code WHERE color_accessories.code=? LIMIT  1");
        $stmt->execute(array($code));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        $result['size']='';

    }else if($model=='savers')
    {

        $stmt=$this->db->prepare("SELECT  product_savers.title,  product_savers.img,excel_savers.quantity,product_savers.color,product_savers.code FROM product_savers    left JOIN  excel_savers ON excel_savers.code=product_savers.code WHERE product_savers.code=? LIMIT  1");
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

        $stmt=$this->db->prepare("SELECT  {$model}.title,{$model}.id_cat,{$color}.color,{$color}.img,{$code_table}.size,{$code_table}.code,{$excel}.quantity FROM {$code_table} INNER JOIN  {$color} ON  {$color}.id={$code_table}.id_color INNER JOIN  {$model} ON {$model}.id={$color}.id_item left JOIN  {$excel} ON {$excel}.code={$code_table}.code   WHERE {$code_table}.code=? LIMIT  1");
        $stmt->execute(array($code));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
    }


   return $result;


}

    function list_serial_deleted()
    {

        $this->checkPermit('list_serial_deleted',$this->folder);
        $this->adminHeaderController($this->langControl($this->folder));



        require ($this->render($this->folder,'report_serial_entry/html','serial_deleted','php'));
        $this->adminFooterController();

    }


    public function processing_serial_deleted()
    {


        $table = $this->serial_delete;
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $table.'.bill', 'dt' => 0),
            array( 'db' => $table.'.code', 'dt' => 1),
            array( 'db' => $table.'.serial', 'dt' => 2 ),
            array( 'db' => $table.'.type_enter', 'dt' => 3 ),
            array( 'db' => 'user.username', 'dt' => 4 ),

            array( 'db' =>  $table.'.date', 'dt' => 5 ,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),

            array(  'db' =>   $table.'.id', 'dt'=> 6)


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

    function edit_report_serial_entry($id)
    {

        $this->checkPermit('edit_report_serial_entry',  $this->folder);
        $this->adminHeaderController($this->langControl('edit_report_serial_entry'));


        if (!$this->admin($this->userid))
        {
            $stmtResult = $this->db->prepare("SELECT  * FROM serial_page   WHERE page=? AND userId=?");
            $stmtResult->execute(array($id,$this->userid));
            if ($stmtResult->rowCount()  < 1)
            {
                die('
                 <br>
                    <div class="alert alert-danger" role="alert">
                       <span>تحاول التعديل على رقم جرد غير خاص بك </span>  //  <a href="'.url.'/'.$this->folder.'/list_report_serial_entry" class="btn btn-warning btn-sm  ">رجوع</a> 
                    </div>
                    
                    '
                );
            }
        }




        require($this->render($this->folder, 'report_serial_entry/html', 'edit', 'php'));
        $this->adminFooterController();

    }



    function from_edit($id)
    {


        $this->checkPermit('add_jard',  $this->folder);

        if (isset($_POST['submit'])) {

            try {

                $form = new  Form();


                $form->post('bill')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');

                $form->post('location')
                    ->val('strip_tags');

                $form->post('code')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');


                $form->post('serial')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');

                $form->post('type_enter')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();



                $code=$data['code'];

                $model = $this->model_code(trim($code));

                if ($model) {
                    $data['code'] = $code;
                    $data['model']=$model;

                    if ($model=='mobile')
                    {
                        $excel='excel';
                    }else
                    {
                        $excel='excel_'.$model;
                    }

                }
                else
                {
                    $stmt_spare_code=$this->db->prepare("SELECT *FROM spare_code WHERE  spare_code=? LIMIT 1");
                    $stmt_spare_code->execute(array($code));
                    if ($stmt_spare_code->rowCount() > 0)
                    {
                        $result=$stmt_spare_code->fetch(PDO::FETCH_ASSOC);
                        $data['model']  = $this->model_code(trim($result['code']));
                        $data['code'] = $result['code'];

                        $model= $data['model'];
                        $code= $data['code'];
                        if ($model=='mobile')
                        {
                            $excel='excel';
                        }else
                        {
                            $excel='excel_'.$model;
                        }
                    }
                }

                if ($data['model'] && $data['code']) {
                    if ($data['location'])
                    {
                        $stmtCheckLocationModel=$this->db->prepare("SELECT *FROM location_model WHERE model=? AND location=? ");
                        $stmtCheckLocationModel->execute(array($data['model'],$data['location']));
                        if ($stmtCheckLocationModel->rowCount() <= 0)
                        {
                            die('locationNotFound');
                        }

                    }


                    $stmtExcel=$this->db->prepare("SELECT quantity FROM  {$excel} WHERE  code=?");
                    $stmtExcel->execute(array($data['code']));
                    $excelResult= $stmtExcel->fetch(PDO::FETCH_ASSOC);

                    $serialEnter=$this->sum_serial_enter($data['code'],$data['model']);


                    if ((int)$serialEnter <  (int)$excelResult['quantity'] )
                    {

                        if ($data['spare_code']) {

                            $stmtSpareCode = $this->db->prepare("SELECT  * FROM  spare_code   WHERE spare_code=? AND model =? AND code=? LIMIT 1 ");
                            $stmtSpareCode->execute(array($data['spare_code'], $data['model'],$data['code']));
                            if ($stmtSpareCode->rowCount() <= 0) {
                                $this->addSpareCode($data['spare_code'], $data['model'],$data['code']);
                            }

                        }

                        $stmtUpdatePage = $this->db->prepare("UPDATE `serial_page`  SET   from_date =?  WHERE  page=?  AND    userId=? AND  from_date = 0");
                        $stmtUpdatePage->execute(array(time(), $id, $this->userid));

                        $stmtUpdatePage2 = $this->db->prepare("UPDATE `serial_page`  SET   to_date =?  WHERE  page=?  AND    userId=?  ");
                        $stmtUpdatePage2->execute(array(time(), $id, $this->userid));


                        $duplication=true;


                        $stmtCh = $this->db->prepare("SELECT * FROM serial WHERE serial=? AND  model=?  ");
                        $stmtCh->execute(array(trim($data['serial']),$model));
                        if ($stmtCh->rowCount() > 0) {

                            if ($this->check_serial_required($code,'serial_duplication',$model)==false)
                            {
                                $duplication=false;
                            }

                        }

                        if ($duplication==true){
                            if ($this->setting->get('repet') == 2) {

                                $stmt = $this->db->prepare("INSERT INTO `serial` ( page,bill, code, serial, type_enter, quantity, userId, date, model, location) VALUE (?,?,?,?,?,?,?,?,?,?) ");
                                $stmt->execute(array($id, trim($data['bill']), trim($data['code']), $data['serial'], $data['type_enter'], 1, $this->userid, time(), $data['model'], $data['location']));
                                $this->deleteCodeFromSerialConform(trim($data['code']), $data['model']);
                                echo 'true';
                            } else {

                                $stmt = $this->db->prepare("SELECT * FROM serial WHERE code =? AND  serial=? AND  model=?  ");
                                $stmt->execute(array(trim($data['code']), $data['serial'], $data['model']));
                                if ($stmt->rowCount() <= 0) {

                                    $stmt = $this->db->prepare("INSERT INTO `serial` ( page,bill, code, serial, type_enter, quantity, userId, date, model,location) VALUE (?,?,?,?,?,?,?,?,?,?) ");
                                    $stmt->execute(array($id, trim($data['bill']), trim($data['code']), $data['serial'], $data['type_enter'], 1, $this->userid, time(), $data['model'], $data['location']));
                                    $this->deleteCodeFromSerialConform(trim($data['code']), $data['model']);

                                }
                                echo 'true';
                            }
                        }else
                        {
                            echo 'no_duplication';
                        }




                    }else
                    {

                        $stmt = $this->db->prepare("INSERT INTO `serial_case_2` ( page,bill, code, serial, type_enter, quantity, userId, date, model,location) VALUE (?,?,?,?,?,?,?,?,?,?) ");
                        $stmt->execute(array($id, trim($data['bill']), trim($data['code']), $data['serial'], $data['type_enter'], 1, $this->userid, time(), $data['model'], $data['location']));
                        echo 'over';
                    }


                }else{
                    echo 'not_code_found';
                }

            } catch (Exception $e) {

                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }

        }

    }


    function codeDetails($model,$code)
    {


        $data=array();
        if ($model=='accessories')
        {
            $stmt=$this->db->prepare("SELECT *  FROM  color_accessories    WHERE  code=? LIMIT 1");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0)
            {
                $result=$stmt->fetch(PDO::FETCH_ASSOC);
                $data['code']=$result['code'];
                $data['color']=$result['color'];
                $data['size']=$result['code'];
            }
        }else if ($model == 'savers')
        {

            $stmt=$this->db->prepare("SELECT *  FROM  product_savers    WHERE  code=? LIMIT 1");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0)
            {
                $result=$stmt->fetch(PDO::FETCH_ASSOC);
                $data['code']=$result['code'];
                $data['color']=$result['color'];
                $data['size']=$result['code'];
            }
        }else
        {
            if ($model =='mobile')
            {

                $code_table='code';
                $color='color';

            }else
            {
                $code_table='code_'.$model;
                $color='color_'.$model;
            }

            $stmt=$this->db->prepare("SELECT {$code_table}.code,{$code_table}.size,{$color}.color,{$color}.id_item FROM {$code_table} INNER JOIN {$color} ON {$color}.id={$code_table}.id_color WHERE {$code_table}.code=? LIMIT 1");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0)
            {
                $result=$stmt->fetch(PDO::FETCH_ASSOC);
                $data['code']=$result['code'];
                $data['color']=$result['color'];
                $data['size']=$result['size'];
            }
        }

        if (!empty($data))
        {
            echo json_encode($data);
        }


    }





}