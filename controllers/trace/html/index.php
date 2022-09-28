
<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item active" aria-current="page" > <a href="<?php  echo url .'/'.$this->folder ?>/list_trace"> <?php  echo $this->langControl('trace')?> </a> </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('details') ?>  </li>
            </ol>
        </nav>

    </div>
</div>


<br>


<div class="row">
    <div class="col">

        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th>اسم الادمن</th>
                <th>  رقم الفاتورة  </th>
                <th>  الجدول </th>
                <th>  العملية </th>
                <th>  الملاحظة </th>
                <th>  التاريخ </th>


            </tr>
            </thead>
            <tbody>
            <tr>
                <td>  <?php echo $result['userName'] ?>  </td>
                <td>  <?php echo $result['number_bill'] ?>  </td>
                <td>  <?php echo $result['table'] ?>  </td>
                <td>  <?php echo $result['operation'] ?>  </td>
                <td>  <?php echo  $result['note'] ?>  </td>
                <td>  <?php echo $result['createDate'] ?>  </td>

            </tr>
            </tbody>

        </table>

    </div>
</div>


<hr>


<?php  if (!empty($oldData)) { ?>

<div class="alert alert-warning" role="alert">
    البيانات القديمة
</div>
<div class="overflow-auto">
<table class="table table-striped">
    <thead>
    <tr>
    <?php  foreach ($oldData as $key => $k) {  ?>
      <?php  foreach ($k as $x=>$d) {   ?>
        <th scope="col"> <?php  echo $this->langControl($x) ?> </th>
       <?php  }   ?>
     <?php break; }    ?>
    </tr>
    </thead>

    <tbody>
    <?php  foreach ($oldData as $key => $k) {  ?>
    <tr>

    <?php  foreach ($k as $x=>$d) {   ?>
        <td><?php  echo $this->ifNameImage($d,$x) ?> </td>
    <?php  }  ?>

    </tr>
    <?php  }  ?>
    </tbody>

</table>

</div>

<br>
<hr>
<?php  }  ?>

<?php  if (!empty($newData)) { ?>

<div class="alert alert-primary" role="alert">
    البيانات الحديثة
</div>
<div class="overflow-auto">
<table class="table table-striped">
    <thead>
    <tr>
    <?php  foreach ($newData as $key => $k) {  ?>
      <?php  foreach ($k as $x=>$d) {   ?>
        <th scope="col"> <?php  echo $this->langControl($x) ?> </th>
       <?php  }   ?>
     <?php break; }    ?>
    </tr>
    </thead>

    <tbody>
    <?php  foreach ($newData as $key => $k) {  ?>
    <tr>

    <?php  foreach ($k as $x=>$d) {   ?>
        <td><?php  echo $this->ifNameImage($d,$x) ?> </td>
    <?php  }  ?>

    </tr>
    <?php  }  ?>
    </tbody>

</table>

</div>
<?php  }  ?>