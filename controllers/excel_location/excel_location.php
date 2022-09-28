<?php

class excel_location extends Controller
{


	function __construct()
	{
		parent::__construct();

	}






	function mobile()
	{

		$this->checkPermit('mobile',$this->folder);
		$this->adminHeaderController($this->langControl('mobile'));

		require ($this->render($this->folder,'mobile','index','php'));
		$this->adminFooterController();

	}



	function camera()
	{

		$this->checkPermit('camera',$this->folder);
		$this->adminHeaderController($this->langControl('camera'));

		require ($this->render($this->folder,'camera','index','php'));
		$this->adminFooterController();

	}


	function computer()
	{

		$this->checkPermit('computer',$this->folder);
		$this->adminHeaderController($this->langControl('computer'));

		require ($this->render($this->folder,'computer','index','php'));
		$this->adminFooterController();

	}




	function games()
	{

		$this->checkPermit('games',$this->folder);
		$this->adminHeaderController($this->langControl('games'));

		require ($this->render($this->folder,'games','index','php'));
		$this->adminFooterController();

	}


	function network()
	{

		$this->checkPermit('network',$this->folder);
		$this->adminHeaderController($this->langControl('network'));

		require ($this->render($this->folder,'network','index','php'));
		$this->adminFooterController();

	}

	function printing_supplies()
	{

		$this->checkPermit('printing_supplies',$this->folder);
		$this->adminHeaderController($this->langControl('printing_supplies'));

		require ($this->render($this->folder,'printing_supplies','index','php'));
		$this->adminFooterController();

	}

	function accessories()
	{

		$this->checkPermit('accessories',$this->folder);
		$this->adminHeaderController($this->langControl('accessories'));

		require ($this->render($this->folder,'accessories','index','php'));
		$this->adminFooterController();

	}

	function savers()
	{

		$this->checkPermit('savers',$this->folder);
		$this->adminHeaderController($this->langControl('savers'));

		require ($this->render($this->folder,'savers','index','php'));
		$this->adminFooterController();

	}



