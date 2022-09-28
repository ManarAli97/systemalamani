<?php if (!empty($data))  { ?>
<br>
<table class="table table-bordered">
    <thead>
    <tr>

        <th scope="col">الصورة</th>
        <th scope="col">الباركود</th>
        <th scope="col"> الكمية الكلية </th>
        <th scope="col">    الموقع  </th>
        <th scope="col">     كمية الموقع  </th>
    </tr>
    </thead>
    <tbody>
  <?php  foreach ($data as $dt) {  ?>
    <tr>

        <td><img width="50" src="<?php  echo $dt['image'] ?>"></td>
        <td><?php  echo $dt['code'] ?></td>
        <td><?php  echo $dt['quantity'] ?></td>
        <td><?php  echo $dt['location'] ?></td>
        <td><?php  echo $dt['locq'] ?></td>

    </tr>
<?php  }  ?>
    </tbody>

    <?php } ?>