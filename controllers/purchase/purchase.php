<?php

class purchase extends Controller {
    function __construct()
    {
        parent::__construct();
        $this->purchase_order = 'purchase_order'; // purchase table name (تفاصيل المشتريات)
        $this->purchase_item = 'purchase_item'; // purchase_item table name (مواد الشراء)
        $this->supplier = 'supplier';  // supplier table name (الموردين)
        $this->source_request = 'source_request'; // source_request table name (مصدر الطلب ,دولة او محافظة)
        $this->type_shipping = 'type_shipping'; // type_Shipping table name (نوع الشحن)
        $this->menu=new Menu();


        $this->setting = new Setting();
    }

    public function createTB()
    {
        /*
        * Create Table supplier
        * Created 2022/07/17
        * type (نوع هو مورد او محاسب خارجي)
        */
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->supplier}` (
            `id` int(4) Unsigned  NOT NULL AUTO_INCREMENT ,
            `name` varchar(150) NOT NULL,
            `type` varchar(50) NOT NULL,
            `iduser` int(4) NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        /*
        * Create Table source request
        */
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->source_request}` (
            `id` SMALLINT(2) Unsigned  NOT NULL AUTO_INCREMENT ,
            `name` varchar(255) NOT NULL,
            `iduser` int(4) NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        /*
        * Create Table type shipping
        *
        */
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->type_shipping}` (
            `id` TINYINT(1) Unsigned  NOT NULL AUTO_INCREMENT ,
            `type` varchar(100) NOT NULL,
            `iduser` int(4) NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        /*
        * Create Table company_shipping
        *
        */
        $this->db->query("CREATE TABLE IF NOT EXISTS `company_shipping` (
            `id`  SMALLINT(2) Unsigned  NOT NULL AUTO_INCREMENT ,
            `name` varchar(255) NOT NULL,
            `iduser` int(4) NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        /*
        * Create Table current
        */
        $this->db->query("CREATE TABLE IF NOT EXISTS `currency` (
            `id` TINYINT(1) Unsigned  NOT NULL AUTO_INCREMENT ,
            `name` varchar(100) NOT NULL,
            `iduser` int(4) NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        /*
        * Create Table purchase
        * @id_source_request (id مصدر الطلب)
        * state (on_request  قيد الطلب , being_processed قيد التجهيز ,  being_sent  قيد الارسال  , shipping قيد الشحن , loaded محملة , arrival تم الوصول, arrival_warehouse داخلة في مخازننا, receive واصلة )
        * @date_shipping (تاريخ الشحن)
        * @iduser_date_shipping ( الشخص الذي اضاف تاريخ الشحن)
        * date_request (تاريخ الطلب)
        * @date_ex_eq (تاريخ المتوقع للتجهيز)
        * date_eq (تاريخ التجهيز)
        * @date_send (تاريخ المتوقع للارسال)
        * @date_receive (تاريخ الاستلام)
        * @iduser_receive (المستخدم الذي أستلم البضاعة)
        * @total (المبلغ الكلي)
        * price_exchange (سعر الصرف)
        * total$ (المبلغ الكلي بالدولار)
        */
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->purchase_order}` (
            `id` int(4)  Unsigned NOT NULL AUTO_INCREMENT,
            `idsupplier`  int(4)  Unsigned,
            `idsource_request` SMALLINT(2) Unsigned ,
            `idtype_shipping`  TINYINT(1) Unsigned,
            `idcompany_shipping`   SMALLINT(2) Unsigned,
            `iduser`  int(4)  NOT NULL,
            `idcurrency`  TINYINT(1) Unsigned,
            `bill_crystal` varchar(255),
            `add_to_excel` TINYINT(1) Unsigned  NULL DEFAULT '0',
            `state_order` varchar(150),
            `date_request` bigint(20) NOT NULL DEFAULT '0',
            `iduser_date_request` int(4),
            `date_ex_eq` bigint(20) NOT NULL  DEFAULT '0',
            `iduser_date_ex_eq`  int(4),
            `date_eq` bigint(20) NOT NULL DEFAULT '0',
            `iduser_date_eq`  int(4),
            `date_send`  bigint(20) NOT NULL DEFAULT '0',
            `iduser_date_send`  int(4),
            `date_ex_shipping` bigint(20) NOT NULL  DEFAULT '0',
            `iduser_date_exshipping`  int(4),
            `date_shipping`  bigint(20) NOT NULL  DEFAULT '0',
            `iduser_date_shipping`  int(4) ,
            `date_ex_arrival` bigint(20) NOT NULL DEFAULT '0',
            `iduser_date_ex_arrival`  int(4),
            `date_arrival`  bigint(20) NOT NULL  DEFAULT '0',
            `iduser_date_arrival`  int(4) ,
            `date_receive`  bigint(20) NOT NULL DEFAULT '0',
            `iduser_receive`  int(4),
            `date_arrival_warehouse` bigint(20) NOT NULL DEFAULT '0',
            `iduser_date_arrival_warehouse`  int(4) ,
            `user_arrival_warehouse` varchar(255),
            `price_exchange` FLOAT NOT NULL DEFAULT '1',
            `total-price` float NOT NULL DEFAULT '0.0',
            `total_price_dollars` FLOAT NOT NULL DEFAULT '0.0',
            `note` varchar(255),
            `date_reminder`  bigint(20) NOT NULL DEFAULT '0',
            `iduser_reminder`  int(4),
            `created` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`idsupplier`) REFERENCES supplier(id),
            FOREIGN KEY (`idsource_request`) REFERENCES source_request(id),
            FOREIGN KEY (`idtype_shipping`) REFERENCES type_shipping(id),
            FOREIGN KEY (`idcompany_shipping`) REFERENCES company_shipping(id),
            FOREIGN KEY (`iduser`) REFERENCES user(id),
            FOREIGN KEY (`idcurrency`) REFERENCES currency(id),
            FOREIGN KEY (`iduser_date_request`) REFERENCES user(id),
            FOREIGN KEY (`iduser_date_ex_eq`) REFERENCES user(id),
            FOREIGN KEY (`iduser_date_eq`) REFERENCES user(id),
            FOREIGN KEY (`iduser_date_send`) REFERENCES user(id),
            FOREIGN KEY (`iduser_date_exshipping`) REFERENCES user(id),
            FOREIGN KEY (`iduser_date_shipping`) REFERENCES user(id),
            FOREIGN KEY (`iduser_date_ex_arrival`) REFERENCES user(id),
            FOREIGN KEY (`iduser_date_arrival`) REFERENCES user(id),
            FOREIGN KEY (`iduser_date_arrival_warehouse`) REFERENCES user(id),
            FOREIGN KEY (`iduser_receive`) REFERENCES user(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        /*
        * Create Table purchase item
        * wholesale_price_purchase  سعر الشراء الجملة
        * wholesale_price2_purchase سعر شراء جملة الجملة
        * type للحافظات (رجالي , نسائي, الكل)
        * cover_material للحافظات ( نوع المادة)
        * feature_cover للحافظات (خصائص المادة)
        * rate  نسبة الجمالية للحافظات
        */
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->purchase_item}` (
            `id` int(4) Unsigned NOT NULL AUTO_INCREMENT,
            `idpurchase` int(4) Unsigned NOT NULL,
            `title` varchar(255) NOT NULL,
            `code` varchar(255) NOT NULL,
            `image` varchar(255) NOT NULL,
            `model` varchar(100) NOT NULL,
            `quantity` int(4) Unsigned NOT NULL,
            `price_purchase`  FLOAT NOT NULL DEFAULT '0',
            `price_dollars`  FLOAT NOT NULL DEFAULT '0',
            `price_sale`  FLOAT NOT NULL,
            `wholesale_price_sale`  FLOAT NOT NULL,
            `wholesale_price2_sale`  FLOAT NOT NULL,
            `type` varchar(255),
            `rate` FLOAT NOT NULL DEFAULT '0',
            `size` varchar(255),
            `note` varchar(255),
            `id_user` int(4) NOT NULL,
            `add_to_excel` TINYINT(1) Unsigned  NULL DEFAULT '0',
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`id_user`) REFERENCES user(id),
            FOREIGN KEY (`idpurchase`) REFERENCES purchase_order(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        /*
        * Create Table payment_purchase
        * @payment (الدفعة)
        */

        $this->db->query("CREATE TABLE IF NOT EXISTS `payment_purchase` (
            `id` INT(4) Unsigned NOT NULL AUTO_INCREMENT,
            `idpurchase` INT(4) Unsigned NOT NULL,
            `payment` FLOAT NOT NULL,
            `id_name_pay` int(4)  Unsigned NOT NULL,
            `price_exchange` FLOAT NOT NULL DEFAULT '1',
            `note` varchar(255),
            `iduser` INT(4) NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id),
            FOREIGN KEY (`idpurchase`) REFERENCES purchase_order(id),
            FOREIGN KEY (`id_name_pay`) REFERENCES supplier(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        // جدول التتبع تغيرات فاتورة الشراء
        $this->db->query("CREATE TABLE IF NOT EXISTS `trace_purchase_order` (
            `id` int(4) Unsigned  NOT NULL AUTO_INCREMENT,
            `idpurchase` int(4) Unsigned NOT NULL,
            `data`  text NOT NULL,
            `iduser` int(4) Unsigned NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id),
            FOREIGN KEY (`idpurchase`) REFERENCES purchase_order(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        // جدول خاص بالمواد التي لم تضاف اثناء رفع الاكسل
        $this->db->query("CREATE TABLE IF NOT EXISTS `excel_purchase` (
            `id` int(4) Unsigned NOT NULL AUTO_INCREMENT,
            `idpurchase` int(4) Unsigned NOT NULL,
            `code` varchar(255) NOT NULL,
            `model` varchar(255) NOT NULL,
            `iduser` int(4) Unsigned NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id),
            FOREIGN KEY (`idpurchase`) REFERENCES purchase_order(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        // خاص بالكلفة الاضافية
        $this->db->query("CREATE TABLE IF NOT EXISTS `extra_purchase_cost` (
            `id` INT(4)  Unsigned  NOT NULL AUTO_INCREMENT,
            `idpurchase` INT(4) Unsigned NOT NULL,
            `cost` FLOAT NOT NULL,
            `idcurrency`   TINYINT(1) Unsigned NOT NULL,
            `price_exchange` FLOAT NOT NULL DEFAULT '1',
            `note` varchar(255),
            `iduser` INT(4) Unsigned NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id),
            FOREIGN KEY (`idpurchase`) REFERENCES purchase_order(id),
            FOREIGN KEY (`idcurrency`) REFERENCES currency(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        return $this->db->cht(array($this->purchase_order, $this->purchase_item, $this->source_request, $this->type_shipping, $this->company_shipping));
    }

    public function index()
    {
        $index = new Index();
        $index->index();
    }
    // اضافة شركات الشحن
    public function create_company_shipping()
    {
        $data = json_decode($_GET['jsonData'], true);
        $nameCompany= $data['name_company'];
        $stmt = $this->db->prepare("INSERT INTO `company_shipping`(`name`, `iduser`, `date`) VALUES (?,?,?)");
        $stmt->execute(array($nameCompany, $this->userid, time()));
    }
    // عرض شركات الشحن
    public function company_shipping()
    {
        $this->checkPermit('company_shipping','purchase');
        $this->adminHeaderController($this->langControl('purchase'));

        require ($this->render($this->folder,'html','add_company_shipping','php'));
        $this->adminFooterController();
    }


    //   معالجة عرض شركات الشحن
    public function processing_company_shipping()
    {
        $table = "company_shipping";
        $primaryKey = 'id';
        $columns = array(
            array( 'db' => 'id', 'dt' => 0 ),
            array( 'db' => 'name', 'dt' => 1 ),
            array( 'db' => 'iduser', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                return  $this->UserInfo( $d) ;
                }
            ),
            array( 'db' => 'date', 'dt' => 3 ,
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
    // اضافة  عملة
    public function create_currency()
    {
        $data = json_decode($_GET['jsonData'], true);
        $nameCurrency= $data['name_currency'];
        $stmt = $this->db->prepare("INSERT INTO `currency`(`name`, `iduser`, `date`) VALUES (?,?,?)");
        $stmt->execute(array($nameCurrency, $this->userid, time()));
    }
    // عرض  العملات
    public function show_currency()
    {
        $this->checkPermit('show_currency','purchase');
        $this->adminHeaderController($this->langControl('purchase'));

        require ($this->render($this->folder,'html','add_currency','php'));
        $this->adminFooterController();
    }


    //   معالجة عرض العملات
    public function processing_show_currency()
    {
        $table = "currency";
        $primaryKey = 'id';
        $columns = array(
            array( 'db' => 'id', 'dt' => 0 ),
            array( 'db' => 'name', 'dt' => 1 ),
            array( 'db' => 'iduser', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                return  $this->UserInfo( $d) ;
                }
            ),
            array( 'db' => 'date', 'dt' => 3 ,
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
    // اضافة  مصدر طلب
    public function create_source_request()
    {
        $data = json_decode($_GET['jsonData'], true);
        $sourceRequest= $data['source_request'];
        $stmt = $this->db->prepare("INSERT INTO `source_request`(`name`, `iduser`, `date`) VALUES (?,?,?)");
        $stmt->execute(array($sourceRequest, $this->userid, time()));
    }

    // عرض  مصادر الطلب
    public function show_source_request()
    {
        $this->checkPermit('show_source_request','purchase');
        $this->adminHeaderController($this->langControl('purchase'));

        require ($this->render($this->folder,'html','add_source_request','php'));
        $this->adminFooterController();
    }


    //   معالجة عرض مصادر الطلب
    public function processing_source_request()
    {
        $table = "source_request";
        $primaryKey = 'id';
        $columns = array(
            array( 'db' => 'id', 'dt' => 0 ),
            array( 'db' => 'name', 'dt' => 1 ),
            array( 'db' => 'iduser', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                return  $this->UserInfo( $d) ;
                }
            ),
            array( 'db' => 'date', 'dt' => 3 ,
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

    // اضافة  مورد
    public function create_supplier()
    {
        $data = json_decode($_GET['jsonData'], true);
        $nameSupplier= $data['name_supplier'];
        $stmt = $this->db->prepare("INSERT INTO `$this->supplier` (`name`,`type` ,`iduser`, `date`) VALUES (?,?,?,?)");
        $stmt->execute(array($nameSupplier,'supplier',$this->userid, time()));
    }

    // عرض  معلومات الموردين
    public function supplier()
    {
        $this->checkPermit('supplier','purchase');
        $this->adminHeaderController($this->langControl('purchase'));
        require ($this->render($this->folder,'html','add_supplier','php'));
        $this->adminFooterController();
    }


    // معالجة عرض  معلومات الموردين
    public function processing_show_supplier()
    {
        $table = "$this->supplier";
        $primaryKey = 'id';
        $columns = array(
            array( 'db' => 'id', 'dt' => 0 ),
            array( 'db' => 'name', 'dt' => 1 ),
            array( 'db' => 'iduser', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                return  $this->UserInfo( $d) ;
                }
            ),
            array( 'db' => 'date', 'dt' => 3 ,
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
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,'type = "supplier"')
        );
    }


    public function create_external_accountants()
    {
        $data = json_decode($_GET['jsonData'], true);
        $nameAccount= $data['name'];
        $stmt_item = $this->db->prepare("SELECT `id` FROM `user` WHERE `username` = ?");
        $stmt_item->execute(array($nameAccount));
        if($stmt_item->rowCount() > 0)
        {
            $row_item = $stmt_item->fetch(PDO::FETCH_ASSOC);
            $iduser = $row_item['id'];
            $stmt = $this->db->prepare("INSERT INTO `supplier`(`iduser`, `name`,`type`,`date`) VALUES (?,?,?,?)");
            $stmt->execute(array($this->userid,$nameAccount,'external_accountants',time()));
        }
        else
        {
           echo 1;
        }
    }
    // عرض  معلومات المحاسبين الخارجيين
    public function external_accountants()
    {
        $this->checkPermit('external_accountants','purchase');
        $this->adminHeaderController($this->langControl('purchase'));

        require ($this->render($this->folder,'html','add_external_accounts','php'));
        $this->adminFooterController();
    }


    // معالجة عرض  معلومات المحاسبين الخارجيين
    public function processing_external_accountants()
    {
        $table = "$this->supplier";
        $primaryKey = 'id';
        $columns = array(
            array( 'db' => 'id', 'dt' => 0 ),
            array( 'db' => 'iduser', 'dt' => 1 ,
                'formatter' => function( $d, $row ) {
                return  $this->UserInfo( $d) ;
                }
            ),
            array( 'db' => 'name', 'dt' => 2),
            array( 'db' => 'date', 'dt' => 3 ,
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
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,'type = "external_accountants"')
        );
    }

    // اضافة  فاتورة شراء
    public function add_purchase_bill()
    {
        $this->checkPermit('add_purchase_bill','purchase');
        $this->adminHeaderController($this->langControl('purchase'));
        $data = array();
        $nameSupplier=array();
        $stmt_supplier =$this->db->prepare("SELECT  * FROM `$this->supplier` WHERE `type`= ?");
        $stmt_supplier->execute(array('supplier'));

        while ($row = $stmt_supplier->fetch(PDO::FETCH_ASSOC))
        {
            $nameSupplier[]=$row;
        }
        // عرض مصادر الطلب
        $stmt_source_request = $this->stmtSelect("$this->source_request");
        $sourceRequest=array();
        while ($row_source_request = $stmt_source_request->fetch(PDO::FETCH_ASSOC))
        {
            $sourceRequest[]=$row_source_request;
        }
        // عرض اسماء شركات الشحن
        $stmt_company_shipping = $this->stmtSelect("company_shipping");
        $companyShipping=array();
        while ($row_company_shipping= $stmt_company_shipping->fetch(PDO::FETCH_ASSOC))
        {
            $companyShipping[]=$row_company_shipping;
        }
        // عرض انواع الشحن
        $stmt_type_shipping= $this->stmtSelect("$this->type_shipping");
        $typeShipping=array();
        while ($row_type_shipping= $stmt_type_shipping->fetch(PDO::FETCH_ASSOC))
        {
            $typeShipping[]=$row_type_shipping;
        }

        // عرض العملات
        $stmt_currency= $this->stmtSelect("currency");
        $currency=array();
        while ($row_currency= $stmt_currency->fetch(PDO::FETCH_ASSOC))
        {
            $currency[]=$row_currency;
        }

        $accountSupplier=array();
        $stmtSupplier = $this->stmtSelect("$this->supplier");
        while ($row = $stmtSupplier->fetch(PDO::FETCH_ASSOC))
        {
            $accountSupplier[]=$row;
        }

        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();
                $form->post('name_supplier')
                    ->val('strip_tags');

                $form->post('source_request')
                ->val('strip_tags');

                $form->post('company_shipping')
                ->val('strip_tags');

                $form->post('type_shipping')
                ->val('strip_tags');

                $form->post('date_request')
                ->val('strip_tags');

                $form->post('date_ex_eq')
                ->val('strip_tags');

                $form->post('date_eq')
                ->val('strip_tags');

                $form->post('date_send')
                ->val('strip_tags');

                $form->post('date_ex_shipping')
                ->val('strip_tags');

                $form->post('date_shipping')
                ->val('strip_tags');

                $form->post('date_ex_arrival')
                    ->val('strip_tags');

                $form->post('date_arrival')
                    ->val('strip_tags');

                $form->post('date_arrival_warehouse')
                    ->val('strip_tags');

                $form->post('user_add_arrival_warehouse')
                ->val('strip_tags');

                $form->post('currency')
                    ->val('strip_tags');

                $form->post('price_exchange_order')
                    ->val('strip_tags');

                $form->post('note_order')
                    ->val('strip_tags');

                $form->post('title')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('category')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('code')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('quantity')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('image')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('size_val')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('type_val')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('rate_val')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('price_purchase')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('sale_price')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('wholesale_price_sale')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('wholesale_price2_sale')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('note')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('total-price')
                    ->val('strip_tags');

                $form->post('total_price_dollars')
                    ->val('strip_tags');

                $form->post('total_price_cost')
                    ->val('strip_tags');

                $form->post('cost')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('currency_cost')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('price_exchange_cost')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('note_cost')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('subtotal')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('name_pay')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('price_exchange')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('note_payment')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('date_reminder')
                    ->val('strip_tags');

                $form->submit();

                $data = $form->fetch();

                if (empty($this->error_form)) {

                    $title = json_decode($data['title'], true);
                    $category = json_decode($data['category'], true);
                    $codes = json_decode($data['code'], true);
                    $quantity = json_decode($data['quantity'], true);
                    $img = json_decode($data['image'], true);
                    $size = json_decode($data['size_val'], true);
                    $type = json_decode($data['type_val'], true);
                    $rate = json_decode($data['rate_val'], true);
                    $price_purchase = json_decode($data['price_purchase'], true);
                    $sale_price = json_decode($data['sale_price'], true);
                    $wholesale_price_sale = json_decode($data['wholesale_price_sale'], true);
                    $wholesale_price2_sale = json_decode($data['wholesale_price2_sale'], true);
                    $note = json_decode($data['note'], true);

                    $costs = json_decode($data['cost'], true);
                    $currencyCost = json_decode($data['currency_cost'], true);
                    $priceExchangeCost = json_decode($data['price_exchange_cost'], true);
                    $noteCost = json_decode($data['note_cost'], true);


                    $subtotals = json_decode($data['subtotal'], true);
                    $namePay = json_decode($data['name_pay'], true);
                    $priceExchange = json_decode($data['price_exchange'], true);
                    $notePayment = json_decode($data['note_payment'], true);

                    $sumTotal = 0;
                    $check_currency = $this->db->prepare("SELECT `name` FROM `{$this->purchase_item}` WHERE `id` = ?");
                    $check_currency->execute(array($data['currency']));
                    $currency = $check_currency->fetch();
                    if($check_currency->rowCount() > 0){
                        if($currency['name'] == 'دولار'){
                            $priceExchangeItem = 0;
                        }else{
                            for($i= 0 ; $i <= count($subtotals); $i++){
                                $sumTotal += $subtotals[$i];

                            }
                            if($sumTotal ==  $data['total_price_cost']){
                                for($i= 0 ; $i <= count($subtotals); $i++){
                                    $priceExchangeItem +=  $subtotals[$i] * $priceExchange[$i];
                                }
                                $priceExchangeItem = $priceExchangeItem / $data['total_price_cost'];
                                $priceExchangeItem =  round($priceExchangeItem, 2);

                            }

                            if($sumTotal <  $data['total_price_cost']){
                                $min = $data['total_price_cost'] - $sumTotal;
                                for($i= 0 ; $i <= count($subtotals); $i++){
                                    $priceExchangeItem +=  $subtotals[$i] * $priceExchange[$i];
                                }
                                $priceExchangeItem +=  $min * $data['price_exchange_order'];
                                $priceExchangeItem = $priceExchangeItem / $data['total_price_cost'];
                                $priceExchangeItem =  round($priceExchangeItem, 2);

                            }

                            if($sumTotal > $data['total_price_cost']){
                                $sumPrice = 0;
                                for($i= 0 ; $i <= count($subtotals); $i++){
                                    $sumPrice +=  $subtotals[$i];
                                    if($sumPrice < $sumTotal || $sumPrice == $sumTotal){
                                        $priceExchangeItem +=  $subtotals[$i] * $priceExchange[$i];
                                    }else{
                                        $min = $sumPrice - $sumTotal;
                                        $priceExchangeItem +=  $min * $priceExchange[$i];
                                        break;
                                    }
                                }

                                $priceExchangeItem = $priceExchangeItem / $data['total_price_cost'];
                                $priceExchangeItem =  round($priceExchangeItem, 2);
                            }
                        }
                    }



                    // add number days to date
                    if( $data['date_ex_eq'] == ''){
                        $dateExEq = 0;
                    }else{
                        $dateExEq = time() + (60 * 60 * 24 * $data['date_ex_eq']);
                    }

                    if($data['date_ex_shipping'] == ''){
                        $dateExShipping = 0;
                    }else{
                        $dateExShipping = time() + (60 * 60 * 24 * $data['date_ex_shipping']);

                    }
                    if($data['date_ex_arrival'] == ''){
                        $dateExArrival = 0;
                    }else{
                        $dateExArrival = time() + (60 * 60 * 24 * $data['date_ex_arrival']);

                    }

                    $data['date_request'] = strtotime($data['date_request']);
                    $data['date_eq'] = strtotime($data['date_eq']);
                    $data['date_send'] = strtotime($data['date_send']);
                    $data['date_shipping'] = strtotime($data['date_shipping']);
                    $data['date_arrival'] = strtotime($data['date_arrival']);
                    $data['date_arrival_warehouse'] = strtotime($data['date_arrival_warehouse']);
                    $data['date_reminder'] = strtotime($data['date_reminder']);

                    $stmt = $this->db->prepare("INSERT INTO `{$this->purchase_order}` (`idsupplier`,`idsource_request`,`idtype_shipping`,`idcompany_shipping`,`iduser`,`idcurrency`,`state_order` ,`date_request`,`iduser_date_request`,`price_exchange`,`total-price`,`total_price_dollars`,`note`,`bill_crystal`,`created`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $stmt->execute(array($data['name_supplier'],$data['source_request'],$data['type_shipping'],$data['company_shipping'],$this->userid,$data['currency'],'on_request',$data['date_request'],$this->userid,$data['price_exchange_order'],$data['total-price'], $data['total_price_dollars'],$data['note_order'] ,'NULL',time()));

                    $getLastId = $this->db->prepare("SELECT `id` FROM `{$this->purchase_order}` WHERE `iduser`=? ORDER BY `id` DESC");
                    $getLastId->execute(array($this->userid));
                    $row_id = $getLastId->fetch(PDO::FETCH_ASSOC);
                    $lastId = $row_id['id'];

                    // $lastId=$this->db->lastInsertId();
                    // echo $lastId;
                    if($dateExEq != 0 ){
                        $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `date_ex_eq` = ?, `iduser_date_ex_eq` = ? , `state_order` = ? WHERE `id` = ?");
                        $stmt_update->execute(array($dateExEq,$this->userid,'being_processed',$lastId));
                    }

                    if($data['date_eq'] != 0 || $data['date_eq'] != '' ){
                        $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `date_eq` = ?, `iduser_date_eq` = ? , `state_order` =? WHERE `id` = ?");
                        $stmt_update->execute(array($data['date_eq'],$this->userid,'being_sent',$lastId));
                    }

                    if($data['date_send'] != 0 || $data['date_send'] != '' ){
                        $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `date_send` = ?, `iduser_date_send` = ? WHERE `id` = ?");
                        $stmt_update->execute(array($data['date_send'],$this->userid,$lastId));
                    }

                    if($data['date_shipping'] != 0 || $data['date_shipping'] != '' ){
                        $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `date_shipping` = ?, `iduser_date_shipping` = ? , `state_order` =? WHERE `id` = ?");
                        $stmt_update->execute(array($data['date_shipping'],$this->userid,'shipping',$lastId));
                    }

                    if($dateExShipping != 0 ){
                        $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `date_ex_shipping` = ?, `iduser_date_exshipping` = ? WHERE `id` = ?");
                        $stmt_update->execute(array($dateExShipping,$this->userid,$lastId));
                    }


                    if($dateExArrival != 0 ){
                        $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `date_ex_arrival` = ?, `iduser_date_arrival` = ? , `state_order` =? WHERE `id` = ?");
                        $stmt_update->execute(array($dateExArrival,$this->userid,'loaded',$lastId));
                    }

                    if($data['date_arrival'] != 0 || $data['date_arrival'] != '' ){
                        $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `date_arrival` = ?, `iduser_date_ex_arrival` = ? ,  `state_order` =? WHERE `id` = ?");
                        $stmt_update->execute(array($data['date_arrival'],$this->userid,'arrival',$lastId));
                    }

                    if($data['date_arrival_warehouse'] != 0 ){
                        $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `date_arrival_warehouse` = ?, `iduser_date_arrival_warehouse` = ? , `user_arrival_warehouse` = ? , `state_order` =? WHERE `id` = ?");
                        $stmt_update->execute(array($data['date_arrival_warehouse'],$this->userid,$data['user_add_arrival_warehouse'],'arrival_warehouse',$lastId));
                    }

                    if($data['date_reminder'] != '' || $data['date_reminder'] != 0){
                        $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `date_reminder` = ? , `iduser_reminder` = ?  WHERE `id` = ?");
                        $stmt_update->execute(array($data['date_reminder'],$this->userid,$lastId));
                    }

                    foreach ($codes as $key => $code) {
                        if($code !=''){
                            if($priceExchangeItem != 0){
                                $price_dollars = $price_purchase[$key] / $priceExchangeItem;
                            }else{
                                $price_dollars = $price_purchase[$key];
                            }


                            $stmt_cd = $this->db->prepare("INSERT INTO `purchase_item` (`idpurchase`,`title`,`code`,`quantity`,`price_purchase`,`price_dollars`,`price_sale`,`wholesale_price_sale`,`wholesale_price2_sale`,`note`,`id_user`,`model`,`image`,`size`,`rate`,`type`,`date`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                            $stmt_cd->execute(array($lastId, $title[$key],$code,$quantity[$key],$price_purchase[$key],$price_dollars,$sale_price[$key],$wholesale_price_sale[$key],$wholesale_price2_sale[$key],$note[$key],$this->userid,$category[$key],$img[$key],$size[$key],$rate[$key],$type[$key],time()));
                        }
                    }

                    // اضافة التكلفة الاضافية
                    foreach ($costs as $key => $cost) {
                        if($cost !=''){
                            $stmt_cost = $this->db->prepare("INSERT INTO `extra_purchase_cost`(`idpurchase`,`cost`,`idcurrency`,`price_exchange`,`note`,`iduser`,`date`) VALUE (?,?,?,?,?,?,?)");
                            $stmt_cost->execute(array($lastId,$cost,$currencyCost[$key],$priceExchangeCost[$key],$noteCost[$key],$this->userid,time()));

                        }
                    }

                    foreach ($subtotals as $key => $subtotal) {
                        if($subtotal !=''){
                            $stmt_payment = $this->db->prepare("INSERT INTO `payment_purchase` (`idpurchase`,`iduser`,`payment`,`id_name_pay`,`price_exchange`,`note`,`date`) VALUE (?,?,?,?,?,?,?)");
                            $stmt_payment->execute(array($lastId, $this->userid,$subtotal,$namePay[$key],$priceExchange[$key],$notePayment[$key],time()));
                        }
                    }

                    // $data_order = array();
                    // $data_item = array();

                    // $stmt_order = $this->db->prepare("select * from `{$this->purchase_order}` where `id`=?");
                    // $stmt_order->execute(array($lastId));
                    // $row_order = $stmt_order->fetch();
                    // $data_order = $row_order;

                    // $stmt_item = $this->db->prepare("select * from `purchase_item` where `idpurchase`=?");
                    // $stmt_item->execute(array($lastId));
                    // $row_item = $stmt_item->fetchAll();
                    // $data_item = $row_item;

                    // $data = json_encode(array_merge($data_order, $data_item));
                    // $stmt_trace = $this->db->prepare("INSERT INTO `trace_purchase_order` (`idpurchase`,`data`,`iduser`,`date`) VALUE (?,?,?,?)");
                    // $stmt_trace->execute(array($lastId, $data, $this->userid, time()));

                    // $data['title'] = json_decode($data['title'], true);

                }

            } catch (Exception $e) {
                // $data = $form->fetch();
                // $data['date'] = strtotime($data['date']);
                $this->error_form = json_decode($e->getMessage(), true);
            }
        }
        require ($this->render($this->folder,'html','add_purchase_bill','php'));
        $this->adminFooterController();
    }


    public function processing_show_items()
    {
        $data = json_decode($_GET['jsonData'], true);
        $model = $data['category'];
        $barcode = $data['code'];
        $title = $data['title'];

        $items=array();
        // mobile ,computer , games
        if($barcode != ''){
            if($model == 'mobile' || $model == 'computer' || $model == 'games'){
                $items = $this->selectItemByCode($model,$barcode);
                if(!$items){
                    echo 1;
                }else{

                    echo json_encode($items);
                }
            }
            if($model == 'savers'){
                $items = $this->selectSaversByCode($barcode);
                if(!$items){
                    echo 1;
                }else{
                    echo json_encode($items);
                }
            }
            if($model == 'accessories'){
                $items = $this->selectAccByCode($barcode);
                if(!$items){
                    echo 1;
                }else{
                    echo json_encode($items);
                }
            }
        }
    }


    public function report_purchase()
    {
        $this->checkPermit('report_purchase','purchase');
        $this->adminHeaderController($this->langControl('purchase'));

        require ($this->render($this->folder,'html','report_purchase','php'));
        $this->adminFooterController();
    }

    //
    public function processing_report_purchase($date_start = '0' ,$date_end = '0',$model='select',$state = '')
    {
        $table = "purchase_order";
        $primaryKey = 'purchase_order.id';
        $tableJoin = 'purchase_item';
        $columns = array(
            array( 'db' => 'purchase_order.id', 'dt' => 0 ),
            array( 'db' => 'purchase_order.idsupplier', 'dt' => 1,
                'formatter' => function($id, $row) {
                    $supplier = $this->selectById($id,'supplier');
                    return $supplier;
                }
           ),
           array( 'db' => 'purchase_order.iduser', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                    return  $this->UserInfo( $d) ;
                }
            ),
            array('db' => 'purchase_order.date_arrival_warehouse', 'dt' =>3,
                'formatter' => function ($d, $row) {
                    if($d != 0){
                        return date('d-m-Y',$d);
                    }else{
                        return '';
                    }

                }
            ),
            array( 'db' => 'purchase_order.bill_crystal', 'dt' => 4,
                'formatter' => function($id, $row) {
                    if($row[4] == 'NULL'){
                       return "<input type='text' class='form-control-md' name='bill_crystal'  id='bill_crystal_".$row[0]."' />";
                    }else{
                        return $row[4];
                    }
                }
            ),
            array( 'db' => 'purchase_order.id', 'dt' => 5,
                'formatter' => function($id, $row) {
                    if ($this->permit('receive_products', $this->folder)) {
                        if($row[3] == 0){
                            return '<button class="btn btn-sm receive_products" id="receive_products_'.$id.'"   type="button" style = "background-color : #E65C4F;color: #FFF;cursor: text;" disabled ><span>تم الوصول</span>  </button>';
                        }else{
                            if($row[4] == ''){
                                return '<button class="btn btn-sm receive_products" id="receive_products_'.$id.'" onclick="receive_products('.$id.')"  type="button" style = "background-color : #E65C4F;color: #FFF;" > <span>تم الوصول</span>  </button>';
                            }else{
                                return '<button class="btn btn-sm receive_products" id="receive_products_'.$id.'"   type="button" style = "background-color : #E65C4F;color: #FFF;cursor: text;" disabled >  <i class="fa fa-check-circle" ></i> <span>تم الوصول</span>  </button>';
                            }
                        }
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array( 'db' => 'purchase_order.id', 'dt' => 6,
                'formatter' => function( $id, $row ) {
                    if ($this->permit('add_to_excel', $this->folder)) {
                        if($row[3] == 0){
                            return '<button class="btn btn-sm receive_products" id="add_to_excel_'.$id.'"  type="button" style = "background-color : #008CBA;color: #FFF;cursor: text;" disabled > <span> رفع</span>  </button>';
                        }else{
                            if($row[12] != 0 && $row[13] == 0){
                                return '<button class="btn btn-sm receive_products" id="add_to_excel_'.$id.'"  type="button" style = "background-color : #008CBA;color: #FFF;cursor: text;" disabled > <span> رفع</span>  </button>';
                            }
                            elseif($row[13] == 0){
                                return '<button class="btn btn-sm receive_products" id="add_to_excel_'.$id.'" onclick="add_to_excel('.$id.')"  type="button" style = "background-color : #008CBA;color: #FFF;" > <span> رفع</span>  </button>';
                            }
                            else{
                                return '<button class="btn btn-sm receive_products" id="add_to_excel_'.$id.'"   type="button" style = "background-color : #008CBA;color: #FFF;cursor: text;" disabled >  <i class="fa fa-check-circle" ></i> <span>تم الرفع</span>  </button>';
                            }
                        }
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array( 'db' => 'purchase_order.state_order', 'dt' =>7,
            'formatter' => function ($state_order) {
                return $this->langControl($state_order);
                // return $this->check_state($id);
                }
             ),

            array( 'db' => 'purchase_order.date_request', 'dt' =>8,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i:s', $d);
                }
            ),
            array( 'db' => 'purchase_order.id', 'dt' =>9,
                'formatter' => function($id, $row) {

                    if ($this->permit('edit_purchase_bill', $this->folder)) {
                        return "<a href=".url."/purchase/edit_purchase_bill/$id class=''  style='text-align: center;font-size: 25px; margin-bottom:60px'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>";

                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array( 'db' => 'purchase_order.id', 'dt' => 10,
                'formatter' => function ($id, $row) {
                    if ($this->permit('copy_row', $this->folder)) {
                        return '<button class="btn btn-warning btn-sm " onclick="copy_row('.$id.')"  type="button"  >  <i class="fa fa-clone"></i> <span>تكرار</span>  </button>';
                    } else {
                        return $this->langControl('forbidden');
                    }

                }
            ),
            array('db'=> 'purchase_order.id', 'dt'=> 11,
                'formatter' => function( $id, $row ) {
                    return "<a href=".url."/purchase/upload_excel/$id class='dt-button buttons-excel buttons-html5  btn-sm'> <span>رفع اكسل</span></a>";
                }
            ),

            array( 'db' => 'purchase_order.date_receive', 'dt' => 12),
            array( 'db' => 'purchase_order.add_to_excel', 'dt' => 13)
            // array( 'db' => $tableJoin.'.model', 'dt' => 14)

        );
        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = " LEFT JOIN purchase_item ON purchase_order.id = purchase_item.idpurchase ";
        $whereAll = " purchase_order.id !=0 ";
        /*اذا مدخل بس تأريخ البداية
        * يعرض من التاريخ البداية واكبر منه
        */
        if ($date_start != 0) {
            $date_start = strtotime($date_start);
            $whereAll .=   " AND  `date_request` >= '".$date_start."' ";
        }

        /*اذا مدخل بس تأريخ النهاية
        * يعرض من التاريخ النهاية واقل منه
        */
        if($date_end != 0){
            $date_end = strtotime($date_end);
            $whereAll .=   " AND  `date_request` <= '".$date_end."' ";
        }
        if($state != ''){
            $whereAll .= " AND `state_order` IN ({$state}) ";
        }

        if ($model != 'select') {
            $whereAll .=   " AND  {$tableJoin}.model = '$model' ";
        }
        $whereAll .= " ORDER BY `date_request` DESC ";

        // print_r($whereAll);
        echo json_encode(
            SSP::complex_join( $_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll,null,null,1)
        );
    }

    // تعديل فاتورة المشتريات
    public function edit_purchase_bill($id)
    {
        $this->checkPermit('edit_purchase_bill','purchase');
        $this->adminHeaderController($this->langControl('purchase'));
        $index = 1; // for item purchase
        $i = 1;  //for payment
        $c = 1; //for cost
        $bill_crystal = '';
        $bill_purchase = array();
        $item_order = array();
        $payment_order = array();
        $cost_order = array();
        $allPayment = 0.0;
        $nameCurrency = '';
        // عرض اسماء الموردين
        $nameSupplier=array();
        $stmt_supplier =$this->db->prepare("SELECT  * FROM `$this->supplier` WHERE `type`= ?");
        $stmt_supplier->execute(array('supplier'));

        while ($row = $stmt_supplier->fetch(PDO::FETCH_ASSOC))
        {
            $nameSupplier[]=$row;
        }
        // عرض مصادر الطلب
        $stmt_source_request = $this->stmtSelect("$this->source_request");
        $sourceRequest=array();
        while ($row_source_request = $stmt_source_request->fetch(PDO::FETCH_ASSOC))
        {
            $sourceRequest[]=$row_source_request;
        }
        // عرض اسماء شركات الشحن
        $stmt_company_shipping = $this->stmtSelect("company_shipping");
        $companyShipping=array();
        while ($row_company_shipping= $stmt_company_shipping->fetch(PDO::FETCH_ASSOC))
        {
            $companyShipping[]=$row_company_shipping;
        }
        // عرض انواع الشحن
        $stmt_type_shipping= $this->stmtSelect("$this->type_shipping");
        $typeShipping=array();
        while ($row_type_shipping= $stmt_type_shipping->fetch(PDO::FETCH_ASSOC))
        {
            $typeShipping[]=$row_type_shipping;
        }

        // عرض العملات
        $stmt_currency= $this->stmtSelect("currency");
        $currency=array();
        while ($row_currency= $stmt_currency->fetch(PDO::FETCH_ASSOC))
        {
            $currency[]=$row_currency;
        }


        $stmtSupplier = $this->stmtSelect("$this->supplier");
        $accountSupplier=array();
        while ($row = $stmtSupplier->fetch(PDO::FETCH_ASSOC))
        {
            $accountSupplier[]=$row;
        }



        $stmt_order = $this->db->prepare("SELECT * FROM `{$this->purchase_order}` WHERE `id` = ?");
        $stmt_order->execute(array($id));
        if($stmt_order->rowCount() > 0){
            while($row_order = $stmt_order->fetch(PDO::FETCH_ASSOC)){


                if($row_order['date_request'] != '0'){
                    $row_order['date_request'] = date('Y-m-d',$row_order['date_request']);
                }else{
                    $row_order['date_request'] = '';
                }

                if($row_order['date_ex_eq'] != 0){
                    $row_order['date_ex_eq'] = abs(round(($row_order['date_ex_eq'] - time()) / (60 * 60 * 24)));
                }else{
                    $row_order['date_ex_eq'] = '';
                }

                if($row_order['date_eq'] != 0){
                    $row_order['date_eq'] = date('Y-m-d',$row_order['date_eq']);
                }else{
                    $row_order['date_eq'] = '';
                }

                if($row_order['date_send'] != 0){
                    $row_order['date_send'] =  date('Y-m-d',$row_order['date_send']);
                }
                else{
                    $row_order['date_send'] =  '';
                }

                if($row_order['date_ex_shipping'] != 0){
                    $row_order['date_ex_shipping'] = abs(round(($row_order['date_ex_shipping'] - time()) / (60 * 60 * 24)));
                }
                else{
                    $row_order['date_ex_shipping'] =  '';
                }

                if($row_order['date_shipping'] != 0){
                    $row_order['date_shipping'] =  date('Y-m-d',$row_order['date_shipping']);
                }
                else{
                    $row_order['date_shipping'] =  '';
                }


                if($row_order['date_arrival'] != 0){
                    $row_order['date_arrival'] = date('Y-m-d',$row_order['date_arrival']);
                }else{
                    $row_order['date_arrival'] = '';
                }

                if($row_order['date_ex_arrival'] != 0){
                    $row_order['date_ex_arrival'] =  abs(round(($row_order['date_ex_arrival'] - time()) / (60 * 60 * 24)));
                }else{
                    $row_order['date_ex_arrival'] = '';
                }

                if($row_order['date_arrival_warehouse'] != 0){
                    $row_order['date_arrival_warehouse'] = date('Y-m-d',$row_order['date_arrival_warehouse']);
                }else{
                    $row_order['date_arrival_warehouse'] = '';
                }

                if($row_order['date_reminder'] != '0'){
                    $row_order['date_reminder'] = date('Y-m-d',$row_order['date_reminder']);
                }else{
                    $row_order['date_reminder'] = '';
                }

                $name_currency = $this->db->prepare("SELECT `name` FROM `currency` WHERE `id` = ?");
                $name_currency->execute(array($row_order['idcurrency']));
                $row_name = $name_currency->fetch(PDO::FETCH_ASSOC);
                $nameCurrency = $row_name['name'];

                $bill_purchase[] = $row_order;
                $bill_crystal = $row_order['bill_crystal'];

            }
            json_encode($bill_crystal);

        }


        $stmt_item = $this->db->prepare("SELECT * FROM `{$this->purchase_item}` WHERE `idpurchase` = ?");
        $stmt_item->execute(array($id));


        while($row_item = $stmt_item->fetch(PDO::FETCH_ASSOC)){
            $row_item['id'] =  $this->get_id_by_model($row_item['model'],$row_item['code']);
            $item_order[] = $row_item;
        }


        $stmt_payment = $this->db->prepare("SELECT * FROM `payment_purchase` WHERE `idpurchase` = ?");
        $stmt_payment->execute(array($id));
        while($row_payment = $stmt_payment->fetch(PDO::FETCH_ASSOC)){
            $row_payment['date'] = date('Y-m-d',$row_payment['date']);
            $allPayment += $row_payment['payment'];
            $payment_order[] = $row_payment;
        }

        $stmt_cost = $this->db->prepare("SELECT * FROM `extra_purchase_cost` WHERE `idpurchase` = ?");
        $stmt_cost->execute(array($id));
        while($row_cost = $stmt_cost->fetch(PDO::FETCH_ASSOC)){
            $row_cost['date'] = date('Y-m-d',$row_cost['date']);
            // $allPayment += $row_payment['payment'];
            $cost_order[] = $row_cost;
        }


        if (isset($_POST['submit'])) {

            // add order to table trace
            $allData = array();
            // $allData = array_merge($bill_purchase, $item_order);
            $allData = $bill_purchase;
            $allData['item_purchase'] = $item_order;
            $allData['payment_purchase'] =  $payment_order;

            // تكلفة شراء اضافية
            $allData['cost_purchase'] =  $cost_order;

            $oldData = json_encode($allData);
            $stmt_trace = $this->db->prepare("INSERT INTO `trace_purchase_order` (`idpurchase`,`data`,`iduser`,`date`) VALUES (?,?,?,?)");
            $stmt_trace->execute(array($id, $oldData, $this->userid, time()));

            // json هذا الجزء لعرض بيانات الطلب حافظتها
            // $s = $this->db->prepare("select * from `trace_purchase_order` where `idpurchase` = ? order by `date` desc limit 1");
            // $s->execute(array($id));
            // $row = $s->fetch(PDO::FETCH_ASSOC);
            // $o = json_decode($row['data'], true);
            // echo '<pre>';
            // print_r($o);
            // echo '</pre>';
            // echo $o['item_purchase'][0]['title'];


            try {
                $form = new  Form();
                $form->post('name_supplier')
                    ->val('strip_tags');

                $form->post('source_request')
                    ->val('strip_tags');

                $form->post('company_shipping')
                    ->val('strip_tags');

                $form->post('type_shipping')
                    ->val('strip_tags');

                $form->post('date_request')
                    ->val('strip_tags');

                $form->post('date_ex_eq')
                    ->val('strip_tags');

                $form->post('date_eq')
                    ->val('strip_tags');

                $form->post('date_send')
                    ->val('strip_tags');

                $form->post('date_ex_shipping')
                    ->val('strip_tags');

                $form->post('date_shipping')
                    ->val('strip_tags');

                $form->post('date_ex_arrival')
                    ->val('strip_tags');

                $form->post('date_arrival')
                    ->val('strip_tags');

                $form->post('date_arrival_warehouse')
                    ->val('strip_tags');

                $form->post('user_add_arrival_warehouse')
                    ->val('strip_tags');

                $form->post('currency')
                    ->val('strip_tags');

                $form->post('price_exchange_order')
                    ->val('strip_tags');

                $form->post('note_order')
                    ->val('strip_tags');

                $form->post('title')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('category')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('code')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('quantity')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('image')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('size_val')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('type_val')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('rate_val')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('price_purchase')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('sale_price')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('wholesale_price_sale')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('wholesale_price2_sale')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('note')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('total-price')
                    ->val('strip_tags');

                $form->post('total_price_dollars')
                    ->val('strip_tags');

                $form->post('total_price_cost')
                ->val('strip_tags');

                $form->post('idcost')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('cost')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('currency_cost')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('price_exchange_cost')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('note_cost')
                    ->val('is_array')
                    ->val('strip_tags');


                $form->post('id_payment')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('subtotal')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('name_pay')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('price_exchange')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('note_payment')
                    ->val('is_array')
                    ->val('strip_tags');


                $form->submit();

                $data = $form->fetch();

                if (empty($this->error_form)) {

                    $title = json_decode($data['title'], true);
                    $category = json_decode($data['category'], true);
                    $codes = json_decode($data['code'], true);
                    $quantity = json_decode($data['quantity'], true);
                    $img = json_decode($data['image'], true);
                    $size = json_decode($data['size_val'], true);
                    $type = json_decode($data['type_val'], true);
                    $rate = json_decode($data['rate_val'], true);
                    $price_purchase = json_decode($data['price_purchase'], true);
                    $sale_price = json_decode($data['sale_price'], true);
                    $wholesale_price_sale = json_decode($data['wholesale_price_sale'], true);
                    $wholesale_price2_sale = json_decode($data['wholesale_price2_sale'], true);
                    $note = json_decode($data['note'], true);

                    $costs = json_decode($data['cost'], true);
                    $currencyCost = json_decode($data['currency_cost'], true);
                    $priceExchangeCost = json_decode($data['price_exchange_cost'], true);
                    $idCost = json_decode($data['idcost'], true);
                    $noteCost = json_decode($data['note_cost'], true);

                    $subtotals = json_decode($data['subtotal'], true);
                    $namePay = json_decode($data['name_pay'], true);
                    $priceExchange = json_decode($data['price_exchange'], true);
                    $idPayment = json_decode($data['id_payment'], true);
                    $notePayment = json_decode($data['note_payment'], true);
                    // change number day to format(time stamp)

                    if( $data['date_ex_eq'] == ''){
                        $dateExEq = 0;
                    }else{
                        $dateExEq = time() + (60 * 60 * 24 * $data['date_ex_eq']);
                    }

                    if($data['date_ex_shipping'] == ''){
                        $dateExShipping = 0;
                    }else{
                        $dateExShipping = time() + (60 * 60 * 24 * $data['date_ex_shipping']);

                    }
                    if($data['date_ex_arrival'] == ''){
                        $dateExArrival = 0;
                    }else{
                        $dateExArrival = time() + (60 * 60 * 24 * $data['date_ex_arrival']);

                    }

                    $data['date_request'] = strtotime($data['date_request']);
                    $data['date_eq'] = strtotime($data['date_eq']);
                    $data['date_send'] = strtotime($data['date_send']);
                    $data['date_shipping'] = strtotime($data['date_shipping']);
                    $data['date_arrival'] = strtotime($data['date_arrival']);
                    $data['date_arrival_warehouse'] = strtotime($data['date_arrival_warehouse']);



                    $sumTotal = 0;
                    $check_currency = $this->db->prepare("SELECT `name` FROM `{$this->purchase_item}` WHERE `id` = ?");
                    $check_currency->execute(array($data['currency']));
                    $currency = $check_currency->fetch();
                    if($check_currency->rowCount() > 0){
                        if($currency['name'] == 'دولار'){
                            $priceExchangeItem = 0;
                        }else{
                            for($i= 0 ; $i <= count($subtotals); $i++){
                                $sumTotal += $subtotals[$i];

                            }
                            if($sumTotal ==  $data['total_price_cost']){
                                for($i= 0 ; $i <= count($subtotals); $i++){
                                    $priceExchangeItem +=  $subtotals[$i] * $priceExchange[$i];
                                }
                                $priceExchangeItem = $priceExchangeItem / $data['total_price_cost'];
                                $priceExchangeItem =  round($priceExchangeItem, 2);

                            }

                            if($sumTotal <  $data['total_price_cost']){
                                $min = $data['total_price_cost'] - $sumTotal;
                                for($i= 0 ; $i <= count($subtotals); $i++){
                                    $priceExchangeItem +=  $subtotals[$i] * $priceExchange[$i];
                                }
                                $priceExchangeItem +=  $min * $data['price_exchange_order'];
                                $priceExchangeItem = $priceExchangeItem / $data['total_price_cost'];
                                $priceExchangeItem =  round($priceExchangeItem, 2);

                            }

                            if($sumTotal > $data['total_price_cost']){
                                $sumPrice = 0;
                                for($i= 0 ; $i <= count($subtotals); $i++){
                                    $sumPrice +=  $subtotals[$i];
                                    if($sumPrice < $sumTotal || $sumPrice == $sumTotal){
                                        $priceExchangeItem +=  $subtotals[$i] * $priceExchange[$i];
                                    }else{
                                        $min = $sumPrice - $sumTotal;
                                        $priceExchangeItem +=  $min * $priceExchange[$i];
                                        break;
                                    }
                                }

                                $priceExchangeItem = $priceExchangeItem / $data['total_price_cost'];
                                $priceExchangeItem =  round($priceExchangeItem, 2);
                            }
                        }
                    }



                    $stmt = $this->db->prepare("UPDATE  `{$this->purchase_order}` set  `idsupplier` = ?,`idsource_request` =?,`idtype_shipping` = ?,`idcompany_shipping` = ?,`idcurrency` =?, `price_exchange` = ?,`total-price` = ?,`total_price_dollars` = ?,`date_request` =?,`iduser_date_request` = ?,`state_order` = ?, `note`=? WHERE  `id` = ?");
                    $stmt->execute(array($data['name_supplier'],$data['source_request'],$data['type_shipping'],$data['company_shipping'],$data['currency'], $data['price_exchange_order'],$data['total-price'], $data['total_price_dollars'], $data['date_request'],$this->userid,'on_request',$data['note_order'] ,$id));

                    if($bill_purchase[0]['date_ex_eq'] != $dateExEq){
                        $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `date_ex_eq` = ?, `iduser_date_ex_eq` = ? , `state_order` = ? WHERE `id` = ?");
                        $stmt_update->execute(array($dateExEq,$this->userid,'being_processed',$id));
                    }

                    if($bill_purchase[0]['date_eq'] != $data['date_eq']){
                        $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `date_eq` = ?, `iduser_date_eq` = ? , `state_order` =? WHERE `id` = ?");
                        $stmt_update->execute(array($data['date_eq'],$this->userid,'being_sent',$id));
                    }

                    if($bill_purchase[0]['date_shipping'] != $data['date_shipping']){
                        $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `date_shipping` = ?, `iduser_date_shipping` = ? , `state_order` =? WHERE `id` = ?");
                        $stmt_update->execute(array($data['date_shipping'],$this->userid,'shipping',$id));
                    }

                    if($bill_purchase[0]['date_ex_arrival'] != $dateExArrival ){
                        $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `date_ex_arrival` = ?, `iduser_date_arrival` = ? , `state_order` =? WHERE `id` = ?");
                        $stmt_update->execute(array($dateExArrival,$this->userid,'loaded',$id));
                    }
                    if($bill_purchase[0]['date_arrival'] != $data['date_arrival']){
                        $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `date_arrival` = ?, `iduser_date_ex_arrival` = ? , `state_order` =? WHERE `id` = ?");
                        $stmt_update->execute(array($data['date_arrival'],$this->userid,'arrival',$id));
                    }

                    if($bill_purchase[0]['date_arrival_warehouse'] != $data['date_arrival_warehouse']){
                        $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `date_arrival_warehouse` = ?, `iduser_date_arrival_warehouse` = ? ,`user_arrival_warehouse` =? ,`state_order` =? WHERE `id` = ?");
                        $stmt_update->execute(array($data['date_arrival_warehouse'],$this->userid,$data['user_add_arrival_warehouse'],'arrival_warehouse',$id));
                    }

                    if($bill_purchase[0]['date_ex_shipping'] != $dateExShipping){
                        $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `date_ex_shipping` = ?, `iduser_date_exshipping` = ? WHERE `id` = ?");
                        $stmt_update->execute(array($dateExShipping,$this->userid,$id));
                    }

                    if($bill_purchase[0]['date_send'] != $data['date_send']){
                       $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `date_send` = ?, `iduser_date_send` = ? WHERE `id` = ?");
                       $stmt_update->execute(array($data['date_send'],$this->userid,$id));
                    }


                    if($stmt->rowCount() > 0){
                        foreach ($codes as $key => $code) {
                            if($priceExchangeItem != 0){
                                $price_dollars = $price_purchase[$key] / $priceExchangeItem;
                            }else{
                                $price_dollars = $price_purchase[$key];
                            }

                            if($code != ''){
                                $stmt_select = $this->db->prepare("SELECT * FROM `{$this->purchase_item}` WHERE `idpurchase` = ? AND `code` = ?");
                                $stmt_select->execute(array($id, $code));
                                $row = $stmt_select->fetch();
                                if($stmt_select->rowCount() > 0){
                                    $stmt_item = $this->db->prepare("UPDATE `{$this->purchase_item}` set  `title` = ?,`code` = ?,`quantity` = ?,`price_purchase` = ?,`price_dollars`=?,`price_sale` = ?,`wholesale_price_sale` = ?,`wholesale_price2_sale` = ?,`note` = ?, `id_user` = ?, `model` = ? ,`image` = ?,`size` = ?,`rate` = ?,`type` =?,`date` = ?  where `idpurchase` = ? AND `code` = ?");
                                    $stmt_item->execute(array($title[$key],$code,$quantity[$key],$price_purchase[$key],$price_dollars,$sale_price[$key],$wholesale_price_sale[$key],$wholesale_price2_sale[$key],$note[$key],$this->userid,$category[$key],$img[$key],$size[$key],$rate[$key],$type[$key],time() , $id , $code));
                                }
                                else{
                                    $stmt_item = $this->db->prepare("INSERT INTO `{$this->purchase_item}` (`idpurchase`,`title`,`code`,`quantity`,`price_purchase`,`price_dollars`,`price_sale`,`wholesale_price_sale`,`wholesale_price2_sale`,`note`, `id_user`, `model`,`image`,`size`,`rate`,`type`,`date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                                    $stmt_item->execute(array($id ,$title[$key],$code,$quantity[$key],$price_purchase[$key],$price_dollars,$sale_price[$key],$wholesale_price_sale[$key],$wholesale_price2_sale[$key],$note[$key],$this->userid,$category[$key],$img[$key],$size[$key],$rate[$key],$type[$key],time()));
                                }
                            }
                        }
                    }


                    foreach($costs as $key => $cost) {
                        if($cost !='' && $idCost[$key] == '0'){
                            $stmt_cost = $this->db->prepare("INSERT INTO `extra_purchase_cost`(`idpurchase`,`cost`,`idcurrency`,`price_exchange`,`note`,`iduser`,`date`) VALUE (?,?,?,?,?,?,?)");
                            $stmt_cost->execute(array($id,$cost,$currencyCost[$key],$priceExchangeCost[$key],$noteCost[$key],$this->userid,time()));
                        }else{

                            $update_cost = $this->db->prepare("UPDATE `extra_purchase_cost` SET `cost` =? ,`idcurrency` =? ,`price_exchange` =? ,`note`= ?   WHERE `idpurchase` = ? AND `id` = ?");
                            $update_cost->execute(array($cost,$currencyCost[$key],$priceExchangeCost[$key],$noteCost[$key],$id,$idCost[$key]));
                        }
                    }


                    foreach($subtotals as $key => $subtotal) {
                        if($subtotal !='' && $idPayment[$key] == '0'){
                            $stmt_payment = $this->db->prepare("INSERT INTO `payment_purchase` (`idpurchase`,`iduser`,`payment`,`id_name_pay`,`price_exchange`,`note`,`date`) VALUES (?,?,?,?,?,?,?)");
                            $stmt_payment->execute(array($id,$this->userid,$subtotal,$namePay[$key],$priceExchange[$key],$notePayment[$key],time()));
                        }else{

                            $update_payment = $this->db->prepare("UPDATE `payment_purchase` SET `payment`=? ,`id_name_pay`=? ,`price_exchange`=? ,`note`=?   WHERE `idpurchase` =? AND `id` = ?");
                            $update_payment->execute(array($subtotal,$namePay[$key],$priceExchange[$key],$notePayment[$key],$id,$idPayment[$key]));
                        }
                    }

                }

            } catch (Exception $e) {
                // $data = $form->fetch();
                // $data['date'] = strtotime($data['date']);
                $this->error_form = json_decode($e->getMessage(), true);
            }
        }

        require ($this->render($this->folder,'html','edit_purchase_bill','php'));
        $this->adminFooterController();
    }

    public function upload_excel($id)
    {
        $this->checkPermit('upload_excel','purchase');
        $this->adminHeaderController($this->langControl('purchase'));

        // $checkIfExist = array();
        if(isset($_POST["submit"])) {


            try {
                $form = new  Form();

                $form->post('files_normal')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $name_file=json_decode($data['files_normal'],true);

                $inputFileName=$this->root_file.'/files/'.$name_file[0]['rand_name'];
                if (file_exists($inputFileName)) {

                    //  Read your Excel workbook
                    try {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFileName);
                    } catch (Exception $e) {
                        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                    }

                    //  Get worksheet dimensions
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();
                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        // echo $row;
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                            FALSE,
                            TRUE,
                            TRUE);
                        if (count($rowData[0]) > 2) {

                            if (!isset($rowData[0][4]))
                            {
                                $rowData[0][4]='0';
                            }else
                            {
                                if (empty($rowData[0][4]))
                                {
                                    $rowData[0][4]='0';
                                }
                            }

                            if (!isset($rowData[0][5]))
                            {
                                $rowData[0][5]='0';
                            }else
                            {
                                if (empty($rowData[0][5]))
                                {
                                    $rowData[0][5]='0';
                                }
                            }
                            if (!isset($rowData[0][6]))
                            {
                                $rowData[0][6]='0';
                            }else
                            {
                                if (empty($rowData[0][6]))
                                {
                                    $rowData[0][6]='0';
                                }
                            }


                            if (!empty($rowData[0][0])) {

                                $code=(int)trim(strip_tags($rowData[0][0]));
                                $model=trim(strip_tags($rowData[0][1]));

                                $quantity = (int)trim(strip_tags($rowData[0][2]));
                                $price_purchase = trim(strip_tags($rowData[0][3]));
                                $price_sale = trim(strip_tags($rowData[0][4]));
                                $wholesale_price_sale = trim(strip_tags($rowData[0][5]));
                                $wholesale_price2_sale = trim(strip_tags($rowData[0][6]));

                                // $code=(int)trim(strip_tags($rowData[0][1]));
                                $item = array();
                                if($model == 'موبايل'){
                                    $model = 'mobile';
                                    $table = 'code';
                                    $item =  $this->selectItemByCode($model,$code);
                                }
                                elseif($model == 'حاسبات'){
                                    $model = 'computer';
                                    $table =  'code_'.$model;
                                    $item =  $this->selectItemByCode($model,$code);
                                }
                                elseif($model == 'العاب' || $model == 'الالعاب'){
                                    $model = 'games';
                                    $table =  'code_'.$model;
                                    $item =  $this->selectItemByCode($model,$code);
                                }
                                elseif($model == 'حافظات'){
                                    $model = 'savers';
                                    $table =  'product_savers';
                                    $item =  $this->selectSaversByCode($code);
                                }
                                elseif($model == 'اكسسوارات' || $model == 'اكسسوار'){
                                    $model = 'accessories';
                                    $table =  'color_accessories';
                                    $item =  $this->selectAccByCode($code);
                                }
                                else{
                                    $table =  '';
                                }


                                if(!empty($item)){
                                    $stmt = $this->db->prepare("INSERT INTO `{$this->purchase_item}` (`idpurchase`,`id_user`,`title`,`quantity`,`code`, `model` ,`size`,`rate`,`type`,`image`,`price_purchase`,`price_sale`,`wholesale_price_sale`,`wholesale_price2_sale`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                                    $stmt->execute(array($id,$this->userid,$item[0]['title'],$quantity,$code,$model,$item[0]['size'],$item[0]['rate'],$item[0]['type'],$item[0]['img'],$price_purchase,$price_sale,$wholesale_price_sale,$wholesale_price2_sale));

                                }else{
                                    $stmt = $this->db->prepare("INSERT INTO `excel_purchase` (`idpurchase`,`iduser`,`code`, `model`,`date`) VALUES (?,?,?,?,?)");
                                    $stmt->execute(array($id,$this->userid,$code,$rowData[0][1],time()));
                                }
                            }
                        } else {
                            $this->error_form = json_encode(array('files_normal' => 'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
                            break;
                        }

                    }

                    @unlink($inputFileName);

                }else
                {

                    $this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form))
                {
                    $this->lightRedirect(url."/".$this->folder."/edit_purchase_bill/$id");
                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'html','upload_excel','php'));
        $this->adminFooterController();
    }



    function item_pur_not_upload(){
        $this->checkPermit('item_pur_not_upload','purchase');
        $this->adminHeaderController($this->langControl('purchase'));

        require ($this->render($this->folder,'html','item_not_upload','php'));
        $this->adminFooterController();
    }

    public function processing_not_upload()
    {
        $table = "excel_purchase";
        $primaryKey = 'id';
        $columns = array(
            array( 'db' => 'id', 'dt' => 0 ),
            array( 'db' => 'idpurchase', 'dt' => 1),
            array( 'db' => 'code', 'dt' => 2),
            array( 'db' => 'model', 'dt' => 3),
            array( 'db' => 'iduser', 'dt' => 4 ,
                'formatter' => function( $d, $row ) {
                return  $this->UserInfo( $d) ;
                }
            ),

            array( 'db' => 'date', 'dt' => 5 ,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);
                }
            ),

            array( 'db' => 'id', 'dt' => 6,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return '<button class="btn btn-sm delete_row" onclick="delete_row('.$id.')"  type="button"  > <i class="fa fa-trash-o" aria-hidden="true"></i>  </button>';
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
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


    // ابحث عن باركود في اي مودل
    function checkCode($table,$where){
        $stmt_code = $this->db->prepare("SELECT `code` FROM `$table`  WHERE {$where} ");
        $stmt_code->execute();
        if($stmt_code->rowCount() > 0){
            return 1;
        }else{
            return 0;
        }
    }



    public function stmtSelect($nameTable)
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$nameTable}`");
        $stmt->execute();
        return  $stmt;
    }

    // get data by code from tables(mobile,computer,games)
    public function selectItemByCode($model,$barcode)
    {
        if($model=='mobile'){
            $color = 'color';
            $code = 'code';
            $excel = 'excel';
        } else{
            $color = 'color_'. $model;
            $code = 'code_'. $model;
            $excel = 'excel_'. $model;
        }
        $item = array();
        $stmt_code = $this->db->prepare("SELECT `id`,`code`,`id_color`,`size` FROM `$code` WHERE `is_delete` = 0 AND `code`=? ");
        $stmt_code->execute(array($barcode));
        if($stmt_code->rowCount() > 0){
            while ($row = $stmt_code->fetch(PDO::FETCH_ASSOC))
            {
                $id_color = $row['id_color'];
                $stmt_color = $this->db->prepare("SELECT `img` , `id_item` FROM `$color` WHERE `is_delete` = 0 AND  `id`=?  limit 1");
                $stmt_color->execute(array($id_color));
                while ($row_color = $stmt_color->fetch(PDO::FETCH_ASSOC))
                {
                    $row['img'] = $row_color['img'];
                    $id_item = $row_color['id_item'];
                }
                $stmt_item = $this->db->prepare("SELECT `id`,`title` FROM `$model` WHERE `is_delete` = 0 AND `id`=?   limit 1");
                $stmt_item->execute(array($id_item));
                while ($row_item = $stmt_item->fetch(PDO::FETCH_ASSOC))
                {
                    $row['id'] = $row_item['id'];
                    $row['title'] = $row_item['title'];
                }
                // $row['e'] = $excel;
                $stmt_excel = $this->db->prepare("SELECT `quantity` ,`wholesale_price`, `wholesale_price2`, `price_dollars` FROM `$excel` WHERE  `code`=? ");
                $stmt_excel->execute(array($barcode));
                if($stmt_excel->rowCount() > 0){
                    while ($row_excel = $stmt_excel->fetch(PDO::FETCH_ASSOC))
                    {
                        // $row['quantity']=$row_excel['quantity'];
                        $row_excel['wholesale_price'] === "NULL" ? $row['wholesale_price'] = 0 : $row['wholesale_price'] = $row_excel['wholesale_price'];
                        $row_excel['wholesale_price2'] === "NULL" ? $row['wholesale_price2'] = 0 : $row['wholesale_price2'] = $row_excel['wholesale_price2'];
                        // $row['wholesale_price2']=$row_excel['wholesale_price2'];
                        $row['price_dollars']=$row_excel['price_dollars'];
                    }
                }
                $row['rate'] = '';
                $row['type'] = '';
                $item[]=$row;
            }
        }
        return $item;
    }

    // get data by code from tables(product_savers)
    public function selectSaversByCode($barcode){
        $item = array();
        $model = 'product_savers';
        $stmt_items = $this->db->prepare("SELECT  `id`, `code`,`title` , `img`,`cover_material` ,`type_cover`, `feature_cover`,`note` FROM `$model` WHERE `is_delete` = 0 AND `code`=? ");
        $stmt_items->execute(array($barcode));
        if($stmt_items->rowCount() > 0){
            while ($row = $stmt_items->fetch(PDO::FETCH_ASSOC))
            {
                // echo $row['code'];
                $row['id'] = $row['id'];
                $stmt_cover_material =$this->db->prepare("SELECT `cover_material` FROM `cover_material` WHERE  `number`=? limit 1");
                $stmt_cover_material->execute(array($row['cover_material']));
                if($stmt_cover_material->rowCount() > 0){
                    $row_cover_material = $stmt_cover_material->fetch(PDO::FETCH_ASSOC);
                    $cover_material = $row_cover_material['cover_material'];
                }else{
                    $cover_material = '';
                }

                $stmt_type_cover =$this->db->prepare("SELECT `type_cover` FROM `type_cover` WHERE  `number`=?  limit 1");
                $stmt_type_cover->execute(array($row['type_cover']));
                if($stmt_type_cover->rowCount() > 0){
                    $row_type_cover = $stmt_type_cover->fetch(PDO::FETCH_ASSOC);
                    $type_cover = $row_type_cover['type_cover'];
                }else{
                    $type_cover = '';
                }


                $stmt_feature_cover =$this->db->prepare("SELECT `feature_cover` FROM `feature_cover` WHERE  `number`=? limit 1");
                $stmt_feature_cover->execute(array($row['feature_cover']));
                if($stmt_feature_cover->rowCount() > 0){
                    $row_feature_cover = $stmt_feature_cover->fetch(PDO::FETCH_ASSOC);
                    $feature_cover = $row_feature_cover['feature_cover'];
                }else{
                    $feature_cover = '';
                }

                $row['rate'] = $row['note'];

                $row['type'] = $cover_material .' - '. $type_cover .' - '.$feature_cover;


                $stmt_excel = $this->db->prepare("SELECT  `quantity` ,`wholesale_price`, `wholesale_price2`,`price_dollars` FROM `excel_savers` WHERE  `code`=? ");
                $stmt_excel->execute(array($barcode));
                if($stmt_excel->rowCount() > 0){
                    while ($row_excel = $stmt_excel->fetch(PDO::FETCH_ASSOC))
                    {
                        // $row['quantity'] = $row_excel['quantity'];
                        $row_excel['wholesale_price'] === "NULL" ? $row['wholesale_price'] = 0 : $row['wholesale_price'] = $row_excel['wholesale_price'];
                        $row_excel['wholesale_price2'] === "NULL" ? $row['wholesale_price2'] = 0 : $row['wholesale_price2'] = $row_excel['wholesale_price2'];
                        $row['price_dollars'] = $row_excel['price_dollars'];
                    }
                }
                $row['size'] = '';
                $item[]=$row;
            }
        }
        return $item;
    }

    // get data by code from tables(accessories)
    public function selectAccByCode($barcode){
        $item = array();
        $model = 'accessories';
        $color = 'color_accessories';

        $stmt_color = $this->db->prepare("SELECT `img` ,`id_item` , `code` FROM `$color` WHERE `is_delete` = 0 AND `code`=? ");
        $stmt_color->execute(array($barcode));
        if($stmt_color->rowCount() > 0){
            while ($row = $stmt_color->fetch(PDO::FETCH_ASSOC))
            {
                $id_item = $row['id_item'];
                // $row['code'] = $barcode;
                // $row['img'] = $row['img'];
                $stmt_item = $this->db->prepare("SELECT  `id`, `title`  FROM `$model` WHERE  `is_delete` = 0 AND  `id`=?  limit 1");
                $stmt_item->execute(array($id_item));
                while ($row_item = $stmt_item->fetch(PDO::FETCH_ASSOC))
                {
                    $row['title'] = $row_item['title'];
                    $row['id'] = $row_item['id'];
                }

                $stmt_excel = $this->db->prepare("SELECT `quantity` ,`wholesale_price` , `wholesale_price2`,`price_dollars` FROM `excel_accessories` WHERE  `code`=? ");
                $stmt_excel->execute(array($barcode));
                if($stmt_excel->rowCount() > 0){
                    while ($row_excel = $stmt_excel->fetch(PDO::FETCH_ASSOC))
                    {
                        // $row['quantity']=$row_excel['quantity'];
                        $row_excel['wholesale_price'] === "NULL" ? $row['wholesale_price'] = 0 : $row['wholesale_price'] = $row_excel['wholesale_price'];
                        $row_excel['wholesale_price2'] === "NULL" ? $row['wholesale_price2'] = 0 : $row['wholesale_price2'] = $row_excel['wholesale_price2'];
                        $row['price_dollars']=$row_excel['price_dollars'];
                        $row['rate'] = '';
                        $row['type'] = '';
                    }
                }
                $row['size'] = '';
                $item[]=$row;
            }
        }
        return $item;
    }

    // تعرض البيانات على الاساس الاسم
    public function selectName()
    {

        $data = json_decode($_GET['jsonData'], true);
        $model = $data['category'];
        $title = $data['title'];
        $item = array();

        if($model == 'savers'){
            $model = 'product_savers';
            $stmt_item = $this->db->prepare("SELECT `title` , `code` FROM `$model` WHERE `is_delete` = 0 AND `title` like '$title%' limit 40");
            $stmt_item->execute();
            if($stmt_item->rowCount() > 0){
                while ($row_item = $stmt_item->fetch(PDO::FETCH_ASSOC)){
                    $row_item['code'] = $row_item['code'];
                    $row_item['title'] = $row_item['title'] .' ( باركود :' . $row_item['code'] . ')';
                    $item[]=$row_item;
                }
            }

        }
        if($model == 'accessories'){
            $model = 'accessories';
            $color = 'color_accessories';

            $stmt_item = $this->db->prepare("SELECT `id` ,`title`  FROM `$model` WHERE  `is_delete` = 0 AND  `title` like '$title%' limit 40");
            $stmt_item->execute();
            if($stmt_item->rowCount() > 0){
                while ($row = $stmt_item->fetch(PDO::FETCH_ASSOC))
                {
                    $id_item = $row['id'];
                    $stmt_color = $this->db->prepare("SELECT `img` ,`color`, `code`  FROM `$color` WHERE `is_delete` = 0 AND `id_item`=? ");
                    $stmt_color->execute(array($id_item));
                    while ($row_color = $stmt_color->fetch(PDO::FETCH_ASSOC))
                    {
                        $row['code'] =  $row_color['code'];
                        $row['title'] = $row['title'] . ' (لون ' . $row_color['color'] . ')' . ' ( باركود :' . $row_color['code'] . ')';
                    }
                    $item[]=$row;
                }
            }
        }
        if($model == 'mobile' || $model == 'games' || $model == 'computer'){
            if($model=='mobile'){
                $color = 'color';
                $code = 'code';
            } else{
                $color = 'color_'. $model;
                $code = 'code_'. $model;
            }
            $item = array();
            $codes = '';
            $stmt_item = $this->db->prepare("SELECT  `id` , `title`  FROM `$model` WHERE  `is_delete` = 0 AND  `title` like '$title%' limit 40");
            $stmt_item->execute();
            if($stmt_item->rowCount() > 0){
                while ($row = $stmt_item->fetch(PDO::FETCH_ASSOC)){
                    $id_item = $row['id'];
                    $name = $row['title'];
                    $stmt_color = $this->db->prepare("SELECT `id`,`color`  FROM `$color` WHERE `is_delete` = 0 AND  `id_item`=? ");
                    $stmt_color->execute(array($id_item));
                    while ($row_color = $stmt_color->fetch(PDO::FETCH_ASSOC))
                    {
                        $id_color = $row_color['id'];
                        $row_color = $row_color['color'];
                        $stmt_code = $this->db->prepare("SELECT  `code` FROM `$code` WHERE `is_delete` = 0 AND `id_color`=? ");
                        $stmt_code->execute(array($id_color));
                        if($stmt_code->rowCount() > 0){
                            while ($row_code= $stmt_code->fetch(PDO::FETCH_ASSOC))
                            {

                                $row[]['code'] = $row_code['code'];
                                if($row_code['code'] != '' &&  $row_color !=''){

                                $item[]['title'] = $name . ' (لون ' .  $row_color . ')' . ' ( باركود :' . $row_code['code'] . ')';
                                }
                            }
                        }
                    }

                }
            }
        }
        echo json_encode($item);
    }


    // تعرض اسماء المستخدمين بقائمة اثناء الكتابه
    public function selectUser()
    {

        $data = json_decode($_GET['jsonData'], true);
        $name = $data['name'];
        $item = array();

        $stmt_item = $this->db->prepare("SELECT `username` FROM `user` WHERE `username` like '$name%' limit 40");
        $stmt_item->execute();
        if($stmt_item->rowCount() > 0){
            while ($row_item = $stmt_item->fetch(PDO::FETCH_ASSOC)){
                $row_item['name'] = $row_item['username'];
                $item[]=$row_item;
            }
        }

        echo json_encode($item);
    }

    // function check user
    public function checkUser()
    {
        $data = json_decode($_GET['jsonData'], true);
        $username = $data['name'];
        $stmt_item = $this->db->prepare("SELECT `username` FROM `user` WHERE `username` = ? ");
        $stmt_item->execute(array($username));
        if($stmt_item->rowCount() > 0){
            echo 1;
        } else{
            echo 0;
        }
    }




    function selectById($id,$model,$column = 'name')
    {

        $stmt = $this->db->prepare("SELECT `$column` from `$model` WHERE `id`=?   ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data[$column];
        } else {
            return '';
        }
    }


    // تكرار فاتورة شراء
    function copy_row($id)
    {
        $stmt=$this->db->prepare("INSERT INTO `{$this->purchase_order}` (`iduser`,`created`,`bill_crystal`) VALUES (?,?,?) ");
        $stmt->execute(array($this->userid,time(),'NULL'));

        $idpurchase = $this->db->lastInsertId();
        // $stmt_update = $this->db->prepare("UPDATE `{$this->purchase_order}` SET `created`= ? WHERE `id`=?");
        // $stmt_update->execute(array(time(),$idpurchase));
        if ($stmt->rowCount() > 0)
        {
            $stmt_select = $this->db->prepare("SELECT `title`,`code`,`quantity`,`price_purchase`,`price_sale`,`wholesale_price_sale`,`wholesale_price2_sale`,`note`,`id_user`,`model`,`date` FROM `purchase_item` WHERE idpurchase=?");
            $stmt_select->execute(array($id));
            if ($stmt_select->rowCount() > 0) {
                // echo $idpurchase;
                while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
                    $stmt_item = $this->db->prepare("INSERT INTO `purchase_item` (`idpurchase`,`title`,`code`,`quantity`,`price_purchase`,`price_sale`,`wholesale_price_sale`,`wholesale_price2_sale`,`note`,`id_user`,`model`,`date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                    $stmt_item->execute(array($idpurchase,$row['title'],$row['code'],$row['quantity'],$row['price_purchase'],$row['price_sale'],$row['wholesale_price_sale'],$row['wholesale_price2_sale'],$row['note'],$row['id_user'],$row['model'],time()));
                    echo 1;
                }
            }
        }
    }


    function delete_row_item($code,$id){
        $stmt=$this->db->prepare("DELETE FROM `$this->purchase_item` WHERE idpurchase=? AND code=?");
        $stmt->execute(array($id,$code));
        if ($stmt->rowCount() > 0)
        {
            echo true;
        }else{
            echo false;
        }
    }

    /*
    * get id product by code
    * احتاجه بتعديل بطاقة المادة
    */

    function get_id_by_model($model,$barcode){
        if($model == 'mobile'  ||  $model == 'computer' || $model == 'games' ){
            if($model=='mobile'){
                $color = 'color';
                $code = 'code';
            } else{
                $color = 'color_'. $model;
                $code = 'code_'. $model;
            }
            $stmt_code = $this->db->prepare("SELECT `id_color` FROM `$code` WHERE `code`=? ");
            $stmt_code->execute(array($barcode));
            if ($stmt_code->rowCount() > 0) {
                $data = $stmt_code->fetch(PDO::FETCH_ASSOC);
                $stmt_item = $this->db->prepare("SELECT `id_item` FROM `$color` WHERE `id`=? ");
                $stmt_item->execute(array($data['id_color']));
                if ($stmt_item->rowCount() > 0) {
                    $data = $stmt_item->fetch(PDO::FETCH_ASSOC);
                    return $data['id_item'];
                } else {
                   return 0;
                }
            }

        }

        if($model == 'accessories'){
            $color = 'color_'. $model;
            $stmt_item = $this->db->prepare("SELECT `id_item` FROM `$color` WHERE `code`=? ");
            $stmt_item->execute(array($barcode));
            if ($stmt_item->rowCount() > 0) {
                $data = $stmt_item->fetch(PDO::FETCH_ASSOC);
                return $data['id_item'];
            } else {
                return 0;
            }
        }

        if($model == 'savers'){
            $model = 'product_savers';
            $stmt_item = $this->db->prepare("SELECT `id` FROM `$model` WHERE `code`=? ");
            $stmt_item->execute(array($barcode));
            if ($stmt_item->rowCount() > 0) {
                $data = $stmt_item->fetch(PDO::FETCH_ASSOC);
                return $data['id'];
            } else {
                return 0;
            }
        }

    }


    // تم الوصول
    function receive_products($id,$bill_crystal){
        $update_bill_crystall=$this->db->prepare("UPDATE `$this->purchase_order` SET `bill_crystal`= ? WHERE `id`=?");
        $update_bill_crystall->execute(array($bill_crystal,$id));
        if ($update_bill_crystall->rowCount() > 0) {
            $stmt=$this->db->prepare("UPDATE `$this->purchase_order` SET `date_receive`= ? , `iduser_receive` = ? , `state_order` = ? WHERE `id`=?");
            $stmt->execute(array(time(),$this->userid,'receive',$id));
            if ($stmt->rowCount() > 0)
            {
                echo 1;
            }else{
                echo 0;
            }
        }
    }


    // رفع تراكمي
    function add_to_excel($id,$bill_crystal){

        $check_update = array();  //لتحقق من تحديث كل  الباركودات
        $update_bill_crystall=$this->db->prepare("UPDATE `$this->purchase_order` SET `bill_crystal`= ? WHERE `id`=?");
        $update_bill_crystall->execute(array($bill_crystal,$id));
        if ($update_bill_crystall->rowCount() > 0) {
            $stmt = $this->db->prepare("SELECT  `model`, `code` , `quantity` , `price_sale` , `wholesale_price_sale` , `wholesale_price2_sale` FROM `purchase_item` WHERE idpurchase=?  AND `add_to_excel` = 0");
            $stmt->execute(array($id));
            if ($stmt->rowCount() > 0) {
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    if($row['model'] == 'mobile'){
                        $excel = 'excel';
                        $model = 'code';
                    }
                    if($row['model'] == 'computer' || $row['model'] == 'games'){
                        $excel = 'excel_'. $row['model'];
                        $model = 'code_'. $row['model'];
                    }
                    if($row['model'] == 'accessories'){
                        $excel = 'excel_'. $row['model'];
                        $model = 'color_'. $row['model'];
                    }
                    if($row['model'] == 'savers'){
                        $excel = 'excel_'. $row['model'];
                        $model = 'product_savers';
                    }
                    $stmt_ch = $this->db->prepare("SELECT `code` FROM `$excel` WHERE `code`=?");
                    $stmt_ch->execute(array($row['code']));
                    if($stmt_ch->rowCount() > 0){
                        $add_to_excel = $this->db->prepare("UPDATE `$excel` SET  `quantity` = `quantity` + ?  , `price_dollars` = ? , `wholesale_price` = ? , `wholesale_price2` = ? WHERE `code`=?");
                        $add_to_excel->execute(array($row['quantity'],$row['price_sale'],$row['wholesale_price_sale'],$row['wholesale_price2_sale'],$row['code']));
                        if($add_to_excel->rowCount() > 0){
                            $check_update[] = 1;
                              //    يحدث قيمتها  حتى اذا صارت مشكلة ميرجع يحدث الكل يحدث بس الي ماتحدثadd_to_excel
                              $updateItemPur = $this->db->prepare("UPDATE  `$this->purchase_item` SET  `add_to_excel` = 1 WHERE `idpurchase` = ? AND `code` =? ");
                              $updateItemPur->execute(array($id,$row['code']));
                              $checkIfExist= $this->checkCode('location_confirm','code = '.$row['code'].' AND model = '.$row['model'].' ');
                              if($checkIfExist == 1){
                                $updateLocatConf= $this->db->prepare("UPDATE  `location_confirm` SET  `quantity` = `quantity` + ? ,`price_dollars` = ?  WHERE `code` = ? AND `model` =? ");
                                $updateLocatConf->execute(array($row['quantity'],$row['price_sale'],$row['code'],$row['model']));
                              }else{
                                $addLocatConf = $this->db->prepare("INSERT INTO `location_confirm` (`code`, `quantity`, `price_dollars`,`model`,`userid`,`date`) VALUES (?,?,?,?,?,?)");
                                $addLocatConf->execute(array($row['code'],$row['quantity'],$row['price_sale'],$row['model'] ,$this->userid,time()));
                                }
                        }else{
                            $check_update[] = 0;
                        }

                    }else{
                        $stmtChInModel = $this->db->prepare("SELECT `id` FROM `$model` WHERE `code`=?");
                        $stmtChInModel->execute(array($row['code']));
                        if($stmtChInModel->rowCount() > 0){
                            $add_to_excel = $this->db->prepare("INSERT INTO `$excel` (`code`, `quantity`, `price_dollars`, `wholesale_price`, `wholesale_price2`) VALUES (?,?,?,?,?)");
                            $add_to_excel->execute(array($row['code'],$row['quantity'],$row['price_sale'],$row['wholesale_price_sale'],$row['wholesale_price2_sale']));
                            if($add_to_excel->rowCount() > 0){
                                $check_update[] = 1;
                                //    يحدث قيمتها  حتى اذا صارت مشكلة ميرجع يحدث الكل يحدث بس الي ماتحدثadd_to_excel
                                $updateItemPur = $this->db->prepare("UPDATE  `$this->purchase_item` SET  `add_to_excel` = 1 WHERE `idpurchase` = ? AND `code` =? ");
                                $updateItemPur->execute(array($id,$row['code']));

                                 if($checkIfExist == 1){
                                $updateLocatConf= $this->db->prepare("UPDATE  `location_confirm` SET  `quantity` = `quantity` + ? ,`price_dollars` = ?  WHERE `code` = ? AND `model` =? ");
                                $updateLocatConf->execute(array($row['quantity'],$row['price_sale'],$row['code'],$row['model']));
                              }else{
                                $addLocatConf = $this->db->prepare("INSERT INTO `location_confirm` (`code`, `quantity`, `price_dollars`,`model`,`userid`,`date`) VALUES (?,?,?,?,?,?)");
                                $addLocatConf->execute(array($row['code'],$row['quantity'],$row['price_sale'],$row['model'] ,$this->userid,time()));
                                }
                            }else{
                                $check_update[] = 0;
                            }

                        }
                    }
                }


                if(empty(array_search(0,$check_update,true))){
                    $update=$this->db->prepare("UPDATE `$this->purchase_order` SET `date_receive`= ? ,`iduser_receive` = ?  ,`add_to_excel` = ?,`state_order` = ? WHERE `id`=?");
                    $update->execute(array(time(),$this->userid,1,'receive',$id));
                    if ($update->rowCount() > 0)
                    {
                        echo 1;
                    }else{
                        echo 0;
                    }
                }else{
                    $update_bill_crystall=$this->db->prepare("UPDATE `$this->purchase_order` SET `bill_crystal`= ? WHERE `id`=?");
                    $update_bill_crystall->execute(array('',$id));
                }

            }
        }
    }



    // حذف كلفة شحن اضافية او دفعة
    function deletePayment($model,$idpurchase,$id){
        $delete_payment = $this->db->prepare("DELETE FROM `$model` WHERE `idpurchase` = ? AND `id` = ?");
        $delete_payment->execute(array($idpurchase,$id));
        if ($delete_payment->rowCount() > 0)
        {
            echo 1;
        }else{
            echo 0;
        }
    }

    //
    function deleteRow($id){
        $delete = $this->db->prepare("DELETE FROM `excel_purchase` WHERE id =? ");
        $delete->execute(array($id));
        if ($delete->rowCount() > 0)
        {
            echo 1;
        }else{
            echo 0;
        }
    }



    function reminder_purchase(){
        $this->checkPermit('reminder_purchase','purchase');
        $this->adminHeaderController($this->langControl('purchase'));

        require ($this->render($this->folder,'html','reminder_purchase','php'));
        $this->adminFooterController();
    }

    public function processing_reminder_purchase($model='select')
    {
        $date=time();

        $table = "purchase_order";
        $primaryKey = 'purchase_order.id';
        $tableJoin = 'purchase_item';
        $columns = array(
            array( 'db' => 'purchase_order.id', 'dt' => 0 ),
            array( 'db' => 'purchase_order.idsupplier', 'dt' => 1,
                'formatter' => function($id, $row) {
                    $supplier = $this->selectById($id,'supplier');
                    return $supplier;
                }
           ),
           array( 'db' => 'purchase_order.iduser', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                    return  $this->UserInfo( $d) ;
                }
            ),


            array( 'db' => 'purchase_order.state_order', 'dt' =>3,
            'formatter' => function ($state_order) {
                return $this->langControl($state_order);
                // return $this->check_state($id);
                }
             ),

            array( 'db' => 'purchase_order.date_request', 'dt' =>4,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i:s', $d);
                }
            ),
            array( 'db' => 'purchase_order.id', 'dt' =>5,
                'formatter' => function($id, $row) {

                    if ($this->permit('edit_purchase_bill', $this->folder)) {
                        return "<a href=".url."/purchase/edit_purchase_bill/$id  style='text-align: center;font-size: 25px; margin-bottom:60px'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>";

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


        $join = " LEFT JOIN purchase_item ON purchase_order.id = purchase_item.idpurchase ";
        $whereAll = " purchase_order.id !=0  AND (`purchase_order`.`date_reminder` < $date AND `purchase_order`.`date_reminder` !=0 ) ";

        if ($model != 'select') {
            $whereAll .=   " AND  {$tableJoin}.model = '$model' ";
        }

        $whereAll .= " ORDER BY `date_request` DESC ";

        // print_r($whereAll);
        echo json_encode(
            SSP::complex_join( $_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll,null,null,1)
        );
    }
}

