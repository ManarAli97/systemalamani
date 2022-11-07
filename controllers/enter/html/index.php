<!DOCTYPE html>
<meta property="og:type" content="website"/>
<html dir="<?php echo $this->dirSite ?>">
<head>
    <meta charset="UTF-8">
    <!--    <meta name="viewport" content="width=device-width, initial-scale=0, maximum-scale=0" />-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <title> تسجيل الدخول </title>
    <link rel="icon"   href="<?php echo $this->static_file_site ?>/image/site/logo_notif.png">


    <!--jquery -->
    <script src="<?php echo $this->static_file_site ?>/js/jquery.min.js"></script>

    <!--bootstrap-->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/bootstrap/css/bootstrap.min.css" >
    <script src="<?php echo $this->static_file_site ?>/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo $this->static_file_site ?>/bootstrap/js/bootstrap.min.js"  ></script>

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
    <script src="<?php echo $this->static_file_site ?>/js/qrcode.min.js"></script>

    <!--  range -->
    <link rel="stylesheet" href="<?php echo $this->static_file_site ?>/range/jquery-ui.css" type="text/css" media="all" />
    <script src="<?php echo $this->static_file_site ?>/range/jquery-ui.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->static_file_site ?>/range/price_range_script.js"></script>

    <script src="<?php echo $this->static_file_site ?>/js/qr-code-styling.js"></script>




    <script>

        var myarr_non = ['NON','non','UNKNOWN','unknown','Unknown','Non','بلا','',' ','  '];

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

        .hello{
            /* z-index:15000000001!important;  */
            top:80px ;
            /*         	margin-bottom:-200px; */
            font-family: 'AlHurraTxtlight';
            /* width: 100px;
            height: 100px; */
            /* background-color: red; */
            background-color: rgb(180, 180, 180);
            background-image: linear-gradient(45deg, rgba(255,255,255,0) 45%,rgba(255,255,255,1) 50%,rgba(255,255,255,0) 55%,rgba(255,255,255,0) 100%);
            background-size: 200%;
            /* z-index: -1; */
            /* filter: blur(5px); */
            -webkit-background-clip: text;
            -moz-background-clip: text;
            -webkit-text-fill-color: transparent;
            -moz-text-fill-color: transparent;
            font-size: 30px;
            /*             font-weight:900; */
            position:fixed;
            animation: hello_animation 4s ease ,hello_real_color 5.5s infinite;

            left:155px;
            /* animation-iteration-count: infinite; */
            float: left;

            /* animation-direction: alternate;  */
        }
        @keyframes hello_animation {
            0% { top:-100px;}
            /* 60% { left:200px;}
            95% { left:300px;} */

            100% { top:80px;}


        }
        .hello_real{
            /* z-index:9000!important;  */
            /* top:0 !important;  */
            font-family: 'AdvertisingBold';
            /* width: 100px;
            height: 100px; */
            /* background-color: red; */
            background-color: rgb(180, 180, 180);
            background-image: linear-gradient(45deg, rgba(255,255,255,0) 45%,rgba(255,255,255,1) 50%,rgba(255,255,255,1) 55%,rgba(255,255,255,0) 60%,rgba(255,255,255,0) 100%);
            background-size: 200%;
            -webkit-background-clip: text;
            -moz-background-clip: text;
            -webkit-text-fill-color: transparent;
            -moz-text-fill-color: transparent;
            position:fixed;
            animation : hello_real_animation  7s  ,hello_real_color 5.5s infinite;
            /*             margin-top: 100px;
                          margin-bottom: 100px; */
            /*   			margin-right: -15px;
                          margin-left:-15px; */
            /* animation-iteration-count: infinite; */
            display: flex ;
            justify-content: center; /* horizontal */
            align-items: center; /* vertical */
            right: 340px;
            width:100%;
            /* animation-direction: alternate;  */
            /*             font-weight:900; */
            font-size:50px ;
        }
        @keyframes hello_real_animation {
            0% { font-size:0px;right: 520px; }
            25% { font-size:0px;right: 520px; }
            100% { font-size:50px ;right: 340px; }

        }
        @keyframes hello_real_color {

            0% {
                background-position: -100%;
            }
            100% {
                background-position: 100%;
            }

        }

        .hidden {
            opacity:0;
        }
        .console-container {

            /* font-family:Khula; */
            /* font-size:4em;
            text-align:center;
            height:200px;
            width:600px; */
            top : -65px ;
            /* display:block; */
            position:absolute;
            color:  rgba(180,180,180,1) ;

            bottom:0;
            left:26px;
            right: 26px;
            margin:auto;
            font-size: 21px;
            animation : typing_feed_in_out  48.83s infinite 1s;
        }

        .console-underscore
        {

            height: 18px;
            width: 7px;
            /* color: white; */
            background: #FFAB38;

            display:inline-block;
            position:relative;
            /* top:-0.14em; */
            left:-5px;
        }
        /*  */
        @keyframes typing_feed_in_out {

            0% {
                color:  rgba(255,255,255,1) ;
            }
            85% {
                color:  rgba(255,255,255,1) ;
            }
            100% {
                color:  rgba(255,255,255,0) ;
            }

        }

        @keyframes welcome_feed_in_out {

            0% {
                opacity: 0 ;
            }

            100% {
                opacity: 1;
            }

        }


        /* title styles */
        .slading span{
            display: flex;
            /*   background-color: #D8D8D8; */
            position: relative;
            overflow: hidden;
            display: block;
            line-height: 1.2;
        }
        .slading span::after{
            box-sizing: border-box;
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: white;
            animation: a-ltr-after 2s cubic-bezier(.77,0,.18,1) forwards;
            transform: translateX(101%);
        }
        .slading span::before{
            box-sizing: border-box;
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background:  #283581;
            animation: a-ltr-before 3s cubic-bezier(.77,0,.18,1) forwards;
            transform: translateX(0);
        }

        .slading span:nth-of-type(1)::before,
        .slading span:nth-of-type(1)::after{
            animation-delay: 1s;
        }

        .slading span:nth-of-type(2)::before,
        .slading span:nth-of-type(2)::after{
            animation-delay: 1.5s;
        }
        .slading span:nth-of-type(3)::before,
        .slading span:nth-of-type(3)::after{
            animation-delay: 2s;
        }

        .slading span:nth-of-type(4)::before,
        .slading span:nth-of-type(4)::after{
            animation-delay: 2.5s;
        }
        .slading span:nth-of-type(5)::before,
        .slading span:nth-of-type(5)::after{
            animation-delay: 3s;
        }

        .slading span:nth-of-type(6)::before,
        .slading span:nth-of-type(6)::after{
            animation-delay: 3.5s;
        }
        .slading span:nth-of-type(7)::before,
        .slading span:nth-of-type(7)::after{
            animation-delay: 5s;
        }

        .slading span:nth-of-type(8)::before,
        .slading span:nth-of-type(8)::after{
            animation-delay: 5.5s;
        }
        @keyframes a-ltr-after{
            0% {transform: translateX(100%)}
            100% {transform: translateX(-101%)}
        }

        @keyframes a-ltr-before{
            0% {transform: translateX(000%)}
            100% {transform: translateX(-200%)}
        }



    </style>



</head>
<body   style="overflow-x: hidden;position: relative">

