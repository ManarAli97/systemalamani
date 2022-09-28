<?php

class Pages extends Controller
{



    function __construct()
    {
        parent::__construct();
        $this->table='pages';
        $this->category='category_pages';
        $this->menu=new Menu();

    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
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
          `content` longtext COLLATE utf8_unicode_ci NOT NULL,
          `img` int(10) NOT NULL,
          `relid` int (10) NOT NULL,
          `active` int(10) NOT NULL DEFAULT '0', `lang` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
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
        $this->checkPermit('View_category','pages');
        $this->adminHeaderController($this->langControl('pages'),$id);
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);
        $data=$this->db->select("SELECT * from  {$this->category} WHERE  `relid` = {$id}  AND `lang`='{$this->langControl}' ");
      foreach ($data as $key => $dt)
      {

          $data[$key]['checked']= ($dt['active']==1) ? 'checked' : null ;
          if ($dt['img'] !=0) {
              $data[$key]['img'] = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module   AND `lang`='{$this->langControl}' LIMIT 1 ", array(':id' => $dt['img'], ':module' => $this->folder.'_cat'));
              $data[$key]['image'] = $this->save_file.$data[$key]['img'][0]['rand_name'];
              $data[$key]['type_file'] = $data[$key]['img'][0]['file_type'];
              unset($data[$key]['img']);
          } else
              {
                  $data[$key]['image']="http://placehold.jp/20/cccccc/0000/252x252.png?text={$dt['title']}";
//                  $data[$key]['image']=$this->static_file_control.'/image/admin/default.png';
              }


      }
        require ($this->render($this->folder,'html','admin_category','php'));
        $this->adminFooterController();

    }


    public function list_pages($id=null)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('view_pages','pages');
        $this->adminHeaderController($this->langControl('view_pages'),$id);
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);
        $data_cat=$this->db->select("SELECT * from  {$this->category} WHERE  `lang`='{$this->langControl}'");
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


    public function view_list()
    {
        $stmt=$this->db->prepare("SELECT * from  {$this->table} WHERE `active` = 1  AND `lang`='{$this->langControl}'");
           $stmt->execute();
           $pages=array();
           while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {

                if ($row['img'] !=0) {
                    $get_file= $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module  AND `lang`='{$this->langControl}' LIMIT 1 ", array(':id' => $row['img'], ':module' => $this->folder));
                   if ($get_file)
                   {
                           $get_file=$get_file[0];
                           $row['image'] = $this->save_file.$get_file['rand_name'];
                           $row['type_file'] =$get_file['file_type'];
                   }else
                   {
                       $row['type_file'] ='no-file';
                       $row['image']=$this->static_file_control.'/image/admin/default.png';

                   }


                }
                else
                {
                    $row['type_file'] ='no-file';
                    $row['image']=$this->static_file_control.'/image/admin/default.png';
                }

            $pages[]=  $row;
           }

        require ($this->render($this->folder,'html','view_list','php'));


    }


    public function visible_pages($v_,$id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v=$v_;$id=$id_;
        } else {
            $v = 0;$id = 0;
        }
        $data = $this->db->update("pages",array('active'=>$v), "`id`={$id}  AND `lang`='{$this->langControl}'");
    }


    function delete_pages($id)
    {
        if ($this->handleLogin()) {
            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            $response = $this->db->delete('pages', "`id`={$id}");
         }
    }




    public function ch($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM pages WHERE `id` = ? AND `active` = 1  AND `lang`='{$this->langControl}' ");
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


    public function select_category_pages($id)
    {
        $stmt=$this->db->prepare("SELECT * from  {$this->category} WHERE `relid`=?  AND `active`=1   AND `lang`='{$this->langControl}'");
        $stmt->execute(array($id));
        return $stmt;
    }


    public function select_category_pages_public($id)
    {
        $stmt=$this->db->prepare("SELECT * from  {$this->category} WHERE `relid`=? AND `active`=1 AND `lang`='{$this->langControl}'");
        $stmt->execute(array($id));
        return $stmt;
    }

    public function ck_sub_cat($id)
    {
        $stmt=$this->db->prepare("SELECT * from  {$this->category} WHERE `relid`=?  AND `lang`='{$this->langControl}'");
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
        $stmt = $this->db->prepare("SELECT * FROM `{$this->category}` WHERE relid = ?  AND `lang`='{$this->langControl}'");
        $stmt->execute(array($relid));
        while ($row = $stmt->fetch()) {
            require ($this->render($this->folder,'html','sub_cat','php'));
        }
    }


    public function sub_cat_active($r_id,$id=null)
    {
        if ($id==null)
        {
            return 'close_this_pages';
        }
        $stmt=$this->db->prepare("SELECT * from  `$this->category`  WHERE `id`=?  AND `lang`='{$this->langControl}'");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            $result=$stmt->fetchAll();
            $result=$result[0];
            if ($r_id==$id || $result['relid'] == $r_id)
            {

                return 'pages';
            }
            else
            {
                return 'close_thispages';
            }

        }
        else
        {
            return 'close_this_pages';
        }

    }







    public  function details($id)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}

        $stmt=$this->db->prepare("SELECT *FROM `{$this->category}` WHERE  `id` = ? AND `lang`='{$this->langControl}'");
        $stmt->execute(array($id));
        $result=$stmt->fetchAll()[0];

        if ($result['img'] != 0 )
        {

            $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module AND `lang`='{$this->langControl}' LIMIT 1 ", array(':id' => $result['img'], ':module' => $this->folder.'_cat'));
            $get_file = $get_file[0];
             $file  = $this->save_file.$get_file['rand_name'];
        }



        require ($this->render($this->folder,'html','details','php'));
    }





