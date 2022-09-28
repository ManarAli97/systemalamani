<?php

class medical_supplies extends Controller
{



    function __construct()
    {
        parent::__construct();
        $this->table='medical_supplies';
        $this->category='category_medical_supplies';
        $this->cart_shop_active='cart_shop_active';
        $this->menu=new Menu();

    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `price` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `quantity` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `id_cat` int(11) NOT NULL,
          `content` longtext COLLATE utf8_unicode_ci NOT NULL,
          `img` bigint(20) NOT NULL DEFAULT '0',
          `view` bigint(20) NOT NULL DEFAULT '0',
          `active` int(11) NOT NULL DEFAULT '0',
          `lang` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
          `userid` int(11) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->category}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `img` int(10) NOT NULL,
           `relid` int (10) NOT NULL,
           `active` int(10) NOT NULL DEFAULT '0',
          `lang` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
          `userid` int(11) NOT NULL,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");




        return  $this->db->cht(array($this->table, $this->category));


    }

    public function index(){


        $stmt=$this->db->prepare("SELECT * from  {$this->category} WHERE  `active` = 1  ");
        $stmt->execute();
        $data=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {


            if ( $row['img'] !=0) {
                $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row['img'], ':module' =>  $this->folder.'_cat'));
                $get_file = $get_file[0];

                    $row['image'] = $this->save_file.$get_file['rand_name'];

            }else
            {
                $row['image']=$this->static_file_control.'/image/admin/default.png';
            }
            $data[]=$row;

        }


        require ($this->render($this->folder,'html','list_category','php'));

    }




      public function admin_category($id=0)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('View_category','medical_supplies');
        $this->adminHeaderController($this->langControl('medical_supplies'),$id);
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);
        $data=$this->db->select("SELECT * from  {$this->category} WHERE  `relid` = {$id} AND `lang`='{$this->langControl}'");
      foreach ($data as $key => $dt)
      {

          $data[$key]['checked']= ($dt['active']==1) ? 'checked' : null ;
          if ($dt['img'] !=0) {
              $data[$key]['img'] = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module AND `lang`='{$this->langControl}' LIMIT 1 ", array(':id' => $dt['img'], ':module' => $this->folder.'_cat'));
              $data[$key]['image'] = $this->save_file.$data[$key]['img'][0]['rand_name'];
              $data[$key]['type_file'] = $data[$key]['img'][0]['file_type'];
              unset($data[$key]['img']);
          } else
              {
                  $data[$key]['image']=$this->static_file_control.'/image/admin/default.png';
              }


      }
        require ($this->render($this->folder,'html','admin_category','php'));
        $this->adminFooterController();

    }


    public function list_medical_supplies($id=null)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('view_medical_supplies','medical_supplies');
        $this->adminHeaderController($this->langControl('view_medical_supplies'),$id);
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);
        $data_cat=$this->db->select("SELECT * from  {$this->category} WHERE   `lang`='{$this->langControl}'");
        foreach ($data_cat as $key => $d_cat)
        {


            if ($d_cat['id']  == $id)
            {
                $d_cat['selected']='selected';

            }else
            {
                $d_cat['selected']=null;
            }
            $data_cat[$key]=$d_cat;
        }


        require ($this->render($this->folder,'html','list','php'));
        $this->adminFooterController();

    }


    public function view_medical_supplies($id)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}

            $stmtCatg=$this->db->prepare("SELECT *FROM {$this->category} WHERE `active` = 1 AND `id`=?");
            $stmtCatg->execute(array($id));
            $result=$stmtCatg->fetch(PDO::FETCH_ASSOC);

            $stmt=$this->db->prepare("SELECT * from  {$this->table} WHERE  `active` = 1 AND `id_cat`=?");
            $stmt->execute(array($id));
            $data=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {

                if ( $row['img'] !=0) {
                    $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row['img'], ':module' =>  $this->folder));
                    $get_file = $get_file[0];
                    $row['image'] = $this->save_file.$get_file['rand_name'];
                    $row['nameImage'] = $get_file['rand_name'];
                }else
                {
                    $row['image']=$this->static_file_control.'/image/admin/default.png';
                }

                $data[]=$row;

            }




        require ($this->render($this->folder,'html','view_list','php'));

    }

    public  function ajax($id_cat=null,$page=0)
    {

        $limit=8;
        if (!is_numeric($id_cat) && !is_numeric($page)  ) {$error=new Errors(); $error->index();}
        $page=$page*$limit-$limit;
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE  `id_cat`=? AND `lang`='{$this->langControl}' ORDER BY `date` DESC  LIMIT {$limit} OFFSET $page");
        $stmt->execute(array($id_cat));
        $data=array();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key => $dt) {
            if ( $dt['img'] !=0) {
                $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $dt['img'], ':module' => 'medical_supplies'));
                $get_file = $get_file[0];

                if ($get_file['file_type']=='image')
                {
                    if (file_exists($this->root_file.'thump_'.$get_file['rand_name']))
                    {
                        $dt['img'] = $this->save_file.'thump_'.$get_file['rand_name'];
                    }else
                    {
                        $dt['img'] = $this->save_file.$get_file['rand_name'];
                    }
                }else{
                    $dt['img'] =$this->static_file_control.'/image/admin/video.jpg';
                }

            }else
            {
                $dt['img']=$this->static_file_control.'/image/admin/default.png';
            }
            $dt['date']=date('Y-F-d',$dt['date']);
            $data[]=$dt;
        }
        require ($this->render($this->folder,'html','ajax','php'));
    }




    function  getCategorymedical_supplies()
    {
        $stmt=$this->db->prepare("SELECT *FROM {$this->category} WHERE `active` = 1");
        $stmt->execute();
        return $stmt;
    }


    function  getCategorymedical_supplies_not_Get_this_id($id)
    {
        $stmt=$this->db->prepare("SELECT *FROM {$this->category} WHERE `active` = 1 AND `id`  <> ?");
        $stmt->execute(array($id));
        return $stmt;
    }

    function  getmedical_suppliesByCatId($id)
    {
        $stmt=$this->db->prepare("SELECT *FROM {$this->table} WHERE `active` = 1 and `id_cat` = ?");
        $stmt->execute(array($id));
        return $stmt;
    }




    public function add_medical_supplies($id=null)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('Add_medical_supplies','medical_supplies');
        $this->adminHeaderController($this->langControl('Add_medical_supplies'),$id);
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);
        $data_cat=$this->db->select("SELECT * from  {$this->category} WHERE  `lang`='{$this->langControl}'");
        foreach ($data_cat as $key => $d_cat)
        {


            if ($d_cat['id']  == $id)
            {
                $d_cat['checked']='checked';

            }else
            {
                $d_cat['checked']=null;
            }
            $data_cat[$key]=$d_cat;
        }

        $media=array();
        $data['title']='';

        $data['content']='';
        $data['files']='';
        $data['price']='';
        $data['quantity']='';

        $data['date']= time();
        if (isset($_POST['submit']))
        {
            try
            {
             $form =new  Form();

                $form  ->post('title')
                       ->val('is_empty',$this->langControl('required'))
                       ->val('strip_tags');

                $form  ->post('price')
                       ->val('is_empty',$this->langControl('required'))
                       ->val('strip_tags');

                $form  ->post('quantity')
                       ->val('is_empty',$this->langControl('required'))
                       ->val('strip_tags');


                $form  ->post('id_cat')
                       ->val('is_empty',$this->langControl('required'))
                       ->val('strip_tags');

                $form  ->post('files')
                       ->val('is_empty','يرجى رفع صور او  فيديو  ')
                       ->val('strip_tags');

                $form  ->post('date')
                       ->val('is_empty',$this->langControl('required'))
                       ->val('strip_tags');


                $form ->submit();
                $data =$form -> fetch();
                $data['date']=strtotime($data['date']);
                $data['lang']=$this->langControl;
                $data['userid']=$this->userid;
                $data['code']=$this->randomCode();
                $file=new Files();


                  $this->db->insert($this->table,array_diff_key($data,['files'=>"delete"]));
                  $img=$file->insert_file($this->folder,$this->db->lastInsertId(),json_decode($data['files'],True));
                  $this->db->update($this->table,array('img'=>$img),"id={$this->db->lastInsertId()}");
                  $this->lightRedirect(url."/medical_supplies/list_medical_supplies/{$id}",0);


            }
            catch (Exception $e)
            {
                $data =$form -> fetch();
                $data['date']=strtotime($data['date']);
                $media=json_decode($data['files'],true);
                $this->error_form= $e -> getMessage();
            }

        }

        require ($this->render($this->folder,'html','add','php'));
        $this->adminFooterController();

    }

    function randomCode()
    {
        if ($this->handleLogin()) {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 10 ; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass); //turn the array into a string
        }
    }

    public function edit_medical_supplies($id)
    {
        $this->checkPermit('Edit_medical_supplies','medical_supplies');
        if (!is_numeric($id)) {
            die(':)');
        }

        $files =new Files();
        $this->adminHeaderController($this->langControl('edit'));

        $data=$this->db->select("SELECT * from `medical_supplies` WHERE `id`=:id AND `lang`='{$this->langControl}' LIMIT 1 ",array(':id'=>$id));
        $data=$data[0];
        $mainImg=$data['img'];
        $breadcumbs = $this ->Breadcumbs( $this->category,$data['id_cat']);

        $data_cat=$this->db->select("SELECT * from  {$this->category}  WHERE   `lang`='{$this->langControl}'");
        foreach ($data_cat as $key => $d_cat)
        {


            if ($d_cat['id']  == $data['id_cat'])
            {
                $d_cat['checked']='checked';

            }else
            {
                $d_cat['checked']=null;
            }
            $data_cat[$key]=$d_cat;
        }
        $idImg=0;
        $get_file=array();
        $get_file=$this->db->select("SELECT * from `files` WHERE `relid`=:relid AND `module`=:module AND `lang`='{$this->langControl}'",array(':relid'=>$id,':module'=>$this->folder));
        if(!empty($get_file))
        {

            $data['file_type'] = $get_file[0]['file_type'];


            foreach ($get_file as $key => $set_file) {


                if ($set_file['id'] == $data['img']) {
                    $set_file['checked'] = 'checked';
                    $set_file['class'] = 'selected';
                    $set_file['trash'] = null;
                } else {
                    $set_file['checked'] = null;
                    $set_file['class'] = null;
                    $set_file['trash'] = null;


                }

                $get_file[$key] = $set_file;
            }
        }

        $media=array();
        $data['files']='';
        if (isset($_POST['submit']))
        {
            try
            {
                $form =new  Form();

                $form  ->post('title')
                        ->val('is_empty',$this->langControl('required'))
                        ->val('strip_tags');


                $form  ->post('price')
                    ->val('is_empty',$this->langControl('required'))
                    ->val('strip_tags');


                $form  ->post('quantity')
                    ->val('is_empty',$this->langControl('required'))
                    ->val('strip_tags');



                $form  ->post('id_cat')
                        ->val('is_empty',$this->langControl('required'))
                        ->val('strip_tags');

                $form  ->post('img')
//                    ->val('is_empty','يرجى تحديد صورة او فيديو')
                         ->val('strip_tags');

                $form  ->post('files')
                        ->val('strip_tags');

                $form  ->post('date')
                       ->val('is_empty',$this->langControl('required'))
                        ->val('strip_tags');


                $form ->submit();
                $data =$form -> fetch();
                $data['date']=strtotime($data['date']);

//                if (empty($data['img']))
//                {
//                    $data['img']=0;
//                }
                $imgNew=0;
                if (!empty($data['files'])) {

                    $file = new Files();
                     $imgNew = $file->insert_file($this->folder, $id, json_decode($data['files'], True));
                }

               if ($mainImg == 0 && !empty($data['files']))
               {

                   $data['img']=$imgNew;
               }

                $this->db->update($this->table,array_diff_key($data,['files'=>"delete"]),"id={$id}");
               $this->lightRedirect(url."/medical_supplies/list_medical_supplies/{$data['id_cat']}",0);


            }catch (Exception $e)
            {
                $data =$form -> fetch();
                $data['date']=strtotime($data['date']);
                $media=json_decode($data['files'],true);
                $this->error_form= $e -> getMessage();
            }

        }


        require ($this->render($this->folder,'html','edit','php'));
        $this->adminFooterController();

    }




