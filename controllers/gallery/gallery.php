<?php

class Gallery extends Controller
{


    function __construct()
    {
        parent::__construct();
        $this->table='gallery';
        $this->category='galleryCategory';
    }

    public function createTB()
    {


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
         `id` bigint(20) NOT NULL AUTO_INCREMENT,
         `id_cat` int(20) NOT NULL,
          `module` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `normal_name` text COLLATE utf8_unicode_ci NOT NULL,
          `rand_name` text COLLATE utf8_unicode_ci NOT NULL,
          `relid` bigint(20) NOT NULL,
          `description` longtext COLLATE utf8_unicode_ci NOT NULL,
          `ext` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `file_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `file_size` bigint(20) NOT NULL,
           `active` int(10) NOT NULL DEFAULT '0',
          `lang` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
          `userid` int(11) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->category}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `img` int(10) NOT NULL,
           `relid` INT (10) NOT NULL,
           `active` int(10) NOT NULL DEFAULT '0',
           `lang` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
           `userid` int(11) NOT NULL,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        return  $this->db->cht(array($this->table, $this->category));


    }

    public function index(){ $index =new Index(); $index->index();}

    public function admin_category($id=0)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $this->checkPermit('View_category','video');
        $this->adminHeaderController($this->langControl('video'),$id);
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);

        $data=$this->db->select("SELECT * from  {$this->category} WHERE  `relid` = {$id} AND `lang`='{$this->langControl}'");
      foreach ($data as $key => $dt)
      {

          $data[$key]['checked']= ($dt['active']==1) ? 'checked' : null ;
          if ($dt['img'] !=0) {
              $data[$key]['img'] = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module AND `lang`='{$this->langControl}' LIMIT 1 ", array(':id' => $dt['img'], ':module' => $this->folder.'_cat'));
              $data[$key]['image'] = $this->save_file.$data[$key]['img'][0]['rand_name'];
              $data[$key]['type_file'] = $data[$key]['img'][0]['file_type'];
              unset($data[$key]['img']);
          } else
              {
                  $data[$key]['image']=$this->static_file_control.'/image/admin/default.png';
              }


      }

        require ($this->render($this->folder,'cat','admin_category','php'));
        $this->adminFooterController();

    }


    public function list_gallery($id,$p=1)
    {

        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        $page=$p;
        $this->checkPermit('view_gallery','gallery');
        $this->adminHeaderController($this->langControl('view_gallery'));
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);

        $data_cat=$this->db->select("SELECT * from  `{$this->category}` WHERE `lang`='{$this->langControl}'");
        foreach ($data_cat as $key => $d_cat)
        {


            if ($d_cat['id']  == $id)
            {
                $d_cat['selected']='selected';

            }else
            {
                $d_cat['selected']=null;
            }
            $data_cat[$key]=$d_cat;
        }

        $count=0;
        $data=$this->db->select("SELECT * from `{$this->table}` WHERE `id_cat`=:id_cat AND `lang`='{$this->langControl}'",array('id_cat'=>$id));

        $arr_c=array_chunk($data,10);
         $count=count($arr_c);
        $public=null;
        $stmt=$this->db->prepare("SELECT * from `{$this->table}` WHERE `active`=? AND `lang`='{$this->langControl}'");
        $stmt->execute(array(1));
        if ($stmt->rowCount())
        {
            $public='checked';
        }

         require ($this->render($this->folder,'html','list_gallery','php'));
        $this->adminFooterController();

    }

  public  function ajax($id_cat=null,$page=0)
    {

        if (!is_numeric($id_cat) && !is_numeric($page)  ) {$error=new Errors(); $error->index();}
        $page=$page*10-10;
         $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE  `id_cat`={$id_cat} AND `lang`='{$this->langControl}' ORDER BY `id` DESC LIMIT 10 OFFSET $page");
         $stmt->execute();
        $data=array();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key => $dt) {

            if ($dt['active'] == 0)
            {
               $dt['opacity']='0.2';
            }else
            {
                $dt['opacity']='1';
            }
            $dt['checked'] = ($dt['active'] == 1) ? 'checked' : null;
        $data[]=$dt;
        }




        require ($this->render($this->folder,'html','ajax','php'));
    }




    public  function view_image($id=0,$page=1)
    {
        if (!is_numeric($id) && !is_numeric($page)  ) {$error=new Errors(); $error->index();}

        $stmt=$this->db->prepare("SELECT *FROM `{$this->category}`  WHERE `active` = 1 AND `lang`='{$this->langControl}'");
        $stmt->execute();
        $category=array();
        $c=0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            if ($id==0 && $c == 0)
            {
                $id=$row['id'];
                $row['active']='active';
            }
            else if ($row['id']==$id)
            {
                $row['active']='active';
            }
            else
            {
                $row['active']='';
            }

            $category[]=$row;
        $c++;
        }

        $stmt=$this->db->prepare("SELECT *FROM `{$this->category}`  WHERE `active` = 1 AND `id`=? AND `lang`='{$this->langControl}'");
        $stmt->execute(array($id));
        $result= $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt_img=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE `id_cat`=? AND `active` = ?  AND `lang`='{$this->langControl}'");
        $stmt_img->execute(array($id,1));
        $images=array();
           while ($row_img =$stmt_img->fetch(PDO::FETCH_ASSOC))
           {
               $images[]=$row_img;
           }

        $images=array_chunk($images,9);
           $count=count($images);
        $images=$images[$page-1];





        require ($this->render($this->folder,'html','view_image','php'));

    }





  public  function edit_image($id=null)
    {

        if ($this->handleLogin())
        {
            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            $title=$_POST['title'];
            $description=$_POST['description'];
            $url=$_POST['url'];
            $stmt=$this->db->update($this->table,array('normal_name'=>$title,'description'=>$description,'url'=>$url),"id={$id} AND `lang`='{$this->langControl}'");

        }

    }


    function upload_image($id=null)
    {


        $setting=new Setting();
        if (isset($_FILES['image'])) {
            $errors = array();
            $image = array();

            for ($i = 0; $i < count($_FILES["image"]["name"]); $i++) {
                $file_name = $_FILES['image']['name'][$i];
                $file_size = $_FILES['image']['size'][$i];
                $file_tmp = $_FILES['image']['tmp_name'][$i];
                $file_type = $_FILES['image']['type'][$i];
                $save_file = $this->root_file;
                @mkdir("$save_file", 0755);
                $temp = explode(".", $file_name);
                $extension = strtolower(end($temp));
                $file_type = explode("/", $file_type);
                $file_name_new = md5(mt_rand(0, time())) . "_." . $extension;
                  $stmt=$this->db->prepare("INSERT INTO `{$this->table}` (`id_cat`,`normal_name`,`rand_name`,`ext`,`file_type`,`file_size`,`lang`,`userid`,`date`) VALUES  (?,?,?,?,?,?,?,?,?) ");
                  $stmt->execute(array($id,$temp[0], $file_name_new,$extension,$file_size,$file_type[0],$this->langControl,$this->userid,time()));
                    if ($stmt->rowCount() > 0 )
                    {
                        move_uploaded_file($file_tmp, $save_file . "/" . $file_name_new);
                        if(in_array(strtolower($extension),array('png','jpg','jpeg','gif')))
                        {
                            $this->smart_resize_image($this->root_file.$file_name_new,$this->root_file.'thump_'.$file_name_new,null,$setting->get('width',1800) ,$setting->get('height',1600),$setting->get('proportional',1),'file',false,false,  $setting->get('quality',75) , $setting->get('grayscale',0) );
                        }
                    }
                }

            echo 1;

        }
    }


    /**
     * easy image resize function
     * @param  $file - file name to resize
     * @param  $string - The image data, as a string
     * @param  $width - new image width
     * @param  $height - new image height
     * @param  $proportional - keep image proportional, default is no
     * @param  $output - name of the new file (include path if needed)
     * @param  $delete_original - if true the original image will be deleted
     * @param  $use_linux_commands - if set to true will use "rm" to delete the image, if false will use PHP unlink
     * @param  $quality - enter 1-100 (100 is best quality) default is 100
     * @param  $grayscale - if true, image will be grayscale (default is false)
     * @return boolean|resource
     */
    function smart_resize_image($file,
                                $file_new_neme,
                                $string             = null,
                                $width              = 0,
                                $height             = 0,
                                $proportional       = false,
                                $output             = 'file',
                                $delete_original    = true,
                                $use_linux_commands = false,
                                $quality            = 100,
                                $grayscale          = false
    ) {

        if ( $height <= 0 && $width <= 0 ) return false;
        if ( $file === null && $string === null ) return false;

        # Setting defaults and meta
        $info                         = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
        $image                        = '';
        $final_width                  = 0;
        $final_height                 = 0;
        list($width_old, $height_old) = $info;
        $cropHeight = $cropWidth = 0;

        # Calculating proportionality
        if ($proportional) {
            if      ($width  == 0)  $factor = $height/$height_old;
            elseif  ($height == 0)  $factor = $width/$width_old;
            else                    $factor = min( $width / $width_old, $height / $height_old );

            $final_width  = round( $width_old * $factor );
            $final_height = round( $height_old * $factor );
        }
        else {
            $final_width = ( $width <= 0 ) ? $width_old : $width;
            $final_height = ( $height <= 0 ) ? $height_old : $height;
            $widthX = $width_old / $width;
            $heightX = $height_old / $height;

            $x = min($widthX, $heightX);
            $cropWidth = ($width_old - $width * $x) / 2;
            $cropHeight = ($height_old - $height * $x) / 2;
        }

        # Loading image to memory according to type
        switch ( $info[2] ) {
            case IMAGETYPE_JPEG:  $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);  break;
            case IMAGETYPE_GIF:   $file !== null ? $image = imagecreatefromgif($file)  : $image = imagecreatefromstring($string);  break;
            case IMAGETYPE_PNG:   $file !== null ? $image = imagecreatefrompng($file)  : $image = imagecreatefromstring($string);  break;
            default: return false;
        }

        # Making the image grayscale, if needed
        if ($grayscale) {
            imagefilter($image, IMG_FILTER_GRAYSCALE);
        }

        # This is the resizing/resampling/transparency-preserving magic
        $image_resized = imagecreatetruecolor( $final_width, $final_height );
        if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
            $transparency = imagecolortransparent($image);
            $palletsize = imagecolorstotal($image);

            if ($transparency >= 0 && $transparency < $palletsize) {
                $transparent_color  = imagecolorsforindex($image, $transparency);
                $transparency       = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                imagefill($image_resized, 0, 0, $transparency);
                imagecolortransparent($image_resized, $transparency);
            }
            elseif ($info[2] == IMAGETYPE_PNG) {
                imagealphablending($image_resized, false);
                $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
                imagefill($image_resized, 0, 0, $color);
                imagesavealpha($image_resized, true);
            }
        }
        imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);


        # Taking care of original, if needed
        if ( $delete_original ) {
            if ( $use_linux_commands ) exec('rm '.$file);
            else @unlink($file);
        }

        # Preparing a method of providing result
        switch ( strtolower($output) ) {
            case 'browser':
                $mime = image_type_to_mime_type($info[2]);
                header("Content-type: $mime");
                $output = NULL;
                break;
            case 'file':
                $output = $file_new_neme;
                break;
            case 'return':
                return $image_resized;
                break;
            default:
                break;
        }

        # Writing image according to type to the output destination and image quality
        switch ( $info[2] ) {
            case IMAGETYPE_GIF:   imagegif($image_resized, $output);    break;
            case IMAGETYPE_JPEG:  imagejpeg($image_resized, $output, $quality);   break;
            case IMAGETYPE_PNG:
                $quality = 9 - (int)((0.9*$quality)/10.0);
                imagepng($image_resized, $output, $quality);
                break;
            default: return false;
        }

        return true;
    }





    public function add_gallery($id)
    {

        if (!is_numeric($id)){  $error=new Errors();  $error ->index();}
        $this->checkPermit('add_gallery','gallery');
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);
        $this->adminHeaderController($this->langControl('add_gallery'),$id);

        require ($this->render($this->folder,'html','add','php'));
        $this->adminFooterController();

    }


    public function select_category_gallery($id)
    {
        $stmt=$this->db->prepare("SELECT * from  `{$this->category}` WHERE `relid`=? AND `lang`='{$this->langControl}'");
        $stmt->execute(array($id));
        return $stmt;
    }

    public function ck_sub_cat($id)
    {
        $stmt=$this->db->prepare("SELECT * from  {$this->category} WHERE `relid`=? AND `lang`='{$this->langControl}'");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            return true;
        }else
        {
            return false;
        }
    }

    public function listSubCategory($relid,$id=null)
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->category}` WHERE relid = ? AND `lang`='{$this->langControl}'");
        $stmt->execute(array($relid));
        while ($row = $stmt->fetch()) {
            require ($this->render($this->folder,'html','sub_cat','php'));
        }
    }



