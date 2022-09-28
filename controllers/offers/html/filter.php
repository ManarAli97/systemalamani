<?php if ($offers) { ?>
<?php foreach ($offers as $printContent) {   ?>

    <div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">

        <div  class="infoDevice">
			 <div class='ribbon_offers'>
              <p class='text-ribbon'>  عروض <br> كل  يوم</p> 
            </div>
            <a href="<?php echo url .'/'. $this->folder?>/details/<?php echo $printContent['id'] ?>"  >


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

<?php  } else {  ?>
    <div class="col-12">

    <div class="alert alert-warning" role="alert">
        لا توجد عروض
    </div>
    </div>

<?php  } ?>