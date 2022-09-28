<?php
require 'location/location.php';
require 'transport_not_confirm/transport_not_confirm.php';
require 'transport_confirm/transport_confirm.php';
require 'transport_user/transport_user.php';
require 'store_transport/store_transport.php';
require 'transport_search/transport_search.php';
class location_report extends Controller
{
	use location,transport_not_confirm,transport_confirm,transport_user,store_transport,transport_search;

	protected $from=null;
	protected $to=null;
	public $ids=array();
	public $fromDate=0;
	public $toDate=0;
	public $id_gl=0;
	function __construct()
	{
		parent::__construct();
		$this->table='location_transport';
		$this->location_transport_convert='location_transport_convert';
		$this->location_groups = 'location_groups';
		$this->group_bill = 'location_transport_groups';


		$this->group=array(
			'0'=>'الغاء تحديد المجموعة',
			'1'=>'المجموعة الاولى',
			'2'=>'المجموعة الثانية',
			'3'=>'المجموعة الثالثه',
 			'4'=>'المجموعة الرابعة',
 			'5'=>'المجموعة الخامسة',
		);

	}


	public function createTB()
	{

		$this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `location` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `quantity` int(11) NOT NULL,
          `transport` int(11) NOT NULL,
          `userid` int(11) NOT NULL,
          `active` int(11) NOT NULL  DEFAULT '0',
           `not_convert_quantity` int(11) NOT NULL,
           `convert_quantity` int(11) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



		$this->db->query("CREATE TABLE IF NOT EXISTS `{$this->location_transport_convert}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `location` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `quantity` int(11) NOT NULL,
          `transport` int(11) NOT NULL,
          `userid` int(11) NOT NULL,
          `active` int(11) NOT NULL  DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



		$this->db->query("CREATE TABLE IF NOT EXISTS `{$this->group_bill}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `number_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `crystal_bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `number` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `userid` int (10) NOT NULL,
           `user_input_bill` int (10) NOT NULL,
           `checked` int(20) NOT NULL DEFAULT 0,
           `user_checked` int(20) NOT NULL,
           `date` bigint(20) NOT NULL,
           
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



		return $this->db->cht(array($this->table ));

	}

	function checkSerialCode()
	{
		if ($this->handleLogin())
		{
			$serial=trim($_GET['serial']);
			$code=trim($_GET['code']);
			$model=trim($_GET['model']);
			$stmt=$this->db->prepare("SELECT *FROM serial WHERE serial=? AND code=? AND model=?");

			$stmt->execute(array($serial,$code,$model));
			if ($stmt->rowCount() <= 0)
			{
				echo 'false';
			}


		}


	}


	function report()
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

		$from=null;
		$to=null;
		if (isset($_GET['from']))
		{
			$from=$_GET['from'];
			$to=$_GET['to'];
		}


		$fromDate_format=0;
		$toDate_format=0;
		$fromDate=0;
		$toDate=0;
		if (isset($_GET['fromDate']) && isset($_GET['toDate']) )
		{
			$fromDate_format=$_GET['fromDate'];
			$toDate_format=$_GET['toDate'];

			  $fromDate=strtotime($_GET['fromDate']);
		  	$toDate=strtotime($_GET['toDate']);
		}


//
//		$group=0;
//		$stmt = $this->db->prepare("SELECT  group_location FROM location WHERE   1 ORDER BY group_location  DESC LIMIT 1");
//		$stmt->execute();
//		if ($stmt->rowCount() > 0)
//		{
//			$group=$stmt->fetch(PDO::FETCH_ASSOC)['group_location'];
//
//		}




		$stmtdata = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 0 AND `userid`=? ");
		$stmtdata->execute(array($this->userid));
		$data=array();
		$type_transport=null;
		while ($row=$stmtdata->fetch(PDO::FETCH_ASSOC))
		{
			$row['serial_req']='';
			if ($this->check_serial_required($row['code'],'serial_transfer',$row['model']) == true)
			{
				$row['serial_req']='required';
			}

			$row['listSerial']=$this->getSerialCode($row['code'],$row['quantity'],$row['model']);


			$type_transport=$row['model'];
		    $row['location']=   $this->tamayaz_locations($row['location']);
			$data[]=$row;
		}


		require($this->render($this->folder, 'html', 'index', 'php'));
		$this->adminFooterController();
	}



	public function processing_report($from=0,$to=0,$model='mobile',$id=null,$fromDate=0,$toDate=0)
	{

		$this->from=$from;
		$this->to=$to;
		$this->checkPermit('location_report', $this->folder);

		$this->fromDate=$fromDate;
		$this->toDate=$toDate;


		$table = $model;
		$primaryKey = $model.'.id';

		if ($model=='mobile') {
			$code = 'code';
			$color = 'color';
		}else {
			$code = 'code_'.$model;
			$color = 'color_'.$model;
		}
		$category='category_'.$model;

		$columns = array(

			array(  'db' =>'location.sequence', 'dt'=>0),

			array(  'db' => $color.'.img', 'dt'=>1,
				'formatter' => function( $d, $row ) {
					$img=$this->save_file.$d;
					return "<img style='width: 100px' src='$img'>";
				}
			),

			array(  'db' => $model.'.title', 'dt'=>2),
			array(  'db' => $code.'.code', 'dt'=>3,
				'formatter' => function( $d, $row ) {
					return "<span onclick='copy_text(this)' class='copyToClipboard' title='نسخ' data-clipboard-text='{$d}'>{$d}</span>";
				}
			),
			array(  'db' => 'location.model', 'dt'=>4,
				'formatter' => function( $d, $row ) {
					return $this->sum_quantity_location($row[3],$d);
				}
			),

			array(  'db' => 'location.model', 'dt'=>5,
				'formatter' => function( $d, $row ) {

					if ($this->fromDate > 0 && $this->toDate > 0){
						$stmt=$this->db->prepare("SELECT  SUM(`number`) as num  FROM cart_shop_active WHERE code=? AND `table`=?  AND  date_prepared between  ? AND ?");
						$stmt->execute(array($row[3],$d,$this->fromDate, $this->toDate));
					}else
					{

						$stmt=$this->db->prepare("SELECT  SUM(`number`) as num  FROM cart_shop_active WHERE code=? AND `table`=?");
						$stmt->execute(array($row[3],$d));
					}

					$result=$stmt->fetch(PDO::FETCH_ASSOC);
					return $result['num'];

				}
			),

			/*     المجموعات    */
			array(  'db' =>'location.model', 'dt'=>6,
				'formatter' => function( $d, $row ) {
					return $this->table_location($row[3],$d,$this->from);
				}
			),
			array(  'db' =>'location.model', 'dt'=>7,
				'formatter' => function( $d, $row ) {
					return $this->table_location($row[3],$d,$this->to);
				}
			),

			/*	array(  'db' =>'location.model', 'dt'=>7,
                    'formatter' => function( $d, $row ) {
                        return $this->table_locion($row[2],$d,3);
                    }
                ),
            /*	array(  'db' =>'location.model', 'dt'=>7,
                    'formatter' => function( $d, $row ) {
                        return $this->table_location($row[2],$d,4);
                    }
                ),
                array(  'db' =>'location.model', 'dt'=>8,
                    'formatter' => function( $d, $row ) {
                        return $this->table_location($row[2],$d,5);
                    }
                ),*/



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


			$join = "INNER JOIN {$category} ON {$category}.id={$model}.id_cat INNER JOIN {$color} ON {$color}.id_item={$model}.id INNER JOIN `{$code}` ON {$code}.id_color={$color}.id  INNER JOIN location ON location.code={$code}.code";
			$whereAll = array("{$model}.id_cat IN({$ids_cat})","location.model='{$model}'","  ( location.group_location  = {$from}  OR location.group_location  =  {$to} ) ");
			$group="GROUP BY {$code}.code";

			$result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group);
			echo json_encode($result);

		}else{

			$join = "INNER JOIN {$color} ON {$color}.id_item={$model}.id INNER JOIN `{$code}` ON {$code}.id_color={$color}.id  INNER JOIN location ON location.code={$code}.code";
			$whereAll = array("location.model='{$model}'","  ( location.group_location  = {$from}  OR location.group_location  =  {$to} ) ");
			$group="GROUP BY {$code}.code";

			$result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group);

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


	public function processing_report_accessories($from=0,$to=0,$model='accessories',$id=null,$fromDate=0,$toDate=0)
	{

		$this->checkPermit('location_report', $this->folder);
	  	$this->from=$from;
	  	$this->to=$to;
		  $this->fromDate=$fromDate;
		  $this->toDate=$toDate;

		$table = $model;
		$primaryKey = $model.'.id';

	    $color = 'color_'.$model;

		$category='category_'.$model;

		$columns = array(

			array(  'db' =>'location.sequence', 'dt'=>0),

			array(  'db' => $color.'.img', 'dt'=>1,
				'formatter' => function( $d, $row ) {
					$img=$this->save_file.$d;
					return "<img style='width: 100px' src='$img'>";
				}
			),

			array(  'db' => $model.'.title', 'dt'=>2),
			array(  'db' => $color.'.code', 'dt'=>3,
				'formatter' => function( $d, $row ) {
					return "<span onclick='copy_text(this)' class='copyToClipboard' title='نسخ' data-clipboard-text='{$d}'>{$d}</span>";
				}
			),
			array(  'db' => $color.'.maximum', 'dt'=>4),
			array(  'db' => $color.'.minimum', 'dt'=>5),
			array(  'db' => 'location.model', 'dt'=>6,
				'formatter' => function( $d, $row ) {
					return $this->sum_quantity_location($row[3],$d);
				}
			),
			array(  'db' => 'location.model', 'dt'=>7,
				'formatter' => function( $d, $row ) {

				if ($this->fromDate > 0 && $this->toDate > 0){
					$stmt=$this->db->prepare("SELECT  SUM(`number`) as num  FROM cart_shop_active WHERE code=? AND `table`=?  AND  date_prepared between  ? AND ?");
					$stmt->execute(array($row[3],$d,$this->fromDate, $this->toDate));
				}else
				{

					$stmt=$this->db->prepare("SELECT  SUM(`number`) as num  FROM cart_shop_active WHERE code=? AND `table`=?");
					$stmt->execute(array($row[3],$d));
				}

		     	$result=$stmt->fetch(PDO::FETCH_ASSOC);
		     	return $result['num'];


				}
			),

			/*     المجموعات    */
			array(  'db' => 'location.model', 'dt'=>8,
				'formatter' => function( $d, $row ) {

					$stmt=$this->db->prepare("SELECT SUM(quantity) as quantity FROM `location` WHERE code=? AND `model`=? AND group_location=? AND quantity > 0 ");
					$stmt->execute(array($row[3],$d,$this->from));
					$sq=0;
					if ($stmt->rowCount() > 0)
					{
						$sq=$stmt->fetch(PDO::FETCH_ASSOC)['quantity'];

					}
					$max=0;
					$min=0;
					if ($row[4])
					{
						$max=$row[4];
					}

					if ($row[5])
					{
						$min=$row[5];
					}
					$maxmin=($max+$min)/2;
					$q=$maxmin-$sq;
					if ($q>0)
					{
						return  $q;
					}else
					{
						return  0;
					}

				}
			),

			/*     المجموعات    */
			array(  'db' => 'location.model', 'dt'=>9,
				'formatter' => function( $d, $row ) {
					return $this->table_location($row[3],$d,$this->from);
				}
			),
			array(  'db' => 'location.model', 'dt'=>10,
				'formatter' => function( $d, $row ) {
					return $this->table_location($row[3],$d,$this->to);
				}
			),

			/*	array(  'db' => 'location.model', 'dt'=>9,
                    'formatter' => function( $d, $row ) {
                        return $this->table_locion($row[2],$d,3);
                    }
                ),
            /*	array(  'db' => 'location.model', 'dt'=>8,
                    'formatter' => function( $d, $row ) {
                        return $this->table_location($row[2],$d,4);
                    }
                ),
                array(  'db' => 'location.model', 'dt'=>9,
                    'formatter' => function( $d, $row ) {
                        return $this->table_location($row[2],$d,5);
                    }
                ),*/



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


			$join = "INNER JOIN {$color} ON {$color}.id_item={$model}.id  INNER JOIN location ON location.code={$color}.code";
			$whereAll = array("{$model}.id_cat IN({$ids_cat})","location.model='{$model}'"," ( location.group_location  = {$from}  OR location.group_location  =  {$to} )");
			$group="GROUP BY {$color}.code";

			$result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group);
			echo json_encode($result);


		}else{

			$join = "INNER JOIN {$color} ON {$color}.id_item={$model}.id  INNER JOIN location ON location.code={$color}.code ";
			$whereAll = array( "location.model='{$model}'"," ( location.group_location  = {$from}  OR location.group_location  =  {$to} ) ");
			$group="GROUP BY {$color}.code";


			$result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group);

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


	public function processing_report_savers($from,$to,$model=null,$id=null,$fromDate=0,$toDate=0)
	{
 
		$this->checkPermit('location_report', $this->folder);
		$this->from=$from;
		$this->to=$to;
		$this->fromDate=$fromDate;
		$this->toDate=$toDate;

		$table = 'product_savers';
		$primaryKey = 'product_savers.id';

		$columns = array(

			array(  'db' =>'location.sequence', 'dt'=>0),

			array(  'db' => $table.'.img', 'dt'=>1,
				'formatter' => function( $d, $row ) {
					$img=$this->save_file.$d;
					return "<img style='width: 100px' src='$img'>";
				}
			),

			array(  'db' => $table.'.title', 'dt'=>2),
			array(  'db' => $table.'.code', 'dt'=>3,
				'formatter' => function( $d, $row ) {
					return "<span onclick='copy_text(this)' class='copyToClipboard' title='نسخ' data-clipboard-text='{$d}'>{$d}</span>";
				}
			),

			array(  'db' => 'location.model', 'dt'=>4,
				'formatter' => function( $d, $row ) {
					return $this->sum_quantity_location($row[3],$d);
				}
			),
			array(  'db' => $table.'.code', 'dt'=>5,
				'formatter' => function( $d, $row ) {

					if ($this->fromDate > 0 && $this->toDate > 0){
						$stmt=$this->db->prepare("SELECT  SUM(`number`) as num  FROM cart_shop_active WHERE code=? AND `table`=?  AND  date_prepared between  ? AND ?");
						$stmt->execute(array($d,'product_savers',$this->fromDate, $this->toDate));
					}else
					{
						$stmt=$this->db->prepare("SELECT  SUM(`number`) as num  FROM cart_shop_active WHERE code=? AND `table`=?");
						$stmt->execute(array($d,'product_savers'));
					}

					$result=$stmt->fetch(PDO::FETCH_ASSOC);
					return $result['num'];


				}
			),

			/*     المجموعات    */
			array(  'db' =>'location.model', 'dt'=>6,
				'formatter' => function( $d, $row ) {
					return $this->table_location($row[3],$d,$this->from);
				}
			),
			array(  'db' => 'location.model', 'dt'=>7,
				'formatter' => function( $d, $row ) {
					return $this->table_location($row[3],$d,$this->to);
				}
			),

			/*	array(  'db' => 'location.model', 'dt'=>7,
                    'formatter' => function( $d, $row ) {
                        return $this->table_locion($row[2],$d,3);
                    }
                ),
            /*	array(  'db' => 'location.model', 'dt'=>7,
                    'formatter' => function( $d, $row ) {
                        return $this->table_location($row[2],$d,4);
                    }
                ),
                array(  'db' => 'location.model', 'dt'=>8,
                    'formatter' => function( $d, $row ) {
                        return $this->table_location($row[2],$d,5);
                    }
                ),*/



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
			$whereAll = array( "location.model='savers'"," ( location.group_location  = {$from}  OR location.group_location  =  {$to} ) ");
			$group="GROUP BY {$table}.code";

			$result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group);

//		$start=$_REQUEST['start']+1;
//		$idx=1;
//		foreach($result['data'] as &$res){
//			$res[0]=(string)$start;
//			$start++;
//			$idx++;
//		}
			echo json_encode($result);

	}




	function  table_location($code,$model,$g,$color=null)
	{

			$stmt=$this->db->prepare("SELECT *FROM `location` WHERE code=? AND `model`=? AND group_location=? AND quantity > 0 ");
			$stmt->execute(array($code,$model,$g));



		if ($stmt->rowCount() > 0)
		{
			$html="
		<table class='table table-bordered' style='background: #fff;margin: 0;padding: 0'><tbody>";

			$html .= "
		 <tr>
        <td style='padding: 0;    vertical-align: unset;background: #add'> م  </td>
        <td style='padding: 0;    vertical-align: unset;background: #fea'>  ك </td>
      
           </tr>
			";

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$html .= "
		 <tr>
        <td style='padding: 0;    vertical-align: unset;background: #ad7'>   {$this->tamayaz_locations($row['location'])}   </td>
        <td style='padding: 0;    vertical-align: unset;background: #ffffff'> {$row['quantity']} </td>
      
           </tr>
			";

			}

			$html.="</tbody> </table>";
			return $html ;
		}



	}




