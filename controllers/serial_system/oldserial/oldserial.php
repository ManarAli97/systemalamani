<?php

trait oldserial
{

    protected  $data_code=array();

    function __construct()
    {
        parent::__construct();
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject
    }



    function list_oldserial()
    {
        $this->checkPermit('oldserial',  $this->folder);
        $this->adminHeaderController($this->langControl('oldserial'));

        $number='';
        if (isset($_GET['number']))
        {
            $number=$_GET['number'];
        }

        $stmt=$this->db->prepare("SELECT normal_date FROM serial  GROUP BY normal_date");
        $stmt->execute();
        $data=array();
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $row[$row['normal_date']]=array();

            $dateEnter=strtotime($row['normal_date']);

            $stmtSerial=$this->db->prepare("SELECT * FROM serial WHERE normal_date=?  ");
            $stmtSerial->execute(array($row['normal_date']));
            while($rowSerial=$stmtSerial->fetch(PDO::FETCH_ASSOC))
            {

                $stmtCount=$this->db->prepare("SELECT date_prepared  FROM ( SELECT date_prepared  FROM cart_shop_active WHERE code=? AND prepared=2 AND cancel=0 AND enter_serial <> '' AND  date_prepared > ? ORDER BY date_prepared DESC LIMIT {$number}) t  order by date_prepared asc limit 1");
                $stmtCount->execute(array($rowSerial['code'],$dateEnter));
                if ($stmtCount->rowCount() > 0)
                {
                   $dateLastPrepared = $stmtCount->fetch(PDO::FETCH_ASSOC)['date_prepared'];
                   if ($rowSerial['date']  < $dateLastPrepared)
                  {
                      $rowSerial['dateLastPrepared']=date('Y-m-d',$dateLastPrepared);
                      $row[$row['normal_date']][]=$rowSerial;
                  }

               }

            }

            if (!empty($row[$row['normal_date']]))
            {
                $data[]=$row;
            }

        }


        require($this->render($this->folder, 'oldserial/html', 'index', 'php'));
        $this->adminFooterController();

    }


}