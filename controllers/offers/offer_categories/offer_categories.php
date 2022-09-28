<?php


trait offer_categories
{


    function __construct()
    {
        parent::__construct();

        $this->setting = new Setting();
    }





    public function list_offer_categories()
    {
        $this->checkPermit('list_offer_categories', $this->folder);
        $this->adminHeaderController($this->langControl($this->folder));



        require($this->render($this->folder, 'offer_categories/html', 'list', 'php'));
        $this->adminFooterController();
    }

    public function add_offer_categories()
    {
        $this->checkPermit('add_offer_categories', $this->folder);
        $this->adminHeaderController($this->langControl('add'));


        if (isset($_POST['submit'])) {
            try {
                $form = new Form();

                $form->post('title')
                    ->val('is_array');


                $form->submit();
                $data = $form->fetch();

                $title = json_decode($data['title'], true);



                foreach ($title as $key => $save_data) {
                    $stmt_s = $this->db->prepare("INSERT INTO `{$this->offer_categories}` (`title`,`userid`,`date`) VALUE (?,?,?)");
                    $stmt_s->execute(array($save_data,$this->userid,time()));
                
                	$id =  $this->db->lastInsertId();
                	$this->Add_to_sync_schedule($id,"offer_categories","offer_categories");
                }


                $this->lightRedirect(url . '/' . $this->folder . '/list_offer_categories', 0);
            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }

        }

        require($this->render($this->folder, 'offer_categories/html', 'add', 'php'));
        $this->adminFooterController();
    }


    public function processing_offer_categories()
    {

        $table = $this->offer_categories;
        $primaryKey = 'id';

        $columns = array(
            array('db' => 'title', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return strip_tags($d);
                }
            ),


            array('db' => 'date', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d',$d);
                }
            ),



            array(
                'db' => 'id',
                'dt' => 2,
                'formatter' => function ($id, $row) {

                    return "
                <div style='text-align: center'>
                  <input {$this->ch_offer_categories($id)} class='toggle-demo' onchange='visible_offer_categories(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
               ";

                }
            ),


            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    if ($this->permit('edit_offer_categories', $this->folder)) {
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
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_offer_categories', $this->folder)) {
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

            array('db' => 'id', 'dt' => 5)


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


    public function ch_offer_categories($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->offer_categories} WHERE `id` = ? AND `active` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }


    public function visible_offer_categories($v_, $id_)
    {
        if ($this->handleLogin()) {
            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }
            $data = $this->db->update($this->offer_categories, array('active' => $v), "`id`={$id}");
            $this->Add_to_sync_schedule($id,"offer_categories","offer_categories");

        }
    }


    function delete_offer_categories($id)
    {
        if ($this->handleLogin()) {

            $c = $this->db->prepare("DELETE FROM  `$this->offer_categories`  WHERE  `id`=?");
            $c->execute(array($id));
            $this->Add_to_sync_schedule($id,"offer_categories","delete_offer_categories");



        }
    }

    function get_offer_categories($id)
    {
        if ($this->handleLogin()) {
            $data = $this->db->select("SELECT * from `{$this->offer_categories}` WHERE `id`=:id ", array(':id' => $id));
            if (!empty($data)) {
                $data = $data[0];
                echo json_encode($data);
            } else {
                exit();
            }
        }


    }


    public function edit_offer_categories($id = null)
    {

        if ($this->handleLogin()) {
            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }
            $title = strip_tags($_POST['title']);


            $stmt = $this->db->update($this->offer_categories, array('title' => $title,'userid' => $this->userid,'date' => time()), "id={$id}");
            $this->Add_to_sync_schedule($id,"offer_categories","offer_categories");


        }

    }




    function getAlloffer_categories()
    {

        $stmt = $this->db->prepare("SELECT  *FROM  `$this->offer_categories`  WHERE  `active`=1 AND `lang`='{$this->langControl}' ");
        $stmt->execute();
        return $stmt;
    }


}









