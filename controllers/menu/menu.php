<?php


class Menu extends Controller
{


    function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        $index = new Index();
        $index->index();
    }

    public function menu()
    {


        $mobile=new mobile();

        $stmt_site_table_acc =$mobile->select_category_mobile_public(0);
        $category_site_acc=array();

        while ($row_s_t_acc=$stmt_site_table_acc->fetch(PDO::FETCH_ASSOC))
        {


            if ($row_s_t_acc['img'] !=0) {
                $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row_s_t_acc['img'], ':module' => 'mobile_cat'));
                $get_file = $get_file[0];
                $row_s_t_acc['image'] ='<img class="ion_catg" src="'.$this->save_file.$get_file['rand_name'].'">';

            } else
            {
                $row_s_t_acc['image']= '<i class="fa fa-mobile"></i>';
            }


            if ($mobile->ck_sub_cat_public($row_s_t_acc['id']))
            {
                $row_s_t_acc['sub']='menu_arow_active dropdown-toggle';
            }
            else
            {
                $row_s_t_acc['sub']='';
            }
            $category_site_acc[]=$row_s_t_acc;
        }





        $accessories=new Accessories();

        $stmt_site_table_acc_accessories =$accessories->select_category_accessories_public(0);
        $category_site_acc_accessories=array();

        while ($row_s_t_acc_accessories=$stmt_site_table_acc_accessories->fetch(PDO::FETCH_ASSOC))
        {


            if ($row_s_t_acc_accessories['img'] != 0) {
                $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row_s_t_acc_accessories['img'], ':module' => 'accessories_cat'));
                if (!empty($get_file[0]))
                {
                    $get_file = $get_file[0];
                    $row_s_t_acc_accessories['image'] ='<img class="ion_catg" src="'.$this->save_file.$get_file['rand_name'].'">';
                }else
                {
                    $row_s_t_acc_accessories['image']= '<i class="fa fa-diamond"></i>';

                }


            } else
            {
                $row_s_t_acc_accessories['image']= '<i class="fa fa-diamond"></i>';
            }

            if ($accessories->ck_sub_cat_public($row_s_t_acc_accessories['id']))
            {
                $row_s_t_acc_accessories['sub']='menu_arow_active dropdown-toggle';
            }
            else
            {
                $row_s_t_acc_accessories['sub']='';
            }
            $category_site_acc_accessories[]=$row_s_t_acc_accessories;
        }



        $games=new Games();

        $stmt_site_table_acc_games =$games->select_category_games_public(0);
        $category_site_acc_games=array();

        while ($row_s_t_acc_games=$stmt_site_table_acc_games->fetch(PDO::FETCH_ASSOC))
        {

            if ($row_s_t_acc_games['img'] !=0) {
                $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row_s_t_acc_games['img'], ':module' => 'games_cat'));
                $get_file = $get_file[0];
                $row_s_t_acc_games['image'] ='<img class="ion_catg" src="'.$this->save_file.$get_file['rand_name'].'">';

            } else
            {
                $row_s_t_acc_games['image']= '<i class="fa fa-gamepad"></i>';
            }


            if ($games->ck_sub_cat_public($row_s_t_acc_games['id']))
            {
                $row_s_t_acc_games['sub']='menu_arow_active dropdown-toggle';
            }
            else
            {
                $row_s_t_acc_games['sub']='';
            }
            $category_site_acc_games[]=$row_s_t_acc_games;
        }


        $camera=new camera();

        $stmt_site_table_acc_camera =$camera->select_category_camera_public(0);
        $category_site_acc_camera=array();

        while ($row_s_t_acc_camera=$stmt_site_table_acc_camera->fetch(PDO::FETCH_ASSOC))
        {

            if ($row_s_t_acc_camera['img'] !=0) {
                $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row_s_t_acc_camera['img'], ':module' => 'camera_cat'));
                $get_file = $get_file[0];
                $row_s_t_acc_camera['image'] ='<img class="ion_catg" src="'.$this->save_file.$get_file['rand_name'].'">';

            } else
            {
                $row_s_t_acc_camera['image']= '<i class="fa fa-video-camera"></i>';
            }


            if ($camera->ck_sub_cat_public($row_s_t_acc_camera['id']))
            {
                $row_s_t_acc_camera['sub']='menu_arow_active dropdown-toggle';
            }
            else
            {
                $row_s_t_acc_camera['sub']='';
            }
            $category_site_acc_camera[]=$row_s_t_acc_camera;
        }



		$printing_supplies=new printing_supplies();

		$stmt_site_table_acc_printing_supplies =$printing_supplies->select_category_printing_supplies_public(0);
		$category_site_acc_printing_supplies=array();

		while ($row_s_t_acc_printing_supplies=$stmt_site_table_acc_printing_supplies->fetch(PDO::FETCH_ASSOC))
		{

			if ($row_s_t_acc_printing_supplies['img'] !=0) {
				$get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row_s_t_acc_printing_supplies['img'], ':module' => 'printing_supplies_cat'));
				$get_file = $get_file[0];
				$row_s_t_acc_printing_supplies['image'] ='<img class="ion_catg" src="'.$this->save_file.$get_file['rand_name'].'">';

			} else
			{
				$row_s_t_acc_printing_supplies['image']= '<i class="fa fa-video-printing_supplies"></i>';
			}


			if ($printing_supplies->ck_sub_cat_public($row_s_t_acc_printing_supplies['id']))
			{
				$row_s_t_acc_printing_supplies['sub']='menu_arow_active dropdown-toggle';
			}
			else
			{
				$row_s_t_acc_printing_supplies['sub']='';
			}
			$category_site_acc_printing_supplies[]=$row_s_t_acc_printing_supplies;
		}



		$computer=new computer();

        $stmt_site_table_acc_computer =$computer->select_category_computer_public(0);
        $category_site_acc_computer=array();

        while ($row_s_t_acc_computer=$stmt_site_table_acc_computer->fetch(PDO::FETCH_ASSOC))
        {

            if ($row_s_t_acc_computer['img'] !=0) {
                $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row_s_t_acc_computer['img'], ':module' => 'computer_cat'));
                $get_file = $get_file[0];
                $row_s_t_acc_computer['image'] ='<img class="ion_catg" src="'.$this->save_file.$get_file['rand_name'].'">';

            } else
            {
                $row_s_t_acc_computer['image']= '<i class="fa fa-video-computer"></i>';
            }


            if ($computer->ck_sub_cat_public($row_s_t_acc_computer['id']))
            {
                $row_s_t_acc_computer['sub']='menu_arow_active dropdown-toggle';
            }
            else
            {
                $row_s_t_acc_computer['sub']='';
            }
            $category_site_acc_computer[]=$row_s_t_acc_computer;
        }






        $network=new network();

        $stmt_site_table_acc_network =$network->select_category_network_public(0);
        $category_site_acc_network=array();

        while ($row_s_t_acc_network=$stmt_site_table_acc_network->fetch(PDO::FETCH_ASSOC))

        {
            if ($row_s_t_acc_network['img'] !=0) {
                $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row_s_t_acc_network['img'], ':module' => 'network_cat'));
                $get_file = $get_file[0];
                $row_s_t_acc_network['image'] ='<img class="ion_catg" src="'.$this->save_file.$get_file['rand_name'].'">';

            } else
            {
                $row_s_t_acc_network['image']= '<i class="fa fa-wifi"></i>';
            }


        if ($network->ck_sub_cat_public($row_s_t_acc_network['id']))
            {
                $row_s_t_acc_network['sub']='menu_arow_active dropdown-toggle';
            }
            else
            {
                $row_s_t_acc_network['sub']='';
            }
            $category_site_acc_network[]=$row_s_t_acc_network;
        }



        $medical_supplies=new medical_supplies();




        require ($this->render($this->folder,'html','index','php'));

    }






}
?>