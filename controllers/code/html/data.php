<?php if (!empty($device))   { ?>


<input type="hidden" name="id"  id="id_device" value="<?php  echo $device[0]['id']?>">

<div class="title_table1">
    المتوفر في الموقع
</div>

<table class="table table-striped   table_style1">
    <thead>
    <tr>

        <th scope="col">القسم </th>
        <th scope="col">اسم الجهاز</th>
        <th scope="col">اللون</th>
        <th scope="col">اسم اللون</th>
        <th scope="col">سعر الدولار</th>
        <th scope="col">سعر بالدينار</th>
        <th scope="col">رينج السعر</th>
        <th scope="col"> المتوفر في الموقع</th>
        <th scope="col">    صورة  </th>
    </tr>
    </thead>
    <tbody>

<?php  foreach ($device as $dv)  { ?>
    <tr>
        <td><?php  echo $dv['category']?></td>
        <td><?php  echo $dv['name']?></td>
        <td> <div style="background: <?php  echo $dv['color']?>;width: 30px;height: 30px"  </td>
        <td id="name_color"><?php  echo $dv['name_color']?></td>
        <td><?php  echo $dv['price_dollars']?>  $ </td>
        <td><?php  echo $dv['price']?>  د.ع </td>
        <td><?php  echo $dv['r_price']?>  د.ع </td>
        <td  id="found_quantity" ><?php  echo $dv['quantity']?></td>
        <td > <img  style="width: 32px "  src="<?php  echo $dv['img']?>"> </td>
    </tr>


    <?php   }  ?>

    </tbody>
</table>




<div class="title_table2">
    المحجوزة في الموقع
</div>

<table class="table table-striped   table_style2">
    <thead>
    <tr>

        <th scope="col">القسم </th>
        <th scope="col">اسم الجهاز</th>
        <th scope="col">اللون</th>
        <th scope="col">اسم اللون</th>
        <th scope="col">سعر الدولار</th>
        <th scope="col">سعر بالدينار</th>
        <th scope="col">رينج السعر</th>
        <th scope="col">  المحجوزة في الموقع </th>
        <th scope="col">    صورة  </th>
    </tr>
    </thead>
    <tbody>

<?php  foreach ($device as $dv)  { ?>
    <tr>
        <td><?php  echo $dv['category']?></td>
        <td><?php  echo $dv['name']?></td>
        <td> <div style="background: <?php  echo $dv['color']?>;width: 30px;height: 30px"  </td>
        <td><?php  echo $dv['name_color']?></td>
        <td><?php  echo $dv['price_dollars']?>  $ </td>
        <td><?php  echo $dv['price']?>  د.ع </td>
        <td><?php  echo $dv['r_price']?>  د.ع </td>
        <td><?php  echo $dv['order']?></td>
        <td> <img  style="width: 32px "  src="<?php  echo $dv['img']?>"> </td>
    </tr>

    <?php   }  ?>

    </tbody>
</table>




<div class="title_table3">
يمكن اخذة من الموقع
</div>

<table class="table table-striped   table_style3">
    <thead>
    <tr>

        <th scope="col">القسم </th>
        <th scope="col">اسم الجهاز</th>
        <th scope="col">اللون</th>
        <th scope="col">اسم اللون</th>
        <th scope="col">سعر الدولار</th>
        <th scope="col">سعر بالدينار</th>
        <th scope="col">رينج السعر</th>
        <th scope="col"> يمكن اخذة من الموقع </th>
        <th scope="col">    صورة  </th>
    </tr>
    </thead>
    <tbody>

<?php  foreach ($device as $dv)  { ?>
    <tr>
        <td><?php  echo $dv['category']?></td>
        <td><?php  echo $dv['name']?></td>
        <td> <div style="background: <?php  echo $dv['color']?>;width: 30px;height: 30px"  </td>
        <td><?php  echo $dv['name_color']?></td>
        <td><?php  echo $dv['price_dollars']?>  $ </td>
        <td><?php  echo $dv['price']?>  د.ع </td>
        <td><?php  echo $dv['r_price']?>  د.ع </td>
        <td id="can_get"><?php  echo $dv['quantity']  ?></td>
        <td> <img  style="width: 32px "  src="<?php  echo $dv['img']?>"> </td>
    </tr>

    <?php   }  ?>

    </tbody>
</table>



<?php   }  else {  ?>

    <div class="alert alert-success" role="alert">
    حسناً لا يوجد شي ! هل تأكدت من تحديد القسم ؟
    </div>

<?php   }  ?>






