


<?php  if (!empty($data)) {  ?>
	<table id="table_data" class="table table-bordered  table-striped">
		<thead>
		<tr>
			<th scope="col">القسم</th>
			<th scope="col">اسم المادة</th>
			<th scope="col">صورة المادة</th>
			<th scope="col">رمز المادة</th>
			<th scope="col">المواقع التي سحبت منها</th>
			<th scope="col">المواقع المسموح انتقل الها </th>
			<th scope="col"> الكمية الغير منقولة </th>
            <th scope="col"> السيريلات المقترحة </th>
            <th scope="col"> السيريلات </th>
			<th scope="col"> المواقع الجديدة </th>
			<th scope="col"> الكمية المنقولة للمواقع الجديدة </th>
			<th scope="col">  ملاحظة </th>
			<th scope="col"> حذف </th>

		</tr>
		</thead>
		<tbody>
		<?php foreach ($data as $ta)  { ?>
			<tr id="row_db_<?php echo $ta['id'] ?>">
				<td> <?php echo $this->langControl($ta['model'] )  ?> </td>
				<td> <?php echo $ta['title'] ?> </td>
				<td> <img style="width: 40px" src="<?php echo $this->save_file.$ta['image'] ?>"> </td>
				<td  onclick='copy_text(this)' class='copyToClipboard' title='نسخ' data-clipboard-text="<?php echo strip_tags($ta['code']) ?>"    > <?php echo $ta['code'] ?> </td>
				<td> <?php echo    $this->tamayaz_locations($ta['location']) ?> </td>
				<td>

                    <table style="background: #ffffff">
                        <tr>
                            <td style='padding: 0;border: 1px solid;    vertical-align: unset '>  الموقع </td>
                            <td style='padding: 0;  border: 1px solid;    vertical-align: unset'> الكمية  </td>

                        </tr>
                        <?php  foreach ($ta['all_location'] as $locationcode) {  ?>
                            <tr style="padding: 0;background: #ffffff">
                                <td  onclick='copy_text(this)' class='copyToClipboard' title='نسخ' data-clipboard-text="<?php echo strip_tags($locationcode['location']) ?>"   style="padding: 0;border: 1px solid;background: #ffffff"><?php echo $locationcode['location'] ?></td>
                                <td  onclick='copy_text(this)' class='copyToClipboard' title='نسخ' data-clipboard-text="<?php echo strip_tags($locationcode['quantity']) ?>"   style="padding:0 5px;border: 1px solid;background: #ffffff"><?php echo $locationcode['quantity'] ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                    
                </td>
				<td class="qcheck <?php  if ($ta['quantity'] != 0) echo 'qfound'?> " >   <?php echo $ta['quantity'] ?> </td>
                <td>
                    <div class="number_serial_<?php echo $ta['code']  ?>"> <span> <?php echo $ta['quantity']+ $ta['toquantity']  ?> </span></div>

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

                <td>


						<table class='table table-bordered' style='background: #fff;margin: 0;padding: 0'><tbody>
                            <tr>
                            <td style='padding: 0;    vertical-align: unset;background: #add'> م  </td>
                            <td style='padding: 0;    vertical-align: unset;background: #fea'> ك  </td>
                            <td style='padding: 0;    vertical-align: unset;background: #af0c1e'>  <i class="fa fa-times"></i>  </td>
                            </tr>
                            <?php  foreach ($ta['tolocation'] as $tol) {   ?>

							<tr>
								<td style='padding: 0;    vertical-align: unset;'>   <?php echo  $this->tamayaz_locations($tol['location'])  ?>   </td>
                                <td style='padding: 0;    vertical-align: unset;'>   <?php echo $tol['quantity'] ?>   </td>
                                <td style='padding: 0;    vertical-align: unset'>   <button  onclick="remove_location_convert(<?php echo $tol['id'] ?>,<?php echo $transport?>)" style="color: red;padding: 0;margin: 0" class="btn"><i class="fa fa-times"></i> </button>   </td>
							</tr>
		                   <?php  } ?>
							</tbody></table>


				</td>
				<td> <?php echo $ta['toquantity'] ?> </td>
                <td> <textarea class="form-control" onkeyup="enter_note(this,'<?php echo $ta['id'] ?>','<?php echo $ta['model'] ?>')"><?php echo $ta['note'] ?></textarea> </td>
                <td>  <button  class="btn btn-danger" type="button" onclick="delete_all_row_loc(<?php echo $ta['id'] ?>,<?php echo $transport ?>)"><i class="fa fa-times"></i> </button> </td>

			</tr>
		<?php } ?>
		</tbody>
	</table>
	<hr>
	<div class="text-center">
		<button  class="btn btn-primary confirm_t " type="submit"  >   تأكيد المناقلة   </button>
	</div>
<?php  }  ?>
