<div class="container">


    <div class="row">
        <div class="col-lg-3">
            <?php    $this->menu->menu() ?>
        </div>

        <div class="col-lg-9">
            <div class="slider_product">


                <script src="<?php echo $this->static_file_control ?>/js/jquery.touchSwipe.min.js"></script>
                <div id="carouselExampleControls" class="carousel slide " data-ride="carousel">

                    <ol class="carousel-indicators" id="control_slider">
                        <?php  foreach ($gallery as $key=> $g_m) {  ?>
                        <li data-target="#carouselExampleControls" data-slide-to="<?php echo $key ?>"  class="<?php if ($key==0)  echo 'active'?>"></li>
                      <?php  } ?>
                    </ol>

                    <div class="carousel-inner" role="listbox">

                        <?php  foreach ($gallery as $key=> $g_m) {  ?>
                        <div class="carousel-item <?php  if ($key==0)  echo 'active' ?> " style="position: relative">
                            <?php  if (!empty($g_m['url']))  {   ?>
                            <a href="<?php echo $g_m['url'] ?>" class="btn url_image">
                                شاهد الكثير
                             </a>
                            <?php  }  ?>
                            <img class="d-block w-100" src="<?php echo $g_m['image'] ?>" alt="First slide">
                        </div>
                        <?php  } ?>

                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>




            </div>
        </div>


    </div>


    <style>
        a.url_image {
            position: absolute;
            right: 37px;
            bottom: 37px;
            z-index: 5;
            background: #ffb401e6;
            color: #ffff;
            border-radius: 0;
            box-shadow: 3px 6px 0 0 #ffffff;
        }

        @media  (max-width: 460px){
                a.url_image {
                    right: 10px;
                    bottom: 10px;
                    padding: 1px 5px;
                    font-size: 12px;
                }
        }
        .carousel-item
        {
            transition: -webkit-transform .3s ease-in-out !important;
            transition: transform .3s ease-in-out !important;
            transition: transform .3s ease-in-out, -webkit-transform .3s ease-in-out !important;
        }

        #control_slider {
            padding: 0;
            margin: 0;
            bottom: 5px;
        }

        #control_slider li{
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid transparent;
        }

        @media (max-width: 460px) {

            #control_slider li {
                width: 10px;
                height: 10px;
            }
            #control_slider {
                bottom: 1px;
            }
        }


    </style>

    <br>



            <div class="row">
                    <?php  foreach ($ads_content as $key => $ads) {  ?>

                        <?php  if ($key <    2) {  ?>

                            <div class="col-lg-6">
                                <div class="big_img_">
                                    <a href="<?php  echo $ads['link']?>">
                                    <img src="<?php  echo $ads['img']?>">
                                    </a>
                                </div>
                         </div>

                        <?php  } else {   ?>
                        <div class="col-lg-4">
                          <div class="small_image">
                              <a href="<?php  echo $ads['link']?>">
                              <img src="<?php  echo $ads['img']?>">
                              </a>
                          </div>

                        </div>

                        <?php  }  ?>
                   <?php  }  ?>
            </div>




