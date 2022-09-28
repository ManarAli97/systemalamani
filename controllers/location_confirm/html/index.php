

<br>

<div class="row">
	<div class="col">
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/view/<?php echo $model?>"><?php  echo $this->langControl($this->folder) ?> </a></li>
				<li class="breadcrumb-item active" aria-current="page" >  <?php  echo $this->langControl($model) ?></li>
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
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing/<?php echo $model?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[7]);
            },

            "order": [[ 5, 'desc'] ],
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

<div class="row justify-content-between">
	<div class="col-auto">
		<a class="btn btn-primary" href="<?php  echo url .'/'.$this->folder ?>/add/<?php echo $model?>"> <i class="fa fa-plus"> <span>  رفع Excel </span></i>     </a>
	</div>
	<div class="col-auto">
       <input <?php  echo $this->check_location($model) ?> class='toggle-demo' onchange='active_location(this)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'> تفعيل / الغاء تفعيل المواقع
    </div>
    <?php  if ($this->permit('delete_all_'.$model,$this->folder)) {   ?>

    <div class="col-auto">
        <button     onclick='remove_all()' type='button' class="btn btn-danger" >  حذف الكل  </button>
    </div>

    <?php } ?>
    <script>
        function active_location(e) {
            var vis=$(e).is( ':checked' )? 1:0;
            $.get("<?php echo url .'/'.$this->folder ?>/active_location/<?php echo $model ?>/"+vis, function(){ })
        }



        function remove_all() {

            if (confirm('هل انت متأكد؟'))
            {
                $.get( "<?php echo url .'/'.$this->folder ?>/remove_all",{model:'<?php  echo $model ?>'}, function( data ) {
                    if (data)
                    {
                        window.location=''
                    }else {
                        alert('لا يمكن حذف الكل');
                    }
                });
            }

        }

    </script>
</div>

<hr>

    <form id="idForm"   method="post">
        <div class="row align-items-end">
            <div class="col-auto" style="position: relative">
                <label>الموقع</label>
                <input  type="text" oninput="send_data_location()"  onclick="select()" id="location_get" class=" form-control" name="location" placeholder="الموقع"   autocomplete="off">
            <div class="list_location"></div>
            </div>

            <div class="col-auto">
                <label>الباركود</label>
                <input style="width: 150px" id="filed-code"   oninput="get_info_code()"  type="text" class=" xdata form-control" name="code" required autocomplete="off">
            </div>

            <div class="col-auto">
                <label>الكمية</label>
                <input style="width: 150px" id="filed-q"    oninput="remove_class(this)"  type="text" class=" xdata form-control" name="q"   autocomplete="off">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary" >حفظ</button>
            </div>
            <div class="col-auto" id="alert_over_q">

             </div>
        </div>
     </form>

  <div class="result"></div>

<script>



    function convert_quantity_from_excel_conform()
    {

        var modal="<?php  echo $model ?>"
        var code=$('#filed-code').val();

        $.get("<?php echo url . '/' . $this->folder ?>/convert_quantity_from_excel_conform", {model: modal,code:code}, function (data) {
            console.log(data)
            if (data ==='true') {
                get_info_code()
                setTimeout(function () {
                    $('.convert_quantity .btn').html("<i class='fa fa-check-circle'></i>").css('background',"#28a745");

                },500)
            }else
            {
                alert('حدث خطأ اعد المحاوله ')
            }

        });

    }


    $("#location_get").focusout(function(){
        setTimeout(function () {
            $('.list_location').hide()

        },500)
    });


    function remove_class(e) {
        $(e).removeClass('error_quantity')
        $('#alert_over_q').empty();
    }


    location_in='';
    public_code=0;
    function get_info_code() {
        var code= $("#filed-code").val();
        if (public_code !== code)
        {
            $("#filed-q").val('').removeClass('error_quantity');
        }
        public_code=code;
        if (code) {
            $.get("<?php   echo url . '/' . $this->folder?>/get_info_code/<?php echo $model?>", {code: code}, function (data) {
                if (data)
               {
                   $(".result").html(data);
               }

            });
        }else
        {
           // $(".result").empty()
        }

    }

    function get_info_code2(code) {

        $.get("<?php   echo url . '/' . $this->folder?>/get_info_code/<?php echo $model?>", {code: code}, function (data) {
            if (data)
            {
                $(".result").html(data);
            }

        });


    }


    $("#idForm").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        location_in=$('#location_get').val();

        if (location_in) {
            var c = $("#filed-code").val();
            var q = $("#filed-q").val();

            if (c && location_in) {

                $.post("<?php  echo url . '/' . $this->folder ?>/lct/<?php echo $model?>", {
                    location: location_in,
                    code: c,
                    q: q
                }, function (data) {


                    if (data) {

                        if (data === '1') {
                            get_info_code()
                            $("#filed-code").select().val('');
                            $("#filed-q").val('').removeClass('error_quantity');
                            $('#alert_over_q').empty();
                        } else if (data === 'not_found') {
                            alert('الموقع  غير موجود من ضمن مواقع القسم ')
                        } else if (data === 'q') {
                            $("#filed-code").select().val('');
                            if ($('#filed-q').val() === '') {
                                $('#filed-q').val(0).val(Number($('#filed-q').val()) + Number(1)).addClass('error_quantity')
                            } else {
                                $('#filed-q').val(Number($('#filed-q').val()) + Number(1)).addClass('error_quantity')
                            }

                            $('#alert_over_q').html(`
                           <div    style="margin: 0" class=" alert alert-danger alert-dismissible fade show" role="alert">
                        تم ادخال اكبر من الكمية المرفوعه
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `)

                            get_info_code2(c)

                        } else if (data === 'insert_code_to_location_conform') {
                            //  alert(' تم اضافة رمز المادة الى مواد بتظار تأكيد مواقعها ')
                            $("#filed-code").select().val('');
                            $("#filed-q").val('');
                            $('#alert_over_q').empty();

                        } else if (data === '-l') {
                            alert('الموقع غير مدخل لهذا الباركود ')
                        } else {
                            alert('حدث خطأ اعد المحاولة')
                        }
                    }
                });

            }
        }else {
            $("#filed-code").val('');
            $('#location_get').select().val('');

        }

    });


    function send_data_location() {

        if ($('#location_get').val())
        {
            $.get( "<?php  echo url .'/'. $this->folder ?>/search_location",{model:'<?php echo $model ?>',location:$('#location_get').val()}, function( data ) {
                if (data)
                {
                    $('.list_location').html(data).show()
                }else
                {
                    $('.list_location').hide().empty()
                }
            });

        }else {
            $('.list_location').hide().empty()

        }


    }

    function print_location(e) {
        $('#location_get').val($(e).text())
        $('.list_location').hide().empty()
    }


</script>

<hr>
<div class="row">
	<div class="col">


		<table  id="example" class="table table-striped display d-table"  >
			<thead>
			<tr>



				<th> القسم </th>
                <th>اسم المادة</th>
                <th>  الباركود </th>
				<th>  سعر الدولار </th>
				<th> الكمية </th>
				<th> التاريخ </th>
				<th> حذف </th>

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




