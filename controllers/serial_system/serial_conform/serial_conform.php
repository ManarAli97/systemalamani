<?php

trait serial_conform
{



    function __construct()
    {
        parent::__construct();
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject

    }





    function list_serial_conform()
    {

        $this->checkPermit('serial_conform',$this->folder);

        $this->adminHeaderController($this->langControl($this->folder));
        $model='mobile';

        if (isset($_GET['model']))
        {
            $model=trim($_GET['model']);
        }


        require ($this->render($this->folder,'serial_conform/html','index','php'));
        $this->adminFooterController();

    }




    public function processing_serial_conform($model='mobile')
    {



        if ($model=='accessories')
        {


            $table ='serial_conform';


            $primaryKey = $table.'.id';

            $columns = array(

                array( 'db' => $model.'.title', 'dt' => 0 ),
                array( 'db' => 'color_accessories.color', 'dt' => 1 ),
                array( 'db' => 'color_accessories.id', 'dt' => 2 ,
                    'formatter' => function ($id, $row) {
                        return  '';
                    }
                ),
                array( 'db' => $table.'.code', 'dt' => 3 ),
                array( 'db' => $table.'.type', 'dt' => 4 ),

                array(  'db' =>   $table.'.id', 'dt'=> 5)


            );

            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASS,
                'db'   => DB_NAME,
                'host' => DB_HOST,
                'charset' => 'utf8'
            );





            $join = " INNER JOIN  color_accessories ON color_accessories.code = {$table}.code  INNER JOIN  {$model} ON {$model}.id=color_accessories.id_item LEFT JOIN serial  ON serial.code = {$table}.code";
            $whereAll =  array("{$table}.model = '{$model}'","serial.code IS NULL ");
            $group = "GROUP BY {$table}.code";


            echo json_encode(

                SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,1));


        }else if ($model=='savers')
        {



            $table ='serial_conform';

            $primaryKey = $table.'.id';

            $columns = array(

                array( 'db' =>  'product_savers.title', 'dt' => 0 ),
                array( 'db' =>  'product_savers.color', 'dt' => 1 ),
                array( 'db' => $table.'.id', 'dt' => 2 ,
                    'formatter' => function ($id, $row) {
                        return  '';
                    }
                ),
                array( 'db' => $table.'.code', 'dt' => 3 ),

                array( 'db' => $table.'.type', 'dt' => 4 ),

                array(  'db' =>   $table.'.id', 'dt'=> 5)


            );

            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASS,
                'db'   => DB_NAME,
                'host' => DB_HOST,
                'charset' => 'utf8'
            );



            $join = " INNER  JOIN product_savers  ON product_savers.code = {$table}.code LEFT JOIN serial  ON serial.code = {$table}.code";
            $whereAll =  array("{$table}.model = '{$model}'","serial.code IS NULL ");
            $group = "GROUP BY {$table}.code";
            echo json_encode(
                SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,1));


        }else{

            $table ='serial_conform';
            if ($model == 'mobile')
            {
                $code='code';
                $color='color';

            }else
            {

                $code='code_'.$model;
                $color='color_'.$model;

            }

            $primaryKey = $table.'.id';

            $columns = array(
                array( 'db' => $model.'.title', 'dt' => 0 ),
                array( 'db' => $color.'.color', 'dt' => 1 ),
                array( 'db' => $code.'.size', 'dt' => 2 ),
                array( 'db' => $table.'.code', 'dt' => 3 ),
                array( 'db' => $table.'.type', 'dt' => 4 ),
                array(  'db' =>   $table.'.id', 'dt'=> 5)
            );

            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASS,
                'db'   => DB_NAME,
                'host' => DB_HOST,
                'charset' => 'utf8'
            );



            $join = "INNER JOIN  {$code} ON  {$code}.code={$table}.code INNER JOIN  {$color} ON  {$color}.id={$code}.id_color INNER JOIN  {$model} ON {$model}.id={$color}.id_item LEFT JOIN serial  ON serial.code = {$table}.code";
            $whereAll =  array("{$table}.model = '{$model}'","serial.code IS NULL ");
            $group = "GROUP BY {$table}.code";

            echo json_encode(

                SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,1));


        }



    }










}