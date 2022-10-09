<?php
class User extends Controller
{
   function __construct()
   {
    parent::__construct();
    $this->table='user';
    $this->group='usergroup';

    }


    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
           `id` int(11) NOT NULL AUTO_INCREMENT,
          `username` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `password` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `idGroup` int(11) NOT NULL,
          `lang` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
          `userid` int(11) NOT NULL,
          `direct` int(11) NOT NULL DEFAULT 0,
          `money_box` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `role` enum('admin','owner') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'owner',
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->group}` (
           `id` int(11) NOT NULL AUTO_INCREMENT,
           `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `img` bigint(20) NOT NULL DEFAULT '0',
           `active` int(11) NOT NULL DEFAULT '0',
            `lang` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
           `userid` bigint(20) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");




        return $this->db->cht(array($this->table,$this->group));


    }





    public function group()
    {

        $this ->checkPermit ('group_user','user');
        $this->adminHeaderController($this->langControl('group_user'));
        $data = $this->db->select("SELECT * from  {$this->group} WHERE  `lang`='{$this->langControl}'");
        foreach ($data as $key => $dt)
        {
            $data[$key]['checked']= ($dt['active']==1) ? 'checked' : null ;
            if ($dt['img'] !=0) {
                $data[$key]['img'] = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module  AND `lang`='{$this->langControl}' LIMIT 1 ", array(':id' => $dt['img'], ':module' => $this->group));
                $data[$key]['image'] =$this->save_file.$data[$key]['img'][0]['rand_name'];
                $data[$key]['type_file'] = $data[$key]['img'][0]['file_type'];
                unset($data[$key]['img']);
            }else
            {
                $data[$key]['image']=$this->static_file_control.'/image/admin/groupuser.png';
            }

        }

        require($this->render($this->folder, 'html', 'group', 'php'));
        $this->adminFooterController();
    }

    public function add_group()
    {
        $this->adminHeaderController($this->langControl('add_group'));
        $this ->checkPermit ('add_group','user');

        $data['name']='';
        $data['files']='';

        if (isset($_POST['submit']))
        {
            try{
                $form =new Form();
                $form  ->post('name')
                    ->val('is_empty',$this->langControl('the_title_field_is_empty'))
                    ->val('strip_tags');
                $form  ->post('files')
                    ->val('strip_tags');

                $form ->submit();
                $data =$form -> fetch();
                $data['lang']=$this->langControl;
                $data['userid']=$this->userid;
                $file=new Files();

                $this->db->insert($this->group,array_diff_key($data,['files'=>"delete"]));
                if(!empty($data['files']))
                  {
                $img= $file->insert_file($this->group,$this->db->lastInsertId(),json_decode($data['files'],True));
                $this->db->update($this->group,array('img'=>$img),"id={$this->db->lastInsertId()}");
                  }
                $this->lightRedirect(url.'/user/group',0);
            }

            catch (Exception $e)
            {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();
            }

        }



        require ($this->render($this->folder,'html/group','add','php'));
        $this->adminFooterController();
    }



    public function edit_group($id)
    {
        $this ->checkPermit ('edit_group','user');
        $data=$this->db->select("SELECT * from `{$this->group}` WHERE `id`=:id  AND `lang`='{$this->langControl}' LIMIT 1 ",array(':id'=>$id));
        $data=$data[0];
        $this->adminHeaderController($data['name']);
          $idImg=0;
       if ( $data['img'] !=0){
        $get_file=$this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module  AND `lang`='{$this->langControl}' LIMIT 1 ",array(':id'=>$data['img'],':module'=>$this->group));
        $get_file=$get_file[0];
         $idImg=$get_file['id'];
        }
        if (isset($_POST['submit']))
        {

            try
            {
                $form =new Form();
                $form ->post('name')
                    ->val('is_empty',$this->langControl('the_title_field_is_empty'))
                    ->val('strip_tags');
                $form ->post('files')
                    ->val('strip_tags');
                $form ->submit();
                $data =$form -> fetch();
                if (!empty($data['files']))
                {
                    if ($idImg != 0)
                    {
                        @unlink($this->root_file.$get_file['rand_name']);
                        $this->db->delete('files',"id={$get_file['id']}");
                    }
                    $file=new Files();
                    $data['img']= $file->insert_file( "$this->group",$id,json_decode($data['files'],True));
                }
                else
                {
                    $data['img']=$idImg;
                }
                $this->db->update( "`{$this->group}`",array_diff_key($data,['files'=>"delete"]),"id={$id}");

           $this->lightRedirect( url.'/user/group',0);
            }
            catch (Exception $e)
            {
                $this->error_form=$e -> getMessage();
            }
        }
        require ($this->render($this->folder,'html/group','edit','php'));
        $this->adminFooterController();
    }





    public  function list_user($id=null)
    {

        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this ->checkPermit ('list_user','user');
        $data = $this->db->select("SELECT * from  `{$this->group}` WHERE `id`=:id  AND `lang`='{$this->langControl}'",array(':id'=>$id));
        $this->adminHeaderController($data[0]['name']);


        require($this->render($this->folder, 'html', 'list_user', 'php'));
        $this->adminFooterController();

    }



    public  function add($id=null)
    {

        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this ->checkPermit ('list_user','user');
        $data = $this->db->select("SELECT * from  `{$this->group}` WHERE `id`=:id  AND `lang`='{$this->langControl}'",array(':id'=>$id));
        $this->adminHeaderController($data[0]['name']);



        $sales_man=false;
        $stmt_sales_man =$this->db->prepare("SELECT *FROM `usergroup` WHERE  `id`=? AND  ( `name` LIKE '%مبيعات%' OR `name` LIKE '%مبيع%')  ");
        $stmt_sales_man->execute(array($id));
        if ($stmt_sales_man->rowCount() > 0)
        {
            $sales_man=true;
        }

        $purchases_man=false;
        $stmt_purchases_man=$this->db->prepare("SELECT *FROM `usergroup` WHERE  `id`=? AND    (`name` LIKE '%مشتري%' OR `name` LIKE '%مشتريات%' )  ");
        $stmt_purchases_man->execute(array($id));
        if ($stmt_purchases_man->rowCount() > 0)
        {
            $purchases_man=true;
        }

        $delegate_man=false;
        $stmt_delegate_man=$this->db->prepare("SELECT *FROM `usergroup` WHERE  `id`=? AND  (`name` LIKE '%مندوبين%' OR `name` LIKE '%مندوب%')   ");
        $stmt_delegate_man->execute(array($id));
        if ($stmt_delegate_man->rowCount() > 0)
        {
            $delegate_man=true;
        }

        $preparation=false;
        $stmt_preparation=$this->db->prepare("SELECT *FROM `usergroup` WHERE  `id`=? AND  (`name` LIKE '%تجهيز%' OR `name` LIKE '%التجهيزات%')   ");
        $stmt_preparation->execute(array($id));
        if ($stmt_preparation->rowCount() > 0)
        {
            $preparation=true;
        }

        $direct=false;
        $stmt_direct=$this->db->prepare("SELECT *FROM `usergroup` WHERE  `id`=? AND  (`name` LIKE '%مباشر%' OR `name` LIKE '%مباشرين%' OR `name` LIKE '%ثانويين%')   ");
        $stmt_direct->execute(array($id));
        if ($stmt_direct->rowCount() > 0)
        {
            $direct=true;
        }


        $region=array();
        $stmt=$this->db->prepare("SELECT *FROM `region` WHERE `active`=1 ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $region[]=$row;
        }


        $print_devices=array();
        $stmt=$this->db->prepare("SELECT *FROM `print_devices`  ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $print_devices[]=$row;
        }


        $data['username']='';
        $data['password']='';
        $data['number']='';
        $data['location_out_pull']=0;
        $data['number_copy']=1;
        if (isset($_POST['submit']))
        {
            try {
                $form = new  Form();
                $form->post('username')
                    ->val('is_empty', $this->langControl('the_username_field_is_empty'))
                    ->val('strip_tags');
                $form->post('password')
                    ->val('is_empty', $this->langControl('the_password_field_is_empty'))
                    ->val('strip_tags');

                $form->post('role')
                    ->val('is_empty', $this->langControl('select_role_user'))
                    ->val('strip_tags');

                $form->post('number')
                    ->val('strip_tags');

                $form->post('print')
                    ->val('strip_tags');

                $form->post('number_copy')
                    ->val('strip_tags');


				$form->post('csrf')
					->val('strip_tags');



				$form->post('money_box')
                    ->val('strip_tags');


                $form->post('shortfalls')
                    ->val('is_array')
                    ->val('strip_tags');


                $form->post('check_accessories')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('location_out_pull')
                    ->val('strip_tags');

				$form->post('smart_prepared')
                    ->val('strip_tags');

                $form->post('price_type')
                    ->val('is_array')
                    ->val('strip_tags');


//                if ($sales_man  ||  $purchases_man || $delegate_man || $preparation || $direct) {
                    $form->post('category')
                        ->val('is_array')
                        ->val('strip_tags');


                if ($delegate_man) {
                    $form->post('region')
                        ->val('is_array', 'منطقة التسوق مطلوب')
                        ->val('strip_tags');
                }

                if ($direct) {
                    $form->post('direct')
                        ->val('is_empty', 'اختر فئة الادمن')
                        ->val('strip_tags');
                }


                $form ->submit();
                $data =$form -> fetch();

				if ($this->CSRFTchecked($data['csrf'])) {


                    $data['hash']=$this->hash_user();
                    $data['uuid']=$data['password'].'_'.$this->uuid(4);


					$data['lang'] = $this->langControl;
					$data['userid'] = $this->userid;
					$data['idGroup'] = $id;
					$data['money_box'] = (int)str_replace(',', '', $data['money_box']);
					if (!empty($data['category'])  ) {
						$list_catg = json_decode($data['category'], true);
					}

					if (!empty($data['region']) && $delegate_man) {
						$list_region = json_decode($data['region'], true);
					}

					if (!empty($data['price_type'])) {
                        $data['price_type'] = implode(',',json_decode($data['price_type'], true));
					}else
                    {
                        $data['price_type']='';
                    }

					if (!empty($data['shortfalls'])) {
                        $data['shortfalls'] = implode(',',json_decode($data['shortfalls'], true));
					}else
                    {
                        $data['shortfalls']='';
                    }
					if (!empty($data['check_accessories'])) {
                        $data['check_accessories'] = implode(',',json_decode($data['check_accessories'], true));
					}else
                    {
                        $data['check_accessories']='';
                    }

					$userCk = $this->db->select("SELECT * from  {$this->table} WHERE `username`=:username  AND `lang`='{$this->langControl}' LIMIT 1 ", array(':username' => $data['username']));
					if (count($userCk) > 0) {
						$this->error_form = array('username' => $this->langControl('username_not available'));
					} else {

						$data['password'] = $this->HASH_key('sha256', $data['password'] . $data['username'], HASH_PASSWORD_KEY);
						$this->db->insert($this->table, array_diff_key($data, ['category' => "delete", 'region' => "delete", 'csrf' => "delete"]));
						$lsat_id = $this->db->lastInsertId();

						if (!empty($data['category'])  ) {
							foreach ($list_catg as $key => $save_data) {
								$stmt_c = $this->db->prepare("INSERT INTO `user_purchases_catg` (`id_user`,`catg`,`date`) VALUE (?,?,?)");
								$stmt_c->execute(array($lsat_id, $save_data, time()));
							}
						}

						if (!empty($data['region']) && $delegate_man) {
							foreach ($list_region as $key => $save_region) {
								$stmt_c = $this->db->prepare("INSERT INTO `user_purchases_region` (`id_user`,`id_region`,`date`) VALUE (?,?,?)");
								$stmt_c->execute(array($lsat_id, $save_region, time()));
							}
						}

						$this->lightRedirect(url . '/' . $this->folder . "/list_user/{$id}", 0);

					}
				}

            }

            catch (Exception $e)
            {
                $data =$form -> fetch();
                $this->error_form= json_decode($e -> getMessage(),true);
            }
        }



        require($this->render($this->folder, 'html', 'add', 'php'));
        $this->adminFooterController();

    }


    public function edit($id=null)
    {

        if (!is_numeric($id)) { $error=new Errors(); $error->index();}

        $this ->checkPermit ('edit_user','user');
        $this->adminHeaderController($this->langControl('edit'));
        $stmt=$this->db->select("SELECT * from `user` WHERE `id`=:id  AND `lang`='{$this->langControl}' LIMIT 1 ",array(':id'=>$id));
         $result=$stmt[0];

         if (empty($result['money_box']))
         {
             $result['money_box']=0;
         }



        $sales_man=false;
        $stmt_sales_man =$this->db->prepare("SELECT *FROM `usergroup` WHERE  `id`=? AND  ( `name` LIKE '%مبيعات%' OR `name` LIKE '%مبيع%')  ");
        $stmt_sales_man->execute(array($result['idGroup']));
        if ($stmt_sales_man->rowCount() > 0)
        {
            $sales_man=true;
        }

        $purchases_man=false;
        $stmt_purchases_man=$this->db->prepare("SELECT *FROM `usergroup` WHERE  `id`=? AND    (`name` LIKE '%مشتري%' OR `name` LIKE '%مشتريات%' )  ");
        $stmt_purchases_man->execute(array($result['idGroup']));
        if ($stmt_purchases_man->rowCount() > 0)
        {
            $purchases_man=true;
        }

        $categ=array();
        $stmt_cat = $this->db->prepare("SELECT *FROM `user_purchases_catg`  WHERE `id_user`=? ");
        $stmt_cat->execute(array($id));

        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC))
        {
            $categ[]=$row['catg'];

        }


        $region_id=array();
        $stmt_reg = $this->db->prepare("SELECT *FROM `user_purchases_region`  WHERE `id_user`=? ");
        $stmt_reg->execute(array($id));
        while ($rowg = $stmt_reg->fetch(PDO::FETCH_ASSOC))
        {
            $region_id[]=$rowg['id_region'];

        }


        $delegate_man=false;
        $stmt_delegate_man=$this->db->prepare("SELECT *FROM `usergroup` WHERE  `id`=? AND  (`name` LIKE '%مندوبين%' OR `name` LIKE '%مندوب%')   ");
        $stmt_delegate_man->execute(array($result['idGroup']));
        if ($stmt_delegate_man->rowCount() > 0)
        {
            $delegate_man=true;
        }


        $preparation=false;
        $stmt_preparation=$this->db->prepare("SELECT *FROM `usergroup` WHERE  `id`=? AND  (`name` LIKE '%تجهيز%' OR `name` LIKE '%التجهيزات%')   ");
        $stmt_preparation->execute(array($result['idGroup']));
        if ($stmt_preparation->rowCount() > 0)
        {
            $preparation=true;
        }


        $region=array();
        $stmt=$this->db->prepare("SELECT *FROM `region` WHERE `active`=1 ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $region[]=$row;
        }


        $print_devices=array();
        $stmt=$this->db->prepare("SELECT *FROM `print_devices`  ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $print_devices[]=$row;
        }



        $group = $this->db->select("SELECT * from  `{$this->group}` WHERE  `lang`='{$this->langControl}'");
        foreach ($group as $key => $d_cat)
        {

            if ($d_cat['id']  == $result['idGroup'])
            {
                $d_cat['selected']='selected';

            }else
            {
                $d_cat['selected']=null;
            }
            $group[$key]=$d_cat;
        }
        $direct=false;
        $stmt_direct=$this->db->prepare("SELECT *FROM `usergroup` WHERE  `id`=? AND  (`name` LIKE '%مباشر%')   ");
        $stmt_direct->execute(array($result['idGroup']));
        if ($stmt_direct->rowCount() > 0)
        {
            $direct=true;
        }


        if (isset($_POST['submit']))
        {
            try {
                $form = new  Form();

                $form->post('username')
                    ->val('is_empty', $this->langControl('the_username_field_is_empty'))
                    ->val('strip_tags');
                $form->post('password')
                    ->val('strip_tags');
                $form->post('role')
                    ->val('is_empty', $this->langControl('select_role_user'))
                    ->val('strip_tags');
                $form->post('idGroup')
                    ->val('is_empty', $this->langControl('select_group'))
                    ->val('strip_tags');

                $form->post('number')
                    ->val('strip_tags');

                $form->post('print')
                    ->val('strip_tags');
                $form->post('number_copy')
                    ->val('strip_tags');

				$form->post('csrf')
					->val('strip_tags');

                $form->post('money_box')
                    ->val('strip_tags');
                $form->post('smart_prepared')
                    ->val('strip_tags');
                $form->post('price_type')
                    ->val('is_array')
                    ->val('strip_tags');
                $form->post('shortfalls')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('check_accessories')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('location_out_pull')
                    ->val('strip_tags');

//                if ($sales_man  ||  $purchases_man || $delegate_man || $preparation || $direct) {
                    $form->post('category')
                        ->val('is_array')
                        ->val('strip_tags');
//                }


                if ($delegate_man) {
                    $form->post('region')
                        ->val('is_array', 'منطقة التسوق مطلوب')
                        ->val('strip_tags');
                }


                if ($direct) {
                    $form->post('direct')
                        ->val('is_empty', 'اختر فئة الادمن')
                        ->val('strip_tags');
                }

                $form ->submit();
                $data =$form -> fetch();
                $data['userid'] = $this->userid;


                if (!empty($data['price_type'])) {
                    $data['price_type'] = implode(',',json_decode($data['price_type'], true));
                }else
                {
                    $data['price_type']='';
                }

                if (!empty($data['shortfalls'])) {
                    $data['shortfalls'] = implode(',',json_decode($data['shortfalls'], true));
                }else
                {
                    $data['shortfalls']='';
                }
                if (!empty($data['check_accessories'])) {
                    $data['check_accessories'] = implode(',',json_decode($data['check_accessories'], true));
                }else
                {
                    $data['check_accessories']='';
                }

				if ($this->CSRFTchecked($data['csrf'])) {

                $data['money_box']=(int)str_replace(',','',$data['money_box']);


//                if (!empty($data['category']) &&   ($sales_man  ||  $purchases_man ||  $delegate_man ||  $preparation ||  $direct)) {
                if (!empty($data['category'])) {
                    $list_catg = json_decode($data['category'], true);
                }

                if (!empty($data['region']) &&   $delegate_man) {
                    $list_region = json_decode($data['region'], true);
                }


                if ($data['direct'] !=3)
                {
                    $data['money_box'] ='';
                }

                $userCk = $this->db->select("SELECT * from  `user` WHERE `username`=:username  AND `lang`='{$this->langControl}' LIMIT 1 ",array(':username'=>$result['username']));
                if ($userCk[0]['username']==$data['username'])
                {
                    $data['username']=$userCk[0]['username'];
                }
                else
                {
                    $userCk = $this->db->select("SELECT * from  `user` WHERE `username`=:username  AND `lang`='{$this->langControl}' LIMIT 1 ",array(':username'=>$data['username']));
                    if (count($userCk)>0)
                    {
                        $this->error_form=array('username'=>$this->langControl('username_not available'));
                    }
                }
                if ($data['username'] != $result['username'] && empty($data['password']) )
                {

                    $this->error_form=array('username'=>'يجب تغير الباسورد في حال تم تغير اسم المستخدم.');


                }else {

					if (empty($this->error_form)) {


						if (!empty($data['password'])) {

                            $data['uuid']=$data['password'].'_'.$this->uuid(4);

							$data['password'] = $this->HASH_key('sha256', $data['password'] . $data['username'], HASH_PASSWORD_KEY);

						} else {
							$data['password'] = $result['password'];
						}

						$this->db->update('user', array_diff_key($data, ['category' => "delete", 'region' => "delete", 'csrf' => "delete"]), "id={$id}");
						$this->db->update('log_accountant', array('username' => $data['username']), "id_user={$id}");
						$this->db->update('log_accountant_bill', array('username' => $data['username']), "id_user={$id}");
						$this->db->update('discount', array('from_username' => $data['username']), "from_id_user={$id}");
						$this->db->update('discount', array('to_username' => $data['username']), "to_id_user={$id}");


						if (!empty($data['category'])) {
							$stmt = $this->db->prepare("DELETE FROM `user_purchases_catg` WHERE   `id_user` = ? ");
							$stmt->execute(array($id));
							foreach ($list_catg as $key => $save_data) {
								$stmt_c = $this->db->prepare("INSERT INTO `user_purchases_catg` (`id_user`,`catg`,`date`) VALUE (?,?,?)");
								$stmt_c->execute(array($id, $save_data, time()));
							}
						}
						if (!empty($data['region']) && $delegate_man) {
							$stmt = $this->db->prepare("DELETE FROM `user_purchases_region` WHERE   `id_user` = ? ");
							$stmt->execute(array($id));
							foreach ($list_region as $key => $save_region) {
								$stmt_c = $this->db->prepare("INSERT INTO `user_purchases_region` (`id_user`,`id_region`,`date`) VALUE (?,?,?)");
								$stmt_c->execute(array($id, $save_region, time()));
							}
						}


						$this->lightRedirect(url . '/' . $this->folder . "/list_user/{$data['idGroup']}", 0);

					}
				  }
                }
            }

            catch (Exception $e)
            {
                $this->error_form= json_decode($e -> getMessage(),true);
            }
        }

        require ($this->render($this->folder,'html','edit','php'));
        $this->adminFooterController();







    }




    public function processing($id=null)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this ->checkPermit ('list_user','user');

        $table =$this->table;
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'username', 'dt' => 0 ),
            array( 'db' => 'uuid', 'dt' => 1 ,

                'formatter' => function($id, $row ) {
               if($this->permit('password',$this->folder))
                {
                    $p=explode('_',$id);
                     return $p[0];
                }else{
                   return "*******";
               }

                }
                ),
            array( 'db' => 'role', 'dt' => 2 ),
            array( 'db' => 'idGroup', 'dt' => 3,
               'formatter' => function($id, $row ) {
                    return $this->get_group_by_id($id);
                  }
            ),



            array(
                'db'        => 'hash',
                'dt'        => 4,
                'formatter' => function($id, $row ) {
                    return  "
                    <a target='_blank' download='qr user-{$row[0]}' href='https://chart.googleapis.com/chart?choe=UTF-8&chs=300x300&cht=qr&chl={$id}&username={$row[0]}'><img src='https://chart.googleapis.com/chart?choe=UTF-8&chs=50x50&cht=qr&chl={$id}'></a>
                    ";
                }
            ),
            array( 'db' => 'number', 'dt' => 5 ),
            array( 'db' => 'print', 'dt' => 6 ),
            array(
                'db' => 'id',
                'dt' =>7,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible_edit_price', $this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch($id)} class='toggle-demo' onchange='visible_edit_price(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array(
                'db' => 'id',
                'dt' =>8,
                'formatter' => function ($id, $row) {
                    if ($this->permit('active', $this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_active($id)} class='toggle-demo' onchange='active(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array(
                'db' => 'id',
                'dt' =>9,
                'formatter' => function ($id, $row) {
                    if ($this->permit('jard_and_correction', $this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_jard_and_correction($id)} class='toggle-demo' onchange='jard_and_correction(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array(
                'db' => 'id',
                'dt' =>10,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_serial_sale', $this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_delete_serial_sale($id)} class='toggle-demo' onchange='delete_serial_sale(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array(
                'db'        => 'id',
                'dt'        => 11,
                'formatter' => function($id, $row ) {
                    return "
                   <div style='text-align: center;font-size: 23px;'>
                    <a href=".url."/user/edit/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db'        => 'id',
                'dt'        => 12,
                'formatter' => function($id, $row ) {
                    return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}' data-role='{$row[2]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                }
            ),
            array(
                'db'        => 'id',
                'dt'        => 13,
                'formatter' => function($id, $row ) {
                    return "
                   <div style='text-align: center;font-size: 23px;'>
                    <a href=".url."/permit/admin_permit_user/$id> <i class='fa fa-list-alt' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(  'db' => 'id', 'dt'=>14)


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
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`idGroup` <> 0 AND `idGroup`=$id  AND `lang`='{$this->langControl}'")
        );

    }



    public function ch($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `edit_price` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }

    public function visible_edit_price($v_, $id_)
    {
        if ($this->handleLogin()) {
            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }

            $data = $this->db->update($this->table, array('edit_price' => $v), "`id`={$id}");

        }
    }

    public function ch_active($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `active` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }

    public function active($v_, $id_)
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

        }
    }

    public function ch_jard_and_correction($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `jard_and_correction` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }

    public function jard_and_correction($v_, $id_)
    {
        if ($this->handleLogin()) {
            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }

            $data = $this->db->update($this->table, array('jard_and_correction' => $v), "`id`={$id}");

        }
    }

    public function ch_delete_serial_sale($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `delete_serial_sale` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }

    public function delete_serial_sale($v_, $id_)
    {
        if ($this->handleLogin()) {
            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }

            $data = $this->db->update($this->table, array('delete_serial_sale' => $v), "`id`={$id}");

        }
    }


    public function get_group_by_id($id)
    {

        $stmt=$this->db->prepare("SELECT name FROM `{$this->group}` WHERE `id`=?  AND `lang`='{$this->langControl}'");
      $stmt->execute(array($id));
     $result= $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result[0]['name'];
    }



    public function visible_group($v_,$id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v=$v_;$id=$id_;
        } else {
            $v = 0;$id = 0;
        }
        $data = $this->db->update("usergroup",array('active'=>$v), "`id`={$id}  AND `lang`='{$this->langControl}'");
    }


    function deleteGroup($id)
    {
        if ($this->handleLogin()) {
            $response = $this->db->delete($this->group, "`id`={$id}  AND `lang`='{$this->langControl}'");
            $response = $this->db->delete('files', "`relid`={$id} AND `module`='{$this->folder}._cat'  AND `lang`='{$this->langControl}'", 0);
			$response = $this->db->delete($this->table, "`idGroup`={$id}  ");

		}
    }


    public function select_all_group_user()
    {
        $stmt=$this->db->prepare("SELECT  *FROM `{$this->group}` WHERE  `lang`='{$this->langControl}'");
        $stmt->execute();
        return $stmt;
    }

    public function delete($id)
    {
        if ($this->handleLogin()) {
            $response = $this->db->delete($this->table, "`id`={$id}  AND `lang`='{$this->langControl}'");
            $response = $this->db->delete('log_accountant', "`id_user`={$id}  ");
            $response = $this->db->delete('log_accountant_bill', "`id_user`={$id} ");
            $response = $this->db->delete('discount', "`from_id_user`={$id} ");
            $response = $this->db->delete('discount', "`to_id_user`={$id} ");

        }
      }



    function delete_image_cat($id)
    {
        if ($this->handleLogin()) {
            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            $response = $this->db->update($this->category, array('img' => 0), "`id`={$id}  AND `lang`='{$this->langControl}'");
            $response = $this->db->delete('files', "`relid`={$id} AND `module`='{$this->folder}._cat'  AND `lang`='{$this->langControl}'", 0);
        }
    }




    public function delete_user_purchases_catg($model,$id)
    {
        if ($this->handleLogin()) {

            $stmt=$this->db->prepare("DELETE FROM `user_purchases_catg` WHERE `catg`=? AND  `id_user` = ? ");
            $stmt->execute(array($model,$id));
        }
    }



    public function delete_user_purchases_region($id_region,$id)
    {
        if ($this->handleLogin()) {

            $stmt=$this->db->prepare("DELETE FROM `user_purchases_region` WHERE `id_region`=? AND  `id_user` = ? ");
            $stmt->execute(array($id_region,$id));
        }
    }




    public  function list_all_user()
    {

        $this ->checkPermit ('list_all_user','user');
         $this->adminHeaderController('all_user');




        require($this->render($this->folder, 'html', 'list_all', 'php'));
        $this->adminFooterController();

    }

    public function processing_all()
    {

        $this ->checkPermit ('list_all_user','user');
        $table =$this->table;
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'username', 'dt' => 0 ),
            array( 'db' => 'uuid', 'dt' => 1 ,

                'formatter' => function($id, $row ) {
                    if($this->permit('password',$this->folder))
                    {
                        $p=explode('_',$id);
                        return $p[0];
                    }else{
                        return "*******";
                    }

                }
            ),
            array( 'db' => 'role', 'dt' => 2 ),
            array( 'db' => 'idGroup', 'dt' => 3,
                'formatter' => function($id, $row ) {
                    return $this->get_group_by_id($id);
                }
            ),


            array(
                'db'        => 'hash',
                'dt'        => 4,
                'formatter' => function($id, $row ) {
                    return  "
                    <a target='_blank' download='qr user-{$row[0]}' href='https://chart.googleapis.com/chart?choe=UTF-8&chs=300x300&cht=qr&chl={$id}&username={$row[0]}'><img src='https://chart.googleapis.com/chart?choe=UTF-8&chs=50x50&cht=qr&chl={$id}'></a>
                    ";
                }
            ),
            array( 'db' => 'number', 'dt' => 5 ),
            array(
                'db' => 'id',
                'dt' =>6,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible_edit_price', $this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch($id)} class='toggle-demo' onchange='visible_edit_price(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),

            array(
                'db' => 'id',
                'dt' =>7,
                'formatter' => function ($id, $row) {
                    if ($this->permit('active', $this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_active($id)} class='toggle-demo' onchange='active(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),

            array(
                'db' => 'id',
                'dt' =>8,
                'formatter' => function ($id, $row) {
                    if ($this->permit('jard_and_correction', $this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_jard_and_correction($id)} class='toggle-demo' onchange='jard_and_correction(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),

            array(
                'db' => 'id',
                'dt' =>9,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_serial_sale', $this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_delete_serial_sale($id)} class='toggle-demo' onchange='delete_serial_sale(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 10,
                'formatter' => function($id, $row ) {
                    return "
                   <div style='text-align: center;font-size: 23px;'>
                    <a href=".url."/user/edit/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db'        => 'id',
                'dt'        => 11,
                'formatter' => function($id, $row ) {
                    return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}' data-role='{$row[2]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                }
            ),
            array(
                'db'        => 'id',
                'dt'        => 12,
                'formatter' => function($id, $row ) {
                    return "
                   <div style='text-align: center;font-size: 23px;'>
                    <a href=".url."/permit/admin_permit_user/$id> <i class='fa fa-list-alt' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(  'db' => 'id', 'dt'=>13)


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
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`idGroup` <> 0   AND `lang`='{$this->langControl}'")
        );

    }


    function hash_user()
    {

            $hash=$this->uuid(6);
            $stmtc=$this->db->prepare("SELECT  *FROM `user` WHERE hash =? ");
            $stmtc->execute(array($hash));
            if ($stmtc->rowCount() > 0)
            {
                $this->hash_user();
            }else
            {
                return $hash;
            }

    }






}