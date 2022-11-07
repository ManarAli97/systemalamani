<!DOCTYPE html>
<meta property="og:type" content="website"/>
<html dir="<?php echo $this->dirSite ?>">
<head>
    <meta charset="UTF-8">
    <!--    <meta name="viewport" content="width=device-width, initial-scale=0, maximum-scale=0" />-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title><?php echo $this->title;?></title>
    <link rel="icon"   href="<?php echo $this->static_file_site ?>/image/site/logo_notif.png">

    <meta name="mobile-web-app-capable" content="yes">
    <!--jquery -->
    <script src="<?php echo $this->static_file_site ?>/js/jquery.min.js"></script>

    <!--bootstrap-->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/bootstrap/css/bootstrap.min.css" >


    <!--css range-->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/range_input2/jquery.range.css">

    <!--custom css -->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/css/default1.css"/>

    <!--custom js-->
    <script src="<?php echo $this->static_file_site ?>/js/custom.js"></script>


    <!--bootstrap-toggle-->
    <link href="<?php echo $this->static_file_site ?>/bootstrap/toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="<?php echo $this->static_file_site ?>/bootstrap/toggle/js/bootstrap-toggle.min.js"></script>

    <!--upload file-->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/dist2/font-awesome.min.css"/>



    <!--      pagenation-->
    <script src="<?php echo $this->static_file_control ?>/js/pagenation/twbsPagination.js"></script>
    <script src="<?php echo $this->static_file_control ?>/zoom/jquery.elevatezoom.js"></script>

    <!--    swiper-->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/swiper/swiper.min.css">
    <script src="<?php echo $this->static_file_site ?>/js/qrcode.min.js"></script>

    <!--  range -->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/range/jquery-ui.css" type="text/css" media="all" />
    <script src="<?php echo $this->static_file_site ?>/range/jquery-ui.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->static_file_site ?>/range/price_range_script.js"></script>

    <script src="<?php echo $this->static_file_site ?>/countdown/jquery.countdown.js"></script>


    <script src="<?php echo $this->static_file_site ?>/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo $this->static_file_site ?>/bootstrap/js/bootstrap.min.js"  ></script>
    <link rel="stylesheet" href="<?=url ?>/controllers/header/css/surveys.css" />
    <script src="<?php echo $this->static_file_site ?>/camera/app.js"></script>

    <script>

        var myarr_non = ['NON','non','UNKNOWN','unknown','Unknown','Non','بلا','',' ','  '];
        var convertAcount=0;
    </script>


    <style>

        @media  only screen and  (max-width: 980px) and  (min-width: 700px)
        {
            .container {
                max-width: 970px;
            }

            .style_btn_like_mb {
                width: 48%;
            }
            .comparison {
                width: 48%;
            }
            .xcartp {
                padding: 0 15px;
            }
        }


        @media  only screen and  (max-width: 700px) and  (min-width: 500px)
        {
            .container {
                max-width: 970px;
            }
        }
        @media (max-width: 570px)
        {
            .xcartp {
                padding: 0 15px;
                margin-bottom: 5px;
            }
        }




        /* width */
        ::-webkit-scrollbar {
            height: 10px;
            width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #495678;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        * {
            font-family: 'DroidArabicKufi';

        }



    	/*Style offers every day*/
	.ribbon_offers {
    	position: absolute;
    	width: 52px;
   		height: 52px;
    	background: #ffb600;
    	border: 1px solid #ffb600;
    	top: 30px;
    	left: 0px;
    	z-index: 10;
    	border-radius: 50%;
    	display: flex;
    	justify-content: center;
    	align-items: center;
    	text-align: center;
    	cursor: pointer;

	}

	@media (max-width: 767px) {
    	.ribbon_offers {
        	left: -3px;
        	top: 30px  !important;
        	position: absolute;
        	width: 45px;
        	height: 45px;
    	}
    	.ribbon_offers .text-ribbon {
        	font-size: 11px !important;
    	}
	}

	.ribbon_offers .text-ribbon {
    	color: #000;
    	text-align: center;
    	font-size: 13px;
    	padding-top: 10px;
	}
	.ribbon_offers a {
    	text-decoration:none;
	}



    </style>

</head>
<body class="fr-view" style="overflow-x: hidden;">


<?php  if (isset($_SESSION['username_member_r'])) {   ?>

    <div class="modal  " onclick="select_qr_input()" id="exampleModal_qr_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="position: relative">
                    <h5 class="modal-title" id="exampleModalLabel">   الدخول بستخدام رمز QR   </h5>
                    <div class="loginTimeOut">60</div>
                </div>
                <div class="modal-body">
                    <div class="iconqr" style="margin-bottom: 18px;text-align: center">
                        <img width="100" src="<?php echo $this->static_file_site ?>/image/site/qr.png">
                    </div>

                    <form id="check_qr_login"  method="post" action="<?php echo url  ?>/enter/rprice?login=login">
                        <div class="error_qr_login"></div>
                        <div class="form-row align-items-center">
                            <div class="col" style="position: relative">
                                <input type="search"   style="width: 0;height: 0;padding: 0;margin: 0;box-shadow: unset;outline: unset;border: 0"           inputmode="none"        autocomplete="off"   name="qr" class="form-control" id="qrcodeprice" placeholder="اضغط هنا ثم قم بتوجيه رمز QR الخاص بك نحو الكامرة"  required>
                            </div>

                        </div>
                    </form>
                    <input   style="width: 0;height: 0;padding: 0;margin: 0;box-shadow: unset;outline: unset;border: 0"  inputmode="none"      class="form-control" id="qrcodeprice2"    >



                </div>
                <div class="modal-footer text-right d-block">
                    اجعل رمز ال QR الخاص بك امام الكامره
                </div>
            </div>
        </div>
    </div>





    <style>
        .loginTimeOut {
            position: absolute;
            left: 21px;
            top: 15px;
            border-radius: 50%;
            border: 1px solid #9e9e9e;
            width: 34px;
            height: 34px;
            font-size: 20px;
            text-align: center;
            font-weight: bold;
            box-shadow: 0 0 10px 0 #847c7c;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>


    <form action="<?php echo url  ?>/enter/rprice?login=login" id="convertAcountCustomer" method="post"  >

        <input type="text" name="qr"   style="width: 0;height: 0;padding: 0;margin: 0;box-shadow: unset;outline: unset;border: 0 ; position: absolute;"        inputmode="none" id="covertAcount">
    </form>



    <script type="text/javascript">





        function select_qr_input()
        {
            $("#qrcodeprice").val('');
            $(document).ready(function() {
                $("#qrcodeprice").select();
            });

        }





        if (localStorage.getItem("uuid")  !== '1000' ) {

            if (localStorage.getItem("counter")) {
                if (localStorage.getItem("counter") >= 600) {
                    convertAcount = 1;
                    $('#exampleModal_qr_logout').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    newCountLogout()
                    select_qr_input()
                    value = localStorage.getItem("counter");
                } else {
                    value = localStorage.getItem("counter");
                }
            } else {
                value = 0;
            }


            var counter = function () {
                if (value === 600) {
                    convertAcount = 1;
                    $('#exampleModal_qr_logout').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    newCountLogout()
                    select_qr_input()

                    localStorage.setItem("counter", value);
                    value = parseInt(value) + 1;
                } else {
                    value = parseInt(value) + 1;
                    localStorage.setItem("counter", value);
                }
            };

            var interval = setInterval(counter, 1000);

        }





        var refreshIntervalId='';
        function newCountLogout()
        {
            refreshIntervalId = setInterval(backLogin, 1000)
        }

        logOut=1;
        logOutTime=60;
        function backLogin()
        {
            if (logOut === 60)
            {
                localStorage.setItem("counter", 0)
                $('.loginTimeOut').text(0)
                $.get( "<?php echo url ?>/register/logout", function( data ) {
                    if (data) {
                        window.location="<?php   echo url ?>/enter";
                    }
                });
            }else if (logOut < 60)
            {
                $('.loginTimeOut').text(logOutTime)
            }
            logOut++;
            logOutTime--;
        }

        function select_qr_input2()
        {

            $("#qrcodeprice2").val('');
            $(document).ready(function() {
                $("#qrcodeprice2").select();
            });

        }



        $("#check_qr_login").submit(function(e) {

            if (localStorage.getItem("uuid")  === $('#qrcodeprice').val() )
            {
                logOut=0
                logOutTime=60;
                value = 0
                counter();
                localStorage.setItem("counter", 0);
                clearInterval(refreshIntervalId);
                $('#exampleModal_qr_logout').modal('hide')
                $('.loginTimeOut').text(60)

                if (localStorage.getItem("confirmation_order"))
                {
                    bay_now();
                }

                convertAcount =0;

            }else {

                e.preventDefault(); // avoid to execute the actual submit of the form.
                var form = $(this);
                var url = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize() + "&submit=submit&screen="+localStorage.getItem("screen_user"), // serializes the form's elements.
                    success: function (data) {
                        if (data === 'rqr') {
                            select_qr_input()
                            $(".error_qr_login").text('رمز QR الخاص بك غير صحيح!');
                        } else {
                            value = 0
                            select_qr_input2();
                            localStorage.setItem("counter", 0);
                            localStorage.setItem("uuid", data);
                            window.location = "<?php echo url ?>"

                        }
                    }
                });
            }return false;

        });



        setInterval(function () {
            if (convertAcount == 0 )
            {
                $(document).ready(function() {
                    var ca = $("#covertAcount").val();
                    if (ca.length < 1 )
                    {
                        $("#covertAcount").select();
                    }
                });
            }
        },1000);




        $("#convertAcountCustomer").submit(function(e) {
            if ($('#covertAcount').val()) {
                e.preventDefault(); // avoid to execute the actual submit of the form.
                var form = $(this);
                var url = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize() + "&submit=submit&screen="+localStorage.getItem("screen_user"), // serializes the form's elements.
                    success: function (data) {
                        if (data === 'rqr') {

                            $("#covertAcount").val('').select();
                            alert('رمز QR غير صالح! اعد المحاولة')
                        } else {

                            value = 0;
                            select_qr_input2();
                            localStorage.setItem("counter", 0);
                            localStorage.setItem("uuid", data);
                            window.location = "<?php echo url ?>"

                        }
                    }
                });
            }else
            {
                $("#covertAcount").val('').select();
            }return false;
        });






    </script>

