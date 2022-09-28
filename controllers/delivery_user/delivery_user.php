<?php

class delivery_user extends Controller
{



    function __construct()
    {
        parent::__construct();

        $this->cart_shop_active = 'cart_shop_active';
        $this->register_user = 'register_user';
        $this->smile='smile';
        $this->tokenAdmin='tokenAdmin';


    }


    public function createTB()
    {



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->smile}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
          `id_r` int(10) NOT NULL ,
          `smile` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `delivery_user` int(10) NOT NULL,
          `msg` longtext  COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return  $this->db->cht(array($this->smile));

    }






    function index()
    {

        $this->checkPermit('delivery_user','delivery_user');
        $this->adminHeaderController($this->langControl('delivery_user'));


        if (!is_numeric($this->userid)) {$error=new Errors(); $error->index();}




        $mobile=new mobile();
        $stmt_date_req_done=$mobile->getAllContentFromCar_details_client_delivery_user_date_d_r($this->userid);
        $date_req_done=array();
        while ($row_d =$stmt_date_req_done->fetch(PDO::FETCH_ASSOC))
        {

            $row_d[$row_d['date_d_r']]=array();
            $stmt=$mobile->getAllContentFromCar_details_client_delivery_user($row_d['id_member_r'],$row_d['date_d_r'],$this->userid);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $table=$row['table'];
                $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
                $stmt_get_item->execute(array($row['id_item']));
                $item = $stmt_get_item->fetch();

                $row['title']=$item['title'];
                $row['img']=$this->save_file.$row['image'];

                if ($row['table'] == 'mobile') {

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $result_price['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $result_price['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $result_price['price'].' د.ع ';
                    }


                }


                if ($row['table'] == 'camera') {

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_camera`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $result_price['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $result_price['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $result_price['price'].' د.ع ';
                    }



                }



                if ($row['table'] == 'printing_supplies') {

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_printing_supplies`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $result_price['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $result_price['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $result_price['price'].' د.ع ';
                    }



                }


                if ($row['table'] == 'computer') {

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_computer`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $result_price['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $result_price['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $result_price['price'].' د.ع ';
                    }



                }



                if ($row['table'] == 'games') {

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_games`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $result_price['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $result_price['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $result_price['price'].' د.ع ';
                    }


                }


                if ($row['table'] == 'network') {


                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_network`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $result_price['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $result_price['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $result_price['price'].' د.ع ';
                    }




                }



                if ($row['table'] == 'accessories') {

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_accessories`  WHERE  `code`=?  ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $result_price['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $result_price['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $result_price['price'].' د.ع ';
                    }

                }


                if ($row['table'] == 'product_savers') {

                    $stmt_price = $this->db->prepare("SELECT  *FROM   `excel_savers`  WHERE  `code`=? ");
                    $stmt_price->execute(array($row['code']));
                    $result_price=$stmt_price->fetch(PDO::FETCH_ASSOC);

                    if (isset($_COOKIE['currency']) )
                    {
                        if ($_COOKIE['currency'] == 0)
                        {
                            $row['price']= $result_price['price'] .' د.ع ';
                        }else
                        {
                            $row['price']= $result_price['price_dollars'] .'$ ';
                        }
                    }else
                    {
                        $row['price']= $result_price['price'].' د.ع ';
                    }

                }


                $row_d[$row_d['date_d_r']][]=$row;
            }


            $date_req_done[]=$row_d;

        }

        require ($this->render($this->folder,'html','index','php'));
        $this->adminFooterController();


    }


