<?php

class specifications extends Controller
{


    function __construct()
    {
        parent::__construct();
        $this->table = 'specifications';
        $this->specifications_item = 'specifications_item';
    }

    public function createTB()
    {


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `active` int(10) NOT NULL DEFAULT '0',
          `lang` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->specifications_item}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
          `item` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `id_specif` int(10) NOT NULL DEFAULT '0',
           PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        return $this->db->cht(array($this->table,$this->specifications_item));

    }

    public function index()
    {
        $this->checkPermit('list_specifications', 'specifications');
        $this->adminHeaderController($this->langControl('specifications'));



        require($this->render($this->folder, 'html', 'index', 'php'));
        $this->adminFooterController();
    }



      public function list_specifications($model)
    {
        $this->checkPermit('list_specifications', 'specifications');
        $this->adminHeaderController($this->langControl('specifications'));

        $stmt=$this->db->prepare("SELECT *FROM {$this->table} WHERE `model`=?");
        $stmt->execute(array($model));
        $specif=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $specif[]=$row;
        }


        require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();
    }




      public function add_specifications($model)
    {
        $this->checkPermit('add_specifications', 'specifications');
        $this->adminHeaderController($this->langControl('add'));



        if (isset($_POST['submit']))
        {
            try{
                $form =new Form();

                $form  ->post('title')
                    ->val('is_array','مطلوب');

                $form  ->post('item')
                    ->val('is_array','مطلوب');


                $form ->submit();
                $data =$form -> fetch();
                $file=new Files();

                $title=json_decode($data['title'],true);
                $item=json_decode($data['item'],true);

                foreach ($title as $key => $save_data)
                {
                    $stmt_s=$this->db->prepare("INSERT INTO `{$this->table}` (`title`,`model`,`lang`,`userId`,`date`) VALUE (?,?,?,?,?)");
                    $stmt_s->execute(array($save_data,$model,$this->langControl,$this->userid, time()));
                    if ($stmt_s->rowCount() > 0 ) {
                        $lastId_c=$this->db->lastInsertId();
                        foreach ($item[$key] as $index => $itm)
                        {
                            $stmt_cd=$this->db->prepare("INSERT INTO `{$this->specifications_item}` (`item`,`id_specif`) VALUE (?,?)");
                            $stmt_cd->execute(array($itm,$lastId_c));
                        }
                    }

                }




               $this->lightRedirect(url.'/'.$this->folder.'/list_specifications/'.$model,0);
            }

            catch (Exception $e)
            {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();
            }

        }

        require($this->render($this->folder, 'html', 'add', 'php'));
        $this->adminFooterController();
    }

      public function edit_specifications($id)
    {
        $this->checkPermit('edit_specifications', 'specifications');
        $this->adminHeaderController($this->langControl('edit'));

        $stmt=$this->db->prepare("SELECT *FROM {$this->table} WHERE `id`=?");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);



        $stmti=$this->db->prepare("SELECT *FROM {$this->specifications_item} WHERE `id_specif`=?");
        $stmti->execute(array($id));
        $specif=array();
        while ($row = $stmti->fetch(PDO::FETCH_ASSOC))
        {
            $specif[]=$row;
        }


        if (isset($_POST['submit']))
        {
            try{
                $form =new Form();

                $form  ->post('title')
                    ->val('is_empty','مطلوب');

                $form  ->post('item')
                    ->val('is_array','مطلوب');


                $form ->submit();
                $data =$form -> fetch();
                $file=new Files();


                $item=json_decode($data['item'],true);

                if ($this->permit('save_edit_catg',$this->folder)) {
                    $stmt = $this->db->prepare("UPDATE   `{$this->table}` SET  `title`=?   WHERE `id`=?");
                    $stmt->execute(array($data['title'], $id));

                    foreach ($item as $index => $itm) {

                        $stmt_cd = $this->db->prepare("INSERT INTO `{$this->specifications_item}` (`id`,`item`,`id_specif`) VALUE (?,?,?)  ON DUPLICATE KEY UPDATE `id`=VALUES(id),`item`=VALUES(item),`id_specif`=VALUES(id_specif)");
                        $stmt_cd->execute(array($index, $itm, $id));


                    }

                    $this->lightRedirect(url . '/' . $this->folder . '/list_specifications/' . $result['model'], 0);
                }

            }

            catch (Exception $e)
            {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();
            }

        }

        require($this->render($this->folder, 'html', 'edit', 'php'));
        $this->adminFooterController();
    }










    public function ch($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `active` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            return 'checked';
        }
        else
        {
            return '';
        }
    }



    public function visible_specifications($v_,$id_)
    {
        if ($this->handleLogin()) {
            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }
            $data = $this->db->update($this->table, array('active' => $v), "`id`={$id}");
        }
    }


    function delete_specifications($id)
    {
        if ($this->handleLogin()) {
            $response = $this->db->delete($this->table, "`id`={$id}");

            $c = $this->db->prepare("DELETE FROM  `$this->specifications_item`  WHERE  `id_specif`=?");
            $c->execute(array($id));


        }
    }

    function remove_sub_row_db($id)
    {
        if ($this->handleLogin()) {
            $response = $this->db->delete($this->specifications_item, "`id`={$id}");
        }
    }


}