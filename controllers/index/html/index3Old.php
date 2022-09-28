<div class="container">


    <div class="row">
        <div class="col-lg-3">
            <?php    $this->menu->menu() ?>
        </div>

        <div class="col-lg-9">
            <div class="slider_product">


                <div id="carouselExampleControls" class="carousel slide " data-ride="carousel">
                    <div class="carousel-inner">

                        <?php  foreach ($gallery as $key=> $g_m) {  ?>
                        <div class="carousel-item <?php  if ($key==0)  echo 'active' ?> ">
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


    <br>

    <div class="row">
        <div class="col-lg-3">

            <div class="mail_list">

                <div class="title_m_l">
                    القائمة البريدية
                </div>
                <div class="text_m_l">
                    اشترك في القائمة البريدية ليييصلك جديد الاجهزة الواردة الينا
                </div>

                 <input type="text" class="form-control" name="">

                <input type="submit" name="submit" class="btn subscribe" value="SUBSCRIBE">


            </div>

        </div>

        <div class="col-lg-9">


            <div class="row">

                <div class="col-lg-8">

                    <?php  foreach ($ads_content as $key => $ads) {  ?>

                        <?php  if ($key==0) {  ?>
                    <div class="big_img_">
                        <img src="<?php  echo $ads['img']?>">
                    </div>

                    <div class="row">
                        <?php  } else {   ?>
                        <div class="col-6">
                          <div class="small_image">

                              <img src="<?php  echo $ads['img']?>">
                          </div>

                        </div>
                            <?php  if ($key==2) {  ?>
                            </div>
                           <?php  }  ?>
                        <?php  }  ?>



               <?php  }  ?>


                </div>
                <div class="col-lg-4">
                     <div class="resom">
                         <img src="https://cdn.pixabay.com/photo/2015/05/31/15/07/business-792113_960_720.jpg">
                     </div>
                </div>
            </div>

        </div>

    </div>



<br>
<br>

    <div class="row">
        <div class="col-lg-9">
            <div class="row justify-content-end">

                <div class="col-auto">

                    <ul class="nav tabDoor nav-tabs " id="myTab" role="tablist">

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

                                        <div class="col-auto  ">
                                        موبايلات
                                        </div>
                                    </div>
                                </div>

                                <div id="carouselExampleControlsPhone-<?php echo $cat_tab['id']?>" class="carousel slide" data-ride="carousel" >
                                <div class="carousel-inner">

                                    <?php  foreach ($cat_tab['content'] as $index=> $content) { ?>
                                    <div class="carousel-item  <?php if ($index==0) echo 'active' ?>  ">
                                        <div class="row">

                                            <?php  foreach ($content as $printContent)  { ?>

                                            <div class="col-lg-4">

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

                                                    <div class="pricDevice">
                                                        <?php echo $printContent['price'] ?> $
                                                    </div>
                                                    <div class="c_device">

                                                        <div class="row align-items-center">
                                                            <div class="col-3" style="text-align: center">
                                                                <img  class="icon_msg" src="<?php echo $this->static_file_site ?>/image/site/msg.png">
                                                            </div>
                                                            <div class="col-6" style="padding: 0">
                                                                <button type="button" class="btn btn_cart">
                                                                    <span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
                                                                </button>
                                                            </div>
                                                            <div class="col-3">
                                                                <button type="button" class="btn btn_like   ">
                                                                    <i class="fa fa-heart"></i>
                                                                </button>

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



        </div>
        <div class="col-lg-3">

            <div class="accessories">ملحقات</div>

            <div class="content_accessories">

                <?php foreach ($arraypartsAllCat as $part) {   ?>
                <div class="row_acce">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="title_acce"> <?php echo $part['title']?> </div>
                            <div class="pric_acee">
                                <?php echo $part['price']?>$
                            </div>
                        </div>
                        <div class="col-auto">
                            <img src=" <?php echo $part['img']?>">
                        </div>
                    </div>
                </div>
              <?php  } ?>


            </div>


        </div>

    </div>

<br>
<br>

    <div class="row">
        <div class="col-lg-9">






            <div id="carouselExampleControlsOffers" class="carousel slide  carousel-fade" data-ride="carousel">
                <div class="carousel-inner">

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

                <div class="col-auto">

                    <ul class="nav tabDoor nav-tabs " id="myTab_accessories" role="tablist">
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

                                            <div class="col-auto  ">
                                               اكسسورات منوعة
                                            </div>
                                        </div>
                                    </div>

                                    <div id="carouselExampleControlsAccessories-<?php echo $cat_tab['id']?>" class="carousel slide" data-ride="carousel" >
                                        <div class="carousel-inner">

                                            <?php  foreach ($cat_tab['content'] as $index=> $content) { ?>
                                                <div class="carousel-item  <?php if ($index==0) echo 'active' ?>  ">
                                                    <div class="row">

                                                        <?php  foreach ($content as $printContent)  { ?>

                                                            <div class="col-lg-4">

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
                                                                    <div class="pricDevice">
                                                                        <?php echo $printContent['price'] ?> $
                                                                    </div>
                                                                    <div class="c_device">

                                                                        <div class="row align-items-center">
                                                                            <div class="col-3" style="text-align: center">
                                                                                <img  class="icon_msg" src="<?php echo $this->static_file_site ?>/image/site/msg.png">
                                                                            </div>
                                                                            <div class="col-6" style="padding: 0">
                                                                                <button type="button" class="btn btn_cart">
                                                                                    <span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="col-3">
                                                                                <button type="button" class="btn btn_like   ">
                                                                                    <i class="fa fa-heart"></i>
                                                                                </button>

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
                    <div class="carousel-inner">

                        <?php  foreach ($arraygroupsAllCat as $key => $contentG)  { ?>
                        <div class="carousel-item <?php  if ($key == 0)  echo  'active'?> ">
                            <div class="row">
                                <?php  foreach ($contentG as   $c_g)  { ?>
                                <div class="col-3">
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





        </div>

        <div class="col-lg-3">
            <div class="customer_option">
                <div class="control_slider_customer_option">
                <div class="row justify-content-between">
                    <div class="col-auto">

                        رأي الزبائن
                    </div>


                    <div class="col-auto border" style="width: 50px">


                            <a class="carousel-control-prev row_prev" href="#carouselExampleControls_customer_option" role="button" data-slide="prev">
                                <i class="fa fa-chevron-left"></i>
                            </a>
                            <a class="carousel-control-next row_next" href="#carouselExampleControls_customer_option" role="button" data-slide="next">
                                <i class="fa fa-chevron-right"></i>
                            </a>


                    </div>
                </div>
                </div>
                 <div class="slider_customer_option">
                     <div id="carouselExampleControls_customer_option" class="carousel slide" data-ride="carousel">
                         <div class="carousel-inner">
                             <div class="carousel-item active">

                                 <div class="text_c_o">
                                     التعامل كان جيدا مع الشركة وحصلت على بطاقة ضمان لمدة سنتين السماعة كانت اصلية واستمتعت بيها كثيرا

                                 </div>

                                 <div class="user_r">
                                     <div class="row align-items-center">
                                         <div class="col-auto" style="padding-left: 0">
                                             <img class="image_mbr_u" src="https://cdn.pixabay.com/photo/2018/01/15/07/51/woman-3083378__340.jpg">

                                         </div>
                                         <div class="col">
                                             <div class="name_u"> علي صباح </div>
                                             <div class="date_u">  <span>2019 / 5/10  </span>   </div>

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


</div>


<br>
<br>
<br>
<br>
