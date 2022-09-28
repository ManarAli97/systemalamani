<?php

class Excel extends Controller
{



    function __construct()
    {
        parent::__construct();
        $this->table = 'excel';
        $this->excel_accessories = 'excel_accessories';
        $this->excel_games = 'excel_games';
        $this->excel_camera = 'excel_camera';
        $this->excel_computer = 'excel_computer';
        $this->excel_printing_supplies = 'excel_printing_supplies';
        $this->excel_network = 'excel_network';
        $this->excel_savers = 'excel_savers';
        $this->cart_shop_active = 'cart_shop_active';
        $this->location = 'location';
        $this->uesr_add_excel = 'uesr_add_excel';

         $this->date_archives=strtotime(date('Y-m-d h:i A',time()));
	     $this->normal_date = date('Y-m-d h:i A',time());
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `id` int(10) NOT NULL AUTO_INCREMENT ,
            `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `price_dollars`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `price`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `quantity`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->location}` (
            `id` int(10) NOT NULL AUTO_INCREMENT ,
            `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `location`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `quantity`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `model`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->uesr_add_excel}` (
            `id` int(10) NOT NULL AUTO_INCREMENT ,
            `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `price`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `userid`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `username`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `model`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        return $this->db->cht(array($this->table,$this->location,$this->uesr_add_excel));

    }


    public function index()
    {
        $index = new Index();
        $index->index();
    }

    public function list_excel()
    {
        $this->checkPermit('list_excel','excel');
        $this->adminHeaderController($this->langControl('excel'));

        require ($this->render($this->folder,'html','list','php'));
        $this->adminFooterController();

    }



    public function processing()
    {
        $this->checkPermit('list_excel','excel');
        $table = $this->table;
        $primaryKey ='id';

        $columns = array(

            array( 'db' => 'code', 'dt' => 0 ),
            array( 'db' => 'quantity', 'dt' => 1 ),
            array( 'db' => 'price_dollars', 'dt' => 2 ),
            array( 'db' => 'price', 'dt' => 3 ),
            array( 'db' => 'range1', 'dt' => 4 ),
            array( 'db' => 'range2', 'dt' => 5 ),
            array( 'db' => 'number_bill', 'dt' => 6 ),
            array( 'db' => 'date', 'dt' =>  7,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 8,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => 'code',
                'dt'        => 9,
                'formatter' => function($id, $row ) {

                    if ($this->checkLocation('mobile',$id))
                    {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('mobile',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }

                }
            ),
            array(  'db' => 'id', 'dt'=>10)


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

             SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns));


       // SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )

    }


    public function mobile_location_set()
    {
        $this->checkPermit('list_excel','excel');
        $this->adminHeaderController($this->langControl('excel'));

        require ($this->render($this->folder,'html','location_set','php'));
        $this->adminFooterController();

    }

    public function processing_mobile_location_set()
    {
        $this->checkPermit('list_excel','excel');
        $table = $this->table;
        $tableJoin = $this->table.'.';
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $tableJoin.'code', 'dt' => 0 ),
            array( 'db' => $tableJoin.'quantity', 'dt' => 1 ),
            array( 'db' => $tableJoin.'price_dollars', 'dt' => 2 ),
            array( 'db' => $tableJoin.'price', 'dt' => 3 ),
            array( 'db' => $tableJoin.'range1', 'dt' => 4 ),
            array( 'db' => $tableJoin.'range2', 'dt' => 5 ),
            array( 'db' => $tableJoin.'number_bill', 'dt' => 6 ),
            array( 'db' => $tableJoin.'date', 'dt' =>  7,
                'formatter' => function( $d, $row ) {
                    	return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin.'id',
                'dt'        => 8,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin.'code',
                'dt'        => 9,
                'formatter' => function($id, $row ) {

                    if ($this->checkLocation('mobile',$id))
                    {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('mobile',$id,$row[1]) class='btn btn-success'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }

                }
            ),
            array(  'db' => $tableJoin.'id', 'dt'=>10)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = "INNER JOIN `location` ON {$table}.code = location.code ";
         $whereAll = array("location.model='mobile'");
         $group="GROUP BY {$table}.code";

        echo json_encode(

             SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll,null,$group));


    }



    public function mobile_location_set_not()
    {
        $this->checkPermit('list_excel','excel');
        $this->adminHeaderController($this->langControl('excel'));


        require ($this->render($this->folder,'html','location_set_not','php'));
        $this->adminFooterController();

    }

    public function processing_mobile_location_set_not()
    {
        $this->checkPermit('list_excel','excel');
        $table = $this->table;
        $tableJoin = $table.'.';
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $tableJoin.'code', 'dt' => 0 ),
            array( 'db' => $tableJoin.'quantity', 'dt' => 1 ),
            array( 'db' => $tableJoin.'price_dollars', 'dt' => 2 ),
            array( 'db' => $tableJoin.'price', 'dt' => 3 ),
            array( 'db' => $tableJoin.'range1', 'dt' => 4 ),
            array( 'db' => $tableJoin.'range2', 'dt' => 5 ),
            array( 'db' => $tableJoin.'number_bill', 'dt' => 6 ),
            array( 'db' => $tableJoin.'date', 'dt' =>  7,
                'formatter' => function( $d, $row ) {
                    	return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin.'id',
                'dt'        => 8,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin.'code',
                'dt'        => 9,
                'formatter' => function($id, $row ) {

                    if ($this->checkLocation('mobile',$id))
                    {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('mobile',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }

                }
            ),
            array(  'db' => $tableJoin.'id', 'dt'=>10)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = "LEFT JOIN location ON {$table}.code = location.code  LEFT JOIN code ON excel.code=code.code ";
         $whereAll = array('location.code Is NULL' , "code.location <> ''");

        echo json_encode(

            Ssp::complex_join($_GET, $sql_details, $table, $primaryKey, $columns,$join,null,$whereAll));


    }



    function  add_mobile()
    {
        $this->checkPermit('add_mobile','excel');
        $this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'excel','add_mobile/'.$id);
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


                    $stmtCopy=$this->db->prepare("INSERT INTO excel_mobile_archives SELECT *  FROM `excel`");
					$stmtCopy->execute();
					if ($stmtCopy->rowCount() > 0 || true ) {
						$stmt = $this->db->prepare("DELETE  FROM `excel` WHERE 1");
						$stmt->execute();

						$stmt_loc = $this->db->prepare("DELETE  FROM `location_confirm` WHERE model =?");
                        $stmt_loc->execute(array('mobile'));

						$date = time();

						$stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
						$stmt_date->execute(array('mobile', $date));

						//  Loop through each row of the worksheet in turn

						for ($row = 1; $row <= $highestRow; $row++) {
							//  Read a row of data into an array
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
								FALSE,
								TRUE,
								TRUE);


							if (count($rowData[0]) == 6 || count($rowData[0]) == 7) {

								$stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `code`=? ");
								$stmt->execute(array($rowData[0][0]));
								if ($stmt->rowCount() > 0) {
									continue;
								}

								if (!empty($rowData[0][0])) {

									if (count($rowData[0]) == 6) {
										$stmt = $this->db->prepare("INSERT INTO excel (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $rowData[0][3], $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date, $this->userid,$this->date_archives));

									} else {
										$stmt = $this->db->prepare("INSERT INTO excel (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`number_bill`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date, $this->userid,$this->date_archives));
									}

										$stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,`number_bill`) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
										$stmt_user_add_excel->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date, '', 'new', 'mobile',$rowData[0][6]));

										$lc=new location_confirm();
									    $lc->update($rowData[0][0], $rowData[0][1],'mobile', $rowData[0][2]);
								}
							} else {
								$this->error_form = json_encode(array('files_normal' => 'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
								break;
							}

						}

						@unlink($inputFileName);
					}
                }else
                {

                    $this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form))
                {
                    $this->lightRedirect(url."/location_confirm/view/mobile");

                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'html','add','php'));
        $this->adminFooterController();
    }



    function  mobile_cumulative_upload( )
    {
        $this->checkPermit('mobile_cumulative_upload','excel');
        $this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'excel','mobile_cumulative_upload');
        if(isset($_POST["submit"])) {


            try {
                $form = new  Form();

                $form->post('files_mobile_cumulative_upload')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $name_file=json_decode($data['files_mobile_cumulative_upload'],true);

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

                    $date=time();
                    $stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
                    $stmt_date->execute(array('mobile',$date));

                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
							FALSE,
                            TRUE,
                            TRUE);



                        if (count($rowData[0]) >=6  ||  count($rowData[0]) >=7)
                        {

                            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `code`=? ");
                            $stmt->execute(array($rowData[0][0]));
                            if($stmt->rowCount()>0)
                            {
                                if (!empty($rowData[0][0])) {


                                    if (count($rowData[0]) ==6 )
                                    {
                                        $stmt = $this->db->prepare("UPDATE  excel SET `quantity`=quantity + ? ,`price_dollars`=? ,  `price` =?, `range1`=?,`range2`=?, `date` = ? ,`userid`=? ,`date_archives`=?  WHERE `code`= ?  ");
                                        $stmt->execute(array($rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date,$this->userid,$this->date_archives, $rowData[0][0]));
                                    }else
                                    {
                                        $stmt = $this->db->prepare("UPDATE  excel SET `quantity`=quantity + ? ,`price_dollars`=? ,  `price` =?, `range1`=?,`range2`=?,`number_bill`=?, `date` = ? ,`userid`=? ,`date_archives`=?  WHERE `code`= ?  ");
                                        $stmt->execute(array($rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives, $rowData[0][0]));


                                    }

                                }
                            }else
                            {
                                if (!empty($rowData[0][0])) {



                                    if (count($rowData[0]) ==6) {
                                        $stmt = $this->db->prepare("INSERT INTO  excel  (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?)");
                                        $stmt->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date,$this->userid,$this->date_archives));
                                    }else
                                    {
                                        $stmt = $this->db->prepare("INSERT INTO excel  (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`number_bill`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?,?)");
                                        $stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3], $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives));

                                    }

                                }
                            }
							if (!empty($rowData[0][0])) {
								$stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,number_bill) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
								$stmt_user_add_excel->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date, '', 'old', 'mobile',$rowData[0][6]));

								$lc=new location_confirm();
								$lc->update($rowData[0][0], $rowData[0][1],'mobile', $rowData[0][2],1);
							}

                        }else{
                            $this->error_form2=json_encode(array('files_mobile_cumulative_upload'=>'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
                            break;
                        }

                    }

                    @unlink($inputFileName);
                }else
                {

                    $this->error_form2=json_encode(array('files_mobile_cumulative_upload'=>'يرجى اعادة رفع الملف'));
                }

				if (empty($this->error_form2))
				{
					$this->lightRedirect(url."/location_confirm/view/mobile");

				}
            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form2=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'html','add','php'));
        $this->adminFooterController();
    }





    function delete_excel($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->table, "`id`={$id}");
            echo 'true';
        }
    }



    public function list_excel_accessories()
    {
        $this->checkPermit('list_excel_excel_accessories','excel');
        $this->adminHeaderController($this->langControl('excel'));

        require ($this->render($this->folder,'accessories','list','php'));
        $this->adminFooterController();

    }



    public function processing_accessories()
    {
        $this->checkPermit('list_excel_excel_accessories','excel');
        $table = $this->excel_accessories;
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'code', 'dt' => 0 ),
            array( 'db' => 'quantity', 'dt' => 1 ),
            array( 'db' => 'price_dollars', 'dt' => 2 ),
            array( 'db' => 'price', 'dt' => 3 ),
            array( 'db' => 'range1', 'dt' => 4 ),
            array( 'db' => 'range2', 'dt' => 5 ),
            array( 'db' => 'color', 'dt' => 6 ),
            array( 'db' => 'number_bill', 'dt' => 7 ),
            array( 'db' => 'date', 'dt' => 8,
                'formatter' => function( $d, $row ) {
                    	return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 9,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => 'code',
                'dt'        =>10,
                'formatter' => function($id, $row ) {

                    if ($this->checkLocation('accessories',$id,$row[6]))
                    {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('accessories',$id,$row[1],'$row[6]') class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }

                }
            ),
            array(  'db' => 'id', 'dt'=>11)


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
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )
        );

    }





    public function accessories_location_set()
    {
        $this->checkPermit('list_excel','excel');
        $this->adminHeaderController($this->langControl('excel'));

        require ($this->render($this->folder,'accessories','location_set','php'));
        $this->adminFooterController();

    }

    public function processing_accessories_location_set()
    {
        $this->checkPermit('list_excel','excel');
        $table = 'excel_accessories';
        $primaryKey = $table.'.id';
        $tableJoin = $table.'.';

        $columns = array(

            array( 'db' => $tableJoin.'code', 'dt' => 0 ),
            array( 'db' => $tableJoin.'quantity', 'dt' => 1 ),
            array( 'db' => $tableJoin.'price_dollars', 'dt' => 2 ),
            array( 'db' => $tableJoin.'price', 'dt' => 3 ),
            array( 'db' => $tableJoin.'range1', 'dt' => 4 ),
            array( 'db' => $tableJoin.'range2', 'dt' => 5 ),
            array( 'db' => $tableJoin.'color', 'dt' => 6 ),
            array( 'db' => $tableJoin.'number_bill', 'dt' => 7 ),
            array( 'db' => $tableJoin.'date', 'dt' => 8,
                'formatter' => function( $d, $row ) {
                    	return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin.'id',
                'dt'        => 9,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin.'code',
                'dt'        =>10,
                'formatter' => function($id, $row ) {

                    if ($this->checkLocation('accessories',$id,$row[6]))
                    {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('accessories',$id,$row[1],'$row[6]') class='btn btn-success'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }

                }
            ),
            array(  'db' => $tableJoin.'id', 'dt'=>11)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "INNER JOIN `location` ON {$table}.code = location.code ";
        $whereAll = array("location.model='accessories'");
        $group="GROUP BY {$table}.code,{$table}.color";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll,null,$group));

    }



    public function accessories_location_set_not()
    {
        $this->checkPermit('list_excel','excel');
        $this->adminHeaderController($this->langControl('excel'));

        require ($this->render($this->folder,'accessories','location_set_not','php'));
        $this->adminFooterController();

    }

    public function processing_accessories_location_set_not()
    {
        $this->checkPermit('list_excel','excel');
        $table = 'excel_accessories';
        $tableJoin = $table.'.';
        $primaryKey = $table.'.id';


        $columns = array(

            array( 'db' => $tableJoin.'code', 'dt' => 0 ),
            array( 'db' => $tableJoin.'quantity', 'dt' => 1 ),
            array( 'db' => $tableJoin.'price_dollars', 'dt' => 2 ),
            array( 'db' => $tableJoin.'price', 'dt' => 3 ),
            array( 'db' => $tableJoin.'range1', 'dt' => 4 ),
            array( 'db' => $tableJoin.'range2', 'dt' => 5 ),
            array( 'db' => $tableJoin.'color', 'dt' => 6 ),
            array( 'db' => $tableJoin.'number_bill', 'dt' => 7 ),
            array( 'db' => $tableJoin.'date', 'dt' => 8,
                'formatter' => function( $d, $row ) {
                    	return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin.'id',
                'dt'        => 9,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin.'code',
                'dt'        =>10,
                'formatter' => function($id, $row ) {

                    if ($this->checkLocation('accessories',$id,$row[6]))
                    {
                    return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('accessories',$id,$row[1],'$row[6]') class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }

                }
            ),
            array(  'db' => $tableJoin.'id', 'dt'=>11)


        );


// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = "LEFT JOIN location ON   location.code = {$table}.code LEFT JOIN color_accessories ON color_accessories.code = excel_accessories.code  ";
        $whereAll = array('location.code Is NULL' , "color_accessories.location <> ''");
        $group = "GROUP BY excel_accessories.code,excel_accessories.color";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll,null,$group));



    }






    function  add_accessories()
    {
        $this->checkPermit('add_accessories','excel');
        $this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'excel','add_accessories');
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


					$stmtCopy=$this->db->prepare("INSERT INTO excel_accessories_archives SELECT *  FROM `excel_accessories`");
					$stmtCopy->execute();
					if ($stmtCopy->rowCount() > 0 || true ){
						$stmt = $this->db->prepare("DELETE  FROM `excel_accessories` WHERE 1");
						$stmt->execute();

                        $stmt_loc = $this->db->prepare("DELETE  FROM `location_confirm` WHERE model =?");
                        $stmt_loc->execute(array('accessories'));

						$date = time();
						$stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
						$stmt_date->execute(array('accessories', $date));

						//  Loop through each row of the worksheet in turn

						for ($row = 1; $row <= $highestRow; $row++) {
							//  Read a row of data into an array
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
								FALSE,
								TRUE,
								TRUE);


							if (count($rowData[0]) == 8 || count($rowData[0]) == 7) {

								if (!empty($rowData[0][0])) {

									$stmt = $this->db->prepare("SELECT * FROM {$this->excel_accessories} WHERE `code`=? AND `color`=? ");
									$stmt->execute(array($rowData[0][0],$rowData[0][6]));
									if ($stmt->rowCount() > 0) {
										continue;
									}


									if (count($rowData[0]) == 7) {




										$stmt = $this->db->prepare("INSERT INTO   excel_accessories  (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`color`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives));
									} else {



										$stmt = $this->db->prepare("INSERT INTO  excel_accessories  (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`color`,`number_bill`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $rowData[0][7], $date,$this->userid,$this->date_archives));

 									}


										$stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,number_bill) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
										$stmt_user_add_excel->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date,  $rowData[0][6], 'new', 'accessories',$rowData[0][7]));
									$lc=new location_confirm();
									$lc->update($rowData[0][0], $rowData[0][1],'accessories', $rowData[0][2], $rowData[0][6]);
								}



							} else {
								$this->error_form = json_encode(array('files_normal' => 'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
								break;
							}

						}

						@unlink($inputFileName);
					}
                }else
                {

                    $this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form))
                {

					$this->lightRedirect(url."/location_confirm/view/accessories");
                }



            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'accessories','add','php'));
        $this->adminFooterController();
    }



    function  accessories_cumulative_upload( )
    {
        $this->checkPermit('accessories_cumulative_upload','excel');
        $this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'excel','accessories_cumulative_upload');
        if(isset($_POST["submit"])) {


            try {
                $form = new  Form();

                $form->post('files_accessories_cumulative_upload')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $name_file=json_decode($data['files_accessories_cumulative_upload'],true);

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

                    $date=time();
                    $stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
                    $stmt_date->execute(array('accessories',$date));

                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array

                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
							FALSE,
                            TRUE,
                            TRUE);


                        if (count($rowData[0]) >=8 ||  count($rowData[0]) >=7)
                        {

                            $stmt = $this->db->prepare("SELECT * FROM {$this->excel_accessories} WHERE `code`=? AND `color` =? ");
                            $stmt->execute(array($rowData[0][0],$rowData[0][6]));
                            if($stmt->rowCount()>0)
                            {
                                if (!empty($rowData[0][0])) {

                                    if (count($rowData[0]) ==7)
                                    {

                                        $stmt = $this->db->prepare("UPDATE  excel_accessories SET `quantity`=quantity + ? ,`price_dollars`=? ,  `price` =?,`range1`=?,`range2`=?,`color`=?, `date` = ? ,`userid`=? ,`date_archives`=? WHERE `code`= ? AND `color`= ? ");
                                        $stmt->execute(array($rowData[0][1], $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives, $rowData[0][0],$rowData[0][6]));
                                    }else
                                    {


                                        $stmt = $this->db->prepare("UPDATE  excel_accessories SET `quantity`=quantity + ? ,`price_dollars`=? ,  `price` =?,`range1`=?,`range2`=?,`color`=?, `number_bill`=?, `date` = ?,`userid`=? ,`date_archives`=?  WHERE `code`= ? AND `color`= ? ");
                                        $stmt->execute(array($rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $rowData[0][7], $date,$this->userid,$this->date_archives, $rowData[0][0],$rowData[0][6]));


                                    }

                                }
                            }else
                            {
                                if (!empty($rowData[0][0])) {


                                    if (count($rowData[0]) ==7) {


                                        $stmt = $this->db->prepare("INSERT INTO excel_accessories (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`color`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?,?)");
                                        $stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3], $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]),$rowData[0][6], $date,$this->userid,$this->date_archives));
                                    }else
                                    {


                                        $stmt = $this->db->prepare("INSERT INTO excel_accessories (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`color`,`number_bill`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                                        $stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]),$rowData[0][6],$rowData[0][7], $date,$this->userid,$this->date_archives));


                                    }

                                }
                            }
							if (!empty($rowData[0][0])) {
								$stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,number_bill) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
								$stmt_user_add_excel->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date,  $rowData[0][6], 'old', 'accessories',$rowData[0][7]));
								$lc=new location_confirm();
								$lc->update($rowData[0][0], $rowData[0][1],'accessories', $rowData[0][2],1);
							}

                        }else{
                            $this->error_form2=json_encode(array('files_accessories_cumulative_upload'=>'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
                            break;
                        }

                    }

                    @unlink($inputFileName);
                }else
                {

                    $this->error_form2=json_encode(array('files_accessories_cumulative_upload'=>'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form2))
                {

					$this->lightRedirect(url."/location_confirm/view/accessories");
                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form2=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'accessories','add','php'));
        $this->adminFooterController();
    }









    function delete_excel_accessories($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->excel_accessories, "`id`={$id}");
            echo 'true';
        }
    }


    public function list_excel_service()
    {
        $this->checkPermit('list_excel_excel_service','excel');
        $this->adminHeaderController($this->langControl('excel'));

        require ($this->render($this->folder,'service','list','php'));
        $this->adminFooterController();

    }



    public function processing_service()
    {
        $this->checkPermit('list_excel_excel_service','excel');
        $table = $this->excel_savers;
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'code', 'dt' => 0 ),
            array( 'db' => 'quantity', 'dt' => 1 ),
            array( 'db' => 'price_dollars', 'dt' => 2 ),
            array( 'db' => 'price', 'dt' => 3 ),
            array( 'db' => 'number_bill', 'dt' => 4 ),
            array( 'db' => 'date', 'dt' =>  5,
                'formatter' => function( $d, $row ) {
                    	return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => 'id',
                'dt'        =>6,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
			array(
				'db'        => 'code',
				'dt'        => 7,
				'formatter' => function($id, $row ) {

					if ($this->checkLocation('product_savers',$id))
					{
						return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('product_savers',$id,$row[2]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
					}

				}
			),
            array(  'db' => 'id', 'dt'=>8)


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
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )
        );

    }




    public function list_excel_service_location_set()
    {
        $this->checkPermit('list_excel_excel_service','excel');
        $this->adminHeaderController($this->langControl('excel'));

        require ($this->render($this->folder,'service','location_set','php'));
        $this->adminFooterController();

    }



    public function processing_service_location_set()
    {
        $this->checkPermit('list_excel_excel_service','excel');

		$table = 'excel_savers';
		$primaryKey = $table.'.id';
		$tableJoin = $table.'.';

        $columns = array(

            array( 'db' => $tableJoin.'code', 'dt' => 0 ),
            array( 'db' => $tableJoin.'quantity', 'dt' => 1 ),
            array( 'db' => $tableJoin.'price_dollars', 'dt' => 2 ),
            array( 'db' => $tableJoin.'price', 'dt' => 3 ),
            array( 'db' => $tableJoin.'number_bill', 'dt' => 4 ),
            array( 'db' => $tableJoin.'date', 'dt' =>  5,
                'formatter' => function( $d, $row ) {
                    	return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin.'id',
                'dt'        =>6,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
			array(
				'db'        => $tableJoin.'code',
				'dt'        => 7,
				'formatter' => function($id, $row ) {

					if ($this->checkLocation('product_savers',$id))
					{
						return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('product_savers',$id,$row[2]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
					}

				}
			),
            array(  'db' => $tableJoin.'id', 'dt'=>8)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
		$join = "INNER JOIN `location` ON {$table}.code = location.code ";
		$whereAll = array("location.model='product_savers'");
		$group="GROUP BY {$table}.code";

		echo json_encode(
			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll,null,$group));

	}





    public function list_excel_service_location_set_not()
    {
        $this->checkPermit('list_excel_excel_service','excel');
        $this->adminHeaderController($this->langControl('excel'));

        require ($this->render($this->folder,'service','location_set_not','php'));
        $this->adminFooterController();

    }



    public function processing_service_location_set_not()
    {
        $this->checkPermit('list_excel_excel_service','excel');

		$table = 'excel_savers';
		$primaryKey = $table.'.id';
		$tableJoin = $table.'.';

        $columns = array(

            array( 'db' => $tableJoin.'code', 'dt' => 0 ),
            array( 'db' => $tableJoin.'quantity', 'dt' => 1 ),
            array( 'db' => $tableJoin.'price_dollars', 'dt' => 2 ),
            array( 'db' => $tableJoin.'price', 'dt' => 3 ),
            array( 'db' => $tableJoin.'number_bill', 'dt' => 4 ),
            array( 'db' => $tableJoin.'date', 'dt' =>  5,
                'formatter' => function( $d, $row ) {
                    	return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin.'id',
                'dt'        =>6,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
			array(
				'db'        => $tableJoin.'code',
				'dt'        => 7,
				'formatter' => function($id, $row ) {

					if ($this->checkLocation('product_savers',$id))
					{
						return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('product_savers',$id,$row[2]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
					}

				}
			),
            array(  'db' => $tableJoin.'id', 'dt'=>8)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );



		$join = "LEFT JOIN location ON   location.code = {$table}.code LEFT JOIN product_savers ON product_savers.code = excel_savers.code  ";
		$whereAll = array('location.code IS NULL' );
		$group = "GROUP BY excel_savers.code";

		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll,null,$group));




	}




    function  add_service()
    {
        $this->checkPermit('add_service','excel');
        $this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'excel','add_service');
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

					$stmtCopy=$this->db->prepare("INSERT INTO excel_savers_archives SELECT *  FROM `excel_savers`");
					$stmtCopy->execute();
					if ($stmtCopy->rowCount() > 0 || true ) {
						$stmt = $this->db->prepare("DELETE  FROM `excel_savers` WHERE 1");
						$stmt->execute();

                        $stmt_loc = $this->db->prepare("DELETE  FROM `location_confirm` WHERE model =?");
                        $stmt_loc->execute(array('savers'));
						$date = time();
						$stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
						$stmt_date->execute(array('savers', $date));

						//  Loop through each row of the worksheet in turn

						for ($row = 1; $row <= $highestRow; $row++) {
							//  Read a row of data into an array
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
								FALSE,
								TRUE,
								TRUE);

							if (  count($rowData[0]) == 5) {

								if (!empty($rowData[0][0])) {

									$stmt = $this->db->prepare("SELECT * FROM {$this->excel_savers} WHERE `code`=? ");
									$stmt->execute(array($rowData[0][0]));
									if ($stmt->rowCount() > 0) {
										continue;
									}


										if (!empty($rowData[0][0])) {

											$stmt = $this->db->prepare("INSERT INTO excel_savers (`code`,`quantity`,`price_dollars`,`price`,`number_bill`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?)");
											$stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3], trim($rowData[0][4]), $date,$this->userid,$this->date_archives));
										}


									$stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`type`,`model`,number_bill) VALUES(?,?,?,?,?,?,?,?,?,?)");
									$stmt_user_add_excel->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date,   'new', 'savers',$rowData[0][4]));
									$lc=new location_confirm();
									$lc->update($rowData[0][0], $rowData[0][1],'savers', $rowData[0][2]);

								}


							} else {
								$this->error_form = json_encode(array('files_normal' => 'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
								break;
							}

						}

						@unlink($inputFileName);
					}
                }else
                {

                    $this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form))
				{

					$this->lightRedirect(url."/location_confirm/view/savers");
				}


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'service','add','php'));
        $this->adminFooterController();
    }


    function  service_cumulative_upload()
    {
        $this->checkPermit('service_cumulative_upload','excel');
        $this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'excel','service_cumulative_upload');

        if(isset($_POST["submit"])) {


            try {
                $form = new  Form();

                $form->post('files_service_cumulative_upload')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $name_file=json_decode($data['files_service_cumulative_upload'],true);

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


                    $date=time();
                    $stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
                    $stmt_date->execute(array('savers',$date));

                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
							FALSE,
                            TRUE,
                            TRUE);

                        if (count($rowData[0]) ==5)
                        {

                            if (!empty($rowData[0][0])) {


                                    $stmt = $this->db->prepare("SELECT * FROM {$this->excel_savers} WHERE `code`=?");
                                    $stmt->execute(array($rowData[0][0]));
                                    if ($stmt->rowCount() > 0) {
                                        if (!empty($rowData[0][0])) {


                                            $stmt = $this->db->prepare("UPDATE  excel_savers SET `quantity`=quantity + ? ,`price_dollars`=? ,  `price` =?, `number_bill` =?,  `date` = ? ,`userid`=?,`date_archives`=? WHERE `code`= ? ");
                                            $stmt->execute(array($rowData[0][1] , $rowData[0][2], $rowData[0][3], $rowData[0][4], $date,$this->userid,$this->date_archives, $rowData[0][0]));
                                        }
                                    } else {

                                        if (!empty($rowData[0][0])) {

                                            $stmt = $this->db->prepare("INSERT INTO excel_savers (`code`,`quantity`,`price_dollars`,`price`,`number_bill`,`date`,`userid`,date_archives) VALUES(?,?,?,?,?,?,?,?)");
                                            $stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3], trim($rowData[0][4]), $date,$this->userid,$this->date_archives));
                                        }
                                    }




								if (!empty($rowData[0][0])) {

									$stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`type`,`model`,number_bill) VALUES(?,?,?,?,?,?,?,?,?,?)");
									$stmt_user_add_excel->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date,   'old', 'savers',$rowData[0][4]));
									$lc=new location_confirm();
									$lc->update($rowData[0][0], $rowData[0][1],'savers', $rowData[0][2],1);

								}
                            }


                        }else{
                            $this->error_form2=json_encode(array('files_service_cumulative_upload'=>'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
                            break;
                        }

                    }

                    @unlink($inputFileName);
                }else
                {

                    $this->error_form2=json_encode(array('files_service_cumulative_upload'=>'يرجى اعادة رفع الملف'));
                }

                if (empty( $this->error_form2))
				{

					$this->lightRedirect(url."/location_confirm/view/savers");
				}


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form2=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'service','add','php'));
        $this->adminFooterController();
    }






    function delete_excel_service($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->excel_savers, "`id`={$id}");
            echo 'true';
        }
    }




    public function list_excel_games()
    {
        $this->checkPermit('list_excel_excel_games','excel');
        $this->adminHeaderController($this->langControl('excel'));

        require ($this->render($this->folder,'games','list','php'));
        $this->adminFooterController();

    }



    public function processing_games()
    {
        $this->checkPermit('list_excel_excel_games','excel');
        $table = $this->excel_games;
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'code', 'dt' => 0 ),
            array( 'db' => 'quantity', 'dt' => 1 ),
            array( 'db' => 'price_dollars', 'dt' => 2 ),
            array( 'db' => 'price', 'dt' => 3 ),
            array( 'db' => 'range1', 'dt' => 4 ),
            array( 'db' => 'range2', 'dt' => 5 ),
            array( 'db' => 'number_bill', 'dt' => 6 ),
            array( 'db' => 'date', 'dt' =>  7,
                'formatter' => function( $d, $row ) {
                    	return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 8,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => 'code',
                'dt'        => 9,
                'formatter' => function($id, $row ) {

                    if ($this->checkLocation('games',$id))
                    {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('games',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }

                }
            ),
            array(  'db' => 'id', 'dt'=>10)


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
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )
        );

    }




    public function games_location_set()
    {
        $this->checkPermit('list_excel','excel');
        $this->adminHeaderController($this->langControl('excel'));

        require ($this->render($this->folder,'games','location_set','php'));
        $this->adminFooterController();

    }

    public function processing_games_location_set()
    {
        $this->checkPermit('list_excel','excel');
        $table = 'excel_games';
        $primaryKey = $table.'.id';
        $tableJoin = $table.'.';
        $columns = array(

            array( 'db' => $tableJoin.'code', 'dt' => 0 ),
            array( 'db' => $tableJoin.'quantity', 'dt' => 1 ),
            array( 'db' => $tableJoin.'price_dollars', 'dt' => 2 ),
            array( 'db' => $tableJoin.'price', 'dt' => 3 ),
            array( 'db' => $tableJoin.'range1', 'dt' => 4 ),
            array( 'db' => $tableJoin.'range2', 'dt' => 5 ),
            array( 'db' => $tableJoin.'number_bill', 'dt' => 6 ),
            array( 'db' => $tableJoin.'date', 'dt' =>  7,
                'formatter' => function( $d, $row ) {
                    	return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin.'id',
                'dt'        => 8,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin.'code',
                'dt'        => 9,
                'formatter' => function($id, $row ) {

                    if ($this->checkLocation('games',$id))
                    {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('games',$id,$row[1]) class='btn btn-success'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }

                }
            ),
            array(  'db' => $tableJoin.'id', 'dt'=>10)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );



        $join = "INNER JOIN `location` ON {$table}.code = location.code ";
        $whereAll = array("location.model='games'");
        $group="GROUP BY {$table}.code";

        echo json_encode(
            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll,null,$group));

    }



    public function games_location_set_not()
    {
        $this->checkPermit('list_excel','excel');
        $this->adminHeaderController($this->langControl('excel'));

        require ($this->render($this->folder,'games','location_set_not','php'));
        $this->adminFooterController();

    }

    public function processing_games_location_set_not()
    {
        $this->checkPermit('list_excel','excel');
        $table = 'excel_games';
        $tableJoin = $table.'.';
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $tableJoin.'code', 'dt' => 0 ),
            array( 'db' => $tableJoin.'quantity', 'dt' => 1 ),
            array( 'db' => $tableJoin.'price_dollars', 'dt' => 2 ),
            array( 'db' => $tableJoin.'price', 'dt' => 3 ),
            array( 'db' => $tableJoin.'range1', 'dt' => 4 ),
            array( 'db' => $tableJoin.'range2', 'dt' => 5 ),
            array( 'db' => $tableJoin.'number_bill', 'dt' => 6 ),
            array( 'db' => $tableJoin.'date', 'dt' =>  7,
                'formatter' => function( $d, $row ) {
                    	return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin.'id',
                'dt'        => 8,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin.'code',
                'dt'        => 9,
                'formatter' => function($id, $row ) {

                    if ($this->checkLocation('games',$id))
                    {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('games',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }

                }
            ),
            array(  'db' => $tableJoin.'id', 'dt'=>10)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = "LEFT JOIN location ON {$table}.code = location.code  LEFT JOIN code_games ON excel_games.code=code_games.code ";
        $whereAll = array('location.code Is NULL' , "code_games.location <> ''");

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll));


        // SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )

    }



    function  add_games()
    {
        $this->checkPermit('add_games','excel');
        $this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'excel','add_games');

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

					$stmtCopy=$this->db->prepare("INSERT INTO excel_games_archives SELECT *  FROM `excel_games`");
					$stmtCopy->execute();
					if ($stmtCopy->rowCount() > 0 || true ) {
						$stmt = $this->db->prepare("DELETE  FROM `excel_games` WHERE 1");
						$stmt->execute();
                        $stmt_loc = $this->db->prepare("DELETE  FROM `location_confirm` WHERE model =?");
                        $stmt_loc->execute(array('games'));
						$date = time();
						$stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
						$stmt_date->execute(array('games', $date));

						//  Loop through each row of the worksheet in turn

						for ($row = 1; $row <= $highestRow; $row++) {
							//  Read a row of data into an array
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
								FALSE,
								TRUE,
								TRUE);


							if (count($rowData[0]) == 6 || count($rowData[0]) == 7) {

								$stmt = $this->db->prepare("SELECT * FROM {$this->excel_games} WHERE `code`=? ");
								$stmt->execute(array($rowData[0][0]));
								if ($stmt->rowCount() > 0) {
									continue;
								}

								if (!empty($rowData[0][0])) {

									if (count($rowData[0]) == 6) {
										$stmt = $this->db->prepare("INSERT INTO excel_games (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date,$this->userid,$this->date_archives));
									} else {

										$stmt = $this->db->prepare("INSERT INTO excel_games (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`number_bill`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives));

									}
									$stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,number_bill) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
									$stmt_user_add_excel->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date,  '', 'new', 'games',$rowData[0][6]));

									$lc=new location_confirm();
									$lc->update($rowData[0][0], $rowData[0][1],'games', $rowData[0][2]);


								}



							} else {
								$this->error_form = json_encode(array('files_normal' => 'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
								break;
							}

						}

						@unlink($inputFileName);
					}
                }else
                {

                    $this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form))
                {
					$this->lightRedirect(url."/location_confirm/view/view/games");

                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'games','add','php'));
        $this->adminFooterController();
    }



    function  games_cumulative_upload( )
    {
        $this->checkPermit('games_cumulative_upload','excel');
        $this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'excel','games_cumulative_upload');

        if(isset($_POST["submit"])) {


            try {
                $form = new  Form();

                $form->post('files_games_cumulative_upload')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $name_file=json_decode($data['files_games_cumulative_upload'],true);

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

                    $date=time();
                    $stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
                    $stmt_date->execute(array('games',$date));

                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
							FALSE,
                            TRUE,
                            TRUE);


                        if (count($rowData[0]) ==6  || count($rowData[0]) ==7)
                        {

                            $stmt = $this->db->prepare("SELECT * FROM {$this->excel_games} WHERE `code`=? ");
                            $stmt->execute(array($rowData[0][0]));
                            if($stmt->rowCount()>0)
                            {
                                if (!empty($rowData[0][0])) {

                                    if (count($rowData[0]) ==6) {
                                        $stmt = $this->db->prepare("UPDATE  excel_games SET `quantity`=quantity + ? ,`price_dollars`=? ,  `price` =?,`range1`=?,`range2`=?,  `date` = ?,`userid`=?,`date_archives`=?  WHERE `code`= ?  ");
                                        $stmt->execute(array($rowData[0][1] , $rowData[0][2], $rowData[0][3], $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date,$this->userid,$this->date_archives, $rowData[0][0]));
                                    }else
                                    {

                                        $stmt = $this->db->prepare("UPDATE  excel_games SET `quantity`=quantity + ? ,`price_dollars`=? ,  `price` =?,`range1`=?,`range2`=?, `number_bill`=?,  `date` = ?,`userid`=?,`date_archives`=?  WHERE `code`= ?  ");
                                        $stmt->execute(array($rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives, $rowData[0][0]));


                                    }
                                }
                            }else
                            {
                                if (!empty($rowData[0][0])) {


                                    if (count($rowData[0]) ==6) {
                                        $stmt = $this->db->prepare("INSERT INTO excel_games  (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?)");
                                        $stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date,$this->userid,$this->date_archives));
                                    }else
                                    {
                                        $stmt = $this->db->prepare("INSERT INTO excel_games  (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`number_bill`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?,?)");
                                        $stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3], $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives));

                                    }

                                }
                            }

							if (!empty($rowData[0][0])) {
								$stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,number_bill) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
								$stmt_user_add_excel->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date,  '', 'old', 'games',$rowData[0][6]));
								$lc=new location_confirm();
								$lc->update($rowData[0][0], $rowData[0][1],'games', $rowData[0][2],1);


							}

                        }else{
                            $this->error_form2=json_encode(array('files_games_cumulative_upload'=>'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
                            break;
                        }

                    }

                    @unlink($inputFileName);
                }else
                {

                    $this->error_form2=json_encode(array('files_games_cumulative_upload'=>'يرجى اعادة رفع الملف'));
                }
                if (empty($this->error_form2))
                {

					$this->lightRedirect(url."/location_confirm/view/games");


				}


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form2=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'games','add','php'));
        $this->adminFooterController();
    }


    function delete_excel_games($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->excel_games, "`id`={$id}");
            echo 'true';
        }
    }






    public function list_excel_camera()
    {
        $this->checkPermit('list_excel_excel_camera','excel');
        $this->adminHeaderController($this->langControl('excel'));

        require ($this->render($this->folder,'camera','list','php'));
        $this->adminFooterController();

    }



    public function processing_camera()
    {
        $this->checkPermit('list_excel_excel_camera','excel');
        $table = $this->excel_camera;
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'code', 'dt' => 0 ),
            array( 'db' => 'quantity', 'dt' => 1 ),
            array( 'db' => 'price_dollars', 'dt' => 2 ),
            array( 'db' => 'price', 'dt' => 3 ),
            array( 'db' => 'range1', 'dt' => 4 ),
            array( 'db' => 'range2', 'dt' => 5 ),
            array( 'db' => 'number_bill', 'dt' => 6 ),
            array( 'db' => 'date', 'dt' =>  7,
                'formatter' => function( $d, $row ) {
                    	return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 8,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),   array(
                'db'        => 'code',
                'dt'        => 9,
                'formatter' => function($id, $row ) {

                    if ($this->checkLocation('camera',$id))
                    {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('camera',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }

                }
            ),
            array(  'db' => 'id', 'dt'=>10)


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
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )
        );

    }



    public function camera_location_set()
    {
        $this->checkPermit('list_excel','excel');
        $this->adminHeaderController($this->langControl('excel'));

        require ($this->render($this->folder,'camera','location_set','php'));
        $this->adminFooterController();

    }

    public function processing_camera_location_set()
    {
        $this->checkPermit('list_excel','excel');
        $table = 'excel_camera';
        $primaryKey = $table.'.id';
        $tableJoin = $table.'.';
        $columns = array(

            array( 'db' => $tableJoin.'code', 'dt' => 0 ),
            array( 'db' => $tableJoin.'quantity', 'dt' => 1 ),
            array( 'db' => $tableJoin.'price_dollars', 'dt' => 2 ),
            array( 'db' => $tableJoin.'price', 'dt' => 3 ),
            array( 'db' => $tableJoin.'range1', 'dt' => 4 ),
            array( 'db' => $tableJoin.'range2', 'dt' => 5 ),
            array( 'db' => $tableJoin.'number_bill', 'dt' => 6 ),
            array( 'db' => $tableJoin.'date', 'dt' =>  7,
                'formatter' => function( $d, $row ) {
                    	return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin.'id',
                'dt'        => 8,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin.'code',
                'dt'        => 9,
                'formatter' => function($id, $row ) {

                    if ($this->checkLocation('camera',$id))
                    {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('camera',$id,$row[1]) class='btn btn-success'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }

                }
            ),
            array(  'db' => $tableJoin.'id', 'dt'=>10)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );





        $join = "INNER JOIN `location` ON {$table}.code = location.code ";
        $whereAll = array("location.model='camera'");
        $group="GROUP BY {$table}.code";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll,null,$group));

    }



    public function camera_location_set_not()
    {
        $this->checkPermit('list_excel','excel');
        $this->adminHeaderController($this->langControl('excel'));

        require ($this->render($this->folder,'camera','location_set_not','php'));
        $this->adminFooterController();

    }

    public function processing_camera_location_set_not()
    {
        $this->checkPermit('list_excel','excel');
        $table = 'excel_camera';
        $tableJoin = $table.'.';
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $tableJoin.'code', 'dt' => 0 ),
            array( 'db' => $tableJoin.'quantity', 'dt' => 1 ),
            array( 'db' => $tableJoin.'price_dollars', 'dt' => 2 ),
            array( 'db' => $tableJoin.'price', 'dt' => 3 ),
            array( 'db' => $tableJoin.'range1', 'dt' => 4 ),
            array( 'db' => $tableJoin.'range2', 'dt' => 5 ),
            array( 'db' => $tableJoin.'number_bill', 'dt' => 6 ),
            array( 'db' => $tableJoin.'date', 'dt' =>  7,
                'formatter' => function( $d, $row ) {
                    	return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin.'id',
                'dt'        => 8,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin.'code',
                'dt'        => 9,
                'formatter' => function($id, $row ) {

                    if ($this->checkLocation('camera',$id))
                    {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('camera',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }

                }
            ),
            array(  'db' => $tableJoin.'id', 'dt'=>10)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = "LEFT JOIN location ON {$table}.code = location.code  LEFT JOIN code_camera ON excel_camera.code=code_camera.code ";
        $whereAll = array('location.code Is NULL' , "code_camera.location <> ''");

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll));


        // SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )

    }




    function  add_camera()
    {
        $this->checkPermit('add_camera','excel');
        $this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'excel','add_camera');

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

					$stmtCopy=$this->db->prepare("INSERT INTO excel_camera_archives SELECT *  FROM `excel_camera`");
					$stmtCopy->execute();
					if ($stmtCopy->rowCount() > 0 || true ) {
						$stmt = $this->db->prepare("DELETE  FROM `excel_camera` WHERE 1");
						$stmt->execute();
						$stmt_loc = $this->db->prepare("DELETE  FROM `location_confirm` WHERE model =?");
                        $stmt_loc->execute(array('camera'));
						$date = time();
						$stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
						$stmt_date->execute(array('camera', $date));

						//  Loop through each row of the worksheet in turn

						for ($row = 1; $row <= $highestRow; $row++) {
							//  Read a row of data into an array
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
								FALSE,
								TRUE,
								TRUE);


							if (count($rowData[0]) == 6 || count($rowData[0]) == 7) {

								$stmt = $this->db->prepare("SELECT * FROM {$this->excel_camera} WHERE `code`=? ");
								$stmt->execute(array($rowData[0][0]));
								if ($stmt->rowCount() > 0) {
									continue;
								}

								if (!empty($rowData[0][0])) {

									if (count($rowData[0]) == 6) {
										$stmt = $this->db->prepare("INSERT INTO  excel_camera  (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date,$this->userid,$this->date_archives));
									} else {

										$stmt = $this->db->prepare("INSERT INTO  excel_camera   (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`number_bill`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives));

									}

								}


								if (!empty($rowData[0][0])) {
									$stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,number_bill) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
									$stmt_user_add_excel->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date,  '', 'new', 'camera',$rowData[0][6]));
									$lc=new location_confirm();
									$lc->update($rowData[0][0], $rowData[0][1],'camera', $rowData[0][2]);

								}

							} else {
								$this->error_form = json_encode(array('files_normal' => 'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
								break;
							}

						}

						@unlink($inputFileName);
					}
                }else
                {

                    $this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
                }

				$this->lightRedirect(url."/location_confirm/view/camera");



			} catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'camera','add','php'));
        $this->adminFooterController();
    }



    function  camera_cumulative_upload( )
    {
        $this->checkPermit('camera_cumulative_upload','excel');
        $this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'excel','camera_cumulative_upload');

        if(isset($_POST["submit"])) {


            try {
                $form = new  Form();

                $form->post('files_camera_cumulative_upload')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $name_file=json_decode($data['files_camera_cumulative_upload'],true);

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

                    $date=time();
                    $stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
                    $stmt_date->execute(array('camera',$date));

                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
							FALSE,
                            TRUE,
                            TRUE);


                        if (count($rowData[0]) ==6  || count($rowData[0]) ==7)
                        {

                            $stmt = $this->db->prepare("SELECT * FROM {$this->excel_camera} WHERE `code`=? ");
                            $stmt->execute(array($rowData[0][0]));
                            if($stmt->rowCount()>0)
                            {
                                if (!empty($rowData[0][0])) {

                                    if (count($rowData[0]) ==6)
                                    {
                                        $stmt = $this->db->prepare("UPDATE  excel_camera SET `quantity`=quantity + ? ,`price_dollars`=? ,  `price` =?,`range1` = ?,`range2`= ? ,  `date` = ?,`userid`=?,`date_archives`=?  WHERE `code`= ?  ");
                                        $stmt->execute(array($rowData[0][1] , $rowData[0][2], $rowData[0][3], $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date,$this->userid,$this->date_archives, $rowData[0][0]));
                                    }else
                                    {
                                        $stmt = $this->db->prepare("UPDATE excel_camera SET `quantity`=quantity + ? ,`price_dollars`=? ,  `price` =?,`range1` = ?,`range2`= ? ,`number_bill`= ? ,  `date` = ? ,`userid`=?,`date_archives`=? WHERE `code`= ?  ");
                                        $stmt->execute(array($rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives, $rowData[0][0]));


                                    }

                                }
                            }else
                            {
                                if (!empty($rowData[0][0])) {

                                    if (count($rowData[0]) ==6) {
                                        $stmt = $this->db->prepare("INSERT INTO excel_camera (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?)");
                                        $stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3], $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date,$this->userid,$this->date_archives));
                                    }else
                                    {
                                        $stmt = $this->db->prepare("INSERT INTO excel_camera  (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`number_bill`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?,?)");
                                        $stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives));


                                    }

                                }
                            }

							if (!empty($rowData[0][0])) {
								$stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,number_bill) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
								$stmt_user_add_excel->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date,  '', 'old', 'camera',$rowData[0][6]));

								$lc=new location_confirm();
								$lc->update($rowData[0][0], $rowData[0][1],'camera', $rowData[0][2],1);

							}

                        }else{
                            $this->error_form2=json_encode(array('files_camera_cumulative_upload'=>'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
                            break;
                        }

                    }

                    @unlink($inputFileName);
                }else
                {

                    $this->error_form2=json_encode(array('files_camera_cumulative_upload'=>'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form2))
                {
					$this->lightRedirect(url."/location_confirm/view/camera");
                }



            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form2=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'camera','add','php'));
        $this->adminFooterController();
    }








    function delete_excel_camera($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->excel_camera, "`id`={$id}");
            echo 'true';
        }
    }




    public function list_excel_network()
    {
        $this->checkPermit('list_excel_excel_network','excel');
        $this->adminHeaderController($this->langControl('excel'));

        require ($this->render($this->folder,'network','list','php'));
        $this->adminFooterController();

    }



    public function processing_network()
    {
        $this->checkPermit('list_excel_excel_network','excel');
        $table = $this->excel_network;
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'code', 'dt' => 0 ),
            array( 'db' => 'quantity', 'dt' => 1 ),
            array( 'db' => 'price_dollars', 'dt' => 2 ),
            array( 'db' => 'price', 'dt' => 3 ),
            array( 'db' => 'range1', 'dt' => 4 ),
            array( 'db' => 'range2', 'dt' => 5 ),
            array( 'db' => 'number_bill', 'dt' => 6 ),
            array( 'db' => 'date', 'dt' =>  7,
                'formatter' => function( $d, $row ) {
                    	return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => 'id',
                'dt'        => 8,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),   array(
                'db'        => 'code',
                'dt'        => 9,
                'formatter' => function($id, $row ) {

                    if ($this->checkLocation('network',$id))
                    {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('network',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }

                }
            ),
            array(  'db' => 'id', 'dt'=>10)


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
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )
        );

    }



    public function network_location_set()
    {
        $this->checkPermit('list_excel','excel');
        $this->adminHeaderController($this->langControl('excel'));

        require ($this->render($this->folder,'network','location_set','php'));
        $this->adminFooterController();

    }

    public function processing_network_location_set()
    {
        $this->checkPermit('list_excel','excel');
        $table = 'excel_network';
        $tableJoin = $table.'.';
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $tableJoin.'code', 'dt' => 0 ),
            array( 'db' => $tableJoin.'quantity', 'dt' => 1 ),
            array( 'db' => $tableJoin.'price_dollars', 'dt' => 2 ),
            array( 'db' => $tableJoin.'price', 'dt' => 3 ),
            array( 'db' => $tableJoin.'range1', 'dt' => 4 ),
            array( 'db' => $tableJoin.'range2', 'dt' => 5 ),
            array( 'db' => $tableJoin.'number_bill', 'dt' => 6 ),
            array( 'db' => $tableJoin.'date', 'dt' =>  7,
                'formatter' => function( $d, $row ) {
                    	return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin.'id',
                'dt'        => 8,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin.'code',
                'dt'        => 9,
                'formatter' => function($id, $row ) {

                    if ($this->checkLocation('network',$id))
                    {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('network',$id,$row[1]) class='btn btn-success'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }

                }
            ),
            array(  'db' => $tableJoin.'id', 'dt'=>10)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "INNER JOIN `location` ON {$table}.code = location.code ";
        $whereAll = array("location.model='network'");
        $group="GROUP BY {$table}.code";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll,null,$group));


    }



    public function network_location_set_not()
    {
        $this->checkPermit('list_excel','excel');
        $this->adminHeaderController($this->langControl('excel'));

        require ($this->render($this->folder,'network','location_set_not','php'));
        $this->adminFooterController();

    }

    public function processing_network_location_set_not()
    {
        $this->checkPermit('list_excel','excel');
        $table = 'excel_network';
        $tableJoin = $table.'.';
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $tableJoin.'code', 'dt' => 0 ),
            array( 'db' => $tableJoin.'quantity', 'dt' => 1 ),
            array( 'db' => $tableJoin.'price_dollars', 'dt' => 2 ),
            array( 'db' => $tableJoin.'price', 'dt' => 3 ),
            array( 'db' => $tableJoin.'range1', 'dt' => 4 ),
            array( 'db' => $tableJoin.'range2', 'dt' => 5 ),
            array( 'db' => $tableJoin.'number_bill', 'dt' => 6 ),
            array( 'db' => $tableJoin.'date', 'dt' =>  7,
                'formatter' => function( $d, $row ) {
                    	return date( 'Y-m-d h:i A', $d);
                }
            ),

            array(
                'db'        => $tableJoin.'id',
                'dt'        => 8,
                'formatter' => function($id, $row ) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    }
                    else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),
            array(
                'db'        => $tableJoin.'code',
                'dt'        => 9,
                'formatter' => function($id, $row ) {

                    if ($this->checkLocation('network',$id))
                    {
                        return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('network',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                    }

                }
            ),
            array(  'db' => $tableJoin.'id', 'dt'=>10)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = "LEFT JOIN location ON {$table}.code = location.code  LEFT JOIN code_network ON excel_network.code=code_network.code ";
        $whereAll = array('location.code Is NULL' , "code_network.location <> ''");

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll));


        // SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )

    }



    function  add_network()
    {
        $this->checkPermit('add_network','excel');
        $this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'excel','add_network');

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


					$stmtCopy=$this->db->prepare("INSERT INTO excel_network_archives SELECT *  FROM `excel_network`");
					$stmtCopy->execute();
					if ($stmtCopy->rowCount() > 0 || true ) {
						$stmt = $this->db->prepare("DELETE  FROM `excel_network` WHERE 1");
						$stmt->execute();
                        $stmt_loc = $this->db->prepare("DELETE  FROM `location_confirm` WHERE model =?");
                        $stmt_loc->execute(array('network'));

						$date = time();
						$stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
						$stmt_date->execute(array('network', $date));

						//  Loop through each row of the worksheet in turn

						for ($row = 1; $row <= $highestRow; $row++) {
							//  Read a row of data into an array
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
								FALSE,
								TRUE,
								TRUE);


							if (count($rowData[0]) == 6 || count($rowData[0]) == 7) {

								$stmt = $this->db->prepare("SELECT * FROM {$this->excel_network} WHERE `code`=? ");
								$stmt->execute(array($rowData[0][0]));
								if ($stmt->rowCount() > 0) {
									continue;
								}

								if (!empty($rowData[0][0])) {


									if (count($rowData[0]) == 6) {
										$stmt = $this->db->prepare("INSERT INTO  excel_network    (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date,$this->userid,$this->date_archives));
									} else {

										$stmt = $this->db->prepare("INSERT INTO  excel_network   (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`number_bill`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives));

 									}


										$stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,number_bill) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
										$stmt_user_add_excel->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date,  '', 'new', 'network',$rowData[0][6]));
									$lc=new location_confirm();
									$lc->update($rowData[0][0], $rowData[0][1],'network', $rowData[0][2]);

								}



							} else {
								$this->error_form = json_encode(array('files_normal' => 'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
								break;
							}

						}

						@unlink($inputFileName);
					}
                }else
                {

                    $this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form))
                {
					$this->lightRedirect(url."/location_confirm/view/network");

                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'network','add','php'));
        $this->adminFooterController();
    }



    function  network_cumulative_upload( )
    {
        $this->checkPermit('network_cumulative_upload','excel');
        $this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'excel','network_cumulative_upload');

        if(isset($_POST["submit"])) {


            try {
                $form = new  Form();

                $form->post('files_network_cumulative_upload')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $name_file=json_decode($data['files_network_cumulative_upload'],true);

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

                    $date=time();
                    $stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
                    $stmt_date->execute(array('network',$date));

                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
							FALSE,
                            TRUE,
                            TRUE);


                        if (count($rowData[0]) ==6  || count($rowData[0]) ==7)
                        {

                            $stmt = $this->db->prepare("SELECT * FROM {$this->excel_network} WHERE `code`=? ");
                            $stmt->execute(array($rowData[0][0]));
                            if($stmt->rowCount()>0)
                            {
                                if (!empty($rowData[0][0])) {


                                    if (count($rowData[0]) ==6)
                                    {
                                        $stmt = $this->db->prepare("UPDATE  excel_network SET `quantity`=quantity + ? ,`price_dollars`=? ,  `price` =?,`range1`=?,`range2`=?,  `date` = ? ,`userid`=?,`date_archives`=? WHERE `code`= ?  ");
                                        $stmt->execute(array($rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date,$this->userid,$this->date_archives, $rowData[0][0]));
                                    }else{

                                        $stmt = $this->db->prepare("UPDATE  excel_network SET `quantity`=quantity + ? ,`price_dollars`=? ,  `price` =?,`range1`=?,`range2`=?, `number_bill`=?,  `date` = ? ,`userid`=?,`date_archives`=? WHERE `code`= ?  ");
                                        $stmt->execute(array($rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives, $rowData[0][0]));


                                    }

                                }
                            }else
                            {
                                if (!empty($rowData[0][0])) {



                                    if (count($rowData[0]) ==6)
                                    {
                                        $stmt = $this->db->prepare("INSERT INTO excel_network (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?)");
                                        $stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3], $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date,$this->userid,$this->date_archives));
                                    }else
                                    {
                                        $stmt = $this->db->prepare("INSERT INTO excel_network (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`number_bill`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?,?)");
                                        $stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3], $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]) , $rowData[0][6], $date,$this->userid,$this->date_archives));


                                    }

                                }
                            }

							if (!empty($rowData[0][0])) {
								$stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,number_bill) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
								$stmt_user_add_excel->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date,  '', 'old', 'network',$rowData[0][6]));
								$lc=new location_confirm();
								$lc->update($rowData[0][0], $rowData[0][1],'network', $rowData[0][2],1);

							}

                        }else{
                            $this->error_form2=json_encode(array('files_network_cumulative_upload'=>'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
                            break;
                        }

                    }

                    @unlink($inputFileName);
                }else
                {

                    $this->error_form2=json_encode(array('files_network_cumulative_upload'=>'يرجى اعادة رفع الملف'));
                }
                    if (empty( $this->error_form2))
                    {
						$this->lightRedirect(url."/location_confirm/view/network");
                    }



            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form2=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'network','add','php'));
        $this->adminFooterController();
    }





    function delete_excel_network($id)
    {
        if ($this->handleLogin() ) {
            $this->AddToTraceByFunction($this->userid,'excel','delete_excel_network');

            $response = $this->db->delete($this->excel_network, "`id`={$id}");
            echo 'true';
        }
    }






    function checkLocation($model,$code,$color=null)
    {




            $table = null;
            if ($model == 'mobile') {
                $table = 'code';
            } else if ($model == 'accessories') {
                $table = 'color_accessories';
            } else if ($model == 'product_savers') {
                $table = 'product_savers';
            } else {
                $table = 'code_' . $model;
            }

            if ($color == null) {
                $stmt = $this->db->prepare("SELECT *FROM `{$table}` WHERE `code`=? AND `location` <> '' ");
                $stmt->execute(array($code));

            } else {
                $stmt = $this->db->prepare("SELECT *FROM `{$table}` WHERE `code`=? AND `color`=? AND `location` <> ''");
                $stmt->execute(array($code, $color));
            }
            if($stmt->rowCount() > 0)
            {
                return true;

            }else{
                return false;
            }


    }







    function set_location($model,$code,$quantity)
    {



        if ($this->handleLogin()) {


            $color=null;
            if (isset($_GET['color']))
            {
                $color  =$_GET['color'];
            }

            $table = null;
            if ($model == 'mobile') {
                $table = 'code';
            } else if ($model == 'accessories') {
                $table = 'color_accessories';
            } else if ($model == 'product_savers') {
                $table = 'product_savers';
            } else {
                $table = 'code_'.$model;
            }

            if ($color == null) {
                $stmt = $this->db->prepare("SELECT *FROM `location` WHERE `code`=? AND model = ? ");
                $stmt->execute(array($code,$model));

            } else {
                $stmt = $this->db->prepare("SELECT *FROM `location` WHERE `code`=? AND `color`=? AND model = ?");
                $stmt->execute(array($code, $color,$model));
            }

            $location=array();
            while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                $location[]= $row['location'];
            }

            $outLocation=array();

            if ($color == null) {

                foreach ($location as $key=>$l)
                {
                    $stmtLocation = $this->db->prepare("SELECT *FROM `location` WHERE code=? AND location= ?  AND model=? ");
                    $stmtLocation->execute(array($code, $l, $model));
                    if($stmtLocation->rowCount() > 0)
                    {
                        $rst=$stmtLocation->fetch(PDO::FETCH_ASSOC);
                        $outLocation[$key]['location']=$l;
                        $outLocation[$key]['id']=$rst['id'];
                        $outLocation[$key]['quantity']=$rst['quantity'];
                    }else{
                        $outLocation[$key]['location']=$l;
                        $outLocation[$key]['id']='x'.$key;
                        $outLocation[$key]['quantity']='';
                    }

                }


            }else{
                foreach ($location as $key=>$l)
                {
                    $stmtLocation = $this->db->prepare("SELECT *FROM `location` WHERE code=? AND location= ?  AND model=? AND color=?");
                    $stmtLocation->execute(array($code, $l, $model,$color));
                    if($stmtLocation->rowCount() > 0)
                    {
                        $rst=$stmtLocation->fetch(PDO::FETCH_ASSOC);
                        $outLocation[$key]['location']=$l;
                        $outLocation[$key]['id']=$rst['id'];
                        $outLocation[$key]['quantity']=$rst['quantity'];
                    }else{
                        $outLocation[$key]['location']=$l;
                        $outLocation[$key]['id']='x'.$key;
                        $outLocation[$key]['quantity']='';
                    }

                }

            }

                require($this->render($this->folder, 'location', 'index', 'php'));

            }

    }

     function inst_location($model,$code)
    {

        if($this->handleLogin())
        {

            $color=null;
            if (isset($_POST['color']))
            {
                $color = $_POST['color'];
            }


            $location=$_POST['setLocation'];
            $indexLocation=$_POST['indexLocation'];


            foreach ($location as $index => $cd) {
                $stmt_cd = $this->db->prepare("INSERT INTO `location` (id,quantity,location,model,code,color) VALUE (?,?,?,?,?,?)  ON DUPLICATE KEY UPDATE id=VALUES(id),code=VALUES(code),color=VALUES(color),color=VALUES(color),quantity=VALUES(quantity),model=VALUES(model)");
                $stmt_cd->execute(array($index, $cd, $indexLocation[$index],$model, $code, $color));
            }



        }

    }

    function lct($model)
	{
		if($this->handleLogin())
		{

			$code=$_POST['code'];
			$location=$_POST['location'];
			$q=0;
			if (is_numeric($_POST['q']))
			{
				$q=$_POST['q'];

			}


			if ($model == 'mobile') {
				$excel = 'excel';
			} else  {
				$excel = 'excel_'.$model;
			}

			$stmtx1 = $this->db->prepare("SELECT *FROM `{$excel}` WHERE `code`=?  ");
			$stmtx1->execute(array($code));
			if($stmtx1->rowCount() > 0) {

			$stmtx2 = $this->db->prepare("SELECT *FROM `{$excel}` WHERE `quantity` >= {$q} AND `code`=? ");
			$stmtx2->execute(array($code));
			if($stmtx2->rowCount() > 0) {


				$stmtLocation = $this->db->prepare("SELECT *FROM `location` WHERE code=? AND location= ?  AND model=? ");
				$stmtLocation->execute(array($code, $location, $model));
				if ($stmtLocation->rowCount() > 0) {
					$stmt = $this->db->prepare("UPDATE   `location` SET  quantity=? ,`date`=? WHERE code=? AND location=? AND model=?");
					$stmt->execute(array($q, time(), $code, $location, $model));
					if ($stmt->rowCount() > 0) {
						echo '1';
					}
				} else {
					$stmt = $this->db->prepare("INSERT INTO `location` (code, location,quantity, model) VALUE (?,?,?,?) ");
					$stmt->execute(array($code, $location, $q, $model));
					if ($stmt->rowCount() > 0) {
						echo '1';
					}
				}
			}else{
				echo 'q';//not found quantity
			}
			}else{
				echo 'c';//not found code
			}

		}
	}




    function lctacc($model)
	{
		if($this->handleLogin())
		{

			$code=$_POST['code'];
			$color=$_POST['color'];
			$location=$_POST['location'];
			$q=0;
			if (is_numeric($_POST['q']))
			{
				$q=$_POST['q'];

			}

			$stmtx1 = $this->db->prepare("SELECT *FROM `excel_accessories` WHERE `code`=? AND color=?");
			$stmtx1->execute(array($code,$color));
			if($stmtx1->rowCount() > 0) {

			$stmtx2 = $this->db->prepare("SELECT *FROM `excel_accessories` WHERE `quantity` >= {$q} AND `code`=? AND color=?");
			$stmtx2->execute(array($code,$color));
			if($stmtx2->rowCount() > 0) {


				$stmtLocation = $this->db->prepare("SELECT *FROM `location` WHERE code=? AND location= ?  AND model=? AND color=?");
				$stmtLocation->execute(array($code, $location, $model,$color));
				if ($stmtLocation->rowCount() > 0) {
					$stmt = $this->db->prepare("UPDATE   `location` SET  quantity=? ,`date`=? WHERE code=? AND location=? AND model=?  AND color=?");
					$stmt->execute(array($q, time(), $code, $location, $model,$color));
					if ($stmt->rowCount() > 0) {
						echo '1';
					}
				} else {
					$stmt = $this->db->prepare("INSERT INTO `location` (code, location,quantity, model,color) VALUE (?,?,?,?,?) ");
					$stmt->execute(array($code, $location, $q, $model,$color));
					if ($stmt->rowCount() > 0) {
						echo '1';
					}
				}
			}else{
				echo 'q';//not found quantity
			}
			}else{
				echo 'c';//not found code
			}

		}
	}







	public function list_excel_computer()
	{
		$this->checkPermit('list_excel_excel_computer','excel');
		$this->adminHeaderController($this->langControl('excel'));

		require ($this->render($this->folder,'computer','list','php'));
		$this->adminFooterController();

	}

	public function processing_computer()
	{
		$this->checkPermit('list_excel_excel_computer','excel');
		$table = $this->excel_computer;
		$primaryKey = 'id';

		$columns = array(

			array( 'db' => 'code', 'dt' => 0 ),
			array( 'db' => 'quantity', 'dt' => 1 ),
			array( 'db' => 'price_dollars', 'dt' => 2 ),
			array( 'db' => 'price', 'dt' => 3 ),
			array( 'db' => 'range1', 'dt' => 4 ),
			array( 'db' => 'range2', 'dt' => 5 ),
			array( 'db' => 'number_bill', 'dt' => 6 ),
			array( 'db' => 'date', 'dt' =>  7,
				'formatter' => function( $d, $row ) {
						return date( 'Y-m-d h:i A', $d);
				}
			),

			array(
				'db'        => 'id',
				'dt'        => 8,
				'formatter' => function($id, $row ) {
					if ($this->permit('delete',$this->folder)) {
						return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
					}
					else
					{
						return "لا تمتلك صلاحية";
					}
				}
			),   array(
				'db'        => 'code',
				'dt'        => 9,
				'formatter' => function($id, $row ) {

					if ($this->checkLocation('computer',$id))
					{
						return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('computer',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
					}

				}
			),
			array(  'db' => 'id', 'dt'=>10)


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
			SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )
		);

	}

	public function computer_location_set()
	{
		$this->checkPermit('list_excel','excel');
		$this->adminHeaderController($this->langControl('excel'));

		require ($this->render($this->folder,'computer','location_set','php'));
		$this->adminFooterController();

	}

	public function processing_computer_location_set()
	{
		$this->checkPermit('list_excel','excel');
		$table = 'excel_computer';
		$primaryKey = $table.'.id';
		$tableJoin = $table.'.';
		$columns = array(

			array( 'db' => $tableJoin.'code', 'dt' => 0 ),
			array( 'db' => $tableJoin.'quantity', 'dt' => 1 ),
			array( 'db' => $tableJoin.'price_dollars', 'dt' => 2 ),
			array( 'db' => $tableJoin.'price', 'dt' => 3 ),
			array( 'db' => $tableJoin.'range1', 'dt' => 4 ),
			array( 'db' => $tableJoin.'range2', 'dt' => 5 ),
			array( 'db' => $tableJoin.'number_bill', 'dt' => 6 ),
			array( 'db' => $tableJoin.'date', 'dt' =>  7,
				'formatter' => function( $d, $row ) {
						return date( 'Y-m-d h:i A', $d);
				}
			),

			array(
				'db'        => $tableJoin.'id',
				'dt'        => 8,
				'formatter' => function($id, $row ) {
					if ($this->permit('delete',$this->folder)) {
						return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
					}
					else
					{
						return "لا تمتلك صلاحية";
					}
				}
			),
			array(
				'db'        => $tableJoin.'code',
				'dt'        => 9,
				'formatter' => function($id, $row ) {

					if ($this->checkLocation('computer',$id))
					{
						return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('computer',$id,$row[1]) class='btn btn-success'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
					}

				}
			),
			array(  'db' => $tableJoin.'id', 'dt'=>10)


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);





		$join = "INNER JOIN `location` ON {$table}.code = location.code ";
		$whereAll = array("location.model='computer'");
		$group="GROUP BY {$table}.code";

		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll,null,$group));

	}


	public function computer_location_set_not()
	{
		$this->checkPermit('list_excel','excel');
		$this->adminHeaderController($this->langControl('excel'));

		require ($this->render($this->folder,'computer','location_set_not','php'));
		$this->adminFooterController();

	}

	public function processing_computer_location_set_not()
	{
		$this->checkPermit('list_excel','excel');
		$table = 'excel_computer';
		$tableJoin = $table.'.';
		$primaryKey = $table.'.id';

		$columns = array(

			array( 'db' => $tableJoin.'code', 'dt' => 0 ),
			array( 'db' => $tableJoin.'quantity', 'dt' => 1 ),
			array( 'db' => $tableJoin.'price_dollars', 'dt' => 2 ),
			array( 'db' => $tableJoin.'price', 'dt' => 3 ),
			array( 'db' => $tableJoin.'range1', 'dt' => 4 ),
			array( 'db' => $tableJoin.'range2', 'dt' => 5 ),
			array( 'db' => $tableJoin.'number_bill', 'dt' => 6 ),
			array( 'db' => $tableJoin.'date', 'dt' =>  7,
				'formatter' => function( $d, $row ) {
						return date( 'Y-m-d h:i A', $d);
				}
			),

			array(
				'db'        => $tableJoin.'id',
				'dt'        => 8,
				'formatter' => function($id, $row ) {
					if ($this->permit('delete',$this->folder)) {
						return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
					}
					else
					{
						return "لا تمتلك صلاحية";
					}
				}
			),
			array(
				'db'        => $tableJoin.'code',
				'dt'        => 9,
				'formatter' => function($id, $row ) {

					if ($this->checkLocation('computer',$id))
					{
						return "*
                   <div style='text-align: center;font-size: 23px;'>
                    <a onclick=getLocation('computer',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
					}

				}
			),
			array(  'db' => $tableJoin.'id', 'dt'=>10)


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);

		$join = "LEFT JOIN location ON {$table}.code = location.code  LEFT JOIN code_computer ON excel_computer.code=code_computer.code ";
		$whereAll = array('location.code Is NULL' , "code_computer.location <> ''");

		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll));


		// SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )

	}

	function  add_computer()
	{
		$this->checkPermit('add_computer','excel');
		$this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'excel','add_computer');     

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


					$stmtCopy=$this->db->prepare("INSERT INTO excel_computer_archives SELECT *  FROM `excel_computer`");
					$stmtCopy->execute();
					if ($stmtCopy->rowCount() > 0 || true ) {
						$stmt = $this->db->prepare("DELETE  FROM `excel_computer` WHERE 1");
						$stmt->execute();
                        $stmt_loc = $this->db->prepare("DELETE  FROM `location_confirm` WHERE model =?");
                        $stmt_loc->execute(array('computer'));
						$date = time();
						$stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
						$stmt_date->execute(array('computer', $date));

						//  Loop through each row of the worksheet in turn

						for ($row = 1; $row <= $highestRow; $row++) {
							//  Read a row of data into an array
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
								FALSE,
								TRUE,
								TRUE);


							if (count($rowData[0]) == 6 || count($rowData[0]) == 7) {

								$stmt = $this->db->prepare("SELECT * FROM {$this->excel_computer} WHERE `code`=? ");
								$stmt->execute(array($rowData[0][0]));
								if ($stmt->rowCount() > 0) {
									continue;
								}

								if (!empty($rowData[0][0])) {


									if (count($rowData[0]) == 6) {
										$stmt = $this->db->prepare("INSERT INTO  excel_computer (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date,$this->userid,$this->date_archives));
									} else {

										$stmt = $this->db->prepare("INSERT INTO  excel_computer   (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`number_bill`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives));


									}


										$stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,number_bill) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
										$stmt_user_add_excel->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date,  '', 'new', 'computer',$rowData[0][6]));
									$lc=new location_confirm();
									$lc->update($rowData[0][0], $rowData[0][1],'computer', $rowData[0][2]);

								}




							} else {
								$this->error_form = json_encode(array('files_normal' => 'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
								break;
							}

						}

						@unlink($inputFileName);
					}
				}else
				{

					$this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
				}

				$this->lightRedirect(url."/location_confirm/view/computer");


			} catch (Exception $e) {
				$data =$form -> fetch();
				$this->error_form=$e -> getMessage();

			}


		}

		require ($this->render($this->folder,'computer','add','php'));
		$this->adminFooterController();
	}

	function  computer_cumulative_upload( )
	{
		$this->checkPermit('computer_cumulative_upload','excel');
		$this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'excel','computer_cumulative_upload');

		if(isset($_POST["submit"])) {


			try {
				$form = new  Form();

				$form->post('files_computer_cumulative_upload')
					->val('is_empty', 'مطلوب')
					->val('strip_tags');


				$form->submit();
				$data = $form->fetch();
				$name_file=json_decode($data['files_computer_cumulative_upload'],true);

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

					$date=time();
					$stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
					$stmt_date->execute(array('computer',$date));

					//  Loop through each row of the worksheet in turn

					for ($row = 1; $row <= $highestRow; $row++) {
						//  Read a row of data into an array
						$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
							FALSE,
							TRUE,
							TRUE);


						if (count($rowData[0]) ==6  || count($rowData[0]) ==7)
						{

							$stmt = $this->db->prepare("SELECT * FROM {$this->excel_computer} WHERE `code`=? ");
							$stmt->execute(array($rowData[0][0]));
							if($stmt->rowCount()>0)
							{
								if (!empty($rowData[0][0])) {


									if (count($rowData[0]) ==6)
									{
										$stmt = $this->db->prepare("UPDATE excel_computer SET `quantity`=quantity + ? ,`price_dollars`=? ,  `price` =?,`range1` = ?,`range2`= ? ,  `date` = ?,`userid`=?,`date_archives`=?  WHERE `code`= ?  ");
										$stmt->execute(array($rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date,$this->userid,$this->date_archives, $rowData[0][0]));
									}else
									{
										$stmt = $this->db->prepare("UPDATE  excel_computer SET `quantity`=quantity + ? ,`price_dollars`=? ,  `price` =?,`range1` = ?,`range2`= ? ,`number_bill`= ? ,  `date` = ?,`userid`=?,`date_archives`=?   WHERE `code`= ?  ");
										$stmt->execute(array($rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives, $rowData[0][0]));


									}

								}
							}else
							{
								if (!empty($rowData[0][0])) {



									if (count($rowData[0]) ==6) {
										$stmt = $this->db->prepare("INSERT INTO excel_computer  (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date,$this->userid,$this->date_archives));
									}else
									{
										$stmt = $this->db->prepare("INSERT INTO excel_computer  (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`number_bill`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3], $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives));


									}

								}
							}


							if (!empty($rowData[0][0])) {
								$stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,number_bill) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
								$stmt_user_add_excel->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date,  '', 'old', 'computer',$rowData[0][6]));

								$lc=new location_confirm();
								$lc->update($rowData[0][0], $rowData[0][1],'computer', $rowData[0][2],1);

							}

						}else{
							$this->error_form2=json_encode(array('files_computer_cumulative_upload'=>'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
							break;
						}

					}

					@unlink($inputFileName);
				}else
				{

					$this->error_form2=json_encode(array('files_computer_cumulative_upload'=>'يرجى اعادة رفع الملف'));
				}

				if (empty($this->error_form2))
				{
					$this->lightRedirect(url."/location_confirm/view/computer");
				}



			} catch (Exception $e) {
				$data =$form -> fetch();
				$this->error_form2=$e -> getMessage();

			}


		}

		require ($this->render($this->folder,'computer','add','php'));
		$this->adminFooterController();
	}


	function delete_excel_computer($id)
	{
		if ($this->handleLogin() ) {
			$response = $this->db->delete($this->excel_computer, "`id`={$id}");
			echo 'true';
		}
	}







	public function list_excel_printing_supplies()
	{
		$this->checkPermit('list_excel_excel_printing_supplies','excel');
		$this->adminHeaderController($this->langControl('excel'));

		require ($this->render($this->folder,'printing_supplies','list','php'));
		$this->adminFooterController();

	}

	public function processing_printing_supplies()
	{
		$this->checkPermit('list_excel_excel_printing_supplies','excel');
		$table = $this->excel_printing_supplies;
		$primaryKey = 'id';

		$columns = array(

			array( 'db' => 'code', 'dt' => 0 ),
			array( 'db' => 'quantity', 'dt' => 1 ),
			array( 'db' => 'price_dollars', 'dt' => 2 ),
			array( 'db' => 'price', 'dt' => 3 ),
			array( 'db' => 'range1', 'dt' => 4 ),
			array( 'db' => 'range2', 'dt' => 5 ),
			array( 'db' => 'number_bill', 'dt' => 6 ),
			array( 'db' => 'date', 'dt' =>  7,
				'formatter' => function( $d, $row ) {
						return date( 'Y-m-d h:i A', $d);
				}
			),

			array(
				'db'        => 'id',
				'dt'        => 8,
				'formatter' => function($id, $row ) {
					if ($this->permit('delete',$this->folder)) {
						return "
<div style='text-align: center'>
	<button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
		<i class='fa fa-trash-o' aria-hidden='true'></i></i>
	</button>
</div> ";
					}
					else
					{
						return "لا تمتلك صلاحية";
					}
				}
			),   array(
				'db'        => 'code',
				'dt'        => 9,
				'formatter' => function($id, $row ) {

					if ($this->checkLocation('printing_supplies',$id))
					{
						return "*
<div style='text-align: center;font-size: 23px;'>
	<a onclick=getLocation('printing_supplies',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
</div> ";
					}

				}
			),
			array(  'db' => 'id', 'dt'=>10)


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
			SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )
		);

	}

	public function printing_supplies_location_set()
	{
		$this->checkPermit('list_excel','excel');
		$this->adminHeaderController($this->langControl('excel'));

		require ($this->render($this->folder,'printing_supplies','location_set','php'));
		$this->adminFooterController();

	}

	public function processing_printing_supplies_location_set()
	{
		$this->checkPermit('list_excel','excel');
		$table = 'excel_printing_supplies';
		$primaryKey = $table.'.id';
		$tableJoin = $table.'.';
		$columns = array(

			array( 'db' => $tableJoin.'code', 'dt' => 0 ),
			array( 'db' => $tableJoin.'quantity', 'dt' => 1 ),
			array( 'db' => $tableJoin.'price_dollars', 'dt' => 2 ),
			array( 'db' => $tableJoin.'price', 'dt' => 3 ),
			array( 'db' => $tableJoin.'range1', 'dt' => 4 ),
			array( 'db' => $tableJoin.'range2', 'dt' => 5 ),
			array( 'db' => $tableJoin.'number_bill', 'dt' => 6 ),
			array( 'db' => $tableJoin.'date', 'dt' =>  7,
				'formatter' => function( $d, $row ) {
						return date( 'Y-m-d h:i A', $d);
				}
			),

			array(
				'db'        => $tableJoin.'id',
				'dt'        => 8,
				'formatter' => function($id, $row ) {
					if ($this->permit('delete',$this->folder)) {
						return "
<div style='text-align: center'>
	<button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
		<i class='fa fa-trash-o' aria-hidden='true'></i></i>
	</button>
</div> ";
					}
					else
					{
						return "لا تمتلك صلاحية";
					}
				}
			),
			array(
				'db'        => $tableJoin.'code',
				'dt'        => 9,
				'formatter' => function($id, $row ) {

					if ($this->checkLocation('printing_supplies',$id))
					{
						return "*
<div style='text-align: center;font-size: 23px;'>
	<a onclick=getLocation('printing_supplies',$id,$row[1]) class='btn btn-success'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
</div> ";
					}

				}
			),
			array(  'db' => $tableJoin.'id', 'dt'=>10)


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);





		$join = "INNER JOIN `location` ON {$table}.code = location.code ";
		$whereAll = array("location.model='printing_supplies'");
		$group="GROUP BY {$table}.code";

		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll,null,$group));

	}


	public function printing_supplies_location_set_not()
	{
		$this->checkPermit('list_excel','excel');
		$this->adminHeaderController($this->langControl('excel'));

		require ($this->render($this->folder,'printing_supplies','location_set_not','php'));
		$this->adminFooterController();

	}

	public function processing_printing_supplies_location_set_not()
	{
		$this->checkPermit('list_excel','excel');
		$table = 'excel_printing_supplies';
		$tableJoin = $table.'.';
		$primaryKey = $table.'.id';

		$columns = array(

			array( 'db' => $tableJoin.'code', 'dt' => 0 ),
			array( 'db' => $tableJoin.'quantity', 'dt' => 1 ),
			array( 'db' => $tableJoin.'price_dollars', 'dt' => 2 ),
			array( 'db' => $tableJoin.'price', 'dt' => 3 ),
			array( 'db' => $tableJoin.'range1', 'dt' => 4 ),
			array( 'db' => $tableJoin.'range2', 'dt' => 5 ),
			array( 'db' => $tableJoin.'number_bill', 'dt' => 6 ),
			array( 'db' => $tableJoin.'date', 'dt' =>  7,
				'formatter' => function( $d, $row ) {
						return date( 'Y-m-d h:i A', $d);
				}
			),

			array(
				'db'        => $tableJoin.'id',
				'dt'        => 8,
				'formatter' => function($id, $row ) {
					if ($this->permit('delete',$this->folder)) {
						return "
<div style='text-align: center'>
	<button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
		<i class='fa fa-trash-o' aria-hidden='true'></i></i>
	</button>
</div> ";
					}
					else
					{
						return "لا تمتلك صلاحية";
					}
				}
			),
			array(
				'db'        => $tableJoin.'code',
				'dt'        => 9,
				'formatter' => function($id, $row ) {

					if ($this->checkLocation('printing_supplies',$id))
					{
						return "*
<div style='text-align: center;font-size: 23px;'>
	<a onclick=getLocation('printing_supplies',$id,$row[1]) class='btn btn-warning'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
</div> ";
					}

				}
			),
			array(  'db' => $tableJoin.'id', 'dt'=>10)


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);

		$join = "LEFT JOIN location ON {$table}.code = location.code  LEFT JOIN code_printing_supplies ON excel_printing_supplies.code=code_printing_supplies.code ";
		$whereAll = array('location.code Is NULL' , "code_printing_supplies.location <> ''");

		echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null,$whereAll));


// SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )

	}

	function  add_printing_supplies()
	{
		$this->checkPermit('add_printing_supplies','excel');
		$this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'excel','add_printing_supplies');

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


					$stmtCopy=$this->db->prepare("INSERT INTO excel_printing_supplies_archives SELECT *  FROM `excel_printing_supplies`");
					$stmtCopy->execute();
					if ($stmtCopy->rowCount() > 0 || true ) {
						$stmt = $this->db->prepare("DELETE  FROM `excel_printing_supplies` WHERE 1");
						$stmt->execute();
                        $stmt_loc = $this->db->prepare("DELETE  FROM `location_confirm` WHERE model =?");
                        $stmt_loc->execute(array('printing_supplies'));

						$date = time();
						$stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
						$stmt_date->execute(array('printing_supplies', $date));

                          //  Loop through each row of the worksheet in turn

						for ($row = 1; $row <= $highestRow; $row++) {
                         //  Read a row of data into an array
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
								FALSE,
								TRUE,
								TRUE);


							if (count($rowData[0]) == 6 || count($rowData[0]) == 7) {

								$stmt = $this->db->prepare("SELECT * FROM {$this->excel_printing_supplies} WHERE `code`=? ");
								$stmt->execute(array($rowData[0][0]));
								if ($stmt->rowCount() > 0) {
									continue;
								}

								if (!empty($rowData[0][0])) {

									if (count($rowData[0]) == 6) {
										$stmt = $this->db->prepare("INSERT INTO  excel_printing_supplies  (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date,$this->userid,$this->date_archives));
									} else {

										$stmt = $this->db->prepare("INSERT INTO  excel_printing_supplies   (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`number_bill`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives));


									}


										$stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,number_bill) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
										$stmt_user_add_excel->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date,  '', 'new', 'printing_supplies',$rowData[0][6]));

									$lc=new location_confirm();
									$lc->update($rowData[0][0], $rowData[0][1],'printing_supplies', $rowData[0][2]);

								}




							} else {
								$this->error_form = json_encode(array('files_normal' => 'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
								break;
							}

						}

						@unlink($inputFileName);
					}
				}else
				{

					$this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
				}

				$this->lightRedirect(url."/location_confirm/view/printing_supplies");


			} catch (Exception $e) {
				$data =$form -> fetch();
				$this->error_form=$e -> getMessage();

			}


		}

		require ($this->render($this->folder,'printing_supplies','add','php'));
		$this->adminFooterController();
	}

	function  printing_supplies_cumulative_upload( )
	{
		$this->checkPermit('printing_supplies_cumulative_upload','excel');
		$this->adminHeaderController($this->langControl('add'));
        $this->AddToTraceByFunction($this->userid,'excel','printing_supplies_cumulative_upload');

		if(isset($_POST["submit"])) {


			try {
				$form = new  Form();

				$form->post('files_printing_supplies_cumulative_upload')
					->val('is_empty', 'مطلوب')
					->val('strip_tags');


				$form->submit();
				$data = $form->fetch();
				$name_file=json_decode($data['files_printing_supplies_cumulative_upload'],true);

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

					$date=time();
					$stmt_date = $this->db->prepare("INSERT INTO  `date_upload` (`category`,`date`) VALUES (?,?) ");
					$stmt_date->execute(array('printing_supplies',$date));

//  Loop through each row of the worksheet in turn

					for ($row = 1; $row <= $highestRow; $row++) {
//  Read a row of data into an array
						$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
							FALSE,
							TRUE,
							TRUE);


						if (count($rowData[0]) ==6  || count($rowData[0]) ==7)
						{

							$stmt = $this->db->prepare("SELECT * FROM {$this->excel_printing_supplies} WHERE `code`=? ");
							$stmt->execute(array($rowData[0][0]));
							if($stmt->rowCount()>0)
							{
								if (!empty($rowData[0][0])) {

									if (count($rowData[0]) ==6)
									{
										$stmt = $this->db->prepare("UPDATE  excel_printing_supplies SET `quantity`=quantity + ? ,`price_dollars`=? ,  `price` =?,`range1` = ?,`range2`= ? ,  `date` = ? ,`userid`=?,`date_archives`=? WHERE `code`= ?  ");
										$stmt->execute(array($rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date,$this->userid,$this->date_archives, $rowData[0][0]));
									}else
									{
										$stmt = $this->db->prepare("UPDATE  excel_printing_supplies SET `quantity`=quantity + ? ,`price_dollars`=? ,  `price` =?,`range1` = ?,`range2`= ? ,`number_bill`= ? ,  `date` = ? ,`userid`=?,`date_archives`=? WHERE `code`= ?  ");
										$stmt->execute(array($rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives, $rowData[0][0]));


									}

								}
							}else
							{
								if (!empty($rowData[0][0])) {



									if (count($rowData[0]) ==6) {
										$stmt = $this->db->prepare("INSERT INTO excel_printing_supplies  (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $date,$this->userid,$this->date_archives));
									}else
									{
										$stmt = $this->db->prepare("INSERT INTO excel_printing_supplies  (`code`,`quantity`,`price_dollars`,`price`,`range1`,`range2`,`number_bill`,`date`,`userid`,`date_archives`) VALUES(?,?,?,?,?,?,?,?,?,?)");
										$stmt->execute(array($rowData[0][0], $rowData[0][1] , $rowData[0][2], $rowData[0][3],  $this->min_price($rowData[0][2]), $this->max_price($rowData[0][2]), $rowData[0][6], $date,$this->userid,$this->date_archives));

									}

								}
							}


							if (!empty($rowData[0][0])) {
								$stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,number_bill) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
								$stmt_user_add_excel->execute(array($rowData[0][0], $rowData[0][1], $rowData[0][2], $this->userid, $_SESSION['usernamelogin'], $date, $this->normal_date,  '', 'old', 'printing_supplies',$rowData[0][6]));

								$lc=new location_confirm();
								$lc->update($rowData[0][0], $rowData[0][1],'printing_supplies', $rowData[0][2],1);

							}



						}else{
							$this->error_form2=json_encode(array('files_printing_supplies_cumulative_upload'=>'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
							break;
						}

					}

					@unlink($inputFileName);
				}else
				{

					$this->error_form2=json_encode(array('files_printing_supplies_cumulative_upload'=>'يرجى اعادة رفع الملف'));
				}

				if (empty($this->error_form2))
				{
					$this->lightRedirect(url."/location_confirm/view/printing_supplies");

				}



			} catch (Exception $e) {
				$data =$form -> fetch();
				$this->error_form2=$e -> getMessage();

			}


		}

		require ($this->render($this->folder,'printing_supplies','add','php'));
		$this->adminFooterController();
	}


	function delete_excel_printing_supplies($id)
	{
		if ($this->handleLogin() ) {
			$response = $this->db->delete($this->excel_printing_supplies, "`id`={$id}");
			echo 'true';
		}
	}




function type_add($t)
{
	if ($t=='new')
	{
		return 'حذف واستبدال';
	}else

	{
		return 'تراكمي';
	}
}

	public function archives($model)
	{
		$this->checkPermit('archives_'.$model,'excel');
		$this->adminHeaderController($this->langControl('archives_'.$model));


		$date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;
		$number_bill=null;

		$sumCode=0;
		$sumqu=0;
		$amount=0;
		$amountD=0;

        if (isset($_GET['date']))
        {
            $date = $_GET['date'];
        }

        if (isset($_GET['todate']))
        {
            $todate = $_GET['todate'];
        }

        if (isset($_GET['number_bill']))
        {
            $number_bill=$_GET['number_bill'];
        }


		if ($date && $todate &&  $number_bill  ) {


			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);


			$stmtcode=$this->db->prepare("SELECT count(id) as count FROM uesr_add_excel WHERE number_bill=? AND   model=? AND  date BETWEEN  ? AND  ? AND code REGEXP '^[0-9]+$'");
			$stmtcode->execute(array($model,$number_bill,$from_date_stm,$to_date_stm));
			   $sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE number_bill=? AND   model=? AND  date BETWEEN  ? AND  ?   AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute(array($model,$number_bill,$from_date_stm,$to_date_stm));
			 $sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE number_bill=? AND model=? AND  date BETWEEN  ? AND  ? ");
			$stmtmony->execute(array($model,$number_bill,$from_date_stm,$to_date_stm));
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}
			}



		}
		else if ( $date  && $todate ) {


			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);


			$stmtcode=$this->db->prepare("SELECT count(id) as count FROM uesr_add_excel WHERE    model=?  AND  date BETWEEN  ? AND  ? AND code REGEXP '^[0-9]+$'");
			$stmtcode->execute(array($model,$from_date_stm,$to_date_stm));
			   $sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE        model=?  AND  date BETWEEN  ? AND  ?   AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute(array($model,$from_date_stm,$to_date_stm));
			 $sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE   model=?  AND  date BETWEEN  ? AND  ? ");
			$stmtmony->execute(array($model,$from_date_stm,$to_date_stm));
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}
			}



		}else
		{



			$stmtcode=$this->db->prepare("SELECT count(code) as count FROM uesr_add_excel WHERE model=?   AND code REGEXP '^[0-9]+$' ");
			$stmtcode->execute(array($model));
			 $sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE      model=?    AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute(array($model));
			  $sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE  model=?   ");
			$stmtmony->execute(array($model));
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}

			}



		}
		$amountD=$this->price_dollarsAdmin($amount);


		require ($this->render($this->folder,'html','archives_mobile','php'));
		$this->adminFooterController();

	}

	public function processing_archives($model,$from_date_stm=null,$to_date_stm=null,$number_bill=null)
	{




		$this->checkPermit('archives_'.$model,'excel');
		$table = 'uesr_add_excel';
		$primaryKey ='id';

		$columns = array(

			array( 'db' => 'code', 'dt' => 0 ),
			array( 'db' => 'number_bill', 'dt' => 1 ),
			array( 'db' => 'quantity', 'dt' => 2 ),
			array( 'db' => 'price', 'dt' => 3 ),
			array( 'db' => 'type', 'dt' =>  4,
				'formatter' => function( $d, $row ) {
					return $this->type_add($d);
				}
			),

			array( 'db' => 'date', 'dt' => 5,
				'formatter' => function( $d, $row ) {
					return date( 'Y-m-d h:i A', $d);
				}
			),


			array(
				'db'        => 'userid',
				'dt'        => 6,
				'formatter' => function($id, $row ) {

			 	  return $this->UserInfo($id) ;

				}
			),
			array(  'db' => 'id', 'dt'=>7)


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);


		if (!empty($from_date_stm) && !empty($to_date_stm)&& !empty($number_bill))
		{
			echo json_encode(

				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"number_bill={$number_bill} AND `date` BETWEEN {$from_date_stm} AND {$to_date_stm} AND model='{$model}' "));

		}
		else if (!empty($from_date_stm) && !empty($to_date_stm))
		{
			echo json_encode(

				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns," `date` BETWEEN {$from_date_stm} AND {$to_date_stm} AND model='{$model}' "));

		}else{
			echo json_encode(

				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"model='{$model}'" ));
		}


	}

/*
 * تم الاستغناء منه بوضيفة $model في الاعلى
 *
	public function archives_network()
	{
		$this->checkPermit('archives_network','excel');
		$this->adminHeaderController($this->langControl('excel'));


		$date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;
		$number_bill=null;

		$sumCode=0;
		$sumqu=0;
		$amount=0;
		$amountD=0;
		if (isset($_GET['date'])&&isset($_GET['todate'])&&isset($_GET['number_bill']) ) {
			$date = $_GET['date'];
			$todate = $_GET['todate'];

			$number_bill=$_GET['number_bill'];

			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);


			$stmtcode=$this->db->prepare("SELECT count(id) as count FROM uesr_add_excel WHERE number_bill=? AND   model='network' AND  date BETWEEN  ? AND  ? AND code REGEXP '^[0-9]+$'");
			$stmtcode->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE number_bill=? AND   model='network' AND  date BETWEEN  ? AND  ?   AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE number_bill=? AND model='network' AND  date BETWEEN  ? AND  ? ");
			$stmtmony->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}
			}



		}else
		{



			$stmtcode=$this->db->prepare("SELECT count(code) as count FROM uesr_add_excel WHERE model='network'  AND code REGEXP '^[0-9]+$' ");
			$stmtcode->execute();
			$sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE     model='network'   AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute();
			$sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE model='network'  ");
			$stmtmony->execute();
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}

			}



		}
		$amountD=$this->price_dollarsAdmin($amount);


		require ($this->render($this->folder,'network','archives_network','php'));
		$this->adminFooterController();

	}

	public function processing_network_archives($from_date_stm=null,$to_date_stm=null,$number_bill=null)
	{




		$this->checkPermit('archives_network','excel');
		$table = 'uesr_add_excel';
		$primaryKey ='id';

		$columns = array(

			array( 'db' => 'code', 'dt' => 0 ),
			array( 'db' => 'number_bill', 'dt' => 1 ),
			array( 'db' => 'quantity', 'dt' => 2 ),
			array( 'db' => 'price', 'dt' => 3 ),
			array( 'db' => 'type', 'dt' =>  4,
				'formatter' => function( $d, $row ) {
					return $this->type_add($d);
				}
			),

			array( 'db' => 'date', 'dt' => 5,
				'formatter' => function( $d, $row ) {
					return date( 'Y-m-d h:i A', $d);
				}
			),


			array(
				'db'        => 'userid',
				'dt'        => 6,
				'formatter' => function($id, $row ) {

					return $this->UserInfo($id) ;

				}
			),
			array(  'db' => 'id', 'dt'=>7)


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);


		if (!empty($from_date_stm) && !empty($to_date_stm)&& !empty($number_bill))
		{
			echo json_encode(

				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"number_bill={$number_bill} AND `date` BETWEEN {$from_date_stm} AND {$to_date_stm} AND model='network' "));

		}else{
			echo json_encode(

				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"model='network'" ));
		}


	}

	public function archives_games()
	{
		$this->checkPermit('archives_games','excel');
		$this->adminHeaderController($this->langControl('excel'));


		$date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;
		$number_bill=null;

		$sumCode=0;
		$sumqu=0;
		$amount=0;
		$amountD=0;
		if (isset($_GET['date'])&&isset($_GET['todate'])&&isset($_GET['number_bill']) ) {
			$date = $_GET['date'];
			$todate = $_GET['todate'];

			$number_bill=$_GET['number_bill'];

			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);


			$stmtcode=$this->db->prepare("SELECT count(id) as count FROM uesr_add_excel WHERE number_bill=? AND   model='games' AND  date BETWEEN  ? AND  ? AND code REGEXP '^[0-9]+$'");
			$stmtcode->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE number_bill=? AND   model='games' AND  date BETWEEN  ? AND  ?   AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE number_bill=? AND model='games' AND  date BETWEEN  ? AND  ? ");
			$stmtmony->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}
			}



		}else
		{



			$stmtcode=$this->db->prepare("SELECT count(code) as count FROM uesr_add_excel WHERE model='games'  AND code REGEXP '^[0-9]+$' ");
			$stmtcode->execute();
			$sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE     model='games'   AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute();
			$sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE model='games'  ");
			$stmtmony->execute();
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}

			}



		}
		$amountD=$this->price_dollarsAdmin($amount);


		require ($this->render($this->folder,'games','archives_games','php'));
		$this->adminFooterController();

	}

	public function processing_games_archives($from_date_stm=null,$to_date_stm=null,$number_bill=null)
	{




		$this->checkPermit('archives_games','excel');
		$table = 'uesr_add_excel';
		$primaryKey ='id';

		$columns = array(

			array( 'db' => 'code', 'dt' => 0 ),
			array( 'db' => 'number_bill', 'dt' => 1 ),
			array( 'db' => 'quantity', 'dt' => 2 ),
			array( 'db' => 'price', 'dt' => 3 ),
			array( 'db' => 'type', 'dt' =>  4,
				'formatter' => function( $d, $row ) {
					return $this->type_add($d);
				}
			),

			array( 'db' => 'date', 'dt' => 5,
				'formatter' => function( $d, $row ) {
					return date( 'Y-m-d h:i A', $d);
				}
			),


			array(
				'db'        => 'userid',
				'dt'        => 6,
				'formatter' => function($id, $row ) {

					return $this->UserInfo($id) ;

				}
			),
			array(  'db' => 'id', 'dt'=>7)


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);


		if (!empty($from_date_stm) && !empty($to_date_stm)&& !empty($number_bill))
		{
			echo json_encode(

				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"number_bill={$number_bill} AND `date` BETWEEN {$from_date_stm} AND {$to_date_stm} AND model='games' "));

		}else{
			echo json_encode(

				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"model='games'" ));
		}


	}

	public function archives_camera()
	{
		$this->checkPermit('archives_camera','excel');
		$this->adminHeaderController($this->langControl('excel'));


		$date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;
		$number_bill=null;

		$sumCode=0;
		$sumqu=0;
		$amount=0;
		$amountD=0;
		if (isset($_GET['date'])&&isset($_GET['todate'])&&isset($_GET['number_bill']) ) {
			$date = $_GET['date'];
			$todate = $_GET['todate'];

			$number_bill=$_GET['number_bill'];

			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);


			$stmtcode=$this->db->prepare("SELECT count(id) as count FROM uesr_add_excel WHERE number_bill=? AND   model='camera' AND  date BETWEEN  ? AND  ? AND code REGEXP '^[0-9]+$'");
			$stmtcode->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE number_bill=? AND   model='camera' AND  date BETWEEN  ? AND  ?   AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE number_bill=? AND model='camera' AND  date BETWEEN  ? AND  ? ");
			$stmtmony->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}
			}



		}else
		{



			$stmtcode=$this->db->prepare("SELECT count(code) as count FROM uesr_add_excel WHERE model='camera'  AND code REGEXP '^[0-9]+$' ");
			$stmtcode->execute();
			$sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE     model='camera'   AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute();
			$sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE model='camera'  ");
			$stmtmony->execute();
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}

			}



		}
		$amountD=$this->price_dollarsAdmin($amount);


		require ($this->render($this->folder,'camera','archives_camera','php'));
		$this->adminFooterController();

	}

	public function processing_camera_archives($from_date_stm=null,$to_date_stm=null,$number_bill=null)
	{




		$this->checkPermit('archives_camera','excel');
		$table = 'uesr_add_excel';
		$primaryKey ='id';

		$columns = array(

			array( 'db' => 'code', 'dt' => 0 ),
			array( 'db' => 'number_bill', 'dt' => 1 ),
			array( 'db' => 'quantity', 'dt' => 2 ),
			array( 'db' => 'price', 'dt' => 3 ),
			array( 'db' => 'type', 'dt' =>  4,
				'formatter' => function( $d, $row ) {
					return $this->type_add($d);
				}
			),

			array( 'db' => 'date', 'dt' => 5,
				'formatter' => function( $d, $row ) {
					return date( 'Y-m-d h:i A', $d);
				}
			),


			array(
				'db'        => 'userid',
				'dt'        => 6,
				'formatter' => function($id, $row ) {

					return $this->UserInfo($id) ;

				}
			),
			array(  'db' => 'id', 'dt'=>7)


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);


		if (!empty($from_date_stm) && !empty($to_date_stm)&& !empty($number_bill))
		{
			echo json_encode(

				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"number_bill={$number_bill} AND `date` BETWEEN {$from_date_stm} AND {$to_date_stm} AND model='camera' "));

		}else{
			echo json_encode(

				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"model='camera'" ));
		}


	}

	public function archives_computer()
	{
		$this->checkPermit('archives_computer','excel');
		$this->adminHeaderController($this->langControl('excel'));


		$date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;
		$number_bill=null;

		$sumCode=0;
		$sumqu=0;
		$amount=0;
		$amountD=0;
		if (isset($_GET['date'])&&isset($_GET['todate'])&&isset($_GET['number_bill']) ) {
			$date = $_GET['date'];
			$todate = $_GET['todate'];

			$number_bill=$_GET['number_bill'];

			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);


			$stmtcode=$this->db->prepare("SELECT count(id) as count FROM uesr_add_excel WHERE number_bill=? AND   model='computer' AND  date BETWEEN  ? AND  ? AND code REGEXP '^[0-9]+$'");
			$stmtcode->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE number_bill=? AND   model='computer' AND  date BETWEEN  ? AND  ?   AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE number_bill=? AND model='computer' AND  date BETWEEN  ? AND  ? ");
			$stmtmony->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}
			}



		}else
		{



			$stmtcode=$this->db->prepare("SELECT count(code) as count FROM uesr_add_excel WHERE model='computer'  AND code REGEXP '^[0-9]+$' ");
			$stmtcode->execute();
			$sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE     model='computer'   AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute();
			$sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE model='computer'  ");
			$stmtmony->execute();
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}

			}



		}
		$amountD=$this->price_dollarsAdmin($amount);


		require ($this->render($this->folder,'computer','archives_computer','php'));
		$this->adminFooterController();

	}

	public function processing_computer_archives($from_date_stm=null,$to_date_stm=null,$number_bill=null)
	{




		$this->checkPermit('archives_computer','excel');
		$table = 'uesr_add_excel';
		$primaryKey ='id';

		$columns = array(

			array( 'db' => 'code', 'dt' => 0 ),
			array( 'db' => 'number_bill', 'dt' => 1 ),
			array( 'db' => 'quantity', 'dt' => 2 ),
			array( 'db' => 'price', 'dt' => 3 ),
			array( 'db' => 'type', 'dt' =>  4,
				'formatter' => function( $d, $row ) {
					return $this->type_add($d);
				}
			),

			array( 'db' => 'date', 'dt' => 5,
				'formatter' => function( $d, $row ) {
					return date( 'Y-m-d h:i A', $d);
				}
			),


			array(
				'db'        => 'userid',
				'dt'        => 6,
				'formatter' => function($id, $row ) {

					return $this->UserInfo($id) ;

				}
			),
			array(  'db' => 'id', 'dt'=>7)


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);


		if (!empty($from_date_stm) && !empty($to_date_stm)&& !empty($number_bill))
		{
			echo json_encode(

				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"number_bill={$number_bill} AND `date` BETWEEN {$from_date_stm} AND {$to_date_stm} AND model='computer' "));

		}else{
			echo json_encode(

				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"model='computer'" ));
		}


	}

	public function archives_printing_supplies()
	{
		$this->checkPermit('archives_printing_supplies','excel');
		$this->adminHeaderController($this->langControl('excel'));


		$date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;
		$number_bill=null;

		$sumCode=0;
		$sumqu=0;
		$amount=0;
		$amountD=0;
		if (isset($_GET['date'])&&isset($_GET['todate'])&&isset($_GET['number_bill']) ) {
			$date = $_GET['date'];
			$todate = $_GET['todate'];

			$number_bill=$_GET['number_bill'];

			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);


			$stmtcode=$this->db->prepare("SELECT count(id) as count FROM uesr_add_excel WHERE number_bill=? AND   model='printing_supplies' AND  date BETWEEN  ? AND  ? AND code REGEXP '^[0-9]+$'");
			$stmtcode->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE number_bill=? AND   model='printing_supplies' AND  date BETWEEN  ? AND  ?   AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE number_bill=? AND model='printing_supplies' AND  date BETWEEN  ? AND  ? ");
			$stmtmony->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}
			}



		}else
		{



			$stmtcode=$this->db->prepare("SELECT count(code) as count FROM uesr_add_excel WHERE model='printing_supplies'  AND code REGEXP '^[0-9]+$' ");
			$stmtcode->execute();
			$sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE     model='printing_supplies'   AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute();
			$sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE model='printing_supplies'  ");
			$stmtmony->execute();
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}

			}



		}
		$amountD=$this->price_dollarsAdmin($amount);


		require ($this->render($this->folder,'printing_supplies','archives_printing_supplies','php'));
		$this->adminFooterController();

	}

	public function processing_printing_supplies_archives($from_date_stm=null,$to_date_stm=null,$number_bill=null)
	{




		$this->checkPermit('archives_printing_supplies','excel');
		$table = 'uesr_add_excel';
		$primaryKey ='id';

		$columns = array(

			array( 'db' => 'code', 'dt' => 0 ),
			array( 'db' => 'number_bill', 'dt' => 1 ),
			array( 'db' => 'quantity', 'dt' => 2 ),
			array( 'db' => 'price', 'dt' => 3 ),
			array( 'db' => 'type', 'dt' =>  4,
				'formatter' => function( $d, $row ) {
					return $this->type_add($d);
				}
			),

			array( 'db' => 'date', 'dt' => 5,
				'formatter' => function( $d, $row ) {
					return date( 'Y-m-d h:i A', $d);
				}
			),


			array(
				'db'        => 'userid',
				'dt'        => 6,
				'formatter' => function($id, $row ) {

					return $this->UserInfo($id) ;

				}
			),
			array(  'db' => 'id', 'dt'=>7)


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);


		if (!empty($from_date_stm) && !empty($to_date_stm)&& !empty($number_bill))
		{
			echo json_encode(

				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"number_bill={$number_bill} AND `date` BETWEEN {$from_date_stm} AND {$to_date_stm} AND model='printing_supplies' "));

		}else{
			echo json_encode(

				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"model='printing_supplies'" ));
		}


	}

	public function  archives_accessories()
	{
		$this->checkPermit('archives_accessories','excel');
		$this->adminHeaderController($this->langControl('excel'));





		$date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;
		$number_bill=null;

		$sumCode=0;
		$sumqu=0;
		$amount=0;
		$amountD=0;


        if (isset($_GET['date']))
        {
            $date = $_GET['date'];
        }

        if (isset($_GET['todate']))
        {
            $todate = $_GET['todate'];
        }

        if (isset($_GET['number_bill']))
        {
            $number_bill=$_GET['number_bill'];
        }



        if ($date && $todate &&  $number_bill  ) {


			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);


			$stmtcode=$this->db->prepare("SELECT count(id) as count FROM uesr_add_excel WHERE number_bill=? AND   model='accessories' AND  date BETWEEN  ? AND  ? AND code REGEXP '^[0-9]+$'");
			$stmtcode->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE number_bill=? AND   model='accessories' AND  date BETWEEN  ? AND  ?   AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE number_bill=? AND model='accessories' AND  date BETWEEN  ? AND  ? ");
			$stmtmony->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}
			}



		}

      else  if ($date && $todate  ) {


			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);


			$stmtcode=$this->db->prepare("SELECT count(id) as count FROM uesr_add_excel WHERE    model='accessories' AND  date BETWEEN  ? AND  ? AND code REGEXP '^[0-9]+$'");
			$stmtcode->execute(array( $from_date_stm,$to_date_stm));
			$sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE  model='accessories' AND  date BETWEEN  ? AND  ?   AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute(array( $from_date_stm,$to_date_stm));
			$sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE model='accessories' AND  date BETWEEN  ? AND  ? ");
			$stmtmony->execute(array( $from_date_stm,$to_date_stm));
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}
			}



		}else
		{



			$stmtcode=$this->db->prepare("SELECT count(code) as count FROM uesr_add_excel WHERE model='accessories'  AND code REGEXP '^[0-9]+$' ");
			$stmtcode->execute();
			$sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE     model='accessories'   AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute();
			$sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE model='accessories'  ");
			$stmtmony->execute();
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}

			}



		}
		$amountD=$this->price_dollarsAdmin($amount);

		require ($this->render($this->folder,'accessories','archives_accessories','php'));
		$this->adminFooterController();

	}

	public function processing_archives_accessories($from_date_stm=null,$to_date_stm=null,$number_bill=null)
	{
		$this->checkPermit('archives_accessories','excel');
		$table = 'uesr_add_excel';
		$primaryKey = 'id';

		$columns = array(

			array( 'db' => 'code', 'dt' => 0 ),
			array( 'db' => 'number_bill', 'dt' => 1 ),
			array( 'db' => 'quantity', 'dt' => 2),
			array( 'db' => 'price', 'dt' => 3 ),
			array( 'db' => 'color', 'dt' => 4 ),
			array( 'db' => 'type', 'dt' =>  5,
				'formatter' => function( $d, $row ) {
					return $this->type_add($d);
				}
			),

			array( 'db' => 'date', 'dt' => 6,
				'formatter' => function( $d, $row ) {
					return date( 'Y-m-d h:i A', $d);
				}
			),


			array(
				'db'        => 'userid',
				'dt'        => 7,
				'formatter' => function($id, $row ) {


					return $this->UserInfo($id) ;


				}
			),
			array(  'db' => 'id', 'dt'=>8)


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);






		if (!empty($from_date_stm) && !empty($to_date_stm)&& !empty($number_bill))
		{
			echo json_encode(

				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"number_bill={$number_bill} AND `date` BETWEEN {$from_date_stm} AND {$to_date_stm} AND model='accessories' "));

		}else{
			echo json_encode(

				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"model='accessories'" ));
		}



	}

	public function archives_service()
	{
		$this->checkPermit('archives_service','excel');
		$this->adminHeaderController($this->langControl('excel'));







		$date=null;
		$todate=null;

		$from_date_stm=null;
		$to_date_stm=null;
		$number_bill=null;

		$sumCode=0;
		$sumqu=0;
		$amount=0;
		$amountD=0;
		if (isset($_GET['date'])&&isset($_GET['todate'])&&isset($_GET['number_bill']) ) {
			$date = $_GET['date'];
			$todate = $_GET['todate'];

			$number_bill=$_GET['number_bill'];

			$from_date_stm =   strtotime($date);
			$to_date_stm =  strtotime($todate);


			$stmtcode=$this->db->prepare("SELECT count(id) as count FROM uesr_add_excel WHERE number_bill=? AND   model='savers' AND  date BETWEEN  ? AND  ? AND code REGEXP '^[0-9]+$'");
			$stmtcode->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE number_bill=? AND   model='savers' AND  date BETWEEN  ? AND  ?   AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE number_bill=? AND model='savers' AND  date BETWEEN  ? AND  ? ");
			$stmtmony->execute(array($number_bill,$from_date_stm,$to_date_stm));
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}
			}



		}else
		{



			$stmtcode=$this->db->prepare("SELECT count(code) as count FROM uesr_add_excel WHERE model='savers'  AND code REGEXP '^[0-9]+$' ");
			$stmtcode->execute();
			$sumCode=$stmtcode->fetch(PDO::FETCH_ASSOC)['count'];

			$stmtqq=$this->db->prepare("SELECT SUM(quantity) as sum FROM uesr_add_excel WHERE     model='savers'   AND quantity REGEXP '^[0-9]+$' ");
			$stmtqq->execute();
			$sumqu=$stmtqq->fetch(PDO::FETCH_ASSOC)['sum'];


			$stmtmony=$this->db->prepare("SELECT *FROM uesr_add_excel WHERE model='savers'  ");
			$stmtmony->execute();
			$amount=0;
			while ($row = $stmtmony->fetch(PDO::FETCH_ASSOC)){
				if(is_numeric(trim($row['price'])))
				{
					$s=(int)$row['quantity']*(double)trim($row['price']);
					$amount=(int)$amount+(int)$s ;
				}

			}



		}
		$amountD=$this->price_dollarsAdmin($amount);


		require ($this->render($this->folder,'service','archives_service','php'));
		$this->adminFooterController();

	}

	public function processing_archives_service($from_date_stm=null,$to_date_stm=null,$number_bill=null)
	{


		$this->checkPermit('archives_service','excel');
		$table = 'uesr_add_excel';
		$primaryKey = 'id';

		$columns = array(

			array( 'db' => 'code', 'dt' => 0 ),
			array( 'db' => 'number_bill', 'dt' => 1 ),
			array( 'db' => 'quantity', 'dt' => 2 ),
			array( 'db' => 'price', 'dt' => 3 ),
			array( 'db' => 'type', 'dt' =>  4,
				'formatter' => function( $d, $row ) {
					return $this->type_add($d);
				}
			),

			array( 'db' => 'date', 'dt' => 5,
				'formatter' => function( $d, $row ) {
					return date( 'Y-m-d h:i A', $d);
				}
			),


			array(
				'db'        => 'userid',
				'dt'        => 6,
				'formatter' => function($id, $row ) {


					return $this->UserInfo($id) ;


				}
			),
			array(  'db' => 'id', 'dt'=>7)


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db'   => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);





		if (!empty($from_date_stm) && !empty($to_date_stm)&& !empty($number_bill))
		{
			echo json_encode(

				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"number_bill={$number_bill} AND `date` BETWEEN {$from_date_stm} AND {$to_date_stm} AND model='savers' "));

		}else{
			echo json_encode(

				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"model='savers'" ));
		}

 


	}

*/


}