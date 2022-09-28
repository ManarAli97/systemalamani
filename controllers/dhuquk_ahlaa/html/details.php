<?php  $this->publicHeader($this->langSite($this->folder));  ?>




    <div class="container">

        <div class="row">

            <div class="col-lg-3">

                <?php $this->menu->menu() ?>


            </div>

            <div class="col-lg-9">
                <br>

                <nav aria-label="breadcrumb" class="path_bread">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php  echo url ?>"><i class="fa fa-home"></i> </a></li>
                        <li class="breadcrumb-item"> <a href="<?php echo url .'/'.$this->folder ?>"><?php echo $this->langSite($this->folder); ?>  </a>    </li>
                        <li class="breadcrumb-item">  <?php echo $result['title']; ?>   </li>
                    </ol>
                </nav>


                <div class="row align-items-center">
                    <div class="col-auto">
                        الاقسام:
                    </div>
                    <div class="col-lg-6 col-md-8 col">
                        <select style="padding-top: 2px" name="id_cat" class="form-control"   onchange="location = this.value;">

                            <option value="<?php echo url .'/'. $this->folder ?>" selected > كل الاقسام </option>

                            <?php foreach ($category as $cag) {   ?>
                                <option  <?php  if ($cag['id']==$result['id_cat'] )  echo  'selected' ?>  value="<?php echo url .'/'. $this->folder ?>/index/<?php echo $cag['id'] ?>" <?php    if ($cag['id'] == $id) echo 'selected' ?> ><?php echo $cag['title'] ?> </option>
                            <?php  }  ?>
                        </select>
                    </div>
                </div>
                <hr>


                    <?php  if ($this->setting->get('dhuquk_ahlaa')) { ?>
                        <div class="notexcol">

                            <?php echo $this->setting->get('dhuquk_ahlaa'); ?>

                        </div>
                        <br>
                   <?php }    ?>



                <div class="image_offers_show">

                    <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"  class="swiper mySwiper2">
                        <div class="swiper-wrapper">

                            <?php foreach ($images as $img) {  ?>
                                <div class="swiper-slide">
                                    <img src="<?php  echo $img['url'] ?>" />
                                </div>
                            <?php } ?>

                        </div>

                    </div>
                    <div thumbsSlider="" class="swiper mySwiper">
                        <div class="swiper-wrapper">

                            <?php foreach ($images as $img) {  ?>
                                <div class="swiper-slide">
                                    <img src="<?php  echo $img['url'] ?>" />
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <br>
                <div class="content_art">
                    <?php echo $result['content']; ?>
                </div>


            </div>
        </div>
    </div>


    <br>
    <br>


<style>

    #links .carousel-indicators {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 15;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-pack: center;
        justify-content: center;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    #links .carousel-indicators li {
        box-sizing: content-box;
        -ms-flex: 0 1 auto;
        flex: 0 1 auto;
        width: 30px;
        height: 3px;
        margin-right: 3px;
        margin-left: 3px;
        text-indent: -999px;
        cursor: pointer;
        background-color: #283581;
        background-clip: padding-box;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
        opacity: .5;
        transition: opacity .6s ease;

    }
    #links  .carousel-indicators .active {
        opacity: 1;
    }
    .notexcol
    {
        border: 1px solid #dddddd;
        padding: 10px 12px;
        border-radius: 5px;
    }
    .title_card
    {
        color: #283581;
        text-align: center;
        padding: 7px 2px;
        font-size: 20px;
        margin: 3px;
    }
    .content_card
    {
        color: #020202d4;
        padding: 8px;
    }



    .blueimp-gallery > .next, .blueimp-gallery > .prev
    {
        color: #fff !important;
    }
    .blueimp-gallery > .close
    {
        color: #fff !important;
    }



    .page.active a
    {
        background: #007bff;
        color: #FFFFFF;
    }

    li.next.disabled a:hover ,li.last.disabled a:hover ,
    li.first.disabled a:hover,li.prev.disabled a:hover{

        cursor: not-allowed;
    }


    .blueimp-gallery > .close {

        left: 15px !important;
        right: auto !important;

    }
 .blueimp-gallery > .title {

        right: 15px !important;
       opacity: 1 !important;
    }


</style>




    <!-- Swiper JS -->
    <script   src="<?php echo $this->static_file_site ?>/swiper/swiper-bundle.min.js"></script>


    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".mySwiper2", {
            spaceBetween: 10,

            thumbs: {
                swiper: swiper,
            },
        });
    </script>

    <style>


        .dropdown_filter
        {
            border: 2px solid #495678;
            border-radius: 0;
            margin-bottom: 15px;
        }

        .btn_search_filter
        {
            border: 2px solid #495678;
            border-radius: 0;
            width: 100%;
            margin-bottom: 15px;
            background: #495678;
            color: #ffff;
        }


        .countDown {
            position: relative;
            background: #a5d5e2;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 5px;
        }
        .main-example {
            background: #fff;
            padding: 8px 0 36px 0;
            border-radius: 5px;
            direction: ltr;
        }
        .end_offer {
            font-size: 28px;
            font-weight: bold;
            color: #495678;
            padding-bottom: 11px;

        }

        .choose_color {
            font-weight: bold;
            margin-bottom: 12px;
            padding-right: 4px;
            color: black;
        }
        .details_item {
            background: #fff;
            padding: 5px 3px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .item_offer {
            margin: 11px 0;
            background: #a5d5e2;
            padding: 5px;
            border-radius: 7px;
        }

        .item_offer i {
            color: #0a7817;
        }

        .m_item {
            margin: 8px 0;
            font-weight: bold;
            border-bottom: 1px solid #bfc8ca;
        }


        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;

            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .swiper {
            width: 100%;
            height: auto;
            margin-left: auto;
            margin-right: auto;
        }

        .swiper-slide {
            background-size: cover;
            background-position: center;
        }

        .mySwiper2 {
            height: 100%;
            width: 100%;
        }

        /*.mySwiper2 img{*/
        /*    height: 350px !important;*/

        /*}*/

        .mySwiper {
            height: 100px;
            box-sizing: border-box;
            padding: 10px 0;
        }

        .mySwiper .swiper-slide {
            width: 100px;
            height: 100%;
            opacity: 0.4;
            cursor: pointer;
        }

        .mySwiper .swiper-slide-thumb-active {
            opacity: 1;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image_offers_show
        {
            text-align: center;
            position: relative;
            overflow: hidden;

        }

        .notePrice {
            padding: 5px;
            background: #e5e7f3;
        }

        .price
        {

            font-size: 18px;
            font-weight: bold;
        }
        .t_d_m
        {
            margin-top: 30px;
            font-size: 18px;
            font-weight: bold;
        }

        #price_device,#price_unit
        {
            color: red;
            font-size: 18px;
            font-weight: bold;
        }


        .infoDevice
        {
            border: 2px solid rgba(139, 134, 134, 0.45);
        }

        .menu_category
        {
            height:auto;
        }


        @media screen and (max-width: 48em) {
            .main-example {
                padding: 8px 0 0 0;
            }
        }

    </style>





<?php $this->publicFooter(); ?>