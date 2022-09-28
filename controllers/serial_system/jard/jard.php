<?php

trait jard
{

    protected  $data_code=array();

    function __construct()
    {
        parent::__construct();
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject
    }

    function required_location_jard($flag)
    {
        if ($flag==0)
        {
            $this->setting->set('required_location_jard',0) ;
        }else
        {
            $this->setting->set('required_location_jard',1) ;
        }

    }


    function repet_jard($flag)
    {
        if ($flag==0)
        {
            $this->setting->set('repet',1) ;
        }else
        {
            $this->setting->set('repet',2) ;
        }

    }


    function list_jard()
    {

        $this->checkPermit('generation_serial',$this->folder);

        $this->adminHeaderController($this->langControl($this->folder));

        require ($this->render($this->folder,'jard/html','list','php'));
        $this->adminFooterController();

    }



    function add_jard($id)
    {

        $this->checkPermit('add_jard',  $this->folder);
        $this->adminHeaderController($this->langControl('add_jard'));


        require($this->render($this->folder, 'jard/html', 'add', 'php'));
        $this->adminFooterController();

    }


    function creat_page_jard()
    {


        $stmtpage = $this->db->prepare("SELECT `page` FROM jard_page    ORDER BY page DESC LIMIT 1");
        $stmtpage->execute();
        if ($stmtpage->rowCount() > 0) {
            $page = $stmtpage->fetch(PDO::FETCH_ASSOC)['page'] + 1;
            $stmt = $this->db->prepare("INSERT INTO `jard_page` ( page, userId, date) VALUE (?,?,?) ");
            $stmt->execute(array($page,$this->userid,time()));
        } else {
            $stmt = $this->db->prepare("INSERT INTO `jard_page` ( page, userId, date) VALUE (?,?,?) ");
            $stmt->execute(array(1,$this->userid,time()));
            $page =  1;

        }

        echo $page;
    }



    function from_add_jard($id)
    {


        $this->checkPermit('add_jard',  $this->folder);

        if (isset($_POST['submit'])) {

            try {

                $form = new  Form();

                if ($this->setting->get('required_location_jard') == 1){
                    $form->post('location')
                        ->val('is_empty', $this->langControl('required'))
                        ->val('strip_tags');
                      }

                $form->post('serial')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');

                $form->post('type_enter')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');

                /*   duplication = في حال السيريال مكرر لاكثر من باركود عند الجر يظهر الباركودات ويتم اختيار باركود  */
                $form->post('duplication')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $serial=trim($data['serial']);



                if (!empty($data['duplication']))
                {
                    $stmtpage = $this->db->prepare("SELECT  * FROM serial   WHERE serial=? AND code=?");
                    $stmtpage->execute(array($serial,$data['duplication']));
                }else
                {
                    $stmtpage = $this->db->prepare("SELECT  * FROM serial   WHERE serial=? ");
                    $stmtpage->execute(array($serial));
                }

                if ($stmtpage->rowCount() > 0) {


                    $stmtUpdatePage = $this->db->prepare("UPDATE `jard_page`  SET   from_date =? ,to_date=? WHERE  page=?  AND    userId=? AND  from_date = 0");
                    $stmtUpdatePage->execute(array(time(),time(),$id,$this->userid));


                    $stmtChshort_time_start=$this->db->prepare("SELECT *FROM jardtime WHERE page=?    ");
                    $stmtChshort_time_start->execute(array($id));
                    if ($stmtChshort_time_start->rowCount()>0) {

                        $stmtUpdatePageshort_time_start = $this->db->prepare("UPDATE `jardtime`  SET   from_date =?  WHERE  page=?   AND  from_date = 0");
                        $stmtUpdatePageshort_time_start->execute(array(time(), $id));

                        $stmtshort_time_start = $this->db->prepare("SELECT *FROM jard_page WHERE page=?    ");
                        $stmtshort_time_start->execute(array($id));
                        if ($stmtshort_time_start->rowCount() > 0) {

                            $r_short_time_start = $stmtshort_time_start->fetch(PDO::FETCH_ASSOC);

                            if (time() < strtotime("+30 minutes", $r_short_time_start['to_date'])) {
                                $stmtUpdatePageshort_time_start = $this->db->prepare("UPDATE `jardtime`  SET   to_date =?  WHERE  page=?  ORDER BY id DESC  LIMIT 1");
                                $stmtUpdatePageshort_time_start->execute(array(time(), $id));
                            }else
                            {
                                $stmtInsertTimePAge = $this->db->prepare("INSERT INTO  `jardtime` ( page, userId, from_date, to_date, date) values (?,?,?,?,?)");
                                $stmtInsertTimePAge->execute(array($id,$this->userid,time(),time(),time() ));
                            }
                        }

                    }else
                    {
                        $stmtInsertTimePAge = $this->db->prepare("INSERT INTO  `jardtime` ( page, userId, from_date, to_date, date) values (?,?,?,?,?)");
                        $stmtInsertTimePAge->execute(array($id,$this->userid,time(),time(),time() ));

                    }

                    $stmtUpdatePage2 = $this->db->prepare("UPDATE `jard_page`  SET   to_date =?  WHERE  page=?  AND    userId=?  ");
                    $stmtUpdatePage2->execute(array(time(),$id,$this->userid));


                    $result= $stmtpage->fetch(PDO::FETCH_ASSOC);

                    $serial_data= $this->data_code($result['code'],$result['model']);
                    $serial_data['model']=$result['model'];



                    if ($this->setting->get('required_location_jard') == 0){
                        $data['location']='';

                        $data['location_quantity']=0;
                    }else
                    {


                        $stmtCheckLocationModel=$this->db->prepare("SELECT *FROM location_model WHERE model=? AND location=? ");
                        $stmtCheckLocationModel->execute(array($result['model'],$data['location']));
                        if ($stmtCheckLocationModel->rowCount() <= 0)
                        {
                            die('locationNotFound');
                        }

                        $data['location_quantity']=$this->location_quantity($result['code'],$result['model'],$data['location']);
                    }

                    $data['location_quantity_all']=$this->location_quantity_all($result['code'],$result['model']);

                    $stmtCh=$this->db->prepare("SELECT  * FROM jard   WHERE    code =? AND  serial=? AND model=? AND page=?");
                    $stmtCh->execute(array($serial_data['code'],$data['serial'],$serial_data['model'],$id));
                    if ($stmtCh->rowCount() > 0)
                    {
                          echo 'enterSerial';
                    }else{
                        $stmt = $this->db->prepare("INSERT INTO `jard` ( page, code, serial, type_enter, quantity,excel_quantity, model, userId,`date`,location,location_quantity,location_quantity_all) VALUE (?,?,?,?,?,?,?,?,?,?,?,?) ");
                        $stmt->execute(array($id,$serial_data['code'],$data['serial'],$data['type_enter'],1,$serial_data['quantity'],$serial_data['model'],$this->userid,time(),$data['location'],$data['location_quantity'],$data['location_quantity_all']));
                        echo 'true';

                    }

            }else{
                    echo 'er_serial';
                }

            } catch (Exception $e) {

                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }

        }

    }

