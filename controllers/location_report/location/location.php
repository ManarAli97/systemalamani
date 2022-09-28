<?php


trait location
{

	function __construct()
	{
		parent::__construct();

	}



	function location()
	{


		$this->checkPermit('location_report', $this->folder);
		$this->adminHeaderController($this->langControl('location_report '));

		if (isset($_GET['model']) && isset($_GET['category'])) {

			$categoryIds = $_GET['category'];


			$id = explode('_', $categoryIds);
			$id = $id[1];


			$model = $_GET['model'];

			$name_category = 'category_' . $model;
			$breadcumbsx = $this->BreadcumbsPublic($name_category, $id);
			$category ='<li class="breadcrumb-item active" aria-current="page" >' . $this->langControl($model) .' </li> ';
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

		$from=null;
		$to=null;
		if (isset($_GET['from']))
		{
			$from=$_GET['from'];
			$to=$_GET['to'];
		}




        $group=0;
		$stmt = $this->db->prepare("SELECT  group_location FROM location WHERE   1 ORDER BY group_location  DESC LIMIT 1");
		$stmt->execute();
		if ($stmt->rowCount() > 0)
        {
            $group=$stmt->fetch(PDO::FETCH_ASSOC)['group_location'];

        }


		require($this->render($this->folder, 'location/html', 'index', 'php'));
		$this->adminFooterController();
	}

	public function processing_report_location($from=0,$to=0,$model='mobile',$id=null)
	{


		$this->checkPermit('location_report', $this->folder);

		$table = $model;
		$primaryKey = $model.'.id';

		if ($model=='mobile') {
			$code = 'code';
			$color = 'color';
		}else  {
			$code = 'code_'.$model;
			$color = 'color_'.$model;
		}
		$category='category_'.$model;

		$columns = array(

			array(  'db' =>'location.sequence', 'dt'=>0),
			array( 'db' => 'location.id', 'dt' => 1 ,
				'formatter' => function( $d, $row ) {
					return "<input type='checkbox'    class='childcheckbox'  name='item[]' value='{$d}'>";
				}
			),
			array(  'db' => $model.'.title', 'dt'=>2),
			array(  'db' => $code.'.code', 'dt'=>3),
			array(  'db' => 'location.location', 'dt'=>4,
                'formatter'=> function($d,$row)
                {
                    return $this->tamayaz_locations($d);
                }
                ),
			array(  'db' => 'location.quantity', 'dt'=>5),

			/*     المجموعات    */
			array(  'db' => 'location.id', 'dt'=>6,
				'formatter' => function( $d, $row ) {
					return $this->table_location_list($d,$row[3],$row[11],1,null);
				}
			),
			array(  'db' =>'location.id', 'dt'=>7,
				'formatter' => function( $d, $row ) {
					return $this->table_location_list($d,$row[3],$row[11],2,null);
				}
			),
			array(  'db' => 'location.id', 'dt'=>8,
				'formatter' => function( $d, $row ) {
					return $this->table_location_list($d,$row[3],$row[11],3,null);
				}
			),


		 	array(  'db' => 'location.id', 'dt'=>9,
				'formatter' => function( $d, $row ) {
					return $this->table_location_list($d,$row[3],$row[11],4,null);
				}
			),
			array(  'db' => 'location.id', 'dt'=>10,
				'formatter' => function( $d, $row ) {
					return $this->table_location_list($d,$row[3],$row[11],5,null);
				}
			),

            array(  'db' =>'location.model', 'dt'=>11),

		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);

		if ($model !=null && $id != null)
		{
			$this->ids[]=$id;
			if (!empty($this->getLoopIdX($id,$category)))
			{
				$this->ids[]=  $this->getLoopIdX($id,$category);
			}
			$ids_cat=implode(',', $this->ids);


			$join = "INNER JOIN {$color} ON {$color}.id_item={$model}.id INNER JOIN `{$code}` ON {$code}.id_color={$color}.id  INNER JOIN location ON location.code={$code}.code";
			$whereAll = array("{$model}.id_cat IN({$ids_cat})","location.model='{$model}'","location.quantity > 0","location.sequence BETWEEN {$from} AND {$to}");


			$result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null);

			echo json_encode($result);

		}else{

			$join = "INNER JOIN {$color} ON {$color}.id_item={$model}.id INNER JOIN `{$code}` ON {$code}.id_color={$color}.id  INNER JOIN location ON location.code={$code}.code";
			$whereAll = array("location.model='{$model}'","location.quantity > 0","location.sequence BETWEEN {$from} AND {$to} ");

			$result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null);

//			$start=$_REQUEST['start']+1;
//			$idx=1;
//			foreach($result['data'] as &$res){
//				$res[0]=(string)$start;
//				$start++;
//				$idx++;
//			}
			echo json_encode($result);


		}


	}


	public function processing_report_accessories_location($from=0,$to=0,$model='accessories',$id=null)
	{

		$this->checkPermit('location_report', $this->folder);


		$table = $model;
		$primaryKey = $model.'.id';

		$color = 'color_'.$model;

		$category='category_'.$model;

		$columns = array(

			array(  'db' =>'location.sequence', 'dt'=>0),
			array( 'db' => 'location.id', 'dt' => 1 ,
				'formatter' => function( $d, $row ) {
					return "<input type='checkbox'    class='childcheckbox'  name='item[]' value='{$d}'>";
				}
			),
			array(  'db' => $model.'.title', 'dt'=>2),
			array(  'db' => $color.'.code', 'dt'=>3),
			array(  'db' => $color.'.maximum', 'dt'=>4),
			array(  'db' => $color.'.minimum', 'dt'=>5),
            array(  'db' => 'location.location', 'dt'=>6,
                'formatter'=> function($d,$row)
                {
                    return $this->tamayaz_locations($d);
                }
            ),
			array(  'db' => 'location.quantity', 'dt'=>7),

			/*     المجموعات    */
			array(  'db' =>'location.id', 'dt'=>8,
				'formatter' => function( $d, $row ) {
					return $this->table_location_list($d,$row[3],$row[13],1);
				}
			),
			array(  'db' =>'location.id', 'dt'=>9,
				'formatter' => function( $d, $row ) {
					return $this->table_location_list($d,$row[3],$row[13],2);
				}
			),
			array(  'db' =>'location.id', 'dt'=>10,
				'formatter' => function( $d, $row ) {
					return $this->table_location_list($d,$row[3],$row[13],3);
				}
			),
            array(  'db' =>'location.id', 'dt'=>11,
                'formatter' => function( $d, $row ) {
                    return $this->table_location_list($d,$row[3],$row[13],4);
                }
            ),
            array(  'db' =>'location.id', 'dt'=>12,
                'formatter' => function( $d, $row ) {
                    return $this->table_location_list($d,$row[3],$row[13],5);
                }
            ),

            array(  'db' => 'location.model', 'dt'=>13),


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);

		if ($model !=null && $id != null)
		{
			$this->ids[]=$id;
			if (!empty($this->getLoopIdX($id,$category)))
			{
				$this->ids[]=  $this->getLoopIdX($id,$category);
			}
			$ids_cat=implode(',', $this->ids);


			$join = "INNER JOIN {$color} ON {$color}.id_item={$model}.id  INNER JOIN location ON location.code={$color}.code ";
			$whereAll = array("{$model}.id_cat IN({$ids_cat})","location.model='{$model}'","location.quantity > 0","location.sequence BETWEEN {$from} AND {$to}");


			$result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null);

			echo json_encode($result);

		}else{

			$join = "INNER JOIN {$color} ON {$color}.id_item={$model}.id  INNER JOIN location ON location.code={$color}.code";
			$whereAll = array( "location.model='{$model}'","location.quantity > 0","location.sequence BETWEEN {$from} AND {$to} ");


			$result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null);

