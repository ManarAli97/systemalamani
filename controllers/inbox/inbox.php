<?php
class Inbox extends Controller
{
function __construct()
{
parent::__construct();


}


      function view_inbox()
         {
             $this->checkPermit('view_inbox','inbox');
            $this->adminHeaderController($this->langControl('view_inbox'));

          require($this->render($this->folder, 'html', 'index', 'php'));
        $this->adminFooterController();

    }



    public function processing()
    {


        $table = 'message';
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'id_r', 'dt' => 0 ,
                'formatter' => function( $d, $row ) {
                    return  $this->costomer_name($d,$row[5]) ;
                }
            ),
            array( 'db' => 'id_r', 'dt' => 1 ,
                'formatter' => function( $d, $row ) {
                    return  $this->costomer_phone($d,$row[5]) ;
                }

            ),

            array( 'db' => 'date', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d ', $d);
                }
            ),
            array( 'db' => 'message', 'dt' => 3 ),

            array(
                'db'        => 'id',
                'dt'        => 4,
                'formatter' => function($id, $row ) {
                    return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}' data-role='{$row[2]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
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
        echo json_encode(
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns)
        );

    }


    function costomer_name($id,$row=0)
    {

        if ($this->handleLogin())
        {
            if ($id !=0)
            {
                $stmtCods = $this->db->prepare("SELECT `name`FROM `register_user` WHERE id = ?    LIMIT 1");
                $stmtCods->execute(array($id));
                $result=$stmtCods->fetch(PDO::FETCH_ASSOC);
                return $result['name'];
            }else {

                $stmtCods = $this->db->prepare("SELECT `userid`FROM `message` WHERE id = ?    LIMIT 1");
                $stmtCods->execute(array($row));
                $result=$stmtCods->fetch(PDO::FETCH_ASSOC);


                $stmtUser= $this->db->prepare("SELECT `username`FROM `user` WHERE id = ?    LIMIT 1");
                $stmtUser->execute(array($result['userid']));
                if ($stmtUser->rowCount() > 0)
                {
                    $resultUser=$stmtUser->fetch(PDO::FETCH_ASSOC);
                    return "<span style='background: green;border-radius: 15px;padding: 0 16px;color: #ffffff' title='شكوى من ادمن'>{$resultUser['username']}</span>";
                }else{
                    return $this->langControl('unknown_person');
                }



            }

        }

    }


    function costomer_phone($id,$row=0)
    {

        if ($this->handleLogin())
        {
            if ($id !=0)
            {
            $stmtCods = $this->db->prepare("SELECT `phone` FROM `register_user` WHERE id = ?    LIMIT 1");
            $stmtCods->execute(array($id));
            $result=$stmtCods->fetch(PDO::FETCH_ASSOC);
            return $result['phone'];
            }else{
                $stmtCods = $this->db->prepare("SELECT `userid`FROM `message` WHERE id = ?    LIMIT 1");
                $stmtCods->execute(array($row));
                $result=$stmtCods->fetch(PDO::FETCH_ASSOC);


                $stmtUser= $this->db->prepare("SELECT `username`FROM `user` WHERE id = ?    LIMIT 1");
                $stmtUser->execute(array($result['userid']));
                if ($stmtUser->rowCount() > 0)
                {
                    $resultUser=$stmtUser->fetch(PDO::FETCH_ASSOC);
                    return "<span style='background: green;border-radius: 15px;padding:0 16px;color: #ffffff' title='شكوى من ادمن'>{$resultUser['username']}</span>";
                }else{
                    return $this->langControl('unknown_person');
                }


            }
        }

    }


public function delete($id)
{
    if ($this->handleLogin()) {
        $response = $this->db->delete('message', "`id`={$id}");
    }

}



}