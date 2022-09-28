

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('range_table') ?> </a></li>
                <li class="breadcrumb-item"> <?php  echo $this->langControl('view_content') ?>  </li>
            </ol>
        </nav>

    </div>

</div>


<div class="row">
    <div class="col-lg-9">
        <a  href="<?php echo url .'/'.$this->folder   ?>/add_range_table" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span><?php  echo $this->langControl('add_content') ?>  </span> </a>
    </div>
</div>


<script>

    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_range_table",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[6]);
            },
            "order": [[ 0, 'asc'] ],
            aLengthMenu: [ 10,25, 50, 100,-1],
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
            "columnDefs": [
            { className: "from_amount_cell", "targets": [ 0 ] },
            { className: "to_amount_cell", "targets": [ 1 ] },
            { className: "amount_cell", "targets": [ 2 ] }
        ]

        } );
    } );



</script>


<br>


<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
    <tr>

        <th>من  </th>
        <th> الى  </th>
        <th>  التقريب </th>
        <th><?php  echo $this->langControl("publishing") ?> </th>
        <th><?php  echo $this->langControl("edit") ?> </th>
        <th><?php echo $this->langControl('delete') ?></th>
    </tr>
    </thead>
</table>


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


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-from_amount" id="exampleModalLabel"> </h5>


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
        var from_amount = button.data('from_amount') ;
        var modal = $(this);
        modal.find('.modal-from_amount').text('هل انت متاكد من حذف العنصر ؟ ' );
        modal.find('.modal-body').text(from_amount);
        modal.find('#save').val(recipient)
    });

    $('#save').on('click',function () {
        var  id= $('#save').val();
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_range_table/"+id, function( data ) {
            $('#row_'+id).remove();
            $('#exampleModal').modal('hide')
        });
    });
</script>


<script>


    function visible_range_table(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/visible_range_table/"+vis+'/'+id, function(){ })
    }



</script>





<div class="modal fade" id="exampleModal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"  style="    padding: 6px;" >
                    <span class="col-auto">
                      <?php  echo  $this->langControl('edit') ?>
                    </span>
            </div>
            <div class="modal-body">
                <form id="edit_range_table" action="" method="post">
                    <div class="form-group">
                        <label for="from_amount">  <?php  echo  $this->langControl('from_amount') ?></label>
                        <input type="text" name="from_amount" class="from_amount form-control from_amount_image" id="from_amount"  value="">
                    </div>

                    <div class="form-group">
                        <label for="to_amount">  <?php  echo  $this->langControl('to_amount') ?></label>
                        <input type="number" name="to_amount" class="to_amount form-control to_amount_image" id="to_amount"  value="">
                    </div>

                    <div class="form-group">
                        <label for="amount">  <?php  echo  $this->langControl('amount') ?></label>
                        <input type="number" name="amount" class="amount form-control amount_image" id="amount"  value="">
                    </div>

                    <input name="id" class="id" type="number" hidden >
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
            url: "<?php  echo url . '/' . $this->folder?>/get_range_table/"+id,
            cache: false,
            success: function(data){
                if (data)
                {
                    var  response = JSON.parse(data);
                    modal.find('.id').val(id);
                    modal.find('.from_amount').val(response.from_amount);
                    modal.find('.amount').val(response.amount);
                    modal.find('.to_amount').val(response.to_amount);
                    modal.find('.amount').val(response.amount);

                    modal.find('#edit_range_table').attr("action","<?php  echo url .'/'.$this->folder?>/edit_range_table/"+id);
                }
            }
        });
    });


    $(function () {
        $('#edit_range_table').on('submit', function (e) {
            e.preventDefault();
            data = $('#edit_range_table').serialize()
            $.ajax({
                type: 'post',
                url: this.action,
                data: data,
                success: function () {
                    $('#row_'+$('input[name="id"]').val() + ' td.from_amount_cell').text(($('input[name="from_amount"]').val()));
                    $('#row_'+$('input[name="id"]').val() + ' td.to_amount_cell').text(($('input[name="to_amount"]').val()));
                    $('#row_'+$('input[name="id"]').val() + ' td.amount_cell').text(($('input[name="amount"]').val()));

                    $('#exampleModal_edit').modal('hide')
                }
            });

        });

    });

</script>
