


<br>

<div class="row">
	<div class="col">
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/location"><?php  echo $this->langControl('location_report') ?> </a></li>
				<?php  echo $category ?>
 				<li class="breadcrumb-item active" aria-current="page" >  بحث عن مناقلات رمز المادة    </li>
				<li class="breadcrumb-item active" aria-current="page" >  <?php echo $code?> </li>

			</ol>
		</nav>


		<hr>
	</div>
</div>


<form action="<?php echo url.'/'.$this->folder?>/view_transport_search" method="get">

    <div class="row align-items-end">
        <div class="col-auto">
            رمز المادة
            <input type="text" autocomplete="off"   name="code" class="form-control" value="<?php  echo $code ?>"  required>
        </div>
        <div class="col-auto">
            من تاريخ   (اختياري)
            <input type="datetime-local" name="date" class="form-control" value="<?php  echo $date ?>"  >
        </div>
        <div class="col-auto">
            الى تاريخ   (اختياري)
            <input type="datetime-local" name="todate" class="form-control" value="<?php  echo $todate ?>"  >
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-warning" >بحث</button>
            <a href="<?php echo url.'/'.$this->folder?>/view_transport_search" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
        </div>
    </div>

</form>

<hr>
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            aLengthMenu: [ 10,25, 50, 100,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                sProcessing:  `
                <span style="vertical-align: sub;" class="spinner-grow text-light spinner-grow-sm" role="status" aria-hidden="true"></span>
                  جاري التحميل ...
                `,
                sLengthMenu: "عرض _MENU_ ",
                sSearch: " أبحث  ",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"


            },
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            bFilter: true, bInfo: true
        } );
    } );
</script>

<div class="row">
	<div class="col-12">
		<div class="resultLocation">
			<?php  if (!empty($data)) {  ?>
				<table  id="example" class="table  table-bordered  table-striped">
					<thead>
					<tr>
						<th scope="col">  رقم المناقلة </th>
						<th scope="col">القسم</th>
						<th scope="col">اسم المادة</th>
						<th scope="col">صورة المادة</th>
						<th scope="col">رمز المادة</th>
						<th scope="col">المواقع التي سحبت منها</th>
						<th scope="col"> المواقع الجديدة </th>
						<th scope="col"> الكمية المنقولة للمواقع الجديدة </th>
                        <th scope="col"> الكمية الغير منقولة </th>
                         <th scope="col">   التاريخ والوقت </th>
                        <th scope="col">اسم المؤكد</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($data as $ta)  { ?>
						<tr id="row_db_<?php echo $ta['id'] ?>">
							<td><a href="<?php echo url .'/'.$this->folder ?>/view_transport_confirm?g=<?php echo  $ta['transport']    ?>">  <?php echo  $ta['transport']    ?> </a>  </td>
							<td> <?php echo $this->langControl($ta['model'] )  ?> </td>
							<td> <?php echo $ta['title'] ?> </td>
							<td> <img style="width: 40px" src="<?php echo $this->save_file.$ta['image'] ?>"> </td>
							<td> <?php echo $ta['code'] ?> </td>
							<td> <?php echo $ta['location'] ?> </td>


							<td>
                                <?php    $newLocation =''; ?>
                                    <?php  foreach ($ta['tolocation'] as $tol) {   ?>
                                       <?php  $newLocation = $tol['location']  .' ,'?>
                                    <?php  } ?>

                                <?php  echo rtrim($newLocation,',')?>

							</td>
                            <td> <?php echo $ta['toquantity'] ?> </td>

                            <td class="qcheck  <?php  if ($ta['quantity'] != 0) echo 'qfound'?> "> <?php echo $ta['quantity'] ?> </td>

                             <td> <?php echo date('Y-m-d h:i:s A', $ta['date']) ?> </td>
                            <td> <?php echo  $ta['confirm']    ?> </td>

                        </tr>
					<?php } ?>
					</tbody>
				</table>

			<?php  } else{  ?>

                <?php if ($code) {  ?>
                <div class="alert alert-primary" role="alert">
               <span> لا توجد مناقلات لرمز المادة  </span>     <strong>   <?php  echo  $code ?> </strong>

                    <?php   if (!empty($from_date_stm) && !empty($to_date_stm)) {  ?>
                        <span>  خلال الفترة المحددة </span>
                        <?php } ?>
                </div>
                  <?php } ?>
            <?php } ?>

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











