

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('menu_link_device_acc_cover') ?> </a></li>
                <li class="breadcrumb-item"> <?php  echo $this->langControl('view_content') ?>  </li>
            </ol>
        </nav>

    </div>

</div>


<div class="row">
    <div class="col-lg-9">
        <a  href="<?php echo url .'/'.$this->folder   ?>/add_menu_link_device_acc_cover" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span><?php  echo $this->langControl('add_content') ?>  </span> </a>
        <a  href="<?php echo url .'/'.$this->folder   ?>/excel" role="button"    class="btn btn-warning btn-sm"> <i class="fa fa-file-excel-o" aria-hidden="true"></i>  <span>  رفع ملف اكسيل  </span> </a>
    </div>
</div>


<script>
    var table;
    $(document).ready(function() {

        var selected = [];
        table =   $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_menu_link_device_acc_cover",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "order": [[ 3, 'desc'] ],
            aLengthMenu: [ 10,25, 50, 100,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                sProcessing: " معالجة ...",
                sLengthMenu: "عرض _MENU_ ",
                sSearch: "أبحث",
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


<br>


<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
    <tr>
        <th scope="col">  اسم الجهاز   </th>

        <th scope="col">   اضافة بواسطة  </th>
        <th scope="col">   تعديل  </th>
        <th scope="col">   االتاريخ والوقت  </th>
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
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_menu_link_device_acc_cover/"+id, function( data ) {
            $('#row_'+id).remove();
            $('#exampleModal').modal('hide')
        });
    });
</script>


<script>


    function visible_menu_link_device_acc_cover(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/visible_menu_link_device_acc_cover/"+vis+'/'+id, function(){ })
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
                <form id="edit_menu_link_device_acc_cover" action="" method="post">
                    <div class="form-group">
                        <label for="name_device">   اسم الجهاز</label>
                        <input type="text" name="name_device" class="name_device form-control name_device_image" id="name_device"  value="">
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
            url: "<?php  echo url . '/' . $this->folder?>/get_menu_link_device_acc_cover/"+id,
            cache: false,
            success: function(data){
                if (data)
                {
                    var  response = JSON.parse(data);
                    modal.find('.id').val(id);
                    modal.find('.name_device').val(response.name_device);
                    modal.find('#edit_menu_link_device_acc_cover').attr("action","<?php  echo url .'/'.$this->folder?>/edit_menu_link_device_acc_cover/"+id);
                }
            }
        });
    });


    $(function () {
        $('#edit_menu_link_device_acc_cover').on('submit', function (e) {
            e.preventDefault();
            data = $('#edit_menu_link_device_acc_cover').serialize()
            $.ajax({
                type: 'post',
                url: this.action,
                data: data,
                success: function () {

                    table.draw()

                     $('#exampleModal_edit').modal('hide')
                }
            });

        });

    });

</script>
