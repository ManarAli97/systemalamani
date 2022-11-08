<?php
//  Include PHPExcel_IOFactory
include 'PHPExcel/Classes/PHPExcel.php';
class Controller
{
    public $header = 'header';
    public $footer = 'footer';
    public $table = '';
    public $lang = array();
    public $img;
    public $folder = 'folder';
    public $userid;
    public $c = 'red';
    public $idGroup = '';
    public $error_form = array();
    public $tableCreated = array();
    public $tableNotCreated = array();
    public $idAdmin = array();
    public $langControl = 'ar';
    public $langSite = 'ar';
    public $numberLangSite = array('ar', 'en');
    public $dirSite = 'ltr';
    public $dirControl = 'ltr';
    public $save_file = '';
    public $show_file_site = '';
    public $root_file = '';
    public $static_file_control = '';
    public $static_file_site = '';
    public $pathBreadcumbs = array();
    public $id_category = array();
    public $languageSite = 'useful';
    public $session_language = 'useful';
    public $ltr_rtl = 'left';
    public $phone = 'true';
    public $bast_it = 1;
    public $active_wholesale_price = false;
    public $non = array('NON', 'non', 'UNKNOWN', 'unknown', 'Unknown', 'Non', 'بلا', '', ' ', '  ');
    public $pointer_sale_quantity = false;
    public $pointer_purchases_quantity = false;
    public $comma = [',', ".", "د.ع", "$", " "];
    public $num = 0; /* for compare_warehouses   */
    public $version = 0.1;
    public $category_website = array();
    public $stopUrl = url . "/errors/stop";
    public $id_money_clipper = 0;
    public $expire_session = "+8 hour";
    public $idd1 = array(315, 317, 318, 319, 320, 321, 322, 323,542);
    public $price_type=array('1'=>'سعر الجملة','2'=>'سعر جملة الجملة','3'=>'سعر التكلفة');
    public $print_devices=array('1'=>'print 1','2'=>'print 2','3'=>'print 3');
    public $model_big_q=array('network','camera'); //اقسام ذات كميات كبيرة بالتجهيز
    public $is_delete=" is_delete = 0 ";
    public $check_name_category = 0;

    function __construct()
    {

        // for HTML and Confirm Form Resubmission
        ob_start();
        // header('Cache-Control: no cache');

        //Object
        //Object

        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject


        $this->folder = strtolower(get_class($this));
        Session::init();
        if (Session::get('loggedIn') == true) {
            $this->idGroup = Session::get('idGroup');
            $this->userid = Session::get('userid');
            $this->idAdmin = $this->adminUser();

            $this->controlUser($this->userid);
            $this->autoLogOut();
            $this->activeUser($this->userid);

        }

        $this->langControl = $this->langControlDefault();
        if (in_array($this->langControl, array('ar', 'fa'))) {
            $this->dirControl = 'rtl';
        }
        $this->langSite = $this->langSiteDefault();
        if (in_array($this->langSite, array('ar', 'fa'))) {
            $this->dirSite = 'rtl';
            $this->ltr_rtl = 'right';
        }

        //url file her
        $this->save_file = url . "/public/$this->langControl/save_file/"; // show file in control panel
        $this->show_file_site = url . "/public/$this->langSite/save_file/"; //show files in site
        $this->root_file = ROOT . "/public/$this->langControl/save_file/";  // root save folder in file #save_file
        $this->dowinload_file = ROOT . "/public/$this->langControl/download/";  // root save folder in file #save_file
        $this->static_file_control = url . "/public/$this->langControl"; // call url file in HeaderAdmin and FooterAdmin control panel
        $this->static_file_site = url . "/public/$this->langSite";  // call url files in Header and Footer site


        if (isset($_SESSION['username_member_r'])) {

            $stmt = $this->db->prepare("SELECT *FROM `register_user` WHERE username = ? AND `phone` = '' LIMIT 1");
            $stmt->execute(array($_SESSION['username_member_r']));
            if ($stmt->rowCount() > 0) {

                $this->phone = 'false';
            }


            if ($this->active_wholesale_price()) {
                $this->active_wholesale_price = true;
            }
        }

        if(!isset($_SESSION['print']))
        {
            $_SESSION['print']='';
            $_SESSION['number_copy']=1;
        }


        if (Session::get('bast_it') == 1) {
            $this->bast_it = "`bast_it`= 1";
        }


        $this->category_website = array(
            'mobile' => $this->langControl('mobile'),
            'accessories' => $this->langControl('accessories'),
            'camera' => $this->langControl('camera'),
            'games' => $this->langControl('games'),
            'network' => $this->langControl('network'),
            'savers' => $this->langControl('savers'),
            'computer' => $this->langControl('computer'),
            'printing_supplies' => $this->langControl('printing_supplies'),
        );


    }



    function activeUser($id)
    {


            $stmt = $this->db->prepare("SELECT *FROM  `user` WHERE  `id`  = ?  ");
            $stmt->execute(array($id));
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result['active'] == 0 && $result['idGroup'] != 0) {

                    session_destroy();

                    echo '
                   <div  style="    text-align: center; background: #ffc107;padding: 15px;font-size: 22px;font-weight: bold;" role="alert">
                  <span> الحساب غير فعال </span> <a href="'.url .'/login/user" class="alert-link"> رجوع </a>
                </div>
                ';
                    die();
                }
            }

    }







    function active_wholesale_price()
    {
        $stmt = $this->db->prepare("SELECT *FROM  `register_user` WHERE `id` = ? AND `active_wholesale_price`= 1 ");
        $stmt->execute(array(Session::get('id_member_r')));
        if ($stmt->rowCount() > 0) {
            return true;
        }

    }


    public function adminHeaderController($title = 'myWebsitr', $id = null)
    {

        if (isset($_SESSION['loggedIn'])) {
            if ($_SESSION['direct'] == 1) {
                //                die('Access denied :) ');
                header("Location:" . url);
            }

        }

        $this->header = new Header();
        $this->header->adminHeader($title, $id);
    }

    public function adminFooterController()
    {
        $this->footer = new Footer();
        $this->footer->adminFooter();
    }


    public function adminFooterController2()
    {
        $this->footer = new Footer();
        $this->footer->adminFooter2();
    }


    public function publicHeader($title = 'myWebsitr')
    {
        $this->header = new Header();
        $this->header->public_header($title);
    }

    public function publicFooter()
    {
        $this->footer = new Footer();
        $this->footer->public_footer();
    }


    public function render($models, $htmlFolder, $nameFile, $typefile = 'html', $noInclude = false)
    {
        $path = 'controllers/' . strtolower($models) . '/' . $htmlFolder . '/' . $nameFile . '.' . $typefile;
        return $path;
    }


    public function lang($word)
    {

        if (array_key_exists($word, $this->lang)) {
            return $this->lang[$word];

        } else {
            return $word;

        }
    }

    // H27 تم التعديل على هذه الدالة بتاريخ 10-9-2022
    public function permit($aclname = NULL, $aclgroup = NULL)
    {

        if ($aclname == NULL) {
            return TRUE;
        }
        // اذا كان غير مضاف
        $stmt = $this->db->prepare("SELECT * from `permitgroup` WHERE `aclname`='{$aclname}' AND `aclgroup`='$aclgroup' ");
        $stmt->execute();
        if($stmtPermit = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $idParmit = $stmtPermit['id'];
        }
        else{
            // return 'else';
            $data = array('aclname' => $aclname, 'aclgroup' => $aclgroup);

            $stmt = $this->db->insert("permitgroup", $data);
            $idParmit = $this->db->lastInsertId();

        }

        if (in_array($this->userid, $this->idAdmin)) {
            return true;
        }
        $stmt_permit = $this->db->prepare("SELECT id from `permit`   WHERE `idGroup`={$this->idGroup}  AND `idParmit` ={$idParmit}  AND `permit` =1 UNION SELECT id FROM `permit_user` where  id_user ={$this->userid} and idParmit={$idParmit} and permit =1 ");
        $stmt_permit->execute();

        if($row = $stmt_permit->fetch(PDO::FETCH_ASSOC))
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function checkPermit($aclname = NULL, $aclgroup = NULL)
    {
        if ($this->handleLogin()) {
            if (!empty($aclname)) {
                if ($this->permit($aclname, $aclgroup) == false) {
                    die($this->langControl($aclname) . '  لا تمتلك صلاحية دخول الى هذا القسم:  ');
                }
            }
        } else die('does not have authorization to perform action !!!');
    }


    public function handleLogin()
    {

        if (isset($_SESSION['loggedIn'])) {
            $this->userid = Session::get('userid');
            $stmt = $this->db->prepare("UPDATE user SET session = ? WHERE id=?");
            $stmt->execute(array(strtotime($this->expire_session), $this->userid));
            return true;
        } else {
            if (isset($_COOKIE['g_active']))
            {
                header("Location:" . url . "/login/user?g=1"); // games category disk

            }else
            {
                header("Location:" . url . "/login/user");
            }
        }
    }


    function autoLogOut()
    {
        $stmt = $this->db->prepare("SELECT * FROM user  WHERE id=? AND session < ?");
        $stmt->execute(array($this->userid, time()));
        if ($stmt->rowCount() > 0) {
            header("Location:" . url . "/login/logout");
        } else {
            return true;
        }
    }

    public function adminUser()
    {
        $stmt = $this->db->prepare("SELECT  id FROM `user` WHERE `role`=?");
        $stmt->execute(array('admin'));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $id_admin = array();
        if (!empty($result)) {
            foreach ($result as $id_idmin) {
                $id_admin[] = $id_idmin['id'];
            }
        }
        return $id_admin;
    }


    public static function HASH_key($algo, $data, $key = HASH_PASSWORD_KEY)
    {
        $context = hash_init($algo, HASH_HMAC, $key);
        hash_update($context, $data);
        return hash_final($context);
    }


// language set


    public function langControlDefault()
    {
        $data = $this->db->select("SELECT  lang_control FROM setlang WHERE `active_lang_control`=:active_lang_control AND `lang_control` <> :lang_control LIMIT 1", array(':active_lang_control' => 1, 'lang_control' => ''));
        if (!empty($data)) {
            return $data[0]['lang_control'];
        } else {
            return $this->langControl;
        }
    }


    public function langSiteDefault()
    {
        if (!isset($_SESSION[$this->session_language])) {
            $data = $this->db->select("SELECT  lang_site FROM setlang WHERE `active_lang_site`=:active_lang_site AND `lang_site` <> :lang_site LIMIT 1", array(':active_lang_site' => 1, 'lang_site' => ''));
            if (!empty($data)) {
                return $data[0]['lang_site'];
            } else {
                return $this->langSite;
            }
        } else {
            if (in_array($_SESSION[$this->session_language], $this->numberLangSite())) {
                //  print_r($this->numberLangSite());
                return $_SESSION[$this->session_language];
            } else {
                return $this->langSite;
            }
        }

    }


    public function numberLangSite()
    {
        $data = $this->db->select("SELECT  lang_site FROM setlang WHERE `lang_site` <> :lang_site", array('lang_site' => ''));
        if (!empty($data)) {
            foreach ($data as $key => $lang) {
                $this->numberLangSite[$key] = $lang['lang_site'];
            }
        }
        return $this->numberLangSite;
    }


    /**
     * @param $key
     * @return string
     */

    public function langControl($key)
    {
        $data = $this->db->select("SELECT  {$this->langControl} FROM `lang` WHERE `key` = :key", array('key' => $key));

        if (!empty($data)) {
            return $data[0][$this->langControl];
        } else {
            return $key;
        }

    }

    /**
     * @param $key
     * @return string
     */
    public function langSite($key)
    {
        $data = $this->db->select("SELECT  {$this->langSite} FROM `lang` WHERE `key` = :key", array('key' => $key));
        if (!empty($data)) {
            return $data[0][$this->langSite];
        } else {
            return $key;
        }
    }


// end functions lang


    public function Breadcumbs($tbale, $id)
    {

        $stmt = $this->db->prepare("SELECT * from  `{$tbale}`  WHERE `id`=? AND  {$this->is_delete}");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $result = $result[0];
            $stmt = $this->db->prepare("SELECT * from   `{$tbale}`  WHERE `relid`=? AND  {$this->is_delete} ");
            $stmt->execute(array($id));
            if ($stmt->rowCount() > 0) {
                $this->pathBreadcumbs[$result['title']] = url . '/' . $this->folder . '/admin_category/' . $result['id'];
            } else {
                $this->pathBreadcumbs[$result['title']] = '#';
            }
            $this->Breadcumbs($tbale, $result['relid']);
            return array_reverse($this->pathBreadcumbs, true);

        }

    }

    public function BreadcumbsPublic($tbale, $id)
    {

        $stmt = $this->db->prepare("SELECT * from  `{$tbale}`  WHERE `id`=? AND  {$this->is_delete}");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $result = $result[0];
            $stmt = $this->db->prepare("SELECT * from   `{$tbale}`  WHERE `relid`=? AND  {$this->is_delete}");
            $stmt->execute(array($id));
            if ($stmt->rowCount() > 0) {
                if (!isset($_COOKIE['g_active']))
                {
                    $this->pathBreadcumbs[$result['title']] = url . '/' . $this->folder . '/list_view/' . $result['id'];

                }
            } else {
                $this->pathBreadcumbs[$result['title']] = '#';
            }
            $this->BreadcumbsPublic($tbale, $result['relid']);
            return array_reverse($this->pathBreadcumbs, true);

        }

    }


    public function BreadcumbsPublic_id_category($tbale, $id)
    {

        $stmt = $this->db->prepare("SELECT * from  `{$tbale}`  WHERE `id`=? AND  {$this->is_delete}");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $result = $result[0];
            $stmt = $this->db->prepare("SELECT * from   `{$tbale}`  WHERE `relid`=? AND  {$this->is_delete}");
            $stmt->execute(array($id));
            if ($stmt->rowCount() > 0) {
                $this->id_category[$result['id']] = $result['id'];
            } else {
                $this->id_category[$result['id']] = $result['id'];
            }
            $this->BreadcumbsPublic_id_category($tbale, $result['relid']);
            return array_reverse($this->id_category, true);

        }

    }

    /*
     * $menu 1 delete cache  menu
     */
    public function lightRedirect($location, $timeout = '0', $menu = 0)
    {
        if ($menu) {
            echo "<script type='text/javascript'>
              localStorage.removeItem('menu');
             setTimeout(function(){ window.location = '{$location}'; }, {$timeout});</script>";

        } else {
            echo " <script type='text/javascript'>    setTimeout(function(){ window.location = '{$location}'; }, {$timeout});</script>";

        }
    }

    public function sm($successMessage)
    {
        return
            "
         <div id='snackbar'> {$successMessage} </div>
        <script>
         var x = document.getElementById('snackbar');
         x.className = 'show';
         setTimeout(function(){ x.className = x.className.replace('show', ''); }, 30000);
         </script>
         ";
    }


    function pointer_sale_quantity($id)
    {

        $stmt = $this->db->prepare("SELECT *FROM  `user` WHERE  `id`  = ? ");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt_groups = $this->db->prepare("SELECT *FROM `usergroup` WHERE `id`=? AND  (`name` LIKE '%مبيعات%' OR `name` LIKE '%مبيع%')  ");
        $stmt_groups->execute(array($result['idGroup']));
        if ($stmt_groups->rowCount() > 0) {
            return true;
        } else {
            if ($result['role'] == 'admin') {
                return true;
            } else {
                return false;
            }


        }

    }


    function pointer_purchases_quantity($id)
    {

        $stmt = $this->db->prepare("SELECT *FROM  `user` WHERE  `id`  = ? ");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt_groups = $this->db->prepare("SELECT *FROM `usergroup` WHERE `id`=? AND  (`name` LIKE '%مشتري%' OR `name` LIKE '%مشتريات%')  ");
        $stmt_groups->execute(array($result['idGroup']));
        if ($stmt_groups->rowCount() > 0) {
            return true;
        } else {
            if ($result['role'] == 'admin') {
                return true;
            } else {
                return false;
            }


        }

    }

    function category_permit($model, $id)
    {
        $stmt = $this->db->prepare("SELECT *FROM  `user` WHERE  `id`  = ? ");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("SELECT *FROM `user_purchases_catg` WHERE `catg`=? AND  `id_user`=?");
        $stmt->execute(array($model, $id));
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            if ($result['role'] == 'admin') {
                return true;
            } else {
                return false;
            }
        }

    }


    function ifAdmin($id)
    {
        $stmt = $this->db->prepare("SELECT *FROM  `user` WHERE  `id`  = ? ");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['role'] == 'admin') {
            return false;
        } else {
            return true;
        }

    }


    function admin($id)
    {
        $stmt = $this->db->prepare("SELECT *FROM  `user` WHERE  `id`  = ? ");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['role'] == 'admin') {
            return true;
        } else {
            return false;
        }

    }


    function pointer_purchases_man($id)
    {

        $stmt = $this->db->prepare("SELECT *FROM  `user` WHERE  `id`  = ? ");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt_groups = $this->db->prepare("SELECT *FROM `usergroup` WHERE `id`=? AND  (`name` LIKE '%مشتري%' OR `name` LIKE '%مشتريات%')  ");
        $stmt_groups->execute(array($result['idGroup']));
        if ($stmt_groups->rowCount() > 0) {
            return true;
        } else {
            if ($result['role'] == 'admin') {
                return true;
            } else {
                return false;
            }

        }
    }

    function pointer_delegate_man($id)
    {

        $stmt = $this->db->prepare("SELECT *FROM  `user` WHERE  `id`  = ? ");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt_groups = $this->db->prepare("SELECT *FROM `usergroup` WHERE `id`=? AND  (`name` LIKE '%مندوبين%' OR `name` LIKE '%مندوب%')  ");
        $stmt_groups->execute(array($result['idGroup']));
        if ($stmt_groups->rowCount() > 0) {
            return true;
        } else {
            if ($result['role'] == 'admin') {
                return true;
            } else {
                return false;
            }

        }
    }

    function region_all($id)
    {

        $stmt = $this->db->prepare("SELECT *FROM  `region` WHERE  `id`  = ? ");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['title'];
    }

    function loginUser()
    {


        if (isset($_SESSION['loggedIn'])) {
            if (in_array($_SESSION['userid'], $this->idd1) && $_SESSION['direct'] == 1) {
                return false;
            } else {
                return true;
            }

        } else {
            return false;
        }
    }


    function uuid($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function isDirect()
    {
        if (isset($_SESSION['direct'])) {
            return true;
        } else {
            return false;
        }
    }

    function isUuid()
    {

        if (isset($_SESSION['direct'])) {
            return $_SESSION['uuid'];
        } else {
            return 0;
        }

    }

    function price_dollars($price_dollars)
    {
        $price = $this->price_dollarsAdmin($price_dollars);
        return $this->around((int)str_replace($this->comma, '', $price));
    }

    function min_price($price_dollars) /*  for ring excel */
    {
        $price = $this->price_dollarsAdmin($price_dollars);
        $price_string = $this->around((int)str_replace($this->comma, '', $price));
        $split = explode('-', $price_string);
        return (int)str_replace($this->comma, '', $split[0]);

    }

    function max_price($price_dollars) /*  for ring excel */
    {
        $price = $this->price_dollarsAdmin($price_dollars);
        $price_string = $this->around((int)str_replace($this->comma, '', $price));
        $split = explode('-', $price_string);
        if (count($split) == 2) {
            return (int)str_replace($this->comma, '', $split[1]);
        } else {
            return (int)str_replace($this->comma, '', $split[0]);
        }

    }

    function rate($r, $t)
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `rate` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `rate` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `type` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $fromDate = strtotime(date('Y-m-d', time()));
        $toDate = time();

        $stmt = $this->db->prepare("SELECT *FROM `rate` WHERE `type`=? AND `date` BETWEEN ? AND  ? ");
        $stmt->execute(array($t, $fromDate, $toDate));
        if ($stmt->rowCount() > 0) {
            $rate = $stmt->fetch(PDO::FETCH_ASSOC);
            return $rate['rate'];
        } else {

            $stmtCh = $this->db->prepare("SELECT *FROM `rate` WHERE `type`=?  ");
            $stmtCh->execute(array($t));
            if ($stmtCh->rowCount() > 0) {
                $stmtUp = $this->db->prepare("UPDATE `rate` SET `rate`=?,`date`=? WHERE `type`=?");
                $stmtUp->execute(array($r, time(), $t));
                return $r;
            } else {
                $stmtIn = $this->db->prepare("INSERT INTO `rate` ( `rate`, `type`, `date`) VALUES (?,?,?)");
                $stmtIn->execute(array($r, $t, time()));
                return $r;

            }
        }


    }


    function around($price)
    {

        if ($price >= 1 && $price <= 1000) {
            $r = $this->rate(rand(124.5, 249), 1);
            $r2 = $this->rate(rand(87.15, 249), 2);
            return number_format($price - $r) . ' - ' . number_format($price + $r2);
        } elseif (($price >= 1001 && $price <= 3000)) {
            $r = $this->rate(rand(375, 750), 3);
            $r2 = $this->rate(rand(262.5, 750), 4);
            return number_format($price - $r) . ' - ' . number_format($price + $r2);
        } elseif (($price >= 3001 && $price <= 5000)) {
            $r = $this->rate(rand(750, 1500), 5);
            $r2 = $this->rate(rand(525, 1500), 6);
            return number_format($price - $r) . ' - ' . number_format($price + $r2);
        } elseif (($price >= 5001 && $price <= 9000)) {
            $r = $this->rate(rand(1000, 2000), 7);
            $r2 = $this->rate(rand(700, 2000), 8);
            return number_format($price - $r) . ' - ' . number_format($price + $r2);
        } elseif (($price >= 9001 && $price <= 15000)) {
            $r = $this->rate(rand(1250, 2500), 9);
            $r2 = $this->rate(rand(875, 2500), 10);
            return number_format($price - $r) . ' - ' . number_format($price + $r2);
        } elseif (($price >= 15001 && $price <= 50000)) {
            $r = $this->rate(rand(1500, 3000), 11);
            $r2 = $this->rate(rand(1050, 3000), 12);
            return number_format($price - $r) . ' - ' . number_format($price + $r2);
        } elseif (($price >= 50001 && $price <= 100000)) {
            $r = $this->rate(rand(2000, 4000), 13);
            $r2 = $this->rate(rand(1400, 4000), 14);
            return number_format($price - $r) . ' - ' . number_format($price + $r2);
        } elseif (($price >= 100001 && $price <= 150000)) {
            $r = $this->rate(rand(2250, 4500), 15);
            $r2 = $this->rate(rand(1575, 4500), 16);
            return number_format($price - $r) . ' - ' . number_format($price + $r2);
        } elseif (($price >= 150001 && $price <= 200000)) {
            $r = $this->rate(rand(2750, 5500), 17);
            $r2 = $this->rate(rand(1925, 5500), 18);
            return number_format($price - $r) . ' - ' . number_format($price + $r2);
        } elseif (($price >= 200001 && $price <= 300000)) {
            $r = $this->rate(rand(3250, 6500), 19);
            $r2 = $this->rate(rand(2275, 6500), 20);
            return number_format($price - $r) . ' - ' . number_format($price + $r2);
        } elseif (($price >= 300001 && $price <= 400000)) {
            $r = $this->rate(rand(3750, 7500), 21);
            $r2 = $this->rate(rand(2625, 7500), 22);
            return number_format($price - $r) . ' - ' . number_format($price + $r2);
        } elseif (($price >= 400001 && $price <= 500000)) {
            $r = $this->rate(rand(4250, 8500), 23);
            $r2 = $this->rate(rand(2975, 8500), 24);
            return number_format($price - $r) . ' - ' . number_format($price + $r2);
        } elseif (($price >= 500001 && $price <= 650000)) {
            $r = $this->rate(rand(4750, 9500), 25);
            $r2 = $this->rate(rand(3325, 9500), 26);
            return number_format($price - $r) . ' - ' . number_format($price + $r2);
        } elseif (($price >= 650001 && $price <= 750000)) {
            $r = $this->rate(rand(5500, 11000), 27);
            $r2 = $this->rate(rand(3850, 11000), 28);
            return number_format($price - $r) . ' - ' . number_format($price + $r2);
        } elseif (($price >= 750001 && $price <= 1000000)) {
            $r = $this->rate(rand(6000, 12000), 29);
            $r2 = $this->rate(rand(4200, 12000), 30);
            return number_format($price - $r) . ' - ' . number_format($price + $r2);
        } elseif (($price >= 1000001)) {
            $r = $this->rate(rand(6750, 13500), 31);
            $r2 = $this->rate(rand(4725, 13500), 32);
            return number_format($price - $r) . ' - ' . number_format($price + $r2);
        } else {
            return $price;
        }

    }


    function price_dollarsAdmin($price_dollars, $dollar_exchange = null)
    {


        if (!empty($dollar_exchange) && $dollar_exchange != '' && $dollar_exchange != 0) {


            $price = explode('-', $price_dollars);


            if (count($price) == 2) {
                $f1 = (double)trim(str_replace(',', '.', $price[0]));
                $price1 = ($f1 * $dollar_exchange);
                $filter_price = number_format(round($price1));
                return $this->outPrice($filter_price);
            } else {
                $f1 = (double)trim(str_replace(',', '.', $price[0]));
                $price1 = ($f1 * $dollar_exchange);
                $filter_price = number_format(round($price1));
                return $this->outPrice($filter_price);
            }


        } else {


            $price1 = 0;
            $price2 = 0;
            $stmt = $this->db->prepare("SELECT *FROM `dollar_price`  WHERE `active` = 1  ORDER BY `id` DESC  LIMIT 1");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $price = explode('-', $price_dollars);

                $f1 = (double)trim(str_replace(',', '.', $price[0]));
                $price1 = ($f1 * $result['dollar']);
                $filter_price = number_format(round($price1));
                return $this->outPrice($filter_price);
            } else {
                return 0;
            }
        }

    }


    function not_round_price($price_dollars, $dollar_exchange = null)
    {


        if (!empty($dollar_exchange) && $dollar_exchange != '' && $dollar_exchange != 0) {


            $price = explode('-', $price_dollars);


            if (count($price) == 2) {
                $f1 = (double)trim(str_replace(',', '.', $price[0]));
                $price1 = ($f1 * $dollar_exchange);
                $filter_price = number_format(round($price1));
                return $filter_price;
            } else {
                $f1 = (double)trim(str_replace(',', '.', $price[0]));
                $price1 = ($f1 * $dollar_exchange);
                $filter_price = number_format(round($price1));
                return $filter_price;
            }


        } else {


            $price1 = 0;
            $price2 = 0;
            $stmt = $this->db->prepare("SELECT *FROM `dollar_price`  WHERE `active` = 1  ORDER BY `id` DESC  LIMIT 1");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $price = explode('-', $price_dollars);

                $f1 = (double)trim(str_replace(',', '.', $price[0]));
                $price1 = ($f1 * $result['dollar']);
                $filter_price = number_format(round($price1));
                return $filter_price;
            } else {
                return 0;
            }
        }

    }

    function check_item_round($table, $id)
    {
        if ($table == 'offers') {
            return true;
        }
        $stmt_round_price = $this->db->prepare("SELECT *FROM {$table} WHERE  id=? AND `change_price`=1  ");
        $stmt_round_price->execute(array($id));
        if ($stmt_round_price->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    function outPrice($filter_price)
    {
        $f_price = explode(',', $filter_price);
        if (count($f_price) == 1) {
            return $this->filter_price_round($f_price[0]);
        } else if (count($f_price) == 2) {
            if ($this->filter_price_round($f_price[1]) >= 1000) {
                $one = 1;
                return number_format((int)$f_price[0] + $one . '000');
            } else {
                return $f_price[0] . ',' . $this->filter_price_round($f_price[1]);
            }
        } else if (count($f_price) == 3) {
            if ($this->filter_price_round($f_price[2]) >= 1000) {
                $one = 1;
                $milliom = ($f_price[0] . $f_price[1]);
                return number_format((int)$milliom + $one . '000');
            } else {
                $milliom = ($f_price[0] . $f_price[1]);
                return number_format($milliom . $this->filter_price_round($f_price[2]));
            }
        } else {
            return $filter_price;
        }

    }

    function filter_price_round($price)
    {
        $stmt = $this->db->prepare("SELECT `amount` FROM `range_table` WHERE  {$price} BETWEEN from_amount  AND to_amount AND `active`=1  LIMIT 1");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['amount'];
        } else {
            return $price;
        }

    }


    function cuts($id, $table)
    {

        $stmt = $this->db->prepare("SELECT *FROM {$table} WHERE `id`=? AND `cuts`=1");
        $stmt->execute(array($id));
        if ($stmt->rowCount()) {

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $price = explode('-', $result['price_cuts']);

            if (count($price) == 2) {

                $f1 = (double)trim(str_replace(',', '.', $price[0]));
                $f2 = (double)trim(str_replace(',', '.', $price[1]));
                return number_format(round($f1)) . ' - ' . number_format(round($f2));
            } else {
                $f1 = (double)trim(str_replace(',', '.', $price[0]));
                return number_format(round($f1));
            }


        } else {
            return false;
        }


    }



    function getNumberBill($l)
    {

        return   $this->runInDBTransaction(function () use ($l ) {

            $max = $this->db->prepare("SELECT  MAX(number_bill) as number_bill FROM cart_shop_active LIMIT 1");
            $max->execute();
            if ($max->rowCount() > 0)
            {
                $result=$max->fetch(PDO::FETCH_ASSOC);
                $bill=(int)$result['number_bill'];

                $ret_item= $this->db->prepare("SELECT    MAX(number_bill) as number_bill FROM retrieve_item   LIMIT 1");
                $ret_item->execute();
                $rel_item_result=$ret_item->fetch(PDO::FETCH_ASSOC);
                $bill2=(int)$rel_item_result['number_bill'];
                if ($bill > $bill2)
                {
                    return   $bill  + 1;
                }else
                {
                    return   $bill2  + 1;
                }
            }else
            {
                return 1;
            }
        });
    }




    function purchase_customer_number_bill_create($l)
    {

        $newNumberBill = $this->db->prepare("SELECT  * FROM `purchase_customer_bill` WHERE id !=0  ORDER BY number_bill DESC");
        $newNumberBill->execute();
        if ($newNumberBill->rowCount() > 0) {
            $numberBill = $newNumberBill->fetch(PDO::FETCH_ASSOC);
            return (int)$numberBill['number_bill'] + 1;

        } else {
            return 1;
        }
    }

    function uuid_getNumberBill($digits)
    {

        $randomString = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        return $randomString;
    }


    function getNumberBillReview($l)
    {

        $newNumberBill = $this->db->prepare("SELECT * FROM `review` WHERE 1 ORDER BY number_bill_new DESC");
        $newNumberBill->execute();
        if ($newNumberBill->rowCount() > 0) {
            $numberBill = $newNumberBill->fetch(PDO::FETCH_ASSOC);
            return (int)$numberBill['number_bill_new'] + 1;

        } else {
            return 1;
        }
    }

    function uuid_getNumberBillReview($digits)
    {

        $randomString = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        return $randomString;
    }


    function thisCatg($catg = null)
    {
        if ($this->userid) {

            if (in_array($this->userid, $this->idAdmin)) {
                return true;
            } else {
                if ($catg) {
                    $stmt = $this->db->prepare("SELECT catg  FROM  `user_purchases_catg` WHERE  `id_user`  = ? ");
                    $stmt->execute(array($this->userid));
                    $category = array();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $category[] = $row['catg'];
                    }
                    if (!empty($category)) {
                        if (in_array($catg, $category)) {
                            return true;
                        }
                    } else {
                        return false;
                    }

                } else {
                    return false;
                }
            }


        } else if (isset($_SESSION['username_member_r'])) {
            return true;
        } else {
            return false;
        }
    }


    function check_other_code_in_cart_shop($id)
    {
        $stmt = $this->db->prepare("SELECT `catg`  FROM  `user_purchases_catg` WHERE  `id_user`  = ? ");
        $stmt->execute(array($id));
        $category = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $category[] = "'" . $row['catg'] . "'";
        }

        return implode(',', $category);
    }


    function controlUser($id)
    {


        if (in_array($id, $this->idAdmin)) {
            return true;
        } else {
            $stmt = $this->db->prepare("SELECT *FROM  `user` WHERE  `id`  = ?  ");
            $stmt->execute(array($id));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt_groups = $this->db->prepare("SELECT *FROM `usergroup` WHERE `id`=? AND  `active`=1 ");
            $stmt_groups->execute(array($result['idGroup']));
            if ($stmt_groups->rowCount() > 0) {
                return true;
            } else {

                die('Authentication failed  !!');

            }
        }

    }


    function UserInfo($id, $c = null, $col = 'username')
    {


        if ($id) {

            $stmt = $this->db->prepare("SELECT * from `user` WHERE `id`=?   ");
            $stmt->execute(array($id));
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $data[$col];
            } else {
                if ($c) {
                    return '-';
                } else {
                    return 'system';

                }
            }
        } else {
            return '';
        }



    }


    function UserInfoBill($id)
    {
        if ($this->handleLogin()) {
            $stmt = $this->db->prepare("SELECT * from `user` WHERE `id`=?   ");
            $stmt->execute(array($id));
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $data['username'];
            } else {
                return 'زبون';
            }
        }
    }

    function sizeBox($id)
    {
        if ($this->handleLogin()) {
            $stmt = $this->db->prepare("SELECT * from `user` WHERE `id`=?   ");
            $stmt->execute(array($id));
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $data['money_box'];
            } else {
                return 0;
            }
        }
    }

    function UserNameInfo($username)
    {
        if ($this->handleLogin()) {
            $stmt = $this->db->prepare("SELECT * from `user` WHERE `username`=?   ");
            $stmt->execute(array($username));
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $data['id'];
            }
        }
    }

    function customerInfo($id, $col = 'name')
    {
        if ($this->handleLogin()) {
            $stmt = $this->db->prepare("SELECT  * from `register_user` WHERE `id`=?   ");
            $stmt->execute(array($id));
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $data[$col];
            }
        }
    }


