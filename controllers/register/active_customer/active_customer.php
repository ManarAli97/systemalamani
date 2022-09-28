<?php

trait active_customer
{



    function __construct()
    {
        parent::__construct();
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject

    }


    public function active()
    {
        $this->checkPermit('active_customer','register');
        $this->adminHeaderController($this->langControl('active_customer'));


        $count=0;
        $stmt=$this->db->prepare("SELECT COUNT(id) as  c FROM register_session_customer WHERE     active = 1");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['c'];
        }


        require ($this->render($this->folder,'active_customer/html','index','php'));
        $this->adminFooterController();
    }


    public function count_active()
    {
        $count=0;
        $stmt=$this->db->prepare("SELECT COUNT(id) as  c FROM register_session_customer WHERE     active = 1");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['c'];
        }

        echo $count;
    }




    public function processing_active_customer()
    {


        $this->checkPermit('active_customer', 'register');

        $table = 'register_session_customer';
        $primaryKey = 'register_user.id';

        $columns = array(

            array('db' => 'register_user.name', 'dt' => 0),
            array('db' => 'register_user.title', 'dt' => 1),
            array('db' => 'register_user.phone', 'dt' => 2),
            array('db' => 'register_user.city', 'dt' => 3),
            array('db' => 'register_user.address', 'dt' => 4),
            array('db' => 'register_user.gander', 'dt' => 5),
            array('db' => 'register_user.birthday', 'dt' => 6),

            array('db' => 'register_session_customer.date', 'dt' => 7,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s A',$id);
                }
            ),



            array('db' => 'register_session_customer.active', 'dt' => 8,
                'formatter' => function ($id, $row) {
                if ($id == 1)
                {
                    return ' <i class="fa fa-circle" style="color: #0a7817" ></i>';

                }else
                {
                    return ' <i class="fa fa-circle" style="color: #b60519" ></i>';

                }
                }

            ),

            array('db' => 'register_session_customer.count_login', 'dt' => 9),
            array('db' => 'register_session_customer.screen', 'dt' => 10),
            array('db' => 'register_user.id', 'dt' =>11,
                'formatter' => function ($id, $row)
                {
                    if ($this->permit('notes_about_customer',$this->folder)) {

                        return "<button class='btn btn-primary btn-sm' onclick='get_note({$id})'>ملاحظات </button>";
                    } else
                    {
                        return $this->langControl('forbidden');
                    }

                }
            ),
            array('db' => 'register_user.id', 'dt' => 12),



        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );



        $join = " inner JOIN register_user ON register_user.id = register_session_customer.id_customer  ";
        $whereAll = array("");

        echo json_encode(

        SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));



    }

    function date_active_customer()
    {


        $stmt=$this->db->prepare("SELECT id,active FROM register_session_customer WHERE `date` >  date_active_now  OR date_active_now < last_date_active     ORDER BY `date` DESC LIMIT 1");
        $stmt->execute();
        if ($stmt->rowCount() > 0)
        {

            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            $stmtUpdate=$this->db->prepare("UPDATE  register_session_customer SET  date_active_now=?  WHERE id=?");
            $stmtUpdate->execute(array(time()+1,$result['id']));

            if ($result['active']==1)
            {
                echo 'login';
            }else
            {
                echo 'logout';
            }

        }

    }




}