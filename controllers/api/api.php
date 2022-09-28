<?php



class api extends Controller
{

    function __construct()
    {

        parent::__construct();

    }

      function syn()
      {

              // $stmtInst=$this->db->prepare("INSERT INTO xxx (code) values  (?) ");
              // $stmtInst->execute(array(1));
            // $this->synchronization();
      	// $this->add_cart_shop_all();
       $this->testConnection();


      }
		function syn_item()
      {

              // $stmtInst=$this->db->prepare("INSERT INTO xxx (code) values  (?) ");
              // $stmtInst->execute(array(1));
      		// $this->synchronization_item();
			// $this->synchronization_line_2();
        $stmt = $this->db->prepare('SELECT id,code,img FROM `product_savers`  where code in ( "159033","159225","159226","159228","159229","159243","159244","159246","159282","172067","172071","172072","172073","172074","172077","172079","172080","172082","172084","172088","172089","172090","172091","172092","172110","172111","172113","172114","172120","172121","172136","172138","172139","172143","172153","172239","172278","172293","172296","172297","172307","172310","172338","172356","172383","172394","172402","172446","172462","172499","172500","172501","172537","172555","172559","172564","172569","172575","172578","172579","172640","172644","172649","172653","172658","172659","172662","172675","172678","172679","172682","172686","172707","172711","172734","172758","172793","172797","172798","172833","172984","173060","173072","173075","173100","173261","173263","173266","173299","173580","173583","173706","173714","173722","173890","174198","174294","174301","174346","174378","174467","174474","174477","174488","174490","174492","174725") ;');
            $stmt->execute();
            $not_exist = '';
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $path_img = ROOT_FILES_h27.$row['img'];
                if (!file_exists($path_img))
                {
                    $not_exist .= $row['img'].',';
                }
    
            }
            $not_exist=substr($not_exist,0,-1);
            echo $not_exist;

      }
// 		function add_direct()
//         { 
//         	$stmt=$this->db->prepare("SELECT id FROM `computer` ");
//             $stmt->execute();
//             // $result= $stmt->fetchAll(PDO::FETCH_ASSOC);
//         	//print_r($result);
        
//             if ($stmt-> rowCount() > 0 )
//             {
//                 while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
//                 {
//                 	 $stmt_ins = $this->db->prepare("INSERT INTO `sync_schedule`(`id_rec`, `table_name`, `function`) VALUES (?,?,?)");
//         			$stmt_ins->execute(array($row['id'],'computer','add_item'));
//                 }
//             }
//         }
	function syn_line_2()
    {
        // echo "test";
		$this->synchronization_line_2();
              // $stmtInst=$this->db->prepare("INSERT INTO xxx (code) values  (?) ");
              // $stmtInst->execute(array(1));
      		// $this->synchronization_item();


    }
	function manual_send()
    {
        // $this->checkPermit('details','found');
        $this->adminHeaderController($this->langControl('api'));
        require ($this->render($this->folder,'html','manual_send','php'));
        $this->adminFooterController();
    }
    function get_ids()
    {
        $str = $_POST['str'];
        $stmt=$this->db->prepare( $str);
        $stmt->execute();
        // $result= $stmt->fetchAll(PDO::FETCH_ASSOC);
        // print_r($result);
        $ids = array();
        if ($stmt-> rowCount() > 0 )
        {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $ids[] = $row['id'];
            }
        }
        echo json_encode($ids);
    }
    function synchronization_direct()
    {
        $id = $_POST['id'];
        $id_rec = $_POST['id_rec'];
        $table_name = $_POST['table_name'];
        $function = $_POST['function'];
    	$code = $_POST['code'];
        // $row = $stmt->fetch(PDO::FETCH_ASSOC);
        switch ($function) {
            case 'quantity_adjustment':
                echo json_encode($this->quantity_adjustment_send($id,$id_rec,$table_name));
                break;
            case 'add_category':
                echo json_encode($this->add_category_send($id,$id_rec,$table_name));
                break;
            case 'add_item':
                echo json_encode($this->add_item_send($id,$id_rec,$table_name));
                break;
            case 'add_category_savers':
                echo json_encode($this->add_category_savers_send($id,$id_rec));
                break;
            case 'add_name_device':
                echo json_encode($this->add_name_device_send($id,$id_rec));
                break;
            case 'add_type_device':
                echo json_encode($this->add_type_device_send($id,$id_rec));
                break;
            case 'add_savers':
                echo json_encode($this->add_savers_send($id,$id_rec));
                break;
            case 'add_accessories':
                echo json_encode($this->add_accessories_send($id,$id_rec));
                break;
            case 'add_mobile':
                echo json_encode($this->add_mobile_send($id,$id_rec));
                break;
            case 'offer_categories':
                echo json_encode($this->add_offer_categories_send($id,$id_rec,$table_name));
                break;
            case 'delete_offer_categories':
                echo json_encode($this->delete_offer_categories_send($id,$id_rec,$table_name));
                break;
            case 'add_offers':
                echo json_encode($this->add_offers_send($id,$id_rec,$table_name));
                break;
            case 'add_offers_item':
                echo json_encode($this->add_offers_item_send($id,$id_rec,$table_name));
                break;
            case 'delete_offers_item':
                echo json_encode($this->delete_offers_item_send($id,$id_rec,$table_name));
                break;
            case 'add_class_games':
                echo json_encode($this->add_class_games_send($id,$id_rec));
                break;
            case 'add_games':
                echo json_encode($this->add_games_send($id,$id_rec));
                break; 
        
        	case 'delete_category':
                 echo json_encode($this->delete_cate_send($id,$id_rec,$table_name));
                 break;
           case 'delete_item':
                 echo json_encode($this->delete_item_send($id,$id_rec,$table_name,$code));
                break;
          // case 'delete_color_code':
         	 //  echo json_encode($this->delete_color_code_send($id,$id_rec,$table_name,$code));
          	// break;
         // case 'delete_code':
              //  echo json_encode($this->delete_code_send($id,$id_rec,$table_name,$code));
              // break; 
        	case 'delete_item_accessories':
                echo json_encode($this->delete_item_accessories_send($id,$id_rec,$table_name,$code));
               	break;
            case 'delete_savers':
                echo json_encode($this->delete_savers_send($id,$id_rec,$table_name,$code));
                break;

				case 'delete_type_device':
				echo json_encode($this->delete_type_device_send($id,$id_rec,$table_name));
				break;
			case 'delete_name_device':
				echo json_encode($this->delete_name_device_send($id,$id_rec,$table_name));
				break;
			case 'delete_category_savers':
				echo json_encode($this->delete_category_savers_send($id,$id_rec,$table_name));
				break;
                    
            
        }
    }



}
