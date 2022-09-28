<?php

class trace extends Controller
{


    function __construct()
    {
        parent::__construct();
        $this->table = 'trace';
    }

    public function createTB()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `userId`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `userName`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `table` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `operation` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `oldData`  longtext COLLATE utf8_unicode_ci NOT NULL,
          `newData`  longtext COLLATE utf8_unicode_ci NOT NULL,
          `note`  longtext COLLATE utf8_unicode_ci NOT NULL,
          `lang`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
          `createDate`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `number_bill`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table));


    }

    public function list_trace()
    {
        $this->checkPermit('list_trace',$this->folder);
        $this->adminHeaderController($this->langControl('list_trace'));


        $fromdate=null;
        $todate=null;
        $username=null;
        $id_user=null;
		$fromdatestrtotime=null;
		$todatestrtotime=null;

		if (isset($_GET['username']))
		{
			$username=trim($_GET['username']);
			$id_user=$this->UserNameInfo($username);

		}

		if (isset($_GET['fromdate'])&&isset($_GET['todate']))
		{
			$fromdate=trim($_GET['fromdate']);
			$todate=trim($_GET['todate']);

		  	$fromdatestrtotime=strtotime($fromdate);

		  	$todatestrtotime=strtotime($todate);
		}

		$string='';
		if (!empty($id_user) && !empty($fromdatestrtotime) && !empty($todatestrtotime))
		{
			$string=$id_user.'/'.$fromdatestrtotime.'/'.$todatestrtotime;
 		}
		else if (!empty($id_user) && empty($fromdatestrtotime) && empty($todatestrtotime))
		{
			$string=$id_user.'/0/0';
		}
		else if (empty($id_user) && !empty($fromdatestrtotime) && !empty($todatestrtotime))
		{
			$string='0/'.$fromdatestrtotime.'/'.$todatestrtotime;
		}


		require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();

    }




    public function processing($username=null,$fromdatestrtotime=null,$todatestrtotime=null)
    {

        $table = $this->table;
		$primaryKey = $table . '.id';


        $columns = array(

            array( 'db' => $table.'.userName', 'dt' => 0 ),
            array( 'db' => $table.'.number_bill', 'dt' => 1 ),
            array( 'db' => $table.'.table', 'dt' => 2 ),
            array( 'db' => $table.'.operation', 'dt' => 3 ),
            array( 'db' => $table.'.note', 'dt' => 4 ),
            array( 'db' => $table.'.date', 'dt' =>  5 ,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i:s A', $d);
                }
            ),

            array(
                'db'        => $table.'.id',
                'dt'        => 6,
                'formatter' => function($id, $row ) {
                    if ($this->permit('details',$this->folder)) {

                    	if ($row[2]=='cart_shop_active')
						{
						 return "
						 <div style='text-align: center;font-size: 23px;'>
						  <a href=" . url . "/" . $this->folder . "/details2/$id>  تفاصيل   </a>
						 </div>";

						}else
						{
							return "
						 <div style='text-align: center;font-size: 23px;'>
						  <a href=" . url . "/" . $this->folder . "/details/$id>  تفاصيل   </a>
						 </div>";
						}


                    }else
                    {
                        return "لا تمتلك صلاحية";
                    }
                }
            ),

            array(  'db' => $table.'.id', 'dt'=>7)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

		$join = "";

		if (!empty($username) && !empty($fromdatestrtotime) && !empty($todatestrtotime))
		{
			$whereAll = array("{$table}.userId ={$username}","{$table}.date BETWEEN {$fromdatestrtotime} AND {$todatestrtotime} ");
		}
		else if (!empty($username) && empty($fromdatestrtotime) && empty($todatestrtotime))
		{
			$whereAll = array("{$table}.userId ={$username}");

		}
		else if (empty($username) && !empty($fromdatestrtotime) && !empty($todatestrtotime))
		{
			 $whereAll = array("{$table}.date BETWEEN {$fromdatestrtotime} AND {$todatestrtotime} ");

		}else
		{
			$whereAll = array("");
		}

		//$group="GROUP BY  {$table}.number_bill";

		echo json_encode(
			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns,'',null,$whereAll,'',''));

    }


    public function details($id)
    {
        $this->checkPermit('details',$this->folder);
        $this->adminHeaderController($this->langControl('details'));

        $stmt=$this->db->prepare("SELECT  *FROM `trace` WHERE `id`  = ? " );
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);


        $oldData=json_decode($result['oldData']);

        $newData=json_decode($result['newData']);


        require($this->render($this->folder, 'html', 'index', 'php'));
        $this->adminFooterController();

    }


    public function details2($id)
    {
        $this->checkPermit('details',$this->folder);
        $this->adminHeaderController($this->langControl('details'));

        $stmt=$this->db->prepare("SELECT  *FROM `trace` WHERE `id`  = ? " );
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);


        $stmt2=$this->db->prepare("SELECT   *  FROM `trace` WHERE `number_bill`  = ? " );
        $stmt2->execute(array($result['number_bill']));
        $data=array();

        while ($row=$stmt2->fetch(PDO::FETCH_ASSOC))
		{
			$row['old_Data']=json_decode($row['oldData'],true);
			$row['new_Data']=json_decode($row['newData'],true);
			$row['oldFilter_Data']=array();
			$row['newFilter_Data']=array();
			$row['sumBillOld']=0;
			$row['sumBillNew']=0;

			$priceOld=0;
			$xpOld=0;
			foreach ($row['old_Data'] as $old)
			{

				$table=$old['table'];
				$stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
				$stmt_get_item->execute(array($old['id_item']));
				$item = $stmt_get_item->fetch();

				$old['title']=$item['title'];
				$old['img']=$this->save_file.$old['image'];

				if (!empty($this->cuts($old['id_item'],$table)))
				{
					$old['price']=  $this->cuts($old['id_item'],$table).' د.ع ';
				}else
				{
					$old['price']= $this->price_dollarsAdmin($old['price_dollars'],$old['dollar_exchange']).' د.ع ';
				}

				if (!empty($this->cuts($old['id_item'],$old['table']))) {

					$priceO = explode('-',$this->cuts($old['id_item'], $old['table']))  ;
					$f1 = (double)trim(str_replace(',', '', $priceO[0]));
					$xpOld = $xpOld + ($f1 * $old['number']);
					$priceOld= number_format(round($xpOld));

				}else {
					$priceO =$this->price_dollarsAdmin($old['price_dollars'],$old['dollar_exchange']);
					$f1 = (int)trim(str_replace(',', '', $priceO));
					$xpOld = $xpOld + ($f1 * $old['number']);
					$priceOld= number_format($xpOld);
				}

				$row['oldFilter_Data'][]=$old;

			}
			$row['sumBillOld']=$priceOld;




			$priceNew=0;
			$xpNew=0;
			foreach ($row['new_Data'] as $new)
			{

				$table=$new['table'];
				$stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
				$stmt_get_item->execute(array($new['id_item']));
				$item = $stmt_get_item->fetch();

				$new['title']=$item['title'];
				$new['img']=$this->save_file.$new['image'];

				if (!empty($this->cuts($new['id_item'],$table)))
				{
					$new['price']=  $this->cuts($new['id_item'],$table).' د.ع ';
				}else
				{
					$new['price']= $this->price_dollarsAdmin($new['price_dollars'],$new['dollar_exchange']).' د.ع ';
				}



				if (!empty($this->cuts($new['id_item'],$new['table']))) {

					$priceN = explode('-',$this->cuts($new['id_item'], $new['table']))  ;
					$f1 = (double)trim(str_replace(',', '', $priceN[0]));
					$xpNew = $xpNew + ($f1 * $new['number']);
					$priceNew= number_format(round($xpNew));

				}else {
					$priceN =$this->price_dollarsAdmin($new['price_dollars'],$new['dollar_exchange']);
					$f1 = (int)trim(str_replace(',', '', $priceN));
					$xpNew = $xpNew + ($f1 * $new['number']);
					$priceNew= number_format($xpNew);
				}

				$row['sumBillNew']=$priceNew;
				$row['newFilter_Data'][]=$new;

			}


			$data[]=$row;
		}


        require($this->render($this->folder, 'html', 'index2', 'php'));
        $this->adminFooterController();

    }






      function  addtrace($table,$operation,$oldData=null,$newData=null,$note=null,$number_bill=null)
    {

        $stmt=$this->db->prepare("INSERT INTO `trace` (`userId`,`userName`,`table`,`operation`,`oldData`,`newData`,`note`,`date`,`createDate`,`lang`,`number_bill`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($this->userid,$_SESSION['usernamelogin'],$table,$operation,$oldData,$newData,$note,time(),date('Y-m-d h:i:s A'),$this->langControl,$number_bill));

    }



    function ifNameImage($data,$col=null)
    {


        $m=explode('.',$data);
        $x=end($m);

        if (count($m)==2 && in_array(strtolower($x), array('png', 'jpg', 'jpeg')))
        {
            return "<img width='40px' src='$this->save_file{$data}'>";
        }else
        {
            if ($col=='id_customre')
            {
                return $this->customerInfo($data);

            }else
            {
                return $data;

            }
        }


    }



}




