	function getLoopIdX($id,$category)
	{

		$stmt=$this->db->prepare("SELECT *from  {$category} WHERE  `relid` = {$id} AND `active` = 1 ");
		$stmt->execute(array($id));
		while (  $s=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->ids[]=$s['id'];
			$this->getLoopIdX($s['id'],$category);

		}

	}

	function getLoopId($id,$category)
	{

		if (!empty($id))
		{
			$this->ids[]=$id;
		}

		$stmt=$this->db->prepare("SELECT *from  {$category} WHERE  `relid` = {$id} AND `active` = 1 ");
		$stmt->execute(array($id));
		while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{

			$this->ids[]=$row['id'];


			$this->getLoopIdX($row['id'],$category);
		}

		return $this->ids;
	}


	function sum_quantity_location($code,$model,$color=null)
	{


		if ($model=='mobile')
		{
			$excel='excel';
		}else
		{
			$excel='excel_'.$model;
		}


		$stmt = $this->db->prepare("SELECT * FROM {$excel} WHERE `code`=? ");
		$stmt->execute(array($code));
		if ($stmt->rowCount()>0)
		{
			return $stmt->fetch(PDO::FETCH_ASSOC)['quantity'];
		}else
		{
			return 0;
		}


//		if (empty($color))
//		{
//			$stmt = $this->db->prepare("SELECT  SUM(quantity) as quantity FROM location WHERE  `code` = ? AND `model`=? AND `quantity` <> '' ");
//			$stmt->execute(array($code,$model));
//		}else{
//
//			$stmt = $this->db->prepare("SELECT  SUM(quantity) as quantity FROM location WHERE  `code` = ? AND `model`=? AND `color`=? AND `quantity` <> ''");
//			$stmt->execute(array($code,$model,$color));
//		}
//


	}





