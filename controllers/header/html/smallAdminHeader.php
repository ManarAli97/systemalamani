<!DOCTYPE html>

 <html dir="<?php echo $this->dirControl ?>">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=0, maximum-scale=0" />

     <title><?php echo $this->title;?></title>

     <!--jquery -->
     <script src="<?php echo $this->static_file_control ?>/js/jquery.min.js"></script>

     <script>
         $(document).ready(function(){
             $('meta[name="viewport"]').prop('content', 'width=1440');
         });
     </script>
     <!--bootstrap-->
     <link rel="stylesheet" href="<?php echo $this->static_file_control ?>/bootstrap/css/bootstrap.min.css" >
     <script src="<?php echo $this->static_file_control ?>/bootstrap/js/popper.min.js"></script>
     <script src="<?php echo $this->static_file_control ?>/bootstrap/js/bootstrap.min.js"  ></script>


     <!--custom css -->

     <link rel="stylesheet" href="<?php echo $this->static_file_control ?>/css/adminCss.css"/>

     <!--clipboard.min.js-->
     <script src="<?php echo $this->static_file_control ?>/js/clipboard.min.js"></script>


     <!--bootstrap-toggle-->
     <link href="<?php echo $this->static_file_control ?>/bootstrap/toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
     <script src="<?php echo $this->static_file_control ?>/bootstrap/toggle/js/bootstrap-toggle.min.js"></script>

     <link rel="stylesheet" href="<?php echo $this->static_file_control ?>/dist2/font-awesome.min.css"/>

     <!--dataTables-->
     <link rel="stylesheet" href="<?php echo $this->static_file_control ?>/datatable/css/jquery.dataTables.min.css">
     <link rel="stylesheet" href="<?php echo $this->static_file_control ?>/datatable/css/dataTables.bootstrap4.min.css">
     <script type="text/javascript" src="<?php echo $this->static_file_control ?>/datatable/js/jquery.dataTables.min.js"></script>
     <script type="text/javascript" src="<?php echo $this->static_file_control ?>/datatable/js/dataTables.bootstrap4.min.js"></script>


     <script type="text/javascript" language="javascript" src="<?php echo $this->static_file_control ?>/datatable/js/dataTables.buttons.min.js"></script>
     <script type="text/javascript" language="javascript" src="<?php echo $this->static_file_control ?>/datatable/js/jszip.min.js"></script>
     <script type="text/javascript" language="javascript" src="<?php echo $this->static_file_control ?>/datatable/js/vfs_fonts.js"></script>
     <script type="text/javascript" language="javascript" src="<?php echo $this->static_file_control ?>/datatable/js/buttons.html5.min.js"></script>

     <link rel="stylesheet" type="text/css" href="<?php echo $this->static_file_control ?>/datatable/css/buttons.dataTables.min.css">
     <script src="<?php echo $this->static_file_control ?>/js/JsBarcode.all.min.js"></script>
     <script src="<?php echo $this->static_file_control ?>/js/Tafqeet.js"></script>


 </head>
 <body >



 <div class="fixed-top">
 <nav class="navbar navbar-expand-lg navbar-light bg-light top_menu_admin">
     <a class="navbar-brand logoAdmin" href="<?php echo url ; ?>/home" >
        APP
     </a>

    <a class="navbar-brand logoAdmin" href="<?php echo url ; ?>" >
       home
     </a>


     <script>
         function open_close_menu(e) {
             var vis=$(e).is(':checked' )? 1:0;

             if(vis===0)
             {
                 $('.menuControl').css('display','block')
             }else
             {
                 $('.menuControl').css('display','none')
             }

         }
     </script>


     <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <ul class="navbar-nav mr-auto">

             <?php if (Session::get('loggedIn')==true)  {  ?>
             <li class="nav-item active">
                 <a class="nav-link"  href="<?php echo url ; ?>/home" id="navbarDropdown" role="button"   aria-haspopup="true" aria-expanded="false">
                     <i style="color: #000" class="fa fa-dashboard" aria-hidden="true"></i>
                     <span style="color: #000">  <?php  echo $this->langControl('category_site')?></span>
                 </a>

             </li>
             <?php if (Session::get('role')=='admin')  {  ?>
             <li class="nav-item dropdown">
             <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownGroup" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <span style="color: #000"> <i class="fa fa-users" aria-hidden="true"></i> <span> <?php  echo $this->langControl('group_user')?></span></span>
             </a>
             <div class="dropdown-menu" aria-labelledby="navbarDropdownGroup">
                 <a class="dropdown-item"  href="<?php echo url ; ?>/user/group"> <i class="fa fa-folder-open" aria-hidden="true"></i>  <span><?php  echo $this->langControl('view_group')?></span> </a>
                 <a class="dropdown-item" href="<?php echo url ; ?>/user/add_group"> <i class="fa fa-plus" aria-hidden="true"></i>  <span><?php  echo $this->langControl('add_group')?></span></a>
             </div>
             </li>


             <li class="nav-item active">
                 <a class="nav-link" href="<?php echo url ?>/lang/view_lang"> <i class="fa fa-language" aria-hidden="true"></i>   <span><?php  echo $this->langControl('website_translation')?></span> </a>
             </li>


             <?php } ?>


				 <?php  if ($this->permit('money_clipper','details_money_clipper')) {  ?>
                     <li class="nav-item active"> <a  class="nav-link" href="<?php echo url?>/money_clipper/details_money_clipper">  <i class="fa fa-money" aria-hidden="true"></i>   <span> القاصة </span>   </a> </li>
				 <?php  } ?>


             <li class="nav-item active">
                 <a class="nav-link" href="<?php echo url ?>/login/logout"> <i class="fa fa-sign-out" aria-hidden="true"></i>   <span><?php  echo $this->langControl('sign_out')?></span> </a>
             </li>

             <?php }  ?>

         </ul>
         <?php if (Session::get('loggedIn')==true) {  ?>

             <div class=" my-2 my-lg-0">

             <span>  <?php echo Session::get('usernamelogin') ?> </span>    <i class="fa fa-user-circle-o" aria-hidden="true"></i>

         </div>
         <?php } ?>
     </div>

     <div class="menu_toggle">
         <input datax-stylex="iosx" id="controlMenu" data-height="18"  data-onstyle="warning" type="checkbox" onchange="open_close_menu(this)"   data-toggle="toggle" data-on="<i class='fa  fa-outdent'></i> open" data-off="<i class='fa  fa-times-circle-o'></i> close">

     </div>

 </nav>
 </div>
<div class="down_fixed"></div>


 <link rel="stylesheet" href="<?php echo $this->static_file_control ?>/css/file-explore.css">
