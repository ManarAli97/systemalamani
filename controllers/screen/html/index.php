<!DOCTYPE html>
<meta property="og:type" content="website"/>
<html dir="<?php echo $this->dirSite ?>">
<head>
    <meta charset="UTF-8">
    <!--    <meta name="viewport" content="width=device-width, initial-scale=0, maximum-scale=0" />-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <title>  تعين موضف للشاشة  </title>
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


    </style>



</head>
<body   style="overflow-x: hidden;position: relative">
<br>
<br>
<br>



<div class="container-fluid">

    <div class="row justify-content-center  ">




        <div class="col-lg-6 col-md-9  col-sm-9 col-9 mb-3" style="position: relative">
            <label>  اختر موظف للشاشة </label>
            <input  type="text" oninput="search_customer_note()"   id="username" class=" form-control"   placeholder="اسم المستخدم"   autocomplete="off"  >
            <div class="list_name"></div>
            <input type="hidden" id="id_user_get">
        </div>

        <div class="col-lg-2 col-md-3  col-sm-3 col-3  mb-3"  style="margin-top: 31px">
            <button  onclick="save_info_user()" class="btn btn-warning" >حفظ</button>

        </div>

    </div>

</div>




<script>

    function writeNoteAboutCustomer() {
        $('#ModalwriteNoteAboutCustomer').modal('show')
    }


    function search_customer_note() {

        if ($('#username').val())
        {
            $.get( "<?php  echo url .'/'.$this->folder ?>/username",{name:$('#username').val()}, function( data ) {
                if (data)
                {
                    $('.list_name').html(data).show()
                }else
                {
                    $('.list_name').hide().empty()
                }
            });

        }else {
            $('.list_name').hide().empty()

        }


    }


    $("#username").focusout(function(){
        setTimeout(function () {
            $('.list_name').hide()

        },500)
    });

    function print_name(e,id) {
        $('#username').val($(e).text())
        $('#id_user_get').val(id)
        $('.list_name').hide().empty()
    }

      localStorage.removeItem('screen_user');
     localStorage.removeItem('screen_user_id');



    function save_info_user() {



        var username=$("#username").val();
        var id_user = $('#id_user_get').val()

        localStorage.setItem("screen_user", username);
        localStorage.setItem("screen_user_id", id_user);

        if (localStorage.getItem("screen_user"))
        {
          alert('تم الحفظ')
          window.location="<?php echo url ?>";
        }

    }

    function empty_fild() {
        $('#username').val('')
        $('#id_user_get').val('')
        $('#note_custom_get').val('')
    }

</script>





<br>
<br>
<br>
<br>
<br>
<br>
 <br>
<br>
<br>
<br>
<br>
<br>

</body>
</html>