    function location_quantity_all($code,$model)
    {

        $stmt  = $this->db->prepare("SELECT  SUM(quantity) as q FROM location  WHERE code=? AND  model=?  ");
        $stmt ->execute(array($code,$model));

        return $stmt ->fetch(PDO::FETCH_ASSOC)['q'] ;
    }

    function location_quantity($code,$model,$location)
    {

        $stmt  = $this->db->prepare("SELECT  SUM(quantity) as q FROM location  WHERE code=? AND  model=? AND location=?");
        $stmt ->execute(array($code,$model,$location));

        return $stmt ->fetch(PDO::FETCH_ASSOC)['q'] ;
    }





    function info_serial()
    {


        $serial=$_GET['serial'];
        $id_catg='';
        $model=0;
        $stmtpage = $this->db->prepare("SELECT  * FROM serial   WHERE serial=? ");
        $stmtpage->execute(array($serial));
        if ($stmtpage->rowCount() > 0) {

            $data=array();
            while ($result=$stmtpage->fetch(PDO::FETCH_ASSOC)) {

                $model=$result['model'];



               $data_code[] = $this->data_code($result['code'], $result['model']);

               foreach ($data_code as $ifo)
               {
                   $id_catg=$ifo['id_cat'];
                   $result['title'] = $ifo['title'] ;
                   $result['img']=$ifo['img'];
                   $result['color'] =$ifo['color'];
                   $result['size'] =$ifo['size'];
                   $result['quantity']=$ifo['quantity'];
                }


                $result['quantity_serial'] = $this->sum_serial_enter_all($result['code'], $result['model']);
                $result['user'] = $this->UserInfo($result['userId']);
                $result['date'] = date('Y-m-d h:i:s a', $result['date']);
                $result['location'] = $this->list_location_no_html($result['code'], $result['model']);
                $result['spare_code'] = $this->get_spare_code($result['code'], $result['model']);
                $result['location_conform'] = $this->location_conform($result['code'], $result['model']);

                $data[]=$result;

            }

            require($this->render($this->folder, 'jard/html', 'data', 'php'));

        }

    }