<div class="container-fluid">
 <div class="row flex-xl-nowrap">






     <div class="menuControl"  >
         <br>
         <ul class="file-tree">


             <?php  if ($this->permit('mobile','mobile')) {  ?>
             <li class="mobile"> <a href="#"><?php  echo $this->langControl('mobile') ?></a>

                 <a href="<?php echo  url ?>/mobile/add_category"  class="mobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/mobile/admin_category"  class="mobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/mobile/list2_mobile"  style="color: #4CAF50"  data-toggle="tooltip" data-placement="top" title="عرض محتويات كل الاقسام"><i class="fa fa-list" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/mobile/quantity" style="color: #ff0000" data-toggle="tooltip" data-placement="top" title="export excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/mobile/unknown"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة"><i class="fa fa-plus" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/mobile/barcode"  data-toggle="tooltip" data-placement="top" title="تحديث الباركودات البديلة"><i class="fa fa-barcode" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/mobile/list_model_connect"  data-toggle="tooltip" data-placement="top" title="ربط الاقسام المتشابه   "><i class="fa fa-link" aria-hidden="true"></i></a>

                 <ul>
                     <?php foreach ($category_mobile as $cat) {   ?>
                         <?php  if ($mobile->ck_sub_cat($cat['id'])) { ?>
                             <li class="<?php echo $mobile->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="mobile"> <?php   echo $cat['title']?> </a>
                                 <a href="<?php echo  url ?>/mobile/list_mobile/<?php   echo $cat['id'] ?>"  class="mobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_content')  ?>"><i class="fa  fa-folder" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/mobile/edit_category/<?php   echo $cat['id'] ?>"  class="mobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/mobile/add_category/<?php   echo $cat['id'] ?>"  class="mobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/mobile/admin_category/<?php   echo $cat['id']?>"  class="mobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                                 <?php   $mobile->listSubCategory($cat['id'],$id) ?>
                             </li>
                         <?php  }else { ?>
                             <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/mobile/list_mobile/<?php    echo $cat['id'] ?>" class="mobile"> <?php   echo $cat['title']?></a>

                                 <a href="<?php echo  url ?>/mobile/edit_category/<?php   echo $cat['id'] ?>"  class="mobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/mobile/add_category/<?php   echo $cat['id'] ?>"  class="mobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                             </li>

                         <?php }  } ?>
                 </ul>
             </li>

           <?php  } ?>
             <?php  if ($this->permit('games','games')) {  ?>
             <li class="games"> <a href="#"><?php  echo $this->langControl('games') ?></a>

                 <a href="<?php echo  url ?>/games/add_category"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/games/admin_category"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/games/list2_games"  style="color: #4CAF50"   data-toggle="tooltip" data-placement="top" title="عرض محتويات كل الاقسام"><i class="fa fa-list" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/games/quantity" style="color: #ff0000" data-toggle="tooltip" data-placement="top" title="export excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/games/unknown"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة"><i class="fa fa-plus" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/games/list_model_connect"  data-toggle="tooltip" data-placement="top" title="ربط الاقسام المتشابه   "><i class="fa fa-link" aria-hidden="true"></i></a>


                 <ul>


                     <li class="games"> <a href="<?php echo url ?>/games/list_class_games"><?php  echo $this->langControl('class_games') ?>
                             <a href="<?php echo  url ?>/games/add_class_games"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_class_games')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>

                         </a>


                         <?php foreach ($category_games as $cat) {   ?>
                         <?php  if ($games->ck_sub_cat($cat['id'])) { ?>
                             <li class="<?php echo $games->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="games"> <?php   echo $cat['title']?> </a>
                                 <a href="<?php echo  url ?>/games/list_games/<?php   echo $cat['id'] ?>"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_content')  ?>"><i class="fa  fa-folder" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/games/edit_category/<?php   echo $cat['id'] ?>"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/games/add_category/<?php   echo $cat['id'] ?>"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/games/admin_category/<?php   echo $cat['id']?>"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                                 <?php   $games->listSubCategory($cat['id'],$id) ?>
                             </li>
                         <?php  }else { ?>
                             <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/games/list_games/<?php    echo $cat['id'] ?>" class="games"> <?php   echo $cat['title']?></a>

                                 <a href="<?php echo  url ?>/games/edit_category/<?php   echo $cat['id'] ?>"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/games/add_category/<?php   echo $cat['id'] ?>"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                             </li>

                         <?php }  } ?>
                 </ul>
             </li>
    <?php  } ?>

             <?php  if ($this->permit('camera','camera')) {  ?>
             <li class="camera"> <a href="#"><?php  echo $this->langControl('camera') ?></a>

                 <a href="<?php echo  url ?>/camera/add_category"  class="camera" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/camera/admin_category"  class="camera" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/camera/list2_camera"   style="color: #4CAF50"   data-toggle="tooltip" data-placement="top" title="عرض محتويات كل الاقسام"><i class="fa fa-list" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/camera/quantity" style="color: #ff0000" data-toggle="tooltip" data-placement="top" title="export excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/camera/unknown"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة"><i class="fa fa-plus" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/camera/list_model_connect"  data-toggle="tooltip" data-placement="top" title="ربط الاقسام المتشابه   "><i class="fa fa-link" aria-hidden="true"></i></a>

                 <ul>
                     <?php foreach ($category_camera as $cat) {   ?>
                         <?php  if ($camera->ck_sub_cat($cat['id'])) { ?>
                             <li class="<?php echo $camera->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="camera"> <?php   echo $cat['title']?> </a>
                                 <a href="<?php echo  url ?>/camera/list_camera/<?php   echo $cat['id'] ?>"  class="camera" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_content')  ?>"><i class="fa  fa-folder" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/camera/edit_category/<?php   echo $cat['id'] ?>"  class="camera" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/camera/add_category/<?php   echo $cat['id'] ?>"  class="camera" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/camera/admin_category/<?php   echo $cat['id']?>"  class="camera" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                                 <?php   $camera->listSubCategory($cat['id'],$id) ?>
                             </li>
                         <?php  }else { ?>
                             <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/camera/list_camera/<?php    echo $cat['id'] ?>" class="camera"> <?php   echo $cat['title']?></a>

                                 <a href="<?php echo  url ?>/camera/edit_category/<?php   echo $cat['id'] ?>"  class="camera" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/camera/add_category/<?php   echo $cat['id'] ?>"  class="camera" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                             </li>

                         <?php }  } ?>
                 </ul>
             </li>

             <?php  } ?>


			 <?php  if ($this->permit('printing_supplies','printing_supplies')) {  ?>
                 <li class="printing_supplies"> <a href="#"><?php  echo $this->langControl('printing_supplies') ?></a>

                     <a href="<?php echo  url ?>/printing_supplies/add_category"  class="printing_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/printing_supplies/admin_category"  class="printing_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/printing_supplies/list2_printing_supplies"   style="color: #4CAF50"   data-toggle="tooltip" data-placement="top" title="عرض محتويات كل الاقسام"><i class="fa fa-list" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/printing_supplies/quantity" style="color: #ff0000" data-toggle="tooltip" data-placement="top" title="export excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/printing_supplies/unknown"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة"><i class="fa fa-plus" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/printing_supplies/list_model_connect"  data-toggle="tooltip" data-placement="top" title="ربط الاقسام المتشابه   "><i class="fa fa-link" aria-hidden="true"></i></a>

                     <ul>
						 <?php foreach ($category_printing_supplies as $cat) {   ?>
							 <?php  if ($printing_supplies->ck_sub_cat($cat['id'])) { ?>
                                 <li class="<?php echo $printing_supplies->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="printing_supplies"> <?php   echo $cat['title']?> </a>
                                     <a href="<?php echo  url ?>/printing_supplies/list_printing_supplies/<?php   echo $cat['id'] ?>"  class="printing_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_content')  ?>"><i class="fa  fa-folder" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/printing_supplies/edit_category/<?php   echo $cat['id'] ?>"  class="printing_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/printing_supplies/add_category/<?php   echo $cat['id'] ?>"  class="printing_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/printing_supplies/admin_category/<?php   echo $cat['id']?>"  class="printing_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
									 <?php   $printing_supplies->listSubCategory($cat['id'],$id) ?>
                                 </li>
							 <?php  }else { ?>
                                 <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/printing_supplies/list_printing_supplies/<?php    echo $cat['id'] ?>" class="printing_supplies"> <?php   echo $cat['title']?></a>

                                     <a href="<?php echo  url ?>/printing_supplies/edit_category/<?php   echo $cat['id'] ?>"  class="printing_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/printing_supplies/add_category/<?php   echo $cat['id'] ?>"  class="printing_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                 </li>

							 <?php }  } ?>
                     </ul>
                 </li>

			 <?php  } ?>


			 <?php  if ($this->permit('computer','computer')) {  ?>
                 <li class="computer"> <a href="#"><?php  echo $this->langControl('computer') ?></a>

                     <a href="<?php echo  url ?>/computer/add_category"  class="computer" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/computer/admin_category"  class="computer" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/computer/list2_computer"   style="color: #4CAF50"   data-toggle="tooltip" data-placement="top" title="عرض محتويات كل الاقسام"><i class="fa fa-list" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/computer/quantity" style="color: #ff0000" data-toggle="tooltip" data-placement="top" title="export excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/computer/unknown"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة"><i class="fa fa-plus" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/computer/list_model_connect"  data-toggle="tooltip" data-placement="top" title="ربط الاقسام المتشابه   "><i class="fa fa-link" aria-hidden="true"></i></a>

                     <ul>
						 <?php foreach ($category_computer as $cat) {   ?>
							 <?php  if ($computer->ck_sub_cat($cat['id'])) { ?>
                                 <li class="<?php echo $computer->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="computer"> <?php   echo $cat['title']?> </a>
                                     <a href="<?php echo  url ?>/computer/list_computer/<?php   echo $cat['id'] ?>"  class="computer" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_content')  ?>"><i class="fa  fa-folder" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/computer/edit_category/<?php   echo $cat['id'] ?>"  class="computer" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/computer/add_category/<?php   echo $cat['id'] ?>"  class="computer" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/computer/admin_category/<?php   echo $cat['id']?>"  class="computer" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
									 <?php   $computer->listSubCategory($cat['id'],$id) ?>
                                 </li>
							 <?php  }else { ?>
                                 <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/computer/list_computer/<?php    echo $cat['id'] ?>" class="computer"> <?php   echo $cat['title']?></a>

                                     <a href="<?php echo  url ?>/computer/edit_category/<?php   echo $cat['id'] ?>"  class="computer" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/computer/add_category/<?php   echo $cat['id'] ?>"  class="computer" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                 </li>

							 <?php }  } ?>
                     </ul>
                 </li>

			 <?php  } ?>




             <?php  if ($this->permit('network','network')) {  ?>
             <li class="network"> <a href="#"><?php  echo $this->langControl('network') ?></a>

                 <a href="<?php echo  url ?>/network/add_category"  class="network" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/network/admin_category"  class="network" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/network/list2_network"  style="color: #4CAF50"    data-toggle="tooltip" data-placement="top" title="عرض محتويات كل الاقسام"><i class="fa fa-list" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/network/quantity" style="color: #ff0000" data-toggle="tooltip" data-placement="top" title="export excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/network/unknown"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة"><i class="fa fa-plus" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/network/list_model_connect"  data-toggle="tooltip" data-placement="top" title="ربط الاقسام المتشابه   "><i class="fa fa-link" aria-hidden="true"></i></a>

                 <ul>
                     <?php foreach ($category_network as $cat) {   ?>
                         <?php  if ($network->ck_sub_cat($cat['id'])) { ?>
                             <li class="<?php echo $network->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="network"> <?php   echo $cat['title']?> </a>
                                 <a href="<?php echo  url ?>/network/list_network/<?php   echo $cat['id'] ?>"  class="network" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_content')  ?>"><i class="fa  fa-folder" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/network/edit_category/<?php   echo $cat['id'] ?>"  class="network" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/network/add_category/<?php   echo $cat['id'] ?>"  class="network" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/network/admin_category/<?php   echo $cat['id']?>"  class="network" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                                 <?php   $network->listSubCategory($cat['id'],$id) ?>
                             </li>
                         <?php  }else { ?>
                             <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/network/list_network/<?php    echo $cat['id'] ?>" class="network"> <?php   echo $cat['title']?></a>

                                 <a href="<?php echo  url ?>/network/edit_category/<?php   echo $cat['id'] ?>"  class="network" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/network/add_category/<?php   echo $cat['id'] ?>"  class="network" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                             </li>

                         <?php }  } ?>
                 </ul>
             </li>
<?php  } ?>
             <?php  if ($this->permit('accessories','accessories')) {  ?>
             <li class="accessories"> <a href="#"><?php  echo $this->langControl('accessories') ?></a>

                 <a href="<?php echo  url ?>/accessories/add_category"  class="accessories" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/accessories/admin_category"  class="accessories" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/accessories/list2_accessories"  style="color: #4CAF50"    data-toggle="tooltip" data-placement="top" title="عرض محتويات كل الاقسام"><i class="fa fa-list" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/accessories/quantity" style="color: #ff0000" data-toggle="tooltip" data-placement="top" title="export excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/accessories/unknown"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة"><i class="fa fa-plus" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/accessories/list_accessories_connect"  data-toggle="tooltip" data-placement="top" title="ربط الاقسام المتشابه في الاواسق "><i class="fa fa-link" aria-hidden="true"></i></a>

                 <ul>
                     <?php foreach ($category_accessories as $cat) {   ?>
                         <?php  if ($accessories->ck_sub_cat($cat['id'])) { ?>
                             <li class="<?php echo $accessories->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="accessories"> <?php   echo $cat['title']?> </a>
                                 <a href="<?php echo  url ?>/accessories/list_accessories/<?php   echo $cat['id'] ?>"  class="accessories" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_content')  ?>"><i class="fa  fa-folder" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/accessories/edit_category/<?php   echo $cat['id'] ?>"  class="accessories" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/accessories/add_category/<?php   echo $cat['id'] ?>"  class="accessories" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/accessories/admin_category/<?php   echo $cat['id']?>"  class="accessories" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                                 <?php   $accessories->listSubCategory($cat['id'],$id) ?>
                             </li>
                         <?php  }else { ?>
                             <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/accessories/list_accessories/<?php    echo $cat['id'] ?>" class="accessories"> <?php   echo $cat['title']?></a>

                                 <a href="<?php echo  url ?>/accessories/edit_category/<?php   echo $cat['id'] ?>"  class="accessories" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/accessories/add_category/<?php   echo $cat['id'] ?>"  class="accessories" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                             </li>

                         <?php }  } ?>
                 </ul>
             </li>
             <?php  }  ?>


			 <?php  if ($this->permit('savers','savers')) {  ?>
                 <li class="savers">  <a href="#">  <?php  echo $this->langControl('savers') ?> </a>
                     <a href="<?php echo  url ?>/savers/all_cover" style="color: #4CAF50" data-toggle="tooltip" data-placement="top" title="كل الحافظات"><i class="fa fa-list" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/savers/quantity" style="color: #ff0000" data-toggle="tooltip" data-placement="top" title="export excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/savers/unknown"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة"><i class="fa fa-plus" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/savers/unknown2"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة بدون تحديد اسم الجهاز"><i class="fa fa-folder-o" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/savers/type_cover"  data-toggle="tooltip" data-placement="top" title=" تحديث الاسم الاتيني "><i class="fa fa-undo" aria-hidden="true"></i></a>

                     <ul>
                         <li class="savers">
                             <a class="savers" href="<?php echo url?>/savers/list_category"> <?php  echo $this->langControl('brands') ?> </a>
                             <a href="<?php echo url ?>/savers/add_category" class="savers" data-toggle="tooltip"
                                data-placement="top" title="<?php echo $this->langControl('add') ?>"><i
                                         class="fa fa-plus-circle" aria-hidden="true"></i></a>
                         </li>

                         <li class="savers">
                             <a class="savers" href="<?php echo url?>/savers/list_savers"> <?php  echo $this->langControl('hardware_chains') ?> </a>
                             <a href="<?php echo url ?>/savers/add" class="savers" data-toggle="tooltip"
                                data-placement="top" title="<?php echo $this->langControl('add') ?>"><i
                                         class="fa fa-plus-circle" aria-hidden="true"></i></a>
                         </li>

                         <li class="savers">
                             <a class="savers" href="<?php echo url?>/savers/list_type_device"> <?php  echo $this->langControl('type_device') ?> </a>
                             <a href="<?php echo url ?>/savers/add_type_device" class="savers" data-toggle="tooltip"
                                data-placement="top" title="<?php echo $this->langControl('add') ?>"><i
                                         class="fa fa-plus-circle" aria-hidden="true"></i></a>
                         </li>



                         <li class="savers">
                             <a class="savers" href="<?php echo url?>/savers/open_savers"> عرض الحافظات </a>
                         </li>



                     </ul>
                 </li>

			 <?php }  ?>


             <?php  if ($this->permit('specifications','specifications')) {  ?>
                 <li class="specifications"> <a href="<?php echo url?>/specifications"> <?php  echo $this->langControl('specifications') ?> </a>
                 </li>

             <?php  } ?>

             <?php  if ($this->permit('files','files')) {  ?>
                 <li class="files">  <a href="#">  مدير الملفات </a>

                     <ul>
                         <?php  foreach ($this->category_website as $key => $catg)  { ?>
                         <li class="files">
                             <a class="files" href="<?php echo url?>/files/image/<?php  echo $key ?>">  <?php  echo $catg ?> </a>

                         </li>
                         <?php } ?>
                     </ul>

                 </li>

             <?php  }  ?>

             <?php  if ($this->permit('excel','excel')) {  ?>
                 <li class="excel">  <a href="#">  <?php  echo $this->langControl('excel') ?> </a>

                     <ul>
                         <li class="excel">
                             <a class="excel" href="<?php echo url?>/excel/list_excel"> <?php  echo $this->langControl('add_excel_mobile') ?> </a>


                             <a href="<?php echo url ?>/excel/add_mobile" class="excel" data-toggle="tooltip"
                                data-placement="top" title="<?php echo $this->langControl('add_excel_mobile') ?>"><i
                                     class="fa fa-plus-circle" aria-hidden="true"></i></a>

							 <?php  if ($this->permit('archives_mobile','excel')) {  ?>
                             <a href="<?php echo url ?>/excel/archives/mobile" class="excel" data-toggle="tooltip"
                                data-placement="top" title="ارشيف"><i
                                     class="fa fa-archive" aria-hidden="true" ></i></a>
							 <?php } ?>
                             <a href="<?php echo url ?>/excel/mobile_location_set" class="excel" data-toggle="tooltip"
                                data-placement="top" title="مواقع محدده"><i
                                     class="fa fa-map-marker" aria-hidden="true" style="color: green"></i></a>


                             <a href="<?php echo url ?>/excel/mobile_location_set_not" class="excel" data-toggle="tooltip"
                                data-placement="top" title="مواقع غير محدده"><i
                                     class="fa fa-map-marker" aria-hidden="true" style="color: red"></i></a>


                         </li>
                         <li class="excel">
                             <a class="excel" href="<?php echo url?>/excel/list_excel_accessories"> <?php  echo $this->langControl('add_excel_accessories') ?> </a>
                             <a href="<?php echo url ?>/excel/add_accessories" class="excel" data-toggle="tooltip"
                                data-placement="top" title="<?php echo $this->langControl('add_excel_accessories') ?>"><i
                                     class="fa fa-plus-circle" aria-hidden="true"></i></a>

							 <?php  if ($this->permit('archives_accessories','excel')) {  ?>
                             <a href="<?php echo url ?>/excel/archives/accessories" class="excel" data-toggle="tooltip"
                                data-placement="top" title="ارشيف"><i
                                         class="fa fa-archive" aria-hidden="true" ></i></a>
							 <?php } ?>
                             <a href="<?php echo url ?>/excel/accessories_location_set" class="excel" data-toggle="tooltip"
                                data-placement="top" title="مواقع محدده"><i
                                     class="fa fa-map-marker" aria-hidden="true" style="color: green"></i></a>


                             <a href="<?php echo url ?>/excel/accessories_location_set_not" class="excel" data-toggle="tooltip"
                                data-placement="top" title="مواقع غير محدده"><i
                                     class="fa fa-map-marker" aria-hidden="true" style="color: red"></i></a>
                         </li>

                         <li class="excel">
                             <a class="excel" href="<?php echo url?>/excel/list_excel_service"> <?php  echo $this->langControl('add_excel_service') ?> </a>
                             <a href="<?php echo url ?>/excel/add_service" class="excel" data-toggle="tooltip"
                                data-placement="top" title="<?php echo $this->langControl('add_excel_service') ?>"><i
                                     class="fa fa-plus-circle" aria-hidden="true"></i></a>

							 <?php  if ($this->permit('archives_service','excel')) {  ?>
                             <a href="<?php echo url ?>/excel/archives/service" class="excel" data-toggle="tooltip"
                                data-placement="top" title="ارشيف"><i
                                         class="fa fa-archive" aria-hidden="true" ></i></a>
							 <?php } ?>

                             <a href="<?php echo url ?>/excel/list_excel_service_location_set" class="excel" data-toggle="tooltip"
                                data-placement="top" title="مواقع محدده"><i
                                         class="fa fa-map-marker" aria-hidden="true" style="color: green"></i></a>


                             <a href="<?php echo url ?>/excel/list_excel_service_location_set_not" class="excel" data-toggle="tooltip"
                                data-placement="top" title="مواقع غير محدده"><i
                                         class="fa fa-map-marker" aria-hidden="true" style="color: red"></i></a>



                         </li>
                         <li class="excel">
                             <a class="excel" href="<?php echo url?>/excel/list_excel_games"> <?php  echo $this->langControl('add_excel_games') ?> </a>
                             <a href="<?php echo url ?>/excel/add_games" class="excel" data-toggle="tooltip"
                                data-placement="top" title="<?php echo $this->langControl('add_excel_games') ?>"><i
                                     class="fa fa-plus-circle" aria-hidden="true"></i></a>
							 <?php  if ($this->permit('archives_games','excel')) {  ?>
                             <a href="<?php echo url ?>/excel/archives/games" class="excel" data-toggle="tooltip"
                                data-placement="top" title="ارشيف"><i
                                         class="fa fa-archive" aria-hidden="true" ></i></a>
							 <?php } ?>
                             <a href="<?php echo url ?>/excel/games_location_set" class="excel" data-toggle="tooltip"
                                data-placement="top" title="مواقع محدده"><i
                                     class="fa fa-map-marker" aria-hidden="true" style="color: green"></i></a>


                             <a href="<?php echo url ?>/excel/games_location_set_not" class="excel" data-toggle="tooltip"
                                data-placement="top" title="مواقع غير محدده"><i
                                     class="fa fa-map-marker" aria-hidden="true" style="color: red"></i></a>
                         </li>



                         <li class="excel">
                             <a class="excel" href="<?php echo url?>/excel/list_excel_camera"> <?php  echo $this->langControl('add_excel_camera') ?> </a>
                             <a href="<?php echo url ?>/excel/add_camera" class="excel" data-toggle="tooltip"
                                data-placement="top" title="<?php echo $this->langControl('add_excel_camera') ?>"><i
                                     class="fa fa-plus-circle" aria-hidden="true"></i></a>

							 <?php  if ($this->permit('archives_camera','excel')) {  ?>
                             <a href="<?php echo url ?>/excel/archives/camera" class="excel" data-toggle="tooltip"
                                data-placement="top" title="ارشيف"><i
                                         class="fa fa-archive" aria-hidden="true" ></i></a>
							 <?php } ?>
                             <a href="<?php echo url ?>/excel/camera_location_set" class="excel" data-toggle="tooltip"
                                data-placement="top" title="مواقع محدده"><i
                                     class="fa fa-map-marker" aria-hidden="true" style="color: green"></i></a>


                             <a href="<?php echo url ?>/excel/camera_location_set_not" class="excel" data-toggle="tooltip"
                                data-placement="top" title="مواقع غير محدده"><i
                                     class="fa fa-map-marker" aria-hidden="true" style="color: red"></i></a>
                         </li>


                         <li class="excel">
                             <a class="excel" href="<?php echo url?>/excel/list_excel_printing_supplies"> <?php  echo $this->langControl('add_excel_printing_supplies') ?> </a>
                             <a href="<?php echo url ?>/excel/add_printing_supplies" class="excel" data-toggle="tooltip"
                                data-placement="top" title="<?php echo $this->langControl('add_excel_printing_supplies') ?>"><i
                                         class="fa fa-plus-circle" aria-hidden="true"></i></a>

							 <?php  if ($this->permit('archives_printing_supplies','excel')) {  ?>
                             <a href="<?php echo url ?>/excel/archives/printing_supplies" class="excel" data-toggle="tooltip"
                                data-placement="top" title="ارشيف"><i
                                         class="fa fa-archive" aria-hidden="true" ></i></a>
							 <?php } ?>
                             <a href="<?php echo url ?>/excel/printing_supplies_location_set" class="excel" data-toggle="tooltip"
                                data-placement="top" title="مواقع محدده"><i
                                         class="fa fa-map-marker" aria-hidden="true" style="color: green"></i></a>


                             <a href="<?php echo url ?>/excel/printing_supplies_location_set_not" class="excel" data-toggle="tooltip"
                                data-placement="top" title="مواقع غير محدده"><i
                                         class="fa fa-map-marker" aria-hidden="true" style="color: red"></i></a>
                         </li>


                         <li class="excel">
                             <a class="excel" href="<?php echo url?>/excel/list_excel_computer"> <?php  echo $this->langControl('add_excel_computer') ?> </a>
                             <a href="<?php echo url ?>/excel/add_computer" class="excel" data-toggle="tooltip"
                                data-placement="top" title="<?php echo $this->langControl('add_excel_computer') ?>"><i
                                         class="fa fa-plus-circle" aria-hidden="true"></i></a>

							 <?php  if ($this->permit('archives_computer','excel')) {  ?>
                             <a href="<?php echo url ?>/excel/archives/computer" class="excel" data-toggle="tooltip"
                                data-placement="top" title="ارشيف"><i
                                         class="fa fa-archive" aria-hidden="true" ></i></a>
							 <?php } ?>
                             <a href="<?php echo url ?>/excel/computer_location_set" class="excel" data-toggle="tooltip"
                                data-placement="top" title="مواقع محدده"><i
                                         class="fa fa-map-marker" aria-hidden="true" style="color: green"></i></a>


                             <a href="<?php echo url ?>/excel/computer_location_set_not" class="excel" data-toggle="tooltip"
                                data-placement="top" title="مواقع غير محدده"><i
                                         class="fa fa-map-marker" aria-hidden="true" style="color: red"></i></a>
                         </li>




                         <li class="excel">
                             <a class="excel" href="<?php echo url?>/excel/list_excel_network"> <?php  echo $this->langControl('add_excel_network') ?> </a>
                             <a href="<?php echo url ?>/excel/add_network" class="excel" data-toggle="tooltip"
                                data-placement="top" title="<?php echo $this->langControl('add_excel_network') ?>"><i
                                     class="fa fa-plus-circle" aria-hidden="true"></i></a>

							 <?php  if ($this->permit('archives_network','excel')) {  ?>
                             <a href="<?php echo url ?>/excel/archives/network" class="excel" data-toggle="tooltip"
                                data-placement="top" title="ارشيف"><i
                                         class="fa fa-archive" aria-hidden="true" ></i></a>
                                <?php } ?>

                             <a href="<?php echo url ?>/excel/network_location_set" class="excel" data-toggle="tooltip"
                                data-placement="top" title="مواقع محدده"><i
                                     class="fa fa-map-marker" aria-hidden="true" style="color: green"></i></a>


                             <a href="<?php echo url ?>/excel/network_location_set_not" class="excel" data-toggle="tooltip"
                                data-placement="top" title="مواقع غير محدده"><i
                                     class="fa fa-map-marker" aria-hidden="true" style="color: red"></i></a>
                         </li>

                     </ul>


                 </li>

             <?php  }  ?>

             <?php  if ($this->permit('location_model','location_model')) {  ?>
                 <li class="location_model">  <a href="#">  <?php  echo $this->langControl('location_model') ?> </a>

                     <ul>
                         <li class="location_model">
                             <a class="location_model" href="<?php echo url?>/location_model/list_location/mobile"> <?php  echo $this->langControl('mobile') ?> </a>
                             <a class="location_model" href="<?php echo url?>/location_model/add/mobile">  <i class="fa fa-upload"></i> </a>
                         </li>
                         <li class="location_model">
                             <a class="location_model" href="<?php echo url?>/location_model/list_location/camera"> <?php  echo $this->langControl('camera') ?> </a>
                             <a class="location_model" href="<?php echo url?>/location_model/add/camera">  <i class="fa fa-upload"></i> </a>
                         </li>

                         <li class="location_model">
                             <a class="location_model" href="<?php echo url?>/location_model/list_location/computer"> <?php  echo $this->langControl('computer') ?> </a>
                             <a class="location_model" href="<?php echo url?>/location_model/add/computer">  <i class="fa fa-upload"></i> </a>
                         </li>

                         <li class="location_model">
                             <a class="location_model" href="<?php echo url?>/location_model/list_location/games"> <?php  echo $this->langControl('games') ?> </a>
                             <a class="location_model" href="<?php echo url?>/location_model/add/games">  <i class="fa fa-upload"></i> </a>
                         </li>

                         <li class="location_model">
                             <a class="location_model" href="<?php echo url?>/location_model/list_location/network"> <?php  echo $this->langControl('network') ?> </a>
                             <a class="location_model" href="<?php echo url?>/location_model/add/network">  <i class="fa fa-upload"></i> </a>
                         </li>

                         <li class="location_model">
                             <a class="location_model" href="<?php echo url?>/location_model/list_location/printing_supplies"> <?php  echo $this->langControl('printing_supplies') ?> </a>
                             <a class="location_model" href="<?php echo url?>/location_model/add/printing_supplies">  <i class="fa fa-upload"></i> </a>
                         </li>

                         <li class="location_model">
                             <a class="location_model" href="<?php echo url?>/location_model/list_location/accessories"> <?php  echo $this->langControl('accessories') ?> </a>
                             <a class="location_model" href="<?php echo url?>/location_model/add/accessories">  <i class="fa fa-upload"></i> </a>
                         </li>
                         <li class="location_model">
                             <a class="location_model" href="<?php echo url?>/location_model/list_location/savers"> <?php  echo $this->langControl('savers') ?> </a>
                             <a class="location_model" href="<?php echo url?>/location_model/add/savers">  <i class="fa fa-upload"></i> </a>
                         </li>

                     </ul>


                 </li>

             <?php  }  ?>



			 <?php  if ($this->permit('location_confirm','location_confirm')) {  ?>
                 <li class="location_confirm">  <a href="#">  <?php  echo $this->langControl('location_confirm') ?> </a>

                     <ul>
                         <li class="location_confirm">
                             <a class="location_confirm" href="<?php echo url?>/location_confirm/mobile"> <?php  echo $this->langControl('mobile') ?> </a>
                             <a class="location_confirm" href="<?php echo url?>/location_confirm/add/mobile">  <i class="fa fa-upload"></i> </a>
                         </li>
                         <li class="location_confirm">
                             <a class="location_confirm" href="<?php echo url?>/location_confirm/camera"> <?php  echo $this->langControl('camera') ?> </a>
                             <a class="location_confirm" href="<?php echo url?>/location_confirm/add/camera">  <i class="fa fa-upload"></i> </a>
                         </li>

                         <li class="location_confirm">
                             <a class="location_confirm" href="<?php echo url?>/location_confirm/computer"> <?php  echo $this->langControl('computer') ?> </a>
                             <a class="location_confirm" href="<?php echo url?>/location_confirm/add/computer">  <i class="fa fa-upload"></i> </a>
                         </li>

                         <li class="location_confirm">
                             <a class="location_confirm" href="<?php echo url?>/location_confirm/games"> <?php  echo $this->langControl('games') ?> </a>
                             <a class="location_confirm" href="<?php echo url?>/location_confirm/add/games">  <i class="fa fa-upload"></i> </a>
                         </li>

                         <li class="location_confirm">
                             <a class="location_confirm" href="<?php echo url?>/location_confirm/network"> <?php  echo $this->langControl('network') ?> </a>
                             <a class="location_confirm" href="<?php echo url?>/location_confirm/add/network">  <i class="fa fa-upload"></i> </a>
                         </li>

                         <li class="location_confirm">
                             <a class="location_confirm" href="<?php echo url?>/location_confirm/printing_supplies"> <?php  echo $this->langControl('printing_supplies') ?> </a>
                             <a class="location_confirm" href="<?php echo url?>/location_confirm/add/printing_supplies">  <i class="fa fa-upload"></i> </a>
                         </li>

                         <li class="location_confirm">
                             <a class="location_confirm" href="<?php echo url?>/location_confirm/accessories"> <?php  echo $this->langControl('accessories') ?> </a>
                             <a class="location_confirm" href="<?php echo url?>/location_confirm/add/accessories">  <i class="fa fa-upload"></i> </a>
                         </li>
                         <li class="location_confirm">
                             <a class="location_confirm" href="<?php echo url?>/location_confirm/savers"> <?php  echo $this->langControl('savers') ?> </a>
                             <a class="location_confirm" href="<?php echo url?>/location_confirm/add/savers">  <i class="fa fa-upload"></i> </a>
                         </li>

                     </ul>


                 </li>

			 <?php  }  ?>


             <?php  if ($this->permit('excel_location','excel_location')) {  ?>
                 <li class="excel_location">  <a href="#">  <?php  echo $this->langControl('excel_location') ?> </a>

                     <ul>
                         <li class="excel_location">
                             <a class="excel_location" href="<?php echo url?>/excel_location/mobile"> <?php  echo $this->langControl('mobile') ?> </a>
                             <a class="excel_location" href="<?php echo url?>/excel_location/add/mobile">  <i class="fa fa-upload"></i> </a>
                         </li>
                         <li class="excel_location">
                             <a class="excel_location" href="<?php echo url?>/excel_location/camera"> <?php  echo $this->langControl('camera') ?> </a>
                             <a class="excel_location" href="<?php echo url?>/excel_location/add/camera">  <i class="fa fa-upload"></i> </a>
                         </li>

                         <li class="excel_location">
                             <a class="excel_location" href="<?php echo url?>/excel_location/computer"> <?php  echo $this->langControl('computer') ?> </a>
                             <a class="excel_location" href="<?php echo url?>/excel_location/add/computer">  <i class="fa fa-upload"></i> </a>
                         </li>

                         <li class="excel_location">
                             <a class="excel_location" href="<?php echo url?>/excel_location/games"> <?php  echo $this->langControl('games') ?> </a>
                             <a class="excel_location" href="<?php echo url?>/excel_location/add/games">  <i class="fa fa-upload"></i> </a>
                         </li>

                         <li class="excel_location">
                             <a class="excel_location" href="<?php echo url?>/excel_location/network"> <?php  echo $this->langControl('network') ?> </a>
                             <a class="excel_location" href="<?php echo url?>/excel_location/add/network">  <i class="fa fa-upload"></i> </a>
                         </li>

                         <li class="excel_location">
                             <a class="excel_location" href="<?php echo url?>/excel_location/printing_supplies"> <?php  echo $this->langControl('printing_supplies') ?> </a>
                             <a class="excel_location" href="<?php echo url?>/excel_location/add/printing_supplies">  <i class="fa fa-upload"></i> </a>
                         </li>

                         <li class="excel_location">
                             <a class="excel_location" href="<?php echo url?>/excel_location/accessories"> <?php  echo $this->langControl('accessories') ?> </a>
                             <a class="excel_location" href="<?php echo url?>/excel_location/add/accessories">  <i class="fa fa-upload"></i> </a>
                         </li>
                         <li class="excel_location">
                             <a class="excel_location" href="<?php echo url?>/excel_location/savers"> <?php  echo $this->langControl('savers') ?> </a>
                             <a class="excel_location" href="<?php echo url?>/excel_location/add/savers">  <i class="fa fa-upload"></i> </a>
                         </li>

                     </ul>


                 </li>

             <?php  }  ?>
             <?php  if ($this->permit('case_reports','case_reports')) {  ?>
                 <li class="case_reports">  <a href="#">  <?php  echo $this->langControl('case_reports') ?> </a>

                     <ul>
                         <li class="case_reports">
                             <a class="case_reports" href="<?php echo url?>/case_reports/list_case/mobile"> <?php  echo $this->langControl('mobile') ?> </a>
                         </li>
                         <li class="case_reports">
                             <a class="case_reports" href="<?php echo url?>/case_reports/list_case/camera"> <?php  echo $this->langControl('camera') ?> </a>
                         </li>

                         <li class="case_reports">
                             <a class="case_reports" href="<?php echo url?>/case_reports/list_case/computer"> <?php  echo $this->langControl('computer') ?> </a>
                         </li>

                         <li class="case_reports">
                             <a class="case_reports" href="<?php echo url?>/case_reports/list_case/games"> <?php  echo $this->langControl('games') ?> </a>
                         </li>

                         <li class="case_reports">
                             <a class="case_reports" href="<?php echo url?>/case_reports/list_case/network"> <?php  echo $this->langControl('network') ?> </a>
                         </li>

                         <li class="case_reports">
                             <a class="case_reports" href="<?php echo url?>/case_reports/list_case/printing_supplies"> <?php  echo $this->langControl('printing_supplies') ?> </a>
                         </li>

                         <li class="case_reports">
                             <a class="case_reports" href="<?php echo url?>/case_reports/list_case/accessories"> <?php  echo $this->langControl('accessories') ?> </a>
                         </li>
                         <li class="case_reports">
                             <a class="case_reports" href="<?php echo url?>/case_reports/list_case/savers"> <?php  echo $this->langControl('savers') ?> </a>
                         </li>

                     </ul>


                 </li>

             <?php  }  ?>


			 <?php  if ($this->permit('compare_warehouses','compare_warehouses')) {  ?>
                 <li class="compare_warehouses">

                     <?php if (empty($wc)) { ?>
                     <a href="<?php echo url?>/compare_warehouses/add"> <?php  echo $this->langControl('compare_warehouses') ?> </a>
                     <?php } else{ ?>
                         <?php  foreach ($wc as $w) {  ?>
                         <a href="<?php echo url?>/compare_warehouses/index/<?php echo $w['category'] ?>/<?php echo $w['type'] ?>"> <?php  echo $this->langControl('compare_warehouses') ?> </a>
						 <?php } ?>
					 <?php } ?>

                     <a class="compare_warehouses" href="<?php echo url?>/compare_warehouses/cover"  data-toggle="tooltip" data-placement="top"  title="خاص في الحافظات">  <i class="fa fa-folder-open-o"></i> </a>



                 </li>
			 <?php  } ?>


             <?php  if ($this->permit('statistics','statistics')) {  ?>
             <li class="statistics"> <a href="<?php echo url?>/statistics"> <?php  echo $this->langControl('statistics') ?> </a> </li>

             <?php  } ?>



             <?php  if ($this->permit('all_active_buy','accountant')) {  ?>
                 <li class="accountant">  <a href="<?php echo url?>/accountant" > <?php  echo $this->langControl('accountant') ?>    </a>

                     <span class="bellOrder">   <i class="fa fa-bell "> </i> <?php $accountant = new accountant();  echo $accountant-> all_notification_buy() ?> </span>

                 </li>

                 <style>
                     span.bellOrder {
                         margin-right: 6px;
                     }
                     .bellOrder .fa-bell
                     {
                     <?php  if ($accountant-> all_notification_buy() > 0) {  ?>
                         color: red;

                     <?php  }  ?>
                     }

                 </style>



             <?php  }  ?>



             <?php  if ($this->permit('all_active_buy','accountant')) {  ?>
                 <li class="under_accounting">  <a href="<?php echo url?>/accountant/under_accounting" > <?php  echo $this->langControl('under_accounting') ?>    </a>

                     <span class="bellOrder">   <i class="fa fa-bell "> </i> <?php $accountant = new accountant();  echo $accountant-> all_notification_buy() ?> </span>

                 </li>

                 <style>
                     span.bellOrder {
                         margin-right: 6px;
                     }
                     .bellOrder .fa-bell
                     {
                     <?php  if ($accountant-> all_notification_buy() > 0) {  ?>
                         color: red;

                     <?php  }  ?>
                     }

                 </style>



             <?php  }  ?>



             <?php  if ($this->permit('all_active_buy','prepared')) {  ?>
                 <li class="prepared">  <a href="<?php echo url?>/prepared" > <?php  echo $this->langControl('prepared') ?>    </a>

                     <span class="bellOrder">   <i class="fa fa-bell "> </i> <?php $prepared = new prepared();  echo $prepared-> all_notification_buy() ?> </span>

                 </li>

                 <style>
                     span.bellOrder {
                         margin-right: 6px;
                     }
                     .bellOrder .fa-bell
                     {
                     <?php  if ($prepared-> all_notification_buy() > 0) {  ?>
                         color: red;

                     <?php  }  ?>
                     }

                 </style>



             <?php  }  ?>

             <?php  if ($this->permit('direct','direct')) {  ?>
                 <?php  if ($this->isDirect() || $this->admin($this->userid) )  { ?>
                     <?php if ( $_SESSION['direct'] == 2 || $this->admin($this->userid)) { ?>
                 <li class="direct">  <a href="<?php echo url?>/direct" > <?php  echo $this->langControl('direct2') ?>    </a>

                     <span class="bellOrder">   <i class="fa fa-bell "> </i> <?php $direct = new direct();  echo $direct-> all_notification_buy() ?> </span>

                 </li>

                 <style>
                     span.bellOrder {
                         margin-right: 6px;
                     }
                     .bellOrder .fa-bell
                     {
                     <?php  if ($direct-> all_notification_buy() > 0) {  ?>
                         color: red;

                     <?php  }  ?>
                     }

                 </style>

                 <?php  }  ?>
                <?php  }  ?>

             <?php  }  ?>

             <?php  if ($this->permit('direct','direct')) {  ?>
                 <?php  if ($this->isDirect() || $this->admin($this->userid) )  { ?>
                     <?php if ( $_SESSION['direct'] == 3 || $this->admin($this->userid)) { ?>
                 <li class="direct">  <a href="<?php echo url?>/direct/direct3_account" > <?php  echo $this->langControl('direct3') ?>    </a>

                     <span class="bellOrder">   <i class="fa fa-bell "> </i> <?php $direct = new direct();  echo $direct-> all_notification_buy3() ?> </span>

                 </li>

                 <style>
                     span.bellOrder {
                         margin-right: 6px;
                     }
                     .bellOrder .fa-bell
                     {
                     <?php  if ($direct-> all_notification_buy3() > 0) {  ?>
                         color: red;

                     <?php  }  ?>
                     }

                 </style>

                 <?php  }  ?>
                <?php  }  ?>

             <?php  }  ?>



             <?php  if ($this->permit('main_log_accountant','main_log_accountant')) {  ?>
                 <li class="register">  <a href="<?php echo url?>/main_log_accountant" > <?php  echo $this->langControl('main_log_accountant') ?>    </a>

                 </li>

             <?php  }  ?>



             <?php  if ($this->permit('log_accountant','log_accountant')) {  ?>
                 <li class="register">  <a href="<?php echo url?>/log_accountant" > <?php  echo $this->langControl('log_accountant') ?>    </a>

                 </li>

             <?php  }  ?>


			 <?php  if ($this->permit('bill_main_accountant','bill_main_accountant')) {  ?>
                 <li class="bill_main_accountant">  <a href="<?php echo url?>/bill_main_accountant" > <?php  echo $this->langControl('bill_main_accountant') ?>    </a>

                 </li>

			 <?php  }  ?>

			 <?php  if ($this->permit('bill_secondary_accountant','bill_secondary_accountant')) {  ?>
                 <li class="bill_secondary_accountant">  <a href="<?php echo url?>/bill_secondary_accountant" > <?php  echo $this->langControl('bill_secondary_accountant') ?>    </a>
                 </li>
			 <?php  }  ?>



			 <?php  if ($this->permit('account_bill_purchase_customer','purchase_customer')) {  ?>
                 <li class="code"> <a href="<?php echo url ?>/purchase_customer"> <?php  echo $this->langControl('account_bill_purchase_customer') ?> </a> </li>
			 <?php  }  ?>



			 <?php  if ($this->permit('purchase_customer','purchase_customer')) {  ?>
                 <li class="purchase_customer">  <a href="#" > <?php  echo $this->langControl('purchase_customer') ?>    </a>

                     <ul>
						 <?php  if ($this->permit('purchase','purchase_customer')) {  ?>
                             <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/purchase"> شراء جهاز </a> </li>
						 <?php  } ?>
						 <?php  if ($this->permit('bills_enter','purchase_customer')) {  ?>
                             <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/bills_enter">   فواتير شراء مدخلة  </a> </li>
						 <?php  } ?>
						 <?php  if ($this->permit('bills_note_enter','purchase_customer')) {  ?>
                             <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/bills_note_enter">   فواتير شراء غير مدخلة  </a>

                                 <span class="all_purchase_customer_note_enter_bill">   <i class="fa fa-bell "> </i> <?php $purchase_customer = new purchase_customer();  echo $purchase_customer-> all_purchase_customer_note_enter_bill() ?> </span>

                             </li>

                             <style>
                                 span.all_purchase_customer_note_enter_bill {
                                     margin-right: 6px;
                                 }
                                 .all_purchase_customer_note_enter_bill .fa-bell
                                 {
                                 <?php  if ($purchase_customer-> all_purchase_customer_note_enter_bill() > 0) {  ?>
                                     color: red;

                                 <?php  }  ?>
                                 }

                             </style>


                         <?php  } ?>

						 <?php  if ($this->permit('bills_checked','purchase_customer')) {  ?>
                             <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/bills_checked">   فواتير  شراء مدققه   </a> </li>
						 <?php  } ?>
						 <?php  if ($this->permit('bills_note_checked','purchase_customer')) {  ?>
                             <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/bills_note_checked">   فواتير شراء غير مدققه   </a> </li>
						 <?php  } ?>
						 <?php  if ($this->permit('bills_edit','purchase_customer')) {  ?>
                             <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/bills_edit">   فواتير  شراء تم التعديل عليها   </a> </li>
						 <?php  } ?>
						 <?php  if ($this->permit('bills_cancel','purchase_customer')) {  ?>
                             <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/bills_cancel">   فواتير  شراء ملغيه </a> </li>
						 <?php  } ?>

                     </ul>

                 </li>

			 <?php  }  ?>




			 <?php  if ($this->permit('rewind','rewind')) {  ?>
                 <li class="rewind">  <a href="#" > <?php  echo $this->langControl('rewind') ?>    </a>

                     <ul>

						 <?php  if ($this->permit('bills_enter','rewind')) {  ?>
                             <li class="rewind"> <a  class="rewind" href="<?php echo url?>/rewind/bills_enter">   فواتير مرتجع مدخلة  </a> </li>
						 <?php  } ?>
						 <?php  if ($this->permit('bills_note_enter','rewind')) {  ?>
                             <li class="rewind"> <a  class="rewind" href="<?php echo url?>/rewind/bills_note_enter">   فواتير مرتجع غير مدخلة  </a>

                                 <span class="all_rewind_note_enter_bill">   <i class="fa fa-bell "> </i> <?php $rewind = new rewind();  echo $rewind-> all_rewind_note_enter_bill() ?> </span>

                             </li>

                             <style>
                                 span.all_rewind_note_enter_bill {
                                     margin-right: 6px;
                                 }
                                 .all_rewind_note_enter_bill .fa-bell
                                 {
                                 <?php  if ($rewind-> all_rewind_note_enter_bill() > 0) {  ?>
                                     color: red;

                                 <?php  }  ?>
                                 }

                             </style>

						 <?php  } ?>

						 <?php  if ($this->permit('bills_checked','rewind')) {  ?>
                             <li class="rewind"> <a  class="rewind" href="<?php echo url?>/rewind/bills_checked">   فواتير  مرتجع مدققه   </a> </li>
						 <?php  } ?>
						 <?php  if ($this->permit('bills_note_checked','rewind')) {  ?>
                             <li class="rewind"> <a  class="rewind" href="<?php echo url?>/rewind/bills_note_checked">   فواتير مرتجع غير مدققه   </a> </li>
						 <?php  } ?>
						 <?php  if ($this->permit('bills_edit','rewind')) {  ?>
                             <li class="rewind"> <a  class="rewind" href="<?php echo url?>/rewind/bills_edit">   فواتير  مرتجع تم التعديل عليها   </a> </li>
						 <?php  } ?>

                     </ul>

                 </li>

			 <?php  }  ?>








             <?php  if ($this->permit('money_clipper','money_clipper')) {  ?>
                 <li class="money_clipper"> <a  href="#"> <?php  echo $this->langControl('money_clipper') ?> </a>
                     <ul>
						 <?php  if ($this->permit('details_money_clipper','money_clipper')) {  ?>
                             <li class="money_clipper"> <a  class="money_clipper" href="<?php echo url?>/money_clipper/details_money_clipper">  تفاصيل القاصة   </a> </li>
						 <?php  } ?>

						 <?php  if ($this->permit('record_add_money_clipper','money_clipper')) {  ?>
                             <li class="money_clipper"> <a  class="money_clipper" href="<?php echo url?>/money_clipper/record_add_money_clipper">     سجل الاضافة   الى القاصه  </a> </li>
						 <?php  } ?>
						 <?php  if ($this->permit('withdraw','money_clipper')) {  ?>
                             <li class="money_clipper"> <a  class="money_clipper" href="<?php echo url?>/money_clipper/withdraw">     سجل السحب من القاصه  </a> </li>
						 <?php  } ?>

						 <?php  if ($this->permit('main_user','money_clipper')) {  ?>
                             <li class="money_clipper"> <a  class="money_clipper" href="<?php echo url?>/money_clipper/main_user">  المحاسبين الرئيسيين   </a> </li>
						 <?php  } ?>
						 <?php  if ($this->permit('secondary_user','money_clipper')) {  ?>
                             <li class="money_clipper"> <a  class="money_clipper" href="<?php echo url?>/money_clipper/secondary_user">  المحاسبين الثانوين  </a> </li>
						 <?php  } ?>

                     </ul>
                 </li>
			 <?php  } ?>



             <?php  if ($this->permit('group_location','group_location')) {  ?>
                 <li class="code"> <a href="<?php echo url ?>/group_location/list_group_location"> <?php  echo $this->langControl('group_location') ?> </a> </li>
             <?php  }  ?>


             <?php  if ($this->permit('bills_inside_system','bills_inside_system')) {  ?>
                 <li class="bills_inside_system">  <a href="#" > <?php  echo $this->langControl('bills_inside_system') ?>    </a>
                     <span class="delete_bill">   <i class="fa fa-star "> </i> <?php $bills_inside_system = new bills_inside_system();  echo $bills_inside_system-> all_delete_bill() ?> </span>

                     <ul>

						 <?php  if ($this->permit('all','bills_inside_system')) {  ?>
                             <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system">   كل الفواتير   </a> </li>
						 <?php  } ?>


						 <?php  if ($this->permit('bills_crystal_enter','bills_inside_system')) {  ?>
                             <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/bills_crystal_enter">  فواتر كرستال مدخلة</a> </li>
						 <?php  } ?>


						 <?php  if ($this->permit('bills_crystal_not_enter','bills_inside_system')) {  ?>
                             <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/bills_crystal_not_enter">  فواتر كرستال غير مدخلة   </a>



                                 <span class="all_note_enter_bill">   <i class="fa fa-bell "> </i> <?php $bills_inside_system = new bills_inside_system();  echo $bills_inside_system-> all_note_enter_bill() ?> </span>

                             </li>

                             <style>
                                 span.all_note_enter_bill {
                                     margin-right: 6px;
                                 }
                                 .all_note_enter_bill .fa-bell
                                 {
                                 <?php  if ($bills_inside_system-> all_note_enter_bill() > 0) {  ?>
                                     color: red;

                                 <?php  }  ?>
                                 }

                             </style>



                         <?php  } ?>


                         <?php  if ($this->permit('group_not_enter','bills_inside_system')) {  ?>
                             <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/group_not_enter">  مجاميع بإنتضار كتابة رقم فاتورة كرستال لها  </a> </li>
                         <?php  } ?>


                         <?php  if ($this->permit('group_enter','bills_inside_system')) {  ?>
                             <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/group_enter">  مجاميع  تم ادخال  رقم فاتورة كرستال لها  </a> </li>
                         <?php  } ?>



						 <?php  if ($this->permit('bills_checked','bills_inside_system')) {  ?>
                             <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/bills_checked">   فواتير مدققه  </a> </li>
						 <?php  } ?>

						 <?php  if ($this->permit('bills_note_checked','bills_inside_system')) {  ?>
                             <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/bills_note_checked">   فواتير غير مدققه  </a> </li>
						 <?php  } ?>
						 <?php  if ($this->permit('bills_crystal_edit_bill','bills_inside_system')) {  ?>
                             <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/bills_crystal_edit_bill">    فواتير تم التعديل عليها  </a> </li>
						 <?php  } ?>

						 <?php  if ($this->permit('bills_deleted','bills_inside_system')) {  ?>
                             <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/bills_deleted">    فواتير  ملغية </a>


                                 <span class="delete_bill">   <i class="fa fa-star "> </i> <?php $bills_inside_system = new bills_inside_system();  echo $bills_inside_system-> all_delete_bill() ?> </span>

                             </li>

                             <style>
                                 span.delete_bill {
                                     margin-right: 6px;
                                 }
                                 .delete_bill .fa-star
                                 {
                                 <?php  if ($bills_inside_system-> all_delete_bill() > 0) {  ?>
                                     color: red;

                                 <?php  }  ?>
                                 }

                             </style>


						 <?php  } ?>


                         <?php  if ($this->permit('bills_crystal_note_enter_deleted','bills_inside_system')) {  ?>
                             <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/bills_crystal_note_enter_deleted">    فواتير غير مدخلة ملغية </a> </li>
                         <?php  } ?>


                     </ul>

                 </li>

             <?php  }  ?>




             <?php  if ($this->permit('report_sale','report_sale')) {  ?>
                 <li class="report_sale">  <a href="#" >  تقرير المبيعات </a>

                     <ul>
						 <?php  if ($this->permit('report_sale','bills_all')) {  ?>
                             <li class="report_sale"> <a  class="report_sale" href="#">تم المحاسبة</a> </li>
						 <?php  } ?>

						 <?php  if ($this->permit('report_sale','bills_all')) {  ?>
                             <li class="report_sale"> <a  class="report_sale" href="#">تم التجهيز  </a> </li>
						 <?php  } ?>



                     </ul>

                 </li>

             <?php  }  ?>



             <?php  if ($this->permit('location_report','location_report')) {  ?>
                 <li class="location_report">  <a href="#" >  <?php  echo $this->langControl('location_report') ?>  </a>

                     <ul>
						 <?php  if ($this->permit('view_location','location_report')) {  ?>
                             <li class="location_report"> <a  class="location_report" href="<?php  echo url ?>/location_report/location">  عرض المواقع  </a> </li>
						 <?php  } ?>

						 <?php  if ($this->permit('create_transporter','location_report')) {  ?>
                             <li class="location_report"> <a  class="location_report" href="<?php  echo url ?>/location_report/report">  انشاء مناقلة  </a> </li>
						 <?php  } ?>
						 <?php  if ($this->permit('transport_not_confirm','location_report')) {  ?>
                             <li class="location_report"> <a  class="location_report" href="<?php  echo url ?>/location_report/transport_not_confirm">   مناقلات غير مؤكدة    </a> <a data-toggle="tooltip" data-placement="top"  title="not click" class="location_report" href="<?php  echo url ?>/location_report/view_transport_not_confirm">   <i style="font-size: 10px" class="fa fa-arrow-right"></i>   </a> </li>

						 <?php  } ?>

						 <?php  if ($this->permit('transport_confirm','location_report')) {  ?>
                             <li class="location_report"> <a  class="location_report" href="<?php  echo url ?>/location_report/transport_confirm">   مناقلات  مؤكدة    </a> <a data-toggle="tooltip" data-placement="top"  title="not click" class="location_report" href="<?php  echo url ?>/location_report/view_transport_confirm">   <i style="font-size: 10px" class="fa fa-arrow-right"></i>   </a> </li>

						 <?php  } ?>

                     </ul>

                 </li>

             <?php  }  ?>






             <?php  if ($this->permit('register','register')) {  ?>
             <li class="register"> <a  href="#"> <?php  echo $this->langControl('registration') ?>

                     <a target="_blank" href="<?php echo  url ?>/customers/add_customers"  class="customers" data-toggle="tooltip" data-placement="top" title="اضافة زبون"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/customers/search"  class="customers" data-toggle="tooltip" data-placement="top" title="بحث عن زبون"><i class="fa fa-search" aria-hidden="true"></i></a>

                 </a>
                 <ul>
                     <?php  if ($this->permit('subscribers','register')) {  ?>
                      <li class="register"> <a  class="register" href="<?php echo url?>/register/subscribers"> عرض الكل </a> </li>
                     <?php  } ?>
                     <?php  if ($this->permit('subscribers1','register')) {  ?>
                     <li class="register"> <a  class="register" href="<?php echo url?>/register/subscribers1">  زبائن مقتنعين   </a> </li>
                     <?php  } ?>
                     <?php  if ($this->permit('subscribers2','register')) {  ?>
                     <li class="register"> <a  class="register" href="<?php echo url?>/register/subscribers2">   زبائن غير  مقتنيعين </a> </li>
                     <?php  } ?>
                 </ul>
                 </li>
             <?php  } ?>



             <?php  if ($this->permit('code','code')) {  ?>
             <li class="code"> <a href="<?php echo url?>/code"> <?php  echo $this->langControl('check_code') ?> </a> </li>
             <?php  }  ?>

             <?php  if ($this->permit('report_upload','report')) {  ?>
             <li class="report"> <a href="<?php echo url?>/report/report_upload"> <?php  echo $this->langControl('report_upload') ?> </a> </li>
             <?php  }  ?>

             <?php  if ($this->permit('report_withdrawn','report')) {  ?>
             <li class="report"> <a href="<?php echo url?>/report/report_withdrawn"> <?php  echo $this->langControl('report_withdrawn') ?> </a> </li>
             <?php  }  ?>

             <?php  if ($this->permit('add_material_report','add_material_report')) {  ?>
             <li class="report"> <a href="<?php echo url?>/add_material_report"> <?php  echo $this->langControl('add_material_report') ?> </a> </li>
             <?php  }  ?>

             <?php  if ($this->permit('view_bills','bills')) {  ?>
             <li class="bills"> <a href="<?php echo url?>/bills"> <?php  echo $this->langControl('view_bills') ?> </a> </li>
             <?php  }  ?>

             <?php  if ($this->permit('insert_bills','bills')) {  ?>
             <li class="bills"> <a href="<?php echo url?>/bills/insert_bills"> <?php  echo $this->langControl('insert_bills') ?> </a> </li>
             <?php  }  ?>



             <?php  if ($this->permit('delivery_user','delivery_user')) {  ?>
                 <li class="delivery_user"> <a href="<?php echo url?>/delivery_user"> <?php  echo $this->langControl('delivery_user') ?> </a> </li>

             <?php  } ?>



             <?php  if ($this->permit('questions','questions')) {  ?>
                 <li class="questions"> <a href="<?php echo url?>/questions/view_questions"> <?php  echo $this->langControl('questions') ?> </a>
                     <a  class="questions" href="<?php echo url?>/questions/add" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add')  ?>">  <i class="fa fa-plus-circle" aria-hidden="true"></i> </a>
                 </li>
             <?php  } ?>

             <?php  if ($this->permit('competition','competition')) {  ?>
                 <li class="competition">  <a href="<?php echo url?>/competition/view_competition">  اجابات الزبائن على المسابقة </a> </li>

             <?php  } ?>
             <?php  if ($this->permit('list_groups','groups')) {  ?>
                 <li class="groups"> <a href="#"><?php  echo $this->langControl('groups') ?></a>
                     <a href="<?php echo  url ?>/groups/add_category"  class="groups" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/groups/admin_category"  class="groups" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                     <ul>
                         <?php foreach ($categorygroups as $cat) {   ?>
                             <?php  if ($groups->ck_sub_cat($cat['id'])) { ?>
                                 <li class="<?php echo $groups->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="groups"> <?php   echo $cat['title']?> </a>
                                     <a href="<?php echo  url ?>/groups/edit_category/<?php   echo $cat['id'] ?>"  class="groups" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/groups/add_category/<?php   echo $cat['id'] ?>"  class="groups" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/groups/admin_category/<?php   echo $cat['id']?>"  class="groups" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                                     <?php   $groups->listSubCategory($cat['id'],$id) ?>
                                 </li>
                             <?php  }else { ?>
                                 <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/groups/list_groups/<?php    echo $cat['id'] ?>" class="groups"> <?php   echo $cat['title']?></a>
                                     <a href="<?php echo  url ?>/groups/edit_category/<?php   echo $cat['id'] ?>"  class="groups" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/groups/add_category/<?php   echo $cat['id'] ?>"  class="groups" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                 </li>

                             <?php }  } ?>
                     </ul>
                 </li>
             <?php }  ?>



             <?php  if ($this->permit('list_ads','ads')) {  ?>
                 <li class="ads">  <a href="<?php echo url?>/ads/list_ads"> <?php  echo $this->langControl('ads') ?> </a>

                     <a href="<?php echo  url ?>/ads/add"  class="ads" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>

                 </li>

             <?php  }  ?>



             <?php  if ($this->permit('list_offers','offers')) {  ?>
                 <li class="offers">  <a href="<?php echo url?>/offers/list_offers"> <?php  echo $this->langControl('offers') ?> </a>

                     <a href="<?php echo  url ?>/offers/add"  class="offers" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>

                 </li>

             <?php  }  ?>



             <?php  if ($this->permit('list_how_use','how_use')) {  ?>
                 <li class="how_use">  <a href="<?php echo url?>/how_use/list_how_use"> <?php  echo $this->langControl('how_use') ?> </a>

                     <a href="<?php echo  url ?>/how_use/add"  class="how_use" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>

                 </li>

             <?php  }  ?>



             <?php  if ($this->permit('parts','parts')) {  ?>
                 <li class="parts"> <a href="#"><?php  echo $this->langControl('parts') ?></a>

                     <a href="<?php echo  url ?>/parts/add_category"  class="parts" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/parts/admin_category"  class="parts" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>

                     <ul>
                         <?php foreach ($category_parts as $cat) {   ?>
                             <?php  if ($parts->ck_sub_cat($cat['id'])) { ?>
                                 <li class="<?php echo $parts->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="parts"> <?php   echo $cat['title']?> </a>
                                     <a href="<?php echo  url ?>/parts/list_parts/<?php   echo $cat['id'] ?>"  class="parts" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_content')  ?>"><i class="fa  fa-folder" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/parts/edit_category/<?php   echo $cat['id'] ?>"  class="parts" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/parts/add_category/<?php   echo $cat['id'] ?>"  class="parts" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/parts/admin_category/<?php   echo $cat['id']?>"  class="parts" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                                     <?php   $parts->listSubCategory($cat['id'],$id) ?>
                                 </li>
                             <?php  }else { ?>
                                 <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/parts/list_parts/<?php    echo $cat['id'] ?>" class="parts"> <?php   echo $cat['title']?></a>
                                     <a href="<?php echo  url ?>/parts/edit_category/<?php   echo $cat['id'] ?>"  class="parts" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/parts/add_category/<?php   echo $cat['id'] ?>"  class="parts" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                 </li>

                             <?php }  } ?>
                     </ul>
                 </li>
             <?php } ?>


             <?php  if ($this->permit('list_pages','pages')) {  ?>
                 <li class="pages"> <a href="#"><?php  echo $this->langControl('pages') ?></a>
                     <a href="<?php echo  url ?>/pages/add_category"  class="pages" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                     <a href="<?php echo  url ?>/pages/admin_category"  class="pages" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                     <ul>
                         <?php foreach ($categorypages as $cat) {   ?>
                             <?php  if ($pages->ck_sub_cat($cat['id'])) { ?>
                                 <li class="<?php echo $pages->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="pages"> <?php   echo $cat['title']?> </a>
                                     <a href="<?php echo  url ?>/pages/edit_category/<?php   echo $cat['id'] ?>"  class="pages" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/pages/add_category/<?php   echo $cat['id'] ?>"  class="pages" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/pages/admin_category/<?php   echo $cat['id']?>"  class="pages" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                                     <?php   $pages->listSubCategory($cat['id'],$id) ?>
                                 </li>
                             <?php  }else { ?>
                                 <li class="card_<?php echo $cat['id']?>">  <?php   echo $cat['title']?>
                                     <a href="<?php echo  url ?>/pages/edit_category/<?php   echo $cat['id'] ?>"  class="pages" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                     <a href="<?php echo  url ?>/pages/add_category/<?php   echo $cat['id'] ?>"  class="pages" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                 </li>

                             <?php }  } ?>
                     </ul>
                 </li>
             <?php  } ?>



             <?php  if ($this->permit('gallery','gallery')) {  ?>
             <li class="gallery"> <a href="#"><?php  echo $this->langControl('gallery') ?></a>
                 <a href="<?php echo  url ?>/gallery/add_category"  class="gallery" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/gallery/admin_category"  class="gallery" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                 <ul>
                     <?php foreach ($category_gallery as $cat) {   ?>
                         <?php  if ($gallery->ck_sub_cat($cat['id'])) { ?>
                             <li class="<?php echo $gallery->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="gallery"> <?php   echo $cat['title']?> </a>
                                 <a href="<?php echo  url ?>/gallery/edit_category/<?php   echo $cat['id'] ?>"  class="gallery" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/gallery/add_category/<?php   echo $cat['id'] ?>"  class="gallery" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/gallery/admin_category/<?php   echo $cat['id']?>"  class="gallery" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                                 <?php   $gallery->listSubCategory($cat['id'],$id) ?>
                             </li>
                         <?php  }else { ?>
                             <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/gallery/list_gallery/<?php    echo $cat['id'] ?>" class="gallery"> <?php   echo $cat['title']?></a>
                                 <a href="<?php echo  url ?>/gallery/edit_category/<?php   echo $cat['id'] ?>"  class="gallery" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                 <a href="<?php echo  url ?>/gallery/add_category/<?php   echo $cat['id'] ?>"  class="gallery" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                             </li>

                         <?php }  } ?>
                 </ul>
             </li>
          <?php } ?>

             <?php  if ($this->permit('user','user')) {  ?>
             <li class="group"> <a href="#">  <?php  echo $this->langControl('group_user') ?></a>

                 <a href="<?php echo  url ?>/user/add_group"  class="group" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                 <a href="<?php echo  url ?>/user/group"  class="group" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>

                 <ul>
                     <?php  foreach ($group_user as $gp_user)  {  ?>
                         <li> <a href="<?php echo url  ?>/user/list_user/<?php echo $gp_user['id']  ?>" class="group"> <?php  echo $gp_user['name'] ?> </a>

                             <a href="<?php echo  url ?>/user/edit_group/<?php   echo $gp_user['id'] ?>"  class="group" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                             <a href="<?php echo  url ?>/permit/admin_permit/<?php   echo $gp_user['id'] ?>"  class="group" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('permit')  ?>"><i class="fa fa-lock" aria-hidden="true"></i></a>

                         </li>
                     <?php  } ?>
                 </ul>
             </li>

             <?php } ?>


             <?php  if ($this->permit('inbox','inbox')) {  ?>

             <li class="inbox"> <a href="<?php echo url?>/inbox/view_inbox"> <?php  echo $this->langControl('view_inbox') ?> </a> </li>
          <?php  }  ?>
             <?php  if ($this->permit('language','language')) {  ?>
             <li class="languageSite">  <a href="<?php echo url?>/lang/view_lang"> <?php  echo $this->langControl('website_translation') ?> </a> </li>
           <?php } ?>

             <?php  if ($this->permit('setting','setting')) {  ?>
             <li class="setting"> <a href="#"> <?php  echo $this->langControl('setting') ?> </a>
                 <ul>
                     <li class="setting"> <a class="setting" href="<?php echo url?>/setting/update"> <?php  echo $this->langControl('information') ?> </a></li>
                     <li class="setting"> <a class="setting" href="<?php echo url?>/setting/link_social_media"> <?php  echo $this->langControl('link_social_media') ?> </a></li>
                     <li class="setting"> <a class="setting" href="<?php echo url?>/setting/image"> <?php  echo $this->langControl('images') ?> </a></li>
                     <li class="setting"> <a class="setting" href="<?php echo url?>/setting/changeLanguage"> <?php  echo $this->langControl('changeLanguage') ?> </a></li>

                 </ul>
             </li>

             <?php  } ?>



             <?php  if ($this->permit('log','log')) {  ?>
             <li class="log">  <a href="<?php echo url?>/log/view_log" class="log"> <?php  echo $this->langControl('log') ?> </a> </li>
             <?php  } ?>

             <?php  if ($this->permit('movement_materials','movement_materials')) {  ?>
             <li class="movement_materials">  <a href="<?php echo url?>/movement_materials" class="movement_materials"> <?php  echo $this->langControl('movement_materials') ?> </a> </li>
             <?php  } ?>

             <?php  if ($this->permit('search_serial','search_serial')) {  ?>
             <li class="search_serial">  <a href="<?php echo url?>/search_serial" class="search_serial"> <?php  echo $this->langControl('search_serial') ?> </a> </li>
             <?php  } ?>

             <?php  if ($this->permit('dollar_price','dollar_price')) {  ?>
             <li class="dollar_price">  <a href="<?php echo url?>/dollar_price" class="dollar_price"> <?php  echo $this->langControl('dollar_price') ?> </a> </li>
             <?php  } ?>


             <?php  if ($this->permit('range_table','range_table')) {  ?>
             <li class="dollar_price">  <a href="<?php echo url?>/range_table/list_range_table" class="range_table"> <?php  echo $this->langControl('range_table') ?> </a> </li>
             <?php  } ?>


             <?php  if ($this->permit('found','found')) {  ?>
             <li class="found">  <a href="<?php echo url?>/found/view" class="found"> <?php  echo $this->langControl('found') ?> </a> </li>
             <?php  } ?>

             <?php  if ($this->permit('trace','trace')) {  ?>
             <li class="trace">  <a href="<?php  echo url  ?>/trace/list_trace" class="trace"> <?php  echo $this->langControl('trace') ?> </a> </li>
             <?php  } ?>


             <?php  if ($this->permit('trace_site','trace_site')) {  ?>
             <li class="trace_site">  <a href="<?php  echo url  ?>/trace_site/list_trace_site" class="trace_site"> <?php  echo $this->langControl('trace_site') ?> </a> </li>
             <?php  } ?>


			


         </ul>


     </div>


