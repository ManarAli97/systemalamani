

<script>
    var table;
    $(document).ready(function() {

        var selected = [];

        table=  $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing/<?php echo $id ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "order": [[ 0, 'asc'] ],
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

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_page_serial_system"><?php  echo $this->langControl('serial_system') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" > توليد سيريلات  </li>
                <li class="breadcrumb-item active" aria-current="page" >  <span>رقم الصفحة </span>  <?php  echo $id ?> </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row justify-content-between">

    <div class="col-auto">
        <a  href="<?php echo url .'/'.$this->folder?>/generation/<?php  echo  $id ?>" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span> توليد سيريالات  </span> </a>
        <a   href="<?php echo url .'/'.$this->folder?>/print_serial/<?php  echo  $id ?>"   role="button"    class="btn btn-warning btn-sm"> <i class="fa fa-print" aria-hidden="true"></i>  <span>  طباعة السيريلات </span> </a>
    </div>

    <div class="col-auto">
        <?php 	if ($this->permit('delete_serial_code', $this->folder)) { ?>

                 <button class="btn btn-warning  btn-sm" data-toggle="modal" data-target="#delete_exampleModal" > <i class="fa fa-trash"></i> <span>حذف مخصص  </span></button>


        <?php }  ?>
        <?php 	if ($this->permit('delete_all', $this->folder)) { ?>
                 <button class="btn btn-danger  btn-sm" onclick="delete_all()"> <i class="fa fa-trash"></i> <span>حذف الكل</span></button>

        <?php }  ?>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="delete_exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> حذف سيريلات رمز المادة  </h5>

            </div>
            <div class="modal-body">
                <label>رمز المادة</label>
                <input type="text" id="code" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" onclick="delete_code()" class="btn btn-danger">حفظ</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">خروج</button>
            </div>
        </div>
    </div>
</div>
<script>
    function delete_all() {

        if (confirm('هل انت متأكد؟'))
        {
            $.get( "<?php echo url .'/'.$this->folder ?>/delete_all/<?php echo $id ?>", function( data ) {
                if (data)
                {
                    window.location=''
                }else {
                    alert('فشل الحذف')
                }
            });
        }



    }

    function delete_code() {

        var code = $('#code').val()
        if(code) {

            if (confirm('هل انت متأكد؟')) {
                $.get("<?php echo url . '/' . $this->folder ?>/delete_code/" + code, function (data) {
                    if (data) {
                        $('#delete_exampleModal').modal('hide')
                        table.draw();
                    } else {
                        alert('فشل الحذف')
                    }
                });
            }

        }else
        {

            $('#code').select().css('border','1px solid red')
        }

    }

</script>

<hr>


        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th> رقم الصفحة </th>
                <th> الباركود </th>
                <th> السيريال </th>
                <th> طول السيريال</th>
                <th> المستخدم </th>
                <th>تاريخ التوليد</th>


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



<script>

    function active_serial_system(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php  echo url.'/'.$this->folder?>/active_serial_system/"+vis+'/'+id, function(data){
           if (data !== 'true')
           {
               window.location="<?php  echo url ?>/login/user"
           }
        })
    }

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
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo $this->langControl('close') ?></button>
                <button type="button" value="" id='save' class="btn btn-danger"><?php echo $this->langControl('delete') ?> </button>
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
        modal.find('.modal-title').text('<?php  echo $this->langControl("are_you_sure") ?> ? ' );
        modal.find('.modal-body').text(title);
        modal.find('#save').val(recipient)
    });

    $('#save').on('click',function () {
        var  id= $('#save').val();
        console.log(id)
        $.get( "<?php echo url .'/'. $this->folder ?>/delete_serial_system/"+id, function( data ) {
            if (data === 'true') {
                $('#row_' + id).remove();
                $('#exampleModal').modal('hide')
            }else
            {
                window.location="<?php  echo url ?>/login/user"
            }
        });
    });
</script>








