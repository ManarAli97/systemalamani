<?php
class Questions extends Controller
{
function __construct()
{
parent::__construct();

    $this->answer_customer='answer_customer';
    $this->table='questions';
    $this->answer='answer';
    $this->menu=new Menu();
}







    public function createTB()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
           `id` int(11) NOT NULL AUTO_INCREMENT,
          `questions` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `number_q` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `active` int(10) NOT NULL DEFAULT '0',
          `lang` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->answer}` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `id_q` int(11) NOT NULL,
          `answer` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `correct` int(11) NOT NULL ,
          `lang` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");




        return $this->db->cht(array($this->table,$this->answer ));
    }

      function view_questions()
         {
         $this->checkPermit('questions','questions');
        $this->adminHeaderController($this->langControl('questions'));

        require($this->render($this->folder, 'html', 'index', 'php'));
        $this->adminFooterController();

    }


    public function add()
    {


        $this->checkPermit('add','questions');
        $this->adminHeaderController($this->langControl('add'));

        $data['questions']='';
        $data['number_q']='';
        $data['answer']='';

        if (isset($_POST['submit']))
        {
            try {
                $form = new  Form();
                $form->post('number_q')
                    ->val('is_empty',  $this->langControl('empty_number_q'))
                    ->val('strip_tags');

                $form->post('questions')
                    ->val('is_empty', $this->langControl('empty_questions'))
                    ->val('strip_tags');

                $form->post('answer')
                    ->val('is_array', $this->langControl('empty_answer'))
                    ->val('strip_tags');
                $form->post('correct')
                    ->val('is_array', $this->langControl('empty_answer'))
                    ->val('strip_tags');

                $form ->submit();
                $data =$form -> fetch();

                $data['lang']=$this->langControl;
                $data['date']=time();

                $data['image']='';
                if ($_FILES['image']['error'] == 0) {
                    $data['image'] = $this->save_file($_FILES['image']);
                }


                $answer=json_decode($data['answer'],true);

                $correct=json_decode($data['correct'],true);

                if (empty($this->error_form))
                {
                      $this->db->insert($this->table,array_diff_key($data, ['answer' => "delete",'correct' => "delete"]));
                    $last_id=$this->db->lastInsertId();
                    foreach ($answer as $key => $na) {


                        if (in_array($key,$correct))
                        {

                            $correct_=1;
                        }else
                        {
                            $correct_=0;
                        }

                        $stmt = $this->db->prepare("INSERT INTO `{$this->answer}` (`id_q`,`answer`,`correct`,`lang`,`date`) VALUES (?,?,?,?,?)  ");
                        $stmt->execute(array($last_id,$na,$correct_,$this->langControl,time()));
                    }

                  $this->lightRedirect( url.'/'.$this->folder.'/view_questions',0);
                }



            }

            catch (Exception $e)
            {
                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }
        }




       require ($this->render($this->folder,'html','add','php'));
        $this->adminFooterController();


    }




    function save_file($image)
    {

        $save_file = $this->root_file.'questions';
        @mkdir($save_file);
        $path = $save_file;

        if ($image['error'] == 0) {
            $fileName_agency_file = $image['name'];
            $file_agency_file = $image['tmp_name'];
            $temp_agency_file = explode(".", $fileName_agency_file);
            $extension_agency_file = strtolower(end($temp_agency_file));
            $fileName_agency_file = time() . md5(mt_rand(1, time())) . '_.' . $extension_agency_file;
            move_uploaded_file($file_agency_file, $path . '/' . $fileName_agency_file);
            $file = $fileName_agency_file;

            return $file;
        }
    }




    public function edit($id)
    {

        if (!is_numeric($id)) {
            dir(':)');
        }
        $this->checkPermit('edit','questions');

        $this->adminHeaderController($this->langControl('edit'));

        $stmt=$this->db->select("SELECT * from `{$this->table}` WHERE `id`=:id LIMIT 1 ",array(':id'=>$id));
         $result=$stmt[0];

         $stmt=$this->db->prepare("SELECT *FROM `{$this->answer}` WHERE `id_q`=?");
         $stmt->execute(array($result['id']));
         $answer=array();
         while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
         {
             if ($row['correct']==1)
             {
                 $row['checked']='checked';

             }else
             {
                 $row['checked']='';
             }

             $answer[]=$row;
         }




        if (isset($_POST['submit']))
        {

            try {

                $form = new  Form();
                $form->post('number_q')
                    ->val('is_empty',  $this->langControl('empty_number_q'))
                    ->val('strip_tags');

                $form->post('questions')
                    ->val('is_empty', $this->langControl('empty_questions'))
                    ->val('strip_tags');

                $form->post('answer')
                    ->val('is_array', $this->langControl('empty_answer'))
                    ->val('strip_tags');
                $form->post('correct')
                    ->val('is_array', $this->langControl('empty_answer'))
                    ->val('strip_tags');

                $form ->submit();
                $data =$form -> fetch();


                $data['lang']=$this->langControl;
                $data['date']=time();


                if ($_FILES['image']['error'] != 4) {
                    if ($_FILES['image']['error'] == 0) {
                        $data['image'] = $this->save_file($_FILES['image']);
                    }
                }


                $answer=json_decode($data['answer'],true);

                $correct=json_decode($data['correct'],true);


                if ($this->permit('save_edit',$this->folder)) {
                    if (empty($this->error_form)) {
                        $this->db->update($this->table, array_diff_key($data, ['answer' => "delete", 'correct' => "delete"]), "id={$id}");

                        foreach ($answer as $key => $na) {


                            if (in_array($key, $correct)) {

                                $correct_ = 1;
                            } else {
                                $correct_ = 0;
                            }

                            $stmt = $this->db->prepare("INSERT INTO `{$this->answer}` (`id`,`id_q`,`answer`,`correct`,`lang`,`date`) VALUES (?,?,?,?,?,?)  ON DUPLICATE KEY UPDATE  `id`=VALUES(id),`answer`=VALUES(answer) ,`correct`=VALUES(correct)  ");
                            $stmt->execute(array($key, $id, $na, $correct_, $this->langControl, time()));
                        }


                        $this->lightRedirect(url . '/' . $this->folder . '/view_questions', 0);
                    }
                }

            }

            catch (Exception $e)
            {
                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }
        }


        require ($this->render($this->folder,'html','edit','php'));
        $this->adminFooterController();


    }




    public function processing()
    {


        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'questions', 'dt' => 0 ),

            array( 'db' => 'number_q', 'dt' => 1 ),
            array(
                'db'        => 'id',
                'dt'        => 2,
                'formatter' => function($id, $row ) {
                    if ($this->permit('visible',$this->folder)) {
                    return "
                <div style='text-align: center'>
                  <input {$this->ch($id)} class='toggle-demo' onchange='visible_mobile(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 3,
                'formatter' => function($id, $row ) {
                    return " 
                   <div style='text-align: center;font-size: 23px;'>
                    <a href=".url."/questions/edit/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db'        => 'id',
                'dt'        => 4,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                    return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}' data-role='{$row[2]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
                    else
                    {
                        return $this->langControl('forbidden');
                    }
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

    public function ch($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `active` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            return 'checked';
        }
        else
        {
            return '';
        }
    }

    public function visible_questions($v_,$id_)
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


    public function delete($id)
{

    if ($this->handleLogin())
    {
        $response = $this->db->delete($this->table,"`id`={$id}");
        echo $response;
    }


}

public function campaign_name_from_model($id)
{
    $stmt=$this->db->prepare("SELECT *FROM $this->table WHERE `id`={$id} AND `lang`='{$this->langControl}'");
    $stmt->execute();
    if ($stmt->rowCount()>0)
    {
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return $result['name'];

    }else
    {
       return 'no any think';
    }
}


public function delete_from_db($id)
{
    if ($this->handleLogin()) {
        $response = $this->db->delete($this->answer, "`id`={$id}");
        echo $response;
    }

}
    public function select_q()
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}`  WHERE `active` =1  ORDER BY `id` DESC  LIMIT 1");
        $stmt->execute();
        return $stmt;
    }

    public function select_q2()
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}`     ORDER BY `id` DESC  LIMIT 1");
        $stmt->execute();
        return $stmt;
    }
  public function select_q_p()
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}`    ORDER BY `id` DESC   ");
        $stmt->execute();
        return $stmt;
    }

    public function select_ans($id)
    {
       $stmt = $this->db->prepare("SELECT * FROM `{$this->answer}` WHERE `id_q`=? ORDER BY `id` ASC ");
        $stmt->execute(array($id));
        return $stmt;
    }

    function view()
    {




        $stmt=$this->select_q();
        $qu=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $row['answer']=array();
            $stmt_a=$this->select_ans($row['id']);
            while ($row_a = $stmt_a->fetch(PDO::FETCH_ASSOC))
            {
                $row['answer'][]=$row_a;
            }


            $qu[]=$row;
        }

        require ($this->render($this->folder,'html','view','php'));

    }


    public function form($id)
    {

        if (isset($_SESSION['username_member_r'])) {

            $id_customer=$_SESSION['id_member_r'];

            $stmtx = $this->db->prepare("SELECT   *FROM `register_user` where  `id` =?  AND `phone` <> '' LIMIT 1");
            $stmtx->execute(array($id_customer));
            if ($stmtx->rowCount() > 0) {



                if (!is_numeric($id)) {
                    echo json_encode(array('failed' => array('failed' => 'حدث خطأ يرجى اعادة المحاولة لاحقا.')), JSON_FORCE_OBJECT);
                }

                if (isset($_POST['submit'])) {
                    try {
                        $stmt = $this->db->prepare("SELECT   *FROM `questions` where  `id` =?  ORDER BY `id` DESC  LIMIT 1");
                        $stmt->execute(array($id));
                        if ($stmt->rowCount() == 0) {
                            echo json_encode(array('failed' => array('failed' => 'حدث خطأ يرجى اعادة المحاولة لاحقا.')), JSON_FORCE_OBJECT);
                        } else {


                            $form = new  Form();

                            $form->post('id_ans')
                                ->val('is_empty', 'يرجى تحديد الاجابة.')
                                ->val('strip_tags');

                            $form->submit();
                            $data = $form->fetch();

                            $data['date'] = time();
                            $data['id_q'] = $id;
                            $data['id_customer'] = $id_customer;

                            $stmt = $this->db->prepare("SELECT   *FROM `answer` where `id_q`=? AND  `correct`=1 ORDER BY `id` DESC  ");
                            $stmt->execute(array($id));
                            $result = array();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $result[] = $row['id'];
                            }

                            if (in_array($data['id_ans'], $result)) {
                                $data['correct'] = 1;
                                $data['type_correct'] = 'اجابة صحيحة';
                            } else {
                                $data['correct'] = 0;
                                $data['type_correct'] = 'اجابة خاطئة';
                            }




                    $stmt = $this->db->prepare("SELECT   *FROM $this->answer_customer where `id_customer`=?  AND `id_q` =? ");
                    $stmt->execute(array($id_customer, $id));
                    if ($stmt->rowCount() == 0) {

                            if (empty($this->error_form)) {
                                $this->db->insert($this->answer_customer, $data);  //***************
                                echo json_encode(array('done' => array('done' => 'تم ارسال الاجابة بنجاح.')), JSON_FORCE_OBJECT);

                            } else {
                                echo json_encode(array('failed' => array('failed' => 'حدث خطأ يرجى اعادة المحاولة لاحقا.')), JSON_FORCE_OBJECT);
                            }

                    } else {
                        echo json_encode(array('xcolx' => array('xcolx' => $this->langSite('this_question_has_been_answered_in_advance'))), JSON_FORCE_OBJECT);

                    }
                 }


                    } catch (Exception $e) {
                        $this->error_form = $e->getMessage();
                        echo json_encode(array('error' => json_decode($this->error_form)), JSON_FORCE_OBJECT);

                    }
                }
            }else
            {
                echo json_encode(array('failed' => array('failed' =>  "<span>  يرجى اضافة رقم الهاتف   </span> <a class='loginFromHer ' href='".url."/register/edit' style='cursor: pointer'   > من هنا </a>")), JSON_FORCE_OBJECT);

            }

        } else {
            echo json_encode(array('failed' => array('failed' =>  "<span> يرجى تسجيل الدخول   </span> <a class='loginFromHer ' data-toggle='modal' style='cursor: pointer' data-target='#login_site' >  اضغط هنا </a>")), JSON_FORCE_OBJECT);
        }
    }



    function delt_image_q($id)
    {

        if ($this->handleLogin())
        {

            $stmt=$this->db->prepare("UPDATE `{$this->table}` SET `image`='' WHERE `id` = ? ");
            $stmt->execute(array($id));
            if ($stmt->rowCount()>0)
            {
                echo 1;
            }

        }
    }





}