//	في حال حذفت فاتورة
    function clearBill($number_bill, $count)
    {
        if ($count == 1) {
            $stmt1 = $this->db->prepare("DELETE FROM `bill` WHERE number_bill =? ");
            $stmt1->execute(array($number_bill));


            $stmt2 = $this->db->prepare("DELETE FROM `log_accountant_bill` WHERE number_bill =? ");
            $stmt2->execute(array($number_bill));


            $stmt3 = $this->db->prepare("DELETE FROM `cart_shop_active` WHERE number_bill =? ");
            $stmt3->execute(array($number_bill));

        }


    }


    function generateToken($h)
    {

        $alphabet = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $h; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }


    function CSRFToken($token)
    {
        return "<input type='hidden' name='csrf' value='{$token}'>";
    }

    function CSRFTchecked($csrf)
    {
        if ($csrf === $_SESSION['CSRFToken']) {
            return true;
        } else {
            $this->lightRedirect($this->stopUrl);
        }

    }


    function set_money_clipper()
    {


        $fromdate = strtotime(date('Y-m-d', time()));
        $todate = strtotime('+1 day', $fromdate);

        $stmtActive = $this->db->prepare("SELECT id FROM money_clipper WHERE `flag`=0 AND active=1  order by id DESC  limit 1");
        $stmtActive->execute();
        $result = $stmtActive->fetch(PDO::FETCH_ASSOC);

        $convertMoney = $this->allMoney_clipper($result['id']);


        $id_money_clipper = 0;
        $stmt = $this->db->prepare("SELECT *FROM money_clipper WHERE flag=0 AND `date` BETWEEN  ? AND  ? ");
        $stmt->execute(array($fromdate, $todate));
        if ($stmt->rowCount() == 0) {
            $stmte = $this->db->prepare("INSERT INTO money_clipper (money, userid, date,active,date_active) VALUES (?,?,?,?,?)  ");
            $stmte->execute(array($convertMoney, 0, strtotime(date('Y-m-d h:i A', time())), 1, time()));
            if ($stmte->rowCount() > 0) {
                $id_money_clipper = $this->db->lastInsertId();

                $stmtUnaitive = $this->db->prepare("UPDATE  money_clipper SET `active`=0,date_active=? WHERE id <> ? AND `date`  <  ? ");
                $stmtUnaitive->execute(array(time(), $id_money_clipper, $fromdate));

            }

        } else {

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_money_clipper = $result['id'];
        }


        $stmt_groups = $this->db->prepare("SELECT *FROM `usergroup` WHERE    (`name` LIKE '%محاسب%' OR `name` LIKE '%محاسبين%' OR `name` LIKE '%المحاسبين%')  ");
        $stmt_groups->execute();
        if ($stmt_groups->rowCount() > 0) {
            $result_g = $stmt_groups->fetch(PDO::FETCH_ASSOC);
            $stmtg = $this->db->prepare("SELECT *FROM  `user` WHERE  `idGroup`  = ? ");
            $stmtg->execute(array($result_g['id']));
            while ($row = $stmtg->fetch(PDO::FETCH_ASSOC)) {

                $stmt1 = $this->db->prepare("SELECT *FROM money_clipper_main_user WHERE  id_user=? AND   `flag`= 0   AND `date` BETWEEN  ? AND  ? ");
                $stmt1->execute(array($row['id'], $fromdate, $todate));
                if ($stmt1->rowCount() == 0) {
                    $stmte1 = $this->db->prepare("INSERT INTO money_clipper_main_user (id_money_clipper, money, flag, id_user, userid, date) VALUES (?,?,?,?,?,?)  ");
                    $stmte1->execute(array($id_money_clipper, 0, 0, $row['id'], 0, time()));
                }

                $stmt2 = $this->db->prepare("SELECT *FROM money_clipper_main_user WHERE  id_user=? AND   `flag`= 1   AND `date` BETWEEN  ? AND  ? ");
                $stmt2->execute(array($row['id'], $fromdate, $todate));
                if ($stmt2->rowCount() == 0) {
                    $stmte2 = $this->db->prepare("INSERT INTO money_clipper_main_user (id_money_clipper, money, flag, id_user, userid, date) VALUES (?,?,?,?,?,?)  ");
                    $stmte2->execute(array($id_money_clipper, 0, 1, $row['id'], 0, time()));
                }

            }
        }


        $stmt_groups_secondary = $this->db->prepare("SELECT *FROM `usergroup` WHERE   (`name` LIKE '%مباشر%' OR `name` LIKE '%مباشرين%' OR `name` LIKE '%ثانويين%') ");
        $stmt_groups_secondary->execute();
        if ($stmt_groups_secondary->rowCount() > 0) {

            while ($result_g_secondary = $stmt_groups_secondary->fetch(PDO::FETCH_ASSOC)) {

                $stmtg_secondary = $this->db->prepare("SELECT *FROM  `user` WHERE  `idGroup`  = ? AND `direct` =3 ");
                $stmtg_secondary->execute(array($result_g_secondary['id']));
                while ($row_secondary = $stmtg_secondary->fetch(PDO::FETCH_ASSOC)) {


                    $stmt1_secondary = $this->db->prepare("SELECT *FROM money_clipper_secondary_user WHERE  id_user=? AND   `flag`= 0   AND `date` BETWEEN  ? AND  ? ");
                    $stmt1_secondary->execute(array($row_secondary['id'], $fromdate, $todate));
                    if ($stmt1_secondary->rowCount() == 0) {

                        $stmte1_secondary = $this->db->prepare("INSERT INTO money_clipper_secondary_user (id_money_clipper, money, flag, id_user, userid, date) VALUES (?,?,?,?,?,?)  ");
                        $stmte1_secondary->execute(array($id_money_clipper, 0, 0, $row_secondary['id'], 0, time()));
                    }

                    $stmt2_secondary = $this->db->prepare("SELECT *FROM money_clipper_secondary_user WHERE  id_user=? AND   `flag`= 1   AND `date` BETWEEN  ? AND  ? ");
                    $stmt2_secondary->execute(array($row_secondary['id'], $fromdate, $todate));
                    if ($stmt2_secondary->rowCount() == 0) {
                        $stmte2_secondary = $this->db->prepare("INSERT INTO money_clipper_secondary_user (id_money_clipper, money, flag, id_user, userid, date) VALUES (?,?,?,?,?,?)  ");
                        $stmte2_secondary->execute(array($id_money_clipper, 0, 1, $row_secondary['id'], 0, time()));
                    }

                }


            }

        }
        return $id_money_clipper;
    }


    function allMoney_clipper($id)
    {

        $stmtd0 = $this->db->prepare("SELECT SUM(money) as money FROM money_clipper WHERE `flag`=0 AND active=1 AND `id`=?");
        $stmtd0->execute(array($id));
        $money_clipperd0 = $stmtd0->fetch(PDO::FETCH_ASSOC);


        $stmtd1 = $this->db->prepare("SELECT SUM(money) as money FROM money_clipper_withdraw WHERE `id_money_clipper`=?");
        $stmtd1->execute(array($id));
        $money_clipperd1 = $stmtd1->fetch(PDO::FETCH_ASSOC);

        return $sum = (((int)$money_clipperd0['money'] - (int)$this->allMoney_clipper_get0($id, 0)) + (int)$this->allMoney_clipper_get1($id, 1)) - (int)$money_clipperd1['money'];

    }

    /*
     * add to user account
     */
    function allMoney_clipper_get0($id, $flag = 0)
    {

        $stmtm = $this->db->prepare("SELECT SUM(money) as money FROM money_clipper_main_user WHERE   id_money_clipper=? AND `flag`= ?  ");
        $stmtm->execute(array($id, $flag));
        $money_clipperm_main = $stmtm->fetch(PDO::FETCH_ASSOC);

        $stmts = $this->db->prepare("SELECT SUM(money) as money FROM money_clipper_secondary_user WHERE  id_money_clipper=? AND  `flag`= ?  ");
        $stmts->execute(array($id, $flag));
        $money_clippers_secondary = $stmts->fetch(PDO::FETCH_ASSOC);

        return $sum = $money_clipperm_main['money'] + $money_clippers_secondary['money'];
    }


    /*
     * get to user account
     */
    function allMoney_clipper_get1($id, $flag = 1)
    {

        $stmtm = $this->db->prepare("SELECT SUM(money) as money FROM money_clipper_main_user WHERE id_money_clipper=? AND `flag`= ?  ");
        $stmtm->execute(array($id, $flag));
        $money_clipperm_main = $stmtm->fetch(PDO::FETCH_ASSOC);

        $stmts = $this->db->prepare("SELECT SUM(money) as money FROM money_clipper_secondary_user WHERE id_money_clipper=? AND `flag`= ?  ");
        $stmts->execute(array($id, $flag));
        $money_clippers_secondary = $stmts->fetch(PDO::FETCH_ASSOC);

        return $sum = $money_clipperm_main['money'] + $money_clippers_secondary['money'];
    }


    // $check اذا كان صغر  فراح يشتغل عادي
    //  واذا واحد ف مراح يجيب مواقع مستودع البلدية
    function get_location($model, $code, $color = null, $check=0)
    {

        if ($this->handleLogin()) {


            if ($model == 'product_savers') {
                $model = 'savers';
            }
            $add_condition = '';
            if ($check != 0) {
                $add_condition = ' AND `sequence` not between 701 AND 800  ' ;
            }
            // تلزيكة علمود ما نضهر مواقع حي البلدية
            $stmtLocation = $this->db->prepare("SELECT id,location,quantity FROM `location` WHERE code=?  AND model=? AND quantity > 0 $add_condition ");
            $stmtLocation->execute(array($code, $model));
            $outLocation = array();

            while ($row = $stmtLocation->fetch(PDO::FETCH_ASSOC)) {

                $row['location']=$this->tamayaz_locations($row['location']);

                $outLocation[] = $row;

            }

            return $outLocation;

        }

    }


    function edit_bill($number_bill, $user)
    {
        $stmt = $this->db->prepare("SELECT *FROM `cart_shop_active` WHERE number_bill=?  UNION SELECT *FROM `cart_shop` WHERE number_bill=? ");
        $stmt->execute(array($number_bill, $number_bill));
        if ($stmt->rowCount() > 0) {
            $stmt_up = $this->db->prepare("UPDATE  `crystal_bill` SET  checked=0 , edit=1, user_edit=?,`note`=?  WHERE  number_bill =?  AND `delete`=0");
            $stmt_up->execute(array($user, 'تم تعديل الفاتورة', $number_bill));
        } else {
            $stmtc = $this->db->prepare("SELECT *FROM `crystal_bill` WHERE number_bill=?   ");
            $stmtc->execute(array($number_bill));
            if ($stmtc->rowCount() > 0) {
                $stmt_up = $this->db->prepare("UPDATE  `crystal_bill` SET  checked=0 , edit=1, user_edit=?,`note`=? ,`delete`=1  WHERE  number_bill =?  AND `delete`=0  ");
                $stmt_up->execute(array($user, 'تم تعديل الفاتورة', $number_bill));
            } else {
                $stmt_d = $this->db->prepare("UPDATE  `retrieve_item` SET  `delete`=1 , delete_user=?, delete_date=?   WHERE  `number_bill` =?   ");
                $stmt_d->execute(array($user, time(), $number_bill));
            }

        }


    }


