<?php  foreach ($result['color'] as $color ) { ?>
	<?php  if (!empty($color['code'])) {  ?>
<?php foreach ($color['code'] as $code) {   ?>
<tr class="remove_<?php  echo $code['code'] ?>">
	<td>  <img width="40" src="<?php  echo $color['image'] ?>"> </td>
	<td>  <?php  echo $result['title'] ?></td>
	<td >   <?php echo $color['color'] ?>  </td>
	<td >
        <?php echo $code['code'] ?>
    </td>
	<td >   <?php echo $code['quantity'] ?>  </td>
	<td >   <?php echo $code['price'] ?> </td>
	<td >   <?php echo $code['price_dollars'] ?>  </td>

  	<td>

        <input style="    min-width: 85px;" type="number" autocomplete="off" min="1" max="<?php echo $code['quantity'] ?>" name="count[]" value="" class="form-control" placeholder="الكمية" required>

        <input autocomplete="off"  type="hidden"  style="width: 40px" name="id_device[]" value="<?php  echo $result['id'] ?>" >
        <input autocomplete="off"  type="hidden"  value="<?php echo $color['table'] ?>" name="cat[]">
        <input autocomplete="off"  type="hidden"  value="<?php echo $color['img'] ?>" name="image[]">
        <input autocomplete="off"  type="hidden"  value="<?php echo $color['color'] ?>" name="name_color[]">
        <input autocomplete="off"   type="hidden" value="<?php echo $color['code_color'] ?>" name="code_color[]">
        <input autocomplete="off"  type="hidden" value="<?php echo $code['code'] ?>" name="code[]">
        <input autocomplete="off"  type="hidden" value="<?php echo $code['size'] ?>" name="size[]">
        <input autocomplete="off"  type="hidden" value="<?php echo $code['quantity'] ?>" name="found[]">

    </td>


	<td>  <button type="button" class="btn btn-danger" onclick="$('.remove_<?php  echo $code['code'] ?>').remove();check_data()"> <i class="fa fa-times"></i>  </button> </td>

</tr>
<?php  } ?>
<?php  } ?>
<?php  } ?>