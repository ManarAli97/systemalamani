<?php

class Login extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $index = new Index();
        $index->index();
    }

    public function user()
    {

        if (isset($_SESSION['loggedIn'])) {
            header("Location:" . url . "/home");
        } else {
            $g=0;
            if (isset($_GET['g'])) {
                if ($_GET['g'] == 1) {
                    $g=1;
                }
            }

            require($this->render($this->folder, 'html', 'index', 'html'));

        }
    }

    public function login()
    {

        $login = $_POST['login'];
        $password = $_POST['password'];

        $stmt = $this->db->prepare("SELECT *FROM `user` WHERE username=? AND password = ? LIMIT 1");
        $stmt->execute(array(trim($login), $this->HASH_key('sha256', $password . trim($login), HASH_PASSWORD_KEY)));
        $data = $stmt->fetch();

        if ($stmt->rowCount() > 0) {
            //login


            if ($data['active'] == 0  && $data['idGroup'] !=0  )
            {
                echo '
                <div  style="    text-align: center; background: #ffc107;padding: 15px;font-size: 22px;font-weight: bold;" role="alert">
                  <span> الحساب غير فعال </span> <a href="'.url .'/login/user" class="alert-link"> رجوع </a>   
                </div>
                ';
                die();
            }


            Session::set('role', $data['role']);
            Session::set('loggedIn', $data['password']);
            Session::set('userid', $data['id']);
            Session::set('idGroup', $data['idGroup']);
            Session::set('usernamelogin', $data['username']);
            Session::set('print', $data['print']);
            Session::set('number_copy', $data['number_copy']);
			Session::set('CSRFToken', $this->generateToken(25));

			$stmt=$this->db->prepare("UPDATE user SET session = ?,uuid=? WHERE id=? AND idGroup <>  0 ");
			$stmt->execute(array(strtotime($this->expire_session),$password.'_'.$this->uuid(4),$data['id']));

			if ($data['direct']  > 0) {
				Session::set('direct', $data['direct']);

				$stmtx = $this->db->prepare("SELECT   `id_member_r`  FROM  `cart_shop_active` WHERE  `user_direct`  = ?  AND number_bill = 0 GROUP BY `user_direct` ");
				$stmtx->execute(array($data['id']));
				if ($stmtx->rowCount() > 0) {
					$r = $stmtx->fetch(PDO::FETCH_ASSOC);
					if (!is_numeric($r['id_member_r'])) {
						Session::set('uuid', $r['id_member_r']);
					} else {
						Session::set('uuid', $this->uuid(4));
					}
				  }
				else
				{
					Session::set('uuid', $this->uuid(4));
				}


                if (isset($_GET['g']))
                {
                    if ($_GET['g'] == 1)
                    {
                        $cookie_name = "id_user_disk";
                        $cookie_value = $data['id'];
                        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

                        $this->lightRedirect(url .'/games/disk?g=1' , 0);

                    }else{
                        $this->lightRedirect(url , 0);
                    }
                }else
                {
                    $this->lightRedirect(url , 0);
                }


            }
            else
            {
                $_SESSION['direct']=0;
                Session::set('uuid', $this->uuid(4));

                if ($this->main_account($data['id']))
                {
                    $this->lightRedirect(url . '/accountant', 0);

                }else if ($this->prepared_account($data['id']))
                {
                    $this->lightRedirect(url . '/prepared', 0);

                }else
                {
                    $this->lightRedirect(url . '/home', 0);

                }


            }

        } else {
            header("Location:" . url . "/login/user");
        }
    }




    public function logout()
    {
        unset($_SESSION['role']);
        unset($_SESSION['loggedIn']);
        unset($_SESSION['userid']);
        unset($_SESSION['idGroup']);
        unset($_SESSION['usernamelogin']);
        unset($_SESSION['direct']);
        unset($_SESSION['uuid']);
        header("Location:" . url . "/login/user");

    }


}