<?php } ?>



<div class="bar_top" style="padding: 10px;background: #f8f8f8a3;">


    <div class="container">
        <div class="row justify-content-between  align-items-center">
            <div class="col x_padding1">
                <div class="row align-items-center	">

                    <?php if (!$this->isDirect()) { ?>

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

                                                    <a class="dropdown-item item_menu" href="<?php echo url ?>/register/details">  عرض الطلب السابق  </a>
                                                    <a class="dropdown-item item_menu" href="<?php echo url ?>/comparison">   مقارنة بين الاجهزة  </a>
                                                    <a class="dropdown-item item_menu btn"   onclick="logoutFacebook()">تسجيل خروج </a>
                                                <?php  }else{  ?>


                                                    <a class="dropdown-item item_menu" data-toggle="modal" style="cursor: pointer" data-target="#login_site">
                                                        <i class="fa fa-sign-in icon_user"  ></i>  <span > تسجيل الدخول</span>
                                                    </a>

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



                                    </div>
                                    <div class="progress_cart_background">
                                        <div class="progress_cart">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: 25%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button_buy">
                                        <div class="row">

                                            <div class="col-6">

                                                <?php  if($this->isDirect()){  ?>
                                                    <?php  if($_SESSION['direct'] ==1 || $_SESSION['direct']==2 || $_SESSION['direct']==3) { ?>
                                                        <button  data-toggle="modal" data-target="#exampleModalDirect" <?php  if ($_SESSION['direct']==3 ) echo "onclick='exampleModalDirectAxcol()'" ?>   <?php  if (isset($_COOKIE['g_active']) ) echo "onclick='active_qr()'" ?>      class="send_order_btn btn btn-primary buy  open_to_buy"> <span>طلب</span> <i    class="fa fa-spinner loading_icon"></i> </button>

                                                    <?php  } else {   ?>
                                                        <button  onclick="alert('لايمكن اتمام العملية انت لست بائع مباشر')" class="send_order_btn btn btn-primary buy  open_to_buy"> <span>طلب</span> <i    class="fa fa-spinner loading_icon"></i> </button>
                                                    <?php  }  ?>                                            <?php  }  else {  ?>
                                                    <button  onclick="bay_now()"  class="send_order_btn btn btn-primary buy  open_to_buy"> <span>طلب</span> <i    class="fa fa-spinner loading_icon"></i> </button>
                                                <?php  } ?>

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

                    <?php  }  else{   ?>

                        <?php  if (isset($_SESSION['loggedIn'])) {  ?>
                            <div class="col-auto" style="padding-top: 5px">


                                <div class="row">
                                    <div class="col-auto">
                                        <?php  if (!isset($_COOKIE['g_active'])) { ?>

                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton22" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <?php  echo $_SESSION['usernamelogin'] ?>
                                                </button>

                                                <?php if (!in_array($_SESSION['userid'],$this->idd1)  ) {  ?>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton22">
                                                        <?php if ($_SESSION['direct'] != 1) { ?>
                                                            <a class="dropdown-item" style="<?php if ($_SESSION['direct'] ==1 )  echo "display:none";?>" href="<?php echo url?>/home"> لوحة التحكم </a>
                                                        <?php  } ?>
                                                        <a class="dropdown-item"   href="<?php echo url ?>/login/logout">  تسجيل خروج </a>
                                                    </div>
                                                <?php } ?>
                                            </div>


                                        <?php }else {  ?>
                                            <a class="btn foundedBtn" href="<?php  echo $url ?>">
                                                الرئيسية
                                            </a>
                                        <?php } ?>
                                    </div>


                                    <?php if ($_SESSION['direct'] ==2 )  {    ?>
                                        <div class="col-auto">

                                            <a style="margin: 0" class="btn btn-info" href="<?php echo url?>/direct" >  <span class="bellOrder">   <i class="fa fa-bell "> </i> <?php $direct = new direct();  echo $direct-> all_notification_buy() ?> </span> </a>

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

                                        </div>
                                    <?php  } ?>

                                </div>
                            </div>





                        <?php  } ?>
                    <?php  } ?>

                </div>

            </div>

            <?php  if(!isset($_SESSION['usernamelogin']))  { ?>
                <?php  if ($quest) {  ?>
                    <div class="col-auto x_padding2">
                        <a class="msapka" href="<?php  echo url ?>/questions/view">

                            <img src="<?php echo $this->static_file_site ?>/image/site/msq2.png"/>

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

            <?php } ?>



            <?php if (isset($_SESSION['loggedIn'])) {  ?>
                <?php     if ($this->ch_smart_prepared($this->userid)) {  ?>
                    <div class="modal fade bd-example-modal-lg" id="exampleModalwithdraw_code" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog  modal-lg"  role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">سحب</h5>
                                </div>
                                <div class="modal-body">

                                    <form id="add_withdraw" action="<?php  echo url ?>/withdraw_return/add_withdraw" method="post">
                                        <div class="row align-items-center justify-content-between">


                                            <div class="col-lg-4 mb-3">
                                                <label> الموقع</label>
                                                <input id="location_withdraw" class="form-control" name="location"  required  autocomplete="off">
                                            </div>


                                            <div class="col-lg-4 mb-3">
                                                <label>رمز المادة</label>
                                                <input id="code_withdraw" class="form-control" name="code"  required autocomplete="off">
                                            </div>


                                            <div class="col-auto mt-3">
                                                <button   type="submit" class="btn btn-warning" >حفظ</button>
                                            </div>

                                            <div class="col-auto  mt-3" >
                                                <i   style="color: #0a7817;display: none" id="check_withdraw" class="fa fa-check-circle"></i>
                                            </div>

                                        </div>

                                    </form>

                                    <div class="result_withdraw_return_code">
                                        <div class="text-center">
                                            <div class="spinner-border" role="status"> </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button name="submit" type="submit" class="btn btn-secondary" data-dismiss="modal">خروج</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade bd-example-modal-lg" id="exampleModalreturn_code" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog  modal-lg"  role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">ارجاع</h5>
                                </div>
                                <div class="modal-body">




                                    <form id="add_return" action="<?php  echo url ?>/withdraw_return/add_return" method="post">
                                        <div class="row align-items-center justify-content-between">


                                            <div class="col-lg-5 mb-3">
                                                <label>رمز المادة</label>
                                                <input   id="code_return" class="form-control" name="code"  required autocomplete="off">
                                            </div>

                                            <div class="col-lg-5 mb-3">
                                                <label> الموقع</label>
                                                <input id="location_return" class="form-control" name="location"  required  autocomplete="off">
                                            </div>



                                            <div class="col-auto mt-3  ">
                                                <button    type="submit" class="btn btn-warning" >حفظ</button>
                                            </div>

                                            <div class="col-auto  mt-3" >
                                                <i style="color: #0a7817;display: none" id="check_return" class="fa fa-check-circle"></i>
                                            </div>

                                        </div>

                                    </form>
                                    <div class="result_withdraw_return_code">
                                        <div class="text-center">
                                            <div class="spinner-border" role="status"> </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button name="submit" type="submit" class="btn btn-secondary" data-dismiss="modal">خروج</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-auto p-0">
                        <button class="btn withdraw_code" onclick="withdraw_code_select()" data-toggle="modal" data-target="#exampleModalwithdraw_code"  > سحب</button>
                    </div>

                    <div class="col-auto p-1">
                        <button class="btn return_code" onclick="return_code_select()" data-toggle="modal" data-target="#exampleModalreturn_code"  >  ارجاع </button>
                    </div>

                    <script>


                        function get_result_withdraw_return_code() {
                            var vl = $('#code_return').val();
                            $.get( "<?php  echo url ?>/withdraw_return/get_location_code", function( data ) {

                                if (data ==='not_found')
                                {
                                    $('.result_return_code').html(`
                            <div class="alert alert-warning " role="alert">
                                 لا يوجد مواد مسحوبة
                                </div>
                            `);
                                }else {
                                    $('.result_withdraw_return_code').html(data);

                                }

                            });

                        }


                        function withdraw_code_select() {
                            setTimeout(function () {
                                $('#location_withdraw').select().val('')
                            },500)
                            get_result_withdraw_return_code()
                        }
                        $("#add_withdraw").submit(function(e) {

                            e.preventDefault(); // avoid to execute the actual submit of the form.

                            $('#check_withdraw').show();

                            var form = $(this);
                            var actionUrl = form.attr('action');

                            $.ajax({
                                type: "POST",
                                url: actionUrl,
                                data: form.serialize()+"&submit=submit", // serializes the form's elements.
                                success: function(data)
                                {

                                    get_result_withdraw_return_code()

                                    if (data) {
                                        if (data === 'add') {
                                            $('#code_withdraw').select().val('')
                                        } else if (data === 'location_model') {

                                            alert('الموقع ليس من ضمن مواقع الاقسام ');
                                            $('#code_withdraw').select()
                                        }else if (data === 'over_quantity_location')
                                        {
                                            alert('الكمية  المسحوبة اكبر من كمية الموقع ');
                                            $('#code_withdraw').select()
                                        }

                                        setTimeout(function () {
                                            $('#check_withdraw').hide();
                                        },500)
                                    }

                                }
                            });

                        });


                        function return_code_select() {
                            setTimeout(function () {
                                $('#code_return').select().val('')
                            },500)
                            get_result_withdraw_return_code()

                        }
                        $("#add_return").submit(function(e) {

                            e.preventDefault(); // avoid to execute the actual submit of the form.
                            $('#check_return').show();

                            var form = $(this);
                            var actionUrl = form.attr('action');

                            $.ajax({
                                type: "POST",
                                url: actionUrl,
                                data: form.serialize()+"&submit=submit", // serializes the form's elements.
                                success: function(data)
                                {
                                    get_result_withdraw_return_code()
                                    if (data) {

                                        if (data === 'add') {
                                            $('#location_return').select().val('')
                                        } else if (data === 'not_found_code') {
                                            $('#location_return').select()
                                            alert('رمز المادة او الموقع غير موجود ضمن السحب')

                                        } else if (data === 'location_model') {

                                            alert('الموقع ليس من ضمن مواقع الاقسام ');
                                            $('#location_return').select()
                                        }

                                        setTimeout(function () {
                                            $('#check_return').hide();
                                        },500)
                                    }

                                }
                            });

                        });



                    </script>
                <?php  } ?>
            <?php  } ?>




            <style>



                .withdraw_code
                {
                    background: #000000;
                    color: #fff !important;
                    padding: 0 4px;
                    margin: 0;
                    -webkit-box-shadow: 0px 2px 5px 0px rgb(0 0 0 / 10%);
                    -moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.1);
                    box-shadow: 0px 2px 5px 0px rgb(40 53 129);
                    text-decoration: none !important;

                }

                .return_code
                {
                    background: #283581;
                    color: #fff !important;
                    padding: 0 4px;
                    margin: 0;
                    -webkit-box-shadow: 0px 2px 5px 0px rgb(0 0 0 / 10%);
                    -moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.1);
                    box-shadow: 0px 2px 5px 0px rgb(40 53 129);
                    text-decoration: none !important;

                }

            </style>















            <?php  if($this->isDirect()){  ?>
                <?php  if( $_SESSION['direct']==3) { ?>

                <div class="col-auto x_padding2">
                    <div  class="bast_it_btn_modal">
                        <span><?php  echo $this->sizeBox($this->userid)?></span>
                    </div>
                </div>
            <?php  } ?>


                <div class="modal fade" id="exampleModalsearch_customer_qr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog  " role="document">
                        <div class="modal-content">
                            <div class="modal-header"  style="width: 100%;display: block">
                                <div class=" row justify-content-between">
                                    <div class="col-auto"> <h5 > تولد رمز QR </h5> </div>
                                    <div class="col-auto"> <h5 class="name_owner_qr font-weight-bold"></h5></div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="logo_on_qr">
                                    <div id="qrcode"></div>
                                    <img class="img_logo_qr" src="<?php  echo  $this->static_file_site ?>/image/site/logo_notif.png">
                                </div>
                                <div class="row hide_c_phone" >
                                    <div class="col">

                                        <label> ادخل رقم الهاتف</label>
                                        <input  type="number"    id="phone_qr" class=" form-control"   placeholder=" ادخل رقم الهاتف"   autocomplete="off" required>

                                    </div>

                                    <div class="col-auto align-self-end">
                                        <button class="btn btn-danger" onclick="get_qr_custom()"><i class="fa fa-qrcode"></i></button>
                                    </div>

                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button"  id="print_cust_qr" onclick="print_qr_custom()"  class="btn btn-primary" > طباعة رمز QR </button>
                                <button type="button"  onclick="$('.name_owner_qr').empty()"  class="btn btn-warning" data-dismiss="modal">خروج</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="<?php echo $this->static_file_site ?>/js/qrcode.min.js"></script>


                <style>

                    #print_cust_qr
                    {
                        display: none;
                    }

                    #qrcode img
                    {
                        display: initial !important;
                    }

                    .logo_on_qr
                    {
                        text-align: center;
                        position: relative;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }
                    .logo_on_qr .img_logo_qr
                    {
                        position: absolute;
                        background: white;
                        padding-right: 5px;
                        width: 75px;
                    }

                    .logo_on_qr{
                        display: none;
                    }






                    #qrcode_print
                    {

                        width: 100% !important;

                    }

                    #qrcode_print img
                    {
                        display: initial !important;
                        width: 100% !important;
                        height: 100% !important;
                    }

                    .name_owner_qr_print
                    {
                        text-align: center;
                        font-size:18px ;
                    }

                    .logo_on_qr_print
                    {
                        text-align: center;
                        position: relative;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .logo_on_qr_print .img_logo_qr_print
                    {
                        position: absolute;
                        background: white;
                        padding-right: 5px;
                        width: 150px;
                    }

                    .name_company_print
                    {
                        text-align: center !important;
                        font-size: 25px !important;
                        font-weight: bold !important;
                        margin-top: 30px !important;
                        padding-top: 15px !important;
                        border-top: 1px solid #000;

                    }
                    .noe_print
                    {
                        text-align: center;
                        font-size: 18px;
                        font-weight: bold;
                    }

                    .name_customer_print
                    {
                        text-align: center !important;
                        font-size: 45px !important;
                        font-weight: bold !important;
                        margin-bottom: 30px !important;
                        margin-top: 15px;
                    }


                    .print_qr_customer
                    {
                        display: none;
                        padding: 10px;
                    }

                    @media print {

                        .container
                        {
                            display: none;
                        }
                        #container_print
                        {
                            display: block;
                        }
                        @page {
                            size: A5; /* DIN A4 standard, Europe */
                            margin: 0;
                        }

                        * {
                            -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
                            color-adjust: exact !important; /*Firefox*/
                        }

                        body * {
                            visibility: hidden;

                        }

                        .print_qr_customer {
                            width: 100% !important;
                            height: auto !important;
                            position: relative;
                            visibility: visible;
                            display: block;
                        }

                        .print_qr_customer * {
                            position: relative;
                            visibility: visible;
                        }


                        .bar_top,.header_fixed,.bar_category
                        {
                            display: none;
                        }

                    }


                </style>

            <?php  if (!isset($_COOKIE['g_active'])) { ?>
                <div class="col-auto x_padding2">
                    <button class="btn get_qrcode" data-toggle="modal" data-target="#exampleModalsearch_customer_qr" onclick="set_model_qr()"><i class="fa fa-qrcode"></i></button>
                </div>
            <?php  } ?>
            <?php  } ?>

            <div class="col-auto x_padding2"><a href="<?= url.'/surveys' ?> ">
                    <button style="margin: 0" id="haiderButton">استبيان</button></a>
            </div>

            <div class="col-auto x_padding2">
                <a class="btn foundedBtn" href="<?php  echo url ?>/found/add">
                    اطلب مالم تجده
                </a>


                <style>


                    .get_qrcode {
                        font-size: 24px;
                        padding: 0;
                        height: 28px;
                    }
                    .get_qrcode i {
                        border: 1px solid #d1d1d1;
                        padding: 5px;
                        width: 40px;
                        border-radius: 5px;
                        color: #283581;
                        display:  unset;
                        text-rendering: unset;
                        padding-bottom: 3px;
                    }

                    .foundedBtn
                    {
                        background: #ffffff;
                        color: #000;
                        padding: 0 4px;
                        margin: 0;
                        -webkit-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.1);
                        -moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.1);
                        box-shadow: 0px 2px 5px 0px rgb(40 53 129);
                        text-decoration: none !important;
                    }


                    @media  (max-width: 460px){


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
                    box-shadow: 0px 2px 5px 0px rgb(40 53 129);
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
                    <a class="navbar-brand" href="<?php echo $url ?>"><img class="logo_site" style="max-width: 330px" src="<?php echo $Img ?>"></a>

                    <button class="navbar-toggler sm_btn_menu collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

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


                            </div>
                            <div class="progress_cart_background">
                                <div class="progress_cart">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: 25%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="button_buy">
                                <div class="row">

                                    <div class="col-6">


                                        <?php  if($this->isDirect()){  ?>
                                            <?php  if($_SESSION['direct'] ==1 || $_SESSION['direct']==2 || $_SESSION['direct']==3) { ?>
                                                <button  data-toggle="modal" data-target="#exampleModalDirect" <?php  if ($_SESSION['direct']==3 ) echo "onclick='exampleModalDirectAxcol()'" ?>  <?php  if (isset($_COOKIE['g_active']) ) echo "onclick='active_qr()'" ?>     class="send_order_btn btn btn-primary buy  open_to_buy"> <span>طلب</span> <i    class="fa fa-spinner loading_icon"></i> </button>

                                            <?php  } else {   ?>
                                                <button  onclick="alert('لايمكن اتمام العملية انت لست بائع مباشر')" class="send_order_btn btn btn-primary buy  open_to_buy"> <span>طلب</span> <i    class="fa fa-spinner loading_icon"></i> </button>
                                            <?php  }  ?>
                                        <?php  }  else {  ?>
                                            <button  onclick="bay_now()"  class="send_order_btn btn btn-primary buy  open_to_buy"> <span>طلب</span> <i    class="fa fa-spinner loading_icon"></i> </button>
                                        <?php  } ?>


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


                    <div class="d-none d-sm-none d-md-none">
                        <ul class="navbar-nav mr-auto ">
                            <li class="nav-item active">
                                <a class="nav-link item_menu" href="<?php echo $url ?>">  <i class="fa fa-home" ></i> <span>الرئيسية</span>  </a>
                            </li>


                            <?php if (!empty($category_mobile)) { ?>
                                <li class="nav-item dropdown li_dropdown_menu   ">

                                    <a class="nav-link Dropdown_main_menu dropdown-toggle" href="#">      <?php  echo $this->langSite('mobile')?>  </a>
                                    <ul class="dropdown-menu dropdown-menu-right first_sub_menu item_menu " aria-labelledby="navbarDropdownMenuLink1">
                                        <?php  foreach ($category_mobile as $key => $cat_s_t) { ?>
                                            <li class="dropdown-submenu rotate_this_active ">
                                                <a  class="nav-link Dropdown_main_menu mobile_menu_hover  <?php  echo $cat_s_t['sub'] ?>  "     data-ids="<?php  echo $cat_s_t['id'] ?>"   data-sub="0"  href="<?php  echo url ?>/mobile/list_view/<?php echo $cat_s_t['id'] ?>" id="navbarDropdownMenuLink1" data-toggle="" aria-haspopup="true" aria-expanded="false">

                                                    <i class="fa fa-mobile" ></i>
                                                    <?php echo  $cat_s_t['title'] ?>

                                                </a>
                                                <?php  if ($mobile->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                    <ul class="dropdown-menu dropdown-menu-right first_sub_menu  mobile_nav_hover<?php  echo $cat_s_t['id'] ?> " aria-labelledby="navbarDropdownMenuLink1">

                                                    </ul>
                                                <?php } ?>
                                            </li>

                                        <?php }  ?>
                                    </ul>

                                </li>
                            <?php  }  ?>





                            <?php if (!empty($category_accessories)) { ?>
                                <li class="nav-item dropdown li_dropdown_menu   ">

                                    <a class="nav-link Dropdown_main_menu dropdown-toggle" href="#">  <?php  echo $this->langSite('accessories')?> </a>
                                    <ul class="dropdown-menu dropdown-menu-right first_sub_menu item_menu " aria-labelledby="navbarDropdownMenuLink1">
                                        <?php  foreach ($category_accessories as $key => $cat_s_t) { ?>
                                            <li class="dropdown-submenu rotate_this_active ">
                                                <a class="nav-link Dropdown_main_menu  accessories_menu_hover <?php  echo $cat_s_t['sub'] ?>  " data-ids="<?php  echo $cat_s_t['id'] ?>" data-sub="0"  href="<?php  echo url ?>/accessories/list_view/<?php echo $cat_s_t['id'] ?>" id="navbarDropdownMenuLink1" data-toggle="" aria-haspopup="true" aria-expanded="false">


                                                    <?php echo  $cat_s_t['title'] ?>

                                                </a>
                                                <?php  if ($accessories->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                    <ul class="dropdown-menu dropdown-menu-right first_sub_menu accessories_nav_hover<?php  echo $cat_s_t['id'] ?>" aria-labelledby="navbarDropdownMenuLink1">

                                                    </ul>
                                                <?php } ?>
                                            </li>

                                        <?php }  ?>
                                        <li class="dropdown-submenu rotate_this_active ">
                                            <a class="nav-link Dropdown_main_menu  " href="<?php echo url ?>/savers/list_view">    <?php  echo $this->langSite('savers')?>  </a>
                                        </li>

                                    </ul>

                                </li>
                            <?php } ?>
                            <?php if (!empty($category_games)) { ?>
                                <li class="nav-item dropdown li_dropdown_menu   ">

                                    <a class="nav-link Dropdown_main_menu dropdown-toggle" href="#">      <?php  echo $this->langSite('games')?>  </a>
                                    <ul class="dropdown-menu dropdown-menu-right first_sub_menu item_menu " aria-labelledby="navbarDropdownMenuLink1">
                                        <?php  foreach ($category_games as $key => $cat_s_t) { ?>
                                            <li class="dropdown-submenu rotate_this_active ">
                                                <a class="nav-link Dropdown_main_menu games_menu_hover  <?php  echo $cat_s_t['sub'] ?>  "  data-ids="<?php  echo $cat_s_t['id'] ?>" data-sub="0"  href="<?php  echo url ?>/games/list_view/<?php echo $cat_s_t['id'] ?>" id="navbarDropdownMenuLink1" data-toggle="" aria-haspopup="true" aria-expanded="false">

                                                    <i class="fa fa-games" ></i>
                                                    <?php echo  $cat_s_t['title'] ?>

                                                </a>
                                                <?php  if ($games->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                    <ul class="dropdown-menu dropdown-menu-right first_sub_menu games_nav_hover<?php  echo $cat_s_t['id'] ?>" aria-labelledby="navbarDropdownMenuLink1">
                                                    </ul>
                                                <?php } ?>
                                            </li>

                                        <?php }  ?>
                                    </ul>

                                </li>
                            <?php }  ?>
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


                        </ul>


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


                        </div>
                        <div class="progress_cart_background">
                            <div class="progress_cart">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: 25%"></div>
                                </div>
                            </div>
                        </div>


                        <div class="button_buy">
                            <div class="row">

                                <div class="col-6">


                                    <?php  if($this->isDirect()){  ?>
                                        <?php  if($_SESSION['direct'] ==1 || $_SESSION['direct']==2 || $_SESSION['direct']==3) { ?>
                                            <button  data-toggle="modal"          data-target="#exampleModalDirect" <?php  if ($_SESSION['direct']==3 ) echo "onclick='exampleModalDirectAxcol()'" ?>   <?php  if (isset($_COOKIE['g_active']) ) echo "onclick='active_qr()'" ?>     class="send_order_btn btn btn-primary buy  open_to_buy"> <span>طلب</span> <i    class="fa fa-spinner loading_icon"></i> </button>

                                        <?php  } else {   ?>
                                            <button  onclick="alert('لايمكن اتمام العملية انت لست بائع مباشر')" class="send_order_btn btn btn-primary buy  open_to_buy"> <span>طلب</span> <i    class="fa fa-spinner loading_icon"></i> </button>
                                        <?php  }  ?>                                    <?php  }  else {  ?>
                                        <button  onclick="bay_now()"  class="send_order_btn btn btn-primary buy  open_to_buy"> <span>طلب</span> <i    class="fa fa-spinner loading_icon"></i> </button>
                                    <?php  } ?>

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



                <div class="modal  " id="exampleModal_delete_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<div  style="padding: 0 5px">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div id="accordion" class="d-lg-none d-block accordion_all_menu">


            <div class="card">
                <div class="card-header  accordion_row" id="headingOne_main_home">

                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <a class="link_acc" href="<?php  echo $url ?>"> <?php echo $this->langSite('home')?>   </a>
                        </div>

                    </div>
                </div>

            </div>



            <?php  if (!empty($category_site_acc_mobile)) { ?>
                <div class="card">
                    <div class="card-header  accordion_row" id="headingOne_main_mobile_acc">

                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <a class="link_acc" href="<?php echo url ?>/mobile/list_view"    >    <?php echo $this->langSite('mobile')?> </a>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_mobile_acc" aria-expanded="true" aria-controls="collapseOne_main_mobile_acc">
                                    <i class="fa fa-angle-down"> </i>
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
                                                        <button  value="0" onclick="get_sub_mobile(this,<?php  echo $cat_s_t['id'] ?>)"  class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="true" aria-controls="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>">
                                                            <i class="fa fa-angle-down"> </i>
                                                        </button>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div id="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" class="collapse " aria-labelledby="headingOne_main_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordion_mobile">
                                            <div class="card-body nested_accordion  body_menu_mobile<?php  echo  $cat_s_t['id'] ?>">

                                            </div>
                                        </div>
                                    </div>
                                <?php  }  ?>
                            </div>


                        </div>
                    </div>
                </div>
            <?php  }  ?>



            <?php  if (!empty($category_site_acc_accessories)) { ?>
                <div class="card">
                    <div class="card-header  accordion_row" id="headingOne_main_accessories_acc">

                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <a class="link_acc" href="<?php echo url ?>/accessories/list_view"  >    <?php echo $this->langSite('accessories')?> </a>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_accessories_acc" aria-expanded="true" aria-controls="collapseOne_main_accessories_acc">
                                    <i class="fa fa-angle-down"> </i>
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
                                                        <button  value="0" onclick="get_sub_accessories(this,<?php  echo $cat_s_t['id'] ?>)"   class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="true" aria-controls="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>">
                                                            <i class="fa fa-angle-down"> </i>
                                                        </button>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div id="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" class="collapse " aria-labelledby="headingOne_main_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordion_accessories">
                                            <div class="card-body nested_accordion  body_menu_accessories<?php  echo  $cat_s_t['id'] ?>">


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
            <?php  }  ?>


            <?php  if (!empty($category_site_acc_camera)) { ?>
                <div class="card">
                    <div class="card-header  accordion_row" id="headingOne_main_camera_acc">

                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <a  class="link_acc" href="<?php echo url ?>/camera/list_view"    >    <?php echo $this->langSite('camera')?> </a>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_camera_acc" aria-expanded="true" aria-controls="collapseOne_main_camera_acc">
                                    <i class="fa fa-angle-down"> </i>
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
                                                        <button value="0" onclick="get_sub_camera(this,<?php  echo $cat_s_t['id'] ?>)"  class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="true" aria-controls="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>">
                                                            <i class="fa fa-angle-down"> </i>
                                                        </button>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div id="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" class="collapse " aria-labelledby="headingOne_main_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordion_camera">
                                            <div class="card-body nested_accordion body_menu_camera<?php  echo  $cat_s_t['id'] ?>">


                                            </div>
                                        </div>
                                    </div>
                                <?php  }  ?>
                            </div>


                        </div>
                    </div>
                </div>
            <?php  }  ?>


            <?php  if (!empty($category_site_acc_computer)) { ?>
                <div class="card">
                    <div class="card-header  accordion_row" id="headingOne_main_computer_acc">

                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <a  class="link_acc" href="<?php echo url ?>/computer/list_view"     >    <?php echo $this->langSite('computer')?> </a>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_computer_acc" aria-expanded="true" aria-controls="collapseOne_main_computer_acc">
                                    <i class="fa fa-angle-down"> </i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="collapseOne_main_computer_acc" class="collapse " aria-labelledby="headingOne_main_computer_acc" data-parent="#accordion">
                        <div class="card-body nested_accordion">

                            <div id="accordion_computer">



                                <?php  foreach ($category_site_acc_computer as $key => $cat_s_t) { ?>
                                    <div class="card">
                                        <div class="card-header  accordion_row" id="headingOne_main_<?php  echo  $cat_s_t['id'] ?>">

                                            <div class="row justify-content-between align-items-center">
                                                <div class="col-auto">
                                                    <a class="link_acc" href="<?php  echo url ?>/computer/list_view/<?php echo $cat_s_t['id']?>">  <?php  echo  $cat_s_t['title'] ?>   </a>
                                                </div>
                                                <?php  if ($computer->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                    <div class="col-auto">
                                                        <button  value="0" onclick="get_sub_computer(this,<?php  echo $cat_s_t['id'] ?>)"  class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="true" aria-controls="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>">
                                                            <i class="fa fa-angle-down"> </i>
                                                        </button>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div id="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" class="collapse " aria-labelledby="headingOne_main_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordion_computer">
                                            <div class="card-body nested_accordion body_menu_computer<?php  echo  $cat_s_t['id'] ?>">

                                            </div>
                                        </div>
                                    </div>
                                <?php  }  ?>
                             <div class="card-header  accordion_row">
                                     <a class="link_acc"  href="<?php echo url ?>/computer_assembly">  <?php echo $this->langSite('computer_assembly') ?>   </a>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            <?php  }  ?>


            <?php  if (!empty($category_site_acc_printing_supplies)) { ?>
                <div class="card">
                    <div class="card-header  accordion_row" id="headingOne_main_printing_supplies_acc">

                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <a   class="link_acc" href="<?php echo url ?>/printing_supplies/list_view"      >    <?php echo $this->langSite('printing_supplies')?> </a>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_printing_supplies_acc" aria-expanded="true" aria-controls="collapseOne_main_printing_supplies_acc">
                                    <i class="fa fa-angle-down"> </i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="collapseOne_main_printing_supplies_acc" class="collapse " aria-labelledby="headingOne_main_printing_supplies_acc" data-parent="#accordion">
                        <div class="card-body nested_accordion">

                            <div id="accordion_printing_supplies">



                                <?php  foreach ($category_site_acc_printing_supplies as $key => $cat_s_t) { ?>
                                    <div class="card">
                                        <div class="card-header  accordion_row" id="headingOne_main_<?php  echo  $cat_s_t['id'] ?>">

                                            <div class="row justify-content-between align-items-center">
                                                <div class="col-auto">
                                                    <a class="link_acc" href="<?php  echo url ?>/printing_supplies/list_view/<?php echo $cat_s_t['id']?>">  <?php  echo  $cat_s_t['title'] ?>   </a>
                                                </div>
                                                <?php  if ($printing_supplies->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                    <div class="col-auto">
                                                        <button   value="0" onclick="get_sub_printing_supplies(this,<?php  echo $cat_s_t['id'] ?>)"  class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="true" aria-controls="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>">
                                                            <i class="fa fa-angle-down"> </i>
                                                        </button>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div id="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" class="collapse " aria-labelledby="headingOne_main_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordion_printing_supplies">
                                            <div class="card-body nested_accordion body_menu_printing_supplies<?php  echo  $cat_s_t['id'] ?>">

                                            </div>
                                        </div>
                                    </div>
                                <?php  }  ?>
                            </div>


                        </div>
                    </div>
                </div>
            <?php  }  ?>



            <?php  if (!empty($category_site_acc_games)) { ?>
                <div class="card">
                    <div class="card-header  accordion_row" id="headingOne_main_games_acc">

                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <a  class="link_acc" href="<?php echo url ?>/games/list_view"    >    <?php echo $this->langSite('games')?> </a>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_games_acc" aria-expanded="true" aria-controls="collapseOne_main_games_acc">
                                    <i class="fa fa-angle-down"> </i>
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
                                                        <button  value="0" onclick="get_sub_games(this,<?php  echo $cat_s_t['id'] ?>)"  class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="true" aria-controls="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>">
                                                            <i class="fa fa-angle-down"> </i>
                                                        </button>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div id="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" class="collapse " aria-labelledby="headingOne_main_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordion_games">
                                            <div class="card-body nested_accordion   body_menu_games<?php  echo  $cat_s_t['id'] ?>">

                                            </div>
                                        </div>
                                    </div>
                                <?php  }  ?>
                            </div>


                        </div>
                    </div>
                </div>
            <?php  }  ?>

            <?php  if (!empty($category_site_acc_network)) { ?>
                <div class="card">
                    <div class="card-header  accordion_row" id="headingOne_main_network_acc">

                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <a   class="link_acc" href="<?php echo url ?>/network/list_view"   >    <?php echo $this->langSite('network')?> </a>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_network_acc" aria-expanded="true" aria-controls="collapseOne_main_network_acc">
                                    <i class="fa fa-angle-down"> </i>
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
                                                        <button  value="0" onclick="get_sub_network(this,<?php  echo $cat_s_t['id'] ?>)"  class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="true" aria-controls="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>">
                                                            <i class="fa fa-angle-down"> </i>
                                                        </button>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div id="collapseOne_main_<?php  echo  $cat_s_t['id'] ?>" class="collapse " aria-labelledby="headingOne_main_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordion_network">
                                            <div class="card-body nested_accordion  body_menu_network<?php  echo  $cat_s_t['id'] ?>">

                                            </div>
                                        </div>
                                    </div>
                                <?php  }  ?>


                            </div>


                        </div>
                    </div>
                </div>
            <?php  }  ?>



            <?php if (!empty($categorypages)) {   ?>
                <div class="card">
                    <div class="card-header  accordion_row" id="headingOne_main_pages_acc">

                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <a class="link_acc" href="#" data-toggle="collapse" data-target="#collapseOne_main_pages_acc" aria-expanded="true" aria-controls="collapseOne_main_pages_acc">    <?php echo $this->langSite('pages')?> </a>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-primary icon_accordion_sort" data-toggle="collapse" data-target="#collapseOne_main_pages_acc" aria-expanded="true" aria-controls="collapseOne_main_pages_acc">
                                    <i class="fa fa-angle-down"> </i>
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


            <div class="card">
                <div class="card-header  accordion_row" id="headingOne_main_home">

                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <a class="link_acc" href="<?php  echo url ?>/offers"> <?php echo $this->langSite('offers')?>   </a>
                        </div>

                    </div>
                </div>

            </div>
            <div class="card">
                <div class="card-header  accordion_row"  >

                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <a class="link_acc" href="<?php  echo url ?>/dhuquk_ahlaa" >    <?php echo $this->langSite('dhuquk_ahlaa')?> </a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header  accordion_row"  >

                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <a class="link_acc" href="<?php  echo url ?>/alamani_art" >    <?php echo $this->langSite('alamani_art')?> </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>


    </div>
</div>
<script>

    $('.navbar-toggler.sm_btn_menu').on('click',function () {
        if ($(".navbar-toggler.sm_btn_menu").hasClass('collapsed'))
        {
            window.scroll({
                top: 0,
                behavior: 'smooth'
            });

        }
    });

</script>

<style>
    div#header_fixed
    {
        position: relative;
        top: 0;
        background: white;
    }
    .under_fixed_header
    {
        display: none;
    }
    .accordion_row button, .accordion_row button:hover, .accordion_row button:focus {
        background: #283581;
        border: 1px solid #283581;
        font-size: 23px;
        padding: 0;
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
        var scroll_pos = 1;
        var  xscroll=1;
        $(document).scroll(function() {

            scroll_pos = $(this).scrollTop();
            console.log(scroll_pos)

            if (scroll_pos > 0) {

                $('.header_fixed').css('top','0');
                $('.header_fixed').css('position','fixed');
                $('.under_fixed_header').css('display','block');
                if ($(window).width() <  993) {
                    $('.cartDrop_small_fixed').show();
                    $('.sm_btn_menu').css('left', '49px');
                }
                xscroll=0;
            }else if (scroll_pos===0 && xscroll===0)
            {

                $('.header_fixed').css('top','70px')
                if ($(window).width() <  993) {
                    $('.cartDrop_small_fixed').hide();
                    $('.sm_btn_menu').css('left', '0');
                }
            }
        });
    });

