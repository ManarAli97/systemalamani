<!DOCTYPE html>

 <html dir="<?php echo $this->dirControl ?>">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=0, maximum-scale=0" />

     <!--    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=off" />-->

     <title><?php echo $this->title;?></title>
     <link rel="icon"   href="<?php echo $this->static_file_site ?>/image/site/logo_notif.png">

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




     <!--custom js-->
     <script src="<?php echo $this->static_file_control ?>/js/custom.js"></script>

     <!--clipboard.min.js-->
     <script src="<?php echo $this->static_file_control ?>/js/clipboard.min.js"></script>


     <!--bootstrap-toggle-->
     <link href="<?php echo $this->static_file_control ?>/bootstrap/toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
     <script src="<?php echo $this->static_file_control ?>/bootstrap/toggle/js/bootstrap-toggle.min.js"></script>

     <!--upload file-->
     <link rel="stylesheet" href="<?php echo $this->static_file_control ?>/dist2/jquerysctipttop.css"/>
     <link rel="stylesheet" href="<?php echo $this->static_file_control ?>/dist2/font-awesome.min.css"/>
     <link rel="stylesheet" href="<?php echo $this->static_file_control ?>/dist2/bootstrap-FileUpload.css"/>
     <script src="<?php echo $this->static_file_control ?>/dist2/bootstrap-FileUpload.js"></script>


     <!--dataTables-->
     <link rel="stylesheet" href="<?php echo $this->static_file_control ?>/datatable/css/jquery.dataTables.min.css">
     <link rel="stylesheet" href="<?php echo $this->static_file_control ?>/datatable/css/dataTables.bootstrap4.min.css">
     <script type="text/javascript" src="<?php echo $this->static_file_control ?>/datatable/js/jquery.dataTables.min.js"></script>
     <script type="text/javascript" src="<?php echo $this->static_file_control ?>/datatable/js/dataTables.bootstrap4.min.js"></script>


     <!--editor css -->
     <link  rel="stylesheet" href="<?php echo $this->static_file_control ?>/editor/link.css">
