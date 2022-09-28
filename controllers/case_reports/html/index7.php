


<br>

<div class="row">
	<div class="col">
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_location/<?php  echo $model?>"><?php  echo $this->langControl($this->folder) ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" >  <?php  echo   $this->langControl( $model)  ?></li>
            </ol>
		</nav>


		<hr>
	</div>
</div>




<script>
    $(document).ready(function() {

        var selected = [];

        var t=$('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing7/<?php  echo  $model ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[6]);
            },

            "order": [[ 2, 'desc'] ],
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


<?php  echo $this->tab($model,'case7') ?>


<hr>

<div class="row justify-content-end">
    <div class="col-auto">
        <button     onclick='success_location_all(this)' type='button' class="btn btn-success" >   قبول الكل  </button>
    </div>
    <div class="col-auto">
        <button     onclick='remove_location_all(this)' type='button' class="btn btn-danger" >  حذف الكل  </button>
    </div>

</div>




<hr>
<div class="row">
	<div class="col">


		<table  id="example" class="table table-striped display d-table"  >
			<thead>
			<tr>



				<th> صورة </th>
				<th> المادة </th>
				<th>  الباركود </th>
				<th> الموقع  </th>
				<th> كمية الموقع  </th>
				<th>  عملية  </th>

			</tr>
			</thead>

		</table>

	</div>
</div>




<script>

    function remove_location(id) {

        if (confirm('هل انت متأكد؟'))
        {

            $.get( "<?php echo url .'/'.$this->folder ?>/remove_location",{model:'<?php  echo $model ?>',id:id}, function( data ) {

               if (data)
               {
                   $('#row_'+id).remove();
               }else {
                   alert('لا يمكن حذف الموقع يرجى اعادة المحاولة')
               }
            });
        }

    }

    function remove_location_all(e) {

        if (confirm('هل انت متأكد؟'))
        {
            $(e).attr("disabled", true);
            $.get( "<?php echo url .'/'.$this->folder ?>/remove_location_all",{model:'<?php  echo $model ?>'}, function( data ) {
               if (data)
               {
                 window.location=''
               }else {
                   alert('لا يمكن حذف الموقع يرجى اعادة المحاولة');
                   $(e).removeAttr("disabled");
               }
            });
        }

    }

    function success_location(id) {

        if (confirm('هل انت متأكد؟'))
        {

            $.get( "<?php echo url .'/'.$this->folder ?>/success_location",{model:'<?php  echo $model ?>',id:id}, function( data ) {


                if (data)
               {
                   $('#row_'+id).remove();
               }else {
                   alert('حدث خطأ اعد المحاولة')


                }
            });
        }

    }
    function success_location_all(e) {

        if (confirm('هل انت متأكد؟'))
        {
            $(e).attr("disabled", true);
            $.get( "<?php echo url .'/'.$this->folder ?>/success_location_all",{model:'<?php  echo $model ?>'}, function( data ) {

                if (data)
               {

                  window.location=''
               }else {
                    $(e).removeAttr("disabled");
                   alert('حدث خطأ اعد المحاولة')
               }
            });
        }

    }

</script>



<style>
    .button_report
    {
        margin-bottom: 15px;
    }
    .active_case
    {
        background: #4caf50;
        border: 1px solid #4caf50;
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




