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




                <form id="idForm_computer_assembly" action="<?php echo url .'/'. $this->folder?>/cart_order/<?php echo $id ?>" method="post" >

                <div class="row" id="filter">




                        <div class="col-12">

                            <div class="details_info_mobile">


                                <div class="m_item">
                                    عناصر  التجميعة
                                </div>

                                <div class="row">

                                <?php  foreach ($item as $outItem) {  ?>
                                    <div class="col-12 mb-2">

                                        <table class="table table-bordered tableSet">
                                            <tbody>
                                            <tr>

                                                <th>#</th>
                                                <th>صورة</th>
                                                <th>اسم</th>
                                                <th>حجم الذاكرة</th>
                                                <th>السعر</th>

                                            </tr>
                                            <tr   <?php if (!empty($outItem['disabled']))  { ?>  style="background: #f59393;color:#fff "  data-toggle="tooltip" data-placement="top" title="نفذت الكمية" <?php  }  ?> >

                                                <td>

                                                    <div class="custom-control custom-checkbox">
                                                        <input  <?php  echo  $outItem['disabled'] ?> type="checkbox" name="item[]" onchange="checkedSet()"  value="<?php  echo $outItem['id']  ?>" class="custom-control-input checkedSet" id="check_id_<?php  echo $outItem['id'] ?>">
                                                        <label class="custom-control-label" for="check_id_<?php  echo $outItem['id'] ?>"></label>
                                                    </div>

                                                </td>

                                                <td  >
                                                    <img class="imgItem"   <?php if (empty($outItem['disabled']))  { ?> onclick="selectCheckbox(<?php echo $outItem['id'] ?>)" <?php } ?>  src="<?php echo $outItem['img'] ?>">
                                                </td>

                                                 <th >
                                                 <div class="title_item"  <?php if (empty($outItem['disabled']))  { ?> onclick="selectCheckbox(<?php echo $outItem['id'] ?>)" <?php } ?>  > <?php echo $outItem['title'] ?></div>
                                                </th>
                                                <th  >
                                                    <div class="title_item"   <?php if (empty($outItem['disabled']))  { ?> onclick="selectCheckbox(<?php echo $outItem['id'] ?>)" <?php } ?>   > <?php echo $outItem['size'] ?></div>
                                                </th>
                                                <th  >
                                                 <div class="title_item"   <?php if (empty($outItem['disabled']))  { ?> onclick="selectCheckbox(<?php echo $outItem['id'] ?>)" <?php } ?>  > <?php echo $outItem['price'] ?></div>
                                                </th>


                                            </tr>



                                            <tr>
                                             <?php  if ($outItem['sub'])  { ?>
                                                <th   class=" other_item text-center"  > <i class="fa fa-level-up"></i>  <i class="fa fa-level-up"></i> </th>
                                                <th   class=" other_item text-center" colspan="3">بدائل</th>
                                                <th   class=" other_item text-center"  > <i class="fa fa-level-up"></i><i class="fa fa-level-up"></i> </th>
                                                <?php }   ?>

                                            </tr>
                                            <?php  if ($outItem['sub']) {  ?>

                                            <?php  foreach ($outItem['sub'] as $subItem)   { ?>
                                            <tr>

                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input  value="<?php  echo $subItem['id']  ?>"   onchange="checkedSet()"   name="item[]" type="checkbox" class="custom-control-input checkedSet" id="check_id_<?php  echo $subItem['id'] ?>">
                                                        <label class="custom-control-label" for="check_id_<?php  echo $subItem['id'] ?>"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <img  class="imgItem"  onclick="selectCheckbox(<?php echo $subItem['id'] ?>)"  src="<?php echo $subItem['img'] ?>">
                                                </td>
                                                <td>
                                                    <div class="title_item"   onclick="selectCheckbox(<?php echo $subItem['id'] ?>)"  > <?php echo $subItem['title'] ?></div>

                                                </td>
                                                <td>
                                                    <div class="title_item"   onclick="selectCheckbox(<?php echo $subItem['id'] ?>)"  > <?php echo $subItem['size'] ?></div>

                                                </td>
                                                <td>
                                                    <div class="title_item"   onclick="selectCheckbox(<?php echo $subItem['id'] ?>)"  > <?php echo $subItem['price'] ?></div>

                                                </td>

                                            </tr>
                                            <?php } ?>
                                            <?php } ?>



                                            </tbody>
                                        </table>


                                    </div>



                                <?php  } ?>

                            </div>
                            </div>

                        </div>



                </div>



                    <div class="row">

                        <div class="col-12">
                            <div class="addedToCart_computer_assembly"></div>
                        </div>

                        <div class="col-auto mainInfoPrice">

                            <span>  سعر المواد الرئيسية للتجميعة : </span>

                            <span id="price_device"> <?php  echo $price ?> </span>

                            <button type="button" data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $priceC ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button>

                        </div>

                        <div class="col-auto subInfoPrice" style="display: none">
                        </div>


                        <div class="col-auto">
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


                </form>
             <br>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="image_computer_assembly_show">

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
                </div>