    function duplication_code()
    {

        $serial=$_GET['serial'];

        $stmtpage = $this->db->prepare("SELECT  * FROM serial   WHERE serial=? ");
        $stmtpage->execute(array($serial));
        if ($stmtpage->rowCount() > 0) {

            $data=array();
            while ($result=$stmtpage->fetch(PDO::FETCH_ASSOC)) {
                $data[]=$result;
            }


         if (count($data) >= 2 ) {

             foreach ($data as $outDate){
          echo  "<div class='custom-control custom-radio  custom-control-inline'>
                <input  type='radio' id='customRadio-{$outDate['code']}' value='{$outDate['code']}' name='duplication' class='custom-control-input' required>
                <label class='custom-control-label' for='customRadio-{$outDate['code']}'>{$outDate['code']}</label>
              </div>";

           }
         }


        }

    }




    function get_spare_code($code,$model)
    {

            $stmt  = $this->db->prepare("SELECT   GROUP_CONCAT(spare_code SEPARATOR  ',') as spare_code FROM spare_code  WHERE code=? AND  model=?  ");
            $stmt ->execute(array($code,$model));

        return $stmt ->fetch(PDO::FETCH_ASSOC)['spare_code'] ;
    }


    function sum_serial_enter_all($code,$model)
    {

            $stmt  = $this->db->prepare("SELECT  SUM(quantity) as q FROM serial  WHERE code=? AND  model=?  ");
            $stmt ->execute(array($code,$model));

        return $stmt ->fetch(PDO::FETCH_ASSOC)['q'] ;
    }

    function location_conform($code,$model)
    {

        $stmt  = $this->db->prepare("SELECT  SUM(quantity) as q FROM location_confirm  WHERE code=? AND  model=?  ");
        $stmt ->execute(array($code,$model));

        return $stmt ->fetch(PDO::FETCH_ASSOC)['q'] ;
    }


    public function processing_jard()
    {


        $table = $this->jard_page;
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $table.'.page', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/details_page_jard/{$d}'>{$d}</a>";
                }
            ),

            array( 'db' => 'user.username', 'dt' => 1 ),


            array( 'db' =>  $table.'.page', 'dt' => 2 ,
                'formatter' => function ($id, $row) {
                    return  $this->get_Time_jard($id);
                }
            ),

            array( 'db' =>  $table.'.from_date', 'dt' => 3 ,
                'formatter' => function ($id, $row) {
                    $from_date= strtotime(date('H:i:s', $id));
                    $to_date= strtotime(date('H:i:s', $row[6]));
                    $diff = $from_date - $to_date;
                    return  $this->time_reg(abs($diff));

                }
            ),

            array( 'db' =>  $table.'.date', 'dt' => 4 ,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),
            array( 'db' =>  $table.'.date', 'dt' => 5 ,
                'formatter' => function ($id, $row) {

                $date_add=strtotime('+1 day', $id);

                    if ($date_add >= time())
                    {
                        return "<a href='".url.'/'.$this->folder."/edit_jard/{$row[0]}'><i class='fa fa-edit'></i></a>";
                    }
                }
            ),
            array(  'db' =>   $table.'.to_date', 'dt'=> 6),
            array(  'db' =>   $table.'.id', 'dt'=> 7)


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



    function get_Time_jard($id)
    {
        $stmt  = $this->db->prepare("SELECT  *  FROM jardtime  WHERE page=?   ");
        $stmt ->execute(array($id));

        $html = "<table class='table-bordered table_location '>";
        if ($stmt->rowCount() > 0) {
            $html .= "<tr>  <th>من فترة</th>   <th>الى فترة</th>   <th> الوقت </th>   </tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $d1=date('h:i:s a',$row['from_date']);
                $d2=date('h:i:s a',$row['to_date']);
                $time=$this->time_reg(abs($row['to_date']-$row['from_date']));

                $html .= "<tr> <td>{$d1}</td>    <td>{$d2}</td>    <td>{$time}</td>     </tr>    ";
            }
        }else
        {
            $html .= "</tr><td> لا يوجد وقت</td></tr>";
        }
        $html .="</table>";
         return $html;

    }



    function details_page_jard($id)
    {

        $this->checkPermit('details_page',$this->folder);
        $this->adminHeaderController($this->langControl($this->folder));



        require ($this->render($this->folder,'jard/html','details_page','php'));
        $this->adminFooterController();

    }


    public function processing_details_pagejard($id)
    {


        $table = $this->jard;
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $table.'.page', 'dt' => 0),
            array( 'db' => $table.'.model', 'dt' => 1),
            array( 'db' => $table.'.code', 'dt' => 2,
                'formatter' => function ($id, $row) {
                $this->infoCode=$this->data_code_jard($id,$row[1]);

                    return   $this->infoCode['cat_title'];
                }
            ),
            array( 'db' => $table.'.code', 'dt' => 3,
                'formatter' => function ($id, $row) {
                  return  $this->infoCode['title'];
                }
            ),
            array( 'db' => $table.'.code', 'dt' => 4),
            array( 'db' => $table.'.code', 'dt' => 5,
                'formatter' => function ($id, $row) {

                    $m="'{$row[12]}'";
                    return '
                <button class="btn btn-primary" onclick="get_serial_jard_details('.$id.','.$m.','.$row[0].')"  type="button" data-toggle="collapse" data-target="#multiCollapseExample-'.$id.$row[12].'" aria-expanded="false" aria-controls="multiCollapseExample'.$id.$row[8].'">'.$this->sum_serial_jard($id,$row[12],$row[0]).'</button>
                   <div class="collapse multi-collapse" id="multiCollapseExample-'.$id.$row[12].'">
                      <div style="padding: 5px;margin:0 ;align-items: center;" class="card card-body" id="data_collapse_'.$id.$row[12].'">
                   </div>
                </div>
                ';
                }
            ),

            array( 'db' => $table.'.code', 'dt' => 6,
                'formatter' => function ($id, $row) {

                    $m="'{$row[12]}'";
                    return  $this->quantity_code_excel($id,$m);
                }
            ),

            array( 'db' => $table.'.code', 'dt' => 7,


                'formatter' => function ($id, $row) {


                    $m="'{$row[12]}'";
                    return '
                <button class="btn btn-warning btn_quantity_enter" onclick="get_serial('.$id.','.$m.')"  type="button" data-toggle="collapse" data-target="#multiCollapseExampleSerial-'.$id.$row[12].'" aria-expanded="false" aria-controls="multiCollapseExampleSerial'.$id.$row[12].'">'.$this->sum_serial_enter_all($id, $row[12]) .'</button>
                   <div class="collapse multi-collapse" id="multiCollapseExampleSerial-'.$id.$row[12].'">
                      <div style="padding: 5px;margin:0" class="card card-body" id="data_collapse_Serial'.$id.$row[12].'">
                   </div>
                </div>
                ';

                }
                ),

            array( 'db' => $table.'.type_enter', 'dt' =>8 ),
            array( 'db' => 'user.username', 'dt' => 9 ),

            array( 'db' =>  $table.'.date', 'dt' => 10 ,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),

            array(  'db' =>   $table.'.id', 'dt'=> 11),//8
            array(  'db' =>   $table.'.model', 'dt'=> 12)//9


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
        $group=" GROUP BY code ";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,$group,null,1));

    }