	function getMainCatDB($model)
	{
		if ($this->handleLogin())
		{

			if ($model != 'savers')
			{
				$category='category_'.$model;
				$stmt=$this->db->prepare("SELECT *FROM {$category} WHERE  `relid` = 0 ");
				$stmt->execute();

				if ($stmt->rowCount() > 0)
				{

					$html="<select  name='category'  id='sub_cags_p'  class='custom-select col-md-3 mb-3 list_menu_categ' onchange='sub_catgs2(this)' >";
					$html.="<option value='' disabled  selected > اختر قسم  </option>"  ;

					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


						$html.="<option value='{$model}_{$row['id']}'   >{$row['title']}</option>"  ;

					}

					$html.='</select>';

					echo $html ;
				}


			}
		}

	}




	function sub_catgs($data)
	{
		if ($this->handleLogin())
		{

			$d=explode('_',$data);

			$model=$d[0];
			$id=$d[1];
			$c=0;
			if ($model != 'savers')
			{
				$category = 'category_' . $model;
				$stmt = $this->db->prepare("SELECT *FROM {$category} WHERE  `relid` = ? ");
				$stmt->execute(array($id));


				if ($stmt->rowCount() > 0) {

					$html = "<select name='category'  id='{$data}' class='custom-select col-md-3 mb-3 list_menu_categ' onchange='sub_catgs(this)' >";
					$html.="<option value='' disabled  selected > اختر قسم  </option>"  ;
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

						$html .= "<option value='{$model}_{$row['id']}'   >{$row['title']}</option>";

						$c++;
					}

					$html .= '</select> ';

					echo $html;

				}
			}
		}

	}


	function sub_catgs2($data)
	{
		if ($this->handleLogin())
		{

			$d=explode('_',$data);

			$model=$d[0];
			$id=$d[1];
			if ($model != 'savers')
			{
				$category = 'category_' . $model;
				$stmt = $this->db->prepare("SELECT *FROM {$category} WHERE  `relid` = ? ");
				$stmt->execute(array($id));


				if ($stmt->rowCount() > 0) {

					$html = "<select name='category'  id='{$data}'  class='custom-select col-md-3 mb-3 list_menu_categ' onchange='sub_catgs2(this)' > ";
					$html.="<option value='' disabled  selected > اختر قسم  </option>"  ;
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

						$html .= "<option value='{$model}_{$row['id']}'   >{$row['title']}</option>";

					}

					$html .= '</select>';

					echo $html;

				}
			}
		}

	}






	function checked_purchases_all($model)
	{
		if ($this->handleLogin()) {

        $this->AddToTraceByFunction($this->userid,'location_report','checked_purchases_all/'.$model);

			if ($model=='savers')
			{
				$model='product_savers';
			}

			if (isset($_REQUEST['item'])) {
				$myArray = $_REQUEST['item'];
				$group = $_POST['group'];

				if (!empty($myArray))
				{
					foreach ($myArray as $code)
					{
						$stmt = $this->db->prepare("UPDATE location  SET  `group_location`=?,userid=? WHERE `code` =?  AND `model`= ?   ");
						$stmt->execute(array($group,$this->userid,$code,$model));
					}

					echo json_encode(array('done' => $myArray, JSON_FORCE_OBJECT));
				}else{
					echo json_encode(array('error_ch' => array('empty' => 'قيمة فارغ'), JSON_FORCE_OBJECT));

				}

			}
			else {
				echo json_encode(array('empty' => array('empty' => 'قيمة فارغ'), JSON_FORCE_OBJECT));

			}

		}
	}


	function insert_location()
	{

		if ($this->handleLogin())
		{
            

			if (isset($_POST['submit']))
			{

			    $model=$_POST['model'];
				$location=trim($_POST['location']);

				$code=$_POST['code'];
				if (is_numeric($_POST['quantity']))
				{
					$quantity=$_POST['quantity'];
				}else
				{
					$quantity=0;
				}
				$color='';

				$this->AddToTraceByFunction($this->userid,'location_report','insert_location/'.$model.'/'.$location.'/'.$code.'/'.$quantity);
				$stmtchq=$this->db->prepare("SELECT *FROM location WHERE model=? AND location = ? AND code=?  AND quantity >= ?");
				$stmtchq->execute(array($model,$location,$code,$quantity));
				if ($stmtchq->rowCount() > 0 ) {
					$q=true;


					$ql=$stmtchq->fetch(PDO::FETCH_ASSOC);







					$stmt_found = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 1 AND location = ? AND code=?  AND model=? LIMIT 1");
                    $stmt_found->execute(array($location, $code, $model));
					if ($stmt_found->rowCount() > 0) {
						$result_found=$stmt_found->fetch(PDO::FETCH_ASSOC);
                            echo (int)$result_found['transport'];
                        } else {


						$same_location=true;
                        $stmtchSameLocation = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 0  AND code=?  AND model=? AND userid=?");
                        $stmtchSameLocation->execute(array( $code, $model, $this->userid));
                        if ($stmtchSameLocation->rowCount() > 0) {

                            $resultSameLocation=$stmtchSameLocation->fetch(PDO::FETCH_ASSOC);

                            if ($location != $resultSameLocation['location'])
							{
								$same_location=false;
							}

                        }


                        if ($same_location) {


							$stmtch = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 0 AND location = ? AND code=?  AND model=? AND userid=?");
							$stmtch->execute(array($location, $code, $model, $this->userid));
							if ($stmtch->rowCount() > 0) {

								$qt = $stmtch->fetch(PDO::FETCH_ASSOC);


								if ($qt['quantity'] + $quantity > $ql['quantity']) {
									$q = false;
								} else {
									$stmtch = $this->db->prepare("UPDATE    location_transport SET  quantity=quantity+?  WHERE  `active` = 0 AND location = ? AND code=?  AND model=? AND userid=?");
									$stmtch->execute(array($quantity, $location, $code, $model, $this->userid));
								}

							} else {
								$stmt = $this->db->prepare("INSERT INTO location_transport ( model, location,code,  quantity, active, date, userid)values (?,?,?,?,?,?,?)");
								$stmt->execute(array($model, $location, $code, $quantity, 0, time(), $this->userid));
							}


							$stmtdata = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 0 AND `userid`=? ");
							$stmtdata->execute(array($this->userid));
							$data = array();
							while ($row = $stmtdata->fetch(PDO::FETCH_ASSOC)) {

								$row['serial_req']='';
								if ($this->check_serial_required($row['code'],'serial_transfer',$row['model']) == true)
								{
									$row['serial_req']='required';
								}

								$row['listSerial']=$this->getSerialCode($row['code'],$row['quantity'],$row['model']);




								$row['location'] = $this->tamayaz_locations($row['location']);
								$data[] = $row;
							}

							if ($data && $q) {
								require($this->render($this->folder, 'html', 'data', 'php'));
							} else {
								echo '-q';
							}

						}else
						{
							echo 'notSameLocation';
						}




                    }




				}else
				{
					echo '-q';
				}


			}




		}



	}

	function delete_row_loc($id)
	{
		if ($this->handleLogin())
		{

            $this->AddToTraceByFunction($this->userid,'location_report','delete_row_loc/'.$id);

			$stmt = $this->db->prepare("DELETE FROM location_transport WHERE  `id` = ? AND `active`=0");
			$stmt->execute(array($id));


			$stmtdata = $this->db->prepare("SELECT COUNT(id) as c FROM location_transport WHERE  `active` = 0  ");
			$stmtdata->execute();
			$result=$stmtdata->fetch(PDO::FETCH_ASSOC);
			if($result['c']==0)
			{
				echo '0';
			}

		}

	}
	function save_transport()
	{
		if ($this->handleLogin())
		{


			if (isset($_POST['submit'])) {


				$stmtdata = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 0 AND `userid`=? ");
				$stmtdata->execute(array($this->userid));
				$type_transport=null;
				while ($row=$stmtdata->fetch(PDO::FETCH_ASSOC))
				{
					    $serialList=$_POST['serial_'.$row['code']];
						$serialList=implode(',',$serialList);
						$stmtSerial= $this->db->prepare("UPDATE    location_transport SET serial=?   WHERE id=?  AND userid=? AND `active` = 0 AND transport=0");
						$stmtSerial->execute(array($serialList,$row['id'], $this->userid));
				}

				$this->AddToTraceByFunction($this->userid, 'location_report', 'save_transport');

				$stmt = $this->db->prepare("SELECT `transport` FROM location_transport    ORDER BY transport DESC LIMIT 1");
				$stmt->execute();
				if ($stmt->rowCount() > 0) {
					$transport = $stmt->fetch(PDO::FETCH_ASSOC)['transport'] + 1;

				} else {
					$stmt2 = $this->db->prepare("SELECT `transport` FROM location_transport   ORDER BY transport DESC LIMIT 1");
					$stmt2->execute();
					$transport = $stmt2->fetch(PDO::FETCH_ASSOC)['transport'] + 1;

				}


				$stmtdata = $this->db->prepare("UPDATE    location_transport SET active=1  , transport=? WHERE userid=? AND `active` = 0 AND transport=0");
				$stmtdata->execute(array($transport, $this->userid));
				if ($stmtdata->rowCount() > 0) {
					echo $transport;
				}




			}
		}

	}

