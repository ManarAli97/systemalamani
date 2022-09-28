<?php


trait case_serial
{


    function __construct()
    {
        parent::__construct();
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject

    }


    function selling_mismatched_serial()
    {
        $this->checkPermit('selling_mismatched_serial',$this->folder);

        $this->adminHeaderController($this->langControl('selling_mismatched_serial'));

        require ($this->render($this->folder,'case_serial/html','case1','php'));
        $this->adminFooterController();

    }



    public function processing_selling_mismatched_serial()
    {


        $table ='serial_case_1';

        $primaryKey = $table.'.id';
        $columns = array(
            array( 'db' => $table.'.model', 'dt' => 0 ),
            array( 'db' => $table.'.code', 'dt' => 1 ),
            array( 'db' => $table.'.serial', 'dt' => 2 ),
            array( 'db' => $table.'.number_bill', 'dt' => 3 ),
            array( 'db' => 'user.username', 'dt' => 4 ,
                'formatter' => function ($id, $row) {
                    return  $id;
                }
            ),

            array( 'db' => $table.'.date', 'dt' => 5 ,
                'formatter' => function ($id, $row) {
                    return  date('Y-m-d h:i:s A ',$id);
                }
            ),

            array( 'db' =>  $table.'.id', 'dt' => 6 ,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_selling_mismatched_serial',$this->folder))
                    {

                        return '
                          <button class="btn btn-danger" onclick="delete_selling_mismatched_serial('.$id.')"  type="button"  ><i class="fa fa-trash"></i> </button>   
                    ';
                    }
                }
            ),

            array(  'db' =>   $table.'.id', 'dt'=> 7)


        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = " INNER JOIN user ON user.id ={$table}.userId ";
        $whereAll = array("");


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));


    }




    function delete_selling_mismatched_serial($id)
    {
        if ($this->handleLogin())
        {
            $stmt  = $this->db->prepare("DELETE FROM serial_case_1 WHERE id=?");
            $stmt ->execute(array($id));

            echo 'true';
        }

    }


    function serial_over_enter_quantity()
    {
        $this->checkPermit('serial_over_enter_quantity',$this->folder);

        $this->adminHeaderController($this->langControl('serial_over_enter_quantity'));

        require ($this->render($this->folder,'case_serial/html','case2','php'));
        $this->adminFooterController();

    }



    public function processing_serial_over_enter_quantity()
    {


        $table ='serial_case_2';

        $primaryKey = $table.'.id';
        $columns = array(
            array( 'db' => $table.'.page', 'dt' => 0 ),
            array( 'db' => $table.'.model', 'dt' => 1 ),
            array( 'db' => $table.'.code', 'dt' => 2 ),
            array( 'db' => $table.'.serial', 'dt' => 3 ),
            array( 'db' => $table.'.bill', 'dt' => 4 ),
            array( 'db' => $table.'.location', 'dt' => 5 ),
            array( 'db' => 'user.username', 'dt' => 6 ,
                'formatter' => function ($id, $row) {
                    return  $id;
                }
            ),

            array( 'db' => $table.'.date', 'dt' => 7 ,
                'formatter' => function ($id, $row) {
                    return  date('Y-m-d h:i:s A ',$id);
                }
            ),

            array( 'db' =>  $table.'.id', 'dt' => 8 ,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_serial_over_enter_quantity',$this->folder))
                    {

                        return '
                          <button class="btn btn-danger" onclick="delete_serial_over_enter_quantity('.$id.')"  type="button"  ><i class="fa fa-trash"></i> </button>   
                    ';
                    }
                }
            ),

            array(  'db' =>   $table.'.id', 'dt'=> 9)


        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = " INNER JOIN user ON user.id ={$table}.userId ";
        $whereAll = array("");


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));


    }




    function delete_serial_over_enter_quantity($id)
    {
        if ($this->handleLogin())
        {
            $stmt  = $this->db->prepare("DELETE FROM serial_case_2 WHERE id=?");
            $stmt ->execute(array($id));

            echo 'true';
        }

    }








}

