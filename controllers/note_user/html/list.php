

<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing/<?php echo $id ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[3]);
            },
            "order": [[ 2, 'DESC'] ],
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
            <span></span>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/note_user"><?php  echo $this->langControl('note_user') ?> </a></li>

                    <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('view_content') ?>  </li>
                </ol>
            </nav>


            <hr>
        </div>
    </div>

<div class="row">
    <div class="col-auto">

        <div class="form-group select_drop"  style="width: 100%" >
            <select  onchange="location = this.value;"   class="form-control"  >
                <option value="<?php  echo url.'/'.$this->folder?>/list_note_user/0"   > عرض الكل </option>

                <?php foreach ($group as $list_cat)  {     ?>
                    <option value="<?php  echo url.'/'.$this->folder?>/list_note_user/<?php   echo $list_cat['id'] ?>"  <?php   if ($list_cat['id'] == $id)  echo 'selected'?>    > <?php   echo $list_cat['name'] ?> </option>
                <?php  }  ?>

            </select>
        </div>

    </div>

</div>

<hr>
    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>

                    <th>  الزبون </th>
                    <th> المهنة </th>
                    <th><?php  echo $this->langControl('phone') ?></th>
                    <th><?php  echo $this->langControl('city') ?></th>
                    <th><?php  echo $this->langControl('address') ?></th>
                    <th>  الجنس </th>
                    <th>  تاريخ الميلاد </th>
                    <th>الملاحظة</th>
                    <th> التاريخ</th>
                </tr>
                </thead>

            </table>

        </div>
    </div>


<div class="modal fade" id="exampleModalnote_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> ملاحظات حول الزبون </h5>
            </div>
            <div class="modal-body">
                <div class="table_note"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  data-dismiss="modal">خروج</button>

            </div>
        </div>
    </div>
</div>

<script>


    function get_note(id) {

        $('#exampleModalnote_customer').modal('show');
        $.get("<?php echo url  .'/'.$this->folder ?>/get_note_customer/"+id, function(data){

            if (data)
            {
                $('.table_note').html(data);

            }
        })

    }

    </script>
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
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_note_user/"+id, function( e ) {
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
        $.get("<?php echo url .'/'.$this->folder ?>/visible_note_user/"+vis+'/'+id, function(e){
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
