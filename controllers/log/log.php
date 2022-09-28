<?php

class Log extends Controller
{
    function __construct()
    {
        parent::__construct();

        $this->table = 'log';
    }


    public function createTB()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `username` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `action` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `table` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `ip` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `lang` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
          `userid` int(11) NOT NULL,
          `date` bigint(20) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        return $this->db->cht(array($this->table));
    }


    public function view_log()
    {

        $this->checkPermit('view_log', 'log');
        $this->adminHeaderController($this->langControl('view_log'));


        require($this->render($this->folder, 'html', 'index', 'php'));
        $this->adminFooterController();

    }


    public function processing()
    {


        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(

            array('db' => 'username', 'dt' => 0),
            array('db' => 'action', 'dt' => 1,
                'formatter' => function( $d, $row ) {
                    return $this->langControl($d);
                }
            ),
            array('db' => 'table', 'dt' => 2),
            array( 'db' => 'date', 'dt' =>  3 ,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d h:i:s a', $d);
                }

            ),
        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "`lang`='{$this->langControl}'")
        );

    }

    public function insert($action, $table)
    {

        $stmt = $this->db->prepare("INSERT INTO `{$this->table}` (`username`,`action`,`table`,`ip`,`lang`,`userid`,`date`) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute(array(Session::get('usernamelogin'), $action, $table, $this->ipaddress(), $this->langControl, $this->userid, time()));
        if ($stmt->rowCount() > 0) {
            return true;
        }
    }


    public function ipaddress()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }


    public function delete()
    {
        if ($this->handleLogin()) {
            $myTimestamp = time();
            $setting = new Setting();
            if (empty($setting->get('delete_log'))) {
                $plus_month = strtotime("+1 month", $myTimestamp);
                $setting->set('delete_log', $plus_month);
            }
            if ($setting->get('delete_log') == $myTimestamp) {
                $stmt = $this->db->prepare("DELETE FROM `{$this->table}` WHERE 1");
                if ($stmt->rowCount() > 0) {
                    $setting->set('delete_log', 0);
                }
            }
        }

    }

    public function get_login()
    {
        $stmt = $this->db->prepare("SELECT *FROM {$this->table} WHERE `lang`='{$this->langControl}'");
        $stmt->execute();
        return $stmt;
    }


}