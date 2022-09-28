<?php  $this->publicHeader($this->langSite('search'));  ?>

<script>
    $('#text_search_return').val('<?php  echo $search ?>');

    $(document).ready(function(){
        catg="<?php  echo $_GET['cat'] ?>";
        $("select.form-control.form-control.dropdownCatg option").each(function(){
            if($(this).val()===catg){ // EDITED THIS LINE
                $(this).attr("selected","selected");
            }
        });
    });
</script>

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
                            <li class="breadcrumb-item">   بحث  </a></li>
                            <li class="breadcrumb-item">  <?php  echo $search ?> </a></li>

                        </ol>
                    </nav>









                <?php  if (!empty($content) || !empty($offers) )  { ?>


                    <div class="row" >

                        <?php foreach ($offers as $printContent) {   ?>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">

                                <div  class="infoDevice">

                                    <a href="<?php echo url ?>/offers/details/<?php echo $printContent['id'] ?>"  >


                                        <div class="hoverBtn">
                                            <button class="btn"><i class="fa fa-search"></i> </button>
                                        </div>
                                        <div class="imageDevise">
                                            <?php   if ($printContent['countdown'] == 1) {  ?>
                                                <div class="end_offer_list" id="getting-started<?php echo $printContent['id'] ?>">
                                                    <script type="text/javascript">
                                                        $("#getting-started<?php echo $printContent['id'] ?>")
                                                            .countdown("<?php  echo date('Y/m/d H:i:s',$printContent['todate'])  ?>", function(event) {
                                                                $(this).text(
                                                                    event.strftime('%D يوم -  %H:%M:%S')
                                                                );
                                                            });
                                                    </script>
                                                </div>
                                            <?php } ?>
                                            <img   src="<?php echo $printContent['image'] ?>" alt="لا توجد صورة">
                                        </div>
                                    </a>

                                    <div class="nameDevice">
                                        <?php echo $printContent['title'] ?>
                                    </div>
                                    <textarea  disabled class="form-control description"><?php echo $printContent['description'] ?></textarea>
                                    <div class="row justify-content-center   align-items-center">
                                        <div class="col-auto">
                                            <div class="pricDevice" >
                                                <?php echo $printContent['range'] ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['priceC'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        <?php  } ?>



                        <?php foreach ($content as $printContent) {   ?>
                        <!--      mobile-->

                        <?php   if ($printContent['type_cat'] =='mobile') {  ?>

                                <div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">

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

                                                            <button type="button" class="btn btn_cart" onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','mobile')">
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

                        <?php  } ?>

                        <!--                 end   mobile-->

                            <!--      savers-->

                        <?php   if ($printContent['type_cat'] =='savers') {  ?>

                                <div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">



                                    <div   class="infoDevice">
                                        <?php  if ($printContent['bast_it'] == 1 ) { ?>
                                            <div class="bast_device">
                                                <?php echo $this->langSite('bast_it') ?>
                                            </div>

                                        <?php } ?>
                                        <a href="<?php echo url ?>/savers/details/<?php echo $printContent['id'] ?>/<?php echo $printContent['id_cat_customer'] ?>"  >
                                            <div class="hoverBtn">
                                                <button class="btn"><i class="fa fa-search"></i> </button>
                                            </div>
                                            <div class="imageDevise">
                                                <img   src="<?php echo $printContent['image'] ?>" alt="لا توجد صورة">

                                            </div>


                                        <div class="nameDevice">
                                            <?php echo $printContent['title'] ?>
                                        </div>

<!-- 
                                                <div style="text-align: center;font-weight: bold" >
                                                    < ?php echo $printContent['title_device'] ?>
                                                </div> -->




                                        </a>

                                        <div class="pricDevice">
                                            <?php echo $printContent['price'] ?>
                                        </div>




                                        <?php  if ($this->ch_wcprice() ) {  ?>
                                            <table class="table table-bordered table-striped table_wholesale_price">

                                                <tbody>

                                                <?php if ($this->wcprice(1)) { ?>

                                                    <tr>
                                                        <td>جملة</td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button" class="btn btn-sm add_type_price"  onclick="addToCartCover(<?php echo $printContent['id'] ?>,<?php echo $printContent['id_cat'] ?>,<?php echo $printContent['id_cat_customer'] ?>,1)" >  <?php echo $printContent['wholesale_price'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($this->wcprice(2)) { ?>
                                                    <tr>
                                                        <td>جملة الجملة</td>
                                                        <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addToCartCover(<?php echo $printContent['id'] ?>,<?php echo $printContent['id_cat'] ?>,<?php echo $printContent['id_cat_customer'] ?>,2)" >  <?php echo $printContent['wholesale_price2'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price2'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($this->wcprice(3)) { ?>
                                                    <tr>
                                                        <td>التكلفة</td>
                                                        <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addToCartCover(<?php echo $printContent['id'] ?>,<?php echo $printContent['id_cat'] ?>,<?php echo $printContent['id_cat_customer'] ?>,3)" > <?php echo $printContent['cost_price'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['cost_price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>

                                        <?php } ?>





                                        <div class="c_device">
                                            <div class="addedToCart_savers<?php echo $printContent['id'] ?>"></div>



                                            <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>
                                                <?php if ($this->phone=='true' || $this->isDirect()) {   ?>
                                                     <button type="button" class="btn btn_cart" onclick="addToCartCover(<?php echo $printContent['id'] ?>,<?php echo $printContent['id_cat'] ?>,<?php echo $printContent['id_cat_customer'] ?>)">
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

                                    </div>



                                </div>

                        <?php  } ?>

                        <!--                 end   savers-->

                        <!--      camera-->

                    <?php   if ($printContent['type_cat']  =='camera') {  ?>


                                <div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">

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
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button" class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','camera',1)" >  <?php echo $printContent['wholesale_price'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($this->wcprice(2)) { ?>
                                                    <tr>
                                                        <td>جملة الجملة</td>
                                                        <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','camera',2)" >  <?php echo $printContent['wholesale_price2'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price2'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($this->wcprice(3)) { ?>
                                                    <tr>
                                                        <td>التكلفة</td>
                                                        <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','camera',3)" >  <?php echo $printContent['cost_price'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['cost_price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>

                                        <?php } ?>




                                        <div class="c_device">
                                            <div class="addedToCart_camera<?php echo $printContent['id'] ?>"></div>

                                            <div class="row align-items-center justify-content-center">

                                                <div class="col-lg-8 col-md-8 col-sm-12  xcartp"  >

                                                    <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>


                                                        <?php if ($this->phone=='true' || $this->isDirect()) {   ?>

                                                            <button type="button" class="btn btn_cart" onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','camera')">
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
                                                <div class="col-lg-3 col-md-3 col-sm-12">
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


                    <?php  }  ?>

                        <!--  end   camera-->


                        <!--      printing_supplies-->

                    <?php   if ($printContent['type_cat']  =='printing_supplies') {  ?>


                                <div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">

                                    <div  class="infoDevice">
                                        <?php  if ($printContent['bast_it'] == 1 ) { ?>
                                            <div class="bast_device">
                                                <?php echo $this->langSite('bast_it') ?>
                                            </div>

                                        <?php } ?>

                                        <a href="<?php echo url ?>/printing_supplies/details/<?php echo $printContent['id'] ?>"  >
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
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button" class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','printing_supplies',1)" >  <?php echo $printContent['wholesale_price'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($this->wcprice(2)) { ?>
                                                    <tr>
                                                        <td>جملة الجملة</td>
                                                        <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','printing_supplies',2)" >  <?php echo $printContent['wholesale_price2'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price2'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($this->wcprice(3)) { ?>
                                                    <tr>
                                                        <td>التكلفة</td>
                                                        <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','printing_supplies',3)" >  <?php echo $printContent['cost_price'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['cost_price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>

                                        <?php } ?>


                                        <div class="c_device">
                                            <div class="addedToCart_printing_supplies<?php echo $printContent['id'] ?>"></div>

                                            <div class="row align-items-center justify-content-center">

                                                <div class="col-lg-8 col-md-8 col-sm-12  xcartp"  >

                                                    <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>


                                                        <?php if ($this->phone=='true' || $this->isDirect()) {   ?>

                                                            <button type="button" class="btn btn_cart" onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','printing_supplies')">
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
                                                <div class="col-lg-3 col-md-3 col-sm-12">
                                                    <?php if (isset($_SESSION['username_member_r'])) { ?>

                                                        <button   type="button" class="btn btn_like    L_<?php echo $printContent['id']  ?> <?php  if ($printContent['like']) echo 'unlike'; else echo  'like' ?>"  onclick=<?php  if ($printContent['like']) echo "unlike_d(".$printContent['id'].",'printing_supplies')"; else echo "like_d(".$printContent['id'].",'printing_supplies')" ?>   >
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


                    <?php  }  ?>

                        <!--  end   printing_supplies-->


                        <!--      computer-->

                    <?php   if ($printContent['type_cat']  =='computer') {  ?>


                                <div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">

                                    <div  class="infoDevice">
                                        <?php  if ($printContent['bast_it'] == 1 ) { ?>
                                            <div class="bast_device">
                                                <?php echo $this->langSite('bast_it') ?>
                                            </div>

                                        <?php } ?>

                                        <a href="<?php echo url ?>/computer/details/<?php echo $printContent['id'] ?>"  >
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
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button" class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','computer',1)" >  <?php echo $printContent['wholesale_price'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($this->wcprice(2)) { ?>
                                                    <tr>
                                                        <td>جملة الجملة</td>
                                                        <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','computer',2)" >  <?php echo $printContent['wholesale_price2'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price2'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($this->wcprice(3)) { ?>
                                                    <tr>
                                                        <td>التكلفة</td>
                                                        <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','computer',3)" >  <?php echo $printContent['cost_price'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['cost_price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>

                                        <?php } ?>



                                        <div class="c_device">
                                            <div class="addedToCart_computer<?php echo $printContent['id'] ?>"></div>

                                            <div class="row align-items-center justify-content-center">

                                                <div class="col-lg-8 col-md-8 col-sm-12  xcartp"  >

                                                    <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>


                                                        <?php if ($this->phone=='true' || $this->isDirect()) {   ?>

                                                            <button type="button" class="btn btn_cart" onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','computer')">
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
                                                <div class="col-lg-3 col-md-3 col-sm-12">
                                                    <?php if (isset($_SESSION['username_member_r'])) { ?>

                                                        <button   type="button" class="btn btn_like    L_<?php echo $printContent['id']  ?> <?php  if ($printContent['like']) echo 'unlike'; else echo  'like' ?>"  onclick=<?php  if ($printContent['like']) echo "unlike_d(".$printContent['id'].",'computer')"; else echo "like_d(".$printContent['id'].",'computer')" ?>   >
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


                    <?php  }  ?>

                        <!--  end   computer-->

                        <!--      games-->

                    <?php   if ($printContent['type_cat']  =='games') {  ?>



                                <div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">

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
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button" class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','computer',1)" >  <?php echo $printContent['wholesale_price'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($this->wcprice(2)) { ?>
                                                    <tr>
                                                        <td>جملة الجملة</td>
                                                        <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','computer',2)" >  <?php echo $printContent['wholesale_price2'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price2'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($this->wcprice(3)) { ?>
                                                    <tr>
                                                        <td>التكلفة</td>
                                                        <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','computer',3)" >  <?php echo $printContent['cost_price'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['cost_price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>

                                        <?php } ?>



                                        <div class="c_device">
                                            <div class="addedToCart_games<?php echo $printContent['id'] ?>"></div>

                                            <div class="row align-items-center justify-content-center">

                                                <div class="col-lg-8 col-md-8 col-sm-12  xcartp"  >

                                                    <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>


                                                        <?php if ($this->phone=='true' || $this->isDirect()) {   ?>

                                                            <button type="button" class="btn btn_cart" onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','games')">
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
                                                <div class="col-lg-3 col-md-3 col-sm-12">
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



                    <?php  }  ?>

                        <!--  end   games-->


                        <!--      network-->

                        <?php   if ($printContent['type_cat']  =='network') {  ?>

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
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button" class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','network',1)" >  <?php echo $printContent['wholesale_price'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($this->wcprice(2)) { ?>
                                                    <tr>
                                                        <td>جملة الجملة</td>
                                                        <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','network',2)" >  <?php echo $printContent['wholesale_price2'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price2'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($this->wcprice(3)) { ?>
                                                    <tr>
                                                        <td>التكلفة</td>
                                                        <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','network',3)" >  <?php echo $printContent['cost_price'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['cost_price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>

                                        <?php } ?>


                                        <div class="c_device">
                                            <div class="addedToCart_network<?php echo $printContent['id'] ?>"></div>

                                            <div class="row align-items-center justify-content-center">

                                                <div class="col-lg-8 col-md-8 col-sm-12  xcartp"  >

                                                    <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>


                                                        <?php if ($this->phone=='true' || $this->isDirect()) {   ?>

                                                            <button type="button" class="btn btn_cart" onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','network')">
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
                                                <div class="col-lg-3 col-md-3 col-sm-12">
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
                          <?php  } ?>


                        <!--  end   network-->

                        <!--      accessories-->

                        <?php  if ($printContent['type_cat']  == 'accessories') {  ?>


                                <div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">

                                    <div  class="infoDevice">

                                        <?php  if ($printContent['bast_it'] == 1 ) { ?>
                                            <div class="bast_device">
                                                <?php echo $this->langSite('bast_it') ?>
                                            </div>

                                        <?php } ?>


                                        <a href="<?php echo url ?>/accessories/details/<?php echo $printContent['id'] ?>/<?php echo $printContent['id_cat_customer'] ?>"  >
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
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button" class="btn btn-sm add_type_price"  onclick="addedToCart_accessories(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','<?php echo $printContent['id_cat'] ?>','<?php echo $printContent['id_cat_customer'] ?>',1)" >  <?php echo $printContent['wholesale_price'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($this->wcprice(2)) { ?>
                                                    <tr>
                                                        <td>جملة الجملة</td>
                                                        <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addedToCart_accessories(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','<?php echo $printContent['id_cat'] ?>','<?php echo $printContent['id_cat_customer'] ?>',2)" >  <?php echo $printContent['wholesale_price2'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price2'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($this->wcprice(3)) { ?>
                                                    <tr>
                                                        <td>التكلفة</td>
                                                        <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addedToCart_accessories(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','<?php echo $printContent['id_cat'] ?>','<?php echo $printContent['id_cat_customer'] ?>',3)" >  <?php echo $printContent['cost_price'] ?> </button> </td>
                                                        <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['cost_price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>

                                        <?php } ?>




                                        <div class="c_device">
                                            <div class="addedToCart_acc<?php echo $printContent['id'] ?>"></div>

                                            <div class="row align-items-center justify-content-center">

                                                <div class="col-lg-8 col-md-8 col-sm-12  xcartp"  >

                                                    <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>
                                                        <?php if ($this->phone=='true' || $this->isDirect()) {   ?>
                                                            <button type="button" class="btn btn_cart" onclick="addedToCart_accessories(<?php echo $printContent['id'] ?>,'<?php echo $printContent['code'] ?>','<?php echo $printContent['id_cat'] ?>','<?php echo $printContent['id_cat_customer'] ?>')">
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
                                                <div class="col-lg-3 col-md-3 col-sm-12 ">
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
                            <?php  } ?>


                        <!--   end    accessories-->



                            <script>

                                function  like_d(id,model) {

                                    $.get('<?php echo url ?>/'+model+'/like_d/'+id, function(data){
                                        if (data==='done')
                                        {

                                            $('.L_'+id).attr('onclick','unlike_d('+id+')');
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
                                            $('.L_'+id).attr('onclick','like_d('+id+')');
                                            $('.L_'+id).removeClass('unlike');

                                        }else
                                        {
                                            alert("Error")
                                        }

                                    });
                                }


                                function addToCart(id,code,model,price_type=null) {

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

                                function addedToCart_accessories(id,code,id_catgory = 0,id_catg_customer =0,price_type=null) {
                                    var  dataD={'id_item':id,'code':code,'price_type':price_type};
                                    $.get('<?php echo url ?>/accessories/cart_order'+'/'+id_catgory+'/'+id_catg_customer, { jsonData: JSON.stringify( dataD )}, function(data){

                                        if (data !=='finish')
                                        {
                                            $.get("<?php echo url ?>/accessories/count_c" , function(e) {
                                                $('span.count_item').text(e);
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

                                function addToCartCover(id,id_cat=0,id_cat_customer=0,price_type=null) {

                                     $.get('<?php echo url ?>/savers/cart_order/'+id,{price_type:price_type}, function(data){
                                         if (data !=='finish')
                                         {
                                             $.get("<?php echo url ?>/savers/count_c" , function(e) {
                                                 $('span.count_item').text(e);
                                             });
                                             $('.addedToCart_savers'+id).html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa fa-check-circle"> </i>  <span> تمت الاضافة  </span>
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                           </button>
                                     </div>`);
                                             $('.button_buy').css('display','block');
                                             $('.empty_car').css('display','none');
                                             $('.item_cat').html(data);
                                             setTimeout(function(){
                                                 $('.addedToCart_savers'+id).empty();
                                             }, 4000);

                                         }else
                                         {
                                             alert('نفذت الكمية')
                                         }
                                     });

                                 }



                             </script>




                       <?php  } ?>

                    </div>


                   <?php } else {   ?>
                                <div class="alert alert-danger" role="alert">
                                     لا توجد نتائج اعد المحاولة.
                                </div>

                     <?php } ?>

                    <br>


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


</script>


<br>
<br>
<br>
<?php $this->publicFooter(); ?>