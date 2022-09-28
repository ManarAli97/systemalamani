<?php
trait search_purchase_customer
{
    function __construct()
    {
        parent::__construct();
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject

    }


    function search_purchase_customer_bill()
    {

        $this->checkPermit('search_purchase_customer_bill', $this->folder);
        $this->AdminHeaderController($this->langControl('search_purchase_customer_bill'));





        require($this->render($this->folder, 'search_purchase_customer/html', 'index', 'php'));

        $this->AdminFooterController();
    }

    function data()
    {

        $number_bill=trim($_GET['bill']);


        $sum = $this->sumbill($number_bill);


        $stmt_customer = $this->db->prepare("SELECT register_user.*,purchase_customer_bill.number_bill,purchase_customer_bill.crystal_bill,purchase_customer_bill.date_account,purchase_customer_bill.active,purchase_customer_bill.user_purchase ,purchase_customer_bill.userid FROM purchase_customer_bill INNER JOIN register_user ON register_user.id = purchase_customer_bill.id_customer    WHERE   purchase_customer_bill.number_bill=?  ");
        $stmt_customer->execute(array($number_bill));
        $result = $stmt_customer->fetch(PDO::FETCH_ASSOC);




        $stmt = $this->db->prepare("SELECT * FROM purchase_customer_item  WHERE   number_bill=?");
        $stmt->execute(array($number_bill));
        $bill = array();
        $mod = array('savers');
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $table = $row['table'];


            if (!in_array($table, $mod)) {
                if ($table == 'mobile') {
                    $color = 'color';
                } else {
                    $color = 'color_' . $table;
                }

                $stmtT = $this->db->prepare("SELECT title FROM {$table}  WHERE id=?  ");
                $stmtT->execute(array($row['id_item']));
                if ($stmtT->rowCount() > 0) {
                    $r = $stmtT->fetch(PDO::FETCH_ASSOC);
                    $row['title'] = $r['title'];
                } else {
                    $row['title'] = '';
                }

                $stmtimg = $this->db->prepare("SELECT img FROM {$color}  WHERE id=?  ");
                $stmtimg->execute(array($row['id_color']));
                if ($stmtimg->rowCount() > 0) {
                    $rm = $stmtimg->fetch(PDO::FETCH_ASSOC);
                    $row['image'] = $this->save_file . $rm['img'];
                } else {
                    $row['image'] = '';
                }


            } else {
                $stmtT = $this->db->prepare("SELECT title,img FROM product_savers  WHERE id=?  ");
                $stmtT->execute(array($row['id_item']));
                if ($stmtT->rowCount() > 0) {
                    $r = $stmtT->fetch(PDO::FETCH_ASSOC);
                    $row['title'] = $r['title'];
                    $row['image'] = $this->save_file . $r['img'];

                } else {
                    $row['title'] = '';
                    $row['image'] = '';
                }
            }

            $bill[] = $row;
        }



        require($this->render($this->folder, 'search_purchase_customer/html', 'data', 'php'));


    }


}