//-----------------category------------------


    function add_category($id=0)
    {
        $this->checkPermit('add_category','pages');
        if (!is_numeric($id)){  $error=new Errors();  $error ->index();}
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);
        $this->adminHeaderController($this->langControl('add_category'),$id);
        $data['title']='';
        $data['files']='';
        $data['content']='';

        if (isset($_POST['submit']))
        {
            try{
                $form =new Form();
                $form  ->post('title')
                    ->val('is_empty',$this->langControl('the_title_field_is_empty'))
                    ->val('strip_tags');
                $form  ->post('content')
                    ->val('strip_tags',TAG);
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


                $this->lightRedirect(url.'/pages/admin_category',0);
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





    function edit_category($id)
    {

        $this->checkPermit('edit_category','pages');
        $data=$this->db->select("SELECT * from {$this->category} WHERE `id`=:id  AND `lang`='{$this->langControl}' LIMIT 1 ",array(':id'=>$id));
        $data=$data[0];
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);
        $this->adminHeaderController($data['title'],$id);
        $idImg=0;
        if ( $data['img'] !=0) {
            $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module  AND `lang`='{$this->langControl}' LIMIT 1 ", array(':id' => $data['img'], ':module' => $this->folder.'_cat'));
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
                $form  ->post('content')
                    ->val('strip_tags',TAG);
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

                    $this->lightRedirect(url . '/pages/admin_category', 0);
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
        if (is_numeric($v_) && is_numeric($id_)) {
            $v=$v_;$id=$id_;
        } else {
            $v = 0;$id = 0;
        }
        $data = $this->db->update($this->category,array('active'=>$v), "`id`={$id}  AND `lang`='{$this->langControl}'");
    }





    function delete($id)
    {
        if ($this->handleLogin()) {
            $response = $this->db->delete($this->category, "`id`={$id}  AND `lang`='{$this->langControl}'");
         }
    }


    function delete_image_cat($id)
    {
        if ($this->handleLogin()) {
            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            $response = $this->db->update($this->category, array('img' => 0), "`id`={$id}  AND `lang`='{$this->langControl}'");
         }
    }

    public function getAllBaseCategoriesByRelid($relid)
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->category}` WHERE  `relid` = 0 AND `active`=1  AND `lang`='{$this->langControl}' ORDER BY `id` ASC");
        $stmt->execute(array($relid));
        return $stmt->fetchAll();
    }


    public function getAllpagesFromContent($id_cat = array(), $limit)
    {
        $Id_cat = implode(',', $id_cat);
        $stmt = $this->db->query("SELECT * FROM `{$this->table}` WHERE  `id_cat` IN ({$Id_cat})   AND `active` = 1  AND `lang`='{$this->langControl}' ORDER BY `id` DESC LIMIT $limit");
        return $stmt;
    }





}