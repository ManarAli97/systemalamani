<!DOCTYPE html>
<meta property="og:type" content="website"/>
<html dir="<?php echo $this->dirSite ?>">
<head>
    <meta charset="UTF-8">
    <!--    <meta name="viewport" content="width=device-width, initial-scale=0, maximum-scale=0" />-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=off" />

    <title><?php echo $this->title;?></title>
    <link rel="icon"   href="<?php echo $this->static_file_site ?>/image/site/logo_notif.png">

    <!--    firebase-->
    <script src="https://www.gstatic.com/firebasejs/7.6.0/firebase.js"></script>

    <!--jquery -->
    <script src="<?php echo $this->static_file_site ?>/js/jquery.min.js"></script>

    <!--bootstrap-->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/bootstrap/css/bootstrap.min.css" >
    <script src="<?php echo $this->static_file_site ?>/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo $this->static_file_site ?>/bootstrap/js/bootstrap.min.js"  ></script>

    <!--css range-->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/range_input2/jquery.range.css">

    <!--custom css -->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/css/default20.css"/>




    <!--custom js-->
    <script src="<?php echo $this->static_file_site ?>/js/custom.js"></script>


    <!--bootstrap-toggle-->
    <link href="<?php echo $this->static_file_site ?>/bootstrap/toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="<?php echo $this->static_file_site ?>/bootstrap/toggle/js/bootstrap-toggle.min.js"></script>

    <!--upload file-->

    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/dist2/font-awesome.min.css"/>


    <!--dataTables-->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/datatable/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/datatable/css/dataTables.bootstrap4.min.css">
    <script type="text/javascript" src="<?php echo $this->static_file_site ?>/datatable/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->static_file_site ?>/datatable/js/dataTables.bootstrap4.min.js"></script>


    <!--editor css -->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/editor/froala/css/froala_style.css"/>


    <!--      pagenation-->
    <script src="<?php echo $this->static_file_control ?>/js/pagenation/twbsPagination.js"></script>
    <script src="<?php echo $this->static_file_control ?>/zoom/jquery.elevatezoom.js"></script>

