<?php


class group_location extends Controller
{

    public $ids = array();


    function __construct()
    {
        parent::__construct();
        $this->table = 'group_location';
        $this->setting = new Setting();
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `from` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `to` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `active` int(10) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table));

    }




    public function list_group_location()
    {
        $this->checkPermit('list_group_location', 'group_location');
        $this->adminHeaderController($this->langControl('group_location'));

        require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();
    }

    public function add_group_location()
    {
        $this->checkPermit('add', 'group_location');
        $this->adminHeaderController($this->langControl('add'));


        if (isset($_POST['submit'])) {
            try {
                $form = new Form();

                $form->post('title')
                    ->val('is_array', 'مطلوب');

                $form->post('from')
                    ->val('is_array', 'مطلوب');

                $form->post('to')
                    ->val('is_array', 'مطلوب');

                $form->submit();
                $data = $form->fetch();
                $file = new Files();

                $title = json_decode($data['title'], true);
                $from = json_decode($data['from'], true);
                $to = json_decode($data['to'], true);


                foreach ($title as $key => $save_data) {
                    $stmt_s = $this->db->prepare("INSERT INTO `{$this->table}` (`title`,`from`,`to`,`date`) VALUE (?,?,?,?)");
                    $stmt_s->execute(array($save_data,$from[$key],$to[$key],time()));
                }


                $this->lightRedirect(url . '/' . $this->folder . '/list_group_location', 0);
            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }

        }

        require($this->render($this->folder, 'html', 'add', 'php'));
        $this->adminFooterController();
    }


    public function processing_group_location()
    {

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(
            array('db' => 'title', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),

            array('db' => 'from', 'dt' => 1 ),

            array('db' => 'to', 'dt' => 2 ),


            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    if ($this->permit('add', 'group_location')) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_group_location($id)} class='toggle-demo' onchange='visible_group_location(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),


            array(
                'db' => 'id',
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    if ($this->permit('edit', 'group_location')) {
                        return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'   data-toggle='modal' data-target='#exampleModal_edit' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-edit' aria-hidden='true'></i></i>
                         </button>
                    </div>
                   
                    ";
                    } else {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),


            array(
                'db' => 'id',
                'dt' => 5,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', 'group_location')) {
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
            array('db' => 'id', 'dt' => 6)


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


    public function ch_group_location($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `active` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }


    public function visible_group_location($v_, $id_)
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


    function delete_group_location($id)
    {
        if ($this->handleLogin()) {

            $c = $this->db->prepare("DELETE FROM  `$this->table`  WHERE  `id`=?");
            $c->execute(array($id));
        }
    }

    function get_group_location($id)
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


    public function edit_group_location($id = null)
    {

        if ($this->handleLogin()) {
            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }
            $title = $_POST['title'];
            $from = $_POST['from'];
            $to = $_POST['to'];
            $stmt = $this->db->update($this->table, array('title' => $title,'from'=>$from,'to'=>$to), "id={$id}");

        }

    }


}









