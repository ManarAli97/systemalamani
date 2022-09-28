


<br>

<div class="row">
	<div class="col">
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">تفاصيل تأكيد المواقع</a></li>
				<li class="breadcrumb-item active" aria-current="page" >  <?php  echo $this->langControl($model) ?></li>
			</ol>
		</nav>


		<hr>
	</div>
</div>




<script>
    $(document).ready(function() {

        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {

            if (i===1 || i===2   ) {
                $(this).html('<input class="form-control" type="text" placeholder="بحث" />');

                $('input', this).on('keyup change', function () {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }else
            {
                $(this).html('');

            }

        } );



        var table=$('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing_location_backup/<?php echo $model?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[6]);
            },

            "order": [[ 5, 'desc'] ],
            aLengthMenu: [ 10, 25, 50,100, 200, 300,-1],
            orderCellsTop: true,
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
	<div class="col">


		<table  id="example" class="table table-striped display d-table"  >
			<thead>
			<tr>



				<th> القسم </th>
                <th>  الباركود </th>
                <th>  الموقع  </th>
				<th>  الكمية  </th>
				<th> المستخدم </th>
				<th> التاريخ </th>

			</tr>
			</thead>

		</table>

	</div>
</div>






<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> </h5>


            </div>
            <div class="modal-body">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">الغاء</button>
                <button type="button" value="" id='save' class="btn btn-danger">حذف </button>
            </div>
        </div>
    </div>
</div>










<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('id') ;
        var title = button.data('title') ;
        var modal = $(this);
        modal.find('.modal-title').text('هل انت متاكد من حذف العنصر ؟ ' );
        modal.find('.modal-body').text(title);
        modal.find('#save').val(recipient)
    });

    $('#save').on('click',function () {
        var  id= $('#save').val();
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_code/"+id, function( data ) {
            console.log(data)
            $('#row_'+id).remove();
            $('#exampleModal').modal('hide')
        });
    });




</script>






<style>

    .error_quantity
    {
        background: red;
    }

    .list_location {
        position: absolute;
        z-index: 1000;
        width: 100%;
        border: 1px solid #cec8c8;
        box-shadow: 5px 4px 6px 0px #0000003b;
        display: none;
        height: 300px;
        overflow: auto;
        background: #FFFFFF;
    }
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




