<?php if (!empty($device))   { ?>
    <?php  foreach ($device as $dv)  { ?>
    <tr  class="remove_row_<?php  echo $dv['id'].'_'.$dv['code']  ?>" >
        <td><?php  echo $dv['name']?></td>
        <td> <div style="background: <?php  echo $dv['color']?>;width: 30px;height: 30px"  </td>
        <td><?php  echo $dv['name_color']?></td>
        <td><?php  echo $dv['price']?>  د.ع </td>
        <td><?php  echo $dv['size']?>  </td>
        <td id="can_get"><?php  echo $dv['quantity']  ?></td>
        <td> <img  style="width: 32px "  src="<?php  echo $dv['img']?>"> </td>
        <td>  <input type="number" name="count[]" class="form-control" max="<?php  echo $dv['quantity']  ?>"  style=" width: 68px; text-align: center" value="1"></td>
        <td> <button class="btn btn-danger " type="button"  onclick="$('.remove_row_<?php  echo  $dv['id'].'_'.$dv['code'] ?>').remove()"   ><i class="fa fa-times"></i> </button> </td>

        <td style="width: 0;overflow:hidden;">


            <input type="hidden" name="id_device[]"    value="<?php  echo $dv['id']?>">
            <input type="hidden" name="image[]"   value="<?php  echo $dv['image']?>">
            <input type="hidden" name="name_color[]"   value="<?php  echo $dv['name_color']?>">
            <input type="hidden" name="code_color[]"   value="<?php  echo $dv['color']?>">
            <input type="hidden" name="size[]"   value="<?php  echo $dv['size']?>">
            <input type="hidden" name="code[]"   value="<?php  echo $dv['code']?>">
            <input type="hidden" name="cat[]"   value="<?php  echo $dv['cat']?>">
            <input type="hidden" name="found[]"   value="<?php  echo $dv['quantity']  -  $dv['order']  ?>">

        </td>

    </tr>

    <?php   }  ?>

<?php   }  ?>