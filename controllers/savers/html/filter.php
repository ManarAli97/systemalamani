<?php  if ($offers)  {  ?>

<?php foreach ($offers as $printContent) {   ?>

    <div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">

        <div  class="infoDevice">
                       <div class='ribbon_offers'>
                        <a href="<?php echo url ?>/offers/" >  <p class='text-ribbon'>  عروض <br> كل  يوم</p> </a>
                    </div>
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


<?php  } ?>


<?php   if (!empty($table)) {  ?>

<?php foreach ($table as $printContent) {   ?>

<div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">

<div   class="infoDevice">
    <?php  if ($printContent['bast_it'] == 1 ) { ?>
        <div class="bast_device">
            <?php echo $this->langSite('bast_it') ?>
        </div>

    <?php } ?>

    <?php

            foreach ($offers as $offersItem)
            {

                if($offersItem['code'] == $printContent['code']){  ?>

                    <div class='ribbon_offers'>
                        <a href="<?php echo url ?>/offers/" >  <p class='text-ribbon'>  عروض <br> كل  يوم</p> </a>
                    </div>
                <?php }


        }?>
    <a href="<?php echo url ?>/savers/details/<?php echo $printContent['id'] ?>/<?php echo $printContent['id_device_coustomer'] ?>"  >
        <div class="hoverBtn">
            <button class="btn"><i class="fa fa-search"></i> </button>
        </div>
        <div class="imageDevise">
            <img   src="<?php echo $printContent['image'] ?>" alt="لا توجد صورة">
        </div>


<!--     <div class="nameDevice">
        < ?php echo $printContent['title'] ?>
    </div> -->


            <div class='nameDevice' >
                <?php echo $printContent['title_device'] ?>
            </div>



    </a>
    <div class="pricDevice">
        <?php echo $printContent['price'] ?> &nbsp; &nbsp;
      <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button>

    </div>




    <?php  if ($this->ch_wcprice() ) {  ?>
        <table class="table table-bordered table-striped table_wholesale_price">

            <tbody>

            <?php if ($this->wcprice(1)) { ?>

                <tr>
                    <td>جملة</td>
                    <td> <button data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button" class="btn btn-sm add_type_price"  onclick="addToCartCover(<?php echo $printContent['id'] ?>,1,<?php echo $printContent['id_device'] ?>,<?php echo $printContent['id_device_coustomer'] ?>)" >  <?php echo $printContent['wholesale_price'] ?> </button> </td>
                    <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                </tr>
            <?php } ?>
            <?php if ($this->wcprice(2)) { ?>
                <tr>
                    <td>جملة الجملة</td>
                    <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addToCartCover(<?php echo $printContent['id'] ?>,2,<?php echo $printContent['id_device'] ?>,<?php echo $printContent['id_device_coustomer'] ?>)" >  <?php echo $printContent['wholesale_price2'] ?> </button> </td>
                    <td> <button data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $printContent['wholesale_price2'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                </tr>
            <?php } ?>
            <?php if ($this->wcprice(3)) { ?>
                <tr>
                    <td>التكلفة</td>
                    <td> <button  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button"  class="btn btn-sm add_type_price"  onclick="addToCartCover(<?php echo $printContent['id'] ?>,3,<?php echo $printContent['id_device'] ?>,<?php echo $printContent['id_device_coustomer'] ?>)" >  <?php echo $printContent['cost_price'] ?> </button> </td>
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
                        <button type="button" class="btn btn_cart" onclick="addToCartCover(<?php echo $printContent['id'] ?>,<?php echo $printContent['id_device'] ?>,<?php echo $printContent['id_device_coustomer'] ?>)">
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




<?php } else {  ?>




<div class="col-12">

<div class="alert alert-danger" role="alert">
لا توجد نتائج اعد المحاولة.
</div>
</div>





<?php } ?>