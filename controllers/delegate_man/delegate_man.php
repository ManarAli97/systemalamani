<?php

class delegate_man extends Controller
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
        $this->checkPermit('delegate_man','delegate_man');
        $this->adminHeaderController($this->langControl('delegate_man'));



        $categ=array();
        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
        $stmt_cat->execute(array($this->userid));
        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
        {
            $categ[]=$row['catg'];
        }




        if (isset($_POST['model']) && isset($_POST['category'])) {

            $categoryIds = $_POST['category'];


            $id = explode('_', end($categoryIds));
            $id = $id[1];
            $model = $_POST['model'];

            $name_category = 'category_' . $model;
            $breadcumbsx = $this->BreadcumbsPublic($name_category, $id);
            $category = $this->langControl($model);
            foreach ($breadcumbsx as $key => $cat) {
                $category .= ' / ' . $key;
            }

            $id_category= $this->BreadcumbsPublic_id_category($name_category,$id);;
            $ids=implode(',',$id_category);
        } else if (isset($_POST['model']))
        {
            $id = null;
            $model = $_POST['model'];
            $category = $this->langControl($model);

        }else
        {
            $id=null;
            $model=null;
            $category=null;

        }


        if ($model == null)
        {
            $categ=array();
            $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
            $stmt_cat->execute(array($this->userid));
            while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
            {
                $categ[]=$row['catg'];
            }
        }else
        {
            $categ=array();
            $categ[]=$model;
            $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? AND `catg` <> ?");
            $stmt_cat->execute(array($this->userid,$model));
            while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
            {
                $categ[]=$row['catg'];
            }
        }



        require ($this->render($this->folder,'html','index','php'));
        $this->adminFooterController();

    }




