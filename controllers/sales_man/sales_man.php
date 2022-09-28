<?php

class sales_man extends Controller
{

    public $ids = array();


    function __construct()
    {
        parent::__construct();
        $this->table = 'purchases';
        $this->setting = new Setting();
    }



    public function index()
    {
        $this->checkPermit('view_sales_man','sales_man');
        $this->adminHeaderController($this->langControl('view_sales_man'));


       require ($this->render($this->folder,'html','index','php'));
        $this->adminFooterController();

    }



    public function add($id=null,$model=null)
    {
        $sendProd=false;

        $this->checkPermit('add_shortfalls','sales_man');
        $this->adminHeaderController($this->langControl('add_shortfalls'),$id);

        $category='category_'.$model;




        $region=array();
        $stmt=$this->db->prepare("SELECT *FROM `region` WHERE `active`=1 ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $region[]=$row;
        }



        $class=new $model;

        $stmt=$this->db->prepare("SELECT *FROM {$model} WHERE  `id` = ? ");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);


         $breadcumbsx = $this->BreadcumbsPublic($category,$result['id_cat']);

        $cat_link= $this->langControl($model) ;
        foreach ($breadcumbsx as  $key => $cat)
        {
            $cat_link.= ' / '  . $key;
        }

      $id_category= $this->BreadcumbsPublic_id_category($category,$result['id_cat']);;

        $stmtCat=$this->db->prepare("SELECT *FROM {$category} WHERE  `id` = ? ");
        $stmtCat->execute(array($result['id_cat']));
        $resultCat=$stmtCat->fetch(PDO::FETCH_ASSOC);


        $g_c=$class->getImageAndColor($result['id'],100);
        $g_c_content=array();

        while ($row = $g_c->fetch(PDO::FETCH_ASSOC)) {

                if ($model=='accessories')
                {
                    $stmt_price = $class->getPrice($row['code'], 1);
                }else{
                    $stmt_price = $class->getPrice($row['id'], 1);
                }

                $row['code'] = $stmt_price['code'] ;
                $row['quantity'] = $stmt_price['quantity'];
                $row['image'] = $row['img'];
                $g_c_content[$row['id']] = $row;
         }

        if (isset($_POST['submit']))
        {
            try
            {
                $form =new  Form();


                $form  ->post('selected')
                    ->val('is_array')
                    ->val('strip_tags');

                $form  ->post('region')
                    ->val('strip_tags');


                $form  ->post('price')
                       ->val('is_array')
                       ->val('strip_tags');

                $form  ->post('quantity')
                       ->val('is_array')
                       ->val('strip_tags');

                $form  ->post('note')
                       ->val('is_array')
                       ->val('strip_tags');


                $form ->submit();
                $data =$form -> fetch();
                $date=strtotime(date('Y-m-d',time()));
                $full_date=time();

                $selected = json_decode($data['selected'], true);
                $quantity = json_decode($data['quantity'], true);
                $note = json_decode($data['note'], true);
                $price = json_decode($data['price'], true);

                $fullData=array();

                foreach ($selected as $sld)
                {

                    $fullData[$sld]['model']=$model;
                    $fullData[$sld]['category']=$cat_link;
                    $fullData[$sld]['id_category']=implode(',',$id_category);
                    $fullData[$sld]['item']=$result['title'];
                    $fullData[$sld]['image']=$g_c_content[$sld]['image'];
                    $fullData[$sld]['color']=$g_c_content[$sld]['color'];
                    $fullData[$sld]['code']=$g_c_content[$sld]['code'];
                    $fullData[$sld]['price_dollars']=$g_c_content[$sld]['price_dollars'];
                    $fullData[$sld]['old_quantity']=$g_c_content[$sld]['quantity'];
                    $fullData[$sld]['quantity']=$quantity[$sld][0];
                    $fullData[$sld]['price']=$price[$sld][0];
                    $fullData[$sld]['note']=$note[$sld][0];
                    $fullData[$sld]['id_user']=$this->userid;
                    $fullData[$sld]['id_cat']= $resultCat['id'];
                    $fullData[$sld]['id_item']=$result['id'];
                    $fullData[$sld]['date']=$date;
                    $fullData[$sld]['full_date']=$full_date;
                    $fullData[$sld]['region']=$data['region'];


                    $fullData[$sld]['purchases_man']=1;
                    $fullData[$sld]['sales_man']=1;
                }


                foreach ($selected as $sld)
                {


                    $this->db->insert($this->table,$fullData[$sld]);

                }

                $sendProd=true;


                $this->lightRedirect(url.'/'.$model."/details/{$id}",3);


            }catch (Exception $e)
            {
                $data =$form -> fetch();

            }

        }