<div class="background_register">

    <div class="video_center_screen">
        <div class="opacity_video">


            <video   class="bg_video" autoplay muted loop id="myVideo">
                <source src="<?php echo $this->static_file_site ?>/image/site/main_screen_2.mp4" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>

        </div>
    </div>
    <div class="control_from_register">
        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-lg-7 col-md-7   col-sm-7    col-7  " id="content_form">

                    <div class='hello form2'  > اهلا بكم في  </div>
                    <div class='hello_real form2' style="top:120px;right:340px;" > شاشة الحقيقة </div>
                    <div class='hello_real form3' style="top:70px;right:340px;" > شاشة الحقيقة </div>
                    <div class='hello form1' id='h27_hello_f1' style="font-size: 39px;left: 35px; animation : welcome_feed_in_out  5s,hello_real_color 5.5s infinite ;top:58px   " > للانضمام الى عائلة الاماني </div>

                    <div class='console-container form1' style="line-height: 80%;text-align: justify;" ><span id='plase_note'></span><div class='console-underscore' id='plase_note_console'>  </div></div>
                    <div class=' form2 col-6' style="position:fixed;top :220px ;right:320px;font-size: 25px; color:  rgba(180,180,180,1) ;text-align: justify;line-height: 110%" ><span id='plase_note2'></span><div class='console-underscore' id='plase_note_console2'>  </div></div>
                    <div class="container_from ">

                        <div class="carousel-inner">

                            <div class="carousel-item active form1">
                                <form action="<?php  echo url  ?>/customers/form"  method="post"  id="idFormReg"   class="was-validated">



                                    <label style="font-size: 20px" for="search_phone">ادخل رقم الهاتف</label>
                                    <div class="note_phone"></div>
                                    <div class="zero_"></div>
                                    <div class="length_"></div>
                                    <div id="h27_search_phone_id" class="search_phone mb-3">
                                        <div class="row align-items-end">
                                            <div class="col"  >
                                                <div class="input-group">

                                                    <input class="form-control is-valid"   type="number"  name="phone" onblur="checkPhone11n(this);checkPhone(this);" oninput="checkPhone(this)" autocomplete="off" placeholder="ادخل رقم الهاتف" id="search_phone" required>
                                                    <!-- <div class="input-group-prepend" style="    border: 0;overflow: hidden;border-radius: 5px 0 0 5px">
                                                        <div class="input-group-text" id="count_phone_1">0</div>
                                                    </div> -->

                                                </div>
                                            </div>

                                            <div class="col-auto enterByphone_and_qr" style="padding-right: 0" >
                                                <button type="button" class="btn readQrbtn" onclick="select_qr()" data-toggle="modal" data-target="#exampleModal_qr">
                                                    دخول
                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                    <script>

                                        // الكود الخاص الكتابة بشكل كيبورد
                                        function consoleText(words, id,con_id,time_start,time_repet,time_typing,time_underscor,stop_under) {

                                            var visible = true;
                                            var con = document.getElementById(con_id);
                                            var letterCount = 1;
                                            var x = 1;
                                            var waiting = false;
                                            var target = document.getElementById(id);
                                            var farst_time= true;
                                            var finsh = false
                                            // stop_fun(3000)

                                            window.setInterval(function() {
                                                if (farst_time === true){
                                                    window.setTimeout(function() {

                                                        farst_time= false;
                                                    }, time_start)
                                                }
                                                else if (letterCount === 0 && waiting === false) {
                                                    waiting = true;
                                                    target.innerHTML = words[0].substring(0, letterCount)
                                                    window.setTimeout(function() {

                                                        var usedWord = words.shift();
                                                        words.push(usedWord);
                                                        x = 1;

                                                        letterCount += x;
                                                        waiting = false;
                                                    }, 1)
                                                } else if (letterCount === words[0].length + 1 && waiting === false) {
                                                    waiting = true;
                                                    if(stop_under){

                                                        finsh=true;
                                                    }
                                                    window.setTimeout(function() {
                                                        x = (words[0].length +1) *-1;
                                                        letterCount += x;
                                                        waiting = false;


                                                    }, time_repet)
                                                } else if (waiting === false) {
                                                    target.innerHTML = words[0].substring(0, letterCount)
                                                    letterCount += x;
                                                }
                                            }, time_typing)
                                            window.setInterval(function() {
                                                if (visible === true | finsh | farst_time) {
                                                    con.className = 'console-underscore hidden'
                                                    visible = false;

                                                } else {
                                                    con.className = 'console-underscore'

                                                    visible = true;
                                                }
                                            }, time_underscor)
                                        }
                                        // /////////////////////////////////////////

                                        $("#search_phone").unbind('keyup change input paste').bind('keyup change input paste',function(e){
                                            var $this = $(this);
                                            var val = $this.val();
                                            var valLength = val.length;
                                            var maxCount = 11;
                                            if(valLength>maxCount){
                                                $this.val($this.val().substring(0,maxCount));
                                            }
                                        });


                                        $("#search_phone").on("input", function() {
                                            var num=this.value.length
                                            $("#count_phone_1").text(num);
                                            if (num > 11 || num === 11)
                                            {
                                                checkPhone11n()
                                            }
                                        });


                                        function checkPhone(e)
                                        {
                                            var phone=$(e).val()
                                            $.get( "<?php  echo url  ?>/customers/check_phone",{phone:phone}, function( data ) {
                                                if (data ==='true')
                                                {
                                                    $('.enterByphone_and_qr').show();
                                                    $('.note_phone').html(`
                                                    <div class="phone_found">رقم الهاتف مسجل  يرجى  الضغط على زر الدخول</div>
                                                `);
                                                    checkPhone11n()
                                                    $("#f1_next_btn").attr("disabled","disabled");
                                                }else {
                                                    $('.enterByphone_and_qr').hide();
                                                    $('.note_phone').empty()
                                                    $("#f1_next_btn").removeAttr("disabled");

                                                }
                                            });

                                            var ch=phone.toString()
                                            var letter = ch.charAt(0);
                                            var letter2 = ch.charAt(1);
                                            letter=letter=letter+letter2

                                            if (letter !== '07' && letter)
                                            {
                                                $('.zero_').html(`
                                                    <div class="phone_found"> يجب ان يبدا رقم الهاتف برقم 07 </div>
                                                `);
                                            }else {
                                                $('.zero_').empty()
                                            }
                                            if (letter === '')
                                            {
                                                $('.length_').empty()
                                            }

                                        }

                                        function checkPhone11n() {
                                            var phone=$('#search_phone').val()
                                            var ch=phone.toString()
                                            var letter = ch.charAt(0);
                                            if ((ch.length  >  '11'  || ch.length  <  '11')   && letter) {
                                                $('.length_').html(`
                                                                   <div class="phone_found">يجب ان يكون رقم الهاتف 11 رقم    </div>
                                                               `);
                                            }else
                                            {
                                                $('.length_').empty()
                                            }

                                        }

                                    </script>

                                    <style>
                                        .enterByphone_and_qr
                                        {
                                            display: none;
                                        }
                                        .phone_found
                                        {
                                            color: #ffffFF;
                                            background: red;
                                            padding: 0px 12px;
                                            border-radius: 6px;
                                        }
                                        button.btn.readQrbtn {
                                            color: #fff;
                                            background: #ff9800;
                                            font-size: 23px;
                                        }
                                        #count_phone_1
                                        {
                                            margin-right: -35px;
                                            z-index: 9999;
                                        }


                                    </style>
                                    <div class="field_form">

                                        <div class="form-group row">
                                            <div class="col-12">
                                                <label style="font-size: 20px" for="first_name">الاسم واللقب</label>
                                                <input   autocomplete="off"   type="text" class="form-control is-invalid"  oninput="validate_space(this)"  name="first_name" id="first_name" placeholder="الاسم واللقب" required >
                                            </div>
                                        </div>




                                        <div class="form-group row">
                                            <div class="col-12">
                                                <label style="font-size: 20px" for="title"><span>المهنة</span> <span style="font-size: 14px">(يفضل كتابة المنصب الوظيفي في القطاع العام او الخاص ، ربة بيت ،طالب...)</span></label>
                                                <input   autocomplete="off"   type="text" class="form-control "   oninput="validate_space(this)"   name="title" id="title" placeholder="المهنة"  required>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <!-- 											<div class="row"> -->



                                            <!--                                             </div> -->
                                            <div class="col-12">
                                                <label style="font-size: 20px;margin-button:-55px;"  >  تاريخ الميلاد  </label>
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                                        <label style="font-size: 20px" for="day">اليـوم</label>

                                                        <select  name="day" id="day" class="brth form-control " required>
                                                            <option value="">اليوم</option>
                                                            <?php   for($i=1 ; $i <=31 ;$i++) { ?>
                                                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                                            <?php  } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                                        <label style="font-size: 20px" for="month">الشهر</label>
                                                        <select  name="month" id="month" class="brth form-control " required>
                                                            <option value="">الشهر</option>
                                                            <?php   for($x=1 ; $x <=12 ;$x++) { ?>
                                                                <option value="<?php echo $x ?>"><?php echo $x ?></option>
                                                            <?php  } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                                        <label style="font-size: 20px" for="year">السنة</label>
                                                        <input  autocomplete="off"   type="number" class="form-control xcolalich no_required" name="year"   id="year" max="<?php   echo  date('Y',time()) ?>"  min="1920"   placeholder="السنة" required >
                                                    </div>
                                                </div>


                                            </div>
                                        </div>



                                        <style>

                                            .was-validated  .brth.form-control:valid
                                            {
                                                background-image: none;
                                                padding-left: unset;
                                            }

                                            .form-control.no_required {
                                                /* border-color: #ced4da !important; */
                                                padding-left:unset !important;
                                                background-image:unset !important;

                                            }

                                            .withModelRegister
                                            {
                                                max-width: unset !important;
                                                width: 100% !important;
                                                padding: 0 20px !important;
                                            }
                                        </style>

                                        <div class="form-group row">

                                            <div class="col-12">
                                                <label style="font-size: 20px" for="city">المحافظة</label>

                                                <select name="city"   id="city" class="custom-select" required>
                                                    <option value="" disabled hidden="">حدد المحافظة</option>
                                                    <option value="أربيل">أربيل</option>
                                                    <option value="الأنبار">الأنبار</option>
                                                    <option value="بابل">بابل</option>
                                                    <option value="بغداد">بغداد</option>
                                                    <option value="البصرة">البصرة</option>
                                                    <option value="دهوك">دهوك</option>
                                                    <option value="القادسية">القادسية</option>
                                                    <option value="ديالى">ديالى</option>
                                                    <option value="ذي قار"> ذي قار </option>
                                                    <option value="السليمانية">السليمانية</option>
                                                    <option value="صلاح الدين"> صلاح الدين </option>
                                                    <option value="كركوك">كركوك</option>
                                                    <option selected value="كربلاء المقدسة"> كربلاء المقدسة </option>
                                                    <option value="المثنى">المثنى</option>
                                                    <option value="ميسان">ميسان</option>
                                                    <option value="النجف الأشرف"> النجف الأشرف </option>
                                                    <option value="نينوى">نينوى</option>
                                                    <option value="واسط">واسط</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group row">

                                            <div class="col-12">
                                                <label style="font-size: 20px" for="address">الحـي</label>

                                                <input  autocomplete="off"   type="text" class="form-control "  oninput="validate_space(this)"   name="address" id="address" placeholder="الحي"  required>

                                                <input type="hidden" name="id_user_screen" id="id_user_screen">
                                            </div>
                                        </div>
                                        <div id='h27_sex_id' class="">
                                            <label style="    font-size: 21px;margin-left: 22px;"> الجنس </label>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline1" name="gander" value="ذكر" class="custom-control-input" required>
                                                <label style="color: #ffffFF !important;font-size: 21px;" class="custom-control-label" for="customRadioInline1">ذكر</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline2" name="gander" value="انثى" class="custom-control-input" required>
                                                <label style="color: #ffffFF !important;font-size: 21px;" class="custom-control-label" for="customRadioInline2">انثى</label>
                                            </div>
                                        </div>


                                    </div>


                                    <div class="control_slider_regiser">
                                        <div class="row justify-content-between">
                                            <div class="col-auto">
                                                <a class="btn back_layer" href="<?php  echo url .'/'.$this->folder  ?>" role="button" data-slide="prev">
                                                    <i class="fa fa-caret-right"></i> <span> السابق </span>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" name="submit" class="btn next_layer" id="f1_next_btn" >
                                                    <span>التالي</span>  <i class="fa fa-caret-left"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </form>

                            </div>

                            <form action="<?php  echo url  ?>/customers/form2"  method="post"  id="idFormReg2"   class="was-validated">


                                <!--                            choose-->
                                <div class="carousel-item form2 ">


                                    <div class="row">
                                        <div class="col-12">

                                            <label for="about_company" class="col-form-label" style="font-size: 40px;margin-bottom: 5px;margin-right:10px;color:rgb(180, 180, 180);">
                                                <div class=' form2' style="display: block;margin-top: 250px;line-height: 135%" ><span id='plase_note3'></span><div class='console-underscore' id='plase_note_console3'>  </div></div>

                                            </label>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-11">

                                            <!--                            <label for="about_company" class="col-form-label" style="font-size: 40px;margin-bottom: 5px;margin-right:10px;color:rgb(180, 180, 180);"> -->
                                            <div class=' form2' style="display: block;font-size: 24px; color:  rgba(180,180,180,1) ;text-align: justify;line-height: 110%"  ><span id='plase_note4'></span><div class='console-underscore' id='plase_note_console4'>  </div></div>

                                            <!--                                     </label> -->
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group row">
                                        <label for="about_company" class="col-sm-3 col-form-label"> </label>
                                        <div class="col-sm-9" id="f2_yes_no">

                                            <div class="custom-control custom-radio custom-control-inline yes_or_no" id="f2_yes">
                                                <input type="radio" value="1" id="about_company1" name="about_company" required class="custom-control-input  ">
                                                <label  style="color:rgb(180, 180, 180)" class="custom-control-label about_company_style" for="about_company1">نعم</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline yes_or_no" id="f2_no">
                                                <input type="radio" value="2" id="about_company2" name="about_company" required class="custom-control-input  ">
                                                <label  class="custom-control-label about_company_style" for="about_company2">كلا</label>
                                            </div>

                                        </div>

                                        <br>
                                        <br>
                                        <br>
                                    </div>


                                    <div class="control_slider_regiser btn_control_ly4" id="f2_btn_next_pre">

                                        <div class="row justify-content-between">
                                            <div class="col-auto">


                                                <button type="button" class="btn back_layer" onclick="control_slider(1)"   >
                                                    <i class="fa fa-caret-right"></i>   <span>السابق</span>
                                                </button>

                                            </div>
                                            <div class="col-auto" id="f2_btn_next">

                                                <button type="button" class="btn next_layer next_choose ff3"  onclick="control_slider(3)"  disabled href="#carouselExampleControls" role="button" data-slide="next">
                                                    <span>التالي</span>  <i class="fa fa-caret-left"></i>
                                                </button>

                                                <button type="button" class="btn next_layer open_video_fast ff3" disabled style="display: none"  onclick="gotoVideo()">
                                                    <span>التالي</span>  <i class="fa fa-caret-left"></i>
                                                </button>



                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <!--                            choose-->
                                <div class="carousel-item form3">

                                    <div class="forAnswerThat"  style="margin-bottom: 5px">
                                        <div class=' form3' ><span id='f3_qu1'></span><div class='console-underscore' id='f3_qu1_console'> </div></div>

                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline setForAnswer col-12">
                                        <input type="radio"   value="1" id="forAnswerThat1" name="forAnswerThat" class="custom-control-input">
                                        <label class="custom-control-label " for="forAnswerThat1">
                                            <div class=' form3' ><span id='f3_ans1'></span><div class='console-underscore' id='f3_ans1_console'> </div></div>




                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline setForAnswer col-12">
                                        <input type="radio" value="2" id="forAnswerThat2" name="forAnswerThat" class="custom-control-input">
                                        <label class="custom-control-label" for="forAnswerThat2">
                                            <div class=' form3' ><span id='f3_ans2'></span><div class='console-underscore' id='f3_ans2_console'>  </div></div>


                                        </label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline setForAnswer col-12">
                                        <input type="radio" value="3" id="forAnswerThat3" name="forAnswerThat" class="custom-control-input">
                                        <label class="custom-control-label" for="forAnswerThat3">
                                            <div class=' form3' ><span id='f3_ans3'></span><div class='console-underscore' id='f3_ans3_console'>  </div></div>

                                        </label>
                                    </div>
                                    <div class=' form3'  ><span id='f3_note'></span><div class='console-underscore' id='f3_note_console'>  </div></div>




                                    <div class="control_slider_regiser btn_control_ly4" id='f3_btn_next_pre'>

                                        <div class="row justify-content-between">
                                            <div class="col-auto">
                                                <button type="button" onclick="control_slider(2)"  class="btn back_layer"  >
                                                    <i class="fa fa-caret-right"></i> <span> السابق </span>
                                                </button>
                                            </div>
                                            <div class="col-auto" id="f3_btn_next">

                                                <button type="button" class="btn next_layer choose_1_2 ff4" disabled onclick="gotoVideo()"  >
                                                    <span>التالي</span>  <i class="fa fa-caret-left"></i>
                                                </button>

                                                <button name="submit"  type="submit" class="btn next_layer  choose3 ff4"  disabled style="display: none" >
                                                    <span>التالي</span>  <i class="fa fa-caret-left"></i>
                                                </button>

                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <!--                            video-->
                                <div class="this_real_video">
                                    <video     id="myvideo_play" class="video_view"  >
                                        <source src="<?php  echo  $this->static_file_site ?>/image/site/video-new1.mp4" type="video/mp4">
                                    </video>
                                </div>

                                <div class="carousel-item form4 open_video">



                                    <div class="form-group row ">
                                        <label for="after_video" class="col-12 col-form-label ">
                                            <div class=' form4' style="display: block;font-size: 40px; color:  rgba(180,180,180,1) ;text-align: justify;line-height: 135%" ><span id='f4_note'></span><div class='console-underscore' id='f4_note_console'>  </div></div>

                                        </label>
                                        <div class="col-sm-12" style="right:50px" id="f4_yes_no">

                                            <div class="custom-control custom-radio custom-control-inline yes_or_no">

                                                <input type="radio"  value="1" id="after_video1" name="after_video" class="custom-control-input fakeRadio">
                                                <label class="custom-control-label about_company_style"  for="after_video1">نعم</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline yes_or_no">
                                                <input type="radio" value="2" id="after_video2" name="after_video" class="custom-control-input fakeRadio">
                                                <label  class="custom-control-label about_company_style" for="after_video2">كلا</label>
                                            </div>

                                        </div>
                                    </div>



                                    <div class="form-group row noteAfter_video">
                                        <label for="after_video" class="col-12 col-form-label">
                                            <div class=' form4' style="display: block;font-size: 25px; color:  rgba(180,180,180,1) ;text-align: justify;line-height: 115%" ><span id='f4_why'></span><div class='console-underscore' id='f4_why_console'>  </div></div>

                                        </label>
                                        <div class="col-12">

                                            <textarea style="resize: none;overflow: hidden;min-height: 50px; max-height: 500px;" oninput="auto_grow(this)" class="form-control" id="write_note" name="note"></textarea>
                                        </div>
                                    </div>


                                    <div class="control_slider_regiser">

                                        <div class="row justify-content-between">
                                            <div class="col-auto">
                                                <button type="button" class="btn back_layer"   onclick="control_slider(2)"   >
                                                    <i class="fa fa-caret-right"></i> <span> السابق </span>
                                                </button>
                                            </div>
                                            <div class="col-auto" id="f4_next">

                                                <button  name="submit" disabled type="submit" class="btn next_layer lsat_layer" >
                                                    <span>التالي</span>  <i class="fa fa-caret-left"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>


                                </div>

                            </form>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

