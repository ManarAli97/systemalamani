
<div class="tab-content contentTabPhoneModel" id="myTabContent">
    <?php foreach ($category_mobile as $key => $cat_tab) {   ?>

        <div class="tab-pane  <?php if ($key==0) echo 'show active' ?>  " id="mobileCat_<?php echo $id ?>" role="tabpanel" aria-labelledby="mobile-tab_<?php echo  $id ?>">

            <div class="phoneModel">

                <div class="control_slider">
                    <div class="row">
                        <div class="col-auto border" style="width: 50px">
                            <a class="carousel-control-prev row_prev" href="#carouselExampleControlsPhone-<?php echo  $id ?>" role="button" data-slide="prev">
                                <i class="fa fa-chevron-left"></i>
                            </a>
                            <a class="carousel-control-next row_next" href="#carouselExampleControlsPhone-<?php echo  $id  ?>" role="button" data-slide="next">
                                <i class="fa fa-chevron-right"></i>
                            </a>

                        </div>

                        <div class="col-auto  titleCatLg">
                            موبايلات
                        </div>
                    </div>
                </div>

                <div id="carouselExampleControlsPhone-<?php echo $id ?>" class="carousel slide" data-ride="carousel" >
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

                                                <?php  if ($printContent['stop'] ==1 ) { ?>
                                                <div class="stop_device">
                                                    <?php echo $this->langSite('stop_product') ?>
                                                </div>
                                                <a href="<?php echo url ?>/mobile/stop/<?php echo $printContent['id'] ?>/<?php echo $printContent['code'] ?>"  >
                                                    <?php  } else if ($printContent['q'] ==0 ) { ?>
                                                    <div class="stop_device">
                                                        <?php echo $this->langSite('out_of_quantity') ?>
                                                    </div>
                                                    <a href="<?php echo url ?>/mobile/stop/<?php echo $printContent['id'] ?>/<?php echo $printContent['code'] ?>"  >
                                                        <?php  }else{   ?>
                                                        <a href="<?php echo url ?>/mobile/details/<?php echo $printContent['id'] ?>"  >
                                                            <?php  }  ?>
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


                                                        <div class="nameDevice">
                                                            <?php echo $printContent['title'] ?>

                                                        </div>
                                                        <textarea  disabled class="form-control description"><?php echo $printContent['description'] ?></textarea>

                                                    </a>
                                                    <div class="row justify-content-center   align-items-center">
                                                        <div class="col-auto">
                                                            <div class="pricDevice" >
                                                                <?php echo $printContent['price'] ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['priceC'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button>
                                                        </div>
                                                    </div>

                                                    <?php  if ($this->ch_wcprice() ) {  ?>
                                                        <table class="table table-bordered table-striped table_wholesale_price">

                                                            <tbody>

                                                            <?php if ($this->wcprice(1)) { ?>

                                                                <tr>
                                                                    <td>جملة</td>
                                                                    <td> <button data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button" class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','mobile',1)" >  <?php echo $printContent['wholesale_price'] ?> </button> </td>
                                                                    <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                                </tr>
                                                            <?php } ?>
                                                            <?php if ($this->wcprice(2)) { ?>
                                                                <tr>
                                                                    <td>جملة الجملة</td>
                                                                    <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','mobile',2)" >  <?php echo $printContent['wholesale_price2'] ?> </button> </td>
                                                                    <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price2'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                                </tr>
                                                            <?php } ?>
                                                            <?php if ($this->wcprice(3)) { ?>
                                                                <tr>
                                                                    <td>التكلفة</td>
                                                                    <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','mobile',3)" >  <?php echo $printContent['cost_price'] ?> </button> </td>
                                                                    <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['cost_price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                                </tr>
                                                            <?php } ?>
                                                            </tbody>
                                                        </table>

                                                    <?php } ?>


                                                    <div class="c_device">
                                                        <div class="addedToCart_mobile<?php echo $printContent['id'] ?>"></div>

                                                        <div class="row align-items-center justify-content-center">

                                                            <?php  if ($printContent['stop'] ==1 ||  $printContent['q'] == 0 ) { ?>

                                                                <div class="col-lg-10 col-md-12 col-sm-auto  xcartp"  >

                                                                    <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>


                                                                        <?php if ($this->phone=='true' || $this->isDirect()) {   ?>

                                                                            <a href="<?php echo url ?>/mobile/stop/<?php echo $printContent['id'] ?>/<?php echo $printContent['code'] ?>" type="button" class="btn btn_cart"  >
                                                                                <span>  عرض الاجهزة المشابهه  </span>
                                                                            </a>
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


                                                            <?php  } else {  ?>
                                                                <div class="col-lg-7 col-md-12 col-sm-auto  xcartp"  >

                                                                    <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>


                                                                        <?php if ($this->phone=='true' || $this->isDirect()) {   ?>

                                                                            <button type="button" class="btn btn_cart" onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','<?php echo $this->folder ?>')">
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
                                                                <div class="col-lg-5 col-md-12 col-sm-auto">
                                                                    <?php if (isset($_SESSION['username_member_r'])) { ?>

                                                                        <button   type="button" class="btn btn_like style_btn_like_mb   L_<?php echo $printContent['id']  ?> <?php  if ($printContent['like']) echo 'unlike'; else echo  'like' ?>"  onclick=<?php  if ($printContent['like']) echo "unlike_d(".$printContent['id'].",'mobile')"; else echo "like_d(".$printContent['id'].",'mobile')" ?>   >
                                                                            <i class="fa fa-heart"></i>
                                                                        </button>
                                                                        <button   title="اضافة المنتج الى خانة المقارنة بين المنتجات" type="button" class="btn comparison comp_<?php echo $printContent['id']  ?> <?php  if ($printContent['comparison']) echo 'un_comparison'; else echo  'comparison' ?>"  onclick=<?php  if ($printContent['comparison']) echo "un_comparison_d(".$printContent['id'].",'mobile')"; else echo "comparison_d(".$printContent['id'].",'mobile')" ?>   >
                                                                            <i class="fa fa-exchange"></i>
                                                                        </button>
                                                                    <?php } else { ?>

                                                                        <button type="button" class="btn btn_like style_btn_like_mb  "   data-toggle="modal" data-target="#login_site">
                                                                            <i class="fa fa-heart"></i>
                                                                        </button>
                                                                        <button type="button" class="btn comparison"   data-toggle="modal" data-target="#login_site">
                                                                            <i class="fa fa-exchange"></i>
                                                                        </button>
                                                                    <?php } ?>

                                                                </div>
                                                            <?php  } ?>
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
