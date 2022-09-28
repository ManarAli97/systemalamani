<?php

require "active_customer/active_customer.php";

class Register extends Controller
{

    use active_customer;

    protected $price_type_permit=false;
    function __construct()
    {
        parent::__construct();
        $this->table = 'register_user';
        $this->cart_shop_active='cart_shop_active';
        $this->session_customer='register_session_customer';
        $this->menu = new Menu();

        $date=strtotime(date('Y-m-d',time()));
        $stmtActive=$this->db->prepare("UPDATE  register_session_customer SET  active=0  WHERE date <  ? ");
        $stmtActive->execute(array($date));


    }



    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->session_customer}` (
           `id` int(11)  NOT NULL AUTO_INCREMENT ,
           `id_customer` int(20) NOT NULL,
           `screen` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `userid` int(20) NOT NULL,
           `active` int(20) NOT NULL DEFAULT 0,
           `count_login` int(20) NOT NULL DEFAULT 1,
           `date` bigint(20) NOT NULL,
           `first_date` bigint(20) NOT NULL,
           `last_date_active` bigint(20) NOT NULL,
           `date_active_now` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        return $this->db->cht(array($this->session_customer));
    }

    public function index()
    {
        $index = new Index();
        $index->index();
    }

    public function logout()
    {


        $stmtUpdate=$this->db->prepare("UPDATE  register_session_customer SET  `last_date_active`=?,active=0  WHERE id_customer=?");
        $stmtUpdate->execute(array(time(),$_SESSION['id_member_r']));

            $_SESSION['date_active_customer']=null;
            $_SESSION['username_member_r']=null;
            $_SESSION['id_member_r']=null;
            $_SESSION['name_r']=null;
           $_SESSION['typeLogin']=null;
           session_destroy();
          echo 'true';


    }

    public function logout_customer()
    {
        $stmtUpdate=$this->db->prepare("UPDATE  register_session_customer SET  `last_date_active`=?,active=0  WHERE id_customer=?");
        $stmtUpdate->execute(array(time(),$_SESSION['id_member_r']));

            $_SESSION['date_active_customer']=null;
            $_SESSION['username_member_r']=null;
            $_SESSION['id_member_r']=null;
            $_SESSION['name_r']=null;
           $_SESSION['typeLogin']=null;
           session_destroy();
          header('location:'.url.'/enter');

    }



       function sign_in()
        {
        // $this->lightRedirect(url,0);
           header('location:'.url);

//            if (isset($_SESSION['username_member_r'])) {
//                $this->lightRedirect(url,0);
//            }else{
//                require ($this->render($this->folder,'html','login','php'));
//            }

        }


    public function login()
    {
        if (!empty($_POST['username']) && !empty($_POST['password']) )
        {
            $username=trim(strip_tags($_POST['username']));
            $password=trim(strip_tags($_POST['password']));
            $result=array();

            if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
                //                if username
                $stmt_get_time = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE phone = ?   LIMIT 1");
                $stmt_get_time->execute(array($username));
                $data = $stmt_get_time->fetch();


                $stmt = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE phone=? AND password = ? LIMIT 1");
                $stmt->execute(array($username, $this->HASH_key('sha256', $password  .$data['date'], HASH_PASSWORD_KEY)));
                $result = $stmt->fetch();
            }

            if (!empty($result))
            {
                $_SESSION['username_member_r'] = $result['phone'];
                $_SESSION['id_member_r'] =  $result['id'];
                $_SESSION['name_r'] = $result['name'];
                $_SESSION['typeLogin'] = $result['login'];

                setcookie("setLogin", openssl_encrypt($_SESSION['username_member_r'],"AES-128-ECB",HASH_PASSWORD_KEY).'#|'. $_SESSION['id_member_r'] ,time() + 31556926 , "/");

                echo 'login';
            }
            if (empty($result))
            {
                echo 'not_login';
            }
         }
        else
        {
            echo 'empty';
        }

    }


    function loginActive()
    {

           $data= explode('#|', $_COOKIE['setLogin']);


           if (!empty($data))
           {

               $decrypted_user=openssl_decrypt($data[0],"AES-128-ECB",HASH_PASSWORD_KEY);

               $stmt = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE (`phone`=? OR `username`=?) AND id = ? LIMIT 1");
               $stmt->execute(array($decrypted_user,$decrypted_user, $data[1] ));
               $result = $stmt->fetch();


               if (!empty($result)) {

                   if ( $result['login'] == 'website')
                   {
                       $_SESSION['username_member_r'] = $result['phone'];
                   }else
                   {
                       if (!empty($result['phone']))
                       {
                           $_SESSION['username_member_r'] = $result['phone'];
                       }else
                       {
                           $_SESSION['username_member_r'] = $result['username'];
                       }
                   }


                   $_SESSION['id_member_r'] = $result['id'];
                   $_SESSION['name_r'] = $result['name'];
                   $_SESSION['typeLogin'] = $result['login'];

                   setcookie("setLogin", openssl_encrypt($_SESSION['username_member_r'],"AES-128-ECB",HASH_PASSWORD_KEY).'#|'. $_SESSION['id_member_r'] ,time() + 31556926 , "/");

                   return true;
               }else
               {
                   setcookie("setLogin", null,time() + 31556926  , "/");
                   $this->lightRedirect(url.'/'.$this->folder.'/sign_in',0);

               }


           }else{
               setcookie("setLogin", null,time() + 31556926  , "/");
               $this->lightRedirect(url.'/'.$this->folder.'/sign_in',0);

           }



   }




    function loginWithFacebook()
    {
        $data['name']=strip_tags(trim($_GET['name']));
        $data['username']=strip_tags(trim($_GET['id']));
        $data['email']=strip_tags(trim($_GET['email']));
        $data['year']=date('Y',time());
        $data['date']=time();
        $data['login']='facebook';
        $data['country']='العراق';


        $stmt_get_time = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE username = ?   LIMIT 1");
        $stmt_get_time->execute(array($data['username']));
        if ($stmt_get_time->rowCount()>0)
        {
            $data = $stmt_get_time->fetch();
            if (!empty($data['phone']))
            {
                $_SESSION['username_member_r'] = $data['phone'];
            }else
            {
                $_SESSION['username_member_r'] = $data['username'];
            }
            $_SESSION['id_member_r'] =   $data['id'];
            $_SESSION['name_r'] = $data['name'];
            $_SESSION['typeLogin'] = $data['login'];
            setcookie("setLogin", openssl_encrypt($_SESSION['username_member_r'],"AES-128-ECB",HASH_PASSWORD_KEY).'#|'. $_SESSION['id_member_r'] ,time() + 31556926 , "/");

            echo 'true';
        }
        else
        {
            $stmt = $this->db->insert($this->table,$data );
            if ($stmt)
            {
                $_SESSION['username_member_r'] = $data['username'];
                $_SESSION['id_member_r'] =  $this->db->lastInsertId();
                $_SESSION['name_r'] = $data['name'];
                $_SESSION['typeLogin'] = $data['login'];
               // echo 'true';
                setcookie("setLogin", openssl_encrypt($_SESSION['username_member_r'],"AES-128-ECB",HASH_PASSWORD_KEY).'#|'. $_SESSION['id_member_r'] ,time() + 31556926 , "/");

            }
            else
            {
                echo 'false';
            }
        }


    }


    function update_data()
    {
        if (isset($_SESSION['username_member_r'])) {
            $id_user = $_SESSION['id_member_r'];

                    if (isset($_POST['submit']))
                    {
                        $data['phone']=$_POST['phone'];
                        $data['city']=$_POST['city'];
                        $data['address']=$_POST['address'];
                        $stmt = $this->db->update($this->table, $data,"id={$id_user}");
                        if ($stmt)
                        {
                            echo 'true';
                        }
                    }
                    else
                    {
                        echo 'false';
                    }

        }
    }

    function edit($id)
    {

        $this->checkPermit('edit', $this->folder);
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }
        $files = new Files();
        $this->adminHeaderController($this->langControl('edit'));

            $city=array(
                'بغداد',
                'كربلاء المقدسة',
                'النجف الأشرف',
                'بابل',
                'ميسان',
                'الأنبار',
                'أربيل',
                'البصرة',
                'دهوك',
                'القادسية',
                'ديالى',
                'ذي قار',
                'السليمانية',
                'صلاح الدين',
                'كركوك',
                'المثنى',
                'نينوى',
                'واسط',
            );



            $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE `id` = ?    LIMIT 1");
            $stmt->execute(array($id));
            $result = $stmt->fetch();
            $result['birthday']=date('Y-m-d',strtotime($result['birthday']));

            if (isset($_POST['submit'])) {
                try {
                    $form = new  Form();

                    $form->post('name')
                        ->val('strip_tags');


                    $form->post('title')
                        ->val('strip_tags');


                    $form->post('phone')
                        ->val('strip_tags');


                    $form->post('city')
                        ->val('strip_tags');

                    $form->post('address')
                        ->val('strip_tags');


                    $form->post('birthday')
                        ->val('strip_tags');

                    $form->post('gander')
                        ->val('strip_tags');


                    $form->submit();
                    $data = $form->fetch();


                    if (strlen((string)$data['phone']) == 11 )
                    {

                            $stmt = $this->db->update($this->table,  $data,"id={$id}");
                            $this->lightRedirect(url.'/'.$this->folder.'/subscribers');

                    }else
                    {
                        $this->error_form=json_encode(array('length_phone'=>  'رقم الهاتف يجب ان يكون 11 رقم مثلاً:07xxxxxxxxx' ));
                    }


                } catch (Exception $e) {
                    $data = $form->fetch();
                    $this->error_form = $e->getMessage();
                }

            }

            require ($this->render($this->folder,'html','edit','php'));

        $this->adminFooterController();

    }


    function buy()
    {
        if (isset($_SESSION['username_member_r'])) {
            $id_user=$_SESSION['id_member_r'];

            $stmt=$this->db->prepare("SELECT *FROM `register_user` WHERE `id`=? ");
            $stmt->execute(array($id_user));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);

            $id_user_screen=0;

            if(isset($_GET['id_user_screen']))
            {
                $id_user_screen=$_GET['id_user_screen'];
            }

            $setting =new Setting();


            $car=array();
            $mobile=new mobile();



                $stmt_date = $this->db->prepare("UPDATE `cart_shop_active` SET `date_req` = ?  WHERE `id_member_r`=? AND `buy` = 0 AND `status`=0");
                $stmt_date->execute(array(time(), $id_user));

                $stmt1 = $mobile->getAllContentFromCar_new($_SESSION['id_member_r']);

                while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {




                    $table=$row['table'] ;
                    $number = $row['number'];

                    $this->set_quantity_order($table,$row['id_item'],$row['code'],$number);


                    $stmt_get_item = $this->db->prepare("SELECT *FROM `{$row['table']}` WHERE id = ?  LIMIT 1");
                    $stmt_get_item->execute(array($row['id_item']));
                    $item = $stmt_get_item->fetch();
                    $row['title'] = $item['title'];
                    $row['img'] = $this->save_file . $row['image'];

                }



            $number_bill=$this->getNumberBill(4);

           $dollar=0;
            $stmt=$this->db->prepare("SELECT *FROM `dollar_price`  WHERE `active` = 1  ORDER BY `id` DESC  LIMIT 1" );
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $resultDollar = $stmt->fetch(PDO::FETCH_ASSOC);
                $dollar=$resultDollar['dollar'];
            }


                $stmt1 = $this->db->prepare("UPDATE `cart_shop_active` SET `buy` = 1 ,`number_bill`=?,`dollar_exchange`=?,user_direct=? WHERE `id_member_r`=? AND `buy` = 0 ");
                $stmt1->execute(array($number_bill,$dollar,$id_user_screen,$id_user));

                $stmt2 = $this->db->prepare("UPDATE `register_user` SET `date_req` =  ?  WHERE `id` = ?  ");
                $stmt2->execute(array(time(), $id_user));

                if ($stmt1->rowCount() > 0) {
                    echo '1';
                }

//            }else{
//
//                echo 'onlyCards';
//            }

        $this->logout_customer();
        }
        else
        {
            require ($this->render($this->folder,'html','login','php'));
        }


    }

    public function sendEmail( $from = array('email@test.com', 'Test Name'), $recipientsXmail = array('email@test.com' => 'Test name'), $replyto = NULL,$subject,$body)
    {


        $mail = new PHPMailer;
        $mail->CharSet = 'utf-8';
        $mail->XMailer = 'khatawat';
        $mail->Encoding = "base64";
        $mail->setFrom($from[0], $from[1]);
        foreach ($recipientsXmail as $email => $name) {
            $mail->addAddress($email, $name);
        }
        $mail->isHTML(true);

        $mail->addReplyTo($replyto);
        $mail->Subject = $subject;
        $mail->Body = $body;
        if (!$mail->send()) {
//            echo 'Message could not be sent.';
//            echo 'Mailer Error: ' . $mail->ErrorInfo;
            return 0;
        } else {
            return 1;
        }
    }


    function processing_request($id)
    {
        if ($this->handleLogin()) {
            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }
            $this->checkPermit('processing_request', 'register');
            $date_req = $_GET['date_req'];
            $number_bill = $_GET['number_bill'];
            $date_req = implode(',', $date_req);
            $stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET   `number_bill` = ? , `status` = 1 ,  `buy` = 2 , `date_d_r`= ? , `user_id`=? WHERE  `buy` = ?  AND `id_member_r`=?  AND `date_req` IN ($date_req)  ");
            $stmt2->execute(array($number_bill,time(), $_SESSION['userid'], 1, $id));

            if ($stmt2->rowCount() > 0) {
                echo 1;
            } else {
                echo 0;
            }
        }else{
            echo 'login';
        }
    }


    function processing_request_edit_delivery_user($id)
    {
        if ($this->handleLogin()) {
            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }


            $this->checkPermit('processing_request_edit_delivery_user', 'delivery_user');
            $date_d_r = $_GET['date_d_r'];
            $idUser = $_GET['idUser'];
            $number_bill = $_GET['number_bill'];

            $stmt2 = $this->db->prepare("UPDATE `cart_shop_active` SET `number_bill` = ? ,`delivery_user` = ? , `status` = 1  , `user_id`=? WHERE  `buy` = ?  AND `id_member_r`=?  AND `date_d_r` =?  ");
            $stmt2->execute(array($number_bill,$idUser, $_SESSION['userid'], 2, $id,$date_d_r));

            if ($stmt2->rowCount() > 0) {
                echo 1;
            } else {
                echo 0;
            }
        }else{
            echo 'login';
        }
    }


    function processing_request_after_rej($id)
    {
        $this->AddToTraceByFunction($this->userid,'register','processing_request_after_rej/'.$id);
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        if ($this->handleLogin()) {
            $this->checkPermit('processing_request_after_rej', 'register');
            $date_d_r = $_GET['date_d_r'];

            $stmt = $this->db->prepare("UPDATE `cart_shop_active` SET date_req=?, `status` = 1  , `buy` =2,   `user_id`=?  WHERE  `buy` = ? AND `id_member_r`=? AND  `date_d_r` =? ");
            $stmt->execute(array(time(), $_SESSION['userid'], 3, $id, $date_d_r));

            if ($stmt->rowCount() > 0) {

                $stmt1 = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`code`,`name_color`,`table`,SUM(`number`)as number,`buy`,`date` FROM `{$this->cart_shop_active}` WHERE `id_member_r` =?  AND `buy` =2 AND `date_d_r`=? GROUP BY `id_item`,`size`,`table`,`code` ORDER BY `id`  DESC  ");
                $stmt1->execute(array($id, $date_d_r));
                while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {


                    if ($row['table'] == 'mobile') {

                        $number = $row['number'];
                        $stmt = $this->db->prepare("UPDATE  `excel` SET `quantity`=`quantity` - {$number} WHERE  `code`=?  ");
                        $stmt->execute(array($row['code']));
                    }


                    if ($row['table'] == 'camera') {
                        $number = $row['number'];
                        $stmt = $this->db->prepare("UPDATE  `excel_camera` SET `quantity`=`quantity` - {$number} WHERE  `code`=?  ");
                        $stmt->execute(array($row['code']));
                    }


                    if ($row['table'] == 'printing_supplies') {
                        $number = $row['number'];
                        $stmt = $this->db->prepare("UPDATE  `excel_printing_supplies` SET `quantity`=`quantity` - {$number} WHERE  `code`=?  ");
                        $stmt->execute(array($row['code']));
                    }

                    if ($row['table'] == 'computer') {
                        $number = $row['number'];
                        $stmt = $this->db->prepare("UPDATE  `excel_computer` SET `quantity`=`quantity` - {$number} WHERE  `code`=?  ");
                        $stmt->execute(array($row['code']));
                    }


                    if ($row['table'] == 'games') {
                        $number = $row['number'];
                        $stmt = $this->db->prepare("UPDATE  `excel_games` SET `quantity`=`quantity` - {$number} WHERE  `code`=?  ");
                        $stmt->execute(array($row['code']));
                    }


                    if ($row['table'] == 'network') {
                        $number = $row['number'];
                        $stmt = $this->db->prepare("UPDATE  `excel_network` SET `quantity`=`quantity` - {$number} WHERE  `code`=?  ");
                        $stmt->execute(array($row['code']));
                    }


                    if ($row['table'] == 'accessories') {
                        $number = $row['number'];
                        $stmt = $this->db->prepare("UPDATE  `excel_accessories` SET `quantity`=`quantity` - {$number} WHERE  `code`=?  ");
                        $stmt->execute(array($row['code']));
                    }


                    if ($row['table'] == 'product_savers') {
                        $number = $row['number'];
                        $stmt = $this->db->prepare("UPDATE  `excel_savers` SET `quantity`=`quantity` - {$number} WHERE  `code`=? ");
                        $stmt->execute(array($row['code']));
                    }

                }


                echo 1;
            } else {
                echo 0;
            }
        }else{
            echo 'login';
        }

    }



    function processing_request_rejected($id)
    {
        $this->AddToTraceByFunction($this->userid,'register','processing_request_rejected/'.$id);
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        if ($this->handleLogin()) {
            $this->checkPermit('processing_request_rejected', 'register');

            $why_rej = $_GET['why_rej'];

            $date_req = $_GET['date_req'];

            $date_req = implode(',', $date_req);
            $stmt1 = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date` FROM `{$this->cart_shop_active}` WHERE `id_member_r` =?  AND `buy` = 1  AND  `date_req` IN ($date_req) GROUP BY `id_item`,`size`,`table`,`code` ORDER BY `id`  DESC  ");
            $stmt1->execute(array($id));
            while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {


                if ($row['table'] == 'mobile') {

                    $number = $row['number'];
                    $stmt = $this->db->prepare("UPDATE  `excel` SET `quantity`=`quantity` + {$number} WHERE  `code`=?  ");
                    $stmt->execute(array($row['code']));
                }


                if ($row['table'] == 'camera') {
                    $number = $row['number'];
                    $stmt = $this->db->prepare("UPDATE  `excel_camera` SET `quantity`=`quantity` + {$number} WHERE  `code`=?  ");
                    $stmt->execute(array($row['code']));
                }

                if ($row['table'] == 'printing_supplies') {
                    $number = $row['number'];
                    $stmt = $this->db->prepare("UPDATE  `excel_printing_supplies` SET `quantity`=`quantity` + {$number} WHERE  `code`=?  ");
                    $stmt->execute(array($row['code']));
                }


                if ($row['table'] == 'computer') {
                    $number = $row['number'];
                    $stmt = $this->db->prepare("UPDATE  `excel_computer` SET `quantity`=`quantity` + {$number} WHERE  `code`=?  ");
                    $stmt->execute(array($row['code']));
                }


                if ($row['table'] == 'games') {
                    $number = $row['number'];
                    $stmt = $this->db->prepare("UPDATE  `excel_games` SET `quantity`=`quantity` + {$number} WHERE  `code`=?  ");
                    $stmt->execute(array($row['code']));
                }


                if ($row['table'] == 'network') {
                    $number = $row['number'];
                    $stmt = $this->db->prepare("UPDATE  `excel_network` SET `quantity`=`quantity` + {$number} WHERE  `code`=?  ");
                    $stmt->execute(array($row['code']));
                }


                if ($row['table'] == 'accessories') {
                    $number = $row['number'];
                    $stmt = $this->db->prepare("UPDATE  `excel_accessories` SET `quantity`=`quantity` + {$number} WHERE  `code`=?  ");
                    $stmt->execute(array($row['code']));
                }


                if ($row['table'] == 'product_savers') {
                    $number = $row['number'];
                    $stmt = $this->db->prepare("UPDATE  `excel_savers` SET `quantity`=`quantity` + {$number} WHERE  `code`=?  ");
                    $stmt->execute(array($row['code']));
                }

            }


            $stmt = $this->db->prepare("UPDATE `cart_shop_active` SET `status` = 2  , `buy` = 3, `why_rejected` = ?  , `date_d_r`= ? , `user_id`=?  WHERE  `buy` = ? AND `id_member_r`=? AND  `date_req` IN ($date_req)");
            $stmt->execute(array($why_rej, time(), $_SESSION['userid'], 1, $id));

            if ($stmt->rowCount() > 0) {
                echo 1;
            } else {
                echo 0;
            }
        }else{
            echo 'login';
        }
    }



    function processing_request_rejected_after_order($id)
    {
        $this->AddToTraceByFunction($this->userid,'register','processing_request_rejected_after_order/'.$id);
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}

        if ($this->handleLogin()) {
            $this->checkPermit('processing_request_rejected_after_order','register');

            $why_rej = $_GET['why_rej'];

            $date_d_r = $_GET['date_d_r'];


            $stmt = $this->db->prepare("UPDATE `cart_shop_active` SET `date_req`=? ,`status` = 2  , `buy` = 3, `why_rejected` = ?  , `user_id`=?  WHERE  `buy` = ? AND `id_member_r`=? AND  `date_d_r` = ? AND `date_d_r` <> 0");
            $stmt->execute(array(time(), $why_rej, $_SESSION['userid'], 2, $id, $date_d_r));

            if ($stmt->rowCount() > 0) {
                $stmt1 = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date` FROM `{$this->cart_shop_active}` WHERE `id_member_r` =?  AND `buy` = 3 AND `date_d_r` = ? GROUP BY `id_item`,`size`,`table`,`code` ORDER BY `id`  DESC  ");
                $stmt1->execute(array($id, $date_d_r));
                while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {


                    if ($row['table'] == 'mobile') {

                        $number = $row['number'];
                        $stmt = $this->db->prepare("UPDATE  `excel` SET `quantity`=`quantity` + {$number} WHERE  `code`=?  ");
                        $stmt->execute(array($row['code']));
                    }


                    if ($row['table'] == 'camera') {
                        $number = $row['number'];
                        $stmt = $this->db->prepare("UPDATE  `excel_camera` SET `quantity`=`quantity` + {$number} WHERE  `code`=?  ");
                        $stmt->execute(array($row['code']));
                    }

                    if ($row['table'] == 'printing_supplies') {
                        $number = $row['number'];
                        $stmt = $this->db->prepare("UPDATE  `excel_printing_supplies` SET `quantity`=`quantity` + {$number} WHERE  `code`=?  ");
                        $stmt->execute(array($row['code']));
                    }


                    if ($row['table'] == 'computer') {
                        $number = $row['number'];
                        $stmt = $this->db->prepare("UPDATE  `excel_computer` SET `quantity`=`quantity` + {$number} WHERE  `code`=?  ");
                        $stmt->execute(array($row['code']));
                    }


                    if ($row['table'] == 'games') {
                        $number = $row['number'];
                        $stmt = $this->db->prepare("UPDATE  `excel_games` SET `quantity`=`quantity` + {$number} WHERE  `code`=?  ");
                        $stmt->execute(array($row['code']));
                    }


                    if ($row['table'] == 'network') {
                        $number = $row['number'];
                        $stmt = $this->db->prepare("UPDATE  `excel_network` SET `quantity`=`quantity` + {$number} WHERE  `code`=?  ");
                        $stmt->execute(array($row['code']));
                    }


                    if ($row['table'] == 'accessories') {
                        $number = $row['number'];
                        $stmt = $this->db->prepare("UPDATE  `excel_accessories` SET `quantity`=`quantity` + {$number} WHERE  `code`=?  ");
                        $stmt->execute(array($row['code']));
                    }


                    if ($row['table'] == 'product_savers') {
                        $number = $row['number'];
                        $stmt = $this->db->prepare("UPDATE  `excel_savers` SET `quantity`=`quantity` + {$number} WHERE  `code`=? ");
                        $stmt->execute(array($row['code']));
                    }

                }


                echo 1;
            } else {
                echo 0;
            }
        }else{
            echo 'login';
        }
    }


    function return_order_minus($table,$code,$id_user)
    {
        $this->AddToTraceByFunction($this->userid,'register','return_order_minus/'.$table.'/'.$code.'/'.$id_user);
        if (!is_string($table)) {$error=new Errors(); $error->index();}
        if (!is_numeric($id_user)) {$error=new Errors(); $error->index();}

        if ($this->handleLogin()) {

            $this->checkPermit('return_order_minus', 'register');
            $color = $_GET['color'];
            $mpx = $_GET['mpx'];



            $stmt_count_n = $this->db->prepare("SELECT  *FROM `{$this->cart_shop_active}` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `name_color` = ?   AND `buy` = 1 AND `number` = 1");
            $stmt_count_n->execute(array($table, $code, $id_user,$color));

            if ($stmt_count_n->rowCount() > 0 )
            {

                $stmt_delete_last_one = $this->db->prepare("SELECT SUM(`number`)as number  FROM `{$this->cart_shop_active}` WHERE  `table` =?  AND `code` =? AND `id_member_r` = ?   AND `name_color` = ?   AND `buy` = 1 ");
                $stmt_delete_last_one->execute(array($table, $code, $id_user,$color));
                   $number= $stmt_delete_last_one->fetch(PDO::FETCH_ASSOC)['number'];

                if ($number == 1) {

                    $stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ?  AND `buy` = 1  LIMIT 1 ");
                    $stmt->execute(array($table, $code, $id_user,$color));
                    echo  0;

                }else if ($number > 1)
                    {
                    $stmt_sel = $this->db->prepare("UPDATE  `cart_shop_active` SET  `number`=`number` - 1  WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ?  AND `buy` = 1  AND number > 1 LIMIT  1  ");
                    $stmt_sel->execute(array($table, $code, $id_user,$color));
                    if ($stmt_sel->rowCount() < 1)
                    {
                        $stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ?  AND `buy` = 1  LIMIT 1 ");
                        $stmt->execute(array($table, $code, $id_user,$color));
                    }
                }else{
                    $stmt = $this->db->prepare("DELETE   FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ?  AND `buy` = 1  LIMIT 1 ");
                    $stmt->execute(array($table, $code, $id_user,$color));
                }

            } else
            {
                $stmt_sel = $this->db->prepare("UPDATE  `cart_shop_active` SET  `number`=`number` - 1  WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ?  AND `buy` = 1  AND number > 1 LIMIT  1  ");
                $stmt_sel->execute(array($table, $code, $id_user,$color));

             }

                if ($table == 'mobile') {

                    $stmt = $this->db->prepare("UPDATE  `excel` SET `quantity`=`quantity` + 1 WHERE  `code`=?  ");
                    $stmt->execute(array($code));

                }


                if ($table == 'camera') {

                    $stmt = $this->db->prepare("UPDATE  `excel_camera` SET `quantity`=`quantity` + 1 WHERE  `code`=?  ");
                    $stmt->execute(array($code));
                }

                if ($table == 'printing_supplies') {

                    $stmt = $this->db->prepare("UPDATE  `excel_printing_supplies` SET `quantity`=`quantity` + 1 WHERE  `code`=?  ");
                    $stmt->execute(array($code));
                }
			if ($table == 'computer') {

				$stmt = $this->db->prepare("UPDATE  `excel_computer` SET `quantity`=`quantity` + 1 WHERE  `code`=?  ");
				$stmt->execute(array($code));
			}


                if ($table == 'games') {

                    $stmt = $this->db->prepare("UPDATE  `excel_games` SET `quantity`=`quantity` + 1 WHERE  `code`=?  ");
                    $stmt->execute(array($code));
                }


                if ($table == 'network') {

                    $stmt = $this->db->prepare("UPDATE  `excel_network` SET `quantity`=`quantity` + 1 WHERE  `code`=?  ");
                    $stmt->execute(array($code));
                }


                if ($table == 'accessories') {

                    $stmt = $this->db->prepare("UPDATE  `excel_accessories` SET `quantity`=`quantity` + 1 WHERE  `code`=?  AND `color` = ? ");
                    $stmt->execute(array($code,$color));
                }


                if ($table == 'product_savers') {

                    $stmt = $this->db->prepare("UPDATE  `excel_savers` SET `quantity`=`quantity` + 1 WHERE  `code`=?  ");
                    $stmt->execute(array($code));
                }


                $stmt = $this->db->prepare("UPDATE   `{$this->cart_shop_active}` SET  `mpx`  =?   WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ?   AND `buy` = 1   ");
                $stmt->execute(array($mpx, $table, $code, $id_user,$color));



                $stmt2 = $this->db->prepare("SELECT  SUM(`number`)as number  FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ? AND `buy`= 1 GROUP BY `id_item`,`size`,`table`,`code`,`name_color` ORDER BY `id`  DESC  ");
                $stmt2->execute(array($table, $code, $id_user,$color));
                $res = $stmt2->fetch(PDO::FETCH_ASSOC);

                if ($stmt2->rowCount() > 0) {
                    echo $res['number'];
                }

        }

    }



    function return_order_plus($table,$code,$id_user)
    {
        $this->AddToTraceByFunction($this->userid,'register','return_order_plus/'.$table.'/'.$code.'/'.$id_user);
        if (!is_string($table)) {$error=new Errors(); $error->index();}
        if (!is_numeric($id_user)) {$error=new Errors(); $error->index();}

        if ($this->handleLogin()) {
            $this->checkPermit('return_order_plus', 'register');
            $color = $_GET['color'];
            $mpx = $_GET['mpx'];

            $stmt_sel = $this->db->prepare("UPDATE  `cart_shop_active` SET  `number`=`number` + 1  WHERE `table` =?  AND `code` =? AND `id_member_r` = ? AND  `name_color` = ? AND `buy` = 1    LIMIT  1  ");
            $stmt_sel->execute(array($table, $code, $id_user,$color));

                if ($stmt_sel->rowCount() > 0 ) {

                    if ($table == 'mobile') {

                        $stmt = $this->db->prepare("UPDATE  `excel` SET `quantity`=`quantity` - 1 WHERE  `code`=?  ");
                        $stmt->execute(array($code));
                    }


                    if ($table == 'camera') {

                        $stmt = $this->db->prepare("UPDATE  `excel_camera` SET `quantity`=`quantity` - 1 WHERE  `code`=?  ");
                        $stmt->execute(array($code));
                    }

                    if ($table == 'printing_supplies') {

                        $stmt = $this->db->prepare("UPDATE  `excel_printing_supplies` SET `quantity`=`quantity` - 1 WHERE  `code`=?  ");
                        $stmt->execute(array($code));
                    }

					if ($table == 'computer') {

						$stmt = $this->db->prepare("UPDATE  `excel_computer` SET `quantity`=`quantity` - 1 WHERE  `code`=?  ");
						$stmt->execute(array($code));
					}

                    if ($table == 'games') {

                        $stmt = $this->db->prepare("UPDATE  `excel_games` SET `quantity`=`quantity` - 1 WHERE  `code`=?  ");
                        $stmt->execute(array($code));
                    }


                    if ($table == 'network') {

                        $stmt = $this->db->prepare("UPDATE  `excel_network` SET `quantity`=`quantity` - 1 WHERE  `code`=?  ");
                        $stmt->execute(array($code));
                    }


                    if ($table == 'accessories') {

                        $stmt = $this->db->prepare("UPDATE  `excel_accessories` SET `quantity`=`quantity` - 1 WHERE  `code`=?  AND  `color` = ?");
                        $stmt->execute(array($code,$color));
                    }

                    if ($table == 'product_savers') {
                        $stmt_srv = $this->db->prepare("SELECT `color`,SUM(`number`)as number  FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `buy`= 1 GROUP BY `id_item`,`size`,`table`,`code` ORDER BY `id`  DESC  ");
                        $stmt_srv->execute(array($table, $code, $id_user));
                        $srv = $stmt_srv->fetch(PDO::FETCH_ASSOC);
                        $stmt = $this->db->prepare("UPDATE  `excel_savers` SET `quantity`=`quantity` - 1 WHERE  `code`=?  ");
                        $stmt->execute(array($code));
                    }


                    $stmt = $this->db->prepare("UPDATE   `{$this->cart_shop_active}` SET  `mpx`  =?   WHERE `table` =?  AND `code` =? AND `id_member_r` = ?  AND `name_color` = ?   AND `buy` = 1   ");
                    $stmt->execute(array($mpx, $table, $code, $id_user,$color));

                    $stmt2 = $this->db->prepare("SELECT SUM(`number`)as number  FROM `{$this->cart_shop_active}` WHERE `table` =?  AND `code` =? AND `id_member_r` = ? AND `name_color`=? AND `buy`= 1 GROUP BY `id_item`,`size`,`table`,`code` ORDER BY `id`  DESC  ");
                    $stmt2->execute(array($table, $code, $id_user,$color));
                    $res = $stmt2->fetch(PDO::FETCH_ASSOC);

                    if ($stmt2->rowCount() > 0) {
                        echo $res['number'];
                    }
                }

        }
    }









    public function wholesale_price()
    {
        $this->checkPermit('wholesale_price','registration');
        $this->adminHeaderController($this->langControl('wholesale_price'));

        $y=0;

        if (isset($_POST['submit']))
        {
            $y = $_POST['year'];

        }


        $stmt = $this->db->prepare("SELECT * FROM  `{$this->table}` GROUP BY `year` ORDER BY `year` DESC ");
        $stmt->execute();
        $year=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $year[]=$row['year'];
        }


        require ($this->render($this->folder,'html','list_wholesale_price','php'));
        $this->adminFooterController();
    }


    public function processing_wholesale_price($year=0)
    {


        $this->checkPermit('wholesale_price','registration');

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(

            array('db' => 'name', 'dt' => 0),
            array('db' => 'username', 'dt' => 1),
            array('db' => 'phone', 'dt' => 2),
            array('db' => 'country', 'dt' => 3),
            array('db' => 'city', 'dt' => 4),
            array('db' => 'address', 'dt' => 5),

            array(
                'db'        => 'id',
                'dt'        => 6,
                'formatter' => function($id, $row ) {
                    if ($this->permit('visible',$this->folder)) {
                    return "
                <div style='text-align: center'>
                  <input {$this->ch_wholesale_price($id)} class='toggle-demo' onchange='visible_wholesale_price(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),


            array('db' => 'date', 'dt' => 7,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:s:i A',$id);
                }
            ),


            array('db' => 'id', 'dt' => 8,
                'formatter' => function ($id, $row) {
                    return  "<a href=' ".  url .'/'.$this->folder ."/details_client/{$id}'>{$this->langControl('details')}</a>" ;
                }

            ),

            array('db' => 'id', 'dt' => 9,
                'formatter' => function ($id, $row) {
                    return  "<a href=' ".  url .'/'.$this->folder ."/view_req/{$id}'>{$this->notification_buy($id)}</a>" ;
                }

            ),

            array(
                'db' => 'id',
                'dt' => 10,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', 'registration')) {
                        return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array('db' => 'id', 'dt' => 11)


        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        if ($year == 0) {
            echo json_encode(
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "`wholesale_price`=1  ")
            );
        }
        else
        {
            echo json_encode(
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, " year ={$year} AND `wholesale_price`=1  ")
            );
        }


    }



    public function subscribers()
    {
        $this->checkPermit('list_register','registration');
        $this->adminHeaderController($this->langControl('registration'));

        $y=0;

        if (isset($_POST['submit']))
        {
            $y = $_POST['year'];

        }

        $stmt = $this->db->prepare("SELECT * FROM  `{$this->table}` GROUP BY `year` ORDER BY `year` DESC ");
        $stmt->execute();
        $year=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $year[]=$row['year'];
        }

        $date=null;
        $todate=null;
        $fromDate=null;
        $toDate=null;
        if (isset($_GET['date'])&&isset($_GET['todate']))
        {
            $date=$_GET['date'];
            $todate=$_GET['todate'];

            $fromDate=strtotime($date);
            $toDate= strtotime($todate);

        }

        require ($this->render($this->folder,'html','list','php'));
        $this->adminFooterController();
    }




    public function processing($year=0,$date=null,$todate=null)
    {


        $this->checkPermit('list_registration', 'registration');


        $this->price_type_permit= $this->permit('price_type', $this->folder);


        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(

            array('db' => 'name', 'dt' => 0),
            array('db' => 'title', 'dt' => 1),
            array('db' => 'phone', 'dt' => 2),
            array('db' => 'city', 'dt' => 3),
            array('db' => 'address', 'dt' => 4),
            array('db' => 'gander', 'dt' => 5),
            array('db' => 'price_type', 'dt' => 6,

                'formatter' => function($id, $row ) {

                    $ar=explode(',',$id);
                    $checked=null;
                    if (in_array(1,$ar))
                    {
                        $checked='checked';
                    }

                    if ( $this->price_type_permit) {
                        return "

                <div style='text-align: center'>
                  <input {$checked}  value='1' class='toggle-demo list_price_type{$row[16]}' type='checkbox'  onchange='price_type(this,{$row[16]})'  data-toggle='toggle' data-on='on' data-off='off' data-onstyle='success' data-offstyle='danger'  data-size='small' data-style='ios' >
                 </div>
             ";
            } else {
                return $this->langControl('forbidden');
            }
                }
            ),
            array('db' => 'price_type', 'dt' => 7,

                'formatter' => function($id, $row ) {


                    $ar=explode(',',$id);
                    $checked=null;
                    if (in_array(2,$ar))
                    {
                        $checked='checked';
                    }

                    if ( $this->price_type_permit) {
                        return "
                <div style='text-align: center'>
                  <input {$checked}  value='2' class='toggle-demo list_price_type{$row[16]}'  type='checkbox'  onchange='price_type(this,{$row[16]})'  data-toggle='toggle' data-on='on' data-off='off' data-onstyle='success' data-offstyle='danger' data-size='small'  data-style='ios' >
                 </div>
             ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
                ),
            array('db' => 'price_type', 'dt' => 8,

                'formatter' => function($id, $row ) {

                    $ar=explode(',',$id);
                    $checked=null;
                    if (in_array(3,$ar))
                    {
                        $checked='checked';
                    }

                    if ( $this->price_type_permit) {
                        return "
                <div class='' style='text-align: center'>
                  <input {$checked}  value='3' class='toggle-demo list_price_type{$row[16]}'  type='checkbox'  onchange='price_type(this,{$row[16]})'  data-toggle='toggle' data-on='on' data-off='off' data-onstyle='success' data-offstyle='danger'  data-size='small'  data-style='ios'>
                 </div>
                  ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }

                ),

            array(
                'db'        => 'type_customer_12',
                'dt'        => 9,
                'formatter' => function($id, $row ) {

                    if ($row[17] != 0) {
                        if ($this->permit('type_customer', $this->folder)) {
                            $type_customer_12=null;
                            if ($id==1)
                            {
                                $type_customer_12='checked';
                            }

                            return "
                            <div style='text-align: center'>
                              <input {$type_customer_12}   class='toggle-demo'  type='checkbox'  onchange='type_customer(this,{$id})'  data-toggle='toggle' data-on='مقتنع' data-off='غير مقتنع' data-onstyle='success' data-offstyle='danger'>
                             </div>
                         ";
                        } else {
                            return $this->langControl('forbidden');
                        }
                    }else{
                       return '<span class="badge badge-warning"> غير محدد</span>'  ;
                    }
                }


            ),

            array('db' => 'id', 'dt' =>10,
                        'formatter' => function ($id, $row)
                        {
                            if ($this->permit('notes_about_customer',$this->folder)) {

                                return "<button class='btn btn-primary btn-sm' onclick='get_note({$id})'>ملاحظات </button>";
                            } else
                                {
                                    return $this->langControl('forbidden');
                                }

                     }
            ),

            array('db' => 'date', 'dt' => 11,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:s:i A',$id);
                }
            ),


         array('db' => 'id', 'dt' =>12,
                'formatter' => function ($id, $row) {
                return  "<a  href=' ".  url .'/'.$this->folder ."/details_client/{$id}'>تفاصيل</a>" ;
                }

            ),

         array('db' => 'id', 'dt' => 13,
                'formatter' => function ($id, $row) {
                return  "<a href=' ".  url .'/'.$this->folder ."/view_req/{$id}'><i class='fa fa-cart-plus'></i> </a>" ;
                }

            ),

         array('db' => 'id', 'dt' => 14,
                'formatter' => function ($id, $row) {
                return  "<a href=' ".  url .'/'.$this->folder ."/edit/{$id}'><i class='fa fa-edit'></i></a>" ;
                }

            ),

            array(
                'db' => 'id',
                'dt' => 15,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', 'registration')) {
                        return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array('db' => 'id', 'dt' => 16),
            array('db' => 'type_customer_12', 'dt' => 17)


        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );




        if ($date && $todate)
        {

                echo json_encode(
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"`date` BETWEEN {$date} AND {$todate} ")
                );

        }else
            {

            echo json_encode(
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns  )
            );


            }



    }




    public function subscribers_qr()
    {
        $this->checkPermit('subscribers_qr','registration');
        $this->adminHeaderController($this->langControl('registration'));

        $y=0;

        if (isset($_POST['submit']))
        {
            $y = $_POST['year'];

        }

        $stmt = $this->db->prepare("SELECT * FROM  `{$this->table}` GROUP BY `year` ORDER BY `year` DESC ");
        $stmt->execute();
        $year=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $year[]=$row['year'];
        }

        $date=null;
        $todate=null;
        $fromDate=null;
        $toDate=null;
        if (isset($_GET['date'])&&isset($_GET['todate']))
        {
            $date=$_GET['date'];
            $todate=$_GET['todate'];

            $fromDate=strtotime($date);
            $toDate= strtotime($todate);

        }

        require ($this->render($this->folder,'html','qr','php'));
        $this->adminFooterController();
    }




    public function processing_qr($year=0,$date=null,$todate=null)
    {


        $this->checkPermit('subscribers_qr', 'registration');

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(

            array('db' => 'name', 'dt' => 0),
            array('db' => 'phone', 'dt' => 1),
            array('db' => 'city', 'dt' => 2),
            array('db' => 'address', 'dt' => 3),



            array('db' => 'uid', 'dt' => 4,
                'formatter' => function ($id, $row) {
                  if ($id)
                  {
                      return  "<button onclick=getQr('{$id}','{$row[1]}') style='padding: 0;font-size: 38px;color: #284491' type='button' class='btn'><i class='fa fa-qrcode'></i></button>";

                  }else
                  {
                      return  '';
                  }
                }
            ),


            array('db' => 'date', 'dt' => 5,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:s:i A',$id);
                }
            ),

            array('db' => 'id', 'dt' => 6)


        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );




        if ($date && $todate)
        {
            if ($year == 0) {
                echo json_encode(
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"`date` BETWEEN {$date} AND {$todate} ")
                );
            }
            else {
                echo json_encode(
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, " `year` ={$year} AND `date` BETWEEN {$date} AND {$todate} "));
            }
        }else
            {
                if ($year == 0) {
                    echo json_encode(
                        SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns  )
                    );
                }
                else {
                    echo json_encode(
                        SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, " `year` ={$year}  "));
                }
            }



    }













     function ch_price_type($ty,$nu)
     {
         $ar=explode(',',$ty);
         if (in_array($nu,$ar))
         {
             return 'checked';
         }
     }


    function change_price_type($id)
    {
        if ($this->handleLogin()) {
             $data['price_type']=implode(',',json_decode($_GET['type_price'],true));
            $stmt = $this->db->update($this->table,$data, "`id`={$id}");
        }
    }





    public function subscribers1()
    {
        $this->checkPermit('subscribers1','registration');
        $this->adminHeaderController('زبائن مقتنعين');

        $y=0;

        if (isset($_POST['submit']))
        {
            $y = $_POST['year'];

        }

        $stmt = $this->db->prepare("SELECT * FROM  `{$this->table}` GROUP BY `year` ORDER BY `year` DESC ");
        $stmt->execute();
        $year=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $year[]=$row['year'];
        }


        require ($this->render($this->folder,'html','list1','php'));
        $this->adminFooterController();
    }




    public function processing1($year=0)
    {


        $this->checkPermit('list_registration', 'registration');

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(

            array('db' => 'name', 'dt' => 0),
            array('db' => 'phone', 'dt' => 1),
            array('db' => 'city', 'dt' => 2),
            array('db' => 'address', 'dt' => 3),

            array(
                'db'        => 'id',
                'dt'        => 4,
                'formatter' => function($id, $row ) {
                    if ($this->permit('visible',$this->folder)) {
                    return "
                <div style='text-align: center'>
                  <input {$this->ch_type_customer($id)}  class='toggle-demo'  type='checkbox'  onchange='type_customer(this,{$id})'  data-toggle='toggle' data-on='مقتنع' data-off='غير مقتنع' data-onstyle='success' data-offstyle='danger'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),


            array('db' => 'id', 'dt' =>5,
                'formatter' => function ($id, $row) {
                    return  "<a   target='_blank' class='btn btn-info btn-sm' href=' ".  url .'/'.$this->folder ."/account_customer/{$id}'>  <i class='fa fa-sign-in'></i>  <span>دخول بحساب الزبون</span></a>" ;
                }

            ),

            array('db' => 'date', 'dt' => 6,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:s:i A',$id);
                }
            ),


            array('db' => 'id', 'dt' =>7,
                'formatter' => function ($id, $row) {
                    return  "<a  href=' ".  url .'/'.$this->folder ."/details_client/{$id}'>{$this->langControl('details')}</a>" ;
                }

            ),

            array('db' => 'id', 'dt' => 8,
                'formatter' => function ($id, $row) {
                    return  "<a href=' ".  url .'/'.$this->folder ."/view_req/{$id}'>{$this->notification_buy($id)}</a>" ;
                }

            ),

            array(
                'db' => 'id',
                'dt' => 9,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', 'registration')) {
                        return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array('db' => 'id', 'dt' => 10)


        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        if ($year == 0) {
            echo json_encode(
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"`type_customer_12` =1" )
            );
        }
        else
        {
        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, " year ={$year} AND `type_customer_12` =1")
        );
    }


    }





    public function subscribers2()
    {
        $this->checkPermit('subscribers2','registration');
        $this->adminHeaderController('زبائن غير مقتنعين');

        $y=0;

        if (isset($_POST['submit']))
        {
            $y = $_POST['year'];

        }

        $stmt = $this->db->prepare("SELECT * FROM  `{$this->table}` GROUP BY `year` ORDER BY `year` DESC ");
        $stmt->execute();
        $year=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $year[]=$row['year'];
        }


        require ($this->render($this->folder,'html','list2','php'));
        $this->adminFooterController();
    }




    public function processing2($year=0)
    {


        $this->checkPermit('list_registration', 'registration');

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(

            array('db' => 'name', 'dt' => 0),
            array('db' => 'phone', 'dt' => 1),
            array('db' => 'city', 'dt' => 2),
            array('db' => 'address', 'dt' => 3),

            array(
                'db'        => 'id',
                'dt'        => 4,
                'formatter' => function($id, $row ) {
                    if ($this->permit('visible',$this->folder)) {
                    return "
                <div style='text-align: center'>
                  <input {$this->ch_type_customer($id)}  class='toggle-demo'  type='checkbox'  onchange='type_customer(this,{$id})'  data-toggle='toggle' data-on='مقتنع' data-off='غير مقتنع' data-onstyle='success' data-offstyle='danger'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),

            array('db' => 'id', 'dt' =>5,
                'formatter' => function ($id, $row) {
                    return  "<a   target='_blank' class='btn btn-info btn-sm' href=' ".  url .'/'.$this->folder ."/account_customer/{$id}'>  <i class='fa fa-sign-in'></i>  <span>دخول بحساب الزبون</span></a>" ;
                }

            ),

            array('db' => 'date', 'dt' => 6,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:s:i A',$id);
                }
            ),


            array('db' => 'id', 'dt' =>7,
                'formatter' => function ($id, $row) {
                    return  "<a  href=' ".  url .'/'.$this->folder ."/details_client/{$id}'>{$this->langControl('details')}</a>" ;
                }

            ),

            array('db' => 'id', 'dt' => 8,
                'formatter' => function ($id, $row) {
                    return  "<a href=' ".  url .'/'.$this->folder ."/view_req/{$id}'>{$this->notification_buy($id)}</a>" ;
                }

            ),

            array(
                'db' => 'id',
                'dt' => 9,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', 'registration')) {
                        return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array('db' => 'id', 'dt' => 10)



        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        if ($year == 0) {
            echo json_encode(
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"`type_customer_12` =2" )
            );
        }
        else
        {
        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, " year ={$year} AND `type_customer_12` =2")
        );
    }


    }





    function account_customer($id)
    {
        if ($this->handleLogin())
        {

            $this->logoutNow();
            $stmt=$this->db->prepare("SELECT *FROM `register_user` WHERE `id`=? ");
            $stmt->execute(array($id));
            if ($stmt->rowCount()>0)
            {
                $result=$stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['username_member_r'] = $result['phone'];
                $_SESSION['id_member_r'] =  $result['id'];
                $_SESSION['name_r'] = $result['name'];
                $_SESSION['typeLogin'] = $result['login'];
                setcookie("setLogin", openssl_encrypt($_SESSION['username_member_r'],"AES-128-ECB",HASH_PASSWORD_KEY).'#|'. $_SESSION['id_member_r'] ,time() + 31556926 , "/");

              $this->lightRedirect(url,0);
            }else{
                $this->lightRedirect(url.'/home',0);
            }
        }


    }






    public function ch_type_customer($id)
    {
        if ($this->handleLogin()) {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `type_customer_12` = 1 ");
            $stmt->execute(array($id));
            if ($stmt->rowCount() > 0) {
                return 'checked';
            } else {
                return '';
            }
        }
    }


    function visible_wholesale_price($v_,$id_)
    {
        if ($this->handleLogin()) {
            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }
            $data = $this->db->update($this->table, array('wholesale_price' => $v,'active_wholesale_price' => $v), "`id`={$id}");
        }
    }


   public function notification_buy($id)
   {
       $stmt = $this->db->prepare("SELECT * FROM  `cart_shop_active`  WHERE `id_member_r` = ? AND `buy` = 1 AND  `status` = 0  ");
       $stmt->execute(array($id));
       $number_of_rows = $stmt->fetchColumn();

       if ($number_of_rows > 0)
       {
           return '<i style="color: red" class="fa fa-bell"></i>';
       }else
       {
           return '<i style="color: lightgrey" class="fa fa-bell"></i>';
       }
   }



    public function all_notification_buy()
    {
        $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `buy` = 1 AND  `status` = 0  GROUP BY `id_member_r`");
        $stmt->execute();
        $count_active=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $count_active[]=$row;
        }
        return count($count_active);

    }




    public  function details()
    {
        if (isset($_SESSION['username_member_r'])) {
            $id_user = $_SESSION['id_member_r'];


           $stmt = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE `id` = ?    LIMIT 1");
            $stmt->execute(array($_SESSION['id_member_r']));
            $result = $stmt->fetch();

            $mobile=new mobile();

            $stmt=$mobile->getAllContentFromCar($_SESSION['id_member_r']);
            $request=array();

            $sum=0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $table=$row['table'];
                $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
                $stmt_get_item->execute(array($row['id_item']));
                $item = $stmt_get_item->fetch();

                $row['title']=$item['title'];
                $row['img']=$this->save_file.$row['image'];


                if ($row['table'] == 'medical_supplies') {

                    $stmt_id_catg_c = $this->db->prepare("SELECT `id_cat` FROM `medical_supplies` WHERE `id` = ?  LIMIT 1");
                    $stmt_id_catg_c->execute(array($row['id_item']));
                    $id_catgC=$stmt_id_catg_c->fetch(PDO::FETCH_ASSOC)['id_cat'];

                    $stmt_id_catg_title = $this->db->prepare("SELECT `title` FROM `medical_supplies` WHERE `id` = ?  LIMIT 1");
                    $stmt_id_catg_title->execute(array($id_catgC));

                    $row['title']=$stmt_id_catg_title->fetch(PDO::FETCH_ASSOC)['title'] .'  -  '. $item['title']  ;

                    $row['price']= $row['price']. ' د.ع ';
                    $row['color_name']='';

                }

                if ($row['table'] == 'mobile') {

                    $stmt_color = $this->db->prepare("SELECT `color` FROM `color` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $row['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $row['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }



                }


                if ($row['table'] == 'camera') {
                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_camera`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $row['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $row['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }

                }

                if ($row['table'] == 'printing_supplies') {
                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_printing_supplies`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $row['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $row['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }

                }

                if ($row['table'] == 'computer') {
                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_computer`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $row['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $row['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }

                }



                if ($row['table'] == 'games') {


                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];
                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_games`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $row['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $row['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }



                }


                if ($row['table'] == 'network') {


                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];
                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_network`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $row['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $row['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }





                }



                if ($row['table'] == 'accessories') {

                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_accessories`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $row['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $row['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }

                }


                if ($row['table'] == 'product_savers') {

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_savers`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);
                    $row['color_name']=$row['name_color'];
                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $row['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $row['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }


                }


                $request[]=$row;
            }





             $stmt=$mobile->getAllContentFromCar_old($_SESSION['id_member_r']);
            $request_old=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $table=$row['table'];
                $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
                $stmt_get_item->execute(array($row['id_item']));
                $item = $stmt_get_item->fetch();
                $row['title']=$item['title'];
                $row['img']=$this->save_file.$row['image'];


                if ($row['table'] == 'medical_supplies') {

                    $stmt_id_catg_c = $this->db->prepare("SELECT `id_cat` FROM `medical_supplies` WHERE `id` = ?  LIMIT 1");
                    $stmt_id_catg_c->execute(array($row['id_item']));
                    $id_catgC=$stmt_id_catg_c->fetch(PDO::FETCH_ASSOC)['id_cat'];

                    $stmt_id_catg_title = $this->db->prepare("SELECT `title` FROM `medical_supplies` WHERE `id` = ?  LIMIT 1");
                    $stmt_id_catg_title->execute(array($id_catgC));

                    $row['title']=$stmt_id_catg_title->fetch(PDO::FETCH_ASSOC)['title'] .'  -  '. $item['title']  ;

                    $row['price']= $row['price']. ' د.ع ';
                    $row['color_name']='';
                }

                if ($row['table'] == 'mobile') {

                    $stmt_color = $this->db->prepare("SELECT `color` FROM `color` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $row['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $row['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }

                }


                if ($row['table'] == 'camera') {

                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_camera`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $row['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $row['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }

                }



                if ($row['table'] == 'printing_supplies') {

                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_printing_supplies`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $row['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $row['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }

                }



                if ($row['table'] == 'computer') {

                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_computer`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $row['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $row['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }

                }



                if ($row['table'] == 'games') {

                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];
                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_games`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $row['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $row['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }



                }


                if ($row['table'] == 'network') {


                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];
                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_network`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $row['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $row['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }




                }



                if ($row['table'] == 'accessories') {

                    $color_table='color_'.$row['table'];
                    $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                    $stmt_color->execute(array($row['image']));
                    $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_accessories`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $row['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $row['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }

                }


                if ($row['table'] == 'product_savers') {


                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_savers`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);
                    $row['color_name']=$row['name_color'];
                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $row['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $row['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
                    }

                }


                $request_old[]=$row;
            }

            require($this->render($this->folder, 'html', 'details', 'php'));
        } else {
            require($this->render($this->folder, 'html', 'login', 'php'));
        }
    }


    public  function view_req($id)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('view_request','register');
        $this->adminHeaderController($this->langControl('view_request'),$id);



        $stmt=$this->db->prepare("SELECT *FROM `register_answer` WHERE `id_user`=?");
        $stmt->execute(array($id));
        $answer=$stmt->fetch(PDO::FETCH_ASSOC);


            $id_user = $id;
            $stmt = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE id = ?    LIMIT 1");
            $stmt->execute(array($id_user));
            $result = $stmt->fetch();

        $mobile=new mobile();

        $stmt=$mobile->getAllContentFromCar($id);
        $request=array();

        $sum=0;
        $date_req=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $table=$row['table'];
            $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
            $stmt_get_item->execute(array($row['id_item']));
            $item = $stmt_get_item->fetch();

            $row['title']=$item['title'];
            $row['img']=$this->save_file.$row['image'];

            $date_req[$row['date_req']]=$row['date_req'];

            if ($row['table'] == 'medical_supplies') {

                $stmt_id_catg_c = $this->db->prepare("SELECT `id_cat` FROM `medical_supplies` WHERE `id` = ?  LIMIT 1");
                $stmt_id_catg_c->execute(array($row['id_item']));
                $id_catgC=$stmt_id_catg_c->fetch(PDO::FETCH_ASSOC)['id_cat'];

                $stmt_id_catg_title = $this->db->prepare("SELECT `title` FROM `medical_supplies` WHERE `id` = ?  LIMIT 1");
                $stmt_id_catg_title->execute(array($id_catgC));

                $row['title']=$stmt_id_catg_title->fetch(PDO::FETCH_ASSOC)['title'] .'  -  '. $item['title']  ;

                $row['price']= $row['price']. ' د.ع ';
                $row['color_name']='';
            }

            if ($row['table'] == 'mobile') {

                $stmt_color = $this->db->prepare("SELECT `color` FROM `color` WHERE `img` = ?  LIMIT 1");
                $stmt_color->execute(array($row['image']));
                $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                $stmt_price = $this->db->prepare("SELECT  *FROM   `excel`  WHERE  `code`=?  ");
                $stmt_price->execute(array($row['code']));
                $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                if (isset($_COOKIE['currency']) )
                {
                    if ($_COOKIE['currency'] == 0)
                    {
                        $row['price']= $row['price'] .' د.ع ';
                    }else
                    {
                        $row['price']= $row['price_dollars'] .'$ ';
                    }
                }else
                {
                    $row['price']= $row['price'].' د.ع ';
                }


            }


            if ($row['table'] == 'camera') {

                $color_table='color_'.$row['table'];
                $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                $stmt_color->execute(array($row['image']));
                $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_camera`  WHERE  `code`=?  ");
                $stmt_price->execute(array($row['code']));
                $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                if (isset($_COOKIE['currency']) )
                {
                    if ($_COOKIE['currency'] == 0)
                    {
                        $row['price']= $row['price'] .' د.ع ';
                    }else
                    {
                        $row['price']= $row['price_dollars'] .'$ ';
                    }
                }else
                {
                    $row['price']= $row['price'].' د.ع ';
                }



            }



            if ($row['table'] == 'printing_supplies') {

                $color_table='color_'.$row['table'];
                $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                $stmt_color->execute(array($row['image']));
                $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_printing_supplies`  WHERE  `code`=?  ");
                $stmt_price->execute(array($row['code']));
                $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                if (isset($_COOKIE['currency']) )
                {
                    if ($_COOKIE['currency'] == 0)
                    {
                        $row['price']= $row['price'] .' د.ع ';
                    }else
                    {
                        $row['price']= $row['price_dollars'] .'$ ';
                    }
                }else
                {
                    $row['price']= $row['price'].' د.ع ';
                }



            }


            if ($row['table'] == 'computer') {

                $color_table='color_'.$row['table'];
                $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                $stmt_color->execute(array($row['image']));
                $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_computer`  WHERE  `code`=?  ");
                $stmt_price->execute(array($row['code']));
                $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                if (isset($_COOKIE['currency']) )
                {
                    if ($_COOKIE['currency'] == 0)
                    {
                        $row['price']= $row['price'] .' د.ع ';
                    }else
                    {
                        $row['price']= $row['price_dollars'] .'$ ';
                    }
                }else
                {
                    $row['price']= $row['price'].' د.ع ';
                }



            }



            if ($row['table'] == 'games') {
                $color_table='color_'.$row['table'];
                $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                $stmt_color->execute(array($row['image']));
                $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];
                $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_games`  WHERE  `code`=?  ");
                $stmt_price->execute(array($row['code']));
                $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                if (isset($_COOKIE['currency']) )
                {
                    if ($_COOKIE['currency'] == 0)
                    {
                        $row['price']= $row['price'] .' د.ع ';
                    }else
                    {
                        $row['price']= $row['price_dollars'] .'$ ';
                    }
                }else
                {
                    $row['price']= $row['price'].' د.ع ';
                }


            }


            if ($row['table'] == 'network') {
                $color_table='color_'.$row['table'];
                $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                $stmt_color->execute(array($row['image']));
                $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];
                $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_network`  WHERE  `code`=?  ");
                $stmt_price->execute(array($row['code']));
                $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                if (isset($_COOKIE['currency']) )
                {
                    if ($_COOKIE['currency'] == 0)
                    {
                        $row['price']= $row['price'] .' د.ع ';
                    }else
                    {
                        $row['price']= $row['price_dollars'] .'$ ';
                    }
                }else
                {
                    $row['price']= $row['price'].' د.ع ';
                }




            }



            if ($row['table'] == 'accessories') {

                $color_table='color_'.$row['table'];
                $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                $stmt_color->execute(array($row['image']));
                $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_accessories`  WHERE  `code`=?  ");
                $stmt_price->execute(array($row['code']));
                $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                if (isset($_COOKIE['currency']) )
                {
                    if ($_COOKIE['currency'] == 0)
                    {
                        $row['price']= $row['price'] .' د.ع ';
                    }else
                    {
                        $row['price']= $row['price_dollars'] .'$ ';
                    }
                }else
                {
                    $row['price']= $row['price'].' د.ع ';
                }

            }


            if ($row['table'] == 'product_savers') {

                $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_savers`  WHERE  `code`=?  ");
                $stmt_price->execute(array($row['code']));
                $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);
                $row['color_name']=$row['name_color'];
                if (isset($_COOKIE['currency']) )
                {
                    if ($_COOKIE['currency'] == 0)
                    {
                        $row['price']= $row['price'] .' د.ع ';
                    }else
                    {
                        $row['price']= $row['price_dollars'] .'$ ';
                    }
                }else
                {
                    $row['price']= $row['price'].' د.ع ';
                }

            }


            $request[]=$row;
        }
       $date_req=json_encode($date_req);




        $groups=array();
        $stmt_groups =$this->db->prepare("SELECT *FROM `usergroup` WHERE `name` LIKE '%توصيل%' ");
        $stmt_groups->execute();
        while ($row = $stmt_groups->fetch(PDO::FETCH_ASSOC))
        {

                $groups[]= $row;


        }



        require($this->render($this->folder, 'html', 'view_req', 'php'));
        $this->adminFooterController();
    }


    public  function view_req2($id,$bill)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('delivered','delivery_user');
        $this->adminHeaderController($this->langControl('view_request'),$id);





        $stmt=$this->db->prepare("SELECT *FROM `register_answer` WHERE `id_user`=?");
        $stmt->execute(array($id));
        $answer=$stmt->fetch(PDO::FETCH_ASSOC);




        $infoOrder=$this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `id_member_r`=? AND `number_bill`=?");
        $infoOrder->execute(array($id,$bill));
        $dataOrder=$infoOrder->fetch(PDO::FETCH_ASSOC);


            $id_user = $id;
            $stmt = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE id = ?    LIMIT 1");
            $stmt->execute(array($id_user));
            $result = $stmt->fetch();

        $mobile=new mobile();

        $stmt=$mobile->getAllContentFromCarMost_req($id,$bill);
        $request=array();

        $sum=0;
        $date_req=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $table=$row['table'];
            $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
            $stmt_get_item->execute(array($row['id_item']));
            $item = $stmt_get_item->fetch();

            $row['title']=$item['title'];
            $row['img']=$this->save_file.$row['image'];

            $date_req[$row['date_req']]=$row['date_req'];

            if ($row['table'] == 'medical_supplies') {

                $stmt_id_catg_c = $this->db->prepare("SELECT `id_cat` FROM `medical_supplies` WHERE `id` = ?  LIMIT 1");
                $stmt_id_catg_c->execute(array($row['id_item']));
                $id_catgC=$stmt_id_catg_c->fetch(PDO::FETCH_ASSOC)['id_cat'];

                $stmt_id_catg_title = $this->db->prepare("SELECT `title` FROM `medical_supplies` WHERE `id` = ?  LIMIT 1");
                $stmt_id_catg_title->execute(array($id_catgC));

                $row['title']=$stmt_id_catg_title->fetch(PDO::FETCH_ASSOC)['title'] .'  -  '. $item['title']  ;

                $row['price']= $row['price']. ' د.ع ';
                $row['color_name']='';
            }

            if ($row['table'] == 'mobile') {

                $stmt_color = $this->db->prepare("SELECT `color` FROM `color` WHERE `img` = ?  LIMIT 1");
                $stmt_color->execute(array($row['image']));
                $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                $stmt_price = $this->db->prepare("SELECT  *FROM   `excel`  WHERE  `code`=?  ");
                $stmt_price->execute(array($row['code']));
                $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                if (isset($_COOKIE['currency']) )
                {
                    if ($_COOKIE['currency'] == 0)
                    {
                        $row['price']= $row['price'] .' د.ع ';
                    }else
                    {
                        $row['price']= $row['price_dollars'] .'$ ';
                    }
                }else
                {
                    $row['price']= $row['price'].' د.ع ';
                }


            }


            if ($row['table'] == 'camera') {

                $color_table='color_'.$row['table'];
                $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                $stmt_color->execute(array($row['image']));
                $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_camera`  WHERE  `code`=?  ");
                $stmt_price->execute(array($row['code']));
                $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                if (isset($_COOKIE['currency']) )
                {
                    if ($_COOKIE['currency'] == 0)
                    {
                        $row['price']= $row['price'] .' د.ع ';
                    }else
                    {
                        $row['price']= $row['price_dollars'] .'$ ';
                    }
                }else
                {
                    $row['price']= $row['price'].' د.ع ';
                }



            }


            if ($row['table'] == 'printing_supplies') {

                $color_table='color_'.$row['table'];
                $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                $stmt_color->execute(array($row['image']));
                $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_printing_supplies`  WHERE  `code`=?  ");
                $stmt_price->execute(array($row['code']));
                $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                if (isset($_COOKIE['currency']) )
                {
                    if ($_COOKIE['currency'] == 0)
                    {
                        $row['price']= $row['price'] .' د.ع ';
                    }else
                    {
                        $row['price']= $row['price_dollars'] .'$ ';
                    }
                }else
                {
                    $row['price']= $row['price'].' د.ع ';
                }



            }
            if ($row['table'] == 'computer') {

                $color_table='color_'.$row['table'];
                $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                $stmt_color->execute(array($row['image']));
                $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_computer`  WHERE  `code`=?  ");
                $stmt_price->execute(array($row['code']));
                $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                if (isset($_COOKIE['currency']) )
                {
                    if ($_COOKIE['currency'] == 0)
                    {
                        $row['price']= $row['price'] .' د.ع ';
                    }else
                    {
                        $row['price']= $row['price_dollars'] .'$ ';
                    }
                }else
                {
                    $row['price']= $row['price'].' د.ع ';
                }



            }



            if ($row['table'] == 'games') {
                $color_table='color_'.$row['table'];
                $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                $stmt_color->execute(array($row['image']));
                $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];
                $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_games`  WHERE  `code`=?  ");
                $stmt_price->execute(array($row['code']));
                $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                if (isset($_COOKIE['currency']) )
                {
                    if ($_COOKIE['currency'] == 0)
                    {
                        $row['price']= $row['price'] .' د.ع ';
                    }else
                    {
                        $row['price']= $row['price_dollars'] .'$ ';
                    }
                }else
                {
                    $row['price']= $row['price'].' د.ع ';
                }


            }


            if ($row['table'] == 'network') {
                $color_table='color_'.$row['table'];
                $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                $stmt_color->execute(array($row['image']));
                $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];
                $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_network`  WHERE  `code`=?  ");
                $stmt_price->execute(array($row['code']));
                $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                if (isset($_COOKIE['currency']) )
                {
                    if ($_COOKIE['currency'] == 0)
                    {
                        $row['price']= $row['price'] .' د.ع ';
                    }else
                    {
                        $row['price']= $row['price_dollars'] .'$ ';
                    }
                }else
                {
                    $row['price']= $row['price'].' د.ع ';
                }




            }



            if ($row['table'] == 'accessories') {

                $color_table='color_'.$row['table'];
                $stmt_color = $this->db->prepare("SELECT `color` FROM `{$color_table}` WHERE `img` = ?  LIMIT 1");
                $stmt_color->execute(array($row['image']));
                $row['color_name']=$stmt_color->fetch(PDO::FETCH_ASSOC)['color'];

                $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_accessories`  WHERE  `code`=?  ");
                $stmt_price->execute(array($row['code']));
                $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                if (isset($_COOKIE['currency']) )
                {
                    if ($_COOKIE['currency'] == 0)
                    {
                        $row['price']= $row['price'] .' د.ع ';
                    }else
                    {
                        $row['price']= $row['price_dollars'] .'$ ';
                    }
                }else
                {
                    $row['price']= $row['price'].' د.ع ';
                }

            }


            if ($row['table'] == 'product_savers') {

                $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_savers`  WHERE  `code`=?  ");
                $stmt_price->execute(array($row['code']));
                $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);
                $row['color_name']=$row['name_color'];
                if (isset($_COOKIE['currency']) )
                {
                    if ($_COOKIE['currency'] == 0)
                    {
                        $row['price']= $row['price'] .' د.ع ';
                    }else
                    {
                        $row['price']= $row['price_dollars'] .'$ ';
                    }
                }else
                {
                    $row['price']= $row['price'].' د.ع ';
                }

            }


            $request[]=$row;
        }
       $date_req=json_encode($date_req);



        require($this->render($this->folder, 'html', 'view_req2', 'php'));
        $this->adminFooterController();
    }



    public  function details_client($id,$id_user_direct=null)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('details_client','register');
        $this->adminHeaderController($this->langControl('view_request'),$id);

        $id_user = $id;
        $stmt = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE id = ?    LIMIT 1");
        $stmt->execute(array($id_user));
        $result = $stmt->fetch();

        $stmt=$this->db->prepare("SELECT *FROM `register_answer` WHERE `id_user`=?");
        $stmt->execute(array($id));
        $answer=$stmt->fetch(PDO::FETCH_ASSOC);


        $mobile=new mobile();


        $date=null;
        $todate=null;

        $from_date_stm=null;
        $to_date_stm=null;

        if (isset($_GET['date'])&&isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);

        }


        if ($from_date_stm && $to_date_stm)
        {

            $stmt_date_req_done = $this->db->prepare("SELECT   * FROM `cart_shop_active` WHERE `id_member_r` =? AND date_req BETWEEN  ? AND ? AND   `buy` = 2 AND   `accountant` = 1 AND cancel=0    GROUP BY `number_bill`   ORDER BY `number_bill` DESC ");
            $stmt_date_req_done->execute(array($id,$from_date_stm,$to_date_stm));
        }else
        {
            $stmt_date_req_done = $this->db->prepare("SELECT  *  FROM `cart_shop_active` WHERE `id_member_r` =?  AND   `buy` = 2 AND   `accountant` = 1 AND cancel=0  GROUP BY `number_bill`    ORDER BY `number_bill` DESC ");
            $stmt_date_req_done->execute(array($id));

        }


//
//
//        if ($id_user_direct)
//        {
//
//            if ($from_date_stm && $to_date_stm)
//            {
//
//                $stmt_date_req_done = $this->db->prepare("SELECT   * FROM `cart_shop_active` WHERE `id_member_r` =? AND date_req BETWEEN  ? AND ? AND   `buy` = 2 AND   `accountant` = 1 AND cancel=0  AND user_direct = ? GROUP BY `number_bill`   ORDER BY `number_bill` DESC ");
//                $stmt_date_req_done->execute(array($id,$from_date_stm,$to_date_stm,$id_user_direct));
//            }else
//            {
//                $stmt_date_req_done = $this->db->prepare("SELECT  *  FROM `cart_shop_active` WHERE `id_member_r` =?  AND   `buy` = 2 AND   `accountant` = 1 AND cancel=0  GROUP BY `number_bill` AND user_direct = ?  ORDER BY `number_bill` DESC ");
//                $stmt_date_req_done->execute(array($id,$id_user_direct));
//            }
//        }else
//        {
//
//
//        }



        $date_req_done=array();
        while ($row_d =$stmt_date_req_done->fetch(PDO::FETCH_ASSOC))
        {


            $row_d[$row_d['number_bill']]=array();
            $xp1Offer=0;
            $stmt = $this->db->prepare("SELECT  cart_shop_active.* ,SUM(`number`)as number FROM `cart_shop_active` WHERE `id_member_r` =?  AND `number_bill`= ? AND   `buy` = 2 AND   `accountant` = 1 AND cancel=0 GROUP BY `id_item`,`table`,`code`,`number_bill`   ");
            $stmt->execute(array($id, $row_d['number_bill']));

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {

                $table=$row['table'];
                $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
                $stmt_get_item->execute(array($row['id_item']));
                $item = $stmt_get_item->fetch();

                $row['title']=$item['title'];
                $row['img']=$this->save_file.$row['image'];

                $table=$row['table'];
                $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
                $stmt_get_item->execute(array($row['id_item']));
                $item = $stmt_get_item->fetch();

                $row['title']=$item['title'];
                $row['img']=$this->save_file.$row['image'];

                    if ($this->check_item_round($row['table'],$row['id_item'])) {
                        $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
                        $row['price']= $price;
                    }else
                    {
                        $price = $this->not_round_price($row['price_dollars'], $row['dollar_exchange']);
                        $row['price']= $price;
                    }

                    $f1 = (int)trim(str_replace($this->comma, '', $price));
                    $xp1Offer = $xp1Offer + ($f1 * $row['number']);
                    $price1_normal= ($xp1Offer);


                $row_d[$row_d['number_bill']][]=$row;
            }
            $date_req_done[]=$row_d;
        }





        if ($from_date_stm && $to_date_stm)
        {

            $stmt_date_req_done = $this->db->prepare("SELECT   * FROM `cart_shop_active` WHERE `id_member_r` =? AND date_req BETWEEN  ? AND ? AND   `buy` = 3 AND   cancel=1   GROUP BY `number_bill`   ORDER BY `number_bill` DESC ");
            $stmt_date_req_done->execute(array($id,$from_date_stm,$to_date_stm));
        }else
        {
            $stmt_date_req_done = $this->db->prepare("SELECT  *  FROM `cart_shop_active` WHERE `id_member_r` =?  AND   `buy` = 3 AND cancel=1  GROUP BY `number_bill`    ORDER BY `number_bill` DESC ");
            $stmt_date_req_done->execute(array($id));
        }


        $date_req_reject=array();
        while ($row_r =$stmt_date_req_done->fetch(PDO::FETCH_ASSOC))
        {
            $xp1Offer=0;
            $row_r[$row_r['number_bill']]=array();

            $stmt = $this->db->prepare("SELECT  cart_shop_active.* ,SUM(`number`)as number FROM `cart_shop_active` WHERE `id_member_r` =?  AND `number_bill`= ? AND   `buy` = 3  AND cancel=1 GROUP BY `id_item`,`table`,`code`,`number_bill`   ");
            $stmt->execute(array($id, $row_r['number_bill']));

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $table=$row['table'];
                $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
                $stmt_get_item->execute(array($row['id_item']));
                $item = $stmt_get_item->fetch();

                $row['title']=$item['title'];
                $row['img']=$this->save_file.$row['image'];


                if ($this->check_item_round($row['table'],$row['id_item'])) {
                    $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
                    $row['price']= $price;
                }else
                {
                    $price = $this->not_round_price($row['price_dollars'], $row['dollar_exchange']);
                    $row['price']= $price;
                }

                $f1 = (int)trim(str_replace($this->comma, '', $price));
                $xp1Offer = $xp1Offer + ($f1 * $row['number']);
                $price1_normal= ($xp1Offer);

                $row_r[$row_r['number_bill']][]=$row;
            }


            $date_req_reject[]=$row_r;

        }




        require($this->render($this->folder, 'html', 'details_client', 'php'));
        $this->adminFooterController();
    }








    function user_delivery($id)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        if ($this->handleLogin())
        {

            $stmt_groups =$this->db->prepare("SELECT *FROM `user` WHERE `idGroup` = ? ");
            $stmt_groups->execute(array($id));
            $html='';$c=0;
            while ($row = $stmt_groups->fetch(PDO::FETCH_ASSOC))
            {
                if ($c==0)
                {
                    $html.='<option value="'.$row['id'].'"  selected  >'.$row['username'].'</option>';

                }else
                {
                    $html.='<option value="'.$row['id'].'" >'.$row['username'].'</option>';

                }
                $c++;
            }

            echo $html;
        }


    }



    public function all_active_buy()
    {

        $this->checkPermit('view_request','register');
        $this->adminHeaderController($this->langControl('view_request'));
        $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `buy` = 1 AND  `status` = 0 GROUP BY `id_member_r`  ORDER BY `date_req` ASC ");
        $stmt->execute();
        $count_active=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $stmt_user = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE id = ? ");
            $stmt_user->execute(array($row['id_member_r']));

            while ($row_user =$stmt_user->fetch(PDO::FETCH_ASSOC))
            {
                $count_active[]=$row_user;
            }

        }

        require($this->render($this->folder, 'html', 'active', 'php'));

        $this->adminFooterController();

    }



            function checkLoginData($id)
            {
                $stmt = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE `id` = ?    ");
                $stmt->execute(array($id));
                if ($stmt->rowCount()>0)
                {
                    return 'true';
                }else
                {
                    return 'false';

                }
            }


    function getDetails($id)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `id` = ?  ");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);



        $table=$result['table'];
        $result2=$this->db->select("SELECT * from `{$table}` WHERE `id`=:id  AND `active` =:active LIMIT 1 ",array(':id'=>$result['id_item'],':active'=>1));
        if (empty($result2))
        {
            $error=new Errors(); $error->index();
        }
        $result2=$result2[0];
        $result['title']=$result2['title'];
        $result['image']  = $this->save_file.$result['image'];


        require($this->render($this->folder, 'html', 'ajax', 'php'));


    }
    function empty_car()
    {

            if(!$this->isDirect())
            {
                $id_member_r = $_SESSION['id_member_r'];
            }else{
                $id_member_r = $this->isUuid();
            }

    		$stmt_id_cart = $this->db->prepare("SELECT id FROM {$this->cart_shop_active}  WHERE   `id_member_r` = ?   AND accountant=0  AND `buy` = 0  ");
            $stmt_id_cart->execute(array($id_member_r));
            // $row = $stmt_id_cart->fetch(PDO::FETCH_ASSOC);
            while ($row = $stmt_id_cart->fetch(PDO::FETCH_ASSOC))
            {
                $id_cart =   $row['id'];
                $stmt_delete = $this->db->prepare( "DELETE FROM `type_device_customer` WHERE  `id_shop_cart` = ? ");
                $stmt_delete->execute(array($id_cart));
            }

        $stmt = $this->db->prepare( "DELETE FROM  cart_shop_active WHERE  `id_member_r` = ? AND accountant=0  AND `buy` = 0   ");
        $stmt->execute(array($id_member_r));
        if ($stmt->rowCount() > 0)
        {
            echo 'true';
        }




    }

    function dlt_item($id,$id_c,$id_offer)
    {

        if(!$this->isDirect())
        {
            $id_member_r = $_SESSION['id_member_r'];
        }else{
            $id_member_r = $this->isUuid();
        }

			$stmt_delete = $this->db->prepare( "DELETE FROM `type_device_customer` WHERE  `id_shop_cart` = ? ");
            $stmt_delete->execute(array($id_c));
        if ($id_offer)
        {

            $stmt = $this->db->prepare( "DELETE FROM {$this->cart_shop_active} WHERE  `id_member_r` = ?   AND `id_offer` = ? AND accountant=0  AND `buy` = 0   ");
            $stmt->execute(array($id_member_r,$id_offer));
            if ($stmt->rowCount() > 0)
            {

                $stmt_d = $this->db->prepare("SELECT  *FROM {$this->cart_shop_active}  WHERE   `id_member_r` = ?   AND `id_offer` = ? AND accountant=0  AND `buy` = 0  ");
                $stmt_d->execute(array($id_member_r,$id_offer));
                if ($stmt_d->rowCount() > 0)
                {
                    echo 'true';

                }else{
                    echo 'empty';
                }


            }

        }else{



            $stmt = $this->db->prepare( "DELETE FROM {$this->cart_shop_active} WHERE  `id_member_r` = ?   AND `id_item` = ?  AND `id`=? AND accountant=0  AND `buy` = 0");
            $stmt->execute(array($id_member_r,$id,$id_c));
            if ($stmt->rowCount() > 0)
            {

                $stmt_d = $this->db->prepare("SELECT  *FROM {$this->cart_shop_active}  WHERE   `id_member_r` = ?  AND  accountant=0  AND `buy` = 0  ");
                $stmt_d->execute(array($id_member_r));
                if ($stmt_d->rowCount() > 0)
                {
                    echo 'true';

                }else{
                    echo 'empty';
                }


            }

        }




    }



    function phone()
    {
        if (isset($_SESSION['username_member_r'])) {
            $id_user = $_SESSION['id_member_r'];

            if (isset($_POST['submit']))
            {
                $data['phone']=$_POST['phone'];

                 if ($_SESSION['typeLogin'] == 'facebook') {
                     $data['city'] = $_POST['city'];
                     $data['address'] = $_POST['address'];
                 }
                $stmt = $this->db->update($this->table, $data,"id={$id_user}");
                if ($stmt)
                {
                    echo 'true';
                }
             }
            else
            {
                echo 'false';
            }

        }
    }


    function delete_registration($id)
    {
        if ($this->handleLogin()) {
         $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE  `id` = ?   ");
         $stmt->execute(array($id));
         if ($stmt->rowCount() > 0) {
            echo 'true';
         }
      }
    }



    public function note($id)
    {

        if($this->handleLogin())
        {

            if (isset($_POST['submit']))
            {
                 $note=strip_tags(trim($_POST['note']));

                $stmt = $this->db->prepare("UPDATE  `{$this->table}`  SET   `note` = ? WHERE     `id` = ? ");
                $stmt->execute(array($note,$id));
                if ($stmt->rowCount() > 0 )
                {
                    echo 'true';
                }else
                {
                    echo 'false';
                }


            }else{
                echo 'false';
            }

        }else{
            echo 'false';
        }




    }




    public function delete_note($id)
    {

        if($this->handleLogin()) {


            $note = strip_tags(trim($_POST['note']));

            $stmt = $this->db->prepare("UPDATE  `{$this->table}`  SET   `note` = '' WHERE     `id` = ? ");
            $stmt->execute(array($id));
            if ($stmt->rowCount() > 0) {
                echo 'true';
            } else {
                echo 'false';
            }

        }

    }





    function search_live()
    {
        $this->checkPermit('chat','chat');
        $q=strip_tags(trim($_GET["q"]));

        $q = '%' . $q . '%';

        $stmt = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE `name` LIKE ? OR `phone` LIKE  ? ");
        $stmt->execute(array($q,$q));

        $idU=array();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $idU[]= $row['id'];
            }


        $idU=implode(',',$idU);
        $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `buy` = 1 AND  `status` = 0   AND `id_member_r` IN ($idU)   GROUP BY `id_member_r`  ORDER BY `date_req` ASC ");
        $stmt->execute();
        $count_active=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $stmt_user = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE id = ? ");
            $stmt_user->execute(array($row['id_member_r']));

            while ($row_user =$stmt_user->fetch(PDO::FETCH_ASSOC))
            {
                $count_active[]=$row_user;
            }

        }

        require($this->render($this->folder, 'html', 'active_ajax', 'php'));
       }else{
            echo '0';
        }
    }

/*
    function chg()
    {


       $code=array(
            2620,
            2649,
            2657,
            2717,
            2805,
            2815,
            2825,
            2828,
            2829,
            2832,
            2833,
            2834,
            2837,
            2840,
            2841,
            2843,
            2847,
            2848,
            2849,
            2850,
            2851,
            2852,
            2853,
            2854,
            2855,
            2856,
            2857,
            2859,
            2860,
            2861,
            2862,
            2863,
            2864,
            2866,
            2867,
            2868,
            2869,
            2870,
            2871,
            2873,
            2875,
            2876,
            2877,
            2878,
            2879,
            2880,
            2881,
            2882,
            2883,
            2884,
            2885,
            2886,
            2887,
            2888,
            2889,
            2890,
            2891,
            2892,
            2893,
            2894,
            2895,
            2896,
            2898,
            2899,
            2900,
            2901
        );
        $cde = implode(',', $code);
        $stmt = $this->db->prepare("UPDATE `cart_shop_active` SET `delivered`=1, `delivered_date` = ?  WHERE  `buy` = 2 AND `status`=1 AND `number_bill` NOT IN ($cde)");
        $stmt->execute(array(time()));

        if ($stmt->rowCount()>0)
        {
            echo 1;
        }else
        {
            echo 0;
        }


    }

*/



function  resetpassword()
{



    require($this->render($this->folder, 'html', 'resetpassword', 'php'));
}


function checkphone()
{


      $phone=strip_tags(trim($_GET['phone']));
    $stmt=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE `phone`=?");
    $stmt->execute(array($phone));
    if ($stmt->rowCount() > 0)
    {
     echo 'true';
    }else
    {
      echo 'false';
    }


}


function hashalixcol()

{

     $key=strip_tags(trim($_POST['alixcolrndid']));
     $phone=  strip_tags(trim($_POST['alixcolph']));

       $_SESSION['uid']=$key;
       $_SESSION['reset_phone']=$phone;


    $stmt=$this->db->prepare("UPDATE  `{$this->table}` SET `hashphone`=?  WHERE `phone`=?");
    $stmt->execute(array($key,$phone));
    if ($stmt->rowCount() > 0)
    {

        echo 'true';
    }


}


            function reset_password()
            {

                if (isset($_POST['submit'])) {


                    $password = strip_tags(trim($_POST['password']));

                    $stmt = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE `phone` = ?    LIMIT 1");

                    $stmt->execute(array($_SESSION['reset_phone']));
                    $result = $stmt->fetch();



                    $pass = $this->HASH_key('sha256', $password . $result['date'], HASH_PASSWORD_KEY);
                    $stmt2 = $this->db->prepare("UPDATE  `{$this->table}` SET `password`=?  WHERE `phone`=? AND `hashphone`=?");
                    $stmt2->execute(array($pass, $_SESSION['reset_phone'], $_SESSION['uid']));


                        $stmt3 = $this->db->prepare("UPDATE  `{$this->table}` SET `hashphone`=''  WHERE `phone`=? AND `hashphone`=?");
                        $stmt3->execute(array($_SESSION['reset_phone'], $_SESSION['uid']));

                            unset($_SESSION['reset_phone']);
                            unset($_SESSION['uid']);

                        $_SESSION['username_member_r'] = $result['phone'];
                        $_SESSION['id_member_r'] = $result['id'];
                        $_SESSION['name_r'] = $result['name'];
                        $_SESSION['typeLogin'] = $result['login'];

                        setcookie("setLogin", openssl_encrypt($_SESSION['username_member_r'], "AES-128-ECB", HASH_PASSWORD_KEY) . '#|' . $_SESSION['id_member_r'], time() + (86400 * 30), "/");

                        echo 'true';

                }else
                {
                    echo 'false';
                }

        }


            function close_msg_p()  //delete user note
            {
                if (isset($_SESSION['username_member_r']))
                {
                    $id=$_SESSION['id_member_r'];

                    $stmt = $this->db->prepare("UPDATE  `{$this->table}`  SET   `note` = '' WHERE     `id` = ? ");
                    $stmt->execute(array($id));

                }
            }








    function get() // add product for customer by admin
    {
        if ($this->handleLogin()) {
            $this->checkPermit('check_code', 'code');

            $code = strip_tags(trim($_POST['code']));
            $cat = strip_tags(trim($_POST['cat']));

            $device=array();


            if ($cat =='mobile')
            {


                $stmtCode_mobile=$this->db->prepare("SELECT *FROM `excel` WHERE `code`=?");
                $stmtCode_mobile->execute(array($code));
                if ($stmtCode_mobile->rowCount() > 0 )
                {
                    $result=$stmtCode_mobile->fetch(PDO::FETCH_ASSOC);


                    $device[0]['quantity']=$result['quantity'];
                    $device[0]['price']=$result['price'];



                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1  AND `status` =0    AND `table`='mobile' ");
                    $stmt_order->execute(array($result['code']));
                    $only_order=$stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order']=$only_order['num'];


                    $stmt_cd = $this->db->prepare("SELECT *  FROM `code` WHERE `code` =?  ");
                    $stmt_cd->execute(array($result['code']));
                    $id_color=$stmt_cd->fetch(PDO::FETCH_ASSOC);
                    $device[0]['size'] = $id_color['size'];

                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`color`  FROM `color` WHERE `id` =?  ");
                    $stmt_img->execute(array($id_color['id_color']));
                    $img_div=$stmt_img->fetch(PDO::FETCH_ASSOC);
                    $device[0]['img']=$this->save_file.$img_div['img'];
                    $device[0]['image']=$img_div['img'];
                    $device[0]['color']=$img_div['code_color'];
                    $device[0]['name_color'] = $img_div['color'];


                    $stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `mobile` WHERE `id` =?    ");
                    $stmt_name_device->execute(array($img_div['id_item']));
                    $name_device=$stmt_name_device->fetch(PDO::FETCH_ASSOC);
                    $device[0]['name'] = $name_device['title'];
                    $device[0]['id'] = $name_device['id'];

                    $stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_mobile` WHERE `id` =?    ");
                    $stmt_name_cat->execute(array($name_device['id_cat']));
                    $name_cate=$stmt_name_cat->fetch(PDO::FETCH_ASSOC);
                    $device[0]['category']=$this->langControl('mobile'). '  /  ' .$name_cate['title'];


                }
            }


            if ($cat =='camera') {
                $stmtCode_camera = $this->db->prepare("SELECT * FROM `excel_camera` WHERE `code`=?");
                $stmtCode_camera->execute(array($code));
                if ($stmtCode_camera->rowCount() > 0) {
                    $result = $stmtCode_camera->fetch(PDO::FETCH_ASSOC);

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];



                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='camera' ");
                    $stmt_order->execute(array($result['code']));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order'] = $only_order['num'];



                    $stmt_cd = $this->db->prepare("SELECT  * FROM `code_camera` WHERE `code` =?  ");
                    $stmt_cd->execute(array($result['code']));
                    $id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);
                    $device[0]['size'] = $id_color['size'];

                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color ,`color` FROM `color_camera` WHERE `id` =?  ");
                    $stmt_img->execute(array($id_color['id_color']));
                    $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                    $device[0]['img'] = $this->save_file . $img_div['img'];
                    $device[0]['image']=$img_div['img'];
                    $device[0]['color'] = $img_div['code_color'];
                    $device[0]['name_color'] = $img_div['color'];

                    $stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `camera` WHERE `id` =?    ");
                    $stmt_name_device->execute(array($img_div['id_item']));
                    $name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
                    $device[0]['name'] = $name_device['title'];
                    $device[0]['id'] = $name_device['id'];

                    $stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_camera` WHERE `id` =?    ");
                    $stmt_name_cat->execute(array($name_device['id_cat']));
                    $name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
                    $device[0]['category'] = $this->langControl('camera') . '  /  ' . $name_cate['title'];


                }

            }



            if ($cat =='printing_supplies') {
                $stmtCode_printing_supplies = $this->db->prepare("SELECT * FROM `excel_printing_supplies` WHERE `code`=?");
                $stmtCode_printing_supplies->execute(array($code));
                if ($stmtCode_printing_supplies->rowCount() > 0) {
                    $result = $stmtCode_printing_supplies->fetch(PDO::FETCH_ASSOC);

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];



                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='printing_supplies' ");
                    $stmt_order->execute(array($result['code']));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order'] = $only_order['num'];



                    $stmt_cd = $this->db->prepare("SELECT  * FROM `code_printing_supplies` WHERE `code` =?  ");
                    $stmt_cd->execute(array($result['code']));
                    $id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);
                    $device[0]['size'] = $id_color['size'];

                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color ,`color` FROM `color_printing_supplies` WHERE `id` =?  ");
                    $stmt_img->execute(array($id_color['id_color']));
                    $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                    $device[0]['img'] = $this->save_file . $img_div['img'];
                    $device[0]['image']=$img_div['img'];
                    $device[0]['color'] = $img_div['code_color'];
                    $device[0]['name_color'] = $img_div['color'];

                    $stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `printing_supplies` WHERE `id` =?    ");
                    $stmt_name_device->execute(array($img_div['id_item']));
                    $name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
                    $device[0]['name'] = $name_device['title'];
                    $device[0]['id'] = $name_device['id'];

                    $stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_printing_supplies` WHERE `id` =?    ");
                    $stmt_name_cat->execute(array($name_device['id_cat']));
                    $name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
                    $device[0]['category'] = $this->langControl('printing_supplies') . '  /  ' . $name_cate['title'];


                }

            }


            if ($cat =='computer') {
                $stmtCode_computer = $this->db->prepare("SELECT * FROM `excel_computer` WHERE `code`=?");
                $stmtCode_computer->execute(array($code));
                if ($stmtCode_computer->rowCount() > 0) {
                    $result = $stmtCode_computer->fetch(PDO::FETCH_ASSOC);

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];



                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='computer' ");
                    $stmt_order->execute(array($result['code']));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order'] = $only_order['num'];



                    $stmt_cd = $this->db->prepare("SELECT  * FROM `code_computer` WHERE `code` =?  ");
                    $stmt_cd->execute(array($result['code']));
                    $id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);
                    $device[0]['size'] = $id_color['size'];

                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color ,`color` FROM `color_computer` WHERE `id` =?  ");
                    $stmt_img->execute(array($id_color['id_color']));
                    $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                    $device[0]['img'] = $this->save_file . $img_div['img'];
                    $device[0]['image']=$img_div['img'];
                    $device[0]['color'] = $img_div['code_color'];
                    $device[0]['name_color'] = $img_div['color'];

                    $stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `computer` WHERE `id` =?    ");
                    $stmt_name_device->execute(array($img_div['id_item']));
                    $name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
                    $device[0]['name'] = $name_device['title'];
                    $device[0]['id'] = $name_device['id'];

                    $stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_computer` WHERE `id` =?    ");
                    $stmt_name_cat->execute(array($name_device['id_cat']));
                    $name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
                    $device[0]['category'] = $this->langControl('computer') . '  /  ' . $name_cate['title'];


                }

            }
            if ($cat =='games') {
                $stmtCode_games = $this->db->prepare("SELECT *FROM `excel_games` WHERE `code`=?");
                $stmtCode_games->execute(array($code));
                if ($stmtCode_games->rowCount() > 0) {
                    $result = $stmtCode_games->fetch(PDO::FETCH_ASSOC);

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];



                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1  AND `status` =0  AND `table`='games' ");
                    $stmt_order->execute(array($result['code']));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order'] = $only_order['num'];



                    $stmt_cd = $this->db->prepare("SELECT *  FROM `code_games` WHERE `code` =?  ");
                    $stmt_cd->execute(array($result['code']));
                    $id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);
                    $device[0]['size'] = $id_color['size'];

                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`color`  FROM `color_games` WHERE `id` =?  ");
                    $stmt_img->execute(array($id_color['id_color']));
                    $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                    $device[0]['img'] = $this->save_file . $img_div['img'];
                    $device[0]['image']=$img_div['img'];
                    $device[0]['color'] = $img_div['code_color'];
                    $device[0]['name_color'] = $img_div['color'];

                    $stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `games` WHERE `id` =?    ");
                    $stmt_name_device->execute(array($img_div['id_item']));
                    $name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
                    $device[0]['name'] = $name_device['title'];
                    $device[0]['id'] = $name_device['id'];

                    $stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_games` WHERE `id` =?    ");
                    $stmt_name_cat->execute(array($name_device['id_cat']));
                    $name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
                    $device[0]['category'] = $this->langControl('games') . '  /  ' . $name_cate['title'];


                }


            }

            if ($cat =='network') {
                $stmtCode_network = $this->db->prepare("SELECT *FROM `excel_network` WHERE `code`=?");
                $stmtCode_network->execute(array($code));
                if ($stmtCode_network->rowCount() > 0) {
                    $result = $stmtCode_network->fetch(PDO::FETCH_ASSOC);

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];


                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0   AND `table`='network' ");
                    $stmt_order->execute(array($result['code']));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order'] = $only_order['num'];



                    $stmt_cd = $this->db->prepare("SELECT  * FROM `code_network` WHERE `code` =?  ");
                    $stmt_cd->execute(array($result['code']));
                    $id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);
                    $device[0]['size'] = $id_color['size'];

                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`color`  FROM `color_network` WHERE `id` =?  ");
                    $stmt_img->execute(array($id_color['id_color']));
                    $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                    $device[0]['img'] = $this->save_file . $img_div['img'];
                    $device[0]['image']=$img_div['img'];
                    $device[0]['color'] = $img_div['code_color'];
                    $device[0]['name_color'] = $img_div['color'];

                    $stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `network` WHERE `id` =?    ");
                    $stmt_name_device->execute(array($img_div['id_item']));
                    $name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
                    $device[0]['name'] = $name_device['title'];
                    $device[0]['id'] = $name_device['id'];


                    $stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_network` WHERE `id` =?    ");
                    $stmt_name_cat->execute(array($name_device['id_cat']));
                    $name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
                    $device[0]['category'] = $this->langControl('network') . '  /  ' . $name_cate['title'];


                }

            }
            if ($cat =='accessories') {

                $stmtCode_accessories = $this->db->prepare("SELECT *FROM `excel_accessories` WHERE `code`=?");
                $stmtCode_accessories->execute(array($code));
                if ($stmtCode_accessories->rowCount() > 0) {
                    $result = $stmtCode_accessories->fetch(PDO::FETCH_ASSOC);

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];



                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `buy` = 1 AND `status` =0  AND `table`='accessories' ");
                    $stmt_order->execute(array($result['code']));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order'] = $only_order['num'];




                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`color`  FROM `color_accessories` WHERE `code` =?  ");
                    $stmt_img->execute(array($result['code']));
                    $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                    $device[0]['img'] = $this->save_file . $img_div['img'];
                    $device[0]['image']=$img_div['img'];
                    $device[0]['color'] = $img_div['code_color'];
                    $device[0]['name_color'] = $img_div['color'];
                    $device[0]['size'] = '';

                    $stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `accessories` WHERE `id` =?    ");
                    $stmt_name_device->execute(array($img_div['id_item']));
                    $name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
                    $device[0]['name'] = $name_device['title'];
                    $device[0]['id'] = $name_device['id'];

                    $stmt_name_cat = $this->db->prepare("SELECT  `title`  FROM `category_accessories` WHERE `id` =?    ");
                    $stmt_name_cat->execute(array($name_device['id_cat']));
                    $name_cate = $stmt_name_cat->fetch(PDO::FETCH_ASSOC);
                    $device[0]['category'] = $this->langControl('accessories') . '  /  ' . $name_cate['title'];


                }


            }

            if ($cat =='savers')
            {
                $color = strip_tags(trim($_POST['color']));


                $stmtCode_network = $this->db->prepare("SELECT *FROM `excel_savers` WHERE `code`=? AND `color`=? ");
                $stmtCode_network->execute(array($code,$color));
                if ($stmtCode_network->rowCount() > 0) {
                    $result = $stmtCode_network->fetch(PDO::FETCH_ASSOC);

                    $device[0]['quantity'] = $result['quantity'];
                    $device[0]['price'] = $result['price'];


                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop_active` WHERE `code` =?  AND `name_color` =?  AND `buy` = 1 AND `status` =0   AND `table`='product_savers' ");
                    $stmt_order->execute(array($result['code'],$color));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                    $device[0]['order'] = $only_order['num'];
                    $device[0]['size'] = '';



                    $stmt_color = $this->db->prepare("SELECT  * FROM `product_color`  WHERE `color` =?   LIMIT 1");
                    $stmt_color->execute(array($color));
                    $colorx = $stmt_color->fetch(PDO::FETCH_ASSOC);
                    $device[0]['color'] = $colorx['code_color'];
                    $device[0]['name_color'] = $colorx['color'];
                    $device[0]['img'] = $this->save_file . $colorx['img'];
                    $device[0]['image']=$colorx['img'];


                    $stmt_name = $this->db->prepare("SELECT  `id`,`title`  FROM `product_savers` WHERE `id` =?  AND `code` =?");
                    $stmt_name->execute(array($colorx['id_product'],$result['code']));
                    $name_device = $stmt_name->fetch(PDO::FETCH_ASSOC);
                    $device[0]['name'] = $name_device['title'];
                    $device[0]['id'] = $name_device['id'];

                    $device[0]['category'] = $this->langControl('savers') ;

                }

            }


            require($this->render($this->folder, 'code', 'data', 'php'));


        }
    }



    function add_item_to_order()
    {


        if ($this->handleLogin()) {
            

            $id = strip_tags($_POST['id_device']);

            if (is_numeric($id)) {

                $code = strip_tags($_POST['code']);
                $image = strip_tags($_POST['image']);
                $count = strip_tags($_POST['count']);
                $found = strip_tags($_POST['found']);
                $id_member_r = strip_tags($_POST['id_member_r']);
                $cat = strip_tags($_POST['cat']);
                $name_color = strip_tags($_POST['name_color']);
                $code_color = strip_tags($_POST['code_color']);
                $size = strip_tags($_POST['size']);
                $this->AddToTraceByFunction($this->userid,'register','add_item_to_order/'.$id.'/'.$code.'/'.$image.'/'.$count.'/'.$found.'/'.$id_member_r.'/'.$cat.'/'.$name_color.'/'.$code_color.'/'.$size);


                if ($cat == 'mobile') {
                    $data['table'] = $cat;
                    $excel = 'excel';
                    $code_table = 'code';
                }


                if ($cat == 'camera') {
                    $data['table'] = $cat;
                    $excel = 'excel_camera';

                }

                if ($cat == 'printing_supplies') {
                    $data['table'] = $cat;
                    $excel = 'excel_printing_supplies';

                }

                if ($cat == 'computer') {
                    $data['table'] = $cat;
                    $excel = 'excel_computer';

                }

                if ($cat == 'games') {
                    $data['table'] = $cat;
                    $excel = 'excel_games';

                }

                if ($cat == 'network') {
                    $data['table'] = $cat;
                    $excel = 'excel_network';

                }

                if ($cat == 'accessories') {
                    $data['table'] = $cat;
                    $excel = 'excel_accessories';

                }

                if ($cat == 'savers') {
                    $data['table'] = 'product_savers';
                    $excel = 'excel_savers';

                }


                if ($cat == 'accessories') {
                    $stmt = $this->db->prepare("SELECT * from `{$excel}` WHERE  `code`= ? AND `color` = ? ");
                    $stmt->execute(array($code, $name_color));
                } else {

                    $stmt = $this->db->prepare("SELECT * from `{$excel}` WHERE  `code`= ?  ");
                    $stmt->execute(array($code));
                }


                $result = $stmt->fetch(PDO::FETCH_ASSOC);


                if ($found >= $count) {

                    if ($cat == 'accessories') {
                        $stmt = $this->db->prepare("UPDATE  `{$excel}` SET `quantity`=`quantity` - ? WHERE  `code`=?  AND `color` = ?  ");
                        $stmt->execute(array($count, $code, $name_color));
                    } else {
                        $stmt = $this->db->prepare("UPDATE  `{$excel}` SET `quantity`=`quantity` - ? WHERE  `code`=?  ");
                        $stmt->execute(array($count, $code));
                    }


                    $data['buy'] = 1;
                    $data['id_item'] = $id;
                    $data['id_member_r'] = $id_member_r;
                    $data['number'] = $count;
                    $data['date'] = time();
                    $data['date_req'] = time();
                    $data['name_color'] = $name_color;
                    $data['code'] = $code;
                    $data['size'] = $size;
                    $data['image'] = $image;
                    $data['color'] = $code_color;
                    $data['price'] = $result['price'];
                    $data['price_dollars'] = $result['price_dollars'];

                    $this->db->insert('cart_shop_active', $data);

                    echo 'add';
                } else {
                    echo 'not_enough';
                }


            } else {
                echo 'error';
            }

        }

    }


    function type_customer($v_,$id)
    {
        if ($this->handleLogin()) {
            $note=$_GET['note'];
            $data=array();
            if ($v_==1)
            {
                $data['type_customer']='مقتنع';
                $data['type_customer_12']=1;
            }else{
                $data['type_customer']='غير مقتنع';
                $data['type_customer_12']=2;
            }

            $register_answer['choose']='';
            $register_answer['note']=$note;
            $register_answer['userid']=$this->userid;
            $register_answer['date']=time();

            $stmt = $this->db->update($this->table,$data, "`id`={$id}");
            $stmt = $this->db->update('register_answer',$register_answer, "`id_user`={$id}");
        }
    }






    public function subscribers_screen()
    {
        $this->checkPermit('list_subscribers_screen','registration');
        $this->adminHeaderController($this->langControl('registration'));

        $y=0;

        if (isset($_POST['submit']))
        {
            $y = $_POST['year'];

        }

        $stmt = $this->db->prepare("SELECT * FROM  `{$this->table}` GROUP BY `year` ORDER BY `year` DESC ");
        $stmt->execute();
        $year=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $year[]=$row['year'];
        }

        $date=null;
        $todate=null;
        $fromDate=null;
        $toDate=null;
        if (isset($_GET['date'])&&isset($_GET['todate']))
        {
            $date=$_GET['date'];
            $todate=$_GET['todate'];

            $fromDate=strtotime($date);
            $toDate= strtotime($todate);

        }

        require ($this->render($this->folder,'html','list_screen','php'));
        $this->adminFooterController();
    }




    public function processing_screen($year=0,$date=null,$todate=null)
    {


        $this->checkPermit('list_subscribers_screen', 'registration');

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(

            array('db' => 'name', 'dt' => 0),
            array('db' => 'title', 'dt' => 1),
            array('db' => 'phone', 'dt' => 2),
            array('db' => 'city', 'dt' => 3),
            array('db' => 'address', 'dt' => 4),
            array('db' => 'gander', 'dt' => 5),
            array('db' => 'birthday', 'dt' => 6),
            array('db' => 'price_type', 'dt' => 7,

                'formatter' => function($id, $row ) {
                    if ($this->permit('price_type', $this->folder)) {
                        return "


                <div style='text-align: center'>
                  <input {$this->ch_price_type($id,1)}  value='1' class='toggle-demo list_price_type{$row[19]}' type='checkbox'  onchange='price_type(this,{$row[19]})'  data-toggle='toggle' data-on='on' data-off='off' data-onstyle='success' data-offstyle='danger'  data-size='small' data-style='ios' >
                 </div>
             ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => 'price_type', 'dt' => 8,

                'formatter' => function($id, $row ) {
                    if ($this->permit('price_type', $this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_price_type($id,2)}  value='2' class='toggle-demo list_price_type{$row[18]}'  type='checkbox'  onchange='price_type(this,{$row[19]})'  data-toggle='toggle' data-on='on' data-off='off' data-onstyle='success' data-offstyle='danger' data-size='small'  data-style='ios' >
                 </div>
             ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => 'price_type', 'dt' => 9,

                'formatter' => function($id, $row ) {
                    if ($this->permit('price_type', $this->folder)) {
                        return "
                <div class='' style='text-align: center'>
                  <input {$this->ch_price_type($id,3)}  value='3' class='toggle-demo list_price_type{$row[18]}'  type='checkbox'  onchange='price_type(this,{$row[19]})'  data-toggle='toggle' data-on='on' data-off='off' data-onstyle='success' data-offstyle='danger'  data-size='small'  data-style='ios'>
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

                    if ($row[19] != 0) {
                        if ($this->permit('type_customer', $this->folder)) {
                            return "
                <div style='text-align: center'>
                  <input {$this->ch_type_customer($id)}  class='toggle-demo'  type='checkbox'  onchange='type_customer(this,{$id})'  data-toggle='toggle' data-on='مقتنع' data-off='غير مقتنع' data-onstyle='success' data-offstyle='danger'>
                 </div>
             ";
                        } else {
                            return $this->langControl('forbidden');
                        }
                    }else{
                        return '<span class="badge badge-warning"> غير محدد</span>'  ;
                    }
                }


            ),

            array('db' => 'id', 'dt' =>11,
                'formatter' => function ($id, $row)
                {
                    if ($this->permit('notes_about_customer',$this->folder)) {

                        return "<button class='btn btn-primary btn-sm' onclick='get_note({$id})'>ملاحظات </button>";
                    } else
                    {
                        return $this->langControl('forbidden');
                    }

                }
            ),

            array('db' => 'date', 'dt' => 12,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:s:i A',$id);
                }
            ),


            array('db' => 'id', 'dt' =>13,
                'formatter' => function ($id, $row) {
                    return  "<a  href=' ".  url .'/'.$this->folder ."/details_client/{$id}'>{$this->langControl('details')}</a>" ;
                }

            ),

            array('db' => 'id', 'dt' => 14,
                'formatter' => function ($id, $row) {
                    return  "<a href=' ".  url .'/'.$this->folder ."/view_req/{$id}'>{$this->notification_buy($id)}</a>" ;
                }

            ),
            array('db' => 'id', 'dt' => 15,
                'formatter' => function ($id, $row) {
                    return  "<a href=' ".  url .'/'.$this->folder ."/edit/{$id}'><i class='fa fa-edit'></i></a>" ;
                }

            ),

            array('db' => 'id_user_screen', 'dt' => 16,
                'formatter' => function ($id, $row) {
                    return   $this->UserInfo($id) ;
                }

            ),

            array('db' => 'time_reg', 'dt' => 17,
                'formatter' => function ($id, $row) {
                    return    $this->time_reg($id) ;
                }

            ),
            array(
                'db' => 'id',
                'dt' => 18,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', 'registration')) {
                        return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),



            array('db' => 'id', 'dt' => 19),
            array('db' => 'type_customer_12', 'dt' => 20)


        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );




        if ($date && $todate)
        {
            if ($year == 0) {
                echo json_encode(
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"city <> '' AND gander <> ''  AND `date` BETWEEN {$date} AND {$todate} ")
                );
            }
            else {
                echo json_encode(
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "city <> '' AND gander <> ''  AND `year` ={$year} AND `date` BETWEEN {$date} AND {$todate} "));
            }
        }else
        {
            if ($year == 0) {
                echo json_encode(
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"city <> '' AND gander <> ''  "  )
                );
            }
            else {
                echo json_encode(
                    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "city <> '' AND gander <> '' AND `year` ={$year}  "));
            }
        }



    }

    function time_reg($time)
    {

        if ($time <= 59)
        {
          return    $time . '  ثانية ';
        }else {


            $H = floor($time / 3600);

            if ($H >= 1 )
            {
                return   $H . '  ساعة ' ;
            }else
            {
                $i = ($time / 60) % 60;
                return    $i . '  دقيقة ' ;
            }



        }




    }



    public function subscribers_order_screen()
    {
        $this->checkPermit('list_subscribers_order_screen','registration');
        $this->adminHeaderController($this->langControl('registration'));

        $y=0;

        if (isset($_POST['submit']))
        {
            $y = $_POST['year'];

        }

        $stmt = $this->db->prepare("SELECT * FROM  `{$this->table}` GROUP BY `year` ORDER BY `year` DESC ");
        $stmt->execute();
        $year=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $year[]=$row['year'];
        }



        $fromdate_bill=null;
        $todate_bill=null;

        $fromdate_bill_timestamp=0;
        $todate_bill_timestamp=0;
        $bill1=0;
        $bill2=0;

        $_SESSION['fromdate_bill_timestamp']=null;
        $_SESSION['todate_bill_timestamp']=null;
        $_SESSION['bill1']=null;
        $_SESSION['bill2']=null;

        if (isset($_GET['fromdate_bill']) && isset($_GET['todate_bill']))
        {

            if (!empty($_GET['fromdate_bill']) && !empty($_GET['todate_bill'])) {


                $fromdate_bill = $_GET['fromdate_bill'];
                $todate_bill = $_GET['todate_bill'];

                $fromdate_bill_timestamp = strtotime($fromdate_bill);
                $todate_bill_timestamp = strtotime($todate_bill);

                $_SESSION['fromdate_bill_timestamp']=$fromdate_bill_timestamp;
                $_SESSION['todate_bill_timestamp']=$todate_bill_timestamp;

            }
        }


        if (isset($_GET['bill1']))
        {
            if (!empty($_GET['bill1']))
            {
                $bill1=$_GET['bill1'];
                $_SESSION['bill1']=$bill1;

            }
        }

        if (isset($_GET['bill2']))
        {
            if (!empty($_GET['bill2']))
            {
                $bill2=$_GET['bill2'];
                $_SESSION['bill2']=$bill2;

            }
        }

        require ($this->render($this->folder,'html','list_screen_order','php'));
        $this->adminFooterController();
    }




    public function processing_order_screen($fromdate_bill_timestamp=0,$todate_bill_timestamp=0,$bill1=null,$bill2=null)
    {


        $this->checkPermit('list_subscribers_order_screen', 'registration');

        $table = $this->table;
        $primaryKey = 'register_user.id';

        $columns = array(

            array('db' => 'register_user.name', 'dt' => 0),
            array('db' => 'register_user.title', 'dt' => 1),
            array('db' => 'register_user.phone', 'dt' => 2),
            array('db' => 'register_user.city', 'dt' => 3),
            array('db' => 'register_user.address', 'dt' => 4),
            array('db' => 'register_user.gander', 'dt' => 5),
            array('db' => 'register_user.birthday', 'dt' => 6),
            array('db' => 'register_user.price_type', 'dt' => 7,

                'formatter' => function($id, $row ) {
                    if ($this->permit('price_type', $this->folder)) {
                        return "


                <div style='text-align: center'>
                  <input {$this->ch_price_type($id,1)}  value='1' class='toggle-demo list_price_type{$row[20]}' type='checkbox'  onchange='price_type(this,{$row[20]})'  data-toggle='toggle' data-on='on' data-off='off' data-onstyle='success' data-offstyle='danger'  data-size='small' data-style='ios' >
                 </div>
             ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => 'register_user.price_type', 'dt' => 8,

                'formatter' => function($id, $row ) {
                    if ($this->permit('price_type', $this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_price_type($id,2)}  value='2' class='toggle-demo list_price_type{$row[20]}'  type='checkbox'  onchange='price_type(this,{$row[20]})'  data-toggle='toggle' data-on='on' data-off='off' data-onstyle='success' data-offstyle='danger' data-size='small'  data-style='ios' >
                 </div>
             ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => 'register_user.price_type', 'dt' => 9,

                'formatter' => function($id, $row ) {
                    if ($this->permit('price_type', $this->folder)) {
                        return "
                <div class='' style='text-align: center'>
                  <input {$this->ch_price_type($id,3)}  value='3' class='toggle-demo list_price_type{$row[20]}'  type='checkbox'  onchange='price_type(this,{$row[20]})'  data-toggle='toggle' data-on='on' data-off='off' data-onstyle='success' data-offstyle='danger'  data-size='small'  data-style='ios'>
                 </div>
                  ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }

            ),

            array(
                'db'        => 'register_user.id',
                'dt'        => 10,
                'formatter' => function($id, $row ) {

                    if ($row[21] != 0) {
                        if ($this->permit('type_customer', $this->folder)) {
                            return "
                <div style='text-align: center'>
                  <input {$this->ch_type_customer($id)}  class='toggle-demo'  type='checkbox'  onchange='type_customer(this,{$id})'  data-toggle='toggle' data-on='مقتنع' data-off='غير مقتنع' data-onstyle='success' data-offstyle='danger'>
                 </div>
             ";
                        } else {
                            return $this->langControl('forbidden');
                        }
                    }else{
                        return '<span class="badge badge-warning"> غير محدد</span>'  ;
                    }
                }


            ),

            array('db' => 'register_user.id', 'dt' =>11,
                'formatter' => function ($id, $row)
                {
                    if ($this->permit('notes_about_customer',$this->folder)) {

                        return "<button class='btn btn-primary btn-sm' onclick='get_note({$id})'>ملاحظات </button>";
                    } else
                    {
                        return $this->langControl('forbidden');
                    }

                }
            ),

            array('db' => 'register_user.date', 'dt' => 12,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s A',$id);
                }
            ),


            array('db' => 'register_user.id', 'dt' =>13,
                'formatter' => function ($id, $row) {
                    return  "<a  href=' ".  url .'/'.$this->folder ."/details_client/{$id}/{$row[22]}'>{$this->langControl('details')}</a>" ;
                }

            ),

            array('db' => 'register_user.id', 'dt' => 14,
                'formatter' => function ($id, $row) {
                    return  "<a href=' ".  url .'/'.$this->folder ."/view_req/{$id}'>{$this->notification_buy($id)}</a>" ;
                }

            ),
            array('db' => 'register_user.id', 'dt' => 15,
                'formatter' => function ($id, $row) {
                    return  "<a href=' ".  url .'/'.$this->folder ."/edit/{$id}'><i class='fa fa-edit'></i></a>" ;
                }

            ),

            array('db' => 'user.id', 'dt' => 16,
                'formatter' => function ($id, $row) {
                    return  $this->sum_number_bill_user($id,$row[20]) ;
                }

            ),

            array('db' => 'user.username', 'dt' => 17,
                'formatter' => function ($id, $row) {
                    return  $id ;
                }

            ),


            array('db' => 'cart_shop_active.byqr', 'dt' => 18,
                'formatter' => function ($id, $row) {

                    if ($id)
                    {
                        return 'فواتير حساب الموظف';
                    }else
                    {
                        return 'فواتير الشاشة';
                    }


                }


            ),

            array(
                'db' => 'register_user.id',
                'dt' => 19,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', 'registration')) {
                        return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array('db' => 'register_user.id', 'dt' => 20),
            array('db' => 'register_user.type_customer_12', 'dt' => 21),
            array('db' => 'cart_shop_active.user_direct', 'dt' => 22),



        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );



        $join = " inner JOIN cart_shop_active ON cart_shop_active.id_member_r = register_user.id   LEFT JOIN user ON user.id =  cart_shop_active.user_direct ";
       if ($fromdate_bill_timestamp && $todate_bill_timestamp )
        {


            if ($bill1 ==1 && $bill2 ==1 )
            {
                $whereAll = array(" register_user.city <> '' ",
                    "  register_user.`xc`=1 ",
                    " ( cart_shop_active.`byqr`=0 OR   cart_shop_active.`byqr`=1   ) ",
                    "  cart_shop_active.`date_req` BETWEEN {$fromdate_bill_timestamp} AND {$todate_bill_timestamp} ",
                    " cart_shop_active.accountant =1"," cart_shop_active.cancel =0" ," cart_shop_active.prepared =2");

            }else if ($bill1 ==1 )
            {

                $whereAll = array(" register_user.city <> '' ",
                    "  register_user.`xc`=1 ",
                    "  cart_shop_active.`byqr`=0 ",
                    "  cart_shop_active.`date_req` BETWEEN {$fromdate_bill_timestamp} AND {$todate_bill_timestamp} ",
                    " cart_shop_active.accountant =1"," cart_shop_active.cancel =0" ," cart_shop_active.prepared =2");

            }else if ($bill2 ==1 )
            {

                $whereAll = array(" register_user.city <> '' ",
                    "  register_user.`xc`=1 ",
                    "  cart_shop_active.`byqr`=1 ",
                    "  cart_shop_active.`date_req` BETWEEN {$fromdate_bill_timestamp} AND {$todate_bill_timestamp} ",
                    " cart_shop_active.accountant =1"," cart_shop_active.cancel =0" ," cart_shop_active.prepared =2");
            }else
            {
                $whereAll = array(" register_user.city <> '' ",
                    "  register_user.`xc`=1 ",
                    "  cart_shop_active.`date_req` BETWEEN {$fromdate_bill_timestamp} AND {$todate_bill_timestamp} ",
                    " cart_shop_active.accountant =1"," cart_shop_active.cancel =0" ," cart_shop_active.prepared =2");

            }



        }
        else
        {




            if ($bill1  ==1  && $bill2  ==1 )
            {
                $whereAll = array("register_user.city <> '' ",
                    "  register_user.`xc` = 1 ",
                    " ( cart_shop_active.`byqr`=0 OR   cart_shop_active.`byqr`=1   ) ",
                    " register_user.gander <> ''  "," cart_shop_active.accountant =1"," cart_shop_active.cancel =0" ," cart_shop_active.prepared =2 ");

            }else if ($bill1  ==1 )
            {
                $whereAll = array("register_user.city <> '' ",
                    "  register_user.`xc` = 1 ",
                    "   cart_shop_active.`byqr`=0   ",
                    " register_user.gander <> ''  "," cart_shop_active.accountant =1"," cart_shop_active.cancel =0" ," cart_shop_active.prepared =2 ");


            }else if ($bill2  ==1 )
            {
                $whereAll = array("register_user.city <> '' ",
                    "  register_user.`xc` = 1 ",
                    "  cart_shop_active.`byqr`=1     ",
                    " register_user.gander <> ''  "," cart_shop_active.accountant =1"," cart_shop_active.cancel =0" ," cart_shop_active.prepared =2 ");

            }else
            {
                $whereAll = array("register_user.city <> '' ",
                    "  register_user.`xc` = 1 ",
                    " register_user.gander <> ''  "," cart_shop_active.accountant =1"," cart_shop_active.cancel =0" ," cart_shop_active.prepared =2 ");

            }


        }
        $group=" GROUP BY  cart_shop_active.id_member_r,  cart_shop_active.user_direct ,  cart_shop_active.byqr  " ;
        echo json_encode(
            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,1));

    }


    function sum_number_bill_user($id_user,$id_customer)
    {



        if (empty( $_SESSION['fromdate_bill_timestamp']) &&  empty( $_SESSION['todate_bill_timestamp'])   &&  empty( $_SESSION['bill1'])   &&  empty( $_SESSION['bill2'])   )
        {
            $stmt = $this->db->prepare("SELECT  count(number_bill) as couts  FROM `cart_shop_active` WHERE  (`user_direct` = ? OR user_direct=0)   AND  id_member_r =?   AND accountant =1  AND     cancel =0  AND  buy =2 AND   prepared =2 GROUP BY   id_member_r");
            $stmt->execute(array($id_user,$id_customer));

        }else  if (!empty( $_SESSION['fromdate_bill_timestamp']) &&  !empty( $_SESSION['todate_bill_timestamp'])   &&  !empty( $_SESSION['bill1'])   &&  !empty( $_SESSION['bill2'])   )
        {
            $stmt = $this->db->prepare("SELECT  count(number_bill) as couts  FROM `cart_shop_active` WHERE (`user_direct` = ? OR user_direct=0)   AND  id_member_r =?   AND  `date_req` BETWEEN  ? AND  ?    AND accountant =1  AND     cancel =0  AND  buy =2 AND   prepared =2 GROUP BY   id_member_r");
            $stmt->execute(array($id_user,$id_customer,$_SESSION['fromdate_bill_timestamp'],$_SESSION['todate_bill_timestamp']));
        }else if (!empty( $_SESSION['fromdate_bill_timestamp']) &&  !empty( $_SESSION['todate_bill_timestamp'])   &&  !empty( $_SESSION['bill1'])   &&  empty( $_SESSION['bill2']) )
        {
            $stmt = $this->db->prepare("SELECT  count(number_bill) as couts  FROM `cart_shop_active` WHERE   id_member_r =? AND byqr = 0   AND  `date_req` BETWEEN  ? AND  ?    AND accountant =1  AND     cancel =0  AND  buy =2 AND   prepared =2 GROUP BY  id_member_r");
            $stmt->execute(array($id_customer,$_SESSION['fromdate_bill_timestamp'],$_SESSION['todate_bill_timestamp']));
        }
        else if (!empty( $_SESSION['fromdate_bill_timestamp']) &&  !empty( $_SESSION['todate_bill_timestamp'])   &&  empty( $_SESSION['bill1'])   &&  !empty( $_SESSION['bill2']) )
        {
            $stmt = $this->db->prepare("SELECT  count(number_bill) as couts  FROM `cart_shop_active` WHERE `user_direct` = ?  AND  id_member_r =? AND byqr = 1  AND direct <> 0  AND  `date_req` BETWEEN  ? AND  ?    AND accountant =1  AND     cancel =0  AND  buy =2 AND   prepared =2 GROUP BY   ,id_member_r");
            $stmt->execute(array($id_user,$id_customer,$_SESSION['fromdate_bill_timestamp'],$_SESSION['todate_bill_timestamp']));
        }

        else if (empty( $_SESSION['fromdate_bill_timestamp']) &&  empty( $_SESSION['todate_bill_timestamp'])   &&  !empty( $_SESSION['bill1'])   &&  !empty( $_SESSION['bill2']) )
        {
            $stmt = $this->db->prepare("SELECT  count(number_bill) as couts  FROM `cart_shop_active` WHERE   id_member_r =?     AND accountant =1  AND     cancel =0  AND  buy =2 AND   prepared =2  GROUP BY   id_member_r");
            $stmt->execute(array($id_customer ));
        }


        else if (empty( $_SESSION['fromdate_bill_timestamp']) &&  empty( $_SESSION['todate_bill_timestamp'])   &&  !empty( $_SESSION['bill1'])   &&  empty( $_SESSION['bill2']) )
        {
            $stmt = $this->db->prepare("SELECT  count(number_bill) as couts  FROM `cart_shop_active` WHERE   id_member_r =? AND byqr=0    AND accountant =1  AND     cancel =0  AND  buy =2 AND   prepared =2 GROUP BY   id_member_r");
            $stmt->execute(array($id_customer ));
        }

        else if (empty( $_SESSION['fromdate_bill_timestamp']) &&  empty( $_SESSION['todate_bill_timestamp'])   &&  empty( $_SESSION['bill1'])   &&  !empty( $_SESSION['bill2']) )
        {
            $stmt = $this->db->prepare("SELECT  count(number_bill) as couts  FROM `cart_shop_active` WHERE  `user_direct` = ?  AND id_member_r =? AND byqr=1  AND direct <> 0    AND accountant =1  AND     cancel =0  AND  buy =2 AND   prepared =2 GROUP BY   id_member_r");
            $stmt->execute(array($id_user,$id_customer ));
        }


        if ($stmt->rowCount() > 0) {

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return  $result['couts'];
        }else{
            return 0;
        }

    }




}