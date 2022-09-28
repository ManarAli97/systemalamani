<?php $this->publicHeader($result['title']); ?>




    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">  عرض المواقع  </h5>

                </div>
                <div class="modal-body">

                    <ul class="list-group">
                        <?php foreach ($color as $colordata) { ?>
                            <li class="list-group-item" style="background: <?php  echo $colordata['code_color']  ?>">  <?php  echo $colordata['color']  ?>

                                <?php  if (!empty($colordata['code'])) { ?>
                                    <ul  class="list-group sub_code"  >
                                        <?php foreach ($colordata['code'] as $code) { ?>
                                            <li class="list-group-item">  <?php echo $code['code']  ?>

                                                <?php  if (!empty($code['location'])) { ?>
                                                    <ul class="list-group sub_sub_code">
                                                        <?php foreach ($code['location'] as $location) { ?>

															<?php if ($location['quantity'] > 0) {   ?>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center"><span data-toggle="tooltip" data-placement="top" title="الموقع"> <?php echo   $this->tamayaz_locations($location['location'])  ?></span>
																	<?php  if ($this->loginUser()) { ?>
                                                                        <span class="badge badge-primary badge-pill" data-toggle="tooltip" data-placement="top" title="الكمية"><?php echo $location['quantity'] ?></span>
																	<?php  } ?>

                                                                </li>
															<?php  }  ?>

                                                        <?php  }  ?>

                                                    </ul>


                                                <?php  }  ?>


                                            </li>
                                        <?php  }  ?>
                                    </ul>

                                <?php } ?>
                            </li>


                        <?php  }  ?>

                    </ul>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>

                </div>
            </div>
        </div>
    </div>





    <div class="container">
        <div class="row">
            <div class="col-lg-3">

                <?php $this->menu->menu() ?>




                <div class="phoneModel heddinSm" style="position: relative">

                    <div class="control_slider control_slider_inside">
                        <div class="row">
                            <div class="col-auto border" style="width: 50px">
                                <a class="carousel-control-prev row_prev" href="#carouselExampleControlsPhone-sideBar"
                                   role="button" data-slide="prev">
                                    <i class="fa fa-chevron-left"></i>
                                </a>
                                <a class="carousel-control-next row_next" href="#carouselExampleControlsPhone-sideBar"
                                   role="button" data-slide="next">
                                    <i class="fa fa-chevron-right"></i>
                                </a>

                            </div>

                            <div class="col-auto  ">
                                <?php echo $this->langSite('games') ?>
                            </div>
                        </div>
                    </div>

                    <div id="carouselExampleControlsPhone-sideBar" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">

                            <?php foreach ($content as $index => $printContent) { ?>
                                <div class="carousel-item  <?php if ($index == 0) echo 'active' ?>  ">
                                  <div class="infoDevice">
                                      <?php  if ($printContent['bast_it'] == 1 ) { ?>
                                          <div class="bast_device">
                                              <?php echo $this->langSite('bast_it') ?>
                                          </div>

                                      <?php } ?>
                                    <a href="<?php echo url ?>/games/details/<?php echo $printContent['id'] ?>">
                                        <div class="hoverBtn">
                                            <button class="btn"><i class="fa fa-search"></i></button>
                                        </div>

                                        <div class="imageDevise">

                                            <img src="<?php echo $printContent['image'] ?>" alt="لا توجد صورة">
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
                                      <div class="memoryDevice">
                                          <?php  if (!empty($printContent['size']) &&  !in_array($printContent['size'],$this->non) )  { ?>
                                              حجم الذاكرة :                                    <?php echo $printContent['size'] ?>
                                          <?php  }  ?>
                                      </div>
                                        <div class="c_device">
                                            <div class="addedToCart_games<?php echo $printContent['id'] ?>"></div>

                                            <div class="row align-items-center justify-content-center">

                                                <div class="col-6" style="padding: 0">

                                                    <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>
                                                        <?php if ($this->phone=='true' || $this->isDirect()) {   ?>
                                                        <button type="button" class="btn btn_cart" onclick="addToCart('<?php echo $printContent['code'] ?>')">
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
                                                <div class="col-3">

                                                    <?php if (isset($_SESSION['username_member_r'])) { ?>

                                                        <button   type="button" class="btn btn_like    L_<?php echo $printContent['id']  ?> <?php  if ($printContent['like']) echo 'unlike'; else echo  'like' ?>"  onclick=<?php  if ($printContent['like']) echo "unlike_d(".$printContent['id'].")"; else echo "like_d(".$printContent['id'].")" ?>   >
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

                            <?php } ?>

                        </div>

                    </div>
                </div>

                <script>

                    function  like_d(id) {

                        $.get('<?php echo url ?>/games/like_d/'+id, function(data){
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

                        $.get('<?php echo url ?>/games/unlike_d/'+id, function(data){
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

                </script>
            </div>

            <div class="col-lg-9">

                <br>


                    <nav aria-label="breadcrumb" class="path_bread">
                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="<?php if (isset($_COOKIE['g_active']))  { echo url.'/'.$this->folder.'/disk?g=1';  }else{ echo url; }   ?>"><i class="fa fa-home"></i> </a></li>
                            <?php if ($breadcumbs){ foreach ($breadcumbs as $key => $bc) {   ?>

                                <li class="breadcrumb-item   <?php   if ($bc == "#" ) echo 'active'?> "  aria-current="page" > <?php if ($bc != "#" ) echo "<a href='{$bc}'>{$key} </a>"; else echo $key ?> </li>

                            <?php  } } ?>
                            <li class="breadcrumb-item   active "  aria-current="page" > <?php echo $result['title'] ?></li>


                        </ol>
                    </nav>

                <?php  if (!empty($g_c_content))  {  ?>


                <form id="buy_form">
                    <div class="details_games">

                        <div class="row">
                            <div class="col-lg-6">
                                <br>

                                    <button type="button" class="btn   showLocation" data-toggle="modal" data-target="#exampleModal">
                                        <i class="fa fa-th"></i>
                                    </button>
                                    <style>

                                        .showLocation {
                                            background: #183065;
                                            position: absolute;
                                            top: 0;
                                            z-index: 1;
                                            color: #fff !important;
                                        }
                                    </style>

                                <div class="image_games_show">
                                    <?php  if ($result['bast_it'] == 1 ) { ?>
                                        <div class="bast_device">
                                            <?php echo $this->langSite('bast_it') ?>
                                        </div>

                                    <?php } ?>
                                    <?php  if ($result['cuts'] == 1 ) { ?>
                                        <div class="price_cuts_note" style="left: 16px;bottom: 12px;">
                                            <?php echo $this->langSite('price_cuts') ?>
                                        </div>

                                    <?php } ?>
                                    <img class="image_user" src="<?php echo $this->static_file_site ?>/image/site/loding.gif" id="imagePhone">
                                </div>
                            </div>

                            <div class="col-lg-6">



                                <div class="details_info_games">


                                    <div class="notePrice">
                                        <?php  echo $this->setting->get('note')?>
                                    </div>

                                    <div class="choose_color_games">
                                        <div class="t_d_m">
                                            اختيار التفاصيل
                                        </div>

                                        <div class="color">
                                              <span> اللون  </span>
                                        </div>
                                        <hr>

                                        <div class="required_color"></div>
                                        <?php foreach ($g_c_content as $key => $print_g_c) { ?>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline<?php echo $print_g_c['id'] ?>"
                                                       onchange="gstImageFromRadio(<?php echo $print_g_c['id'] ?>)"
                                                       value="<?php echo $print_g_c['image'] ?>" name="color"
                                                       class="custom-control-input" <?php if ($key == 0) echo 'checked' ?> >
                                                <label class="custom-control-label label_color_<?php echo $key ?>"
                                                       for="customRadioInline<?php echo $print_g_c['id'] ?>">  <?php if ($print_g_c['color'] != 'بلا') echo $print_g_c['color'] ?> </label>
                                            </div>
                                            <style>
                                                .label_color_<?php  echo  $key  ?>::before {
                                                    background-color: <?php  echo $print_g_c['code_color']?>;
                                                    width: 1rem;
                                                    height: 1rem;
                                                    cursor: pointer;

                                                    border: 1px solid #d5d5d5;
                                                }

                                                .label_color_<?php  echo  $key  ?>:after {
                                                    width: 1rem;
                                                    height: 1rem;
                                                    cursor: pointer;
                                                }

                                                .custom-radio .custom-control-input:checked ~ .custom-control-label.label_color_<?php  echo  $key  ?>::before {
                                                    background-color: <?php  echo $print_g_c['code_color']?>;
                                                    border: 1px solid #d5d5d5;
                                                }
                                            </style>
                                        <?php } ?>


                                    </div>
                                    <div class="display_size_memory">
                                    <hr>
                                    <div class="required_size"></div>
                                     <label for="size_memory">حجم الذاكرة</label>
                                    <select class="custom-select mr-sm-2"  name="size" onchange="getPrice()" id="size_memory">

                                    </select>
                                    </div>
                                    <hr>
                                    <div class="alertTable"></div>

                                    <div class="price_type_list"></div>

                                    <hr>
                                </div>


                                <div class="cart_a">

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="done_buy">

                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-3 col-sm-6 col-6">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend x_plus">
                                                    <button type="button" class="btn  " id="minus"> -</button>
                                                </div>
                                                <input type="number" min="1" name="number" value="1"
                                                       class="form-control x_ox_number" id="count"  >
                                                <div class="input-group-prepend x_plus">
                                                    <button type="button" class="btn  " id="plus"> +</button>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-6 col-md-3 col-sm-6 col-6">
                                            <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>
                                                <?php if ($this->phone=='true' || $this->isDirect()) {   ?>
                                                <button class="btn btn-primary addToCart" type="submit" name="submit"><i
                                                            class="fa fa-shopping-cart"></i> اضف الى السلة
                                                </button>

                                            <?php  }else{   ?>
                                            <button class="btn   addToCart" type="button"
                                                    data-toggle="modal" data-target="#add_phone"><i
                                                        class="fa fa-shopping-cart"></i> اضف الى السلة
                                            </button>
                                            <?php  }  ?>

                                            <?php } else { ?>

                                                <button class="btn   addToCart" type="button"
                                                        data-toggle="modal" data-target="#login_site"><i
                                                            class="fa fa-shopping-cart"></i> اضف الى السلة
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>



                    </div>
                </form>

                <div class="detailsDevice">
                    <?php echo $result['content'] ?>
                </div>

                <?php  } else{  ?>

                    <div class="alert alert-danger" role="alert">
                        نفذت الكمية! سوف تتوفر قريبا يرجى متابعة السوق الالكتروني.
                    </div>

                <?php  }  ?>

            </div>


                <script>

                    function x_error_color() {
                        $('.required_color').text('');
                    }


                    var price = 0;
                    var count = 1;

                    function get_price(id, key) {


                        $('#count').val(1);
                        count = 1;
                        $('.size_icon').removeClass('checked');
                        $("#" + key + '_item').addClass('checked');
                        $("#" + key + '_checkbox').prop('checked', true); // Checks it
                        $.ajax({
                            type: 'GET',
                            url: '<?php echo url . '/' . $this->folder ?>/price/' + id,
                            cache: false,
                            success: function (result) {
                                price = result;
                                $('.price_xo_x').html('<br> <span  >السعر  &nbsp; &nbsp;</span> :  <span id="last_price">  ' + result + "</span> <?php  if (isset($_COOKIE['currency'])) {  if ($_COOKIE['currency'] == 0 ) echo 'د.ع'; else echo '$' ;}else{  echo 'د.ع' ;}      ?> ")
                            },
                        });

                        $('.required_size').text('');

                    }

                    $('#minus').click(function () {
                        count = $('#count').val();
                        if (count > 1) {
                            count = parseInt(count) - 1;
                            $("#count").val(count);

                        }

                    });
                    $('#plus').click(function () {
                        count = $('#count').val();
                        count = parseInt(count) + 1;
                        $("#count").val(count);

                     });


                    $(document).ready(function () {
                        $('#buy_form').submit(function (e) {
                            e.preventDefault();
                            $.ajax({
                                type: "POST",
                                url: '<?php echo url . '/' . $this->folder ?>/car_item/<?php  echo $id?>/' + $("#count").val(),
                                data: $(this).serialize(),
                                success: function (data) {


                                    if (isJson(data)) {
                                        var result=JSON.parse(data);
                                        $('.done_buy').html(`<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <i class="fa fa-check-circle"> </i>  <span> ${result[3]} </span>
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                           </button>
                                     </div>`);
                                    }
                                    else
                                    {
                                        $('.size_icon').removeClass('checked');
                                        $('.choose_color').prop('checked', false);
                                        $('.choose_size').prop('checked', false);
                                        $.get("<?php echo url .'/'.$this->folder ?>/count_c" , function(e){
                                            $('span.count_item').text(e);
                                            $('.button_buy').css('display','block');
                                            $('.empty_car').css('display','none');
                                            $('.done_buy').html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa fa-check-circle"> </i>  <span> تمت اضافة العنصر  الى السلة </span>
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                           </button>
                                     </div>`);

                                        });
                                        $('.button_buy').css('display','block');
                                        $('.empty_car').css('display','none');
                                        $('.item_cat').html(data);

                                        setTimeout(function(){
                                            $('.done_buy').empty();
                                        }, 4000);


                                    }

                                }
                            });
                        });
                    });

                    function isJson(str) {
                        try {
                            JSON.parse(str);
                        } catch (e) {
                            return false;
                        }
                        return true;
                    }


                </script>


                <style>

                    .required_size, .required_color {
                        color: red;
                        margin-bottom: 18px;
                    }

                    .price_xo_x span:nth-of-type(2) {
                        border: 1px solid #7e7;
                        padding: 0 20px;
                        border-radius: 7px;
                    }

                    .x_ox_number {
                        text-align: center;
                        margin: 0 5px;
                        height: 34px;
                        border-radius: 52px !important;
                    }

                    .sher_pro {
                        position: absolute;
                        bottom: 10px;
                        left: 10px;
                    }

                    .details_prod {
                        border: 1px solid #d1d0ce;
                        height: 100%;
                        padding: 5px 20px;
                        position: relative;
                    }

                    .size_icon {
                        border: 1px solid #d1d0ce;
                        padding: 0 7px;
                        margin: 0 3px;
                        text-align: center;
                        cursor: pointer;
                        transition: 0.5s;
                    }

                    .size_icon:hover, .size_icon:focus {
                        background: #707f8e;
                        color: #ffffff;
                    }

                    .checked {
                        background: #707f8e;
                        color: #ffffff;
                        position: relative;
                    }

                    .checked:before {

                        position: absolute;
                        content: '\f00c';
                        font-family: FontAwesome;
                        top: -20px;
                        color: #7e7;
                        width: 100%;
                        text-align: center;
                        right: 0;
                    }

                    .title_pro {
                        font-size: 28px;
                    }

                    .color_icon {
                        padding: 1px 17px;
                        margin: 0 5px;
                    }

                    .sher_pro a {
                        text-decoration: none;
                    }

                    .sher_pro i {
                        color: #ffffff;
                        width: 32px;
                        height: 32px;
                        font-size: 18px;
                        border-radius: 50%;
                        padding: 8px;
                        text-align: center;
                        background: #125da9;
                    }


                    .relImg {
                        width: 100%;
                    }


                    .image_or_icon {
                        text-align: center;
                        width: 250px;
                        height: 250px;
                        border: 1px solid #0ea2be;
                        border-radius: 50%;
                        overflow: hidden;
                        animation: pulse 3s infinite;
                        padding-top: 28px;
                    }


                    .image_or_icon img {

                        height: 186px;
                    }

                    .that_rel {
                        background: #125da9;
                        margin: 18px 0;
                        padding: 5px 14px;
                        border-radius: 5px;
                        color: #ffffff;
                        font-size: 22px;
                    }

                    button#minus {
                        border-radius: 50%;
                        width: 33px;
                        height: 33px;
                        padding: 0;
                        background: #495678;
                        color: #ffffff;
                    }

                    button#plus {
                        border-radius: 50%;
                        width: 33px;
                        height: 33px;
                        padding: 0;
                        background: #495678;
                        color: #ffffff;
                    }





                </style>


            </div>


        </div>



    <script>

        gstImageFromRadio(<?php  echo $id_c ?>);

        function gstImageFromRadio(id) {
            $('#imagePhone').attr('src', "<?php echo $this->static_file_site ?>/image/site/loding.gif");

            var value = $("input[type=radio][name='color']:checked").val();

            $.get("<?php echo url . '/' . $this->folder ?>/dtl/" + id, function (data) {
                imageUrl="<?php echo $this->save_file ?>"+value;
                $('#imagePhone').attr('src', imageUrl);
                if ($(window).width() > 450) {
                    $('img#imagePhone').attr('data-zoom-image', imageUrl);
                    $('#imagePhone').elevateZoom({
                        zoomType: "window",
                        cursor: "crosshair",
                        zoomWindowFadeIn: 500,
                        zoomWindowFadeOut: 750,
                        responsive:true,
                        zoomLevel: 1,
                        onZoomedImageLoaded:function() {
                            $('.zoomWindow').css('background-image', 'url(' + imageUrl + ')');
                        },
                    });
                }
                $('#size_memory').html(data);
                if( $('#size_memory option').length === 1){
                    ziv=$('#size_memory option:first').text();
                    if(myarr_non.indexOf(ziv) > -1)
                    {
                        $('.display_size_memory').hide();
                    }else {
                        $('.display_size_memory').show();
                    }

                }else {
                    $('.display_size_memory').show();
                }

                getPrice();

            });
        }

        function getPrice() {
            $.get("<?php echo url . '/' . $this->folder ?>/price/" + $('#size_memory option:selected').val()+"/<?php  echo $result['price_dollars'] ?>", function (data) {

                $('.price_type_list').html(data);
                if (data)
                {
                    setfocusInput()
                }

            });
        }


    </script>

    <style>
        .image_games_show {
            text-align: center;
        }

        .image_games_show img.image_user {
            height: 350px;
            max-width: 100%;
        }

        .notePrice {
            padding: 5px;
            background: #e5e7f3;
        }

        .price {

            font-size: 18px;
            font-weight: bold;
        }

        .t_d_m {
            margin-top: 30px;
            font-size: 18px;
            font-weight: bold;
        }

        #price_device, #price_unit {
            color: red;
            font-size: 18px;
            font-weight: bold;
        }



        .infoDevice {
            border: 2px solid rgba(139, 134, 134, 0.45);
        }

    </style>


    <br>
    <br>
    <br>
    <br>

<?php  if (isset($_SESSION['loggedIn'])) {  ?>
	<?php if ($this->permit('show_quantity','show_quantity'))   { ?>
        <?php  if (!isset($_COOKIE['g_active'])) { ?>
        <div class="request_order">


            <div class="row justify-content-center">
                <div class="col-auto">
                    <table   class="table_details_c   ">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">اسم اللون </th>
                            <th scope="col">اللون</th>
                            <th scope="col">كود</th>
                            <th scope="col">الكمية</th>
                        </tr>
                        </thead>
                        <tbody>
						<?php foreach ($g_c_content as $key => $tq) {  ?>
                            <tr>
                                <th scope="row"><?php  echo $key+1 ?></th>
                                <td><?php  echo $tq['color'] ?></td>
                                <td style=" padding-right: 28px;"> <span style="display: block;width: 15px;height:15px;border-radius: 50%;background:<?php  echo $tq['code_color'] ?>;border: 1px solid gainsboro" ></span> </td>
                                <td><?php  echo $tq['code'] ?></td>
                                <td><?php  echo $tq['quantity'] ?></td>
                            </tr>
						<?php  } ?>

                        </tbody>
                    </table>



                </div>
            </div>


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



        .table_details_c {
            width: auto;
            background: #ffff;
            text-align: center;
        }

        .table_details_c th {
            width: auto;
            background: #a5d5e2 !important;
            color: black;
            border: 1px solid #000000;
        }
        .table_details_c tr    ,  .table_details_c tr td {
            width: auto;
            background: #ffff;
            color: black;
            border: 1px solid #000000;
        }

    </style>

<?php  } ?>



    <div class="modal  " onclick="select_qr()" id="exampleModal_qr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">SCAN QR CODE  </h5>

                </div>
                <div class="modal-body">
                    <div class="iconqr" style="margin-bottom: 18px;text-align: center">
                        <img width="100" src="<?php echo $this->static_file_site ?>/image/site/qr.png">
                    </div>

                    <form id="rprice"  method="post" action="<?php echo url .'/'. $this->folder ?>/rprice">
                        <div class="error_qr"></div>
                        <div class="form-row align-items-center">

                            <div class="col" style="position: relative">

                                <input   style="width: 0;height: 0;padding: 0;margin: 0;box-shadow: unset;outline: unset;border: 0"     autocomplete="off"   name="qr" class="form-control" id="get_qrcodeprice" placeholder="qr scan"  required>
                            </div>

                        </div>
                    </form>


                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>


    <script>

        function select_qr($type_price=null)
        {
            convertAcount=1
            $(".error_qr").empty();
            $("#get_qrcodeprice").val('');
            $(document).ready(function() {
                $("#get_qrcodeprice").select();
            });

        }


        $("#rprice").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var url = form.attr('action');
            idExcel=$('#size_memory option:selected').val();
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize()+"&idExcel="+idExcel+"&submit=submit", // serializes the form's elements.
                success: function(data)
                {
                    if (data==='rqr')
                    {
                        $("#get_qrcodeprice").val('').select();
                        $(".error_qr").text('Error Qr Code');
                    }else if (data==='unk')
                    {
                        $(".error_qr").text('Error Qr Code');
                    }else
                    {
                        convertAcount=0
                        $("#get_qrcodeprice").val('');
                        $("#exampleModal_qr").modal('hide');
                        $("#price_device").text(data)
                    }
                }
            });


        });




        function addToCart(code,price_type=0) {

            var number=$('#number_item_'+price_type).val();

            var  dataD={'id_item':<?php echo $result['id'] ?>,'code':code,'price_type':price_type,'number':number};

            $.get('<?php echo url .'/'.$this->folder ?>/cart_order', { jsonData: JSON.stringify( dataD )}, function(data){

                if (data !=='finish')
                {
                    $.get("<?php echo url .'/'.$this->folder ?>/count_c" , function(e) {
                        $('span.count_item').text(e);
                    });

                    if (price_type) {
                        $('.alertTable').html(`
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa fa-check-circle"> </i>  <span> تمت الاضافة  </span>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                           </button>
                      </div>`);

                        setTimeout(function () {
                            $('.alertTable').empty();
                        }, 4000);
                    } else {

                        alert('تمت الاضافة الى السله')
                    }


                    $('.button_buy').css('display','block');
                    $('.empty_car').css('display','none');
                    $('.item_cat').html(data);

                }else
                {
                    alert('نفذت الكمية')
                }
            });

        }




    </script>

<?php $this->publicFooter(); ?>