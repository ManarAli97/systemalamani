

<?php if (!empty($data)) {  ?>

<div class="row">
	<?php  foreach ($data as $result )  { ?>

        <div class="col-12 " >
            <a class="active_order_by_qr infoCustomer ifactive  <?php  if ($result['accountant'] ==1)echo 'direct_bill' ?>  " id="row<?php echo $result['number_bill'] ?>" href="#" onclick="getOrder(<?php  echo $result['id']  ?>,'<?php  echo $result['number_bill']  ?>')">
                <div><?php echo $result['name'] ?>  (<?php  echo $result['number_bill']  ?>) </div>
                <div   style="direction: ltr;">

					<?php  if ($this->permit('number_phone_show',$this->folder)) {  ?>
						<?php echo  $result['phone'] ?>
					<?php }else{ ?>
						<?php echo substr($result['phone'], 0, 3) . "*****" . substr($result['phone'], 8) ?>
					<?php  }  ?>

                </div>

				<?php  if ($result['accountant']==1) {  ?>
                    <div class="direct_user_name"> تمت المحاسبه من قبل المحاسب :<?php echo $result['id_accountant_user'] ?></div>
				<?php  } ?>

                <table style="margin: 0" class="table table-dark table-bordered">
                    <tbody>
                    <tr>
                        <td style="padding: 0"><?php echo  $result['sumbill'] ?> د.ع </td>
                        <td style="padding: 0"><?php echo  $result['date_order'] ?></td>
                    </tr>

                    </tbody>
                </table>

            </a>
        </div>
	<?php  }  ?>
</div>
<?php  }   ?>
