<?php


class withdraw_return extends Controller
{

    public $ids = array();


    function __construct()
    {
        parent::__construct();
        $this->table = 'withdraw_return';
        $this->setting = new Setting();
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `location` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `quantity` int(10) NOT NULL  DEFAULT '0' ,
          `active` int(10) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
          `userid_withdraw` int(10) NOT NULL DEFAULT '0',
          `userid_return` int(10) NOT NULL DEFAULT '0',

           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table));

    }



    function smart_prepared()
    {

       

         $number_bill=strip_tags(trim($_GET['number_bill']));
         $id=strip_tags(trim($_GET['id']));
		$this->AddToTraceByFunction($this->userid,'withdraw_return','smart_prepared/'.$number_bill.'/'.$id);

       $stmt=$this->db->prepare("SELECT  cart_shop_active.*, SUM(number) as number   FROM cart_shop_active WHERE id_member_r=? AND number_bill=? AND  accountant=1 AND  prepared=1 AND  cancel=0 AND wr_prepared=0 GROUP BY id_item,code,`table` ");
       $stmt->execute(array($id,$number_bill));
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
       {

           $number=(int)$row['number'];
           $number2=(int)$row['number'];
           $table=$row['table'];
           if ($row['table']=='product_savers')
           {
               $table='savers';
           }

           $locationFound=array();
           $locationFoundrtrim=null;
           $stmtwr=$this->db->prepare("SELECT SUM(quantity) as quantity FROM withdraw_return WHERE  code = ? AND userid_withdraw=? GROUP BY code ");
           $stmtwr->execute(array($row['code'],$row['user_direct']));
           if ($stmtwr->rowCount() > 0)
           {
               $result = $stmtwr->fetch(PDO::FETCH_ASSOC);
               $sumAllLocationwr=(int)$result['quantity'];
               if ($sumAllLocationwr > 0)
               {


                   $stmtLocation=$this->db->prepare("SELECT * FROM withdraw_return WHERE  code = ? AND quantity  > 0 AND userid_withdraw= ? ORDER BY quantity DESC ");
                   $stmtLocation->execute(array($row['code'],$row['user_direct']));
                   $location=array();
                   while ($rowLocation = $stmtLocation->fetch(PDO::FETCH_ASSOC))
                   {
                       $location[] = $rowLocation;
                   }

                   if ($location)
                   {
                       $x=0;
                       $over=0;
                       foreach ($location as $lx)
                       {

//                           if ( (int)$lx['quantity'] >= $number )
//                           {
//
//                               $stmt_location = $this->db->prepare("UPDATE   `location` SET `quantity`=quantity-? ,`date`=? , userid=?   WHERE location =? AND code = ? AND `model` = ?   LIMIT 1");
//                               $stmt_location->execute(array($number,time(),$this->userid,$lx['location'],$row['code'],$table));
//
//
//                               $stmt_withdraw_return = $this->db->prepare("UPDATE   `withdraw_return` SET `quantity`=quantity-? ,`date`=?    WHERE location =? AND code = ? AND  userid_withdraw=? LIMIT 1");
//                               $stmt_withdraw_return->execute(array($number,time(), $lx['location'],$row['code'],$row['user_direct']));
//
//
//                               $stmt_cart_shop = $this->db->prepare("UPDATE `cart_shop_active` SET    `buy` = 2 ,  `prepared` = 2 , `date_prepared`= ? , `user_direct`=?,location=? WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=?  AND `number_bill`=?  AND `accountant`=1 AND `prepared`=1 ");
//                               $stmt_cart_shop->execute(array(time(), $this->userid,$lx['location'], $row['code'], $id,$row['table'],$row['id_item'],$number_bill));
//
//                               break;
//                           }else
//

                            if ($sumAllLocationwr >= $number)
                           {

                               if ($number >=  $lx['quantity'] && $number > 0)
                               {
                                   $x=$lx['quantity'];
                               }
                               else if ($number > 0)
                               {
                                   $x = $number;
                               }

                               if ($number > 0) {

                                   $locationFound[]=$lx['location'];
                                   $stmt_location = $this->db->prepare("UPDATE   `location` SET `quantity`=quantity-? ,`date`=? , userid=?   WHERE location =? AND code = ? AND `model` = ?   LIMIT 1");
                                   $stmt_location->execute(array($x, time(), $this->userid, $lx['location'], $row['code'], $table));


                                   $stmt_withdraw_return = $this->db->prepare("UPDATE   `withdraw_return` SET `quantity`=quantity-? ,`date`=?    WHERE location =? AND code = ? AND  userid_withdraw=? LIMIT 1");
                                   $stmt_withdraw_return->execute(array($x, time(), $lx['location'], $row['code'], $row['user_direct']));


                               }
                               $number=$number - $x;

                               if ($number <=0)
                               {
                                    $locationFoundrtrim=implode(',',$locationFound);
                                   $stmt_cart_shop = $this->db->prepare("UPDATE `cart_shop_active` SET    `buy` = 2 ,  `prepared` = 2 , `date_prepared`= ? , `user_direct`=?,location=? WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=?  AND `number_bill`=?  AND `accountant`=1 AND `prepared`=1 ");
                                   $stmt_cart_shop->execute(array(time(), $this->userid,$locationFoundrtrim, $row['code'], $id,$row['table'],$row['id_item'],$number_bill));

                                   break;
                               }


                           }else
                           {



                               if ($number2 >=  $lx['quantity'] && $number2 > 0)
                               {
                                   $x=$lx['quantity'];
                               }
                               else if ($number2 > 0)
                               {
                                   $x = $number2;
                               }

                               $over=$over+$x;
                               if ($number2 > 0) {

                                   $locationFound[]=$lx['location'];
                                   $stmt_location = $this->db->prepare("UPDATE   `location` SET `quantity`=quantity-? ,`date`=? , userid=?   WHERE location =? AND code = ? AND `model` = ?   LIMIT 1");
                                   $stmt_location->execute(array($x, time(), $this->userid, $lx['location'], $row['code'], $table));


                                   $stmt_withdraw_return = $this->db->prepare("UPDATE   `withdraw_return` SET `quantity`=quantity-? ,`date`=?    WHERE location =? AND code = ? AND  userid_withdraw=? LIMIT 1");
                                   $stmt_withdraw_return->execute(array($x, time(), $lx['location'], $row['code'], $row['user_direct']));


                               }

                               echo $over;
                               if ($sumAllLocationwr  == $over )
                               {
                                   $locationFoundrtrim=implode(',',$locationFound);
                                   $stmt_cart_shop = $this->db->prepare("UPDATE `cart_shop_active` SET  wr_prepared=?,id_prepared=?,location=? WHERE `code`=? AND `id_member_r` =? AND `table` = ? AND `id_item`=?  AND `number_bill`=?  AND `accountant`=1 AND `prepared`=1 ");
                                   $stmt_cart_shop->execute(array($over,  $this->userid , $locationFoundrtrim, $row['code'], $id,$row['table'],$row['id_item'],$number_bill));

                                   break;
                               }

                               $number2=$number2 - $x;



                           }

                       }


                   }

               }

           }


           echo $number_bill;

       }

    }


    public function add_withdraw()
    {
        if ($this->handleLogin()) {

            if (isset($_POST['submit'])) {

        

                $code = strip_tags(trim($_POST['code']));
                $location = strip_tags(trim($_POST['location']));
            	$this->AddToTraceByFunction($this->userid,'withdraw_return','add_withdraw/'.$code.'/'.$location);


                $stmtconfirm = $this->db->prepare("SELECT * FROM location_model WHERE location=? ");
                $stmtconfirm->execute(array($location));
                if ($stmtconfirm->rowCount() > 0) {


                    if ($this->equl_q_location($code,$location)) {

                        $stmt_ch_code = $this->db->prepare("SELECT * FROM withdraw_return WHERE code=? AND location =? AND userid_withdraw = ?");
                        $stmt_ch_code->execute(array($code, $location, $this->userid));
                        if ($stmt_ch_code->rowCount() > 0) {

                            $stmtCode = $this->db->prepare("UPDATE  withdraw_return  SET quantity=quantity+1 ,`date` = ?,userid_withdraw=? WHERE  code=? AND location =? AND userid_withdraw = ?  ");
                            $stmtCode->execute(array(time(), $this->userid, $code, $location, $this->userid));

                            echo 'add';
                        } else {

                            $stmtCode = $this->db->prepare("INSERT INTO  withdraw_return  (code, location, quantity,  `date`, userid_withdraw) VALUES (?,?,?,?,?) ");
                            $stmtCode->execute(array($code, $location, 1, time(), $this->userid));
                            echo 'add';
                        }

                    }else{

                        echo 'over_quantity_location';
                    }



                } else {

                    echo 'location_model';
                }


            }
        }else die('does not have authorization to perform action !!!');

    }


    public function add_return()
    {
        if ($this->handleLogin()) {
            if (isset($_POST['submit'])) {

               

                $code = strip_tags(trim($_POST['code']));
                $location = strip_tags(trim($_POST['location']));
            	$this->AddToTraceByFunction($this->userid,'withdraw_return','add_return/'.$code.'/'.$location);


                $stmtconfirm = $this->db->prepare("SELECT * FROM location_model WHERE location=? ");
                $stmtconfirm->execute(array($location));
                if ($stmtconfirm->rowCount() > 0) {


                    $stmt_ch_code = $this->db->prepare("SELECT * FROM withdraw_return WHERE code=? AND location =? AND userid_withdraw = ? AND  quantity > 0");
                    $stmt_ch_code->execute(array($code, $location, $this->userid));
                    if ($stmt_ch_code->rowCount() > 0) {

                        $stmtCode = $this->db->prepare("UPDATE  withdraw_return  SET quantity=quantity-1 ,`date` = ?,userid_return=? WHERE  code=? AND location =? AND userid_withdraw = ?  ");
                        $stmtCode->execute(array(time(), $this->userid, $code, $location, $this->userid));

                        echo 'add';
                    } else {

                        echo 'not_found_code';
                    }


                } else {

                    echo 'location_model';
                }


            }
        } else die('does not have authorization to perform action !!!');

    }


    function get_location_code()
    {



        $stmt_ch_code = $this->db->prepare("SELECT * FROM withdraw_return WHERE userid_withdraw = ?   AND  quantity > 0");
        $stmt_ch_code->execute(array(  $this->userid));
        if ($stmt_ch_code->rowCount() > 0) {

            $html='<table class="table table-bordered table-striped mb-5"><thead>
              <tr>
                <th>رمز المادة</th>
                <th>الموقع</th>
                <th>الكمية المسحوبه</th>
              </tr>
            </thead><tbody>';
            while ($row = $stmt_ch_code->fetch(PDO::FETCH_ASSOC))
            {

                $html.="
               <tr>
               <td>{$row['code']}</td>
               <td>{$row['location']}</td>
               <td>{$row['quantity']}</td>
                </tr>
                ";


            }

            $html.='</tbody></table>';

        echo $html;

        }else
        {

            echo 'not_found';
        }

    }


    function equl_q_location($code,$location)
    {

        $stmtlocation= $this->db->prepare("SELECT quantity FROM location WHERE code=? AND location=? LIMIT 1");
        $stmtlocation->execute(array($code,$location));
        if ($stmtlocation->rowCount() > 0) {

            $resultlocation =  $stmtlocation->fetch(PDO::FETCH_ASSOC);

            $stmtwr = $this->db->prepare("SELECT quantity FROM withdraw_return WHERE code=? AND location=? AND userid_withdraw = ? LIMIT 1");
            $stmtwr->execute(array($code,$location,$this->userid));

            $wr =  $stmtwr->fetch(PDO::FETCH_ASSOC);
            if ((int)$resultlocation['quantity'] >= (int)$wr['quantity']+1)
            {
              return true;
            }else
            {
                return false;
            }

        }else
        {
            return false;
        }


        }

}
