
<?php  foreach ($car as $shop) { ?>
    <div class="row item_row delete_item_row_<?php  echo $shop['id'] ?>" id="item_row_<?php  echo $shop['id'] ?>">

        <div class="col-auto" style="padding-right: 0;padding-left: 0;">
            <button onclick="delete_item_row(<?php  echo $shop['id_item'] ?>,<?php  echo $shop['id'] ?>)" class="btn delete_item_row" type="button"> <i class="fa fa-times"></i> </button>
        </div>

        <div class="col-auto" style="padding-right: 0;padding-left: 0;">
            <img class="image_item"   src="<?php  echo $shop['img'] ?>">
        </div>
        <div class="col">
            <div class="size_item">
                <span> <?php  echo $shop['title'] ?>  </span> &nbsp;    <input class="number_item_buy number_item_buy_<?php  echo $shop['id'] ?>" id="count_buy_<?php  echo $shop['id'] ?>" type="text"  value="<?php  echo $shop['number'] ?>" readonly>
            </div>

            <div class="price_row" id="price_sum_car_<?php  echo $shop['id'] ?>">
                <?php  echo $shop['price'] ?>       <?php  if(!empty($shop['size'])) echo "(".$shop['size'].")"; else  $shop['size'] ?>
            </div>
			<?php  if ($shop['q_0']) {  ?>
                <div class="q_0">
                    نفذت الكمية
                </div>
			<?php } ?>
        </div>

    </div>




<?php  }  ?>

<div class="sum_all_price_cart">
    <span>        مجموع الفاتورة بين :</span> <span> <?php  echo $price1 ?>  </span>
</div>
