
<?php  if ($this->loginUser()) {  ?>

    <div class="row_list_price">
        <span> <?php  echo $this->langControl('price_between') ?>  : </span>
        <?php

            $price_costom =   $this->price_dollarsAdmin($result['price_dollars']);

        ?>
        <span id="price_device">
            <span style="padding-left:15px">  <?php echo  $price_costom ?>  د.ع   </span>
            <button type="button" data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $price_costom  ?>')" class="btn text_price_dollar">  لمعرفة السعر بالدولار اضغط هنا   </button>
        </span>
        <button type="button" class="btn readQrbtn" onclick="select_qr()" data-toggle="modal" data-target="#exampleModal_qr">
            <i class="fa fa-qrcode"></i>
        </button>
    </div>

<?php  if ($this->ch_wcprice() ) {  ?>

<table class="table table-bordered table-striped table_wholesale_price mt-2">

    <tbody>

       <?php if ($this->wcprice(1)) { ?>
        <?php $wholesale_price =   $this->price_dollarsAdmin($result['wholesale_price']);    ?>
        <tr>
            <td>جملة</td>
            <td> <input id="number_item_1" style="width: 65px;text-align: center" type="number" value="1" class="form-control" min="1" >   </td>
            <td> <button type="button"  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button" class="btn btn-sm add_type_price"  id="price_device_1" onclick="addToCartCover('<?php echo $result['id'] ?>',1)" >   <?php echo $wholesale_price    ?>   </button> </td>
            <td> <button type="button"  data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $wholesale_price ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
            <td>
                <button   type="button" class="btn readQrbtn position-relative" onclick="select_qr(1)" data-toggle="modal" data-target="#exampleModal_qr">
                    <i class="fa fa-qrcode"></i>
                </button>
            </td>
        </tr>
        <?php  }  ?>

       <?php if ($this->wcprice(2)) { ?>
        <?php $wholesale_price2 =   $this->price_dollarsAdmin($result['wholesale_price2']);    ?>
        <tr>
            <td> جملة الجملة</td>
            <td> <input id="number_item_2" style="width: 65px;text-align: center" type="number" value="1" class="form-control" min="1" >   </td>
            <td> <button type="button"  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button" class="btn btn-sm add_type_price"  id="price_device_2"  onclick="addToCartCover('<?php echo $result['id'] ?>',2)" >   <?php echo $wholesale_price2    ?>   </button> </td>
            <td> <button type="button"  data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $wholesale_price2 ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
            <td>
                <button   type="button" class="btn readQrbtn position-relative" onclick="select_qr(2)" data-toggle="modal" data-target="#exampleModal_qr">
                    <i class="fa fa-qrcode"></i>
                </button>
            </td>
        </tr>
        <?php  }  ?>
       <?php if ($this->wcprice(3)) { ?>
        <?php $cost_price =   $this->price_dollarsAdmin($result['cost_price']);    ?>
        <tr>
            <td>التكلفة</td>
            <td> <input id="number_item_3" style="width: 65px;text-align: center" type="number" value="1" class="form-control" min="1" >   </td>
            <td> <button type="button"  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button" class="btn btn-sm add_type_price"  id="price_device_3"  onclick="addToCartCover('<?php echo $result['id'] ?>',3)" >   <?php echo $cost_price    ?>   </button> </td>
            <td> <button type="button"  data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $cost_price ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
            <td>
                <button   type="button" class="btn readQrbtn position-relative" onclick="select_qr(3)" data-toggle="modal" data-target="#exampleModal_qr">
                    <i class="fa fa-qrcode"></i>
                </button>
            </td>
        </tr>
        <?php  }  ?>

    </tbody>
</table>


    <?php  } ?>


<?php } else {  ?>


    <div class="row_list_price">

        <span> <?php  echo $this->langControl('price_between') ?>  : </span>

        <?php

           $price_costom =   $this->price_dollars($result['price_dollars']);

        ?>

        <span id="price_device">
            <span style="padding-left:15px">  <?php echo  $price_costom ?>  د.ع   </span>
            <button type="button" data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $price_costom  ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button>
        </span>
        <button type="button" class="btn readQrbtn" onclick="select_qr()" data-toggle="modal" data-target="#exampleModal_qr">
            <i class="fa fa-qrcode"></i>
        </button>

    </div>




    <?php  if ($this->ch_wcprice() ) {  ?>

        <table class="table table-bordered table-striped table_wholesale_price mt-2">

            <tbody>

            <?php if ($this->wcprice(1)) { ?>
                <?php $wholesale_price =   $this->price_dollars($result['wholesale_price']);    ?>
                <tr>
                    <td>جملة</td>
                    <td> <input id="number_item_1" style="width: 65px;text-align: center" type="number" value="1" class="form-control" min="1" >   </td>
                    <td> <button type="button"  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button" class="btn btn-sm add_type_price"  id="price_device_1" onclick="addToCartCover('<?php echo $result['id'] ?>',1)" >   <?php echo $wholesale_price    ?>   </button> </td>
                    <td> <button type="button"  data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $wholesale_price ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                    <td>
                        <button   type="button" class="btn readQrbtn position-relative" onclick="select_qr(1)" data-toggle="modal" data-target="#exampleModal_qr">
                            <i class="fa fa-qrcode"></i>
                        </button>
                    </td>
                </tr>
            <?php  }  ?>

            <?php if ($this->wcprice(2)) { ?>
                <?php $wholesale_price2 =   $this->price_dollars($result['wholesale_price2']);    ?>
                <tr>
                    <td> جملة الجملة</td>
                    <td> <input id="number_item_2" style="width: 65px;text-align: center" type="number" value="1" class="form-control" min="1" >   </td>
                    <td> <button type="button"  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button" class="btn btn-sm add_type_price"  id="price_device_2"  onclick="addToCartCover('<?php echo $result['id'] ?>',2)" >   <?php echo $wholesale_price2    ?>   </button> </td>
                    <td> <button type="button"  data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $wholesale_price2 ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                    <td>
                        <button   type="button" class="btn readQrbtn position-relative" onclick="select_qr(2)" data-toggle="modal" data-target="#exampleModal_qr">
                            <i class="fa fa-qrcode"></i>
                        </button>
                    </td>
                </tr>
            <?php  }  ?>
            <?php if ($this->wcprice(3)) { ?>
                <?php $cost_price =   $this->price_dollars($result['cost_price']);    ?>
                <tr>
                    <td>التكلفة</td>
                    <td> <input id="number_item_3" style="width: 65px;text-align: center" type="number" value="1" class="form-control" min="1" >   </td>
                    <td> <button type="button"  data-toggle="tooltip" data-placement="top" title="اضف للسلة"  type="button" class="btn btn-sm add_type_price"  id="price_device_3"  onclick="addToCartCover('<?php echo $result['id'] ?>',3)" >   <?php echo $cost_price    ?>   </button> </td>
                    <td> <button type="button"  data-toggle="tooltip" data-placement="top" title="عرض سعر الدولار" onclick="get_dollar_price(this,'<?php echo $cost_price ?>')" class="btn icon_price_dollar"> <i class="fa fa-usd"></i> </button></td>
                    <td>
                        <button   type="button" class="btn readQrbtn position-relative" onclick="select_qr(3)" data-toggle="modal" data-target="#exampleModal_qr">
                            <i class="fa fa-qrcode"></i>
                        </button>
                    </td>
                </tr>
            <?php  }  ?>

            </tbody>
        </table>


    <?php  } ?>






<?php  } ?>