public function processing($model,$id=null)
{

    if ($model !=null && ($id != null || $id != 0))

    {

        $name_category='category_'.$model;
        $breadcumbsx = $this->BreadcumbsPublic($name_category,$id);
        $category= $this->langControl($model) ;
        foreach ($breadcumbsx as  $key => $cat)
        {
            $category.= ' / ' . $key;
        }

        $id_category= $this->BreadcumbsPublic_id_category($name_category,$id);;
        $ids=implode(',',$id_category);

    }



    $region=array();
    $stmt_region = $this->db->prepare("SELECT *FROM `user_purchases_region`  WHERE `id_user`=? ");
    $stmt_region->execute(array($this->userid));
    while ($row_r = $stmt_region->fetch(PDO::FETCH_ASSOC))
    {
        $region[]=$row_r['id_region'];
    }

    $regionx=implode(',',$region);



    $table = $this->table;
    $primaryKey = 'id';

    $columns = array(

        array( 'db' => 'category', 'dt' => 0 ),
        array( 'db' => 'item', 'dt' => 1 ),
        array( 'db' => 'region', 'dt' => 2,

            'formatter' => function( $d, $row ) {
                return  $this->region_all($d);
            }

        ),
        array( 'db' => 'code', 'dt' => 3 ),
        array( 'db' => 'color', 'dt' => 4 ),
        array( 'db' => 'price', 'dt' => 5 ),
        array( 'db' => 'quantity', 'dt' => 6,
            'formatter' => function( $d, $row ) {
                return (int)$d;
            }
          ),

        array( 'db' => 'sale_quantity', 'dt' => 7,
            'formatter' => function( $d, $row ) {
                return (int)$d;
            }

        ),
        array( 'db' => 'quantity', 'dt' => 8,
            'formatter' => function( $d, $row ) {
                return (int)$d - (int)$row[7];
            }
        ),



        array(
            'db' => 'id',
            'dt' => 9,
            'formatter' => function ($id, $row) {

                return "
                   <div style='text-align: center'>
                    <button class='btn btn-success btn-sm'   data-toggle='modal' data-target='#exampleModal_edit' data-id='{$id}' data-path_catg='{$row[0]}'   data-title='{$row[1]}'  data-image='{$row[12]}'   >
                    شراء 
                         </button>
                    </div>
                   
                    ";

            }
        ),


        array( 'db' => 'note', 'dt' => 10 ),

         array( 'db' => 'full_date', 'dt' =>  11,
            'formatter' => function( $d, $row ) {
                return date( 'Y-m-d h:i A', $d);
            }

        ),
        array( 'db' => 'image', 'dt' => 12,
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





        array(  'db' => 'id', 'dt'=>13),



    );

// SQL server connection information
    $sql_details = array(
        'user' => DB_USER,
        'pass' => DB_PASS,
        'db'   => DB_NAME,
        'host' => DB_HOST,
        'charset' => 'utf8'
    );

    if ($id==null || $id==0 )
    {

        echo json_encode(
    // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
        SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`model` = '{$model}'  AND `region` IN ({$regionx})  AND  `delegate_man`=1 AND `id_user_d`={$this->userid} AND `purchases`=0")
    );
    }

    else
    {
        echo json_encode(
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`model` = '{$model}' AND (`category` LIKE '%{$category}%')   AND `region` IN ({$regionx})  AND  `delegate_man`=1 AND `id_user_d`={$this->userid} AND `purchases`=0")
        );

    }


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





    function add_suggestion()
    {

        $this->checkPermit('add_suggestion','delegate_man');
        $this->adminHeaderController($this->langControl('add_suggestion'));


        $sendProd=false;

        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();


                $form->post('item')
                    ->val('is_empty','اسم المادة مطلوب')
                    ->val('strip_tags');


                $form->post('image')
                    ->val('is_array')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $data['date']=strtotime(date('Y-m-d',time()));
                $data['full_date']=time();
                $image = array();
                if (empty($this->check_file($_FILES['image'], 'صور مطلوبة', array('jpg', 'jpeg', 'png')))) {
                    $image = $this->save_file($_FILES['image']);
                }else
                {
                    $this->error_form=array('image'=>'يجب اضافة  صورة لة');
                }


                if (empty($this->error_form)) {



                    $data['image']=$image[0];
                    $data['list_image']=implode(',',$image);
                    $data['id_user_d']=$this->userid;

                    $stmt=$this->db->insert( $this->table,$data);
                    $sendProd=true;
                }

            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form= json_decode($e -> getMessage(),true);
            }

        }


        require ($this->render($this->folder,'html','add_suggestion','php'));
        $this->adminFooterController();


    }



    function save_file($image)
    {

        $save_file = $this->root_file;
        @mkdir($save_file);
        $path = $save_file;
        $setting=new Setting();
        $xfile=new Files();
        $file = array();
        foreach ($image["name"] as $i => $data) {
            if ($image['error'][$i] == 0) {
                $fileName_agency_file = $image['name'][$i];
                $file_agency_file = $image['tmp_name'][$i];
                $temp_agency_file = explode(".", $fileName_agency_file);
                $extension_agency_file = strtolower(end($temp_agency_file));
                $fileName_agency_file = time() . md5(mt_rand(1, time())) . '_.' . $extension_agency_file;
                move_uploaded_file($file_agency_file, $path . '/' . $fileName_agency_file);


                $xfile->smart_resize_image($this->root_file . $fileName_agency_file, $this->root_file .$fileName_agency_file, null, $setting->get('width', 1800), $setting->get('height', 1600), $setting->get('proportional', 1), 'file', false, false, $setting->get('quality', 75), $setting->get('grayscale', 0));

                $file[$i] = $fileName_agency_file;
            }
        }
        return $file;
    }



    function check_file($image, $arg, $ex = array())
    {

        foreach ($image["name"] as $i => $data) {
            if ($image['error'][$i] == 0) {
                $fileName_agency_file = $image['name'][$i];
                $file_agency_file = $image['tmp_name'][$i];
                $temp_agency_file = explode(".", $fileName_agency_file);
                $extension_agency_file = strtolower(end($temp_agency_file));
                if ($image['size'][$i] < 15194304) {
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
    }













    public function report()
    {
        $this->checkPermit('report','delegate_man');
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


        $categ=array();
        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
        $stmt_cat->execute(array($this->userid));
        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
        {
            $categ[]="'".$row['catg']."'";
        }
        $model=implode(',',$categ);




        $region=array();
        $stmt_region = $this->db->prepare("SELECT *FROM `user_purchases_region`  WHERE `id_user`=? ");
        $stmt_region->execute(array($this->userid));
        while ($row_r = $stmt_region->fetch(PDO::FETCH_ASSOC))
        {
            $region[]=$row_r['id_region'];
        }

        $regionx=implode(',',$region);






        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'category', 'dt' => 0 ),
            array( 'db' => 'item', 'dt' => 1 ),
            array( 'db' => 'code', 'dt' => 2 ),
            array( 'db' => 'color', 'dt' => 3 ),
            array( 'db' => 'price', 'dt' => 4 ),
            array( 'db' => 'quantity', 'dt' => 5,
                'formatter' => function( $d, $row ) {
                    return (int)$d;
                }
            ),

            array( 'db' => 'sale_quantity', 'dt' => 6,
                'formatter' => function( $d, $row ) {
                    return (int)$d;
                }

            ),
            array( 'db' => 'quantity', 'dt' => 7,
                'formatter' => function( $d, $row ) {
                    return (int)$d - (int)$row[6];
                }
            ),


            array( 'db' => 'note', 'dt' => 8 ),

            array( 'db' => 'date', 'dt' =>  9,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d ', $d);
                }

            ),
            array( 'db' => 'image', 'dt' => 10,
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



            array(  'db' => 'id', 'dt'=>11),



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
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`model` IN ({$model})  AND `region` IN ({$regionx})  AND `id_user_d`={$this->userid} AND `purchases_finish`=1 AND `checked_purchases`=0")
            );

        }else
        {
            echo json_encode(

                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`model` IN ({$model})  AND `region` IN ({$regionx})  AND `id_user_d`={$this->userid} AND `purchases_finish`=1 AND  `date_purchases` = {$date}  AND `checked_purchases`=0")
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






    public function edit_region($id = null)
    {

        if ($this->handleLogin()) {
            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }
            $title = $_POST['title'];
            $stmt = $this->db->update($this->table, array('title' => $title), "id={$id}");

        }

    }




    function purchases_add($id)
    {

        $stmt=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE `id`= ? ");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);


        if (isset($_POST['submit'])) {

            try {

                $form = new  Form();


                $form->post('price_purchases')
                    ->val('is_empty',' سعر شراء مطلوب')
                    ->val('strip_tags');


                $form->post('sale_quantity')
                    ->val('is_empty','الكمية مطلوبة')
                    ->val('strip_tags');

                $form->post('note_d')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $data['date_purchases']=strtotime(date('Y-m-d',time()));
                $data['time_purchases']=strtotime(date('h:i:s A',time()));



                if ( ((int)$data['sale_quantity'] + (int)$result['sale_quantity']) < $result['quantity'] )
                {
                    $data['purchases']=0;
                    $data['purchases_man']=1;

                }else
                {
                    $data['delegate_man']=2;
                    $data['purchases']=1;

                }

                $data['purchases_finish']=1;




                if ( ((int)$data['sale_quantity'] + (int)$result['sale_quantity']) < $result['quantity'] )
                {
                    $data['sale_quantity']=(int)$data['sale_quantity']+(int)$result['sale_quantity'];

                    $this->db->update($this->table,$data,"`id`={$id}");

                    echo json_encode(array('id'=>$id,'sale_quantity'=>(int)$data['sale_quantity'],'piqe_quantity'=>(int)$result['quantity']-(int)$data['sale_quantity']));
                }else{
                    $data['sale_quantity']=(int)$data['sale_quantity']+(int)$result['sale_quantity'];
                    $this->db->update($this->table,$data,"`id`={$id}");
                    echo  $id;
                }




            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form=$e -> getMessage();
            }

        }



    }




}



















