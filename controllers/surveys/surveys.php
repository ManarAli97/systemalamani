
<?php
/**
 *  بالاستطلاع لدينا ثللاثة جداول
 *      haider_questions
 *           مخصص للسؤال
 *      haider_answers
 *          مخصص لاجوبة الاسئلة 
 *          بالنسبة للاعمدة
 *              info_next:
 *                  من خلالة نعرف 
 * مع العلم ان العمود القبل الاخير مخصص لمعرفة نوع الجواب
 * 
 * 
 */
class surveys extends Controller
{

    public $ids = array();
    public $imgUrl ='';


    function __construct()
    {
        parent::__construct();
     
        $this->imgUrl = url."/controllers/surveys/image/";
        
        $this->menu=new Menu();
    }
    /**
     * 
     */
    public function view()
    {
       
         $this->checkPermit('show_statistics','haider_statistics');
        $this->adminHeaderController($this->langControl('statistics'));
        require ($this->render($this->folder,'html','statistics','php'));
        $this->adminFooterController();
    }
    /**
     * This fuction for return <a> tag if answer has feedback 
     */
    function getAnswerRow($idAnswer)
    {
        $stmt = $this->db->prepare("SELECT `type_next` FROM `haider_answers`  WHERE `id`=?");
        $stmt->execute(array($idAnswer));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // $data['model'] =$found_data['model'];
        if ( $row['type_next']=='add')
            return "<a href='".url."/".$this->folder."/showFeedBack/".$idAnswer."'>".$this->getAnswerCount($idAnswer)." </a>";
        else
            return $this->getAnswerCount($idAnswer);
    }

    /**
     * Return the count of  answer by id Answer
     */
    function getAnswerCount($idAnswer)
    {
        $stmt = $this->db->prepare("SELECT `count` FROM `haider_statistics`  WHERE `id_answer`=?");
        $stmt->execute(array($idAnswer));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // $data['model'] =$found_data['model'];
        return $row['count'];
    }

