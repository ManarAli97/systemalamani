<?php

class error_quantity extends Controller
{

    public $ids = array();
    function __construct()
    {
        parent::__construct();

        $this->table = 'error_quantity';
        $this->filter_location_tracking_quantity = 'filter_location_tracking_quantity';
        $this->filter_location_error_quantity = 'filter_location_error_quantity';
        $this->filter_location_error_quantity = 'filter_location_error_quantity';
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->error_quantity}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT,
          `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `quantity` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `note` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `number_bill` varchar(250) COLLATE utf8_unicode_ci  ,   
          `userid` int(11) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->filter_location_tracking_quantity}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT,
          `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `location` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `quantity` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `type` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `note` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `number_bill` varchar(250) COLLATE utf8_unicode_ci  ,   
          `userid` int(11) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->filter_location_error_quantity}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT,
          `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `location` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `quantity` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `type` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `note` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `number_bill` varchar(250) COLLATE utf8_unicode_ci  ,   
          `userid` int(11) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        return $this->db->cht(array($this->table,$this->filter_location_tracking_quantity,$this->filter_location_error_quantity));

    }




	function index()
	{


	}

	function location_confirm()
	{


		$this->checkPermit('error_quantity_location_confirm',$this->folder);
		$this->adminHeaderController($this->langControl('error_quantity_location_confirm '));


		require($this->render($this->folder, 'html', 'index', 'php'));
		$this->adminFooterController();
	}


	public function processing_location_confirm()
	{

	    $table=$this->table;
        $primaryKey='error_quantity.id';
			$columns = array(
                array('db' => $table.'.model', 'dt' => 0 ),
				array('db' => $table.'.code', 'dt' => 1),
                array('db' => $table.'.quantity', 'dt' => 2 ),
                array('db' => $table.'.note', 'dt' => 3 ) ,
                array('db' => $table.'.number_bill', 'dt' => 4 ) ,
                array('db' =>  'user.username', 'dt' => 5 ) ,
                array('db' => $table.'.date', 'dt' => 6,

					'formatter' => function( $d, $row ) {
						return   date('Y-m-d h:i:s A',$d) ;
					}

				),
                array( 'db' => $table.'.id', 'dt' => 7,
                    'formatter' => function ($id, $row) {
                        if ($row[9] == 0)
                        {
                            return '
                          <button class="btn btn-warning btn-sm " onclick="error_location_conform_correcting('.$id.')"  type="button"  >  <span>  معالجة</span>  </button>
               
                        ';
                        }else
                        {
                            return "<i class='fa fa-check-circle' style='color:green'></i>";
                        }

                    }
                ),
                array( 'db' => $table.'.id', 'dt' => 8,
                    'formatter' => function ($id, $row) {
                        $model="'{$row[0]}'";
                        $code="'{$row[1]}'";
                        if ($row[10] == 0)
                        {
                            return '
                          <button class="btn btn-warning btn-sm " onclick="error_location_conform_correcting_data('.$id.','.$model.','.$code.')"  type="button"  >  <span>  معالجة</span>  </button>
               
                        ';
                        }else
                        {
                            return "<i class='fa fa-check-circle' style='color:green'></i>";
                        }

                    }
                ),
                array('db' => $table.'.correct', 'dt' => 9 ) ,
                array('db' => $table.'.correct_data', 'dt' => 10 ) ,


			);

           // SQL server connection information
			$sql_details = array(
				'user' => DB_USER,
				'pass' => DB_PASS,
				'db' => DB_NAME,
				'host' => DB_HOST,
				'charset' => 'utf8'
			);

                $join = " inner JOIN user ON user.id = error_quantity.userid ";

                 $whereAll = array("");

                echo json_encode(
                    SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,null));

	   }



	function  location_tracking_quantity()
	{


		$this->checkPermit('filter_location_tracking_quantity',$this->folder);
		$this->adminHeaderController($this->langControl('filter_location_tracking_quantity '));


		require($this->render($this->folder, 'html', 'tracking', 'php'));
		$this->adminFooterController();
	}


	public function processing_filter_location_tracking_quantity()
	{

	    $table=$this->filter_location_tracking_quantity;
        $primaryKey=$table.'.id';
			$columns = array(
                array('db' => $table.'.model', 'dt' => 0 ),
				array('db' => $table.'.code', 'dt' => 1),
                array('db' => $table.'.location', 'dt' => 2 ),
                array('db' => $table.'.quantity', 'dt' => 3),
                array('db' => $table.'.type', 'dt' => 4 ),
                array('db' => $table.'.note', 'dt' => 5 ) ,
                array('db' => $table.'.number_bill', 'dt' => 6 ) ,
                array('db' =>  'user.username', 'dt' => 7 ) ,
                array('db' => $table.'.date', 'dt' => 8,

					'formatter' => function( $d, $row ) {
						return   date('Y-m-d h:i:s A',$d) ;
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

                $join = " inner JOIN user ON user.id = {$table}.userid ";

                 $whereAll = array("");

                echo json_encode(
                    SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,null));

	   }


	function  location_error_quantity()
	{


		$this->checkPermit('filter_location_error_quantity',$this->folder);
		$this->adminHeaderController($this->langControl('filter_location_error_quantity '));


		require($this->render($this->folder, 'html', 'error', 'php'));
		$this->adminFooterController();
	}


	public function processing_filter_location_error_quantity()
	{

	    $table=$this->filter_location_error_quantity;
        $primaryKey=$table.'.id';
			$columns = array(
                array('db' => $table.'.model', 'dt' => 0 ),
				array('db' => $table.'.code', 'dt' => 1),
                array('db' => $table.'.location', 'dt' => 2 ),
                array('db' => $table.'.quantity', 'dt' => 3),
                array('db' => $table.'.type', 'dt' => 4 ),
                array('db' => $table.'.note', 'dt' => 5 ) ,
                array('db' => $table.'.number_bill', 'dt' => 6 ) ,
                array('db' =>  'user.username', 'dt' => 7 ) ,
                array('db' => $table.'.date', 'dt' => 8,

					'formatter' => function( $d, $row ) {
						return   date('Y-m-d h:i:s A',$d) ;
					}

				),


                array( 'db' => $table.'.id', 'dt' => 9,
                    'formatter' => function ($id, $row) {

                    if ($this->permit('location_correcting_code',$this->folder)) {
                        if ($row[11] == 0) {
                            return '
                          <button class="btn btn-warning btn-sm " onclick="error_location_correcting(' . $id . ')"  type="button"  >  <span>  معالجة</span>  </button>
               
                        ';
                        } else {
                            return "<i class='fa fa-check-circle' style='color:green'></i>";
                        }
                    }



                    }
                ),


                array( 'db' => $table.'.id', 'dt' => 10,
                    'formatter' => function ($id, $row) {
                        if ($this->permit('location_correcting_data',$this->folder)) {

                            if (in_array($row[13],array('+','-'))) {

                                if ($row[12] == 0) {
                                    return '
                          <button class="btn btn-warning btn-sm " onclick="error_location_correcting_data(' . $id . ')"  type="button"  >  <span>  معالجة</span>  </button>
               
                        ';
                                } else {
                                    return "<i class='fa fa-check-circle' style='color:green'></i>";
                                }

                            }


                        }

                    }
                ),

                array('db' => $table.'.correct', 'dt' => 11 ) ,
                array('db' => $table.'.correct_data', 'dt' => 12 ) ,
                array('db' => $table.'.type', 'dt' => 13 ) ,


			);

           // SQL server connection information
			$sql_details = array(
				'user' => DB_USER,
				'pass' => DB_PASS,
				'db' => DB_NAME,
				'host' => DB_HOST,
				'charset' => 'utf8'
			);

                $join = " inner JOIN user ON user.id = {$table}.userid ";

                 $whereAll = array("");

                echo json_encode(
                    SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,null));

	   }


	   function error_location_conform_correcting($id)
       {

           $stmt=$this->db->prepare("UPDATE  error_quantity  SET  correct =1 WHERE id=?");
           $stmt->execute(array($id));
           if ($stmt->rowCount()>0)
           {
               echo $id;
           }
       }

	   function error_location_conform_correcting_data($id)
       {



            $model=trim($_GET['model']);
            $code=trim($_GET['code']);
           if ($model== 'mobile')
           {
               $excel='excel';

           }else
           {
               $excel='excel_'.$model;

           }


           $stmt= $this->db->prepare("SELECT code,quantity  as exq FROM {$excel} WHERE code=?  LIMIT 1");
           $stmt->execute(array( $code ));

           while ($row = $stmt->fetch(PDO::FETCH_ASSOC) ) {

               $row['lsmq']=0;
               $stmtLocation = $this->db->prepare("SELECT SUM(quantity) as lsmq  FROM location WHERE code=? AND model= ? ");
               $stmtLocation->execute(array($code, $model));
               if ($stmtLocation->rowCount() > 0) {

                   $qlocation=$stmtLocation->fetch(PDO::FETCH_ASSOC);
                   if ($qlocation['lsmq'] > 0)
                   {
                       $row['lsmq']= $qlocation['lsmq'];
                   }
               }



               if ($row['exq'] > $row['lsmq']) {

                   $stmtlc = $this->db->prepare("SELECT quantity FROM location_confirm WHERE code=? AND model= ? ");
                   $stmtlc->execute(array($row['code'], $model));
                   if ($stmtlc->rowCount() > 0) {
                       $clocation = $stmtlc->fetch(PDO::FETCH_ASSOC);
                       $q = (int)$row['lsmq'] + (int)$clocation['quantity'];
                       if ($row['exq'] > $q) {

                           $over = (int)$row['exq'] - $q;
                           $stmtlcu = $this->db->prepare("UPDATE location_confirm SET  quantity=quantity+{$over} ,`date`=?,userid=? WHERE code=? AND model= ? ");
                           $stmtlcu->execute(array(time(), $this->userid, $row['code'], $model));

                       }

                   } else {
                       $over = (int)$row['exq'] - (int)$row['lsmq'];
                       $stmtExcel_conform = $this->db->prepare("INSERT INTO  location_confirm (quantity,code,model,date,userid)  values (?,?,?,?,?)");
                       $stmtExcel_conform->execute(array($over, $row['code'], $model, time(), $this->userid));

                   }
               }

           }


            $stmt=$this->db->prepare("UPDATE  error_quantity  SET  correct_data =1 WHERE id=?");
           $stmt->execute(array($id));
           if ($stmt->rowCount()>0)
           {
               echo $id;
           }
       }




	   function error_location_correcting($id)
       {

           $stmt=$this->db->prepare("UPDATE  filter_location_error_quantity  SET  correct =1 WHERE id=?");
           $stmt->execute(array($id));
           if ($stmt->rowCount()>0)
           {
               echo $id;
           }
       }




	   function error_location_correcting_data($id)
       {

           $stmtlc = $this->db->prepare("SELECT * FROM filter_location_error_quantity WHERE id=? AND correct_data= 0 ");
           $stmtlc->execute(array($id));
           if ($stmtlc->rowCount() > 0) {
               $clocation = $stmtlc->fetch(PDO::FETCH_ASSOC);
               $q=$clocation['quantity'];
               if ($clocation['type']  == '+' )
               {


                   $stmtup = $this->db->prepare("UPDATE   location SET  quantity=quantity+ {$q},userid=?,`date`=?  WHERE code=? AND location=? AND model=?");
                   $stmtup->execute(array($this->userid, time()+1, $clocation['code'], $clocation['location'], $clocation['model']));
                   if ($stmtup->rowCount() > 0) {

                       $this->filter_location_tracking_quantity( $clocation['code'], $clocation['model'],  $clocation['location'], $q, ' تصحيح الخطأ في تقير متابعة اخطاء الكميات   - رقم51', '+');

                   } else {
                       $this->filter_location_error_quantity($clocation['code'], $clocation['model'],  $clocation['location'], $q, '  تصحيح الخطأ في تقير متابعة اخطاء الكميات  - رقم الخطا 51', '+');

                   }


               }
               else if ($clocation['type']  == '-' )
               {

                   $stmtup = $this->db->prepare("UPDATE   location SET  quantity=quantity- {$q},userid=?,`date`=?  WHERE code=? AND location=? AND model=?");
                   $stmtup->execute(array($this->userid, time()+1, $clocation['code'], $clocation['location'], $clocation['model']));
                   if ($stmtup->rowCount() > 0) {

                       $this->filter_location_tracking_quantity( $clocation['code'], $clocation['model'],  $clocation['location'], $q, ' تصحيح الخطأ في تقير متابعة اخطاء الكميات   - رقم52', '-');

                   } else {
                       $this->filter_location_error_quantity($clocation['code'], $clocation['model'],  $clocation['location'], $q, '  تصحيح الخطأ في تقير متابعة اخطاء الكميات  - رقم الخطا 52', '-');

                   }

               }


               $stmt = $this->db->prepare("UPDATE  filter_location_error_quantity  SET  correct_data =1 WHERE id=?");
               $stmt->execute(array($id));
               if ($stmt->rowCount() > 0) {
                   echo $id;
               }


           }
       }



}