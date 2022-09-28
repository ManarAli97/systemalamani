<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">صور</th>
        <th scope="col">اسم المادة</th>
        <th scope="col">الباركود</th>
        <th scope="col">الباركود البديل</th>
        <th scope="col">اللون</th>
        <th scope="col">الذاكرة</th>
        <th scope="col">كملة الواقع (السيريلات المدخلة) </th>
        <th scope="col">الكمية الحالية (كميات واسعار) </th>
        <th scope="col"> المواقع  </th>
        <th scope="col">  كمية المواقع  </th>


    </tr>
    </thead>
    <tbody>
    <tr>
       
        <td> <img width="100" src="<?php  echo  $this->save_file.$data['img']  ?>"> </td>
        <td><?php echo $data['title'] ?></td>
        <td><?php echo $data['code'] ?></td>
        <td><?php echo $data['spare_code'] ?></td>
        <td><?php echo $data['color'] ?></td>
        <td><?php echo $data['size'] ?></td>
        <td><?php echo $data['quantity_serial'] ?></td>
        <td><?php echo $data['quantity'] ?></td>
        <td>
            <?php   $sum=0; if ($data['location']) { ?>
                <table class="table">
                    <tr><td> الموقع  </td><td> الكمية </td></tr>

                    <?php  foreach ($data['location'] as $loct)  { ?>
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
     
    </tbody>
</table>