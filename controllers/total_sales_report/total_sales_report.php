<?php

/**
 * class total_sales_report
 */
class total_sales_report extends Controller
{

    /**
     * function __construct
     */
    function __construct()
    {
        parent::__construct();
    }
    /**
     * function index
     */
    public function index()
    {
        $this->checkPermit('user_sales', 'reports');
        $this->adminHeaderController("تقرير مبيعات الموظفين");

        // $sales_user_groups = array();
        // $stmtgruop = $this->db->prepare("SELECT id, title_group FROM `sales_user_groups`");
        // $stmtgruop->execute();
        // while ($row = $stmtgruop->fetch(PDO::FETCH_ASSOC)) {
        //     $sales_user_groups[] = $row;
        // }

        require($this->render($this->folder, 'html', 'sales_report_html', 'php'));
        $this->adminFooterController();
    }

    /**
     * get users_id from tabel cart_shop_active between two dates
     */
    public function get_users_id_whose_sales()
    {
        // get dates from post
        $this->checkPermit('user_sales', 'reports');
        $date_from = $_POST['from'];
        $date_to = $_POST['to'];
        $model = $_POST['model'];
        $id_cat = $_POST['id_cat'];
        $code = $_POST['code'];
        // $id_group = $_POST['id_group'];

        // chenge date format from post to datestamp
        $date_from = strtotime($date_from);
        $date_to = strtotime($date_to);


        // // get users_id from tabel cart_shop_active between two dates
        // $stmt = $this->db->prepare("SELECT DISTINCT `user_id` FROM `cart_shop_active` WHERE `date` BETWEEN ? AND ?");
        // $stmt->execute(array($date_from, $date_to));
        // $users_id = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // get user_id and namber and date from tabel cart_shop_active
        // $stmt = $this->db->prepare("SELECT user_id, `number` as salse ,`date` FROM `cart_shop_active` WHERE `date` BETWEEN ? AND ? ORDER BY user_id , `date`");
        // $stmt->execute(array($date_from, $date_to));
        // $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $model_condetion = '';
        if ($model != '0') {
            $model_condetion = " and `table`='{$model}'";
        }
        $cat_condetion = '';
        if ($id_cat != 0 && $code == '') {
            $cat_condetion = " and `id_item` in (select id from {$model} where id_cat in({$this->get_ids_cat($model,$id_cat)}))";
        }

        $code_condetion = '';
        if ($code != '') {
            $code_condetion = " and `code` = '{$code}'";
        }
        // $group_condetion = '';
        // if ($id_group != 0) {
        //     $group_condetion = " and `user_direct` in(select id from `user` where group_sales = {$id_group})";
        // }

        // get spasfic data from model 
        $stmt = $this->db->prepare("SELECT user_direct, price_dollars, `number` as salse ,`date` FROM `cart_shop_active` WHERE `date` BETWEEN ? AND  ? AND user_direct !=0 And buy = 2 {$model_condetion} {$cat_condetion} {$code_condetion} ORDER BY user_direct , `date`");
        $stmt->execute(array($date_from, $date_to));
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users_and_sales = [];
        $userName = [];
        $currnt_user = ' ';
        $j = -1;
        foreach ($rows as $row) {
            // if user_direct is not equal to currnt_user
            if ($row['user_direct'] != $currnt_user) {
                $j = $j + 1;
                $currnt_user = $row['user_direct'];

                // // get name by user_direct
                $userName = $this->db->prepare("SELECT `username` FROM `user` WHERE `id` = ?");
                $userName->execute(array($row['user_direct']));
                $names = $userName->fetch(PDO::FETCH_ASSOC);

                // put the name in users_and_sales array
                $users_and_sales[$j]['name'] = $names['username'];

                for ($i = $date_from; $i <= $date_to; $i += 86400) {
                    $users_and_sales[$j]['sales'][] = 0;
                    $users_and_sales[$j]['price_dollars'][] = 0;
                }
            }
            $day_count = -1;
            // loop in date between two dates
            for ($i = $date_from; $i <= $date_to; $i += 86400) {
                $day_count = $day_count + 1;
                //get start of day in rows date 
                $start_of_day = strtotime(date('Y-m-d', $i));
                //get end of day in rows date
                $end_of_day = strtotime(date('Y-m-d', $i + 86400));
                if ($row['date'] >= $start_of_day && $row['date'] <= $end_of_day) {
                    $users_and_sales[$j]['sales'][$day_count] += (int)$row['salse'];
                    $users_and_sales[$j]['price_dollars'][$day_count] += (int)$row['price_dollars'];
                }
            }
        }
        echo json_encode($users_and_sales);
    }

