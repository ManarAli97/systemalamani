<?php

class quantity_change_control extends Controller
{

    public $ids = array();
    function __construct()
    {
        parent::__construct();
        $this->table = 'quantity_error';
        $this->menu = new Menu();
    }


    /**
     * اضافة مجموعة جديده وعرض المجموعات الموجوده  وتفاصيلها
     */
    public function index()
    {
        $this->checkPermit('show_error', 'quantity_change_control');
        $this->adminHeaderController($this->langControl('quantity_change_control'));

        require($this->render($this->folder, 'html', 'index', 'php'));
        $this->adminFooterController();
    }

    /**
     * عرض عدد تكرارات الباركودات 
     */

    public function viwe_quantity_change_control()
    {
        $this->checkPermit('viwe_quantity_change_control', 'quantity_change_control');
        $this->adminHeaderController("عرض عدد تكرارات الباركودات");

        require($this->render($this->folder, 'html', 'viwe_quantity_change_control', 'php'));
        $this->adminFooterController();
    }

    public function processing_viwe_quantity_change_control()
    {
        $table = "quantity_change_control";
        $primaryKey = 'quantity_change_control.id';
        $columns = array(
            array('db' => 'quantity_change_control.code', 'dt' => 1),
            array('db' => 'quantity_change_control.model', 'dt' => 0,),

            // array(
            //     'db' => 'quantity_change_control.code', 'dt' => 2,
            //     'formatter' => function ($count_code) {
            //         return $this->get_count_of_id_by_code($count_code);
            //     }
            // ),
            array(
                'db' => 'quantity_change_control.code', 'dt' => 2,
                'formatter' => function ($code) {
                    // return $item_title
                    return '<a  href= "viwe_full_quantity_change_control/'.$code.'" role="button" title="اضغط لمعرفت التفاصيل"  class="btn btn-warning btn-lg ">  <span>' . $this->get_count_of_id_by_code($code);'</span></a>';
                }
            ),
        );
        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        // create group by code
        $groupBy = " GROUP BY quantity_change_control.code";
        echo json_encode(
            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, null, null, null, null, $groupBy)
        );
    }

    /**
     * get count of id by code
     */
    public function get_count_of_id_by_code($code)
    {
        $count = $this->db->select("SELECT COUNT(id) AS CountOfCode FROM `quantity_change_control` WHERE code = '$code'");
        return $count[0]['CountOfCode'];
    }


    /**
     * عرض تفاصيل الباركود المحدد
     */

    public function viwe_full_quantity_change_control($code)
    {
        $this->checkPermit('viwe_full_quantity_change_control', 'quantity_change_control');
        $this->adminHeaderController("عرض تفاصيل الباركود");
 
        require($this->render($this->folder, 'html', 'viwe_full_quantity_change_control', 'php'));
        $this->adminFooterController();
    }

    public function processing_viwe_full_quantity_change_control($code)
    {
        $table = "quantity_change_control";
        $primaryKey = 'quantity_change_control.id';
        $columns = array(
            array('db' => 'quantity_change_control.code', 'dt' => 0),
            array('db' => 'quantity_change_control.model', 'dt' => 1,),
            array('db' => 'quantity_change_control.prepared_q', 'dt' => 2,),
        
            array('db' => 'quantity_change_control.excal_q', 'dt' => 3,),
            array('db' => 'quantity_change_control.locations_total', 'dt' => 4,),
            array('db' => 'quantity_change_control.locations_q', 'dt' => 5,),
            array('db' => 'quantity_change_control.location_confirm_q', 'dt' => 6,),
            array('db' => 'quantity_change_control.date', 'dt' => 7,
                'formatter' => function ($d) {
                    return date('Y-m-d h:i A', $d);
                }
            ),
            array('db' => 'quantity_change_control.date', 'dt' => 8),
        
        );
        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        $where="quantity_change_control.code = '$code'";
        echo json_encode(
            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, null,$where)
        );
    }

    /**
     *  معالجة عرض الباركودات
     */
