<?php  $this->publicHeader($this->langSite('savers'));  ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">

                <?php $this->menu->menu() ?>



<div class="filter_x">


    <div class="row">
        <div class="col-12">

            <select class="custom-select" name="brand" id="brand"   onchange="brand()"   required>
                <?php foreach ($category as $key => $catg) {   ?>
                    <option    value="<?php  echo $catg['id']?>"><?php  echo $catg['title']?></option>
                <?php  } ?>

            </select>
        </div>

    </div>
    <br>


     <form id="myform" action="<?php  echo url .'/'. $this->folder?>/device" method="post">

         <div class="row">
             <div class="col-12">

                 <select onchange="typeDevice_public()" class="custom-select" name="nameDevice_public"   id="nameDevice_public" required>

                 </select>
             </div>
         </div>
         <br>


        <div class="row">
            <div class="col-12">

                <select  onchange="colorDevice_public()" class="custom-select"   id="typeDevice_public" required>

                </select>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-12">

                <select   class="custom-select"  name="colorDevice_public" id="colorDevice_public" required>

                </select>
            </div>
        </div>
         <div class="msgc"></div>

         <br>
        <div class="container">
            <div class="row justify-content-md-center ">
                <div class="col-md-auto">
                    <input  class="btn btn-primary" type="submit" name="submit" value="بحث">
                </div>
            </div>
        </div>

     </form>

</div>
    <script>

        brand();
        function brand() {

            $.get("<?php echo url . '/' . $this->folder ?>/getNmaDevice_public/" + $('#brand option:selected').val(), function (data) {
                $('#nameDevice_public').html(data);

                if (data)
                {
                    typeDevice_public($('#brand option:selected').val())
                }
            });
        }

        function typeDevice_public() {

            $.get("<?php echo url . '/' . $this->folder ?>/typeDevice_public/"+$('#nameDevice_public option:selected').val(), function (data) {
                $('#typeDevice_public').html(data);
                if (data)
                {
                    colorDevice_public()
                }

            });
        }

        function colorDevice_public() {


            $.get("<?php echo url . '/' . $this->folder ?>/colorDevice_public/"+$('#typeDevice_public option:selected').val(), function (data) {
                $('#colorDevice_public').html(data);
            });
        }


        $(function() {

            $("#myform").submit(function(e) {

                e.preventDefault();
                var actionurl = e.currentTarget.action;
                $.ajax({
                    url: actionurl,
                    type: 'post',
                    data: $("#myform").serialize()+'&submit',
                    success: function(data) {

                        if (data==='notSelect')
                        {
                            $('.msgc').html(`
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    يرجى تحديد الكل !
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                            `)
                        }else  if (data==='notFound') {
                            $('.msgc').html(`
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                  !غير متوفر حاليا
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>

                            `)
                         }
                        else {
                            $('#filter').html(data)
                        }
                    }
                });

            });

        });






</script>


        <br>
                <br>



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

                <div class="container">

                    <div class="row" id="filter" >
                        <?php foreach ($data_view as $printContent) {   ?>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">

                                <div   class="infoDevice">
                                    <?php  if ($printContent['bast_it'] == 1 ) { ?>
                                        <div class="bast_device">
                                            <?php echo $this->langSite('bast_it') ?>
                                        </div>

                                    <?php } ?>
                                    <a href="<?php echo url ?>/savers/details/<?php echo $printContent['id'] ?>"  >
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
                                    <div class="pricDevice">
                                        <?php echo $printContent['price'] ?>
                                    </div>

                                    <div class="c_device">
                                        <div class="addedToCart_savers<?php echo $printContent['id'] ?>"></div>

                                        <div class="row align-items-center justify-content-center">

                                            <div class="col-6" style="padding: 0">

                                                <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>
                                                    <?php if ($this->phone=='true' || $this->isDirect()) {   ?>
                                                    <button type="button" class="btn btn_cart" onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['priceC'] ?>','<?php echo $printContent['nameImage'] ?>','<?php echo $printContent['color'] ?>','<?php echo $printContent['code_color'] ?>','<?php echo $printContent['code'] ?>')">
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
                        <?php  } ?>

                    </div>


                    <br>
                    <div class="row justify-content-center">
                        <div class="col-auto ">
                            <ul id="pagination-demo" class="pagination "></ul>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>


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

        function addToCart(id,price,nameImage,name_color,code_color,code) {

            var  dataD={'id_item':id,'price':price,'image':nameImage,'name_color':name_color,'color':code_color,'code':code};

            $.get('<?php echo url ?>/savers/cart_order', { jsonData: JSON.stringify( dataD )}, function(data){
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


    <script>

        $('#pagination-demo').twbsPagination({
            totalPages: <?php echo $count ?>,
            startPage: <?php echo $page ?>,
            visiblePages: 5,
            initiateStartPageClick: false,
            href: false,
            hrefVariable: '{{page}}',
            first: 'الاول',
            prev: '&laquo;',
            next: '&raquo;',
            last: 'الاخير',
            loop: false,
            onPageClick: function (event, page) {
                $('.page-active').removeClass('page-active');
                $('#page'+page).addClass('page-active');
                window.location.href='<?php echo url .'/'.$this->folder ?>/list_view/'+page
            },
            paginationClass: 'pagination',
            nextClass: 'next',
            prevClass: 'prev',
            lastClass: 'last',
            firstClass: 'first',
            pageClass: 'page',
            activeClass: 'active',
            disabledClass: 'disabled',

        });



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

    .menu_category {
        border: 1px solid #d6d6d6;
        height: auto;
        border-top: 2px solid #fe5600;
        padding-top: 40px;
        overflow: hidden;
        overflow-y: auto;
        padding-bottom: 35px;
        border-bottom: 0;
    }


</style>

<br>

<?php $this->publicFooter(); ?>