    /**
     * 
     */
    public function feedbackServerSide($idAnswer)
    {
        $table ='haider_feedback';
        $primaryKey = 'id';

        $columns = array(
            array( 'db' => 'number', 'dt' =>0 ),
            array( 'db' => 'note', 'dt' =>1 ),
            array( 
                'db' => 'admin_note',
                'dt' =>2,
                'formatter' => function($id, $row ) {
                    return $this->adminNote($row[3],$id);
                }),

            array(  'db' => 'id', 'dt'=>3,
                'formatter' => function($id, $row ) {
                    return "
                    <div style='text-align: center'>
                    <input {$this->checkEnableCall($id)} class='toggle-demo' onchange='updateEnableCall(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'><p style='font-size:10px;' >{$this->getUser($id,'enable_call')}</P>
                    </div>
                    ";
                }
                
            ),
            array(  'db' => 'id', 'dt'=>4,
                'formatter' => function($id, $row ) {
                    return "
                    <div style='text-align: center'>
                    <input {$this->checkCalled($id)} class='toggle-demo' onchange='updateCalled(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'><p style='font-size:10px;' >{$this->getUser($id,'called')}</P>
                    </div>
                    ";
                }
                
            ),
            array( 
                'db' => 'called_note',
                'dt' =>5,
                'formatter' => function($id, $row ) {
                     return "
                    <div class='col-xs-2'>
                        
                        <textarea  onfocusout='addCalledNote(this.value,$row[3])' class='form-control '  type='text' rows='3' >$id</textarea><p style='font-size:10px;' >{$this->getUser($row[3],'called_note')}</P>
                    </div>
                ";
                }),
        
        );

        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        $select = "  id_answer = ".$idAnswer;
        if(isset($_SESSION['filterFeedback'][1])&&($_SESSION['filterFeedback'][1]==1))
            $select.=" and enable_call=1 ";
       
        
        echo json_encode(
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,$select)
        );

    }
    /**
     * هاي دالة المعالجة الخاصة بموبوضع عرض  التتبع
     */
    public function processingShowTraking($id=null,$actionType=null)
    {
        $table = "h27_feedback_tracking";
        $primaryKey = 'id';


        $columns = array(

            array( 'db' => 'user_id', 'dt' => 0 ,
                'formatter' => function( $d, $row ) {
                    return  $this->UserInfo( $d) ;
                }
            ),
            array( 'db' => 'the_value', 'dt' => 1 ),
            array( 'db' => 'action_date', 'dt' => 2 ,
            'formatter' => function( $d, $row ) {
                return $d ;
            }
        ),
       
       
   
        );
        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        $select= 'id_feedback ="'.$id.'" and action_type ="'.$actionType.'" ';

        echo json_encode(
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,$select)
        );

    }
    public function statisticsServerSide()
    {
        $table ='haider_answers';
        $primaryKey = 'id';


        $columns = array(

            array( 'db' => 'id_question', 'dt' => 0 ,
                'formatter' => function( $d, $row ) {
                    return  $this->getQuestion($d) ;
                }
            ),
            
            array( 'db' => 'answer', 'dt' =>1 ),
            array( 'db' => 'id', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                    return  $this->getAnswerRow($d) ;
                }
            ),

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
    /**
     * هاي الدالة من خلالها نعرض الحركات الي صارت بواسطة رقم الحقل ونوع الاكشن 
     * 
     */
    function showTraking($id=null,$actionType=null)
    {
        $this->checkPermit('details','found');
        $this->adminHeaderController($this->langControl('الحركة'));
       
        require ($this->render($this->folder,'html','show_tracking','php'));
        $this->adminFooterController();
    }

     /**
     * هاي الدالة تخلي حقل الملاحظة عباره عن مربع نص من يكون المستخدم هو الادمن  
     */
    function adminNote($row,$id)
    {
        if(isset($_SESSION['filterFeedback'][0]) && $_SESSION['filterFeedback'][0]==1 )
        {
        return "
                    <div class='col-xs-2'>
                        
                        <textarea  onfocusout='addAdminNote(this.value,$row)' class='form-control '  type='text' rows='3' >$id</textarea><p style='font-size:10px;' >{$this->getUser($row,'admin_note')}</P>
                    </div>
                ";
        }
        return $id."<p style='font-size:10px;' >{$this->getUser($row,'admin_note')}</P>";
    }
    // /**
    //  * هاي الدالة تخلي حقل الملاحظة عباره عن مربع نص من يكون المستخدم هو الكول سنتر
    //  */
    // function calledNote($row,$id)
    // {
    //     if(isset($_SESSION['filterFeedback'][1]) && $_SESSION['filterFeedback'][1]==1 )
    //     {
    //     return "
    //                 <div class='col-xs-2'>
                        
    //                     <textarea  onfocusout='addcalledNote(this.value,$row)' class='form-control '  type='text' rows='3' >$id</textarea><p style='font-size:10px;' >{$this->getUser($row,'called_note')}</P>
    //                 </div>
    //             ";
    //     }
    //     return $id."<p style='font-size:10px;' >{$this->getUser($row,'called_note')}</P>";
    // }

    /**
     *   هاي الدالة ترجع اسم المستخدم الي نفذ اجراء معين على جدول اطلب مالم تجده
     * وبيها رابط حتى نشوف كل التعديلات السابقة
     */
    public function getUser($idFeedback,$actionType)
    {
        $stmt = $this->db->prepare("SELECT * FROM `h27_feedback_tracking`  WHERE `id_feedback`=? and action_type=? ORDER BY `h27_feedback_tracking`.`id` DESC" );
        $stmt->execute(array($idFeedback,$actionType));
        if($row = $stmt->fetch(PDO::FETCH_ASSOC))
            return  "
            <div style='text-align: center;font-size: 18px;'>
             <a href=".url.'/'.$this->folder."/showTraking/$idFeedback/$actionType> <span>{$this->UserInfo( $row['user_id'])}</span> </a>
             </div> " 
            ;
        else 
            return "";
    }
    
    /**
     * من خلال هاي الدالة نعرض السؤال 
     *  حاليا نعرض السؤال الاول اذا لم يتم اختيار اي سؤال 
     */
    function index($id=1,$vote=0)
    {
        $this->addVoit($vote);


        $sqlQ = $this->db->prepare("SELECT * FROM haider_answers  WHERE `id_question`=?");
        $sqlQ->execute(array($id));
        $answers= array();

        while($row= $sqlQ->fetch(PDO::FETCH_ASSOC))
        {
            $answers[]=$row;
        }
        require ($this->render($this->folder,'html','header','php'));
        require ($this->render($this->folder,'html','index','php'));
    }
    /**
     * اضهار الاشعار للزبون
     */
    function showInfo($id)
    {
        $sqlQ = $this->db->prepare("SELECT * FROM haider_answers  WHERE `id`=?");
        $sqlQ->execute(array($id));
        $this->addVoit($id);
        $answer= $sqlQ->fetch(PDO::FETCH_ASSOC);
        require ($this->render($this->folder,'html','header','php'));
        require ($this->render($this->folder,'html','info','php'));
    }
    /**
     * اخذ معلومات الزبون 
     */
    function showAdding($id)
    {
        $sqlQ = $this->db->prepare("SELECT * FROM haider_answers  WHERE `id`=?");
        $sqlQ->execute(array($id));
        $this->addVoit($id);
        $answer= $sqlQ->fetch(PDO::FETCH_ASSOC);
        require ($this->render($this->folder,'html','header','php'));
        require ($this->render($this->folder,'html','add','php'));
    }
    /**
     * اضافة صوت
     */
    function addVoit($id)
    {
        $stmt = $this->db->prepare("update  haider_statistics set `count`=`count`+1 where id_answer=?");
        $stmt->execute(array($id));
       
        // $sqlQ = $this->db->prepare("SELECT * FROM haider_answers  WHERE `id`=?");
        // $sqlQ->execute(array($id));
        // $answer= $sqlQ->fetch(PDO::FETCH_ASSOC);
        // if($answer["type_next"]=="q")
        //     $this->lightRedirect(url.'/surveys/index/'.$answer['info_next']);
        // else if($answer["type_next"]=="info")
        //     $this->lightRedirect(url.'/surveys/showInfo/'.$answer['id']);
        // else if($answer["type_next"]=="add")
        //     $this->lightRedirect(url.'/surveys/showAdding/'.$answer['id']);
       
       
    }
    function addFeedBack($id)
    {
       
        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();
                $form->post('number')
                    ->val('strip_tags');

                $form->post('note')
                    ->val('strip_tags');

                $form->submit();
                $data = $form->fetch();
                $stmt = $this->db->prepare("INSERT INTO `haider_feedback`( `id_answer`, `number`, `note`) VALUES (?,?,?)");
                $stmt->execute(array($id, $data['number'],$data['note']));
                $this->lightRedirect(url.'/surveys/');

            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form= json_decode($e -> getMessage(),true);
            }
            
        } 

    }

    function showFeedBack($idAnswer)
    {
        $this->checkPermit('show_feedback','haider_statistics');
       
       
        $this->adminHeaderController($this->langControl('statistics'));
        require ($this->render($this->folder,'html','showFeedBack','php'));
        $this->adminFooterController();

    }



    /**
     * هذه الدالة خاصة لجلب السؤال  من الجدول 
     */
    function getQuestion($id)
    {
        $sqlQ = $this->db->prepare("SELECT question FROM haider_questions  WHERE `id`=?");
        $sqlQ->execute(array($id));
        $resilt = $sqlQ->fetch(PDO::FETCH_ASSOC);
        return $resilt['question'];
    }

    /**
     * هاي الدالة خاصة بجلب الصورة الخاصة بالجواب
     */
    function getImage($idAnswer)
    {
        $sqlQ = $this->db->prepare("SELECT img FROM answers_img  WHERE `id_answers`=?");
        $sqlQ->execute(array($idAnswer));
        $resilt = $sqlQ->fetch(PDO::FETCH_ASSOC);
        return $this->imgUrl.$resilt['img'];
    }
    /**
     *  هاي الدالة تحدد اي نوع من المستخدمين  موجود
     */
    public function checkOption($admin,$callCenter)
    {
        
        $_SESSION['filterFeedback']= array();
        if($admin==1) 
            $_SESSION['filterFeedback'][0]= $admin; 
        else if(isset ($_SESSION['filterFeedback'][0])) 
            unset($_SESSION['filterFeedback'][0]);

        if($callCenter==1) 
            $_SESSION['filterFeedback'][1]= $callCenter; 
        else if(isset ($_SESSION['filterFeedback'][1])) 
            unset($_SESSION['filterFeedback'][1]);
        
    }
    /**
     * هاي الدالة تتاكد انه تم التحويل للاتصال او لا من خلال الايدي
     */
    public function checkEnableCall($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM haider_feedback WHERE `id` = ? AND `enable_call` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }
    
    /**
     * هاي الدالة تتاكد انه تم الاتصال بالزبون او لا من خلال الايدي
     */
    public function checkCalled($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM haider_feedback WHERE `id` = ? AND `called` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }
    /**
     * 
     *  وضيفتها تحدث على الجدول وتخلي حقل التحويل الى الكولسنتر صح 
     * يتم استدعأها عن طريق اجاكس للعلم
     */
    public function updateEnableCall($v_, $id_)
    {
        if ($this->handleLogin()) {
            if (is_numeric($v_) && is_numeric($id_)) 
            {
                $v = $v_;
                $id = $id_;
            }
             else 
            {
                $v = 0;
                $id = 0;
            }
            $stmt = $this->db->prepare("update haider_feedback set enable_call=? where id=?");
            $stmt->execute(array($v,$id));
            if($v==1)
            {
                $this->addFeedbackTracking($id,"enable_call","تم التحويل الى الكول سنتر");
            }
            else
            {
                $this->addFeedbackTracking($id,"enable_call","تم الغاء تم التحويل الى الكول سنتر");
            }
            
		}
    }
    /**
     * 
     *  وضيفتها تحدث على الجدول وتخلي حقل الاتصال بالزبون صح 
     * يتم استدعأها عن طريق اجاكس للعلم
     */
    public function updateCalled($v_, $id_)
    {
        if ($this->handleLogin()) {
            if (is_numeric($v_) && is_numeric($id_)) 
            {
                $v = $v_;
                $id = $id_;
            }
             else 
            {
                $v = 0;
                $id = 0;
            }
            $stmt = $this->db->prepare("update haider_feedback set called=? where id=?");
            $stmt->execute(array($v,$id));
            if($v==1)
            {
                $this->addFeedbackTracking($id,"called"," تم الاتصال ");
            }
            else
            {
                $this->addFeedbackTracking($id,"called","تم الغاء الاتصال");
            }
            
		}
    }
     /**
     * هاي الدالة تضيف اي حركة صارت على جدول 
     * haider_feedback   
     * 
     * */ 
    public function addFeedbackTracking($idFeedback,$actionType,$theValue)
    {
        $stmt = $this->db->prepare("INSERT INTO `h27_feedback_tracking`( `id_feedback`, `action_type`, `user_id`,the_value) VALUES (?,?,?,?)");
        $stmt->execute(array($idFeedback,$actionType, $this->userid,$theValue));
    }
    /**
     * هاي الدالة تضيف ملاحظة الادمن ويتم استدعاؤها عن طريق اجاكس
     */
    function addAdminNote()
    {
        $note = $_POST['value1'];
        $id = $_POST['value2'];
            $stmt = $this->db->prepare("update  haider_feedback set admin_note=? where id=?");
            $stmt->execute(array($note,$id));
            $this->addFeedbackTracking($id,"admin_note",$note);
        
    }
     /**
     * هاي الدالة تضيف ملاحظة الكول سنتر ويتم استدعاؤها عن طريق اجاكس
     */
    function addCalledNote()
    {
        $note = $_POST['value1'];
        $id = $_POST['value2'];
        
            $stmt = $this->db->prepare("update  haider_feedback set called_note=? where id=?");
            $stmt->execute(array($note,$id));
            $this->addFeedbackTracking($id,"called_note",$note);
        
    }

   
}
