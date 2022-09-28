


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









<script   src="<?php echo $this->static_file_site ?>/resize/jquery.splitter.js"></script>

<link rel="stylesheet" href="<?php echo $this->static_file_site ?>/resize/jquery.splitter.css">


<script>
    $(function($) {

        $('#spliter2').css({

            height: 950
        }).split({
            orientation: 'horizontal',
            limit: 20,
            percent: true
        });

    });
</script>

<style>
	#multiple > .item {
		background-color: #2d2d2d;
	}
	#spliter2 .a {
		background-color: #ffffff;
		overflow: hidden;
		overflow-y: auto;
	}
	#spliter2 .b {
		background-color: #ffffff;
		overflow: hidden;
		overflow-y: auto;
		/*padding: 7px 16px*/
	}

</style>


<div id="spliter2">
	<div class="a">


		<form action="<?php  echo  url .'/'.$this->folder ?>/report" method="get">
			<div class="container-fluid" id="expand_menu">
				<div class="row ">
					<select name="model"  id="her_add_menu" class="custom-select  col-md-3 mb-3 list_menu_categ" onchange="mainCatgHtmlx(this)" required>
						<option value="" disabled selected>  اختر الفئة الرئيسية  </option>
						<?php  foreach ($this->category_website as $key => $cg) {   ?>
							<option value="<?php  echo $key ?>"     > <?php  echo $cg ?></option>
						<?php  } ?>
					</select>


					<div class="col-auto">
						<input data-toggle="tooltip" data-placement="top" title="رقم مجموعة اولى" value="<?php echo $from ?>"  class="form-control" style="width:150px;" name="from"  type="number" placeholder="رقم مجموعة اولى" required>
					</div>
					<div class="col-auto">
						<input  data-toggle="tooltip" data-placement="top" title=" رقم مجموعة ثانية " value="<?php echo $to ?>" class="form-control" style="width:150px;" name="to"  type="number" placeholder="رقم مجموعة ثانية" required>
					</div>

                    <div class="col-auto">
                        <input  data-toggle="tooltip" data-placement="top" title="من تاريخ // المبيعات  " value="<?php echo $fromDate_format ?>"  class="form-control"   name="fromDate"   type="datetime-local"     data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر"  >
                    </div>
                    <div class="col-auto">
                        <input  data-toggle="tooltip" data-placement="top" title="الى تاريخ // المبيعات" value="<?php echo $toDate_format ?>"   class="form-control"   name="toDate"   type="datetime-local"     data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر"   >
                    </div>

					<div class="col-12 text-center">
						<hr>
						<button class="btn btn-info" type="submit" >   <span>بحث </span> <i class="fa fa-search"></i> </button>
					</div>
				</div>

			</div>

		</form>




		<form id="checked_purchases_all"   method="post">


			<script>
                $(document).ready(function() {

                    var selected = [];

                    var t=$('#example').DataTable( {
                        "processing": true,
                        "serverSide": false,

						<?php  if ($model=='accessories'){ ?>
                        "ajax": "<?php echo url .'/'. $this->folder ?>/processing_report_accessories/<?php echo $from ?>/<?php echo $to ?>/<?php  echo $model ?>/<?php  echo $id ?>/<?php echo $fromDate ?>/<?php echo $toDate ?>",
						<?php  }else if ($model=='savers')  { ?>
                        "ajax": "<?php echo url .'/'. $this->folder ?>/processing_report_savers/<?php echo $from ?>/<?php echo $to ?>/<?php  echo $model ?>/<?php  echo $id ?>/<?php echo $fromDate ?>/<?php echo $toDate ?>",
						<?php  }else{   ?>
                        "ajax": "<?php echo url .'/'. $this->folder ?>/processing_report/<?php echo $from ?>/<?php echo $to ?>/<?php  echo $model ?>/<?php  echo $id ?>/<?php echo $fromDate ?>/<?php echo $toDate ?>",
						<?php  } ?>

                        info:false,
                        "fnDrawCallback": function() {
                            jQuery('.toggle-demo').bootstrapToggle();

                        },

                        "order": [[ 0, 'asc'] ],
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
                    // t.on( 'order.dt search.dt', function () {
                    //     t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    //         cell.innerHTML = i+1;
                    //     } );
                    // } ).draw();

                } );
			</script>


			<hr>
			<div class="row">
				<div class="col">


					<table  id="example" class="table table-striped display d-table"  >
						<thead>
						<tr>
							<th> ت  </th>

							<th>  صورة </th>
							<th>  اسم المادة </th>
							<th> رمز المادة </th>
                            <?php  if ($model=='accessories'){ ?>
							<th>  الحد الاعلى   </th>
							<th>  الحد الادنى   </th>
                            <?php  } ?>
							<th> الكمية </th>
							<th> المبيع  </th>

                            <?php  if ($model=='accessories'){ ?>
                                <th>  الكمية الواجب تعويضها   </th>

                            <?php  } ?>

                            <?php if (array_key_exists($from,$this->group)) {  ?>
                                    <th>  <?php echo $this->group[$from] ?> </th>
                            <?php } ?>
                            <?php if (array_key_exists($to,$this->group)) {  ?>
                                    <th>  <?php echo $this->group[$to] ?> </th>
                            <?php } ?>

<!--                            < ? php  for ($i=1 ; $i <= $group ;$i++ ) { ?>-->
<!--                                <th>  < ?php echo $this->group[$i] ?> </th>-->
<!--                            < ? php } ?>-->
						</tr>
						</thead>

					</table>

				</div>
			</div>



			<hr>
			<br>
			<br>


		</form>



	</div>




	<div class="b">



<form id="insert_location"  action="<?php echo url.'/'.$this->folder  ?>/insert_location" method="post">

	<div class="row align-items-end">
		<div class="col-12">
			<div class="create_transport">
				انشاء مناقلة

			</div>
		</div>




		<div class="col-lg-2 col-md-2 col-sm-12 mb-3">
			<div class="form-group">
                <label for="location_loc">  اختر الفئة الرئيسية  </label>

                <select name="model"  id="select_model"  class="custom-select  "  required>

                    <option value="" disabled selected>  اختر الفئة الرئيسية  </option>
                    <?php  foreach ($this->category_website as $key => $cg) {   ?>
                        <option value="<?php  echo $key ?>"     > <?php  echo $cg ?></option>
                    <?php  } ?>
                </select>
            </div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-12 mb-3">
			<div class="form-group">
				<label for="location_loc">  الموقع  </label>
				<input name="location" type="search" class="form-control" id="location_loc" aria-describedby="emailHelp" placeholder="الموقع" required autocomplete="off">
 			</div>
		</div>

		<div class="col-lg-2 col-md-2 col-sm-12 mb-3">
			<div class="form-group">
				<label for="location_code">  باركود المادة  </label>
				<input oninput="change_code()" name="code" type="search" class="form-control" id="location_code" aria-describedby="emailHelp" placeholder="باركود المادة" required autocomplete="off">
 			</div>
		</div>

		<div class="col-lg-2 col-md-2 col-sm-12 mb-3">
			<div class="form-group">
				<label for="location_quantity">  سحب كمية  </label>
				<input value="0"  onkeyup="remove_class(this)" name="quantity" type="number" class="form-control" id="location_quantity" aria-describedby="emailHelp" placeholder="الكمية  "   autocomplete="off">
 			</div>
		</div>

		<div class="col-lg-2 col-md-2 col-sm-12 mb-3">
			<div class="form-group">
				<button name="submit" class="btn btn-warning" value="submit" type="submit"  > اضافة  </button>
 			</div>
		</div>

	</div>


</form>

		<div class="row">
			<div class="col-12">
                <form id="save_transport" action="<?php echo url . '/' . $this->folder ?>/save_transport" method="post">
				<div class="resultLocation">
					<?php  if (!empty($data)) {  ?>
						<table class="table table-bordered  table-striped">
							<thead>
							<tr>
								<th scope="col">القسم</th>
								<th scope="col">الموقع</th>
								<th scope="col">الكود</th>
								<th scope="col">اللون</th>
								<th scope="col">الكمية</th>
                                <th scope="col">السيريلات المقترحة</th>
                                <th scope="col">السيريلات </th>
								<th scope="col">ملاحظة</th>
								<th scope="col">حذف</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($data as $ta)  { ?>
								<tr id="row_db_<?php echo $ta['id'] ?>">
									<td> <?php echo $this->langControl($ta['model']) ?> </td>
									<td> <?php echo $ta['location'] ?> </td>
									<td> <?php echo $ta['code'] ?> </td>
									<td> <?php echo $ta['color'] ?> </td>
									<td> <?php echo $ta['quantity'] ?> </td>
                                    <td>

                                        <?php  if ($ta['listSerial']) {  ?>
                                            <?php  foreach ($ta['listSerial'] as $key => $serial) { ?>
                                                    <span class="badge badge-success d-block mb-1">  <?php echo $serial ?></span>
                                            <?php } ?>
                                        <?php } ?>
                                    </td>
                                    <td>

                                        <?php  if ($ta['listSerial']) {  ?>
                                            <?php  foreach ($ta['listSerial'] as $key => $serial) { ?>
                                                  <input onblur="checkSerialCode(this,'<?php echo  $ta['code'] ?>','<?php echo $ta['model'] ?>')" type="text" name="serial_<?php echo $ta['code'] ?>[]"  autocomplete="off" placeholder="سيريال - <?php  echo $key+1 ?> " class="form-control mb-1"  <?php echo $ta['serial_req'] ?> >
                                            <?php } ?>
                                        <?php } ?>


                                    </td>
                                    <td> <textarea class="form-control" onkeyup="enter_note(this,'<?php echo $ta['id'] ?>','<?php echo $ta['model'] ?>')"><?php echo $ta['note'] ?></textarea> </td>
									<td>  <button  class="btn btn-danger" type="button" onclick="delete_row_loc(<?php echo $ta['id'] ?>)"><i class="fa fa-times"></i> </button> </td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
						<hr>
						<div class="text-center">
							<button  class="btn btn-primary" type="submit"  >حفظ   </button>
						</div>
					<?php  }  ?>
                </div>
                </form>

			</div>
		</div>

	</div>
</div>



<script>


    public_code=0;
    function change_code() {
        var code= $("#location_code").val();
        if (public_code !== code)
        {
            $("#location_quantity").val('0').removeClass('error_quantity');
        }
        public_code=code;

    }




    var select_model=false;
	<?php if ($type_transport) { ?>
    select_model= "<?php   echo $type_transport ?>";
	<?php  } ?>

    $("#insert_location").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

		if ($('#select_model :selected').val()) {

		    if (select_model && select_model !== $('#select_model :selected').val())
			{
			    alert('يرجى اختيار مناقلة من نفس القسم')
			}else {
                var form = $(this);
                var url = form.attr('action');

                var a='';
                if ($('#location_quantity').val()==='0')
                {
                    a='&quantity=1';
                }


                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize() + "&submit=submit"+a, // serializes the form's elements.
                    success: function (data) {

                        if($.isNumeric(data)) {

                            alert(' الموقع موجود في المناقلة غير مؤكده ذات الرقم  ' + data +' يرجى تأكيدها قبل انشاء مناقلة جديده لهذا الموقع ')

                        }else   if (data === '-q') {
                            if ($('#location_quantity').val() === '') {
                                $('#location_quantity').val(0);
                            }
                            $('#location_quantity').val(Number($('#location_quantity').val()) + Number(1)).addClass('error_quantity')

                            $('#location_code').select().val('')

                            $('#alert_over_q').html(`
                           <div    style="margin: 0" class=" alert alert-danger alert-dismissible fade show" role="alert">
                               تم ادخال اكبر من الكمية المرفوعه
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `);


                        }else if(data === 'notSameLocation')
                        {
                            alert('لا يمكن السحب من موقعين مختلفين  لرمز الماده في نفس المناقلة ')
                        } else {
                            $('#location_code').select().val('')
                            $('#location_quantity').val(0).removeClass('error_quantity')
                            $('.resultLocation').html(data)
                            $('#alert_over_q').empty();
                        }

                    }
                });
            }
        }else
		{
		    alert('يرجى اختيار فئة رئيسية')
		}

    });

    function remove_class(e) {
        $(e).removeClass('error_quantity')
    }

    function delete_row_loc(id)
	{
        $.get("<?php echo url . '/' . $this->folder ?>/delete_row_loc/" +id, function (data) {
            if (data==='0')
            {
                $('.resultLocation').empty();
            }
            else
            {
                $('#row_db_'+id).remove();
            }
        });
	}

    function checkSerialCode(e,code,model)
	{
	    if ($(e).val()) {
            $.get("<?php echo url . '/' . $this->folder ?>/checkSerialCode", {
                serial: $(e).val(),
                code: code,
                model: model
            }, function (data) {

                if (data === 'false') {
                    alert('السيريال المدخل ليس من ضمن سيريلات المادة')
                    $(e).css('border', '1px solid red').select().val('');

                }else
                {
                    $(e).css('border', '1px solid #ced4da');
                }

            });
        }
	}


    function enter_note(e,id,model)
    {
        var v=$(e).val();
        $.get("<?php echo url . '/' . $this->folder ?>/enter_note",{id:id,model:model,note:v}, function (data) {

        });
    }



    $("#save_transport").submit(function(e) {
        if (confirm("هل انت متأكد؟")) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var actionUrl = form.attr('action');

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize()+"&submit=submit", // serializes the form's elements.
            success: function(data)
            {
                console.log(data)
                if (data) {
                    alert('تم انشاء مناقلة ذات الرقم :' + data);
                    $('.resultLocation').empty();
                    window.location='<?php echo url .'/'. $this->folder ?>/transport_not_confirm'
                }else
                {
                    alert('حدث خطاء اثناء حفظ المناقلة اعد المحاولة')
                }
            }
        });
        }return false
    });



    //function save_transport()
	//{
	//    if (confirm("هل انت متأكد؟")) {
    //        $.get("<?php //echo url . '/' . $this->folder ?>///save_transport", function (data) {
    //            if (data) {
    //                alert('تم انشاء مناقلة ذات الرقم :' + data);
    //                $('.resultLocation').empty();
    //                window.location='<?php //echo url .'/'. $this->folder ?>///transport_not_confirm'
    //            }else
    //            {
    //                alert('حدث خطاء اثناء حفظ المناقلة اعد المحاولة')
    //            }
    //        });
    //    }return false
	//}
    //



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

            $('#select_model').val(value)


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
    .error_quantity
    {
        background: red;
    }

	.create_transport{

		padding: 5px 13px;
		background: #adc;
		margin-top: 7px;
		margin-bottom: 16px;
		font-size: 22px;
		border-radius: 5px;
	}

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
            $.ajax({
                url:  "<?php  echo url .'/'.$this->folder ?>/checked_purchases_all/<?php echo $model ?>",
                type: 'post',
                cache: false,
                data: $("#checked_purchases_all").serialize(),
                success: function (data) {
                    var response = JSON.parse(data);
                    if(response.done) {
                        alert('تم اضافة المواد المحددة الى المجموعة المحددة')
                        window.location=''
                    }else if (response.error_ch)
                    {
                        alert('يرجى تحديد المواقع')
                    }
                    else if (response.empty)
                    {
                        alert('يرجى تحديد المواقع')
                    }
                }
            })



        });
    });

</script>


<style>

	.add_to_group
	{
		position: relative;
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











