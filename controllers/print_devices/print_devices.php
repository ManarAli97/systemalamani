<?php


class print_devices extends Controller
{

    public $ids = array();


    function __construct()
    {
        parent::__construct();
        $this->table = 'print_devices';
        $this->setting = new Setting();
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `active` int(10) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,  
          `userid` int(10) NOT NULL DEFAULT '0',
          
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table));

    }




    public function list_print_devices()
    {
        $this->checkPermit('list_print_devices', 'print_devices');
        $this->adminHeaderController($this->langControl('print_devices'));

        require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();
    }

    public function add_print_devices()
    {
        $this->checkPermit('add', 'print_devices');
        $this->adminHeaderController($this->langControl('add'));


        if (isset($_POST['submit'])) {
            try {
                $form = new Form();

                $form->post('title')
                    ->val('is_array', 'مطلوب');

                $form->submit();
                $data = $form->fetch();


                $title = json_decode($data['title'], true);


                foreach ($title as $key => $save_data) {
                    $stmt_s = $this->db->prepare("INSERT INTO `{$this->table}` (`title`,`userid`) VALUES (?,?)");
                    $stmt_s->execute(array(trim($save_data),$this->userid));
                }


                $this->lightRedirect(url . '/' . $this->folder . '/list_print_devices', 0);
            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }

        }

        require($this->render($this->folder, 'html', 'add', 'php'));
        $this->adminFooterController();
    }


    public function processing_print_devices()
    {

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(
            array('db' => 'title', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),


            array('db' => 'userid', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return $this->UserInfo($d);
                }
            ),



            array(
                'db' => 'id',
                'dt' => 2,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', 'print_devices')) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array('db' => 'id', 'dt' => 3)


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
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
        );

    }


    public function ch_print_devices($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `active` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }


    public function visible_print_devices($v_, $id_)
    {
        if ($this->handleLogin()) {
            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }
            $data = $this->db->update($this->table, array('active' => $v), "`id`={$id}");
        }
    }


    function delete_print_devices($id)
    {
        if ($this->handleLogin()) {

            $c = $this->db->prepare("DELETE FROM  `$this->table`  WHERE  `id`=?");
            $c->execute(array($id));
        }
    }

    function get_print_devices($id)
    {
        if ($this->handleLogin()) {
            $data = $this->db->select("SELECT * from `{$this->table}` WHERE `id`=:id ", array(':id' => $id));
            if (!empty($data)) {
                $data = $data[0];
                echo json_encode($data);
            } else {
                exit();
            }
        }


    }


    public function edit_print_devices($id = null)
    {

        if ($this->handleLogin()) {
            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }
            $title = $_POST['title'];
            $stmt = $this->db->update($this->table, array('title' => $title), "id={$id}");

        }

    }


}









