


<br>

<div class="row">
	<div class="col">
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl($this->folder) ?> </a></li>

			</ol>
		</nav>


		<hr>
	</div>
</div>

<div class="row align-items-end justify-content-between">


    <div class="col-auto">
        <a  href="<?php echo url .'/'.$this->folder ?>/add" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span><?php  echo $this->langControl('add') ?>  </span> </a>
     </div>


</div>


<script>
    $(document).ready(function() {

        var selected = [];

        var t=$('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing/<?php   echo $from_date_stm .'/'.$to_date_stm  ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[1]);
            },



            "order": [[ 0, 'asc'] ],

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



<hr>


<form action="<?php echo url.'/'.$this->folder?>/index" method="get">

    <div class="row align-items-end">
        <div class="col-auto">
            من تاريخ
            <input type="date" name="date" class="form-control" value="<?php  echo $date ?>"  required>
        </div>
        <div class="col-auto">
            الى تاريخ
            <input type="date" name="todate" class="form-control" value="<?php  echo $todate ?>"  required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-warning" >بحث</button>
            <a href="<?php echo url.'/'.$this->folder?>" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
        </div>
    </div>

</form>

<br>

<div class="row">
	<div class="col">


		<table  id="example" class="table table-striped display d-table"  >
			<thead>
			<tr>

				<th> القسم </th>
				<th>   رمز المادة </th>
				<th> الموقع  </th>
				<th> الكمية </th>
				<th> المستخدم </th>
				<th> التاريخ </th>
				<th> ملاحظة </th>

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






<div class="modal fade" id="exampleModal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header"  style="    padding: 6px;" >
                    <span class="col-auto">
                   تعديل الكمية
                    </span>
			</div>
			<div class="modal-body">
				<form id="edit_location" action="" method="post">

					<div class="form-group">
						<label for="quantity">  <?php  echo  $this->langControl('quantity') ?></label>
						<input type="text" name="quantity" class="quantity form-control  " id="quantity"  value="">
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
                    modal.find('.quantity').val(response.quantity);
                    modal.find('#edit_location').attr("action","<?php  echo url .'/'.$this->folder?>/edit/"+id);
                }
            }
        });
    });


    $(function () {
        $('#edit_location').on('submit', function (e) {
            e.preventDefault();
            data = $('#edit_location').serialize()
            $.ajax({
                type: 'post',
                url: this.action,
                data: data,
                success: function (response) {
                    if (response==='-q')
                    {
                        alert('الكمية المدخلة اكبر من الكمية المتوفرة') ;
                    }else
                    {
                        $('#row_'+$('input[name="id"]').val() + ' td.quantity_cell').text(($('input[name="quantity"]').val()));
                        $('#exampleModal_edit').modal('hide')
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