    public function sub_cat_active($r_id,$id=null)
    {
        if ($id==null)
        {
            return 'close_this_gallery';
        }
        $stmt=$this->db->prepare("SELECT * from  `$this->category`  WHERE `id`=? AND `lang`='{$this->langControl}'");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            $result=$stmt->fetchAll();
            $result=$result[0];
            if ($r_id==$id || $result['relid'] == $r_id)
            {

                return 'gallery';
            }
            else
            {
                return 'close_this_gallery';
            }

        }
        else
        {
            return 'close_this_gallery';
        }

    }



//-----------------category------------------


    function add_category($id=0)
    {


        $this->checkPermit('add_category','gallery');
        if (!is_numeric($id)){  $error=new Errors();  $error ->index();}
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);
        $this->adminHeaderController($this->langControl('category'),$id);


        $data['title']='';
        $data['files']='';
        $data['index']='';

        if (isset($_POST['submit']))
        {
            try{
                $form =new Form();
                $form  ->post('title')
                    ->val('is_empty',$this->langControl('the_title_field_is_empty'))
                    ->val('strip_tags');
                $form  ->post('files')
                    ->val('strip_tags');

                $form  ->post('index')
                    ->val('strip_tags');

                $form ->submit();
                $data =$form -> fetch();
                $data['relid']=$id;
                $data['lang']=$this->langControl;
                $data['userid']=$this->userid;
                $data['date']=time();
                $file=new Files();

                $this->db->insert($this->category,array_diff_key($data,['files'=>"delete"]));

                if(!empty($data['files'])) {
                    $img = $file->insert_file($this->folder.'_cat', $this->db->lastInsertId(), json_decode($data['files'], True));
                    $this->db->update($this->category, array('img' => $img), "id={$this->db->lastInsertId()}");
                }


                $this->lightRedirect(url.'/'.$this->folder.'/admin_category',0);
            }

            catch (Exception $e)
            {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();
            }

        }



        require ($this->render($this->folder,'cat','add','php'));
        $this->adminFooterController();

    }





    function edit_category($id)
    {
        $this->checkPermit('edit_category','gallery');
        $data=$this->db->select("SELECT * from `{$this->category}` WHERE `id`=:id AND `lang`='{$this->langControl}' LIMIT 1 ",array(':id'=>$id));
        $data=$data[0];
        $breadcumbs = $this ->Breadcumbs( $this->category,$id);
        $this->adminHeaderController($data['title'],$id);
        $idImg=0;
        if ( $data['img'] !=0) {
            $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND  `module`=:module AND `lang`='{$this->langControl}' LIMIT 1 ", array(':id' => $data['img'], ':module' => $this->folder.'_cat'));
            $get_file = $get_file[0];
            $idImg = $get_file['id'];
        }
        if (isset($_POST['submit']))
        {

            try
            {
                $form =new Form();
                $form ->post('title')
                    ->val('is_empty',$this->langControl('the_title_field_is_empty'))
                    ->val('strip_tags');
                $form ->post('files')
                    ->val('strip_tags');
                $form  ->post('index')
                    ->val('strip_tags');


                $form ->submit();
                $data =$form -> fetch();
                if (!empty($data['files']))
                {
                    if ($idImg != 0)
                    {
                        @unlink($this->root_file.$get_file['rand_name']);
                        $this->db->delete('files',"id={$get_file['id']}");
                    }
                    $file=new Files();
                    $data['img']= $file->insert_file( $this->folder.'_cat',$id,json_decode($data['files'],True));
                }
                else
                {
                    $data['img']=$idImg;
                }
                if ($this->permit('save_edit_catg',$this->folder)) {
                    $this->db->update($this->category, array_diff_key($data, ['files' => "delete"]), "id={$id}");

                    $this->lightRedirect(url . '/' . $this->folder . '/admin_category', 0);
                }

            }
            catch (Exception $e)
            {

                $this->error_form=$e -> getMessage();
             }
        }
        require ($this->render($this->folder,'cat','edit','php'));
        $this->adminFooterController();
    }


    public function visible($v_,$id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v=$v_;$id=$id_;
        } else {
            $v = 0;$id = 0;
        }
        $data = $this->db->update($this->category,array('active'=>$v), "`id`={$id} AND `lang`='{$this->langControl}'");
    }


    public function active_image($v_,$id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v=$v_;$id=$id_;
        } else {
            $v = 0;$id = 0;
        }
        $data = $this->db->update($this->table,array('active'=>$v), "`id`={$id} AND `lang`='{$this->langControl}'");
    }



    public function active_all_image($v_)
    {
        if (is_numeric($v_)) {
            $v=$v_;
        } else {
            $v = 0;
        }
        $data = $this->db->update($this->table,array('active'=>$v),"`lang`='{$this->langControl}'" );
    }



    function delete($id)
    {
        if ($this->handleLogin()) {
            $response = $this->db->delete($this->category, "`id`={$id} AND `lang`='{$this->langControl}'");
        }

    }



    function getImageById($id)
    {
        $data = $this->db->select("SELECT * from `{$this->table}` WHERE `id`=:id AND `lang`='{$this->langControl}'", array(':id' => $id));
       if (!empty($data))
       {
             $data= $data[0] ;
       echo json_encode($data);
       }
       else
       {
           exit();
       }

    }




    public function delete_image($id)
    {
        if ($this->handleLogin()) {
            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            $data = $this->db->select("SELECT * from `{$this->table}` WHERE `id`=:id AND `lang`='{$this->langControl}'", array(':id' => $id));
            $delete = $this->db->delete($this->table, "id={$id} AND `lang`='{$this->langControl}'");
            @unlink($this->root_file . $data[0]['rand_name']);
            echo $data[0]['rand_name'];
        }
    }



    function delete_image_cat($id)
    {
        if ($this->handleLogin()) {
            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            $response = $this->db->update($this->category, array('img' => 0), "`id`={$id} AND `lang`='{$this->langControl}'");
        }
    }




    function getCatg($index)
    {
        if (!is_numeric($index))
        {
            $index=1;
        }

        $stmt=$this->db->prepare("SELECT *FROM `$this->category` WHERE `active`=1  AND `index`= ?   LIMIT 1 ");
        $stmt->execute(array($index));
        return $stmt;
    }



    function getAllImage($id,$limit)
    {
        $stmt=$this->db->prepare("SELECT *FROM `$this->table` WHERE `active`=1  AND  `id_cat` = ?  ORDER BY `id` DESC LIMIT {$limit} ");
        $stmt->execute(array($id));
        return $stmt;
    }



}