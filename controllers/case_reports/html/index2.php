


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
            "ajax": "<?php echo url .'/'. $this->folder ?>/<?php  echo $processing.'/'.$model ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[2]);
            },

            "order": [[ 2, 'desc'] ],
            'columnDefs': [{
                "targets": [0],
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


    $(function(){
        $('.checkall').on('click', function() {
            $('.childcheckbox').prop('checked', this.checked)
        });
    });



</script>

<?php  echo $this->tab($model,'case2') ?>


<hr>



<form id="delete_location_confirm"   method="post">



<div class="row">
	<div class="col">


		<table  id="example" class="table table-striped display d-table"  >
			<thead>
			<tr>


                <th>

                    <div class="row justify-content-center">
                        <div class="col-auto p-0">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input type="checkbox" class="custom-control-input checkall" id="customControlInline">
                                <label class="custom-control-label" for="customControlInline"></label>
                            </div>

                        </div>
                        <div class="col-auto p-0"> <button  type="submit"  class="btn btn-sm btn-danger">حذف</button> </div>
                    </div>


                    </th>
				<th> صورة </th>
				<th> المادة </th>
				<th>  الباركود </th>
				<th> الموقع  </th>
				<th> الكمية  </th>
				<th> المستخدم  </th>

			</tr>
			</thead>

		</table>

	</div>
</div>


</form>


<script>



    $(function() {
        $("#delete_location_confirm").submit(function (e) {

            if (confirm('هل انت متأكد ؟')) {
                e.preventDefault();
                var actionurl = e.currentTarget.action;
                var from = $('#from').val();
                var to = $('#to').val();
                $.ajax({
                    url: "<?php  echo url . '/' . $this->folder ?>/delete_location_confirm/<?php echo $model ?>",
                    type: 'post',
                    cache: false,
                    data: $("#delete_location_confirm").serialize(),
                    success: function (data) {
                        if (data ==='true') {
                            window.location = '';
                        }else if (data==='empty')
                        {
                            alert('يرجى التحديد')
                        }
                    }
                })

            }return false;

        });
    });

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