        require ($this->render($this->folder,'html','add','php'));
        $this->adminFooterController();



    }



    public function add_by_category($id=null,$model=null)
    {
        $sendProd=false;

        $this->checkPermit('add_shortfalls','sales_man');
        $this->adminHeaderController($this->langControl('add_shortfalls'),$id);

        $category='category_'.$model;




        $region=array();
        $stmt=$this->db->prepare("SELECT *FROM `region` WHERE `active`=1 ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $region[]=$row;
        }




        $class=new $model;


         $breadcumbsx = $this->BreadcumbsPublic($category,$id);

        $cat_link= $this->langControl($model) ;
        foreach ($breadcumbsx as  $key => $cat)
        {
            $cat_link.= ' / '  . $key;
        }

        $id_category= $this->BreadcumbsPublic_id_category($category,$id);

        if (isset($_POST['submit']))
        {
            try
            {
                $form =new  Form();



                $form  ->post('region')
                    ->val('is_empty','منطقة التسوق مطلوب')
                    ->val('strip_tags');


                $form  ->post('item')
                    ->val('is_empty','اسم المنتج   مطلوب')
                    ->val('strip_tags');




                $form->post('color')

                    ->val('strip_tags');


                $form->post('code')

                    ->val('strip_tags');


                $form->post('price')

                    ->val('strip_tags');


                $form->post('quantity')

                    ->val('strip_tags');


                $form->post('note')

                    ->val('strip_tags');



                $form->submit();
                $data = $form->fetch();
                $data['date']=strtotime(date('Y-m-d',time()));
                $data['full_date']=time();
                $data['model']=$model;


                if (empty($this->error_form)) {


                    $data['category'] = $cat_link;
                     $data['id_category'] =   implode(',',$id_category);;



                    $data['image'] = '';
                    if (empty($this->check_file($_FILES['image'], 'صور مطلوبة', array('jpg', 'jpeg', 'png')))) {
                        $data['image'] = $this->save_file($_FILES['image']);
                    }

                    $data['purchases_man'] = 1;
                    $data['sales_man'] = 1;
                    $data['id_user'] = $this->userid;


                    $stmt = $this->db->insert($this->table, $data);

                    $sendProd = true;

                    $this->lightRedirect(url.'/'.$model."/list_view/{$id}",3);
                }


            }catch (Exception $e)
            {
                $data =$form -> fetch();

            }

        }


        require ($this->render($this->folder,'html','add_by_category','php'));
        $this->adminFooterController();

    }



