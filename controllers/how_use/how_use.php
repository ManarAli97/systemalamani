<?php

class how_use extends Controller
{



    function __construct()
    {
        parent::__construct();
        $this->table='how_use';
        $this->menu=new Menu();
    }

    public function createTB()
    {


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `content` text COLLATE utf8_unicode_ci NOT NULL,
           `img` int(10) NOT NULL,
           `active` int(10) NOT NULL DEFAULT '0',
           `view` bigint(20) NOT NULL DEFAULT '0',
           `lang` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return  $this->db->cht(array($this->table));

    }

    public function index(){ $index =new Index(); $index->index();}


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

    public function  visible_special($v_,$id_)
    {

        if ($this->handleLogin()) {

            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }
            if ($v==0)
            {
                $data = $this->db->update($this->table, array('sort' => NULL), "`id`={$id}");
            }
            else
            {
                $stmt = $this->db->prepare("SELECT * FROM $this->table  WHERE  `sort` IS NOT NULL  ORDER BY `sort` DESC LIMIT 1");
                $stmt->execute();
                if ($stmt->rowCount() > 0)
                {
                    $result=$stmt->fetch(PDO::FETCH_ASSOC);
                    $data = $this->db->update($this->table, array('sort' => $result['sort']+1), "`id`={$id}");
                }else
                {
                    $data = $this->db->update($this->table, array('sort' => 1), "`id`={$id}");
                }
            }
            $data = $this->db->update($this->table, array('special_active' => $v), "`id`={$id}");
            echo 'true';
        }
    }





    public function list_how_use()
    {
        $this->checkPermit('list_how_use','how_use');
        $this->adminHeaderController($this->langControl('how_use'));

        require ($this->render($this->folder,'html','list','php'));
        $this->adminFooterController();

    }





    public function processing()
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
        array( 'db' => 'view', 'dt' => 2 ),
        array(
            'db'        => 'id',
            'dt'        => 3,
            'formatter' => function($id, $row ) {
                if ($this->permit('visible','how_use')) {
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
            'dt'        => 4,
            'formatter' => function($id, $row ) {
                if ($this->permit('edit','how_use')) {
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
            'dt'        => 5,
            'formatter' => function($id, $row ) {
                if ($this->permit('delete','how_use')) {
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
        SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )
    );

}

    public function visible_how_use($v_,$id_)
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


    function delete_how_use($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->table, "`id`={$id}");
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




    function add()
    {
        $this->checkPermit('add','how_use');
        $this->adminHeaderController($this->langControl('add'));

        $data['title']='';
        $data['content']='';
        $data['files']='';

        if (isset($_POST['submit']))
        {
            try{
                $form =new Form();
                $form  ->post('title')
                    ->val('is_empty','مطلوب')
                    ->val('strip_tags',TAG);

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


                $this->lightRedirect(url.'/'.$this->folder.'/list_how_use',0);
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
        $this->checkPermit('edit_category','categories');
        $data=$this->db->select("SELECT * from {$this->table} WHERE `id`=:id LIMIT 1 ",array(':id'=>$id));
        $data=$data[0];

        $this->adminHeaderController($data['title'],$id);
        $idImg=0;
        if ( $data['img'] !=0) {
            $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $data['img'], ':module' => $this->folder));
            $get_file = $get_file[0];
            $idImg = $get_file['id'];
        }
        if (isset($_POST['submit']))
        {

            try
            {
                $form =new Form();
                $form  ->post('title')
                    ->val('is_empty','مطلوب')
                    ->val('strip_tags',TAG);

                $form  ->post('content')
                    ->val('strip_tags',TAG);

                $form  ->post('files')
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
                    $data['img']= $file->insert_file( $this->folder,$id,json_decode($data['files'],True));
                }
                else
                {
                    $data['img']=$idImg;
                }

                if ($data['img'] !==0)
                {if ($this->permit('save_edit',$this->folder)) {
                    $this->db->update($this->table, array_diff_key($data, ['files' => "delete"]), "id={$id}");
                    $this->lightRedirect(url . '/' . $this->folder . '/list_how_use', 0);
                }
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

    public function getAllhow_use()
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE   `active`=1 ORDER BY `id` DESC LIMIT 5");
        $stmt->execute();
        return $stmt->fetchAll();
    }



    public  function view_how_use($page=1)
   {
    if ( !is_numeric($page)  ) {$error=new Errors(); $error->index();}


        $stmt=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE  `active` = ?  AND `lang`='{$this->langControl}'  order by `id` DESC ");
        $stmt->execute(array(1));


    $how_use=array();
    while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
    {
        if ($row['img'] != 0 ) {
            $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module AND `lang`='{$this->langControl}' LIMIT 1 ", array(':id' => $row['img'], ':module' => $this->folder));
            $get_file = $get_file[0];
            $row['image']=$this->save_file . $get_file['rand_name'];
        }else
        {
            $row['image']="http://placehold.jp/20/cccccc/0000/252x252.png?text={$row['title']}";;
        }
        $how_use[]=$row;
    }

    if (!empty($how_use))
    {
        $how_use=array_chunk($how_use,8);
        $count=count($how_use);
        $how_use=$how_use[$page-1];
    }

    require ($this->render($this->folder,'html','view_list','php'));
}



    public  function details()
    {

        $stmt=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE `active`=1   ");
        $stmt->execute();
        $result=array();


        while ($row =  $stmt->fetch(PDO::FETCH_ASSOC))
        {
            if ($row['img'] != 0) {

                $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module AND `lang`='{$this->langControl}' LIMIT 1 ", array(':id' => $row['img'], ':module' => $this->folder));
                $get_file = $get_file[0];
                $row['video'] = $this->save_file . $get_file['rand_name'];

            } else {
                $row['video'] = 'no-file';
            }

            $stmt2 = $this->db->prepare("UPDATE `{$this->table}` SET view = view+1 WHERE id = ?");
            $stmt2->execute(array($row['id']));
            $result[]=$row;
        }






        require ($this->render($this->folder,'html','details','php'));

}

}