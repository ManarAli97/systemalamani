<?php

class Chat extends Controller
{


    function __construct()
    {
        parent::__construct();
        $this->table = 'chat';
        $this->register_user = 'register_user';
        $this->token = 'token';
        $this->tokenAdmin = 'tokenAdmin';
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
           `id` int(11)  NOT NULL AUTO_INCREMENT ,
           `message` longtext COLLATE utf8_unicode_ci NOT NULL,
           `id_r`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `username_r`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `admin`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `direction`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `user_admin`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `read` int(11)  NOT NULL DEFAULT 0,
           `readUser` int(11)  NOT NULL DEFAULT 0,
           `is_delete` int(11)  NOT NULL DEFAULT 0,
           `date` bigint(20) NOT NULL,
           `date_day` bigint(20) NOT NULL,
          
           PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->token}` (
           `id` int(11)  NOT NULL AUTO_INCREMENT ,
           `token` longtext COLLATE utf8_unicode_ci NOT NULL,
           `browser`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `id_member_r`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->tokenAdmin}` (
           `id` int(11)  NOT NULL AUTO_INCREMENT ,
           `token` longtext COLLATE utf8_unicode_ci NOT NULL,
           `browser`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `id_user`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        return $this->db->cht(array($this->table,$this->token,$this->tokenAdmin));

    }


    public function index()
    {

        if (isset($_SESSION['username_member_r'])) {


        $this->db->update($this->table,array('readUser'=>0),"id_r='{$_SESSION['id_member_r']}'");

        $data=$this->db->select("SELECT * from  {$this->register_user} ");

        $chat=array();
        $date_day=array();

        $stmt_date_day=$this->db->prepare("SELECT `date_day` FROM `{$this->table}` WHERE `id_r`= ? AND `admin` = ? AND `is_delete`= 0 GROUP BY `date_day`");
        $stmt_date_day->execute(array($_SESSION['id_member_r'],'admin'));
          while ($rowGD=$stmt_date_day->fetch(PDO::FETCH_ASSOC))
          {
              $date_day[]=$rowGD;

              $stmt=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE `id_r`= ? AND `admin` = ?  AND `date_day` = ?   AND `is_delete`= 0 ");
              $stmt->execute(array($_SESSION['id_member_r'],'admin',$rowGD['date_day']));
              $chat[$rowGD['date_day']]=array();
              while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
              {
                  $chat[$rowGD['date_day']][]=$row;
              }

          }


        require($this->render($this->folder, 'html', 'index', 'php'));

        } else {
            require($this->render('register', 'html', 'login', 'php'));
        }

    }




    function list_user()
    {

        $this->checkPermit('chat','chat');
        $this->adminHeaderController($this->langControl('chat'));



        require ($this->render($this->folder,'html','list_user','php'));
        $this->adminFooterController();
    }



    function loadmore()
    {

        $limit = (intval($_GET['limit']) != 0 ) ? $_GET['limit'] : 10;
        $offset = (intval($_GET['offset']) != 0 ) ? $_GET['offset'] : 0;

        $stmt_u=$this->db->prepare("SELECT  *from  `{$this->register_user}` where `last_chat` <> 0 order by `last_chat` DESC   LIMIT $limit OFFSET $offset");
        $stmt_u->execute();
        $data1=array();
        $data2=array();
        while ($rowU = $stmt_u->fetch(PDO::FETCH_ASSOC)) {

            $stmt_read=$this->db->prepare("SELECT count(*)   FROM `{$this->table}` WHERE `id_r`= ? AND `admin` = ? AND `read`=1");
            $stmt_read->execute(array(  $rowU['id'],'admin'));

            $rowU['newMsg']=$stmt_read->fetchColumn();

            if ($rowU['newMsg'] >0 )
            {


                $data1[]="
                    <div class='userOpen active_{$rowU['id']}'>
                        <a  class='' onclick='getMessage({$rowU['id']})'  href='#'> <i class='fa fa-user-circle-o'></i>  <span> {$rowU['name']} <div class='phone_user_chat'> {$rowU['phone']}  </div> </span>
                          </a>
                          <span class='newMessage'>   {$rowU['newMsg']}  </span>

                    </div>
                  
                ";

            }else{
                $stmt_read2=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE `id_r`= ? AND `admin` = ? AND `read`=0");
                $stmt_read2->execute(array(  $rowU['id'],'admin'));

                if($stmt_read2 ->rowCount() > 0)
                {

                    $data2[]="
                      <div class='userOpen  active_{$rowU['id']}'>

                      <a     onclick='getMessage({$rowU['id']})' href='#' > <i class='fa fa-user-circle-o'></i>  <span> {$rowU['name']} <div class='phone_user_chat'> {$rowU['phone']} </div> </span>
                       </a>
                       
                       <button    class='btn not_read' onclick='not_read({$rowU['id']})'     title='تحديد الرسائل كغير مقروءة'   > <i class='fa fa-star'></i> </button>
                     </div>
                ";
                }

            }
        }

        $data=array_merge($data1,$data2);
        foreach ($data as $x)
        {
            echo $x;
        }

    }




