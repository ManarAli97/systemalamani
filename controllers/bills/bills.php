<?php

class Bills extends Controller
{


    function __construct()
    {
        parent::__construct();

        $this->bills = 'bills';
        $this->setting=new Setting();
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->bills}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT,
          `bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `amount` bigint(250) NOT NULL,
          `userid` int(11) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        return $this->db->cht(array($this->bills));

    }



    function index()
    {
        $this->checkPermit('view_bills','bills');
        $this->adminHeaderController($this->langControl('bills'));
        $total=0;


        $totime='';
        $fromtime='';
        $fromtime_stamp=null;
        $totime_stamp=null;
        if (isset($_GET['submit'])) {


            $totime = trim($_GET['todate']);
            $fromtime = trim($_GET['fromdate']);



            $fromtime_stamp = strtotime($fromtime);
            $totime_stamp = strtotime($totime);


            if ($this->type_user($this->userid))
            {

                $total= $this->sum_amount_date(null,$fromtime_stamp,$totime_stamp);
            }else
            {
                $total=  $this->sum_amount_date($this->userid,$fromtime_stamp,$totime_stamp);
            }


        }
         else
         {

             if ($this->type_user($this->userid))
             {

                 $total= $this->sum_amount();
             }else
             {
                 $total=  $this->sum_amount($this->userid);
             }

         }


        require ($this->render($this->folder,'html','view_bile','php'));
        $this->adminFooterController();

    }



    function sum_amount($id=null)
    {


        if ($id==null)
        {

            $stmt1 = $this->db->prepare("SELECT  SUM(`amount`) as amount FROM `{$this->bills}` ");
            $stmt1->execute();
           return $stmt1->fetch(PDO::FETCH_ASSOC)['amount'];
        }else
        {


            $stmt1 = $this->db->prepare("SELECT  SUM(`amount`) as amount FROM `{$this->bills}` WHERE `userid`=? ");
            $stmt1->execute(array($this->userid));
            return $stmt1->fetch(PDO::FETCH_ASSOC)['amount'];
        }
    }

    function sum_amount_date($id=null,$fromtime_stamp,$totime_stamp)
    {

        if ($id==null)
        {

            $stmt1 = $this->db->prepare("SELECT  SUM(`amount`) as amount FROM `{$this->bills}` WHERE (`date` >= {$fromtime_stamp} AND `date` <= {$totime_stamp})");
            $stmt1->execute();
           return $stmt1->fetch(PDO::FETCH_ASSOC)['amount'];
        }else
        {


            $stmt1 = $this->db->prepare("SELECT  SUM(`amount`) as amount FROM `{$this->bills}` WHERE `userid`=? AND (`date` >= {$fromtime_stamp} AND `date` <= {$totime_stamp})");
            $stmt1->execute(array($this->userid));
            return $stmt1->fetch(PDO::FETCH_ASSOC)['amount'];
        }
    }

    public function processing($fromtime_stamp =null ,$totime_stamp=null)
    {
        $this->checkPermit('list_bills','bills');
        $table = $this->bills;
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'bill', 'dt' => 0 ),
            array( 'db' => 'amount', 'dt' => 1,

                'formatter' => function( $d, $row ) {
                    return  number_format($d) .'  د.ع';
                }

            ),
            array( 'db' => 'userid', 'dt' =>  2,
                'formatter' => function( $d, $row ) {
                    return $this->name_user($d);
                }
            ),

            array( 'db' => 'date', 'dt' =>  3,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d ', $d);
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 4,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete','bills')) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='رقم الفاتورة  {$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(  'db' => 'id', 'dt'=>5)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        if ($fromtime_stamp==null && $totime_stamp == null)
        {

            if ($this->type_user($this->userid))
            {
                echo json_encode(
                    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )
                );

            }else
            {
                echo json_encode(
                    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"userid={$this->userid}" )
                );
            }
        }else{
            if ($this->type_user($this->userid))
            {
                echo json_encode(
                    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"(`date` >= {$fromtime_stamp} AND `date` <= {$totime_stamp})" )
                );

            }else
            {
                echo json_encode(
                    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"userid={$this->userid} AND (`date` >= {$fromtime_stamp} AND `date` <= {$totime_stamp})" )
                );
            }
        }



    }

    function name_user($id)
    {

        if ($this->handleLogin())
        {
            $stmtCods = $this->db->prepare("SELECT `username`FROM `user` WHERE id = ?    LIMIT 1");
            $stmtCods->execute(array($id));
            $result=$stmtCods->fetch(PDO::FETCH_ASSOC);
            return $result['username'];
        }

    }

    function type_user($id)
    {

        if ($this->handleLogin())
        {
            $stmtCods = $this->db->prepare("SELECT `username`FROM `user` WHERE id = ?  AND `role`='admin' LIMIT 1");
            $stmtCods->execute(array($id));
           if ($stmtCods->rowCount() > 0 )
           {
               return true;
           }else
           {
               return false;
           }

        }

    }

    function delete_bill($id)
    {
        $this->checkPermit('delete','bills');
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->bills, "`id`={$id}");
            echo 'true';
        }
    }






    function insert_bills()
    {
        $this->checkPermit('insert_bills','bills');
        $this->adminHeaderController($this->langControl('bills'));


        $save=false;

        $count_bill=0;

        $data['bill']='';
        $data['amount']='';
        if (isset($_POST['submit_x']))
        {
            try
            {
                $form =new  Form();

                $form  ->post('bill')
                    ->val('is_array')
                    ->val('strip_tags');

                $form  ->post('amount')
                    ->val('is_array')
                    ->val('strip_tags');


                $form ->submit();
                $data =$form -> fetch();
                $data['date']=time();


                $bill=json_decode($data['bill'],true);
                $amount=json_decode($data['amount'],true);


                foreach ($bill as $key => $save_data)
                {
                    $stmt=$this->db->prepare("INSERT INTO `{$this->bills}` (`bill`,`amount`,`userid`,`date`) VALUE (?,?,?,?)");
                    $stmt->execute(array($save_data, $amount[$key], $this->userid, $data['date']));

                }



                $count_bill=count($bill);
                $save=true;

            }catch (Exception $e)
            {
                $data['date']=strtotime($data['date']);
                $this->error_form= json_decode($e -> getMessage(),true);

            }



        }




        require ($this->render($this->folder,'html','insert_bill','php'));
        $this->adminFooterController();

    }








}