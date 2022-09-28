<!DOCTYPE html>
<meta property="og:type" content="website"/>
<html dir="<?php echo $this->dirSite ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0, maximum-scale=0" />
    <!--    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=off" />-->
    <script>
        $(document).ready(function(){
            $('meta[name="viewport"]').prop('content', 'width=1440');
        });
    </script>
    <title><?php echo $this->title;?></title>


    <!--jquery -->
    <script src="<?php echo $this->static_file_site ?>/js/jquery.min.js"></script>

    <!--bootstrap-->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/bootstrap/css/bootstrap.min.css" >
    <script src="<?php echo $this->static_file_site ?>/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo $this->static_file_site ?>/bootstrap/js/bootstrap.min.js"  ></script>


    <!--custom css -->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/css/default.css"/>




    <!--custom js-->
    <script src="<?php echo $this->static_file_site ?>/js/custom.js"></script>


    <!--bootstrap-toggle-->
    <link href="<?php echo $this->static_file_site ?>/bootstrap/toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="<?php echo $this->static_file_site ?>/bootstrap/toggle/js/bootstrap-toggle.min.js"></script>

    <!--upload file-->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/dist/jquerysctipttop.css"/>
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/dist/font-awesome.min.css"/>
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/dist/bootstrap-FileUpload.css"/>
    <script src="<?php echo $this->static_file_site ?>/dist/bootstrap-FileUpload.js"></script>


    <!--dataTables-->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/datatable/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/datatable/css/dataTables.bootstrap4.min.css">
    <script type="text/javascript" src="<?php echo $this->static_file_site ?>/datatable/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->static_file_site ?>/datatable/js/dataTables.bootstrap4.min.js"></script>


    <!--editor css -->
    <link  rel="stylesheet" href="<?php echo $this->static_file_site ?>/editor/link.css">

    <!--      pagenation-->
    <script src="<?php echo $this->static_file_control ?>/js/pagenation/twbsPagination.js"></script>

<!--slider popup-->


</head>
<!--style="background-image: url('--><?php //echo $this->static_file_site ?><!--/image/site/bg.jpg')"-->
<body>
<div class="bar_top">


<div class="container">
    <div class="row justify-content-end">
        <div class="col-auto">
             <div class="row align-items-center">
                 <div class="col-auto" style="padding-left: 0;">
                 <span> اختر العملية </span> <i class="fa fa-chevron-down"></i>
                 </div>
                 <div class="col-auto" style="padding-right:0;">

                     <select  class="form-control vodiapicker">
                         <option value="usd" class="test" data-thumbnail="<?php echo $this->static_file_site ?>/image/site/usd.png"> USD </option>
                         <option  value="iq" data-thumbnail="<?php echo $this->static_file_site ?>/image/site/iq.png">  IQ </option>
                     </select>

                     <div class="lang-select">
                         <button class="btn-select" value=""></button>
                         <div class="b">
                             <ul id="a">
                             </ul>
                         </div>
                     </div>

                 </div>
             </div>
        </div>
    </div>
</div>

</div>