<div class="modal fade"  id="exampleModal_hello_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <div style="width: 100%" class="row justify-content-between align-content-center">
                    <div class="col-auto">
                        <h5 style=" margin-top: 3px;   font-size: 26px;"  class="modal-title" id="exampleModalLabel"> <span>مرحبا</span>  <span class="name_customer"></span> </h5>
                    </div>

                    <div class="col-auto" style="padding: 0">
                        <img style="width: 70px;" src="<?php  echo  $this->static_file_site ?>/image/site/logo_notif.png">
                    </div>
                </div>


            </div>
            <div class="modal-body" id="message_out">
                <div class="test1n" style="text-align: justify;">
                    <div  style="display: block;font-size: 50px; color:  rgba(30,30,30,1) ;text-align: justify;line-height: 125%;text-align: center; " ><span id='f4_qu_txt1'></span><div class='console-underscore' id='f4_qu_txt1_console'>  </div></div>
                    <div  style="display: block;font-size: 25px; color:  rgba(30,30,30,1) ;text-align: justify;line-height: 125%" ><span id='f4_qu_txt2'></span><div class='console-underscore' id='f4_qu_txt2_console'>  </div></div>
                    <div  style="display: block;font-size: 25px; color:  rgba(30,30,30,1) ;text-align: justify;line-height: 115%" ><span id='f4_qu_txt3'></span><div class='console-underscore' id='f4_qu_txt3_console'>  </div></div>
                    <br>
                </div>
                <div class="logo_on_qr" id="qr_&_logo">
                    <div id="qrcode"></div>
                    <img class="img_logo_qr" id="img_log_in_qr" src="<?php  echo  $this->static_file_site ?>/image/site/logo_notif.png">
                </div>
                <div  id="qr_create" style="background-image:url(<?php  echo  $this->static_file_site ?>/image/site/qr_createing.gif);width: 200px;height: 200px;background-repeat: no-repeat;background-size: 250%;background-position: center;margin-right: 130px;">
                    <!-- <img  id="img_log_in_qr1" src="<?php //  echo  $this->static_file_site ?>/image/site/qr_createing.gif"> -->
                </div>
                <br>
                <div class="progress" style="height: 2px;">
                    <div  class="progress-bar progress_inter" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="test1n" style="text-align: justify;margin:16px">
                <div  style="display: block;font-size: 25px; color:  rgba(30,30,30,1) ;text-align: justify;line-height: 125%" ><span id='f4_qu_txt21'></span><div class='console-underscore' id='f4_qu_txt21_console'>  </div></div>
                <div  style="display: block;font-size: 25px; color:  rgba(30,30,30,1) ;text-align: justify;line-height: 125%" ><span id='f4_qu_txt22'></span><div class='console-underscore' id='f4_qu_txt22_console'>  </div></div>
                <div  style="display: block;font-size: 25px; color:  rgba(30,30,30,1) ;text-align: justify;line-height: 125%" ><span id='f4_qu_txt23'></span><div class='console-underscore' id='f4_qu_txt23_console'>  </div></div>
                <div  style="display: block;font-size: 25px; color:  rgba(30,30,30,1) ;text-align: justify;line-height: 125%" ><span id='f4_qu_txt24'></span><div class='console-underscore' id='f4_qu_txt24_console'>  </div></div>
                <div  style="display: block;font-size: 25px; color:  rgba(30,30,30,1) ;text-align: justify;line-height: 125%" ><span id='f4_qu_txt25'></span><div class='console-underscore' id='f4_qu_txt25_console'>  </div></div>
                <div  style="display: block;font-size: 25px; color:  rgba(30,30,30,1) ;text-align: justify;line-height: 125%" ><span id='f4_qu_txt26'></span><div class='console-underscore' id='f4_qu_txt26_console'>  </div></div>


            </div>

            <div class="container-fluid" id="enter_to_eco">

                <div class="row align-items-end justify-content-between">
                    <div class="col-auto">
                        <div class="row justify-content-center" >
                            <div  class="col-12" style="margin-bottom: 5px;text-align: center"> هل تريد الدخول؟ </div>
                            <div class="col-auto">
                                <button class="btn btn-primary" onclick="enterSite()">نعم</button>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-danger" onclick="window.location='<?php  echo url ?>/register/logout_customer'">لا</button>
                            </div>

                        </div>
                    </div>
                    <div class="col-auto">
                        <button  class="btn btn-warning" onclick="print_qr(this)"  >  <i class="fa fa-print"></i>   <span>طباعة رمز QR</span> </button>

                    </div>
                </div>



            </div>

            <br>
        </div>
    </div>

