

		<?php  if (!empty($data))  { ?>
			
				<td> <?php echo $this->langControl($data['model'] )  ?> </td>
				<td> <?php echo $data['title'] ?> </td>
				<td> <img style="width: 40px" src="<?php echo $this->save_file.$data['image'] ?>"> </td>
				<td  onclick='copy_text(this)' class='copyToClipboard' title='نسخ' data-clipboard-text="<?php echo strip_tags($data['code']) ?>"    > <?php echo $data['code'] ?> </td>
				<td> <?php echo    $this->tamayaz_locations($data['location']) ?> </td>
				<td>

                    <table style="background: #ffffff">
                        <tr>
                            <td style='padding: 0;border: 1px solid;    vertical-align: unset '>  الموقع </td>
                            <td style='padding: 0;  border: 1px solid;    vertical-align: unset'> الكمية  </td>

                        </tr>
                        <?php  foreach ($data['all_location'] as $locationcode) {  ?>
                            <tr style="padding: 0;background: #ffffff">
                                <td  onclick='copy_text(this)' class='copyToClipboard' title='نسخ' data-clipboard-text="<?php echo strip_tags($locationcode['location']) ?>"   style="padding: 0;border: 1px solid;background: #ffffff"><?php echo $locationcode['location'] ?></td>
                                <td  onclick='copy_text(this)' class='copyToClipboard' title='نسخ' data-clipboard-text="<?php echo strip_tags($locationcode['quantity']) ?>"   style="padding:0 5px;border: 1px solid;background: #ffffff"><?php echo $locationcode['quantity'] ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                    
                </td>
				<td class="qcheck <?php  if ($data['quantity'] != 0) echo 'qfound'?> " >   <?php echo $data['quantity'] ?> </td>
                <td>
                    <div class="number_serial_<?php echo $data['code']  ?>"> <span> <?php echo $data['quantity']+ $data['toquantity']  ?> </span></div>

                    <?php  if ($data['listSerial']) {  ?>
                        <?php  foreach ($data['listSerial'] as $key => $serial) { ?>
                            <span class="badge badge-success d-block mb-1">  <?php echo $serial ?></span>
                        <?php } ?>
                    <?php } ?>

                </td>
                <td>

                    <?php  if ($data['listSerial']) {  ?>
                        <?php  foreach ($data['listSerial'] as $key => $serial) { ?>
                            <input onblur="checkSerialCode(this,'<?php echo  $data['code'] ?>','<?php echo $data['model'] ?>')" type="text" name="serial_<?php echo $data['code'] ?>[]"  autocomplete="off" placeholder="سيريال - <?php  echo $key+1 ?> " class="form-control mb-1"  <?php echo $data['serial_req'] ?> >
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
                            <?php  foreach ($data['tolocation'] as $tol) {   ?>

							<tr>
								<td style='padding: 0;    vertical-align: unset;'>   <?php echo  $this->tamayaz_locations($tol['location'])  ?>   </td>
                                <td style='padding: 0;    vertical-align: unset;'>   <?php echo $tol['quantity'] ?>   </td>
                                <td style='padding: 0;    vertical-align: unset'>   <button  onclick="remove_location_convert(<?php echo $tol['id'] ?>,<?php echo $transport?>)" style="color: red;padding: 0;margin: 0" class="btn"><i class="fa fa-times"></i> </button>   </td>
							</tr>
		                   <?php  } ?>
							</tbody></table>


				</td>
				<td> <?php echo $data['toquantity'] ?> </td>
                <td> <textarea class="form-control" onkeyup="enter_note(this,'<?php echo $data['id'] ?>','<?php echo $data['model'] ?>')"><?php echo $data['note'] ?></textarea> </td>
                <td>  <button  class="btn btn-danger" type="button" onclick="delete_all_row_loc(<?php echo $data['id'] ?>,<?php echo $transport ?>)"><i class="fa fa-times"></i> </button> </td>

			
		<?php } ?>
		