<style>
    .menuControl {

        min-height: unset;
        overflow-y: auto;
    }
 .bodyControl {


        overflow-y: auto;
    }


         /* width */
     ::-webkit-scrollbar {
         width: 4px;
         height: 8px;
     }

    /* Track */
    ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px #e9e9e9;

    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #3f51b5c4;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #b30000;
    }





         .menuControl {
             position: relative;
             padding-left:8px;
         }
         .menuControl:after {
             content: "\f0da";
             background-color: #eaeaea;
             position: absolute;
             top: 0;
             left: 0;
             width: 8px;
             height: 100%;
             cursor: w-resize;
             font-family: FontAwesome;
             display: flex;
             align-items: center;
             color: #000000;
         }

     </style>
     <script>


         const BORDER_SIZE =8;
         const panel = document.getElementsByClassName("menuControl")[0];

         let m_pos;
         function resize(e){
             const dx = m_pos - e.x;
             m_pos = e.x;
             panel.style.width = (parseInt(getComputedStyle(panel, '').width) + dx) + "px";
         }

         panel.addEventListener("mousedown", function(e){
             if (e.offsetX < BORDER_SIZE) {
                 m_pos = e.x;
                 document.addEventListener("mousemove", resize, false);
             }
         }, false);

         document.addEventListener("mouseup", function(){
             document.removeEventListener("mousemove", resize, false);
         }, false);

     </script>





     <script>


         $(document).ready(function() {

         $('.menuControl').css('height',Number($('body').height()-57 )+'px')
         $('.bodyControl').css('height',Number($('body').height()-57 )+'px')

         });

         $(document).ready(function() {
             var path = window.location.href;
               path = path.split('?')[0] ;
              var open=$('.file-tree a[href="'+path+'"]').attr('class');
              $('.'+open).addClass('open');
               $('a.'+open).removeClass('open');
               $('.file-tree li a[href="'+path+'"]').addClass('select_this_item');
             $(".file-tree").filetree();
         });
     </script>

     <script src="<?php echo $this->static_file_control ?>/js/file-explore.js"></script>


     <div class="col bodyControl" >

 