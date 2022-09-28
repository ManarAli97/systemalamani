<?php

class Home extends Controller
{



    function __construct()
    {
        parent::__construct();

    }



    function cart_shop_active()
    {

      // $stmt=$this->db->prepare("SELECT crystal_bill, number_bill  FROM crystal_bill GROUP BY number_bill    ");
        $stmt=$this->db->prepare("SELECT crystal_bill.crystal_bill, crystal_bill.number_bill  FROM `crystal_bill` LEFT JOIN cart_shop_active  ON cart_shop_active.crystal_bill = crystal_bill.crystal_bill WHERE cart_shop_active.crystal_bill IS NULL GROUP BY crystal_bill.number_bill    ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

            $stmtup=$this->db->prepare("UPDATE  cart_shop_active SET  crystal_bill =? WHERE number_bill=?");
            $stmtup->execute(array($row['crystal_bill'],$row['number_bill']));
            if ($stmtup->rowCount() > 0 )
            {
                echo $row['crystal_bill'] .' ******'.  $row['number_bill'] . '<br>';

            }
        }
    }



    function cart_shop_group()
    {

        $stmt=$this->db->prepare("SELECT `number`, number_bill  FROM group_bill GROUP BY number_bill    ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

            $stmtup=$this->db->prepare("UPDATE  cart_shop_active SET  group_bill =? WHERE number_bill=?");
            $stmtup->execute(array($row['number'],$row['number_bill']));
            if ($stmtup->rowCount() > 0 )
            {
                echo $row['number'] .' ******'.  $row['number_bill'] . '<br>';

            }
        }
    }



    function index()
    {



        $this->checkPermit('inter_to_Control','home_control');
        $this->adminHeaderController($this->langControl('home_control'));


        $stmt=$this->db->prepare("SELECT `date_accountant`,`dollar_exchange` FROM `cart_shop_active` WHERE `buy`=2 ORDER BY `date_accountant` DESC LIMIT 1 ");
        $stmt->execute();
        $lastDay=$stmt->fetch(PDO::FETCH_ASSOC)['date_accountant'];


        $day=array(strtotime(date('Y-m-d',$lastDay)));
        for($i=1 ; $i<=6 ;$i++)
        {
            $day[]= strtotime("-{$i} day", strtotime(date('Y-m-d',$lastDay)));
        }

        $data=array();
        foreach ($day as $key => $d)
        {
            $data[date('Y-m-d',$d)]=array();

            $stmt_done = $this->db->prepare("SELECT   SUM(`number`) as num ,`dollar_exchange` FROM `cart_shop_active` WHERE    `accountant`=1 AND  cancel=0  AND  ( `date_accountant`  between  ? AND  ? )");
            $stmt_done->execute(array($d, strtotime("+1 day", strtotime(date('Y-m-d',$d)))));

            $only_done = $stmt_done->fetch(PDO::FETCH_ASSOC);
            $data[date('Y-m-d',$d)][] = $only_done['num'];

            $data[date('Y-m-d',$d)][] = date('Y-m-d',$d);
            $data[date('Y-m-d',$d)][] =date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d',$d))));


        }
        ksort(  $data);

 

        $data2=array();
        foreach ($day as $key => $d)
        {
            $data2[date('Y-m-d',$d)]=array();

            $stmt_1 = $this->db->prepare("SELECT  *FROM `cart_shop_active` WHERE     `accountant`=1 AND  cancel=0  AND   ( `date_accountant`  between  ? AND  ? )");
            $stmt_1->execute(array($d, strtotime("+1 day", strtotime(date('Y-m-d',$d)))));
            $price1=0;

            while ($row = $stmt_1->fetch(PDO::FETCH_ASSOC))
            {
                $f1 = (int)$row['number']*(int)str_replace($this->comma,'',$this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange'])) ;
                $price1=$price1+$f1;
            }

            $data2[date('Y-m-d',$d)][] = $price1;

            $data2[date('Y-m-d',$d)][] = date('Y-m-d',$d);
            $data2[date('Y-m-d',$d)][] =date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d',$d))));


        }
        ksort(  $data2);



        require ($this->render($this->folder,'html','index','php'));
        $this->adminFooterController();

    }




   function control()
    {
        $this->checkPermit('inter_to_Control','home_control');
        $this->adminHeaderController($this->langControl('home_control'));
        require ($this->render($this->folder,'html','index','php'));
        $this->adminFooterController();
    }



}