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
                                اضغط هنا
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
            padding: 3px 9px;
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
                                    <a style="display: block"  href="<?php  echo $ads['link']?>">
                                    <img src="<?php  echo $ads['img']?>">
                                    </a>
                                </div>
                         </div>

                        <?php  } else {   ?>
                        <div class="col-lg-4">
                          <div class="small_image">
                              <a style="display: block" href="<?php  echo $ads['link']?>">
                              <img src="<?php  echo $ads['img']?>">
                              </a>
                          </div>

                        </div>

                        <?php  }  ?>
                   <?php  }  ?>
            </div>




<br>
<br>
<br>

    <style>

        .titleCatSm
        {
            display: none;
            margin-bottom: 12px;
        }

          .big_img_ img
           {
               height: auto !important;
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


        }
 

         .swiper-container {
             width: 100%;
         }

        .swiper-slide {

            height: auto;
            width: auto;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;

        }

        .swiper-container {
            overflow-x: hidden;
        }

        .swiper-slide ul {
            margin: 0;
            list-style-type: none;
            display: flex;
            align-items: center;
            white-space: nowrap;
            border: 0;
            padding: 4px 0;
        }

        .swiper-slide li {
            margin-left: 15px;
        }

        .swiper-slide a {
            display: block;
            color: #000000;
            border-radius: 0;
            padding: 7px 12px;
            background-color: white;
            border: solid 1px #dcd8d8;
        }
        .swiper-scrollbar
        {
            display: none;
        }

        .class_catg_tabe.active{
            background: #283581;
            color: #ffff !important;
        }


    </style>


	<?php  if (!empty($category_mobile)) {   ?>
            <div class="row justify-content-end">


                <div class="col-12">


                    <script>
                        $(document).ready(function () {
                            var swiper = new Swiper('#scroll-tags_mobile', {
                                direction: 'horizontal',
                                slidesPerView: 'auto',
                                freeMode: true,
                                scrollbar: {
                                    el: '.swiper-scrollbar',
                                },
                                mousewheel: true,
                            });

                            $('.swiper-scrollbar').show();
                        });
                    </script>
                    <div class="swiper-container" id="scroll-tags_mobile">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <ul   class="tags-list nav tabDoor nav-tabs " id="myTab" role="tablist" >

                                    <?php foreach ($category_mobile as $key => $cat_tab)   {  ?>
                                        <li><a  onclick="get_mobile(<?php echo $cat_tab['id'] ?>)"  class="btn class_catg_tabe  <?php if ($key==0) echo 'active' ?>"    id="mobile-tab_<?php echo $cat_tab['id']?>" data-toggle="tab" href="#mobileCat_<?php echo $cat_tab['id']?>" role="tab" aria-controls="home" aria-selected="true">  <?php  echo $cat_tab['title']?> </a></li>
                                    <?php  }  ?>

                                </ul>
                            </div>
                        </div>

                    </div>


                </div>


                <div class="col-12 result_mobile">  </div>


                <script>

                    setTimeout(function () {
                        get_mobile(<?php echo $fm ?>);
                    },1000)
                    function get_mobile(id) {
                        $( ".result_mobile" ).html('<div class="loading2"><img  src="<?php echo $this->static_file_site ?>/image/site/loding.gif"  ></div>');
                        $.get( "<?php echo url ?>/mobile/index_data/"+id, function( data ) {
                            $( ".result_mobile" ).html( data );
                        });
                    }
                </script>

            </div>
        <br>
        <br>

          <?php  }  ?>




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




        function addToCart(id,code,model,price_type=0) {

            var  dataD={'id_item':id,'code':code,'price_type':price_type};

            $.get('<?php echo url ?>/'+model+'/cart_order', { jsonData: JSON.stringify( dataD )}, function(data){

                if (data !=='finish')
                {
                    $.get("<?php echo url ?>/"+model+"/count_c" , function(e) {
                        $('span.count_item').text(e);
                    });
                    $('.addedToCart_'+model+id).html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa fa-check-circle"> </i>  <span> تمت الاضافة  </span>
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                           </button>
                                     </div>`);
                    $('.button_buy').css('display','block');
                    $('.empty_car').css('display','none');
                    $('.item_cat').html(data);
                    setTimeout(function(){
                        $('.addedToCart_'+model+id).empty();
                    }, 4000);

                }else
                {
                    alert('نفذت الكمية')
                }
            });

        }




    </script>




    <div class="row">
        <div class="col-12">

            <?php  if (!empty($gallery2))  {   ?>
            <div id="carouselExampleControlsGG2" class="carousel slide  carousel-fade" data-ride="carousel">


                <ol class="carousel-indicators" id="control_slider">
                    <?php  foreach ($gallery2 as $key=> $gg2) {  ?>
                        <li data-target="#carouselExampleControlsGG2" data-slide-to="<?php echo $key ?>"  class="<?php if ($key==0)  echo 'active'?>"></li>
                    <?php  } ?>
                </ol>

                <div class="carousel-inner" role="listbox">

                <?php  foreach ($gallery2 as $key => $gg2) {  ?>
                    <div class="carousel-item <?php  if ($key==0) echo 'active'?> " style="position: relative">
                        <?php  if (!empty($gg2['url']))  {   ?>
                            <a href="<?php echo $gg2['url'] ?>" class="btn url_image">
                                اضغط هنا
                            </a>
                        <?php  }  ?>
                        <div class="image_offers">
                            <img src="<?php echo $gg2['image']?>">
                        </div>
                    </div>
                  <?php  }  ?>

                </div>
            </div>
            <br>
            <br>
            <br>

            <?php  }  ?>




            <?php  if (!empty($category_computer)) {   ?>
                <br>
                <div class="row">


                    <div class="col-12">


                        <script>
                            $(document).ready(function () {
                                var swiper = new Swiper('#scroll-tags_computer', {
                                    direction: 'horizontal',
                                    slidesPerView: 'auto',
                                    freeMode: true,
                                    scrollbar: {
                                        el: '.swiper-scrollbar',
                                    },
                                    mousewheel: true,
                                });

                                $('.swiper-scrollbar').show();
                            });
                        </script>
                        <div class="swiper-container" id="scroll-tags_computer">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <ul   class="tags-list nav tabDoor nav-tabs " id="myTab" role="tablist" >

                                        <?php foreach ($category_computer as $key => $cat_tab)   {  ?>
                                            <li><a    onclick="get_computer(<?php echo $cat_tab['id'] ?>)"   class="btn class_catg_tabe  <?php if ($key==0) echo 'active' ?>"    id="computer-tab_<?php echo $cat_tab['id']?>" data-toggle="tab" href="#computerCat_<?php echo $cat_tab['id']?>" role="tab" aria-controls="home" aria-selected="true">  <?php  echo $cat_tab['title']?> </a></li>
                                        <?php  }  ?>

                                    </ul>
                                </div>
                            </div>

                        </div>






                    </div>


                    <div class="col-12 result_computer">  </div>

                    <script>
                        setTimeout(function () {
                            get_computer(<?php echo $fco ?>);
                        },2000)
                        function get_computer(id) {
                            $( ".result_computer" ).html('<div class="loading2"><img  src="<?php echo $this->static_file_site ?>/image/site/loding.gif"  ></div>');
                            $.get( "<?php echo url ?>/computer/index_data/"+id, function( data ) {
                                $( ".result_computer" ).html( data );
                            });
                        }
                    </script>



                </div>

                <br>
                <br>
            <?php  }  ?>



            <?php  if (!empty($gallery7))  {   ?>
                <div id="carouselExampleControlsGG4" class="carousel slide  carousel-fade" data-ride="carousel">


                    <ol class="carousel-indicators" id="control_slider">
                        <?php  foreach ($gallery7 as $key=> $gg4) {  ?>
                            <li data-target="#carouselExampleControlsGG4" data-slide-to="<?php echo $key ?>"  class="<?php if ($key==0)  echo 'active'?>"></li>
                        <?php  } ?>
                    </ol>

                    <div class="carousel-inner" role="listbox">

                        <?php  foreach ($gallery7 as $key => $gg4) {  ?>
                            <div class="carousel-item <?php  if ($key==0) echo 'active'?> " style="position: relative">
                                <?php  if (!empty($gg4['url']))  {   ?>
                                    <a href="<?php echo $gg4['url'] ?>" class="btn url_image">
                                        اضغط هنا
                                    </a>
                                <?php  }  ?>
                                <div class="image_offers">
                                    <img src="<?php echo $gg4['image']?>">
                                </div>
                            </div>
                        <?php  }  ?>

                    </div>
                </div>
                <br>
                <br>
                <br>

            <?php  }  ?>








            <?php  if (!empty($category_accessories)) {   ?>

                <br>
            <div class="row">

                <div class="col-12">


                    <script>
                        $(document).ready(function () {
                            var swiper = new Swiper('#scroll-tags_accessories', {
                                direction: 'horizontal',
                                slidesPerView: 'auto',
                                freeMode: true,
                                scrollbar: {
                                    el: '.swiper-scrollbar',
                                },
                                mousewheel: true,
                            });

                            $('.swiper-scrollbar').show();
                        });
                    </script>
                    <div class="swiper-container" id="scroll-tags_accessories">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <ul   class="tags-list nav tabDoor nav-tabs" id="myTab_accessories" role="tablist" >

                                    <?php foreach ($category_accessories as $key => $cat_tab)   {  ?>
                                        <li><a  onclick="get_accessories(<?php echo $cat_tab['id'] ?>)"  class="btn class_catg_tabe  <?php if ($key==0) echo 'active' ?>"    id="mobile-tab_accessories_<?php echo $cat_tab['id']?>" data-toggle="tab" href="#tab_accessories_Cat_<?php echo $cat_tab['id']?>" role="tab" aria-controls="home" aria-selected="true">  <?php  echo $cat_tab['title']?> </a></li>
                                    <?php  }  ?>

                                </ul>
                            </div>
                        </div>

                    </div>




                </div>



                <div class="col-12 result_accessories">  </div>


                <script>
                    setTimeout(function () {
                        get_accessories(<?php echo $fa ?>);
                    },2000)

                    function get_accessories(id) {
                        $( ".result_accessories" ).html('<div class="loading2"><img  src="<?php echo $this->static_file_site ?>/image/site/loding.gif"  ></div>');
                        $.get( "<?php echo url ?>/accessories/index_data/"+id, function( data ) {
                            $( ".result_accessories" ).html( data );
                        });
                    }
                </script>




            </div>


            <br>
            <br>
            <?php  }  ?>


            <?php  if (!empty($gallery3))  {   ?>
                <div id="carouselExampleControlsGG3" class="carousel slide  carousel-fade" data-ride="carousel">


                    <ol class="carousel-indicators" id="control_slider">
                        <?php  foreach ($gallery3 as $key=> $gg3) {  ?>
                            <li data-target="#carouselExampleControlsGG3" data-slide-to="<?php echo $key ?>"  class="<?php if ($key==0)  echo 'active'?>"></li>
                        <?php  } ?>
                    </ol>

                    <div class="carousel-inner" role="listbox">

                        <?php  foreach ($gallery3 as $key => $gg3) {  ?>
                            <div class="carousel-item <?php  if ($key==0) echo 'active'?> " style="position: relative">
                                <?php  if (!empty($gg3['url']))  {   ?>
                                    <a href="<?php echo $gg3['url'] ?>" class="btn url_image">
                                        اضغط هنا
                                    </a>
                                <?php  }  ?>
                                <div class="image_offers">
                                    <img src="<?php echo $gg3['image']?>">
                                </div>
                            </div>
                        <?php  }  ?>

                    </div>
                </div>
                <br>
                <br>
                <br>

            <?php  }  ?>


			<?php  if (!empty($category_camera)) {   ?>
                <br>
            <div class="row">


                <div class="col-12">


                    <script>
                        $(document).ready(function () {
                            var swiper = new Swiper('#scroll-tags_camera', {
                                direction: 'horizontal',
                                slidesPerView: 'auto',
                                freeMode: true,
                                scrollbar: {
                                    el: '.swiper-scrollbar',
                                },
                                mousewheel: true,
                            });

                            $('.swiper-scrollbar').show();
                        });
                    </script>
                    <div class="swiper-container" id="scroll-tags_camera">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <ul   class="tags-list nav tabDoor nav-tabs " id="myTab" role="tablist" >

                                    <?php foreach ($category_camera as $key => $cat_tab)   {  ?>
                                        <li><a  onclick="get_camera(<?php echo $cat_tab['id'] ?>)"  class="btn class_catg_tabe  <?php if ($key==0) echo 'active' ?>"    id="camera-tab_<?php echo $cat_tab['id']?>" data-toggle="tab" href="#cameraCat_<?php echo $cat_tab['id']?>" role="tab" aria-controls="home" aria-selected="true">  <?php  echo $cat_tab['title']?> </a></li>
                                    <?php  }  ?>

                                </ul>
                            </div>
                        </div>

                    </div>






                </div>



                <div class="col-12 result_camera">  </div>

                <script>
                    setTimeout(function () {
                        get_camera(<?php echo $fc ?>);
                    },2000)
                    function get_camera(id) {
                        $( ".result_camera" ).html('<div class="loading2"><img  src="<?php echo $this->static_file_site ?>/image/site/loding.gif"  ></div>');
                        $.get( "<?php echo url ?>/camera/index_data/"+id, function( data ) {
                            $( ".result_camera" ).html( data );
                        });
                    }
                </script>



            </div>

            <br>
            <br>
			<?php  }  ?>


            <?php  if (!empty($gallery4))  {   ?>
                <div id="carouselExampleControlsGG4" class="carousel slide  carousel-fade" data-ride="carousel">


                    <ol class="carousel-indicators" id="control_slider">
                        <?php  foreach ($gallery4 as $key=> $gg4) {  ?>
                            <li data-target="#carouselExampleControlsGG4" data-slide-to="<?php echo $key ?>"  class="<?php if ($key==0)  echo 'active'?>"></li>
                        <?php  } ?>
                    </ol>

                    <div class="carousel-inner" role="listbox">

                        <?php  foreach ($gallery4 as $key => $gg4) {  ?>
                            <div class="carousel-item <?php  if ($key==0) echo 'active'?> " style="position: relative">
                                <?php  if (!empty($gg4['url']))  {   ?>
                                    <a href="<?php echo $gg4['url'] ?>" class="btn url_image">
                                        اضغط هنا
                                    </a>
                                <?php  }  ?>
                                <div class="image_offers">
                                    <img src="<?php echo $gg4['image']?>">
                                </div>
                            </div>
                        <?php  }  ?>

                    </div>
                </div>
                <br>
                <br>
                <br>

            <?php  }  ?>







			<?php  if (!empty($category_printing_supplies)) {   ?>
                <br>
                <div class="row">


                    <div class="col-12">


                        <script>
                            $(document).ready(function () {
                                var swiper = new Swiper('#scroll-tags_printing_supplies', {
                                    direction: 'horizontal',
                                    slidesPerView: 'auto',
                                    freeMode: true,
                                    scrollbar: {
                                        el: '.swiper-scrollbar',
                                    },
                                    mousewheel: true,
                                });

                                $('.swiper-scrollbar').show();
                            });
                        </script>
                        <div class="swiper-container" id="scroll-tags_printing_supplies">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <ul   class="tags-list nav tabDoor nav-tabs " id="myTab" role="tablist" >

										<?php foreach ($category_printing_supplies as $key => $cat_tab)   {  ?>
                                            <li><a    onclick="get_printing_supplies(<?php echo $cat_tab['id'] ?>)"  class="btn class_catg_tabe  <?php if ($key==0) echo 'active' ?>"    id="printing_supplies-tab_<?php echo $cat_tab['id']?>" data-toggle="tab" href="#printing_suppliesCat_<?php echo $cat_tab['id']?>" role="tab" aria-controls="home" aria-selected="true">  <?php  echo $cat_tab['title']?> </a></li>
										<?php  }  ?>

                                    </ul>
                                </div>
                            </div>

                        </div>






                    </div>



                    <div class="col-12 result_printing_supplies">  </div>

                    <script>

                        setTimeout(function () {
                            get_printing_supplies(<?php echo $fps ?>);
                        },3000)
                        function get_printing_supplies(id) {
                            $( ".result_printing_supplies" ).html('<div class="loading2"><img  src="<?php echo $this->static_file_site ?>/image/site/loding.gif"  ></div>');
                            $.get( "<?php echo url ?>/printing_supplies/index_data/"+id, function( data ) {
                                $( ".result_printing_supplies" ).html( data );
                            });
                        }
                    </script>



                </div>

                <br>
                <br>
			<?php  }  ?>


            <?php  if (!empty($gallery8))  {   ?>
                <div id="carouselExampleControlsGG4" class="carousel slide  carousel-fade" data-ride="carousel">


                    <ol class="carousel-indicators" id="control_slider">
                        <?php  foreach ($gallery8 as $key=> $gg4) {  ?>
                            <li data-target="#carouselExampleControlsGG4" data-slide-to="<?php echo $key ?>"  class="<?php if ($key==0)  echo 'active'?>"></li>
                        <?php  } ?>
                    </ol>

                    <div class="carousel-inner" role="listbox">

                        <?php  foreach ($gallery8 as $key => $gg4) {  ?>
                            <div class="carousel-item <?php  if ($key==0) echo 'active'?> " style="position: relative">
                                <?php  if (!empty($gg4['url']))  {   ?>
                                    <a href="<?php echo $gg4['url'] ?>" class="btn url_image">
                                        اضغط هنا
                                    </a>
                                <?php  }  ?>
                                <div class="image_offers">
                                    <img src="<?php echo $gg4['image']?>">
                                </div>
                            </div>
                        <?php  }  ?>

                    </div>
                </div>
                <br>
                <br>
                <br>

            <?php  }  ?>


            <br>

			<?php  if (!empty($category_games)) {   ?>
            <div class="row">


                <div class="col-12">


                    <script>
                        $(document).ready(function () {
                            var swiper = new Swiper('#scroll-tags_games', {
                                direction: 'horizontal',
                                slidesPerView: 'auto',
                                freeMode: true,
                                scrollbar: {
                                    el: '.swiper-scrollbar',
                                },
                                mousewheel: true,
                            });

                            $('.swiper-scrollbar').show();
                        });
                    </script>
                    <div class="swiper-container" id="scroll-tags_games">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <ul   class="tags-list nav tabDoor nav-tabs " id="myTab" role="tablist" >

                                    <?php foreach ($category_games as $key => $cat_tab)   {  ?>
                                        <li><a   onclick="get_games(<?php echo $cat_tab['id'] ?>)"   class="btn class_catg_tabe  <?php if ($key==0) echo 'active' ?>"    id="games-tab_<?php echo $cat_tab['id']?>" data-toggle="tab" href="#gamesCat_<?php echo $cat_tab['id']?>" role="tab" aria-controls="home" aria-selected="true">  <?php  echo $cat_tab['title']?> </a></li>
                                    <?php  }  ?>

                                </ul>
                            </div>
                        </div>

                    </div>


                </div>

                <div class="col-12 result_games">  </div>

                <script>
                    setTimeout(function () {
                        get_games(<?php echo $fg ?>);
                    },3000)

                    function get_games(id) {
                        $( ".result_games" ).html('<div class="loading2"><img  src="<?php echo $this->static_file_site ?>/image/site/loding.gif"  ></div>');
                        $.get( "<?php echo url ?>/games/index_data/"+id, function( data ) {
                            $( ".result_games" ).html( data );
                        });
                    }
                </script>


            </div>


<br>
<br>
<?php  }  ?>


            <?php  if (!empty($gallery5))  {   ?>
                <div id="carouselExampleControlsGG5" class="carousel slide  carousel-fade" data-ride="carousel">


                    <ol class="carousel-indicators" id="control_slider">
                        <?php  foreach ($gallery5 as $key=> $gg5) {  ?>
                            <li data-target="#carouselExampleControlsGG5" data-slide-to="<?php echo $key ?>"  class="<?php if ($key==0)  echo 'active'?>"></li>
                        <?php  } ?>
                    </ol>

                    <div class="carousel-inner" role="listbox">

                        <?php  foreach ($gallery5 as $key => $gg5) {  ?>
                            <div class="carousel-item <?php  if ($key==0) echo 'active'?> " style="position: relative">
                                <?php  if (!empty($gg5['url']))  {   ?>
                                    <a href="<?php echo $gg5['url'] ?>" class="btn url_image">
                                        اضغط هنا
                                    </a>
                                <?php  }  ?>
                                <div class="image_offers">
                                    <img src="<?php echo $gg5['image']?>">
                                </div>
                            </div>
                        <?php  }  ?>

                    </div>
                </div>
                <br>
                <br>
                <br>

            <?php  }  ?>



            <br>


            <?php  if (!empty($category_network)) {   ?>

            <div class="row">

                <div class="col-12">



                    <script>
                        $(document).ready(function () {
                            var swiper = new Swiper('#scroll-tags_network', {
                                direction: 'horizontal',
                                slidesPerView: 'auto',
                                freeMode: true,
                                scrollbar: {
                                    el: '.swiper-scrollbar',
                                },
                                mousewheel: true,
                            });

                            $('.swiper-scrollbar').show();
                        });
                    </script>
                    <div class="swiper-container" id="scroll-tags_network">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <ul   class="tags-list nav tabDoor nav-tabs " id="myTab" role="tablist" >

                                    <?php foreach ($category_network as $key => $cat_tab)   {  ?>
                                        <li><a  onclick="get_network(<?php echo $cat_tab['id'] ?>)"   class="btn class_catg_tabe  <?php if ($key==0) echo 'active' ?>"    id="network-tab_<?php echo $cat_tab['id']?>" data-toggle="tab" href="#networkCat_<?php echo $cat_tab['id']?>" role="tab" aria-controls="home" aria-selected="true">  <?php  echo $cat_tab['title']?> </a></li>
                                    <?php  }  ?>

                                </ul>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="col-12 result_network">  </div>

                <script>

                    setTimeout(function () {
                        get_network(<?php echo $fn ?>);
                    },3000)

                    function get_network(id) {
                        $( ".result_network" ).html('<div class="loading2"><img  src="<?php echo $this->static_file_site ?>/image/site/loding.gif"  ></div>');
                        $.get( "<?php echo url ?>/network/index_data/"+id, function( data ) {
                            $( ".result_network" ).html( data );
                        });
                    }
                </script>


            </div>
                <br>
                <br>
            <?php  }  ?>




            <?php  if (!empty($gallery6))  {   ?>
                <div id="carouselExampleControlsGG6" class="carousel slide  carousel-fade" data-ride="carousel">


                    <ol class="carousel-indicators" id="control_slider">
                        <?php  foreach ($gallery6 as $key=> $gg6) {  ?>
                            <li data-target="#carouselExampleControlsGG6" data-slide-to="<?php echo $key ?>"  class="<?php if ($key==0)  echo 'active'?>"></li>
                        <?php  } ?>
                    </ol>

                    <div class="carousel-inner" role="listbox">

                        <?php  foreach ($gallery6 as $key => $gg6) {  ?>
                            <div class="carousel-item <?php  if ($key==0) echo 'active'?> " style="position: relative">
                                <?php  if (!empty($gg6['url']))  {   ?>
                                    <a href="<?php echo $gg6['url'] ?>" class="btn url_image">
                                        اضغط هنا
                                    </a>
                                <?php  }  ?>
                                <div class="image_offers">
                                    <img src="<?php echo $gg6['image']?>">
                                </div>
                            </div>
                        <?php  }  ?>

                    </div>
                </div>
                <br>
                <br>
                <br>


            <?php  }  ?>





            <?php  if (!empty($data))  {  ?>

            <div class="row">

                <div class="col-12">

                    <script>
                        $(document).ready(function () {
                            var swiper = new Swiper('#scroll-tags_medical_supplies', {
                                direction: 'horizontal',
                                slidesPerView: 'auto',
                                freeMode: true,
                                scrollbar: {
                                    el: '.swiper-scrollbar',
                                },
                                mousewheel: true,
                            });

                            $('.swiper-scrollbar').show();
                        });
                    </script>

                    <div class="swiper-container" id="scroll-tags_medical_supplies">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <ul   class="tags-list nav tabDoor nav-tabs " id="myTab" role="tablist" >

                                        <li><a class="btn class_catg_tabe active" id="medical_supplies-tab_cards" data-toggle="tab" href="#medical_suppliesCat_cards" role="tab" aria-controls="home" aria-selected="true">  <?php echo $this->langSite('medical_supplies')?> </a></li>

                                </ul>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-12">

                    <div class="tab-content contentTabPhoneModel" id="myTabContent">

                        <div class="tab-pane active" id="medical_suppliesCat_cards" role="tabpanel" aria-labelledby="medical_supplies-tab_cards">

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
                                            <?php echo $this->langSite('medical_supplies') ?>
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
                                                                <a style="border: 1px solid #f6f6f6;" class="link_catg_view" href="<?php echo url  ?>/medical_supplies/view_medical_supplies/<?php  echo $dta['id']?>">
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

            <br>
            <br>

               <?php  }  ?>









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

<style>

    .loading2{
        height: 400px;
        background: #dcd8d840;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .loading2 img{
        width: 45px;
    }
</style>

