<?php

class Account extends Controller {
    function __construct()
    {
        parent::__construct();
        $this->account_catg = 'ac_account_catg';    // فئات الحسابات
        $this->general_info = 'ac_general_info';    // معلومات الحساب العامة
        $this->account = 'ac_account';              // هذا الجدول خاصة بمعلومات الحساب الاضافية
        $this->price_list = 'ac_price_list';        //(مفرد , جملة, جملة الجملة)قائمة الاسعار
        $this->price_style = 'ac_price_style';      // نقدي , نقدي و اجل , اجل ,اقساط

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

        /* ......خاص بجميع المستخدمين و الزبائن و الموظفين و
         * stop (منع التعامل)
        */
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->general_info}` (
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
            `active` TINYINT(1) NOT NULL,
            `stop` TINYINT(1) NOT NULL,
            `iduser` int(4) NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->account}` (
            `id` int(11) Unsigned  NOT NULL AUTO_INCREMENT,
            `id_info`  int(11) Unsigned  NOT NULL,
            `id_cat`  int(11) Unsigned  NOT NULL,
            `id_branch` int(4) Unsigned NOT NULL,
            `mth_goal_amount` float NOT NULL,
            `mth_goal_currency`  TINYINT(1) Unsigned  NOT NULL,
            `duration_of_debt` float NOT NULL,
            `max_debt_limit` float NOT NULL,
            `currency_debt_limit` TINYINT(1) Unsigned  NOT NULL,
            `id_price_list` TINYINT(1) Unsigned NOT NULL,
            `id_price_style` TINYINT(1) Unsigned NOT NULL,
            `iduser` int(4) NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id),
            FOREIGN KEY (`id_info`) REFERENCES ac_general_info(id),
            FOREIGN KEY (`id_cat`) REFERENCES ac_account_catg(id),
            FOREIGN KEY (`id_branch`) REFERENCES branch(id),
            FOREIGN KEY (`id_price_list`) REFERENCES ac_price_list(id),
            FOREIGN KEY (`id_price_style`) REFERENCES ac_price_style(id),
            FOREIGN KEY (`mth_goal_currency`) REFERENCES currency(id),
            FOREIGN KEY (`currency_debt_limit`) REFERENCES currency(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->price_list}` (
            `id` TINYINT(1) Unsigned  NOT NULL AUTO_INCREMENT ,
            `title` varchar(50) NOT NULL,
            `active` TINYINT(1) NOT NULL,
            `iduser` int(4) NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->price_style}` (
            `id` TINYINT(1) Unsigned  NOT NULL AUTO_INCREMENT ,
            `title` varchar(50) NOT NULL,
            `active` TINYINT(1) NOT NULL,
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
                    <a href='".url."/account/add_account/".$row['id']."' class='account' data-toggle='tooltip' data-placement='top' title='اضافة حساب'><i class='fa fa-plus' aria-hidden='true'></i></a>";
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
        $id_account = 0;
        // ترجع الفئات التابعه للفئة الاصلية
        $nameCategory= $this->get_name_rel_catg($id);

        // هنا حتى نأخذ الفئة الاصلية الي دخل عليها الزبون
        $name_current_catg = $this->db->prepare("SELECT `id`,`title` FROM `{$this->account_catg}` WHERE active = 1 AND id = ?");
        $name_current_catg->execute(array($id));
        if($name_current_catg->rowCount() > 0){
            $row_name[] = $name_current_catg->fetch(PDO::FETCH_ASSOC);
            if(!empty($nameCategory)){
                $nameCategory = array_merge($row_name,$nameCategory);
            }else{
                $nameCategory = $row_name;
            }
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


        $priceList = array();
        $stmt_price_list =$this->db->prepare("SELECT `id`,`title` FROM `{$this->price_list}` WHERE active = 1");
        $stmt_price_list->execute();

        while ($row_list= $stmt_price_list->fetch(PDO::FETCH_ASSOC))
        {
            $priceList[]=$row_list;
        }

        $priceStyle = array();
        $stmt_price_style =$this->db->prepare("SELECT `id`,`title` FROM `{$this->price_style}` WHERE active = 1");
        $stmt_price_style->execute();

        while ($row_style = $stmt_price_style->fetch(PDO::FETCH_ASSOC))
        {
            $priceStyle[]=$row_style;
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

                $form->post('state')
                    ->val('strip_tags');

                $form->post('stop')
                    ->val('strip_tags');


                $form->post('type_account')
                    ->val('strip_tags');

                $form->post('branch')
                    ->val('strip_tags');

                $form->post('price_list')
                    ->val('strip_tags');

                $form->post('mth_goal_amount')
                    ->val('strip_tags');

                $form->post('mth_goal_currency')
                    ->val('strip_tags');

                $form->post('duration_of_debt')
                    ->val('strip_tags');

                $form->post('max_debt_limit')
                    ->val('strip_tags');

                $form->post('currency_debt_limit')
                    ->val('strip_tags');

                $form->post('price_style')
                    ->val('strip_tags');

                $form->submit();

                $data = $form->fetch();

                if (empty($this->error_form)) {

                    $stmt = $this->db->prepare("INSERT INTO `{$this->general_info}`(`name`,`phone`,`job`,`country`,`city`,`address`,`gander`,`brithday`,`note`,`active`,`stop`,`iduser`,`date`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $stmt->execute(array($data['name'],$data['phone'],$data['job'],$data['country'],$data['city'],$data['address'],$data['gander'],$data['brithday'],$data['note'],$data['state'],$data['stop'],$this->userid,time()));

                    $getLastId = $this->db->prepare("SELECT `id` FROM `{$this->general_info}` WHERE `iduser`=? ORDER BY `id` DESC");
                    $getLastId->execute(array($this->userid));
                    $row_id = $getLastId->fetch(PDO::FETCH_ASSOC);
                    $lastId = $row_id['id'];

                    $stmt_account = $this->db->prepare("INSERT INTO `{$this->account}`(`id_info`,`id_cat`,`id_branch`,`mth_goal_amount`,`mth_goal_currency`,`duration_of_debt`,`max_debt_limit`,`currency_debt_limit`,`id_price_list`,`id_price_style`,`iduser`,`date`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?)");
                    $stmt_account->execute(array($lastId,$data['type_account'],$data['branch'],$data['mth_goal_amount'],$data['mth_goal_currency'],$data['duration_of_debt'],$data['max_debt_limit'],$data['currency_debt_limit'],$data['price_list'],$data['price_style'],$this->userid,time()));
                }

            } catch (Exception $e) {

                $this->error_form = json_decode($e->getMessage(), true);
            }
        }

        require ($this->render($this->folder,'html','add_account','php'));
        $this->adminFooterController();
    }


    // عرض كل الزبائن
    public function edit_user_account($id_account,$id=0){
        $this->checkPermit('edit_user_account','account');
        $this->adminHeaderController($this->langControl('account'));

        $nameCategory = array();


        $infoAccount = array();
        $stmt_account =$this->db->prepare("SELECT `name`,`phone`,`job`,`country`,`city`,`address`,`gander`,`brithday`,`note`,`active`,`stop` FROM `{$this->general_info}` WHERE id = ?");
        $stmt_account->execute(array($id_account));

        while ($row_account = $stmt_account->fetch(PDO::FETCH_ASSOC))
        {
            $infoAccount[]=$row_account;
        }



        // ترجع الفئات التابعه للفئة الاصلية
        $nameCategory= $this->get_name_rel_catg($id);

        // هنا حتى نأخذ الفئة الاصلية الي دخل عليها الزبون
        $name_current_catg = $this->db->prepare("SELECT `id`,`title` FROM `{$this->account_catg}` WHERE active = 1 AND id = ?");
        $name_current_catg->execute(array($id));
        if($name_current_catg->rowCount() > 0){
            $row_name[] = $name_current_catg->fetch(PDO::FETCH_ASSOC);
            if(!empty($nameCategory)){
                $nameCategory = array_merge($row_name,$nameCategory);
            }else{
                $nameCategory = $row_name;
            }
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


        $priceList = array();
        $stmt_price_list =$this->db->prepare("SELECT `id`,`title` FROM `{$this->price_list}` WHERE active = 1");
        $stmt_price_list->execute();

        while ($row_list= $stmt_price_list->fetch(PDO::FETCH_ASSOC))
        {
            $priceList[]=$row_list;
        }

        $priceStyle = array();
        $stmt_price_style =$this->db->prepare("SELECT `id`,`title` FROM `{$this->price_style}` WHERE active = 1");
        $stmt_price_style->execute();

        while ($row_style = $stmt_price_style->fetch(PDO::FETCH_ASSOC))
        {
            $priceStyle[]=$row_style;
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

                $form->post('state')
                    ->val('strip_tags');

                $form->post('stop')
                    ->val('strip_tags');


                $form->post('type_account')
                    ->val('strip_tags');

                $form->post('branch')
                    ->val('strip_tags');

                $form->post('price_list')
                    ->val('strip_tags');

                $form->post('mth_goal_amount')
                    ->val('strip_tags');

                $form->post('mth_goal_currency')
                    ->val('strip_tags');

                $form->post('duration_of_debt')
                    ->val('strip_tags');

                $form->post('max_debt_limit')
                    ->val('strip_tags');

                $form->post('currency_debt_limit')
                    ->val('strip_tags');

                $form->post('price_style')
                    ->val('strip_tags');

                $form->submit();

                $data = $form->fetch();

                if (empty($this->error_form)) {




                    $this->lightRedirect(url."/".$this->folder."/view_user_account/$id");
                }

            } catch (Exception $e) {

                $this->error_form = json_decode($e->getMessage(), true);
            }
        }

        require ($this->render($this->folder,'html','edit_user_account','php'));
        $this->adminFooterController();
    }

    // عرض كل الزبائن
    public function view_user_account($id)
    {
        $this->checkPermit('view_user_account','account');
        $this->adminHeaderController($this->langControl('account'));

        require ($this->render($this->folder,'html','view_user_account','php'));
        $this->adminFooterController();
    }

    public function processing($id)
    {
        $table = "ac_general_info";
        $primaryKey = 'ac_general_info.id';
        $columns = array(
            array( 'db' => 'ac_general_info.name', 'dt' => 0 ),
            array( 'db' => 'ac_general_info.phone', 'dt' => 1),
            array( 'db' => 'ac_account.id_cat', 'dt' => 2,
                'formatter' => function($id,$row) {
                    return $this->getName('ac_account_catg', $id);
                }
            ),
            array( 'db' => 'ac_account.id_branch', 'dt' => 3,
                'formatter' => function($id, $row ) {
                    return $this->getName('branch', $id);
                }
            ),
            array( 'db' => 'ac_general_info.iduser', 'dt' => 4 ,
                'formatter' => function($id, $row ) {
                return  $this->UserInfo($id);
                }
            ),

            array( 'db' => 'ac_general_info.date', 'dt' => 5 ,
                'formatter' => function($id, $row ) {
                    return date( 'Y-m-d h:i A',$id);
                }
            ),

            array( 'db' => 'ac_general_info.id', 'dt' => 6,
                'formatter' => function($id, $row ) {
                    if ($this->permit('edit_account', $this->folder)) {
                        return "<a href=".url."/account/edit_user_account/$id/$row[2]  style='text-align: center;font-size: 25px; margin-bottom:60px'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>";

                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            )
        );
        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = " INNER JOIN ac_account ON ac_general_info.id = ac_account.id_info ";
        $whereAll = " ac_account.id_cat = $id ";
        echo json_encode(
            SSP::complex_join( $_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll,null,null,1)
        );
    }

    // ترجع الفئات التابعه للفئة الاصلية

    public function get_name_rel_catg($id){
        $id =(int)$id;
        $nameCategory = array();
        $nameRelCatg = array();
        if($id != 0){
            $stmt = $this->db->prepare("SELECT `id`,`title` FROM `{$this->account_catg}` WHERE active = 1 AND relid = ?");
            $stmt->execute(array($id));
            if($stmt->rowCount() > 0){
                while ($row= $stmt->fetch(PDO::FETCH_ASSOC)){
                    $nameCategory[]=$row;
                    $relid =$row['id'];
                    $nameRelCatg = $this->get_name_rel_catg($relid);
                    if (is_array($nameRelCatg)){
                        foreach($nameRelCatg as $value){
                            $nameCategory[] = $value;
                        }
                    }
                }
                return $nameCategory;
            }
        // if id = 0 return all category
        }elseif($id == 0){
            $stmt = $this->db->prepare("SELECT `id`,`title` FROM `{$this->account_catg}` WHERE active = 1");
            $stmt->execute(array());
            if($stmt->rowCount() > 0){
                while ($row= $stmt->fetch(PDO::FETCH_ASSOC)){
                    $nameCategory[]=$row;
                }
                return $nameCategory;
            }
        }
    }

    public function checkIfExist(){
        $data = json_decode($_GET['jsonData'], true);
        $phone = $data['phone'];
        $id_account = $data['id_account'];
        $where = " `phone` = $phone ";
        if($id_account != 0){
            $where .= " `id` != $id_account ";
        }
        $stmt = $this->db->prepare("SELECT `id` FROM `{$this->general_info}` WHERE {$where}");
        $stmt->execute();
        if($stmt->rowCount() > 0){
            echo 1;
        }
    }

    public function getName($table,$id){
        $title ='';
        $stmt = $this->db->prepare("SELECT `title` FROM `$table` WHERE `id` = ? LIMIT 1");
        $stmt->execute(array($id));
        if($stmt->rowCount() > 0){

           $row = $stmt->fetch(PDO::FETCH_ASSOC);
           $title = $row['title'];
        }
        return $title;
    }

}