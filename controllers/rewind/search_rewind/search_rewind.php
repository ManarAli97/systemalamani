<?php
trait search_rewind
{
    function __construct()
    {
        parent::__construct();
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject

    }


    function search_rewind_bill()
    {

        $this->checkPermit('search_rewind_bill', $this->folder);
        $this->AdminHeaderController($this->langControl('search_rewind_bill'));





        require($this->render($this->folder, 'search_rewind/html', 'index', 'php'));

        $this->AdminFooterController();
    }

    function data()
    {

        $number_bill=trim($_GET['bill']);

        $sum =$this->sumbill($number_bill);


        $stmt_customer=$this->db->prepare("SELECT register_user.*,review.number_bill_new,review.crystal_bill,review.date,review.id_accountant,review.id_prepared ,review.note_review FROM review INNER JOIN register_user ON register_user.id = review.id_customre    WHERE   review.number_bill_new=? AND review.cancel=0");
        $stmt_customer->execute(array($number_bill));
        $result=$stmt_customer->fetch(PDO::FETCH_ASSOC);



        $stmt=$this->db->prepare("SELECT review_item.*,cart_shop_active.price_dollars,cart_shop_active.image FROM review_item     INNER JOIN cart_shop_active ON cart_shop_active.id=review_item.id_cart WHERE   number_bill_new=?  AND review_item.cancel=0 ");
        $stmt->execute(array($number_bill));
        $bill=array();

        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $row['price_sale']=$this->price_dollarsAdmin($row['price_dollars']);
            $row['image']=$this->save_file.$row['image'];
            $bill[]=$row;
        }


        require($this->render($this->folder, 'search_rewind/html', 'data', 'php'));


    }


}