<?php

trait report_serial_cases
{



    function __construct()
    {
        parent::__construct();
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject

    }





    function list_report_serial_cases1()
    {

        $this->checkPermit('report_serial_cases1',$this->folder);

        $this->adminHeaderController($this->langControl($this->folder));
        $model='mobile';

        if (isset($_GET['model']))
        {
            $model=trim($_GET['model']);
        }


        require ($this->render($this->folder,'report_serial_cases/html','case_1','php'));
        $this->adminFooterController();

    }




    public function processing_case_1($model='mobile')
    {



        if ($model=='accessories')
        {


                $table ='color_accessories';


            $primaryKey = $table.'.id';

            $columns = array(

                array( 'db' => $model.'.title', 'dt' => 0 ),
                array( 'db' => $table.'.color', 'dt' => 1 ),
                array( 'db' => $table.'.id', 'dt' => 2 ,
                    'formatter' => function ($id, $row) {
                        return  '';
                    }
                    ),
                array( 'db' => $table.'.code', 'dt' => 3 ),

                array(  'db' =>   $table.'.id', 'dt'=> 4)


            );

            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASS,
                'db'   => DB_NAME,
                'host' => DB_HOST,
                'charset' => 'utf8'
            );





            $join = " INNER JOIN  {$model} ON {$model}.id={$table}.id_item LEFT JOIN serial  ON serial.code = {$table}.code ";
            $whereAll = array("serial.code IS NULL ");
            $group = "GROUP BY {$table}.code";

            echo json_encode(

                SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,1));


        }else if ($model=='savers')
         {



             $table ='product_savers';


             $primaryKey = $table.'.id';

             $columns = array(

                 array( 'db' => $table.'.title', 'dt' => 0 ),
                 array( 'db' => $table.'.color', 'dt' => 1 ),
                 array( 'db' => $table.'.id', 'dt' => 2 ,
                     'formatter' => function ($id, $row) {
                         return  '';
                     }
                 ),
                 array( 'db' => $table.'.code', 'dt' => 3 ),

                 array(  'db' =>   $table.'.id', 'dt'=> 4)


             );

             $sql_details = array(
                 'user' => DB_USER,
                 'pass' => DB_PASS,
                 'db'   => DB_NAME,
                 'host' => DB_HOST,
                 'charset' => 'utf8'
             );





             $join = "  LEFT JOIN serial  ON serial.code = {$table}.code ";
             $whereAll = array("serial.code IS NULL ");
             $group = "GROUP BY {$table}.code";

             echo json_encode(

                 SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,1));



         }else{

            if ($model == 'mobile')
            {
                $table ='code';
                $code_table=$table;
                $color='color';

            }else
            {
                $table ='code_'.$model;
                $code_table=$table;
                $color='color_'.$model;

            }

            $primaryKey = $table.'.id';

            $columns = array(
                array( 'db' => $model.'.title', 'dt' => 0 ),
                array( 'db' => $color.'.color', 'dt' => 1 ),
                array( 'db' => $table.'.size', 'dt' => 2 ),
                array( 'db' => $table.'.code', 'dt' => 3 ),
                array(  'db' =>   $table.'.id', 'dt'=> 4)


            );

            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASS,
                'db'   => DB_NAME,
                'host' => DB_HOST,
                'charset' => 'utf8'
            );



            $join = "INNER JOIN  {$color} ON  {$color}.id={$code_table}.id_color INNER JOIN  {$model} ON {$model}.id={$color}.id_item LEFT JOIN serial  ON serial.code = {$table}.code ";
            $whereAll = array("serial.code IS NULL ");
            $group = "GROUP BY {$table}.code";

            echo json_encode(

                SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,1));


        }



    }










}