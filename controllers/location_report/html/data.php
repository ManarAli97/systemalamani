<table class="table table-bordered  table-striped">
	<thead>
	<tr>

		<th scope="col">القسم</th>
		<th scope="col">الموقع</th>
		<th scope="col">الكود</th>
		<th scope="col">اللون</th>
		<th scope="col">الكمية</th>
        <th scope="col">السيريلات المقترحة</th>
        <th scope="col">السيريلات </th>
		<th scope="col">ملاخظة</th>
		<th scope="col">حذف</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($data as $ta)  { ?>
	<tr id="row_db_<?php echo $ta['id'] ?>">
		<td> <?php echo $ta['model'] ?> </td>
		<td> <?php echo $ta['location'] ?> </td>
		<td> <?php echo $ta['code'] ?> </td>
		<td> <?php echo $ta['color'] ?> </td>
		<td> <?php echo $ta['quantity'] ?> </td>

        <td>

            <?php  if ($ta['listSerial']) {  ?>
                <?php  foreach ($ta['listSerial'] as $key => $serial) { ?>
                    <span class="badge badge-success d-block mb-1">  <?php echo $serial ?></span>
                <?php } ?>
            <?php } ?>
        </td>
        <td>

            <?php  if ($ta['listSerial']) {  ?>
                <?php  foreach ($ta['listSerial'] as $key => $serial) { ?>
                    <input onblur="checkSerialCode(this,'<?php echo  $ta['code'] ?>','<?php echo $ta['model'] ?>')" type="text" name="serial_<?php echo $ta['code'] ?>[]"  autocomplete="off" placeholder="سيريال - <?php  echo $key+1 ?> " class="form-control mb-1"  <?php echo $ta['serial_req'] ?> >
                <?php } ?>
            <?php } ?>


        </td>

        <td> <textarea class="form-control" onkeyup="enter_note(this,'<?php echo $ta['id'] ?>','<?php echo $ta['model'] ?>')"><?php echo $ta['note'] ?></textarea> </td>
        <td>  <button  class="btn btn-danger" type="button" onclick="delete_row_loc(<?php echo $ta['id'] ?>)"><i class="fa fa-times"></i> </button> </td>
	</tr>
 <?php } ?>
	</tbody>
</table>
<hr>
<div class="text-center">
    <button  class="btn btn-primary" type="submit"  >حفظ   </button>
</div>