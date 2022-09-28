<?php

class coupon extends Controller
{

    public $ids = array();


    function __construct()
    {
        parent::__construct();
        $this->table = 'coupon';
        $this->menu=new Menu();
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `id_group` int(25) NOT NULL,
          `barcode` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
          `id_user`  int(11)   NOT NULL,
          `active` int(2) NOT NULL DEFAULT 0,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`),
           FOREIGN KEY (id_group) REFERENCES groups_coupons(id),
           FOREIGN KEY (id_user) REFERENCES user(id),
           UNIQUE (barcode)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `groups_coupons` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_user` int(25) NOT NULL,
            `name_group` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (id_user) REFERENCES user(id)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS user_coupon (
            `id` int(11)  NOT NULL AUTO_INCREMENT ,
            `id_coupon` int(25)  NOT NULL,
            `id_user`  int(11)   NOT NULL,
            `id_customer`  int(11)   NOT NULL,
            `state` int(11) NOT NULL DEFAULT 0,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (id_user) REFERENCES user(id),
            FOREIGN KEY (id_coupon) REFERENCES coupon(id),
            FOREIGN KEY (id_customer) REFERENCES register_user(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `used_coupon` (
            `id` INT(11) NOT NULL AUTO_INCREMENT ,
            `id_user` INT(11) NOT NULL ,
            `id_user_coupon` INT(11) NOT NULL,
            `date` BIGINT(20) NOT NULL ,
            PRIMARY KEY (`id`),
            FOREIGN KEY (id_user) REFERENCES user(id),
            FOREIGN KEY (id_user_coupon) REFERENCES user_coupon(id)
            ) ENGINE = InnoDB;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `winners_customers` (
            `id` int(11)  NOT NULL AUTO_INCREMENT ,
            `username` varchar(250) NOT NULL,
            `phone` varchar(250) NOT NULL,
            `id_group`  int(11)   NOT NULL,
            `id_user` int(11) NOT NULL,
            `state_user` int(11) NOT NULL DEFAULT 0,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (id_user) REFERENCES user(id),
            FOREIGN KEY (id_group) REFERENCES groups_coupons(id))
        ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        return $this->db->cht(array($this->table));


    }
    /**
     *الدالة للتاكد من ان الباركود غير موجود
     */
    public function check_barcode($barcode)
    {
        $stmt = $this->db->prepare("SELECT count(id) as count_ FROM `coupon` WHERE barcode = ?;");
        $stmt->execute(array($barcode));
        $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt_data['count_'];
    }

     /**
     *  اضافة مجموعة جديده
     */
    public function create_groups()
    {
        // $this->checkPermit('create_groups','coupon');

        $data = json_decode($_GET['jsonData'], true);
        $nameGroup= $data['name_group'];
        $stmt = $this->db->prepare("INSERT INTO `groups_coupons`(`name_group`, `id_user`, `date`) VALUES (?,?,?)");
        $stmt->execute(array($nameGroup, $this->userid, time()));

    }
     /**
     * اضافة مجموعة جديده وعرض المجموعات الموجوده  وتفاصيلها
     */
    public function groups_coupons()
    {
        $this->checkPermit('groups_coupons','coupon');
        $this->adminHeaderController($this->langControl('coupon'));

        require ($this->render($this->folder,'html','groups_coupons','php'));
        $this->adminFooterController();
    }

    /**
     *  معالجة عرض الباركودات
     */
    public function processing_groups_coupons()
    {
        $table = "groups_coupons";
        $primaryKey = 'id';
        $columns = array(
            array( 'db' => 'id', 'dt' => 0 ),
            array( 'db' => 'name_group', 'dt' => 1 ),
            array(
                'db' => 'id',
                'dt' =>2,
                'formatter' => function ($id, $row) {
                    return $this->get_count_coupon_in_group($id);
                }
            ),
             array(
                'db' => 'id',
                'dt' =>3,
                'formatter' => function ($id, $row) {
                    return $this->get_count_coupon_active($id);
                }
            ),
            array(
                'db' => 'id',
                'dt' =>4,
                'formatter' => function ($id, $row) {
                    return $this->get_count_coupon_in_group($id) - $this->get_count_coupon_active($id);
                }
            ),
            array(
                'db' => 'id','dt' =>5,
                'formatter' => function ($id, $row) {
                    if($this->permit('barcode_generation','coupon')){
                         return "<div style='text-align: center;font-size: 16px;'><a class='btn btn-primary' href=" . url . "/coupon/show_coupons/$id>  توليد الكوبونات </a></div> ";
                    }else{
                        return "<div style='text-align: center;font-size: 16px;'>لاتمتلك صلاحية</div> ";
                    }
                }
            ),
            array(
                'db' => 'id','dt' =>6,
                'formatter' => function ($id, $row) {
                    if($this->permit('create_winners','coupon')){
                        return "<div style='text-align: center;font-size: 16px;'> <a class='btn btn-primary' href=" . url . "/coupon/add_winners/$id>  اضافة فائز</a> </div> ";
                    }else{
                        return "<div style='text-align: center;font-size: 16px;'>لاتمتلك صلاحية</div> ";
                    }
                }
            ),
            array( 'db' => 'id_user', 'dt' => 7 ,
            'formatter' => function( $d, $row ) {
             return  $this->UserInfo( $d) ;
            }
        ),
            array( 'db' => 'date', 'dt' => 8 ,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);
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
    // صفحة اضافة فائز جديد
    public function add_winners($idGroup)
    {
        // $this->checkPermit('add_winners','coupon');
        $this->adminHeaderController($this->langControl('coupon'));
        require ($this->render($this->folder,'html','add_winners','php'));
        $this->adminFooterController();
    }
    // اضافة فائز جديد
    public function create_winners()
    {
        $this->checkPermit('create_winners','coupon');

        $data = json_decode($_GET['jsonData'], true);

        $stmt_check = $this->db->prepare("SELECT `id`  FROM `winners_customers` where phone=?  AND id_group=?");
        $stmt_check->execute(array($data['phone'],$data['id_group']));
        if($stmt_check->rowCount() > 0){

            echo 0;
        }else{
            $state_user = $this->check_phone_customer($data['phone']);
            $stmt = $this->db->prepare("INSERT INTO `winners_customers`( `username`, `phone`,`id_group`,`id_user`,`state_user`, `date`) VALUES (?,?,?,?,?,?)");
            $stmt->execute(array($data['name'],$data['phone'],$data['id_group'],$this->userid,  $state_user ,time()));
            echo 1;
        }


    }
    // عرض الزبائن الفائزين
    public function winners_customers()
    {
        $this->checkPermit('winners_customers','coupon');
        $this->adminHeaderController($this->langControl('coupon'));

        $stmt = $this->db->prepare("SELECT * FROM `groups_coupons`");
        $stmt->execute();
        $category=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row;
        }

        require ($this->render($this->folder,'html','winners_customers','php'));
        $this->adminFooterController();
    }

     /**
     *  معالجة عرض الباركودات
     */
    public function processing_winners_customers($idGroup = 1)
    {
        $table = "winners_customers";
        $primaryKey = 'winners_customers.id';
        $columns = array(
            array( 'db' => 'winners_customers.id', 'dt' => 0 ),
         array( 'db' => 'winners_customers.username', 'dt' => 1),
            array( 'db' => 'winners_customers.phone', 'dt' => 2),
            array( 'db' => 'groups_coupons.name_group', 'dt' => 3
            ),
            array( 'db' => 'winners_customers.state_user', 'dt' => 4 ,
            'formatter' => function( $d, $row ) {
                if($d == 0){
                   return 'الرقم غير مسجل';
                }
                if($d == 1){
                   return 'الرقم مسجل';
                }
                if($d == 2){
                   return 'الرقم مسجل ويمتلك qr  ';
                }
               }),
               array( 'db' => 'winners_customers.id_user', 'dt' => 5,
               'formatter' => function( $d, $row ) {
                   return  $this->UserInfo( $d) ;
               }
           ),
            array( 'db' => 'winners_customers.date', 'dt' => 6 ,
            'formatter' => function( $d, $row ) {
                return date( 'Y-m-d h:i A', $d);
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
        $join = " INNER JOIN  groups_coupons ON winners_customers.id_group = groups_coupons.id ";
        $whereAll = array("winners_customers.id_group = '{$idGroup}'");
        echo json_encode(
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex_join( $_GET, $sql_details, $table, $primaryKey, $columns,$join, null, $whereAll)
        );
    }
    /**
     * انشاء الباركودات
     */
    public function create_coupons($idGroup,$count)
    {
        $this->checkPermit('barcode_generation','coupon');

        $stmt = $this->db->prepare("INSERT INTO `coupon`( `barcode`, `id_group`,`id_user`, `date`) VALUES (?,?,?,?)");
        // echo $count;
        for($i=0;$i<intval($count);$i++){
            // هذا  للتاكد من عدم تكرار الباركود
            $check_barcode = true;
            $barcode = '00000';
            while ($check_barcode)
            {
                $barcode = '00000';
                $rand_num= rand(00000,99999);
                $barcode .= strval($rand_num);
                $barcode = substr($barcode, strlen($barcode)-5);
                $check_barcode =$this->check_barcode($barcode);
            }
            $stmt->execute(array($barcode,$idGroup,$this->userid, time()));

        }

    }
    /**
     * عرض الباركودات وحالتهم ومن نفس النافذه ننشأ الباركودات الجديدة
     */
    public function show_coupons($idGroup)
    {
        $this->checkPermit('show_coupons','coupon');
        $this->adminHeaderController($this->langControl('coupon'));
        require ($this->render($this->folder,'html','show_coupons','php'));
        $this->adminFooterController();
    }

    /**
     *  معالجة عرض الباركودات
     */
    public function processing_show_coupons($idGroup)
    {
        $table = "coupon";
        $primaryKey = 'id';
        $columns = array(
            array( 'db' => 'id', 'dt' => 0 ),
            array( 'db' => 'barcode', 'dt' => 1 ),
            array( 'db' => 'id_user', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                    return  $this->UserInfo( $d) ;
                }
            ),
            array( 'db' => 'active', 'dt' => 3 ,
                'formatter' => function( $d, $row ) {
                    if($d==0)
                        return 'غير محجوز';
                    else if($d==1)
                        return 'محجوز';
                }
            ),
            array( 'db' => 'date', 'dt' => 4 ,
            'formatter' => function( $d, $row ) {
                return date( 'Y-m-d h:i A', $d);
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
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"coupon.id_group={$idGroup}")
        );
    }



    /**
     *   عرض باركودات الزبائن ومن نفس النافذه نعطي باركودات للزبائن
     */
    public function list_customer_coupons()
    {
        $this->checkPermit('list_customer_coupons','coupon');
        $this->adminHeaderController($this->langControl('coupon'));
        $stmt = $this->db->prepare("SELECT * FROM `groups_coupons`");
        $stmt->execute();
        $category=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row;
        }
        require ($this->render($this->folder,'html','list_customar_coupons','php'));
        $this->adminFooterController();
    }
    /**
     *  معالجة عرض الباركودات
     */
    public function processing_list_customer_coupons()
    {
        $table = "user_coupon";
        $primaryKey = 'user_coupon.id';
        $columns = array(
            array( 'db' => 'coupon.id', 'dt' => 0 ),
            array( 'db' => 'coupon.barcode', 'dt' => 1 ),
            array( 'db' => 'user.username', 'dt' => 2 ),
            array( 'db' => 'register_user.name', 'dt' => 3 ),
            array( 'db' => 'user_coupon.state', 'dt' => 4 ,
                'formatter' => function( $d, $row ) {
                    if($d==0)
                        return 'لم تستخدم';
                    else if($d==1)
                        return 'تم استخدامها';
                }
            ),
            array( 'db' => 'user_coupon.date', 'dt' => 5 ,
            'formatter' => function( $d, $row ) {
                return date( 'Y-m-d h:i A', $d);
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
        $join = " INNER JOIN coupon ON coupon.id=user_coupon.id_coupon INNER JOIN user ON user.id = user_coupon.id_user INNER JOIN register_user ON user_coupon.id_customer = register_user.id ";
        $whereAll = array('');
        echo json_encode(
            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1)
        );
    }
    // نتأكد من رقم الزبون مسجل واذا اي يمتك
    public function check_phone_customer($number)
    {
        $result_check = 0;
        $stmt = $this->db->prepare("SELECT `id` , `xc` FROM `register_user` where phone=? ORDER BY `xc` DESC");
        $stmt->execute(array($number));
        if($stmt->rowCount() > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row['xc'] == 0){
                $result_check = 1;
            }else{
                $result_check = 2;
            }

        }
        echo $result_check;
        return $result_check;
    }
     // نتأكد من رقم الزبون مسجل واذا اي يمتك
     public function get_customer_name_by_phone($phone)
     {
         $result= '';
         $stmt = $this->db->prepare("SELECT `name` FROM `register_user` where phone=? ORDER BY `xc` DESC");
         $stmt->execute(array($phone));
         if($stmt->rowCount() > 0){
             $row = $stmt->fetch(PDO::FETCH_ASSOC);

                 $result=$row['name'];


         }
         echo $result;
     }
    /**
     *
     */
    // public function get_barcode_coupon_by_id($id)
    // {
    //     $stmt = $this->db->prepare("SELECT barcode FROM `coupon` where id=? ");
    //     $stmt->execute(array($id));
    //     if($stmt_data = $stmt->fetch(PDO::FETCH_ASSOC))
    //         return $stmt_data['barcode'];
    //     return 0;
    // }
    /**
     * واضحه من اسمها بعد 😒
     */
    public function get_customer_name_by_id($id)
    {
        $stmt = $this->db->prepare("SELECT name FROM `register_user` where id=? ");
        $stmt->execute(array($id));
        if($stmt_data = $stmt->fetch(PDO::FETCH_ASSOC))
            return $stmt_data['name'];
        return  0;
    }
    /**
     * واضحه من اسمها بعد 😒
     */
    public function get_id_customer_by_num_or_qr($number)
    {
        $stmt = $this->db->prepare("SELECT id FROM `register_user` where (phone=? or uid=?)  and xc =1 ");
        $stmt->execute(array($number,$number));
        if($stmt_data = $stmt->fetch(PDO::FETCH_ASSOC))
            return $stmt_data['id'];
        return  0;
    }
    /**
     * هاي الدالة هيج سوينهالان احتاجها ك API
     */
    public function check_customar_number($number,$idGroup)
    {
          // نتأكده من رقم الزبون تابع للمجموعة
          $stmt_check = $this->db->prepare("SELECT id  FROM `winners_customers` WHERE phone = ? AND `id_group` = ? ");
          $stmt_check->execute(array($number,$idGroup));
          if($stmt_check->rowCount() > 0){
            $id_customar =  $this->get_id_customer_by_num_or_qr($number);
            if($id_customar>0)
            {
                $stmt = $this->db->prepare("SELECT count(id) as _count FROM `user_coupon` where id_customer =? and id_coupon in (select id from coupon where id_group=?);");
                $stmt->execute(array($id_customar));
                $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($stmt_data['_count']>0)
                    echo -1;
                else
                    echo $id_customar;

            }else
                echo 0;
        }else{
            echo 1;
        }
    }
    /**
     * ترسل اول باركود متاح
     */
    public function get_available_barcode($idGroup)
    {
        $stmt = $this->db->prepare("SELECT id FROM `coupon` where active=0  AND `id_group` = ? ORDER by id asc LIMIT 1; ");
        $stmt->execute(array($idGroup));
        if($stmt_data = $stmt->fetch(PDO::FETCH_ASSOC))
            return $stmt_data['id'];
        return 0;
    }
    /**
     *
     */
    public function set_coupon_availablle($id)
    {
        $stmt = $this->db->prepare("UPDATE `coupon` SET `active`=1 WHERE id=?");
        $stmt->execute(array($id));
    }
    /**
     *
     */
    public function set_barcode($customer_number,$idGroup)
    {
        if($this->Permit('set_barcode_to_customer','coupon'))
        {
            $stmt = $this->db->prepare("INSERT INTO `user_coupon`( `id_coupon`, `id_user`, `id_customer`,  `date`) VALUES (?,?,?,?)");
            $customer_id = $this->get_id_customer_by_num_or_qr($customer_number);
            // echo $count;
            // هذا هنا حتى نعرف من اي تسلسل راح ياخذ الزبون
            // $id_coupon=$this->get_available_barcode();
            for($i=0;$i<25;$i++){
                $id_coupon=$this->get_available_barcode($idGroup);
                $stmt->execute(array($id_coupon, $this->userid,$customer_id, time()));
                $this->set_coupon_availablle($id_coupon);
            }
            echo $id_coupon;

        }else{
            echo -1;
        }
    }
    /**
     *
     */
    public function use_coupon()
    {
        $this->checkPermit('use_coupon','coupon');
        $this->adminHeaderController($this->langControl('use_coupon'));
        require ($this->render($this->folder,'html','use_coupon','php'));
        $this->adminFooterController();
    }
    /**
     * عرض الباركودات المستخدمة
     */
    public function list_used_coupons()
    {
        $this->checkPermit('list_used_coupons','coupon');
        $this->adminHeaderController($this->langControl('list_used_coupons'));
        require ($this->render($this->folder,'html','list_used_coupons','php'));
        $this->adminFooterController();
    }
    /**
     *  معالجة عرض الباركودات المستخدمة
     */
    public function processing_list_used_coupons()
    {
        $table = "used_coupon";
        $primaryKey = 'used_coupon.id';
        $tableJoin = $table . '.';
        // $columns = array(
        //     array( 'db' => 'coupon.barcode', 'dt' => 0 ),
        //     array( 'db' => 'used_coupon.id', 'dt' => 1 ),
        //     array( 'db' => 'register_user.name', 'dt' => 2 ),
        //     array( 'db' => 'used_coupon.date', 'dt' => 3 ),

        // );
        $columns = array(
            array( 'db' => 'coupon.barcode', 'dt' => 0 ),
            array( 'db' => 'user.username', 'dt' => 1 ),
            array( 'db' => 'register_user.name', 'dt' => 2 ),
            array( 'db' => 'used_coupon.date', 'dt' => 3,
            'formatter' => function( $d, $row ) {
                return date( 'Y-m-d h:i A', $d);
            } ),

        );
        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        $join = " INNER JOIN user_coupon on used_coupon.id_user_coupon = user_coupon.id INNER JOIN coupon ON user_coupon.id_coupon = coupon.id INNER JOIN user ON user_coupon.id_user=user.id INNER JOIN register_user on user_coupon.id_customer=register_user.id ";
        $whereAll = array('');
        echo json_encode(
            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1)
        );
    }

    /**
     * واضحه من اسمها بعد 😒
     */
    public function check_customar_barcode($num_or_qr,$coupon_barcode)
    {
        // حاليا اجيك كلشي كبل بجملة وحدة لان ما عندي وقت بس بعدين اعدل علية اكثر
        $stmt = $this->db->prepare("SELECT count(user_coupon.id) as count_ FROM `user_coupon` , coupon ,register_user where user_coupon.id_coupon =coupon.id and user_coupon.id_customer=register_user.id and coupon.active=1 and user_coupon.state=0 and (register_user.phone = ? or register_user.uid =?) and coupon.barcode=?;");
        $stmt->execute(array($num_or_qr,$num_or_qr,$coupon_barcode));
        $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $stmt_data['count_'];
    }
    /**
     * نشوف اذا كان الزبون رابح او لا
     */
    public function check_won_barcode($num_or_qr)
    {
        // حاليا اجيك كلشي كبل بجملة وحدة لان ما عندي وقت بس بعدين اعدل علية اكثر
        $stmt = $this->db->prepare("SELECT count(user_coupon.id) as count_ FROM `user_coupon` ,register_user where  user_coupon.id_customer = register_user.id and user_coupon.state=0 and (register_user.phone = ? or register_user.uid =?);");
        $stmt->execute(array($num_or_qr,$num_or_qr));
        $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $stmt_data['count_'];
    }
    /**
     *
     */
    public function get_id_user_coupon_by_barcode($coupon_barcode)
    {
        $stmt = $this->db->prepare("SELECT user_coupon.id FROM `user_coupon` , coupon  where user_coupon.id_coupon =coupon.id and coupon.barcode=? ");
        $stmt->execute(array($coupon_barcode));
        if($stmt_data = $stmt->fetch(PDO::FETCH_ASSOC))
            return $stmt_data['id'];
        return 0;
    }

    /**
     *
     */
    public function confirmation_of_use($coupon_barcode)
    {
        $stmt = $this->db->prepare("UPDATE `coupon` ,user_coupon set user_coupon.state=1 where user_coupon.id_coupon= coupon.id and coupon.barcode=?;");
        if($stmt->execute(array($coupon_barcode)))
        {
            $id_user_coupon= $this->get_id_user_coupon_by_barcode($coupon_barcode);
            $stmt = $this->db->prepare("INSERT INTO `used_coupon`( `id_user`,id_user_coupon, `date`) VALUES (?,?,?)");
            $stmt->execute(array($this->userid,$id_user_coupon,time()));
            echo 1;

        }
        else
            echo 0;
    }


    public function get_count_coupon_in_group($idGroup)
    {
        $stmt = $this->db->prepare("SELECT count(*) as count_ FROM `coupon` where id_group=?;");
        $stmt->execute(array($idGroup));
        $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt_data['count_'];
    }


    public function get_count_coupon_active($idGroup)
    {
        $stmt = $this->db->prepare("SELECT count(*) as count_ FROM `coupon` where id_group=? AND active=1");
        $stmt->execute(array($idGroup));
        $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt_data['count_'];
    }



}