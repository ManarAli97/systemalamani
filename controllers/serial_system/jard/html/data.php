<input type="hidden" id="getModel" value="<?php echo $model  ?>">
<input  type="hidden" id="getid_catg" value="<?php echo $id_catg  ?>">

<table class="table table-bordered">
    <thead>
    <tr>

        <th scope="col">صور</th>
        <th scope="col">اسم المادة</th>
        <th scope="col">الباركود</th>
        <th scope="col">الباركود البديل</th>
        <th scope="col">اللون</th>
        <th scope="col">الذاكرة</th>
        <th scope="col">الكمية الحالية (كميات واسعار) </th>
        <th scope="col">مواد بانتظار تأكيد مواقعها</th>
        <th scope="col">كملة الواقع (السيريلات المدخلة) </th>

        <th scope="col"> المواقع  </th>
        <th scope="col">  كمية المواقع  </th>


    </tr>
    </thead>
    <tbody>

  <?php  foreach ($data as $outDate) {  ?>
    <tr>


        <td> <img width="100" src="<?php  echo  $this->save_file.$outDate['img']  ?>"> </td>
        <td><?php echo $outDate['title'] ?></td>
        <td><?php echo $outDate['code'] ?></td>
        <td><?php echo $outDate['spare_code'] ?></td>
        <td><?php echo $outDate['color'] ?></td>
        <td><?php echo $outDate['size'] ?></td>
        <td><?php echo $outDate['quantity'] ?></td>
        <td><?php echo $outDate['location_conform'] ?></td>
        <td><?php echo $outDate['quantity_serial'] ?></td>

        <td>
            <?php   $sum=0; if ($outDate['location']) { ?>
                <table class="table">
                    <tr><td> الموقع  </td><td> الكمية </td></tr>

                    <?php  foreach ($outDate['location'] as $loct)  { ?>
                        <tr><td> <?php  echo $loct['location']?> </td><td> <?php  echo $loct['quantity']?> </td></tr>
                        <?php    $sum =$sum + $loct['quantity']?>
                    <?php } ?>

                </table>
            <?php } else {  ?>

                لا توجد مواقع
            <?php  } ?>
        </td>
        <td><?php echo $sum ?></td>
    </tr>
     <?php } ?>
    </tbody>
</table>