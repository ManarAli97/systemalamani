<script>

    // blur
    function setfocusInput() {

        $('.table_wholesale_price  input').on('click', function () {
         convertAcount=1
        });
        $('.table_wholesale_price  input').on('blur', function () {
            convertAcount=0
            $("#covertAcount").val('').select();
        })
    }

    $('.x_ox_number').on('click', function () {
        convertAcount=1
    });

    $('.x_ox_number').on('blur', function () {
        convertAcount=0
        $("#covertAcount").val('').select();
    });

    $('#validationTextarea-message').on('click', function () {
        convertAcount=1
    });

    $('#validationTextarea-message').on('blur', function () {
        convertAcount=0
        $("#covertAcount").val('').select();
    });

    $('#text_search_return').on('click', function () {
        convertAcount=1
    });

    $('#text_search_return').on('blur', function () {
        convertAcount=0
        $("#covertAcount").val('').select();
    });

    $('.box_notFound input').on('click', function () {
        convertAcount=1
    });

    $('.box_notFound input').on('blur', function () {
        convertAcount=0
        $("#covertAcount").val('').select();
    });

    $('.box_notFound textarea').on('click', function () {
        convertAcount=1
    });

    $('.box_notFound textarea').on('blur', function () {
        convertAcount=0
        $("#covertAcount").val('').select();
    });




    $('#catForSearch').on('focus', function () {
        convertAcount=1
    });

    $('#catForSearch').on('blur change', function () {
        convertAcount=0
        $("#covertAcount").val('').select();
    });


    $('#brand').on('focus', function () {
        convertAcount=1
    });

    $('#brand').on('blur change', function () {
        convertAcount=0
        $("#covertAcount").val('').select();
    });

    $('#nameDevice_public').on('focus', function () {
        convertAcount=1
    });

    $('#nameDevice_public').on('blur change', function () {
        convertAcount=0
        $("#covertAcount").val('').select();
    });

    $('#typeDevice_public').on('focus', function () {
        convertAcount=1
    });

    $('#typeDevice_public').on('blur change', function () {
        convertAcount=0
        $("#covertAcount").val('').select();
    });

    $('#type_cover').on('focus', function () {
        convertAcount=1
    });

    $('#type_cover').on('blur change', function () {
        convertAcount=0
        $("#covertAcount").val('').select();
    });

    $('#category_offer').on('focus', function () {
        convertAcount=1
    });

    $('#category_offer').on('blur change', function () {
        convertAcount=0
        $("#covertAcount").val('').select();
    });


    $('#exampleModal_qr').on('hidden.bs.modal', function (e) {
     convertAcount=0
    });




    $('#CatgFilter').on('focus', function () {
        convertAcount=1
    });

    $('#CatgFilter').on('blur change', function () {
        convertAcount=0
        $("#covertAcount").val('').select();
    });


    $('#idForm_range select').on('focus', function () {
        convertAcount=1
    });

    $('#idForm_range select').on('blur change', function () {
        convertAcount=0
        $("#covertAcount").val('').select();
    });




    $('#max_price').on('click', function () {
        convertAcount=1
    });

    $('#max_price').on('blur', function () {
        convertAcount=0
        $("#covertAcount").val('').select();
    });


    $('#min_price').on('click', function () {
        convertAcount=1
    });

    $('#min_price').on('blur', function () {
        convertAcount=0
        $("#covertAcount").val('').select();
    });



</script>


<a class="btn user_screen_fiexd" id="user_screen_fiexd"></a>

<style>

    .loading_filter img
    {
        width: 40px;
    }

    a#user_screen_fiexd {
        position: fixed;
        bottom: 0;
        left: 0;
        background: black;
        border-radius: 0;
        padding: 1px 12px;
        color: #fff;
        display: none;
    }

    .underSetting {
        bottom: 34px;
    }


    .text_price_dollar {
        border: 1px solid #eceaea;
        background: #edf6f9;
        margin: 0;
        font-size: 13px;
        justify-content: center;
        align-items: center;
        padding: 1px 7px;
        margin-top: 8px;
    }

