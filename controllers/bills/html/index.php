<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">


                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('insert_bills') ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>



<form action="<?php  echo url .'/'.$this->folder ?>/index" method="post">



    <div class="row x_report">


        <div class="col-auto">
            <label class="mr-sm-2"  for="bbb">رقم الفاتورة</label>
            <input type="text" name="bill"  id="bbb"  class="form-control"  placeholder="رقم الفاتورة" required>
        </div>

        <div class="col-auto">
            <label class="mr-sm-2" for="aaa">مبلغ الفاتورة</label>
            <input type="number" name="amount"  id="aaa"  class="form-control"  placeholder="مبلغ الفاتورة" required>
        </div>

        <div class="col-auto align-self-end x_btn_save"  >
            <input  name="submit"  style="margin: 0 !important;" value="حفظ" type="submit" class="btn btn-warning mb-2">
        </div>

    </div>

    <hr>

</form>



<form action="<?php  echo url .'/'.$this->folder ?>/index" method="get">
    <div class="row align-items-center x_report" >


        <div class="col-auto">
         من تاريخ
        </div>

        <div class="col-auto">

            <input  name="fromdate" type="date" value="<?php  echo $fromtime?>" class="form-control" required>

        </div>
        <div class="col-auto">
            الى تاريخ
        </div>

        <div class="col-auto">
            <input  name="todate" type="date" value="<?php  echo $totime?>" class="form-control" required>
        </div>

        <div class="col-auto x_btn_save"  >
            <input type="submit" name="submit" value="بحث" class="btn btn-success">
            <a  href="<?php  echo url .'/'.$this->folder ?>/index"  class="btn btn-primary"> <i class="fa fa-refresh"></i> </a>
        </div>

    </div>

</form>
<hr>
<style>
    .x_report .col-auto
    {
        margin: 15px 0;
    }

    @media (max-width: 460px) {
        .x_btn_save
        {
            width: 100%;
            text-align: center;
        }
    }
</style>





<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing/<?php  echo $fromtime_stamp .'/'.$totime_stamp ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[5]);
            },
            "order": [[ 3, 'desc'] ],
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
            ,
            <?php  if ($this->permit('export_excel',$this->folder)) { ?>
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


<div class="row">
    <div class="col">

        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th>  رقم الفاتورة  </th>
                <th>  مبلغ الفاتورة   </th>
                <th>   مدخل الفاتورة  </th>
                <th>   تاريخ ادخال الفاتورة  </th>
                <th><?php  echo $this->langControl('delete') ?></th>
            </tr>
            </thead>

        </table>

    </div>
</div>


<hr>

<?php  if ($this->permit('view_total_amount','bills')) {  ?>

<div class="row">
    <div class="col-lg-6 col-md-8 col-sm-12">
        <div class="alert alert-warning" role="alert">
         <div class="row justify-content-between">
             <div class="col-auto">
                 <strong> اجمالي الفواتير </strong>
             </div>

             <div class="col-auto">
                 <strong>  <?php  echo number_format($total)?>  د.ع  </strong>
             </div>

         </div>
        </div>
    </div>
</div>

<?php }  ?>



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
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_bill/"+id, function( e ) {
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


