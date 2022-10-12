<?php
trait transport_not_confirm
{

    function __construct()
    {
        parent::__construct();
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject

    }


    function transport_not_confirm()
    {


        $this->checkPermit('transport_not_confirm', $this->folder);
        $this->adminHeaderController($this->langControl('transport_not_confirm '));


        require($this->render($this->folder, 'transport_not_confirm', 'html/index', 'php'));
        $this->adminFooterController();

    }


    public function processing_transport_not_confirm()
    {

        $this->checkPermit('processing_transport_not_confirm', $this->folder);

        $table = 'location_transport';
        $primaryKey = $table . '.id';


        $columns = array(


            array('db' => $table . '.model', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return $this->langControl($d);
                }
            ),
            array('db' => 'user.username', 'dt' => 1),
            array('db' => $table . '.transport', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return "<a  class='btn btn-warning' href='" . url . '/' . $this->folder . "/view_transport_not_confirm?g={$d}' >{$d}</a>";
                }),
            array('db' => $table . '.date', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i a', $d);
                }
            ),
            array(  'db' => $table.'.transport', 'dt'=>4,
                'formatter' => function( $d, $row ) {

                    if ($this->permit('delete',$this->folder)) {
                        return "<button  onclick='delete_transport_before_conform({$d})' class='btn btn-danger'  ><i class='fa fa-trash'></i></button>";

                    }else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            )
        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "INNER JOIN user ON user.id={$table}.userid ";
        $whereAll = array("{$table}.active = 1");
        $group = "GROUP BY {$table}.transport";

        $result = SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll, null, $group);

        echo json_encode($result);


    }


    function view_transport_not_confirm()
    {

        if (isset($_GET['g'])) {
            $transport = $_GET['g'];
        } else {
            $transport = 0;
        }

        $this->checkPermit('transport_not_confirm', $this->folder);
        $this->adminHeaderController($this->langControl('transport_not_confirm '));


        $stmt = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 1 AND `transport`=? GROUP BY model LIMIT 1");
        $stmt->execute(array($transport));
        $result_trans = $stmt->fetch(PDO::FETCH_ASSOC);


        if (isset($_GET['model']) && isset($_GET['category'])) {

            $categoryIds = $_GET['category'];


            $id = explode('_', $categoryIds);
            $id = $id[1];


            $model = $_GET['model'];

            $name_category = 'category_' . $model;
            $breadcumbsx = $this->BreadcumbsPublic($name_category, $id);
            $category = $this->langControl($model);
            foreach ($breadcumbsx as $key => $cat) {
                $category .= '<li class="breadcrumb-item active" aria-current="page" >' . $key . ' </li> ';
            }


        } else if (isset($_GET['model'])) {
            $id = null;
            $model = $_GET['model'];
            $category = '<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) . ' </li> ';

        } else {
            $id = null;
            $model = null;
            $category = null;

        }

        $from = null;
        $to = null;
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
        }

        $fromDate_format=0;
        $toDate_format=0;
        $fromDate=0;
        $toDate=0;
        if (isset($_GET['fromDate']) && isset($_GET['toDate']) )
        {
            $fromDate_format=$_GET['fromDate'];
            $toDate_format=$_GET['toDate'];

            $fromDate=strtotime($_GET['fromDate']);
            $toDate=strtotime($_GET['toDate']);
        }