</style>

<script>


    if ( localStorage.getItem("screen_user"))
    {
        $('#user_screen_fiexd').text(localStorage.getItem("screen_user")).show()
    }

</script>


<link rel="stylesheet" href="<?php echo $this->static_file_site ?>/circle/circle-menu.min2.css">
<script src="<?php echo $this->static_file_site ?>/circle/circleMenu.min.js"></script>

<nav class="c-circle-menu js-menu">
    <button class="c-circle-menu__toggle js-menu-toggle">
        <i class="fa fa-question"></i>
    </button>
    <ul class="c-circle-menu__items">

        <li class="c-circle-menu__item">
          
        </li>

        <li class="c-circle-menu__item">

            <a href="#" data-toggle="modal" data-target="#exampleModalQuestion" class="c-circle-menu__link">
                <i class="fa  fa-info"></i>
            </a>
        </li>

        <li class="c-circle-menu__item">
            <a href="<?php echo url ?>/contact" class="c-circle-menu__link">
                <i style="transform: rotate(-17deg);" class="fa fa-bullhorn"></i>
            </a>
        </li>

    </ul>
    <div class="c-circle-menu__mask js-menu-mask"></div>
</nav>
<script >
    var el = '.js-menu';
    var myMenu = cssCircleMenu(el);

</script>




<div id="hash"  class="btn underSetting">
   <img src="<?php echo $this->static_file_site ?>/image/site/hash.png">        جاري تطوير السوق الالكتروني و اضافة منتجات اكثر
</div>

<script>
    $(document).ready(function() {
        $('#hash').click(function() {
            $(this).toggleClass("downWth");
        });
    });

</script>








<div class="modal fade" id="exampleModalQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">  مرحبا زبوننا الكريم </h5>

            </div>
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="msgWelcome">
                            لا تتردد في السؤال الموظف جاهز للأجابة على جميع اسئلتكم.
                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="<?php echo $this->static_file_site ?>/image/site/q.png">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn   close_pop_order" data-dismiss="modal">خروج</button>
            </div>
        </div>
    </div>
</div>







<style>

    .end_offer_list {
        position: absolute;
        background: #283581;
        padding: 1px 13px;
        color: #fff;
        border-radius: 0 0 0 9px;
    }

	




    .request_order .col-auto
    {
        max-height: 200px;
        overflow: auto;
    }





    .stop_device {
        position: absolute;
        z-index: 1;
        background: #ff5722;
        right: 0;
        top: 0;
        color: white;
        padding: 0 5px;
        border-radius: 5px 0 0 5px;
    }


    .msgWelcome
    {
        font-weight: bold;
        text-align: center;
        line-height: 2;
        font-size: 21px;
    }

    .pricDevice {
        display: flex !important;
    }


    .downWth
    {
        width: 484px;
    }


    .zoomWindow{
        border: 4px solid rgb(60, 54, 54) !important;
        border-radius: 12px !important;
        z-index: 15000 !important;
    }
    .zoomLens {
        border: 1px solid red !important;
        border-radius: 5px;
    }

    @media (max-width: 360px) {

        .downWth
        {
          overflow: auto;
            font-size: 10px;
            width: 360px;

        }

        .zoomWindow{
            display: none;!important;
        }
        .zoomLens {
            display: none !important;
        }
        .zoomWindowContainer
        {
            display: none !important;
        }
    }


    .control_slider .carousel-control-next,.control_slider  .carousel-control-prev
    {
        z-index: unset;
    }

    .loading-image
    {
        height: 100px;
        width: 100%;
        text-align: center;
    }
    .loading-image img
    {
        height: 100px;
        text-align: center;
    }
    .end-record-info{
        border: 1px solid #d6d4d8;
        margin-top: 15px;
        padding: 5px;
        background: #e5e6e873;
    }


     .control_sort
     {
         background: #ffffff;
         margin-top: 10px;
         border: 1px solid #eff0f4;
     }

    .sort_class
    {
        box-shadow: none !important;
        outline: none !important;
    }
    .sort_class.active_btn
    {
        color: #ff5722;
    }