function quantity_code_excel($code,$model)
{

    if ($model == 'mobile')
    {
        $excel='excel';
    }else
    {
        $excel='excel_'.$model;
    }

    $stmt  = $this->db->prepare("SELECT   IFNULL(quantity,0) as quantity  FROM excel  WHERE code=?   ");
    $stmt ->execute(array($code));
    if ($stmt->rowCount() > 0)
    {
        return $stmt->fetch(PDO::FETCH_ASSOC)['quantity'];
    }else
    {
        return 0;
    }


}




function get_serial_jard($code,$model,$page)
{

    if ($this->admin($this->userid)) {
        $stmt  = $this->db->prepare("SELECT   id,serial,quantity  FROM jard  WHERE code=? AND  model=? AND page=? ");
        $stmt ->execute(array($code,$model,$page));
    }else
    {
        $stmt  = $this->db->prepare("SELECT   id,serial,quantity  FROM jard  WHERE code=? AND  model=? AND  userId =? AND page=? ");
        $stmt ->execute(array($code,$model,$this->userid,$page));
    }



    $html = "<table class='table_location'>";
    if ($stmt->rowCount() > 0) {

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($this->permit('delete_serial',$this->folder))
            {
                $html .= "<tr id='serial_{$row['id']}'> <td>{$row['serial']}<td><span class='badge badge-pill badge-success'>{$row['quantity']} </span></td>
               <td> <span  style='cursor: pointer;color: red ;padding: 0 5px' onclick='delete_serial_jard({$row['id']})'><i class='fa fa-times-circle'></i> </span> </td>
                 
                </tr>    ";
            }
            else {
                $html .= "<tr> <td>{$row['serial']}<td><span class='badge badge-pill badge-success'>{$row['quantity']} </span></td> </tr>    ";
            }

        }
    }else
    {
        $html .= "</tr><td> لا يوجد سيريال</td></tr>";
    }
    $html .="</table>";
    echo $html;







}