<div class="container">
    <div class="row align-items-center">
        <div class="col">


            <nav class="navbar navbar-expand-lg navbar-light  ">
                <a class="navbar-brand" href="<?php echo url ?>"><img src="<?php echo $this->static_file_site ?>/image/site/logo.png"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link item_menu" href="<?php echo url ?>"> الرئيسية  </a>
                        </li>


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle item_menu" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                الاقسام
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php  foreach ($category_mobile as $cat_m) {  ?>
                                <a class="dropdown-item" href="<?php  echo url ?>/mobile/list_view/<?php echo $cat_m['id'] ?>"><?php  echo $cat_m['title']?></a>
                                <?php } ?>

                            </div>
                        </li>

                    </ul>

                </div>
            </nav>


        </div>

        <div class="col-auto">

            <div class="col-auto">
                <div class="row justify-content-end align-items-center">

                    <div class="col-auto d-block d-sm-none">
                        <div class="dropdown">
                            <button class="user_xorox dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                    <a class="dropdown-item item_menu btn"   onclick="logoutFacebook()">تسجيل خروج </a>
                                <?php  }else{  ?>


                                    <a class="dropdown-item item_menu" data-toggle="modal" style="cursor: pointer" data-target="#login_site">
                                        <i class="fa fa-sign-in icon_user"  ></i>  <span    > تسجيل الدخول</span>
                                    </a>
                                    <a class="dropdown-item item_menu" href="<?php  echo url ?>/register/register_user">  <i class="fa fa-pencil" ></i>    <span>  أنشاء حساب </span>      </a>

                                <?php  }  ?>


                            </div>
                        </div>
                        <style>
                            button.user_xorox:after{
                                display: none;
                            }

                            .dropdown-menu.down_menu.mobile_dr {
                                right: unset !important;
                                top: 8px !important;
                                left: -5px !important;
                                  background: #495678 ;
                            }
                            .dropdown-menu.down_menu.mobile_dr .dropdown-item{
                                color:#ffffff ;
                            }
                            .dropdown-menu.down_menu.mobile_dr .dropdown-item:hover{
                                color:#000000 ;
                            }
                            .dropdown-menu.down_menu.mobile_dr:after {
                                content: '\f0d8';
                                position: absolute;
                                top: -24px;
                                left: 11px;
                                font-family: FontAwesome;
                                font-size: 26px;
                                color: #495678 ;
                            }
                        </style>

                    </div>
                    <div class="col-auto d-none d-sm-block">
                        <div class="login">

                            <?php  if (isset($_SESSION['username_member_r'])) {  ?>


                                <div class="dropdown">
                                    <button  class="user_xorox dropdown-toggle d-none d-sm-block " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-user icon_user"></i>
                                        <span>
                                       <?php $arr = explode(' ', $_SESSION['name_r']); echo $arr[0];    ?>  </span>
                                        <?php   if ($newMsg > 0) {  ?>
                                            <i style="color: red;font-size: 8px;"  class="fa fa-circle"></i>
                                        <?php  }  ?>

                                    </button>

                                    <button  class="user_xorox dropdown-toggle d-block d-sm-none" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                    <i class="fa fa-sign-in icon_user"  data-toggle="modal" style="cursor: pointer" data-target="#login_site"></i>  <span class="rxoc"  data-toggle="modal" style="cursor: pointer" data-target="#login_site"  > تسجيل الدخول</span>
                                </div>



                            <?php  }  ?>

                        </div>
                    </div>
                    <?php  if (!isset($_SESSION['username_member_r'])) {  ?>
                        <div class="col-auto d-none d-sm-block">
                            <div class="register">
                                <a  href="<?php  echo url ?>/register/register_user">  <i class="fa fa-pencil" ></i>    <span>  أنشاء حساب </span>      </a>
                            </div>
                        </div>
                    <?php  }  ?>
                </div>


            </div>

        </div>
<!--        end User-->



    </div>
</div>



