<?php

class Setting extends Controller
{


    function __construct()
    {
        parent::__construct();
        $this->table = 'setting';
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `set` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `content` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
          `lang` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
          `userid` int(11) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table));


    }


    function prepared_serial_or_code($flag)
    {
        if ($this->handleLogin())
        {
            if ($flag==0)
            {
                $this->set('prepared_serial_or_code',0) ;
            }else
            {
                $this->set('prepared_serial_or_code',1) ;
            }

        }

    }


    public function index()
    {
        $index = new Index();
        $index->index();
    }

    public function update()
    {

        $this->checkPermit('edit_setting','setting');
        $this->adminHeaderController($this->langControl('edit_setting'));
        $idImg=0;
        if ($this->get('id_logo') != 0) {
            $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $this->get('id_logo'), ':module' => 'logo_site'));
            $get_file = $get_file[0];
            $idImg = $get_file['id'];
        }

        if (isset($_POST['submit']))
        {

            try
            {
                $form =new Form();
                $form ->post('print_qr')
                    ->val('strip_tags');
                $form ->post('note')
                    ->val('strip_tags');

                $form ->post('number_phone_first')
                    ->val('strip_tags');

                $form ->post('number_phone_second')
                    ->val('strip_tags');

                $form ->post('email')
                    ->val('strip_tags');

                $form ->post('email_message')
                    ->val('strip_tags');

                $form ->post('address')
                    ->val('strip_tags');
                $form ->post('amount_bill')
                    ->val('strip_tags');

                $form  ->post('copyright')
                    ->val('strip_tags',TAG);

                $form  ->post('aboutus')
                    ->val('strip_tags',TAG);

                $form  ->post('files')
                    ->val('strip_tags');
                $form  ->post('hour')
                    ->val('strip_tags');

                $form ->submit();
                $data =$form -> fetch();

                $this->set('print_qr',trim($data['print_qr']));
                $this->set('note',$data['note']);
                $this->set('number_phone_first',$data['number_phone_first']);
                $this->set('number_phone_second',$data['number_phone_second']);
                $this->set('email',$data['email']);
                $this->set('email_message',$data['email_message']);
                $this->set('address',$data['address']);
                $this->set('copyright',$data['copyright']);
                $this->set('aboutus',$data['aboutus']);
                $this->set('amount_bill',$data['amount_bill']);
                $this->set('hour',$data['hour']);

                if (!empty($data['files']))
                {
                    if ($idImg != 0)
                    {
                        @unlink($this->root_file.$get_file['rand_name']);
                        $this->db->delete('files',"id={$get_file['id']}");
                    }
                    $file=new Files();
                    $this->set('id_logo', $file->insert_file( 'logo_site',1010,json_decode($data['files'],True)));
                }
                else
                {
                    $this->set('id_logo', $idImg);
                }



                $this->lightRedirect( url.'/'.$this->folder.'/update',0);


            }
            catch (Exception $e)
            {
                $this->error_form= $e -> getMessage();
            }
        }
        require ($this->render($this->folder,'html','setting','php'));
        $this->adminFooterController();
    }


    public function image()
    {

        $this->checkPermit('edit_setting','setting');
        $this->adminHeaderController($this->langControl('edit_setting'));

        if (isset($_POST['submit']))
        {
            try
            {
                $form =new Form();


                $form ->post('width')
                    ->val('strip_tags');

                $form ->post('height')
                    ->val('strip_tags');

                $form ->post('proportional')
                    ->val('strip_tags');

                $form ->post('quality')
                    ->val('strip_tags');

                $form ->post('grayscale')
                    ->val('strip_tags');


                $form ->submit();
                $data =$form -> fetch();

                $this->set('width',$data['width']);
                $this->set('height',$data['height']);
                $this->set('proportional',$data['proportional']);
                $this->set('quality',$data['quality']);
                $this->set('grayscale',$data['grayscale']);

               $this->lightRedirect( url.'/'.$this->folder.'/image',0);


            }
            catch (Exception $e)
            {
                $this->error_form= $e -> getMessage();
            }
        }
        require ($this->render($this->folder,'html','image','php'));
        $this->adminFooterController();
    }
    public function link_social_media()
    {

        $this->checkPermit('edit_setting','setting');
        $this->adminHeaderController($this->langControl('edit_setting'));

        if (isset($_POST['submit']))
        {

            try
            {
                $form =new Form();
                $form ->post('facebook')
                    ->val('strip_tags');

                $form ->post('instagram')
                    ->val('strip_tags');

                $form ->post('telegram')
                    ->val('strip_tags');



                $form ->post('whatsapp')
                    ->val('strip_tags');

                $form ->post('linkedin')
                    ->val('strip_tags');

                $form ->post('youtube')
                    ->val('strip_tags');




                $form ->submit();
                $data =$form -> fetch();

                $this->set('facebook',$data['facebook']);
                $this->set('instagram',$data['instagram']);
                $this->set('telegram',$data['telegram']);
                $this->set('whatsapp',$data['whatsapp']);
                $this->set('linkedin',$data['linkedin']);
                $this->set('youtube',$data['youtube']);


               $this->lightRedirect( url.'/'.$this->folder.'/link_social_media',0);


            }
            catch (Exception $e)
            {
                $this->error_form= $e -> getMessage();
            }
        }
        require ($this->render($this->folder,'html','link_social_media','php'));
        $this->adminFooterController();
    }




            public function  set($set,$content)
            {

            if ($this->handleLogin()) {
              $stmt=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE `set`= ? AND `lang` = ?");
              $stmt->execute(array($set,$this->langControl));
              if ($stmt->rowCount()> 0)
              {
                  $stmt=$this->db->prepare("UPDATE `{$this->table}` SET `content` = ? , `userid`=? WHERE   `set`= ? AND `lang`= '{$this->langControl}'");
                  $stmt->execute(array($content,$this->userid,trim($set)));

              }else{
                  $stmt=$this->db->prepare("INSERT INTO `{$this->table}` (`set`,`content`,`lang`,`userid`,`date`) VALUES (?,?,?,?,?)");
                  $stmt->execute(array(trim($set),$content,trim($this->langControl),$this->userid,time()));
              }


              if ($stmt->rowCount() > 0)
              {
                  return true;
              }else
              {
                 return false;
              }
            }

            }


            public function get($set,$content=null)
            {

                $stmt=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE `set` = ? AND `lang` = ?");
                $stmt->execute(array($set,$this->langControl));
                if ($stmt->rowCount() > 0)
                {
                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                    return $result['content'];
                }else
                {

                    return $content;
                }
            }

            public function get_site($set,$content=null)
            {

                $stmt=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE `set` = ? AND `lang` = ?");
                $stmt->execute(array($set,$this->langSite));
                if ($stmt->rowCount() > 0)
                {
                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                    return $result['content'];
                }else
                {

                    return $content;
                }
            }


            public function changeLanguage()
            {
                $this->checkPermit('changeLanguage','setting');
                $this->adminHeaderController($this->langControl('changeLanguage'));

                $stmtControl=$this->db->prepare("SELECT *FROM `setlang` WHERE `lang_control` <> '' ");
                $stmtControl->execute();
                $langControl=array();
                while ($row = $stmtControl->fetch(PDO::FETCH_ASSOC))
                {

                    if ($row['lang_control'] == $this->langControl)
                    {
                        $row['selectLang'] ='selected';
                    }
                    else
                    {
                        $row['selectLang'] =null;
                    }

                    $langControl[]=$row;
                 }



                $stmtSite=$this->db->prepare("SELECT *FROM `setlang` WHERE `lang_site` <> '' ");
                $stmtSite->execute();
                $langSite=array();
                while ($row = $stmtSite->fetch(PDO::FETCH_ASSOC))
                {

                    if ($row['lang_site'] == $this->langSite)
                    {
                        $row['selectSite'] ='selected';
                    }
                    else
                    {
                        $row['selectSite'] =null;
                    }

                    $langSite[]=$row;
                 }




                require ($this->render($this->folder,'html','changeLanguage','php'));

            }



            public function viewPage($v)
            {

                if (is_numeric($v) ) {
                    $v=1;

                } else {
                    $v = 0;
                }

                $this->set('viewPage',$v);

            }




            function delete_logo($id)
            {
                if ($this->handleLogin() ) {
                    $response = $this->db->update($this->table,array('content'=>0),"`set`='id_logo'");
                    $response = $this->db->delete('files',"`id`={$id} AND `module`='logo_site'",0);
                    echo 'true';
                }
            }



}