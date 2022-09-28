<?php if (!empty($device))   { ?>


<input type="hidden" name="id_device"  id="id_device" value="<?php  echo $device[0]['id']?>">
<input type="hidden" name="image"   value="<?php  echo $device[0]['image']?>">
<input type="hidden" name="name_color"   value="<?php  echo $device[0]['name_color']?>">
<input type="hidden" name="code_color"   value="<?php  echo $device[0]['color']?>">
<input type="hidden" name="size"   value="<?php  echo $device[0]['size']?>">
<input type="hidden" name="found"   value="<?php  echo $device[0]['quantity']  -  $device[0]['order']  ?>">




<table class="table table-striped   table_style3">
    <thead>
    <tr>

        <th scope="col">اسم الجهاز</th>
        <th scope="col">اللون</th>
        <th scope="col">اسم اللون</th>
        <th scope="col">السعر</th>
        <th scope="col">حجم الذاكرة</th>
        <th scope="col">المتوفر </th>
        <th scope="col">    صورة  </th>
        <th scope="col">    الكمية  </th>
        <th scope="col">    اضافة  </th>
    </tr>
    </thead>
    <tbody>

<?php  foreach ($device as $dv)  { ?>
    <tr>
        <td><?php  echo $dv['name']?></td>
        <td> <div style="background: <?php  echo $dv['color']?>;width: 30px;height: 30px"  </td>
        <td><?php  echo $dv['name_color']?></td>
        <td><?php  echo $dv['price']?>  د.ع </td>
        <td><?php  echo $dv['size']?>  </td>
        <td id="can_get"><?php  echo $dv['quantity']  ?></td>
        <td> <img  style="width: 32px "  src="<?php  echo $dv['img']?>"> </td>
        <td>  <input type="text" name="count" class="form-control"  style=" width: 43px; text-align: center" value="1">   </td>
        <td> <button class="btn btn-warning add_to_order " type="submit" name="submit"><i class="fa fa-plus"></i> </button> </td>
    </tr>

    <?php   }  ?>

    </tbody>
</table>



<?php   }  else {  ?>

    <div class="alert alert-success" role="alert">
    حسناً لا يوجد شي ! هل تأكدت من تحديد القسم ؟
    </div>

<?php   }  ?>






