

<script>
    var table;
    $(document).ready(function() {


          table= $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_material",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "order": [[ 3, 'desc'] ],
            aLengthMenu: [ -1, 10,25, 50, 100],
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
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_serial_system"><?php  echo $this->langControl('serial_system') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" >    جرد المواد  </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row">

    <div class="col-auto">
        <a  href="<?php echo url .'/'.$this->folder?>/add_report_serial_entry" role="button"    class="btn btn-primary "> <i class="fa fa-plus" aria-hidden="true"></i>  <span> انشاء صفحة </span> </a>
    </div>

</div>



<hr>


        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th>   القسم    </th>
                <th>  اسم المادة </th>
                <th>  رمز المادة  </th>
                <th>   اللون </th>
                <th>   الذاكرة </th>
                <th>    الكمية المضروبة </th>
                <th> الكمية الحالية </th>
                <th> الوقت المستغرق </th>
                <th>تاريخ والوقت </th>
                <th>   حذف </th>


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

    function get_serial(code,model) {

        $.get("<?php  echo url.'/'.$this->folder?>/get_serial/"+code+'/'+model, function(data){
           if (data)
           {
               $('#data_collapse_'+code+model).html(data)
           }
        })
    }

    function  delete_serial(id) {

        if (confirm('هل انت متأكد؟'))
        {
            $.get("<?php  echo url.'/'.$this->folder?>/delete_serial/"+id, function(data){
                if (data==='true')
                {
                    $('#serial_'+id).remove()
                }else
                {
                    alert('لا يمكن حذف السيريال تم بيعة')
                }
            })
        }return false;


    }


    function  get_serial_by_code(code,model) {

        if (confirm('هل انت متأكد؟'))
        {
            $.get("<?php  echo url.'/'.$this->folder?>/get_serial_by_code/"+code+"/"+model, function(data){
                if (data)
                {
                    table.draw();
                }
            })
        }return false;


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


<style>
    .list_serial {
        border-bottom: 1px solid #dfdfdf;
        position: relative;
    }
    .list_serial:last-child {
        border-bottom: 0;
    }

    .list_serial span {
        position: absolute;
        left: 0;
        width: 20px;
        height: 20px;
        color: red;
        font-size: 19px;
        cursor: pointer;
    }
</style>





