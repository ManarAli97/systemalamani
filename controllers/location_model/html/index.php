


<br>

<div class="row">
	<div class="col">
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_location/<?php  echo $model?>"><?php  echo $this->langControl($this->folder) ?> </a></li>
				<li class="breadcrumb-item active" aria-current="page" >  <?php  echo $model?></li>
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
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing/<?php  echo $model ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[5]);
            },

            "columnDefs": [
                { className: "sequence_cell", "targets": [ 0 ] },
            ],

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
		<a class="btn btn-primary" href="<?php  echo url .'/'.$this->folder ?>/add/<?php  echo $model ?>"> <i class="fa fa-plus"> <span>  رفع Excel </span></i>     </a>
	</div>

    <div class="col-auto">
        <input <?php  echo $this->check_location($model) ?> class='toggle-demo' onchange='active_location(this)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'> تفعيل / الغاء تفعيل المواقع
    </div>

    <script>
        function active_location(e) {
            var vis=$(e).is( ':checked' )? 1:0;
            $.get("<?php echo url .'/'.$this->folder ?>/active_location/<?php echo $model ?>/"+vis, function(){ })
        }
    </script>


    <div class="col-auto">
        <?php 	if ($this->permit('delete_all_location', $this->folder)) { ?>
            <div class="text-left">
                <button class="btn btn-danger" onclick="delete_all('<?php  echo $model ?>')"> <i class="fa fa-trash"></i> <span>حذف الكل</span></button>
            </div>

        <?php }  ?>
    </div>

</div>

<hr>

<form id="idForm" action="<?php  echo url .'/'.$this->folder ?>/lct/<?php  echo $model ?>" method="post">
	<div class="row align-items-end">



		<div class="col-auto">
			<label>الموقع</label>
			<input style="width: 150px" type="text" class=" form-control" name="location" required autocomplete="off">
		</div>



        <div class="col-auto">
            <label>التسلسل</label>
            <input style="width: 150px" type="number" class=" xdata form-control" name="sequence" required autocomplete="off">
        </div>


        <div class="col-auto">
			<button  class="btn btn-primary  btn-sm"  type="submit" >حفظ</button>
		</div>

	</div>

</form>
<script>
    $("#idForm").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {

                if (data==='1')
                {
                    $('.xdata').val('')
                    alert('تم تحديث الموقع')
                    window.location=''

                }else if (data==='2') {
                    $('.xdata').val('')
                    alert('تمت الاضافة  ')
                    window.location=''
                }else {
                    alert('حدث خطأ اعد المحاولة')
                }
            }
        });


    });
</script>

<hr>
<div class="row">
	<div class="col">


		<table  id="example" class="table table-striped display d-table"  >
			<thead>
			<tr>



				<th> التسلسل </th>
				<th>  المواقع </th>
                <th>  القسم   </th>
                <th>   تعديل  التسلسل   </th>
                <th> حذف </th>

			</tr>
			</thead>

		</table>

	</div>
</div>







<div class="modal fade" id="exampleModal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"  style="    padding: 6px;" >
                    <span class="col-auto">
                   تعديل  التسلسل
                    </span>
            </div>
            <div class="modal-body">
                <form id="edit_location" action="" method="post">

                    <div class="form-group">
                        <label for="sequence_id">  <?php  echo  $this->langControl('sequence') ?></label>
                        <input type="text" name="sequence" class="sequence_class form-control  " id="sequence_id" autocomplete="off"  >
                    </div>
                    <input name="id" class="id_location" type="hidden"    >
                    <div class="modal-footer">
                        <input class="btn btn-primary" type="submit" name="submit" value="<?php  echo $this -> langControl('save')?>">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php  echo $this -> langControl('close')?></button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    $('#exampleModal_edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');

        var modal = $(this);
        $.ajax({
            url: "<?php  echo url . '/' . $this->folder?>/get_location_edit/"+id,
            cache: false,
            success: function(data){
                if (data)
                {

                    var  response = JSON.parse(data);
                    modal.find('.id_location').val(id);
                    modal.find('.sequence_class').val(response.sequence);
                    modal.find('#edit_location').attr("action","<?php  echo url .'/'.$this->folder?>/edit/"+id);
                }
            }
        });
    });


    $(function () {
        $('#edit_location').on('submit', function (e) {
            e.preventDefault();
            var val=$("#sequence_id").val();
            data = $('#edit_location').serialize()
            $.ajax({
                type: 'post',
                url: this.action,
                data: data,
                success: function (response) {
                    if (response)
                    {
                        $('#row_'+$('input[name="id"]').val() + ' td.sequence_cell').text(val);
                        $('#exampleModal_edit').modal('hide')
                    }else {
                        alert('حدث خطأ اعد المحاوله؟')
                    }

                }
            });

        });

    });

</script>








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




