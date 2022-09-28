<?php
class Lang extends Controller
{
    function __construct()
    {
        parent::__construct();

        $this->table='lang';
        $this->setlang='setlang';
    }


    public function createTB()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `key` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `ar` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `en` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->setlang}` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `lang_site` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `active_lang_site` int(11) NOT NULL DEFAULT '0',
          `lang_control` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `active_lang_control` int(11) NOT NULL DEFAULT '0',
           PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $stmt=$this->db->select("SELECT *FROM `{$this->setlang}`");
        if (empty($stmt))
        {
            $stmt_lang=$this->db->insert($this->setlang,array('lang_site'=>'ar','active_lang_site'=>1));
            $stmt_lang=$this->db->insert($this->setlang,array('lang_control'=>'ar','active_lang_control'=>1));
        }

        return $this->db->cht(array($this->table, $this->setlang));
    }



    public function  set_l()
    {
        echo $this->langSite;
        echo $this->dirSite;
    }


    public function  langChang($lang)
    {

        $_SESSION[$this->session_language]=$lang;
    }


    public function  changeLangControl($lang)
    {

        $stmt=$this->db->prepare("UPDATE `$this->setlang` SET `active_lang_control` = 0 ");
        $stmt->execute();
        if ($stmt->rowCount()>0)
        {
            $stmtSet=$this->db->prepare("UPDATE `$this->setlang` SET `active_lang_control` = 1 WHERE `lang_control` = ?");
            $stmtSet->execute(array($lang));
            return true;
        }


    }



    public function  changeLangSite($lang)
    {

        $stmt=$this->db->prepare("UPDATE `$this->setlang` SET `active_lang_site` = 0 ");
        $stmt->execute();
        if ($stmt->rowCount()>0)
        {
            $stmtSet=$this->db->prepare("UPDATE `$this->setlang` SET `active_lang_site` = 1 WHERE `lang_site` = ?");
            $stmtSet->execute(array($lang));
//                return true;
            echo $lang;
        }


    }




    function view_lang()
    {
        $this->checkPermit('language','language');
        $this->adminHeaderController($this->langControl('website_translation'));

        $data['key']='';
        $data['ar']='';
        $data['en']='';
        if (isset($_POST['submit']))
        {
            try {
                $form = new  Form();
                $form->post('key')
                    ->val('is_empty', $this->langControl('field_key_word_empty'))
                    ->val('strip_tags');
                $form->post('ar')
                    ->val('is_empty', $this->langControl('field_ar_empty'))
                    ->val('strip_tags');
                $form->post('en')
                    ->val('is_empty',  $this->langControl('field_en_empty'))
                    ->val('strip_tags');
                $form ->submit();
                $data =$form -> fetch();
                $userCk = $this->db->select("SELECT * from  `lang` WHERE `key`=:key LIMIT 1 ",array(':key'=>$data['key']));
                if (count($userCk)>0)
                {
                    $this->error_form=array('key'=>'الكلمة موجودة بالفعل');
                }
                else
                {
                    $this->db->insert('lang',$data);
                    $this->lightRedirect( url.'/'.$this->folder.'/view_lang',0);

                }


            }

            catch (Exception $e)
            {
                $data =$form -> fetch();
                $this->error_form= json_decode($e -> getMessage(),true);
            }
        }



        require($this->render($this->folder, 'html', 'index', 'php'));
        $this->adminFooterController();

    }


    public function edit($id)
    {

        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('edit','language');

        $this->adminHeaderController($this->langControl('edit'));

        $stmt=$this->db->select("SELECT * from `{$this->table}` WHERE `id`=:id LIMIT 1 ",array(':id'=>$id));
        $result=$stmt[0];

        if (isset($_POST['submit']))
        {
            try {
                $form = new  Form();

                $form->post('key')
                    ->val('is_empty', $this->langControl('field_key_word_empty'))
                    ->val('strip_tags');
                $form->post('ar')
                    ->val('is_empty', $this->langControl('field_ar_empty'))
                    ->val('strip_tags');
                $form->post('en')
                    ->val('is_empty', $this->langControl('field_en_empty'))
                    ->val('strip_tags');
                $form ->submit();
                $data =$form -> fetch();

                if (empty($this->error_form))
                {
                    $this->db->update($this->table,$data,"id={$id}");

                    $this->lightRedirect( url.'/'.$this->folder.'/view_lang',0);

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




    public function processing()
    {


        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'key', 'dt' => 0 ),
            array( 'db' => 'ar', 'dt' => 1 ),
            array( 'db' => 'en', 'dt' => 2 ),


            array(
                'db'        => 'id',
                'dt'        => 3,
                'formatter' => function($id, $row ) {
                    return " 
                   <div style='text-align: center;font-size: 23px;'>
                    <a href=".url."/lang/edit/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db'        => 'id',
                'dt'        => 4,
                'formatter' => function($id, $row ) {
                    return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}' data-role='{$row[2]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                }
            ),
            array(  'db' => 'id', 'dt'=>5)


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
             SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns)
        );

    }



    public function delete($id)
    {
        if ($this->handleLogin()) {
            $response = $this->db->delete($this->table, "`id`={$id}");
        }

    }



}