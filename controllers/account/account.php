<?php

class Account extends Controller {
    function __construct()
    {
        parent::__construct();
        $this->account_catg = 'account_catg';
        $this->person = 'person';
        $this->menu=new Menu();


        $this->setting = new Setting();
    }

    public function createTB()
    {
        /*
        * Create Table account_catg
        * Created 2022/10/12
        * جدول خاص بفئات الحسابات
        */

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->account_catg}` (
            `id` int(4) Unsigned  NOT NULL AUTO_INCREMENT ,
            `title` varchar(150) NOT NULL,
            `active` TINYINT(1) NOT NULL,
            `relid`  int(4) Unsigned  NOT NULL,
            `idbranch` int(4) Unsigned,
            `iduser` int(4) NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id),
            FOREIGN KEY (`idbranch`) REFERENCES branch(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        // جدول الفروع
        $this->db->query("CREATE TABLE IF NOT EXISTS `branch` (
            `id` int(4) Unsigned  NOT NULL AUTO_INCREMENT ,
            `title` varchar(150) NOT NULL,
            `active` TINYINT(1) NOT NULL,
            `relid`  int(4) Unsigned  NOT NULL,
            `iduser` int(4) NOT NULL,
            `date` bigint(20) NOT NULL,
            `note` varchar(150) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        // ......خاص بجميع المستخدمين و الزبائن و الموظفين و
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->person}` (
            `id` int(11) Unsigned  NOT NULL AUTO_INCREMENT,
            `first_name` varchar(50)  COLLATE utf8_unicode_ci NOT NULL,
            `name` varchar(100)  COLLATE utf8_unicode_ci NOT NULL,
            `phone` varchar(50)  COLLATE utf8_unicode_ci NOT NULL,
            `job` varchar(50)  COLLATE utf8_unicode_ci NOT NULL,
            `country` varchar(50)  COLLATE utf8_unicode_ci NOT NULL,
            `city` varchar(50)  COLLATE utf8_unicode_ci NOT NULL,
            `address` varchar(50)  COLLATE utf8_unicode_ci NOT NULL,
            `type_customer` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
            `type_customer12` varchar(50)  COLLATE utf8_unicode_ci NOT NULL,
            `uid` varchar(200)  COLLATE utf8_unicode_ci NOT NULL,
            `login` varchar(50)  COLLATE utf8_unicode_ci NOT NULL,
            `brithday` varchar(50)  COLLATE utf8_unicode_ci NOT NULL,
            `gander` varchar(50)  COLLATE utf8_unicode_ci NOT NULL,
            `model` varchar(50)  COLLATE utf8_unicode_ci NOT NULL,
            `id_user_screen` int(11),
            `note` varchar(50)  COLLATE utf8_unicode_ci NOT NULL,
            `xc` TINYINT(1) NOT NULL,
            `iduser` int(4) NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        return $this->db->cht(array($this->account_catg));
    }

    public function index()
    {
        $index = new Index();
        $index->index();
    }

    // عرض فئات الحسابات
    function account_catg($relid = 0)
    {
        $account = '';
        $stmt = $this->db->prepare("SELECT `title`,`id` FROM `{$this->account_catg}` WHERE active = 1 AND relid = ?");
        $stmt->execute(array($relid));
        if($stmt->rowCount() > 0){
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $account .= "<ul>";
                if ($this->permit($row['title'],'account')) {
                    if($this->check_child_account($row['id'])){
                        $account .= "<li class='account'> <a href='#'>";
                    }else{
                        $account .= "<li class='account'> <a href='".url."/account/view_user_account/".$row['id']."'> ";

                    }

                    $account .= $row['title'] .'</a>';
                    $account .= "  <a href='".url."/account/add_catg_account/".$row['id']."' class='account' data-toggle='tooltip' data-placement='top' title='اضافة فئة'><i class='fa  fa-folder' aria-hidden='true'></i></a>
                    <a href='".url."/account/add_account/".$row['id']."' class='account' data-toggle='tooltip' data-placement='top' title='اضافة حساب'><i class='fa fa-plus' aria-hidden='true'></a></i>";
                    $account .= $this->account_catg($row['id']);
                }
                $account .= " </ul>";
            }
        }

