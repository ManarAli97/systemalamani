<?php

class check_accessories extends Controller
{

    protected $list_serial='';

    function __construct()
    {
        parent::__construct();
        $this->table='check_accessories';
    }

    public function createTB()
    {


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
          `number_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `serial` varchar(250) COLLATE utf8_unicode_ci NOT NULL, 
          `serial_text` varchar(250) COLLATE utf8_unicode_ci NOT NULL, 
           `active` int(10) NOT NULL DEFAULT '0',
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





    public function list_check_accessories()
    {
        $this->checkPermit('list_check_accessories','check_accessories');
        $this->adminHeaderController($this->langControl('check_accessories'));

        require ($this->render($this->folder,'html','list_offers','php'));
        $this->adminFooterController();

    }





    public function processing()
    {

    $table = $this->table;
    $primaryKey =  $table.'.id';

    $columns = array(

        array( 'db' => $table.'.number_bill', 'dt' => 0 ),

        array( 'db' =>   'cart_shop_active.number_bill', 'dt' =>  1 ,
            'formatter' => function( $d, $row ) {

            $serial=$this->serial_bill($d);
            $this->list_serial=$serial;
            return  $serial;
            }
        ),

        array( 'db' => $table.'.serial', 'dt' => 2 ),
        array( 'db' =>  $table.'.serial', 'dt' =>  3,
            'formatter' => function( $d, $row ) {

            if (in_array($d,explode(',',$this->list_serial)))
            {
                return "<span style='color: green;font-size: 30px;font-weight: bold;'>√</span>";
            }else
            {
                return "<span  style='color: red;font-size: 24px;font-weight: bold'>Χ</span>";
            }

         }

        ),
        array( 'db' =>  'user.username', 'dt' =>  4),
        array( 'db' =>  $table.'.date', 'dt' =>  5 ,
            'formatter' => function( $d, $row ) {
                return date( 'Y-m-d h:i:s a', $d);
             }
            ),
        array(
            'db'        =>  $table.'.id',
            'dt'        => 6,
            'formatter' => function($id, $row ) {
                if ($this->permit('delete','check_accessories')) {
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
        array(  'db' =>  $table.'.id', 'dt'=>7)


    );

// SQL server connection information
    $sql_details = array(
        'user' => DB_USER,
        'pass' => DB_PASS,
        'db'   => DB_NAME,
        'host' => DB_HOST,
        'charset' => 'utf8'
    );


        $join = " inner JOIN user ON user.id = {$table}.userid   LEFT JOIN cart_shop_active ON cart_shop_active.number_bill={$table}.number_bill";
        $whereAll = array("");

        $g="GROUP BY {$table}.number_bill,$table.serial";

        echo json_encode(

        SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$g,1));

}

    function serial_bill($bill)
    {
        $list_serial=array();
        $stmt = $this->db->prepare("SELECT  enter_serial   FROM `cart_shop_active` WHERE `number_bill` =? AND enter_serial <> ''");
        $stmt->execute(array($bill));
        if ($stmt->rowCount() > 0 )
        {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $list_serial[] = $row['enter_serial'];

            }
        }

     return   $html_list= implode(',',$list_serial);

    }


    public function visible_check_accessories($v_,$id_)
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


    function delete_check_accessories($id)
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




    function employee()
    {
        $this->checkPermit('add','check_accessories');
        $this->adminHeaderController($this->langControl('add'));


        require ($this->render($this->folder,'html','add','php'));
        $this->adminFooterController();

    }



    function form_add()
    {
        if ($this->handleLogin()) {


            $data['number_bill'] = '';
            $data['serial'] = '';


            if (isset($_POST['submit'])) {
                try {
                    $form = new Form();
                    $form->post('number_bill')
                        ->val('is_empty','مطلوب')
                        ->val('strip_tags', TAG);

                    $form->post('serial')
                        ->val('is_empty','مطلوب')
                        ->val('strip_tags');

                    $form->submit();
                    $data = $form->fetch();


                       $serial=explode(',',$data['serial']);
                       foreach ($serial as $list_serial)
                       {

                           $stmt= $this->db->prepare("INSERT INTO  check_accessories  ( number_bill, serial, serial_text,userId, `date`) VALUES(?,?,?,?,?)");
                           $stmt->execute(array($data['number_bill'],$list_serial,$data['serial'],$this->userid,time()));
                       }

                        echo 'true';


                } catch (Exception $e) {
                    $data = $form->fetch();
                    $this->error_form = $e->getMessage();
                }

            }
        }
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

    public function getAllcheck_accessories()
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE   `active`=1 ORDER BY `id` DESC LIMIT 5");
        $stmt->execute();
        return $stmt->fetchAll();
    }



    public  function view_check_accessories($page=1)
   {
    if ( !is_numeric($page)  ) {$error=new Errors(); $error->index();}


        $stmt=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE  `active` = ?  AND `lang`='{$this->langControl}'  order by `id` DESC ");
        $stmt->execute(array(1));


    $check_accessories=array();
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
        $check_accessories[]=$row;
    }

    if (!empty($check_accessories))
    {
        $check_accessories=array_chunk($check_accessories,8);
        $count=count($check_accessories);
        $check_accessories=$check_accessories[$page-1];
    }

    require ($this->render($this->folder,'html','view_list','php'));
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

        if ($result['img'] != 0 )
        {

            $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module AND `lang`='{$this->langControl}' LIMIT 1 ", array(':id' => $result['img'], ':module' => $this->folder));
            $get_file = $get_file[0];
            $result['image']  = $this->save_file.$get_file['rand_name'];

        }else
        {
            $result['image']='no-file';
        }




        $stmt_check_accessories=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE `active` = ? AND `id` <> ? ORDER BY `id`DESC LIMIT 15");
        $stmt_check_accessories->execute(array(1,$result['id']));
        $check_accessories_content =array();

        while ($row = $stmt_check_accessories ->fetch(PDO::FETCH_ASSOC)   )
        {
            if ( $row['img'] !=0) {
                $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row['img'], ':module' => $this->folder));
                $get_file = $get_file[0];
                if (file_exists($this->root_file.'thump_'.$get_file['rand_name']))
                {
                    $row['image'] = $this->save_file.'thump_'.$get_file['rand_name'];
                }else
                {
                    $row['image'] = $this->save_file.$get_file['rand_name'];
                }
            }else
            {
                $row['image']=$this->static_file_control.'/image/admin/default.png';
            }

            $check_accessories_content[]=$row;
        }



        require ($this->render($this->folder,'html','details','php'));
    }


    function delete_all()
    {
        if ($this->handleLogin()) {
            $this->checkPermit('delete_all', $this->folder);
            $stmt = $this->db->prepare("TRUNCATE TABLE `{$this->table}` ");
            $stmt->execute();
            echo 1;
        }
    }


}