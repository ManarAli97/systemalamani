

	<div class="content_search">

		<?php  foreach ($contentAll as $sch) {  ?>

			<button type="button" value="<?php echo $sch['id'] ?>"  onclick="getDetails_device(this)"     class="btn row_search"><?php echo $sch['title'] ?></button>

		<?php } ?>

	</div>


