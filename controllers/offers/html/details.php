<?php  $this->publicHeader($result['title']);  ?>
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
                        <li class="breadcrumb-item"> <a href="<?php  echo url .'/'.$this->folder ?>"> <?php  echo $this->langSite($this->folder) ?> </a> </li>
                        <li class="breadcrumb-item"> <?php  echo $result['title'] ?>  </li>

                    </ol>
                </nav>


                <?php  if ($data_cat) {  ?>

                    <div class="row">

                        <div class="col">
                            <select class="custom-select dropdown_filter"  id="category_offer"   >
                                <option value="all" >  كل الفئات </option>
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

                    </style>




                <?php } ?>





                <form id="idForm_offers" action="<?php echo url .'/'. $this->folder?>/cart_order/<?php echo $id ?>" method="post" >

                <div class="row" id="filter">
                    <?php   if ($result['countdown'] == 1) {  ?>
                    <div class="col-12">

                        <div class="countDown">

                            <div class="row align-items-center">

                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="end_offer text-center">
                                       <?php  echo $this->langSite('end_offer') ?>
                                    </div>

                                </div>


                                <div class="col-lg-6 col-md-6 col-sm-6 col-12 text-center">
                                    <div class="main-example">

                                        <div class="countdown-container" id="main-example">


                                            <div class="time days flip">
                                                <span class="label">يوم</span>
                                                <span class="count curr top">00</span>
                                                <span class="count next top">00</span>
                                                <span class="count next bottom">00</span>
                                                <span class="count curr bottom">00</span>
                                            </div>

                                            <div class="time hours flip">
                                                <span class="label">ساعة</span>
                                                <span class="count curr top">00</span>
                                                <span class="count next top">00</span>
                                                <span class="count next bottom">00</span>
                                                <span class="count curr bottom">00</span>
                                            </div>

                                            <div class="time minutes flip">
                                                <span class="label">دقيقة</span>
                                                <span class="count curr top">00</span>
                                                <span class="count next top">00</span>
                                                <span class="count next bottom">00</span>
                                                <span class="count curr bottom">00</span>
                                            </div>

                                            <div class="time seconds flip">
                                                <span class="label">ثانية</span>
                                                <span class="count curr top">00</span>
                                                <span class="count next top">00</span>
                                                <span class="count next bottom">00</span>
                                                <span class="count curr bottom">00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>




                        </div>

                    </div>
                    <?php } ?>

                        <div class="col-lg-8">
                            <div class="image_offers_show">

                                <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"  class="swiper mySwiper2">
                                    <div class="swiper-wrapper">

                                        <?php foreach ($image as $img) {  ?>
                                        <div class="swiper-slide cover_image">
                                            <img src="<?php  echo $img ?>" />
                                        </div>
                                        <?php } ?>

                                    </div>

                                </div>


                             </div>
                        </div>

                        <div class="col-lg-4">

                            <div class="details_info_mobile">

                                 <div class="notePrice">
                                    <?php  echo $this->setting->get('note')?>
                                </div>


                                <div class="m_item">
                                    مواد العرض
                                </div>



                                <?php  foreach ($item as $ite) {  ?>
                                <div class="item_offer">
                                <div>   <i class="fa fa-check-circle">  </i>  <span> <?php echo $ite['title']?></span>  </div>

                                    <div class="details_item">

                                        <?php   if ($ite['model'] != 'savers') { ?>
                                        <div class="choose_color"> اختر اللون </div>
                                        <?php foreach ($ite['details'.$ite['id']] as $key => $print_g_c) { ?>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline<?php echo $print_g_c['id'] ?>"

                                                       value="<?php echo $print_g_c['id'] ?>" name="details_offer[<?php echo $ite['id'] ?>x]"
                                                       class="custom-control-input notDeviceCover"  required >
                                                <label class="custom-control-label label_color_<?php echo $print_g_c['id']   ?>"
                                                       for="customRadioInline<?php echo $print_g_c['id'] ?>">  <?php   echo $print_g_c['size'] ?> </label>
                                            </div>


                                            <style>
                                                .label_color_<?php  echo  $print_g_c['id']  ?>::before {
                                                    background-color: <?php  echo $print_g_c['code_color']?>;
                                                    width: 20px;
                                                    height: 20px;
                                                    cursor: pointer;
                                                    border: 1px solid #d5d5d5;
                                                    top: 1px;
                                                }

                                                .label_color_<?php  echo  $print_g_c['id']  ?>:after {
                                                    width: 20px;
                                                    height: 20px;
                                                    cursor: pointer;
                                                }

                                                .custom-radio .custom-control-input.notDeviceCover:checked ~ .custom-control-label.label_color_<?php  echo  $print_g_c['id']  ?>::before {
                                                    background-color: <?php  echo $print_g_c['code_color']?>;
                                                    border: 1px solid #d5d5d5;

                                                }

                                                .custom-radio .custom-control-input.notDeviceCover:checked ~ .custom-control-label::after
                                                {
                                                    top: 1px;
                                                    border: 3px solid #ff5722;
                                                    border-radius: 50%;
                                                    box-shadow: 0 0 0 0.2rem rgb(0 123 255 / 25%);
                                                }

                                            </style>
                                        <?php } ?>
                                      <?php } else {  ?>


                                            <div class="choose_color"> اختر  الجهاز </div>

                                            <?php  foreach ($type_device[$ite['id']] as $index => $device ) {  ?>

                                                <div class="custom-control custom-radio mb-2">
                                                    <input type="radio" onchange="device_cover(<?php  echo $index ?>)"  id="customRadioDevice_<?php  echo $index ?>" name="deviceCover" class="custom-control-input" required>
                                                    <label class="custom-control-label" for="customRadioDevice_<?php  echo $index ?>"><?php  echo $device ?></label>
                                                </div>

                                             <?php  } ?>




                                        <?php  } ?>


                                    </div>



                                </div>
                                <?php  } ?>

                            </div>

                        </div>



                </div>
                   <div class="row justify-content-end">

                       <div class="col-12 ">

                           <?php  foreach ($item as $ite) {  ?>
                           <?php   if ($ite['model'] == 'savers') { ?>
                               <?php foreach ($ite['details'.$ite['id']] as $key => $print_g_c) {  ?>


                               <div class="list_cover" id="open_list_cover_<?php echo $key ?>" >

                                   <div class="row unselectCover">
                                   <?php  foreach ($ite['details'.$ite['id']][$key] as $outCover ) {  ?>
                                       <div class="col-lg-4 col-md-4 col-sm-6 col-6 mb-5">
                                           <div class="imageDevise">
                                           <label class="choose_image">
                                               <input   type="radio" id="customRadioInlineCover<?php echo $outCover['id'] ?>" value="<?php echo $outCover['id'] ?>" name="details_offer[<?php echo $ite['id'] ?>]"
                                                       required >
                                               <img   src="<?php echo $outCover['image'] ?>" >


                                           </label>

                                        </div>
                                           <div class="title_cover">
                                               <?php echo $outCover['title'] ?>
                                           </div>
                                       </div>
                                   <?php } ?>
                                   </div>

                               </div>

                           <?php } ?>
                             <?php } ?>
                        <?php } ?>


                       </div>

                       <div class="col-lg-4 col-12">

                           <span> <?php  echo $this->langControl('price_between') ?>  : </span>

                           <span id="price_device"> <?php  echo $result['price']?> </span>

                           <button type="button" data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $result['priceC'] ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button>
                           <hr>
                           <div class="cart_a">

                               <div class="row">
                                   <div class="col-12">
                                       <div class="addedToCart_offers<?php echo $result['id'] ?>">

                                       </div>
                                   </div>


                                   <div class="col-12">
                                       <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>
                                           <?php if ($this->phone=='true' || $this->isDirect()) {   ?>
                                               <button   class="btn btn-primary addToCart" type="submit" name="submit"><i
                                                           class="fa fa-shopping-cart"></i> اضف الى السلة
                                               </button>

                                           <?php  }else{   ?>
                                               <button class="btn   addToCart" type="button"
                                                       data-toggle="modal" data-target="#add_phone"><i
                                                           class="fa fa-shopping-cart"></i> اضف الى السلة
                                               </button>
                                           <?php  }  ?>

                                       <?php } else { ?>

                                           <button class="btn btn-primary addToCart" type="button"
                                                   data-toggle="modal" data-target="#login_site"><i
                                                       class="fa fa-shopping-cart"></i> اضف الى السلة
                                           </button>
                                       <?php } ?>
                                   </div>
                               </div>



                           </div>

                       </div>

                   </div>


                </form>