//			$start=$_REQUEST['start']+1;
//			$idx=1;
//			foreach($result['data'] as &$res){
//				$res[0]=(string)$start;
//				$start++;
//				$idx++;
//			}
			echo json_encode($result);


		}


	}


	public function processing_report_savers_location($from=0,$to=0,$model=null,$id=null)
	{

		$this->checkPermit('location_report', $this->folder);




		$table = 'product_savers';
		$primaryKey = 'product_savers.id';
		$category='type_device';

		$columns = array(

			array(  'db' =>'location.sequence', 'dt'=>0),
			array( 'db' => 'location.id', 'dt' => 1 ,
				'formatter' => function( $d, $row ) {
					return "<input type='checkbox'    class='childcheckbox'  name='item[]' value='{$d}'>";
				}
			),

			array(  'db' => $table.'.title', 'dt'=>2),
			array(  'db' => $table.'.code', 'dt'=>3),
            array(  'db' => 'location.location', 'dt'=>4,
                'formatter'=> function($d,$row)
                {
                    return $this->tamayaz_locations($d);
                }
            ),
			array(  'db' => 'location.quantity', 'dt'=>5),

			/*     المجموعات    */
			array(  'db' => 'location.id', 'dt'=>6,
				'formatter' => function( $d, $row ) {
					return $this->table_location_list($d,$row[3],$row[11],1,null);
				}
			),
			array(  'db' => 'location.id', 'dt'=>7,
				'formatter' => function( $d, $row ) {
					return $this->table_location_list($d,$row[3],$row[11],2,null);
				}
			),
			array(  'db' => 'location.id', 'dt'=>8,
				'formatter' => function( $d, $row ) {
					return $this->table_location_list($d,$row[3],$row[11],3,null);
				}
			),
		 	array(  'db' => 'location.id', 'dt'=>9,
				'formatter' => function( $d, $row ) {
					return $this->table_location_list($d,$row[3],$row[11],4,null);
				}
			),
			array(  'db' => 'location.id', 'dt'=>10,
				'formatter' => function( $d, $row ) {
					return $this->table_location_list($d,$row[3],$row[11],5,null);
				}
			),
            array(  'db' =>'location.model', 'dt'=>11),


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);



		$join = "INNER JOIN location ON location.code={$table}.code  ";
		$whereAll = array( "location.model='savers'","location.quantity > 0","location.sequence BETWEEN {$from} AND {$to}");
//		$group="GROUP BY {$table}.code";

		$result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null);

