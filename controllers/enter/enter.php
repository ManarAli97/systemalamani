<?php

class enter extends Controller
{
	function __construct()
	{
		parent::__construct();
        $this->setting = new Setting();
	}


	function index()
	{

	    if (isset($_SESSION['id_member_r'])) {
            $stmtUpdate = $this->db->prepare("UPDATE  register_session_customer SET  `last_date_active`=?,active=0  WHERE id_customer=?");
            $stmtUpdate->execute(array(time(), $_SESSION['id_member_r']));

            $_SESSION['date_active_customer'] = null;
            $_SESSION['username_member_r'] = null;
            $_SESSION['id_member_r'] = null;
            $_SESSION['name_r'] = null;
            $_SESSION['typeLogin'] = null;
        }

		$city=array(
			'بغداد',
			'كربلاء المقدسة',
			'بابل',
			'النجف الأشرف',
			'ميسان',
			'الأنبار',
			'أربيل',
			'البصرة',
			'دهوك',
			'القادسية',
			'ديالى',
			'ذي قار',
			'السليمانية',
			'صلاح الدين',
			'كركوك',
			'المثنى',
			'نينوى',
			'واسط',
		);



        $stmt=$this->db->prepare("SELECT *FROM `truth_screen_questions` WHERE `active`=1   ");
        $stmt->execute();
        $videos=array();


        while ($row =  $stmt->fetch(PDO::FETCH_ASSOC))
        {
            if ($row['img'] != 0) {

                $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module    LIMIT 1 ", array(':id' => $row['img'], ':module' =>'truth_screen_questions'));
                $get_file = $get_file[0];
                $row['video'] = $this->save_file . $get_file['rand_name'];

            } else {
                $row['video'] = 'no-file';
            }

            $videos[]=$row;
        }





        require($this->render($this->folder, 'html', 'enter', 'php'));

	}

	function home()
	{


        if (isset($_SESSION['username_member_r']))
        {
            header('Location:'. url );
        }else {


            $city = array(
                'بغداد',
                'كربلاء المقدسة',
                'بابل',
                'النجف الأشرف',
                'ميسان',
                'الأنبار',
                'أربيل',
                'البصرة',
                'دهوك',
                'القادسية',
                'ديالى',
                'ذي قار',
                'السليمانية',
                'صلاح الدين',
                'كركوك',
                'المثنى',
                'نينوى',
                'واسط',
            );


            require($this->render($this->folder, 'html', 'index', 'php'));
        }
	}


	function index2()
	{




		$city=array(
			'بغداد',
			'كربلاء المقدسة',
			'بابل',
			'النجف الأشرف',
			'ميسان',
			'الأنبار',
			'أربيل',
			'البصرة',
			'دهوك',
			'القادسية',
			'ديالى',
			'ذي قار',
			'السليمانية',
			'صلاح الدين',
			'كركوك',
			'المثنى',
			'نينوى',
			'واسط',
		);



		 require($this->render($this->folder, 'html', 'index2', 'php'));

	}

