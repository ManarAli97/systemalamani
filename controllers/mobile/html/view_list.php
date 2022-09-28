<?php  if (is_numeric($id)) { ?>
<?php  $this->publicHeader( $result['title']);  ?>


    <?php  if (isset($_SESSION['loggedIn'])) {  ?>
        <?php if ($this->pointer_sale_quantity($_SESSION['userid']) == true && $this->category_permit($this->folder,$this->userid))   { ?>
            <div class="request_order" style="text-align: center">
                <a class="btn btn-danger" href="<?php  echo url ?>/sales_man/add_by_category/<?php  echo $id .'/'.$this->folder ?>"    >  اخذ  الفئة   </a>
            </div>
        <?php  } ?>

        <?php if ($this->ifAdmin($_SESSION['userid'])) {  ?>
            <?php if ($this->pointer_purchases_quantity($_SESSION['userid']) == true && $this->category_permit($this->folder,$this->userid))   { ?>
                <div class="request_order" style="text-align: center">
                    <a class="btn btn-danger" href="<?php  echo url ?>/purchases_man/add_by_category/<?php  echo $id .'/'.$this->folder ?>"    >  اخذ فئة الفئة  </a>
                </div>
            <?php  } ?>
        <?php  } ?>

        <style>
            .request_order
            {
                position: fixed;
                bottom: 6px;
                text-align: center;
                width: 100%;
                z-index: 150;
            }

        </style>

    <?php  } ?>






<?php  } else {  ?>
    <?php  $this->publicHeader($this->langSite('mobile'));  ?>
<?php } ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-3">

                <?php $this->menu->menu() ?>






