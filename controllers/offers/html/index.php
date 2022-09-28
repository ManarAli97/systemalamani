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


                <?php  if ($data_cat) {  ?>

                <div class="row">

                    <div class="col">
                        <select class="custom-select dropdown_filter"  id="category_offer"   >
                            <option value="all" >  كل العروض </option>
                            <?php foreach ($data_cat as $key => $catg) {   ?>
                                <option    value="<?php  echo $key ?>"><?php  echo  $catg ?></option>
                            <?php  } ?>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button  class="btn  btn_search_filter" onclick="search_offer()"    >بحث</button>
                    </div>

                </div>



                <style>
                    .dropdown_filter
                    {
                        border: 2px solid #495678;
                        border-radius: 15px;
                        margin-bottom: 15px;
                    }

                    .btn_search_filter
                    {
                        border: 2px solid #495678;
                        border-radius: 15px;
                        width: 100%;
                        margin-bottom: 15px;
                        background: #495678;
                        color: #ffff;
                    }

                </style>

                <br>


           <?php } ?>

                <div class="container">
                <?php  if ($offers)  {  ?>
                    <div class="row" id="filter" >


                                <?php foreach ($offers as $printContent) {   ?>

                                    <div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">

                                        <div  class="infoDevice">
                                          <div class='ribbon_offers'>
                                                <p class='text-ribbon'>  عروض<br> كل يوم</p>
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
                                                    <img  class="imgOffer" src="<?php echo $printContent['image'] ?>" alt="لا توجد صورة">
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
                             لا توجد عروض
                            </div>

                       <?php  } ?>

                    <br>


                </div>
            </div>

        </div>
    </div>


    <script>


        function search_offer() {

            $('#filter').html(`
            <div style="text-align:center;width: 100%;"> <img  width="50"  src="<?php echo $this->static_file_site ?>/image/site/loadingx.gif"  ></div>
            `
            );

            var catg= $('#category_offer option:selected').val()
            localStorage.setItem("offer_cat",catg);
            $.get("<?php echo url . '/' . $this->folder ?>/filter/"+catg, function (data) {

                $('#filter').html(data)
            });
        }


    </script>




<br>


<style>

    .menu_category
    {
        height:auto;
    }
    .imageDevise img.imgOffer {

        object-fit: unset !important;
    }


</style>

<?php $this->publicFooter(); ?>