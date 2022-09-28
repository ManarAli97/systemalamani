<?php
require_once "search_purchase_customer/search_purchase_customer.php";
class purchase_customer extends Controller
{

  use search_purchase_customer;

    function __construct()
    {
        parent::__construct();

        $this->purchase_customer_bill = 'purchase_customer_bill';
        $this->purchase_customer_item = 'purchase_customer_item';
        $this->group_bill='purchase_customer_group_bill';
        $this->setting = new Setting();

    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->purchase_customer_bill}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `id_customer`  int(11) NOT NULL,
          `number_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `sumbill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `active` int(11) NOT NULL DEFAULT '0',
          `checked` int(11) NOT NULL DEFAULT '0',
          `edit` int(11) NOT NULL DEFAULT '0',
          `cancel` int(11) NOT NULL DEFAULT '0',
          `user_cancel` int(11) NOT NULL,
           `date_cancel` bigint(20) NOT NULL,
          `userid` int(11) NOT NULL,
          `user_enter` int(11) NOT NULL,
          `user_checked` int(11) NOT NULL,
          `user_edit` int(11) NOT NULL,
          `crystal_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date_account` bigint(20) NOT NULL,
          `date_enter` bigint(20) NOT NULL,
          `date_checked` bigint(20) NOT NULL,
          `date_edit` bigint(20) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
      ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->purchase_customer_item}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `id_customer`  int(11) NOT NULL,
          `id_bill`  int(11) NOT NULL,
          `number_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `id_item` int(11) NOT NULL,
          `id_color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `quantity` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `serial` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `price_purchase` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `price_sale` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `note` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
          `table` varch ar(250) COLLATE utf8_unicode_ci NOT NULL,

           PRIMARY KEY (`id`)
      ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->group_bill}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `number_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `crystal_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `number` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `userid` int (10) NOT NULL,
           `user_input_bill` int (10) NOT NULL,
           `checked` int(20) NOT NULL DEFAULT 0,
           `user_checked` int(20) NOT NULL,
           `date` bigint(20) NOT NULL,
           
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        return $this->db->cht(array($this->purchase_customer_bill, $this->purchase_customer_item, $this->group_bill));

    }



    function required($flag)
    {
        if ($flag==0)
        {
            $this->setting->set('required_serial_purchase_customer',0) ;
        }else
        {
            $this->setting->set('required_serial_purchase_customer',1) ;
        }

    }




    function index()
    {

        $this->checkPermit('account_bill_purchase_customer', $this->folder);
        $this->adminHeaderController($this->langControl('account_bill_purchase_customer'));

        $this->purchase_customer_number_bill_create(4);


        $bill = array();

        $stmt = $this->db->prepare("SELECT  purchase_customer_bill.*,register_user.name,register_user.phone FROM purchase_customer_bill INNER JOIN register_user   on register_user.id = purchase_customer_bill.id_customer WHERE active = 0 AND cancel =0 ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $bill[] = $row;
        }


        require($this->render($this->folder, 'account', 'index', 'php'));
        $this->adminFooterController();

    }


    function details($number_bill)
    {

        $this->checkPermit('details', $this->folder);
        $this->adminHeaderController($this->langControl('details'));


        $sum = $this->sumbill($number_bill);


        $stmt_customer = $this->db->prepare("SELECT register_user.*,purchase_customer_bill.number_bill,purchase_customer_bill.crystal_bill,purchase_customer_bill.date_account FROM purchase_customer_bill INNER JOIN register_user ON register_user.id = purchase_customer_bill.id_customer    WHERE   purchase_customer_bill.number_bill=?  ");
        $stmt_customer->execute(array($number_bill));
        $result = $stmt_customer->fetch(PDO::FETCH_ASSOC);


        $stmt = $this->db->prepare("SELECT * FROM purchase_customer_item  WHERE   number_bill=?");
        $stmt->execute(array($number_bill));
        $bill = array();
        $mod = array('savers');
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $table = $row['table'];


            if (!in_array($table, $mod)) {
                if ($table == 'mobile') {
                    $color = 'color';
                } else {
                    $color = 'color_' . $table;
                }

                $stmtT = $this->db->prepare("SELECT title FROM {$table}  WHERE id=?  ");
                $stmtT->execute(array($row['id_item']));
                if ($stmtT->rowCount() > 0) {
                    $r = $stmtT->fetch(PDO::FETCH_ASSOC);
                    $row['title'] = $r['title'];
                } else {
                    $row['title'] = '';
                }

                $stmtimg = $this->db->prepare("SELECT img FROM {$color}  WHERE id=?  ");
                $stmtimg->execute(array($row['id_color']));
                if ($stmtimg->rowCount() > 0) {
                    $rm = $stmtimg->fetch(PDO::FETCH_ASSOC);
                    $row['image'] = $this->save_file . $rm['img'];
                } else {
                    $row['image'] = '';
                }


            } else {
                $stmtT = $this->db->prepare("SELECT title,img FROM product_savers  WHERE id=?  ");
                $stmtT->execute(array($row['id_item']));
                if ($stmtT->rowCount() > 0) {
                    $r = $stmtT->fetch(PDO::FETCH_ASSOC);
                    $row['title'] = $r['title'];
                    $row['image'] = $this->save_file . $r['img'];

                } else {
                    $row['title'] = '';
                    $row['image'] = '';
                }
            }

            $bill[] = $row;
        }


        require($this->render($this->folder, 'html', 'details', 'php'));
        $this->adminFooterController();

    }


    function purchase()
    {


        $this->checkPermit('purchase', $this->folder);
        $this->adminHeaderController($this->langControl('purchase'));


        require($this->render($this->folder, 'html', 'index', 'php'));

        $this->adminFooterController();


    }


    function search_phone()
    {


        $phone = $_GET['phone'];


        $stmt = $this->db->prepare("SELECT * FROM register_user WHERE  phone =  ?   LIMIT 1");
        $stmt->execute(array($phone));
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode(array('name' => $result['name'], 'phone' => $result['phone'], 'id' => $result['id'], 'qr' => $result['uid'],));
        }


    }


    function search_ar()
    {


        $qr = $_GET['qr'];

        $link = explode('/', $qr);
        $code = end($link);

        $stmt = $this->db->prepare("SELECT * FROM register_user WHERE  uid =  ?   LIMIT 1");
        $stmt->execute(array($code));
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode(array('name' => $result['name'], 'phone' => $result['phone'], 'id' => $result['id'], 'qr' => $result['uid'],));
        }

    }


    function smartsearch()
    {

        $mod = array('accessories', 'savers');

        $val = strip_tags(trim($_GET['val']));
        $model = strip_tags(trim($_GET['cat']));
        $mod = array('accessories', 'savers');
        if ($model == 'mobile') {
            $code = 'code';
            $color = 'color';
        } else if (!in_array($model, $mod)) {
            $code = 'code_' . $model;
            $color = 'color_' . $model;

        }
        $contentAll = array();
        $q = '%' . trim($val) . '%';
        $r = '[[:<:]]' . trim($val) . '[[:>:]]';

        if (!in_array($model, $mod)) {





            $stmt = $this->db->prepare("SELECT `id`,`title`,`bast_it`,`price_dollars` FROM `{$model}` WHERE ( title LIKE ? OR  tags LIKE ? )     LIMIT 10");
            $stmt->execute(array($q, $q));

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $contentAll[] = $row;

                }
            }

            $stmtcode = $this->db->prepare("SELECT {$model}.* FROM {$code} inner JOIN {$color} ON {$code}.id_color = {$color}.id inner JOIN {$model} ON {$color}.id_item =  {$model}.id WHERE ({$code}.code=? OR {$code}.serial  REGEXP ?) ");
            $stmtcode->execute(array(str_replace(' ', '', $val), $r));
            if ($stmtcode->rowCount() > 0) {
                while ($row_code = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
                    $contentAll[] = $row_code;


                }
            }
        } else if ($model == 'accessories') {

            $stmt = $this->db->prepare("SELECT *FROM `accessories` WHERE ( title LIKE ? OR  tags LIKE ? )  LIMIT 10");
            $stmt->execute(array($q, $q));

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $contentAll[] = $row;

                }
            }

            $stmtcode = $this->db->prepare("SELECT accessories.* FROM color_accessories inner JOIN accessories ON color_accessories.id_item = accessories.id WHERE  (color_accessories.code=?  OR color_accessories.serial  REGEXP ?)  ");
            $stmtcode->execute(array(str_replace(' ', '', $val), $r));
            if ($stmtcode->rowCount() > 0) {
                while ($row_code = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
                    $contentAll[] = $row_code;
                }
            }


        } else if ($model == 'savers') {

            $stmt = $this->db->prepare("SELECT * from `product_savers` WHERE (title LIKE ?  OR code = ? OR serial REGEXP ? ) LIMIT 10");
            $stmt->execute(array($q, str_replace(' ', '', $val), $r));

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $contentAll[] = $row;

                }
            }

        }
        if (!empty($contentAll)) {
            require($this->render($this->folder, 'html', 'data', 'php'));

        }


    }


    /*
        function getdata()
        {
            $id=$_GET['id'];
            $stmt = $this->db->prepare("SELECT id,title,serial_flag,enter_serial  FROM `mobile` WHERE  id=?     ");
            $stmt->execute(array($id));

            $result=$stmt->fetch(PDO::FETCH_ASSOC);

             $result['color']=array();
            $stmtc = $this->db->prepare("SELECT *FROM `color` WHERE  id_item=?  ");
            $stmtc->execute(array($id));
            while ($row =$stmtc->fetch(PDO::FETCH_ASSOC) )
            {
                $row['image']=$this->save_file.$row['img'];

                $row['code']=array();

                $stmtcode = $this->db->prepare("SELECT code.*,excel.quantity,excel.price_dollars FROM `code` left   join excel on excel.code = code.code WHERE  id_color=?  ");
                $stmtcode->execute(array($row['id']));
                while ($rowcode =$stmtcode->fetch(PDO::FETCH_ASSOC) )
                {

                    if (empty($rowcode['price_dollars']))
                    {
                        $rowcode['price_dollars']=0;
                    }


                    if (empty($rowcode['quantity']))
                    {
                        $rowcode['quantity']=0;
                    }


                    $rowcode['price']=$this->price_dollarsAdmin($rowcode['price_dollars']);
                    $row['code'][]=$rowcode;
                }

                $result['color'][]=$row;
            }


            if (!empty($result))
            {
                require($this->render($this->folder, 'html', 'mobile', 'php'));

            }


        }

    */


    function getdata()
    {
        $id = $_GET['id'];
        $model = $_GET['model'];

        $mod = array('accessories', 'savers');
        if ($model == 'mobile') {
            $code = 'code';
            $color = 'color';
            $excel = 'excel';
        } else if (!in_array($model, $mod)) {
            $code = 'code_' . $model;
            $color = 'color_' . $model;
            $excel = 'excel_' . $model;

        }

        if (!in_array($model, $mod)) {


            $stmt = $this->db->prepare("SELECT id,title,serial_flag,enter_serial  FROM `{$model}` WHERE  id=?     ");
            $stmt->execute(array($id));

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $result['color'] = array();
            $stmtc = $this->db->prepare("SELECT *FROM `{$color}` WHERE  id_item=?  ");
            $stmtc->execute(array($id));
            while ($row = $stmtc->fetch(PDO::FETCH_ASSOC)) {
                $row['image'] = $this->save_file . $row['img'];
                $row['table'] = $model;

                $row['code'] = array();

                $stmtcode = $this->db->prepare("SELECT {$code}.*,{$excel}.quantity,{$excel}.price_dollars,{$excel}.wholesale_price,{$excel}.wholesale_price2,{$excel}.cost_price FROM `{$code}` left   join {$excel} on {$excel}.code = {$code}.code WHERE  {$code}.id_color=?  ");
                $stmtcode->execute(array($row['id']));
                while ($rowcode = $stmtcode->fetch(PDO::FETCH_ASSOC)) {

                    if (empty($rowcode['price_dollars'])) {
                        $rowcode['price_dollars'] = 0;
                    }


                    if (empty($rowcode['quantity'])) {
                        $rowcode['quantity'] = 0;
                    }

                    $rowcode['wholesale_priced'] = $this->price_dollarsAdmin($rowcode['wholesale_price']);
                    $rowcode['wholesale_price2d'] = $this->price_dollarsAdmin($rowcode['wholesale_price2']);
                    $rowcode['cost_priced'] = $this->price_dollarsAdmin($rowcode['cost_price']);


                    $rowcode['price'] = $this->price_dollarsAdmin($rowcode['price_dollars']);
                    $rowcode['store'] =$this->storehouse($rowcode['code'],$model) ;

                    $row['code'][] = $rowcode;

                }

                $result['color'][] = $row;
            }
        } else if ($model == 'accessories') {


            $stmt = $this->db->prepare("SELECT id,title,serial_flag,enter_serial  FROM `accessories` WHERE  id=?     ");
            $stmt->execute(array($id));

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $result['color'] = array();
            $stmtc = $this->db->prepare("SELECT color_accessories.*,excel_accessories.quantity,excel_accessories.price_dollars,excel_accessories.wholesale_price,excel_accessories.wholesale_price2,excel_accessories.cost_price FROM `color_accessories` left   join excel_accessories on excel_accessories.code = color_accessories.code WHERE  color_accessories.id_item=?  ");
            $stmtc->execute(array($id));
            while ($row = $stmtc->fetch(PDO::FETCH_ASSOC)) {
                $row['image'] = $this->save_file . $row['img'];
                $row['table'] = $model;
                $codex = $row['code'];
                $row['code'] = array();

                $row['code'][0]['price_dollars'] = $row['price_dollars'];
                $row['code'][0]['wholesale_price'] = $row['wholesale_price'];
                $row['code'][0]['wholesale_price2'] = $row['wholesale_price2'];
                $row['code'][0]['cost_price'] = $row['cost_price'];


                $row['code'][0]['wholesale_priced'] = $this->price_dollarsAdmin($row['wholesale_price']);
                $row['code'][0]['wholesale_price2d'] = $this->price_dollarsAdmin($row['wholesale_price2']);
                $row['code'][0]['cost_priced'] = $this->price_dollarsAdmin($row['cost_price']);

                $row['code'][0]['code'] = $codex;
                $row['code'][0]['price'] = $this->price_dollarsAdmin($row['price_dollars']);
                if (empty($row['quantity'])) {
                    $row['code'][0]['quantity'] = 0;
                } else {
                    $row['code'][0]['quantity'] = $row['quantity'];
                }
                $row['code'][0]['size'] = '';
                $row['code'][0]['store'] =$this->storehouse($codex,$model) ;

                $result['color'][] = $row;
            }
        } else if ($model == 'savers') {


            $stmt = $this->db->prepare("SELECT id,title,serial_flag,enter_serial  FROM `product_savers` WHERE  id=?     ");
            $stmt->execute(array($id));

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $result['color'] = array();
            $stmtc = $this->db->prepare("SELECT product_savers.*,excel_savers.quantity,excel_savers.price_dollars,excel_savers.wholesale_price,excel_savers.wholesale_price2,excel_savers.cost_price FROM `product_savers` left   join excel_savers on excel_savers.code = product_savers.code WHERE  product_savers.id=?  ");
            $stmtc->execute(array($id));
            while ($row = $stmtc->fetch(PDO::FETCH_ASSOC)) {
                $row['image'] = $this->save_file . $row['img'];
                $row['table'] = $model;
                $codex = $row['code'];
                $row['code'] = array();

                $row['code'][0]['price_dollars'] = $row['price_dollars'];
                $row['code'][0]['wholesale_price'] = $row['wholesale_price'];
                $row['code'][0]['wholesale_price2'] = $row['wholesale_price2'];
                $row['code'][0]['cost_price'] = $row['cost_price'];

                $row['code'][0]['wholesale_priced'] = $this->price_dollarsAdmin($row['wholesale_price']);
                $row['code'][0]['wholesale_price2d'] = $this->price_dollarsAdmin($row['wholesale_price2']);
                $row['code'][0]['cost_priced'] = $this->price_dollarsAdmin($row['cost_price']);

                $row['code'][0]['code'] = $codex;
                $row['code'][0]['price'] = $this->price_dollarsAdmin($row['price_dollars']);
                if (empty($row['quantity'])) {
                    $row['code'][0]['quantity'] = 0;
                } else {
                    $row['code'][0]['quantity'] = $row['quantity'];
                }
                $row['code'][0]['size'] = '';
                $row['code'][0]['store'] =$this->storehouse($codex,$model) ;
                $result['color'][] = $row;
            }
        }


        if (!empty($result)) {
            require($this->render($this->folder, 'html', 'mobile', 'php'));

        }


    }


    function check_serial_required_purchase()
    {

         $code=trim($_GET['code']);
        if ($this->check_serial_required($code,'serial_purchase')==true)
        {
            echo 'true';
        }

    }






    function storehouse($code,$table)
    {



        if ($table =='product_savers')
        {
            $table='savers';
        }


        $sequence = array();

            $stmt = $this->db->prepare("SELECT  sequence FROM location  WHERE code=? AND  `model`=? LIMIT  1");
            $stmt->execute(array($code,$table));
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $sequence[] = $row['sequence'];
            }


        $store=array();
        foreach ($sequence as $sq)
        {
            $stmt2 = $this->db->prepare("SELECT  * FROM  group_location   WHERE {$sq} between `from` AND  `to` LIMIT 1 ");
            $stmt2->execute();
            $name_store=$stmt2->fetch(PDO::FETCH_ASSOC);

            if (!in_array($name_store['title'],$store))
            {
                $store[]=$name_store['title'];

            }

        }
        return implode(',',$store);

    }















    function checkFounded($id, $price_dollars, $model)
    {

        $idItemC = array();
        $funs = new $model;
        $stmtIdItC = $funs->numberItems($id);
        while ($rowiIdIt = $stmtIdItC->fetch(PDO::FETCH_ASSOC)) {
            $idItemC[] = $rowiIdIt;
        }

        if (!empty($idItemC)) {
            foreach ($idItemC as $idItc) {
                $stmt_img_id = $funs->getImage($idItc['id'], 1);
                $stmt_price = $funs->getPrice($stmt_img_id['id'], 1, $price_dollars);

                if ($model == 'mobile') {

                    if ($funs->smt_ch_code($stmt_price['code'])) {

                        return true;
                    } else {
                        continue;
                    }

                } else {

                    $smt_ch_q = $funs->smt_ch_q($stmt_price['code']);
                    if ($smt_ch_q->rowCount() > 0) {
                        return true;
                    } else {
                        continue;
                    }
                }


            }
        }
    }


    function save_data()
    {


        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $stmtr = $this->db->prepare("SELECT  id   FROM `register_user` WHERE  phone=? AND name=? ");
        $stmtr->execute(array($name, $phone));
        if ($stmtr->rowCount() > 0) {
            $id = $stmtr->fetch(PDO::FETCH_ASSOC)['id'];
        } else {
            $stmt = $this->db->prepare("INSERT INTO `register_user` (`name`,`phone`,`date`) values (?,?,?)");
            $stmt->execute(array($name, $phone, time()));
            $id = $this->db->lastInsertId();
        }
        if ($id) {

            $ids_mobile = $_POST['id_mobile'];

            $number_bill = $this->purchase_customer_number_bill_create(4);
            $stmtb = $this->db->prepare("INSERT INTO `purchase_customer_bill` ( id_customer, number_bill,user_purchase,`date`) values (?,?,?,?)");
            $stmtb->execute(array($id, $number_bill, $this->userid, time()));
            if ($stmtb->rowCount() > 0) {

                $id_bill = $this->db->lastInsertId();
                foreach ($ids_mobile as $data) {

                    $id_color = $_POST['id_color_' . $data];
                    $model = $_POST['model_' . $data];
                    $code = $_POST['code_' . $data];
                    $quantity = $_POST['quantity_' . $data];
                    $price_purchase = $_POST['price_purchase_' . $data];
                    $price_sale = $_POST['price_sale_' . $data];
                    $wholesale_price = $_POST['wholesale_price_' . $data];
                    $wholesale_price2 = $_POST['wholesale_price2_' . $data];
                    $cost_price = $_POST['cost_price_' . $data];
                    $note = $_POST['note_' . $data];
                    $location = $_POST['location_' . $data];

                    foreach ($code as $key => $cde) {
                        $table = $model[$key];
                        if ($table == 'mobile') {
                            $excel = 'excel';
                        } else {

                            $excel = 'excel_' . $table;

                    }


                         $qty=(int)trim($quantity[$key]);

                        $serial = implode(',', $_POST['serial_' . $cde]);
                        $stmtp = $this->db->prepare("INSERT INTO `purchase_customer_item` (  id_customer, id_bill, number_bill, id_item, id_color, code, quantity, serial, price_purchase, price_sale, note,location, date,`table`,`wholesale_price`,`wholesale_price2`,`cost_price`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                        $stmtp->execute(array($id, $id_bill, $number_bill, $data, $id_color[$key], $cde, $quantity[$key], $serial, (int)str_replace($this->comma, '', $price_purchase[$key]), $price_sale[$key], $note[$key],$location[$key], time(), $table,$wholesale_price[$key],$wholesale_price2[$key],$cost_price[$key]));

                    }
                }
                echo 'true';

            }

        }

    }

    function getDateBill()
    {

        $id_bill = $_GET['id_bill'];
        $id_customer = $_GET['id_customer'];
        $number_bill = $_GET['number_bill'];

        $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE id = ?    LIMIT 1");
        $stmt->execute(array($id_customer));
        $result = $stmt->fetch();

        $sum = $this->sumbill($number_bill);



        $stmtpl = $this->db->prepare("SELECT *FROM `purchase_customer_bill` WHERE number_bill = ?    LIMIT 1");
        $stmtpl->execute(array($number_bill));
        $result2 = $stmtpl->fetch();




        $stmt = $this->db->prepare("SELECT * FROM purchase_customer_item  WHERE id_bill=? AND id_customer=? AND number_bill=?");
        $stmt->execute(array($id_bill, $id_customer, $number_bill));
        $bill = array();
        $mod = array('savers');
        $number_type = 0;
        $sum_material = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $table = $row['table'];


            if (!in_array($table, $mod)) {
                if ($table == 'mobile') {
                    $color = 'color';
                } else {
                    $color = 'color_' . $table;
                }

                $number_type = $number_type + 1;
                $sum_material = $sum_material + $row['quantity'];


                $stmtT = $this->db->prepare("SELECT title FROM {$table}  WHERE id=?  ");
                $stmtT->execute(array($row['id_item']));
                if ($stmtT->rowCount() > 0) {
                    $r = $stmtT->fetch(PDO::FETCH_ASSOC);
                    $row['title'] = $r['title'];
                } else {
                    $row['title'] = '';
                }

                $stmtimg = $this->db->prepare("SELECT img FROM {$color}  WHERE id=?  ");
                $stmtimg->execute(array($row['id_color']));
                if ($stmtimg->rowCount() > 0) {
                    $rm = $stmtimg->fetch(PDO::FETCH_ASSOC);
                    $row['image'] = $this->save_file . $rm['img'];
                } else {
                    $row['image'] = '';
                }


            } else {
                $stmtT = $this->db->prepare("SELECT title,img FROM product_savers  WHERE id=?  ");
                $stmtT->execute(array($row['id_item']));
                if ($stmtT->rowCount() > 0) {
                    $r = $stmtT->fetch(PDO::FETCH_ASSOC);
                    $row['title'] = $r['title'];
                    $row['image'] = $this->save_file . $r['img'];

                } else {
                    $row['title'] = '';
                    $row['image'] = '';
                }
            }

            $bill[] = $row;
        }

       require($this->render($this->folder, 'account', 'data', 'php'));


    }

    function pay()
    {
        $id_customer = $_GET['id_customer'];
        $number_bill = $_GET['number_bill'];

        $sp= $this->sumbill($number_bill) ;


        if ($this->main_account($this->userid))
        {

            $account = new Accountant();
            $allMoney_from_star = (int)trim(str_replace($this->comma, '', $account->billAcount_money_clipper($this->userid)));

            if ( $sp > $allMoney_from_star ) {
                echo '-1';
            } else {

                $stmt = $this->db->prepare("UPDATE purchase_customer_bill SET `active`=? ,`userid`=?,`date_account`=? WHERE `id_customer`=? AND `number_bill`=?");
                $stmt->execute(array(1, $this->userid, time(), $id_customer, $number_bill));
                if ($stmt->rowCount() > 0) {


                    $stmt_total = $this->db->prepare("SELECT *FROM `total_accountants` WHERE  `id_account` = ?  ");
                    $stmt_total->execute(array($this->userid));
                    if ($stmt_total->rowCount() > 0) {
                        $stmt_t = $this->db->prepare("UPDATE  `total_accountants` SET `bill_purchase`=bill_purchase + {$sp},`userId`=?, `date`=? WHERE  `id_account` = ?   ");
                        $stmt_t->execute(array($this->userid,time(),$this->userid));

                    } else {
                        $stmt_t = $this->db->prepare("INSERT INTO `total_accountants` (`username`,`id_account`,`bill_purchase`,`userId`,`date`) values (?,?,?,?,?)");
                        $stmt_t->execute(array($this->UserInfo($this->userid),$this->userid, $sp,$this->userid, time()));
                    }



                    $stmt=$this->db->prepare("SELECT *FROM purchase_customer_item WHERE number_bill=? AND id_customer=?");
                    $stmt->execute(array($number_bill,$id_customer));
                    while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        $qty=(int)$row['quantity'];
                        if ($row['table'] == 'mobile') {
                            $excel = 'excel';
                        } else {

                            $excel = 'excel_' . $row['table'] ;

                        }


                        if ($row['serial'])
                        {

                            $serial=explode(',',$row['serial']);
                            foreach ($serial as $srl)
                            {
                                $srl=trim($srl);
                                   $stmtSERial = $this->db->prepare("INSERT INTO `serial` (code, serial, type_enter, quantity, userId, `date`, model,note) VALUE (?,?,?,?,?,?,?,?) ");
                                    $stmtSERial->execute(array($row['code'],$srl,$row['number_bill'].' فاتورة شراء ', 1, $row['userId'], time(), $row['table'],$row['number_bill'].' شراء  '));

                            }
                        }



                        $stmtChCode = $this->db->prepare("SELECT *FROM {$excel} WHERE code =?");
                        $stmtChCode->execute(array($row['code']));
                        if ($stmtChCode->rowCount() > 0) {


                            $pr=$stmtChCode->fetch(PDO::FETCH_ASSOC);

                            if (empty(trim($row['price_sale'])) || $row['price_sale'] == 0 ) {
                                $row['price_dollars']= $pr['price_dollars'];
                            }else
                            {
                                $row['price_dollars']=$row['price_sale'];
                            }

                            if (empty(trim($row['wholesale_price'])) || $row['wholesale_price'] == 0 ) {
                                $row['wholesale_price']= $pr['wholesale_price'];
                            }

                            if (empty(trim($row['wholesale_price2'])) || $row['wholesale_price2'] == 0 ) {
                                $row['wholesale_price2']= $pr['wholesale_price2'];
                            }

                            if (empty(trim($row['cost_price'])) || $row['cost_price'] == 0 ) {
                                $row['cost_price']= $pr['cost_price'];
                            }


                            $stmtExcel = $this->db->prepare("UPDATE {$excel} SET  quantity=quantity+ {$qty} ,price_dollars=?,wholesale_price=?,wholesale_price2=?,cost_price=?,range1 = ? ,range2 = ? WHERE code =?");
                            $stmtExcel->execute(array($row['price_dollars'],$row['wholesale_price'],$row['wholesale_price2'],$row['cost_price'], $this->min_price($row['price_dollars']), $this->max_price($row['price_dollars']), $row['code']));

                            $stmtExcel_archive = $this->db->prepare("INSERT INTO uesr_add_excel (code,quantity,price,type,number_bill,`date`,normal_date,username,wholesale_price,wholesale_price2,cost_price,model)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                            $stmtExcel_archive->execute(array($row['code'],$qty, $row['price_dollars'],'شراء','شراء',time(),date('Y-m-d h:i A',time()),$this->userid,$row['wholesale_price'],$row['wholesale_price2'],$row['cost_price'],$row['table']));

                        } else {
                            $stmtExcel = $this->db->prepare("INSERT INTO {$excel} (code,quantity,price_dollars,range1,range2,number_bill,`date`,date_archives,userid,wholesale_price,wholesale_price2,cost_price)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                            $stmtExcel->execute(array($row['code'],$qty, $row['price_sale'], $this->min_price($row['price_sale']), $this->max_price($row['price_sale']),'شراء',time(),time(),$this->userid,$row['wholesale_price'],$row['wholesale_price2'],$row['cost_price']));


                            $stmtExcel_archive = $this->db->prepare("INSERT INTO uesr_add_excel (code,quantity,price,type,number_bill,`date`,normal_date,username,wholesale_price,wholesale_price2,cost_price,model)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                            $stmtExcel_archive->execute(array($row['code'],$qty, $row['price_sale'],'شراء','شراء',time(),date('Y-m-d h:i A',time()),$this->userid,$row['wholesale_price'],$row['wholesale_price2'],$row['cost_price'],$row['table']));

                        }



                        if (!empty($row['location'])) {

                            $stmt_ch_location = $this->db->prepare("SELECT *FROM  location  WHERE code =? AND  model=? AND location=?");
                            $stmt_ch_location->execute(array($row['code'], $row['table'], trim($row['location'])));
                            if ($stmt_ch_location->rowCount() > 0) {
                                $stmtExcel_conform = $this->db->prepare("UPDATE location SET  quantity=quantity + {$qty} ,`date`=? ,userid=? WHERE code =? AND  model=? AND location=?");
                                $stmtExcel_conform->execute(array(time(),$this->userid, $row['code'], $row['table'], trim($row['location'])));
                                if($stmtExcel_conform->rowCount()  > 0)
                                {
                                    $this->filter_location_tracking_quantity($row['code'],$row['table'], trim($row['location']),$qty,' شراء جهاز - رقم39','+',$number_bill);

                                }else
                                {
                                    $this->filter_location_error_quantity($row['code'],$row['table'], trim($row['location']),$qty,'  شراء جهاز - رقم الخظأ 39','+',$number_bill);

                                }
                            } else {

                                $stmtModelLOcation = $this->db->prepare("SELECT sequence FROM `location_model`  WHERE `location` LIKE ?  AND `model` =?   LIMIT 1");
                                $stmtModelLOcation->execute(array(trim($row['location']), $row['table']));
                                $sequence=0;
                                if ($stmtModelLOcation->rowCount() >0)
                                {
                                    $sequence = $stmtModelLOcation->fetch(PDO::FETCH_ASSOC)['sequence'];

                                }

                                $stmtExcel_conform = $this->db->prepare("INSERT INTO location (sequence,quantity,`date`,code,model,location,userid) VALUES (?,?,?,?,?,?,?)");
                                $stmtExcel_conform->execute(array($sequence,$qty, time(), $row['code'], $row['table'], trim($row['location']),$this->userid));
                                if($stmtExcel_conform->rowCount()  > 0)
                                {
                                    $this->filter_location_tracking_quantity($row['code'],$row['table'], trim($row['location']),$qty,' شراء جهاز - رقم40','+',$number_bill);

                                }else
                                {
                                    $this->filter_location_error_quantity($row['code'],$row['table'], trim($row['location']),$qty,'  شراء جهاز - رقم الخظأ 40','+',$number_bill);

                                }
                            }
                        }else
                        {

                            $stmtChCodeConform = $this->db->prepare("SELECT *FROM location_confirm WHERE code =? AND model=?");
                            $stmtChCodeConform->execute(array($row['code'],$row['table']));
                            if ($stmtChCodeConform->rowCount() > 0) {
                                $stmtExcel_conform = $this->db->prepare("UPDATE location_confirm SET  quantity=quantity+ {$qty} ,`date`=?  WHERE code =? AND  model=?");
                                $stmtExcel_conform->execute(array(time(), $row['code'],$row['table']));
                                if($stmtExcel_conform->rowCount() <=0)
                                {
                                    $this->filter_error_quantity( $row['code'],$row['table'],$qty,' محاسبة فاتورة شراء   - رقم الخطا 9',$number_bill);
                                }
                            }else
                            {

                                $stmtExcel_conform = $this->db->prepare("INSERT INTO  location_confirm (quantity,code,model,`date`)  values (?,?,?,?) ");
                                $stmtExcel_conform->execute(array($qty,$row['code'],$row['table'],time()));
                                if($stmtExcel_conform->rowCount() <=0)
                                {
                                    $this->filter_error_quantity( $row['code'],$row['table'],$qty,' محاسبة فاتورة شراء   - رقم الخطا 10',$number_bill);
                                }
                            }

                        }

                        $this->Add_to_sync_schedule($row['code'],$row['table'],'quantity_adjustment',' ',' controllers\purchase_customer\purchase_customer.php 915 '.$this->UserInfo($this->userid));


                    }



                    echo 'true';
                }
            }

        }else
        {

            $direct = new direct();
            $allMoney_from_star_direct  = (int)trim(str_replace($this->comma, '', $direct->sumAllMoney($this->userid)));


            if  ($sp > $allMoney_from_star_direct)  {
                echo '-1';
            } else {



                $stmt = $this->db->prepare("UPDATE purchase_customer_bill SET `active`=? ,`userid`=?,`date_account`=? WHERE `id_customer`=? AND `number_bill`=?");
                $stmt->execute(array(1, $this->userid, time(), $id_customer, $number_bill));
                if ($stmt->rowCount() > 0) {


                    $stmt=$this->db->prepare("SELECT *FROM purchase_customer_item WHERE number_bill=? AND id_customer=?");
                    $stmt->execute(array($number_bill,$id_customer));
                    while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        $qty=(int)$row['quantity'];
                        if ($row['table'] == 'mobile') {
                            $excel = 'excel';
                        } else {

                            $excel = 'excel_' . $row['table'] ;

                        }



                        if ($row['serial'])
                        {

                            $serial=explode(',',$row['serial']);
                            foreach ($serial as $srl)
                            {
                                $srl=trim($srl);
                                $stmtSERial = $this->db->prepare("INSERT INTO `serial` (code, serial, type_enter, quantity, userId, `date`, model,note) VALUE (?,?,?,?,?,?,?,?) ");
                                $stmtSERial->execute(array($row['code'],$srl,$row['number_bill'].' فاتورة شراء ', 1, $row['userId'], time(), $row['table'],$row['number_bill'].' شراء  '));

                            }
                        }



                        $stmtChCode = $this->db->prepare("SELECT *FROM {$excel} WHERE code =?");
                        $stmtChCode->execute(array($row['code']));
                        if ($stmtChCode->rowCount() > 0) {


                            $pr=$stmtChCode->fetch(PDO::FETCH_ASSOC);

                            if (empty(trim($row['price_sale'])) || $row['price_sale'] == 0 ) {
                                $row['price_dollars']= $pr['price_dollars'];
                            }else
                            {
                                $row['price_dollars']=$row['price_sale'];
                            }

                            if (empty(trim($row['wholesale_price'])) || $row['wholesale_price'] == 0 ) {
                                $row['wholesale_price']= $pr['wholesale_price'];
                            }

                            if (empty(trim($row['wholesale_price2'])) || $row['wholesale_price2'] == 0 ) {
                                $row['wholesale_price2']= $pr['wholesale_price2'];
                            }

                            if (empty(trim($row['cost_price'])) || $row['cost_price'] == 0 ) {
                                $row['cost_price']= $pr['cost_price'];
                            }


                            $stmtExcel = $this->db->prepare("UPDATE {$excel} SET  quantity=quantity+ {$qty} ,price_dollars=?,wholesale_price=?,wholesale_price2=?,cost_price=?,range1 = ? ,range2 = ? WHERE code =?");
                            $stmtExcel->execute(array($row['price_dollars'],$row['wholesale_price'],$row['wholesale_price2'],$row['cost_price'], $this->min_price($row['price_dollars']), $this->max_price($row['price_dollars']), $row['code']));

                            $stmtExcel_archive = $this->db->prepare("INSERT INTO uesr_add_excel (code,quantity,price,type,number_bill,`date`,normal_date,username,wholesale_price,wholesale_price2,cost_price,model)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                            $stmtExcel_archive->execute(array($row['code'],$qty, $row['price_dollars'],'شراء','شراء',time(),date('Y-m-d h:i A',time()),$this->userid,$row['wholesale_price'],$row['wholesale_price2'],$row['cost_price'],$row['table']));

                        } else {
                            $stmtExcel = $this->db->prepare("INSERT INTO {$excel} (code,quantity,price_dollars,range1,range2,number_bill,`date`,date_archives,userid,wholesale_price,wholesale_price2,cost_price)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                            $stmtExcel->execute(array($row['code'],$qty, $row['price_sale'], $this->min_price($row['price_sale']), $this->max_price($row['price_sale']),'شراء',time(),time(),$this->userid,$row['wholesale_price'],$row['wholesale_price2'],$row['cost_price']));


                            $stmtExcel_archive = $this->db->prepare("INSERT INTO uesr_add_excel (code,quantity,price,type,number_bill,`date`,normal_date,username,wholesale_price,wholesale_price2,cost_price,model)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                            $stmtExcel_archive->execute(array($row['code'],$qty, $row['price_sale'],'شراء','شراء',time(),date('Y-m-d h:i A',time()),$this->userid,$row['wholesale_price'],$row['wholesale_price2'],$row['cost_price'],$row['table']));

                        }



                        if (!empty($row['location'])) {

                            $stmt_ch_location = $this->db->prepare("SELECT *FROM  location  WHERE code =? AND  model=? AND location=?");
                            $stmt_ch_location->execute(array($row['code'], $row['table'], trim($row['location'])));
                            if ($stmt_ch_location->rowCount() > 0) {
                                $stmtExcel_conform = $this->db->prepare("UPDATE location SET  quantity=quantity + {$qty} ,userid=?,`date`=?  WHERE code =? AND  model=? AND location=?");
                                $stmtExcel_conform->execute(array($this->userid,time(), $row['code'], $row['table'], trim($row['location'])));
                                if($stmtExcel_conform->rowCount()  > 0)
                                {
                                    $this->filter_location_tracking_quantity($row['code'],$row['table'], trim($row['location']),$qty,' شراء جهاز - رقم41','+',$number_bill);

                                }else
                                {
                                    $this->filter_location_error_quantity($row['code'],$row['table'], trim($row['location']),$qty,'  شراء جهاز - رقم الخظأ 41','+',$number_bill);

                                }
                            } else {

                                $stmtModelLOcation = $this->db->prepare("SELECT sequence FROM `location_model`  WHERE `location` LIKE ?  AND `model` =?   LIMIT 1");
                                $stmtModelLOcation->execute(array(trim($row['location']), $row['table']));
                                $sequence=0;
                                if ($stmtModelLOcation->rowCount() >0)
                                {
                                    $sequence = $stmtModelLOcation->fetch(PDO::FETCH_ASSOC)['sequence'];

                                }

                                $stmtExcel_conform = $this->db->prepare("INSERT INTO location (sequence,quantity,`date`,code,model,location,userid) VALUES (?,?,?,?,?,?,?)");
                                $stmtExcel_conform->execute(array($sequence,$qty, time(), $row['code'], $row['table'], trim($row['location']),$this->userid));
                                if($stmtExcel_conform->rowCount()  > 0)
                                {
                                    $this->filter_location_tracking_quantity($row['code'],$row['table'], trim($row['location']),$qty,' شراء جهاز - رقم42','+',$number_bill);

                                }else
                                {
                                    $this->filter_location_error_quantity($row['code'],$row['table'], trim($row['location']),$qty,'  شراء جهاز - رقم الخظأ 42','+',$number_bill);

                                }
                            }
                        }else
                        {

                            $stmtChCodeConform = $this->db->prepare("SELECT *FROM location_confirm WHERE code =? AND model=?");
                            $stmtChCodeConform->execute(array($row['code'],$row['table']));
                            if ($stmtChCodeConform->rowCount() > 0) {
                                $stmtExcel_conform = $this->db->prepare("UPDATE location_confirm SET  quantity=quantity+ {$qty},`date`=?  WHERE code =? AND  model=?");
                                $stmtExcel_conform->execute(array(time(), $row['code'],$row['table']));

                                if($stmtExcel_conform->rowCount() <=0)
                                {
                                    $this->filter_error_quantity( $row['code'],$row['table'],$qty,' محاسبة فاتورة شراء   - رقم الخطا 11',$number_bill);
                                }


                            }else
                            {

                                $stmtExcel_conform = $this->db->prepare("INSERT INTO  location_confirm (quantity,code,model,date)  values (?,?,?,?)");
                                $stmtExcel_conform->execute(array($qty,$row['code'],$row['table'],time()));
                                if($stmtExcel_conform->rowCount() <=0)
                                {
                                    $this->filter_error_quantity( $row['code'],$row['table'],$qty,' محاسبة فاتورة شراء   - رقم الخطا 12',$number_bill);
                                }
                            }

                        }

                        $this->Add_to_sync_schedule($row['code'],$row['table'],'quantity_adjustment',' ',' controllers\purchase_customer\purchase_customer.php 915 '.$this->UserInfo($this->userid));

                    }

                    echo 'true';
                }


            }
        }
        $this->AddToTraceByFunction($this->userid,'purchase_customer','pay/'.$id_customer.'/'.$number_bill);
    }


    function sumbill($number_bill)
    {

        $stmt = $this->db->prepare("SELECT *FROM purchase_customer_item WHERE number_bill=?  ");
        $stmt->execute(array($number_bill));
        $sum = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $s = (int)$row['quantity'] * (int)$row['price_purchase'];
            $sum = (int)$sum + $s;
        }

        return $sum;

    }

    function sumbillall($id)
    {

        $stmt = $this->db->prepare("SELECT *FROM purchase_customer_bill WHERE userid=? AND active=1");
        $stmt->execute(array($id));
        $sum = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $stmtsum = $this->db->prepare("SELECT *FROM purchase_customer_item WHERE  id_bill=? AND id_customer=? AND number_bill=?");
            $stmtsum->execute(array($row['id'], $row['id_customer'], $row['number_bill']));

            while ($rowsum = $stmtsum->fetch(PDO::FETCH_ASSOC)) {
                $s = (int)$rowsum['quantity'] * (int)$rowsum['price_purchase'];
                $sum = (int)$sum + (int)$s;
            }

        }

        return $sum;

    }

    function sumbillDate($id, $fromdate, $todate)
    {

        $stmt = $this->db->prepare("SELECT *FROM purchase_customer_bill WHERE userid=? AND active=1 AND date_account between ? AND ?");
        $stmt->execute(array($id, $fromdate, $todate));
        $sum = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


            $stmtsum = $this->db->prepare("SELECT *FROM purchase_customer_item WHERE  id_bill=? AND id_customer=? AND number_bill=?");
            $stmtsum->execute(array($row['id'], $row['id_customer'], $row['number_bill']));

            while ($rowsum = $stmtsum->fetch(PDO::FETCH_ASSOC)) {
                $s = (int)$rowsum['quantity'] * (int)$rowsum['price_purchase'];
                $sum = (int)$sum + (int)$s;
            }
        }

        return $sum;


    }


    public function bills_enter()
    {
        $this->checkPermit('bills_enter', $this->folder);
        $this->adminHeaderController($this->langControl('bills_enter'));


        $date = null;
        $todate = null;

        $from_date_stm = null;
        $to_date_stm = null;

        if (isset($_GET['date']) && isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm = strtotime($date);
            $to_date_stm = strtotime($todate);

        }


        require($this->render($this->folder, 'enter', 'bills_enter', 'php'));
        $this->adminFooterController();
    }


    public function processing_bills_enter($from_date_stm = null, $to_date_stm = null)
    {

        $table = 'purchase_customer_bill';
        $primaryKey = 'purchase_customer_bill.id';

        $columns = array(
            array('db' => 'register_user.name', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),
            array('db' => 'register_user.phone', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),
            array('db' => 'purchase_customer_bill.number_bill', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return "<a href='" . url . '/' . $this->folder . "/details/{$d}'>{$d}</a>";
                }
            ),

            array('db' => 'purchase_customer_bill.number_bill', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return number_format($this->sumBill($d));
                }
            ),

            array('db' => 'purchase_customer_bill.crystal_bill', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return $d;
                }
            ),

            array('db' => 'purchase_customer_bill.crystal_bill', 'dt' => 5,
                'formatter' => function ($d, $row) {

                    if ($this->permit('edit_bill', $this->folder)) {

                        if (!empty($row[10]) && $row[11] == 0 && $row[12] == 1) {
                            return "
					 <div class='row justify-content-center align-items-center'>
					  <div class='col-auto' style='padding-left: 2px'>		
							   <input id='numberBill_{$row[3]}'  value='{$d}' type='text' class='form-control withBill' name='crystal_bill' required>
					   </div>
					  <div class='col-auto' style='padding-right: 2px'>
					   <button type='submit' id='btn_in_bill_{$row[3]}' onclick=saveBill('" . $row[3] . "')  name='submit' class='btn btn-success'>حفظ</button>
					  </div>
					  </div>
					";
                        } else {
                            return "
					 <div class='row justify-content-center align-items-center'>
					  <div class='col-auto' style='padding-left: 2px'>		
							   <input id='numberBill_{$row[3]}'  value='{$d}' type='text' class='form-control withBill' name='crystal_bill' required>
					   </div>
					  <div class='col-auto' style='padding-right: 2px'>
					   <button type='submit' id='btn_in_bill_{$row[3]}' onclick=saveBill('" . $row[3] . "')  name='submit' class='btn btn-warning'>حفظ</button>
					  </div>
					  </div>
					";
                        }


                    }

                }
            ),


            array('db' => 'purchase_customer_bill.userid', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }
            ),

            array('db' => 'purchase_customer_bill.date_account', 'dt' => 7,

                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }

            ),

            array('db' => 'purchase_customer_bill.user_enter', 'dt' => 8,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }

            ),
            array('db' => 'purchase_customer_bill.date_enter', 'dt' => 9,

                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }

            ),


            array('db' => 'purchase_customer_bill.crystal_bill', 'dt' => 10),
            array('db' => 'purchase_customer_bill.edit', 'dt' => 11),
            array('db' => 'purchase_customer_bill.checked', 'dt' => 12),


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "inner JOIN register_user ON register_user.id = purchase_customer_bill.id_customer  left JOIN user ON user.id = purchase_customer_bill.userid  ";
        if (empty($from_date_stm) && empty($to_date_stm)) {
            $whereAll = array("purchase_customer_bill.active = 1","purchase_customer_bill.cancel = 0", "purchase_customer_bill.crystal_bill <> ''");

        } else {
            $whereAll = array("purchase_customer_bill.active = 1","purchase_customer_bill.cancel = 0", "purchase_customer_bill.date_enter BETWEEN {$from_date_stm} AND {$to_date_stm}");

        }


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));

    }


    public function bills_note_enter()
    {
        $this->checkPermit('bills_note_enter', $this->folder);
        $this->adminHeaderController($this->langControl('bills_note_enter'));


        $date = null;
        $todate = null;

        $from_date_stm = null;
        $to_date_stm = null;

        if (isset($_GET['date']) && isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm = strtotime($date);
            $to_date_stm = strtotime($todate);

        }

        $stmt = $this->db->prepare("SELECT  purchase_customer_bill.number_bill FROM `purchase_customer_bill`     WHERE   purchase_customer_bill.number_bill not in(SELECT number_bill FROM {$this->group_bill})  AND purchase_customer_bill.crystal_bill = '' AND purchase_customer_bill.active = 1  ") ;
        $stmt->execute();
        $bill=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {

                $bill[]=$row['number_bill'];

        }


        require($this->render($this->folder, 'enter', 'bills_note_enter', 'php'));
        $this->adminFooterController();
    }


    public function processing_bills_note_enter($from_date_stm = null, $to_date_stm = null)
    {

        $table = 'purchase_customer_bill';
        $primaryKey = 'purchase_customer_bill.id';

        $columns = array(
            array('db' => 'register_user.name', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),
            array('db' => 'register_user.phone', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),
            array('db' => 'purchase_customer_bill.number_bill', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return "<a href='" . url . '/' . $this->folder . "/details/{$d}'>{$d}</a>";
                }
            ),

            array('db' => 'purchase_customer_bill.number_bill', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return number_format($this->sumBill($d));
                }
            ),

            array('db' => 'purchase_customer_bill.crystal_bill', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    if ($this->permit('enter_bill', $this->folder)) {

                        return "
					 <div class='row justify-content-center align-items-center'>
					  <div class='col-auto' style='padding-left: 2px'>		
							   <input id='numberBill_{$row[3]}'  value='{$d}' type='text' class='form-control withBill' name='crystal_bill' required>
					   </div>
					  <div class='col-auto' style='padding-right: 2px'>
					   <button type='submit' id='btn_in_bill_{$row[3]}' onclick=saveBill('" . $row[3] . "')  name='submit' class='btn btn-warning'>حفظ</button>
					  </div>
					  </div>
					";
                    } else {
                        return 'لا تمتلك صلاحية';
                    }

                }
            ),


            array('db' => 'purchase_customer_bill.userid', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }
            ),

            array('db' => 'purchase_customer_bill.date_account', 'dt' => 6,

                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }

            ),


            array('db' => 'purchase_customer_bill.number_bill', 'dt' => 7),


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "inner JOIN register_user ON register_user.id = purchase_customer_bill.id_customer  left JOIN user ON user.id = purchase_customer_bill.userid  ";
        if (empty($from_date_stm) && empty($to_date_stm)) {
            $whereAll = array("purchase_customer_bill.active = 1","purchase_customer_bill.cancel = 0", "purchase_customer_bill.crystal_bill = ''");

        } else {

            $whereAll = array("purchase_customer_bill.active = 1","purchase_customer_bill.cancel = 0", "purchase_customer_bill.crystal_bill = ''", "purchase_customer_bill.date_enter BETWEEN {$from_date_stm} AND {$to_date_stm}");


        }


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));

    }


    public function bills_note_checked()
    {
        $this->checkPermit('bills_note_checked', $this->folder);
        $this->adminHeaderController($this->langControl('bills_note_checked'));


        $date = null;
        $todate = null;

        $from_date_stm = null;
        $to_date_stm = null;

        if (isset($_GET['date']) && isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm = strtotime($date);
            $to_date_stm = strtotime($todate);

        }


        require($this->render($this->folder, 'enter', 'note_checked', 'php'));
        $this->adminFooterController();
    }


    public function processing_bills_note_checked($from_date_stm = null, $to_date_stm = null)
    {

        $table = 'purchase_customer_bill';
        $primaryKey = 'purchase_customer_bill.id';

        $columns = array(

            array('db' => $table . '.number_bill', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return "<input type='checkbox'    class='childcheckbox'  name='number_bill[]' value='{$d}'>";
                }
            ),


            array('db' => 'register_user.name', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),
            array('db' => 'register_user.phone', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),
            array('db' => 'purchase_customer_bill.number_bill', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return "<a href='" . url . '/' . $this->folder . "/details/{$d}'>{$d}</a>";
                }
            ),

            array('db' => 'purchase_customer_bill.number_bill', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return number_format($this->sumBill($d));
                }
            ),

            array('db' => 'purchase_customer_bill.crystal_bill', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return $d;
                }
            ),

            array('db' => 'purchase_customer_bill.crystal_bill', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    return "
					 <div class='row justify-content-center align-items-center'>
					  <div class='col-auto' style='padding-right: 2px'>
					   <button type='button' id='btn_in_bill_{$row[11]}' onclick=checked_bill('" . $row[11] . "')  name='submit' class='btn btn-primary'>موافق</button>
					  </div>
					  </div>
					";

                }
            ),


            array('db' => 'purchase_customer_bill.userid', 'dt' => 7,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }
            ),

            array('db' => 'purchase_customer_bill.date_account', 'dt' => 8,

                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }

            ),

            array('db' => 'purchase_customer_bill.user_enter', 'dt' => 9,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }

            ),
            array('db' => 'purchase_customer_bill.date_enter', 'dt' => 10,

                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }

            ),
            array('db' => 'purchase_customer_bill.number_bill', 'dt' => 11),


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "inner JOIN register_user ON register_user.id = purchase_customer_bill.id_customer  left JOIN user ON user.id = purchase_customer_bill.userid  ";
        if (empty($from_date_stm) && empty($to_date_stm)) {
            $whereAll = array("purchase_customer_bill.active = 1","purchase_customer_bill.cancel = 0", "purchase_customer_bill.crystal_bill <> ''", "purchase_customer_bill.checked = 0");

        } else {
            $whereAll = array("purchase_customer_bill.active = 1","purchase_customer_bill.cancel = 0", "purchase_customer_bill.crystal_bill <> ''", "purchase_customer_bill.checked = 0", "purchase_customer_bill.date_checked BETWEEN {$from_date_stm} AND {$to_date_stm}");

        }


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));

    }





    public function bills_cancel()
    {
        $this->checkPermit('bills_cancel', $this->folder);
        $this->adminHeaderController($this->langControl('bills_cancel'));


        $date = null;
        $todate = null;

        $from_date_stm = null;
        $to_date_stm = null;

        if (isset($_GET['date']) && isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm = strtotime($date);
            $to_date_stm = strtotime($todate);

        }


        require($this->render($this->folder, 'enter', 'bills_cancel', 'php'));
        $this->adminFooterController();
    }


    public function processing_bills_cancel($from_date_stm = null, $to_date_stm = null)
    {

        $table = 'purchase_customer_bill';
        $primaryKey = 'purchase_customer_bill.id';

        $columns = array(
            array('db' => 'register_user.name', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),
            array('db' => 'register_user.phone', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),
            array('db' => 'purchase_customer_bill.number_bill', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return "<a href='" . url . '/' . $this->folder . "/details/{$d}'>{$d}</a>";
                }
            ),

            array('db' => 'purchase_customer_bill.number_bill', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return number_format($this->sumBill($d));
                }
            ),



            array('db' => 'purchase_customer_bill.user_cancel', 'dt' =>4,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }
            ),

            array('db' => 'purchase_customer_bill.date_cancel', 'dt' =>5,

                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }

            ),

        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "inner JOIN register_user ON register_user.id = purchase_customer_bill.id_customer  left JOIN user ON user.id = purchase_customer_bill.userid  ";
        if (empty($from_date_stm) && empty($to_date_stm)) {
            $whereAll = array("purchase_customer_bill.cancel = 1");

        } else {
            $whereAll = array("purchase_customer_bill.cancel = 1", "purchase_customer_bill.date_enter BETWEEN {$from_date_stm} AND {$to_date_stm}");

        }


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));

    }









    function checked_all()
    {
        if ($this->handleLogin()) {

            if (isset($_REQUEST['number_bill'])) {
                $myArray = $_REQUEST['number_bill'];
                $ids = implode(',', $myArray);
                $stmt_up = $this->db->prepare("UPDATE  `purchase_customer_bill` SET  checked=1 , user_checked=?, date_checked=?   WHERE   `number_bill` IN ({$ids})  ");
                $stmt_up->execute(array($this->userid, time()));
                if ($stmt_up->rowCount() > 0) {
                    echo '1';
                }
            }
        }
    }


    public function bills_checked()
    {
        $this->checkPermit('bills_enter', $this->folder);
        $this->adminHeaderController($this->langControl('bills_enter'));


        $date = null;
        $todate = null;

        $from_date_stm = null;
        $to_date_stm = null;

        if (isset($_GET['date']) && isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm = strtotime($date);
            $to_date_stm = strtotime($todate);
        }


        require($this->render($this->folder, 'enter', 'bills_checked', 'php'));
        $this->adminFooterController();
    }


    public function processing_bills_checked($from_date_stm = null, $to_date_stm = null)
    {

        $table = 'purchase_customer_bill';
        $primaryKey = 'purchase_customer_bill.id';

        $columns = array(
            array('db' => 'register_user.name', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),
            array('db' => 'register_user.phone', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),
            array('db' => 'purchase_customer_bill.number_bill', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),

            array('db' => 'purchase_customer_bill.number_bill', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return number_format($this->sumBill($d));
                }
            ),

            array('db' => 'purchase_customer_bill.crystal_bill', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return $d;
                }
            ),

            array('db' => 'purchase_customer_bill.crystal_bill', 'dt' => 5,
                'formatter' => function ($d, $row) {

                    return '<i style="color: green" class="fa fa-check-circle"></i>';
                }

            ),


            array('db' => 'purchase_customer_bill.userid', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }
            ),

            array('db' => 'purchase_customer_bill.date_account', 'dt' => 7,

                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }

            ),

            array('db' => 'purchase_customer_bill.user_checked', 'dt' => 8,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }

            ),
            array('db' => 'purchase_customer_bill.date_checked', 'dt' => 9,

                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }

            ),


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "inner JOIN register_user ON register_user.id = purchase_customer_bill.id_customer  left JOIN user ON user.id = purchase_customer_bill.userid  ";
        if (empty($from_date_stm) && empty($to_date_stm)) {
            $whereAll = array("purchase_customer_bill.active = 1","purchase_customer_bill.cancel = 0", "purchase_customer_bill.crystal_bill <> ''", "purchase_customer_bill.checked = 1");

        } else {
            $whereAll = array("purchase_customer_bill.active = 1","purchase_customer_bill.cancel = 0", "purchase_customer_bill.crystal_bill <> ''", "purchase_customer_bill.checked = 1", "purchase_customer_bill.date_enter BETWEEN {$from_date_stm} AND {$to_date_stm}");

        }


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));

    }


    public function bills_edit()
    {
        $this->checkPermit('bills_edit', $this->folder);
        $this->adminHeaderController($this->langControl('bills_edit'));


        $date = null;
        $todate = null;

        $from_date_stm = null;
        $to_date_stm = null;

        if (isset($_GET['date']) && isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm = strtotime($date);
            $to_date_stm = strtotime($todate);

        }

        require($this->render($this->folder, 'enter', 'bills_edit', 'php'));
        $this->adminFooterController();
    }


    public function processing_bills_edit($from_date_stm = null, $to_date_stm = null)
    {

        $table = 'purchase_customer_bill';
        $primaryKey = 'purchase_customer_bill.id';

        $columns = array(
            array('db' => 'register_user.name', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),
            array('db' => 'register_user.phone', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),
            array('db' => 'purchase_customer_bill.number_bill', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),

            array('db' => 'purchase_customer_bill.number_bill', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return number_format($this->sumBill($d));
                }
            ),

            array('db' => 'purchase_customer_bill.crystal_bill', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return $d;
                }
            ),


            array('db' => 'purchase_customer_bill.userid', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }
            ),

            array('db' => 'purchase_customer_bill.date_account', 'dt' => 6,

                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }

            ),

            array('db' => 'purchase_customer_bill.user_edit', 'dt' => 7,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }

            ),
            array('db' => 'purchase_customer_bill.date_edit', 'dt' => 8,

                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }

            ),


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "inner JOIN register_user ON register_user.id = purchase_customer_bill.id_customer  left JOIN user ON user.id = purchase_customer_bill.userid  ";
        if (empty($from_date_stm) && empty($to_date_stm)) {
            $whereAll = array("purchase_customer_bill.active = 1","purchase_customer_bill.cancel = 0", "purchase_customer_bill.edit =1 ");

        } else {
            $whereAll = array("purchase_customer_bill.active = 1","purchase_customer_bill.cancel = 0", "purchase_customer_bill.edit =1 ", "purchase_customer_bill.date_edit BETWEEN {$from_date_stm} AND {$to_date_stm}");
        }


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));

    }


    function crystal_bill()
    {
        if ($this->handleLogin()) {

            $number_bill = trim(str_replace(' ', '', $_GET['number_bill']));
            $crystal_bill = trim(str_replace(' ', '', $_GET['crystal_bill']));


            $stmt = $this->db->prepare("SELECT *FROM `purchase_customer_bill` WHERE  `number_bill` =? AND crystal_bill = ''");
            $stmt->execute(array($number_bill));
            if ($stmt->rowCount() > 0) {
                $stmt_up = $this->db->prepare("UPDATE  `purchase_customer_bill` SET  crystal_bill=? , user_enter=?, date_enter=?  WHERE  `number_bill` =?  ");
                $stmt_up->execute(array($crystal_bill, $this->userid, time(), $number_bill));
                if ($stmt_up->rowCount() > 0) {
                    echo '1';

                }

            } else {
                $stmt_up = $this->db->prepare("UPDATE  `purchase_customer_bill` SET  crystal_bill=? , user_edit=?, date_edit=?,`edit`=1,`checked`=0  WHERE  `number_bill` =?  ");
                $stmt_up->execute(array($crystal_bill, $this->userid, time(), $number_bill));
                if ($stmt_up->rowCount() > 0) {
                    echo '1';

                }

            }


        }
    }


    function checked_bill()
    {

        if ($this->handleLogin()) {
            $number_bill = $_GET['number_bill'];
            $stmt_up = $this->db->prepare("UPDATE  `purchase_customer_bill` SET  checked=1 , user_checked=?, date_checked=?,edit=0   WHERE  `number_bill` =?  ");
            $stmt_up->execute(array($this->userid, time(), $number_bill));
            if ($stmt_up->rowCount() > 0) {
                echo '1';
            }
        }

    }


    function chbill()
    {
        $h1 = date('Y-m-d h:00:00 a', time());

        $timestamp = strtotime($h1) + 60 * 60;

        $h2 = date('Y-m-d h:i:s a', $timestamp);

        $t1 = strtotime($h1);
        $t2 = strtotime($h2);

        $number_bill = array();

        $stmt = $this->db->prepare("SELECT   number_bill FROM `purchase_customer_bill`  WHERE crystal_bill <> ''   AND  ( date_edit between ? AND ?  OR    date_enter between ? AND ? )");
        $stmt->execute(array($t1, $t2, $t1, $t2));
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $number_bill[] = $row['number_bill'];
            }
            echo json_encode($number_bill);
        }


    }

    function new_price_purchase()
    {
        $price = (int)str_replace($this->comma, '', $_GET['price']);
        if (is_numeric($price)) {

            $id_customer = $_GET['id_customer'];
            $id_row = $_GET['id_row'];
            $number_bill = $_GET['number_bill'];
            $table = $_GET['table'];


            $stmtch = $this->db->prepare("SELECT *FROM purchase_customer_item WHERE id=? AND id_customer =? AND number_bill=? AND  `table`=?     LIMIT 1");
            $stmtch->execute(array($id_row, $id_customer, $number_bill, $table));
            if ($stmtch->rowCount() > 0) {

                $stmtup = $this->db->prepare("UPDATE  purchase_customer_item  SET price_purchase=? ,user_edit_price=? WHERE  id=? AND id_customer =? AND number_bill=? AND  `table`=? ");
                $stmtup->execute(array($price, $this->userid, $id_row, $id_customer, $number_bill, $table));
                if ($stmtup->rowCount() > 0) {
                    echo 'edit';
                }
            } else {
                echo 'not_found';
            }

        } else {
            echo 'xprice';
        }
    }


    function new_price_sale()
    {
        $price = $_GET['price'];
        if (is_numeric($price)) {

            $id_customer = $_GET['id_customer'];
            $id_row = $_GET['id_row'];
            $number_bill = $_GET['number_bill'];
            $table = $_GET['table'];


            $stmtch = $this->db->prepare("SELECT *FROM purchase_customer_item WHERE id=? AND id_customer =? AND number_bill=? AND  `table`=?     LIMIT 1");
            $stmtch->execute(array($id_row, $id_customer, $number_bill, $table));
            if ($stmtch->rowCount() > 0) {
                $result = $stmtch->fetch(PDO::FETCH_ASSOC);
                $cde = $result['code'];


                $stmtup = $this->db->prepare("UPDATE  purchase_customer_item  SET price_sale=? ,user_edit_dollar=? WHERE  id=? AND id_customer =? AND number_bill=? AND  `table`=? ");
                $stmtup->execute(array($price, $this->userid, $id_row, $id_customer, $number_bill, $table));
                if ($stmtup->rowCount() > 0) {

                    if ($table == 'mobile') {
                        $excel = 'excel';
                    } else {

                        $excel = 'excel_' . $table;

                    }
                    $stmtExcel = $this->db->prepare('UPDATE {$excel} SET  price_dollars=?,range1 = ? ,range2 = ? WHERE code =?');
                    $stmtExcel->execute(array($price, $this->min_price($price), $this->max_price($price), $cde));


                    echo 'edit';
                    $this->AddToTraceByFunction($this->userid,'purchase_customer','new_quantity/'.$id_row.'/'.$id_customer.'/'.$number_bill.'/'.$table.'/'.strval($quantity));

                }
            } else {
                echo 'not_found';
            }

        } else {
            echo 'xprice';
        }
    }


    function new_quantity()
    {

        if ($this->handleLogin()) {

            $quantity = (int)str_replace($this->comma, '', $_GET['quantity']);
            if (is_numeric($quantity)) {

                $id_customer = $_GET['id_customer'];
                $id_row = $_GET['id_row'];
                $number_bill = $_GET['number_bill'];
                $table = $_GET['table'];


                $stmtch = $this->db->prepare("SELECT *FROM purchase_customer_item WHERE id=? AND id_customer =? AND number_bill=? AND  `table`=?     LIMIT 1");
                $stmtch->execute(array($id_row, $id_customer, $number_bill, $table));
                if ($stmtch->rowCount() > 0) {

                    $result = $stmtch->fetch(PDO::FETCH_ASSOC);
                    $cde = $result['code'];


                    $stmtup = $this->db->prepare("UPDATE  purchase_customer_item  SET quantity=? ,user_edit_quantity=? WHERE  id=? AND id_customer =? AND number_bill=? AND  `table`=? ");
                    $stmtup->execute(array($quantity, $this->userid, $id_row, $id_customer, $number_bill, $table));
                    if ($stmtup->rowCount() > 0) {
                        if ($table == 'mobile') {
                            $excel = 'excel';
                        } else {

                            $excel = 'excel_' . $table;

                        }

                        $quantity = $quantity - $result['quantity'];
                        if ($quantity > 0) {
                            $stmtExcel = $this->db->prepare('UPDATE {$excel} SET  quantity=quantity+?  WHERE code =?');
                            $stmtExcel->execute(array($quantity, $cde));
                        } else {
                            $stmtExcel = $this->db->prepare('UPDATE {$excel} SET  quantity=quantity-?  WHERE code =?');
                            $stmtExcel->execute(array(abs($quantity), $cde));
                        }


                        echo 'edit';

                        $this->AddToTraceByFunction($this->userid,'purchase_customer','new_quantity/'.$id_row.'/'.$id_customer.'/'.$number_bill.'/'.$table.'/'.strval($quantity));


                    }
                } else {
                    echo 'not_found';
                }

            } else {
                echo 'xquantity';
            }
        }
    }


    function cancel_bill()
    {

        if ($this->handleLogin()) {

            $id_customer = $_GET['id_customer'];
            $number_bill = $_GET['number_bill'];


            $stmtup = $this->db->prepare("UPDATE  purchase_customer_bill SET cancel=? ,user_cancel=?,date_cancel=? WHERE   id_customer =? AND number_bill=?   ");
            $stmtup->execute(array(1, $this->userid,time(), $id_customer, $number_bill));
            if ($stmtup->rowCount() > 0) {
                echo 'true';
            }

        }

    }


    function all_purchase_customer_note_enter_bill()
    {

        $stmt = $this->db->prepare("SELECT  count(*)  FROM `purchase_customer_bill`  WHERE  purchase_customer_bill.active = 1  AND purchase_customer_bill.crystal_bill = '' AND purchase_customer_bill.cancel = 0 ");
        $stmt->execute();
        return $stmt->fetchColumn() ;

    }


    function add_group()
    {

        $this->checkPermit('add_group', $this->folder);
        $stmt = $this->db->prepare("SELECT  purchase_customer_bill.number_bill FROM `purchase_customer_bill`    WHERE purchase_customer_bill.number_bill not in(SELECT number_bill FROM {$this->group_bill})  AND   purchase_customer_bill.crystal_bill = '' AND purchase_customer_bill.active = 1  ") ;
        $stmt->execute();
        $bill=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $bill[]=$row['number_bill'];

        }


        if (!empty($bill)) {

            $number = 1;
            $stmt_sq = $this->db->prepare("SELECT `number` FROM {$this->group_bill} ORDER BY `number` DESC  LIMIT 1");
            $stmt_sq->execute();
            if ($stmt_sq->rowCount() > 0) {
                $num = $stmt_sq->fetch(PDO::FETCH_ASSOC);
                $number = $num['number'] + 1;
            }

            $time=time();
            $values="";

            $list_bill=implode(',',$bill);
            foreach ($bill as $data)
            {
                $values.="(
                    '{$list_bill}',
                    '{$data}',
                    '{$number}',
                    {$this->userid},
                    {$time}
                   )," ;
            }

            $values=rtrim($values, ',');
            $stmt_add=$this->db->prepare("INSERT INTO {$this->group_bill} (`name`, `number_bill`, `number`, `userid`, `date`) values {$values}");
            $stmt_add->execute();
            if ($stmt_add->rowCount() > 0)
            {
                echo $number;
            }
        }


    }



    public function export_group($number)
    {
        $this->checkPermit('export_group', $this->folder);
        $this->adminHeaderController($this->langControl('export_group'));



        if (!is_numeric($number))
        {
            $error=new Errors();
            $error->index();
        }


        $stmt = $this->db->prepare("SELECT   * FROM {$this->group_bill}    WHERE  number=?   LIMIT 1") ;
        $stmt->execute(array($number));
        if ($stmt->rowCount() < 1)
        {
            $error=new Errors();
            $error->index();
        }

        $result=$stmt->fetch(PDO::FETCH_ASSOC);

        $date=null;
        $todate=null;

        $from_date_stm=null;
        $to_date_stm=null;

        if (isset($_GET['date'])&&isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);

        }


        require($this->render($this->folder, 'group', 'bills_materials_not_enter', 'php'));
        $this->adminFooterController();
    }


    public function processing_bill_materials_crystal_not_enter($number,$from_date_stm=null,$to_date_stm=null)
    {




        $table = $this->purchase_customer_item;
        $primaryKey = $this->purchase_customer_item.'.id';

        $columns = array(

            array('db' => $table.'.code', 'dt' => 0   ),
            array('db' => $table.'.serial', 'dt' => 1   ),
            array('db' => $table.'.quantity', 'dt' =>2   ),

            array('db' => $table.'.code', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return  $this->storehouse_export($row[12],$d,$row[11]);
                }
            ),

            array('db' => $table.'.price_purchase', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return number_format($d);
                }
            ),
            array('db' => $table.'.price_purchase', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return number_format($d);
                }
            ),
            array('db' => $table.'.price_sale', 'dt' => 6 ),


            array('db' => $table.'.number_bill', 'dt' => 7,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/details/{$d}'>{$d}</a>";
                }
            ),


            array('db' => $table.'.number_bill', 'dt' => 8,
                'formatter' => function ($d, $row) {
                    return "<div class='text-right'>{$this->customerInfo($row[10])},{$this->user_acc($d)},{$this->user_purchase($d)},{$d},{$row[9]} </div>";
                }

            ),

            array('db' =>$table.'.note', 'dt' =>9 ),
            array('db' =>$table.'.id_customer', 'dt' =>10 ),
            array('db' =>$table.'.table', 'dt' =>11 ),
            array('db' =>$table.'.location', 'dt' =>12 ),



        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "inner JOIN purchase_customer_bill ON purchase_customer_bill.number_bill = purchase_customer_item.number_bill inner JOIN purchase_customer_group_bill ON purchase_customer_group_bill.number_bill = purchase_customer_item.number_bill  ";
        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array("purchase_customer_bill.cancel=0","purchase_customer_group_bill.number  = {$number}");

        }else{
            $whereAll = array("purchase_customer_bill.cancel=0","purchase_customer_group_bill.date BETWEEN {$from_date_stm} AND {$to_date_stm}","purchase_customer_group_bill.number  = {$number}");
        }


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null));

    }


    function user_acc($n)
    {

        $stmt = $this->db->prepare("SELECT   userid FROM `purchase_customer_bill`    WHERE   number_bill =?") ;
        $stmt->execute(array($n));
        if ($stmt->rowCount() > 0)
        {
            $r=$stmt->fetch(PDO::FETCH_ASSOC);
            return $this->UserInfo($r['userid'],'c');
        }
    }

    function user_purchase($n)
    {

        $stmt = $this->db->prepare("SELECT   user_purchase FROM `purchase_customer_bill`    WHERE   number_bill =?") ;
        $stmt->execute(array($n));
        if ($stmt->rowCount() > 0)
        {
            $r=$stmt->fetch(PDO::FETCH_ASSOC);
            return $this->UserInfo($r['user_purchase'],'c');
        }
    }


    function group_not_enter()
    {

        $this->checkPermit('group_not_enter', $this->folder);
        $this->AdminHeaderController($this->langControl('group_not_enter'));


        $stmt = $this->db->prepare("SELECT  purchase_customer_bill.number_bill FROM `purchase_customer_bill`    WHERE purchase_customer_bill.number_bill not in(SELECT number_bill FROM {$this->group_bill})  AND   purchase_customer_bill.crystal_bill = '' AND purchase_customer_bill.active = 1  ") ;
        $stmt->execute();
        $bill=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $bill[]=$row['number_bill'];

        }

        $date=null;
        $todate=null;

        $from_date_stm=null;
        $to_date_stm=null;

        if (isset($_GET['date'])&&isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);

        }


        require($this->render($this->folder, 'group', 'group_not_enter', 'php'));
        $this->AdminFooterController();

    }



    public function processing_group_not_enter($from_date_stm=null,$to_date_stm=null)
    {

        $table = $this->group_bill;
        $primaryKey = $this->group_bill.'.id';

        $columns = array(


            array('db' => $table.'.number', 'dt' => 0  ),

            array('db' => $table.'.name', 'dt' => 1  ),
            array('db' => $table.'.userid', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return  $this->UserInfo($d);
                }
            ),



            array('db' => $table.'.date', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i a',$d);
                }
            ),


            array('db' => $table.'.number', 'dt' => 4,
                'formatter' => function ($d, $row) {

                    return "
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-auto' style='padding-left: 2px'>		
				  	       <input id='numberBill_{$d}'  type='text' class='form-control withBill' name='crystal_bill' autocomplete='off' required>
                   </div>
				  <div class='col-auto' style='padding-right: 2px'>
				   <button type='submit' id='btn_in_bill_{$d}' onclick=saveBill('".$d."')  name='submit' class='btn btn-warning'>حفظ</button>
                  </div>
                  </div>
                    " ;
                }
            ),

            array('db' => $table.'.number', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/export_group/{$d}'><span>تصدير مواد الفواتير</span></a>";
                }
            ),

            array('db' =>$table.'.number', 'dt' => 6),//7




        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = " left JOIN purchase_customer_bill ON purchase_customer_bill.crystal_bill = {$this->group_bill}.crystal_bill ";
        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array("{$this->group_bill}.crystal_bill  = '' ");

        }else{
            $whereAll = array("{$this->group_bill}.crystal_bill  = '' ","{$this->group_bill}.date BETWEEN {$from_date_stm} AND {$to_date_stm}" );

        }
        $group="GROUP BY  {$this->group_bill}.number";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

    }





    function group_enter()
    {

        $this->checkPermit('group_not_enter', $this->folder);
        $this->AdminHeaderController($this->langControl('group_not_enter'));


        $stmt = $this->db->prepare("SELECT  purchase_customer_bill.number_bill FROM `purchase_customer_bill`    WHERE purchase_customer_bill.number_bill not in(SELECT number_bill FROM {$this->group_bill})  AND   purchase_customer_bill.crystal_bill = '' AND purchase_customer_bill.active = 1  ") ;
        $stmt->execute();
        $bill=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $bill[]=$row['number_bill'];

        }

        $date=null;
        $todate=null;

        $from_date_stm=null;
        $to_date_stm=null;

        if (isset($_GET['date'])&&isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);

        }


        require($this->render($this->folder, 'group', 'group_enter', 'php'));
        $this->AdminFooterController();

    }



    public function processing_group_enter($from_date_stm=null,$to_date_stm=null)
    {

        $table = $this->group_bill;
        $primaryKey = 'id';

        $columns = array(


            array('db' => 'number', 'dt' => 0  ),

            array('db' => 'name', 'dt' => 1  ),
            array('db' => 'userid', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return  $this->UserInfo($d);
                }
            ),


            array('db' => 'user_input_bill', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return  $this->UserInfo($d);
                }
            ),



            array('db' => 'date', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i a',$d);
                }
            ),

            array('db' => 'crystal_bill', 'dt' => 5  ),

            array('db' => 'number', 'dt' => 6,
                'formatter' => function ($d, $row) {
                if ($this->permit('edit_crystal_bill_group',$this->folder)) {
                    return "
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-auto' style='padding-left: 2px'>		
				  	       <input id='numberBill_{$d}' value='{$row[5]}'  type='text' class='form-control withBill' name='crystal_bill' required>
                   </div>
				  <div class='col-auto' style='padding-right: 2px'>
				   <button type='submit' id='btn_in_bill_{$d}' onclick=saveBill('" . $d . "')  name='submit' class='btn btn-success'>تعديل</button>
                  </div>
                  </div>
                    ";
                }
                else
                {
                    return 'لا تمتلك صلاحية';
                }
                }
            ),

            array('db' => 'number', 'dt' => 7,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/export_group_enter/{$d}'><span>تصدير مواد الفواتير</span></a>";
                }
            ),

            array('db' =>'number', 'dt' => 8),//7




        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );



        if (empty($from_date_stm) && empty($to_date_stm))
        {
            echo json_encode(

                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null,"crystal_bill <> '' GROUP BY  number"));
        }else{
            echo json_encode(
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null,"crystal_bill <> '' AND date BETWEEN {$from_date_stm} AND {$to_date_stm} GROUP BY  number"));

        }


    }





    public function export_group_enter($number)
    {
        $this->checkPermit('export_group', $this->folder);
        $this->adminHeaderController($this->langControl('export_group'));



        if (!is_numeric($number))
        {
            $error=new Errors();
            $error->index();
        }


        $stmt = $this->db->prepare("SELECT   * FROM {$this->group_bill}    WHERE  number=?   LIMIT 1") ;
        $stmt->execute(array($number));
        if ($stmt->rowCount() < 1)
        {
            $error=new Errors();
            $error->index();
        }

        $result=$stmt->fetch(PDO::FETCH_ASSOC);

        $date=null;
        $todate=null;

        $from_date_stm=null;
        $to_date_stm=null;

        if (isset($_GET['date'])&&isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);

        }


        require($this->render($this->folder, 'group', 'bills_materials_enter', 'php'));
        $this->adminFooterController();
    }


    public function processing_bill_materials_crystal_enter($number,$from_date_stm=null,$to_date_stm=null)
    {




        $table = $this->purchase_customer_item;
        $primaryKey = $this->purchase_customer_item.'.id';

        $columns = array(

            array('db' => $table.'.code', 'dt' => 0   ),
            array('db' => $table.'.serial', 'dt' => 1   ),
            array('db' => $table.'.quantity', 'dt' =>2   ),
            array('db' => $table.'.code', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return  $this->storehouse_export($row[13],$d,$row[12]);
                }
            ),
            array('db' => $table.'.price_purchase', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return number_format($d);
                }
            ),
            array('db' => $table.'.price_purchase', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return number_format($d);
                }
            ),
            array('db' => $table.'.price_sale', 'dt' => 6 ),


            array('db' => $table.'.number_bill', 'dt' => 7,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/details/{$d}'>{$d}</a>";
                }
            ),
            array('db' => $this->group_bill.'.crystal_bill', 'dt' => 8 ),


            array('db' => $table.'.number_bill', 'dt' => 9,
                'formatter' => function ($d, $row) {
                    return "<div class='text-right'>{$this->customerInfo($row[11])} ,{$this->user_acc($d)} ,{$this->user_purchase($d)} ,{$d},{$row[10]}</div>";
                }

            ),

            array('db' =>$table.'.note', 'dt' =>10 ),
            array('db' =>$table.'.id_customer', 'dt' =>11 ),
            array('db' =>$table.'.table', 'dt' =>12 ),
            array('db' =>$table.'.location', 'dt' =>13 ),






        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "inner JOIN purchase_customer_bill ON purchase_customer_bill.number_bill = purchase_customer_item.number_bill inner JOIN purchase_customer_group_bill ON purchase_customer_group_bill.number_bill = purchase_customer_item.number_bill  ";
        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array("purchase_customer_bill.cancel=0","purchase_customer_group_bill.number  = {$number}");

        }else{
            $whereAll = array("purchase_customer_bill.cancel=0","purchase_customer_group_bill.date BETWEEN {$from_date_stm} AND {$to_date_stm}","purchase_customer_group_bill.number  = {$number}");
        }


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null));

    }




    function storehouse_export($location,$code,$table)
    {



        if ($table =='product_savers')
        {
            $table='savers';
        }


        $loc=explode(',',$location);

        $sequence = array();
        foreach ($loc as $l)
        {
            $stmt = $this->db->prepare("SELECT  sequence FROM location  WHERE  location=? AND code=? AND  `model`=? LIMIT  1");
            $stmt->execute(array($l,$code,$table));
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $sequence[] = $row['sequence'];
            }
        }

        $store=array();
        foreach ($sequence as $sq)
        {
            $stmt2 = $this->db->prepare("SELECT  * FROM  group_location   WHERE {$sq} between `from` AND  `to` LIMIT 1 ");
            $stmt2->execute();
            $name_store=$stmt2->fetch(PDO::FETCH_ASSOC);

            if (!in_array($name_store['title'],$store))
            {
                $store[]=$name_store['title'];

            }

        }
        return implode(',',$store);

    }






    function crystal_bill_group()
    {
        if ($this->handleLogin()) {


            $number = trim(str_replace(' ', '', $_GET['number_group']));
            $crystal_bill = trim(str_replace(' ', '', $_GET['crystal_bill']));


            $stmt = $this->db->prepare("SELECT   number_bill FROM {$this->group_bill}    WHERE  number=? ");
            $stmt->execute(array($number));
            $bill = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $bill[] = $row['number_bill'];
            }


            $stmt_ch = $this->db->prepare("SELECT   number_bill FROM {$this->group_bill}    WHERE  number=? ");
            $stmt_ch->execute(array($number));
            if ($stmt_ch->rowCount() > 0) {


                $stmt_up = $this->db->prepare("UPDATE  `{$this->group_bill}` SET  crystal_bill=? , user_input_bill=?  WHERE  number =?   ");
                $stmt_up->execute(array($crystal_bill, $this->userid, $number));
                if ($stmt_up->rowCount() > 0) {

                    $bill_group=implode(',',$bill);
                    $stmt_p = $this->db->prepare("UPDATE  `purchase_customer_bill` SET  crystal_bill=? , user_enter=?,`date_enter`=?  WHERE  number_bill IN($bill_group)  ");
                    $stmt_p->execute(array($crystal_bill, $this->userid,time()));
                    if ($stmt_p->rowCount() > 0) {
                        echo '1';
                    }

                }
            }
        }

    }



    public function prch_acc()
    {
        $this->checkPermit('prch_acc', $this->folder);
        $this->adminHeaderController($this->langControl('prch_acc'));


        $date = null;
        $todate = null;

        $from_date_stm = null;
        $to_date_stm = null;
        $id=0;

        if (isset($_GET['id']))
        {
            $id=  $_GET['id'];
        }

        if ( isset($_GET['date']) && isset($_GET['todate']) ) {

            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm = strtotime($date);
            $to_date_stm = strtotime($todate);

        }


        $stmt_groups = $this->db->prepare("SELECT id FROM `usergroup` WHERE  (`name` LIKE '%محاسب%' OR `name` LIKE '%محاسبين الرئيسيين%' OR `name` LIKE '%مباشر%' OR `name` LIKE '%مباشرين%' OR `name` LIKE '%ثانويين%') ");
        $stmt_groups->execute();
        if ($stmt_groups ->rowCount() > 0)
        {
            $ids=array();
            while ($g=$stmt_groups->fetch(PDO::FETCH_ASSOC))
            {
                $ids[]=$g['id'];
            }

            $ids = implode(',',$ids);

            $stmt=$this->db->prepare("SELECT *FROM user WHERE idGroup IN({$ids})");
            $stmt->execute();
            $user=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $user[]=$row;
            }

        }




        require($this->render($this->folder, 'html', 'prch_acc', 'php'));
        $this->adminFooterController();
    }


    public function processing_prch_acc($id,$from_date_stm = null, $to_date_stm = null)
    {

        $table = 'purchase_customer_bill';
        $primaryKey = 'purchase_customer_bill.id';

        $columns = array(
            array('db' => 'register_user.name', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),
            array('db' => 'register_user.phone', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),
            array('db' => 'purchase_customer_bill.number_bill', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return "<a href='" . url . '/' . $this->folder . "/details/{$d}'>{$d}</a>";
                }
            ),

            array('db' => 'purchase_customer_bill.number_bill', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return number_format($this->sumBill($d));
                }
            ),

            array('db' => 'purchase_customer_bill.crystal_bill', 'dt' => 4,
                'formatter' => function ($d, $row) {
                    return $d;
                }
            ),


            array('db' => 'purchase_customer_bill.userid', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }
            ),

            array('db' => 'purchase_customer_bill.date_account', 'dt' => 6,

                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }

            ),

            array('db' => 'purchase_customer_bill.user_enter', 'dt' => 7,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }

            ),
            array('db' => 'purchase_customer_bill.date_enter', 'dt' => 8,

                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }

            ),


            array('db' => 'purchase_customer_bill.crystal_bill', 'dt' => 9),
            array('db' => 'purchase_customer_bill.edit', 'dt' => 10),
            array('db' => 'purchase_customer_bill.checked', 'dt' => 11),


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "inner JOIN register_user ON register_user.id = purchase_customer_bill.id_customer  left JOIN user ON user.id = purchase_customer_bill.userid  ";
        if (empty($from_date_stm) && empty($to_date_stm)) {
            $whereAll = array("purchase_customer_bill.active = 1","purchase_customer_bill.cancel = 0", "purchase_customer_bill.userid = {$id}");

        } else {
            $whereAll = array("purchase_customer_bill.active = 1","purchase_customer_bill.cancel = 0", "purchase_customer_bill.userid = {$id}", "purchase_customer_bill.date_enter BETWEEN {$from_date_stm} AND {$to_date_stm}");

        }


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));

    }




    function search_location()
    {
        $model=$_GET['model'];
        $code=$_GET['code'];
        $location=$_GET['location'];
        $location='%' . $location . '%';
        $stmt = $this->db->prepare("SELECT *FROM `location_model`  WHERE `location` LIKE ?  AND `model` =? GROUP BY location LIMIT 25");
        $stmt->execute(array($location, $model));
        if ($stmt->rowCount() > 0) {

            $html = '';
            {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $html .= "<a class='btn d-block text-right bg-light' href='#' data-model='{$model}' data-code='{$code}' onclick='print_location(this)'>{$row['location']}</a>";
                }
            }
            echo $html;
        }
    }

    function check_location_model()
    {
        $model=$_GET['model'];
        $location=trim($_GET['location']);

        $stmt = $this->db->prepare("SELECT *FROM `location_model`  WHERE `location` = ?  AND `model` =? GROUP BY location LIMIT 1");
        $stmt->execute(array($location, $model));
        if ($stmt->rowCount() > 0) {
            echo 'true';
        }else
        {
            echo 'false';
        }
    }



}



?>