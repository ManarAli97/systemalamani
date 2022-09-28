

	<div class="content_search">

		<?php  foreach ($data as $sch) {  ?>

			<button type="button" value="<?php echo $sch['id'] ?>"  onclick="fulldata(this)"  data-name="<?php echo $sch['name'] ?>"   data-phone="<?php echo $sch['phone'] ?>"   data-id_customer="<?php echo $sch['id'] ?>"   data-qr="<?php echo $sch['uid'] ?>" class="btn row_search"><?php echo $sch['name'] ?>-<?php echo $sch['phone'] ?></button>

		<?php } ?>

	</div>


