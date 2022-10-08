


<br>

<div class="row">
	<div class="col">
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/location"><?php  echo $this->langControl('location_report') ?> </a></li>
				<?php  echo $category ?>
				<li class="breadcrumb-item active" aria-current="page" >  عرض المحتويات </li>
			</ol>
		</nav>


		<hr>
	</div>
</div>



<form action="<?php  echo  url .'/'.$this->folder ?>/location" method="get">
	<div class="container-fluid" id="expand_menu">
		<div class="row">

			<select name="model"  id="her_add_menu" class="custom-select  col-md-3 mb-3 list_menu_categ" onchange="mainCatgHtmlx(this)" required>
				<option value="" disabled selected>  اختر الفئة الرئيسية  </option>
				<?php  foreach ($this->category_website as $key => $cg) {   ?>
                    <option value="<?php  echo $key ?>"     > <?php  echo $cg ?></option>
				<?php  } ?>
			</select>


			<div class="col-auto">
				<input onkeyup="$('#from_r').text($(this).val())" value="<?php echo $from ?>" id="from" class="form-control" style="width:150px;" name="from"  type="number" placeholder="من  تسلسل" required>
			</div>
			<div class="col-auto">
				<input  onkeyup="$('#to_r').text($(this).val())" value="<?php echo $to ?>" id="to" class="form-control" style="width:150px;" name="to"  type="number" placeholder="الى تسلسل" required>
			</div>
			<div class="col-12 text-center">
				<hr>
				<button class="btn btn-info" type="submit" >   <span>بحث </span> <i class="fa fa-search"></i> </button>
			</div>

		</div>

	</div>

</form>




<script>



    function mainCatgHtmlx(selectObject) {

        var value = selectObject.value;
        var id_html = selectObject.id;

        if (value !== 'savers')
		{
        $.get("<?php echo url . '/' . $this->folder ?>/getMainCatDB/" +value, function (data) {
            if (data)
            {
                $('#'+id_html).nextAll('select').remove();
                $('#'+id_html+':last').after(data);
            }
            else
            {
                alert('حدث خطاء في الاختيار يرجى تحديث الصفة او المحاولة لاحقا')
            }
        });
        pathCatg();

    }

    }


    function sub_catgs(selectObject) {

        var value = selectObject.value;
        var id_html = selectObject.id;
        $.get("<?php echo url . '/' . $this->folder ?>/sub_catgs/" + value, function (data) {
            if (data)
            {
                $('#'+id_html).nextAll('select').remove();
                $('#'+id_html+':last').after(data);
            }
            else
            {
                $('#'+id_html).nextAll('select').remove();
            }
        });
        pathCatg();
    }



    function sub_catgs2(selectObject) {
        var value = selectObject.value;
        var id_html = selectObject.id;

        $.get("<?php echo url . '/' . $this->folder ?>/sub_catgs2/" + value, function (data) {
            if (data)
            {
                $('#'+id_html).nextAll('select').remove();
                $('#'+id_html+':last').after(data);
            }
            else
            {
                $('#'+id_html).nextAll('select').remove();
            }
        });
        pathCatg();
    }



    function pathCatg() {
        var d = $('#expand_menu select option:selected').map(function () {
            return $(this).text();
        });

        p=d[0];
        for (i = 1; i < d.length; i++)
        {
            p+=" / "+d[i];
        }
        $('#path_catg').val(p)
    }

</script>



<style>

	.list_menu_categ
	{
		border-radius: 0;
		outline: none;
		box-shadow: unset;
	}
	.list_menu_categ:focus
	{
		border-radius: 0;
		outline: none;
		box-shadow: unset;
	}


	.x_down div
	{
		margin-bottom: 30px;
	}
	.code_m
	{
		margin-top: 15px;
	}
	button.btn.add_new_sub_row {
		padding: 0;
		background: transparent;
		color: #218838;
		font-size: 25px;
	}
	button.btn.remove_sub_row {
		padding: 0;
		background: transparent;
		color: red;
		font-size: 25px;
	}

	.remove_div
	{
		position: absolute;
		left: 13px;
		padding: 0;
		top: -14px;
		background: #f5f6f7;
		border: 0;
	}

	.remove_div i
	{
		color: red;
		font-size: 28px;
	}
	.addPs
	{
		color: #FFFFFF !important;
	}
	.x_down
	{
		position: relative;
		margin-bottom: 25px;
		border: 1px solid #eeeff0;
		border-bottom: 1px solid #d5d7d8;
		padding: 22px;
		padding-bottom: 15px;
		background: #eeeff08a;
	}
