<?php  $this->publicHeader($this->langSite('savers'));  ?>
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
                            <li class="breadcrumb-item"> <?php  echo $this->langSite('savers') ?>  </li>

                        </ol>
                    </nav>


                <br>

                <style>
                	.filte_savers{
                        display:flex;
                    }
                    .filte_savers .col-lg-3{
                        padding-left: 5px !important;
                    }

                    .custom-select{
                        height: calc(1.5em + .75rem + 11px) !important;

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
                        /*   width: 100%; */
                        height: calc(1.5em + .75rem + 11px) !important;
                        padding-left: 29px !important;
                        padding-right: 29px !important;
                        margin-bottom: 15px;
                        margin-left: 3px;
                        background: #495678;
                        color: #ffff;
                    }

                    @media (max-width: 767px) {
                    	.btn_search_filter{
                        	width: 100%;
                    	}
                    	.filte_savers .col-sm-6,
                        .filte_savers .col-sm-5{
                        	padding-left:15px !important;
                    	}
                    }

                </style>


          <div class="filte_savers">


                <div class="row">

                    <div class="col-lg-3 col-md-3 col-sm-6">

                        <select class="custom-select dropdown_filter" name="brand" id="brand"   onchange="brand()"   required>
                            <option>   اختر الماركة </option>
                            <?php foreach ($category as $key => $catg) {   ?>
                                <option    value="<?php  echo $catg['id']?>"><?php  echo $catg['title']?></option>
                            <?php  } ?>

                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">

                        <select onchange="typeDevice_public()" class="custom-select dropdown_filter" name="nameDevice_public"   id="nameDevice_public" required>
                            <option>   اختر السلسلة </option>
                        </select>
                    </div>


                        <div class="col-lg-3 col-md-3 col-sm-5">

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


                            <div class="col-lg-1 col-md-1 col-sm-2">
                                <button  class="btn  btn_search_filter" onclick="colorDevice_public()"    >بحث</button>
                            </div>

                </div>

            </div>
                <br>

                <div class="container">



                    <div class="row" id="filter" >
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


                    </div>


                    <br>


                </div>
            </div>

        </div>
    </div>
    <script>


        function brand() {

            localStorage.setItem("cats1",  $('#brand option:selected').val() );
            $.get("<?php echo url . '/' . $this->folder ?>/getNmaDevice_public/" + $('#brand option:selected').val(), function (data) {
                $('#nameDevice_public').html(data);

                if (data)
                {
                    typeDevice_public($('#brand option:selected').val())
                }
            });




        }

        function typeDevice_public() {
            localStorage.setItem("cats2", $('#nameDevice_public option:selected').val());
            $.get("<?php echo url . '/' . $this->folder ?>/typeDevice_public/"+$('#nameDevice_public option:selected').val(), function (data) {
                $('#typeDevice_public').html(data);

            });


        }

        function colorDevice_public() {


            $('#filter').html(`

               <div style="text-align:center;width: 100%;"> <img  width="50"  src="<?php echo $this->static_file_site ?>/image/site/loadingx.gif"  ></div>

            `
            );


            var type= $('#type_cover option:selected').val()
            localStorage.setItem("type_cover",type);
            $.get("<?php echo url . '/' . $this->folder ?>/colorDevice_public/"+$('#typeDevice_public option:selected').val()+"/"+type, function (data) {

                $('#filter').html(data)
            });
        }




    </script>





    <script>

     function  like_d(id) {

            $.get('<?php echo url ?>/savers/like_d/'+id, function(data){
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

          $.get('<?php echo url ?>/savers/unlike_d/'+id, function(data){
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

        function addToCartCover(id,id_device,id_device_customer,price_type=0) {

            $.get('<?php echo url ?>/savers/cart_order/'+id+'/'+id_device+'/'+id_device_customer,{price_type:price_type}, function(data){
                if (data !=='finish')
                {
                    $.get("<?php echo url ?>/savers/count_c" , function(e) {
                        $('span.count_item').text(e);
                    });
                    $('.addedToCart_savers'+id).html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa fa-check-circle"> </i>  <span> تمت الاضافة  </span>
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                           </button>
                                     </div>`);
                        $('.button_buy').css('display','block');
                    $('.empty_car').css('display','none');
                    $('.item_cat').html(data);
                    setTimeout(function(){
                        $('.addedToCart_savers'+id).empty();
                    }, 4000);

                }else
                {
                    alert('نفذت الكمية')
                }
            });

        }

    </script>



<style>
    ul#pagination-demo li
    {
        padding: 0 2px;
    }
    ul#pagination-demo li a
    {
        border-radius: 5px;
    }

    .page-active {
        display: block;
    }
    .page.active a
    {
        background: #007bff;
        color: #FFFFFF;
    }


    .filter_x
    {
        border: 1px solid #d6d6d6;
        padding: 29px 5px;
        border-top: 0;
    }
    .filter_x select
    {
       border-radius: 0;
    }


</style>

<br>

<?php $this->publicFooter(); ?>