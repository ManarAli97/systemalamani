

<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing/<?php  echo  $string ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "order": [[ 5, 'desc'] ],
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
        } );
    } );
</script>



    <br>

    <div class="row">
        <div class="col">
            <span></span>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page" > <a href="<?php  echo url .'/'.$this->folder ?>/list_trace"> <?php  echo $this->langControl('trace')?> </a> </li>


                </ol>
            </nav>


            <hr>
        </div>
    </div>


<form action="<?php echo url.'/'.$this->folder?>/list_trace" method="get">

    <div class="row   justify-content-between">
        <div class="col-auto">
           اسم الموظف
            <input type="text" name="username"  value="<?php echo $username ?>" class="form-control">
        </div>

        <div class="col-auto">

            <div class="row">
                <div class="col-auto">
                    من تاريخ
                    <input  type="datetime-local"     data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر"  name="fromdate" class="form-control" value="<?php  echo $fromdate ?>"  >
                </div>
                <div class="col-auto">
                    الى تاريخ
                    <input  type="datetime-local"     data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر"  name="todate" class="form-control" value="<?php  echo $todate ?>"  >
                </div>
            </div>

        </div>


        <div class="col-12 text-center">
            <hr>
            <button type="submit" class="btn btn-warning" >بحث</button>
            <a href="<?php echo url.'/'.$this->folder?>" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
        </div>
    </div>

</form>

<br>
<hr>
    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th>اسم الادمن</th>
                    <th>  رقم الفاتورة </th>
                    <th>  الجدول </th>
                    <th>  العملية </th>
                    <th>  الملاحظة </th>
                    <th>  التاريخ </th>
                    <th>  التفاصيل </th>
                     
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
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_trace/"+id, function( e ) {
            if (e !=='true')
            {
                window.location='<?php  echo url ."/login/user"?>'
            }else
            {
                $('#row_'+id).remove();
                $('#exampleModal').modal('hide')
            }

        });
    });
 </script>


<script>


    function visible_news(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/visible_trace/"+vis+'/'+id, function(e){
            if (e !=='true')
            {
                window.location='<?php  echo url ."/login/user"?>'
            }
        })
    }

    function visible_special(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/visible_special/"+vis+'/'+id, function(e){
            if (e !=='true')
            {
                window.location='<?php  echo url ."/login/user"?>'
            }
        })
    }
    function send_notification(id) {

        if (confirm('هل انت متأكد من ارسال الاشعار'))
        {
            $.get("<?php echo url .'/'.$this->folder?>/send_notification_to_app/"+id, function(a){ console.log(a)  })

        }

    }

</script>
