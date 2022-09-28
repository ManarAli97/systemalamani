


<br>

<div class="row">
	<div class="col">
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/location"><?php  echo $this->langControl('location_report') ?> </a></li>
				<li class="breadcrumb-item active" aria-current="page" >   <?php echo $this->langControl('store_transport') ?>   </li>
			</ol>
		</nav>


		<hr>
	</div>
</div>




<script>
    var  table;
    $(document).ready(function() {

        var selected = [];

        table=$('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing_store_transport/<?php   echo $from_date_stm .'/'.$to_date_stm  ?>/<?php echo $id_gl ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "order": [[ 2, 'asc'] ],
            'columnDefs': [{
                "targets": [1],
                "orderable": false
            }],

            aLengthMenu: [ 10, 25, 50,100, 200, 300,-1],
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



<form action="<?php echo url.'/'.$this->folder?>/store_transport" method="get">

	<div class="row align-items-end">

        <div class="col-auto">

             المستودعات (اختياري)
            <select class="form-control" name="id_gl">
                <option value=""></option>
                <?php  foreach ($group_location as $glo){  ?>
                    <option <?php if ($id_gl == $glo['id'] ) echo 'selected' ?>  value="<?php  echo $glo['id']?>"><?php  echo $glo['title']?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-auto">
            من تاريخ   (اختياري)
			<input type="date" name="date" class="form-control" value="<?php  echo $date ?>"  >
		</div>
		<div class="col-auto">
            الى تاريخ   (اختياري)
			<input type="date" name="todate" class="form-control" value="<?php  echo $todate ?>"  >
		</div>
		<div class="col-auto">
			<button type="submit" class="btn btn-warning" >بحث</button>
			<a href="<?php echo url.'/'.$this->folder?>/store_transport" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
		</div>
	</div>

</form>
<hr>


<script>







    function delete_transport(transport) {

        if (confirm(    ' هل انت متأكد من حذف المناقلة ذات الرقم ' + transport + "  ؟  "  )){
           $.get( "<?php echo url.'/'.$this->folder?>/delete_transport",{transport:transport}, function( data ) {

               if (data)
               {
                   table.draw()
               }else  {
                   alert('لا يمكن حذف المناقلة')
               }
           });

       } return false;

    }

</script>

<div class="row">
	<div class="col">


		<table  id="example" class="table table-striped display d-table"  >
			<thead>
			<tr>


				<th>   القسم  </th>
				<th>  اسم المنشأ </th>
				<th>  رقم المناقلة </th>
				<th>   تصدير مواد المناقلة   </th>
				<th>   اسم المؤكد  </th>
				<th>  التاريخ والوقت </th>
				<th>  حالة التصدير </th>
				<th>   المستخدم المصدر  </th>
				<th>   تاريخ التصدير </th>
				<th>  حذف </th>

			</tr>
			</thead>

		</table>

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
</style>

<br>
<br>
<br>