public function processing($id)
{


    $table = $this->table;
    $primaryKey = 'id';

    $columns = array(



        array( 'db' => 'title', 'dt' => 0 ),
        array( 'db' => 'price', 'dt' => 1 ,
           'formatter' => function( $d, $row ) {
                return $d .'د.ع';
            }
        ),
        array( 'db' => 'quantity', 'dt' => 2 ),
        array( 'db' => 'date', 'dt' => 3 ,
            'formatter' => function( $d, $row ) {
                return date( 'Y-m-d ', $d);
            }

            ),
        array(
            'db' => 'id',
            'dt' => 4,
            'formatter' => function ($id, $row) {
                if ($this->permit('visible','medical_supplies')) {
                    return "
                <div style='text-align: center'>
                  <input {$this->ch($id)} class='toggle-demo' onchange='visible_medical_supplies(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                }
                else
                {
                    return $this->langControl('forbidden');
                }
            }
        ),

        array(
            'db' => 'id',
            'dt' => 5,
            'formatter' => function ($id, $row) {
                if ($this->permit('edit','medical_supplies')) {
                    return "
                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/medical_supplies/edit_medical_supplies/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
                else
                {
                    return $this->langControl('forbidden');
                }
            }
        ),
        array(
            'db' => 'id',
            'dt' => 6,
            'formatter' => function ($id, $row) {
                if ($this->permit('edit','medical_supplies')) {
                    return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                }
                else{
                    return $this->langControl('forbidden');
                }
            }
        ),
        array(  'db' => 'id', 'dt'=>7)


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
        SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns ,"id_cat={$id} AND `lang`='{$this->langControl}'")
    );

}

    public function visible_medical_supplies($v_,$id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v=$v_;$id=$id_;
        } else {
            $v = 0;$id = 0;
        }
        $data = $this->db->update("medical_supplies",array('active'=>$v), "`id`={$id} AND `lang`='{$this->langControl}'");
    }


    function delete_medical_supplies($id)
    {
        if ($this->handleLogin()) {
            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            $response = $this->db->delete($this->table, "`id`={$id} AND `lang`='{$this->langControl}'");
        }
    }




    public function ch($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM medical_supplies WHERE `id` = ? AND `active` = 1 AND `lang`='{$this->langControl}'");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            return 'checked';
        }
        else
        {
            return '';
        }
    }


    public function select_category_medical_supplies($id)
    {
        $stmt=$this->db->prepare("SELECT * from  {$this->category} WHERE `relid`=? AND `lang`='{$this->langControl}'");
        $stmt->execute(array($id));
        return $stmt;
    }

    public function select_category_medical_supplies_public($id)
    {
        $stmt=$this->db->prepare("SELECT * from  {$this->category} WHERE `relid`=? AND `active`=1 AND `lang`='{$this->langControl}'");
        $stmt->execute(array($id));
        return $stmt;
    }

    public function ck_sub_cat($id)
    {
        $stmt=$this->db->prepare("SELECT * from  {$this->category} WHERE `relid`=? AND `lang`='{$this->langControl}'");
        $stmt->execute(array($id));
       if ($stmt->rowCount() > 0)
       {
           return true;
       }else
       {
           return false;
       }
    }

    public function listSubCategory($relid,$id=null)
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->category}` WHERE relid = ? AND `lang`='{$this->langControl}'");
        $stmt->execute(array($relid));
        while ($row = $stmt->fetch()) {
            require ($this->render($this->folder,'html','sub_cat','php'));
        }
    }


    public function sub_cat_active($r_id,$id=null)
    {
        if ($id==null)
        {
            return 'close_this_medical_supplies';
        }
        $stmt=$this->db->prepare("SELECT * from  `$this->category`  WHERE `id`=? AND `lang`='{$this->langControl}'");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            $result=$stmt->fetchAll();
            $result=$result[0];
            if ($r_id==$id || $result['relid'] == $r_id)
            {

                return 'medical_supplies';
            }
            else
            {
                return 'close_thismedical_supplies';
            }

        }
        else
        {
            return 'close_this_medical_supplies';
        }

    }


//-----------------category------------------


    function add_category($id=0)
    {
        $this->checkPermit('add_category','medical_supplies');
        if (!is_numeric($id)){  $error=new Errors();  $error ->index();}
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);
        $this->adminHeaderController($this->langControl('add_category'),$id);
        $data['title']='';
        $data['files']='';

        if (isset($_POST['submit']))
        {
            try{
                $form =new Form();
                $form  ->post('title')
                    ->val('is_empty',$this->langControl('the_title_field_is_empty'))
                    ->val('strip_tags');
                $form  ->post('files')
                    ->val('strip_tags');

                $form ->submit();
                $data =$form -> fetch();
                $data['relid']=$id;
                $data['lang']=$this->langControl;
                $data['userid']=$this->userid;
                $data['date']=time();
                $file=new Files();

                $this->db->insert($this->category,array_diff_key($data,['files'=>"delete"]));

                if(!empty($data['files'])) {
                    $img = $file->insert_file($this->folder.'_cat', $this->db->lastInsertId(), json_decode($data['files'], True));
                    $this->db->update($this->category, array('img' => $img), "id={$this->db->lastInsertId()}");
                }


                $this->lightRedirect(url.'/medical_supplies/admin_category',0);
            }

            catch (Exception $e)
            {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();
            }

        }



        require ($this->render($this->folder,'cat','add','php'));
        $this->adminFooterController();

    }





    function edit_category($id)
    {

        $this->checkPermit('edit_category','medical_supplies');
        $data=$this->db->select("SELECT * from {$this->category} WHERE `id`=:id AND `lang`='{$this->langControl}' LIMIT 1 ",array(':id'=>$id));
        $data=$data[0];
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);
        $this->adminHeaderController($data['title'],$id);
        $idImg=0;
        if ( $data['img'] !=0) {
            $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module AND `lang`='{$this->langControl}' LIMIT 1 ", array(':id' => $data['img'], ':module' => $this->folder.'_cat'));
            $get_file = $get_file[0];
            $idImg = $get_file['id'];
        }
        if (isset($_POST['submit']))
        {

            try
            {
                $form =new Form();
                $form ->post('title')
                    ->val('is_empty',$this->langControl('the_title_field_is_empty'))
                    ->val('strip_tags');
                $form ->post('files')
                    ->val('strip_tags');

                $form ->submit();
                $data =$form -> fetch();
                if (!empty($data['files']))
                {
//                    if ($idImg != 0)
//                    {
//                        @unlink($this->root_file.$get_file['rand_name']);
//                     }
                    $file=new Files();
                    $data['img']= $file->insert_file( $this->folder.'_cat',$id,json_decode($data['files'],True));
                }
                else
                {
                    $data['img']=$idImg;
                }
                if ($this->permit('save_edit_catg',$this->folder)) {
                    $this->db->update($this->category, array_diff_key($data, ['files' => "delete"]), "id={$id}");

                    $this->lightRedirect(url . '/medical_supplies/admin_category', 0);
                }
            }
            catch (Exception $e)
            {
                $this->error_form= $e -> getMessage();
            }
        }
        require ($this->render($this->folder,'cat','edit','php'));
        $this->adminFooterController();
    }


    public function visible($v_,$id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v=$v_;$id=$id_;
        } else {
            $v = 0;$id = 0;
        }
        $data = $this->db->update($this->category,array('active'=>$v), "`id`={$id}");
    }





    function delete($id)
    {
        if ($this->handleLogin()) {
            $response = $this->db->delete($this->category, "`id`={$id} AND `lang`='{$this->langControl}'");
        }
    }


    function delete_image_cat($id)
    {
        if ($this->handleLogin()) {
            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            $response = $this->db->update($this->category, array('img' => 0), "`id`={$id} AND `lang`='{$this->langControl}'");
        }
    }

    public function getAllBaseCategoriesByRelid($relid)
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->category}` WHERE  `relid` = 0  AND `active`=1 AND `lang`='{$this->langControl}' ORDER BY `id` ASC");
        $stmt->execute(array($relid));
        return $stmt->fetchAll();
    }

    public function geTitleCat($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->category}` WHERE  `id` = ?  AND `active`=1 AND `lang`='{$this->langControl}' limit 1");
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }





    function cart_order()
    {

        $data = json_decode($_GET['jsonData'], true);
        if(!$this->isDirect())
        {
            $data['id_member_r'] = $_SESSION['id_member_r'];
        }else{
            $data['id_member_r'] = $this->isUuid();
            $data['user_direct'] = $this->userid;
        }



            $char=['"',"'"];

            $data['id_item']=strip_tags(str_replace($char,'',$data['id_item']));
            $data['price']=strip_tags(str_replace($char,'',$data['price']));
            $data['image']=strip_tags(str_replace($char,'',$data['image']));
            $data['code']=strip_tags(str_replace($char,'',$data['code']));



            $data['number'] =  strip_tags(str_replace($char,'',$data['count']));;
            $data['date'] = time();

            unset($data['count']);

            $stmt_ch= $this->db->prepare("SELECT * from `{$this->table}` WHERE    `id`= ?    AND  `quantity` > 0  AND `quantity` <> 0  AND `quantity` <> '' ");
            $stmt_ch->execute(array($data['id_item']));
            if ($stmt_ch->rowCount() > 0) {

                $stmt_price = $this->db->prepare("SELECT *FROM  `{$this->table}`   WHERE  `id`=?  ");
                $stmt_price->execute(array($data['id_item']));
                $price_2D = $stmt_price->fetch(PDO::FETCH_ASSOC);

                $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `id_item` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?");
                $stmt_order->execute(array($data['id_item'], $this->table, $data['id_member_r']));
                $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                $q = $price_2D['quantity'] - $only_order['num'];

                if ($q >= $data['number']) {

                    $data['table'] = $this->table;
					$dollar=new Dollar_price();
					$data['dollar_exchange']=$dollar->dollar_get();
                    $this->db->insert($this->cart_shop_active, $data);


                    if ($this->isDirect())
                    {
                        $id=$this->isUuid();
                    }else{
                        $id= $_SESSION['id_member_r'];
                    }

                    $stmt = $this->getAllContentFromCar_new($id);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                        $stmt_get_item = $this->db->prepare("SELECT *FROM `{$row['table']}` WHERE id = ?  LIMIT 1");
                        $stmt_get_item->execute(array($row['id_item']));
                        $item = $stmt_get_item->fetch();
                        $row['title'] = $item['title'];

                        if ($row['table'] == 'medical_supplies') {

                            $stmt_id_catg_c = $this->db->prepare("SELECT `id_cat` FROM `medical_supplies` WHERE `id` = ?  LIMIT 1");
                            $stmt_id_catg_c->execute(array($row['id_item']));
                            $id_catgC=$stmt_id_catg_c->fetch(PDO::FETCH_ASSOC)['id_cat'];

                            $stmt_id_catg_title = $this->db->prepare("SELECT `title` FROM `category_medical_supplies` WHERE `id` = ?  LIMIT 1");
                            $stmt_id_catg_title->execute(array($id_catgC));

                            $row['title']=$stmt_id_catg_title->fetch(PDO::FETCH_ASSOC)['title'] .'  -  '. $item['title']  ;

                            $row['price']= $row['price']. ' د.ع ';
                            $row['color_name']='';
                        }

                        if ($row['table'] == 'mobile') {

                            $stmt_price = $this->db->prepare("SELECT  *FROM   `excel`  WHERE  `code`=?  ");
                            $stmt_price->execute(array($row['code']));
                            $result_price = $stmt_price->fetch(PDO::FETCH_ASSOC);

                            if (isset($_COOKIE['currency'])) {
                                if ($_COOKIE['currency'] == 0) {
                                         if ($this->loginUser() )
                                        {
                                            $row['price'] = $result_price['wholesale_price'] . ' د.ع ';
                                        }else
                                        {
                                            $row['price'] = $result_price['price'] . ' د.ع ';
                                        }

                                } else {
                                    $row['price'] = $result_price['price_dollars'] . '$ ';
                                }
                            } else {
                                     if ($this->loginUser() )
                                        {
                                            $row['price'] = $result_price['wholesale_price'] . ' د.ع ';
                                        }else
                                        {
                                            $row['price'] = $result_price['price'] . ' د.ع ';
                                        }

                            }


                        }


                        if ($row['table'] == 'camera') {

                            $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_camera`  WHERE  `code`=?  ");
                            $stmt_price->execute(array($row['code']));
                            $result_price = $stmt_price->fetch(PDO::FETCH_ASSOC);

                            if (isset($_COOKIE['currency'])) {
                                if ($_COOKIE['currency'] == 0) {
                                         if ($this->loginUser() )
                                        {
                                            $row['price'] = $result_price['wholesale_price'] . ' د.ع ';
                                        }else
                                        {
                                            $row['price'] = $result_price['price'] . ' د.ع ';
                                        }

                                } else {
                                    $row['price'] = $result_price['price_dollars'] . '$ ';
                                }
                            } else {
                                     if ($this->loginUser() )
                                        {
                                            $row['price'] = $result_price['wholesale_price'] . ' د.ع ';
                                        }else
                                        {
                                            $row['price'] = $result_price['price'] . ' د.ع ';
                                        }

                            }


                        }


                        if ($row['table'] == 'printing_supplies') {

                            $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_printing_supplies`  WHERE  `code`=?  ");
                            $stmt_price->execute(array($row['code']));
                            $result_price = $stmt_price->fetch(PDO::FETCH_ASSOC);

                            if (isset($_COOKIE['currency'])) {
                                if ($_COOKIE['currency'] == 0) {
                                         if ($this->loginUser() )
                                        {
                                            $row['price'] = $result_price['wholesale_price'] . ' د.ع ';
                                        }else
                                        {
                                            $row['price'] = $result_price['price'] . ' د.ع ';
                                        }

                                } else {
                                    $row['price'] = $result_price['price_dollars'] . '$ ';
                                }
                            } else {
                                     if ($this->loginUser() )
                                        {
                                            $row['price'] = $result_price['wholesale_price'] . ' د.ع ';
                                        }else
                                        {
                                            $row['price'] = $result_price['price'] . ' د.ع ';
                                        }

                            }


                        }

                        if ($row['table'] == 'computer') {

                            $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_computer`  WHERE  `code`=?  ");
                            $stmt_price->execute(array($row['code']));
                            $result_price = $stmt_price->fetch(PDO::FETCH_ASSOC);

                            if (isset($_COOKIE['currency'])) {
                                if ($_COOKIE['currency'] == 0) {
                                         if ($this->loginUser() )
                                        {
                                            $row['price'] = $result_price['wholesale_price'] . ' د.ع ';
                                        }else
                                        {
                                            $row['price'] = $result_price['price'] . ' د.ع ';
                                        }

                                } else {
                                    $row['price'] = $result_price['price_dollars'] . '$ ';
                                }
                            } else {
                                     if ($this->loginUser() )
                                        {
                                            $row['price'] = $result_price['wholesale_price'] . ' د.ع ';
                                        }else
                                        {
                                            $row['price'] = $result_price['price'] . ' د.ع ';
                                        }

                            }


                        }


                        if ($row['table'] == 'games') {

                            $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_games`  WHERE  `code`=?  ");
                            $stmt_price->execute(array($row['code']));
                            $result_price = $stmt_price->fetch(PDO::FETCH_ASSOC);

                            if (isset($_COOKIE['currency'])) {
                                if ($_COOKIE['currency'] == 0) {
                                         if ($this->loginUser() )
                                        {
                                            $row['price'] = $result_price['wholesale_price'] . ' د.ع ';
                                        }else
                                        {
                                            $row['price'] = $result_price['price'] . ' د.ع ';
                                        }

                                } else {
                                    $row['price'] = $result_price['price_dollars'] . '$ ';
                                }
                            } else {
                                     if ($this->loginUser() )
                                        {
                                            $row['price'] = $result_price['wholesale_price'] . ' د.ع ';
                                        }else
                                        {
                                            $row['price'] = $result_price['price'] . ' د.ع ';
                                        }

                            }


                        }


                        if ($row['table'] == 'network') {


                            $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_network`  WHERE  `code`=?  ");
                            $stmt_price->execute(array($row['code']));
                            $result_price = $stmt_price->fetch(PDO::FETCH_ASSOC);

                            if (isset($_COOKIE['currency'])) {
                                if ($_COOKIE['currency'] == 0) {
                                         if ($this->loginUser() )
                                        {
                                            $row['price'] = $result_price['wholesale_price'] . ' د.ع ';
                                        }else
                                        {
                                            $row['price'] = $result_price['price'] . ' د.ع ';
                                        }

                                } else {
                                    $row['price'] = $result_price['price_dollars'] . '$ ';
                                }
                            } else {
                                     if ($this->loginUser() )
                                        {
                                            $row['price'] = $result_price['wholesale_price'] . ' د.ع ';
                                        }else
                                        {
                                            $row['price'] = $result_price['price'] . ' د.ع ';
                                        }

                            }


                        }


                        if ($row['table'] == 'accessories') {

                            $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_accessories`  WHERE  `code`=?  ");
                            $stmt_price->execute(array($row['code']));
                            $result_price = $stmt_price->fetch(PDO::FETCH_ASSOC);

                            if (isset($_COOKIE['currency'])) {
                                if ($_COOKIE['currency'] == 0) {
                                         if ($this->loginUser() )
                                        {
                                            $row['price'] = $result_price['wholesale_price'] . ' د.ع ';
                                        }else
                                        {
                                            $row['price'] = $result_price['price'] . ' د.ع ';
                                        }

                                } else {
                                    $row['price'] = $result_price['price_dollars'] . '$ ';
                                }
                            } else {
                                     if ($this->loginUser() )
                                        {
                                            $row['price'] = $result_price['wholesale_price'] . ' د.ع ';
                                        }else
                                        {
                                            $row['price'] = $result_price['price'] . ' د.ع ';
                                        }

                            }

                        }



                        if ($row['table'] == 'product_savers') {

                            $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_savers`  WHERE  `code`=?  AND `color` = ? ");
                            $stmt_price->execute(array($row['code'], $row['name_color']));
                            $result_price = $stmt_price->fetch(PDO::FETCH_ASSOC);

                            if (isset($_COOKIE['currency'])) {
                                if ($_COOKIE['currency'] == 0) {
                                         if ($this->loginUser() )
                                        {
                                            $row['price'] = $result_price['wholesale_price'] . ' د.ع ';
                                        }else
                                        {
                                            $row['price'] = $result_price['price'] . ' د.ع ';
                                        }

                                } else {
                                    $row['price'] = $result_price['price_dollars'] . '$ ';
                                }
                            } else {
                                     if ($this->loginUser() )
                                        {
                                            $row['price'] = $result_price['wholesale_price'] . ' د.ع ';
                                        }else
                                        {
                                            $row['price'] = $result_price['price'] . ' د.ع ';
                                        }

                            }

                        }




                        $row['img'] = $this->save_file . $row['image'];
						$row['q_0']=$this->q_0($row['table'],$row['code'],$row['name_color']);
                        $car[] = $row;
                    }

                    require($this->render($this->folder, 'html', 'ajax', 'php'));
                }else
                {
                    echo 'finish';
                }

            }else
            {
                echo 'finish';
            }


    }



    function count_c()
    {
        if ($this->isDirect())
        {
            $id=$this->isUuid();
        }else{
            $id= $_SESSION['id_member_r'];
        }

        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`, `number`,`buy`,`date` FROM `{$this->cart_shop_active}` WHERE `id_member_r` =?  AND `buy` = 0 GROUP BY `offers`,`id_offer`,`date`  ORDER BY `id`  DESC  ");
        $stmt->execute(array($id));
            $car=array();
            $count=0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $count=$count+$row['number'];
            }

            echo $count;

    }

    public function getAllContentFromCar_new($id_member_r)
    {
        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date` FROM `{$this->cart_shop_active}` WHERE `id_member_r` =?  AND `buy` = 0 GROUP BY `id_item`,`size`,`table`,`price`,`name_color` ORDER BY `id`  DESC  ");
        $stmt->execute(array($id_member_r));
        return $stmt;
    }


    public function getCategory()
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->category}` WHERE   `active`=1 ");
        $stmt->execute();
        if ($stmt->rowCount() > 0)
        {
            return true;
        }else
        {
            return false;
        }

    }




}