<!--     pagenation-->
     <script src="<?php echo $this->static_file_control ?>/js/pagenation/twbsPagination.js"></script>




     <script type="text/javascript" language="javascript" src="<?php echo $this->static_file_control ?>/datatable/js/dataTables.buttons.min.js"></script>
     <script type="text/javascript" language="javascript" src="<?php echo $this->static_file_control ?>/datatable/js/buttons.flash.min.js"></script>
     <script type="text/javascript" language="javascript" src="<?php echo $this->static_file_control ?>/datatable/js/jszip.min.js"></script>
     <script type="text/javascript" language="javascript" src="<?php echo $this->static_file_control ?>/datatable/js/pdfmake.min.js"></script>
     <script type="text/javascript" language="javascript" src="<?php echo $this->static_file_control ?>/datatable/js/vfs_fonts.js"></script>
     <script type="text/javascript" language="javascript" src="<?php echo $this->static_file_control ?>/datatable/js/buttons.html5.min.js"></script>
     <script type="text/javascript" language="javascript" src="<?php echo $this->static_file_control ?>/datatable/js/buttons.print.min.js"></script>


     <link rel="stylesheet" type="text/css" href="<?php echo $this->static_file_control ?>/datatable/css/buttons.dataTables.min.css">


     <script  src="<?php echo $this->static_file_control ?>/datatable/js/dataTables.fixedColumns.js"></script>
     <link href="<?php echo $this->static_file_control ?>/datatable/css/bootstrap.min.css">
     <link href="<?php echo $this->static_file_control ?>/datatable/css/dataTables.bootstrap.css">
     <link href="<?php echo $this->static_file_control ?>/datatable/css/fixedColumns.bootstrap.css">


     <script src="<?php echo $this->static_file_control ?>/datatable/js/dataTables.fixedColumns.min.js"></script>
     <script src="<?php echo $this->static_file_control ?>/datatable/js/buttons.colVis.min.js"></script>
     <script src="<?php echo $this->static_file_control ?>/js/JsBarcode.all.min.js"></script>
     <script src="<?php echo $this->static_file_control ?>/js/Tafqeet.js"></script>
     <link rel="stylesheet" href="<?php echo $this->static_file_control ?>/datatable/css/fixedColumns.dataTables.min.css">

     <!--             search in select  -->
     <link rel="stylesheet" href="<?php echo $this->static_file_control ?>/select/bootstrap-select.css" />
     <script src="<?php echo $this->static_file_control ?>/select/bootstrap-select.min.js"></script>
     <script src="<?php echo $this->static_file_site ?>/camera/app.js"></script>


     <script src="<?php echo $this->static_file_site ?>/select/bootstrap3-typeahead.min.js"></script>
     <script src="<?php echo $this->static_file_site ?>/select/bootstrap-multiselect.js"></script>
     <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/select/bootstrap-multiselect.css" />


 </head>
 <body >



 <div class="fixed-top">
 <nav class="navbar navbar-expand-lg navbar-light bg-light top_menu_admin">
     <button onclick="get_main_menu()" value="0"  class="btn navbar-brand main_menu "> <i class="fa fa-list"></i>   <span>القائمة الرئيسيه</span> </button>

     <script>


         function noty_menu() {

             $.get("<?php  echo url ?>/bills_inside_system/noty_menu", function (data) {
                 if (data) {
                     if (data > '0')
                     {
                         $('.all_note_enter_bill i').css('color','red')
                         $('.noty_bills_inside_system').text(data)

                     }
                 }
             });
         }

         function get_main_menu()
         {

             if ($('.main_menu').val() === '1' ){

                 $( ".menuControl" ).toggle();
                 $('.main_menu').val(1).toggleClass('main_menu_active');

             }else
             {

                 if (localStorage.getItem('menu'))
                 {

                     $('.main_menu').val(1).toggleClass('main_menu_active');

                     $(".menuControl").html(`
                   <div class="loading_menu"></div>
                    `).addClass('active_menu').show();
                     setTimeout(function () {
                         $( ".menuControl" ).html( localStorage.getItem('menu') );
                         set_menu()

                     },50);

                 }else {

                     $('.main_menu').val(1).toggleClass('main_menu_active');

                     $(".menuControl").html(`
                   <div class="loading_menu"></div>
                 `).addClass('active_menu').show();

                     $.get("<?php  echo url . '/' . $this->folder ?>/menu/<?php  echo $id ?>", function (data) {
                         if (data) {

                             localStorage.setItem('menu', data);

                             $(".menuControl").html(data);
                             set_menu()

                             $.get("<?php  echo url ?>/bills_inside_system/noty_menu", function (data) {

                                 if (data > '0')
                                 {
                                     $('.all_note_enter_bill i').css('color','red')
                                     $('.noty_bills_inside_system').text(data)

                                 }

                             });


                         }

                     });
                 }
             }



         }


     </script>


     <a class="navbar-brand logoAdmin" href="<?php echo url ; ?>/home" >
        APP
     </a>

    <a class="navbar-brand logoAdmin" href="<?php echo url ; ?>" >
       home
     </a>


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
     
     
     		 <?php if ($this->permit('reminder_purchase', 'purchase')) {?>
                <a   href="<?php  echo url ?>/purchase/reminder_purchase" id="add_reminder"   class="btn add_reminder">
                    <i class="fa fa-bell icon_reminder" ></i>

            </a>
            <?php } ?>
     
           <?php if ($this->permit('quantity_error', 'savers') ||$this->permit('quantity_error', 'mobile') ||$this->permit('quantity_error', 'accessories') ||$this->permit('quantity_error', 'camera') ||$this->permit('quantity_error', 'computer') ||$this->permit('quantity_error', 'games') ||$this->permit('quantity_error', 'network') ) {?>
            <div class=' my-2 my-lg-0'>
                <a   href="<?php  echo url ?>/quantity_change_control" class="btn warning" id ="quantity_warning" data-toggle="tooltip" data-placement="top" title=" تحذير الكميات  "> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>
            </div>
            <?php } ?>
             <div class=" my-2 my-lg-0">
                 <?php  if ($this->permit('min_max','accessories') )  { ?>
                   <?php if ($min) {  ?>
                     <a   href="<?php  echo url ?>/accessories/min_max" class="btn min_max"  data-toggle="tooltip" data-placement="top" title="مواد في الحد الادنى"> <i class="fa fa-sort-numeric-desc" aria-hidden="true"></i></a>


                     <style>
                     a.warning {

                        display: block;
                        width: 32px;
                        height: 32px;
                        border-radius: 50%;
                        margin-left: 19px;
                        padding: 0;
                        background-color: green;
                        color: #ffffff;
                        font-size: 19px;
                        /* transition: background .3s; */
                        cursor: pointer;
                        border: none;
                        -webkit-appearance: none;
                        -moz-appearance: none;
                        appearance: none;
                        box-shadow: none;
                        outline: 0 !important;
                        animation: animation_warning 4s ease-in-out 2s infinite alternate forwards;
                     }


                        @keyframes animation_warning
                        {
                            0% {
                                -webkit-transform: scale(1);
                                transform: scale(1);
                            }
                            14% {
                                -webkit-transform: scale(1.1);
                                transform: scale(1.1);
                            }
                            28% {
                                -webkit-transform: scale(1);
                                transform: scale(1);
                            }
                            42% {
                                -webkit-transform: scale(1.1);
                                transform: scale(1.1);
                            }
                            70% {
                                -webkit-transform: scale(1);
                                transform: scale(1);
                            }
                        }
                         a.min_max {
                             color: white !important;
                             width: 24px;
                             height: 24px;
                             display: inline-block;
                             margin-left: 19px;
                             background: red ;
                             border-radius: 50%;
                             font-size: 16px;
                             padding: 0px 2px 0 0;
                             animation: pulse_min_max 2s infinite;
                         }



                         @keyframes  pulse_min_max {
                             0% {
                                 -moz-box-shadow: 0 0 0 0 rgba(204,169,44, 0.4);
                                 box-shadow:0 0 0 0 rgba(244, 67, 54, 99);
                             }
                             70% {
                                 -moz-box-shadow: 0 0 0 30px rgba(204,169,44, 0);
                                 box-shadow: 0 0 0 10px rgba(204,169,44, 0.2 );
                             }
                             100% {
                                 -moz-box-shadow: 0 0 0 0 rgba(204,169,44, 0);
                                 box-shadow: 0 0 0 0 rgba(204,169,44, 0);
                             }
                         }
                     
                     
                     	  .add_reminder{
                            overflow: hidden;
                            transition: 0.5s;
                            color: #ffb600;
                            background: #fff;
                            /* position: fixed; */
                            margin-left: 20px;
                            padding: 0;
                            font-size: 22px;
                            width: 32px;
                            height: 32px;
                            border-radius: 50%;
                            /* z-index: 10; */
                            -webkit-box-shadow: 0px 0px 10px #696969;
                            -moz-box-shadow:0px 0px 10px #696969;
                            box-shadow: 0px 0px 10px #696969;
                        }
                        .add_reminder .icon_reminder , .add_reminder .icon_reminder:hover{
                            color: #ffb600;
                        }

                        .addWth{
                            width: 304px;
                            height: 40px;
                            border-radius: 0;
                        }
                        @media (max-width: 360px) {
                            .addWth{
                                overflow: auto;
                                font-size: 10px;
                                width: 260px;
                                border-radius:0;
                            }
                        }


                     </style>

                 <?php } ?>
                 <?php } ?>

             <span>  <?php echo Session::get('usernamelogin') ?> </span>    <i class="fa fa-user-circle-o" aria-hidden="true"></i>


         </div>
         <?php } ?>
     </div>



 </nav>
 </div>