</style>


<div class="footer">

    <div class="bar_footer bg-light text-dark pt-5 pb-4">
        <div class="container">
            <div class="row justify-content-end align-items-center">
                <div class="col-auto d-none d-sm-block">
                    <div class="title_p_t  text-dark">
                        مواقع التواصل الاجتماعي
                    </div>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-5">
                    <div class="icon_social ">
                        <a href="<?php echo $this->setting->get('facebook') ?>"  class="btn btn_icon_social"> <i class="fa fa-facebook"></i> </a>
                        <a href="<?php echo $this->setting->get('instagram') ?>" class="btn btn_icon_social"> <i class="fa fa-instagram"></i> </a>
                        <a href="<?php echo $this->setting->get('telegram') ?>" class="btn btn_icon_social"> <i class="fa fa-send"></i> </a>
                        <a href="<?php echo $this->setting->get('youtube') ?>" class="btn btn_icon_social"> <i class="fa fa-youtube"></i> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bar_bottom_footer  bg-light">

        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-4  col-md-4 border_left">
                    <div class="logo_footer">
                        <img class="logo_site "  src="<?php echo $Img ?>">

                    </div>
                    <div class="copyright d-none d-sm-block">
                        <?php echo $this->setting->get('copyright') ?>
                    </div>
                </div>


                <div class="col-lg-5 col-md-8">

                    <div class="catg_footer">
                        <div class="row">

                          <?php  if ($this->thisCatg('mobile')) { ?>

                            <div class="col-6">
                                <a href="<?php echo  url  ?>/mobile/list_view" class="link_footer">  <i  style="font-size: 20px;" class="fa fa-mobile"></i>  <span> <?php echo $this->langSite('mobile') ?> </span>   </a>
                            </div>
						  <?php  }  ?>
							<?php  if ($this->thisCatg('accessories')) { ?>
                            <div class="col-6">
                                <a href="<?php echo  url  ?>/accessories/list_view" class="link_footer">   <i class="fa fa-diamond"></i>    <span> <?php echo $this->langSite('accessories') ?> </span>   </a>
                            </div>
							<?php  }  ?>

							<?php  if ($this->thisCatg('games')) { ?>
                            <div class="col-6">
                                <a href="<?php echo  url  ?>/games/list_view" class="link_footer">   <i class="fa fa-gamepad"></i>    <span> <?php echo $this->langSite('games') ?> </span>   </a>
                            </div>
							<?php  }  ?>

							<?php  if ($this->thisCatg('camera')) { ?>
                            <div class="col-6">
                                <a href="<?php echo  url  ?>/camera/list_view" class="link_footer">   <i class="fa fa-video-camera"></i>   <span> <?php echo $this->langSite('camera') ?> </span>   </a>
                            </div>
							<?php  }  ?>

							<?php  if ($this->thisCatg('printing_supplies')) { ?>
                            <div class="col-6">
                                <a href="<?php echo  url  ?>/printing_supplies/list_view" class="link_footer">   <i class="fa fa-print"></i>   <span> <?php echo $this->langSite('printing_supplies') ?> </span>   </a>
                            </div>
							<?php  }  ?>

							<?php  if ($this->thisCatg('computer')) { ?>
                            <div class="col-6">
                                <a href="<?php echo  url  ?>/computer/list_view" class="link_footer">   <i class="fa fa-laptop"></i>   <span> <?php echo $this->langSite('computer') ?> </span>   </a>
                            </div>
							<?php  }  ?>

							<?php  if ($this->thisCatg('network')) { ?>
                            <div class="col-6">
                                <a href="<?php echo  url  ?>/network/list_view" class="link_footer">   <i class="fa fa-wifi"></i>   <span> <?php echo $this->langSite('network') ?> </span>   </a>
                            </div>
							<?php  }  ?>
							<?php  if ($this->thisCatg('savers')) { ?>
                            <div class="col-6">
                                <a href="<?php echo  url  ?>/savers/list_view" class="link_footer">    <i class="fa fa-folder"></i>  <span> <?php echo $this->langSite('savers') ?> </span>   </a>
                            </div>
                            <?php  }  ?>
                          </div>


                        <hr>
                     <div class="row">
                         <?php foreach ($categorypages as $page_x) {   ?>
                            <div class="col-6">
                                <a href="<?php echo url ?>/pages/details/<?php echo $page_x['id'] ?>" class="link_footer">  <i  style="font-size: 7px;color: #28a745;"  class="fa fa-circle"></i>  <span><?php echo $page_x['title'] ?>  </span>   </a>
                            </div>

                           <?php  }  ?>

                        </div>


                    </div>



                </div>

                <div class="col-lg-3">
                    <div class="contact_us">
                    
                         <div class="infox">
                            <div class="row align-items-center">
                            	<div class="col-2 padding-y">
                                    <div class="icon_info">
                                        <i class="fa fa-suitcase"></i>
                                    </div>
                                </div>
  
                                <div class="col-10 padding-x">
                                    <a href="https://company.alamani.iq/document/view/document" target="_blank"> التقديم على وظيفة </a>
                                </div>
                               
                            </div>
                        </div>


                    
                    
                      <div class="infox">
                            <div class="row align-items-center">
                                <div class="col-2 padding-y">
                                    <div class="icon_info">
                                    <i class="fa fa-map-marker"></i>
                                    </div>
                                </div>


                                <div class="col-10 padding-x">
                                     <?php echo $this->setting->get('address') ?>
                                </div>
                            </div>
                        </div>
                    
                   
                    
                    
                    
                        <div class="infox">
                            <div class="row align-items-center">
                                <div class="col-2 padding-y">
                                    <div class="icon_info">
                                        <i class="fa fa-mobile"></i>
                                    </div>
                                </div>

                                <div class="col-10 padding-x" >
                                    <div style='font-size: 27px;'><span style='font-size: 18px;'> خدمة الزبائن</span> <?php echo $this->setting->get('number_phone_first') ?>  </div>
                                </div>
                            </div>
                        </div>

                       
                        <div class="infox">
                            <div class="row align-items-center">
                                <div class="col-2 padding-y">
                                    <div class="icon_info"  style='background-color: green'>
                                        <i class="fa fa-whatsapp"></i>
                                    </div>
                                </div>
                                <div class="col-10 padding-x" style='font-size: 18px;' >
                                  <div> <?php echo $this->setting->get('number_phone_second') ?> </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright2 d-block d-sm-none">
        <?php echo $this->setting->get('copyright') ?>
    </div>