public function processing()
{


    $table = $this->table;
    $primaryKey = 'id';


    $columns = array(


        array( 'db' => 'id', 'dt' => 0 ,
            'formatter' => function( $d, $row ) {
                return "<input type='checkbox' checked  class='childcheckbox'  name='item[]' value='{$d}'>";
            }
          ),
        array( 'db' => 'category', 'dt' => 1 ),
        array( 'db' => 'item', 'dt' => 2 ),
        array( 'db' => 'code', 'dt' => 3 ),
        array( 'db' => 'color', 'dt' => 4 ),
        array( 'db' => 'price', 'dt' => 5 ),
        array( 'db' => 'quantity', 'dt' => 6 ),
        array( 'db' => 'note', 'dt' => 7 ),

         array( 'db' => 'date', 'dt' =>  8,
            'formatter' => function( $d, $row ) {
                return date( 'Y-m-d ', $d);
            }

        ),
        array( 'db' => 'image', 'dt' => 9,
              'formatter' => function( $d, $row ) {
                  if (!empty($d))
                  {
                      return "<img style='width: 30px' src='{$this->save_file}{$d}'>";

                  }else
                  {
                      return "<img style='width: 30px' src=".$this->static_file_control."/image/admin/default.png >";

                  }
                }
        ),

        array(
            'db'        => 'id',
            'dt'        =>10,
            'formatter' => function($id, $row ) {
                return "
                <div style='text-align: center'>
                    <button type='button'  class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[2]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
            }
        ),
        array( 'db' => 'id_user', 'dt' => 11,
            'formatter' => function( $d, $row ) {
                return  $this->delivery_user_name($d);
            }
        ),

        array(  'db' => 'id', 'dt'=>12)


    );

// SQL server connection information
    $sql_details = array(
        'user' => DB_USER,
        'pass' => DB_PASS,
        'db'   => DB_NAME,
        'host' => DB_HOST,
        'charset' => 'utf8'
    );
    echo json_encode(
    // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
        SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`sales_man`=0 AND `id_user`={$this->userid}")
    );

}


    function delete_item($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->table, "`id`={$id}");
        }
    }

    function convert_to_employ_purchases()
    {
        if ($this->handleLogin()) {

            if (isset($_REQUEST['item'])) {
                $myArray = $_REQUEST['item'];

                $ids = implode(',', $myArray);
                $stmt = $this->db->prepare("UPDATE {$this->table}  SET  `sales_man`=1,`purchases_man`=1 WHERE `id` IN ({$ids}) ");
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    echo json_encode(array('done' => $myArray, JSON_FORCE_OBJECT));
                }
            } else {
                echo json_encode(array('empty' => array('empty' => 'قيمة فارغ'), JSON_FORCE_OBJECT));

            }

        }
    }








    function add_manual()
    {

        $this->checkPermit('add_shortfalls','sales_man');
        $this->adminHeaderController($this->langControl('add_shortfalls'));



        $region=array();
        $stmt=$this->db->prepare("SELECT *FROM `region` WHERE `active`=1 ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $region[]=$row;
        }

        $categ=array();
        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
        $stmt_cat->execute(array($this->userid));

        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
        {
            $categ[]=$row['catg'];
        }

        $sendProd=false;


        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();

                $form->post('model')
                    ->val('is_empty','القسم الرئيسي مطلوب')
                    ->val('strip_tags');

                $form->post('region')
                    ->val('strip_tags');


                $form->post('category')
                    ->val('is_array')
                    ->val('strip_tags');


                $form->post('item')
                    ->val('strip_tags');


                $form->post('color')
                    ->val('strip_tags')
                    ->val('strip_tags');


                $form->post('code')
                    ->val('strip_tags')
                    ->val('strip_tags');


                $form->post('price')
                    ->val('strip_tags')
                    ->val('strip_tags');


                $form->post('quantity')
                    ->val('strip_tags')
                    ->val('strip_tags');


                $form->post('note')
                    ->val('strip_tags')
                    ->val('strip_tags');



                $form->submit();
                $data = $form->fetch();
                $data['date']=strtotime(date('Y-m-d',time()));
                $data['full_date']=time();



                if (empty($data['item']) && $_FILES['image']['error']==4 )
                {
                    $this->error_form=array('image'=>'يجب اضافة اسم المنتج او صورة لة');
                }

                if (empty($this->error_form)) {

                    $categoryIds = json_decode($data['category'], true);

                    $last_id_cat=explode('_',end($categoryIds));


                        $name_category = 'category_' . $data['model'];
                        $breadcumbsx = $this->BreadcumbsPublic($name_category, $last_id_cat[1]);
                        $category = $this->langControl($data['model']);
                        foreach ($breadcumbsx as $key => $cat) {
                            $category .= ' / '  . $key;
                        }
                        $data['category'] = $category;
                        $id_category = $this->BreadcumbsPublic_id_category($name_category, $last_id_cat[1]);;
                        $data['id_category'] = implode(',', $id_category);


                    $data['image']='';
                    if (empty($this->check_file($_FILES['image'], 'صور مطلوبة', array('jpg', 'jpeg', 'png')))) {
                        $data['image'] = $this->save_file($_FILES['image']);
                    }

                    $data['purchases_man']=1;
                    $data['sales_man']=1;
                    $data['id_user']=$this->userid;

                    $stmt=$this->db->insert($this->table,$data);

                    $sendProd=true;


                }

            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form= json_decode($e -> getMessage(),true);
            }

        }



        require ($this->render($this->folder,'html','add_manual','php'));
        $this->adminFooterController();


    }


    function getMainCatDB($model)
    {
        if ($this->handleLogin())
        {

            if ($model != 'savers')
            {
                $category='category_'.$model;
                $stmt=$this->db->prepare("SELECT *FROM {$category} WHERE  `relid` = 0 ");
                $stmt->execute();

                if ($stmt->rowCount() > 0)
                {

                    $html="<select  name='category[]'  id='sub_cags_p'  class='custom-select col-md-3 mb-3 list_menu_categ' onchange='sub_catgs2(this)' >";
                    $html.="<option value='' disabled  selected > اختر قسم  </option>"  ;

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


                        $html.="<option value='{$model}_{$row['id']}'   >{$row['title']}</option>"  ;

                    }

                    $html.='</select>';

                    echo $html ;
                }


            }
        }

    }




    function sub_catgs($data)
    {
        if ($this->handleLogin())
        {

            $d=explode('_',$data);

            $model=$d[0];
            $id=$d[1];
            if ($model != 'savers')
            {
                $category = 'category_' . $model;
                $stmt = $this->db->prepare("SELECT *FROM {$category} WHERE  `relid` = ? ");
                $stmt->execute(array($id));


                if ($stmt->rowCount() > 0) {

                    $html = "<select name='category[]'  id='{$data}' class='custom-select col-md-3 mb-3 list_menu_categ' onchange='sub_catgs(this)' >";
                    $html.="<option value='' disabled  selected > اختر قسم  </option>"  ;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                        $html .= "<option value='{$model}_{$row['id']}'   >{$row['title']}</option>";

                        $c++;
                    }

                    $html .= '</select> ';

                    echo $html;

                }
            }
        }

    }


    function sub_catgs2($data)
    {
        if ($this->handleLogin())
        {

            $d=explode('_',$data);

            $model=$d[0];
            $id=$d[1];
            if ($model != 'savers')
            {
                $category = 'category_' . $model;
                $stmt = $this->db->prepare("SELECT *FROM {$category} WHERE  `relid` = ? ");
                $stmt->execute(array($id));


                if ($stmt->rowCount() > 0) {

                    $html = "<select name='category[]'  id='{$data}'  class='custom-select col-md-3 mb-3 list_menu_categ' onchange='sub_catgs2(this)' > ";
                    $html.="<option value='' disabled  selected > اختر قسم  </option>"  ;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                        $html .= "<option value='{$model}_{$row['id']}'   >{$row['title']}</option>";

                    }

                    $html .= '</select>';

                    echo $html;

                }
            }
        }

    }




    function save_file($image)
    {

        $save_file = $this->root_file;
        @mkdir($save_file);
        $path = $save_file;



            if ($image['error'] == 0) {
                $fileName_agency_file = $image['name'];
                $file_agency_file = $image['tmp_name'];
                $temp_agency_file = explode(".", $fileName_agency_file);
                $extension_agency_file = strtolower(end($temp_agency_file));
                $fileName_agency_file = time() . md5(mt_rand(1, time())) . '_.' . $extension_agency_file;
                move_uploaded_file($file_agency_file, $path . '/' . $fileName_agency_file);

                $setting=new Setting();
                $file=new Files();
                $file->smart_resize_image($this->root_file . $fileName_agency_file, $this->root_file .$fileName_agency_file, null, $setting->get('width', 1800), $setting->get('height', 1600), $setting->get('proportional', 1), 'file', false, false, $setting->get('quality', 75), $setting->get('grayscale', 0));

                return $file = $fileName_agency_file;


            }


    }



    function check_file($image, $arg, $ex = array())
    {


            if ($image['error'] == 0) {
                $fileName_agency_file = $image['name'];
                $file_agency_file = $image['tmp_name'];
                $temp_agency_file = explode(".", $fileName_agency_file);
                $extension_agency_file = strtolower(end($temp_agency_file));
                if ($image['size'] < 5194304) {
                    if (in_array($extension_agency_file, $ex)) {
                        if (is_uploaded_file($file_agency_file)) {
                        } else {
                            return $error['document'] = " فشل تحميل ملف {$arg} ";
                        }
                    } else {
                        return $error['document'] = "صيغة الملف غير مسموح بيها";

                    }
                } else {
                    return $error['document'] = "   حجم الملف اكبر من 5 ميكابت ";
                }
            } else {
                return $error['document'] = "مطلوب ";
            }

    }













    public function report()
    {
        $this->checkPermit('report','sales_man');
        $this->adminHeaderController($this->langControl('report'));

        if (isset($_GET['date'])) {
            $date = strtotime($_GET['date']);
        }else
        {
            $date=null;
        }

        require ($this->render($this->folder,'html','report','php'));
        $this->adminFooterController();

    }


    public function processing_report($date=null)
    {


        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(


            array( 'db' => 'id', 'dt' => 0 ,
                'formatter' => function( $d, $row ) {
                    return "<input type='checkbox'    class='childcheckbox'  name='item[]' value='{$d}'>";
                }
            ),
            array( 'db' => 'category', 'dt' => 1 ),
            array( 'db' => 'item', 'dt' => 2 ),
            array( 'db' => 'code', 'dt' => 3 ),
            array( 'db' => 'color', 'dt' => 4 ),
            array( 'db' => 'price', 'dt' => 5 ),
            array( 'db' => 'quantity', 'dt' => 6 ),
            array( 'db' => 'note', 'dt' => 7 ),

            array( 'db' => 'date', 'dt' =>  8,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d ', $d);
                }

            ),
            array( 'db' => 'image', 'dt' => 9,
                'formatter' => function( $d, $row ) {
                    if (!empty($d))
                    {
                        return "<img style='width: 30px' src='{$this->save_file}{$d}'>";

                    }else
                    {
                        return "<img style='width: 30px' src=".$this->static_file_control."/image/admin/default.png >";

                    }
                }
            ),

        array( 'db' => 'id_user', 'dt' => 10,
                'formatter' => function( $d, $row ) {
                    return  $this->delivery_user_name($d);
                }
            ),



            array(  'db' => 'id', 'dt'=>11)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        if ($date == null)
        {

            echo json_encode(
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`sales_man`=1 AND `id_user`={$this->userid}")
            );

        }else
        {
            echo json_encode(
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`sales_man`=1 AND `id_user`={$this->userid} AND  `date` = {$date} ")
            );

        }

    }



    function delivery_user_name($id)
    {

        if ($this->handleLogin())
        {
            $stmtCods = $this->db->prepare("SELECT `username`FROM `user` WHERE id = ?    LIMIT 1");
            $stmtCods->execute(array($id));
            $result=$stmtCods->fetch(PDO::FETCH_ASSOC);
            return $result['username'];
        }

    }



