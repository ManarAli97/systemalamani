<?php  if (!empty($data_view)) {  ?>


    <div class="row" >
        <?php foreach ($data_view as $printContent) {   ?>

            <div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">

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
                    <textarea  disabled class="form-control description"><?php echo $printContent['description'] ?></textarea>
                    <div class="row justify-content-center   align-items-center">
                        <div class="col-auto">
                            <?php  if ($printContent['cuts'] == 1 ) { ?>
                                <div class="pricDevice" style="display: block">
                                    <!--                                            <div class="oldXPrice" style="text-decoration: line-through;">--><?php //echo $printContent['price'] ?><!-- </div>-->
                                    <div class="price_cuts" style="color: green;font-weight: bold"> <?php echo $printContent['price_cuts'] ?> د.ع   </div>
                                </div>
                            <?php  } else{ ?>
                                <div class="pricDevice" >
                                    <?php echo $printContent['price'] ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-auto">
                            <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['priceC'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button>
                        </div>
                    </div>

                    <div class="c_device">
                        <div class="addedToCart_network<?php echo $printContent['id'] ?>"></div>

                        <div class="row align-items-center justify-content-center">

                            <div class="col-lg-8 col-md-8 col-sm-auto  xcartp"  >

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
                            <div class="col-lg-3 col-md-3 col-sm-auto">
                                <?php if (isset($_SESSION['username_member_r'])) { ?>

                                    <button   type="button" class="btn btn_like    L_<?php echo $printContent['id']  ?> <?php  if ($printContent['like']) echo 'unlike'; else echo  'like' ?>"  onclick=<?php  if ($printContent['like']) echo "unlike_d(".$printContent['id'].",'mobile')"; else echo "like_d(".$printContent['id'].",'mobile')" ?>   >
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
        <?php  } ?>

    </div>


    <br>
    <div class="row justify-content-center">
        <div class="col-auto ">
            <ul id="pagination-demo" class="pagination "></ul>
        </div>
    </div>




<?php  }else {     ?>


    <div class="alert alert-danger" role="alert">
        لا توجد نتائج اعد المحاولة.
    </div>


<?php  }  ?>