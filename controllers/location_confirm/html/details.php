<?php if (!empty($data))  { ?>
<br>
<table class="table table-bordered det-t">
    <thead>
    <tr>

        <th scope="col">الصورة</th>
        <th scope="col">الباركود</th>
      
          <th scope="col"> الكمية الكلية
              <?php    if ($this->permit('convert_quantity_from_excel_conform',$this->folder)) { ?>
            <div class="convert_quantity">
                <button class="btn"   onclick="convert_quantity_from_excel_conform()"  ><span>تحويل  الكمية</span>  <i class="fa fa-arrow-left"></i> </button>
            </div>
            <?php  } ?>
        </th>
    
        <th scope="col">    كمية غير منقولة او غير مؤكدة </th>
        <th scope="col">    الموقع  </th>
        <th scope="col">     كمية الموقع  </th>

    </tr>
    </thead>
    <tbody>
  <?php  foreach ($data as $key => $dt) {  ?>
    <tr>

        <td><img width="150" src="<?php  echo $dt['image'] ?>"></td>
        <td><?php  echo $dt['code'] ?></td>
        <?php  if ($key == 0 ) {?>
        <td  rowspan="<?php echo count($data) ?>" ><?php  echo $dt['quantity'] ?></td>
        <td   rowspan="<?php echo count($data) ?>"  ><?php  echo $dt['qNotConvert'] ?></td>
        <?php } ?>
        <td><?php  echo $dt['location'] ?></td>
        <td><?php  echo $dt['locq'] ?></td>

    </tr>
<?php  }  ?>
    </tbody>

    <?php } ?>

    <style>


       .det-t td {
            text-align: center;
            vertical-align: middle;
        }


        .convert_quantity
        {
            border-top: 1px solid #bbbbbb;
            padding-top: 5px;
        }
        .convert_quantity .btn
        {
            padding: 0 4px;
            background: #009688;
            color: #fff;
        }
    </style>





