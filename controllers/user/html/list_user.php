<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url .'/'.$this->folder?>/group"><?php  echo $this->langControl('group_user') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page"> <?php  echo $data[0]['name']?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>



<div class="row">
    <div class="col-lg-9">
        <a  href="<?php echo url .'/'.$this->folder ?>/add/<?php echo $id ?>" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-user" aria-hidden="true"></i>  <span>   اضافة مستخدم  </span> </a>
    </div>
</div>

<hr>

 <script>



     $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url ?>/user/processing/<?php echo $id?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[14]);
            },
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


            }
        } );
    } );
</script>


    <br>

    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th>  اسم المستخدم</th>
                    <!-- <th> الرمز </th> -->
                    <th>الدور</th>
                    <th>المجموعة</th>
                    <th>QR</th>
                    <th>رقم الموظف</th>
                    <th>  الطابعة  </th>
                    <th>تعديل سعر مواد الفاتورة</th>
                    <th>     تفعيل الحساب </th>
                    <th>    جرد وتصحيح كميات المواقع    </th>
                    <th>    حذف السيريلات المعرفة المبيوعة    </th>
                    <th><?php  echo $this->langControl("edit") ?> </th>
                    <th><?php echo $this->langControl('delete') ?></th>
                    <th>التصاريح</th>


                </tr>
                </thead>

            </table>

        </div>
    </div>

<style>
    .money_box
    {
        display: none;
    }

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
    .p_nm
    {
        margin: 0;
    }
    .menu_user
    {
        padding: 0 .75rem;
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
        var role = button.data('role') ;
        var modal = $(this);

            modal.find('.modal-title').text('<?php  echo $this->langControl("are_you_sure") ?> ? ' );
            modal.find('#save').css('display','block')

        modal.find('.modal-body').text(title);
        modal.find('#save').val(recipient)
    });

    $('#save').on('click',function () {
            var  id= $('#save').val();
            $.get( "<?php echo url ?>/user/delete/"+id, function( data ) {
                $('#row_'+id).remove();
                $('#exampleModal').modal('hide')
            });

    });



    function visible_edit_price(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/visible_edit_price/"+vis+'/'+id, function(){ })
    }



    function active(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/active/"+vis+'/'+id, function(){ })
    }


    function jard_and_correction(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/jard_and_correction/"+vis+'/'+id, function(){ })
    }


    function delete_serial_sale(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/delete_serial_sale/"+vis+'/'+id, function(){ })
    }



</script>

