<?php

class staff_evaluation extends Controller
{



    function __construct()
    {
        parent::__construct();
        $this->table='staff_evaluation';
        $this->menu=new Menu();
    }

    public function createTB()
    {


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `id_customer` int(10) NOT NULL,
           `number_employee` int(10) NOT NULL,
           `number_smile` int(10) NOT NULL,
           `note` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return  $this->db->cht(array($this->table));

    }

    public function index(){ $index =new Index(); $index->index();}






    public function list_staff_evaluation()
    {
        $this->checkPermit('list_staff_evaluation','staff_evaluation');
        $this->adminHeaderController($this->langControl('staff_evaluation'));

        require ($this->render($this->folder,'html','list','php'));
        $this->adminFooterController();

    }





    public function processing()
    {

        $table = $this->table;
        $primaryKey = $this->table.'.id';

        $columns = array(

            array( 'db' => 'user.username', 'dt' => 0 ),

            array('db' =>$this->table.'.id_customer', 'dt' => 1,
                'formatter' => function( $d, $row ) {

                    return $this->customerInfo($d);
                }
            ),

            array('db' =>$this->table.'.number_smile', 'dt' => 2,
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

            array( 'db' => $this->table.'.note', 'dt' => 3 ),

            array('db' =>$this->table.'.date', 'dt' => 4,
                'formatter' => function( $d, $row ) {

                    return date('Y-m-d h:i:s a',$d);
                }
            ),
            array(  'db' => $this->table.'.id', 'dt'=>5)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = " LEFT JOIN user ON user.number = staff_evaluation.number_employee ";
        $whereAll = array("");


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));


    }


    function add()
    {

        if (isset($_SESSION['username_member_r']))
        {

            $number=strip_tags(trim($_POST['number']));
            $number_smile=strip_tags(trim($_POST['number_smile']));
            $note=strip_tags(trim($_POST['note']));

            $stmtc=$this->db->prepare("SELECT id FROM user WHERE number=?");
            $stmtc->execute(array($number));
            if ($stmtc->rowCount() > 0 )
            {


            $stmt=$this->db->prepare("INSERT INTO {$this->table} (`id_customer`,`number_employee`,`number_smile`,`note`,`date`) VALUES (?,?,?,?,?) ");
            $stmt->execute(array($_SESSION['id_member_r'],$number,$number_smile,$note,time()));
            if ($stmt->rowCount() > 0)
            {
                echo 'true';
            }else
            {
                echo 'login';
            }

        }else
            {
                echo 'number';
            }
        }else
        {
            echo 'login';
        }

    }



}