function get_serial_jard_details($code,$model,$page)
{
    $stmt  = $this->db->prepare("SELECT   id,serial ,quantity,location  FROM jard  WHERE code=? AND  model=? AND page=? ");
    $stmt ->execute(array($code,$model,$page));
//    if ($this->admin($this->userid)) {
//        $stmt  = $this->db->prepare("SELECT   id,serial ,quantity,location  FROM jard  WHERE code=? AND  model=? AND page=? ");
//        $stmt ->execute(array($code,$model,$page));
//    }else
//    {
//        $stmt  = $this->db->prepare("SELECT   id,serial ,quantity ,location   FROM jard  WHERE code=? AND  model=? AND  userId =? AND page=? ");
//        $stmt ->execute(array($code,$model,$this->userid,$page));
//    }

    $html = "<table class='table_location '>";
    if ($stmt->rowCount() > 0) {
        $html .= "<tr>  <td>السيريال</td>   <td>الموقع</td>  <td>كمية</td>  </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $html .= "<tr> <td>{$row['serial']}</td>    <td>{$row['location']}</td>   <td><span class='badge badge-pill badge-success'>{$row['quantity']} </span></td> </tr>    ";
        }
    }else
    {
        $html .= "</tr><td> لا يوجد سيريال</td></tr>";
    }
    $html .="</table>";
    echo $html;


}



function get_all_location_jard_details($code,$model)
{
        $stmt  = $this->db->prepare("SELECT  location,location_quantity  FROM jard  WHERE code=? AND  model=?   ");
        $stmt ->execute(array($code,$model));

        $html = "<table class='table_location'>";
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $html .= "<tr> <td>{$row['location']}<td><span class='badge badge-pill badge-success'>{$row['location_quantity']} </span></td> </tr>    ";
            }
        }
        else
        {
            $html .= "</tr><td> لا يوجد مواقع</td></tr>";
        }
         $html .="</table>";
        echo $html;
}