<div class="down_fixed"></div>


 <link rel="stylesheet" href="<?php echo $this->static_file_control ?>/css/file-explore.css">
<div class="container-fluid">
 <div class="row flex-xl-nowrap">



     <div class="menuControl"  >


     </div>


<style>

    li.folder-root.open>ul {
        opacity: 1;
        display: block;
        max-height: max-content;
    }
    .loading_menu
    {
        height: 100%;
        width: 100%;
        background-image: url(<?php echo $this->static_file_control  ?>/image/site/sk.gif);
        transform: scaleX(-1);
        background-size:100% ;
    }
    .dataTable
    {
        width: 100% !important;
    }
    .main_menu {
        background: #f8f9fa;
        border-radius: 0;
        border: 1px solid #d4d4d4;
        box-shadow: inset 0 0 7px 0px #1d1c1c63;
    }
    .main_menu:hover {
        box-shadow: inset 0 0 7px 0 #28a745a1;
    }

    .main_menu.main_menu_active {
        box-shadow: inset 0 0 7px 0 #28a745a1;
    }

    .main_menu:focus {
        outline: unset;
        box-shadow: inset 0 0 7px 0 #1d1c1c63;
    }
    .main_menu.main_menu_active {
        box-shadow: inset 0 0 7px 0 #28a745a1;
    }


    .menuControl {
        position: relative;
        padding-left:8px;
        min-height: unset;
        overflow-y: auto;
        width: auto;
    }
    .menuControl.active_menu {
      width: 450px;
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

 .bodyControl {


        overflow-y: auto;
    }


         /* width */
     ::-webkit-scrollbar {
         width: 10px;
         height: 10px;
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
                 if ($('.main_menu').val() === '0' ) {
                     get_main_menu()
                 }
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

         function set_menu() {
             var path = window.location.href;
             path = path.split('?')[0] ;
             var open=$('.file-tree a[href="'+path+'"]').attr('class');
             $('.'+open).addClass('open');
             $('a.'+open).removeClass('open');
             $('.file-tree li a[href="'+path+'"]').addClass('select_this_item');
             $(".file-tree").filetree();
         }
     <?php if ($this->permit('quantity_error', 'savers') ||$this->permit('quantity_error', 'mobile') ||$this->permit('quantity_error', 'accessories') ||$this->permit('quantity_error', 'camera') ||$this->permit('quantity_error', 'computer') ||$this->permit('quantity_error', 'games') ||$this->permit('quantity_error', 'network') ) {?>

         setInterval(function() {
         $.get( "<?php echo url .'/quantity_change_control/get_quantity_error_count' ?>", function(data) {
            console.log(data);
            if(data == 0){
                $('#quantity_warning').css('background-color','green');

            }else{
                $('#quantity_warning').css('background-color','red');

            }

        });
    }, 2000);
    <?php } ?>

     </script>

     <script src="<?php echo $this->static_file_control ?>/js/file-explore.js"></script>
     <div class="col bodyControl" >

