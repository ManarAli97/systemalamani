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
                            <li class="breadcrumb-item"> <?php  echo $this->langSite($this->folder) ?>  </li>

                        </ol>
                    </nav>


                <div class="container">
                <?php  if ($computer_assembly)  {  ?>
                    <div class="row" id="filter" >


                                <?php foreach ($computer_assembly as $printContent) {   ?>

                                    <div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">

                                        <div  class="infoDevice">


                                            <a href="<?php echo url .'/'. $this->folder?>/details/<?php echo $printContent['id'] ?>"  >


                                                <div class="hoverBtn">
                                                    <button class="btn"><i class="fa fa-search"></i> </button>
                                                </div>
                                                <div class="imageDevise">
                                                    <img  class="imgcomputer_assembly" src="<?php echo $printContent['image'] ?>" alt="لا توجد صورة">
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



                    </div>
                        <?php  } else {  ?>

                            <div class="alert alert-warning" role="alert">
                             لا توجد تجميعات
                            </div>

                       <?php  } ?>

                    <br>


                </div>
            </div>

        </div>
    </div>



<br>


<style>

    .menu_category
    {
        height:auto;
    }
    .imageDevise img.imgcomputer_assembly {

        object-fit: unset !important;
    }


</style>

<?php $this->publicFooter(); ?>