<?php

class note_user extends Controller
{



    function __construct()
    {
        parent::__construct();
        $this->table='note_user';
     
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `id_customer` int(20) NOT NULL,
          `name_customer` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `note` longtext COLLATE utf8_unicode_ci NOT NULL,
          `choose` longtext COLLATE utf8_unicode_ci NOT NULL,
           `userid` int(20) NOT NULL,
           `user_group` int(20) NOT NULL,
           `date` bigint(20) NOT NULL,

           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return  $this->db->cht(array($this->table));

    }

    public function index(){ $index =new Index(); $index->index();}






    public function list_note_user($id=0)
    {
        $this->checkPermit('list_note_user','note_user');
        $this->adminHeaderController($this->langControl('note_user'));



        $stmt = $this->db->prepare("SELECT usergroup.id,usergroup.name  from note_user INNER JOIN usergroup ON usergroup.id=note_user.user_group WHERE 1 GROUP BY user_group   ");
        $stmt->execute();

        $group=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $group[]=$row;
        }




            require ($this->render($this->folder,'html','list','php'));
        $this->adminFooterController();

    }





    public function processing($id=0)
    {

        $table = $this->table;
        $primaryKey = $this->table.'.id';

        $columns = array(

            array('db' =>$this->table.'.name_customer', 'dt' => 0,
                'formatter' => function( $d, $row ) {

                    return  $d ;
                }
            ),

            array('db' => 'register_user.title', 'dt' => 1),
            array('db' => 'register_user.phone', 'dt' => 2),
            array('db' => 'register_user.city', 'dt' => 3),
            array('db' => 'register_user.address', 'dt' => 4),
            array('db' => 'register_user.gander', 'dt' => 5),
            array('db' => 'register_user.birthday', 'dt' => 6),
            array('db' => $this->table.'.id_customer', 'dt' =>7,
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


            array('db' =>$this->table.'.date', 'dt' => 8,
                'formatter' => function( $d, $row ) {

                    return date('Y-m-d h:i:s a',$d);
                }
            ),
            array(  'db' => $this->table.'.id', 'dt'=>9)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        if ($id==0)
        {
            $join = " INNER JOIN register_user ON register_user.id = note_user.id_customer ";
            $whereAll = array("");
        }else
        {
            $join = "  INNER JOIN register_user ON register_user.id = note_user.id_customer  ";
            $whereAll = array("note_user.user_group={$id} ");
        }

        $group="GROUP BY  note_user.id_customer";



        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));


    }


    function save_note()
    {
        if ($this->handleLogin())
        {

            $name=strip_tags(trim($_POST['name']));
            $id=strip_tags(trim($_POST['id']));
            $note=strip_tags(trim($_POST['note']));
            $stmt=$this->db->prepare("INSERT INTO  note_user ( id_customer, name_customer, note, userid,user_group, `date`) VALUES (?,?,?,?,?,?) ");
            $stmt->execute(array($id,$name,$note,$this->userid,$this->idGroup,time()));
            if ($stmt->rowCount()>0)
            {
                echo 'true';
            }
        }
    }


    function get_note_customer($id)
    {
        if ($this->handleLogin())
        {

            $notes=array();
            $stmt = $this->db->prepare("SELECT  note_user.name_customer,note_user.note,note_user.date,user.username,usergroup.name  FROM `note_user` INNER JOIN user ON user.id =note_user.userid  INNER JOIN usergroup ON usergroup.id = note_user.user_group WHERE note_user.`id_customer`=? ORDER BY note_user.`date` DESC ");
            $stmt->execute(array($id));
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $notes[]=$row;
            }

            require($this->render($this->folder, 'html', 'notes', 'php'));

        }

    }


}