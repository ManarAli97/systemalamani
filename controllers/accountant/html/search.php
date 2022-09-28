

<?php if (!empty($data)) {  ?>

<div class="row">
	<?php  foreach ($data as $result )  { ?>
		<div class="col-12 " >
			<a style="position: relative" class="infoCustomer ifactive <?php  if ($result['direct'] ==3)echo 'direct_bill' ?>  " id="row<?php echo $result['number_bill'] ?>" href="#" onclick="getOrder(<?php  echo $result['id_member_r']  ?>,'<?php  echo $result['number_bill']  ?>')">
				<div><?php echo $result['name'] ?> (<?php echo $result['number_bill'] ?>)  </div>
				<div  style="direction: ltr;">

					<?php  if ($this->permit('number_phone_show',$this->folder)) {  ?>
						<?php echo  $result['phone'] ?>
					<?php }else{ ?>
						<?php echo substr($result['phone'], 0, 3) . "*****" . substr($result['phone'], 8) ?>
					<?php  }  ?>

				</div>

				<?php  if ($result['top']==1) {  ?>
					<i style="position: absolute;top: 20px;left: 5px; color: red;" class="fa fa-star"></i>
				<?php  } ?>
				<?php  if ($result['direct']==3) {  ?>
					<div class="direct_user_name">المحاسب الثانوي:<?php echo $result['user_direct'] ?></div>
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
<?php  } else { ?>

	<span class="no_thing"> لا يوجد شي </span>
<?php  }  ?>