//
//        $stmt = $this->db->prepare("SELECT  group_location FROM location WHERE  group_location <> 0 group by group_location ORDER BY group_location  asc ");
//        $stmt->execute();
//        $group_location = array();
//        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//            $group_location[] = $row['group_location'];
//        }


        $stmtdata = $this->db->prepare("SELECT *, SUM(`quantity`) as `quantity`, GROUP_CONCAT(`location`) as location FROM location_transport WHERE  `active` = 1 AND `transport`=? GROUP BY code");
        $stmtdata->execute(array($transport));
        $data = array();
        while ($row = $stmtdata->fetch(PDO::FETCH_ASSOC)) {


            if ($row['model'] == 'mobile') {
                $code = 'code';
                $color = 'color';
                $table = $row['model'];

                $stmt_t = $this->db->prepare("SELECT  {$code}.location, {$color}.img,{$table}.title FROM {$code} INNER JOIN {$color} ON {$color}.id={$code}.id_color  INNER JOIN {$table} ON {$table}.id={$color}.id_item WHERE  {$code}.`code` = ?  ");
                $stmt_t->execute(array($row['code']));

            } else if ($row['model'] == 'accessories') {


                $table = $row['model'];
                $stmt_t = $this->db->prepare("SELECT  color_accessories.location, color_accessories.img,accessories.title FROM color_accessories INNER JOIN accessories on accessories.id = color_accessories.id_item    WHERE  color_accessories.`code` = ? ");
                $stmt_t->execute(array($row['code']));

            } else if ($row['model'] == 'savers') {
                $table = $row['model'];
                $stmt_t = $this->db->prepare("SELECT  product_savers.location, product_savers.img,product_savers.title FROM product_savers    WHERE  product_savers.`code` = ?   ");
                $stmt_t->execute(array($row['code']));
            } else {

                $code = 'code_' . $row['model'];
                $color = 'color_' . $row['model'];
                $table = $row['model'];

                $stmt_t = $this->db->prepare("SELECT  {$code}.location, {$color}.img,{$table}.title FROM {$code} INNER JOIN {$color} ON {$color}.id={$code}.id_color  INNER JOIN {$table} ON {$table}.id={$color}.id_item WHERE  {$code}.`code` = ?  ");
                $stmt_t->execute(array($row['code']));

            }

            $result = $stmt_t->fetch(PDO::FETCH_ASSOC);
            $row['image'] = $result['img'];


            $stmt_all_loc = $this->db->prepare("SELECT location,quantity FROM location WHERE code=? AND `model`=?   ");
            $stmt_all_loc->execute(array($row['code'], $table));
            $row['all_location'] = array();
            while ($rowloc = $stmt_all_loc->fetch(PDO::FETCH_ASSOC)) {
                $rowloc['location'] = $this->tamayaz_locations( $rowloc['location']);
                $row['all_location'][] = $rowloc;
            }


            $row['title'] = $result['title'];


            $row['tolocation'] = array();
            $stmt_to_location = $this->db->prepare("SELECT location,id,quantity_trans as quantity FROM location_transport_convert WHERE  `transport`=?  AND code=?  AND  model =? AND from_location=? ");
            $stmt_to_location->execute(array($transport, $row['code'], $row['model'], $row['location']));
            while ($rowL = $stmt_to_location->fetch(PDO::FETCH_ASSOC)) {
                $row['tolocation'][] = $rowL;
            }


            $stmt_quantity = $this->db->prepare("SELECT SUM(quantity) as quantity FROM location_transport_convert WHERE  `transport`=?  AND code=? AND  model =?  AND from_location=?");
            $stmt_quantity->execute(array($transport, $row['code'], $row['model'],$row['location']));
            $row['toquantity'] = $stmt_quantity->fetch(PDO::FETCH_ASSOC)['quantity'];

            $row['quantity'] = (int)$row['quantity']  ;



            $row['serial_req']='';
            if ($this->check_serial_required($row['code'],'serial_transfer',$row['model']) == true)
            {
                $row['serial_req']='required';
            }

            $row['listSerial']=$this->getSerialCode($row['code'],(int)$row['quantity']+ (int)$row['toquantity'],$row['model']);




            $data[] = $row;
        }


        require($this->render($this->folder, 'transport_not_confirm', 'html/view', 'php'));
        $this->adminFooterController();

    }


    function getFromLocation($transport,$code,$model,$active=1)
        {

            $stmtdata = $this->db->prepare("SELECT *FROM location_transport WHERE     `transport`=? AND code=? AND  model=? AND `active` = ?");
            $stmtdata->execute(array($transport,$code,$model,$active));
            $html = '';
            while ($row = $stmtdata->fetch(PDO::FETCH_ASSOC)) {
                $html.="<div class='mb-3'>{$row['location']} = {$row['quantity']}</div>";
            }
            return $html;
        }





    function insert_location_convert($transport)
    {

        if ($this->handleLogin()) {
            if (isset($_POST['submit'])) {
                $model = trim($_POST['model']);
                $location = trim($_POST['location']);
                $code = trim($_POST['code']);
                if (is_numeric($_POST['quantity'])) {
                    $quantity = trim($_POST['quantity']);
                } else {
                    $quantity = 0;
                }
                $color = 'بلا';
                $stmtxm = $this->db->prepare("SELECT `sequence` FROM `location_model`  WHERE `location`=?  AND `model` =?  ");
                $stmtxm->execute(array($location, $model));
                if ($stmtxm->rowCount() > 0) {
                    //  اذا كان الموقع مضاف
                    $location_model=$stmtxm->fetch(PDO::FETCH_ASSOC);

                    // ناخذ من المناقلة

                    $stmt_check_q = $this->db->prepare("SELECT *,  SUM(quantity) as quantity FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND transport=?  ");
                    $stmt_check_q->execute(array($code, $model, $transport ));
                    $result_location= $stmt_check_q->fetch(PDO::FETCH_ASSOC);

                    // نشوف اذا الموقع مضاف للمادة
                    $stmtins = $this->db->prepare("SELECT id FROM location WHERE `model`=? AND location  = ? AND `code` =? ");
                    $stmtins->execute(array($model, $location, $code));
                    if ($stmtins->rowCount() < 1) {
                        // اذا ما كان مضاف نضيفه
                        $stmtins = $this->db->prepare("INSERT INTO location (`model` , location  , `code` ,quantity,userid ,date,`new_location`,`sequence`) values (?,?,?,?,?,?,?,?)");
                        $stmtins->execute(array($model, $location, $code, 0, $this->userid, time(), 1,$location_model['sequence']));
                        // get last id
                        // $last_id = $this->db->lastInsertId();
                    }



                    // مره لخ نرجع نشوف الموقع
                    // هذا راح الغي لان ماله داعي
                    // $stmtchq = $this->db->prepare("SELECT *FROM location WHERE `model`=? AND location =  ? AND `code`=? ");
                    // $stmtchq->execute(array($model, $location, $code));

                    if ($stmtins->rowCount() > 0) {
                        // اذا كان مضاف

                        // نشوف اذا كان كمية المادة اكبر من الكمية الموجودة في المناقلة
                        $stmtlocation = $this->db->prepare("SELECT * FROM location WHERE `model`=? AND location  = ?   AND `code` =? AND quantity >= ? ");
                        $stmtlocation->execute(array($model, $result_location['location'], $code,$result_location['quantity']));
                        if ($stmtlocation ->rowCount() ) {
                            // اذا كانت كمية المادة اكبر من الكمية الموجودة في المناقلة
                            $q = true;
                            // مره لخ يرجع يسوي ركوست على هاي
                            // هذا راح الغي لان ماله داعي
                            //
                            // $stmtx1 = $this->db->prepare("SELECT * FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND transport=?");
                            // $stmtx1->execute(array($code, $model, $transport));
                            // if ($stmtx1->rowCount() > 0) {
                                // $sum_q = 0;
                                // while ($row = $stmtx1->fetch(PDO::FETCH_ASSOC)) {
                                //     $sum_q = $sum_q + $row['quantity'];
                                // }
                                if ($quantity <= $result_location['quantity']) {
                                    //  هذا هم ماله داعي
                                    // $stmt_check = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 1 AND code=?  AND model=? AND transport = ? AND quantity >  0 ORDER BY id ASC LIMIT 1");
                                    // $stmt_check->execute(array($code, $model, $transport));
                                    if ($result_location['quantity'] > 0) {
                                        // $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

                                        if ($result_location['quantity'] >= $quantity) {

                                            $stmtch = $this->db->prepare("SELECT *FROM `location_transport_convert`  WHERE  `active` = 1 AND location = ? AND code=? AND model=? AND transport=? AND from_location=?");
                                            $stmtch->execute(array($location, $code, $model, $transport, $result_location['location']));
                                            if ($stmtch->rowCount() > 0) {
//
                                                $stmtchup = $this->db->prepare("UPDATE    location_transport_convert SET  quantity=quantity+?,quantity_trans=quantity_trans+?,userid=?,`date` =?,user_pull=?,serial=? WHERE  `active` = 1 AND location = ? AND code=?  AND model=? AND transport=? AND from_location=?");
                                                $stmtchup->execute(array($quantity, $quantity, $this->userid, time(), $result_location['userid'], $result_location['serial'], $location, $code, $model, $transport, $result_location['location']));
                                                if ($stmtchup->rowCount() > 0) {
                                                    $stmtup_trans = $this->db->prepare("UPDATE    location_transport SET  quantity=quantity - ? WHERE  `active` = 1 AND code=?  AND model=? AND transport = ? AND `location` =?  ");
                                                    $stmtup_trans->execute(array($quantity, $code, $model, $transport, $result_location['location']));

                                                    $this->date_transport_not_confirm($transport,$result_location['id']);
                                                } else {
                                                    //echo  $q='   لم يتم النقل    ';
                                                    echo $q = 'quantity_over';
                                                }
                                            } else {

                                                $stmt = $this->db->prepare("INSERT INTO location_transport_convert ( model, location, code, quantity, transport, active, date, userid,from_location,quantity_trans,user_pull,serial)values (?,?,?,?,?,?,?,?,?,?,?,?)");
                                                $stmt->execute(array($model, $location, $code, $quantity, $transport, 1, time(), $this->userid, $result_location['location'], $quantity, $result_location['userid'], $result_location['serial']));
                                                if ($stmt->rowCount() > 0) {
                                                    $stmtup_trans = $this->db->prepare("UPDATE    location_transport SET  quantity = quantity - ? WHERE  `active` = 1 AND code=?  AND model=? AND transport = ? AND `location` =?  ");
                                                    $stmtup_trans->execute(array($quantity, $code, $model, $transport, $result_location['location']));

                                                    $this->date_transport_not_confirm($transport,$result_location['id']);
                                                } else {
                                                    // echo  $q='   لم يتم النقل    ';
                                                    echo $q = 'quantity_over';
                                                }
                                            }

                                        } else {
                                            // echo  $q='اكبر من كمية المستودع';
                                            echo $q = 'quantity_over';
                                        }
                                    } else {
                                        //  echo  $q='تم نقل كل الكمية من المستودعات';
                                        echo $q = 'quantity_over';
                                    }
                                } else {
                                    //echo  $q='الكمية المدخلة اكبر من كمية المستودعات المسحوبة';
                                    echo $q = 'quantity_over';
                                }

                            // }

                        }else
                        {
                            echo $q = 'quantity_over2';
                        }


                    } else {
                        echo 'not_found_in_code_location';
                    }




                } else {
                    echo 'not_found';
                }


            }


        }


    }



    function date_transport_not_confirm($transport,$id)
    {


        if ($this->handleLogin()) {

            $stmtdata = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 1 AND `transport`=? and id =? ");
            $stmtdata->execute(array($transport,$id));
            $data = array();

            while ($row = $stmtdata->fetch(PDO::FETCH_ASSOC)) {
                $table = $row['model'];
                if ($row['model'] == 'mobile') {
                    $code = 'code';
                    $color = 'color';


                    $stmt_t = $this->db->prepare("SELECT  {$code}.location, {$color}.img,{$table}.title FROM {$code} INNER JOIN {$color} ON {$color}.id={$code}.id_color  INNER JOIN {$table} ON {$table}.id={$color}.id_item WHERE  {$code}.`code` = ?  ");
                    $stmt_t->execute(array($row['code']));

                } else if ($row['model'] == 'accessories') {

                    $stmt_t = $this->db->prepare("SELECT  color_accessories.location, color_accessories.img,accessories.title FROM color_accessories INNER JOIN accessories on accessories.id = color_accessories.id_item    WHERE  color_accessories.`code` = ?  ");
                    $stmt_t->execute(array($row['code']));

                } else if ($row['model'] == 'savers') {
                    $stmt_t = $this->db->prepare("SELECT  product_savers.location, product_savers.img,product_savers.title FROM product_savers    WHERE  product_savers.`code` = ?   ");
                    $stmt_t->execute(array($row['code']));
                } else {

                    $code = 'code_' . $row['model'];
                    $color = 'color_' . $row['model'];
                    $table = $row['model'];


                    $stmt_t = $this->db->prepare("SELECT  {$code}.location, {$color}.img,{$table}.title FROM {$code} INNER JOIN {$color} ON {$color}.id={$code}.id_color  INNER JOIN {$table} ON {$table}.id={$color}.id_item WHERE  {$code}.`code` = ?  ");
                    $stmt_t->execute(array($row['code']));

                }
                $result = $stmt_t->fetch(PDO::FETCH_ASSOC);


                $stmt_all_loc = $this->db->prepare("SELECT location,quantity FROM location WHERE code=? AND `model`=?   ");
                $stmt_all_loc->execute(array($row['code'], $table));
                $row['all_location'] = array();
                while ($rowloc = $stmt_all_loc->fetch(PDO::FETCH_ASSOC)) {
                    $rowloc['location'] = $this->tamayaz_locations( $rowloc['location']);
                    $row['all_location'][] = $rowloc;
                }

                $row['image'] = $result['img'];
                $row['title'] = $result['title'];


                $row['tolocation'] = array();
                $stmt_to_location = $this->db->prepare("SELECT location,id,quantity_trans as quantity,quantity as sum_q FROM location_transport_convert WHERE  `transport`=?  AND code=?  AND  model =? AND from_location=? ");
                $stmt_to_location->execute(array($transport, $row['code'], $row['model'], $row['location']));
                $sum_q=0;
                while ($rowL = $stmt_to_location->fetch(PDO::FETCH_ASSOC)) {
                    $row['tolocation'][] = $rowL;
                    $sum_q+=(int)$rowL['quantity'];
                }


                // $stmt_quantity = $this->db->prepare("SELECT SUM(quantity) as quantity FROM location_transport_convert WHERE  `transport`=?  AND code=? AND  model =?  AND from_location=?");
                // $stmt_quantity->execute(array($transport, $row['code'], $row['model'], $row['location']));
                $row['toquantity'] = $sum_q;

                // $row['quantity'] = $sum_q;



                $row['serial_req']='';
                if ($this->check_serial_required($row['code'],'serial_transfer',$row['model']) == true)
                {
                    $row['serial_req']='required';
                }

                $row['listSerial']=$this->getSerialCode($row['code'],(int)$row['quantity']+ (int)$row['toquantity'],$row['model']);




                $data = $row;
            }
            echo $id;
            if ($data) {
                require($this->render($this->folder, 'transport_not_confirm', 'html/data', 'php'));
            }
        }

    }
    // get id from location_transport by code and model and transport
    function get_id_location_transport($code,$model,$transport)
    {
        $stmt = $this->db->prepare("SELECT id FROM location_transport WHERE code=? AND model=? AND transport=? ");
        $stmt->execute(array($code,$model,$transport));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }


    function remove_location_convert($id, $transport)
    {
        if ($this->handleLogin()) {

            $stmt = $this->db->prepare("SELECT * FROM location_transport_convert WHERE  `id` = ? AND transport=?  ");
            $stmt->execute(array($id, $transport));
            if ($stmt->rowCount()>0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $stmtup_trans = $this->db->prepare("UPDATE    location_transport SET  quantity=quantity + ? WHERE  `active` = 1 AND code=?  AND model=? AND transport = ? AND `location` =?  ");
                $stmtup_trans->execute(array($result['quantity_trans'], $result['code'], $result['model'], $transport, $result['from_location']));
                if ($stmtup_trans->rowCount() > 0)
                {
                    $stmt2 = $this->db->prepare("DELETE FROM location_transport_convert WHERE  `id` = ? AND transport=?  ");
                    $stmt2->execute(array($id, $transport));

                    $this->date_transport_not_confirm($transport, $this->get_id_location_transport($result['code'],$result['model'],$transport));
                }else
                {
                    echo 'false';
                }

            }else
            {
                echo 'false';
            }
        }

    }


    function confirm_transport($transport)
    {
        if ($this->handleLogin()) {


            if (isset($_POST['submit'])) {


                $stmtdata = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 1 AND `userid`=?  AND  transport=? ");
                $stmtdata->execute(array($this->userid,$transport));
                $type_transport = null;
                while ($row = $stmtdata->fetch(PDO::FETCH_ASSOC)) {
                    $serialList = $_POST['serial_' . $row['code']];
                    $serialList = implode(',', $serialList);
                    $stmtSerial = $this->db->prepare("UPDATE    location_transport SET serial_conform=?   WHERE id=?  AND userid=? AND `active` = 1 AND transport=?");
                    $stmtSerial->execute(array($serialList, $row['id'], $this->userid,$transport));
                }


                $stmtdataCovert = $this->db->prepare("SELECT *FROM location_transport_convert WHERE   `userid`=? AND `active` =1 AND  transport=? ");
                $stmtdataCovert->execute(array($this->userid,$transport));
                $type_transport = null;
                while ($rowConvert = $stmtdataCovert->fetch(PDO::FETCH_ASSOC)) {
                    $serialListConvert = $_POST['serial_' . $rowConvert['code']];
                    $serialListConvert = implode(',', $serialListConvert);
                    $stmtSerialConvert = $this->db->prepare("UPDATE    location_transport_convert SET serial_conform=?   WHERE id=?  AND userid=? AND `active` =1  AND transport=?");
                    $stmtSerialConvert->execute(array($serialListConvert, $rowConvert['id'], $this->userid,$transport));
                }


                $stmtdata = $this->db->prepare("SELECT *FROM location_transport_convert WHERE  `active` = 1 AND `transport`=? ");
                $stmtdata->execute(array($transport));
                while ($row = $stmtdata->fetch(PDO::FETCH_ASSOC)) {
//                if ($row['model'] == 'savers') {
//                    $t = 'product_savers';
//                } else {
//                    $t = $row['model'];
//                }



                    if ($row['serial'])
                    {

                        $serial=explode(',',$row['serial']);
                        foreach ($serial as $serl)
                        {
                            if ($serl){

                                $stmtUpSerial = $this->db->prepare("UPDATE    serial  SET  location=?  , date=? , userid=?  WHERE  `code` = ? AND `serial`=?   AND model=?  ");
                                $stmtUpSerial->execute(array($row['location'], time(), $this->userid, $row['code'], $serl,$row['model']));

                                 $stmtUpJard = $this->db->prepare("UPDATE    jard  SET  location=?  , date=? , userid=?  WHERE  `code` = ? AND `serial`=?   AND model=?  ");
                                 $stmtUpJard->execute(array($row['location'], time(), $this->userid, $row['code'], $serl,$row['model']));


                                 $stmtUpJard_and_correction = $this->db->prepare("UPDATE    jard_and_correction  SET  location=?  , date=? , userid=?  WHERE  `code` = ? AND `serial`=?   AND model=?  ");
                                 $stmtUpJard_and_correction->execute(array($row['location'], time(), $this->userid, $row['code'], $serl,$row['model']));


                            }
                        }
                    }



                    $t = $row['model'];


                    $stmtu = $this->db->prepare("UPDATE    location SET  quantity=quantity - ?  , date=? , userid=?  WHERE  `location` = ? AND `code`=?   AND model=?  ");
                    $stmtu->execute(array((int)$row['quantity_trans'], time(), $this->userid, $row['from_location'], $row['code'], $t));
                    if ($stmtu->rowCount() > 0) {
                        $this->filter_location_tracking_quantity($row['code'], $t, $row['from_location'], (int)$row['quantity_trans'], ' تأكيد مناقلة - رقم14', '-', $transport);

                    } else {
                        $this->filter_location_error_quantity($row['code'], $t, $row['from_location'], (int)$row['quantity_trans'], '  تأكيد مناقلة - رقم الخظأ 14', '-', $transport);

                    }

                    $stmtc = $this->db->prepare("UPDATE    location SET  quantity=quantity + ? , date=? , userid=? WHERE  `location` = ? AND `code`=?   AND model=?  ");
                    $stmtc->execute(array((int)$row['quantity'], time(), $this->userid, $row['location'], $row['code'], $t));
                    if ($stmtc->rowCount() > 0) {
                        $this->filter_location_tracking_quantity($row['code'], $t, $row['location'], (int)$row['quantity'], '  تأكيد مناقلة - رقم15', '+', $transport);

                    } else {
                        $this->filter_location_error_quantity($row['code'], $t, $row['location'], (int)$row['quantity'], '  تأكيد مناقلةة - رقم الخظأ 15', '+', $transport);

                    }


                }


                $stmtfx1 = $this->db->prepare("UPDATE    location_transport SET  active=?,confirm_user=? WHERE  `transport` = ? ");
                $stmtfx1->execute(array(2, $this->userid, $transport));


                $stmtfx2 = $this->db->prepare("UPDATE    location_transport_convert SET  active=?,confirm_user=? WHERE  `transport` = ? ");
                $stmtfx2->execute(array(2, $this->userid, $transport));

                echo 'true';



            }

        }
    }





    function checkSerialCodeConvert()
    {
        if ($this->handleLogin())
        {
                $serial=trim($_GET['serial']);
                 $code=trim($_GET['code']);
                $model=trim($_GET['model']);
                $lastSerial=trim($_GET['lastSerial']);
            $stmt=$this->db->prepare("SELECT *FROM serial WHERE serial=? AND code=? AND model=?");
            $stmt->execute(array($serial,$code,$model));
            if ($stmt->rowCount() <= 0)
            {
                echo json_encode(array('info'=>'false'));
            }else{

                $result=$stmt->fetch(PDO::FETCH_ASSOC);

                 $date1=strtotime(date('Y-m-d h:i:s a',$result['date'])).'-';

                $stmt2=$this->db->prepare("SELECT *FROM serial WHERE serial=? AND code=? AND model=?");
                $stmt2->execute(array($lastSerial,$code,$model));
                $result2=$stmt2->fetch(PDO::FETCH_ASSOC);
                $date2=strtotime(date('Y-m-d h:i:s a',$result2['date']));
                if ($date1  > $date2)
                {
                    echo json_encode(array('info'=>'true','serialOld'=>'true'));
                }else
                {
                    echo json_encode(array('info'=>'true','serialOld'=>'false'));
                }

            }


        }


    }




    function delete_all_row_loc($id, $transport)
    {
        if ($this->handleLogin()) {

            $stmt1 = $this->db->prepare("SELECT * FROM location_transport WHERE  `id` = ? AND transport=?   ");
            $stmt1->execute(array($id, $transport));
            $result = $stmt1->fetch(PDO::FETCH_ASSOC);


            $stmt2 = $this->db->prepare("DELETE FROM location_transport_convert WHERE  `code` = ? AND `color`=? AND `model`=?  AND transport=?  ");
            $stmt2->execute(array($result['code'], $result['color'], $result['model'], $transport));


            $stmt3 = $this->db->prepare("DELETE FROM location_transport WHERE  `id` = ? AND `transport` =? AND `active`=1");
            $stmt3->execute(array($id, $transport));


            $stmtdata = $this->db->prepare("SELECT COUNT(id) as c FROM location_transport WHERE  `active` = 1 AND `transport`=?");
            $stmtdata->execute(array($transport));
            $resultd = $stmtdata->fetch(PDO::FETCH_ASSOC);
            if ($resultd['c'] == 0) {
                echo '0';
            } else {
                $this->date_transport_not_confirm($transport,$id);
            }


        }

    }



    function delete_transport_before_conform()
    {

        if ($this->handleLogin()) {
            $transport = $_GET['transport'];

            $stmt = $this->db->prepare("DELETE FROM location_transport WHERE `transport` =? ");
            $stmt->execute(array($transport));

            $stmt2 = $this->db->prepare("DELETE FROM location_transport_convert WHERE `transport` =? ");
            $stmt2->execute(array($transport));


            echo 'delete';

        }
    }