        return $account;
    }


    public function check_child_account($id){
        $check = false;
        $stmt = $this->db->prepare("SELECT `id` FROM `{$this->account_catg}` WHERE active = 1 AND relid = ? LIMIT 1 ");
        $stmt->execute(array($id));
        if($stmt->rowCount() > 0){
            $check = true;
        }
        return $check;
    }

    // صفحة اضافة فئة
    public function add_catg_account($id = 0){
        $this->checkPermit('add_catg_account','account');
        $this->adminHeaderController($this->langControl('account'));

        $nameCategory = array();
        $name_catg =$this->db->prepare("SELECT `title`,`id` FROM `{$this->account_catg}` WHERE active = 1");
        $name_catg->execute();

        while ($row = $name_catg->fetch(PDO::FETCH_ASSOC))
        {
            $nameCategory[]=$row;
        }

        $nameBranch = array();
        $name_branch =$this->db->prepare("SELECT `title`,`id` FROM `branch` WHERE active = 1");
        $name_branch->execute();

        while ($row = $name_branch->fetch(PDO::FETCH_ASSOC))
        {
            $nameBranch[]=$row;
        }


        require ($this->render($this->folder,'html','add_catg_account','php'));
        $this->adminFooterController();
    }

    // اضافة الفئة الجديده
    public function create_account_catg(){
        $data = json_decode($_GET['jsonData'], true);

        $stmt = $this->db->prepare("INSERT INTO `{$this->account_catg}`(`title`,`active`,`relid`,`idbranch`,`iduser`,`date`) VALUE (?,?,?,?,?,?)");
        $stmt->execute(array($data['name'],1,$data['relid'],$data['idbranch'],$this->userid,time()));
        if($stmt->rowCount() > 0){
            echo 1;
        }else{
            echo 0;
        }
    }

    // // الفئات التابعه للفئة الاصلية
    // public function get_sub_catg()
    // {
    //     $data = json_decode($_GET['jsonData'], true);
    //     $id = $data['id'];
    //     $item = array();
    //     $select = '';
    //     $stmt = $this->db->prepare("SELECT `id`,`title` FROM `{$this->account_catg}` WHERE active = 0 AND relid = ?");
    //     $stmt->execute(array($id));
    //     if($stmt->rowCount() > 0){
    //         $select .= "<select  name='sub_categ'  id='sub_cags_p'  class='custom-select col-md-2  mb-4 ml-2 list_menu_categ' onchange='sub_catgs(this)' >";
    //         $select .="<option value='0'  selected >  نوع الحساب   </option>"  ;
    //         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    //             $select .="<option value='{$row['id']}'>{$row['title']}</option>"  ;

    //         }
    //         $select .='</select>';
    //     }
    //     echo $select;


    // }

    // // كل الفئات التابعات للفئة لثانويه
    // public function get_sub_catgs()
    // {
    //     $data = json_decode($_GET['jsonData'], true);
    //     $id = $data['id'];
    //     $item = array();
    //     $select = '';
    //     $stmt = $this->db->prepare("SELECT `id`,`title` FROM `{$this->account_catg}` WHERE active = 0 AND relid = ?");
    //     $stmt->execute(array($id));
    //     if($stmt->rowCount() > 0){
    //         $select .= "<select  name='sub_categ'  id='sub_cags_$id'  class='custom-select col-md-2  mb-4 ml-2 list_menu_categ' onchange='sub_catgs(this)'>";
    //         $select .="<option value='0'  selected >  نوع الحساب   </option>"  ;
    //         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    //             $select .="<option value='{$row['id']}'>{$row['title']}</option>"  ;

    //         }
    //         $select .='</select>';
    //     }
    //     echo $select;


    // }


    // public function get_sub_branch()
    // {
    //     $data = json_decode($_GET['jsonData'], true);
    //     $id = $data['id'];
    //     $item = array();
    //     $select = '';
    //     $stmt = $this->db->prepare("SELECT `id`,`title` FROM `branch` WHERE active = 0 AND relid = ?");
    //     $stmt->execute(array($id));
    //     if($stmt->rowCount() > 0){
    //         $select .= "<select  name='main_branch'  id='sub_branch'  class='custom-select col-md-2  mb-4 ml-2 list_menu_categ' onchange='sub_branches(this)' >";
    //         $select .="<option value='0'  selected >  نوع الحساب   </option>"  ;
    //         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    //             $select .="<option value='{$row['id']}'   >{$row['title']}</option>"  ;

    //         }
    //         $select .='</select>';
    //     }
    //     echo $select;


    // }

    // // كل الفئات التابعات للفئة لثانويه
    // public function get_sub_branches()
    // {
    //     $data = json_decode($_GET['jsonData'], true);
    //     $id = $data['id'];
    //     $item = array();
    //     $select = '';
    //     $stmt = $this->db->prepare("SELECT `id`,`title` FROM `branch` WHERE active = 0 AND relid = ?");
    //     $stmt->execute(array($id));
    //     if($stmt->rowCount() > 0){
    //         $select .= "<select  name='main_branch'  id='sub_branches_$id'  class='custom-select col-md-2  mb-4 ml-2 list_menu_categ' onchange='sub_branches(this)'>";
    //         $select .="<option value='0'  selected >  نوع الحساب   </option>"  ;
    //         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    //             $select .="<option value='{$row['id']}'>{$row['title']}</option>"  ;

    //         }
    //         $select .='</select>';
    //     }
    //     echo $select;


    // }


    // صفحة اضافة حساب
    public function add_account($id=0){
        $this->checkPermit('add_account','account');
        $this->adminHeaderController($this->langControl('account'));

        $nameCategory = array();
        $name_catg =$this->db->prepare("SELECT `id`,`title` FROM `{$this->account_catg}` WHERE active = 1");
        $name_catg->execute();

        while ($row = $name_catg->fetch(PDO::FETCH_ASSOC))
        {
            $nameCategory[]=$row;
        }


        $nameBranch = array();
        $name_branch =$this->db->prepare("SELECT `id`,`title` FROM `branch` WHERE active = 1");
        $name_branch->execute();

        while ($row = $name_branch->fetch(PDO::FETCH_ASSOC))
        {
            $nameBranch[]=$row;
        }


        // عرض العملات
        $stmt_currency =$this->db->prepare("SELECT `id`,`name` FROM `currency`");
        $stmt_currency->execute();
        $currency=array();
        while ($row_currency= $stmt_currency->fetch(PDO::FETCH_ASSOC))
        {
            $currency[]=$row_currency;
        }


        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();

                $form->post('name')
                    ->val('strip_tags');

                $form->post('phone')
                    ->val('strip_tags');

                $form->post('job')
                    ->val('strip_tags');

                $form->post('country')
                    ->val('strip_tags');

                $form->post('city')
                    ->val('strip_tags');

                $form->post('address')
                    ->val('strip_tags');

                $form->post('gander')
                    ->val('strip_tags');

                $form->post('brithday')
                    ->val('strip_tags');

                $form->post('note')
                    ->val('strip_tags');



                $form->submit();

                $data = $form->fetch();

                if (empty($this->error_form)) {

                    $stmt = $this->db->prepare("INSERT INTO `{$this->person}`(`name`,`phone`,`job`,`country`,`city`,`address`,`gander`,`brithday`,`note`,`iduser`,`date`) VALUE (?,?,?,?,?,?,?,?,?,?,?)");
                    $stmt->execute(array($data['name'],$data['phone'],$data['job'],$data['country'],$data['city'],$data['address'],$data['gander'],$data['brithday'],$data['note'],$this->userid,time()));

                }

            } catch (Exception $e) {

                $this->error_form = json_decode($e->getMessage(), true);
            }
        }

        require ($this->render($this->folder,'html','add_account','php'));
        $this->adminFooterController();
    }



    // عرض كل الزبائن
    public function view_user_account($id)
    {

        $this->adminHeaderController($this->langControl('account'));

        require ($this->render($this->folder,'html','view_user_account','php'));
        $this->adminFooterController();
    }





}