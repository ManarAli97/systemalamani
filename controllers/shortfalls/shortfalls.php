<?php

class shortfalls extends Controller
{



    function __construct()
    {
        parent::__construct();
        $this->table='shortfalls';
    }

    public function createTB()
    {


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `img` int(10) NOT NULL,
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





    public function list_shortfalls()
    {
        $this->checkPermit('list_shortfalls','shortfalls');
        $this->adminHeaderController($this->langControl('shortfalls'));

        require ($this->render($this->folder,'html','list_offers','php'));
        $this->adminFooterController();

    }





    public function processing()
    {

    $table = $this->table;
    $primaryKey =  $table.'.id';

    $columns = array(
        array(  'db' =>  $table.'.id', 'dt'=>0),

        array( 'db' => $table.'.title', 'dt' => 1 ),
        array( 'db' =>  $table.'.model', 'dt' => 2,
        'formatter' => function($model) {
            return $this->langSite($model) ;
         }),
        array( 'db' =>  $table.'.code', 'dt' => 3 ),

        array( 'db' =>$table.'.img', 'dt' =>4 ,
            'formatter' => function($d,$row) {
                return $this->image($d,$row[2],$row[3]);
             }
            ),
        array( 'db' => 'user.username', 'dt' => 5 ),
        array( 'db' =>  $table.'.date', 'dt' =>  6 ,
            'formatter' => function( $d, $row ) {
                return date( 'Y-m-d h:i:s a', $d);
             }
            ),
        array(
            'db'        =>  $table.'.id',
            'dt'        => 7,
            'formatter' => function($id, $row ) {
                if ($this->permit('delete','shortfalls')) {
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
        array(  'db' =>  $table.'.id', 'dt'=>8)


    );

// SQL server connection information
    $sql_details = array(
        'user' => DB_USER,
        'pass' => DB_PASS,
        'db'   => DB_NAME,
        'host' => DB_HOST,
        'charset' => 'utf8'
    );


        $join = " inner JOIN user ON user.id = {$table}.userid";
        $whereAll = array("");

        echo json_encode(

        SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));

}

    function image($id,$model,$code)
    {
        $image = array();
        $stmt = $this->db->prepare("SELECT * from `files` WHERE `id`= ?  AND `module`=? ");
        $stmt->execute(array($id,$this->folder));
        if ($stmt->rowCount() > 0)
        {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
             $img = $this->save_file.$result['rand_name'];
            return '<img style="width: 120px; height:140px" src="'.$img.'">';
        }
        else
        {
            if($model == 'mobile' || $model == 'computer' || $model == 'games'){
                $image = $this->selectItemByCode($model,$code);
                if(count($image) > 0){
                    $img = $this->save_file.$image[0]['img'];
                    return '<img style="width: 120px; height:140px" src="'.$img.'">';
                }
                else{
                    return '<img style="width: 120px; height:140px" src="'.$this->save_file.'no_image.png">';
                }
            }
            if($model == 'accessories'){
                $image = $this->selectAccByCode($code,$code);
                if(!empty($image)){
                    $img = $this->save_file.$image[0]['img'];
                    return '<img style="width: 120px; height:140px" src="'.$img.'">';
                }
                else{
                    return '<img style="width: 120px; height:140px" src="'.$this->save_file.'no_image.png">';
                }
            }
            if($model == 'savers'){
                $image = $this->selectSaversByCode($code);
                if(count($image) > 0){
                    $img = $this->save_file.$image[0]['img'];
                    return '<img style="width: 120px; height:140px" src="'.$img.'">';
                }
                else{
                    return '<img style="width: 120px; height:140px" src="'.$this->save_file.'no_image.png">';
                }
            }

            // return '<img style="width: 150px" src="'.$this->save_file.'no_image.png">';

        }

    }


    public function visible_shortfalls($v_,$id_)
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


    function delete_shortfalls($id)
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
        $this->checkPermit('add','shortfalls');
        $this->adminHeaderController($this->langControl('add'));


        require ($this->render($this->folder,'html','add','php'));
        $this->adminFooterController();

    }



    function form_add()
    {
        if ($this->handleLogin()) {


            $data['title'] = '';
            $data['code'] = '';
            $data['files'] = '';

            if (isset($_POST['submit'])) {
                try {
                    $form = new Form();

                    $form->post('category')
                    ->val('strip_tags');

                    $form->post('title')
                        ->val('strip_tags', TAG);

                    $form->post('code')
                        ->val('strip_tags');


                    $form->post('files')
                        ->val('strip_tags');


                    $form->submit();
                    $data = $form->fetch();
                    $file = new Files();

                    $data['lang'] = $this->langControl;
                    $data['userId'] = $this->userid;
                    $data['date'] = time();



                    if ( $data['title'] ||   $data['code'] || $data['files'] || $data['category'])
                    {

                        // $this->db->insert($this->table, array_diff_key($data, ['files' => "delete"]));




                        if($data['category'] == 'mobile' || $data['category'] == 'computer' || $data['category']== 'games'){

                            $items = $this->selectItemByCode($data['category'], $data['code'],$data['title']);
                            if(count($items) > 0){
                                foreach ($items as $item) {
                                    $stmt_insert= $this->db->prepare("INSERT INTO `$this->table`(`title`, `code`, `model`,`userId` ,`date`) VALUES (?,?,?,?,?)");
                                    $stmt_insert->execute(array($item['title'],$item['code'],$data['category'],$this->userid,time()));
                                }
                            }else{
                                $stmt_insert= $this->db->prepare("INSERT INTO `$this->table`(`title`, `code`, `model`,`userId` ,`date`) VALUES (?,?,?,?,?)");
                                $stmt_insert->execute(array($data['title'],$data['code'],$data['category'],$this->userid,time()));

                            }

                            if (!empty($data['files'])) {
                                $img = $file->insert_file($this->folder, $this->db->lastInsertId(), json_decode($data['files'], True));
                                $this->db->update($this->table, array('img' => $img), "id={$this->db->lastInsertId()}");
                            }
                        }
                        if($data['category'] == 'savers'){
                            $items = $this->selectSaversByCode($data['code'],$data['title']);
                            if(count($items) > 0){
                                foreach ($items as $item) {
                                    $stmt_insert= $this->db->prepare("INSERT INTO `$this->table`(`title`, `code`, `model`,`userId` ,`date`) VALUES (?,?,?,?,?)");
                                    $stmt_insert->execute(array($item['title'],$item['code'],$data['category'],$this->userid,time()));
                                }
                            }else{
                                $stmt_insert= $this->db->prepare("INSERT INTO `$this->table`(`title`, `code`, `model`,`userId` ,`date`) VALUES (?,?,?,?,?)");
                                $stmt_insert->execute(array($data['title'],$data['code'],$data['category'],$this->userid,time()));

                            }

                            if (!empty($data['files'])) {
                                $img = $file->insert_file($this->folder, $this->db->lastInsertId(), json_decode($data['files'], True));
                                $this->db->update($this->table, array('img' => $img), "id={$this->db->lastInsertId()}");
                            }

                        }
                        if($data['category'] == 'accessories'){
                            $items = $this->selectAccByCode($data['code'],$data['title']);
                            if(count($items) > 0){
                                foreach ($items as $item) {
                                    $stmt_insert= $this->db->prepare("INSERT INTO `$this->table`(`title`, `code`, `model`,`userId` ,`date`) VALUES (?,?,?,?,?)");
                                    $stmt_insert->execute(array($item['title'],$item['code'],$data['category'],$this->userid,time()));
                                }
                            }else{
                                $stmt_insert= $this->db->prepare("INSERT INTO `$this->table`(`title`, `code`, `model`,`userId` ,`date`) VALUES (?,?,?,?,?)");
                                $stmt_insert->execute(array($data['title'],$data['code'],$data['category'],$this->userid,time()));

                            }

                            if (!empty($data['files'])) {
                                $img = $file->insert_file($this->folder, $this->db->lastInsertId(), json_decode($data['files'], True));
                                $this->db->update($this->table, array('img' => $img), "id={$this->db->lastInsertId()}");
                            }
                        }

                        echo 'true';
                    }else
                    {

                        echo 'false';
                    }

                }catch (Exception $e) {
                    $data = $form->fetch();
                    $this->error_form = $e->getMessage();
                }

            }
        }
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



                $form  ->post('link')
                    ->val('strip_tags');

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
                { if ($this->permit('save_edit',$this->folder)) {
                    $this->db->update($this->table, array_diff_key($data, ['files' => "delete"]), "id={$id}");
                    $this->lightRedirect(url . '/' . $this->folder . '/list_shortfalls', 0);
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

    public function getAllshortfalls()
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE   `active`=1 ORDER BY `id` DESC LIMIT 5");
        $stmt->execute();
        return $stmt->fetchAll();
    }



    public  function view_shortfalls($page=1)
   {
    if ( !is_numeric($page)  ) {$error=new Errors(); $error->index();}


        $stmt=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE  `active` = ?  AND `lang`='{$this->langControl}'  order by `id` DESC ");
        $stmt->execute(array(1));


    $shortfalls=array();
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
        $shortfalls[]=$row;
    }

    if (!empty($shortfalls))
    {
        $shortfalls=array_chunk($shortfalls,8);
        $count=count($shortfalls);
        $shortfalls=$shortfalls[$page-1];
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




        $stmt_shortfalls=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE `active` = ? AND `id` <> ? ORDER BY `id`DESC LIMIT 15");
        $stmt_shortfalls->execute(array(1,$result['id']));
        $shortfalls_content =array();

        while ($row = $stmt_shortfalls ->fetch(PDO::FETCH_ASSOC)   )
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

            $shortfalls_content[]=$row;
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



    public function selectItemByCode($model,$barcode,$title='')
    {
        if($model=='mobile'){
            $color = 'color';
            $code = 'code';
        } else{
            $color = 'color_'. $model;
            $code = 'code_'. $model;
        }
        $item = array();
        $stmt_code = $this->db->prepare("SELECT `id`,`code`,`id_color` FROM `$code` WHERE `is_delete` = 0 AND  AND (`code`=? OR `code`=?)");
        $stmt_code->execute(array($barcode,$title));
        if($stmt_code->rowCount() > 0){
            while ($row = $stmt_code->fetch(PDO::FETCH_ASSOC))
            {
                $id_color = $row['id_color'];
                $row['code'] = $row['code'];
                $stmt_color = $this->db->prepare("SELECT `img` , `id_item` FROM `$color` WHERE `is_delete` = 0 AND  `id`=?  limit 1");
                $stmt_color->execute(array($id_color));
                while ($row_color = $stmt_color->fetch(PDO::FETCH_ASSOC))
                {
                    $row['img'] = $row_color['img'];
                    $id_item = $row_color['id_item'];
                }
                $stmt_item = $this->db->prepare("SELECT `title` FROM `$model` WHERE `is_delete` = 0 AND `id`=?   limit 1");
                $stmt_item->execute(array($id_item));
                while ($row_item = $stmt_item->fetch(PDO::FETCH_ASSOC))
                {
                    $row['title'] = $row_item['title'];
                }
          
                $item[]=$row;
            }
        }
       return $item;
    }

    // get data by code from tables(product_savers)
    public function selectSaversByCode($barcode,$title =''){
        $item = array();
        $model = 'product_savers';
        $stmt_items = $this->db->prepare("SELECT  `code`,`title` , `img` FROM `$model` WHERE `is_delete` = 0  AND (`code`=? OR `code`=?)");
        $stmt_items->execute(array($barcode,$title));
        if($stmt_items->rowCount() > 0){
            while ($row = $stmt_items->fetch(PDO::FETCH_ASSOC))
            {
                $item[]=$row;
            }
        }
       return $item;
    }

    // get data by code from tables(accessories)
    public function selectAccByCode($barcode,$title =' '){
         $item = array();
    
       	$stmt_color = $this->db->prepare("SELECT accessories.id, accessories.title,color_accessories.id_item,color_accessories.code,color_accessories.img  FROM `accessories` inner join color_accessories on color_accessories.id_item=accessories.id WHERE   `color_accessories`.`code`=? OR `color_accessories`.`code`=? limit 1");
        $stmt_color->execute(array($barcode,$title));
        if($stmt_color->rowCount() > 0){
        	$item[] = $stmt_color->fetch(PDO::FETCH_ASSOC);   
        }
    	 return $item;
    }



}