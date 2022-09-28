


<br>

<div class="row">
	<div class="col">
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/location"><?php  echo $this->langControl('location_report') ?> </a></li>
				<li class="breadcrumb-item active" aria-current="page" >   مناقلات غير مؤكدة </li>
			</ol>
		</nav>


		<hr>
	</div>
</div>




<script>
    var table = '';
    $(document).ready(function() {



       table = $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing_transport_not_confirm",
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


    function delete_transport_before_conform(transport) {

        if (confirm(    ' هل انت متأكد من حذف المناقلة ذات الرقم ' + transport + "  ؟  "  )){
            $.get( "<?php echo url.'/'.$this->folder?>/delete_transport_before_conform",{transport:transport}, function( data ) {

                if (data)
                {

                    table.draw();

                }else  {
                    alert('لا يمكن حذف المناقلة')
                }
            });

        }

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
				<th>  التاريخ والوقت </th>
				<th> حذف </th>

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