        function  get_chat($id)
        {
            if (is_null( $id)) {$error=new Errors(); $error->index();}
            $this->checkPermit('chat','chat');
            $chat=array();
            $date_day=array();
            $this->db->update($this->table,array('read'=>0),"id_r='{$id}'");
            $stmt_date_day=$this->db->prepare("SELECT `date_day` FROM `{$this->table}` WHERE `id_r`= ? AND `admin` = ?  GROUP BY `date_day`");
            $stmt_date_day->execute(array($id,'admin'));
            while ($rowGD=$stmt_date_day->fetch(PDO::FETCH_ASSOC))
            {
                $date_day[]=$rowGD;

                $stmt=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE `id_r`= ? AND `admin` = ?  AND `date_day` = ? ");
                $stmt->execute(array($id,'admin',$rowGD['date_day']));
                $chat[$rowGD['date_day']]=array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    $chat[$rowGD['date_day']][]=$row;
                }

            }

            require ($this->render($this->folder,'html','ajax','php'));

        }


    public function  notification_chat()
    {
        $stmt = $this->db->prepare("SELECT  count(*)  FROM `{$this->table}`  WHERE   `read`=1");
        $stmt->execute();
        return $stmt->fetchColumn() ;

    }


    function get_num_of_words($string) {
        $string = preg_replace('/\s+/', ' ', trim($string));
        $words = explode(" ", $string);
        return count($words);
    }

    function search_live()
    {
        $this->checkPermit('chat','chat');
        $q=strip_tags(trim($_GET["q"]));

        $q = '%' . $q . '%';
        $stmt = $this->db->prepare("SELECT *FROM `{$this->register_user}` WHERE `name` LIKE ? OR `phone` LIKE  ? ");
        $stmt->execute(array($q,$q));
        $html='';
        if ($stmt->rowCount() > 0)
        {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $html.='<a  href="'.url.'/'.$this->folder.'/list_user/'.$row['id'].'"  class="customer_live"><span>'.$row['name'].'</span>  <span class="number_phone"> '.$row['phone'].'</span> </a>';
            }
            echo $html;
        }
        else{
            echo '0';
        }



    }


    function chatCenter($id_member_r)
    {

        if (isset($_SESSION['username_member_r'])) {


            $stmtCods = $this->db->prepare("SELECT *FROM `{$this->register_user}` WHERE id = ?    LIMIT 1");
            $stmtCods->execute(array($id_member_r));
           $result=$stmtCods->fetch(PDO::FETCH_ASSOC);


                 $resultToken=array();
               $stmtToken = $this->db->prepare("SELECT *FROM `{$this->tokenAdmin}`  ");
                $stmtToken->execute(array());
                while ($row=$stmtToken->fetch(PDO::FETCH_ASSOC))
                {
                    $resultToken[]=$row['token'];
                }



            if (isset($_POST['submit'])) {

                $char=['"',"'"];
                $data['message']= strip_tags(str_replace($char,'',$_POST['message']));
                $data['id_r'] = $_SESSION['id_member_r'];
                $data['username_r'] = $_SESSION['username_member_r'];
                $data['admin'] = 'admin';
                $data['direction'] = 'left';
                $data['date'] = time();
                $data['read'] = 1;
                $data['date_day'] =strtotime(date('Y-m-d', time()));
                $data['last_chat'] =time();
                if (!empty($resultToken))
                {
                    $this->send( $resultToken,$_POST['message'],$result['name'],url.'/'.$this->folder.'/list_user/'.$data['id_r']);
                }

                $this->db->insert($this->table, $data);
                $this->db->update($this->register_user,array('last_chat'=>time()),"id='{$id_member_r}'");
             }

        } else {
            require($this->render($this->folder, 'html', 'login', 'php'));
        }

    }



    function chatCenter_admin($id)
    {


        if (is_null( $id)) {$error=new Errors(); $error->index();}
           $this->checkPermit('chat','chat');

        $stmt = $this->db->prepare("SELECT *FROM `{$this->register_user}` WHERE id = ?    LIMIT 1");
        $stmt->execute(array($id));
        $result = $stmt->fetch();

        $resultToken=array();
        $stmtToken = $this->db->prepare("SELECT *FROM `{$this->token}` WHERE id_member_r = ?  ");
        $stmtToken->execute(array($id));
        while ($row=$stmtToken->fetch(PDO::FETCH_ASSOC))
        {
            $resultToken[]=$row['token'];
        }

            if (isset($_POST['submit'])) {


                $x=explode('**',$_POST['message']);

                $r='';
                foreach ($x as $a)
                {

                    if (filter_var($a, FILTER_VALIDATE_URL)) {

                        $r.= " &nbsp&nbsp <a class='send_url' target='_blank' href='{$a}'>{$a}</a>  &nbsp&nbsp" ;
                    }else{

                        $r .=$a  ;

                    }

                }

//                echo $r;

//                $data['message'] = $r;
//                $data['id_r'] = $result['id'];
//                $data['username_r'] = $result['username'];
//                $data['admin'] = 'admin';
//                $data['direction'] = 'right';
//                $data['userid'] =  Session::get('userid');
//                $data['date'] = time();
//                $data['readUser'] = 1;
//                $data['date_day'] =strtotime(date('Y-m-d', time()));
//                $data['last_chat'] =time();

                $stmt=$this->db->prepare("INSERT INTO {$this->table} (`message`,`id_r`,`username_r`,`admin`,`direction`,`userid`,`date`,`readUser`,`date_day`,`last_chat`)  VALUE (?,?,?,?,?,?,?,?,?,?) ");
                $stmt->execute(array($r,$result['id'],$result['username'],'admin','right', Session::get('userid'),time(),1,strtotime(date('Y-m-d', time())),time()));
//                $this->db->insert($this->table, $data);
                $this->db->update($this->register_user,array('last_chat'=>time()),"id='{$id}'");
                $this->send( $resultToken,$_POST['message'],$this->langControl('title_website'),url.'/chat');
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

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }


    function action($id)
    {
        if(isset($_POST['token'])) {

            $stmt = $this->db->prepare("DELETE FROM `{$this->token}`  WHERE  `browser` = ? AND  `id_member_r` = ? ");
            $stmt->execute(array($this->ExactBrowserName(),$id));

            $stmt = $this->db->prepare("INSERT INTO `{$this->token}`  (`token`,`browser`,`id_member_r` ,`date`) values (?,?,?,?)");
            $stmt->execute(array($_POST['token'],$this->ExactBrowserName(),$id,time()));

            if($stmt->rowCount()>0) {
                echo 'Token Saved..';
            } else {
                echo 'Failed to saved token..';
            }
        }

    }

    function actionAdmin()
    {
        if(isset($_POST['token'])) {

            $stmt = $this->db->prepare("DELETE FROM `{$this->tokenAdmin}`  WHERE  `browser` = ? AND  `id_user` = ? ");
            $stmt->execute(array($this->ExactBrowserName(),Session::get('userid')));


            $stmt = $this->db->prepare("INSERT INTO `{$this->tokenAdmin}`  (`token`,`browser`,`id_user` ,`date`) values (?,?,?,?)");
            $stmt->execute(array($_POST['token'],$this->ExactBrowserName(),Session::get('userid'),time()));

            if($stmt->rowCount()>0) {
                echo 'Token Saved..';
            } else {
                echo 'Failed to saved token..';
            }
        }

    }



    function ExactBrowserName()
    {

        $ExactBrowserNameUA=$_SERVER['HTTP_USER_AGENT'];

        if (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/")) {
            // OPERA
            $ExactBrowserNameBR="Opera";
        } elseIf (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "chrome/")) {
            // CHROME
            $ExactBrowserNameBR="Chrome";
        } elseIf (strpos(strtolower($ExactBrowserNameUA), "msie")) {
            // INTERNET EXPLORER
            $ExactBrowserNameBR="Internet Explorer";
        } elseIf (strpos(strtolower($ExactBrowserNameUA), "firefox/")) {
            // FIREFOX
            $ExactBrowserNameBR="Firefox";
        } elseIf (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/")==false and strpos(strtolower($ExactBrowserNameUA), "chrome/")==false) {
            // SAFARI
            $ExactBrowserNameBR="Safari";
        } else {
            // OUT OF DATA
            $ExactBrowserNameBR="OUT OF DATA";
        };

        return $ExactBrowserNameBR;
    }

    function delete_message($date)
    {
        if (isset($_SESSION['id_member_r']))
        {
            if (!is_numeric( $date)) {$error=new Errors(); $error->index();}
            $stmt=$this->db->prepare("UPDATE  `{$this->table}` SET `is_delete` = 1  WHERE `id_r`=? AND `username_r` =? AND `date_day`=? ");
            $stmt->execute(array($_SESSION['id_member_r'],$_SESSION['username_member_r'],$date));
            if ($stmt->rowCount() > 0)
            {
                echo 'done';
            }
        }


    }

    function not_read($id)
    {
        if ($this->handleLogin())
        {
            if (is_null( $id)) {$error=new Errors(); $error->index();}

            $time=time();
            $stmt=$this->db->prepare("UPDATE  `{$this->table}` SET `read` = 1,`date`=?,`last_chat`=?  WHERE `id_r`=? AND `direction`='left' ORDER BY `id` DESC   LIMIT 1 ");
            $stmt->execute(array($time,$time,$id));
            if ($stmt->rowCount() > 0)
            {
                $stmt2=$this->db->prepare("UPDATE  `{$this->register_user}` SET `last_chat`=?  WHERE `id`=?  ");
                $stmt2->execute(array($time,$id));
                if ($stmt->rowCount()>0)
                {
                    echo 'done';
                }

            }

        }


    }


}