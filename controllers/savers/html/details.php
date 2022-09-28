<?php $this->publicHeader($result['title']); ?>





    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">  عرض المواقع  </h5>

                </div>
                <div class="modal-body">

                 	<?php  if (!empty($latiniin)) { ?>
                                    <ul  class="list-group sub_code"  >
										<?php foreach ($latiniin as $code) { ?>
                                            <li class="list-group-item">

                                                <div class="row justify-content-between">
                                                    <div class="col-auto"> <?php echo $code['code']  ?></div>
                                                    <div class="col-auto">
                                                        <img  width="40" src="<?php echo $code['image']  ?>">
                                                    </div>

                                                </div>

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




            </div>

            <div class="col-lg-9">


                <br>


                    <nav aria-label="breadcrumb" class="path_bread">
                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="<?php  echo url ?>"><i class="fa fa-home"></i> </a></li>

                            <li class="breadcrumb-item  "  aria-current="page" > <a href="<?php  echo url .'/'.$this->folder?>/list_view"><?php echo $this->langControl('savers')  ?> </a> </li>
                            <li class="breadcrumb-item   active "  aria-current="page" > <?php echo $result['title'] ?></li>


                        </ol>
                    </nav>


                <div class="filte_savers">


                    <style>
                        .dropdown_filter
                        {
                            border: 2px solid #495678;
                            border-radius: 0;
                            margin-bottom: 15px;
                        }

                        .btn_search_filter
                        {
                            border: 2px solid #495678;
                            border-radius: 0;
                            width: 100%;
                            margin-bottom: 15px;
                            background: #495678;
                            color: #ffff;
                            z-index: 10;
                            position: relative;
                        }

                    </style>
                    <div class="row">

                        <div class="col-lg-3 col-md-3 col-sm-6">

                            <select class="custom-select dropdown_filter" name="brand" id="brand"   onchange="brand()"   required>
                                <option>   اختر الماركة </option>
                                <?php foreach ($category as $key => $catg) {   ?>
                                    <option    value="<?php  echo $catg['id']?>"><?php  echo $catg['title']?></option>
                                <?php  } ?>

                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">

                            <select onchange="typeDevice_public()" class="custom-select dropdown_filter" name="nameDevice_public"   id="nameDevice_public" required>
                                <option>   اختر السلسلة </option>
                            </select>
                        </div>


                        <div class="col-lg-3 col-md-4 col-sm-5">

                            <select    class="custom-select dropdown_filter"   id="typeDevice_public" required>

                                <option>   اختر الجهاز  </option>
                            </select>
                        </div>


                        <div class="col-lg-2 col-md-2 col-sm-5">

                            <select id="type_cover"   class="custom-select dropdown_filter"     required>

                                <option  value="all" >الكل</option>
                                <option   value="ml" >   رجالي  </option>
                                <option  value="fm" >   نسائي  </option>

                            </select>
                        </div>



                        <div class="col-lg-2 col-md-2">
                            <button  class="btn  btn_search_filter" onclick="colorDevice_public()"    >بحث</button>
                        </div>

                    </div>
                    <script>

                        $(document).ready(function(){

                            $("#brand option").each(function(){
                                if($(this).val()===localStorage.getItem("cats1")){ // EDITED THIS LINE
                                    $(this).attr("selected","selected");
                                    brand();
                                }
                            });


                            $("#type_cover option").each(function(){
                                if($(this).val()===localStorage.getItem("type_cover")){ // EDITED THIS LINE
                                    $(this).attr("selected","selected");
                                }
                            });


                        });


                        function brand() {


                            $.get("<?php echo url . '/' . $this->folder ?>/getNmaDevice_public/" + $('#brand option:selected').val(), function (data) {
                                $('#nameDevice_public').html(data);

                                if (data)
                                {

                                    $("#nameDevice_public option").each(function(){
                                        if($(this).val()===localStorage.getItem("cats2")){ // EDITED THIS LINE
                                            $(this).attr("selected","selected");
                                        }
                                    });

                                    typeDevice_public($('#brand option:selected').val())


                                }
                            });

                            localStorage.setItem("cats1",  $('#brand option:selected').val() );


                        }

                        function typeDevice_public() {

                            $.get("<?php echo url . '/' . $this->folder ?>/typeDevice_public/"+$('#nameDevice_public option:selected').val(), function (data) {
                                $('#typeDevice_public').html(data);



                                cats3="<?php  echo $id_device ?>";
                                $("#typeDevice_public option").each(function(){
                                    if($(this).val()===cats3){ // EDITED THIS LINE
                                        $(this).attr("selected","selected");
                                    }
                                });

                            });

                            localStorage.setItem("cats2", $('#nameDevice_public option:selected').val());

                        }

                        function colorDevice_public() {
                            var type= $('#type_cover option:selected').val()
                            localStorage.setItem("type_cover",type);
                            $.get("<?php echo url . '/' . $this->folder ?>/colorDevice_public/"+$('#typeDevice_public option:selected').val()+"/"+type, function (data) {

                                $('#filter').html(data)

                            });

                        }




                    </script>




                </div>
                   <hr>

                    <div class="row" id="filter" >
                <form id="buy_form">
                    <div class="details_mobile">

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


                                <div class="image_mobile_show">

                                    <?php  if ($result['bast_it'] == 1 ) { ?>
                                        <div class="bast_device">
                                            <?php echo $this->langSite('bast_it') ?>
                                        </div>

                                    <?php } ?>

                                    <img class="image_user" src="<?php echo $this->static_file_site ?>/image/site/loding.gif"  id="imagePhone">

                                    <script>

                                    </script>

                                </div>
                            </div>

                            <div class="col-lg-6">



                                <div class="details_info_mobile">


                                    <div class="notePrice">

                                        <?php  echo $this->setting->get('note')?>
                                    </div>

                                    <div class="choose_color_mobile">
                                        <div class="t_d_m">
                                            اختيار التفاصيل
                                        </div>

                                        <hr>

                                        <style>

                                            .choose_image img
                                            {

                                                width: 40px;
                                                height: 40px;
                                                margin-bottom: 10px;
                                                border: 1px solid gainsboro;
                                            }

                                            /* HIDE RADIO */
                                            .choose_image [type=radio] {
                                                position: absolute;
                                                opacity: 0;
                                                width: 0;
                                                height: 0;
                                            }

                                            /* IMAGE STYLES */
                                            .choose_image  [type=radio] + img {
                                                cursor: pointer;
                                            }

                                            /* CHECKED STYLES */
                                            .choose_image [type=radio]:checked + img {
                                                outline: 2px solid #f00;
                                            }


                                        </style>

                                        <div class="required_color"></div>
                                        <?php foreach ($latiniin as $key => $print_g_c) { ?>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <label class="choose_image">
                                                <input data-id="<?php echo $print_g_c['id'] ?>"  type="radio" id="customRadioInline<?php echo $print_g_c['id'] ?>"
                                                       onchange="gstImageFromRadio('<?php echo $print_g_c['code'] ?>' )"
                                                       value="<?php echo $print_g_c['img'] ?>" name="color"
                                                       class="custom-control-input" <?php if ($print_g_c['id'] == $id) echo 'checked' ?> >
                                                         <img src="<?php echo $print_g_c['image'] ?>">
                                                </label>
                                            </div>
                                            <style>
                                                .label_color_<?php  echo  $key  ?>::before {
                                                    background-color: <?php  echo $print_g_c['code_color']?>;
                                                    width: 2rem;
                                                    height: 2rem;
                                                    cursor: pointer;

                                                    border: 1px solid #d5d5d5;
                                                }

                                                .label_color_<?php  echo  $key  ?>:after {
                                                    width: 2rem;
                                                    height: 2rem;
                                                    cursor: pointer;
                                                }

                                                .custom-radio .custom-control-input:checked ~ .custom-control-label.label_color_<?php  echo  $key  ?>::before {
                                                    background-color: <?php  echo $print_g_c['code_color']?>;
                                                    border: 1px solid #d5d5d5;
                                                }
                                            </style>
                                        <?php } ?>


                                    </div>



                                    <hr>


                                    <div class="price_type_list">



                                    </div>


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
                                                    <button type="button" class="btn  " id="minus"> - </button>
                                                </div>
                                                <input type="number" min="1" name="number" value="1"
                                                       class="form-control x_ox_number" id="count"  >
                                                <div class="input-group-prepend x_plus">
                                                    <button type="button" class="btn  " id="plus"> + </button>
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

            </div>



            </div>


            <script>


                function x_error_color() {
                    $('.required_color').text('');
                }


                var price = 0;
                var count = 1;



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

                        var id = $("input[type=radio][name='color']:checked").attr('data-id');
                        e.preventDefault();
                        $.ajax({
                            type: "POST",
                            url: '<?php echo url . '/' . $this->folder ?>/car_item/'+id+'/'+$("#count").val()+'/'+<?php echo $result['id_device']?>+'/'+<?php echo $id_device_customer?>,
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

                function addToCartCover(id,id_device,id_device_customer,price_type=0) {
                    var number=1;
                    if ($('#number_item_'+price_type).val())
                    {
                          number=$('#number_item_'+price_type).val();
                    }

                    $.get('<?php echo url ?>/savers/cart_order/'+id+'/'+id_device+'/'+id_device_customer,{price_type:price_type,number:number}, function(data){
                        if (data !=='finish')
                        {
                            $.get("<?php echo url ?>/savers/count_c" , function(e) {
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


                label.custom-control-label {
                    margin: 0px 11px;
                }

            </style>


        </div>


    </div>




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
            iditem=$('input[name="color"]:checked').data('id');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize()+"&idcolor="+iditem+"&submit=submit", // serializes the form's elements.
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



        gstImageFromRadio('<?php  echo $result['code'] ?>');

        function gstImageFromRadio(code) {
            $('#imagePhone').attr('src', "<?php echo $this->static_file_site ?>/image/site/loding.gif");

            var value = $("input[type=radio][name='color']:checked").val();

            $.get("<?php echo url . '/' . $this->folder ?>/price/",{code:code}, function (data) {

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


                $('.price_type_list').html(data);
                if (data)
                {
                    setfocusInput()
                }

            });


        }



    </script>

    <style>
        .image_mobile_show {
            text-align: center;
        }

        .image_mobile_show img.image_user {
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





<?php $this->publicFooter(); ?>