function done_delivery()
{


    if ($this->handleLogin())
    {
        $this->checkPermit('delivered','delivery_user');


          $number_bill=strip_tags(trim($_GET['number_bill']));
          $id_member_r=strip_tags(trim($_GET['id_member_r']));
          $date_d_r=strip_tags(trim($_GET['date_d_r']));


          $stmt=$this->db->prepare("UPDATE `{$this->cart_shop_active}` SET `delivered`=1 , `delivered_date` = ?  WHERE `id_member_r`= ? AND  `date_d_r`=? AND `number_bill` = ? AND `delivered` = 0 AND  `number_bill` <> 0" );
          $stmt->execute(array(time(),$id_member_r,$date_d_r,$number_bill));

          if ($stmt->rowCount() > 0)
          {
              echo 1;
          }
    }



}



        function smile_delivery($id_r,$smile,$delivery_user)
        {

            if (!is_numeric($id_r)) {$error=new Errors(); $error->index();}
            if (!is_numeric($smile)) {$error=new Errors(); $error->index();}
            if (!is_numeric($delivery_user)) {$error=new Errors(); $error->index();}



            $stmtCods = $this->db->prepare("SELECT *FROM `{$this->register_user}` WHERE id = ?    LIMIT 1");
            $stmtCods->execute(array($id_r));
            $result=$stmtCods->fetch(PDO::FETCH_ASSOC);


            $resultToken=array();
            $stmtToken = $this->db->prepare("SELECT *FROM `{$this->tokenAdmin}`  ");
            $stmtToken->execute();
            while ($row=$stmtToken->fetch(PDO::FETCH_ASSOC))
            {
                $resultToken[]=$row['token'];
            }


            $stmt=$this->db->prepare("INSERT INTO `{$this->smile}` (id_r,smile,delivery_user,`date`) VALUES (?,?,?,?)");
            $stmt->execute(array($id_r,$smile,$delivery_user,time()));
            $list_id=$this->db->lastInsertId();
            if ($stmt->rowCount())
            {

                $stmt_reg = $this->db->prepare("UPDATE `{$this->register_user}` SET `delivery_service`=0   WHERE `id`= ?  ");
                $stmt_reg->execute(array($id_r));


                if (!empty($resultToken))
                {
                    $chat =new Chat();
                    $msg="  اعجب " .$result['name'] . "   بخدمة التوصيل ";
                    $this->send( $resultToken, $msg ,$result['name'],url.'/'.$this->folder.'/list_delivery');
                }

                echo $list_id;
            }
        }



    function send($registrationIds,$msg,$title,$url)
    {
        define('SERVER_API_KEY', 'AIzaSyCvi0M_PBoyXXKKS0W-ABFlK5ky7Volemk');



        $header = [
            'Authorization: Key=' . SERVER_API_KEY,
            'Content-Type: Application/json'
        ];

        $msg = [
            'title' => $title,
            'body' =>$msg,
            'icon' =>  $this->static_file_site .'/image/site/logo_notif.png',
            'click_action' => $url

        ];

        $payload = [
            'registration_ids' 	=> $registrationIds,
            'data'				=> $msg
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode( $payload ),
            CURLOPT_HTTPHEADER => $header
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

    }




    function list_delivery()
         {

         $this->checkPermit('customers_view_the_delivery_service','delivery_user');
          $this->adminHeaderController($this->langControl('customers_view_the_delivery_service'));

             $stmt1 = $this->db->prepare("SELECT  count(*)  FROM `{$this->smile}`  WHERE   `smile`=1");
             $stmt1->execute();
             $s1= $stmt1->fetchColumn() ;


             $stmt2 = $this->db->prepare("SELECT  count(*)  FROM `{$this->smile}`  WHERE   `smile`=2");
             $stmt2->execute();
             $s2= $stmt2->fetchColumn() ;


             $stmt3 = $this->db->prepare("SELECT  count(*)  FROM `{$this->smile}`  WHERE   `smile`=3");
             $stmt3->execute();
             $s3= $stmt3->fetchColumn() ;



             require ($this->render($this->folder,'html','list','php'));
          $this->adminFooterController();
         }



    public function processing()
    {


        $table = $this->smile;
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'id_r', 'dt' => 0 ,
              'formatter' => function( $d, $row ) {
                 return  $this->costomer_name($d) ;
               }
            ),
            array( 'db' => 'id_r', 'dt' => 1 ,
              'formatter' => function( $d, $row ) {
                 return  $this->costomer_phone($d) ;
               }

            ),
            array( 'db' => 'smile', 'dt' => 2 ,

                'formatter' => function( $d, $row ) {
                    return  $this->smile_her($d) ;
                }
            ),

           array( 'db' => 'msg', 'dt' => 3),


            array( 'db' => 'delivery_user', 'dt' =>4  ,
                'formatter' => function( $d, $row ) {
                    return  $this->delivery_user_name($d) ;
                }


            ),
            array( 'db' => 'date', 'dt' =>  5 ,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i:s A', $d);
                }
            ),
            array('db' => 'id_r', 'dt' => 6,
                'formatter' => function ($id, $row) {
                    return  "<a href=' ".  url ."/register/details_client/{$id}'>{$this->langControl('details')}</a>" ;
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
        echo json_encode(
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns)
        );

    }



    function costomer_name($id)
    {

        if ($this->handleLogin())
        {
            $stmtCods = $this->db->prepare("SELECT `name`FROM `{$this->register_user}` WHERE id = ?    LIMIT 1");
            $stmtCods->execute(array($id));
            $result=$stmtCods->fetch(PDO::FETCH_ASSOC);
             return $result['name'];
        }

    }


    function costomer_phone($id)
    {

        if ($this->handleLogin())
        {
            $stmtCods = $this->db->prepare("SELECT `phone` FROM `{$this->register_user}` WHERE id = ?    LIMIT 1");
            $stmtCods->execute(array($id));
            $result=$stmtCods->fetch(PDO::FETCH_ASSOC);
             return $result['phone'];
        }

    }

    function delivery_user_name($id)
    {

        if ($this->handleLogin())
        {
            $stmtCods = $this->db->prepare("SELECT `username`FROM `user` WHERE id = ?    LIMIT 1");
            $stmtCods->execute(array($id));
            $result=$stmtCods->fetch(PDO::FETCH_ASSOC);
             return $result['username'];
        }

    }



    function smile_her($id)
    {

        if ($id==1)
        {
            return "<i  style='font-size: 20px;color: green' class='fa fa-smile-o'></i>";
        }else if ($id==2)
        {
            return "<i  style='font-size: 20px;color: orange' class='fa fa-meh-o'></i>";
        }else
        {
            return "<i  style='font-size: 20px;color: red' class='fa fa-frown-o'></i>";
        }

    }



    function prepared_requests()
    {
        $this->checkPermit('prepared_requests','delivery_user');
        $this->adminHeaderController($this->langControl('prepared_requests'));


        $groups=array();
        $stmt_groups =$this->db->prepare("SELECT *FROM `usergroup` WHERE `name` LIKE '%توصيل%' ");
        $stmt_groups->execute();
        while ($row = $stmt_groups->fetch(PDO::FETCH_ASSOC))
        {

            $groups[]= $row;


        }


        $mobile=new mobile();

        $stmt_date_req_done=$mobile->getAllContentFromCar_details_client_done_prepared_requests();
        $prepared_requests=array();
        while ($row_d =$stmt_date_req_done->fetch(PDO::FETCH_ASSOC))
        {
                $stmt1 = $this->db->prepare("SELECT `username` FROM `user` WHERE id = ?    LIMIT 1");
                $stmt1->execute(array($row_d['delivery_user']));
                  $row_d['username']= $stmt1->fetch(PDO::FETCH_ASSOC)['username'];

                  $stmt2 = $this->db->prepare("SELECT `name`,`phone` FROM `{$this->register_user}` WHERE id = ?    LIMIT 1");
                  $stmt2->execute(array($row_d['id_member_r']));

                      $r=$stmt2->fetch(PDO::FETCH_ASSOC);
                        $row_d['name']=$r['name'];
                        $row_d['phone']=$r['phone'];

                     $prepared_requests[]=$row_d;

           }


        require ($this->render($this->folder,'html','prepared_requests','php'));
        $this->adminFooterController();
    }




    function count_prepared_requests()
    {
        $mobile=new mobile();
        $stmt_date_req_done=$mobile->getAllContentFromCar_details_client_done_prepared_requests();
        $prepared_requests=array();
        while ($row_d =$stmt_date_req_done->fetch(PDO::FETCH_ASSOC))
        {
            $prepared_requests[]=$row_d;
        }
        return count($prepared_requests);


    }



    function msg_smile($id)
    {

         $msg=strip_tags($_POST['msg']);
         $id_smile=strip_tags($_POST['id']);

        $stmt = $this->db->prepare("UPDATE `{$this->smile}` SET `msg`=?   WHERE `id`= ? AND `id_r`=? ");
        $stmt->execute(array($msg,$id_smile,$id));


    }


}




















