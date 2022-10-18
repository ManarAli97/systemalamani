<?php

class Account extends Controller {
    function __construct()
    {
        parent::__construct();
        $this->account_catg = 'account_catg'; // purchase table name (تفاصيل المشتريات)
        // $this->purchase_item = 'purchase_item'; // purchase_item table name (مواد الشراء)
        // $this->supplier = 'supplier';  // supplier table name (الموردين)
        // $this->source_request = 'source_request'; // source_request table name (مصدر الطلب ,دولة او محافظة)
        // $this->type_shipping = 'type_shipping'; // type_Shipping table name (نوع الشحن)
        $this->menu=new Menu();


        $this->setting = new Setting();
    }

    public function createTB()
    {
        /*
        * Create Table account_catg
        * Created 2022/10/12
        *
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
        $stmt = $this->db->prepare("SELECT `title`,`id` FROM `{$this->account_catg}` WHERE active = 0 AND relid = ?");
        $stmt->execute(array($relid));
        if($stmt->rowCount() > 0){
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $account .= "<ul>";
                if ($this->permit($row['title'],'account')) {
                    if($this->check_child_account($row['id'])){
                        $account .= "<li class='account'> <a href='#'>";
                    }else{
                        $account .= "<li class='account'> <a href='".url."/account/view_user_account/".$row['id']."'>";
                    }
                    // $account .= "/account/view_user_account/".strval($row['title'])."/".$row['id']."'>";
                    $account .= $row['title'] . $this->account_catg($row['id']);
                    $account .= " </a></li>";
                }
                $account .= " </ul>";
            }
        }

        return $account;
    }

    public function check_child_account($id){
        $check = false;
        $stmt = $this->db->prepare("SELECT `id` FROM `{$this->account_catg}` WHERE active = 0 AND relid = ? LIMIT 1 ");
        $stmt->execute(array($id));
        if($stmt->rowCount() > 0){
            $check = true;
        }
        return $check;
    }

    public function add_catg_account(){
        $this->checkPermit('add_catg_account','account');
        $this->adminHeaderController($this->langControl('account'));

        $nameCategory = array();
        $name_catg =$this->db->prepare("SELECT `title`,`id` FROM `{$this->account_catg}` WHERE active = 0 AND relid = 0");
        $name_catg->execute();

        while ($row = $name_catg->fetch(PDO::FETCH_ASSOC))
        {
            $nameCategory[]=$row;
        }

        $nameBranch = array();
        $name_branch =$this->db->prepare("SELECT `title`,`id` FROM `branch` WHERE active = 0 AND relid = 0");
        $name_branch->execute();

        while ($row = $name_branch->fetch(PDO::FETCH_ASSOC))
        {
            $nameBranch[]=$row;
        }

        // if (isset($_POST['submit'])) {
        //     try {
        //         $form = new  Form();
        //         $form->post('name_categ')
        //             ->val('strip_tags');

        //         $form->post('main_catg')
        //             ->val('strip_tags');

        //         $form->post('sub_categ')
        //             ->val('strip_tags');

        //         $form->post('main_branch')
        //             ->val('strip_tags');

        //         $form->post('sub_branch')
        //             ->val('strip_tags');


        //         $form->submit();
        //         $data = $form->fetch();

        //         if (empty($this->error_form)) {
        //             echo $data['main_catg'];
        //             $relid =  0;
        //             if($data['main_catg'] !='0' && $data['sub_categ'] == '0'){
        //                 $relid =  $data['main_catg'];
        //             }elseif($data['sub_categ'] == '0'){
        //                 $relid =  $data['main_catg'];
        //             }else{
        //                 $relid =  $data['sub_categ'];
        //             }

        //             // $idbranch =  0;
        //             // if($data['main_branch'] !=0){
        //             //     $idbranch =  $data['sub_branch'];
        //             // }

        //             if($data['name_categ'] != ''){
        //                 $stmt = $this->db->prepare("INSERT INTO `{$this->account_catg}` (`title`,`active`,`relid`,`iduser`,`date`) VALUE (?,?,?,?,?)");
        //                 $stmt->execute(array($data['name_categ'],0,$relid,$this->userid,time()));
        //             }
        //         }

        //     } catch (Exception $e) {
        //         $this->error_form = json_decode($e->getMessage(), true);
        //     }
        // }
        require ($this->render($this->folder,'html','add_catg_account','php'));
        $this->adminFooterController();
    }

    public function create_account_catg(){
        $data = json_decode($_GET['jsonData'], true);

        $stmt = $this->db->prepare("INSERT INTO `{$this->account_catg}` (`title`,`active`,`relid`,`idbranch`,`iduser`,`date`) VALUE (?,?,?,?,?,?)");
        $stmt->execute(array($data['name'],0,$data['relid'],$data['idbranch'],$this->userid,time()));
        if($stmt->rowCount() > 0){
            echo 1;
        }else{
            echo 0;
        }
    }

    // الفئات التابعه للفئة الاصلية
    public function get_sub_catg()
    {
        $data = json_decode($_GET['jsonData'], true);
        $id = $data['id'];
        $item = array();
        $select = '';
        $stmt = $this->db->prepare("SELECT `id`,`title` FROM `{$this->account_catg}` WHERE active = 0 AND relid = ?");
        $stmt->execute(array($id));
        if($stmt->rowCount() > 0){
            $select .= "<select  name='sub_categ'  id='sub_cags_p'  class='custom-select col-md-2  mb-4 ml-2 list_menu_categ' onchange='sub_catgs(this)' >";
            $select .="<option value='0'  selected >  نوع الحساب   </option>"  ;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $select .="<option value='{$row['id']}'>{$row['title']}</option>"  ;

            }
            $select .='</select>';
        }
        echo $select;


    }

    // كل الفئات التابعات للفئة لثانويه
    public function get_sub_catgs()
    {
        $data = json_decode($_GET['jsonData'], true);
        $id = $data['id'];
        $item = array();
        $select = '';
        $stmt = $this->db->prepare("SELECT `id`,`title` FROM `{$this->account_catg}` WHERE active = 0 AND relid = ?");
        $stmt->execute(array($id));
        if($stmt->rowCount() > 0){
            $select .= "<select  name='sub_categ'  id='sub_cags_$id'  class='custom-select col-md-2  mb-4 ml-2 list_menu_categ' onchange='sub_catgs(this)'>";
            $select .="<option value='0'  selected >  نوع الحساب   </option>"  ;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $select .="<option value='{$row['id']}'>{$row['title']}</option>"  ;

            }
            $select .='</select>';
        }
        echo $select;


    }


    public function get_sub_branch()
    {
        $data = json_decode($_GET['jsonData'], true);
        $id = $data['id'];
        $item = array();
        $select = '';
        $stmt = $this->db->prepare("SELECT `id`,`title` FROM `branch` WHERE active = 0 AND relid = ?");
        $stmt->execute(array($id));
        if($stmt->rowCount() > 0){
            $select .= "<select  name='main_branch'  id='sub_branch'  class='custom-select col-md-2  mb-4 ml-2 list_menu_categ' onchange='sub_branches(this)' >";
            $select .="<option value='0'  selected >  نوع الحساب   </option>"  ;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $select .="<option value='{$row['id']}'   >{$row['title']}</option>"  ;

            }
            $select .='</select>';
        }
        echo $select;


    }

    // كل الفئات التابعات للفئة لثانويه
    public function get_sub_branches()
    {
        $data = json_decode($_GET['jsonData'], true);
        $id = $data['id'];
        $item = array();
        $select = '';
        $stmt = $this->db->prepare("SELECT `id`,`title` FROM `branch` WHERE active = 0 AND relid = ?");
        $stmt->execute(array($id));
        if($stmt->rowCount() > 0){
            $select .= "<select  name='main_branch'  id='sub_branches_$id'  class='custom-select col-md-2  mb-4 ml-2 list_menu_categ' onchange='sub_branches(this)'>";
            $select .="<option value='0'  selected >  نوع الحساب   </option>"  ;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $select .="<option value='{$row['id']}'>{$row['title']}</option>"  ;

            }
            $select .='</select>';
        }
        echo $select;


    }


    public function add_account(){
        $this->checkPermit('add_account','account');
        $this->adminHeaderController($this->langControl('account'));

        require ($this->render($this->folder,'html','add_account','php'));
        $this->adminFooterController();
    }

    public function view_user_account($id)
    {

        $this->adminHeaderController($this->langControl('account'));

        require ($this->render($this->folder,'html','view_user_account','php'));
        $this->adminFooterController();
    }



}