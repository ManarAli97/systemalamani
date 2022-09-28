<br>
<div class="row">
	<div class="col">

		<nav aria-label="breadcrumb" >

			<ol class="breadcrumb"  >
				<li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/details_money_clipper"><?php  echo $this->langControl('money_clipper') ?> </a></li>
				<li class="breadcrumb-item active">   سجل الاضافة الى القاصة   </li>
			</ol>

		</nav>

	</div>
	<div class="col-auto">
		<div class="sumAllMoney">
			<span>   مجموع القاصة : </span> <span>  <?php  echo number_format($this->allMoney_clipper($this->id_money_clipper)) ?> </span> <span> د.ع</span>
		</div>
	</div>


</div>



<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_record_add_money_clipper",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "order": [[1, 'desc'] ],
            aLengthMenu: [ 10,25, 50, 100,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                  sProcessing:  `
                <span style="vertical-align: sub;" class="spinner-grow text-light spinner-grow-sm" role="status" aria-hidden="true"></span>
                  جاري التحميل ...
                `,
                sLengthMenu: "عرض _MENU_ ",
                sSearch: "أبحث",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"


            }
        } );
    } );
</script>


<hr>
<div class="row">
	<div class="col">

		<table  id="example" class="table table-striped display d-table"  >
			<thead>
			<tr>
				<th>  المبلغ المضاف  </th>
				<th> تاريخ الاضافة </th>
				<th>  الادمن </th>
				<th>  ملاحظه </th>



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
<br>