function enter_note()
{
	if ($this->handleLogin())
	{
		$note=strip_tags($_GET['note']);
		$id=strip_tags($_GET['id']);
		$model=strip_tags($_GET['model']);
		$stmtdata = $this->db->prepare("UPDATE    location_transport SET note=? WHERE  active=0 AND  userid=? AND `id` = ? AND model=?");
		$stmtdata->execute(array($note,$this->userid,$id,$model));

		if($stmtdata->rowCount()>0)
		{
			echo 'true';
		}
	}

}




	function add_group()
	{

		$this->checkPermit('add_group', $this->folder);


		$bill=array();
		$stmtdata = $this->db->prepare("SELECT transport  FROM location_transport_convert WHERE  `active` = 2 AND isdelete =0 AND `number_group`  = 0 GROUP BY transport ");
		$stmtdata->execute();
		while ($row=$stmtdata->fetch(PDO::FETCH_ASSOC)) {
			$bill[]=$row['transport'];
		}



		if (!empty($bill)) {

			$number = 1;
			$stmt_sq = $this->db->prepare("SELECT `number` FROM {$this->group_bill} ORDER BY `number` DESC  LIMIT 1");
			$stmt_sq->execute();
			if ($stmt_sq->rowCount() > 0) {
				$num = $stmt_sq->fetch(PDO::FETCH_ASSOC);
				$number = $num['number'] + 1;
			}

			$time=time();
			$values="";

			$list_bill=implode(',',$bill);
			foreach ($bill as $data)
			{
				$values.="(
                    '{$list_bill}',
                    '{$data}',
                    '{$number}',
                    {$this->userid},
                    {$time}
                   )," ;

				$stmtup_trans = $this->db->prepare("UPDATE    location_transport_convert SET number_group= ? WHERE    transport = ? ");
				$stmtup_trans->execute(array($number,$data));

			}

			$values=rtrim($values, ',');
			$stmt_add=$this->db->prepare("INSERT INTO {$this->group_bill} (`name`, `number_bill`, `number`, `userid`, `date`) values {$values}");
			$stmt_add->execute();
			if ($stmt_add->rowCount() > 0)
			{
				echo $number;
			}
		}


	}




	function group_not_enter()
	{

		$this->checkPermit('group_not_enter', $this->folder);
		$this->AdminHeaderController($this->langControl('group_not_enter'));



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


		require($this->render($this->folder, 'group', 'group_not_enter', 'php'));
		$this->AdminFooterController();

	}



	public function processing_group_not_enter($from_date_stm=null,$to_date_stm=null)
	{

		$table = $this->group_bill;
		$primaryKey = $this->group_bill.'.id';

		$columns = array(


			array('db' => $table.'.number', 'dt' => 0  ),

			array('db' => $table.'.name', 'dt' => 1  ),
			array('db' => $table.'.userid', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return  $this->UserInfo($d);
				}
			),



			array('db' => $table.'.date', 'dt' => 3,
				'formatter' => function ($d, $row) {
					return date('Y-m-d h:i a',$d);
				}
			),


			array('db' => $table.'.number', 'dt' => 4,
				'formatter' => function ($d, $row) {

					return "
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-auto' style='padding-left: 2px'>		
				  	       <input id='numberBill_{$d}'  type='text' class='form-control withBill' name='crystal_bill' autocomplete='off' required>
                   </div>
				  <div class='col-auto' style='padding-right: 2px'>
				   <button type='submit' id='btn_in_bill_{$d}' onclick=saveBill('".$d."')  name='submit' class='btn btn-warning'>حفظ</button>
                  </div>
                  </div>
                    " ;
				}
			),

			array('db' => $table.'.number', 'dt' => 5,
				'formatter' => function ($d, $row) {
				if ($this->permit('export_group_enter',$this->folder)) {
					return "<a href='" . url . '/' . $this->folder . "/export_group?g={$d}'><span>تصدير مواد المجموعة</span></a>";
				}else
				{
					return 'لا تمتلك صلاحية';
				}
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

			array('db' =>$table.'.number', 'dt' => 7),//7




		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);



//		$join = "LEFT JOIN location_transport_convert ON location_transport_convert.crystal_bill = {$this->group_bill}.crystal_bill ";


		$join = " ";
		if (empty($from_date_stm) && empty($to_date_stm))
		{
			$whereAll = array("{$this->group_bill}.crystal_bill  = '' ");

		}else{
			$whereAll = array("{$this->group_bill}.crystal_bill  = '' ","{$this->group_bill}.date BETWEEN {$from_date_stm} AND {$to_date_stm}" );
		}
		$group="GROUP BY  {$this->group_bill}.number";

		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

	}




	public function export_group()
	{
		$this->checkPermit('export_group', $this->folder);
		$this->adminHeaderController($this->langControl('export_group'));

		$number=$_GET['g'];

		if (!is_numeric($number))
		{
			$error=new Errors();
			$error->index();
		}


		$stmt = $this->db->prepare("SELECT   * FROM {$this->group_bill}    WHERE  number=?   LIMIT 1") ;
		$stmt->execute(array($number));
		if ($stmt->rowCount() < 1)
		{
			$error=new Errors();
			$error->index();
		}

		$result=$stmt->fetch(PDO::FETCH_ASSOC);

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


		require($this->render($this->folder, 'group', 'bills_materials_not_enter', 'php'));
		$this->adminFooterController();
	}


	public function processing_bill_materials_crystal_not_enter($number,$from_date_stm=null,$to_date_stm=null)
	{

		$table = $this->location_transport_convert;
		$primaryKey = 'id';

		$columns = array(

			array('db' => 'code', 'dt' => 0   ),
			array('db' => 'quantity', 'dt' => 1   ),
			array('db' => 'code', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return $this->tile_table($d,$row[8]) ;
				}
			),
			array('db' => 'from_location', 'dt' => 3,

				'formatter' => function ($d, $row) {
					return $this->store_location($d,$row[8],$row[0]) ;
				}

				),
			array('db' => 'location', 'dt' => 4 ,

				'formatter' => function ($d, $row) {
					return $this->store_location($d,$row[8],$row[0]) ;
				}
			),


			array('db' => 'transport', 'dt' => 5,
				'formatter' => function ($d, $row) {
					return "<div class='text-right'>{$d},{$this->UserInfo($row[6])},{$this->UserInfo($row[7])},{$this->note_transport($row[0],$row[3],$row[8],$d)} </div>";
				}
			),

			array('db' =>'user_pull', 'dt' =>6 ),
			array('db' =>'userid', 'dt' =>7 ),
			array('db' =>'model', 'dt' =>8),



		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);

		if (empty($from_date_stm) && empty($to_date_stm))
		{
			echo json_encode(
				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "number_group= {$number}"));
		}else{

			echo json_encode(
				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "number_group= {$number} AND date BETWEEN {$from_date_stm} AND {$to_date_stm}"));
		}


	}







	function group_enter()
	{

		$this->checkPermit('group_enter', $this->folder);
		$this->AdminHeaderController($this->langControl('group_enter'));


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


		require($this->render($this->folder, 'group', 'group_enter', 'php'));
		$this->AdminFooterController();

	}



	public function processing_group_enter($from_date_stm=null,$to_date_stm=null)
	{

		$table = $this->group_bill;
		$primaryKey = $this->group_bill.'.id';

		$columns = array(


			array('db' => $table.'.number', 'dt' => 0  ),

			array('db' => $table.'.name', 'dt' => 1  ),
			array('db' => $table.'.userid', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return  $this->UserInfo($d);
				}
			),


			array('db' => $table.'.user_input_bill', 'dt' => 3,
				'formatter' => function ($d, $row) {
					return  $this->UserInfo($d);
				}
			),



			array('db' => $table.'.date', 'dt' => 4,
				'formatter' => function ($d, $row) {
					return date('Y-m-d h:i a',$d);
				}
			),

			array('db' => $table.'.crystal_bill', 'dt' => 5  ),

			array('db' => $table.'.number', 'dt' => 6,
				'formatter' => function ($d, $row) {
					if ($this->permit('edit_crystal_bill_group',$this->folder)) {
						return "
             	 <div class='row justify-content-center align-items-center'>
				  <div class='col-auto' style='padding-left: 2px'>		
				  	       <input id='numberBill_{$d}' value='{$row[5]}'  type='text' class='form-control withBill' name='crystal_bill' required>
                   </div>
				  <div class='col-auto' style='padding-right: 2px'>
				   <button type='submit' id='btn_in_bill_{$d}' onclick=saveBill('" . $d . "')  name='submit' class='btn btn-success'>تعديل</button>
                  </div>
                  </div>
                    ";
					}
					else
					{
						return 'لا تمتلك صلاحية';
					}
				}
			),

			array('db' => $table.'.number', 'dt' => 7,
				'formatter' => function ($d, $row) {
					if ($this->permit('export_group_enter',$this->folder)) {
                        return "<a  href='" . url . '/' . $this->folder . "/export_group_enter?g={$d}'><span>تصدير مواد المجموعة</span></a>";
                    }else
					{
						return 'لا تمتلك صلاحية';
					}
				}
			),
			array('db' => $table.'.export', 'dt' => 8,
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

			array('db' =>$table.'.number', 'dt' => 9),//7




		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);




//		$join = "LEFT JOIN location_transport_convert ON location_transport_convert.crystal_bill = {$this->group_bill}.crystal_bill ";
		$join = "  ";
		if (empty($from_date_stm) && empty($to_date_stm))
		{
			$whereAll = array("{$this->group_bill}.crystal_bill  <> '' ");

		}else{
			$whereAll = array("{$this->group_bill}.crystal_bill  <> '' ","{$this->group_bill}.date BETWEEN {$from_date_stm} AND {$to_date_stm}" );
		}
		$group="GROUP BY  {$this->group_bill}.number";

		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group));

	}





	public function export_group_enter()
	{
		$this->checkPermit('export_group', $this->folder);
		$this->adminHeaderController($this->langControl('export_group'));


		$number=$_GET['g'];
		if (!is_numeric($number))
		{
			$error=new Errors();
			$error->index();
		}


		$stmt = $this->db->prepare("SELECT   * FROM {$this->group_bill}    WHERE  number=?   LIMIT 1") ;
		$stmt->execute(array($number));
		if ($stmt->rowCount() < 1)
		{
			$error=new Errors();
			$error->index();
		}

		$result=$stmt->fetch(PDO::FETCH_ASSOC);

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


		require($this->render($this->folder, 'group', 'bills_materials_enter', 'php'));
		$this->adminFooterController();
	}


	public function processing_bill_materials_crystal_enter($number,$from_date_stm=null,$to_date_stm=null)
	{



		$table = $this->location_transport_convert;
		$primaryKey = 'id';

		$columns = array(

			array('db' => 'code', 'dt' => 0   ),
			array('db' => 'quantity', 'dt' => 1   ),
			array('db' => 'code', 'dt' => 2,
				'formatter' => function ($d, $row) {
					return $this->tile_table($d,$row[8]) ;
				}
			),
			array('db' => 'from_location', 'dt' => 3 ,

				'formatter' => function ($d, $row) {
					return $this->store_location($d,$row[8],$row[0]) ;
				}
				),
			array('db' => 'location', 'dt' => 4 ,

				'formatter' => function ($d, $row) {
					return $this->store_location($d,$row[8],$row[0]) ;
				}
			),


			array('db' => 'transport', 'dt' => 5,
				'formatter' => function ($d, $row) {
					return "<div class='text-right'>{$d},{$this->UserInfo($row[6])},{$this->UserInfo($row[7])},{$this->note_transport($row[0],$row[3],$row[8],$d)} </div>";
				}
			),

			array('db' =>'user_pull', 'dt' =>6 ),
			array('db' =>'userid', 'dt' =>7 ),
			array('db' =>'model', 'dt' =>8),



		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);

		if (empty($from_date_stm) && empty($to_date_stm))
		{
			echo json_encode(
				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "number_group= {$number}"));
		}else{

			echo json_encode(
				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "number_group= {$number} AND date BETWEEN {$from_date_stm} AND {$to_date_stm}"));
		}


	}