<!--    swiper-->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/swiper/swiper.min.css">


    <!--slider popup-->

    <?php   if (!isset($_SESSION['username_member_r'])) { ?>
        <style>
            .fb-login-button.loginFacebook.fb_iframe_widget {
                display: block !important;
            }
        </style>
    <?php } ?>

    <style>


        .loadingPage {
            position: fixed;
            z-index: 150000;
            width: 100%;
            height: 100%;
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @-webkit-keyframes rotation {
            from {
                -webkit-transform: rotate(0deg);
            }

            to {
                -webkit-transform: rotate(359deg);
            }
        }

        body {
            overflow: hidden;
        }
        .loadingPage_text
        {

            margin-top: 5px;
            margin-bottom: 10px;
            font-weight: bold;
            text-align: center;
        }
        </style>

    <script>

        var myarr_non = ['NON','non','UNKNOWN','unknown','Unknown','Non','بلا','',' ','  '];

    </script>

</head>
<body class="fr-view" style="overflow-x: hidden;">



<div class="loadingPage">
    <div>
    <div style="text-align: center">   <img class="inside" id="NonerotatingImgLogo" src="<?php  echo  $this->static_file_control ?>/image/site/logo_loading.png" alt="inside"  > </div>
    <div style="text-align: center">   <img class="inside" id="NonerotatingImgLogo" src="<?php  echo  $this->static_file_control ?>/image/site/loading.svg" alt="inside"  > </div>
</div>
</div>



<script>

    $(window).on('load', function(){
       $('.loadingPage').fadeOut();
        $('body').css('overflow','auto');
    });
    setTimeout(function () {
        $('.loadingPage').fadeOut();
        $('body').css('overflow','auto');
    },5000)
</script>


<div class="bar_top" style=" padding: 0 0 2px  0;background: #f8f8f8a3;">


    <div class="container">
        <div class="row justify-content-between  align-items-center">
            <div class="col x_padding1">
                <div class="row align-items-center	">


                    <!--       computer   User-->

                    <div class="col-auto d-lg-block d-none">

                        <div class="col-auto">
                            <div class="row justify-content-end align-items-center" style="height: 50px">

                                <div class="col-auto d-block d-sm-none">
                                    <div class="dropdown">
                                        <button class="user_xorox dropdown-toggle btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-user icon_user"></i>
                                            <?php   if ($newMsg > 0) {  ?>
                                                <i style="color: red;font-size: 8px;"  class="fa fa-circle"></i>
                                            <?php  }  ?>

                                        </button>
                                        <div class="dropdown-menu down_menu mobile_dr" aria-labelledby="dropdownMenuButton">
                                            <?php  if (isset($_SESSION['username_member_r'])) {  ?>
                                                <a class="dropdown-item item_menu" href="<?php echo url ?>/register/edit">   <span> <?php $arr = explode(' ', $_SESSION['name_r']); echo $arr[0];    ?>  </span> <i class="fa fa-pencil" ></i>    </a>
                                                <a class="dropdown-item item_menu" href="<?php echo url ?>/chat"> <span>  مركز الرسائل </span>
                                                    <?php   if ($newMsg > 0) {  ?>
                                                        <i style="color: red;font-size: 8px;"  class="fa fa-circle"></i>
                                                    <?php  }  ?>
                                                </a>
                                                <a class="dropdown-item item_menu" href="<?php echo url ?>/register/details">  عرض الطلب السابق  </a>
                                                <a class="dropdown-item item_menu" href="<?php echo url ?>/comparison">   مقارنة بين الاجهزة  </a>
                                                <a class="dropdown-item item_menu btn"   onclick="logoutFacebook()">تسجيل خروج </a>
                                            <?php  }else{  ?>


                                                <a class="dropdown-item item_menu" data-toggle="modal" style="cursor: pointer" data-target="#login_site">
                                                    <i class="fa fa-sign-in icon_user"  ></i>  <span > تسجيل الدخول</span>
                                                </a>
                                                <a class="dropdown-item item_menu" href="<?php  echo url ?>/register/register_user">  <i class="fa fa-pencil" ></i>    <span>  أنشاء حساب </span>      </a>

                                            <?php  }  ?>


                                        </div>
                                    </div>

                                </div>
                                <div class="col-auto d-none d-sm-block">
                                    <div class="login">

                                        <?php  if (isset($_SESSION['username_member_r'])) {  ?>


                                            <div class="dropdown">
                                                <button  class="user_xorox dropdown-toggle d-none d-sm-block  btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-user icon_user"></i>
                                                    <span>
                                                    <?php $arr = explode(' ', $_SESSION['name_r']); echo $arr[0];    ?>  </span>
                                                    <?php   if ($newMsg > 0) {  ?>
                                                        <i style="color: red;font-size: 8px;"  class="fa fa-circle"></i>
                                                    <?php  }  ?>

                                                </button>

                                                <button  class="user_xorox dropdown-toggle d-block d-sm-none btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-user icon_user"></i>
                                                </button>

                                                <div class="dropdown-menu down_menu mobile_dr" aria-labelledby="dropdownMenuButton">
                                                    <?php  if (isset($_SESSION['username_member_r'])) {  ?>
                                                        <a class="dropdown-item item_menu" href="<?php echo url ?>/register/edit">   <span> <?php $arr = explode(' ', $_SESSION['name_r']); echo $arr[0];    ?>  </span> <i class="fa fa-pencil" ></i>    </a>
                                                        <a class="dropdown-item item_menu" href="<?php echo url ?>/chat"> <span>  مركز الرسائل </span>
                                                            <?php   if ($newMsg > 0) {  ?>
                                                                <i style="color: red;font-size: 8px;"  class="fa fa-circle"></i>
                                                            <?php  }  ?>
                                                        </a>
                                                        <a class="dropdown-item item_menu" href="<?php echo url ?>/register/details">  عرض الطلب السابق  </a>
                                                        <a class="dropdown-item item_menu" href="<?php echo url ?>/comparison">  مقارنة بين الاجهزة   </a>
                                                        <a class="dropdown-item item_menu btn"   onclick="logoutFacebook()">تسجيل خروج </a>
                                                    <?php  }else{  ?>


                                                        <a class="dropdown-item item_menu" data-toggle="modal" style="cursor: pointer" data-target="#login_site">
                                                            <i class="fa fa-sign-in icon_user"  ></i>  <span    > تسجيل الدخول</span>
                                                        </a>
                                                        <a class="dropdown-item item_menu" href="<?php  echo url ?>/register/register_user">  <i class="fa fa-pencil" ></i>    <span>  أنشاء حساب </span>      </a>

                                                    <?php  }  ?>


                                                </div>
                                            </div>


                                        <?php  } else  { ?>
                                            <div class="d-none d-sm-block">
                                                <i class="fa fa-sign-in icon_user"  data-toggle="modal" style="cursor: pointer" data-target="#login_site"></i>  <span class="rxoc"  data-toggle="modal" style="cursor: pointer" data-target="#login_site"  >  تسجيل دخول </span>
                                            </div>



                                        <?php  }  ?>

                                    </div>
                                </div>
                                <?php  if (!isset($_SESSION['username_member_r'])) {  ?>
                                    <div class="col-auto d-none d-sm-block">
                                        <div class="register">
                                            <a  href="<?php  echo url ?>/register/register_user">  <i class="fa fa-pencil" ></i>    <span style="color: black">    أنشاء حساب </span>      </a>
                                        </div>
                                    </div>
                                <?php  }  ?>
                            </div>


                        </div>

                    </div>
                    <!--        end User-->


                    <!--        mobile  User-->
                    <div class="col-auto d-md-block d-lg-none"   >

                        <div class="col-auto">
                            <div class="row justify-content-end align-items-center"  style="height: 50px">

                                <div class="col-auto d-block d-sm-none" style="padding-left: 0">
                                    <div class="dropdown">
                                        <button class="user_xorox dropdown-toggle btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-user icon_user"></i>
                                            <?php  if (isset($_SESSION['username_member_r'])) {  ?>
                                                <span>
                                            <?php $arr = explode(' ', $_SESSION['name_r']); echo $arr[0];    ?>  </span>
                                                <?php   if ($newMsg > 0) {  ?>
                                                    <i style="color: red;font-size: 8px;"  class="fa fa-circle"></i>
                                                <?php  }  ?>
                                            <?php  }  ?>

                                        </button>
                                        <div class="dropdown-menu down_menu mobile_dr" aria-labelledby="dropdownMenuButton">
                                            <?php  if (isset($_SESSION['username_member_r'])) {  ?>
                                                <a class="dropdown-item item_menu" href="<?php echo url ?>/register/edit">   <span> <?php $arr = explode(' ', $_SESSION['name_r']); echo $arr[0];    ?>  </span> <i class="fa fa-pencil" ></i>    </a>
                                                <a class="dropdown-item item_menu" href="<?php echo url ?>/chat"> <span>  مركز الرسائل </span>
                                                    <?php   if ($newMsg > 0) {  ?>
                                                        <i style="color: red;font-size: 8px;"  class="fa fa-circle"></i>
                                                    <?php  }  ?>
                                                </a>
                                                <a class="dropdown-item item_menu" href="<?php echo url ?>/register/details">  عرض الطلب السابق  </a>
                                                <a class="dropdown-item item_menu" href="<?php echo url ?>/comparison">  مقارنة بين الاجهزة   </a>
                                                <a class="dropdown-item item_menu btn"   onclick="logoutFacebook()">تسجيل خروج </a>
                                            <?php  }else{  ?>


                                                <a class="dropdown-item item_menu" data-toggle="modal" style="cursor: pointer" data-target="#login_site">
                                                    <i class="fa fa-sign-in icon_user"  ></i>  <span > تسجيل الدخول</span>
                                                </a>
                                                <a class="dropdown-item item_menu" href="<?php  echo url ?>/register/register_user">  <i class="fa fa-pencil" ></i>    <span>  أنشاء حساب </span>      </a>

                                            <?php  }  ?>


                                        </div>
                                    </div>

                                </div>
                                <div class="col-auto d-none d-sm-block">
                                    <div class="login">

                                        <?php  if (isset($_SESSION['username_member_r'])) {  ?>


                                            <div class="dropdown">
                                                <button  class="user_xorox dropdown-toggle d-none d-sm-block  btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-user icon_user"></i>
                                                    <span>
                                                       <?php $arr = explode(' ', $_SESSION['name_r']); echo $arr[0];    ?>  </span>
                                                    <?php   if ($newMsg > 0) {  ?>
                                                        <i style="color: red;font-size: 8px;"  class="fa fa-circle"></i>
                                                    <?php  }  ?>

                                                </button>

                                                <button  class="user_xorox dropdown-toggle d-block d-sm-none btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-user icon_user"></i>
                                                </button>

                                                <div class="dropdown-menu down_menu mobile_dr" aria-labelledby="dropdownMenuButton">
                                                    <?php  if (isset($_SESSION['username_member_r'])) {  ?>
                                                        <a class="dropdown-item item_menu" href="<?php echo url ?>/register/edit">   <span> <?php $arr = explode(' ', $_SESSION['name_r']); echo $arr[0];    ?>  </span> <i class="fa fa-pencil" ></i>    </a>
                                                        <a class="dropdown-item item_menu" href="<?php echo url ?>/chat"> <span>  مركز الرسائل </span>
                                                            <?php   if ($newMsg > 0) {  ?>
                                                                <i style="color: red;font-size: 8px;"  class="fa fa-circle"></i>
                                                            <?php  }  ?>
                                                        </a>
                                                        <a class="dropdown-item item_menu" href="<?php echo url ?>/register/details">  عرض الطلب السابق  </a>
                                                        <a class="dropdown-item item_menu" href="<?php echo url ?>/comparison">   مقارنة بين الاجهزة  </a>
                                                        <a class="dropdown-item item_menu btn"   onclick="logoutFacebook()">تسجيل خروج </a>
                                                    <?php  }else{  ?>


                                                        <a class="dropdown-item item_menu" data-toggle="modal" style="cursor: pointer" data-target="#login_site">
                                                            <i class="fa fa-sign-in icon_user"  ></i>  <span    > تسجيل الدخول</span>
                                                        </a>
                                                        <a class="dropdown-item item_menu" href="<?php  echo url ?>/register/register_user">  <i class="fa fa-pencil" ></i>    <span>  أنشاء حساب </span>      </a>

                                                    <?php  }  ?>


                                                </div>
                                            </div>


                                        <?php  } else  { ?>
                                            <div class="d-none d-sm-block">
                                                <i class="fa fa-sign-in icon_user"  data-toggle="modal" style="cursor: pointer" data-target="#login_site"></i>  <span class="rxoc"  data-toggle="modal" style="cursor: pointer" data-target="#login_site"  >   </span>
                                            </div>

                                        <?php  }  ?>

                                    </div>
                                </div>
                                <?php  if (!isset($_SESSION['username_member_r'])) {  ?>
                                    <div class="col-auto d-none d-sm-block">
                                        <div class="register">
                                            <a  href="<?php  echo url ?>/register/register_user">  <i class="fa fa-pencil" ></i>    <span>    </span>      </a>
                                        </div>
                                    </div>
                                <?php  }  ?>
                            </div>
                        </div>
                    </div>
                    <!--        end User-->


                    <!--    CART     -->
                    <div class="col-auto   d-md-block d-lg-none" style="padding: 0">

                        <div class="dropdown">
                            <button   class="btn cart_shop_active dropdown-toggle" type="button" id="dropdownMenuButton_car" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="count_item count_item_cartShow"><?php  echo $count ?></span>  <i class="fa fa-shopping-cart"></i>
                            </button>

                            <div class="dropdown-menu content_car keep_it_open" aria-labelledby="dropdownMenuButton_car">

                                <div class="item_cat">

                                    <?php $price1=0;$price2=0; foreach ($car as $shop) { ?>
                                        <div class="row item_row delete_item_row_<?php  echo $shop['id'] ?>" id="item_row_<?php  echo $shop['id'] ?>">

                                            <div class="col-auto" style="padding-right: 0;padding-left: 0;">
                                                <button onclick="delete_item_row(<?php  echo $shop['id_item'] ?>,<?php  echo $shop['id'] ?>)" class="btn delete_item_row" type="button"> <i class="fa fa-times"></i> </button>
                                            </div>

                                            <div class="col-auto" style="padding-right: 0;padding-left: 0;">
                                                <img class="image_item"   src="<?php  echo $shop['img'] ?>">
                                            </div>
                                            <div class="col">
                                                <div class="size_item">
                                                    <span> <?php  echo $shop['title'] ?>  </span> &nbsp;    <input class="number_item_buy number_item_buy_<?php  echo $shop['id'] ?>" id="count_buy_<?php  echo $shop['id'] ?>" type="text"  value="<?php  echo $shop['number'] ?>" readonly>
                                                </div>

                                                <div class="price_row" id="price_sum_car_<?php  echo $shop['id'] ?>">
                                                    <?php  echo $shop['price']   ?>     <?php  if(!empty($shop['size'])) echo "(".$shop['size'].")"; else  $shop['size'] ?>
                                                </div>
												<?php  if ($shop['q_0']) {  ?>
                                                    <div class="q_0">
                                                        نفذت الكمية
                                                    </div>
												<?php } ?>
                                            </div>

                                        </div>

                                        <?php

                                        $price=explode('-',$shop['price']);
                                        if (count($price) == 2)
                                        {

                                            $f1=(int)trim(str_replace(',','',$price[0] ));
                                            $f2=(int)trim(str_replace(',','',$price[1] ));
                                            $price1=$price1+ ($f1 * $shop['number'] );
                                            $price2=$price2+($f2 * $shop['number'] );
                                        }else
                                        {
                                            $f1=(int)trim(str_replace(',','',$price[0] ));
                                            $price1=$price1+ ($f1 * $shop['number'] );
                                            $price2=$price2+ ($f1 * $shop['number'] );
                                        }


                                        ?>




                                    <?php  }  ?>
                                    <?php  if (!empty($car)) {  ?>
                                    <div class="sum_all_price_cart">
                                        <span>        مجموع الفاتورة بين :</span> <span> <?php  echo number_format($price1)?>  </span> - <span> <?php  echo number_format($price2)  ?> </span>
                                    </div>
                                    <?php } ?>

                                </div>

                                <div class="progress_cart">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: 25%"></div>
                                    </div>
                                </div>
                                <div class="button_buy">
                                    <div class="row">

                                        <div class="col-6">
                                            <?php if ($stmt_fb=='true') { ?>

                                                <button  onclick="bay_now()"  class="send_order_btn btn btn-primary buy  open_to_buy"> <span>طلب</span> <i    class="fa fa-spinner loading_icon"></i> </button>
                                            <?php  } else { ?>

                                                <button   class="btn btn-primary buy  open_to_buy"  data-toggle="modal" data-target="#exampleModalFullData"   > <span>طلب</span> <i   class="fa fa-spinner loading_icon"></i> </button>

                                            <?php  }  ?>



                                        </div>
                                        <div class="col-6">
                                            <button data-toggle="modal" data-target="#exampleModal_empty_car" class="btn btn-danger delete"> حذف </button>
                                        </div>
                                    </div>


                                </div>

                                <div class="empty_car">
                                    لا يوجد عناصر
                                </div>


                            </div>
                        </div>







                        <div class="modal fade" id="exampleModal_delete_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"> حذف  </h5>

                                    </div>
                                    <div class="modal-body">
                                        هل انت متأكد ؟
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">الغاء</button>
                                        <button type="button"  value="" id='delete_item' class="btn btn-warning">حذف </button>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <script>
                            $(document).on('click.bs.dropdown.data-api', '.keep_it_open', function (e) {
                                e.stopPropagation();
                            });

                        </script>


                    </div>

                </div>

            </div>

            <?php  if ($quest) {  ?>
                <div class="col-auto x_padding2">
                    <a class="msapka" href="<?php  echo url ?>/questions/view">

                        <img src="<?php echo $this->static_file_site ?>/image/site/msq.png"/>

                    </a>


                    <style>

                        .msapka
                        {
                            text-decoration: none;
                            color: #000000;
                        }

                        .msapka:hover
                        {
                            text-decoration: none;
                            color: #000000;
                        }

                        .msapka img
                        {
                            height: auto;
                            padding-top: 4px;
                        }

                        @media  (max-width: 460px){
                            .msapka {
                                font-size: 14px;
                                margin-left: 5px;
                            }

                            .msapka img
                            {
                                height: 27px;
                            }
                            .x_padding2
                            {
                                padding: 0 0 0 5px;
                            }

                            .x_padding1
                            {
                                padding: 5px 0 0 0 ;
                            }

                        }
                    </style>




                </div>

            <?php  }   ?>

                <div class="col-auto x_padding2">
                    <button type="button" class="btn  bast_it_btn_modal" data-toggle="modal" data-target="#exampleModal_bast_it">
                      ننصح به
                    </button>

                </div>




    <style>
        .bast_it_btn_modal {
            background: #ffffff;
            color: #000;
            padding: 0 4px;
            margin: 0;
            -webkit-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.1);
            -moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.1);
            box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.1);
        }

        .btn_close_bast
        {
            background: #dedede;
            color: #000;
            padding: 0 4px;
            margin: 0;
            -webkit-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.1);
            -moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.1);
            box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.1);
        }

        .bast_it_text
        {
            text-align: center;
            margin-bottom: 30px
        }

        .btn_active_mode_bast
        {
            text-align: center;
        }

        .btn_active_mode_bast .toggle.ios
        {
            width: 110px !important;
        }

    </style>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal_bast_it" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"> تنبية  </h5>

                            </div>
                            <div class="modal-body">

                                <div class="bast_it_text">

                                    اضغط على "تفعيل" لاظهار المنتجات التي تنصح بها الشركة فقط و التي تخص الاجهزة الالكترونية و ملحقاتها الالكترونية فقط

                                </div>

                                <div class="btn_active_mode_bast">
                                    <input type="checkbox"  <?php  if (Session::get('bast_it') == 1) echo 'checked' ?>   onchange="active_mode_bast_it(this)"  data-toggle="toggle"  data-on="الغاء التفعيل" data-off="تفعيل" data-onstyle="warning" data-offstyle="success"   data-size="small" datax-stylex="iosx"  >

                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button"  class="btn  btn_close_bast" data-dismiss="modal"> اغلاق</button>
                            </div>
                        </div>
                    </div>
                </div>





        </div>
    </div>
