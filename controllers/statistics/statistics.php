<?php

class statistics extends Controller
{

    function __construct()
    {
        parent::__construct();
        $this->cart_shop_active = 'cart_shop_active';

    }



    function index()
    {

        $this->checkPermit('view_statistics','statistics');
        $this->adminHeaderController($this->langControl('View_category'));



		if (isset($_GET['date'])&&isset($_GET['todate']))
		{
			$date=$_GET['date'];
			$todate=$_GET['todate'];

			$fromDateStamp=strtotime($date);
			$toDateStamp=  strtotime($todate);

		}else
		{
			  $fromDateStamp=strtotime(date('Y-m-d'));
		       $toDateStamp= time();
			   $date=date('Y-m-d',$fromDateStamp);
			   $todate=date('Y-m-d',$toDateStamp);
		}



		$stmt_total_req = $this->db->prepare("SELECT  COUNT(*)  FROM `cart_shop_active` WHERE `date_req` between ? AND  ?  GROUP BY `number_bill`  ");
        $stmt_total_req->execute(array($fromDateStamp,$toDateStamp));
        $total_req=array();
        while ($row = $stmt_total_req->fetch(PDO::FETCH_ASSOC))
        {
            $total_req[]=$row;
        }


        $stmt_total_req2 = $this->db->prepare("SELECT  COUNT(*)  FROM `cart_shop_active`  WHERE `buy` = 2  AND    `date_req` between ? AND  ?   GROUP BY `number_bill`  ");
        $stmt_total_req2->execute(array($fromDateStamp,$toDateStamp));
        $total_req2=array();
        while ($row2 = $stmt_total_req2->fetch(PDO::FETCH_ASSOC))
        {
            $total_req2[]=$row2;
        }


        $stmt_total_req3 = $this->db->prepare("SELECT  COUNT(*)  FROM `cart_shop_active`  WHERE (`buy` = 3 OR cancel = 1)  AND    `date_req` between ? AND  ? GROUP BY `number_bill`  ");
        $stmt_total_req3->execute(array($fromDateStamp,$toDateStamp));
        $total_req3=array();
        while ($row3 = $stmt_total_req3->fetch(PDO::FETCH_ASSOC))
        {
            $total_req3[]=$row3;
        }


        $stmt_total_req4 = $this->db->prepare("SELECT  SUM(`number`)  AS `number` FROM `cart_shop_active`  WHERE  `buy` = 2  AND    `date_req` between ? AND  ?   GROUP BY `number_bill`  ");
        $stmt_total_req4->execute(array($fromDateStamp,$toDateStamp));
        $total_req4=array();
        while ($row4 = $stmt_total_req4->fetch(PDO::FETCH_ASSOC))
        {
            $total_req4[]=$row4;
        }

        $total_req4 = array_sum(array_map(function($item) {
            return $item['number'];
        }, $total_req4));


		$stmt_rewind = $this->db->prepare("SELECT  COUNT(*) as num FROM `review_item`  WHERE   `date` between ? AND  ?  ");
		$stmt_rewind->execute(array($fromDateStamp,$toDateStamp));
		$total_req5=0;
	    $r5=$stmt_rewind->fetch(PDO::FETCH_ASSOC);

		 $total_req5=$r5['num'];






       require ($this->render($this->folder,'html','index','php'));
        $this->adminFooterController();
    }


}