<!--                computer-->
                <?php  if (!empty($specifications)) { ?>

                   <div class="bgSilter d-none d-sm-none d-md-none d-lg-block">
                    <br>
                    <br>
                    <div class="title_filter">
                        <i onclick="openFilter()" class="fa fa-filter"></i> <span  onclick="openFilter()"> بحث المواصفات </span>
                    </div>

                    <div class="openFilter">
                        <form  id="filterForm"  action="<?php  echo url .'/'.$this->folder ?>/filter/<?php  echo  $id ?>" method="post">
                    <div class="filter">

                            <div class="row">

                                <div class="col-12">
                                    <span style="font-weight: bold;margin-bottom: 5px;display: block;" >الاقسام</span>
                                    <select name="catgFilter" class="custom-select   custom-select-md" id="CatgFilter">
                                        <option value="all" selected> كل الاقسام </option>
                                        <?php foreach ($catRange as $cat) {  ?>
                                            <option <?php  if ($cat['id'] == $id) echo 'selected'?> value="<?php   echo   $cat['id'] ?>"><?php   echo   $cat['title'] ?></option>
                                        <?php }  ?>
                                    </select>
                                </div>
                                <?php foreach ($specifications as $specific) {   ?>
                                    <div class="col-12" style="margin-bottom: 30px">

                                        <div style="margin-bottom: 7px;font-weight: bold;">
                                            <?php  echo $specific['title'] ?>
                                        </div>
                                        <?php  foreach ($specific['items'] as $key => $itms ) {  ?>
                                            <div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio"  value="<?php  echo $itms['id']?>" id="customradio_<?php  echo  $itms['id']  ?>" name="specifications[<?php  echo $specific['id']?>][]" class="custom-control-input">
                                                    <label class="custom-control-label" for="customradio_<?php  echo  $itms['id']  ?>">  <?php  echo $itms['item']?> </label>
                                                </div>
                                            </div>
                                        <?php  }  ?>
                                    </div>

                                <?php } ?>


                            </div>



                    </div>

                    <div class="SearchFilter">
                          <div></div>

                         <button  type="submit" class="btn btnSearchFilter"><i class="fa fa-filter"></i> <span>بحث</span> </button>

                        <div class="loading_filter"><img  src="<?php echo $this->static_file_site ?>/image/site/loding.gif" ></div>

                    </div>

            </form>
                        </div>

                    <style>
                        .menu_category {
                            padding-top: 26px;
                            height: auto;
                            padding-bottom: 26px;
                        }
                        .bgSilter  .title_filter i.fa.fa-filter
                        {
                            color: #ffffff;
                            background: #283581;
                            width: 35px;
                            height: 35px;
                            border-radius: 6px;
                            text-align: center;
                            font-size: 25px;
                            padding-top: 4px;
                            cursor: pointer;
                        }
                        .bgSilter .title_filter i.fa.fa-filter:hover
                        {
                            color: #ffffff;
                            background: #ff5722;

                        }

                        .bgSilter .title_filter span
                        {

                            font-size: 18px;
                            padding-right: 8px;
                            cursor: pointer;
                        }
                        .bgSilter .filter {
                            border: 1px solid #d6d6d6;
                            margin-top: 9px;
                            padding: 9px 7px;
                            max-height: 808px;
                            overflow: hidden;
                            overflow-y: auto;
                            position: relative;
                            border-bottom: 0;
                        }

                        .bgSilter .SearchFilter
                        {
                            text-align: center;
                            border: 1px solid #d6d6d6;
                            border-top: 0;
                            padding: 0 0 10px 0;
                            position: relative;
                        }
                        .bgSilter .SearchFilter div
                        {
                            margin-bottom: 10px;
                            border-top:1px solid #d6d6d6;
                        }

                        .bgSilter .btnSearchFilter
                        {
                            background: #283581;
                            color: #ffffff;
                            padding: 4px 27px;
                            font-size: 18px;
                            border-radius: 0;

                        }

                        .bgSilter select#CatgFilter {
                            margin-bottom: 24px;
                            border-radius: 0;
                        }

                        .bgSilter .loading_filter
                        {
                            width: 43px;
                            height: 41px;
                            border: 0 !important;
                            position: absolute;
                            top: 8px;
                            right: 12px;
                            display: none;
                        }


                        .bgSilter .openFilter
                        {
                            max-height: 890px;
                            overflow: hidden;
                            transition: 0.5s;
                        }


                        .bgSilter .openFilter.fltr_close
                        {
                            max-height: 0;
                            overflow: hidden;
                            transition: 0.5s;
                        }

                    </style>


                    <script>

                        $("#filterForm").submit(function(e) {

                            $('.loading_filter').show();
                            e.preventDefault();
                            var form = $(this);
                            var url = form.attr('action');
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: form.serialize() + '&submit=submit',
                                success: function (data) {
                                    $('.loading_filter').hide();
                                    if (data)
                                    {

                                        if (data)
                                        {
                                            $('.range_data').html(data);
                                        }
                                        $('html, body').animate({
                                            scrollTop: $(".path_bread").offset().top
                                        }, 500);
                                    }else
                                    {
                                        alert('يرجى تحديد المواصفات!')
                                    }

                                }
                            })
                        });


                        function openFilter () {
                            $('.openFilter').toggleClass("fltr_close");
                        }

                    </script>

                   </div>
                <?php  }  ?>



            </div>

            <div class="col-lg-9">

                <br>


                    <nav aria-label="breadcrumb" class="path_bread">
                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="<?php  echo url ?>"><i class="fa fa-home"></i> </a></li>

                           <?php  if (is_numeric($id)) { ?>
                            <?php if ($breadcumbs){ foreach ($breadcumbs as $key => $bc) {   ?>

                                <li class="breadcrumb-item   <?php   if ($bc == "#" ) echo 'active'?> "  aria-current="page" > <?php if ($bc != "#" ) echo "<a href='{$bc}'>{$key} </a>"; else echo $key ?> </li>

                            <?php  } } ?>
                            <?php  } else {  ?>
                               <li class="breadcrumb-item active">  <?php echo $this->langSite('mobile') ?>  </li>

                           <?php } ?>

                        </ol>
                    </nav>



                <div class="formRange_her">

				<?php  if ($range) {  ?>
                    <form id="idForm_range" action="<?php  echo url .'/'.$this->folder ?>/range" method="post">



                            <div class="slider_range">


                                <div  class="row justify-content-between price-range-block">


                                    <div class="col-auto">


                                        <div class="input-group setting_range  ">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">000,</div>
                                            </div>
                                            <input type="text"  autocomplete="off" name="max_range" onkeyup="numberOnly(this)"  oninput="validity.valid||(value='2000');" id="max_price" class="price-range-field form-control" />
                                        </div>
                                    </div>
                                    <div class="col-auto">

                                        <div class="input-group setting_range  ">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">000,</div>
                                            </div>
                                            <input type="text"   autocomplete="off" name="min_range"  onkeyup="numberOnly(this)"  oninput="validity.valid||(value='0');" id="min_price" class="price-range-field form-control" />
                                        </div>

                                    </div>
                                    <div class="col-12">
                                        <div id="slider-range" class="price-filter-range" name="rangeInput"></div>
                                    </div>
                                </div>

                            </div>



                            <div class="row">
                                <div class="col">
                                    <select name="catRg" class="custom-select   custom-select-md" id="inlineFormCustomSelect">
                                        <option value="all" selected> كل الاقسام </option>
										<?php foreach ($catRange as $cat) {  ?>
                                            <option <?php  if ($cat['id'] == $id) echo 'selected'?> value="<?php   echo   $cat['id'] ?>"><?php   echo   $cat['title'] ?></option>
										<?php }  ?>
                                    </select>
                                </div>
                                <div class="col-auto">

                                    <button type="submit" name="submit"  class="btn btn_search_range" > بحث </button>

                                </div>
                            </div>



                    </form>
				<?php  }  ?>
                   <div class="control_sort">
                    <div class="row">

                        <div class="col-auto">
                            <button class="btn d-block d-lg-none" onclick="openFilter()" > <i class="fa fa-filter"></i>  <span> فرز </span> </button>
                        </div>
                        <div class="col-auto">
                            <button class="btn sort_class" onclick="sort_desc(this)" > <i class="fa fa-sort-amount-desc"></i> <span> تنازلي حسب السعر</span> </button>
                        </div>
                        <div class="col-auto">
                            <button class="btn sort_class" onclick="sort_asc(this)" > <i class="fa fa-sort-amount-asc"></i>  <span> تصاعدي حسب السعر</span>  </button>
                        </div>
                    </div>
                </div>
            </div>



