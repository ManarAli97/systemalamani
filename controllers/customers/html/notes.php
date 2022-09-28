<?php if ($notes) { ?>

<table class="table table-bordered">

    <thead>
    <tr>
        <th>اسم الزبون</th>
        <th>الملاحظة</th>
        <th>اسم الموظف الذي  كتب الملاحظة</th>
        <th>االتاريخ</th>

    </tr>
    </thead>
    <tbody>

    <?php foreach ($notes as $note) {   ?>
    <tr>
        <td><?php  echo $note['name_customer'] ?></td>
        <td><?php  echo $note['note'] ?></td>
        <td><?php  echo $note['username'] ?></td>
        <td><?php  echo date('Y-m-d h:i:s a',$note['date']) ?></td>
    </tr>
    <?php  } ?>
    </tbody>

</table>

<?php } else {  ?>
    <div class="alert alert-warning" role="alert">
      لا توجد ملاحظات حول هذا الزبون
    </div>


<?php } ?>
