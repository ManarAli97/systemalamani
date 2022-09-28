<?php

class Contact extends Controller
{


    function __construct()
    {
        parent::__construct();
        $this->table = 'message';
        $this->menu=new Menu();
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `id_r` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `message`  longtext COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
           `userid` int(11) COLLATE utf8_unicode_ci NOT NULL,
          
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table));


    }

    public function index()
    {

//        if (isset($_SESSION['username_member_r'])) {
//
//        require ($this->render($this->folder,'html','index','php'));
//        } else {
//            require($this->render('register', 'html', 'login', 'php'));
//        }


        require ($this->render($this->folder,'html','index','php'));


    }


    public function form()
    {
        $userid=0;
        if (isset($_SESSION['id_member_r'])) {
           $id= $_SESSION['id_member_r'];
        }else{
            $id=0;
            $userid=$this->userid;
        }

        if (isset($_POST['submit'])) {

            try {
                $form = new Form();

                $form->post('message')
                    ->val('is_empty','الحقل فارغ.')
                    ->val('strip_tags');

                $form->submit();
                $data = $form->fetch();

                    $stmt=$this->db->prepare("INSERT INTO `{$this->table}` (`id_r`,`message`,`date`,`userid`) VALUES (?,?,?,?)");
                    $stmt->execute(array($id,$data['message'],time(),$userid));
                    if ($stmt->rowCount()>0)
                    {
                        echo json_encode(array('done'=>array('done'=>'تم ارسال رسالتكم بنجاح شكرا لتواصلكم معنا .')),JSON_FORCE_OBJECT);

                    }


            } catch (Exception $e) {
                $this->error_form = $e->getMessage();
                echo json_encode(array('error'=>json_decode($this->error_form)),JSON_FORCE_OBJECT);
            }

        }


//        }else
//        {
//            echo json_encode(array('login'=>array('login'=>'يرجى تسجيل الدخول')),JSON_FORCE_OBJECT);
//        }
    }


}
?>