function data_code_jard($code,$model)
{

    if ($model=='accessories')
    {
        $stmt=$this->db->prepare("SELECT category_accessories.title as cat_title, accessories.title,excel_accessories.quantity,color_accessories.color FROM color_accessories INNER JOIN  accessories ON  accessories.id=color_accessories.id_item  INNER JOIN category_accessories  on accessories.id_cat = category_accessories.id   left JOIN  excel_accessories ON excel_accessories.code=color_accessories.code WHERE color_accessories.code=? LIMIT  1");
        $stmt->execute(array($code));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        $result['size']='';

    }else if($model=='savers')
    {

        $stmt=$this->db->prepare("SELECT  product_savers.title,excel_savers.quantity,product_savers.color FROM product_savers    left JOIN  excel_savers ON excel_savers.code=product_savers.code WHERE product_savers.code=? LIMIT  1");
        $stmt->execute(array($code));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        $result['size']='';
        $result['cat_title']='';

    }else
    {
        $category='category_'.$model;
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

        $stmt=$this->db->prepare("SELECT {$category}.title as cat_title, {$model}.title,{$color}.color,{$code_table}.size,{$excel}.quantity FROM {$code_table} INNER JOIN  {$color} ON  {$color}.id={$code_table}.id_color INNER JOIN  {$model} ON {$model}.id={$color}.id_item     INNER JOIN {$category}  on {$model}.id_cat = {$category}.id      left JOIN  {$excel} ON {$excel}.code={$code_table}.code   WHERE {$code_table}.code=? LIMIT  1");
        $stmt->execute(array($code));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
    }


   return $result;


}

    function list_serial_deleted_jard()
    {

        $this->checkPermit('list_serial_deleted',$this->folder);
        $this->adminHeaderController($this->langControl($this->folder));



        require ($this->render($this->folder,'jard/html','serial_deleted','php'));
        $this->adminFooterController();

    }


    public function processing_serial_deleted_jard()
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




    function  jard_material ()
    {

        $this->checkPermit('jard_material',$this->folder);
        $this->adminHeaderController($this->langControl($this->folder));



        require ($this->render($this->folder,'jard/html','material','php'));
        $this->adminFooterController();

    }


    public function processing_jard_material()
    {


        $table = $this->jard;
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $table.'.page', 'dt' => 0  ),
            array( 'db' => $table.'.model', 'dt' => 1 ,
                'formatter' => function ($id, $row) {
                    return  $id."[". $this->langControl($id) ."]";
                }
            ),
            array( 'db' => $table.'.code', 'dt' => 2 ,
                'formatter' => function ($id, $row) {
                    $this->data_code=$this->data_code($id,$row[1]);
                    return  $this->data_code['title'];
                }
            ),
            array( 'db' => $table.'.code', 'dt' => 3),
            array( 'db' => $table.'.code', 'dt' => 4 ,
                'formatter' => function ($id, $row) {
                    return  $this->data_code['color'];
                }
            ),
            array( 'db' => $table.'.code', 'dt' => 5 ,
                'formatter' => function ($id, $row) {
                    return  $this->data_code['size'];
                }
            ),
            array( 'db' => $table.'.code', 'dt' => 6,
                'formatter' => function ($id, $row) {

                    $m="'{$row[1]}'";
                    return '
                <button class="btn btn-primary" onclick="get_serial_jard('.$id.','.$m.','.$row[0].')"  type="button" data-toggle="collapse" data-target="#multiCollapseExample-'.$id.$row[1].'" aria-expanded="false" aria-controls="multiCollapseExample'.$id.$row[1].'">'.$this->sum_serial_jard($id,$row[1],$row[0]).'</button>
                   <div class="collapse multi-collapse" id="multiCollapseExample-'.$id.$row[1].'">
                      <div style="padding: 5px;margin:0;align-items: center;"  class="card card-body" id="data_collapse_'.$id.$row[1].'">
                   </div>
                </div>
                ';
                }
            ),
            array( 'db' => $table.'.location_quantity_all', 'dt' => 7,
                'formatter' => function ($id, $row) {

                    $m="'{$row[1]}'";
                    return '
                <button class="btn btn-warning" onclick="get_all_location_jard_details('.$row[3].','.$m.')"  type="button" data-toggle="collapse" data-target="#location_jard-'.$row[3].$row[1].'" aria-expanded="false" aria-controls="location_jard'.$row[3].$row[1].'">'.$id.'</button>
                   <div class="collapse multi-collapse"   id="location_jard-'.$row[3].$row[1].'">
                      <div style="padding: 5px;margin:0;align-items: center;" class="card card-body" id="location_data_collapse_'.$row[3].$row[1].'">
                   </div>
                </div>
                ';
                }
            ),


            array( 'db' => $table.'.excel_quantity', 'dt' => 8 ,
                'formatter' => function ($id, $row) {
                    return  $id;
                }
            ),


            array( 'db' =>  $table.'.date', 'dt' => 9 ,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),

            array( 'db' =>  $table.'.code', 'dt' => 10 ,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_serial',$this->folder))
                    {
                        $code="'{$id}'";
                        $model="'{$row[0]}'";
                        return '
                          <button class="btn btn-primary" onclick="delete_serial_jard_by_code('.$code.','.$model.','.$row[0].')"  type="button"  ><i class="fa fa-trash"></i> </button>   
                    ';
                    }
                }
            ),

            array(  'db' =>   $table.'.id', 'dt'=> 11),




        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = " inner JOIN user ON user.id = {$table}.userId   ";

        if ($this->admin($this->userid))
        {
            $whereAll = array("");
        }else
        {
            $whereAll = array("userId={$this->userid}");
        }

        $group="  GROUP BY {$table}.code , {$table}.page  ";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,1));

    }



    function sum_serial_jard($code,$model,$page)
    {
        $stmt  = $this->db->prepare("SELECT  SUM(quantity) as q FROM jard  WHERE code=? AND  model=? AND page=?");
        $stmt ->execute(array($code,$model,$page));

//        if ($this->admin($this->userid))
//        {
//            $stmt  = $this->db->prepare("SELECT  SUM(quantity) as q FROM jard  WHERE code=? AND  model=? AND page=?");
//            $stmt ->execute(array($code,$model,$page));
//        }else
//        {
//            $stmt  = $this->db->prepare("SELECT  SUM(quantity) as q FROM jard  WHERE code=? AND  model=? AND userId = ? AND page =? ");
//            $stmt ->execute(array($code,$model,$this->userid,$page));
//        }
        return $stmt ->fetch(PDO::FETCH_ASSOC)['q'] ;
    }





    function edit_jard($id)
    {

        $this->checkPermit('edit_jard',  $this->folder);
        $this->adminHeaderController($this->langControl('edit_jard'));

        if (!$this->admin($this->userid))
        {
            $stmtResult = $this->db->prepare("SELECT  * FROM jard_page   WHERE page=? AND userId=?");
            $stmtResult->execute(array($id,$this->userid));
            if ($stmtResult->rowCount()  < 1)
            {
                die('
                 <br>
                    <div class="alert alert-danger" role="alert">
                       <span>تحاول التعديل على رقم جرد غير خاص بك </span>  //  <a href="'.url.'/'.$this->folder.'/list_jard" class="btn btn-warning btn-sm  ">رجوع</a> 
                    </div>
                    
                    '
                );
            }
        }





        require($this->render($this->folder, 'jard/html', 'edit', 'php'));
        $this->adminFooterController();

    }


    function from_edit_jard($id)
    {



        $stmtResult = $this->db->prepare("SELECT  * FROM jard_page   WHERE page=? ");
        $stmtResult->execute(array($id));
        $result=$stmtResult->fetch(PDO::FETCH_ASSOC);


        $date_add=strtotime('+1 day', $result['date']);

        if ($date_add <= time())
        {
            die('over_time');
        }


        $this->checkPermit('edit_jard',  $this->folder);

        if (isset($_POST['submit'])) {

            try {

                $form = new  Form();



                if ($this->setting->get('required_location_jard') == 1){
                    $form->post('location')
                        ->val('is_empty', $this->langControl('required'))
                        ->val('strip_tags');
                }

                $form->post('serial')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');

                $form->post('type_enter')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');


                $form->post('duplication')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $serial=trim($data['serial']);




                if (!empty($data['duplication']))
                {
                    $stmtpage = $this->db->prepare("SELECT  * FROM serial   WHERE serial=? AND code=?");
                    $stmtpage->execute(array($serial,$data['duplication']));
                }else
                {
                    $stmtpage = $this->db->prepare("SELECT  * FROM serial   WHERE serial=? ");
                    $stmtpage->execute(array($serial));
                }


                if ($stmtpage->rowCount() > 0) {




                    $stmtChshort_time_start=$this->db->prepare("SELECT *FROM jardtime WHERE page=?    ");
                    $stmtChshort_time_start->execute(array($id));
                    if ($stmtChshort_time_start->rowCount()>0) {

                        $stmtUpdatePageshort_time_start = $this->db->prepare("UPDATE `jardtime`  SET   from_date =?  WHERE  page=?   AND  from_date = 0");
                        $stmtUpdatePageshort_time_start->execute(array(time(), $id));

                        $stmtshort_time_start = $this->db->prepare("SELECT *FROM jard_page WHERE page=?    ");
                        $stmtshort_time_start->execute(array($id));
                        if ($stmtshort_time_start->rowCount() > 0) {

                            $r_short_time_start = $stmtshort_time_start->fetch(PDO::FETCH_ASSOC);

                            if (time() < strtotime("+30 minutes", $r_short_time_start['to_date'])) {
                                $stmtUpdatePageshort_time_start = $this->db->prepare("UPDATE `jardtime`  SET   to_date =?  WHERE  page=?  ORDER BY id DESC  LIMIT 1");
                                $stmtUpdatePageshort_time_start->execute(array(time(), $id));
                            }else
                            {
                                $stmtInsertTimePAge = $this->db->prepare("INSERT INTO  `jardtime` ( page, userId, from_date, to_date, date) values (?,?,?,?,?)");
                                $stmtInsertTimePAge->execute(array($id,$this->userid,time(),time(),time() ));
                            }
                        }

                    }else
                    {
                        $stmtInsertTimePAge = $this->db->prepare("INSERT INTO  `jardtime` ( page, userId, from_date, to_date, date) values (?,?,?,?,?)");
                        $stmtInsertTimePAge->execute(array($id,$this->userid,time(),time(),time() ));

                    }



                    $stmtUpdatePage = $this->db->prepare("UPDATE `jard_page`  SET   from_date =?  WHERE  page=?  AND    userId=? AND  from_date = 0");
                    $stmtUpdatePage->execute(array(time(),$id,$this->userid));

                    $stmtUpdatePage2 = $this->db->prepare("UPDATE `jard_page`  SET   to_date =?  WHERE  page=?  AND    userId=?  ");
                    $stmtUpdatePage2->execute(array(time(),$id,$this->userid));

                    $result= $stmtpage->fetch(PDO::FETCH_ASSOC);
                    $serial_data= $this->data_code($result['code'],$result['model']);
                    $serial_data['model']=$result['model'];



                    if ($this->setting->get('required_location_jard') == 0){
                        $data['location']='';

                        $data['location_quantity']=0;
                    }else
                    {

                        $stmtCheckLocationModel=$this->db->prepare("SELECT *FROM location_model WHERE model=? AND location=? ");
                        $stmtCheckLocationModel->execute(array($result['model'],$data['location']));
                        if ($stmtCheckLocationModel->rowCount() <= 0)
                        {
                            die('locationNotFound');
                        }

                        $data['location_quantity']=$this->location_quantity($result['code'],$result['model'],$data['location']);
                    }

                    $data['location_quantity_all']=$this->location_quantity_all($result['code'],$result['model']);



                    $stmtCh=$this->db->prepare("SELECT  * FROM jard   WHERE    code =? AND  serial=? AND model=? AND page=? ");
                    $stmtCh->execute(array($serial_data['code'],$data['serial'],$serial_data['model'],$id));
                    if ($stmtCh->rowCount() > 0)
                    {
                        echo 'enterSerial';
                    }else{
                        $stmt = $this->db->prepare("INSERT INTO `jard` ( page, code, serial, type_enter, quantity,excel_quantity, model, userId,`date`,location,location_quantity,location_quantity_all) VALUE (?,?,?,?,?,?,?,?,?,?,?,?) ");
                        $stmt->execute(array($id,$serial_data['code'],$data['serial'],$data['type_enter'],1,$serial_data['quantity'],$serial_data['model'],$this->userid,time(),$data['location'],$data['location_quantity'],$data['location_quantity_all']));
                        echo 'true';

                    }

                }else{
                    echo 'er_serial';
                }

            } catch (Exception $e) {

                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }

        }

    }




    function delete_serial_jard($id)
    {
        if ($this->handleLogin())
        {

            $stmtRow = $this->db->prepare("SELECT * FROM jard WHERE id=? ");
            $stmtRow ->execute(array($id));
            $result=$stmtRow->fetch(PDO::FETCH_ASSOC);
            $time=time();
            $stmtData  = $this->db->prepare("INSERT INTO jard_delete (page, code, serial, type_enter, quantity,excel_quantity, model, userId, date)  SELECT page,code, serial, type_enter, quantity,excel_quantity, model, $this->userid, $time  FROM jard WHERE id=?");
            $stmtData ->execute(array($id));

            $stmt  = $this->db->prepare("DELETE FROM jard WHERE id=?");
            $stmt ->execute(array($id));
            $this->insertCodeSerial_conform($result['code'],$result['mode'],'حذف سيريال');
            echo 'true';
        }

    }

    function delete_serial_jard_by_code($code,$model,$page)
    {
        if ($this->handleLogin())
        {


            if ($model == 'deleted')
            {
                $stmt  = $this->db->prepare("DELETE FROM jard WHERE code=?  AND page=?");
                $stmt ->execute(array($code,$page));
                die('true');
            }

            $time=time();
            if ($this->admin($this->userid))
            {
                $stmtRow = $this->db->prepare("SELECT * FROM jard WHERE code=? AND model=? AND page=?");
                $stmtRow ->execute(array($code,$model,$page));
            }else
            {
                $stmtRow = $this->db->prepare("SELECT * FROM jard WHERE code=? AND model=? AND  userId=? AND page=?");
                $stmtRow ->execute(array($code,$model,$this->userid,$page));
            }

            while ($row = $stmtRow->fetch(PDO::FETCH_ASSOC) )
            {
                $stmtData  = $this->db->prepare("INSERT INTO jard_delete (page,  code, serial, type_enter, quantity,excel_quantity, model, userId, date)  SELECT page, code, serial, type_enter, quantity,excel_quantity, model, $this->userid, $time  FROM jard_delete WHERE id=?");
                $stmtData ->execute(array($row['id']));

            }
            if ($this->admin($this->userid))
            {
                $stmt  = $this->db->prepare("DELETE FROM jard WHERE code=? AND model=? AND page=?");
                $stmt ->execute(array($code,$model,$page));

            }else
            {
                $stmt  = $this->db->prepare("DELETE FROM jard WHERE code=? AND model=? AND userId=? AND page=?");
                $stmt ->execute(array($code,$model,$this->userid,$page));


            }
            echo 'true';
        }

    }


    function code_not_jrad()
    {

          $id_page=$_GET['id_page'];
         $model=$_GET['model'];
         $id_catg=$_GET['id_catg'];

         if ($model=='accessories' && $model != 'savers')
         {
             $stmt  = $this->db->prepare("SELECT category_accessories.title as cat_title, accessories.title, color_accessories.code FROM accessories  INNER JOIN  category_accessories   on accessories.id_cat = category_accessories.id INNER JOIN color_accessories ON color_accessories.id_item = accessories.id   LEFT JOIN jard ON jard.code=color_accessories.code  WHERE accessories.id_cat=? AND ( jard.page=? OR jard.page IS NULL ) AND jard.code IS NULL");

         }else if ( $model != 'savers')
         {


             $category='category_'.$model;

             if ($model=='mobile')
             {
                 $color='color';
                 $code='code';
             }else
             {
                 $color='color_'.$model;
                 $code='code_'.$model;
             }


         }
         $stmt  = $this->db->prepare("SELECT {$category}.title as cat_title, {$model}.title, {$code}.code FROM {$model}     INNER JOIN  {$category}   on {$model}.id_cat = {$category}.id   INNER JOIN {$color} ON {$color}.id_item = {$model}.id INNER JOIN {$code} ON {$code}.id_color={$color}.id LEFT JOIN jard ON jard.code={$code}.code  WHERE {$model}.id_cat=? AND ( jard.page=? OR jard.page IS NULL ) AND jard.code IS NULL");
         $stmt ->execute(array($id_catg,$id_page));
        $data=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data[]=$row;
        }



       require($this->render($this->folder, 'jard/html', 'code_not_jrad', 'php'));



    }





}