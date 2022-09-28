<?php

class case_reports extends Controller
{


    function __construct()
    {
        parent::__construct();
        $this->table = 'case_reports';
    }

    function index($model)
    {

        $this->checkPermit($model, $this->folder);
        $this->adminHeaderController($this->langControl($model));



        require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();

    }


    function tab($model,$active=null)
    {

        require($this->render($this->folder, 'html', 'tab', 'php'));
    }


    function list_case($model,$type=1)
    {

        $this->checkPermit($model, $this->folder);
        $this->adminHeaderController($this->langControl($model));

         $active1='';
         $active2='';
         $active3='';
         $active4='';
         $active5='';
         $active6='';
        $processing='processing';
        if ($type==1)
        {
            $active1='active_case';

            $processing='processing';
            require($this->render($this->folder, 'html', 'index', 'php'));


        }else if ($type==2)
        {
            $active2='active_case';
            $processing='processing2';
            require($this->render($this->folder, 'html', 'index2', 'php'));


        }else if ($type==3)
        {
            $active3='active_case';
            $processing='processing3';
            require($this->render($this->folder, 'html', 'index3', 'php'));


        }else if ($type==4)
        {
            $active4='active_case';
            $processing='processing4';
            require($this->render($this->folder, 'html', 'index2', 'php'));


        }else  if ($type==5)
        {
            $active5='active_case';
            $processing='processing5';
            require($this->render($this->folder, 'html', 'index2', 'php'));


        }else
        {
            $active6='active_case';
            require($this->render($this->folder, 'html', 'index2', 'php'));

        }

        $this->adminFooterController();

    }



    public function processing($model=null)
    {



        if ($model=='mobile') {
            $excel = 'excel';
            $code = 'code';
            $color = 'color';
        }else  {
            $excel  = 'excel_'.$model;
            $code = 'code_'.$model;
            $color = 'color_'.$model;
        }
        $table = $excel;
        $primaryKey = $table.'.id';

        if ($model =='savers')
        {
            $model='product_savers';
        }

        if ($model=='product_savers')
        {

        $columns = array(
        array('db' => $model.'.img', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    if ($d)
                    {
                        return "<img width=100 src='".$this->save_file.$d."' >";
                    }else{
                        return 'لاتوجد صورة';
                    }
                }
            ),
            array(  'db' =>$model.'.title', 'dt'=>1),
            array(  'db' => $excel.'.code', 'dt'=>2),
            array(  'db' => $excel.'.quantity', 'dt'=>3),

        );

        }
        else
        {
            $columns = array(
                array('db' => $color.'.img', 'dt' => 0,
                    'formatter' => function ($d, $row) {
                        if ($d)
                        {
                            return "<img width=100 src='".$this->save_file.$d."' >";
                        }else{
                            return 'لاتوجد صورة';
                        }
                    }
                ),
                array(  'db' =>$model.'.title', 'dt'=>1),
                array(  'db' => $excel.'.code', 'dt'=>2),
                array(  'db' => $excel.'.quantity', 'dt'=>3),

            );
        }

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        if ($model=='product_savers')
        {
            $join = "
            LEFT JOIN {$model} ON  {$model}.code={$excel}.code 
            LEFT JOIN location ON location.code = {$excel}.code
            ";
            $model='savers';
        }else if ($model =='accessories')
        {
            $join = "
            LEFT JOIN {$color} ON  {$color}.code={$excel}.code 
            LEFT JOIN {$model} ON {$model}.id={$color}.id_item 
            LEFT JOIN location ON location.code = {$excel}.code
            ";
        }else{
            $join = "
            LEFT JOIN {$code} ON  {$code}.code={$excel}.code 
            LEFT JOIN {$color} ON {$color}.id= {$code}.id_color
            LEFT JOIN {$model} ON {$model}.id={$color}.id_item 
            LEFT JOIN location ON location.code = {$excel}.code
            ";
        }


            $whereAll = array("location.code IS null","location.model ='{$model}'");

