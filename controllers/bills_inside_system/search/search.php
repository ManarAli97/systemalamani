<?php
trait search
{
    function __construct()
    {
        parent::__construct();
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject

    }


    function search_bill()
    {

        $this->checkPermit('search_bill', 'bills_inside_system');
        $this->AdminHeaderController($this->langControl('search_bill'));





        require($this->render($this->folder, 'search/html', 'index', 'php'));

        $this->AdminFooterController();
    }

    function data()
    {

        $number_bill=trim($_GET['bill']);
        $stmt = $this->db->prepare("SELECT  cart_shop_active.*,SUM(`number`)as number FROM `cart_shop_active` WHERE  `number_bill`=?   GROUP BY `id_member_r`,`id_item`,`table`,`code`,`number_bill`,price_type,id_offer  UNION SELECT  cart_shop.*,SUM(`number`)as number FROM `cart_shop` WHERE  `number_bill`=?   GROUP BY `id_member_r`,`id_item`,`table`,`code`,`number_bill`,price_type,id_offer ");
        $stmt->execute(array($number_bill,$number_bill));
        $request=array();

        $name_customer=null;
        $name_customer=null;
        $phone=null;

        $accountant=null;
        $date_accountant=null;
        $prepared=null;
        $date_prepared=null;

        $sellers=null;
        $date_sellers=null;
        $crystal_bill=null;
        $group_bill=null;
        $status_bill=null;
        $cancel_user=null;
        $why_cancel=null;
        $cancel=0;
        $edit_price=0;
        $user_edit_price=0;
        $note_prepared=null;


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

            $name_customer=$this->customerInfo($row['id_member_r']);
            $phone=$this->customerInfo($row['id_member_r'],'phone');
            if ($row['accountant'] ==1)
            {
                $accountant=$this->UserInfo($row['id_accountant_user']);
                $date_accountant= date('Y-m-d h:s:i a',$row['date_accountant']);
            }

            $note_prepared=$row['note_prepared'];

            if ($row['edit_price'] ==1 )
            {
                $edit_price=1;
                $user_edit_price=$this->UserInfo($row['user_edit_price']);
            }


            if ($row['prepared'] ==2 )
            {

                if ($row['id_prepared'])
                {
                    $prepared=$this->UserInfo($row['id_prepared']);

                }else
                {
                    $prepared=$this->UserInfo($row['user_direct']);
                }

                $date_prepared= date('Y-m-d h:s:i a',$row['date_prepared']);
            }



                if ($row['direct']  == 0  &&  $row['user_direct'] !=0  )
                {
                    $sellers=$this->UserInfo($row['user_direct']) .' + '.$this->customerInfo($row['id_member_r']);

                } else  if ($row['direct']  > 0 || $row['user_direct'] !=0  )
                {
                    $sellers=$this->UserInfo($row['user_direct']);
                }else
                {
                    $sellers=$this->customerInfo($row['id_member_r']);
                }
                $date_sellers= date('Y-m-d h:i:s a',$row['date_req']);

                $crystal_bill=$row['crystal_bill'];
                $group_bill=$row['group_bill'];

                if ($row['cancel'] ==1 )
                {
                    $cancel=1;
                    $status_bill='فاتورة ملغية';
                    $cancel_user=$this->UserInfo($row['id_accountant_user']);
                    $why_cancel=$row['why_rejected'];


                }else if ($row['accountant'] ==1 && $row['prepared'] ==2)
                {
                    $status_bill='فاتورة محاسبة ومجهزة';
                }else if ($row['accountant'] ==1)
                {
                    $status_bill='فاتورة محاسبة فقط';

                }else{
                    $status_bill='فاتورة  قيد المحاسبة والتجهيز  ';

                }



            if ($row['offers'] == 'offers') {

                $row['price'] = $this->priceDollarOffer($row['id_offer'], 4) . ' د.ع ';

            }else
            {
                if ($this->check_item_round($row['table'],$row['id_item'])) {
                    $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
                    $row['price']= $price;
                }else
                {
                    $price = $this->not_round_price($row['price_dollars'], $row['dollar_exchange']);
                    $row['price']= $price;
                }

            }

            $table=$row['table'];
            $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
            $stmt_get_item->execute(array($row['id_item']));
            $item = $stmt_get_item->fetch();
            $row['title']=$item['title'];
            $row['img']=$this->save_file.$row['image'];


            $row['color_name']=$row['name_color'];



            $request[]=$row;
        }



        /*             بسبب تجميعة العروض       */

