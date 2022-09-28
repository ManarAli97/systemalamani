<?php
trait feature_cover

{




    public function list_feature_cover()
    {

        $this->checkPermit('feature_cover', 'savers');
        $this->adminHeaderController($this->langControl('feature_cover'));

        require($this->render($this->folder, 'feature_cover', 'html/list', 'php'));
        $this->adminFooterController();

    }

    public function add_feature_cover()
    {


        $this->checkPermit('add_feature_cover', 'savers');
        $this->adminHeaderController($this->langControl('add_feature_cover'));

        $category = $this->db->select("SELECT * from `{$this->table}` ");


        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();



                $form->post('feature_cover')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('number')
                    ->val('is_array')
                    ->val('strip_tags');



                $form->submit();
                $data = $form->fetch();
                $data['date'] = time();
                $data['userid'] = $this->userid;


                $feature_cover = json_decode($data['feature_cover'], true);
                $number = json_decode($data['number'], true);



                foreach ($feature_cover as $key => $save_data) {
                    $stmt_c = $this->db->prepare("INSERT INTO `{$this->feature_cover}` (`feature_cover`,`number`,`userid`,`date`) VALUE (?,?,?,?)");
                    $stmt_c->execute(array($save_data,$number[$key],$this->userid, time()));

                }

                $this->lightRedirect(url . "/savers/list_feature_cover", 0);

            } catch (Exception $e) {
                $data = $form->fetch();
                $data['date'] = strtotime($data['date']);
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }

        require($this->render($this->folder, 'feature_cover', 'html/add', 'php'));
        $this->adminFooterController();

    }



    public function edit_feature_cover($id)
    {
        $this->checkPermit('edit_feature_cover', 'savers');
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }

        $files = new Files();
        $this->adminHeaderController($this->langControl('edit'));

        $data = $this->db->select("SELECT * from `{$this->feature_cover}` WHERE `id`=:id LIMIT 1 ", array(':id' => $id));
        $data = $data[0];


        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();


                $form->post('feature_cover')
                    ->val('is_empty', 'نوع الحافظة  مطلوب  ')
                    ->val('strip_tags');

                $form->post('number')
                    ->val('is_empty', 'رقم نوع الحافة مطلوب  ')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();


                $this->db->update($this->feature_cover, $data, "id={$id}");


                $this->lightRedirect(url . "/savers/list_feature_cover", 0);


            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }


        require($this->render($this->folder, 'feature_cover', 'html/edit', 'php'));
        $this->adminFooterController();

    }

    public function processing_feature_cover()
    {


        $table = $this->feature_cover;
        $primaryKey = 'id';

        $columns = array(


            array('db' => 'feature_cover', 'dt' => 0),
            array('db' => 'number', 'dt' =>1),
            array('db' => 'date', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d ', $d);
                }

            ),
            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($id, $row) {

                    return "
                <div style='text-align: center'>
                  <input {$this->ch_feature_cover($id)} class='toggle-demo' onchange='visible_savers(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }


            ),

            array(
                'db' => 'id',
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    return "
 
                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/savers/edit_feature_cover/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db' => 'id',
                'dt' => 5,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_feature_cover',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
                    else
                    {
                        return $this->langControl('forbidden');
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
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
        );

    }


    public function ch_feature_cover($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->feature_cover} WHERE `id` = ? AND `active` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }
    public function visible_savers_feature_cover($v_, $id_)
    {

        if ($this->handleLogin())
        {

            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }

            $data = $this->db->update($this->feature_cover, array('active' => $v), "`id`={$id}");
        }

    }

    function delete_savers_feature_cover($id)
    {
        if ($this->handleLogin() ) {

            $cd = $this->db->prepare("DELETE FROM `$this->feature_cover`  WHERE  `id`=?");
            $cd->execute(array($id));
        }
    }








}