

<script>
    var  table;
    $(document).ready(function() {

 

       table= $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url ?>/savers/processing_type_device",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[7]);
            },
            "order": [[ 2, 'desc'] ],
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
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_savers"><?php  echo $this->langControl('savers') ?> </a></li>

                    <li class="breadcrumb-item active" aria-current="page" >  عرض الاجهزة  </li>

                </ol>
            </nav>


            <hr>
        </div>
    </div>

<div class="row">

    <div class="col-lg-9">
        <a  href="<?php echo url ?>/savers/add_type_device" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span><?php  echo $this->langControl('add_content') ?>  </span> </a>

    </div>
</div>

<hr>
    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th>عنوان</th>
                    <th> الجهاز المربوط</th>
                    <th><?php  echo $this->langControl('date') ?></th>
                    <th>الحالة</th>

                    <th>تعديل</th>
                    <th>حذف</th>
                    <th>المستخدم</th>

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
        $.get( "<?php echo url ?>/savers/delete_savers_type_device/"+id, function( data ) {
            table.draw();
            $('#exampleModal').modal('hide')
        });
    });
 </script>


<script>


    function visible_savers(e,id) {

        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url ?>/savers/visible_savers_type_device/"+vis+'/'+id, function(data){
            console.log(data)
        })
    }



</script>