	public function processing($model)
	{


	   $table = 'location';
		$primaryKey = $table.'.id';


		$columns = array(
			array(  'db' =>$table.'.sequence', 'dt'=>0),
			array(  'db' =>  $table.'.code', 'dt'=>1),
            array(  'db' =>$table.'.location', 'dt'=>2,
                'formatter' => function ($id, $row) {
                    return $this->tamayaz_locations($id);
                }

            ),
			array(  'db' =>$table.'.quantity', 'dt'=>3),
			array(  'db' =>$table.'.date', 'dt'=>4,
				'formatter' => function ($id, $row) {
                 return date('Y-m-d h:i:s A',$id);
                }
            ),
			array(
				'db' =>$table.'.id',
				'dt' => 5,
				'formatter' => function ($id, $row) {
					if ($this->permit('edit_quantity', $this->folder)) {
						return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'   data-toggle='modal' data-target='#exampleModal_edit' data-id='{$id}' data-quantity='{$row[3]}'    >
                    <i class='fa fa-edit' aria-hidden='true'></i></i>
                         </button>
                    </div>
                   
                    ";
					} else {
						return "لا تمتلك صلاحية";
					}
				}
			),

            array(  'db' =>'user.username', 'dt'=>6),

			array(
				'db' => $table.'.id',
				'dt' => 7,
				'formatter' => function ($id, $row) {
					if ($this->permit('delete_location', $this->folder)) {
						return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[2]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
					} else {
						return "لا تمتلك صلاحية";
					}
				}
			),
			array(  'db' => $table.'.id', 'dt'=>8),

		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);




        $join = " inner JOIN user ON user.id = {$table}.userid";
        $whereAll = array("{$table}.model='{$model}'");


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));



	}



	public function processing_savers($model)
	{



		$table = 'product_savers';
		$primaryKey = 'product_savers.id';
		$category='type_device';

		$columns = array(
			array(  'db' =>'location.sequence', 'dt'=>0),
			array(  'db' => $table.'.code', 'dt'=>1),
			array(  'db' => 'location.location', 'dt'=>2),
			array(  'db' => 'location.quantity', 'dt'=>3),

			array(
				'db' => 'location.id',
				'dt' => 7,
				'formatter' => function ($id, $row) {
					if ($this->permit('edit_quantity', $this->folder)) {
						return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'   data-toggle='modal' data-target='#exampleModal_edit' data-id='{$id}' data-quantity='{$row[3]}'    >
                    <i class='fa fa-edit' aria-hidden='true'></i></i>
                         </button>
                    </div>
                   
                    ";
					} else {
						return "لا تمتلك صلاحية";
					}
				}
			),


			array(
				'db' => 'location.id',
				'dt' => 4,
				'formatter' => function ($id, $row) {
					if ($this->permit('delete_location', $this->folder)) {
						return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[2]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
					} else {
						return "لا تمتلك صلاحية";
					}
				}
			),

			array(  'db' => 'location.id', 'dt'=>5),

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
		$whereAll = array( "location.model='savers'" );
		$group="GROUP BY {$table}.code";
	 	$result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group);

			echo json_encode($result);

	}



	public function processing_accessories($model)
	{



		$table = $model;
		$primaryKey = $model.'.id';

		$color = 'color_'.$model;

		$category='category_'.$model;
		$columns = array(
			array(  'db' =>'location.sequence', 'dt'=>0),
			array(  'db' => $color.'.code', 'dt'=>1),
			array(  'db' => 'location.location', 'dt'=>2),
			array(  'db' => 'location.quantity', 'dt'=>3),

			array(
				'db' => 'location.id',
				'dt' => 4,
				'formatter' => function ($id, $row) {
					if ($this->permit('edit_quantity', $this->folder)) {
						return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'   data-toggle='modal' data-target='#exampleModal_edit' data-id='{$id}' data-quantity='{$row[3]}'    >
                    <i class='fa fa-edit' aria-hidden='true'></i></i>
                         </button>
                    </div>
                   
                    ";
					} else {
						return "لا تمتلك صلاحية";
					}
				}
			),


			array(
				'db' => 'location.id',
				'dt' => 5,
				'formatter' => function ($id, $row) {
					if ($this->permit('delete_location', $this->folder)) {
						return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[2]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
					} else {
						return "لا تمتلك صلاحية";
					}
				}
			),

			array(  'db' => 'location.id', 'dt'=>6),

		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);


		$join = "INNER JOIN {$color} ON {$color}.id_item={$model}.id  INNER JOIN location ON location.code={$color}.code AND location.color = {$color}.color ";
		$whereAll = array( "location.model='{$model}'");

		 $result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null);

			echo json_encode($result);

	}




	function get_location_edit($id)
	{
		if ($this->handleLogin()) {
			$stmt = $this->db->prepare("SELECT * from `location` WHERE `id`=? LIMIT 1");
			$stmt->execute(array($id));
			if ($stmt->rowCount()>0) {
				$data =$stmt->fetch(PDO::FETCH_ASSOC);
				echo json_encode($data);
			} else {
				exit();
			}
		}


	}


	public function edit($id = null)
	{

		if ($this->handleLogin()) {

            $this->AddToTraceByFunction($this->userid,'excel_location','edit/'.$id);
			if (!is_numeric($id)) {
				$error = new Errors();
				$error->index();
			}
			$quantity =(int)trim($_POST['quantity']);

			$stmt=$this->db->prepare('SELECT *FROM location WHERE id=?');
			$stmt->execute(array($id));

			if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result['model']=='mobile')
                {
                    $excel='excel';
                }else
                {
                    $excel='excel_'.$result['model'];
                }


                $stmt_code_quantity=$this->db->prepare("SELECT *FROM `{$excel}` WHERE code=? AND quantity >= ?");
                $stmt_code_quantity->execute(array($result['code'],$quantity));
                if($stmt_code_quantity->rowCount() > 0) {

                    if ($quantity > $result['quantity']) {

                        $stmtc = $this->db->prepare("SELECT *FROM location_confirm WHERE code=? AND model=? AND quantity >= {$quantity}");
                        $stmtc->execute(array($result['code'], $result['model']));
                        if ($stmtc->rowCount() > 0) {


                            $stmtup = $this->db->prepare("UPDATE   location SET  `quantity` = ?,userid=?,`date`=? WHERE  id=? AND code=?");
                            $stmtup->execute(array($quantity, $this->userid, time(), $id, $result['code']));

                            if ($stmtup->rowCount() > 0) {

                                $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity`- $quantity ,userid=?,`date`=? WHERE code=? AND model=? ");
                                $stmtcon->execute(array($this->userid, time(), $result['code'], $result['model']));
                                if ($stmtcon->rowCount() <= 0) {
                                    $this->filter_error_quantity($result['code'], $result['model'], $quantity, '   تعديل كمية الموقع excel وتقرير المواقع   - رقم الخطا 42');
                                }

                                $this->filter_location_tracking_quantity($result['code'], $result['model'], $result['location'], $quantity, '    تعديل كمية الموقع excel وتقرير المواقع  - رقم44', '+-');

                            } else {
                                $this->filter_location_error_quantity($result['code'], $result['model'], $result['location'], $quantity, '   تعديل كمية الموقع excel وتقرير المواقع  - رقم الخطا 44', '+-');

                            }

                        } else {
                            echo '-q';
                        }
                    } else {

                        $q = $result['quantity'] - $quantity;

                        $stmtup = $this->db->prepare("UPDATE   location SET  `quantity` = ?,userid=?,`date`=? WHERE  id=? AND code=?");
                        $stmtup->execute(array($quantity, $this->userid, time(), $id, $result['code']));
                        if ($stmtup->rowCount() > 0) {

                            $stmtChCodeConform = $this->db->prepare("SELECT *FROM location_confirm WHERE code =? AND model=?");
                            $stmtChCodeConform->execute(array($result['code'], $result['model']));
                            if ($stmtChCodeConform->rowCount() > 0) {


                                $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity`- $q ,userid=?,`date`=? WHERE code=? AND model=? ");
                                $stmtcon->execute(array($this->userid, time(), $result['code'], $result['model']));
                                if ($stmtcon->rowCount() <= 0) {
                                    $this->filter_error_quantity($result['code'], $result['model'], $quantity, '   تعديل كمية الموقع excel وتقرير المواقع   - رقم الخطا 43');
                                }

                            } else {
                                $stmtExcel_conform = $this->db->prepare("INSERT INTO  location_confirm (quantity,code,model,date,userid)  VALUES (?,?,?,?,?)");
                                $stmtExcel_conform->execute(array($q, $result['code'], $result['model'], time(),$this->userid));
                                if ($stmtExcel_conform->rowCount() <= 0) {
                                    $this->filter_error_quantity($result['code'], $result['model'], $quantity, '   تعديل كمية الموقع excel وتقرير المواقع   - رقم الخطا 44');
                                }
                            }


                            $this->filter_location_tracking_quantity($result['code'], $result['model'], $result['location'], $quantity, '    تعديل كمية الموقع excel وتقرير المواقع  - رقم45', '+-');

                        } else {
                            $this->filter_location_error_quantity($result['code'], $result['model'], $result['location'], $quantity, '   تعديل كمية الموقع excel وتقرير المواقع  - رقم الخطا 45', '+-');

                        }


                    }

                }
            }
		}

	}


	function delete_location($id)
	{
		if ($this->handleLogin()) {

            $this->AddToTraceByFunction($this->userid,'excel_location','delete_location/'.$id);

			$stmtc=$this->db->prepare("SELECT *FROM location WHERE id=?   ");
			$stmtc->execute(array($id));
			if ($stmtc->rowCount() > 0) {




                $result = $stmtc->fetch(PDO::FETCH_ASSOC);
                $q=(int)$result['quantity'];

                $stmtUp0 = $this->db->prepare("UPDATE   location_confirm SET  `quantity` = 0   WHERE code=? AND model= ?  AND quantity < 0");
                $stmtUp0->execute(array( $result['code'], $result['model']));

                $stmtup = $this->db->prepare("DELETE FROM  `location`  WHERE  `id`=?");
                $stmtup->execute(array($id));

                if ($stmtup->rowCount() > 0) {

                    $stmtChCodeConform = $this->db->prepare("SELECT *FROM location_confirm WHERE code =? AND model=?");
                    $stmtChCodeConform->execute(array($result['code'], $result['model'] ));
                    if ($stmtChCodeConform->rowCount() > 0) {

                        $stmtcon = $this->db->prepare("UPDATE   location_confirm SET  `quantity` =`quantity` + $q ,userid=?,`date`=? WHERE code=? AND model=? ");
                        $stmtcon->execute(array($this->userid, time(), $result['code'], $result['model']));
                        if ($stmtcon->rowCount() <= 0) {
                            $this->filter_error_quantity($result['code'], $result['model'], $q, '   حذف الموقع excel وتقرير المواقع   - رقم الخطا 45');
                        }
                    }else
                    {
                        $stmtExcel_conform = $this->db->prepare("INSERT INTO  location_confirm (quantity,code,model,date,userid)  values (?,?,?,?,?)");
                        $stmtExcel_conform->execute(array($q,$result['code'], $result['model'],time(),$this->userid));
                        if ($stmtExcel_conform->rowCount() <= 0) {
                            $this->filter_error_quantity($result['code'], $result['model'], $q, '   حذف الموقع excel وتقرير المواقع   - رقم الخطا 46');
                        }
                    }

                    echo 'true';
                    $this->filter_location_tracking_quantity($result['code'], $result['model'], $result['location'], $q, '   حذف الموقع excel وتقرير المواقع  - رقم46', '-');

                } else {
                    $this->filter_location_error_quantity($result['code'], $result['model'], $result['location'], $q, '  حذف الموقع excel وتقرير المواقع  - رقم الخطا 46', '-');

                    echo 'false';
                }


            }


		}
	}

	function delete_all($model)
	{
		if ($this->handleLogin()) {
            $this->AddToTraceByFunction($this->userid,'excel_location','delete_all/'.$model);

			$this->checkPermit($model.'_delete_all_location', $this->folder);


            $stmtUp0 = $this->db->prepare("UPDATE   location_confirm SET  `quantity` = 0   WHERE  model= ?  AND quantity < 0");
            $stmtUp0->execute(array(  $model));

            $stmtc=$this->db->prepare("SELECT *FROM location WHERE  `model`=?  ");
            $stmtc->execute(array($model));
            if ($stmtc->rowCount() > 0) {
                while ($row = $stmtc->fetch(PDO::FETCH_ASSOC))
                {

                    $c = $this->db->prepare("DELETE FROM  `location`  WHERE id=? AND code=? AND  `model`=?");
                    $c->execute(array($row['id'],$row['code'],$model));
                    $q=$row['quantity'];
                    if ($c->rowCount()>0)
                    {

                        $stmtChCodeConform = $this->db->prepare("SELECT *FROM location_confirm WHERE code =? AND model=?");
                        $stmtChCodeConform->execute(array($row['code'], $row['model'] ));
                        if ($stmtChCodeConform->rowCount() > 0) {
                            $stmtExcel_conform = $this->db->prepare("UPDATE location_confirm SET  quantity=quantity+{$q} ,`date`=?,userid=?  WHERE code =? AND  model=?");
                            $stmtExcel_conform->execute(array(time(),$this->userid,$row['code'], $row['model']));
                            if ($stmtExcel_conform->rowCount() <= 0) {
                                $this->filter_error_quantity($row['code'], $row['model'], $q, '   حذف كل الموقع excel وتقرير المواقع   - رقم الخطا 47');
                            }
                        }else
                        {
                            $stmtExcel_conform = $this->db->prepare("INSERT INTO  location_confirm (quantity,code,model,`date`,userid)  values (?,?,?,?,?)");
                            $stmtExcel_conform->execute(array($q,$row['code'], $row['model'],time(),$this->userid));
                            if ($stmtExcel_conform->rowCount() <= 0) {
                                $this->filter_error_quantity($row['code'], $row['model'], $q, '   حذف كل الموقع excel وتقرير المواقع   - رقم الخطا 48');
                            }
                        }


                        $this->filter_location_tracking_quantity($row['code'], $row['model'], $row['location'], $q, '   حذف كل الموقع excel وتقرير المواقع  - رقم47', '-');

                    }else
                    {
                        $this->filter_location_error_quantity($row['code'], $row['model'], $row['location'], $q, '  حذف كل الموقع excel وتقرير المواقع  - رقم الخطا 47', '-');

                    }






                }



            }



		}
	}




	function  add($model)
	{
        $this->AddToTraceByFunction($this->userid,'excel_location','add/'.$model);

		$this->checkPermit('excel',$this->folder);
		$this->adminHeaderController($this->langControl('excel'));
		if ($model=='mobile') {
			$code = 'code';
			$excel = 'excel';
		}else {
			$code = 'code_'.$model;
			$excel = 'excel_'.$model;
		}

		$location=array();
        $stmt_locat = $this->db->prepare("SELECT location,sequence FROM `location_model`  WHERE  `model` =?  ");
        $stmt_locat->execute(array($model));
        while ($row = $stmt_locat->fetch(PDO::FETCH_ASSOC))
        {
            $location[]=$row;
        }

		if(isset($_POST["submit"])) {


			try {
				$form = new  Form();

				$form->post('files_normal')
					->val('is_empty', 'مطلوب')
					->val('strip_tags');


				$form->submit();
				$data = $form->fetch();
				$name_file=json_decode($data['files_normal'],true);

				$inputFileName=$this->root_file.'/files/'.$name_file[0]['rand_name'];
				if (file_exists($inputFileName)) {

					//  Read your Excel workbook
					try {
						$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
						$objReader = PHPExcel_IOFactory::createReader($inputFileType);
						$objPHPExcel = $objReader->load($inputFileName);
					} catch (Exception $e) {
						die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
					}

					//  Get worksheet dimensions
					$sheet = $objPHPExcel->getSheet(0);
					$highestRow = $sheet->getHighestRow();
					$highestColumn = $sheet->getHighestColumn();

					//  Loop through each row of the worksheet in turn

					for ($row = 1; $row <= $highestRow; $row++) {
						//  Read a row of data into an array
						$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
							NULL,
							TRUE,
							TRUE);


						if (count($rowData[0])  >= 1)
						{


						    foreach ($location as $in_location){

                                $stmtc = $this->db->prepare("SELECT *FROM location WHERE code=? AND location=? AND model=? ");
                                $stmtc->execute(array(trim($rowData[0][0]), $in_location['location'], $model));
                                if ($stmtc->rowCount() > 0) {
                                    continue;
                                } else {

                                    $stmt = $this->db->prepare("INSERT INTO  location  (code,location,model,sequence,userid,`date`) values (?,?,?,?,?,?) ");
                                    $stmt->execute(array($rowData[0][0],$in_location['location'], $model, $in_location['sequence'], $this->userid, time()));
                                }

                            }


						}else{
							$this->error_form=json_encode(array('files_normal'=>'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
							break;
						}

					}

					@unlink($inputFileName);
				}else
				{

					$this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
				}

				if (empty($this->error_form))
				{
				  $this->lightRedirect(url.'/'.$this->folder."/{$model}");

				}


			} catch (Exception $e) {
				$data =$form -> fetch();
				$this->error_form=$e -> getMessage();

			}


		}

		require ($this->render($this->folder,'html','add','php'));
		$this->adminFooterController();
	}



    function  add_accessories($model)
    {
        $this->AddToTraceByFunction($this->userid,'excel_location','add_accessories/'.$model);

        $this->checkPermit('add_accessories',$this->folder);
        $this->adminHeaderController($this->langControl('excel'));

        if(isset($_POST["submit"])) {


            try {
                $form = new  Form();

                $form->post('files_normal')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $name_file=json_decode($data['files_normal'],true);

                $inputFileName=$this->root_file.'/files/'.$name_file[0]['rand_name'];
                if (file_exists($inputFileName)) {

                    //  Read your Excel workbook
                    try {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFileName);
                    } catch (Exception $e) {
                        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                    }

                    //  Get worksheet dimensions
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();

                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                            NULL,
                            TRUE,
                            TRUE);


                        if (count($rowData[0])  >= 2)
                        {


                            $stmtcode=$this->db->prepare("SELECT *FROM location_model WHERE location=? AND model=?  ");
                            $stmtcode->execute(array(trim($rowData[0][1]),$model));
                            if ($stmtcode->rowCount()>0) {

                                $stmtc = $this->db->prepare("SELECT *FROM location WHERE code=? AND location=? AND model=? ");
                                $stmtc->execute(array(trim($rowData[0][0]), $rowData[0][1], $model));
                                if ($stmtc->rowCount() > 0) {
                                    continue;
                                } else {

                                    $in_location= $stmtcode->fetch(PDO::FETCH_ASSOC);

                                    $stmt = $this->db->prepare("INSERT INTO  location  (code,location,model,sequence,userid,`date`) values (?,?,?,?,?,?) ");
                                    $stmt->execute(array($rowData[0][0],$rowData[0][1], $model, $in_location['sequence'], $this->userid, time()));
                                }
                            }
                        }else{
                            $this->error_form=json_encode(array('files_normal'=>'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
                            break;
                        }

                    }

                    @unlink($inputFileName);
                }else
                {

                    $this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form))
                {
                    $this->lightRedirect(url.'/'.$this->folder."/{$model}");

                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,$model,'add','php'));
        $this->adminFooterController();
    }

    function  add_savers($model)
    {
        $this->AddToTraceByFunction($this->userid,'excel_location','add_savers/'.$model);
        $this->checkPermit('excel',$this->folder);
        $this->adminHeaderController($this->langControl('excel'));

        if(isset($_POST["submit"])) {


            try {
                $form = new  Form();

                $form->post('files_normal')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $name_file=json_decode($data['files_normal'],true);

                $inputFileName=$this->root_file.'/files/'.$name_file[0]['rand_name'];
                if (file_exists($inputFileName)) {

                    //  Read your Excel workbook
                    try {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFileName);
                    } catch (Exception $e) {
                        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                    }

                    //  Get worksheet dimensions
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();

                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                            NULL,
                            TRUE,
                            TRUE);



                        if (count($rowData[0])  >= 2)
                        {


                            $stmtcode=$this->db->prepare("SELECT *FROM location_model WHERE location=? AND model=?  ");
                            $stmtcode->execute(array(trim($rowData[0][1]),$model));
                            if ($stmtcode->rowCount()>0) {

                                $stmtc = $this->db->prepare("SELECT *FROM location WHERE code=? AND location=? AND model=? ");
                                $stmtc->execute(array(trim($rowData[0][0]), $rowData[0][1], $model));
                                if ($stmtc->rowCount() > 0) {
                                    continue;
                                } else {

                                    $in_location= $stmtcode->fetch(PDO::FETCH_ASSOC);

                                    $stmt = $this->db->prepare("INSERT INTO  location  (code,location,model,sequence,userid,`date`) values (?,?,?,?,?,?) ");
                                    $stmt->execute(array($rowData[0][0],$rowData[0][1], $model, $in_location['sequence'], $this->userid, time()));
                                }
                            }
                        }else{
                            $this->error_form=json_encode(array('files_normal'=>'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
                            break;
                        }

                    }

                    @unlink($inputFileName);
                }else
                {

                    $this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form))
                {
                    $this->lightRedirect(url.'/'.$this->folder."/{$model}");

                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,$model,'add','php'));
        $this->adminFooterController();
    }







    function lct($model)
	{
		if($this->handleLogin())
		{
           
			$code=strip_tags(trim($_POST['code']));
			$this->AddToTraceByFunction($this->userid,'excel_location','lct/'.$model.'/'.$code);
            $location=array();
            $stmt_locat = $this->db->prepare("SELECT location,sequence FROM `location_model`  WHERE  `model` =?  ");
            $stmt_locat->execute(array($model));
            while ($row = $stmt_locat->fetch(PDO::FETCH_ASSOC))
            {
                $location[]=$row;
            }

            if (!empty($location))
            {
            foreach ($location as $in_location){

                $stmtc = $this->db->prepare("SELECT *FROM location WHERE code=? AND location=? AND model=? ");
                $stmtc->execute(array($code, $in_location['location'], $model));
                if ($stmtc->rowCount() > 0) {
                    continue;
                } else {

                    $stmt = $this->db->prepare("INSERT INTO  location  (code,location,model,sequence,userid,`date`) values (?,?,?,?,?,?) ");
                    $stmt->execute(array($code,$in_location['location'], $model, $in_location['sequence'], $this->userid, time()));
                }

            }

                echo 1;
            }else
            {
                echo 'not_found';
            }


		}
	}



    function lct_acc_and_cover($model)
	{
		if($this->handleLogin())
		{
            
			$code=strip_tags(trim($_POST['code']));
			$location=strip_tags(trim($_POST['location']));
        	$this->AddToTraceByFunction($this->userid,'excel_location','lct_acc_and_cover/'.$model.'/'.$code.'/'.$location);
        


            $stmt_locat = $this->db->prepare("SELECT location,sequence FROM `location_model`  WHERE  location=? AND  `model` =?  ");
            $stmt_locat->execute(array($location,$model));
           if ($stmt_locat->rowCount() > 0)
           {
               $sequence=$stmt_locat->fetch(PDO::FETCH_ASSOC);
               $stmtc = $this->db->prepare("SELECT *FROM location WHERE code=? AND location=? AND model=? ");
               $stmtc->execute(array($code,$location, $model));
               if ($stmtc->rowCount() <= 0) {

                   $stmt = $this->db->prepare("INSERT INTO  location  (code,location,model,sequence,userid,`date`) values (?,?,?,?,?,?) ");
                   $stmt->execute(array($code,$location, $model, $sequence['sequence'], $this->userid, time()));
                   echo 1;
               }else
               {
                   echo 'found';
               }

           }

           else
            {
                echo 'not_found';
            }


		}
	}

