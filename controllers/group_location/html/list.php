

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('group_location') ?> </a></li>
                <li class="breadcrumb-item"> <?php  echo $this->langControl('view_content') ?>  </li>
            </ol>
        </nav>

    </div>

</div>


<div class="row">
    <div class="col-lg-9">
        <a  href="<?php echo url .'/'.$this->folder   ?>/add_group_location" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span><?php  echo $this->langControl('add_content') ?>  </span> </a>
    </div>
</div>


<script>
    $(document).ready(function() {

        var selected = [];
        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_group_location",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[6]);
            },

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
            ,
            "columnDefs": [
                { className: "title_cell", "targets": [ 0 ] },
                { className: "from_cell", "targets": [ 1 ] },
                { className: "to_cell", "targets": [ 2 ] },
            ]
        } );
    } );
</script>


<br>


<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
    <tr>
        <th scope="col"> العنوان </th>
        <th scope="col">    من  </th>
        <th scope="col">    الى </th>
        <th scope="col">    الحالة </th>
        <th scope="col">    تعديل  </th>
        <th scope="col">    حذف  </th>
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
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_group_location/"+id, function( data ) {
            $('#row_'+id).remove();
            $('#exampleModal').modal('hide')
        });
    });
</script>


<script>


    function visible_group_location(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/visible_group_location/"+vis+'/'+id, function(){ })
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
                <form id="edit_group_location" action="" method="post">
                    <div class="form-group">
                        <label for="title">  <?php  echo  $this->langControl('title') ?></label>
                        <input type="text" name="title" class="title form-control title_image" id="title"  value="">
                    </div>
                    <div class="form-group">
                        <label for="from">  من موقع  </label>
                        <input type="text" name="from" class="from form-control title_image" id="from"  value="">
                    </div>
                    <div class="form-group">
                        <label for="to">  الى موقع  </label>
                        <input type="text" name="to" class="to form-control title_image" id="to"  value="">
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
            url: "<?php  echo url . '/' . $this->folder?>/get_group_location/"+id,
            cache: false,
            success: function(data){
                if (data)
                {
                    var  response = JSON.parse(data);
                    modal.find('.id').val(id);
                    modal.find('.title').val(response.title);
                    modal.find('.from').val(response.from);
                    modal.find('.to').val(response.to);
                    modal.find('#edit_group_location').attr("action","<?php  echo url .'/'.$this->folder?>/edit_group_location/"+id);
                }
            }
        });
    });


    $(function () {
        $('#edit_group_location').on('submit', function (e) {
            e.preventDefault();
            data = $('#edit_group_location').serialize()
            $.ajax({
                type: 'post',
                url: this.action,
                data: data,
                success: function () {
                    $('#row_'+$('input[name="id"]').val() + ' td.title_cell').text(($('input[name="title"]').val()));
                    $('#row_'+$('input[name="id"]').val() + ' td.from_cell').text(($('input[name="from"]').val()));
                    $('#row_'+$('input[name="id"]').val() + ' td.to_cell').text(($('input[name="to"]').val()));
                    $('#exampleModal_edit').modal('hide')
                }
            });

        });

    });

</script>
