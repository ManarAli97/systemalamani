<?php

class comparison extends Controller
{

    public $ids = array();


    function __construct()
    {
        parent::__construct();
        $this->table = 'mobile';
        $this->category = 'category_mobile';
        $this->color = 'color';
        $this->code = 'code';
        $this->excel = 'excel';
        $this->cart_shop_active = 'cart_shop_active';
        $this->like_mobile = 'like_mobile';
        $this->comparison = 'comparison';
        $this->menu = new Menu();

        $this->setting = new Setting();
        $this->mobile = new Mobile();
    }


    public function index()
    {

        if (isset($_SESSION['username_member_r'])) {

            $id_r = $_SESSION['id_member_r'];

            $stmt=$this->db->prepare("SELECT `id_device` FROM {$this->comparison} WHERE `id_member_r`= ? ");
            $stmt->execute(array($id_r));
            $id_item=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $id_item[]=$row['id_device']  ;
            }

             $Id_item = implode(',', $id_item);

            $stmt=$this->db->prepare("SELECT *FROM {$this->table} WHERE `id`   IN ({$Id_item})  ");
            $stmt->execute();


            $g_c_content=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


                $g_c = $this->db->prepare("SELECT *FROM `{$this->color}` WHERE   `id_item`  = ?  ");
                $g_c->execute(array($row['id']));
                while ($color = $g_c->fetch(PDO::FETCH_ASSOC)) {

                    $stmt_price = $this->mobile->getPrice($color['id'], 1,$row['price_dollars']);
                    $smt_ch_q = $this->mobile->smt_ch_q($stmt_price['code']);
                    if ($smt_ch_q->rowCount() > 0) {
                        $g_c = $this->db->prepare("SELECT `img` FROM `{$this->color}` WHERE   `id_item`  = ? LIMIT 1 ");
                        $g_c->execute(array($row['id']));
                        $row['image'] = $this->show_file_site.$g_c->fetch(PDO::FETCH_ASSOC) ['img'];

                        $g_c_content[] = $row;
                    }

                }



            }


            require($this->render($this->folder, 'html', 'index', 'php'));
        } else {
            require($this->render('register', 'html', 'login', 'php'));
        }
    }



    function this_comp()
    {



        if (isset($_SESSION['username_member_r'])) {

            $id_r = $_SESSION['id_member_r'];
            $g_c_content=array();
            if (isset($_POST['id_comp_item']))
            {
                $id_item=$_POST['id_comp_item'];

                if (!empty($id_item)) {


                    foreach ($id_item as $x) {
                        if (!is_numeric(abs($x))) {
                            die('fuck you ☻');
                        }
                    }


                    $Id_item = implode(',', $id_item);

                    $stmt = $this->db->prepare("SELECT *FROM {$this->table} WHERE `id`   IN ({$Id_item})  ");
                    $stmt->execute();


                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                        $row['color'] = array();
                        $row['id_color'] = 0;
                        $c = 0;
                        $g_c = $this->db->prepare("SELECT *FROM `{$this->color}` WHERE   `id_item`  = ?  ");
                        $g_c->execute(array($row['id']));
                        while ($color = $g_c->fetch(PDO::FETCH_ASSOC)) {

                            $stmt_price = $this->mobile->getPrice($color['id'], 1,$row['price_dollars']);
                            $smt_ch_q = $this->mobile->smt_ch_q($stmt_price['code']);
                            if ($smt_ch_q->rowCount() > 0) {

                                if ($c == 0) {
                                    $row['id_color'] = $color['id'];
                                }
                                $row['color'][] = $color;
                                $c++;
                            }

                        }

                        $g_c_content[] = $row;
                    }


                }
            }

            require($this->render($this->folder, 'html', 'data', 'php'));
        } else {
            require($this->render('register', 'html', 'login', 'php'));
        }



    }

function  break_row_comp($id)
{
    if (is_numeric(abs($id)))
    {
        if (isset($_SESSION['username_member_r'])) {

            $id_r = $_SESSION['id_member_r'];
            $g_c= $this->db->prepare("DELETE  FROM `{$this->comparison}` WHERE  `id_member_r`= ?  AND `id_device`  = ?  ");
            $g_c->execute(array($id_r,$id));
          echo 'true';
        }
    }


    }

}































