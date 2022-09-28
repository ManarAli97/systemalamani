<?php

class convert extends Controller
{



    function __construct()
    {
        parent::__construct();


    }



//    public function index()
//    {
//
//
//        $idCat=63;
//        $idAcc=315;
//        $old_table='mobile';
//        $new_table='accessories';
//
//        $old_category='mobile';
//        $new_category='accessories';
//        echo '<br>';
//         echo 'id='.$idCat;
//        echo '<br>';
//
//        $stmt=$this->db->prepare("SELECT *FROM  `mobile` WHERE  `id_cat`=?" );
//        $stmt->execute(array($idCat));
//        $id_mobile=array();
//
//        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
//        {
//            $id_mobile[]=$row['id'];
//        }
//
//print_r($id_mobile);
//echo '<br>';
//
//        echo 'نقل الايتمات'.'<br>';
//       foreach ($id_mobile as $key=> $copyitem)
//       {
//           $stmt2=$this->db->prepare("SELECT *FROM  `mobile` WHERE  `id`=?" );
//           $stmt2->execute(array($copyitem));
//           $result=$stmt2->fetch(PDO::FETCH_ASSOC);
//
//           $stmt3=$this->db->prepare("INSERT INTO  `accessories` (`title`,`content`,`id_cat`,`img`,`view`,`active`,`date`,`bast_it`,`old_table`,`old_id`)  VALUES (?,?,?,?,?,?,?,?,?,?)  " );
//           $stmt3->execute(array($result['title'],$result['content'],$idAcc,$result['img'],$result['view'],$result['active'],$result['date'],$result['bast_it'],$old_table,$copyitem));
//            if ($stmt3->rowCount()>0)
//            {
//                echo ($key+1).'<br>';
//            }
//
//       }
//
//       $color=array();
//       foreach ($id_mobile as $key=> $copyitem) {
//           $stmt_color = $this->db->prepare("SELECT *FROM   `color` WHERE  `id_item`=?");
//           $stmt_color->execute(array($copyitem));
//           while ($row = $stmt_color->fetch(PDO::FETCH_ASSOC))
//           {
//               $stmt_code = $this->db->prepare("SELECT `code` FROM   `code` WHERE  `id_color`=?");
//               $stmt_code->execute(array($row['id']));
//               $row['code']=$stmt_code->fetch(PDO::FETCH_ASSOC)['code'];
//               $color[]=$row;
//           }
//
//        }
//        echo  '<br><br><br><br>';
//        echo 'نقل الالوان'.'<br>';
//
//       foreach ($color as $key=> $in_color)
//       {
//           $stmt_acc=$this->db->prepare("SELECT *FROM  `accessories` WHERE  `old_id`=?" );
//           $stmt_acc->execute(array($in_color['id_item']));
//           $result_acc_id=$stmt_acc->fetch(PDO::FETCH_ASSOC);
//
//
//           $stmt3=$this->db->prepare("INSERT INTO   `color_accessories` (`code`,`color`,`code_color`,`id_item`,`img`,`date`,`old_table`)  VALUES (?,?,?,?,?,?,?)  " );
//           $stmt3->execute(array($in_color['code'],$in_color['color'],$in_color['code_color'],$result_acc_id['id'],$in_color['img'],$in_color['date'],$old_table));
//            if ($stmt3->rowCount()>0)
//            {
//                echo ($key+1).'<br>';
//            }
//
//       }
//
//        echo  '<br><br><br><br>';
//        echo ' تعديل السلة  '.'<br>';
//        foreach ($id_mobile as $key=> $copyitem) {
//            $stmt_acc_cart = $this->db->prepare("SELECT `id` FROM    `accessories` WHERE  `old_id`=?");
//            $stmt_acc_cart->execute(array($copyitem));
//            $result_xx=$stmt_acc_cart->fetch(PDO::FETCH_ASSOC);
//
//
//            $stmt_cart=$this->db->prepare("UPDATE `cart_shop_active` SET `id_item` =? ,`table`=? WHERE `id_item`=? AND `table`=?");
//            $stmt_cart->execute(array($result_xx['id'],$new_table,$copyitem,$old_table));
//            if ($stmt_cart->rowCount()>0)
//            {
//                echo $copyitem.'-------------'.$result_xx['id'].'<br>';
//            }
//
//        }
//
//
//
//        echo  '<br><br><br><br>';
//        echo ' تعديل التقارير  '.'<br>';
//
//        foreach ($id_mobile as $key=> $copyitem) {
//            $stmt_acc_cart = $this->db->prepare("SELECT `id` FROM    `accessories` WHERE  `old_id`=?");
//            $stmt_acc_cart->execute(array($copyitem));
//            $result_xx=$stmt_acc_cart->fetch(PDO::FETCH_ASSOC);
//
//
//
//            $stmt_cart=$this->db->prepare("UPDATE  `report_withdrawn` SET `id_product` =? ,`category`=? WHERE `id_product`=? AND `category`=?");
//            $stmt_cart->execute(array($result_xx['id'],$new_category,$copyitem,$old_category));
//            if ($stmt_cart->rowCount()>0)
//            {
//                echo $copyitem.'--------'.$result_xx['id'].'<br>'  ;
//            }
//
//        }
//
//        $shutdown=$this->db->prepare("UPDATE  `category_mobile` SET `active` =0 WHERE  `id`=? ");
//        $shutdown->execute(array($idCat));
//
//}



//  137,
//  138,
// 139,
// 140,
// 144,
//  145,
//  147,
//  150,
// 151,
//  152,
//  153,
//  191,
//  192,
//  193,

}