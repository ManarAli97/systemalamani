
<?php

class found extends Controller
{

    public $ids = array();


    function __construct()
    {
        parent::__construct();
        $this->table = 'found';
        $this->menu=new Menu();
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `content`  longtext COLLATE utf8_unicode_ci NOT NULL,
          `image`  longtext COLLATE utf8_unicode_ci NOT NULL,
          `active` int(20) NOT NULL DEFAULT 0,
          `id_r` int(20) NOT NULL DEFAULT 0,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table));


    }
    public function getCatgry($model)
    {
        $found = $this->db->prepare("SELECT * FROM category_$model ");
        $found->execute();
        $categorys = array();
        while ($row= $found->fetch(PDO::FETCH_ASSOC))
        {
            $categorys[]=$row;
        }
        echo json_encode($categorys);




    }
    
    
    
    public function view($id = 0)
    {
        if($id==0) unset( $_SESSION['modelSelcted']);
        $this->checkPermit('list_founded','found');
        $this->adminHeaderController($this->langControl('found'));
        if (!is_numeric($id)) 
        {
            $error = new Errors();
            $error->index();
        }
        $found = $this->db->prepare("SELECT * FROM `found`  WHERE `id`=?");
        $found->execute(array($id));
        $found_data = $found->fetch(PDO::FETCH_ASSOC);
        $data['model'] =$found_data['model'];
        $data['id_cat'] =$found_data['id_cat'];
        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();
                $form->post('model')
                    ->val('strip_tags');
                $form->post('id_cat')
                    ->val('strip_tags');
                $form->submit();
                $data = $form->fetch();
                $stmt = $this->db->prepare("update  found set model=?,id_cat=? where id=?");
                $stmt->execute(array($data['model'], $data['id_cat'],$id));
                $this->addFoundTracking($id,"model",$this->getCatgryName($data['id_cat'],$data['model']) );
                $this->lightRedirect(url.'/'.$this->folder.'/view');
              
               
            } catch (Exception $e) {
                $data = $form->fetch();
                $data['date'] = strtotime($data['date']);
                $this->error_form = json_decode($e->getMessage(), true);
            }
        }
        require ($this->render($this->folder,'html','index','php'));
        $this->adminFooterController();
    }
    /**
     *  هاي الدالة تحدد اي نوع من المستخدمين  موجود
     */
    public function checkOption($admin,$supplier,$callCenter,$all)
    {
        
        $_SESSION['filterOption']= array();
        if($admin==1) 
            $_SESSION['filterOption'][0]= $admin; 
        else if(isset ($_SESSION['filterOption'][0])) 
            unset($_SESSION['filterOption'][0]);

        if($supplier==1) 
            $_SESSION['filterOption'][1]= $supplier; 
        else if(isset ($_SESSION['filterOption'][1])) 
            unset($_SESSION['filterOption'][1]);

        if($callCenter==1) 
            $_SESSION['filterOption'][2]= $callCenter; 
        else if(isset ($_SESSION['filterOption'][2])) 
            unset($_SESSION['filterOption'][2]);
        
        if($all==1) 
            $_SESSION['filterOption'][3]= $all; 
        else if(isset ($_SESSION['filterOption'][3])) 
            unset($_SESSION['filterOption'][3]);
        


    }



    public function processing()
    {
        $table = $this->table;
        $primaryKey = 'id';


        $columns = array(

            array( 'db' => 'id_r', 'dt' => 0 ,
                'formatter' => function( $d, $row ) {
                    return  $this->costomer_name($d) ;
                }
            ),
            // خلينه هذا الحقل نعليق لان صار تغير واسم الماده   هو الرقم حاليا
            array( 'db' => 'id_r', 'dt' => 1 ,
                'formatter' => function( $d, $row ) {
                    return  $this->costomer_phone($d) ;
                }

            ),
                // المفروض سابقا كان هذا  اسم الماده ولكن للضروره صار رقم هاتف 
            array( 'db' => 'title', 'dt' =>2 ),
            array( 'db' => 'content', 'dt' => 3 ),


            array( 'db' => 'date', 'dt' =>  4,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);
                }
            ),



            array(
                'db'        => 'id',
                'dt'        => 5,
                'formatter' => function($id, $row ) {
                    return "
                   <div style='text-align: center;font-size: 20px;'>
                    <a href=".url.'/'.$this->folder."/details/$id> <span>عرض التفاصيل</span> </a>
                    </div> ";
                }
            ),
            array(
                'db'        => 'model',
                'dt'        => 6,
                'formatter' => function($id, $row ) {  
                    if(isset( $_SESSION['filterOption'][0]) && $_SESSION['filterOption'][0]==1 || isset( $_SESSION['filterOption'][3]) && $_SESSION['filterOption'][3]==1)
                    {
                        
                        return "
                        <div id='model_$row[5]' style='text-align: center;font-size: 17px; '>
                        <a  href=".url.'/'.$this->folder."/view/$row[5]> <span>{$this->langControl($id)}</span> </a><p style='font-size:10px;' >{$this->getUser($row[5],'model')}</P>
                        </div> ";
                    }
                    else return '<p>'.$this->langControl($id).'</p>'.$this->getUser($row[5],'model');
                }
            ),
            // array( 'db' => 'id_cat', 'dt' =>8 ),
            array( 'db'  => 'id_cat', 'dt' =>7 ,
            'formatter' => function( $d, $row ) {
                return   $this->getCatgryName($d,$row[6]) ;
            }
        ),
        array( 'db'  => 'note_item', 'dt' =>8 ,
            'formatter' => function( $d, $row ) {
                return   $this->noteInput($row[5],$d);
            }
        ),
        array( 
            'db' => 'id_item',
            'dt' =>9,
            'formatter' => function($id, $row ) {
                return $this->textinput($row[5],$id);
            }
        ),
        
        array(  'db' => 'id', 'dt'=>10,
        'formatter' => function($id, $row ) {
            return "
            <div style='text-align: center'>
            <input {$this->checkEnable($row[5])} class='toggle-demo' onchange='updateCalled(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'><p style='font-size:10px;' >{$this->getUser($row[5],'called')}</P>
            </div>
            ";
        }
        
    ),
    array( 
        'db' => 'note_called',
        'dt' =>11,
        'formatter' => function($id, $row ) {
            return $this->noteCalled($row[5],$id);
        }
    ),
        array(
            'db'        => 'id',
            'dt'        =>12,
            'formatter' => function($id, $row ) { 
                if($this->permit("delete",$this->folder))
                {
                    return "
                <div style='text-align: center'>
                    <button type='button'  class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[2]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                        </button>
                    </div> ";
                }
                else return "لا تمتلك صلاحية";

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
        $select= ' id like "%%" ';

       
            if(isset($_SESSION['filterOption'][0])) $select .= ' and model ="بلا" ';
            if(isset($_SESSION['filterOption'][1]))
            {
                $select .= ' and id_item ="" and model !="بلا" ';
                if(isset($_SESSION['modelSelcted']))
                {
                    $select .= ' and model like "%'.$_SESSION['modelSelcted'].'%" ';
                    if(isset($_SESSION['id_catSelcted']) && $_SESSION['id_catSelcted']!=0)
                    {
                        $select .= ' and id_cat = '.$_SESSION['id_catSelcted'].' ';
                    }
                }
            } 
            if(isset($_SESSION['filterOption'][2])) 
            {
                $select .= ' and called ="0" and id_item !="" and model !="بلا"  ';
                if(isset($_SESSION['modelSelcted']))
                {
                    $select .= ' and model like "%'.$_SESSION['modelSelcted'].'%" ';
                    if(isset($_SESSION['id_catSelcted'])&& $_SESSION['id_catSelcted']!=0)
                    {
                        $select .= ' and id_cat = '.$_SESSION['id_catSelcted'].' ';
                    }
                }
            }
            if(isset($_SESSION['filterOption'][3])) 
            {
              
                if(isset($_SESSION['modelSelcted']))
                {
                    $select .= ' and model like "%'.$_SESSION['modelSelcted'].'%" ';
                    if(isset($_SESSION['id_catSelcted'])&& $_SESSION['id_catSelcted']!=0)
                    {
                        $select .= ' and id_cat = '.$_SESSION['id_catSelcted'].' ';
                    }
                }
            }

        
        echo json_encode(
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,$select)
        );

    }
    /**
     * هاي دالة المعالجة الخاصة بموبوضع عرض  التتبع
     */
    public function processingShowTraking($id=null,$actionType=null)
    {
        $table = "found_tracking";
        $primaryKey = 'id';


        $columns = array(

            array( 'db' => 'user_id', 'dt' => 0 ,
                'formatter' => function( $d, $row ) {
                    return  $this->UserInfo( $d) ;
                }
            ),
            array( 'db' => 'the_value', 'dt' => 1 ),
            array( 'db' => 'action_date', 'dt' => 2 ,
            'formatter' => function( $d, $row ) {
                return $d ;
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
        $select= 'id_found ="'.$id.'" and action_type ="'.$actionType.'" ';

        echo json_encode(
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,$select)
        );

    }
    
    /**
     * هاي الدالة تضيف اي حركة صارت على جدول اطلب مالم تجده 
     *  */ 
    public function addFoundTracking($IdFound,$actionType,$theValue)
    {
        $stmt = $this->db->prepare("INSERT INTO `found_tracking`( `id_found`, `action_type`, `user_id`,the_value) VALUES (?,?,?,?)");
        $stmt->execute(array($IdFound,$actionType, $this->userid,$theValue));
    }
    /**
     * هاي الدالة تتاكد انه تم الاتصال بالزبون او لا من خلال الايدي
     */
    public function checkEnable($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `called` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }
    /**
     * 😁هاي الدالة مخموطه من علي مع بعض التعديلات 
     * المهم وضيفتها تحدث على الجدول وتخلي حقل الاتصال صح 
     * يتم استدعأها عن طريق اجاكس للعلم
     */
    public function updateCalled($v_, $id_)
    {
        if ($this->handleLogin()) {
            if (is_numeric($v_) && is_numeric($id_)) 
            {
                $v = $v_;
                $id = $id_;
            }
             else 
            {
                $v = 0;
                $id = 0;
            }
            $stmt = $this->db->prepare("update found set called=? where id=?");
            $stmt->execute(array($v,$id));
            if($v==1)
            {
                $this->addFoundTracking($id,"called","تم الاتصال");
            }
            else
            {
                $this->addFoundTracking($id,"called","تم الغاء الاتصال");
            }
            
		}
    }
    /**
     *   هاي الدالة ترجع اسم المستخدم الي نفذ اجراء معين على جدول اطلب مالم تجده
     * وبيها رابط حتى نشوف كل التعديلات السابقة
     */
    public function getUser($idFound,$actionType)
    {
        $found = $this->db->prepare("SELECT * FROM `found_tracking`  WHERE `id_found`=? and action_type=? ORDER BY `found_tracking`.`id` DESC" );
        $found->execute(array($idFound,$actionType));
        if($found_data = $found->fetch(PDO::FETCH_ASSOC))
            return  "
            <div style='text-align: center;font-size: 18px;'>
             <a href=".url.'/'.$this->folder."/showTraking/$idFound/$actionType> <span>{$this->UserInfo( $found_data['user_id'])}</span> </a>
             </div> " 
            ;
        else 
            return "";
    }
    /**
     * نضيف سشن المودل حتى يسوي فلتره 
     * اجاكس
     */
    public function setModelSession($model){
        $_SESSION['modelSelcted']=$model;
        $_SESSION['id_catSelcted']=0;
    }


    /**
     * نضيف سشن الفئة حتى يسوي فلتره 
     * اجاكس
     */
    public function setId_catSession($id_cat){
        $_SESSION['id_catSelcted']=$id_cat;
    
    }
    /**
     * هاي الدالة تخلي حقل المادة عباره عن مربع نص من يكون المستخدم هو مجهز
     */
    function textinput($row,$id)
    {
        if(isset($_SESSION['filterOption'][1]) && $_SESSION['filterOption'][1]==1 || isset($_SESSION['filterOption'][3]) && $_SESSION['filterOption'][3]==1)
        {
        return "
                    <div class='col-xs-2'>
                        <textarea onfocusout='addItem(this.value,$row)' class='form-control '  type='text' rows='3' >$id</textarea><p style='font-size:10px;' >{$this->getUser($row,'item')}</P>
                    </div>
                ";
        }
        return $id."<p style='font-size:10px;' >{$this->getUser($row,'item')}</P>";
    }
    /**
     * هاي الدالة تخلي حقل الملاحظة عباره عن مربع نص من يكون المستخدم هو مجهز
     */
    function noteInput($row,$id)
    {
        if(isset($_SESSION['filterOption'][1]) && $_SESSION['filterOption'][1]==1 || isset($_SESSION['filterOption'][3]) && $_SESSION['filterOption'][3]==1)
        {
        return "
                    <div class='col-xs-2'>
                        
                        <textarea  onfocusout='addNote(this.value,$row)' class='form-control '  type='text' rows='3' >$id</textarea><p style='font-size:10px;' >{$this->getUser($row,'note')}</P>
                    </div>
                ";
        }
        return $id."<p style='font-size:10px;' >{$this->getUser($row,'note')}</P>";
    }
    /**
     * هاي الدالة تخلي حقل الملاحظة عباره عن مربع نص من يكون المستخدم هو الكول سنتر
     */
    function noteCalled($row,$id)
    {
        if(isset($_SESSION['filterOption'][2]) && $_SESSION['filterOption'][2]==1 || isset($_SESSION['filterOption'][3]) && $_SESSION['filterOption'][3]==1)
        {
        return "
                    <div class='col-xs-2'>
                        
                        <textarea  onfocusout='addNoteCalled(this.value,$row)' class='form-control '  type='text' rows='3' >$id</textarea><p style='font-size:10px;' >{$this->getUser($row,'note_called')}</P>
                    </div>
                ";
        }
        return $id."<p style='font-size:10px;' >{$this->getUser($row,'note_called')}</P>";
    }

    function costomer_name($id)
    {

        if ($this->handleLogin())
        {
            if ($id !=0)
            {
                $stmtCods = $this->db->prepare("SELECT `name`FROM `register_user` WHERE id = ?    LIMIT 1");
                $stmtCods->execute(array($id));
                $result=$stmtCods->fetch(PDO::FETCH_ASSOC);
                return $result['name'];
            }else {
                return $this->langControl('unknown_person');

            }

        }

    }
    /**
     * هاي الدالة انطيها المعرف والمودل وهي تنطيني اسم الفئة 😁
      */ 
    function getCatgryName($id,$model){
        $sqlQ = $this->db->prepare("SELECT title FROM category_$model  WHERE `id`=?");
        $sqlQ->execute(array($id));
        $title = $sqlQ->fetch(PDO::FETCH_ASSOC);
        return $title['title'];
    }
    /**
     * هاي الدالة تضيف المادة ويتم استدعاؤها عن طريق اجاكس
     */
    function addId_Item()
    {
        $item = $_POST['value1'];
        $id = $_POST['value2'];
        
        $sqlQ = $this->db->prepare("SELECT * FROM found  WHERE `id`=?");
        $sqlQ->execute(array($id));
        $result = $sqlQ->fetch(PDO::FETCH_ASSOC);
        if($result["id_item"][0] != $item )
        {
            echo '<script type="text/javascript">
                consol.log('.$result["id_item"].');
                </script>';
            $stmt = $this->db->prepare("update  found set id_item=? where id=?");
            $stmt->execute(array($item,$id));
            $this->addFoundTracking($id,"item",$item);
        }
    }
    /**
     * هاي الدالة تضيف ملاحظة ويتم استدعاؤها عن طريق اجاكس
     */
    function addNote()
    {
        $note = $_POST['value1'];
        $id = $_POST['value2'];
        
        $sqlQ = $this->db->prepare("SELECT * FROM found  WHERE `id`=?");
        $sqlQ->execute(array($id));
       
       
            $stmt = $this->db->prepare("update  found set note_item=? where id=?");
            $stmt->execute(array($note,$id));
            $this->addFoundTracking($id,"note",$note);
        
    }
     /**
     * هاي الدالة تضيف ملاحظة الكول سنتر ويتم استدعاؤها عن طريق اجاكس
     */
    function addNoteCalled()
    {
        $note = $_POST['value1'];
        $id = $_POST['value2'];
        
        $sqlQ = $this->db->prepare("SELECT * FROM found  WHERE `id`=?");
        $sqlQ->execute(array($id));
      
       
            $stmt = $this->db->prepare("update  found set note_called=? where id=?");
            $stmt->execute(array($note,$id));
            $this->addFoundTracking($id,"note_called",$note);
        
    }

    /**
     * هاي الدالة من خلالها نعرض الحركات الي صارت بواسطة رقم الحقل ونوع الاكشن 
     * 
     */
    function showTraking($id=null,$actionType=null)
    {
        $this->checkPermit('details','found');
        $this->adminHeaderController($this->langControl('الحركة'));
       
        require ($this->render($this->folder,'html','show_tracking','php'));
        $this->adminFooterController();
    }


    function costomer_phone($id)
    {

        if ($this->handleLogin())
        {
            if ($id !=0)
            {
                $stmtCods = $this->db->prepare("SELECT `phone` FROM `register_user` WHERE id = ?    LIMIT 1");
                $stmtCods->execute(array($id));
                $result=$stmtCods->fetch(PDO::FETCH_ASSOC);
                return $result['phone'];
            }else{
                return $this->langControl('unknown_person');

            }
        }

    }


    function delete_item($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->table, "`id`={$id}");
        }
    }



    function details($id)
    {
        $this->checkPermit('details','found');
        $this->adminHeaderController($this->langControl('details'));
        $stmt=$this->db->prepare("SELECT *FROM {$this->table} WhERE `id`=?");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        $image=array();
        $image=explode(',',$result['image']);
        require ($this->render($this->folder,'html','details','php'));
        $this->adminFooterController();
    }
    
    function add()
    {
        $sendProd=false;
        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();
                $form->post('title')
                    ->val('strip_tags');

                $form->post('content')
                    ->val('strip_tags');


                $form->post('image')
                    ->val('is_array')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $data['date']=time();
                if (isset($_SESSION['id_member_r'])) {
                    $data['id_r'] = $_SESSION['id_member_r'];
                }
                $image = array();

                if ($_FILES['image']['error'][0]==0)
                {
                    if (empty($this->check_file($_FILES['image'], 'صور مطلوبة', array('jpg', 'jpeg', 'png')))) {
                        $image = $this->save_file($_FILES['image']);
                    }else
                    {
                        $this->error_form=array('image'=>'يجب اضافة  صورة لة');
                    }
                }


                if (empty($data['title']) && empty($data['content']) && $_FILES['image']['error'][0]==4)
                {
                    $this->error_form=array('error'=>'يجب ادخال احد الحقول');

                }

                if (empty($this->error_form)) {



                  //  $data['image']=$image[0];
                    $data['image']=implode(',',$image);


                    $stmt=$this->db->insert( $this->table,$data);
                    $sendProd=true;
                }

            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form= json_decode($e -> getMessage(),true);
            }

        }


        require ($this->render($this->folder,'html','add','php'));


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

}