

<script>
    $(document).ready(function() {


        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            if (i===0 || i===1   || i===6  ) {
                $(this).html('<input class="form-control" type="text" placeholder="بحث" />');

                $('input', this).on('keyup change', function () {
                    console.log(this.value)
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }else
            {
                $(this).html('');

            }

        } );
        var table= $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_report_serial_entry",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "order": [[ 0, 'desc'] ],
            aLengthMenu: [ 10,25, 50, 100,-1],
            orderCellsTop: true,
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
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_report_serial_entry"><?php  echo $this->langControl('serial_system') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('list') ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row">
    <div class="col-auto">
        <a href="<?php echo url .'/'.$this->folder?>/serial_material_inventory"    class="btn btn-warning btn-sm"> <i class="fa fa-table" aria-hidden="true"></i>  <span>   جرد السيريالات   </span> </a>
    </div>

    <div class="col-auto">
        <button  role="button"  onclick="creat_page_jard()"   class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span> انشاء صفحة </span> </button>
    </div>

</div>

<script>

    function creat_page_jard() {
        if (confirm('انشاء صفحة جديدة ؟'))
        {
            $.get( "<?php echo url .'/'.$this->folder?>/creat_page_serial", function( data ) {
                console.log(data)
                window.location="<?php echo url .'/'.$this->folder?>/add_report_serial_entry/"+data
            });
        }return false

    }

</script>


<hr>


        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th> رقم الصفحة </th>

                <th> المستخدم </th>
                <th> الوقت المستغرق </th>
                <th>تاريخ  </th>
                <th>تعديل (فعال خلال 24 ساعة فقط)  </th>


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