</div>




<div class="print_qr">

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="print_qr_python col-lg-5 col-md-5 col-sm-5 col-5">

                <div class="print_qr_code">

                    <div style="text-align: center" class="name_customer_print" style=' text-align: center !important;font-size: 35px !important;font-weight: bold !important;margin-bottom: 30px !important; margin-top: 15px;'></div>
                    <div class="logo_on_qr_print" style=' width: 100% ;position: relative; margin-left:auto; margin-right:auto;' >
                        <div id="qrcode_print"  style='text-align:center !important;position: relative !important;   width: 100% !important;padding-right:40px'></div>

                    </div>

                    <div class="name_company_print" style="text-align: center !important;font-size: 20px !important;font-weight: bold !important; margin-top: 30px !important;padding-top: 15px !important;border-top: 1px solid #000;">
                        شركة الاماني
                    </div>
                    <div class="noe_print" style=" text-align: center;font-size: 15px;font-weight: bold;">
                        عزيزي الزبون يمكنك استخدام رمز QR الخاص بك في المره القادمة لتسجيل الدخول لحسابك وتصفح المنتاجات وطلبها من خلال الشاشة.
                    </div>

                </div>


            </div>


        </div>

    </div>

</div>


<script>

    function print_qr(e) {

        <?php  if (!empty($this->setting->get('print_qr'))) {  ?>
        $(".print_qr_python canvas").remove();
        var htmlqr=$(".print_qr_python").html();

        $.post( "<?php  echo url  ?>/bill_print/qr_print",{htmlqr:htmlqr}, function( data ) {

            console.log(data)
            if (data)
            {
                alert('تمت طباعة رمز QR خاص بيك يرجى استلامة من الكاشير')
            }else{
                alert('الطابعة غير متصلة')
            }

        });

        <?php } else {  ?>
         window.print()
        <?php } ?>

        $(e).hide()

    }

