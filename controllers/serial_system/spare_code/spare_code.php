<?php

trait spare_code
{



    function __construct()
    {
        parent::__construct();
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject

    }





    function list_spare_code()
    {

        $this->checkPermit('spare_code',$this->folder);

        $this->adminHeaderController($this->langControl($this->folder));
        $model='mobile';

        if (isset($_GET['model']))
        {
            $model=trim($_GET['model']);
        }


        require ($this->render($this->folder,'spare_code/html','list','php'));
        $this->adminFooterController();

    }




    public function processing_spare_code($model='mobile')
    {

             $m=$model;
            if ($model=='savers') {

                $model = 'product_savers';
                $m='savers';
            }

            $table ='spare_code';


            $primaryKey = $table.'.id';
            $columns = array(
                array( 'db' => $model.'.title', 'dt' => 0 ),
                array( 'db' => $table.'.color', 'dt' => 1 ),
                array( 'db' => $table.'.size', 'dt' => 2 ),
                array( 'db' => $table.'.code', 'dt' => 3 ),
                array( 'db' => $table.'.spare_code', 'dt' => 4 ),
                array( 'db' => 'user.username', 'dt' => 5 ,
                    'formatter' => function ($id, $row) {
                        return  $id;
                    }
                ),

                array( 'db' => $table.'.date', 'dt' => 6 ,
                    'formatter' => function ($id, $row) {
                        return  date('Y-m-d h:i:s A ',$id);
                    }
                ),

                array(  'db' =>   $table.'.id', 'dt'=> 7)


            );

            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASS,
                'db'   => DB_NAME,
                'host' => DB_HOST,
                'charset' => 'utf8'
            );


            $join = " INNER JOIN  {$model} ON {$model}.id={$table}.id_item INNER JOIN user ON user.id ={$table}.userid ";
            $whereAll = array("{$table}.model='{$m}'");