</script>


<script>


    function logoutFacebook() {
        sessionStorage.clear();
        $.get( "<?php echo url ?>/register/logout", function( data ) {
            if (data) {
                conform_logOut();
            }
        });
    }

    function conform_logOut() {

        $.get( "<?php echo url ?>/register/logout", function( data ) {
            if (data) {
                window.location="<?php   echo url ?>/enter";
            }
        });
    }




</script>



<div class="bar_category">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12  d-none d-lg-block" >
                <div class="categoryAndOffers">
                    اقسام العروض
                </div>
            </div>
            <div class="col-lg-9 col-md-12  col-sm-12 ">

                <form action="<?php  echo url ?>/search/index" id="FormSearchLive" method="get">
                    <div class="row">
                        <div class="col-lg-3 col-md-4  col-sm-4 col-5 HideCatMobile" style="padding-left: 0">
                            <select onchange="smartSearch()" name="cat" id="catForSearch" class="form-control form-control dropdownCatg"  style=' border-radius: 0 15px 15px 0;' >
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

                                <?php  foreach ($category_computer  as $cat_m) {  ?>
                                    <option value="<?php  echo $cat_m['idx']?>">   <?php  echo $cat_m['title']?>   </option>
                                <?php } ?>

                                <?php  foreach ($category_printing_supplies as $cat_m) {  ?>
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

                          span.cat_search {
                                background: red;
                                color: #fff;
                                padding: 0 7px;
                                border-radius: 15px;
                                margin-right:35px;
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


                                <i   class="fa fa-search"></i>

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
        background: #fff;
        width: 100%;
        color: #283581;
        border-radius: 15px 0 0 15px;
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
        height: 70px;
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

    #qrcode img
    {
        display: initial !important;
    }

    .logo_on_qr
    {
        text-align: center;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .logo_on_qr .img_logo_qr
    {
        position: absolute;
        background: white;
        padding-right: 5px;
        width: 75px;
    }

</style>





<div class="modal  " id="add_phone" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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


<div class="modal  " id="exampleModal_bay_now" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <div class="test1n">   شكرا لتسوقك من شركة الاماني .  توجه الى اقرب موظف مبيعات عليك كي يرشدك لغرض اجراء المحاسبة واستلام البضاعة .   </div>
            </div>


            <br>
            <div class="progress" style="height: 2px;">
                <div  class="progress-bar progress_inter" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <div class="modal-footer">
                <a href="<?php echo url ?>"   class="btn close_pop_order" >موافق</a>
            </div>
        </div>
    </div>
</div>

<div class="modal  " id="exampleModal_onlyCards" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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


<div class="modal  " id="exampleModal_empty_car" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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


    .progress_cart_background
    {
        background: #c0a84d !important;
        height: 6px;

    }
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
        $.get('<?php echo url  ?>/register/empty_car', function(data){
            console.log(data)
            if(data)
            {
                $('.button_buy').css('display','none');
                $('.empty_car').css('display','block');
                $('.sum_all_price_cart').remove();
                $('.item_cat').empty();
                $('.count_item_cartShow').html(0);
                $("#exampleModal_empty_car").modal("hide")
            }else
            {
                alert('لا يمكن افراغ السلة اعد المحاولة')
            }

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


    function delete_item_row(id,id_c,id_offer) {

        $.get('<?php echo url  ?>/register/dlt_item/'+id+'/'+id_c+'/'+id_offer, function(date){

            if (date==='true')
            {
                sumC=$('.count_item.count_item_cartShow').last().text();
                itemN=$('.number_item_buy_'+id_c).last().val();
                num_edit=Number(sumC)-Number(itemN)
                $('.count_item.count_item_cartShow').text(num_edit);

                $(".delete_item_row_"+id_c).remove();

                $( ".item_cat" ).html("<div style='text-align:center'><img  style='width: 40px'  src='<?php echo $this->static_file_site ?>/image/site/loding.gif' ></div>");

                $.get( "<?php echo url .'/'.$this->folder ?>/cart", function( data ) {
                    $( ".item_cat" ).html( data );

                });

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


    $(document).ready(function() {
        $(".cart_shop_active").click(function(){

            $('.activeAfterCloseWebCam').click();

            $( ".item_cat" ).html("<div style='text-align:center'><img  style='width: 40px'  src='<?php echo $this->static_file_site ?>/image/site/loding.gif' ></div>");

            $.get( "<?php echo url .'/'.$this->folder ?>/cart", function( data ) {
                $( ".item_cat" ).html( data );

            });
        });
    });

    localStorage.removeItem('confirmation_order');
    function  bay_now()
    {

        if (localStorage.getItem("confirmation_order"))
        {
            $('.cart_shop_active ').click()
            var id_user_screen=localStorage.getItem("screen_user_id");

            if($('.item_cat .q_0').length > 0)
            {
                alert('يرجى حذف المواد النافذة من السله ')
            }else {

                $('.loading_icon').css('display','block');
                $('.progress_cart').css('display','block');
                $('.send_order_btn').attr('disabled','disabled');

                setTimeout(function () {
                    $('.progress_cart .progress .progress-bar').css('width','50%');

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo url  ?>/register/buy?id_user_screen='+id_user_screen,
                        cache: false,
                        success: function(result) {

                            if (result==='0')
                            {
                                $('#exampleModal_bay_now').modal({
                                    backdrop: 'static',
                                    keyboard: false
                                });

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

                                localStorage.removeItem('confirmation_order');

                                $('.progress_cart .progress .progress-bar').css('width','75%');
                                setTimeout(function () {
                                    $('.progress_cart .progress .progress-bar').css('width','100%');
                                },1000);
                                setTimeout(function () {


                                    $('#exampleModal_bay_now').modal({
                                        backdrop: 'static',
                                        keyboard: false
                                    });


                                    var timeleft = 100;
                                    var downloadTimer = setInterval(function(){
                                        if(timeleft <= 0){
                                            clearInterval(downloadTimer);
                                        }
                                        $('.progress_inter').css('width',100 - timeleft +'%');
                                        timeleft -= 1;
                                        if (timeleft===0)
                                        {
                                            window.location="<?php echo url ?>"
                                        }
                                    }, 200);


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
        }else
        {

            convertAcount =1;

            localStorage.setItem("confirmation_order",'confirmation_qr');

            $('#exampleModal_qr_logout').modal({
                backdrop: 'static',
                keyboard: false
            });
            newCountLogout ()
            select_qr_input()

        }



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



<style>
    .item_cat {

        position: relative;
        padding-bottom: 38px;
    }

    .sum_all_price_cart {
        position: fixed;
        bottom:43px;
        background: #c0a84d;
        color: #000000;
        padding: 5px 7px;
        left: 0;
        right: 0;
        font-size: 15px;
        width: 100%;
    }
</style>




<div class="modal  " id="exampleModalDirect" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">  تأكيد الطلب باستخدام   </h5>

            </div>
            <div class="modal-body">


                <ul class="nav nav-tabs tabTypeSendOrder" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active_qr_g"   id="home-tab" data-toggle="tab"  onclick="openWebCam()" href="#home" role="tab" aria-controls="home" aria-selected="true">QR</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab"  onclick="closeWebCam()" href="#profile" role="tab" aria-controls="profile" aria-selected="false">رقم الهاتف</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link active activeAfterCloseWebCam"  id="contact-tab"  onclick="closeWebCam()" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">   رقم الهاتف   </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <!-- home -->
                    <div class="tab-pane  " id="home" role="tabpanel" aria-labelledby="home-tab">

                        <form id="readqrfromdevice" method="get" action="< ?php  echo url ?>/customers/byqr">
                            <input name="qr"    inputmode="none"    style="width: 0;height: 0;padding: 0;margin: 0;box-shadow: unset;outline: unset;border: 0"     autocomplete="off"  id="id_readqr" class="form-control" required>
                        </form>
                        <div class="resultErrorcam"></div>
                        <video onclick="select_readqr()" id="webcam-preview"></video>


                        <style>


                            #webcam-preview
                            {
                                width: 100% !important;
                                height: 400px !important;
                                border-radius: 5px;
                                background-image: url(<?php echo $this->static_file_site ?>/image/site/qr.png);
                                background-position: center;
                                background-repeat: no-repeat;
                                background-size: 215px;
                            }
                            .resultErrorcam
                            {
                                color: red;
                            }


                        </style>

                        <script>

                            const codeReader = new ZXing.BrowserQRCodeReader();


                            function closeWebCam() {
                                codeReader.reset();
                                codeReader.stopContinuousDecode();

                            }


                            function select_readqr() {
                                $('#id_readqr').select();
                            }

                            function openWebCam() {



                                codeReader.decodeFromVideoDevice(null, 'webcam-preview', (result, err) => {
                                    if (result) {

                                        var audio = new Audio('<?php echo $this->static_file_site ?>/camera/qr.mp3');
                                        audio.play();

                                        $.get( "<?php  echo url ?>/customers/byqr",{qr:result.text}, function( data ) {
                                            if (data === '1') {
                                                // alert("تم ارسال الطلب  للمحاسبة والتجهيز");
                                                reSet();
                                                $('#exampleModalDirect').modal('hide')
                                                $('.resultErrorcam').empty();

                                                codeReader.reset();
                                                codeReader.stopContinuousDecode();
                                            } else if (data === '2') {

                                                $('#exampleModalDirect').modal('hide')
                                                $('.resultErrorcam').empty();

                                                // alert("تم ارسال الطلب الى  المحاسبة , يرجى تجهيز الزبون بعد المحاسبة");
                                                codeReader.reset();
                                                codeReader.stopContinuousDecode();
                                            } else if (data === '3') {
                                                window.location = "<?php echo url ?>/direct/direct3_account";
                                                $('.resultErrorcam').empty();

                                                codeReader.reset();
                                                codeReader.stopContinuousDecode();
                                            } else {

                                                $('.resultErrorcam').html('رمز ال QR غير صحيح');
                                            }

                                        });

                                    }

                                    if (err) {

                                        if (err instanceof ZXing.NotFoundException) {
                                            console.log('No QR code found.')
                                            $('.resultErrorcam').html('لا يوجد رمز QR امام الكامرا ');

                                        }

                                        if (err instanceof ZXing.ChecksumException) {
                                            $('.resultErrorcam').html('تم العثور على رمز QR ، لكن قيمة قراءته لم تكن صالحة.');

                                        }

                                        if (err instanceof ZXing.FormatException) {

                                            $('.resultErrorcam').html('تم العثور على رمز QR ، لكنه كان بتنسيق غير صالح.');

                                        }
                                    }
                                })

                                setTimeout(function () {
                                    $('#id_readqr').select();

                                },10);


                            }




                            $("#readqrfromdevice").submit(function(e) {

                                e.preventDefault(); // avoid to execute the actual submit of the form.

                                var form = $(this);
                                var actionUrl = form.attr('action');

                                $.ajax({
                                    type: "GET",
                                    url: actionUrl,
                                    data: form.serialize(), // serializes the form's elements.
                                    success: function(data)
                                    {


                                        if (data === '1') {
                                            // alert("تم ارسال الطلب  للمحاسبة والتجهيز");
                                            reSet();
                                            $('#exampleModalDirect').modal('hide')
                                            $('.resultErrorcam').empty();
                                            setTimeout(function () {
                                                codeReader.reset();
                                                codeReader.stopContinuousDecode();
                                            },500)

                                        } else if (data === '2') {

                                            $('#exampleModalDirect').modal('hide')
                                            $('.resultErrorcam').empty();

                                            // alert("تم ارسال الطلب الى  المحاسبة , يرجى تجهيز الزبون بعد المحاسبة");
                                            setTimeout(function () {
                                                codeReader.reset();
                                                codeReader.stopContinuousDecode();
                                            },500)
                                        } else if (data === '3') {
                                            window.location = "<?php echo url ?>/direct/direct3_account";
                                            $('.resultErrorcam').empty();

                                            setTimeout(function () {
                                                codeReader.reset();
                                                codeReader.stopContinuousDecode();
                                            },500)
                                        } else {

                                            $('.resultErrorcam').html('رمز ال QR غير صحيح');
                                        }



                                    }
                                });

                            });





                        </script>


                    </div>
                    <!-- home-->
                    <!-- profile -->
                    <!-- <div class="tab-pane  " id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <form id="byphone" action="<?php  echo url ?>/customers/byphone" method="post">
                            <br>

                            <div class="form-group">
                                <label for="exampleInputphone1"> رقم هاتف مسجل  </label>


                                <div class="input-group mb-2">
                                    <input autocomplete="off"  name="phone"  type="number"   class="form-control" required id="exampleInputphone1" aria-describedby="phoneHelp"  >
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" id="count_phone_1">0</div>
                                    </div>
                                </div>
                                <script>
                                    $("#exampleInputphone1").on("input", function() {
                                        $("#count_phone_1").text(this.value.length);
                                    });
                                </script>
                            </div>



                            <hr>
                            <div style="text-align: center">
                                <button id="byphone_btn_send_order"  type="submit" class="btn btn-primary">  موافق  </button>
                            </div>
                        </form>

                    </div> -->
                    <!-- profile -->
                    <div class="tab-pane   show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <form id="new_customers" action="<?php  echo url ?>/customers/new_customers" method="post">
                            <br>

                            <div class="custom-control custom-radio custom-control-inline mb-4" style="margin-top:30px;" >
                                <input type="checkbox"  name="without_number" value="1" class="custom-control-input " id="without_number">

                                <label class="custom-control-label" for="without_number" > بدون رقم</label>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputphone2"> رقم هاتف    </label>

                                <div class="input-group mb-2">
                                    <input  autocomplete="off"   name="phone" type="number" minlength="11" maxlength="11" class="form-control" id="exampleInputphone2" required aria-describedby="phoneHelp"  >
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" id="count_phone_2">0</div>
                                    </div>
                                </div>


                                <script>
                                    $("#exampleInputphone2").on("input", function() {
                                        $("#count_phone_2").text(this.value.length);
                                    });

                                    checkBox = document.getElementById('without_number').addEventListener('click', event => {
                                        if(event.target.checked) {
                                            $('#exampleInputphone2').val('00000000000');
                                            $('#exampleInputphone2').attr("readonly", true);
                                        }
                                        if(event.target.checked == false ) {
                                            $('#exampleInputphone2').val('');
                                            $('#exampleInputphone2').attr("readonly", false);
                                        }
                                    });


                                    $( "#exampleInputphone2" ).keyup(function() {

                                        var phone= $('#exampleInputphone2').val();
                                        if((phone.length == 11) && (phone !='00000000000') ){
                                            $.get( "<?php echo url ?>/customers/get_customer_name_by_phone/"+phone, function(data) {
                                                $("#exampleInputname1").val(data);
                                            });
                                        }
                                    });

                                    $( "#input-group-text" ).click(function() {
                                        console.log('m');
                                    });

                                </script>

                            </div>

                            <!-- <div class="form-group">
                                <label for="exampleInputname1">  الاسم  </label>
                                <input  autocomplete="off"   name="name" type="text"  class="form-control" id="exampleInputname1" required  aria-describedby="nameHelp"  >
                            </div> -->


                            <div class="input-group mb-3">
                                <input name="name" type="text"  class="form-control" id="exampleInputname1" required  aria-describedby="nameHelp" aria-label="Text input with checkbox" autocomplete="off">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Button</button>
                                </div>
                            </div>

                            <hr>
                            <div style="text-align: center">
                                <button  type="submit" id="new_customers_btn_send_order" class="btn btn-primary">  موافق  </button>
                            </div>
                        </form>


                    </div>
                </div>



            </div>

        </div>
    </div>
</div>

<style>

    .camera_open
    {
        width: 100%;
        height: 250px;
        background: #000000;
    }

</style>


<script>

    $("#byphone").submit(function(e) {



        $('#byphone_btn_send_order').attr('disabled','disabled').html(
            ` <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
             <span >جاري ارسال الطلب ...</span>`
        );

        e.preventDefault();
        x=$("#exampleInputphone1").val();
        if (x.toString().length === 11) {
            var form = $(this);
            var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize() + '&submit=submit',
                success: function (data) {

                    $('#byphone_btn_send_order').removeAttr('disabled').html(
                        `موافق`
                    );

                    if (data === '1') {

                        $("#exampleInputphone1").val('');


                        alert("تم ارسال الطلب  للمحاسبة والتجهيز");
                        reSet();
                        $('#exampleModalDirect').modal('hide')
                    } else if (data === '2') {
                        $("#exampleInputphone1").val('');
                        $('#exampleModalDirect').modal('hide')

                        alert("تم ارسال الطلب الى  المحاسبة , يرجى تجهيز الزبون بعد المحاسبة");

                    } else if (data === '3') {
                        $("#exampleInputphone1").val('');
                        window.location = "<?php echo url ?>/direct/direct3_account";

                    } else {
                        alert('الرقم المدخل غير مسجل مسبقا')
                    }
                }
            });

        }else
        {
            $('#byphone_btn_send_order').removeAttr('disabled').html(
                `موافق`
            );

            alert("رقم الهاتف يجب ان يكون 11 رقم")
        }
    });


    $("#new_customers").submit(function(e) {


        $('#new_customers_btn_send_order').attr('disabled','disabled').html(
            ` <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
             <span>جاري ارسال الطلب ...</span>`
        );

        e.preventDefault();
        x=$("#exampleInputphone2").val();
        if (x.toString().length === 11) {
            var form = $(this);
            var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize()+'&submit=submit',
                success: function(data)
                {

                    console.log(data)

                    $('#new_customers_btn_send_order').removeAttr('disabled').html(
                        `موافق`
                    );

                    if(data==='1')
                    {
                        $("#exampleInputname1").val('')
                        $("#exampleInputphone2").val('')

                        alert("تم ارسال الطلب  للمحاسبة والتجهيز");
                        reSet();
                        $('#exampleModalDirect').modal('hide')
                    }else if(data==='2'){

                        $("#exampleInputname1").val('')
                        $("#exampleInputphone2").val('')

                        $('#exampleModalDirect').modal('hide')

                        alert("تم ارسال الطلب الى  المحاسبة , يرجى تجهيز الزبون بعد المحاسبة");
                    }else if(data==='3')
                    {
                        $("#exampleInputname1").val('')
                        $("#exampleInputphone2").val('')

                        window.location="<?php echo  url ?>/direct/direct3_account";

                    }else
                    {
                        alert('لا يمكن انشاء طلب بحساب نوع admin')
                    }
                }
            });

        }else
        {



            $('#new_customers_btn_send_order').removeAttr('disabled').html(
                `موافق`
            );

            alert("رقم الهاتف يجب ان يكون 11 رقم")
        }
    });

    function reSet() {
        $('.loading_icon').css('display','none');
        $('.button_buy').css('display','none');
        $('.empty_car').css('display','block');
        $('.sum_all_price_cart').remove();
        $('.item_cat').empty();
        $('.count_item_cartShow').html(0);
        $('.progress_cart').css('display','none');

    }

    <?php  if($overBoxMoney == 1) { ?>
    console.log('fff')
    // $( document ).ready(function() {
    //     $('#overBoxMoney').modal({
    //         backdrop: 'static',
    //         keyboard: false
    //     });
    // })

    <?php  } ?>



</script>

<!-- Modal -->
<div class="modal  " style="background: #00000052;z-index: 15000000000000000000000" id="overBoxMoney" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">  تنبية  </h5>

            </div>
            <div class="modal-body">
                المبلغ الذي معك تجاوز حجم الصندوق يرجى التوجة الى مدير النظام لزيادة حجم الصندوق او دفع المبلغ الذي معك الى المحاسب.
            </div>
            <div class="modal-footer">
                <button type="button" onclick="hiddeModelDirect3()" class="btn btn-warning" data-dismiss="modal">  هل تريد حذف بعض المواد من السلة ؟</button>
            </div>
        </div>
    </div>
</div>


<?php  if (isset($_SESSION['direct']) ) { ?>
    <?php  if ($_SESSION['direct'] ==3 ) {   ?>


        <script>


            $('#overBoxMoney').on('hidden.bs.modal', function () {
                $("#exampleModalDirect").modal('hide');
            });

            exampleModalDirectAxcol();
            function exampleModalDirectAxcol() {



                $.get("<?php  echo url ?>/log_accountant/check_amount", function (data) {


                    if(data==='false')
                    {

                        $("#exampleModalDirect").modal('hide');

                        $('#overBoxMoney').modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                    }
                    else
                    {
                        $("#overBoxMoney").modal('hide');

                    }

                });

            }
            function hiddeModelDirect3() {
                $("#exampleModalDirect").modal('hide');

            }




        </script>

    <?php  }  ?>
<?php  }  ?>





<!-- Modal -->
<div class="modal fade" id="note_order_cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">  كتابة ملاحظة  </h5>
            </div>
            <div class="modal-body">
                <form id="write_note_customer" action="<?php echo url .'/'.$this->folder ?>/note_cart_note" method="post">

                    <input type="hidden" name="id_member_r" id="row_id_member_r">
                    <input  type="hidden"  name="id_item" id="row_id_item">
                    <input  type="hidden"  name="code" id="row_code">
                    <input  type="hidden"  name="table" id="row_table">
                    <input  type="hidden"  name="name_color" id="row_name_color">

                    <div class="form-group">
                        <label for="row_edit_note">ملاحظة</label>
                        <textarea  name="note" class="form-control" id="row_edit_note"  rows="3"  ></textarea>
                    </div>
                    <div class="modal-footer">
                        <button  type="button" class="btn btn-danger" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<script>

    function note_order(id_member_r,code,id_item,table,name_color)
    {

        $.get( "<?php echo url .'/'.$this->folder ?>/row_cart",
            {
                id_member_r:id_member_r,
                code:code,
                id_item:id_item,
                table:table,
                name_color:name_color

            }
            , function( data ) {
                if (data)
                {


                    response=JSON.parse(data);

                    $('#row_id_member_r').val(response.id_member_r);
                    $('#row_id_item').val(response.id_item);
                    $('#row_code').val(response.code);
                    $('#row_table').val(response.table);
                    $('#row_name_color').val(response.name_color);
                    $('#row_edit_note').val(response.note);


                    $('#note_order_cart').modal('show')

                }else
                {
                    alert('ملاحظة خاصة في الزبون')
                }
            });


    }

    $("#write_note_customer").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {
                if (data)
                {
                    alert('تم اضافة الملاحظة.');
                    $('#note_order_cart').modal('hide')

                }else {
                    alert('فشل كتابة الملاحظة');
                }

                $(".cart_shop_active").click();

            }
        });


    });
</script>

<!--get menu-->
<script>

    function get_sub_mobile(e,id)
    {
        if ($(e).val() === '0')
        {
            $(".body_menu_mobile"+id ).html(`<div class="loading_sub_menu"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
            $.get( "<?php  echo url ?>/mobile/listSubCategoryMenu_acc/"+id, function( data ) {
                if (data)
                {
                    $( ".body_menu_mobile"+id).html( data );
                    $(e).val(1)
                }
            });
        }

    }
    function get_sub_games(e,id)
    {
        if ($(e).val() === '0')
        {
            $(".body_menu_games"+id ).html(`<div class="loading_sub_menu"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
            $.get( "<?php  echo url ?>/games/listSubCategoryMenu_acc/"+id, function( data ) {
                if (data)
                {
                    $( ".body_menu_games"+id).html( data );
                    $(e).val(1)
                }
            });
        }

    }
    function get_sub_camera(e,id)
    {
        if ($(e).val() === '0')
        {
            $(".body_menu_camera"+id ).html(`<div class="loading_sub_menu"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
            $.get( "<?php  echo url ?>/camera/listSubCategoryMenu_acc/"+id, function( data ) {
                if (data)
                {
                    $( ".body_menu_camera"+id).html( data );
                    $(e).val(1)
                }
            });
        }

    }

    function get_sub_network(e,id)
    {
        if ($(e).val() === '0')
        {
            $(".body_menu_network"+id ).html(`<div class="loading_sub_menu"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
            $.get( "<?php  echo url ?>/network/listSubCategoryMenu_acc/"+id, function( data ) {
                if (data)
                {
                    $( ".body_menu_network"+id).html( data );
                    $(e).val(1)
                }
            });
        }

    }

    function get_sub_computer(e,id)
    {
        if ($(e).val() === '0')
        {
            $(".body_menu_computer"+id ).html(`<div class="loading_sub_menu"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
            $.get( "<?php  echo url ?>/computer/listSubCategoryMenu_acc/"+id, function( data ) {
                if (data)
                {
                    $( ".body_menu_computer"+id).html( data );
                    $(e).val(1)
                }
            });
        }

    }

    function get_sub_printing_supplies(e,id)
    {
        if ($(e).val() === '0')
        {
            $(".body_menu_printing_supplies"+id ).html(`<div class="loading_sub_menu"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
            $.get( "<?php  echo url ?>/printing_supplies/listSubCategoryMenu_acc/"+id, function( data ) {
                if (data)
                {
                    $( ".body_menu_printing_supplies"+id).html( data );
                    $(e).val(1)
                }
            });
        }

    }


    function get_sub_accessories(e,id)
    {
        if ($(e).val() === '0')
        {
            $(".body_menu_accessories"+id).html(`<div class="loading_sub_menu"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
            $.get( "<?php  echo url ?>/accessories/listSubCategoryMenu_acc/"+id, function( data ) {
                if (data)
                {
                    $( ".body_menu_accessories"+id).html( data );
                    $(e).val(1)
                }
            });
        }

    }

    $(".mobile_menu_hover").on("mouseover", function () {
        var ids=$(this).data('ids')
        var sub=$(this).data('sub')
        if (sub === 0){
            $(this).data('sub','1')
            $(".mobile_nav_hover"+ids ).html(`<div class="loading_sub_menu"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
            $.get( "<?php  echo url ?>/mobile/listSubCategoryMenu/"+ids, function( data ) {
                if (data)
                {
                    $(".mobile_nav_hover"+ids).html( data );
                }
            });

        }

    });


    $(".accessories_menu_hover").on("mouseover", function () {
        var ids=$(this).data('ids')
        var sub=$(this).data('sub')
        if (sub === 0){
            $(this).data('sub','1')
            $(".accessories_nav_hover"+ids ).html(`<div class="loading_sub_menu"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
            $.get( "<?php  echo url ?>/accessories/listSubCategoryMenu/"+ids, function( data ) {
                if (data)
                {
                    $(".accessories_nav_hover"+ids).html( data );
                }
            });

        }

    });



    $(".games_menu_hover").on("mouseover", function () {
        var ids=$(this).data('ids')
        var sub=$(this).data('sub')
        if (sub === 0){
            $(this).data('sub','1')
            $(".games_nav_hover"+ids ).html(`<div class="loading_sub_menu"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
            $.get( "<?php  echo url ?>/games/listSubCategoryMenu/"+ids, function( data ) {
                if (data)
                {
                    $(".games_nav_hover"+ids).html( data );
                }
            });

        }

    });


</script>


<?php  if($this->isDirect()){  ?>
<div class="container"  id="container_print">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-7 col-sm-7 col-7">
            <div class="print_qr_customer">


                <div  class="name_owner_qr_print name_customer_print"> </div>

                <div class="logo_on_qr_print">
                    <div id="qrcode_print"></div>
                    <img class="img_logo_qr_print" src="<?php  echo  $this->static_file_site ?>/image/site/logo_notif.png">
                </div>

                <div class="name_company_print">
                    شركة الاماني
                </div>
                <div class="noe_print">
                    عزيزي الزبون يمكنك استخدام رمز QR الخاص بك في المره القادمة لتسجيل الدخول لحسابك وتصفح المنتاجات وطلبها من خلال الشاشة.
                </div>

            </div>
        </div>
    </div>
</div>

<script>





    function get_qr_custom() {

        $('.name_owner_qr').empty()
        var phone=$('#phone_qr').val()
        if (phone)
        {

            $.get( "<?php echo url  ?>/customers/get_uid",{phone:phone}, function( data ) {
                if (data)
                {

                    var  response=JSON.parse(data)


                    $('.name_owner_qr').html(response.name)
                    $('.hide_c_phone').hide();
                    $('.logo_on_qr').show();
                    $('#qrcode').empty();


                    var qrcode = new QRCode("qrcode");
                    qrcode.makeCode(response.uid);
                    $('#qrcode_print').empty();
                    $('.name_owner_qr_print').html(response.name)
                    var qrcode_print = new QRCode("qrcode_print");
                    qrcode_print.makeCode(response.uid);
                    $('#print_cust_qr').show();

                }else {
                    alert('رقم الهاتف غير مسجل!')

                }

            });

        }else
        {
            alert('رقم الهاتف غير مسجل!')
        }

    }

    function print_qr_custom() {
        window.print();

    }

    function set_model_qr() {
        $('#print_cust_qr').hide();
        $('.hide_c_phone').show();
        $('.logo_on_qr').hide();
        $('.name_owner_qr').empty();
        $('#phone_qr').select().val('')
    }

</script>
<?php } ?>

<script>


    function active_qr() {

        $('.active_qr_g').click();
    }

</script>