//	function store_location($location,$model,$code)
//	{
//
//		$stmt=$this->db->prepare('SELECT  *FROM location WHERE location=? AND model=? AND code = ? LIMIT 1');
//		$stmt->execute(array(trim($location),trim($model),$code));
//		if ($stmt->rowCount() > 0)
//		{
//			$result=$stmt->fetch(PDO::FETCH_ASSOC);
//			$stmt_sequence=$this->db->prepare("SELECT title FROM group_location WHERE  {$result['sequence']} between `from` AND  `to`     LIMIT 1");
//			$stmt_sequence->execute();
//			if ($stmt_sequence->rowCount() > 0)
//			{
//				$group=$stmt_sequence->fetch(PDO::FETCH_ASSOC);
//				return $group['title'];
//			}else{
//				return 'لم يتم تحديد مجموعة للمستودعات';
//
//			}
//		}else
//		{
//			return  "الموقع  " .$location. "  غير موجود من ضمن مواقع الباركود ";
//		}
//	}
//






	function note_transport($code,$location,$model,$transport)
	{

		$stmt = $this->db->prepare("SELECT   note FROM  `location_transport`    WHERE  code=? AND  location=? AND  model=? AND  transport=?    ") ;
		$stmt->execute(array($code,$location,$model,$transport));
		if ($stmt->rowCount()  > 0)
		{
		 $r=$stmt->fetch(PDO::FETCH_ASSOC);
		 return $r['note'];
		}else
		{
			return  '';
		}

	}


	function tile_table($code,$model)
	{
		if ($model == 'savers')
		{

			$stmt = $this->db->prepare("SELECT   title FROM  `product_savers`    WHERE  code=? LIMIT 1 ") ;
			$stmt->execute(array($code));
			if ($stmt->rowCount()  > 0)
			{
				$r=$stmt->fetch(PDO::FETCH_ASSOC);
				return $r['title'];
			}

		}else if ($model == 'accessories'){

			$stmt = $this->db->prepare("SELECT   accessories.title FROM color_accessories   INNER JOIN accessories ON  accessories.id=color_accessories.id_item WHERE  color_accessories.code=? LIMIT 1 ") ;
			$stmt->execute(array($code));
			if ($stmt->rowCount()  > 0)
			{
				$r=$stmt->fetch(PDO::FETCH_ASSOC);
				return $r['title'];
			}

		}
		else
		{

			if ($model=='mobile')
			{
				$code_table='code';
				$color='color';
			}else
			{
				$code_table='code_'.$model;
				$color='color_'.$model;
			}

			$stmt = $this->db->prepare("SELECT   mobile.title FROM {$code_table}   INNER JOIN {$color} ON  {$color}.id ={$code_table}.id_color INNER  JOIN  mobile ON  mobile.id={$color}.id_item WHERE  {$code_table}.code=? LIMIT 1 ") ;
			$stmt->execute(array($code));
			if ($stmt->rowCount()  > 0)
			{
				$r=$stmt->fetch(PDO::FETCH_ASSOC);
				return $r['title'];
			}

		}


	}



	function crystal_bill_group()
	{
		if ($this->handleLogin()) {


			$number = trim(str_replace(' ', '', $_GET['number_group']));
			$crystal_bill = trim(str_replace(' ', '', $_GET['crystal_bill']));


			$stmt = $this->db->prepare("SELECT   number_bill FROM {$this->group_bill}    WHERE  number=? ");
			$stmt->execute(array($number));
			$bill = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$bill[] = $row['number_bill'];
			}


			$stmt_ch = $this->db->prepare("SELECT   number_bill FROM {$this->group_bill}    WHERE  number=? ");
			$stmt_ch->execute(array($number));
			if ($stmt_ch->rowCount() > 0) {


				$stmt_up = $this->db->prepare("UPDATE  `{$this->group_bill}` SET  crystal_bill=? , user_input_bill=?  WHERE  number =?   ");
				$stmt_up->execute(array($crystal_bill, $this->userid, $number));
				if ($stmt_up->rowCount() > 0) {

					$bill_group=implode(',',$bill);
					$stmt_p = $this->db->prepare("UPDATE  `location_transport_convert` SET  crystal_bill=? , user_enter=?,`date_enter`=?  WHERE  transport IN($bill_group)  ");
					$stmt_p->execute(array($crystal_bill, $this->userid,time()));
					if ($stmt_p->rowCount() > 0) {
						echo '1';
					}

				}
			}
		}

	}


function done_export()
{
	$id=$_GET['id'];
	$number=$_GET['number'];
	$stmt=$this->db->prepare("UPDATE location_transport_groups SET export=1,user_export=? WHERE id =? AND number=?");
	$stmt->execute(array($this->userid,$id,$number));
}


}




?>
