


<br>

<div class="row">
	<div class="col">
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/location"><?php  echo $this->langControl('location_report') ?> </a></li>
				<?php  echo $category ?>
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/transport_confirm"> عرض المناقلات المؤكدة </a></li>
				<li class="breadcrumb-item active" aria-current="page" >  عرض المناقلة </li>
				<li class="breadcrumb-item active" aria-current="page" >  <?php echo $transport?> </li>

			</ol>
		</nav>


		<hr>
	</div>
</div>




<div class="row">
	<div class="col-12">
		<div class="resultLocation">
			<?php  if (!empty($data)) {  ?>
				<table class="table table-bordered  table-striped">
					<thead>
					<tr>
						<th scope="col">اسم المؤكد</th>
						<th scope="col">القسم</th>
						<th scope="col">اسم المادة</th>
						<th scope="col">صورة المادة</th>
						<th scope="col">رمز المادة</th>
						<th scope="col">المواقع التي سحبت منها</th>
						<th scope="col">المواقع المسموح انتقل الها </th>
						<th scope="col"> الكمية الغير منقولة </th>
						<th scope="col"> المواقع الجديدة </th>
						<th scope="col"> الكمية المنقولة للمواقع الجديدة </th>
                        <th scope="col">   السيريلات </th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($data as $ta)  { ?>
						<tr id="row_db_<?php echo $ta['id'] ?>">
							<td> <?php echo  $ta['confirm']    ?> </td>
							<td> <?php echo $this->langControl($ta['model'] )  ?> </td>
							<td> <?php echo $ta['title'] ?> </td>
							<td> <img style="width: 40px" src="<?php echo $this->save_file.$ta['image'] ?>"> </td>
							<td> <?php echo $ta['code'] ?> </td>
							<td> <?php echo $ta['location'] ?> </td>

                            <td>

                                <?php echo  implode(',',$ta['all_location'])   ?>

                            </td>

                            <td class="qcheck  <?php  if ($ta['quantity'] != 0) echo 'qfound'?> "> <?php echo $ta['quantity'] ?> </td>
							<td>


									<table class='table table-bordered' style='background: #fff;margin: 0;padding: 0'><tbody>

										<tr>
											<td style='padding: 0;    vertical-align: unset;background: #add'> م  </td>
											<td style='padding: 0;    vertical-align: unset;background: #fea'> ك  </td>
 										</tr>
										<?php  foreach ($ta['tolocation'] as $tol) {   ?>

										<tr>
											<td style='padding: 0;    vertical-align: unset;'>   <?php echo $tol['location'] ?>   </td>
											<td style='padding: 0;    vertical-align: unset;'>   <?php echo $tol['quantity'] ?>   </td>
 										</tr>
										<?php  } ?>

										</tbody>

									</table>

							</td>
                            <td> <?php echo $ta['toquantity'] ?> </td>
                            <td> <?php echo $ta['serial'] ?> </td>
						</tr>
					<?php } ?>
					</tbody>
				</table>

			<?php  }  ?>
		</div>


	</div>
</div>




<style>



	table thead tr
	{
		text-align: center;
	}

	table tbody tr td
	{
		text-align: center;
	}


	.d-table
	{
		width:100%;
		border: 1px solid #c4c2c2;
		border-radius: 5px;
	}
	.class_delete_row
	{
		background: transparent;
		border-radius: 50%;
		padding: 0;
		width: 35px;
		height: 35px;
		font-size: 28px;
		margin: 0;
	}

</style>

<br>
<br>
<br>