<!--                mobile-->
                <?php  if (!empty($specifications)) { ?>

                    <div class="smSilter d-block d-lg-none" style="margin-top: 10px;margin-bottom: 23px">



                        <div class="openFilter fltr_close">
                            <form  id="filterForm2"  action="<?php  echo url .'/'.$this->folder ?>/filter/<?php  echo  $id ?>" method="post">
                                <div class="filter">

                                    <div class="row">

                                        <div class="col-12">
                                            <span style="font-weight: bold;margin-bottom: 5px;display: block;" >الاقسام</span>
                                            <select name="catgFilter" class="custom-select   custom-select-md" id="CatgFilter">
                                                <option value="all" selected> كل الاقسام </option>
                                                <?php foreach ($catRange as $cat) {  ?>
                                                    <option <?php  if ($cat['id'] == $id) echo 'selected'?> value="<?php   echo   $cat['id'] ?>"><?php   echo   $cat['title'] ?></option>
                                                <?php }  ?>
                                            </select>
                                        </div>
                                        <?php foreach ($specifications as $specific) {   ?>
                                            <div class="col-12" style="margin-bottom: 30px">

                                                <div style="margin-bottom: 7px;font-weight: bold;">
                                                    <?php  echo $specific['title'] ?>
                                                </div>
                                                <?php  foreach ($specific['items'] as $key => $itms ) {  ?>
                                                    <div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio"  value="<?php  echo $itms['id']?>" id="customradio2_<?php  echo  $itms['id']  ?>" name="specifications[<?php  echo $specific['id']?>][]" class="custom-control-input">
                                                            <label class="custom-control-label" for="customradio2_<?php  echo  $itms['id']  ?>">  <?php  echo $itms['item']?> </label>
                                                        </div>
                                                    </div>
                                                <?php  }  ?>
                                            </div>

                                        <?php } ?>


                                    </div>



                                </div>

                                <div class="SearchFilter">
                                    <div></div>

                                    <button  type="submit" class="btn btnSearchFilter"><i class="fa fa-filter"></i> <span>بحث</span> </button>

                                    <div class="loading_filter"><img  src="<?php echo $this->static_file_site ?>/image/site/loding.gif" ></div>

                                </div>

                            </form>
                        </div>

                        <style>
                            .menu_category {
                                padding-top: 26px;
                                height: auto;
                                padding-bottom: 26px;
                            }
                           .smSilter .title_filter i.fa.fa-filter
                            {
                                color: #ffffff;
                                background: #283581;
                                width: 35px;
                                height: 35px;
                                border-radius: 6px;
                                text-align: center;
                                font-size: 25px;
                                padding-top: 4px;
                                cursor: pointer;
                            }
                            .smSilter  .title_filter i.fa.fa-filter:hover
                            {
                                color: #ffffff;
                                background: #ff5722;

                            }

                            .smSilter .title_filter span
                            {

                                font-size: 18px;
                                padding-right: 8px;
                                cursor: pointer;
                            }
                            .smSilter   .filter {
                                border: 1px solid #d6d6d6;
                                margin-top: 9px;
                                padding: 9px 7px;
                                max-height: 808px;
                                overflow: hidden;
                                overflow-y: auto;
                                position: relative;
                                border-bottom: 0;
                            }

                            .smSilter   .SearchFilter
                            {
                                text-align: center;
                                border: 1px solid #d6d6d6;
                                border-top: 0;
                                padding: 0 0 10px 0;
                                position: relative;
                            }
                            .smSilter .SearchFilter div
                            {
                                margin-bottom: 10px;
                                border-top:1px solid #d6d6d6;
                            }

                            .smSilter  .btnSearchFilter
                            {
                                background: #283581;
                                color: #ffffff;
                                padding: 4px 27px;
                                font-size: 18px;
                                border-radius: 0;

                            }

                            .smSilter select#CatgFilter {
                                margin-bottom: 24px;
                                border-radius: 0;
                            }

                            .smSilter .loading_filter
                            {
                                width: 43px;
                                height: 41px;
                                border: 0 !important;
                                position: absolute;
                                top: 8px;
                                right: 12px;
                                display: none;
                            }


                            .smSilter .openFilter
                            {
                                max-height: 890px;
                                overflow: hidden;
                                transition: 0.5s;
                            }


                            .smSilter  .openFilter.fltr_close
                            {
                                max-height: 0;
                                overflow: hidden;
                                transition: 0.5s;
                            }

                        </style>


                        <script>

                            $("#filterForm2").submit(function(e) {

                                $('.loading_filter').show();
                                e.preventDefault();
                                var form = $(this);
                                var url = form.attr('action');
                                $.ajax({
                                    type: "POST",
                                    url: url,
                                    data: form.serialize() + '&submit=submit',
                                    success: function (data) {
                                        $('.loading_filter').hide();
                                        if (data)
                                        {
                                            $('.openFilter').toggleClass("fltr_close");
                                            if (data)
                                            {
                                                $('.range_data').html(data);
                                            }
                                        }else
                                        {
                                            alert('يرجى تحديد المواصفات!')
                                        }

                                    }
                                })
                            });


                            function openFilter () {
                                $('.openFilter').toggleClass("fltr_close");
                            }

                        </script>

                    </div>
                <?php  }  ?>


                <div class="loading_range"></div>


                <div class="range_data">
                    <?php  if ($offers)  {  ?>
                        <div class="row">
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
                        </div>



                    <?php  } ?>



                    <div class="wrapper">
                        <div id="results_data" class="row"></div>
                    </div>

                    <script>

                        (function($){
                            $.fn.loaddata = function(options) {// Settings
                                var settings = $.extend({
                                    loading_gif_url	: "<?php echo $this->static_file_site ?>/image/site/loding.gif", //url to loading gif
                                    end_record_text	: 'تم عرض جميع المنتجات', //no more records to load

                                }, options);



                                if (options === 'desc')
                                {
                                    data_url 	= '<?php  echo  url .'/'. $this->folder ?>/load_desc/<?php echo $id ?>'; //url to PHP page
                                    start_page 	= 1; //initial page
                                }else if (options === 'asc')
                                {
                                    data_url 	= '<?php  echo  url .'/'. $this->folder ?>/load_asc/<?php echo $id ?>'; //url to PHP page
                                    start_page 	= 1; //initial page
                                }else{
                                    data_url 	= '<?php  echo  url .'/'. $this->folder ?>/load/<?php echo $id ?>'; //url to PHP page
                                    start_page 	= 1; //initial page
                                }

                                var el = this;
                                loading  = false;
                                end_record = false;
                                contents(el, settings); //initial data load


                                $(window).scroll(function() { //detact scroll

                                    if($(window).scrollTop() + $(window).height() >= $(document).height() - $('.footer').height()){ //scrolled to bottom of the page
                                        contents(el, settings); //load content chunk
                                    }
                                });
                            };
                            //Ajax load function
                            function contents(el, settings){
                                var load_img = $('<div>').html(`<img src="${settings.loading_gif_url}">`).addClass('loading-image'); //create load image
                                var record_end_txt = $('<div/>').text(settings.end_record_text).addClass('col-12 text-center end-record-info'); //end record text

                                if(loading == false && end_record == false){
                                    loading = true; //set loading flag on
                                    el.append(load_img); //append loading image
                                    console.log(load_img)
                                    $.post( data_url, {'page': start_page}, function(data){ //jQuery Ajax post
                                        if(data.trim().length == 0){ //no more records
                                            el.append(record_end_txt); //show end record text
                                            load_img.remove(); //remove loading img
                                            end_record = true; //set end record flag on
                                            return; //exit
                                        }
                                        loading = false;  //set loading flag off
                                        load_img.remove(); //remove loading img
                                        el.append(data);  //append content
                                        start_page ++; //page increment
                                    })
                                }
                            }

                        })(jQuery);
                        $("#results_data").loaddata(); //load the results into element


                        function sort_desc(e) {
                            $('#results_data').empty();
                            $('.sort_class').removeClass('active_btn');
                            $(e).addClass('active_btn');
                            $("#results_data").loaddata('desc'); //load the results into element

                        }
                        function sort_asc(e) {
                            $('#results_data').empty();
                            $('.sort_class').removeClass('active_btn');
                            $(e).addClass('active_btn');
                            $("#results_data").loaddata('asc'); //load the results into element

                        }

                    </script>


                </div>
            </div>

        </div>
    </div>


    <script>

     function  like_d(id) {

            $.get('<?php echo url ?>/mobile/like_d/'+id, function(data){
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


      function  unlike_d (id) {

          $.get('<?php echo url ?>/mobile/unlike_d/'+id, function(data){
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


     function addToCart(id,code,price_type=0) {

         var  dataD={'id_item':id,'code':code,'price_type':price_type};

         $.get('<?php echo url .'/'.$this->folder ?>/cart_order', { jsonData: JSON.stringify( dataD )}, function(data){

             if (data !=='finish')
             {
                 $.get("<?php echo url .'/'.$this->folder ?>/count_c" , function(e) {
                     $('span.count_item').text(e);
                 });
                 $('.addedToCart_<?php echo $this->folder  ?>'+id).html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa fa-check-circle"> </i>  <span> تمت الاضافة  </span>
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                           </button>
                                     </div>`);
                 $('.button_buy').css('display','block');
                 $('.empty_car').css('display','none');
                 $('.item_cat').html(data);
                 setTimeout(function(){
                     $('.addedToCart_<?php echo $this->folder  ?>'+id).empty();
                 }, 4000);

             }else
             {
                 alert('نفذت الكمية')
             }
         });

     }

     $("#idForm_range").submit(function(e) {

         $('.loading_range').html(' <img  src="<?php echo $this->static_file_site ?>/image/site/loding.gif" >');
         e.preventDefault();
         var form = $(this);
         var url = form.attr('action');
         $.ajax({
             type: "POST",
             url: url,
             data: form.serialize() + '&submit=submit',
             success: function (data) {
                 $('.loading_range').empty();
                 if (data)
                 {
                     $('.range_data').html(data)

                 }

             }
         })
     })


    </script>



<br>

<?php $this->publicFooter(); ?>