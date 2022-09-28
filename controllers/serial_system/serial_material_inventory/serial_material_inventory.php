<?php

trait serial_material_inventory
{

    protected  $data_code=array();
    protected  $q_serial=0;

    function __construct()
    {
        parent::__construct();
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject
    }



    function  serial_material_inventory($model='mobile')
    {

        $this->checkPermit('serial_material_inventory',$this->folder);
        $this->adminHeaderController($this->langControl($this->folder));


        if (isset($_GET['model']) && isset($_GET['category'])) {

            $categoryIds = $_GET['category'];


            $id = explode('_', $categoryIds);
            $id = $id[1];


            $model = $_GET['model'];

            $name_category = 'category_' . $model;
            $breadcumbsx = $this->BreadcumbsPublic($name_category, $id);
            $category ='<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) .' </li> ';
            foreach ($breadcumbsx as $key => $cat) {
                $category .= '<li class="breadcrumb-item active" aria-current="page" >' . $key .' </li> ';
            }


        } else if (isset($_GET['model']))
        {
            $id = null;
            $model = $_GET['model'];
            $category ='<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) .' </li> ';

        }else
        {

            $id=null;
           $category ='<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) .' </li> ';

        }




        require ($this->render($this->folder,'serial_material_inventory/html','material','php'));
        $this->adminFooterController();

    }


    public function processing_serial_material_inventory($model='mobile',$id=null)
    {

        $table = $model;
        $primaryKey = $model.'.id';

        if ($model=='mobile') {
            $code = 'code';
            $color = 'color';
            $excel = 'excel';
        }else  {
            $code = 'code_'.$model;
            $color = 'color_'.$model;
            $excel = 'excel_'.$model;
        }
        $category='category_'.$model;

        $columns = array(

            array( 'db' => 'serial.model', 'dt' => 0 ,
                'formatter' => function ($id, $row) {
                    return  $id."[". $this->langControl($id) ."]";
                }
            ),
            array( 'db' => $table.'.title', 'dt' => 1 ),
            array( 'db' => 'serial.bill', 'dt' => 2),
            array( 'db' => 'serial.code', 'dt' => 3),

            array( 'db' =>  "(SELECT   GROUP_CONCAT(spare_code SEPARATOR ',')      FROM spare_code WHERE spare_code.code = serial.code AND spare_code.model = serial.model)", 'dt' => 4 ,
                'formatter' => function ($id, $row) {
                return $row[4];
                }
            ),


            array( 'db' => $color.'.color', 'dt' => 5   ),
            array( 'db' => $code.'.code', 'dt' => 6 ),
            array( 'db' => 'serial.code', 'dt' => 7,
                'formatter' => function ($id, $row) {

                $this->q_serial=$this->sum_serial_enter($id,$row[0]);
                $m="'{$row[0]}'";
                return '
                <button class="btn btn-warning btn_quantity_enter" onclick="get_serial('.$id.','.$m.')"  type="button" data-toggle="collapse" data-target="#multiCollapseExample-'.$id.$row[0].'" aria-expanded="false" aria-controls="multiCollapseExample'.$id.$row[0].'">'.$this->q_serial.'</button>
                   <div class="collapse multi-collapse" id="multiCollapseExample-'.$id.$row[0].'">
                      <div style="padding: 5px;margin:0" class="card card-body" id="data_collapse_'.$id.$row[0].'">
                   </div>
                </div>
                ';
                }
                ),

            array( 'db' => 'serial.code', 'dt' => 8,
                'formatter' => function ($id, $row) {

                $m="'{$row[0]}'";
                return '
                <button class="btn btn-info btn_quantity_enter" onclick="get_location_serial('.$id.','.$m.')"  type="button" data-toggle="collapse" data-target="#get_location_serial-'.$id.$row[0].'" aria-expanded="false" aria-controls="get_location_serial'.$id.$row[0].'">'. $this->q_serial.'</button>
                   <div class="collapse multi-collapse" id="get_location_serial-'.$id.$row[0].'">
                      <div style="padding: 5px;margin:0" class="card card-body" id="location_serial_data_collapse_'.$id.$row[0].'">
                   </div>
                </div>
                ';
                }
             ),


            array( 'db' =>  "(SELECT quantity  FROM {$excel} WHERE {$excel}.code = serial.code )", 'dt' => 9 ,
                'formatter' => function ($id, $row) {
                    return  $row[9];
                }
            ),


            array( 'db' =>  "(SELECT SUM(location.quantity) FROM location WHERE location.code =  serial.code AND location.model =  serial.model)", 'dt' => 10 ,
                'formatter' => function ($id, $row) {

                    $m="'{$row[0]}'";
                    $q=0;
                     if ($row[10])
                        {
                            $q=$row[10];
                        }
                    return '
                   <button class="btn btn-primary btn_location" onclick="list_location('.$row[3].','.$m.')"  type="button" data-toggle="collapse" data-target="#get_location-'.$row[3].$row[0].'" aria-expanded="false" aria-controls="get_location'.$row[3].$row[0].'">'.$q.'</button>
                   <div class="collapse multi-collapse" id="get_location-'.$row[3].$row[0].'">
                      <div style="padding: 5px;margin:0" class="card card-body" id="data_location_'.$row[3].$row[0].'">
                   </div>
                </div>
                ';

                }
            ),

            array( 'db' =>  'serial.date', 'dt' => 11 ,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),



            array( 'db' => 'serial.code', 'dt' => 12,
                'formatter' => function ($id, $row) {

                    $m="'{$row[0]}'";
                    return '
                <button class="btn btn-success btn-sm " onclick="quantity_correction(this,'.$id.','.$m.')"  type="button"  >تصحيح</button>
               
                ';
                }
            ),


            array( 'db' =>  'serial.code', 'dt' => 13 ,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_serial',$this->folder))
                    {
                        $id="'{$id}'";
                        $m="'{$row[0]}'";
                        return '
                          <button class="btn btn-danger" onclick="delete_serial_by_code('.$id.','.$m.')"  type="button"  ><i class="fa fa-trash"></i> </button>   
                    ';
                    }
                }
            ),

            array(  'db' =>   'serial.id', 'dt'=> 14),




        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );




        if ($model !=null && $id != null)
        {
            $this->ids[]=$id;
            if (!empty($this->getLoopIdX($id,$category)))
            {
                $this->ids[]=  $this->getLoopIdX($id,$category);
            }
            $ids_cat=implode(',', $this->ids);




//            if ($this->admin($this->userid))
//            {
//                $whereAll = array("");
//            }else
//            {
//                $whereAll = array("userId={$this->userid}");
//            }


            $join = "INNER JOIN {$color} ON {$color}.id_item={$model}.id INNER JOIN `{$code}` ON {$code}.id_color={$color}.id  INNER JOIN serial ON serial.code={$code}.code";
            $whereAll = array("{$model}.id_cat IN({$ids_cat})","serial.model='{$model}'");

            $group="  GROUP BY serial.code, serial.model  ";
            $result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,1);

            echo json_encode($result);

        }else{

            $join = "INNER JOIN {$color} ON {$color}.id_item={$model}.id INNER JOIN `{$code}` ON {$code}.id_color={$color}.id  INNER JOIN serial ON serial.code={$code}.code";
            $whereAll = array("serial.model='{$model}'");
            $group="  GROUP BY serial.code, serial.model  ";

            $result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,1);


            echo json_encode($result);


        }




    }


    public function processing_serial_material_inventory_accessories($model,$id=null)
    {

        $table = $model;
        $primaryKey = $model.'.id';

        $color = 'color_'.$model;

        $category='category_'.$model;

        $columns = array(

            array( 'db' => 'serial.model', 'dt' => 0 ,
                'formatter' => function ($id, $row) {
                    return  $id."[". $this->langControl($id) ."]";
                }
            ),
            array( 'db' => $table.'.title', 'dt' => 1  ),
            array( 'db' => 'serial.bill', 'dt' => 2),
            array( 'db' => 'serial.code', 'dt' => 3),

            array( 'db' =>  "(SELECT   GROUP_CONCAT(spare_code SEPARATOR ',')      FROM spare_code WHERE spare_code.code = serial.code AND spare_code.model = serial.model)", 'dt' => 4 ,
                'formatter' => function ($id, $row) {
                return $row[4];
                }
            ),


            array( 'db' => $color.'.color', 'dt' => 5 ),
            array( 'db' => $color.'.code', 'dt' => 6 ,
                'formatter' => function ($id, $row) {
                    return  '';
                }
            ),
            array( 'db' => 'serial.code', 'dt' => 7,
                'formatter' => function ($id, $row) {

                $this->q_serial=$this->sum_serial_enter($id,$row[0]);
                $m="'{$row[0]}'";
                return '
                <button class="btn btn-warning btn_quantity_enter" onclick="get_serial('.$id.','.$m.')"  type="button" data-toggle="collapse" data-target="#multiCollapseExample-'.$id.$row[0].'" aria-expanded="false" aria-controls="multiCollapseExample'.$id.$row[0].'">'.$this->q_serial.'</button>
                   <div class="collapse multi-collapse" id="multiCollapseExample-'.$id.$row[0].'">
                      <div style="padding: 5px;margin:0" class="card card-body" id="data_collapse_'.$id.$row[0].'">
                   </div>
                </div>
                ';
                }
                ),

            array( 'db' => 'serial.code', 'dt' => 8,
                'formatter' => function ($id, $row) {

                $m="'{$row[0]}'";
                return '
                <button class="btn btn-info btn_quantity_enter" onclick="get_location_serial('.$id.','.$m.')"  type="button" data-toggle="collapse" data-target="#get_location_serial-'.$id.$row[0].'" aria-expanded="false" aria-controls="get_location_serial'.$id.$row[0].'">'. $this->q_serial.'</button>
                   <div class="collapse multi-collapse" id="get_location_serial-'.$id.$row[0].'">
                      <div style="padding: 5px;margin:0" class="card card-body" id="location_serial_data_collapse_'.$id.$row[0].'">
                   </div>
                </div>
                ';
                }
             ),


            array( 'db' =>  "(SELECT quantity  FROM excel_accessories WHERE excel_accessories.code = serial.code )", 'dt' => 9 ,
                'formatter' => function ($id, $row) {
                    return  $row[9];
                }
            ),

            array( 'db' =>  "(SELECT SUM(location.quantity) FROM location WHERE location.code =  serial.code AND location.model =  serial.model)", 'dt' => 10 ,
                'formatter' => function ($id, $row) {

                    $m="'{$row[0]}'";
                    $q=0;
                     if ($row[10])
                        {
                            $q=$row[10];
                        }
                    return '
                   <button class="btn btn-primary btn_location" onclick="list_location('.$row[3].','.$m.')"  type="button" data-toggle="collapse" data-target="#get_location-'.$row[3].$row[0].'" aria-expanded="false" aria-controls="get_location'.$row[3].$row[0].'">'.$q.'</button>
                   <div class="collapse multi-collapse" id="get_location-'.$row[3].$row[0].'">
                      <div style="padding: 5px;margin:0" class="card card-body" id="data_location_'.$row[3].$row[0].'">
                   </div>
                </div>
                ';

                }
            ),

            array( 'db' =>  'serial.date', 'dt' => 11 ,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),



            array( 'db' => 'serial.code', 'dt' => 12,
                'formatter' => function ($id, $row) {

                    $m="'{$row[0]}'";
                    return '
                <button class="btn btn-success btn-sm " onclick="quantity_correction(this,'.$id.','.$m.')"  type="button"  >تصحيح</button>
               
                ';
                }
            ),


            array( 'db' =>  'serial.code', 'dt' => 13 ,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_serial',$this->folder))
                    {
                        $id="'{$id}'";
                        $m="'{$row[0]}'";
                        return '
                          <button class="btn btn-danger" onclick="delete_serial_by_code('.$id.','.$m.')"  type="button"  ><i class="fa fa-trash"></i> </button>   
                    ';
                    }
                }
            ),

            array(  'db' =>   'serial.id', 'dt'=> 14),




        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );





        if ($model !=null && $id != null)
        {
            $this->ids[]=$id;
            if (!empty($this->getLoopIdX($id,$category)))
            {
                $this->ids[]=  $this->getLoopIdX($id,$category);
            }
            $ids_cat=implode(',', $this->ids);


            $join = "INNER JOIN {$color} ON {$color}.id_item={$model}.id  INNER JOIN serial ON serial.code={$color}.code ";
            $whereAll = array("{$model}.id_cat IN({$ids_cat})" ,"serial.model='{$model}'");

            $group="  GROUP BY serial.code, serial.model  ";
            $result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,1);

            echo json_encode($result);

        }else{

            $join = "INNER JOIN {$color} ON {$color}.id_item={$model}.id  INNER JOIN serial ON serial.code={$color}.code";
            $whereAll = array( "serial.model='{$model}'","serial.model='{$model}'" );


            $group="  GROUP BY serial.code, serial.model  ";

            $result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,1);



            echo json_encode($result);


        }


    }



    public function processing_serial_material_inventory_savers ($model,$id=null)
    {

        $table = 'product_savers';
        $primaryKey = 'product_savers.id';
        $category='type_device';

        $columns = array(

            array( 'db' => 'serial.model', 'dt' => 0 ,
                'formatter' => function ($id, $row) {
                    return  $id."[". $this->langControl($id) ."]";
                }
            ),
            array( 'db' => $table.'.title', 'dt' => 1  ),
            array( 'db' => 'serial.bill', 'dt' => 2),
            array( 'db' => 'serial.code', 'dt' => 3),

            array( 'db' =>  "(SELECT   GROUP_CONCAT(spare_code SEPARATOR ',')      FROM spare_code WHERE spare_code.code = serial.code AND spare_code.model = serial.model)", 'dt' => 4 ,
                'formatter' => function ($id, $row) {
                return $row[4];
                }
            ),


            array( 'db' => $table.'.color', 'dt' => 5 ),
            array( 'db' => $table.'.code', 'dt' => 6 ,
                'formatter' => function ($id, $row) {
                    return  '';
                }
            ),
            array( 'db' => 'serial.code', 'dt' => 7,
                'formatter' => function ($id, $row) {

                $this->q_serial=$this->sum_serial_enter($id,$row[0]);
                $m="'{$row[0]}'";
                return '
                <button class="btn btn-warning btn_quantity_enter" onclick="get_serial('.$id.','.$m.')"  type="button" data-toggle="collapse" data-target="#multiCollapseExample-'.$id.$row[0].'" aria-expanded="false" aria-controls="multiCollapseExample'.$id.$row[0].'">'.$this->q_serial.'</button>
                   <div class="collapse multi-collapse" id="multiCollapseExample-'.$id.$row[0].'">
                      <div style="padding: 5px;margin:0" class="card card-body" id="data_collapse_'.$id.$row[0].'">
                   </div>
                </div>
                ';
                }
                ),

            array( 'db' => 'serial.code', 'dt' => 8,
                'formatter' => function ($id, $row) {

                $m="'{$row[0]}'";
                return '
                <button class="btn btn-info btn_quantity_enter" onclick="get_location_serial('.$id.','.$m.')"  type="button" data-toggle="collapse" data-target="#get_location_serial-'.$id.$row[0].'" aria-expanded="false" aria-controls="get_location_serial'.$id.$row[0].'">'. $this->q_serial.'</button>
                   <div class="collapse multi-collapse" id="get_location_serial-'.$id.$row[0].'">
                      <div style="padding: 5px;margin:0" class="card card-body" id="location_serial_data_collapse_'.$id.$row[0].'">
                   </div>
                </div>
                ';
                }
             ),


            array( 'db' =>  "(SELECT quantity  FROM excel_savers WHERE excel_savers.code =  serial.code )", 'dt' => 9 ,
                'formatter' => function ($id, $row) {
                    return  $row[9];
                }
            ),

            array( 'db' =>  "(SELECT SUM(location.quantity) FROM location WHERE location.code =  serial.code AND location.model =  serial.model)", 'dt' => 10 ,
                'formatter' => function ($id, $row) {

                    $m="'{$row[0]}'";
                    $q=0;
                     if ($row[10])
                        {
                            $q=$row[10];
                        }
                    return '
                   <button class="btn btn-primary btn_location" onclick="list_location('.$row[3].','.$m.')"  type="button" data-toggle="collapse" data-target="#get_location-'.$row[3].$row[0].'" aria-expanded="false" aria-controls="get_location'.$row[3].$row[0].'">'.$q.'</button>
                   <div class="collapse multi-collapse" id="get_location-'.$row[3].$row[0].'">
                      <div style="padding: 5px;margin:0" class="card card-body" id="data_location_'.$row[3].$row[0].'">
                   </div>
                </div>
                ';

                }
            ),

            array( 'db' =>  'serial.date', 'dt' => 11 ,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),



            array( 'db' => 'serial.code', 'dt' => 12,
                'formatter' => function ($id, $row) {

                    $m="'{$row[0]}'";
                    return '
                <button class="btn btn-success btn-sm " onclick="quantity_correction(this,'.$id.','.$m.')"  type="button"  >تصحيح</button>
               
                ';
                }
            ),


            array( 'db' =>  'serial.code', 'dt' => 13 ,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_serial',$this->folder))
                    {
                        $code="'{$id}'";
                        $model="'{$row[0]}'";
                        return '
                          <button class="btn btn-danger" onclick="delete_serial_by_code('.$code.','.$model.')"  type="button"  ><i class="fa fa-trash"></i> </button>   
                    ';
                    }
                }
            ),

            array(  'db' =>   'serial.id', 'dt'=> 14),




        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );





        $join = "INNER JOIN serial ON serial.code={$table}.code  ";
        $whereAll = array( "serial.model='savers'" );

        $group="  GROUP BY serial.code, serial.model  ";
        $result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null,  $whereAll,null,$group,1);

        echo json_encode($result);



    }


    function getLoopIdX($id,$category)
    {

        $stmt=$this->db->prepare("SELECT *from  {$category} WHERE  `relid` = {$id} AND `active` = 1 ");
        $stmt->execute(array($id));
        while (  $s=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $this->ids[]=$s['id'];
            $this->getLoopIdX($s['id'],$category);

        }

    }

    function getLoopId($id,$category)
    {

        if (!empty($id))
        {
            $this->ids[]=$id;
        }

        $stmt=$this->db->prepare("SELECT *from  {$category} WHERE  `relid` = {$id} AND `active` = 1 ");
        $stmt->execute(array($id));
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $this->ids[]=$row['id'];


            $this->getLoopIdX($row['id'],$category);
        }

        return $this->ids;
    }




    function quantity_correction($code,$model)
    {

        $stmt  = $this->db->prepare("SELECT  SUM(quantity) as q FROM serial  WHERE code=? AND  model=?");
        $stmt ->execute(array($code,$model ));
        $q= $stmt ->fetch(PDO::FETCH_ASSOC)['q'] ;
        if ($model=='mobile')
        {
            $excel='excel';
        }
        else
        {
            $excel='excel_'.$model;
        }




        $stmtchlocation = $this->db->prepare("SELECT  *FROM serial  WHERE code=? AND  model=? AND location <> '' ");
        $stmtchlocation ->execute(array($code,$model));
          if ($stmtchlocation->rowCount() > 0) {


                  $stmtOldLocationQuantity = $this->db->prepare('SELECT  location,quantity FROM location WHERE code=? AND model=?   ');
                  $stmtOldLocationQuantity->execute(array($code, $model));
                  $resultOldLocation =array();
                  $OldLocation_quantity=0;
                  while ($row = $stmtOldLocationQuantity->fetch(PDO::FETCH_ASSOC))
                  {
                      $OldLocation_quantity=$OldLocation_quantity+$row['quantity'];
                      $resultOldLocation[]=$row;
                  }


                  $stmtNewLocationSerialQuantity = $this->db->prepare("SELECT  location,quantity FROM serial WHERE code=? AND model=?    AND location <> '' ");
                  $stmtNewLocationSerialQuantity->execute(array($code, $model));
                  $resultNewLocationSerial =array();
                  $NewLocationSerial_quantity=0;
                  $checkLocationInModel=true;
                  $checkLocationInModelNotFound=array();
                  while ($row = $stmtNewLocationSerialQuantity->fetch(PDO::FETCH_ASSOC))
                  {
                      if ($row['location']) {
                          $stmtChModelLocation = $this->db->prepare("SELECT  *FROM location_model  WHERE location=? AND  model=?  LIMIT 1");
                          $stmtChModelLocation->execute(array($row['location'], $model));
                          if ($stmtChModelLocation->rowCount() <= 0) {
                              $checkLocationInModelNotFound[] = $row['location'];
                              $checkLocationInModel = false;
                          }

                          $NewLocationSerial_quantity = $NewLocationSerial_quantity + $row['quantity'];
                          $resultNewLocationSerial[] = $row;
                      }
                  }





                  if ($checkLocationInModel) {
                      $stmt_serial_correct_location_deleted = $this->db->prepare("INSERT INTO  serial_correct_location_deleted ( oldlocation, newlocation, code, model, userId, date)  values (?,?,?,?,?,?)");
                      $stmt_serial_correct_location_deleted->execute(array(json_encode($resultOldLocation), json_encode($resultNewLocationSerial), $code, $model, $this->userid, time()));
                      if ($stmt_serial_correct_location_deleted->rowCount() > 0) {

                          $stmtDeleteLocation = $this->db->prepare("DELETE FROM location WHERE code=? AND  model=?");
                          $stmtDeleteLocation->execute(array($code, $model));
                          if ($stmtDeleteLocation->rowCount() > 0) {

                              $this->filter_location_tracking_quantity($code, $model, 'حذف المواقع وتجديدها ', 0, '  نظام السيريلات - تصحيح   - رقم49', '--');

                          } else {
                              $this->filter_location_error_quantity($code, $model, 'حذف المواقع وتجديدها ', 0, '  نظام السيريلات - تصحيح   -  رقم الخطا 49', '--');

                          }
                              $qConform = $q - $NewLocationSerial_quantity;

                              $stmtExcel = $this->db->prepare("UPDATE  $excel  SET  quantity={$q} ,userid=? ,date=? WHERE code =?");
                              $stmtExcel->execute(array($this->userid, time(), $code));

                              $stmtl = $this->db->prepare("SELECT  *FROM serial  WHERE code=? AND  model=? GROUP BY serial,location");
                              $stmtl->execute(array($code, $model));
                              while ($row = $stmtl->fetch(PDO::FETCH_ASSOC)) {

                                  $stmtls = $this->db->prepare("SELECT SUM(quantity) as q FROM serial  WHERE code=? AND  model=? AND  location = ? ");
                                  $stmtls->execute(array($code, $model, $row['location']));
                                  if ($stmtls->rowCount() > 0) {
                                      $lq = $stmtls->fetch(PDO::FETCH_ASSOC)['q'];

                                      $stmtModelLocation = $this->db->prepare("SELECT  *FROM location_model  WHERE location=? AND  model=?  LIMIT 1");
                                      $stmtModelLocation->execute(array($row['location'], $model));
                                      if ($stmtModelLocation->rowCount() > 0) {
                                          $modelLocation = $stmtModelLocation->fetch(PDO::FETCH_ASSOC);

                                          $stmtUplocation = $this->db->prepare("INSERT INTO location (code, location, quantity, model, date, userid, sequence) VALUES (?,?,?,?,?,?,?)");
                                          $stmtUplocation->execute(array($code, $row['location'], $lq, $model, time(), $this->userid, $modelLocation['sequence']));
                                          if ($stmtUplocation->rowCount() > 0) {
                                              $this->filter_location_tracking_quantity($code, $model, $row['location'], $lq, '  نظام السيريلات - تصحيح   - رقم50', '+');

                                          } else {
                                              $this->filter_location_error_quantity($code, $model, $row['location'], $lq, '  نظام السيريلات - تصحيح   -  رقم الخطا 50', '+');

                                          }

                                      }
                                  }

                              }

                              echo 'true';

                              $stmtChCodeConform = $this->db->prepare("SELECT *FROM location_confirm WHERE code =? AND model=?");
                              $stmtChCodeConform->execute(array($code, $model));
                              if ($stmtChCodeConform->rowCount() > 0) {
                                  $stmtExcel_conform = $this->db->prepare("UPDATE location_confirm SET  quantity= $qConform  ,`date`=?,userid=?  WHERE code =? AND  model=?");
                                  $stmtExcel_conform->execute(array(time(), $this->userid, $code, $model));
                                  if ($stmtExcel_conform->rowCount() <= 0) {
                                      $this->filter_error_quantity($code, $model, $qConform, '   نظام السيريلات - تصحيح      - رقم الخطا 52');
                                  }
                              } else {
                                  $stmtExcel_conform = $this->db->prepare("INSERT INTO  location_confirm (quantity,code,model,date,userid)  values (?,?,?,?,?)");
                                  $stmtExcel_conform->execute(array($qConform, $code, $model, time()));
                                  if ($stmtExcel_conform->rowCount() <= 0) {
                                      $this->filter_error_quantity($code, $model, $qConform, '  نظام السيريلات - تصحيح     - رقم الخطا 53');
                                  }
                              }


                              $stmtExcel_conform = $this->db->prepare("UPDATE location_confirm SET  quantity=0 ,`date`=?,userid=?  WHERE code =? AND  model=? AND quantity < 0 ");
                              $stmtExcel_conform->execute(array(time(), $this->userid, $code, $model));




                      }
                  }else
                  {
                      $notFoundLocationmodel=implode(' - ',$checkLocationInModelNotFound);

                      echo '  هذه المواقع  [   ' . $notFoundLocationmodel . '  ]  غير موجودة في مواقع القسم يرجى اضافتها قبل اجراء التصحيح' ;
                  }

          }else
          {
              echo 'nolocation';
          }

      }



    function time_taken($code,$model)
    {

        if ($this->admin($this->userid))
        {
            $stmt  = $this->db->prepare("SELECT  time_taken  FROM serial  WHERE code=? AND  model=? ORDER BY  id DESC LIMIT 1");
            $stmt ->execute(array($code,$model));
        }else
        {
            $stmt  = $this->db->prepare("SELECT  time_taken  FROM serial  WHERE code=? AND  model=? AND userId =? ORDER BY  id DESC LIMIT 1");
            $stmt ->execute(array($code,$model,$this->userid));
        }

        return $stmt ->fetch(PDO::FETCH_ASSOC)['time_taken'] ;
    }


    function sum_serial_enter($code,$model)
    {

            $stmt  = $this->db->prepare("SELECT  SUM(quantity) as q FROM serial  WHERE code=? AND  model=?");
            $stmt ->execute(array($code,$model ));
            return $stmt ->fetch(PDO::FETCH_ASSOC)['q'] ;

    }






    function list_location ($code,$model)
    {


            $stmt  = $this->db->prepare("SELECT    location,quantity  FROM location  WHERE code=? AND  model=?  ");
            $stmt ->execute(array($code,$model));

        $html = "<table class='table_location'>";
        if ($stmt->rowCount() > 0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $html .= "<tr> <td>{$this->tamayaz_locations($row['location'])}<td><span class='badge badge-pill badge-success'>{$row['quantity']} </span></td> </tr>    ";
             }
        }else
        {
            $html .= "</tr><td> لا يوجد مواقع</td></tr>";
        }
        $html .="</table>";
        echo $html;
    }


    function get_location_serial ($code,$model)
    {


            $stmt  = $this->db->prepare("SELECT    serial,location    FROM serial  WHERE code=? AND  model=?  AND location <>''  ORDER BY serial");
            $stmt ->execute(array( $code,$model));

        $html = "<table class='table_serial_location'>";
        if ($stmt->rowCount() > 0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $html .= "<tr> <td>{$row['serial']}<td><span>{$this->tamayaz_locations($row['location'])} </span></td> </tr>    ";
             }
        }else
        {
            $html .= "</tr><td> لا يوجد مواقع</td></tr>";
        }
        $html .="</table>";
        echo $html;
    }



    function list_location_no_html ($code,$model)
    {

            $stmt  = $this->db->prepare("SELECT    location,quantity  FROM location  WHERE code=? AND  model=?  ");
            $stmt ->execute(array($code,$model));
            $location=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $row['location']=$this->tamayaz_locations($row['location']);

                $location[]=$row;
             }
          return $location;
    }





    function delete_serial_sale($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM  user WHERE `id` = ? AND `delete_serial_sale` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return  false;
        }

    }

    function delete_serial($id)
    {
        if ($this->handleLogin())
        {

            $stmtRow = $this->db->prepare("SELECT * FROM serial WHERE id=? ");
            $stmtRow ->execute(array($id));
            $result=$stmtRow->fetch(PDO::FETCH_ASSOC);






            if ($this->delete_serial_sale($this->userid))
            {

                $time = time();
                $stmtData = $this->db->prepare("INSERT INTO serial_delete (page, bill, code, serial, type_enter, quantity, model, userId, date)  SELECT page, bill, code, serial, type_enter, quantity, model, $this->userid, $time  FROM serial WHERE id=?");
                $stmtData->execute(array($id));

                $stmt = $this->db->prepare("DELETE FROM serial WHERE id=?");
                $stmt->execute(array($id));
                $this->insertCodeSerial_conform($result['code'], $result['model'], 'حذف سيريال');
                echo 'true';

            }   else {


                $serial = '[[:<:]]' . $result['serial'] . '[[:>:]]';

                $stmt_serial = $this->db->prepare("SELECT *FROM `cart_shop_active`  WHERE `enter_serial`  REGEXP ?  LIMIT 1");
                $stmt_serial->execute(array($serial));
                if ($stmt_serial->rowCount() > 0) {
                    echo 'false';
                } else {


                    $time = time();
                    $stmtData = $this->db->prepare("INSERT INTO serial_delete (page, bill, code, serial, type_enter, quantity, model, userId, date)  SELECT page, bill, code, serial, type_enter, quantity, model, $this->userid, $time  FROM serial WHERE id=?");
                    $stmtData->execute(array($id));

                    $stmt = $this->db->prepare("DELETE FROM serial WHERE id=?");
                    $stmt->execute(array($id));
                    $this->insertCodeSerial_conform($result['code'], $result['model'], 'حذف سيريال');
                    echo 'true';
                }
            }
        }

    }

    function delete_serial_by_code($code,$model)
    {
        if ($this->handleLogin())
        {


            if ($model == 'deleted')
            {
                $stmt  = $this->db->prepare("DELETE FROM serial WHERE code=?  ");
                $stmt ->execute(array($code));
                die('true');
            }

            $time=time();
            if ($this->admin($this->userid))
            {
                $stmtRow = $this->db->prepare("SELECT * FROM serial WHERE code=? AND model=?");
                $stmtRow ->execute(array($code,$model));
            }else
            {
                $stmtRow = $this->db->prepare("SELECT * FROM serial WHERE code=? AND model=? AND  userId=?");
                $stmtRow ->execute(array($code,$model,$this->userid));
            }

            while ($row = $stmtRow->fetch(PDO::FETCH_ASSOC) )
            {
                $stmtData  = $this->db->prepare("INSERT INTO serial_delete (page, bill, code, serial, type_enter, quantity, model, userId, date)  SELECT page, bill, code, serial, type_enter, quantity, model, $this->userid, $time  FROM serial WHERE id=?");
                $stmtData ->execute(array($row['id']));
                $this->insertCodeSerial_conform($row['code'],$row['mode'],'حذف سيريال');

            }
            if ($this->admin($this->userid))
            {
                $stmt  = $this->db->prepare("DELETE FROM serial WHERE code=? AND model=?");
                $stmt ->execute(array($code,$model));

            }else
            {
                $stmt  = $this->db->prepare("DELETE FROM serial WHERE code=? AND model=? AND userId=?");
                $stmt ->execute(array($code,$model,$this->userid));


            }
            echo 'true';
        }

    }




}