</style>




<form id="checked_purchases_all"   method="post">


	<script>
        $(document).ready(function() {

            var selected = [];

            var t=$('#example').DataTable( {
                "processing": true,
                "serverSide": true,
				<?php  if ($model=='accessories'){ ?>
                "ajax": "<?php echo url .'/'. $this->folder ?>/processing_report_accessories_location/<?php echo $from ?>/<?php echo $to ?>/<?php  echo $model ?>/<?php  echo $id ?>",
				<?php  }else if ($model=='savers')  { ?>
                "ajax": "<?php echo url .'/'. $this->folder ?>/processing_report_savers_location/<?php echo $from ?>/<?php echo $to ?>/<?php  echo $model ?>/<?php  echo $id ?>",
			    <?php  }else{   ?>
                "ajax": "<?php echo url .'/'. $this->folder ?>/processing_report_location/<?php echo $from ?>/<?php echo $to ?>/<?php  echo $model ?>/<?php  echo $id ?>",
			    <?php  } ?>

                info:false,
                "fnDrawCallback": function() {
                    jQuery('.toggle-demo').bootstrapToggle();

                },

                "order": [[ 1, 'asc'] ],
                'columnDefs': [{
                    "targets": [1],
                    "orderable": false
                }],

                aLengthMenu: [ 10, 25, 50,100, 200, 300,500,1000,-1],
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
          /*  t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();*/

        } );
	</script>


	<hr>
	<div class="row">
		<div class="col">


			<table  id="example" class="table table-striped display d-table"  >
				<thead>
				<tr>
					<th> ت  </th>
					<th>  <input type='checkbox'   class="checkall"  >  </th>
					<th>  اسم المادة </th>
					<th> رمز المادة </th>
                    <?php  if ($model =='accessories') {  ?>
                   <th>  الحد الاعلى   </th>
					<th> الحد الادنى</th>
                    <?php  }  ?>
					<th> الموقع </th>
					<th> الكمية </th>
					<?php  for ($i=1 ; $i <= $group ;$i++ ) { ?>
					<th>  <?php echo $this->group[$i] ?> </th>
					<?php } ?>

				</tr>
				</thead>

			</table>

		</div>
	</div>



<hr>
	<br>
	<br>
	<div class="row align-items-end add_to_group">
		<div class="col-4">
			<label for="select_group">اضافة المواد المحددة الى المجموعة</label>
			<select style="padding: 0 5px" name="group"  id="select_group" class="form-control list_menu_categ"  required>
				<option value="" disabled selected> تحديد المجموعة  </option>
				<?php  foreach ($this->group as $key => $g) {   ?>
					<option value="<?php  echo $key ?>"     > <?php  echo $g ?></option>
				<?php  } ?>
			</select>

		</div>
		<div class="col-auto ">
            <div class="custom-control custom-checkbox">
                <input name="all" type="hidden"  value="0" >
                <input name="all" type="checkbox" value="1" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1"> <span>الكل ضمن الرينج</span> (<span id="from_r"><?php echo $from  ?></span> - <span id="to_r"><?php echo  $to  ?></span>) </label>
            </div>
		</div>
		<div class="col-auto ">
			<input class="btn btn-warning"  name="submit"  value="موافق"  type="submit">
		</div>
	</div>

</form>






<script>

    $(function(){
        $('.checkall').on('click', function() {
            $('.childcheckbox').prop('checked', this.checked)
        });
    });




    $(function() {
        $("#checked_purchases_all").submit(function (e) {

            e.preventDefault();
            var actionurl = e.currentTarget.action;
            var from=$('#from').val();
            var to=$('#to').val();
            $.ajax({
                url:  "<?php  echo url .'/'.$this->folder ?>/checked_purchases_all_location/<?php echo $model ?>",
                type: 'post',
                cache: false,
                data: $("#checked_purchases_all").serialize()+"&from="+from+"&to="+to,
                success: function (data) {
                    console.log(data);

                    var response = JSON.parse(data);
                    console.log(response);
                    if(response.done) {
                        alert('تم اضافة المواد المحددة الى المجموعة المحددة')
					 	window.location=''
                    }else if (response.error_ch)
                    {
                        alert('يرجى تحديد المواقع')
                    }
                    else if (response.empty)
                    {
                        alert('يرجى تحديد المواقع 1 ')
                    }
                }
            })



        });
    });

</script>


<style>

	.add_to_group
	{
		position: fixed;
		bottom: 0;
		background: #add;
		width: 100%;
		padding: 5px;
		border: 2px solid #add;
		padding-bottom: 18px;
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








