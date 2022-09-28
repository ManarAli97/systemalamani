<?php

class purchase extends Controller {
    function __construct()
    {
        parent::__construct();
        $this->purchase_order = 'purchase_order'; // purchase table name (تفاصيل المشتريات)
        $this->purchase = 'purchase_item'; // purchase_item table name (مواد الشراء)
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
        */
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->supplier}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `iduser` int(11) NOT NULL,
          `name` varchar(255) NOT NULL,
          `date` bigint(20) NOT NULL,
          PRIMARY KEY (`id`),
          FOREIGN KEY (`iduser`) REFERENCES user(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        /*
        * Create Table source request
        */
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->source_request}` (
            `id` int(11)  NOT NULL AUTO_INCREMENT ,
            `name` varchar(255) NOT NULL,
            `iduser` int(11) NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        /*
        * Create Table type shipping
        *
        */
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->type_shipping}` (
            `id` int(11)  NOT NULL AUTO_INCREMENT ,
            `type` varchar(255) NOT NULL,
            `iduser` int(11) NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        /*
        * Create Table company_shipping
        *
        */
        $this->db->query("CREATE TABLE IF NOT EXISTS `company_shipping` (
            `id` int(11)  NOT NULL AUTO_INCREMENT ,
            `name` varchar(255) NOT NULL,
            `iduser` int(11) NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        /*
        * Create Table current
        */
        $this->db->query("CREATE TABLE IF NOT EXISTS `currency` (
            `id` int(11)  NOT NULL AUTO_INCREMENT ,
            `name` varchar(255) NOT NULL,
            `iduser` int(11) NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`iduser`) REFERENCES user(id)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        /*
        * Create Table purchase
        * @id_source_request (id مصدر الطلب)
        * @date_shipping (تاريخ الشحن)
        * @iduser_date_shipping ( الشخص الذي اضاف تاريخ الشحن)
        * @old_data (البيانات القديمة بعد التعديل)
        * date_request (تاريخ الطلب)
        * @date_eq (تاريخ المتوقع للتجهيز)
        * @date_send (تاريخ المتوقع للارسال)
        * @id_user_add_subtotal (المستخدم الذي أضاف المبلغ)
        * @data_recive (تاريخ الاستلام)
        * @iduser_recive (المستخدم الذي أستلم البضاعة)
        * @total (المبلغ الكلي)
        */
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->purchase_order}` (
            `id` int(11)  NOT NULL AUTO_INCREMENT,
            `idsupplier` int(11) NOT NULL,
            `idsource_request` int(11) NOT NULL,
            `idtype_shipping` int(11) NOT NULL,
            `idcompany_shipping` int(11) NOT NULL,
            `iduser` int(11) NOT NULL,
            `idcurrency`  int(11) NOT NULL,
            `bill_crystal` varchar(255) NOT NULL,
            `date_shipping` date NOT NULL,
            `iduser_date_shipping` int(11) NOT NULL,
            `date_ex_shipping` date NOT NULL,
            `iduser_date_exshipping` int(11) NOT NULL,
            `date_eq` date NOT NULL,
            `iduser_date_eq` int(11) NOT NULL,
            `date_send` date NOT NULL,
            `iduser_date_send` int(11) NOT NULL,
            `data_arrival` date NOT NULL,
            `iduser_data_arrival` int(11) NOT NULL,
            `data_ex_arrival` date NOT NULL,
            `iduser_data_ex_arrival` int(11) NOT NULL,
            `data_recive` date NOT NULL,
            `iduser_recive` int(11) NOT NULL,
            `subtotal` float(11) NOT NULL,
            `iduser_add_subtotal` int(11) NOT NULL,
            `total` float(11) NOT NULL,
            `old_data` varchar(255) NOT NULL,
            `relid` int(11) NOT NULL,
            `date_request` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`idsupplier`) REFERENCES supplier(id),
            FOREIGN KEY (`idsource_request`) REFERENCES source_request(id),
            FOREIGN KEY (`idtype_shipping`) REFERENCES type_shipping(id),
            FOREIGN KEY (`idcompany_shipping`) REFERENCES company_shipping(id),
            FOREIGN KEY (`iduser`) REFERENCES user(id),
            FOREIGN KEY (`idcurrency`) REFERENCES currency(id),
            FOREIGN KEY (`iduser_date_shipping`) REFERENCES user(id),
            FOREIGN KEY (`iduser_date_exshipping`) REFERENCES user(id),
            FOREIGN KEY (`iduser_date_eq`) REFERENCES user(id),
            FOREIGN KEY (`iduser_date_send`) REFERENCES user(id),
            FOREIGN KEY (`iduser_data_arrival`) REFERENCES user(id),
            FOREIGN KEY (`iduser_data_ex_arrival`) REFERENCES user(id),
            FOREIGN KEY (`iduser_recive`) REFERENCES user(id),
            FOREIGN KEY (`iduser_add_subtotal`) REFERENCES user(id)
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
            `id` int(11)  NOT NULL AUTO_INCREMENT,
            `idpurchase` int(11) NOT NULL,
            `title` varchar(255) NOT NULL,
            `code` varchar(255) NOT NULL,
            `image` varchar(255) NOT NULL,
            `model` varchar(255) NOT NULL,
            `quantity` int(11) NOT NULL,
            `price_purchase` int(11) NOT NULL,
            `wholesale_price_purchase` int(11) NOT NULL,
            `wholesale_price2_purchase` int(11) NOT NULL,
            `price_sale` int(11) NOT NULL,
            `wholesale_price_sale` int(11) NOT NULL,
            `wholesale_price2_sale` int(11) NOT NULL,
            `type` varchar(255) NOT NULL,
            `cover_material` varchar(255) NOT NULL,
            `feature_cover` varchar(255) NOT NULL,
            `rate` int(11) NOT NULL,
            `note` varchar(255) NOT NULL,
            `id_user` int(11) NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`id_user`) REFERENCES user(id),
            FOREIGN KEY (`idpurchase`) REFERENCES purchase_order(id)
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
        $stmt = $this->db->prepare("INSERT INTO `$this->supplier` (`name`, `iduser`, `date`) VALUES (?,?,?)");
        $stmt->execute(array($nameSupplier, $this->userid, time()));
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
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns)
        );
    }


    // اضافة  فاتورة شراء
    public function add_purchase_bill()
    {
        $this->checkPermit('add_purchase_bill','purchase');
        $this->adminHeaderController($this->langControl('purchase'));
        // $data = json_decode($_GET['jsonData'], true);

        // عرض اسماء الموردين
        $stmt_supplier = $this->stmtSelect("$this->supplier");
        $nameSupplier=array();
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

                $form->post('date_eq')
                ->val('strip_tags');

                $form->post('date_send')
                ->val('strip_tags');

                $form->post('date_ex_shipping')
                ->val('strip_tags');

                $form->post('date_shipping')
                ->val('strip_tags');

                $form->post('data_ex_arrival')
                    ->val('strip_tags');

                $form->post('data_arrival')
                    ->val('strip_tags');

                $form->post('currency')
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

                $form->post('img')
                    ->val('is_array')
                    ->val('strip_tags');

                // $form->post('type')
                //     ->val('is_array')
                //     ->val('strip_tags');

                // $form->post('rate')
                //     ->val('is_array')
                //     ->val('strip_tags');

                $form->post('purchase_item')
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


                $form->submit();

                $data = $form->fetch();

                if (empty($this->error_form)) {

                    $title = json_decode($data['title'], true);
                    $category = json_decode($data['category'], true);
                    $codes = json_decode($data['code'], true);
                    $quantity = json_decode($data['quantity'], true);
                    // $type = json_decode($data['type'], true);
                    $img = json_decode($data['img'], true);
                    // $rate = json_decode($data['rate'], true);
                    $purchase_item = json_decode($data['purchase_item'], true);
                    $sale_price = json_decode($data['sale_price'], true);
                    $wholesale_price_sale = json_decode($data['wholesale_price_sale'], true);
                    $wholesale_price2_sale = json_decode($data['wholesale_price2_sale'], true);
                    $note = json_decode($data['note'], true);

                    // add number days to date
                    $dateEq=Date('y:m:d', strtotime('+'.$data['date_eq'].' days'));
                    $dateExShipping=Date('y:m:d', strtotime('+'.$data['date_ex_shipping'].' days'));
                    $dataExArrival=Date('y:m:d', strtotime('+'.$data['data_ex_arrival'].' days'));
                    $stmt = $this->db->prepare("INSERT INTO `{$this->purchase_order}` (`idsupplier`,`idsource_request`,`idtype_shipping`,`idcompany_shipping`,`iduser`,`idcurrency`,`date_shipping`,`iduser_date_shipping`,`date_ex_shipping`,`iduser_date_exshipping`,`date_eq`,`iduser_date_eq`,`date_send`,`iduser_date_send`,`data_arrival`,`iduser_data_arrival`,`data_ex_arrival`,`iduser_data_ex_arrival`,`subtotal`,`iduser_add_subtotal`,`total`,`old_data`,`relid`,`date_request`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $stmt->execute(array($data['name_supplier'],$data['source_request'],$data['type_shipping'],$data['company_shipping'],$this->userid,$data['currency'],$data['date_shipping'],$this->userid,$dateExShipping,$this->userid, $dateEq,$this->userid, $data['date_send'],$this->userid,$data['data_arrival'],$this->userid,$dataExArrival,$this->userid,33,$this->userid, 200.0,'',0,$data['date_request']));

                    $lastId=$this->db->lastInsertId();

                    foreach ($codes as $key => $code) {
                        $stmt_cd = $this->db->prepare("INSERT INTO `purchase_item` (`idpurchase`,`title`,`code`,`quantity`,`price_purchase`,`price_sale`,`wholesale_price_sale`,`wholesale_price2_sale`,`note`,`id_user`,`model`,`date`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?)");
                        $stmt_cd->execute(array($lastId, $title[$key],$code,$quantity[$key],$purchase_item[$key],$sale_price[$key],$wholesale_price_sale[$key],$wholesale_price2_sale[$key],$note[$key],$this->userid,$category[$key],time()));

                    }


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
        if($title != ''){
            if($model == 'mobile' || $model == 'computer' || $model == 'games'){
                $items = $this->selectItemByName($model,$title);
                if(!$items){
                    echo 1;
                }else{
                    echo json_encode($items);
                }
            }
            if($model == 'savers'){
                $items = $this->selectSaversByName($title);
                if(!$items){
                    echo 1;
                }else{
                    echo json_encode($items);
                }
            }
            if($model == 'accessories'){
                $items = $this->selectAccByName($title);
                if(!$items){
                    echo 1;
                }else{
                    echo json_encode($items);
                }
            }
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
        } else{
            $color = 'color_'. $model;
            $code = 'code_'. $model;
        }
        $item = array();
        $stmt_code = $this->db->prepare("SELECT `id`,`code`,`id_color` FROM `$code` WHERE `is_delete` = 0 AND `code`=? ");
        $stmt_code->execute(array($barcode));
        if($stmt_code->rowCount() > 0){
            while ($row = $stmt_code->fetch(PDO::FETCH_ASSOC))
            {
                $id_color = $row['id_color'];
                $row['code'] = $row['code'];
                $stmt_color = $this->db->prepare("SELECT `img` , `id_item` FROM `$color` WHERE `is_delete` = 0 AND  `id`=?  limit 1");
                $stmt_color->execute(array($id_color));
                while ($row_color = $stmt_color->fetch(PDO::FETCH_ASSOC))
                {
                    $row['img'] = $this->save_file . $row_color['img'];
                    $id_item = $row_color['id_item'];
                }
                $stmt_item = $this->db->prepare("SELECT `title` FROM `$model` WHERE `is_delete` = 0 AND `id`=?   limit 1");
                $stmt_item->execute(array($id_item));
                while ($row_item = $stmt_item->fetch(PDO::FETCH_ASSOC))
                {
                    $row['title'] = $row_item['title'];
                }
                // $row['title']=$row['title'];
                // $row['category']=$category;
                // $row['title']=$row['title'];
                // $row['title']=$row['title'];
                // $row['title']=$row['title'];
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
        $stmt_items = $this->db->prepare("SELECT  `code`,`title` , `img`,`cover_material` ,`type_cover`, `feature_cover`,`note` FROM `$model` WHERE `is_delete` = 0 AND `code`=? ");
        $stmt_items->execute(array($barcode));
        if($stmt_items->rowCount() > 0){
            while ($row = $stmt_items->fetch(PDO::FETCH_ASSOC))
            {
                // echo $row['code'];
                $stmt_cover_material =$this->db->prepare("SELECT `cover_material` FROM `cover_material` WHERE  `number`=? limit 1");
                $stmt_cover_material->execute(array($row['cover_material']));
                if($stmt_cover_material->rowCount() > 0){
                    $row_cover_material = $stmt_cover_material->fetch(PDO::FETCH_ASSOC);
                    $cover_material = $row_cover_material['cover_material'];
                }else{
                    $cover_material = '';
                }


                $stmt_feature_cover =$this->db->prepare("SELECT `feature_cover` FROM `feature_cover` WHERE  `number`=? limit 1");
                $stmt_feature_cover->execute(array($row['feature_cover']));
                if($stmt_feature_cover->rowCount() > 0){
                    $row_feature_cover = $stmt_feature_cover->fetch(PDO::FETCH_ASSOC);
                    $feature_cover = $row_feature_cover['feature_cover'];
                }else{
                    $feature_cover = '';
                }
                $stmt_type_cover =$this->db->prepare("SELECT `type_cover` FROM `type_cover` WHERE  `number`=?  limit 1");
                $stmt_type_cover->execute(array($row['type_cover']));
                if($stmt_type_cover->rowCount() > 0){
                    $row_type_cover = $stmt_type_cover->fetch(PDO::FETCH_ASSOC);
                    $type_cover = $row_type_cover['type_cover'];
                }else{
                    $type_cover = '';
                }


                $row['code'] = $row['code'];
                $row['title'] =  $row['title'];
                $row['rate'] = $row['note'];
                $row['img'] = $this->save_file.$row['img'];
                $row['type'] = $cover_material .' '. $feature_cover .' '. $type_cover;

                // $row['title']=$row['title'];
                // $row['category']=$category;
                // $row['title']=$row['title'];
                // $row['title']=$row['title'];
                // $row['title']=$row['title'];

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

        $stmt_color = $this->db->prepare("SELECT `img` ,`id_item` FROM `$color` WHERE `is_delete` = 0 AND `code`=? ");
        $stmt_color->execute(array($barcode));
        if($stmt_color->rowCount() > 0){
            while ($row = $stmt_color->fetch(PDO::FETCH_ASSOC))
            {
                $id_item = $row['id_item'];
                $row['code'] = $barcode;
                $row['img'] = $this->save_file . $row['img'];
                $stmt_item = $this->db->prepare("SELECT `title`  FROM `$model` WHERE  `is_delete` = 0 AND  `id`=?  limit 1");
                $stmt_item->execute(array($id_item));
                while ($row_item = $stmt_item->fetch(PDO::FETCH_ASSOC))
                {
                    $row['title'] = $row_item['title'];
                }
                // $stmt_item = $this->db->prepare("SELECT `title` FROM `$model` WHERE `id`=?  limit 1");
                // $stmt_item->execute(array($id_item));

                // $row['title']=$row['title'];
                // $row['category']=$category;
                // $row['title']=$row['title'];
                // $row['title']=$row['title'];
                // $row['title']=$row['title'];
                $row['rate'] = '';
                $row['type'] = '';


                $item[]=$row;
            }
        }
        return $item;
    }

    public function selectName()
    {

        $data = json_decode($_GET['jsonData'], true);
        $model = $data['category'];
        $title = $data['title'];
        $item = array();
        if($model == 'savers'){
            $model = 'product_savers';
        }
        $stmt_item = $this->db->prepare("SELECT `title` , `color`, `code` FROM `$model` WHERE `is_delete` = 0 AND `title` like '%$title%'");
        $stmt_item->execute();
        if($stmt_item->rowCount() > 0){
        while ($row_item = $stmt_item->fetch(PDO::FETCH_ASSOC)){
                $row_item['title'] = $row_item['title'] .' (باركود' . $row_item['code'] . ')';
                $item[]=$row_item;
            }
        }
        echo json_encode($item);
    }


    public function selectItemByName($model,$title)
    {
        if($model=='mobile'){
            $color = 'color';
            $code = 'code';
        } else{
            $color = 'color_'. $model;
            $code = 'code_'. $model;
        }
        $item1 = array();
        $codes = '';
        $stmt_item = $this->db->prepare("SELECT  `id`  FROM `$model` WHERE `is_delete` = 0 AND `title` like '$title' limit 1");
        $stmt_item->execute();
        if($stmt_item->rowCount() > 0){
            while ($row = $stmt_item->fetch(PDO::FETCH_ASSOC)){
                $id_item = $row['id'];
                $row['title'] = $title;

                $stmt_color = $this->db->prepare("SELECT `id`,`img`  FROM `$color` WHERE `is_delete` = 0 AND  `id_item`=? ");
                $stmt_color->execute(array($id_item));
                while ($row_color = $stmt_color->fetch(PDO::FETCH_ASSOC))
                {
                    $row['img'] = $this->save_file . $row_color['img'];
                    $id_color = $row_color['id'];

                    $stmt_code = $this->db->prepare("SELECT  `code` FROM `$code` WHERE `is_delete` = 0 AND `id_color`=? ");
                    $stmt_code->execute(array($id_color));
                    if($stmt_code->rowCount() > 0){
                        while ($row_code= $stmt_code->fetch(PDO::FETCH_ASSOC))
                        {
                            foreach ($row_code as $key => $value) {
                                $codes .= $value . ',';
                                // $row['code'][$key] = $value;
                                // $row['code'] = $row[$key];

                            }
                            // $row['code'] = $row_code['code'];
                        }
                    }
                }
                $row['code'] =substr($codes,0,-1);
                $row['rate'] = '';
                $row['type'] = '';
                $item1[]=$row;
            }

        }
        return $item1;
    }

    // get data by code from tables(product_savers)
    public function selectSaversByName($title){
        $item = array();
        $model = 'product_savers';
        $stmt_items = $this->db->prepare("SELECT  `code`, `img`,`cover_material` ,`type_cover`, `feature_cover`,`note` FROM `$model` WHERE `is_delete` = 0 AND `title` LIKE '%$title%'");
        $stmt_items->execute();
        if($stmt_items->rowCount() > 0){
            while ($row = $stmt_items->fetch(PDO::FETCH_ASSOC))
            {
                // echo $row['code'];
                $stmt_cover_material =$this->db->prepare("SELECT `cover_material` FROM `cover_material` WHERE  `number`=? ");
                $stmt_cover_material->execute(array($row['cover_material']));
                if($stmt_cover_material->rowCount() > 0){
                    $row_cover_material = $stmt_cover_material->fetch(PDO::FETCH_ASSOC);
                    $cover_material = $row_cover_material['cover_material'];
                }else{
                    $cover_material = '';
                }


                $stmt_feature_cover =$this->db->prepare("SELECT `feature_cover` FROM `feature_cover` WHERE  `number`=? ");
                $stmt_feature_cover->execute(array($row['feature_cover']));
                if($stmt_feature_cover->rowCount() > 0){
                    $row_feature_cover = $stmt_feature_cover->fetch(PDO::FETCH_ASSOC);
                    $feature_cover = $row_feature_cover['feature_cover'];
                }else{
                    $feature_cover = '';
                }
                $stmt_type_cover =$this->db->prepare("SELECT `type_cover` FROM `type_cover` WHERE  `number`=?  ");
                $stmt_type_cover->execute(array($row['type_cover']));
                if($stmt_type_cover->rowCount() > 0){
                    $row_type_cover = $stmt_type_cover->fetch(PDO::FETCH_ASSOC);
                    $type_cover = $row_type_cover['type_cover'];
                }else{
                    $type_cover = '';
                }


                $row['code'] = $row['code'];
                // $row['title'] =  $row['title'];
                $row['rate'] = $row['note'];
                $row['img'] = $this->save_file.$row['img'];
                $row['type'] = $cover_material .'<br>'. $feature_cover .'<br>'. $type_cover;

                // $row['title']=$row['title'];
                // $row['category']=$category;
                // $row['title']=$row['title'];
                // $row['title']=$row['title'];
                // $row['title']=$row['title'];

                $item[]=$row;
            }
        }
        return $item;
    }

    // get data by code from tables(accessories)
    public function selectAccByName($title){
        $item = array();
        $model = 'accessories';
        $color = 'color_accessories';

        $stmt_item = $this->db->prepare("SELECT `id`  FROM `$model` WHERE  `is_delete` = 0 AND  `title` like '$title'  limit 1");
        $stmt_item->execute();
        if($stmt_item->rowCount() > 0){
            while ($row = $stmt_item->fetch(PDO::FETCH_ASSOC))
            {
                // $row['title'] = $row['title'];
                $id_item = $row['id'];
                $stmt_color = $this->db->prepare("SELECT `img` , `code`  FROM `$color` WHERE `is_delete` = 0 AND `id_item`=? ");
                $stmt_color->execute(array($id_item));
                while ($row_color = $stmt_color->fetch(PDO::FETCH_ASSOC))
                {
                    // $id_item = $row['id_item'];
                    $row['code'] =  $row_color['code'];
                    $row['img'] = $this->save_file . $row_color['img'];
                }
                $row['rate'] = '';
                $row['type'] = '';
                $item[]=$row;
            }
        }
        return $item;
    }



}




















// ///////////////////



// <br>

// <div class="row">
//     <div class="col">
//         <span></span>
//         <nav aria-label="breadcrumb">
//             <ol class="breadcrumb">
//                 <li class="breadcrumb-item active" aria-current="page" ><?php  echo $this->langControl('purchase_bill') ?> </li>
//             </ol>
//         </nav>
//     </div>

// </div>

// <div class="content">
//     <form  action="<?php echo url.'/'.$this->folder ?>/add_purchase_bill/" method="post" enctype="multipart/form-data">
//         <div class='part1'>

//             <div class="form-row row mb-4">
//                 <div class="col-lg-3 col-md-2 mr-4">
//                     <label class="mr-sm-2" for="select_name_supplier">اسم المورد</label>
//                     <select class="form-control dropdown_filter selectpicker" data-live-search="true" name="name_supplier" id="select_name_supplier" required>
//                         <?php foreach ($nameSupplier as $key => $name) {   ?>
//                             <option    value="<?php  echo $name['id']?>"><?php  echo $name['name']?></option>
//                         <?php  } ?>
//                     </select>
//                 </div>

//                 <div class="col-lg-2 col-md-2 mr-4">
//                     <label class="mr-sm-2" for="select_source_request"> مصدر الطلب</label>
//                     <select class=" form-control dropdown_filter selectpicker" data-live-search="true" name="source_request" id="select_source_request" required>
//                         <?php foreach ($sourceRequest as $key => $name) {   ?>
//                             <option    value="<?php  echo $name['id']?>"><?php  echo $name['name']?></option>
//                         <?php  } ?>
//                     </select>
//                 </div>

//                 <div class="col-lg-3 col-md-2 mr-4">
//                     <label class="mr-sm-2" for="select_company_shipping">اسم شركة الشحن</label>
//                     <select class="form-control dropdown_filter selectpicker" data-live-search="true"  name="company_shipping" id="select_company_shipping" required>
//                         <?php foreach ($companyShipping as $key => $name) {   ?>
//                             <option    value="<?php  echo $name['id']?>"><?php  echo $name['name']?></option>
//                         <?php  } ?>
//                     </select>
//                 </div>

//                 <div class="col-lg-2 col-md-2 mr-4">
//                     <label class="mr-sm-2" for="select_type_shipping">نوع  الشحن</label>
//                     <select class="form-control dropdown_filter selectpicker" data-live-search="true" name="type_shipping" id="select_type_shipping"  required>
//                         <?php foreach ($typeShipping as $key => $name) {   ?>
//                             <option    value="<?php  echo $name['id']?>"><?php  echo $name['type']?></option>
//                         <?php  } ?>
//                     </select>
//                 </div>
//             </div>
//         </div>
//         <div class='part1'>
//             <div class="form-row row mb-4">
//                 <div class="col-lg-3 col-md-2 mr-4  mb-4">
//                     <label class="mr-sm-2" for="date_request">تاريخ الطلب </label>
//                     <input type="date" name="date_request"  class="form-control" id="date_request" >
//                 </div>

//                 <div class="col-lg-2 col-md-2 mr-4">
//                     <label class="mr-sm-2" for="date_eq"> المدة المتوقعة لتجهيز </label>
//                     <input type="number" name="date_eq"  class="form-control" id="date_eq" min='0'>
//                 </div>
//                 <div class="col-lg-3 col-md-2 mr-4">
//                     <label class="mr-sm-2" for="date_send">   تاريخ الارسال</label>
//                     <input type="date" name="date_send"  class="form-control" id="date_send" >
//                 </div>
//                 <div class="col-lg-2 col-md-2 mr-4">
//                     <label class="mr-sm-2" for="date_ex_shipping"> المدة المتوقعة لشحن </label>
//                     <input type="number" name="date_ex_shipping"  class="form-control" id="date_ex_shipping" min='0' >
//                 </div>
//                 <div class="col-lg-3 col-md-2 mr-4">
//                     <label class="mr-sm-2" for="date_shipping"> تاريخ  الشحن   </label>
//                     <input type="date" name="date_shipping"  class="form-control" id="date_shipping">
//                 </div>
//                 <div class="col-lg-2 col-md-2 mr-4">
//                     <label class="mr-sm-2" for="data_ex_arrival"> المدة المتوقعة للوصول </label>
//                     <input type="number" name="data_ex_arrival"  class="form-control" id="data_ex_arrival" min='0' >
//                 </div>
//                 <div class="col-lg-3 col-md-2 mr-4">
//                         <label class="mr-sm-2" for="data_arrival"> تاريخ وصول البضاعة   </label>
//                         <input type="date" name="data_arrival" class="form-control" id="data_arrival">
//                 </div>
//                 <div class="col-lg-2 col-md-2 mr-4">
//                 <label class="mr-sm-2" for="currency">عملة الشراء  </label>
//                     <select class="form-control dropdown_filter selectpicker" data-live-search="true" name="currency" id="currency"  required>
//                         <?php foreach ($currency as $key => $name) {   ?>
//                             <option    value="<?php  echo $name['id']?>"><?php  echo $name['name']?></option>
//                         <?php  } ?>
//                     </select>
//                 </div>
//             </div>
//         </div>


//         <table id="example"  class="table table-striped  d-table table-bordered row-border order-column"  width="100%">
//             <thead>
//                 <tr>
//                     <th></th>
//                     <th> اسم المادة</th>
//                     <th>القسم</th>
//                     <th> رمز المادة</th>
//                     <th> الكمية </th>
//                     <th>صورة المادة</th>
//                     <th>التصنيف </th>
//                     <th>نسبة  جمالية   </th>
//                     <th>سعر الشراء</th>
//                     <th> سعر البيع $</th>
//                     <th> سعر البيع جملة $</th>
//                     <th> سعر البيع جملة الجملة $</th>
//                     <th>ملاحظة</th>
//                 </tr>
//             </thead>
//             <tbody>
//                 <tr id='0'>
//                     <td> <button type="button" class="btn add_new_sub_row">  <i class="fa fa-plus"></i> </button></td>
//                     <td><input name="title[0]"  id="title_0"  list='list1_0'><datalist id="list1_0"> </datalist></td>
//                     <td><select name="category[0]" class=" dropdown_filter selectpicker" data-live-search="true"  id="category_0" required >
//                             <?php foreach ($this->category_website as $key => $value) {   ?>
//                                 <option value="<?php  echo $key?>"><?php  echo $value?></option>
//                             <?php  } ?>
//                         </select>
//                     </td>
//                     <td> <input type="text"  name="code[0]" class="form-control-md" id="code_0" ></td>
//                     <td> <input type="text" name="quantity[0]" class="form-control" id="quantity_0" ></td>
//                     <td><img src="" name="img[0]"  alt="لا توجد صورة" srcset="" id='img_0' width='150px' height='150px' ></td>
//                     <td name="type[0]" id="type_0" > </td>
//                     <td name="rate[0]"  id="rate_0"></td>
//                     <td> <input type="text" name="purchase_item[0]"  class="form-control" id="purchase_item_0" ></td>
//                     <td> <input type="text" name="sale_price[0]" class="form-control" id="sale_price_0" ></td>
//                     <td> <input type="text" name="wholesale_price_sale[0]" class="form-control" id="wholesale_price_sale_0" ></td>
//                     <td> <input type="text" name="wholesale_price2_sale[0]" class="form-control" id="wholesale_price2_sale_0" ></td>
//                     <td> <textarea  name="note[0]" class="form-control" id="note_0" ></textarea></td>
//                 </tr>
//             </tbody>
//         </table>

//           <!-- <button type="button"  type="submit" name="submit" id="save_bill" class="btn btn-primary">حفظ</button> -->
//           <input class="btn btn-primary" id="save_bill" value="<?php  echo $this->langControl('save') ?>"  type="submit" name="submit">
//     </form>
// </div>


// <script>
//     $(document).ready(function() {
//         $('#example').DataTable( {
//             // scrollX: true,
//             // responsive: true,
//             info:false,
//             "fnDrawCallback": function() {
//                 jQuery('.toggle-demo').bootstrapToggle();

//             },
//             "fnCreatedRow": function( nRow, aData, iDataIndex ) {
//                 $(nRow).attr('id','row_'+ aData[7]);

//             },
//             'columnDefs': [{
//                 "targets": [0],
//                 "orderable": false
//             }],
//             "order": [[ 0, 'desc'] ],
//             aLengthMenu: [ 50,100, 200, 300,-1],
//             oLanguage: {
//                 sLoadingRecords: "تحميل ...",
//                 sProcessing: " معالجة ...",
//                 sLengthMenu: "عرض _MENU_ ",
//                 sSearch: " أبحث  ",
//                 oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
//                 sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
//                 sSearchPlaceholder: "البحث"


//             },       <?php  if ($this->permit('export_excel',$this->folder)) { ?>
//             dom: 'Bfrtip',

//             buttons: [
//                 'excel'  ,
//                 'pageLength'
//             ],
//             <?php  }  ?>
//             bFilter: true, bInfo: true,
//         });

//          // اضافة صف جديد
//          let countLine = 0;
//         $(".add_new_sub_row").click(function () {
//             var table = $('#example').DataTable();
//             var nameGategory = $("#category_"+countLine).val();
//             countLine++;
//             newRow = `<tr id='${countLine}' class="remove_sub_row_${countLine}"><td>  <button type="button" class="btn remove_sub_row" onclick="remove_sub_row(${countLine})"> <i class="fa  fa-minus"></i> </button></td>
//             <td><input name="title[${countLine}]"  id="title_${countLine}" list='list1_${countLine}'><datalist id="list1_${countLine}"></datalist></td>
//                 <td><select  name ="category[${countLine}]" class="dropdown bootstrap-select form-control dropdown_filter" data-live-search="true" id="category_${countLine}" required >
//                         <?php foreach ($this->category_website as $key => $value) {   ?>
//                             <option value="<?php  echo $key?>"><?php  echo $value?></option>
//                         <?php  } ?>
//                     </select>
//                 </td>
//                 <td> <input type="text" name ="code[${countLine}]"  id="code_${countLine}" ></td>
//                 <td> <input type="text" name ="quantity[${countLine}]"  class="form-control-md" id="quantity_${countLine}" ></td>
//                 <td><img src=""  name ="img[${countLine}]" alt="لاتوجد صورة" srcset="" id='img_${countLine}' width='150px' height='150px' ></td>
//                 <td name ="type[${countLine}]" id="type_${countLine}"> </td>
//                 <td name ="rate[${countLine}]" id="rate_${countLine}"></td>
//                 <td> <input type="text" name ="purchase_item[${countLine}]" class="form-control" id="purchase_item_${countLine}" ></td>
//                 <td> <input type="text" name ="sale_price[${countLine}]"  class="form-control" id="sale_price_${countLine}" ></td>
//                 <td> <input type="text" name ="wholesale_price_sale[${countLine}]" class="form-control" id="wholesale_price_sale_${countLine}" ></td>
//                 <td> <input type="text" name ="wholesale_price2_sale[${countLine}]" class="form-control" id="wholesale_price2_sale_${countLine}" ></td>
//                 <td> <textarea name ="note[${countLine}]" class="form-control" id="note_${countLine}" ></textarea></td>
//             </tr>`;
//             table.row.add($(newRow)).draw();
//             $("#category_"+countLine).val(nameGategory).change();
//             $('.remove_sub_row_'+countLine).find('tr').attr('id',countLine);
//             $('.dropdown_filter').selectpicker();
//         });

//         // اذا تاريخ المتوقع للتجهيز 0 لا يسمح له بادخال باقي التواريخ
//         $( "#date_eq" ).on('input',function() {
//             var numberOfDay= $('#date_eq').val();
//             if(numberOfDay == 0)
//             {
//                 $("#date_send").attr("disabled", true);
//                 $("#date_ex_shipping").attr("disabled", true);
//                 $("#date_shipping").attr("disabled", true);
//                 $("#data_ex_arrival").attr("disabled", true);
//                 $("#data_arrival").attr("disabled", true);
//             }else{
//                 $("#date_send").attr("disabled", false);
//                 $("#date_ex_shipping").attr("disabled", false);
//                 $("#date_shipping").attr("disabled", false);
//                 $("#data_ex_arrival").attr("disabled", false);
//                 $("#data_arrival").attr("disabled", false);
//             }
//         });

//         //
//         var table = $('#example').DataTable();
//         $('#example').on( 'click', 'tr', function () {
//             var id = table.row(this).id();
//             var category = $('#category_'+id).val();
//             var code= $('#code_'+id).val();
//             var title = $('#title_'+id).val();

//                 var  dataCode={'category':category,'code':code ,'title':title};
//                 if(code!='' && title ==''){
//                     $.get( "<?php echo url .'/'.$this->folder ?>/processing_show_items/",{ jsonData: JSON.stringify(dataCode)}, function(data) {
//                         if(data != 1){
//                            console.log(data);
//                             var value = JSON.parse(data);
//                             $('#title_'+id).val(value[0].title);
//                             $('#img_'+id).attr('src',value[0].img);
//                             $('#type_'+id).html(value[0].type);
//                             $('#rate_'+id).html(value[0].rate);
//                             $('#quantity_'+id).val(value[0].quantity);
//                             // $('#purchase_order_0').val(data.purchase_order);
//                             $('#sale_price_'+id).val(value[0].price_dollars);
//                             $('#wholesale_price_sale_'+id).val(value[0].wholesale_price);
//                             $('#wholesale_price2_sale_'+id).val(value[0].wholesale_price2);
//                             // $('#note_0').val(data.note);
//                         }else{
//                             alert(' الباركود غير موجود اضف بطاقة مادة اولا');
//                             $('#code_'+id).val('');
//                             $('#title_'+id).val('');

//                             $('#img_'+id).val('');
//                             $('#img_'+id).attr('src','');
//                             $('#type_'+id).html('');
//                             $('#rate_'+id).html('');
//                         }
//                     });
//                 }

//             // end of keyup
//             $('#title_'+id ).on('input',function() {
//                 category = $('#category_'+id).val();
//                 title = $('#title_'+id).val();
//                 code = $('#code_'+id).val();
//                 var dataTitle={'category':category,'title':title};
//                 $.get( "<?php echo url .'/'.$this->folder ?>/selectName/",{ jsonData: JSON.stringify(dataTitle)}, function(titleItem) {
//                     // console.log(titleItem);
//                     var dat = JSON.parse(titleItem);

//                     allTitle = '';
//                     for(var i=0;i<dat.length;i++){
//                         // console.log(dat[i].code);
//                         allTitle += '<option value="'+dat[i].title+'" id="'+dat[i].code+'" />';
//                     }
//                     $('#list1_'+id).html(allTitle);

//                 });

//             });
//             // end select item by name

//             $('#title_'+id).keyup(function() {
//                 title = $('#title_'+id).val();
//                 code =  title.substring(title.lastIndexOf(':') + 1, title.lastIndexOf(')'));
//                 var  dataName={'category':category,'code':code,'title':title};

//                 $.get("<?php echo url .'/'.$this->folder ?>/processing_show_items/",{ jsonData: JSON.stringify(dataName)}, function(data) {
//                     console.log(data);
//                     if(data.length != 0){
//                         var value = JSON.parse(data);
//                         $('#code_'+id).val(value[0].code);
//                         $('#img_'+id).attr('src',value[0].img);
//                         $('#type_'+id).html(value[0].type);
//                         $('#rate_'+id).html(value[0].rate);
//                         $('#quantity_'+id).val(value[0].quantity);
//                         // $('#purchase_order_0').val(data.purchase_order);
//                          $('#sale_price_'+id).val(value[0].price_dollars);
//                         $('#wholesale_price_sale_'+id).val(value[0].wholesale_price);
//                          $('#wholesale_price2_sale_'+id).val(value[0].wholesale_price2);
//                         // $('#note_0').val(data.note);
//                         // var codeString = value[0].code;
//                         // var codeArray = codeString.split(",");
//                         // // console.log(codeArray);
//                         // allCodes = '';
//                         // for(var i=0;i<codeArray.length;i++){
//                         //     allCodes += '<option value="'+codeArray[i]+'" id=list_code_"'+{id}+'" />';
//                         // }
//                         // $('#list_code_'+id).html(allCodes);
//                       }
//                 });

//             });


//             // $('#list_code_'+id).on('change',function() {
//             //     title = $('#title_'+id).val();
//             //     code = $('#code_'+id).val();
//             //     var  dataName={'category':category,'code':code,'title':title};

//             //     console.log(code);
//             //     $('#img_'+id).attr('src','');
//             //     $('#type_'+id).html('');
//             //     $('#rate_'+id).html('');
//             //     $.get( "< ?php echo url .'/'.$this->folder ?>/processing_show_items/",{ jsonData: JSON.stringify(dataName)}, function(data) {
//             //         var value = JSON.parse(data);
//             //         // $('#code_'+id).val(value[0].code);

//             //         $('#img_'+id).attr('src',value[0].img);
//             //         $('#type_'+id).html(value[0].type);
//             //         $('#rate_'+id).html(value[0].rate);
//             //         // $('#purchase_order_0').val(data.purchase_order);
//             //         // $('#sale_price_0').val(data.sale_price);
//             //         // $('#wholesale_price_sale_0').val(data.wholesale_price_sale);
//             //         // $('#wholesale_price2_sale_0').val(data.wholesale_price2_sale);
//             //         // $('#note_0').val(data.note);
//             //     });
//             // });

//         });


//     });



//     // حذف الصف بعد الضغط على الزر
//     function remove_sub_row(id){
//         $('.remove_sub_row_'+id).remove();
//     }
// </script>







// <style>
//     body{
//         background-color: #f8f9fa !important;
//     }
//     .breadcrumb{
//         border-radius: 0 !important;
//         margin-bottom: 0 !important;
//         background-color: rgba(121,169,197,.92) !important;
//         -webkit-box-shadow: 0px -4px 3px #ccc;
//         -moz-box-shadow: 0px -4px 3px #ccc;
//         box-shadow: 0px -4px 10px #ccc;
//     }
//     .breadcrumb li {
//         color: #fff !important;
//     }

//     .content{
//         width: 100%;
//         margin-right: 0 auto;
//     }
//     .content .part1{
//         width: 100%;
//         padding: 16px 10px;
//         background-color: #fff !important;
//         margin-bottom: 30px;
//         box-shadow: 0px 0px 10px #ccc;
//     }
//     .d-table
//     {
//         width:100%;
//         margin-top:30px !important;
//         border: 1px solid #c4c2c2;
//         border-radius: 5px;

//     }
//     table thead tr
//     {

//         text-align: center;
//         white-space: nowrap;
//         background-color: rgba(121,169,197,0.92) !important;
//         color: #fff;
//         /* height: 35px; */
//         font-size:14px;

//     }
//     table tbody tr td
//     {
//         /* text-align: center; */
//         /* white-space: nowrap; */
//         font-size:14px;
//     }
//     table tbody  tr:nth-child(odd) {
//         background-color: #f8f9fa !important;
//     }
//     table tbody  tr:nth-child(even) {
//         background-color: #f3f8fa;
//     }
//     input, .custom-select
//     {
//         border-radius: 6px;
//     }
//     .add_new_sub_row{
//         color: green;
//     }
//     .remove_sub_row{
//        color: red;
//     }
//     #save_bill{
//         /* position: relative; */
//         text-align: center;
//         justify-self: center;
//         margin: 10px auto;
//         /* background-color: #00a65a; */
//         color: #fff;
//         border-radius: 6px;
//         padding: 5px 10px;
//     }

// </style>