            echo json_encode(

                SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));



    }



    function add_spare_code()
    {


        $model = $_GET['model'];

        $tab=null;
        if (isset($_GET['tab']))
        {
            $tab = $_GET['tab'];
        }

        $this->checkPermit('spare_code',$this->folder);
        $this->adminHeaderController($this->langControl($model));



        require ($this->render($this->folder,'spare_code/html','add','php'));
        $this->adminFooterController();

    }



    function code($model)
    {
         $this->checkPermit('spare_code',$this->folder);
         $code=trim($_POST['code']);
         $spare_code=trim($_POST['spare_code']);

         if ($model=='accessories')
         {


             $stmt=$this->db->prepare("SELECT *  FROM  color_accessories    WHERE  code=? LIMIT 1");
             $stmt->execute(array($code));
             if ($stmt->rowCount() > 0)
             {
                 $result=$stmt->fetch(PDO::FETCH_ASSOC);
                 $stmtCh=$this->db->prepare("SELECT *FROM spare_code WHERE code=? AND spare_code=? AND  model=? ");
                 $stmtCh->execute(array($code,$spare_code,$model));
                 if ($stmtCh->rowCount() <=0)
                 {
                     $stmtIn = $this->db->prepare("INSERT INTO spare_code ( code, color, size, spare_code, model, userId, date,id_item) VALUES (?,?,?,?,?,?,?,?) ");
                     $stmtIn ->execute(array($code,$result['color'],'',$spare_code,$model,$this->userid,time(),$result['id_item']));
                 }

                 echo 'true';

             }else
             {
                 echo 'xcode';
             }



         }else if ($model == 'savers')
         {

             $stmt=$this->db->prepare("SELECT *  FROM  product_savers    WHERE  code=? LIMIT 1");
             $stmt->execute(array($code));
             if ($stmt->rowCount() > 0)
             {
                 $result=$stmt->fetch(PDO::FETCH_ASSOC);
                 $stmtCh=$this->db->prepare("SELECT *FROM spare_code WHERE code=? AND spare_code=? AND  model=? ");
                 $stmtCh->execute(array($code,$spare_code,$model));
                 if ($stmtCh->rowCount() <=0)
                 {
                     $stmtIn = $this->db->prepare("INSERT INTO spare_code ( code, color, size, spare_code, model, userId, date,id_item) VALUES (?,?,?,?,?,?,?,?) ");
                     $stmtIn ->execute(array($code,$result['color'],'',$spare_code,$model,$this->userid,time(),$result['id']));
                 }

                 echo 'true';

             }else
             {
                 echo 'xcode';
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
                $stmtCh=$this->db->prepare("SELECT *FROM spare_code WHERE code=? AND spare_code=? AND  model=? ");
                $stmtCh->execute(array($code,$spare_code,$model));
                if ($stmtCh->rowCount() <=0)
                {
                    $stmtIn = $this->db->prepare("INSERT INTO spare_code ( code, color, size, spare_code, model, userId, date,id_item) VALUES (?,?,?,?,?,?,?,?) ");
                    $stmtIn ->execute(array($code,$result['color'],$result['size'],$spare_code,$model,$this->userid,time(),$result['id_item']));
                }

                echo 'true';

            }else
            {
                echo 'xcode';
            }



         }


    }



    function addSpareCode($spare_code,$model,$code,$echo=true)
    {

         if ($model=='accessories')
         {


             $stmt=$this->db->prepare("SELECT *  FROM  color_accessories    WHERE  code=? LIMIT 1");
             $stmt->execute(array($code));
             if ($stmt->rowCount() > 0)
             {
                 $result=$stmt->fetch(PDO::FETCH_ASSOC);
                 $stmtCh=$this->db->prepare("SELECT *FROM spare_code WHERE code=? AND spare_code=? AND  model=? ");
                 $stmtCh->execute(array($code,$spare_code,$model));
                 if ($stmtCh->rowCount() <=0)
                 {
                     $stmtIn = $this->db->prepare("INSERT INTO spare_code ( code, color, size, spare_code, model, userId, date,id_item) VALUES (?,?,?,?,?,?,?,?) ");
                     $stmtIn ->execute(array($code,$result['color'],'',$spare_code,$model,$this->userid,time(),$result['id_item']));
                 }
                 if ($echo)
                 {
                     echo 'true';
                 }


             }else
             {
                 if ($echo)
                 {
                     echo 'xcode';
                 }
             }



         }else if ($model == 'savers')
         {

             $stmt=$this->db->prepare("SELECT *  FROM  product_savers    WHERE  code=? LIMIT 1");
             $stmt->execute(array($code));
             if ($stmt->rowCount() > 0)
             {
                 $result=$stmt->fetch(PDO::FETCH_ASSOC);
                 $stmtCh=$this->db->prepare("SELECT *FROM spare_code WHERE code=? AND spare_code=? AND  model=? ");
                 $stmtCh->execute(array($code,$spare_code,$model));
                 if ($stmtCh->rowCount() <=0)
                 {
                     $stmtIn = $this->db->prepare("INSERT INTO spare_code ( code, color, size, spare_code, model, userId, date,id_item) VALUES (?,?,?,?,?,?,?,?) ");
                     $stmtIn ->execute(array($code,$result['color'],'',$spare_code,$model,$this->userid,time(),$result['id']));
                 }

                 if ($echo)
                 {
                     echo 'true';
                 }


             }else
             {
                 if ($echo)
                 {
                     echo 'xcode';
                 }
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
                $stmtCh=$this->db->prepare("SELECT *FROM spare_code WHERE code=? AND spare_code=? AND  model=? ");
                $stmtCh->execute(array($code,$spare_code,$model));
                if ($stmtCh->rowCount() <=0)
                {
                    $stmtIn = $this->db->prepare("INSERT INTO spare_code ( code, color, size, spare_code, model, userId, date,id_item) VALUES (?,?,?,?,?,?,?,?) ");
                    $stmtIn ->execute(array($code,$result['color'],$result['size'],$spare_code,$model,$this->userid,time(),$result['id_item']));
                }

                if ($echo)
                {
                    echo 'true';
                }

            }else
            {
                if ($echo)
                {
                    echo 'xcode';
                }


            }



         }


    }


    function bysearch()
    {
         $this->checkPermit('spare_code',$this->folder);
          $model=trim($_POST['model']);
          $code=trim($_POST['code']);
          $spare_code=trim($_POST['spare_code']);

         if ($model=='accessories')
         {


             $stmt=$this->db->prepare("SELECT *  FROM  color_accessories    WHERE  code=? LIMIT 1");
             $stmt->execute(array($code));
             if ($stmt->rowCount() > 0)
             {
                 $result=$stmt->fetch(PDO::FETCH_ASSOC);
                 $stmtCh=$this->db->prepare("SELECT *FROM spare_code WHERE code=? AND spare_code=? AND  model=? ");
                 $stmtCh->execute(array($code,$spare_code,$model));
                 if ($stmtCh->rowCount() <=0)
                 {
                     $stmtIn = $this->db->prepare("INSERT INTO spare_code ( code, color, size, spare_code, model, userId, date,id_item) VALUES (?,?,?,?,?,?,?,?) ");
                     $stmtIn ->execute(array($code,$result['color'],'',$spare_code,$model,$this->userid,time(),$result['id_item']));
                 }

                 echo 'true';

             }else
             {
                 echo 'xcode';
             }



         }else if ($model == 'savers')
         {

             $stmt=$this->db->prepare("SELECT *  FROM  product_savers    WHERE  code=? LIMIT 1");
             $stmt->execute(array($code));
             if ($stmt->rowCount() > 0)
             {
                 $result=$stmt->fetch(PDO::FETCH_ASSOC);
                 $stmtCh=$this->db->prepare("SELECT *FROM spare_code WHERE code=? AND spare_code=? AND  model=? ");
                 $stmtCh->execute(array($code,$spare_code,$model));
                 if ($stmtCh->rowCount() <=0)
                 {
                     $stmtIn = $this->db->prepare("INSERT INTO spare_code ( code, color, size, spare_code, model, userId, date,id_item) VALUES (?,?,?,?,?,?,?,?) ");
                     $stmtIn ->execute(array($code,$result['color'],'',$spare_code,$model,$this->userid,time(),$result['id']));
                 }

                 echo 'true';

             }else
             {
                 echo 'xcode';
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

             $stmt=$this->db->prepare("SELECT {$code_table}.code,{$code_table}.size,{$color}.color,{$color}.id_item FROM {$code_table} INNER JOIN {$color} ON {$color}.id=$code_table.id_color WHERE {$code_table}.code=? LIMIT 1");
             $stmt->execute(array($code));
            if ($stmt->rowCount() > 0)
            {
                $result=$stmt->fetch(PDO::FETCH_ASSOC);
                $stmtCh=$this->db->prepare("SELECT *FROM spare_code WHERE code=? AND spare_code=? AND  model=? ");
                $stmtCh->execute(array($code,$spare_code,$model));
                if ($stmtCh->rowCount() <=0)
                {
                    $stmtIn = $this->db->prepare("INSERT INTO spare_code ( code, color, size, spare_code, model, userId, date,id_item) VALUES (?,?,?,?,?,?,?,?) ");
                    $stmtIn ->execute(array($code,$result['color'],$result['size'],$spare_code,$model,$this->userid,time(),$result['id_item']));
                }

                echo 'true';

            }else
            {
                echo 'xcode';
            }



         }


    }


    function smartsearch()
    {

        $mod = array('accessories', 'savers');

        $val = strip_tags(trim($_GET['val']));
        $model = strip_tags(trim($_GET['cat']));
        $mod = array('accessories', 'savers');
        if ($model == 'mobile') {
            $code = 'code';
            $color = 'color';
        } else if (!in_array($model, $mod)) {
            $code = 'code_' . $model;
            $color = 'color_' . $model;

        }
        $contentAll = array();
        $q = '%' . trim($val) . '%';
        $r = '[[:<:]]' . trim($val) . '[[:>:]]';

        if (!in_array($model, $mod)) {





            $stmt = $this->db->prepare("SELECT `id`,`title`,`bast_it`,`price_dollars` FROM `{$model}` WHERE ( title LIKE ? OR  tags LIKE ? )     LIMIT 10");
            $stmt->execute(array($q, $q));

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $contentAll[] = $row;

                }
            }

            $stmtcode = $this->db->prepare("SELECT {$model}.* FROM {$code} inner JOIN {$color} ON {$code}.id_color = {$color}.id inner JOIN {$model} ON {$color}.id_item =  {$model}.id WHERE ({$code}.code=? OR {$code}.serial  REGEXP ?) ");
            $stmtcode->execute(array(str_replace(' ', '', $val), $r));
            if ($stmtcode->rowCount() > 0) {
                while ($row_code = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
                    $contentAll[] = $row_code;


                }
            }
        } else if ($model == 'accessories') {

            $stmt = $this->db->prepare("SELECT *FROM `accessories` WHERE ( title LIKE ? OR  tags LIKE ? )  LIMIT 10");
            $stmt->execute(array($q, $q));

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $contentAll[] = $row;

                }
            }

            $stmtcode = $this->db->prepare("SELECT accessories.* FROM color_accessories inner JOIN accessories ON color_accessories.id_item = accessories.id WHERE  (color_accessories.code=?  OR color_accessories.serial  REGEXP ?)  ");
            $stmtcode->execute(array(str_replace(' ', '', $val), $r));
            if ($stmtcode->rowCount() > 0) {
                while ($row_code = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
                    $contentAll[] = $row_code;
                }
            }


        } else if ($model == 'savers') {

            $stmt = $this->db->prepare("SELECT * from `product_savers` WHERE (title LIKE ?  OR code = ? OR serial REGEXP ? ) LIMIT 10");
            $stmt->execute(array($q, str_replace(' ', '', $val), $r));

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $contentAll[] = $row;

                }
            }

        }
        if (!empty($contentAll)) {
            require($this->render($this->folder, 'spare_code/html', 'data', 'php'));

        }


    }


        function get_color()
        {

             $model=$_GET['cat'];
             $id_item=$_GET['id_item'];


            if ($model=='accessories')
            {


                $stmt=$this->db->prepare("SELECT *  FROM  color_accessories    WHERE  id_item=? ");
                $stmt->execute(array($id_item));

                $html='<option selected disabled value="">اختر اللون</option>';
                if ($stmt->rowCount() > 0)
                {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        $html.="<option   value='{$row['id']}'>{$row['color']}</option>";
                    }

                }
                 echo $html;

            }else if ($model == 'savers')
            {

                $stmt=$this->db->prepare("SELECT *  FROM  product_savers    WHERE  id=?  ");
                $stmt->execute(array($id_item));
                $html='<option selected disabled value="">اختر اللون</option>';
                if ($stmt->rowCount() > 0)
                {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        $html.="<option   value='{$row['id']}'>{$row['color']}</option>";
                    }

                }
                echo $html;


            }
            else
            {
                if ($model =='mobile')
                {
                    $color='color';
                }else
                {
                    $color='color_'.$model;
                }
                $stmt=$this->db->prepare("SELECT  {$color}.* FROM {$color}   WHERE id_item=? ");
                $stmt->execute(array($id_item));
                $html='<option selected disabled value="">اختر اللون</option>';
                if ($stmt->rowCount() > 0)
                {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        $html.="<option   value='{$row['id']}'>{$row['color']}</option>";
                    }
                }
                echo $html;
            }
        }


        function get_code_details()
        {

              $model=$_GET['cat'];
              $id_color=$_GET['id_color'];


            if ($model=='accessories')
            {


                $stmt=$this->db->prepare("SELECT *  FROM  color_accessories    WHERE  id=? ");
                $stmt->execute(array($id_color));

                $html=null;

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        $html.="<option   value='{$row['code']}'>{$row['code']}</option>";
                    }

                 echo $html;

            }else if ($model == 'savers')
            {

                $stmt=$this->db->prepare("SELECT *  FROM  product_savers    WHERE  id=?  ");
                $stmt->execute(array($id_color));
                $html=null;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        $html.="<option   value='{$row['code']}'>{$row['code']}</option>";
                    }

                echo $html;


            }
            else
            {
                if ($model =='mobile')
                {
                    $code='code';
                }else
                {
                    $code='code_'.$model;
                }
                $stmt=$this->db->prepare("SELECT  {$code}.* FROM {$code}   WHERE id_color=? ");
                $stmt->execute(array($id_color));
                $html='<option selected disabled value="">اختر  الذاكرة</option>';
                if ($stmt->rowCount() > 0)
                {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        $html.="<option   value='{$row['code']}'>{$row['size']}</option>";
                    }
                }
                echo $html;
            }
        }



    function  excel($model)
    {


        $this->checkPermit('excel',$this->folder);
        $this->adminHeaderController($this->langControl('excel'));


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


                        if (count($rowData[0])  >= 2)
                        {



                            $code=trim($rowData[0][0]);
                            $spare_code=trim($rowData[0][1]);



                            if ($model=='accessories')
                            {


                                $stmt=$this->db->prepare("SELECT *  FROM  color_accessories    WHERE  code=? LIMIT 1");
                                $stmt->execute(array($code));
                                if ($stmt->rowCount() > 0)
                                {
                                    $result=$stmt->fetch(PDO::FETCH_ASSOC);
                                    $stmtCh=$this->db->prepare("SELECT *FROM spare_code WHERE code=? AND spare_code=? AND  model=? ");
                                    $stmtCh->execute(array($code,$spare_code,$model));
                                    if ($stmtCh->rowCount() <=0)
                                    {
                                        $stmtIn = $this->db->prepare("INSERT INTO spare_code ( code, color, size, spare_code, model, userId, date,id_item) VALUES (?,?,?,?,?,?,?,?) ");
                                        $stmtIn ->execute(array($code,$result['color'],'',$spare_code,$model,$this->userid,time(),$result['id_item']));
                                    }



                                }


                            }else if ($model == 'savers')
                            {

                                $stmt=$this->db->prepare("SELECT *  FROM  product_savers    WHERE  code=? LIMIT 1");
                                $stmt->execute(array($code));
                                if ($stmt->rowCount() > 0)
                                {
                                    $result=$stmt->fetch(PDO::FETCH_ASSOC);
                                    $stmtCh=$this->db->prepare("SELECT *FROM spare_code WHERE code=? AND spare_code=? AND  model=? ");
                                    $stmtCh->execute(array($code,$spare_code,$model));
                                    if ($stmtCh->rowCount() <=0)
                                    {
                                        $stmtIn = $this->db->prepare("INSERT INTO spare_code ( code, color, size, spare_code, model, userId, date,id_item) VALUES (?,?,?,?,?,?,?,?) ");
                                        $stmtIn ->execute(array($code,$result['color'],'',$spare_code,$model,$this->userid,time(),$result['id']));
                                    }

                                    echo 'true';

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
                                    $stmtCh=$this->db->prepare("SELECT *FROM spare_code WHERE code=? AND spare_code=? AND  model=? ");
                                    $stmtCh->execute(array($code,$spare_code,$model));
                                    if ($stmtCh->rowCount() <=0)
                                    {
                                        $stmtIn = $this->db->prepare("INSERT INTO spare_code ( code, color, size, spare_code, model, userId, date,id_item) VALUES (?,?,?,?,?,?,?,?) ");
                                        $stmtIn ->execute(array($code,$result['color'],$result['size'],$spare_code,$model,$this->userid,time(),$result['id_item']));
                                    }

                                }



                            }



                        }else{
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
                    $this->lightRedirect(url.'/'.$this->folder."/list_spare_code?model=".$model);

                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'spare_code/html','excel','php'));
        $this->adminFooterController();
    }



}