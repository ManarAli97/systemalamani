<?php  $this->publicHeader($result['title']);  ?>
<meta property="og:url" content="<?php echo url .'/'. $this->folder ?>/details/<?php echo $result['id'] ?>"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="<?php  echo $result['title'] ?>"/>
<?php  $sub_content=strip_tags($result['content']); ?>
<?php  $result_cont = preg_replace('/(\s)"([^"]+)"(\s)/', '$1$2$3', $sub_content);?>
<?php  $excerpt_content = preg_replace('/^"(.*?)"$/', '$1', $result_cont);?>
<?php  $string = mb_substr(trim(preg_replace('/\s+/', ' ', $excerpt_content)),0,190,'utf-8'); ?>
<?php  $string =str_replace('"', "", $string); ?>
<?php  $string =str_replace("'", "", $string); ?>
<?php  $string =str_replace("،", "", $string); ?>
<?php  $string =str_replace("&nbsp", "", $string);?>
<?php  $string =trim(preg_replace('/\s\s+/', ' ', $string));?>
<meta property="og:description" content="<?php echo  $string   ?> ..."/>
<?php  if ( $file_type == 'image') { ?>
<meta property="og:image" content="<?php  echo $file?>"/>
<?php } ?>


<div class="container">
<div class="section_1">

        <div class="row">
            <div class="col-lg-8 col-md-8" >

                <div class="parts_list_her">
                    <span>  الاخبار  </span>
                </div>
                <br>

                <?php   if ($file_type == 'video' ) {  ?>

                        <div class="tittle_video">
                        <?php  echo $result['title'] ?>
                    </div>


                    <?php  if (!empty($result['price'])) {  ?>
                    <div class="tittle_video_2">
                        <?php  echo $result['price'] ?>
                    </div>
                        <?php  } ?>

                    <div class="row justify-content-between">
                        <div class="col-auto">

                            <div class="icon_view_and_date">
                              <span>  <i class="fa  fa-eye"></i> <i>  <?php  echo  $result['view'] ?></i></span> |
                               <span>    <i class="fa  fa-calendar"></i> <i>  <?php echo date('Y-m-d', $result['date'])   ?></i> </span>
                            </div>

                        </div>

                        <div class="col-auto">

                            <div>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo url .'/'. $this->folder ?>/details/<?php echo $result['id'] ?>" target="_blank">
                                    <img src="<?php  echo $this->static_file_site ?>/image/site/f_s.png">
                                </a>
                                <a href="https://twitter.com/intent/tweet?text=<?php  echo $result['title'] ?>&url=<?php echo url .'/'. $this->folder ?>/details/<?php echo $result['id'] ?>"   target="_blank">
                                    <img src="<?php  echo $this->static_file_site ?>/image/site/t_s.png">
                                </a>
                                <a href="https://telegram.me/share/url?url==<?php echo url .'/'. $this->folder ?>/details/<?php echo $result['id'] ?>"   target="_blank">
                                    <img src="<?php  echo $this->static_file_site ?>/image/site/tg_s.png">
                                </a>
                            </div>

                        </div>

                    </div>

                 <div class="video_bg">
                    <video class="video_default" controls >
                        <source src="<?php  echo $file?>#t=0.5"  >
                    </video>

                     <?php if (!empty($result['content'])) {  ?>
                         <div class="description" > <?php  echo $result['content'] ?></div>
                     <?php  }  ?>
                    </div>


                <?php    }  else if ( $file_type == 'image') { ?>

                    <div class="tittle_video">
                        <?php  echo $result['title'] ?>
                    </div>


                    <?php  if (!empty($result['price'])) {  ?>
                    <div class="tittle_video_2">
                        <?php  echo $result['price'] ?>
                    </div>
                        <?php  } ?>

                    <div class="row justify-content-between">
                        <div class="col-auto">

                            <div class="icon_view_and_date">
                              <span>  <i class="fa  fa-eye"></i> <i>  <?php  echo  $result['view'] ?></i></span> |
                               <span>    <i class="fa  fa-calendar"></i> <i>  <?php echo date('Y-m-d', $result['date'])   ?></i> </span>
                            </div>

                        </div>

                        <div class="col-auto">

                            <div>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo url .'/'. $this->folder ?>/details/<?php echo $result['id'] ?>" target="_blank">
                                    <img src="<?php  echo $this->static_file_site ?>/image/site/f_s.png">
                                </a>
                                <a href="https://twitter.com/intent/tweet?text=<?php  echo $result['title'] ?>&url=<?php echo url .'/'. $this->folder ?>/details/<?php echo $result['id'] ?>"   target="_blank">
                                    <img src="<?php  echo $this->static_file_site ?>/image/site/t_s.png">
                                </a>
                                <a href="https://telegram.me/share/url?url==<?php echo url .'/'. $this->folder ?>/details/<?php echo $result['id'] ?>"   target="_blank">
                                    <img src="<?php  echo $this->static_file_site ?>/image/site/tg_s.png">
                                </a>
                            </div>

                        </div>

                    </div>

                    <div class="video_bg">
                        <img src="<?php  echo $file?>" class="video_default"  >

                        <?php if (!empty($result['content'])) {  ?>
                            <div class="description" > <?php  echo $result['content'] ?></div>
                        <?php  }  ?>
                    </div>

                <?php    }else{  ?>


                        <div class="tittle_video">
                        <?php  echo $result['title'] ?>
                    </div>


                    <?php  if (!empty($result['price'])) {  ?>
                    <div class="tittle_video_2">
                        <?php  echo $result['price'] ?>
                    </div>
                        <?php  } ?>

                    <div class="row justify-content-between">
                        <div class="col-auto">

                            <div class="icon_view_and_date">
                              <span>  <i class="fa  fa-eye"></i> <i>  <?php  echo  $result['view'] ?></i></span> |
                               <span>    <i class="fa  fa-calendar"></i> <i>  <?php echo date('Y-m-d', $result['date'])   ?></i> </span>
                            </div>

                        </div>

                        <div class="col-auto">

                            <div>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo url .'/'. $this->folder ?>/details/<?php echo $result['id'] ?>" target="_blank">
                                    <img src="<?php  echo $this->static_file_site ?>/image/site/f_s.png">
                                </a>
                                <a href="https://twitter.com/intent/tweet?text=<?php  echo $result['title'] ?>&url=<?php echo url .'/'. $this->folder ?>/details/<?php echo $result['id'] ?>"   target="_blank">
                                    <img src="<?php  echo $this->static_file_site ?>/image/site/t_s.png">
                                </a>
                                <a href="https://telegram.me/share/url?url==<?php echo url .'/'. $this->folder ?>/details/<?php echo $result['id'] ?>"   target="_blank">
                                    <img src="<?php  echo $this->static_file_site ?>/image/site/tg_s.png">
                                </a>
                            </div>

                        </div>

                    </div>
             <br>
                    <?php if (!empty($result['content'])) {  ?>
                        <div class="description" > <?php  echo $result['content'] ?></div>
                    <?php  }  ?>


                <?php    }  ?>

             <?php  if (!empty($related_infogr)) { ?>

<div class="image_from_parts">
صور الخبر
</div>

                <div class="row">

                    <?php  foreach ($related_infogr as $rel_inf){ ?>
                    <div class="col col-lg-4" id="links">
                        <?php  if ($rel_inf['file_type']=='image') {   ?>
                                <a href="<?php echo $this->show_file_site .$rel_inf['rand_name'] ?>" data-gallery="" data-unique-id="tmp_<?php echo $rel_inf['id'] ?>">
                                 <img class="image_infg_rel" src="<?php  echo  $rel_inf['file']?>">
                             </a>
                             <?php  }else{ ?>
                                <video class="video_infg_rel" controls >
                                    <source src="<?php  echo  $rel_inf['file']?>#t=0.5"  >
                                </video>

                             <?php  } ?>
                    </div>
                    <?php }  ?>
                </div>
           <?php  } ?>

            </div>



            <div class="col-lg-4 col-md-4" >
                <div class="dropdown-divider d-block d-sm-block d-md-none "></div>
                <?php  $sidebar -> sidebars()  ?>
            </div>

        </div>



    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-use-bootstrap-modal="false">
        <div class="slides"></div>
        <h3 class="title" ></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>