function get_info_code($model)
{
    $code_get=trim($_GET['code']);


    if ($model=='mobile') {
        $code = 'code';
        $color = 'color';
        $excel = 'excel';
    }else {
        $code = 'code_'.$model;
        $color = 'color_'.$model;
        $excel = 'excel_'.$model;
    }


    if ($model=='accessories')
    {


        $stmt= $this->db->prepare("
          SELECT {$color}.code,{$color}.img,{$excel}.quantity,location.location,location.quantity as locq FROM `{$excel}` 
        left JOIN {$color} ON `{$color}`.code={$excel}.code 
        left JOIN location ON location.code={$excel}.code WHERE {$excel}.code=? AND `location`.model=?
        ");

    }else if ($model=='savers')
    {

        $stmt= $this->db->prepare("
          SELECT {$color}.code,{$color}.img,{$excel}.quantity,location.location,location.quantity as locq FROM `{$excel}` 
        left JOIN  product_savers ON product_savers.code={$excel}.code 
        left JOIN location ON location.code={$excel}.code WHERE {$excel}.code=? AND `location`.model=?
        ");

    }else{


        $stmt= $this->db->prepare("
        SELECT {$code}.code,{$color}.img,{$excel}.quantity,location.location,location.quantity as locq FROM `{$excel}` 
        left JOIN  {$code}  ON `{$code}`.code=`{$excel}`.code
        left JOIN {$color} ON {$color}.id={$code}.id_color 
        left JOIN location ON location.code={$excel}.code 
        WHERE {$excel}.code=? AND `location`.model=?

");
    }



    $stmt->execute(array($code_get,$model));
    $data=array();
    while ($row =$stmt->fetch(PDO::FETCH_ASSOC) )
    {
        $row['image']=$this->save_file.$row['img'];
        $data []=$row;
    }

    require ($this->render($this->folder,'html','details','php'));


}



    function location_backup($model)
    {

        $this->checkPermit('location_backup_confirm', $this->folder);
        $this->adminHeaderController($this->langControl($model));

        require($this->render($this->folder, 'html', 'location_backup', 'php'));
        $this->adminFooterController();

    }


    public function processing_location_backup($model)
    {


        $table = 'location_backup2';
        $primaryKey = 'id';

        $columns = array(

            array(
                'db' =>  'model',
                'dt' => 0,
                'formatter' => function ($id, $row) {
                 return   $this->langControl($id);
                }
            ),
            array('db' => 'code', 'dt' => 1),
            array(  'db' =>'location', 'dt'=>2,
                'formatter' => function ($id, $row) {
                    return $this->tamayaz_locations($id);
                }

            ),
            array('db' => 'quantity', 'dt' => 3),

            array(
                'db' => 'userid',
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    return   $this->UserInfo($id);
                }
            ),
            array('db' => 'date_noraml', 'dt' => 5),

            array('db' => 'id', 'dt' => 6),

        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"model='{$model}'")
        );




    }



function  zero_location($model)
    {
        $this->checkPermit('zero_location',$this->folder);
        $this->adminHeaderController($this->langControl('excel'));
        $this->AddToTraceByFunction($this->userid,'excel_location','zero_location/'.$model);
        
        if ($model=='mobile') {
            $code = 'code';
            $excel = 'excel';
        }else {
            $code = 'code_'.$model;
            $excel = 'excel_'.$model;
        }
        
        
        
        if(isset($_POST["submit"])) {
            

            try {
                $form = new  Form();

                $form->post('files_normal')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $name_file=json_decode($data['files_normal'],true);

                $inputFileName=$this->root_file.'/files/'.$name_file[0]['rand_name'];
                if (file_exists($inputFileName)) {

                    //  Read your Excel workbook
                    try {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFileName);
                    } catch (Exception $e) {
                        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                    }

                    //  Get worksheet dimensions
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();

                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                            NULL,
                            TRUE,
                            TRUE);


                        if (count($rowData[0])  >= 1)
                        {
                            $location=trim($rowData[0][0]);
                            $stmt = $this->db->prepare("SELECT  *FROM location WHERE location =  ?  AND  model = ?");
                            $stmt->execute(array($location,$model));
                            if ($stmt->rowCount() > 0) {
                                // من الممكن ان يحتوي الموقع على اكثر من باركود 
                                while($r=$stmt->fetch(PDO::FETCH_ASSOC))
                                {
                                    $code=$r['code'];
                                    $qun=(int)$r['quantity'];
                                    // update quantity in location excel by code 
                                    $stmt_ex = $this->db->prepare("UPDATE `{$excel}` SET quantity = quantity - {$qun},`userid`=?,`date`=?  WHERE code = ?");
                                    $stmt_ex->execute(array($this->userid,time(),$code));
                                }

                                // $stmt = $this->db->prepare("UPDATE `{$excel}` SET quantity = 0,`userid`=?,`date`=?  WHERE code = ?");
                                // $stmt->execute(array($this->userid,time(),$code));

                                $stmt2 = $this->db->prepare("UPDATE `location` SET quantity = 0 ,`userid`=?,`date`=? WHERE location = ?  AND  model = ?");
                                $stmt2->execute(array($this->userid,time(),$location,$model));
                               if ($stmt2->rowCount() > 0){
                                $this->filter_location_tracking_quantity($code, $model, $location, $r['quantity'], '  تصفير كمية المواقع  - رقم53', '-');
                                } else {
                                    $this->filter_location_error_quantity($code, $model, $location, $r['quantity'], '   تصفير كمية المواقع   - رقم الخطا 53', '-');

                                }


                            }

                        }else{
                            $this->error_form=json_encode(array('files_normal'=>'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
                            break;
                        }

                    }

                    @unlink($inputFileName);
                }else
                {

                    $this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form))
                {
                    $this->lightRedirect(url.'/'.$this->folder."/{$model}");

                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'html','zero_location','php'));
        $this->adminFooterController();
    }




}