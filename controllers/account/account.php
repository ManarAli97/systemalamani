<?php

class purchase extends Controller {
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

    public function account_catg()
    {
        $account_catg = '';

        // <ul>
        //         <li class="location_model"> <a href="#">uasort</a></li>
        //         <li class="location_model">uasort</li>
        //     </ul>
        $this->checkPermit('account','account');
        $this->adminHeaderController($this->langControl('account'));

        $stmt = $this->db->prepare("SELECT `account_catg` FROM `title` WHERE active = 0");
        $stmt->execute();
        if($stmt->rowCount() > 0){
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $account_catg .= "<ul>";
                $account_catg .= "<li class='location_model'> <a href='#'>";
                $account_catg .= $row['title'];
                $account_catg .= " </a></li></ul>";
            }
        }

        return $account_catg;
    }


}