<!--    new nesw-->
<br>
<br>
    <div class="row">
<div class="col-12">

               <a class="btn top_view_parts">
                               احدث الاخبار
                            </a>
                            <div class="container_tab_slider">

                                <div id="carouselExampleIndicators_parts_hospital_new_parts"
                                     class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">

                                        <?php foreach ($new_parts_chunk as  $key => $array_chunk_parts) { ?>
                                        <div class="carousel-item <?php if ($key == 0) echo 'active' ?>  ">
                                            <div class="row">
                                                <?php foreach ($array_chunk_parts as $print_parts) { ?>
                                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                                        <a href="<?php  echo url .'/'.$this->folder ?>/details/<?php echo $print_parts['id'] ?>" class="image_parts_list">
                                                            <img src="<?php echo $print_parts['img'] ?>">
                                                        </a>
                                                        <div class="info_parts">
                                                            <div class="title_parts_list">
                                                                <?php echo $print_parts['title'] ?>

                                                            </div>
                                                            <div class="info_parts_publishing">
                                                                <span>   &nbsp;  <?php echo $print_parts['view'] ?>  </span>
                                                                <i class="fa fa-eye"></i> <span
                                                                        style="border-left: 1px solid #d0cccc; "></span>
                                                                &nbsp;
                                                                <span>      <?php echo $print_parts['date'] ?>   </span>
                                                                <i class="fa fa-clock-o"></i> &nbsp;
                                                            </div>
                                                        </div>

                                                    </div>

                                                <?php } ?>
                                            </div>

                                        </div>

                                                 <?php } ?>

                                    </div>
                                    <div class="control_slider_parts" style="margin-top: 13px;">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-auto" style="padding-left: 2px;padding-right: 0">
                                                    <a class="carousel-control-prev prev_and_prev"
                                                       href="#carouselExampleIndicators_parts_hospital_new_parts"
                                                       role="button" data-slide="prev">
                                                        <i class="fa  fa-caret-right"></i>
                                                    </a>
                                                </div>
                                                <div class="col-auto" style="padding-right: 2px">
                                                    <a class="carousel-control-next prev_and_next"
                                                       href="#carouselExampleIndicators_parts_hospital_new_parts"
                                                       role="button" data-slide="next">
                                                        <i class="fa  fa-caret-left"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                        </div>


