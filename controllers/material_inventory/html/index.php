

<br>

<div class="row">
	<div class="col">
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_location/<?php  echo $model?>"><?php  echo $this->langControl($this->folder) ?> </a></li>
				<li class="breadcrumb-item active" aria-current="page" >  <?php  echo $this->langControl($model)?></li>
			</ol>
		</nav>


		<hr>
	</div>
</div>




<script>
    $(document).ready(function() {
        <?php  if ($model=='accessories' || $model == 'savers' ) {   ?>

         $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            <?php  if (  $model == 'savers' ) {   ?>
               if (i===6  ) {
                <?php  } else { ?>
                   if (i===3  ) {
                <?php } ?>
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
        <?php  } ?>



        var table=$('#example').DataTable( {

            <?php  if ($model=='accessories') {   ?>
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing_accessories/<?php  echo $model ?>",
            <?php  } else if ($model=='savers'){ ?>
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing_savers",
            <?php  } else { ?>
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing/<?php  echo $model ?>",

        <?php  } ?>
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[1]);
            },
            orderCellsTop: true,

            aLengthMenu: [ 10, 25, 50,100, 200, 500,1000,1500,2000,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                sProcessing: " معالجة ...",
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

                <?php  if ($model =='savers') {   ?>
                    <th>  الماركة </th>
                    <th>  السلسلة </th>
                    <th>  الجهاز </th>
                <?php  } ?>
                <th> الباركود </th>
				<th> اسم الماده </th>



                <?php  if ($model=='accessories' || $model =='savers') {   ?>
                	<th> المواقع   </th>
                	<th> الكمية   </th>
                <?php } else {  ?>

                <?php  foreach ($this->location as $lco){  ?>
                <th>  <?php  echo $lco  ?>   </th>
               <?php  } ?>
               <?php  } ?>

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
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_location/"+id, function( data ) {
            $('#row_'+id).remove();
            $('#exampleModal').modal('hide')
        });
    });

    function delete_all(model) {

        if (confirm('هل انت متأكد؟'))
        {
            $.get( "<?php echo url .'/'.$this->folder ?>/delete_all/"+model, function( data ) {
                if (data)
                {
                    window.location=''
                }else {
                    alert('فشل الحذف')
                }
            });
        }



    }


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




