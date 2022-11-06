<?php
class customers extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'register_user';
        $this->cart_shop_active = 'cart_shop_active';
        $this->register_answer = 'register_answer';
        $this->menu = new Menu();
        $this->sleepx = array(50000, 60000, 70000, 80000, 90000, 100000, 110000, 120000, 130000, 140000, 150000, 160000, 170000, 180000, 190000, 200000, 210000, 220000, 230000, 240000, 250000, 260000, 270000, 280000, 290000, 300000, 310000, 320000, 330000, 340000, 350000, 360000, 370000, 380000, 390000, 400000, 410000, 420000, 430000, 440000, 450000, 460000, 470000, 480000, 490000, 500000);
    }
    public function createTB()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `username` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `first_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `second_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `third_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `phone` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `country` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `city` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `type_customer` varchar(250)   COLLATE utf8_unicode_ci NOT NULL,
          `type_customer_12` int(11)   COLLATE utf8_unicode_ci NOT NULL,
          `address` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `uid` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `login` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `ip` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `year` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `note` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `birthday` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
          `date_req` bigint(20) NOT NULL,
          `delivery_service` int(20) NOT NULL,
          `delivery_user` int(20) NOT NULL,
          `last_chat` bigint(20) NOT NULL,
          `wholesale_price` int(20) NOT NULL,
          `active_wholesale_price` int(20) NOT NULL,
          `xc` int(20) NOT NULL DEFAULT 1,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->register_answer}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `id_user` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `phone` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `note` longtext COLLATE utf8_unicode_ci NOT NULL,
          `choose` longtext COLLATE utf8_unicode_ci NOT NULL,
           `userid` int(20) NOT NULL,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        return $this->db->cht(array($this->table, $this->register_answer));
    }
    function name()
    {
        if ($this->handleLogin()) {
            $name = $_GET['name'];
            $name = '%' . $name . '%';
            $stmt = $this->db->prepare("SELECT *FROM `register_user`  WHERE (`name` LIKE ? OR phone LIKE ? )  AND gander <> '' AND  city <> '' LIMIT 15");
            $stmt->execute(array($name, $name));
            if ($stmt->rowCount() > 0) {
                $html = ''; {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $html .= "<a class='btn d-block text-right bg-light' href='#'  onclick='print_name(this,{$row['id']})'>{$row['name']}</a>";
                    }
                }
                echo $html;
            }
        }
    }
    public function form()
    {
        $q = array(
            1 => '1. انك ستحصل على انسب سعر و افضل ضمان.',
            2 => '2. ستحصل على انسب سعر و افضل ضمان و الجودة تعني انك اشتريت جهاز لماركة مشهورة.',
            3 => '3. ستحصل على انسب سعر و افضل ضمان لجهاز غير مغشوش "اصلي" في زمن انتشر به الغش بشكل كبير جدا و خصوصا في عالم اجهزة الموبايل لان طرق الغش سهلة و مربحة جداً و تحتاج فقط لشخص غير ملتزم دينيا ليعمل بها و يكسب منها الاموال الحرام الطائلة و من تلك الطرق البسيطة هي استبدال ملحقات الاجهزة الاصلية بملحقات تجارية مشابهة للاصلية و اعادة اقفال كارتونة الجهاز بلاصق او نايلون يشابه لاصق و نايلون الجهاز الاصلي فيصبح فقط صاحب الاختصاص الذي لديه خبرة كافية يستطيع ان يميز الجهاز '
        );
        $time_reg = $_GET['time_reg'];
        if (true) {
            try {
                $form = new  Form();
                $form->post('first_name')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');
                $form->post('gander')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');
                $form->post('id_user_screen')
                    ->val('strip_tags');
                $form->post('day')
                    ->val('strip_tags');
                $form->post('month')
                    ->val('strip_tags');
                $form->post('year')
                    ->val('strip_tags');
                $form->post('title')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');
                $form->post('phone')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');
                $form->post('city')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');
                $form->post('address')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');
                $form->submit();
                $data = $form->fetch();
                $data['date'] = time();
                $data['time_reg'] = $time_reg;
                $data['login'] = 'website';
                $data['country'] = 'العراق';
                $data['username'] = $data['phone'];
                $data['name'] = $data['first_name'];
                $data['uid'] = $this->c_uid(8);
                $data['birthday'] = $data['year'] . '-' . $data['month'] . '-' . $data['day'];
                $answer = array();
                $data['xc'] = 1;
                if (empty($this->error_form)) {
                    $stmt2 = $this->db->prepare("SELECT *FROM `register_user` WHERE `phone`=? AND xc=1  AND city <> ''  AND gander <> ''");
                    $stmt2->execute(array($data['phone']));
                    if ($stmt2->rowCount() > 0) {
                        $result =  $stmt2->fetch(PDO::FETCH_ASSOC);
                        $data['uid'] = $result['uid'];
                        $stmt = $this->db->update($this->table, array_diff_key($data, ['about_company' => "delete", 'forAnswerThat' => "delete", 'after_video' => "delete", 'note' => "delete", 'day' => "delete", 'month' => "delete", 'year' => "delete"]), "phone={$data['phone']}  AND city <> ''  AND gander <> ''");
                        $_SESSION['new_register'] = $result['id'];
                        echo json_encode(array('done' => array('done' => $result['uid'])), JSON_FORCE_OBJECT);
                    } else {
                        $stmt = $this->db->insert($this->table, array_diff_key($data, ['about_company' => "delete", 'forAnswerThat' => "delete", 'after_video' => "delete", 'note' => "delete", 'day' => "delete", 'month' => "delete", 'year' => "delete"]));
                        $last_id = $this->db->lastInsertId($this->table);
                        $_SESSION['new_register'] = $last_id;
                        echo json_encode(array('done' => array('done' =>  $data['uid'])), JSON_FORCE_OBJECT);
                    }
                }
            } catch (Exception $e) {
                $this->error_form = $e->getMessage();
                echo json_encode(array('error' => json_decode($this->error_form)), JSON_FORCE_OBJECT);
            }
        }
    }
    public function form2()
    {
        $q = array(
            1 => '1. انك ستحصل على انسب سعر و افضل ضمان.',
            2 => '2. ستحصل على انسب سعر و افضل ضمان و الجودة تعني انك اشتريت جهاز لماركة مشهورة.',
            3 => '3. ستحصل على انسب سعر و افضل ضمان لجهاز غير مغشوش "اصلي" في زمن انتشر به الغش بشكل كبير جدا و خصوصا في عالم اجهزة الموبايل لان طرق الغش سهلة و مربحة جداً و تحتاج فقط لشخص غير ملتزم دينيا ليعمل بها و يكسب منها الاموال الحرام الطائلة و من تلك الطرق البسيطة هي استبدال ملحقات الاجهزة الاصلية بملحقات تجارية مشابهة للاصلية و اعادة اقفال كارتونة الجهاز بلاصق او نايلون يشابه لاصق و نايلون الجهاز الاصلي فيصبح فقط صاحب الاختصاص الذي لديه خبرة كافية يستطيع ان يميز الجهاز '
        );
        $time_reg = $_GET['time_reg'];
        if (true) {
            try {
                $form = new  Form();
                $form->post('about_company')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');
                $form->post('forAnswerThat')
                    ->val('strip_tags');
                $form->post('after_video')
                    ->val('strip_tags');
                $form->post('note')
                    ->val('strip_tags');
                $form->submit();
                $data = $form->fetch();
                $answer = array();
                if ($data['about_company'] == 1  && $data['forAnswerThat'] == 3) {
                    $data['type_customer'] = 'مقتنع';
                    $data['type_customer_12'] = 1;
                    $answer['choose'] = $q[3];
                }
                if ($data['about_company'] == 1  && ($data['forAnswerThat'] == 1 ||  $data['forAnswerThat'] == 2)) {
                    $data['type_customer'] = 'غير مقتنع';
                    $data['type_customer_12'] = 2;
                    if ($data['forAnswerThat'] == 1) {
                        $answer['choose'] = $q[1];
                    } else if ($data['forAnswerThat'] == 2) {
                        $answer['choose'] = $q[2];
                    } else {
                        $answer['choose'] = $q[3];
                    }
                }
                if ($data['about_company'] == 2) {
                    if ($data['after_video'] == 1) {
                        $data['type_customer'] = 'مقتنع';
                        $data['type_customer_12'] = 1;
                    } else {
                        $data['type_customer'] = 'غير مقتنع';
                        $data['type_customer_12'] = 2;
                        $answer['note'] = $data['note'];
                    }
                }
                if ($data['about_company'] == 1  && ($data['forAnswerThat'] == 1 ||  $data['forAnswerThat'] == 2)) {
                    if ($data['after_video'] == 1) {
                        $data['type_customer'] = 'مقتنع';
                        $data['type_customer_12'] = 1;
                    } else {
                        $data['type_customer'] = 'غير مقتنع';
                        $data['type_customer_12'] = 2;
                        $answer['note'] = $data['note'];
                    }
                }
                $data['time_reg'] = $time_reg;
                if (empty($this->error_form)) {
                    $stmt2 = $this->db->prepare("SELECT *FROM `register_user` WHERE `id`=?  ");
                    $stmt2->execute(array($_SESSION['new_register']));
                    $result =  $stmt2->fetch(PDO::FETCH_ASSOC);
                    $stmt = $this->db->update($this->table, array_diff_key($data, ['about_company' => "delete", 'forAnswerThat' => "delete", 'after_video' => "delete", 'note' => "delete", 'day' => "delete", 'month' => "delete", 'year' => "delete"]), "id={$_SESSION['new_register']}");
                    $_SESSION['username_member_r'] = $result['phone'];
                    $_SESSION['id_member_r'] = $_SESSION['new_register'];
                    $_SESSION['name_r'] = $result['name'];
                    $_SESSION['typeLogin'] = $result['login'];
                    $answer['phone'] = $result['phone'];
                    $answer['id_user'] =  $_SESSION['new_register'];
                    $this->db->insert($this->register_answer, $answer);
                    $this->active_customer($result['id'], $this->UserInfo($result['id_user_screen']));
                    echo json_encode(array('done' => array('done' =>  $result['uid'])), JSON_FORCE_OBJECT);
                }
            } catch (Exception $e) {
                $this->error_form = $e->getMessage();
                echo json_encode(array('error' => json_decode($this->error_form)), JSON_FORCE_OBJECT);
            }
        }
    }
    function phone()
    {
        $phone = $_POST['phone'];
        $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE `phone`=?  AND `xc` =1");
        $stmt->execute(array($phone));
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['username_member_r'] = $result['phone'];
            $_SESSION['id_member_r'] =  $result['id'];
            $_SESSION['name_r'] = $result['name'];
            $_SESSION['typeLogin'] = $result['login'];
            echo json_encode(array('done' => array('done' => $result['uid'], 'first_name' => $result['first_name'])), JSON_FORCE_OBJECT);
        } else {
            $this->error_form = json_encode(array('error' =>  'error'));
            echo json_encode(array('error' => json_decode($this->error_form)), JSON_FORCE_OBJECT);
        }
    }
    function check_phone()
    {
        $phone = strip_tags(trim($_GET['phone']));
        if (strlen($phone) == 11) {
            $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE `phone`=? AND xc=1 AND gander <> '' AND city <> '' ");
            $stmt->execute(array($phone));
            if ($stmt->rowCount() > 0) {
                echo 'true';
            }
        }
    }
    function check_register()
    {
        if (isset($_SESSION['username_member_r'])) {
            echo 'true';
        }
    }
    function login_customer($id)
    {
        if ($this->handleLogin()) {
            $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE `id`=? ");
            $stmt->execute(array($id));
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['username_member_r'] = $result['phone'];
                $_SESSION['id_member_r'] =  $result['id'];
                $_SESSION['name_r'] = $result['name'];
                $_SESSION['typeLogin'] = $result['login'];
                //            setcookie("setLogin", openssl_encrypt($_SESSION['username_member_r'],"AES-128-ECB",HASH_PASSWORD_KEY).'#|'. $_SESSION['id_member_r'] ,time() + 31556926 , "/");
                $this->lightRedirect(url, 0);
            }
        }
    }
    function chphone($phone)
    {
        $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE `phone`=? AND `xc` =1");
        $stmt->execute(array($phone));
        if ($stmt->rowCount() > 0) {
            echo 'found';
        }
    }
    function c_uid($length)
    {
        $key = $this->generateRandomString($length);
        $c_uid = $this->db->prepare("SELECT * from  {$this->table} WHERE `uid`=?  ");
        $c_uid->execute(array($key));
        if ($c_uid->rowCount() > 0) {
            $this->c_uid($length);
        } else {
            return $key;
        }
    }
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function add_customers($phone = null)
    {
        $this->checkPermit('add_customer', 'registration');
        $this->adminHeaderController($this->langControl('add_customer'));
        require($this->render($this->folder, 'html', 'add', 'php'));
        $this->adminFooterController();
    }
    function form_add_customer()
    {
        $this->checkPermit('add_customer', 'registration');
        if (true) {
            try {
                $form = new  Form();
                $form->post('name')
                    ->val('strip_tags');
                $form->post('phone')
                    ->val('strip_tags');
                $form->submit();
                $data = $form->fetch();
                $data['uid'] = $this->c_uid(8);
                if (!empty($data['name']) || !empty($data['phone'])) {
                    if (empty($data['phone'])) {
                        $data['phone'] = $data['uid'];
                        $data['username'] = $data['uid'];
                    } else {
                        $data['username'] = $data['phone'];
                    }
                    $data['year'] = date('Y', time());
                    $data['date'] = time();
                    $data['login'] = 'website';
                    $data['country'] = 'العراق';
                    $data['xc'] = 0;
                    $stmt = $this->db->insert($this->table, $data);
                    $last_id = $this->db->lastInsertId();
                    $this->logoutNow();
                    if (empty($data['phone'])) {
                        $_SESSION['username_member_r'] = $data['uid'];
                    } else {
                        $_SESSION['username_member_r'] = $data['phone'];
                    }
                    $_SESSION['id_member_r'] = $last_id;
                    $_SESSION['name_r'] = $data['name'];
                    $_SESSION['typeLogin'] = $data['login'];
                    echo json_encode(array('done' => array('done' => 'done')), JSON_FORCE_OBJECT);
                } else {
                    echo json_encode(array('error' => array('error' => 'يجب كتابة الاسم او الرقم')), JSON_FORCE_OBJECT);
                }
            } catch (Exception $e) {
                $this->error_form = $e->getMessage();
                echo json_encode(array('error' => array('error' => 'يجب كتابة الاسم او الرقم')), JSON_FORCE_OBJECT);
            }
        }
    }
    function logoutNow()
    {
        setcookie("setLogin", null, time() + 31556926, "/");
        unset($_SESSION['username_member_r']);
        unset($_SESSION['id_member_r']);
        unset($_SESSION['name_r']);
        unset($_SESSION['typeLogin']);
    }
    function search()
    {
        $this->checkPermit('search', 'registration');
        $this->adminHeaderController($this->langControl('add_customer'));
        require($this->render($this->folder, 'html', 'search', 'php'));
        $this->adminFooterController();
    }
    function ch_search_c()
    {
        $this->checkPermit('add_customer', 'registration');
        if (true) {
            try {
                $form = new  Form();
                $form->post('name')
                    ->val('strip_tags');
                $form->submit();
                $data = $form->fetch();
                $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE `phone`=?");
                $stmt->execute(array($data['name']));
                if ($stmt->rowCount() > 0) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $stmt2 = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `buy` = 1 AND  `status` = 0 AND `id_member_r` = ? GROUP BY `id_member_r`  ORDER BY `date_req` ASC ");
                    $stmt2->execute(array($result['id']));
                    if ($stmt2->rowCount() > 0) {
                        echo json_encode(array('doner' => array('doner' => $result['id'])), JSON_FORCE_OBJECT);
                    } else {
                        echo json_encode(array('done' => array('done' => $result['id'])), JSON_FORCE_OBJECT);
                    }
                } else {
                    echo json_encode(array('error' => array('error' => $data['name'])), JSON_FORCE_OBJECT);
                }
            } catch (Exception $e) {
                $this->error_form = $e->getMessage();
                echo json_encode(array('f' => array('f' => 'حدث خطا')), JSON_FORCE_OBJECT);
            }
        }
    }
    function byphone()
    {
        if ($this->handleLogin()) {
            $k = array_rand($this->sleepx);
            $v = $this->sleepx[$k];
            usleep($v);
            $uuid = $this->isUuid();
            $phone = trim($_POST['phone']);
            $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE `phone`=? limit 1");
            $stmt->execute(array($phone));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_user = $result['id'];
            $dollar = 0;
            $stmt = $this->db->prepare("SELECT *FROM `dollar_price`  WHERE `active` = 1  ORDER BY `id` DESC  LIMIT 1");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $resultDollar = $stmt->fetch(PDO::FETCH_ASSOC);
                $dollar = $resultDollar['dollar'];
            }
            if (!empty($result)) {
                if ($_SESSION['direct'] == 3) {
                    $stmt_uuid = $this->db->prepare("UPDATE `cart_shop_active` SET `date`=?,`id_member_r` = ? ,`direct`=? ,`user_direct`=?,`prepared` = ?,`dollar_exchange`=?  WHERE `id_member_r`=? AND `buy` = 0 AND `status`=0");
                    $stmt_uuid->execute(array(time(), $id_user, $_SESSION['direct'], $this->userid, 1, $dollar, $uuid));
                } else {
                    $stmt_uuid = $this->db->prepare("UPDATE `cart_shop_active` SET `date`=?,`id_member_r` = ? ,`direct`=? ,`user_direct`=?,`dollar_exchange`=? WHERE `id_member_r`=? AND `buy` = 0 AND `status`=0");
                    $stmt_uuid->execute(array(time(), $id_user, $_SESSION['direct'], $this->userid, $dollar, $uuid));
                }
                $mobile = new mobile();
                $stmt_date = $this->db->prepare("UPDATE `cart_shop_active` SET `date_req` = ?  WHERE `id_member_r`=? AND `buy` = 0 AND `status`=0");
                $stmt_date->execute(array(time(), $id_user));
                $stmt1 = $mobile->getAllContentFromCar_new($id_user);
                while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                    $table = $row['table'];
                    $number = $row['number'];
                    $this->set_quantity_order($table, $row['id_item'], $row['code'], $number);
                    if ($row['offers']) {
                        $this->check_one_itemoffers($row['id_offer']);
                    }
                    $stmt_get_item = $this->db->prepare("SELECT *FROM `{$row['table']}` WHERE id = ?  LIMIT 1");
                    $stmt_get_item->execute(array($row['id_item']));
                    $item = $stmt_get_item->fetch();
                    $row['title'] = $item['title'];
                    $row['img'] = $this->save_file . $row['image'];
                }
                /*   $x = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `id_member_r`=? AND  `prepared` = 0 AND `accountant`=0 AND `buy` =1 ");
                $x->execute(array($id_user));
                if ($x->rowCount() > 0) {
                    $stmtNb = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE `id_member_r`=? AND `prepared` = 0  AND `accountant`=0 AND `buy` =1  order by `number_bill` DESC LIMIT 1");
                    $stmtNb->execute(array($id_user));
                    if ($stmtNb->rowCount() > 0) {
                        $r = $stmtNb->fetch(PDO::FETCH_ASSOC);
                        $number_bill = $r['number_bill'];
                    }
                } else {
                    $stmtNb = $this->db->prepare("SELECT *FROM `cart_shop_active`  ORDER BY `number_bill` DESC   LIMIT 1");
                    $stmtNb->execute();
                    if ($stmtNb->rowCount() > 0) {
                        $r = $stmtNb->fetch(PDO::FETCH_ASSOC);
                        $number_bill = $r['number_bill'] + 1;
                    } else {
                        $number_bill = 1;
                    }
                }
                */
                $number_bill = $this->getNumberBill(4);
                $stmt1 = $this->db->prepare("UPDATE `cart_shop_active` SET `buy` = 1 ,`number_bill`=? WHERE `id_member_r`=? AND `buy` = 0 ");
                $stmt1->execute(array($number_bill, $id_user));
                $stmt2 = $this->db->prepare("UPDATE `register_user` SET `date_req` =  ?  WHERE `id` = ?  ");
                $stmt2->execute(array(time(), $id_user));
                $stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $oldData = array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
                    $oldData[] = $rowt;
                }
                if ($_SESSION['direct'] == 3) {
                    $trace = new trace();
                    $trace->addtrace('cart_shop_active', 'محاسب مباشر- اضافة طلب جيد -  بستخدام رفم الهاتف      ', json_encode($oldData), json_encode(array()), ' اضافة طلب بواسطة المحاسب المباشر رقم الفاتورة ' . $number_bill, $number_bill);
                } else if ($_SESSION['direct'] == 2) {
                    $trace = new trace();
                    $trace->addtrace('cart_shop_active', 'مجهز مباشر- اضافة طلب جيد -    بستخدام رفم الهاتف       ', json_encode($oldData), json_encode(array()), ' اضافة طلب بواسطة المجهز المباشر رقم الفاتورة ' . $number_bill, $number_bill);
                } else {
                    $trace = new trace();
                    $trace->addtrace('cart_shop_active', 'بائع مباشر- اضافة طلب جيد -     بستخدام رفم الهاتف      ', json_encode($oldData), json_encode(array()), ' اضافة طلب بواسطة البائع المباشر رقم الفاتورة ' . $number_bill, $number_bill);
                }
                echo $_SESSION['direct'];
                Session::set('uuid', $this->uuid(4));
            }
        }
    }
    function byqr()
    {
        if ($this->handleLogin()) {
            $k = array_rand($this->sleepx);
            $v = $this->sleepx[$k];
            usleep($v);
            $uuid = $this->isUuid();
            $qr = trim($_GET['qr']);
            $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE `uid`=? limit 1");
            $stmt->execute(array($qr));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_user = $result['id'];
            $dollar = 0;
            $stmt = $this->db->prepare("SELECT *FROM `dollar_price`  WHERE `active` = 1  ORDER BY `id` DESC  LIMIT 1");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $resultDollar = $stmt->fetch(PDO::FETCH_ASSOC);
                $dollar = $resultDollar['dollar'];
            }
            if (!empty($result)) {
                if ($_SESSION['direct'] == 3) {
                    $stmt_uuid = $this->db->prepare("UPDATE `cart_shop_active` SET `date`=?,`id_member_r` = ? ,`direct`=? ,`user_direct`=?,`prepared` = ?,`dollar_exchange`=? ,byqr=1 WHERE `id_member_r`=? AND `buy` = 0 AND `status`=0");
                    $stmt_uuid->execute(array(time(), $id_user, $_SESSION['direct'], $this->userid, 1, $dollar, $uuid));
                } else {
                    $stmt_uuid = $this->db->prepare("UPDATE `cart_shop_active` SET `date`=?,`id_member_r` = ? ,`direct`=? ,`user_direct`=?,`dollar_exchange`=? ,byqr=1 WHERE `id_member_r`=? AND `buy` = 0 AND `status`=0");
                    $stmt_uuid->execute(array(time(), $id_user, $_SESSION['direct'], $this->userid, $dollar, $uuid));
                }
                $mobile = new mobile();
                $stmt_date = $this->db->prepare("UPDATE `cart_shop_active` SET `date_req` = ?  WHERE `id_member_r`=? AND `buy` = 0 AND `status`=0");
                $stmt_date->execute(array(time(), $id_user));
                $stmt1 = $mobile->getAllContentFromCar_new($id_user);
                while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                    $table = $row['table'];
                    $number = $row['number'];
                    $this->set_quantity_order($table, $row['id_item'], $row['code'], $number);
                    if ($row['offers']) {
                        $this->check_one_itemoffers($row['id_offer']);
                    }
                    $stmt_get_item = $this->db->prepare("SELECT *FROM `{$row['table']}` WHERE id = ?  LIMIT 1");
                    $stmt_get_item->execute(array($row['id_item']));
                    $item = $stmt_get_item->fetch();
                    $row['title'] = $item['title'];
                    $row['img'] = $this->save_file . $row['image'];
                }
                $number_bill = $this->getNumberBill(4);
                $stmt1 = $this->db->prepare("UPDATE `cart_shop_active` SET `buy` = 1 ,`number_bill`=?,byqr=1 WHERE `id_member_r`=? AND `buy` = 0 ");
                $stmt1->execute(array($number_bill, $id_user));
                $stmt2 = $this->db->prepare("UPDATE `register_user` SET `date_req` =  ?  WHERE `id` = ?  ");
                $stmt2->execute(array(time(), $id_user));
                $stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $oldData = array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
                    $oldData[] = $rowt;
                }
                if ($_SESSION['direct'] == 3) {
                    $trace = new trace();
                    $trace->addtrace('cart_shop_active', 'محاسب مباشر- اضافة طلب جيد -  بستخدام رفم الهاتف      ', json_encode($oldData), json_encode(array()), ' اضافة طلب بواسطة المحاسب المباشر رقم الفاتورة ' . $number_bill, $number_bill);
                } else if ($_SESSION['direct'] == 2) {
                    $trace = new trace();
                    $trace->addtrace('cart_shop_active', 'مجهز مباشر- اضافة طلب جيد -    بستخدام رفم الهاتف       ', json_encode($oldData), json_encode(array()), ' اضافة طلب بواسطة المجهز المباشر رقم الفاتورة ' . $number_bill, $number_bill);
                } else {
                    $trace = new trace();
                    $trace->addtrace('cart_shop_active', 'بائع مباشر- اضافة طلب جيد -     بستخدام رفم الهاتف      ', json_encode($oldData), json_encode(array()), ' اضافة طلب بواسطة البائع المباشر رقم الفاتورة ' . $number_bill, $number_bill);
                }
                echo $_SESSION['direct'];
                Session::set('uuid', $this->uuid(4));
            }
        }
    }
    function qr($uid)
    {
        if (isset($_SESSION['loggedIn'])) {
            $k = array_rand($this->sleepx);
            $v = $this->sleepx[$k];
            usleep($v);
            $uuid = $this->isUuid();
            $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE `uid`=? limit 1");
            $stmt->execute(array($uid));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_user = $result['id'];
            $dollar = 0;
            $stmt = $this->db->prepare("SELECT *FROM `dollar_price`  WHERE `active` = 1  ORDER BY `id` DESC  LIMIT 1");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $resultDollar = $stmt->fetch(PDO::FETCH_ASSOC);
                $dollar = $resultDollar['dollar'];
            }
            if (!empty($result)) {
                if ($_SESSION['direct'] == 3) {
                    $stmt_uuid = $this->db->prepare("UPDATE `cart_shop_active` SET `date`=?,`id_member_r` = ? ,`direct`=? ,`user_direct`=?,`prepared` = ?,`dollar_exchange`=? ,byqr=1 WHERE `id_member_r`=? AND `buy` = 0 AND `status`=0");
                    $stmt_uuid->execute(array(time(), $id_user, $_SESSION['direct'], $this->userid, 1, $dollar, $uuid));
                } else {
                    $stmt_uuid = $this->db->prepare("UPDATE `cart_shop_active` SET `date`=?,`id_member_r` = ? ,`direct`=? ,`user_direct`=?,`dollar_exchange`=?,byqr=1 WHERE `id_member_r`=? AND `buy` = 0 AND `status`=0");
                    $stmt_uuid->execute(array(time(), $id_user, $_SESSION['direct'], $this->userid, $dollar, $uuid));
                }
                $mobile = new mobile();
                $stmt_date = $this->db->prepare("UPDATE `cart_shop_active` SET `date_req` = ?  WHERE `id_member_r`=? AND `buy` = 0 AND `status`=0");
                $stmt_date->execute(array(time(), $id_user));
                $stmt1 = $mobile->getAllContentFromCar_new($id_user);
                while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                    $table = $row['table'];
                    $number = $row['number'];
                    $this->set_quantity_order($table, $row['id_item'], $row['code'], $number);
                    if ($row['offers']) {
                        $this->check_one_itemoffers($row['id_offer']);
                    }
                    $stmt_get_item = $this->db->prepare("SELECT *FROM `{$row['table']}` WHERE id = ?  LIMIT 1");
                    $stmt_get_item->execute(array($row['id_item']));
                    $item = $stmt_get_item->fetch();
                    $row['title'] = $item['title'];
                    $row['img'] = $this->save_file . $row['image'];
                }
                $number_bill = $this->getNumberBill(4);
                $stmt1 = $this->db->prepare("UPDATE `cart_shop_active` SET `buy` = 1 ,`number_bill`=?,byqr=1 WHERE `id_member_r`=? AND `buy` = 0 ");
                $stmt1->execute(array($number_bill, $id_user));
                $stmt2 = $this->db->prepare("UPDATE `register_user` SET `date_req` =  ?  WHERE `id` = ?  ");
                $stmt2->execute(array(time(), $id_user));
                $stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $oldData = array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
                    $oldData[] = $rowt;
                }
                if ($_SESSION['direct'] == 3) {
                    $trace = new trace();
                    $trace->addtrace('cart_shop_active', 'محاسب مباشر- اضافة طلب جيد -  بستخدام تقنية QR  ', json_encode($oldData), json_encode(array()), ' اضافة طلب بواسطة المحاسب المباشر رقم الفاتورة ' . $number_bill, $number_bill);
                } else if ($_SESSION['direct'] == 2) {
                    $trace = new trace();
                    $trace->addtrace('cart_shop_active', 'مجهز مباشر- اضافة طلب جيد - بستخدام تقنية QR ', json_encode($oldData), json_encode(array()), ' اضافة طلب بواسطة المجهز المباشر رقم الفاتورة ' . $number_bill, $number_bill);
                } else {
                    $trace = new trace();
                    $trace->addtrace('cart_shop_active', 'بائع مباشر- اضافة طلب جيد -  بستخدام تقنية QR  ', json_encode($oldData), json_encode(array()), ' اضافة طلب بواسطة البائع المباشر رقم الفاتورة ' . $number_bill, $number_bill);
                }
                Session::set('uuid', $this->uuid(4));
            }
            require($this->render($this->folder, 'html', 'qr', 'php'));
        } else {
            $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE `uid`=? limit 1");
            $stmt->execute(array($uid));
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['username_member_r'] = $result['phone'];
                $_SESSION['id_member_r'] =  $result['id'];
                $_SESSION['name_r'] = $result['name'];
                $_SESSION['typeLogin'] = $result['login'];
                //				setcookie("setLogin", openssl_encrypt($_SESSION['username_member_r'],"AES-128-ECB",HASH_PASSWORD_KEY).'#|'. $_SESSION['id_member_r'] ,time() + 31556926 , "/");
                $this->lightRedirect(url, 0);
            } else {
                echo 'الزبون غبر مسجل!!';
            }
        }
    }
    function new_customers()
    {
        if ($this->handleLogin()) {
            $k = array_rand($this->sleepx);
            $v = $this->sleepx[$k];
            usleep($v);
            $uuid = $this->isUuid();
            $name = trim(strip_tags($_POST['name']));
            $phone = trim($_POST['phone']);
            $data['uid'] = $this->c_uid(8);
            $data['name'] = $name;
            $data['username'] = $phone;
            $data['phone'] = $phone;
            $data['year'] = date('Y', time());
            $data['date'] = time();
            $data['login'] = 'website';
            $data['country'] = 'العراق';
            $data['xc'] = 0;


            $stmtx = $this->db->insert($this->table, $data);
            $last_id = $this->db->lastInsertId($this->table);


            $stmt_info = $this->db->prepare("INSERT INTO `ac_general_info`(`name`,`phone`,`country`,`city`,`login`,`active`,`stop`,`iduser`,`date`) VALUE (?,?,?,?,?,?,?,?,?)");
            $stmt_info->execute(array($data['name'],$data['phone'],$data['country'],'كربلاء',$data['login'],1,0,$this->userid,time()));

            $getLastId = $this->db->prepare("SELECT `id` FROM `ac_general_info` WHERE `iduser`= ? ORDER BY `id` DESC");
            $getLastId->execute(array($this->userid));
            $row_id = $getLastId->fetch(PDO::FETCH_ASSOC);
            $lastId = $row_id['id'];

            $getIdCat = $this->db->prepare("SELECT `id` FROM `ac_account_catg` WHERE `title`=? ");
            $getIdCat->execute(array('الزبائن'));
            $row_cat = $getIdCat->fetch(PDO::FETCH_ASSOC);
            $id_cat = $row_cat['id'];

            $getPriceList = $this->db->prepare("SELECT `id` FROM `ac_price_list` WHERE `title`=? ");
            $getPriceList->execute(array('مفرد'));
            $row_list = $getPriceList->fetch(PDO::FETCH_ASSOC);
            $price_list = $row_list['id'];

            $getPriceStyle = $this->db->prepare("SELECT `id` FROM `ac_price_style` WHERE `title`=? ");
            $getPriceStyle->execute(array('نقدي'));
            $row_style = $getPriceStyle->fetch(PDO::FETCH_ASSOC);
            $price_style = $row_style['id'];


            $stmt_account = $this->db->prepare("INSERT INTO `ac_account` (`id_info`,`id_cat`,`id_branch`,`id_price_list`,`id_price_style`,`iduser`,`date`) VALUE (?,?,?,?,?,?,?)");
            $stmt_account->execute(array($lastId,$id_cat,1,$price_list,$price_style,$this->userid,time()));


            $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE `id`=? limit 1");
            $stmt->execute(array($last_id));

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_user = $result['id'];
            $dollar = 0;
            $stmt = $this->db->prepare("SELECT *FROM `dollar_price`  WHERE `active` = 1  ORDER BY `id` DESC  LIMIT 1");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $resultDollar = $stmt->fetch(PDO::FETCH_ASSOC);
                $dollar = $resultDollar['dollar'];
            }
            if (!empty($result)) {
                if ($_SESSION['direct'] == 3) {
                    $stmt_uuid = $this->db->prepare("UPDATE `cart_shop_active` SET `date`=?,`id_member_r` = ? ,`direct`=? ,`user_direct`=?,`prepared`=?,`dollar_exchange`=? WHERE `id_member_r`=? AND `buy` = 0 AND `status`=0");
                    $stmt_uuid->execute(array(time(), $id_user, $_SESSION['direct'], $this->userid, 1, $dollar, $uuid));
                } else {
                    $stmt_uuid = $this->db->prepare("UPDATE `cart_shop_active` SET `date`=?,`id_member_r` = ? ,`direct`=? ,`user_direct`=?,`dollar_exchange`=? WHERE `id_member_r`=? AND `buy` = 0 AND `status`=0");
                    $stmt_uuid->execute(array(time(), $id_user, $_SESSION['direct'], $this->userid, $dollar, $uuid));
                }
                $mobile = new mobile();
                $stmt_date = $this->db->prepare("UPDATE `cart_shop_active` SET `date_req` = ?  WHERE `id_member_r`=? AND `buy` = 0 AND `status`=0");
                $stmt_date->execute(array(time(), $id_user));
                $stmt1 = $mobile->getAllContentFromCar_new($id_user);
                while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                    $table = $row['table'];
                    $number = $row['number'];
                    $this->set_quantity_order($table, $row['id_item'], $row['code'], $number);
                    $stmt_get_item = $this->db->prepare("SELECT *FROM `{$row['table']}` WHERE id = ?  LIMIT 1");
                    $stmt_get_item->execute(array($row['id_item']));
                    $item = $stmt_get_item->fetch();
                    $row['title'] = $item['title'];
                    $row['img'] = $this->save_file . $row['image'];
                    if ($row['offers']) {
                        $this->check_one_itemoffers($row['id_offer']);
                    }
                }
                $number_bill = $this->getNumberBill(4);
                $stmt1 = $this->db->prepare("UPDATE `cart_shop_active` SET `buy` = 1 ,`number_bill`=? WHERE `id_member_r`=? AND `buy` = 0 ");
                $stmt1->execute(array($number_bill, $id_user));
                $stmt2 = $this->db->prepare("UPDATE `register_user` SET `date_req` =  ?  WHERE `id` = ?  ");
                $stmt2->execute(array(time(), $id_user));
                $stmtt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE   `number_bill` = ? ");
                $stmtt->execute(array($number_bill));
                $oldData = array();
                while ($rowt = $stmtt->fetch(PDO::FETCH_ASSOC)) {
                    $oldData[] = $rowt;
                }
                if ($_SESSION['direct'] == 3) {
                    $trace = new trace();
                    $trace->addtrace('cart_shop_active', 'محاسب مباشر- اضافة طلب جيد - زبون جيد فقط لهذة الفاتورة', json_encode($oldData), json_encode(array()), ' اضافة طلب بواسطة المحاسب المباشر رقم الفاتورة ' . $number_bill, $number_bill);
                } else if ($_SESSION['direct'] == 2) {
                    $trace = new trace();
                    $trace->addtrace('cart_shop_active', 'مجهز مباشر- اضافة طلب جيد - زبون جيد فقط لهذة الفاتورة', json_encode($oldData), json_encode(array()), ' اضافة طلب بواسطة المجهز المباشر رقم الفاتورة ' . $number_bill, $number_bill);
                } else {
                    $trace = new trace();
                    $trace->addtrace('cart_shop_active', 'بائع مباشر- اضافة طلب جيد - زبون جيد فقط لهذة الفاتورة', json_encode($oldData), json_encode(array()), ' اضافة طلب بواسطة البائع المباشر رقم الفاتورة ' . $number_bill, $number_bill);
                }
                echo $_SESSION['direct'];
                Session::set('uuid', $this->uuid(4));
            }
        }
    }
    function login_qr($uid)
    {
        $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE `uid`=? limit 1");
        $stmt->execute(array($uid));
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['username_member_r'] = $result['phone'];
            $_SESSION['id_member_r'] =  $result['id'];
            $_SESSION['name_r'] = $result['name'];
            $_SESSION['typeLogin'] = $result['login'];
            //			setcookie("setLogin", openssl_encrypt($_SESSION['username_member_r'],"AES-128-ECB",HASH_PASSWORD_KEY).'#|'. $_SESSION['id_member_r'] ,time() + 31556926 , "/");
            $this->lightRedirect(url, 0);
        } else {
            echo 'الزبون غبر مسجل!!';
        }
    }
    function get_uid()
    {
        if ($this->handleLogin()) {
            $phone = strip_tags(trim($_GET['phone']));
            $stmt = $this->db->prepare("SELECT name,uid  FROM `register_user`  WHERE phone =? AND   uid <> ''  LIMIT 1");
            $stmt->execute(array($phone));
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode(array('name' => $result['name'], 'uid' => $result['uid']));
            }
        }
    }


    // customers_compensation
    function customers_compensation_index()
    {
        $this->checkPermit('customers_compensation', 'customers');
        $this->adminHeaderController("تعويض الزبائن");
        require($this->render($this->folder, 'html', 'customers_compensation', 'php'));
        $this->adminFooterController();
    }
    public function customers_compensation_index_processing()
    {
        $table = "customers_compensation";
        $primaryKey = 'id';
        $columns = array(
            // array('db' => 'id', 'dt' => 0),
            array('db' => 'customer_name', 'dt' => 0),
            array('db' => 'customer_number', 'dt' => 1),
            array('db' => 'id_bill', 'dt' => 2),
            array(
                'db' => 'date_called', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    if ($d == 0) {
                        return '';
                    } else {
                        return date('Y-m-d h:i A', $d);
                    }

                }
            ),
            array('db' => 'user_called', 'dt' => 4,
            'formatter' => function ($d, $row) {
                return $this->UserInfo($d);

            }
            ),
            array('db' => 'note_called', 'dt' => 5),
            // array(
            //     'db' => 'date_check', 'dt' => 6,
            //     'formatter' => function ($d, $row) {
            //         return date('Y-m-d h:i A', $d);
            //     }
            // ),
            // array('db' => 'user_check', 'dt' => 7),
            // array('db' => 'note_check', 'dt' => 8),
        );
        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        // $select = ' id like "%%" ';
        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
        );
    }
    function sales_staff()
    {
        $this->checkPermit('sales_staff_customers_compensation', 'customers');
        $this->adminHeaderController("تعويض الزبائن");
        require($this->render($this->folder, 'html', 'sales_staff', 'php'));
        $this->adminFooterController();
    }
    public function sales_staff_processing()
    {
        $table = "customers_compensation";
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'customer_name', 'dt' => 0),
            array('db' => 'customer_number', 'dt' => 1),
            array('db' => 'id_bill', 'dt' => 2),
            array(
                'db' => 'date_called', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),
            array('db' => 'user_called', 'dt' => 4
            ,
            'formatter' => function ($d, $row) {
                return $this->UserInfo($d);

            }),
            // array('db' => 'note_called', 'dt' => 4),
            // array(
            //     'db' => 'id', 'dt' => 5,
            //     '' => function ($d, $row) {
            //         return  '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Open modal for @fat</button>';
            //     }
            // ),
            array(
                'db' => 'id', 'dt' => 5,
                'formatter' => function ($id, $row) {
                    // if ($this->permit('update_sales_staff', $this->folder)) {
                    return "
                            <div style='text-align: center'>
                                <button class='btn btn-primary btn-pg'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                                <i class='fa fa-edit' aria-hidden='true'></i>
                                </button>
                            </div>
                            ";
                    // } else {
                    //     return $this->langControl('forbidden');
                    // }
                }
            ),
            // array to show the action buttons
            // array(
            //     'db' => 'id', 'dt' => 5,
            //     'formatter' => function ($d, $row) {
            //         return  '<a href="' . url . 'customers/update_sales_staff/' . $d . '" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
            //         <a href="' . url . 'customers/delete/' . $d . '" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            //     }
            // ),
        );
        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        // select only the rows that not have a note_check
        $select = '`check`= 0';
        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $select)
        );
    }
    // update on database by popup window show on sales_staff
    public function update_sales_staff()
    {
        $this->checkPermit('update_sales_staff', 'customers');
        $id = $_POST['id'];
        $date_check = time();
        $user_check = $this->userid;
        $note_check = $_POST['note_check'];
        $where = "id = $id";
        $data = array(
            'date_check' => $date_check,
            'user_check' => $user_check,
            'note_check' => $note_check,
            'check' => 1
        );
        $this->db->update('customers_compensation', $data, $where);
        // $this->db->close();
        echo json_encode(array('status' => 'success'));
    }
    //     $this->model->update($date_check, $user_check, $note_check, $where);
    //     $this->lightRedirect('customers/sales_staff');
    // }
    function show_all_customers_compensation()
    {
        $this->checkPermit('show_all_customers_compensation', 'customers');
        $this->adminHeaderController("تعويض الزبائن");
        require($this->render($this->folder, 'html', 'show_all', 'php'));
        $this->adminFooterController();
    }
    public function show_all_processing()
    {
        $table = "customers_compensation";
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'customer_name', 'dt' => 0),
            array('db' => 'customer_number', 'dt' => 1),
            array('db' => 'id_bill', 'dt' => 2),
            array(
                'db' => 'date_called', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),
            array('db' => 'user_called', 'dt' => 4,
            'formatter' => function ($d, $row) {
                return $this->UserInfo($d);

            }
            ),
            array('db' => 'note_called', 'dt' => 5),
            array(
                'db' => 'date_check', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    if ($d == 0) {
                        return '';
                    } else {
                        return date('Y-m-d h:i A', $d);
                    }
                }
            ),
            array('db' => 'user_check', 'dt' => 7
            ,
            'formatter' => function ($d, $row) {
                return $this->UserInfo($d);

            }),
            array('db' => 'note_check', 'dt' => 8),
            array(
                'db' => 'check', 'dt' => 9,
                'formatter' => function ($d, $row) {
                    if ($d == 0) {
                        return 'لم يتم التعويض';
                    } else {
                        return 'تم التعويض';
                    }
                }
            ),
            array(
                'db' => 'note_after_compensation',
                'dt' =>10,
                'formatter' => function($id, $row ) {
                    return $this->noteCalled($row[11],$id);
                }
            ),
            // get id from database to use it above
            array('db' => 'id', 'dt' => 11),
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
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
        );
    }

    /**
     * هاي الدالة تضيف ملاحظة الكول سنتر ويتم استدعاؤها عن طريق اجاكس
     */
    function addNoteCalled()
    {
        $note = $_POST['value1'];
        $id = $_POST['value2'];

        $sqlQ = $this->db->prepare("SELECT * FROM customers_compensation  WHERE `id`=?");
        $sqlQ->execute(array($id));

        $stmt = $this->db->prepare("update  customers_compensation set note_after_compensation=? where id=?");
        $stmt->execute(array($note,$id));
        $this->addFoundTracking($id,"note_after_compensation",$note);
    }

    /**
     * هاي الدالة تضيف اي حركة صارت على جدول اطلب مالم تجده
     *  */
    public function addFoundTracking($IdFound,$actionType,$theValue)
    {
        $stmt = $this->db->prepare("INSERT INTO `found_tracking`( `id_found`, `action_type`, `user_id`,the_value) VALUES (?,?,?,?)");
        $stmt->execute(array($IdFound,$actionType, $this->userid,$theValue));
    }

    /**
     * هاي الدالة تخلي حقل الملاحظة عباره عن مربع نص
     */
    function noteCalled($row,$id)
    {
        return "
            <div class='col-xs-2'>
                <textarea  onfocusout='addNoteCalled(this.value,$row)' class='form-control '  type='text' rows='3' >$id</textarea> <p style='font-size:10px;' >{$this->getUser($row,'note_after_compensation')}</P>
            </div>
        ";
    }

    /**
     *   هاي الدالة ترجع اسم المستخدم الي نفذ اجراء معين على جدول اطلب مالم تجده
     * وبيها رابط حتى نشوف كل التعديلات السابقة
     */
    public function getUser($idFound,$actionType)
    {
        $found = $this->db->prepare("SELECT * FROM `found_tracking`  WHERE `id_found`=? and action_type=? ORDER BY `found_tracking`.`id` DESC" );
        $found->execute(array($idFound,$actionType));
        if($found_data = $found->fetch(PDO::FETCH_ASSOC))
            return  "
            <div style='text-align: center;font-size: 18px;'>
                <span>{$this->UserInfo( $found_data['user_id'])}</span>
            </div> "
            ;
        else
            return "";
    }

    function add_customers_compensation()
    {
        $this->checkPermit('add_customers_compensation', 'customers');
        $this->adminHeaderController("اضافة تعويض الزبائن");
        require($this->render($this->folder, 'html', 'input', 'php'));
        $this->adminFooterController();
        $sendProd = false;
        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();
                $form->post('id')
                    ->val('strip_tags');
                $form->post('customer_name')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');
                $form->post('customer_number')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');
                $form->post('note_called')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');
                $form->post('id_bill')
                    ->val('strip_tags');
                $form->submit();
                $data = $form->fetch();
                $data['date_called'] = time();
                $data['date_check'] = empty($data['date_check']);
                $data['user_called'] = $this->userid;
            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = json_decode($e->getMessage(), true);
            }
        }
        // insert data to database
        if (isset($data) && !empty($data)) {
            $this->db->insert('customers_compensation', $data);
            // $this->lightRedirect('index', 1);
            $sendProd = true;
        } else {
            // message error
            $this->error_form = "حدث خطأ ما ادخل البيانات مرة اخرى";
            $sendProd = false;
        }
    }

    function checklogin(){

        if(isset($_POST['username']) && isset($_POST['password'])){
            $username = $_POST['username'];
            $password =  $_POST['password'];

            $stmt = $this->db->prepare("SELECT id FROM `user`  WHERE  username = ? and password = ?");
            $stmt->execute(array($username,$this->HASH_key('sha256', $password . trim($username), HASH_PASSWORD_KEY)));
            if ($stmt->rowCount() > 0)
            {
                $id=$stmt->fetch(PDO::FETCH_ASSOC);
                $data = ["id" => $id['id'] ];
                $JSON_data = json_encode($data);
                print_r($JSON_data);
            }
            else
            {
                $data = ["id" => "0" ];
                $JSON_data = json_encode($data);
                print_r($JSON_data);
            }
        }
    }

    function insert_phone_customer()
    {
        if(isset($_POST['phone']) && isset($_POST['userid'])){
            $data['date'] = time();
            $data['phone'] = $_POST['phone'];
            $data['userid'] = $_POST['userid'];
            $stmt = $this->db->insert('customer_con', $data);
        	echo json_encode($data['userid']);
        }
    }

    function customer_report()
    {
        $this->checkPermit('customer_report', 'customers');
        $this->adminHeaderController("تقرير الزبائن");

        require($this->render($this->folder, 'html', 'customer_report', 'php'));
        $this->adminFooterController();
    }

    function search_phone_customer()
    {
        $stmt = $this->db->prepare("SELECT phone  FROM `customer_con`  WHERE userid =? ORDER BY `id` DESC limit 1");
        $stmt->execute(array($this->userid));
        if ($stmt->rowCount() > 0 ) {
            $stmt_ = $stmt->fetch(PDO::FETCH_ASSOC);
            echo $stmt_['phone'];
        }
    }

    function register_user($id_cus)
    {
        $table = "register_user";
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'name', 'dt' => 0),
            array('db' => 'username', 'dt' => 1),
            array('db' => 'city', 'dt' => 2),
            array('db' => 'year', 'dt' => 3),
            array('db' => 'note', 'dt' => 4),
            array('db' => 'type_customer', 'dt' => 5),
            array('db' => 'date', 'dt' => 6,
                'formatter' => function ($d, $row) {
                        return date('Y-m-d', $d);
                    }
            )
        );
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        $whereall ="`id` IN ({$id_cus})";
        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns , null ,$whereall)
        );

    }

    function staff_evaluation($id_cus)
    {
        $table = 'staff_evaluation';
        $primaryKey = 'staff_evaluation.id';

        $columns = array(

            array( 'db' => 'user.username', 'dt' => 0 ),
            array('db' =>'staff_evaluation.number_smile', 'dt' => 1,
                'formatter' => function( $d, $row ) {
                    if ($d == 1) {
                        return '<i class="fa fa-smile-o"  style="font-size: 20px;color: green;"></i>';
                    } else if ($d == 2) {
                        return '<i class="fa fa-meh-o"  style="font-size: 20px;color: orange;"></i>';
                    } else if ($d == 3) {
                        return '<i class="fa fa-frown-o" style="font-size: 20px;color: red;"></i>';
                    } else {
                        return '';
                    }
                }
            ),

            array( 'db' =>'staff_evaluation.note', 'dt' => 2 ),

            array('db' =>'staff_evaluation.date', 'dt' => 3,
                'formatter' => function( $d, $row ) {

                    return date('Y-m-d h:i:s a',$d);
                }
            ),


        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = " LEFT JOIN user ON user.number = staff_evaluation.number_employee ";
        $whereAll = "staff_evaluation.id_customer IN ({$id_cus})";


        echo json_encode(SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));

    }

    function note_user($id_cus)
    {
        $table = 'note_user';
        $primaryKey = 'note_user.id';

        $columns = array(
            array( 'db' => 'user.username', 'dt' => 0 ),
            array( 'db' =>'note_user.note', 'dt' => 1 ),
            array( 'db' =>'usergroup.name', 'dt' => 2 ),
            array('db' =>'note_user.date', 'dt' => 3,
                'formatter' => function( $d, $row ) {

                    return date('Y-m-d h:i:s a',$d);
                }
            ),


        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = " INNER JOIN user ON user.id =note_user.userid  INNER JOIN usergroup ON usergroup.id = note_user.user_group";
        $whereAll = "note_user.id_customer IN ({$id_cus})";


        echo json_encode(SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));
    }

    function found($phone)
    {
        $table = "found";
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'content', 'dt' => 0),
            array('db' => 'called', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    if($d == 1)
                            return 'تم التواصل مع الزبون' ;
                        else
                            return ' لم يتم التواصل مع الزبون ' ;
                }),

            array('db' => 'note_called', 'dt' => 2),
            array('db' => 'date', 'dt' => 3,
                'formatter' => function ($d, $row) {
                        return date('Y-m-d', $d);
                    }
            )
        );
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        $whereall ="`title` like '%{$phone}%'";

        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns , null ,$whereall)
        );
    }

    function customers_compensation($phone)
    {
        $table = "customers_compensation";
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'customer_name', 'dt' => 0),
            array('db' => 'customer_number', 'dt' => 1),
            array('db' => 'id_bill', 'dt' => 2),
            array(
                'db' => 'date_called', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i A', $d);
                }
            ),
            array('db' => 'user_called', 'dt' => 4,
            'formatter' => function ($d, $row) {
                return $this->UserInfo($d);

            }
            ),
            array('db' => 'note_called', 'dt' => 5),
            array(
                'db' => 'date_check', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    if ($d == 0) {
                        return '';
                    } else {
                        return date('Y-m-d h:i A', $d);
                    }
                }
            ),
            array('db' => 'user_check', 'dt' => 7
            ,
            'formatter' => function ($d, $row) {
                return $this->UserInfo($d);

            }),
            array('db' => 'note_check', 'dt' => 8),
            array(
                'db' => 'check', 'dt' => 9,
                'formatter' => function ($d, $row) {
                    if ($d == 0) {
                        return 'لم يتم التعويض';
                    } else {
                        return 'تم التعويض';
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
        $whereall ="`customer_number` like '%{$phone}%'";
        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns ,null ,$whereall)
        );
    }

    function coupon($phone){
        $table = "user_coupon";
        $primaryKey = 'user_coupon.id';
        $columns = array(
            array( 'db' => 'user_coupon.id_coupon', 'dt' => 0 ,
                'formatter' => function( $d, $row ) {
                    return $this->group_coupon($d) ;
                }
            ),
            array( 'db' => 'user_coupon.id_user', 'dt' => 1,
                'formatter' => function( $d, $row ) {
                    return $this->name_user_coupon($d) ;
                }
            ),
            array( 'db' => 'register_user.phone', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                    return $this->count_used_coupon($d) ;
                }
            ),
            array( 'db' => 'user_coupon.date', 'dt' => 3 ,
            'formatter' => function( $d, $row ) {
                return date( 'Y-m-d h:i A', $d);
            }
        ),
        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        $join = " INNER JOIN  register_user ON user_coupon.id_customer = register_user.id ";
        $whereAll = " register_user.phone like '%{$phone}%' ";
        $group="GROUP BY user_coupon.id_customer";
        echo json_encode(
            SSP::complex_join( $_GET, $sql_details, $table, $primaryKey, $columns,$join, null, $whereAll , null,$group)
        );
    }

    function count_used_coupon($phone)
    {
        $stmt = $this->db->prepare("SELECT count(user_coupon.id) as count_ FROM `user_coupon` ,register_user where  user_coupon.id_customer = register_user.id and user_coupon.state=0 and register_user.phone = ? ;");
        $stmt->execute(array($phone));
        $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt_data['count_'];
    }

    function name_user_coupon($id_user)
    {
        $stmt = $this->db->prepare("SELECT `username` FROM `user` WHERE `id` = ?");
        $stmt->execute(array($id_user));
        $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt_data['username'];
    }

    function group_coupon($id_coupon)
    {
        $stmt = $this->db->prepare("SELECT `name_group` FROM `coupon` INNER JOIN  groups_coupons ON coupon.id_group = groups_coupons.id WHERE groups_coupons.id = ?");
        $stmt->execute(array($id_coupon));
        $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt_data['name_group'];
    }

    function purchase_customer($id_cus)
    {
        $table = "purchase_customer_item";
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'table', 'dt' => 0,
                'formatter' => function ($d, $row) {
                        return $this->name_item($d, $row[5]);
                    }
            ),
            array('db' => 'number_bill', 'dt' => 1),
            array('db' => 'price_purchase', 'dt' => 2),
            array('db' => 'price_sale', 'dt' => 3),
            array('db' => 'date', 'dt' => 4,
                'formatter' => function ($d, $row) {
                        return date('Y-m-d', $d);
                }
            ),
            array('db' => 'id_item', 'dt' => 5)

        );
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        $whereall ="`id_customer` IN ({$id_cus})";
        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns , null ,$whereall)
        );
    }

    function name_item($table,$id_item)
    {
        if($table == 'savers') $table = 'product_savers' ;

        $stmt = $this->db->prepare("SELECT `title` FROM `{$table}`  WHERE id = ?");
        $stmt->execute(array($id_item));
        $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt_data['title'];
    }

     function cart_shop($id_cus)
    {
        $table = 'cart_shop_all';
        $primaryKey = 'cart_shop_all.id';

        $columns = array(

            array( 'db' => 'cart_shop_all.number_bill', 'dt' => 0 ),
            array('db' =>'cart_shop_all.number_bill', 'dt' => 1,
                'formatter' => function( $d, $row ) {
                    return $this->all_orders_bill($d,$row[4]);
                }
            ),

            array('db' =>'cart_shop_all.number_bill', 'dt' => 2,
                'formatter' => function( $d, $row ) {
                    return $this->sum_price($d);
                }
            ),

            array('db' =>'cart_shop_all.date', 'dt' => 3,
                'formatter' => function( $d, $row ) {

                    return date('Y-m-d h:i:s a',$d);
                }
            ),
            array( 'db' => 'cart_shop_all.table', 'dt' => 4)


        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = null ;
        $whereAll = "cart_shop_all.id_member_r IN ({$id_cus})";
        $group="GROUP BY cart_shop_all.number_bill";

        echo json_encode(SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,1));

    }

    function sum_price($number_bill)
    {
        $stmt = $this->db->prepare("SELECT  `price_dollars`,`dollar_exchange` FROM `cart_shop_all` WHERE `number_bill`=?");
        $stmt->execute(array($number_bill));
        $data= array();
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $data[] = str_replace(',','',$this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']));
        }
        return number_format(array_sum($data));
    }

    function all_orders_bill($number_bill,$table){
        $stmt = $this->db->prepare("SELECT `cart_shop_all`.* ,title FROM `cart_shop_all` inner JOIN {$table} ON  `cart_shop_all`.id_item = $table.id WHERE `number_bill`=?");
        $stmt->execute(array($number_bill));
        $result = '<table  style="background: #e0e0eb; border: 2px solid #f2f2f2;">
                    <tr style="background: #f2f2f2;">
                        <td>اسم المنتج</td>
                        <td>القسم</td>
                        <td>الكود</td>
                        <td>اللون</td>
                        <td>العدد</td>
                        <td>السعر</td>
                        <td>التاريخ والوقت</td>
                    </tr> ';

        while($row = $stmt->fetch(PDO::FETCH_ASSOC) )
        {
            $result .= '<tr style="background: #fff;">
                            <td>'.$row['title'].'</td>
                            <td>'.$row['table'].'</td>
                            <td>'.$row['code'].'</td>
                            <td>'.$row['color'].'</td>
                            <td>'.$row['number'].'</td>
                            <td>'.$row['price'].'</td>
                            <td>'.date('Y-m-d h:i:s a',$row['date']).'</td>
                        </tr> ';
        }

        $result .= '</table>' ;
        return $result ;
    }

    function get_id_customer($phone)
    {
        $stmt = $this->db->prepare("SELECT id  FROM `register_user`  WHERE phone =? ");
        $stmt->execute(array($phone));
        $data = "";
        if ($stmt->rowCount() > 0) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $data .= $row['id']. ",";
            }
            echo $data;
        }else{
            echo $data;
        }
    }
}
