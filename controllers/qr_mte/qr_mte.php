<?php

class qr_mte extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->table='qr_mte';
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT , 
          `id_customer` int(11) NOT NULL,  
          `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `phone` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `normal_date` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `active` int(10) NOT NULL DEFAULT '0',
          `show` int(10) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,  
          `userid` int(10) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table));

    }


    function index()
    {
        require($this->render($this->folder, 'html', 'index', 'php'));

    }



    function camera()
    {

        $qr=$_GET['qr'];

        $stmtqr=$this->db->prepare("SELECT *FROM register_user WHERE uid=?    LIMIT 1 ");
        $stmtqr->execute(array($qr));
        if ($stmtqr->rowCount() > 0) {
            $result = $stmtqr->fetch(PDO::FETCH_ASSOC);
            $stmtch=$this->db->prepare("SELECT *FROM qr_mte WHERE id_customer=? AND name=? AND phone=? AND `show`=?");
            $stmtch->execute(array($result['id'], $result['name'], $result['phone'],0));
            if ($stmtch->rowCount() > 0) {

                echo 'add';

            }else{
                $stmt = $this->db->prepare("INSERT INTO  qr_mte ( id_customer, name, phone, `date`,normal_date,`userid`) values (?,?,?,?,?,?) ");
                $stmt->execute(array($result['id'], $result['name'], $result['phone'], time(), date('Y-m-d h:i a'),$this->userid));
                if ($stmt->rowCount() > 0)
                {
                    echo 'add';
                }else{
                    echo 'error';
                }
            }

        }else
        {
            echo 'not_found';
        }
    }





    public function list_report()
    {
        $this->checkPermit('list_report', 'qr_mte');
        $this->adminHeaderController($this->langControl('list_report'));



        require($this->render($this->folder, 'html', 'report', 'php'));
        $this->adminFooterController();
    }



    public function processing_report()
    {

        $table = $this->table;
        $primaryKey = $table .'.id';

        $columns = array(
            array('db' =>  $table .'.name', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return "<span onclick='copy_text(this)' class='copyToClipboard' title='نسخ' data-clipboard-text='{$d}'>{$d}</span>";

                }
            ),


            array('db' =>  $table .'.phone', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return "<span onclick='copy_text(this)' class='copyToClipboard' title='نسخ' data-clipboard-text='{$d}'>{$d}</span>";

                }
            ),


            array('db' =>  $table .'.date', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    $d= date('Y-m-d h:i:s a',$d);
                    return "<span onclick='copy_text(this)' class='copyToClipboard' title='نسخ' data-clipboard-text='{$d}'>{$d}</span>";

                }
            ),

            array('db' =>   'user.username', 'dt' => 3 ),

            array('db' =>  $table .'.id', 'dt' => 4)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = " inner JOIN user ON user.id = qr_mte.userid ";
        $whereAll = array("qr_mte.`show`=1");

            echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));


}



    public function list_qr_mte()
    {
        $this->checkPermit('list_qr_mte', 'qr_mte');
        $this->adminHeaderController($this->langControl('qr_mte'));



        require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();
    }
    public function processing_qr_mte()
    {

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(
            array('db' => 'name', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return "<span onclick='copy_text(this)' class='copyToClipboard' title='نسخ' data-clipboard-text='{$d}'>{$d}</span>";

                }
            ),


            array('db' => 'phone', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return "<span onclick='copy_text(this)' class='copyToClipboard' title='نسخ' data-clipboard-text='{$d}'>{$d}</span>";

                }
            ),


            array('db' => 'date', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    $d= date('Y-m-d h:i:s a',$d);
                    return "<span onclick='copy_text(this)' class='copyToClipboard' title='نسخ' data-clipboard-text='{$d}'>{$d}</span>";

                }
            ),

            array('db' => 'id', 'dt' => 3,
                'formatter' => function ($d, $row) {

                    return "<button  onclick='hide_customer({$d})' class='btn btn-warning'  >اخفاء</button>";

                }
            ),

            array('db' => 'id', 'dt' => 4)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns," `show` = 0 " )
        );

    }


    function hide($id)
    {

        $stmt=$this->db->prepare("UPDATE qr_mte SET `show`=1 WHERE `show`=0 AND id=?");
        $stmt->execute(array($id));
        if ($stmt->rowCount() >0)
        {
            echo 'reload';
        }

    }






}


