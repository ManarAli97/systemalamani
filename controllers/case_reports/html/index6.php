


<br>

<div class="row">
	<div class="col">
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_location/<?php  echo $model?>"><?php  echo $this->langControl($this->folder) ?> </a></li>
				<li class="breadcrumb-item active" aria-current="page" >  <?php  echo   $this->langControl( $this->langControl($this->folder))  ?></li>
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
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing6/<?php  echo  $model ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[2]);
            },


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

<div class="row">
	<div class="col-auto">
		<a class="btn btn-secondary button_report <?php  echo $active1 ?>  " href="<?php  echo url .'/'.$this->folder ?>/list_case/<?php  echo $model ?>">  مواد مرفوعة في اكسل الكميات والاسعار وليس لها مواقع    </a>
	</div>

	<div class="col-auto">
		<a class="btn btn-secondary button_report <?php  echo $active2 ?>" href="<?php  echo url .'/'.$this->folder ?>/list_case/<?php  echo $model ?>/2">  مواد غير مرفوعة في اكسل الكميات والاسعار و لها مواقع    </a>
	</div>
    <div class="col-auto">
        <a class="btn btn-secondary  button_report " href="<?php  echo url .'/'.$this->folder ?>/list_case3/<?php  echo $model ?>">  الكمية الكلية اقل من الكمية الموزعة على المواقع   </a>
    </div>
    <div class="col-auto">
        <a class="btn btn-secondary  button_report " href="<?php  echo url .'/'.$this->folder ?>/list_case4/<?php  echo $model ?>">  الكمية الكلية كبر  من الكمية الموزعة على المواقع   </a>
    </div>

    <div class="col-auto">
        <a class="btn btn-secondary  button_report  " href="<?php  echo url .'/'.$this->folder ?>/list_case5/<?php  echo $model ?>">  مواد غير مرفوعه في اكسيل الكميات والاسعار ولها بطاقة   </a>
    </div>
    <div class="col-auto">
        <a class="btn btn-secondary  button_report active_case" href="<?php  echo url .'/'.$this->folder ?>/list_case6/<?php  echo $model ?>">   مواد مرفوعة في اكسيل الكميات والاسعار وليس لها بطاقة  </a>
    </div>

        <div class="col-auto">
            <a class="btn btn-secondary  button_report " href="<?php  echo url .'/'.$this->folder ?>/list_case7/<?php  echo $model ?>">     المواد    داخلة  بموقع غير مسموح الانتقال الها   </a>
        </div>

</div>


<hr>
<div class="row">
	<div class="col">


		<table  id="example" class="table table-striped display d-table"  >
			<thead>
			<tr>



				<th>  الباركود </th>
				<th>  الكمية </th>
				<th>   سعر الدولار </th>
				<th>   رقم الفاتورة </th>
				<th>  تاريخ الرفع </th>


			</tr>
			</thead>

		</table>

	</div>
</div>








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




