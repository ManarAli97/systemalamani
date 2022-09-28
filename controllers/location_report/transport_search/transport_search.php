<?php
trait transport_search
{

	function __construct()
	{
		parent::__construct();
		$this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject

	}


	function view_transport_search(){

		if (isset($_GET['code']))
		{
		     $code=trim($_GET['code']);
		}else{
            $code=null;
		}

		$this->checkPermit('code_transport_search', $this->folder);
		$this->adminHeaderController($this->langControl('code_transport_search '));

			$id=null;
			$model=null;
			$category=null;



        $date=0;
        $todate=0;

        $from_date_stm=0;
        $to_date_stm=0;
        $id_gl=0;

        if (isset($_GET['date'])&&isset($_GET['todate'])) {

            if (!empty($_GET['date']) && !empty($_GET['todate']))
            {
                $date = $_GET['date'];
                $todate = $_GET['todate'];

                $from_date_stm =   strtotime($date);
                $to_date_stm =  strtotime($todate);

            }

        }



        if (!empty($from_date_stm) && !empty($to_date_stm))
        {
            $stmtdata = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 2 AND `code`=?  AND `date` BETWEEN ? AND  ?");
            $stmtdata->execute(array($code,$from_date_stm,$to_date_stm));
        }else
        {
            $stmtdata = $this->db->prepare("SELECT *FROM location_transport WHERE  `active` = 2 AND `code`=?  ");
            $stmtdata->execute(array($code));
        }




		$data=array();
		while ($row=$stmtdata->fetch(PDO::FETCH_ASSOC))
		{
            $table=$row['model'];


			if ($row['model']=='mobile')
			{
				$code='code';
				$color='color';

				$stmt_t= $this->db->prepare("SELECT  {$code}.location, {$color}.img,{$table}.title FROM {$code} INNER JOIN {$color} ON {$color}.id={$code}.id_color  INNER JOIN {$table} ON {$table}.id={$color}.id_item WHERE  {$code}.`code` = ?  ");
				$stmt_t->execute(array($row['code']));

			}else if ($row['model']=='accessories')

			{

				$stmt_t= $this->db->prepare("SELECT  color_accessories.location, color_accessories.img,accessories.title FROM color_accessories INNER JOIN accessories on accessories.id = color_accessories.id_item    WHERE  color_accessories.`code` = ?   ");
				$stmt_t->execute(array($row['code']));

			}else if ($row['model']=='savers')
			{
				$stmt_t= $this->db->prepare("SELECT  product_savers.location, product_savers.img,product_savers.title FROM product_savers    WHERE  product_savers.`code` = ?   ");
				$stmt_t->execute(array($row['code']));
			}else
			{

				$code='code_'.$row['model'];
				$color='color_'.$row['model'];
				$table=$row['model'];


				$stmt_t= $this->db->prepare("SELECT  {$code}.location, {$color}.img,{$table}.title FROM {$code} INNER JOIN {$color} ON {$color}.id={$code}.id_color  INNER JOIN {$table} ON {$table}.id={$color}.id_item WHERE  {$code}.`code` = ?  ");
				$stmt_t->execute(array($row['code']));

			}


            $result = $stmt_t->fetch(PDO::FETCH_ASSOC);
            $row['image'] = $result['img'];


            $stmt_all_loc = $this->db->prepare("SELECT location,quantity,new_location FROM location WHERE code=? AND `model`=?    ");
            $stmt_all_loc->execute(array($row['code'], $table));
            $row['all_location'] = array();
            while ($rowloc = $stmt_all_loc->fetch(PDO::FETCH_ASSOC)) {
                $row['all_location'][] = $rowloc['location'];
            }

            $row['title'] = $result['title'];


            $row['image'] = $result['img'];

            $row['tolocation'] = array();
            $stmt_to_location = $this->db->prepare("SELECT location,id,quantity_trans as quantity FROM location_transport_convert WHERE  `transport`=?  AND code=?  AND  model =? AND from_location=? ");
            $stmt_to_location->execute(array($row['transport'], $row['code'], $row['model'], $row['location']));
            while ($rowL = $stmt_to_location->fetch(PDO::FETCH_ASSOC)) {
                $row['tolocation'][] = $rowL;
            }

            $stmt_quantity = $this->db->prepare("SELECT SUM(quantity) as quantity FROM location_transport_convert WHERE  `transport`=?  AND code=? AND  model =?  AND from_location=?");
            $stmt_quantity->execute(array($row['transport'], $row['code'], $row['model'], $row['location']));
            $row['toquantity'] = $stmt_quantity->fetch(PDO::FETCH_ASSOC)['quantity'];

            $row['quantity'] = (int)$row['quantity'];


            $row['confirm']=$this->UserInfo($row['confirm_user']);

            $data[] = $row;
		}



		require($this->render($this->folder, 'transport_search', 'html/view', 'php'));
		$this->adminFooterController();

	}







}