/*
    function  excel()
    {
        $this->checkPermit('excel','sales_man');
        $this->adminHeaderController($this->langControl('add'));

        if(isset($_POST["submit"])) {

            try {
                $form = new  Form();

                $form->post('excel')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();

                $name_file=json_decode($data['excel'],true);

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
                    $date=strtotime(date('Y-m-d',time()));
                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                            NULL,
                            TRUE,
                            TRUE);

                        if (count($rowData[0]) >= 7 )
                        {
                            $stmt = $this->db->prepare("INSERT INTO {$this->table} (`category`,`item`,`code`,`color`,`price`,`quantity`,`note`,`id_user`,`date`,`sales_man`) VALUES(?,?,?,?,?,?,?,?,?,?)");
                            $stmt->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $rowData[0][3], $rowData[0][4], $rowData[0][5], $rowData[0][6],$this->userid, $date,0));
                        }else{
                            $this->error_form=json_encode(array('excel'=>'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
                            break;
                        }

                    }

                    @unlink($inputFileName);
                }else
                {

                    $this->error_form=json_encode(array('excel'=>'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form))
                {
                    $this->lightRedirect(url.'/'.$this->folder);

                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'html','add_excel','php'));
        $this->adminFooterController();
    }
*/




    function by_code()
    {

        $this->checkPermit('add_purchases_by_code', 'sales_man');
        $this->adminHeaderController($this->langControl('check_code'));


        $categ=array();
        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
        $stmt_cat->execute(array($this->userid));

        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
        {
            $cat[$row['catg']]=$this->langControl($row['catg']);
        }


        require($this->render($this->folder, 'html', 'code', 'php'));

        $this->adminFooterController();


    }

    function get()
    {
        if ($this->handleLogin()) {
            $this->checkPermit('add_purchases_by_code', 'sales_man');

            $code = strip_tags(trim($_POST['code']));
            $cat = strip_tags(trim($_POST['cat']));

            $device=array();


            if ($cat =='mobile')
            {


                $stmtCode_mobile=$this->db->prepare("SELECT *FROM `excel` WHERE `code`=?");
                $stmtCode_mobile->execute(array($code));
                if ($stmtCode_mobile->rowCount() > 0 )
                {
                    $result=$stmtCode_mobile->fetch(PDO::FETCH_ASSOC);


                    $device[0]['quantity']=$result['quantity'];
                    $device[0]['price']=$result['price'];



                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1  AND `status` =0    AND `table`='mobile' ");
                    $stmt_order->execute(array($result['code']));
                    $only_order=$stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order']=$only_order['num'];


                    $stmt_cd = $this->db->prepare("SELECT  `id_color`  FROM `code` WHERE `code` =?  ");
                    $stmt_cd->execute(array($result['code']));
                    $id_color=$stmt_cd->fetch(PDO::FETCH_ASSOC);


                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`color`  FROM `color` WHERE `id` =?  ");
                    $stmt_img->execute(array($id_color['id_color']));
                    $img_div=$stmt_img->fetch(PDO::FETCH_ASSOC);


                    $device[0]['img']=$this->save_file.$img_div['img'];
                    $device[0]['color']=$img_div['code_color'];
                    $device[0]['name_color'] = $img_div['color'];

                    $stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `mobile` WHERE `id` =?    ");
                    $stmt_name_device->execute(array($img_div['id_item']));
                    $name_device=$stmt_name_device->fetch(PDO::FETCH_ASSOC);
                    $device[0]['name'] = $name_device['title'];
                    $device[0]['id'] = $name_device['id'];

                    $stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_mobile` WHERE `id` =?    ");
                    $stmt_name_cat->execute(array($name_device['id_cat']));
                    $name_cate=$stmt_name_cat->fetch(PDO::FETCH_ASSOC);
                    $device[0]['category']=$this->langControl('mobile'). '  /  ' .$name_cate['title'];


                }
            }


            if ($cat =='camera') {
                $stmtCode_camera = $this->db->prepare("SELECT *FROM `excel_camera` WHERE `code`=?");
                $stmtCode_camera->execute(array($code));
                if ($stmtCode_camera->rowCount() > 0) {
                    $result = $stmtCode_camera->fetch(PDO::FETCH_ASSOC);

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];



                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='camera' ");
                    $stmt_order->execute(array($result['code']));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order'] = $only_order['num'];



                    $stmt_cd = $this->db->prepare("SELECT  `id_color`  FROM `code_camera` WHERE `code` =?  ");
                    $stmt_cd->execute(array($result['code']));
                    $id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);

                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color ,`color` FROM `color_camera` WHERE `id` =?  ");
                    $stmt_img->execute(array($id_color['id_color']));
                    $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                    $device[0]['img'] = $this->save_file . $img_div['img'];
                    $device[0]['color'] = $img_div['code_color'];
                    $device[0]['name_color'] = $img_div['color'];

                    $stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `camera` WHERE `id` =?    ");
                    $stmt_name_device->execute(array($img_div['id_item']));
                    $name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
                    $device[0]['name'] = $name_device['title'];
                    $device[0]['id'] = $name_device['id'];

                    $stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_camera` WHERE `id` =?    ");
                    $stmt_name_cat->execute(array($name_device['id_cat']));
                    $name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
                    $device[0]['category'] = $this->langControl('camera') . '  /  ' . $name_cate['title'];


                }

            }



            if ($cat =='printing_supplies') {
                $stmtCode_printing_supplies = $this->db->prepare("SELECT *FROM `excel_printing_supplies` WHERE `code`=?");
                $stmtCode_printing_supplies->execute(array($code));
                if ($stmtCode_printing_supplies->rowCount() > 0) {
                    $result = $stmtCode_printing_supplies->fetch(PDO::FETCH_ASSOC);

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];



                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='printing_supplies' ");
                    $stmt_order->execute(array($result['code']));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order'] = $only_order['num'];



                    $stmt_cd = $this->db->prepare("SELECT  `id_color`  FROM `code_printing_supplies` WHERE `code` =?  ");
                    $stmt_cd->execute(array($result['code']));
                    $id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);

                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color ,`color` FROM `color_printing_supplies` WHERE `id` =?  ");
                    $stmt_img->execute(array($id_color['id_color']));
                    $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                    $device[0]['img'] = $this->save_file . $img_div['img'];
                    $device[0]['color'] = $img_div['code_color'];
                    $device[0]['name_color'] = $img_div['color'];

                    $stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `printing_supplies` WHERE `id` =?    ");
                    $stmt_name_device->execute(array($img_div['id_item']));
                    $name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
                    $device[0]['name'] = $name_device['title'];
                    $device[0]['id'] = $name_device['id'];

                    $stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_printing_supplies` WHERE `id` =?    ");
                    $stmt_name_cat->execute(array($name_device['id_cat']));
                    $name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
                    $device[0]['category'] = $this->langControl('printing_supplies') . '  /  ' . $name_cate['title'];


                }

            }


            if ($cat =='computer') {
                $stmtCode_computer = $this->db->prepare("SELECT *FROM `excel_computer` WHERE `code`=?");
                $stmtCode_computer->execute(array($code));
                if ($stmtCode_computer->rowCount() > 0) {
                    $result = $stmtCode_computer->fetch(PDO::FETCH_ASSOC);

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];



                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='computer' ");
                    $stmt_order->execute(array($result['code']));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order'] = $only_order['num'];



                    $stmt_cd = $this->db->prepare("SELECT  `id_color`  FROM `code_computer` WHERE `code` =?  ");
                    $stmt_cd->execute(array($result['code']));
                    $id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);

                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color ,`color` FROM `color_computer` WHERE `id` =?  ");
                    $stmt_img->execute(array($id_color['id_color']));
                    $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                    $device[0]['img'] = $this->save_file . $img_div['img'];
                    $device[0]['color'] = $img_div['code_color'];
                    $device[0]['name_color'] = $img_div['color'];

                    $stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `computer` WHERE `id` =?    ");
                    $stmt_name_device->execute(array($img_div['id_item']));
                    $name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
                    $device[0]['name'] = $name_device['title'];
                    $device[0]['id'] = $name_device['id'];

                    $stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_computer` WHERE `id` =?    ");
                    $stmt_name_cat->execute(array($name_device['id_cat']));
                    $name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
                    $device[0]['category'] = $this->langControl('computer') . '  /  ' . $name_cate['title'];


                }

            }
            if ($cat =='games') {
                $stmtCode_games = $this->db->prepare("SELECT *FROM `excel_games` WHERE `code`=?");
                $stmtCode_games->execute(array($code));
                if ($stmtCode_games->rowCount() > 0) {
                    $result = $stmtCode_games->fetch(PDO::FETCH_ASSOC);

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];



                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1  AND `status` =0  AND `table`='games' ");
                    $stmt_order->execute(array($result['code']));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order'] = $only_order['num'];



                    $stmt_cd = $this->db->prepare("SELECT  `id_color`  FROM `code_games` WHERE `code` =?  ");
                    $stmt_cd->execute(array($result['code']));
                    $id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);

                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`color`  FROM `color_games` WHERE `id` =?  ");
                    $stmt_img->execute(array($id_color['id_color']));
                    $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                    $device[0]['img'] = $this->save_file . $img_div['img'];
                    $device[0]['color'] = $img_div['code_color'];
                    $device[0]['name_color'] = $img_div['color'];

                    $stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `games` WHERE `id` =?    ");
                    $stmt_name_device->execute(array($img_div['id_item']));
                    $name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
                    $device[0]['name'] = $name_device['title'];
                    $device[0]['id'] = $name_device['id'];

                    $stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_games` WHERE `id` =?    ");
                    $stmt_name_cat->execute(array($name_device['id_cat']));
                    $name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
                    $device[0]['category'] = $this->langControl('games') . '  /  ' . $name_cate['title'];


                }


            }

            if ($cat =='network') {
                $stmtCode_network = $this->db->prepare("SELECT *FROM `excel_network` WHERE `code`=?");
                $stmtCode_network->execute(array($code));
                if ($stmtCode_network->rowCount() > 0) {
                    $result = $stmtCode_network->fetch(PDO::FETCH_ASSOC);

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];


                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0   AND `table`='network' ");
                    $stmt_order->execute(array($result['code']));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order'] = $only_order['num'];



                    $stmt_cd = $this->db->prepare("SELECT  `id_color`  FROM `code_network` WHERE `code` =?  ");
                    $stmt_cd->execute(array($result['code']));
                    $id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);

                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`color`  FROM `color_network` WHERE `id` =?  ");
                    $stmt_img->execute(array($id_color['id_color']));
                    $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                    $device[0]['img'] = $this->save_file . $img_div['img'];
                    $device[0]['color'] = $img_div['code_color'];
                    $device[0]['name_color'] = $img_div['color'];

                    $stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `network` WHERE `id` =?    ");
                    $stmt_name_device->execute(array($img_div['id_item']));
                    $name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
                    $device[0]['name'] = $name_device['title'];
                    $device[0]['id'] = $name_device['id'];


                    $stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_network` WHERE `id` =?    ");
                    $stmt_name_cat->execute(array($name_device['id_cat']));
                    $name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
                    $device[0]['category'] = $this->langControl('network') . '  /  ' . $name_cate['title'];


                }

            }
            if ($cat =='accessories') {

                $color = strip_tags(trim($_POST['color']));

                $stmtCode_accessories = $this->db->prepare("SELECT *FROM `excel_accessories` WHERE `code`=? AND `color`= ?");
                $stmtCode_accessories->execute(array($code,$color));
                if ($stmtCode_accessories->rowCount() > 0) {
                    $result = $stmtCode_accessories->fetch(PDO::FETCH_ASSOC);

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];



                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `name_color` =?  AND `buy` = 1 AND `status` =0  AND `table`='accessories' ");
                    $stmt_order->execute(array($result['code'],$color));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order'] = $only_order['num'];




                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`color`  FROM `color_accessories` WHERE `code` =? AND `color`= ? ");
                    $stmt_img->execute(array($result['code'],$color));
                    $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                    $device[0]['img'] = $this->save_file . $img_div['img'];
                    $device[0]['color'] = $img_div['code_color'];
                    $device[0]['name_color'] = $img_div['color'];

                    $stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `accessories` WHERE `id` =?    ");
                    $stmt_name_device->execute(array($img_div['id_item']));
                    $name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
                    $device[0]['name'] = $name_device['title'];
                    $device[0]['id'] = $name_device['id'];

                    $stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_accessories` WHERE `id` =?    ");
                    $stmt_name_cat->execute(array($name_device['id_cat']));
                    $name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
                    $device[0]['category'] = $this->langControl('accessories') . '  /  ' . $name_cate['title'];


                }


            }

            if ($cat =='savers')
            {
                $color = strip_tags(trim($_POST['color']));


                $stmtCode_network = $this->db->prepare("SELECT *FROM `excel_savers` WHERE `code`=? AND `color`=? ");
                $stmtCode_network->execute(array($code,$color));
                if ($stmtCode_network->rowCount() > 0) {
                    $result = $stmtCode_network->fetch(PDO::FETCH_ASSOC);

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];


                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `name_color` =?  AND `buy` = 1 AND `status` =0   AND `table`='product_savers' ");
                    $stmt_order->execute(array($result['code'],$color));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order'] = $only_order['num'];




                    $stmt_color = $this->db->prepare("SELECT  * FROM `product_color`  WHERE `color` =?   LIMIT 1");
                    $stmt_color->execute(array($color));
                    $colorx = $stmt_color->fetch(PDO::FETCH_ASSOC);
                    $device[0]['color'] = $colorx['code_color'];
                    $device[0]['name_color'] = $colorx['color'];
                    $device[0]['img'] = $this->save_file . $colorx['img'];



                    $stmt_name = $this->db->prepare("SELECT  `id`,`title`  FROM `product_savers` WHERE `id` =?  AND `code` =?");
                    $stmt_name->execute(array($colorx['id_product'],$result['code']));
                    $name_device = $stmt_name->fetch(PDO::FETCH_ASSOC);
                    $device[0]['name'] = $name_device['title'];
                    $device[0]['id'] = $name_device['id'];

                    $device[0]['category'] = $this->langControl('savers') ;

                }

            }


            require($this->render($this->folder, 'html', 'data', 'php'));


        }
    }



    function color_list($code,$cat)
    {
        $this->checkPermit('check_code', 'sales_man');


        $code = strip_tags(trim($code));
        $cat = strip_tags(trim($cat));

        $table='excel_'.$cat;
        $stmtColor = $this->db->prepare("SELECT *FROM `{$table}` WHERE `code`=?  ");
        $stmtColor->execute(array($code));
        $html='<select class="custom-select mr-sm-2"  id="color_name_acc">';
        if ($stmtColor->rowCount() > 0) {
            $c=0;
            while ($row = $stmtColor->fetch(PDO::FETCH_ASSOC))
            {
                if ($c==0)
                {
                    $html.="<option value='{$row['color']}'  selected>{$row['color']}</option>";

                }else
                {
                    $html.="<option value='{$row['color']}'>{$row['color']}</option>";

                }

                $c++;

            }

        }

        echo $html.='</select>';



    }







}



















