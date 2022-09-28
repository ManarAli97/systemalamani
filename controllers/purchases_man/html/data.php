<?php if (!empty($device))   { ?>




<table class="table table-striped   table_style1">
    <thead>
    <tr>

        <th scope="col">القسم </th>
        <th scope="col">اسم الجهاز</th>
        <th scope="col">اللون</th>
        <th scope="col">اسم اللون</th>
        <th scope="col">السعر</th>
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
        <td><?php  echo $dv['price']?>  د.ع </td>
        <td  id="found_quantity" ><?php  echo $dv['quantity']?></td>
        <td > <img  style="width: 32px "  src="<?php  echo $dv['img']?>"> </td>
    </tr>


    <?php   }  ?>

    </tbody>
</table>

<hr>
    <div class="row justify-content-center">
        <div class="col-auto">
            <a class="btn btn-info" href="<?php  echo url .'/'.$this->folder?>/add/<?php  echo $dv['id'] .'/'.$cat ?>"    > <i class="fa fa-share"></i>  <span> تحويل المنتج الى قائمة النواقص</span>  </a>
        </div>
    </div>

<?php   }  else {  ?>

    <div class="alert alert-success" role="alert">
    حسناً لا يوجد شي ! هل تأكدت من تحديد القسم ؟
    </div>

<?php   }  ?>