</div>


<script>

    function active_mode_bast_it(e) {

        var vis=$(e).is( ':checked' )? 1:0;

         $.get("<?php echo url .'/'.$this->folder ?>/active_mode_bast_it/"+vis, function(date){
             window.location='';
         })

    }


</script>


<div id="header_fixed" class="header_fixed">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">


                <nav class="navbar navbar-expand-lg navbar-light for_fixed_nav ">
                    <a class="navbar-brand" href="<?php echo url ?>"><img class="logo_site" style="max-width: 350px" src="<?php echo $Img ?>"></a>

                    <button class="navbar-toggler sm_btn_menu" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

                        <div class="navTrigger">
                            <i></i><i></i><i></i>
                        </div>

                    </button>

                    <div class="dropdown cartDrop_small_fixed">
                        <button   class="btn cart_shop_active dropdown-toggle" type="button" id="dropdownMenuButton_carFor_fixed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="count_item count_item_small_fixed count_item_cartShow"><?php  echo $count ?></span>  <i class="fa fa-shopping-cart"></i>
                        </button>

                        <div class="dropdown-menu content_car_ForFiexd keep_it_open" aria-labelledby="dropdownMenuButton_carFor_fixed">

                            <div class="item_cat">

                                <?php $price1=0;$price2=0; foreach ($car as $shop) { ?>
                                    <div class="row item_row delete_item_row_<?php  echo $shop['id'] ?>" id="item_row_<?php  echo $shop['id'] ?>">

                                        <div class="col-auto" style="padding-right: 0;padding-left: 0;">
                                            <button onclick="delete_item_row(<?php  echo $shop['id_item'] ?>,<?php  echo $shop['id'] ?>)" class="btn delete_item_row" type="button"> <i class="fa fa-times"></i> </button>
                                        </div>

                                        <div class="col-auto" style="padding-right: 0;padding-left: 0;">
                                            <img class="image_item"   src="<?php  echo $shop['img'] ?>">
                                        </div>
                                        <div class="col">
                                            <div class="size_item">
                                                <span> <?php  echo $shop['title'] ?>  </span> &nbsp;    <input class="number_item_buy number_item_buy_<?php  echo $shop['id'] ?>" id="count_buy_<?php  echo $shop['id'] ?>" type="text"  value="<?php  echo $shop['number'] ?>" readonly>
                                            </div>

                                            <div class="price_row" id="price_sum_car_<?php  echo $shop['id'] ?>">
                                                <?php  echo $shop['price']   ?>     <?php  if(!empty($shop['size'])) echo "(".$shop['size'].")"; else  $shop['size'] ?>
                                            </div>
											<?php  if ($shop['q_0']) {  ?>
                                                <div class="q_0">
                                                    نفذت الكمية
                                                </div>
											<?php } ?>
                                        </div>

                                    </div>


                                    <?php

                                    $price=explode('-',$shop['price']);

                                    if (count($price) == 2)
                                    {

                                        $f1=(int)trim(str_replace(',','',$price[0] ));
                                        $f2=(int)trim(str_replace(',','',$price[1] ));
                                        $price1=$price1+ ($f1 * $shop['number'] );
                                        $price2=$price2+($f2 * $shop['number'] );
                                    }else
                                    {
                                        $f1=(int)trim(str_replace(',','',$price[0] ));
                                        $price1=$price1+ ($f1 * $shop['number'] );
                                        $price2=$price2+ ($f1 * $shop['number'] );
                                    }


                                    ?>




                                <?php  }  ?>
                                <?php  if (!empty($car)) {  ?>
                                    <div class="sum_all_price_cart">
                                        <span>        مجموع الفاتورة بين :</span> <span> <?php  echo number_format($price1)?>  </span> - <span> <?php  echo number_format($price2)  ?> </span>
                                    </div>
                                <?php } ?>


                            </div>
                            <div class="progress_cart">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: 25%"></div>
                                </div>
                            </div>
                            <div class="button_buy">
                                <div class="row">

                                    <div class="col-6">
                                        <?php if ($stmt_fb=='true') { ?>

                                            <button  onclick="bay_now()" class="send_order_btn btn btn-primary buy  open_to_buy"> <span>طلب</span> <i  class="fa fa-spinner loading_icon"></i> </button>
                                        <?php  } else { ?>

                                            <button   class="btn btn-primary buy  open_to_buy"  data-toggle="modal" data-target="#exampleModalFullData"   > <span>طلب</span> <i    class="fa fa-spinner loading_icon"></i> </button>

                                        <?php  }  ?>



                                    </div>
                                    <div class="col-6">
                                        <button data-toggle="modal" data-target="#exampleModal_empty_car" class="btn btn-danger delete"> حذف </button>
                                    </div>
                                </div>


                            </div>

                            <div class="empty_car">
                                لا يوجد عناصر
                            </div>


                        </div>
                    </div>




                    <script>
                        $('.navTrigger').click(function(){
                            $(this).toggleClass('active');
                        });
                    </script>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="d-lg-block d-none">
                            <ul class="navbar-nav mr-auto ">
                                <li class="nav-item active">
                                    <a class="nav-link item_menu" href="<?php echo url ?>">  <i class="fa fa-home" ></i> <span>الرئيسية</span>  </a>
                                </li>

                                <li class="nav-item dropdown li_dropdown_menu   ">

                                    <a class="nav-link Dropdown_main_menu dropdown-toggle" href="#">      <?php  echo $this->langSite('mobile')?>  </a>
                                    <ul class="dropdown-menu dropdown-menu-right first_sub_menu item_menu " aria-labelledby="navbarDropdownMenuLink1">
                                        <?php  foreach ($category_mobile as $key => $cat_s_t) { ?>
                                            <li class="dropdown-submenu rotate_this_active ">
                                                <a class="nav-link Dropdown_main_menu   <?php  echo $cat_s_t['sub'] ?>  " href="<?php  echo url ?>/mobile/list_view/<?php echo $cat_s_t['id'] ?>" id="navbarDropdownMenuLink1" data-toggle="" aria-haspopup="true" aria-expanded="false">

                                                    <i class="fa fa-mobile" ></i>
                                                    <?php echo  $cat_s_t['title'] ?>

                                                </a>
                                                <?php  if ($mobile->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                    <ul class="dropdown-menu dropdown-menu-right first_sub_menu" aria-labelledby="navbarDropdownMenuLink1">
                                                        <?php   $mobile->listSubCategoryMenu($cat_s_t['id']) ?>
                                                    </ul>
                                                <?php } ?>
                                            </li>

                                        <?php }  ?>
                                    </ul>

                                </li>

                                <li class="nav-item dropdown li_dropdown_menu   ">

                                    <a class="nav-link Dropdown_main_menu dropdown-toggle" href="#">  <?php  echo $this->langSite('accessories')?> </a>
                                    <ul class="dropdown-menu dropdown-menu-right first_sub_menu item_menu " aria-labelledby="navbarDropdownMenuLink1">
                                        <?php  foreach ($category_accessories as $key => $cat_s_t) { ?>
                                            <li class="dropdown-submenu rotate_this_active ">
                                                <a class="nav-link Dropdown_main_menu   <?php  echo $cat_s_t['sub'] ?>  " href="<?php  echo url ?>/accessories/list_view/<?php echo $cat_s_t['id'] ?>" id="navbarDropdownMenuLink1" data-toggle="" aria-haspopup="true" aria-expanded="false">


                                                    <?php echo  $cat_s_t['title'] ?>

                                                </a>
                                                <?php  if ($accessories->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                    <ul class="dropdown-menu dropdown-menu-right first_sub_menu" aria-labelledby="navbarDropdownMenuLink1">
                                                        <?php   $accessories->listSubCategoryMenu($cat_s_t['id']) ?>
                                                    </ul>
                                                <?php } ?>
                                            </li>

                                        <?php }  ?>
                                        <li class="dropdown-submenu rotate_this_active ">
                                            <a class="nav-link Dropdown_main_menu  " href="<?php echo url ?>/savers/list_view">    <?php  echo $this->langSite('savers')?>  </a>
                                        </li>

                                    </ul>

                                </li>



                                <li class="nav-item dropdown li_dropdown_menu   ">

                                    <a class="nav-link Dropdown_main_menu dropdown-toggle" href="#">      <?php  echo $this->langSite('games')?>  </a>
                                    <ul class="dropdown-menu dropdown-menu-right first_sub_menu item_menu " aria-labelledby="navbarDropdownMenuLink1">
                                        <?php  foreach ($category_games as $key => $cat_s_t) { ?>
                                            <li class="dropdown-submenu rotate_this_active ">
                                                <a class="nav-link Dropdown_main_menu   <?php  echo $cat_s_t['sub'] ?>  " href="<?php  echo url ?>/games/list_view/<?php echo $cat_s_t['id'] ?>" id="navbarDropdownMenuLink1" data-toggle="" aria-haspopup="true" aria-expanded="false">

                                                    <i class="fa fa-games" ></i>
                                                    <?php echo  $cat_s_t['title'] ?>

                                                </a>
                                                <?php  if ($games->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                    <ul class="dropdown-menu dropdown-menu-right first_sub_menu" aria-labelledby="navbarDropdownMenuLink1">
                                                        <?php   $games->listSubCategoryMenu($cat_s_t['id']) ?>
                                                    </ul>
                                                <?php } ?>
                                            </li>

                                        <?php }  ?>
                                    </ul>

                                </li>
                                <?php if (!empty($categorypages)) {   ?>
                                    <li class="nav-item dropdown li_dropdown_menu   ">

                                        <a class="nav-link Dropdown_main_menu dropdown-toggle" href="#">      <?php  echo $this->langSite('pages')?>  </a>
                                        <ul class="dropdown-menu dropdown-menu-right first_sub_menu item_menu " aria-labelledby="navbarDropdownMenuLink1">

                                            <?php foreach ($categorypages as $page_x) {   ?>
                                                <li class="dropdown-submenu rotate_this_active ">
                                                    <a class="nav-link Dropdown_main_menu  " href="<?php echo url ?>/pages/details/<?php echo $page_x['id'] ?>"><?php echo $page_x['title'] ?> </a>
                                                </li>
                                            <?php  }  ?>


                                        </ul>

                                    </li>
                                <?php  } ?>


                                <!--                         <li class="nav-item active">-->
                                <!--                             <a class="nav-link item_menu" href="--><?php //echo url ?><!--/savers/list_view">    <span>   --><?php // echo $this->langSite('savers')?><!--  </span>  </a>-->
                                <!--                         </li>-->






                            </ul>


                        </div>

                        <div id="accordion" class="d-lg-none d-block accordion_all_menu">


                            <div class="card">
                                <div class="card-header  accordion_row" id="headingOne_main_home">

                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <a class="link_acc" href="<?php  echo url ?>"> <?php echo $this->langSite('home')?>   </a>
                                        </div>

                                    </div>
                                </div>

                            </div>


                            <div class="card">
                                <div class="card-header  accordion_row" id="headingOne_main_mobile_acc">

                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <a class="link_acc" href="#" data-toggle="collapse" data-target="#collapseOne_main_mobile_acc" aria-expanded="true" aria-controls="collapseOne_main_mobile_acc">    <?php echo $this->langSite('mobile')?> </a>
                                        </div>

                                        <div class="col-auto">
                                            <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_mobile_acc" aria-expanded="true" aria-controls="collapseOne_main_mobile_acc">
                                                <i class="fa fa-sort"> </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div id="collapseOne_main_mobile_acc" class="collapse " aria-labelledby="headingOne_main_mobile_acc" data-parent="#accordion">
                                    <div class="card-body nested_accordion">

                                        <div id="accordion_mobile">



                                            <?php  foreach ($category_site_acc_mobile as $key => $cat_s_t) { ?>
                                                <div class="card">
                                                    <div class="card-header  accordion_row" id="headingOne_main_<?php  echo  $cat_s_t['id'] ?>">

                                                        <div class="row justify-content-between align-items-center">
                                                            <div class="col-auto">
                                                                <a class="link_acc" href="<?php  echo url ?>/mobile/list_view/<?php echo $cat_s_t['id']?>">  <?php  echo  $cat_s_t['title'] ?>   </a>
                                                            </div>
                                                            <?php  if ($mobile->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                                <div class="col-auto">
                                                                    <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="true" aria-controls="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>">
                                                                        <i class="fa fa-sort"> </i>
                                                                    </button>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div id="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" class="collapse " aria-labelledby="headingOne_main_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordion_mobile">
                                                        <div class="card-body nested_accordion">
                                                            <?php  if ($mobile->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                                <?php   $mobile->listSubCategoryMenu_acc($cat_s_t['id']) ?>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            <?php  }  ?>
                                        </div>


                                    </div>
                                </div>
                            </div>








                            <div class="card">
                                <div class="card-header  accordion_row" id="headingOne_main_accessories_acc">

                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <a class="link_acc" href="#" data-toggle="collapse" data-target="#collapseOne_main_accessories_acc" aria-expanded="true" aria-controls="collapseOne_main_accessories_acc">    <?php echo $this->langSite('accessories')?> </a>
                                        </div>

                                        <div class="col-auto">
                                            <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_accessories_acc" aria-expanded="true" aria-controls="collapseOne_main_accessories_acc">
                                                <i class="fa fa-sort"> </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div id="collapseOne_main_accessories_acc" class="collapse " aria-labelledby="headingOne_main_accessories_acc" data-parent="#accordion">
                                    <div class="card-body nested_accordion">

                                        <div id="accordion_accessories">



                                            <?php  foreach ($category_site_acc_accessories as $key => $cat_s_t) { ?>
                                                <div class="card">
                                                    <div class="card-header  accordion_row" id="headingOne_main_<?php  echo  $cat_s_t['id'] ?>">

                                                        <div class="row justify-content-between align-items-center">
                                                            <div class="col-auto">
                                                                <a class="link_acc" href="<?php  echo url ?>/accessories/list_view/<?php echo $cat_s_t['id']?>">  <?php  echo  $cat_s_t['title'] ?>   </a>
                                                            </div>
                                                            <?php  if ($accessories->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                                <div class="col-auto">
                                                                    <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="true" aria-controls="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>">
                                                                        <i class="fa fa-sort"> </i>
                                                                    </button>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div id="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" class="collapse " aria-labelledby="headingOne_main_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordion_accessories">
                                                        <div class="card-body nested_accordion">
                                                            <?php  if ($accessories->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                                <?php   $accessories->listSubCategoryMenu_acc($cat_s_t['id']) ?>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            <?php  }  ?>

                                            <div class="card">
                                                <div class="card-header  accordion_row" id="headingOne_main_home">

                                                    <div class="row justify-content-between align-items-center">
                                                        <div class="col-auto">
                                                            <a class="link_acc" href="<?php  echo url ?>/savers/list_view"> <?php echo $this->langSite('savers')?>   </a>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>


                                        </div>


                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header  accordion_row" id="headingOne_main_camera_acc">

                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <a class="link_acc" href="#" data-toggle="collapse" data-target="#collapseOne_main_camera_acc" aria-expanded="true" aria-controls="collapseOne_main_camera_acc">    <?php echo $this->langSite('camera')?> </a>
                                        </div>

                                        <div class="col-auto">
                                            <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_camera_acc" aria-expanded="true" aria-controls="collapseOne_main_camera_acc">
                                                <i class="fa fa-sort"> </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div id="collapseOne_main_camera_acc" class="collapse " aria-labelledby="headingOne_main_camera_acc" data-parent="#accordion">
                                    <div class="card-body nested_accordion">

                                        <div id="accordion_camera">



                                            <?php  foreach ($category_site_acc_camera as $key => $cat_s_t) { ?>
                                                <div class="card">
                                                    <div class="card-header  accordion_row" id="headingOne_main_<?php  echo  $cat_s_t['id'] ?>">

                                                        <div class="row justify-content-between align-items-center">
                                                            <div class="col-auto">
                                                                <a class="link_acc" href="<?php  echo url ?>/camera/list_view/<?php echo $cat_s_t['id']?>">  <?php  echo  $cat_s_t['title'] ?>   </a>
                                                            </div>
                                                            <?php  if ($camera->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                                <div class="col-auto">
                                                                    <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="true" aria-controls="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>">
                                                                        <i class="fa fa-sort"> </i>
                                                                    </button>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div id="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" class="collapse " aria-labelledby="headingOne_main_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordion_camera">
                                                        <div class="card-body nested_accordion">
                                                            <?php  if ($camera->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                                <?php   $camera->listSubCategoryMenu_acc($cat_s_t['id']) ?>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            <?php  }  ?>
                                        </div>


                                    </div>
                                </div>
                            </div>



                            <div class="card">
                                <div class="card-header  accordion_row" id="headingOne_main_games_acc">

                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <a class="link_acc" href="#" data-toggle="collapse" data-target="#collapseOne_main_games_acc" aria-expanded="true" aria-controls="collapseOne_main_games_acc">    <?php echo $this->langSite('games')?> </a>
                                        </div>

                                        <div class="col-auto">
                                            <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_games_acc" aria-expanded="true" aria-controls="collapseOne_main_games_acc">
                                                <i class="fa fa-sort"> </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div id="collapseOne_main_games_acc" class="collapse " aria-labelledby="headingOne_main_games_acc" data-parent="#accordion">
                                    <div class="card-body nested_accordion">

                                        <div id="accordion_games">



                                            <?php  foreach ($category_site_acc_games as $key => $cat_s_t) { ?>
                                                <div class="card">
                                                    <div class="card-header  accordion_row" id="headingOne_main_<?php  echo  $cat_s_t['id'] ?>">

                                                        <div class="row justify-content-between align-items-center">
                                                            <div class="col-auto">
                                                                <a class="link_acc" href="<?php  echo url ?>/games/list_view/<?php echo $cat_s_t['id']?>">  <?php  echo  $cat_s_t['title'] ?>   </a>
                                                            </div>
                                                            <?php  if ($games->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                                <div class="col-auto">
                                                                    <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="true" aria-controls="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>">
                                                                        <i class="fa fa-sort"> </i>
                                                                    </button>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div id="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" class="collapse " aria-labelledby="headingOne_main_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordion_games">
                                                        <div class="card-body nested_accordion">
                                                            <?php  if ($games->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                                <?php   $games->listSubCategoryMenu_acc($cat_s_t['id']) ?>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            <?php  }  ?>
                                        </div>


                                    </div>
                                </div>
                            </div>



                            <div class="card">
                                <div class="card-header  accordion_row" id="headingOne_main_network_acc">

                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <a class="link_acc" href="#" data-toggle="collapse" data-target="#collapseOne_main_network_acc" aria-expanded="true" aria-controls="collapseOne_main_network_acc">    <?php echo $this->langSite('network')?> </a>
                                        </div>

                                        <div class="col-auto">
                                            <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_network_acc" aria-expanded="true" aria-controls="collapseOne_main_network_acc">
                                                <i class="fa fa-sort"> </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div id="collapseOne_main_network_acc" class="collapse " aria-labelledby="headingOne_main_network_acc" data-parent="#accordion">
                                    <div class="card-body nested_accordion">

                                        <div id="accordion_network">



                                            <?php  foreach ($category_site_acc_network as $key => $cat_s_t) { ?>
                                                <div class="card">
                                                    <div class="card-header  accordion_row" id="headingOne_main_<?php  echo  $cat_s_t['id'] ?>">

                                                        <div class="row justify-content-between align-items-center">
                                                            <div class="col-auto">
                                                                <a class="link_acc" href="<?php  echo url ?>/network/list_view/<?php echo $cat_s_t['id']?>">  <?php  echo  $cat_s_t['title'] ?>   </a>
                                                            </div>
                                                            <?php  if ($network->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                                <div class="col-auto">
                                                                    <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="true" aria-controls="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>">
                                                                        <i class="fa fa-sort"> </i>
                                                                    </button>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div id="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" class="collapse " aria-labelledby="headingOne_main_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordion_network">
                                                        <div class="card-body nested_accordion">
                                                            <?php  if ($network->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                                <?php   $network->listSubCategoryMenu_acc($cat_s_t['id']) ?>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            <?php  }  ?>


                                        </div>


                                    </div>
                                </div>
                            </div>




                            <?php if (!empty($categorypages)) {   ?>
                                <div class="card">
                                    <div class="card-header  accordion_row" id="headingOne_main_pages_acc">

                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-auto">
                                                <a class="link_acc" href="#" data-toggle="collapse" data-target="#collapseOne_main_pages_acc" aria-expanded="true" aria-controls="collapseOne_main_pages_acc">    <?php echo $this->langSite('pages')?> </a>
                                            </div>

                                            <div class="col-auto">
                                                <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_pages_acc" aria-expanded="true" aria-controls="collapseOne_main_pages_acc">
                                                    <i class="fa fa-sort"> </i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="collapseOne_main_pages_acc" class="collapse " aria-labelledby="headingOne_main_pages_acc" data-parent="#accordion">
                                        <div class="card-body nested_accordion">

                                            <div id="accordion_pages">


                                                <?php foreach ($categorypages as $page_x) {   ?>
                                                    <div class="card">
                                                        <div class="card-header  accordion_row" id="headingOne_main_<?php  echo  $page_x['id'] ?>">

                                                            <div class="row justify-content-between align-items-center">
                                                                <div class="col-auto">
                                                                    <a class="link_acc" href="<?php  echo url ?>/pages/details/<?php echo $page_x['id']?>">  <?php  echo  $page_x['title'] ?>   </a>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php  }  ?>



                                            </div>


                                        </div>
                                    </div>
                                </div>

                            <?php  } ?>

                        </div>




                    </div>
                </nav>


            </div>



            <!--    CART     -->
            <div class="col-auto d-lg-block d-none">

                <div class="dropdown">
                    <button class="btn cart_shop_active dropdown-toggle" type="button" id="dropdownMenuButton_car" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="count_item count_item_cartShow"><?php  echo $count ?></span>  <i class="fa fa-shopping-cart"></i>
                    </button>

                    <div class="dropdown-menu content_car keep_it_open" aria-labelledby="dropdownMenuButton_car">

                        <div class="item_cat">

                            <?php $price1=0;$price2=0; foreach ($car as $shop) { ?>
                                <div class="row item_row delete_item_row_<?php  echo $shop['id'] ?>" id="item_row_<?php  echo $shop['id'] ?>">

                                    <div class="col-auto" style="padding-right: 0;padding-left: 0;">
                                        <button onclick="delete_item_row(<?php  echo $shop['id_item'] ?>,<?php  echo $shop['id'] ?>)" class="btn delete_item_row" type="button"> <i class="fa fa-times"></i> </button>
                                    </div>

                                    <div class="col-auto" style="padding-right: 0;padding-left: 0;">
                                        <img class="image_item"   src="<?php  echo $shop['img'] ?>">
                                    </div>
                                    <div class="col">
                                        <div class="size_item">
                                            <span> <?php  echo $shop['title'] ?>  </span> &nbsp;    <input class="number_item_buy number_item_buy_<?php  echo $shop['id'] ?>" id="count_buy_<?php  echo $shop['id'] ?>" type="text"  value="<?php  echo $shop['number'] ?>" readonly>
                                        </div>

                                        <div class="price_row" id="price_sum_car_<?php  echo $shop['id'] ?>">
                                            <?php  echo $shop['price'] ?>    <?php  if(!empty($shop['size'])) echo "(".$shop['size'].")"; else  $shop['size'] ?>
                                        </div>
										<?php  if ($shop['q_0']) {  ?>
                                            <div class="q_0">
                                                نفذت الكمية
                                            </div>
										<?php } ?>
                                    </div>

                                </div>

                                <?php

                                $price=explode('-',$shop['price']);

                                if (count($price) == 2)
                                {

                                    $f1=(int)trim(str_replace(',','',$price[0] ));
                                    $f2=(int)trim(str_replace(',','',$price[1] ));
                                    $price1=$price1+ ($f1 * $shop['number'] );
                                    $price2=$price2+($f2 * $shop['number'] );
                                }else
                                {
                                    $f1=(int)trim(str_replace(',','',$price[0] ));
                                    $price1=$price1+ ($f1 * $shop['number'] );
                                    $price2=$price2+ ($f1 * $shop['number'] );
                                }

                                ?>


                            <?php  }  ?>
                            <?php  if (!empty($car)) {  ?>
                                <div class="sum_all_price_cart">
                                    <span>        مجموع الفاتورة بين :</span> <span> <?php  echo number_format($price1)?>  </span> - <span> <?php  echo number_format($price2)  ?> </span>
                                </div>
                            <?php } ?>

                        </div>

                        <div class="progress_cart">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: 25%"></div>
                            </div>
                        </div>



                        <div class="button_buy">
                            <div class="row">

                                <div class="col-6">
                                    <?php if ($stmt_fb=='true') { ?>

                                        <button  onclick="bay_now()" class="send_order_btn btn btn-primary buy  open_to_buy"> <span>طلب</span> <i    class="fa fa-spinner loading_icon"></i> </button>
                                    <?php  } else { ?>

                                        <button   class="btn btn-primary buy  open_to_buy"  data-toggle="modal" data-target="#exampleModalFullData"   > <span>طلب</span> <i   class="fa fa-spinner loading_icon"></i> </button>

                                    <?php  }  ?>


                                </div>
                                <div class="col-6">
                                    <button data-toggle="modal" data-target="#exampleModal_empty_car" class="btn btn-danger delete"> حذف </button>
                                </div>
                            </div>


                        </div>

                        <div class="empty_car">
                            لا يوجد عناصر
                        </div>


                    </div>
                </div>

                <style>


                    <?php if (!empty($car)) {  ?>

                    .button_buy
                    {
                        display: block;
                    }
                    .empty_car
                    {
                        display: none;
                    }

                    <?php  }else{    ?>
                    .button_buy
                    {
                        display: none;
                    }
                    .empty_car
                    {
                        display: block;
                    }


                    <?php   }  ?>

                    .user_xorox
                    {
                        background: transparent;
                    }
                </style>



                <div class="modal fade" id="exampleModal_delete_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"> حذف  </h5>

                            </div>
                            <div class="modal-body">
                                هل انت متأكد ؟
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">الغاء</button>
                                <button type="button"  value="" id='delete_item' class="btn btn-warning">حذف </button>
                            </div>
                        </div>
                    </div>
                </div>



                <script>
                    $(document).on('click.bs.dropdown.data-api', '.keep_it_open', function (e) {
                        e.stopPropagation();
                    });

                </script>


            </div>






        </div>
    </div>
</div>

<div class="under_fixed_header"></div>

<style>
    div#header_fixed
    {
        position: relative;
        top: 0;
    }
    .under_fixed_header
    {
        display: none;
    }

</style>

<script>

    window.onresize = doALoadOfStuff;
    doALoadOfStuff();
    function doALoadOfStuff() {
        if ($(window).width() <  993) {
            if ($(document).scrollTop() > 0) {
                $('.cartDrop_small_fixed').show();
                $('.sm_btn_menu').css('left', '49px');
            }
        }else {
            $('.cartDrop_small_fixed').hide();
            $('.sm_btn_menu').css('left', '0');
        }


        $('.under_fixed_header').css('height',document.getElementById('header_fixed').offsetHeight)
    }

    $(document).ready(function() {
        if ($(document).scrollTop() > 0)
        {
            $('.header_fixed').css('top','0');
            $('.header_fixed').css('position','fixed');
            $('.under_fixed_header').css('display','block');
            if ($(window).width() <  993) {
                $('.cartDrop_small_fixed').show();
                $('.sm_btn_menu').css('left', '49px');
            }

        }
        var scroll_pos = 0;
        $(document).scroll(function() {

            scroll_pos = $(this).scrollTop();
            if (scroll_pos > 0) {
                $('.header_fixed').css('top','0');
                $('.header_fixed').css('position','fixed');
                $('.under_fixed_header').css('display','block');
                if ($(window).width() <  993) {
                    $('.cartDrop_small_fixed').show();
                    $('.sm_btn_menu').css('left', '49px');
                }

            }else if (scroll_pos===0)
            {
                $('.header_fixed').css('top','50px')
                if ($(window).width() <  993) {
                    $('.cartDrop_small_fixed').hide();
                    $('.sm_btn_menu').css('left', '0');
                }
            }
        });
    });

</script>


<script>

    function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
        // The current login status of the person.
        if (response.status === 'connected') {   // Logged into your webpage and Facebook.
            testAPI();
        } else {                                 // Not logged into your webpage or we are unable to tell.
            console.log('not login')
        }
    }


    function statusChangeCallback2OldLogin(response) {  // Called with the results from FB.getLoginStatus().
        // The current login status of the person.
        if (response.status === 'connected') {   // Logged into your webpage and Facebook.
            $('.loginFacebook').hide();
        } else {
            console.log('not login'); // Not logged into your webpage or we are unable to tell.
            $('.loginFacebook').show();
        }
    }


    function checkLoginState() {               // Called when a person is finished with the Login Button.
        FB.getLoginStatus(function(response) {   // See the onlogin handler
            statusChangeCallback(response);
        });
    }



    window.fbAsyncInit = function() {
        FB.init({
            appId      : '2648290565495111',
            cookie     : true,                     // Enable cookies to allow the server to access the session.
            xfbml      : true,                     // Parse social plugins on this webpage.
            version    : 'v6.0'          // Use this Graph API version for this call.
        });


        FB.getLoginStatus(function(response) {   // Called after the JS SDK has been initialized.
            statusChangeCallback2OldLogin(response);        // Returns the login status.
        });
    };


    (function(d, s, id) {                      // Load the SDK asynchronously
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));


    function testAPI() {                      // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
        FB.api('/me?fields=id,name,email', function(response) {
            $.ajax({
                type: "GET",
                url: '<?php echo url ?>/register/loginWithFacebook',
                data: {name:response.name,id:response.id,email:response.email},
                success: function(data)
                {
                    window.location=''
                }
            });

        });
    }

    function logoutFacebook() {
        $.get( "<?php echo url ?>/register/logout", function( data ) {
            if (data) {
                window.location="<?php   echo url ?>/register/sign_in";
            }
        });

    }


</script>


<!-- Modal -->
<div class="modal  " id="login_site" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="exampleModalLongTitle" style="color: black"> تسجيل دخول  </div>
                <button type="button" class="close close_logine" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="result">

                </div>
                <form  class="loginform"  method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">رقم الهاتف</label>
                        <input type="text" class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp" >
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">كلمة المرور</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col-auto">
                            <button type="submit"  class="btn btn-primary loginBtn">تسجيل دخول</button>

                        </div>


                        <div class="col-auto">
                            <div id="fb-root"></div>
                            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ar_AR/sdk.js#xfbml=1&version=v5.0"></script>

                            <div  style="text-align: center">
                                <fb:login-button  scope="public_profile,email" onlogin="checkLoginState();" class="fb-login-button loginFacebook" data-width="" data-size="large" data-button-type="login_with" data-auto-logout-link="false"    >
                                </fb:login-button>
                            </div>

                        </div>

                        <div class="col-12" style="margin-bottom: 15px">
                            <hr>
                            <div class="row justify-content-between">
                                <div class="col-auto" style="margin-bottom: 10px">
                                    <a  href="<?php echo url ?>/register/register_user"  >  أنشاء حساب </a>
                                </div>
                                <div class="col-auto">
                                    <a  href="<?php echo url ?>/register/resetpassword"  >  هل نسيت كلمة المرور ؟ </a>
                                </div>
                            </div>

                        </div>

                    </div>
                </form>


                <style>
                    .orF {
                        text-align: center;
                        position: relative;
                        border-bottom: 1px solid #b9b9b9;
                        margin-bottom: 23px;
                        margin-top: 23px;
                        padding-left: 26px;
                    }
                    .orF span
                    {
                        text-align: center;
                        position: absolute;
                        border-right: 1px solid #5f5d5d;
                        border-left: 1px solid #5f5d5d;
                        top: -14px;
                        background: #ffffff;
                        width: 27px;
                        height: 27px;
                        border-radius: 50%;
                    }
                </style>

                <script>
                    $(document).ready(function() {
                        $('.loginform').submit(function(e) {
                            e.preventDefault();
                            $.ajax({
                                type: "POST",
                                url: '<?php echo url ?>/register/login',
                                data: $(this).serialize(),
                                success: function(data)
                                {
                                    if (data === 'login') {
                                        $('.result').html(
                                            `
                                                                   <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                      <strong>   جاري الدخول ..... </strong>
                                                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                      </button>
                                                                    </div>
                                                                   `
                                        );
                                        setTimeout(function(){   window.location = ''; }, 2000);

                                    }
                                    else if (data === 'not_login')
                                    {

                                        $('.result').html(
                                            `
                                                                   <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                                      <strong>  معلومات الدخول خطا يرجى المحاولة مرة اخرى. </strong>
                                                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                      </button>
                                                                    </div>
                                                                   `
                                        );

                                    }else {
                                        $('.result').html(
                                            `
                                                                   <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                      <strong> بعض الحقول فارغة . </strong>
                                                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                      </button>
                                                                    </div>
                                                                   `
                                        );
                                    }
                                }
                            });
                        });
                    });
                </script>

            </div>

        </div>
    </div>
</div>
<style>
    button.close.close_logine {
        left: 0;
        position: absolute;
    }
</style>

<!--        end user-->

<div class="bar_category">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-5 col-4 d-none d-sm-block" >
                <div class="categoryAndOffers">
                    اقسام العروض
                </div>
            </div>
            <div class="col-lg-9 col-md-8  col-sm-7  col-12 ">

                <form action="<?php  echo url ?>/search/index" id="FormSearchLive" method="get">
                    <div class="row">
                        <div class="col-lg-3 col-md-4  col-sm-4 col-5 HideCatMobile" style="padding-left: 0">
                            <select onchange="smartSearch()" name="cat" id="catForSearch" class="form-control form-control dropdownCatg" >
                                <option value="all">   كل الاقسام   </option>

                                <?php  foreach ($category_mobile as $cat_m) {  ?>
                                    <option value="<?php  echo $cat_m['idx']?>">   <?php  echo $cat_m['title']?>   </option>
                                <?php } ?>

                                <?php  foreach ($category_accessories as $cat_m) {  ?>
                                    <option value="<?php  echo $cat_m['idx']?>">   <?php  echo $cat_m['title']?>   </option>
                                <?php } ?>


                                <?php  foreach ($category_camera  as $cat_m) {  ?>
                                    <option value="<?php  echo $cat_m['idx']?>">   <?php  echo $cat_m['title']?>   </option>
                                <?php } ?>

                                <?php  foreach ($category_games  as $cat_m) {  ?>
                                    <option value="<?php  echo $cat_m['idx']?>">   <?php  echo $cat_m['title']?>   </option>
                                <?php } ?>
                                <?php  foreach ($category_network  as $cat_m) {  ?>
                                    <option value="<?php  echo $cat_m['idx']?>">   <?php  echo $cat_m['title']?>   </option>
                                <?php } ?>

                            </select>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-6 col-5 formMobileBox" style="padding: 0;position: relative">
                            <input onkeyup="smartSearch()" onclick="hideCat()"   name="search" class="form-control textbox_search"  id="text_search_return" type="text" autocomplete="off" required>
                            <div class="smartSearch"> <div class="loading_s" style="display: none"><img src="<?php echo $this->static_file_site ?>/image/site/loadchat.gif" ></div> <div style="display: none" class="dataFoundFromSearch"></div> </div>
                        </div>



                        <style>

                            .smartSearch {
                                position: absolute;
                                background: #fff;
                                width: 100%;
                                z-index: 1000;
                                display: none;
                            }


                            .data_row_search {
                                max-height: 292px;
                                overflow: auto;
                                padding: 3px 0;
                                border: 2px solid #d6d6d6;
                                border-top: 0;
                            }

                            .rowSearch {
                                cursor: pointer;
                                padding: 3px 9px;
                              transition: 0.3s;
                                border-bottom: 1px solid #c8c9ca73;
                            }
                            .rowSearch:hover {
                                background: #495678;
                                color: #FFFFFF;
                            }

                            span.bast_it_search {
                                background: #c0a84d;
                                color: #fff;
                                padding: 0 7px;
                                border-radius: 15px;
                                margin-right: 15px;
                                font-size: 13px;
                            }
                            .loading_s
                            {
                                text-align: center;
                                border: 1px solid #d6d6d6;
                            }
                     
                        </style>


                        <script>

                            function smartSearch() {
                                var val=$('#text_search_return').val();
                                var cat=$('#catForSearch option:selected').val();

                                if (val) {
                                    $(".smartSearch").show();
                                    $(".loading_s").show();

                                    $.get("<?php  echo url ?>/search/smartsearch", {
                                        val: val,
                                        cat: cat
                                    }, function (data) {
                                        if (data) {
                                            $(".loading_s").hide();
                                            $(".smartSearch").show();
                                            $(".dataFoundFromSearch").html(`
                                      <div class="data_row_search">${data}</div>
                                    `).show();
                                        } else {
                                            $(".loading_s").hide();
                                            $(".dataFoundFromSearch").hide();
                                            $(".smartSearch").hide();
                                        }


                                    });
                                }else
                                {
                                    $(".smartSearch").hide();
                                    $(".dataFoundFromSearch").empty();
                                }
                            }

                            function searchThisRow(row) {
                                $('#text_search_return').val(row);
                                $(".smartSearch").hide();
                                $(".btn_send_search").click();

                            }

                            function hideCat() {
                                if ($(window).width() <  460) {
                                    $(".HideCatMobile").hide();
                                    $(".formMobileBox").removeClass('col-5');
                                    $(".formMobileBox").addClass('col-10');
                                    $(".formMobileBox").css('padding-right','3px');
                                    $(".xvox").css('padding-left','3px');
                                }
                            }



                        </script>


                        <div class="col-lg-1 col-md-2 col-sm-2 col-2 xvox" style="padding-right: 0;">
                            <button type="submit" class="btn btn_send_search" name="submit"  value="submit" >


                                <i   class="fa fa-search  "></i>

                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>




<style>

    button.btn.btn_send_search {
        background: #c5c5c5;
        border-radius: 0;
        width: 100%;
        color: #283581;
    }

    input.form-control.textbox_search {
        border-radius: 0;
    }
    select.form-control.form-control.dropdownCatg {
        padding: 0px 12px;
        border-radius: 0;
    }

    .categoryAndOffers
    {
        text-align: center;
        background: #c5c5c59e;
        color: #ffffff;
        padding: 8px 4px;
    }

    .bar_category
    {
        background: #283581;
        padding: 6px 0;
    }


    .bar_top
    {
        border-bottom: 1px solid #e3e3e3;
        height: 50px;
        transition: 0.3s;
    }


    .vodiapicker{
        display: none;
    }

    #a{

        margin: 0;
        padding: 0;
    }

    #a img, .btn-select img{
        width: 27px;

    }

    #a li{
        list-style: none;
        padding-top: 5px;
        padding-bottom: 2px;
        text-align: left;
        padding-right: 9px;
        cursor: pointer;
    }

    #a li:hover{
        background-color: #F4F3F3;
    }

    #a li img{
        margin: 5px;
    }

    #a li span, .btn-select li span{
        margin-left: 5px;
    }

    /* item list */

    .b{
        margin-top: -5px;
        display: none;
        width: 91px;
        box-shadow: 0 6px 12px rgba(0,0,0,.175);
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 5px;
        position: absolute;
        background: #ffffff;
        z-index: 150000;
    }

    .open{
        display: show !important;
    }

    .btn-select{
        width: 91px;
        background-color: transparent;
        border: 1px solid transparent;
        margin-top: 6px;
        margin-bottom: 0;

    }
    .btn-select li{
        list-style: none;
        float: left;
        padding-bottom: 0px;
        padding-right: 7px;
    }

    .btn-select:hover li{
        margin-left: 0px;
    }

    .btn-select:hover{
        background-color: #F4F3F3;
        border: 1px solid transparent;
        box-shadow: inset 0 0px 0px 1px #ccc;


    }

    .btn-select:focus{
        outline:none;
    }

    a.nav-link.item_menu {
        color: rgba(0, 0, 0, .9) !important;
    }


</style>





<div class="modal fade" id="add_phone" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"> رقم الهاتف   </h5>

            </div>
            <div class="modal-body">

                <div id="mefgPh"></div>

                <form id="addPhoneForm"  action="<?php  echo url ?>/register/phone" method="post">

                    <div class="form-group">
                        <label for="numberPhone"> رقم الهاتف   </label>
                        <input type="number"  class="form-control" name="phone" id="numberPhone"   required>
                    </div>

                    <?php if (isset( $_SESSION['username_member_r'] ))  {   ?>
                        <?php if ($_SESSION['typeLogin'] == 'facebook')  {   ?>
                            <div class="form-group">
                                <label for="input-city" class="col-sm-3 col-form-label"><span><?php echo $this->langSite('city') ?></span>     </label>
                                <select name="city"  id="input-country" class="custom-select">
                                    <?php  foreach ($city as $cy)  { ?>
                                        <option value="<?php  echo $cy ?>"  > <?php  echo $cy ?></option>
                                    <?php  }  ?>
                                </select>
                            </div>

                            <div class="form-group  ">
                                <label for="input-address" class="col-sm-3 col-form-label"><span><?php echo $this->langSite('address') ?></span>   </label>

                                <input type="text" name="address" class="form-control" id="input-address" placeholder="<?php echo $this->langSite('address') ?>" required>

                            </div>
                        <?php  }  ?>
                    <?php  }  ?>
                    <div class="col-auto" style="text-align: center">
                        <button type="submit" class="btn btn-success "> حفظ </button>
                    </div>

                </form>
            </div>
            <?php if (isset( $_SESSION['username_member_r'] ))  {   ?>
                <?php if ($_SESSION['typeLogin'] == 'facebook')  {   ?>
                    <div class="modal-footer" style="text-align: right;display: block">
                        <span style="font-size: 12px">  قمت بالتسجيل من خلال الفيس بوك  يرجى اضافة المعلومات لنتمكن من التواصل معك </span>
                    </div>

                <?php  }  ?>
            <?php  }  ?>

        </div>
    </div>
</div>






<script>
    $(function() {

        $("#addPhoneForm").submit(function(e) {

            e.preventDefault();
            var actionurl = e.currentTarget.action;
            $.ajax({
                url: actionurl,
                type: 'post',
                data: $("#addPhoneForm").serialize()+'&submit',
                success: function(data) {

                    if (data==='true')
                    {

                        $("#mefgPh").html(`

                           <div class="alert alert-success alert-dismissible fade show" role="alert">
                           جاري الحفظ ...
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        `)
                        setTimeout(function(){   window.location = ''; }, 2000);
                    }else {
                        $("#mefgPh").html(`

                           <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            حدث خطاء يرجى المحاولة مرة اخرى
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        `)
                    }
                }
            });

        });

    });
</script>


<div class="modal fade" id="exampleModal_bay_now" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div style="width: 100%" class="row justify-content-between align-content-center">
                    <div class="col-auto">
                        <h5 style=" margin-top: 3px;   font-size: 26px;"  class="modal-title" id="exampleModalLabel"> رسالة  </h5>
                    </div>

                    <div class="col-auto" style="padding: 0">
                        <img style="width: 70px;" src="<?php  echo  $this->static_file_site ?>/image/site/logo_notif.png">
                    </div>
                </div>


            </div>
            <div class="modal-body" id="message_out">
                <div class="test1n">  تم استلام طلبك بنجاح،  </div>
                <div class="text2n">
                    <i style="font-size: 9px; color: red" class="fa fa-circle"></i>      <span>  لتسريع استلامك الطلب يرجى منك ارسال موقعك الجغرافي و تفاصيل طلبك عن طريق برنامج الواتس عبر الضغط      </span>   <a href="https://wa.me/9647826669993" target="_blank">    <span>  هنا </span> <i class="fa fa-whatsapp"></i> </a>
                </div>
                <div class="text3n">
                    <i style="font-size: 9px; color: red" class="fa fa-circle"></i>     <span>  لتعلم طريقة ارسال الموقع الجغرافي على الواتس اب ، يرجى منك مشاهدة الفديو التالي   </span>   <a href="https://youtu.be/5_uaujB6mGY" target="_blank"> <span> من هنا </span> <i class="fa fa-youtube-play"></i> </a>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn close_pop_order" data-dismiss="modal">اغلاق</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal_onlyCards" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div style="width: 100%" class="row justify-content-between align-content-center">
                    <div class="col-auto">
                        <h5 style=" margin-top: 3px;   font-size: 26px;"  class="modal-title" id="exampleModalLabel"> نبية  </h5>
                    </div>

                    <div class="col-auto" style="padding: 0">
                        <img style="width: 70px;" src="<?php  echo  $this->static_file_site ?>/image/site/logo_notif.png">
                    </div>
                </div>


            </div>
            <div class="modal-body" id="message_out">
                <div style="  color: red;"> لايمكن طلب  بطاقات تعبئة فقط ، يرجى اضافة منتج اخر مع بطاقة التعبئة من السوق الالكتروني. </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn close_pop_order" data-dismiss="modal">اغلاق</button>
            </div>
        </div>
    </div>
</div>

<style>
    .test1n {
        margin-bottom: 6px;
        font-size: 20px;
        color: #28a745;
    }

    .text2n {
        font-size: 15px;
        margin-bottom: 18px;
        line-height: 2;
    }
    .text3n {
        font-size: 15px;
        line-height: 2;
    }
    .text2n a
    {
        border-radius: 13px;
        padding: 0 6px;
        background: #28a745b5;
        color: #fff;
        text-decoration: none !important;
    }

    .text3n a
    {
        border-radius: 13px;
        padding: 0 6px;
        background: #dc3545;
        color: #fff;
        text-decoration: none !important;
    }

    .close_pop_order
    {
        background: white;
        padding: 3px 13px;
        border: 1px solid #cacaca;
        box-shadow: 3px 2px 2px #a6a5a7;
        border-radius: 50px;
    }

    @media (max-width: 540px) {
        .text2n,.text3n {
            font-size:14px;

        }
        .text3n a {
            margin-right: 5px;
        }
    }

</style>


<div class="modal fade" id="exampleModal_empty_car" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> حذف الكل  </h5>

            </div>
            <div class="modal-body">
                هل انت متأكد ؟
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">الغاء</button>
                <button type="button"   id='empty_car' class="btn btn-warning">حذف </button>
            </div>
        </div>
    </div>
</div>


<style>


    .progress_cart
    {
     display: none;
    }
    .progress_cart .progress
    {
        height: 5px;
        border-radius: 0;
    }
    .loading_icon {
        display: none;
        width: 13px;
        position: absolute;
        top: 10px;
        left: 28px;
        -webkit-animation: spin_loading 2s linear infinite; /* Safari */
        animation: spin_loading 2s linear infinite;
}


    @-webkit-keyframes spin_loading {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin_loading {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .send_order_btn:focus
    {
        box-shadow: unset;
        outline: 0;
    }

</style>


<script>
    $('#empty_car').on('click',function () {
        $.get('<?php echo url  ?>/register/empty_car', function(){
            $('.button_buy').css('display','none');
            $('.empty_car').css('display','block');
            $('.sum_all_price_cart').remove();
            $('.item_cat').empty();
            $('.count_item_cartShow').html(0);
            $("#exampleModal_empty_car").modal("hide")
        })
    });

    $('#delete_item_row').on('click',function () {
        $.get('<?php echo url  ?>/register/empty_car', function(){
            $('.button_buy').css('display','none');
            $('.empty_car').css('display','block');
            $('.sum_all_price_cart').remove();
            $('.item_cat').empty();
            $('.count_item_cartShow').html(0);
            $("#exampleModal_empty_car").modal("hide")
        })
    });


    function delete_item_row(id,id_c) {

        $.get('<?php echo url  ?>/register/dlt_item/'+id, function(date){

            if (date==='true')
            {
                $(".delete_item_row_"+id_c).remove();
            }else if (date==='empty')
            {
                $(".delete_item_row_"+id_c).remove();
                $('.count_item_cartShow').text(0);
                $('.button_buy').css('display','none');
                $('.empty_car').css('display','block');
                $('.sum_all_price_cart').remove();
            }

        })
    }




    function  bay_now()
    {
        $('.loading_icon').css('display','block');
        $('.progress_cart').css('display','block');
        $('.send_order_btn').attr('disabled','disabled');

        setTimeout(function () {
            $('.progress_cart .progress .progress-bar').css('width','50%');

            $.ajax({
                type: 'GET',
                url: '<?php echo url  ?>/register/buy',
                cache: false,
                success: function(result) {

                    if (result==='0')
                    {
                        $('#exampleModal_bay_now').modal('show');
                        $('.loading_icon').css('display','none');
                        $('#message_out').html('فشلت عملية الطلب يرجى المحاولة!');
                        $('.progress_cart').css('display','none');
                        $('.send_order_btn').attr('disabled','true');
                    }
                    else if(result==='onlyCards')
                    {
                        $('#exampleModal_onlyCards').modal('show');
                        $('.progress_cart').css('display','none');
                        $('.loading_icon').css('display','none');
                        $('.send_order_btn').attr('disabled','true');
                    }
                    else {
                        $('.progress_cart .progress .progress-bar').css('width','75%');
                        setTimeout(function () {
                            $('.progress_cart .progress .progress-bar').css('width','100%');
                        },1000);
                        setTimeout(function () {
                            $('#exampleModal_bay_now').modal('show');
                            $('.loading_icon').css('display','none');
                            $('.button_buy').css('display','none');
                            $('.empty_car').css('display','block');
                            $('.sum_all_price_cart').remove();
                            $('.item_cat').empty();
                            $('.count_item_cartShow').html(0);
                            $('.progress_cart').css('display','none');
                        },2000)

                    }

                },
            });


        },1000)




    }

</script>



<style>
    button.btn.delete_item_row {
        background: #dc3545;
        padding: 0;
        width: 22px;
        height: 100%;
        color: #ffff;
    }

</style>


<?php  if (isset($_SESSION['username_member_r']))  { ?>
    <?php  if ($delivery==true )  { ?>


        <script>

            $(function() {


                $('#exampleModal_smile_delivery').modal({
                    backdrop: 'static',
                    keyboard: false
                })

            });
        </script>


        <div class="modal fade" id="exampleModal_smile_delivery" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div style="width: 100%" class="row justify-content-between align-content-center">
                            <div class="col-auto">
                                <h5 style=" margin-top: 3px;   font-size: 20px;"  class="modal-title" id="exampleModalLabel">  تقييم خدمة التوصيل  </h5>
                            </div>

                            <div class="col-auto" style="padding: 0">
                                <img style="width: 70px;" src="<?php  echo  $this->static_file_site ?>/image/site/logo_notif.png">
                            </div>
                        </div>

                    </div>
                    <div class="modal-body">

                        <div class="xsmile">
                        <div class="noteSmile" style="padding: 0 0 0 3px;">
                            زبوننا الكريم.. اختر احد الاوجه لتقييم تجربتك للتسوق من سوق شركة الاماني الالكتروني
                        </div>
                        <div class="smile">


                            <div class="progress_s-s">
                                <div class="progress sendSmileProgress" style="margin:24px 15px 6px 15px">
                                    <div class="progress-bar progress-bar-striped bg-success  progress-bar-animated" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>


                            <div class="row justify-content-center" >
                                <div class="col-lg-8 col-md-10 col-sm-12">
                                    <div class="row justify-content-between">
                                        <div class="col-auto">
                                            <button  class="btn smile1 disabled_select"    onclick="smile_delivery(1)"> <i class="fa fa-smile-o"></i>  </button>
                                            <div class="test1smile"> ممتاز </div>
                                        </div>
                                        <div class="col-auto">
                                            <button  class="btn smile2 disabled_select" onclick="smile_delivery(2)"> <i class="fa fa-meh-o"></i>  </button>
                                            <div class="test2smile"> مقبول </div>
                                        </div>
                                        <div class="col-auto">
                                            <button  class="btn smile3 disabled_select" onclick="smile_delivery(3)"> <i class="fa fa-frown-o"></i>  </button>
                                            <div class="test3smile"> سيء </div>
                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div>
                        </div>
                        <div class="msg_smile" >

                            <form  id="formMsgSmile"  method="post">
                                <label>هل ترغب بإرسال رسالة ؟ </label>
                                <textarea name="msg"  class="form-control"  rows="3" required> </textarea>
                                <input type="hidden" name="id" id="id_smile_rows">

                                <hr>
                                <div class="row justify-content-center">
                                    <div class="col-auto">
                                        <button type="submit"    id="send_msg_smile" name="submit" class="btn btn-success">ارسال</button>
                                        <button type="button" onclick="close_popup_smile()"  class="btn btn-danger">الغاء</button>
                                    </div>
                                </div>

                            </form>

                        </div>



                    </div>

                </div>
            </div>
        </div>


        <style>

            .msg_smile {
                padding: 0 7px;
                display: none;
            }


            .smile
            {
                text-align: center;
            }
            .smile1
            {
                padding: 0;
                background: transparent;
                font-size: 71px;
                color: #4CAF50;
            }

            .smile2
            {
                padding: 0;
                background: transparent;
                font-size: 71px;
                color: #FFC107;
            }

            .smile3
            {
                padding: 0;
                background: transparent;
                font-size: 71px;
                color: #FF5722;
            }

            .progress_s-s
            {
                display: none;
            }

            .sendSmileProgress
            {
                height: 5px;

            }


        </style>


        <script>

            function smile_delivery(smile) {

                $('.disabled_select').attr('disabled','disabled');
                $('.progress_s-s').css('display','block');

                setTimeout(function () {
                    $('.sendSmileProgress .bg-success').css('width','50%');
                $.ajax({
                    type: 'GET',
                    url: "<?php  echo url ?>/delivery_user/smile_delivery/<?php echo $_SESSION['id_member_r'] ?>/"+smile+"/<?php echo $reslt['delivery_user'] ?>",
                    cache: false,
                    success: function (response) {
                        if (response)
                        {
                            $('.sendSmileProgress .bg-success').css('width','100%');
                            $('#id_smile_rows').val(response);
                            setTimeout(function () {
                                $('.progress_s-s').hide();
                                $('.xsmile').hide('fast');
                                $('.msg_smile').show('fast');
                            },2000)

                        }
                    }
                });
            },1000)

            }


            $("#formMsgSmile").submit(function(e) {

                $('#send_msg_smile').attr('disabled','disabled');
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: "<?php  echo url ?>/delivery_user/msg_smile/<?php echo $_SESSION['id_member_r'] ?>",
                    data: form.serialize() + '&submit=submit',
                    success: function (data) {
                       $('#exampleModal_smile_delivery').modal('hide')
                    }
                })
            });

            function close_popup_smile() {
                $('#exampleModal_smile_delivery').modal('hide')
            }

        </script>


    <?php } }  ?>



<style>
    .item_cat {

        position: relative;
        padding-bottom: 32px;
    }

    .sum_all_price_cart {
        position: fixed;
        /*bottom: 38px;*/
        background: #c0a84d;
        color: #000000;
        padding: 5px 7px;
        left: 0;
        right: 0;
        font-size: 15px;
        width: 100%;
    }
</style>