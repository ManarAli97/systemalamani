<?php


class processing_report extends Controller
{

    public $ids = array();


    function __construct()
    {
        parent::__construct();
        $this->table = 'processing_report';
        $this->setting = new Setting();
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `number_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `normal_date` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `note` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,  
          `userid` int(10) NOT NULL DEFAULT '0',
        
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table));

    }

    function insert_data()
    {
        $number_bill=$_GET['number_bill'];
        $code=$_GET['code'];
         $note=$_GET['note'];

        if ($note == 1)
        {

             $date_now_js= $_GET['date_now'];
             $time=date('s', time());
             $t=$time-$date_now_js;

            if ($t <= 0)
            {
                $stmtch = $this->db->prepare("SELECT * FROM cart_shop_active WHERE `number_bill` = ? AND `code` = ? AND prepared=1 ");
                $stmtch->execute(array($number_bill,$code));
                if ($stmtch->rowCount() > 0)
                {
                    $stmtInst=$this->db->prepare("INSERT INTO processing_report ( number_bill, code, normal_date, note, `date`, userid) values  (?,?,?,?,?,?) ");
                    $stmtInst->execute(array($number_bill,$code,date('Y-m-d h:i:s A'),'جهاز قارئ الباركود',time(),$this->userid));
                }

            }else
            {
                $stmtch = $this->db->prepare("SELECT * FROM cart_shop_active WHERE `number_bill` = ? AND `code` = ? AND prepared=1 ");
                $stmtch->execute(array($number_bill,$code));
                if ($stmtch->rowCount() > 0)
                {
                    $stmtInst=$this->db->prepare("INSERT INTO processing_report ( number_bill, code, normal_date, note, `date`, userid) values  (?,?,?,?,?,?) ");
                    $stmtInst->execute(array($number_bill,$code,date('Y-m-d h:i:s A'),'ادخال يدوي لرمز المادة',time(),$this->userid));
                }
            }


        }else
        {
            $stmtch = $this->db->prepare("SELECT * FROM cart_shop_active WHERE `number_bill` = ? AND `code` = ? AND prepared=1 ");
            $stmtch->execute(array($number_bill,$code));
            if ($stmtch->rowCount() > 0)
            {
                $stmtInst=$this->db->prepare("INSERT INTO processing_report ( number_bill, code, normal_date, note, `date`, userid) values  (?,?,?,?,?,?) ");
                $stmtInst->execute(array($number_bill,$code,date('Y-m-d h:i:s A'),$note,time(),$this->userid));
            }
        }


    }






    public function list_processing_report()
    {
        $this->checkPermit('list_processing_report', 'processing_report');
        $this->adminHeaderController($this->langControl('processing_report'));


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

        require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();
    }



    public function processing_processing_report($fromDate=null,$toDate=null)
    {

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(
            array('db' => 'code', 'dt' => 0),
            array('db' => 'number_bill', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),
            array('db' => 'note', 'dt' => 2),
            array('db' => 'userid', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }
            ),



            array('db' => 'normal_date', 'dt' => 4),
            array('db' => 'id', 'dt' => 5)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        if ($fromDate && $toDate)
        {
            echo json_encode(
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns," `date` between  {$fromDate} AND  {$toDate} "));
        }else
        {
            echo json_encode(
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
            );
        }




}





}