</script>


<style>

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
        font-size: 35px !important;
        font-weight: bold !important;
        margin-bottom: 30px !important;
        margin-top: 15px;
    }

    .print_qr
    {
        padding: 8px;
        display: none;
    }

    #qrcode_print
    {
        width: 100% !important;
    }

    #qrcode_print img
    {
        width: 100% !important;
        display: initial !important;
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


    @media print {

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

        .hide_print {
            display: none;
        }


        .background_register
        {
            height: 0;
            overflow: hidden;
            visibility: hidden;
            display: none;
        }

        .result {
            height: auto !important;
            overflow: unset !important;
        }

        .bodyControl {
            overflow: unset;
        }

        .footer_bill {
            margin-top: 30px;
        }

        .print_qr {
            width: 100% !important;
            height: auto !important;
            position: relative;
            visibility: visible;
            display: block;
        }

        .print_qr * {
            position: relative;
            visibility: visible;
        }

    }







</style>

<script>
    $(document).ready(function(){
        consoleText(['لطفاً يرجى ملئ البيانات بدقة ، في حالة املاء بينات غير صحيحة لن تستطيع استرداد حسابك مستقبلا .'], 'plase_note','plase_note_console',1000,40000,90,400,false);


//     $("#content_form").css("margin-top","");
// //         $("#content_form").css("margin-top","");
// consoleText(['لطفاً يرجى ملئ البيانات بدقة ، في حالة املاء بينات غير صحيحة لن تستطيع استرداد حسابك مستقبلا .'], 'plase_note','plase_note_console',1000,40000,90,400,false);
//             console.log("test id")
//             $('.form1').show('slow')
//             $('.form2').hide('slow')
//             $('.form3').hide('slow')
//             $('.form4').hide('slow')
    });
    function startType(){

        $('#qr_create').show();
        hide_tag('qr_create',18000);

        consoleText(['مبـــــــارك'], 'f4_qu_txt1','f4_qu_txt1_console',500,10000000,90,400,true);
        consoleText([' انضممت الان الى عائلة الاماني و اصبح حسابك جاهز لتبدأ بإستخدامه.'], 'f4_qu_txt2','f4_qu_txt2_console',2000,10000000,90,400,true);
        consoleText(['التقط صورة للرمز و احتفظ به في موبايلك لانك ستحتاجه في كل مرة تزور بها شركة الاماني.'], 'f4_qu_txt3','f4_qu_txt3_console',9000,10000000,90,400,true);



        $('#qrcode').hide();
        show_tag('qrcode',18000);
        $('#img_log_in_qr').hide();
        show_tag('img_log_in_qr',18000);
        $('#enter_to_eco').hide();
        show_tag('enter_to_eco',19000);

        consoleText(['مميزات الحساب'], 'f4_qu_txt21','f4_qu_txt21_console',19000,1000000,90,400,true);
        consoleText(['1. لن تحتاج الى اعطاء اي من بياناتك عند التسوق سوى ابراز هذه الصوره لموظف الشركة.'], 'f4_qu_txt22','f4_qu_txt22_console',20500,1000000,90,400,true);
        consoleText(['2. ستتمكن من التسوق من الشاشات الذكيه بكل سهوله والاستعانه بموظف الشركة ان احببت.'], 'f4_qu_txt23','f4_qu_txt23_console',28500,1000000,90,400,true);
        consoleText(['3. يمكنك الاطلاع على مشترياتك السابقه.'], 'f4_qu_txt24','f4_qu_txt24_console',36500,1000000,90,400,true);
        consoleText(['ملاحظة /'], 'f4_qu_txt25','f4_qu_txt25_console',41500,1000000,90,400,true);
        consoleText(['في حاله لم تتمكن من الحفاظ على الصوره او فقدتها يمكنك الحصول عليها في اي وقت تشاء عبر الطلب من موظف المبيعات .'], 'f4_qu_txt26','f4_qu_txt26_console',42500,1000000,90,400,true);
    }
    function show_tag(id,time_to){
        window.setTimeout(function() {
            $('#'+id).show()
            console.log(id)
        }, time_to)

    }
    function hide_tag(id,time_to){
        window.setTimeout(function() {
            $('#'+id).hide()
            console.log(id)
        }, time_to)
    }
    function control_slider(id) {
        if (id === 1)
        {
            $("#content_form").css("margin-top","");
            consoleText(['لطفاً يرجى ملئ البيانات بدقة ، في حالة املاء بينات غير صحيحة لن تستطيع استرداد حسابك مستقبلا .'], 'plase_note','plase_note_console',1000,40000,90,400,false);
            console.log("test id")
            $('.form1').show('slow')
            $('.form2').hide('slow')
            $('.form3').hide('slow')
            $('.form4').hide('slow')
        }else if (id === 2)
        {
            $("#content_form").css("margin-top","-150px");
            consoleText(['زبوننا الكريم .. لاكمال عملية الحصول على حساب ، لطفاً نرجو الاجابة على اسئلة شاشة الحقيقة'], 'plase_note2','plase_note_console2',3000,1000000,60,400,true);
            consoleText(['لاحظنا ان بعض زبائننا الكرام  <b> ليس </b>لديهم معلومة عن المعنى الحـقيـقـي لشعـــار شـركتـنـــا (جـودة ، ضمـان ، سعر مميز ) فهل تعرف ماذا نقصد به؟'], 'plase_note3','plase_note_console3',10000,1000000,60,400,true);
            consoleText(['ملاحظة / في حالة اختيارك "كلا " سيبدأ فيديو يبين لك المعنى الحقيقي للجودة والضمان والسعر المميز حسب وجهة نظر ادارة الشركة '], 'plase_note4','plase_note_console4',20000,1000000,60,400,true);
            // $('#f2_yes_no').hide();
            // show_tag('f2_yes_no',370);

            $('#f2_yes').hide();
            show_tag('f2_yes',22000);

            $('#f2_no').hide();
            show_tag('f2_no',22000);

            $('#f2_btn_next').hide();
            show_tag('f2_btn_next',23000);

            // $('#f2_btn_next_pre').hide();
            // show_tag('f2_btn_next_pre',400);
            $('.form1').hide('slow')
            $('.form2').show('slow')
            $('.form3').hide('slow')
            $('.form4').hide('slow')
        }else if (id === 3)
        {
            $("#content_form").css("margin-top","");
            consoleText(['برأيك اي من الاتي يمثل المعنى الحقيقي للجوده والضمان والسعر المميز؟'], 'f3_qu1','f3_qu1_console',3000,10000000,70,400,true);
            consoleText(['1.	انك ستحصل على انسب سعر و افضل ضمان.'], 'f3_ans1','f3_ans1_console',9000,10000000,70,400,true);
            consoleText(['2.	ستحصل على انسب سعر و افضل ضمان و الجودة تعني انك اشتريت جهاز لماركة مشهورة.'], 'f3_ans2','f3_ans2_console',13000,10000000,70,400,true);
            consoleText(['3.  ستحصل على انسب سعر و افضل ضمان و الجودة تعني انك اشتريت جهاز غير مغشوش "اصلي" في زمن انتشر به الغش بشكل كبير جدا و خصوصا في عالم الاجهزة الالكترونية لان طرق الغش سهلة و مربحة جداً و تحتاج فقط لشخص غير ملتزم دينيا ليعمل بها و يكسب منها الاموال الحرام الطائلة و من تلك الطرق البسيطة هي بيع الجهاز المجدد (مستخدم وتمت صيانته) على انه جهاز اصلي جديد و كذلك استبدال ملحقات الاجهزة الاصلية بملحقات تجارية مشابهة للاصلية و اعادة اقفال كارتونة الجهاز بلاصق او نايلون يشابه لاصق و نايلون الجهاز الاصلي .'], 'f3_ans3','f3_ans3_console',20000,10000000,70,400,true);
            consoleText(['في حاله اختيارك لخيار خاطئ سيبدا فيديو يبين لك المعنى الحقيقي للجوده والضمان والسعر المميز حسب وجهه نظر ادارة شركة الاماني'], 'f3_note','f3_note_console',57000,10000000,70,400,false);
            $('#f3_btn_next').hide();
            show_tag('f3_btn_next',67000);
            $('.form1').hide('slow');
            $('.form2').hide('slow');
            $('.form3').show('slow');
            $('.form4').hide('slow');
        }else if (id === 4)
        {
            consoleText(['بعـد مشاهدتـك فديو الحقيقة هل انت مقتنع تماما ان ليس من مـصــلحتــك الـبحــث عن السعر الارخص فقط في بيئة كثر بها الغـش بشـكل فضيـع جـدا و يتـوجـب عليـــك مــن الان اختيار مكان تثق به للشراء منه.'], 'f4_note','f4_note_console',1000,40000000,90,400,false);
            $('#f4_yes_no').hide();
            show_tag('f4_yes_no',19000);
            $('#f4_next').hide();
            show_tag('f4_next',20000);
            $('.form1').hide('slow')
            $('.form2').hide('slow')
            $('.form3').hide('slow')
            $('.form4').show('slow')
        }else
        {
            // consoleText(['لطفاً يرجى ملئ البيانات بدقة...'], 'text',3000,10000,120,400);
            consoleText(['لطفاً يرجى ملئ البيانات بدقة...'], 'plase_note','plase_note_console',3000,10000,90,400,true);
            $('.form1').hide('slow')
            $('.form2').show('slow')
            $('.form3').hide('slow')
            $('.form4').hide('slow')
        }
    }

</script>



<style>
    .zoom_out input[type='text']
    {
        margin: 1px 5px -5px 5px;
        /* height: 30px !important;
        font-size: 12px !important; */
        padding : 0px 20px !important;
        width: 98% !important;
    }
    .zoom_out input[type='number']
    {
        margin: 1px 5px -5px 5px;
        /* height: 30px !important;
        font-size: 12px !important; */
        padding : 0px 20px !important;
        width: 95% !important;
    }
    .zoom_out input[type='radio']
    {
        margin: 1px 5px -5px 5px;
        /* height: 30px !important;
        font-size: 12px !important; */
        padding : 0px 20px !important;
        width: 95% !important;
    }
    .zoom_out label
    {
        margin: 1px 5px 0px 0px !important;

        /* font-size: 16px; */
    }
    .zoom_out select
    {
        margin: 0px 5px -20px 5px;
        /* height: 30px !important;
        font-size: 10px !important; */
        padding : 0px 20px !important;
        width: 98% !important;
    }
    #h27_search_phone_id.zoom_out{
        margin: 0px 0px -20px 0px;
    }
    /* .zoom_out *
    {
        margin: 0px 0px 0px 0px;
    } */
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    .form2
    {
        display: none;
    }


    .form3
    {
        display: none;
        color :rgb(180, 180, 180);
        /* font-size: 25px; */
        text-align: justify;
    }
    #f3_qu1 ,#f3_ans1 ,#f3_ans2 ,#f3_ans3,#f3_note
    {
        font-size: 25px;
        line-height: 130%;

    }

    .form4
    {
        display: none;
    }




    .text_after_video
    {
        font-size: 20px;
    }

    .control_slider_regiser {
        margin-top: 30px;
    }

    .btn.next_slider {
        background: #00abda;
        margin-top: 32px;
        border-radius: 36px;
        padding: 8px 23px;
        font-size: 25px;
        color: #fff;
        margin-right: 43px;
    }


    .btn.back_layer {
        background:rgba(244, 27, 53, 0.25);
        border: 2px solid  #dc3545;
        /* background: #dc3545; */
        /* margin-top: 23px; */
        border-radius: 36px;
        color: #fff;
        padding: 3px 20px;
        font-size: 22px;
        height: 40px;
        width: 150px;

    }
    .btn.next_layer {
        background:rgba(40, 167, 69, 0.25);
        border: 2px solid  #28a745;
        /*     	background:rgba(0, 174, 219, 0.25);
                border: 2px solid  #00AEDB; */
        /* margin-top: 23px; */
        border-radius: 50px;
        padding: 3px 20px;
        font-size: 22px;
        height: 40px;
        color: #fff;
        width: 150px;
    }

    .text_start
    {
        color: #ffffff;
        line-height: 1.7;
        font-family: Arial;
    }


    .real_screen {
        font-size: 55px;
        background: #CF2B8E;
        background: -webkit-linear-gradient(to left, #CF2B8E 0%, #FCB528 67%);
        background: -moz-linear-gradient(to left, #CF2B8E 0%, #FCB528 67%);
        background: linear-gradient(to left, #fb5695 0%, #fff258 67%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: bold;
    }

    .container_from {

        /*height: 385px;*/
        width: 100%;
        overflow: auto;
    }

    .background_register
    {

        border: 1px solid;
        height: 100%;
        position: fixed;
        width: 100%;
        background: black;


    }

    .background_register .video_center_screen
    {

        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        background: #000000;
        height: 100%;
        /*background-image: url(*/<?php //echo $this->static_file_site ?>/*/image/site/bg-new.gif);*/
        background-repeat: no-repeat;
        background-position: right;
        background-size: cover;

    }

    .opacity_video
    {
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 1;
        background: #00000038;
        opacity: 1;

    }

    .background_register .video_center_screen .bg_video
    {
        width: 100%;
        z-index: 11;
        position: relative;
        top: 50%;
        transform: translateY(-50%);
    }
    .control_from_register
    {

        position: absolute;
        top: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        z-index: 1111;
        color: #ffffff;
    }



</style>




<style>






    .search_phone .text_phone {
        font-size: 23px;
        margin-top: 53px;
    }


    input#search_phone {
        height: 40px;
        font-size:16 px;
        /* border: 2px solid #ccc; */
        background: rgba(255, 255, 255, 0.2);
        border-radius: 36px;
        color: #E5E5E5 !important;
    }

    button#btn_search_phone {
        background: #ffc107;
        color: #ffff;
        padding: 0 26px;
        height: 50px;
        border: 0;
        font-size: 26px;
        border-radius: 10px 0 0 10px;
    }

    .field_form input,
    .field_form textarea,
    .field_form select,
    .custom-select.is-valid, .was-validated .custom-select:valid
    {
        height: 40px;
        font-size: 16px;
        border-radius: 36px;
        background: rgba(255, 255, 255, 0.2) !important;
        color: #E5E5E5 !important;
        /* border: 2px solid #ccc; */
    }
    option
    {
        color:#69757D;
    }
    .xphonea
    {
        border: 1px solid red !important;
        box-shadow: 0 0 0 0.2rem rgba(167, 76, 40, 0.25) !important;

    }

    .btn_control_ly3
    {
        margin-top: 0;
    }
    .btn_control_ly4
    {
        margin-top: 10px;
    }

    .xmarg
    {
        margin-bottom: 0;
    }

    .text_register {
        font-size: 30px;
        margin-bottom: 12px;
    }

    .setForAnswer {
        margin-bottom: 5px;
        border: 1px solid #bdbdbd;
        padding: 5px 34px 3px 5px;
        border-radius: 19px;
    }

    .setForAnswer label {
        color: #ffffff !important;
    }

    .about_company_style
    {
        color: #ffffff !important;
        font-size: 30px;

    }

    .about_company_style::before {
        right: -2.5rem;
        display: block;
        width: 25px;
        height: 25px;
    }

    .about_company_style::after {
        right: -40px;
        width: 25px;
        height: 25px;
    }

    .yes_or_no
    {
        margin: 0 25px;
    }
    .test1n {
        margin-bottom: 6px;
        font-size: 20px;
        color:#283581;
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
    .phone_number_found {
        background: #FFC107;
        font-size: 14px;
        margin-bottom: 2px;
        padding: 3px 7px;
    }


    .video_view
    {
        width: 100%;
        /* z-index: 15000000000; */
        display: none;
    }



    .video_view::-webkit-media-controls {
        display:none !important;
    }

    .noteAfter_video
    {
        display: none;
    }

    .question_after_video
    {
        display: none;
    }

    .carousel-item {

        transition: -webkit-transform .3s ease-in-out;
        transition: transform .3s ease-in-out;
        transition: transform .3s ease-in-out, -webkit-transform .3s ease-in-out;
    }

</style>

<script>

    function set_back_layer() {

        $('.xnext').addClass('carousel-item-next carousel-item-left')
        $('.xback').addClass('active carousel-item-left')
        setTimeout(function () {
            $('.xnext').removeClass('carousel-item-left')
            $('.xnext').removeClass('active')

        },40)

        setTimeout(function () {
            $('.xback').removeClass(' carousel-item-left')

        },50)

        setTimeout(function () {
            $('.xnext').removeClass('carousel-item-next')

        },500)


    }

</script>


<script>


    function validate_space(input) {
        if(/^\s/.test(input.value))
            input.value = '';
    }


    function showResult(phone)
    {

        $.get( "<?php  echo url  ?>/customers/chphone/"+phone, function( data ) {
            if (data==='found')
            {
                $('.chphone').html('<div class="phone_number_found">رقم الهاتف مسجل مسبقا يرجى الرجوع الى الفقرة السابقة .</div>')
                $('#phone').addClass('xphonea')
            }else {
                $('.chphone').empty();
                $('#phone').removeClass('xphonea')
            }
        });

    }

    $(document).ready(function(){
        $('.video_view').on('ended',function(){

            closeFullscreen();
            $('.lsat_layer').removeAttr("disabled");
            $('.question_after_video input').attr('required','required');
            $('.video_view').hide();
            $('.question_after_video').show('fast');
            control_slider(4)

        });
    });


    $('input[name="about_company"]').change(function() {
        val= $('input[name="about_company"]:checked').val();
        if (val==='1')
        {

            $('.next_choose').show();
            $('.open_video_fast').hide();

        }else
        {

            $('.next_choose').hide();
            $('.open_video_fast').show();

        }

        $('.ff3').removeAttr('disabled')

    });



    function gotoVideo()
    {
        $('.video_view').show();
        $('.open_video').addClass('active')
        openFullscreen();
    }



    $('input[name="after_video"]').change(function() {
        val= $('input[name="after_video"]:checked').val();
        if (val==='1')
        {
            $('.noteAfter_video textarea').removeAttr('required');
            $('.noteAfter_video').hide('fast');
        }else
        {

            $('.noteAfter_video textarea').attr('required','required');
            $('.noteAfter_video').show('fast');
            consoleText([' لماذا لست مقتنعاً ؟  نرجو ان تكتب لنا كي نفهم طريقة تفكيرك و نسعى الى توفير ما تره مناسب لك<br>'], 'f4_why','f4_why_console',1,1000000,90,400,true);
        }

    });


    $('input[name="forAnswerThat"]').change(function() {
        val2= $('input[name="forAnswerThat"]:checked').val();
        if (val2==='1' ||  val2==='2' )
        {

            $('.choose_1_2').css('display','block');
            $('.choose3').hide();

        }else
        {
            $('.this_real_video').show()
            $('.choose3').show();
            $('.choose_1_2').hide();
            $('.noteAfter_video').hide('fast');
            $(".fakeRadio").prop( "checked", false );
            $('.fakeRadio').removeAttr('required')
            $('#write_note').removeAttr('required')


        }

        $('.ff4').removeAttr('disabled')

    });

    function step2back() {

        setTimeout(function () {

            val= $('input[name="about_company"]:checked').val();
            if ( val==='2' )
            {
                $('.goback').click();
            }
        },500)


    }




    function openFullscreen() {

        var elem = document.getElementById("myvideo_play");
        elem.play()

        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) { /* Safari */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) { /* IE11 */
            elem.msRequestFullscreen();
        }
    }

    function closeFullscreen() {
        var elem = document.getElementById("myvideo_play");
        if (elem.exitFullscreen) {
            elem.exitFullscreen();
        } else if (elem.mozCancelFullScreen) {
            elem.mozCancelFullScreen();
        } else if (elem.webkitExitFullscreen) {
            elem.webkitExitFullscreen();
        } else if (elem.msExitFullscreen) {
            elem.msExitFullscreen();
        }
    }




    $('#exampleModal_register_new').modal({
        backdrop: 'static',
        keyboard: false
    });


    $('#id_user_screen').val(localStorage.getItem("screen_user_id"))







    var time_reg=0;



    var  counttime = setInterval(function () {
        time_reg++;
        console.log(time_reg)
    },1000);

    $("#idFormReg").submit(function(e) {

        var ph=$('#search_phone').val();
        var mob=ph.toString();

        var letter = mob.charAt(0);
        var letter2 = mob.charAt(1);
        letter=letter=letter+letter2

        if ( mob.length  > '11' ||  mob.length  < '11' || letter  !== '07' )
        {
            $('.length_').empty()
            $('.zero_').empty()
            $('.note_phone').html(`
                   <div class="phone_found">يجب ان يكون رقم الهاتف 11 رقم يبدأ برقم 07</div>
               `);
        }else {
            $('.note_phone').empty();
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: url+"?time_reg="+time_reg,
                data: formData,
                success: function (result) {
                    console.log(result)
                    var response = JSON.parse(result);
                    if (response.error) {
                        for (var prop in response.error) {
                            $('*[name="' + prop + '"]').addClass('is-invalid');
                        }

                        alert('يرجى مراجة المعلومات المدخلة.')

                    } else if (response.done) {


                        control_slider(2)



                    } else {
                        alert('فشل التسجيل يرجى اعادة التسجيل ')
                        window.location = "<?php echo url ?>"
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            })
        }return false;
    });



    $("#idFormReg2").submit(function(e) {

        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: url+"?time_reg="+time_reg,
            data: formData,
            success: function (result) {
                console.log(result)
                var response = JSON.parse(result);
                if (response.error) {
                    for (var prop in response.error) {
                        $('*[name="' + prop + '"]').addClass('is-invalid');
                    }

                    alert('يرجى مراجة المعلومات المدخلة.')

                } else if (response.done) {
                    time_reg=0;
                    clearInterval(counttime)
                    infoUrl=response.done['done'];

                    var qrcode = new QRCode("qrcode");
                    qrcode.makeCode(infoUrl);

                    var qrcode_print = new QRCode("qrcode_print");
                    qrcode_print.makeCode(infoUrl);


                    //const qrcodePrint = new QRCodeStyling({
                    //    "type": "svg",
                    //    "width": 300,
                    //    "height": 300,
                    //    "data": infoUrl,
                    //    //"image":"<?php //// echo  $this->static_file_site ?>/////image/site/logo_notif.png",
                    //    "margin": 0,
                    //    "qrOptions": {
                    //        "typeNumber": "0",
                    //        "mode": "Byte",
                    //        "errorCorrectionLevel": "Q"
                    //    },
                    //    "imageOptions": {
                    //        "hideBackgroundDots": false,
                    //        "imageSize": 0,
                    //        "margin": 0
                    //    },
                    //    "dotsOptions": {
                    //        "type": "square",
                    //        "color": "#000000",
                    //        "gradient": null
                    //    },
                    //    "backgroundOptions": {
                    //        "color": "#ffffff",
                    //        "gradient": null
                    //    },
                    //    "dotsOptionsHelper": {
                    //        "colorType": {
                    //            "single": true,
                    //            "gradient": false
                    //        },
                    //        "gradient": {
                    //            "linear": true,
                    //            "radial": false,
                    //            "color1": "#000000",
                    //            "color2": "#000000",
                    //            "rotation": "0"
                    //        }
                    //    },
                    //    "cornersSquareOptions": {
                    //        "type": "",
                    //        "color": "#000000",
                    //        "gradient": {
                    //            "type": "linear",
                    //            "rotation": 0,
                    //            "colorStops": [
                    //                {
                    //                    "offset": 0,
                    //                    "color": "#000000"
                    //                },
                    //                {
                    //                    "offset": 1,
                    //                    "color": "#000000"
                    //                }
                    //            ]
                    //        }
                    //    },
                    //    "cornersSquareOptionsHelper": {
                    //        "colorType": {
                    //            "single": true,
                    //            "gradient": false
                    //        },
                    //        "gradient": {
                    //            "linear": true,
                    //            "radial": false,
                    //            "color1": "#000000",
                    //            "color2": "#000000",
                    //            "rotation": "0"
                    //        }
                    //    },
                    //    "cornersDotOptions": {
                    //        "type": "",
                    //        "color": "#000000"
                    //    },
                    //    "cornersDotOptionsHelper": {
                    //        "colorType": {
                    //            "single": true,
                    //            "gradient": false
                    //        },
                    //        "gradient": {
                    //            "linear": true,
                    //            "radial": false,
                    //            "color1": "#000000",
                    //            "color2": "#000000",
                    //            "rotation": "0"
                    //        }
                    //    },
                    //    "backgroundOptionsHelper": {
                    //        "colorType": {
                    //            "single": true,
                    //            "gradient": false
                    //        },
                    //        "gradient": {
                    //            "linear": true,
                    //            "radial": false,
                    //            "color1": "#ffffff",
                    //            "color2": "#ffffff",
                    //            "rotation": "0"
                    //        }
                    //    }
                    //
                    //});
                    //
                    //qrcodePrint.append(document.getElementById("qrcode_print"));
                    //
                    //



                    $('span.name_customer').text($('#first_name').val());
                    $('.name_customer_print').text($('#first_name').val());
                    $('#exampleModal_hello_customer').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    startType();

                } else {
                    alert('فشل التسجيل يرجى اعادة التسجيل ')
                    window.location="<?php echo url ?>"
                }
            },
            cache: false,
            contentType: false,
            processData: false
        })

    });


    function enterSite()
    {

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
        }, 25);

    }





    $("#search_phone").submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            success: function (result) {
                var response = JSON.parse(result);

                if (response.error) {
                    $('.after_phone').click();

                } else if (response.done) {

                    infoUrl="<?php  echo url ?>/customers/qr/"+response.done['done'];
                    var qrcode = new QRCode("qrcode");
                    qrcode.makeCode(infoUrl);

                    $('span.name_customer').text(response.done['first_name']);
                    $('#exampleModal_hello_customer').modal({
                        backdrop: 'static',
                        keyboard: false
                    });

                } else {
                    $('.after_phone').click();
                }
            },
            cache: false,
            contentType: false,
            processData: false
        })

    });





    function auto_grow(element) {
        element.style.height = "40px";
        element.style.height = (element.scrollHeight)+"px";
    }