//			$start=$_REQUEST['start']+1;
//			$idx=1;
//			foreach($result['data'] as &$res){
//				$res[0]=(string)$start;
//				$start++;
//				$idx++;
//			}
		echo json_encode($result);



	}




	function  table_location_list($id,$code,$model,$g,$color=null)
	{


			$stmt=$this->db->prepare("SELECT *FROM `location` WHERE id=? AND code=? AND `model`=? AND group_location=? AND quantity > 0 ");
			$stmt->execute(array($id,$code,$model,$g));


		if ($stmt->rowCount() > 0)
		{
			$html="
		<table class='table table-bordered' style='background: #fff;margin: 0;padding: 0'><tbody>";

			$html .= "
		 <tr>
        <td style='padding: 0;    vertical-align: unset;background: #add'> م  </td>
        <td style='padding: 0;    vertical-align: unset;background: #fea''>  ك </td>
      
           </tr>
			";

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$html .= "
		 <tr>
        <td style='padding: 0;    vertical-align: unset;background: #ad7'>   {$row['location']}   </td>
        <td style='padding: 0;    vertical-align: unset;background: #ffffff'> {$row['quantity']} </td>
      
           </tr>
			";

			}

			$html.="</tbody> </table>";
			return $html ;
		}


	}




	function checked_purchases_all_location($model)
	{
		if ($this->handleLogin()) {

//			if ($model=='savers')
//			{
//				$model='product_savers';
//			}

            $group = $_POST['group'] ;
             $from= $_POST['from'];
             $to = $_POST['to'];
             $all = $_POST['all'];

            if ($all==0) {

                if (isset($_REQUEST['item'])) {
                    $myArray = $_REQUEST['item'];


                    if (!empty($myArray)) {

                        $Ids = implode(',', $myArray);

                        $stmt = $this->db->prepare("UPDATE location  SET  `group_location`=?,userid=? WHERE `id`   IN ({$Ids})   AND `model`= ?   ");
                        $stmt->execute(array($group, $this->userid, $model));
                        if ($stmt->rowCount() > 0)
                        {
                            echo json_encode(array('done' => $myArray, JSON_FORCE_OBJECT));
                        }else
                        {
                            echo json_encode(array('error_ch' => array('empty' => 'قيمة فارغ'), JSON_FORCE_OBJECT));

                        }

                    } else {
                        echo json_encode(array('error_ch' => array('empty' => 'قيمة فارغ'), JSON_FORCE_OBJECT));

                    }

                } else {
                    echo json_encode(array('empty' => array('empty' => 'قيمة فارغ'), JSON_FORCE_OBJECT));

                }
            }else
            {


                 $stmt = $this->db->prepare("UPDATE location  SET  `group_location`=?,userid=? WHERE   `model`= ?  AND  `sequence`  between {$from} AND  {$to}  ");
                $stmt->execute(array($group, $this->userid, $model));
                if ($stmt->rowCount() > 0)
                {
                    echo json_encode(array('done' => array('update'), JSON_FORCE_OBJECT));

                }else
                {
                    echo json_encode(array('error_ch' => array('empty' => 'قيمة فارغ'), JSON_FORCE_OBJECT));

                }
            }
		}
	}



}
