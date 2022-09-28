<?php

class Files extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'files';
        $this->setting=new Setting();
    }


    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
         `id` bigint(20) NOT NULL AUTO_INCREMENT,
          `module` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `normal_name` text COLLATE utf8_unicode_ci NOT NULL,
          `rand_name` text COLLATE utf8_unicode_ci NOT NULL,
          `relid` bigint(20) NOT NULL,
          `description` longtext COLLATE utf8_unicode_ci NOT NULL,
          `ext` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `file_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `file_size` bigint(20) NOT NULL,
          `lang` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
          `userid` int(11) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table));


    }

    function insert_file($model, $id, $file = array())
    {

        if (!empty($file)) {
            $last_id = 1;
            foreach ($file as $key => $insert_file) {
                $this->db->insert('files', array('module' => $model, 'normal_name' => $insert_file['normal_name'],
                    'rand_name' => $insert_file['rand_name'], 'relid' => $id, 'ext' => $insert_file['ext'],
                    'file_size' => $insert_file['file_size'], 'file_type' => $insert_file['file_type'],'lang'=>$this->langControl,'userid'=>$this->userid));
                if ($key == 0) {
                    $last_id = $this->db->lastInsertId();
                }

            }
            return $last_id;
        }
    }


    function chk_img($module, $id)
    {
        $data = $this->db->select("SELECT * from `files` WHERE `relid`=:relid  AND  `module`=:module AND `lang`='{$this->langControl}'  LIMIT 1 ", array(':relid' => $id, 'module' => $module));

        if (empty($data)) {
            return true;
        } else {
            return false;
        }

    }

    function save_image()
    {

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
                $image[$i] = array('normal_name' => $temp[0], 'rand_name' => $file_name_new, 'ext' => $extension, 'file_size' => $file_size, 'file_type' => $file_type[0]);
                if(in_array(strtolower($extension),array('png','jpg','jpeg','gif',"avi", "flv", "swf", "m4v", "mkv", "mov", "mp4", "ogv", "wmv"))) {
                    move_uploaded_file($file_tmp, $save_file . "/" . $file_name_new);
                    if (in_array(strtolower($extension), array('png', 'jpg', 'jpeg')))
                    {
                        $this->smart_resize_image($this->root_file . $file_name_new, $this->root_file . 'thump_' . $file_name_new, null, $this->setting->get('width', 1800), $this->setting->get('height', 1600), $this->setting->get('proportional', 1), 'file', false, false, $this->setting->get('quality', 75), $this->setting->get('grayscale', 0),false);
                   }
                }
             }

            echo json_encode($image);

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
                                $grayscale          = false,
                                $watermark        = true
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


        // if overlay is needed

        if ($watermark) {
            $stamp = imagecreatefrompng(ROOT . "/public/{$this->langControl}/image/site/wm.png");

            $marge_right = 10;
            $marge_bottom = 10;
            $sx = imagesx($stamp);
            $sy = imagesy($stamp);

            $this->imagecopymerge_alpha($image_resized, $stamp, imagesx($image_resized) - $sx - $marge_right, imagesy($image_resized) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 100);
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





    function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
        // creating a cut resource
        $cut = imagecreatetruecolor($src_w, $src_h);

        // copying relevant section from background to the cut resource
        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);

        // copying relevant section from watermark to the cut resource
        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);

        // insert cut resource to destination image
        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
    }






    function save_files()
    {


        if (isset($_FILES['files'])) {
            $errors = array();
            $image = array();

            for ($i = 0; $i < count($_FILES["files"]["name"]); $i++) {
                $file_name = $_FILES['files']['name'][$i];
                $file_size = $_FILES['files']['size'][$i];
                $file_tmp = $_FILES['files']['tmp_name'][$i];
                $file_type = $_FILES['files']['type'][$i];
                $save_file = $this->root_file . 'files/';
                @mkdir("$save_file", 0755);
                $temp = explode(".", $file_name);
                $extension = strtolower(end($temp));
                $file_type = explode("/", $file_type);
                $file_name_new = md5(mt_rand(0, time())) . "_." . $extension;
                $image[$i] = array('normal_name' => $temp[0], 'rand_name' => $file_name_new, 'ext' => $extension, 'file_size' => $file_size, 'file_type' => $file_type[0]);
                if (in_array(strtolower($extension), array('pdf', 'zip', 'xlsx', 'csv', 'pptx', 'rar'))) {
                    move_uploaded_file($file_tmp, $save_file . "/" . $file_name_new);
                }
            }

            echo json_encode($image);

        }

    }


    public function delete($id,$model)
    {
        if ($this->handleLogin()) {
            $stmt_file = $this->db->prepare("SELECT * from `files` WHERE `id`= ?  AND `lang`='{$this->langControl}' AND `module` = ? ");
            $stmt_file->execute(array($id,$model));
            $result_file=$stmt_file->fetch(PDO::FETCH_ASSOC);

            if ($model=='videos')
            {



                $stmt_model = $this->db->prepare("UPDATE  `{$model}` SET `video_id`=0 WHERE `id`= ?  AND `video_id`=? ");
                $stmt_model ->execute(array($result_file['relid'],$result_file['id']));
                $result_model=$stmt_model->fetch(PDO::FETCH_ASSOC);


                $stmt_file_delete = $this->db->prepare("DELETE  FROM `files` WHERE `id`= ?  AND  `module` = ? ");
                $stmt_file_delete->execute(array($id,$model));
                $result_d=$stmt_file_delete->fetch(PDO::FETCH_ASSOC);
            } else if ($model=='videos_poster')
            {


                $stmt_model = $this->db->prepare("UPDATE  `{$model}` SET `poster_id`=0 WHERE `id`= ?  AND `poster_id`=? ");
                $stmt_model ->execute(array($result_file['relid'],$result_file['id']));
                $result_model=$stmt_model->fetch(PDO::FETCH_ASSOC);


                $stmt_file_delete = $this->db->prepare("DELETE  FROM `files` WHERE `id`= ?  AND  `module` = ? ");
                $stmt_file_delete->execute(array($id,$model));
                $result_d=$stmt_file_delete->fetch(PDO::FETCH_ASSOC);
            }

            else if ($model==$model.'_cat')
            {


                $stmt_model = $this->db->prepare("UPDATE  `{$model}` SET `poster_id`=0 WHERE `id`= ?  AND `poster_id`=? ");
                $stmt_model ->execute(array($result_file['relid'],$result_file['id']));
                $result_model=$stmt_model->fetch(PDO::FETCH_ASSOC);


                $stmt_file_delete = $this->db->prepare("DELETE  FROM `files` WHERE `id`= ?  AND  `module` = ? ");
                $stmt_file_delete->execute(array($id,$model));
                $result_d=$stmt_file_delete->fetch(PDO::FETCH_ASSOC);
            }
            else
            {

                $stmt_model = $this->db->prepare("UPDATE  `{$model}` SET `img`=0 WHERE `id`= ?  AND `img`=? ");
                $stmt_model ->execute(array($result_file['relid'],$result_file['id']));
                $result_model=$stmt_model->fetch(PDO::FETCH_ASSOC);


                $stmt_file_delete = $this->db->prepare("DELETE  FROM `files` WHERE `id`= ?  AND  `module` = ? ");
                $stmt_file_delete->execute(array($id,$model));
                $result_d=$stmt_file_delete->fetch(PDO::FETCH_ASSOC);

            }




            //            @unlink($this->root_file . $data[0]['rand_name']);
        }

    }


    public function delete_file($rand_name)
    {
        if ($this->handleLogin()) {
//            @unlink($this->root_file . $rand_name);
        }
    }




    function crop()
    {
        $oldPath=$this->root_file;
        $base64_string=$_POST['image'];
        $table=$_POST['table'] ;
        $id=$_POST['ids'];
        $old_img=$_POST['name_image'];

        $temp = explode(".", $old_img);
        $extension = strtolower(end($temp));
        $new_img = md5(mt_rand(0, time())) . "_." . $extension;


        $stmt=$this->db->prepare("UPDATE {$table} SET `img`=? WHERE id=? ");
        $stmt->execute(array($new_img,$id));
        if ($stmt->rowCount() > 0)
        {

            @unlink($oldPath.$old_img);
            $stmtc=$this->db->prepare("UPDATE cart_shop_active SET `image`=? WHERE image=? ");
            $stmtc->execute(array($new_img,$old_img));

            $stmtr=$this->db->prepare("UPDATE retrieve_item SET `image`=? WHERE image=? ");
            $stmtr->execute(array($new_img,$old_img));

            $output=$oldPath.$new_img;


            define('UPLOAD_DIR', 'img/');

            $base64 = base64_decode(preg_replace('#^data:image/[^;]+;base64,#', '', $base64_string));

            $stamp = imagecreatefrompng(ROOT."/public/{$this->langControl}/image/site/wm.png");
            $im = imagecreatefromstring($base64);


            $marge_right = 10;
            $marge_bottom = 10;
            $sx = imagesx($stamp);
            $sy = imagesy($stamp);

            $this->imagecopymerge_alpha($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 100);


            imagepng($im, $output, 9);


            $fileSize=filesize($output);

            if (filesize($this->root_file.$new_img))
            {
                echo json_encode(array('img'=>$new_img,'file_size'=>$fileSize,'file_size_kb'=>$this->formatSizeUnits($fileSize)));
            }

        }

    }





    function image($model)
    {

        $this->checkPermit('image',$this->folder);
        $this->adminHeaderController($this->langControl('image'));



        require ($this->render($this->folder,'html/image','index','php'));
        $this->adminFooterController();

    }



    function load($model)
    {


        if ($model == 'mobile')
        {
            $table='color';

        }else if ($model == 'savers')
        {
            $table='product_savers';

        }else
        {
            $table='color_'.$model;

        }
        $item_per_page = 12;
        $files=array();
        //sanitize post value
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

        if(!is_numeric($page_number)){
            header('HTTP/1.1 500 Invalid page number!');
            exit();
        }
        $position = (($page_number-1) * $item_per_page);

      if ($model == 'savers')
      {
          $stmt=$this->db->prepare("SELECT img,id,id_device,id as id_item from  `{$table}` WHERE 1 LIMIT $position,$item_per_page");

      }else
      {
          $stmt=$this->db->prepare("SELECT img,id,id_item from  `{$table}` WHERE 1 LIMIT $position,$item_per_page");

      }

        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            $row['bigSize']=0;
            $row['bigSize']='';

            if (file_exists($this->root_file.$row['img']))
            {
                $row['url']=$this->save_file.$row['img'];
                $byt=filesize($this->root_file.$row['img']);
                $row['size']=$this->formatSizeUnits($byt);
                if ($byt > 300000 )
                {
                    $row['bigSize']='bigSize';
                }
            }else
            {
                $row['url']=$this->static_file_control.'/image/admin/default.png';
                $row['size']=0;
            }


            $files[] = $row;
        }


            require ($this->render($this->folder,'html/image','load','php'));


    }


    function formatSizeUnits($bytes)
    {
        $info=array();
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }



    function edit_media($id,$model)
    {

        if ($model == 'mobile')
        {
            $table='color';

        }else if ($model == 'savers')
        {
            $table='product_savers';

        }else
        {
            $table='color_'.$model;

        }



        $stmt = $this->db->prepare("SELECT * from `{$table}` WHERE `id`=?   LIMIT 1  ");

        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        $result['url']=$this->show_file_site.$result['img'];

        require ($this->render($this->folder,'html/image','edit','php'));

    }




    function save_image_manager($id,$model)
    {



        if ($model == 'mobile')
        {
            $table='color';

        }else if ($model == 'savers')
        {
            $table='product_savers';

        }else
        {
            $table='color_'.$model;

        }


            if ($model == 'savers')
            {
                $stmt=$this->db->prepare("SELECT img,id,id as id_item from  `{$table}` WHERE `id`=? LIMIT 1");
            }else
            {
                $stmt=$this->db->prepare("SELECT img,id,id_item from  `{$table}` WHERE `id`=? LIMIT 1");
            }

            $stmt->execute(array($id));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);

            $old_img=$result['img'];

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

                    if ($id)
                    {
                        @unlink($this->root_file . $result['rand_name']);
                        @unlink($this->root_file .'thump_'.$result['rand_name']);

                        $file_name_new = md5(mt_rand(0, time())) . "_." . $extension;

                    }else
                    {
                        $file_name_new = md5(mt_rand(0, time())) . "_." . $extension;
                    }

                    $image[$i] = array('normal_name' => $temp[0], 'rand_name' => $file_name_new, 'ext' => $extension, 'file_size' => $file_size,'file_size_kb' => $this->formatSizeUnits($file_size), 'file_type' => $file_type[0]);
                    if(in_array(strtolower($extension),array('png','jpg','jpeg')))
                    {
                        move_uploaded_file($file_tmp, $save_file . "/" . $file_name_new);
                       $this->smart_resize_image($this->root_file.$file_name_new,$this->root_file.$file_name_new,null,$this->setting->get('width',1800) ,$this->setting->get('height',1600),$this->setting->get('proportional',1),'file',false,false,  $this->setting->get('quality',75) , $this->setting->get('grayscale',0) );
                    }
                }

                if ($id)
                {
                    $stmt = $this->db->prepare("UPDATE  `{$table}` SET `img` = ?   WHERE `id`=?    ");
                    $stmt->execute(array($file_name_new,$id));

                    $stmtc=$this->db->prepare("UPDATE cart_shop_active SET `image`=? WHERE image=? ");
                    $stmtc->execute(array($file_name_new,$old_img));

                    $stmtr=$this->db->prepare("UPDATE retrieve_item SET `image`=? WHERE image=? ");
                    $stmtr->execute(array($file_name_new,$old_img));
                }
                echo json_encode($image);

            }
    }


    function resize($model)
    {


        $this->checkPermit('resize',$this->folder);
        $this->adminHeaderController($this->langControl('resize'));





        require ($this->render($this->folder,'html/image','resize','php'));
        $this->adminFooterController();
    }


function initialize($model)
{

    if ($model == 'mobile')
    {
        $table='color';

    }else if ($model == 'savers')
    {
        $table='product_savers';

    }else
    {
        $table='color_'.$model;

    }


    if ($model == 'savers')
    {
        $stmt=$this->db->prepare("SELECT img from  `{$table}` ");

    }else
    {
        $stmt=$this->db->prepare("SELECT img from  `{$table}`");

    }
    $stmt->execute();
    $files=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        if (file_exists($this->root_file.$row['img']))
        {
            $row['url']=$this->save_file.$row['img'];
            $byt=filesize($this->root_file.$row['img']);
            if ($byt > 80000 )
            {
                $files[] = $row['img'];
            }
        }
    }
    if ($files)
    {
        echo json_encode($files);

    }

}



    function zip()
    {
        $photo=$_GET['photo'];
        $result=$this->smart_resize_image_list($this->root_file.$photo,$this->root_file.$photo,null,$this->setting->get('width',800) ,$this->setting->get('height',600),$this->setting->get('proportional',1),'file',false,false,  $this->setting->get('quality',75) , $this->setting->get('grayscale',0) );
        if ($result)
        {
            echo $photo;
        }
        else
        {
            echo $photo;
        }


    }


    function smart_resize_image_list($file,
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


    public function delete_file_and_row($id)
    {
        if ($this->handleLogin()) {
            $stmt = $this->db->prepare("SELECT * from `files` WHERE `id`=? AND `lang`='{$this->langControl}' LIMIT 1  ");
            $stmt->execute(array($id));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);

            @unlink($this->root_file . $result['rand_name']);
            @unlink($this->root_file .'thump_'.$result['rand_name']);

            $stmtd = $this->db->prepare("DELETE   from `files` WHERE `id`=? AND `lang`='{$this->langControl}' LIMIT 1  ");
            $stmtd->execute(array($id));
        }
    }




}