</div>
</div>


</div>
</div>

    <script>
        $(document).ready(function() {
            var myEle = document.getElementById("links");
            if(myEle){
            document.getElementById('links').onclick = function (event) {
                blueimp.Gallery(
                    document.getElementById('links').getElementsByTagName('a'),
                    {
                        container: '#blueimp-gallery',
                        carousel: true,
                        onslide: function (index, slide) {
                            var unique_id = this.list[index].getAttribute('data-unique-id');
                        }
                    }
                );
            }
            }
        });


    </script>

<style>
    .image_from_parts {
    background: #ececec;
    margin-bottom: 15px;
    padding: 10px 23px;
    font-size: 18px;
    border-radius: 5px;
}
    .parts_list_her {
        border-bottom: 1px solid #c9c7c7;
        position: relative;
        height: 37px;
        padding-right: 39px;
    }

    .parts_list_her span {
        border-bottom: 0px solid #00a3c8;
        font-size: 22px;
        padding: 0px 55px 0 54px;
        position: relative;
    }
    .parts_list_her span:after {
        content: '___';
        position: absolute;
        width: 100%;
        text-align: center;
        right: 0;
        font-family: FontAwesome;
        color: #00a3c8;
        z-index: 1;
        border-bottom: 1px solid #00a3c8;
        font-size: 52px;
        bottom: 0;
        font-weight: bold;
        line-height: 1.06;
    }
    .list_last_parts
    {
        margin-bottom: 9px;
        display: block;
    }
    .list_last_parts:last-child {
        margin-bottom: 0;
    }

    .blueimp-gallery > .next, .blueimp-gallery > .prev
    {
        color: #fff !important;
    }
    .blueimp-gallery > .close
    {
        color: #fff !important;
    }


    img.image_infg_rel {
        width: 100%;
        height: 200px;
        margin-bottom: 30px;
    }

    video.video_infg_rel {
        width: 100%;
        height: 200px;
        margin-bottom: 30px;
        object-fit: inherit;
    }

    .description {

        text-align: justify;
        padding: 10px;
        color: black;
    }
    .video_default
    {
        width: 100%;
        cursor: pointer;
        object-fit: inherit;
    }
    .tittle_video
    {

        color: #000000;
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 17px;
    }
    .tittle_video_2
    {

        color: #e56353;
        font-size: 16px;
        border-bottom: 1px solid #c7c7c747;
        margin-bottom: 12px;
    }

    .video_bg_sub
    {
        border-bottom: 2px solid #a5f1fe;
        margin-bottom: 18px;
        padding-bottom: 18px;
    }
    .video_bg_sub:last-child
    {
        border-bottom: 2px solid transparent;
    }



   .side_infg
   {
       background: #65cee2;
       padding: 5px;
   }

    .icon_view_and_date {
        height: 100%;
        padding: 5px;
        text-align: left;
        color: #858585;
    }


    .last_infg {
        background: white;
        margin-bottom: 9px;
        transition: 0.5s;
    }
  .last_infg:hover {
      background: #a5f1feeb;
    }

        .last_infg:last-child {
        margin-bottom: 0;
    }