</div>



<style>
    .xBoxG {
        padding: 0 11px;
        padding-left: 1px;
        border: 1px solid #e8e8e86b;
    }

    .xBoxG:nth-child(even) {
        padding: 0 11px;
        padding-right: 1px;
    }

    a.link_footer {
        margin: 8px 0;
        display: block;
        color: #283581;
        text-decoration: none;
        transition: 0.5s;
    }

    a.link_footer:hover {
        background: #283581;
        color: #ffff;
        padding: 0 10px;
        border-radius: 10px;
    }



    a.link_footer i {

        font-size: 14px;
    }


    .border_left
    {
        border-left: 1px solid #c8c9cb;
    }

    .copyright
    {
		font-size: 15px;
        padding-top: 21px;
        text-align: center;
        padding-bottom: 11px;
    }

    .copyright2
    {
     	background: #283581;
        padding: 20px 5px;
        text-align: center;
        color: #fff;
        font-size: 13px;
    	padding-bottom: 60px;
    

    }

    .logo_footer {
        padding:35px 0;
        border-bottom: 1px solid #c8c9cb;
        margin-bottom: 5px;
    }

    @media (max-width: 767px)  {

        .border_left
        {
            border-left: 0;

        }

        .logo_footer {

            padding: 19px 0;
            text-align: center;
			/* background: #d9dce1; */
            border-bottom:0 ;
        }

        .catg_footer {
            padding-right: 8px;
        }

        .logo_footer .logo_site {
            height: 57px;
            width: auto;
        }
    
      .contact_us {
           width: 100%;
        }


    }




    @media (max-width: 460px)  {
        .menu_category {
            margin-bottom: 2px;
        }
    }


    .image_mobile_show {
        margin-bottom: 20px;
    }


    .color_item_table {
        border: 1px solid #f2f2f2;
    }
    .contact_us {
        padding: 15px;
        height: 100%;
    }

    .infox
    {
        margin-bottom: 15px;
    }
    .infox  .padding-x
    {
        padding-right: 0;
    }
    .infox  .padding-y
    {
        padding-right: 0;
    }
    .infox .icon_info {
        text-align: center;
       width: 25px;
        height: 25px;
        font-size: 15px;
        border-radius: 50%;
        padding: 2px;
        background:#283581;
        color: #ffffff;
     	margin-right: 6px;
    }
    .bar_bottom_footer
    {

        background:#e5e6e8;
    }

    .title_p_t
    {
        color: #ffffff;
    }

    .bar_footer {
        background: #283581;
        min-height: 70px;
        padding: 8px 0;
       	border-top: 1px solid rgba(0,0,0,0.24);
		/*border-top-left-radius: 95px; */
        -webkit-box-shadow: 0px -3px 5px 0px rgba(0,0,0,0.20);
        -moz-box-shadow: 0px -4px 5px 0px rgba(0,0,0,0.75);
        box-shadow: 0px -3px 5px 0px rgba(0,0,0,0.20);
    }

 	@media (min-width: 640px)
   	 {
        .icon_social
        {
            margin-left:75px;
        }
    }

    .icon_social
    {
        text-align: center;
        padding: 8px 0;
    }
    a.btn.btn_icon_social {
       background: #283581;
       color: #ffffffed;
       border: 1px solid;
       border-radius: 50%;
    }

    a.btn.btn_icon_social:hover {
        color: #ffffffed;

    }

    .imageDevise img {

        object-fit: cover !important;
    }

    .image_mobile_show img.image_user {
        object-fit: cover !important;
    }




    .bast_device {
        background: #FF5722;
        position: absolute;
        padding: 1px 5px;
        color: #fff;
        z-index: 10;
        left: 0;
        top: 0;
    }


    .bast_device:after  {
        content:'';
        position: absolute;
        top: 0;
        width: 0;
        height: 0;
        z-index: 1;
    }
    .bast_device:after {
        left: 100%;
        border-top: 25px solid #FF5722;
        border-right: 10px solid transparent;
    }
    @media (max-width: 640px)
    {
        .style_btn_like_mb {
            width: 49%;
        }
    }

    .heddinSm {
        margin-top: 50px;
    }

    /*اخفاء القائمة الجانبية في عرض التفاصيل */
    @media (max-width: 991px)  {


        .heddinSm
        {
            display: none;
        }



    }


    .infoDevice
    {
        border: 0;
    }