/*
    function confirm_transport_set()
    {
        if ($this->handleLogin()) {

            $stmtdata = $this->db->prepare("SELECT *FROM location_transport_convert WHERE   model='savers'  AND transport NOT IN (16,17,15)");
            $stmtdata->execute();
            while ($row = $stmtdata->fetch(PDO::FETCH_ASSOC)) {
//                if ($row['model'] == 'savers') {
//                    $t = 'product_savers';
//                } else {
//
//                }
                $t = $row['model'];
             echo     $row['transport'].'<br>';



                $stmtx = $this->db->prepare("SELECT * FROM    location  WHERE   `location` = ? AND `code`=?   AND model=?  ");
                $stmtx->execute(array($row['from_location'], $row['code'], $t));
                if ($stmtx->rowCount() > 0)
                {
                    $rr=$stmtx->fetch(PDO::FETCH_ASSOC);
                    $q=(int)$rr['quantity']-(int)$row['quantity_trans'];
                    if ($q >= 0)
                    {

                        $stmtu = $this->db->prepare("UPDATE    location SET  quantity=quantity - ? WHERE  `location` = ? AND `code`=?   AND model=?  AND quantity  ");
                        $stmtu->execute(array((int)$row['quantity_trans'], $row['from_location'], $row['code'], $t));

                        $stmtc = $this->db->prepare("UPDATE    location SET  quantity=quantity + ? WHERE  `location` = ? AND `code`=?   AND model=?  ");
                        $stmtc->execute(array((int)$row['quantity'], $row['location'], $row['code'], $t));

                    }


                }


            }


        }

    }



function xs()
{


    $stmtdata = $this->db->prepare("SELECT *FROM location_transport_convert WHERE active =2 AND  model ='savers' ");
    $stmtdata->execute();
    while ($row = $stmtdata->fetch(PDO::FETCH_ASSOC)) {


       $a=  explode('-',$row['from_location']);

        if (count($a) >= 2)
        {

            if ($a[0] ==$row['location'] ) {
                $stmtins = $this->db->prepare("SELECT *FROM location WHERE `model`=? AND location  = ?   AND `code` =? ");
                $stmtins->execute(array('savers', $row['location'], $row['code']));
                if ($stmtins->rowCount() < 1) {

                    $stmtInsert = $this->db->prepare("INSERT INTO  location (location,quantity,code,model,`date`,userid,`new_location`)  values (?,?,?,?,?,?,?)");
                    $stmtInsert->execute(array($row['location'], (int)$row['quantity'], $row['code'], 'savers', time(), $this->userid, 1));

                    echo $row['transport'];
                    echo    '<br>';
                }
            }
        }



    }


}


*/


}

