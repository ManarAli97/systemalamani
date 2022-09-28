




<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_code_not_upload/<?php   echo  $model .'/'. $from_date_stm .'/'.$to_date_stm  ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[8]);
            },
            "order": [[ 0, 'desc'] ],
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



    <br>

    <div class="row">
        <div class="col">
            <span></span>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_excel"><?php  echo $this->langControl('excel') ?> </a></li>
                    <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl($model) ?>  </li>
                    <li class="breadcrumb-item active" aria-current="page" >  مواد غير مرفوعة  </li>
                </ol>
            </nav>


            <hr>
        </div>
    </div>


<form action="<?php echo url.'/'.$this->folder?>/code_not_upload/<?php echo  $model ?>" method="get">



    <div class="row justify-content-between">
        <div class="col-auto">
            <div class="row align-items-end">
                <div class="col-auto">
                    من تاريخ
                    <input type="date" name="date" class="form-control" value="<?php  echo $date ?>"  required>
                </div>
                <div class="col-auto">
                    الى تاريخ
                    <input type="date" name="todate" class="form-control" value="<?php  echo $todate ?>"  required>
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-warning" >بحث</button>
                    <a href="<?php echo url.'/'.$this->folder?>/code_not_upload/<?php echo  $model ?>" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
                </div>
            </div>



        </div>

        <div class="col-auto">
            <button     onclick='delete_not_upload_code()' type='button' class="btn btn-danger" >  حذف الكل  </button>
        </div>


    </div>



    <script>
        function delete_not_upload_code() {

            if(confirm('هل انت متأكد ؟'))
            {

                $.get("<?php echo url .'/'.$this->folder ?>/delete_not_upload_code/<?php echo $model ?>", function(data){
                    if (data)
                    {
                        window.location=''

                    }else
                    {
                        alert('فشل الحذف')
                    }

                })

            }return false;

        }
    </script>




</form>

<br>



<hr>
    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th> القسم </th>
                    <th> الرمز </th>
                    <th> الكمية  </th>
                    <th>  سعر بالدولار  </th>
                    <th>  تاريخ الرفع </th>
                </tr>
                </thead>

            </table>

        </div>
    </div>




<br>
<br>

<br>
<br>


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