</style>
<?php if (isset($_SESSION['username_member_r'])) { ?>
<?php   if ($msg==true)  {  ?>

        <div class="message">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-6 col-sm-12">

                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                       <?php  echo $note['note'] ?>  <a href="<?php  echo url ?>/register/edit"> من هنا </a>
                        <div class="removeNote">
                          <span> * لإلغاء الملاحظة يرجى الضغط مرتين على علامة </span>      <span> &times;</span>
                        </div>

                        <button type="button" onclick="close_msg_p()" class="close"  >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>


        <style>
            .message {
                position: fixed;
                bottom: 0;
                width: 100%;
                z-index: 1000000000000000000000;
            }
            .removeNote {
                font-size: 12px;
                border-top: 1px solid #989393;
                margin-top: 8px;
                padding-top: 5px;
                color: #000;
            }
        </style>

        <script>
            countxm=0;
            function close_msg_p() {
                countxm++;
                if (countxm === 2)
                {
                    $.get( "<?php  echo url ?>/register/close_msg_p", function( data ) {

                            $('.message').remove()

                    });
                }

            }
        </script>

<?php  } } ?>





<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $('body').tooltip({selector: '[data-toggle="tooltip"]'});

    });

</script>



<style>
    .icon_price_dollar {
        border: 1px solid;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #283581;
        margin: 0;
        color: #ffff;
        font-size: 17px;
        font-weight: bold;
        padding: 0;
        justify-content: center;
        align-items: center;
    }
    .icon_price_dollar:hover {

        color: #ffff;

    }
    .setting_range input
    {

        background: white;
        width: 57px !important;
        height: 26px;
        margin-bottom: 10px !important;

    }
    .setting_range .input-group-prepend
    {
        background: #eeeeee;
        height: 26px;
    }
    .setting_range .input-group-prepend .input-group-text
    {
        background: #eeeeee;
        height: 26px;
    }


    .sliderText{
        width:40%;
        margin-bottom:30px;
        border-bottom: 2px solid red;
        padding: 10px 0 10px 0px;
        font-weight:bold;
    }

    .ui-slider-horizontal {
        height: .6em;
    }

    .ui-widget-header {
        background: #283581;
    }

    .price-range-search {

        background-color: #f9f9f9;
        border: 1px solid #6e6666;
        min-width: 40%;
        display: inline-block;
        height: 32px;
        border-radius: 5px;
        float: right;
        margin-bottom:20px;
        font-size:16px;
    }

    .search-results-block{
        position: relative;
        display: block;
        clear: both;
    }

    .slider_range
    {
        padding-top: 0;
    }


    .over_qr
    {
        position: absolute;
        background: white;
        width: 0;
        overflow: hidden;
        height: 36px;
        display: flex;
        align-items: center;
        border-radius: 0 6px 4px 0;
        padding-top: 8px;
        top: 1px;
        right: 6px;
    }

    .error_qr
    {
        color: red;
    }
    .error_qr_login
    {
        color: red;
    }
    .readQrbtn
    {
        background: transparent;
        padding: 0;
        font-size: 24px;
        position: absolute;
        left: 0;
        box-shadow: unset !important;
    }