</script>







<div class="modal  " onclick="select_qr()" id="exampleModal_qr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> تسجيل الدخول بستخدام رمز QR   </h5>

            </div>
            <div class="modal-body">
                <div class="iconqr" style="margin-bottom: 18px;text-align: center">
                    <img width="100" src="<?php echo $this->static_file_site ?>/image/site/qr.png">
                </div>

                <form id="rprice"  method="post" action="<?php echo url .'/'. $this->folder ?>/rprice">
                    <div class="error_qr"></div>
                    <div class="form-row align-items-center">
                        <div class="col" style="position: relative">
                            <input type="search" style="width: 0;height: 0;padding: 0;margin: 0;box-shadow: unset;outline: unset;border: 0"        autocomplete="off"   name="qr" class="form-control" id="qrcodeprice" placeholder="اضغط هنا ثم قم بتوجيه رمز QR الخاص بك نحو الكامرة"  required>
                        </div>

                    </div>
                </form>
                <input   style="width: 0;height: 0;padding: 0;margin: 0;box-shadow: unset;outline: unset;border: 0"    class="form-control" id="qrcodeprice2"    >


            </div>
            <div class="modal-footer text-right d-block">
                اجعل رمز ال QR الخاص بك امام الكامره
            </div>
        </div>
    </div>
