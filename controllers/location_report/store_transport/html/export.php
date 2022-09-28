


<br>

<div class="row">
	<div class="col">
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/location"><?php  echo $this->langControl('location_report') ?> </a></li>
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/store_transport">    <?php echo $this->langControl('store_transport') ?>   </a></li>

                <li class="breadcrumb-item active" aria-current="page" >  عرض المناقلة </li>
				<li class="breadcrumb-item active" aria-current="page" >  <?php echo $transport?> </li>
                <li class="breadcrumb-item active" aria-current="page" >   تصدير المواد   </li>


            </ol>
		</nav>


		<hr>
	</div>
</div>


<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            aLengthMenu: [   100, 200,-1],
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



<div class="row justify-content-between">
    <div class="col-auto mb-2">

        <div class='row   align-items-end'>
            <div class='col-auto'  >
                <label>ادخال رقم فاتورة كرستال</label>
                <input placeholder="ادخال رقم فاتورة كرستال" id='numberBill_<?php  echo $transport?>'  value="<?php  echo $crystal_bill ?>" autocomplete="off" type='text' class='form-control' name='crystal_bill' required>
            </div>
            <div class='col-auto'  >
                <button type='submit' id='btn_in_bill_<?php  echo $transport?>' onclick=saveBilltransport('<?php  echo $transport?>')  name='submit' class='btn btn-warning'>حفظ</button>
            </div>
        </div>
    </div>

</div>

<div class="row">
	<div class="col-12">
		<div class="resultLocation">
			<?php  if (!empty($data)) {  ?>
				<table   id="example"     class="table table-bordered  table-striped">
					<thead>
					<tr>
                        <th scope="col">  رمز المادة   </th>
                        <th scope="col">    الكمية     </th>
                        <th scope="col"> اسم المادة </th>
                        <th scope="col"> اسم المستودع الذي سحب منه </th>
                        <th scope="col"> اسم المستودع الذي ادخلت الكمية به </th>
                        <th scope="col">رقم فاتورة كرستال,رقم  المناقلة ،اسم الموظف الساحب،اسم الموظف الذي ادخل الكمية،الملاحظة  </th>


                    </tr>
					</thead>
					<tbody>
					<?php foreach ($data as $ta)  { ?>
						<tr id="row_db_<?php echo $ta['id'] ?>">
							<td> <?php echo  $ta['code']    ?> </td>
							<td> <?php echo  $ta['quantity']    ?> </td>
							<td> <?php echo  $ta['title']    ?> </td>
							<td> <?php echo  $ta['from_store_location']    ?> </td>
							<td> <?php echo  $ta['to_store_location']    ?> </td>
							<td> <?php echo  $ta['details']    ?> </td>
						</tr>
					<?php } ?>
					</tbody>
				</table>

			<?php  }  ?>
		</div>


	</div>
</div>


<script>

    function saveBilltransport(transport) {

        if($('#numberBill_'+transport).val())
        {

            $.get( "<?php  echo url .'/'.$this->folder ?>/crystal_bill_transport",{transport:transport,crystal_bill:$('#numberBill_'+transport).val()}, function( data ) {
                if (data)
                {
                    alert(    'تم اضافة فاتورة كرستال = ' +$('#numberBill_'+transport).val());

                    window.location=""

                }else

                {
                    alert('رقم فاتورة كرستال مدخل مسبقا')
                }

            });

        }else {

            alert('حقل فاتورة كرستال فارغ !')
        }

    }




    setTimeout(function () {
        $('.buttons-excel').hide();
    },100)
    <?php  if ($this->permit('export_excel','location_report')) {  ?>
    setTimeout(function () {
        $('.buttons-excel').show();
        $('.buttons-excel').click(function(){
            $.get( "<?php  echo url .'/'. $this->folder  ?>/export_transport",{transport:<?php  echo $transport ?>}, function( data ) {

            });
        });
    },500)
    <?php  } ?>

</script>

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