.q_0
{
    background: red;
    color: #ffffff;
    padding: 0 5px;
}

    .imageDevise
    {
        height: 283px;
        max-width: 100%;
    }
 .setting_range input {
        background: #fff;
        width: 76px!important;
        height: 39px;
        margin-bottom: 10px!important;
    }

    .setting_range .input-group-prepend .input-group-text {
        background: #eee;
        height: 39px;
    }
</style>

<script>


    function numberOnly(e)
    {
        valu=$(e).val();
        $(e).val(valu.replace(/\D/g, ""));
    }


    $("#slider-range").slider({
        range: true,
        orientation: "horizontal",
        min: 0,
        max: 2000,
        values: [0, 2000],
        step: 1,

        slide: function (event, ui) {
            if (ui.values[0] == ui.values[1]) {
                return false;
            }

            $("#min_price").val(ui.values[0]);
            $("#max_price").val(ui.values[1]);
        }
    });


    function get_dollar_price(e,price) {



        $.get( "<?php  echo url   ?>/dollar_price/dollar_price_convert",{price:price}, function( data ) {

            $(e).tooltip('hide')
                .attr('data-original-title', data)
                .tooltip('show');
        });


    }

</script>


<style>

    /*
    css update

    wholesale_price
    wholesale_price2
    cost_price
     */
    .infoDevice .hoverBtn
    {

        height: 100%;

    }

    .infoDevice a{
        position: relative;
        display: block;
        overflow: hidden;
        text-decoration: none !important;
         color: black !important;
    }

    .table_wholesale_price {
        text-align: center;
        font-size: 13px;
    }

    .add_type_price
    {
        background: #bcd4e6;
        font-size: 12px;
        color: #000;
        font-weight: bold;
    }
    .table_wholesale_price td  {
        border: 1px solid #dee2e6;
        vertical-align: middle;
        padding: 3px 0;
    }