<br>

                <div class="row">

                    <?php if ($result['content']) {  ?>
                    <div class="col-12">

                        <div class="detailsDevice">
                            <?php echo $result['content'] ?>
                        </div>
                        <br>
                    </div>
                      <?php } ?>
                        <?php  if ($random)  {  ?>
                        <div class="col-12">
                            <div class="alert alert-secondary" role="alert">
                               عروض اخرى
                            </div>

                            <div class="row" id="filter" >
                                <?php foreach ($random as $printContent) {   ?>

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

                        </div>
                        <?php  }  ?>



                    </div>


                <br>




            </div>

        </div>
    </div>





    <link href="<?php echo $this->static_file_site ?>/countdown/main.css" rel="stylesheet">

    <script src="<?php echo $this->static_file_site ?>/countdown/lodash.min.js"></script>
    <script type="text/javascript">
        function device_cover(id)
        {
            $('.list_cover').hide();
            $('#open_list_cover_'+id).show();
        }



        $(window).on('load', function() {
            var labels = ['weeks', 'days', 'hours', 'minutes', 'seconds'],
                nextYear = '<?php  echo date('Y/m/d H:i:s',$result['todate'])  ?>',
                template = _.template($('#main-example-template').html()),
                currDate = '00:00:00:00:00',
                nextDate = "00:00:00:00:00",
                parser = /([0-9]{2})/gi,
                $example = $('#main-example');
            // Parse countdown string to an object

            function strfobj(str) {
                var parsed = str.match(parser),
                    obj = {};
                labels.forEach(function(label, i) {
                    obj[label] = parsed[i]
                });
                return obj;
            }
            // Return the time components that diffs
            function diff(obj1, obj2) {
                var diff = [];
                labels.forEach(function(key) {
                    if (obj1[key] !== obj2[key]) {
                        diff.push(key);
                    }
                });
                return diff;
            }
            // Build the layout
            var initData = strfobj(currDate);
            labels.forEach(function(label, i) {
                $example.append(template({
                    curr: initData[label],
                    next: initData[label],
                    label: label
                }));
            });
            // Starts the countdown
            $example.countdown(nextYear, function(event) {
                var newDate = event.strftime('%w:%d:%H:%M:%S'),
                    data;

                if (newDate !== nextDate) {
                    currDate = nextDate;
                    nextDate = newDate;
                    // Setup the data
                    data = {
                        'curr': strfobj(currDate),
                        'next': strfobj(nextDate)
                    };
                    // Apply the new values to each node that changed
                    diff(data.curr, data.next).forEach(function(label) {
                        var selector = '.%s'.replace(/%s/, label),
                            $node = $example.find(selector);
                        // Update the node
                        $node.removeClass('flip');
                        $node.find('.curr').text(data.curr[label]);
                        $node.find('.next').text(data.next[label]);
                        // Wait for a repaint to then flip
                        _.delay(function($node) {
                            $node.addClass('flip');
                        }, 50, $node);
                    });
                }
            });
        });




        function get_dollar_price(e,price) {



            $.get( "<?php  echo url   ?>/dollar_price/dollar_price_convert",{price:price}, function( data ) {

                $(e).tooltip('hide')
                    .attr('data-original-title', data)
                    .tooltip('show');
            });


        }


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



        $("#idForm_offers").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {



                    console.log(data)

                    if (data ==='add')
                    {

                        $.get("<?php echo url ?>/offers/count_c" , function(e) {
                            $('span.count_item').text(e);
                        });

                        $('.addedToCart_offers'+<?php  echo $id ?>).html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa fa-check-circle"> </i>  <span> تمت الاضافة  </span>
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                           </button>
                                     </div>`);

                        $('.button_buy').css('display','block');
                        $('.empty_car').css('display','none');
                        $('.item_cat').html('');
                        setTimeout(function(){
                            $('.addedToCart_offers'+<?php  echo $id ?>).empty();
                        }, 4000);

                    }else if (data === 'finish')
                    {
                        alert('نفذت الكمية')
                    }else
                    {
                        alert(data)
                    }


                }
            });


        });


        function addToCart_offers(id,nameImage) {

            var  dataD={'id_offer':id,'image':nameImage};

            $.get('<?php echo url .'/'. $this->folder?>/cart_order', { jsonData: JSON.stringify( dataD )}, function(data){
                if (data !=='finish')
                {
                    console.log(data)
                    $.get("<?php echo url ?>/offers/count_c" , function(e) {
                        $('span.count_item').text(e);
                    });

                    $('.addedToCart_offers'+id).html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa fa-check-circle"> </i>  <span> تمت الاضافة  </span>
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                           </button>
                                     </div>`);

                    $('.button_buy').css('display','block');
                    $('.empty_car').css('display','none');
                    $('.item_cat').html(data);
                    setTimeout(function(){
                        $('.addedToCart_offers'+id).empty();
                    }, 4000);

                }else
                {
                    alert('نفذت الكمية')
                }
            });

        }



        $(document).ready(function() {

            $("#category_offer option").each(function () {
                if ($(this).val() === localStorage.getItem("offer_cat")) { // EDITED THIS LINE
                    $(this).attr("selected", "selected");
                }
            });
        })
    </script>



    <!-- Swiper JS -->
    <script   src="<?php echo $this->static_file_site ?>/swiper/swiper-bundle.min.js"></script>


    <!-- Initialize Swiper -->
    <script>

        var swiper2 = new Swiper(".mySwiper2", {
            spaceBetween: 10,

        });
    </script>

    <style>
        .title_cover {
            display: block;
            text-align: center;
            margin-top: 9px;
        }
        .list_cover
        {
            display: none;
            margin-bottom: 47px;
            margin-top: 15px;
            border: 3px solid #a5d5e2;
            padding: 15px;
        }

        .title_type_device {
            padding: 2px 14px;
            background: #e9e9e9;
            margin-bottom: 3px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }

        .choose_image img
        {

            margin-bottom: 10px;
            border: 1px solid gainsboro;
        }

        /* HIDE RADIO */
        .choose_image [type=radio] {
            position: absolute;
            opacity: 0;
            width: 1px;
            height: 1px;
        }

        /* IMAGE STYLES */
        .choose_image  [type=radio] + img {
            cursor: pointer;
        }

        /* CHECKED STYLES */
        .choose_image [type=radio]:checked + img {
            outline: 2px solid #f00;
        }



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


        .countDown {
            position: relative;
            background: #a5d5e2;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 5px;
        }
        .main-example {
            background: #fff;
            padding: 8px 0 36px 0;
            border-radius: 5px;
            direction: ltr;
        }
        .end_offer {
            font-size: 28px;
            font-weight: bold;
            color: #495678;
            padding-bottom: 11px;

        }

        .choose_color {
            font-weight: bold;
            margin-bottom: 12px;
            padding-right: 4px;
            color: black;
        }
        .details_item {
            background: #fff;
            padding: 5px 3px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .item_offer {
            margin: 11px 0;
            background: #a5d5e2;
            padding: 5px;
            border-radius: 7px;
        }

        .item_offer i {
            color: #0a7817;
        }

        .m_item {
            margin: 8px 0;
            font-weight: bold;
            border-bottom: 1px solid #bfc8ca;
        }


        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;

            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .swiper {
            width: 100%;
            height: auto;
            margin-left: auto;
            margin-right: auto;
        }

        .swiper-slide {
            background-size: cover;
            background-position: center;
        }

        .mySwiper2 {
            height: 100%;
            width: 100%;
        }

        /*.mySwiper2 img{*/
        /*    height: 350px !important;*/

        /*}*/

        .mySwiper {
            height: 100px;
            box-sizing: border-box;
            padding: 10px 0;
        }

        .mySwiper .swiper-slide {
            width: 100px;
            height: 100%;
            opacity: 0.4;
            cursor: pointer;
        }

        .mySwiper .swiper-slide-thumb-active {
            opacity: 1;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image_offers_show
        {
            text-align: center;
            position: relative;
            overflow: hidden;

        }

        .notePrice {
            padding: 5px;
            background: #e5e7f3;
        }

        .price
        {

            font-size: 18px;
            font-weight: bold;
        }
        .t_d_m
        {
            margin-top: 30px;
            font-size: 18px;
            font-weight: bold;
        }

        #price_device,#price_unit
        {
            color: red;
            font-size: 18px;
            font-weight: bold;
        }


        .infoDevice
        {
            border: 2px solid rgba(139, 134, 134, 0.45);
        }

        .menu_category
        {
            height:auto;
        }

    </style>





    <br>

<?php $this->publicFooter(); ?>