	function rprice()
	{

		if (isset($_POST['submit']))
		{

		  	$qr=$_POST['qr'];
			$link=explode('/',$qr);
			$code= end($link);

			// $stmtqr=$this->db->prepare("SELECT *FROM register_user WHERE uid=? AND xc=1 AND city <> '' AND gander <> '' LIMIT 1 ");
			 $stmtqr=$this->db->prepare("SELECT *FROM register_user WHERE uid=?    LIMIT 1 ");
			$stmtqr->execute(array($code));
			if ($stmtqr->rowCount() > 0)
			{
				$result=$stmtqr->fetch(PDO::FETCH_ASSOC);


				if (isset($_SESSION['id_member_r']))
                {
                    $stmtUpdate=$this->db->prepare("UPDATE  register_session_customer SET  `last_date_active`=?,active=0  WHERE id_customer=?");
                    $stmtUpdate->execute(array(time(),$_SESSION['id_member_r']));
                }



                $_SESSION['username_member_r'] = $result['phone'];
				$_SESSION['id_member_r'] =  $result['id'];
				$_SESSION['name_r'] = $result['name'];
				$_SESSION['typeLogin'] = $result['login'];

				if (isset($_GET['login']))
                {
                    $screen=$_POST['screen'];
                    $this->active_customer($result['id'],$screen);
                }
                if(isset($_GET['full_data']))
                {
                    if (empty($result['city']) || empty($result['address'])  || empty($result['birthday'])  || empty($result['gander']) || empty($result['title']) )
                    {
                        $col=array();

                        if (empty($result['title']))
                        {
                            $col['title']='المهنة';
                        }


                        if (empty($result['birthday']))
                        {
                            $col['birthday']='تاريخ الميلاد';

                        }

                        if (empty($result['gander']))
                        {
                            $col['gander']='الجنس';
                        }

                        if (empty($result['city']))
                        {
                            $col['city']='المحافظة';
                        }

                        if (empty($result['address']))
                        {
                            $col['address']='العنوان';
                        }

//                       echo json_encode(array('full_data'=>'0','uid'=> $result['uid'],'id'=> $result['id'],'col'=>$col));
                       echo json_encode(array('full_data'=>'1','uid'=> $result['uid'],'id'=> $result['id']));

                    }else
                    {
                      echo json_encode(array('full_data'=>'1','uid'=> $result['uid'],'id'=> $result['id']));
                    }
                }else
                {
                    echo $result['uid'];
                }

			}else{
				echo 'rqr';
			}

		}else
		{
			echo 'rqr';
		}



	}

    function rq_user()
    {

        if (isset($_POST['submit']))
        {

            $qr=strip_tags(trim($_POST['qr']));

            $stmtqr=$this->db->prepare("SELECT *FROM user WHERE hash=? ");
            $stmtqr->execute(array($qr));
            if ($stmtqr->rowCount() > 0)
            {
                $result=$stmtqr->fetch(PDO::FETCH_ASSOC);
                echo json_encode(array('id'=>$result['id'],'username'=>$result['username']));
            }else{
                echo 'rqr';
            }

        }else
        {
            echo 'rqr';
        }



    }


    function edit()
    {
        $uid=strip_tags(trim($_GET['uid']));
        $id=strip_tags(trim($_GET['id']));


        $stmtqr=$this->db->prepare("SELECT *FROM register_user WHERE uid=?  AND `id`=? LIMIT 1 ");
        $stmtqr->execute(array($uid,$id));
        $result=$stmtqr->fetch(PDO::FETCH_ASSOC);

        try {
            $form = new  Form();


            if (empty($result['title'])) {

                $form->post('title')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');
            }

            if (empty($result['gander'])) {
                $form->post('gander')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');
            }



            if (empty($result['birthday'])) {

                $form->post('day')
                    ->val('strip_tags');

                $form->post('month')
                    ->val('strip_tags');

                $form->post('year')
                    ->val('strip_tags');

            }



            if (empty($result['city'])) {
                $form->post('city')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');
            }



            if (empty($result['address'])) {

                $form->post('address')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');
            }




            $form->submit();
            $data = $form->fetch();

            $data['login']='website';
            $data['country']='العراق';
            $data['id_user_screen']=$_GET['id_user_screen'];
            if (empty($result['birthday'])) {
                $data['birthday'] = $data['year'] . '-' . $data['month'] . '-' . $data['day'];
            }



            $data['xc']=1;
            if (empty($this->error_form))
            {
                    $stmt = $this->db->update('register_user', array_diff_key($data,['day'=>"delete",'month'=>"delete",'year'=>"delete"]),"uid={$uid} AND id={$id}");
                    echo $uid;
            }

        } catch (Exception $e) {

            $this->error_form = $e->getMessage();

        }

    }


}