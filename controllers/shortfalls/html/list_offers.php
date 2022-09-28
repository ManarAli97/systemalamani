
<script>
    var  table;
    $(document).ready(function() {

        var selected = [];

        table =    $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[5]);
            },
            "order": [[ 4, 'desc'] ],
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
                    <li class="breadcrumb-item"> <?php  echo $this->langControl('shortfalls') ?>  </li>

                    <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('view_content') ?>  </li>
                </ol>
            </nav>


            <hr>
        </div>
    </div>
<div class="row justify-content-between">
    <?php  if ($this->permit_shortfalls($this->userid,1)) {  ?>

        <div class="col-auto">
        <a  href="<?php echo url .'/'.$this->folder ?>/employee" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span><?php  echo $this->langControl('add_content') ?>  </span> </a>
    </div>
    <?php  } ?>
    <div class="col-auto">
        <?php 	if ($this->permit('delete_all', $this->folder)) { ?>
            <div class="text-left">
                <button class="btn btn-danger  btn-sm" onclick="delete_all()"> <i class="fa fa-trash"></i> <span>حذف الكل</span></button>
            </div>

        <?php }  ?>
    </div>
</div>

    <script>
        function delete_all() {

            if (confirm('هل انت متأكد؟'))
            {
                $.get( "<?php echo url .'/'.$this->folder ?>/delete_all", function( data ) {
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


<hr>
    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                      <th>تسلسل</th>
                    <th> اسم المادة </th>
                    <th> القسم </th>
                    <th>رمز المادة</th>
                    <th>صورة</th>
                    <th>الموظف</th>
                    <th><?php  echo $this->langControl('date') ?></th>
                    <th>حذف</th>
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
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_shortfalls/"+id, function( e ) {
            if (e !=='true')
            {
                window.location='<?php  echo url ."/login/user"?>'
            }else
            {
                table.draw();
                $('#exampleModal').modal('hide')
            }

        });
    });
 </script>


<script>


    function visible_news(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/visible_shortfalls/"+vis+'/'+id, function(e){
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
