<?php
class Index extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->menu=new Menu();
    }

    public function index()
    {

        if (isset($_SESSION['usernamelogin'])) {

            if (isset($_COOKIE['g_active']) && isset($_COOKIE['id_user_disk'])) {
                header("Location:" . url . "/games/disk?g=1");
            }

        }
        $this->publicHeader($this->langControl('title_website'));

		  $category_mobile = array();
		if ($this->thisCatg('mobile')) {


            $mobile = new mobile();
            $stmt_cat = $mobile->select_category_mobile_public(0);
            $category_mobile = array();

            $fm = 0;
            $cm = 1;
            while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
                if ($cm == 1) {
                    $fm = $row['id'];
                }
                $category_mobile[] = $row;
                $cm++;
            }
        }





        $category_camera=array();
        if ($this->thisCatg('camera')) {
            $camera=new camera();
            $stmt_cat =$camera->select_category_camera_public(0);
            $fc = 0;
            $cc = 1;
            while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
                if ($cc == 1) {
                    $fc = $row['id'];
                }
                $category_camera[] = $row;
                $cc++;
            }
        }




        $category_computer=array();
        if ($this->thisCatg('computer')) {

            $computer = new computer();
            $stmt_cat = $computer->select_category_computer_public(0);
            $fco = 0;
            $cco = 1;
            while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
                if ($cco == 1) {
                    $fco = $row['id'];
                }
                $category_computer[] = $row;
                $cco++;
            }


        }

        $category_printing_supplies=array();
        if ($this->thisCatg('printing_supplies')) {

            $printing_supplies = new printing_supplies();
            $stmt_cat = $printing_supplies->select_category_printing_supplies_public(0);
            $fps = 0;
            $cps= 1;
            while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
                if ($cps == 1) {
                    $fps = $row['id'];
                }
                $category_printing_supplies[] = $row;
                $cps++;
            }


        }


        $category_games=array();
        if ($this->thisCatg('games')) {

            $games = new games();
            $stmt_cat = $games->select_category_games_public(0);
            $fg = 0;
            $cg= 1;
            while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
                if ($cg == 1) {
                    $fg = $row['id'];
                }
                $category_games[] = $row;
                $cg++;
            }


        }


        $category_network=array();
        if ($this->thisCatg('network')) {

            $network = new network();
            $stmt_cat = $network->select_category_network_public(0);
            $fn = 0;
            $cn= 1;
            while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
                if ($cn == 1) {
                    $fn = $row['id'];
                }
                $category_network[] = $row;
                $cn++;
            }


        }



		$category_accessories = array();

		if ($this->thisCatg('accessories')) {

            $accessories=new accessories();
            $stmt_cat =$accessories->select_category_accessories_public(0);
            $fa=0;
            $ca=1;
            while ($row=$stmt_cat->fetch(PDO::FETCH_ASSOC))
            {
                if ($ca==1)
                {
                    $fa=$row['id'];
                }
                $category_accessories[]=$row;
                $ca++;
            }

        }





        $groups_class=new groups();
        $stmt = $groups_class->getAllBaseCategoriesByRelid(0);
        $arraySubCat = array();
        foreach ($stmt as $rowCat) {
            $arraySubCat[] = $rowCat['id'];
        }
        $arraygroupsAllCat = array();
        if (!empty($arraySubCat))
        {
            $allgroupsCat = $groups_class->getAllgroupsFromContent($arraySubCat, 15);

            while ($rowData = $allgroupsCat->fetch()) {

                if ( $rowData['img'] !=0) {
                    $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $rowData['img'], ':module' => 'groups'));
                    $get_file = $get_file[0];

                    if ($get_file['file_type']=='image')
                    {
                        if (file_exists($this->root_file.'thump_'.$get_file['rand_name']))
                        {
                            $rowData['img'] = $this->save_file.'thump_'.$get_file['rand_name'];
                        }else
                        {
                            $rowData['img'] = $this->save_file.$get_file['rand_name'];
                        }
                    }else{
                        $rowData['img'] =$this->static_file_control.'/image/admin/video.jpg';
                    }

                }else
                {
                    $rowData['img']=$this->static_file_control.'/image/admin/default.png';
                }


                $arraygroupsAllCat[] = $rowData;

            }

        }
        $arraygroupsAllCat=array_chunk($arraygroupsAllCat,4);




        $ads =new Ads();
        $stmt_ads=$ads->getAllADS();
        $ads_content =array();
        foreach (   $stmt_ads as $row)
        {
            if ( $row['img'] !=0) {
                $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row['img'], ':module' => 'ads'));
                $get_file = $get_file[0];
                if (file_exists($this->root_file.'thump_'.$get_file['rand_name']))
                {
                    $row['img'] = $this->save_file.$get_file['rand_name'];
                }else
                {
                    $row['img'] = $this->save_file.$get_file['rand_name'];
                }
            }else
            {
                $row['img']=$this->static_file_control.'/image/admin/default.png';
            }
            $row['date']=date('Y-m-d',$row['date']);

            $ads_content[]=$row;
        }




     /*   $offers =new offers();
        $stmt_offers=$offers->getAlloffers();
        $offers_content =array();
        foreach (   $stmt_offers as $row)
        {
            if ( $row['img'] !=0) {
                $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row['img'], ':module' => 'offers'));
                $get_file = $get_file[0];
                if (file_exists($this->root_file.'thump_'.$get_file['rand_name']))
                {
                    $row['img'] = $this->save_file.'thump_'.$get_file['rand_name'];
                }else
                {
                    $row['img'] = $this->save_file.$get_file['rand_name'];
                }
            }else
            {
                $row['img']=$this->static_file_control.'/image/admin/default.png';
            }
            $row['date']=date('Y-m-d',$row['date']);

            $offers_content[]=$row;
        }
*/



        $gallery_Class=new Gallery();
        $gallery=array();
        $stmtCat=$gallery_Class->getCatg(1);
        if ($stmtCat->rowCount() > 0)
        {
            $result=$stmtCat->fetch(PDO::FETCH_ASSOC);
            $stmtg=$gallery_Class->getAllImage($result['id'],5);
            while ($row =$stmtg->fetch(PDO::FETCH_ASSOC))
            {
                $row['image']=$this->save_file.$row['rand_name'];
                $gallery[]=$row;
            }
        }

     $gallery2=array();
        $stmtCat=$gallery_Class->getCatg(2);
        if ($stmtCat->rowCount() > 0)
        {
            $result=$stmtCat->fetch(PDO::FETCH_ASSOC);
            $stmtg=$gallery_Class->getAllImage($result['id'],3);
            while ($row =$stmtg->fetch(PDO::FETCH_ASSOC))
            {
                $row['image']=$this->save_file.$row['rand_name'];
                $gallery2[]=$row;
            }
        }


     $gallery3=array();
        $stmtCat=$gallery_Class->getCatg(3);
        if ($stmtCat->rowCount() > 0)
        {
            $result=$stmtCat->fetch(PDO::FETCH_ASSOC);
            $stmtg=$gallery_Class->getAllImage($result['id'],3);
            while ($row =$stmtg->fetch(PDO::FETCH_ASSOC))
            {
                $row['image']=$this->save_file.$row['rand_name'];
                $gallery3[]=$row;
            }
        }


     $gallery4=array();
        $stmtCat=$gallery_Class->getCatg(4);
        if ($stmtCat->rowCount() > 0)
        {
            $result=$stmtCat->fetch(PDO::FETCH_ASSOC);
            $stmtg=$gallery_Class->getAllImage($result['id'],3);
            while ($row =$stmtg->fetch(PDO::FETCH_ASSOC))
            {
                $row['image']=$this->save_file.$row['rand_name'];
                $gallery4[]=$row;
            }
        }


     $gallery5=array();
        $stmtCat=$gallery_Class->getCatg(5);
        if ($stmtCat->rowCount() > 0)
        {
            $result=$stmtCat->fetch(PDO::FETCH_ASSOC);
            $stmtg=$gallery_Class->getAllImage($result['id'],3);
            while ($row =$stmtg->fetch(PDO::FETCH_ASSOC))
            {
                $row['image']=$this->save_file.$row['rand_name'];
                $gallery5[]=$row;
            }
        }


     $galler6=array();
        $stmtCat=$gallery_Class->getCatg(6);
        if ($stmtCat->rowCount() > 0)
        {
            $result=$stmtCat->fetch(PDO::FETCH_ASSOC);
            $stmtg=$gallery_Class->getAllImage($result['id'],3);
            while ($row =$stmtg->fetch(PDO::FETCH_ASSOC))
            {
                $row['image']=$this->save_file.$row['rand_name'];
                $gallery6[]=$row;
            }
        }


        $gallery7=array();
        $stmtCat=$gallery_Class->getCatg(7);
        if ($stmtCat->rowCount() > 0)
        {
            $result=$stmtCat->fetch(PDO::FETCH_ASSOC);
            $stmtg=$gallery_Class->getAllImage($result['id'],3);
            while ($row =$stmtg->fetch(PDO::FETCH_ASSOC))
            {
                $row['image']=$this->save_file.$row['rand_name'];
                $gallery7[]=$row;
            }
        }

        $gallery8=array();
        $stmtCat=$gallery_Class->getCatg(8);
        if ($stmtCat->rowCount() > 0)
        {
            $result=$stmtCat->fetch(PDO::FETCH_ASSOC);
            $stmtg=$gallery_Class->getAllImage($result['id'],3);
            while ($row =$stmtg->fetch(PDO::FETCH_ASSOC))
            {
                $row['image']=$this->save_file.$row['rand_name'];
                $gallery8[]=$row;
            }
        }




  /*      $parts_class=new parts();
        $stmt = $parts_class->getAllBaseCategoriesByRelid(0);
        $arraySubCat = array();
        foreach ($stmt as $rowCat) {
            $arraySubCat[] = $rowCat['id'];
        }
        $arraypartsAllCat = array();
        if (!empty($arraySubCat))
        {
            $allpartsCat = $parts_class->getAllpartsFromContent($arraySubCat, 15);

            while ($rowData = $allpartsCat->fetch()) {

                if ( $rowData['img'] !=0) {
                    $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $rowData['img'], ':module' => 'parts'));
                  if (!empty($get_file[0]))
                  {


                    $get_file = $get_file[0];

                    if ($get_file['file_type']=='image')
                    {
                        if (file_exists($this->root_file.'thump_'.$get_file['rand_name']))
                        {
                            $rowData['img'] = $this->save_file.'thump_'.$get_file['rand_name'];
                        }else
                        {
                            $rowData['img'] = $this->save_file.$get_file['rand_name'];
                        }
                    }else{
                        $rowData['img'] =$this->static_file_control.'/image/admin/video.jpg';
                    }
                  }else
                  {
                      $rowData['img'] =$this->static_file_control.'/image/admin/video.jpg';

                  }

                }else
                {
                    $rowData['img']=$this->static_file_control.'/image/admin/default.png';
                }


                $arraypartsAllCat[] = $rowData;

            }

        }
*/

        $stmtCard=$this->db->prepare("SELECT * from  `category_medical_supplies` WHERE  `active` = 1  ");
        $stmtCard->execute();
        $data=array();
        while ($rowC = $stmtCard->fetch(PDO::FETCH_ASSOC))
        {


            if ( $rowC['img'] !=0) {
                $get_fileC = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $rowC['img'], ':module' =>   'medical_supplies_cat'));
                $get_fileC = $get_fileC[0];

                $rowC['image'] = $this->save_file.$get_fileC['rand_name'];

            }else
            {
                $rowC['image']=$this->static_file_control.'/image/admin/default.png';
            }
            $data[]=$rowC;

        }
        $data=array_chunk($data,3);



        $medical_supplies=new medical_supplies();




        require ($this->render($this->folder,'html','index','php'));
        $this->publicFooter();

    }


    public function index2()
    {

        $this->publicHeader($this->langControl('title_website'));


        require ($this->render($this->folder,'html','index2','php'));


        $this->publicFooter();


    }




}