            $result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1);

            echo json_encode($result);




    }



    public function processing2($model=null)
    {

        if ($model=='mobile') {
            $excel = 'excel';
            $code = 'code';
            $color = 'color';
        }else  {
            $excel  = 'excel_'.$model;
            $code = 'code_'.$model;
            $color = 'color_'.$model;
        }
        $table = 'location_confirm';
        $primaryKey = $table.'.id';


            $columns = array(

                array(  'db' =>$table.'.id', 'dt'=>0,

                    'formatter' => function( $d, $row ) {
                        return "<input type='checkbox'    class='childcheckbox'  name='item[]' value='{$d}'>";
                    }

                ),

                array('db' => $table.'.model', 'dt' => 1,
                    'formatter' => function ($d, $row) {
                        if ($this->info_code($d,$row[2],'img'))
                        {
                            return "<img width=100 src='".$this->save_file.$this->info_code($d,$row[1],'img')."' >";
                        }else{
                            return 'لاتوجد صورة';
                        }
                    }
                ),
                array(  'db' =>$table.'.model', 'dt'=>2,

                    'formatter' => function ($d, $row) {
                       return $this->info_code($d,$row[3],'title');
                    }

                    ),
                array(  'db' => $table.'.code', 'dt'=>3),

                array(  'db' => $table.'.location', 'dt'=>4),
                array(  'db' => $table.'.quantity', 'dt'=>5),
                array(  'db' => $table.'.userid', 'dt'=>6,
                    'formatter' => function ($d, $row) {
                        return $this->UserInfo($d);
                    }

                ),


            );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );



            $join = "
            LEFT JOIN $excel ON $excel.code = $table.code
      
            ";

            $whereAll = array(/*"{$excel}.code IS null",*/"model='{$model}'"," {$table}.`location` <> ''");


            $result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null);

            echo json_encode($result);

    }




    function delete_location_confirm($model)
    {
        if ($this->handleLogin()) {

 			$this->AddToTraceByFunction($this->userid,'case_reports','delete_location_confirm/'.$model);
            if (isset($_REQUEST['item'])) {
                $myArray = $_REQUEST['item'];


                if (!empty($myArray)) {

                    $Ids = implode(',', $myArray);

                    $stmt = $this->db->prepare("DELETE  from location_confirm WHERE `id`   IN ({$Ids})   AND `model`= ?   ");
                    $stmt->execute(array($model));
                    if ($stmt->rowCount() > 0) {
                        echo  'true';
                    }

                }else
                {
                    echo 'empty';
                }
            }
        }

    }



    function info_code($model,$code,$col)
    {

        if ($model=='savers')
        {

            $stmt=$this->db->prepare("
        SELECT  product_savers.title,product_savers.img  FROM  product_savers
         WHERE product_savers.code= ? ");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0)
            {
                $result= $stmt->fetch(PDO::FETCH_ASSOC);
                return $result[$col];
            }

        }else if ($model=='accessories'){
          $stmt=$this->db->prepare("
        SELECT  {$model}.title,color_accessories.img  FROM  color_accessories
        INNER JOIN {$model} ON {$model}.id=color_accessories.id_item
         WHERE color_accessories.code= ? ");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0)
            {
                $result= $stmt->fetch(PDO::FETCH_ASSOC);
                return $result[$col];
            }


        }else
        {


            if ($model=='mobile') {
                $code_table = 'code';
                $color = 'color';
            }else  {
                $code_table = 'code_'.$model;
                $color = 'color_'.$model;
            }

         $stmt=$this->db->prepare("
        SELECT  {$model}.title,{$color}.img  FROM  {$code_table} 
        INNER JOIN {$color} ON {$color}.id= {$code_table}.id_color
        INNER JOIN {$model} ON {$model}.id={$color}.id_item
         WHERE {$code_table}.code= ? ");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0)
            {
               $result= $stmt->fetch(PDO::FETCH_ASSOC);
              return $result[$col];
            }

        }




    }



    function list_case3($model)
    {


        $this->checkPermit($model, $this->folder);
        $this->adminHeaderController($this->langControl($model));


        require($this->render($this->folder, 'html', 'index3', 'php'));


        $this->adminFooterController();


    }

    function over_quantity($model)
    {
        if($this->handleLogin())
        {

        	$this->AddToTraceByFunction($this->userid,'case_reports','over_quantity/'.$model);
            $stmt=$this->db->prepare("UPDATE location SET over_quantity=0 WHERE model=?");
            $stmt->execute(array($model));
            echo 'true';
        }

    }

    public function processing3($model=null)
    {

        $table = 'location';
        $primaryKey = 'id';


            $columns = array(

                array(  'db' =>  'model', 'dt'=>0),
                array(  'db' =>  'code', 'dt'=>1),
                array(  'db' => 'location', 'dt'=>2),
                array(  'db' => 'over_quantity', 'dt'=>3),
                array(  'db' => 'id', 'dt'=>4),

            );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $result=SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"model='{$model}' AND over_quantity > 0");

        echo json_encode($result);

    }




    /*
    function list_case3($model)
    {


        $this->checkPermit($model, $this->folder);
        $this->adminHeaderController($this->langControl($model));


        if ($model=='mobile') {
            $excel = 'excel';
            $code = 'code';
            $color = 'color';
        }else  {
            $excel  = 'excel_'.$model;
            $code = 'code_'.$model;
            $color = 'color_'.$model;
        }
        if ($model =='savers')
        {
            $model='product_savers';
        }

        if ($model=='product_savers')
        {
            $stmt=$this->db->prepare("
       SELECT  {$model}.title, {$model}.img,{$excel}.code ,{$excel}.quantity    FROM {$excel}

        LEFT JOIN {$model} ON  {$model}.code={$excel}.code
        INNER JOIN location ON location.code = $excel.code

       WHERE location.model='{$model}' AND {$excel}.code = location.code AND
        $excel.quantity < (SELECT SUM(location.quantity) FROM location WHERE location.model='{$model}' AND $excel.code = location.code )
       GROUP BY {$excel}.code

        ");

        }
        else    if ($model=='accessories')
        {
            $stmt=$this->db->prepare("
       SELECT  {$model}.title, {$color}.img,{$excel}.code ,{$excel}.quantity    FROM {$excel}

        LEFT JOIN {$color} ON  {$color}.code={$excel}.code
        LEFT JOIN {$model} ON {$model}.id={$color}.id_item
        INNER JOIN location ON location.code = $excel.code

       WHERE location.model='{$model}' AND {$excel}.code = location.code AND
        $excel.quantity < (SELECT SUM(location.quantity) FROM location WHERE location.model='{$model}' AND $excel.code = location.code )
       GROUP BY {$excel}.code

        ");


        }else{

            $stmt=$this->db->prepare("
       SELECT  {$model}.title, {$color}.img,{$excel}.code ,{$excel}.quantity    FROM {$excel}

        LEFT JOIN {$code} ON  {$code}.code={$excel}.code
        LEFT JOIN {$color} ON {$color}.id= {$code}.id_color
        LEFT JOIN {$model} ON {$model}.id={$color}.id_item
        INNER JOIN location ON location.code = $excel.code

       WHERE location.model='{$model}' AND {$excel}.code = location.code AND
        $excel.quantity < (SELECT SUM(location.quantity) FROM location WHERE location.model='{$model}' AND $excel.code = location.code )
       GROUP BY {$excel}.code

        ");

        }

        $stmt->execute();

        $data=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $row['image']=$this->save_file.$row['img'];

            $row['location']= $this->table_location($row['code'],$model);

            $data[]=$row;
        }




        $active1='';
        $active2='';
        $active3='';
        $active4='';
        $active5='';
        $active6='';

        require($this->render($this->folder, 'html', 'index3', 'php'));


        $this->adminFooterController();


    }
*/


    function list_case4($model)
    {


        $this->checkPermit($model, $this->folder);
        $this->adminHeaderController($this->langControl($model));


        if ($model=='mobile') {
            $excel = 'excel';
            $code = 'code';
            $color = 'color';
        }else  {
            $excel  = 'excel_'.$model;
            $code = 'code_'.$model;
            $color = 'color_'.$model;
        }
        if ($model =='savers')
        {
            $model='product_savers';
        }

        if ($model=='product_savers')
        {
            $stmt=$this->db->prepare("
       SELECT  {$model}.title, {$model}.img,{$excel}.code ,{$excel}.quantity    FROM {$excel}
           
        LEFT JOIN {$model} ON  {$model}.code={$excel}.code 
        INNER JOIN location ON location.code = $excel.code 
    
       WHERE location.model='{$model}' AND {$excel}.code = location.code AND 
        $excel.quantity > (SELECT SUM(location.quantity) FROM location WHERE location.model='{$model}' AND $excel.code = location.code )   
       GROUP BY {$excel}.code  

        ");

        }
        else    if ($model=='accessories')
        {
            $stmt=$this->db->prepare("
       SELECT  {$model}.title, {$color}.img,{$excel}.code ,{$excel}.quantity    FROM {$excel}
           
        LEFT JOIN {$color} ON  {$color}.code={$excel}.code 
        LEFT JOIN {$model} ON {$model}.id={$color}.id_item 
        INNER JOIN location ON location.code = $excel.code 
    
       WHERE location.model='{$model}' AND {$excel}.code = location.code AND 
        $excel.quantity > (SELECT SUM(location.quantity) FROM location WHERE location.model='{$model}' AND $excel.code = location.code )   
       GROUP BY {$excel}.code  

        ");


        }else{

            $stmt=$this->db->prepare("
       SELECT  {$model}.title, {$color}.img,{$excel}.code ,{$excel}.quantity    FROM {$excel}
           
        LEFT JOIN {$code} ON  {$code}.code={$excel}.code 
        LEFT JOIN {$color} ON {$color}.id= {$code}.id_color
        LEFT JOIN {$model} ON {$model}.id={$color}.id_item 
        INNER JOIN location ON location.code = $excel.code 
    
       WHERE location.model='{$model}' AND {$excel}.code = location.code AND 
        $excel.quantity > (SELECT SUM(location.quantity) FROM location WHERE location.model='{$model}' AND $excel.code = location.code )   
       GROUP BY {$excel}.code  

        ");

        }

        $stmt->execute();

        $data=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $row['image']=$this->save_file.$row['img'];

            $row['location']= $this->table_location($row['code'],$model);

            $data[]=$row;
        }




        $active1='';
        $active2='';
        $active3='';
        $active4='';
        $active5='';
        $active6='';

        require($this->render($this->folder, 'html', 'index4', 'php'));


        $this->adminFooterController();





    }



    function  table_location($code,$model)
    {


        $stmt=$this->db->prepare("SELECT *FROM `location` WHERE code=? AND `model`=? ");
        $stmt->execute(array($code,$model));


        if ($stmt->rowCount() > 0)
        {
            $html="
		<table class='table table-bordered' style='background: #fff;margin: 0;padding: 0'><tbody>";

            $html .= "
		 <tr>
        <td style='padding: 0;    vertical-align: unset;background: #add'> م  </td>
        <td style='padding: 0;    vertical-align: unset;background: #fea'>  ك </td>
      
           </tr>
			";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $html .= "
		 <tr>
        <td style='padding: 0;    vertical-align: unset;background: #ad7'>   {$row['location']}   </td>
        <td style='padding: 0;    vertical-align: unset;background: #ffffff'> {$row['quantity']} </td>
      
           </tr>
			";

            }

            $html.="</tbody> </table>";
            return $html ;
        }



    }


    function list_case5($model)
    {
        $this->checkPermit($model, $this->folder);
        $this->adminHeaderController($this->langControl($model));


         require($this->render($this->folder, 'html', 'index5', 'php'));

        $this->adminFooterController();


    }

    public function processing5($model=null)
    {



        if ($model=='mobile') {
            $excel = 'excel';
            $code = 'code';
            $color = 'color';
        }else  {
            $excel  = 'excel_'.$model;
            $code = 'code_'.$model;
            $color = 'color_'.$model;
        }


        if ($model =='savers')
        {
            $model='product_savers';
            $table = 'product_savers';

        }else if ($model =='accessories')
        {
            $table = $color;
        }else
        {
            $table = $code;
        }


        $primaryKey = $table.'.id';

        if ($model=='product_savers')
        {
            $columns = array(
                array('db' => $model.'.img', 'dt' => 0,
                    'formatter' => function ($d, $row) {
                        if ($d)
                        {
                            return "<img width=100 src='".$this->save_file.$d."' >";
                        }else{
                            return 'لاتوجد صورة';
                        }
                    }
                ),
                array(  'db' =>$model.'.title', 'dt'=>1),
                array(  'db' => $model.'.code', 'dt'=>2),
            );


            $join = "
            LEFT JOIN {$excel} ON  {$excel}.code={$model}.code 
            ";

            $whereAll = array("{$excel}.code IS null");
        }
        else if ($model =='accessories')
        {
            $columns = array(
                array('db' => $color.'.img', 'dt' => 0,
                    'formatter' => function ($d, $row) {
                        if ($d)
                        {
                            return "<img width=100 src='".$this->save_file.$d."' >";
                        }else{
                            return 'لاتوجد صورة';
                        }
                    }
                ),
                array(  'db' =>$model.'.title', 'dt'=>1),
                array(  'db' => $color.'.code', 'dt'=>2),
            );


            $join = "
            LEFT JOIN {$excel} ON  {$excel}.code={$color}.code 
            INNER JOIN {$model} ON {$model}.id={$color}.id_item 
            ";

            $whereAll = array("{$excel}.code IS null");
        }else
        {
            $columns = array(
                array('db' => $color.'.img', 'dt' => 0,
                    'formatter' => function ($d, $row) {
                        if ($d)
                        {
                            return "<img width=100 src='".$this->save_file.$d."' >";
                        }else{
                            return 'لاتوجد صورة';
                        }
                    }
                ),
                array(  'db' =>$model.'.title', 'dt'=>1),
                array(  'db' => $code.'.code', 'dt'=>2),
            );

            $join = "
            LEFT JOIN {$excel} ON  {$excel}.code={$code}.code 
            INNER JOIN {$color} ON {$color}.id= {$code}.id_color
            INNER JOIN {$model} ON {$model}.id={$color}.id_item 
         
            ";
            $whereAll = array("{$excel}.code IS null");
        }


// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null);

        echo json_encode($result);

    }


    function list_case7($model)
    {
        $this->checkPermit($model, $this->folder);
        $this->adminHeaderController($this->langControl($model));


        require($this->render($this->folder, 'html', 'index7', 'php'));

        $this->adminFooterController();


    }


    public function processing7($model=null)
    {

        if ($model=='mobile') {
            $excel = 'excel';
            $code = 'code';
            $color = 'color';
        }else  {
            $excel  = 'excel_'.$model;
            $code = 'code_'.$model;
            $color = 'color_'.$model;
        }
        $table = 'location';
        $primaryKey = $table.'.id';

        if ($model =='savers')
        {
            $model='product_savers';
        }

        if ($model=='product_savers')
        {

            $columns = array(
                array('db' => $model.'.img', 'dt' => 0,
                    'formatter' => function ($d, $row) {
                        if ($d)
                        {
                            return "<img width=100 src='".$this->save_file.$d."' >";
                        }else{
                            return 'لاتوجد صورة';
                        }
                    }
                ),
                array(  'db' =>$model.'.title', 'dt'=>1),
                array(  'db' => $table.'.code', 'dt'=>2),
                array(  'db' => $table.'.location', 'dt'=>3),
                array(  'db' => $table.'.quantity', 'dt'=>4),

                array('db' => 'location.id', 'dt' => 5,
                    'formatter' => function ($d, $row) {
                        return "
                    <div class='row justify-content-center'>
                     <div class='col-auto'> <button class='btn btn-danger' onclick='remove_location({$d})' > <i class='fa fa-times'></i> </button> </div>
                     <div class='col-auto'> <button class='btn btn-success' onclick='success_location({$d})' > <i class='fa fa-check'></i> </button> </div>
                     </div>
                    ";
                    }
                ),
                array(  'db' =>'location.id', 'dt'=>6),
                array(  'db' =>'location.model', 'dt'=>7),


            );

        }
        else
        {
            $columns = array(
                array('db' => $color.'.img', 'dt' => 0,
                    'formatter' => function ($d, $row) {
                        if ($d)
                        {
                            return "<img width=100 src='".$this->save_file.$d."' >";
                        }else{
                            return 'لاتوجد صورة';
                        }
                    }
                ),
                array(  'db' =>$model.'.title', 'dt'=>1),
                array(  'db' => $table.'.code', 'dt'=>2),
                array(  'db' => $table.'.location', 'dt'=>3),
                array(  'db' => $table.'.quantity', 'dt'=>4),
                array('db' => 'location.id', 'dt' => 5,
                    'formatter' => function ($d, $row) {
                    return "
                    <div class='row justify-content-center'>
                     <div class='col-auto'> <button class='btn btn-danger' onclick='remove_location({$d})' > <i class='fa fa-times'></i> </button> </div>
                     <div class='col-auto'> <button class='btn btn-success' onclick='success_location({$d})' > <i class='fa fa-check'></i> </button> </div>
                     </div>
                    ";
                    }
                ),
                array(  'db' =>'location.id', 'dt'=>6),
                array(  'db' =>'location.model', 'dt'=>7),


            );
        }

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        if ($model=='product_savers')
        {
            $join = "
            LEFT JOIN {$model} ON  {$model}.code=location.code 
            ";
            $model='savers';
        }else if ($model =='accessories')
        {
            $join = "
            LEFT JOIN $color ON $color.code = location.code
            LEFT JOIN {$model} ON {$model}.id={$color}.id_item 
            ";
        }else
        {
            $join = "
            LEFT JOIN {$code} ON  {$code}.code=location.code 
            LEFT JOIN {$color} ON {$color}.id= {$code}.id_color
            LEFT JOIN {$model} ON {$model}.id={$color}.id_item 
            ";

        }

        $whereAll = array("location.model ='{$model}'","location.new_location =1");

        $result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null);

        echo json_encode($result);

    }



    function remove_location()
    {
    
    	

        if ($this->handleLogin())
        {

            $model=$_GET['model'];
            $id=$_GET['id'];
			$this->AddToTraceByFunction($this->userid,'case_reports','remove_location/'.$model.'/'.$id);
            $stmtc = $this->db->prepare("SELECT *FROM `location`  WHERE `id`=?  AND `model` =? LIMIT 1");
            $stmtc->execute(array($id, $model));
            if ($stmtc->rowCount() > 0) {
                $result=$stmtc->fetch(PDO::FETCH_ASSOC);

                $stmtconfirm = $this->db->prepare("SELECT *FROM location_confirm WHERE code=? AND model=?  ");
                $stmtconfirm->execute(array($result['code'], $model));
                if ($stmtconfirm->rowCount() > 0) {

                        $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity` +  ?  WHERE code=? AND model=? ");
                        $stmtcon->execute(array((int)trim($result['quantity']),$result['code'], $model));
                }else
                {
                    $stmt = $this->db->prepare("INSERT INTO    `location_confirm` (code, quantity, model, date) VALUES (?,?,?,?)  ");
                    $stmt->execute(array( $result['code'],(int)trim($result['quantity']), $model,time()));

                }

                $stmtd = $this->db->prepare("DELETE FROM `location`  WHERE `id`=? AND code =? AND location =?  AND `model` =? LIMIT 1");
                $stmtd->execute(array($id,$result['code'],$result['location'], $model));
                if ($stmtd->rowCount() > 0)
                {
                    echo 1;
                }
            }
        }

    }


    function remove_location_all()
    {

        if ($this->handleLogin())
        {
			
            $model=$_GET['model'];
			$this->AddToTraceByFunction($this->userid,'case_reports','remove_location_all/'.$model);

            $stmtc = $this->db->prepare("SELECT *FROM `location`  WHERE `new_location`=1  AND `model` =?  ");
            $stmtc->execute(array(  $model));
            if ($stmtc->rowCount() > 0) {
                while ($row = $stmtc->fetch(PDO::FETCH_ASSOC)) {

                    $stmtconfirm = $this->db->prepare("SELECT *FROM location_confirm WHERE code=? AND model=?  ");
                    $stmtconfirm->execute(array($row['code'], $model));
                    if ($stmtconfirm->rowCount() > 0) {

                        $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity` +  ?  WHERE code=? AND model=? ");
                        $stmtcon->execute(array((int)trim($row['quantity']), $row['code'], $model));
                    } else {
                        $stmt = $this->db->prepare("INSERT INTO    `location_confirm` (code, quantity, model, date) VALUES (?,?,?,?)  ");
                        $stmt->execute(array($row['code'], (int)trim($row['quantity']), $model, time()));

                    }

                    $stmtd = $this->db->prepare("DELETE FROM `location`  WHERE `id`=? AND code =? AND location =?  AND `model` =? LIMIT 1");
                    $stmtd->execute(array($row['id'], $row['code'], $row['location'], $model));

                }
                echo 1;
            }
        }

    }



    function success_location()
    {

        if ($this->handleLogin()) {
			
        	
            $model = $_GET['model'];
            $id = $_GET['id'];
        	$this->AddToTraceByFunction($this->userid,'case_reports','success_location/'.$model.'/'.$id);


            $stmt = $this->db->prepare("UPDATE   `location` SET  new_location=0 ,userid=? WHERE id=?  AND model=?");
            $stmt->execute(array($this->userid, $id, $model));
            if ($stmt->rowCount() > 0) {
                echo 1;
            }

        }
    }

    function success_location_all()
    {

        if ($this->handleLogin()) {
			
            $model = $_GET['model'];
			$this->AddToTraceByFunction($this->userid,'case_reports','success_location_all/'.$model);

            $stmt = $this->db->prepare("UPDATE   `location` SET  new_location=0 ,userid=? WHERE  model=?");
            $stmt->execute(array($this->userid, $model));
            if ($stmt->rowCount() > 0) {
                echo 1;
            }

        }
    }

}