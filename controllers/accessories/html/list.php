
<script>
    var table;
    $(document).ready(function() {

        var selected = [];

        table= $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url ?>/accessories/processing/<?php echo $id  ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[8]);
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
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/admin_category"><?php  echo $this->langControl('accessories') ?> </a></li>
                    <?php if ($breadcumbs){ foreach ($breadcumbs as $key => $bc) {   ?>
                        <li class="breadcrumb-item"><a href="<?php  echo $bc ?>"><?php echo $key ?></a></li>
                    <?php  } } ?>
                    <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('view_content') ?>  </li>

                </ol>
            </nav>


            <hr>
        </div>
    </div>

<div class="row">
    <div class="col-auto">

        <div class="form-group select_drop"  style="width: 100%" >
            <select  onchange="location = this.value;"  class="selectpicker"  aria-expanded="false"  data-live-search="true"  >
                <?php foreach ($data_cat as $list_cat)  {     ?>
                    <option value="<?php  echo url.'/'.$this->folder?>/list_<?php  echo  $this->folder   ?>/<?php   echo $list_cat['id'] ?>"  <?php   echo $list_cat['selected'] ?>   > <?php   echo $list_cat['title'] ?> </option>
                <?php  }  ?>

            </select>
        </div>

    </div>
    <div class="col-lg-9">
        <a  href="<?php echo url ?>/accessories/add_accessories/<?php echo $id ?>" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span><?php  echo $this->langControl('add_content') ?>  </span> </a>
        <a  href="<?php  echo url  ?>/accessories/admin_category"  role="button"   class="btn btn-warning btn-sm"> <i class="fa fa-list" aria-hidden="true"></i> <span><?php  echo $this->langControl('show_category') ?> </span></a>
        <a  href="<?php  echo url  ?>/accessories/add_category"  role="button"   class="btn btn-info btn-sm">  <i class="fa fa-folder-open-o" aria-hidden="true"></i>  <span><?php  echo $this->langControl('add_category') ?>   </span></a>

    </div>
</div>

<hr>
    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th>عنوان</th>
                    <th>التفاصيل</th>
                    <th><?php  echo $this->langControl('date') ?></th>
                    <th>الحالة</th>
                    <th>عدد المشاهدات</th>
                    <th>تعديل</th>
                    <th>تكرار</th>
                    <th>حذف</th>

                </tr>
                </thead>

            </table>

        </div>
    </div>



<script>

    function copy_row(id) {

        if (confirm('هل انت متأكد؟'))
        {
            $.get("<?php  echo url.'/'.$this->folder?>/copy_row/"+id, function(data){
                if (data)
                {
                    alert('تم التكرار')
                    table.draw()

                }
            })
        }

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
        $.get( "<?php echo url ?>/accessories/delete_accessories/"+id, function( data ) {
            console.log(data);
            if(data == 1){
                $('#row_'+id).remove();
                $('#exampleModal').modal('hide');
            }else{
                    alert('لا يمكن حذف الباركود لانه يحتوي على كمية');
            }
        });
    });


    function visible_accessories(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url ?>/accessories/visible_accessories/"+vis+'/'+id, function(){ })
    }



</script>
