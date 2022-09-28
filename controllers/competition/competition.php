<?php
class Competition extends Controller
{
    function __construct()
    {
        parent::__construct();

        $this->table='answer_customer';
    }


    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `id_customer` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `id_q` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `id_ans` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `type_correct` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `correct` int(11) NOT NULL,
          `lang` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        return $this->db->cht(array($this->table));
    }


    function view_competition($id=0)
    {
        $this->checkPermit('view_competition','competition');

        $this->adminHeaderController($this->langControl('view_competition'));

        $data_q=array();

        $questions=new Questions();

        if ($id==0)
        {
            $stmt=$questions->select_q2();
            $rus=$stmt->fetch(PDO::FETCH_ASSOC) ;
            $id=$rus['id'];
        }


        $stmt=$questions->select_q_p();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            if ($row['id']==$id)
            {
                $row['select']='selected';
            }
            else
            {
                $row['select']='';
            }
            $data_q[]=$row;
        }



        require($this->render($this->folder, 'html', 'index', 'php'));
        $this->adminFooterController();

    }



    function view_competition2()
    {
        $this->checkPermit('view_competition','competition');

        $this->adminHeaderController($this->langControl('view_competition'));


        require($this->render($this->folder, 'html', 'index2', 'php'));
        $this->adminFooterController();

    }







    public function processing($id)
    {

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'id_customer', 'dt' => 0 ,

                'formatter' => function($id, $row ) {
                    return $this->customer_name($id);
                }

                ),
            array( 'db' => 'id_customer', 'dt' => 1,

                'formatter' => function($id, $row ) {
                    return $this->customer_phone($id);
                }

            ),
            array( 'db' => 'correct', 'dt' => 2  ,

                'formatter' => function($id, $row ) {
                    return $this->type_answer($id);
                }

            ),
            array( 'db' => 'type_correct', 'dt' => 3 ),

            array( 'db' => 'id_ans', 'dt' => 4 ,

                'formatter' => function($id, $row ) {
                    return $this->answer($id);
                }

            ),

            array( 'db' => 'date', 'dt' =>5 ,
                'formatter' => function($id, $row ) {
                    return date('Y-m-d h:i:s A', $id);
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 6,
                'formatter' => function($id, $row ) {
                    return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                }
            ),
            array(  'db' => 'id', 'dt'=>7)


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
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"id_q={$id}")
        );

    }


    public function processing2()
    {

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'id_customer', 'dt' => 0 ,

                'formatter' => function($id, $row ) {
                    return $this->customer_name($id);
                }

                ),
            array( 'db' => 'id_customer', 'dt' => 1,

                'formatter' => function($id, $row ) {
                    return $this->customer_phone($id);
                }

            ),
            array( 'db' => 'correct', 'dt' => 2  ,

                'formatter' => function($id, $row ) {
                    return $this->type_answer($id);
                }

            ),
            array( 'db' => 'type_correct', 'dt' => 3 ),

            array( 'db' => 'id_ans', 'dt' => 4 ,

                'formatter' => function($id, $row ) {
                    return $this->answer($id);
                }

            ),

            array( 'db' => 'date', 'dt' =>5 ,
                'formatter' => function($id, $row ) {
                    return date('Y-m-d h:i:s A', $id);
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 6,
                'formatter' => function($id, $row ) {
                    return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                }
            ),
            array(  'db' => 'id', 'dt'=>7)


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
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,"`correct`=1 AND `type_correct`='اجابة صحيحة' AND ( `id_q` >= 23  AND  `id_q` <= 29  )")
        );

    }



    function customer_name($id)
    {

        if ($this->handleLogin())
        {
            $stmtCods = $this->db->prepare("SELECT `name`FROM `register_user` WHERE id = ?    LIMIT 1");
            $stmtCods->execute(array($id));
            $result=$stmtCods->fetch(PDO::FETCH_ASSOC);
            return $result['name'];
        }

    }



    function customer_phone($id)
    {

        if ($this->handleLogin())
        {
            $stmtCods = $this->db->prepare("SELECT `phone` FROM `register_user` WHERE id = ?    LIMIT 1");
            $stmtCods->execute(array($id));
            $result=$stmtCods->fetch(PDO::FETCH_ASSOC);
            return $result['phone'];
        }

    }

    function type_answer($id)
    {
        if ($id==1)
        {
            return  "<i style='color: green' class='fa fa-check-circle'></i>";
        }else{
            return  "<i style='color: red' class='fa fa-times-circle'></i>";
        }
    }

    function answer($id)
    {

        if ($this->handleLogin())
        {
            $stmtCods = $this->db->prepare("SELECT `answer` FROM `answer` WHERE id = ?    LIMIT 1");
            $stmtCods->execute(array($id));
            $result=$stmtCods->fetch(PDO::FETCH_ASSOC);
            return $result['answer'];
        }

    }




    public function lot($id)
    {
        $this->checkPermit('lot_electro','competition');
        $this->adminHeaderController($this->langControl('lot_electro'));

        $stmt = $this->db->prepare("SELECT   *FROM `questions` where  `id` =?  ORDER BY `id` DESC  LIMIT 1");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);



        require($this->render($this->folder, 'html', 'lot', 'php'));
        $this->adminFooterController();
    }



    public function select_win($id)
    {
        $stmt = $this->db->prepare("SELECT *FROM $this->table WHERE `id_q`=$id  AND  `correct`=1 ORDER BY RAND() LIMIT 7; ");
        $stmt->execute(array($id));
        $result=array();
        if ($stmt ->rowCount() > 0)
        {
         while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
         {

             $row['name']=$this->customer_name($row['id_customer']);
             $row['phone']=$this->customer_phone($row['id_customer']);
             $row['correct']=$this->type_answer($row['correct']);
             $row['id_ans']=$this->answer($row['id_ans']);
             $row['date']=date('Y-m-d h:i:s A', $row['date']);

             $result[]=$row;
         }

        }

        require($this->render($this->folder, 'html', 'ajax', 'php'));
    }


    public function campaign_name($id)
    {
        $campaigns =  new Campaigns();
        return $campaigns->campaign_name_from_model($id);
    }


    public function delete($id)
    {

        $response = $this->db->delete($this->table,"`id`={$id}");
        echo $response;


    }



}