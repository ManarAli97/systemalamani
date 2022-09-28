<?php


class range_table extends Controller
{


    function __construct()
    {
        parent::__construct();
        $this->table = 'range_table';
        $this->setting = new Setting();
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `from_amount` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `to_amount` varchar(250) COLLATE utf8_unicode_ci NOT NULL ,
          `amount` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `active` int(10) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table));

    }




    public function list_range_table()
    {
        $this->checkPermit('list_range_table', 'range_table');
        $this->adminHeaderController($this->langControl('range_table'));



        require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();
    }

    public function add_range_table()
    {
        $this->checkPermit('add', 'range_table');
        $this->adminHeaderController($this->langControl('add'));


        if (isset($_POST['submit'])) {
            try {
                $form = new Form();

                $form->post('from_amount')
                    ->val('is_array');
                $form->post('to_amount')
                    ->val('is_array');
                $form->post('amount')
                    ->val('is_array');


                $form->submit();
                $data = $form->fetch();

				$from_amount = json_decode($data['from_amount'], true);
				$to_amount = json_decode($data['to_amount'], true);
				$amount= json_decode($data['amount'], true);


                foreach ($from_amount as $key => $save_data) {
                    $stmt_s = $this->db->prepare("INSERT INTO `{$this->table}` (`from_amount`,`to_amount`,`amount`) VALUE (?,?,?)");
                    $stmt_s->execute(array($save_data,$to_amount[$key],$amount[$key]));
                }


               $this->lightRedirect(url . '/' . $this->folder . '/list_range_table', 0);
            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }

        }

        require($this->render($this->folder, 'html', 'add', 'php'));
        $this->adminFooterController();
    }


    public function processing_range_table()
    {

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(
            array('db' => 'from_amount', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),

            array('db' => 'to_amount', 'dt' =>1,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),


            array('db' => 'amount', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),



            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($id, $row) {

                        return "
                <div style='text-align: center'>
                  <input {$this->ch_range_table($id)} class='toggle-demo' onchange='visible_range_table(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
               ";

                }
            ),


            array(
                'db' => 'id',
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    if ($this->permit('edit', 'range_table')) {
                        return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'   data-toggle='modal' data-target='#exampleModal_edit' data-id='{$id}' data-from_amount='{$row[0]}'  data-to_amount='{$row[1]}'  data-amount='{$row[2]}'    >
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
                    if ($this->permit('delete', 'range_table')) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-from_amount='{$row[2]}'   >
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
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns )
        );

    }


    public function ch_range_table($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `active` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }


    public function visible_range_table($v_, $id_)
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


    function delete_range_table($id)
    {
        if ($this->handleLogin()) {

            $c = $this->db->prepare("DELETE FROM  `$this->table`  WHERE  `id`=?");
            $c->execute(array($id));


        }
    }

    function get_range_table($id)
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


    public function edit_range_table($id = null)
    {

        if ($this->handleLogin()) {
            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }
            $from_amount = strip_tags($_POST['from_amount']);
			$to_amount = strip_tags($_POST['to_amount']);
            $amount = strip_tags($_POST['amount']);

            $stmt = $this->db->update($this->table, array('from_amount' => $from_amount,'to_amount' => $to_amount,'amount' => $amount), "id={$id}");

        }

    }




    function getAllrange_table()
    {

        $stmt = $this->db->prepare("SELECT  *FROM  `$this->table`  WHERE  `active`=1 AND `lang`='{$this->langControl}' ");
        $stmt->execute();
        return $stmt;
    }


}









