<?php
trait transport_confirm
{

	function __construct()
	{
		parent::__construct();
		$this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject

	}



	function transport_confirm()
	{


		$this->checkPermit('transport_confirm', $this->folder);
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



        $bill=array();
        $stmtdata = $this->db->prepare("SELECT transport FROM location_transport_convert WHERE  `active` = 2 AND  isdelete =0   AND `number_group`  = 0 GROUP BY transport ");
        $stmtdata->execute();
        while ($row=$stmtdata->fetch(PDO::FETCH_ASSOC)) {
            $bill[]=$row;
        }

            require($this->render($this->folder, 'transport_confirm', 'html/index', 'php'));
		$this->adminFooterController();

	}


	public function processing_transport_confirm($from_date_stm=null,$to_date_stm=null)
	{

		$this->checkPermit('processing_transport_confirm', $this->folder);

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
					return "<a  class='btn btn-warning' href='".url.'/'.$this->folder."/view_transport_confirm?g={$d}' >{$d}</a>";
				}),


			array('db' => $table.'.transport', 'dt' =>3,
				'formatter' => function ($d, $row) {
					return "<a  class='btn btn-primary' href='".url.'/'.$this->folder."/export_transport_confirm?g={$d}' >   <span> تصدير مواد المناقلة </span> </a>";
				}),

			array('db' =>  $table.'.confirm_user', 'dt' => 4,
				'formatter' => function ($d, $row) {
					return  $this->UserInfo($d);
				}
			),
			array('db' => $table.'.date', 'dt' => 5,
				'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i a', $d);
				}
			),
			array('db' => $table.'.export', 'dt' => 6,
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

            array('db' => $table.'.user_export', 'dt' => 7,
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
            array('db' => $table.'.date_export', 'dt' => 8,
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

            array(  'db' => $table.'.transport', 'dt'=>9,
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




        $join = "INNER JOIN user ON user.id={$table}.userid ";

        if (empty($from_date_stm) && empty($to_date_stm))
        {
            $whereAll = array("{$table}.active = 2","number_group = 0","isdelete = 0");
        }else{
            $whereAll = array("{$table}.active = 2","{$table}.date BETWEEN {$from_date_stm} AND {$to_date_stm}","number_group = 0 ","isdelete = 0");

        }

        $group = "GROUP BY {$table}.transport";

        $result = SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll, null, $group);

        echo json_encode($result);




    }


	function view_transport_confirm(){

		if (isset($_GET['g']))
		{
			$transport=$_GET['g'];
		}else{
			$transport=0;
		}

		$this->checkPermit('transport_confirm', $this->folder);
		$this->adminHeaderController($this->langControl('transport_confirm '));

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





		require($this->render($this->folder, 'transport_confirm', 'html/view', 'php'));
		$this->adminFooterController();

	}




	function export_transport_confirm(){

		if (isset($_GET['g']))
		{
		  	$transport=$_GET['g'];
		}else{
			$transport=0;
		}

		$this->checkPermit('export_transport_confirm', $this->folder);
		$this->adminHeaderController($this->langControl('export_transport_confirm ') .'  رقم المناقلة '.$transport);


        $crystal_bill='';
		$stmt=$this->db->prepare("SELECT *FROM location_transport_convert WHERE transport=? ");
        $stmt->execute(array($transport));
        $data=array();
        $m=0;
        $q=0;
        $p=0;
        $sum_p=0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
             $row['from_store_location']=$this->store_location($row['from_location'],$row['model'],$row['code']) ;
             $row['to_store_location']= $this->store_location($row['location'],$row['model'],$row['code']) ;

            if ($row['from_store_location'] != $row['to_store_location'] ||   $row['from_store_location'] == 'لم يتم تحديد مجموعة للمستودعات' || $row['to_store_location'] == 'لم يتم تحديد مجموعة للمستودعات' ) {
                $crystal_bill=$row['crystal_bill'];



                if ($row['model']=='mobile')
                {
                    $excel='excel';
                }else {
                    $excel='excel_'.$row['model'];
                }
                $row['price']=0;
                $stmt_excel=$this->db->prepare("SELECT *FROM {$excel} WHERE code=?");
                $stmt_excel->execute(array($row['code']));
                if ($stmt_excel->rowCount() > 0)
                {
                    $row['price'] = $stmt_excel->fetch(PDO::FETCH_ASSOC)['price_dollars'];
                }

                $m=$m+1;
                $q=$q+$row['quantity'];


                $p=$row['price']*$row['quantity'];
                $sum_p=$sum_p+$p;

                $row['title']=$this->tile_table($row['code'],$row['model']) ;
                $row['from_store_location']=$this->store_location($row['from_location'],$row['model'],$row['code']) ;
                $row['to_store_location']= $this->store_location($row['location'],$row['model'],$row['code']) ;
                $row['details']= "<div class='text-right'>{$row['crystal_bill']},{$row['transport']},{$this->UserInfo($row['user_pull'])},{$this->UserInfo($row['userid'])},{$this->note_transport($row['code'],$row['from_location'],$row['model'],$row['transport'])}  </div>";
                $data[]=$row;
            }

        }




		require($this->render($this->folder, 'transport_confirm', 'html/export', 'php'));
		$this->adminFooterController();

	}


    function crystal_bill_transport()
    {
        if ($this->handleLogin()) {


            $transport = trim(str_replace(' ', '', $_GET['transport']));
            $crystal_bill = trim(str_replace(' ', '', $_GET['crystal_bill']));



                    $stmt_p = $this->db->prepare("UPDATE  `location_transport_convert` SET  crystal_bill=? , user_enter=?,`date_enter`=?  WHERE  transport  =?  ");
                    $stmt_p->execute(array($crystal_bill, $this->userid,time(),$transport));
                    if ($stmt_p->rowCount() > 0) {
                        echo '1';
                    }

        }

    }



    function delete_transport()
    {


        if ($this->handleLogin())
        {
            $transport= $_GET['transport'];
            $stmt=$this->db->prepare("SELECT *FROM location_transport_convert WHERE transport=? AND active = 2 AND  isdelete=0 ");
            $stmt->execute(array($transport));

            if ($stmt->rowCount() > 0) {

               while ( $result = $stmt->fetch(PDO::FETCH_ASSOC)) {

                   $stmt_ch = $this->db->prepare("SELECT *FROM location WHERE location=? AND  code = ? AND  model = ?");
                   $stmt_ch->execute(array($result['location'], $result['code'], $result['model']));
                   if ($stmt_ch->rowCount() > 0) {

                       $location=$stmt_ch->fetch(PDO::FETCH_ASSOC);

                       $qy=0;

                       if ((int)$location['quantity'] >= (int)$result['quantity'] )
                       {
                           $qy= (int)$result['quantity'];
                       }else
                       {
                           $qy =(int)$location['quantity'];
                       }


                       $stmt_ul1 = $this->db->prepare("UPDATE  `location` SET  quantity = quantity+? , userid=?,`date`=?  WHERE   location=? AND  code = ? AND  model = ? ");
                       $stmt_ul1->execute(array($qy, $this->userid, time(), $result['from_location'], $result['code'], $result['model']));
                       if($stmt_ul1->rowCount()  > 0)
                       {
                           $this->filter_location_tracking_quantity($result['code'],$result['model'], $result['from_location'],$qy,' حذف مناقلة - رقم12','+',$transport);

                       }else
                       {
                            $this->filter_location_error_quantity($result['code'],$result['model'], $result['from_location'],$qy,' حذف مناقلة - رقم الخظأ 12','+',$transport);

                       }




                       $stmt_ul2 = $this->db->prepare("UPDATE  `location` SET  quantity = quantity-? , userid=?,`date`=?  WHERE   location=? AND  code = ? AND  model = ? ");
                       $stmt_ul2->execute(array($qy, $this->userid, time(), $result['location'], $result['code'], $result['model']));
                       if($stmt_ul2->rowCount()  > 0)
                       {
                           $this->filter_location_tracking_quantity($result['code'],$result['model'], $result['location'],$qy,' حذف مناقلة - رقم13','-',$transport);

                       }else
                       {
                           $this->filter_location_error_quantity($result['code'],$result['model'], $result['location'],$qy,' حذف مناقلة - رقم الخظأ 13','-',$transport);

                       }



                       $stmt_trnst = $this->db->prepare("UPDATE  `location_transport_convert` SET isdelete=1, user_delete=?,`date_delete`=?  WHERE    transport = ?  ");
                       $stmt_trnst->execute(array($this->userid, time(), $transport));
                       if ($stmt_trnst->rowCount() > 0) {
                           echo 'deleted';
                       }

                   }
               }
            }

        }

    }


    function export_transport()
    {

        $transport=$_GET['transport'];
        $stmt=$this->db->prepare("UPDATE location_transport_convert SET export=1,user_export=?,date_export=? WHERE transport =?  ");
        $stmt->execute(array($this->userid,time(),$transport));
    }





}