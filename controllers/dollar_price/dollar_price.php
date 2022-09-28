<?php

class Dollar_price extends Controller
{



    function __construct()
    {
        parent::__construct();

        $this->table='dollar_price';


        $this->setting =new Setting();

    }

    public function createTB()
    {


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `dollar` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `active` int(10) NOT NULL DEFAULT '1',
           `userid` int(11) NOT NULL,
           `lang` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return  $this->db->cht(array($this->table));

    }

//dollar_price


    public function index()
    {
        $this->checkPermit('list_dollar_price', 'dollar_price');
        $this->adminHeaderController($this->langControl('dollar_price'));

        require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();
    }

    public function add_dollar_price()
    {
        $this->checkPermit('add_dollar_price', 'dollar_price');
        $this->adminHeaderController($this->langControl('add'));



        if (isset($_POST['submit']))
        {
            try{
                $form =new Form();

                $form  ->post('dollar')
                    ->val('is_array','مطلوب');

                $form ->submit();
                $data =$form -> fetch();
                $file=new Files();

                $title=json_decode($data['dollar'],true);


                foreach ($title as $key => $save_data)
                {
                    $stmt_s=$this->db->prepare("INSERT INTO `{$this->table}` (`dollar`,`userid`,`lang`,`date`) VALUE (?,?,?,?)");
                    $stmt_s->execute(array($save_data,$this->userid,$this->langControl,time()));
                }


                $this->lightRedirect(url.'/'.$this->folder,0);
            }

            catch (Exception $e)
            {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();
            }

        }

        require($this->render($this->folder, 'html', 'add', 'php'));
        $this->adminFooterController();
    }



    public function processing()
    {

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(
            array( 'db' => 'dollar', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return strip_tags($d);
                }
            ),


            array( 'db' => 'userid', 'dt' => 1,
                'formatter' => function( $d, $row ) {
                    return  $this->UserInfo($d);
                }
            ),

            array( 'db' => 'date', 'dt' => 2,
                'formatter' => function( $d, $row ) {
                    return date('Y-m-d h:i:s A',$d);
                }
            ),


            array(  'db' => 'id', 'dt'=>3)


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
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )
        );

    }


    public function ch_dollar_price($id)
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




    public function visible_dollar_price($v_,$id_)
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


    function delete_dollar_price($id)
    {
        if ($this->handleLogin()) {

            $c = $this->db->prepare("DELETE FROM  `$this->table`  WHERE  `id`=?");
            $c->execute(array($id));


        }
    }

    function get_dollar_price($id)
    {
        if ($this->handleLogin())
        {
            $data = $this->db->select("SELECT * from `{$this->table}` WHERE `id`=:id AND `lang`='{$this->langControl}'", array(':id' => $id));
            if (!empty($data))
            {
                $data= $data[0] ;
                echo json_encode($data);
            }
            else
            {
                exit();
            }
        }


    }


    function get_dollar_price_from_user()
    {
        if ($this->handleLogin())
        {


            if ($this->userAccess()) {
                $stmt = $this->db->prepare("SELECT * from `{$this->table}` ");
                $stmt->execute();
                return $stmt;
            } else {
                $stmt = $this->db->prepare("SELECT * from `{$this->table}`  WHERE `id`=? ");
                $stmt->execute(array(session::get('iddollar_price')));
                return $stmt;
            }

        }


    }


    public  function edit_dollar_price($id=null)
    {

        if ($this->handleLogin())
        {
            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            $dollar=$_POST['dollar'];
            $stmt=$this->db->update($this->table,array('dollar'=>$dollar,'date'=>time()),"id={$id} AND `lang`='{$this->langControl}'");

        }

    }



    function dollar_get()
	{
		$stmt=$this->db->prepare("SELECT *FROM `dollar_price`  WHERE `active` = 1  ORDER BY `id` DESC  LIMIT 1" );
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$resultDollar = $stmt->fetch(PDO::FETCH_ASSOC);
			return str_replace(',','',$resultDollar['dollar']);
		}else{
			return 0;
		}

	}



    function dollar_price_convert()
    {

        $stmt= $this->db->prepare("SELECT dollar FROM dollar_price WHERE active =1 ORDER BY id DESC  LIMIT  1");
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);

        $price=str_replace($this->comma,'',trim(str_replace('د.ع','',$_GET['price'])));

        $out_price=0;
        $split_price=explode('-',$price);
        if (count($split_price) == 1)
        {
            $new_price = $split_price[0] / $result['dollar'];
            if (is_float($new_price)) {
                $p = explode('.', $new_price);
                $new_price = $p[0] . '.' . substr($p[1], 0, 2);
            }
            $out_price = $new_price ;
        }else{

            $new_price1 = $split_price[0] / $result['dollar'];
            if (is_float($new_price1)) {
                $p = explode('.', $new_price1);
                $new_price1 = $p[0] . '.' . substr($p[1], 0, 2);
            }
            $new_price2 = $split_price[1] / $result['dollar'];
            if (is_float($new_price2)) {
                $p = explode('.', $new_price2);
                $new_price2 = $p[0] . '.' . substr($p[1], 0, 2);
            }

            $out_price =   $new_price1  .' - '.  $new_price2   ;

        }



        echo $out_price .' دولار ' ;

    }



}