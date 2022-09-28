
<?php if (!empty($g_c_content)) {   ?>

<?php  foreach ($g_c_content as $key => $result)  { ?>
    <div class="col-lg-6 col-md-6 col-sm-6"  style="margin-bottom: 30px">

        <div class="grid_comparison">
            <form id="buy_form_<?php echo $key ?>">
                <div class="details_mobile">

                    <div class="row">
                        <div class="col-12">
                            <br>

                            <div class="image_mobile_show">

                                <?php  if ($result['bast_it'] == 1 ) { ?>
                                    <div class="bast_device">
                                        <?php echo $this->langSite('bast_it') ?>
                                    </div>

                                <?php } ?>
                                <?php  if ($result['cuts'] == 1 ) { ?>
                                    <div class="price_cuts_note" style="left: 3px;bottom: 12px;">
                                        <?php echo $this->langSite('price_cuts') ?>
                                    </div>

                                <?php } ?>
                                <img class="image_user" src="<?php echo $this->static_file_site ?>/image/site/loding.gif"  id="imagePhone_<?php echo $key ?>">


                            </div>
                        </div>

                        <div class="col-12">



                            <div class="details_info_mobile">

                                <div class="choose_color_mobile">
                                    <div class="t_d_m">
                                        تفاصيل المنتج
                                    </div>

                                    <div class="color">
                                         </i> <span> اللون  </span>
                                    </div>
                                    <hr>

                                    <div class="required_color"></div>
                                    <?php foreach ($result['color'] as $index => $print_g_c) { ?>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadioInline<?php echo $print_g_c['id'] ?>_<?php echo $index ?>"
                                                   onchange="gstImageFromRadio_<?php echo $key ?>(<?php echo $print_g_c['id'] ?>)"
                                                   value="<?php echo $print_g_c['img'] ?>" name="color"
                                                   class="custom-control-input" <?php if ($index == 0) echo 'checked' ?> >
                                            <label class="custom-control-label label_color_<?php echo $print_g_c['id'] ?>"
                                                   for="customRadioInline<?php echo $print_g_c['id'] ?>_<?php echo $index ?>">   <?php if ($print_g_c['color'] != 'بلا') echo $print_g_c['color'] ?> </label>
                                        </div>
                                        <style>
                                            .label_color_<?php  echo  $print_g_c['id']  ?>::before {
                                                background-color: <?php  echo $print_g_c['code_color']?>;
                                                width: 1rem;
                                                height: 1rem;
                                                cursor: pointer;

                                                border: 1px solid #d5d5d5;
                                            }

                                            .label_color_<?php  echo   $print_g_c['id']   ?>:after {
                                                width: 1rem;
                                                height: 1rem;
                                                cursor: pointer;
                                            }

                                            .custom-radio .custom-control-input:checked ~ .custom-control-label.label_color_<?php  echo   $print_g_c['id']   ?>::before {
                                                background-color: <?php  echo $print_g_c['code_color']?>;
                                                border: 1px solid #d5d5d5;
                                            }
                                        </style>
                                    <?php } ?>


                                </div>
                                <hr>
                                <div class="required_size"></div>
                                <label for="size_memory">حجم الذاكرة</label>
                                <select class="custom-select mr-sm-2"  name="size" onchange="getPrice_<?php echo $key ?>()" id="size_memory">

                                </select>

                                <hr>

                                <span> <?php  echo $this->langControl('price_between') ?>  : </span>


                                <?php  if ($result['cuts'] == 1 ) {  ?>
                                    <span  style="text-decoration: line-through;font-size: 15px;font-weight:normal "   class="price_style_comp" id="price_device_<?php echo $key ?>" ></span>
                                    <span style="color: green;font-weight: bold" class="price_cuts" class="price_style_comp" id="price_device_<?php echo $key ?>"> <?php  echo $result['price_cuts']?> د.ع  </span>

                                <?php  } else {  ?>
                                    <span   class="price_style_comp" id="price_device_<?php echo $key ?>"></span>
                                <?php  }  ?>




                                <span"></span>


                                <hr>
                            </div>


                            <div class="cart_a">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="done_buy_<?php echo $key ?>">

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-3 col-sm-6 col-6">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend x_plus">
                                                <button type="button" class="btn  minus" id="minus_<?php echo $key ?>"> -</button>
                                            </div>
                                            <input type="text" name="number" value="1"
                                                   class="form-control x_ox_number" id="count_<?php echo $key ?>" readonly>
                                            <div class="input-group-prepend x_plus">
                                                <button type="button" class="btn  plus" id="plus_<?php echo $key ?>"> +</button>
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


            <script>


                var price_<?php echo $key ?> = 0;
                var count_<?php echo $key ?> = 1;

                $('#minus_<?php echo $key ?>').click(function () {
                    if (count_<?php echo $key ?> > 1) {
                        count_<?php echo $key ?> = parseInt(count_<?php echo $key ?>) - 1;
                        $("#count_<?php echo $key ?>").val(count_<?php echo $key ?>);

                    }

                });

                $('#plus_<?php echo $key ?>').click(function () {
                    count_<?php echo $key ?> = parseInt(count_<?php echo $key ?>) + 1;
                    $("#count_<?php echo $key ?>").val(count_<?php echo $key ?>);
                });


                $(document).ready(function () {
                    $('#buy_form_<?php echo $key ?>').submit(function (e) {
                        e.preventDefault();
                        $.ajax({
                            type: "POST",
                            url: '<?php echo url  ?>/mobile/car_item/<?php  echo $result['id']?>/' + count_<?php echo $key ?>,
                            data: $(this).serialize(),
                            success: function (data) {


                                if (isJson(data)) {
                                    var result=JSON.parse(data);
                                    $('.done_buy_<?php echo $key ?>').html(`<div class="alert alert-warning alert-dismissible fade show" role="alert">
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
                                    $.get("<?php echo url  ?>/mobile/count_c" , function(e){
                                        $('span.count_item').text(e);
                                        $('.button_buy').css('display','block');
                                        $('.empty_car').css('display','none');
                                        $('.done_buy_<?php echo $key ?>').html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
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
                                        $('.done_buy_<?php echo $key ?>').empty();
                                    }, 4000);


                                }

                            }
                        });
                    });
                });

                gstImageFromRadio_<?php echo $key ?>(<?php  echo $result['id_color'] ?>);

                function gstImageFromRadio_<?php echo $key ?>(id) {
                    $('#imagePhone_<?php echo $key ?>').attr('src', "<?php echo $this->static_file_site ?>/image/site/loding.gif");

                    var value = $("#buy_form_<?php echo $key ?> input[type=radio][name='color']:checked").val();

                    $.get("<?php echo url  ?>/mobile/dtl/" + id, function (data) {

                        imageUrl="<?php echo $this->save_file ?>"+value;
                        $('#imagePhone_<?php echo $key ?>').attr('src', imageUrl);
                        $('#buy_form_<?php echo $key ?> #size_memory').html(data);
                        getPrice_<?php echo $key ?>();
                    });


                }


                function getPrice_<?php echo $key ?>() {
                    $.get("<?php echo url  ?>/mobile/price/" + $('#buy_form_<?php echo $key ?> #size_memory option:selected').val()+"/<?php echo $result['price_dollars'] ?>", function (data) {
                        price_<?php echo $key ?>=data;
                        $('#price_device_<?php echo $key ?>').html((data) + ' <?php  if (isset($_COOKIE['currency'])) {  if ($_COOKIE['currency'] == 0 ) echo 'د.ع'; else echo '$' ;}else{  echo 'د.ع' ;}      ?>');
                    });
                }

            </script>

        </div>

    </div>
<?php  }  ?>


<?php  }  else { ?>

    <div class="alert alert-danger" role="alert" style="width: 100%;">
        <span>   لا توجد منتجات للمقارنة بينها يرجى الضغط على هذة العلامة   </span>  <i class="fa fa-exchange"> </i>   <span> لإضافة المنتجات الى قائمة المقارنات  </span>
    </div>

<?php  }  ?>
