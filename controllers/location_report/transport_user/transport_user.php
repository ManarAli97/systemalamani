<?php
trait transport_user
{

	function __construct()
	{
		parent::__construct();
		$this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject

	}



	function transport_user()
	{


		$this->checkPermit('transport_user', $this->folder);
		$this->adminHeaderController($this->langControl('transport_user '));




		$date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;

		if (isset($_GET['date'])&&isset($_GET['todate'])) {
			$date = $_GET['date'];
			$todate = $_GET['todate'];

			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);
		}



            require($this->render($this->folder, 'transport_user', 'html/index', 'php'));
		$this->adminFooterController();

	}


	public function processing_transport_user($from_date_stm=null,$to_date_stm=null)
	{

		$this->checkPermit('processing_transport_user', $this->folder);

		$table = 'location_transport_convert';
		$primaryKey =  $table.'.id';


		$this->from=$from_date_stm;
		$this->to=$to_date_stm;


		$columns = array(



            array('db' => 'user.username', 'dt' => 0 ),

			array('db' => $table.'.confirm_user', 'dt' =>1,
				'formatter' => function ($d, $row) {
					return "<a  class='btn btn-warning' href='".url.'/'.$this->folder."/list_transport_user/{$d}' >{$this->number_transport($d,$this->from,$this->to)}</a>";
				})
		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);




        $join = "INNER JOIN user ON user.id={$table}.confirm_user ";

        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array("{$table}.active = 2", "isdelete = 0");
        }else{
            $whereAll = array("{$table}.active = 2","{$table}.date BETWEEN {$from_date_stm} AND {$to_date_stm}" ,"isdelete = 0");

        }

        $group = "GROUP BY {$table}.confirm_user";

        $result = SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll, null, $group);

        echo json_encode($result);

    }


    function number_transport($id,$from,$to)
    {


        if ($from && $to)
        {
            $stmt  = $this->db->prepare("SELECT   COUNT(numb)  as n  FROM  ( SELECT   COUNT(id) as numb     FROM location_transport_convert WHERE  confirm_user= ? AND  `active` = 2 AND isdelete = 0 AND `date`  between ? AND  ? GROUP BY  confirm_user,transport) as t ");
            $stmt ->execute(array($id,$from,$to));
        }else
        {
            $stmt  = $this->db->prepare("SELECT   COUNT(numb)  as n  FROM  ( SELECT   COUNT(id) as numb     FROM location_transport_convert WHERE  confirm_user= ? AND  `active` = 2 AND isdelete = 0  GROUP BY  confirm_user,transport) as t ");
            $stmt ->execute(array($id));
        }

        if ($stmt->rowCount() > 0)
        {
           $result = $stmt->fetch(PDO::FETCH_ASSOC);
           return $result['n'];
        }else
        {
            return 0;
        }

    }




	function view_transport_user(){

		if (isset($_GET['g']))
		{
			$transport=$_GET['g'];
		}else{
			$transport=0;
		}

		$this->checkPermit('transport_user', $this->folder);
		$this->adminHeaderController($this->langControl('transport_user '));

		if (isset($_GET['model']) && isset($_GET['category'])) {

			$categoryIds = $_GET['category'];


			$id = explode('_', $categoryIds);
			$id = $id[1];


			$model = $_GET['model'];

			$name_category = 'category_' . $model;
			$breadcumbsx = $this->BreadcumbsPublic($name_category, $id);
			$category = $this->langControl($model);
			foreach ($breadcumbsx as $key => $cat) {
				$category .= '<li class="breadcrumb-item active" aria-current="page" >' . $key .' </li> ';
			}


		} else if (isset($_GET['model']))
		{
			$id = null;
			$model = $_GET['model'];
			$category ='<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) .' </li> ';

		}else
		{
			$id=null;
			$model=null;
			$category=null;

		}


		$stmt = $this->db->prepare("SELECT  group_location FROM location WHERE  group_location <> 0 group by group_location ORDER BY group_location  asc ");
		$stmt->execute();
		$group_location=array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$group_location[]=$row['group_location'];
		}



		$stmtdata = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 2 AND `transport`=?  ");
		$stmtdata->execute(array($transport));
		$data=array();
		while ($row=$stmtdata->fetch(PDO::FETCH_ASSOC))
		{
            $table=$row['model'];


			if ($row['model']=='mobile')
			{
				$code='code';
				$color='color';

				$stmt_t= $this->db->prepare("SELECT  {$code}.location, {$color}.img,{$table}.title FROM {$code} INNER JOIN {$color} ON {$color}.id={$code}.id_color  INNER JOIN {$table} ON {$table}.id={$color}.id_item WHERE  {$code}.`code` = ?  ");
				$stmt_t->execute(array($row['code']));

			}else if ($row['model']=='accessories')

			{

				$stmt_t= $this->db->prepare("SELECT  color_accessories.location, color_accessories.img,accessories.title FROM color_accessories INNER JOIN accessories on accessories.id = color_accessories.id_item    WHERE  color_accessories.`code` = ?   ");
				$stmt_t->execute(array($row['code']));

			}else if ($row['model']=='savers')
			{
				$stmt_t= $this->db->prepare("SELECT  product_savers.location, product_savers.img,product_savers.title FROM product_savers    WHERE  product_savers.`code` = ?   ");
				$stmt_t->execute(array($row['code']));
			}else
			{

				$code='code_'.$row['model'];
				$color='color_'.$row['model'];
				$table=$row['model'];


				$stmt_t= $this->db->prepare("SELECT  {$code}.location, {$color}.img,{$table}.title FROM {$code} INNER JOIN {$color} ON {$color}.id={$code}.id_color  INNER JOIN {$table} ON {$table}.id={$color}.id_item WHERE  {$code}.`code` = ?  ");
				$stmt_t->execute(array($row['code']));

			}


            $result = $stmt_t->fetch(PDO::FETCH_ASSOC);
            $row['image'] = $result['img'];


            $stmt_all_loc = $this->db->prepare("SELECT location,quantity,new_location FROM location WHERE code=? AND `model`=?    ");
            $stmt_all_loc->execute(array($row['code'], $table));
            $row['all_location'] = array();
            while ($rowloc = $stmt_all_loc->fetch(PDO::FETCH_ASSOC)) {
                $row['all_location'][] = $rowloc['location'];
            }

            $row['title'] = $result['title'];


            $row['image'] = $result['img'];

            $row['tolocation'] = array();
            $stmt_to_location = $this->db->prepare("SELECT location,id,quantity_trans as quantity FROM location_transport_convert WHERE  `transport`=?  AND code=?  AND  model =? AND from_location=? ");
            $stmt_to_location->execute(array($transport, $row['code'], $row['model'], $row['location']));
            while ($rowL = $stmt_to_location->fetch(PDO::FETCH_ASSOC)) {
                $row['tolocation'][] = $rowL;
            }

            $stmt_quantity = $this->db->prepare("SELECT SUM(quantity) as quantity FROM location_transport_convert WHERE  `transport`=?  AND code=? AND  model =?  AND from_location=?");
            $stmt_quantity->execute(array($transport, $row['code'], $row['model'], $row['location']));
            $row['toquantity'] = $stmt_quantity->fetch(PDO::FETCH_ASSOC)['quantity'];

            $row['quantity'] = (int)$row['quantity'];


            $row['confirm']=$this->UserInfo($row['confirm_user']);

            $data[] = $row;
		}





		require($this->render($this->folder, 'transport_user', 'html/view', 'php'));
		$this->adminFooterController();

	}



    function list_transport_user($id)
    {


        $this->checkPermit('list_transport_user', $this->folder);
        $this->adminHeaderController($this->langControl('transport_confirm '));



        $date=null;
        $todate=null;

        $from_date_stm=null;
        $to_date_stm=null;

        if (isset($_GET['date'])&&isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);
        }



        require($this->render($this->folder, 'transport_user', 'html/list_transport_user', 'php'));
        $this->adminFooterController();

    }


    public function processing_list_transport_user($id,$from_date_stm=null,$to_date_stm=null)
    {

        $this->checkPermit('list_transport_user', $this->folder);

        $table = 'location_transport_convert';
        $primaryKey =  $table.'.id';


        $columns = array(


            array('db' =>  $table.'.model', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return $this->langControl($d);
                }
            ),


            array('db' =>  $table.'.user_pull', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return  $this->UserInfo($d);
                }
            ),

            array('db' => $table.'.transport', 'dt' =>2,
                'formatter' => function ($d, $row) {
                    return "<a  class='btn btn-warning' href='".url.'/'.$this->folder."/view_transport_user?g={$d}' >{$d}</a>";
                }),

            array('db' =>  $table.'.crystal_bill', 'dt' => 3 ),

            array('db' => $table.'.transport', 'dt' =>4,
                'formatter' => function ($d, $row) {
                    return "<a  class='btn btn-primary' href='".url.'/'.$this->folder."/export_transport_confirm?g={$d}' >   <span> تصدير مواد المناقلة </span> </a>";
                }),

            array('db' =>  $table.'.confirm_user', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return  $this->UserInfo($d);
                }
            ),
            array('db' => $table.'.date', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i a', $d);
                }
            ),


            array('db' => $table.'.export', 'dt' => 7,
                'formatter' => function ($d, $row) {

                    if ($d == 1)
                    {
                        return "<i class='fa fa-check-circle' style='color: green'></i>";

                    }else
                    {
                        return "<i class='fa fa-times-circle' style='color: red'></i>";

                    }
                }
            ),




            array('db' => $table.'.user_export', 'dt' => 8,
                'formatter' => function ($d, $row) {
                    if ($d)
                    {
                        return  $this->UserInfo($d);
                    }else
                    {
                        return  '';
                    }

                }
            ),
            array('db' => $table.'.date_export', 'dt' => 9,
                'formatter' => function ($d, $row) {
                    if ($d)
                    {
                        return date('Y-m-d h:i a', $d);
                    }else
                    {
                        return  '';
                    }

                }
            ),



            array(  'db' => $table.'.transport', 'dt'=>10,
                'formatter' => function( $d, $row ) {

                    if ($this->permit('delete',$this->folder)) {
                        return "<button  onclick='delete_transport({$d})' class='btn btn-danger'  ><i class='fa fa-trash'></i></button>";

                    }else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),

        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );




        $join = "INNER JOIN user ON user.id={$table}.confirm_user ";

        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array("{$table}.active = 2","isdelete = 0","{$table}.confirm_user = {$id}");
        }else{
            $whereAll = array("{$table}.active = 2","{$table}.confirm_user = {$id}","{$table}.date BETWEEN {$from_date_stm} AND {$to_date_stm}","isdelete = 0");

        }

        $group = "GROUP BY {$table}.transport";

        $result = SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll, null, $group);

        echo json_encode($result);




    }




}