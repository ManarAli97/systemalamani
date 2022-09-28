<?php $this->publicHeader($result['title']); ?>


    <div class="container">

        <div class="row">

            <div class="col-lg-3">

                <?php $this->menu->menu() ?>


            </div>

            <div class="col-lg-9">
                <br>


                <nav aria-label="breadcrumb" class="path_bread">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">   <a href="<?php echo url .'/'. $this->folder ?>">  <?phP echo $this->langSite('cards') ?> </a>  </li>
                        <li class="breadcrumb-item">    <?phP echo $result['title'] ?>  </li>
                    </ol>
                </nav>


                <div class="row">

                    <?php  foreach ($data as $dta) {  ?>
                        <div class="col-g-4 col-md-4 col-sm-6">
                            <div class="card_view"  >
                                <div class="image_card">
                                    <img src="<?php  echo $dta['image']?> ">
                                </div>
                                <div class="title_card">
                                    <?php  echo $dta['title']?>
                                    <div class="price_card">
                                        <?php  echo $dta['price']?> د.ع
                                    </div>

                                </div>

                                <div class="control_card">
                                    <div class="addedToCart_mobile<?php echo $dta['id'] ?>"></div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend"  >
                                                    <button class="input-group-text btn   minus_number_card" onclick="minus_card(<?php echo $dta['id'] ?>)">-</button>
                                                </div>
                                                <input type="text" disabled class="form-control box_count_number" id="count_card_<?php echo $dta['id'] ?>" value="1"  >
                                                <div class="input-group-prepend">
                                                    <button class="input-group-text btn plus_number_card" onclick="plus_card(<?php echo $dta['id'] ?>)">+</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">



                                            <?php if (isset($_SESSION['username_member_r']) || $this->isDirect()) { ?>


                                                <?php if ($this->phone=='true' || $this->isDirect()) {   ?>

                                                    <button  class="btn get_card" onclick="addToCart(<?php echo $dta['id'] ?>,'<?php echo trim($dta['price']) ?>','<?php echo $dta['nameImage'] ?>','<?php echo $dta['code'] ?>')">   <span>اضف   </span> <i class="fa fa-shopping-cart"></i>  </button>

                                                <?php  }else{   ?>

                                                    <button  class="btn get_card"   data-toggle="modal" data-target="#add_phone" >   <span>اضف   </span> <i class="fa fa-shopping-cart"></i>  </button>


                                                <?php  }  ?>
                                            <?php } else { ?>

                                                <button  class="btn get_card"     data-toggle="modal" data-target="#login_site" >   <span>اضف   </span> <i class="fa fa-shopping-cart"></i>  </button>

                                            <?php } ?>

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php  } ?>

                </div>



            </div>
        </div>
    </div>



<script>




function plus_card(id) {
   count= $('#count_card_'+id).val();
    count = parseInt(count) + 1;
    $('#count_card_'+id).val(count);
}


function minus_card(id) {
    if (count > 1) {
        count= $('#count_card_'+id).val();
        count = parseInt(count) - 1;
        $('#count_card_'+id).val(count);
    }
}



function addToCart(id,price,nameImage,code) {

    var  dataD={'id_item':id,'price':price,'image':nameImage,'code':code,'count':$('#count_card_'+id).val()};

    $.get('<?php echo url ?>/cards/cart_order', { jsonData: JSON.stringify( dataD )}, function(data){

        if (data !=='finish')
        {
            $.get("<?php echo url ?>/cards/count_c" , function(e) {
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

            $('.addedToCart_mobile'+id).html(`<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <i class="fa fa-check-circle"> </i>  <span> تنفذت الكمية </span>
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                           </button>
                                     </div>`);

        }
    });

}








</script>

    <style>
        .price_card {
            text-align: center;
            border-top: 1px solid #e9ecef;
            padding-top: 13px;
            color: red;
            font-weight: bold;
            margin-top: 3px;
        }

        .plus_number_card,.minus_number_card
        {
            background: #898eab;
            border: 0;
            color: #fff;
            border-radius: 0;
        }

        .plus_number_card:focus,.minus_number_card:focus {
            outline: 0;
            box-shadow: unset;
        }


        button.btn.get_card {
            width: 100%;
            border-radius: 0;
            background: #283581;
            color: #fff;
            margin: 0;
        }

        .control_card
        {
            padding: 0 4px;
            padding-top: 4px;
            border: 1px solid #e9ecef;
            border-top: 0;
        }

        .control_card .col-6
        {

        }
        .box_count_number
        {
            text-align: center;
        }
        .image_card
        {
            border: 1px solid #e9ecef;
            border-bottom: 0;
        }
        .image_card img
        {
            width: 100%;
            height: 176px;
        }

        .card_view{

            display: block;
            text-decoration: none;
            color: black;
            margin-bottom: 30px;
            -webkit-box-shadow: 5px 3px 5px 0px rgba(0, 0, 0, 0.27);
            -moz-box-shadow: 5px 3px 5px 0px rgba(0, 0, 0, 0.27);
            box-shadow: 5px 3px 5px 0px rgba(0, 0, 0, 0.27);
            transition: 0.3s;
            border-radius: 3px;
            overflow: hidden;
        }

        .card_view:hover{

            text-decoration: none;
            color: black;
            -webkit-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.1);
            -moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.1);
            box-shadow: 3px 3px 6px 2px rgba(43, 43, 43, 0.67);
        }
        .title_card {
            padding: 12px;
            border: 1px solid #e4e4e4;
        }

    </style>
    <br>
    <br>
    <br>
<?php $this->publicFooter(); ?>