<br>
<br>

    <style>

        .titleCatSm
        {
            display: none;
            margin-bottom: 12px;
        }
        @media (max-width: 770px) {

            .titleCatSm
            {
                display: block;

            }
             .titleCatSm  div
            {

                border-bottom: 2px solid #495678;
                 padding: 0 15px;
            }

            .tab_cat_device .justify-content-end
            {
                margin-bottom: 42px;
                justify-content: flex-start !important;
            }
            .titleCatLg
            {
                display: block;
                opacity: 0;
            }

        }

    </style>



            <div class="row justify-content-end">

                <div class="col-12  titleCatSm">
                   <div > موبايلات</div>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-12  tab_cat_device">

                    <ul class="nav tabDoor nav-tabs justify-content-end" id="myTab" role="tablist">

                        <?php foreach ($category_mobile as $key => $cat_tab)   {  ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($key==0) echo 'active' ?> " id="mobile-tab_<?php echo $cat_tab['id']?>" data-toggle="tab" href="#mobileCat_<?php echo $cat_tab['id']?>" role="tab" aria-controls="home" aria-selected="true"><?php echo $cat_tab['title']?></a>
                        </li>
                        <?php } ?>


                    </ul>

                </div>

                <div class="col-12">

                    <div class="tab-content contentTabPhoneModel" id="myTabContent">
                        <?php foreach ($category_mobile as $key => $cat_tab) {   ?>

                        <div class="tab-pane  <?php if ($key==0) echo 'show active' ?>  " id="mobileCat_<?php echo $cat_tab['id']?>" role="tabpanel" aria-labelledby="mobile-tab_<?php echo $cat_tab['id']?>">

                            <div class="phoneModel">

                                <div class="control_slider">
                                    <div class="row">
                                        <div class="col-auto border" style="width: 50px">
                                            <a class="carousel-control-prev row_prev" href="#carouselExampleControlsPhone-<?php echo $cat_tab['id']?>" role="button" data-slide="prev">
                                                <i class="fa fa-chevron-left"></i>
                                            </a>
                                            <a class="carousel-control-next row_next" href="#carouselExampleControlsPhone-<?php echo $cat_tab['id']?>" role="button" data-slide="next">
                                                <i class="fa fa-chevron-right"></i>
                                            </a>

                                        </div>

                                        <div class="col-auto  titleCatLg">
                                        موبايلات
                                        </div>
                                    </div>
                                </div>

                                <div id="carouselExampleControlsPhone-<?php echo $cat_tab['id']?>" class="carousel slide" data-ride="carousel" >
                                <div class="carousel-inner" role="listbox">

                                    <?php  foreach ($cat_tab['content'] as $index=> $content) { ?>
                                    <div class="carousel-item  <?php if ($index==0) echo 'active' ?>  ">
                                        <div class="row">

                                            <?php  foreach ($content as $printContent)  { ?>

                                            <div class="col-lg-3 col-md-4 col-sm-6 col-6 xBoxG">

                                                <div  class="infoDevice">


                                                    <?php  if ($printContent['bast_it'] == 1 ) { ?>
                                                        <div class="bast_device">
                                                            <?php echo $this->langSite('bast_it') ?>
                                                        </div>

                                                       <?php } ?>


                                                    <a href="<?php echo url ?>/mobile/details/<?php echo $printContent['id'] ?>"  >
                                                        <div class="hoverBtn">
                                                            <button class="btn"><i class="fa fa-search"></i> </button>
                                                        </div>
                                                    <div class="imageDevise">
                                                        <img   src="<?php echo $printContent['image'] ?>" alt="لا توجد صورة">

                                                        <?php  if ($printContent['cuts'] == 1 ) { ?>
                                                            <div class="price_cuts_note">
                                                                <?php echo $this->langSite('price_cuts') ?>
                                                            </div>

                                                        <?php } ?>
                                                    </div>
                                                    </a>

                                                    <div class="nameDevice">
                                                        <?php echo $printContent['title'] ?>

                                                    </div>
                                                    <textarea  disabled class="form-control description"><?php echo $printContent['description'] ?></textarea>
                                                    <?php  if ($printContent['cuts'] == 1 ) { ?>
                                                        <div class="pricDevice" style="display: block">
<!--                                                            <div class="oldXPrice" style="text-decoration: line-through;">--><?php //echo $printContent['price'] ?><!-- </div>-->
                                                             <div class="price_cuts" style="color: green;font-weight: bold"> <?php echo $printContent['price_cuts'] ?> د.ع   </div>
                                                           </div>
                                                        <?php  } else{ ?>
                                                           <div class="pricDevice" >
                                                            <?php echo $printContent['price'] ?>
                                                          </div>
                                                        <?php } ?>



                                                    <div class="c_device">
                                                        <div class="addedToCart_mobile<?php echo $printContent['id'] ?>"></div>

                                                        <div class="row align-items-center justify-content-center">

                                                            <div class="col-lg-7 col-md-7 col-sm-12  xcartp"  >

                                                                <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>


                                                                    <?php if ($this->phone=='true' || $this->isDirect()) {   ?>

                                                                        <button type="button" class="btn btn_cart" onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['size'] ?>','<?php echo $printContent['priceC'] ?>','<?php echo $printContent['nameImage'] ?>','<?php echo $printContent['code_color'] ?>','<?php echo $printContent['code'] ?>')">
                                                                            <span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
                                                                        </button>
                                                                        <?php  }else{   ?>

                                                                        <button type="button" class="btn btn_cart"    data-toggle="modal" data-target="#add_phone">
                                                                            <span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
                                                                        </button>

                                                                         <?php  }  ?>
                                                                <?php } else { ?>

                                                                    <button type="button" class="btn btn_cart"    data-toggle="modal" data-target="#login_site">
                                                                        <span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
                                                                    </button>

                                                                <?php } ?>


                                                            </div>
                                                            <div class="col-lg-5 col-md-5 col-sm-12">
                                                                <?php if (isset($_SESSION['username_member_r'])) { ?>

                                                                    <button   type="button" class="btn btn_like  style_btn_like_mb  L_<?php echo $printContent['id']  ?> <?php  if ($printContent['like']) echo 'unlike'; else echo  'like' ?>"  onclick=<?php  if ($printContent['like']) echo "unlike_d(".$printContent['id'].",'mobile')"; else echo "like_d(".$printContent['id'].",'mobile')" ?>   >
                                                                        <i class="fa fa-heart"></i>
                                                                    </button>

                                                                    <button  title="اضافة المنتج الى خانة المقارنة بين المنتجات"  type="button" class="btn comparison comp_<?php echo $printContent['id']  ?> <?php  if ($printContent['comparison']) echo 'un_comparison'; else echo  'comparison' ?>"  onclick=<?php  if ($printContent['comparison']) echo "un_comparison_d(".$printContent['id'].",'mobile')"; else echo "comparison_d(".$printContent['id'].",'mobile')" ?>   >
                                                                        <i class="fa fa-exchange"></i>
                                                                    </button>
                                                                <?php } else { ?>

                                                                    <button type="button" class="btn btn_like  style_btn_like_mb "   data-toggle="modal" data-target="#login_site">
                                                                        <i class="fa fa-heart"></i>
                                                                    </button>
                                                                    <button  type="button" class="btn comparison"   data-toggle="modal" data-target="#login_site">
                                                                        <i class="fa fa-exchange"></i>
                                                                    </button>
                                                                <?php } ?>

                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                            <?php   } ?>
                                        </div>
                                    </div>

                                    <?php   } ?>


                                </div>

                              </div>
                            </div>

                        </div>
                        <?php  } ?>

                    </div>

                </div>


            </div>






    <script>


        function  comparison_d(id) {

            $('.comp_'+id).attr('onclick','un_comparison_d('+id+')');
            $('.comp_'+id).addClass('un_comparison');

            $.get('<?php echo url ?>/mobile/comparison_d/'+id, function(data){
                if (data !=='done')
                {
                    alert("Error")
                }

            });
        }


        function  un_comparison_d (id) {

            $('.comp_'+id).attr('onclick','comparison_d('+id+')');
            $('.comp_'+id).removeClass('un_comparison');

            $.get('<?php echo url ?>/mobile/un_comparison_d/'+id, function(data){
                if (data !=='done')
                {
                    alert("Error")
                }

            });
        }





        function  like_d(id,model) {

            $.get('<?php echo url ?>/'+model+'/like_d/'+id, function(data){
                if (data==='done')
                {

                    $('.L_'+id).attr('onclick','unlike_d('+id+',"'+model+'")');
                    $('.L_'+id).addClass('unlike');
                    $('.L_'+id).removeClass('like');
                }else
                {
                    alert("Error")
                }

            });
        }


        function  unlike_d (id,model) {

            $.get('<?php echo url ?>/'+model+'/unlike_d/'+id, function(data){
                if (data==='done')
                {
                    $('.L_'+id).attr('onclick','like_d('+id+',"'+model+'")');
                    $('.L_'+id).removeClass('unlike');

                }else
                {
                    alert("Error")
                }

            });
        }



        function addToCart(id,size,price,nameImage,code_color,code) {

            var  dataD={'id_item':id,'size':size,'price':price,'image':nameImage,'color':code_color,'code':code};

            $.get('<?php echo url ?>/mobile/cart_order', { jsonData: JSON.stringify( dataD )}, function(data){
                if (data !=='finish')
                {
                    $.get("<?php echo url ?>/mobile/count_c" , function(e) {
                        $('span.count_item').text(e);
                    });
                    $('.addedToCart_mobile'+id).html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa fa-check-circle"> </i>  <span> تمت الاضافة  </span>
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                           </button>
                                     </div>`);
                        $('.button_buy').css('display','block');
                    $('.empty_car').css('display','none');
                    $('.item_cat').html(data);
                    setTimeout(function(){
                        $('.addedToCart_mobile'+id).empty();
                    }, 4000);

                }else
                {
                    alert('نفذت الكمية')
                }
            });

        }

        function addToCart_camera(id,size,price,nameImage,code_color,code) {

            var  dataD={'id_item':id,'size':size,'price':price,'image':nameImage,'color':code_color,'code':code};

            $.get('<?php echo url ?>/camera/cart_order', { jsonData: JSON.stringify( dataD )}, function(data){
                if (data !=='finish')
                {
                    $.get("<?php echo url ?>/camera/count_c" , function(e) {
                        $('span.count_item').text(e);
                    });
                    $('.addedToCart_camera'+id).html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa fa-check-circle"> </i>  <span> تمت الاضافة  </span>
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                           </button>
                                     </div>`);
                        $('.button_buy').css('display','block');
                    $('.empty_car').css('display','none');
                    $('.item_cat').html(data);
                    setTimeout(function(){
                        $('.addedToCart_camera'+id).empty();
                    }, 4000);

                }else
                {
                    alert('نفذت الكمية')
                }
            });

        }

        function addToCart_games(id,size,price,nameImage,code_color,code) {

            var  dataD={'id_item':id,'size':size,'price':price,'image':nameImage,'color':code_color,'code':code};

            $.get('<?php echo url ?>/games/cart_order', { jsonData: JSON.stringify( dataD )}, function(data){
                if (data !=='finish')
                {
                    $.get("<?php echo url ?>/games/count_c" , function(e) {
                        $('span.count_item').text(e);
                    });
                    $('.addedToCart_games'+id).html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa fa-check-circle"> </i>  <span> تمت الاضافة  </span>
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                           </button>
                                     </div>`);
                        $('.button_buy').css('display','block');
                    $('.empty_car').css('display','none');
                    $('.item_cat').html(data);
                    setTimeout(function(){
                        $('.addedToCart_games'+id).empty();
                    }, 4000);

                }else
                {
                    alert('نفذت الكمية')
                }
            });

        }

        function addToCart_network(id,size,price,nameImage,code_color,code) {

            var  dataD={'id_item':id,'size':size,'price':price,'image':nameImage,'color':code_color,'code':code};

            $.get('<?php echo url ?>/network/cart_order', { jsonData: JSON.stringify( dataD )}, function(data){
                if (data !=='finish')
                {
                    $.get("<?php echo url ?>/network/count_c" , function(e) {
                        $('span.count_item').text(e);
                    });
                    $('.addedToCart_network'+id).html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa fa-check-circle"> </i>  <span> تمت الاضافة  </span>
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                           </button>
                                     </div>`);
                        $('.button_buy').css('display','block');
                    $('.empty_car').css('display','none');
                    $('.item_cat').html(data);
                    setTimeout(function(){
                        $('.addedToCart_network'+id).empty();
                    }, 4000);

                }else
                {
                    alert('نفذت الكمية')
                }
            });

        }


        function addToCart_acce(id,price,nameImage,code_color,code) {

            var  dataD={'id_item':id,'price':price,'image':nameImage,'color':code_color,'code':code};

            $.get('<?php echo url ?>/accessories/cart_order', { jsonData: JSON.stringify( dataD )}, function(data){
                if (data !=='finish')
                {
                    $.get("<?php echo url ?>/accessories/count_c" , function(e) {
                        $('.count_item_cartShow').text(e);

                    });
                    $('.addedToCart_acc'+id).html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa fa-check-circle"> </i>  <span> تمت الاضافة  </span>
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                           </button>
                                     </div>`);
                        $('.button_buy').css('display','block');
                    $('.empty_car').css('display','none');
                    $('.item_cat').html(data);
                    setTimeout(function(){
                        $('.addedToCart_acc'+id).empty();
                    }, 4000);

                }else
                {
                    alert('نفذت الكمية')
                }
            });

        }



    </script>


<br>
<br>

    <div class="row">
        <div class="col-12">


            <div id="carouselExampleControlsOffers" class="carousel slide  carousel-fade" data-ride="carousel">
                <div class="carousel-inner" role="listbox">

                <?php  foreach ($offers_content as $key => $o_content) {  ?>
                    <div class="carousel-item <?php  if ($key==0) echo 'active'?> ">
                        <div class="image_offers">
                            <img src="<?php echo $o_content['img']?>">
                        </div>
                    </div>
                  <?php  }  ?>

                </div>
            </div>




            <br>
            <br>

            <div class="row justify-content-end">

                <div class="col-12  titleCatSm">
                    <div >  اكسسورات منوعة </div>
                </div>

                <div class="col-lg-10 col-md-10 col-sm-12  tab_cat_device">

                    <ul class="nav tabDoor nav-tabs justify-content-end" id="myTab_accessories" role="tablist">
                        <?php foreach ($category_accessories as $key => $cat_tab)   {  ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($key==0) echo 'active' ?> " id="mobile-tab_accessories_<?php echo $cat_tab['id']?>" data-toggle="tab" href="#tab_accessories_Cat_<?php echo $cat_tab['id']?>" role="tab" aria-controls="home" aria-selected="true"><?php echo $cat_tab['title']?></a>
                            </li>
                        <?php } ?>

                    </ul>

                </div>

                <div class="col-12">

                    <div class="tab-content contentTabPhoneModel" id="myTabContent_accessories">
                        <?php foreach ($category_accessories as $key => $cat_tab) {   ?>

                            <div class="tab-pane  <?php if ($key==0) echo 'show active' ?>  " id="tab_accessories_Cat_<?php echo $cat_tab['id']?>" role="tabpanel" aria-labelledby="mobile-tab_accessories_<?php echo $cat_tab['id']?>">

                                <div class="phoneModel">

                                    <div class="control_slider">
                                        <div class="row">
                                            <div class="col-auto border" style="width: 50px">
                                                <a class="carousel-control-prev row_prev" href="#carouselExampleControlsAccessories-<?php echo $cat_tab['id']?>" role="button" data-slide="prev">
                                                    <i class="fa fa-chevron-left"></i>
                                                </a>
                                                <a class="carousel-control-next row_next" href="#carouselExampleControlsAccessories-<?php echo $cat_tab['id']?>" role="button" data-slide="next">
                                                    <i class="fa fa-chevron-right"></i>
                                                </a>

                                            </div>

                                            <div class="col-auto titleCatLg ">
                                               اكسسورات منوعة
                                            </div>
                                        </div>
                                    </div>

                                    <div id="carouselExampleControlsAccessories-<?php echo $cat_tab['id']?>" class="carousel slide" data-ride="carousel" >
                                        <div class="carousel-inner" role="listbox">

                                            <?php  foreach ($cat_tab['content'] as $index=> $content) { ?>
                                                <div class="carousel-item  <?php if ($index==0) echo 'active' ?>  ">
                                                    <div class="row">

                                                        <?php  foreach ($content as $printContent)  { ?>

                                                            <div class="col-lg-3 col-md-4 col-sm-6 col-6 xBoxG">

                                                                <div  class="infoDevice">
                                                                    <?php  if ($printContent['bast_it'] == 1 ) { ?>
                                        <div class="bast_device">
                                            <?php echo $this->langSite('bast_it') ?>
                                        </div>

                                    <?php } ?>

                                                                    <a href="<?php echo url ?>/accessories/details/<?php echo $printContent['id'] ?>"  >
                                                                    <div class="hoverBtn">
                                                                        <button class="btn"><i class="fa fa-search"></i> </button>
                                                                    </div>

                                                                    </a>
                                                                    <div class="imageDevise">

                                                                        <img   src="<?php echo $printContent['image'] ?>" alt="لا توجد صورة">
                                                                        <?php  if ($printContent['cuts'] == 1 ) { ?>
                                                                            <div class="price_cuts_note">
                                                                                <?php echo $this->langSite('price_cuts') ?>
                                                                            </div>

                                                                        <?php } ?>
                                                                    </div>


                                                                    <div class="nameDevice">
                                                                        <?php echo $printContent['title'] ?>

                                                                    </div>
                                                                    <?php  if ($printContent['cuts'] == 1 ) { ?>
                                                                        <div class="pricDevice" style="display: block">
<!--                                                                            <div class="oldXPrice" style="text-decoration: line-through;">--><?php //echo $printContent['price'] ?><!-- </div>-->
                                                                            <div class="price_cuts" style="color: green;font-weight: bold"> <?php echo $printContent['price_cuts'] ?> د.ع   </div>
                                                                        </div>
                                                                    <?php  } else{ ?>
                                                                        <div class="pricDevice" >
                                                                            <?php echo $printContent['price'] ?>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <div class="c_device">
                                                                        <div class="addedToCart_acc<?php echo $printContent['id'] ?>"></div>

                                                                        <div class="row align-items-center justify-content-center">

                                                                            <div class="col-lg-8 col-md-8 col-sm-auto  xcartp"  >

                                                                                <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>
                                                                                    <?php if ($this->phone=='true' || $this->isDirect()) {   ?>
                                                                                    <button type="button" class="btn btn_cart" onclick="addToCart_acce(<?php echo $printContent['id'] ?>,'<?php echo $printContent['priceC'] ?>','<?php echo $printContent['nameImage'] ?>','<?php echo $printContent['code_color'] ?>','<?php echo $printContent['code'] ?>')">
                                                                                        <span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
                                                                                    </button>
                                                                                <?php  }else{   ?>

                                                                                    <button type="button" class="btn btn_cart"    data-toggle="modal" data-target="#add_phone">
                                                                                        <span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
                                                                                    </button>

                                                                                <?php  }  ?>
                                                                                <?php } else { ?>

                                                                                    <button type="button" class="btn btn_cart"    data-toggle="modal" data-target="#login_site">
                                                                                        <span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
                                                                                    </button>

                                                                                <?php } ?>


                                                                            </div>
                                                                            <div class="col-lg-3 col-md-3 col-sm-auto ">
                                                                                <?php if (isset($_SESSION['username_member_r'])) { ?>

                                                                                    <button   type="button" class="btn btn_like    L_<?php echo $printContent['id']  ?> <?php  if ($printContent['like']) echo 'unlike'; else echo  'like' ?>"  onclick=<?php  if ($printContent['like']) echo "unlike_d(".$printContent['id'].",'accessories')"; else echo "like_d(".$printContent['id'].",'accessories')" ?>   >
                                                                                        <i class="fa fa-heart"></i>
                                                                                    </button>

                                                                                <?php } else { ?>

                                                                                    <button type="button" class="btn btn_like   "   data-toggle="modal" data-target="#login_site">
                                                                                        <i class="fa fa-heart"></i>
                                                                                    </button>

                                                                                <?php } ?>

                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        <?php   } ?>
                                                    </div>
                                                </div>

                                            <?php   } ?>


                                        </div>

                                    </div>
                                </div>

                            </div>
                        <?php  } ?>

                    </div>

                </div>


            </div>


<br>
<br>




            <div class="row justify-content-end">

                <div class="col-12  titleCatSm">
                    <div >  <?php echo $this->langSite('camera') ?> </div>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-12  tab_cat_device">

                    <ul class="nav tabDoor nav-tabs justify-content-end" id="myTab" role="tablist">

                        <?php foreach ($category_camera as $key => $cat_tab)   {  ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($key==0) echo 'active' ?> " id="camera-tab_<?php echo $cat_tab['id']?>" data-toggle="tab" href="#cameraCat_<?php echo $cat_tab['id']?>" role="tab" aria-controls="home" aria-selected="true"><?php echo $cat_tab['title']?></a>
                            </li>
                        <?php } ?>


                    </ul>

                </div>

                <div class="col-12">

                    <div class="tab-content contentTabPhoneModel" id="myTabContent">
                        <?php foreach ($category_camera as $key => $cat_tab) {   ?>

                            <div class="tab-pane  <?php if ($key==0) echo 'show active' ?>  " id="cameraCat_<?php echo $cat_tab['id']?>" role="tabpanel" aria-labelledby="camera-tab_<?php echo $cat_tab['id']?>">

                                <div class="phoneModel">

                                    <div class="control_slider">
                                        <div class="row">
                                            <div class="col-auto border" style="width: 50px">
                                                <a class="carousel-control-prev row_prev" href="#carouselExampleControlsPhone-<?php echo $cat_tab['id']?>" role="button" data-slide="prev">
                                                    <i class="fa fa-chevron-left"></i>
                                                </a>
                                                <a class="carousel-control-next row_next" href="#carouselExampleControlsPhone-<?php echo $cat_tab['id']?>" role="button" data-slide="next">
                                                    <i class="fa fa-chevron-right"></i>
                                                </a>

                                            </div>

                                            <div class="col-auto  titleCatLg">
                                                <?php echo $this->langSite('camera') ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="carouselExampleControlsPhone-<?php echo $cat_tab['id']?>" class="carousel slide" data-ride="carousel" >
                                        <div class="carousel-inner" role="listbox">

                                            <?php  foreach ($cat_tab['content'] as $index=> $content) { ?>
                                                <div class="carousel-item  <?php if ($index==0) echo 'active' ?>  ">
                                                    <div class="row">

                                                        <?php  foreach ($content as $printContent)  { ?>

                                                            <div class="col-lg-3 col-md-4 col-sm-6 col-6 xBoxG">

                                                                <div  class="infoDevice">
                                                                    <?php  if ($printContent['bast_it'] == 1 ) { ?>
                                        <div class="bast_device">
                                            <?php echo $this->langSite('bast_it') ?>
                                        </div>

                                    <?php } ?>

                                                                    <a href="<?php echo url ?>/camera/details/<?php echo $printContent['id'] ?>"  >
                                                                        <div class="hoverBtn">
                                                                            <button class="btn"><i class="fa fa-search"></i> </button>
                                                                        </div>
                                                                        <div class="imageDevise">
                                                                            <img   src="<?php echo $printContent['image'] ?>" alt="لا توجد صورة">
                                                                            <?php  if ($printContent['cuts'] == 1 ) { ?>
                                                                                <div class="price_cuts_note">
                                                                                    <?php echo $this->langSite('price_cuts') ?>
                                                                                </div>

                                                                            <?php } ?>
                                                                        </div>
                                                                    </a>

                                                                    <div class="nameDevice">
                                                                        <?php echo $printContent['title'] ?>

                                                                    </div>
                                                                    <?php  if ($printContent['cuts'] == 1 ) { ?>
                                                                        <div class="pricDevice" style="display: block">
<!--                                                                            <div class="oldXPrice" style="text-decoration: line-through;">--><?php //echo $printContent['price'] ?><!-- </div>-->
                                                                            <div class="price_cuts" style="color: green;font-weight: bold"> <?php echo $printContent['price_cuts'] ?> د.ع   </div>
                                                                        </div>
                                                                    <?php  } else{ ?>
                                                                        <div class="pricDevice" >
                                                                            <?php echo $printContent['price'] ?>
                                                                        </div>
                                                                    <?php } ?>

                                                                    <div class="c_device">
                                                                        <div class="addedToCart_camera<?php echo $printContent['id'] ?>"></div>

                                                                        <div class="row align-items-center justify-content-center">

                                                                            <div class="col-lg-8 col-md-8 col-sm-auto  xcartp"  >

                                                                                <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>


                                                                                    <?php if ($this->phone=='true' || $this->isDirect()) {   ?>

                                                                                        <button type="button" class="btn btn_cart" onclick="addToCart_camera(<?php echo $printContent['id'] ?>,'<?php echo $printContent['size'] ?>','<?php echo $printContent['priceC'] ?>','<?php echo $printContent['nameImage'] ?>','<?php echo $printContent['code_color'] ?>','<?php echo $printContent['code'] ?>')">
                                                                                            <span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
                                                                                        </button>
                                                                                    <?php  }else{   ?>

                                                                                        <button type="button" class="btn btn_cart"    data-toggle="modal" data-target="#add_phone">
                                                                                            <span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
                                                                                        </button>

                                                                                    <?php  }  ?>
                                                                                <?php } else { ?>

                                                                                    <button type="button" class="btn btn_cart"    data-toggle="modal" data-target="#login_site">
                                                                                        <span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
                                                                                    </button>

                                                                                <?php } ?>


                                                                            </div>
                                                                            <div class="col-lg-3 col-md-3 col-sm-auto">
                                                                                <?php if (isset($_SESSION['username_member_r'])) { ?>

                                                                                    <button   type="button" class="btn btn_like    L_<?php echo $printContent['id']  ?> <?php  if ($printContent['like']) echo 'unlike'; else echo  'like' ?>"  onclick=<?php  if ($printContent['like']) echo "unlike_d(".$printContent['id'].",'camera')"; else echo "like_d(".$printContent['id'].",'camera')" ?>   >
                                                                                        <i class="fa fa-heart"></i>
                                                                                    </button>

                                                                                <?php } else { ?>

                                                                                    <button type="button" class="btn btn_like   "   data-toggle="modal" data-target="#login_site">
                                                                                        <i class="fa fa-heart"></i>
                                                                                    </button>

                                                                                <?php } ?>

                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        <?php   } ?>
                                                    </div>
                                                </div>

                                            <?php   } ?>


                                        </div>

                                    </div>
                                </div>

                            </div>
                        <?php  } ?>

                    </div>

                </div>


            </div>




<br>
<br>




            <div class="row justify-content-end">

                <div class="col-12  titleCatSm">
                    <div >  <?php echo $this->langSite('games') ?> </div>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-12  tab_cat_device">

                    <ul class="nav tabDoor nav-tabs justify-content-end" id="myTab" role="tablist">

                        <?php foreach ($category_games as $key => $cat_tab)   {  ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($key==0) echo 'active' ?> " id="games-tab_<?php echo $cat_tab['id']?>" data-toggle="tab" href="#gamesCat_<?php echo $cat_tab['id']?>" role="tab" aria-controls="home" aria-selected="true"><?php echo $cat_tab['title']?></a>
                            </li>
                        <?php } ?>


                    </ul>

                </div>

                <div class="col-12">

                    <div class="tab-content contentTabPhoneModel" id="myTabContent">
                        <?php foreach ($category_games as $key => $cat_tab) {   ?>

                            <div class="tab-pane  <?php if ($key==0) echo 'show active' ?>  " id="gamesCat_<?php echo $cat_tab['id']?>" role="tabpanel" aria-labelledby="games-tab_<?php echo $cat_tab['id']?>">

                                <div class="phoneModel">

                                    <div class="control_slider">
                                        <div class="row">
                                            <div class="col-auto border" style="width: 50px">
                                                <a class="carousel-control-prev row_prev" href="#carouselExampleControlsPhone-<?php echo $cat_tab['id']?>" role="button" data-slide="prev">
                                                    <i class="fa fa-chevron-left"></i>
                                                </a>
                                                <a class="carousel-control-next row_next" href="#carouselExampleControlsPhone-<?php echo $cat_tab['id']?>" role="button" data-slide="next">
                                                    <i class="fa fa-chevron-right"></i>
                                                </a>

                                            </div>

                                            <div class="col-auto  titleCatLg">
                                                <?php echo $this->langSite('games') ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="carouselExampleControlsPhone-<?php echo $cat_tab['id']?>" class="carousel slide" data-ride="carousel" >
                                        <div class="carousel-inner" role="listbox">

                                            <?php  foreach ($cat_tab['content'] as $index=> $content) { ?>
                                                <div class="carousel-item  <?php if ($index==0) echo 'active' ?>  ">
                                                    <div class="row">

                                                        <?php  foreach ($content as $printContent)  { ?>

                                                            <div class="col-lg-3 col-md-4 col-sm-6 col-6 xBoxG">

                                                                <div  class="infoDevice">
                                                                    <?php  if ($printContent['bast_it'] == 1 ) { ?>
                                        <div class="bast_device">
                                            <?php echo $this->langSite('bast_it') ?>
                                        </div>

                                    <?php } ?>

                                                                    <a href="<?php echo url ?>/games/details/<?php echo $printContent['id'] ?>"  >
                                                                        <div class="hoverBtn">
                                                                            <button class="btn"><i class="fa fa-search"></i> </button>
                                                                        </div>
                                                                        <div class="imageDevise">
                                                                            <img   src="<?php echo $printContent['image'] ?>" alt="لا توجد صورة">
                                                                            <?php  if ($printContent['cuts'] == 1 ) { ?>
                                                                                <div class="price_cuts_note">
                                                                                    <?php echo $this->langSite('price_cuts') ?>
                                                                                </div>

                                                                            <?php } ?>
                                                                        </div>
                                                                    </a>

                                                                    <div class="nameDevice">
                                                                        <?php echo $printContent['title'] ?>

                                                                    </div>
                                                                    <?php  if ($printContent['cuts'] == 1 ) { ?>
                                                                        <div class="pricDevice" style="display: block">
<!--                                                                            <div class="oldXPrice" style="text-decoration: line-through;">--><?php //echo $printContent['price'] ?><!-- </div>-->
                                                                            <div class="price_cuts" style="color: green;font-weight: bold"> <?php echo $printContent['price_cuts'] ?> د.ع   </div>
                                                                        </div>
                                                                    <?php  } else{ ?>
                                                                        <div class="pricDevice" >
                                                                            <?php echo $printContent['price'] ?>
                                                                        </div>
                                                                    <?php } ?>
                                               <div class="memoryDevice">
                                                                        <?php  if (!empty($printContent['size']) &&  !in_array($printContent['size'],$this->non) )  { ?>
                                      حجم الذاكرة :                                    <?php echo $printContent['size'] ?>
                                                                        <?php  }  ?>
                                                                    </div>
                                                                    <div class="c_device">
                                                                        <div class="addedToCart_games<?php echo $printContent['id'] ?>"></div>

                                                                        <div class="row align-items-center justify-content-center">

                                                                            <div class="col-lg-8 col-md-8 col-sm-auto  xcartp"  >

                                                                                <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>


                                                                                    <?php if ($this->phone=='true' || $this->isDirect()) {   ?>

                                                                                        <button type="button" class="btn btn_cart" onclick="addToCart_games(<?php echo $printContent['id'] ?>,'<?php echo $printContent['size'] ?>','<?php echo $printContent['priceC'] ?>','<?php echo $printContent['nameImage'] ?>','<?php echo $printContent['code_color'] ?>','<?php echo $printContent['code'] ?>')">
                                                                                            <span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
                                                                                        </button>
                                                                                    <?php  }else{   ?>

                                                                                        <button type="button" class="btn btn_cart"    data-toggle="modal" data-target="#add_phone">
                                                                                            <span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
                                                                                        </button>

                                                                                    <?php  }  ?>
                                                                                <?php } else { ?>

                                                                                    <button type="button" class="btn btn_cart"    data-toggle="modal" data-target="#login_site">
                                                                                        <span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
                                                                                    </button>

                                                                                <?php } ?>


                                                                            </div>
                                                                            <div class="col-lg-3 col-md-3 col-sm-auto">
                                                                                <?php if (isset($_SESSION['username_member_r'])) { ?>

                                                                                    <button   type="button" class="btn btn_like    L_<?php echo $printContent['id']  ?> <?php  if ($printContent['like']) echo 'unlike'; else echo  'like' ?>"  onclick=<?php  if ($printContent['like']) echo "unlike_d(".$printContent['id'].",'games')"; else echo "like_d(".$printContent['id'].",'games')" ?>   >
                                                                                        <i class="fa fa-heart"></i>
                                                                                    </button>

                                                                                <?php } else { ?>

                                                                                    <button type="button" class="btn btn_like   "   data-toggle="modal" data-target="#login_site">
                                                                                        <i class="fa fa-heart"></i>
                                                                                    </button>

                                                                                <?php } ?>

                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        <?php   } ?>
                                                    </div>
                                                </div>

                                            <?php   } ?>


                                        </div>

                                    </div>
                                </div>

                            </div>
                        <?php  } ?>

                    </div>

                </div>


            </div>


<br>
<br>




            <div class="row justify-content-end">

                <div class="col-12  titleCatSm">
                    <div >  <?php echo $this->langSite('network') ?></div>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-12  tab_cat_device">

                    <ul class="nav tabDoor nav-tabs justify-content-end" id="myTab" role="tablist">

                        <?php foreach ($category_network as $key => $cat_tab)   {  ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($key==0) echo 'active' ?> " id="network-tab_<?php echo $cat_tab['id']?>" data-toggle="tab" href="#networkCat_<?php echo $cat_tab['id']?>" role="tab" aria-controls="home" aria-selected="true"><?php echo $cat_tab['title']?></a>
                            </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link   " id="network-tab_cards" data-toggle="tab" href="#networkCat_cards" role="tab" aria-controls="home" aria-selected="true"> خدمات شبكات المحمولة </a>
                        </li>

                    </ul>

                </div>

                <div class="col-12">

                    <div class="tab-content contentTabPhoneModel" id="myTabContent">
                        <?php foreach ($category_network as $key => $cat_tab) {   ?>

                            <div class="tab-pane  <?php if ($key==0) echo 'show active' ?>  " id="networkCat_<?php echo $cat_tab['id']?>" role="tabpanel" aria-labelledby="network-tab_<?php echo $cat_tab['id']?>">

                                <div class="phoneModel">

                                    <div class="control_slider">
                                        <div class="row">
                                            <div class="col-auto border" style="width: 50px">
                                                <a class="carousel-control-prev row_prev" href="#carouselExampleControlsPhone-<?php echo $cat_tab['id']?>" role="button" data-slide="prev">
                                                    <i class="fa fa-chevron-left"></i>
                                                </a>
                                                <a class="carousel-control-next row_next" href="#carouselExampleControlsPhone-<?php echo $cat_tab['id']?>" role="button" data-slide="next">
                                                    <i class="fa fa-chevron-right"></i>
                                                </a>

                                            </div>

                                            <div class="col-auto  titleCatLg">
                                                <?php echo $this->langSite('network') ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="carouselExampleControlsPhone-<?php echo $cat_tab['id']?>" class="carousel slide" data-ride="carousel" >
                                        <div class="carousel-inner" role="listbox">

                                            <?php  foreach ($cat_tab['content'] as $index=> $content) { ?>
                                                <div class="carousel-item  <?php if ($index==0) echo 'active' ?>  ">
                                                    <div class="row">

                                                        <?php  foreach ($content as $printContent)  { ?>

                                                            <div class="col-lg-3 col-md-4 col-sm-6 col-6 xBoxG">

                                                                <div  class="infoDevice">
                                                                    <?php  if ($printContent['bast_it'] == 1 ) { ?>
                                        <div class="bast_device">
                                            <?php echo $this->langSite('bast_it') ?>
                                        </div>

                                    <?php } ?>

                                                                    <a href="<?php echo url ?>/network/details/<?php echo $printContent['id'] ?>"  >
                                                                        <div class="hoverBtn">
                                                                            <button class="btn"><i class="fa fa-search"></i> </button>
                                                                        </div>
                                                                        <div class="imageDevise">
                                                                            <img   src="<?php echo $printContent['image'] ?>" alt="لا توجد صورة">
                                                                            <?php  if ($printContent['cuts'] == 1 ) { ?>
                                                                                <div class="price_cuts_note">
                                                                                    <?php echo $this->langSite('price_cuts') ?>
                                                                                </div>

                                                                            <?php } ?>
                                                                        </div>
                                                                    </a>

                                                                    <div class="nameDevice">
                                                                        <?php echo $printContent['title'] ?>

                                                                    </div>
                                                                    <?php  if ($printContent['cuts'] == 1 ) { ?>
                                                                        <div class="pricDevice" style="display: block">
<!--                                                                            <div class="oldXPrice" style="text-decoration: line-through;">--><?php //echo $printContent['price'] ?><!-- </div>-->
                                                                            <div class="price_cuts" style="color: green;font-weight: bold"> <?php echo $printContent['price_cuts'] ?> د.ع   </div>
                                                                        </div>
                                                                    <?php  } else{ ?>
                                                                        <div class="pricDevice" >
                                                                            <?php echo $printContent['price'] ?>
                                                                        </div>
                                                                    <?php } ?>
                                               <div class="memoryDevice">
                                                                        <?php  if (!empty($printContent['size']) &&  !in_array($printContent['size'],$this->non) )  { ?>
                                      حجم الذاكرة :                                    <?php echo $printContent['size'] ?>
                                                                        <?php  }  ?>
                                                                    </div>
                                                                    <div class="c_device">
                                                                        <div class="addedToCart_network<?php echo $printContent['id'] ?>"></div>

                                                                        <div class="row align-items-center justify-content-center">

                                                                            <div class="col-lg-8 col-md-8 col-sm-auto  xcartp"  >

                                                                                <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>


                                                                                    <?php if ($this->phone=='true' || $this->isDirect()) {   ?>

                                                                                        <button type="button" class="btn btn_cart" onclick="addToCart_network(<?php echo $printContent['id'] ?>,'<?php echo $printContent['size'] ?>','<?php echo $printContent['priceC'] ?>','<?php echo $printContent['nameImage'] ?>','<?php echo $printContent['code_color'] ?>','<?php echo $printContent['code'] ?>')">
                                                                                            <span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
                                                                                        </button>
                                                                                    <?php  }else{   ?>

                                                                                        <button type="button" class="btn btn_cart"    data-toggle="modal" data-target="#add_phone">
                                                                                            <span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
                                                                                        </button>

                                                                                    <?php  }  ?>
                                                                                <?php } else { ?>

                                                                                    <button type="button" class="btn btn_cart"    data-toggle="modal" data-target="#login_site">
                                                                                        <span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
                                                                                    </button>

                                                                                <?php } ?>


                                                                            </div>
                                                                            <div class="col-lg-3 col-md-3 col-sm-auto">
                                                                                <?php if (isset($_SESSION['username_member_r'])) { ?>

                                                                                    <button   type="button" class="btn btn_like    L_<?php echo $printContent['id']  ?> <?php  if ($printContent['like']) echo 'unlike'; else echo  'like' ?>"  onclick=<?php  if ($printContent['like']) echo "unlike_d(".$printContent['id'].",'network')"; else echo "like_d(".$printContent['id'].",'network')" ?>   >
                                                                                        <i class="fa fa-heart"></i>
                                                                                    </button>

                                                                                <?php } else { ?>

                                                                                    <button type="button" class="btn btn_like   "   data-toggle="modal" data-target="#login_site">
                                                                                        <i class="fa fa-heart"></i>
                                                                                    </button>

                                                                                <?php } ?>

                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        <?php   } ?>
                                                    </div>
                                                </div>

                                            <?php   } ?>


                                        </div>

                                    </div>
                                </div>

                            </div>
                        <?php  } ?>





                            <div class="tab-pane" id="networkCat_cards" role="tabpanel" aria-labelledby="network-tab_cards">

                                <div class="phoneModel">

                                    <div class="control_slider">
                                        <div class="row">
                                            <div class="col-auto border" style="width: 50px">
                                                <a class="carousel-control-prev row_prev" href="#carouselExampleControlsPhone-medical_supplies" role="button" data-slide="prev">
                                                    <i class="fa fa-chevron-left"></i>
                                                </a>
                                                <a class="carousel-control-next row_next" href="#carouselExampleControlsPhone-medical_supplies" role="button" data-slide="next">
                                                    <i class="fa fa-chevron-right"></i>
                                                </a>

                                            </div>

                                            <div class="col-auto  titleCatLg">
                                                <?php echo $this->langSite('network') ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="carouselExampleControlsPhone-medical_supplies" class="carousel slide" data-ride="carousel" >
                                        <div class="carousel-inner" role="listbox">

                                            <?php  foreach ($data as $key => $dtaC) {  ?>
                                                <div class="carousel-item  <?php  if ($key==0) echo 'active'?>   ">
                                                    <div class="grid_cards_slider">
                                                    <div class="row">
                                                        <?php  foreach ($dtaC as $dta) {  ?>
                                                            <div class="col-g-4 col-md-4 col-sm-6 col-6">
                                                                <a class="link_catg_view" href="<?php echo url  ?>/medical_supplies/view_cards/<?php  echo $dta['id']?>">
                                                                    <div class="image_carg">
                                                                        <img src="<?php  echo $dta['image']?> ">
                                                                    </div>
                                                                    <div class="title_catg">
                                                                        <?php  echo $dta['title']?>
                                                                    </div>

                                                                </a>
                                                            </div>
                                                        <?php  } ?>

                                                    </div> 
                                                    </div>
                                                </div>

                                            <?php  } ?>


                                        </div>

                                    </div>
                                </div>

                            </div>













                    </div>

                </div>


            </div>






            <?php if (!empty($arraygroupsAllCat)) {  ?>
                <br>
                <br>
               <div class="control_group">


                   <div class="row">
                       <div class="col-auto border" style="width: 50px">
                           <a class="carousel-control-prev row_prev" href="#carouselExampleControls_group" role="button" data-slide="prev">
                               <i class="fa fa-chevron-left"></i>
                           </a>
                           <a class="carousel-control-next row_next" href="#carouselExampleControls_group" role="button" data-slide="next">
                               <i class="fa fa-chevron-right"></i>
                           </a>

                       </div>

                       <div class="col-auto ">
                           المجموعات
                       </div>
                   </div>


               </div>
            <div class="sliderGroup">


                <div id="carouselExampleControls_group" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">

                        <?php  foreach ($arraygroupsAllCat as $key => $contentG)  { ?>
                        <div class="carousel-item <?php  if ($key == 0)  echo  'active'?> ">
                            <div class="row">
                                <?php  foreach ($contentG as   $c_g)  { ?>
                                <div class="col-lg-3 col-md-3 col-sm-4 ">
                                    <div class="image_g_d">
                                        <img src="<?php echo $c_g['img']?>">
                                    </div>
                                    <div class="title_g_d">
                                        <?php echo $c_g['title']?>
                                    </div>
                                </div>
                                <?php  } ?>
                            </div>

                        </div>

                        <?php  }  ?>

                    </div>

                </div>
            </div>
             <?php  } ?>

        </div>


    </div>


</div>


<br>
<br>
<br>
<br>