//	check quantity in cart
    function q_0($table, $code, $color = null)
    {

        $excel = null;
        if ($table == 'mobile') {
            $excel = 'excel';

        } else if ($table == 'product_savers') {
            $excel = 'excel_savers';
        } else {
            $excel = 'excel_' . $table;
        }

        if ($table == 'accessories') {

            $stmt = $this->db->prepare("SELECT *FROM excel_accessories WHERE code=? AND  color = ? AND quantity  <= 0 ");
            $stmt->execute(array($code, $color));
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            $stmt = $this->db->prepare("SELECT *FROM {$excel} WHERE code=? AND  quantity <= 0 ");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }


    }

    function checkEditPrice($id)
    {
        if ($this->handleLogin()) {
            $stmt = $this->db->prepare("SELECT * from `user` WHERE `id`=?  AND `edit_price`=1 ");
            $stmt->execute(array($id));
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }


    function onlinedb()
    {

        $servername = "94.23.204.112";
        $username = "alamani_system";
        $dbname = "alamani_system";
        $password = "system2052032";

        try {
            $conn = new PDO("mysql:host=$servername;dbname={$dbname}", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;

        } catch (PDOException $e) {

        }


    }


    function main_account($id)
    {
        $stmt = $this->db->prepare("SELECT idGroup from `user` WHERE `id`=?   ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt_groups = $this->db->prepare("SELECT *FROM `usergroup` WHERE  (`name` LIKE '%محاسب%' OR `name` LIKE '%محاسبين الرئيسيين%') AND id= ?");
            $stmt_groups->execute(array($data['idGroup']));
            if ($stmt_groups->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    function prepared_account($id)
    {
        $stmt = $this->db->prepare("SELECT idGroup from `user` WHERE `id`=?   ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt_groups = $this->db->prepare("SELECT *FROM `usergroup` WHERE  (`name` LIKE '%التجهيز%' OR `name` LIKE '%موضفين التجهيز%') AND id= ?");
            $stmt_groups->execute(array($data['idGroup']));
            if ($stmt_groups->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }


    function sum_account_main($id)
    {

        $stmt = $this->db->prepare("SELECT * from `total_accountants` WHERE `id_account`=?   ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $plus = (int)$data['bill_sale'] + (int)$data['secondary_accountants'] + (int)$data['amount_from_clipping'];
            $minus = (int)$data['minus_customer'] + (int)$data['review_to_customer'] + (int)$data['amount_to_clipping'] + (int)$data['bill_purchase'];
            return $plus - $minus;

        } else {
            return 0;
        }

    }

    public function getPriceSearch($price_dollars, $price_dollars_excel)
    {

        if ($this->loginUser()) {

            return $price = $this->price_dollarsAdmin($price_dollars_excel);

        } else {
            if ($price_dollars == 1) {
                return $price = $this->price_dollars($price_dollars_excel);
            } else {
                return $price = $price_dollars_excel;
            }
        }

    }


    function is_float_system($num, $rate = 3)
    {


        if (is_float($num)) {

            $p = explode('.', $num);
            if (count($p) > 1) {
                $num = $p[0] . '.' . substr($p[1], 0, $rate);
            } else {
                $num = $p[0];
            }


        }

        return $num;


    }

    function priceDollarOffer($id, $num)
    {

        $allPD = 0;
        $price = array();
        $outPrice = 0;
        $rate = 1;
        $info = array(1 => 'سعر جميع المواد قبل التخفيض $', 2 => 'سعر جميع المواد قبل التخفيض D', 3 => 'سعر جميع المواد بعد التخفيض $', 4 => 'سعر جميع المواد بعد التخفيض D', 5 => 'رينج', 6 => 'نسبة التخفيض من السعر الحقيقي');

        $stmt = $this->db->prepare("SELECT *FROM  offers WHERE id=? AND ((`total_price` = '' AND `rate` <> '') OR (`total_price`  <>  '' AND `rate` = '')  )");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($result['total_price'])) {

                $stmtItem = $this->db->prepare("SELECT code,model FROM  offers_item WHERE id_offer=?    GROUP BY id_offer,id_item,model");
                $stmtItem->execute(array($result['id']));
                if ($stmtItem->rowCount() > 0) {

                    while ($rowItem = $stmtItem->fetch(PDO::FETCH_ASSOC)) {
                        if ($rowItem['model'] == 'mobile') {
                            $excel = 'excel';
                        } else {
                            $excel = 'excel_' . $rowItem['model'];
                        }

                        $stmtexcel = $this->db->prepare("SELECT price_dollars FROM {$excel} WHERE `code`=?    LIMIT 1");
                        $stmtexcel->execute(array(trim($rowItem['code'])));
                        if ($stmtexcel->rowCount() > 0) {
                            $price_dollars = trim($stmtexcel->fetch(PDO::FETCH_ASSOC)['price_dollars']);
                            $price[] = $price_dollars;
                            $allPD = $allPD + $price_dollars;
                        }

                    }

                    $info[1] = $this->is_float_system($allPD);
                    $info[2] = $this->price_dollarsAdmin($info[1]);

                    if ($result['total_price'] != $allPD) {
                        $rate = $result['total_price'] / $allPD;
                        $rate = $this->is_float_system($rate, 4);
                    }

                    $info[6] = $rate;

                    foreach ($price as $p) {
                        $priceRate = $p * $rate;
                        $outPrice = $outPrice + $priceRate;
                    }

                    $info[3] = $this->is_float_system($outPrice);

                    $info[4] = $this->price_dollarsAdmin($info[3]);
                    $info[5] = $this->price_dollars($info[3]);

                    return $info[$num];

                }


            } else if (!empty($result['rate'])) {
                $stmtItem = $this->db->prepare("SELECT code,model FROM  offers_item WHERE id_offer=?     GROUP BY id_offer,id_item,model ");
                $stmtItem->execute(array($result['id']));
                if ($stmtItem->rowCount() > 0) {

                    while ($rowItem = $stmtItem->fetch(PDO::FETCH_ASSOC)) {
                        if ($rowItem['model'] == 'mobile') {
                            $excel = 'excel';
                        } else {
                            $excel = 'excel_' . $rowItem['model'];
                        }

                        $stmtexcel = $this->db->prepare("SELECT price_dollars FROM {$excel} WHERE `code`=? LIMIT 1");
                        $stmtexcel->execute(array(trim($rowItem['code'])));
                        if ($stmtexcel->rowCount() > 0) {
                            $price_dollars = trim($stmtexcel->fetch(PDO::FETCH_ASSOC)['price_dollars']);

                            $price[] = $price_dollars;
                            $allPD = $allPD + $price_dollars;
                        }

                    }
                    $info[1] = $this->is_float_system($allPD);
                    $info[2] = $this->price_dollarsAdmin($info[1]);


                    $rate = trim($result['rate']);
                    $info[6] = $rate;
                    foreach ($price as $p) {
                        $priceRate = $p * $rate;
                        $outPrice = $outPrice + $priceRate;
                    }

                    $info[3] = $this->is_float_system($outPrice);
                    $info[4] = $this->price_dollarsAdmin($info[3]);
                    $info[5] = $this->price_dollars($info[3]);

                    return $info[$num];

                }


            } else {
                return 0;
            }


        } else return 0;


    }


    function check_offer($id, $active, $note = '')
    {

        $stmtItem = $this->db->prepare("SELECT code,model FROM  offers_item WHERE id_offer=?   ");
        $stmtItem->execute(array($id));
        if ($stmtItem->rowCount() > 0) {

            while ($rowItem = $stmtItem->fetch(PDO::FETCH_ASSOC)) {
                if ($rowItem['model'] == 'mobile') {
                    $excel = 'excel';
                } else {
                    $excel = 'excel_' . $rowItem['model'];
                }

                $stmtexcel = $this->db->prepare("SELECT quantity FROM {$excel} WHERE `code`=?  AND `quantity`  <= 0  LIMIT 1");
                $stmtexcel->execute(array(trim($rowItem['code'])));
                if ($stmtexcel->rowCount() > 0) {

                    $stmt = $this->db->prepare("UPDATE    offers SET active=? , note =?    WHERE id = ?  ");
                    $stmt->execute(array($active, $note, $id));

                    return false;
                }
            }
            return true;
        }


    }


    function details_offer($id, $col)
    {
        $stmt = $this->db->prepare("SELECT *FROM  offers WHERE id=?   ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result[$col];
        }else
        {
            return '-';
        }

    }

    function check_all_itemoffers()
    {
        $date = time();
        $stmt = $this->db->prepare("SELECT *FROM `offers` WHERE  `active`=1 AND todate > {$date} ");
        $stmt->execute();
        while ($rowOffer = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stmtItem = $this->db->prepare("SELECT *FROM `offers_item` WHERE  `id_offer` = ?     GROUP BY id_item,model ");
            $stmtItem->execute(array($rowOffer['id']));
            while ($row = $stmtItem->fetch(PDO::FETCH_ASSOC)) {

                if ($row['model'] == 'mobile') {
                    $excel = 'excel';
                } else {
                    $excel = 'excel_' . $row['model'];
                }

                $q = 0;

                $row['details' . $row['id']] = array();
                $stmtItemDetails = $this->db->prepare("SELECT {$excel}.quantity FROM `offers_item` INNER  JOIN {$excel} ON  {$excel}.code=offers_item.code WHERE  offers_item.`id_offer` = ? AND offers_item.id_item=? AND offers_item.`model`=?   AND {$excel}.quantity > 0 ");
                $stmtItemDetails->execute(array($rowOffer['id'], $row['id_item'], $row['model']));
                while ($details = $stmtItemDetails->fetch(PDO::FETCH_ASSOC)) {
                    $q = $q + $details['quantity'];
                }

                if ($q == 0) {
                    $stmtUPd = $this->db->prepare("UPDATE    offers SET active=? , note =?    WHERE id = ?  ");
                    $stmtUPd->execute(array(2, 'نفذت بعض مواد العرض', $rowOffer['id']));
                }

            }
        }


    }

    function onItemOffOffer()
    {

        $stmt = $this->db->prepare("SELECT offers_item.model,offers_item.id_item   FROM `offers` INNER  JOIN  offers_item ON offers_item.id_offer = offers.id WHERE   offers.`active`  > 1  OR  offers.`delete` = 1       GROUP BY offers_item.id_item,offers_item.model ");
        $stmt->execute();
        while ($rowOffer = $stmt->fetch(PDO::FETCH_ASSOC)) {


            if ($rowOffer['model']=='savers')
            {
                $table= 'product_savers';
            }else{
                $table= $rowOffer['model'];
            }

            $stmtUPd = $this->db->prepare("UPDATE    {$table} SET active=?   WHERE id = ?  ");
            $stmtUPd->execute(array(1,$rowOffer['id_item']));
        }
    }


    function check_one_itemoffers($id)
    {

        $q = 0;
        $stmtItem = $this->db->prepare("SELECT *FROM `offers_item` WHERE  `id_offer` = ?    GROUP BY id_item,model ");
        $stmtItem->execute(array($id));
        while ($row = $stmtItem->fetch(PDO::FETCH_ASSOC)) {

            if ($row['model'] == 'mobile') {
                $excel = 'excel';
            } else {
                $excel = 'excel_' . $row['model'];
            }


            $row['details' . $row['id']] = array();
            $stmtItemDetails = $this->db->prepare("SELECT {$excel}.quantity FROM `offers_item` INNER  JOIN {$excel} ON  {$excel}.code=offers_item.code WHERE  offers_item.`id_offer` = ? AND offers_item.id_item=? AND offers_item.`model`=?   AND {$excel}.quantity > 0 ");
            $stmtItemDetails->execute(array($id, $row['id_item'], $row['model']));
            while ($details = $stmtItemDetails->fetch(PDO::FETCH_ASSOC)) {
                $q = $q + $details['quantity'];
            }

            if ($q == 0) {
                $stmtUPd = $this->db->prepare("UPDATE    offers SET active=? , note =?    WHERE id = ?  ");
                $stmtUPd->execute(array(2, 'نفذت بعض مواد العرض', $id));
                return false;
            }

        }
        return true;


    }


    function ch_wcprice()
    {
        if ($this->loginUser()) {
            if ($this->admin($this->userid)) {
                return true;
            }
            if ($this->UserInfo($this->userid, null, 'price_type')) {
                return true;
            } else {
                return false;
            }
        } else if (isset($_SESSION['id_member_r'])) {
            if ($this->customerInfoPublic($_SESSION['id_member_r'],  'price_type')) {
                return true;
            } else {
                return false;
            }
        }else
        {
            return false;
        }
    }

    function wcprice($type = null)
    {
        if ($this->loginUser()) {

            if ($this->admin($this->userid)) {
                return true;
            } else {

                if ($type) {
                    if (in_array($type, explode(',', $this->UserInfo($this->userid, null, 'price_type')))) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        } else if (isset($_SESSION['id_member_r'])) {
            if ($type) {
                if (in_array($type, explode(',', $this->customerInfoPublic($_SESSION['id_member_r'], 'price_type')))) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    function  customerInfoPublic($id, $col = 'name')
    {

        $stmt = $this->db->prepare("SELECT  * from `register_user` WHERE `id`=?   ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data[$col];
        }

    }

    function  hide_location()
    {

        $stmt = $this->db->prepare("SELECT  * from `hide_location`  ");
        $stmt->execute();
        $location=array();
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $location[]=$row['location'];
        }

        return $location;
    }


    function runInDBTransaction($stmt)
    {

        $this->db->beginTransaction();
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $stmt_run=$stmt();
            $this->db->commit();
            return $stmt_run;
        } catch (Exception $e) {
            if ($this->db->inTransaction())
                $this->db->rollBack();

        }

    }


    function store_location($location,$model,$code)
    {


        if ($model =='product_savers')
        {
            $model='savers';
        }



        if ($location) {

            $loc = explode(',', $location);

            $list_loct = array();
            foreach ($loc as $location) {

                if ($location) {

                    $stmt = $this->db->prepare('SELECT  *FROM location WHERE location=? AND model=? AND code = ? LIMIT 1');
                    $stmt->execute(array(trim($location), trim($model), $code));
                    if ($stmt->rowCount() > 0) {
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                        $stmt_sequence = $this->db->prepare("SELECT title FROM group_location WHERE  {$result['sequence']} between `from` AND  `to`     LIMIT 1");
                        $stmt_sequence->execute();
                        if ($stmt_sequence->rowCount() > 0) {
                            $group = $stmt_sequence->fetch(PDO::FETCH_ASSOC);
                            $list_loct[] = $group['title'];
                        } else {
                            $list_loct[] = 'لم يتم تحديد مجموعة للمستودعات';

                        }
                    } else {
                        $list_loct[] = "الموقع  " . $location . "  غير موجود من ضمن مواقع الباركود ";
                    }

                }

            }

            return implode(',', $list_loct);
        }

    }




    function active_customer($id,$screen=0)
    {


        $date=time();
        $stmt=$this->db->prepare("SELECT * FROM register_session_customer WHERE id_customer=?");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            $stmtUpdate=$this->db->prepare("UPDATE  register_session_customer SET  `date`=?,screen=?,active=1,count_login=count_login+1,date_active_now=?  WHERE id_customer=?");
            $stmtUpdate->execute(array($date,$screen,$date - 1,$id));

        }else
        {
            $stmtInsert=$this->db->prepare("INSERT INTO register_session_customer ( id_customer, screen,  active, `date`, first_date,date_active_now) values (?,?,?,?,?,?) ");
            $stmtInsert->execute(array($id,$screen,1,$date,$date,$date - 1));
        }

    }

    function ch_smart_prepared($id)
    {
        $stmt=$this->db->prepare("SELECT  id FROM `user` WHERE `id`=? AND `smart_prepared`=1");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            return true;
        }else
        {
            return false;
        }
    }

	//  هذا الدالة لمتابعة الكميات عن طريق اسم الدالة
    public function AddToTraceByFunction($idUser,$model,$nameFunction)
    {
        $date=time();
        $stmt = $this->db->prepare("INSERT INTO `tracebyfunction`(`id_user`, `model`,`name_function`,`date`) VALUE (?,?,?,?)");
        $stmt->execute(array($idUser,$model,$nameFunction,$date));
    }



	/*
    *هذه الدالة تتحقق اذا كانت الفئة لواصق
    *create by NAI
    * 2022/07/04
    */
    public function check_id_catge($id){

        $stmt_catg_acc = $this->db->prepare("SELECT * FROM `category_accessories` WHERE id = ? LIMIT 1");
        $stmt_catg_acc->execute(array($id));


        if ($stmt_catg_acc->rowCount() > 0){
            $row_catg_acc = $stmt_catg_acc->fetch(PDO::FETCH_ASSOC);
            if($row_catg_acc['title'] == 'اللواصق'){
                $this->check_name_category = 1;
            }elseif(($row_catg_acc['title'] != 'اللواصق')&& ($row_catg_acc['relid'] == 0)){
                $this->check_name_category = 0;
            }else{
                $this->check_id_catge($row_catg_acc['relid']);
            }
        }
        return  $this->check_name_category;
    }
    ///////////////////////////////////////////////////
    //////////////////////////////////////////
    ////////////
    // اضافة المزامنة
    // حاليا المزامنة للكمياات فقط ولكن الدوال مجهزة لمزامنة اي جدول اخر
    /**
     * arther h27
     *  @param int $method the requst method(POST,PUT,GET)
     *  @param string $data the data of request (in json format)
     *  @param string $apiUrl the full api url
     */
    public function Add_to_sync_schedule($id_rec,$table_name,$function='quantity_adjustment',$code = ' ',$commint = ' no commint')
    {
        if ($table_name == 'product_savers') {
            $table_name='savers';
        }
        $stmt = $this->db->prepare("INSERT INTO `sync_schedule`(`id_rec`, `table_name`, `function` ,`code`) VALUES (?,?,?,?)");
        $stmt->execute(array($id_rec,$table_name,$function,$code));
    	$this->add_to_sync_log($this->db->lastInsertId(),$id_rec,$table_name,$function,'Add_to_sync_schedule commint : -'.$commint);

        // $this->synchronization();
    }
    // 	 بسبب اللود راح نخلي فكشنات ثنين للمزامنة حتى ما يصير تاخير بالمطابقة
    /**
     * arther h27
     *
     * هاي الدالة فقط لمزامنة الكميات والاسعار
     *  @param int $id_row id of table
     *  @param string $table_name
     *  @param string $function name of function
     */
    public function synchronization()
    {
//         if($this->testConnection()==200){

//             $stmt=$this->db->prepare("SELECT `id`,`id_rec`, `table_name`, `function` FROM `sync_schedule` where ( function ='quantity_adjustment' OR function ='offer_categories' OR function ='delete_offer_categories' OR function ='add_offers' OR function ='add_offers_item' OR function ='delete_offers_item') and code not like '%error%' ORDER BY `sync_schedule`.`id` DESC limit 100  ");
//             $stmt->execute();
//             // $result= $stmt->fetchAll(PDO::FETCH_ASSOC);
//             //print_r($result);

//             if ($stmt-> rowCount() > 0 )
//             {
//                 while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
//                 {
//                     switch ($row['function']) {
//                         case 'quantity_adjustment':

//                             $this->quantity_adjustment_send($row['id'],$row['id_rec'],$row['table_name']);
//                             break;
//                         case 'add_category':
//                             $this->add_category_send($row['id'],$row['id_rec'],$row['table_name']);
//                             break;
//                         case 'add_item':
//                             $this->add_item_send($row['id'],$row['id_rec'],$row['table_name']);
//                             break;
//                         case 'add_category_savers':
//                             $this->add_category_savers_send($row['id'],$row['id_rec']);
//                             break;
//                         case 'add_name_device':
//                             $this->add_name_device_send($row['id'],$row['id_rec']);
//                             break;
//                         case 'add_type_device':
//                             $this->add_type_device_send($row['id'],$row['id_rec']);
//                             break;
//                         case 'add_savers':
//                             $this->add_savers_send($row['id'],$row['id_rec']);
//                             break;
//                         case 'add_accessories':
//                             $this->add_accessories_send($row['id'],$row['id_rec']);
//                             break;
//                         case 'add_mobile':
//                             $this->add_mobile_send($row['id'],$row['id_rec']);
//                             break;

//                         case 'offer_categories':
//                             $this->add_offer_categories_send($row['id'],$row['id_rec'],$row['table_name']);
//                             break;
//                         case 'delete_offer_categories':
//                             $this->delete_offer_categories_send($row['id'],$row['id_rec'],$row['table_name']);
//                             break;
//                         case 'add_offers':
//                             $this->add_offers_send($row['id'],$row['id_rec'],$row['table_name']);
//                             break;
//                         case 'add_offers_item':
//                             $this->add_offers_item_send($row['id'],$row['id_rec'],$row['table_name']);
//                             break;
//                         case 'delete_offers_item':
//                             $this->delete_offers_item_send($row['id'],$row['id_rec'],$row['table_name']);
//                             break;
//                     	case 'add_class_games':
//                             $this->add_class_games_send($row['id'],$row['id_rec']);
//                             break;
//                         case 'add_games':
//                             $this->add_games_send($row['id'],$row['id_rec']);
//                             break;

//                     }

//                 }
//             }

//         }

    }
    /* arther h27
    *
    * هاي الدالة لمزامنة بطاقات المادة كافة
    *  @param int $id_row id of table
    *  @param string $table_name
    *  @param string $function name of function
    */
    public function synchronization_line_2()
    {
//         if($this->testConnection()==200){

//             $stmt=$this->db->prepare("SELECT `id`,`id_rec`, `table_name`, `function` FROM `sync_schedule` where (function ='add_mobile' or function ='add_accessories' or function ='add_item' or function ='add_savers' or function ='add_type_device' or function ='add_name_device' or function ='add_category_savers' or function ='add_category' or function ='add_games') and code not like '%error%' ORDER BY `sync_schedule`.`id` DESC limit 5 ");
//             $stmt->execute();
//             // $result= $stmt->fetchAll(PDO::FETCH_ASSOC);
//             //print_r($result);

//             if ($stmt-> rowCount() > 0 )
//             {
//                 while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
//                 {
//                     // echo "<br> id ".$row['id'];
//                     // echo "<br> id_rec ".$row['id_rec'];
//                     // echo "<br> table_name ".$row['table_name'];
//                     // echo "<br> function ".$row['function'];
//                     switch ($row['function']) {
//                         case 'quantity_adjustment':

//                             $this->quantity_adjustment_send($row['id'],$row['id_rec'],$row['table_name']);
//                             break;
//                         case 'add_category':
//                             $this->add_category_send($row['id'],$row['id_rec'],$row['table_name']);
//                             break;
//                         case 'add_item':
//                             $this->add_item_send($row['id'],$row['id_rec'],$row['table_name']);
//                             break;
//                         case 'add_category_savers':
//                             $this->add_category_savers_send($row['id'],$row['id_rec']);
//                             break;
//                         case 'add_name_device':
//                             $this->add_name_device_send($row['id'],$row['id_rec']);
//                             break;
//                         case 'add_type_device':
//                             $this->add_type_device_send($row['id'],$row['id_rec']);
//                             break;
//                         case 'add_savers':
//                             $this->add_savers_send($row['id'],$row['id_rec']);
//                             break;
//                         case 'add_accessories':
//                             $this->add_accessories_send($row['id'],$row['id_rec']);
//                             break;
//                         case 'add_mobile':
//                             $this->add_mobile_send($row['id'],$row['id_rec']);
//                             break;
//                         case 'offer_categories':
//                             $this->add_offer_categories_send($row['id'],$row['id_rec'],$row['table_name']);
//                             break;
//                         case 'delete_offer_categories':
//                             $this->delete_offer_categories_send($row['id'],$row['id_rec'],$row['table_name']);
//                             break;
//                         case 'add_offers':
//                             $this->add_offers_send($row['id'],$row['id_rec'],$row['table_name']);
//                             break;
//                         case 'add_offers_item':
//                             $this->add_offers_item_send($row['id'],$row['id_rec'],$row['table_name']);
//                             break;
//                         case 'delete_offers_item':
//                             $this->delete_offers_item_send($row['id'],$row['id_rec'],$row['table_name']);
//                             break;
//                     	case 'add_class_games':
//                             $this->add_class_games_send($row['id'],$row['id_rec']);
//                             break;
//                         case 'add_games':
//                             $this->add_games_send($row['id'],$row['id_rec']);
//                             break;

//                     }

//                 }
//             }

//         }

    }
    // mmm
// هاي الدالة تجريبية نستدعيها بشكل فردي
    public function synchronization_item()
    {

        if($this->testConnection()==200){
            echo 'gg';
            $stmt=$this->db->prepare("SELECT   `id`,`id_rec`, `table_name`, `function`,`code` FROM `sync_schedule` where  id =555658 ");
            $stmt->execute();
            if ($stmt-> rowCount() > 0 )
            {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    // $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo "<br> id ".$row['id'];
                    echo "<br> id_rec ".$row['id_rec'];
                    echo "<br> table_name ".$row['table_name'];
                    echo "<br> function ".$row['function'];
                    switch ($row['function']) {
                        case 'quantity_adjustment':

                            $this->quantity_adjustment_send($row['id'],$row['id_rec'],$row['table_name']);
                            break;
                        case 'add_category':
                            $this->add_category_send($row['id'],$row['id_rec'],$row['table_name']);
                            break;
                        case 'add_item':
                            $this->add_item_send($row['id'],$row['id_rec'],$row['table_name']);
                            break;
                        case 'add_category_savers':
                            $this->add_category_savers_send($row['id'],$row['id_rec']);
                            break;
                        case 'add_name_device':
                            $this->add_name_device_send($row['id'],$row['id_rec']);
                            break;
                        case 'add_type_device':
                            $this->add_type_device_send($row['id'],$row['id_rec']);
                            break;
                        case 'add_savers':
                            $this->add_savers_send($row['id'],$row['id_rec']);
                            break;
                        case 'add_accessories':
                            $this->add_accessories_send($row['id'],$row['id_rec']);
                            break;
                        case 'add_mobile':
                            $this->add_mobile_send($row['id'],$row['id_rec']);
                            break;
                        case 'offer_categories':
                            $this->add_offer_categories_send($row['id'],$row['id_rec'],$row['table_name']);
                            break;
                        case 'delete_offer_categories':
                            $this->delete_offer_categories_send($row['id'],$row['id_rec'],$row['table_name']);
                            break;
                        case 'add_offers':
                            $this->add_offers_send($row['id'],$row['id_rec'],$row['table_name']);
                            break;
                    	case 'delete_offers':
                             $this->delete_offers_send($row['id'],$row['id_rec'],$row['table_name']);
                             break;
                        case 'add_offers_item':
                            $this->add_offers_item_send($row['id'],$row['id_rec'],$row['table_name']);
                            break;
                        case 'delete_offers_item':
                            $this->delete_offers_item_send($row['id'],$row['id_rec'],$row['table_name']);
                            break;
                    	case 'add_class_games':
                            $this->add_class_games_send($row['id'],$row['id_rec']);
                            break;
                        case 'add_games':
                            $this->add_games_send($row['id'],$row['id_rec']);
                            break;

                    	case 'delete_category':
                                $this->delete_cate_send($row['id'],$row['id_rec'],$row['table_name']);
                                break;
                    	case 'delete_item':
                    		    $this->delete_item_send($row['id'],$row['id_rec'],$row['table_name'],$row['code']);
                    		    break;
                    		case 'delete_color_code':
                    		$this->delete_color_code_send($row['id'],$row['id_rec'],$row['table_name'],$row['code']);
                    		break;
                    		case 'delete_code':
                    		$this->delete_code_send($row['id'],$row['id_rec'],$row['table_name'],$row['code']);
                    		break;

                    	// 	case 'delete_item_accessories':
                    	// 	      $this->delete_item_accessories_send($row['id'],$row['id_rec'],$row['table_name'],$row['code']);
                    	// 	      break;

                    	// 	case 'delete_savers':
                        //         $this->delete_savers_send($row['id'],$row['id_rec'],$row['table_name'],$row['code']);
                        //         break;

                    	// 	case 'delete_type_device':
                        //         $this->delete_type_device_send($row['id'],$row['id_rec'],$row['table_name']);
                        //         break;

                        //    case 'delete_name_device':
                        //         $this->delete_name_device_send($row['id'],$row['id_rec'],$row['table_name']);
                        //         break;
                    	// 	 case 'delete_category_savers':
                        //         $this->delete_category_savers_send($row['id'],$row['id_rec'],$row['table_name']);
                        //         break;



                    }
                }
            }else
            {
                echo "<br> no row ";
            }

        }
    }




    /**
     * h27
     * basic Call API
     */
    function CallAPI($method, $url, $data )
    {
        $curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("key:jehfttrr4r4r7565256"));

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
    /**
     *
     */
    function  testConnection($url='https://m/')
    {


        // // Use get_headers() function
        // $headers = @get_headers($url);

        // // Use condition to check the existence of URL
        // if($headers && strpos( $headers[0], '200')) {
            $status = 200;
        // }
        // else {
        //     $status = 404;
        // }

        // Display result
        return $status;

    }
    /**
     * h27
     * دالة حذف
     * @param string $table_name اسم الجدول
     * @param string $colomn_name نوع الحقل الخاص بالشرط
     * @param mix $value قيمة الحقل
     * @return int 0 if error 1 if success
     */
    function delete_rows($table_name,$colomn_name,$value){
        $statm = $this->db->prepare("DELETE FROM `{$table_name}` WHERE `{$colomn_name}`=? ");
        $statm->execute(array($value));
    }
    /**
     * h27
     */
    function add_to_sync_log($id,$id_row,$table_name,$function,$data_content){
        $statm = $this->db->prepare("INSERT INTO `sync_log`(`id_sync`, `id_row`, `table_name`, `function`, `data_content`) VALUES (?,?,?,?,?)");
        $statm->execute(array($id,$id_row,$table_name,$function,$data_content));
    }
    /**
     * تعديل حقل الكود فقط
     */
    function update_code_in_sync($code,$id)
    {
        $statm = $this->db->prepare("UPDATE `sync_schedule` SET `code`=? WHERE `id`=?");
        $statm->execute(array($code,$id));
    }

    ///// الدوال الخاصة بتنفيذ المزامنة بشكل فردي
    // كل دالة تؤدي غرض خاص

    /**
     * دالة ارسال الكميات
     * Send method
     */
        function quantity_adjustment_send($id,$id_row,$table_name)
    {
        $this->add_to_sync_log($id,$id_row,$table_name,'quantity_adjustment','strating');
        // echo "<br> start <br>";
        $excel_tb = 'excel';
        if($table_name!='mobile')
            $excel_tb=$excel_tb.'_'.$table_name;
        // echo "<br> ex_tb : ".$excel_tb;
        $stmt_excel=$this->db->prepare("SELECT `id`, `code`,`price_dollars`,`range1`,`range2`, `quantity` FROM {$excel_tb} WHERE `code`=?  ");
        $stmt_excel->execute(array($id_row));
        $row =$stmt_excel->fetch(PDO::FETCH_ASSOC);
        // get sum of quntity from locations
        // only for accessories and savers
        $sum_quntity=$row['quantity'];
        if($table_name=='accessories' || $table_name=='savers')
        {
            $stmt_loc=$this->db->prepare("SELECT SUM(`quantity`) as sum FROM `location` WHERE `code`=?  and model=? ");
            $stmt_loc->execute(array($id_row,$table_name));
            $row_loc =$stmt_loc->fetch(PDO::FETCH_ASSOC);
            $sum_quntity=$row_loc['sum'];
        }
        // echo "<br> row : ";
        // print_r($row);
        $test_add = $this->CallAPI('POST', "https://m/api/quantity_adjustment_receive",array(
            'code' => $row['code'],
            'quantity' => $sum_quntity,
            'price_dollars' => $row['price_dollars'],
            'range1' => $row['range1'],
            'range2' => $row['range2'],
            'excel'=>$excel_tb
        ));
        $this->add_to_sync_log($id,$id_row,$table_name,'quantity_adjustment','send to server : -- code : '.$row['code'].' -- quantity : '.$row['quantity'].' -- price_dollars : '.$row['price_dollars'].' -- range1 : '.$row['range1'].' -- range2 : '.$row['range2'].' -- excel : '.$excel_tb);
        // echo "<br> test_add : ".$test_add;
        $this->add_to_sync_log($id,$id_row,$table_name,'quantity_adjustment','get from server : '.$test_add);
        $test_add = intval($test_add);
        // echo "<br> intrval test_add : ".$test_add;
        if( $test_add>0)
        {
            $this->add_to_sync_log($id,$id_row,$table_name,'quantity_adjustment','seccess : '.$test_add);
            // $stmt=$this->db->prepare("DELETE FROM `sync_schedule` WHERE `id`=? ");
            // $stmt->execute(array($id));
            $this->delete_rows('sync_schedule','id',$id);
            return 1;
        }else
        {
            $this->add_to_sync_log($id,$id_row,$table_name,'quantity_adjustment','faild : '.$test_add);
            $stmt=$this->db->prepare("update  `sync_schedule` set code=? WHERE `id`=? ");
            if($row['code']=="")
            {
                $stmt->execute(array('error -'.$row['code'].' - '.$row['quantity'].' - '.$row['price_dollars'].' - '.$row['range1'].' - '.$row['range2'].' - '.$excel_tb,$id));
            }
            else
            {
                $stmt->execute(array($row['code'].' - '.$row['quantity'].' - '.$row['price_dollars'].' - '.$row['range1'].' - '.$row['range2'].' - '.$excel_tb,$id));
            }
        }


    }
    /**
     * تحديث id_sync
     * @param int $id_row id of item in the table
     * @param int $id_sync id of sync table
     * @param string $table name of table
     * @return void
     */
    function update_id_sync($id_row,$id_sync,$table)

    {

        $this->create_id_sync($table);
        $stmt_item=$this->db->prepare("UPDATE `$table` SET `id_sync`=? WHERE  `id`=?  ");
        $stmt_item->execute(array($id_sync,$id_row));
    }
    /**
     * h27
     * get id_sync of any table
     * @param int $id id of row in table
     * @param string $table_name name of table
     * @return int id_sync (اذا كانت النتيجة null فهذا يعني ان الصف غير موجود)
     */
    public function get_id_sync($id,$table_name)
    {
        $this->create_id_sync($table_name);
        $stmt_id_sync=$this->db->prepare("SELECT id_sync,id FROM {$table_name} WHERE id=?  ");
        $stmt_id_sync->execute(array($id));
        // echo "SELECT id_sync,id FROM {$table_name} WHERE id={$id}  ";
        $row_id_sync = $stmt_id_sync->fetch(PDO::FETCH_ASSOC);
        if(empty($row_id_sync))
        {
            return "no row";
        }
        else
        {
            return $row_id_sync['id_sync'];
        }

    }
    function create_id_sync($table)
    {
        $stmt = $this->db->prepare("SHOW COLUMNS FROM `{$table}` LIKE 'id_sync'");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($row))
        {
            $stmt = $this->db->prepare("ALTER TABLE `{$table}` ADD `id_sync` INT(11) NOT NULL DEFAULT '0'");
            $stmt->execute();
        }

    }


  	/*
    * NAI
    * create field is_delete
    * 2022/05
    */
	public function create_is_delete($table)
    {
        $stmt = $this->db->prepare("SHOW COLUMNS FROM `{$table}` LIKE 'is_delete'");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($row))
        {
            $stmt = $this->db->prepare("ALTER TABLE `{$table}` ADD `is_delete` INT(11) NOT NULL DEFAULT '0'");
            $stmt->execute();
        }

    }

	/*
    * NAI
    * Update value  field is_delete
    * 2022/05
    */
  	public function update_is_delete($table,$where_claus)
	{

    	$this->create_is_delete($table);
        $stmt_item=$this->db->prepare("UPDATE {$table} SET `is_delete`=1 WHERE  {$where_claus} ");
        $stmt_item->execute();
		// $stmt_item=$this->db->prepare("UPDATE {$table} SET `is_delete`= 1 WHERE  {$where_clause} ");
		// $stmt_item->execute();
    }
	/*
    * NAI
    * تشفير الباركود بعد الحذف
    * Update value  code
    * 2022/07/10
    */
	 public function update_code($table,$code,$id)
    {

        $code = $code.'_d_'.$id;
        $stmt_item=$this->db->prepare("UPDATE {$table} SET code =? WHERE  id = ?");
        $stmt_item->execute(array($code, $id));

    }

    /**
     * h27
     * الدالة الخاصة بالصور
     * @param int $id id of sync in table
     * @param int $id_row id of files
     * @return int $id_sync id of sync in table
     */
    function add_file_send($id,$id_row)
    {
        $this->add_to_sync_log($id,$id_row,'files','add_file','strating');
        $this->create_id_sync('files');
        $statm = $this->db->prepare("SELECT `id`, `module`, `normal_name`, `rand_name`, `relid`, `description`, `ext`, `file_type`, `file_size`, `lang`,  `date` FROM `files`  WHERE `id`=? ");
        $statm->execute(array($id_row));
        $row = $statm->fetch(PDO::FETCH_ASSOC);
        // print_r($row);
        // نحول الصورة الى سترنك
        // $path_img = FILES_h27.$row['rand_name'];
        // if (!file_exists($path_img))
        // {
        //     $path_img = url . "/public/ar/image/site/img_404.png";
        // }
        // // echo $path_img;
        // $img_base64 =  base64_encode(file_get_contents($path_img));
        $path_img = ROOT_FILES_h27.$row['rand_name'];
        $type_img = "false";
        // echo $path_img;
        $img_base64 =  "false";
        // echo "<br> before if path: ".$path_img;
        if (file_exists($path_img))
        {
            // echo "<br> in if path: ".$path_img;
            $type_img = pathinfo($path_img, PATHINFO_EXTENSION);
            // echo $path_img;
            $img_base64 =  base64_encode(file_get_contents($path_img));
        }
        $array_data = array(
            'id'=>$row['id'],
            'module'=>$row['module'],
            'normal_name'=>$row['normal_name'],
            'relid'=>$row['relid'],
            'description'=>$row['description'],
            'ext'=>$row['ext'],
            'file_type'=>$row['file_type'],
            'file_size'=>$row['file_size'],
            'lang'=>$row['lang'],
            'date'=>$row['date'],
            'img_name'=>$row['rand_name'],
            'img_type'=>$type_img,
            'img' => $img_base64,
            'method'=>'add_file'
        );
        $this->add_to_sync_log($id,$id_row,'files','add_file','send to server : id : '.$row['id'].' - module : '.$row['module'].' - normal_name : '.$row['normal_name'].' - relid : '.$row['relid'].' - description : '.$row['description'].' - ext : '.$row['ext'].' - file_type : '.$row['file_type'].' - file_size : '.$row['file_size'].' - lang : '.$row['lang'].' - date : '.$row['date'].' - img_name : '.$row['rand_name'].' - method : add_file');
        $id_sync= $this->CallAPI('POST', "https://m/api/api_receive",$array_data);
        $this->add_to_sync_log($id,$id_row,'files','add_file','get from server : id : '.$id_sync);
        $id_sync = intval($id_sync);
        if($id_sync>0)
        {
            $this->add_to_sync_log($id,$id_row,'files','add_file','success : id : '.$id_sync);
            $this->update_id_sync($id_row,$id_sync,'files');
            $this->delete_rows('sync_schedule','id',$id);

        }else
        {
            $this->update_code_in_sync('error id : '.$row['id'].' - module : '.$row['module'].' - normal_name : '.$row['normal_name'].' - relid : '.$row['relid'].' - description : '.$row['description'].' - ext : '.$row['ext'].' - file_type : '.$row['file_type'].' - file_size : '.$row['file_size'].' - lang : '.$row['lang'].' - date : '.$row['date'].' - img_name : '.$row['rand_name'],$id);
            $this->add_to_sync_log($id,$id_row,'files','add_file','feild : id : '.$id_sync);
        }
        return $id_sync;

    }
    /**
     * H27
     * اذا كانت الفئة غير مضافة ف نضيفها
     * واذا كانت غير موجةده ف نحدث عليها
     * @param int $id id of sync in table
     * @param int $id_cat id of category
     * @param string $model name of category
     */
    function add_category_send($id=0,$id_row,$model)
    {

        $this->add_to_sync_log($id,$id_row,$model,'add_category','strating');
     	$this->create_is_delete('category_'.$model);

        // echo "<br> strat add cat , id ".$id_row;
        // $this->create_id_sync('category_'.$model);
        // فائدة هذه المصفوفة للتاكد من اضافة جميع الايديات المرتبطة بالفئة قد تمت مزامنتها
        $check_FK =array("check_img"=>false, "check_relid"=>false);
        $statm = $this->db->prepare("SELECT `id`, `title`, `img`, `relid`, `active`, `date`, `order_cat`, `code_cat` , `is_delete` FROM `category_{$model}` WHERE `id`=? ");
        $statm->execute(array($id_row));
        $row = $statm->fetch(PDO::FETCH_ASSOC);
        // echo "<br> row ";
        // print_r($row);
        // echo "<br>";
        // //  بداية اضافة الملف المرتبط بالفئة
        $id_file=$this->get_id_sync($row['img'],'files');
        // // اذا كان صفر فالملف لم تتم مزامنته
        // echo "test id_file : ";
        // echo $id_file.'<br>';
        if(strval($id_file)=='0')
        {
            // echo "test add_file_send";
            $id_file=intval($this->add_file_send(0,$row['img']));
            // اذا كان الناتج اكبر من صفر فان المزامنة تمت بنجاح للصورة
            if($id_file>0)
            {
                $check_FK['check_img']=true;
            }
        }
        // في الحالتان المذكورتان اما الصورة غير مضافة اصلا للنضام الداخلي ف نتجاوزها ونعتبر انها تمت اضافتها
        // او انها قد تمت اضافتها وقد حصلنا على معرف المزامنة
        else if($id_file=="no row" || $id_file>0)
        {
            $check_FK['check_img']=true;
        }




        // print_r($check_FK);
        // echo "<br>";
        // بداية اضافة الفئة الاب
        $id_relid=$this->get_id_sync($row['relid'],'category_'.$model);
        // اذا كان صفر فالفئة الاب لم تتم مزامنته
        if(strval($id_relid)=='0')
        {
            $id_relid=intval($this->add_category_send(0,$row['relid'],$model));
            // اذا كان الناتج اكبر من صفر فان المزامنة تمت بنجاح للفئة الاب
            if($id_relid>0)
            {
                $check_FK['check_relid']=true;
            }
        }
        // في الحالتان المذكورتان اما الفئة الاب غير موجدة اصلا للنضام الداخلي ف نتجاوزها ونعتبر انها تمت اضافتها
        // او انها قد تمت اضافتها وقد حصلنا على معرف المزامنة
        else if($id_relid=="no row" || $id_relid>0)
        {
            $check_FK['check_relid']=true;
        }
        // print_r($check_FK);
        // echo "<br>";
        if($check_FK['check_img']==true && $check_FK['check_relid']==true)
        {
            $array_data = array(
                'id'=>$row['id'],
                'title'=>$row['title'],
                'img'=>intval($id_file),
                'relid'=>intval($id_relid),
                'active'=>$row['active'],
                'date'=>$row['date'],
                'order_cat'=>$row['order_cat'],
                'code_cat'=>$row['code_cat'],
                'model'=>$model,
              'is_delete'=>$row['is_delete'],
                'method'=>'add_category'
            );
            $this->add_to_sync_log($id,$id_row,$model,'add_category','send to server : - id '.$row['id'].' - title '.$row['title'].' - img '.$row['img'].' - relid '.$row['relid'].' - active '.$row['active'].' - date '.$row['date'].' - order_cat '.$row['order_cat'].' - code_cat '.$row['code_cat']);
            // print_r($array_data);
            // echo "<br>";
            $id_sync= $this->CallAPI('POST', "https://m/api/api_receive",$array_data);
            // echo $id_sync."<br>";
            $this->add_to_sync_log($id,$id_row,$model,'add_category','receive from server : - id '.$id_sync);
            $id_sync = intval($id_sync);
            if($id_sync>0)
            {
                $this->add_to_sync_log($id,$id_row,$model,'add_category','success : - id '.$id_sync);
                $this->update_id_sync($id_row,$id_sync,'category_'.$model);
                $this->delete_rows('sync_schedule','id',$id);
            }
            return $id_sync;
        }
        else
        {
            $this->add_to_sync_log($id,$id_row,$model,'add_category','failed check FK ');
            $this->update_code_in_sync('error id '.$row['id'].' - title '.$row['title'].' - img '.$row['img'].' - relid '.$row['relid'].' - active '.$row['active'].' - date '.$row['date'].' - order_cat '.$row['order_cat'].' - code_cat '.$row['code_cat'],$id);
            return 0;
        }
    }
    /**
     * h27
     * الدالة الخاصة باضافة وتعديل المواد
     * تشمل الموديلات(حلول الشبكة و الحلول الامنية والالعاب والحاسوب والطباعة)
     * @param int $id the id of sync table
     * @param int $id_row the id of row in table
     * @param string $table_name the name of table
     */
    function add_item_send($id,$id_row,$table_name)
    {

    	$this->create_is_delete($table_name);
    	$this->create_is_delete('code_'.$table_name);
    	$this->create_is_delete('color_'.$table_name);

        $this->add_to_sync_log($id,$id_row,$table_name,'add_item','start');
        $check_FK =array("check_id_cat"=>false);
        $stmt_item=$this->db->prepare("SELECT  `id`, `title`, `content`, `id_cat`, `id_main_cat`, `img`, `view`, `active`, `main_cat`, `date`, `bast_it`, `tags`, `specifications`, `cuts`, `price_cuts`, `description`, `serial_flag`, `price_dollars`, `location`, `enter_serial`, `change_price`,`is_delete`  FROM {$table_name} WHERE `id`=?  ");
        $stmt_item->execute(array($id_row));
        $row_item =$stmt_item->fetch(PDO::FETCH_ASSOC);
        // معرف الفئة في الموقع
        $id_cat = $this->get_id_sync($row_item['id_cat'],$table_name);
        // اذا كان صفر ف الفئة لم تتم مزامنتها
        // echo "<br> id_cat ".$id_cat;
        if(strval($id_cat)=='0')
        {
            // echo "<br> if cat =0 ";
            $id_cat = $this->add_category_send(0,$row_item['id_cat'],$table_name);
            // echo "<br> sync id cat : ".$id_cat;
            if($id_cat>0)
            {
                $check_FK['check_id_cat']=true;
            }
        }
        else if ($id_cat>0 || $id_cat=='no row')
        {
            $check_FK['check_id_cat']=true;
        }
        // echo "<br> check_FK";
        // print_r($check_FK);
        if($check_FK['check_id_cat'])
        {
            $stmt_codes=$this->db->prepare("SELECT code FROM `code_{$table_name}` where id_color in (select id from color_{$table_name} where id_item =? )");
            $stmt_codes->execute(array($id_row));

            $check_codes="( ";
            while ($row_codes = $stmt_codes->fetch(PDO::FETCH_ASSOC))
            {
                $check_codes.='"'.$row_codes['code'].'",';
            }
            $check_codes=substr($check_codes,0,-1).')';
            $array_data = array(
                'id' => $row_item['id'],
                'title' => $row_item['title'],
                'content' => $row_item['content'],
                'id_cat' => $id_cat,
                'id_main_cat' => $row_item['id_main_cat'],
                'active' => $row_item['active'],
                'main_cat' => $row_item['main_cat'],
                'date' => $row_item['date'],
                'bast_it' => $row_item['bast_it'],
                'tags' => $row_item['tags'],
                'specifications' => $row_item['specifications'],
                'cuts' => $row_item['cuts'],
                'price_cuts' => $row_item['price_cuts'],
                'description' => $row_item['description'],
                'serial_flag' => $row_item['serial_flag'],
                'price_dollars' => $row_item['price_dollars'],
                'location' => $row_item['location'],
                'enter_serial' => $row_item['enter_serial'],
                'change_price' => $row_item['change_price'],
                'table_name' => $table_name,
              	'is_delete' => $row_item['is_delete'],
                'check_codes' => $check_codes,
                'method' => 'add_item'
            );
            $this->add_to_sync_log($id,$id_row,$table_name,'add_item','send to server : - id '.$row_item['id'].' - title '.$row_item['title']. ' - id_cat '.$id_cat.' - id_main_cat '.$row_item['id_main_cat'].' - active '.$row_item['active'].' - main_cat '.$row_item['main_cat'].' - date '.$row_item['date'].' - bast_it '.$row_item['bast_it'].' - tags '.$row_item['tags'].' - specifications '.$row_item['specifications'].' - cuts '.$row_item['cuts'].' - price_cuts '.$row_item['price_cuts'].' - description '.$row_item['description'].' - serial_flag '.$row_item['serial_flag'].' - price_dollars '.$row_item['price_dollars'].' - location '.$row_item['location'].' - enter_serial '.$row_item['enter_serial'].' - change_price '.$row_item['change_price']. ' - table_name '.$table_name.' - check_codes '.$check_codes);
            // echo "<br> array_data";
            // print_r($array_data);
            $id_item = $this->CallAPI('POST','https://m/api/api_receive', $array_data);
            $this->add_to_sync_log($id,$id_row,$table_name,'add_item','receive from server : - id_item '.$id_item);
            // echo "<br> id_item ".$id_item;
            // اذا كانت النتيجة 0 فهذا يعني ان الاضافة لم تتم ف ننهي عمل الدالة الى هنا
            $id_item = intval($id_item);
            if($id_item==0)
            {
                $this->add_to_sync_log($id,$id_row,$table_name,'add_item','fild to item');
                $this->update_code_in_sync('error - id '.$row_item['id'].' - title '.$row_item['title']. ' - id_cat '.$id_cat.' - id_main_cat '.$row_item['id_main_cat'].' - active '.$row_item['active'].' - main_cat '.$row_item['main_cat'].' - date '.$row_item['date'].' - bast_it '.$row_item['bast_it'].' - tags '.$row_item['tags'].' - specifications '.$row_item['specifications'].' - cuts '.$row_item['cuts'].' - price_cuts '.$row_item['price_cuts'].' - description '.$row_item['description'].' - serial_flag '.$row_item['serial_flag'].' - price_dollars '.$row_item['price_dollars'].' - location '.$row_item['location'].' - enter_serial '.$row_item['enter_serial'].' - change_price '.$row_item['change_price']. ' - table_name '.$table_name.' - check_codes '.$check_codes,$id);
                return 0;
            }
            //     // echo $id_item;
            //  بعد اضافة المادة
            // نضيف الالوان الخاصة بالمادة
            $stmt_color=$this->db->prepare("SELECT a.`id` as id, a.`color` as color, a.`code_color` as code_color, a.`id_item` as id_item, a.`img` as img, a.`date` as date ,a.`is_delete` as is_delete,b.code as code FROM color_{$table_name} a ,code_{$table_name} b where a.id_item=? and a.id=b.id_color;");
            $stmt_color->execute(array($id_row));
            // print_r($stmt_color);
            while ($row_color = $stmt_color->fetch(PDO::FETCH_ASSOC))
            {
                // نحول الصورة الى سترنك
                // $path_img = FILES_h27.$row_color['img'];
                // if (!file_exists($path_img))
                // {
                //     $path_img = url . "/public/ar/image/site/img_404.png";
                // }
                // $type_img = pathinfo($path_img, PATHINFO_EXTENSION);
                // // echo $path_img;
                // $img_base64 =  base64_encode(file_get_contents($path_img));

                $path_img = ROOT_FILES_h27.$row_color['img'];
                $type_img = "false";
                // echo $path_img;
                $img_base64 =  "false";
                // echo "<br> before if path: ".$path_img;
                if (file_exists($path_img))
                {
                    // echo "<br> in if path: ".$path_img;
                    $type_img = pathinfo($path_img, PATHINFO_EXTENSION);
                    // echo $path_img;
                    $img_base64 =  base64_encode(file_get_contents($path_img));
                }
                $array_data = array(
                    'id' => $row_color['id'],
                    'color' => $row_color['color'],
                    'code_color' => $row_color['code_color'],
                    'id_item' => $id_item,
                    'img_name'=>$row_color['img'],
                    'img_type'=>$type_img,
                    'img' => $img_base64,
                    'date' => $row_color['date'],
                    'code' => $row_color['code'],
                	'is_delete' => $row_color['is_delete'],
                    'model' => $table_name,
                    'method' => 'add_color_item'
                );
                $this->add_to_sync_log($id,$id_row,$table_name,'add_color_item','send to server : - id '.$row_color['color'].' - color '.$row_color['color'].' - code_color '.$row_color['code_color'].' - id_item '.$id_item.'  - date '.$row_color['date'].' - code '.$row_color['code'].' - model '.$table_name);
                // echo "<br> array data color item";
                // print_r($array_data);
                $id_color= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
                $this->add_to_sync_log($id,$id_row,$table_name,'add_color_item','receive from server : - id_color '.$id_color);
                // echo $id_color;
                // بعد اضافة الالوان
                // نضيف الاحجام الخاصة باللون
                // echo '<br>'.$id_color.'<br>';
                $id_color= intval($id_color);
                if($id_color==0)
                {
                    $this->add_to_sync_log($id,$id_row,$table_name,'add_color_item','fild to color');
                    $this->update_code_in_sync('error - id '.$id_color.' - color '.$row_color['color'].' - code_color '.$row_color['code_color'].' - id_item '.$id_item.'  - date '.$row_color['date'].' - code '.$row_color['code'].' - model '.$table_name,$id);
                    return 0;
                }
                $this->add_to_sync_log($id,$id_row,$table_name,'add_code_item','start');
                $stmt_code=$this->db->prepare("SELECT `id`, `code`, `size`, `id_color`, `date`, `serial`, `location` , `is_delete` FROM `code_{$table_name}` where id_color=?");
                $stmt_code->execute(array($row_color['id'],));
                while ($row_code = $stmt_code->fetch(PDO::FETCH_ASSOC))
                {
                    $array_data = array(
                        'id' => $row_code['id'],
                        'code' => $row_code['code'],
                        'size' => $row_code['size'],
                        'id_color' => $id_color,
                        'date' => $row_code['date'],
                        'serial' => $row_code['serial'],
                        'location' => $row_code['location'],
                       'is_delete' => $row_code['is_delete'],
                        'model' => $table_name,
                        'method' => 'add_code_item'

                    );
                    $this->add_to_sync_log($id,$id_row,$table_name,'add_code_item','send to server : - id '.$row_code['id'].' - code '.$row_code['code'].' - size '.$row_code['size'].' - id_color '.$id_color.'  - date '.$row_code['date'].' - serial '.$row_code['serial'].' - location '.$row_code['location'].' - model '.$table_name);
                    // echo "code";
                    // print_r($array_data);
                    $id_code= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
                    $this->add_to_sync_log($id,$id_row,$table_name,'add_code_item','receive from server : - id_code '.$id_code);
                    // echo '<br>'.$id_code.'<br>';
                    $id_code = intval($id_code);
                    if($id_code==0)
                    {
                        $this->add_to_sync_log($id,$id_row,$table_name,'add_code_item','fild to code');
                        $this->update_code_in_sync('error - id '.$row_code['id'].' - code '.$row_code['code'].' - size '.$row_code['size'].' - id_color '.$id_color.'  - date '.$row_code['date'].' - serial '.$row_code['serial'].' - location '.$row_code['location'].' - model '.$table_name,$id);
                        return 0;
                    }
                    // return $id_code;
                }
            }
            // echo "<br> befor sync_schedule ";
            $this->add_to_sync_log($id,$id_row,$table_name,'add_item','end');
            $this->delete_rows('sync_schedule','id',$id);
            return 1;
        }
        else
        {
            $this->add_to_sync_log($id,$id_row,$table_name,'add_item','fild in FK');
            $this->update_code_in_sync('error - fild in FK',$id);
            return 0;
        }

    }
    /**
     * اضافة الفئة
     * category_savers
     * @param int $id id of sync table , if 0 then return value
     * @param int $id_row id of item in the table
     * @return int if id=0 else return void
     */
    function add_category_savers_send($id=0,$id_row)
    {
        $this->add_to_sync_log($id,$id_row,'category_savers','add_category_savers','start');
        $this->create_id_sync('category_savers');
    	$this->create_is_delete('category_savers');
        $stmt_item=$this->db->prepare("SELECT `id`, `title`, `relid`, `active`, `order_cat`, `date`, `is_delete` FROM `category_savers` WHERE  `id`=?  ");
        $stmt_item->execute(array($id_row));
        $row_item =$stmt_item->fetch(PDO::FETCH_ASSOC);
        $array_data = array(
            'id' => $row_item['id'],
            'title' => $row_item['title'],
            'relid' => $row_item['relid'],
            'active' => $row_item['active'],
            'order_cat' => $row_item['order_cat'],
            'date' => $row_item['date'],
         	'is_delete' => $row_item['is_delete'],
            'method' => 'add_category_savers',

        );
        $this->add_to_sync_log($id,$id_row,'category_savers','add_category_savers','send to server : - id '.$row_item['id'].' - title '.$row_item['title'].' - relid '.$row_item['relid'].' - active '.$row_item['active'].' - order_cat '.$row_item['order_cat'].' - date '.$row_item['date']);
        $id_sync = $this->CallAPI('POST','https://m/api/api_receive', $array_data);
        $this->add_to_sync_log($id,$id_row,'category_savers','add_category_savers','receive from server : - id_sync '.$id_sync);
        // اذا تمت العملية بنجاح ف سوف تعيد عدد اكبر من 0
        $id_sync = intval($id_sync);
        if($id_sync>0)
        {
            $this->add_to_sync_log($id,$id_row,'category_savers','add_category_savers','end');
            $this->update_id_sync($id_row,$id_sync,$table='category_savers');
            $this->delete_rows('sync_schedule','id',$id);
        }
        else
        {
            $this->add_to_sync_log($id,$id_row,'category_savers','add_category_savers','fild to sync');
            $this->update_code_in_sync('error - fild to sync',$id);
            return 0;
        }
        return $id_sync;
    }
    /**
     * اضافة اسم الحافضة
     * name_device
     * @param int $id id of sync table , if 0 then return value
     * @param int $id_row id of item in the table
     * @return int if id=0 else return void
     */
    function add_name_device_send($id=0,$id_row)
    {
        $this->add_to_sync_log($id,$id_row,'name_device','add_name_device','start');
    	$this->create_is_delete('name_device');
        $check_FK = array('check_id_cat'=>false);
        $stmt_item=$this->db->prepare("SELECT `id`, `title`, `id_cat`,  `active`, `date`,`is_delete` FROM `name_device` WHERE  `id`=?  ");
        $stmt_item->execute(array($id_row));
        $row_item =$stmt_item->fetch(PDO::FETCH_ASSOC);
        $id_cat = $this->get_id_sync($row_item['id_cat'],'category_savers');
        // اذا كانت القيمة 0 ف هذا يعني ان الفئة لم تتم مزامنتها مع الموقع
        if(strval($id_cat)=='0')
        {
            $id_cat=intval($this->add_category_savers_send(0,$row_item['id_cat']));
            // اذا كانت النتيجة اكبر من 0 ف يعني ان الفئة تم مزامنتها مع الموقع
            if($id_cat>0)
            {
                $check_FK['check_id_cat']=true;
            }
        }
        //  للتوضيح ان في حالة (لا صفوف  ) فان الفئة اصلا غير موجوده في النضام الداخلي وفي هذه الحالة نعتبره 0
        else if($id_cat>0 || $id_cat=='no row')
        {
            $check_FK['check_id_cat']=true;
        }
        if($check_FK['check_id_cat']==true)
        {
            $this->create_id_sync('name_device');
            $array_data = array(
                'id' => $row_item['id'],
                'title' => $row_item['title'],
                'id_cat' => intval($id_cat),
                'active' => $row_item['active'],
                'date' => $row_item['date'],
            	'is_delete' => $row_item['is_delete'],
                'method' => 'add_name_device',

            );
            $this->add_to_sync_log($id,$id_row,'name_device','add_name_device','send to server : - id '.$row_item['id'].' - title '.$row_item['title'].' - id_cat '.$row_item['id_cat'].' - active '.$row_item['active'].' - date '.$row_item['date']);
            $id_sync=intval($this->CallAPI('POST','https://m/api/api_receive', $array_data));
            $this->add_to_sync_log($id,$id_row,'name_device','add_name_device','receive from server : - id_sync '.$id_sync);
            // اذا تمت الاضافة بصورة صحيحة فنحدث حقل المزامنة
            //  واذا ليست صحية ف لا
            if($id_sync>0)
            {
                $this->add_to_sync_log($id,$id_row,'name_device','add_name_device','end');
                $this->update_id_sync($id_row,$id_sync,'name_device');
                $this->delete_rows('sync_schedule','id',$id);
            }
            else
            {
                $this->add_to_sync_log($id,$id_row,'name_device','add_name_device','fild to sync');
                $this->update_code_in_sync('error - fild to sync',$id);
                return 0;
            }
            return $id_sync;
        }
        else
        {
            $this->add_to_sync_log($id,$id_row,'name_device','add_name_device',' fild in FK');
            $this->update_code_in_sync('error - fild in FK',$id);
            return 0;
        }
    }
    /**
     * اضافة نوع الحافضة
     * type_device
     * @param int $id id of sync table , if 0 then return value
     * @param int $id_row id of item in the table
     * @return int
     */
    function add_type_device_send($id=0,$id_row)
    {
        // echo"<br> start device  id row ".$id_row;
    	$this->create_is_delete('type_device');
        $this->add_to_sync_log($id,$id_row,'type_device','add_type_device','start');
        $check_FK = array('check_id_device'=>false);
        $stmt_item=$this->db->prepare("SELECT `id`, `title`, `id_device`, `active`, `date`, `is_delete` FROM `type_device` WHERE  `id`=?  ");
        $stmt_item->execute(array($id_row));
        $row_item =$stmt_item->fetch(PDO::FETCH_ASSOC);
        $id_device = $this->get_id_sync($row_item['id_device'],'name_device');
        // اذا كانت القيمة 0 ف هذا يعني ان الفئة لم تتم مزامنتها مع الموقع
        // echo"<br> id  device ".$id_device;
        if(strval($id_device)=='0')
        {
            // echo"<br> if id  device = 0 ";
            $id_device = $this->add_name_device_send($id=0,$row_item['id_device']);
            // اذا كانت النتيجة اكبر من 0 ف يعني ان الفئة تم مزامنتها مع الموقع
            // echo"<br> id  device ".$id_device;
            if(intval($id_device)>0)
            {
                $check_FK['check_id_device']=true;
            }
        }
        //  للتوضيح ان في حالة (لا صفوف  ) فان اسم الجهاز اصلا غير موجوده في النضام الداخلي وفي هذه الحالة نعتبره 0
        else if($id_device>0 || $id_device=='no row')
        {
            $check_FK['check_id_device']=true;
        }
        if($check_FK['check_id_device']==true)
        {
            $this->create_id_sync('type_device');
            $array_data= array(
                'id' => $row_item['id'],
                'title' => $row_item['title'],
                'id_device' => intval($id_device),
                'active' => $row_item['active'],
                'date' => $row_item['date'],
              'is_delete' => $row_item['is_delete'],
                'method' => 'add_type_device',
            );
            $this->add_to_sync_log($id,$id_row,'type_device','add_type_device','send to server : - id '.$row_item['id'].' - title '.$row_item['title'].' - id_device '.$row_item['id_device'].' - active '.$row_item['active'].' - date '.$row_item['date']);
            $id_sync=intval($this->CallAPI('POST','https://m/api/api_receive', $array_data));
            $this->add_to_sync_log($id,$id_row,'type_device','add_type_device','receive from server : - id_sync '.$id_sync);
            if($id_sync>0)
            {
                $this->add_to_sync_log($id,$id_row,'type_device','add_type_device','end');
                $this->update_id_sync($row_item['id'],$id_sync,'type_device');
                $this->delete_rows('sync_schedule','id',$id);
            }
            else
            {
                $this->add_to_sync_log($id,$id_row,'type_device','add_type_device','fild to sync');
                $this->update_code_in_sync('error - fild to sync',$id);
                return 0;
            }
            return $id_sync;
        }
        else
        {
            $this->add_to_sync_log($id,$id_row,'type_device','add_type_device',' fild in FK');
            $this->update_code_in_sync('error - fild in FK',$id);
            return 0;
        }
    }
    /**
     * الدالة الخاصة بالحافضات
     * @param int $id id of sync table
     * @param int $id_row id of item in the table
     *
     * ففي حالة ان المادة موجوده ف تحدث معلوماتها واذا لم تكن موجوده ف تعيد اضافتها
     *
     */
    function add_savers_send($id=0,$id_row)
    {
        $this->add_to_sync_log($id,$id_row,'savers','add_savers','start');
    	$this->create_is_delete('product_savers');
        // echo"<br> start add savers ";
        $check_FK = array('check_id_device'=>false);
        $stmt_item=$this->db->prepare("SELECT `id`, `color`, `code_color`, `img`, `id_product`, `date`, `code`, `title`, `content`, `latiniin`, `symbol`, `bast_it`, `active`, `userId`, `cuts`, `price_cuts`, `id_device`, `serial_flag`, `location`, `enter_serial`, `locationTag`, `serial`, `change_price` ,`is_delete` FROM `product_savers` WHERE  `id`=?  ");
        $stmt_item->execute(array($id_row));
        $row_item =$stmt_item->fetch(PDO::FETCH_ASSOC);
        $id_device = $this->get_id_sync($row_item['id_device'],'type_device');
        // echo"<br> id  device ".$id_device;
        // اذا كانت القيمة 0 ف هذا يعني ان نوع الجهاز لم تتم مزامنتها مع الموقع
        if(strval($id_device)=='0')
        {
            // echo"<br> if id  device = 0 ";
            $id_device = $this->add_type_device_send($id=0,$row_item['id_device']);
            // اذا كانت النتيجة اكبر من 0 ف يعني ان نوع الجهاز تم مزامنتها مع الموقع
            // echo"<br> id  device ".$id_device;
            if(intval($id_device)>0)
            {
                $check_FK['check_id_device']=true;
            }
        }
        //  للتوضيح ان في حالة (لا صفوف  ) فان اسم الجهاز اصلا غير موجوده في النضام الداخلي وفي هذه الحالة نعتبره 0
        else if($id_device>0 || $id_device=='no row')
        {
            $check_FK['check_id_device']=true;
        }
        // echo "<br> check ";
        // print_r($check_FK);
        if($check_FK['check_id_device'])
        {
            // نحول الصورة الى سترنك
            // $path_img = FILES_h27.$row_item['img'];
            // if (!file_exists($path_img))
            // {
            //     $path_img = url . "/public/ar/image/site/img_404.png";
            // }
            // $type_img = pathinfo($path_img, PATHINFO_EXTENSION);
            // // echo $path_img;
            // $img_base64 =  base64_encode(file_get_contents($path_img));
            // معرف الفئة في الموقع
            $path_img = ROOT_FILES_h27.$row_item['img'];
            $type_img = "false";
            // echo $path_img;
            $img_base64 =  "false";
            // echo "<br> before if path: ".$path_img;
            if (file_exists($path_img))
            {
                // echo "<br> in if path: ".$path_img;
                $type_img = pathinfo($path_img, PATHINFO_EXTENSION);
                // echo $path_img;
                $img_base64 =  base64_encode(file_get_contents($path_img));
            }
            $array_data = array(
                'id' => $row_item['id'],
                'color' => $row_item['color'],
                'code_color' => $row_item['code_color'],
                'img_name'=>$row_item['img'],
                'img_type'=>$type_img,
                'img' => $img_base64,
                'id_product' => $row_item['id_product'],
                'date' => $row_item['date'],
                'code' => $row_item['code'],
                'title' => $row_item['title'],
                'content' => $row_item['content'],
                'latiniin' => $row_item['latiniin'],
                'symbol' => $row_item['symbol'],
                'bast_it' => $row_item['bast_it'],
                'active' => $row_item['active'],
                'cuts' => $row_item['cuts'],
                'price_cuts' => $row_item['price_cuts'],
                'id_device' => intval($id_device),
                'serial_flag' => $row_item['serial_flag'],
                'location' => $row_item['location'],
                'enter_serial' => $row_item['enter_serial'],
                'locationTag' => $row_item['locationTag'],
                'serial' => $row_item['serial'],
                'change_price' => $row_item['change_price'],
            	 'is_delete' => $row_item['is_delete'],
                'method' => 'add_savers',
            );
            $this->add_to_sync_log($id,$id_row,'savers','add_savers','send to server : - id : '.$row_item['id']. ' - color : '.$row_item['color'].' - code_color : '.$row_item['code_color'].'  - id_product : '.$row_item['id_product'].' - date : '.$row_item['date'].' - code : '.$row_item['code'].' - title : '.$row_item['title'].'  - latiniin : '.$row_item['latiniin'].' - symbol : '.$row_item['symbol'].' - bast_it : '.$row_item['bast_it'].' - active : '.$row_item['active'].' - cuts : '.$row_item['cuts'].' - price_cuts : '.$row_item['price_cuts'].' - id_device : '.$row_item['id_device'].' - serial_flag : '.$row_item['serial_flag'].' - location : '.$row_item['location'].' - enter_serial : '.$row_item['enter_serial'].' - locationTag : '.$row_item['locationTag'].' - serial : '.$row_item['serial'].' - change_price : '.$row_item['change_price']);
            // print_r($array_data);

            if(intval( $this->CallAPI('POST','https://m/api/api_receive', $array_data))>0)
            {
                $this->add_to_sync_log($id,$id_row,'savers','add_savers',' end');
                $this->delete_rows('sync_schedule','id',$id);
                return 1;
            }
            else
            {
                $this->add_to_sync_log($id,$id_row,'savers','add_savers',' error in send to server');
                $this->update_code_in_sync("error in send to server",$id);
                return 0;
            }

        }
        else
        {
            $this->add_to_sync_log($id,$id_row,'savers','add_savers',' faild in FK');
            $this->delete_rows('sync_schedule','id',$id);

            return 0;
        }
    }
    /**
     * h27
     * الدالة الخاصة باضافة الاكسسوارات
     * @param int $id id of sync_schedule table
     * @param string $id_row id of accessories table
     * بعد التعديل على دالة الاستقبال اصبحت الدالة للاضافة والتعديل معا
     * ففي حالة ان المادة موجوده ف تحدث معلوماتها واذا لم تكن موجوده ف تعيد اضافتها
     */
    function add_accessories_send($id=0,$id_row)
    {
        $this->add_to_sync_log($id,$id_row,'accessories','add_accessories',' start');
    	$this->create_is_delete('accessories');
    	$this->create_is_delete('color_accessories');
        $check_FK = array('check_id_cat'=>false);
        // ناخذ الباركودات لنستخدمها في التاكد من اضافة الاكسسوار في الموقع
        $stmt_codes=$this->db->prepare("SELECT code FROM `color_accessories` where id_item= ?");
        $stmt_codes->execute(array($id_row));
        $check_codes="( ";
        while ($row_codes = $stmt_codes->fetch(PDO::FETCH_ASSOC))
        {
            $check_codes.='"'.$row_codes['code'].'",';
        }
        $check_codes=substr($check_codes,0,-1).')';
        // echo "check_codes".$check_codes.'\n';
        $stmt_item=$this->db->prepare("SELECT  `id`, `title`, `content`, `id_cat`, `id_main_cat`, `img`,  `active`, `main_cat`, `date`, `bast_it`, `tags`, `specifications`, `cuts`, `price_cuts`, `description`, `serial_flag`, `price_dollars`, `location`, `enter_serial`, `change_price`,`is_delete`  FROM accessories WHERE `id`=?  ");
        $stmt_item->execute(array($id_row));
        $row_item =$stmt_item->fetch(PDO::FETCH_ASSOC);
        // معرف الفئة في الموقع
        $id_cat= $this->get_id_sync($row_item['id_cat'],'category_accessories');
        // echo "<br>id_cat".$id_cat.'<br>';
        if(strval($id_cat)=="0")
        {
            $id_cat=$this->add_category_send(0,$row_item['id_cat'],'accessories');
            if($id_cat>0)
            {
                $check_FK['check_id_cat']=true;
            }
        }
        else if($id_cat>0 || $id_cat=='no row')
        {
            $check_FK['check_id_cat']=true;
        }
        // echo "<br>check_FK<br>";
        // print_r($check_FK['check_id_cat']);
        if($check_FK['check_id_cat'])
        {
            $array_data = array(
                'id' => $row_item['id'],
                'title' => $row_item['title'],
                'content' => $row_item['content'],
                'id_cat' => intval($id_cat),
                'id_main_cat' => $row_item['id_main_cat'],
                'active' => $row_item['active'],
                'main_cat' => $row_item['main_cat'],
                'date' => $row_item['date'],
                'bast_it' => $row_item['bast_it'],
                'tags' => $row_item['tags'],
                'specifications' => $row_item['specifications'],
                'cuts' => $row_item['cuts'],
                'price_cuts' => $row_item['price_cuts'],
                'description' => $row_item['description'],
                'serial_flag' => $row_item['serial_flag'],
                'price_dollars' => $row_item['price_dollars'],
                'location' => $row_item['location'],
                'enter_serial' => $row_item['enter_serial'],
                'change_price' => $row_item['change_price'],
              'is_delete' => $row_item['is_delete'],
                'check_codes' => $check_codes,
                'method' => 'add_accessories',
            );
            $this->add_to_sync_log($id,$id_row,'accessories','add_accessories',' send to server : - id '.$row_item['id'].' title '.$row_item['title'].' id_cat '.$id_cat.' id_main_cat '.$row_item['id_main_cat'].' active '.$row_item['active'].' main_cat '.$row_item['main_cat'].' date '.$row_item['date'].' bast_it '.$row_item['bast_it'].' tags '.$row_item['tags'].' specifications '.$row_item['specifications'].' cuts '.$row_item['cuts'].' price_cuts '.$row_item['price_cuts'].' description '.$row_item['description'].' serial_flag '.$row_item['serial_flag'].' price_dollars '.$row_item['price_dollars'].' location '.$row_item['location'].' enter_serial '.$row_item['enter_serial'].' change_price '.$row_item['change_price'].' check_codes '.$check_codes);
            // print_r($array_data);
            $id_item = $this->CallAPI('POST','https://m/api/api_receive', $array_data);
            $this->add_to_sync_log($id,$id_row,'accessories','add_accessories','response from server : - id '.$id_item);
            $id_item = intval($id_item);
            // echo "<br> id_item ".$id_item.'<br>';
            if($id_item>0)
            {
                $this->add_to_sync_log($id,$id_row,'accessories','add_accessories',' start send colors');
                // echo $id_item;
                //  بعد اضافة المادة
                // نضيف الالوان الخاصة بالمادة
                $stmt_color=$this->db->prepare("SELECT `id`, `code`, `color`, `code_color`, `id_item`, `img`, `date`, `old_table`, `serial`, `location`, `minimum`, `maximum` , `is_delete` FROM `color_accessories` where id_item=?");
                $stmt_color->execute(array($id_row));
                while ($row_color = $stmt_color->fetch(PDO::FETCH_ASSOC))
                {
                    // نحول الصورة الى سترنك
                    $path_img = ROOT_FILES_h27.$row_color['img'];
                    $type_img = "false";
                    // echo $path_img;
                    $img_base64 =  "false";
                    // echo "<br> before if path: ".$path_img;
                    if (file_exists($path_img))
                    {
                        // echo "<br> in if path: ".$path_img;
                        $type_img = pathinfo($path_img, PATHINFO_EXTENSION);
                        // echo $path_img;
                        $img_base64 =  base64_encode(file_get_contents($path_img));
                    }

                    $array_data = array(
                        'id' => $row_color['id'],
                        'code' => $row_color['code'],
                        'color' => $row_color['color'],
                        'code_color' => $row_color['code_color'],
                        'id_item' => $id_item,
                        'img_name'=>$row_color['img'],
                        'img_type'=>$type_img,
                        'img' => $img_base64,
                        'date' => $row_color['date'],
                        'old_table' => $row_color['old_table'],
                        'serial' => $row_color['serial'],
                        'location' => $row_color['location'],
                        'minimum' => $row_color['minimum'],
                        'maximum' => $row_color['maximum'],
                     	'is_delete' => $row_color['is_delete'],
                        'method' => 'add_color_accessories'
                    );
                    $this->add_to_sync_log($id,$id_row,'accessories','add_color_accessories',' send to server : - id '.$row_color['id'].' - code '.$row_color['code'].' - color '.$row_color['color'].' - code_color '.$row_color['code_color'].' - id_item '.$id_item.' - date '.$row_color['date'].' - old_table '.$row_color['old_table'].' - serial '.$row_color['serial'].' - location '.$row_color['location'].' - minimum '.$row_color['minimum'].' - maximum '.$row_color['maximum']);
                    // print_r( $array_data);
                    $id_color = $this->CallAPI('POST','https://m/api/api_receive', $array_data);
                    $this->add_to_sync_log($id,$id_row,'accessories','add_color_accessories','response from server : - id '.$id_color);
                    // echo "<br> id_color ".$id_color;
                    $id_color = intval($id_color);
                    if($id_color == 0)
                    {
                        $this->add_to_sync_log($id,$id_row,'accessories','add_color_accessories',' error in send color');
                        // echo "<br> if empty ".$id_color;
                        $this->update_code_in_sync('error in color ',$id);
                        return 0;
                    }

                }
                // echo "<br> before delete ".$id;
                $this->delete_rows('sync_schedule','id',$id);
                return 1;
            }
            else
            {
                $this->add_to_sync_log($id,$id_row,'accessories','add_accessories',' error in send accessories');
                $this->update_code_in_sync('error in item ',$id);
                return 0;
            }
        }
    }
    function add_mobile_send($id,$id_row)
    {
        $this->add_to_sync_log($id,$id_row,'mobile','add_mobile',' start send mobile');
    	$this->create_is_delete('mobile');
    	$this->create_is_delete('code');
    	$this->create_is_delete('color');

        $check_FK =array("check_id_cat"=>false,"check_id_accessories"=>false,"check_id_savers"=>false);
        $stmt_item=$this->db->prepare("SELECT  `id`, `content`, `title`, `id_cat`, `id_main_cat`, `img`,  `active`, `main_cat`, `date`, `bast_it`, `tags`, `specifications`, `cuts`, `price_cuts`, `description`, `name_accessories`, `id_accessories`, `name_savers`, `id_savers`, `serial_flag`, `price_dollars`, `location`, `enter_serial` ,`is_delete` FROM mobile WHERE `id`=?  ");
        $stmt_item->execute(array($id_row));
        $row_item =$stmt_item->fetch(PDO::FETCH_ASSOC);
        // معرف الفئة في الموقع
        $id_cat = $this->get_id_sync($row_item['id_cat'],'category_mobile');
        // اذا كان صفر ف الفئة لم تتم مزامنتها
        if(strval($id_cat)=='0')
        {
            $id_cat = intval($this->add_category_send(0,$row_item['id_cat'],'mobile'));
            if($id_cat>0)
            {
                $check_FK['check_id_cat']=true;
            }
        }
        elseif ($id_cat>0 || $id_cat=='no row')
        {
            $check_FK['check_id_cat']=true;
        }
        $id_accessories = $this->get_id_sync($row_item['id_accessories'],"category_accessories");
        if(strval($id_accessories)=='0')
        {
            $id_accessories = intval($this->add_category_send(0,$row_item['id_accessories'],'accessories'));
            if($id_accessories>0)
            {
                $check_FK['check_id_accessories']=true;
            }
        }
        else if($id_accessories>0 || $id_accessories=='no row')
        {
            $check_FK['check_id_accessories']=true;
        }
        $id_savers = $this->get_id_sync($row_item['id_savers'],"type_device");
        if(strval($id_savers)=='0')
        {
            $id_savers = intval($this->add_type_device_send(0,$row_item['id_savers'],'type_device'));
            if($id_savers>0)
            {
                $check_FK['check_id_savers']=true;
            }
        }
        else if($id_savers>0 || $id_savers=='no row')
        {
            $check_FK['check_id_savers']=true;
        }
        // print_r($check_FK);
        if($check_FK['check_id_cat'] && $check_FK['check_id_accessories'] && $check_FK['check_id_savers'])
        {
            $stmt_codes=$this->db->prepare("SELECT code FROM `code` where id_color in (select id from color where id_item =? )");
            $stmt_codes->execute(array($id_row));
            $check_codes="( ";
            while ($row_codes = $stmt_codes->fetch(PDO::FETCH_ASSOC))
            {
                $check_codes.='"'.$row_codes['code'].'",';
            }
            $check_codes=substr($check_codes,0,-1).')';
            $array_data = array(
                'id' => $row_item['id'],
                'content' => $row_item['content'],
                'title' => $row_item['title'],
                'id_cat' => intval($id_cat),
                'id_main_cat' => intval($row_item['id_main_cat']),
                'active' => $row_item['active'],
                'main_cat' => $row_item['main_cat'],
                'date' => $row_item['date'],
                'bast_it' => $row_item['bast_it'],
                'tags' => $row_item['tags'],
                'specifications' => $row_item['specifications'],
                'cuts' => $row_item['cuts'],
                'price_cuts' => $row_item['price_cuts'],
                'description' => $row_item['description'],
                'name_accessories' => $row_item['name_accessories'],
                'id_accessories' => intval($id_accessories),
                'name_savers' => $row_item['name_savers'],
                'id_savers' => intval($id_savers),
                'serial_flag' => $row_item['serial_flag'],
                'price_dollars' => $row_item['price_dollars'],
                'location' => $row_item['location'],
                'enter_serial' => $row_item['enter_serial'],
                'check_codes' => $check_codes,
            	'is_delete' => $row_item['is_delete'],
                'method' => 'add_mobile'
            );
            $this->add_to_sync_log($id,$id_row,'mobile','add_mobile',' send to server : - id : '.$row_item['id'].' - title : '.$row_item['title'].' - id_cat : '.$id_cat.' - id_main_cat : '.$row_item['id_main_cat'].' - active : '.$row_item['active'].' - main_cat : '.$row_item['main_cat'].' - date : '.$row_item['date'].' - bast_it : '.$row_item['bast_it'].' - tags : '.$row_item['tags'].' - specifications : '.$row_item['specifications'].' - cuts : '.$row_item['cuts'].' - price_cuts : '.$row_item['price_cuts'].' - description : '.$row_item['description'].' - name_accessories : '.$row_item['name_accessories'].' - id_accessories : '.$id_accessories.' - name_savers : '.$row_item['name_savers'].' - id_savers : '.$id_savers.' - serial_flag : '.$row_item['serial_flag'].' - price_dollars : '.$row_item['price_dollars'].' - location : '.$row_item['location'].' - enter_serial : '.$row_item['enter_serial'].' - check_codes : '.$check_codes.' - method : add_mobile');
            // print_r($array_data);
            $id_item = $this->CallAPI('POST','https://m/api/api_receive', $array_data);
            $this->add_to_sync_log($id,$id_row,'mobile','add_mobile',' return from server : - id_item : '.$id_item);
            // اذا كانت النتيجة 0 فهذا يعني ان الاضافة لم تتم ف ننهي عمل الدالة الى هنا
            // echo "<br>".$id_item."<br>";
            $id_item = intval($id_item);
            if($id_item==0)
            {
                $this->add_to_sync_log($id,$id_row,'mobile','add_mobile',' filed add  : - id_item : '.$id_item);
                $this->update_code_in_sync('error in add item id : '.$row_item['id'].' title : '.$row_item['title'],$id);
                return 0;
            }
            // echo $id_item;
            //  بعد اضافة المادة
            // نضيف الالوان الخاصة بالمادة
            // SELECT a.`id` as id, a.`color` as color, a.`code_color` as code_color, a.`id_item` as id_item, a.`img` as img, a.`date` as date ,b.code as code FROM `color_computer` a ,code_computer b where a.id_item=? and a.id=b.id_color;
            $this->add_to_sync_log($id,$id_row,'mobile','add_mobile',' start add color');
            $stmt_color=$this->db->prepare("SELECT a.`id` as id, a.`color` as color, a.`code_color` as code_color, a.`id_item` as id_item, a.`img` as img, a.`date` as date ,a.`is_delete` as is_delete,b.code as code FROM color a ,code b where a.id_item=? and a.id=b.id_color;");
            $stmt_color->execute(array($id_row));
            while ($row_color = $stmt_color->fetch(PDO::FETCH_ASSOC))
            {

                // نحول الصورة الى سترنك
//                 $path_img = FILES_h27.$row_color['img'];

//                 $type_img = pathinfo($path_img, PATHINFO_EXTENSION);
//                 // echo $path_img;
//                 $img_base64 =  base64_encode(file_get_contents($path_img));

                $path_img = ROOT_FILES_h27.$row_color['img'];
                $type_img = "false";
                // echo $path_img;
                $img_base64 =  "false";
                // echo "<br> before if path: ".$path_img;
                if (file_exists($path_img))
                {
                    // echo "<br> in if path: ".$path_img;
                    $type_img = pathinfo($path_img, PATHINFO_EXTENSION);
                    // echo $path_img;
                    $img_base64 =  base64_encode(file_get_contents($path_img));
                }
                $array_data = array(
                    'id' => $row_color['id'],
                    'color' => $row_color['color'],
                    'code_color' => $row_color['code_color'],
                    'id_item' => $id_item,
                    'img_name'=>$row_color['img'],
                    'img_type'=>$type_img,
                    'img' => $img_base64,
                    'date' => $row_color['date'],
                    'model' => 'mobile',
                    'code' => $row_color['code'],
                 	'is_delete' => $row_color['is_delete'],
                    'method' => 'add_color_item'

                );
                $this->add_to_sync_log($id,$id_row,'mobile','add_mobile',' send to server : - id : '.$row_color['id'].' - color : '.$row_color['color'].' - code_color : '.$row_color['code_color'].' - id_item : '.$id_item.' - img_type : '.$type_img.'  - date : '.$row_color['date'].' - model : mobile - code : '.$row_color['code'].' - method : add_color_item');
                // echo "<br>";
                // print_r($array_data);
                // print_r($array_data);
                $id_color= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
                $this->add_to_sync_log($id,$id_row,'mobile','add_mobile',' return from server : '.$id_color);
                // echo $id_color;
                // بعد اضافة الالوان
                // نضيف الاحجام الخاصة باللون
                $id_color = intval($id_color);
                if($id_color==0)
                {
                    $this->add_to_sync_log($id,$id_row,'mobile','add_mobile',' filed add color : - id_color : '.$id_color);
                    $this->update_code_in_sync('error in add color - id : '.$row_color['id'].' - color : '.$row_color['color'].' - code_color : '.$row_color['code_color'].' - id_item : '.$id_item.' - img_type : '.$type_img.'  - date : '.$row_color['date'].' - model : mobile - code : '.$row_color['code'],$id);
                    return 0;
                }
                $this->add_to_sync_log($id,$id_row,'mobile','add_mobile',' start add size');
                // mmm
                $stmt_code=$this->db->prepare("SELECT `id`, `code`, `size`, `id_color`, `date`, `serial`, `location`,`is_delete` FROM `code` where `is_delete` = 0 AND  `id_color`=?");
                $stmt_code->execute(array($row_color['id']));

                while ($row_code = $stmt_code->fetch(PDO::FETCH_ASSOC))
                {
                    $array_data = array(
                        'id' => $row_code['id'],
                        'code' => $row_code['code'],
                        'size' => $row_code['size'],
                        'id_color' => $id_color,
                        'date' => $row_code['date'],
                        'serial' => $row_code['serial'],
                        'location' => $row_code['location'],
                       'is_delete' => $row_code['is_delete'],
                        'model' => 'mobile',
                        'method' => 'add_code_item'
                    );
                    $this->add_to_sync_log($id,$id_row,'mobile','add_mobile',' send to server : - id : '.$row_code['id'].' - code : '.$row_code['code'].' - size : '.$row_code['size'].' - id_color : '.$id_color.' - date : '.$row_code['date'].' - serial : '.$row_code['serial'].' - location : '.$row_code['location'].' - model : mobile - method : add_code_item');
                    // print_r($array_data);
                    $id_code= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
                    $this->add_to_sync_log($id,$id_row,'mobile','add_mobile',' return from server : '.$id_code);
                    $id_code = intval($id_code);
                    if($id_code==0)
                    {
                        $this->add_to_sync_log($id,$id_row,'mobile','add_mobile',' filed add code : - id_code : '.$id_code);
                        $this->update_code_in_sync('error in add code - id : '.$row_code['id'].' - code : '.$row_code['code'].' - size : '.$row_code['size'].' - id_color : '.$id_color.' - date : '.$row_code['date'].' - serial : '.$row_code['serial'].' - location : '.$row_code['location'],$id);
                        return 0;
                    }
                    // echo $id_code;
                }
            }
            $this->add_to_sync_log($id,$id_row,'mobile','add_mobile',' end add mobile');
            $this->delete_rows('sync_schedule','id',$id);
            return 1;
        }
        else
        {
            $this->add_to_sync_log($id,$id_row,'mobile','add_mobile',' fild in FK ');
            $this->update_code_in_sync('error in FK',$id);
            return 0;
        }
    }
    /**
     * H27
     * اذا كانت تصنيف الالعاب غير مضافة ف نضيفها
     * واذا كانت غير موجةده ف نحدث عليها
     * @param int $id id of sync in table
     * @param int $id_cat id of category
     * @param string $model name of category
     */
    function add_class_games_send($id=0,$id_row)
    {
        $this->add_to_sync_log($id,$id_row,'class_games','add_class_games_send',' start add class games');


        $statm = $this->db->prepare("SELECT `id`, `title`, `active`,  `date` FROM `class_games` WHERE `id`=? ");
        $statm->execute(array($id_row));
        $row = $statm->fetch(PDO::FETCH_ASSOC);

        $array_data = array(
            'id'=>$row['id'],
            'title'=>$row['title'],
            'active'=>$row['active'],
            'date'=>$row['date'],
            'method'=>'add_class_games'
        );
        $this->add_to_sync_log($id,$id_row,'class_games','add_class_games_send',' send to server : - id : '.$row['id'].' - title : '.$row['title'].' - active : '.$row['active'].' - date : '.$row['date'].' - method : add_class_games');
        // print_r($array_data);
        // echo "<br>";
        $id_sync= $this->CallAPI('POST', "https://m/api/api_receive",$array_data);
        $this->add_to_sync_log($id,$id_row,'class_games','add_class_games_send',' return from server : '.$id_sync);
        // echo $id_sync."<br>";
        $id_sync = intval($id_sync);
        if($id_sync>0)
        {
            $this->add_to_sync_log($id,$id_row,'class_games','add_class_games_send',' end add class games');
            $this->update_id_sync($id_row,$id_sync,'class_games');
             $this->delete_rows('sync_schedule','id',$id);
        }
        else
        {
            $this->add_to_sync_log($id,$id_row,'class_games','add_class_games_send',' fild in FK ');
            $this->update_code_in_sync('error in add : - id : '.$row['id'].' - title : '.$row['title'].' - active : '.$row['active'].' - date : '.$row['date'],$id);
            return 0;
        }
        return $id_sync;

    }

    function add_games_send($id,$id_row)
    {
    	$this->create_is_delete('games');
    	$this->create_is_delete('color_games');
    	$this->create_is_delete('code_games');
        $this->add_to_sync_log($id,$id_row,'games','add_games_send',' start add games');
        // echo "add_games_send<br>";
        $check_FK =array("check_id_cat"=>false,"check_id_class_games"=>array());
        $stmt_item=$this->db->prepare("SELECT  `id`, `title`, `content`, `id_cat`, `id_main_cat`, `img`, `view`, `active`, `main_cat`, `date`, `bast_it`, `tags`, `class_games`, `specifications`, `cuts`, `price_cuts`, `description`, `serial_flag`, `price_dollars`, `location`, `enter_serial`, `change_price` , `is_delete` FROM `games` WHERE `id`=?  ");
        $stmt_item->execute(array($id_row));
        $row_item =$stmt_item->fetch(PDO::FETCH_ASSOC);
        // echo "<br>";
        // print_r($row_item);
        // echo "<br>";
        // معرف الفئة في الموقع
        $id_cat = $this->get_id_sync($row_item['id_cat'],'category_games');
        //  echo '<br> id_cat befor if'.$id_cat;
        // اذا كان صفر ف الفئة لم تتم مزامنتها
        if(strval($id_cat)=='0')
        {
            $id_cat = intval($this->add_category_send(0,$row_item['id_cat'],'games'));
            // echo '<br> id_cat after if'.$id_cat;
            if($id_cat>0)
            {
                $check_FK['check_id_cat']=true;
            }
        }
        elseif ($id_cat>0 || $id_cat=='no row')
        {
            $check_FK['check_id_cat']=true;
        }
        //category

        $array_class_games = explode(",",  $row_item['class_games']);
        // echo "<br>";
        // print_r($array_class_games);
        // echo "<br>";
        $class_games = " ";
        for($i = 0; $i < count($array_class_games); $i++){
            $check_FK['check_id_class_games'][$i]=false;
            $id_class_games =$this->get_id_sync($array_class_games[$i],'class_games');

            // اذا كان صفر ف الفئة لم تتم مزامنتها
            if(strval($id_class_games) =='0'){
                $id_class_games =intval($this->add_class_games_send(0,$array_class_games[$i]));
                if($id_class_games>0){
                    $check_FK['check_id_class_games'][$i]=true;
                }
            }elseif($id_class_games>0 || $id_class_games=='no row'){
                $check_FK['check_id_class_games'][$i]=true;
            }
            $class_games .= strval(intval($id_class_games)).',';
        }
        $class_games=substr($class_games,0,-1);

        $check_all_classes = true;
        for($i = 0; $i < count($check_FK['check_id_class_games']); $i++)
        {
            if($check_FK['check_id_class_games'][$i]==false)
            {
                $check_all_classes=false;
            }
        }

        // print_r($check_FK);
        if($check_FK['check_id_cat'] && $check_all_classes)
        {
            $stmt_codes=$this->db->prepare("SELECT code FROM `code_games` , `is_delete` where id_color in (select id from color_games where id_item =? )");
            $stmt_codes->execute(array($id_row));

            $check_codes="( ";
            while ($row_codes = $stmt_codes->fetch(PDO::FETCH_ASSOC))
            {
                $check_codes.='"'.$row_codes['code'].'",';
            }
            $check_codes=substr($check_codes,0,-1).')';
            $array_data = array(
                'id' => $row_item['id'],
                'title' => $row_item['title'],
                'content' => $row_item['content'],
                'id_cat' => $id_cat,
                'id_main_cat' => $row_item['id_main_cat'],
                'active' => $row_item['active'],
                'main_cat' => $row_item['main_cat'],
                'date' => $row_item['date'],
                'bast_it' => $row_item['bast_it'],
                'tags' => $row_item['tags'],
                'class_games' => $class_games,
                'specifications' => $row_item['specifications'],
                'cuts' => $row_item['cuts'],
                'price_cuts' => $row_item['price_cuts'],
                'description' => $row_item['description'],
                'serial_flag' => $row_item['serial_flag'],
                'price_dollars' => $row_item['price_dollars'],
                'location' => $row_item['location'],
                'enter_serial' => $row_item['enter_serial'],
                'change_price' => $row_item['change_price'],
              'is_delete' => $row_item['is_delete'],
                'check_codes' => $check_codes,
                'method' => 'add_games'
            );
            $this->add_to_sync_log($id,$id_row,'games','add_games_send',' send to server : - id '.$row_item['id'].' - title ' .$row_item['title'].' - id_cat '.$row_item['id_cat'].' - id_main_cat '.$row_item['id_main_cat'].' - active '.$row_item['active'].' - main_cat '.$row_item['main_cat'].' - date '.$row_item['date'].' - bast_it '.$row_item['bast_it'].' - tags '.$row_item['tags'].' - class_games '.$row_item['class_games'].' - specifications '.$row_item['specifications'].' - cuts '.$row_item['cuts'].' - price_cuts '.$row_item['price_cuts'].' - description '.$row_item['description'].' - serial_flag '.$row_item['serial_flag'].' - price_dollars '.$row_item['price_dollars'].' - location '.$row_item['location'].' - enter_serial '.$row_item['enter_serial'].' - change_price '.$row_item['change_price']. ' - check_codes '.$check_codes);
            // echo "<br> array_data";
            // print_r($array_data);
            $id_item = $this->CallAPI('POST','https://m/api/api_receive', $array_data);
            $this->add_to_sync_log($id,$id_row,'games','add_games_send',' return from server : - id '.$id_item);
            // echo "<br> id_item ".$id_item;
            // اذا كانت النتيجة 0 فهذا يعني ان الاضافة لم تتم ف ننهي عمل الدالة الى هنا
            $id_item = intval($id_item);
            if($id_item==0)
            {
                $this->add_to_sync_log($id,$id_row,'games','add_games_send',' field to add : - id '.$id_item);
                $this->update_code_in_sync('error in add item  - id '.$row_item['id'].' - title ' .$row_item['title'].' - id_cat '.$row_item['id_cat'].' - id_main_cat '.$row_item['id_main_cat'].' - active '.$row_item['active'].' - main_cat '.$row_item['main_cat'].' - date '.$row_item['date'].' - bast_it '.$row_item['bast_it'].' - tags '.$row_item['tags'].' - class_games '.$row_item['class_games'].' - specifications '.$row_item['specifications'].' - cuts '.$row_item['cuts'].' - price_cuts '.$row_item['price_cuts'].' - description '.$row_item['description'].' - serial_flag '.$row_item['serial_flag'].' - price_dollars '.$row_item['price_dollars'].' - location '.$row_item['location'].' - enter_serial '.$row_item['enter_serial'].' - change_price '.$row_item['change_price']. ' - check_codes '.$check_codes,$id);
                return 0;
            }
            //     // echo $id_item;
            //  بعد اضافة المادة
            // نضيف الالوان الخاصة بالمادة
            $this->add_to_sync_log($id,$id_row,'games','add_color_games_send',' start add color_games');
            $stmt_color=$this->db->prepare("SELECT a.`id` as id, a.`color` as color, a.`code_color` as code_color, a.`id_item` as id_item, a.`img` as img, a.`date` as date, a.`is_delete` as is_delete,b.code as code FROM color_games a ,code_games b where a.id_item=? and a.id=b.id_color;");
            $stmt_color->execute(array($id_row));
            // print_r($stmt_color);
            while ($row_color = $stmt_color->fetch(PDO::FETCH_ASSOC))
            {
                // نحول الصورة الى سترنك
                // $path_img = FILES_h27.$row_color['img'];
                // if (!file_exists($path_img))
                // {
                //     $path_img = url . "/public/ar/image/site/img_404.png";
                // }
                // $type_img = pathinfo($path_img, PATHINFO_EXTENSION);
                // // echo $path_img;
                // $img_base64 =  base64_encode(file_get_contents($path_img));

                $path_img = ROOT_FILES_h27.$row_color['img'];
                $type_img = "false";
                // echo $path_img;
                $img_base64 =  "false";
                // echo "<br> before if path: ".$path_img;
                if (file_exists($path_img))
                {
                    // echo "<br> in if path: ".$path_img;
                    $type_img = pathinfo($path_img, PATHINFO_EXTENSION);
                    // echo $path_img;
                    $img_base64 =  base64_encode(file_get_contents($path_img));
                }
                $array_data = array(
                    'id' => $row_color['id'],
                    'color' => $row_color['color'],
                    'code_color' => $row_color['code_color'],
                    'id_item' => $id_item,
                    'img_name'=>$row_color['img'],
                    'img_type'=>$type_img,
                    'img' => $img_base64,
                    'date' => $row_color['date'],
                    'code' => $row_color['code'],
                  'is_delete' => $row_color['is_delete'],
                	'model' => 'games',
                    'method' => 'add_color_item'
                );
                $this->add_to_sync_log($id,$id_row,'games','add_color_games_send',' send to server : - id '.$row_color['id'].' - color ' .$row_color['color'].' - code_color '.$row_color['code_color'].' - id_item '.$id_item.' - img '.$row_color['img'].' - date '.$row_color['date'].' - code '.$row_color['code']);
                // echo "<br> array data color item";
                // print_r($array_data);
                $id_color= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
                $this->add_to_sync_log($id,$id_row,'games','add_color_games_send',' return from server : - id '.$id_color);
                // echo $id_color;
                // بعد اضافة الالوان
                // نضيف الاحجام الخاصة باللون
                // echo '<br>'.$id_color.'<br>';
                $id_color= intval($id_color);
                if($id_color==0)
                {
                    $this->add_to_sync_log($id,$id_row,'games','add_color_games_send',' field to add : - id '.$id_color);
                    $this->update_code_in_sync('error in add color  - id '.$row_color['id'].' - color ' .$row_color['color'].' - code_color '.$row_color['code_color'].' - id_item '.$id_item.' - img '.$row_color['img'].' - date '.$row_color['date'].' - code '.$row_color['code'],$id);
                    return 0;
                }
                $this->add_to_sync_log($id,$id_row,'games','add_size_games_send',' start add size_games');
                $stmt_code=$this->db->prepare("SELECT `id`, `code`, `size`, `id_color`, `date`, `serial`, `location` , `is_delete` FROM `code_games` where id_color=?");
                $stmt_code->execute(array($row_color['id'],));
                while ($row_code = $stmt_code->fetch(PDO::FETCH_ASSOC))
                {
                    $array_data = array(
                        'id' => $row_code['id'],
                        'code' => $row_code['code'],
                        'size' => $row_code['size'],
                        'id_color' => $id_color,
                        'date' => $row_code['date'],
                        'serial' => $row_code['serial'],
                        'location' => $row_code['location'],
                    	 'is_delete' => $row_code['is_delete'],
                    	'model' => 'games',
                        'method' => 'add_code_item'

                    );
                    $this->add_to_sync_log($id,$id_row,'games','add_size_games_send',' send to server : - id '.$row_code['id'].' - code '.$row_code['code'].' - size '.$row_code['size'].' - id_color '.$id_color.' - date '.$row_code['date'].' - serial '.$row_code['serial'].' - location '.$row_code['location']);
                    // echo "code";
                    // print_r($array_data);
                    $id_code= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
                    $this->add_to_sync_log($id,$id_row,'games','add_size_games_send',' return from server : - id '.$id_code);
                    // echo '<br>'.$id_code.'<br>';
                    $id_code = intval($id_code);
                    if($id_code==0)
                    {
                        $this->add_to_sync_log($id,$id_row,'games','add_size_games_send',' field to add : - id '.$id_code);
                        $this->update_code_in_sync('error in add size  - id '.$row_code['id'].' - code '.$row_code['code'].' - size '.$row_code['size'].' - id_color '.$id_color.' - date '.$row_code['date'].' - serial '.$row_code['serial'].' - location '.$row_code['location'],$id);
                        return 0;
                    }
                    // return $id_code;
                }
            }
            // echo "<br> befor sync_schedule ";
            $this->add_to_sync_log($id,$id_row,'games','add_color_games_send',' end ');
            $this->delete_rows('sync_schedule','id',$id);
            return 1;
        }
    	else
        {
            $this->add_to_sync_log($id,$id_row,'games','add_color_games_send',' feild  in FK ');
            $this->update_code_in_sync('error in fk',$id);
            return 0;
        }
    }



    /*
     * 2022/4/30
     *  مزامنة فئات العروض
    */
    function add_offer_categories_send($id,$id_row,$table_name){
        $this->add_to_sync_log($id,$id_row,'offer_categories','add_offer_categories_send',' start ');
    	$this->create_is_delete($table_name);
        if($table_name =='offer_categories'){
            $stmt=$this->db->prepare("SELECT `id`, `title`,`active`,`date`,`is_delete`  FROM {$table_name} WHERE `id`=?  ");
            $stmt->execute(array($id_row));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $array_data = array(
                'id' => $row['id'],
                'title' => $row['title'],
                'active' => $row['active'],
                'date' => $row['date'],
            	'is_delete' => $row['is_delete'],
                'method' => 'offer_categories'
            );
            $this->add_to_sync_log($id,$id_row,'offer_categories','add_offer_categories_send',' send to server : - id '.$row['id'].' - title '.$row['title'].' - active '.$row['active'].' - date '.$row['date']);
            // print_r($array_data);
            $id_code= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
            $this->add_to_sync_log($id,$id_row,'offer_categories','add_offer_categories_send',' return from server : - id '.$id_code);
            $id_code = intval($id_code);
            // echo 'int' . $id_code ."<br>";
            if($id_code>0){
                $this->add_to_sync_log($id,$id_row,'offer_categories','add_offer_categories_send',' end ');
                $this->update_id_sync($id_row,$id_code,'offer_categories');
                $this->delete_rows('sync_schedule','id',$id);
            }

            return $id_code;
        }else{
            $this->add_to_sync_log($id,$id_row,'offer_categories','add_offer_categories_send',' feild  in FK ');
            return 0;
        }


    }



	/*
	*  NAI
     *  مزامنة حذف فئات العروض
	* 2022/04  create
	* 2022/05/29 last update
	*/
    function delete_offer_categories_send($id,$id_row,$table_name){
    	$this->add_to_sync_log($id,$id_row,'offer_categories','delete_offer_categories',' start send offer_categories');
     	$this->create_is_delete($table_name);

		$is_sync =array("check_is_sync"=>false);
		$id_cat = $this->get_id_sync($id_row,'offer_categories');
   		if(strval($id_cat)=='0'){
        	$this->add_to_sync_log($id,$id_row,'offer_categories','delete_offer_categories',' الفئة غير متزامنة');
        	$id_cat = intval($this->add_category_send(0,$id_row,$table_name));


        	if($id_cat>0)
            {
                $is_sync['check_is_sync']=true;
            	$this->add_to_sync_log($id,$id_row,'offer_categories','delete_offer_categories','id_sync'.$id_cat);
            }
        }
        elseif ($id_cat>0 || $id_cat=='no row')
        {
            $is_sync['check_is_sync']=true;
        }

		if($is_sync['check_is_sync'] || $id_cat > 0){

        	$array_data = array(
        		'id' => $id_cat,
        		'method' => 'delete_offer_categories'
        	);
        	  $this->add_to_sync_log($id,$id_row,'offer_categories','delete_offer_categories_send',' send to server : - id '.$id_cat);
        	// print_r($array_data);
        	$id_code= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
       		// echo  $id_code;
        	 $this->add_to_sync_log($id,$id_row,'offer_categories','delete_offer_categories_send',' return from server : - id '.$id_code);
        	if(strval($id_code)=='0'){
            	return 0;
            	 $this->add_to_sync_log($id,$id_row,'offer_categories','delete_offer_categories_send',' error'.$id_code);
        	}else{
            	 $this->add_to_sync_log($id,$id_row,'offer_categories','delete_offer_categories_send',' end ');
            	$this->delete_rows('sync_schedule','id',$id);
        	}
        	echo $id_code;
    	}

    }

    /*
     * NAI
     *  مزامنة  العروض
     * 2022/4/30 create
    */
    function add_offers_send($id,$id_row,$table_name){
     $this->create_is_delete($table_name);

        $this->add_to_sync_log($id,$id_row,$table_name,'add_offers_send',' start ');
    	$this->create_is_delete($table_name);
        if($table_name =='offers'){
            $check_FK =array("check_id_cat"=>array(),"check_id_offer_cat"=>array());
            $stmt=$this->db->prepare("SELECT `id`, `title`,`content`,`description`,`total_price`,`rate`,`img`,`id_offer_categories`,`ids_cat`,`model`,`imgid`,`range_price`,`fromdate_normal`,`fromdate`,`todate_normal`,`todate`,`active`,`delete`,`lang`,`date`,`note`,`range_price_user`,`note2`,`countdown` , `is_delete`  FROM {$table_name} WHERE `id`=?  ");
            $stmt->execute(array($id_row));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //تحويل الصورة الى سترمك
            $path_img = ROOT_FILES_h27.$row['img'];
            $type_img = "false";
            $img_base64 =  "false";
            if (file_exists($path_img))
            {
                $type_img = pathinfo($path_img, PATHINFO_EXTENSION);
                $img_base64 =  base64_encode(file_get_contents($path_img));
            }
            //category model
            $array_id_cat = explode(",",  $row['ids_cat']);
            $array_name_model = explode(",",  $row['model']);
            $ids_cat = array();
            for($i = 0; $i < count($array_id_cat); $i++){
                $check_FK['check_id_cat'][$i]=false;
                $id_cat =$this->get_id_sync($array_id_cat[$i],'category_'.$array_name_model[$i].'');
                //   اذا كان صفر ف الفئة لم تتم مزامنتها
                if(strval($id_cat) =='0'){
                    if($row['model'] == 'savers'){
                        $id_cat =intval($this->add_category_savers_send(0,$array_id_cat[$i]));
                    }else{
                        $id_cat =intval($this->add_category_send(0,$array_id_cat[$i],$array_name_model[$i]));
                    }

                    if($id_cat>0){
                        $check_FK['check_id_cat'][$i]=true;
                    }
                }elseif ($id_cat>0 || $id_cat=='no row'){
                	$check_FK['check_id_cat'][$i]=true;
                }
                $ids_cat[]= $id_cat;

            }
            $array_cat  = $check_FK['check_id_cat'];
            $check_all_id_cat = true;
            if(!empty(array_search(false,$array_cat,true))){
                $check_all_id_cat = false;
            }
            $id_cat = implode(" ,",$ids_cat);


        	//check id offer categories
            $array_offer_categories = explode(",",  $row['id_offer_categories']);
            $ids_offer_cat = array();
            for($i = 0; $i < count($array_offer_categories); $i++){
                $check_FK['check_id_offer_cat'][$i]=false;
                $id_offer_cat = $this->get_id_sync($array_offer_categories[$i],'offer_categories');
                //   اذا كان صفر ف الفئة لم تتم مزامنتها
                if(strval($id_offer_cat)=='0'){
                    $id_offer_cat = intval($this->add_offer_categories_send(0,$array_offer_categories[$i],'offer_categories'));
                    if($id_offer_cat>0){
                        $check_FK['check_id_offer_cat'][$i]=true;
                    }
                }
                elseif ($id_offer_cat>0 || $id_offer_cat=='no row'){
                    $check_FK['check_id_offer_cat'][$i]=true;
                }
                $ids_offer_cat[]= $id_offer_cat;
            }
            $array_offer_cat  = $check_FK['check_id_offer_cat'];
            $check_all_id_offer_cat = true;
            if(!empty(array_search(false,$array_offer_cat,true))){
               $check_all_id_offer_cat = false;
            }
            $id_offer_cat = implode(" ,",$ids_offer_cat);


            if($check_all_id_cat && $check_all_id_offer_cat)
            {
                $array_data = array(
                    'id' => $row['id'],
                    'title' => $row['title'],
                    'content' => $row['content'],
                    'description' => $row['description'],
                    'total_price' => $row['total_price'],
                    'rate' => $row['rate'],
                    'img' => $img_base64,
                    'img_name'=>$row['img'],
                    'img_type'=>$type_img,
                    'id_offer_categories' => $id_offer_cat,
                    'ids_cat' =>  $id_cat,
                    'model' => $row['model'],
                    'imgid' => $row['imgid'],
                    'range_price' => $row['range_price'],
                    'fromdate_normal' => $row['fromdate_normal'],
                    'fromdate' => $row['fromdate'],
                    'todate_normal' => $row['todate_normal'],
                    'todate' => $row['todate'],
                    'active' => $row['active'],
                    'delete' => $row['delete'],
                    'lang' => $row['lang'],
                    'date' => $row['date'],
                    'note' => $row['note'],
                    'range_price_user' => $row['range_price_user'],
                    'note2' => $row['note2'],
                    'countdown' => $row['countdown'],
                 	'is_delete' => $row['is_delete'],
                    'method' => 'add_offers'
                );
                $this->add_to_sync_log($id,$id_row,'offers','add_offers_send',' send to server : - id '.$row['id'].' title '.$row['title'].' content '.$row['content'].' description '.$row['description'].' total_price '.$row['total_price'].' rate '.$row['rate'].' img '.$row['img'].' id_offer_categories '.$row['id_offer_categories'].' ids_cat '.$row['ids_cat'].' model '.$row['model'].' imgid '.$row['imgid'].' range_price '.$row['range_price'].' fromdate_normal '.$row['fromdate_normal'].' fromdate '.$row['fromdate'].' todate_normal '.$row['todate_normal'].' todate '.$row['todate'].' active '.$row['active'].' delete '.$row['delete'].' lang '.$row['lang'].' date '.$row['date'].' note '.$row['note'].' range_price_user '.$row['range_price_user'].' note2 '.$row['note2'].' countdown '.$row['countdown']);
                $id_code= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
                $this->add_to_sync_log($id,$id_row,'offers','add_offers_send','return from server : - id '.$id_code);
                $id_code=intval($id_code);
                if($id_code>0 ){
                    $this->add_to_sync_log($id,$id_row,'offers','add_offers_send',' end');
                    $this->update_id_sync($id_row,$id_code,'offers');
                    $this->delete_rows('sync_schedule','id',$id);
                }
                return $id_code;
            }
            else{
                $this->add_to_sync_log($id,$id_row,'offers','add_offers_send',' error in FK');
                return 0;
            }
        }else{
            $this->add_to_sync_log($id,$id_row,'offers','add_offers_send',' error in table name');
            return 0;
        }



    }


	/*
	*  NAI
	*  مزامنة حذف  العروض
	*  2022/05/31 last update
	*/
	function delete_offers_send($id,$id_row,$table_name){
    	$this->add_to_sync_log($id,$id_row,'offers','delete_offers',' start send offers');
     	$this->create_is_delete($table_name);

  		$id_offer = $this->get_id_sync($id_row,$table_name);
   	 	//   اذا كان صفر ف الفئة لم تتم مزامنتها
    	if($id_offer == 0){
        	$this->add_to_sync_log($id,$id_row,'offers','delete_offers',' العرض غير متزامن');
        	$id_offer = intval($this->add_offers_send(0,$id_row,$table_name));
        	// echo  $id_offer ;
        	if($id_offer >0){

                  $stmt=$this->db->prepare("SELECT `id`  FROM `offers_item` WHERE  `id_offer`=?   ");
        		  $stmt->execute(array($id_row));
                  $row_offers = $stmt->fetch(PDO::FETCH_ASSOC);

            	 $id_offer_item = intval($this->add_offers_item_send(0,$row_offers['id'],'offers_item'));
            	 echo $id_offer_item;
            		if($id_offer_item >0){
                    	$this->add_to_sync_log($id,$id_row,'offers','delete_offers','offer and items finish sync');
                    	$this->delete_rows('sync_schedule','id',$id);
                	}else{
                		return 0;
                    	 $this->add_to_sync_log($id,$id_row,'offers','delete_offers',' error in add offer and items');
                	}
        	}else{
            	return 0;
         }

        // echo  $id_offer;

    	}else{
    		$stmt=$this->db->prepare("SELECT `active`  FROM `offers` WHERE `id`=?  ");
      		$stmt->execute(array($id_row));
       		$row_offers = $stmt->fetch(PDO::FETCH_ASSOC);
        	$array_data = array(
            	'id' => $id_offer,
        		'active' => $row_offers['active'],
            	'method' => 'delete_offers'
        	);
         	$this->add_to_sync_log($id,$id_row,'offers','delete_offers',' send to server : - id '.$id_offer.' active '.$row_offers['active']);
        	// print_r($array_data);
        	$id_code= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
        	$this->add_to_sync_log($id,$id_row,'offers','delete_offers','return from server : - id '.$id_code);
        	$id_code = intval($id_code);
        	if($id_code>0)
        	{
            	$this->add_to_sync_log($id,$id_row,'offers','delete_offers_send',' end ');
            	$this->delete_rows('sync_schedule','id',$id);
        	}else{
            	$this->add_to_sync_log($id,$id_row,'offers','delete_offers_send',' error'.$id_code);
            	return 0;
        	}
      		echo $id_code;
    	}

	}



    /*
     *  مزامنة منتجات العروض
    */
    function add_offers_item_send($id,$id_row,$table_name){
     $this->create_is_delete($table_name);

        $this->add_to_sync_log($id,$id_row,$table_name,'add_offers_item_send',' start');
    	$this->create_is_delete($table_name);
        if($table_name =='offers_item'){
            $check_FK =array("check_ids_cat"=>false,"check_id_offer"=>false);
            $stmt=$this->db->prepare("SELECT `id`, `model`,`title`,`code`,`id_offer`, `id_item`,`ids_cat`,`img`,`imgid`,`active`,`lang`,`date`,`color`,`code_color`,`size`,`latiniin_or_code`,`cover_type_offer` , `is_delete` FROM {$table_name} WHERE `id`=?  ");
            $stmt->execute(array($id_row));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // نحول الصورة الى سترنك
            $path_img = ROOT_FILES_h27.$row['img'];
            $type_img = "false";
            $img_base64 =  "false";
            if (file_exists($path_img)) {
                $type_img = pathinfo($path_img, PATHINFO_EXTENSION);
                $img_base64 =  base64_encode(file_get_contents($path_img));
            }

            //category
            $ids_cat = $this->get_id_sync($row['ids_cat'],'category_'.$row['model'].'');
            //   اذا كان صفر ف الفئة لم تتم مزامنتها
            if(strval($ids_cat)=='0'){
                if($row['model'] == 'savers'){
                    $ids_cat = intval($this->add_category_savers_send(0,$row['ids_cat'],$row['model']));
                }
                else{
                    $ids_cat = intval($this->add_category_send(0,$row['ids_cat'],$row['model']));
                }
                if($ids_cat>0)
                {
                    $check_FK['check_ids_cat']=true;
                }
            }
            elseif ($ids_cat>0 || $ids_cat=='no row')
            {
                $check_FK['check_ids_cat']=true;
            }

            //offers
            $id_offer_cat = $this->get_id_sync($row['id_offer'],'offers');

            //   اذا كان صفر ف الفئة لم تتم مزامنتها
            if(strval($id_offer_cat)=='0'){
                $id_offer_cat = intval($this->add_offers_send(0,$row['id_offer'],'offers'));
                if($id_offer_cat>0)
                {
                    $check_FK['check_id_offer']=true;
                }
            }
            elseif ($id_offer_cat>0 || $id_offer_cat=='no row')
            {
                $check_FK['check_id_offer']=true;
            }

            if($check_FK['check_ids_cat'] && $check_FK['check_id_offer'])
            {
                $array_data = array(
                    'id' => $row['id'],
                    'model' => $row['model'],
                    'title' => $row['title'],
                    'code' => $row['code'],
                    'id_offer' => $id_offer_cat,
                    'id_item' => $row['id_item'],
                    'ids_cat' => $ids_cat,
                    'img' => $img_base64,
                    'imgid' => $row['imgid'],
                    'img_name'=>$row['img'],
                    'img_type'=>$type_img,
                    'active' => $row['active'],
                    'lang' => $row['lang'],
                    'date' => $row['date'],
                    'color' => $row['color'],
                    'code_color' => $row['code_color'],
                    'size' => $row['size'],
                    'latiniin_or_code' => $row['latiniin_or_code'],
                    'cover_type_offer' => $row['cover_type_offer'],
                	'is_delete' => $row['is_delete'],
                    'method' => 'add_offers_item'
                );
                $this->add_to_sync_log($id,$id_row,$table_name,'add_offers_item_send',' send to server : - id '.$row['id'].' - model '.$row['model'].' - title '.$row['title'].' - code '.$row['code'].' - id_offer '.$id_offer_cat.' - id_item '.$row['id_item'].' - ids_cat '.$ids_cat.'  - imgid '.$row['imgid'].' - active '.$row['active'].' - lang '.$row['lang'].' - date '.$row['date'].' - color '.$row['color'].' - code_color '.$row['code_color'].' - size '.$row['size'].' - latiniin_or_code '.$row['latiniin_or_code'].' - cover_type_offer '.$row['cover_type_offer']);

                $id_code= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
                $this->add_to_sync_log($id,$id_row,$table_name,'add_offers_item_send',' response from server : - id '.$id_code);
                // echo $id_code;
                $id_code = intval($id_code);
                if($id_code>0){
                    $this->add_to_sync_log($id,$id_row,$table_name,'add_offers_item_send',' end');
                    $this->update_id_sync($id_row,$id_code,'offers_item');
                    $this->delete_rows('sync_schedule','id',$id);
                }
                return $id_code;
            }
        }else{
            $this->add_to_sync_log($id,$id_row,$table_name,'add_offers_item_send',' error in table name');
            return 0;
        }

    }




	/*
	*  NAI
	*   حذف منتجات العرض
	*  2022/05/08 create
    *  2022/05/31 last update
	*/
    function delete_offers_item_send($id,$id_row,$table_name){
    	$this->add_to_sync_log($id,$id_row,'offers_item','delete_offers_item',' start ');
     	$this->create_is_delete($table_name);

   		$id_offer_item = $this->get_id_sync($id_row,$table_name);
		//   اذا كان صفر ف الفئة لم تتم مزامنتها
		if($id_offer_item == 0){
        	 $this->add_to_sync_log($id,$id_row,$table_name,'add_offers_item_send',' item not sync');
			$id_offer_item = intval($this->add_offers_item_send(0,$id_row,$table_name));
			echo $id_offer_item;
			if($id_offer_item >0){
            	 $this->add_to_sync_log($id,$id_row,$table_name,'add_offers_item_send',' item is sync');
				$this->delete_rows('sync_schedule','id',$id);
			}else{
                $this->add_to_sync_log($id,$id_row,'offers_item','delete_offers_item_send','error in sync');

				return 0;
			}
		}
		else
		{
			$array_data = array(
				'id' => $id_offer_item,
				'method' => 'delete_offers_item'
			);
        	$this->add_to_sync_log($id,$id_row,'offers_item','delete_offers_item',' send to server : - id '.$id_offer_item);
			// print_r($array_data);
			$id_code= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
         	$this->add_to_sync_log($id,$id_row,'offers_item','delete_offers_item',' response from server : - id '.$id_code);
			$id_code = intval($id_code);
			if($id_code>0)
			{
            	$this->add_to_sync_log($id,$id_row,'offers_item','delete_offers_item',' end ');
				$this->delete_rows('sync_schedule','id',$id);
			}else{
              $this->add_to_sync_log($id,$id_row,'offers_item','delete_offers_item_send',' error : - id '.$id_code);
				return 0;
			}
			echo $id_code;
		}

  }








	/*
*  NAI
*  دالة مزامنة  حذف بطاقات المادة من الموبايل و حاسبات و الالعاب
*  2022/05/11 - 13:47 create
*  2022/05/30 last update
*/
function delete_item_send($id,$id_row,$table_name,$code){
 		$this->create_is_delete($table_name);
		$this->add_to_sync_log($id,$id_row,$table_name,'delete_item',' start ');
        $array_data = array(
            'code' => $code,
        	'model' => $table_name,
            'method' => 'delete_item'
        );
        // print_r($array_data);
		$this->add_to_sync_log($id,$id_row,$table_name,'delete_item',' send to server : - code '.$code. 'model'.$table_name);
        $id_code = $this->CallAPI('POST','https://m/api/api_receive', $array_data);
		$this->add_to_sync_log($id,$id_row,$table_name,'delete_item',' response from server : - id '.$id_code);

 		// echo  $id_code;
		if(intval($id_code) != 404){
			//  is_delete  اذا المادة موجودة يحدث قيمة
        	$id_code = intval($id_code);
          	// echo $id_code;
          	if($id_code>0){
            	$this->add_to_sync_log($id,$id_row,$table_name,'delete_item',' end ');
            	$this->delete_rows('sync_schedule','id',$id);
          	}else{
             	$this->add_to_sync_log($id,$id_row,$table_name,'delete_item','error in id'.$id_code);
         	   	return 0;
        	}
        }else{
        $this->add_to_sync_log($id,$id_row,$table_name,'delete_item',' المادة غير موجوده ');
		//  اذا ماموجوده يضيفها
        if($table_name == 'mobile'){
            	$id_item = intval($this->add_mobile_send($id,$id_row));
        	}
        	if($table_name == 'games' || $table_name == 'computer'){

            	$id_item = intval($this->add_item_send($id,$id_row,$table_name));
        	}

          if($id_item>0){
                $this->add_to_sync_log($id,$id_row,$table_name,'delete_item','  تم اضافة المادة  ');
            	$this->delete_rows('sync_schedule','id',$id);
          }else{
            $this->add_to_sync_log($id,$id_row,$table_name,'delete_item','error in id'.$id_item);
            return 0;
         }


        }

}

/*
* NAI
* delete color and code from mobile, computer , games
* 2022/05/30 last update
* الدالة تشتغل ولكن حاليا منحتاجها لان عند حذف اللون او الكود تعاد اضافة المادة
*/
function delete_color_code_send($id,$id_row,$table_name,$code){
        $array_data = array(
            'id' => $id_row,
            'code' => $code,
        	'model' => $table_name,
            'method' => 'delete_color_code'
        );
        // print_r($array_data);
        $id_code= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
 		// echo $id_code;
        $id_code = intval($id_code);
        // echo $id_code;
        if($id_code>0)
        {
            $this->delete_rows('sync_schedule','id',$id);
        }else{
            return 0;
        }
                // echo $id_code;
}
/*
* NAI
* delete code from mobile, computer , games
* 2022/05/08 create
* 2022/05/30 last update
*/
function delete_code_send($id,$id_row,$table_name,$code){

        $array_data = array(
            'id' => $id_row,
            'code' => $code,
        	'model' => $table_name,
            'method' => 'delete_code'
        );
    // print_r($array_data);
        $id_code= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
 		// echo $id_code;
        $id_code = intval($id_code);
        // echo $id_code;
        if($id_code>0)
        {
            $this->delete_rows('sync_schedule','id',$id);
        }else{
            return 0;
        }
                // echo $id_code;
}


/*
* NAI
* delete code from mobile, computer , games
* 2022/05/08 create
* 2022/06/02 last update
*/
function delete_savers_send($id,$id_row,$table_name,$code){
 			$this->create_is_delete($table_name);
			$this->add_to_sync_log($id,$id_row,$table_name,'delete_savers',' start ');
             $array_data = array(
            'code' => $code,
            'method' => 'delete_savers'
        );
         // print_r($array_data);
		$this->add_to_sync_log($id,$id_row,$table_name,'delete_savers',' send to server : - code '.$code);
        $id_code= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
 		// echo $id_code;
		$this->add_to_sync_log($id,$id_row,$table_name,'delete_savers',' response from server : - id '.$id_code);
		$id_code = intval($id_code);
		if($id_code != 404){

        	// echo $id_code;
        	if($id_code>0)
        	{
            	 $this->add_to_sync_log($id,$id_row,$table_name,'delete_savers',' end ');
           	 	 $this->delete_rows('sync_schedule','id',$id);
        	}else{
             $this->add_to_sync_log($id,$id_row,$table_name,'delete_savers','error in id'.$id_code);
            	return 0;
       	 	}
        }else{
		//  اذا ماموجوده يضيفها
        	$this->add_to_sync_log($id,$id_row,$table_name,'delete_savers',' المادة غير موجوده ');
            $id_item = intval($this->add_savers_send(0,$id_row));
          	// echo $id_item;
          if($id_item>0){
          		$this->add_to_sync_log($id,$id_row,$table_name,'delete_savers','  تم اضافة المادة  ');
            	$this->delete_rows('sync_schedule','id',$id);
          }else{
           		$this->add_to_sync_log($id,$id_row,$table_name,'delete_savers','error in id'.$id_item);
            return 0;
         }


        }
}




/*
* NAI
* حذف بطاقة مادة من جدول الاكسسوار
* 2022/05/31 last update
*/
// add_accessories_send($id=0,$id_row)
function delete_item_accessories_send($id,$id_row,$table_name,$code){
 		$this->create_is_delete($table_name);
		$this->add_to_sync_log($id,$id_row,$table_name,'delete_item_accessories',' start ');
        $array_data = array(
            'code' => $code,
            'method' => 'delete_item_accessories'
        );
        // print_r($array_data);
		$this->add_to_sync_log($id,$id_row,$table_name,'delete_item_accessories',' send to server : - code '.$code);
        $id_code= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
		$this->add_to_sync_log($id,$id_row,$table_name,'delete_item_accessories',' response from server : - id '.$id_code);
		if($id_code != 404){
			//  is_delete  اذا المادة موجودة يحدث قيمة
        	// $id_code = intval($id_code);
          	// echo $id_code;
          	if($id_code>0){
            	$this->add_to_sync_log($id,$id_row,$table_name,'delete_item_accessories_send',' end ');
            	$this->delete_rows('sync_schedule','id',$id);
          	}else{
            	 $this->add_to_sync_log($id,$id_row,$table_name,'delete_item','error in id'.$id_code);
         	   	return 0;
        	}
        }else{
			//  اذا ماموجوده يضيفها
       		$this->add_to_sync_log($id,$id_row,$table_name,'delete_item_accessories',' المادة غير موجوده ');
        	$id_item = intval($this->add_accessories_send(0,$id_row));
          	if($id_item>0){
            	$this->add_to_sync_log($id,$id_row,$table_name,'delete_item_accessories','  تم اضافة المادة  ');
            	$this->delete_rows('sync_schedule','id',$id);
          	}else{
             	$this->add_to_sync_log($id,$id_row,$table_name,'delete_item_accessories','error in id'.$id_item);
            	return 0;
         	}


        }

}


/*
* NAI
* delete  from category and product from mobile , computer, games , accessories
* 2022/06/02 create
*/
function delete_cate_send($id,$id_row,$table_name){
 	$this->create_is_delete($table_name);
	$this->add_to_sync_log($id,$id_row,$table_name,'delete_cate',' start ');
  	$is_sync =array("check_is_sync"=>false);
	$id_cat = $this->get_id_sync($id_row,'category_'.$table_name.'');
   if(strval($id_cat)=='0'){
   		   $this->add_to_sync_log($id,$id_row,$table_name,'delete_cate',' الفئة غير متزامنة ');
           $id_cat = intval($this->add_category_send(0,$id_row,$table_name));

            if($id_cat>0)
            {
                $is_sync['check_is_sync']=true;
            }
        }
        elseif ($id_cat>0 || $id_cat=='no row')
        {
            $is_sync['check_is_sync']=true;
        }

	if($is_sync['check_is_sync'] || $id_cat > 0){
     	 $this->add_to_sync_log($id,$id_row,$table_name,'delete_cate',' تمت مزامنة الفئة ');
         $array_data = array(
         	'id' => $id_cat,
        	'model'=> $table_name,
            'method' => 'delete_category'
    	);

    	// print_r($array_data);
    	$this->add_to_sync_log($id,$id_row,$table_name,'delete_item',' send to server : - id '.$id_cat. 'model'.$table_name);
        $id_code= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
    	// echo $id_code;
    	$this->add_to_sync_log($id,$id_row,$table_name,'delete_cate',' response from server : - id '.$id_code);
        $id_code = intval($id_code);

        if($id_code>0)
        {
        	$this->add_to_sync_log($id,$id_row,$table_name,'delete_cate_send',' end ');
            $this->delete_rows('sync_schedule','id',$id);
        }else{
        	$this->add_to_sync_log($id,$id_row,$table_name,'delete_cate_send','error in id'.$id_code);
            return 0;
        }
    }
}

//////////


/*
* NAI
* تحذف اسم الجهاز والحافظات الخاصة بالجهاز
* 2022/06/03 create
*/
function delete_type_device_send($id,$id_row,$table_name){
 	$this->create_is_delete($table_name);
	$this->add_to_sync_log($id,$id_row,$table_name,'delete_type_device',' send ');
	$is_sync =array("check_is_sync"=>false);
	$id_sync = $this->get_id_sync($id_row,'type_device');
	  // echo $id_sync;
   	if(strval($id_sync)=='0'){
    	  // echo $id_sync;
		  $this->add_to_sync_log($id,$id_row,$table_name,'delete_type_device','  غير متزامنة ');
          $id_sync = intval($this->add_type_device_send(0,$id_row));

            if($id_sync>0)
            {
                $is_sync['check_is_sync']=true;
            }
        }
        elseif ($id_sync>0 || $id_sync=='no row')
        {
            $is_sync['check_is_sync']=true;
        }

	if($is_sync['check_is_sync'] || $id_sync > 0){

		$this->add_to_sync_log($id,$id_row,$table_name,'delete_type_device','  تمت المزامنة ');
         $array_data = array(
         	'id' => $id_sync,
            'method' => 'delete_type_device'
    	);

        // print_r($array_data);
    	$this->add_to_sync_log($id,$id_row,$table_name,'delete_type_device',' send to server : - id '.$id_sync);
        $id_code= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
    	$this->add_to_sync_log($id,$id_row,$table_name,'delete_type_device',' response from server : - id '.$id_code);
        $id_code = intval($id_code);
        // echo $id_code;
        if($id_code>0)
        {
        	$this->add_to_sync_log($id,$id_row,$table_name,'delete_type_device_send',' end ');
            $this->delete_rows('sync_schedule','id',$id);
        }else{
        	$this->add_to_sync_log($id,$id_row,$table_name,'delete_type_device_send','error in id'.$id_code);
            return 0;
        }
    }
}











/*
* NAI
* تحذف السلسلة و اسم الجهاز والحافظات الخاصة بالجهاز
* 2022/06/03 create
*/
function delete_name_device_send($id,$id_row,$table_name){
 	$this->create_is_delete($table_name);
	$this->add_to_sync_log($id,$id_row,$table_name,'delete_name_device',' send ');

	$is_sync =array("check_is_sync"=>false);
	$id_sync = $this->get_id_sync($id_row,'name_device');
	  // echo $id_sync;
   if(strval($id_sync)=='0'){
   		  $this->add_to_sync_log($id,$id_row,$table_name,'delete_name_device','  غير متزامنة ');
          $id_sync = intval($this->add_name_device_send(0,$id_row));

            if($id_sync>0)
            {
                $is_sync['check_is_sync']=true;
            }
        }
        elseif ($id_sync>0 || $id_sync=='no row')
        {
            $is_sync['check_is_sync']=true;
        }

	if($is_sync['check_is_sync'] || $id_sync > 0)
     {
    	  $this->add_to_sync_log($id,$id_row,$table_name,'delete_name_device','  تمت المزامنة ');
         $array_data = array(
         	'id' => $id_sync,
            'method' => 'delete_name_device'
    	);

        // print_r($array_data);
    	$this->add_to_sync_log($id,$id_row,$table_name,'delete_name_device',' send to server : - id '.$id_sync);
        $id_code= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
        $this->add_to_sync_log($id,$id_row,$table_name,'delete_name_device',' response from server : - id '.$id_code);
        $id_code = intval($id_code);
        // echo $id_code;
        if($id_code>0)
        {
        	$this->add_to_sync_log($id,$id_row,$table_name,'delete_name_device_send',' end ');
            $this->delete_rows('sync_schedule','id',$id);
        }else{
        $this->add_to_sync_log($id,$id_row,$table_name,'delete_name_device_send','error in id'.$id_code);
            return 0;
        }
    }
}


/*
* NAI
* تحذف الماركة و  السلسلة و اسم الجهاز والحافظات الخاصة بالجهاز
* 2022/06/03 create
*/
function delete_category_savers_send($id,$id_row,$table_name){

 	$this->create_is_delete($table_name);
	$this->add_to_sync_log($id,$id_row,$table_name,'delete_category_savers',' send ');
	$is_sync =array("check_is_sync"=>false);
	$id_sync = $this->get_id_sync($id_row,'category_savers');

   if(strval($id_sync)=='0'){
     	  $this->add_to_sync_log($id,$id_row,$table_name,'delete_category_savers','  غير متزامنة ');
          $id_sync = intval($this->add_category_savers_send(0,$id_row));

            if($id_sync>0)
            {
                $is_sync['check_is_sync']=true;
            }
        }
        elseif ($id_sync>0 || $id_sync=='no row')
        {
            $is_sync['check_is_sync']=true;
        }

	if($is_sync['check_is_sync'] || $id_sync>0)
     {
    	 $this->add_to_sync_log($id,$id_row,$table_name,'delete_category_savers','  تمت المزامنة ');
         $array_data = array(
         	'id' => $id_sync,
            'method' => 'delete_category_savers'
    	);

        // print_r($array_data);
     	$this->add_to_sync_log($id,$id_row,$table_name,'delete_category_savers',' send to server : - id '.$id_sync);
        $id_code= $this->CallAPI('POST','https://m/api/api_receive', $array_data);
        // echo $id_code;
    	 $this->add_to_sync_log($id,$id_row,$table_name,'delete_category_savers',' response from server : - id '.$id_code);
        $id_code = intval($id_code);
        // echo $id_code;
        if($id_code>0)
        {
        	$this->add_to_sync_log($id,$id_row,$table_name,'delete_category_savers_send',' end ');
            $this->delete_rows('sync_schedule','id',$id);
        }else{
        $this->add_to_sync_log($id,$id_row,$table_name,'delete_category_savers_send','error in id'.$id_code);
            return 0;
        }
    }



}

    //////////////////
    ////////////////////////////////////////////
    /////////////////////////////////////////////////////

	// تم  التعديل بحيث يعيد اللون هذه المره
    function tamayaz_locations($id)
    {


        $stmt=$this->db->prepare("SELECT location,color FROM tamayaz_locations WHERE `location`=?  ");
        $stmt->execute(array(trim($id)));

        if ($stmt->rowCount() >0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $color = $row['color'];
            return "<span style='color:{$color};font-weight: bold'>{$id}</span>";
        }else
        {
            return $id;
        }

    }
	/**
     * H27
     * return color from tamayaz_locations by location
     * @param $id
     * @return string
     */
    function tamayaz_locations_color($location)
    {
        $stmt=$this->db->prepare("SELECT color FROM tamayaz_locations WHERE `location`=?  ");
        $stmt->execute(array(trim($location)));
        if ($stmt->rowCount() >0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['color'];
        }else
        {
            return '#000000';
        }

    }


    function tamayaz_locations_bool($id)
    {


        $stmt=$this->db->prepare("SELECT location FROM tamayaz_locations WHERE `location`=?  ");
        $stmt->execute(array(trim($id)));
        if ($stmt->rowCount() >0)
        {
            return true;
        }

    }




function set_quantity_order($table,$id_item,$code,$number)
{


    $locationCol='location';
    $table_item=$table;

    if ($table== 'mobile') {
        $excel = 'excel';
    }else   if ($table== 'product_savers') {
        $excel = 'excel_savers';
        $table = 'savers';
        $locationCol='locationTag';
        $table_item='product_savers';

    } else {
        $excel = 'excel_' . $table;
    }




        $stmt = $this->db->prepare("UPDATE  `{$excel}` SET `quantity`=`quantity` - {$number} WHERE  `code`=?  ");
        $stmt->execute(array($code));

        $stmtCheckActveLocation=$this->db->prepare("SELECT *FROM {$table_item} WHERE  id=? AND {$locationCol} != 1");
        $stmtCheckActveLocation->execute(array($id_item));
        if ($stmtCheckActveLocation->rowCount() > 0) {
            $stmtChCodeConform = $this->db->prepare("SELECT *FROM location_confirm WHERE code =? AND model=? AND quantity >= {$number}");
            $stmtChCodeConform->execute(array($code, $table));
            if ($stmtChCodeConform->rowCount() > 0) {
                $stmtExcel_conform = $this->db->prepare("UPDATE location_confirm SET  quantity=quantity - {$number} ,`date`=?  WHERE code =? AND  model=?");
                $stmtExcel_conform->execute(array(time(), $code, $table));
                if($stmtExcel_conform->rowCount() <=0)
                {
                    $this->filter_error_quantity( $code, $table,$number,'   ضبط كمية الطلب   - رقم الخطا 16');
                }
            } else {
                $stmtExcel_conform = $this->db->prepare("UPDATE location_confirm SET  quantity=0 ,`date`=?  WHERE code =? AND  model=?");
                $stmtExcel_conform->execute(array(time(), $code, $table));
                if($stmtExcel_conform->rowCount() <=0)
                {
                    $this->filter_error_quantity( $code, $table,$number,'   ضبط كمية الطلب   - رقم الخطا 17');
                }
            }
        }
    $this->AddToTraceByFunction($this->userid,'Controller','set_quantity_order/'.$table.'/'.$id_item.'/'.$code.'/'.$number);
}


    function set_quantity_order_minus($table,$id_item,$code,$number)
    {


        $locationCol = 'location';
        $table_item = $table;

        if ($table == 'mobile') {
            $excel = 'excel';
        } else if ($table == 'product_savers') {
            $excel = 'excel_savers';
            $table = 'savers';
            $locationCol = 'locationTag';
            $table_item = 'product_savers';

        } else {
            $excel = 'excel_' .$table;
        }


        $stmt = $this->db->prepare("UPDATE  `{$excel}` SET `quantity`=`quantity` + {$number} WHERE  `code`=?  ");
        $stmt->execute(array($code));

        $stmtCheckActveLocation = $this->db->prepare("SELECT *FROM {$table} WHERE  id=? AND {$locationCol} = 0");
        $stmtCheckActveLocation->execute(array($id_item));
        if ($stmtCheckActveLocation->rowCount() > 0) {

            $stmtChCodeConform = $this->db->prepare("SELECT *FROM location_confirm WHERE code =? AND model=?");
            $stmtChCodeConform->execute(array($code,$table ));
            if ($stmtChCodeConform->rowCount() > 0) {
                $stmtExcel_conform = $this->db->prepare("UPDATE location_confirm SET  quantity=quantity+{$number} ,`date`=?  WHERE code =? AND  model=?");
                $stmtExcel_conform->execute(array(time(), $code,$table));
                if($stmtExcel_conform->rowCount() <=0)
                {
                    $this->filter_error_quantity( $code, $table,$number,'    تنقيص الطلب   - رقم الخطا 18');
                }
            }else
            {
                $stmtExcel_conform = $this->db->prepare("INSERT INTO  location_confirm (quantity,code,model,`date`,userid)  values (?,?,?,?,?)");
                $stmtExcel_conform->execute(array($number,$code,$table,time(),$this->userid));
                if($stmtExcel_conform->rowCount() <=0)
                {
                    $this->filter_error_quantity( $code, $table,$number,'   تنقيص الطلب    - رقم الخطا 19');
                }

            }

        }

        $this->AddToTraceByFunction($this->userid,'Controller','set_quantity_order_minus/'.$table.'/'.$id_item.'/'.$code.'/'.$number);



    }






    public function name_category($id,$tbale)
    {

        $stmt = $this->db->prepare("SELECT * from    `{$tbale}`  WHERE `id`=? ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $this->db->prepare("SELECT * from   `{$tbale}`  WHERE `relid`=? ");
            $stmt->execute(array($id));
            if ($stmt->rowCount() > 0) {
                if ($result['relid'] == 0)
                {
                    $this->pathBreadcumbs[0] =$result['title'];
                }

            }
            $this->name_category( $result['relid'],$tbale);
            return  $this->pathBreadcumbs[0];
        }

    }



    function permit_shortfalls($id,$flag)
    {
        if (in_array($this->userid, $this->idAdmin)) {
            return true;
        }else
        {

            $stmt = $this->db->prepare("SELECT shortfalls from `user` WHERE `id`=?  AND shortfalls <> '' ");
            $stmt->execute(array($id));
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                if(in_array($flag,explode(',',$data['shortfalls'])))
                {
                    return true;
                }else
                {
                    return false;
                }
            } else {
                return false;
            }

        }

    }


    function permit_check_accessories($id,$flag)
    {
        if (in_array($this->userid, $this->idAdmin)) {
            return true;
        }else
        {

            $stmt = $this->db->prepare("SELECT check_accessories from `user` WHERE `id`=?  AND check_accessories <> '' ");
            $stmt->execute(array($id));
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                if(in_array($flag,explode(',',$data['check_accessories'])))
                {
                    return true;
                }else
                {
                    return false;
                }
            } else {
                return false;
            }

        }

    }


    function insertCodeSerial_conform($code,$model,$type)
    {
        $stmtCh=$this->db->prepare("SELECT *FROM serial_conform       WHERE  serial_conform.code=?  AND  serial_conform.model=? ");
        $stmtCh->execute(array($code,$model  ));
        if ($stmtCh->rowCount() <=0)
        {
            $stmtIn = $this->db->prepare("INSERT INTO serial_conform ( code, model,type, userId, date) VALUES (?,?,?,?,?) ");
            $stmtIn ->execute(array($code,$model,$type,$this->userid,time()));
        }

    }


    function deleteCodeFromSerialConform($code,$model)
    {
        $stmt  = $this->db->prepare("DELETE FROM serial_conform WHERE code=? AND  model=?");
        $stmt ->execute(array($code,$model));
    }





    function serial_moves($serial,$code,$number_bill,$table,$type)
    {

        if ($table=='product_savers')
        {
            $table= 'savers';
        }



        if ($type=='sale')
        {
            $serial=explode(',',$serial);
            foreach ($serial as $sir)
            {
                $sir=trim($sir);
                $time=time();
                $stmtCh  = $this->db->prepare("SELECT * FROM serial WHERE code=? AND serial =? AND model=?  ");
                $stmtCh ->execute(array($code,$sir,$table));
                if ($stmtCh->rowCount() > 0) {
                    $stmtData = $this->db->prepare("INSERT INTO serial_moves (page, bill, code, serial, type_enter, quantity, model, userId,location, userid_move,`date`,number_bill,`type`)  SELECT page, bill, code, serial, type_enter, quantity, model,userId,location, $this->userid, $time,'{$number_bill}','{$type}'  FROM serial WHERE serial=? AND code=? LIMIT 1");
                    $stmtData->execute(array($sir, $code));
                    if ($stmtData->rowCount() > 0) {
                        $stmt = $this->db->prepare("DELETE FROM serial WHERE code=? AND serial =? AND model=? LIMIT  1 ");
                        $stmt->execute(array($code, $sir, $table));
                    }

                }else
                {
                    $stmtData = $this->db->prepare("INSERT INTO serial_case_1 (code, serial, model, number_bill, userId, date) VALUES (?,?,?,?,?,?)");
                    $stmtData->execute(array($code,$sir,$table,$number_bill,$this->userid,time() ));
                }

            }

        } else  if ($type=='withdrawn')
        {
            $serial=explode(',',$serial);
            foreach ($serial as $sir)
            {
                $sir=trim($sir);
                $time=time();
                $stmtCh  = $this->db->prepare("SELECT * FROM serial WHERE code=? AND serial =? AND model=?  ");
                $stmtCh ->execute(array($code,$sir,$table));
                if ($stmtCh->rowCount() > 0) {
                    $stmtData = $this->db->prepare("INSERT INTO serial_moves (page, bill, code, serial, type_enter, quantity, model, userId,location, userid_move,`date`,number_bill,`type`)  SELECT page, bill, code, serial, type_enter, quantity, model,userId,location, $this->userid, $time,'{$number_bill}','{$type}'  FROM serial WHERE serial=? AND code=? LIMIT 1");
                    $stmtData->execute(array($sir, $code));
                    if ($stmtData->rowCount() > 0) {
                        $stmt = $this->db->prepare("DELETE FROM serial WHERE code=? AND serial =? AND model=? LIMIT  1 ");
                        $stmt->execute(array($code, $sir, $table));
                    }

                }

            }

        }


    }


    function filter_error_quantity( $code,$mode,$quantity,$note,$number_bill=null)
    {

        $stmtData = $this->db->prepare("INSERT INTO error_quantity (code, model, quantity, note, userid, date, number_bill) values (?,?,?,?,?,?,?)");
        $stmtData->execute(array($code,$mode,$quantity,$note,$this->userid,time(),$number_bill));

    }

    function filter_location_tracking_quantity( $code,$mode,$location,$quantity,$note,$type,$number_bill=null)
    {

        $stmtData = $this->db->prepare("INSERT INTO filter_location_tracking_quantity ( code, model, location, quantity, type, note, number_bill, userid, date) values (?,?,?,?,?,?,?,?,?)");
        $stmtData->execute(array($code,$mode,$location,$quantity,$type,$note,$number_bill,$this->userid,time()));

    }

    function filter_location_error_quantity( $code,$mode,$location,$quantity,$note,$type,$number_bill=null)
    {


        $stmtData = $this->db->prepare("INSERT INTO filter_location_error_quantity ( code, model, location, quantity, type, note, number_bill, userid, date) values (?,?,?,?,?,?,?,?,?)");
        $stmtData->execute(array($code,$mode,$location,$quantity,$type,$note,$number_bill,$this->userid,time()));

    }

   function check_model_code_and_serial($code)
    {


        $code=trim($code);




        $stmt=$this->db->prepare("SELECT  code FROM code where code = ?");
        $stmt->execute(array($code));
        if ($stmt->rowCount()>0)
        {
            return $this->check_active_serial_prepared('mobile',$code);
        }

        $stmt=$this->db->prepare("SELECT  code FROM color_accessories where code = ?");
        $stmt->execute(array($code));
        if ($stmt->rowCount()>0)
        {
            return $this->check_active_serial_prepared('accessories',$code);

        }

        $stmt=$this->db->prepare("SELECT  code FROM code_camera where code = ?");
        $stmt->execute(array($code));
        if ($stmt->rowCount()>0)
        {
            return $this->check_active_serial_prepared('camera',$code);

        }

        $stmt=$this->db->prepare("SELECT  code FROM code_games where code = ?");
        $stmt->execute(array($code));
        if ($stmt->rowCount()>0)
        {
            return $this->check_active_serial_prepared('games',$code);

        }

        $stmt=$this->db->prepare("SELECT  code FROM code_network where code = ?");
        $stmt->execute(array($code));
        if ($stmt->rowCount()>0)
        {
            return $this->check_active_serial_prepared('network',$code);

        }

        $stmt=$this->db->prepare("SELECT  code FROM product_savers where code = ?");
        $stmt->execute(array($code));
        if ($stmt->rowCount()>0)
        {
            return $this->check_active_serial_prepared('savers',$code);

        }

        $stmt=$this->db->prepare("SELECT  code FROM code_computer where code = ?");
        $stmt->execute(array($code));
        if ($stmt->rowCount()>0)
        {
            return $this->check_active_serial_prepared('computer',$code);

        }

        $stmt=$this->db->prepare("SELECT  code FROM code_printing_supplies where code = ?");
        $stmt->execute(array($code));
        if ($stmt->rowCount()>0)
        {
            return $this->check_active_serial_prepared('printing_supplies',$code);
        }else
        {


            $stmtpage = $this->db->prepare("SELECT  * FROM  spare_code   WHERE spare_code=? LIMIT 1 ");
            $stmtpage->execute(array($code));
            if ($stmtpage->rowCount() > 0) {
                $result = $stmtpage->fetch(PDO::FETCH_ASSOC);
                return $this->check_active_serial_prepared($result['model'],$result['code']);
            }else
            {

                $stmtSerail = $this->db->prepare("SELECT  * FROM  serial   WHERE serial=? LIMIT 1 ");
                $stmtSerail->execute(array($code));
                if ($stmtSerail->rowCount() > 0) {
                    $result = $stmtSerail->fetch(PDO::FETCH_ASSOC);
                    return $this->check_active_serial_prepared($result['model'],$result['code']);
                }else
                {
                    die('notFoundCode');
                }



            }

        }

        die('notFoundCode');

    }




    function check_active_serial_prepared($model,$code)
    {

        if ($model == 'savers')
        {

            $stmt = $this->db->prepare("SELECT type_device.serial_prepared FROM `product_savers` INNER JOIN type_device ON type_device.id=product_savers.id_device  WHERE product_savers.code=? AND type_device.serial_prepared=1 LIMIT 1");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0) {
                return true;
            }else
            {
                return false;
            }

        }else if ($model == 'accessories')
        {

            $stmt = $this->db->prepare("SELECT category_accessories.serial_prepared FROM `color_accessories` INNER JOIN accessories ON accessories.id=color_accessories.id_item INNER JOIN  category_accessories On category_accessories.id=accessories.id_cat WHERE color_accessories.code=? AND category_accessories.serial_prepared=1 LIMIT 1");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0) {
                return true;
            }else
            {
                return false;
            }

        }else{

            $cat='category_'.$model;
            if($model=='mobile')
            {
                $codeTable='code';
                $color='color';
            }else
            {
                $codeTable='code_'.$model;
                $color='color_'.$model;
            }


            $stmt = $this->db->prepare("SELECT {$cat}.serial_prepared FROM `{$codeTable}`
             INNER JOIN {$color} ON {$color}.id={$codeTable}.id_color
             INNER JOIN {$model} ON {$model}.id={$color}.id_item
             INNER JOIN  {$cat} On {$cat}.id={$model}.id_cat
             WHERE {$codeTable}.code=? AND {$cat}.serial_prepared=1 LIMIT 1");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0) {
                return true;
            }else
            {
                return false;
            }

        }


    }





    function check_active_location($model,$code)
    {

        if ($model == 'savers')
        {

            $stmt = $this->db->prepare("SELECT product_savers.locationTag FROM `product_savers`  WHERE product_savers.locationTag=1  AND product_savers.code=?  LIMIT 1");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0) {
                return true;
            }else
            {
                return false;
            }

        }else if ($model == 'accessories')
        {

            $stmt = $this->db->prepare("SELECT accessories.location FROM `color_accessories` INNER JOIN accessories ON accessories.id=color_accessories.id_item  WHERE  accessories.location=1 AND color_accessories.code=? LIMIT 1");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0) {
                return true;
            }else
            {
                return false;
            }

        }else{

            $cat='category_'.$model;
            if($model=='mobile')
            {
                $codeTable='code';
                $color='color';
            }else
            {
                $codeTable='code_'.$model;
                $color='color_'.$model;
            }



            $stmt = $this->db->prepare("SELECT {$model}.location  FROM `{$codeTable}`
             INNER JOIN {$color} ON {$color}.id={$codeTable}.id_color
             INNER JOIN {$model} ON {$model}.id={$color}.id_item  WHERE {$model}.location = 1 AND `{$codeTable}`.code=?
             LIMIT 1");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0) {
                return true;
            }else
            {
                return false;
            }

        }


    }


    function permit_user($flag)
    {
        if (in_array($this->userid, $this->idAdmin)) {
            return true;
        }else
        {

            $stmt = $this->db->prepare("SELECT {$flag} from `user` WHERE `id`=?  AND {$flag}  =1 ");
            $stmt->execute(array($this->userid));
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }

        }

    }


    function checkSerialMatchCode($model,$code,$serial)
    {
        $stmt = $this->db->prepare("SELECT  * FROM serial   WHERE model=? AND code=? AND serial=? LIMIT 1");
        $stmt->execute(array($model,$code,$serial));
        if ($stmt->rowCount() > 0) {
            return true;
        }else
        {
            false;
        }
    }



    function spare_code_item($model,$code)
    {
        $stmt = $this->db->prepare("SELECT  spare_code FROM spare_code   WHERE model=? AND code=?  ");
        $stmt->execute(array($model,$code));
        if ($stmt->rowCount() > 0) {
            $data=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $data[]=$row['spare_code'];
            }
            if ($data)
            {
                return implode('-',$data);
            }

        }
    }


    function check_serial_required($code,$col,$model=null)
    {



        if ($model==null)
        {
            $model =  $this->model_code($code);
        }

        if ($model == 'savers')
        {

            $stmt = $this->db->prepare("SELECT type_device.{$col} FROM `product_savers` INNER JOIN type_device ON type_device.id=product_savers.id_device  WHERE product_savers.code=? AND type_device.{$col}=1 LIMIT 1");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0) {
                return true;
            }else
            {
                return false;
            }

        }else if ($model == 'accessories')
        {

            $stmt = $this->db->prepare("SELECT category_accessories.{$col} FROM `color_accessories` INNER JOIN accessories ON accessories.id=color_accessories.id_item INNER JOIN  category_accessories On category_accessories.id=accessories.id_cat WHERE color_accessories.code=? AND category_accessories.{$col}=1 LIMIT 1");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0) {
                return true;
            }else
            {
                return false;
            }

        }else{

            $cat='category_'.$model;
            if($model=='mobile')
            {
                $codeTable='code';
                $color='color';
            }else
            {
                $codeTable='code_'.$model;
                $color='color_'.$model;
            }


            $stmt = $this->db->prepare("SELECT {$cat}.{$col} FROM `{$codeTable}`
             INNER JOIN {$color} ON {$color}.id={$codeTable}.id_color
             INNER JOIN {$model} ON {$model}.id={$color}.id_item
             INNER JOIN  {$cat} On {$cat}.id={$model}.id_cat
             WHERE {$codeTable}.code=? AND {$cat}.{$col}=1 LIMIT 1");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0) {
                return true;
            }else
            {
                return false;
            }

        }


    }




    function model_code($code)
    {


        $code=trim($code);

        $stmt=$this->db->prepare("SELECT  code FROM code where code = ?");
        $stmt->execute(array($code));
        if ($stmt->rowCount()>0)
        {
            return 'mobile';
        }

        $stmt=$this->db->prepare("SELECT  code FROM color_accessories where code = ?");
        $stmt->execute(array($code));
        if ($stmt->rowCount()>0)
        {
            return 'accessories';
        }

        $stmt=$this->db->prepare("SELECT  code FROM code_camera where code = ?");
        $stmt->execute(array($code));
        if ($stmt->rowCount()>0)
        {
            return 'camera';
        }

        $stmt=$this->db->prepare("SELECT  code FROM code_games where code = ?");
        $stmt->execute(array($code));
        if ($stmt->rowCount()>0)
        {
            return 'games';
        }

        $stmt=$this->db->prepare("SELECT  code FROM code_network where code = ?");
        $stmt->execute(array($code));
        if ($stmt->rowCount()>0)
        {
            return 'network';
        }

        $stmt=$this->db->prepare("SELECT  code FROM product_savers where code = ?");
        $stmt->execute(array($code));
        if ($stmt->rowCount()>0)
        {
            return 'savers';
        }

        $stmt=$this->db->prepare("SELECT  code FROM code_computer where code = ?");
        $stmt->execute(array($code));
        if ($stmt->rowCount()>0)
        {
            return 'computer';
        }

        $stmt=$this->db->prepare("SELECT  code FROM code_printing_supplies where code = ?");
        $stmt->execute(array($code));
        if ($stmt->rowCount()>0)
        {
            return 'printing_supplies';
        }

        return  false;

    }



    function getSerialCode($code,$quantity,$model)
    {


        if ($model == 'product_savers')
        {
            $model='savers';
        }

        $serial=array();
        $quantity=(int)$quantity;
        $stmt=$this->db->prepare("SELECT   serial  FROM serial WHERE code=? AND model=?  LIMIT {$quantity}  ");
        $stmt->execute(array($code,$model));
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $serial[]=$row['serial'];
            }
        }

        return $serial;

    }
	/**
     * h27
     * check if row is exist in table by where condition
     * @param $table
     * @param $where
     * @return bool
     */
    function isExist($table,$where)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$table} WHERE {$where}");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }else{
            return false;
        }
    }


    /**
     * computer_assembly
     * @param $id
     * @param $col
     * @return string
     *
     */

    function details_computer_assembly($id, $col)
    {
        $stmt = $this->db->prepare("SELECT *FROM  computer_assembly WHERE id=?   ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result[$col];
        }else
        {
            return '-';
        }

    }



    function check_one_itemcomputer_assembly($id)
    {




        $stmtItemCh=$this->db->prepare("SELECT * FROM `computer_assembly_item`    WHERE id_computer_assembly=?  AND sub_item=0 GROUP BY id_item,model");
        $stmtItemCh->execute(array($id));
        while ($rowCh = $stmtItemCh->fetch(PDO::FETCH_ASSOC)) {

            $stmtItem = $this->db->prepare("SELECT * FROM `computer_assembly_item`    WHERE id=? AND id_computer_assembly=?  AND sub_item=0");
            $stmtItem->execute(array($rowCh['id'],$id));
            $qty = 0;
            while ($rowItem = $stmtItem->fetch(PDO::FETCH_ASSOC)) {
                if ($rowItem['model'] == 'mobile') {
                    $excel = 'excel';
                } else {
                    $excel = 'excel_' . $rowItem['model'];
                }
                $stmtexcel = $this->db->prepare("SELECT  {$excel}.quantity  FROM {$excel} WHERE `code`=?    AND {$excel}.quantity > 0  LIMIT 1");
                $stmtexcel->execute(array(trim($rowItem['code'])));
                if ($stmtexcel->rowCount() > 0) {
                    $resultQty = $stmtexcel->fetch(PDO::FETCH_ASSOC);
                    $qty = $qty + $resultQty['quantity'];
                }


                $stmtItemSub = $this->db->prepare("SELECT {$excel}.quantity  FROM `computer_assembly_item` INNER  JOIN {$excel} ON  {$excel}.code=computer_assembly_item.code  WHERE computer_assembly_item.id_computer_assembly=?  AND computer_assembly_item.sub_item=?   AND {$excel}.quantity > 0");
                $stmtItemSub->execute(array($id, $rowItem['id']));
                while ($rowItemSub = $stmtItemSub->fetch(PDO::FETCH_ASSOC)) {
                    $qty = $qty + $rowItemSub['quantity'];
                }

            }



            if ($qty == 0) {
                $stmtUPd = $this->db->prepare("UPDATE    computer_assembly SET active=? , note =?    WHERE id = ?  ");
                $stmtUPd->execute(array(2, 'نفذت بعض مواد التجميعة', $id));
                return false;
            }

        }
        return true;
    }


    /**
     * @param $id
     * @param int $type_price  1=Dollars
     */

    function getPriceComputerAssembly($id,$type_price=0)
    {

        $price=0;

        $stmtItem=$this->db->prepare("SELECT *FROM `computer_assembly_item` WHERE  `id_computer_assembly` = ?  AND sub_item=0   GROUP BY id_computer_assembly,id_item,model ");
        $stmtItem->execute(array($id));
        $price=0;
        while($row=$stmtItem->fetch (PDO::FETCH_ASSOC)) {


            if ($type_price==1)
            {
                $price = $price + $row['price'];
            }else {


                if ($this->loginUser()) {
                    $price = $price + str_replace($this->comma, '', $this->price_dollarsAdmin($row['price']));
                } else {
                    $price = $price + $row['price'];
                }
            }
        }

        return $price;




    }

