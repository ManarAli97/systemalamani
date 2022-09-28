<?php  $this->publicHeader($this->langSite('mobile'));  ?>


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
                            <li class="breadcrumb-item active"> <a href="<?php  echo url ?>/mobile/list_view"> <?php echo $this->langSite('mobile') ?> </a>  </li>
                            <li class="breadcrumb-item active">   الاجهزة المشابهه  </li>


                        </ol>
                    </nav>


                <form id="myForm"  method="post">


                    <div class="row">
                        <div class="col-12">
                          <div class="import_category">

                              <table class="table category_mobile table-bordered">
                                  <tbody>
                                  <?php  foreach ($import_category as $catg)  { ?>

                                  <tr>
                                      <?php  foreach ($catg as $imc)  { ?>

                                          <td>
                                          <div class="custom-control custom-checkbox custom-control-inline">
                                              <input   onchange="get_data_device()" type="checkbox" name="ids_cat[]" value="<?php echo $imc['id'] ?>" id="imc-<?php echo $imc['id'] ?>"  class="custom-control-input">
                                              <label class="custom-control-label" for="imc-<?php echo $imc['id'] ?>"> <?php echo $imc['title'] ?> </label>
                                          </div>
                                      </td>
                                      <?php  }  ?>
                                  </tr>

                                  <?php  }  ?>

                                  </tbody>
                              </table>

                        </div>
                        </div>
                    </div>

                </form>


                <script>



                   function get_data_device() {

                       $('.loading_data').show('fast');
                       var formData = $('#myForm').serialize();
                       $.ajax({
                           url:  "<?php echo url .'/'. $this->folder ?>/stop_ajax/<?php echo $id .'/'. $code?>",
                           data: formData,
                           type: 'post',
                           success: function(data) {
                               if (data)
                               {
                                   $('.loading_data').hide('fast');
                                   $('#load_date_mobile').html(data)
                               }else
                               {
                                   $('.loading_data').hide('fast');
                               }
                           }
                       });

                   }



                </script>

                <style>


                    .import_category
                    {
                        margin-bottom: 30px;
                    }
                    .loading_data
                    {
                        display: none;
                        text-align: center;
                        margin-bottom: 19px;
                    }
                    .loading_data img
                    {
                        width: 40px;
                    }

                </style>



                    <div class="loading_data">
                        <img src="<?php echo $this->static_file_site ?>/image/site/loding.gif">
                    </div>

                    <div class="row"  id="load_date_mobile"  >

                        <?php  if (!empty($data_view)) {  ?>

                        <?php foreach ($data_view as $printContent) {   ?>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">

                                <div  class="infoDevice">
                                    <?php  if ($printContent['bast_it'] == 1 ) { ?>
                                        <div class="bast_device">
                                            <?php echo $this->langSite('bast_it') ?>
                                        </div>
                                    <?php } ?>


                                        <a href="<?php echo url ?>/mobile/details/<?php echo $printContent['id'] ?>"  >

                                        <div class="hoverBtn">
                                            <button class="btn"><i class="fa fa-search"></i> </button>
                                        </div>
                                        <div class="imageDevise">
                                            <img   src="<?php echo $printContent['image'] ?>" alt="لا توجد صورة">
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
                                    <textarea  disabled class="form-control description"><?php echo $printContent['description'] ?></textarea>

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

                                    <div class="c_device">
                                        <div class="addedToCart_mobile<?php echo $printContent['id'] ?>"></div>

                                        <div class="row align-items-center justify-content-center">

                                            <div class="col-lg-7 col-md-12 col-sm-auto  xcartp"  >

                                                <?php if (isset($_SESSION['username_member_r']) || $this->isDirect() ) { ?>


                                                    <?php if ($this->phone=='true' || $this->isDirect()) {   ?>

                                                        <button type="button" class="btn btn_cart" onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['size'] ?>','<?php echo $printContent['priceC'] ?>','<?php echo $printContent['nameImage'] ?>','<?php echo $printContent['code_color'] ?>','<?php echo $printContent['code'] ?>')">
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
                                            <div class="col-lg-5 col-md-12 col-sm-auto">
                                                <?php if (isset($_SESSION['username_member_r'])) { ?>

                                                    <button   type="button" class="btn btn_like  style_btn_like_mb  L_<?php echo $printContent['id']  ?> <?php  if ($printContent['like']) echo 'unlike'; else echo  'like' ?>"  onclick=<?php  if ($printContent['like']) echo "unlike_d(".$printContent['id'].",'mobile')"; else echo "like_d(".$printContent['id'].",'mobile')" ?>   >
                                                        <i class="fa fa-heart"></i>
                                                    </button>

                                                    <button    title="اضافة المنتج الى خانة المقارنة بين المنتجات"  type="button" class="btn comparison comp_<?php echo $printContent['id']  ?> <?php  if ($printContent['comparison']) echo 'un_comparison'; else echo  'comparison' ?>"  onclick=<?php  if ($printContent['comparison']) echo "un_comparison_d(".$printContent['id'].",'mobile')"; else echo "comparison_d(".$printContent['id'].",'mobile')" ?>   >
                                                        <i class="fa fa-exchange"></i>
                                                    </button>

                                                <?php } else { ?>

                                                    <button type="button" class="btn btn_like style_btn_like_mb  "   data-toggle="modal" data-target="#login_site">
                                                        <i class="fa fa-heart"></i>
                                                    </button>
                                                    <button  type="button" class="btn comparison"   data-toggle="modal" data-target="#login_site">
                                                        <i class="fa fa-exchange"></i>
                                                    </button>

                                                <?php } ?>

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        <?php  } ?>
                          <?php }else {   ?>
                            <div class="alert alert-warning" role="alert">
                                لا توجد اجهزة مشابهه من هذه الفئة يرجى اختيار فئة اخرى
                            </div>
                        <?php  }  ?>

                    </div>


                    <br>

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

        function addToCart(id,size,price,nameImage,code_color,code) {

            var  dataD={'id_item':id,'size':size,'price':price,'image':nameImage,'color':code_color,'code':code};

            $.get('<?php echo url ?>/mobile/cart_order', { jsonData: JSON.stringify( dataD )}, function(data){
                if (data !=='finish')
                {
                    $.get("<?php echo url ?>/mobile/count_c" , function(e) {
                        $('span.count_item').text(e);
                    });
                    $('.addedToCart_mobile'+id).html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa fa-check-circle"> </i>  <span> تمت الاضافة  </span>
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                           </button>
                                     </div>`);
                        $('.button_buy').css('display','block');
                    $('.empty_car').css('display','none');
                    $('.item_cat').html(data);
                    setTimeout(function(){
                        $('.addedToCart_mobile'+id).empty();
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
    .table.category_mobile td, .table th {
        padding: 5px;
    }

</style>

<br>

<?php $this->publicFooter(); ?>