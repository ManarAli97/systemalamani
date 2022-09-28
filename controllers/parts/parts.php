<?php

class Parts extends Controller
{



    function __construct()
    {
        parent::__construct();
        $this->table='parts';
        $this->category='category_parts';

    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `price` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
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

    public function index(){ $index =new Index(); $index->index();}




      public function admin_category($id=0)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('View_category','parts');
        $this->adminHeaderController($this->langControl('parts'),$id);
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


    public function list_parts($id=null)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('view_parts','parts');
        $this->adminHeaderController($this->langControl('view_parts'),$id);
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


    public function view_list($id='',$p=1)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $stmt_parts=$this->getCategoryparts_not_Get_this_id($id);
        $cat_parts=array();

        $result=$this->geTitleCat($id);


        while ($row = $stmt_parts->fetch(PDO::FETCH_ASSOC))
        {
            $stmt_v=$this->getpartsByCatId($row['id']);
            $row['parts']=array();
            while ($row_content = $stmt_v->fetch(PDO::FETCH_ASSOC))
            {
                if ( $row_content['img'] !=0) {
                    $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row_content['img'], ':module' => 'parts'));
                    $get_file = $get_file[0];

                    if ($get_file['file_type']=='image')
                    {
                        if (file_exists($this->root_file.'thump_'.$get_file['rand_name']))
                        {
                            $row_content['img'] = $this->save_file.'thump_'.$get_file['rand_name'];
                        }else
                        {
                            $row_content['img'] = $this->save_file.$get_file['rand_name'];
                        }
                    }else{
                        $row_content['img'] =$this->static_file_control.'/image/admin/video.jpg';
                    }

                }else
                {
                    $row_content['img']=$this->static_file_control.'/image/admin/default.png';
                }
                $row_content['date']=date('Y-m-d',$row_content['date']);
                $row['parts'][]=$row_content;
            }
            $row['parts']=array_chunk($row['parts'],3);
            $cat_parts []=$row;
        }


        $page=$p;
        $count=0;
        $data=$this->db->select("SELECT * from `{$this->table}` WHERE `id_cat`=:id_cat AND `lang`='{$this->langControl}'  ORDER BY `date` DESC ",array('id_cat'=>$id));

        $arr_c=array_chunk($data,8);
        $count=count($arr_c);



        $sidebar=new Sidebar();


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
                $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $dt['img'], ':module' => 'parts'));
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




    function  getCategoryparts()
    {
        $stmt=$this->db->prepare("SELECT *FROM {$this->category} WHERE `active` = 1");
        $stmt->execute();
        return $stmt;
    }


    function  getCategoryparts_not_Get_this_id($id)
    {
        $stmt=$this->db->prepare("SELECT *FROM {$this->category} WHERE `active` = 1 AND `id`  <> ?");
        $stmt->execute(array($id));
        return $stmt;
    }

    function  getpartsByCatId($id)
    {
        $stmt=$this->db->prepare("SELECT *FROM {$this->table} WHERE `active` = 1 and `id_cat` = ?");
        $stmt->execute(array($id));
        return $stmt;
    }


    function  get_new_parts()
    {
        $stmt=$this->db->prepare("SELECT *FROM {$this->table} WHERE `active` = 1  order by `date` DESC ");
        $stmt->execute();
        return $stmt;
    }


    public  function details($id)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}

        $stmt=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE  `id` = ? AND `lang`='{$this->langControl}'");
        $stmt->execute(array($id));
        $result=$stmt->fetchAll()[0];

        if (empty($result))
        {
            $error=new Errors(); $error->index();
        }


        $file=null;
        $related_infogr=array();
        if ($result['img'] != 0 )
        {

            $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module AND `lang`='{$this->langControl}' LIMIT 1 ", array(':id' => $result['img'], ':module' => $this->folder));
            $get_file = $get_file[0];
            $file  = $this->save_file.$get_file['rand_name'];
            $file_type=$get_file['file_type'];
        }else
        {
            $file_type='no-file';
        }

        $get_file = $this->db->select("SELECT * from `files` WHERE `relid`=:relid AND `module`=:module AND `lang`='{$this->langControl}'", array(':relid' => $id, ':module' => $this->folder));
        if (!empty($get_file))
        {
            foreach ($get_file as  $gf)
            {
                if ($gf['id']==$result['img'])
                {
                    continue;
                }
                $gf['file']= $this->save_file.$gf['rand_name'];;
                $related_infogr[]= $gf;
            }

        }

        $stmt=$this->db->prepare("SELECT *FROM `{$this->category}`  WHERE `active` = 1 AND `lang`='{$this->langControl}'");
        $stmt->execute();
        $category=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row['id'];
        }


        $last_parts=array();

        if (!empty($category)) {
            $stmt_parts = $this->getAllInfogContentLimit($category, 8);
            while ($row_parts= $stmt_parts->fetch(PDO::FETCH_ASSOC)) {

                    if ($row_parts['img'] !=0) {
                        $get_file= $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module AND `lang`='{$this->langControl}' LIMIT 1 ", array(':id' => $row_parts['img'], ':module' => $this->folder));
                        if ($get_file)
                        {
                            $get_file=$get_file[0];
                            $row_parts['image'] = $this->save_file.$get_file['rand_name'];
                            $row_parts['type_file'] =$get_file['file_type'];
                        }else
                        {
                            $row_parts['type_file'] ='no-file';
                            $row_parts['image']=$this->static_file_control.'/image/admin/default.png';
                        }
                    }
                    else
                    {
                        $row_parts['type_file'] ='no-file';
                        $row_parts['image']=$this->static_file_control.'/image/admin/default.png';
                    }
                $last_parts[] = $row_parts;
            }

        }

        $stmt = $this->db->prepare("UPDATE `{$this->table}` SET view = view+1 WHERE id = ?");
        $stmt->execute(array($id));

        $sidebar=new Sidebar();


            $stmt_v=$this->get_new_parts();
               $new_parts=array();
            while ($row_content = $stmt_v->fetch(PDO::FETCH_ASSOC))
            {
                if ( $row_content['img'] !=0) {
                    $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row_content['img'], ':module' => 'parts'));
                    $get_file = $get_file[0];

                    if ($get_file['file_type']=='image')
                    {
                        if (file_exists($this->root_file.'thump_'.$get_file['rand_name']))
                        {
                            $row_content['img'] = $this->save_file.'thump_'.$get_file['rand_name'];
                        }else
                        {
                            $row_content['img'] = $this->save_file.$get_file['rand_name'];
                        }
                    }else{
                        $row_content['img'] =$this->static_file_control.'/image/admin/video.jpg';
                    }

                }else
                {
                    $row_content['img']=$this->static_file_control.'/image/admin/default.png';
                }
                $row_content['date']=date('Y-m-d',$row_content['date']);
                $new_parts[]=$row_content;
            }
            $new_parts_chunk=array_chunk($new_parts,4);




        require ($this->render($this->folder,'html','details','php'));
    }


    public function getAllInfogContentLimit($id_cat = array(), $limit)
    {
        $Id_cat = implode(',', $id_cat);
        $stmt = $this->db->query("SELECT * FROM `{$this->table}` WHERE  `id_cat` IN ({$Id_cat})   AND `active` = 1  AND `lang`='{$this->langControl}'  ORDER BY `id` DESC LIMIT $limit");
        return $stmt;
    }





    public function add_parts($id=null)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('Add_parts','parts');
        $this->adminHeaderController($this->langControl('Add_parts'),$id);
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
        $data['price']='';
        $data['content']='';
        $data['files']='';
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

                $form  ->post('content')
                       ->val('is_empty',$this->langControl('required'))
                       ->val('strip_tags',TAG);

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
                $file=new Files();


                  $this->db->insert($this->table,array_diff_key($data,['files'=>"delete"]));
                  $img=$file->insert_file($this->folder,$this->db->lastInsertId(),json_decode($data['files'],True));
                  $this->db->update($this->table,array('img'=>$img),"id={$this->db->lastInsertId()}");
                  $this->lightRedirect(url."/parts/list_parts/{$id}",0);


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


    public function edit_parts($id)
    {
        $this->checkPermit('Edit_parts','parts');
        if (!is_numeric($id)) {
            die(':)');
        }

        $files =new Files();
        $this->adminHeaderController($this->langControl('edit'));

        $data=$this->db->select("SELECT * from `parts` WHERE `id`=:id AND `lang`='{$this->langControl}' LIMIT 1 ",array(':id'=>$id));
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

                $form  ->post('content')
                        ->val('is_empty',$this->langControl('required'))
                        ->val('strip_tags',TAG);

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
               $this->lightRedirect(url."/parts/list_parts/{$data['id_cat']}",0);


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
        array( 'db' => 'date', 'dt' =>  1 ,
            'formatter' => function( $d, $row ) {
                return date( 'Y-m-d ', $d);
            }

            ),
        array(
            'db' => 'id',
            'dt' => 2,
            'formatter' => function ($id, $row) {
                if ($this->permit('visible','parts')) {
                    return "
                <div style='text-align: center'>
                  <input {$this->ch($id)} class='toggle-demo' onchange='visible_parts(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                }
                else
                {
                    return $this->langControl('forbidden');
                }
            }
        ),
        array( 'db' => 'view', 'dt' => 3 ),
        array(
            'db' => 'id',
            'dt' => 4,
            'formatter' => function ($id, $row) {
                if ($this->permit('edit','parts')) {
                    return "
                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/parts/edit_parts/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
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
            'dt' => 5,
            'formatter' => function ($id, $row) {
                if ($this->permit('edit','parts')) {
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
        array(  'db' => 'id', 'dt'=>6)


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

    public function visible_parts($v_,$id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v=$v_;$id=$id_;
        } else {
            $v = 0;$id = 0;
        }
        $data = $this->db->update("parts",array('active'=>$v), "`id`={$id} AND `lang`='{$this->langControl}'");
    }


    function delete_parts($id)
    {
        if ($this->handleLogin()) {
            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            $response = $this->db->delete($this->table, "`id`={$id} AND `lang`='{$this->langControl}'");
        }
    }




    public function ch($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM parts WHERE `id` = ? AND `active` = 1 AND `lang`='{$this->langControl}'");
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


    public function select_category_parts($id)
    {
        $stmt=$this->db->prepare("SELECT * from  {$this->category} WHERE `relid`=? AND `lang`='{$this->langControl}'");
        $stmt->execute(array($id));
        return $stmt;
    }

    public function select_category_parts_public($id)
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
            return 'close_this_parts';
        }
        $stmt=$this->db->prepare("SELECT * from  `$this->category`  WHERE `id`=? AND `lang`='{$this->langControl}'");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            $result=$stmt->fetchAll();
            $result=$result[0];
            if ($r_id==$id || $result['relid'] == $r_id)
            {

                return 'parts';
            }
            else
            {
                return 'close_thisparts';
            }

        }
        else
        {
            return 'close_this_parts';
        }

    }


//-----------------category------------------


    function add_category($id=0)
    {
        $this->checkPermit('add_category','parts');
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


                $this->lightRedirect(url.'/parts/admin_category',0);
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

        $this->checkPermit('edit_category','parts');
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

                    $this->lightRedirect(url . '/parts/admin_category', 0);
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


    public function getAllpartsFromContent($id_cat = array(), $limit)
    {
        $Id_cat = implode(',', $id_cat);
        $stmt = $this->db->query("SELECT * FROM `{$this->table}` WHERE  `id_cat` IN ({$Id_cat})   AND `active` = 1 AND `lang`='{$this->langControl}' ORDER BY `date` DESC LIMIT $limit");
        return $stmt;
    }


    public function getAllpartsFromContent_with_price($id_cat = array(), $limit)
    {
        $Id_cat = implode(',', $id_cat);
        $stmt = $this->db->query("SELECT * FROM `{$this->table}` WHERE  `id_cat` IN ({$Id_cat})   AND `active` = 1 AND  `price` <> ''  AND  `lang`='{$this->langControl}' ORDER BY `date` ASC LIMIT $limit");
        return $stmt;
    }






}