</style>




 <style>

        ul#pagination-demo li
        {
            padding: 0 2px;
        }
       ul#pagination-demo li a
        {
           border-radius: 5px;
        }

        .page-active {
            display: block;
        }
        .page.active a
        {
            background: #007bff;
            color: #FFFFFF;
        }


        .title_list_parts {
            margin-top: 24px;
        }
        .info_parts_list {
            position: absolute;
            bottom: 0;
            color: #a8a8a8;
        }

        .border_space_parts {
            border-bottom: 2px dotted;
            padding: 14px 0;
        }


        .image_list_parts img
        {
            width: 100%;
        }

        .parts_list_her {
            border-bottom: 1px solid #c9c7c7;
            position: relative;
            height: 37px;
            padding-right: 39px;
        }

        .parts_list_her span {
            border-bottom: 0px solid #00a3c8;
            font-size: 22px;
            padding: 0px 55px 0 54px;
            position: relative;
        }
        .parts_list_her span:after {
            content: '___';
            position: absolute;
            width: 100%;
            text-align: center;
            right: 0;
            font-family: FontAwesome;
            color: #00a3c8;
            z-index: 1;
            border-bottom: 1px solid #00a3c8;
            font-size: 52px;
            bottom: 0;
            font-weight: bold;
            line-height: 1.06;
        }

        .content_tab_parts_hospital
        {

            padding-top: 30px;
        }

        .tab_parts_hospital.nav-tabs .nav-item.show .nav-link, .tab_parts_hospital.nav-tabs .nav-link.active {
            color:blue;
            background-color: transparent;
        }

        .tab_parts_hospital.nav-tabs .nav-item {
            border: 1px solid transparent;
            border-radius: 0;
            margin-left: 2px;
            background: transparent;
            color: #0e0e0e;
            position: relative;
        }
        .tab_parts_hospital.nav-tabs .nav-item.show .nav-link, .tab_parts_hospital.nav-tabs .nav-link.active:before {
            content: ' ___';
            position: absolute;
            width: 100%;
            text-align: center;
            right: 0;
            font-family: FontAwesome;
            color: #00a3c8;
            z-index: 1;
            border-bottom: 1px solid #00a3c8;
            font-size: 54px;
            bottom: 0;
            font-weight: bold;
            line-height: 1.04;
        }

        a.btn.top_view_parts {
            background: #e56353;
            border-radius: 0;
            color: #ffffff;
        }

        .container_tab_slider {
            border-top: 2px solid #999999;
            padding-top: 1px;
        }

        .image_parts_list {
            display: block;


        }

        .image_parts_list img {
            width: 100%;
            height: 178px;

        }

        .info_parts_publishing {
            text-align: left;
        }

        .title_parts_list {
            margin-bottom: 9px;
            margin-top: 5px;
            height: 52px;
            overflow: hidden;
        }


    </style>



<?php $this->publicFooter(); ?>