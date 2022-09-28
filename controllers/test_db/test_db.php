<?php

class test_db extends Controller
{


    function __construct()
    {
        parent::__construct();

    }



function x()
{


    copy('E:\projects\inside_alamani\controllers\test_db\afaq.jpg', 'C:\xampp\htdocs\inside_alamani\inside_alamani\controllers\test_db\x.jpg');

}


    public function upload2()
    {
        $host='alamani.iq';
        $port=21;
       $timeout=3600;
       $user='alixcol@alamani.iq';
        $pass='&7k@Q(DvNUJH';
        $ftp = ftp_connect($host, $port, $timeout);
        ftp_login($ftp, $user, $pass);

        $dest_file='/home/alamani/public_html/alamani.iq/alixcol';


        $save_file = $this->root_file;
        @mkdir($save_file);
        echo $source_file = $save_file.'/0b21a186df3393cbcefce459bf7df9ce_.png';

        $ret = ftp_put($ftp,
            $dest_file,
            'test_db.php', FTP_BINARY);

        while (FTP_MOREDATA == $ret)
        {
            print_r('1');
            // display progress bar, or something
            $ret = ftp_nb_continue($ftp);
        }


    }



    public function upload()
    {

        $this->adminHeaderController($this->langControl('add'));


        if (isset($_POST['submit']))
        {

            $ftp_server='alamani.iq';

            $ftp_user_name='alixcol@alamani.iq';
            $ftp_user_pass='&7k@Q(DvNUJH';

            $destination_file = "/public_html/alamani.iq/alixcol/";

            $save_file = $this->root_file;
            @mkdir($save_file);
            $source_file = $save_file.'/0b21a186df3393cbcefce459bf7df9ce_.png';

      //      $source_file = $_FILES['file']['tmp_name'];

// set up basic connection
            $conn_id = ftp_connect($ftp_server);
            ftp_pasv($conn_id, true);

// login with username and password
            $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

// check connection
            if ((!$conn_id) || (!$login_result)) {
                echo "FTP connection has failed!";
                echo "Attempted to connect to $ftp_server for user $ftp_user_name";
                exit;
            } else {
                echo "Connected to $ftp_server, for user $ftp_user_name";
            }

// upload the file
            $upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY);

// check upload status
            if (!$upload) {
                echo "FTP upload has failed!";
            } else {
                echo "Uploaded $source_file to $ftp_server as $destination_file";
            }

// close the FTP stream
            ftp_close($conn_id);


        }



        require($this->render($this->folder, 'html', 'index', 'php'));
        $this->adminFooterController();

    }





    function index()
    {

        $servername = "94.23.204.112";
        $username = "alamani_system";
        $dbname = "alamani_system";
        $password = "system2052032";

        try {
            $conn = new PDO("mysql:host=$servername;dbname={$dbname}", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        $stmt=$conn->prepare("SELECT *FROM  accessories WHERE 1 LIMIT 5");
               $stmt->execute();
        $aa=array();
        while ($row =$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $aa[]=$row;
        }
           print_r($aa);

    }


}