<script>

    //function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
    //    // The current login status of the person.
    //    if (response.status === 'connected') {   // Logged into your webpage and Facebook.
    //        testAPI();
    //    } else {                                 // Not logged into your webpage or we are unable to tell.
    //        console.log('not login')
    //    }
    //}
    //
    //
    //function statusChangeCallback2OldLogin(response) {  // Called with the results from FB.getLoginStatus().
    //    // The current login status of the person.
    //    if (response.status === 'connected') {   // Logged into your webpage and Facebook.
    //        $('.loginFacebook').hide();
    //    } else {
    //        console.log('not login') // Not logged into your webpage or we are unable to tell.
    //        $('.loginFacebook').show();
    //    }
    //}
    //
    //
    //function checkLoginState() {               // Called when a person is finished with the Login Button.
    //    FB.getLoginStatus(function(response) {   // See the onlogin handler
    //        statusChangeCallback(response);
    //    });
    //}
    //
    //
    //
    //window.fbAsyncInit = function() {
    //    FB.init({
    //        appId      : '780249565720656',
    //        cookie     : true,                     // Enable cookies to allow the server to access the session.
    //        xfbml      : true,                     // Parse social plugins on this webpage.
    //        version    : 'v5.0'          // Use this Graph API version for this call.
    //    });
    //
    //
    //    FB.getLoginStatus(function(response) {   // Called after the JS SDK has been initialized.
    //        statusChangeCallback2OldLogin(response);        // Returns the login status.
    //    });
    //};
    //
    //
    //(function(d, s, id) {                      // Load the SDK asynchronously
    //    var js, fjs = d.getElementsByTagName(s)[0];
    //    if (d.getElementById(id)) return;
    //    js = d.createElement(s); js.id = id;
    //    js.src = "https://connect.facebook.net/en_US/sdk.js";
    //    fjs.parentNode.insertBefore(js, fjs);
    //}(document, 'script', 'facebook-jssdk'));
    //
    //
    //function testAPI() {                      // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
    //    FB.api('/me?fields=id,name,email', function(response) {
    //        $.ajax({
    //            type: "GET",
    //            url: '<?php //echo url ?>///register/loginWithFacebook',
    //            data: {name:response.name,id:response.id,email:response.email},
    //            success: function(data)
    //            {
    //                window.location=''
    //            }
    //        });
    //
    //    });
    //}

    function logoutFacebook() {
        //FB.logout(function(response) {
        //    if (response)
        //    {
        //        $.get( "<?php //echo url ?>///register/logout", function( data ) {
        //            if (data)
        //            {
        //                $('.loginFacebook').show();
        //                $('#exampleModalCenter_logOut').modal('show');
        //
        //            }
        //
        //        });
        //    }
        //
        //});
        $.get( "<?php echo url ?>/register/logout", function( data ) {

            if (data) {
               window.location=""
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
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <button type="submit"  class="btn btn-primary">تسجيل دخول</button>

                        </div>
                    </div>
                </form>

                <div class="orF"><span> او </span> </div>
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
                <div id="fb-root"></div>
                <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ar_AR/sdk.js#xfbml=1&version=v5.0"></script>

                <div  style="text-align: center">
                    <fb:login-button  scope="public_profile,email" onlogin="checkLoginState();" class="fb-login-button loginFacebook" data-width="" data-size="medium" data-button-type="login_with" data-auto-logout-link="false"    >
                    </fb:login-button>
                </div>

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
                                        setTimeout(function(){   window.location = ''; }, 3000);

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
            <div class="col-lg-3">
                <div class="categoryAndOffers">
                    اقسام العروض
                </div>
            </div>
            <div class="col-lg-9">

             <form action="<?php  echo url ?>/search/index" method="get">
                <div class="row">
                    <div class="col-lg-3" style="padding: 0">
                        <select name="cat" class="form-control form-control dropdownCatg" >
                          <?php  foreach ($category_mobile as $cat_m) {  ?>
                            <option value="<?php  echo $cat_m['id']?>">   <?php  echo $cat_m['title']?>   </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-8" style="padding: 0">
                        <input name="search" class="form-control textbox_search" type="text"  required>
                    </div>
                    <div class="col-lg-1" style="padding: 0">
                        <button type="submit" class="btn btn_send_search" name="submit"  value="submit" >بحث</button>
                    </div>
                </div>
                </form>
            </div>

        </div>
    </div>

</div>




<style>

    button.btn.btn_send_search {
        background: #ff5500;
        padding: 6px 26px;
        border-radius: 0;
        width: 100%;
        color: #ffff;
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
        background: #343c53;
        color: #ffffff;
        padding: 8px 4px;
    }

    .bar_category
    {
        background: #495678;
        padding: 6px 0;
    }


.bar_top
{
    border-bottom: 1px solid #e3e3e3;
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






<script>

    var langArray = [];
    $('.vodiapicker option').each(function(){
        var img = $(this).attr("data-thumbnail");
        var text = this.innerText;
        var value = $(this).val();
        var item = '<li><span>'+ text +'</span> <img src="'+ img +'" alt="" value="'+value+'"/></li>';
        langArray.push(item);
    })

    $('#a').html(langArray);

    //Set the button value to the first el of the array
    $('.btn-select').html(langArray[0]);
    $('.btn-select').attr('value', 'en');

    //change button stuff on click
    $('#a li').click(function(){
        var img = $(this).find('img').attr("src");
        var value = $(this).find('img').attr('value');
        var text = this.innerText;
        var item = '<li><span>'+ text +'</span> <img src="'+ img +'" alt="" />  </li>';
        $('.btn-select').html(item);
        $('.btn-select').attr('value', value);
        $(".b").toggle();
        //console.log(value);
    });

    $(".btn-select").click(function(){
        $(".b").toggle();
    });

    //check local storage for the lang
    var sessionLang = localStorage.getItem('lang');
    if (sessionLang){
        //find an item with value of sessionLang
        var langIndex = langArray.indexOf(sessionLang);
        $('.btn-select').html(langArray[langIndex]);
        $('.btn-select').attr('value', sessionLang);
    } else {
        var langIndex = langArray.indexOf('ch');
        console.log(langIndex);
        $('.btn-select').html(langArray[langIndex]);
        //$('.btn-select').attr('value', 'en');
    }


</script>





