    public function daily_sales()
    {
        $this->checkPermit('daily_sales', 'reports');
        $this->adminHeaderController("مجموع المبيعات اليومي حسب عدد المبيعات");

        // $sales_user_groups = array();
        // $stmtgruop = $this->db->prepare("SELECT id, title_group FROM `sales_user_groups`");
        // $stmtgruop->execute();
        // while ($row = $stmtgruop->fetch(PDO::FETCH_ASSOC)) {
        //     $sales_user_groups[] = $row;
        // }

        require($this->render($this->folder, 'html', 'daily_sales_html', 'php'));
        $this->adminFooterController();
    }

    /**
     * get users_id from tabel cart_shop_active between two dates
     */
    public function daily_sales_count()
    {
        // get dates from post
        $date_from = $_POST['from'];
        $date_to = $_POST['to'];
        $model = $_POST['model'];
        $id_cat = $_POST['id_cat'];
        $code = $_POST['code'];
        // $id_group = $_POST['id_group'];

        // chenge date format from post to datestamp
        $date_from = strtotime($date_from);
        $date_to = strtotime($date_to)+86400;

        $model_condetion = '';
        if ($model != '0') {
            $model_condetion = " and `table`='{$model}'";
        }
        $cat_condetion = '';
        if ($id_cat != 0 && $code == '') {
            $cat_condetion = " and `id_item` in (select id from {$model} where id_cat in({$this->get_ids_cat($model,$id_cat)}))";
        }

        $code_condetion = '';
        if ($code != '') {
            $code_condetion = " and `code` = '{$code}'";
        }
        // $group_condetion = '';
        // if ($id_group != 0) {
        //     $group_condetion = " and `user_direct` in(select id from `user` where group_sales = {$id_group})";
        // }

        // get spasfic data from model 
        $stmt = $this->db->prepare("SELECT price_dollars, `number` as salse ,`date` FROM `cart_shop_active` WHERE `date` BETWEEN ? AND  ?  And buy = 2 {$model_condetion} {$cat_condetion} {$code_condetion} ORDER BY `date`");
        $stmt->execute(array($date_from, $date_to));
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


        // get the sum of sales for each day between two dates
        $sales = array();
        $price_dollars = array();
        for ($i = $date_from; $i <= $date_to; $i += 86400) {
            $sales[] = 0;
            $price_dollars[] = 0;
        }
        foreach ($rows as $row) {
            $day_count = -1;
            // loop in date between two dates
            for ($i = $date_from; $i <= $date_to; $i += 86400) {
                $day_count = $day_count + 1;
                //get start of day in rows date 
                $start_of_day = strtotime(date('Y-m-d', $i));
                //get end of day in rows date
                $end_of_day = strtotime(date('Y-m-d', $i + 86400));
                if ($row['date'] >= $start_of_day && $row['date'] <= $end_of_day) {
                    $sales[$day_count] += (int)$row['salse'];
                    $price_dollars[$day_count] += (int)$row['price_dollars'];
                }
            }
        }
        // send data to view
        echo json_encode(array('sales' => $sales, 'price_dollars' => $price_dollars));
    }

