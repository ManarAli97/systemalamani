<?php  foreach ($result['color'] as $color ) { ?>
	<?php  if (!empty($color['code'])) {  ?>
<?php foreach ($color['code'] as $code) {   ?>
<tr  class="found_row remove_<?php  echo $code['code'] ?>">
	<td>  <img width="150" src="<?php  echo $color['image'] ?>"> </td>
	<td> <input autocomplete="off"  type="hidden" style="width: 40px" name="id_mobile[<?php  echo $result['id'] ?>]" value="<?php  echo $result['id'] ?>" >   <?php  echo $result['title'] ?></td>
	<td >   <?php echo $color['color'] ?>  </td>

	<td >

        <input autocomplete="off"  type="hidden"  value="<?php echo $model ?>" name="model_<?php  echo $result['id'] ?>[]">
        <input autocomplete="off"  type="hidden" value="<?php echo $color['id'] ?>" name="id_color_<?php  echo $result['id'] ?>[]">
        <input autocomplete="off"  type="hidden" value="<?php echo $code['code'] ?>" name="code_<?php  echo $result['id'] ?>[]">
        <?php echo $code['code'] ?>  </td>
	<td >   <?php echo $code['quantity'] ?>  </td>
	<td >
        <?php echo $code['price'] ?>

        <table class="table table-bordered table_prich_x">
            <tr>
                <td>الجملة</td>
                <td><?php echo $code['wholesale_priced'] ?></td>
            </tr>

            <tr>
                <td>جملة الجملة</td>
                <td><?php echo $code['wholesale_price2d'] ?></td>
            </tr>

            <tr>
                <td>التكلفة</td>
                <td><?php echo $code['cost_priced'] ?></td>
            </tr>

        </table>

    </td>


	<td >   <?php echo $code['price_dollars'] ?>

        <table class="table table-bordered table_prich_x">
            <tr>
                <td>الجملة</td>
                <td><?php echo $code['wholesale_price'] ?></td>
            </tr>

            <tr>
                <td>جملة الجملة</td>
                <td><?php echo $code['wholesale_price2'] ?></td>
            </tr>

            <tr>
                <td>التكلفة</td>
                <td><?php echo $code['cost_price'] ?></td>
            </tr>

        </table>
    </td>


	<td>  <input autocomplete="off"   required type="text"  <?php  if ($result['enter_serial'] == 1)  { ?>  onkeyup="number_serial(this,<?php  echo $code['code'] ?>)" <?php  } ?>  min="0" max="100"  name="quantity_<?php  echo $result['id'] ?>[]" class="form-control" >   </td>
	<td  class="sale_quantity_<?php  echo $code['code'] ?>" >

    <input autocomplete="off" name="serial_<?php  echo $code['code'] ?>[]" value="" class="form-control" placeholder="سيريال" readonly>
    </td>
	<td>


		<div class="input-group mb-2">

			<input autocomplete="off"  type="text" onkeyup="add_comma(this)" name="price_purchase_<?php  echo $result['id'] ?>[]" class="form-control" required>
			<div class="input-group-prepend">
				<div class="input-group-text">د.ع</div>
			</div>
		</div>


	</td>
	<td>  <textarea autocomplete="off" rows="1" type="text"  name="note_<?php  echo $result['id'] ?>[]" class="form-control" ></textarea>   </td>
	<td>


		<div class="input-group mb-2">
			<input  autocomplete="off"  type="text"   name="price_sale_<?php  echo $result['id'] ?>[]" class="form-control" required>
		</div>

		<div class="input-group mb-2">
            <input  autocomplete="off"  type="text"   name="wholesale_price_<?php  echo $result['id'] ?>[]" class="form-control"  >
		</div>

		<div class="input-group mb-2">
            <input  autocomplete="off"  type="text"   name="wholesale_price2_<?php  echo $result['id'] ?>[]" class="form-control"  >
        </div>

		<div class="input-group mb-2">
            <input  autocomplete="off"  type="text"   name="cost_price_<?php  echo $result['id'] ?>[]" class="form-control"  >
        </div>

	</td>
    <td style="position: relative">   <input  autocomplete="off"  onblur="check_location_model('<?php echo $model ?>','<?php echo $code['code'] ?>')" id="<?php echo $model ?>_<?php echo $code['code'] ?>"  <?php  if (!in_array($model,array('mobile','computer','games'))) echo 'required' ?>   oninput="get_location_model('<?php echo $model ?>','<?php echo $code['code'] ?>')" type="text" class="form-control location_get"  name="location_<?php  echo $result['id'] ?>[]" >
    <div class="list_location <?php echo $model ?>_<?php echo $code['code'] ?>  "></div>

    </td>
    <td >   <?php echo $code['store'] ?>  </td>
	<td>  <button type="button" class="btn btn-danger" onclick="$('.remove_<?php  echo $code['code'] ?>').remove();check_data()"> <i class="fa fa-times"></i>  </button> </td>

</tr>
<?php  } ?>
<?php  } ?>
<?php  } ?>