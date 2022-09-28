<?php

class Permit extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'permitgroup';
        $this->permit = 'permit';
    }





    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
         `id` int(11) NOT NULL AUTO_INCREMENT,
         `aclname` text COLLATE utf8_unicode_ci NOT NULL,
         `aclgroup` text COLLATE utf8_unicode_ci NOT NULL,
         `lang` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
         `userid` int(11) NOT NULL,
          PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->permit}` (
           `id` int(11) NOT NULL AUTO_INCREMENT,
           `idGroup` bigint(20) NOT NULL ,
           `idParmit` int(11) NOT NULL  ,
           `permit` int(11) NOT NULL DEFAULT '0',
           `lang` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
           `userid` int(11) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table, $this->permit));


    }



    function admin_permit($id_group=null)
    {

        $this->adminHeaderController('تصاريح المجموعة');

        $data = $this->db->select("SELECT * from  `usergroup` WHERE `id`=:id",array(':id'=>$id_group));
         //return only distinct (different) values.
        $stmt = $this->db->query("SELECT DISTINCT `aclgroup` as groupName  FROM {$this->table} ");

        $permitGroups=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
             $row['statement_group']=array();

           $stmt_g=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE `aclgroup`=?");
           $stmt_g ->execute(array($row['groupName']));
           while ($row_gp = $stmt_g->fetch(PDO::FETCH_ASSOC))
           {
               $row_gp['checked']=$this->checkPermit_true_or_false($id_group,$row_gp['id']);
               $row['statement_group'][]=$row_gp;
           }

            $permitGroups[] = $row;
        }

        require ($this->render($this->folder,'html','admin_permit','php'));
        $this->adminFooterController();

    }
    /**
     *  هاي الدالة نسخة معدلة عن الفوك
     * فكرتها انه تنطي صلاحيات خاصة بالموظف نفسه
     */
    function admin_permit_user($id_user=null)
    {

        $this->adminHeaderController('تصاريح المجموعة');

        $data = $this->db->select("SELECT * from  `user` WHERE `id`=:id",array(':id'=>$id_user));
         //return only distinct (different) values.
        $stmt = $this->db->query("SELECT DISTINCT `aclgroup` as groupName  FROM  {$this->table} ");

        $permitGroups=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
             $row['statement_group']=array();

           $stmt_g=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE `aclgroup`=?");
           $stmt_g ->execute(array($row['groupName']));
           while ($row_gp = $stmt_g->fetch(PDO::FETCH_ASSOC))
           {
               $row_gp['checked']=$this->checkPermit_true_or_false($id_user,$row_gp['id'],'permit_user');
               $row['statement_group'][]=$row_gp;
           }

            $permitGroups[] = $row;
        }

        require ($this->render($this->folder,'html','admin_permit_user','php'));
        $this->adminFooterController();

    }

    //  $table_permit هذا اضافة حتى نميز هل الجيك لصلاحيات المجموعة او اليوزر بشكل خاص
    public function checkPermit_true_or_false($id_group,$idParmit,$table_permit='permit')
    {
        // لان العمود يختلف باسمه فسويت هذا  حتىنسوي الشرط على اساسة
        $culomn_id_group='idGroup';
        if($table_permit=='permit_user')
        {
            $culomn_id_group='id_user';
        }
        $stmt=$this->db->prepare("SELECT *FROM `$table_permit` WHERE `$culomn_id_group`=? AND `idParmit`=? AND `permit`=?");
        $stmt ->execute(array($id_group,$idParmit,1));
        if ($stmt->rowCount()>0)
        {
            return 'checked';
        }else
        {
            return null;
        }
    }


    public function activPermit($vis,$idGroup,$idParmit)
    {
        $stmt=$this->db->prepare("SELECT *FROM `{$this->permit}` WHERE `idGroup`=? AND `idParmit`=?");
        $stmt->execute(array($idGroup,$idParmit));
        if ($stmt->rowCount()>0)
        {


            $stmt=$this->db->prepare("UPDATE  `{$this->permit}` SET  `permit`=? WHERE `idGroup`=? AND `idParmit`=?");
            $stmt->execute(array($vis,$idGroup,$idParmit));
            if($stmt->rowCount()>0)
            {
                return true;
            }

        }
        else
        {
           $stmt=$this->db->insert($this->permit,array('idGroup'=>$idGroup,'idParmit'=>$idParmit,'permit'=>$vis));
       if ($stmt)
       {
           return true;
       }else
       {
           return false;
       }
        }

    }
    /*
    *  دالة تحديث صلاحيات المستخدم
    *
    */
    public function activPermit_user($vis,$idGroup,$idParmit)
    {
        $stmt=$this->db->prepare("SELECT *FROM `permit_user` WHERE `id_user`=? AND `idParmit`=?");
        $stmt->execute(array($idGroup,$idParmit));
        if ($stmt->rowCount()>0)
        {


            $stmt=$this->db->prepare("UPDATE  `permit_user` SET  `permit`=? WHERE `id_user`=? AND `idParmit`=?");
            $stmt->execute(array($vis,$idGroup,$idParmit));
            if($stmt->rowCount()>0)
            {
                return true;
            }

        }
        else
        {
            $stmt=$this->db->insert('permit_user',array('id_user'=>$idGroup,'idParmit'=>$idParmit,'permit'=>$vis));
            if ($stmt)
            {
                return true;
            }else
            {
                return false;
            }
        }

    }




}

?>