<br>
<script>


    function selectCheckbox(id) {

        var vis=$("#check_id_"+id).is( ':checked' )? 1:0;

        if (vis===0)
        {
            $("#check_id_"+id).prop('checked', true);
        }else
        {
            $("#check_id_"+id).prop('checked', false);
        }
        checkedSet()
    }


    function  checkedSet(){
        var ids=[];
        $("input.checkedSet:checked").each(function(){
            ids.push($(this).val());
        });

        if (ids.length !== 0)
        {

            $.get( "<?php echo url .'/'.$this->folder  ?>/getPriceItemSelect/<?php echo  $id ?>",{ids:ids}, function( data ) {

               if (data==='error')
               {
                 alert('حدث خطأ اعد المحاولة لاحقا')
                   $('.mainInfoPrice').show()
                   $('.subInfoPrice').hide()
               }else  if (data)
                {

                  var respo= JSON.parse(data)

                    $('.subInfoPrice').html(`

                         <span>  سعر المواد المحددة : </span>

                            <span id="price_device"> ${respo.price} </span>

                            <button type="button" data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'${respo.priceC}')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button>


                    `)
                    $('.mainInfoPrice').hide()
                    $('.subInfoPrice').show()

                }else
               {
                   alert('حدث خطأ اعد المحاولة لاحقا')
                   $('.mainInfoPrice').show()
                   $('.subInfoPrice').hide()
               }

            });

        }else
        {
            $('.mainInfoPrice').show()
            $('.subInfoPrice').hide()
        }

    }



</script>


    <style>


        .title_item {
            cursor: pointer;
        }

        .imgItem {
            cursor: pointer;
            width: 100px;
            height: 70px
        }

        .other_item {
            background: #efefef;
            padding: 0 !important;
        }

        .tableSet
        {
            background:#fbfbfb ;
        }

    </style>



                <div class="row">


                        <?php  if ($random)  {  ?>
                        <div class="col-12">
                            <div class="alert alert-secondary" role="alert">
                               تجميعات اخرى
                            </div>

                            <div class="row" id="filter" >
                                <?php foreach ($random as $printContent) {   ?>

                                    <div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">

                                        <div  class="infoDevice">
                                            <a href="<?php echo url .'/'. $this->folder?>/details/<?php echo $printContent['id'] ?>"  >
                                                <div class="hoverBtn">
                                                    <button class="btn"><i class="fa fa-search"></i> </button>
                                                </div>
                                                <div class="imageDevise">

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




    <!-- Swiper JS -->
    <script   src="<?php echo $this->static_file_site ?>/swiper/swiper-bundle.min.js"></script>
    <!-- Initialize Swiper -->
    <script>

        var swiper2 = new Swiper(".mySwiper2", {
            spaceBetween: 10,

        });
    </script>




    <script type="text/javascript">
        function device_cover(id)
        {
            $('.list_cover').hide();
            $('#open_list_cover_'+id).show();
        }



        function get_dollar_price(e,price) {



            $.get( "<?php  echo url   ?>/dollar_price/dollar_price_convert",{price:price}, function( data ) {

                $(e).tooltip('hide')
                    .attr('data-original-title', data)
                    .tooltip('show');
            });


        }




        $("#idForm_computer_assembly").submit(function(e) {

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

                        $.get("<?php echo url ?>/computer_assembly/count_c" , function(e) {
                            $('span.count_item').text(e);
                        });

                        $('.addedToCart_computer_assembly').html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa fa-check-circle"> </i>  <span> تمت الاضافة  </span>
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                           </button>
                                     </div>`);

                        $('.button_buy').css('display','block');
                        $('.empty_car').css('display','none');
                        $('.item_cat').html('');
                        setTimeout(function(){
                            $('.addedToCart_computer_assembly'+<?php  echo $id ?>).empty();
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
        .end_computer_assembly {
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
        .item_computer_assembly {
            margin: 11px 0;
            background: #a5d5e2;
            padding: 5px;
            border-radius: 7px;
        }

        .item_computer_assembly i {
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

        .image_computer_assembly_show
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