/****** end computer_assembly ********/
	 function add_cart_shop_all()
    {
        // $stmt=$this->db->prepare(" INSERT INTO `cart_shop_all`(`id`, `id_member_r`, `id_item`, `size`, `price`, `price_dollars`, `image`, `color`, `code`, `table`, `number`, `buy`, `date`, `date_req`, `status`, `why_rejected`, `mpx`, `user_id`, `date_d_r`, `number_bill`, `name_color`, `accountant`, `date_accountant`, `id_accountant_user`, `prepared`, `date_prepared`, `id_prepared`, `note_prepared`, `top`, `direct`, `user_direct`, `done_direct`, `dollar_exchange`, `cancel`, `date_cancel`, `enter_serial`, `edit_bill`, `edit_price`, `old_price`, `user_edit_price`, `note`, `location`, `auto_print`, `crystal_bill`, `group_bill`, `offers`, `id_offer`, `date_offer`, `price_type`, `wr_prepared`, `byqr`, `user_note_prepared`, `note_search_serial`, `user_note_search_serial`, `id_computer_assembly`, `computer_assembly`, `date_computer_assembly`) SELECT `id`, `id_member_r`, `id_item`, `size`, `price`, `price_dollars`, `image`, `color`, `code`, `table`, `number`, `buy`, `date`, `date_req`, `status`, `why_rejected`, `mpx`, `user_id`, `date_d_r`, `number_bill`, `name_color`, `accountant`, `date_accountant`, `id_accountant_user`, `prepared`, `date_prepared`, `id_prepared`, `note_prepared`, `top`, `direct`, `user_direct`, `done_direct`, `dollar_exchange`, `cancel`, `date_cancel`, `enter_serial`, `edit_bill`, `edit_price`, `old_price`, `user_edit_price`, `note`, `location`, `auto_print`, `crystal_bill`, `group_bill`, `offers`, `id_offer`, `date_offer`, `price_type`, `wr_prepared`, `byqr`, `user_note_prepared`, `note_search_serial`, `user_note_search_serial`, `id_computer_assembly`, `computer_assembly`, `date_computer_assembly` FROM cart_shop WHERE id NOT IN (SELECT id FROM cart_shop_all) ");
        // $stmt->execute();
        $stmt=$this->db->prepare(" INSERT INTO `cart_shop_all`(`id`, `id_member_r`, `id_item`, `size`, `price`, `price_dollars`, `image`, `color`, `code`, `table`, `number`, `buy`, `date`, `date_req`, `status`, `why_rejected`, `mpx`, `user_id`, `date_d_r`, `number_bill`, `name_color`, `accountant`, `date_accountant`, `id_accountant_user`, `prepared`, `date_prepared`, `id_prepared`, `note_prepared`, `top`, `direct`, `user_direct`, `done_direct`, `dollar_exchange`, `cancel`, `date_cancel`, `enter_serial`, `edit_bill`, `edit_price`, `old_price`, `user_edit_price`, `note`, `location`, `auto_print`, `crystal_bill`, `group_bill`, `offers`, `id_offer`, `date_offer`, `price_type`, `wr_prepared`, `byqr`, `user_note_prepared`, `note_search_serial`, `user_note_search_serial`, `id_computer_assembly`, `computer_assembly`, `date_computer_assembly`) SELECT `id`, `id_member_r`, `id_item`, `size`, `price`, `price_dollars`, `image`, `color`, `code`, `table`, `number`, `buy`, `date`, `date_req`, `status`, `why_rejected`, `mpx`, `user_id`, `date_d_r`, `number_bill`, `name_color`, `accountant`, `date_accountant`, `id_accountant_user`, `prepared`, `date_prepared`, `id_prepared`, `note_prepared`, `top`, `direct`, `user_direct`, `done_direct`, `dollar_exchange`, `cancel`, `date_cancel`, `enter_serial`, `edit_bill`, `edit_price`, `old_price`, `user_edit_price`, `note`, `location`, `auto_print`, `crystal_bill`, `group_bill`, `offers`, `id_offer`, `date_offer`, `price_type`, `wr_prepared`, `byqr`, `user_note_prepared`, `note_search_serial`, `user_note_search_serial`, `id_computer_assembly`, `computer_assembly`, `date_computer_assembly` FROM cart_shop_active WHERE id NOT IN (SELECT id FROM cart_shop_all) ");
        $stmt->execute();

        // update cart_shop_all where id in cart_shop and crystal_bill=''
        $stmt=$this->db->prepare("UPDATE cart_shop_all as t1  INNER JOIN cart_shop_active as t2 on t1.id = t2.id SET t1.id_member_r=t2.id_member_r,t1.id_item=t2.id_item,t1.size=t2.size,t1.price=t2.price,t1.price_dollars=t2.price_dollars, t1.number = t2.number ,t1.buy = t2.buy , t1.date = t2.date , t1.date_req = t2.date_req , t1.status = t2.status , t1.why_rejected = t2.why_rejected , t1.mpx = t2.mpx , t1.user_id = t2.user_id , t1.date_d_r = t2.date_d_r , t1.number_bill = t2.number_bill , t1.name_color = t2.name_color , t1.accountant = t2.accountant , t1.date_accountant = t2.date_accountant , t1.id_accountant_user = t2.id_accountant_user , t1.prepared = t2.prepared , t1.date_prepared = t2.date_prepared , t1.id_prepared = t2.id_prepared , t1.note_prepared = t2.note_prepared , t1.top = t2.top , t1.direct = t2.direct , t1.user_direct = t2.user_direct , t1.done_direct = t2.done_direct , t1.dollar_exchange = t2.dollar_exchange , t1.cancel = t2.cancel , t1.date_cancel = t2.date_cancel , t1.enter_serial = t2.enter_serial , t1.edit_bill = t2.edit_bill , t1.edit_price = t2.edit_price , t1.old_price = t2.old_price , t1.user_edit_price = t2.user_edit_price , t1.note = t2.note , t1.location = t2.location , t1.auto_print = t2.auto_print , t1.crystal_bill = t2.crystal_bill , t1.group_bill = t2.group_bill , t1.offers = t2.offers , t1.id_offer = t2.id_offer , t1.date_offer = t2.date_offer , t1.price_type = t2.price_type , t1.wr_prepared = t2.wr_prepared , t1.byqr = t2.byqr , t1.user_note_prepared = t2.user_note_prepared , t1.note_search_serial = t2.note_search_serial , t1.user_note_search_serial = t2.user_note_search_serial , t1.id_computer_assembly = t2.id_computer_assembly , t1.computer_assembly = t2.computer_assembly , t1.date_computer_assembly = t2.date_computer_assembly where t1.buy!=2 or t1.prepared!=2 or t1.crystal_bill='' ");
        $stmt->execute();

     	$stmt=$this->db->prepare("DELETE FROM `cart_shop_all` where id not in (select id from cart_shop_active) and id >360329");
        $stmt->execute();


    }
/**
     * check if the item that ordered in cart_shop_active there are the 0 quantity in excel table
     * @param $number_bill
     * @return bool
     */
    public function checkQuantity($number_bill)
    {
        $stmt=$this->db->prepare("SELECT code,`table`,`number` FROM cart_shop_active WHERE number_bill=? order by `number` desc");
        $stmt->execute(array($number_bill));
        // $count=$stmt->rowCount();
        if($stmt->rowCount())
        {
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                $code=$row['code'];
                $table=$row['table'];
                // $number=$row['number'];
                $excel = 'excel';
                if($table=='product_savers')
                {
                    $excel = 'excel_savers';
                }else if($table!='mobile')
                {
                    $excel = $excel.'_'.$table;
                }


                $stmt=$this->db->prepare("SELECT quantity FROM {$excel} WHERE code=?");
                $stmt->execute(array($code));
                // $count=$stmt->rowCount();
                if($stmt->rowCount())
                {
                    $result=$stmt->fetch(PDO::FETCH_ASSOC);
                    // $quantity=$result['quantity'];
                    if($result['quantity']<=0)
                    {
                        return false;
                    }
                }
            }
            return true;
        }
        else
        {
            return false;
        }
    }

}