<?php

class alamani_art extends Controller
{

    function __construct()
    {
        parent::__construct();
        $this->table='alamani_art';
        $this->category='category_alamani_art';
        $this->menu=new Menu();
        $this->setting=new  Setting();
    }

    public function createTB()
    {


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `content` longtext COLLATE utf8_unicode_ci NOT NULL,
           `img` int(10) NOT NULL,
           `id_cat` int(10) NOT NULL,
           `active` int(10) NOT NULL DEFAULT '0',
           `lang` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `userId` int(11) NOT NULL ,
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



        return  $this->db->cht(array($this->table));

    }




//-----------------category------------------





    public function admin_category($id=0)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('View_category',$this->folder);
        $this->adminHeaderController($this->langControl($this->folder),$id);
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
        require ($this->render($this->folder,'cat','admin_category','php'));
        $this->adminFooterController();

    }



    function add_category($id=0)
    {
        $this->checkPermit('add_category',$this->folder);
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


                $this->lightRedirect(url.'/'.$this->folder.'/admin_category',0);
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

        $this->checkPermit('edit_category',$this->folder);
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

                    $this->lightRedirect(url.'/'.$this->folder.'/admin_category', 0);
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


    public function visible_c($v_,$id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v=$v_;$id=$id_;
        } else {
            $v = 0;$id = 0;
        }
        $data = $this->db->update($this->category,array('active'=>$v), "`id`={$id}");
    }





    function delete_c($id)
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





    public function index($id=0){

        $stmt=$this->db->prepare("SELECT *FROM `$this->category` WHERE `active` = 1 ");
        $stmt->execute();
        $category=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row;
        }


        $stmt=$this->getAllalamani_art($id);
        $dataalamani_art=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

            $stmt_file = $this->db->prepare("SELECT * from `files` WHERE `relid`=? AND `module`=?  LIMIT 1 ");
            $stmt_file->execute(array($row['id'], 'alamani_art'));

            $row['image']= $this->save_file. 'thump_'.$stmt_file->fetch(PDO::FETCH_ASSOC)['rand_name'];

            $dataalamani_art[]=$row;
        }


        require ($this->render($this->folder,'html','index','php'));

    }


    public function details($id){

        $stmt=$this->db->prepare("SELECT *FROM `$this->category` WHERE `active` = 1 ");
        $stmt->execute();
        $category=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row;
        }

        $stmtr = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE  id=?  AND  `active`=1  ");
        $stmtr->execute(array($id));

        $result=$stmtr->fetch(PDO::FETCH_ASSOC);

            $fileStmt = $this->db->prepare("SELECT rand_name FROM  files WHERE `relid` = ? AND module = 'alamani_art'   "); //will return all images except the primary image (squared).
            $fileStmt->execute(array($result['id']));
            $images = array();
            while ($list_img = $fileStmt->fetch(PDO::FETCH_ASSOC)) {
                $list_img['url'] = $this->save_file . $list_img['rand_name'];
                $images[] = $list_img;
            }

        require ($this->render($this->folder,'html','details','php'));

    }

    public function ch_special($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE `id` = ? AND `special_active` = 1 ");
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





    public function note()
    {
        $this->checkPermit('add_note','alamani_art');

        $note=strip_tags($_POST['alamani_art'],TAG);
        $stmt= $this->setting->set('alamani_art',$note);

        if ($stmt)
        {
            echo 'true';
        }
    }



    public function list_alamani_art($id)
    {
        $this->checkPermit('list_alamani_art','alamani_art');
        $this->adminHeaderController($this->langControl('alamani_art'));

        $breadcumbs = $this ->Breadcumbs( $this->category,$id);


        require ($this->render($this->folder,'html','list_offers','php'));
        $this->adminFooterController();

    }




    public function processing($id)
    {

    $table = $this->table;
    $primaryKey = 'id';

    $columns = array(

        array( 'db' => 'title', 'dt' => 0 ),

        array( 'db' => 'date', 'dt' =>  1 ,
            'formatter' => function( $d, $row ) {
                return date( 'Y-m-d ', $d);
             }
            ),
        array(
            'db'        => 'id',
            'dt'        => 2,
            'formatter' => function($id, $row ) {
                if ($this->permit('visible','alamani_art')) {
                    return "
                <div style='text-align: center'>
                  <input {$this->ch($id)} class='toggle-demo' onchange='visible_news(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                }
                else
                {
                    return "لا تمتلك صلاحية";
                }
            }
        ),

        array(
            'db'        => 'id',
            'dt'        => 3,
            'formatter' => function($id, $row ) {
                if ($this->permit('edit','alamani_art')) {
                    return "
                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/" . $this->folder . "/edit/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }else
                {
                    return "لا تمتلك صلاحية";
                }
            }
        ),
        array(
            'db'        => 'id',
            'dt'        => 4,
            'formatter' => function($id, $row ) {
                if ($this->permit('delete','alamani_art')) {
                    return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                }
                else
                {
                    return "لا تمتلك صلاحية";
                }
            }
        ),
        array(  'db' => 'id', 'dt'=>5)


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
        SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns ,"id_cat={$id}")
    );

}

    public function visible_alamani_art($v_,$id_)
    {
        if ($this->handleLogin()) {

            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }
            $data = $this->db->update($this->table, array('active' => $v), "`id`={$id}");
             echo 'true';
        }
    }


    function delete_alamani_art($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->table, "`id`={$id}");
            $response = $this->db->delete('files', "`relid`={$id} AND `module`='{$this->folder}_cat'", 1);
              echo 'true';
        }
    }




    public function ch($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE `id` = ? AND `active` = 1 ");
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




    function add($id)
    {

        $this->checkPermit('add','alamani_art');
        $this->adminHeaderController($this->langControl('add'));

        $breadcumbs = $this ->Breadcumbs( $this->category,$id);

        $stmt=$this->db->prepare("SELECT *FROM `$this->category` ");
        $stmt->execute();
        $category=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row;
        }

        $data['title']='';
        $data['content']='';
        $data['files']='';

        if (isset($_POST['submit']))
        {
            try{
                $form =new Form();
                $form  ->post('title')
                    ->val('is_empty','مطلوب')
                    ->val('strip_tags');


                $form  ->post('id_cat')
                    ->val('is_empty','مطلوب')
                    ->val('strip_tags');


                $form  ->post('content')
                    ->val('strip_tags',TAG);

                $form  ->post('files')
                    ->val('is_empty','مطلوب')
                    ->val('strip_tags');


                $form ->submit();
                $data =$form -> fetch();
                $file=new Files();

                $data['lang']=$this->langControl;
                $data['userId']=$this->userid;
                $data['date']=time();
                $this->db->insert($this->table,array_diff_key($data,['files'=>"delete"]));

                if(!empty($data['files'])) {
                    $img = $file->insert_file($this->folder, $this->db->lastInsertId(), json_decode($data['files'], True));
                    $this->db->update($this->table, array('img' => $img), "id={$this->db->lastInsertId()}");
                }


                $this->lightRedirect(url.'/'.$this->folder.'/list_alamani_art/'.$id,0);
            }

            catch (Exception $e)
            {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();
            }

        }



        require ($this->render($this->folder,'html','add','php'));
        $this->adminFooterController();

    }





    function edit($id)
    {

        if (!is_numeric($id)) { $error = new Errors(); $error->index();}
        $this->checkPermit('edit','alamani_art');
        $data=$this->db->select("SELECT * from {$this->table} WHERE `id`=:id LIMIT 1 ",array(':id'=>$id));
        $data=$data[0];

        $this->adminHeaderController($data['title'],$id);
        $breadcumbs = $this ->Breadcumbs( $this->category,$data['id_cat']);

        $stmt=$this->db->prepare("SELECT *FROM `$this->category` ");
        $stmt->execute();
        $category=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row;
        }

        $idImg=0;
        $get_image=array();
        $get_image=$this->db->select("SELECT * from `files` WHERE `relid`=:relid AND `module`=:module",array(':relid'=>$id,':module'=>$this->folder));
        if(!empty($get_image))
        {
            $data['file_type'] = $get_image[0]['file_type'];
            foreach ($get_image as $key => $set_file) {
                $get_image[$key] = $set_file;
            }
        }

        if (isset($_POST['submit']))
        {

            try
            {
                $form =new Form();
                $form  ->post('title')
                    ->val('is_empty','مطلوب')
                    ->val('strip_tags');

                $form  ->post('id_cat')
                    ->val('is_empty','مطلوب')
                    ->val('strip_tags');


                $form  ->post('content')
                    ->val('strip_tags',TAG);

                $form  ->post('files')
                    ->val('strip_tags');

                $form ->submit();
                $data =$form -> fetch();



                $files=new  Files();
                if (!empty($data['files'])) {

                    $files->insert_file($this->folder, $id, json_decode($data['files'], True));
                }


                if(!empty($get_image))
                {
                    $this->db->update($this->table,array_diff_key($data,['files'=>"delete"]),"id={$id}");
                    $this->lightRedirect(url.'/'.$this->folder.'/list_alamani_art/'.$data['id_cat'],0);
                }else
                {
                    $this->error_form = json_encode(array('img'=>$this->langControl('please_upload_image')),JSON_FORCE_OBJECT);
                }

            }
            catch (Exception $e)
            {
                $this->error_form= $e -> getMessage();
            }
        }
        require ($this->render($this->folder,'html','edit','php'));
        $this->adminFooterController();
    }


    public function visible($v_,$id_)
    {
        if ($this->handleLogin() )
        {

            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }
            $data = $this->db->update($this->table, array('active' => $v), "`id`={$id}");
            echo 'true';
        }
    }



    function delete($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->table, "`id`={$id}");
            echo 'true';
        }
    }


    function delete_image($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->update($this->table,array('img'=>0),"`id`={$id}");
         echo 'true';
        }
    }

    public function getAllalamani_art($id)
    {
        if ($id==0)
        {
            $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE   `active`=1 ORDER BY `id` DESC ");
            $stmt->execute();
        }else{
            $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE `id_cat`=? AND  `active`=1 ORDER BY `id` DESC ");
            $stmt->execute(array($id));
        }

        return $stmt;
    }














}