<?php

class goods_availability extends Controller
{

    public $ids = array();
    public $day_count = 1;
    function __construct()
    {
        parent::__construct();
        $this->table = 'goods_availability';
        //  $this->day_count =1;
        // $this->menu=new Menu();
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `content`  longtext COLLATE utf8_unicode_ci NOT NULL,
          `image`  longtext COLLATE utf8_unicode_ci NOT NULL,
          `active` int(20) NOT NULL DEFAULT 0,
          `id_r` int(20) NOT NULL DEFAULT 0,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table));
    }
    function shortage_report($count = 30, $model = 'mobile', $id_cat = 0,$code='0',$from_date=0,$to_date=0)
    {
        $this->checkPermit('shortage_report', 'goods_availability');
        $this->adminHeaderController($this->langControl('shortage_report'));
        if($from_date==0){
            $from_date =   date("Y-m-d\TH:i:s",time() - 2592000);
        }
        if($to_date==0){
            $to_date = date("Y-m-d\TH:i:s",time());
        }

        require($this->render($this->folder, 'html', 'shortage_report', 'php'));
        $this->adminFooterController();
    }
    // processing_shortage_report 
    function processing_shortage_report($count, $model, $id_cat,$code,$from_date,$to_date)
    {

        $this->day_count = $count;
        $this->model = $model;
        $this->id_cat = $id_cat;
        $this->code = $code;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        // echo 'from '.$this->from_date;
        // echo 'to '.$this->to_date;
        // هنا راح ترجع Array بيها كل معدلات اليبع سواء من السحب اومعدل البيع في مواقع المبيع وبعدين ابدي افلتر بيهن حتى الركوست يصير مره وحده
        // $this->avg_mpi = $this->get_all_avg_mpi($model);
        $table = "goods_availability";
        $primaryKey = 'goods_availability.id';
        if ($model != 'savers') {
            $columns = array(
                array('db' => 'goods_availability.code', 'dt' => 0),
                array('db' => "{$model}.title", 'dt' => 1),
                array(
                    'db' => 'goods_availability.model', 'dt' => 2,
                    'formatter' => function ($d, $row) {
                        // return $item_title
                        return '<div style=" inline-size: 150px;
                        white-space: normal;">' . $this->get_quantity_from_excel($row[0],$d) . '</div>';
                    }
                ),
                array(
                    'db' => 'goods_availability.MPI', 'dt' => 3,
                    'formatter' => function ($d, $row) {
                        // return $item_title
                        return '<div style=" inline-size: 150px;
                        white-space: normal;">' . $this->get_shortage_qun($row[0], $row[2], $this->day_count,$this->from_date,$this->to_date) . '</div>';
                    }
                ),
                // array(
                //     'db' => 'goods_availability.MPI', 'dt' => 4,
                //     'formatter' => function ($d, $row) {

                //         $tatal=  (int)$this->get_shortage_qun($row[0], $row[2], $this->day_count,$this->from_date,$this->to_date) -  (int)$this->get_quantity_from_excel($row[0], $row[2]);


                //         return '<div style=" inline-size: 150px;
                //         white-space: normal;">' . $tatal. '</div>';
                //     }
                // ),
                array(
                    'db' => 'goods_availability.MPI', 'dt' => 4,
                    'formatter' => function ($d, $row) {

                        return $this->get_report_withdrawn($this->model,$row[0],$this->from_date,$this->to_date);
                    }
                ),
                array(
                    'db' => 'goods_availability.MPI', 'dt' => 5,
                    'formatter' => function ($d, $row) {

                        return $this->get_cart_shop_sell($this->model,$row[0],$this->from_date,$this->to_date);
                    }
                ),
                array(
                    'db' => 'goods_availability.MPI', 'dt' => 6,
                    'formatter' => function ($d, $row) {

                        return $this->get_goods_availability($this->model,$row[0],$this->from_date,$this->to_date);
                    }
                ),

            );
        } else {
            $columns = array(
                array('db' => 'goods_availability.code', 'dt' => 0),
                array(
                    'db' => "product_savers.title", 'dt' => 1,
                    'formatter' => function ($d, $row) {
                        // return $item_title
                        return  '<div style=" inline-size: 150px !important;
                        white-space: normal;">' . $this->get_item_title($d, $row[0]) . '</div>';
                    }
                ),
                array(
                    'db' => 'goods_availability.model', 'dt' => 2,
                    'formatter' => function ($d, $row) {
                        // return $item_title
                        return '<div style=" inline-size: 150px;
                        white-space: normal;">' . $this->get_quantity_from_excel($row[0],$d) . '</div>';
                    }
                ),
                array(
                    'db' => 'goods_availability.MPI', 'dt' => 3,
                    'formatter' => function ($d, $row) {
                        // return $item_title
                        return '<div style=" inline-size: 150px;
                        white-space: normal;">' . $this->get_shortage_qun($row[0], $row[2], $this->day_count,$this->from_date,$this->to_date) . '</div>';
                    }
                ),
                // array(
                //     'db' => 'goods_availability.MPI', 'dt' => 4,
                //     'formatter' => function ($d, $row) {

                //         // $tatal=  (int)$this->get_shortage_qun($row[0], $row[2], $this->day_count,$this->from_date,$this->to_date)-  (int)$this->get_quantity_from_excel($row[0], $row[2]);

                //         return '<div style=" inline-size: 150px;
                //         white-space: normal;">0</div>';
                //     }
                // ),
           
                array(
                    'db' => 'goods_availability.MPI', 'dt' => 4,
                    'formatter' => function ($d, $row) {

                        return $this->get_report_withdrawn($this->model,$row[0],$this->from_date,$this->to_date);
                    }
                ),
                array(
                    'db' => 'goods_availability.MPI', 'dt' => 5,
                    'formatter' => function ($d, $row) {

                        return $this->get_cart_shop_sell($this->model,$row[0],$this->from_date,$this->to_date);
                    }
                ),
                array(
                    'db' => 'goods_availability.MPI', 'dt' => 6,
                    'formatter' => function ($d, $row) {

                        return $this->get_goods_availability($this->model,$row[0],$this->from_date,$this->to_date);
                    }
                ),

            );
        }

        // SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        if ($this->model == 'accessories') {
            $join = " INNER JOIN color_accessories on color_accessories.code = goods_availability.code inner join accessories on accessories.id = color_accessories.id_item";
            $whereAll = "goods_availability.model='" . $this->model . "' and accessories.id_cat in (" . $this->get_ids_cat($this->model, $this->id_cat) . ")";
        } else if ($this->model == 'savers') {
            // $join = " INNER JOIN product_savers on product_savers.code = goods_availability.code INNER JOIN type_device on type_device.id = product_savers.id_device INNER JOIN name_device on name_device.id = type_device.id_device INNER JOIN category_savers on category_savers.id = name_device.id_cat";
            $join = "INNER JOIN product_savers on product_savers.code = goods_availability.code";
        	if($this->id_cat!=0)
            	$whereAll = "goods_availability.model='" . $this->model . "' and product_savers.id_device IN (select id from type_device where id_device IN (select id from name_device where  id_cat=" . $this->id_cat . "))";
			else
            	$whereAll = "goods_availability.model='" . $this->model . "' ";
            	
        } else {
            $code = 'code';
            $color = 'color';
            if ($this->model != 'mobile') {
                $code = "code_{$this->model}";
                $color = "color_{$this->model}";
            }
            $join = " INNER JOIN {$code} on {$code}.code = goods_availability.code INNER JOIN {$color} on {$color}.id = {$code}.id_color INNER JOIN {$this->model} on {$this->model}.id = {$color}.id_item";
            $whereAll = "goods_availability.model='" . $this->model . "' and {$this->model}.id_cat in (" . $this->get_ids_cat($this->model, $this->id_cat) . ")";
        }
        if($this->code!=0)
        {
            $whereAll = "goods_availability.model='{$this->model}' and goods_availability.code='{$code}'";
        }


        // $ids_cat = $this->get_ids_cat($this->model,$this->id_cat);
        $group_by = "group by goods_availability.code    ";
        echo json_encode(
            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll, null, $group_by)
        );
    }
    /**
     * هاي الدالة ترجع معدل المبيع  لكل المواد
     */
    function  get_all_avg_mpi($model)
    {
        // global $wpdb;
        // $table = $wpdb->prefix . 'goods_availability';
        // $sql = "SELECT code,AVG(MPI) as avg_mpi FROM {$table} where model='{$model}' group by code";
        // $result = $wpdb->get_results($sql);
        // return $result;
    }
    

    /**
     * الدالة ترجع معرفات كل الفئات الي باخلها
     * @param  string $id_cat الفئة الذي تريد المعرفات التابعة لها
     * @return array        المعرفات التابعة للفئة المرسلة
     */
    function get_ids_cat($model, $id_cat)
    {
        $stmt = $this->db->prepare("SELECT id FROM category_{$model} WHERE relid in({$id_cat})");
        $stmt->execute();
        // if($stmt->rowCount()>0)
        // {
        //     echo '>0';
        // }
        // else
        // {
        //     echo '=0';
        // }
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id_cat  .= ',' . $this->get_ids_cat($model, $row['id']);
        }
        // echo $id_cat;
        return $id_cat;
    }
    function test($model, $id_cat)
    {
        echo $this->get_ids_cat($model, $id_cat);
    }

    /**
     * هاي دالة المعالجة الخاصة بموضوع عرض  التتبع
     */
    public function getCatgry($model)
    {
        $found = $this->db->prepare("SELECT * FROM category_$model ");
        $found->execute();
        $categorys = array();
        while ($row = $found->fetch(PDO::FETCH_ASSOC)) {
            $categorys[] = $row;
        }
        echo json_encode($categorys);
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
     * get shortage quantity by barcode
     * @param  str $barcode barcode of item
     * @param str $model  model of item
     * @return int $quantity shortage quantity
     */
    function get_avg_mpi($barcode, $model,$from_date,$to_date)
    {
        $stmt = $this->db->prepare("SELECT IFNULL(AVG(MPI), 0) as MPI FROM `goods_availability` where code =? and model = ?and (date_start between ? and ? or  date_end between ? and ?) and MPI > 0;");
        $stmt->execute(array($barcode, $model, strtotime($from_date),strtotime($to_date),strtotime($from_date),strtotime($to_date) ));
        if($stmt_data = $stmt->fetch(PDO::FETCH_ASSOC)){
            // return $stmt_data['MPI'];
            return $stmt_data['MPI']*60 ;
        }
        return 0;
    }
    public function get_shortage_qun($barcode, $model, $days,$from_date,$to_date)
    {


        $stmt = $this->db->prepare("SELECT IFNULL(sum(quantity), 0) as quantity FROM `report_withdrawn` where code =? and category = ? and date between  ? and ? ;");
        $stmt->execute(array($barcode, $model,strtotime($from_date) ,strtotime($to_date)));
        $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
        // الكمية المسحوبة من المخزن
        $withdrawn = $stmt_data['quantity'];
        
        if($withdrawn == 0)
        {
            $withdrawn_avg_in_h = 0;
            $time_qu_withdrawn = 0;
        }
        else
        {
            $withdrawn_avg_in_h = ( 30*24)/$withdrawn ;
            $time_qu_withdrawn = ($days *24)/ ($withdrawn_avg_in_h);
        }
        // نسبة المبيعات     
        $avg_mpi_in_h = $this->get_avg_mpi($barcode, $model,$from_date,$to_date) / (60 * 60 );
        if($avg_mpi_in_h == 0)
        {
            $avg_mpi_in_h = 0;
            $time_qu_avg_mpi = 0;
        }
        else
        {
            $time_qu_avg_mpi = ($days *24)/ ($avg_mpi_in_h);
        }
        $sum = $time_qu_avg_mpi + $time_qu_withdrawn;
        return (int)$sum;
    }
    function slack_report($count = 1, $model = '0', $id_cat = 0)
    {
        $this->checkPermit('slack_report', 'goods_availability');
        $this->adminHeaderController($this->langControl('slack_report'));
        require($this->render($this->folder, 'html', 'slack_report', 'php'));
        $this->adminFooterController();
    }
    function processing_slack_report($count, $model, $id_cat)
    {

        $this->day_count = $count;
        $this->model = $model;
        $this->id_cat = $id_cat;
        $table = "goods_availability";
        $primaryKey = 'goods_availability.id';
        $columns = array(
            array('db' => 'goods_availability.code', 'dt' => 0),
            array(
                'db' => "goods_availability.model", 'dt' => 1,
                'formatter' => function ($d, $row) {
                    // return $item_title
                    return  '<div style=" inline-size: 150px !important;
                        white-space: normal;">' . $this->get_item_title($d, $row[0]) . '</div>';
                }
            ),
            array( 'db' => 'goods_availability.model', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                    // return $item_title
                    return $this->get_qun_location($d, $row[0]);
                }
            ),
            array( 'db' => 'goods_availability.MPI', 'dt' => 3 ,
            'formatter' => function( $d, $row ) {
                // return $item_title
                return $this->convert_time($this->get_avg_mpi($row[0], $row[1],date('Y-m-d\TH:i:s',  time() - 2592000),date('Y-m-d\TH:i:s',time())));
            }
            ),
            array( 'db' => 'goods_availability.MPI', 'dt' => 4 ,
            'formatter' => function( $d, $row ) {
                // return $item_title
                return $this->convert_time($this->get_time_remane( $row[0], $row[1]));
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



        // $ids_cat = $this->get_ids_cat($this->model,$this->id_cat);
        $whereAll = " goods_availability.code in({$this->get_slack_barcode($this->model,$this->id_cat,$this->day_count)})  ";
        $group_by = " group by goods_availability.code ";
        echo json_encode(
            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, null, null, $whereAll, null, $group_by)
        );
    }
    /**
     * 
     */
    function get_slack_barcode($model, $id_cat, $count)
    {
        if ($model == 'accessories') {
            $join = " INNER JOIN color_accessories on color_accessories.code = goods_availability.code INNER JOIN accessories on accessories.id = color_accessories.id_item ";
            $whereAll = "goods_availability.model='" . $model . "' and goods_availability.MPI!=0 and accessories.id_cat in (" . $this->get_ids_cat($model, $id_cat) . ")";
        } else if ($model == 'savers') {
            // $join = " INNER JOIN product_savers on product_savers.code = goods_availability.code INNER JOIN type_device on type_device.id = product_savers.id_device INNER JOIN name_device on name_device.id = type_device.id_device INNER JOIN category_savers on category_savers.id = name_device.id_cat";
            $join = "INNER JOIN product_savers on product_savers.code = goods_availability.code";
            $whereAll = "goods_availability.model='" . $model . "' and product_savers.id_device IN (select id from type_device where id_device IN (select id from name_device where  id_cat in (" . $this->get_ids_cat($model, $id_cat) . ")";
        } else {
            $code = 'code';
            $color = 'color';
            if ($model != 'mobile') {
                $code = "code_{$model}";
                $color = "color_{$model}";
            }
            $join = " INNER JOIN {$code} on {$code}.code = goods_availability.code INNER JOIN {$color} on {$color}.id = {$code}.id_color INNER JOIN {$model} on {$model}.id = {$color}.id_item";
            $whereAll = "goods_availability.model='" . $model . "' and  {$model}.id_cat in (" . $this->get_ids_cat($model, $id_cat) . ")";
        }
        $stmt = $this->db->prepare("select model,code,last_date_sale from goods_availability where last_date_sale in ( select max(last_date_sale) from goods_availability GROUP BY code) and code in( select goods_availability.code from goods_availability {$join} where {$whereAll})");
        $stmt->execute();
        $codes = '"897894654843123"';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // echo $row['code'] . '<br>';
            if($this->get_quantity_from_location($row['code'],$model) > 0){
                // $codes .= ',"' . $row['code'] . '"';
                if ($this->get_avg_mpi($row['code'], $model,date('Y-m-d\TH:i:s',  time() - 2592000),date('Y-m-d\TH:i:s',time())) * $count < $this->get_time_remane( $row['code'],$model) ) {
                    $codes .= ',"' . $row['code']. '"';
                }
            }
        }
        //  echo "select model,code,last_date_sale from goods_availability where last_date_sale in ( select max(last_date_sale) from goods_availability GROUP BY code) and goods_availability.code in( select code from goods_availability {$join} where {$whereAll})";
        return $codes;
    }
    /**
     * get quantity from excel table by code and model
     * @param string $code
     * @param string $model
     * @return int
     */
    function get_quantity_from_excel($code, $model){
        $excel ='excel';
        if($model != 'mobile'){
            $excel = 'excel_' . $model;
        }  
        $stmt = $this->db->prepare("select quantity from {$excel} where code = '{$code}' ");
        $stmt->execute();
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            return $row['quantity'];
        }
        else 
            return 0;
    }
    /**
     * get quantity from location if sequence between 4 and 100 by code and model
     */
    function get_quantity_from_location($code, $model){
        $stmt = $this->db->prepare("select sum(quantity) as quantity from location where code = '{$code}' and model='{$model}' and sequence between 4 and 100");
        $stmt->execute();
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            return $row['quantity'];
        }
        else 
            return 0;
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
        $stmt = $this->db->prepare("SELECT location,quantity FROM `location` where code = ? and model =? ");
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
        $stmt = $this->db->prepare("SELECT location,quantity FROM `location` where code = ? and model =? UNION SELECT 'بانتضار التاكيد',quantity FROM `location_confirm` where code = ? and model =?;");
        $stmt->execute(array($barcode, $model,$barcode, $model));
        $stmt_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $table .= '<tr>';
        $table .= '<td style=\'color:red;font-weight: bold;\'>المجموع</td>';
        $table .= '<td>' . $sum . '</td>';
        $table .= '</tr>';
        $table .= '</tbody>';
        $table .= '</table>';
        return $table;
    }
    /**
     * get goods availability by code and model
     * @return str $model  model of item
     * @param  str $barcode barcode of item
     */
    public function get_goods_availability($model, $barcode,$from_date,$to_date)
    {
        // html table with tow columns location and quantity
        $table = '<table class="table table-bordered table-striped table-hover">';
        $table .= '<thead>';
        $table .= '<tr>';
        $table .= '<th>من</th>';
        $table .= '<th>الى</th>';
        $table .= '<th>كمية التعويض </th>';
        $table .= '<th>كمية البيع</th>';
        $table .= '</tr>';
        $table .= '</thead>';
        // echo 'from date ' . $from_date . ' to date ' . $to_date;
        $stmt = $this->db->prepare("SELECT date_start , date_end , quantity,sale_count,MPI FROM `goods_availability` where code = ? and model =? and (date_start between ? and ? or  date_end between ? and ?) order by id ");
        $stmt->execute(array($barcode, $model,strtotime($from_date),strtotime($to_date),strtotime($from_date),strtotime($to_date)));
        // echo "SELECT date_start , date_end , quantity,sale_count,MPI FROM `goods_availability` where code = '{$barcode}' and model ='{$model}' and (date_start between ".strtotime($from_date)." and ".strtotime($to_date)." or  date_end between ".strtotime($from_date)." and ".strtotime($to_date).") order by id ";
        $table .= '<tbody>';
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // print_r($row);
            if((int)$row['date_end']==0)
            {
                $table .= '<tr>';
                $table .= '<td>متوفر الى الان</td>';
                $table .= '<td>البيع كل '.$row['MPI'].' دقيقة</td>';
                // if($row['sale_count']<$row['quantity']) 
                    $table .= '<td >' . $row['quantity'] . '</td>';
                // else
                    $table .= '<td >' . $row['sale_count'] . '</td>';
                $table .= '</tr>';

            }
            else{
            // print_r($row);


                $table .= '<tr>';
                $table .= '<td>' .  date( 'Y-m-d h:i', $row['date_end']) . '</td>';
                // في حالة لم يكن هناك  سف اخر وان الوايل لن يعمل
                $check =true;
                while ( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // print_r($row);

                    $check_one = false;
                    // $sum = $sum + $row['quantity'];
                    // $table .= '<tr>';
                    $table .= '<td>' . date( 'Y-m-d h:i ',$row['date_start']) . '</td>';
                    // if($row['sale_count']<$row['quantity']) 
                        $table .= '<td >' . $row['quantity'] . '</td>';
                    // else
                        $table .= '<td >' . $row['sale_count'] . '</td>';
    
                    $table .= '</tr>';
                    $check =false;
                    if($row['date_end']!=0)
                    {
                        $check= true;
                        $table .= '<tr>';
                        $table .= '<td>' . date( 'Y-m-d h:i ',$row['date_end']) . '</td>';
                    }
    
                }
                if($check)
                {
                    $table .= '<td>لم يعوض الى الان</td>';
                    $table .= '<td>0</td>';
                    $table .= '</tr>';
    
                }
            }


        }
      
        
        $table .= '</tbody>';
        $table .= '</table>';
        return $table;
    }
    /**
     * get report_withdrawn quantity by code and model 
     */
    public function get_report_withdrawn($model, $barcode,$from_date,$to_date)
    {
        $stmt = $this->db->prepare("SELECT IFNULL(sum(quantity), 0) as quantity FROM `report_withdrawn` where code =? and category = ? and date between  ? and ? ;");
        $stmt->execute(array($barcode, $model,strtotime($from_date) ,strtotime($to_date)));
        $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
        // الكمية المسحوبة من المخزن
        return $stmt_data['quantity'];
    }
    /**
     * get report_withdrawn quantity by code and model 
     */
    public function get_cart_shop_sell($model, $barcode,$from_date,$to_date)
    {
        $stmt = $this->db->prepare("SELECT IFNULL(sum(`number`), 0) as quantity FROM `cart_shop_all` where code =? and `table` = ? and date between  ? and ? ;");
        $stmt->execute(array($barcode, $model,strtotime($from_date) ,strtotime($to_date)));
        $stmt_data = $stmt->fetch(PDO::FETCH_ASSOC);
        // الكمية المسحوبة من المخزن
        return $stmt_data['quantity'];
    }
    /**
     * get last date from cart_shop_active by code and model
     * @param string $code
     * @param string $model
     * @return int
     */
    function get_last_date_from_cart_shop($code, $model){
        $stmt = $this->db->prepare("select date_start,last_date_sale from goods_availability where code = '{$code}' and model='{$model}'  order by id desc limit 1");
        $stmt->execute();
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $last=0;
            if ($row['last_date_sale'] == 0) {
                $last= $row['date_start'];
            } else {
                $last= $row['last_date_sale'];
            }
            // 
            $time_h = date('H', $last);
            $time_m = date('i', $last);
            if ($time_h >= 1 && $time_h <= 8) {
                $last = $last - ($time_h * 60 * 60)-($time_m * 60);
                $last = $last + (8 * 60 * 60);
                
            }
            return $last;
           
        }
        else 
            return 0;
    }
    /**
     * convert int to time
     * @param int $time
     * @return string
     */
    function convert_time($time){
        $hour = (int)($time / 60 / 60);
        $min = (int)(($time - $hour * 60 * 60) / 60);
        $sec = (int)($time - $hour * 60 * 60 - $min * 60);
        return $hour . ':' . $min . ':' . $sec;
        // $time = round($time, 2);
        // $time = $time . ' ساعة';
        // return $time;
    }
    /**
     * get time remane by
     */
    function get_time_remane($code, $model){
        $last_sale = $this->get_last_date_from_cart_shop($code, $model);
        // do loop from last sale to current date and calulate time remane and remove time between 1am and 8am
        $time_remane = 0;
        $current_date = time();
        while ($last_sale < $current_date) {
            // if last sale time between 1am and 8am set last sale to 8am
            $time_h = date('H', $last_sale);
            $time_m = date('i', $last_sale);
            // if ($time_h >= 1 && $time_h <= 8) {
            //     $last_sale = $last_sale - ($time_h * 60 * 60) - ($time_m * 60);
            //     $last_sale = $last_sale + (8 * 60 * 60);
            // }
            // // if last_sale and current_date in same day add time remane and break
            //  else 
             if (date('Y-m-d', $last_sale) == date('Y-m-d', $current_date)) {
                $time_remane = $time_remane + ($current_date - $last_sale);
                break;
            }
            // if last_sale and current_date in different day add time remane and set last sale to next day 8am
            else {
                $time_h = date('H', $last_sale);
                $time_m = date('i', $last_sale);
                $time_remane = $time_remane + (24 * 60 * 60 -   ($time_h * 60 * 60) - ($time_m * 60));
                $last_sale = $last_sale + (24 * 60 * 60 - ($time_h * 60 * 60) - ($time_m * 60));
                $last_sale = $last_sale + (8 * 60 * 60);
            }
        }
        return $time_remane;

        //     $last_sale_start = $last_sale + ($last_sale % 86400);
        //     $time_remane = $time_remane + 86400;
        //     $last_sale = $last_sale + 86400;
        // }
        // $time_remane = $time_remane + ($current_date - $last_sale);
        // $time_remane = $this->convert_time($time_remane);
        // return $time_remane;
        // $time_r = time() - $this->get_last_date_from_cart_shop($code, $model);

        // return $this->convert_time($time_r);
    }



    

}
