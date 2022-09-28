<?php

class trace_site extends Controller
{


    function __construct()
    {
        parent::__construct();
        $this->table = 'trace_site';
    }

    public function createTB()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `id_item`  int(11)  NOT NULL , 
          `old_title`  varchar(250) COLLATE utf8_unicode_ci NOT NULL, 
          `new_title`  varchar(250) COLLATE utf8_unicode_ci NOT NULL, 
          `userId`  varchar(250) COLLATE utf8_unicode_ci NOT NULL, 
          `table` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `oldData`  longtext COLLATE utf8_unicode_ci NOT NULL,
          `newData`  longtext COLLATE utf8_unicode_ci NOT NULL,
          `type`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `lang`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
          `createDate`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table));


    }

    public function list_trace_site()
    {
        $this->checkPermit('list_trace_site',$this->folder);
        $this->adminHeaderController($this->langControl('list_trace_site'));


        $model='mobile';

        if (isset($_GET['model']))
        {
            $model=trim($_GET['model']);
        }
		require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();

    }




    public function processing($model)
    {

        $table = $this->table;
		$primaryKey = $table . '.id';


        $columns = array(

            array( 'db' => $table.'.table', 'dt' => 0,
				'formatter' => function( $d, $row ) {
					return  $this->langControl($d);
				 }
				),
            array( 'db' => $table.'.type', 'dt' => 1 ,

				'formatter' => function( $d, $row ) {
                    $action=array('edit'=>'تعديل','add'=>'اضافة','delete'=>'حذف');
                if (array_key_exists($d,$action))
                {
                    return $action[$d];
                }else
                {
                    return   $d;
                }

				}
			 ),
			array( 'db' => $table.'.old_title', 'dt' => 2),
			array( 'db' => $table.'.new_title', 'dt' => 3 ),
			array( 'db' => $table.'.oldData', 'dt' =>4,
				'formatter' => function( $d, $row ) {
					return $this->json_data($row[0],$d);
				}
			),
			array( 'db' => $table.'.newData', 'dt' =>5,
				'formatter' => function( $d, $row ) {
					return $this->json_data($row[0],$d);
				}
			),

			array( 'db' =>  'user.username', 'dt' =>6),

			array( 'db' => $table.'.createDate', 'dt' =>  7 ),

            array(
                'db'        => $table.'.id',
                'dt'        => 8,
                'formatter' => function($id, $row ) {

                    	if ($row[0]=='accessories')
						{
							return "
						 <div style='text-align: center;font-size: 23px;'>
						  <a href=" . url . "/" . $this->folder . "/details1/$id>  تفاصيل   </a>
						 </div>";
						}else if($row[0]=='savers'){
							return "
						 <div style='text-align: center;font-size: 23px;'>
						  <a href=" . url . "/" . $this->folder . "/details2/$id>  تفاصيل   </a>
						 </div>";
						}
                    	else{
							return "
						 <div style='text-align: center;font-size: 23px;'>
						  <a href=" . url . "/" . $this->folder . "/details/$id>  تفاصيل   </a>
						 </div>";
						}



                }
            ),

            array(  'db' => $table.'.id', 'dt'=>9)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

		    $join = "INNER JOIN user ON user.id=$table.userId";
           $whereAll = array("{$table}.`table`='{$model}'");

		//$group="GROUP BY  {$table}.number_bill";

		echo json_encode(
			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns,$join,null,$whereAll,null,null));


    }



    function json_data($model,$data)
    {
        if ($data)
        {
            $normal_data=json_decode($data,true);

            if ($model=='accessories')
            {

                $codelist=array();
                if ($normal_data[0]['color'] )
                {
                    foreach ($normal_data[0]['color'] as $data)
                    {
                        $codelist[]=$data['code'];
                    }
                }

            }else if ($model=='savers')
            {
                $codelist=array($normal_data[0]['code']);
            }else{
                $codelist=array();
                foreach ($normal_data[0]['color'] as $data)
                {
                    if ($data['code'])
                    {
                        foreach ($data['code'] as $code)
                        {

                            $codelist[]=$code['code'];
                        }

                    }
                }
            }

            return implode(' , ',$codelist);


        }else{
            return '';
        }



    }




    public function details($id)
    {
        $this->checkPermit('details',$this->folder);
        $this->adminHeaderController($this->langControl('details'));

        $stmt=$this->db->prepare("SELECT  *FROM `trace_site` WHERE `id`  = ? " );
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);


        $oldData=json_decode($result['oldData'],true);

        $newData=json_decode($result['newData'],true);




        require($this->render($this->folder, 'html', 'index', 'php'));
        $this->adminFooterController();

    }


    public function details1($id)
    {
        $this->checkPermit('details',$this->folder);
        $this->adminHeaderController($this->langControl('details'));

        $stmt=$this->db->prepare("SELECT  *FROM `trace_site` WHERE `id`  = ? " );
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);


        $oldData=json_decode($result['oldData'],true);

        $newData=json_decode($result['newData'],true);




        require($this->render($this->folder, 'html', 'details1', 'php'));
        $this->adminFooterController();

    }

    public function details2($id)
    {
        $this->checkPermit('details',$this->folder);
        $this->adminHeaderController($this->langControl('details'));

        $stmt=$this->db->prepare("SELECT  *FROM `trace_site` WHERE `id`  = ? " );
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);


        $oldData=json_decode($result['oldData'],true);

        $newData=json_decode($result['newData'],true);




        require($this->render($this->folder, 'html', 'details2', 'php'));
        $this->adminFooterController();

    }



    function old($id,$model)
	{

		$table=$model;
		 if ($model=='mobile')
		 {
		 	$color='color';
		 	$code='code';
		 }else{
			 $color='color_'.$model;
			 $code='code_'.$model;
		 }



		if ($table=='accessories')
		{

			$stmtd = $this->db->prepare("SELECT *FROM {$table} WHERE id=? LIMIT 1");
			$stmtd->execute(array($id));
			$data = array();
			while ($row = $stmtd->fetch(PDO::FETCH_ASSOC)) {
				$row['color'] = array();
				$stmtcolor = $this->db->prepare("SELECT *FROM  color_accessories WHERE id_item =? ");
				$stmtcolor->execute(array($row['id']));
				while ($rowc = $stmtcolor->fetch(PDO::FETCH_ASSOC)) {
					$row['color'][] = $rowc;
				}
				$data[] = $row;
			}
		}else if ($table=='savers'){

			$stmtd = $this->db->prepare("SELECT *FROM  `product_savers` WHERE id=? LIMIT 1");
			$stmtd->execute(array($id));
			$data = array();
			while ($row = $stmtd->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}

		}else {

			$stmtd = $this->db->prepare("SELECT *FROM {$table} WHERE id=? LIMIT 1");
			$stmtd->execute(array($id));
			$data = array();
			while ($row = $stmtd->fetch(PDO::FETCH_ASSOC)) {
				$row['color'] = array();
				$stmtcolor = $this->db->prepare("SELECT *FROM {$color} WHERE id_item =? ");
				$stmtcolor->execute(array($row['id']));
				while ($rowc = $stmtcolor->fetch(PDO::FETCH_ASSOC)) {
					$rowc['code'] = array();
					$stmtcode = $this->db->prepare("SELECT *FROM {$code} WHERE id_color=?");
					$stmtcode->execute(array($rowc['id']));
					while ($code = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
						$rowc['code'] [] = $code;
					}
					$row['color'][] = $rowc;
				}
				$data[] = $row;
			}
		}
		return  json_encode($data);

	}


    function neaw($id,$model)
	{

		$table=$model;
		 if ($model=='mobile')
		 {
		 	$color='color';
		 	$code='code';
		 }else{
			 $color='color_'.$model;
			 $code='code_'.$model;
		 }


		 if ($table=='accessories')
		 {

			 $stmtd = $this->db->prepare("SELECT *FROM {$table} WHERE id=? LIMIT 1");
			 $stmtd->execute(array($id));
			 $data = array();
			 while ($row = $stmtd->fetch(PDO::FETCH_ASSOC)) {
				 $row['color'] = array();
				 $stmtcolor = $this->db->prepare("SELECT *FROM  color_accessories WHERE id_item =? ");
				 $stmtcolor->execute(array($row['id']));
				 while ($rowc = $stmtcolor->fetch(PDO::FETCH_ASSOC)) {
					 $row['color'][] = $rowc;
				 }
				 $data[] = $row;
			 }
		 }else if ($table=='savers'){

			 $stmtd = $this->db->prepare("SELECT *FROM  `product_savers` WHERE id=? LIMIT 1");
			 $stmtd->execute(array($id));
			 $data = array();
			 while ($row = $stmtd->fetch(PDO::FETCH_ASSOC)) {
				 $data[] = $row;
			 }

		 }else {


			 $stmtd = $this->db->prepare("SELECT *FROM {$table} WHERE id=? LIMIT 1");
			 $stmtd->execute(array($id));
			 $data = array();
			 while ($row = $stmtd->fetch(PDO::FETCH_ASSOC)) {
				 $row['color'] = array();
				 $stmtcolor = $this->db->prepare("SELECT *FROM {$color} WHERE id_item =? ");
				 $stmtcolor->execute(array($row['id']));
				 while ($rowc = $stmtcolor->fetch(PDO::FETCH_ASSOC)) {
					 $rowc['code'] = array();
					 $stmtcode = $this->db->prepare("SELECT *FROM {$code} WHERE id_color=?");
					 $stmtcode->execute(array($rowc['id']));
					 while ($code = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
						 $rowc['code'] [] = $code;
					 }
					 $row['color'][] = $rowc;
				 }
				 $data[] = $row;
			 }


		 }

		return json_encode($data);

	}



    function  add($id_item,$table,$type,$old_title,$new_title,$oldData=null,$newData=null)
    {

        $stmt=$this->db->prepare("INSERT INTO `trace_site` (`id_item`,`table`,`type`,`old_title`,new_title,`oldData`,`newData`,`date`,`createDate`,`lang`,userId) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($id_item,$table,$type,$old_title,$new_title,$oldData,$newData,time(),date('Y-m-d h:i:s a'),$this->langControl,$this->userid));
    }


    function category($model,$id)
	{
		$model='category_'.$model;
		$stmt=$this->db->prepare("SELECT  *FROM `{$model}` WHERE `id`  = ? " );
		$stmt->execute(array($id));
		$result=$stmt->fetch(PDO::FETCH_ASSOC);

		return $result['title'];
	}


    function trace_category($id,$table)
	{
		$stmt=$this->db->prepare("SELECT  *FROM `{$table}` WHERE `id`  = ? " );
		$stmt->execute(array($id));
		$result=$stmt->fetch(PDO::FETCH_ASSOC);

		return json_encode($result);
	}

    function inforow($id,$table,$col)
	{
		$stmt=$this->db->prepare("SELECT  *FROM `{$table}` WHERE `id`  = ? " );
		$stmt->execute(array($id));
		$result=$stmt->fetch(PDO::FETCH_ASSOC);

		return $result[$col];
	}





}




