    function get_ids_cat($model, $id_cat)
    {
        // if model = 01 then get all ids from cat table where titel
        $stmt = $this->db->prepare("SELECT id FROM category_{$model} WHERE relid in({$id_cat})");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // 
            $id_cat  .= ',' . $this->get_ids_cat($model, $row['id']);
        }
        return $id_cat;
    }

    public function getCatgry($model)
    {
        // $group_condetion = '';
        // $accessories_condetion = '';
        // if ($model == "01") {
        //     $model = "accessories";
        //     $group_condetion = " where `title` like '%لاصق%' or title like '%لواصق%'";
        // }elseif($model == "accessories"){
        //     $accessories_condetion = "WHERE title not like '%لواصق%' and title not like '%لاصق%' ";
        // }
        $found = $this->db->prepare("SELECT * FROM category_$model ");
        $found->execute();
        $categorys = array();
        while ($row = $found->fetch(PDO::FETCH_ASSOC)) {
            $categorys[] = $row;
        }
        echo json_encode($categorys);
    }
}














// // do loop  from date_from to date_to 
// for ($i = $date_from; $i <= $date_to; $i += 86400) {
//     // get the start of day of the date from date_from
//     $start_of_day = strtotime(date('Y-m-d', $i));
//     // get end of day of the date from date_from
//     $end_of_day = strtotime(date('Y-m-d', $i + 86400)) - 1;
//     // get sales in spasfic date for each user and put it in array then add it as data and id_user as a lable and give rondem color in a to datasets for chart
//     $stmt = $this->db->prepare("SELECT sum(`number`) as sales FROM `cart_shop_active` WHERE `user_id` = ? and `date` BETWEEN ? AND ?");
//     $stmt->execute(array($user_id['user_id'], $start_of_day, $end_of_day));
//     $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     // if sales is null then put 0 in sales
//     if ($sales[0]['sales'] == null) {
//         $all_sales[] = 0;
//     } else {
//         // add sales to array
//         $all_sales[] = $sales[0]['sales'];
//     }
// }
//     $users_and_sales[] = array(
//         'user_id' => $user_id['user_id'],
//         'sales' => $all_sales
//     );
// }
// // send as json api
// echo json_encode($users_and_sales);









/**
 * get sales from tabel cart_shop_active for specific user_id and day
 */
// public function get_sales_in_specific_date()
// {
//     // get user_id and day from post
//     $user_id = $_POST['id_user'];
//     $day = $_POST['date'];
//     // get start of day and end of day in datestamp
//     $start_of_day = strtotime($day);
//     echo $start_of_day;
//     $end_of_day = $start_of_day + 86400;
//     // get sales from tabel cart_shop_active for specific user_id between two start of day and end of day
//     $stmt = $this->db->prepare("SELECT sum(number) as sales FROM `cart_shop_active` WHERE `user_id` = ? AND `date` BETWEEN ? AND ?");
//     $stmt->execute(array($user_id, $start_of_day, $end_of_day));
//     $sales = $stmt->fetch(PDO::FETCH_ASSOC);
//     // send as json api
//     echo json_encode($sales);
//     // get sales from tabel cart_shop_active for specific user_id and day
// }
/**
 * get sales and user_id from tabel cart_shop_active for specific user_id and day
 */
        // public function get_sales_in_specific_date()
        // {
        //     $date_from = $_POST['from'];
        //     $date_to = $_POST['to'];
        //     // chenge date format from post to datestamp
        //     $date_from = strtotime($date_from);
        //     $date_to = strtotime($date_to);
        //     // get users_id from tabel cart_shop_active between two dates
        //     $stmt = $this->db->prepare("SELECT DISTINCT `user_id` FROM `cart_shop_active` WHERE `date` BETWEEN ? AND ?");
        //     $stmt->execute(array($date_from, $date_to));
        //     $users_id = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //     // 
