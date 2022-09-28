
<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_wholesale_price/<?php  echo $y ?>",
            info:true,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[12]);
            },
            "order": [[ 7, 'asc'] ],
            aLengthMenu: [ 10,25,75,100,200,-1],
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

            },       <?php  if ($this->permit('export_excel',$this->folder)) { ?>
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            <?php  }  ?>
            bFilter: true, bInfo: true
        } );
    } );
</script>



    <br>

    <div class="row align-items-center">
        <div class="col">
            <span></span>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_registration"><?php  echo $this->langControl('registration') ?> </a></li>
                    <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('wholesale_price') ?>  </li>
                    <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('view_content') ?>  </li>
                </ol>
            </nav>
        </div>
        <div class="col-auto" style="position: relative">
            <a href="<?php  echo url .'/'.$this->folder ?>/all_active_buy">  <i class="fa fa-bell bell_style"> </i>  <span class="number_req" > <?php  echo $this-> all_notification_buy() ?> </span></a>
        </div>
    </div>
<hr>
<form action="<?php  echo url .'/'.$this->folder ?>/subscribers" method="POST">
<div class="row">
        <div class="col-lg-3 col-md-4">
            <select class="custom-select custom-select-sm" name="year" >
                <option value="0" >  اختر سنة </option>
                <?php foreach ($year as $ye)  {     ?>
                    <option value="<?php echo $ye ?>"  <?php  if ($ye == $y) echo 'selected'?>  > <?php   echo $ye ?> </option>
                <?php  }  ?>
            </select>
        </div>

        <div class="col-auto">
            <input type="submit" class="btn btn-primary btn-sm" name="submit" value="بحث">
        </div>
     </div>
</form>
<hr>
    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th><?php  echo $this->langControl('name') ?></th>
                    <th><?php  echo $this->langControl('username') ?></th>
                    <th><?php  echo $this->langControl('phone') ?></th>
                    <th><?php  echo $this->langControl('country') ?></th>
                    <th><?php  echo $this->langControl('city') ?></th>
                    <th><?php  echo $this->langControl('address') ?></th>
                    <th> حساب جملة  </th>
                    <th><?php  echo $this->langControl('date') ?></th>
                    <th><?php  echo $this->langControl('details') ?></th>
                    <th><?php  echo $this->langControl('notification') ?></th>
                    <th><?php  echo $this->langControl('delete') ?></th>
                </tr>
                </thead>

            </table>

        </div>
    </div>


<script>


    function visible_wholesale_price(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url  .'/'. $this->folder?>/visible_wholesale_price/"+vis+'/'+id, function(){ })
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

    .bell_style
    {
        font-size: 33px;
        color: red;
        margin-top: -10px;
    }
.number_req
{
    position: absolute;
    top: -14px;
    width: 25px;
    height: 25px;
    background: #007bff;
    text-align: center;
    left: 4px;
    border-radius: 50%;
    font-weight: bold;
    color: #ffffff;
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
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_registration/"+id, function( e ) {
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

