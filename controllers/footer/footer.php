<?php
class Footer extends Controller
{

    function __construct()
    {
        parent::__construct();
        $this->setting=new Setting();

    }


    public function adminFooter()
    {


        require( $this->render($this->folder,'html','adminFooter','php'));

    }

    public function adminFooter2()
    {


        require( $this->render($this->folder,'html','smallAdminFooter','php'));

    }


    public function public_footer()
    {

        if ($this->setting->get('id_logo') != 0) {
            $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $this->setting->get('id_logo'), ':module' => 'logo_site'));
            $get_file = $get_file[0];
            $Img = $this->save_file .$get_file['rand_name'];

        }else
        {
            $Img=$this->static_file_control.'/image/site/logo.png';
        }

        $mobile =new mobile();
        $stmt_category_mobile=$mobile->select_category_mobile_publicAll();
        $category_mobile=array();
        while ($row=$stmt_category_mobile->fetch(PDO::FETCH_ASSOC))
        {
            $category_mobile[]=$row;
        }

        $pages =new pages();
        $category=$pages->select_category_pages(0);
        $categorypages=array();
        while ($row=$category->fetch(PDO::FETCH_ASSOC))
        {
            $categorypages[]=$row;
        }



        $msg=false;
        if (isset($_SESSION['username_member_r']))
        {


            $stmt=$this->db->prepare("SELECT *FROM `register_user`  WHERE id =? AND `note` <> '' ");
            $stmt->execute(array($_SESSION['id_member_r']));
            if ($stmt->rowCount()>0)
            {
                $msg=true;
               $note = $stmt->fetch(PDO::FETCH_ASSOC);
            }

        }





        require( $this->render($this->folder,'html','footer','php'));

    }



}