</style>


<?php   if (isset($_SESSION['loggedIn'])) {   ?>
<!-- Button trigger modal -->
<button onclick="writeNoteAboutCustomer()" type="button" class="btn writeNote"  data-toggle="tooltip" data-placement="top" title="كتابة ملاحظة حول الزبون">
    <i class="fa fa-pencil"></i>
</button>

<style>

    .writeNote
    {
        background: #cddc39;
        position: fixed;
        bottom: 82px;
        left: 18px;
        padding: 0;
        font-size: 22px;
        width: 37px;
        height: 37px;
        border-radius: 50%;
    }

    .list_name {
        position: absolute;
        z-index: 1000;
        width: 100%;
        border: 1px solid #cec8c8;
        box-shadow: 5px 4px 6px 0px #0000003b;
        display: none;
        height: 300px;
        overflow: auto;
        background: #FFFFFF;
    }
</style>
<div class="modal fade" id="ModalwriteNoteAboutCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">كتابة ملاحظة حول الزبون</h5>

            </div>
            <form id="formNote_custom" action="<?php echo url ?>/note_user/save_note" method="post">
                <div class="modal-body">
                    <div class="mb-3" style="position: relative">
                        <label>ابحث عن اسم الزبون او رقم الهاتف</label>
                        <input  type="text" oninput="search_customer_note()"   id="name_custom_get" class=" form-control" name="name" placeholder="ابحث عن اسم الزبون او رقم الهاتف"   autocomplete="off" required>
                        <div class="list_name"></div>
                    </div>
                    <input type="hidden" name="id" id="id_custom_get">

                    <div>
                        <label>ملاحظة</label>
                        <textarea name="note" rows="3" id="note_custom_get" class="form-control" required></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">حفظ</button>
                    <button type="button" class="btn btn-danger" onclick="empty_fild()" data-dismiss="modal">خروج</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

    function writeNoteAboutCustomer() {
        $('#ModalwriteNoteAboutCustomer').modal('show')
    }


    function search_customer_note() {

        if ($('#name_custom_get').val())
        {
            $.get( "<?php  echo url  ?>/customers/name",{name:$('#name_custom_get').val()}, function( data ) {
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


    $("#name_custom_get").focusout(function(){
        setTimeout(function () {
            $('.list_name').hide()

        },500)
    });

    function print_name(e,id) {
        $('#name_custom_get').val($(e).text())
        $('#id_custom_get').val(id)
        $('.list_name').hide().empty()
    }

    function empty_fild() {
        $('#name_custom_get').val('')
        $('#id_custom_get').val('')
        $('#note_custom_get').val('')
    }
    $("#formNote_custom").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var actionUrl = form.attr('action');
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {
                console.log(data)
                empty_fild()
                $('#ModalwriteNoteAboutCustomer').modal('hide')
            }
        });

    });
</script>
<?php } ?>

<script src="<?php echo $this->static_file_site ?>/swiper/swiper.min.js"></script>
<script type="text/javascript" src="<?php echo $this->static_file_site ?>/range_input2/jquery.range.js"></script>


</body>
</html>