</div>


<script>


    function select_qr()
    {

        $("#qrcodeprice").val('');
        $(document).ready(function() {
            $("#qrcodeprice").select();
        });

    }

    function select_qr2()
    {

        $("#qrcodeprice2").val('');
        $(document).ready(function() {
            $("#qrcodeprice2").select();
        });

    }


    $("#rprice").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize()+"&submit=submit", // serializes the form's elements.
            success: function(data)
            {
                if (data==='rqr')
                {
                    select_qr()
                    $(".error_qr").text('رمز QR الخاص بك غير صحيح!');
                }
                else
                {
                    select_qr2()
                    localStorage.setItem("uuid", data);
                    localStorage.setItem("counter", 0);
                    $(".error_qr").html("<span style='color: green'>جاري تسجيل الدخول ...</span>");
                    window.location="<?php echo url ?>"
                }
            }
        });


    });
    $( ".form1 input[type='text'],.form1 input[type='number'],.form1 select" ).focus(function() {
        // alert( "Handler for .focus() called." );
        $(".form1").addClass("zoom_out");
        $("#h27_hello_f1").css("top","60px");
        $(".console-container").css({"top":"-50px"});
        $("#content_form").css("margin-top","190px");
        console.log("test in");

    });
    $( ".form1 input[type='text'],.form1 input[type='number'],.form1 select" ).focusout(function() {
        // alert( "Handler for .focus() called." );
        $(".form1").removeClass("zoom_out");
        $("#h27_hello_f1").css("top","58px ");
        $("#content_form").css("margin-top","");
        $(".console-container").css({"top":"-65px"});
        console.log("test out");
    });

</script>
<style>

    .error_qr{
        color: red;
        margin-bottom: 5px;
    }
</style>

<a class="btn user_screen_fiexd" id="user_screen_fiexd"></a>

<style>

    a#user_screen_fiexd {
        position: fixed;
        bottom: 0;
        left: 0;
        background: #2a292a;
        border-radius: 0;
        padding: 1px 12px;
        color: #fff;
        display: none;
    }

    .underSetting {
        bottom: 34px;
    }


    canvas
    {
        display: none;
    }



</style>

<script>


    if ( localStorage.getItem("screen_user"))
    {
        $('#user_screen_fiexd').text(localStorage.getItem("screen_user")).show()
    }

</script>

</body>
</html>