public function processing_index()
    {
        $table = "quantity_error";
        $primaryKey = 'quantity_error.id';
        $columns = array(
            array( 'db' => 'quantity_change_control.code', 'dt' => 0 ),
            array( 'db' => 'quantity_change_control.model', 'dt' => 1 ,
                'formatter' => function( $d, $row ) {
                    // return $item_title
                    return  '<div style=" inline-size: 150px !important;
                    white-space: normal;">'. $this->get_item_title($d, $row[0]).'</div>';
                    
                }
            ),
            array( 'db' => 'quantity_change_control.model', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                    // return $item_title
                    return '<div style=" inline-size: 150px;
                    white-space: normal;">'.$this->get_cat_title($d, $row[0]).'</div>';
                }
            ),
            array( 'db' => 'quantity_change_control.model', 'dt' => 3 ,
            'formatter' => function( $d, $row ) {
                    // return $item_title
                    return $this->langControl($d);
                }
            ),
            array( 'db' => 'quantity_change_control.excal_q', 'dt' => 4 ),
            array( 'db' => 'quantity_change_control.locations_total', 'dt' => 5 ),
            array( 'db' => 'quantity_change_control.location_confirm_q', 'dt' => 6 ),
            array( 'db' => 'quantity_change_control.model', 'dt' => 7 ,
                'formatter' => function( $d, $row ) {
                    // return $item_title
                    return $this->get_qun_location($d, $row[0]);
                }
            ),
            array( 'db' => 'quantity_error.date_add', 'dt' => 8 ,
            'formatter' => function( $d, $row ) {
                return date( 'Y-m-d h:i A', $d);
            }
        ),
        );
        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        $join = " INNER JOIN quantity_change_control on quantity_error.id_QCC = quantity_change_control.id  ";
		$whereAll = "quantity_error.repaired =0 and (quantity_change_control.model='accessories' or quantity_change_control.model='savers')";
        echo json_encode(
            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1)
        );
    }
    /**
     * get item name by barcode
     * @return str $model  model of item
     * @param  str $barcode barcode of item
     */
    public function get_item_title($model, $barcode)
    {
        if ($model == 'savers') {
            $stmt = $this->db->prepare("SELECT title FROM `product_savers` where code = ?;");
            $stmt->execute(array($barcode));
            $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $stmt_data['title'];
        } elseif ($model == 'accessories') {
            $stmt = $this->db->prepare("SELECT title FROM `accessories`  where id in(SELECT id_item from color_accessories where code =?);");
            $stmt->execute(array($barcode));
            $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $stmt_data['title'];
        } else {
            $color = 'color';
            $code = 'code';
            if ($model != 'mobile') {
                $color .= '_' . $model;
                $code .= '_' . $model;
            }
            $stmt = $this->db->prepare("SELECT title FROM {$model} where id in(SELECT id_item from {$color} where id in (SELECT id_color from {$code} where code = ''));");
            $stmt->execute(array($barcode));
            $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $stmt_data['title'];
        }
    }
    /**
     * get category name by barcode
     * @return str $model  model of item
     * @param  str $barcode barcode of item
     */
    public function get_cat_title($model, $barcode)
    {
        if ($model == 'savers') {

            $stmt = $this->db->prepare("SELECT `title` FROM `category_{$model}` where id in( SELECT id_cat FROM `product_savers` where code = ?;");
            $stmt->execute(array($barcode));
            $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $stmt_data['title'];
        } elseif ($model == 'accessories') {
            $stmt = $this->db->prepare("SELECT `title` FROM `category_{$model}` where id in(SELECT id_cat FROM `accessories`  where id in(SELECT id_item from color_accessories where code =?));");
            $stmt->execute(array($barcode));
            $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $stmt_data['title'];
        } else {
            $color = 'color';
            $code = 'code';
            if ($model != 'mobile') {
                $color .= '_' . $model;
                $code .= '_' . $model;
            }
            $stmt = $this->db->prepare("SELECT `title` FROM `category_{$model}` where id in(SELECT id_cat FROM {$model} where id in(SELECT id_item from {$color} where id in (SELECT id_color from {$code} where code = '')));");
            $stmt->execute(array($barcode));
            $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $stmt_data['title'];
        }
    }
    /**
     * get quantity location by barcode
     * @return str $model  model of item
     * @param  str $barcode barcode of item
     */
    public function get_qun_location($model, $barcode)
    {
        // html table with tow columns location and quantity
        $table = '<table class="table table-bordered table-striped table-hover">';
        $table .= '<thead>';
        $table .= '<tr>';
        $table .= '<th>الموقع</th>';
        $table .= '<th>الكمية</th>';
        $table .= '</tr>';
        $table .= '</thead>';
        $stmt = $this->db->prepare("SELECT location,quantity FROM `location` where code = ? and model =?;");
        $stmt->execute(array($barcode, $model));
        $stmt_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $table .= '<tbody>';
        $sum = 0;
        foreach ($stmt_data as $row) {
            $sum = $sum + $row['quantity'];
            $table .= '<tr>';
            $table .= '<td>' . $row['location'] . '</td>';
            $table .= '<td>' . $row['quantity'] . '</td>';
            $table .= '</tr>';
        }
        $table .= '<tr>';
        $table .= '<td style=\'color:red;font-weight: bold;\'>المجموع</td>';
        $table .= '<td>' . $sum . '</td>';
        $table .= '</tr>';
        $table .= '</tbody>';
        $table .= '</table>';
        return $table;
    }

    public function get_quantity_error_count()
    {
        // $this->checkPermit('add_winners','coupon');
        $stmt = $this->db->prepare("SELECT count(quantity_error.id) as count_ FROM `quantity_error` INNER JOIN quantity_change_control on quantity_error.id_QCC = quantity_change_control.id where quantity_error.repaired =0 and (quantity_change_control.model='accessories' or quantity_change_control.model='savers');");
        $stmt->execute();
        $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $stmt_data['count_'];
    }
}