        if ($request) {
            $requestPrint = array();
            $price1_Offer = 0;
            $price1_normal = 0;
            $xp1Offer = 0;
            $xpdOffer = 0;
            $number_typeOffer = 0;
            $sum_materialOffer = 0;
            $price_dollarsOffer = 0;


            $stmtOffer = $this->db->prepare("SELECT  cart_shop_active.*  FROM `cart_shop_active` WHERE  `number_bill`=?  AND id_offer <> 0 AND offers = 'offers' GROUP BY  `date_offer` UNION SELECT  cart_shop.*  FROM `cart_shop` WHERE  `number_bill`=?  AND id_offer <> 0 AND offers = 'offers' GROUP BY  `date_offer`   ");
            $stmtOffer->execute(array($number_bill,$number_bill));

            while ($row = $stmtOffer->fetch(PDO::FETCH_ASSOC)) {


                if ($row['offers'] == 'offers') {

                    $row['price'] = $this->priceDollarOffer($row['id_offer'], 4) . ' د.ع ';
                    $price1_Offer = $price1_Offer + (int)str_replace($this->comma, '', $this->priceDollarOffer($row['id_offer'], 4));
                    $row['price_dollars'] = $this->priceDollarOffer($row['id_offer'], 3);

                    $row['title'] = $this->details_offer($row['id_offer'], 'title');

                    $row['img'] = $this->save_file . $this->details_offer($row['id_offer'], 'img');

                }
                $row['size'] = '';
                $row['name_color'] = '';


                $pd = explode('-', $row['price_dollars']);
                $f1d = (double)trim(str_replace(',', '.', $pd[0]));
                $xpdOffer = $xpdOffer + ($f1d * $row['number']);
                $price_dollarsOffer = $xpdOffer;
                $number_typeOffer = $number_typeOffer + 1;
                $sum_materialOffer = $sum_materialOffer + $row['number'];


                $row['color_name'] = $row['name_color'];

                $requestPrint[] = $row;
            }


            $stmtOffer = $this->db->prepare("SELECT  cart_shop_active.*,SUM(number) as number FROM `cart_shop_active` WHERE  `number_bill`=?    AND id_offer = 0  AND offers = ''  GROUP BY  `id_item`,`table`,`code`,`color`,`number_bill`,price_type UNION SELECT  cart_shop.*,SUM(number) as number FROM `cart_shop` WHERE  `number_bill`=?    AND id_offer = 0  AND offers = ''  GROUP BY  `id_item`,`table`,`code`,`color`,`number_bill`,price_type    ");
            $stmtOffer->execute(array($number_bill,$number_bill));

            while ($row = $stmtOffer->fetch(PDO::FETCH_ASSOC)) {

                $table = $row['table'];
                $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
                $stmt_get_item->execute(array($row['id_item']));
                $item = $stmt_get_item->fetch();

                $row['title'] = $item['title'];
                $row['img'] = $this->save_file . $row['image'];



                    if ($this->check_item_round($row['table'], $row['id_item'])) {
                        $price = $this->price_dollarsAdmin($row['price_dollars'], $row['dollar_exchange']);
                        $row['price'] = $price;
                    } else {
                        $price = $this->not_round_price($row['price_dollars'], $row['dollar_exchange']);
                        $row['price'] = $price;
                    }

                    $f1 = (int)trim(str_replace($this->comma, '', $price));
                    $xp1Offer = $xp1Offer + ($f1 * $row['number']);
                    $price1_normal = ($xp1Offer);



                $pd = explode('-', $row['price_dollars']);
                $f1d = (double)trim(str_replace(',', '.', $pd[0]));
                $xpdOffer = $xpdOffer + ($f1d * $row['number']);
                $price_dollarsOffer = $xpdOffer;
                $number_typeOffer = $number_typeOffer + 1;
                $sum_materialOffer = $sum_materialOffer + $row['number'];

                $row['color_name'] = $row['name_color'];

                $requestPrint[] = $row;
            }

            $price1Offer = 0;
            $price1Offer = (int)str_replace($this->comma, '', $price1_Offer) + (int)str_replace($this->comma, '', $price1_normal);


            require($this->render($this->folder, 'search/html', 'data', 'php'));

        }

        if (empty($request))
        {

            $check_account=0;
            $sum=0;
            $price1=0;
            $p1=0;
            $p2=0;
            $xp1=0;
            $xp2=0;
            $stmt = $this->db->prepare("SELECT retrieve_item.*, SUM(`number`) as number  FROM `retrieve_item` WHERE  `number_bill`=?  GROUP BY `id_item`,`table`,`code`,`number_bill`  ");
            $stmt->execute(array($number_bill));
            $deleted=array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {


                $check_account=$row['accountant'];
                $name_customer=$this->customerInfo($row['id_customer']);
                $phone=$this->customerInfo($row['id_customer'],'phone');


                    $price =$this->price_dollarsAdmin($row['price'],$row['dollar_exchange']);
                    $f1 = (int)trim(str_replace(',', '', $price));
                    $xp1 = $xp1 + ($f1 * $row['number']);
                    $price1= number_format($xp1);




                $table=$row['table'];
                $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
                $stmt_get_item->execute(array($row['id_item']));
                $item = $stmt_get_item->fetch();

                $row['title']=$item['title'];
                $row['img']=$this->save_file.$row['image'];


                $table = $row['table'];
                $stmt_get_item = $this->db->prepare("SELECT *FROM `{$table}` WHERE id = ?  LIMIT 1");
                $stmt_get_item->execute(array($row['id_item']));
                $item = $stmt_get_item->fetch();

                $row['title'] = $item['title'];
                $row['img'] = $this->save_file . $row['image'];

                 $row['price']= $this->price_dollarsAdmin($row['price'],$row['dollar_exchange']).' د.ع ';
                 $row['edit_price']=0;

                $deleted[]=$row;
            }


            if ($deleted)
            {
                require($this->render($this->folder, 'search/html', 'deleted', 'php'));

            }


        }





    }


}